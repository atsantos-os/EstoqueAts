<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link rel="stylesheet" href="{{ asset('css/clientes.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    @include('components.header')
    @include('components.sidebar')
    <main class="main-content cliente-main-padded">
        <section class="section-container cliente-container">
            <div class="cliente-header">
                <h2>Clientes</h2>
                <button id="btnNovoCliente" class="btn-novo-cliente"><i class="fa-solid fa-plus"></i> Novo Cliente</button>
            </div>
            <div class="table-responsive">
                <table class="cliente-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>CNPJ</th>
                            <th>Razão Social</th>
                            <th>Nome Fantasia</th>
                            <th>Contrato</th>
                            <th>Supervisor</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clientes as $c)
                        <tr>
                            <td>{{ $c->id_cliente }}</td>
                            <td>{{ $c->cnpj }}</td>
                            <td>{{ $c->razao_social }}</td>
                            <td>{{ $c->nome_fantasia }}</td>
                            <td>{{ $c->contrato }}</td>
                            <td>{{ $c->supervisor }}</td>
                            <td>
                                <button type="button" class="btn-acao btn-editar" title="Editar Cliente" onclick="abrirModalEditarCliente({{ $c->id_cliente }}, '{{ addslashes($c->cnpj) }}', '{{ addslashes($c->razao_social) }}', '{{ addslashes($c->nome_fantasia) }}', '{{ addslashes($c->contrato) }}', '{{ addslashes($c->supervisor) }}')">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <form method="POST" action="{{ route('clientes.destroy', $c->id_cliente) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-acao btn-excluir" title="Excluir Cliente" onclick="return confirm('Tem certeza que deseja excluir este cliente?')">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    <!-- Modal Novo Cliente -->
    <div id="modalNovoCliente" class="cliente-modal">
        <div class="modal-content">
            <span class="close-modal" id="closeModalNovoCliente">&times;</span>
            <h3>Cadastrar Cliente</h3>
            <form method="POST" action="{{ route('clientes.store') }}" id="formNovoCliente">
                @csrf
                <input type="text" name="cnpj" id="cnpjNovo" placeholder="CNPJ" maxlength="18" required>
                <input type="text" name="razao_social" placeholder="Razão Social" maxlength="255" required>
                <input type="text" name="nome_fantasia" placeholder="Nome Fantasia" maxlength="255">
                <input type="text" name="contrato" placeholder="Contrato" maxlength="100">
                <input type="text" name="supervisor" placeholder="Supervisor" maxlength="100">
                <button type="submit">Cadastrar</button>
            </form>
            <div id="novoClienteMsg" class="novo-cliente-msg"></div>
        </div>
    </div>
    <!-- Modal Editar Cliente -->
    <div id="modalEditarCliente" class="cliente-modal">
        <div class="modal-content modal-editar-content">
            <span class="close-modal" id="closeModalEditarCliente">&times;</span>
            <h3>Editar Cliente</h3>
            <form method="POST" id="formEditarCliente">
                @csrf
                <input type="hidden" name="id_cliente" id="editIdCliente">
                <input type="text" name="cnpj" id="editCnpj" placeholder="CNPJ" maxlength="18" required>
                <input type="text" name="razao_social" id="editRazaoSocial" placeholder="Razão Social" maxlength="255" required>
                <input type="text" name="nome_fantasia" id="editNomeFantasia" placeholder="Nome Fantasia" maxlength="255">
                <input type="text" name="contrato" id="editContrato" placeholder="Contrato" maxlength="100">
                <input type="text" name="supervisor" id="editSupervisor" placeholder="Supervisor" maxlength="100">
                <button type="submit" class="btn-salvar-editar">Salvar Alterações</button>
            </form>
            <div id="editarClienteMsg" class="novo-cliente-msg"></div>
        </div>
    </div>
    <script>
        // Modal Novo Cliente
        const btnNovoCliente = document.getElementById('btnNovoCliente');
        const modalNovoCliente = document.getElementById('modalNovoCliente');
        const closeModalNovoCliente = document.getElementById('closeModalNovoCliente');
        btnNovoCliente.onclick = () => modalNovoCliente.style.display = 'flex';
        closeModalNovoCliente.onclick = () => modalNovoCliente.style.display = 'none';
        // Modal Editar Cliente
        const modalEditarCliente = document.getElementById('modalEditarCliente');
        const closeModalEditarCliente = document.getElementById('closeModalEditarCliente');
        closeModalEditarCliente.onclick = () => modalEditarCliente.style.display = 'none';
        window.onclick = e => {
            if(e.target === modalNovoCliente) modalNovoCliente.style.display = 'none';
            if(e.target === modalEditarCliente) modalEditarCliente.style.display = 'none';
        }
        function abrirModalEditarCliente(id, cnpj, razao_social, nome_fantasia, contrato, supervisor) {
            document.getElementById('editIdCliente').value = id;
            document.getElementById('editCnpj').value = cnpj;
            document.getElementById('editRazaoSocial').value = razao_social;
            document.getElementById('editNomeFantasia').value = nome_fantasia;
            document.getElementById('editContrato').value = contrato;
            document.getElementById('editSupervisor').value = supervisor;
            modalEditarCliente.style.display = 'flex';
        }
        document.getElementById('formEditarCliente').onsubmit = function(e) {
            e.preventDefault();
            const id = document.getElementById('editIdCliente').value;
            const cnpj = document.getElementById('editCnpj').value;
            const razao_social = document.getElementById('editRazaoSocial').value;
            const nome_fantasia = document.getElementById('editNomeFantasia').value;
            const contrato = document.getElementById('editContrato').value;
            const supervisor = document.getElementById('editSupervisor').value;
            const msg = document.getElementById('editarClienteMsg');
            msg.innerHTML = '';
            fetch(`/clientes/editar/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ cnpj, razao_social, nome_fantasia, contrato, supervisor })
            }).then(async resp => {
                if (resp.ok) {
                    window.location.reload();
                } else {
                    const result = await resp.json();
                    msg.innerHTML = '<span style="color:#e74c3c;">' + (result.message || 'Erro ao editar cliente') + '</span>';
                }
            }).catch(() => {
                msg.innerHTML = '<span style="color:#e74c3c;">Erro ao editar cliente</span>';
            });
        };
        // Máscara CNPJ
        document.getElementById('cnpjNovo').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{2})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1/$2');
            value = value.replace(/(\d{4})(\d{1,2})$/, '$1-$2');
            e.target.value = value;
        });
    </script>
</body>
</html>
