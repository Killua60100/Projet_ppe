<?php
include '../page/config.php';

$stmt = $mysqlClient->query("SELECT * FROM musique");
$musique = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des musiques</title>
    <!-- Ionicons pour le cœur -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <style>
      .music-card {
        position: relative;
        transition: background-color 0.8s ease, transform 0.8s ease, box-shadow 0.8s ease;
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        gap: 10px;
      }
      .music-card:hover {
        background-color: rgb(93, 93, 93);
        transform: scale(1.05);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
      }
      .like-button.liked ion-icon {
        color: red;
      }
      .like-button ion-icon {
        pointer-events: none;
      }
      .cover-image {
        width: 100%;
        height: 220px;
        background-size: cover;
        background-position: center;
        border-radius: 8px;
        margin-bottom: 10px;
      }
      .default-cover {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eee;
        color: #888;
      }
      .progress-wrapper {
        visibility: hidden;
        opacity: 0;
        transition: opacity 0.5s ease;
        width: 100%;
        height: 10px;
        background-color: #eee;
        border-radius: 5px;
        overflow: hidden;
      }
      .progress-bar {
        height: 10px;
        width: 0%;
        background-color: #4CAF50;
      }
    </style>
</head>
<body>
<!-- Liste des musiques -->
<div class="grid sm:grid-cols-3 lg:grid-cols-5 gap-8">
<?php foreach ($musique as $index => $item): ?>
    <?php
        $url = htmlspecialchars($item['url']);
        $titre = htmlspecialchars($item['titre']);
        $artiste = htmlspecialchars($item['artiste']);
        $idMusique = htmlspecialchars($item['id']);
        // Déterminer l'image de fond en fonction de l'artiste
        $coverImage = '';
        if ($artiste === 'Gazo') {
            $coverImage = '../../ppe/document/gazo euphon.jpeg';
        } elseif ($artiste === 'Theodora') {
            $coverImage = '../../ppe/document/pay.jpg';
        } elseif ($artiste === 'Ziak') {
            $coverImage = '../../ppe/document/ziak.jpg';
        } elseif ($artiste === 'Ninho') {
            $coverImage = '../../ppe/document/ninho-vrais.jpg';
        } elseif ($artiste === 'SDM') {
            $coverImage = '../../ppe/document/sdm-cartier-santos.jpg';
        } elseif ($artiste === 'Naps') {
            $coverImage = '../../ppe/document/naps-la-kiffance.jpg';
        } elseif ($artiste === 'Maes') {
            $coverImage = '../../ppe/document/maes.jpeg';
        } elseif ($artiste === 'Gims') {
            $coverImage = '../../ppe/document/gims-ciel.jpg';
        } elseif ($artiste === 'MRC') {
            $coverImage = '../../ppe/document/mrc.jpeg';
        }
    ?>
    <div class="music-card" onclick="togglePlay('<?php echo $url; ?>', <?php echo $index; ?>, '<?php echo $titre; ?>', '<?php echo $artiste; ?>')">
        <?php if ($coverImage): ?>
            <div class="cover-image" style="background-image: url('<?php echo $coverImage; ?>')"></div>
        <?php else: ?>
            <div class="cover-image default-cover">
                <i class="bi bi-music-note"></i>
            </div>
        <?php endif; ?>
        <div class="card-content">
            <h3 class="song-title"><?php echo $titre; ?></h3>
            <p class="artist-name"><?php echo $artiste; ?></p>
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <span style="font-weight: bold;"><?php echo $titre; ?> - <?php echo $artiste; ?></span>
                <button 
                    class="like-button"
                    data-id="<?php echo $idMusique; ?>"
                    title="Ajouter aux favoris"
                    onclick="event.stopPropagation();"
                    style="background: none; border: none; cursor: pointer; color: #e53e3e; font-size: 1.3em;"
                >
                    <ion-icon name="heart"></ion-icon>
                </button>
            </div>
            <!-- Barre de progression -->
            <div id="progressWrapper<?php echo $index; ?>" class="progress-wrapper">
                <div id="progressBar<?php echo $index; ?>" class="progress-bar"></div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>
<!-- Lecteur YouTube invisible -->
<div id="youtubePlayer" style="display: none;"></div>
<script src="../js/ConfirmLikeButton.js"></script>
<script src="../js/musicCard.js"></script>
</body>
</html>