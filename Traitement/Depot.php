<?php
if(!isset($mobile)){
    session_start();
    include("../Modele/DB.php");
    include("../Modele/ObjetCollector.php");
    $objet = new ObjetCollector(); 
}
if($_GET["acte"] =="suppr"){
    $DE_No = $_GET["DE_No"];
    $depot = new DepotClass($DE_No,$objet->db);
    $depot->delete();
    header('Location: ../indexMVC.php?module=3&action=10');
}
?>
