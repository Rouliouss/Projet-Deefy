<?php

namespace iutnc\deefy\audio\tracks;

class AlbumTrack extends AudioTrack {
    private string $artiste;
    private string $album;
    private int $annee;
    private int $numeroDePiste;

    public function __construct(string $titre, string $nomDuFichier, string $album, int $numeroDePiste, float $duree) {
        parent::__construct($titre, $nomDuFichier, "album", $duree);
        $this->album = $album;
        $this->numeroDePiste = $numeroDePiste;
    }

    public function __get(string $at): mixed {
        if (property_exists($this, $at)) {
            return $this->$at;
        }
        throw new \Exception("Invalid property: $at");
    }

    public function getArtiste(): string {
        return $this->artiste;
    }

    public function getAlbum(): string {
        return $this->album;
    }

    public function getAnnee(): int {
        return $this->annee;
    }

    public function getNumeroDePiste(): int {
        return $this->numeroDePiste;
    }

    public function setArtiste(string $s) {
        $this->artiste = $s;
    }

    public function setAnnee(int $d) {
        if ($d > 0) $this->annee = $d;
    }
}
