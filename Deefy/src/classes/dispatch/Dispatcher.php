<?php

namespace iutnc\deefy\dispatch;

use iutnc\deefy\action\AddPlaylistAction;
use iutnc\deefy\action\AddPodcastTrackAction;
use iutnc\deefy\action\AddUserAction;
use iutnc\deefy\action\DefaultAction;
use iutnc\deefy\action\DisplayPlaylistAction;
use iutnc\deefy\repository\DeefyRepository;
use iutnc\deefy\auth\Authz;
use iutnc\deefy\exception\AuthnException;

class Dispatcher
{
    private ?string $action;

    public function __construct(?string $action)
    {
        $this->action = $action;
    }

    public function run()
    {

        $html = '';

        switch ($this->action) {
            case 'default':
                $action = new DefaultAction();
                break;
            case 'add-playlist':
                $action = new AddPlaylistAction();
                break;
            case 'add-track':
                $action = new AddPodcastTrackAction();
                break;
            case 'add-user':
                $action = new AddUserAction();
                break;
            case 'display-playlists':
                // Exécution de l'action DisplayPlaylistAction
                $action = new DisplayPlaylistAction();
                break;
            default:
                $html = 'Action inconnue';
                $action = null;
        }

        // Si une action a été définie, on exécute la méthode `execute`
        if (isset($action)) {
            $html = $action->execute();
        }

        // Rendu de la page avec le contenu généré
        $this->renderPage($html);
    }

    private function renderPage(string $html): void
    {
        echo <<<END
<!DOCTYPE html>
<html lang="fr">
<head>
<title>Deefy</title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<link href="./index.css" rel="stylesheet"/>
</head>
<body>
<h1>Deefy</h1>
<nav>
<ul>
    <li><a href="?action=default">Accueil</a></li>
    <li><a href="?action=add-user">Inscription</a></li>
    <li><a href="?action=add-playlist">Créer une Playlist</a></li>
    <li><a href="?action=display-playlists">Mes Playlists</a></li>
    <li><a href="?action=add-track">Ajouter une piste</a></li>
</ul>
</nav>

<div>$html</div>
</body>
</html>
END;
    }

    private function renderPlaylist(Playlist $playlist): string
    {
        $html = "<h2>" . htmlspecialchars($playlist->getName()) . "</h2>";
        $html .= "<ul>";
        foreach ($playlist->getTracks() as $track) {
            $html .= "<li>" . htmlspecialchars($track->getTitle()) . "</li>";
        }
        $html .= "</ul>";
        return $html;
    }
}
