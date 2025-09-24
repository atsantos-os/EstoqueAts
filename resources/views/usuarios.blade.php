<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuários</title>
    <link rel="stylesheet" href="{{ asset('css/usuarios.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    @include('components.header')
    @include('components.sidebar')
    <main class="main-content usuario-main-padded">
        <section class="section-container usuario-container">
            <div class="usuario-header">
                <h2>Usuários do Sistema</h2>
                <button id="btnNovoUsuario" class="btn-novo-usuario"><i class="fa-solid fa-plus"></i> Novo Usuário</button>
            </div>
            <div class="table-responsive">
                <table class="usuario-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Tipo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $u)
                        <tr>
                            <td>{{ $u->id }}</td>
                            <td>{{ $u->nome }}</td>
                            <td>{{ $u->cpf }}</td>
                            <td>{{ $u->is_admin ? 'Administrador' : 'Comum' }}</td>
                            <td>
                                <form method="POST" action="{{ route('usuario.toggleAtivo', $u->id) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn-acao btn-inativar" title="{{ $u->ativo ? 'Inativar' : 'Ativar' }} Usuário">
                                        <i class="fa-solid {{ $u->ativo ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                                    </button>
                                </form>
                                <button type="button" class="btn-acao btn-editar" title="Editar Usuário" onclick="abrirModalEditar({{ $u->id }}, '{{ addslashes($u->nome) }}', '{{ $u->cpf }}', {{ $u->is_admin }})">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    <!-- Modal Novo Usuário -->
    <!-- Modal Editar Usuário -->
    <div id="modalEditarUsuario" class="usuario-modal">
        <div class="modal-content modal-editar-content">
            <span class="close-modal" id="closeModalEditarUsuario">&times;</span>
            <h3>Editar Usuário</h3>
            <form method="POST" id="formEditarUsuario">
                @csrf
                <input type="hidden" name="id" id="editId">
                <input type="text" name="nome" id="editNome" placeholder="Nome" maxlength="255" required class="input-editar-usuario">
                <input type="text" name="cpf" id="editCpf" placeholder="CPF" maxlength="14" required class="input-editar-usuario">
                <input type="password" name="senha" id="editSenha" placeholder="Nova Senha" maxlength="255" class="input-editar-usuario">
                <select name="is_admin" id="editIsAdmin" required class="input-editar-usuario">
                    <option value="0">Usuário comum</option>
                    <option value="1">Administrador</option>
                </select>
                <button type="submit" class="btn-salvar-editar">Salvar Alterações</button>
            </form>
            <div id="editarUsuarioMsg" class="novo-usuario-msg"></div>
        </div>
    </div>
    <div id="modalNovoUsuario" class="usuario-modal">
        <div class="modal-content">
            <span class="close-modal" id="closeModalNovoUsuario">&times;</span>
            <h3>Cadastrar Usuário</h3>
            <form method="POST" action="{{ route('usuario.store') }}" id="formNovoUsuario">
                @csrf
                <input type="text" name="nome" placeholder="Nome" maxlength="255" required>
                <input type="text" name="cpf" id="cpfNovo" placeholder="CPF" maxlength="14" required>
                <input type="password" name="senha" placeholder="Senha" maxlength="255" required>
                <select name="is_admin" required>
                    <option value="0">Usuário comum</option>
                    <option value="1">Administrador</option>
                </select>
                <button type="submit">Cadastrar</button>
            </form>
            <div id="novoUsuarioMsg" class="novo-usuario-msg"></div>
        </div>
    </div>
    <script>
        // Modal Editar Usuário
        const modalEditarUsuario = document.getElementById('modalEditarUsuario');
        const closeModalEditarUsuario = document.getElementById('closeModalEditarUsuario');
        closeModalEditarUsuario.onclick = () => modalEditarUsuario.style.display = 'none';
        window.onclick = e => {
            if(e.target === modalNovoUsuario) modalNovoUsuario.style.display = 'none';
            if(e.target === modalEditarUsuario) modalEditarUsuario.style.display = 'none';
        }
        function abrirModalEditar(id, nome, cpf, is_admin) {
            document.getElementById('editId').value = id;
            document.getElementById('editNome').value = nome;
            document.getElementById('editCpf').value = cpf;
            document.getElementById('editIsAdmin').value = is_admin;
            modalEditarUsuario.style.display = 'flex';
        }
        document.getElementById('formEditarUsuario').onsubmit = function(e) {
            e.preventDefault();
            const id = document.getElementById('editId').value;
            const nome = document.getElementById('editNome').value;
            const cpf = document.getElementById('editCpf').value;
            const senha = document.getElementById('editSenha').value;
            const is_admin = document.getElementById('editIsAdmin').value;
            const msg = document.getElementById('editarUsuarioMsg');
            msg.innerHTML = '';
            fetch(`/usuario/editar/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ nome, cpf, senha, is_admin })
            }).then(async resp => {
                if (resp.ok) {
                    window.location.reload();
                } else {
                    const result = await resp.json();
                    msg.innerHTML = '<span style="color:#e74c3c;">' + (result.message || 'Erro ao editar usuário') + '</span>';
                }
            }).catch(() => {
                msg.innerHTML = '<span style="color:#e74c3c;">Erro ao editar usuário</span>';
            });
        };
        // Modal
        const btnNovoUsuario = document.getElementById('btnNovoUsuario');
        const modalNovoUsuario = document.getElementById('modalNovoUsuario');
        const closeModalNovoUsuario = document.getElementById('closeModalNovoUsuario');
        btnNovoUsuario.onclick = () => modalNovoUsuario.style.display = 'flex';
        closeModalNovoUsuario.onclick = () => modalNovoUsuario.style.display = 'none';
        window.onclick = e => { if(e.target === modalNovoUsuario) modalNovoUsuario.style.display = 'none'; }
        // Máscara CPF
        document.getElementById('cpfNovo').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            e.target.value = value;
        });
    </script>
</body>
</html>
