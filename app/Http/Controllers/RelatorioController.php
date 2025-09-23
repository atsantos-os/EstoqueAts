<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movimentacao;
use App\Models\Categoria;
use App\Models\Fornecedor;
use App\Models\Produto;
use App\Models\modelUsuario;
use Maatwebsite\Excel\Facades\Excel;

class RelatorioController extends Controller
{
    public function index(Request $request)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login');
        }
        $usuario = modelUsuario::find(session('user_id'));
        $categorias = Categoria::all();
        $fornecedores = Fornecedor::all();

        $query = Movimentacao::with(['produto.categoria', 'produto.fornecedor', 'usuario']);
        if ($request->filled('data_inicio')) {
            $query->where('data_solicitacao', '>=', $request->data_inicio);
        }
        if ($request->filled('data_fim')) {
            $query->where('data_solicitacao', '<=', $request->data_fim);
        }
        if ($request->filled('categoria')) {
            $query->whereHas('produto', function($q) use ($request) {
                $q->where('id_categoria', $request->categoria);
            });
        }
        if ($request->filled('fornecedor')) {
            $query->whereHas('produto', function($q) use ($request) {
                $q->where('id_fornecedor', $request->fornecedor);
            });
        }
        if ($request->filled('tipo')) {
            $query->where('tipo_movimentacao', $request->tipo);
        }
    $movimentacoes = $query->orderByDesc('data_solicitacao')->limit(100)->get();

        // Dados para gráfico
        $labels = [];
        $entradas = [];
        $saidas = [];
        $grouped = $movimentacoes->groupBy(function($item) {
            return date('m/Y', strtotime($item->data_solicitacao));
        });
        foreach ($grouped as $mes => $items) {
            $labels[] = $mes;
            $entradas[] = $items->where('tipo_movimentacao', 'entrada')->sum('quantidade');
            $saidas[] = $items->where('tipo_movimentacao', 'saida')->sum('quantidade');
        }
        $graficoMovimentacoes = [
            'labels' => $labels,
            'entradas' => $entradas,
            'saidas' => $saidas
        ];

        return view('relatorio', compact('usuario', 'categorias', 'fornecedores', 'movimentacoes', 'graficoMovimentacoes'));
    }

    public function export(Request $request)
    {
        $query = Movimentacao::with(['produto.categoria', 'produto.fornecedor', 'usuario']);
        if ($request->filled('data_inicio')) {
            $query->where('data_solicitacao', '>=', $request->data_inicio);
        }
        if ($request->filled('data_fim')) {
            $query->where('data_solicitacao', '<=', $request->data_fim);
        }
        if ($request->filled('categoria')) {
            $query->whereHas('produto', function($q) use ($request) {
                $q->where('id_categoria', $request->categoria);
            });
        }
        if ($request->filled('fornecedor')) {
            $query->whereHas('produto', function($q) use ($request) {
                $q->where('id_fornecedor', $request->fornecedor);
            });
        }
        if ($request->filled('tipo')) {
            $query->where('tipo_movimentacao', $request->tipo);
        }
        $movimentacoes = $query->orderByDesc('data_solicitacao')->limit(100)->get();

        return Excel::download(new \App\Exports\RelatorioExport($movimentacoes), 'relatorio_estoque.xlsx');
    }
}
