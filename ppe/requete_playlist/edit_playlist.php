<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

include '../page/config.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("Location: connexion.php");
    exit();
}

// Récupérer l'ID de la playlist depuis l'URL
$playlist_id = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$playlist_id) {
    echo '<p class="text-red-500">Erreur : ID de la playlist manquant.</p>';
    exit();
}

// Initialiser les variables
$user_name = isset($_SESSION['id']) ? htmlspecialchars($_SESSION['id']) : "Utilisateur";
$search_results = [];
$search_term = '';
$error_message = '';
$musiques_deja_ajoutees = [];

try {
    // Récupérer les morceaux déjà ajoutés à la playlist
    $stmt = $mysqlClient->prepare("
        SELECT musique.id, musique.titre, musique.artiste 
        FROM liaison 
        INNER JOIN musique ON liaison.id_musique = musique.id 
        WHERE liaison.id_playlist = :id_playlist
    ");
    $stmt->execute(['id_playlist' => $playlist_id]);
    $musiques_deja_ajoutees = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Si une recherche est effectuée
    if (isset($_GET['q']) && !empty($_GET['q'])) {
        $search_term = trim($_GET['q']);
        $search_pattern = '%' . $search_term . '%';

        // Rechercher les morceaux correspondant au terme de recherche
        $stmt = $mysqlClient->prepare("SELECT * FROM musique WHERE titre LIKE :search OR artiste LIKE :search");
        $stmt->execute(['search' => $search_pattern]);
        $musique = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Récupérer tous les morceaux si aucune recherche n'est effectuée
        $stmt = $mysqlClient->query("SELECT * FROM musique");
        $musique = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    $error_message = "Une erreur est survenue lors de la récupération des données.";
    error_log($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Playlist - Melodia</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.7.3/dist/full.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
<div class="drawer lg:drawer-open">
    <div class="drawer-content">
        <div class="search-wrapper p-6">
            <form method="GET" action="" class="search-container">
                <input type="hidden" name="id" value="<?php echo $playlist_id; ?>"> <!-- Inclure l'ID de la playlist dans la recherche -->
                <div class="relative">
                    <i class="bi bi-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="q" class="search-input pl-12" placeholder="Que souhaitez-vous écouter ?" value="<?php echo htmlspecialchars($search_term); ?>">
                </div>
                <button type="submit" class="mt-4 bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition">
                    Rechercher
                </button>
                  <a href="../page/playlists.php" class="bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600 transition">
                Retour à la page précédente
            </a>
            </form>
        </div>
        <!-- Formulaire pour ajouter des morceaux -->
             <!-- Inclure l'ID de la playlist dans le formulaire -->
            <div class="">
                 <?php include '../components/musicCard.php'; ?>
            </div>
        
        
    </div>
</div>
</body>
</html>