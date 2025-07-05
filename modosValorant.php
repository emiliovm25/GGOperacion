<?php
if (!isset($_GET['uuid'])) {
    die("Modo de juego no especificado.");
}

$uuid = htmlspecialchars($_GET['uuid']);
$apiUrl = "https://valorant-api.com/v1/gamemodes/{$uuid}?language=es-MX";

function curlGet($url) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT => 10
    ]);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        die("Error cURL: " . curl_error($ch));
    }
    curl_close($ch);
    return $response;
}

$responseData = curlGet($apiUrl);
$data = json_decode($responseData, true);

if (!$data || $data['status'] !== 200) {
    die("No se pudo obtener información del modo de juego.");
}

$modo = $data['data'];
?>

<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($modo['displayName']) ?> - Modo de Juego</title>
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
            color: #FFD700;
            font-family: Arial, sans-serif;
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
            text-align: center;
        }

        /* Botón superior */
        .top-back-button {
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

        .top-back-button:hover {
            background-color: rgba(212, 175, 55, 0.4);
            transform: translateX(-5px);
        }

        .top-back-button i {
            margin-right: 8px;
        }

        h1 {
            font-size: 3rem;
            font-weight: bold;
            margin-top: 40px;
            color: #FFD700;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 40px;
            margin-top: 30px;
            padding: 0 20px;
            flex-wrap: wrap;
        }

        .image-container img {
            border: 3px solid #FFD700;
            border-radius: 5px;
            max-width: 240px;
            height: auto;
        }

        .description-container {
            text-align: left;
            max-width: 500px;
        }

        .description-container p {
            font-size: 1.4rem;
            color: #FFA500;
            margin: 10px 0;
        }

        .description-container strong {
            color: #FFD700;
        }

        .duration {
            font-size: 1.4rem;
            color: #FFF;
        }

        .display-icon {
            margin-top: 20px;
        }

        .display-icon img {
            width: 80px;
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

            .top-back-button {
                top: 90px;
                left: 20px;
                padding: 10px 15px;
            }

            h1 {
                font-size: 2.5rem;
                margin-top: 30px;
            }

            .container {
                flex-direction: column;
                align-items: center;
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

            .top-back-button {
                position: relative;
                top: auto;
                left: auto;
                margin-bottom: 20px;
            }

            h1 {
                font-size: 2rem;
            }

            .description-container p,
            .duration {
                font-size: 1.1rem;
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
        <!-- Botón superior igual que en la página de armas -->
        <a href="valorantcontenido.php?seccion=modos" class="top-back-button">
            <i class="fas fa-arrow-left"></i> Volver a Modos
        </a>

        <h1><?= htmlspecialchars($modo['displayName']) ?></h1>

        <div class="container">
            <div class="image-container">
                <?php if (!empty($modo['listViewIconTall'])): ?>
                    <img src="<?= htmlspecialchars($modo['listViewIconTall']) ?>" alt="Imagen vertical del modo">
                <?php endif; ?>
            </div>

            <div class="description-container">
                <?php if (!empty($modo['description'])): ?>
                    <p><strong>Descripción:</strong><br><?= htmlspecialchars($modo['description']) ?></p>
                <?php endif; ?>

                <?php if (!empty($modo['duration'])): ?>
                    <p class="duration"><strong>Duración estimada:</strong><br><?= htmlspecialchars($modo['duration']) ?></p>
                <?php endif; ?>

                <div class="display-icon">
                    <?php if (!empty($modo['displayIcon'])): ?>
                        <img src="<?= htmlspecialchars($modo['displayIcon']) ?>" alt="Icono del modo">
                    <?php endif; ?>
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