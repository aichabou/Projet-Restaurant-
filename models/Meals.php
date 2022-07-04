<?php
declare(strict_types=1);

namespace models;

use config\DataBase;

class Meals extends DataBase
{
    private $connexion;
    
    public function __construct()
    {
        $this -> connexion = $this -> getConnexion();
    }
    
    public function getMeals(): ?array
    {
        $meals = null;
        //1
        $query = $this -> connexion -> prepare("
                                                SELECT
                                                    `Id`,
                                                    `Name`,
                                                    `Description`,
                                                    `Photo`,
                                                    `SalePrice`
                                                FROM
                                                    meal
                                                 ");
        //2
        $query -> execute();
        //3
        $meals = $query -> fetchAll();
        // var_dump($meals);
        return $meals;
    }
    
    public function getMealByID($ID_repas): ?array
    {
        $meal = null;
        //1
        $query = $this -> connexion -> prepare("
                                                SELECT
                                                    `Id`,
                                                    `Name`,
                                                    `Description`,
                                                    `Photo`,
                                                    `SalePrice`
                                                FROM
                                                    meal
                                                WHERE Id = ?
                                                 ");
        //2
        $query -> execute([$ID_repas]);
        //3
        $meal = $query -> fetch();
        // var_dump($meals);
        return $meal;
    }
    
    public function insertMeal(string $name,string $description,string $photo,int $prix):bool
    {
        $query = $this -> connexion -> prepare("
                                                INSERT INTO `meal`(
                                                    `Name`,
                                                    `Description`,
                                                    `Photo`,
                                                    `SalePrice`
                                                )
                                                VALUES(
                                                    ?,
                                                    ?,
                                                    ?,
                                                    ?
                                                )
                                            ");
        //2
        $test = $query -> execute([$name,$description,$photo,$prix]);
        
        // var_dump($meals);
        return $test;
    }
    
    public function updateMeal(string $name,string $description,string $photo,int $prix,int $idMeal):bool
    {
        $query = $this -> connexion -> prepare("
                                                    UPDATE
                                                        `meal`
                                                    SET
                                                        `Name` = ?,
                                                        `Description` = ?,
                                                        `Photo` = ?,
                                                        `SalePrice` = ?
                                                    WHERE
                                                        Id = ?
                                                 ");
        //2
        $test = $query -> execute([$name,$description,$photo,$prix,$idMeal]);
        
        // var_dump($meals);
        return $test;
    }
    
    public function updateMealWhithOutPicture(string $name,string $description,int $prix,int $idMeal):bool
    {
        $query = $this -> connexion -> prepare("
                                                    UPDATE
                                                        `meal`
                                                    SET
                                                        `Name` = ?,
                                                        `Description` = ?,
                                                        `SalePrice` = ?
                                                    WHERE
                                                        Id = ?
                                                 ");
        //2
        $test = $query -> execute([$name,$description,$prix,$idMeal]);
        
        // var_dump($meals);
        return $test;
    }
    
    public function deleteMeal(int $idMeal):bool
    {
        $query = $this -> connexion -> prepare("
                                                    DELETE
                                                    FROM
                                                        `meal`
                                                    WHERE
                                                        Id = ?
                                                 ");
        //2
        $test = $query -> execute([$idMeal]);
        
        // var_dump($meals);
        return $test;
    }
}




















// tester 

// $meals = new Meals();
// var_dump($meals -> getMeals());