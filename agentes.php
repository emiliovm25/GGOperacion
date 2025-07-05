<?php
$apiUrl = "https://valorant-api.com/v1/agents?language=es-MX";
$response = file_get_contents($apiUrl);
$data = json_decode($response, true);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agentes - Valorant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

        .selection-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin: 60px auto 40px auto;
            max-width: 1000px;
        }

        .selection-item {
            width: 100px;
            height: 100px;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s, border 0.3s;
            border: 2px solid transparent;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .selection-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
        }

        .selection-item:hover {
            transform: scale(1.1);
            border-color: var(--primary-gold);
        }

        .agent-display-name {
            text-align: center;
            font-size: 1.8rem;
            color: var(--primary-gold);
            margin-bottom: 20px;
            min-height: 40px;
        }

        .agent-label {
            text-align: center;
            color: var(--primary-gold);
            font-size: 0.9rem;
            margin-top: 5px;
        }
    </style>
</head>
<body>

    <h1>Agentes de Valorant</h1>

    <!-- Mostrar nombre dinámico -->
    <div class="agent-display-name" id="agentName">Selecciona un agente</div>

    <!-- Menú de selección rápida -->
    <div class="selection-grid">
        <?php foreach ($data['data'] as $agente): ?>
            <?php if (!empty($agente['isPlayableCharacter']) && !empty($agente['displayIcon'])): ?>
                <div class="selection-item"
                     data-name="<?= htmlspecialchars($agente['displayName']) ?>"
                     data-uuid="<?= $agente['uuid'] ?>">
                    <img src="<?= htmlspecialchars($agente['displayIcon']) ?>" alt="<?= htmlspecialchars($agente['displayName']) ?>">
                    <div class="agent-label"><?= htmlspecialchars($agente['displayName']) ?></div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!-- Script -->
    <script>
    window.onload = function () {
        const nameDisplay = document.getElementById('agentName');
        const agentItems = document.querySelectorAll('.selection-item');

        agentItems.forEach(item => {
            const name = item.dataset.name;
            const uuid = item.dataset.uuid;

            item.addEventListener('mouseover', () => {
                nameDisplay.textContent = name;
            });

            item.addEventListener('mouseout', () => {
                nameDisplay.textContent = 'Selecciona un agente';
            });

            item.addEventListener('click', () => {
                window.location.href = "agentesDetalle.php?uuid=" + uuid;
            });
        });
    };
    </script>

</body>
</html>
