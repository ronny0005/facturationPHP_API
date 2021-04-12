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
class Facturation {
    /*
    public function menu($protection,$type){
        if($type == "FactureVente"){
            if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_VENTE_FACTURE!=2))
                $this->ListeFacture();
        }
    }
    */
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

        if($protection->Prot_No !=""){
            switch($action) {
                    case 1 :
                        if($protection->PROT_Right==1 || ($docEntete->protectionFacture($protection)!=2))
                            $this->ListeFacture();
                        else
                            header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                        break;
                    case 2 :
                        if($protection->PROT_Right==1 || ($docEntete->protectionFacture($protection))!=2)
                            $this->Facture();
                        else
                            header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                        break;
                    default :
                            $this->ListeFacture(); // On décide ce que l'on veut faire
            }
        } else 
            header('Location: index.php');
    }

    public function ListeFacture() {
        include("settings.php");
        include("pages/ListeFacture.php");
    }
    public function Facture() {
        include("settings.php");
        include("pages/Vente/FactureVente.php");
    }
}
?>