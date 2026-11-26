<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../classes/User.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/connexion.php');
    exit;
}

csrfVerifier('../pages/connexion.php');

$email = trim($_POST['email'] ?? '');
$mot_de_passe = $_POST['mot_de_passe'] ?? '';

if ($email === '' || $mot_de_passe === '') {
    $_SESSION['message'] = 'Veuillez remplir tous les champs.';
    header('Location: ../pages/connexion.php');
    exit;
}

$utilisateur = getUtilisateurParEmail($pdo, $email);

    if ($utilisateur && password_verify($mot_de_passe, $utilisateur['mot_de_passe'])) {
        session_regenerate_id(true);
        unset($utilisateur['mot_de_passe']);
        $_SESSION['user'] = $utilisateur;
        header('Location: ../index.php');
        exit;
    } else {
        $_SESSION['message'] = 'Email ou mot de passe incorrect';
        header('Location: ../pages/connexion.php');
        exit;
}



?>