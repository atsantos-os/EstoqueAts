// Gráfico 1: Produtos por Categoria
if (window.produtosPorCategoriaLabels && window.produtosPorCategoriaData) {
    const ctx1 = document.getElementById('graficoProdutosCategoria').getContext('2d');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: window.produtosPorCategoriaLabels,
            datasets: [{
                label: 'Produtos por Categoria',
                data: window.produtosPorCategoriaData,
                backgroundColor: '#3c97c1',
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });
}
// Gráfico 2: Movimentações por Tipo
if (window.movimentacoesPorTipoLabels && window.movimentacoesPorTipoData) {
    const ctx2 = document.getElementById('graficoMovimentacoesTipo').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: window.movimentacoesPorTipoLabels,
            datasets: [{
                label: 'Movimentações',
                data: window.movimentacoesPorTipoData,
                backgroundColor: ['#27ae60', '#e67e22'],
            }]
        },
        options: {
            indexAxis: 'y', // barras horizontais
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });
}
