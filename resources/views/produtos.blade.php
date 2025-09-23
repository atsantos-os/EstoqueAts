<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/produtos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <!-- Modal Editar Produto -->
    <div id="modalEditarProduto" class="novo-produto-modal">
        <div class="modal-content">
            <span class="close-modal" id="closeModalEditarProduto">&times;</span>
            <h3>Editar Produto</h3>
            <form id="formEditarProduto">
                <input class="input-novo-prod" type="text" name="codigo_produto" placeholder="Código do Produto" required>
                <input class="input-novo-prod" type="text" name="nome_produto" placeholder="Nome do Produto" required>
                <textarea class="input-novo-prod" name="descricao_produto" placeholder="Descrição" rows="2"></textarea>
                <div class="edit-flex-row">
                    <select class="input-novo-prod" name="condicao" required>
                        <option value="">Condição</option>
                        <option value="NOVO">Novo</option>
                        <option value="USADO">Usado</option>
                    </select>
                    <input class="input-novo-prod" type="text" name="tamanho" placeholder="Tamanho">
                </div>
                <input class="input-novo-prod" type="number" name="preco_produto" placeholder="Preço" step="0.01" min="0">
                <input class="input-novo-prod" type="number" name="quantidade_inicial" placeholder="Quantidade em Estoque" min="0" value="0" required>
                <select class="input-novo-prod" name="id_categoria" required>
                    <option value="">Categoria</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id_categoria }}">{{ $cat->nome_categoria }}</option>
                    @endforeach
                </select>
                <select class="input-novo-prod" name="id_fornecedor" required>
                    <option value="">Fornecedor</option>
                    @foreach($fornecedores as $forn)
                        <option value="{{ $forn->id_fornecedor }}">{{ $forn->nome_fantasia }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn-salvar-editar">Salvar Alterações</button>
            </form>
            <div id="editarProdutoMsg"></div>
        </div>
    </div>

    <!-- Modal Visualizar Produto -->
    <div id="modalVisualizarProduto" class="novo-produto-modal" style="display:none;">
    <div class="modal-content visual-produto-modal-content">
            <button class="close-modal visual-produto-close" id="closeModalVisualizarProduto">&times;</button>
            <div class="visual-produto-header">
                <span class="visual-produto-icon">
                    <i class="fa-solid fa-box-open"></i>
                </span>
                <h3 class="visual-produto-title">Informações do Produto</h3>
            </div>
            <div id="visualizarProdutoInfo" class="visual-produto-info">
                <!-- Conteúdo preenchido via JS -->
            </div>
        </div>
    </div>
    @include('components.header')
    @include('components.sidebar')
    <div class="produtos-main">
        <div class="produtos-container">
            <div class="produtos-header">
                <h2>Produtos</h2>
                <div class="produtos-filtros-row">
                    <input id="pesquisaProduto" type="text" placeholder="Pesquisar produto..." class="produtos-filtro-input">
                    <select id="filtroCategoria" class="produtos-filtro-select">
                        <option value="">Todas as categorias</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id_categoria }}">{{ $cat->nome_categoria }}</option>
                        @endforeach
                    </select>
                    <button id="btnNovoProdutoNovo" class="btn-novo-produto">
                        <i class="fa-solid fa-plus"></i> Novo Produto
                    </button>
                </div>
            </div>
            <div class="tabela-produtos-wrapper">
            <table class="nova-tabela-produtos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Código</th>
                        <th>Produto</th>
                        <th>Categoria</th>
                        <th>Fornecedor</th>
                        <th>Estoque</th>
                        <th>Preço</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody id="tbodyProdutos">
                    @foreach($produtos as $produto)
                    <tr data-nome="{{ strtolower($produto->nome_produto) }}" data-categoria="{{ $produto->id_categoria }}">
                        <td>{{ $produto->id_produto }}</td>
                        <td>{{ $produto->codigo_produto }}</td>
                        <td>{{ $produto->nome_produto }}</td>
                        <td>{{ $produto->categoria->nome_categoria ?? '-' }}</td>
                        <td>{{ $produto->fornecedor->nome_fantasia ?? '-' }}</td>
                        <td>{{ $estoques[$produto->id_produto]->quantidade ?? 0 }}</td>
                        <td>R$ {{ number_format($produto->preco_produto, 2, ',', '.') }}</td>
                        <td>
                            @if(isset($usuario) && $usuario->is_admin)
                                <button title="Editar" class="btn-editar-produto"><i class="fa-solid fa-pen"></i></button>
                                <button title="Excluir" class="btn-excluir-produto"><i class="fa-solid fa-trash"></i></button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
    <!-- Modal Novo Produto -->
        <div id="modalNovoProdutoNovo" class="novo-produto-modal">
        <div class="modal-content novo-produto-modal-content">
            <span class="close-modal novo-produto-close" id="closeModalNovoProdutoNovo">&times;</span>
            <h3 class="novo-produto-title">Cadastrar Novo Produto</h3>
            <form id="formNovoProdutoNovo" class="novo-produto-form">
                <input class="input-novo-prod" type="text" name="codigo_produto" placeholder="Código do Produto" required>
                <input class="input-novo-prod" type="text" name="nome_produto" placeholder="Nome do Produto" required>
                <textarea class="input-novo-prod" name="descricao_produto" placeholder="Descrição" rows="2"></textarea>
                <div class="novo-produto-flex-row">
                    <select class="input-novo-prod novo-produto-flex" name="condicao" required>
                        <option value="">Condição</option>
                        <option value="NOVO">Novo</option>
                        <option value="USADO">Usado</option>
                    </select>
                    <input class="input-novo-prod novo-produto-flex" type="text" name="tamanho" placeholder="Tamanho">
                </div>
                <input class="input-novo-prod" type="number" name="preco_produto" placeholder="Preço" step="0.01" min="0">
                <input class="input-novo-prod" type="number" name="quantidade_inicial" placeholder="Quantidade Inicial em Estoque" min="0" value="0" required>
                <select class="input-novo-prod" name="id_categoria" required>
                    <option value="">Categoria</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id_categoria }}">{{ $cat->nome_categoria }}</option>
                    @endforeach
                </select>
                <select class="input-novo-prod" name="id_fornecedor" required>
                    <option value="">Fornecedor</option>
                    @foreach($fornecedores as $forn)
                        <option value="{{ $forn->id_fornecedor }}">{{ $forn->nome_fantasia }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn-cadastrar-produto">Cadastrar</button>
            </form>
            <div id="novoProdutoMsgNovo" class="novo-produto-msg"></div>
        </div>
    </div>
    <script>
        // Modal Visualizar Produto
        const modalVisualizarProduto = document.getElementById('modalVisualizarProduto');
        const closeModalVisualizarProduto = document.getElementById('closeModalVisualizarProduto');
        const visualizarProdutoInfo = document.getElementById('visualizarProdutoInfo');
        document.querySelectorAll('tbody#tbodyProdutos tr').forEach(tr => {
            tr.addEventListener('click', async function(e) {
                // Evita abrir ao clicar nos botões de ação
                if (e.target.closest('button')) return;
                const id = tr.querySelector('td').textContent.trim();
                try {
                    const resp = await fetch(`/produtos/${id}`);
                    const data = await resp.json();
                    if (!data.success) throw new Error(data.message || 'Erro ao buscar produto');
                    const p = data.produto;
                    visualizarProdutoInfo.innerHTML = `
                        <div class="visual-produto-campos">
                            <div><strong>ID:</strong> ${p.id_produto}</div>
                            <div><strong>Código:</strong> ${p.codigo_produto}</div>
                            <div><strong>Nome:</strong> ${p.nome_produto}</div>
                            <div><strong>Descrição:</strong> ${p.descricao_produto || '-'}</div>
                            <div><strong>Categoria:</strong> ${p.categoria?.nome_categoria || '-'}</div>
                            <div><strong>Fornecedor:</strong> ${p.fornecedor?.nome_fantasia || '-'}</div>
                            <div><strong>Estoque:</strong> ${p.estoque?.quantidade ?? 0}</div>
                            <div><strong>Preço:</strong> R$ ${Number(p.preco_produto).toLocaleString('pt-BR', {minimumFractionDigits:2})}</div>
                            <div><strong>Condição:</strong> ${p.condicao || '-'}</div>
                            <div><strong>Tamanho:</strong> ${p.tamanho || '-'}</div>
                        </div>
                    `;
                    modalVisualizarProduto.style.display = 'flex';
                } catch (err) {
                    alert('Erro ao buscar dados do produto para visualização.');
                }
            });
        });
        closeModalVisualizarProduto.onclick = () => modalVisualizarProduto.style.display = 'none';
        window.addEventListener('click', e => { if(e.target === modalVisualizarProduto) modalVisualizarProduto.style.display = 'none'; });
        // LOG para debug detalhado do fluxo de edição
        function logEditarProduto(msg, ...args) {
            console.log('[EDITAR PRODUTO]', msg, ...args);
        }
        // Modal Editar Produto
        const modalEditarProduto = document.getElementById('modalEditarProduto');
        const closeModalEditarProduto = document.getElementById('closeModalEditarProduto');
        const formEditarProduto = document.getElementById('formEditarProduto');
        let editandoId = null;
        document.querySelectorAll('tbody#tbodyProdutos .fa-pen').forEach(btn => {
            btn.onclick = async function(e) {
                const tr = e.target.closest('tr');
                editandoId = tr.querySelector('td').textContent.trim();
                logEditarProduto('Abrindo modal de edição para ID', editandoId);
                // Busca os dados completos do produto via backend
                try {
                    const resp = await fetch(`/produtos/${editandoId}`);
                    const data = await resp.json();
                    if (!data.success) throw new Error(data.message || 'Erro ao buscar produto');
                    const p = data.produto;
                    formEditarProduto.codigo_produto.value = p.codigo_produto || '';
                    formEditarProduto.nome_produto.value = p.nome_produto || '';
                    formEditarProduto.descricao_produto.value = p.descricao_produto || '';
                    formEditarProduto.condicao.value = p.condicao || '';
                    formEditarProduto.tamanho.value = p.tamanho || '';
                    formEditarProduto.preco_produto.value = p.preco_produto || '';
                    formEditarProduto.quantidade_inicial.value = p.quantidade_inicial || 0;
                    formEditarProduto.id_categoria.value = p.id_categoria || '';
                    formEditarProduto.id_fornecedor.value = p.id_fornecedor || '';
                    logEditarProduto('Dados carregados do backend:', p);
                    modalEditarProduto.style.display = 'flex';
                } catch (err) {
                    logEditarProduto('Erro ao buscar dados do produto:', err);
                    alert('Erro ao buscar dados do produto para edição.');
                }
            }
        });
        closeModalEditarProduto.onclick = () => modalEditarProduto.style.display = 'none';
        window.onclick = e => { if(e.target === modalEditarProduto) modalEditarProduto.style.display = 'none'; }

        formEditarProduto.onsubmit = async function(e) {
            e.preventDefault();
            const form = e.target;
            const data = new FormData(form);
            const msg = document.getElementById('editarProdutoMsg');
            msg.innerHTML = '';
            logEditarProduto('Enviando dados para update:', Object.fromEntries(data.entries()));
            try {
                const resp = await fetch(`/produtos/${editandoId}`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: data
                });
                logEditarProduto('Resposta recebida:', resp);
                if (resp.ok) {
                    msg.innerHTML = '<span style="color:#27ae60;">Produto atualizado com sucesso!</span>';
                    logEditarProduto('Produto atualizado com sucesso!');
                    setTimeout(()=>{modalEditarProduto.style.display = 'none'; location.reload();}, 800);
                } else {
                    const err = await resp.json();
                    logEditarProduto('Erro ao editar produto:', err);
                    msg.innerHTML = '<span style="color:#e74c3c;">' + (err.message || 'Erro ao editar produto') + '</span>';
                }
            } catch (error) {
                logEditarProduto('Erro inesperado:', error);
                msg.innerHTML = '<span style="color:#e74c3c;">Erro ao editar produto</span>';
            }
        };
        // Filtro de pesquisa e categoria
        const pesquisaProduto = document.getElementById('pesquisaProduto');
        const filtroCategoria = document.getElementById('filtroCategoria');
        const tbodyProdutos = document.getElementById('tbodyProdutos');

        // Excluir produto
        tbodyProdutos.onclick = async function(e) {
            if (e.target.closest('.fa-trash')) {
                const tr = e.target.closest('tr');
                const id = tr.querySelector('td').textContent.trim();
                if (confirm('Deseja excluir este produto?')) {
                    try {
                        const resp = await fetch(`/produtos/${id}`, {
                            method: 'DELETE',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                        });
                        if (resp.ok) {
                            const result = await resp.json();
                            if (result.success) {
                                tr.remove();
                            } else {
                                alert('Erro ao excluir produto.');
                            }
                        } else {
                            alert('Erro ao excluir produto.');
                        }
                    } catch (error) {
                        alert('Erro ao excluir produto.');
                    }
                }
            }
        };

        // Modal Novo Produto
        const btnNovoProdutoNovo = document.getElementById('btnNovoProdutoNovo');
        const modalNovoProdutoNovo = document.getElementById('modalNovoProdutoNovo');
        const closeModalNovoProdutoNovo = document.getElementById('closeModalNovoProdutoNovo');
        btnNovoProdutoNovo.onclick = () => modalNovoProdutoNovo.style.display = 'flex';
        closeModalNovoProdutoNovo.onclick = () => modalNovoProdutoNovo.style.display = 'none';
        window.onclick = e => { if(e.target === modalNovoProdutoNovo) modalNovoProdutoNovo.style.display = 'none'; }

        // Formulário AJAX
        document.getElementById('formNovoProdutoNovo').onsubmit = async function(e) {
            e.preventDefault();
            const form = e.target;
            const data = new FormData(form);
            const msg = document.getElementById('novoProdutoMsgNovo');
            msg.innerHTML = '';
            try {
                const resp = await fetch("{{ route('produtos.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: data
                });
                if (resp.ok) {
                    msg.innerHTML = '<span style="color:#27ae60;">Produto cadastrado com sucesso!</span>';
                    form.reset();
                } else {
                    const err = await resp.json();
                    msg.innerHTML = '<span style="color:#e74c3c;">' + (err.message || 'Erro ao cadastrar produto') + '</span>';
                }
            } catch (error) {
                msg.innerHTML = '<span style="color:#e74c3c;">Erro ao cadastrar produto</span>';
            }
        };

        function filtrarProdutos() {
            const termo = pesquisaProduto.value.trim().toLowerCase();
            const categoria = filtroCategoria.value;
            for (const tr of tbodyProdutos.querySelectorAll('tr')) {
                const nome = tr.getAttribute('data-nome');
                const cat = tr.getAttribute('data-categoria');
                const matchNome = !termo || nome.includes(termo);
                const matchCat = !categoria || cat === categoria;
                tr.style.display = (matchNome && matchCat) ? '' : 'none';
            }
        }
        pesquisaProduto.addEventListener('input', filtrarProdutos);
        filtroCategoria.addEventListener('change', filtrarProdutos);
    </script>
</body>
</html>
