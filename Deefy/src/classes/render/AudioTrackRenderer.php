<?php
namespace iutnc\deefy\render;


abstract class AudioTrackRenderer implements Renderer
{

    public function render(int $selector): string
    {
        if ($selector === self::COMPACT) {
            return $this->renderCompact();
        } elseif ($selector === self::LONG) {
            return $this->renderLong();
        } else {
            return "Mode d'affichage non reconnu.";
        }
    }

    private function renderCompact(): string{
        return "non defini";
    }

    private function renderLong(): string{
        return "non defini";
    }

}

