<style>
    /* CSS Reset e Configurações de Fonte */
    .sidebar, .sidebar * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Montserrat', sans-serif;
    }

    /* Estrutura Principal da Sidebar */
    .sidebar {
        width: 260px;
        position: fixed;
        /* AJUSTE: Posição inicial e altura calculada para respeitar um header de 60px */
        top: 60px; 
        left: 0;
        height: calc(100vh - 60px);

        /* AJUSTE: Nova cor de fundo */
        background-color: #235596; 

        color: #fff;
        display: flex;
        flex-direction: column;
        padding: 15px;
    }

    /* Cabeçalho com Logo e Título */
    .sidebar-header {
        padding: 10px 5px;
    }

    .sidebar-header .brand-link {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #fff;
    }

    .sidebar-header .logo-icon {
        font-size: 28px;
        margin-right: 15px;
        color: #82c3ff; /* Cor do logo levemente ajustada para o novo fundo */
    }
    
    .sidebar-header .title {
        font-size: 22px;
        font-weight: 600;
        white-space: nowrap;
    }

    .sidebar-header .title strong {
        color: #82c3ff; /* Cor do logo levemente ajustada para o novo fundo */
        font-weight: 700;
    }

    .sidebar-header .title span {
        font-weight: 400;
        color: #fff;
    }

    /* Divisor Horizontal */
    .sidebar .divider {
        height: 1px;
        width: 100%;
        /* AJUSTE: Cor do divisor para combinar com o novo fundo */
        background-color: #2A4A6C; 
        margin: 10px 0;
    }

    /* Navegação Principal */
    .sidebar-nav {
        flex-grow: 1;
        overflow-y: auto;
    }

    .sidebar-nav ul {
        list-style: none;
    }

    .sidebar-nav a {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        margin: 5px 0;
        border-radius: 8px;
        text-decoration: none;
        color: #fff;
        font-weight: 500;
        transition: background-color 0.2s ease, color 0.2s ease;
    }

    .sidebar-nav a i {
        font-size: 18px;
        width: 25px; 
        text-align: center;
        margin-right: 15px;
    }

    .sidebar-nav a:hover {
        /* AJUSTE: Cor de hover para combinar com o novo fundo */
        background-color: #2A4A6C; 
        color: #ffffff;
    }

    .sidebar-nav a.active {
        background-color: #82c3ff;
        color: #fff;
    }

    /* Rodapé com Perfil de Usuário */
    .sidebar-footer {
        padding-top: 10px;
    }

    .user-profile {
        display: flex;
        align-items: center;
        padding: 10px 5px;
    }
    
    .user-info {
        display: flex;
        align-items: center;
        flex-grow: 1;
    }

    .user-info .fa-user-circle {
        font-size: 32px;
        margin-right: 15px;
    }

    .user-info .user-name {
        font-weight: 500;
    }

    .logout-btn {
        color: #fff;
        font-size: 20px;
        text-decoration: none;
        padding: 5px;
        transition: color 0.2s ease;
    }

    .logout-btn:hover {
        color: #e74c3c;
    }
</style>

<aside class="sidebar">
    <div class="sidebar-header">
        <a href="{{ url('dashboard') }}" class="brand-link">
            <span class="logo-icon" style="width:28px;display:inline-block;margin-right:15px;">
                <!-- SVG moderno: caixa aberta -->
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#82c3ff" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73zM12 4.15L18.4 8 12 11.85 5.6 8 12 4.15zM5 9.62l6 3.73v6.5L5 16.12V9.62zm14 6.5l-6 3.73v-6.5l6-3.73v6.5z"/></svg>
            </span>
            <h1 class="title">
                <span>ESTOQUE</span>
                <strong>ATS</strong>
                
            </h1>
        </a>
    </div>

    <div class="divider"></div>

    <nav class="sidebar-nav">
        <ul>
            {{-- Painel sempre em primeiro, todos os outros (inclusive admin) em ordem alfabética única --}}
            <li><a href="{{ url('dashboard') }}" class="{{ Request::is('dashboard') ? 'active' : '' }}">
                <span style="width:25px;display:inline-block;margin-right:15px;">
                    <!-- SVG moderno: gráfico/analytics -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M3 17v-7a1 1 0 0 1 2 0v7a1 1 0 0 1-2 0zm4 0v-4a1 1 0 0 1 2 0v4a1 1 0 0 1-2 0zm4 0v-10a1 1 0 0 1 2 0v10a1 1 0 0 1-2 0zm4 0v-2a1 1 0 0 1 2 0v2a1 1 0 0 1-2 0z"/></svg>
                </span>
                <span>Painel</span>
            </a></li>
            {{-- Lista única ordenada --}}
            @php
                $links = [
                    [
                        'label' => 'Categorias',
                        'route' => route('categorias'),
                        'active' => Request::is('categorias'),
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M20.59 13.41l-8-8A2 2 0 0 0 10.17 5H5a2 2 0 0 0-2 2v5.17a2 2 0 0 0 .59 1.41l8 8a2 2 0 0 0 2.83 0l6.17-6.17a2 2 0 0 0 0-2.83zM7.5 8A1.5 1.5 0 1 1 6 9.5 1.5 1.5 0 0 1 7.5 8z"/></svg>',
                        'admin' => true
                    ],
                    [
                        'label' => 'Clientes',
                        'route' => route('clientes'),
                        'active' => Request::is('clientes'),
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05C15.64 13.36 17 14.28 17 15.5V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>',
                        'admin' => true
                    ],
                    [
                        'label' => 'Configurações',
                        'route' => route('configuracoes'),
                        'active' => Request::is('configuracoes'),
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 15.5A3.5 3.5 0 1 1 12 8.5a3.5 3.5 0 0 1 0 7zm7.43-2.27l1.77-1.02a1 1 0 0 0 .37-1.36l-1.68-2.91a1 1 0 0 0-1.36-.37l-1.77 1.02a7.03 7.03 0 0 0-1.53-.88l-.27-1.93A1 1 0 0 0 14 4h-4a1 1 0 0 0-1 .88l-.27 1.93a7.03 7.03 0 0 0-1.53.88L5.43 6.67a1 1 0 0 0-1.36.37l-1.68 2.91a1 1 0 0 0 .37 1.36l1.77 1.02c-.09.32-.16.65-.21.99l-1.93.27A1 1 0 0 0 2 14v4a1 1 0 0 0 .88 1l1.93.27c.05.34.12.67.21.99l-1.77 1.02a1 1 0 0 0-.37 1.36l1.68 2.91a1 1 0 0 0 1.36.37l1.77-1.02c.32.09.65.16.99.21l.27 1.93A1 1 0 0 0 10 22h4a1 1 0 0 0 1-.88l.27-1.93c.34-.05.67-.12.99-.21l1.77 1.02a1 1 0 0 0 1.36-.37l1.68-2.91a1 1 0 0 0-.37-1.36l-1.77-1.02c.09-.32.16-.65.21-.99l1.93-.27A1 1 0 0 0 22 14v-4a1 1 0 0 0-.88-1l-1.93-.27a7.03 7.03 0 0 0-.21-.99z"/></svg>',
                        'admin' => false
                    ],
                    [
                        'label' => 'Fornecedores',
                        'route' => route('fornecedores'),
                        'active' => Request::is('fornecedores'),
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M20 8V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v2H2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8h-2zm-2 0H6V6h12v2zm2 10H4V10h16v8zm-2-4a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/></svg>',
                        'admin' => true
                    ],
                    [
                        'label' => 'Maquinários',
                        'route' => route('maquinarios.index'),
                        'active' => Request::is('maquinarios*'),
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 15.5A3.5 3.5 0 1 1 12 8.5a3.5 3.5 0 0 1 0 7zm7.43-2.27l1.77-1.02a1 1 0 0 0 .37-1.36l-1.68-2.91a1 1 0 0 0-1.36-.37l-1.77 1.02a7.03 7.03 0 0 0-1.53-.88l-.27-1.93A1 1 0 0 0 14 4h-4a1 1 0 0 0-1 .88l-.27 1.93a7.03 7.03 0 0 0-1.53.88L5.43 6.67a1 1 0 0 0-1.36.37l-1.68 2.91a1 1 0 0 0 .37 1.36l1.77 1.02c-.09.32-.16.65-.21.99l-1.93.27A1 1 0 0 0 2 14v4a1 1 0 0 0 .88 1l1.93.27c.05.34.12.67.21.99l-1.77 1.02a1 1 0 0 0-.37 1.36l1.68 2.91a1 1 0 0 0 1.36.37l1.77-1.02c.32.09.65.16.99.21l.27 1.93A1 1 0 0 0 10 22h4a1 1 0 0 0 1-.88l.27-1.93c.34-.05.67-.12.99-.21l1.77 1.02a1 1 0 0 0 1.36-.37l1.68-2.91a1 1 0 0 0-.37-1.36l-1.77-1.02c.09-.32.16-.65.21-.99l1.93-.27A1 1 0 0 0 22 14v-4a1 1 0 0 0-.88-1l-1.93-.27a7.03 7.03 0 0 0-.21-.99z"/></svg>',
                        'admin' => true
                    ],
                    [
                        'label' => 'Movimentações',
                        'route' => route('movimentacao.index'),
                        'active' => Request::is('movimentacao*'),
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M17.65 6.35a.5.5 0 0 0-.85.35v2.79H7.5a.5.5 0 0 0 0 1h9.29v2.79a.5.5 0 0 0 .85.35l3.79-3.79a.5.5 0 0 0 0-.71l-3.78-3.78zM6.35 17.65a.5.5 0 0 0 .85-.35v-2.79h9.29a.5.5 0 0 0 0-1H7.2v-2.79a.5.5 0 0 0-.85-.35L2.56 15.21a.5.5 0 0 0 0 .71l3.79 3.79z"/></svg>',
                        'admin' => false
                    ],
                    [
                        'label' => 'Produtos',
                        'route' => url('produtos'),
                        'active' => Request::is('produtos'),
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73zM12 4.15L18.4 8 12 11.85 5.6 8 12 4.15zM5 9.62l6 3.73v6.5L5 16.12V9.62zm14 6.5l-6 3.73v-6.5l6-3.73v6.5z"/></svg>',
                        'admin' => false
                    ],
                    [
                        'label' => 'Relatórios',
                        'route' => url('relatorio'),
                        'active' => Request::is('relatorio'),
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6H6zm7 1.5V8h5.5L13 3.5zM6 4h6v5a1 1 0 0 0 1 1h5v10a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V4zm2 14v-2h8v2H8zm0-4v-2h8v2H8z"/></svg>',
                        'admin' => false
                    ],
                    [
                        'label' => 'Usuários',
                        'route' => route('usuarios'),
                        'active' => Request::is('usuarios'),
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8V21h19.2v-1.8c0-3.2-6.4-4.8-9.6-4.8z"/></svg>',
                        'admin' => true
                    ],
                ];
                // Filtra admin se não for admin
                if (!isset($usuario) || !$usuario->is_admin) {
                    $links = array_filter($links, function($l) { return !$l['admin']; });
                }
                usort($links, function($a, $b) {
                    return strcmp($a['label'], $b['label']);
                });
            @endphp
            @foreach($links as $link)
                <li><a href="{{ $link['route'] }}" class="{{ $link['active'] ? 'active' : '' }}">
                    <span style="width:25px;display:inline-block;margin-right:15px;">{!! $link['icon'] !!}</span>
                    <span>{{ $link['label'] }}</span>
                </a></li>
            @endforeach
        </ul>
    </nav>

    <div class="divider"></div>

    <footer class="sidebar-footer">
        <div class="user-profile">
            <div class="user-info" style="cursor:pointer;" onclick="toggleEstoque()">
                <span style="width:32px;display:inline-block;margin-right:15px;">
                    <!-- SVG moderno: caixa/estoque -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73zM12 4.15L18.4 8 12 11.85 5.6 8 12 4.15zM5 9.62l6 3.73v6.5L5 16.12V9.62zm14 6.5l-6 3.73v-6.5l6-3.73v6.5z"/></svg>
                </span>
                <span class="estoque-nome" id="estoque-nome">Estoque ATS</span>
            </div>
        </div>
<script>
function toggleEstoque() {
    var nome = document.getElementById('estoque-nome');
    if (nome.innerText.trim() === 'Estoque ATS') {
        nome.innerText = 'Estoque LAS';
    } else {
        nome.innerText = 'Estoque ATS';
    }
}
</script>
    </footer>
</aside>