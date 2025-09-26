<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias de Produtos</title>
        <link rel="stylesheet" href="{{ asset('css/categorias.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    
    @include('components.sidebar')
    <main class="main-content">
        <section class="container">
            <div class="categoria-header">
                <h2>Categorias de Produtos</h2>
                @if(isset($usuario) && $usuario->is_admin)
                <button id="btnNovaCategoria" class="btn-nova-categoria"><i class="fa-solid fa-plus"></i> Nova Categoria</button>
                @endif
            </div>
            <div class="table-responsive">
                <table class="categoria-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categorias as $c)
                        <tr>
                            <td>{{ $c->id_categoria }}</td>
                            <td>{{ $c->nome_categoria }}</td>
                            <td>
                                @if(isset($usuario) && $usuario->is_admin)
                                <form method="POST" action="{{ route('categoria.destroy', $c->id_categoria) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-acao btn-inativar" title="Excluir Categoria" onclick="return confirm('Tem certeza que deseja excluir esta categoria?')">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                                <button type="button" class="btn-acao btn-editar" title="Editar Categoria" onclick="abrirModalEditarCategoria({{ $c->id_categoria }}, '{{ addslashes($c->nome_categoria) }}')">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </main>
        <!-- Modal Nova Categoria -->
    <div id="modalNovaCategoria" class="categoria-modal">
            <div class="modal-content">
                <span class="close-modal" id="closeModalNovaCategoria">&times;</span>
                <h3>Cadastrar Categoria</h3>
                <form method="POST" action="{{ route('categoria.store') }}" id="formNovaCategoria">
                    @csrf
                    <input type="text" name="nome_categoria" placeholder="Nome da Categoria" maxlength="255" required>
                    <button type="submit">Cadastrar</button>
                </form>
                    <div id="novaCategoriaMsg" class="novo-categoria-msg"></div>
            </div>
        </div>
        <!-- Modal Editar Categoria -->
    <div id="modalEditarCategoria" class="categoria-modal">
            <div class="modal-content modal-editar-content">
                <span class="close-modal" id="closeModalEditarCategoria">&times;</span>
                <h3>Editar Categoria</h3>
                <form method="POST" id="formEditarCategoria">
                    @csrf
                    <input type="hidden" name="id_categoria" id="editCategoriaId">
                    <input type="text" name="nome_categoria" id="editCategoriaNome" placeholder="Nome da Categoria" maxlength="255" required class="input-editar-usuario">
                    <button type="submit" class="btn-salvar-editar">Salvar Alterações</button>
                </form>
                    <div id="editarCategoriaMsg" class="novo-categoria-msg"></div>
            </div>
        </div>
    <!-- Modal Nova Categoria -->
    <div id="modalNovaCategoria" class="categoria-modal">
        <div class="modal-content">
            <span class="close-modal" id="closeModalNovaCategoria">&times;</span>
            <h3>Cadastrar Categoria</h3>
            <form method="POST" action="{{ route('categoria.store') }}" id="formNovaCategoria">
                @csrf
                <input type="text" name="nome_categoria" placeholder="Nome da Categoria" maxlength="255" required>
                <button type="submit">Cadastrar</button>
            </form>
                <div id="novaCategoriaMsg" class="novo-categoria-msg"></div>
        </div>
    </div>
    <!-- Modal Editar Categoria -->
    <div id="modalEditarCategoria" class="categoria-modal">
        <div class="modal-content modal-editar-content">
            <span class="close-modal" id="closeModalEditarCategoria">&times;</span>
            <h3>Editar Categoria</h3>
            <form method="POST" id="formEditarCategoria">
                @csrf
                <input type="hidden" name="id_categoria" id="editCategoriaId">
                <input type="text" name="nome_categoria" id="editCategoriaNome" placeholder="Nome da Categoria" maxlength="255" required class="input-editar-usuario">
                <button type="submit" class="btn-salvar-editar">Salvar Alterações</button>
            </form>
                <div id="editarCategoriaMsg" class="novo-categoria-msg"></div>
        </div>
    </div>
    <script>
        // Modal Nova Categoria
        const btnNovaCategoria = document.getElementById('btnNovaCategoria');
        const modalNovaCategoria = document.getElementById('modalNovaCategoria');
        const closeModalNovaCategoria = document.getElementById('closeModalNovaCategoria');
        if(btnNovaCategoria) btnNovaCategoria.onclick = () => {
            modalNovaCategoria.style.display = 'flex';
            modalEditarCategoria.style.display = 'none';
        };
        if(closeModalNovaCategoria) closeModalNovaCategoria.onclick = () => modalNovaCategoria.style.display = 'none';
        // Modal Editar Categoria
        const modalEditarCategoria = document.getElementById('modalEditarCategoria');
        const closeModalEditarCategoria = document.getElementById('closeModalEditarCategoria');
    if(closeModalEditarCategoria) closeModalEditarCategoria.onclick = () => modalEditarCategoria.style.display = 'none';
        window.onclick = e => {
            if(e.target === modalNovaCategoria) modalNovaCategoria.style.display = 'none';
            if(e.target === modalEditarCategoria) modalEditarCategoria.style.display = 'none';
        };
        function abrirModalEditarCategoria(id, nome) {
            document.getElementById('editCategoriaId').value = id;
            document.getElementById('editCategoriaNome').value = nome;
            modalEditarCategoria.style.display = 'flex';
            modalNovaCategoria.style.display = 'none';
        }
        document.getElementById('formEditarCategoria').onsubmit = function(e) {
            e.preventDefault();
            const id = document.getElementById('editCategoriaId').value;
            const nome = document.getElementById('editCategoriaNome').value;
            const msg = document.getElementById('editarCategoriaMsg');
            msg.innerHTML = '';
            fetch(`/categoria/editar/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ nome_categoria: nome })
            }).then(async resp => {
                if (resp.ok) {
                    window.location.reload();
                } else {
                    const result = await resp.json();
                    msg.innerHTML = '<span style="color:#e74c3c;">' + (result.message || 'Erro ao editar categoria') + '</span>';
                }
            }).catch(() => {
                msg.innerHTML = '<span style="color:#e74c3c;">Erro ao editar categoria</span>';
            });
        };
    </script>
</body>
</html>
