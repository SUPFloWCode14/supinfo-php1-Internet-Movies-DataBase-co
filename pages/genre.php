<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

$genre = trim($_GET['genre'] ?? '');

$films = [];
if ($genre !== '') {
    $films = filmsParGenre($pdo, $genre);
}

$libelleGenre = array_search($genre, $genres, true);
$titreGenre = ($libelleGenre !== false) ? $libelleGenre : $genre;

include_once '../includes/header.php';
?>

<main>

    <section class="genre-section">
        <?php if ($genre === ''): ?>
            <h1>Choisissez un genre dans le menu</h1>

        <?php else: ?>
            <h1><?= htmlspecialchars($titreGenre) ?></h1>

            <?php if (empty($films)): ?>
                <p>Aucun film pour ce genre.</p>
            <?php else: ?>
                <div class="genre-films">
                    <?php foreach ($films as $film): ?>
                        <?php include __DIR__ . '/../includes/film_card.php'; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </section>
</main>

<?php include_once '../includes/footer.php'; ?>