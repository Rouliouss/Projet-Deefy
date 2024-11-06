<?php
namespace iutnc\deefy\action;

use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\render\AudioListRenderer;
use iutnc\deefy\render\Renderer;

class AddPlaylistAction extends Action {
    public function execute(): string {
        // Vérifie si la requête est de type GET
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Crée le formulaire HTML pour ajouter une playlist
            $html = <<<END
<h2>Formulaire d'ajout d'une Playlist</h2>
<form method="post" action="?action=add-playlist">
    <label>Nom de la playlist :
        <input type="text" name="nom" placeholder="Nom de la playlist" required>
    </label>
    <button type="submit">Créer</button>
</form>
END;
        } else {
            // Gère la requête POST pour créer une nouvelle playlist
            $nom = filter_var($_POST['nom'], FILTER_SANITIZE_SPECIAL_CHARS); // Nettoyage du nom

            // Instancie une nouvelle Playlist avec le nom fourni
            $playlist = new Playlist($nom);

            // Sérialise la playlist et l'enregistre dans la session
            $_SESSION['playlist'] = serialize($playlist);

            // Rendu du message de succès et de la playlist
            $html = "Création et mise en session de la playlist <b>$nom</b> réussie !<br>";
            $html .= (new AudioListRenderer($playlist))->render(Renderer::COMPACT);
            $html .= '<a href="?action=add-track">Ajouter une piste</a>'; // Lien pour ajouter une piste
        }

        return $html; // Retourne le contenu HTML
    }
}
