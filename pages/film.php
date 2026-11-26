<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

$id = $_GET['id'] ?? '';

$film = (is_string($id) && preg_match('/^tt\d{7,10}$/', $id))
    ? getFilmDetails($pdo, $id)
    : false;

if ($film === false) {
    http_response_code(404);
}

include_once '../includes/header.php';
?>

<main>
    <section class="film-section">
        <?php if ($film === false): ?>
            <h1>Film introuvable</h1>
            <p>Ce film n'existe pas ou n'est plus disponible.</p>
            <p><a href="<?= $racine ?>index.php">Retour à l'accueil</a></p>
        <?php else: ?>
            <div class="film-details">

                <h1><?= htmlspecialchars($film['titre']) ?></h1>
                <div class="film-div">
                    <img src="<?= htmlspecialchars($film['affiche_url']) ?>" alt="Affiche">
                </div>

                <div class="film-div">
                    <p><span style="display: inline-block; font-weight: bold; padding: 5px 0 ;">Année : </span><br><?= htmlspecialchars($film['annee']) ?></p>
                    <p><span style="display: inline-block; font-weight: bold; padding: 5px 0 ;">Réalisateur : </span><br>
                        <?php foreach (separerRealisateurs($film['realisateur']) as $i => $nom): ?>
                            <?= $i > 0 ? ', ' : '' ?><a href="<?= $prefixe ?>realisateur.php?real=<?= urlencode($nom) ?>"><?= htmlspecialchars($nom) ?></a>
                        <?php endforeach; ?>
                    </p>
                    <p><span style="display: inline-block; font-weight: bold; padding: 5px 0 ;">Acteurs : </span><br><?= htmlspecialchars($film['acteurs']) ?></p>
                    <p><span style="display: inline-block; font-weight: bold; padding: 5px 0 ;">Genres : </span><br><?= htmlspecialchars($film['genres']) ?></p>
                    <p><span style="display: inline-block; font-weight: bold; padding: 5px 0 ;">Synopsis : </span><br><?= htmlspecialchars($film['synopsis']) ?></p>

                    <div class="film-prix-panier">
                        <p><?= formaterPrix(prixFilm($film['note_imdb'])) ?></p>

                        <?php if (isset($_SESSION['user'])): ?>
                            <form method="post" action="<?= $racine ?>controller/panier_ajouter.php">
                                <?= csrfField() ?>
                                <button class="compte-bouton-blanc" type="submit" name="imdb_id" value="<?= htmlspecialchars($film['imdb_id']) ?>">Ajouter au panier</button>
                            </form>
                        <?php else: ?>
                            <a class="compte-bouton-bleu" href="<?= $prefixe ?>connexion.php">Se connecter pour acheter</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </section>
</main>

<?php
include_once "../includes/footer.php";
?>