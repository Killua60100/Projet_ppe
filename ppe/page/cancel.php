<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement annulé | Melodia</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.7.3/dist/full.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../styles/styles.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center">
    <div class="text-center">
        <div class="mb-8">
            <i class="bi bi-x-circle text-6xl text-gray-500"></i>
        </div>
        <h1 class="text-4xl font-bold mb-4">Paiement annulé</h1>
        <p class="text-xl text-gray-400 mb-8">Vous avez annulé le processus de paiement.</p>
        <div class="flex gap-4 justify-center">
            <a href="abonnement.php" class="btn btn-primary">
                Réessayer
            </a>
            <a href="index.php" class="btn btn-ghost">
                Retour à l'accueil
            </a>
        </div>
    </div>
</body>
</html>