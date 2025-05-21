<?php
header('Content-Type: text/html; charset=utf-8');

include '../page/config.php';

$stmt = $mysqlClient->query("SELECT * FROM utilisateur");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
  echo '<div style="padding: 10px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 5px;">';
  echo '<p style="margin-bottom: 10px;">' . 
       htmlspecialchars($user['nom']) . " " . 
       htmlspecialchars($user['prenom']) . " " . 
       htmlspecialchars($user['age']) . " ans</p>";
  
  echo "<a href='../page/edit_user.php?id=" . $user['id'] . "' style='margin-right: 10px; padding: 5px 10px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 4px;'>Modifier</a>";
  
  echo "<a href='../requete_users/delete_user.php?id=" . $user['id'] . "' onclick='return confirm(\"Voulez-vous vraiment supprimer cette personne ?\");' style='padding: 5px 10px; background-color: #FF4C4C; color: white; text-decoration: none; border-radius: 4px;'>Supprimer</a>";
  echo '</div>';
}
?>