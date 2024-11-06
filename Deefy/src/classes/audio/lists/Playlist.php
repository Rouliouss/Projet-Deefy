<?php
namespace iutnc\deefy\audio\lists;

require_once 'AudioList.php';

class Playlist extends AudioList {
    public array $pistes;
    protected int $nombreDePistes;
    protected float $dureeTotale;

    public function __construct(string $nom, array $pistes = []) {
        parent::__construct($nom, $pistes);
        $this->pistes = $pistes;
        $this->nombreDePistes = count($pistes);
        $this->dureeTotale = array_reduce($pistes, fn($carry, $piste) => $carry + $piste->getDuree(), 0);
    }

    public function ajouterPiste($piste) {
        $this->pistes[] = $piste;
        $this->nombreDePistes = count($this->pistes);
        $this->dureeTotale += $piste->getDuree();
    }

    public function supprimerPiste(int $indice) {
        if (isset($this->pistes[$indice])) {
            $this->dureeTotale -= $this->pistes[$indice]->getDuree();
            unset($this->pistes[$indice]);
            $this->pistes = array_values($this->pistes);
            $this->nombreDePistes = count($this->pistes);
        } else {
            throw new \iutnc\deefy\exception\InvalidPropertyNameException("Piste non trouvée à l'indice: $indice");
        }
    }

    public function ajouterListePistes(array $nouvellesPistes) {
        foreach ($nouvellesPistes as $piste) {
            if (!in_array($piste, $this->pistes, true)) {
                $this->ajouterPiste($piste);
            }
        }
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function getNombreDePistes(): int {
        return $this->nombreDePistes;
    }

    public function getDureeTotale(): float {
        return $this->dureeTotale;
    }
}
