<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Obtener el parámetro modo
$modo_id = $_GET['modo'] ?? '';

$modos = [
    'clasico' => [
        'name' => 'Clásico',
        'description' => 'El modo de juego estándar 5v5 con tres calles y jungla',
        'map' => 'Grieta del Invocador',
        'image' => 'imglogo/clasico.webp',
        'map_image' => 'imglogo/mapa_clasico.jpg',
        'historia' => 'Lanzado el 27 de octubre de 2009 con el debut de League of Legends, el modo Clásico fue inspirado por el mod Defense of the Ancients (DotA) de Warcraft III. En 2014 recibió su primera gran actualización visual (VU) con nuevos gráficos y diseño. En 2023 se rediseñó completamente como "Grieta del Invocador 2.0" para la temporada 13, manteniendo la esencia estratégica que lo hizo popular mientras modernizaba sus elementos visuales y mecánicas de jungla.',
        'datos_interesantes' => "• Modo 5v5 en mapa simétrico con 3 carriles y jungla\n• 11 torres, 3 inhibidores y 1 nexo por equipo\n• Objetivos épicos: Dragón (5:00) y Barón Nashor (20:00)\n• 4 tipos de Dragones Elementales con buffs únicos\n• Tiempo promedio: 25-35 minutos\n• Más de 150 cambios significativos desde su lanzamiento\n• Modo principal para competencia profesional",
        'mapa_detalle' => '
        <div class="map-feature">
            <h4><i class="fas fa-chess-board"></i> Estructura</h4>
            <ul>
                <li><strong>3 Carriles:</strong> Superior (Top, 1v1), Medio (Mid, 1v1), Inferior (Bot, 2v2)</li>
                <li><strong>Jungla:</strong> 4 cuadrantes con 12 campamentos de monstruos</li>
                <li><strong>Bases:</strong> Torres, Inhibidores y Nexo por equipo</li>
            </ul>
        </div>
        <div class="map-feature">
            <h4><i class="fas fa-dragon"></i> Objetivos Neutrales</h4>
            <div class="feature">
                <img src="imglogo/dragon_icon.png" alt="Dragón">
                <div>
                    <h5>Dragón Elemental</h5>
                    <p>4 variantes (Fuego, Tierra, Aire, Agua) que otorgan buffs de equipo únicos. El Alma de Dragón (después de 4 muertes) da un potente bonus.</p>
                </div>
            </div>
            <div class="feature">
                <img src="imglogo/baron_icon.png" alt="Barón">
                <div>
                    <h5>Barón Nashor</h5>
                    <p>Aparece a los 20:00. Otorga "Mano del Barón" (empuje mejorado de súbditos) durante 3 minutos y buffs de combate.</p>
                </div>
            </div>
        </div>
        <div class="map-feature">
            <h4><i class="fas fa-leaf"></i> Plantas Especiales</h4>
            <ul>
                <li><strong>Planta de Visión:</strong> Revela área circundante al ser destruida</li>
                <li><strong>Planta de Salud:</strong> Cura al equipo que la activa</li>
                <li><strong>Blastocono:</strong> Empuja a los campeones lejos</li>
            </ul>
        </div>',
        'map_description' => 'La Grieta del Invocador es el campo de batalla principal del juego. Dividido en tres carriles con una jungla densa, es donde se juegan las partidas competitivas más emblemáticas. Su diseño simétrico permite estrategias complejas y jugadas coordinadas entre equipos.'
    ],
    'aram' => [
        'name' => 'ARAM',
        'description' => 'Todos Aleatorio Mid (All Random All Mid) - Un solo carril 5v5',
        'map' => 'Abismo de los Lamentos',
        'image' => 'imglogo/aram.png',
        'map_image' => 'imglogo/mapa_aram.jpg',
        'historia' => 'ARAM surgió como moda comunitaria en 2010, jugado en el mapa Clásico con reglas no oficiales: todos mid, campeones aleatorios y sin recall. Riot lo hizo oficial en 2013 con el mapa "Campo de Pruebas". En 2014 se lanzó el "Abismo de los Lamentos" con temática de Freljord, reemplazando definitivamente al Campo de Pruebas. La versión actual (2023) incluye balance específico para campeones y el popular "Evento de Nieve" que altera el terreno. Es el primer modo creado por jugadores en convertirse en oficial.',
        'datos_interesantes' => "• 5v5 en un solo carril sin jungla\n• Campeones asignados aleatoriamente (All Random)\n• Sistema de rerolls (2 acumulables)\n• Health Relics reemplazan las pociones (cura 8% de vida máxima)\n• +50 Tenacidad para todos los campeones\n• Sin recall - Compras solo al morir\n• Tiempo promedio: 15-20 minutos\n• Más de 20 millones de partidas mensuales",
        'mapa_detalle' => '
        <div class="map-feature">
            <h4><i class="fas fa-road"></i> Estructura</h4>
            <ul>
                <li><strong>1 Carril:</strong> 2 torres y 1 inhibidor por equipo</li>
                <li><strong>Health Relics:</strong> 2 por lado (aparecen cada 60 segundos)</li>
                <li><strong>Arbustos:</strong> 2 zonas estratégicas cerca del centro</li>
                <li><strong>Puente destruible:</strong> Evento de nieve cada 3 minutos</li>
            </ul>
        </div>
        <div class="map-feature">
            <h4><i class="fas fa-snowflake"></i> Mecánicas Especiales</h4>
            <div class="feature">
                <img src="imglogo/snowball_icon.png" alt="Evento de nieve">
                <div>
                    <h5>Evento de Nieve</h5>
                    <p>Tormenta periódica que destruye secciones del puente, alterando el terreno de batalla y creando nuevas zonas de combate.</p>
                </div>
            </div>
            <div class="feature">
                <img src="imglogo/poro_icon.png" alt="Poros">
                <div>
                    <h5>Poros</h5>
                    <p>Criaturas interactivas que aparecen cerca de las plataformas de spawn. Si todos los jugadores saludan a un Poro, este crece de tamaño.</p>
                </div>
            </div>
        </div>
        <div class="map-feature">
            <h4><i class="fas fa-random"></i> Sistema de Campeones</h4>
            <ul>
                <li><strong>Cambios limitados:</strong> Usando puntos de reroll (máx. 2 acumulables)</li>
                <li><strong>Intercambios:</strong> Permitidos entre compañeros si ambos tienen los campeones</li>
                <li><strong>Balance especial:</strong> Campeones reciben ajustes de daño (+/- % según balance)</li>
            </ul>
        </div>',
        'map_description' => 'El Abismo de los Lamentos es un mapa helado de un solo carril. Su diseño simplificado está enfocado en peleas constantes, eliminando la fase de líneas tradicional. El puente central se destruye progresivamente con eventos de nieve, forzando enfrentamientos más intensos.'
    ],
    'arena' => [
        'name' => 'Arena',
        'description' => 'Modo 2v2v2v2 con rondas y aumentos de poder',
        'map' => 'Coliseo',
        'image' => 'imglogo/arenalol.jpg',
        'map_image' => 'imglogo/mapa_arena.jpg',
        'historia' => 'Introducido en julio de 2023 como modo temporal, Arena combina elementos de autobatlers y juegos de arena. Inspirado en el éxito de Nexus Blitz, rápidamente ganó popularidad por su formato rápido (10-15 minutos) y caótico. Tras dos temporadas exitosas, Riot lo convirtió en modo permanente en 2024. Su desarrollo incluyó extensas pruebas con más de 150 aumentos (Augments) diferentes y 4 mapas únicos con mecánicas distintas, convirtiéndose en uno de los modos más innovadores de League of Legends.',
        'datos_interesantes' => "• 2v2v2v2 en rondas eliminatorias\n• 4 mapas diferentes con mecánicas únicas\n• Sistema de aumentos (Augments) cada 2 rondas\n• Más de 150 aumentos diferentes (Plata, Oro, Prismático)\n• Plantas de poder y anillos de fuego\n• Vida compartida (empiezas con 20)\n• Eventos aleatorios en rondas 4 y 6\n• Tiempo promedio: 10-15 minutos",
        'mapa_detalle' => '
        <div class="map-feature">
            <h4><i class="fas fa-map"></i> Variantes de Mapa</h4>
            <div class="variants-grid">
                <div class="variant">
                    <h5><i class="fas fa-sun"></i> Coliseo de Shurima</h5>
                    <ul>
                        <li>Anillo de fuego que se contrae</li>
                        <li>Plataformas móviles periódicas</li>
                        <li>Zonas de tormenta de arena</li>
                    </ul>
                </div>
                <div class="variant">
                    <h5><i class="fas fa-hammer"></i> Forjo de los Herreros</h5>
                    <ul>
                        <li>Yunques que otorgan escudos temporales</li>
                        <li>Zonas de sobrecalentamiento que dañan</li>
                        <li>Martillos interactivos</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="map-feature">
            <h4><i class="fas fa-magic"></i> Aumentos (Augments)</h4>
            <div class="feature">
                <img src="imglogo/aumento_plata.png" alt="Aumento Plata">
                <div>
                    <h5>Plata</h5>
                    <p>Mejoras simples (+stats, efectos básicos). Ej: "+20% Daño de Ataque"</p>
                </div>
            </div>
            <div class="feature">
                <img src="imglogo/aumento_oro.png" alt="Aumento Oro">
                <div>
                    <h5>Oro</h5>
                    <p>Cambios de juego (habilidades modificadas). Ej: "Tus habilidades queman el terreno"</p>
                </div>
            </div>
            <div class="feature">
                <img src="imglogo/aumento_prisma.png" alt="Aumento Prismático">
                <div>
                    <h5>Prismático</h5>
                    <p>Transformadores (mecánicas completamente nuevas). Ej: "Ganas una habilidad adicional"</p>
                </div>
            </div>
        </div>
        <div class="map-feature">
            <h4><i class="fas fa-fire"></i> Mecánicas de Ronda</h4>
            <ul>
                <li><strong>Plantas de Poder:</strong> 3 tipos (Cura, DPS, Escudo) aparecen cada ronda</li>
                <li><strong>Anillo de Fuego:</strong> Reduce el área jugable progresivamente</li>
                <li><strong>Eventos Aleatorios:</strong> Prisión de Luz, Tormenta de Meteoritos, etc.</li>
            </ul>
        </div>',
        'map_description' => 'La Arena es un entorno cerrado donde pequeños equipos se enfrentan en intensas rondas. Es rápida, directa, y cada elección cuenta. Con múltiples escenarios cambiantes y un sistema de aumentos que redefine las reglas del juego, ofrece una experiencia única en League of Legends.'
    ]
];

if (!array_key_exists($modo_id, $modos)) {
    die('Modo de juego no válido');
}

$modo = $modos[$modo_id];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($modo['name']) ?> - League of Legends</title>
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
            padding-top: 70px;
            background-color: #000;
            color: #fff;
            font-family: 'Roboto', sans-serif;
            min-height: 100vh;
        }

        .content-wrapper {
            display: flex;
            max-width: 1400px;
            margin: 0 auto;
            flex-direction: column;
        }

        .back-button {
            display: inline-block;
            margin: 20px;
            padding: 12px 25px;
            background-color: rgba(212, 175, 55, 0.2);
            color: #D4AF37;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: all 0.3s;
            border: 1px solid #D4AF37;
        }

        .back-button:hover {
            background-color: rgba(212, 175, 55, 0.4);
            transform: translateX(-5px);
        }

        .back-button i {
            margin-right: 8px;
        }

        .mode-header {
            display: flex;
            align-items: center;
            gap: 30px;
            padding: 30px;
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('<?= $modo['image'] ?>');
            background-size: cover;
            background-position: center;
            min-height: 300px;
        }

        .mode-icon {
            width: 120px;
            height: 120px;
            background-color: rgba(0,0,0,0.7);
            border-radius: 50%;
            padding: 20px;
            border: 3px solid #D4AF37;
        }

        .mode-info {
            flex: 1;
        }

        .mode-name {
            font-size: 3rem;
            font-family: 'Oswald', sans-serif;
            color: #D4AF37;
            margin-bottom: 10px;
        }

        .mode-description {
            font-size: 1.2rem;
            color: #ccc;
            max-width: 800px;
        }

        .mode-map {
            font-size: 1.1rem;
            color: #D4AF37;
            margin-top: 10px;
        }

        .mode-content {
            padding: 30px;
            display: flex;
            gap: 30px;
        }

        .main-content {
            flex: 2;
        }

        .map-container {
            flex: 1;
            position: sticky;
            top: 100px;
            align-self: flex-start;
        }

        .map-image {
            width: 100%;
            border-radius: 10px;
            border: 2px solid #D4AF37;
        }

        .section-title {
            font-size: 2rem;
            color: #D4AF37;
            font-family: 'Oswald', sans-serif;
            margin: 30px 0 15px;
            position: relative;
            padding-bottom: 10px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100px;
            height: 3px;
            background: #D4AF37;
        }

        .story, .interesting-facts {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 20px;
            text-align: justify;
        }

        .interesting-facts {
            background-color: rgba(212, 175, 55, 0.1);
            padding: 20px;
            border-left: 3px solid #D4AF37;
            border-radius: 0 5px 5px 0;
        }

        /* Footer */
        .custom-footer {
            background-color: #111;
            color: white;
            padding: 30px 0 20px;
            margin-top: 50px;
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

        @media (max-width: 992px) {
            .mode-header {
                flex-direction: column;
                text-align: center;
            }
            
            .mode-content {
                flex-direction: column;
            }
            
            .map-container {
                position: static;
                margin-top: 30px;
            }
            
            .hamburger-menu {
                display: block;
            }
            
            .game-scroller {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .mode-name {
                font-size: 2.5rem;
            }
            
            .mode-icon {
                width: 100px;
                height: 100px;
            }
        }

        @media (max-width: 576px) {
            .mode-name {
                font-size: 2rem;
            }
            
            .mode-icon {
                width: 80px;
                height: 80px;
                padding: 15px;
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
        <!-- Botón Volver -->
        <a href="contenidolol.php?seccion=gamemodes" class="back-button">
            <i class="fas fa-arrow-left"></i> Volver a Modos de Juego
        </a>

        <div class="mode-header">
            <img src="imglogo/LOL.png" alt="<?= $modo['name'] ?>" class="mode-icon">
            <div class="mode-info">
                <div class="mode-name"><?= htmlspecialchars($modo['name']) ?></div>
                <div class="mode-description"><?= htmlspecialchars($modo['description']) ?></div>
                <div class="mode-map"><strong>Mapa:</strong> <?= htmlspecialchars($modo['map']) ?></div>
            </div>
        </div>

        <div class="mode-content">
            <div class="main-content">
                <div class="section-title">Historia</div>
                <div class="story"><?= nl2br(htmlspecialchars($modo['historia'])) ?></div>

                <div class="section-title">Datos interesantes sobre el modo del juego</div>
                <div class="interesting-facts"><?= nl2br(htmlspecialchars($modo['datos_interesantes'])) ?></div>
            </div>

            <div class="map-container">
                <img src="<?= $modo['image'] ?>" alt="<?= $modo['map'] ?>" class="map-image">
                <div class="section-title"><?= htmlspecialchars($modo['map']) ?></div>
                <p><?= nl2br(htmlspecialchars($modo['map_description'])) ?></p>
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