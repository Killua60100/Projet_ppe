   // Charger l’API YouTube
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

   function togglePlay(url, index, titre, artiste) {
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
               // Même musique → on arrête
               player.stopVideo();
               stopProgressTracking();
               currentVideoId = null;

               // Masquer la barre de progression
               if (previousWrapperId) {
                   const wrapper = document.getElementById(previousWrapperId);
                   wrapper.style.opacity = "0";
                   wrapper.style.visibility = "hidden";
               }
           } else {
               // Nouvelle musique
               currentVideoId = videoId;
               currentProgressBarId = 'progressBar' + index;
               currentProgressWrapperId = newWrapperId;
               currentIndex = index;

               // Masquer l'ancienne barre
               if (previousWrapperId && previousWrapperId !== newWrapperId) {
                   const oldWrapper = document.getElementById(previousWrapperId);
                   if (oldWrapper) {
                       oldWrapper.style.opacity = "0";
                       oldWrapper.style.visibility = "hidden";
                   }
               }

               // Lancer la nouvelle musique
               player.loadVideoById(videoId);

               // Afficher la nouvelle barre
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

   // Fonction pour gérer les favoris
   function toggleFavorite(musicId) {
       const btn = document.querySelector(`.favorite-btn[data-music-id="${musicId}"]`);
       
       fetch(`../requete_musique/toggle_favori.php?musique_id=${musicId}`, {
           method: 'POST',
           credentials: 'same-origin'
       })
       .then(response => response.json())
       .then(data => {
           if (data.success) {
               btn.classList.toggle('active');
               const icon = btn.querySelector('i');
               if (btn.classList.contains('active')) {
                   icon.style.color = 'white';
               } else {
                   icon.style.color = 'transparent';
               }
           }
       })
       .catch(error => console.error('Erreur:', error));
   }