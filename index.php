<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GG Operación</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome para íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="CSS/styleindex.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
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

        /* Carrusel mejorado y más grande */
        .carousel-container {
            width: 200%;
            max-width: 1900px;
            margin: 50px auto;
            position: relative;
        }

        .carousel {
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            gap: 30px;
            padding: 40px;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }

        .carousel::-webkit-scrollbar {
            display: none;
        }

        .game-card {
            scroll-snap-align: start;
            min-width: 400px;
            height: 600px;
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            flex-shrink: 0;
            background-size: cover;
            background-position: center;
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.4);
        }

        .game-card.collapsed {
            width: 400px;
        }

        .game-card.expanded {
            width: 800px;
        }

        .game-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 40px;
            background: linear-gradient(transparent, rgba(109, 109, 109, 0.9));
            transition: all 0.4s ease;
        }

        .game-card.collapsed .game-overlay {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.7);
        }

        .game-title {
            font-size: 42px;
            font-weight: bold;
            margin-bottom: 30px;
            text-shadow: 3px 3px 8px rgb(0, 0, 0);
            text-align: center;
            text-decoration: #101113;
        }


        .game-card.collapsed .game-title {
            font-size: 28px;
            margin-bottom: 0;
        }

        .explore-btn {
            display: inline-block;
            padding: 15px 40px;
            background: rgb(0, 0, 0);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.4s ease;
            border: 3px solid rgba(255, 255, 255, 0.3);
        }

        .explore-btn:hover {
            background: rgb(0, 0, 0);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }

        .game-card.expanded .explore-btn {
            opacity: 1;
            transform: translateY(0);
        }

        .game-card.collapsed .explore-btn {
            display: none;
        }

        .nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 80px;
            height: 80px;
            background: rgba(0, 0, 0, 0);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            border: none;
            color: white;
            transition: all 0.3s;
        }

        .nav-btn:hover {
            background: rgba(0, 0, 0, 0);
            transform: translateY(-50%) scale(1.1);
        }

        .prev-btn {
            left: 10px;
        }

        .next-btn {
            right: 10px;
        }

        /* Efecto de hover para las tarjetas */
        .game-card:hover:not(.expanded) {
            transform: translateY(-15px);
            box-shadow: 0 20px 40px rgb(0, 0, 0);
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

        /* Sección de video (izquierda) */
        .video-content {
            flex: 1;
            padding: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            background-color: rgba(10, 10, 10, 0.9);
        }

        .video-container {
            width: 100%;
            height: 70%;
            border: 3px solid var(--primary-gold);
            box-shadow: 0 0 30px rgba(212, 175, 55, 0.3);
            overflow: hidden;
            position: relative;
        }

        .video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.1) 0%, rgba(10, 10, 10, 0.8) 100%);
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .play-button {
            width: 80px;
            height: 80px;
            background-color: var(--primary-gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
            cursor: pointer;
            transition: all 0.3s;
        }

        .play-button:hover {
            transform: scale(1.1);
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.7);
        }

        .play-icon {
            color: var(--primary-dark);
            font-size: 30px;
            margin-left: 5px;
        }

        /* Sección de texto (derecha) */
        .text-content {
            flex: 1;
            padding: 80px 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: rgba(15, 15, 15, 0.95);
            position: relative;
        }

        .text-content::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 3px;
            background: linear-gradient(to bottom, var(--primary-gold), transparent);
        }

        .pre-title {
            color: var(--primary-gold);
            font-size: 1rem;
            font-weight: 600;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 3.2rem;
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 30px;
            text-transform: uppercase;
        }

        .section-title span {
            color: var(--primary-gold);
            position: relative;
        }

        .section-title span::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--primary-gold);
        }

        .section-text {
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 30px;
            color: var(--text-light);
            max-width: 500px;
        }

        .section-text span {
            color: var(--secondary-gold);
            font-weight: 600;
        }

        .divider {
            width: 100px;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-gold), transparent);
            margin: 30px 0;
        }

        /* Patrón decorativo */
        .gold-pattern {
            position: absolute;
            bottom: 20px;
            right: 20px;
            opacity: 0.1;
            z-index: 0;
        }



        .text-content,
        .video-content {
            padding: 50px 30px;
        }

        .section-title {
            font-size: 2.3rem;
        }

        .text-content::before {
            width: 100%;
            height: 3px;
            top: 0;
            left: 0;
            background: linear-gradient(to right, var(--primary-gold), transparent);
        }

        :root {
            --primary-dark: #0A0A0A;
            --primary-gold: #D4AF37;
            --secondary-gold: #F5D98F;
            --text-light: #F0F0F0;
        }

        .fullwidth-about {
            width: 100%;
            display: flex;
            min-height: 400px;
            background-color: var(--primary-dark);
        }

        .fullwidth-video {
            flex: 1;
            min-width: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
            position: relative;
        }

        .fullwidth-video-container {
            width: 100%;
            height: 100%;
            max-height: 500px;
            border: 3px solid var(--primary-gold);
            box-shadow: 0 0 25px rgba(212, 175, 55, 0.3);
            overflow: hidden;
            position: relative;
        }

        .fullwidth-text {
            flex: 1;
            min-width: 50%;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .fullwidth-text::before {
            content: '';
            position: absolute;
            left: 0;
            top: 40px;
            bottom: 40px;
            width: 3px;
            background: linear-gradient(to bottom, var(--primary-gold), transparent);
        }

        .fullwidth-pre-title {
            color: var(--primary-gold);
            font-size: 1rem;
            font-weight: 600;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 15px;
        }

        .fullwidth-title {
            font-size: 2.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 20px;
            color: var(--text-light);
        }

        .fullwidth-title span {
            color: var(--primary-gold);
            position: relative;
        }

        .fullwidth-title span::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--primary-gold);
        }

        .fullwidth-divider {
            width: 80px;
            height: 2px;
            background: var(--primary-gold);
            margin: 20px 0;
        }

        .fullwidth-content {
            font-size: 1.1rem;
            line-height: 1.7;
            color: var(--text-light);
            max-width: 600px;
        }

        .fullwidth-content span {
            color: var(--secondary-gold);
            font-weight: 600;
        }

        @media (max-width: 992px) {
            .fullwidth-about {
                flex-direction: column;
            }

            .fullwidth-video,
            .fullwidth-text {
                min-width: 100%;
            }

            .fullwidth-text::before {
                width: 100px;
                height: 3px;
                top: 0;
                left: 40px;
                background: linear-gradient(to right, var(--primary-gold), transparent);
            }

            .fullwidth-video-container {
                max-height: 400px;
            }
        }

        @media (max-width: 576px) {
            .fullwidth-title {
                font-size: 2rem;
            }

            .fullwidth-content {
                font-size: 1rem;
            }
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
    </style>
</head>

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

    <!-- Carrusel mejorado y más grande -->
    <div class="carousel-container">
        <button class="nav-btn prev-btn">
            <i class="bi bi-chevron-left"></i>
        </button>

        <div class="carousel">
            <!-- Fortnite -->
            <div class="game-card collapsed"
                style="background-image: url('imglogo/img/fornite.jpg');"
                onclick="toggleCard(this)">
                <div class="game-overlay">
                    <div>
                        <div class="game-title">FORTNITE</div>
                        <a href="Fornite.php" class="explore-btn">EXPLORA</a>
                    </div>
                </div>
            </div>
            <!-- League of Legends -->
            <div class="game-card collapsed"
                style="background-image: url('imglogo/img/LOL.jpg');"
                onclick="toggleCard(this)">
                <div class="game-overlay">
                    <div>
                        <div class="game-title">LEAGUE OF LEGENDS</div>
                        <a href="lol.php" class="explore-btn">EXPLORA</a>
                    </div>
                </div>
            </div>

            <!-- Valorant -->
            <div class="game-card collapsed"
                style="background-image: url('imglogo/img/valorant.jpg');"
                onclick="toggleCard(this)">
                <div class="game-overlay">
                    <div>
                        <div class="game-title">VALORANT</div>
                        <a href="Valorant.php" class="explore-btn">EXPLORA</a>
                    </div>
                </div>
            </div>
            <div class="game-card collapsed"
                style="background-image: url('imglogo/img/over.jpg');"
                onclick="toggleCard(this)">
                <div class="game-overlay">
                    <div>
                        <div class="game-title">Overwacht</div>
                        <a href="Overwacht.php" class="explore-btn">EXPLORA</a>
                    </div>
                </div>
            </div>
        </div>

        <button class="nav-btn next-btn">
            <i class="bi bi-chevron-right"></i>
        </button>
    </div>
    <div class="fullwidth-about">
        <div class="fullwidth-video">
            <div class="fullwidth-video-container">
                <video width="100%" height="100%" autoplay muted loop>
                    <source src="imglogo/GGvideo.mp4" type="video/mp4">
                    Tu navegador no soporta el elemento de video.
                </video>
            </div>
        </div>

        <div class="fullwidth-text">
            <div class="fullwidth-pre-title">Que Somos?</div>
            <h2 class="fullwidth-title">Bienvenido a <span>GGOperación</span></h2>
            <div class="fullwidth-divider"></div>
            <p class="fullwidth-content">
                Aquí comienza tu misión gamer.<br>
                En GGOperación encontrarás las especificaciones detalladas de los videojuegos más importantes.<br>
                Nuestra herramienta ofrece información estratégica para <span>mejorar tu experiencia</span>, evolucionar tu forma de jugar y descubrir nuevas formas de jugar.<br>
                <span>El juego cambió. Ahora mandas tú con GGOperación.</span>
            </p>
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
    </div>



    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Activar el juego seleccionado
        document.querySelectorAll('.game-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.game-item').forEach(i => i.classList.remove('active'));
                this.classList.add('active');
                // No bloqueamos el enlace
            });
        });


        // Menú hamburguesa
        document.querySelector('.hamburger-menu').addEventListener('click', function(e) {
            e.stopPropagation();
            alert('Menú desplegable activado');
        });

        // Barra arrastrable
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

        // Carrusel expandible
        function toggleCard(card) {
            const allCards = document.querySelectorAll('.game-card');
            const wasExpanded = card.classList.contains('expanded');

            allCards.forEach(item => {
                item.classList.remove('expanded');
                item.classList.add('collapsed');
            });

            if (!wasExpanded) {
                card.classList.remove('collapsed');
                card.classList.add('expanded');

                card.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest',
                    inline: 'center'
                });
            }
        }

        // Variables para el carrusel automático
        const carousel = document.querySelector('.carousel');
        const cards = document.querySelectorAll('.game-card');
        const cardWidth = 430; // 400px de ancho + 30px de gap
        let autoScrollInterval;
        let isUserInteracting = false;
        let resumeTimeout;

        // Clonar los elementos para el efecto infinito
        cards.forEach(card => {
            const clone = card.cloneNode(true);
            carousel.appendChild(clone);
        });

        // Función para mover el carrusel
        function moveCarousel() {
            if (isUserInteracting) return;

            const currentScroll = carousel.scrollLeft;
            const maxScroll = carousel.scrollWidth - carousel.clientWidth;

            // Si estamos al final, volver al inicio sin animación
            if (currentScroll >= maxScroll - cardWidth) {
                carousel.scrollTo({
                    left: 0,
                    behavior: 'instant'
                });
            } else {
                carousel.scrollBy({
                    left: cardWidth,
                    behavior: 'smooth'
                });
            }
        }

        // Iniciar el movimiento automático
        function startAutoScroll() {
            if (autoScrollInterval) clearInterval(autoScrollInterval);
            autoScrollInterval = setInterval(moveCarousel, 3000); // Mover cada 3 segundos
        }

        // Detener el movimiento automático cuando el usuario interactúa
        function handleUserInteraction() {
            isUserInteracting = true;
            if (autoScrollInterval) clearInterval(autoScrollInterval);

            // Limpiar timeout anterior si existe
            if (resumeTimeout) clearTimeout(resumeTimeout);

            // Reanudar después de 10 segundos sin interacción
            resumeTimeout = setTimeout(() => {
                isUserInteracting = false;
                startAutoScroll();
            }, 10000);
        }

        // Navegación con botones
        document.querySelector('.prev-btn').addEventListener('click', () => {
            handleUserInteraction();
            carousel.scrollBy({
                left: -cardWidth,
                behavior: 'smooth'
            });
        });

        document.querySelector('.next-btn').addEventListener('click', () => {
            handleUserInteraction();
            carousel.scrollBy({
                left: cardWidth,
                behavior: 'smooth'
            });
        });

        // Eventos de interacción del usuario
        carousel.addEventListener('mousedown', handleUserInteraction);
        carousel.addEventListener('touchstart', handleUserInteraction);
        carousel.addEventListener('wheel', handleUserInteraction);
        document.querySelectorAll('.game-card').forEach(card => {
            card.addEventListener('click', handleUserInteraction);
        });

        // Iniciar el carrusel automático al cargar la página
        window.addEventListener('load', () => {
            startAutoScroll();
        });

        // Manejar el redimensionamiento de la ventana
        window.addEventListener('resize', () => {
            // Asegurarse de que el carrusel esté en una posición válida
            const currentScroll = carousel.scrollLeft;
            const maxScroll = carousel.scrollWidth - carousel.clientWidth;

            if (currentScroll > maxScroll) {
                carousel.scrollTo({
                    left: maxScroll,
                    behavior: 'instant'
                });
            }
        });
        document.querySelector('.fullwidth-play-btn').addEventListener('click', function() {
            const container = document.querySelector('.fullwidth-video-container');
            container.innerHTML = `
                <video width="100%" height="100%" autoplay muted loop controls>
                    <source src="tu-video.mp4" type="video/mp4">
                </video>
            `;
        });
    </script>
</body>

</html>