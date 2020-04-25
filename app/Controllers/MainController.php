<?php
namespace App\Controllers;

class MainController extends CoreController {
    /**
     * Affiche la page d'accueil
     */
    public function home() {
        $this->show('main/home');
    }

}