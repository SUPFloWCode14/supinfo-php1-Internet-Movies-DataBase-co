<?php
include_once "../includes/header.php";
require_once '../includes/db.php';

require_once '../includes/functions.php';
?>

<main>

    <section class="search-section">

        <h1>Rechercher un film</h1>
        <form class="zone-recherche" action="search.php" method="get">
            <?= csrfField() ?>
            <div class="connexion-form-input">
                <label for="rechercher"></label>
                <input type="search" id="rechercher" name="q" placeholder="Rechercher un film...">
            </div>
            <button class="compte-bouton-bleu" type="submit">Rechercher</button>
        </form>

        <div class="search-resultats">

            <?php
            $pdo = getDbConnection();
            $terme = trim($_GET['q'] ?? '');

            $films = [];

            if ($terme !== '') {
                $films = rechercherFilms($pdo, $terme);
            }
            ?>

            <?php foreach ($films as $film): ?>
                <?php include '../includes/film_card.php'; ?>
            <?php endforeach; ?>

        </div>
    </section>

</main>

<?php
include_once "../includes/footer.php";
?>