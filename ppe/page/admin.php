<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

include 'config.php';

$mdp = isset($_POST['mdp']) ? $_POST['mdp'] : null;

if ($mdp === "admin") {
    $_SESSION['is_admin'] = true;
    header("Location: admin.php");
    exit();
}

// Préparer les données avant l'affichage HTML
ob_start();
include '../requete_users/get_users.php';
$users_content = ob_get_clean();

ob_start();
include '../requete_musique/get_musique.php';
$musique_content = ob_get_clean();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Style général */
        body {
            background-color: #181818;
            color: white;
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Header */
        .header-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-container button {
            background: linear-gradient(45deg, #ff00ff, #00ffff);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 500;
            transition: transform 0.3s ease;
        }

        .header-container a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .header-container a:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: scale(1.05);
        }

        /* Conteneur principal */
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        /* Cartes des projets */
        .project-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            transition: transform 0.3s ease;
        }

        .project-card:hover {
            transform: translateY(-5px);
        }

        .project-card h3 {
            color: white;
            margin-bottom: 20px;
            font-size: 1.5em;
            border-bottom: 2px solid #ff00ff;
            padding-bottom: 10px;
        }

        /* Formulaires */
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        form label {
            color: #bbbbbb;
            font-size: 0.9em;
        }

        form input {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            padding: 12px;
            color: white;
            font-size: 1em;
            transition: all 0.3s ease;
        }

        form input:focus {
            outline: none;
            border-color: #ff00ff;
            background: rgba(255, 255, 255, 0.15);
        }

        /* Boutons */
        button[type="submit"] {
            background: linear-gradient(45deg, #ff00ff, #00ffff);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-size: 1em;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        button[type="submit"]:hover {
            transform: scale(1.02);
        }

        /* Listes */
        #users-list, #musique-list {
            margin-top: 15px;
        }

        #users-list p, #musique-list p {
            background: rgba(255, 255, 255, 0.05);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #users-list a, #musique-list a {
            color: #00ffff;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        #users-list a:hover, #musique-list a:hover {
            background: rgba(0, 255, 255, 0.1);
        }
    </style>
</head>

<body class="bg-accueil">
    <header>
        <div class="header-container">
            <button style="font-size: 20px">espace administrateur</button>
            <a href="logout.php">Se déconnecter</a>
        </div>
    </header>

    <div class="body">
        <div class="container">
            <div class="project-card">
                <h3>Liste de tous les utilisateurs</h3>
                <div id="users-list">
                    <?php echo $users_content; ?>
                </div>
            </div>

            <div class="project-card">
                <h3>Ajouter un utilisateur</h3>
                <form action="../requete_users/add_user.php" method="POST">
                    <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom" required>

                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" name="prenom" required>

                    <label for="age">Âge :</label>
                    <input type="number" id="age" name="age" required>

                    <label for="date_de_naissance">Date de naissance :</label>
                    <input type="date" id="date_de_naissance" name="date_de_naissance" required>

                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" required>

                    <label for="numero">Numéro :</label>
                    <input type="number" id="numero" name="numero" required>

                    <label for="mdp">Mot de passe :</label>
                    <input type="text" id="mdp" name="mdp" required>

                    <button type="submit">Ajouter l'utilisateur</button>
                </form>
            </div>

            <div class="project-card">
                <h3>Liste de toutes les musiques</h3>
                <div id="musique-list">
                    <?php echo $musique_content; ?>
                </div>
            </div>

            <div class="project-card">
                <h3>Ajouter une musique</h3>
                <form action="../requete_musique/add_musique.php" method="POST">
                    <label for="titre">Titre :</label>
                    <input type="text" id="titre" name="titre" required>

                    <label for="artiste">Artiste :</label>
                    <input type="text" id="artiste" name="artiste" required>

                    <label for="url">URL de la musique :</label>
                    <input type="text" id="url" name="url" required>

                    <button type="submit">Ajouter la musique</button>
                </form>
            </div>
        </div>
    </div>

    <script src="../code js/admin.js"></script>
</body>
</html>