<?php
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
function getDateFormat($date) {
    $newDate = date('d/m/Y', strtotime($date));
    return $newDate;
}

/**
 * Converti la date du jour sous forme de seconde
 * en format année-mois-jour
 * 
 * N'importe quelle date antérieure à la date du jour actuel peut être obtenue en soustrayant $time
 *
 * @param integer $time
 * @return string
 */
function convertDate($time = 0) {
    $dateBrut = time() - $time;
    $date = date('Y-m-d', $dateBrut);
    return $date;
}

/* ---------------------------------------------------
    USER'S FUNCTIONS
----------------------------------------------------- */

/**
 * Recupère les informations de l'utilisateur connecté 
 * grâce à son adresse email unique dans la BDD
 *
 * @return userInfo[]
 */
function getUserInfos() {
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

    return $userInfo;
}

/**
 * Déconnecte l'utilisateur
 */
function logout() {
    // Vide complètement la session de l'utilisateur courant
    session_unset();

    // Redirige ensuite l'utilisateur vers la page home
    header('Location:' . $_SERVER['BASE_URI'] .'/');
    exit;
}

/**
 * Vérifie si les informations entrées par l'utilisateur sont correctes
 * Et si l'utilisateur existe déjà dans la BDD via son email
 * Si oui, enregistre l'utilisateur dans la BDD
 * Sinon affiche erreur
 */
function checkRegisterUserInfo() {
    // Récupère les infos
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
    // Si oui, Redirige vers page d'erreur
    $pdo = Database::getPDO();

    $sqlCheckUser = "SELECT * FROM users WHERE email='$email' LIMIT 1";

    $pdoStatement = $pdo->query($sqlCheckUser);

    $userInfo = $pdoStatement->fetch(PDO::FETCH_ASSOC);
    
    if($userInfo['email'] === $email) {
        $errors[] = 'Cette adresse email existe déjà';
        header('Location:' . $_SERVER['BASE_URI'] . '/errorReg');
        exit;
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

        // Actualise les informations de $_SESSION
        // avec les informations de l'utilisateur
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
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
            exit;
        }

    }
}

/**
 * Récupère les informations personnelles de l'utilisateur
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
 * Modifie le mot de passe de la BDD par
 * le mot de passe entré par l'utilisateur
 *
 */
function updatePassword() {
    $oldPassword = isset($_POST['old_password']) ? $_POST['old_password'] : '';
    $newPassword = isset($_POST['new_password']) ? $_POST['new_password'] : '';
    $newPasswordConf = isset($_POST['new_password_conf']) ? $_POST['new_password_conf'] : '';
    $email = $_SESSION['email'];
    $pdo = Database::getPDO();

    // Récupère le mot de passe actuel dans la BDD
    $sql = "SELECT
    `password`
    FROM users
    WHERE email = '$email';
    ";

    $pdoStatement = $pdo->query($sql);
    $passwordFromDb = $pdoStatement->fetch(PDO::FETCH_ASSOC);

    // Compare le nouveau mot de passe et la confirmation
    if($newPassword === $newPasswordConf) {
        // Si oui, chiffre le mot de passe
        $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Vérifie si l'ancien mot de passe correspond au mot de passe existant dans la BDD
        $checkPassword = password_verify($oldPassword, $passwordFromDb['password']);

        // si oui
        if($checkPassword) {
            // Actualise le nouveau mot de passe dans la BDD
            $sqlUpdate = "UPDATE 
            users 
            SET `password` = '$newPassword'
            WHERE email = '$email'";

            $execUpdate = $pdo->exec($sqlUpdate);

            // Si l'update s'est bien déroulé
            if($execUpdate === 1) {
                // Redirige l'utilisateur
                header('Location:' . $_SERVER['BASE_URI'] . '/updatePassword');
                exit;
            }

        } else {
            header('Location:' . $_SERVER['BASE_URI'] . '/errorPassword');
            exit;
        }
    } else {
        header('Location:' . $_SERVER['BASE_URI'] . '/errorPassword');
        exit;

    }
}

/**
 * Modifie l'adresse email de la BDD par 
 * la nouvelle adresse entrée par l'utilisateur
 *
 */
function updateEmail() {
    $newEmail = isset($_POST['new_email']) ? $_POST['new_email'] : '';
    $email = $_SESSION['email'];
    $pdo = Database::getPDO();

    // Récupère tous les emails de la BDD
    $sql = "SELECT
    `email`
    FROM users;
    ";

    $pdoStatement = $pdo->query($sql);
    $emailsFromDb = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

    // Compare chaque email de la BDD avec l'email entré
    foreach ($emailsFromDb as $currentEmail) {
        if($newEmail === $currentEmail['email']) {
            // Si une correspondance est trouvée
            header('Location:' . $_SERVER['BASE_URI'] . '/errorMail');
        }
        else {
            // Sinon, actualise l'adresse email
            $sqlUpdate = "UPDATE 
            users 
            SET `email` = '$newEmail'
            WHERE email = '$email'";
    
            $execUpdate = $pdo->exec($sqlUpdate);

            if($execUpdate === 1) {
                // Si l'update s'est bien déroulé
                // Actualise les données de la session avec la nouvelle adresse email
                // Redirige vers la page indiquant à l'utilisateur que l'update a été fait
                $_SESSION['email'] = $newEmail;
                header('Location:' . $_SERVER['BASE_URI'] . '/update');
                exit;
            } 
        }
    }

}



/* ---------------------------------------------------
    EXPENSES FUNCTIONS
----------------------------------------------------- */

/**
 * Ajoute les données du formulaire des dépenses dans la BDD
 */
function addExpenses() {
    // Si utilisateur non connecté/enregistré
    if(!isset($_SESSION['success'])) {
        // Redirection sur la page d'inscription
        header('Location:' . $_SERVER['BASE_URI'] . '/register');
        exit;
    } else {
        // Sinon, si utilisateur conencté
        // Récupère les infos du formulaire
        $balance = isset($_POST['balance']) ? $_POST['balance'] : '';
        $date = isset($_POST['date']) ? trim($_POST['date']) : '';
        $title = isset($_POST['title']) ? addslashes($_POST['title']) : '';
        $sum = isset($_POST['sum']) ? $_POST['sum'] : '';

        // Récupère l'id et l'email de l'utilisateur connecté
        $userInfo = getUserInfos();

        // Si utilisateur présent en BDD
        if(count($userInfo) === 1) {
            $pdo = Database::getPDO();

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
}

/**
 * Ajoute les données du formulaire des virements dans la BDD
 */
function addTransfer() {
    // Si utilisateur non connecté/enregistré
    if(!isset($_SESSION['success'])) {
        // Redirection sur la page d'inscription
        header('Location:' . $_SERVER['BASE_URI'] . '/register');
        exit;
    } else {
        $date = isset($_POST['date']) ? trim($_POST['date']) : '';
        $title = isset($_POST['title']) ? addslashes($_POST['title']) : '';
        $transfer = isset($_POST['transfer_amount']) ? $_POST['transfer_amount'] : '';

        // Récupère l'id et l'email de l'utilisateur connecté
        $userInfo = getUserInfos();

        // Si utilisateur présent en BDD
        if (count($userInfo) === 1) {
            $pdo = Database::getPDO();

            // Insert les données dans la BDD
            $insertQuery = "INSERT INTO `account` (`user_id`, `date_transfer`, title_transfer, `transfer_amount`) VALUES ('{$userInfo[0]['id']}', '{$date}', '{$title}', '{$transfer}')";

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


/**
 * Récupère la somme de toutes les virements
 * de l'utilisateur connecté via la BDD
 *
 * @return sum[]
 */
function sumTransfer() {
    $email = $_SESSION['email'];

    $pdo = Database::getPDO();

    $sql = "SELECT 
    SUM(`transfer_amount`) AS sumTransfer
    FROM `account` 
    INNER JOIN users 
    ON account.user_id = users.id
    WHERE users.email = '$email';";

    $pdoStatement = $pdo->query($sql);

    $sum = $pdoStatement->fetch(PDO::FETCH_ASSOC);

    return $sum;
}

/**
 * Récupère le solde du compte de l'utilisateur connecté
 *
 * @return balance[]
 */
function getBalance() {
    $email = $_SESSION['email'];

    $pdo = Database::getPDO();

    $sql = "SELECT balance 
    FROM account
    INNER JOIN users 
    ON account.user_id = users.id
    WHERE users.email = '$email'
    ;";

    $pdoStatement = $pdo->query($sql);

    $balance = $pdoStatement->fetch(PDO::FETCH_ASSOC);

    return $balance;
}

/**
 * Calcul le solde actuel de l'utilisateur connecté
 *
 * @return float
 */
function calculBalance() {
    // Récupère le total des dépenses
    $sum = sumExpenses();

    // Récupère le total des virements
    $sumTransfer = sumTransfer();

    // Récupère le solde de l'utilisateur
    $balance= getBalance();

    if($sum != null && $balance != false) {
        // Calcul le solde actuel et formate le résultat
        $currentBalance = $balance['balance'] - $sum['sumExpenses'] + $sumTransfer['sumTransfer'];
        $balanceFormatted = number_format($currentBalance, 2, ',', ' ');
    } else {
        $balanceFormatted = '0';
    }

    return $balanceFormatted;
}

/**
 * Calcul le pourcentage des dépenses par rapport au solde
 *
 * @param float $expenses
 * @param float $balance
 * @return float
 */
function calculPercentage($expenses, $balance) {
    $percentage = ($expenses /  $balance) * 100;

    return $percentage;

}

/**
 * Récupère les informations des dépenses de l'utilisateur
 * triées par date croissante
 *
 * @return allExpenses[]
 */
function getExpensesByDateOrder() {
    $email = $_SESSION['email'];
    $pdo = Database::getPDO();

    $sql = "SELECT *
    FROM account
    INNER JOIN users
    ON account.user_id = users.id
    WHERE users.email = '$email'
    ORDER BY account.date ASC
    ";

    $pdoStatement = $pdo->query($sql);
        
    $allExpenses = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
        
    return $allExpenses;   
}

/**
 * Récupère le total des dépenses réalisées durant une période comprise entre $date et $date2
 * 
 * @param string date, date2
 *
 * @return todayExpenses[]
 */
function getExpensesByDate($date, $date2) {
    $email = $_SESSION['email'];

    $pdo = Database::getPDO();

    $sql = "SELECT 
    SUM(`sum`)
    AS dateExpenses
    FROM account 
    INNER JOIN users
    ON account.user_id = users.id
    WHERE account.`date` BETWEEN '$date' AND '$date2'
    AND users.email = '$email';";
    
    $pdoStatement = $pdo->query($sql);
    
    $expenses = $pdoStatement->fetch(PDO::FETCH_ASSOC);
        
    return $expenses;        
}   

