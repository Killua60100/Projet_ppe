<!-- Contrôles du lecteur -->
<div id="music-player-bar" class="hidden fixed bottom-0 left-0 right-0 bg-[#1a103f]/90 backdrop-blur-lg border-t border-white/10 p-4">
    <div class="container mx-auto flex flex-col gap-2">

        <!-- Info chanson et contrôles -->
        <div class="flex items-center justify-between">
            <div id="currentSongInfo" class="flex items-center gap-3 opacity-0 transition-opacity">
                <div class="w-12 h-12 bg-white/10 rounded flex items-center justify-center">
                    <i class="bi bi-music-note text-2xl"></i>
                </div>
                <div>
                    <h4 class="font-medium" id="currentTitle">-</h4>
                    <p class="text-sm text-gray-400" id="currentArtist">-</p>
                </div>
            </div>

            <!-- Contrôles de lecture -->
            <div class="flex items-center gap-4">
                <button onclick="previousTrack()" class="btn btn-circle btn-sm btn-ghost">
                    <i class="bi bi-skip-start-fill text-xl"></i>
                </button>
                <button onclick="rewind10()" class="btn btn-circle btn-sm btn-ghost">
                    <i class="bi bi-arrow-counterclockwise text-xl"></i>
                </button>
                <button onclick="playPause()" class="btn btn-circle btn-sm btn-ghost" id="playPauseBtn">
                    <i class="bi bi-play-fill text-xl"></i>
                </button>
                <button onclick="forward10()" class="btn btn-circle btn-sm btn-ghost">
                    <i class="bi bi-arrow-clockwise text-xl"></i>
                </button>
                <button onclick="nextTrack()" class="btn btn-circle btn-sm btn-ghost">
                    <i class="bi bi-skip-end-fill text-xl"></i>
                </button>

                <!-- Bouton Like -->

            </div>

            <!-- Volume -->
            <div class="flex items-center gap-4">
                <button onclick="adjustVolume(-0.1)" class="btn btn-circle btn-sm btn-ghost">
                    <i class="bi bi-volume-down"></i>
                </button>
                <input type="range" id="volumeSlider" min="0" max="100" value="100" 
                       class="range range-xs range-primary w-24"
                       onchange="setVolume(this.value / 100)">
                <button onclick="adjustVolume(0.1)" class="btn btn-circle btn-sm btn-ghost">
                    <i class="bi bi-volume-up"></i>
                </button>
            </div>
        </div>

        <!-- Barre de progression -->
        <div class="w-full h-1 bg-gray-700 rounded-full overflow-hidden cursor-pointer" 
             onclick="seekToPosition(event)" 
             onmousemove="showTimePreview(event)" 
             onmouseleave="hideTimePreview()"
             id="progressBarContainer">
            <div id="progressBar" class="h-full bg-primary" style="width: 0%"></div>
            <div id="timePreview" class="hidden absolute transform -translate-x-1/2 -translate-y-8 bg-black/80 px-2 py-1 rounded text-xs"></div>
        </div>

        <!-- Temps -->
        <div class="flex justify-between text-xs text-gray-400">
            <span id="currentTime">0:00</span>
            <span id="duration">0:00</span>
        </div>
    </div>
</div>
