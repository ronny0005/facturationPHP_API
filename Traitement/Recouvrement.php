<?php
$login = "";
$machine_pc = "";
$latitude = 0;
$longitude = 0;
//if(!isset($mobile)){
session_start();
include("../Modele/DB.php");
include("../Modele/MailComplete.php");
include("../Modele/ObjetCollector.php");
include("../Modele/Objet.php");
include("../Modele/DocEnteteClass.php");
include("../Modele/DocLigneClass.php");
include("../Modele/ComptetClass.php");
include("../Modele/ReglementClass.php");
include("../Modele/CaisseClass.php");
include("../Modele/ArticleClass.php");
include("../Modele/ProtectionClass.php");
include("../Modele/ContatDClass.php");
    include("../Modele/CollaborateurClass.php");
    include("../Modele/LogFile.php");
$objet = new ObjetCollector();
if(isset($_SESSION["login"]))
    $login = $_SESSION["login"];
$machine_pc = "";
$mobile="";
//}

if(strcmp($_GET["acte"],"addReglement") == 0) {
    $protection = new ProtectionClass("", "");
    $protection->connexionProctectionByProtNo($_SESSION["id"]);
    $isSecurite = $protection->IssecuriteAdminCaisse($_GET["caisse"]);
    $reglementClass = new ReglementClass(0);
    $cloture = $reglementClass->journeeCloture($objet->getDate($_GET['dateRec']),$_GET['caisse']);
    $valAction = 2;
    $typeRegl = $_GET["typeRegl"];
    if ($typeRegl == "Fournisseur")
        $valAction = 4;
    if ($typeRegl == "Collaborateur")
        $valAction = 5;
    $caissier = $_GET['caissier'];
    if ($caissier == "")
        $caissier = 0;
    $ct_num = $_GET['client_ligne'];
    $dateReglementEntete_deb = $_GET["dateReglementEntete_deb"];
    $dateReglementEntete_fin = $_GET["dateReglementEntete_fin"];
    $ca_no = $_GET["caisse"];
    $type = $_GET["type"];
    if ($isSecurite == 1 && $cloture == 0) {
        $reglement = new ReglementClass(0, $objet->db);
        $mobile = 0;
        if (isset($_GET["mobile"]))
            $mobile = 1;
        $jo_num = $_GET["journal"];
        $rg_no_lier = $_GET["RG_NoLier"];
        $boncaisse = $_GET["boncaisse"];
        $libelle = $_GET['libelleRec'];
        $date = $objet->getDate($_GET['dateRec']);
        $modeReglementRec = $_GET["mode_reglementRec"];
        $montant = str_replace(" ", "", $_GET['montantRec']);
        $impute = $_GET['impute'];
        $RG_Type = $_GET['RG_Type'];
        $reglement->addReglement($mobile, $jo_num, $rg_no_lier, $ct_num
            , $ca_no, $boncaisse, $libelle, $caissier
            , $date, $modeReglementRec, $montant, $impute, $RG_Type, true, $typeRegl);
    }
//    header("Location: ../Reglement-$typeRegl-$caissier-$ct_num-$dateReglementEntete_deb-$dateReglementEntete_fin-$modeReglementRec-$jo_num-$ca_no-$type-$cloture");
        header("Location: ../indexMVC.php?module=1&action=$valAction&typeRegl=$typeRegl&caissier=$caissier&CT_Num=$ct_num&dateReglementEntete_deb=$dateReglementEntete_deb&dateReglementEntete_fin=$dateReglementEntete_fin&mode_reglement=0&journal=$jo_num&caisse=$ca_no&type=$type&cloture=$cloture");
}



?>
