<?php
$objet = new ObjetCollector();
$datedeb=date("dmy");
$datefin=date("dmy");

if($admin==0){
    $depot = new DepotClass(0,$objet->db);
    $rows = $depot->getDepotUser($_SESSION["id"]);
    if(sizeof($rows)>0)
        $depot_no =$rows[0]->DE_No;
    else
        $depot_no = 0;
}else {
    $depot_no = 0;
}
$famille=0;
$article=0;
$do_type=6;
$imprime=0;
$articledebut=0;
$articlefin=0;
$N_Analytique="0";
$stockReel=0;
$siteMarchand = 2;
if(isset($_GET["siteMarchand"])) $siteMarchand=$_GET["siteMarchand"];
if(isset($_GET["N_Analytique"])) $N_Analytique=$_GET["N_Analytique"];
if(isset($_GET["datedebut"]) && !empty($_GET["datedebut"])) $datedeb=$_GET["datedebut"];
if(isset($_GET["datefin"]) && !empty($_GET["datefin"])) $datefin=$_GET["datefin"];
if(isset($_GET["articledebut"])) $articledebut=$_GET["articledebut"];
if(isset($_GET["articlefin"])) $articlefin=$_GET["articlefin"];
if(isset($_GET["depot"])) $depot_no=$_GET["depot"];
if(isset($_GET["famille"])) $famille=$_GET["famille"];
if(isset($_GET["article"])) $article=$_GET["article"];
if(isset($_GET["do_type"])) $do_type=$_GET["do_type"];
if(isset($_GET["stockReel"])) $stockReel=$_GET["stockReel"];
$type_tiers=0;
if(isset($_GET["type_tiers"]))
    $type_tiers=$_GET["type_tiers"];
$cmp=0;

$rupture=0;
/*if($admin==0)
    $rupture=1;
else
    $rupture=0;
*/
if(isset($_GET["rupture"])) $rupture=$_GET["rupture"];

$choix_inv=0;
if(isset($_GET["choix_inv"])) $choix_inv=$_GET["choix_inv"];


$client="0";
if($admin==0){
    $caisse = new CaisseClass(0,$objet->db);
    $rows = $caisse->getCaisseDepot($_SESSION["id"]);
    if($rows!=null)
        $caisse = $rows[0]->CA_No;
    else
        $caisse=0;

}else{
    $caisse=0;
}

$caisse_no=$caisse;
$type=0;
$treglement=0;
if(isset($_GET["client"])) $client=$_GET["client"];


if(isset($_GET["type"])) $type=$_GET["type"];
$facComptabilise = 0;
if(isset($_GET["facComptabilise"])) $facComptabilise =$_GET["facComptabilise"];
if(isset($_GET["caisse"])) $caisse=$_GET["caisse"];
if(isset($_GET["mode_reglement"])) $treglement=$_GET["mode_reglement"];




$clientdebut='0';
$libClientDebut = 'Tout';
$clientfin='0';
$libClientFin = 'Tout';
$document='';
if(isset($_GET["clientdebut"])) $clientdebut=$_GET["clientdebut"];
if(isset($_GET["ClientDebut"])) $clientdebut=$_GET["ClientDebut"];
if(isset($_GET["clientfin"])) $clientfin=$_GET["clientfin"];
if(isset($_GET["ClientFin"])) $clientfin=$_GET["ClientFin"];
if(isset($_GET["document"])) $document=$_GET["document"];

if($clientdebut!='0') {
    $compteClass = new ComptetClass($clientdebut);
    $libClientDebut = $compteClass->CT_Intitule;
}

if($clientfin!='0') {
    $compteClass = new ComptetClass($clientfin);
    $libClientFin = $compteClass->CT_Intitule;
}

$type_reg=0;
if(isset($_GET["type_reg"])) $type_reg=$_GET["type_reg"];

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