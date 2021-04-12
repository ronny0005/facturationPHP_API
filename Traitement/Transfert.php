<?php
$login = "";
session_start();
include("../Modele/DB.php");
include("../Modele/ObjetCollector.php");
include("../Modele/Objet.php");
include("../Modele/LogFile.php");
include("../Modele/DocEnteteClass.php");
include("../Modele/DocLigneClass.php");
include("../Modele/ArticleClass.php");
include("../Modele/DepotClass.php");
include("../Modele/ComptetClass.php");
include("../Modele/ProtectionClass.php");
include("../Modele/MailComplete.php");
$objet = new ObjetCollector();
if(isset($_SESSION["login"]))
$login = $_SESSION["login"];
$mobile="";

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
    $affaire = $_GET["affaire"];
    if($_GET["affaire"]=="null")
        $affaire="";
    if($_GET["affaire"]=="0")
        $affaire="";
    $admin = 0;
    $limitmoinsDate = "";
    $limitplusDate = "";
    try {
        $objet->db->connexion_bdd->beginTransaction();

        if(isset($_GET["PROT_No"])) {
            $protectionClass = new ProtectionClass("", "", $objet->db);
            $protectionClass->connexionProctectionByProtNo($_GET["PROT_No"]);
            if ($protectionClass->PROT_Right != 1) {
                if ($protectionClass->getDelai() != 0) {
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
        $entete=$docEntete->addDocenteteTransfertProcess($_GET["date"], $_GET["reference"], $_GET["collaborateur"], $_GET["affaire"],$_GET["depot"], 0, 0,$_GET["type_fac"]);
        $data = array('entete' => $entete->DO_Piece,'cbMarq' => $entete->cbMarq);
        echo json_encode($data);
    }
    else
        echo "la date doit être comprise entre $limitmoinsDate et $limitplusDate.";

        $objet->db->connexion_bdd->commit();
    }
    catch(Exception $e){
        $objet->db->connexion_bdd->rollBack();
        return json_encode($e);
    }
}

// mise à jour de la référence
if( $_GET["acte"] =="liste_article"){
    $entete=$_GET["entete"];
    $result=$objet->db->requete($objet->getLigneFacture($entete,2,23));     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($rows);
}
// mise à jour de la référence
if( $_GET["acte"] =="liste_article_source"){
    $depot=$_GET["depot"];
    $rows = Array();
    $article = new ArticleClass(0,$objet->db);
    if($depot!="null") {
        if ($_GET["type"] == "Ticket" || $_GET["type"] == "Vente" || $_GET["type"] == "BonLivraison" || $_GET["type"] == "Sortie" || $_GET["type"] == "Transfert" || $_GET["type"] == "Transfert_detail")
            $rows = $article->getAllArticleDispoByArRef($depot);
        else
            $rows = $article->all();
    }
    echo json_encode($rows);
}

// mise à jour de la référence
if( $_GET["acte"] =="liste_article_sourceDevise"){
    $depot=$_GET["depot"];
    $rows = Array();
    if($depot!="null") {
        $article = new ArticleClass(0,$this->db);
        $rows = json_encode($article->getAllArticleDispoByArRef($depot));
    }
    echo json_encode($rows);
}

//ajout article 
if($_GET["acte"] =="ajout_ligne"|| $_GET["acte"] =="modif"){

    if($_GET["quantite"]!=""){
        $qte=$_GET["quantite"];
        $prix = $_GET["prix"];
        $typefac = $_GET["type_fac"];
        $remise = $_GET["remise"];
        $cbMarq =  $_GET["cbMarq"];
        $id_sec =  $_GET["id_sec"];
        $cbMarqEntete = $_GET["cbMarqEntete"];
        $type_rem="P";
        $type_remise = 0;
        $login ="";
        if(isset($_GET["userName"]))
            $login = $_GET["userName"];
        $machine ="";
        $docEntete = new DocEnteteClass($cbMarqEntete,$objet->db);
        $docEntete->type_fac;
        if(isset($_GET["machineName"]))
            $machine = $_GET["machineName"];

        if (isset($_GET["PROT_No"])) {
            $protection = new ProtectionClass("", "", $objet->db);
            $protection->connexionProctectionByProtNo($_GET["PROT_No"]);
            $isSecurite = $protection->IssecuriteAdmin($docEntete->DE_No);
            $isVisu = $docEntete->isVisu($protection->PROT_Administrator, $protection->protectedType($typefac), $protection->PROT_APRES_IMPRESSION,$isSecurite);
            if (!$isVisu) {
                if ($_GET["acte"] == "ajout_ligne") {
                    $ref_article = $_GET["designation"];
                    $qteSource = 0;
                    $prixSource = 0;
                    $article = new ArticleClass($ref_article, $objet->db);
                    $depotSource = new DepotClass($docEntete->DE_No, $objet->db);
                    $isStock = $article->isStock($docEntete->DE_No);
                    if ($isStock == null) {
                        echo "Le dépot {$depotSource->DE_Intitule} n'a pas de stock pour l'article {$article->AR_Ref} !";
                    } else {
                        $prixSource = $isStock[0]->AS_MontSto;
                        $qteSource = $isStock[0]->AS_QteSto;

                        $docligne = new DocLigneClass(0, $objet->db);
                        try {
                            $docligne->db->connexion_bdd->beginTransaction();
                            $var1 = $docligne->addDocligneTransfertProcess($ref_article, $prixSource / $qteSource, $qte, "3", $machine, $cbMarqEntete, $_GET["PROT_No"], 0);
                            if ($typefac == "Transfert")
                                $var2 = $docligne->addDocligneTransfertProcess($ref_article, $prix, $qte, "1", $machine, $cbMarqEntete, $_GET["PROT_No"], $var1->cbMarq);
                            if ($typefac == "Transfert_confirmation")
                                $docligne->addDocligneTransfertConfirmationProcess($ref_article, $prix, $qte, $cbMarqEntete, $var1->cbMarq);
                            if ($typefac == "Transfert")
                                echo json_encode($var2);

                            if ($typefac == "Transfert_confirmation") {
                                $data = array('entete' => "", 'cbMarq' => $var1->cbMarq);
                                echo json_encode($data);
                            }
                            $docligne->db->connexion_bdd->commit();
                        }
                        catch(Exception $e){
                            $docligne->db->connexion_bdd->rollBack();
                            return json_encode($e);
                        }
                    }
                } else {
                    $qte = $_GET["quantite"];
                    $prix = $_GET["prix"];
                    $typefac = $_GET["type_fac"];
                    $cbMarq = $_GET["cbMarq"];
                    $id_sec = $_GET["id_sec"];
                    $cbMarqEntete = $_GET["cbMarqEntete"];
                    $login = "";
                    if (isset($_GET["userName"]))
                        $login = $_GET["userName"];
                    $machine = "";
                    $docligne = new DocLigneClass(0, $objet->db);
                    $docligne->alerteCumulStock();
                    $docEntete = new DocEnteteClass($cbMarqEntete, $objet->db);
                    $docligne->majQteZLigneConfirmation($cbMarq, $qte);
                    $data = $docligne->getZLigneConfirmation($cbMarq);
                    echo json_encode($data);
                }
            }
        }
        }
    $protectionClass = new ProtectionClass("","",$objet->db);
    $html = $protectionClass->alerteTransfert();
    if($html !="") {
        $mail = new Mail();
        $mail->sendMail("$html <br/><br/><br/> {$objet->db->db}","info@it-solution-sarl.com","Liste des transferts à une ligne");
    }
}

if($_GET["acte"] =="vaid_confirmation"){

}

if($_GET["acte"] =="liste_article_depot"){
$depot_no = $_GET["depot"];
$article = new ArticleClass(0,$this->db);
$rows = $article->getAllArticleDispoByArRef($depot);
if($rows!=null)
    echo json_encode($rows);
}

//suppression d'article
if($_GET["acte"] =="suppr"){
    $docligne = new DocLigneClass($_GET["id"], $objet->db);
    try{
        $docligne->db->connexion_bdd->beginTransaction();
        $docligne->supprLigneTransfert($_GET["id_sec"],0);
        $docligne->db->connexion_bdd->commit();
    }
    catch(Exception $e){
        $docligne->db->connexion_bdd->rollBack();
        return json_encode($e);
    }
}
?>