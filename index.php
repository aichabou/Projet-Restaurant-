<?php 
declare(strict_types=1);

session_start();

use config\DataBase;
use controllers\MealsController;
use controllers\UserController;
use controllers\BookingController;
use controllers\OrderController;
use controllers\AdminController;
// require "config/DataBase.php";

//autoload
function chargerClasse($classe)
{
    $classe=str_replace('\\','/',$classe);      
    require $classe.'.php'; 
}

spl_autoload_register('chargerClasse'); //fin Autoload

$mealsController = new MealsController();
$userController = new UserController();
$bookingController = new BookingController();
$orderController = new OrderController();
$adminController = new AdminController();

if(array_key_exists("action",$_GET))
{
    switch($_GET['action'])
    {
        case "create_account":
            $userController -> create_account();
            break;
        case 'connexion':
            $userController -> connexion();
            break;
        case 'deconnexion':
            $userController -> deconnexion();
            break;
        case 'booking':
            $bookingController -> booking();
            break;
        case 'commander':
            $orderController -> commander();
            break;
        case 'ajaxDetails':
            $orderController -> ajaxDetails();
            break;
        case 'ajaxValider':
            $orderController -> ajaxValider();
            break;
        case 'connexionAdmin':
            $adminController -> connexionAdmin();
            break;
        case 'addMeal':
            $mealsController -> addMeal();
            break;
        case 'modifMeal':
            $mealsController -> modifMeal();
            break;
        case 'suppMeal':
            $mealsController -> suppMeal();
            break;
    }
}
else
{
    $mealsController -> listMeals();
}


