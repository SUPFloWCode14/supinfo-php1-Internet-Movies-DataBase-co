<?php

require_once __DIR__ . '/db.php';

function getFilms(PDO $pdo): array
{
    $requete = $pdo->query(
        'SELECT imdb_id, titre, annee, realisateur, genres, affiche_url, note_imdb
        FROM films
        '
    );
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}


function getMeilleursFilms(PDO $pdo, int $nombre = 5): array
{
    $requete = $pdo->prepare(
        'SELECT f.imdb_id, f.titre, f.annee, f.realisateur, f.genres, f.affiche_url, f.metascore, f.note_imdb
         FROM films f
         ORDER BY f.metascore DESC, f.titre ASC
         LIMIT :nombre'
    );
    $requete->bindValue(':nombre', $nombre, PDO::PARAM_INT);
    $requete->execute();

    return $requete->fetchAll(PDO::FETCH_ASSOC);
}


function getFilmDetails(PDO $pdo, string $id)
{
    $requete = $pdo->prepare('SELECT * FROM films WHERE imdb_id = :id');
    $requete->execute([':id' => $id]);
    return $requete->fetch(PDO::FETCH_ASSOC);
}


function rechercherFilms(PDO $pdo, string $terme): array
{
    $requete = $pdo->prepare(
        'SELECT imdb_id, titre, annee, realisateur, genres, affiche_url, note_imdb
         FROM films
         WHERE titre LIKE :terme1
         OR realisateur LIKE :terme2
         ORDER BY titre ASC
         LIMIT 100'
    );
    $requete->execute([
        ':terme1' => '%' . $terme . '%',
        ':terme2' => '%' . $terme . '%',
    ]);

    return $requete->fetchAll(PDO::FETCH_ASSOC);
}


function filmsParGenre(PDO $pdo, string $genre): array
{
    $requete = $pdo->prepare(
        'SELECT imdb_id, titre, annee, realisateur, genres, affiche_url, note_imdb
         FROM films
         WHERE genres LIKE :genre
         ORDER BY titre ASC'
    );
    $requete->execute([':genre' => '%' . $genre . '%']);

    return $requete->fetchAll(PDO::FETCH_ASSOC);
}


function filmsParRealisateur(PDO $pdo, string $real): array
{
    $requete = $pdo->prepare(
        'SELECT imdb_id, titre, annee, realisateur, genres, affiche_url, note_imdb
         FROM films
         WHERE realisateur LIKE :real
         ORDER BY titre ASC'
    );
    $requete->execute([':real' => '%' . $real . '%']);

    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

function separerRealisateurs(string $realisateurs): array
{
    return array_values(array_filter(array_map('trim', explode(',', $realisateurs))));
}

function getUtilisateurParEmail(PDO $pdo, string $email)
{
    $requete = $pdo->prepare('SELECT * FROM utilisateurs WHERE email = :email');
    $requete->execute([':email' => $email]);
    return $requete->fetch(PDO::FETCH_ASSOC);
}
