<?php

namespace App\Controllers;

abstract class CoreController {
    /**
     * Méthode permettant d'afficher du code HTML en se basant sur les views
     *
     * @param string $viewName Nom du fichier de vue
     * @param array $viewVars Tableau des données à transmettre aux vues
     * @return void
     */
    protected function show(string $viewName, $viewVars = []) {
        // On globalise $router car on ne sait pas faire mieux pour l'instant
        global $router;

        $viewVars['connectedUser'] = isset($_SESSION['connectedUser']) ? $_SESSION['connectedUser'] : null;

        // Comme $viewVars est déclarée comme paramètre de la méthode show()
        // les vues y ont accès
        // ici une valeur dont on a besoin sur TOUTES les vues
        // donc on la définit dans show()
        $viewVars['currentPage'] = $viewName; 

        // définir l'url absolue pour nos assets
        $viewVars['assetsBaseUri'] = $_SERVER['BASE_URI'] . '/assets/';
        // définir l'url absolue pour la racine du site
        // /!\ != racine projet, ici on parle du répertoire public/
        $viewVars['baseUri'] = $_SERVER['BASE_URI'];

        // On veut désormais accéder aux données de $viewVars, mais sans accéder au tableau
        // La fonction extract permet de créer une variable pour chaque élément du tableau passé en argument
        extract($viewVars);
        // => la variable $currentPage existe désormais, et sa valeur est $viewName
        // => la variable $assetsBaseUri existe désormais, et sa valeur est $_SERVER['BASE_URI'] . '/assets/'
        // => la variable $baseUri existe désormais, et sa valeur est $_SERVER['BASE_URI']
        // => il en va de même pour chaque élément du tableau

        // $viewVars est disponible dans chaque fichier de vue
        require_once __DIR__.'/../views/layout/header.tpl.php';
        require_once __DIR__.'/../views/'.$viewName.'.tpl.php';
        require_once __DIR__.'/../views/layout/footer.tpl.php';
    }

    /**
     * Méthode permettant de rediriger l'utilisateur, dans tous les controllers.
     */
    public function redirect($route) {
        global $router;

        header('Location: '. $router->generate($route));
        return;
    }

    /**
     * Méthode vérifiant si l'utilisateur est bien connecté
     * 
     * @return true / Or redirect
     */
    public function checkAuthorization()
    {
        // Si utilisateur connecté
        if (isset($_SESSION['connectedUser'])) {
            // Retourne vrai
            return true;

            // Sinon si l'utilisateur n'est pas connecté
        } else {
            // On le redirige vers la page de connexion
            $this->redirect('user-login');
        }
    }
}
