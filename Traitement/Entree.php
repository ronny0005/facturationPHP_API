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
    $mobile="";
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
    if(isset($_GET["do_piece"]))
        $entete=$_GET["do_piece"];
    if($_GET["affaire"]=="0")
        $affaire="";
    if($_GET["affaire"]=="null")
        $affaire="";
    $type_fac = $_GET["type_fac"];

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
    $entete = $docEntete->addDocenteteEntreeProcess($_GET["date"], $_GET["reference"], $_GET["depot"],$_GET["affaire"] , 0, 0);
    $docEntete = new DocEnteteClass(0);
    $docEntete->setTypeFac($type_fac);
    $docEntete->DO_Piece = $entete;
    $element = $docEntete->getFactureByPieceTypeFac();
    $data = array('entete' => $entete,'cbMarq' => $element->cbMarq);
    echo json_encode($data);}
    else
        echo "la date doit être comprise entre $limitmoinsDate et $limitplusDate.";
}

// mise à jour de la référence
if( $_GET["acte"] =="liste_article"){
    $entete=$_GET["entete"];
    $result=$objet->db->requete($objet->getLigneFacture($entete,2,20));     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($rows);
}

// mise à jour de la référence
if( $_GET["acte"] =="liste_article_source"){
    $depot=$_GET["depot"];
    $article = new ArticleClass(0,$this->db);
    echo json_encode($article->getAllArticleDispoByArRef($depot));
}

//ajout article 
if($_GET["acte"] =="ajout_ligne"|| $_GET["acte"] =="modif") {

    if ($_GET["quantite"] != "") {
        $qte = $_GET["quantite"];
        $qte = str_replace(" ", "", $_GET["quantite"]);
        $prix = $_GET["prix"];
        $remise = $_GET["remise"];
        $aprix = 0;
        $cbMarq = $_GET["cbMarq"];
        $cbMarqEntete = $_GET["cbMarqEntete"];
        $type_fac = $_GET["type_fac"];
        $type_rem = "P";
        $type_remise = 0;
        $login = "";
        $docEntete = new DocEnteteClass($cbMarqEntete, $objet->db);
        if (isset($_GET["userName"])) $login = $_GET["userName"];
        $machine = "";
        if (isset($_GET["machineName"])) $machine = $_GET["machineName"];
        if (isset($_GET["PROT_No"])) {
            $protection = new ProtectionClass("", "", $objet->db);
            $protection->connexionProctectionByProtNo($_GET["PROT_No"]);
            $isSecurite = $protection->IssecuriteAdmin($docEntete->DE_No);
            $isVisu = $docEntete->isVisu($protection->PROT_Administrator, $protection->protectedType("Entree"), $protection->PROT_APRES_IMPRESSION,$isSecurite);
            if (!$isVisu) {
                if ($_GET["acte"] == "ajout_ligne") {
                    $ref_article = $_GET["designation"];
                    try {
                        $objet->db->connexion_bdd->beginTransaction();
                        $docligne = new DocLigneClass(0, $objet->db);
                        echo $docligne->addDocligneEntreeMagasinProcess($ref_article, $cbMarqEntete, $qte, "1", "0", $prix, $type_fac, $machine, $_GET["PROT_No"]);
                        $article = new ArticleClass($ref_article, $objet->db);
                        $article->updateArtStock($docEntete->DO_Tiers, $qte, $prix * $qte, $_GET["PROT_No"], $_GET["acte"]);
                        $article->setASQteMaxiArtStock($docEntete->DO_Tiers);
                        $objet->db->connexion_bdd->commit();
                    }
                    catch(Exception $e){
                        $objet->db->connexion_bdd->rollBack();
                        return json_encode($e);
                    }
                } else {
                    try {
                        $objet->db->connexion_bdd->beginTransaction();
                        $docligne = new DocLigneClass($cbMarq, $objet->db);
                        $aprix = $docligne->DL_PrixUnitaire;
                        $aqte = $docligne->DL_Qte;
                        $docligne->setuserName("", "");
                        $docligne->modifDocligneFactureMagasin($qte, $prix, $type_fac,$_GET["PROT_No"]);

                        $article = new ArticleClass($docligne->AR_Ref, $objet->db);
                        $article->updateArtStock($docEntete->DO_Tiers, -$aqte + $qte, ($prix * $qte) - ($aprix * $aqte),$_GET["PROT_No"],$_GET["acte"]);
                        $rows = $docligne->getLigneFactureElementByCbMarq();
                        echo json_encode($rows);
                        $objet->db->connexion_bdd->commit();
                    }
                    catch(Exception $e){
                        $objet->db->connexion_bdd->rollBack();
                        return json_encode($e);
                    }
                }
            }
        }
    }
}

//suppression d'article
if($_GET["acte"] =="suppr") {
    $docligne = new DocLigneClass($_GET["id"], $objet->db);
    $article = new ArticleClass($docligne->AR_Ref, $objet->db);
    $docEntete = new DocEnteteClass($docligne->getcbMarqEntete());
    if (isset($_GET["PROT_No"])) {
        $protection = new ProtectionClass("", "", $objet->db);
        $protection->connexionProctectionByProtNo($_GET["PROT_No"]);
        $isSecurite = $protection->IssecuriteAdmin($docEntete->DE_No);
        $isVisu = $docEntete->isVisu($protection->PROT_Administrator, $protection->protectedType("Entree"), $protection->PROT_APRES_IMPRESSION,$isSecurite);
        if (!$isVisu) {
            $article->updateArtStock($docEntete->DO_Tiers, -$docligne->DL_Qte, -($docligne->DL_CMUP * $docligne->DL_Qte),$_GET["PROT_No"],"suppr_ligne");
            $docligne->delete($_GET["PROT_No"]);
        }
    }
}
?>