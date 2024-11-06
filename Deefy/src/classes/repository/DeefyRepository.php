<?php

namespace iutnc\deefy\repository;

use PDO;
use iutnc\deefy\exception\AuthnException;

class DeefyRepository
{
    private $pdo;

    public function __construct()
    {
        // Vérifier si le fichier de configuration existe et s'il contient toutes les clés nécessaires
        $config = parse_ini_file('db.config.ini');

        if (!$config || !isset($config['host'], $config['dbname'], $config['user'], $config['password'])) {
            die("Fichier de configuration de la base de données manquant ou incomplet.");
        }

        try {
            // Création de la connexion PDO
            $this->pdo = new PDO(
                "mysql:host=" . $config['host'] . ";dbname=" . $config['dbname'],
                $config['user'],
                $config['password']
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // En cas d'échec de connexion, affichage d'un message d'erreur
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }


    // Méthode pour récupérer tous les tracks
    public function getAllTracks()
    {
        $stmt = $this->pdo->query("SELECT * FROM track");
        return $stmt->fetchAll();
    }

    // Méthode pour récupérer les informations d'un utilisateur par email
    public function getUserByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM User WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    // Méthode pour sauvegarder un utilisateur dans la base de données
    public function saveUser($nom, $email, $hashedPassword): bool {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO User (email, passwd) VALUES (:email, :passwd)");
            $stmt->execute([
                'email' => $email,
                'passwd' => $hashedPassword
            ]);
            return true;
        } catch (PDOException $e) {
            throw new AuthnException("Erreur lors de l'ajout de l'utilisateur: " . $e->getMessage());
        }
    }



    public function getAllPlaylists(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM playlist");
        $playlists = [];

        while ($row = $stmt->fetch()) {
            $playlist = new Playlist($row['nom']);
            $playlist->setId($row['id']);
            $playlists[] = $playlist;
        }

        return $playlists;
    }


    public function isEmailTaken($email): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM User WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetchColumn() > 0;
    }

    public function getUserPlaylists(int $userId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM playlists WHERE user_id = :userId");
        $stmt->execute(['userId' => $userId]);


        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

}
