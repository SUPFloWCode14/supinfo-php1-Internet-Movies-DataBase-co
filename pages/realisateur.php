<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
include_once '../includes/header.php';

$real = trim($_GET['real'] ?? '');

$films = [];
if ($real !== '') {
    $films = filmsParRealisateur($pdo, $real);
}
?>

<main>
    <section class="genre-section">

        <?php if ($real === ''): ?>
            <h1>Aucun réalisateur sélectionné.</h1>

        <?php else: ?>
            <h1><?= htmlspecialchars($real) ?></h1>

            <?php if (empty($films)): ?>
                <p>Aucun film pour ce réalisateur.</p>
            <?php else: ?>
                <div class="real-films">
                    <?php foreach ($films as $film): ?>
                        <?php include __DIR__ . '/../includes/film_card.php'; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </section>

</main>

<?php include_once '../includes/footer.php'; ?>