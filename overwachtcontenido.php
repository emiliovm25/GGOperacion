<?php
// Configuración inicial
$seccion = $_GET['seccion'] ?? 'heroes';
$titulo = '';
$contenido = '';

// Obtener datos de la API de Overwatch
function getOverwatchAPI($endpoint) {
    $url = "https://overfast-api.tekrop.fr/{$endpoint}";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
}

// Procesar según la sección
switch($seccion) {
    case 'heroes':
        $titulo = "Héroes de Overwatch";
        $apiData = getOverwatchAPI('heroes');
        $contenido = '<div class="heroes-container"><h1 class="section-title">Héroes de Overwatch</h1><div class="grid-heroes">';
        
        if(is_array($apiData)) {
            foreach($apiData as $hero) {
                $name = htmlspecialchars($hero['name'] ?? 'Nombre no disponible');
                $role = htmlspecialchars($hero['role'] ?? 'Sin rol');
                $location = htmlspecialchars($hero['location'] ?? 'Desconocida');
                $img = $hero['portrait'] ?? 'https://via.placeholder.com/150';
                $key = $hero['key'] ?? md5($name);
                
                $contenido .= '
                <a href="detalleheroe.php?id='.$key.'" class="hero-card" data-hero="'.$key.'">
                    <div class="card-image">
                        <img src="'.$img.'" alt="'.$name.'">
                    </div>
                    <div class="card-content">
                        <h3>'.$name.'</h3>
                        <p class="role">'.$role.'</p>
                        <div class="tags"><span class="tag">'.$role.'</span></div>
                    </div>
                </a>';
            }
        } else {
            $contenido .= '<p class="error-message">Error al cargar los héroes. Inténtalo más tarde.</p>';
        }
        
        $contenido .= '</div></div>';
        break;
        
    case 'maps':
        $titulo = "Mapas de Overwatch";
        $apiData = getOverwatchAPI('maps');
        $contenido = '<div class="maps-container"><h1 class="section-title">Mapas de Overwatch</h1><div class="grid-maps">';
        
        if(is_array($apiData)) {
            foreach($apiData as $map) {
                $name = htmlspecialchars($map['name'] ?? 'Nombre no disponible');
                $location = htmlspecialchars($map['location'] ?? 'Desconocida');
                $img = $map['screenshot'] ?? 'https://via.placeholder.com/150';
                $gamemodes = $map['gamemodes'] ?? [];
                $country_code = strtolower($map['country_code'] ?? '');
                $key = $name; // usa el nombre real tal cual viene

                $modeTags = '';
                foreach($gamemodes as $mode) {
                    $modeTags .= '<span class="tag">'.htmlspecialchars($mode).'</span>';
                }
                
                $flag = $country_code ? '<span class="fi fi-'.$country_code.'"></span> ' : '';
                
                $contenido .= '
                <a href="detallemapa.php?name='.$key.'" class="map-card">
                    <div class="card-image">
                        <img src="'.$img.'" alt="'.$name.'">
                    </div>
                    <div class="card-content">
                        <h3>'.$name.'</h3>
                        <p class="location">'.$flag.$location.'</p>
                        <div class="tags">'.$modeTags.'</div>
                    </div>
                </a>';
            }
        } else {
            $contenido .= '<p class="error-message">Error al cargar los mapas. Inténtalo más tarde.</p>';
        }
        
        $contenido .= '</div></div>';
        break;
        
    case 'gamemodes':
        $titulo = "Modos de Juego";
        $apiData = getOverwatchAPI('gamemodes');
        $contenido = '<div class="gamemodes-container"><h1 class="section-title">Modos de Juego</h1><div class="grid-gamemodes">';
        
        if(is_array($apiData)) {
            foreach($apiData as $gamemode) {
                $name = htmlspecialchars($gamemode['name'] ?? 'Nombre no disponible');
                $img = $gamemode['icon'] ?? 'https://via.placeholder.com/150';
                $key = $name; // usa el nombre real tal cual viene
                
                $contenido .= '
                <a href="detallemodo.php?key='.$key.'" class="gamemode-card">
                    <div class="card-image">
                        <img src="'.$img.'" alt="'.$name.'">
                    </div>
                    <div class="card-content">
                        <h3>'.$name.'</h3>
                    </div>
                </a>';
            }
        } else {
            $contenido .= '<p class="error-message">Error al cargar los modos de juego. Inténtalo más tarde.</p>';
        }
        
        $contenido .= '</div></div>';
        break;
        
    default:
        $titulo = "Overwatch";
        $contenido = '<div class="welcome-message"><p>Selecciona una sección del menú para comenzar</p></div>';
        break;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titulo) ?> - GGOperación</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icons/6.6.6/css/flag-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&family=Roboto&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-dark: #0A0A0A;
            --primary-blue: rgb(0, 0, 0);
            --secondary-blue: rgb(0, 0, 0);
            --dark-blue: #0a1428;
            --text-light: #F0F0F0;
            --text-gray: #a09b8c;
            --card-bg: rgb(0, 0, 0);
            --overwatch-orange: #D4AF37;
            --overwatch-dark: rgb(0, 0, 0);
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            background-color: var(--primary-dark);
            color: var(--text-light);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

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
            color: rgb(110, 110, 110);
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
            color: var(--overwatch-orange);
            border-bottom: 2px solid var(--overwatch-orange);
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
            color: rgb(110, 110, 110);
            font-size: 1.3rem;
            cursor: pointer;
            transition: all 0.2s;
            padding: 8px 12px;
        }

        .hamburger-menu:hover {
            color: var(--overwatch-orange);
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        main {
            flex: 1;
            padding: 20px;
            max-width: 1400px;
            margin: 80px auto 0;
            width: 100%;
        }

        .section-title {
            color: var(--overwatch-orange);
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.5rem;
            position: relative;
            padding-bottom: 15px;
            font-family: 'Oswald', sans-serif;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: var(--overwatch-orange);
        }

        .grid-heroes, .grid-maps, .grid-gamemodes {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }

        .hero-card, .map-card, .gamemode-card {
            background: var(--overwatch-dark);
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid rgba(249, 158, 26, 0.3);
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .hero-card:hover, .map-card:hover, .gamemode-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(249, 158, 26, 0.2);
            border-color: var(--overwatch-orange);
        }

        .card-image {
            height: 320px;
            overflow: hidden;
            position: relative;
        }

        .map-card .card-image {
            height: 200px;
        }

        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top center;
            transition: transform 0.5s;
        }

        .hero-card:hover .card-image img, 
        .map-card:hover .card-image img,
        .gamemode-card:hover .card-image img {
            transform: scale(1.05);
        }

        .card-content {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .hero-card h3, .map-card h3, .gamemode-card h3 {
            margin: 0 0 10px;
            color: var(--overwatch-orange);
            font-size: 1.4rem;
        }

        .role, .location {
            font-style: italic;
            color: var(--text-gray);
            margin-bottom: 15px;
            font-size: 0.9rem;
        }

        .location {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .fi {
            font-size: 1.2em;
            border-radius: 2px;
            box-shadow: 0 0 2px rgba(0,0,0,0.5);
        }

        .tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: auto;
        }

        .tag {
            background: rgba(249, 158, 26, 0.2);
            color: var(--overwatch-orange);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .internal-nav {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 40px;
        }

        .internal-nav a {
            color: var(--text-light);
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 30px;
            background: rgba(0, 0, 0, 0.7);
            border: 1px solid var(--overwatch-orange);
            transition: all 0.3s;
            font-weight: bold;
        }

        .internal-nav a:hover {
            background: var(--overwatch-orange);
            color: var(--primary-dark);
        }

        .welcome-message, .error-message {
            text-align: center;
            padding: 50px;
            font-size: 1.2rem;
            color: var(--text-gray);
        }

        .welcome-message p {
            max-width: 600px;
            margin: 0 auto;
        }

        .error-message {
            color: #ff6b6b;
        }

        .custom-footer {
            background-color: rgb(0, 0, 0);
            padding: 30px 20px;
            border-top: 2px solid var(--overwatch-orange);
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
            background-color: var(--overwatch-orange);
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
            background-color: var(--overwatch-orange);
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

        @media (max-width: 768px) {
            .grid-heroes, .grid-maps, .grid-gamemodes {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }
            
            .internal-nav {
                flex-direction: column;
                align-items: center;
                gap: 10px;
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
            
            main {
                margin-top: 60px;
            }
        }
        
        @media (max-width: 480px) {
            .game-item span {
                display: none;
            }
            
            .game-icon {
                margin-right: 0;
            }
            
            .section-title {
                font-size: 2rem;
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
                    <img src="imglogo/GGO.png" alt="GG Operación" style="height: 60px;">
                </a>
            </div>

            <!-- JUEGOS -->
            <div class="games-section">
                <div class="game-scroller">
                    <a href="Fornite.php" class="game-item"><img src="imglogo/fornite.png" class="game-icon">Fortnite</a>
                    <a href="Valorant.php" class="game-item"><img src="imglogo/valorant.png" class="game-icon">Valorant</a>
                    <a href="lol.php" class="game-item"><img src="imglogo/LOL.png" class="game-icon">League of Legends</a>
                    <a href="Overwacht.php" class="game-item active"><img src="imglogo/over.png" class="game-icon">Overwatch</a>
                    <a href="Descubre.php" class="game-item">Descubre y disfruta</a>
                </div>
            </div>

            <!-- MENÚ -->
            <div class="menu-section">
                <i class="fas fa-bars hamburger-menu"></i>
            </div>
        </div>
    </div>
    
    <main>
        <nav class="internal-nav">
            <a href="?seccion=heroes">Héroes</a>
            <a href="?seccion=maps">Mapas</a>
            <a href="?seccion=gamemodes">Modos de Juego</a>
        </nav>
        
        <?= $contenido ?>
    </main>
    
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
                <a href="Overwacht.php" class="game-item">Overwatch</a>
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
</body>
</html>