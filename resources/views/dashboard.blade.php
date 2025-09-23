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
    <div class="container dashboard-container">
            <h2 class="dashboard-title">Dashboard</h2>
            <div class="dashboard-cards">
                <div class="card card-total">
                    <div class="card-title"><i class="fa-solid fa-boxes-stacked icon-total"></i>Total de Produtos</div>
                    <div class="card-value">{{ $totalProdutos }}</div>
                </div>
                <div class="card card-low">
                    <div class="card-title"><i class="fa-solid fa-triangle-exclamation icon-low"></i>Produtos em Baixa</div>
                    <div class="card-value">{{ $produtosEmBaixa }}</div>
                </div>
                <div class="card card-mov">
                    <div class="card-title"><i class="fa-solid fa-arrows-rotate icon-mov"></i>Movimentações Hoje</div>
                    <div class="card-value">{{ $movimentacoesHoje }}</div>
                </div>
            </div>
            <div class="dashboard-graphs-section">
                <div class="dashboard-graphs-wrapper">
                    <div class="dashboard-graph-card">
                        <h4 class="dashboard-graph-title">Produtos por Categoria</h4>
                        <canvas id="graficoProdutosCategoria" class="dashboard-graph-canvas" height="260"></canvas>
                    </div>
                    <div class="dashboard-graph-card">
                        <h4 class="dashboard-graph-title">Movimentações por Tipo</h4>
                        <canvas id="graficoMovimentacoesTipo" class="dashboard-graph-canvas" height="260"></canvas>
                    </div>
                </div>
                <h3 class="dashboard-mov-title">Movimentações Recentes</h3>
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
