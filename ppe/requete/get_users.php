<?php
header('Content-Type: text/html; charset=utf-8');

try {
  $mysqlClient = new PDO('mysql:host=localhost;dbname=database_ppe;charset=utf8', 'root', 'root');
  $mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo 'Connexion réussie !';
} catch (Exception $e) {
  die('Erreur de connexion : ' . $e->getMessage());
}



$stmt = $mysqlClient->query("SELECT * FROM utilisateur");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
  echo "<p>" . htmlspecialchars($user['nom']) . " " . htmlspecialchars($user['prenom']) . " " . htmlspecialchars($user['age']) . " ans</p>";
  echo "<a href='edit_user.php?id=" . $user['id'] . "' style='margin-right: 10px; padding: 5px 10px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 4px;'>Modifier</a>";
  echo "<a href='../requete/delete_user.php?id=" . $user['id'] . "' onclick='return confirm(\"Voulez-vous vraiment supprimer cette personne ?\");' style='padding: 5px 10px; background-color: #FF4C4C; color: white; text-decoration: none; border-radius: 4px;'>Supprimer</a>";
}
?>