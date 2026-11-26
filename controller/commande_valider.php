<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../classes/Commande.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/panier.php');
    exit;
}

csrfVerifier('../pages/panier.php');

if (!isset($_SESSION['user'])) {
    $_SESSION['message'] = 'Connectez-vous pour utiliser le panier.';
    header('Location: ../pages/connexion.php');
    exit;
}

$commande = new Commande();
$destination = '../pages/panier.php';

try {
    $idCommande = $commande->valider($_SESSION['user']['id']);

    if ($idCommande === false) {
        $_SESSION['message'] = 'Votre panier est vide.';
    } else {
        $_SESSION['message'] = 'Commande validée, merci pour votre achat !';
        $destination = '../pages/mes_achats.php';
        header('Location: ' . $destination);
        exit;
    }
} catch (RuntimeException $e) {
    $_SESSION['message'] = $e->getMessage();
}

header('Location: ../pages/panier.php');
exit;
