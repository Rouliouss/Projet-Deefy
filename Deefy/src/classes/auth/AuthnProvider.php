<?php

namespace iutnc\deefy\auth;

use iutnc\deefy\db\DeefyRepository;
use iutnc\deefy\exception\AuthnException;
use PDO;
use PDOException;

class AuthnProvider {

    /**
     * Vérifie les informations de connexion d'un utilisateur
     *
     * @param string $email L'adresse email de l'utilisateur
     * @param string $password Le mot de passe en clair de l'utilisateur
     * @return void
     * @throws AuthnException Si l'authentification échoue
     */
    public static function signin(string $email, string $password): void {
        try {
            // Connexion à la base de données
            $pdo = new PDO('mysql:host=localhost;dbname=deefy;charset=utf8', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Préparation de la requête pour trouver l'utilisateur par email
            $stmt = $pdo->prepare("SELECT id, passwd FROM User WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérifie si l'utilisateur existe et si le mot de passe correspond
            if ($user && password_verify($password, $user['passwd'])) {
                // Connexion réussie, on initialise la session
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $email;
            } else {
                // En cas d'échec d'authentification
                throw new AuthnException("Échec de l'authentification : email ou mot de passe incorrect.");
            }
        } catch (PDOException $e) {
            throw new AuthnException("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    /**
     * Méthode pour inscrire un utilisateur
     *
     * @param string $email L'adresse email de l'utilisateur
     * @param string $password Le mot de passe en clair de l'utilisateur
     * @return void
     * @throws AuthnException Si l'inscription échoue
     */
    public static function signup(string $email, string $password): void {
        try {
            // Connexion à la base de données
            $pdo = new PDO('mysql:host=localhost;dbname=deefy;charset=utf8', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Vérifier si l'email est déjà pris
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM User WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $emailExists = $stmt->fetchColumn();

            if ($emailExists) {
                throw new AuthnException("L'email est déjà utilisé.");
            }

            // Hacher le mot de passe avant de l'enregistrer
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insérer l'utilisateur dans la base de données
            $stmt = $pdo->prepare("INSERT INTO User (email, passwd) VALUES (:email, :passwd)");
            $stmt->execute(['email' => $email, 'passwd' => $hashedPassword]);

            // Connexion réussie après l'inscription, on initialise la session
            $userId = $pdo->lastInsertId();  // Récupère l'ID du nouvel utilisateur
            session_start();
            $_SESSION['user_id'] = $userId;
            $_SESSION['user_email'] = $email;
        } catch (PDOException $e) {
            throw new AuthnException("Erreur d'inscription : " . $e->getMessage());
        }
    }

    /**
     * Récupère l'utilisateur actuellement connecté
     *
     * @return array
     * @throws AuthnException Si aucun utilisateur n'est connecté
     */
    public static function getSignedInUser() {
        if (!isset($_SESSION['user_id'])) {
            throw new AuthnException("Aucun utilisateur connecté.");
        }
        return ['user_id' => $_SESSION['user_id'], 'user_email' => $_SESSION['user_email']];
    }}