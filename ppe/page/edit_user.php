<?php
header('Content-Type: text/html; charset=utf-8');

include 'config.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Récupérer les données de la personne
    $stmt = $mysqlClient->prepare("SELECT * FROM personnes WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        ?>
        <h1>Modifier la personne</h1>
        <form action="../requete/update_user.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">

            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($user['nom']); ?>" required><br><br>

            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($user['prenom']); ?>" required><br><br>

            <label for="age">Âge :</label>
            <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($user['age']); ?>" required><br><br>

            <button type="submit">Modifier</button>
        </form>
        <?php
    } else {
        echo "Utilisateur non trouvé.";
    }
} else {
    echo "Aucun ID fourni.";
}
?>