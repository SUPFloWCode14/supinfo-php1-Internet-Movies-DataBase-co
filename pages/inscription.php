<?php
require_once __DIR__ . '/../includes/session.php';

if (isset($_SESSION['user'])) {

    header('Location: ../index.php');
    exit;
}

include_once "../includes/header.php";
?>

<main class="connexion-main">

    <h1>Inscription</h1>

    <?php if (isset($_SESSION['message'])): ?>
        <p class="connexion-message" role="alert">
            <?= htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8'); ?>
        </p>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <form action="../controller/inscription.php" method="post">
        <?= csrfField() ?>
        <div class="connexion-form-input">
            <label for="pseudo">Pseudo</label>
            <input type="text" id="pseudo" name="pseudo" placeholder=" " required>
        </div>
        <div class="connexion-form-input">
            <label for="email">Identifiant de connexion</label>
            <input type="email" id="email" name="email" placeholder=" " required>
        </div>
        <div class="connexion-form-input">
            <label for="motdepasse_user">Mot de passe</label>
            <input type="password" id="motdepasse_user" name="mot_de_passe" placeholder=" " required autocomplete="new-password">
        </div>
        <div class="connexion-form-input">
            <label for="motdepasse_confirmation">Confirmation du mot de passe</label>
            <input type="password" id="motdepasse_confirmation" name="mot_de_passe_confirmation" placeholder=" " required autocomplete="new-password">
        </div>

        <button type="submit" class="compte-bouton-bleu">Créer un compte</button>

        <a href="<?= $prefixe ?>connexion.php">Déjà un compte ?</a>

    </form>



</main>

<?php
include_once "../includes/footer.php";
?>