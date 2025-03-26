<?php
header('Content-Type: text/html; charset=utf-8');

session_start();

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $mdp = trim($_POST['mdp']);

    // Vérifier si l'utilisateur existe
    $query = $mysqlClient->prepare("SELECT * FROM utilisateur WHERE email = ?");
    $query->execute([$email]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($mdp === "admin") {
        $_SESSION['is_admin'] = true; // ✅ Définit l'admin dans la session
        $_SESSION['id'] = "admin"; // ✅ Optionnel : stocke un ID pour l'admin
        header("Location: ./admin.php");
        exit();
    }


    if ($user) {
        if ($mdp === $user['mdp']) { // Comparaison directe sans hash
            $_SESSION['id'] = $user['id'];
            $_SESSION['prenom'] = $user['prenom'] . " " . $user['nom']; // Stocke Prénom + Nom
            
            header("Location: index.php");
            exit();
        } else {
            $error_message = "Mot de passe incorrect.";
        }
    } else {
        $error_message = "Email non trouvé.";
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css"> <!-- Le même fichier CSS utilisé pour tout -->
</head>
<body class="connexion-body">

    <h2 class="connexion-title">Connexion</h2>
    
    <?php if (isset($error_message)) : ?>
        <p class="error-message"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form method="post" class="connexion-form">
        <input type="email" name="email" placeholder="Email" required class="connexion-input">
        <input type="password" name="mdp" placeholder="Mot de passe" required class="connexion-input">
        <button type="submit" class="connexion-button">Se connecter</button>
    </form>
    
    <a href="connection.php" class="back-link">Retour</a>
</body>
</html>
