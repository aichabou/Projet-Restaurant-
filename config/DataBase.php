<?php
declare(strict_types=1);

namespace config;

class DataBase
{
    // attributs 
    private const SERVEUR = "db.3wa.io";
    private const USER = "aichabouchaikh";
    private const MDP = "4637d20ffa368118e2d8a18f6e1c0d9b";
    private const BDD = "aichabouchaikh_restaurant";
    private $connexion;
    
    //méthodes 
    public function getConnexion(): ?\PDO
    {
        $this -> connexion = null;
        try
        {
            $this -> connexion = new \PDO("mysql:host=".self::SERVEUR.";dbname=".self::BDD,self::USER,self::MDP);
            // gestion des accents 
            $this -> connexion -> exec("SET CHARACTER SET utf8");// -> appel une méthode d'une classe 
            
            // var_dump($connexion);
        }
        catch(Exception $message)
        {
            echo ' une erruer au moment de la connexion BDD : '.$message->getMessage();
        }
        
        return $this -> connexion;
    }
}

// vérifier la connexion 
// $database = new DataBase();
// var_dump($database -> getConnexion());