<?php
header('Content-Type: text/html; charset=utf-8');

session_start();


try {
    $mysqlClient = new PDO('mysql:host=localhost;dbname=database_ppe;charset=utf8', 'root', 'root');
    $mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo 'Connexion réussie !';
  } catch (Exception $e) {
    die('Erreur de connexion : ' . $e->getMessage());
  }


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

<label for="mdp">mot de passe :</label>
<input type="text" id="mdp" name="mdp" required><br><br>

<button type="submit">creer le compte</button>
</form>

<a href="connection.php">Retour</a>

</html>