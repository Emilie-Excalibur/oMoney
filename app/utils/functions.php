<?php

/* ---------------------------------------------------
    USER'S FUNCTIONS
----------------------------------------------------- */

/**
 * Déconnecte l'utilisateur
 */
function logout() {
    // Vide complètement la session de l'utilisateur courant
    session_unset();

    // Redirige ensuite l'utilisateur vers la page home
    header('Location:' . $_SERVER['BASE_URI'] .'/');

}

/**
 * Vérifie si les informations entrées par l'utilisateur sont correctes
 * Et si l'utilisateur existe déjà dans la BDD via son email
 * Si oui, enregistre l'utilisateur dans la BDD
 * Sinon affiche erreur
 */
function checkRegisterUserInfo() {
    // Récupère les infos
    $errors= [];
    $name = isset($_POST['username']) ? $_POST['username'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password1 = isset($_POST['password_1']) ? $_POST['password_1'] : '';
    $password2 = isset($_POST['password_2']) ? $_POST['password_2'] : '';

    // Vérifie si les champs sont vides
    // Et ajoute une erreur si c'est le cas
    if(empty($name)) {
        $errors[] = 'Entrez un nom d\'utilisateur';
    }

    if(empty($email)) {
        $errors[] = 'Entrez une adresse email';
    }

    if(empty($password1)) {
        $errors[] = 'Entrez un mot de passe';
    }

    if($password1 != $password2) {
        $errors[] = 'Les mots de passe doivent correspondre';
    }

    // Requête SQL pour vérifier si le mail entré par l'utilisateur
    // Existe déjà dans la BDD
    // Si oui, ajoute et affiche erreur
    $pdo = Database::getPDO();

    $sqlCheckUser = "SELECT * FROM users WHERE email='$email' LIMIT 1";

    $pdoStatement = $pdo->query($sqlCheckUser);

    $userInfo = $pdoStatement->fetch(PDO::FETCH_ASSOC);
    
    if($userInfo['email'] === $email) {
        $errors[] = 'Cette adresse email existe déjà';
        header('Location:' . $_SERVER['BASE_URI'] . '/errorReg');
    }

}

/**
 * Ajoute les informations de l'utilisateur dans la BDD
 * Lors de son inscription
 */
function addUserInfoToDB() {
    // Récupération des valeurs du formulaire dans des variables
    $name = isset($_POST['username']) ? $_POST['username'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password_1']) ? password_hash($_POST['password_1'], PASSWORD_DEFAULT) : '';
    $picture = isset($_POST['picture']) ? $_POST['picture'] : '';
    
    // Insertion des données dans la BDD
        
    // Initialise PDO à partir de la classe Database
    $pdo = Database::getPDO();
    
    $insertQuery = "INSERT INTO users (name, email, password, picture) VALUES ('{$name}', '{$email}', '{$password}', '{$picture}')";
    
    $nbInsertedValues = $pdo->exec($insertQuery);
    
    if($nbInsertedValues === 1) {
        // Si l'insertion s'est bien passée

        $sql = "SELECT created_at FROM users WHERE email='$email';";

        $pdoStatement = $pdo->query($sql);
    
        $userDateAccount = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        // Actualise les informations de $_SESSION
        // avec les informations de l'utilisateur
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['created_at'] = $userDateAccount['created_at'];
        $_SESSION['success'] = 'Vous êtes bien enregistré';
    
        // Redirige vers la page home
        header('Location:' . $_SERVER['BASE_URI'] . '/');
        exit;
    
    } else {
        echo "Un problème est survenu, merci de réessayer ultérieurement";
    }
}

/**
 * Vérifie si les informations entrées par l'utilisateur sont correctes
 * Et si l'utilisateur existe déjà dans la BDD via son email et son nom d'utilisateur
 * Si oui, connecte l'utilisateur au site
 */
function checkLoginUserInfo() {
    $errors = [];
    $name = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if(empty($name)) {
        $errors[] = 'Entrez un nom d\'utilisateur';
    }

    if(empty($password)) {
        $errors[] = 'Entrez un mot de passe';
    }

    if(count($errors) === 0) {
        // Récupère les informations dont l'utilisateur a pour nom $name
        $sql = "SELECT * FROM users WHERE `name`= '$name';";

        $pdo = Database::getPDO();

        $pdoStatement = $pdo->query($sql);

        $userLogInfo = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

        //(note : Le nom n'est pas unique, on peut donc avoir plusieurs personnes avec le même nom mais avec des mots de passe différents)
        // Pour chaque résultat obtenu 
        // Vérifie si le mot de passe entré dans le formulaire correspond au mot de passe chiffré dans la BDD
        // Vérifie si le nom entré est strictement identique à celui existant dans la BDD (Sinon ne prend pas en compte la casse du nom)
        foreach ($userLogInfo as $userIndex => $userInfo) {
            if(password_verify($password, $userLogInfo[$userIndex]['password'])) {
                $userPassword = $userLogInfo[$userIndex]['password'];
            } 

            if($userLogInfo[$userIndex]['name'] === $name) {
                $username = $userLogInfo[$userIndex]['name'];
            }
        }

        // Recherche l'utilisateur ayant exactement les infos entrées dans le formulaire 
        $sqlCheck = "SELECT * 
        FROM users 
        WHERE `name` = '$username' 
        AND `password` = '$userPassword';";

        $pdoCheckStatement = $pdo->query($sqlCheck);

        $result = $pdoCheckStatement->fetchAll(PDO::FETCH_ASSOC);
       
        // Si le nombre d'entrées dans le tableau $result est égal à 1
        // càd si une correspondance a été trouvée dans la BDD
        // Actualise les informations de la session utilisateur
        // Et redirige vers la page home
        if(count($result) === 1) {
            $_SESSION['name'] = $username;
            $_SESSION['email'] = $result[0]['email'];
            $_SESSION['created_at'] = getDateFormat('fr', $result[0]['created_at']);

            $_SESSION['success'] = 'Vous êtes bien connecté';

            header('Location:' . $_SERVER['BASE_URI'] . '/');
            exit;
            
        } else {
            $errors[] = 'Mauvais nom/mot de passe';
            header('Location:' . $_SERVER['BASE_URI'] . '/errorLog');
        }

    }
}

/* ---------------------------------------------------
    GENERAL FUNCTIONS
----------------------------------------------------- */

/**
 * Cherche de façon aléatoire une couleur présente dans la BDD
 *
 * @return string
 */
function generateRandomColor() {
    $pdo = Database::getPDO();

    $sql = 'SELECT color_name FROM user_picture_color';

    $pdoStatement = $pdo->query($sql);

    $allColors = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

    $randomColorIndex = rand(0, count($allColors) - 1);

    $randomColor = $allColors[$randomColorIndex]['color_name'];

    return $randomColor;
}

/**
 * Récupère la première lettre du nom de l'utilisateur connecté
 *
 * @return string (1 letter)
 */
function getFirstUserLetter() {
    if(isset($_SESSION['name'])) {
        $name = $_SESSION['name'];

        $firstLetter = substr($name, 0, 1);

        return $firstLetter;
    }
}

/**
 * Change le format d'une date en jour/mois/année
 *
 * @param string $date
 * @return string
 */
function getDateFormat($lang, $date) {
    if($lang == 'fr') {
        $newDate = date('d/m/Y', strtotime($date));
    } else if($lang == 'eng') {
        $newDate = date('Y-m-d', strtotime($date));
    }
    return $newDate;
}

/**
 * Récupère la date du jour
 *
 * @return string
 */
function getDateToday() {
    $getDate = getdate();

    $date = $getDate['mday'] . '/0' . $getDate['mon'] . '/' . $getDate['year'];

    return $date;
}

/* ---------------------------------------------------
    EXPENSES FUNCTIONS
----------------------------------------------------- */

function addExpenses() {
    // Récupère les infos du formulaire
    $balance = isset($_POST['balance']) ? $_POST['balance'] : '';
    $date = isset($_POST['date']) ? trim($_POST['date']) : '';
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $sum = isset($_POST['sum']) ? $_POST['sum'] : '';
    $email = $_SESSION['email'];

    // Insertion des données dans la BDD
    $pdo = Database::getPDO();

    // Récupère les infos de l'utilisateur connecté
    $sql = "SELECT id, `email` 
    FROM users 
    WHERE `email` = '$email';
    ";
    
    $pdoStatement = $pdo->query($sql);
    $userInfo = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

    // Si utilisateur présent en BDD
    if(count($userInfo) === 1) {
        // Insert les données dans la BDD
        $insertQuery = "INSERT INTO account (`user_id`, balance, `date`, title, `sum`) VALUES ('{$userInfo[0]['id']}', '{$balance}', '{$date}', '{$title}', '{$sum}')";
    
        $nbInsertedValues = $pdo->exec($insertQuery);
        
        // Si l'insertion s'est bien passée    
        if($nbInsertedValues === 1) {
            // Redirige vers la page historique
    
            header('Location:' . $_SERVER['BASE_URI'] . '/historique');
            exit;
        
        } else {
            echo "Un problème est survenu, merci de réessayer ultérieurement";
        } 
    } else {
        echo 'L\'opération ne s\'est pas déroulée comme prévue. Etes-vous sûr d\'être correctement enregistré ?';
    }
}

/**
 * Récupère les informations du compte où sont enregistrées toutes les dépenses de l'utilisateur connecté
 *
 * @return accountInfo[]
 */
function getAccountInfo() {
    // Identification de l'utilisateur connecté grâce
    // à son email unique
    $email = $_SESSION['email'];

    $pdo = Database::getPDO();

    // Récupère les informations du compte de l'utilisateur connecté
    $sql = "SELECT 
    account.*,
    users.email 
    FROM account
    INNER JOIN users
    ON account.user_id = users.id
    WHERE users.email = '$email'
    ;";

    $pdoStatement = $pdo->query($sql);

    $accountInfo = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

    return $accountInfo;
}

/**
 * Récupère la somme de toutes les dépenses
 * de l'utilisateur connecté via la BDD
 *
 * @return sum[]
 */
function sumExpenses() {
    $email = $_SESSION['email'];

    $pdo = Database::getPDO();

    $sql = "SELECT 
    SUM(`sum`) AS sumExpenses
    FROM account 
    INNER JOIN users 
    ON account.user_id = users.id
    WHERE users.email = '$email';";

    $pdoStatement = $pdo->query($sql);

    $sum = $pdoStatement->fetch(PDO::FETCH_ASSOC);

    return $sum;
}

function getBalance() {
    $pdo = Database::getPDO();

    $sql = "SELECT balance 
    FROM account
    WHERE id = 1
    ;";

    $pdoStatement = $pdo->query($sql);

    $balance = $pdoStatement->fetch(PDO::FETCH_ASSOC);

    return $balance;
}