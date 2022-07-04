<?php
declare(strict_types=1);

namespace controllers;

use controllers\SecurityController;
use models\Booking;

// require "models/Booking.php";

class BookingController extends SecurityController
{
    private $booking;
    
    public function __construct()
    {
        $this -> booking = new Booking();
    }
    
    public function booking():void
    {
        if($this -> isConnect())
        {
            //1- afficher le form de resa 
            $template = "booking/booking";
            
            // 2- lancer la resa dans la BDD
            if(isset($_POST['dateResa'])&& !empty($_POST['dateResa']) && isset($_POST['booking_hour'])&& !empty($_POST['booking_hour']))
            {
                $date = htmlspecialchars($_POST['dateResa']." ".$_POST['booking_hour'].":".$_POST['booking_min']);//yyyy-mm-dd h:m:s
                $nbrCouverts = (int)htmlspecialchars($_POST['nb_couverts']);
                $id_client = $_SESSION['user']["id_user"];
                
                $test = $this -> booking -> insertBooking($id_client,$date,$nbrCouverts);
                
                if($test)
                {
                   $message = "la reservation est acceptée"; 
                   header('location:index.php?action=booking&message='.$message);
                }
                else
                {
                    $message = "une erruer SQL est survenue";
                }
            }
            require "views/layout.phtml";
        }
        else
        {
            header('location:index.php?action=connexion');
            exit();
        }
    }
}





