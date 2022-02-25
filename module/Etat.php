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

class Etat {
    public $RapportsSSRS = "";

    public function __construct(){
        $objet = new ObjetCollector();
        $objet->db = new DB();
        $this->RapportsSSRS= str_replace("_DEV","",$objet->db->RapportsSSRS);
    }

    public function doAction($action) {
        $objet = new ObjetCollector();
        $protection = new ProtectionClass("","",$objet->db);
        if(isset($_SESSION["login"]))
            $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"],$objet->db);
        if($protection->Prot_No !=""){
            switch($action) {
                case 1 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_MVT_STOCK == 0))
                        $this->etatSSRS("Mouvement_de_stock");
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 2 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_INVENTAIRE_PREP == 0))
                        $this->etatSSRS("Inventaire_preparatoire");
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 3 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_MVT_STOCK == 0))
                        $this->etatSSRS("Equation_du_stock");
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 4 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_STAT_ARTICLE_PAR_ART == 0))
                        $this->etatSSRS("Statistique article par agence");
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 5 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_PALMARES_CLT==0))
                        $this->etatSSRS("Statistique client par agence");
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 6 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_RELEVE_ECH_CLIENT == 0))
                        $this->echeance_client();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 7 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_RELEVE_ECH_CLIENT == 0))
                        $this->etatSSRS("Règlement client");
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 8 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_RELEVE_ECH_CLIENT == 0))
                        $this->etatSSRS("Relevé compte client");
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 9 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_STAT_CAISSE_ARTICLE==0))
                        $this->etatSSRS("Etat caisse");
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 10 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_RELEVE_ECH_CLIENT == 0))
                        $this->etatSSRS("Etat des dettes");
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 11 :
                    if($protection->PROT_Right==1 || (1==1))
                        $this->etatSSRS("Statistique collaborateur par client");
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 12 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_LIVRE_INV == 0))
                        $this->livret_inventaire();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 13 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_STAT_COLLAB_PAR_ARTICLE == 0))
                        $this->etatSSRS("Statistique collaborateur par article");
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 14 :
                    if($protection->PROT_Right==1 || ($protection->PROT_RISQUE_CLIENT == 0))
                        $this->etatSSRS("Versement distant");
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 15 :
                    if($protection->PROT_Right==1 || ($protection->PROT_RISQUE_CLIENT == 0))
                        $this->etatSSRS("Versement bancaire");
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 16 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_STAT_CAISSE_ARTICLE==0))
                        $this->etatSSRS("Controle des reports de fond de caisse");
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 17 :
                    if($protection->PROT_Right==1 || (0==0))
                        $this->etat_dette_detail();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 18 :
                    if($protection->PROT_Right==1 || (0==0))
                        $this->stat_article_achatCA();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 19 :
                    if($protection->PROT_Right==1 ||  ($protection->PROT_ETAT_STAT_ARTICLE_PAR_ART==0))
                        $this->etatSSRS("Statistique des achats");
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 20 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_STAT_FRS==0))
                        $this->etatSSRS("Statistique article par fournisseur");
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 21 :
                    if($protection->PROT_Right==1 || (0==0))
                        $this->etatSSRS("Balance des tiers commercial");
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 22 :
                    if($protection->PROT_Right==1 || (0==0))
                        $this->ech_tiers();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 23 :
                    if($protection->PROT_Right==1 || (0==0))
                        $this->etatSSRS("Etat réaprovisionnement");
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 24 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_STAT_CAISSE_ARTICLE==0))
                        $this->etatSSRS("Caisse d'exploitation");
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 25 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_STAT_CAISSE_ARTICLE==0))
                        $this->etatSSRS("Transfert caisse");
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 26 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_RELEVE_ECH_CLIENT == 0))
                        $this->echeance_client2();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 27 :
                    if($protection->PROT_Right==1)
                        $this->etatSSRS("Stock_grand_depot");
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 28 :
                    $this->etatSSRS("Etat du compte du résultat");
                    break;
                case 29 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_STAT_ARTICLE_PAR_ART == 0))
                        $this->etatSSRS("Centrale_rap_article");
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 30 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_RELEVE_ECH_CLIENT == 0))
                        $this->etatSSRS("Echeance client age");
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 31 :
                    $this->etatSSRS("Ecriture comptable");
                    break;
                case 32 :
                    $this->etatSSRS("Grand livre tiers commercial");
                    break;
                case 33 :
                    $this->etatSSRS("Article Absent Boutique");
                    break;
                case 34 :
                    $this->etatSSRS("Articles dormants");
                    break;

                case 35 :
                    $this->etatSSRS("Balance analytique");
                    break;

                case 36 :
                    $this->etatSSRS("Balance des comptes");
                    break;

                case 37 :
                    $this->etatSSRS("Grand livre analytique");
                    break;
                case 38 :
                    $this->etatSSRS("Etat journal");
                    break;

                case 39 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_STAT_CAISSE_ARTICLE==0))
                        $this->etatSSRS("Statistique client par article");
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 40 :
                    $this->etatSSRS("Grand livre tiers");
                    break;
                case 41 :
                    $this->etatSSRS("Justificatif de solde a date");
                    break;
                case 42 :
                    $this->etatSSRS("Statistique tiers");
                    break;
                case 43 :
                    $this->etatSSRS("Stock magasin");
                    break;
                case 44 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_RELEVE_ECH_CLIENT == 0))
                        $this->echeance_fournisseur();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 45 :
                    $this->etatSSRS("Controle de caisse");
                    break;
                case 46 :
                    $this->etatSSRS("Etat des livraisons");
                    break;
                case 47 :
                    $this->etatSSRS("Etat de ventes inf au superprix");
                    break;
                case 48 :
                    $this->etatSSRS("Etat réaprovisionnement fournisseur");
                    break;
                case 49 :
                    $this->etatSSRS("Client en perte de vitesse");
                    break;
                case 50 :
                    $this->etatSSRS("Etat comparatif CA");
                    break;
                default :
                    $this->Mouvement_stk(); // On décide ce que l'on veut faire
            }
        } else
            header('Location: connexion');
    }

    public function stockMagasin(){
        include("settings.php");
        $query = "/{$this->RapportsSSRS}/Rapports/Stock magasin";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function controleDeCaisse(){
        include("settings.php");
        $query = "/{$this->RapportsSSRS}/Rapports/Controle de caisse";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function etatSSRS($nom){
        include("settings.php");
        $query = "/{$this->RapportsSSRS}/Rapports/$nom";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }
    public function Mouvement_stk() {
        include("settings.php");
        $query = "/".$this->RapportsSSRS."/Rapports/Mouvement_de_stock";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function echeance_client() {
        include("settings.php");
        $query = "/{$this->RapportsSSRS}/Rapports/Echeance client";//$_REQUEST["reportName"];
        $_SESSION["titleName"] = "Echéance client";
        if(isset($_POST["reportName"]))
            $query = $_POST["reportName"];//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function echeance_fournisseur() {
        include("settings.php");
        $query = "/{$this->RapportsSSRS}/Rapports/Echeance fournisseur";
        $_SESSION["titleName"] = "Echéance fournisseur";
        if(isset($_POST["reportName"]))
            $query = $_POST["reportName"];//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function echeance_client2() {
        include("settings.php");
        $query = "/".$this->RapportsSSRS."/Rapports/Echeance client";//$_REQUEST["reportName"];
        if(isset($_GET["typeTiers"]))
            if($_GET["typeTiers"]==1)
                $query = "/".$this->RapportsSSRS."/Rapports/Echeance fournisseur";//$_REQUEST["reportName"];
            else
                $query = "/".$this->RapportsSSRS."/Rapports/Echeance client";//$_REQUEST["reportName"];
        if(isset($_POST["reportName"]))
            $query = $_POST["reportName"];//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function etatCaisse() {
        include("settings.php");
        $query = "/".$this->RapportsSSRS."/Rapports/Etat caisse";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function etatDette() {
        include("settings.php");
        $query = "/".$this->RapportsSSRS."/Rapports/Etat des dettes";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
        //include("pages/Etat/etatDette.php");
    }

    public function livret_inventaire() {
        include("settings.php");
        $dateIndique = 1;
        $query = "/".$this->RapportsSSRS."/Rapports/Livre_d_inventaire";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function etat_dette_detail() {
        include("settings.php");
        //       $query = "/".$this->RapportsSSRS."/Rapports/Etat des dettes detail";//$_REQUEST["reportName"];
        ///       include("pages/Etat/etatSSRS.php");
        include("pages/Etat/etatDette_detail.php");
    }

    public function stat_article_achatCA() {
        include("settings.php");
        // $query = "/".$this->RapportsSSRS."/Rapports/Statistique des achats analytique";//$_REQUEST["reportName"];
        // include("pages/Etat/etatSSRS.php");
        include("pages/Etat/stat_article_achatCA.php");
    }

    public function ech_tiers() {
        include("settings.php");
        //$query = "/".$this->RapportsSSRS."/Rapports/Echeance client";//$_REQUEST["reportName"];
        //include("pages/Etat/etatSSRS.php");
        include("pages/Etat/ech_client.php");
    }


}
?>
