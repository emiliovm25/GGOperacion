<?php
// Verificar si se pasó el parámetro 'key'
if (!isset($_GET['key'])) {
    die("Modo no especificado.");
}

$name = $_GET['key'];

// Obtener todos los modos desde la API
$apiJson = file_get_contents("https://overfast-api.tekrop.fr/gamemodes?locale=es-es");
$gamemodes = json_decode($apiJson, true);

// Validar respuesta de la API
if (!$gamemodes || !is_array($gamemodes)) {
    die("Error al obtener los modos de juego.");
}

// Buscar el modo por su nombre
$modo = null;
foreach ($gamemodes as $gm) {
    if (strcasecmp($gm['name'], $name) === 0) {
        $modo = $gm;
        break;
    }
}

// Si no se encuentra el modo
if (!$modo) {
    die("Modo de juego no encontrado.");
}

// Escapar texto para evitar problemas de seguridad
$modoName = htmlspecialchars($modo['name']);
$modoDescription = htmlspecialchars($modo['description']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $modoName ?> - Modo de Overwatch</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #0d0d0d;
            color: #fff;
        }

        .contenedor {
            max-width: 800px;
            margin: 80px auto;
            background-color: #1a1a1a;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.2);
        }

        h1 {
            font-size: 36px;
            color: #D4AF37;
            margin-bottom: 20px;
        }

        p.descripcion {
            font-size: 18px;
            color: #ccc;
            line-height: 1.6;
        }

        .boton-volver {
            margin-top: 30px;
            display: inline-block;
            background-color: #D4AF37;
            color: #000;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
        }

        .boton-volver:hover {
            background-color: #e5c96a;
        }

        @media (max-width: 600px) {
            .contenedor {
                margin: 30px 15px;
                padding: 25px;
            }

            h1 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>

<div class="contenedor">
    <h1><?= $modoName ?></h1>
    <p class="descripcion"><?= nl2br($modoDescription) ?></p>

    <a href="overwachtcontenido.php?seccion=gamemodes" class="boton-volver">← Volver a modos</a>
</div>

</body>
</html>
