<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $age = $_POST['age'];
    $date_de_naissance = $_POST['date_de_naissance'];
    $email = $_POST['email'];
    $numero = $_POST['numero'];
    $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT); // Hachage du mot de passe
    

    $query = $mysqlClient->prepare("INSERT INTO utilisateur (nom, prenom, age, date_de_naissance, email, numero, mdp) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    if ($query->execute([$nom, $prenom, $age, $date_de_naissance, $email, $numero, $mdp])) {
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
    <title>Inscription - Melodia</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(18deg, #c400d5, #00abff);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
            color: white;
            text-align: center;
        }
 
        .glass-form {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 30px;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2), 0 1px 3px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
 
        input, button {
            padding: 12px;
            margin-top: 10px;
            margin-bottom: 15px;
            border-radius: 8px;
            font-size: 16px;
            border: none;
            outline: none;
            background: rgba(255, 255, 255, 0.3);
            color: white;
            transition: background 0.3s ease, transform 0.3s ease;
        }
 
        button[type="submit"] {
            background-color: #e100f4;
            color: white;
            cursor: pointer;
        }
 
        button:hover {
            background-color: #c700ff;
            transform: scale(1.15);
        }
 
        .back-link {
            color: #00e5ff;
            text-decoration: none;
        }
 
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
 
<body>
    <div class="container mt-5 glass-form">
        <h2>Créer un compte</h2>
        <?php if (isset($error_message)) : ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <?php if (isset($success_message)) : ?>
            <p style="color: green;"><?php echo $success_message; ?></p>
        <?php endif; ?>
        <form method="POST">
            <div class="row g-4"> <!-- Augmenté l'espacement entre les colonnes -->
                <div class="col-sm">
                    <input type="text" name="nom" class="form-control mb-3" placeholder="Nom" required>
                    <input type="text" name="prenom" class="form-control mb-3" placeholder="Prénom" required>
                    <input type="number" name="age" class="form-control mb-3" placeholder="Âge" required>
                    <input type="date" name="date_de_naissance" class="form-control mb-3" placeholder="Date de naissance" required>
                </div>
                <div class="col-sm">
                    <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
                    <input type="number" name="numero" class="form-control mb-3" placeholder="Numéro" required>
                    <input type="password" name="mdp" class="form-control mb-3" placeholder="Mot de passe" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Créer le compte</button>
        </form>
        <div class="social-login mt-4">
            <p>Ou inscrivez-vous avec :</p>
            <!-- Bouton Facebook -->
            <button onclick="location.href='https://www.facebook.com/v12.0/dialog/oauth'" class="btn btn-outline-primary d-flex align-items-center justify-content-center mb-3" style="border-radius: 50px; padding: 10px 20px; width: 100%; max-width: 400px;">
                <img src="https://upload.wikimedia.org/wikipedia/commons/0/05/Facebook_Logo_%282019%29.png" alt="Facebook" style="width: 20px; height: 20px; margin-right: 10px;">
                <span>Inscrivez-vous avec Facebook</span>
            </button>
 
            <!-- Bouton Apple -->
            <button onclick="location.href='https://appleid.apple.com/auth/authorize'" class="btn btn-outline-dark d-flex align-items-center justify-content-center" style="border-radius: 50px; padding: 10px 20px; width: 100%; max-width: 400px;">
                <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg" alt="Apple" style="width: 20px; height: 20px; margin-right: 10px;">
                <span>Continuer avec Apple</span>
            </button>
        </div>
        <a href="connexion.php" class="btn btn-link mt-4">
            <button type="button" class="btn btn-primary">Retour</button>
        </a>
    </div>
</body>
 
</html>