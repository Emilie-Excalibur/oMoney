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
if(isset($_POST['reg_user'])) {

    // Vérifie les informations du formulaire avant de les ajouter en BDD
    checkRegisterUserInfo();

    // Ajoute les informations du formulaire dans la BDD
    addUserInfoToDB();

}

// Validation des données du formulaire de connexion
if(isset($_POST['login_user'])) {
    // Vérifie les infos de l'utilisateur
    // Si celles-ci correspondent à celles existant dans la BDD
    // Connecte l'utilisateur
    checkLoginUserInfo();
}

// Envoi des données du formulaire ajout des dépenses dans la BDD
if(isset($_POST['add_expenses'])) {
    addExpenses();
}

// Envoi des données du formulaire ajout d'un virement dans la BDD
if(isset($_POST['add_transfer'])) {
    addTransfer();
}

// Modification des données utilisateur
if(isset($_POST['update'])) {
    // L'utilisateur peut modifier son email
    updateEmail();
} 

// Modification des données utilisateur
if(isset($_POST['update_password'])) {
    // L'utilisateur peut modifier son mot de passe
    updatePassword();
} 

    // Ajout d'un commentaire
    if (isset($_POST['comment_submit'])) {
        addCommentToDb();
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

$router->map(
    'GET',
    '/errorLog',
    'errorLog',
    'route_error_Log'
);

$router->map(
    'GET',
    '/errorReg',
    'errorReg',
    'route_error_Reg'
);

$router->map(
    'GET',
    '/profil',
    'profil',
    'route_profil'
);

$router->map(
    'GET',
    '/errorMail',
    'errorMail',
    'route_error_Mail'
);

$router->map(
    'GET',
    '/changer-mot-de-passe',
    'password',
    'route_password'
);

$router->map(
    'GET',
    '/errorPassword',
    'errorPassword',
    'route_error_Password'
);

$router->map(
    'GET',
    '/updatePassword',
    'updatePassword',
    'route_update_Password'
);

$router->map(
    'GET',
    '/ajouter-retrait-argent',
    'retrait',
    'route_add_expenses'
);

$router->map(
    'GET',
    '/historique',
    'historique',
    'route_historique'
);

$router->map(
    'GET',
    '/update',
    'update',
    'route_update'
);

$router->map(
    'GET',
    '/ajouter-virement',
    'transfer',
    'route_transfer'
);

$router->map(
    'GET',
    '/commentaires',
    'comments',
    'route_comments'
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

//dump($_SESSION);


    // Rendu visuel
    
// Instanciation de la classe MainController
$controller = new MainController();

// Appel la méthode correspondante du controller afin d'afficher la page demandée
$controller->$methodToCall();


