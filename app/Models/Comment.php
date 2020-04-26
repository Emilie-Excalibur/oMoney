<?php

namespace App\Models;
use App\Models\CoreModel;
use App\Utils\Database;
use PDO;

class Comment extends CoreModel
{
    private $name;
    private $content;

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
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Récupère tous les commentaire
     *
     * @return Comment[]
     */
    public static function findAll() {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `comment` ORDER BY `created_at` DESC;';
        $pdoStatement = $pdo->query($sql);
        $commentList = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Comment');
        return $commentList;
    }

    /**
     * Ajoute un commentaire dans la BDD
     *
     * @return bool
     */
    public function insert() {
        $pdo = Database::getPDO();

        $sql = 'INSERT INTO `comment`(
                `name`, 
                `content`,
                `created_at`
        ) VALUES (
                :name, 
                :content,
                NOW()
        );';

        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':name', $this->name, PDO::PARAM_STR);
        $pdoStatement->bindValue(':content', $this->content, PDO::PARAM_STR);

        $executed = $pdoStatement->execute();
        $insertedRows = $pdoStatement->rowCount();

        if ($executed && $insertedRows === 1) {
            $this->id = $pdo->lastInsertId();
            return true;
        }
        return false;
    }


}