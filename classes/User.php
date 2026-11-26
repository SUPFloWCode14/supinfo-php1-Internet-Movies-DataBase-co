<?php
require_once __DIR__ . '/../includes/db.php';

class User
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = getDbConnection();
    }

    public function getAll()
    {
        $stmt = $this->pdo->prepare("SELECT id, pseudo, email FROM utilisateurs ORDER BY id ASC");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByPseudo($pseudo)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE pseudo = :pseudo");
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($pseudo, $email, $password)
    {
        try {
            $sql = "INSERT INTO utilisateurs (pseudo, email, mot_de_passe) VALUES (:pseudo, :email, :password)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':pseudo', $pseudo);
            $stmt->bindParam(':email', $email);

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bindParam(':password', $hashedPassword);

            return $stmt->execute();
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                return false;
            }
            throw $e;
        }
    }

    public function update($id, $pseudo, $email, $password)
    {
        try {
            if ($password === '') {
                $stmt = $this->pdo->prepare("UPDATE utilisateurs SET pseudo = :pseudo, email = :email WHERE id = :id");
            } else {
                $stmt = $this->pdo->prepare("UPDATE utilisateurs SET pseudo = :pseudo, email = :email, mot_de_passe = :password WHERE id = :id");
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt->bindParam(':password', $hashedPassword);
            }

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':pseudo', $pseudo);
            $stmt->bindParam(':email', $email);

            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function updatePassword($id, $nouveauMotDePasse)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE utilisateurs SET mot_de_passe = :password WHERE id = :id");
            $hashedPassword = password_hash($nouveauMotDePasse, PASSWORD_DEFAULT);
            $stmt->bindParam(':password', $hashedPassword);

            $stmt->bindParam(':id', $id);

            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }


    public function deleteById($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM utilisateurs WHERE id = :id");
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }
}
