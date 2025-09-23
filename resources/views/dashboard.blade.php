<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - At & Santos</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    @include('components.header')
    @include('components.sidebar')

    <div class="main-content">
        <div class="container" style="padding:2.5rem 2rem;">
            <h2 style="margin-bottom:2.5rem;text-align:left;font-size:2.2rem;color:#2678a3;font-weight:700;">Dashboard</h2>
            <div class="dashboard-cards">
                <div class="card card-total">
                    <div class="card-title"><i class="fa-solid fa-boxes-stacked" style="color:#3c97c1;margin-right:8px;"></i>Total de Produtos</div>
                    <div class="card-value">{{ $totalProdutos }}</div>
                </div>
                <div class="card card-low">
                    <div class="card-title"><i class="fa-solid fa-triangle-exclamation" style="color:#e67e22;margin-right:8px;"></i>Produtos em Baixa</div>
                    <div class="card-value">{{ $produtosEmBaixa }}</div>
                </div>
                <div class="card card-mov">
                    <div class="card-title"><i class="fa-solid fa-arrows-rotate" style="color:#27ae60;margin-right:8px;"></i>Movimentações Hoje</div>
                    <div class="card-value">{{ $movimentacoesHoje }}</div>
                </div>
            </div>
            <div style="margin-top:3rem;text-align:left;">
            <div style="margin-top:3rem;text-align:left;">
                <div style="display:flex;gap:1.5rem;margin-bottom:2.2rem;flex-wrap:wrap;justify-content:center;align-items:flex-start;">
                    <div style="flex:1;min-width:340px;max-width:540px;background:#fff;border-radius:12px;box-shadow:0 2px 10px #eaf1f7;padding:1.5rem 1.2rem 1.2rem 1.2rem;display:flex;flex-direction:column;align-items:center;">
                        <h4 style="color:#2678a3;font-size:1.18rem;font-weight:600;margin-bottom:1.1rem;">Produtos por Categoria</h4>
                        <canvas id="graficoProdutosCategoria" style="width:100%;max-width:480px;min-width:240px;" height="260"></canvas>
                    </div>
                    <div style="flex:1;min-width:340px;max-width:540px;background:#fff;border-radius:12px;box-shadow:0 2px 10px #eaf1f7;padding:1.5rem 1.2rem 1.2rem 1.2rem;display:flex;flex-direction:column;align-items:center;">
                        <h4 style="color:#2678a3;font-size:1.18rem;font-weight:600;margin-bottom:1.1rem;">Movimentações por Tipo</h4>
                        <canvas id="graficoMovimentacoesTipo" style="width:100%;max-width:480px;min-width:240px;" height="260"></canvas>
                    </div>
                </div>
                <h3 style="color:#2678a3;margin-bottom:1rem;">Movimentações Recentes</h3>
                <table class="table-mov">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Produto</th>
                            <th>Tipo</th>
                            <th>Quantidade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($movimentacoesRecentes as $mov)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($mov->data_solicitacao)->format('d/m/Y') }}</td>
                            <td>{{ optional(App\Models\Produto::find($mov->id_produto))->nome_produto ?? '-' }}</td>
                            <td>{{ ucfirst(strtolower($mov->tipo_movimentacao)) }}</td>
                            <td>{{ $mov->quantidade }}</td>
                        </tr>
                        @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Perfil do Usuário -->
    <div id="profileModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModalBtn">&times;</span>
            <h3>Perfil do Usuário</h3>
            <p><strong>Nome:</strong> {{ $usuario->nome }}</p>
            <p><strong>CPF:</strong> {{ $usuario->cpf }}</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    // Dados para os gráficos (injetados do backend)
    window.produtosPorCategoriaLabels = {!! json_encode($produtosPorCategoriaLabels ?? []) !!};
    window.produtosPorCategoriaData = {!! json_encode($produtosPorCategoriaData ?? []) !!};
    window.movimentacoesPorTipoLabels = {!! json_encode($movimentacoesPorTipoLabels ?? []) !!};
    window.movimentacoesPorTipoData = {!! json_encode($movimentacoesPorTipoData ?? []) !!};
    </script>
    <script src="{{ asset('js/dashboard-charts.js') }}"></script>
    <script>
        const userProfileBtn = document.getElementById('userProfileBtn');
        const profileModal = document.getElementById('profileModal');
        const closeModalBtn = document.getElementById('closeModalBtn');
        userProfileBtn.onclick = () => profileModal.classList.add('show');
        closeModalBtn.onclick = () => profileModal.classList.remove('show');
        profileModal.onclick = e => { if(e.target === profileModal) profileModal.classList.remove('show'); }
    </script>
</body>
</html>
