<?php
declare(strict_types=1);

namespace models;

use config\DataBase;

class Booking extends DataBase
{
    
    private $connexion;
    
    public function __construct()
    {
        $this -> connexion = $this -> getConnexion();
    }
    
    public function insertBooking(int $id_client,string $date, int $nbrCouverts):bool
    {
        $query = $this -> connexion -> prepare('
                                                INSERT INTO `reservations`(
                                                        `Id_client`,
                                                        `Date`,
                                                        `Nb_couverts`
                                                        )
                                                VALUES(
                                                        ?,
                                                        ?,
                                                        ?
                                                        )
                                                ');
        $test = $query -> execute([$id_client,$date,$nbrCouverts]);
        
        return $test;
    }
}