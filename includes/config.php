<?php
const PRIX_FILM = 7.99;

function prixFilm($note)
{
    if ($note === null || $note === '') {
        return PRIX_FILM;
    }

    $note = (float) $note;

    if ($note >= 8.5) {
        return 9.99;
    } elseif ($note >= 7.5) {
        return 7.99;
    } elseif ($note >= 6) {
        return 5.99;
    }

    return 3.99;
}

function formaterPrix($montant)
{
    return number_format($montant, 2, ',', ' ') . ' €';
}

$genres = [
    'Drame'           => 'Drama',
    'Action'          => 'Action',
    'Science-fiction' => 'Sci-fi',
    'Thriller'        => 'Thriller',
    'Animation'       => 'Animation',
];

