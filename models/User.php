<?php
declare(strict_types=1);

namespace models;

use config\DataBase;

class User extends DataBase
{
    private $connexion;
    
    public function __construct()
    {
        $this -> connexion = $this -> getConnexion();
    }
    
    public function insertUser(string $name,string $firstName,string $birth_date,string $address,string $city,int $cp,int $tel,string $email,string $password):bool
    {
        $query = $this-> connexion -> prepare("
                                            INSERT INTO `compte_client`(
                                                `Nom`,
                                                `Prenom`,
                                                `Date_naissance`,
                                                `Adresse`,
                                                `Ville`,
                                                `Code_postal`,
                                                `Tel`,
                                                `Mail`,
                                                `Mot_de_passe`
                                                 )
                                            VALUES(
                                                ?,
                                                ?,
                                                ?,
                                                ?,
                                                ?,
                                                ?,
                                                ?,
                                                ?,
                                                ?
                                            )
                                            ");
        $result = $query -> execute(array($name,$firstName,$birth_date,$address,$city,$cp,$tel,$email,$password));
        return $result;
    }
    
    public function getUserByEmail($email):bool|array
    {
        $query = $this -> connexion -> prepare("
                                                SELECT
                                                    `Id_client`,
                                                    `Nom`,
                                                    `Prenom`,
                                                    Mot_de_passe
                                                FROM
                                                    `compte_client`
                                                WHERE
                                                    `Mail` = ?
                                                ");
        $query -> execute([$email]);
        $user = $query -> fetch();
        
        return $user;
    }
    
    
    
    
    
    
    
    
    
}