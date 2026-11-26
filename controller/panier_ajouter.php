<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../classes/Panier.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../classes/Commande.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php');
    exit;
}

csrfVerifier('../index.php');

if (!isset($_SESSION['user'])) {
    $_SESSION['message'] = 'Connectez-vous pour utiliser le panier.';
    header('Location: ../pages/connexion.php');
    exit;
}

$imdbId = trim($_POST['imdb_id'] ?? '');

$stmt = $pdo->prepare("SELECT COUNT(*) FROM films WHERE imdb_id = :film");
$stmt->execute([':film' => $imdbId]);

if ($imdbId === '' || (int) $stmt->fetchColumn() === 0) {
    $_SESSION['message'] = 'Film invalide.';
    header('Location: ../index.php');
    exit;
}

$panier = new Panier();
$idUtilisateur = $_SESSION['user']['id'];

if ((new Commande())->possede($idUtilisateur, $imdbId)) {
    $_SESSION['message'] = 'Vous possédez déjà ce film.';
    header('Location: ../pages/panier.php');
    exit;
}

try {
    if ($panier->ajouter($idUtilisateur, $imdbId)) {
        $_SESSION['message'] = 'Film ajouté au panier.';
    } else {
        $_SESSION['message'] = 'Film déjà présent dans le panier.';
    }
} catch (PDOException $e) {
    if ((int) $e->errorInfo[1] === 1452) {
        $_SESSION['message'] = 'Film introuvable.';
    } else {
        throw $e;
    }
}

header('Location: ../pages/panier.php');
exit;