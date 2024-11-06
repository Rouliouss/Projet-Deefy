<?php
namespace iutnc\deefy\render;

use iutnc\deefy\audio\lists\AudioList;

class AudioListRenderer implements Renderer {
    private AudioList $list;

    public function __construct(AudioList $list) {
        $this->list = $list;
    }

    public function render(int $selector): string {
        $html = "<h1>{$this->list->getNom()}</h1>";
        foreach ($this->list->pistes as $index => $track) {
            $renderer = RendererFactory::getRenderer($track);
            $html .= "<p>{$index} - {$renderer->render(Renderer::COMPACT)}</p>";
        }
        $html .= "<p>Total de pistes: {$this->list->getNombreDePistes()}</p>";
        $html .= "<p>Durée totale: {$this->list->getDureeTotale()}s</p>";
        return $html;
    }
}

