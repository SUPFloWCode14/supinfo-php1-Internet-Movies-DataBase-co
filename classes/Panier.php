<?php
require_once __DIR__ . '/../includes/db.php';

class Panier
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = getDbConnection();
    }

    public function ajouter($idUtilisateur, $imdbId)
    {
        $stmt = $this->pdo->prepare("INSERT INTO panier (id_utilisateur, imdb_id) VALUES (:idUtilisateur, :imdb)");

        try {
            $stmt->execute([':idUtilisateur' => $idUtilisateur, ':imdb' => $imdbId]);
            return true;
        } catch (PDOException $e) {
            if ($e->errorInfo[1] === 1062) {
                return false;
            }
            throw $e;
        }
    }

    public function retirer($idUtilisateur, $imdbId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM panier WHERE id_utilisateur = :id AND imdb_id = :film");
        $stmt->execute([':id' => $idUtilisateur, ':film' => $imdbId]);

        return $stmt->rowCount() > 0;
    }

    public function contient($idUtilisateur, $imdbId)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM panier WHERE id_utilisateur = :id AND imdb_id = :film");
        $stmt->execute([':id' => $idUtilisateur, ':film' => $imdbId]);

        return (int) $stmt->fetchColumn() > 0;
    }

    public function compter($idUtilisateur)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM panier WHERE id_utilisateur = :id");
        $stmt->execute([':id' => $idUtilisateur]);

        return (int) $stmt->fetchColumn();
    }

    public function getFilms($idUtilisateur)
    {
        $stmt = $this->pdo->prepare(
            "SELECT f.imdb_id, f.titre, f.annee, f.realisateur, f.note_imdb, f.affiche_url, p.date_ajout
            FROM panier p
            JOIN films f ON f.imdb_id = p.imdb_id
            WHERE p.id_utilisateur = :id
            ORDER BY p.date_ajout DESC, f.titre ASC"
        );
        $stmt->execute([':id' => $idUtilisateur]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function vider($idUtilisateur)
    {
        $stmt = $this->pdo->prepare("DELETE FROM panier WHERE id_utilisateur = :id");
        $stmt->execute([':id' => $idUtilisateur]);
    }
}
