<?php
include '../page/config.php';

function getRecentTracks($userId, $limit = 20) {
    global $conn;
    
    $sql = "SELECT m.id, m.titre, m.image, a.nom as artiste, h.date_ecoute 
            FROM historique h
            JOIN musiques m ON h.musique_id = m.id
            JOIN artistes a ON m.artiste_id = a.id
            WHERE h.utilisateur_id = ?
            ORDER BY h.date_ecoute DESC
            LIMIT ?";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $userId, $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_all(MYSQLI_ASSOC);
}
?>