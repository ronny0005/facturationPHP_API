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
class Admin {
    public $objet ;
    public $protection ;

    public function __construct()
    {
        $this->objet = new ObjetCollector();
        $this->protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"],$this->objet->db);
    }

    public function doAction($action) {
        $objet = new ObjetCollector();
        $protection = new ProtectionClass("","",$objet->db);
        if(isset($_SESSION["login"]))
            $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"],$objet->db);
        if($protection->Prot_No!=""){
            switch($action) {
            case 1 : 
                if($this->protection->PROT_Right==1) $this->Liste_User(); else header('Location: accueil');
                break;
            case 2 : 
                if($this->protection->PROT_Right==1) $this->Liste_Groupe(); else header('Location: accueil');
                break;
            case 3 : 
                if($this->protection->PROT_Right==1) $this->Nouveau_Groupe(); else header('Location: accueil');
                break;
            case 4 : 
                if($this->protection->PROT_Right==1) $this->Nouvel_User(); else header('Location: accueil');
                break;
            case 5 : 
                if($this->protection->PROT_Right==1) $this->Liste_Droit(); else header('Location: accueil');
                break;
            case 6 :
                if($this->protection->PROT_Right==1) $this->Code_Client(); else header('Location: accueil');
                break;
            case 7 :
                if($this->protection->PROT_Right==1) $this->Envoi_Mail(); else header('Location: accueil');
                break;
            case 8 :
                if($this->protection->PROT_Right==1) $this->Envoi_SMS(); else header('Location: accueil');
                break;
            case 9 :
                if($this->protection->PROT_Right==1) $this->Compte_SMS(); else header('Location: accueil');
                break;
            case 10 :
                if($this->protection->PROT_Right==1) $this->Config_acces(); else header('Location: accueil');
                break;
            case 11 :
                if($this->protection->PROT_Right==1) $this->Config_profilUtilisateur(); else header('Location: accueil');
                break;
            case 12 :
                if($this->protection->PROT_Right==1) $this->Deconnexion_totale(); else header('Location: accueil');
                break;
            case 13 :
                if($this->protection->PROT_Right==1) $this->Fusion_article(); else header('Location: accueil');
                break;
            case 14 :
                if($this->protection->PROT_Right==1) $this->Fusion_client(); else header('Location: accueil');
                break;
            case 15 :
                if($this->protection->PROT_Right==1) $this->Calendrier_connexion(); else header('Location: accueil');
                break;
            case 16 :
                if($this->protection->PROT_Right==1) $this->supprLigneMvt(); else header('Location: accueil');
                break;
            case 17 :
                if($this->protection->PROT_Right==1) $this->fixCatCompta(); else header('Location: accueil');
                break;
                default :
                if($this->protection->PROT_Right==1) $this->Liste_User(); else header('Location: accueil');
        }

        } else 
            header('Location: indexMVC.php');
    }

    public function Nouvel_User() {
        include("settings.php");
        include("pages/Admin/CreationUser.php");
    }
    public function supprLigneMvt() {
        include("pages/Admin/supprLigneMvt.php");
    }
    public function fixCatCompta() {
        include("pages/Admin/fixCatCompta.php");
    }
    
    public function Nouveau_Groupe() {
        include("pages/Admin/CreationGroupe.php");
    }

    public function Deconnexion_totale(){
        $this->protection->deconnexionTotale();
        header("location:indexMVC.php?connexion");
    }

    public function Liste_User() {
        include("pages/Admin/Liste_User.php");
    }
    
    public function Liste_Groupe() {
        include("pages/Admin/Liste_Groupe.php");
    }
    
    public function Liste_Droit() {
        include("pages/Admin/Liste_Droit.php");
    }

    public function Code_Client() {
        include("pages/Admin/CodeClient.php");
    }

    public function Envoi_Mail() {
        include("pages/Admin/Envoi_Mail.php");
    }

    public function Envoi_SMS() {
        include("pages/Admin/Envoi_Mail.php");
    }

    public function Config_acces() {
        include("pages/Admin/Config_Acces.php");
    }

    public function compte_SMS() {
        include("pages/Admin/Compte_SMS.php");
    }
    public function Config_profilUtilisateur() {
        include("pages/Admin/Config_profilUtilisateur.php");
    }
    public function Fusion_client() {
        include("pages/Admin/Fusion_client.php");
    }
    public function Fusion_article() {
        include("pages/Admin/Fusion_article.php");
    }



    public function Calendrier_connexion() {
        $action = 0;
        if (isset($_POST["user"]))
		{
			$protectionCalendar = new ProtectionClass("","");
            $protectionCalendar->connexionProctectionByProtNo($_POST["PROT_NoUser"]);
            if($protectionCalendar->PROT_UserProfil==0){
                $listUser = $protectionCalendar->listUserProfil();
                foreach ($listUser as $users){
                    $protectionCalendar->setCalendarUser($users->PROT_No);
				}
                $protectionCalendar->setCalendarUser($_POST["user"]);
			}else{
                $protectionCalendar->setCalendarUser($_POST["PROT_NoUser"]);
			}
		}
        include("pages/Admin/Calendrier_connexion.php");
    }




}	
?>
