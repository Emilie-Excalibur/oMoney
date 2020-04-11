<?php

session_start();

// Inclu les libraires
require __DIR__ . '/../vendor/autoload.php';

// Inclu les controllers
require __DIR__ . '/../app/controllers/MainController.php';

// Inclu les fonctions utiles au site
require __DIR__ . '/../app/utils/functions.php';

// Inclu la classe Database qui sert à se connect à la BDD
require __DIR__ . '/../app/utils/Database.php';

/**
 * DONNEES & BDD
 */

// Validation des données du formulaire d'inscription

if(!empty($_POST)) {
    // Récupération des valeurs du formulaire dans des variables
    $name = isset($_POST['username']) ? $_POST['username'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Insertion des données dans la BDD
    
    // Initialise PDO à partir de la classe Database
    $pdo = Database::getPDO();

    $insertQuery = "INSERT INTO users (name, email, password)
    VALUES ('{$name}', '{$email}', '{$password}')";

    $nbInsertedValues = $pdo->exec($insertQuery);

    if($nbInsertedValues === 1) {

        // Si l'insertion s'est bien passée
        // Redirige vers la page home
        header('Location:' . $_SERVER['BASE_URI'] . '/');
        exit;

    } else {
        echo "Un problème est survenu, merci de réessayer ultérieurement";
    }
}


/**
 * GESTION DES ROUTES & AFFICHAGE DES VUES
 */


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


