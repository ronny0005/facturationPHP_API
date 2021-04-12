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
class PlanComptable {
    public function doAction($action) {
                $objet = new ObjetCollector();
        $protection = new ProtectionClass("","",$objet->db);
        if(isset($_SESSION["login"]))
            $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"],$objet->db);
        if($protection->Prot_No!=""){
            switch($action) {
                    case 1 : 
                        $this->Plan_comptable(); //rechercher un étudiant par domaine d'activité 
                        break;
                    case 2 : 
                        $this->Creation_Plan_comptable(); //rechercher un étudiant par domaine d'activité 
                        break;
                    case 3 : 
                        $this->Plan_analytique(); //rechercher un étudiant par domaine d'activité 
                        break;
                    case 4 : 
                        $this->Creation_Plan_analytique(); //rechercher un étudiant par domaine d'activité 
                        break;
                    case 5 : 
                        $this->Taxe(); //rechercher un étudiant par domaine d'activité 
                        break;
                    case 6 : 
                        $this->Creation_Taxe(); //rechercher un étudiant par domaine d'activité 
                        break;
                    case 7 : 
                        $this->Journaux(); //rechercher un étudiant par domaine d'activité 
                        break;
                    case 8 : 
                        $this->Creation_Journaux(); //rechercher un étudiant par domaine d'activité 
                        break;
                    case 9 : 
                        $this->Banque(); //rechercher un étudiant par domaine d'activité 
                        break;
                    case 10 : 
                        $this->Creation_Banque(); //rechercher un étudiant par domaine d'activité 
                        break;
                    case 11 : 
                        $this->ModeReglement(); //rechercher un étudiant par domaine d'activité 
                        break;
                    case 12 : 
                        $this->Creation_ModeReglement(); //rechercher un étudiant par domaine d'activité 
                        break;
                    case 13 : 
                        $this->Liste_journauxExercice(); //rechercher un étudiant par domaine d'activité 
                        break;
                    case 14 : 
                        $this->Saisie_journauxExercice(); //rechercher un étudiant par domaine d'activité 
                        break;
                case 15 :
                    $this->Controle_de_caisse(); //rechercher un étudiant par domaine d'activité
                    break;
                case 16 :
                    $this->mise_a_jour_comptable(); //rechercher un étudiant par domaine d'activité
                    break;
                case 17 :
                    $this->mise_a_jour_analytique(); //rechercher un étudiant par domaine d'activité
                    break;
                case 18 :
                    if($protection->PROT_Right==1 || ($protection->PROT_CLOTURE_CAISSE!=2))
                        $this->cloture_caisse();
                    else
                        header('Location: accueil');
                    break;
                case 19 :
                    $this->interrogationTiers(); //rechercher un étudiant par domaine d'activité
                    break;
                case 20 :
                    if($protection->PROT_Right==1 || ($protection->PROT_CLOTURE_CAISSE!=2))
                        $this->cloture_comptable();
                    else
                        header('Location: accueil');
                    break;
                default :
                    $this->Plan_comptable();
            }
        } else
            header('Location: connexion');
    }

    public function Plan_comptable() {
        include("pages/Structure/PlanComptable/PlanComptable.php");
    }

    public function interrogationTiers() {

        $objet = new ObjetCollector();
        $depot=$_SESSION["DE_No"];
        $annee = 2020;//$_SESSION["annee"];
        $protected = 0;
        $val=0;
        $action=0;
        $module=0;
        $typeInterrogation="Tiers";
        if(isset($_GET["action"])) $action = $_GET["action"];
        if(isset($_GET["module"])) $module = $_GET["module"];

        if(isset($_GET["type"]))
            $typeInterrogation=$_GET["type"];
        $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
        $compteg = new CompteGClass(0,$objet->db);
        $journal = new JournalClass("");
        $listItem = $journal->getSaisieJournalExercice("",0,$annee,"-1","","",0,"-1");
        include("pages/Structure/PlanComptable/InterrogationTiers.php");
    }

    public function Creation_Plan_comptable() {
        include("pages/Structure/PlanComptable/CreationPlanComptable.php");
    }
    
    public function Plan_analytique() {
        include("pages/Structure/PlanComptable/PlanAnalytique.php");
    }
    public function Creation_Plan_analytique() {
        include("pages/Structure/PlanComptable/CreationPlanAnalytique.php");
    }
    public function Taxe() {
        include("pages/Structure/PlanComptable/Taxe.php");
    }
    public function Creation_Taxe() {
        include("pages/Structure/PlanComptable/CreationTaxe.php");
    }
    public function Journaux() {
        include("pages/Structure/PlanComptable/Journaux.php");
    }
    public function Creation_Journaux() {
        include("pages/Structure/PlanComptable/CreationJournaux.php");
    }
    public function Banque() {
        include("pages/Structure/PlanComptable/Banque.php");
    }
    public function Creation_Banque() {
        include("pages/Structure/PlanComptable/CreationBanque.php");
    }
    public function ModeReglement() {
        include("pages/Structure/PlanComptable/ModeReglement.php");
    }
    public function Creation_ModeReglement() {
        include("pages/Structure/PlanComptable/CreationModeReglement.php");
    }
    public function Liste_journauxExercice() {
        include("pages/Structure/PlanComptable/Liste_journauxExercice.php");
    }
    public function Saisie_journauxExercice() {
        include("pages/Structure/PlanComptable/SaisieJournalExercice.php");
    }
    public function Controle_de_caisse() {
        include("pages/Structure/PlanComptable/Controle_de_caisse.php");
    }
    public function mise_a_jour_comptable() {
        include("pages/Structure/PlanComptable/Mise_a_jour_comptable.php");
    }
    public function mise_a_jour_analytique() {
        include("pages/Structure/PlanComptable/mise_a_jour_analytique.php");
    }
    public function cloture_caisse() {
        include("settings.php");
        include("pages/Structure/PlanComptable/clotureCaisse.php");
    }
    public function cloture_comptable() {
        include("settings.php");
        include("pages/Structure/PlanComptable/clotureComptable.php");
    }

}
?>
