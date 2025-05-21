<?php
session_start();
require_once './config.php';

$plans = [
    [
        'name' => 'Gratuit',
        'price' => '0',
        'period' => '',
        'color' => 'from-gray-500 to-gray-600',
        'popular' => false,
        'features' => [
            'Écoute avec publicités',
            'Qualité audio normale',
            'Lecture aléatoire uniquement',
            'Accès mobile uniquement'
        ]
    ],
    [
        'name' => 'Individuel',
        'price' => '10.99',
        'period' => 'mois',
        'color' => 'from-indigo-500 to-purple-600',
        'popular' => false,
        'features' => [
            'Écoute sans publicité',
            'Qualité audio supérieure',
            'Écoute hors connexion',
            'Lecture à la demande'
        ]
    ],
    [
        'name' => 'Famille',
        'price' => '17.99',
        'period' => 'mois',
        'color' => 'from-green-500 to-emerald-600',
        'popular' => false,
        'features' => [
            'Jusqu\'à 6 comptes',
            'Contrôle parental',
            'Playlists partagées',
            'Qualité audio supérieure'
        ]
    ],
    [
        'name' => 'Pro',
        'price' => '19.99',
        'period' => 'mois',
        'color' => 'from-violet-500 to-fuchsia-600',
        'popular' => true,
        'features' => [
            'Audio Spatial & Dolby Atmos',
            'IA Mix personnalisé',
            'Égaliseur professionnel',
            'Analyse audio avancée'
        ]
    ]
];
?>

<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abonnements | Melodia</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.7.3/dist/full.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../styles/styles.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Stripe JS -->
    <script src="https://js.stripe.com/v3/"></script>
</head>

<?php include '../components/sidebar.php'; ?>

    <main class="container mx-auto px-4 py-16 max-w-7xl">
        <div class="text-center mb-16">
            <h1 class="text-5xl font-bold mb-4">Choisissez votre plan</h1>
            <p class="text-xl text-gray-400">Découvrez la musique sans limites</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php foreach($plans as $index => $plan): ?>
            <div class="plan-card rounded-2xl overflow-hidden p-6 <?php echo isset($plan['popular']) && $plan['popular'] ? 'ring-2 ring-purple-500' : ''; ?>"
                 style="animation-delay: <?php echo $index * 0.1; ?>s">
                <?php if(isset($plan['popular']) && $plan['popular']): ?>
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 text-xs bg-purple-500 rounded-full">Plus populaire</span>
                </div>
                <?php endif; ?>

                <div class="glow" style="--start-color: <?php echo explode(' ', $plan['color'])[0]; ?>; 
                                       --end-color: <?php echo explode(' ', $plan['color'])[1]; ?>">
                    <h3 class="text-2xl font-bold mb-4"><?php echo $plan['name']; ?></h3>
                    <div class="mb-6">
                        <span class="text-4xl font-bold price-tag">
                            <?php if($plan['price'] > 0): ?>
                                <?php echo $plan['price']; ?>€
                            <?php else: ?>
                                Gratuit
                            <?php endif; ?>
                        </span>
                        <?php if($plan['period']): ?>
                            <span class="text-gray-400">/ <?php echo $plan['period']; ?></span>
                        <?php endif; ?>
                    </div>

                    <ul class="space-y-4 mb-8">
                        <?php foreach($plan['features'] as $feature): ?>
                        <li class="flex items-center gap-3">
                            <i class="bi bi-check2 text-green-500"></i>
                            <span><?php echo $feature; ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>

                    <button onclick="openPaymentModal('<?php echo $plan['name']; ?>', '<?php echo $plan['price']; ?>')" 
                            class="btn-subscribe w-full py-3 px-6 rounded-full bg-gradient-to-r <?php echo $plan['color']; ?> 
                            hover:opacity-90 transition-opacity font-semibold transform hover:scale-105 duration-300">
                        <span class="relative z-10">Commencer</span>
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Features Section -->
        <section class="mt-32">
            <h2 class="text-3xl font-bold text-center mb-16">Pourquoi choisir Melodia Premium ?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="text-center floating" style="animation-delay: 0s">
                    <div class="w-16 h-16 mx-auto mb-6 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl 
                                flex items-center justify-center text-2xl">
                        <i class="bi bi-music-note-beamed"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Qualité Audio Premium</h3>
                    <p class="text-gray-400">Profitez d'un son cristallin en qualité HD</p>
                </div>

                <div class="text-center floating" style="animation-delay: 0.2s">
                    <div class="w-16 h-16 mx-auto mb-6 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-xl 
                                flex items-center justify-center text-2xl">
                        <i class="bi bi-cloud-download"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Écoute Hors Connexion</h3>
                    <p class="text-gray-400">Téléchargez vos titres préférés</p>
                </div>

                <div class="text-center floating" style="animation-delay: 0.4s">
                    <div class="w-16 h-16 mx-auto mb-6 bg-gradient-to-r from-green-500 to-emerald-500 rounded-xl 
                                flex items-center justify-center text-2xl">
                        <i class="bi bi-broadcast"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Sans Publicité</h3>
                    <p class="text-gray-400">Musique sans interruption</p>
                </div>
            </div>
        </section>
    </main>

    <!-- Ajouter le modal de paiement avant la fermeture du body -->
    <dialog id="payment-modal" class="modal">
        <div class="modal-box bg-base-200 max-w-2xl">
            <div class="modal-content">
                <h3 class="font-bold text-2xl mb-6 bg-gradient-to-r from-fuchsia-500 to-cyan-500 bg-clip-text text-transparent">
                    Choisissez votre moyen de paiement
                </h3>
                <p class="mb-4">Abonnement sélectionné: 
                    <span id="selected-plan" class="font-bold text-fuchsia-400"></span>
                </p>
                <p class="mb-6">Montant total: 
                    <span id="selected-price" class="font-bold text-cyan-400"></span>
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                    <!-- Stripe -->
                    <div class="payment-method p-4 border rounded-lg flex items-center gap-4" data-method="stripe">
                        <div class="flex items-center justify-center w-8 h-8 bg-gradient-to-r from-indigo-500 to-purple-500 rounded">
                            <i class="bi bi-stripe text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold">Stripe</h4>
                            <p class="text-sm text-gray-400">Paiement sécurisé</p>
                        </div>
                    </div>

                    <!-- PayPal avec nouveau style -->
                    <div class="payment-method p-4 border rounded-lg flex items-center gap-4" data-method="paypal">
                        <div class="flex items-center justify-center w-8 h-8 bg-[#003087] rounded">
                            <i class="bi bi-paypal text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold">PayPal</h4>
                            <p class="text-sm text-gray-400">Paiement rapide</p>
                        </div>
                    </div>

                    <!-- Crypto avec nouveaux logos -->
                    <div class="payment-method p-4 border rounded-lg flex items-center gap-4" data-method="crypto">
                        <div class="flex gap-2">
                            <div class="w-8 h-8 bg-[#F7931A] rounded-full flex items-center justify-center">₿</div>
                            <div class="w-8 h-8 bg-[#627EEA] rounded-full flex items-center justify-center">Ξ</div>
                        </div>
                        <div>
                            <h4 class="font-bold">Crypto</h4>
                            <p class="text-sm text-gray-400">BTC, ETH, etc.</p>
                        </div>
                    </div>

                    <!-- Apple Pay -->
                    <div class="payment-method p-4 border rounded-lg flex items-center gap-4" data-method="apple">
                        <i class="bi bi-apple text-2xl"></i>
                        <div>
                            <h4 class="font-bold">Apple Pay</h4>
                            <p class="text-sm text-gray-400">Paiement rapide</p>
                        </div>
                    </div>
                </div>

                <div class="payment-error" id="payment-error">
                    Veuillez sélectionner un mode de paiement
                </div>

                <div class="modal-action">
                    <button class="btn btn-ghost" onclick="closePaymentModal()">Annuler</button>
                    <button class="btn btn-primary flex items-center gap-2" onclick="processPayment()">
                        <span>Payer maintenant</span>
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </dialog>

    <script>
        function openPaymentModal(planName, price) {
            const modal = document.getElementById('payment-modal');
            const errorMessage = document.getElementById('payment-error');
            
            // Reset l'état du modal
            document.querySelectorAll('.payment-method').forEach(method => {
                method.classList.remove('selected', 'error');
            });
            errorMessage.classList.remove('visible');
            
            // Mettre à jour les informations
            document.getElementById('selected-plan').textContent = planName;
            document.getElementById('selected-price').textContent = price > 0 ? `${price}€/mois` : 'Gratuit';
            
            modal.showModal();
        }

        function closePaymentModal() {
            document.getElementById('payment-modal').close();
        }

        // Gestion de la sélection des méthodes de paiement
        document.querySelectorAll('.payment-method').forEach(method => {
            method.addEventListener('click', () => {
                document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('selected'));
                method.classList.add('selected');
            });
        });

        function processPayment() {
            const selectedMethod = document.querySelector('.payment-method.selected');
            const errorMessage = document.getElementById('payment-error');
            
            // Réinitialiser les états d'erreur
            document.querySelectorAll('.payment-method').forEach(method => {
                method.classList.remove('error');
            });
            errorMessage.classList.remove('visible');

            if (!selectedMethod) {
                // Afficher l'erreur avec animation
                errorMessage.classList.add('visible');
                document.querySelectorAll('.payment-method').forEach(method => {
                    method.classList.add('error');
                });
                return;
            }

            try {
                const method = selectedMethod.dataset.method;
                console.log(`Traitement du paiement avec ${method}...`);
                
                switch(method) {
                    case 'stripe':
                        handleStripePayment();
                        break;
                    case 'paypal':
                        handlePaypalPayment();
                        break;
                    case 'crypto':
                        handleCryptoPayment();
                        break;
                    case 'apple':
                        handleApplePay();
                        break;
                    default:
                        throw new Error('Méthode de paiement non supportée');
                }
            } catch (error) {
                console.error('Erreur de paiement:', error);
                errorMessage.textContent = "Une erreur est survenue lors du paiement. Veuillez réessayer.";
                errorMessage.classList.add('visible');
            }
        }

        // Initialisation de Stripe
        const stripe = Stripe('pk_test_votreclépublique'); // Remplacez par votre clé publique Stripe

        function handleStripePayment() {
            const selectedPlan = document.getElementById('selected-plan').textContent;
            const selectedPrice = document.getElementById('selected-price').textContent;
            
            fetch('../requete_musique/create-checkout-session.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    plan: selectedPlan,
                    price: selectedPrice.replace('€/mois', ''),
                    userId: <?php echo isset($_SESSION['id']) ? $_SESSION['id'] : 'null'; ?>
                })
            })
            .then(response => response.json())
            .then(session => {
                return stripe.redirectToCheckout({ sessionId: session.id });
            })
            .then(result => {
                if (result.error) {
                    alert(result.error.message);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Une erreur est survenue. Veuillez réessayer.');
            });
        }

        function handlePaypalPayment() {
            window.location.href = '../requete_musique/paypal-checkout.php?' + new URLSearchParams({
                plan: document.getElementById('selected-plan').textContent,
                price: document.getElementById('selected-price').textContent.replace('€/mois', '')
            });
        }

        function handleCryptoPayment() {
            console.log('Initialisation du paiement Crypto...');
            alert('Préparation de la transaction crypto...');
        }

        function handleApplePay() {
            console.log('Initialisation d\'Apple Pay...');
            alert('Ouverture d\'Apple Pay...');
        }

        // Modal backdrop click to close
        document.querySelector('.modal-backdrop').addEventListener('click', () => {
            closePaymentModal();
        });

        const sideNav = document.querySelector('.side-nav');
        const main = document.querySelector('main');
        
        // Fonction pour rétracter la navbar
        function retractNav() {
            sideNav.classList.add('retracted');
            main.classList.add('retracted');
        }
        
        // Fonction pour étendre la navbar
        function expandNav() {
            sideNav.classList.remove('retracted');
            main.classList.remove('retracted');
        }
        
        // Écouteurs d'événements pour la navbar
        sideNav.addEventListener('mouseenter', () => {
            expandNav();
        });
        
        sideNav.addEventListener('mouseleave', () => {
            retractNav();
        });
        
        // Rétractation initiale après 3 secondes
        setTimeout(retractNav, 3000);
    </script>

    <!-- Modal de déconnexion -->
    <dialog id="logout_modal" class="modal">
        <div class="modal-box bg-[#1a103f] border border-indigo-500/20 backdrop-blur-xl">
            <div class="flex flex-col items-center gap-6 p-4">
                <!-- Icône animée -->
                <div class="relative w-20 h-20">
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full animate-pulse"></div>
                    <div class="absolute inset-2 bg-[#1a103f] rounded-full flex items-center justify-center">
                        <i class="bi bi-power text-3xl text-white"></i>
                    </div>
                </div>

                <h3 class="text-2xl font-bold bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">
                    Déconnexion
                </h3>
                
                <p class="text-gray-300 text-center">
                    Êtes-vous sûr de vouloir vous déconnecter ?
                </p>

                <div class="flex gap-4 mt-4">
                    <a href="logout.php" class="btn bg-gradient-to-r from-red-500 to-pink-500 border-0 hover:scale-105 transition-transform duration-200 text-white">
                        <i class="bi bi-box-arrow-right mr-2"></i>
                        Déconnexion
                    </a>
                    <button onclick="logout_modal.close()" class="btn btn-ghost border border-gray-600 hover:border-gray-400">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop bg-black/50 backdrop-blur-sm">
            <button>Fermer</button>
        </form>
    </dialog>

    <?php include '../components/footer.php'; ?>
    <script src="../code js/navbar.js"></script>
</body>
</html>