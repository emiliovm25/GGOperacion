<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OVERWATCH</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome para íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="CSS/styleindex.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<style>
    /* CONTENEDOR PRINCIPAL - AHORA A ANCHO COMPLETO */
    .fullwidth-news-container {
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
        padding: 60px 0;
        background-color: #0A0A0A;
        border-top: 3px solid #D4AF37;
        border-bottom: 3px solid #D4AF37;
    }

    /* CONTENEDOR INTERNO PARA CENTRAR CONTENIDO */
    .news-inner-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* TARJETAS DE NOTICIAS */
    .fortnite-news-container {
        display: grid;
        grid-template-columns: 1fr;
        gap: 30px;
    }

    .fortnite-news-card {
        display: flex;
        background: #0A0A0A;
        overflow: hidden;
        margin-bottom: 2px;
        text-decoration: none;
        color: inherit;
        position: relative;
        transition: transform 0.3s, box-shadow 0.3s;
        border: 1px solid rgba(212, 175, 55, 0.3);
    }

    .fortnite-news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(212, 175, 55, 0.2);
        border-color: rgba(212, 175, 55, 0.5);
    }

    /* IMAGEN DE NOTICIA */
    .news-image {
        flex: 1;
        min-width: 300px;
        max-height: 500px;
        overflow: hidden;
    }

    .news-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.3s;
    }

    .fortnite-news-card:hover .news-image img {
        transform: scale(1.05);
    }

    /* CONTENIDO DE NOTICIA */
    .news-content {
        flex: 1;
        padding: 40px;
        min-height: 300px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .news-title {
        color: #D4AF37;
        font-size: 1.8rem;
        margin-bottom: 15px;
        line-height: 1.3;
        font-weight: 700;
    }

    .news-body {
        color: #E0E0E0;
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .news-link {
        color: #F5D98F;
        font-weight: 600;
        margin-top: auto;
        align-self: flex-start;
        transition: all 0.3s;
    }

    .fortnite-news-card:hover .news-link {
        color: #D4AF37;
        transform: translateX(5px);
    }

    /* ALTERNAR POSICIÓN DE IMAGEN */
    .fortnite-news-card:nth-child(odd) {
        flex-direction: row;
    }

    .fortnite-news-card:nth-child(even) {
        flex-direction: row-reverse;
    }

    /* DISEÑO RESPONSIVE */
    @media (max-width: 992px) {

        .fortnite-news-card,
        .fortnite-news-card:nth-child(odd),
        .fortnite-news-card:nth-child(even) {
            flex-direction: column;
        }

        .news-image {
            min-width: 100%;
            max-height: 300px;
        }

        .news-content {
            padding: 25px;
            min-height: auto;
        }
    }

    @media (max-width: 768px) {
        .fullwidth-news-container {
            padding: 40px 0;
        }

        .news-title {
            font-size: 1.5rem;
        }

        .fortnite-news-container {
            padding: 0 15px;
        }

        .news-image {
            min-width: 100%;
            height: 200px;
        }

        .news-content {
            padding: 20px;
        }
    }

    .fortnite-hero {
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
            url('https://images.contentstack.io/v3/assets/bltb6530b271fddd0b1/blt29d7c4f6bc077e9a/5eb26f54402b8b4d13a56656/fortnite-ch2-s2-keyart.jpg') no-repeat center center;
        background-size: cover;
        height: 80vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .hero-content {
        text-align: center;
        width: 100%;
        color: white;
        z-index: 2;
    }

    .fortnite-title {
        font-size: 5rem;
        font-weight: 900;
        text-transform: uppercase;
        background: linear-gradient(to right, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        margin-bottom: 1rem;
    }

    .fortnite-subtitle {
        font-size: 1.8rem;
        margin-bottom: 2rem;
        text-shadow: 2px 2px 4px #000;
        color: #D4AF37;
    }

    .fortnite-cta {
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
        text-shadow: 2px 2px 4px #000;
    }

    .fortnite-btn {
        background: linear-gradient(to right, rgb(0, 26, 255), rgb(0, 110, 255));
        border: none;
        border-radius: 50px;
        padding: 15px 40px;
        font-size: 1.5rem;
        font-weight: bold;
        color: white;
        box-shadow: 0 0 20px rgba(0, 4, 255, 0.7);
        transition: all 0.3s;
    }

    .fortnite-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 0 30px rgba(0, 26, 255, 0.9);
    }

    .pause-btn {
        position: absolute;
        bottom: 20px;
        left: 20px;
        background: rgba(0, 0, 0, 0.5);
        border: 2px solid white;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        transition: all 0.3s;
        z-index: 10;
    }

    .pause-btn:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .pause-icon {
        color: white;
        font-size: 1.2rem;
    }

    .fortnite-hero {
        position: relative;
        height: 80vh;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .video-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        color: white;
        padding: 20px;
    }

    .nav-btn i {
        font-size: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Opcional: Ajusta el tamaño del botón si es necesario */
    .nav-btn {
        width: 70px;
        height: 70px;
    }

    :root {
        --gamebar-bg: #101113;
        --gamebar-text: rgb(110, 110, 110);
        --gamebar-hover: rgb(254, 254, 255);
        --gamebar-border: #333;
        --page-bg: #d9d9d9;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: var(--page-bg);
        margin: 0;
        padding: 0;
    }

    /* Barra de navegación superior */
    .game-bar {
        background-color: var(--gamebar-bg);
        border-bottom: 1px solid var(--gamebar-border);
        padding: 8px 0;
        overflow-x: auto;
        white-space: nowrap;
    }

    .nav-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }

    .logo-section {
        flex-shrink: 0;
        padding-left: 15px;
    }

    .games-section {
        flex-grow: 1;
        display: flex;
        justify-content: center;
        overflow: hidden;
    }

    .game-scroller {
        display: inline-flex;
        padding: 0 20px;
    }

    .game-item {
        display: inline-flex;
        align-items: center;
        color: var(--gamebar-text);
        margin: 0 12px;
        padding: 6px 10px;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none !important;
    }

    .game-item:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: white;
        transform: translateY(-2px);
    }

    .game-item.active {
        color: var(--gamebar-hover);
        border-bottom: 2px solid var(--gamebar-hover);
    }

    .game-icon {
        width: 24px;
        height: 24px;
        margin-right: 8px;
        object-fit: contain;
    }

    .menu-section {
        flex-shrink: 0;
        padding-right: 20px;
    }

    .hamburger-menu {
        color: var(--gamebar-text);
        font-size: 1.3rem;
        cursor: pointer;
        transition: all 0.2s;
        padding: 8px 12px;
    }

    .hamburger-menu:hover {
        color: var(--gamebar-hover);
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 4px;
    }

    :root {
        --primary-dark: #0A0A0A;
        /* Negro profundo */
        --primary-gold: #D4AF37;
        /* Dorado clásico */
        --secondary-gold: #F5D98F;
        /* Dorado claro */
        --text-light: #F0F0F0;
        /* Texto claro */
        --text-gray: #A0A0A0;
        /* Texto secundario */
    }

    body {
        font-family: 'Montserrat', 'Helvetica Neue', Arial, sans-serif;
        background-color: var(--primary-dark);
        color: var(--text-light);
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }

    .about-section {
        display: flex;
        min-height: 100vh;
        position: relative;
    }

    .content-wrapper {
        display: flex;
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        z-index: 2;
    }

    :root {
        --primary-dark: #0A0A0A;
        --primary-gold: #D4AF37;
        --secondary-gold: #F5D98F;
        --text-light: #F0F0F0;
    }

    /* ESTILOS DEL FOOTER */
    .custom-footer {
        background-color: #111214;
        /* Fondo negro grisáceo */
        padding: 30px 20px;
        border-top: 2px solid #D4AF37;
        /* Borde dorado */
        font-family: 'Segoe UI', sans-serif;
    }

    .footer-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 1200px;
        margin: 0 auto;
        flex-wrap: wrap;
        gap: 20px;
    }

    /* Logo izquierda */
    .footer-logo {
        flex: 1;
        min-width: 150px;
    }

    .footer-logo img {
        max-width: 100px;
        height: auto;

    }

    /* Juegos centro */
    .footer-games {
        flex: 2;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
        padding: 0 15px;
    }

    .game-item {
        background-color: rgba(255, 255, 255, 0.08);
        padding: 6px 12px;
        border-radius: 15px;
        font-size: 0.9rem;
        color: #F0F0F0;
        transition: all 0.3s;
        cursor: pointer;
    }

    .game-item:hover {
        background-color: #D4AF37;
        /* Dorado al hover */
        color: #0A0A0A;
        /* Texto negro */
        transform: translateY(-2px);
    }

    /* Redes derecha */
    .footer-social {
        flex: 1;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }

    .social-icon {
        width: 36px;
        height: 36px;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #F0F0F0;
        transition: all 0.3s;
    }

    .social-icon:hover {
        background-color: #D4AF37;
        /* Dorado al hover */
        color: #0A0A0A;
        transform: scale(1.1);
    }

    /* Texto inferior */
    .footer-bottom {
        text-align: center;
        margin-top: 25px;
        padding-top: 15px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.6);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .footer-content {
            flex-direction: column;
        }

        .footer-logo,
        .footer-social {
            justify-content: center;
            width: 100%;
        }

        .footer-logo {
            text-align: center;
        }

        .footer-games {
            order: 3;
            margin-top: 20px;
        }
    }

    /* Estilo BASE del botón */
    .fortnite-btn {
        background: linear-gradient(to right, rgb(0, 26, 255), rgb(0, 110, 255));
        border: none;
        border-radius: 50px;
        /* Bordes completamente redondeados */
        padding: 15px 40px;
        /* Espaciado interno (alto/ancho) */
        font-size: 1.5rem;
        /* Tamaño de texto */
        font-weight: bold;
        /* Negritas */
        color: white;
        /* Color del texto */
        text-transform: uppercase;
        /* Texto en mayúsculas */
        box-shadow: 0 0 20px rgba(0, 4, 255, 0.7);
        /* Sombra azul neón */
        cursor: pointer;
        /* Cambia el cursor al pasar */
        transition: all 0.3s ease;
        /* Transición suave para efectos */
        display: inline-block;
        /* Para que funcione el transform */
        position: relative;
        /* Para efectos avanzados */
        overflow: hidden;
        /* Para efectos de onda */
    }

    /* Estilo HOVER (al pasar el mouse) */
    .fortnite-btn:hover {
        transform: scale(1.05);
        /* Crece un 5% */
        box-shadow: 0 0 30px rgba(0, 26, 255, 0.9);
        /* Sombra más intensa */
        background: linear-gradient(to right, rgb(0, 47, 255), rgb(0, 140, 255));
        /* Gradiente más claro */
    }

    /* Estilo ACTIVE (al hacer clic) */
    .fortnite-btn:active {
        transform: scale(0.98);
        /* Efecto de "presionado" */
        box-shadow: 0 0 15px rgba(0, 4, 255, 0.5);
        /* Sombra más pequeña */
    }

    /* Efecto ONDA (opcional) */
    .fortnite-btn::after {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        width: 5px;
        height: 5px;
        background: rgba(255, 255, 255, 0.5);
        opacity: 0;
        border-radius: 100%;
        transform: scale(1, 1) translate(-50%);
        transform-origin: 50% 50%;
    }

    .fortnite-btn:hover::after {
        animation: ripple 1s ease-out;
    }

    @keyframes ripple {
        0% {
            transform: scale(0, 0);
            opacity: 0.5;
        }

        100% {
            transform: scale(20, 20);
            opacity: 0;
        }
    }

    /*estilo de los agente*/
    /* ESTILOS BASE */
    body {
        margin: 0;
        padding: 0;
        background-color: #000000;
        /* Fondo negro absoluto */
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* CONTENEDOR PRINCIPAL - AHORA A ANCHO COMPLETO */
    .valorant-fullwidth-container {
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
        padding: 60px 0;
        background-color: #0A0A0A;
        /* Negro profundo */
        border-top: 3px solid #D4AF37;
        /* Borde dorado arriba */
        border-bottom: 3px solid #D4AF37;
        /* Borde dorado abajo */
        box-shadow: 0 0 50px rgba(212, 175, 55, 0.1);
        /* Sutil brillo dorado */
    }

    /* CONTENEDOR INTERNO PARA CENTRAR CONTENIDO */
    .valorant-inner-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* TARJETA */
    .valorant-card {
        display: flex;
        background: #0A0A0A;
        /* Negro profundo */
        overflow: hidden;
        position: relative;
        transition: all 0.4s ease;
        border: 1px solid rgba(212, 175, 55, 0.3);
        /* Borde dorado sutil */
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
    }

    .valorant-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(212, 175, 55, 0.3);
        /* Sombra dorada más intensa */
        border-color: rgba(212, 175, 55, 0.5);
        /* Borde más visible al hover */
    }

    /* IMAGEN */
    .valorant-image {
        flex: 1;
        min-width: 50%;
        overflow: hidden;
    }

    .valorant-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.5s ease;
    }

    .valorant-card:hover .valorant-image img {
        transform: scale(1.08);
    }

    /* CONTENIDO */
    .valorant-content {
        flex: 1;
        padding: 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
    }

    .valorant-title {
        color: #D4AF37;
        /* Dorado principal */
        font-size: 3rem;
        margin: 0 0 20px 0;
        line-height: 1.2;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-shadow: 0 2px 5px rgba(212, 175, 55, 0.3);
    }

    .valorant-body {
        color: #E0E0E0;
        /* Texto claro */
        font-size: 1.2rem;
        line-height: 1.7;
        margin-bottom: 30px;
    }

    /* BOTÓN */
    .valorant-btn {
        background: linear-gradient(135deg, #D4AF37 0%, #F5D98F 100%);
        /* Gradiente dorado */
        border: none;
        border-radius: 50px;
        padding: 18px 45px;
        font-size: 1.3rem;
        font-weight: bold;
        color: #0A0A0A;
        /* Texto negro */
        box-shadow: 0 5px 25px rgba(212, 175, 55, 0.4);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        text-decoration: none;
        display: inline-block;
        align-self: flex-start;
        text-transform: uppercase;
        position: relative;
        overflow: hidden;
    }

    .valorant-btn:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 8px 30px rgba(212, 175, 55, 0.6);
        background: linear-gradient(135deg, #F5D98F 0%, #D4AF37 100%);
        /* Inverso del gradiente */
    }

    .valorant-btn:active {
        transform: translateY(1px);
    }

    /* EFECTO DE BRILLO EN BOTÓN */
    .valorant-btn::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(to bottom right,
                rgba(255, 255, 255, 0) 45%,
                rgba(255, 255, 255, 0.8) 50%,
                rgba(255, 255, 255, 0) 55%);
        transform: rotate(30deg);
        transition: all 0.5s;
    }

    .valorant-btn:hover::after {
        left: 100%;
    }

    /* DISEÑO RESPONSIVE */
    @media (max-width: 992px) {
        .valorant-card {
            flex-direction: column;
        }

        .valorant-image {
            min-height: 400px;
        }

        .valorant-content {
            padding: 40px;
        }
    }

    @media (max-width: 768px) {
        .valorant-fullwidth-container {
            padding: 40px 0;
        }

        .valorant-title {
            font-size: 2.2rem;
        }

        .valorant-body {
            font-size: 1.1rem;
        }

        .valorant-btn {
            padding: 15px 35px;
            font-size: 1.1rem;
        }
    }

    @media (max-width: 480px) {
        .valorant-content {
            padding: 30px 20px;
        }

        .valorant-image {
            min-height: 300px;
        }
    }

    /* ESTILOS BASE */
    body {
        margin: 0;
        padding: 0;
        background-color: #000000;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* CONTENEDOR PRINCIPAL - ANCHO COMPLETO */
    .valorant-maps-fullwidth {
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
        padding: 60px 0;
        background-color: #0A0A0A;
        border-top: 3px solid #D4AF37;
        border-bottom: 3px solid #D4AF37;
        box-shadow: 0 0 50px rgba(212, 175, 55, 0.1);
    }

    /* CONTENEDOR INTERNO */
    .maps-inner-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* TARJETA DE MAPA (IMAGEN DERECHA) */
    .valorant-map-card {
        display: flex;
        background: #0A0A0A;
        overflow: hidden;
        position: relative;
        transition: all 0.4s ease;
        border: 1px solid rgba(212, 175, 55, 0.3);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
        flex-direction: row-reverse;
        /* Esto invierte el orden */
    }

    .valorant-map-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(212, 175, 55, 0.3);
        border-color: rgba(212, 175, 55, 0.5);
    }

    /* IMAGEN DEL MAPA */
    .map-image {
        flex: 1;
        min-width: 50%;
        overflow: hidden;
    }

    .map-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.5s ease;
    }

    .valorant-map-card:hover .map-image img {
        transform: scale(1.08);
    }

    /* CONTENIDO DEL MAPA */
    .map-content {
        flex: 1;
        padding: 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .map-title {
        color: #D4AF37;
        font-size: 3rem;
        margin: 0 0 20px 0;
        line-height: 1.2;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-shadow: 0 2px 5px rgba(212, 175, 55, 0.3);
    }

    .map-description {
        color: #E0E0E0;
        font-size: 1.2rem;
        line-height: 1.7;
        margin-bottom: 30px;
    }

    /* BOTÓN */
    .map-btn {
        background: linear-gradient(135deg, #D4AF37 0%, #F5D98F 100%);
        border: none;
        border-radius: 50px;
        padding: 18px 45px;
        font-size: 1.3rem;
        font-weight: bold;
        color: #0A0A0A;
        box-shadow: 0 5px 25px rgba(212, 175, 55, 0.4);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        text-decoration: none;
        display: inline-block;
        align-self: flex-start;
        text-transform: uppercase;
        position: relative;
        overflow: hidden;
    }

    .map-btn:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 8px 30px rgba(212, 175, 55, 0.6);
        background: linear-gradient(135deg, #F5D98F 0%, #D4AF37 100%);
    }

    .map-btn:active {
        transform: translateY(1px);
    }

    /* EFECTO DE BRILLO EN BOTÓN */
    .map-btn::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(to bottom right,
                rgba(255, 255, 255, 0) 45%,
                rgba(255, 255, 255, 0.8) 50%,
                rgba(255, 255, 255, 0) 55%);
        transform: rotate(30deg);
        transition: all 0.5s;
    }

    .map-btn:hover::after {
        left: 100%;
    }

    /* DISEÑO RESPONSIVE */
    @media (max-width: 992px) {
        .valorant-map-card {
            flex-direction: column;
        }

        .map-image {
            min-height: 400px;
            order: 2;
            /* Imagen abajo en móvil */
        }

        .map-content {
            padding: 40px;
            order: 1;
            /* Contenido arriba en móvil */
        }
    }

    @media (max-width: 768px) {
        .valorant-maps-fullwidth {
            padding: 40px 0;
        }

        .map-title {
            font-size: 2.2rem;
        }

        .map-description {
            font-size: 1.1rem;
        }

        .map-btn {
            padding: 15px 35px;
            font-size: 1.1rem;
        }
    }

    @media (max-width: 480px) {
        .map-content {
            padding: 30px 20px;
        }

        .map-image {
            min-height: 300px;
        }
    }

    body {
        margin: 0;
        padding: 0;
        background-color: #000;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* CONTENEDOR PRINCIPAL QUE TOCA TODOS LOS BORDES */
    .valorant-edge-container {
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
        padding: 80px 0;
        background-color: #0A0A0A;
        border-top: 4px solid #D4AF37;
        border-bottom: 4px solid #D4AF37;
        box-shadow: 0 0 60px rgba(212, 175, 55, 0.3);
        overflow: hidden;
    }

    /* EFECTO DE BRILLO EN LOS BORDES */
    .valorant-edge-container::before,
    .valorant-edge-container::after {
        content: '';
        position: absolute;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg,
                transparent,
                rgba(255, 215, 0, 0.8),
                transparent);
        z-index: 2;
        animation: edgeShine 4s infinite linear;
    }

    .valorant-edge-container::before {
        top: -4px;
    }

    .valorant-edge-container::after {
        bottom: -4px;
    }

    @keyframes edgeShine {
        0% {
            transform: translateX(-100%);
        }

        100% {
            transform: translateX(100%);
        }
    }

    /* CONTENIDO INTERIOR */
    .edge-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        display: flex;
        flex-direction: row-reverse;
        /* Imagen derecha, texto izquierda */
        align-items: center;
        gap: 40px;
    }

    /* IMAGEN QUE TOCA LOS BORDES */
    .edge-image {
        flex: 1;
        min-width: 50%;
        height: 600px;
        overflow: hidden;
        position: relative;
    }

    .edge-image::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg,
                rgba(10, 10, 10, 0.8) 0%,
                transparent 30%,
                transparent 70%,
                rgba(10, 10, 10, 0.8) 100%);
        z-index: 1;
    }

    .edge-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    /* CONTENIDO DE TEXTO */
    .edge-text {
        flex: 1;
        padding: 40px;
    }

    .edge-title {
        color: #D4AF37;
        font-size: 3.5rem;
        margin: 0 0 30px 0;
        line-height: 1.1;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 3px;
    }

    .edge-subtitle {
        color: #F5D98F;
        font-size: 1.8rem;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .edge-description {
        color: #E0E0E0;
        font-size: 1.3rem;
        line-height: 1.8;
        margin-bottom: 40px;
    }

    /* BOTÓN QUE TOCA LOS BORDES */
    .edge-btn {
        display: inline-block;
        background: linear-gradient(135deg, #D4AF37 0%, #F5D98F 100%);
        border: none;
        border-radius: 50px;
        padding: 22px 55px;
        font-size: 1.5rem;
        font-weight: 700;
        color: #0A0A0A;
        text-transform: uppercase;
        text-decoration: none;
        box-shadow: 0 8px 35px rgba(212, 175, 55, 0.6);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
    }

    .edge-btn:hover {
        transform: translateY(-5px) scale(1.05);
        box-shadow: 0 12px 45px rgba(212, 175, 55, 0.8);
        background: linear-gradient(135deg, #F5D98F 0%, #D4AF37 100%);
    }

    .edge-btn::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(to bottom right,
                rgba(255, 255, 255, 0) 45%,
                rgba(255, 255, 255, 0.9) 50%,
                rgba(255, 255, 255, 0) 55%);
        transform: rotate(30deg);
        transition: all 0.8s;
    }

    .edge-btn:hover::after {
        left: 100%;
    }

    /* DISEÑO RESPONSIVE */
    @media (max-width: 1200px) {
        .edge-title {
            font-size: 3rem;
        }

        .edge-image {
            height: 500px;
        }
    }

    @media (max-width: 992px) {
        .edge-content {
            flex-direction: column;
        }

        .edge-image {
            width: 100%;
            height: 400px;
            order: 2;
        }

        .edge-text {
            order: 1;
            padding: 30px 20px;
        }

        .edge-title {
            font-size: 2.5rem;
        }
    }

    @media (max-width: 768px) {
        .valorant-edge-container {
            padding: 60px 0;
        }

        .edge-title {
            font-size: 2.2rem;
        }

        .edge-subtitle {
            font-size: 1.5rem;
        }

        .edge-description {
            font-size: 1.1rem;
        }

        .edge-btn {
            padding: 18px 45px;
            font-size: 1.3rem;
        }
    }

    @media (max-width: 576px) {
        .edge-image {
            height: 350px;
        }

        .edge-title {
            font-size: 1.8rem;
            letter-spacing: 2px;
        }

        .edge-btn {
            padding: 15px 40px;
            font-size: 1.1rem;
        }
    }
</style>

<body>
    <!-- Barra de navegación -->
    <div class="game-bar">
        <div class="nav-container">
            <!-- IZQUIERDA: LOGO -->
            <div class="logo-section">
                <a href="index.php">
                    <img src="imglogo/GGO.png" alt="GG Operación" style="height: 60px;">
                </a>
            </div>

            <!-- CENTRO: JUEGOS -->
            <div class="games-section">
                <div class="game-scroller">
                    <a href="Fornite.php" class="game-item ">
                        <img src="imglogo/fornite.png" class="game-icon" alt="Fortnite">
                        <span>Fortnite</span>
                    </a>
                    <a href="Valorant.php" class="game-item">
                        <img src="imglogo/valorant.png" class="game-icon" alt="Valorant">
                        <span>Valorant</span>
                    </a>
                    <a href="lol.php" class="game-item">
                        <img src="imglogo/LOL.png" class="game-icon" alt="League of Legends">
                        <span>League of Legends</span>
                    </a>
                    <a href="Overwacht.php" class="game-item">
                        <img src="imglogo/over.png" class="game-icon" alt="Overwacht">
                        <span>Overwacht</span>
                    </a>
                    
                    <a href="Descubre.php" class="game-item">
                        <span>Descubre y disfruta</span>
                    </a>
                </div>
            </div>

            <!-- DERECHA: MENÚ HAMBURGUESA -->
            <div class="menu-section">
                <i class="fas fa-bars hamburger-menu"></i>
            </div>
        </div>
    </div>
    <!-- Sección Hero con Video de Fortnite -->
    <div class="fortnite-hero">
        <!-- Video de fondo -->
        <video autoplay muted loop id="fortniteVideo" class="video-bg">
            <source src="imglogo/Trailers/trailerover.mp4" type="video/mp4">
            <!-- Si el video no carga, muestra la imagen de fondo -->
            Tu navegador no soporta videos HTML5.
        </video>

        <!-- Botón de pausa -->
        <div class="pause-btn" id="pauseBtn">
            <i class="fas fa-pause pause-icon" id="pauseIcon"></i>
        </div>

        <div class="container hero-content">
            <h1 class="fortnite-title">OVERWATCH</h1>
            <h2 class="fortnite-subtitle">EL FUTURO DE LA HUMANIDAD ESTÁ EN TUS MANOS</h2>
            <p class="fortnite-cta">LUCHA POR LA TIERRA</p>
            <a href="https://www.blizzard.com/download/confirmation?product=ow&blzcmp=ow_gamesite" target="_blank" rel="noopener noreferrer"
                class="fortnite-btn-link">
                <button class="fortnite-btn">ÚNETE A LA BATALLA</button>
            </a>
        </div>
    </div>
    <h1 class="news-title"
        style="text-align: center; width: 100%; margin: 40px 0; font-size: 4rem; font-weight: 900; text-transform: uppercase; color:rgba(212, 175, 55, 0.5); letter-spacing: 2px;">
        NOTICIAS </h1>

    <div class="fullwidth-news-container">
        <div class="news-inner-container">
            <div class="fortnite-news-container">
                <!-- Noticia 1 - Season 17 -->
                <a href="https://overwatch.blizzard.com/en-us/news/24206339/get-powered-up-in-overwatch-2-season-17/"
                    class="fortnite-news-card" target="_blank">
                    <div class="news-image">
                        <img src="imglogo/ACTULIZACIONOVER1.jpg" alt="Overwatch 2 Season 17: Powered Up">
                    </div>
                    <div class="news-content">
                        <h3 class="news-title">Overwatch 2 Season 17: Powered Up</h3>
                        <p class="news-body">La temporada 17 de Overwatch 2 llega con nuevo contenido, incluyendo el
                            modo Power Swap, nuevas recompensas y ajustes de equilibrio para varios héroes.</p>
                        <div class="news-link">Ver noticia completa →</div>
                    </div>
                </a>

                <!-- Noticia 2 - Weekly Recall -->
                <a href="https://overwatch.blizzard.com/en-us/news/24214498/weekly-recall-the-balancing-act/"
                    class="fortnite-news-card" target="_blank">
                    <div class="news-image">
                        <img src="imglogo/ACTULIZACIONOVER2.png" alt="Weekly Recall: The Balancing Act">
                    </div>
                    <div class="news-content">
                        <h3 class="news-title">Weekly Recall: The Balancing Act</h3>
                        <p class="news-body">Un análisis detallado de los cambios de equilibrio más recientes en
                            Overwatch 2, con insights del equipo de desarrollo sobre las decisiones tomadas.</p>
                        <div class="news-link">Ver artículo completo →</div>
                    </div>
                </a>

                <!-- Noticia 3 - Journey to Season 17 -->
                <a href="https://overwatch.blizzard.com/en-us/news/24215411/weekly-recall-journey-to-season-17/"
                    class="fortnite-news-card" target="_blank">
                    <div class="news-image">
                        <img src="imglogo/ACTULIZACIONOVER3.png" alt="Journey to Season 17">
                    </div>
                    <div class="news-content">
                        <h3 class="news-title">Journey to Season 17</h3>
                        <p class="news-body">Un recorrido por el desarrollo de la Temporada 17, incluyendo los desafíos
                            del equipo para crear el nuevo modo Power Swap y los ajustes de héroes.</p>
                        <div class="news-link">Ver reportaje completo →</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="valorant-container">
        <div class="valorant-card">
            <!-- Image Section -->
            <div class="valorant-image">
                <img src="imglogo/heroresva.png" alt="Héroes Overwatch">
            </div>

            <!-- Content Section -->
            <div class="valorant-content">
                <h2 class="valorant-title">TUS HÉROES</h2>
                <p class="valorant-body">
                    EL TRABAJO EN EQUIPO ES TU MEJOR ARMA.<br><br>
                    Más allá de las armas, elige entre tanques, daño y apoyo, cada uno con habilidades únicas que se
                    combinan estratégicamente.
                    Ningún héroe juega igual, y cada sinergia de equipo crea momentos épicos irrepetibles.
                </p>
                <a href="overwachtcontenido.php?seccion=heroes" class="valorant-btn">VER TODOS LOS HÉROES</a>
            </div>
        </div>
    </div>
    <div class="valorant-container">
        <div class="valorant-card">
            <!-- Image Section -->
            <div class="valorant-image">
                <img src="imglogo/mapaove.png" alt="Mapas Overwatch">
            </div>

            <!-- Content Section -->
            <div class="valorant-content">
                <h2 class="valorant-title">DOMINA LOS ESCENARIOS</h2>
                <p class="valorant-body">
                    CADA MAPA ES UN NUEVO DESAFÍO.<br><br>
                    Desde las calles futuristas de Numbani hasta los templos de Nepal, cada escenario en Overwatch
                    ofrece rutas tácticas y puntos clave.
                    Controla las zonas elevadas, flanquea al enemigo y usa el entorno para lograr la victoria.
                </p>
                <a href="overwachtcontenido.php?seccion=maps" class="valorant-btn">EXPLORAR MAPAS</a>
            </div>
        </div>
    </div>
    <div class="valorant-container">
        <div class="valorant-card">
            <!-- Image Section -->
            <div class="valorant-image">
                <img src="imglogo/modoover.png" alt="Modos Overwatch">
            </div>

            <!-- Content Section -->
            <div class="valorant-content">
                <h2 class="valorant-title">EXPERIENCIAS ÚNICAS</h2>
                <p class="valorant-body">
                    MÁS ALLÁ DEL COMBATE BÁSICO.<br><br>
                    Desde el clásico "Payload" hasta los eventos estacionales y el competitivo, cada modo en Overwatch
                    prueba habilidades diferentes.
                    Adapta tu estrategia, coordina con tu equipo y vive experiencias que solo este juego puede ofrecer.
                </p>
                <a href="overwachtcontenido.php?seccion=gamemodes" class="valorant-btn">VER MODOS DE JUEGO</a>
            </div>
        </div>
    </div>


    <div class="custom-footer">
        <div class="footer-content">
            <div class="footer-logo">
                <img src="imglogo/GGO.png" alt="GGOperación Logo">
            </div>

            <div class="footer-games">
                <a href="Valorant.php" class="game-item">Valorant</a>
                <a href="lol.php" class="game-item">League of Legends</a>
                <a href="Fornite.php" class="game-item">Fortnite</a>
                <a href="Descubre.php" class="game-item">Descubre y disfruta</a>
            </div>

            <div class="footer-social">
                <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-discord"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
            </div>
        </div>

        <div class="footer-bottom">
            <p>© 2025 GGOperación. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Activar el juego seleccionado
    document.querySelectorAll('.game-item').forEach(item => {
        item.addEventListener('click', function () {
            document.querySelectorAll('.game-item').forEach(i => i.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Menú hamburguesa (placeholder funcional)
    document.querySelector('.hamburger-menu').addEventListener('click', function (e) {
        e.stopPropagation();
        alert('Menú desplegable activado');
    });

    // Barra arrastrable horizontal (con mouse)
    let isDown = false;
    let startX;
    let scrollLeft;
    const scroller = document.querySelector('.game-scroller');

    scroller.addEventListener('mousedown', (e) => {
        isDown = true;
        startX = e.pageX - scroller.offsetLeft;
        scrollLeft = scroller.scrollLeft;
    });

    scroller.addEventListener('mouseleave', () => {
        isDown = false;
    });

    scroller.addEventListener('mouseup', () => {
        isDown = false;
    });

    scroller.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - scroller.offsetLeft;
        const walk = (x - startX) * 2;
        scroller.scrollLeft = scrollLeft - walk;
    });
    const video = document.getElementById('fortniteVideo');
    const pauseBtn = document.getElementById('pauseBtn');
    const pauseIcon = document.getElementById('pauseIcon');
    let isPlaying = true;

    // Controlar pausa/play del video
    pauseBtn.addEventListener('click', function () {
        if (isPlaying) {
            video.pause();
            pauseIcon.classList.remove('fa-pause');
            pauseIcon.classList.add('fa-play');
        } else {
            video.play();
            pauseIcon.classList.remove('fa-play');
            pauseIcon.classList.add('fa-pause');
        }
        isPlaying = !isPlaying;
    });

    // Reiniciar video si termina (opcional)
    video.addEventListener('ended', function () {
        video.currentTime = 0;
        video.play();
    });
</script>


</html>