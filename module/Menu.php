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
class Menu {
    public function doAction($action) {
        $objet = new ObjetCollector();
        $protection = new ProtectionClass("","",$objet->db);
        if(isset($_SESSION["login"]))
            $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"],$objet->db);
        if($protection->Prot_No!=""){
            switch($action) {
                case 1 :
                    $this->Accueil();
                    break;
                case 2 :
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_REGLEMENT!=2)) $this->Recouvrement(); else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 3 :
                    if($protection->PROT_Right==1 || ($protection->PROT_SAISIE_INVENTAIRE!=2)) $this->Saisi_inventaire(); else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 4 :
                    if($protection->PROT_Right==1 || ($protection->PROT_SAISIE_REGLEMENT_FOURNISSEUR!=2)) $this->Recouvrement(); else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 5 :
                    if($protection->PROT_Right==1 || ($protection->PROT_GENERATION_RGLT_CLIENT!=2)) $this->Recouvrement(); else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 6 :
                    $this->Mot_de_passe();
                    break;
                default :
                    $this->Accueil(); // On décide ce que l'on veut faire
            }
        } else
            header('Location: index.php');
    }

    public function Accueil() {
        include("pages/Accueil.php");
    }
    
    public function Recouvrement() {
        include("settings.php");
        include("pages/Recouvrement.php");
    }

    public function Saisi_inventaire() {
        include("pages/saisie_inventaire.php");
    }

    public function Mot_de_passe() {
        include("pages/mot_de_passe.php");
    }
}	
?>