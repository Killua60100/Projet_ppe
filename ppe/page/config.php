<?php
// Démarrer la session (si ce n'est pas déjà fait)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Paramètres de connexion
$host = 'localhost';
$dbname = 'database_ppe';
$username = 'root';
$password = 'root';

try {
    // Création de la connexion PDO
    $mysqlClient = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}
?>
