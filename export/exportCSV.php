<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 03/02/2019
 * Time: 07:20
 */
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="Liste_Article.csv"');

include("../Modele/DB.php");
include("../Modele/Objet.php");
include("../Modele/ObjetCollector.php");
include("../Modele/ProtectionClass.php");
include("../Modele/ArticleClass.php");

session_start();
$objet = new ObjetCollector();
$protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
$flagPxRevient= $protection->PROT_PX_REVIENT;
$flagPxAchat= $protection->PROT_PX_ACHAT;
$flagInfoLibreArticle = $protection->PROT_INFOLIBRE_ARTICLE;
$article = new ArticleClass(0);
$ar_sommeil=$_GET["AR_Sommeil"];
$prixFlag=$_GET["prixFlag"];
$stockFlag= $_GET["stockFlag"];
$query = $article->queryListeArticle($flagPxAchat,$flagInfoLibreArticle,$ar_sommeil,$prixFlag,$stockFlag,$protection->Prot_No);
$result = $objet->db->query($query." END;");
$rows = $result->fetchAll(PDO::FETCH_OBJ);
$valprixAch = "";
$valprixVen = "";
$valinfolibreArticle1="";
$valinfolibreArticle2="";
if($flagPxAchat==0)
    $valprixAch= "Prix d achat";
if($flagInfoLibreArticle!=2) {
    $valprixVen= "Prix de vente conseillé";
    $valinfolibreArticle1 = "Prix de gros";
    $valinfolibreArticle2 = "Prix details";
}

$user_CSV[0] = array('Reference','Famille','Designation','Stock',$valprixAch,$valprixVen,$valinfolibreArticle1,$valinfolibreArticle2);
// very simple to increment with i++ if looping through a database result
foreach ($rows as $row){
    $valprixAch = "";
    $valprixVen = "";
    $valinfolibreArticle1="";
    $valinfolibreArticle2="";
    if($flagPxAchat==0)
        $valprixAch= $row->AR_PrixAch;
    if($flagInfoLibreArticle!=2) {
        $valprixVen= $row->AR_PrixVen;
        $valinfolibreArticle1 = $row->Prix_Min;
        $valinfolibreArticle2 = $row->Prix_Max;
    }
    array_push($user_CSV,array($row->AR_Ref,$row->FA_CodeFamille,$row->AR_Design,$row->AS_QteSto,$valprixAch,$valprixVen,$valinfolibreArticle1,$valinfolibreArticle2));
}
$fp = fopen('php://output', 'wb');
foreach ($user_CSV as $line) {
    fputcsv($fp, $line, ';');
}
fclose($fp);
?>

