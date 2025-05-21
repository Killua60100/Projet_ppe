<?php
header('Content-Type: text/html; charset=utf-8');

include '../page/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $artiste = $_POST['artiste'];
    $url = $_POST['url'];


    $stmt = $mysqlClient->prepare("INSERT INTO musique (titre, artiste, url) 
                                   VALUES (:titre, :artiste, :url)");

    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':artiste', $artiste);
    $stmt->bindParam(':url', $url);

    $stmt->execute();

    header('Location: ../page/admin.php');
    exit();
}
?>
