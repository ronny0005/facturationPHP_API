<?php
if(!isset($mobile)){
    session_start();
}
    include("../../../Modele/DB.php");
    include("../../../Modele/ObjetCollector.php");
    
    $objet = new ObjetCollector();
    if(isset($_GET["MR_No"]))
        $MR_No = $_GET["MR_No"];
    $Detail = 0;
    if(isset($_GET["Detail"]))
        $Detail = 1;
    $MR_Intitule = str_replace("'","''", $_GET["MR_Intitule"]);
    $ER_VRepart = str_replace("'","''", $_GET["ER_VRepart"]);
    $ER_TRepart = 0;
    if(substr($ER_VRepart,-1)=="F"){
        $ER_TRepart = 2;
    }
    if(substr($ER_VRepart,-1)!="F" && substr($ER_VRepart,-1)!="%"){
        $ER_TRepart = 1;
        $ER_VRepart = $ER_VRepart;
    }else $ER_VRepart = substr($ER_VRepart,0,-1);

    if($ER_VRepart=='Equilibre' || $ER_VRepart=='')
        $ER_VRepart = 0;
    
    $ER_NbJour = $_GET["ER_NbJour"];
    $ER_Condition = $_GET["ER_Condition"];
    $ER_JourTb01 = $_GET["ER_JourTb01"];
    if($_GET["ER_JourTb01"]=="")$ER_JourTb01 =0;
    $N_Reglement = $_GET["N_Reglement"];
    if(isset($_GET["cbMarq"]))
        $cbMarq = $_GET["cbMarq"];
    if(strcmp($_GET["acte"],"ajout") == 0){
        if($Detail==0){
            $result = $objet->db->requete($objet->ajoutModeleR($MR_Intitule));
            $result = $objet->db->requete($objet->getModeleRByIntitule($MR_Intitule));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if($rows==null){
            }else{
                $MR_No = $rows[0]->MR_No;
            }
        }
        if($Detail==1){
            $result = $objet->db->requete($objet->ajoutEModeleR($MR_No,$N_Reglement,$ER_Condition,$ER_NbJour,$ER_JourTb01,$ER_TRepart,$ER_VRepart));
        }
    }
    
    if(strcmp($_GET["acte"],"modif") == 0){
        if($Detail==0){
            $result = $objet->db->requete($objet->modifModeleR($MR_Intitule,$MR_No));
            $result = $objet->db->requete($objet->supprEModeleR($MR_No));
        }
        if($Detail==1){
            $result = $objet->db->requete($objet->ajoutEModeleR($MR_No,$N_Reglement,$ER_Condition,$ER_NbJour,$ER_JourTb01,$ER_TRepart,$ER_VRepart));
        }
    }
    
    if(strcmp($_GET["acte"],"suppr") == 0){
        $MR_No = $_GET["MR_No"];
        $MR_Intitule = $_GET["MR_Intitule"];
        $result = $objet->db->requete($objet->deleteModeRglt($MR_No));
        header('Location: ../../../indexMVC.php?module=9&action=11&acte=supprOK&MR_No='.$MR_Intitule);
    }
    
    if($Detail==0)
        $data = array('MR_No' => $MR_No);
    else
        $data = array('MR_No' => $MR_Intitule);
    echo json_encode($data);

?>
