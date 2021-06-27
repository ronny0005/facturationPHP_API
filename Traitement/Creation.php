<?php
include("../Modele/DB.php");
include("../Modele/ObjetCollector.php");
session_start();
$objet = new ObjetCollector();
include("../Modele/Objet.php");
include("../Modele/ArticleClass.php");
include("../Modele/FamilleClass.php");
include("../Modele/ComptetClass.php");
include("../Modele/DepotClass.php");
include("../Modele/CaisseClass.php");
include("../Modele/CatTarifClass.php");
include("../Modele/F_TarifClass.php");
include("../Modele/ProtectionClass.php");
include("../Modele/ArtClientClass.php");
include("../Modele/MailComplete.php");

if(strcmp($_GET["acte"],"modif_article") == 0){
    $article = new ArticleClass(strtoupper($_GET["reference"]),$objet->db);
    $ancienPxMin = $article->Prix_Min;
    $ancienPxMax = $article->Prix_Max;
    $article->AR_Design = str_replace("'", "''", $_GET["designation"]);
    $article->AR_PrixAch = str_replace(" ","",str_replace(",",".",$_GET["pxAchat"]));
    $article->FA_CodeFamille = $_GET["famille"];
    $article->AR_PrixVen = str_replace(" ","",str_replace(",",".",$_GET["pxHT"]));
    if($article->AR_PrixVen=="") $article->AR_PrixVen=0;
    $article->Prix_Min = str_replace(" ","",str_replace(",",".",$_GET["pxMin"]));
    if($article->Prix_Min=="") $article->Prix_Min=0;
    $article->Prix_Max = str_replace(" ","",str_replace(",",".",$_GET["pxMax"]));
    if($article->Prix_Max=="") $article->Prix_Max=0;
    $article->AR_Condition = $_GET["conditionnement"];
    $article->AR_PrixTTC = (isset($_GET["AR_PrixTTC"])) ? $_GET["AR_PrixTTC"] : 0;
    $article->Qte_Gros = (isset($_GET["qteGros"])) ? $_GET["qteGros"] : 0;
    if($article->Qte_Gros=="") $article->Qte_Gros=0;
    $catal1 = 0;
    $catal2 = 0;
    $catal3 = 0;
    $catal4 = 0;

    if(isset($_GET["catalniv1"])  && $_GET["catalniv2"]!="null")
        $article->CL_No1 = $_GET["catalniv1"];
    if(isset($_GET["catalniv2"]) && $_GET["catalniv2"]!="null")
        $article->CL_No2 = $_GET["catalniv2"];
    if(isset($_GET["catalniv3"])  && $_GET["catalniv3"]!="null")
        $article->CL_No3 = $_GET["catalniv3"];
    if(isset($_GET["catalniv4"])  && $_GET["catalniv4"]!="null")
        $article->CL_No4 = $_GET["catalniv4"];
    $article->AR_Sommeil = (isset($_GET["AR_Sommeil"])) ? $_GET["AR_Sommeil"] : 0;
    $article->setuserName("","");
    $article->maj_article();
    $msgMail = "";
    $titreMail = "";
    if($ancienPxMin!=$article->Prix_Min){
        $msgMail = "Le prix minimum de l'article {$article->AR_Ref} - {$article->AR_Design} a été modifié par {$article->getcbCreateurName()}.<br/>
                    Ancien prix : {$objet->formatChiffre($ancienPxMin)} Nouveau prix : {$objet->formatChiffre($article->Prix_Min)}. <br/><br/> Cordialement.";
        $titreMail = "Modification du prix minimum de l'article {$article->AR_Ref} - {$article->AR_Design}";
    }
    if($ancienPxMax!=$article->Prix_Max){
        $msgMail = "Le prix maximum de l'article {$article->AR_Ref} - {$article->AR_Design} a été modifié par {$article->getcbCreateurName()}.<br/>
                    Ancien prix : {$objet->formatChiffre($ancienPxMax)} Nouveau prix : {$objet->formatChiffre($article->Prix_Max)}. <br/><br/> Cordialement.";
        $titreMail = "Modification du prix maximum de l'article {$article->AR_Ref} - {$article->AR_Design}";
    }

    if($msgMail!=""){
        $result = $objet->db->requete($objet->getInfoRAFControleur());
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if ($rows != null) {
            foreach ($rows as $row) {
                $email = $row->CO_EMail;
                if (preg_match('#^[\w.-]+@[\w.-]+\.[a-z]{2,6}$#i', $email)) {
                    $mail = new Mail();
                    $mail->sendMail($msgMail."<br/><br/><br/> {$objet->db->db}", $email,  $titreMail);
                }
            }
        }
    }
    $data = array('AR_Ref' => $article->AR_Ref);
    echo json_encode($data);
}

if(strcmp($_GET["acte"],"suppr_famille") == 0){
    $result=$objet->db->requete($objet->isFamilleLigne($_GET["FA_CodeFamille"]));
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if($rows==null){
        $result=$objet->db->requete($objet->supprFamille($_GET["FA_CodeFamille"]));
        header('Location: ../indexMVC.php?module=3&action=6&acte=supprOK&codeFAM='.$_GET["FA_CodeFamille"]);
    }else header('Location: ../indexMVC.php?module=3&action=6&acte=supprKO&codeFAM='.$_GET["FA_CodeFamille"]);
}

if(strcmp($_GET["acte"],"supprArtFournisseur") == 0) {
    $article = new ArticleClass(0,$objet->db);
    $article->deleteArtFournisseur($_GET["cbMarq"]);
}

if(strcmp($_GET["acte"],"getArtFournisseur") == 0) {
    $article = new ArticleClass(0,$objet->db);
    echo json_encode($article->getArtFournisseurSelect($_GET["cbMarq"]));
}

if(strcmp($_GET["acte"],"ajoutArtFournisseur") == 0){
    $article = new ArticleClass($_GET["AR_Ref"],$objet->db);
    $ct_num= $_GET["CT_Num"];
    $af_reffourniss = $_GET["AF_RefFourniss"];
    $af_prixach = str_replace(' ','',$_GET["AF_PrixAch"]);
    $af_unite = $_GET["AF_Unite"];
    $af_conversion = $_GET["AF_Conversion"];
    $af_delaiappo = $_GET["AF_DelaiAppo"];
    $af_garantie = $_GET["AF_Garantie"];
    $af_collisage = $_GET["AF_Colisage"];
    $af_qtemini = $_GET["AF_QteMini"];
    $af_qtemont = $_GET["AF_QteMont"];
    if($af_qtemont=="undefined") $af_qtemont='0';
    $eg_champ = $_GET["EG_Champ"];
    if($eg_champ=="undefined") $eg_champ='0';
    $af_principal = $_GET["AF_Principal"];
    $af_prixdev = $_GET["AF_PrixDev"];
    if($af_prixdev=="undefined") $af_prixdev='0';
    $af_devise = $_GET["AF_Devise"];
    $af_remise = $_GET["AF_Remise"];
    if($af_remise=="") $af_remise=0;
    $af_convdiv = $_GET["AF_ConvDiv"];
    $af_typerem = $_GET["AF_TypeRem"];
    $af_codebarre = $_GET["AF_CodeBarre"];
    $af_prixachnouv = $_GET["AF_PrixAchNouv"];
    if($af_prixachnouv=="undefined") $af_prixachnouv='0';

    $af_prixdevnouv = $_GET["AF_PrixDevNouv"];
    if($af_prixdevnouv=="undefined") $af_prixdevnouv='0';

    $af_remisenouv = $_GET["AF_RemiseNouv"];
    if($af_remisenouv=="undefined") $af_remisenouv='0';

    $af_dateapplication = $_GET["AF_DateApplication"];
    if($af_dateapplication=="") $af_dateapplication='1900-01-01';

    $item = $article->insertArtFournisseur($ct_num,$af_reffourniss,$af_prixach,$af_unite,$af_conversion,
                                    $af_delaiappo,$af_garantie,$af_collisage,$af_qtemini,$af_qtemont,
                                    $eg_champ,$af_principal,$af_prixdev,$af_devise,$af_remise,$af_convdiv,
                                    $af_typerem,$af_codebarre,$af_prixachnouv,$af_prixdevnouv,
                                    $af_remisenouv,$af_dateapplication);
    echo json_encode($item);
}
 
if(strcmp($_GET["acte"],"suppr_client") == 0){
    $type = $_GET["type"];
    $result=$objet->db->requete($objet->isClientLigne($_GET["CT_Num"]));
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if($rows==null){
        $result=$objet->db->query($objet->supprClient($_GET["CT_Num"]));
        if($type==0)
        header('Location: ../indexMVC.php?module=3&action=4&acte=supprOK&CT_Num='.$_GET["CT_Num"]);
        else
        header('Location: ../indexMVC.php?module=3&action=8&acte=supprOK&CT_Num='.$_GET["CT_Num"]);

    }else{
        if($type==0)
        header('Location: ../indexMVC.php?module=3&action=4&acte=supprKO&CT_Num='.$_GET["CT_Num"]);
        else
        header('Location: ../indexMVC.php?module=3&action=8&acte=supprKO&CT_Num='.$_GET["CT_Num"]);
    }
}
     
if(strcmp($_GET["acte"],"modif_famille") == 0){
    $ref = $_GET["FA_CodeFamille"];
    $intitule = str_replace("'", "''", $_GET["intitule"]);
    $catal1 = 0;
    $catal2 = 0;
    $catal3 = 0;
    $catal4 = 0;
    $niv=$_GET["niv"];
    $no=$_GET["val"];
    if(isset($_GET["catal1"]))
    $catal1 = $_GET["catal1"];
    if(isset($_GET["catal2"]))
    $catal2 = $_GET["catal2"];
    if(isset($_GET["catal3"]))
    $catal3 = $_GET["catal3"];
    if(isset($_GET["catal4"]))
    $catal4 = $_GET["catal4"];
    if(!isset($_GET["valide"]))
        $famille = new FamilleClass($ref,$objet->db);
        $famille->modifFamille($ref,$intitule,$catal1,$catal2,$catal3,$catal4);
    $result=$objet->db->requete($objet->getCatalogueChildren($niv,$no));
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    $data = array('codeFAM' => $ref);
    echo json_encode($data);
}

if(strcmp($_GET["acte"],"ajout_famille") == 0){
    $ref = strtoupper($_GET["FA_CodeFamille"]);
    $intitule = str_replace("'", "''", $_GET["intitule"]);
    $result=$objet->db->requete($objet->getFamilleByCode($ref));
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if($rows==null){
    $catal1 = 0;
    $catal2 = 0;
    $catal3 = 0;
    $catal4 = 0;
    $niv=$_GET["niv"];
    $no=$_GET["val"];
    if(isset($_GET["catal1"]))
    $catal1 = $_GET["catal1"];
    if(isset($_GET["catal2"]))
    $catal2 = $_GET["catal2"];
    if(isset($_GET["catal3"]))
    $catal3 = $_GET["catal3"];
    if(isset($_GET["catal4"]))
    $catal4 = $_GET["catal4"];
    $famille = new FamilleClass(0,$objet->db);
    $famille->insertFamille($ref,$intitule,$catal1,$catal2,$catal3,$catal4);
    $data = array('codeFAM' => $ref);
    echo json_encode($data);
    }else {
        echo $ref." existe déjà !";
    }
}


if(strcmp($_GET["acte"],"liste_clientIntitule") == 0){
    $result=$objet->db->requete($objet->allClientsByCT_Intitule($_GET["CT_Intitule"]));
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($rows);
}

if(strcmp($_GET["acte"],"ListeFamilleRemise") == 0){
    $famille = new FamilleClass(0,$objet->db);
    echo json_encode($famille->getShortList());
}
if(strcmp($_GET["acte"],"listeArticleRemise") == 0){
    $article = new ArticleClass(0,$objet->db);
    echo json_encode($article->getShortList());
}

if(strcmp($_GET["acte"],"ListeClientRemise") == 0){
    $comptet = new ComptetClass(0,$objet->db);
    echo json_encode($comptet->allClients());
}

if(strcmp($_GET["acte"],"articleByDesign") == 0){
    $article = new ArticleClass(0);
    $rows = $article->getArticleByIntitule($_POST["AR_Design"]);
    if (sizeof($rows)>1){
        echo "Ce nom est déjà utilisé pour un article !";
    }
}

if(strcmp($_GET["acte"],"clientByIntitule") == 0){
    $client = new ComptetClass(0);
    $rows = $client->getTiersByIntitule($_POST["CT_Intitule"]);
    if (sizeof($rows)>1){
        echo "Ce nom est déjà utilisé pour un tier !";
    }
}



if(strcmp($_GET["acte"],"listeCategRemise") == 0){
    $cattarif = new CatTarifClass(0,$objet->db);
    echo json_encode($cattarif->allCatTarifRemise());
}

if(strcmp($_GET["acte"],"listeClient")==0){
    $comptet = new ComptetClass(0,$objet->db);
    $comptet->listeClientPagination();
}

if(strcmp($_GET["acte"],"listeArticle")==0){
    $article = new ArticleClass(0,$objet->db);
    $login = "";
    $mdp="";
    if(isset( $_SESSION["login"]))
        $login = $_SESSION["login"];
    if(isset( $_SESSION["mdp"]))
        $mdp= $_SESSION["mdp"];
    $protection = new ProtectionClass($login, $mdp,$objet->db);
    $article->listeArticlePagination();
}

if(strcmp($_GET["acte"],"artStock")==0){
    $AR_Ref = $_GET["AR_Ref"];
    $DE_No = $_GET["DE_No"];
    $article = new ArticleClass(0);
    echo json_encode($article->getStockDepot($AR_Ref,$DE_No));
}

if(strcmp($_GET["acte"],"suppr_conditionnement") == 0){
    $result=$objet->db->requete($objet->selectFCondition($_GET["enumere"],$_GET["AR_Ref"]));
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if($rows!=null){
        $result=$objet->db->requete($objet->supprFTarifCond($_GET["AR_Ref"],$rows[0]->CO_No));
        $result=$objet->db->requete($objet->supprFCondition($rows[0]->cbMarq));
    }
}

if(strcmp($_GET["acte"],"suppr_article") == 0){
    $article = new ArticleClass($_GET["AR_Ref"]);
    $rows = $article->delete();
    if($rows==1){
        header('Location: ../listeArticle-3-'.$_GET["AR_Ref"]);
    }else
        header('Location: ../listeArticle-4-'.$_GET["AR_Ref"]);
}
if(strcmp($_GET["acte"],"liste_article_design") == 0){
    $result=$objet->db->requete($objet->getAllArticleByDesign($_GET["AR_Design"],$_SESSION["DE_No"]));     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($rows); 
}

if(strcmp($_GET["acte"],"liste_article") == 0){
    $article = new ArticleClass(0,$objet->db);
    echo json_encode($article->all());
}

if(strcmp($_GET["acte"],"ajout_Remise") == 0){
    $tarifClass = new F_TarifClass(0,$objet->db);
    $tarifClass->TF_Intitule = $_GET["TF_Intitule"];
    $tarifClass->TF_Interes = $_GET["TF_Interes"];
    $TF_DateDeb ="";
    if(isset($_GET["TF_DateDeb"]))
        $TF_DateDeb = $_GET["TF_DateDeb"];
    $TF_DateFin ="";
    if(isset($_GET["TF_DateFin"]))
        $TF_DateFin = $_GET["TF_DateFin"];
    $tarifClass->TF_Debut = $TF_DateDeb;
    $tarifClass->TF_Fin = $TF_DateFin;
    $tarifClass->TF_Objectif = $_GET["Objectif"];
    $tarifClass->TF_Domaine = $_GET["TF_Domaine"];
    $tarifClass->TF_Base = $_GET["TF_Base"];
    $tarifClass->TF_Calcul = $_GET["Calcul"];
    $tarifClass->AR_Ref = $_GET["ArticleRemise"];
    $tarifClass->TF_Remise01REM_Type = 0;
    $tarifClass->TF_Remise01REM_Valeur = 0;
    $tarifClass->TF_Remise02REM_Type = 0;
    $tarifClass->TF_Remise02REM_Valeur = 0;
    $tarifClass->TF_Remise03REM_Type = 0;
    $tarifClass->TF_Remise03REM_Valeur = 0;
    $tarifClass->TF_Type = $_GET["TF_Type"];
    $tarifClass->CT_Num = "";
    $tarifClass->setuserName("","");
    $cbMarq = $tarifClass->insertF_Tarif();
    $tarifClass = new F_TarifClass($cbMarq,$objet->db);

    $listeClient = mb_split(",",$_GET["ListeClient"]);
    foreach($listeClient as $element) {
        $tabelement = mb_split(":", $element);
        if (sizeof($tabelement) > 1) {
            $val_interes=2;
            if (trim($tabelement[0])=="Client")
                $val_interes=3;
            $tarifClass->insertF_TarifSelect($tarifClass->TF_No,$val_interes,trim($tabelement[1]));
        }
    }
    $listeArticle = mb_split(",",$_GET["ListeArticle"]);
    foreach($listeArticle as $element) {
        $tabelement = mb_split(":", $element);
        if (sizeof($tabelement) > 1) {
            $val_interes=0;
            if (trim($tabelement[0])=="Article")
                $val_interes=1;
            $tarifClass->insertF_TarifSelect($tarifClass->TF_No,$val_interes,trim($tabelement[1]));
        }
    }
    $ListeMontantRemise = mb_split(",",$_GET["ListeMontantRemise"]);
    foreach($ListeMontantRemise as $element) {
        $tabelement = mb_split(":", $element);
        if (sizeof($tabelement) > 0) {
            if ($tabelement[0] != "") {
                $val_interes = 0;
                $tarifClass->insertF_TarifRemise($tarifClass->TF_No, $tabelement[0], 0, 0);
            }
        }
    }
    $ListValRemise = mb_split(",",$_GET["ListValRemise"]);

    $ListeMontantRemise = mb_split(",",$_GET["ListeMontantRemise"]);
    $i=0;
    foreach($ListValRemise as $element) {
        $tabelement = mb_split(":", $element);
        if (sizeof($tabelement) > 0) {
            if ($tabelement[0] != "") {
                $val_interes = 0;
                $type_remise = 0;
                $remise=$tabelement[0];
                if($remise!=0 && strlen($remise)!=0){
                    if(strpos($remise, "%") || strpos($remise, "P")){
                        if(strpos($remise, "%"))
                            $remise=str_replace("%","",$remise);
                        else
                            $remise=str_replace("P","",$remise);
                        $type_rem="P";
                        $type_remise = 1;
                    }else {
                        $remise=str_replace("U","",$remise);
                        $type_rem="U";
                        $type_remise = 2;
                    }
                }else
                    $remise=0;
                $tarifClass->updateF_TarifRemise($tarifClass->TF_No,$i, $remise, $type_remise);
            }
        }
        $i++;
    }
    $data = array('TF_No' => $tarifClass->TF_No);
    echo json_encode($data);
}


if(strcmp($_GET["acte"],"modif_Remise") == 0) {
    $tarifClass = new F_TarifClass($_GET["cbMarq"],$objet->db);
    $tarifClass->TF_Intitule = $_GET["TF_Intitule"];
    $tarifClass->TF_Interes = $_GET["TF_Interes"];
    $TF_DateDeb = "";
    if (isset($_GET["TF_DateDeb"]))
        $TF_DateDeb = $_GET["TF_DateDeb"];
    $TF_DateFin = "";
    if (isset($_GET["TF_DateFin"]))
        $TF_DateFin = $_GET["TF_DateFin"];
    $tarifClass->TF_Debut = $TF_DateDeb;
    $tarifClass->TF_Fin = $TF_DateFin;
    $tarifClass->TF_Objectif = $_GET["Objectif"];
    $tarifClass->TF_Domaine = $_GET["TF_Domaine"];
    $tarifClass->TF_Base = $_GET["TF_Base"];
    $tarifClass->TF_Calcul = $_GET["Calcul"];
    $tarifClass->AR_Ref = $_GET["ArticleRemise"];
    $tarifClass->TF_Remise01REM_Type = 0;
    $tarifClass->TF_Remise01REM_Valeur = 0;
    $tarifClass->TF_Remise02REM_Type = 0;
    $tarifClass->TF_Remise02REM_Valeur = 0;
    $tarifClass->TF_Remise03REM_Type = 0;
    $tarifClass->TF_Remise03REM_Valeur = 0;
    $tarifClass->TF_Type = $_GET["TF_Type"];
    $tarifClass->CT_Num = "";
    $tarifClass->setuserName("", "");
    $tarifClass->maj_f_tarif();
    $tarifClass->deleteF_TarifRemiseSelect();
    $listeClient = mb_split(",",$_GET["ListeClient"]);
    foreach($listeClient as $element) {
        $tabelement = mb_split(":", $element);
        if (sizeof($tabelement) > 1) {
            $val_interes=2;
            if (trim($tabelement[0])=="Client")
                $val_interes=3;
            $tarifClass->insertF_TarifSelect($tarifClass->TF_No,$val_interes,trim($tabelement[1]));
        }
    }
    $listeArticle = mb_split(",",$_GET["ListeArticle"]);
    foreach($listeArticle as $element) {
        $tabelement = mb_split(":", $element);
        if (sizeof($tabelement) > 1) {
            $val_interes=0;
            if (trim($tabelement[0])=="Article")
                $val_interes=1;
            $tarifClass->insertF_TarifSelect($tarifClass->TF_No,$val_interes,trim($tabelement[1]));
        }
    }
    $ListeMontantRemise = mb_split(",",$_GET["ListeMontantRemise"]);
    foreach($ListeMontantRemise as $element) {
        $tabelement = mb_split(":", $element);
        if (sizeof($tabelement) > 0) {
            if ($tabelement[0] != "") {
                $val_interes = 0;
                $tarifClass->insertF_TarifRemise($tarifClass->TF_No, $tabelement[0], 0, 0);
            }
        }
    }
    $ListValRemise = mb_split(",",$_GET["ListValRemise"]);

    $ListeMontantRemise = mb_split(",",$_GET["ListeMontantRemise"]);
    $i=0;
    foreach($ListValRemise as $element) {
        $tabelement = mb_split(":", $element);
        if (sizeof($tabelement) > 0) {
            if ($tabelement[0] != "") {
                $val_interes = 0;
                $type_remise = 0;
                $remise=$tabelement[0];
                if($remise!=0 && strlen($remise)!=0){
                    if(strpos($remise, "%") || strpos($remise, "P")){
                        if(strpos($remise, "%"))
                            $remise=str_replace("%","",$remise);
                        else
                            $remise=str_replace("P","",$remise);
                        $type_rem="P";
                        $type_remise = 1;
                    }else {
                        $remise=str_replace("U","",$remise);
                        $type_rem="U";
                        $type_remise = 2;
                    }
                }else
                    $remise=0;
                $tarifClass->updateF_TarifRemise($tarifClass->TF_No,$i, $remise, $type_remise);
            }
        }
        $i++;
    }
    $data = array('TF_No' => $tarifClass->TF_No);
    echo json_encode($data);
}

if(strcmp($_GET["acte"],"ajout_client") == 0){
    if(isset($_GET["CT_Num"]))
        $ncompte = strtoupper($_GET["CT_Num"]);
    if(isset($_GET["CT_NumAjout"]))
        $ncompte = strtoupper($_GET["CT_NumAjout"]);
    $comptetClass = new ComptetClass($ncompte);
    if($comptetClass->CT_Num==NULL) {
        $comptetClass->CT_Num = $ncompte;
        $comptetClass->CT_Type = $_GET["type"];
        $comptetClass->CT_Intitule = str_replace("'", "''", $_GET["CT_Intitule"]);
        $comptetClass->CT_Encours = str_replace(" ", "", $_GET["CT_Encours"]);
        $comptetClass->CT_ControlEnc = $_GET["CT_ControlEnc"];
        $comptetClass->CT_Adresse = str_replace("'", "''", $_GET["CT_Adresse"]);
        $comptetClass->CG_NumPrinc = $_GET["CG_NumPrinc"];
        $comptetClass->CT_CodePostal = "";//$_GET["CT_CodePostal"];
        $comptetClass->CT_CodeRegion = str_replace("'", "''", $_GET["CT_CodeRegion"]);
        $comptetClass->CT_Ville = str_replace("'", "''", $_GET["CT_Ville"]);
        $comptetClass->CT_Siret = $_GET["CT_Siret"];
        $comptetClass->CT_Identifiant = $_GET["CT_Identifiant"];
        $comptetClass->CT_Telephone = $_GET["CT_Telephone"];
        $comptetClass->N_CatCompta = $_GET["N_CatCompta"];
        $comptetClass->N_CatTarif = $_GET["N_CatTarif"];
        $comptetClass->DE_No = $_GET["depot"];
        $comptetClass->MR_No = $_GET["mode_reglement"];
        $comptetClass->CA_Num = $_GET["CA_Num"];
        $comptetClass->CO_No = $_GET["CO_No"];
        $comptetClass->CT_Sommeil = $_GET["CT_Sommeil"];
        $ct_numP = "";
        $comptetClass->userName = $_GET["PROT_No"];
        $comptetClass->cbCreateur = $_GET["PROT_No"];
        $comptetClass->createClientMin();
        $data = array('CT_Num' => $comptetClass->CT_Num);
        echo json_encode($data);
    }else {
        echo "$ncompte existe déjà !";
    }
    }

if(strcmp($_GET["acte"],"modif_client") == 0){
        $ncompte = $_GET["CT_Num"];
        //$type = $_GET["type"];
        $comptetClass = new ComptetClass($ncompte);

        $comptetClass->CT_Intitule= str_replace("'", "''", $_GET["CT_Intitule"]);
    $comptetClass->CT_Adresse= str_replace("'", "''", $_GET["CT_Adresse"]);
        $comptetClass->CG_NumPrinc= $_GET["CG_NumPrinc"];
    //$comptetClass ->CT_CodePostal= "";//$_GET["CT_CodePostal"];
    $comptetClass->DE_No= $_GET["depot"];
    $comptetClass->CT_CodeRegion= str_replace("'", "''", $_GET["CT_CodeRegion"]);
    $comptetClass ->CT_Ville= str_replace("'", "''",$_GET["CT_Ville"]);
    $comptetClass->CT_Siret = $_GET["CT_Siret"];
    $comptetClass ->CT_Identifiant= $_GET["CT_Identifiant"];
    $comptetClass ->CT_Telephone= $_GET["CT_Telephone"];
    $comptetClass ->N_CatCompta= $_GET["N_CatCompta"];
    $comptetClass ->N_CatTarif= $_GET["N_CatTarif"];
    $comptetClass ->MR_No= $_GET["mode_reglement"];
    $comptetClass ->CA_Num= $_GET["CA_Num"];
    $comptetClass ->CO_No= $_GET["CO_No"];
    $comptetClass ->CT_Sommeil= $_GET["CT_Sommeil"];
    $comptetClass->CT_ControlEnc = $_GET["CT_ControlEnc"];
    $comptetClass->CT_Encours = str_replace(" ", "", $_GET["CT_Encours"]);

    if($_GET["CA_Num"]=="selected")
        $CA_Num= "";
    $comptetClass->maj_client();
    $comptetClass->modifClientUpdateCANum();
    if($comptetClass ->MR_No!=0 && $comptetClass ->MR_No!=""){
        $comptetClass ->majMrNo();
    }
    $data = array('CT_Num' => $ncompte);
    echo json_encode($data);
}

if(strcmp($_GET["acte"],"cond_detail") == 0){
    $article = new ArticleClass($_GET["reference"]);
    echo json_encode($article->detailConditionnement($_GET["value_cond"]));
}

if(strcmp($_GET["acte"],"maj_cond_detail") == 0){

  //  $article = new ArticleClass($_GET["ref"]);
  //  echo json_encode($article->detailConditionnement($_GET["val"]));
    $result=$objet->db->requete($objet->majDetailConditionnement($_GET["prix"],$_GET["ref"],$_GET["val"],$_GET["enum"],$_GET["qte"],$_GET["AEnum"]));
}

if(strcmp($_GET["acte"],"maj_prix_detail") == 0){
    $AR_Ref = $_GET["ref"];
    $ncat = $_GET["val"];
    $pxTTC = $_GET["Prix_TTC"];
    $ac_prixVen = 0;
    if(isset($_GET["prix"]))
        $ac_prixVen = str_replace(" ","",$_GET["prix"]);
    $ac_coef = 0;
    if(isset($_GET["AC_Coef"]))
        $ac_coef= str_replace(" ","",$_GET["AC_Coef"]);
    $fartclientClass = new F_ArtClientClass(0);
    $fartclientClass->updateFArtClient($ac_prixVen,$ac_coef,$AR_Ref,$ncat,$pxTTC);
}

if(strcmp($_GET["acte"],"ajout_article") == 0){
        $article = new ArticleClass(0);
        if (isset($_GET["reference"]))
            $article->AR_Ref = strtoupper($_GET["reference"]);
        if (isset($_GET["referenceAjout"]))
            $article->AR_Ref = strtoupper($_GET["referenceAjout"]);
        if (isset($_GET["designation"]))
            $article->AR_Design = str_replace("'", "''", $_GET["designation"]);
        if (isset($_GET["designationAjout"]))
            $article->AR_Design = str_replace("'", "''", $_GET["designationAjout"]);
        $articleClass = new ArticleClass($article->AR_Ref);
        if ($articleClass->cbMarq == "") {
            if (isset($_GET["pxAchat"]))
                $article->AR_PrixAch = str_replace(" ", "", str_replace(",", ".", $_GET["pxAchat"]));
            else
                $article->AR_PrixAch = 0;
            if ($article->AR_PrixAch == "") $article->AR_PrixAch = 0;
            $article->FA_CodeFamille = $_GET["famille"];
            $article->AR_Condition = $_GET["conditionnement"];
            if (isset($_GET["pxHT"]))
                $article->AR_PrixVen = str_replace(" ", "", str_replace(",", ".", $_GET["pxHT"]));
            else
                $article->AR_PrixVen = 0;

            if ($article->AR_PrixVen == "") $article->AR_PrixVen = 0;
            if (isset($_GET["pxMin"]))
                $article->Prix_Min = str_replace(" ", "", str_replace(",", ".", $_GET["pxMin"]));
            else
                $article->Prix_Min = 0;
            if ($article->Prix_Min == "") $article->Prix_Min = 0;
            if (isset($_GET["pxMax"]))
                $article->Prix_Max = str_replace(" ", "", str_replace(",", ".", $_GET["pxMax"]));
            else
                $article->Prix_Max = 0;

            if ($article->Prix_Max == "") $article->Prix_Max = 0;

            if (isset($_GET["qteGros"]))
                $article->Qte_Gros = str_replace(" ", "", str_replace(",", ".", $_GET["qteGros"]));
            else
                $article->Qte_Gros = 0;

            if ($article->Qte_Gros == "") $article->Qte_Gros = 0;

            $article->CL_No1 = 0;
            $article->CL_No2 = 0;
            $article->CL_No3 = 0;
            $article->CL_No4 = 0;

            if (isset($_GET["AR_PrixTTC"]))
                $article->AR_PrixTTC = $_GET["AR_PrixTTC"];
            else
                $article->AR_PrixTTC = 0;
            if (isset($_GET["catalniv1"]) && $_GET["catalniv2"] != "null")
                $article->CL_No1 = $_GET["catalniv1"];
            if (isset($_GET["catalniv2"]) && $_GET["catalniv2"] != "null")
                $article->CL_No2 = $_GET["catalniv2"];
            if (isset($_GET["catalniv3"]) && $_GET["catalniv3"] != "null")
                $article->CL_No3 = $_GET["catalniv3"];
            if (isset($_GET["catalniv4"]) && $_GET["catalniv4"] != "null")
                $article->CL_No4 = $_GET["catalniv4"];
            $article->AR_Nomencl = 0;
            $article->AR_QteOperatoire = 1;
            $article->AR_QteComp = 1;
            $article->AR_SaisieVar = 0;
            $article->AR_PUNet = 0;
            $article->AR_Sommeil = $_GET["AR_Sommeil"];
            $article->userName = $_GET["PROT_No"];
            $article->insertArticle();
            $data = array('AR_Ref' => $article->AR_Ref);
            echo json_encode($data);
        } else {
            echo "{$article->AR_Ref} existe déjà !";
        }
}


if(strcmp($_GET["acte"],"catalog_article") == 0){
    $code= $_GET["famille"];
    $cl1=0;
    $cl2=0;
    $cl3=0;
    $cl4=0;
    $cl_int1="";
    $cl_int2="";
    $cl_int3="";
    $cl_int4="";
    $result=$objet->db->requete($objet->getFamilleByCode($code));     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    $cl1 = $rows[0]->CL_No1;
    $cl2 = $rows[0]->CL_No2;
    $cl3 = $rows[0]->CL_No3;
    $cl4 = $rows[0]->CL_No4;
    if($cl1!=0){
        $fcatalogue = new F_CatalogueClass($cl1);
        $cl_int1 = $fcatalogue->CL_Intitule;
    }
    if($cl2!=0){
        $fcatalogue = new F_CatalogueClass($cl2);
        $cl_int2 = $fcatalogue->CL_Intitule;
    }
    if($cl3!=0){
        $fcatalogue = new F_CatalogueClass($cl3);
        $cl_int3 = $fcatalogue->CL_Intitule;
    }
    if($cl4!=0){
        $fcatalogue = new F_CatalogueClass($cl4);
        $cl_int4 = $fcatalogue->CL_Intitule;
    }
    echo '{"CL_No1" : '.$cl1.',"CL_Intitule1" : "'.$cl_int1.'","CL_No2" : '.$cl2.',"CL_Intitule2" : "'.$cl_int2.'","CL_No3" : '.$cl3.',"CL_Intitule3" : "'.$cl_int3.'","CL_No4" : '.$cl4.',"CL_Intitule4" : "'.$cl_int4.'"}';
}

if(strcmp($_GET["acte"],"ajout_user") == 0){
    $protection = new ProtectionClass("","");
    $protection->PROT_User = $_GET["username"];
    $protection->PROT_Description = $_GET["description"];
    $protection->PROT_Pwd = $_GET["password"];
    $protection->PROT_Email = $_GET["email"];
    $protection->PROT_Right = $_GET["groupeid"];
    $protection->PROT_PwdStatus = $_GET["changepass"];
    $profiluser = 0;
    if(isset($_GET["profiluser"])){
        $profiluser = $_GET["profiluser"];
    }
    $protection->PROT_UserProfil = $profiluser;
    $protection->ajoutUser($_GET["securiteAdmin"]);
}

if(strcmp($_GET["acte"],"ajout_depot") == 0){
    $depot = new DepotClass(0);
    $depot->DE_Intitule = str_replace("'","''", $_GET["intitule"]);
    $depot->DE_Adresse = str_replace("'","''", $_GET["adresse"]);
    $depot->DE_Complement = str_replace("'","''", $_GET["complement"]);
    $depot->DE_CodePostal = $_GET["cp"];
    if(isset($_GET["ville"]))
        $depot->DE_Ville = str_replace("'","''", $_GET["ville"]);
    else
        $depot->DE_Ville ="";
    if(isset($_GET["contact"]))
        $depot->DE_Contact = str_replace("'","''", $_GET["contact"]);
    else
        $depot->DE_Contact = "";
    if(isset($_GET["mail"]))
        $depot->DE_EMail = str_replace("'","''", $_GET["mail"]);
    else
        $depot->DE_EMail = "";
    if(isset($_GET["telecopie"]))
        $depot->DE_Telecopie = str_replace("'","''", $_GET["telecopie"]);
    else
        $depot->DE_Telecopie = "";
    if(isset($_GET["code_client"]))
        $codeClient=$_GET["code_client"];
    else
        $codeClient="";
    $depot->DE_Region = str_replace("'","''", $_GET["region"]);
    $depot->DE_Pays = str_replace("'","''", $_GET["pays"]);
    $CA_SoucheVente = $_GET["souche_vente"];
    $CA_SoucheAchat = $_GET["souche_achat"];
    $CA_SoucheInterne = $_GET["souche_interne"];
    $caisse = $_GET["caisse"];
    $affaire= str_replace("'","''", $_GET["affaire"]);
    $depot->DE_Telephone = $_GET["tel"];
    $depot->CA_CatTarif=$_GET["CA_CatTarif"];
    $info = $depot->insertFDepot($CA_SoucheVente,$CA_SoucheAchat,$CA_SoucheInterne,$caisse,$codeClient);
    $data = array('DE_No' => $info->de_No);
    echo json_encode($data);
}  


if(strcmp($_GET["acte"],"ajout_caisse") == 0){
    $caisse = new CaisseClass(0);
    $caisse->CA_Intitule = str_replace("'","''", $_GET["intitule"]);
    $caisse->CO_NoCaissier = $_GET["caissier"];
    $caisse->JO_Num = $_GET["journal"];
    if(isset($_GET["depot"]))
        $codeDepot=$_GET["depot"];
    else
        $codeDepot="";
    $caisseVal = $caisse->insertCaisse($codeDepot,$_GET["PROT_No"]);
    var_dump($caisseVal);
    $caisse = new CaisseClass($caisseVal->CA_No);
    $data = array('CA_No' => $caisse->CA_Intitule);
    echo json_encode($data);
}



if(strcmp($_GET["acte"],"modif_caisse") == 0){
    $caisse = $_GET["ca_no"];
    $caisse = new CaisseClass($_GET["ca_no"],$objet->db);
    $caisse->CO_NoCaissier = $_GET["caissier"];
    $caisse->JO_Num = $_GET["journal"];
    $caisse->CA_Intitule = str_replace("'","''", $_GET["intitule"]);
    if(isset($_GET["depot"]))
        $codeDepot=$_GET["depot"];
    else
        $codeDepot="";
    $caisse->maj_caisse($codeDepot);

    $data = array('CA_No' => $caisse->CA_Intitule);
    echo json_encode($data);
}
    
    
  

if(strcmp($_GET["acte"],"modif_depot") == 0){
    $depot = new DepotClass($_GET["de_no"],$objet->db);
    $depot->DE_Intitule = str_replace("'","''", $_GET["intitule"]);
    $depot->DE_Adresse = str_replace("'","''", $_GET["adresse"]);
    $depot->DE_Complement = str_replace("'","''", $_GET["complement"]);
    $depot->DE_CodePostal = $_GET["cp"];
    $depot->DE_Region = str_replace("'","''", $_GET["region"]);
    $depot->DE_Pays = str_replace("'","''", $_GET["pays"]);
    $caisse = $_GET["caisse"];
    if(isset($_GET["ville"]))
        $depot->DE_Ville = str_replace("'","''", $_GET["ville"]);
    else
        $depot->DE_Ville = "";
    if(isset($_GET["contact"]))
        $depot->DE_Contact = str_replace("'","''", $_GET["contact"]);
    else
        $depot->DE_Contact = "";
    if(isset($_GET["mail"]))
        $depot->DE_EMail = str_replace("'","''", $_GET["mail"]);
    else
        $depot->DE_EMail = "";
    if(isset($_GET["telecopie"]))
        $depot->DE_Telecopie = str_replace("'","''", $_GET["telecopie"]);
    else
        $depot->DE_Telecopie = "";
    $depot->DE_Telephone = $_GET["tel"];
    $CA_SoucheVente = $_GET["souche_vente"];
    $CA_SoucheAchat = $_GET["souche_achat"];
    $CA_SoucheInterne = $_GET["souche_interne"];
    $affaire = str_replace("'","''", $_GET["affaire"]);

    if(isset($_GET["code_client"]))
        $codeClient=$_GET["code_client"];
    else 
        $codeClient="";
    $depot->CA_CatTarif=$_GET["CA_CatTarif"];
    $depot->maj_depot();
    $depot->supprDepotClient();
    if(isset($_GET["code_client"]))
        foreach($codeClient as $code){
            $depot->insertDepotClient($code);
        }

    $rows = $depot->getDepotSouche();
    if(sizeof($rows)==0)
        $depot->insertDepotSouche($CA_SoucheVente,$CA_SoucheAchat,$CA_SoucheInterne,$affaire);
    else
        $depot->updateDepotSouche($CA_SoucheVente,$CA_SoucheAchat,$CA_SoucheInterne,$affaire);
    $rows = $depot->getDepotCaisse();
    if(sizeof($rows)==0)
        $depot->insertDepotCaisse($caisse);
    else
        $depot->modifDepotCaisse($caisse);
    $data = array('DE_No' => $depot->DE_Intitule);
    echo json_encode($data);
}   

if(strcmp($_GET["acte"],"modif_user") == 0){
    $id =$_GET["id"];
    $username =$_GET["username"];
    $description = $_GET["description"];
    $password = $_GET["password"];
    $email = $_GET["email"];
    $groupeid = $_GET["groupeid"];
    $changepass = $_GET["changepass"];
    if(isset($_GET["profiluser"])){
        $profiluser = $_GET["profiluser"];        
    }
    $protection = new ProtectionClass($username,$password);
    $protection->connexionProctectionByProtNo($id);
    $protection->setSecuriteAdmin($_GET["securiteAdmin"]);
    $protection->modifUser($username,$description,$password,$groupeid,$email,$profiluser,$id,$changepass);
    if(isset($_GET["depot"])){
        $depot = $_GET["depot"];
        $depotClass = new DepotClass(0);
        $depotClass->supprDepotUser($id);
        foreach($depot as $dep){
            $depotClass = new DepotClass($dep);
            $depotClass->insertDepotUser($id);
        }
    }
    if(isset($_GET["depotprincipal"])){
        $depotprincipal = $_GET["depotprincipal"];
        foreach($depotprincipal as $dep){
            $depotClass = new DepotClass($dep);
            $depotClass->setPrincipalDepotUser($id,$dep);
        }
    }
    $data = array('Prot_No' => $username);
    echo json_encode($data);
}

if(strcmp($_GET["acte"],"modif_groupe") == 0){
    $protno =$_GET["protno"];
    $cmd =$_GET["cmd"];
    $protright = $_GET["protright"];
    $u = $_GET["u"];
    $gu = $_GET["gu"];
    $result = $objet->db->requete($objet->DroitByProfilProcess($protno,$cmd,$protright));
            
}

?>
