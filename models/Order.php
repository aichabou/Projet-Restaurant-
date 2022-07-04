<?php

declare(strict_types=1);

namespace models;

use config\DataBase;

class Order extends DataBase
{
    private $connexion;
    
    public function __construct()
    {
        $this -> connexion = $this -> getConnexion();
    }
    
    // méthodes 
    public function addOrder(int $id_client,float $total):int
    {
        $query = $this -> connexion -> prepare('
        
                                                INSERT INTO `commandes_clients`(
                                                    `id_client`,
                                                    `prix_total`,
                                                    `date`
                                                    )
                                                VALUES(
                                                    ?,
                                                    ?,
                                                    NOW()
                                                )
                                                ');
        
        $query -> execute([$id_client,$total]);
        
        $id_cmd = $this -> connexion -> lastInsertId();
        
        return (int)$id_cmd;
    }
    
    public function addOrderDetails(int $id_cmd,int $id_meal,int $qte,float$prix_vente):bool
    {
        $query = $this -> connexion -> prepare('
        
                                                INSERT INTO `lignes_commandes`(
                                                    `id_cmd`,
                                                    `id_meal`,
                                                    `qte`,
                                                    `prix_vente`
                                                )
                                                VALUES(
                                                    ?,
                                                    ?,
                                                    ?,
                                                    ?
                                                )
                                                ');
        
        $test = $query -> execute([$id_cmd,$id_meal,$qte,$prix_vente]);
        
        return $test;
    }
}










