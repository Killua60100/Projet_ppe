<?php
function getCoverImage($artiste) 
{
    // Tableau associatif artiste => image
    $coverImages = [
        'GAZO'     => '../../ppe/document/gazo euphon.jpeg',
        'THEODORA' => '../../ppe/document/pay.jpg',
        'ZIAK'     => '../../ppe/document/ziak.jpg',
        'NINHO'    => '../../ppe/document/ninho-vrais.jpg',
        'SDM'      => '../../ppe/document/sdm-cartier-santos.jpg',
        'NAPS'     => '../../ppe/document/naps-la-kiffance.jpg',
        'MAES'     => '../../ppe/document/maes.jpeg',
        'MRC'      => '../../ppe/document/mrc.jpeg',
        'HAMZA'    => '../../ppe/document/KYKY.jpeg',
        'JOSAS'  => '../../ppe/document/Josas.jpeg',
        'WERENOI'  => '../../ppe/document/werenoi.jpeg',
        'GRADUR'  => '../../ppe/document/gradur.jpg',
        'TKS 2G'  => '../../ppe/document/tks.jpg',
        '4KEUS'  => '../../ppe/document/4keus.jpg',
        'DADI' => '../../ppe/document/DADI.jpg',
        'KOBA LA D'=> '../../ppe/document/KOBA.jpg',
    ];


    // Retourne l'image correspondante si l'artiste existe dans le tableau, sinon une valeur par défaut
    return $coverImages[$artiste] ?? ''; // tu peux mettre une image par défaut genre 'default.jpg' si tu veux
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Liste de titres</title>
  <link rel="stylesheet" href="../styles/styles.css" />
</head>
<body>
<div class="track-list">
    <h2 class="font-bold text-lg mb-4">Titres</h2>
    <ul>
        <?php foreach ($search_results as $index => $item): ?>
            <?php
        $url = htmlspecialchars($item['url']);
        $titre = htmlspecialchars($item['titre']);
        $artiste = htmlspecialchars(strtoupper($item['artiste']));
        
        // Déterminer l'image de fond en fonction de l'artiste
        $coverImage = getCoverImage($artiste);
    ?>
            <li onclick="togglePlay('<?php echo htmlspecialchars($item['url']); ?>', '<?php echo $index; ?>', '<?php echo htmlspecialchars($item['titre']); ?>','<?php echo htmlspecialchars($item['artiste']); ?>')" 
                class="flex items-center justify-between py-2 border-b border-gray-800 hover:bg-gray-800 transition cursor-pointer">
                
                <div class="flex items-center gap-4">
                    <img src="<?php echo $coverImage; ?>" alt="" class="w-12 h-12 object-cover rounded">
                    <div>
                        <div class="font-semibold text-white"><?php echo htmlspecialchars($item['titre']); ?></div>
                        <div class="text-sm text-gray-400"><?php echo htmlspecialchars($item['artiste']); ?></div>
                    </div>
                </div>

                <div class="text-gray-300 text-sm pr-6">
                    <span><?= htmlspecialchars($item['duree'] ?? ''); ?></span>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
</body>
</html>

