<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fornite</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome para íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="CSS/styleindex.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<style>
      .fortnite-hero {
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                    url('https://images.contentstack.io/v3/assets/bltb6530b271fddd0b1/blt29d7c4f6bc077e9a/5eb26f54402b8b4d13a56656/fortnite-ch2-s2-keyart.jpg') no-repeat center center;
        background-size: cover;
        height: 80vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .hero-content {
        text-align: center;
        width: 100%;
        color: white;
        z-index: 2;
    }

    .fortnite-title {
        font-size: 5rem;
        font-weight: 900;
        text-transform: uppercase;
        background: linear-gradient(to right,rgb(255, 255, 255),rgb(255, 255, 255),rgb(255, 255, 255));
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        margin-bottom: 1rem;
    }

    .fortnite-subtitle {
        font-size: 1.8rem;
        margin-bottom: 2rem;
        text-shadow: 2px 2px 4px #000;
        color: #D4AF37;
    }

    .fortnite-cta {
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
        text-shadow: 2px 2px 4px #000;
    }

    .fortnite-btn {
        background: linear-gradient(to right,rgb(0, 26, 255),rgb(0, 110, 255));
        border: none;
        border-radius: 50px;
        padding: 15px 40px;
        font-size: 1.5rem;
        font-weight: bold;
        color: white;
        box-shadow: 0 0 20px rgba(0, 4, 255, 0.7);
        transition: all 0.3s;
    }

    .fortnite-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 0 30px rgba(0, 26, 255, 0.9);
    }

    .pause-btn {
        position: absolute;
        bottom: 20px;
        left: 20px;
        background: rgba(0, 0, 0, 0.5);
        border: 2px solid white;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        transition: all 0.3s;
        z-index: 10;
    }

    .pause-btn:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .pause-icon {
        color: white;
        font-size: 1.2rem;
    }
     .fortnite-hero {
        position: relative;
        height: 80vh;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .video-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        color: white;
        padding: 20px;
    }
    .nav-btn i {
        font-size: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Opcional: Ajusta el tamaño del botón si es necesario */
    .nav-btn {
        width: 70px;
        height: 70px;
    }

    :root {
        --gamebar-bg: #101113;
        --gamebar-text: rgb(110, 110, 110);
        --gamebar-hover: rgb(254, 254, 255);
        --gamebar-border: #333;
        --page-bg: #d9d9d9;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: var(--page-bg);
        margin: 0;
        padding: 0;
    }

    /* Barra de navegación superior */
    .game-bar {
        background-color: var(--gamebar-bg);
        border-bottom: 1px solid var(--gamebar-border);
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
        color: var(--gamebar-text);
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
        color: var(--gamebar-hover);
        border-bottom: 2px solid var(--gamebar-hover);
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
        color: var(--gamebar-text);
        font-size: 1.3rem;
        cursor: pointer;
        transition: all 0.2s;
        padding: 8px 12px;
    }

    .hamburger-menu:hover {
        color: var(--gamebar-hover);
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 4px;
    }

    :root {
        --primary-dark: #0A0A0A;
        /* Negro profundo */
        --primary-gold: #D4AF37;
        /* Dorado clásico */
        --secondary-gold: #F5D98F;
        /* Dorado claro */
        --text-light: #F0F0F0;
        /* Texto claro */
        --text-gray: #A0A0A0;
        /* Texto secundario */
    }

    body {
        font-family: 'Montserrat', 'Helvetica Neue', Arial, sans-serif;
        background-color: var(--primary-dark);
        color: var(--text-light);
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }

    .about-section {
        display: flex;
        min-height: 100vh;
        position: relative;
    }

    .content-wrapper {
        display: flex;
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        z-index: 2;
    }

    :root {
        --primary-dark: #0A0A0A;
        --primary-gold: #D4AF37;
        --secondary-gold: #F5D98F;
        --text-light: #F0F0F0;
    }

    /* ESTILOS DEL FOOTER */
    .custom-footer {
        background-color: #111214;
        /* Fondo negro grisáceo */
        padding: 30px 20px;
        border-top: 2px solid #D4AF37;
        /* Borde dorado */
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

    .game-item {
        background-color: rgba(255, 255, 255, 0.08);
        padding: 6px 12px;
        border-radius: 15px;
        font-size: 0.9rem;
        color: #F0F0F0;
        transition: all 0.3s;
        cursor: pointer;
    }

    .game-item:hover {
        background-color: #D4AF37;
        /* Dorado al hover */
        color: #0A0A0A;
        /* Texto negro */
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
        /* Dorado al hover */
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
</style>

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
    <!-- Sección Hero con Video de Fortnite -->
<div class="fortnite-hero">
    <!-- Video de fondo -->
    <video autoplay muted loop id="fortniteVideo" class="video-bg">
        <source src="imglogo/Trailers/trailerf.mp4" type="video/mp4">
        <!-- Si el video no carga, muestra la imagen de fondo -->
        Tu navegador no soporta videos HTML5.
    </video>
    
    <!-- Botón de pausa -->
    <div class="pause-btn" id="pauseBtn">
        <i class="fas fa-pause pause-icon" id="pauseIcon"></i>
    </div>

    <div class="container hero-content">
        <h1 class="fortnite-title">FORTNITE</h1>
        <h2 class="fortnite-subtitle">UNA BATALLA POR LA QUE VALE LA PENA LUCHAR</h2>
        <p class="fortnite-cta">ACCIÓN EN EQUIPO</p>
        <button class="fortnite-btn">JUEGA YA</button>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Activar el juego seleccionado
    document.querySelectorAll('.game-item').forEach(item => {
        item.addEventListener('click', function() {
            document.querySelectorAll('.game-item').forEach(i => i.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Menú hamburguesa (placeholder funcional)
    document.querySelector('.hamburger-menu').addEventListener('click', function(e) {
        e.stopPropagation();
        alert('Menú desplegable activado');
    });

    // Barra arrastrable horizontal (con mouse)
    let isDown = false;
    let startX;
    let scrollLeft;
    const scroller = document.querySelector('.game-scroller');

    scroller.addEventListener('mousedown', (e) => {
        isDown = true;
        startX = e.pageX - scroller.offsetLeft;
        scrollLeft = scroller.scrollLeft;
    });

    scroller.addEventListener('mouseleave', () => {
        isDown = false;
    });

    scroller.addEventListener('mouseup', () => {
        isDown = false;
    });

    scroller.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - scroller.offsetLeft;
        const walk = (x - startX) * 2;
        scroller.scrollLeft = scrollLeft - walk;
    });
       const video = document.getElementById('fortniteVideo');
    const pauseBtn = document.getElementById('pauseBtn');
    const pauseIcon = document.getElementById('pauseIcon');
    let isPlaying = true;

    // Controlar pausa/play del video
    pauseBtn.addEventListener('click', function() {
        if (isPlaying) {
            video.pause();
            pauseIcon.classList.remove('fa-pause');
            pauseIcon.classList.add('fa-play');
        } else {
            video.play();
            pauseIcon.classList.remove('fa-play');
            pauseIcon.classList.add('fa-pause');
        }
        isPlaying = !isPlaying;
    });

    // Reiniciar video si termina (opcional)
    video.addEventListener('ended', function() {
        video.currentTime = 0;
        video.play();
    });
</script>


</html>