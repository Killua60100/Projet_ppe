<?php
header('Content-Type: text/html; charset=utf-8');

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données envoyées par le formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $age = (int)$_POST['age'];
    $date_de_naissance = $_POST['date_de_naissance'];
    $numero = (int)$_POST['numero'];
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];

    // Insertion dans la table "utilisateur"
    $stmt = $mysqlClient->prepare("INSERT INTO utilisateur (nom, prenom, age, date_de_naissance, numero, email,mdp) 
                                   VALUES (:nom, :prenom, :age, :date_de_naissance, :numero, :email,:mdp)");

    // Liaison des paramètres pour éviter les injections SQL
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':age', $age);
    $stmt->bindParam(':date_de_naissance', $date_de_naissance);
    $stmt->bindParam(':numero', $numero);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':mdp', $mdp);

    // Exécution de la requête
    $stmt->execute();

    // Redirection après l'insertion
    header('Location: ../page/index.php?page=projet');
    exit();
}
?>
