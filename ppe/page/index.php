<?php

header('Content-Type: text/html; charset=utf-8');
session_start();

include 'config.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: connection.php");
    exit();
}

?>

<h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['user_name']); ?> !</h1>
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

  <script>

    function loadUsers() {
      fetch('../requete/get_users.php')
        .then(response => response.text())
        .then(data => {
          document.getElementById('users-list').innerHTML = data;
        });
    }

    window.onload = loadUsers;

    function checkUrlForPage() {
      const urlParams = new URLSearchParams(window.location.search);
      const page = urlParams.get('page');
      if (page) {
        handlePageChange(page);
      }
    }

    window.onload = function() {
      loadUsers();
      checkUrlForPage();
    };
  </script>

</body>
</html>
