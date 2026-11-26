<?php
require_once '../includes/session.php';

if (!isset($_SESSION['user'])) {
    $_SESSION['message'] = "Pas d'utilisateur connecté";
    header('Location: ../pages/connexion.php');
    exit;
}

include_once "../includes/header.php";

?>

<main class="espace-client-main">

    <h1>Espace Client</h1>
    <div class="espace-client-menu">

        <h2><?= htmlspecialchars($_SESSION['user']['pseudo']) ?></h2>

        <?php if (isset($_SESSION['message'])): ?>
            <p class="connexion-message" role="alert">
                <?= htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8'); ?>
            </p>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <a class="espace-client-liens" href="<?= $prefixe ?>mon_compte.php">Mon compte</a>
        <a class="espace-client-liens" href="<?= $prefixe ?>mes_achats.php">Mes achats</a>
    </div>

</main>

<?php
include_once "../includes/footer.php";
?>