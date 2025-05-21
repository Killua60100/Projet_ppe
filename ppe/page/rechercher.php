<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

include './config.php';

if (!isset($_SESSION['id'])) {
    header("Location: connexion.php");
    exit();
}

$user_name = isset($_SESSION['id']) ? htmlspecialchars($_SESSION['id']) : "Utilisateur";
$search_results = [];
$search_term = '';
$error_message = '';

try {
    if (isset($_GET['q']) && !empty($_GET['q'])) {
        $search_term = trim($_GET['q']);
        $search_pattern = '%' . $search_term . '%';

        $stmt = $mysqlClient->prepare("SELECT * FROM musique WHERE titre LIKE :search OR artiste LIKE :search");
        $stmt->execute(['search' => $search_pattern]);
        $search_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $stmt = $mysqlClient->query("SELECT * FROM musique");
        $search_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    $error_message = "Une erreur est survenue lors de la recherche.";
    error_log($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rechercher - Melodia</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.7.3/dist/full.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">


</head>

<body class="text-white antialiased">
<?php
include "../components/sidebar.php"
?>
 <main class="ml-72 flex-1 p-8">
<div class="drawer lg:drawer-open">
    <div class="drawer-content">
        <div class="search-wrapper p-6">
            <form method="GET" action="" class="search-container">
                <div class="relative">
                    <i class="bi bi-search absolute left-0.5 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="q" class="search-input" placeholder="Que souhaitez-vous écouter ?" value="<?php echo htmlspecialchars($search_term); ?>">
                </div>
                <button type="submit" class="mt-4 bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition">
                    Rechercher
                </button>
            </form>
        </div>

<?php include "../components/liste.php"; ?>
<?php include '../components/musicPlayer.php'; ?>

<div id="youtubePlayer" style="display: none;"></div>
</main>
<script src="../js/ConfirmLikeButton.js"></script>
<script src="../js/MusicPlayer.js"></script>

</body>
</html>
