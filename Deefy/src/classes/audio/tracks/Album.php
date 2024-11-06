<?php
namespace iutnc\deefy\audio\lists;

class Album extends AudioList {
    private string $artiste;
    private \DateTime $dateSortie;

    public function __construct(string $nom, array $pistes, string $artiste, \DateTime $dateSortie) {
        parent::__construct($nom, $pistes);
        $this->artiste = $artiste;
        $this->dateSortie = $dateSortie;
    }

    public function setArtiste(string $artiste): void {
        $this->artiste = $artiste;
    }

    public function setDateSortie(\DateTime $dateSortie): void {
        $this->dateSortie = $dateSortie;
    }

    public function getArtiste(): string {
        return $this->artiste;
    }

    public function getDateSortie(): \DateTime {
        return $this->dateSortie;
    }
}
