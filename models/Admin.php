<?php
declare(strict_types=1);

namespace models;

use config\DataBase;

class Admin extends DataBase
{
    
    private $connexion;
    
    public function __construct()
    {
        $this -> connexion = $this -> getConnexion();
    }
    
    // méthodes
    public function getAdminByEmail($email)
    {
        $query = $this -> connexion -> prepare("
                                               SELECT
                                                    `id`,
                                                    `Email`,
                                                    `Mdp`,
                                                    `Prenom`,
                                                    `Nom`
                                                FROM
                                                    `admin`
                                                WHERE
                                                    Email = ?
                                                ");
        $query -> execute([$email]);
        $admin = $query -> fetch();
        
        return $admin;
    }
}