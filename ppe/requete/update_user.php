<?php
header('Content-Type: text/html; charset=utf-8');

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $age = (int)$_POST['age'];

    $stmt = $mysqlClient->prepare("UPDATE utilisateur SET nom = :nom, prenom = :prenom, age = :age WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':age', $age);

    if ($stmt->execute()) {
        header('Location: ../page/admin.php');
        exit();
    } else {
        echo "Erreur lors de la mise à jour.";
    }
}
?>  