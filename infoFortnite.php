<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modos de Fortnite</title>
    <style>
        :root {
            --primary-dark: #0A0A0A;
            --primary-gold: #D4AF37;
            --secondary-gold: #F5D98F;
            --text-light: #F0F0F0;
            --text-gray: #A0A0A0;
            --footer-bg: #111214;
        }

        body {
            font-family: 'Montserrat', 'Helvetica Neue', Arial, sans-serif;
            background-color: var(--primary-dark);
            color: var(--text-light);
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* BARRA DE NAVEGACIÓN SUPERIOR */
        .game-bar {
            background-color: var(--gamebar-bg);
            border-bottom: 1px solid var(--gamebar-border);
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.5);
        }

        .nav-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1600px;
            margin: 0 auto;
            padding: 0 20px;
            height: 80px;
        }

        .logo-section {
            flex-shrink: 0;
            padding-right: 30px;
        }

        .logo-section img {
            height: 60px;
            transition: transform 0.3s ease;
        }

        .logo-section img:hover {
            transform: scale(1.05);
        }

        .games-section {
            flex-grow: 1;
            height: 100%;
            display: flex;
            justify-content: center;
            overflow: hidden;
        }

        .game-scroller {
            display: flex;
            height: 100%;
            align-items: center;
            overflow-x: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .game-scroller::-webkit-scrollbar {
            display: none;
        }

        .game-item {
            display: inline-flex;
            align-items: center;
            color: var(--gamebar-text);
            margin: 0 8px;
            padding: 8px 15px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            text-decoration: none;
            white-space: nowrap;
            height: 50px;
            border: 1px solid transparent;
        }

        .game-item:hover {
            background-color: var(--gamebar-highlight);
            color: var(--gamebar-hover);
            transform: translateY(-2px);
            border-color: rgba(212, 175, 55, 0.3);
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.15);
        }

        .game-item.active {
            color: var(--gamebar-active);
            position: relative;
            font-weight: 600;
        }

        .game-item.active::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60%;
            height: 3px;
            background: var(--gamebar-active);
            border-radius: 3px;
        }

        .game-icon {
            width: 28px;
            height: 28px;
            margin-right: 10px;
            object-fit: contain;
            filter: grayscale(30%);
            transition: all 0.3s;
        }

        .game-item:hover .game-icon {
            filter: grayscale(0%) brightness(1.2);
            transform: scale(1.1);
        }

        .menu-section {
            flex-shrink: 0;
            padding-left: 30px;
        }

        .hamburger-menu {
            color: var(--gamebar-text);
            font-size: 1.8rem;
            cursor: pointer;
            transition: all 0.3s;
            padding: 10px;
            border-radius: 50%;
        }

        .hamburger-menu:hover {
            color: var(--gamebar-active);
            background-color: var(--gamebar-highlight);
            transform: rotate(90deg);
        }

        /* CONTENEDOR PRINCIPAL */
        .fullwidth-container {
            width: 100vw;
            position: relative;
            left: 50%;
            right: 50%;
            margin-left: -50vw;
            margin-right: -50vw;
            padding: 60px 0;
            background-color: var(--primary-dark);
            border-top: 3px solid var(--primary-gold);
            border-bottom: 3px solid var(--primary-gold);
        }

        .inner-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* TÍTULO DE SECCIÓN */
        .section-title {
            color: var(--primary-gold);
            font-size: 3rem;
            text-align: center;
            margin-bottom: 40px;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 0 2px 5px rgba(212, 175, 55, 0.3);
        }

        /* NAVEGACIÓN SECUNDARIA */
        .nav-menu {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 40px;
            padding: 15px 0;
            border-bottom: 1px solid rgba(212, 175, 55, 0.3);
        }

        .nav-link {
            color: var(--secondary-gold);
            text-decoration: none;
            font-size: 1.2rem;
            font-weight: 600;
            text-transform: uppercase;
            transition: all 0.3s;
            padding: 5px 15px;
            border-radius: 4px;
        }

        .nav-link:hover {
            color: var(--primary-gold);
            background-color: rgba(212, 175, 55, 0.1);
        }

        /* SECCIÓN DE MODOS DE JUEGO */
        .modos-container {
            padding: 40px 0;
        }

        .grid-modos {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 30px;
        }

        .modo-card {
            background: rgba(10, 10, 10, 0.8);
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(212, 175, 55, 0.3);
            cursor: pointer;
        }

        .modo-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(212, 175, 55, 0.3);
            border-color: rgba(212, 175, 55, 0.5);
        }

        .modo-img-container {
            height: 150px;
            overflow: hidden;
        }

        .modo-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .modo-card:hover .modo-img-container img {
            transform: scale(1.1);
        }

        .modo-title-container {
            padding: 20px;
            background: linear-gradient(to right, #1a1a1a, var(--primary-dark));
            text-align: center;
            border-top: 1px solid rgba(212, 175, 55, 0.2);
        }

        .modo-title-container h3 {
            margin: 0;
            color: var(--secondary-gold);
            font-size: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* SECCIÓN DETALLADA DE MODO */
        .modo-detallado {
            margin-top: 60px;
            border-top: 1px solid rgba(212, 175, 55, 0.3);
            padding-top: 40px;
        }

        .modo-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            gap: 30px;
        }

        .modo-icon {
            width: 100px;
            height: 100px;
            object-fit: contain;
        }

        .modo-info h2 {
            color: var(--primary-gold);
            font-size: 2.5rem;
            margin: 0 0 10px 0;
            text-transform: uppercase;
        }

        .modo-info p {
            color: var(--text-light);
            margin: 0;
            font-size: 1.1rem;
        }

        .modo-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .modo-descripcion {
            color: var(--text-light);
            line-height: 1.6;
            font-size: 1.1rem;
        }

        .modo-caracteristicas h3 {
            color: var(--secondary-gold);
            font-size: 1.5rem;
            margin-top: 0;
        }

        .caracteristica-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .caracteristica-icon {
            width: 24px;
            height: 24px;
            margin-right: 10px;
            color: var(--primary-gold);
        }

        /* FOOTER */
        .custom-footer {
            background-color: var(--footer-bg);
            padding: 30px 20px;
            border-top: 2px solid var(--primary-gold);
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

        .footer-logo {
            flex: 1;
            min-width: 150px;
        }

        .footer-logo img {
            max-width: 100px;
            height: auto;
        }

        .footer-games {
            flex: 2;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            padding: 0 15px;
        }

        .footer-games .game-item {
            background-color: rgba(255, 255, 255, 0.08);
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 0.9rem;
            color: var(--text-light);
            transition: all 0.3s;
            cursor: pointer;
            margin: 0;
        }

        .footer-games .game-item:hover {
            background-color: var(--primary-gold);
            color: var(--primary-dark);
            transform: translateY(-2px);
        }

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
            color: var(--text-light);
            transition: all 0.3s;
        }

        .social-icon:hover {
            background-color: var(--primary-gold);
            color: var(--primary-dark);
            transform: scale(1.1);
        }

        .footer-bottom {
            text-align: center;
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.6);
        }

        /* RESPONSIVE */
        @media (max-width: 1200px) {
            .section-title {
                font-size: 2.5rem;
            }
            
            .modo-content {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 992px) {
            .nav-container {
                padding: 0 15px;
            }

            .games-section {
                justify-content: flex-start;
            }

            .game-item span {
                display: none;
            }

            .game-item {
                margin: 0 5px;
                padding: 8px;
                justify-content: center;
            }

            .game-icon {
                margin-right: 0;
            }

            .nav-menu {
                flex-wrap: wrap;
                gap: 15px;
            }

            .nav-link {
                font-size: 1rem;
            }

            .grid-modos {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }

            .modo-header {
                flex-direction: column;
                text-align: center;
            }

            .footer-content {
                flex-direction: column;
            }

            .footer-logo, .footer-social {
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

        @media (max-width: 768px) {
            .nav-container {
                height: 70px;
            }

            .logo-section img {
                height: 50px;
            }

            .game-scroller {
                padding: 0 10px;
            }

            .section-title {
                font-size: 2rem;
            }

            .grid-modos, .shop-container, .grid-cosmeticos {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 15px;
            }

            .modo-title-container h3 {
                font-size: 1.2rem;
            }

            .modo-detallado {
                margin-top: 40px;
            }
        }

        @media (max-width: 576px) {
            .logo-section {
                padding-right: 15px;
            }

            .menu-section {
                padding-left: 15px;
            }

            .hamburger-menu {
                font-size: 1.5rem;
                padding: 8px;
            }

            .section-title {
                font-size: 1.8rem;
            }

            .grid-modos, .shop-container, .grid-cosmeticos {
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            }

            .modo-img-container {
                height: 120px;
            }

            .modo-info h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
   <!-- Barra de navegación -->
    <div class="game-bar">
        <div class="nav-container">
            <div class="logo-section">
                <a href="index.php">
                    <img src="imglogo/GGO.png" alt="GG Operación" style="height: 60px;">
                </a>
            </div>

            <div class="games-section">
                <div class="game-scroller">
                    <a href="Fornite.php" class="game-item active">
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

            <div class="menu-section">
                <i class="fas fa-bars hamburger-menu"></i>
            </div>
        </div>
    </div>    
                  <!-- DETALLE DE MODO SELECCIONADO -->
                <div class="modo-detallado">
                    <div class="modo-header">
                        <img src="modofornite/Battle_Royale_-_Playlist_-_Fortnite.webp" class="modo-icon" alt="Battle Royale">
                        <div class="modo-info">
                            <h2>Battle Royale</h2>
                            <p>El modo clásico de Fortnite</p>
                        </div>
                    </div>
                    
                    <div class="modo-content">
                        <div class="modo-descripcion">
                            <p>Battle Royale (Batalla Campal en español latinoamericano), es un modo JcJ (Jugador contra jugador) en Fortnite que se lanzó el 26 de septiembre de 2017. Los jugadores deben caer en una isla y luchar para ser el último sobreviviente en solitario, dúos, tríos o escuadrón. En este modo, la construcción está habilitada. Un modo similar pero sin construir es Cero Construcción.</p>
                            
                            <h3>Jugabilidad</h3>
                            <p><strong>Empezando una partida:</strong> Al ingresar a una partida de Battle Royale, los jugadores aparecerán en la Isla de aparición, un lugar donde pueden esperar hasta que el autobús de batalla esté listo para sobrevolar la isla. Al ingresar al autobús de batalla, los jugadores tendrán 15 segundos para saltar y lanzarse en paracaídas hacia cualquier lugar de la isla que deseen. Los jugadores comienzan con 100 de salud y 0 escudos.</p>
                            
                            <p><strong>La tormenta:</strong> Después de un minuto, el Ojo de la Tormenta, una zona segura, se marcará en el Minimapa. Los jugadores tienen aproximadamente 3 minutos hasta que La Tormenta comience a acercarse. Después de que la tormenta llegue al ojo, comienza otro período de gracia y el ojo de la tormenta se encoge. Este proceso se repite hasta que termina la partida.</p>
                        </div>
                        
                        <div class="modo-caracteristicas">
                            <h3>Características principales</h3>
                            
                            <div class="caracteristica-item">
                                <svg class="caracteristica-icon" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M11,16.5L18,9.5L16.59,8.09L11,13.67L7.91,10.59L6.5,12L11,16.5Z" />
                                </svg>
                                <span>Construcción habilitada</span>
                            </div>
                            
                            <div class="caracteristica-item">
                                <svg class="caracteristica-icon" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M11,16.5L18,9.5L16.59,8.09L11,13.67L7.91,10.59L6.5,12L11,16.5Z" />
                                </svg>
                                <span>100 jugadores por partida</span>
                            </div>
                            
                            <div class="caracteristica-item">
                                <svg class="caracteristica-icon" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M11,16.5L18,9.5L16.59,8.09L11,13.67L7.91,10.59L6.5,12L11,16.5Z" />
                                </svg>
                                <span>Modos: Solitario, Dúo, Trío, Escuadrón</span>
                            </div>
                            
                            <div class="caracteristica-item">
                                <svg class="caracteristica-icon" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M11,16.5L18,9.5L16.59,8.09L11,13.67L7.91,10.59L6.5,12L11,16.5Z" />
                                </svg>
                                <span>Sistema de temporadas con Pase de Batalla</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
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
</html>