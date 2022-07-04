<?php

require "../config/DataBase.php";

use config\DataBase;
// vérifier la connexion 
$database = new DataBase();
$connexion = $database -> getConnexion();

// var_dump($connexion);

$query = $connexion -> prepare('INSERT INTO `admin`( `Email`, `Mdp`, `Prenom`, `Nom`)
                                    VALUES(
                                        ?,
                                        ?,
                                        ?,
                                        ?
                                    )'
                                );
                                
$test = $query -> execute(["live73@gmail.com",password_hash("pass123",PASSWORD_DEFAULT),"session","live73"]);

var_dump($test);