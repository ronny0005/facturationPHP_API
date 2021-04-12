<?php
$login = "";
if(!isset($mobile)){
session_start();
include("../Modele/DB.php");
include("../Modele/ObjetCollector.php");
$objet = new ObjetCollector();
$login = $_SESSION["login"];
}

if($_GET["acte"] =="transDevisBL"){
    $entete=$_GET["entete"];
    $result = $objet->db->requete($objet->getDoPiece($entete));
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if ($rows != null) {
        $entete_bl=$objet->addDocenteteBonLivraisonProcess($rows[0]->DO_Tiers,$rows[0]->CO_No,$rows[0]->DO_Ref,$rows[0]->DO_Date,1,$rows[0]->DE_No,$rows[0]->DO_Tarif,$rows[0]->N_CatCompta,$rows[0]->DO_Souche);
    }
    echo "entete : ".$entete_bl." ";
    $result = $objet->db->requete($objet->getLigneFacture($entete,2,23));
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if ($rows != null) {
        foreach ($rows as $row){
            echo $objet->addDocligneTransformFactureProcess(3,$entete_bl,$row->AR_Ref,$row->DL_Qte,$row->DL_Remise01REM_Valeur,$row->DL_Remise01REM_Type,$row->DL_Taxe1,$row->DL_Taxe2,$row->DL_Taxe3,$row->DL_PrixUnitaire);            
        }
    }
    header("location: ../indexMVC.php?module=2&action=2&entete=$entete");
}
?>