"use strict";
//*** déclaration des variables 

let commandes = [];
let recupDetail;
let total = 0;
//*** déclaration des fonctions 
function onAppelAjaxDetails()
{
    // récupérer le choix de l'utilisateur 
    let ID_repas = $("#repas").val();
    // console.log(ID_repas);
    $.getJSON("index.php?action=ajaxDetails","ID_repas="+ID_repas,onAfficheDetail);
}

function onAfficheDetail(details)
{
    recupDetail = details;
    // console.log(details);
    $("#details").empty();
    
    $("#details").append("<img src='views/images/meals/"+details.Photo+"'>");
    $("#details").append("<p>"+details.Description+"</p>");
    $("#details").append("<p>"+details.SalePrice+"</p>");
}

function addPanier(event)
{
    event.preventDefault();
    // quantité 
    let quantite = $("#quantite").val();
    console.log(quantite);
    commandes.push([recupDetail,quantite]);
    saveStorage();
    loadStorage();
    afficher();
}

function saveStorage()
{
    commandes = JSON.stringify(commandes);//js --> json 
    localStorage.setItem("panier",commandes);
}

function loadStorage()
{
    commandes = localStorage.getItem("panier");
    
    if(commandes == null)
    {
        commandes = [];
    }
    else
    {
        commandes = JSON.parse(commandes);//json --> js 
    }
}

function afficher()
{
    // console.log(commandes);
    $("#panier").empty();
    $("#total").empty();
    
    total = 0;
    for(let i=0;i<commandes.length;i++)
    {
        total = total + (commandes[i][0].SalePrice * commandes[i][1]);
        
        $("#panier").append("<tr><td>"+commandes[i][0].Name+"</td><td>"+commandes[i][0].SalePrice+"</td><td>"+commandes[i][1]+"</td><td>"+(commandes[i][0].SalePrice * commandes[i][1])+"</td></tr>");
    }
    
    $("#total").append('<tr><td> Total : '+total+'</td></tr>');
    
}

function onAppelAjaxValiderCMD()
{
    // js --> json 
    commandes = JSON.stringify(commandes);
    $.get("index.php?action=ajaxValider","commandes="+commandes+"&total="+total,validerCMD);
}

function validerCMD(reponse)
{
    // console.log(reponse);
    $("#confirm").html('<p>'+reponse+'</p>');
    
    // tout vider 
    localStorage.clear();
    commandes = [];
    total = 0;
}
//*** code principal 
document.addEventListener("DOMContentLoaded",function(){
    console.log('coucou');
    onAppelAjaxDetails();
    $("#repas").on('change',onAppelAjaxDetails);
    // le bouton ajouter au panier 
    $("#Ajouter").on('click',addPanier);
    // rafraichir le panier 
    loadStorage();
    afficher();
    $('#valider').on('click',onAppelAjaxValiderCMD);
});












