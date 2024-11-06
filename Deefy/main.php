<?php
require_once 'vendor/autoload.php';

// Utilisation des namespaces
use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\render\AlbumTrackRenderer;
use iutnc\deefy\render\AudioListRenderer;
use iutnc\deefy\render\PodcastTrackRenderer;
use iutnc\deefy\audio\tracks\AlbumTrack;
use iutnc\deefy\audio\tracks\PodcastTrack;


// Création d'un objet AlbumTrack
$joe1 = new AlbumTrack("hello", "holle", "president", 2);
$joe1->setArtiste("joebiden");
$joe1->setAnnee(2022);
$joe1->setGenre("ancien");
$joe1->setDuree(287);

// Création d'un objet PodcastTrack
$trump1 = new PodcastTrack("get down mr president", "song/Kirby_screaming_and_falling.mp3");
$trump1->setDate("27/08/2024");
$trump1->setAuteur("Donald");
$trump1->setGenre("police");
$trump1->setDuree(788);

// Rendu de l'AlbumTrack
$r = new AlbumTrackRenderer($joe1);
echo $r->render(1); // Mode compact
echo $r->render(2); // Mode long

// Rendu du PodcastTrack
$r2 = new PodcastTrackRenderer($trump1);
echo $r2->render(2);

$piste1 = new PodcastTrack("Titre 1", "fichier1.mp3");
$piste2 = new PodcastTrack("Titre 2", "fichier2.mp3");

$playlist = new Playlist("Ma Playlist", [$piste1, $piste2]);

// Création du renderer
$renderer = new AudioListRenderer($playlist);

// Affichage de la liste audio
echo $renderer->render(0);



?>
