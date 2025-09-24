<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movimentacao;
use App\Models\Produto;
use App\Models\Estoque;

class MovimentacaoController extends Controller
{
    public function index()
    {
        $usuario = \App\Models\modelUsuario::find(session('user_id'));
        $movimentacoes = Movimentacao::with('produto')
            ->orderBy('data_solicitacao', 'desc')
            ->orderBy('id_movimentacao', 'desc')
            ->get();
        $produtos = Produto::all();
        return view('movimentacao', compact('usuario', 'movimentacoes', 'produtos'));
    }

    public function create()
    {
        $produtos = Produto::all();
        return view('movimentacao_create', compact('produtos'));
    }

    public function store(Request $request)
    {

        try {
            $validated = $request->validate([
                'id_produto' => 'required|exists:produtos,id_produto',
                'tipo_movimentacao' => 'required|in:ENTRADA,SAIDA',
                'quantidade' => 'required|integer|min:1',
                'data_solicitacao' => 'required|date',
                'retirada_por' => 'required|integer|exists:usuarios,id',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'message' => 'Erro de validação',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }

        $mov = Movimentacao::create($request->only(['id_produto','tipo_movimentacao','quantidade','data_solicitacao','retirada_por']));

        // Atualiza estoque
        $estoque = Estoque::where('id_produto', $request->id_produto)->first();
        if ($estoque) {
            if ($request->tipo_movimentacao === 'ENTRADA') {
                $estoque->quantidade += $request->quantidade;
            } else {
                $estoque->quantidade -= $request->quantidade;
                if ($estoque->quantidade < 0) $estoque->quantidade = 0;
            }
            $estoque->save();
        }
        // Log de movimentação
        \App\Models\Log::create([
            'id_usuario' => session('user_id'),
            'acao' => 'movimentou_estoque',
            'detalhes' => 'Movimentação: ' . $request->tipo_movimentacao . ' | Produto ID: ' . $request->id_produto . ' | Quantidade: ' . $request->quantidade,
            'ip' => request()->ip(),
        ]);
        if ($request->ajax() || $request->expectsJson()) {
            $mov = Movimentacao::with('produto')->find($mov->id_movimentacao);
            return response()->json([
                'success' => true,
                'movimentacao' => $mov
            ]);
        }
        return redirect()->route('movimentacao.index');
    }
    public function destroy($id)
    {
        $mov = Movimentacao::findOrFail($id);
        $usuarioLogado = session('user_id');
        // Atualiza estoque ao remover movimentação
        $estoque = Estoque::where('id_produto', $mov->id_produto)->first();
        if ($estoque) {
            if ($mov->tipo_movimentacao === 'ENTRADA') {
                $estoque->quantidade -= $mov->quantidade;
                if ($estoque->quantidade < 0) $estoque->quantidade = 0;
            } else {
                $estoque->quantidade += $mov->quantidade;
            }
            $estoque->save();
        }
        $mov->delete();
        // Log exclusão de movimentação
        \App\Models\Log::create([
            'id_usuario' => $usuarioLogado,
            'acao' => 'excluiu_movimentacao',
            'detalhes' => 'Movimentação: ' . $mov->tipo_movimentacao . ' | Produto ID: ' . $mov->id_produto . ' | Quantidade: ' . $mov->quantidade,
            'ip' => request()->ip(),
        ]);
        return response()->json(['success'=>true]);
    }

    // Função para registrar saída rápida
    public function saidaRapida(Request $request)
    {
        $request->validate([
            'id_produto' => 'required|exists:produtos,id_produto',
            'quantidade' => 'required|integer|min:1',
        ]);
        $mov = Movimentacao::create([
            'id_produto' => $request->id_produto,
            'tipo_movimentacao' => 'SAIDA',
            'quantidade' => $request->quantidade,
            'data_solicitacao' => now()->toDateString(),
            'retirada_por' => $request->retirada_por ?? null,
        ]);
        // Log saída rápida
        \App\Models\Log::create([
            'id_usuario' => session('user_id'),
            'acao' => 'saida_rapida',
            'detalhes' => 'Saída rápida | Produto ID: ' . $request->id_produto . ' | Quantidade: ' . $request->quantidade,
            'ip' => request()->ip(),
        ]);
        $estoque = Estoque::where('id_produto', $request->id_produto)->first();
        if ($estoque) {
            $estoque->quantidade -= $request->quantidade;
            if ($estoque->quantidade < 0) $estoque->quantidade = 0;
            $estoque->save();
        }
        return response()->json(['success'=>true]);
    }
}
