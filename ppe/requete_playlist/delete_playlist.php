<?php
header('Content-Type: text/html; charset=utf-8');

include '../page/config.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];

        // Vérification que l'utilisateur existe dans la base de données
        $stmt = $mysqlClient->prepare("SELECT id FROM playlists WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    
 
        if ($stmt->rowCount() > 0) {

            $stmt = $mysqlClient->prepare("DELETE FROM playlists WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
            // Exécution de la requête
            if ($stmt->execute()) {
                header('Location: ../page/playlists.php'); // Redirection après suppression
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