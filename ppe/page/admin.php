<?php

header('Content-Type: text/html; charset=utf-8');
session_start();

include 'config.php';

$mdp = isset($_POST['mdp']) ? $_POST['mdp'] : null;

if ($mdp === "admin") {
  $_SESSION['is_admin'] = true; // On stocke qu'il est admin
  header("Location: admin.php");
  exit();
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portfolio</title>
  <link rel="stylesheet" href="style.css">
</head>

<body class="bg-accueil">

  <header>
    <div class="header-container">
        <button style="font-size: 20px">espace administrateur</button>
        <a href="logout.php">Se déconnecter</a>
    </div>
  </header>

  <div class="body">

  <div class="project-card">
          <h3>Liste de tous les utilisateurs</h3>
          <div id="users-list">
            <?php
            $stmt = $mysqlClient->query("SELECT * FROM utilisateur");
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($users as $user) {
                echo "<p>" . htmlspecialchars($user['nom']) . " " . htmlspecialchars($user['prenom']) . ", " . htmlspecialchars($user['age']) . " ans</p>";
                echo '<a href="index.php?id=' . $user['id'] . '">Modifier</a>';
                echo ' | <a href="delete_user.php?id=' . $user['id'] . '">Supprimer</a>';
            }
            ?>
          </div>
         </div>

        <div class="project-card">
        <h3>Ajouter un utilisateur </h3>
                <form action="../requete/add_user.php" method="POST">

                    <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom" required><br><br>

                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" name="prenom" required><br><br>

                    <label for="age">Âge :</label>
                    <input type="number" id="age" name="age" required><br><br>

                    <label for="date_de_naissance" :>Date de naissance :</label>
                    <input type="date" id="date_de_naissance" name="date_de_naissance" required><br><br>

                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" required><br><br>

                    <label for="numero">Numéro :</label>
                    <input type="number" id="numero" name="numero" required><br><br>

                    <label for="numero">mot de passe :</label>
                    <input type="text" id="mdp" name="mdp" required><br><br>

                    <button type="submit">Ajouter l'utilisateur</button>
          </form>
        </div>


        
        </div>
       </div>

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
