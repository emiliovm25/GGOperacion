<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$hero_key = $_GET['id'] ?? '';

if (empty($hero_key)) {
    die('Falta el parámetro ID del héroe');
}

function getHeroData($hero_key)
{
    $url = "https://overfast-api.tekrop.fr/heroes/{$hero_key}?locale=es-es";
    $response = @file_get_contents($url);
    if ($response === false) {
        die("Error al obtener datos del héroe");
    }
    return json_decode($response, true);
}

$hero_data = getHeroData($hero_key);

if (!$hero_data) {
    die("No se encontró el héroe con ID {$hero_key}");
}

$roles = [
    'tank' => 'Tanque',
    'damage' => 'Daño',
    'support' => 'Soporte'
];
$hero_role = $roles[strtolower($hero_data['role'])] ?? $hero_data['role'];

function translateStats($stats)
{
    return [
        'salud' => $stats['health'] ?? 0,
        'armadura' => $stats['armor'] ?? 0,
        'escudos' => $stats['shields'] ?? 0,
        'total' => $stats['total'] ?? 0
    ];
}

$hero_stats = translateStats($hero_data['hitpoints'] ?? []);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($hero_data['name'] ?? 'Héroe') ?> - Overwatch</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
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

        :root {
            --color-primary: #D4AF37;
            --color-dark: #000000;
            --color-light: #ffffff;
            --color-gray: #cccccc;
        }

        body {
            margin: 0;
            padding-top: 70px;
            background-color: var(--color-dark);
            color: var(--color-light);
            font-family: 'Roboto', sans-serif;
            min-height: 100vh;
        }

        .hero-container {
            display: flex;
            min-height: calc(100vh - 70px);
        }

        .hero-portrait {
            flex: 0 0 40%;
            position: relative;
            overflow: hidden;
        }

        .hero-portrait img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top center;
        }

        .hero-details {
            flex: 1;
            padding: 40px;
            position: relative;
        }

        .back-button {
            position: absolute;
            top: 10px;
            left: -830px;
            /* Ajusté esta posición para que sea más razonable */
            padding: 10px 20px;
            background-color: #D4AF37;
            /* Color dorado sólido */
            color: #000;
            /* Texto negro para mejor contraste */
            border: 1px solid #D4AF37;
            /* Borde del mismo color */
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s;
            z-index: 10;
        }

        .back-button:hover {
            background-color: #C8A020;
            /* Tonos más oscuros al hacer hover */
            border-color: #C8A020;
            transform: translateX(-3px);
            /* Efecto de movimiento más sutil */
        }

        .hero-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .hero-icon {
            width: 80px;
            height: 80px;
            object-fit: cover;
        }

        .hero-name {
            font-family: 'Oswald', sans-serif;
            font-size: 3rem;
            color: var(--color-primary);
            margin: 0;
            text-transform: uppercase;
        }

        .hero-role {
            display: inline-block;
            padding: 5px 15px;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 20px;
            font-size: 1.1rem;
            color: var(--color-gray);
            margin-top: 5px;
        }

        .stats-container {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
        }

        .stat-box {
            flex: 1;
            background-color: rgba(255, 255, 255, 0.05);
            border: 2px solid var(--color-primary);
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            font-family: 'Oswald', sans-serif;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: bold;
            color: var(--color-primary);
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 0.9rem;
            color: var(--color-gray);
        }

        .section {
            margin-bottom: 30px;
        }

        .section-title {
            font-family: 'Oswald', sans-serif;
            font-size: 2.2rem;
            color: var(--color-primary);
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .section-content {
            font-size: 1.1rem;
            line-height: 1.6;
            color: var(--color-gray);
        }

        .abilities-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            text-align: center;
        }

        .ability-card {
            background-color: transparent;
            padding: 10px;
            width: 140px;
        }

        .ability-icon {
            width: 64px;
            height: 64px;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .ability-name {
            font-weight: bold;
            color: var(--color-primary);
            margin-bottom: 8px;
        }

        .ability-desc {
            font-size: 0.9rem;
            color: var(--color-gray);
        }

        @media (max-width: 992px) {
            .hero-container {
                flex-direction: column;
            }

            .hero-portrait {
                height: 400px;
            }

            .hero-details {
                padding: 30px;
            }

            .back-button {
                left: 20px;
                top: 10px;
            }
        }

        @media (max-width: 768px) {
            .hero-header {
                flex-direction: column;
                text-align: center;
            }

            .stats-container {
                flex-direction: column;
            }

            .abilities-grid {
                flex-direction: column;
                align-items: center;
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
    <div class="hero-container">
        <div class="hero-portrait">
            <img src="imglogo/over.jpg" alt="Overwatch Fijo">
        </div>
        <div class="hero-details">
            <a href="overwachtcontenido.php?seccion=heroes" class="back-button">
                <i class="fas fa-arrow-left"></i> Volver a Héroes
            </a>
            <div class="hero-header">
                <img src="<?= htmlspecialchars($hero_data['portrait']) ?>" class="hero-icon" alt="<?= htmlspecialchars($hero_data['name']) ?>">
                <div>
                    <h1 class="hero-name"><?= htmlspecialchars($hero_data['name']) ?></h1>
                    <span class="hero-role"><?= htmlspecialchars($hero_role) ?></span>
                </div>
            </div>
            <?php if (!empty($hero_data['story']['summary'])): ?>
                <div class="section">
                    <h2 class="section-title">Historia</h2>
                    <div class="section-content">
                        <?= nl2br(htmlspecialchars($hero_data['story']['summary'])) ?>
                    </div>
                    <?php if (!empty($hero_data['location']) || !empty($hero_data['age']) || !empty($hero_data['birthday'])): ?>
                        <div class="section-content" style="margin-top: 20px;">
                            <h3 style="color: var(--color-primary); margin-bottom: 10px;">Datos Biográficos</h3>
                            <ul style="padding-left: 20px;">
                                <?php if (!empty($hero_data['location'])): ?>
                                    <li><strong>Ubicación:</strong> <?= htmlspecialchars($hero_data['location']) ?></li>
                                <?php endif; ?>
                                <?php if (!empty($hero_data['age'])): ?>
                                    <li><strong>Edad:</strong> <?= htmlspecialchars($hero_data['age']) ?> años</li>
                                <?php endif; ?>
                                <?php if (!empty($hero_data['birthday'])): ?>
                                    <li><strong>Cumpleaños:</strong> <?= htmlspecialchars($hero_data['birthday']) ?></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div class="section">
                            <h2 class="section-title">Descripción</h2>
                            <div class="section-content">
                                <?= nl2br(htmlspecialchars($hero_data['description'])) ?>
                            </div>
                        </div>
                        <?php if (!empty($hero_data['abilities'])): ?>
                            <div class="section">
                                <h2 class="section-title">Habilidades</h2>
                                <div class="abilities-grid">
                                    <?php foreach ($hero_data['abilities'] as $ability): ?>
                                        <div class="ability-card">
                                            <img src="<?= htmlspecialchars($ability['icon']) ?>" class="ability-icon" alt="<?= htmlspecialchars($ability['name']) ?>">
                                            <h3 class="ability-name"><?= htmlspecialchars($ability['name']) ?></h3>
                                            <p class="ability-desc"><?= nl2br(htmlspecialchars($ability['description'])) ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="stats-container">
                            <div class="stat-box">
                                <div class="stat-value"><?= $hero_stats['salud'] ?></div>
                                <div class="stat-label">Salud</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-value"><?= $hero_stats['armadura'] ?></div>
                                <div class="stat-label">Armadura</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-value"><?= $hero_stats['escudos'] ?></div>
                                <div class="stat-label">Escudos</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-value"><?= $hero_stats['total'] ?></div>
                                <div class="stat-label">Total</div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
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