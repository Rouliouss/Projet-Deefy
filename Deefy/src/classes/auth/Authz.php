<?php

namespace iutnc\deefy\auth;

use iutnc\deefy\exception\AuthnException;

class Authz
{
    public static function checkRole(int $expectedRole): void
    {
        $user = AuthnProvider::getSignedInUser();

        if (!isset($user['role']) || $user['role'] !== $expectedRole) {
            throw new AuthnException("Accès refusé : rôle non autorisé.");
        }
    }

    public static function checkPlaylistOwner(int $playlistId): void
    {
        $user = AuthnProvider::getSignedInUser();
        $repository = new DeefyRepository();

// Supposons que la méthode getOwnerId() récupère l'ID du propriétaire de la playlist
        $ownerId = $repository->getOwnerIdByPlaylistId($playlistId);

        if ($ownerId !== $user['id'] && $user['role'] !== 100) { // 100 correspond au rôle ADMIN
            throw new AuthnException("Accès refusé : vous n'êtes pas le propriétaire de la playlist.");
        }
    }
}
