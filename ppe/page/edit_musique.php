<?php
header('Content-Type: text/html; charset=utf-8');

include 'config.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    $stmt = $mysqlClient->prepare("SELECT * FROM musique WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $musique = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($musique) {
        ?>
        <h1>Modifier les données de la musique selectionné</h1>
        <form action="../requete_musique/update_musique.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($musique['id']); ?>">

            <label for="titre"> Nouveau titre :</label>
            <input type="text" id="titre" name="titre" value="<?php echo htmlspecialchars($musique['titre']); ?>" required><br><br>

            <label for="artiste">artiste :</label>
            <input type="text" id="artiste" name="artiste" value="<?php echo htmlspecialchars($musique['artiste']); ?>" required><br><br>

            <label for="url">Âge :</label>
            <input type="text" id="url" name="url" value="<?php echo htmlspecialchars($musique['url']); ?>" required><br><br>

            <button type="submit">Modifier</button>
        </form>
        <?php
    } else {
        echo "musique non trouvé.";
    }
} else {
    echo "Aucun ID fourni.";
}
?>