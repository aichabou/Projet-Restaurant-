<?php
declare(strict_types=1);

namespace controllers;

use controllers\SecurityController;
use models\Admin;

// require "models/Booking.php";

class AdminController extends SecurityController
{
    private $admin;
    
    public function __construct()
    {
        $this -> admin = new Admin();
    }
    
    //méthodes 
    
    public function connexionAdmin()
    {
        $template = "admin/connexionAdmin";
        
        if(isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password']))
        {
            $mail = htmlspecialchars($_POST['email']);
            $mdp = htmlspecialchars($_POST['password']);
            
            $admin = $this -> admin -> getAdminByEmail($mail);
            
            if($admin)
            {
                //mot de passe 
                if(password_verify($mdp,$admin['Mdp']))
                {
                    $_SESSION['administrateur']['nom'] = $admin['Prenom']." ".$admin['Nom'];
                    $_SESSION['administrateur']['id_admin'] = $admin['id'];
                    
                }
                else
                {
                    $message = "votre mot de passe est incorrect";
                }
            }
            else
            {
                $message = "votre compte n'existe pas ";
            }
        }
        require "views/layout.phtml";
    }
    
    
}









