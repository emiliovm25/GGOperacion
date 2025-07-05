<?php
if (!isset($_GET['uuid'])) {
    die("Agente no especificado.");
}

$uuid = htmlspecialchars($_GET['uuid']);
$apiUrl = "https://valorant-api.com/v1/agents/{$uuid}?language=es-MX";

function fetchAgentData($url) {
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_HTTPHEADER => ['Accept: application/json']
    ]);
    
    $response = curl_exec($ch);
    if(curl_errno($ch)) {
        die("Error de conexión: " . curl_error($ch));
    }
    
    curl_close($ch);
    return json_decode($response, true);
}

$agentData = fetchAgentData($apiUrl);

if (!$agentData || $agentData['status'] !== 200) {
    die("No se pudo cargar la información del agente.");
}

$agent = $agentData['data'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<title><?= htmlspecialchars($agent['displayName']) ?> - Valorant</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<!-- Font Awesome para el ícono -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
@import url('https://fonts.googleapis.com/css2?family=Oswald:wght@700&family=Roboto&display=swap');
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

.container {
    max-width: 1200px;
    margin: auto;
    padding: 40px 20px;
    position: relative;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 20px;
    z-index: 1;
}

.background-logo {
    position: absolute;
    top: 50%;
    right: 0;
    transform: translateY(-50%);
    width: 700px;
    height: 400px;
    background: url('<?= htmlspecialchars($agent['background']) ?>') no-repeat center;
    background-size: contain;
    opacity: 0.05;
    pointer-events: none;
    z-index: 0;
}

.info {
    flex: 1 1 500px;
    z-index: 1;
}

.agent-name {
    font-family: 'Oswald', sans-serif;
    font-size: 6rem;
    color: var(--primary-gold);
    margin: 0 0 10px;
    text-transform: uppercase;
    line-height: 1;
}

.description {
    font-size: 1.2rem;
    margin-bottom: 20px;
    max-width: 600px;
    color: #ccc;
    line-height: 1.6;
}

.role-section {
    font-size: 1.2rem;
    margin-top: 10px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.role-title {
    font-weight: bold;
    text-decoration: underline;
    text-decoration-color: var(--primary-red);
    margin-bottom: 10px;
}

.role-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    border: 2px solid var(--primary-gold);
    padding: 6px;
    background-color: rgba(255, 255, 255, 0.05);
}

.agent-image-container {
    max-width: 500px;
    flex: 1 1 400px;
    z-index: 1;
    display: flex;
    justify-content: center;
}

.agent-image-container img {
    width: 100%;
    max-height: 400px;
    object-fit: contain;
    display: block;
    user-select: none;
}

.section {
    padding: 40px 20px;
    margin: 20px auto;
    max-width: 1200px;
}

.section-title {
    font-family: 'Oswald', sans-serif;
    font-size: 2.5rem;
    color: var(--primary-gold);
    margin-bottom: 20px;
    border-bottom: 2px solid var(--primary-red);
    padding-bottom: 10px;
}

/* HABILIDADES */
.abilities-wrapper {
    text-align: center;
    margin-top: 40px;
}

.ability-icons {
    display: flex;
    justify-content: center;
    gap: 15px;
    flex-wrap: wrap;
    margin-bottom: 30px;
}

.ability-icon {
    width: 64px;
    height: 64px;
    filter: grayscale(1) brightness(0.4);
    transition: 0.3s;
    cursor: pointer;
    border-radius: 8px;
    background-color: rgba(0,0,0,0.3);
    padding: 8px;
}

.ability-icon.active {
    filter: none;
    transform: scale(1.1);
    background-color: rgba(212, 175, 55, 0.2);
}

.ability-desc-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
}

.ability-desc {
    display: none;
    max-width: 600px;
    text-align: center;
    padding: 20px;
    background-color: rgba(0,0,0,0.3);
    border-radius: 8px;
}

.ability-desc.active {
    display: block;
    animation: fadeIn 0.3s ease-out;
}

.ability-desc h3 {
    color: var(--primary-gold);
    margin-bottom: 10px;
    font-size: 1.5rem;
}

.ability-desc p {
    color: #ccc;
    line-height: 1.6;
    white-space: pre-line;
    font-size: 1rem;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

@media (max-width: 768px) {
    .agent-name {
        font-size: 4rem;
        text-align: center;
    }

    .container {
        flex-direction: column;
        align-items: center;
        padding-top: 60px;
    }

    .background-logo {
        width: 300px;
        height: 200px;
        right: 50%;
        transform: translate(50%, -50%);
        opacity: 0.05;
    }

    .agent-image-container {
        max-width: 100%;
    }
    
    .top-back-button {
        position: absolute;
        top: 20px;
        left: 20px;
        padding: 10px 15px;
        font-size: 0.9rem;
    }
    
    .description {
        text-align: center;
        margin-left: auto;
        margin-right: auto;
    }
    
    .role-section {
        justify-content: center;
    }
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
}
</style>
</head>
<body>
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
    
    <!-- Botón superior fijo para volver atrás -->
    <a href="valorantcontenido.php?seccion=agentes" class="top-back-button">
        <i class="fas fa-arrow-left"></i> Volver a Agentes
    </a>

    <div class="container">
        <div class="info">
            <h1 class="agent-name"><?= strtoupper(htmlspecialchars($agent['displayName'])) ?></h1>
            <p class="description"><?= nl2br(htmlspecialchars($agent['description'])) ?></p>

            <?php if (!empty($agent['role'])): ?>
                <div class="role-section">
                    <div class="role-title">Rol</div>
                    <img src="<?= htmlspecialchars($agent['role']['displayIcon']) ?>" class="role-icon" alt="Rol">
                    <span><?= htmlspecialchars($agent['role']['displayName']) ?></span>
                </div>
            <?php endif; ?>
        </div>

        <div class="agent-image-container">
            <img src="<?= htmlspecialchars($agent['fullPortrait'] ?: $agent['displayIcon']) ?>" alt="<?= htmlspecialchars($agent['displayName']) ?>">
        </div>

        <div class="background-logo"></div>
    </div>

    <!-- Habilidades -->
    <?php if (!empty($agent['abilities'])): ?>
    <div class="section">
        <h2 class="section-title">Habilidades</h2>
        <div class="abilities-wrapper">
            <div class="ability-icons">
                <?php foreach ($agent['abilities'] as $index => $ability): ?>
                    <?php if (!empty($ability['displayIcon'])): ?>
                        <img src="<?= htmlspecialchars($ability['displayIcon']) ?>" alt="<?= htmlspecialchars($ability['displayName']) ?>" class="ability-icon" data-index="<?= $index ?>" onclick="selectAbility(<?= $index ?>)">
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <div class="ability-desc-container">
                <?php foreach ($agent['abilities'] as $index => $ability): ?>
                    <div class="ability-desc" id="desc-<?= $index ?>">
                        <h3><?= htmlspecialchars($ability['displayName']) ?></h3>
                        <p><?= nl2br(htmlspecialchars($ability['description'])) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

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

<script>
    const icons = document.querySelectorAll('.ability-icon');
    const descriptions = document.querySelectorAll('.ability-desc');

    function selectAbility(index) {
        icons.forEach((icon, i) => {
            icon.classList.toggle('active', i === index);
        });
        descriptions.forEach((desc, i) => {
            desc.classList.toggle('active', i === index);
        });
    }

    // Activar la primera habilidad por defecto
    if (icons.length > 0) {
        selectAbility(0);
    }
</script>
</body>
</html>