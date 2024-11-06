<?php

namespace iutnc\deefy\action;

use iutnc\deefy\repository\DeefyRepository;
use iutnc\deefy\auth\AuthnProvider;
use iutnc\deefy\exception\AuthnException;

class AddUserAction extends Action
{

    public function execute(): string
    {
        // Si la requête est de type GET, afficher le formulaire d'inscription
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $html = "<h2>Inscription</h2>";
            $html .= <<<END
<form method="post" action="?action=add-user">
    <label for="nom">Nom:</label>
    <input type="text" id="nom" name="nom" required><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br>

    <label for="password">Mot de passe:</label>
    <input type="password" id="password" name="password" required><br>

    <button type="submit">S'inscrire</button>
</form>
END;
            return $html;
        }

        // Traitement de la requête POST pour l'inscription
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire et les sécuriser
            $nom = filter_var($_POST['nom'], FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];  // Le mot de passe en clair

            // Vérifier si l'email est valide
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return "<p>Email invalide.</p>";
            }

            // Vérifier si l'utilisateur existe déjà
            $repo = new DeefyRepository();
            $existingUser = $repo->getUserByEmail($email);
            if ($existingUser) {
                return "<p>L'email est déjà utilisé. Veuillez en choisir un autre.</p>";
            }

            // Hacher le mot de passe
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Sauvegarder l'utilisateur dans la base de données
            try {
                // Si le champ nom est inutilisé, on passe simplement email et password
                $repo->saveUser($nom, $email, $hashedPassword);

                // Connexion automatique après inscription (facultatif)
                session_start();
                $_SESSION['user'] = [
                    'nom' => $nom,
                    'email' => $email,
                ];

                // Rediriger vers la page d'accueil
                header("Location: ?action=default");
                exit;
            } catch (AuthnException $e) {
                return "<p>Erreur lors de l'inscription: " . $e->getMessage() . "</p>";
            }
        }

        return ''; // Par défaut, ne rien afficher si la méthode n'est pas POST ou GET
    }

}
