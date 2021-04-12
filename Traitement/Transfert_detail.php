<?php
$login = "";
if(!isset($mobile)){
    session_start();
    include("../Modele/DB.php");
    include("../Modele/Objet.php");
    include("../Modele/ObjetCollector.php");
    include("../Modele/ComptetClass.php");
    include("../Modele/DocEnteteClass.php");
    include("../Modele/DocLigneClass.php");
    include("../Modele/ArticleClass.php");
    include("../Modele/LogFile.php");
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
    $comptetClass = new ComptetClass("41TRANSFERTDETAIL","all",$objet->db);
    if(isset($_GET["affaire"])) $affaire = $_GET["affaire"];
    if($comptetClass->CT_Num ==null){
        $comptetClass->CT_Num = strtoupper("41TRANSFERTDETAIL");
        $comptetClass->CT_Type = 0;
        $comptetClass->CT_Intitule = "TRANSFERT DETAILS";
        $comptetClass->CT_Adresse = "";
        $comptetClass->CG_NumPrinc = "4110000";
        $comptetClass->CT_CodePostal = "";//$_GET["CT_CodePostal"];
        $comptetClass->CT_CodeRegion = "";
        $comptetClass->CT_Ville = "";
        $comptetClass->CT_Siret = "";
        $comptetClass->CT_Identifiant = "";
        $comptetClass->CT_Telephone = "";
        $comptetClass->N_CatCompta = 1;
        $comptetClass->N_CatTarif = 1;
        $comptetClass->DE_No = 1;
        $comptetClass->MR_No = 0;
        $comptetClass->CA_Num = "";
        $comptetClass->CO_No = 0;
        $comptetClass->CT_Encours = 0;
        $comptetClass->CT_ControlEnc = 0;
        $ct_numP = "";
        $comptetClass->setuserName("", "");
        $comptetClass->createClientMin();
        $comptetClass = new ComptetClass($ncompte,"all",$objet->db);

        $ct_numP=$comptetClass->CT_Num;
        if($comptetClass->CT_Type!=1)
            $result=$objet->db->requete($objet->createFLivraison($comptetClass->CT_Num
                ,str_replace("'", "''", $comptetClass->CT_Intitule)
                ,str_replace("'", "''", $comptetClass->CT_Adresse)
                ,str_replace("'", "''", $comptetClass->CT_Complement)
                ,str_replace("'", "''", $comptetClass->CT_CodePostal)
                ,str_replace("'", "''", $comptetClass->CT_Ville)
                ,str_replace("'", "''", $comptetClass->CT_CodeRegion)
                ,$comptetClass->N_Expedition,$comptetClass->N_Condition,$comptetClass->CT_Telecopie
                ,str_replace("'", "''", $comptetClass->CT_EMail)
                ,str_replace("'", "''", $comptetClass->CT_Pays)
                ,str_replace("'", "''", $comptetClass->CT_Contact)
                ,$comptetClass->CT_Telephone));
        $result=$objet->db->requete($objet->creationComptetg($comptetClass->CT_Num,$comptetClass->CG_NumPrinc));

        if($comptetClass->MR_No!=0 && $comptetClass->MR_No!=""){
            $result =  $objet->db->requete( $objet->getOptionModeleReglementByMRNo($mode_reglement));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if($rows !=null){
                foreach ($rows as $row){
                    $Condition = $row->ER_Condition;
                    $jour = $row->ER_JourTb01;
                    $nbjour = $row->ER_NbJour;
                    $trepart = $row->ER_TRepart;
                    $vrepart = $row->ER_VRepart;
                }
                $objet->db->requete($objet->insertFReglementT($comptetClass->CT_Num,$Condition,$nbjour,$jour,$trepart,$vrepart));
            }
        }
    }
//Sortie
    $docentete = new DocEnteteClass(0);
    $do_piece= $docentete->addDocenteteTransfertDetailProcess($entete,4,41,$_GET["date"], $_GET["reference"], $_GET["depot"], 0, 0,0,$affaire);
    //$objet->addDocenteteTransfertDetailProcess($entete,4,41,$_GET["date"], $_GET["reference"], $_GET["depot"], 0, 0,0,$affaire);
//Entree
    $docentete->addDocenteteTransfertDetailProcess($do_piece,4,40,$_GET["date"], $_GET["reference"], $_GET["collaborateur"], 0, 0,1,$affaire);
//    $objet->addDocenteteTransfertDetailProcess($entete,4,40,$_GET["date"], $_GET["reference"], $_GET["collaborateur"], 0, 0,1,$affaire);
    $result=$objet->db->requete($objet->lastDOPieceByDE_No($_GET["depot"]));     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if ($rows!=null) {
        $entete = $rows[0]->DO_Piece;
        $cbMarq = $rows[0]->cbMarq;
    }
    $data = array('entete' => $entete,'cbMarq' => $cbMarq);
    echo json_encode($data);
}
// mise à jour de la référence
if( $_GET["acte"] =="liste_article"){
    $entete=$_GET["entete"];
    $result=$objet->db->requete($objet->getLigneTransfert_detail($entete));     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($rows);
}

// mise à jour de la référence
if( $_GET["acte"] =="liste_article_source"){
    $depot=$_GET["depot"];
    $article = new ArticleClass(0);
    $rows = $article->getAllArticleDispoByArRef($depot_no);
    echo json_encode($rows);
}

//ajout article 
if($_GET["acte"] =="ajout_ligne"|| $_GET["acte"] =="modif"){
    
    if($_GET["quantite"]!=""){
        $qte=$_GET["quantite"];
        $qte_dest=$_GET["quantite_dest"];
        $ref_article = $_GET["designation"];
        $ref_article_dest = $_GET["designation_dest"];
        $prix = $_GET["prix"];
        $prix_dest = $_GET["prix_dest"];
        $remise = $_GET["remise"];
        $id_sec =  $_GET["id_sec"];
        $type_rem="P";
        $type_remise = 0;
        $typefac = $_GET["type_fac"];
        $cbMarqEntete = $_GET["cbMarqEntete"];
        $machine = $_GET["machineName"];
        $user = $_GET["userName"];
        $protNo = $_GET["PROT_No"];
        $docentete = new DocEnteteClass($cbMarqEntete);
        $docentete->getDoPieceTrsftDetail();
        $depot = $docentete->DE_No;
        $collaborateur = $docentete->DO_Tiers;
        if($_GET["acte"] =="ajout_ligne"){
            $docligne = new DocLigneClass(0);

            $docligne->addDocligneTransfertDetailProcess(4,41,$cbMarqEntete,$ref_article,$prix,$qte,"3",$docentete->DE_No,$machine,$protNo);
            $var2 = $docligne->addDocligneTransfertDetailProcess(4,40,$cbMarqEntete,$ref_article_dest, $prix_dest,$qte_dest,"1",$docentete->DO_Tiers,$machine,$protNo);
            echo json_encode($var2);
            $article = new ArticleClass($ref_article);
            $article->updateArtStock($depot,-1*$qte,-($prix*$qte),$protNo,"ajout_ligne");

            $article = new ArticleClass($ref_article_dest);
            $article->updateArtStock($collaborateur,$qte_dest,($prix_dest*$qte_dest),$protNo,"ajout_ligne");
        }else{
            $objet->modifDocligneFactureMagasin($entete,$ref_article,$qte,$cbMarq,$prix,4,41,$login,$typefac);
            $objet->modifDocligneFactureMagasin($entete,$ref_article_dest,$qte_dest,$id_sec,$prix_dest,4,40,$login,$typefac);

            $article = new ArticleClass($ref_article);
            $article->updateArtStock($depot,($aqte-$qte),(($Aprix*$aqte)-($prix*$qte)),$protNo,"modif_ligne");

            $article = new ArticleClass($ref_article_dest);
            $article->updateArtStock($collaborateur,(-$aqte_dest+$qte_dest),(($prix_dest*$qte_dest)-($Aprix_dest*$aqte_dest)),$protNo,"modif_ligne");

            $result=$objet->db->requete($objet->lastLigneBycbMarqTrsftDetail($cbMarq,$id_sec));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($rows);    
        }
    }
}

if($_GET["acte"] =="liste_article_depot"){
    $depot_no = $_GET["depot"];
    $article = new ArticleClass(0);
    $rows = $article->getAllArticleDispoByArRef($depot_no);
    if($rows!=null)
        echo json_encode($rows);
}
//suppression d'article
if($_GET["acte"] =="suppr"){
    $docligne = new DocLigneClass($_GET["id"]);
    $docligne_sec = new DocLigneClass($_GET["id_sec"]);
    $article = new ArticleClass($docligne->AR_Ref);
    $article->updateArtStock($docligne->DE_No,+$docligne->DL_Qte,+($docligne->DL_CMUP*$docligne->DL_Qte),$_SESSION["id"],"suppr_ligne");
    $article = new ArticleClass($docligne_sec->AR_Ref);
    $article->updateArtStock($docligne_sec->DE_No,-$docligne_sec->DL_Qte,-($docligne_sec->DL_CMUP*$docligne_sec->DL_Qte),$_SESSION["id"],"suppr_ligne");

    $docligne->delete($_SESSION["id"]);
    $docligne_sec->delete($_SESSION["id"]);
}

?>