<?php
namespace iutnc\deefy\audio\lists;

class AudioList {
    protected string $nom;
    protected int $nombreDePistes;
    protected float $dureeTotale;
    public array $pistes;

    public function __construct(string $nom, array $pistes = []) {
        $this->nom = $nom;
        $this->pistes = $pistes;
        $this->nombreDePistes = count($pistes);
        $this->dureeTotale = array_reduce($pistes, fn($carry, $piste) => $carry + $piste->duree, 0);
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
