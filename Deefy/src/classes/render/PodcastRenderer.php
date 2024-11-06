<?php
namespace iutnc\deefy\render;

use iutnc\deefy\audio\tracks\PodcastTrack;

class PodcastRenderer implements Renderer {
    private PodcastTrack $podcast;

    public function __construct(PodcastTrack $podcast) {
        $this->podcast = $podcast;
    }

    public function render(int $selector): string {
        switch ($selector) {
            case Renderer::COMPACT:
                return "{$this->podcast->getTitre()} - by {$this->podcast->getAuteur()} ({$this->podcast->getDate()->format('Y-m-d')})";
            case Renderer::LONG:
                return "{$this->podcast->getTitre()} - by {$this->podcast->getAuteur()} ({$this->podcast->getDate()->format('Y-m-d')}) - {$this->podcast->getDuree()}s - {$this->podcast->getGenre()}";
            default:
                return "{$this->podcast->getTitre()} - by {$this->podcast->getAuteur()}";
        }
    }
}

