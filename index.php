<?php
include_once "./includes/header.php";
require_once './includes/db.php';
require_once './includes/functions.php';
?>

<main>
    <section class="index-section">

        <div class="index-hero">

            <h1>Internet Movies DataBase &amp; Co</h1>
            <p>Découvrez notre catalogue de films, des grands classiques aux dernières sorties. Consultez les fiches détaillées, achetez vos films en quelques clics et retrouvez-les à tout moment dans votre espace client.</p>
            <p>Recherchez un film par titre ou par réalisateur, parcourez nos genres, ou découvrez notre sélection ci-dessous. Créez un compte gratuitement pour remplir votre panier.</p>

            <form class="zone-recherche" action="<?= $prefixe ?>search.php" method="get">
                <div class="connexion-form-input">
                    <label for="rechercher"></label>
                    <input type="search" id="rechercher" name="q" placeholder="Rechercher un film ou un réalisateur..." aria-label="Rechercher un film ou un réalisateur" maxlength="100" required>
                </div>
                <button class="compte-bouton-bleu" type="submit">Rechercher</button>
            </form>

            <h2>Les meilleurs films disponibles</h2>

        </div>
        <div class="index-films">

            <?php
            $films = getMeilleursFilms($pdo);
            ?>

            <?php foreach ($films as $film): ?>
                <?php include './includes/film_card.php'; ?>
            <?php endforeach; ?>
        </div>

    </section>
</main>

<?php
include_once "./includes/footer.php";
?>