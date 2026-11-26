<?php
require_once __DIR__ . '/../includes/session.php';

if (!isset($_SESSION['user'])) {
    $_SESSION['message'] = 'Connectez-vous pour accéder à votre panier.';
    header('Location: connexion.php');
    exit;
}

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../classes/Panier.php';

$panier = new Panier();
$films  = $panier->getFilms($_SESSION['user']['id']);
$total = 0;

foreach ($films as $film) {
    $total += prixFilm($film['note_imdb']);
}

include_once "../includes/header.php";

?>


<main>

    <h1>Mon panier</h1>
    <div style="font-size: 1.5rem; font-weight: 700; line-height: 1.3;"><?= htmlspecialchars($_SESSION['user']['pseudo']) ?></div>

    <?php if (isset($_SESSION['message'])): ?>
        <p class="panier-message" role="alert">
            <?= htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8'); ?>
        </p>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <section class="panier-section">
        <div class="panier-total">

            <h2>Total : <?= formaterPrix($total) ?></h2>

            <form method="post" action="../controller/panier_vider.php" onsubmit="return confirm('Vider tout le panier ?');">
                <?= csrfField() ?>
                <button class="compte-bouton-blanc" type="submit">Vider le panier</button>
            </form>

            <form method="post" action="../controller/commande_valider.php">
                <?= csrfField() ?>
                <button class="compte-bouton-bleu" type="submit">Valider la commande</button>
            </form>
        </div>
        <div class="panier-detail">
            <?php if (empty($films)): ?>
                <p>Votre panier est vide</p>
                <a class="compte-bouton-blanc" href="<?= $racine ?>index.php">Découvrir nos films</a>
            <?php else: ?>
                <?php foreach ($films as $film): ?>
                    <div class="panier-produit">
                        <a href="<?= $prefixe ?>film.php?id=<?= htmlspecialchars($film['imdb_id']) ?>"><img src="<?= htmlspecialchars($film['affiche_url']) ?>" alt="Affiche de <?= htmlspecialchars($film['titre']) ?>"></a>
                        <h3><?= htmlspecialchars($film['titre']) ?></h3>
                        <p><?= formaterPrix(prixFilm($film['note_imdb'])) ?></p>
                        <form method="post" action="../controller/panier_retirer.php">
                            <?= csrfField() ?>
                            <button class="compte-bouton-blanc" type="submit" name="imdb_id" value="<?= htmlspecialchars($film['imdb_id']) ?>">Retirer</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>


</main>

<?php
include_once "../includes/footer.php";
?>