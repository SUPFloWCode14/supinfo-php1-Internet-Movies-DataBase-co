<?php
require_once __DIR__ . '/../includes/session.php';

if (isset($_SESSION['user'])) {

    header('Location: ../index.php');
    exit;
}

include_once "../includes/header.php";
?>

<main class="connexion-main">

    <h1>Connexion</h1>

    <?php if (isset($_SESSION['message'])): ?>
        <p class="connexion-message" role="alert">
            <?= htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8'); ?>
        </p>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <form action="../controller/auth.php" method="post">
        <?= csrfField() ?>
        <div class="connexion-form-input">
            <label for="identifiant_user">Identifiant de connexion</label>
            <input type="email" id="identifiant_user" name="email" placeholder=" " required>
        </div>
        <div class="connexion-form-input">
            <label for="motdepasse_user">Mot de passe</label>
            <input type="password" id="motdepasse_user" name="mot_de_passe" placeholder=" " required>
        </div>

        <button class="compte-bouton-bleu">Se connecter</button>

    </form>

    <div class="connexion-buttons">
        <a href="inscription.php">
            <button class="compte-bouton-blanc">Créer un compte</button>
        </a>
    </div>


</main>

<?php
include_once "../includes/footer.php";
?>