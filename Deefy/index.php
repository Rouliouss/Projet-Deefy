<?php
declare(strict_types=1);

use iutnc\deefy\dispatch\Dispatcher;
use iutnc\deefy\auth\AuthnProvider;
use iutnc\deefy\exception\AuthnException;

require_once 'vendor/autoload.php';

session_start();

// Vérifie si l'utilisateur est déjà connecté
if (isset($_SESSION['user'])) {
    // Affiche le nom de l'utilisateur s'il est connecté
    $username = htmlspecialchars($_SESSION['user']['nom'] ?? 'Utilisateur inconnu');
} else {
    // Vérifie si on est en mode GET ou POST
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Affiche le formulaire de connexion
        echo '<div class="login-container">
    <form method="POST" action="">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        
        <label for="passwd">Mot de passe:</label>
        <input type="password" name="passwd" id="passwd" required>
        
        <button type="submit">Connexion</button>
    </form>
</div>';
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Vérifie que les deux clés sont présentes dans $_POST
        if (isset($_POST['email']) && isset($_POST['passwd'])) {
            $email = $_POST['email'];
            $passwd = $_POST['passwd'];

            try {
                // Appelle la méthode signin() pour vérifier les informations
                AuthnProvider::signin($email, $passwd);

                // Enregistrement de l'utilisateur en session après authentification réussie
                $_SESSION['user'] = [
                    'email' => $email,
                    'nom' => 'NomUtilisateurExemple' // Remplacer par le vrai nom de l'utilisateur
                ];

                // Message de confirmation pour l'utilisateur
                echo "<p>Bienvenue, " . htmlspecialchars($email) . "! Vous êtes connecté.</p>";
            } catch (AuthnException $e) {
                // Message d'erreur en cas d'échec de l'authentification
                echo "<p>Erreur d'authentification : " . htmlspecialchars($e->getMessage()) . "</p>";
            }
        } else {
            // Message d'erreur si l'email ou le mot de passe est manquant
            echo "<p>Erreur : Email ou mot de passe manquant.</p>";
        }
    }
}

// Affichage du message de bienvenue en haut à droite, si l'utilisateur est connecté
if (isset($username)) {
    echo "<div class='user-welcome-message'>Bienvenue, " . $username . "!</div>";
}

// Initialisation de l'action à partir des paramètres GET, avec 'default' comme valeur par défaut
$action = $_GET['action'] ?? 'default'; // Action par défaut si aucune action n'est précisée
$d = new Dispatcher($action);
$d->run();
