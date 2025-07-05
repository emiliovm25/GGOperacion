<?php
// Configuración inicial
$seccion = $_GET['seccion'] ?? 'modos';
$titulo = 'Fortnite - ' . ucfirst($seccion); // Set dynamic title
$contenido = '';

// Obtener datos de la API de Fortnite
function getFortniteAPI($endpoint)
{
    // Move API key to configuration or environment variable
    $apiKey = getenv('FORTNITE_API_KEY') ?: '4cdf25a7-12d3-47aa-837a-b940bf9884c2';
    $url = "https://fortnite-api.com/v2/{$endpoint}?language=es";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: ' . $apiKey
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

// Procesar según la sección
switch ($seccion) {
    case 'cosmeticos':
        $apiData = getFortniteAPI('cosmetics/br');
        $contenido = '<div class="cosmeticos-container"><h1 style="color:rgba(212, 175, 55, 0.5); text-align:center;">Cosméticos Disponibles</h1><div class="grid-cosmeticos">';

        // Tipos y patrones a excluir
        $excluirTipos = ['loadingscreen', 'banner', 'emoji'];
        $patronesNombres = ['/panelcloth/i', '/nochaoscloth/i', '/empty/i', '/plagholder/i', '/footnite/i'];
        $terminacionesImagen = ['smallicon.png', 'placeholder.png'];

        foreach ($apiData['data'] as $item) {
            $tipo = strtolower($item['type']['value'] ?? '');
            $nombre = $item['name'] ?? '';
            $imagen = $item['images']['icon'] ?? $item['images']['smallIcon'] ?? '';

            // Filtrar por tipos no deseados
            if (in_array($tipo, $excluirTipos)) {
                continue;
            }

            // Filtrar nombres raros
            $nombreInvalido = false;
            foreach ($patronesNombres as $patron) {
                if (preg_match($patron, $nombre)) {
                    $nombreInvalido = true;
                    break;
                }
            }
            if ($nombreInvalido) continue;

            // Filtrar imágenes no deseadas (incluyendo smallicon.png)
            $imagenInvalida = false;
            foreach ($terminacionesImagen as $terminacion) {
                if (substr($imagen, -strlen($terminacion)) === $terminacion) {
                    $imagenInvalida = true;
                    break;
                }
            }
            if ($imagenInvalida || empty($imagen)) continue;

            // Mostrar solo los cosméticos válidos
            $rareza = $item['rarity']['value'] ?? 'Sin rareza';
            $contenido .= '
        <div class="cosmetico-card">
            <img src="' . htmlspecialchars($imagen) . '" alt="' . htmlspecialchars($nombre) . '" onerror="this.src=\'img/default.png\'">
            <h3>' . htmlspecialchars($nombre) . '</h3>
            <p>Tipo: ' . htmlspecialchars($tipo) . '</p>
            <p>Rareza: ' . htmlspecialchars($rareza) . '</p>
        </div>';
        }

        $contenido .= '</div></div>';
        break;

    case 'tienda':
        $apiData = getFortniteAPI('shop');
        $contenido = '<div class="tienda-container">';
        $contenido .= '<h1 style="color:rgba(212, 175, 55, 0.5); text-align:center;">Tienda de Fortnite</h1>';

        $grouped = [];
        $shownIds = [];
        $bundles = [];

        foreach ($apiData['data']['entries'] as $entry) {
            if (isset($entry['bundle'])) {
                $bundles[] = [
                    'name' => $entry['bundle']['name'] ?? 'Bundle sin nombre',
                    'image' => $entry['bundle']['image'] ?? ($entry['items'][0]['images']['icon'] ?? ''),
                    'price' => $entry['finalPrice'] ?? '???'
                ];
                continue;
            }

            $items = $entry['items'] ?? $entry['brItems'] ?? [];

            foreach ($items as $item) {
                if (in_array($item['id'], $shownIds)) continue;
                $shownIds[] = $item['id'];

                $type = $item['type']['displayValue'] ?? 'Otros';
                $rarity = strtolower($item['rarity']['value'] ?? 'common');
                $name = $item['name'] ?? 'Sin nombre';
                $image = $item['images']['icon'] ?? $item['images']['smallIcon'] ?? '';
                $price = $entry['finalPrice'] ?? $entry['regularPrice'] ?? '???';

                if (!isset($grouped[$type])) {
                    $grouped[$type] = [];
                }

                $grouped[$type][] = [
                    'name' => $name,
                    'image' => $image,
                    'price' => $price,
                    'rarity' => $rarity
                ];
            }
        }

        // Mostrar bundles
        if (count($bundles) > 0) {
            $contenido .= '<div class="type-section">';
            $contenido .= '<h2 style="color:rgba(212, 175, 55, 0.5);">Bundles</h2>';
            $contenido .= '<div class="shop-container">';

            foreach ($bundles as $bundle) {
                $contenido .= '
            <div class="item-card">
                <img src="' . htmlspecialchars($bundle['image']) . '" alt="' . htmlspecialchars($bundle['name']) . '">
                <div class="item-name">' . htmlspecialchars($bundle['name']) . '</div>
                <div class="item-price">' . htmlspecialchars($bundle['price']) . ' V-Bucks</div>
            </div>';
            }

            $contenido .= '</div></div>';
        }

        // Mostrar items normales por tipo
        foreach ($grouped as $type => $items) {
            $contenido .= '<div class="type-section">';
            $contenido .= '<h2 style="color:rgba(212, 175, 55, 0.5);">' . htmlspecialchars($type) . '</h2>';
            $contenido .= '<div class="shop-container">';

            foreach ($items as $item) {
                $contenido .= '
            <div class="item-card rarity-' . htmlspecialchars($item['rarity']) . '">
                <img src="' . htmlspecialchars($item['image']) . '" alt="' . htmlspecialchars($item['name']) . '">
                <div class="item-name">' . htmlspecialchars($item['name']) . '</div>
                <div class="item-price">' . htmlspecialchars($item['price']) . ' V-Bucks</div>
            </div>';
            }

            $contenido .= '</div></div>';
        }

        $contenido .= '</div>';
        break;

    case 'mapa':
        $contenido = '
    <h1 style="color:rgba(212, 175, 55, 0.5); text-align:center;">Mapa Fortnite</h1>
    <div class="map-container">
        <img id="map-image" src="" alt="Mapa Fortnite" />
    </div>

    <script>
        fetch("https://fortnite-api.com/v1/map?language=es")
        .then(res => res.json())
        .then(data => {
            const mapImage = document.getElementById("map-image");
            const mapData = data.data;

            if(mapData.images && mapData.images.pois) {
                mapImage.src = mapData.images.pois;
            }
        })
        .catch(err => {
            console.error("Error cargando el mapa:", err);
        });
    </script>';
        break;

    case 'modos':
    default:
        $modos = [
            'Ballistic' => 'modofornite/Ballistic_29_-_Playlist_-_Fortnite.webp',
            'Battle Royale' => 'modofornite/Battle_Royale_-_Playlist_-_Fortnite.webp',
            'Creativo' => 'modofornite/Creative_-_Mode_-_Fortnite.webp',
            'Fortnite OG' => 'modofornite/Fortnite_OG_-_Playlist_-_Fortnite.webp',
            'LEGO Fortnite' => 'modofornite/LEGO_Fortnite_-_Keyart_-_Fortnite.webp',
            'Clasificatoria' => 'modofornite/Ranked_Battle_Royale_-_Gamemode_-_Fortnite.webp',
            'Rocket Racing' => 'modofornite/Rocket_Racing_-_Keyart_-_Fortnite.webp',
            'Cero Construcción' => 'modofornite/Zero_Build_-_Playlist_-_Fortnite.webp',
            'Recarga' => 'modofornite/Reload_-_Playlist_-_Fortnite.webp',
            'Fornite Festival' => 'modofornite/Festival_Main_Stage_-_Playlist_-_Fortnite.webp',
        ];

        $contenido = '
    <div class="modos-container">
         <h1 style="color: #D4AF37; text-shadow: 0 0 10px rgba(212, 175, 55, 0.5);">MODOS DE JUEGO</h1>
        <div class="grid-modos">';

        foreach ($modos as $nombre => $imagen) {
            $contenido .= '
        <div class="modo-card" onclick="window.location.href=\'infoFortnite.php?modo=' . urlencode($nombre) . '\'">
            <div class="modo-img-container">
                <img src="' . htmlspecialchars($imagen) . '" alt="' . htmlspecialchars($nombre) . '" loading="lazy">
            </div>
            <div class="modo-title-container">
            <h3 style="color: #D4AF37;">' . htmlspecialchars($nombre) . '</h3>   
          </div>
        </div>';
        }

        $contenido .= '
        </div>
    </div>';
        break;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titulo) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../CSS/infcssfornite.css">


    <style>
        :root {
            --gamebar-bg: #111214;
            --gamebar-text: #b0b0b0;
            --gamebar-hover: #ffffff;
            --gamebar-active: #D4AF37;
            --gamebar-border: #333;
            --gamebar-highlight: rgba(212, 175, 55, 0.2);
            --primary-dark: #0A0A0A;
            --primary-gold: #D4AF37;
            --secondary-gold: #F5D98F;
            --text-light: #F0F0F0;
            --text-gray: #A0A0A0;
        }

        /* ESTILOS GENERALES */
        body {
            font-family: 'Montserrat', 'Helvetica Neue', Arial, sans-serif;
            background-color: var(--primary-dark);
            color: var(--text-light);
            margin: 0;
            padding: 0;
        }

        /* BARRA DE NAVEGACIÓN */
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

        /* BARRA DE SECCIONES */
        .section-bar {
            background: #1e1e1e;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            overflow-x: auto;
        }

        .section-bar a {
            color: #fff;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 6px;
            background-color: #444;
            transition: background 0.3s;
        }

        .section-bar a.active,
        .section-bar a:hover {
            background-color: #D4AF37;
            color: #000;
        }

        #searchInput {
            margin-left: auto;
            padding: 6px 12px;
            border-radius: 4px;
            border: 1px solid #ccc;
            outline: none;
        }

        /* CONTENIDO PRINCIPAL */
        .modos-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .modos-container h1 {
            text-align: center;
            font-size: 3rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #fff;
            text-shadow: 0 0 10px rgba(191, 255, 0, 0.5), 0 0 20px #D4AF37;
            margin-bottom: 40px;
            font-family: "Burbank Big Condensed", sans-serif;
        }

        .grid-modos {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 30px;
        }

        .modo-card {
            background: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            border: 2px solid rgba(255, 255, 255, 0.1);
            cursor: pointer;
        }

        .modo-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px #D4AF37;
            border-color: #D4AF37;
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
            padding: 15px;
            background: linear-gradient(to right, rgb(0, 0, 0), rgb(0, 0, 0));
            text-align: center;
        }

        .modo-title-container h3 {
            margin: 0;
            color: white;
            font-size: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-family: "Burbank Big Condensed", sans-serif;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
        }

        /* COSMÉTICOS */
        .cosmeticos-container {
            padding: 40px 0;
        }

        .grid-cosmeticos {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .cosmetico-card {
            background-color: #1a1a1a;
            padding: 15px;
            border-radius: 8px;
            transition: all 0.3s;
            border: 1px solid rgba(212, 175, 55, 0.2);
            text-align: center;
        }

        .cosmetico-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(212, 175, 55, 0.2);
            border-color: rgba(212, 175, 55, 0.5);
        }

        .cosmetico-card img {
            width: 100%;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .cosmetico-card h3 {
            color: #F5D98F;
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .cosmetico-card p {
            color: #A0A0A0;
            font-size: 0.9rem;
            margin: 5px 0;
        }

        /* TIENDA */
        .tienda-container {
            padding: 40px 0;
        }

        .type-section {
            margin-bottom: 50px;
        }

        .shop-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 20px;
        }

        .item-card {
            background-color: #1a1a1a;
            padding: 15px;
            border-radius: 8px;
            transition: all 0.3s;
            border: 1px solid rgba(212, 175, 55, 0.2);
            text-align: center;
        }

        .item-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(212, 175, 55, 0.2);
            border-color: rgba(212, 175, 55, 0.5);
        }

        .item-card img {
            width: 100%;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .item-name {
            color: #E0E0E0;
            font-size: 1rem;
            margin-bottom: 5px;
        }

        .item-price {
            color: #D4AF37;
            font-weight: bold;
            font-size: 1.1rem;
        }

        /* MAPA */
        .map-container {
            margin-top: 30px;
            border: 2px solid rgba(212, 175, 55, 0.3);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
        }

        .map-container img {
            width: 100%;
            max-width: 800px;
            display: block;
            margin: 0 auto;
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
        @media (max-width: 992px) {
            .nav-container {
                height: 70px;
            }

            .logo-section img {
                height: 50px;
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

            .modos-container h1 {
                font-size: 2.5rem;
            }

            .grid-modos,
            .shop-container,
            .grid-cosmeticos {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }
        }

        @media (max-width: 768px) {
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

            .modos-container h1 {
                font-size: 2rem;
            }

            .grid-modos,
            .shop-container,
            .grid-cosmeticos {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 15px;
            }

            .modo-title-container h3 {
                font-size: 1.2rem;
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

            .modo-img-container {
                height: 120px;
            }
        }

        .internal-nav {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 40px;
            flex-wrap: wrap;
            align-items: center;
        }

        .internal-nav a {
            color: var(--text-light);
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 30px;
            background: rgba(0, 0, 0, 0.7);
            border: 1px solid var(--primary-gold);
            transition: all 0.3s;
            font-weight: bold;
        }

        .internal-nav a:hover {
            background: var(--primary-gold);
            color: var(--primary-dark);
        }

        .internal-nav a.active {
            background: var(--primary-gold);
            color: var(--primary-dark);
        }

        .search-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-container input {
            padding: 10px 20px 10px 35px;
            border-radius: 30px;
            border: 1px solid var(--primary-gold);
            background: rgba(0, 0, 0, 0.7);
            color: var(--text-light);
            outline: none;
        }

        .search-container .fa-search {
            position: absolute;
            left: 12px;
            color: var(--primary-gold);
        }
    </style>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <title><?= htmlspecialchars($titulo) ?> Fortnite</title>
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
    <nav class="internal-nav">
        <a href="?seccion=modos" class="<?= $seccion === 'modos' ? 'active' : '' ?>">Modos</a>
        <a href="?seccion=cosmeticos" class="<?= $seccion === 'cosmeticos' ? 'active' : '' ?>">Cosméticos</a>
        <a href="?seccion=tienda" class="<?= $seccion === 'tienda' ? 'active' : '' ?>">Tienda</a>
        <a href="?seccion=mapa" class="<?= $seccion === 'mapa' ? 'active' : '' ?>">Mapa</a>
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Buscar..." onkeyup="filtrarContenido()">
        </div>
    </nav>

    <main>
        <?= $contenido ?>
    </main>


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
<script>
    function filtrarContenido() {
        const input = document.getElementById('searchInput');
        const filtro = input.value.toLowerCase();
        const tarjetas = document.querySelectorAll('.item-card, .cosmetico-card, .modo-card');

        tarjetas.forEach(card => {
            const texto = card.textContent.toLowerCase();
            card.style.display = texto.includes(filtro) ? '' : 'none';
        });
    }
</script>


</html>