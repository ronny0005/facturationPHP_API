<?php
include("../Modele/DB.php");
include("../Modele/Objet.php");
include("../Modele/ObjetCollector.php");
include("../Modele/ProtectionClass.php");
include("../Modele/EtatClass.php");
include("../Modele/DepotClass.php");
session_start();
$objet = new ObjetCollector();

if(isset($_SESSION["login"]))
    $login = $_SESSION["login"];

if(isset($_SESSION["mdp"]))
    $mdp = $_SESSION["mdp"];
$protection = new ProtectionClass($login, $mdp,$objet);
$admin=0;
    if($protection ->PROT_Administrator==1 || $protection ->PROT_Right==1)
        $admin=1;
    //$admin=$protection->PROT_Right;
    $vente=$protection->PROT_DOCUMENT_VENTE;
    $rglt=$protection->PROT_DOCUMENT_REGLEMENT;
    $flagPxRevient= $protection->PROT_PX_REVIENT;
    $flagPxAchat= $protection->PROT_PX_ACHAT;
    if($protection->ProfilName=="VENDEUR")
        $profil_caisse=1;
    if($protection->ProfilName=="COMMERCIAUX"  || $protection->ProfilName=="GESTIONNAIRE" || $protection->ProfilName=="VENDEUR")
        $profil_commercial=1;
    if($protection->ProfilName=="RAF" ||$protection->ProfilName=="GESTIONNAIRE" ||$protection->ProfilName=="SUPERVISEUR" )
        $profil_special =1;
    if($protection->ProfilName=="RAF")
        $profil_daf=1;
    if($protection->ProfilName=="SUPERVISEUR")
        $profil_superviseur=1;
    if($protection->ProfilName=="GESTIONNAIRE")
        $profil_gestionnaire=1;
$datedeb="";
$datefin="";
if(isset($_GET["datedeb"]))
    $datedeb=$_GET["datedeb"];
if(isset($_GET["datefin"]))
    $datefin=$_GET["datefin"];
$depot_no=0;
$cmp=0;
$rupture=0;
$clientdebut=0;
$clientfin=0;
$type_reg=0;
if(isset($_GET["rupture"]))
    $rupture=$_GET["rupture"];
if(isset($_GET["depot"]))
    $depot_no=$_GET["depot"];
$nomSociete="";
$result=$objet->db->requete($objet->getNumContribuable());
$rows = $result->fetchAll(PDO::FETCH_OBJ);
if($rows==null){
}
else{
    $nomSociete=$rows[0]->D_RaisonSoc;
}


$objet = new ObjetCollector();
$depot_no=0;
$famille=0;
$article=0;
$do_type=6;
$imprime=0;
$articledebut=0;
$articlefin=0;
$N_Analytique="0";
if(isset($_GET["N_Analytique"])) $N_Analytique=$_GET["N_Analytique"];
if(isset($_GET["datedebut"]) && !empty($_GET["datedebut"])) $datedeb=$objet->getDate($_GET["datedebut"]);
if(isset($_GET["datedeb"]) && !empty($_GET["datedeb"])) $datedeb=$objet->getDate($_GET["datedeb"]);
if(isset($_GET["datefin"]) && !empty($_GET["datefin"])) $datefin=$objet->getDate($_GET["datefin"]);
if(isset($_GET["articledebut"])) $articledebut=$_GET["articledebut"];
if(isset($_GET["articlefin"])) $articlefin=$_GET["articlefin"];
if(isset($_GET["depot"])) $depot_no=$_GET["depot"];
if(isset($_GET["famille"])) $famille=$_GET["famille"];
if(isset($_GET["article"])) $article=$_GET["article"];
if(isset($_GET["do_type"])) $do_type=$_GET["do_type"];


$type_tiers=0;
if(isset($_GET["type_tiers"]))
    $type_tiers=$_GET["type_tiers"];

$typeTiers=0;
if(isset($_GET["typeTiers"]))
    $typeTiers=$_GET["typeTiers"];


$cmp=0;
$rupture=0;
if(isset($_GET["rupture"])) $rupture=$_GET["rupture"];

$choix_inv=0;
if(isset($_GET["choix_inv"])) $choix_inv=$_GET["choix_inv"];


$client="0";
$caisse=0;
$type=0;
$treglement=0;
if(isset($_GET["client"])) $client=$_GET["client"];


if(isset($_GET["type"])) $type=$_GET["type"];
$facComptabilise = 0;
if(isset($_GET["facComptabilise"])) $facComptabilise =$_GET["facComptabilise"];
if(isset($_GET["caisse"])) $caisse=$_GET["caisse"];
if(isset($_GET["mode_reglement"])) $treglement=$_GET["mode_reglement"];




$clientdebut='';
$clientfin='';
$document='';
if(isset($_GET["clientdebut"])) $clientdebut=$_GET["clientdebut"];
if(isset($_GET["clientfin"])) $clientfin=$_GET["clientfin"];
if(isset($_GET["document"])) $document=$_GET["document"];

$type_reg=0;
if(isset($_GET["type_reg"])) $type_reg=$_GET["type_reg"];

$caisse_no=0;
$mode_reglement ="0";
$type_reglement =-1;
if(isset($_GET["caisse"]))
    $caisse_no=$_GET["caisse"];
if(isset($_GET["mode_reglement"]))
    $mode_reglement=$_GET["mode_reglement"];
if(isset($_GET["type_reglement"]))
    $type_reglement=$_GET["type_reglement"];

if(isset($_GET["CT_Num"])) $client = $_GET["CT_Num"];
?>