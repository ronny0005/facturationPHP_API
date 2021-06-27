<?php
$login = "";
if(!isset($mobile)){
session_start();
include("../Modele/DB.php");
include("../Modele/ObjetCollector.php");
include("../Modele/Objet.php");
include("../Modele/LogFile.php");
include("../Modele/DocEnteteClass.php");
    include("../Modele/DocLigneClass.php");
    include("../Modele/ArticleClass.php");
    include("../Modele/ProtectionClass.php");
$objet = new ObjetCollector();
$login = $_SESSION["login"];
$mobile = "";
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
  
// Création de l'entete de document
if($_GET["acte"] =="ajout_entete"){
    $entete=$_GET["do_piece"];
    $admin = 0;
    $limitmoinsDate = "";
    $limitplusDate = "";
    if(isset($_SESSION)){
        $protectionClass = new ProtectionClass($_SESSION["login"],$_SESSION["mdp"],$objet->db);
        if($protectionClass->PROT_Right!=1) {
            if($protectionClass->getDelai()!=0) {
                $limitmoinsDate = date('d/m/Y', strtotime(date('Y-m-d') . " - " . $protectionClass->getDelai() . " day"));
                $limitplusDate = date('d/m/Y', strtotime(date('Y-m-d') . " + " . $protectionClass->getDelai() . " day"));
                $str = strtotime(date("M d Y ")) - (strtotime($_GET["date"]));
                $nbDay = abs(floor($str / 3600 / 24));
                if ($nbDay > $protectionClass->getDelai())
                    $admin = 1;
            }
        }
    }

    if($admin==0) {
        $docEntete = new DocEnteteClass(0,$objet->db);
        $cbMarq = $docEntete->addDocenteteSortieProcess($_GET["date"], $_GET["reference"], $_GET["depot"], $_GET["affaire"], 0, 0);
        $docEntete = new DocEnteteClass($cbMarq,$objet->db);
        $data = array('entete' => $docEntete->DO_Piece,'cbMarq' => $docEntete->cbMarq);
        echo json_encode($data);
    }
    else
        echo "la date doit être comprise entre $limitmoinsDate et $limitplusDate.";
}

// mise à jour de la référence
if( $_GET["acte"] =="liste_article"){
    $entete=$_GET["entete"];
    $result=$objet->db->requete($objet->getLigneFacture($entete,2,21));     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($rows);
}

// mise à jour de la référence
if( $_GET["acte"] =="liste_article_source"){
    $depot=$_GET["depot"];
    $result=$objet->db->requete($objet->getAllArticleDispoByArRef($depot));     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($rows);
}

//ajout article 
if($_GET["acte"] =="ajout_ligne"|| $_GET["acte"] =="modif"){
    if($_GET["quantite"]!="") {
        $qte = $_GET["quantite"];
        $prix = $_GET["prix"];
        $remise = $_GET["remise"];
        $cbMarq = $_GET["cbMarq"];
        $typefac = $_GET["type_fac"];
        $cbMarqEntete = $_GET["cbMarqEntete"];
        $type_rem = "P";
        $type_remise = 0;
        $login = "";
        if (isset($_GET["userName"]))
            $login = $_GET["userName"];
        $machine = "";
        if (isset($_GET["machineName"]))
            $machine = $_GET["machineName"];
        $docEntete = new DocEnteteClass($cbMarqEntete);
        $docligne = new DocLigneClass(0);
        if ($_GET["acte"] == "ajout_ligne") {
            $ref_article = $_GET["designation"];
            echo $docligne->addDocligneSortieMagasinProcess($ref_article, $cbMarqEntete, $qte, "3", $typefac, $machine, $_GET["PROT_No"]);
        } else {
            echo $docligne->modifDocligneFactureMagasin($qte, $prix, $typefac, $_GET["PROT_No"]);
        }
    }
}

//suppression d'article
if($_GET["acte"] =="suppr") {
    $docligne = new DocLigneClass($_GET["id"], $objet->db);
    $docEntete = new DocEnteteClass($docligne->getcbMarqEntete(), $objet->db);
    if (isset($_GET["PROT_No"])) {
        $protection = new ProtectionClass("", "", $objet->db);
        $protection->connexionProctectionByProtNo($_GET["PROT_No"]);
        $isSecurite = $protection->IssecuriteAdmin($docEntete->DE_No);

        $isVisu = $docEntete->isVisu($protection->PROT_Administrator, $protection->protectedType("Sortie"), $protection->PROT_APRES_IMPRESSION,$isSecurite);
        if (!$isVisu) {
            try {
                $objet->db->connexion_bdd->beginTransaction();
                $AR_PrixAch = $docligne->DL_CMUP;
                $DL_Qte = $docligne->DL_Qte;
                $AR_Ref = $docligne->AR_Ref;
                $DE_No = $docEntete->DO_Tiers;
                $article = new ArticleClass($AR_Ref, $objet->db);
                $article->updateArtStock($DE_No, +$DL_Qte, +($AR_PrixAch * $DL_Qte),$_GET["PROT_No"],$_GET["acte"]);
                $docligne->delete($_GET["PROT_No"]);
                $objet->db->connexion_bdd->commit();
            }
            catch(Exception $e){
                $objet->db->connexion_bdd->rollBack();
                return json_encode($e);
            }
        }
    }
}

?>