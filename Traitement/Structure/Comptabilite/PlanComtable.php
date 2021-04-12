<?php
if(!isset($mobile)){
    session_start();
}
    include("../../../Modele/DB.php");
    include("../../../Modele/ObjetCollector.php");
    
    $objet = new ObjetCollector();
    $CG_Num = strtoupper($_GET["CG_Num"]);
    $CG_Intitule = str_replace("'","''", $_GET["CG_Intitule"]);
    $CG_Classement = $_GET["CG_Classement"];
    $CG_Classement = str_replace("'","''", $CG_Classement);
    $N_Nature = $_GET["N_Nature"];
    $CG_Report= $_GET["CG_Report"];
    if(isset($_GET["CG_Saut"]))
        $CG_Saut= 1;
    else 
        $CG_Saut = 1;
    if(isset($_GET["CG_Regroup"]))
        $CG_Regroup= 1;
    else 
        $CG_Regroup = 0;
    if(isset($_GET["CG_Analytique"]))
        $CG_Analytique= 1;
    else 
        $CG_Analytique = 0;
    if(isset($_GET["CG_Echeance"]))
        $CG_Echeance= 1;
    else 
        $CG_Echeance = 0;
    if(isset($_GET["CG_Quantite"]))
        $CG_Quantite= 1;
    else 
        $CG_Quantite = 0;
    if(isset($_GET["CG_Lettrage"]))
        $CG_Lettrage= 1;
    else 
        $CG_Lettrage = 0;
    if(isset($_GET["CG_Tiers"]))
        $CG_Tiers= 1;
    else 
        $CG_Tiers = 0;
    if(isset($_GET["CG_Devise"]))
        $CG_Devise= 1;
    else 
        $CG_Devise = 0;
    if(isset($_GET["N_Devise"]))
        $N_Devise= 1;
    else 
        $N_Devise = 0;
    if(isset($_GET["TA_Code"]))
        $TA_Code = $_GET["TA_Code"];
    else 
        $TA_Code = 0;
    if(isset($_GET["CG_Sommeil"]))
        $CG_Sommeil= 1;
    else 
        $CG_Sommeil = 0;
    $CG_Type= $_GET["CG_Type"];
    
  
if(strcmp($_GET["acte"],"ajout") == 0)
    $result = $objet->db->requete($objet->insertFCompteg($CG_Num,$CG_Type,$CG_Intitule,$CG_Classement,$N_Nature,$CG_Report,$CG_Regroup,$CG_Analytique,$CG_Echeance,$CG_Quantite,$CG_Lettrage,$CG_Tiers,$CG_Devise,$N_Devise,$TA_Code,$CG_Sommeil,$CG_Saut));
if(strcmp($_GET["acte"],"modif") == 0)
    $result = $objet->db->requete($objet->modifFCompteg($CG_Num,$CG_Type,$CG_Intitule,$CG_Classement,$N_Nature,$CG_Report,$CG_Regroup,$CG_Analytique,$CG_Echeance,$CG_Quantite,$CG_Lettrage,$CG_Tiers,$CG_Devise,$N_Devise,$TA_Code,$CG_Sommeil,$CG_Saut));
    
    if(strcmp($_GET["acte"],"suppr") == 0){
        $CG_Num = $_GET["CG_Num"];
        $result = $objet->db->requete($objet->deleteCompteCompta($TA_No));
        header('Location: ../../../indexMVC.php?module=9&action=1&acte=supprOK&CG_Num='.$CG_Num);
    }
    
    $data = array('CG_Num' => $CG_Num);
    echo json_encode($data);

?>
