<?php
include("../Modele/DB.php");
include("../Modele/Objet.php");
include("../Modele/ObjetCollector.php");
include("../Modele/ProtectionClass.php");

if(!isset($_POST["user"])) {
    header('Location: ../connexion-1');
    die();
}
if(isset($_POST["user"])) {
    $protection = new ProtectionClass("","");
    $protection = $protection->getApiJson("/connexion&protUser={$_POST["user"]}&pwd={$_POST["password"]}&jour={$_POST["jour"]}&heure={$_POST["heure"]}");
    $message = "";
    if(isset($protection->message))
        $message = $protection->message;
    if ($message!="")
        header('Location: ../connexion-1');

    session_start();
    $_SESSION["DE_No"] = 0;
    $_SESSION["DO_Souche"] = "";
    $_SESSION["CO_No"] = 0;
    $_SESSION["CA_No"] = 0;
    $_SESSION["login"] = $_POST["user"];
    $_SESSION["mdp"] = $_POST["password"];
    $_SESSION["id"] = $protection->prot_No;
    header('Location: ../accueil');
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>