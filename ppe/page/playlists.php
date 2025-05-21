<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

include './config.php';

if (!isset($_SESSION['id'])) {
    header("Location: connexion.php");
    exit();
}

$user_name = isset($_SESSION['id']) ? htmlspecialchars($_SESSION['id']) : "Utilisateur";

// Récupérer les playlists de l'utilisateur
$stmt = $mysqlClient->prepare("SELECT * FROM playlists WHERE id = ? ORDER BY id DESC");
$stmt->execute([$_SESSION['id']]);
$playlists = $stmt->fetchAll(PDO::FETCH_ASSOC);

$search_results = [];
$search_term = '';
if (isset($_GET['q']) && !empty($_GET['q'])) {
    $search_term = trim($_GET['q']);
    $search_pattern = '%' . $search_term . '%';

    $stmt = $mysqlClient->prepare("SELECT * FROM musique WHERE titre LIKE :search OR artiste LIKE :search");
    $stmt->execute(['search' => $search_pattern]);
    $search_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// Récupérer le nombre total de playlists
$stmt = $mysqlClient->query("SELECT COUNT(*) AS total_playlists FROM playlists");
$totalPlaylists = $stmt->fetch(PDO::FETCH_ASSOC)['total_playlists'];

$stmt = $mysqlClient->query("SELECT COUNT(*) AS total_morceaux FROM musique");
$totalMorceaux = $stmt->fetch(PDO::FETCH_ASSOC)['total_morceaux'];

?>


<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Playlists - Melodia</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.7.3/dist/full.css" rel="stylesheet" type="text/css" />
    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'><link rel="stylesheet" href="../styles/styles.css">    
</head>
<body class="text-white antialiased" >
<?php
include "../components/sidebar.php" ;               
?>

    <main class="ml-72 flex-1 p-8">
        <!-- header -->
        <div class="playlist-header p-8 text-white rounded-xl mb-8 bg-opacity-30 bg-black backdrop-blur-lg">
            <div class="">
                <div class="flex justify-between items-center">
                    <h1 class="text-4xl font-bold mb-4">Vos Playlists</h1>
                    <button class="btn btn-primary gap-2" onclick="create_playlist_modal.showModal()">
                        <i class="bi bi-plus-lg"></i>
                        Créer une playlist
                    </button>
                </div>
                <div class="stats bg-base-200/30 backdrop-blur">
                    <div class="stat">
                        <div class="stat-title">Playlists</div>
                        <div class="stat-value text-primary"><?php echo $totalPlaylists; ?></div> <!-- Nombre réel de playlists -->
                    </div>
                    <div class="stat">
                        <div class="stat-title">musiques</div>
                        <div class="stat-value text-secondary"><?php echo $totalMorceaux; ?></div> <!-- Nombre réel de morceaux -->
                    </div>  
                </div>
            </div>
        </div>
            <div>
                <?php
                    include "../requete_playlist/liste_playlist.php";
                ?>
            </div>
     </main>
<dialog id="create_playlist_modal" class="modal">
  <div class="modal-box" style="width: 80vw; max-width: 1000px; max-height: 90vh; min-height: 60vh; overflow-y: auto;">
    <div class="form-control w-full">
      <?php include "../requete_playlist/add_playlist.php"; ?>
    </div>
  </div>
</dialog>


    

</body>
</html>
                        
                    
