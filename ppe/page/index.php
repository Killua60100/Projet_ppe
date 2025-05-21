<?php

header('Content-Type: text/html; charset=utf-8');
session_start();

include 'config.php';

if (!isset($_SESSION['id'])) {
    header("Location: connexion.php");
    exit();
}

$user_name = isset($_SESSION['prenom']) ? htmlspecialchars($_SESSION['prenom']) : "Utilisateur";

?>
<script>
    // Lorsque le bouton est cliqué, afficher plus de musiques
    document.getElementById('show-more-button').addEventListener('click', function() {
        var moreMusicList = document.querySelector('.more-music-list');
        var button = document.getElementById('show-more-button');
        
        // Afficher la liste des musiques supplémentaires
        moreMusicList.style.display = 'block';

        // Masquer le bouton "Tout afficher"
        button.style.display = 'none';
    });
</script>

<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Melodia</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'><link rel="stylesheet" href="../styles/styles.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src='https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js'></script><script  src="../js/likeButton.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    



</head>
<body class="text-white antialiased">
    <?php include '../components/sidebar.php'; ?>

    <!-- Le reste du contenu de la page -->
    <main class="ml-72 flex-1 p-8">
            <h2 class="text-3xl font-bold mb-4">🎧 Découvrez les hits du moment</h2>
            <p class="text-gray-400 mb-6">Retrouvez les titres les plus écoutés du moment.</p>

            <div class="">
                <?php include '../components/musicCard.php'; ?>
            </div>

            <?php include '../components/musicPlayer.php'; ?>

            <!-- Lecteur YouTube invisible -->
            <div id="youtubePlayer"></div>
    </main>

    <!-- Modal de déconnexion -->
    <dialog id="logout_modal" class="modal">
        <div class="modal-box bg-[#1a103f] border border-indigo-500/20 backdrop-blur-xl">
            <div class="flex flex-col items-center gap-6 p-4">
                <!-- Icône animée -->
                <div class="relative w-20 h-20">
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full animate-pulse"></div>
                    <div class="absolute inset-2 bg-[#1a103f] rounded-full flex items-center justify-center">
                        <i class="bi bi-power text-3xl text-white"></i>
                    </div>
                </div>

                <h3 class="text-2xl font-bold bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">
                    Déconnexion
                </h3>
                
                <p class="text-gray-300 text-center">
                    Êtes-vous sûr de vouloir vous déconnecter ?
                </p>

                <div class="flex gap-4 mt-4">
                    <a href="logout.php" class="btn bg-gradient-to-r from-red-500 to-pink-500 border-0 hover:scale-105 transition-transform duration-200 text-white">
                        <i class="bi bi-box-arrow-right mr-2"></i>
                        Déconnexion
                    </a>
                    <button onclick="logout_modal.close()" class="btn btn-ghost border border-gray-600 hover:border-gray-400">
                        Annuler
                    </button>
                </div>
            </div>
        </div>

        <form method="dialog" class="modal-backdrop bg-black/50 backdrop-blur-sm">
            <button>Fermer</button>
        </form>
    </dialog>

    <?php include '../components/footer.php'; ?>
    <script>
    
    <!-- Script pour emmener vers le js pour confirmer le like -->
    <script src="../js/ConfirmLikeButton.js"></script>
    <script src="../js/MusicPlayer.js"></script>
</body>
</html>
