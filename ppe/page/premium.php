<?php

header('Content-Type: text/html; charset=utf-8');
session_start();

include 'config.php';

if (!isset($_SESSION['id'])) {
    header("Location: connexion.php");
    exit();
}

$user_name = isset($_SESSION['id']) ? htmlspecialchars($_SESSION['id']) : "Utilisateur";

?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <?php
        include "../components/sidebar.php"
    ?>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium - Plateforme de Streaming Musical</title>
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

        header {
            text-align: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2), 0 1px 3px rgba(0, 0, 0, 0.1);
            width: 90%;
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .container {
            display: flex;
            justify-content: center;
            gap: 20px;
            padding: 20px;
            flex-wrap: wrap;
        }

        .card {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 20px;
            width: 300px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2), 0 1px 3px rgba(0, 0, 0, 0.1);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: transform 0.3s ease;
        }

        .card h2 {
            color: #00e5ff;
        }

        .card p {
            margin: 10px 0;
        }

        .card button {
            background-color: #e100f4;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .card button:hover {
            background-color: #c700ff;
            transform: scale(1.15);
        }
    </style>
</head>
<body>
    <header>
        <h1>Devenez Premium</h1>
        <p>Choisissez le plan qui vous convient et profitez de la meilleure expérience musicale.</p>
    </header>
    <div class="container">
        <!-- Plan Individuel -->
        <div class="card">
            <h2>Individuel</h2>
            <p>9,99€/mois</p>
            <p>Écoute sans publicité</p>
            <p>Accès hors ligne</p>
            <p>Qualité audio supérieure</p>
            <button onclick="alert('Vous avez choisi le plan Individuel !')">S'abonner</button>
        </div>
        <!-- Plan Duo -->
        <div class="card">
            <h2>Duo</h2>
            <p>12,99€/mois</p>
            <p>Pour deux comptes</p>
            <p>Écoute sans publicité</p>
            <p>Accès hors ligne</p>
            <p>Qualité audio supérieure</p>
            <button onclick="alert('Vous avez choisi le plan Duo !')">S'abonner</button>
        </div>
        <!-- Plan Famille -->
        <div class="card">
            <h2>Famille</h2>
            <p>14,99€/mois</p>
            <p>Jusqu'à 6 comptes</p>
            <p>Écoute sans publicité</p>
            <p>Accès hors ligne</p>
            <p>Contrôle parental</p>
            <button onclick="alert('Vous avez choisi le plan Famille !')">S'abonner</button>
        </div>
    </div>
</body>
</html>