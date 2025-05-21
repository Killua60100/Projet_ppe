<?php
session_start();
require_once 'config.php';
require_once '../vendor/autoload.php';

\Stripe\Stripe::setApiKey('sk_test_votrecléprivée');

try {
    $session = \Stripe\Checkout\Session::retrieve($_GET['session_id']);
    
    // Mettre à jour le statut premium de l'utilisateur dans la base de données
    $stmt = $mysqlClient->prepare("UPDATE utilisateurs SET abonnement = ? WHERE id = ?");
    $stmt->execute([$session->metadata->plan, $session->metadata->user_id]);

    $_SESSION['message'] = "Merci pour votre abonnement ! Votre compte est maintenant Premium.";
} catch(Exception $e) {
    $_SESSION['error'] = "Une erreur est survenue lors de la validation de votre paiement.";
}
?>

<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement réussi | Melodia</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.7.3/dist/full.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../styles/styles.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center">
    <div class="text-center">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="success-animation mb-8">
                <i class="bi bi-check-circle-fill text-6xl text-green-500"></i>
            </div>
            <h1 class="text-4xl font-bold mb-4">Paiement réussi !</h1>
            <p class="text-xl text-gray-400 mb-8"><?php echo $_SESSION['message']; ?></p>
        <?php else: ?>
            <div class="error-animation mb-8">
                <i class="bi bi-x-circle-fill text-6xl text-red-500"></i>
            </div>
            <h1 class="text-4xl font-bold mb-4">Une erreur est survenue</h1>
            <p class="text-xl text-red-400 mb-8"><?php echo $_SESSION['error']; ?></p>
        <?php endif; ?>
        
        <a href="index.php" class="btn btn-primary">
            Retourner à l'accueil
        </a>
    </div>
</body>
</html>
<?php
// Nettoyer les messages de session
unset($_SESSION['message']);
unset($_SESSION['error']);
?>