<?php

header('Content-Type: text/html; charset=utf-8');
session_start();

include 'config.php';

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("Location: connection.php");
    exit();
}

// Vérifiez si le nom de l'utilisateur est défini
$user_name = isset($_SESSION['id']) ? htmlspecialchars($_SESSION['id']) : "Utilisateur";

?>

<h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['prenom']); ?> !</h1>
<a href="logout.php">Se déconnecter</a>


<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portfolio</title>
  <link rel="stylesheet" href="style.css">
</head>

<body class="bg-accueil">

  <script  src="../code js/admin.js">>
  </script>

</body>
</html>
