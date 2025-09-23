<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/relatorio.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    @include('components.header')
    @include('components.sidebar')
    <div class="relatorio-main">
        <div class="relatorio-container">
            <div class="relatorio-header">
                <h2>Relatórios de Estoque</h2>
                <form method="GET" action="{{ route('relatorio') }}" class="relatorio-filtros">
                    <input type="date" name="data_inicio" value="{{ request('data_inicio') }}" placeholder="Data início">
                    <input type="date" name="data_fim" value="{{ request('data_fim') }}" placeholder="Data fim">
                    <select name="categoria">
                        <option value="">Todas as categorias</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id_categoria }}" {{ request('categoria') == $cat->id_categoria ? 'selected' : '' }}>{{ $cat->nome_categoria }}</option>
                        @endforeach
                    </select>
                    <select name="fornecedor">
                        <option value="">Todos os fornecedores</option>
                        @foreach($fornecedores as $forn)
                            <option value="{{ $forn->id_fornecedor }}" {{ request('fornecedor') == $forn->id_fornecedor ? 'selected' : '' }}>{{ $forn->nome_fantasia }}</option>
                        @endforeach
                    </select>
                    <select name="tipo">
                        <option value="">Todos os tipos</option>
                        <option value="entrada" {{ request('tipo') == 'entrada' ? 'selected' : '' }}>Entrada</option>
                        <option value="saida" {{ request('tipo') == 'saida' ? 'selected' : '' }}>Saída</option>
                    </select>
                    <button type="submit" class="relatorio-btn">Filtrar</button>
                    <a href="{{ route('relatorio.export', request()->all()) }}" class="relatorio-btn relatorio-btn-export">Exportar Excel</a>
                </form>
            </div>
            <div class="relatorio-table-wrapper">
                <table class="relatorio-table">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Produto</th>
                            <th>Categoria</th>
                            <th>Fornecedor</th>
                            <th>Tipo</th>
                            <th>Quantidade</th>
                            <th>Usuário</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($movimentacoes as $mov)
                        <tr>
                            <td>{{ date('d/m/Y', strtotime($mov->data_solicitacao)) }}</td>
                            <td>{{ $mov->produto->nome_produto ?? '-' }}</td>
                            <td>{{ $mov->produto->categoria->nome_categoria ?? '-' }}</td>
                            <td>{{ $mov->produto->fornecedor->nome_fantasia ?? '-' }}</td>
                            <td>{{ ucfirst($mov->tipo_movimentacao) }}</td>
                            <td>{{ $mov->quantidade }}</td>
                            <td>
                                @if($mov->usuario)
                                    {{ $mov->usuario->nome ?? $mov->usuario->id }}
                                @elseif($mov->retirada_por)
                                    {{ $mov->retirada_por }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="relatorio-grafico">
                <h3 class="relatorio-grafico-title">Gráfico de Movimentações</h3>
                <canvas id="graficoMovimentacoes" height="120"></canvas>
            </div>
        </div>
    </div>
    <script>
        // Dados do gráfico vindos do backend
        const dadosGrafico = @json($graficoMovimentacoes);
        const ctx = document.getElementById('graficoMovimentacoes').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: dadosGrafico.labels,
                datasets: [
                    {
                        label: 'Entradas',
                        data: dadosGrafico.entradas,
                        backgroundColor: '#27ae60',
                    },
                    {
                        label: 'Saídas',
                        data: dadosGrafico.saidas,
                        backgroundColor: '#e74c3c',
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: false }
                }
            }
        });
    </script>
</body>
</html>
