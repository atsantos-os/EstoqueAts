<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class ProdutoController extends Controller
{
    public function getProduto($id)
    {
        $produto = \App\Models\Produto::with(['categoria', 'fornecedor', 'estoque'])->find($id);
        if (!$produto) {
            return response()->json(['success' => false, 'message' => 'Produto não encontrado.'], 404);
        }
        $produtoData = $produto->toArray();
        // Estoque já incluso pelo with('estoque')
        return response()->json(['success' => true, 'produto' => $produtoData]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo_produto' => 'required|unique:produtos,codigo_produto',
            'nome_produto' => 'required',
            'descricao_produto' => 'nullable',
            'condicao' => 'required|in:NOVO,USADO',
            'tamanho' => 'nullable',
            'id_categoria' => 'nullable|exists:categorias,id_categoria',
            'id_fornecedor' => 'nullable|exists:fornecedores,id_fornecedor',
            'quantidade_inicial' => 'required|integer|min:0',
        ]);

        // Separa quantidade_inicial dos dados do produto
        $quantidadeInicial = $validated['quantidade_inicial'];
        unset($validated['quantidade_inicial']);

        // Cria o produto
        $produto = Produto::create($validated);

        // Cria o estoque relacionado
        \App\Models\Estoque::create([
            'id_produto' => $produto->id_produto,
            'quantidade' => $quantidadeInicial
        ]);

        // Log de criação de produto
        \App\Models\Log::create([
            'id_usuario' => session('user_id'),
            'acao' => 'criou_produto',
            'detalhes' => 'Produto: ' . $produto->nome_produto,
            'ip' => request()->ip(),
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $produto = Produto::find($id);
        if (!$produto) {
            return response()->json(['success' => false, 'message' => 'Produto não encontrado.'], 404);
        }
        try {
            // Excluir movimentações de estoque relacionadas
            \App\Models\MovimentacaoEstoque::where('id_produto', $id)->delete();
            // Excluir registro de estoque relacionado
            \App\Models\Estoque::where('id_produto', $id)->delete();
            // Excluir o produto
            $nomeProduto = $produto->nome_produto;
            $produto->delete();
            // Log exclusão
            \App\Models\Log::create([
                'id_usuario' => session('user_id'),
                'acao' => 'excluiu_produto',
                'detalhes' => 'Produto: ' . $nomeProduto,
                'ip' => request()->ip(),
            ]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erro ao excluir produto: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'codigo_produto' => 'required',
            'nome_produto' => 'required',
            'descricao_produto' => 'nullable',
            'condicao' => 'required|in:NOVO,USADO',
            'tamanho' => 'nullable',
            'preco_produto' => 'nullable|numeric',
            'id_categoria' => 'nullable|exists:categorias,id_categoria',
            'id_fornecedor' => 'nullable|exists:fornecedores,id_fornecedor',
            'quantidade_inicial' => 'required|integer|min:0',
        ]);
        $produto = \App\Models\Produto::findOrFail($id);
        $produto->update($validated);
        // Atualizar estoque
        $estoque = \App\Models\Estoque::where('id_produto', $id)->first();
        if ($estoque) {
            $estoque->quantidade = $validated['quantidade_inicial'];
            $estoque->save();
        }
        // Log edição
        \App\Models\Log::create([
            'id_usuario' => session('user_id'),
            'acao' => 'editou_produto',
            'detalhes' => 'Produto: ' . $produto->nome_produto,
            'ip' => request()->ip(),
        ]);
        return response()->json(['success' => true]);
    }
}
