<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Menu
 *
 * @author Test
 */
class Mouvement {

    public function doAction($action) {
        $objet = new ObjetCollector();
        $protection = new ProtectionClass("","",$objet->db);
        if(isset($_SESSION["login"]))
            $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"],$objet->db);

        $docEntete = new DocEnteteClass(0,$objet->db);
        $typefac = "";
        if(isset($_GET["type"]))
            $typefac = $_GET["type"];
        $docEntete->setTypeFac($typefac);

        if($protection->Prot_No!=""){
            switch($action) {
                case 1 :
                    if($protection->PROT_Right==1 || ($docEntete->protectionFacture($protection))!=2)
                        $this->FactureMouvement();
                    else
                        header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 2 :
                    if($protection->PROT_Right==1 || ($docEntete->protectionFacture($protection))!=2)
                        $this->saisie_mvtTrsft_detail();
                    else
                        header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                default :
                    header('Location: indexMVC.php?module=1&action=1'); // On décide ce que l'on veut faire
            }
        } else 
            header('Location: index.php');
    }

    public function FactureMouvement() {
        include("settings.php");
        include("pages/Stock/Mouvement.php");
    }

    public function saisie_mvtTrsft_detail() {
        include("settings.php");
        include("pages/Stock/Mouvement_detail.php");
    }

}
?>
