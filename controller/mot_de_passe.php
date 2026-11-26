<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../classes/User.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/mon_compte.php');
    exit;
}

csrfVerifier('../pages/mon_compte.php');

if (!isset($_SESSION['user'])) {
    $_SESSION['message'] = "Pas d'utilisateur connecté";
    header('Location: ../pages/connexion.php');
    exit;
}


$ancien_mot_de_passe = $_POST['ancien_mot_de_passe'] ?? '';
$nouveau_mot_de_passe = $_POST['nouveau_mot_de_passe'] ?? '';
$confirmation_mot_de_passe = $_POST['confirmation_mot_de_passe'] ?? '';

if ($ancien_mot_de_passe === '' || $nouveau_mot_de_passe === '' || $confirmation_mot_de_passe === '') {
    $_SESSION['message'] = 'Renseigner tous les champs.';
    header('Location: ../pages/mon_compte.php');
    exit;
}

if (mb_strlen($nouveau_mot_de_passe, 'UTF-8') < 8) {
    $_SESSION['message'] = "8 caractères minimum.";
    header('Location: ../pages/mon_compte.php');
    exit;
}

if ($nouveau_mot_de_passe !== $confirmation_mot_de_passe) {
    $_SESSION['message'] = "Mot de passe différent";
    header('Location: ../pages/mon_compte.php');
    exit;
}

if ($ancien_mot_de_passe === $nouveau_mot_de_passe) {
    $_SESSION['message'] = "Ne pas réutiliser le même mot de passe. ";
    header('Location: ../pages/mon_compte.php');
    exit;
}


$user = new User();
$utilisateur = $user->getById($_SESSION['user']['id']);

if (!password_verify($ancien_mot_de_passe, $utilisateur['mot_de_passe'])) {
    $_SESSION['message'] = "Mot de passe actuel incorrect.";
    header('Location: ../pages/mon_compte.php');
    exit;
}

$ok = $user->updatePassword($_SESSION['user']['id'], $nouveau_mot_de_passe);

if (!$ok) {
    $_SESSION['message'] = "Impossible de modifier le mot de passe.";
    header('Location: ../pages/mon_compte.php');
    exit;
} else {
    session_regenerate_id(true);
    $_SESSION['message'] = "Mot de passe changé.";
    header('Location: ../pages/mon_compte.php');
    exit;
}
