<?php
include '../page/config.php';

try {
    // Récupérer toutes les playlists
    $stmt = $mysqlClient->query("SELECT * FROM playlists");
    $playlists = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Afficher chaque playlist
    foreach ($playlists as $playlist) {
        echo '<div class="glass-card" style="padding: 20px; margin-bottom: 20px; border-radius: 12px; color: white;">';
        
        // Titre de la playlist
        echo '<p style="margin-bottom: 16px; font-size: 1.2rem; font-weight: bold;">' . htmlspecialchars($playlist['name']) . "</p>";
        
        // Bouton pour ajouter (vert)
        echo "<a href='../requete_playlist/edit_playlist.php?id=" . $playlist['id'] . "' 
                style='margin-right: 10px; padding: 10px 16px; background: linear-gradient(90deg, #22c55e, #16a34a); 
                color: white; text-decoration: none; border-radius: 8px; transition: all 0.3s ease; display: inline-block;'>
                Ajouter</a>";
        
        // Bouton pour supprimer (rouge)
        echo "<a href='../requete_playlist/delete_playlist.php?id=" . $playlist['id'] . "' 
                onclick='return confirm(\"Voulez-vous vraiment supprimer cette playlist ?\");' 
                style='margin-right: 10px; padding: 10px 16px; background: linear-gradient(90deg, #ef4444, #dc2626); 
                color: white; text-decoration: none; border-radius: 8px; transition: all 0.3s ease; display: inline-block;'>
                Supprimer</a>";
        
        // Bouton pour écouter
        echo "<button onclick=\"playPlaylist(" . $playlist['id'] . ")\" 
                style='margin-right: 10px; padding: 10px 16px; background: linear-gradient(90deg, #2563eb, #1d4ed8); 
                color: white; border: none; border-radius: 8px; cursor: pointer; transition: all 0.3s ease;'>
                Écouter</button>";
        
        // Bouton pour pause
        echo "<button onclick=\"pauseMusic()\" 
                style='padding: 10px 16px; background: linear-gradient(90deg, #fb923c, #f97316); 
                color: white; border: none; border-radius: 8px; cursor: pointer; transition: all 0.3s ease;'>
                Pause</button>";

        // Récupérer les morceaux associés à la playlist
        $stmtMusiques = $mysqlClient->prepare("
            SELECT musique.titre, musique.artiste 
            FROM liaison 
            INNER JOIN musique ON liaison.id_musique = musique.id 
            WHERE liaison.id_playlist = :id_playlist
        ");
        $stmtMusiques->execute(['id_playlist' => $playlist['id']]);
        $musiques = $stmtMusiques->fetchAll(PDO::FETCH_ASSOC);

        // Afficher les morceaux
        if (!empty($musiques)) {
            echo '<div style="margin-top: 20px; padding: 10px; background-color:rgba(249, 249, 249, 0.15); border-radius: 5px;">';
            echo '<ul style="margin:0; padding-left:20px;">';
            foreach ($musiques as $musique) {
                echo '<li>' . htmlspecialchars($musique['titre']) . ' - ' . htmlspecialchars($musique['artiste']) . '</li>';
            }
            echo '</ul>';
            echo '</div>';
        } else {
            echo '<p style="margin-top: 20px; color: gray;">Aucun morceau dans cette playlist.</p>';
        }

        // FIN de la carte (tout reste dans le même bloc)
        echo '</div>';
    }

} catch (PDOException $e) {
    echo '<p style="color: red;">Erreur lors de la récupération des playlists : ' . htmlspecialchars($e->getMessage()) . '</p>';
}
?>

<!-- Lecteur YouTube invisible -->
<div id="youtubePlayer" style="display: none;"></div>

<script>
var tag = document.createElement('script');
tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var player;
var playlistQueue = [];
var currentTrackIndex = 0;

function onYouTubeIframeAPIReady() {
    player = new YT.Player('youtubePlayer', {
        height: '1',
        width: '1',
        videoId: '',
        events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
        }
    });
}

function onPlayerReady(event) {
    console.log("Lecteur YouTube prêt");
}

function onPlayerStateChange(event) {
    // Passer au morceau suivant lorsque la vidéo actuelle se termine
    if (event.data === YT.PlayerState.ENDED) {
        playNextTrack();
    }
}

function extractYouTubeVideoId(url) {
    const regex = /(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?v=([a-zA-Z0-9_-]{11})|(?:https?:\/\/)?youtu\.be\/([a-zA-Z0-9_-]{11})/;
    const match = url.match(regex);
    return match ? (match[1] || match[2]) : null;
}

function playNextTrack() {
    if (currentTrackIndex < playlistQueue.length) {
        const track = playlistQueue[currentTrackIndex];
        const videoId = extractYouTubeVideoId(track.url);
        if (videoId) {
            player.loadVideoById(videoId);
            currentTrackIndex++;
        } else {
            alert("URL YouTube invalide pour le morceau : " + track.titre);
            currentTrackIndex++;
            playNextTrack(); // Passer au morceau suivant
        }
    } else {
        alert("Lecture terminée !");
    }
}

function playPlaylist(playlistId) {
    // Récupérer les morceaux de la playlist via une requête AJAX
    fetch(`../requete_playlist/get_playlist_tracks.php?id=${playlistId}`)
        .then(response => response.json())
        .then(data => {
            console.log(data); // Affiche la réponse dans la console
            if (data.success && data.tracks.length > 0) {
                playlistQueue = data.tracks;
                currentTrackIndex = 0;
                playNextTrack();
            } else {
                alert(data.message || "Aucun morceau dans cette playlist.");
            }
        })
        .catch(error => {
            console.error("Erreur lors de la récupération des morceaux :", error);
            alert("Une erreur est survenue lors de la lecture de la playlist.");
        });
}

// Fonction pour mettre en pause la musique
function pauseMusic() {
    if (player && player.pauseVideo) {
        player.pauseVideo(); // Mettre en pause le lecteur YouTube
    }
}
</script>
