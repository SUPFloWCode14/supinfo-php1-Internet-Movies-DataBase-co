# Internet Movies DataBase & Co

Site web de vente de films développé en PHP pour la société fictive « Internet Movies DataBase & Co ». Les utilisateurs peuvent consulter un catalogue de films, les ajouter à leur panier, les acheter et retrouver leurs achats dans leur espace client.

Projet réalisé dans le cadre du module **pPHPD1 – PHP Developer** (1ère année).

---

## Installation et déploiement

### Prérequis

- [XAMPP](https://www.apachefriends.org/) (inclut PHP, Apache et MySQL)
- Un éditeur de code, par exemple [VS Code](https://code.visualstudio.com/)
- PHP accessible depuis le terminal (commande `php -v` fonctionnelle)

### Étapes

1. **Récupérer le projet**
   - Décompresser l'archive et enregistrer le dossier sur votre ordinateur.
   - Il n'est pas obligatoire de le placer dans `htdocs`.

2. **Préparer XAMPP**
   - Si un service MySQL tourne déjà sur votre PC, le désactiver pour éviter un conflit de port.
   - Ouvrir le **XAMPP Control Panel** et démarrer les services **Apache** et **MySQL** avec les boutons `Start`.

3. **Ouvrir phpMyAdmin**
   - Dans le Control Panel, cliquer sur `Admin` sur la ligne **MySQL**.

4. **Importer la base de données**
   - Dans phpMyAdmin, cliquer sur l'onglet **Importer**.
   - Cliquer sur **Choisir un fichier** et sélectionner `database/database_imdbco.sql`.
   - Cliquer sur **Importer** en bas de la page.
   - Vérifier que la base `flre_supinfo_phpd1` et ses tables ont bien été créées.

5. **Vérifier la connexion à la base**
   - Contrôler que les paramètres de connexion dans `includes/db.php` correspondent à votre installation.
   - Par défaut sous XAMPP : utilisateur `root`, sans mot de passe.

6. **Lancer le site**
   - Ouvrir le dossier du projet avec VS Code (clic droit sur le dossier, puis « Ouvrir avec Code »).
   - Ouvrir un terminal dans VS Code et lancer le serveur local :

   ```bash
   php -S localhost:8000
   ```

7. **Ouvrir le site**
   - Dans un navigateur, aller sur : <http://localhost:8000>

> **Astuce :** pour afficher tous les films du catalogue, saisir `%` dans la barre de recherche.

---

## Présentation du projet

### Fonctionnalités principales

| Page | Description |
|------|-------------|
| **Accueil** | Présentation du site, barre de recherche et les 5 films les mieux notés |
| **Recherche** | Recherche de films et de réalisateurs par nom ou mot-clé |
| **Genres** | Liste des films par genre, accessible depuis le menu |
| **Film** | Détails d'un film : synopsis, acteurs, date de sortie, réalisateur(s)… |
| **Réalisateur** | Tous les films d'un réalisateur (lien depuis la fiche film) |
| **Panier** | Films en cours d'achat, total, retrait d'un film, vidage et validation du panier |
| **Espace client** | Achats et commandes validés, changement de mot de passe |
| **Connexion / inscription** | Création de compte (pseudo, email, mot de passe) et authentification |

- Le panier et l'espace client sont réservés aux utilisateurs connectés.
- Un film ne peut être acheté qu'une seule fois par utilisateur.
- Le site est en français, les données des films (issues d'OMDB) sont en anglais.

### Technologies utilisées

- **HTML** : structure des pages
- **CSS** : mise en forme
- **PHP** (natif, sans framework) : logique du site, accès à la base, gestion des sessions
- **SQL (MySQL)** : stockage des données, accès via **PDO**
- **XAMPP** et **VS Code** : environnement de développement

### Architecture des fichiers

```
Internet Movies DataBase & co
├── index.php        → page d'accueil
├── classes/         → classes PHP : User, Panier, Commande
├── controller/      → actions (connexion, inscription, panier, validation, mot de passe…)
├── css/             → feuilles de style
├── database/        → fichier SQL de création de la base
├── includes/        → code réutilisé : config, db, session, csrf, header, footer,
│                      functions, film_card
├── pages/           → pages du site (film, recherche, panier, mes achats, mon compte…)
├── Documentation.docx
└── README.md
```

- **classes** : contiennent la logique et les requêtes SQL pour chaque grande fonctionnalité (utilisateurs, panier, commandes).
- **controller** : font le lien entre les pages et les classes, et vérifient notamment que l'utilisateur est connecté.
- **includes** : morceaux de code contenant du HTML, inclus partout où ils sont nécessaires (principe **DRY**). Par exemple, le header et le footer sont inclus sur toutes les pages, et toutes les cartes de films sont générées par `film_card.php`.

### Base de données

Tables principales :

- `films` : table centrale du site (titre, année, réalisateur, genres, synopsis, affiche, note IMDb…)
- `utilisateurs` : pseudo, email, mot de passe haché, date d'inscription
- `panier` : films en cours d'achat pour chaque utilisateur
- `commandes` : commandes validées (date, total, utilisateur)
- `achats` : une ligne par film acheté dans une commande
- `categories` : catégories (genres) de films

Les clés étrangères relient les tables entre elles et garantissent l'intégrité des données.

### Choix techniques et sécurité

Principe appliqué : *« You should never trust the data sent by users »*. Tout ce qui arrive par un formulaire ou par l'URL est vérifié avant utilisation.

- **Mots de passe** : jamais stockés en clair, hachés avec `password_hash()` et vérifiés avec `password_verify()`.
- **Injection SQL** : requêtes préparées avec PDO (paramètres `:email`, `:id`, etc.).
- **CSRF** : jeton unique par session, ajouté en champ caché dans les formulaires qui modifient des données.
- **Cookies de session** : marqués `HttpOnly` (inaccessibles depuis JavaScript) et `SameSite=Lax`.
- **Pages protégées** : le panier et l'espace client redirigent vers la page de connexion si l'utilisateur n'est pas connecté.
- **XSS** : les données affichées sont échappées avec `htmlspecialchars()`.

### Pistes d'amélioration

- Proposer un fichier téléchargeable après achat pour simuler le téléchargement du film.
- Ajouter du JavaScript pour une expérience plus fluide et interactive.

---

## Auteur

Florent Régnier – Projet pPHPD1 – PHP Developer