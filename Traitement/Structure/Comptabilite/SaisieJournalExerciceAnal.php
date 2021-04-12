<?php
if(!isset($mobile)){
    session_start();
}
    include("../../../Modele/DB.php");
    include("../../../Modele/ObjetCollector.php");
    
    $objet = new ObjetCollector();
    $CA_Num = "";
    if(isset($_GET["CA_Num"]))
    $CA_Num =$_GET["CA_Num"];
    $EA_Quantite = 0;
    if(isset($_GET["A_Qte"]) && $_GET["A_Qte"]!="")
    $EA_Quantite = $_GET["A_Qte"];
    $EA_Montant = 0;
    if(isset($_GET["A_Montant"]) && $_GET["A_Montant"]!="")
    $EA_Montant = $_GET["A_Montant"];
    $EC_No = "";
    if(isset($_GET["EC_No"]))
    $EC_No =$_GET["EC_No"];
    $N_Analytique = "";
    if(isset($_GET["N_Analytique"]))
    $N_Analytique =$_GET["N_Analytique"]; 
        
    
    
if(strcmp($_GET["acte"],"ajout") == 0){
    $result = $objet->db->requete($objet->insertFEcritureA($EC_No,$N_Analytique,$CA_Num,$EA_Montant,$EA_Quantite));
    $result = $objet->db->requete($objet->getLastFCompteA());
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    foreach( $rows as $row){
        afficheLigne($EC_No,$N_Analytique);
    }
}

if(strcmp($_GET["acte"],"suppr") == 0){
    $cbMarq = $_GET["cbMarq"];
    $result = $objet->db->requete($objet->supprFEcritureA($cbMarq));
    $data = array('TA_Code' => 0);
    echo json_encode($data);
}

if(strcmp($_GET["acte"],"modif") == 0){
    $cbMarq = $_GET["cbMarq"];
    $EC_No = $_GET["EC_No"];
    $result = $objet->db->requete($objet-> modifFEcritureA($cbMarq,$EC_No,$N_Analytique,$CA_Num,$EA_Montant,$EA_Quantite));
    $result = $objet->db->requete($objet->getLastFCompteA());
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    foreach( $rows as $row){
        afficheLigne($EC_No,$N_Analytique);
    }
}

if(strcmp($_GET["acte"],"ligneAnal") == 0){
    afficheLigne($EC_No,$N_Analytique);
}

function afficheLigne($EC_No,$N_Analytique){
    $objet = new ObjetCollector();
    $result =  $objet->db->requete($objet->getSaisieAnal($EC_No,$N_Analytique));
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if($rows !=null){
        foreach ($rows as $row){
            echo "<tr id='emodeler_anal_".$row->cbMarq."'>
                    <td id='tabCA_Num'>".$row->CA_Intitule."</td>
                    <td id='tabA_Qte'>".ROUND($row->EA_Quantite,2)."</td>
                    <td id='tabA_Montant'>".ROUND($row->EA_Montant,2)."</td>
                    <td id='data' style='visibility:hidden' ><span style='visibility:hidden' id='tabcbMarq'>".$row->cbMarq."</span></td>
                    <td id='modif_anal_'><i class='fa fa-pencil fa-fw'></i></td><td id='suppr_anal_'><i class='fa fa-trash-o'></i></td>
                </tr>";                    
        }
    }
}

?>
