<?php
header('Content-Type: application/json');
session_start();
require_once '../page/config.php';

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté']);
    exit();
}

if (!isset($_GET['musique_id'])) {
    echo json_encode(['success' => false, 'message' => 'ID de musique non fourni']);
    exit();
}

$user_id = $_SESSION['id'];
$musique_id = intval($_GET['musique_id']);

try {
    // Vérifier si le favori existe déjà
    $check = $mysqlClient->prepare("SELECT id FROM favoris WHERE utilisateur_id = ? AND musique_id = ?");
    $check->execute([$user_id, $musique_id]);
    
    if ($check->rowCount() > 0) {
        // Si le favori existe, on le supprime
        $stmt = $mysqlClient->prepare("DELETE FROM favoris WHERE utilisateur_id = ? AND musique_id = ?");
        $stmt->execute([$user_id, $musique_id]);
        $message = "Retiré des favoris";
    } else {
        // Si le favori n'existe pas, on l'ajoute
        $stmt = $mysqlClient->prepare("INSERT INTO favoris (utilisateur_id, musique_id, date_ajout) VALUES (?, ?, NOW())");
        $stmt->execute([$user_id, $musique_id]);
        $message = "Ajouté aux favoris";
    }
    
    echo json_encode(['success' => true, 'message' => $message]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la modification des favoris']);
}
?>