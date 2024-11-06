<?php
namespace iutnc\deefy\render;

use iutnc\deefy\audio\tracks\AlbumTrack;

class AlbumTrackRenderer implements Renderer {
    private AlbumTrack $track;

    public function __construct(AlbumTrack $track) {
        $this->track = $track;
    }

    public function render(int $selector): string {
        switch ($selector) {
            case Renderer::COMPACT:
                return "{$this->track->getNumeroDePiste()} - {$this->track->getTitre()} - by {$this->track->getArtiste()} (from {$this->track->getAlbum()})";
            case Renderer::LONG:
                return "{$this->track->getNumeroDePiste()} - {$this->track->getTitre()} - by {$this->track->getArtiste()} (from {$this->track->getAlbum()}) - {$this->track->getDuree()}s - {$this->track->getAnnee()} - {$this->track->getGenre()}";
            default:
                return "{$this->track->getTitre()} - by {$this->track->getArtiste()}";
        }
    }
}
