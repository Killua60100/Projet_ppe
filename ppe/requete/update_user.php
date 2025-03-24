<?php
header('Content-Type: text/html; charset=utf-8');

try {
  $mysqlClient = new PDO('mysql:host=localhost;dbname=database_ppe;charset=utf8', 'root', 'root');
  $mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo 'Connexion réussie !';
} catch (Exception $e) {
  die('Erreur de connexion : ' . $e->getMessage());
}


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
        header('Location: ../page/index.php?page=projet');
        exit();
    } else {
        echo "Erreur lors de la mise à jour.";
    }
}
?>  