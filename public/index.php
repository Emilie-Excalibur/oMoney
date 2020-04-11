<?php

session_start();

// Inclu les libraires
require __DIR__ . '/../vendor/autoload.php';

// Inclu les controllers
require __DIR__ . '/../app/controllers/MainController.php';

// Instanciation d'un nouvel objet de la classe AltoRouter
$router = new AltoRouter();

// Définition de la route de base du projet
$router->setBasePath($_SERVER['BASE_URI']);

// Création des routes 
$router->map(
    'GET',
    '/',
    'home',
    'route_home'
);

$router->map(
    'GET',
    '/register',
    'register',
    'route_register'
);

$router->map(
    'GET',
    '/login',
    'login',
    'route_login'
);


$match = $router->match();

// Si la route demandée dans l'URL existe
if($match) {
    // Récupère le nom de la méthode qu'il faudra appeler 
    // pour afficher la page
    $methodToCall = $match['target'];
} else {
    $methodToCall = 'error404';
}


    // Rendu visuel
    
// Instanciation de la classe MainController
$controller = new MainController();

// Appel la méthode correspondante du controller afin d'afficher la page demandée
$controller->$methodToCall();