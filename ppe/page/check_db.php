<?php
include 'config.php';

$stmt = $mysqlClient->query("SELECT * FROM musique LIMIT 5");
$musiques = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($musiques as $musique) {
    echo "ID: " . $musique['id'] . "\n";
    echo "Titre: " . $musique['titre'] . "\n";
    echo "Artiste: " . $musique['artiste'] . "\n";
    echo "URL: " . $musique['url'] . "\n";
    echo "-------------------\n";
}
?>