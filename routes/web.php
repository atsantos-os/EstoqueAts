<?php


use App\Http\Controllers\ControllerUsuario;
use App\Models\modelUsuario;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\MovimentacaoController;
use App\Http\Controllers\RelatorioController;

Route::post('/produtos/{id}', [ProdutoController::class, 'update'])->name('produtos.update');

Route::get('/produtos/{id}', [ProdutoController::class, 'getProduto'])->name('produtos.get');
Route::get('/relatorio', [RelatorioController::class, 'index'])->name('relatorio');
Route::get('/relatorio/export', [RelatorioController::class, 'export'])->name('relatorio.export');


Route::get('/configuracoes', function () {
    if (!session()->has('user_id')) {
        return redirect()->route('login');
    }
    $usuario = App\Models\modelUsuario::find(session('user_id'));
    // Busca logs do próprio usuário (ajuste o nome da tabela/campos conforme seu sistema)
    $logs = DB::table('logs')
        ->where('id_usuario', $usuario->id)
        ->orderByDesc('created_at')
        ->limit(50)
        ->get();
    return view('configuracoes', compact('usuario', 'logs'));
})->name('configuracoes');
Route::get('/produtos', function () {
    if (!session()->has('user_id')) {
        return redirect()->route('login');
    }

    $usuario = App\Models\modelUsuario::find(session('user_id'));

    $produtos = App\Models\Produto::with(['categoria','fornecedor'])
        ->get();
    $estoques = App\Models\Estoque::all()->keyBy('id_produto');
    $categorias = App\Models\Categoria::all();
    $fornecedores = App\Models\Fornecedor::all();

    return view('produtos', compact('usuario', 'produtos', 'estoques', 'categorias', 'fornecedores'));
// Relacionamentos para Produto
\App\Models\Produto::resolveRelationUsing('categoria', function ($produto) {
    return $produto->belongsTo(\App\Models\Categoria::class, 'id_categoria', 'id_categoria');
});
\App\Models\Produto::resolveRelationUsing('fornecedor', function ($produto) {
    return $produto->belongsTo(\App\Models\Fornecedor::class, 'id_fornecedor', 'id_fornecedor');
});
})->name('produtos');

Route::get('/movimentacoes', function () {
    if (!session()->has('user_id')) {
        return redirect()->route('login');
    }

    $usuario = App\Models\modelUsuario::find(session('user_id'));

    // Retorna a view 'movimentacoes' e passa o usuário para ela
    return view('movimentacoes', compact('usuario'));
})->name('movimentacoes');


Route::get('/', [ControllerUsuario::class, 'showLoginForm'])->name('login');
Route::post('/login', [ControllerUsuario::class, 'login']);
Route::post('/logout', [ControllerUsuario::class, 'logout'])->name('logout');
Route::get('/produtos', function () {
    if (!session()->has('user_id')) {
        return redirect()->route('login');
    }
    $usuario = App\Models\modelUsuario::find(session('user_id'));
    $produtos = App\Models\Produto::with(['categoria', 'fornecedor'])->get();
    $categorias = App\Models\Categoria::all();
    $fornecedores = App\Models\Fornecedor::all();
    $estoques = App\Models\Estoque::all()->keyBy('id_produto');
    return view('produtos', compact('usuario', 'produtos', 'categorias', 'fornecedores', 'estoques'));
})->name('produtos');

Route::resource('movimentacao', MovimentacaoController::class)->except(['show', 'edit', 'update']);
Route::post('movimentacao/saida-rapida', [MovimentacaoController::class, 'saidaRapida'])->name('movimentacao.saidaRapida');

Route::get('/dashboard', function () {
    if (!session()->has('user_id')) {
        return redirect()->route('login');
    }

    $usuario = App\Models\modelUsuario::find(session('user_id'));

    // Dashboard: SELECTS
    $totalProdutos = App\Models\Produto::count();
    $produtos = App\Models\Produto::with('estoque')->get();
    $produtosEmBaixa = $produtos->filter(function($produto) {
        $qtdMin = $produto->quantidade_minima ?? 0;
        $qtdEstoque = optional($produto->estoque)->quantidade ?? 0;
        return $qtdEstoque < $qtdMin;
    })->count();
    $movimentacoesHoje = App\Models\MovimentacaoEstoque::whereDate('data_solicitacao', now()->toDateString())->count();
    $movimentacoesRecentes = App\Models\MovimentacaoEstoque::orderBy('data_solicitacao', 'desc')
        ->orderBy('id_movimentacao', 'desc')
        ->limit(5)
        ->get();

    // Gráfico 1: Produtos por Categoria
    $produtosPorCategoria = App\Models\Produto::selectRaw('id_categoria, count(*) as total')
        ->groupBy('id_categoria')
        ->with('categoria')
        ->get();
    $produtosPorCategoriaLabels = $produtosPorCategoria->map(function($p) {
        return optional($p->categoria)->nome_categoria ?? 'Sem Categoria';
    });
    $produtosPorCategoriaData = $produtosPorCategoria->pluck('total');

    // Gráfico 2: Movimentações por Tipo
    $movimentacoesPorTipo = App\Models\MovimentacaoEstoque::selectRaw('tipo_movimentacao, count(*) as total')
        ->groupBy('tipo_movimentacao')
        ->get();
    $movimentacoesPorTipoLabels = $movimentacoesPorTipo->pluck('tipo_movimentacao')->map(function($t) {
        return ucfirst(strtolower($t));
    });
    $movimentacoesPorTipoData = $movimentacoesPorTipo->pluck('total');

    return view('dashboard', compact(
        'usuario',
        'totalProdutos',
        'produtosEmBaixa',
        'movimentacoesHoje',
        'movimentacoesRecentes',
        'produtosPorCategoriaLabels',
        'produtosPorCategoriaData',
        'movimentacoesPorTipoLabels',
        'movimentacoesPorTipoData',
    ));
})->name('dashboard');



Route::post('/produtos', [ProdutoController::class, 'store'])->name('produtos.store');
Route::delete('/produtos/{id}', [ProdutoController::class, 'destroy'])->name('produtos.destroy');

