        // Configuration du lecteur YouTube
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        var player;
        var currentVideoId = null;
        var currentProgressBarId = null;
        var progressInterval = null;
        var currentProgressWrapperId = null;
        var currentIndex = null;
        var currentTitle = null;
        var currentArtist = null;

        function onYouTubeIframeAPIReady() {
            player = new YT.Player('youtubePlayer', {
                height: '1',
                width: '1',
                videoId: '',
                playerVars: {
                    'autoplay': 0,
                    'controls': 0,
                    'disablekb': 1,
                    'enablejsapi': 1,
                    'fs': 0,
                    'modestbranding': 1,
                    'rel': 0
                },
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange,
                    'onError': onPlayerError
                }
            });
        }
        function closeMusicPlayer() {
            document.getElementById('footer').classList.remove('pb-24');

            // Arrêter la vidéo
            if (player) {
                player.stopVideo();
            }
        
            // Masquer la barre de lecture
            document.getElementById('music-player-bar').classList.add('hidden');
        
            // Masquer les infos de la chanson
            document.getElementById('currentSongInfo').style.opacity = '0';
        
            // Stopper le suivi de progression
            stopProgressTracking();
        
            // Masquer la barre de progression active s'il y en a une
            if (currentProgressWrapperId) {
                const activeProgressWrapper = document.getElementById(currentProgressWrapperId);
                if (activeProgressWrapper) {
                    activeProgressWrapper.style.opacity = "0";
                    activeProgressWrapper.style.visibility = "hidden";
                }
            }
        
            // Réinitialiser les variables globales
            currentVideoId = null;
            currentProgressBarId = null;
            currentProgressWrapperId = null;
            currentIndex = null;
            currentTitle = '';
            currentArtist = '';
        }
                
        function onPlayerReady(event) {
            console.log("Lecteur YouTube prêt");
            // Définir le volume initial
            player.setVolume(100);
            document.getElementById('volumeSlider').value = 100;
        }

        function onPlayerStateChange(event) {
            const playPauseBtn = document.querySelector('#playPauseBtn i');
            if (event.data === YT.PlayerState.PLAYING) {
                document.getElementById('currentSongInfo').style.opacity = '1';
                playPauseBtn.classList.remove('bi-play-fill');
                playPauseBtn.classList.add('bi-pause-fill');
                startProgressTracking();
            } else if (event.data === YT.PlayerState.PAUSED) {
                playPauseBtn.classList.remove('bi-pause-fill');
                playPauseBtn.classList.add('bi-play-fill');
            } else if (event.data === YT.PlayerState.ENDED) {
                stopProgressTracking();
                document.getElementById('progressBar').style.width = "0%";
                document.getElementById('currentTime').textContent = "0:00";
                document.getElementById('duration').textContent = "0:00";
                document.getElementById('currentSongInfo').style.opacity = '0';
                playPauseBtn.classList.remove('bi-pause-fill');
                playPauseBtn.classList.add('bi-play-fill');
            }
        }

        function onPlayerError(event) {
            console.error("Erreur YouTube:", event.data);
            // Gérer les différents codes d'erreur
            switch(event.data) {
                case 2:
                    alert("ID de vidéo invalide");
                    break;
                case 5:
                    alert("Erreur HTML5");
                    break;
                case 100:
                    alert("Vidéo non trouvée");
                    break;
                case 101:
                case 150:
                    alert("La lecture de cette vidéo n'est pas autorisée");
                    break;
                default:
                    alert("Une erreur est survenue lors de la lecture");
            }
        }

        function setVolume(volume) {
            if (player && player.setVolume) {
                player.setVolume(volume * 100);
            }
        }

        function adjustVolume(delta) {
            const slider = document.getElementById('volumeSlider');
            const newValue = Math.max(0, Math.min(100, parseInt(slider.value) + (delta * 100)));
            slider.value = newValue;
            setVolume(newValue / 100);
        }

        function extractYouTubeVideoId(url) {
            const regex = /(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?v=([a-zA-Z0-9_-]{11})|(?:https?:\/\/)?youtu\.be\/([a-zA-Z0-9_-]{11})/;
            const match = url.match(regex);
            return match ? (match[1] || match[2]) : null;
        }

        function togglePlay(url, index, title, artist) {
            console.log(url)
            const videoId = extractYouTubeVideoId(url);
            if (!videoId) {
                console.error("URL YouTube invalide :", url);
                return;
            }
            document.getElementById('footer').classList.add('pb-24');

            document.getElementById('currentTitle').textContent = title;
            document.getElementById('currentArtist').textContent = artist;
        
            const previousWrapperId = 'progressWrapper' + currentIndex;
            const newWrapperId = 'progressWrapper' + index;
        
            if (player) {
                const playerState = player.getPlayerState();
        
                if (currentVideoId === videoId && playerState === YT.PlayerState.PLAYING) {
                    // Même musique → on arrête
                    player.stopVideo();
                    stopProgressTracking();
                    currentVideoId = null;
                    document.getElementById('currentSongInfo').style.opacity = '0';
        
                    if (previousWrapperId) {
                        const wrapper = document.getElementById(previousWrapperId);
                        if (wrapper) {
                            wrapper.style.opacity = "0";
                            wrapper.style.visibility = "hidden";
                        }
                    }
        
                    // Masquer la barre de lecture
                    document.getElementById('music-player-bar').classList.add('hidden');
        
                } else {
                    // Nouvelle musique
                    currentVideoId = videoId;
                    currentProgressBarId = 'progressBar' + index;
                    currentProgressWrapperId = newWrapperId;
                    currentIndex = index;
                    currentTitle = title;
                    currentArtist = artist;
        
                    // Masquer l'ancienne barre de progression
                    if (previousWrapperId && previousWrapperId !== newWrapperId) {
                        const oldWrapper = document.getElementById(previousWrapperId);
                        if (oldWrapper) {
                            oldWrapper.style.opacity = "0";
                            oldWrapper.style.visibility = "hidden";
                        }
                    }
        
                    // Lancer la nouvelle musique
                    player.loadVideoById({
                        'videoId': videoId,
                        'suggestedQuality': 'small'
                    });
        
                    // Afficher la nouvelle barre de progression
                    const newWrapper = document.getElementById(newWrapperId);
                    if (newWrapper) {
                        newWrapper.style.visibility = "visible";
                        newWrapper.style.opacity = "1";
                    }
        
                    document.getElementById('currentSongInfo').style.opacity = '1';
                    startProgressTracking();
        
                    // Afficher la barre de lecture
                    document.getElementById('music-player-bar').classList.remove('hidden');
                }
            }
        }
        

        function updateProgressBar() {
            if (player && player.getDuration && player.getCurrentTime) {
                const duration = player.getDuration();
                const currentTime = player.getCurrentTime();
                if (duration > 0) {
                    const percent = (currentTime / duration) * 100;
                    document.getElementById('progressBar').style.width = percent + "%";
                    document.getElementById('currentTime').textContent = formatTime(currentTime);
                    document.getElementById('duration').textContent = formatTime(duration);
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

        function formatTime(seconds) {
            const minutes = Math.floor(seconds / 60);
            seconds = Math.floor(seconds % 60);
            return `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        }

        function playPause() {
            if (player && currentVideoId) {
                const state = player.getPlayerState();
                if (state === YT.PlayerState.PLAYING) {
                    player.pauseVideo();
                    document.querySelector('#playPauseBtn i').classList.remove('bi-pause-fill');
                    document.querySelector('#playPauseBtn i').classList.add('bi-play-fill');
                } else {
                    player.playVideo();
                    document.querySelector('#playPauseBtn i').classList.remove('bi-play-fill');
                    document.querySelector('#playPauseBtn i').classList.add('bi-pause-fill');
                }
            }
        }

        function seekToPosition(event) {
            if (player && currentVideoId) {
                const container = document.getElementById('progressBarContainer');
                const rect = container.getBoundingClientRect();
                const clickPosition = (event.clientX - rect.left) / rect.width;
                const duration = player.getDuration();
                const newTime = duration * clickPosition;
                player.seekTo(newTime, true);
            }
        }

        function showTimePreview(event) {
            if (player && currentVideoId) {
                const container = document.getElementById('progressBarContainer');
                const preview = document.getElementById('timePreview');
                const rect = container.getBoundingClientRect();
                const position = (event.clientX - rect.left) / rect.width;
                const duration = player.getDuration();
                const previewTime = duration * position;
                
                preview.textContent = formatTime(previewTime);
                preview.style.left = event.clientX + 'px';
                preview.style.display = 'block';
            }
        }

        function hideTimePreview() {
            document.getElementById('timePreview').style.display = 'none';
        }

        function rewind10() {
            if (player && currentVideoId) {
                const currentTime = player.getCurrentTime();
                player.seekTo(Math.max(0, currentTime - 10), true);
            }
        }

        function forward10() {
            if (player && currentVideoId) {
                const currentTime = player.getCurrentTime();
                const duration = player.getDuration();
                player.seekTo(Math.min(duration, currentTime + 10), true);
            }
        }

        function previousTrack() {
            // On implémentera cette fonction plus tard avec la gestion de la playlist
            console.log("Previous track");
        }

        function nextTrack() {
            // On implémentera cette fonction plus tard avec la gestion de la playlist
            console.log("Next track");
        }
    


// JS DU index.php