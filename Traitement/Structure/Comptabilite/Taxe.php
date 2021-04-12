<?php
if(!isset($mobile)){
    session_start();
}
    include("../../../Modele/DB.php");
    include("../../../Modele/ObjetCollector.php");
    
    $objet = new ObjetCollector();
    $CompteRattache = $_GET["ComteRattache"];
    $tabCompteRattache = explode(",",$CompteRattache);
    
    $TA_Code = $_GET["TA_Code"];
    $TA_Intitule = str_replace("'","''", $_GET["TA_Intitule"]);
    $TA_Taux = $_GET["TA_Taux"];
    if($_GET["TA_Taux"]=="") $TA_Taux=0;
    $TA_TTaux = $_GET["TA_TTaux"];
    $TA_Type = $_GET["TA_Type"];
    $CG_Num = $_GET["CG_Num"];
    if(isset($_GET["TA_NP"]))   
        $TA_NP= 1;
    else 
        $TA_NP= 0;
    $TA_Sens= $_GET["TA_Sens"];
    $TA_Provenance= $_GET["TA_Provenance"];
    $TA_Regroup = $_GET["TA_Regroup"];
    $TA_Assujet= $_GET["TA_Assujet"];
    $TA_GrilleBase= "";
    $TA_GrilleTaxe= "";

    if(strcmp($_GET["acte"],"suppr") == 0){
        $TA_No = $_GET["TA_No"];
        $TA_Code = $_GET["TA_Code"];
        echo $objet->deleteTaxe($TA_No);
        $result = $objet->db->requete($objet->deleteTaxe($TA_No));
        header('Location: ../../../indexMVC.php?module=9&action=5&acte=supprOK&TA_Code='.$TA_Code);
    }
    
    
if(strcmp($_GET["acte"],"ajout") == 0){
    $result = $objet->db->requete($objet->insertTaxe($TA_Intitule,$TA_TTaux,$TA_Taux,$TA_Type,$CG_Num,$TA_Code,$TA_NP,$TA_Sens,$TA_Provenance,$TA_Regroup,$TA_Assujet,$TA_GrilleBase,$TA_GrilleTaxe));
    $result = $objet->db->requete($objet->getTaxeByTACode($_GET["TA_Code"]));
}

if(strcmp($_GET["acte"],"modif") == 0){
    $result = $objet->db->requete($objet->modifTaxe($TA_Intitule,$TA_TTaux,$TA_Taux,$TA_Type,$CG_Num,$TA_NP,$TA_Sens,$TA_Provenance,$TA_Regroup,$TA_Assujet,$TA_GrilleBase,$TA_GrilleTaxe,$TA_Code));
    
}

if(strcmp($_GET["acte"],"suppr") != 0){
$result = $objet->db->requete($objet->getTaxeByTACode($_GET["TA_Code"]));
$rows = $result->fetchAll(PDO::FETCH_OBJ);
if($rows==null){
}else{
    $result = $objet->db->requete($objet->deleteAllTaCode($rows[0]->TA_No));
    foreach($tabCompteRattache as $rowtab){
        $result = $objet->db->requete($objet->insertETaxe($rows[0]->TA_No,$rowtab));
    }
}
}


$data = array('TA_Code' => $TA_Code);
echo json_encode($data);

?>
