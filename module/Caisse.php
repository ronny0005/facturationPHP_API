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
class Caisse {

    public function doAction($action) {
        $objet = new ObjetCollector();
        $protection = new ProtectionClass("","",$objet->db);
        if(isset($_SESSION["login"]))
            $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"],$objet->db);
        if($protection->Prot_No!=""){
            switch($action) {
                case 1 :
                    $this->Mouvement_caisse(); //rechercher un étudiant par domaine d'activité
                    break;
                case 2 :
                    $this->Mouvement_banque(); //rechercher un étudiant par domaine d'activité
                    break;
                    default : 
                        $this->Mouvement_caisse(); // On décide ce que l'on veut faire		
            }
        }else header('Location: index.php');
    }

    public function Mouvement_caisse() {
        include("settings.php");
        include("pages/Caisse/Mouvement_Caisse.php");
    }

    public function Mouvement_banque() {
        include("settings.php");
        include("pages/Caisse/Mouvement_Banque.php");
    }
   
}
?>
