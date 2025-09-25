


<?php


use App\Http\Controllers\ControllerUsuario;
use App\Models\modelUsuario;
use App\Models\Categoria;
use App\Models\Fornecedor;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\MovimentacaoController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\MaquinarioController;

// ROTAS DE FORNECEDORES (baseadas nas de usuários)


use App\Models\Maquinario;

// Cadastrar maquinário (apenas admin)
Route::post('/maquinarios/store', function (\Illuminate\Http\Request $request) {
    if (!session()->has('user_id')) {
        return redirect()->route('login');
    }
    $usuario = App\Models\modelUsuario::find(session('user_id'));
    if (!$usuario || !$usuario->is_admin) {
        abort(403, 'Acesso não autorizado');
    }
    $validated = $request->validate([
        'maquina' => 'required|max:100',
        'marca' => 'required|max:50',
        'modelo' => 'required|max:50',
        'id_fornecedor' => 'nullable|exists:fornecedores,id_fornecedor',
        'id_cliente' => 'nullable|exists:clientes,id_cliente',
        'supervisor' => 'required',
        'cor' => 'nullable|max:30',
        'patrimonio' => 'required|max:50|unique:maquinarios,patrimonio',
        'valor' => 'nullable|numeric',
        'contrato' => 'nullable|max:50',
        'local' => 'nullable|max:100',
        'volts' => 'nullable|max:20',
        'conferencia' => 'nullable|max:100',
        'observacao' => 'nullable',
        'data_saida' => 'nullable|date',
    ]);
    App\Models\Maquinario::create($validated);
    return redirect()->route('maquinarios.index')->with('success', 'Maquinário cadastrado com sucesso!');
})->name('maquinarios.store');

// Editar maquinário (apenas admin)
Route::post('/maquinarios/editar/{id}', function (\Illuminate\Http\Request $request, $id) {
    if (!session()->has('user_id')) {
        return redirect()->route('login');
    }
    $usuario = App\Models\modelUsuario::find(session('user_id'));
    if (!$usuario || !$usuario->is_admin) {
        abort(403, 'Acesso não autorizado');
    }
    $maquinario = App\Models\Maquinario::findOrFail($id);
    $validated = $request->validate([
        'maquina' => 'required|max:100',
        'marca' => 'required|max:50',
        'modelo' => 'required|max:50',
        'id_fornecedor' => 'nullable|exists:fornecedores,id_fornecedor',
        'id_cliente' => 'nullable|exists:clientes,id_cliente',
        'supervisor' => 'required',
        'cor' => 'nullable|max:30',
        'patrimonio' => 'required|max:50|unique:maquinarios,patrimonio,' . $id . ',id_maquinario',
        'valor' => 'nullable|numeric',
        'contrato' => 'nullable|max:50',
        'local' => 'nullable|max:100',
        'volts' => 'nullable|max:20',
        'conferencia' => 'nullable|max:100',
        'observacao' => 'nullable',
        'data_saida' => 'nullable|date',
    ]);
    $maquinario->update($validated);
    return response()->json(['success' => true]);
})->name('maquinarios.editar');

// Excluir maquinário (apenas admin)
Route::delete('/maquinarios/destroy/{id}', function ($id) {
    if (!session()->has('user_id')) {
        return redirect()->route('login');
    }
    $usuario = App\Models\modelUsuario::find(session('user_id'));
    if (!$usuario || !$usuario->is_admin) {
        abort(403, 'Acesso não autorizado');
    }
    $maquinario = App\Models\Maquinario::findOrFail($id);
    $maquinario->delete();
    return redirect()->route('maquinarios.index')->with('success', 'Maquinário excluído com sucesso!');
})->name('maquinarios.destroy');


// ROTA DE MAQUINARIOS (apenas admin)
Route::get('/maquinarios', function () {
    if (!session()->has('user_id')) {
        return redirect()->route('login');
    }
    $usuario = App\Models\modelUsuario::find(session('user_id'));
    if (!$usuario || !$usuario->is_admin) {
        abort(403, 'Acesso não autorizado');
    }
    $maquinarios = Maquinario::with(['fornecedor', 'cliente'])->get();
    return view('maquinarios', compact('usuario', 'maquinarios'));
})->name('maquinarios.index');
// ROTAS DE CATEGORIAS (apenas admin)

Route::get('/categorias', function () {
    if (!session()->has('user_id')) {
        return redirect()->route('login');
    }
    $usuario = App\Models\modelUsuario::find(session('user_id'));
    if (!$usuario || !$usuario->is_admin) {
        abort(403, 'Acesso não autorizado');
    }
    $categorias = Categoria::all();
    return view('categorias', compact('usuario', 'categorias'));
})->name('categorias');

Route::post('/categoria/store', function (\Illuminate\Http\Request $request) {
    if (!session()->has('user_id')) {
        return redirect()->route('login');
    }
    $usuario = App\Models\modelUsuario::find(session('user_id'));
    if (!$usuario || !$usuario->is_admin) {
        abort(403, 'Acesso não autorizado');
    }
    $validated = $request->validate([
        'nome_categoria' => 'required|max:255|unique:categorias,nome_categoria',
    ]);
    Categoria::create($validated);
    return redirect()->route('categorias')->with('success', 'Categoria criada com sucesso!');
})->name('categoria.store');

Route::post('/categoria/editar/{id}', function (\Illuminate\Http\Request $request, $id) {
    if (!session()->has('user_id')) {
        return redirect()->route('login');
    }
    $usuario = App\Models\modelUsuario::find(session('user_id'));
    if (!$usuario || !$usuario->is_admin) {
        abort(403, 'Acesso não autorizado');
    }
    $categoria = Categoria::findOrFail($id);
    $validated = $request->validate([
        'nome_categoria' => 'required|max:255|unique:categorias,nome_categoria,' . $id . ',id_categoria',
    ]);
    $categoria->update($validated);
    return response()->json(['success' => true]);
})->name('categoria.editar');

Route::delete('/categoria/destroy/{id}', function ($id) {
    if (!session()->has('user_id')) {
        return redirect()->route('login');
    }
    $usuario = App\Models\modelUsuario::find(session('user_id'));
    if (!$usuario || !$usuario->is_admin) {
        abort(403, 'Acesso não autorizado');
    }
    $categoria = Categoria::findOrFail($id);
    $categoria->delete();
    return redirect()->route('categorias')->with('success', 'Categoria excluída com sucesso!');
})->name('categoria.destroy');


// Listar fornecedores (apenas admin)
Route::get('/fornecedores', function () {
    if (!session()->has('user_id')) {
        return redirect()->route('login');
    }
    $usuario = App\Models\modelUsuario::find(session('user_id'));
    if (!$usuario || !$usuario->is_admin) {
        abort(403, 'Acesso não autorizado');
    }
    $fornecedores = Fornecedor::all();
    $categorias = App\Models\Categoria::all();
    return view('fornecedores', compact('usuario', 'fornecedores', 'categorias'));
})->name('fornecedores');

// Cadastrar fornecedor (apenas admin)
Route::post('/fornecedor/store', function (\Illuminate\Http\Request $request) {
    if (!session()->has('user_id')) {
        return redirect()->route('login');
    }
    $usuario = App\Models\modelUsuario::find(session('user_id'));
    if (!$usuario || !$usuario->is_admin) {
        abort(403, 'Acesso não autorizado');
    }
    $validated = $request->validate([
        'nome_fantasia' => 'required|max:255|unique:fornecedores,nome_fantasia',
        'cnpj' => 'nullable|max:20|unique:fornecedores,cnpj',
        'razao_social' => 'nullable|max:255',
        'email' => 'nullable|max:100',
        'telefone' => 'nullable|max:20',
        'categoria_fornecedor' => 'nullable|max:100',
        'responsavel' => 'nullable|max:100',
    ]);
    Fornecedor::create($validated);
    return redirect()->route('fornecedores')->with('success', 'Fornecedor criado com sucesso!');
})->name('fornecedor.store');

// Editar fornecedor (apenas admin)
Route::post('/fornecedor/editar/{id_fornecedor}', function (\Illuminate\Http\Request $request, $id_fornecedor) {
    if (!session()->has('user_id')) {
        return redirect()->route('login');
    }
    $usuario = App\Models\modelUsuario::find(session('user_id'));
    if (!$usuario || !$usuario->is_admin) {
        abort(403, 'Acesso não autorizado');
    }
    $fornecedor = Fornecedor::findOrFail($id_fornecedor);
    $validated = $request->validate([
        'nome_fantasia' => 'required|max:255|unique:fornecedores,nome_fantasia,' . $id_fornecedor . ',id_fornecedor',
        'cnpj' => 'nullable|max:20|unique:fornecedores,cnpj,' . $id_fornecedor . ',id_fornecedor',
        'razao_social' => 'nullable|max:255',
        'email' => 'nullable|max:100',
        'telefone' => 'nullable|max:20',
        'categoria_fornecedor' => 'nullable|max:100',
        'responsavel' => 'nullable|max:100',
    ]);
    $fornecedor->update($validated);
    return response()->json(['success' => true]);
})->name('fornecedor.editar');

// Inativar usuário (apenas admin)
// Alternar ativação/inativação do usuário (apenas admin)
Route::post('/usuario/toggle-ativo/{id}', function ($id) {
    if (!session()->has('user_id')) {
        return redirect()->route('login');
    }
    $usuario = App\Models\modelUsuario::find(session('user_id'));
    if (!$usuario || !$usuario->is_admin) {
        abort(403, 'Acesso não autorizado');
    }
    $user = App\Models\modelUsuario::findOrFail($id);
    $user->ativo = !$user->ativo;
    $user->save();
    $msg = $user->ativo ? 'Usuário ativado com sucesso!' : 'Usuário inativado com sucesso!';
    return redirect()->route('usuarios')->with('success', $msg);
})->name('usuario.toggleAtivo');

// Editar usuário (apenas admin)
Route::post('/usuario/editar/{id}', function (\Illuminate\Http\Request $request, $id) {
    if (!session()->has('user_id')) {
        return redirect()->route('login');
    }
    $usuario = App\Models\modelUsuario::find(session('user_id'));
    if (!$usuario || !$usuario->is_admin) {
        abort(403, 'Acesso não autorizado');
    }
    $user = App\Models\modelUsuario::findOrFail($id);
    $validated = $request->validate([
        'nome' => 'required|max:255',
        'cpf' => 'required|max:14|unique:usuarios,cpf,' . $id,
        'is_admin' => 'required|in:0,1',
        'senha' => 'nullable|max:255',
    ]);
    $user->nome = $validated['nome'];
    $user->cpf = $validated['cpf'];
    $user->is_admin = $validated['is_admin'];
    if (!empty($validated['senha'])) {
        $user->senha = \Illuminate\Support\Facades\Hash::make($validated['senha']);
    }
    $user->save();
    return redirect()->route('usuarios')->with('success', 'Informações do usuário atualizadas!');
})->name('usuario.editar');

// Rota de listagem de usuários (apenas admin)
Route::get('/usuarios', function () {
    if (!session()->has('user_id')) {
        return redirect()->route('login');
    }
    $usuario = App\Models\modelUsuario::find(session('user_id'));
    if (!$usuario || !$usuario->is_admin) {
        abort(403, 'Acesso não autorizado');
    }
    $usuarios = App\Models\modelUsuario::all();
    return view('usuarios', compact('usuario', 'usuarios'));
})->name('usuarios');

// Rota para salvar usuário (apenas admin)
Route::post('/usuario/store', function (\Illuminate\Http\Request $request) {
    if (!session()->has('user_id')) {
        return redirect()->route('login');
    }
    $usuario = App\Models\modelUsuario::find(session('user_id'));
    if (!$usuario || !$usuario->is_admin) {
        abort(403, 'Acesso não autorizado');
    }
    $validated = $request->validate([
        'nome' => 'required|max:255',
        'cpf' => 'required|max:14|unique:usuarios,cpf',
        'senha' => 'required|max:255',
        'is_admin' => 'required|in:0,1',
    ]);
    App\Models\modelUsuario::create([
        'nome' => $validated['nome'],
        'cpf' => $validated['cpf'],
        'senha' => \Illuminate\Support\Facades\Hash::make($validated['senha']),
        'is_admin' => $validated['is_admin'],
        'ativo' => true,
    ]);
    return redirect()->route('usuarios')->with('success', 'Usuário criado com sucesso!');
})->name('usuario.store');

Route::post('/produtos/{id}', [ProdutoController::class, 'update'])->name('produtos.update');

Route::get('/produtos/{id}', [ProdutoController::class, 'getProduto'])->name('produtos.get');
Route::get('/relatorio', [RelatorioController::class, 'index'])->name('relatorio');
Route::get('/relatorio/export', [RelatorioController::class, 'export'])->name('relatorio.export');


Route::get('/configuracoes', function (\Illuminate\Http\Request $request) {
    if (!session()->has('user_id')) {
        return redirect()->route('login');
    }
    $usuario = App\Models\modelUsuario::find(session('user_id'));
    $usuarios = App\Models\modelUsuario::all();
    $query = App\Models\Log::with('usuario');
    if ($usuario->is_admin) {
        if ($request->filled('usuario_id')) {
            $query->where('id_usuario', $request->usuario_id);
        }
        if ($request->filled('acao')) {
            $query->where('acao', $request->acao);
        }
        $logs = $query->orderByDesc('created_at')->limit(50)->get();
        $acoes = App\Models\Log::distinct()->pluck('acao');
    } else {
        $logs = $query->where('id_usuario', $usuario->id)->orderByDesc('created_at')->limit(50)->get();
        $acoes = App\Models\Log::where('id_usuario', $usuario->id)->distinct()->pluck('acao');
    }
    return view('configuracoes', compact('usuario', 'logs', 'usuarios', 'acoes'));
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

