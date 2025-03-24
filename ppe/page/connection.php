<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion ou Inscription</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-bottom: 20px;
        }
        .btn {
            display: block;
            width: 200px;
            padding: 10px;
            margin: 10px auto;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            border-radius: 5px;
            color: white;
            text-align: center;
        }
        .btn-blue {
            background-color: #007bff;
        }
        .btn-green {
            background-color: #28a745;
        }
        .btn-orange {
            background-color:rgb(218, 135, 27);
        }

        .btn-blue:hover {
            background-color:rgb(28, 87, 151);
        }
        .btn-green:hover {
            background-color:rgb(37, 117, 55);
        }
        .btn-orange:hover {
            background-color:rgb(185, 127, 18);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Bienvenue dans Melodia !</h2>
        <h4>notre plaforme de musique 100% gratuite </h4>
        <a href="login.php" class="btn btn-blue">Se connecter</a>
        <a href="register.php" class="btn btn-green">S'inscrire</a>
        <a href="admin.php" class="btn btn-orange">Administrateur</a>
    </div>
</body>
</html>
