<?php
require_once __DIR__ . '/../includes/session.php';

if (!isset($_SESSION['user'])) {
    $_SESSION['message'] = 'Connectez-vous pour accéder à vos achats.';
    header('Location: connexion.php');
    exit;
}

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../classes/Commande.php';

$order  = new Commande();
$achats    = $order->getAchats($_SESSION['user']['id']);
$commandes = $order->getCommandes($_SESSION['user']['id']);

include_once __DIR__ . "/../includes/header.php";

?>

<main>

    <h1>Mes achats</h1>
    <div style="font-size: 1.5rem; font-weight: 700; line-height: 1.3;"><?= htmlspecialchars($_SESSION['user']['pseudo']) ?></div>
    <a class="espace-client-liens" href="<?= $prefixe ?>mon_compte.php">Mon compte</a>

    <?php if (isset($_SESSION['message'])): ?>
        <p class="panier-message" role="alert">
            <?= htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8'); ?>
        </p>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>


    <section class="mes-achats-section">
        <div class="mes-achats-commandes">

            <?php if (empty($commandes)): ?>
                <p>Vous n'avez pas encore passé de commande.</p>
            <?php else: ?>

                <table>
                    <caption>
                        <h3>Liste des commandes</h3>
                    </caption>
                    <thead>
                        <tr>
                            <th>Numéro de commmande</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($commandes as $commande): ?>
                            <tr>
                                <td><?= htmlspecialchars($commande['id']) ?></td>
                                <td><?= formaterPrix((float) $commande['total']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

        </div>
        <div class="mes-achats-liste">
            <?php if (empty($achats)): ?>
                <p>Vous n'avez pas encore acheté de film.</p>
                <a href="<?= $racine ?>index.php">Découvrir nos films</a>
            <?php endif; ?>
            <h3>Liste des achats</h3>

            <?php foreach ($achats as $achat): ?>
                <div class="mes-achats-achats">
                    <a href="<?= $prefixe ?>film.php?id=<?= htmlspecialchars($achat['imdb_id']) ?>"><img src="<?= htmlspecialchars($achat['affiche_url']) ?>" alt="Affiche de <?= htmlspecialchars($achat['titre']) ?>"></a>
                    <h3><?= htmlspecialchars($achat['titre']) ?></h3>
                    <p><?= formaterPrix((float) $achat['prix_paye']) ?></p>
                    <p><?= htmlspecialchars($achat['date_commande']) ?></p>
                </div>
            <?php endforeach; ?>

        </div>
    </section>


</main>

<?php
include_once __DIR__ . "/../includes/footer.php";
?>