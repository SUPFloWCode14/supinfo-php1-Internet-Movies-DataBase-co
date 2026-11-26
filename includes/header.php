<?php
require_once __DIR__ . '/../includes/session.php';

$dossierPage = basename(dirname($_SERVER['SCRIPT_NAME']));
$dansPages   = ($dossierPage === 'pages');

$racine  = $dansPages ? '../' : '';
$prefixe = $dansPages ? '' : 'pages/';

$nomPage = pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME);
$nomPage = str_replace(['_', '-'], ' ', $nomPage);
$nomPage = ucfirst(strtolower($nomPage));

if ($nomPage === '') {
    $nomPage = 'Page';
}

require_once __DIR__ . '/../includes/config.php';

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($nomPage, ENT_QUOTES, 'UTF-8') ?></title>

    <link rel="stylesheet" href="<?= $racine ?>css/style.css">
</head>

<body>

    <header>

        <div class="header-titre">
            <a href="<?= $racine ?>index.php" class="header-logo-site">IMDB'&amp;'Co</a>
            <div class="header-icones">
                <div class="header-icone">

                    <?php if (isset($_SESSION['user'])): ?>
                        <div class="connexion-user" role="alert">
                            <?= htmlspecialchars($_SESSION['user']['pseudo']); ?>
                            <form method="post" action="<?= $prefixe ?>deconnexion.php" class="header-deconnexion">
                                <?= csrfField() ?>
                                <button type="submit">Déconnexion</button>
                            </form>
                            <!-- <a href="<?= $prefixe ?>deconnexion.php">Déconnexion</a> -->
                        </div>
                        <div>
                            <a href="<?= $prefixe ?>espace_client.php">
                                <svg width="48" height="48" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#fff" style="filter: drop-shadow(0 0 6px #ff6a00) drop-shadow(0 0 12px #ff9b54);">
                                    <path d="M15.71,12.71a6,6,0,1,0-7.42,0,10,10,0,0,0-6.22,8.18,1,1,0,0,0,2,.22,8,8,0,0,1,15.9,0,1,1,0,0,0,1,.89h.11a1,1,0,0,0,.88-1.1A10,10,0,0,0,15.71,12.71ZM12,12a4,4,0,1,1,4-4A4,4,0,0,1,12,12Z" />
                                </svg>
                            </a>
                        </div>

                    <?php else: ?>
                        <a href="<?= $prefixe ?>connexion.php">
                            <svg width="48" height="48" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#fff" style="filter: drop-shadow(0 0 6px #ff6a00) drop-shadow(0 0 12px #ff9b54);">
                                <path d="M15.71,12.71a6,6,0,1,0-7.42,0,10,10,0,0,0-6.22,8.18,1,1,0,0,0,2,.22,8,8,0,0,1,15.9,0,1,1,0,0,0,1,.89h.11a1,1,0,0,0,.88-1.1A10,10,0,0,0,15.71,12.71ZM12,12a4,4,0,1,1,4-4A4,4,0,0,1,12,12Z" />
                            </svg>
                        </a>

                    <?php endif; ?>
                </div>
                <div class="header-icone">

                    <a href="<?= $prefixe ?>search.php" id="icone-recherche">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none"
                            style="filter: drop-shadow(0 0 6px #ff6a00) drop-shadow(0 0 12px #ff9b54);">
                            <circle cx="12" cy="11" r="6" stroke="#fff" stroke-width="2" />
                            <line x1="9" y1="15" x2="4" y2="21" stroke="#fff" stroke-width="2" />
                        </svg>
                    </a>

                </div>
            </div>
        </div>
        <div>
            <nav>
                <ul class="header-liens">
                    <a href="<?= $prefixe ?>categories.php">
                        <!-- License: PD. Made by Aleksey Popov: https://dribbble.com/AlekseyPopov -->
                        <svg fill="#fff" style="filter: drop-shadow(0 0 6px #ff6a00) drop-shadow(0 0 12px #ff9b54);" width="48" height="48" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M13,4 L13,11 L20,11 L20,4 L13,4 Z M11,4 L4,4 L4,11 L11,11 L11,4 Z M13,20 L20,20 L20,13 L13,13 L13,20 Z M11,20 L11,13 L4,13 L4,20 L11,20 Z M4,2 L20,2 C21.1045695,2 22,2.8954305 22,4 L22,20 C22,21.1045695 21.1045695,22 20,22 L4,22 C2.8954305,22 2,21.1045695 2,20 L2,4 C2,2.8954305 2.8954305,2 4,2 Z" />
                        </svg>
                    </a>
                    <?php foreach ($genres as $libelle => $valeur): ?>
                        <li>
                            <a href="<?= $prefixe ?>genre.php?genre=<?= urlencode($valeur) ?>"
                                class="header-cat"><?= htmlspecialchars($libelle) ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </div>

    </header>