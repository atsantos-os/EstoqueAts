<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fornecedores</title>
    <link rel="stylesheet" href="{{ asset('css/fornecedores.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    @include('components.header')
    @include('components.sidebar')
    <main class="main-content usuario-main-padded">
        <section class="section-container usuario-container">
            <div class="usuario-header">
                <h2>Fornecedores</h2>
                <button id="btnNovoFornecedor" class="btn-novo-usuario"><i class="fa-solid fa-plus"></i> Novo Fornecedor</button>
            </div>
            <div class="table-responsive">
                <table class="usuario-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome Fantasia</th>
                            <th>CNPJ</th>
                            <th>Razão Social</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Categoria</th>
                            <th>Responsável</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($fornecedores as $f)
                        <tr>
                            <td>{{ $f->id_fornecedor }}</td>
                            <td>{{ $f->nome_fantasia }}</td>
                            <td>{{ $f->cnpj }}</td>
                            <td>{{ $f->razao_social }}</td>
                            <td>{{ $f->email }}</td>
                            <td>{{ $f->telefone }}</td>
                            <td>{{ $f->categoria_fornecedor }}</td>
                            <td>{{ $f->responsavel }}</td>
                            <td>
                                <button type="button" class="btn-acao btn-editar" title="Editar Fornecedor" onclick="abrirModalEditarFornecedor({{ $f->id_fornecedor }}, '{{ addslashes($f->nome_fantasia) }}', '{{ $f->cnpj }}', '{{ addslashes($f->razao_social) }}', '{{ addslashes($f->email) }}', '{{ addslashes($f->telefone) }}', '{{ addslashes($f->categoria_fornecedor) }}', '{{ addslashes($f->responsavel) }}')">
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
    <!-- Modal Editar Fornecedor -->
    <div id="modalEditarFornecedor" class="usuario-modal">
        <div class="modal-content modal-editar-content">
            <span class="close-modal" id="closeModalEditarFornecedor">&times;</span>
            <h3>Editar Fornecedor</h3>
            <form method="POST" id="formEditarFornecedor">
                @csrf
                <input type="hidden" name="id_fornecedor" id="editIdFornecedor">
                <input type="text" name="nome_fantasia" id="editNomeFantasia" placeholder="Nome Fantasia" maxlength="255" required class="input-editar-usuario">
                <input type="text" name="cnpj" id="editCnpj" placeholder="CNPJ" maxlength="20" required class="input-editar-usuario">
                <input type="text" name="razao_social" id="editRazaoSocial" placeholder="Razão Social" maxlength="255" class="input-editar-usuario">
                <input type="email" name="email" id="editEmail" placeholder="Email" maxlength="100" class="input-editar-usuario">
                <input type="text" name="telefone" id="editTelefone" placeholder="Telefone" maxlength="20" class="input-editar-usuario">
                <select name="categoria_fornecedor" id="editCategoriaFornecedor" class="input-editar-usuario">
                    <option value="">Selecione a categoria</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->nome_categoria }}">{{ $cat->nome_categoria }}</option>
                    @endforeach
                </select>
                <input type="text" name="responsavel" id="editResponsavel" placeholder="Responsável" maxlength="100" class="input-editar-usuario">
                <button type="submit" class="btn-salvar-editar">Salvar Alterações</button>
            </form>
            <div id="editarFornecedorMsg" class="novo-usuario-msg"></div>
        </div>
    </div>
    <!-- Modal Novo Fornecedor -->
    <div id="modalNovoFornecedor" class="usuario-modal">
        <div class="modal-content">
            <span class="close-modal" id="closeModalNovoFornecedor">&times;</span>
            <h3>Cadastrar Fornecedor</h3>
            <form method="POST" action="{{ route('fornecedor.store') }}" id="formNovoFornecedor">
                @csrf
                <input type="text" name="nome_fantasia" placeholder="Nome Fantasia" maxlength="255" required>
                <input type="text" name="cnpj" id="cnpjNovo" placeholder="CNPJ" maxlength="20" required>
                <input type="text" name="razao_social" placeholder="Razão Social" maxlength="255">
                <input type="email" name="email" placeholder="Email" maxlength="100">
                <input type="text" name="telefone" placeholder="Telefone" maxlength="20">
                <select name="categoria_fornecedor" id="categoriaNovo" class="input-editar-usuario">
                    <option value="">Selecione a categoria</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->nome_categoria }}">{{ $cat->nome_categoria }}</option>
                    @endforeach
                </select>
                <input type="text" name="responsavel" placeholder="Responsável" maxlength="100">
                <button type="submit">Cadastrar</button>
            </form>
            <div id="novoFornecedorMsg" class="novo-usuario-msg"></div>
        </div>
    </div>
    <script>
        // Modal Editar Fornecedor
        const modalEditarFornecedor = document.getElementById('modalEditarFornecedor');
        const closeModalEditarFornecedor = document.getElementById('closeModalEditarFornecedor');
        closeModalEditarFornecedor.onclick = () => modalEditarFornecedor.style.display = 'none';
        window.onclick = e => {
            if(e.target === modalNovoFornecedor) modalNovoFornecedor.style.display = 'none';
            if(e.target === modalEditarFornecedor) modalEditarFornecedor.style.display = 'none';
        }
        function abrirModalEditarFornecedor(id, nome_fantasia, cnpj, razao_social, email, telefone, categoria_fornecedor, responsavel) {
            document.getElementById('editIdFornecedor').value = id;
            document.getElementById('editNomeFantasia').value = nome_fantasia;
            document.getElementById('editCnpj').value = cnpj;
            document.getElementById('editRazaoSocial').value = razao_social;
            document.getElementById('editEmail').value = email;
            document.getElementById('editTelefone').value = telefone;
            document.getElementById('editCategoriaFornecedor').value = categoria_fornecedor;
            document.getElementById('editResponsavel').value = responsavel;
            modalEditarFornecedor.style.display = 'flex';
        }
        document.getElementById('formEditarFornecedor').onsubmit = function(e) {
            e.preventDefault();
            const id_fornecedor = document.getElementById('editIdFornecedor').value;
            const nome_fantasia = document.getElementById('editNomeFantasia').value;
            const cnpj = document.getElementById('editCnpj').value;
            const razao_social = document.getElementById('editRazaoSocial').value;
            const email = document.getElementById('editEmail').value;
            const telefone = document.getElementById('editTelefone').value;
            const categoria_fornecedor = document.getElementById('editCategoriaFornecedor').value;
            const responsavel = document.getElementById('editResponsavel').value;
            const msg = document.getElementById('editarFornecedorMsg');
            msg.innerHTML = '';
            fetch(`/fornecedor/editar/${id_fornecedor}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ nome_fantasia, cnpj, razao_social, email, telefone, categoria_fornecedor, responsavel })
            }).then(async resp => {
                if (resp.ok) {
                    window.location.reload();
                } else {
                    const result = await resp.json();
                    msg.innerHTML = '<span style="color:#e74c3c;">' + (result.message || 'Erro ao editar fornecedor') + '</span>';
                }
            }).catch(() => {
                msg.innerHTML = '<span style="color:#e74c3c;">Erro ao editar fornecedor</span>';
            });
        };
        // Modal
        const btnNovoFornecedor = document.getElementById('btnNovoFornecedor');
        const modalNovoFornecedor = document.getElementById('modalNovoFornecedor');
        const closeModalNovoFornecedor = document.getElementById('closeModalNovoFornecedor');
        btnNovoFornecedor.onclick = () => modalNovoFornecedor.style.display = 'flex';
        closeModalNovoFornecedor.onclick = () => modalNovoFornecedor.style.display = 'none';
        window.onclick = e => { if(e.target === modalNovoFornecedor) modalNovoFornecedor.style.display = 'none'; }
        // Máscara CNPJ
        document.getElementById('cnpjNovo').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{2})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1/$2');
            value = value.replace(/(\d{4})(\d)/, '$1-$2');
            e.target.value = value;
        });
    </script>
</body>
</html>
