<?php
$login = "";
if(!isset($mobile)){
session_start();
include("../Modele/DB.php");
include("../Modele/ObjetCollector.php");
$objet = new ObjetCollector();
$login = $_SESSION["login"];
}
$cat_tarif=0;
$cat_compta=0;
$libcat_tarif="";
$libcat_compta="";
$entete="";
$affaire="";
$souche="";
$co_no=0;
$depot_no=0;
$modif=0;
$client = "";
$totalht=0;
$tva=0;
$precompte=0;
$marge=0;
$totalttc=0;
$reference="";
  

// mise à jour de la référence
if( $_GET["acte"] =="ajout_date"){
    $entete= $_GET["entete"];
    $objet->db->requete($objet->updateFactureDacte($_GET["date"],$entete));
}
// mise à jour de la référence
if( $_GET["acte"] =="liste_article"){
    $entete=$_GET["entete"];
    $result=$objet->db->requete($objet->getLigneFacture($entete,0,6));     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($rows);
}

//ajout article 
if($_GET["acte"] =="ajout_ligne"|| $_GET["acte"] =="modif"){
    if($_GET["quantite"]!=""){
        $qte=$_GET["quantite"];
        $entete=$_GET["entete"];
        $ref_article = $_GET["designation"];
        $prix = $_GET["prix"];
        $remise = $_GET["remise"];
        $cat_tarif=$_GET["cat_tarif"];
        $cat_compta=$_GET["cat_compta"];
        $cbMarq =  $_GET["cbMarq"];
        $ADL_Qte =  $_GET["ADL_Qte"];
        
        $type_rem="P";
        $type_remise = 0;
        if(strlen($remise)!=0){
            if(strpos($remise, "U")){
                $remise=str_replace("U","",$remise);
                $type_rem="U";
                $type_remise = 2;
                $val_rem = $remise;
            } else {
                $remise=str_replace("%","",$remise);
                $type_rem="P";
                $type_remise = 1;
                $val_rem = $prix * $remise / 100;
            }
        }else $remise=0;
        if($_GET["acte"] =="ajout_ligne")
        echo $objet->addDocligneAvoirProcess(0,$entete,$ref_article,-$qte,$remise,$type_remise,$cat_tarif,$cat_compta,$prix,$login); 
        else 
        echo $objet->modifDocligneAvoir($entete,$ref_article,-$qte,$remise,$type_remise,-$ADL_Qte,$cbMarq,$cat_tarif,$cat_compta,$prix,$login);  
    }
}

//suppression d'article
if($_GET["acte"] =="suppr"){
    $result=$objet->db->requete($objet->suppressionLigne($_GET["id"])); 
}

// mise à jour de la référence
if( $_GET["acte"] =="maj_collaborateur"){
    $entete= $_GET["entete"];
    $objet->db->requete($objet->updateCollabEntete($_GET["collab"],$entete));
}


?>