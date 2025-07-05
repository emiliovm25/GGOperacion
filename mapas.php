<div style="background-color: #0A0A0A; padding: 20px;">
    <h1 style="color:rgba(212, 175, 55, 0.5); text-align:center;">Mapas de Valorant</h1>
    <h2 style="color:rgba(212, 175, 55, 0.5); text-align:center;">Explora los escenarios de batalla</h2>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; margin-top: 20px;">
        <?php 
        $apiData = getValorantAPI('maps');
        $nombresMostrados = [];
        foreach($apiData['data'] as $mapa): 
            if ($mapa['displayName'] !== "The Range" && !in_array($mapa['displayName'], $nombresMostrados)): 
                $nombresMostrados[] = $mapa['displayName'];
                $img = $mapa['listViewIcon'] ?: 'https://via.placeholder.com/150';
        ?>
            <div style="background-color: #1e1e1e; border-radius: 8px; overflow: hidden; border: 1px solid #333;">
                <img src="<?= $img ?>" alt="<?= htmlspecialchars($mapa['displayName']) ?>" style="width: 100%; height: 180px; object-fit: cover;">
                <div style="padding: 15px;">
                    <h3 style="color: #D4AF37; margin: 0 0 10px 0;"><?= htmlspecialchars($mapa['displayName']) ?></h3>
                    <button style="background-color: #D4AF37; color: #0A0A0A; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer;">
                        Ver detalles
                    </button>
                </div>
            </div>
        <?php 
            endif;
        endforeach; 
        ?>
    </div>
</div>