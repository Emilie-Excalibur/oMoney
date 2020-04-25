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

    $sql = "SELECT 
    account.`date`
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

/* ---------------------------------------------------
    COMMENTS
----------------------------------------------------- */

function addCommentToDb() {
    // $name = empty($_POST['username']) ? '' : $_POST['username'];
    // $content = empty($_POST['comment']) ? '' : $_POST['comment'];
    $name = isset($_POST['username']) ? addslashes($_POST['username']) : '';
    $content = isset($_POST['content_comment']) ? addslashes($_POST['content_comment']) : '';
    $newDate = new DateTime('now');
    $date = $newDate->format('Y-m-d H:i:s');

    if($content != '') {
        $pdo = Database::getPDO();
        $insertQuery = "INSERT INTO `comment` (`name`, `content`, `created_at`) VALUES ('{$name}', '{$content}', '{$date}')";
        $nbInsertedValues = $pdo->exec($insertQuery);    
    } else {
        header('Location:' . $_SERVER['BASE_URI'] . '/commentaires');
        exit;
    }

    if($nbInsertedValues === 1) {
        header('Location:' . $_SERVER['BASE_URI'] . '/commentaires');
        exit;
    } else {
        header('Location:' . $_SERVER['BASE_URI'] . '/error404');
        exit;
    }
}