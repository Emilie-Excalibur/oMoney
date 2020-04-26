<?php

namespace App\Models;
use App\Utils\Database;
use PDO;

class User extends CoreModel {
    private $name;
    private $email;
    private $password;
    private $picture;


    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of picture
     */ 
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set the value of picture
     *
     * @return  self
     */ 
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Récupère les informations de tous les utilisateurs de la BDD
     *
     * @return User[]
     */
    public static function findAll() {
        $pdo = Database::getPDO();

        $sql = 'SELECT * FROM users;';

        $pdoStatement = $pdo->query($sql);
        $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\User');
        return $result;
    
    }

    /**
     * Recupère les informations de l'utilisateur connecté 
     * grâce à son adresse email unique dans la BDD
     *
     * @return User[]
     */
    public static function findByMail($email) {
        // Insertion des données dans la BDD
        $pdo = Database::getPDO();

        // Récupère les infos de l'utilisateur connecté
        $sql = 'SELECT * 
            FROM `users`
            WHERE `email` = :email';

        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':email', $email, PDO::PARAM_STR);

        $pdoStatement->execute();
        $result = $pdoStatement->fetchObject(self::class);
        return $result;
    }

    public static function findByName($name) {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM users WHERE `name`= :name';

        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':name', $name, PDO::PARAM_STR);
        $pdoStatement->execute();
        $users = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\User');

        return $users;
    }

    public static function findByNameAndPassword($name, $password) {
        $pdo = Database::getPDO();
        $sql = 'SELECT * 
        FROM users 
        WHERE `name` = :name
        AND `password` = :password;';

        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':name', $name, PDO::PARAM_STR);
        $pdoStatement->bindValue(':password', $password, PDO::PARAM_STR);

        $pdoStatement->execute();

        $result = $pdoStatement->fetchObject(self::class);
        return $result;
    }

    /**
     * Ajoute un nouvel utilisateur dans la BDD
     *
     * @return bool
     */
    public function insert() {
        $pdo = Database::getPDO();
        $sql = 'INSERT INTO `users` (
            `name`,
            `email`,
            `password`,
            `picture`,
            `created_at`
        ) VALUES (
            :name,
            :email,
            :password,
            :picture,
            NOW()
        )';

        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':name', $this->name, PDO::PARAM_STR);
        $pdoStatement->bindValue(':email', $this->email, PDO::PARAM_STR);
        $pdoStatement->bindValue(':password', $this->password, PDO::PARAM_STR);
        $pdoStatement->bindValue(':picture', $this->picture, PDO::PARAM_STR);

        $executed = $pdoStatement->execute();
        $insertedRows = $pdoStatement->rowCount();

        if ($executed && $insertedRows === 1) {
            $this->id = $pdo->lastInsertId();
            return true;
        }
        return false;
    }


    /**
     * Modifie les informations de l'utilisateur connecté dans la BDD
     *
     * @return bool
     */
    public function update() {
        $pdo = Database::getPDO();

        $sql ='UPDATE `users`
        SET
            `name` = :name,
            `email` = :email,
            `updated_at` = NOW()
        WHERE `email` = :oldEmail;
        ';

        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':name', $this->name, PDO::PARAM_STR);
        $pdoStatement->bindValue(':email', $this->email, PDO::PARAM_STR);
        $pdoStatement->bindValue(':oldEmail', $_SESSION['connectedUser']->getEmail(), PDO::PARAM_STR);

        $executed = $pdoStatement->execute();
        $updatedRows = $pdoStatement->rowCount();

        if($executed && $updatedRows === 1) {
            return true;
        }
        return false;
    }

    /**
     * Modifie dans la BDD le mot de passe de l'utilisateur connecté
     *
     * @param [string] $userEmail
     * @return bool
     */
    public function updatePassword($userEmail) {
        $pdo = Database::getPDO();

        $sql = 'UPDATE users 
        SET 
            `password` = :password,
            updated_at = NOW()
        WHERE email = :email;';

        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':password', $this->password, PDO::PARAM_STR);
        $pdoStatement->bindValue(':email', $userEmail, PDO::PARAM_STR);

        $executed = $pdoStatement->execute();
        $updatedRows = $pdoStatement->rowCount();

        if($executed && $updatedRows === 1) {
            return true;
        }
        return false;
    }
}