<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "../page/config.php";

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    echo '<p class="text-red-500">Erreur : Vous devez être connecté pour créer une playlist.</p>';
    return;
}

// Vérifier si la requête est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $playlistName = isset($_POST['name']) ? trim($_POST['name']) : null;
    $isPrivate = isset($_POST['is_private']) ? (int)$_POST['is_private'] : 0; // Par défaut, la playlist est publique
    $userId = $_SESSION['id']; // Récupérer automatiquement l'ID de l'utilisateur connecté

    if ($playlistName) {
        try {
            // Insérer une nouvelle playlist dans la base de données
            $stmt = $mysqlClient->prepare("INSERT INTO playlists (name, user_id, is_private) VALUES (:name, :user_id, :is_private)");
            $stmt->execute([
                'name' => $playlistName,
                'user_id' => $userId,
                'is_private' => $isPrivate,
            ]);

            // Récupérer l'ID de la playlist nouvellement créée
            $playlistId = $mysqlClient->lastInsertId();

            echo '<p class="text-green-500">Playlist créée avec succès ! ID : ' . $playlistId . '</p>';
        } catch (PDOException $e) {
            echo '<p class="text-red-500">Erreur lors de la création de la playlist : ' . htmlspecialchars($e->getMessage()) . '</p>';
        }
    } else {
        echo '<p class="text-red-500">Erreur : Le nom de la playlist est requis.</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Playlist</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.7.3/dist/full.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="">
    <div class="container mx-auto py-10">
        <h1 class="text-3xl font-bold mb-6">Ajouter une Playlist</h1>
        <form method="POST" action="" class="space-y-4 bg-gray-800 p-6 rounded-lg shadow-lg">
            <!-- Nom de la playlist -->
            <div>
                <label for="name" class="block text-sm font-medium">Nom de la Playlist</label>
                <input type="text" id="name" name="name" class="input input-bordered w-full mt-2" placeholder="Nom de la playlist" required>
            </div>

            <!-- Playlist privée -->
            <div>
                <label for="is_private" class="block text-sm font-medium">Playlist Privée</label>
                <select id="is_private" name="is_private" class="select select-bordered w-full mt-2">
                    <option value="0">Non</option>
                    <option value="1">Oui</option>
                </select>
            </div>

            <!-- Bouton de soumission -->
            <div>
                <button type="submit" class="btn btn-primary w-full">Créer la Playlist</button>
            </div>
        </form>
    </div>
</body>
</html>