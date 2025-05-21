<?php
header('Content-Type: text/html; charset=utf-8');

include '../page/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    $titre = $_POST['titre'];
    $artiste = $_POST['artiste'];
    $url = $_POST['url'];

    $stmt = $mysqlClient->prepare("UPDATE musique SET titre = :titre, artiste = :artiste, url = :url WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':artiste', $artiste);
    $stmt->bindParam(':url', $url);

    if ($stmt->execute()) {
        header('Location: ../page/admin.php');
        exit();
    } else {
        echo "Erreur lors de la mise à jour.";
    }
}
?>  