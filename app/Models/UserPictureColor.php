<?php

namespace App\Models;
use App\Models\CoreModel;
use App\Utils\Database;
use PDO;

class UserPictureColor extends CoreModel {
    private $color_name;

    /**
     * Get the value of color_name
     */ 
    public function getColorName()
    {
        return $this->color_name;
    }

    /**
     * Set the value of color_name
     *
     * @return  self
     */ 
    public function setColorName($color_name)
    {
        $this->color_name = $color_name;

        return $this;
    }

    /**
     * Récupère toutes les couleurs dans la BDD
     * et génère un index aléatoire
     * Afin de récupérer une couleur aléatoire
     *
     * @return string (color Name)
     */
    public static function find() {
        $pdo = Database::getPDO();

        $sql = 'SELECT color_name FROM user_picture_color';
    
        $pdoStatement = $pdo->query($sql);
    
        $allColors = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\UserPictureColor');

        $randomColorIndex = rand(0, count($allColors) - 1);
    
        $randomColor = $allColors[$randomColorIndex]->getColorName();
    
        return $randomColor;
    }
}