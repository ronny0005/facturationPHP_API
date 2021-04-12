<?php
if(!isset($mobile)){
    session_start();
}
    include("../../../Modele/DB.php");
    include("../../../Modele/ObjetCollector.php");
    
    $objet = new ObjetCollector();
    
    $N_Analytique = $_GET["N_Analytique"];
    $CA_Num = strtoupper($_GET["CA_Num"]);
    $CA_Intitule = str_replace("'","''", $_GET["CA_Intitule"]);
    $CA_Type = $_GET["CA_Type"];
    $CA_Classement = $_GET["CA_Classement"];
    $CA_Classement = str_replace("'","''", $CA_Classement);
    if(isset($_GET["CA_Raccourci"]))
        $CA_Raccourci= $_GET["CA_Raccourci"];
    else 
        $CA_Raccourci= "";
        
    if(isset($_GET["CA_Report"]))
        $CA_Report= 1;
    else 
        $CA_Report= 0;
    if(isset($_GET["N_Analyse"]))
        $N_Analyse = $_GET["N_Analyse"];
    else 
        $N_Analyse = 1;
    if(isset($_GET["CA_Saut"]))
        $CA_Saut = 1;
    else 
        $CA_Saut = 1;
        
    if(isset($_GET["CA_Sommeil"]))
        $CA_Sommeil= 1;
    else 
        $CA_Sommeil= 0;
    if(isset($_GET["CA_Domaine"]))
        $CA_Domaine = $_GET["CA_Domaine"];
    else 
        $CA_Domaine = 0;
    if(isset($_GET["CA_Achat"]))
        $CA_Achat = $_GET["CA_Achat"];
    else 
        $CA_Achat = 0;
    if(isset($_GET["CA_Vente"]))
        $CA_Vente = $_GET["CA_Vente"];
        else 
        $CA_Vente = 0;

if(strcmp($_GET["acte"],"ajout") == 0)
    $result = $objet->db->requete($objet->insertFComptea ($N_Analytique,$CA_Num,$CA_Intitule,$CA_Type,$CA_Classement,$CA_Raccourci,$CA_Report,$N_Analyse,$CA_Saut,$CA_Sommeil,$CA_Domaine,$CA_Achat,$CA_Vente));
if(strcmp($_GET["acte"],"modif") == 0)
    $result = $objet->db->requete($objet->modifFComptea ($N_Analytique,$CA_Num,$CA_Intitule,$CA_Type,$CA_Classement,$CA_Raccourci,$CA_Report,$N_Analyse,$CA_Saut,$CA_Sommeil,$CA_Domaine,$CA_Achat,$CA_Vente));
    if(strcmp($_GET["acte"],"suppr") == 0){
        $CA_Num = $_GET["CA_Num"];
        $result = $objet->db->requete($objet->deleteCompteAnal($CA_Num));
        header('Location: ../../../indexMVC.php?module=9&action=3&acte=supprOK&CA_Num='.$CA_Num);
    }
    $data = array('CA_Num' => $CA_Num);
    echo json_encode($data);

?>
