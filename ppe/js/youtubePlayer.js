var tag = document.createElement('script');
tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var player;
var currentVideoId = null;

function onYouTubeIframeAPIReady() {
    player = new YT.Player('youtubePlayer', {
        height: '100',
        width: '100',
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
    if (!videoId) return;

    if (player) {
        const state = player.getPlayerState();
        if (currentVideoId === videoId && state === YT.PlayerState.PLAYING) {
            player.stopVideo();
            currentVideoId = null;
        } else {
            currentVideoId = videoId;
            player.loadVideoById(videoId);
            player.playVideo();
        }
    }
}