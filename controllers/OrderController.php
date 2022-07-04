<?php
declare(strict_types=1);

namespace controllers;

use controllers\SecurityController;
use models\Order;
use models\Meals;


class OrderController extends SecurityController
{
    private $order;
    private $meal;
    
    public function __construct()
    {
        $this -> order = new Order();
        $this -> meal = new Meals();
    }
    
    public function commander()
    { 
        if($this -> isConnect())
        {
            $template = "order/order";
            
            // récupérer la liste de tous les repas dans la BDD 
            $meals = $this -> meal -> getMeals();
            
            require "views/layout.phtml";
        }
        else
        {
            header('location:index.php?action=connexion');
            exit();
        }
    }
    
    public function ajaxDetails()
    {
        if($this -> isConnect())
        {
            if(array_key_exists('ID_repas',$_GET))
            {
                $ID_repas = $_GET['ID_repas'];
                
                $meal = $this -> meal -> getMealByID($ID_repas);
                
                // envoyé le resultat vers la requete ajax 
                echo json_encode($meal);
            }
        }
        else
        {
            header('location:index.php?action=connexion');
            exit();
        }
    }
    
    public function ajaxValider()
    {
        if($this -> isConnect())
        {
            if(array_key_exists('commandes',$_GET) && array_key_exists('total',$_GET))
            {
                $commandes = json_decode($_GET['commandes']);//json --> php
                
                // var_dump($commandes);
                
                $total = (float)$_GET['total'];
                
                $id_client = (int)$_SESSION['user']["id_user"];
                
                $id_cmd = (int) $this -> order -> addOrder($id_client,$total);
                
                // echo $id_cmd;
                
                foreach($commandes as $commande)
                {
                    $test = $this -> order ->  addOrderDetails($id_cmd,(int) $commande[0] -> Id ,(int) $commande[1],(float) $commande[0] -> SalePrice);
                }
                
                if($test)
                {
                    echo "Votre commande à bien été inserée ";
                }
                else
                {
                    echo "Une erreur serveur est survenue ";
                }
                
            }
        }
        else
        {
            header('location:index.php?action=connexion');
            exit();
        }
        
    }
}



















