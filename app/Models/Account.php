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

        $sql = "INSERT INTO `account` (
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
                )";

        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);
        $pdoStatement->bindValue(':balance', $this->balance, PDO::PARAM_INT);
        $pdoStatement->bindValue(':date', $this->date, PDO::PARAM_STR);
        $pdoStatement->bindValue(':title', $this->title, PDO::PARAM_STR);
        $pdoStatement->bindValue(':sum', $this->sum, PDO::PARAM_INT);
 
        $executed = $pdoStatement->execute();
        $insertedRows = $pdoStatement->rowCount();

        if ($executed && $insertedRows === 1) {
            return true;
        }
        return false;
        
    }

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
}