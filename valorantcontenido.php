<?php
$seccion = $_GET['seccion'] ?? 'agentes';
?>
<!DOCTYPE html>
<html lang="es-MX">
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap" rel="stylesheet">

<head>
    <meta charset="UTF-8">
    <title>Valorant UI</title>
    <style>
        :root {
            --primary-dark: #0A0A0A;
            --primary-gold: #D4AF37;
            --text-light: #F0F0F0;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: var(--primary-dark);
            font-family: 'Segoe UI', sans-serif;
            color: var(--text-light);
        }

        h1 {
            text-align: center;
            margin-top: 30px;
            color: var(--primary-gold);
            font-size: 3rem;
        }

        .info-panel {
            text-align: center;
            margin-top: 10px;
            font-size: 1.4rem;
        }

        .section-title::after {
            height: 4px;
            background: linear-gradient(to right, transparent, var(--primary-gold), transparent);
        }

        .info-panel span {
            color: var(--primary-gold);
            font-weight: bold;
        }

        .selection-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin: 40px auto;
            max-width: 1000px;
        }

        .selection-item {
            width: 150px;
            height: 150px;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s, border 0.3s;
            border: 2px solid transparent;
            cursor: pointer;
            position: relative;
            background-color: #1a1a1a;
        }

        .selection-item img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 8px;
            background-color: #000;
        }

        .selection-item:hover {
            transform: scale(1.05);
            border-color: var(--primary-gold);
        }

        .map-name {
            position: absolute;
            bottom: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.7);
            color: var(--primary-gold);
            font-weight: bold;
            text-align: center;
            padding: 5px 0;
            font-size: 0.9rem;
        }

        .section-bar {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .section-bar a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            background-color: #222;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .section-bar a.active,
        .section-bar a:hover {
            background-color: var(--primary-gold);
            color: black;
        }

        input[type="text"] {
            padding: 8px;
            border-radius: 5px;
            border: none;
            margin-left: 10px;
            width: 200px;
        }

        /* Barra de navegación superior */
        .game-bar {
            background-color: #101113;
            border-bottom: 1px solid #333;
            padding: 8px 0;
            overflow-x: auto;
            white-space: nowrap;
        }

        .nav-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        /* Sección del logo */
        .logo-section {
            flex-shrink: 0;
            padding-left: 15px;
        }

        /* Sección central de juegos */
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

        /* Items de juegos */
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
            color: rgb(254, 254, 255);
            border-bottom: 2px solid rgb(254, 254, 255);
        }

        /* Iconos de juegos */
        .game-icon {
            width: 24px;
            height: 24px;
            margin-right: 8px;
            object-fit: contain;
        }

        /* Menú hamburguesa */
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

        /* Logo izquierda */
        .footer-logo {
            flex: 1;
            min-width: 150px;
        }

        .footer-logo img {
            max-width: 100px;
            height: auto;
        }

        /* Juegos centro */
        .footer-games {
            flex: 2;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            padding: 0 15px;
        }

        /* Items de juegos en footer */
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

        /* Redes derecha */
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

        /* Texto inferior */
        .footer-bottom {
            text-align: center;
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.6);
        }

        /* Responsive */
        @media (max-width: 768px) {
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

        .internal-nav {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 30px 0 40px;
            flex-wrap: wrap;
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

        .section-title {
            text-align: center;
            margin: 30px 0;
            color: var(--primary-gold);
            font-size: 3rem;
            position: relative;
            padding-bottom: 15px;
            font-family: 'Oswald', sans-serif;
            text-transform: uppercase;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 150px;
            height: 3px;
            background: var(--primary-gold);
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
    <nav class="internal-nav">
        <a href="?seccion=agentes" class="<?= $seccion === 'agentes' ? 'active' : '' ?>">Agentes</a>
        <a href="?seccion=mapas" class="<?= $seccion === 'mapas' ? 'active' : '' ?>">Mapas</a>
        <a href="?seccion=modos" class="<?= $seccion === 'modos' ? 'active' : '' ?>">Modos</a>
        <a href="?seccion=armas" class="<?= $seccion === 'armas' ? 'active' : '' ?>">Armas</a>
    </nav>
    <h1 class="section-title">
        <?php
        if ($seccion === 'agentes') {
            echo 'Selecciona el personaje';
        } elseif ($seccion === 'mapas') {
            echo 'Selecciona un mapa';
        } elseif ($seccion === 'modos') {
            echo 'Selecciona un modo de juego';
        } elseif ($seccion === 'armas') {
            echo 'Selecciona un arma';
        }
        ?>
    </h1>
    <div class="info-panel">
        <?php if ($seccion === 'agentes'): ?>
            <span id="hoverAgentName">Ninguno</span>
        <?php endif; ?>
    </div>

    <!-- Contenedores por sección -->
    <?php if ($seccion === 'agentes'): ?>
        <div class="selection-grid" id="agentGrid"></div>
    <?php elseif ($seccion === 'mapas'): ?>
        <div class="selection-grid" id="mapGrid"></div>
    <?php elseif ($seccion === 'modos'): ?>
        <div class="selection-grid" id="gamemodeGrid"></div>
    <?php elseif ($seccion === 'armas'): ?>
        <div class="selection-grid" id="weaponGrid"></div>
    <?php endif; ?>

    <!-- Scripts por sección -->
    <?php if ($seccion === 'agentes'): ?>
        <script>
            fetch("https://valorant-api.com/v1/agents?isPlayableCharacter=true")
                .then(res => res.json())
                .then(data => {
                    const agents = data.data;
                    const grid = document.getElementById("agentGrid");
                    const hoverName = document.getElementById("hoverAgentName");

                    agents.forEach(agent => {
                        const item = document.createElement("div");
                        item.className = "selection-item";

                        const img = document.createElement("img");
                        img.src = agent.displayIconSmall;
                        img.alt = agent.displayName;

                        item.addEventListener("mouseenter", () => {
                            hoverName.textContent = agent.displayName;
                        });
                        item.addEventListener("mouseleave", () => {
                            hoverName.textContent = "Ninguno";
                        });

                        item.addEventListener("click", () => {
                            window.location.href = `agentesDetalle.php?uuid=${agent.uuid}`;
                        });

                        item.appendChild(img);
                        grid.appendChild(item);
                    });
                });
        </script>
    <?php elseif ($seccion === 'mapas'): ?>
        <script>
            fetch("https://valorant-api.com/v1/maps")
                .then(res => res.json())
                .then(data => {
                    const mapas = data.data;
                    const grid = document.getElementById("mapGrid");

                    mapas.forEach(mapa => {
                        const item = document.createElement("div");
                        item.className = "selection-item";

                        const img = document.createElement("img");
                        img.src = mapa.splash;
                        img.alt = mapa.displayName;

                        const name = document.createElement("div");
                        name.className = "map-name";
                        name.textContent = mapa.displayName;

                        item.appendChild(img);
                        item.appendChild(name);

                        item.addEventListener("click", () => {
                            window.location.href = `MapaDetalle.php?uuid=${mapa.uuid}`;
                        });

                        grid.appendChild(item);
                    });
                });
        </script>
    <?php elseif ($seccion === 'modos'): ?>
        <script>
            fetch("https://valorant-api.com/v1/gamemodes?language=es-MX")
                .then(res => res.json())
                .then(data => {
                    const modos = data.data;
                    const grid = document.getElementById("gamemodeGrid");

                    modos.forEach(modo => {
                        if (!modo.displayIcon) return;

                        const item = document.createElement("div");
                        item.className = "selection-item";

                        const img = document.createElement("img");
                        img.src = modo.displayIcon;
                        img.alt = modo.displayName;

                        const name = document.createElement("div");
                        name.className = "map-name";
                        name.textContent = modo.displayName;

                        item.appendChild(img);
                        item.appendChild(name);

                        item.addEventListener("click", () => {
                            window.location.href = `modosValorant.php?uuid=${modo.uuid}`;
                        });

                        grid.appendChild(item);
                    });
                });
        </script>
    <?php elseif ($seccion === 'armas'): ?>
        <script>
            fetch("https://valorant-api.com/v1/weapons?language=es-MX")
                .then(res => res.json())
                .then(data => {
                    const armas = data.data;
                    const grid = document.getElementById("weaponGrid");

                    armas.forEach(arma => {
                        if (!arma.displayIcon) return;

                        const item = document.createElement("div");
                        item.className = "selection-item";

                        const img = document.createElement("img");
                        img.src = arma.displayIcon;
                        img.alt = arma.displayName;

                        const name = document.createElement("div");
                        name.className = "map-name";
                        name.textContent = arma.displayName;

                        item.appendChild(img);
                        item.appendChild(name);

                        item.addEventListener("click", () => {
                            window.location.href = `armasDetalle.php?uuid=${arma.uuid}`;
                        });

                        grid.appendChild(item);
                    });
                });
        </script>
    <?php endif; ?>

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