<?php
include '../page/config.php';

header('Content-Type: application/json');

$playlistId = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$playlistId) {
    echo json_encode(['success' => false, 'message' => 'ID de playlist manquant.']);
    exit();
}

try {
    $stmt = $mysqlClient->prepare("
        SELECT musique.titre, musique.artiste, musique.url 
        FROM liaison 
        INNER JOIN musique ON liaison.id_musique = musique.id 
        WHERE liaison.id_playlist = :id_playlist
    ");
    $stmt->execute(['id_playlist' => $playlistId]);
    $tracks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'tracks' => $tracks]);
} catch (PDOException $e) {
    error_log("Erreur SQL : " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la récupération des morceaux.']);
}
?>
