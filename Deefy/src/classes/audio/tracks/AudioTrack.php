<?php
namespace iutnc\deefy\audio\tracks;

class AudioTrack {
    protected string $titre;
    protected string $nom_du_fichier;
    protected int $duree;

    public function __construct(string $titre, string $nom_du_fichier, int $duree) {
        $this->titre = $titre;
        $this->nom_du_fichier = $nom_du_fichier;
        $this->duree = $duree;
    }

    public function getTitre(): string {
        return $this->titre;
    }

    public function getNomDuFichier(): string {
        return $this->nom_du_fichier;
    }

    public function getDuree(): int {
        return $this->duree;
    }
}
