<?php

class MainController {
    /**
     * Affiche la page d'accueil
     */
    public function home() {
        $this->show('home');
    }

    /**
     * Affiche la page d'inscription
     */
    public function register() {
        $this->show('register');
    }

    /**
     * Affiche la page de connexion
     */
    public function login() {
        $this->show('login');
    }

    /**
     * Affiche la page d'erreur
     */
    public function error404() {
        $this->show('error404');
    }

    /**
     * Affiche la page d'erreurs de connexion
     */
    public function errorLog() {
        $this->show('errorLog');
    }

    /**
     * Affiche la page d'erreurs d'inscription
     */
    public function errorReg() {
        $this->show('errorReg');
    }

    /**
     * Affiche la page profil de l'utilisateur
     */
    public function profil() {
        $this->show('profil');
    }

    /**
     * Affiche la page pour ajouter un retrait d'argent
     */
    public function retrait() {
        $this->show('retrait');
    }

    /**
     * Affiche la page de l'historique
     */
    public function historique() {
        $this->show('historique');
    }

    /**
     * Affiche la page si actualisation des données utilisateurs 
     */
    public function actualisation() {
        $this->show('actualisation');
    }


    /**
     * show() prend en argument un nom de page à afficher
     * Et l'affiche
     * $viewVars est un tableau contenant toutes les informations utiles à l'affichage (peut donc contenir plusieurs infos)
     */
    public function show($viewName, $viewVars=[]) {

        $viewVars['BaseUri'] = $_SERVER['BASE_URI'];

        // $viewVars est disponible dans chaque fichier de vue
        require_once __DIR__.'/../views/header.tpl.php';
        require_once __DIR__.'/../views/'.$viewName.'.tpl.php';
        require_once __DIR__.'/../views/footer.tpl.php';
    }

}