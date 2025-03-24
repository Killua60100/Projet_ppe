<?php
header('Content-Type: text/html; charset=utf-8');

try {
    // Connexion à la base de données
    $mysqlClient = new PDO('mysql:host=localhost;dbname=database_ppe;charset=utf8', 'root', 'root');
    $mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

// Vérification de la présence de l'ID dans l'URL et si l'ID est valide
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id']; // Conversion de l'ID en entier

    // Vérification que l'utilisateur existe dans la base de données
    $stmt = $mysqlClient->prepare("SELECT id FROM utilisateur WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Si l'utilisateur existe
    if ($stmt->rowCount() > 0) {
        // Préparation de la requête de suppression
        $stmt = $mysqlClient->prepare("DELETE FROM utilisateur WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Exécution de la requête
        if ($stmt->execute()) {
            header('Location: ../page/index.php?page=projet'); // Redirection après suppression
            exit();
        } else {
            echo "Erreur lors de la suppression.";
        }
    } else {
        echo "Utilisateur non trouvé.";
    }
} else {
    echo "Aucun ID valide fourni.";
}
?>
