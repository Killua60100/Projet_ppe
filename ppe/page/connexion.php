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
        // Utiliser password_verify pour comparer le mot de passe saisi avec le mot de passe haché
        if (password_verify($mdp, $user['mdp'])) {
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
    <title>Connexion - Melodia</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Style général */
        body {
            background-color: #181818;
            color: white;
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Conteneur du formulaire */
        .glass-form {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 25px;
            width: 350px;
            transition: transform 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .glass-form:hover {
            transform: translateY(-5px);
        }

        /* En-tête et titre */
        .header {
            margin-bottom: 20px;
            text-align: center;
        }

        .connexion-title {
            color: white;
            margin-bottom: 20px;
            font-size: 1.5em;
            border-bottom: 2px solid #ff00ff;
            padding-bottom: 10px;
        }

        /* Formulaire */
        .connexion-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .connexion-input {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            padding: 12px;
            color: white;
            font-size: 1em;
            transition: all 0.3s ease;
        }

        .connexion-input:focus {
            outline: none;
            border-color: #ff00ff;
            background: rgba(255, 255, 255, 0.15);
        }

        /* Boutons */
        .connexion-button, .social-login button {
            background: linear-gradient(45deg, #ff00ff, #00ffff);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-size: 1em;
            cursor: pointer;
            transition: transform 0.3s ease;
            margin: 10px 0;
        }

        .connexion-button:hover, .social-login button:hover {
            transform: scale(1.02);
        }

        /* Liens */
        a {
            color: #00ffff;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        a:hover {
            background: rgba(0, 255, 255, 0.1);
        }

        /* Messages d'erreur */
        .error-message {
            background: rgba(255, 0, 0, 0.1);
            color: #ff4444;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            text-align: center;
        }

        /* Bannière cookies */
        .cookie-banner {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 20px;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .cookie-banner button {
            background: linear-gradient(45deg, #ff00ff, #00ffff);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 8px;
            margin-left: 10px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .cookie-banner button:hover {
            transform: scale(1.05);
        }

        /* Social login */
        .social-login {
            margin-top: 20px;
            text-align: center;
        }

        .social-login p {
            color: #bbbbbb;
            margin-bottom: 10px;
        }

        /* Style du logo */
        .logo {
            width: 180px;
            height: auto;
            margin-bottom: 30px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            filter: drop-shadow(0 0 10px rgba(255, 0, 255, 0.3));
        }
    </style>
</head>
<body>
    <div class="glass-form">
        <div class="header">
            <img src="../document/logo.png" alt="Logo Melodia" class="logo">
        </div>

        <h2 class="connexion-title">Connexion</h2>
    
    <?php if (isset($error_message)) : ?>
        <p class="error-message"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form method="post" class="connexion-form">
        <input type="email" name="email" placeholder="Email" required class="connexion-input">
        <input type="password" name="mdp" placeholder="Mot de passe" required class="connexion-input">
        <button type="submit" class="connexion-button">Se connecter</button>
    </form>

        <div class="social-login">
            <p>Ou connectez-vous avec :</p>
            <button onclick="location.href='https://accounts.google.com/o/oauth2/auth'">Google</button>
            <button onclick="location.href='https://www.facebook.com/v12.0/dialog/oauth'">Facebook</button>
        </div>

        <p>Pas encore inscrit ? <a href="register.php" style="color: #00e5ff;">Créez un compte</a></p>
    </div>
 
    <div class="cookie-banner">
        <p>Ce site utilise des cookies pour améliorer votre expérience.</p>
        <div>
            <button onclick="acceptCookies()">Tout accepter</button>
            <button onclick="rejectCookies()">Tout refuser</button>
            <button onclick="window.location.href='../essai/politiquecookie.html'">Politique des cookies</button>
        </div>
    </div>
 
    <script>
        function acceptCookies() {
            document.querySelector('.cookie-banner').style.display = 'none';
        }
 
        function rejectCookies() {
            document.querySelector('.cookie-banner').style.display = 'none';
        }
    </script>
</body>
</html>