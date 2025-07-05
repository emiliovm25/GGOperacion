<?php
if (!isset($_GET['name'])) {
    die("Mapa no especificado.");
}

$mapName = htmlspecialchars($_GET['name']);
$apiUrl = "https://overfast-api.tekrop.fr/maps";

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

$response = curlGet($apiUrl);
$maps = json_decode($response, true);

$mapa = null;
foreach ($maps as $m) {
    if (strtolower($m['name']) === strtolower($mapName)) {
        $mapa = $m;
        break;
    }
}

if (!$mapa) {
    die("Mapa no encontrado.");
}
?>

<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($mapa['name']) ?> - Detalles</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-dark: #0a0a0a;
            --primary-gold: #D4AF37;
            --text-light: #F0F0F0;
        }

        body {
            margin: 0;
            background-color: var(--primary-dark);
            color: var(--text-light);
            font-family: 'Roboto', sans-serif;
            padding-top: 80px;
        }

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

        .left-side,
        .right-side {
            flex: 1;
        }

        h1 {
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
            text-align: center;
        }

        .tactical-description {
            color: var(--text-light);
            font-size: 1.2rem;
            text-align: center;
            margin-bottom: 30px;
        }

        .coordinates {
            font-size: 1.4rem;
            font-weight: bold;
            color: var(--primary-gold);
            margin-bottom: 20px;
            text-align: center;
        }

        .display-icon {
            width: 64px;
            height: auto;
            margin-top: 15px;
            border-radius: 10px;
            background-color: #1a1a1a;
            padding: 10px;
            border: 2px solid var(--primary-gold);
        }

        .custom-footer {
            background-color: #111214;
            padding: 30px 20px;
            border-top: 2px solid #D4AF37;
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

        .footer-logo img {
            max-width: 100px;
            height: auto;
        }

        .footer-bottom {
            text-align: center;
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.6);
        }

        @media (max-width: 992px) {
            .content {
                flex-direction: column;
                gap: 30px;
            }
        }
                /* ESTILOS DE LA BARRA DE NAVEGACIÓN */
        .game-bar {
            background-color: #101113;
            border-bottom: 1px solid #333;
            padding: 8px 0;
            overflow-x: auto;
            white-space: nowrap;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .nav-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .logo-section {
            flex-shrink: 0;
            padding-left: 15px;
        }

        .logo-section img {
            height: 50px;
            transition: transform 0.3s;
        }

        .logo-section img:hover {
            transform: scale(1.05);
        }

        .games-section {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            overflow: hidden;
        }

        .game-scroller {
            display: flex;
            gap: 15px;
            overflow-x: auto;
            padding: 5px 0;
            scrollbar-width: none;
        }

        .game-scroller::-webkit-scrollbar {
            display: none;
        }

        .game-item {
            display: flex;
            align-items: center;
            color: rgb(110, 110, 110);
            margin: 0 12px;
            padding: 6px 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none !important;
            white-space: nowrap;
        }

        .game-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateY(-2px);
        }

        .game-item.active {
            color: rgb(254, 254, 255);
            border-bottom: 2px solid rgb(254, 254, 255);
        }

        .game-icon {
            width: 24px;
            height: 24px;
            margin-right: 8px;
            object-fit: contain;
        }

        .hamburger-menu {
            color: rgb(110, 110, 110);
            font-size: 1.3rem;
            cursor: pointer;
            transition: all 0.3s;
            padding: 8px 12px;
            display: none;
        }

        .hamburger-menu:hover {
            color: rgb(254, 254, 255);
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        /* ESTILOS DEL FOOTER */
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
            color: #F0F0F0;
            transition: all 0.3s;
            cursor: pointer;
        }

        .footer-games .game-item:hover {
            background-color: #D4AF37;
            color: #0A0A0A;
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
        @media (max-width: 768px) {
            .nav-container {
                padding: 0 15px;
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

            .hamburger-menu {
                display: block;
            }

            .game-scroller {
                display: none;
            }

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

        @media (max-width: 480px) {
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
    <!-- Botón para volver -->
    <a href="overwachtcontenido.php?seccion=maps" class="top-back-button">
        <i class="fas fa-arrow-left"></i> Volver a Mapas
    </a>

    <div class="content">
        <div class="left-side">
            <h1><?= htmlspecialchars($mapa['name']) ?></h1>
            <img src="<?= htmlspecialchars($mapa['screenshot']) ?>" class="splash" alt="Imagen del mapa">
        </div>

        <div class="right-side">
            <h2>MODOS DE JUEGO</h2>
            <p class="tactical-description">
                <?= htmlspecialchars(implode(', ', $mapa['gamemodes'])) ?>
            </p>

            <p class="coordinates">
                Ubicación: <?= htmlspecialchars($mapa['location'] ?? 'Desconocida') ?>
            </p>

            <?php if (!empty($mapa['country_code'])): ?>
                <img src="https://flagcdn.com/64x48/<?= strtolower($mapa['country_code']) ?>.png"
                    alt="Bandera"
                    class="display-icon">
            <?php endif; ?>
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

</html>