<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<nav class="side-nav">
        <div class="logo-section">
            <a href="index.php" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                <img src="../document/logo.png" alt="Melodia" class="h-8">
                <span class="text-xl font-bold bg-gradient-to-r from-indigo-500 to-purple-500 bg-clip-text text-transparent">
                    Melodia
                </span>
            </a>
        </div>

        <div class="nav-links">
            <a href="index.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : ''; ?>">
                <i class="bi bi-house-door"></i>
                <span>Accueil</span>
            </a>
            <a href="rechercher.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'rechercher.php' ? 'active' : ''; ?>">
                <i class="bi bi-music-note-list"></i>
                <span>Rechercher</span>
            </a>
            <a href="playlists.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'playlists.php' ? 'active' : ''; ?>">
                <i class="bi bi-music-note-list"></i>
                <span>Playlists</span>
            </a>
            <a href="abonnement.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'abonnement.php' ? 'active' : ''; ?>">
                <i class="bi bi-star"></i>
                <span>Abonnement</span>
            </a>
            <a href="favoris.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'favoris.php' ? 'active' : ''; ?>">
                <i class="bi bi-heart"></i>
                <span>Favoris</span>
            </a>
            <a href="#" class="nav-link">
                <i class="bi bi-clock-history"></i>
                <span>Récents</span>
            </a>
        </div>

        <div class="mt-auto">
            <?php if (isset($_SESSION['id'])): ?>
                <div class="flex flex-col gap-2 p-4 bg-gradient-to-br from-indigo-500/10 to-purple-500/10 rounded-lg backdrop-blur">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center">
                            <?php echo isset($_SESSION['prenom']) ? strtoupper(substr($_SESSION['prenom'], 0, 1)) : 'U'; ?>
                        </div>
                        <div>
                            <div class="font-semibold"><?php echo $_SESSION['prenom']; ?></div>
                            <div class="text-sm text-gray-400">Premium</div>
                        </div>
                    </div>
                    <a href="#" onclick="logout_modal.showModal()" class="mt-2 flex items-center gap-2 text-red-400 hover:text-red-300 transition-colors">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Déconnexion</span>
                    </a>
                </div>
            <?php else: ?>
                <div class="flex flex-col gap-2 p-4">
                    <a href="connexion.php" class="btn btn-ghost btn-block">Connexion</a>
                    <a href="inscription.php" class="btn btn-primary btn-block">S'inscrire</a>
                </div>
            <?php endif; ?>
        </div>
    </nav>
    <script src="../js/sideNavRetracted.js"></script>
</body>
</html>

