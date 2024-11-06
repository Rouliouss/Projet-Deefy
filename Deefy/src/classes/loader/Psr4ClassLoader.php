<?php
namespace loader;

class Psr4ClassLoader {
    private $prefix;
    private $baseDir;

    public function __construct($prefix, $baseDir) {
        $this->prefix = rtrim($prefix, '\\') . '\\'; // Ajout d'un antislash à la fin
        $this->baseDir = rtrim($baseDir, '/') . '/'; // Ajout d'un slash à la fin
    }

    public function loadClass($className) {
        // Vérifie si cette classe utilise le préfixe
        if (strpos($className, $this->prefix) !== 0) {
            return; // Ne rien faire si ce n'est pas le bon préfixe
        }

        // Enlève le préfixe de la classe
        $relativeClass = substr($className, strlen($this->prefix));

        // Remplace les antislashs par des slashes pour la structure de répertoire
        $file = $this->baseDir . str_replace('\\', '/', $relativeClass) . '.php';

        // Inclut le fichier si celui-ci existe
        if (is_file($file)) {
            require_once $file;
        }
    }

    public function register() {
        spl_autoload_register([$this, 'loadClass']);
    }
}
?>

