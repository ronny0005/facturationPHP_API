<?php
if(!isset($mobile)){
session_start();
include("../Modele/DB.php");
include("../Modele/ObjetCollector.php");
$objet = new ObjetCollector(); 
}
    if($_GET["acte"] =="ajout_mvtCaisse"){
        
        $CA_No=$_GET["caisse"];
        $date=$_GET["date"];
        $libelle=$_GET["libelle"];
        $compte_g=$_GET["banque"];
        $type=$_GET["type_mvt"];
        $montant=$_GET["montantRec"];
        
        
        $result = $objet->db->requete($objet->getCaisseInfo($CA_No));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $jo_num = $rows[0]->JO_Num;
        $co_no = $rows[0]->CO_No;
        $cg_numPrinc = $rows[0]->CG_Num;
        $result = $objet->db->requete($objet->getMaxRg_Piece());
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $rg_piece = $rows[0]->RG_PIECE;
        $result = $objet->db->requete($objet->addRgtCaisse($date, $montant, $jo_num, $compte_g, $CA_No, $co_no, $libelle, $type,$rg_piece,$cg_numPrinc));
       
        $data = array('entete' => 'OK');
        echo json_encode($data);
    }

?>

