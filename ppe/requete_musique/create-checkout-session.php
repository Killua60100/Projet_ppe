<?php
require_once '../page/config.php';
require_once '../vendor/autoload.php';

// Configuration de Stripe
\Stripe\Stripe::setApiKey('sk_test_votrecléprivée'); // Remplacez par votre clé secrète Stripe

header('Content-Type: application/json');

try {
    $jsonStr = file_get_contents('php://input');
    $jsonObj = json_decode($jsonStr);

    if (!isset($jsonObj->plan) || !isset($jsonObj->price) || !isset($jsonObj->userId)) {
        throw new Exception('Données manquantes');
    }

    // Créer la session de paiement
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'eur',
                'product_data' => [
                    'name' => 'Abonnement Melodia ' . $jsonObj->plan,
                ],
                'unit_amount' => intval($jsonObj->price * 100), // Convertir en centimes
                'recurring' => [
                    'interval' => 'month',
                ],
            ],
            'quantity' => 1,
        ]],
        'mode' => 'subscription',
        'success_url' => 'https://votre-site.com/success.php?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => 'https://votre-site.com/cancel.php',
        'customer_email' => $_SESSION['email'] ?? null,
        'metadata' => [
            'user_id' => $jsonObj->userId,
            'plan' => $jsonObj->plan
        ],
    ]);

    echo json_encode(['id' => $session->id]);
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}