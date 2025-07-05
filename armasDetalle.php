<?php
if (!isset($_GET['uuid'])) {
    die("Arma no especificada.");
}

$uuid = htmlspecialchars($_GET['uuid']);
$weaponUrl = "https://valorant-api.com/v1/weapons/{$uuid}?language=es-MX";
$weaponResponse = file_get_contents($weaponUrl);
$weaponData = json_decode($weaponResponse, true);

if (!$weaponData || $weaponData['status'] !== 200) {
    die("No se pudo cargar la información del arma.");
}

$arma = $weaponData['data'];

$skinsFiltradas = array_filter($arma['skins'], function ($skin) {
    $nombre = strtolower($skin['displayName']);
    $tieneImagen = !empty($skin['displayIcon']) || !empty($skin['fullRender']);
    return $tieneImagen
        && strpos($nombre, 'estándar') === false
        && strpos($nombre, 'standard') === false
        && strpos($nombre, 'diseño favorito aleatorio') === false
        && strpos($nombre, 'random favorite skin') === false;
});

// Convertir a array indexado para facilitar el acceso
$skinsArray = array_values($skinsFiltradas);
?>

<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <title><?= $arma['displayName'] ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* BARRA DE NAVEGACIÓN PRINCIPAL */
        .game-bar {
            background-color: #111214;
            border-bottom: 1px solid #333;
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

        /* SECCIÓN DEL LOGO */
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

        /* SECCIÓN CENTRAL DE JUEGOS */
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

        /* ITEMS DE JUEGO */
        .game-item {
            display: inline-flex;
            align-items: center;
            color: #b0b0b0;
            margin: 0 8px;
            padding: 8px 15px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            white-space: nowrap;
            height: 50px;
            border: 1px solid transparent;
        }

        .game-item:hover {
            background-color: rgba(212, 175, 55, 0.2);
            color: #ffffff;
            transform: translateY(-2px);
            border-color: rgba(212, 175, 55, 0.3);
        }

        .game-item.active {
            color: #D4AF37;
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
            background: #D4AF37;
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

        /* MENÚ HAMBURGUESA */
        .menu-section {
            flex-shrink: 0;
            padding-left: 30px;
        }

        .hamburger-menu {
            color: #b0b0b0;
            font-size: 1.8rem;
            cursor: pointer;
            transition: all 0.3s;
            padding: 10px;
            border-radius: 50%;
        }

        .hamburger-menu:hover {
            color: #D4AF37;
            background-color: rgba(212, 175, 55, 0.2);
            transform: rotate(90deg);
        }

        /* CONTENIDO PRINCIPAL */
        body {
            background-color: #000;
            color: #F0F0F0;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex: 1;
            padding: 30px;
            padding-top: 100px; /* Espacio para la barra de navegación */
        }

        /* Botón Volver */
        .back-button {
            display: inline-block;
            margin-bottom: 30px;
            padding: 12px 25px;
            background-color: rgba(212, 175, 55, 0.2);
            color: #D4AF37;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: all 0.3s;
            border: 1px solid #D4AF37;
            position: absolute;
            left: 30px;
            top: 100px;
        }

        .back-button:hover {
            background-color: rgba(212, 175, 55, 0.4);
            transform: translateX(-5px);
        }

        .back-button i {
            margin-right: 8px;
        }

        .main-container {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            justify-content: center;
            align-items: flex-start;
        }

        .left-panel {
            flex: 1;
            max-width: 600px;
        }

        .right-panel {
            flex: 1;
            max-width: 500px;
        }

        h1 {
            font-size: 70px;
            color: #FFD700;
            margin-bottom: 20px;
            font-weight: bold;
            text-shadow: 2px 2px 8px rgba(255, 215, 0, 0.3);
        }

        .weapon-image-container {
            width: 100%;
            min-height: 200px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .weapon-image {
            max-width: 100%;
            height: auto;
            filter: drop-shadow(0 0 12px #D4AF37);
            transition: opacity 0.4s ease-in-out;
        }

        .weapon-image.hidden {
            opacity: 0;
        }

        .stats {
            padding: 10px 0;
        }

        .stats h2 {
            color: #D4AF37;
            margin-top: 0;
        }

        .stats p {
            font-size: 18px;
            margin: 8px 0;
        }

        .skins-section {
            margin-top: 60px;
        }

        .skins-section h2 {
            text-align: center;
            color: #D4AF37;
            margin-bottom: 20px;
        }

        /* Carrusel mejorado */
        .carousel-container {
            position: relative;
            max-width: 100%;
            margin: 0 auto;
            padding: 0 40px;
        }

        .skins-carousel {
            display: flex;
            overflow-x: auto;
            gap: 15px;
            padding: 20px 10px;
            scroll-behavior: smooth;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
        }

        .skins-carousel::-webkit-scrollbar {
            height: 8px;
        }

        .skins-carousel::-webkit-scrollbar-thumb {
            background: #444;
            border-radius: 4px;
        }

        .skin-card {
            flex: 0 0 auto;
            background-color: transparent;
            border: 2px solid transparent;
            border-radius: 10px;
            padding: 10px;
            width: 150px;
            cursor: pointer;
            text-align: center;
            transition: transform 0.3s, border-color 0.3s;
            scroll-snap-align: start;
        }

        .skin-card.active {
            border-color: #D4AF37;
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.5);
        }

        .skin-card:hover {
            transform: scale(1.05);
            border-color: #D4AF37;
        }

        .skin-card img {
            width: 100%;
            height: auto;
            border-radius: 6px;
        }

        .skin-name {
            margin-top: 10px;
            font-size: 0.95rem;
            color: #D4AF37;
            font-weight: bold;
        }

        /* Botones de navegación */
        .nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            border: none;
            color: #D4AF37;
            font-size: 1.2rem;
            transition: all 0.3s;
        }

        .nav-btn:hover {
            background: rgba(212, 175, 55, 0.3);
            transform: translateY(-50%) scale(1.1);
        }

        .prev-btn {
            left: 0;
        }

        .next-btn {
            right: 0;
        }

        /* FOOTER */
        .custom-footer {
            background-color: #111214;
            padding: 30px 20px;
            border-top: 2px solid #D4AF37;
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
        }

        .footer-games .game-item:hover {
            background-color: #D4AF37;
            color: #0A0A0A;
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
            color: #F0F0F0;
            transition: all 0.3s;
        }

        .social-icon:hover {
            background-color: #D4AF37;
            color: #0A0A0A;
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
        @media (max-width: 992px) {
            .game-item {
                margin: 0 5px;
                padding: 8px 10px;
                font-size: 0.9rem;
            }
            
            .game-icon {
                width: 24px;
                height: 24px;
            }
            
            /* Footer responsive */
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

        @media (max-width: 900px) {
            .main-container {
                flex-direction: column;
                align-items: center;
            }

            .left-panel, .right-panel {
                max-width: 100%;
            }

            h1 {
                text-align: center;
                font-size: 50px;
            }
            
            .carousel-container {
                padding: 0 30px;
            }
            
            .nav-btn {
                width: 30px;
                height: 30px;
                font-size: 1rem;
            }

            .back-button {
                top: 90px;
                left: 20px;
                padding: 10px 15px;
            }
        }

        @media (max-width: 768px) {
            .nav-container {
                height: 70px;
            }
            
            .logo-section img {
                height: 50px;
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

            h1 {
                font-size: 2.5rem;
            }

            .weapon-image {
                max-width: 80%;
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

            .back-button {
                position: relative;
                top: auto;
                left: auto;
                margin-bottom: 20px;
            }

            h1 {
                font-size: 2rem;
            }

            .stats p {
                font-size: 1rem;
            }

            .skin-card {
                width: 120px;
            }

            .skin-name {
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <!-- BARRA DE NAVEGACIÓN -->
    <div class="game-bar">
        <div class="nav-container">
            <div class="logo-section">
                <a href="index.php">
                    <img src="imglogo/GGO.png" alt="GG Operación" style="height: 60px;">
                </a>
            </div>

            <div class="games-section">
                <div class="game-scroller">
                    <a href="Fornite.php" class="game-item">
                        <img src="imglogo/fornite.png" class="game-icon" alt="Fortnite">
                        <span>Fortnite</span>
                    </a>
                    <a href="Valorant.php" class="game-item active">
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

    <!-- CONTENIDO PRINCIPAL -->
    <div class="main-content">
        <!-- Botón Volver -->
        <a href="valorantcontenido.php?seccion=armas" class="back-button">
            <i class="fas fa-arrow-left"></i> Volver a Armas
        </a>

        <div class="main-container">
            <!-- Panel Izquierdo -->
            <div class="left-panel">
                <h1><?= $arma['displayName'] ?></h1>
                <div class="weapon-image-container">
                    <img id="mainWeaponImage" class="weapon-image" src="<?= $arma['displayIcon'] ?>" alt="<?= $arma['displayName'] ?>">
                </div>
            </div>

            <!-- Panel Derecho -->
            <div class="right-panel">
                <?php if (!empty($arma['weaponStats'])): ?>
                    <div class="stats">
                        <h2>Estadísticas</h2>
                        <p><strong>Cadencia de fuego:</strong> <?= $arma['weaponStats']['fireRate'] ?></p>
                        <p><strong>Capacidad del cargador:</strong> <?= $arma['weaponStats']['magazineSize'] ?></p>
                        <p><strong>Tiempo de recarga:</strong> <?= $arma['weaponStats']['reloadTimeSeconds'] ?> segundos</p>

                        <?php foreach ($arma['weaponStats']['damageRanges'] as $rango): ?>
                            <p><strong><?= $rango['rangeStartMeters'] ?>-<?= $rango['rangeEndMeters'] ?> m:</strong><br>
                            Cabeza: <?= $rango['headDamage'] ?>, Cuerpo: <?= $rango['bodyDamage'] ?>, Piernas: <?= $rango['legDamage'] ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Carrusel de skins mejorado -->
        <div class="skins-section">
            <h2>Skins Disponibles</h2>
            <div class="carousel-container">
                <button class="nav-btn prev-btn">❮</button>
                <div class="skins-carousel" id="skinsCarousel">
                    <?php foreach ($skinsArray as $index => $skin): ?>
                        <?php
                            $icono = $skin['displayIcon'] ?? $skin['fullRender'] ?? null;
                        ?>
                        <div class="skin-card <?= $index === 0 ? 'active' : '' ?>" 
                             onclick="cambiarSkin('<?= $icono ?>', <?= $index ?>)" 
                             data-skin-index="<?= $index ?>">
                            <img src="<?= $icono ?>" alt="<?= $skin['displayName'] ?>">
                            <div class="skin-name"><?= $skin['displayName'] ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button class="nav-btn next-btn">❯</button>
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

    <script>
        // Datos de las skins disponibles
        const skinsData = <?= json_encode($skinsArray) ?>;
        let currentSkinIndex = 0;
        const skinCards = document.querySelectorAll('.skin-card');
        const mainWeaponImage = document.getElementById('mainWeaponImage');

        function cambiarSkin(url, index) {
            mainWeaponImage.classList.add("hidden");
            
            // Actualizar tarjeta activa
            skinCards.forEach(card => card.classList.remove('active'));
            skinCards[index].classList.add('active');
            
            setTimeout(() => {
                mainWeaponImage.src = url;
                mainWeaponImage.classList.remove("hidden");
                currentSkinIndex = index;
            }, 200);
        }

        // Carrusel automático con navegación
        document.addEventListener('DOMContentLoaded', function() {
            const carousel = document.getElementById('skinsCarousel');
            const cards = document.querySelectorAll('.skin-card');
            const cardWidth = 165; // 150px + 15px gap
            let autoScrollInterval;
            let isUserInteracting = false;
            let resumeTimeout;

            // Función para actualizar la skin mostrada
            function updateActiveSkin() {
                const scrollPosition = carousel.scrollLeft;
                const activeIndex = Math.round(scrollPosition / cardWidth) % skinsData.length;
                
                if (activeIndex !== currentSkinIndex) {
                    const skin = skinsData[activeIndex];
                    const skinUrl = skin.displayIcon || skin.fullRender;
                    cambiarSkin(skinUrl, activeIndex);
                }
            }

            // Función para mover el carrusel
            function moveCarousel() {
                if (isUserInteracting) return;

                const currentScroll = carousel.scrollLeft;
                const maxScroll = carousel.scrollWidth - carousel.clientWidth;
                const nextIndex = (currentSkinIndex + 1) % skinsData.length;

                // Si estamos al final, volver al inicio sin animación
                if (currentScroll >= maxScroll - cardWidth) {
                    carousel.scrollTo({
                        left: 0,
                        behavior: 'instant'
                    });
                    cambiarSkin(skinsData[0].displayIcon || skinsData[0].fullRender, 0);
                } else {
                    // Mover al siguiente índice
                    carousel.scrollBy({
                        left: cardWidth,
                        behavior: 'smooth'
                    });
                    
                    // Cambiar la skin después de que termine la animación de scroll
                    setTimeout(() => {
                        updateActiveSkin();
                    }, 500);
                }
            }

            // Iniciar el movimiento automático
            function startAutoScroll() {
                if (autoScrollInterval) clearInterval(autoScrollInterval);
                autoScrollInterval = setInterval(moveCarousel, 3000);
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
                const prevIndex = (currentSkinIndex - 1 + skinsData.length) % skinsData.length;
                
                // Encontrar la tarjeta anterior
                const prevCard = document.querySelector(`.skin-card[data-skin-index="${prevIndex}"]`);
                prevCard.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest',
                    inline: 'center'
                });
                
                // Cambiar la skin
                const skin = skinsData[prevIndex];
                cambiarSkin(skin.displayIcon || skin.fullRender, prevIndex);
            });

            document.querySelector('.next-btn').addEventListener('click', () => {
                handleUserInteraction();
                const nextIndex = (currentSkinIndex + 1) % skinsData.length;
                
                // Encontrar la tarjeta siguiente
                const nextCard = document.querySelector(`.skin-card[data-skin-index="${nextIndex}"]`);
                nextCard.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest',
                    inline: 'center'
                });
                
                // Cambiar la skin
                const skin = skinsData[nextIndex];
                cambiarSkin(skin.displayIcon || skin.fullRender, nextIndex);
            });

            // Eventos de interacción del usuario
            carousel.addEventListener('scroll', () => {
                handleUserInteraction();
                updateActiveSkin();
            });

            carousel.addEventListener('mousedown', handleUserInteraction);
            carousel.addEventListener('touchstart', handleUserInteraction);
            carousel.addEventListener('wheel', handleUserInteraction);

            // Iniciar el carrusel automático al cargar la página
            startAutoScroll();
        });
    </script>
</body>
</html>