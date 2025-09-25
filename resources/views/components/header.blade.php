<style>
    /* Reset e Fonte */
    .app-header, .app-header * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    font-family: 'Montserrat', sans-serif;
    }

    /* Estrutura Principal do Header */
    .app-header {
        height: 70px; /* AJUSTE: Altura levemente aumentada */
        width: 100%;
        background-color: #235596;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 30px;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    /* Lado Esquerdo: Logo */
    .app-header .logo-container {
        display: flex;
        align-items: center;
    }
    .app-header .logo-container img {
        height: 110px; /* AJUSTE: Altura da logo aumentada */
    }
    .app-header .logo-container .title-text {
        margin-left: 15px;
        font-size: 1.25rem;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    /* Lado Direito: Ações do Usuário */
    .app-header .header-actions {
        display: flex;
        align-items: center;
        gap: 20px;
    }
    .app-header .welcome-message {
        font-size: 0.95rem;
        color: #d0d8e0;
    }
    .app-header .user-profile-button {
        display: flex;
        align-items: center;
        cursor: pointer;
        padding: 4px;
        border-radius: 50px;
        transition: background-color 0.2s ease;
    }
    .app-header .user-profile-button:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }
    .app-header .user-profile-button .avatar {
        margin-right: 12px;
    }
    .app-header .user-profile-button .user-name {
        font-weight: 500;
    }
    
    /* Estilos do Modal */
    .modal {
        display: flex;
        visibility: hidden;
        opacity: 0;
        position: fixed;
        z-index: 2000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        align-items: center;
        justify-content: center;
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }
    .modal.is-open {
        visibility: visible;
        opacity: 1;
    }

    .modal-content {
        background-color: #fff;
        color: #333;
        padding: 2rem 2.5rem;
        border-radius: 12px;
        box-shadow: 0 5px 25px rgba(0,0,0,0.15);
        max-width: 400px;
        width: 90%;
        position: relative;
        transform: scale(0.95);
        transition: transform 0.3s ease;
    }
    .modal.is-open .modal-content {
        transform: scale(1);
    }

    .modal-content h3 {
        margin: 0 0 1.5rem 0;
        color: #2678a3;
        font-size: 1.5rem;
    }
    .modal-content p {
        margin: 0.8rem 0;
        line-height: 1.7;
        color: #555;
    }
    .modal-content strong {
      color: #333;
    }
    .modal-close-btn {
        position: absolute;
        top: 15px;
        right: 20px;
        color: #aaa;
        font-size: 30px;
        font-weight: bold;
        cursor: pointer;
        transition: color 0.2s ease;
        line-height: 1;
    }
    .modal-close-btn:hover {
        color: #333;
    }
</style>

<header class="app-header">
    <div class="logo-container">
        <img src="https://atsantos.com.br/wp-content/uploads/2025/09/logo-branca.png" alt="Logo">
        <span class="title-text">Controle de Estoque</span>
    </div>
    
    <div class="header-actions">
        <div class="welcome-message">Bem-vindo(a)!</div>
        
        <div class="user-profile-button" id="userProfileBtn">
            <div class="avatar">
                <svg width="42" height="42" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="21" cy="21" r="21" fill="#fff"/>
                    <circle cx="21" cy="16.5" r="7.5" fill="#3c97c1"/>
                    <ellipse cx="21" cy="31.5" rx="11" ry="6.5" fill="#3c97c1"/>
                </svg>
            </div>
            <span class="user-name">{{ $usuario->nome ?? 'Usuário' }}</span>
        </div>
    </div>
</header>
