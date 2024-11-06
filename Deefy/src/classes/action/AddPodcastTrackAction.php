<?php
namespace iutnc\deefy\action;

use iutnc\deefy\audio\tracks\PodcastTrack;
use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\render\AudioListRenderer;
use iutnc\deefy\render\Renderer;

class AddPodcastTrackAction extends Action {
    public function execute(): string {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Affichage du formulaire d'ajout d'une piste
            $html = "<h2>Ajoute une track à ta playlist : </h2>";
            $html .= <<<END
<form method="post" enctype="multipart/form-data" action="?action=add-track">
    <label>Titre :
        <input type="text" name="titre" required>
    </label>
    <label>Chemin du fichier audio :
        <input type="file" name="fichier" accept="audio/mpeg" required>
    </label>
    <label>Durée (secondes) :
        <input type="number" name="duree" required>
    </label>
    <label>Auteur :
        <input type="text" name="auteur" required>
    </label>
    <label>Date :
        <input type="date" name="date" required>
    </label>
    <label>Genre :
        <input type="text" name="genre" required>
    </label>
    <button type="submit">Ajouter</button>
</form>
END;
        } else {
            // Gestion de la requête POST
            $titre = filter_var($_POST['titre'], FILTER_SANITIZE_SPECIAL_CHARS);
            $duree = filter_var($_POST['duree'], FILTER_VALIDATE_INT);
            $auteur = filter_var($_POST['auteur'], FILTER_SANITIZE_SPECIAL_CHARS);
            $date = new \DateTime(filter_var($_POST['date'], FILTER_SANITIZE_SPECIAL_CHARS));
            $genre = filter_var($_POST['genre'], FILTER_SANITIZE_SPECIAL_CHARS);

            // Validation de la durée
            if ($duree <= 0) {
                return "<p>La durée doit être un nombre positif.</p>";
            }

            // Gestion de l'upload du fichier audio
            if ($_FILES['fichier']['error'] === UPLOAD_ERR_OK) {
                $tmp_name = $_FILES['fichier']['tmp_name'];
                $extension = strtolower(pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION));

                // Vérification du type de fichier
                if ($extension === 'mp3' && $_FILES['fichier']['type'] === 'audio/mpeg') {
                    // Vérifier si le dossier audio existe, sinon le créer
                    $audioDir = __DIR__ . '/../../audio';
                    if (!is_dir($audioDir)) {
                        mkdir($audioDir, 0755, true); // Créer le dossier avec les permissions appropriées
                    }

                    // Génération d'un nom aléatoire pour le fichier
                    $new_name = uniqid('audio_', true) . '.mp3';
                    $destination = $audioDir . '/' . $new_name;

                    // Déplacement du fichier uploadé
                    if (move_uploaded_file($tmp_name, $destination)) {
                        // Création de la nouvelle piste avec le chemin du fichier
                        $track = new PodcastTrack($titre, $new_name, $duree, $auteur, $date, $genre);

                        // Récupération de la playlist depuis la session
                        $playlist = unserialize($_SESSION['playlist']);
                        $playlist->ajouterPiste($track);
                        $_SESSION['playlist'] = serialize($playlist); // Mise à jour de la playlist dans la session

                        // Affichage de la playlist avec le rendu
                        $html = "Piste <b>$titre</b> ajoutée avec succès !<br>";
                        $html .= (new AudioListRenderer($playlist))->render(Renderer::COMPACT);
                        $html .= '<a href="?action=add-track">Ajouter encore une piste</a>'; // Lien pour ajouter une autre piste
                    } else {
                        return "<p>Erreur lors du déplacement du fichier. Vérifiez les permissions du dossier.</p>";
                    }
                } else {
                    return "<p>Le fichier doit être au format MP3 et ne doit pas avoir l'extension .php.</p>";
                }
            } else {
                return "<p>Erreur lors du téléchargement du fichier. Code d'erreur: {$_FILES['fichier']['error']}</p>";
            }
        }
        return $html; // Retourne le contenu HTML
    }
}
