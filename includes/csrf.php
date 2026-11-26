<?php
function csrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrfField(): string
{
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(csrfToken()) . '">';
}

function csrfVerifier(string $redirection): void
{
    $envoye = $_POST['csrf_token'] ?? '';

    if (!is_string($envoye) || !hash_equals($_SESSION['csrf_token'] ?? '', $envoye)) {
        $_SESSION['message'] = 'Requête invalide ou session expirée, veuillez réessayer.';
        header('Location: ' . $redirection);
        exit;
    }
}

