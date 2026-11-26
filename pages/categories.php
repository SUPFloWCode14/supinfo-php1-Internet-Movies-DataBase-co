<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

include_once '../includes/header.php';
?>

<main>

    <h1>Choisissez un genre à afficher</h1>
    <section class="categories-section">

        <nav>
            <ul class="categories-liste">
                <?php foreach ($genres as $libelle => $valeur): ?>
                    <li class="compte-bouton-blanc">
                        <a href="<?= $prefixe ?>genre.php?genre=<?= urlencode($valeur) ?>"
                            class="categories_liens"><?= htmlspecialchars($libelle) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>


    </section>
</main>

<?php include_once '../includes/footer.php'; ?>