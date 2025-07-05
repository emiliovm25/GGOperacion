<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Obtener el parámetro ID
$champion_id = $_GET['id'] ?? '';

if (empty($champion_id)) {
    die('Falta el parámetro ID del campeón');
}

// Obtener versión más reciente del juego
function getLatestVersion() {
    $response = @file_get_contents("https://ddragon.leagueoflegends.com/api/versions.json");
    $versions = json_decode($response, true);
    return $versions[0] ?? '13.24.1';
}

// Obtener todos los campeones
function getAllChampions($version) {
    $url = "https://ddragon.leagueoflegends.com/cdn/{$version}/data/es_MX/champion.json";
    $response = @file_get_contents($url);
    $data = json_decode($response, true);
    return $data['data'] ?? [];
}

// Buscar al campeón por ID numérico (key)
function findChampionById($champions, $id) {
    foreach ($champions as $champion) {
        if ((string)$champion['key'] === (string)$id) {
            return $champion;
        }
    }
    return null;
}

// Obtener datos detallados del campeón
function getChampionData($champion_name, $version) {
    $url = "https://ddragon.leagueoflegends.com/cdn/{$version}/data/es_MX/champion/{$champion_name}.json";
    $response = @file_get_contents($url);
    $data = json_decode($response, true);
    return $data['data'][$champion_name] ?? null;
}

// Lógica principal
$version = getLatestVersion();
$allChampions = getAllChampions($version);
$champion = findChampionById($allChampions, $champion_id);

if (!$champion) {
    die("No se encontró el campeón con ID {$champion_id}");
}

$champion_name = $champion['id']; // ej. Khazix
$data = getChampionData($champion_name, $version);

if (!$data) {
    die("No se pudo obtener la información detallada del campeón '{$champion_name}'");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($data['name'] ?? $champion_name) ?> - League of Legends</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Estilos de la barra de navegación */
        .game-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #111;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }
        
        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            max-width: 1400px;
            margin: 0 auto;
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
            margin: 0 20px;
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
            color: white;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            white-space: nowrap;
            transition: all 0.3s;
        }
        
        .game-item:hover, .game-item.active {
            background-color: #D4AF37;
            color: #000;
        }
        
        .game-icon {
            width: 24px;
            height: 24px;
            margin-right: 8px;
            object-fit: contain;
        }
        
        .hamburger-menu {
            color: white;
            font-size: 24px;
            cursor: pointer;
            display: none;
        }
        
        /* Estilos del cuerpo principal */
        body {
            margin: 0;
            padding-top: 70px; /* Para la barra de navegación fija */
            display: flex;
            background-color: #000;
            color: #fff;
            font-family: 'Roboto', sans-serif;
            min-height: 100vh;
            flex-direction: column;
        }

        .content-wrapper {
            display: flex;
            flex: 1;
        }

        .sidebar {
            width: 500px;
            background-color: #111;
        }

        .splash-container {
            width: 100%;
            height: 100vh;
            overflow: hidden;
            position: sticky;
            top: 70px;
        }

        .splash-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            background-color: #111;
        }

        .main-content {
            flex: 1;
            padding: 40px;
            position: relative;
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
            left: 40px;
            top: 20px;
            z-index: 10;
        }

        .back-button:hover {
            background-color: rgba(212, 175, 55, 0.4);
            transform: translateX(-5px);
        }

        .back-button i {
            margin-right: 8px;
        }

        .header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
            margin-top: 20px;
        }

        .header img {
            width: 64px;
            height: 64px;
        }

        .champion-name {
            font-size: 3rem;
            font-family: 'Oswald', sans-serif;
            color: #D4AF37;
        }

        .champion-title {
            font-size: 1.2rem;
            color: #ccc;
        }

        .section-title {
            font-size: 2rem;
            color: #D4AF37;
            font-family: 'Oswald', sans-serif;
            margin-bottom: 10px;
        }

        .story {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 1px;
        }

        .abilities-section {
            margin-bottom: 10px;
        }

        .abilities {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .ability {
            width: 180px;
            background-color: rgb(0, 0, 0);
            padding: 15px;
            border-radius: 10px;
            text-align: center;
        }

        .ability img {
            width: 64px;
            height: 64px;
            margin-bottom: 10px;
        }

        .ability-name {
            color: #D4AF37;
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 1.1rem;
        }

        .ability-desc {
            font-size: 0.9rem;
            color: #ccc;
            line-height: 1.4;
        }

        .passive-section {
            margin-top: 30px;
            background-color: rgb(0, 0, 0);
            padding: 20px;
            border-radius: 10px;
        }

        .passive-section h3 {
            color: #D4AF37;
            font-family: 'Oswald', sans-serif;
            margin-bottom: 15px;
            font-size: 1.5rem;
        }

        .passive-section .passive-content {
            display: flex;
            gap: 15px;
            align-items: flex-start;
        }

        .passive-section img {
            width: 64px;
            height: 64px;
        }

        .passive-text {
            color: #ccc;
        }

        .passive-text .name {
            color: #D4AF37;
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 1.1rem;
        }

        .passive-text .desc {
            font-size: 0.9rem;
            line-height: 1.4;
        }

        /* Estilos del footer */
        .custom-footer {
            background-color: #111;
            color: white;
            padding: 30px 0 20px;
            margin-top: auto;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 0 20px;
        }

        .footer-logo img {
            height: 50px;
            margin-bottom: 15px;
        }

        .footer-games {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin: 10px 0;
        }

        .footer-games a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-games a:hover {
            color: #D4AF37;
        }

        .footer-social {
            display: flex;
            gap: 15px;
            margin: 10px 0;
        }

        .social-icon {
            color: white;
            font-size: 20px;
            transition: color 0.3s;
        }

        .social-icon:hover {
            color: #D4AF37;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            margin-top: 20px;
            border-top: 1px solid #333;
        }

        /* Media queries */
        @media (max-width: 1200px) {
            .sidebar {
                width: 400px;
            }
            
            .ability {
                width: 160px;
            }
        }

        @media (max-width: 992px) {
            .content-wrapper {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                height: 400px;
            }
            
            .splash-container {
                height: 400px;
                position: relative;
                top: auto;
            }
            
            .main-content {
                padding: 30px;
            }
            
            .abilities {
                justify-content: center;
            }
            
            .hamburger-menu {
                display: block;
            }
            
            .game-scroller {
                display: none;
            }

            .back-button {
                left: 30px;
                top: 15px;
            }
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }
            
            .champion-name {
                font-size: 2.5rem;
            }
            
            .ability {
                width: 140px;
                padding: 10px;
            }
            
            .footer-content {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
            
            .footer-games, .footer-social {
                justify-content: center;
            }

            .back-button {
                padding: 10px 15px;
                left: 20px;
                top: 10px;
            }
        }

        @media (max-width: 576px) {
            .back-button {
                position: relative;
                left: auto;
                top: auto;
                margin: 0 auto 20px;
                display: block;
                width: fit-content;
            }
        }
    </style>
</head>

<body>
    <!-- Barra de navegación superior -->
    <div class="game-bar">
        <div class="nav-container">
            <!-- LOGO -->
            <div class="logo-section">
                <a href="index.php">
                    <img src="imglogo/GGO.png" alt="GG Operación">
                </a>
            </div>

            <!-- JUEGOS -->
            <div class="games-section">
                <div class="game-scroller">
                    <a href="Fornite.php" class="game-item"><img src="imglogo/fornite.png" class="game-icon">Fortnite</a>
                    <a href="Valorant.php" class="game-item"><img src="imglogo/valorant.png" class="game-icon">Valorant</a>
                    <a href="lol.php" class="game-item active"><img src="imglogo/LOL.png" class="game-icon">League of Legends</a>
                    <a href="Overwacht.php" class="game-item"><img src="imglogo/over.png" class="game-icon">Overwatch</a>
                    <a href="Descubre.php" class="game-item">Descubre y disfruta</a>
                </div>
            </div>

            <!-- MENÚ HAMBURGUESA -->
            <div class="menu-section">
                <i class="fas fa-bars hamburger-menu"></i>
            </div>
        </div>
    </div>

    <div class="content-wrapper">
        <div class="sidebar">
            <div class="splash-container">
                <img src="https://ddragon.leagueoflegends.com/cdn/img/champion/loading/<?= $champion_name ?>_0.jpg" alt="Splash" loading="lazy">
            </div>
        </div>
        
        <div class="main-content">
            <!-- Botón Volver -->
            <a href="contenidolol.php?seccion=champions" class="back-button">
                <i class="fas fa-arrow-left"></i> Volver a Campeones
            </a>

            <div class="header">
                <img src="https://ddragon.leagueoflegends.com/cdn/<?= $version ?>/img/champion/<?= $data['image']['full'] ?>" alt="Icono">
                <div>
                    <div class="champion-name"><?= htmlspecialchars($data['name'] ?? $champion_name) ?></div>
                    <div class="champion-title"><?= htmlspecialchars($data['title']) ?></div>
                </div>
            </div>

            <div class="section-title">Historia</div>
            <div class="story"><?= $data['lore'] ?></div>

            <div class="abilities-section">
                <div class="section-title">Habilidades</div>
                <div class="abilities">
                    <?php foreach ($data['spells'] as $spell): ?>
                        <div class="ability">
                            <img src="https://ddragon.leagueoflegends.com/cdn/<?= $version ?>/img/spell/<?= $spell['image']['full'] ?>" alt="<?= $spell['name'] ?>">
                            <div class="ability-name"><?= $spell['name'] ?></div>
                            <div class="ability-desc"><?= $spell['description'] ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="passive-section">
                <h3>Pasiva</h3>
                <div class="passive-content">
                    <img src="https://ddragon.leagueoflegends.com/cdn/<?= $version ?>/img/passive/<?= $data['passive']['image']['full'] ?>" alt="Pasiva">
                    <div class="passive-text">
                        <div class="name"><?= $data['passive']['name'] ?> (Pasiva)</div>
                        <div class="desc"><?= $data['passive']['description'] ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer personalizado -->
    <div class="custom-footer">
        <div class="footer-content">
            <!-- Logo -->
            <div class="footer-logo">
                <img src="imglogo/GGO.png" alt="GGOperación Logo">
            </div>

            <!-- Juegos -->
            <div class="footer-games">
                <a href="Valorant.php" class="game-item">Valorant</a>
                <a href="lol.php" class="game-item">League of Legends</a>
                <a href="Fornite.php" class="game-item">Fortnite</a>
                <a href="Descubre.php" class="game-item">Descubre y disfruta</a>
            </div>

            <!-- Redes sociales -->
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
        // Menú hamburguesa para móviles
        document.querySelector('.hamburger-menu').addEventListener('click', function() {
            const gameScroller = document.querySelector('.game-scroller');
            if (gameScroller.style.display === 'flex') {
                gameScroller.style.display = 'none';
            } else {
                gameScroller.style.display = 'flex';
            }
        });
    </script>
</body>

</html>