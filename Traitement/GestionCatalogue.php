<?php
if(!isset($mobile)){
    session_start();
    include("../Modele/DB.php");
    include("../Modele/ObjetCollector.php");
    $objet = new ObjetCollector();
}
if($_GET["acte"]=="nouveau_hniv0"){
    $ref = $_GET["hniv"];
    $no_parent=$_GET["noparent"];
    $niveau=$_GET["niv"];
    $objet = new ObjetCollector();   
    $result=$objet->db->requete($objet->insertFCatalogue($ref,$no_parent,$niveau));     
    $result=$objet->db->requete($objet->getLastCatalogue());     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($rows[0]);
}

if($_GET["acte"]=="listeCatalogue"){
    $niv = $_GET["niv"];
    $no = $_GET["no"];
    $objet = new ObjetCollector();
    $result=$objet->db->requete($objet->getCatalogueChildren($niv,$no));     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if($rows==null)
        echo '{"CL_No":"","CL_Intitule":""}';
    else 
    echo json_encode($rows);
}

    
if($_GET["acte"]=="modifCatalogue"){
    $cl_no = $_GET["no"];
    $intitule=$_GET["intitule"];
    $objet = new ObjetCollector();   
    $result=$objet->db->requete($objet->updateFCatalogue($cl_no,$intitule));     
}

if($_GET["acte"]=="suppr_catalogue"){
    $cl_no = $_GET["cl_no"];
    $objet = new ObjetCollector();   
    $result=$objet->db->requete($objet->deleteFCatalogue($cl_no));     
}


?>