<?php
declare(strict_types=1);

namespace controllers;

use models\Meals;
use controllers\SecurityController;

// require "models/Meals.php";

class MealsController extends SecurityController
{
    private $meal;
    
    public function __construct()
    {
        $this -> meal = new Meals();
    }
    
    public function listMeals():void
    {
        // appel au model 
        $meals = $this -> meal -> getMeals();
        // passer par le template pour afficher 
        $template ="home";
        require "views/layout.phtml";
    }
    
    public function addMeal():void
    {
        if($this -> isConnectAdmin())
        {
            $template = "meal/addMeal";
            
            if(isset($_POST['ajout_nom']) && !empty($_POST['ajout_nom']) && isset($_POST['description']) && !empty($_POST['description']) && isset($_FILES['photo']['name']) && !empty($_FILES['photo']['name']) && isset($_POST['prix_vente']) && !empty($_POST['prix_vente']))
            {
                $name = htmlspecialchars($_POST['ajout_nom']);
                $description = htmlspecialchars($_POST['description']);
                $photo = htmlspecialchars($_FILES['photo']['name']);
                $prix = (int)htmlspecialchars($_POST['prix_vente']);
                
                $test = $this -> meal -> insertMeal($name, $description, $photo, $prix);
                
                if($test)
                {
                    // le code pour télécharger une image dans le dossier 
                    $uploads_dir = 'views/images/meals';
          			$tmp_name = $_FILES["photo"]["tmp_name"];
          			$name = basename($_FILES["photo"]["name"]);
          			$load = move_uploaded_file($tmp_name, "$uploads_dir/$name");
          			
          			if($load)
          			{
          			    $message = "Le meal à été correctement inséré";
                        header('location:index.php?action=addMeal&message='.$message);
                        exit();
          			}
                    
                }
                else
                {
                    $message = "une erreur serveur SQL est survenue";
                }
            }
            require 'views/layout.phtml';
        }
        else
        {
            header('location:index.php');
            exit();
        }
    }
    
    public function modifMeal()
    {
        if($this -> isConnectAdmin())
        {
            $template = "meal/listeMeals";
            
            $meals = $this -> meal -> getMeals();
    
            if(array_key_exists("idMeal",$_GET))
            {
                $meal = $this -> meal ->getMealByID($_GET['idMeal']);
            }
            elseif(isset($_POST['ajout_nom']) && !empty($_POST['ajout_nom']) && isset($_POST['description']) && !empty($_POST['description']) && isset($_POST['prix_vente']) && !empty($_POST['prix_vente']))
            {
                var_dump($_POST);
                $name = htmlspecialchars($_POST['ajout_nom']);
                $description = htmlspecialchars($_POST['description']);
                $photo = htmlspecialchars($_FILES['photo']['name']);
                $prix = (int)htmlspecialchars($_POST['prix_vente']);
                $idMeal = (int)htmlspecialchars($_POST['idMeal']);
                
                if(isset($_FILES['photo']['name']) && !empty($_FILES['photo']['name']))
                {
                    //lancer la méthode de modification 
                    $testimg = $this -> meal -> updateMeal($name,$description,$photo,$prix,$idMeal);
                    
                    if($testimg)
                    {
                        // le code pour télécharger une image dans le dossier 
                        $uploads_dir = 'views/images/meals';
              			$tmp_name = $_FILES["photo"]["tmp_name"];
              			$name = basename($_FILES["photo"]["name"]);
              			$load = move_uploaded_file($tmp_name, "$uploads_dir/$name");
                  		
                  		if($load)
                  		{
                  		    $message = "Le repas à bien été modifié";
                            header("location:index.php?action=modifMeal&message=".$message);
                  		}
                    }
                    else
                    {
                        $message = " erreur sql est survenue";
                        header("location:index.php?action=modifMeal&message=".$message);
                    }
                    
                }
                else
                {
                    $test = $this -> meal -> updateMealWhithOutPicture($name,$description,$prix,$idMeal);
                    if($test)
                    {
                        $message = "Le repas à bien été modifié";
                        header("location:index.php?action=modifMeal&message=".$message);
                    }
                    else
                    {
                        $message = " erreur sql est survenue";
                        header("location:index.php?action=modifMeal&message=".$message);
                    }
                }
            }
            require "views/layout.phtml";
        }
        else
        {
            header('location:index.php');
            exit();
        }
    }
    
    public function suppMeal()
    {
        if($this -> isConnectAdmin())
        { 
            if(array_key_exists('idMeal',$_GET))
            {
                $meal = $this -> meal -> getMealByID((int)$_GET['idMeal']);
                $test = $this -> meal -> deleteMeal((int)$_GET['idMeal']);
                
                if($test)
                {
                    $fichier = 'views/images/meals/'.$meal['Photo'];
                    $img = unlink($fichier);
                    if($img)
                    {
                        $message = "Le repas à bien été supprimé";
                        header("location:index.php?action=modifMeal&message=".$message);
                        exit();
                    }
                    else
                    {
                        $message = "erreur suppression";
                        header("location:index.php?action=modifMeal&message=".$message);
                        exit(); 
                    }
                }
            }
        }
        else
        {
            header('location:index.php');
            exit();
        }
    }
}














