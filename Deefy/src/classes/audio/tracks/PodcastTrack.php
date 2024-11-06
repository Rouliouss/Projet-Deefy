<?php
namespace iutnc\deefy\audio\tracks;

class PodcastTrack extends AudioTrack {
    private string $auteur;
    private \DateTime $date;
    private string $genre;

    public function __construct(string $titre, string $nom_du_fichier, int $duree, string $auteur, \DateTime $date, string $genre) {
        parent::__construct($titre, $nom_du_fichier, $duree);
        $this->auteur = $auteur;
        $this->date = $date;
        $this->genre = $genre;
    }

    public function getTitre(): string {
        return $this->titre;
    }

    public function getAuteur(): string {
        return $this->auteur;
    }

    public function getDate(): \DateTime {
        return $this->date;
    }

    public function getGenre(): string {
        return $this->genre;
    }
}
