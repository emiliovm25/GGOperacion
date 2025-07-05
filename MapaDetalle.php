<?php
if (!isset($_GET['uuid'])) {
    die("Mapa no especificado.");
}

$uuid = htmlspecialchars($_GET['uuid']);
$apiUrl = "https://valorant-api.com/v1/maps/{$uuid}";

function curlGet($url)
{
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

$mapaData = curlGet($apiUrl);
$data = json_decode($mapaData, true);
if (!$data || $data['status'] !== 200) {
    die("Error al obtener los datos del mapa.");
}

$mapa = $data['data'];
?>

<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($mapa['displayName']) ?> - Detalles</title>
    <!-- Font Awesome para el ícono -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-dark: #0a0a0a;
            --primary-gold: #D4AF37;
            --primary-red: #D4AF37;
            --text-light: #F0F0F0;
        }

        body {
            margin: 0;
            background-color: var(--primary-dark);
            color: var(--text-light);
            font-family: 'Roboto', sans-serif;
            overflow-x: hidden;
            position: relative;
            padding-top: 80px; /* Espacio para la barra de navegación */
        }

        /* Botón superior estilo consistente */
        .top-back-button {
            display: inline-block;
            position: fixed;
            left: 30px;
            top: 100px;
            padding: 12px 25px;
            background-color: rgba(212, 175, 55, 0.2);
            color: #D4AF37;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: all 0.3s;
            border: 1px solid #D4AF37;
            z-index: 10;
            backdrop-filter: blur(5px);
        }

        .top-back-button:hover {
            background-color: rgba(212, 175, 55, 0.4);
            transform: translateX(-5px);
        }

        .top-back-button i {
            margin-right: 8px;
        }

        .content {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: flex-start;
            max-width: 1400px;
            width: 100%;
            gap: 60px;
            margin: 40px auto;
            padding: 20px;
        }

        .left-side {
            flex: 1;
        }

        .right-side {
            flex: 1;
            color: var(--primary-gold);
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin-top: 40px;
            align-items: center;
        }

        h1 {
            font-family: 'Oswald', sans-serif;
            font-size: 4rem;
            font-weight: bold;
            color: var(--primary-gold);
            margin-bottom: 20px;
            text-align: center;
            text-transform: uppercase;
        }

        .splash {
            width: 100%;
            max-height: 600px;
            object-fit: contain;
            border: 4px solid var(--primary-gold);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.3);
        }

        .right-side h2 {
            font-size: 2rem;
            margin-bottom: 10px;
            color: var(--primary-gold);
        }

        .right-side h3 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: var(--text-light);
        }

        .coordinates {
            font-size: 1.4rem;
            font-weight: bold;
            color: var(--primary-gold);
            margin-bottom: 20px;
            text-align: center;
        }

        .display-icon {
            width: 200px;
            height: auto;
            margin-top: 15px;
            border-radius: 10px;
            border: 3px solid var(--primary-gold);
            background-color: #1a1a1a;
            padding: 10px;
        }

        .tactical-description {
            color: var(--primary-gold);
            font-size: 1.2rem;
            max-width: 500px;
            text-align: center;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        /* BARRA DE NAVEGACIÓN PRINCIPAL */
        .game-bar {
            background-color: #111214;
            border-bottom: 1px solid #333;
            padding: 0;
            position: fixed;
            top: 0;
            width: 100%;
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
            .content {
                flex-direction: column;
                align-items: center;
                gap: 30px;
            }
            
            .left-side, .right-side {
                width: 100%;
                max-width: 800px;
            }
            
            h1 {
                font-size: 3rem;
            }
            
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
            
            h1 {
                font-size: 2.5rem;
            }
            
            .top-back-button {
                position: absolute;
                top: 20px;
                left: 20px;
                padding: 10px 15px;
                font-size: 0.9rem;
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
            
            h1 {
                font-size: 2rem;
            }
            
            .splash {
                border-width: 2px;
            }
            
            .right-side h2 {
                font-size: 1.5rem;
            }
            
            .coordinates {
                font-size: 1.2rem;
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
    
    <!-- Botón superior con mismo estilo que en otras páginas -->
    <a href="valorantcontenido.php?seccion=mapas" class="top-back-button">
        <i class="fas fa-arrow-left"></i> Volver a Mapas
    </a>

    <div class="content">
        <div class="left-side">
            <h1><?= htmlspecialchars($mapa['displayName']) ?></h1>
            <?php if (!empty($mapa['splash'])): ?>
                <img src="<?= htmlspecialchars($mapa['splash']) ?>" class="splash" alt="Splash del mapa">
            <?php endif; ?>
        </div>

        <div class="right-side">
            <h2>SITES</h2>
            <p class="tactical-description">
                <?= nl2br(htmlspecialchars($mapa['tacticalDescription'] ?? 'No hay descripción táctica disponible.')) ?>
            </p>

            <p class="coordinates">
                Coordenadas generales: <?= htmlspecialchars($mapa['coordinates'] ?: 'N/D') ?>
            </p>

            <?php if (!empty($mapa['displayIcon'])): ?>
                <img src="<?= htmlspecialchars($mapa['displayIcon']) ?>" alt="Ícono del mapa" class="display-icon">
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
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