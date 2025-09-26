<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maquinários</title>
    <link rel="stylesheet" href="{{ asset('css/maquinarios.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    
    @include('components.sidebar')
    <main class="main-content">
        <section class="container">
            <div class="maquinario-header">
                <h2>Maquinários</h2>
                @if(isset($usuario) && $usuario->is_admin)
                <button id="btnNovoMaquinario" class="btn-novo-maquinario"><i class="fa-solid fa-plus"></i> Novo Maquinário</button>
                @endif
            </div>
            <div class="table-responsive">
                <table class="maquinario-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Máquina</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Supervisor</th>
                            <th>Patrimônio</th>
                            <th>Cliente</th>
                            <th>Fornecedor</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($maquinarios as $m)
                        <tr>
                            <td>{{ $m->id_maquinario }}</td>
                            <td>{{ $m->maquina }}</td>
                            <td>{{ $m->marca }}</td>
                            <td>{{ $m->modelo }}</td>
                            <td>{{ $m->supervisor }}</td>
                            <td>{{ $m->patrimonio }}</td>
                            <td>{{ optional($m->cliente)->nome ?? '-' }}</td>
                            <td>{{ optional($m->fornecedor)->nome_fantasia ?? '-' }}</td>
                            <td>
                                @if(isset($usuario) && $usuario->is_admin)
                                <button type="button" class="btn-acao btn-editar" title="Editar Maquinário" onclick="abrirModalEditarMaquinario({{ $m->id_maquinario }}, '{{ addslashes($m->maquina) }}', '{{ addslashes($m->marca) }}', '{{ addslashes($m->modelo) }}', '{{ addslashes($m->supervisor) }}', '{{ addslashes($m->patrimonio) }}', '{{ addslashes(optional($m->cliente)->nome ?? '') }}', '{{ addslashes(optional($m->fornecedor)->nome_fantasia ?? '') }}')">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <form method="POST" action="{{ route('maquinarios.destroy', $m->id_maquinario) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-acao btn-inativar" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir este maquinário?')">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    <!-- Modal Novo Maquinário -->
    @if(isset($usuario) && $usuario->is_admin)
    <div id="modalNovoMaquinario" class="maquinario-modal">
        <div class="modal-content">
            <span class="close-modal" id="closeModalNovoMaquinario">&times;</span>
            <h3>Cadastrar Maquinário</h3>
            <form method="POST" action="{{ route('maquinarios.store') }}" id="formNovoMaquinario">
                @csrf
                <input type="text" name="maquina" placeholder="Nome da Máquina" maxlength="255" required>
                <input type="text" name="marca" placeholder="Marca" maxlength="255">
                <input type="text" name="modelo" placeholder="Modelo" maxlength="255">
                <input type="text" name="supervisor" placeholder="Supervisor" maxlength="255">
                <input type="text" name="patrimonio" placeholder="Patrimônio" maxlength="255">
                <!-- Cliente e Fornecedor podem ser selects se necessário -->
                <button type="submit">Cadastrar</button>
            </form>
            <div id="novoMaquinarioMsg" class="novo-maquinario-msg"></div>
        </div>
    </div>
    <!-- Modal Editar Maquinário -->
    <div id="modalEditarMaquinario" class="maquinario-modal">
        <div class="modal-content modal-editar-content">
            <span class="close-modal" id="closeModalEditarMaquinario">&times;</span>
            <h3>Editar Maquinário</h3>
            <form method="POST" id="formEditarMaquinario">
                @csrf
                <input type="hidden" name="id_maquinario" id="editMaquinarioId">
                <input type="text" name="maquina" id="editMaquina" placeholder="Nome da Máquina" maxlength="255" required>
                <input type="text" name="marca" id="editMarca" placeholder="Marca" maxlength="255">
                <input type="text" name="modelo" id="editModelo" placeholder="Modelo" maxlength="255">
                <input type="text" name="supervisor" id="editSupervisor" placeholder="Supervisor" maxlength="255">
                <input type="text" name="patrimonio" id="editPatrimonio" placeholder="Patrimônio" maxlength="255">
                <!-- Cliente e Fornecedor podem ser setados aqui se forem selects -->
                <button type="submit" class="btn-salvar-editar">Salvar Alterações</button>
            </form>
            <div id="editarMaquinarioMsg" class="novo-maquinario-msg"></div>
        </div>
    </div>
    @endif
    @if(isset($usuario) && $usuario->is_admin)
    <script>
        // Modal Novo Maquinario
        const btnNovoMaquinario = document.getElementById('btnNovoMaquinario');
        const modalNovoMaquinario = document.getElementById('modalNovoMaquinario');
        const closeModalNovoMaquinario = document.getElementById('closeModalNovoMaquinario');
        if(btnNovoMaquinario) btnNovoMaquinario.onclick = () => {
            modalNovoMaquinario.style.display = 'flex';
            modalEditarMaquinario.style.display = 'none';
        };
        if(closeModalNovoMaquinario) closeModalNovoMaquinario.onclick = () => modalNovoMaquinario.style.display = 'none';
        // Modal Editar Maquinario
        const modalEditarMaquinario = document.getElementById('modalEditarMaquinario');
        const closeModalEditarMaquinario = document.getElementById('closeModalEditarMaquinario');
        if(closeModalEditarMaquinario) closeModalEditarMaquinario.onclick = () => modalEditarMaquinario.style.display = 'none';
        window.onclick = e => {
            if(e.target === modalNovoMaquinario) modalNovoMaquinario.style.display = 'none';
            if(e.target === modalEditarMaquinario) modalEditarMaquinario.style.display = 'none';
        };
        function abrirModalEditarMaquinario(id, maquina, marca, modelo, supervisor, patrimonio, cliente, fornecedor) {
            document.getElementById('editMaquinarioId').value = id;
            document.getElementById('editMaquina').value = maquina;
            document.getElementById('editMarca').value = marca;
            document.getElementById('editModelo').value = modelo;
            document.getElementById('editSupervisor').value = supervisor;
            document.getElementById('editPatrimonio').value = patrimonio;
            // Cliente e Fornecedor podem ser setados aqui se forem selects
            modalEditarMaquinario.style.display = 'flex';
            modalNovoMaquinario.style.display = 'none';
        }
        document.getElementById('formEditarMaquinario').onsubmit = function(e) {
            e.preventDefault();
            const id = document.getElementById('editMaquinarioId').value;
            const maquina = document.getElementById('editMaquina').value;
            const marca = document.getElementById('editMarca').value;
            const modelo = document.getElementById('editModelo').value;
            const supervisor = document.getElementById('editSupervisor').value;
            const patrimonio = document.getElementById('editPatrimonio').value;
            const msg = document.getElementById('editarMaquinarioMsg');
            msg.innerHTML = '';
            fetch(`/maquinarios/editar/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ maquina, marca, modelo, supervisor, patrimonio })
            }).then(async resp => {
                if (resp.ok) {
                    window.location.reload();
                } else {
                    const result = await resp.json();
                    msg.innerHTML = '<span style="color:#e74c3c;">' + (result.message || 'Erro ao editar maquinário') + '</span>';
                }
            }).catch(() => {
                msg.innerHTML = '<span style="color:#e74c3c;">Erro ao editar maquinário</span>';
            });
        };
    </script>
    @endif
</body>
</html>
