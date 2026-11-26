<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../classes/User.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/inscription.php');
    exit;
}

csrfVerifier('../pages/inscription.php');

$email = trim($_POST['email'] ?? '');
$pseudo = trim($_POST['pseudo'] ?? '');
$mot_de_passe = $_POST['mot_de_passe'] ?? '';
$confirmation = $_POST['mot_de_passe_confirmation'] ?? '';

if ($email === '' || $pseudo === '' || $mot_de_passe === '') {
    $_SESSION['message'] = 'Veuillez remplir tous les champs.';
    header('Location: ../pages/inscription.php');
    exit;
}


if (mb_strlen($pseudo, 'UTF-8') < 5 || mb_strlen($pseudo, 'UTF-8') > 30) {
    $_SESSION['message'] = "Votre pseudo doit contenir entre 5 et 30 caractères.";
    header('Location: ../pages/inscription.php');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email, 'UTF-8') > 255) {
    $_SESSION['message'] = "Adresse email invalide.";
    header('Location: ../pages/inscription.php');
    exit;
}

if (!preg_match('/^[\p{L}\p{N}_-]+$/u', $pseudo)) {
    $_SESSION['message'] = "Le pseudo ne peut contenir que des lettres, chiffres, tirets et underscores.";
    header('Location: ../pages/inscription.php');
    exit;
}

if (mb_strlen($mot_de_passe, 'UTF-8') < 8) {
    $_SESSION['message'] = "8 caractères minimum.";
    header('Location: ../pages/inscription.php');
    exit;
}

if ($mot_de_passe !== $confirmation) {
    $_SESSION['message'] = "Mot de passe différent";
    header('Location: ../pages/inscription.php');
    exit;
}


$userModel = new User();

if (!$userModel->insert($pseudo, $email, $mot_de_passe)) {
    $_SESSION['message'] = "Ce pseudo ou cet email est déjà utilisé.";
    header('Location: ../pages/inscription.php');
    exit;
} else {
    $_SESSION['message'] = "Compte créé";
    header('Location: ../pages/connexion.php');
    exit;
}
