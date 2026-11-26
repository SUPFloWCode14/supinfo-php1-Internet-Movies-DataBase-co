<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../classes/Panier.php';
require_once __DIR__ . '/../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php');
    exit;
}

csrfVerifier('../pages/panier.php');

if (!isset($_SESSION['user'])) {
    $_SESSION['message'] = 'Connectez-vous pour utiliser le panier.';
    header('Location: ../pages/connexion.php');
    exit;
}

$panier = new Panier();
$panier->vider($_SESSION['user']['id']);

$_SESSION['message'] = 'Votre panier a été vidé.';
header('Location: ../pages/panier.php');
exit;