<?php

namespace App\Controllers;

use App\Models\User;


class UserController extends CoreController
{
    /**
     * Déconnecte l'utilisateur
     */
    function logout()
    {
        // Vide complètement la session de l'utilisateur courant
        unset($_SESSION['connectedUser']);

        // Redirige ensuite l'utilisateur vers la page home
        $this->redirect('main-home');
    }

    /**
     * Affiche la page de connexion
     *
     * @return void
     */
    public function login()
    {
        $pageName = 'Se connecter';

        $this->show('user/login', ['pageName' => $pageName]);
    }

    /**
     * Vérifie si les informations entrées par l'utilisateur sont correctes
     * Et connecte l'utilisateur si tout est ok
     * 
     * Méthode HTTP : POST
     *
     * @return void
     */
    public function checkLogin()
    {
        $name = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS));
        $password = trim(filter_input(INPUT_POST, 'password',  FILTER_SANITIZE_SPECIAL_CHARS));
        $errorList = [];

        if (empty($name)) {
            $errorList[] = 'Merci de renseigner votre nom';
        }

        if (empty($password)) {
            $errorList[] = 'Merci de renseigner votre mot de passe';
        }

        // S'il n'y a pas d'erreurs jusque là
        if (empty($errorList)) {
            // Cherche dans la BDD l'utilisateur qui a pour nom 
            // celui qui a été fourni dans le formulaire
            $users = User::findByName($name);

            // Si aucun utilisateur avec le nom founi n'a été trouvé dans la BDD
            if ($users == false) {
                // Ajoute une erreur
                $errorList[] = 'Mauvais nom';
                $userPassword = null;
                $username = null;

            } else {
                // Sinon, pour chaque résultat obtenu
                //(note : Le nom n'est pas unique, on peut donc avoir plusieurs personnes avec le même nom mais avec des mots de passe différents)
                foreach ($users as $user) {
                    // Vérifie si le mot de passe entré dans le formulaire correspond au mot de passe haché dans la BDD
                    if (password_verify($password, $user->getPassword())) {
                        // Si oui, récupère le mot de passe haché de la BDD
                        $userPassword = $user->getPassword();
                    } else {
                        // Sinon $userPassword n'a aucune valeur
                        $userPassword = null;
                    }

                    // Vérifie si le nom entré est strictement identique à celui existant dans la BDD (Sinon ne prend pas en compte la casse du nom)
                    if ($user->getName() === $name) {
                        $username = $user->getName();
                    } else {
                        $username = null;
                    }
                }
            }

            // Recherche l'utilisateur ayant exactement les infos entrées dans le formulaire 
            $user = User::findByNameAndPassword($username, $userPassword);

            // Si aucune correspondance n'a été trouvée dans la BDD
            if ($user == false) {
                $errorList[] = 'Mauvais nom/mot de passe';
            } else {
                // Si une correspondance a été trouvée
                // Ouvre une session
                $_SESSION['connectedUser'] = $user;

                // Redirige sur la page home
                $this->redirect('main-home');
            }
        }

        // S'il y a eu des erreurs
        if (!empty($errorList)) {
            // Récupère le nom erroné pour le renvoyer à la vue
            // Pour préremplir les champs
            $user = new User();
            $user->setName(filter_input(INPUT_POST, 'username'));

            $this->show('user/login', [
                'user' => $user,
                'errorList' => $errorList
            ]);
        }
    }

    /**
     * Affiche la page d'inscription
     *
     * @return void
     */
    public function register()
    {
        $pageName = 'Créer un compte';
        $this->show('user/register', ['pageName' => $pageName]);
    }

    /**
     * Vérifie si les informations entrées par l'utilisateur sont correctes
     * Et si l'utilisateur existe déjà dans la BDD via son email
     * Si non, enregistre l'utilisateur dans la BDD
     * 
     * Méthode HTTP : POST
     */
    public function checkRegister()
    {
        $errorList = [];
        // Récupère les infos
        $name = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
        $password1 = trim(filter_input(INPUT_POST, 'password_1',  FILTER_SANITIZE_STRING));
        $password2 = trim(filter_input(INPUT_POST, 'password_2',  FILTER_SANITIZE_STRING));

        // Vérifie si les champs sont vides / valides
        // Et ajoute une erreur si c'est le cas
        if (empty($name)) {
            $errorList[] = 'Merci de renseigner un nom d\'utilisateur';
        }

        if (empty($email)) {
            $errorList[] = 'Merci de renseigner une adresse email';
        }
        if (preg_match('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/', $email) == false) {
            $errorList[] = 'Adresse email non valide';
        }

        if (empty($password1)) {
            $errorList[] = 'Merci de renseigner un mot de passe';
        }

        if ($password1 !== $password2) {
            $errorList[] = 'Les mots de passe doivent correspondre';
        }

        // S'il n'y a pas d'erreurs jusque là
        if (empty($errors)) {

            // Cherche dans la BDD si l'email fourni existe déjà ou pas
            $user = User::findByMail($email);

            // Si l'adresse email n'existe pas
            if ($user === false) {
                // Crée une nouvelle instance de User
                $newUser = new User();

                // Hache le mot de passe avant l'insertion en BDD
                $password = password_hash($password1, PASSWORD_DEFAULT);

                // Renseigne les informations sur le nouvel utilisateur
                $newUser->setName($name);
                $newUser->setEmail($email);
                $newUser->setPassword($password);
                //$newUser->setCreatedAt();

                // Ajoute l'utilisateur dans la BDD
                $executed = $newUser->insert();

                // Si l'insertion s'est bien déroulé
                if ($executed) {
                    // Crée une nouvelle session utilisateur
                    $_SESSION['connectedUser'] = $newUser;

                    // Redirige l'utilisateur sur la page home
                    $this->redirect('main-home');
                } else {
                    // Sinon, si l'insertion a échoué (= false)
                    $errorList[] = 'La création du compte a échoué, merci de recommencer.';
                }
            } else {
                // Sinon si l'email existe déjà
                // Ajoute une erreur
                $errorList[] = 'Cette adresse email existe déjà';
            }
        }

        // S'il y a eu des erreurs lors des vérifications
        if (!empty($errorList)) {
            // Récupère l'email et le nom erroné pour les renvoyer à la vue
            // Pour préremplir les champs
            $user = new User();
            $user->setEmail(filter_input(INPUT_POST, 'email'));
            $user->setName(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));

            $this->show('user/register', [
                'user' => $user,
                'errorList' => $errorList
            ]);
        }
    }

    /**
     * Affiche la page contenant les informations de l'utilisateur connecté
     *
     * @return void
     */
    public function profil()
    {
        $this->checkAuthorization();
        $pageName = 'Profil';
        $user = User::findByMail($_SESSION['connectedUser']->getEmail());
        $creationDate = $user->getCreatedAt();

        $this->show('user/profil', [
            'pageName' => $pageName,
            'creationDate' => $creationDate
        ]);
    }

    /**
     * Modifie les informations de l'utilisateur connecté dans la BDD
     *
     * @return void
     */
    public function update() {
        $this->checkAuthorization();

        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $newEmail = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

        // email de l'utilisateur actuellement connecté
        $email = $_SESSION['connectedUser']->getEmail();
        $errorList = [];

        // Vérifie si l'adresse email a un format valide   
        if(preg_match('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/', $newEmail) == false) {
            $errorList[] = 'Adresse email invalide';
        } 

        if(empty($newEmail)) {
            $errorList[] = 'Merci de renseigner votre adresse email';
        }

        if(empty($name)) {
            $errorList[] = 'Merci de renseigner votre nom';
        }

        // Recherche tous les emails dans la BDD
        $userList = User::findAll();

        // Compare chaque email de la BDD avec l'email entré
        foreach ($userList as $user) {
            if($newEmail === $user->getEmail()) {
                // Si une correspondance est trouvée
                $errorList[] = 'Cette adresse email existe déjà';
            }
        }

        // S'il n'y a pas d'erreur jusque là
        if (empty($errorList)) {  
            // Recherche l'utilisateur actuellement connecté par son email   
            $user = User::findByMail($email);

            // Actualise les informations de l'utilisateur
            $user->setName($name);
            $user->setEmail($newEmail);

            $executed = $user->update();

            // Si tout s'est bien passé
            if ($executed) {
                
                // Actualise les données de la session avec la nouvelle adresse email
                $_SESSION['connectedUser']->setEmail($newEmail);
                $_SESSION['connectedUser']->setName($name);


                $success = 'Les informations ont bien été mises à jour';

                $this->show('user/profil', [
                    'success' => $success
                ]);

            // Si au contraire il y a eu un soucis
            } else {

                // Ajoute un message d'erreur
                $errorList[] = 'La mise à jour des informations a échoué, merci de recommencer';
            }
        }

        if(!empty($errorList)) {
            $user = new User();
            $user->setName(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
            $user->setEmail(filter_input(INPUT_POST, 'email',FILTER_SANITIZE_EMAIL));

            $this->show('user/profil', [
                'user' => $user,
                'errorList' => $errorList
            ]);
        }
    }
}
