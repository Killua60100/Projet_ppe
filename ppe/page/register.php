<?php
header('Content-Type: text/html; charset=utf-8');

session_start();

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = $mysqlClient->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    if ($query->execute([$name, $email, $password])) {
        echo "Inscription réussie. <a href='login.php'>Connectez-vous</a>";
    } else {
        echo "Erreur lors de l'inscription.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="inscription-body">

    <h2 class="inscription-title">Créer un compte</h2>
    
    <form action="../requete/add_user.php" method="POST" class="inscription-form">

        <label for="nom" class="inscription-label">Nom :</label>
        <input type="text" id="nom" name="nom" required class="inscription-input"><br><br>

        <label for="prenom" class="inscription-label">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required class="inscription-input"><br><br>

        <label for="age" class="inscription-label">Âge :</label>
        <input type="number" id="age" name="age" required class="inscription-input"><br><br>

        <label for="date_de_naissance" class="inscription-label">Date de naissance :</label>
        <input type="date" id="date_de_naissance" name="date_de_naissance" required class="inscription-input"><br><br>

        <label for="email" class="inscription-label">Email :</label>
        <input type="email" id="email" name="email" required class="inscription-input"><br><br>

        <label for="numero" class="inscription-label">Numéro :</label>
        <input type="number" id="numero" name="numero" required class="inscription-input"><br><br>

        <label for="mdp" class="inscription-label">Mot de passe :</label>
        <input type="text" id="mdp" name="mdp" required class="inscription-input"><br><br>

        <button type="submit" class="inscription-button">Créer le compte</button>
    </form>

    <a href="connection.php" class="back-link">Retour</a>

</body>
</html>
