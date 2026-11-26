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

$imdbId = trim($_POST['imdb_id'] ?? '');

$panier = new Panier();
$idUtilisateur = $_SESSION['user']['id'];

if ($panier->retirer($idUtilisateur, $imdbId)) {
    $_SESSION['message'] = 'Film retiré du panier.';
} else {
    $_SESSION['message'] = "Ce film n'est pas dans votre panier.";
}

header('Location: ../pages/panier.php');
exit;
