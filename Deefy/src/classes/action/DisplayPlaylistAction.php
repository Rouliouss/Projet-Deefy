<?php

namespace iutnc\deefy\action;

use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\render\AudioListRenderer;
use iutnc\deefy\render\Renderer;
use iutnc\deefy\repository\DeefyRepository;



class DisplayPlaylistAction extends Action
{

    public function execute(): string
    {
        // Démarre la session si elle n'est pas déjà démarrée
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
            return "<p>Vous devez être connecté pour afficher vos playlists.</p>";
        }


        $userId = $_SESSION['user']['id'];


        $repository = new DeefyRepository();

        // Récupérer les playlists de l'utilisateur
        $playlists = $repository->getUserPlaylists($userId);


        if (!empty($playlists)) {

            return (new AudioListRenderer($playlists))->render(Renderer::COMPACT);
        } else {
            return "<p>Aucune playlist disponible.</p>";
        }
    }
}
