<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimentação de Estoque</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/movimentacao.css') }}">
     <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    @include('components.header')
    @include('components.sidebar')
    <div class="mov-main">
        <div class="mov-container">
            <div class="mov-header">
                <h2>Movimentação de Estoque</h2>
                <button id="btnNovaMov" class="btn-nova-mov"><i class="fa-solid fa-plus"></i> Nova Movimentação</button>
            </div>
            <table class="mov-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Produto</th>
                        <th>Tipo</th>
                        <th>Quantidade</th>
                        <th>Data</th>
                        <th>Movimentado por</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody id="tbodyMovimentacoes">
                    @foreach($movimentacoes as $mov)
                    <tr data-id="{{ $mov->id_movimentacao }}">
                        <td>{{ $mov->id_movimentacao }}</td>
                        <td>{{ $mov->produto->nome_produto ?? '-' }}</td>
                        <td>{{ $mov->tipo_movimentacao }}</td>
                        <td>{{ $mov->quantidade }}</td>
                        <td>{{ $mov->data_solicitacao }}</td>
                        <td>{{ $mov->usuario->nome ?? '-' }}</td>
                        <td>
                            @if(isset($usuario) && $usuario->is_admin)
                                <button class="btn-excluir" title="Excluir"><i class="fa-solid fa-trash"></i></button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal Nova Movimentação -->
    <div id="modalNovaMov" class="mov-modal">
        <div class="modal-content">
            <span class="close-modal" id="closeModalNovaMov">&times;</span>
            <h3>Cadastrar Movimentação</h3>
            <form id="formNovaMov">
                <select name="id_produto" required>
                    <option value="">Selecione o produto</option>
                    @foreach($produtos as $prod)
                        <option value="{{ $prod->id_produto }}">{{ $prod->nome_produto }}</option>
                    @endforeach
                </select>
                <select name="tipo_movimentacao" required>
                    <option value="ENTRADA">Entrada</option>
                    <option value="SAIDA">Saída</option>
                </select>
                <input type="number" name="quantidade" placeholder="Quantidade" min="1" required>
                <input type="date" name="data_solicitacao" value="{{ date('Y-m-d') }}" required>
                <input type="hidden" name="retirada_por" value="{{ $usuario->id }}">
                <span style="background:#f3f3f3;color:#888;padding:0.5em 1em;border-radius:6px;" title="Movimentado por">{{ $usuario->nome }}</span>
                <button type="submit">Cadastrar</button>
            </form>
            <div id="novaMovMsg" style="margin-top:1rem;font-size:1rem;"></div>
        </div>
    </div>
    <script>
        // Modal
        const btnNovaMov = document.getElementById('btnNovaMov');
        const modalNovaMov = document.getElementById('modalNovaMov');
        const closeModalNovaMov = document.getElementById('closeModalNovaMov');
        btnNovaMov.onclick = () => modalNovaMov.style.display = 'flex';
        closeModalNovaMov.onclick = () => modalNovaMov.style.display = 'none';
        window.onclick = e => { if(e.target === modalNovaMov) modalNovaMov.style.display = 'none'; }

        // Cadastrar movimentação
        document.getElementById('formNovaMov').onsubmit = async function(e) {
            e.preventDefault();
            const form = e.target;
            const data = new FormData(form);
            const msg = document.getElementById('novaMovMsg');
            msg.innerHTML = '';
            try {
                const resp = await fetch("{{ route('movimentacao.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: data
                });
                if (resp.ok) {
                    const result = await resp.json();
                    if (result.success && result.movimentacao) {
                        const mov = result.movimentacao;
                        // Atualiza tabela
                        const tr = document.createElement('tr');
                        tr.innerHTML = `<td>${mov.id_movimentacao}</td><td>${mov.produto.nome_produto}</td><td>${mov.tipo_movimentacao}</td><td>${mov.quantidade}</td><td>${mov.data_solicitacao}</td><td>${mov.retirada_por || '-'}</td><td><button class='btn-excluir' title='Excluir'><i class='fa-solid fa-trash'></i></button></td>`;
                        tr.setAttribute('data-id', mov.id_movimentacao);
                        document.getElementById('tbodyMovimentacoes').prepend(tr);
                        msg.innerHTML = '<span style="color:#27ae60;">Movimentação cadastrada!</span>';
                        form.reset();
                    } else {
                        msg.innerHTML = '<span style="color:#e74c3c;">Erro inesperado ao cadastrar movimentação</span>';
                    }
                } else {
                    const err = await resp.json();
                    let errorMsg = err.message || 'Erro ao cadastrar movimentação';
                    if (err.errors) {
                        errorMsg += '<ul style="margin:0.5em 0 0 1.2em;padding:0;">';
                        for (const [field, messages] of Object.entries(err.errors)) {
                            for (const m of messages) {
                                errorMsg += `<li>${m}</li>`;
                            }
                        }
                        errorMsg += '</ul>';
                    }
                    msg.innerHTML = '<span style="color:#e74c3c;">' + errorMsg + '</span>';
                }
            } catch (error) {
                msg.innerHTML = '<span style="color:#e74c3c;">Erro ao cadastrar movimentação</span>';
            }
        };

        // Excluir movimentação
        document.getElementById('tbodyMovimentacoes').onclick = async function(e) {
            if (e.target.closest('.btn-excluir')) {
                const tr = e.target.closest('tr');
                const id = tr.getAttribute('data-id');
                if (confirm('Deseja excluir esta movimentação?')) {
                    try {
                        const resp = await fetch(`/movimentacao/${id}`, {
                            method: 'DELETE',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                        });
                        const result = await resp.json();
                        if (resp.ok && result.success) {
                            tr.remove();
                        } else {
                            let msg = result.message || 'Erro ao excluir movimentação.';
                            // Exibe feedback visual abaixo da tabela
                            let feedback = document.getElementById('movFeedback');
                            if (!feedback) {
                                feedback = document.createElement('div');
                                feedback.id = 'movFeedback';
                                feedback.style.margin = '1em 0';
                                feedback.style.fontSize = '1rem';
                                feedback.style.textAlign = 'center';
                                document.querySelector('.mov-container').appendChild(feedback);
                            }
                            feedback.innerHTML = `<span style='color:#e74c3c;'>${msg}</span>`;
                        }
                    } catch (error) {
                        alert('Erro ao excluir movimentação.');
                    }
                }
            }
        };
    </script>
</body>
</html>
