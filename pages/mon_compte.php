<?php
require_once '../includes/session.php';

if (!isset($_SESSION['user'])) {
    $_SESSION['message'] = "Pas d'utilisateur connecté";
    header('Location: ../pages/connexion.php');
    exit;
}

include_once "../includes/header.php";

?>

<main>
    <h1>Mon compte</h1>

    <div style="font-size: 1.5rem; font-weight: 700; line-height: 1.3;"><?= htmlspecialchars($_SESSION['user']['pseudo']) ?></div>

    <a class="espace-client-liens" href="<?= $prefixe ?>mes_achats.php">Mes achats</a>

    <section class="mon-compte-section">

        <div class="mon-compte-panneau">
            <?php if (isset($_SESSION['message'])): ?>
                <p class="connexion-message" role="alert">
                    <?= htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8'); ?>
                </p>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>

            <h2>Changement de mot de passe</h2>
            <form action="../controller/mot_de_passe.php" method="post">
                <?= csrfField() ?>
                <div class="connexion-form-input">
                    <label for="ancien_mot_de_passe">Ancien mot de passe</label>
                    <input type="password" id="ancien_mot_de_passe" name="ancien_mot_de_passe" autocomplete="current-password" required>
                </div>

                <div class="connexion-form-input">
                    <label for="nouveau_mot_de_passe">Nouveau mot de passe</label>
                    <input type="password" id="nouveau_mot_de_passe" name="nouveau_mot_de_passe" autocomplete="new-password" required>
                </div>

                <div class="connexion-form-input">
                    <label for="confirmation_mot_de_passe">Confirmer le nouveau mot de passe</label>
                    <input type="password" id="confirmation_mot_de_passe" name="confirmation_mot_de_passe" autocomplete="new-password" required>
                </div>

                <button class="compte-bouton-bleu" type="submit">Changer le mot de passe</button>
            </form>
        </div>
    </section>





</main>

<?php
include_once "../includes/footer.php";
?>