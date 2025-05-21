<?php
header('Content-Type: text/html; charset=utf-8');

include '../page/config.php';

$stmt = $mysqlClient->query("SELECT * FROM musique");
$musique = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($musique as $item) {
  echo '<div style="padding: 10px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 5px;">';

    echo '<p style="margin-bottom: 10px;">' . 
        htmlspecialchars($item['titre']) . " - " . 
        htmlspecialchars($item['artiste']) . " - " . 
        htmlspecialchars($item['url']) . '</p>';
  
      
        echo "<a href='../page/edit_musique.php?id=" . $item['id'] . "' 
                style='margin-right: 10px; padding: 5px 10px; 
                       background-color: #4CAF50; color: white; 
                       text-decoration: none; border-radius: 4px; 
                       border: none; cursor: pointer; display: inline-block;'>
                Modifier
              </a>";
        
        echo "<a href='../requete_users/delete_musique.php?id=" . $item['id'] . "' 
                onclick='return confirm(\"Voulez-vous vraiment supprimer cette musique ?\");' 
                style='margin-right: 10px; padding: 5px 10px; 
                       background-color: #FF4C4C; color: white; 
                       text-decoration: none; border-radius: 4px; 
                       border: none; cursor: pointer; display: inline-block;'>
                Supprimer
              </a>";
        
        echo "<a onclick='playMusic(\"" . htmlspecialchars($item['url']) . "\")' 
                style='padding: 5px 10px; background-color: #2196F3; 
                       color: white; border: none; border-radius: 4px; 
                       cursor: pointer; display: inline-block;'>
                Écouter
              </a>";
  
      
  echo '</div>';
}
?>

<div id="youtubePlayer" style="margin-top: 20px;"></div>
