<?php

namespace App\Models;
use App\Utils\Database;
use PDO;

class Account extends CoreModel {
    private $user_id;
    private $balance;
    private $date;
    private $title;
    private $sum;
    private $date_transfer;
    private $title_transfer;
    private $transfer_amount;


    /**
     * Get the value of user_id
     */ 
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */ 
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Get the value of balance
     */ 
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * Set the value of balance
     *
     * @return  self
     */ 
    public function setBalance($balance)
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * Get the value of date
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */ 
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of sum
     */ 
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * Set the value of sum
     *
     * @return  self
     */ 
    public function setSum($sum)
    {
        $this->sum = $sum;

        return $this;
    }

    /**
     * Get the value of date_transfer
     */ 
    public function getDateTransfer()
    {
        return $this->date_transfer;
    }

    /**
     * Set the value of date_transfer
     *
     * @return  self
     */ 
    public function setDateTransfer($date_transfer)
    {
        $this->date_transfer = $date_transfer;

        return $this;
    }

    /**
     * Get the value of title_transfer
     */ 
    public function getTitleTransfer()
    {
        return $this->title_transfer;
    }

    /**
     * Set the value of title_transfer
     *
     * @return  self
     */ 
    public function setTitleTransfer($title_transfer)
    {
        $this->title_transfer = $title_transfer;

        return $this;
    }

    /**
     * Get the value of transfer_amount
     */ 
    public function getTransferAmount()
    {
        return $this->transfer_amount;
    }

    /**
     * Set the value of transfer_amount
     *
     * @return  self
     */ 
    public function setTransferAmount($transfer_amount)
    {
        $this->transfer_amount = $transfer_amount;

        return $this;
    }

    /**
     * Ajoute des dépenses dans la BDD
     *
     * @return bool
     */
    public function insertExpenses() {
        $pdo = Database::getPDO();

        $sql = 'INSERT INTO `account` (
                    user_id,
                    balance,
                    date,
                    title,
                    sum
                ) VALUES (
                    :user_id,
                    :balance,
                    :date,
                    :title,
                    :sum
                )';

        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);
        $pdoStatement->bindValue(':balance', $this->balance, PDO::PARAM_STR);
        $pdoStatement->bindValue(':date', $this->date, PDO::PARAM_STR);
        $pdoStatement->bindValue(':title', $this->title, PDO::PARAM_STR);
        $pdoStatement->bindValue(':sum', $this->sum, PDO::PARAM_STR);
 
        $executed = $pdoStatement->execute();
        $insertedRows = $pdoStatement->rowCount();

        if ($executed && $insertedRows === 1) {
            return true;
        }
        return false;
    }

    /**
     * Ajoute des revenus dans la BDD
     *
     * @return bool
     */
    public function insertIncome() {
        $pdo = Database::getPDO();

        $sql = 'INSERT INTO `account` (
                    user_id,
                    date_transfer,
                    title_transfer,
                    transfer_amount
                ) VALUES (
                    :user_id,
                    :date_transfer,
                    :title_transfer,
                    :transfer_amount
                )';

        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);
        $pdoStatement->bindValue(':date_transfer', $this->date_transfer, PDO::PARAM_STR);
        $pdoStatement->bindValue(':title_transfer', $this->title_transfer, PDO::PARAM_STR);
        $pdoStatement->bindValue(':transfer_amount', $this->transfer_amount, PDO::PARAM_STR);
 
        $executed = $pdoStatement->execute();
        $insertedRows = $pdoStatement->rowCount();

        if ($executed && $insertedRows === 1) {
            return true;
        }
        return false;
    }

    /**
     * Récupère les informations des transactions de l'utilisateur connecté
     * sous forme d'un tableau contenant un seul index 
     *
     * @param [int] $userEmail
     * @return Account[]
     */
    public static function find($userEmail) {
        $pdo = Database::getPDO();

        $sql = 'SELECT 
        account.*
        FROM account
        INNER JOIN users
        ON account.user_id = users.id
        WHERE users.email = :email
        ;';

        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':email', $userEmail, PDO::PARAM_STR);

        $pdoStatement->execute();
        $transaction = $pdoStatement->fetchObject(self::class);
        return $transaction;
    }

    /**
     * Récupère les informations des transactions de l'utilisateur connecté
     * sous forme d'un tableau contenant plusieurs index
     * L'utilisateur est identifié grâce à son email unique dans la BDD
     *
     * @param [string] $userEmail
     * @return Account[]
     */
    public static function findAll($userEmail) {

        $pdo = Database::getPDO();

        $sql = 'SELECT 
        account.*,
        users.email 
        FROM account
        INNER JOIN users
        ON account.user_id = users.id
        WHERE users.email = :email
        ;';

        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':email', $userEmail, PDO::PARAM_STR);

        $pdoStatement->execute();
        $transactionList = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Account');
        return $transactionList;
    }

    /**
     * Récupère la somme de toutes les dépenses et de tous les revenus de l'utilisateur connecté
     *
     * @param [int] $userEmail
     * @return []
     */
    public static function findSum($userEmail) {
        $pdo = Database::getPDO();
    
        $sql = 'SELECT 
        SUM(`transfer_amount`) AS sumIncome,
        SUM(`sum`) AS sumExpenses
        FROM `account` 
        INNER JOIN users 
        ON account.user_id = users.id
        WHERE users.email = :email;';
    
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':email', $userEmail, PDO::PARAM_STR);

        $pdoStatement->execute();
        $transaction = $pdoStatement->fetch(PDO::FETCH_ASSOC);
        return $transaction;
    }

    /**
     * Récupère la somme des dépenses réalisées durant la durée précisée
     *
     * @param [string] $date1
     * @param [string] $date2
     * @param [string] $userEmail
     * @return []
     */
    public static function findExpensesByDate($date1, $date2, $userEmail) {
        $pdo = Database::getPDO();

        $sql = 'SELECT 
        SUM(`sum`) AS dateExpenses
        FROM account 
        INNER JOIN users
        ON account.user_id = users.id
        WHERE account.`date` BETWEEN :date1 AND :date2
        AND users.email = :email;';
        
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':email', $userEmail, PDO::PARAM_STR);
        $pdoStatement->bindValue(':date1', $date1, PDO::PARAM_STR);
        $pdoStatement->bindValue(':date2', $date2, PDO::PARAM_STR);

        $pdoStatement->execute();
        
        $expenses = $pdoStatement->fetch(PDO::FETCH_ASSOC);
            
        return $expenses;       
    }

    /**
     * Récupère toutes les transactions et les sommes des dépenses/revenus
     * selon le tri qui a été demandé
     *
     * @param [string] $userEmail
     * @return [filterList, filterSum]
     */
    public static function findByFilter($userEmail) {
        $pdo = Database::getPDO();

        $todayObject = new \DateTime('Today');
        $today = $todayObject->format('Y-m-d');
        $yesterdayObject = new \DateTime('yesterday');
        $yesterday = $yesterdayObject->format('Y-m-d');
        $lastWeekObject = new \DateTime('-1 week today');
        $lastWeek = $lastWeekObject->format('Y-m-d');
        $firstDayOfMonthObject = new \DateTime('first day of this month');
        $firstDayOfMonth = $firstDayOfMonthObject->format('Y-m-d');

        // Si aucun tri n'a été demandé
        if(empty($_GET['filter'])) {
            return false;
        }

        // Si un tri a été demandé
        // Récupète toutes les informations liées aux transactions
        // Et les sommes de toutes les dépenses / virements
        if(!empty($_GET['filter']) && $_GET['filter'] === 'all'){
            $sql='SELECT *
            FROM account
            INNER JOIN users
            ON account.user_id = users.id
            WHERE users.email = :email;
            ';

            $sqlSum='SELECT 
            SUM(`sum`) AS sumExpenses,
            SUM(transfer_amount) as sumIncome
            FROM account
            INNER JOIN users
            ON account.user_id = users.id
            WHERE users.email = :email;
            ';
        } else if(!empty($_GET['filter']) && $_GET['filter'] === 'date') {
            $sql = 'SELECT *
            FROM account
            INNER JOIN users
            ON account.user_id = users.id
            WHERE users.email = :email
            ORDER BY account.date DESC, account.date_transfer DESC;
            ';

            $sqlSum='SELECT 
            SUM(`sum`) AS sumExpenses,
            SUM(transfer_amount) as sumIncome
            FROM account
            INNER JOIN users
            ON account.user_id = users.id
            WHERE users.email = :email
            ORDER BY account.date DESC, account.date_transfer DESC;
            ';    
        } else if(!empty($_GET['filter']) && $_GET['filter'] === 'title') {
            $sql = 'SELECT *
            FROM account
            INNER JOIN users
            ON account.user_id = users.id
            WHERE users.email = :email
            ORDER BY account.title ASC, account.title_transfer ASC;
            ';

            $sqlSum='SELECT 
            SUM(`sum`) AS sumExpenses,
            SUM(transfer_amount) as sumIncome
            FROM account
            INNER JOIN users
            ON account.user_id = users.id
            WHERE users.email = :email
            ORDER BY account.title ASC, account.title_transfer ASC;
            ';

        } else if(!empty($_GET['filter']) && $_GET['filter'] === 'sum') {
            $sql = 'SELECT *
            FROM account
            INNER JOIN users
            ON account.user_id = users.id
            WHERE users.email = :email
            ORDER BY account.sum DESC;
            ';

            $sqlSum='SELECT 
            SUM(`sum`) AS sumExpenses,
            SUM(transfer_amount) as sumIncome
            FROM account
            INNER JOIN users
            ON account.user_id = users.id
            WHERE users.email = :email
            ORDER BY account.sum DESC;
            ';

        } else if(!empty($_GET['filter']) && $_GET['filter'] === 'today') {
            $sql = "SELECT *
            FROM account 
            INNER JOIN users
            ON account.user_id = users.id
            WHERE (account.`date` BETWEEN '$today' AND '$today'
            OR account.date_transfer BETWEEN '$today' AND '$today')
            AND users.email = :email;";

            $sqlSum="SELECT 
            SUM(`sum`) AS sumExpenses,
            SUM(transfer_amount) as sumIncome
            FROM account
            INNER JOIN users
            ON account.user_id = users.id
            WHERE (account.`date` BETWEEN '$today' AND '$today'
            OR account.date_transfer BETWEEN '$today' AND '$today')
            AND users.email = :email;
            ";    

        } else if(!empty($_GET['filter']) && $_GET['filter'] === 'yesterday') {
            $sql = "SELECT *
            FROM account 
            INNER JOIN users
            ON account.user_id = users.id
            WHERE (account.`date` BETWEEN '$yesterday' AND '$yesterday'
            OR account.date_transfer BETWEEN '$yesterday' AND '$yesterday')
            AND users.email = :email;";

            $sqlSum="SELECT 
            SUM(`sum`) AS sumExpenses,
            SUM(transfer_amount) as sumIncome
            FROM account
            INNER JOIN users
            ON account.user_id = users.id
            WHERE (account.`date` BETWEEN '$yesterday' AND '$yesterday'
            OR account.date_transfer BETWEEN '$yesterday' AND '$yesterday')
            AND users.email = :email;
            ";        
        } else if(!empty($_GET['filter']) && $_GET['filter'] === 'week') {
            $sql = "SELECT *
            FROM account 
            INNER JOIN users
            ON account.user_id = users.id
            WHERE (account.`date` BETWEEN '$lastWeek' AND '$today'
            OR account.date_transfer BETWEEN '$lastWeek' AND '$today')
            AND users.email = :email;";

            $sqlSum="SELECT 
            SUM(`sum`) AS sumExpenses,
            SUM(transfer_amount) as sumIncome
            FROM account
            INNER JOIN users
            ON account.user_id = users.id
            WHERE (account.`date` BETWEEN '$lastWeek' AND '$today'
            OR account.date_transfer BETWEEN '$lastWeek' AND '$today')
            AND users.email = :email;
            ";   

        } else if(!empty($_GET['filter']) && $_GET['filter'] === 'month') {
            $sql = "SELECT *
            FROM account 
            INNER JOIN users
            ON account.user_id = users.id
            WHERE (account.`date` BETWEEN '$firstDayOfMonth' AND '$today'
            OR account.date_transfer BETWEEN '$firstDayOfMonth' AND '$today')
            AND users.email = :email;";

            $sqlSum="SELECT 
            SUM(`sum`) AS sumExpenses,
            SUM(transfer_amount) as sumIncome
            FROM account
            INNER JOIN users
            ON account.user_id = users.id
            WHERE (account.`date` BETWEEN '$firstDayOfMonth' AND '$today'
            OR account.date_transfer BETWEEN '$firstDayOfMonth' AND '$today')
            AND users.email = :email;
            ";       
        }
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':email', $userEmail, PDO::PARAM_STR);
        $pdoStatement->execute();
        $filterList = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Account');

        $pdoStatementSum = $pdo->prepare($sqlSum);
        $pdoStatementSum->bindValue(':email', $userEmail, PDO::PARAM_STR);
        $pdoStatementSum->execute();
        $filterSum = $pdoStatementSum->fetchAll(PDO::FETCH_ASSOC);
        
        return [
            'filterList' => $filterList, 
            'filterSum' => $filterSum
        ];
    }
}