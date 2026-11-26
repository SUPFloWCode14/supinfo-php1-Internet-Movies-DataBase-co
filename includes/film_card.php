<div class="carte-film">
    <a href="<?= $prefixe ?>film.php?id=<?= htmlspecialchars($film['imdb_id']) ?>"><img src="<?= htmlspecialchars($film['affiche_url']) ?>" alt="Affiche de <?= htmlspecialchars($film['titre']) ?>"></a>

    <h3><?= htmlspecialchars($film['titre']) ?></h3>
    <div><?= htmlspecialchars($film['annee']) ?></div>
    <div>
        <?php foreach (separerRealisateurs($film['realisateur']) as $i => $nom): ?>
            <?= $i > 0 ? ', ' : '' ?><a href="<?= $prefixe ?>realisateur.php?real=<?= urlencode($nom) ?>"><?= htmlspecialchars($nom) ?></a>
        <?php endforeach; ?>
    </div>
    <div><?= formaterPrix(prixFilm($film['note_imdb'])) ?></div>

    <?php if (isset($_SESSION['user'])): ?>
        <form method="post" action="<?= $racine ?>controller/panier_ajouter.php">
            <?= csrfField() ?>
            <button class="compte-bouton-blanc" type="submit" name="imdb_id" value="<?= htmlspecialchars($film['imdb_id']) ?>">Ajouter au panier</button>
        </form>
    <?php else: ?>
        <a class="compte-bouton-bleu" href="<?= $prefixe ?>connexion.php">Se connecter pour acheter</a>
    <?php endif; ?>

    <a href="<?= $prefixe ?>film.php?id=<?= htmlspecialchars($film['imdb_id']) ?>">Plus de détails</a>
</div>