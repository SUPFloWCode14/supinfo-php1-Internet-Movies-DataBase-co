<?php if (isset($_SESSION['user'])): ?>
    <?php
    require_once __DIR__ . '/../classes/Panier.php';
    $nbPanier = (new Panier())->compter($_SESSION['user']['id']);
    ?>

    <a id="panier-widget" href="<?= $prefixe ?>panier.php">
        <!-- License: MIT. Made by artcoholic: https://github.com/artcoholic/akar-icons -->
        <svg width="50px" height="50px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M2.31063 11.2425C2.15285 10.6114 2.63021 10 3.28078 10H20.7192C21.3698 10 21.8472 10.6114 21.6894 11.2425L19.8787 18.4851C19.6561 19.3754 18.8562 20 17.9384 20H6.06155C5.14382 20 4.34385 19.3754 4.12127 18.4851L2.31063 11.2425Z" stroke="#000000" stroke-width="2" stroke-linejoin="round" />
            <path d="M9 14V16" stroke="#000000" stroke-width="2" stroke-linecap="round" />
            <path d="M15 14V16" stroke="#000000" stroke-width="2" stroke-linecap="round" />
            <path d="M6 10L10 4" stroke="#000000" stroke-width="2" stroke-linecap="round" />
            <path d="M18 10L14 4" stroke="#000000" stroke-width="2" stroke-linecap="round" />
        </svg>
        <span id="panier-count"><?= $nbPanier ?></span>
    </a>

<?php else: ?>
    <a id="panier-widget" href="<?= $prefixe ?>connexion.php">
        <!-- License: MIT. Made by artcoholic: https://github.com/artcoholic/akar-icons -->
        <svg width="50px" height="50px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M2.31063 11.2425C2.15285 10.6114 2.63021 10 3.28078 10H20.7192C21.3698 10 21.8472 10.6114 21.6894 11.2425L19.8787 18.4851C19.6561 19.3754 18.8562 20 17.9384 20H6.06155C5.14382 20 4.34385 19.3754 4.12127 18.4851L2.31063 11.2425Z" stroke="#000000" stroke-width="2" stroke-linejoin="round" />
            <path d="M9 14V16" stroke="#000000" stroke-width="2" stroke-linecap="round" />
            <path d="M15 14V16" stroke="#000000" stroke-width="2" stroke-linecap="round" />
            <path d="M6 10L10 4" stroke="#000000" stroke-width="2" stroke-linecap="round" />
            <path d="M18 10L14 4" stroke="#000000" stroke-width="2" stroke-linecap="round" />
        </svg>
    </a>


<?php endif; ?>

<footer>
    <nav aria-label="Pied de page">
        <a style="padding: 20px;" href="<?= $racine ?>index.php">
            <!-- License: MIT. Made by vmware: https://github.com/vmware/clarity-assets -->
            <svg fill="#e9eef5" width="48" height="48" viewBox="0 0 36 36" style="filter: drop-shadow(0 0 6px #ff6a00) drop-shadow(0 0 12px #ff9b54);" version="1.1" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <title>Accueil</title>
                <path class="clr-i-outline clr-i-outline-path-1" d="M33.71,17.29l-15-15a1,1,0,0,0-1.41,0l-15,15a1,1,0,0,0,1.41,1.41L18,4.41,32.29,18.71a1,1,0,0,0,1.41-1.41Z"></path>
                <path class="clr-i-outline clr-i-outline-path-2" d="M28,32h-5V22H13V32H8V18L6,20V32a2,2,0,0,0,2,2h7V24h6V34h7a2,2,0,0,0,2-2V19.76l-2-2Z"></path>
                <rect x="0" y="0" width="36" height="36" fill-opacity="0" />
            </svg>
        </a>
        <ul class="footer-categories">
            <h2>Catégories</h2>
            <hr>
            <li><a href="<?= $prefixe ?>genre.php?genre=Action">Action</a></li>
            <li><a href="<?= $prefixe ?>genre.php?genre=Drama">Drame</a></li>
            <li><a href="<?= $prefixe ?>genre.php?genre=Sci-fi">Science-fiction</a></li>
            <li><a href="<?= $prefixe ?>genre.php?genre=Thriller">Thriller</a></li>
            <li><a href="<?= $prefixe ?>genre.php?genre=Animation">Animation</a></li>
        </ul>
        <ul class="footer-compte">
            <h2>Espace client</h2>
            <hr>
            <li><a href="<?= $prefixe ?>connexion.php">Connexion</a></li>
            <li><a href="<?= $prefixe ?>espace_client.php">Espace client</a></li>
            <li><a href="<?= $prefixe ?>mon_compte.php">Mon compte</a></li>
            <li><a href="<?= $prefixe ?>mes_achats.php">Mes achats</a></li>
        </ul>
        <ul class="footer-reseaux">
            <h2>Nous retrouver</h2>
            <hr>
            <!-- <li> -->
            <a href="https://www.instagram.com/">
                <!-- License: MIT. Made by michaelampr: https://github.com/michaelampr/jam -->
                <svg fill="#e9eef5" width="48" height="48" viewBox="-2 -2 24 24" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMinYMin" class="jam jam-instagram">
                    <path d='M14.017 0h-8.07A5.954 5.954 0 0 0 0 5.948v8.07a5.954 5.954 0 0 0 5.948 5.947h8.07a5.954 5.954 0 0 0 5.947-5.948v-8.07A5.954 5.954 0 0 0 14.017 0zm3.94 14.017a3.94 3.94 0 0 1-3.94 3.94h-8.07a3.94 3.94 0 0 1-3.939-3.94v-8.07a3.94 3.94 0 0 1 3.94-3.939h8.07a3.94 3.94 0 0 1 3.939 3.94v8.07z' />
                    <path d='M9.982 4.819A5.17 5.17 0 0 0 4.82 9.982a5.17 5.17 0 0 0 5.163 5.164 5.17 5.17 0 0 0 5.164-5.164A5.17 5.17 0 0 0 9.982 4.82zm0 8.319a3.155 3.155 0 1 1 0-6.31 3.155 3.155 0 0 1 0 6.31z' />
                    <circle cx='15.156' cy='4.858' r='1.237' />
                </svg>
            </a>
            <!-- </li> -->
            <!-- <li> -->
            <a href="https://fr-fr.facebook.com/">
                <!-- License: Apache. Made by Iconscout: https://github.com/Iconscout/unicons -->
                <svg fill="#e9eef5" width="48" height="48" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1">
                    <path d="M20.9,2H3.1A1.1,1.1,0,0,0,2,3.1V20.9A1.1,1.1,0,0,0,3.1,22h9.58V14.25h-2.6v-3h2.6V9a3.64,3.64,0,0,1,3.88-4,20.26,20.26,0,0,1,2.33.12v2.7H17.3c-1.26,0-1.5.6-1.5,1.47v1.93h3l-.39,3H15.8V22h5.1A1.1,1.1,0,0,0,22,20.9V3.1A1.1,1.1,0,0,0,20.9,2Z" />
                </svg>
            </a>
            <!-- </li> -->
        </ul>
    </nav>
    <p style="text-align: center;">&copy; <?= date('Y') ?> Internet Movies Database &amp; Co. Tous droits réservés.</p>
</footer>

</body>

</html>