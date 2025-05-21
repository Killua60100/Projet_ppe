<?php
include '../page/config.php';

$stmt = $mysqlClient->query("SELECT * FROM musique");
$musique = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste de musiques</title>
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

        .like-button {
            background: none;
            border: none;
            cursor: pointer;
            color: #e53e3e;
            font-size: 1.3em;
        }
    </style>
</head>
<body>

<!-- Liste des musiques -->
<?php foreach ($musique as $index => $item): ?>
    <?php
    $url = htmlspecialchars($item['url']);
    $titre = htmlspecialchars($item['titre']);
    $artiste = htmlspecialchars($item['artiste']);
    $idMusique = htmlspecialchars($item['id']);
    ?>

    <div class="music-card"
         onclick="togglePlay('<?php echo $url; ?>', <?php echo $index; ?>)"
         data-url="<?php echo $url; ?>"
         data-index="<?php echo $index; ?>">

        <div style="display: flex; align-items: center; justify-content: space-between;">
            <span style="font-weight: bold;"><?php echo $titre; ?> - <?php echo $artiste; ?></span>
            <button 
                class="like-button"
                data-id="<?php echo $idMusique; ?>"
                title="Ajouter aux favoris"
                onclick="event.stopPropagation();">
                <ion-icon name="heart"></ion-icon>
            </button>
        </div>

        <div id="progressWrapper<?php echo $index; ?>"
             style="visibility: hidden; opacity: 0; transition: opacity 0.5s ease;
                    width: 100%; height: 10px; background-color: #eee;
                    border-radius: 5px; overflow: hidden;">
            <div id="progressBar<?php echo $index; ?>"
                 style="height: 10px; width: 0%; background-color: #4CAF50;"></div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Lecteur YouTube invisible -->
<div id="youtubePlayer" style="margin-top: 20px;"></div>

<!-- Scripts -->
<script src="../js/ConfirmLikeButton.js"></script>

<!-- YouTube API -->
<script>
    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    var player;
    var currentVideoId = null;
    var currentProgressBarId = null;
    var progressInterval = null;
    var currentIndex = null;

    function onYouTubeIframeAPIReady() {
        player = new YT.Player('youtubePlayer', {
            height: '1',
            width: '1',
            videoId: '',
            events: {
                'onReady': onPlayerReady
            }
        });
    }

    function onPlayerReady(event) {
        console.log("Lecteur YouTube prêt");
    }

    function extractYouTubeVideoId(url) {
        const regex = /(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?v=([a-zA-Z0-9_-]{11})|(?:https?:\/\/)?youtu\.be\/([a-zA-Z0-9_-]{11})/;
        const match = url.match(regex);
        return match ? (match[1] || match[2]) : null;
    }

    function togglePlay(url, index) {
        const videoId = extractYouTubeVideoId(url);
        if (!videoId) {
            console.error("URL YouTube invalide :", url);
            return;
        }

        const previousWrapperId = 'progressWrapper' + currentIndex;
        const newWrapperId = 'progressWrapper' + index;

        if (player) {
            const playerState = player.getPlayerState();

            if (currentVideoId === videoId && playerState === YT.PlayerState.PLAYING) {
                player.stopVideo();
                stopProgressTracking();
                currentVideoId = null;

                if (previousWrapperId) {
                    const wrapper = document.getElementById(previousWrapperId);
                    wrapper.style.opacity = "0";
                    wrapper.style.visibility = "hidden";
                }
            } else {
                currentVideoId = videoId;
                currentProgressBarId = 'progressBar' + index;
                currentIndex = index;

                if (previousWrapperId && previousWrapperId !== newWrapperId) {
                    const oldWrapper = document.getElementById(previousWrapperId);
                    if (oldWrapper) {
                        oldWrapper.style.opacity = "0";
                        oldWrapper.style.visibility = "hidden";
                    }
                }

                player.loadVideoById(videoId);

                const newWrapper = document.getElementById(newWrapperId);
                newWrapper.style.visibility = "visible";
                newWrapper.style.opacity = "1";

                startProgressTracking();
            }
        }
    }

    function updateProgressBar() {
        if (player && player.getDuration && currentProgressBarId) {
            const duration = player.getDuration();
            const currentTime = player.getCurrentTime();
            if (duration > 0) {
                const percent = (currentTime / duration) * 100;
                document.getElementById(currentProgressBarId).style.width = percent + "%";
            }
        }
    }

    function startProgressTracking() {
        if (progressInterval) clearInterval(progressInterval);
        progressInterval = setInterval(updateProgressBar, 500);
    }

    function stopProgressTracking() {
        if (progressInterval) clearInterval(progressInterval);
        if (currentProgressBarId) {
            document.getElementById(currentProgressBarId).style.width = "0%";
        }
    }
</script>

<!-- Ionicons -->
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</html>
