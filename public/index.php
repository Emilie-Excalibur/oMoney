<?php

// Inclu les libraires
require_once '../vendor/autoload.php';
session_start();


/**
 * GESTION DES ROUTES & AFFICHAGE DES VUES
 */

// création de l'objet router
// Cet objet va gérer les routes pour nous, et surtout il va 
$router = new AltoRouter();

// le répertoire (après le nom de domaine) dans lequel on travaille est celui-ci
// Mais on pourrait travailler sans sous-répertoire
// Si il y a un sous-répertoire
if (array_key_exists('BASE_URI', $_SERVER)) {
    // Alors on définit le basePath d'AltoRouter
    $router->setBasePath($_SERVER['BASE_URI']);
    // ainsi, nos routes correspondront à l'URL, après la suite de sous-répertoire
}
// sinon
else {
    // On donne une valeur par défaut à $_SERVER['BASE_URI'] car c'est utilisé dans le CoreController
    $_SERVER['BASE_URI'] = '/';
}

// Définition de la route de base du projet
$router->setBasePath($_SERVER['BASE_URI']);

// Création des routes 
$router->map(
    'GET',
    '/',
    'MainController::home',
    'main-home'
);

$router->map(
    'GET',
    '/commentaires',
    'CommentController::comments',
    'comments-comments'
);

$router->map(
    'POST',
    '/commentaires',
    'CommentController::add'
);


/* =======================
        USER CONNEXION
   =======================
*/

 $router->map(
    'GET',
    '/register',
    'UserController::register',
    'user-register'
);

$router->map(
    'POST',
    '/register',
    'UserController::checkRegister'
);

$router->map(
    'GET',
    '/login',
    'UserController::login',
    'user-login'
);

$router->map(
    'POST',
    '/login',
    'UserController::checkLogin'
);

$router->map(
    'GET',
    '/logout',
    'UserController::logout',
    'user-logout'
);

/* =======================
        USER INFO
   =======================
*/

$router->map(
    'GET',
    '/profil',
    'UserController::profil',
    'user-profil'
);

$router->map(
    'POST',
    '/profil',
    'UserController::updateProfil'
);

$router->map(
    'GET',
    '/password',
    'UserController::password',
    'user-password'
);
$router->map(
    'POST',
    '/password',
    'UserController::updatePassword'
);

/* =======================
        USER'S ACCOUNT
   =======================
*/

$router->map(
    'GET',
    '/history',
    'AccountController::history',
    'account-history'
);

$router->map(
    'GET',
    '/expenses',
    'AccountController::expenses',
    'account-expenses'
);

$router->map(
    'POST',
    '/expenses',
    'AccountController::addExpenses'
);

$router->map(
    'GET',
    '/income',
    'AccountController::income',
    'account-income'
);

$router->map(
    'POST',
    '/income',
    'AccountController::addIncome'
);


/* -------------
--- DISPATCH ---
--------------*/

// On demande à AltoRouter de trouver une route qui correspond à l'URL courante
$match = $router->match();

// Ensuite, pour dispatcher le code dans la bonne méthode, du bon Controller
// On délègue à une librairie externe : https://packagist.org/packages/benoclock/alto-dispatcher
// 1er argument : la variable $match retournée par AltoRouter
// 2e argument : le "target" (controller & méthode) pour afficher la page 404
$dispatcher = new Dispatcher($match, '\App\Controllers\ErrorController::err404');

// On précise le namespace pour tous les controllers
// Ce qui évite de les réécrire à chaque fois
$dispatcher->setControllersNamespace('\App\Controllers\\');

// Une fois le "dispatcher" configuré, on lance le dispatch qui va exécuter la méthode du controller
$dispatcher->dispatch();


