<?php

declare(strict_types=1);

namespace controllers;

use models\User;
use controllers\SecurityController;

// require "models/User.php";

class UserController extends SecurityController
{
    private $user;
    
    public function __construct()
    {
        $this -> user = new User();
    }
    
    public function create_account()
    {
        $template = "user/create_account";
        
        if(isset($_POST['email'])&&!empty($_POST["email"]))
        {
            // vérifier l'existance du compte client 
            $mail = htmlspecialchars($_POST['email']);

            $user = $this -> user -> getUserByEmail($mail);
            
            if($user)
            {
                $message = "votre compte existe déja";
            }
            else
            {
                $name = htmlspecialchars($_POST['lastName']);
                $firstName = htmlspecialchars($_POST['firstName']);
                $birth_date = htmlspecialchars($_POST['birthYear']."-".$_POST['birthMonth']."-".$_POST['birthDay']);
                $address = htmlspecialchars($_POST['address']);
                $city = htmlspecialchars($_POST['city']);
                $cp = (int)htmlspecialchars($_POST['zipCode']);
                $tel = (int)htmlspecialchars($_POST['phone']);
                $email = htmlspecialchars($_POST['email']);
                $password = htmlspecialchars($_POST['password']);
                $password = password_hash($password,PASSWORD_DEFAULT);
                
                $test = $this -> user -> insertUser( $name, $firstName, $birth_date,$address, $city, $cp, $tel, $email, $password);
                
                if($test)
                {
                    $message ="Votre compte à bien été crée";
                    //redirection vers l'authentification 
                    header("location:index.php?action=connexion&message=".$message);
                }
                else
                {
                    $message = "Une erreur SQL est survenue";
                }
            }
        }
        require "views/layout.phtml";
    }
    
    public function connexion():void
    {
        $template ="user/connexion";
        
        if(isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password']))
        {
            $mail = htmlspecialchars($_POST['email']);
            $mdp = htmlspecialchars($_POST['password']);

            $user = $this -> user -> getUserByEmail($mail);
            
            if(!$user)
            {
                $message = "le compte n'existe pas";
            }
            else
            {
                if(password_verify($mdp,$user['Mot_de_passe']))
                {
                    $_SESSION['user']["nom"] = $user['Nom'];
                    $_SESSION['user']["prenom"] = $user['Prenom'];
                    $_SESSION['user']["id_user"] = $user['Id_client'];
                    
                    //redirection vers l'index 
                    header("location:index.php");
                }
                else
                {
                    $message ="Votre mot de passe est incorrect";
                }
            }
        }
        require "views/layout.phtml";
    }
    
    // public function isConnect():bool
    // {
    //     if(isset($_SESSION['user']))
    //     {
    //         return true;
    //     }
    //     else
    //     {
    //         return false;
    //     }
    // }
    
    public function deconnexion():void
    {
    	session_unset();
    	session_destroy();
    	header('Location:index.php');
    }
}








