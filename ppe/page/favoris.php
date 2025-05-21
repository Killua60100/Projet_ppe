
<script>
/**
 * Appelle cette fonction à chaque changement de musique
 * @param {number} musiqueId L'id de la musique en cours
 */
function updateLikeButton(musiqueId) {
    const likeBtn = document.getElementById('likeBtnInNavbar');
    if (likeBtn) {
        likeBtn.setAttribute('data-id', musiqueId);
        // Optionnel : retire la classe "liked" à chaque changement
        likeBtn.classList.remove('liked');
    }
}

// Exemple d'appel : updateLikeButton(5);
// À intégrer dans ta logique de changement de musique
</script>


<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

include './config.php';

if (!isset($_SESSION['id'])) {
    header("Location: connexion.php");
    exit();
}

$userId = $_SESSION['id'];
$user_name = htmlspecialchars($userId);


$stmt = $mysqlClient->prepare("
    SELECT musique.*
    FROM musique
    INNER JOIN favoris ON musique.id = favoris.id_musique
    WHERE favoris.id_utilisateur = :userId
");

$stmt->execute(['userId' => $userId]);
$favoris = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $mysqlClient->query("SELECT COUNT(*) AS total_favoris FROM favoris");
$totalFavoris = $stmt->fetch(PDO::FETCH_ASSOC)['total_favoris'];

$stmt = $mysqlClient->query("SELECT COUNT(*) AS total_morceaux FROM musique");
$totalMorceaux = $stmt->fetch(PDO::FETCH_ASSOC)['total_morceaux'];
?>

<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Favoris - Melodia</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.7.3/dist/full.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../styles/styles.css">
</head>

<?php include "../components/sidebar.php"; ?>

<body class="text-white antialiased">

<main class="container mx-auto px-4 py-16" style="margin-left : 300px;">
    <div class="playlist-header p-8 text-white rounded-xl mb-8 bg-opacity-30 bg-black backdrop-blur-lg">
        <div class="container mx-auto">
            <div class="flex justify-between items-center">
                <h1 class="text-4xl font-bold mb-4">Vos Favoris</h1>
            </div>
            <div class="stats bg-base-200/30 backdrop-blur">
                <div class="stat">
                    <div class="stat-title">Favoris</div>
                    <div class="stat-value text-primary"><?php echo $totalFavoris; ?></div>
                </div>
                <div class="stat">
                    <div class="stat-title">Musiques disponibles</div>
                    <div class="stat-value text-secondary"><?php echo $totalMorceaux; ?></div>
                </div>  
            </div>
        </div>
    </div>

    <div>
        <?php if (count($favoris) > 0): ?>
            <ul class="space-y-4">
                <?php foreach ($favoris as $musique): ?>
                    <li class="p-4 bg-gray-800 rounded-lg shadow-md">
    <div class="flex justify-between items-center">
        <div>
            <a href="<?php echo htmlspecialchars($musique['url']); ?>" target="_blank" class="btn btn-outline btn-sm">
                Écouter
            </a>
            <h2 class="text-xl font-semibold"><?php echo htmlspecialchars($musique['titre']); ?></h2>
            <p class="text-sm text-gray-400"><?php echo htmlspecialchars($musique['artiste']); ?></p>
        </div>
        <button 
            class="btn btn-circle btn-sm btn-ghost like-button liked"
            data-id="<?php echo htmlspecialchars($musique['id']); ?>"
            title="Retirer des favoris"
        >
            <ion-icon name="heart" class="text-xl"></ion-icon>
        </button>
    </div>
</li>
                <?php endforeach; ?>
            </ul>  
        <?php else: ?>
            <p>Aucune musique en favoris.</p>
        <?php endif; ?>
    </div>
<button class="like-button" data-id="99">Test Like</button>
    <script src="../js/ConfirmLikeButton.js"></script>
</main>

</body>
</html>
