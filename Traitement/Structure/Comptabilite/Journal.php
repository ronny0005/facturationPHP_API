<?php
if(!isset($mobile)){
    session_start();
}
    include("../../../Modele/DB.php");
    include("../../../Modele/ObjetCollector.php");
    
    $objet = new ObjetCollector();
    
    $JO_Num = strtoupper($_GET["JO_Num"]);
    $JO_Intitule = str_replace("'","''", $_GET["JO_Intitule"]);
    if(isset($_GET["CG_Num"]))
        $CG_Num = $_GET["CG_Num"];
    else
        $CG_Num = "";
    if(isset($_GET["JO_Type"]))
    $JO_Type = $_GET["JO_Type"];
    if(isset($_GET["JO_NumPiece"]))
        $JO_NumPiece = $_GET["JO_NumPiece"];
    else 
        $JO_NumPiece = 1;
    if(isset($_GET["JO_Contrepartie"]))
        $JO_Contrepartie = 1;
    else 
        $JO_Contrepartie = 0;
    if(isset($_GET["JO_SaisAnal"]))
        $JO_SaisAnal = $_GET["JO_SaisAnal"];
    else 
        $JO_SaisAnal = 0;
    if(isset($_GET["JO_NotCalcTot"]))
        $JO_NotCalcTot = $_GET["JO_NotCalcTot"];
    else 
        $JO_NotCalcTot = 0;
    if(isset($_GET["JO_Rappro"]))
        $JO_Rappro = $_GET["JO_Rappro"];
    else 
        $JO_Rappro = 0;
    if(isset($_GET["JO_Sommeil"]))
        $JO_Sommeil = 1;
    else 
        $JO_Sommeil = 0;
    if(isset($_GET["JO_IFRS"]))
        $JO_IFRS = $_GET["JO_IFRS"];
    else 
        $JO_IFRS = 0;
    if(isset($_GET["JO_Reglement"]))
        $JO_Reglement = 1;
    else 
        $JO_Reglement = 0;
    if(isset($_GET["JO_SuiviTreso"]))
        $JO_SuiviTreso = $_GET["JO_SuiviTreso"];
    else 
        $JO_SuiviTreso = 0;
    
    if(strcmp($_GET["acte"],"ajout") == 0)
    $result = $objet->db->requete($objet->ajoutJournal($JO_Num,$JO_Intitule,$CG_Num,$JO_Type,$JO_NumPiece,$JO_Contrepartie,$JO_SaisAnal,$JO_NotCalcTot,$JO_Rappro,$JO_Sommeil,$JO_IFRS,$JO_Reglement,$JO_SuiviTreso));
if(strcmp($_GET["acte"],"modif") == 0)
    $result = $objet->db->requete($objet->modifJournal($JO_Num,$JO_Intitule,$CG_Num,$JO_NumPiece,$JO_Contrepartie,$JO_SaisAnal,$JO_NotCalcTot,$JO_Rappro,$JO_Sommeil,$JO_IFRS,$JO_Reglement,$JO_SuiviTreso));
    
    if(strcmp($_GET["acte"],"suppr") == 0){
        $JO_Num = $_GET["JO_Num"];
        $result = $objet->db->requete($objet->deleteJournal($JO_Num));
        header('Location: ../../../indexMVC.php?module=9&action=7&acte=supprOK&JO_Num='.$JO_Num);
    }
    $data = array('JO_Num' => $JO_Num);
    echo json_encode($data);

?>
