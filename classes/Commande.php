<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/config.php';

class Commande
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = getDbConnection();
    }

    public function possede($idUtilisateur, $imdbId)
    {
        $stmt = $this->pdo->prepare(
            "SELECT COUNT(*)
         FROM achats a
         JOIN commandes c ON c.id = a.id_commande
         WHERE c.id_utilisateur = :id AND a.imdb_id = :film"
        );
        $stmt->execute([':id' => $idUtilisateur, ':film' => $imdbId]);

        return (int) $stmt->fetchColumn() > 0;
    }

    public function valider($idUtilisateur)
    {
        // 1. Lire le contenu du panier (sur la connexion de cette classe)
        $stmt = $this->pdo->prepare(
            "SELECT f.imdb_id, f.note_imdb
            FROM panier p
            JOIN films f ON f.imdb_id = p.imdb_id
            WHERE p.id_utilisateur = :id"
        );
        $stmt->execute([':id' => $idUtilisateur]);
        $films = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 2. Panier vide : rien à faire
        if (empty($films)) {
            return false;
        }

        // 3. Refuser si un film est déjà possédé
        foreach ($films as $film) {
            if ($this->possede($idUtilisateur, $film['imdb_id'])) {
                throw new RuntimeException('Vous possédez déjà un des films de votre panier.');
            }
        }

        // 4. Calculer le total
        $total = 0;
        foreach ($films as $film) {
            $total += prixFilm($film['note_imdb']);
        }
        $total = round($total, 2);

        // 5. Tout enregistrer d'un bloc
        $this->pdo->beginTransaction();
        try {
            // a) créer la commande
            $stmt = $this->pdo->prepare("INSERT INTO commandes (id_utilisateur, total) VALUES (:id, :total)");
            $stmt->execute([':id' => $idUtilisateur, ':total' => $total]);
            $idCommande = (int) $this->pdo->lastInsertId();

            // b) une ligne d'achat par film
            $stmt = $this->pdo->prepare("INSERT INTO achats (id_commande, imdb_id, prix_paye) VALUES (:commande, :film, :prix)");
            foreach ($films as $film) {
                $stmt->execute([':commande' => $idCommande, ':film' => $film['imdb_id'], ':prix' => prixFilm($film['note_imdb'])]);
            }

            // c) vider le panier (même connexion, donc dans la transaction)
            $stmt = $this->pdo->prepare("DELETE FROM panier WHERE id_utilisateur = :id");
            $stmt->execute([':id' => $idUtilisateur]);

            $this->pdo->commit();
            return $idCommande;
        } catch (Throwable $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            throw $e;
        }
    }

    public function getCommandes($idUtilisateur)
    {
        $stmt = $this->pdo->prepare(
            "SELECT id, date_commande, total
            FROM commandes
            WHERE id_utilisateur = :id
            ORDER BY date_commande DESC, id DESC"
        );
        $stmt->execute([':id' => $idUtilisateur]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAchats($idUtilisateur)
    {
        $stmt = $this->pdo->prepare(
            "SELECT f.imdb_id, f.titre, f.annee, f.realisateur, f.affiche_url, a.prix_paye, c.date_commande
            FROM commandes c
            JOIN achats a ON c.id = a.id_commande
            JOIN films f ON f.imdb_id = a.imdb_id
            WHERE c.id_utilisateur = :id
            ORDER BY c.date_commande DESC, f.titre ASC"
        );
        $stmt->execute([':id' => $idUtilisateur]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
