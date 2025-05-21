<?php
session_start();
include "../page/config.php";

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("Location: ../page/connexion.php");
    exit();
}

// Vérifier si les données nécessaires sont présentes
$playlistId = isset($_POST['playlist_id']) ? intval($_POST['playlist_id']) : null;
$musiqueIds = isset($_POST['musique_ids']) ? $_POST['musique_ids'] : [];
var_dump($playlistId);
if (!$playlistId || empty($musiqueIds)) {
    echo "Erreur : ID de la playlist ou musiques manquants.";
    exit();
}

try {
    // Vérifier si la playlist existe
    $stmt = $mysqlClient->prepare("SELECT * FROM playlists WHERE id = :id");
    $stmt->execute(['id' => $playlistId]);
    $playlist = $stmt->fetch();

    if (!$playlist) {
        echo "Playlist introuvable.";
        exit();
    }

    // Ajouter les musiques à la playlist
    $stmt = $mysqlClient->prepare("INSERT INTO liaison (id_playlist, id_musique) VALUES (:id_playlist, :id_musique)");
    foreach ($musiqueIds as $musiqueId) {
        $stmt->execute([
            'id_playlist' => $playlistId,
            'id_musique' => intval($musiqueId),
        ]);
    }

    // Redirection après succès
    header("Location: edit_playlist.php?id=" . $playlistId . "&success=1");
    exit();
} catch (PDOException $e) {
    echo "Erreur lors de l'ajout des musiques : " . htmlspecialchars($e->getMessage());
}