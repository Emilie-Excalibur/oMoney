<?php

namespace App\Controllers;
use App\Models\Account;
use App\Models\User;
use App\Models\UserPictureColor;


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

        $viewVars['connectedUser'] = isset($_SESSION['connectedUser']) ? true : false;

        // Si utilisateur connecté
        if(!empty($_SESSION['connectedUser'])) {
            // Récupère la liste de toutes ses transactions (dépenses et revenus) sous la forme d'un tableau contenant un objet de type Account à chaque index
            $transactionList = Account::findAll($_SESSION['connectedUser']->getEmail());

            // Récupère les sommes de ses dépenses et de ses revenus
            $transactionSum = Account::findSum($_SESSION['connectedUser']->getEmail());

            // Récupère les informations sur les dépenses/revenus de l'utilisateur sous forme d'un tableau avec une entrée unique contenant un objet de type Account
            $userTransaction = Account::find($_SESSION['connectedUser']->getEmail());

            // Récupère toutes les transactions par date croissante (du plus ancien au plus récent)
            $expensesByDate = Account::findAllByDate($_SESSION['connectedUser']->getEmail());

            // Récupềre le profil de l'utilisateur connecté
            $userInfo = User::findByMail($_SESSION['connectedUser']->getEmail());

            // Récupère les informations de l'utilisateur (nom, première lettre de son nom)
            $name = $_SESSION['connectedUser']->getName();
            $firstLetter = substr($name, 0, 1);
            $color = UserPictureColor::find();
        } else {
            // Sinon, si visiteur
            $transactionList = null;
            $transactionSum = null;
            $userTransaction = null;
            $expensesByDate = null;

            $userInfo = null;
            $firstLetter = null;
            $color = null;
        }

        // Ajoute les valeurs dans viewVars pour pouvoir les transmettre à toutes les vues après
        $viewVars['transactionList'] = $transactionList;
        $viewVars['transactionSum'] = $transactionSum;
        $viewVars['userTransaction'] = $userTransaction;
        $viewVars['expensesByDate'] = $expensesByDate;

        $viewVars['userInfo'] = $userInfo;
        $viewVars['firstLetter'] = $firstLetter;
        $viewVars['color'] = $color; 


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
