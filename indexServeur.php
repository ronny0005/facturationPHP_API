<?php

include("modele/Mail.php");
include("modele/LogFile.php");
include("Modele/DB.php");
include("Modele/Objet.php");
include("Modele/ObjetCollector.php");
include("Modele/CaisseClass.php");
include("Modele/CollaborateurClass.php");
include("Modele/DocReglClass.php");
include("Modele/ReglEchClass.php");
include("Modele/JournalClass.php");
include("modele/ArtClientClass.php");
include("Modele/DepotClass.php");
include("Modele/DepotCaisseClass.php");
include("Modele/DepotUserClass.php");
include("Modele/DocEnteteClass.php");
include("Modele/CatComptaClass.php");
include("Modele/EtatClass.php");
include("modele/ReglementClass.php");
include("modele/CompteaClass.php");
include("modele/P_CommunicationClass.php");
include("modele/LiaisonEnvoiMailUser.php");
include("Modele/LiaisonEnvoiSMSUser.php");
include("modele/DepotEmplClass.php");
include("modele/DepotEmplUserClass.php");
include("Modele/ContatDClass.php");
include("Modele/DocLigneClass.php");
include("Modele/ComptetClass.php");
include("Modele/CatTarifClass.php");
include("Modele/ProtectionClass.php");
include("Modele/TaxeClass.php");
include("Modele/FamilleClass.php");
include("Modele/ArticleClass.php");
include("Modele/F_TarifClass.php");
include("Modele/CompteGClass.php");
include("Modele/BanqueClass.php");
include("module/Menu.php");
include("module/Facturation.php");
include("module/Creation.php");
include("module/Mouvement.php");
include("module/Caisse.php");
include("module/Etat.php");
include("module/Admin.php");
include("module/PlanComptable.php");

$objet = new ObjetCollector();
$texteMenu = "";

function envoiRequete($requete,$objet){
    $result=$objet->db->requete($requete);
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($rows);
}

function execRequete($requete,$objet){
    $objet->db->requete($requete);
}

function error(){
    echo "[{-1}]";
}

$val=$_GET["page"];
switch ($val) {
    case "depot":
        envoiRequete($objet->depot(),$objet);
        break;
    case "depotCount":
        envoiRequete($objet->depotCount(),$objet);
        break;
    case "getCollaborateur":
        $collaborateur = new CollaborateurClass(0);
        echo json_encode($collaborateur->all());
        break;
    case "getCollaborateurCount":
        envoiRequete($objet->getCollaborateurCount(),$objet);
        break;
    case "piedPageFacturation":
        envoiRequete($objet->getCollaborateur(),$objet);
        break;
    case "getPrixClientAch":
        $article = new ArticleClass($_GET["AR_Ref"]);
        echo json_encode($article->getPrixClientAch($_GET['N_CatCompta'], $_GET['N_CatTarif'],$_GET["CT_Num"]));
        break;
    case "getPrixClientAchHT":
        envoiRequete($objet->getPrixClientAchHT($_GET['AR_Ref'], $_GET['N_CatCompta'], $_GET['N_CatTarif'], $_GET['Prix'],$_GET['remise']),$objet);
        break;
    case "getLibTaxePied":
        $article = new ArticleClass(0);
        echo json_encode($article->getLibTaxePied($_GET['N_CatCompta'], $_GET['N_CatTarif']));
        break;
    case "getF_Artclient":
        envoiRequete($objet->getF_Artclient(),$objet);
        break;
    case "getF_ArtclientCount":
        envoiRequete($objet->getF_ArtclientCount(),$objet);
        break;
    case "testCorrectLigneA":
        $docEntete = new DocEnteteClass($_GET["cbMarq"]);
        echo json_encode($docEntete->testCorrectLigneA());
        break;

    case "getF_ArtCompta":
        envoiRequete($objet->getF_ArtCompta(),$objet);
        break;
    case "getF_ArtComptaCount":
        envoiRequete($objet->getF_ArtComptaCount(),$objet);
        break;
    case "getF_FamCompta":
        envoiRequete($objet->getF_FamCompta(),$objet);
        break;
    case "getF_FamComptaCount":
        envoiRequete($objet->getF_FamComptaCount(),$objet);
        break;
    case "getF_Taxe":
        envoiRequete($objet->getF_Taxe(),$objet);
        break;
    case "getTaxeByTACode":
        envoiRequete($objet->getTaxeByTACode($_GET["TA_Code"]),$objet);
        break;

    case "getF_TaxeCount":
        envoiRequete($objet->getF_TaxeCount(),$objet);
        break;

    case "setListEmplacement":
        $depotClass = new DepotClass(0,$objet->db);
        echo json_encode($depotClass->listEmpl($_GET["listId"],$_GET["PROT_No"]));
        break;
    case "getDateEcheance":
        echo $objet->getDateEcgetTiersheance($_GET["CT_Num"],$_GET["Date"]);
        break;
    case "getDateEcheanceSage":
        $comptet = new ComptetClass($_GET["CT_Num"]);
        echo json_encode($comptet->getDateEcgetTiersheanceSage($_GET["Date"]));
        break;
    case "getTiersByIntitule":
        $client = new ComptetClass(0);
        $rows = $client->getTiersByIntitule($_GET["CT_Intitule"]);
        echo json_encode($rows);
        break;
    case "getTiersByIntituleRglt":
        $client = new ComptetClass(0);
        $intitule = $_GET["CT_Intitule"];
        if($_GET["TypeRglt"]!="Collaborateur")
            $rows = $client->getTiersByIntitule($intitule);
        else {
            $client = new CollaborateurClass(0);
            $rows = $client->getCollaborateurByNom($intitule);
        }
        echo json_encode($rows);
        break;
    case "getTiersByNum":
        $client = new ComptetClass(0);
        $rows = $client->getTiersByNum($_GET["CT_Num"]);
        echo json_encode($rows);
        break;
    case "getTiersByNumIntitule":
        $client = new ComptetClass(0);
        $varClient = 0;

        if(isset($_GET["TypeFac"])){
            $docEntete = new DocEnteteClass(0);
            $docEntete->setTypeFac($_GET["TypeFac"]);
            if($docEntete->DO_Domaine == 1)
                $varClient = 1;
            if($_GET["TypeFac"]=="all")
                $varClient = -1;
        }

        if(isset($_GET["typeTiers"]))
            $varClient = $_GET["typeTiers"];

        $select =0;
        $searchTerm = "";
        if(isset($_GET["select"]))
            $select =-1;
        if(isset($_GET['term']))
            $searchTerm = $_GET['term'];
        if(isset($_GET['searchTerm']))
            $searchTerm = $_GET['searchTerm'];

        if(!isset($_GET['term']) && !isset($_GET['searchTerm'])){
            if($varClient!=2) {
                $rows = $client->getTiersByNumIntitule("", $varClient, $select, 0);
            }
            else{
                $collaborateur = new CollaborateurClass(0);
                $rows = $collaborateur->getCaissierByIntitule("");
            }
        }else{
            if($varClient!=2) {
                $rows = $client->getTiersByNumIntitule($searchTerm , $varClient, $select,0);
            }
            else{
                $collaborateur = new CollaborateurClass(0);
                $rows = $collaborateur->getCaissierByIntitule($searchTerm);
            }

        }
        echo json_encode($rows);
        break;

    case "getDepotByIntitule":
        $depot = new DepotClass(0);
        $exclude = (isset($_GET["DE_NoSource"])) ? $_GET["DE_NoSource"] : -1;
        if(!isset($_POST['searchTerm'])){
            $rows = $depot->getDepotByIntitule("",$exclude);
        }else{
            $rows = $depot->getDepotByIntitule($_POST['searchTerm'],$exclude);
        }
        echo json_encode($rows);
        break;

    case "getArticleByRefDesignation":
        $article = new ArticleClass(0);
        $de_no = $_GET["DE_No"];
        $searchTerm = "";
        if(isset($_GET['term']))
            $searchTerm = $_GET['term'];
        if(isset($_GET['searchTerm']))
            $searchTerm = $_GET['searchTerm'];
        $rechEtat = "0";
        if(isset($_GET['rechEtat']))
            $rechEtat = 1;
        if($de_no!="null") {
            if ($_GET["type"] == "Ticket" || $_GET["type"] == "AchatRetour" || $_GET["type"] == "Vente" || $_GET["type"] == "BonLivraison" || $_GET["type"] == "Sortie" || $_GET["type"] == "Transfert"  || $_GET["type"] == "Transfert_confirmation" || $_GET["type"] == "Transfert_detail") {
                echo json_encode($article->getAllArticleDispoByArRef($de_no, 0, $searchTerm,$rechEtat));
            }
            else {
                echo json_encode($article->all(0, $searchTerm,10,-1,$rechEtat));
            }
        }
        break;
    case "getTiersByNumIntitule":
        $client = new ComptetClass(0);
        $searchTerm = "";
        if(isset($_GET['term']))
            $searchTerm = $_GET['term'];
        if(isset($_GET['searchTerm']))
            $searchTerm = $_GET['searchTerm'];
        $type = 0;
        if(isset($_GET['type']))
            $type = $_GET['type'];

        echo json_encode($client->getTiersByNumIntitule($searchTerm,$type));
        break;
    case "getCGNumBySearch" :
        $compteg = new CompteGClass(0);
        $searchTerm = "";
        if(isset($_GET['term']))
            $searchTerm = $_GET['term'];
        echo json_encode($compteg->allSearch($searchTerm,10));
        break;
    case "getArticleByRefDesignationMvtTransfert":
        $article = new ArticleClass(0);
        $de_no = $_GET["DE_No"];
        $searchTerm = "";
        if(isset($_GET['term']))
            $searchTerm = $_GET['term'];
        if($de_no!="null") {
                echo json_encode($article->all(0, $searchTerm,10,0));
        }
        break;

        case "getDepotByDENoIntitule":
        session_start();
        $depot = new DepotClass(0);
        $searchTerm = "";
        if(isset($_GET['term']))
            $searchTerm = $_GET['term'];
        $exclude = -1;
        if(isset($_GET['exclude']))
            $exclude = $_GET['exclude'];
        $depotClass = new DepotClass(0,$objet->db);
        $isPrincipal = 0;
        $protection = new ProtectionClass("","");
        if(isset($_SESSION))
            $protection = new ProtectionClass($_SESSION["login"],$_SESSION["mdp"]);
        if($protection->PROT_Administrator==0)
            echo json_encode($depotClass->getDepotUserSearch($_SESSION["id"],$exclude,$searchTerm,$_GET["principal"]));
        else
            echo json_encode($depot->getDepotByIntitule($searchTerm,$exclude));
        break;

    case "getCaisseByCANoIntitule":
        session_start();
        $caisse = new CaisseClass(0);
        $searchTerm = "";
        if(isset($_GET['term']))
            $searchTerm = $_GET['term'];
        $exclude = -1;
        if(isset($_GET['exclude']))
            $exclude = $_GET['exclude'];
        $caisseClass = new CaisseClass(0,$objet->db);
        $isPrincipal = 0;
        $protection = new ProtectionClass("","");
        if(isset($_SESSION))
            $protection = new ProtectionClass($_SESSION["login"],$_SESSION["mdp"]);
        if($protection->PROT_Administrator==0)
            echo json_encode($caisseClass->getCaisseUser($_SESSION["id"],$exclude,$searchTerm,$_GET["principal"]));
        else
            echo json_encode($caisse->getCaisseByIntitule($searchTerm,$exclude));
        break;

    case "sectionByPlan":
        $html="";
        $list = $objet->sectionByPlan($_GET["nAnalytique"]);
        if(sizeof($list)>0)
            $html = $html."<option value='0'>Tout</option>";
        foreach($list as $val){
            $html = $html."<option value='{$val->CA_Num}'>{$val->CA_Intitule}</option>";
        }
        echo $html;
        break;

    case "getArticleByIntitule":
        $article = new ArticleClass(0);
        $rows = $article->getArticleByIntitule($_GET["AR_Design"]);
        echo json_encode($rows);
        break;

    case "getDateEcheanceSelect":
        echo $objet->getDateEcgetTiersheanceSelect($_GET["MR_No"],$_GET["N_Reglement"],$_GET["Date"]);
        break;

    case "getJournauxSaisie":
        $journal = new JournalClass(0);
        echo json_encode($journal->getJournauxSaisie($_GET["type"],$_GET["codeMois"],$_GET["codeJournal"],$_GET["annee_exercice"]));
        break;

    case "getDateEcheanceSelectSage":
        $reglement = new ReglementClass(0);
        $rows = $reglement->getDateEcgetTiersheanceSelectSage($_GET["MR_No"],$_GET["N_Reglement"],$_GET["Date"]);
        if(sizeof($rows)>0)
            echo json_encode(rows[0]);
        break;

    case "connexionProctection":
        session_start();
        $protection = new ProtectionClass($_SESSION["login"],$_SESSION["mdp"]);
        echo json_encode($protection);
        break;
    case "getCaisseDepotSouche":
        envoiRequete($objet->getCaisseDepotSouche($_GET["CA_No"], $_GET["DE_No"], $_GET["CA_Souche"]),$objet);
        break;
    case "getDepotUser":
        $depotClass = new DepotClass(0);
        echo json_encode($depotClass->getDepotUser($_GET["id"]));
        break;
    case "getCaisseDepot":
        $caisseClass = new CaisseClass(0,$this->db);
        $rows = $caisseClass->getCaisseDepot($_GET["id"]);
        echo json_encode($rows);
        break;
    case "connexionProctectionByProtNo":
        $protection = new ProtectionClass("","");
        $protection->connexionProctectionByProtNo($_GET["Prot_No"]);
        echo json_encode($protection);
        break;
    case "getTarif":
        envoiRequete($objet->getTarif(),$objet);
        break;
    case "getTarifCount":
        envoiRequete($objet->getTarifCount(),$objet);
        break;
    case "depotByDENo":
        envoiRequete($objet->getDepotByDE_No($_GET["DE_No"]),$objet);
        break;
    case "getPlanComptableByCGNum":
        envoiRequete($objet->getPlanComptableByCGNum($_GET["CG_Num"]),$objet);
        break;
    case "insertF_ArtCompta":
        $article = new ArticleClass(0);
        $article->insertF_ArtCompta($_GET["AR_Ref"],$_GET["ACP_Type"],$_GET["ACP_Champ"],str_replace(" - ","",$_GET["CG_Num"]),str_replace(" - ","",$_GET["CG_NumA"]),str_replace(" - ","",$_GET["TA_Code1"]),str_replace(" - ","",$_GET["TA_Code2"]),str_replace(" - ","",$_GET["TA_Code3"]),$_GET["PROT_No"]);
        break;
    case "insertF_FamCompta":
        $result=$objet->db->requete("SELECT *
                                            FROM F_FAMCOMPTA
                                            WHERE FCP_Type=".$_GET["FCP_Type"]." AND FCP_Champ=".$_GET["FCP_Champ"]." AND FA_CodeFamille='".$_GET["FA_CodeFamille"]."'");
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if ($rows != null) {
            execRequete($objet->modifF_FamCompta($_GET["FA_CodeFamille"],$_GET["FCP_Type"],$_GET["FCP_Champ"],str_replace(" - ","",$_GET["CG_Num"]),str_replace(" - ","",$_GET["CG_NumA"]),str_replace(" - ","",$_GET["TA_Code1"]),str_replace(" - ","",$_GET["TA_Code2"]),str_replace(" -","",$_GET["TA_Code3"])),$objet);
        }
        else{
            execRequete($objet->insertF_FamCompta($_GET["FA_CodeFamille"],$_GET["FCP_Type"],$_GET["FCP_Champ"],str_replace(" - ","",$_GET["CG_Num"]),str_replace(" - ","",$_GET["CG_NumA"]),str_replace(" - ","",$_GET["TA_Code1"]),str_replace(" - ","",$_GET["TA_Code2"]),str_replace(" -","",$_GET["TA_Code3"])),$objet);
        }
        break;
    case "getPlanAnalytiqueByCANum":
        envoiRequete($objet->getPlanAnalytiqueByCANum($_GET["CA_Num"]),$objet);
        break;
    case "getPlanAnalytique":
        envoiRequete($objet->getPlanAnalytique($_GET["type"],$_GET["N_Analytique"]),$objet);
        break;
    case "getPlanAnalytiqueHorsTotal":
        envoiRequete($objet->getPlanAnalytiqueHorsTotal($_GET["type"],$_GET["N_Analytique"]),$objet);
        break;
    case "getModeleReglement":
        envoiRequete($objet->getModeleReglement(),$objet);
        break;
    case "getModeleReglementCount":
        envoiRequete($objet->getModeleReglementCount(),$objet);
        break;

    case "getJournauxByJONum":
        envoiRequete($objet->getJournauxByJONum($_GET["JO_Num"]),$objet);
        break;
    case "getJournaux":
        $journal = new JournalClass(0);
        echo json_encode($journal->getJournaux($_GET["JO_Sommeil"]));
        break;
    case "getJournauxCount":
        envoiRequete($objet->getJournauxCount($_GET["JO_Sommeil"]),$objet);
        break;
    case "configMail":
        $liaisonMail = new LiaisonEnvoiMailUser();
        $liaisonMail ->getConfigMail($_GET["PROT_No"],$_GET["PROT_No_Profil"],$_GET["TE_No"],$_GET["Check"]);
        break;
    case "configSMS":
        $liaisonMail = new LiaisonEnvoiSMSUser();
        $liaisonMail ->getConfigSMS($_GET["PROT_No"],$_GET["PROT_No_Profil"],$_GET["TE_No"],$_GET["Check"]);
        break;
    case "configAccess":
        $protection = new ProtectionClass("","");
        $protection->updateEProtection($_GET["PROT_No_Profil"],$_GET["TE_No"],$_GET["Selected"]);
        break;
    case "configProfilUtilisateur":
        $protection = new ProtectionClass("","");
        $protection->updateProfil($_GET["PROT_No"],$_GET["TE_No"]);
        break;

    case "ajoutCodeClient":
        $code="";
        $libelle="";
        $type="";
        if(isset($_GET["code"]))
            $code=$_GET["code"];
        if(isset($_GET["libelle"]))
            $libelle=$_GET["libelle"];
        if(isset($_GET["type"]))
            $type=$_GET["type"];

        if($code!=""){
            $result=$objet->db->requete($objet->supprCodeClientByCode());
            for($i=0;$i<sizeof($code);$i++){
                $result=$objet->db->requete($objet->getCodeClientByCode($code[$i]));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if ($rows != null) {
                    //maj
                    $result=$objet->db->requete($objet->majCodeClientByCode($code[$i],$libelle[$i],$type[$i]));
                }else{
                    //create
                    $result=$objet->db->requete($objet->insertCodeClientByCode($code[$i],$libelle[$i],$type[$i]));
                }
            }
        }
        break;

    case "stat_articleParAgenceByMonth":
        $result=$objet->db->requete($objet->stat_articleParAgenceByMonth($_GET["DE_No"], $_GET["datedeb"], $_GET["datefin"], $_GET["article"], $_GET["famille"]));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);$depot="";
        $val = array();
        $nbval=0;
        $datapoints= array();
        if ($rows != null) {
            foreach ($rows as $row){
                if($depot==""){
                    $depot=$row->DE_Intitule;
                    $datapoints= array();
                }
                if($depot!=$row->DE_Intitule){
                    $data = array(type => "line",lineThickness => 3,showInLegend => true,name => "$row->DE_Intitule"
                    ,axisYType => "secondary",dataPoints => json_encode($datapoints));
                    array_push($val,$data);
                    $depot=$row->DE_Intitule;
                    $datapoints= array();
                    $nbval++;
                }
                else{
                    $dataD=array("x:" => $row->ANNEE,"y:" =>$row->CA_NET_HT);
                    array_push($datapoints,$dataD);
                }
            }
            if($nbval==0){
                $data = array(type => "line",lineThickness => 3,showInLegend => true,name => "$row->DE_Intitule"
                ,axisYType => "secondary",dataPoints => json_encode($datapoints, JSON_NUMERIC_CHECK));
                array_push($val,$data);
            }
        }
        echo json_encode($data);
        break;
    case "parametre":
        envoiRequete($objet->getParametre($_GET["id"]),$objet);
        break;
    case "compareVal":
        envoiRequete($objet->compareVal($_GET["ttc"],$_GET["avance"]),$objet);
        break;
    case "ResteARegler":
        $docEntete = new DocEnteteClass($_GET["cbMarq"]);
        echo json_encode($docEntete->ResteARegler($_GET["avance"]));
        break;
    case "caisse":
        envoiRequete($objet->caisse(),$objet);
        break;
        break;
    case "getInventairePrepa":
        envoiRequete($objet->getInventairePrepa($_GET["P1"],$_GET["P2"],$_GET["P3"],$_GET["P4"],$_GET["P5"],$_GET["P6"]),$objet);
        break;
    case "getAllArticleDispoByArRef":
        envoiRequete($objet->getAllArticleDispoByArRef($_GET['DE_No']),$objet);
        break;
    case "getAllArticleDispoByArRefTrsftDetail":
        envoiRequete($objet->getAllArticleDispoByArRefTrsftDetail($_GET['DE_No'],1),$objet);
        break;
    case "getAllArticle":
        envoiRequete($objet->getAllArticle(),$objet);
        break;
    case "recoiMsgSite":
        execRequete($objet->recoiMsgSite($_GET["nom"],$_GET["message"]),$objet);
        break;
    case "SendMsgSite":
        envoiRequete($objet->SendMsgSite(),$objet);
        break;
    case "ajoutEnteteFactureVente":
        $mobile="android";
        include("Traitement/Facturation.php");
        break;

    case "ajout_article":
        $mobile="android";
        include("Traitement/Creation.php");
        break;
    case "ajout_client":
        $mobile="android";
        include("Traitement/Creation.php");
        break;
    case "getEnteteDocument":
        $mobile="android";
        include("Traitement/Facturation.php");
        break;
    case "ajoutEnteteTicket":
        $mobile="android";
        include("Traitement/Facturation.php");
        break;
    case "ajoutEnteteEntree":
        $mobile="android";
        include("Traitement/Entree.php");
        break;
    case "verif_stock":
        $mobile="android";
        include("Traitement/Facturation.php");
        break;
    case "ajoutEnteteSortie":
        $mobile="android";
        include("Traitement/Sortie.php");
        break;
        break;
    case "ajoutEnteteTransfert":
        $mobile="android";
        include("Traitement/Transfert.php");
        break;
        break;
    case "ajoutEnteteFactureDevis":
        $mobile="android";
        include("Traitement/Facturation.php");
        break;
    case "ajoutEnteteFactureBonLivraison":
        $mobile="android";
        include("Traitement/Facturation.php");
        break;
    case "ajoutEnteteFactureAvoir":
        $mobile="android";
        include("Traitement/Facturation.php");
        break;
    case "ajoutEnteteFactureRetour":
        $mobile="android";
        include("Traitement/Facturation.php");
        break;
    case "ajoutEnteteFactureAchat":
        $mobile="android";
        include("Traitement/Facturation.php");
        break;
    case "ajoutLigneEntree":
        $mobile="android";
        include("Traitement/Entree.php");
        break;
    case "ajoutLigneSortie":
        $mobile="android";
        include("Traitement/Sortie.php");
        break;
    case "ajoutLigneTransfert":
        $mobile="android";
        include("Traitement/Transfert.php");
        break;
    case "regleVente" :
        $mobile="android";
        include("Traitement/Facturation.php");
        break;
    case "regleTicket" :
        $mobile="android";
        include("Traitement/Facturation.php");
        break;
    case "regleAchat" :
        $mobile="android";
        include("Traitement/Facturation.php");
        break;
    case "regleBonLivraison" :
        $mobile="android";
        include("Traitement/Facturation.php");
        break;
    case "ajoutLigneFactureVente" :
        $mobile="android";
        include("Traitement/Facturation.php");
        break;
    case "ajoutLigneTicket" :
        $mobile="android";
        include("Traitement/Facturation.php");
        break;
    case "ajoutLigneFactureDevis" :
        $mobile="android";
        include("Traitement/Facturation.php");
        break;

    case "ajoutLigneFactureBonLivraison" :
        $mobile="android";
        include("Traitement/Facturation.php");
        break;
    case "ajoutLigneFactureAvoir" :
        $mobile="android";
        include("Traitement/Facturation.php");
        break;
    case "ajoutLigneFactureRetour" :
        $mobile="android";
        include("Traitement/Facturation.php");
        break;
    case "ajoutLigneFactureAchat" :
        $mobile="android";
        include("Traitement/Facturation.php");
        break;
    case "vehicule":
        envoiRequete($objet->getVehicule(),$objet);
        break;
    case "getPlanCR":
        envoiRequete($objet->getPlanCR(),$objet);
        break;
    case "getNumContribuable":
        $protection = new ProtectionClass("","");
        echo json_encode($protection->getNumContribuable()[0]);
        break;

    case "getPrixClient":
        $article = new ArticleClass($_GET['AR_Ref']);
        echo json_encode($article->getPrixClient($_GET['N_CatCompta'], $_GET['N_CatTarif']));
        break;
    case "insertDepotClient":
        envoiRequete($objet->insertDepotClient($_GET['DE_No'], $_GET['CodeClient']),$objet);
        break;
    case "supprDepotClient":
        envoiRequete($objet->supprDepotClient($_GET['DE_No']),$objet);
        break;
    case "supprReglement":
        $reglement = new ReglementClass($_GET["RG_No"]);
        $reglement->supprReglement($_GET["PROT_No"]);
        break;
    //test sms
    case "envoiSMSTest":
        execRequete($objet->envoiSMSTest(($_GET['Code']),($_GET['Nom']),($_GET['Numero'])),$objet);
        break;
    case "getPrincipalDepot":
        envoiRequete($objet->getPrincipalDepot($_GET['id']),$objet);
        break;
    case "equationStkVendeur":
        envoiRequete($objet->equationStkVendeur($_GET['DE_No'], $_GET['datedeb'], $_GET['datefin']),$objet);
        break;
    case "stat_mouvementStock":
        $etat = new EtatClass();
        $result=$etat->stat_mouvementStock($_GET['DE_No'], $_GET['datedeb'], $_GET['datefin'], $_GET['articledebut'], $_GET['articlefin']);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($rows);
        break;
    case "stat_articleParAgence":
        envoiRequete($objet->stat_articleParAgence($_GET['DE_No'], $_GET['datedeb'], $_GET['datefin'],"0","0","0","3"),$objet);
        break;
    case "stat_clientParAgence":
        $etat = new EtatClass();
        envoiRequete($etat->stat_clientParAgence($_GET['DE_No'], $_GET['datedeb'], $_GET['datefin'],"3"),$objet);
        break;
    case "etatCaisse":
        $etat = new EtatClass();
        envoiRequete($etat->etatCaisse($_GET['CA_No'], $_GET['datedeb'], $_GET['datefin'],"0","-1"),$objet);
        break;
    case "invPreparatoire":
        $etat = new EtatClass(0);
        if($_GET["type"]==0)
            envoiRequete($etat->getPreparatoireCumul($_GET["DE_No"]), $objet);
        else
            envoiRequete($etat->getetatpreparatoire($_GET["DE_No"],$_GET['datedeb']),$objet);
        break;
    case "getPrixClientHT":
        $docligne = new DocLigneClass(0);
        echo json_encode($docligne->getPrixClientHT($_GET['AR_Ref'], $_GET['N_CatCompta'], $_GET['N_CatTarif'], $_GET['Prix'], $_GET['remise'],$_GET['qte'],$_GET['fournisseur']));
        break;
    case "stat_articleParAgenceArticle":
        envoiRequete($objet->stat_articleParAgenceArticle($_GET["depot"], $_GET["datedeb"], $_GET["datefin"], $_GET["article"], $_GET["famille"]),$objet);
        break;
    case "stat_articleAchatByCANum":
        envoiRequete($objet->stat_articleAchatByCANum("AR.AR_Ref,AR_Design", $_GET["datedeb"], $_GET["datefin"], $_GET["famille"], $_GET["article"], $_GET["N_Analytique"]),$objet);
        break;
    case "isStock":
        $article = new ArticleClass($_GET['AR_Ref']);
        echo json_encode($article->isStock($_GET['DE_No']));
        break;
    case "isStockDENo":
        $article = new ArticleClass($_GET['AR_Ref']);
        echo json_encode($article->isStockDENo($_GET['DE_No'],str_replace(' ','',str_replace(',','.',$_GET["DL_Qte"]))));
        break;
    case "verifSupprAjout":
        $docligne = new DocLigneClass($_GET["cbMarq"]);
        echo json_encode($docligne->verifSupprAjout());
        break;
    case "getClientByCTNum":
        $comptet = new ComptetClass($_GET['CT_Num']);
        echo json_encode($comptet->ctNum());
        break;
    case "getTypePlanComptableValue":
        $comptet = new ComptetClass($_GET['CT_Num']);
        echo json_encode($comptet);
        break;
    case "getJournalLastDate":
        $journal = new JournalClass(0);
        $result = $journal->getJournalLastDate($_GET['JO_Num'],$_GET['Mois'],$_GET['Annee']);
        echo json_encode($result);
        break;
    case "getTotalJournal":
        $journal = new JournalClass(0);
        $ctNum = "";
        $cgNum = "";
        $dateDebut = "";
        $dateFin = "";
        $lettrage =-1;
        $typeInterrogation ="";
        if(isset($_GET["typeInterrogation"]))
            $typeInterrogation = $_GET["typeInterrogation"];
        if(isset($_GET["CT_Num"]))
            $ctNum = $_GET["CT_Num"];
        if(isset($_GET["dateDebut"]))
            $dateDebut = $journal->formatDateSageToDate($_GET["dateDebut"]);
        if(isset($_GET["dateFin"]))
            $dateFin = $journal->formatDateSageToDate($_GET["dateFin"]);
        if(isset($_GET["lettrage"]))
            $lettrage = $_GET["lettrage"];
        if($typeInterrogation!="Tiers"){
            $cgNum = $ctNum;
            $ctNum = "";
        }
        $result = $journal->getTotalJournal($_GET['JO_Num'],$_GET['Mois'],$_GET['Annee'],$_GET['EC_Sens'],$ctNum,$dateDebut,$dateFin,$lettrage,$cgNum);
        echo json_encode($result);
        break;
    case "getLettrage":
        $journal = new JournalClass(0);
        $ctNum = "";
        $cgNum = "";
        $dateDebut = "";
        $dateFin = "";
        $typeInterrogation ="";
        if(isset($_GET["CT_Num"]))
            $ctNum = $_GET["CT_Num"];
        if(isset($_GET["dateDebut"]))
            $dateDebut =  $journal->formatDateSageToDate($_GET["dateDebut"]);
        if(isset($_GET["dateFin"]))
            $dateFin = $journal->formatDateSageToDate($_GET["dateFin"]);
        if(isset($_GET["typeInterrogation"]))
            $typeInterrogation = $_GET["typeInterrogation"];
        if($typeInterrogation!="Tiers"){
            $cgNum = $ctNum;
            $ctNum = "";
        }
        $result = $journal-> getLettrage($ctNum,$dateDebut,$dateFin,$cgNum);
        echo json_encode($result);
        break;


    case "getJournalPiece":
        $journal = new JournalClass($_GET['JO_Num']);
        $result = $journal->getJournalPiece($_GET['Annee']."-".$_GET['Mois']."-01");
        echo json_encode($result);
        break;
    case "getArticle":
        $article = new ArticleClass(0);
        echo json_encode($article->getShortList());
        break;
    case "getCalendarUser":
        $protection = new ProtectionClass("","");
        echo json_encode($protection->getZ_Calendar_user($_GET["PROT_No"],0));
        break;
    case "getTiers":
        $tiers = new ComptetClass(0);
        if($_GET["type"]==0)
            echo json_encode($tiers->allClientsSelect());
        else if($_GET["type"]==1)
            echo json_encode($tiers->allFournisseurSelect());
        else
            echo json_encode($tiers->all());

        break;
    case "getArticleWithStock":
        envoiRequete($objet->getArticleWithStock($_GET['DE_No']),$objet);
        break;
    case "getArticleWithStockMax":
        envoiRequete($objet->getArticleWithStockMax($_GET['DE_No']),$objet);
        break;
    case "getArticleWithStockAndroid":
        envoiRequete($objet->getArticleWithStockAndroid($_GET['DE_No']),$objet);
        break;
    case "getArticleWithStockAndroidCount":
        envoiRequete($objet->getArticleWithStockAndroidCount($_GET['DE_No']),$objet);
        break;
    case "addDocligneFacture":
        break;
    case "addDocenteteFacture":
        $mobile="android";
        include("Traitement/Facturation.php");
        break;
    case "getFacture":
        envoiRequete($objet->getFacture($_GET['DO_Tiers'], $_GET['datedeb'], $_GET['datefin']),$objet);
        break;
    case "selectDefautCompte":
        envoiRequete($objet->selectDefautCompte($_GET['ctype']),$objet);
        break;
    case "majCatCompta":
        if($_GET["cbMarq"]!="") {
            $docEntete = new DocEnteteClass($_GET["cbMarq"]);
            $docEntete->majByCbMarq("N_CatCompta", $_GET["N_CatCompta"], $_GET["cbMarq"]);
            $docEntete->majByCbMarq("DO_Tarif", $_GET["N_CatTarif"], $_GET["cbMarq"]);
        }
        break;
    case "ficheArticle":
        ?>
        <!-- <script>
            $("#pxAchat").inputmask({
                'alias': 'decimal',
                'groupSeparator': ' ',
                'autoGroup': true,
                'digits': 2,
                'rightAlign': true,
                'digitsOptional': false,
                'placeholder': '0.00'
            });
            $("#AF_Remise").inputmask({
                'alias': 'decimal',
                'groupSeparator': ' ',
                'autoGroup': true,
                'digits': 2,
                'rightAlign': true,
                'digitsOptional': false,
                'placeholder': '0.00'
            });
            $("#AF_Colisage").inputmask({
                'alias': 'decimal',
                'groupSeparator': ' ',
                'autoGroup': true,
                'digits': 2,
                'rightAlign': true,
                'digitsOptional': false,
                'placeholder': '0.00'
            });
            $("#AF_QteMini").inputmask({
                'alias': 'decimal',
                'groupSeparator': ' ',
                'autoGroup': true,
                'digits': 2,
                'rightAlign': true,
                'digitsOptional': false,
                'placeholder': '0.00'
            });
            $("#AF_ConvDiv").inputmask({
                'alias': 'decimal',
                'groupSeparator': ' ',
                'autoGroup': true,
                'digits': 2,
                'rightAlign': true,
                'digitsOptional': false,
                'placeholder': '0.00'
            });
            $("#AF_Conversion").inputmask({
                'alias': 'decimal',
                'groupSeparator': ' ',
                'autoGroup': true,
                'digits': 2,
                'rightAlign': true,
                'digitsOptional': false,
                'placeholder': '0.00'
            });


            $("#AF_PrixAch").inputmask({
                'alias': 'decimal',
                'groupSeparator': ' ',
                'autoGroup': true,
                'digits': 2,
                'rightAlign': true,
                'digitsOptional': false,
                'placeholder': '0.00'
            });

            $("#pxHT").inputmask({
                'alias': 'decimal',
                'groupSeparator': ' ',
                'autoGroup': true,
                'digits': 2,
                'rightAlign': true,
                'digitsOptional': false,
                'placeholder': '0.00'
            });

            $("#pxMin").inputmask({
                'alias': 'decimal',
                'groupSeparator': ' ',
                'autoGroup': true,
                'digits': 2,
                'rightAlign': true,
                'digitsOptional': false,
                'placeholder': '0.00'
            });

            $("#pxMax").inputmask({
                'alias': 'decimal',
                'groupSeparator': ' ',
                'autoGroup': true,
                'digits': 2,
                'rightAlign': true,
                'digitsOptional': false,
                'placeholder': '0.00'
            });

            $("#stock_min").inputmask({
                'alias': 'decimal',
                'groupSeparator': ' ',
                'autoGroup': true,
                'digits': 2,
                'rightAlign': true,
                'digitsOptional': false,
                'placeholder': '0.00'
            });

            $("#stock_max").inputmask({
                'alias': 'decimal',
                'groupSeparator': ' ',
                'autoGroup': true,
                'digits': 2,
                'rightAlign': true,
                'digitsOptional': false,
                'placeholder': '0.00'
            });

            $("#formArticleFactureBis").find(":input").each(function () {
                $(this).attr("readonly", true);
            });
        </script> !-->

        <?php
        $ref = "";
        $design = "";
        $pxAch = "";
        $famille = "";
        $pxVtHT = "";
        $pxVtTTC = "";
        $pxMin="";
        $pxMax="";
        $ar_cond=0;
        $cl_no1 = 0;
        $cl_no2 = 0;
        $cl_no3 = 0;
        $cl_no4 = 0;
        $fcl_no1 = 0;
        $fcl_no2 = 0;
        $fcl_no3 = 0;
        $fcl_no4 = 0;
        $CT_PrixTTC = 0;
        $objet = new ObjetCollector();
        $protection="";
        session_start();
        $protection = new ProtectionClass($_SESSION["login"],$_SESSION["mdp"]);
        $flagPxRevient =$protection->PROT_PX_REVIENT;
        $flagPxAchat =$protection->PROT_PX_ACHAT;
        $flagInfoLibreArticle =$protection->PROT_INFOLIBRE_ARTICLE;
        $admin = 0;
        if($protection ->PROT_Administrator==1 || $protection ->PROT_Right==1)
            $admin=1;
        $result=$objet->db->requete($objet->typeArticle());
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if($rows!=null){
            $CT_PrixTTC= $rows[0]->CT_PrixTTC;
        }

        $AR_Sommeil0="";
        $AR_Sommeil1="";
        if(isset($_GET["AR_Ref"])){
            $article = new ArticleClass($_GET["AR_Ref"]);
            $ref = $article->AR_Ref;
            $design = $article->AR_Design;
            $pxAch = $article->AR_PrixAch;
            $famille = $article->FA_CodeFamille;
            $ar_cond = $article->AR_Condition;
            $pxVtHT = $article->AR_PrixVen;
            $pxMin = $article->Prix_Min;
            $pxMax = $article->Prix_Max;
            $cl_no1 = $article->CL_No1;
            $cl_no2 = $article->CL_No2;
            $cl_no3 = $article->CL_No3;
            $cl_no4 = $article->CL_No4;
            $CT_PrixTTC= $article->AR_PrixTTC;
            $qte_gros = $article->Qte_Gros;
            if($article->AR_Sommeil==0)
                $AR_Sommeil0 = " selected ";
            if($article->AR_Sommeil==1)
                $AR_Sommeil1 = " selected ";
            if(isset($famille)){
                $familleClass = new FamilleClass($famille);
                $fcl_no1 = $familleClass->CL_No1;
                $fcl_no2 = $familleClass->CL_No2;
                $fcl_no3 = $familleClass->CL_No3;
                $fcl_no4 = $familleClass->CL_No4;
            }
        }
        $cbIndice=0;
        $PrixTTC_Design = "HT";
        if($CT_PrixTTC==1) $PrixTTC_Design = "TTC";
        function valTTC($id){
            if($id==1) return "TTC";
            else return "HT";
        }

        $flagProtected = $protection->protectedType("article");
        $flagSuppr = $protection->SupprType("article");
        $flagNouveau = $protection->NouveauType("article");
        $ficheArticle =1;
        ?>
        <?php
        include("pages/Structure/CreationArticle.php");
        break;
    case "getNextArticleByFam":
        $famille = new FamilleClass(0);
        echo json_encode($famille->getNextArticleByFam($_GET['codeFam']));
        break;
    case "getCaisseByCA_No":
        $caisse = new CaisseClass(0);
        $rows = $caisse->getCaisseByCA_No($_GET['CA_No']);
        if(sizeof($rows)>0)
            echo json_encode($rows[0]);
        break;
    case "getArticleByRef":
        $article = new ArticleClass($_GET['AR_Ref']);
        echo json_encode($article);
        break;
    case "getArticleByDesignation":
        envoiRequete($objet->getArticleByDesignation($_GET['Design']),$objet);
        break;
    case "getFamille":
        $famille = new FamilleClass(0);
        echo json_encode($famille->getShortList());
        break;
    case "getFamilleCount":
        $famille = new FamilleClass(0);
        echo json_encode($famille->getFamilleCount());
        break;
    case "getConditionnement":
        envoiRequete($objet->getConditionnement(),$objet);
        break;
    case "getConditionnementMax":
        envoiRequete($objet->getConditionnementMax(),$objet);
        break;

    case "getFactureCO":
        envoiRequete($objet->getFactureCO($_GET['CO_No'], $_GET['CT_Num']),$objet);
        break;
    case "getFactureCORecouvrement":
        $collab=0;
        if(isset($_GET["collab"]))
            $collab = $_GET["collab"];
        $docEntete = new DocEnteteClass(0);
        echo json_encode($docEntete->getFactureCORecouvrement($collab, $_GET['CT_Num']));
        break;
    case "getFactureRGNo":
        $reglement = new ReglementClass(0);
        echo json_encode($reglement->getFactureRGNo($_GET['RG_No']));
        break;
    case "updateDrRegle":
        $result=$objet->db->requete($objet->updateDrRegle($_GET['RG_No']));
        break;
    case "calculSoldeLettrage" :
        $journal = new JournalClass(0);
        echo json_encode($journal->calculSoldeLettrage($_GET["listCbMarq"]));
        break;
    case "pointerEcriture" :
        $journal = new JournalClass(0);
        echo json_encode($journal->pointerEcriture($_GET["annuler"],$_GET["listCbMarq"],$_GET["ecLettrage"]));
        break;
    case "getSoucheDepotCaisse":
        $protection = new ProtectionClass("","");
        $rows = $protection->getSoucheDepotCaisse($_GET["prot_no"],$_GET["type"],$_GET["souche"],$_GET["ca_no"],$_GET["DE_No"],$_GET["CA_Num"]);
        if(sizeof($rows)>0)
            echo json_encode($rows[0]);
        break;
    case "getSoucheVente":
        envoiRequete($objet->getSoucheVente(),$objet);
        break;
    case "getSoucheVenteByIndice":
        envoiRequete($objet->getSoucheVenteByIndice($_GET["indice"]),$objet);
        break;
    case "updateDrRegleByDOPiece":
        $docEntete = new DocEnteteClass(0);
        $docEntete->isRegleFullDOPiece($_GET['cbMarq']);
        break;
    case "updateImpute":
        $reglement = new ReglementClass(0);
        $reglement->updateImpute();
        break;
    case "getReglementByClient":
        $typeSelectRegl = 0;
        if (isset($_GET["typeSelectRegl"]))
            $typeSelectRegl = $_GET["typeSelectRegl"];
        $reglement = new ReglementClass(0);
        echo json_encode($reglement->getReglementByClient($_GET['CT_Num'], $_GET['CA_No'], $_GET['type'], $_GET['treglement'], $_GET['datedeb'], $_GET['datefin'], $_GET['caissier'], $_GET['collaborateur'], $_GET['PROT_No'], $typeSelectRegl));
        break;
    case "listeTypeReglement":
        envoiRequete($objet->listeTypeReglement(),$objet);
        break;
    case "getJournauxTreso":
        envoiRequete($objet->getJournauxTreso(),$objet);
        break;

    case "listeTypeReglementCount":
        envoiRequete($objet->listeTypeReglementCount(),$objet);
        break;

    case "convertTransToRegl":
        $result = $objet->db->requete($objet->getCaisseByCA_No($_GET["CA_No"]));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $co_nocaissier = $rows[0]->CO_NoCaissier;
        $jo_num = $rows[0]->JO_Num;
        envoiRequete($objet->convertTransToRegl($_GET["CA_No"],$co_nocaissier,$jo_num,$_GET["RG_No"]),$objet);
        break;

    case "getCaissier" :
            $caisse = new CaisseClass(0);
            echo json_encode($caisse->allCaissier());
        break;
    case "getCatComptaByArRef" :
        envoiRequete($objet->getCatComptaByArRef($_GET['AR_Ref'],$_GET['ACP_Champ'],$_GET['ACP_Type']),$objet);
        break;
    case "getCatComptaByCodeFamille" :
        envoiRequete($objet->getCatComptaByCodeFamille($_GET['FA_CodeFamille'],$_GET['ACP_Champ'],$_GET['ACP_Type']),$objet);
        break;
    case "getCaissierByCaisse" :
        $caisseClass = new CaisseClass(0);
        echo json_encode($caisseClass->getCaissierByCaisse($_GET['CA_No']));
        break;
    case "getReglementByClientFacture":
        envoiRequete($objet->getReglementByClientFacture($_GET['CT_Num'],$_GET['DO_Piece']),$objet);
        break;
    case "getCompteg":
        $compteg = new CompteGClass(0);
        echo json_encode($compteg ->allShort());
        break;
    case "getCompteaByIntitule":
        $comptea = new CompteaClass(0);
        echo json_encode($comptea->allSearch($_GET["term"],10));
        break;
    case "getComptegByCGNum":
        $compteg = new CompteGClass(0,$objet->db);
        $term="";
        if(isset($_GET["term"]))
            $term=$_GET["term"];
        if(isset($_GET["searchTerm"]))
            $term=$_GET["searchTerm"];
        echo json_encode($compteg->allSearch($term,10));
        break;
    case "getEmplacement":
        $DepotEmplClass = new DepotEmplClass(0,$objet->db);
        $term="";
        if(isset($_GET["term"]))
            $term=$_GET["term"];
        if(isset($_GET["searchTerm"]))
            $term=$_GET["searchTerm"];
        $protectionClass = new ProtectionClass("","",$objet->db);
        $protectionClass->connexionProctectionByProtNo($_GET["protNo"]);
        if($protectionClass->PROT_Right == 1)
            echo json_encode($DepotEmplClass->allSearch($term,10));
        else
            echo json_encode($DepotEmplClass->allSearchUser($term,$_GET["protNo"],10));
    break;

    case "findDocByPiece":
        $docEntete = new DocEnteteClass(0);
        $protection = new ProtectionClass("","");
        $protection->connexionProctectionByProtNo($_GET["PROT_No"]);
        $docEntete->setTypeFac($_GET["type_fac"]);
        $listFacture = $docEntete->listeFacture(0,"","",$_GET["PROT_No"],"",$_GET["value"]);

        $admin=0;

        if($protection->PROT_Administrator==1 || $protection->PROT_Right==1)
            $admin=1;

        $typeListe= "documentVente";
        if($docEntete->DO_Domaine==4 || $docEntete->DO_Domaine == 2 || $docEntete->type_fac =="Transfert_valid_confirmation")
            $typeListe = "documentStock";
        if($docEntete->DO_Domaine == 1)
            $typeListe = "documentAchat";
        $protected = $protection->protectedType($docEntete->type_fac);

        $protectedSuppression = $protection->SupprType($typeListe);
        $protectedNouveau = $protection->NouveauType($docEntete->type_fac);

        foreach ($listFacture as $row){
            $message="";
            $avance="";
            $total = round($row->ttc);
            if($docEntete->type_fac=="Ticket" || $docEntete->DO_Domaine ==1 || $docEntete->DO_Domaine == 0){
                $avance = round($row->avance);
                if($avance==null) $avance = 0;
                $message =$row->statut;
            }
            $date = new DateTime($row->DO_Date);
            ?>
            <tr data-toggle="tooltip" data-placement="top" title="<?= $row->PROT_User ?>"
            class='facture' id='article_<?= $row->DO_Piece ?>'>
            <td id='entete'><a href='<?= $docEntete->lien($row->cbMarq) ?>'><?= $row->DO_Piece ?></a></td>
            <td id="DO_Ref"><?= $row->DO_Ref ?></td>
            <td class="d-none"><span class="d-none" id='cbMarq'><?= $row->cbMarq ?></span>
                <span style='display:none' id='DL_PieceBL'><?= $row->DL_PieceBL ?></span>
                <span style='display:none' id='cbCreateur'><?= $row->PROT_User ?></span>
            </td>
            <td id="DO_Date"><?= $date->format('d-m-Y') ?></td>
            <?php
            if($docEntete->DO_Domaine==0 || $docEntete->DO_Domaine==1)
                echo "<td>{$row->CT_Intitule}</td>";
            if($docEntete->DO_Domaine==0 || $docEntete->DO_Domaine==1 || $docEntete->type_fac=="Entree"|| $docEntete->type_fac=="Sortie")
                echo "<td>{$row->DE_Intitule}</td>";
            if($docEntete->type_fac=="Transfert_detail" || $docEntete->type_fac=="Transfert" || $docEntete->type_fac=="Transfert_confirmation" || $docEntete->type_fac=="Transfert_valid_confirmation")
                echo"<th>{$row->DE_Intitule}</th>
                                            <th>{$row->DE_Intitule_dest}</th>";
            ?>
            <td><?= $objet->formatChiffre($total) ?></td>
            <?php
            if($docEntete->type_fac=="Ticket" || ($docEntete->DO_Domaine==0 && ($docEntete->DO_Type!=0 && $docEntete->DO_Type!=1)) ||  $docEntete->DO_Domaine==1)
                echo "<td>{$objet->formatChiffre($avance)}</td>
                                        <td id='statut'>{$message}</td>";
            if(($docEntete->type_fac=="BonLivraison" || $docEntete->type_fac=="Devis") && ($admin==1 || ($protected))) echo '<td><input type="button" class="btn btn-primary" value="Convertir en facture" id="transform"/></td>';
            if(($protectedSuppression)){
                echo "<td id='supprFacture'>";
                if($protectedSuppression) //if(($type=="Ticket" || $type=="BonLivraison" || $type=="Vente" || $type=="AchatRetour" || $type=="AchatRetourC" || $type=="AchatRetourT" || $type=="AchatT" || $type=="VenteT" || $type=="VenteC" || $type=="Achat" || $type=="AchatC" || $type=="Entree"|| $type=="Sortie"|| $type=="Transfert"|| $type=="Transfert_valid_confirmation" || $type=="Transfert_confirmation" || $type=="Transfert_detail") && $avance==0)
                    echo "<i class='fa fa-trash-o'></i></td>";
            }
            echo "<td>";
            if($docEntete->type_fac!="Transfert_valid_confirmation" && $row->DO_Imprim ==1)
                echo "<i class='fa fa-print'></i>";
            echo "</td>";
            if($protection->PROT_CBCREATEUR!=2)
                echo "<td>{$row->PROT_User}</td>";
            echo "</tr>";
        }
        break;

    case "displayListeFacture":
        $protectionClass = new ProtectionClass("","");
        $protectionClass->connexionProctectionByProtNo($_GET["protNo"]);
        $docEntete = new DocEnteteClass(0);
        $docEntete->setTypeFac(($_GET["type"] !="undefined") ? $_GET["type"] : $_GET["typeFac"]);
        $admin=0;
        if($protectionClass->PROT_Administrator==1 || $protectionClass->PROT_Right==1)
            $admin=1;

        $typeListe= "documentVente";
        if($docEntete->DO_Domaine==4 || $docEntete->DO_Domaine == 2 || $docEntete->type_fac=="Transfert_valid_confirmation")
            $typeListe = "documentStock";
        if($docEntete->DO_Domaine == 1)
            $typeListe = "documentAchat";

        $protected = $protectionClass->protectedType($docEntete->type_fac);
        $protectedSuppression = $protectionClass->SupprType($typeListe);
        $protectedNouveau = $protectionClass->NouveauType($docEntete->type_fac);
        $docEntete = $docEntete->displayListeFacture($_GET["depot"],$_GET["datedeb"],$_GET["datefin"],$_GET["client"],$admin,$protected,$protectedSuppression,$protectionClass->PROT_CBCREATEUR,$_GET["protNo"]);
        break;

    case "setListEmplacement":
        $depotClass = new DepotClass(0);
        echo json_encode($depotClass->listEmpl($_GET["listId"],$_GET["PROT_No"]));
        break;
    case "headerSaisiJournalHtml":
        $journal = new JournalClass(0);
        foreach ($journal->headerSaisiJournal($_GET["exercice"],$_GET["JO_Num"]) as $value){
            ?>
            <div class="row">
                <div class="col-4 col-lg-2"><?= $value->Libelle ?></div>
                <div class="col-4 col-lg-2 text-right"><?= ($value->Debit==0) ? "" : $objet->formatChiffre($value->Debit) ?></div>
                <div class="col-4 col-lg-2 text-right"><?= ($value->Credit==0) ? "" : $objet->formatChiffre($value->Credit) ?></div>
            </div>
            <?php
        }
        break;
    case "headerSaisiJournal":
        $journal = new JournalClass(0,$objet->db);
        echo json_encode($journal->headerSaisiJournal($_GET["exercice"],$_GET["JO_Num"],$_GET["position"])[0]);
        break;
    case "getCANumByCaisse" :
        $caisse = new CaisseClass($_GET["CA_No"],$objet->db);
        echo json_encode($caisse->getCaNum());
        break;
    case "getComptegCount":
        $compteg = new CompteGClass(0,$objet->db);
        echo json_encode($compteg->getComptegCount());
        break;
    case "tableau":
        $date = getdate();
        if($_GET["latitude"]!=0 && $_GET["longitude"]!=0)
            $file = $_GET["latitude"]."_".$_GET["longitude"]."_".$_GET["reponseIp"].$_GET["contrib"].$date["year"].substr("00".$date["mon"],-2).substr("00".$date["mday"],-2).'.txt';
        else
            $file = $_GET["reponseIp"].$_GET["contrib"].$date["year"].substr("00".$date["mon"],-2).substr("00".$date["mday"],-2).'.txt';
        fopen($file, "w+");
        $current = file_get_contents($file);
        $current .= "IP : ".$_GET["reponseIp"]."\n";
        $current .= "Location: " . $_GET["reponseLocation"]."\n";
        $current .= "latitude: ". $_GET["latitude"].", longitude: ".$_GET["latitude"];
        file_put_contents($file, $current);
        break;
    case "getCatCompta":
        $catComptaClass = new CatComptaClass(0,$objet->db);
        echo json_encode($catComptaClass->getCatCompta());
        break;
    case "getCatComptaAll":
        $catComptaClass = new CatComptaClass(0,$objet->db);
        echo json_encode($catComptaClass->getCatComptaAll());
        break;
    case "getCatComptaAllCount":
        $catComptaClass = new CatComptaClass(0,$objet->db);
        echo json_encode($catComptaClass->getCatComptaAllCount());
        break;

    case "getCatComptaCount":
        $catComptaClass = new CatComptaClass(0,$objet->db);
        echo json_encode($catComptaClass->getCatComptaCount());
        break;
    case "insertClient":
        envoiRequete($objet->createClientMin($_GET["CT_Num"],$_GET["CT_Intitule"],$_GET["CG_Num"],$_GET["adresse"],$_GET["cp"],$_GET["ville"],$_GET["coderegion"],$_GET["siret"],$_GET["ape"],$_GET["numpayeur"],$_GET["co_no"],$_GET["cattarif"],$_GET["catcompta"],$_GET["de_no"],$_GET["tel"],$_GET["anal"]).";".$objet->getLastClient(),$objet);
        break;
    case "modifReglement":
        $fcreglement = new ReglementClass(0);
        $boncaisse = 0;
        if (isset($_GET["boncaisse"]) && $_GET["boncaisse"] == 1) {
            $boncaisse = 1;
        }
        $fcreglement->majReglement($_GET["protNo"], $boncaisse, $_GET["rg_no"], $_GET["rg_libelle"], $_GET["rg_montant"], $_GET["rg_date"], $_GET["JO_Num"], $_GET["CT_Num"], $_GET["CO_No"]);

        break;
    case "removeFacRglt":
        $docEntete = new DocEnteteClass($_GET["cbMarqEntete"]);
        $docEntete->removeFacRglt($_GET["RG_No"]);
        break;
    case "supprRglt":
        $creglement = new ReglementClass($_GET["RG_No"],$objet->db);
        try {
            $objet->db->connexion_bdd->beginTransaction();
            //        $log = new LogFile();
            //        $log->writeReglement("Suppr Reglement",$creglement->RG_Montant,$creglement->RG_No,$creglement->RG_Piece,$creglement->cbMarq,"F_CREGLEMENT",$_GET["protNo"],$creglement->cbCreateur);
            $creglement->delete($_GET["protNo"]);
            $creglement->deleteF_ReglementVrstBancaire($_GET["RG_No"]);
            $creglement->deleteF_ReglementCaNum($_GET["RG_No"]);
            if(isset($_GET["RG_No_Dest"]) && $_GET["RG_No_Dest"]!=0) {
                $creglement = new ReglementClass($_GET["RG_No_Dest"],$objet->db);
                //$log->writeReglement("Suppr Reglement", $creglement->RG_Montant, $creglement->RG_No, $creglement->RG_Piece, $creglement->cbMarq, "F_CREGLEMENT", $_GET["protNo"],$creglement->cbCreateur);
                $creglement->delete($_GET["protNo"]);
            }
            $objet->db->connexion_bdd->commit();
        }
        catch(Exception $e){
            $objet->db->connexion_bdd->rollBack();
            return json_encode($e);
        }
        break;
    case "remboursementRglt":
        $reglement = new ReglementClass($_GET["RG_No"]);
        $reglement->remboursementRglt($_GET["RG_Date"],$_GET["RG_Montant"]);
        break;
    case "addReglement":
        $jo_num = "";
        if(isset($_GET["JO_Num"]))
            $jo_num = $_GET["JO_Num"];
        $rg_no_lier = 0;
        if(isset($_GET["RG_NoLier"]))
            $rg_no_lier = $_GET["RG_NoLier"];
        $cg_num = "";
        $ct_num=$_GET['CT_Num'];
        $ca_no = $_GET['CA_No'];
        $boncaisse=0;
        $banque = 0;
        if(isset($_GET["boncaisse"]) && $_GET["boncaisse"]==1) {
            $boncaisse = $_GET["boncaisse"];
        }
        $libelle = $_GET['libelle'];
        $caissier = $_GET['caissier'];
        $date = $_GET['date'];
        $reglement = new ReglementClass(0);

        if($_GET["mode_reglementRec"]=="05"){
            $libelle = "Verst distant $libelle";
        }

        $reglement->addReglement($_GET['PROT_No'],""/*$_GET["mobile"]*/,$jo_num/*$_GET["JO_Num"]*/,$rg_no_lier/*$_GET["RG_NoLier"]*/,$ct_num /*$_GET['CT_Num']*/
            ,$ca_no/*$_GET["CA_No"]*/,$boncaisse /*$_GET["boncaisse"]*/,$libelle /*$_GET['libelle']*/,$caissier /*$_GET['caissier']*/
            ,$date/*$_GET['date']*/,$_GET["mode_reglementRec"] /*$_GET["mode_reglementRec"]*/
            ,$_GET['montant'] /*$_GET['montant']*/,$_GET['impute']/*$_GET['impute']*/,$_GET['RG_Type'] /*$_GET['RG_Type']*/,false,"");
        break;

    case "ajoutReglementLigne" :
        $data['file'] = $_FILES;
        $data['text'] = $_POST;
        echo json_encode($data);
        break;
    case "ValideSaisie_comptable" :
        envoiRequete($objet->ValideSaisie_comptable($_GET["DO_Domaine"],$_GET["DO_Type"],$_GET["DO_Piece"]),$objet);
        break;

    case "getConnect":
        session_start();
        echo json_encode($_SESSION);
        break;
    case "addEcheance":
        $type_regl = "";
        if(isset($_GET['type_regl']))
            $type_regl = $_GET['type_regl'];
        $reglement = new ReglementClass(0);
        $reglement->addEcheance($_GET["protNo"], $_GET["cr_no"], $type_regl, $_GET["cbMarqEntete"], round($_GET["montant"]));
        /*
        $docEntete = new DocEnteteClass($_GET["cbMarqEntete"]);
        $docRegl = new DocReglClass(0);
        $cbMarqDocRegl = $docEntete->getcbMarqDocRegl();
        if($cbMarqDocRegl!=0)
            $docRegl = new DocReglClass($cbMarqDocRegl);
        if($cbMarqDocRegl==0)
            $cbMarqDocRegl = $docRegl->addDocRegl($docEntete->DO_Domaine,$docEntete->DO_Type,$docEntete->DO_Piece,0,$reglement->N_Reglement,$docEntete->DO_Date);
        if($type_regl=="Collaborateur") {
            $docRegl = new DocReglClass($cbMarqDocRegl);
            $reglement->CT_NumPayeur = $docEntete->DO_Tiers;
            $reglement->maj("CT_NumPayeur",  $docEntete->DO_Tiers);
        }
        $docRegl = new DocReglClass($cbMarqDocRegl);
        $reglEch = new ReglEchClass(0);
        $reglEch->addReglEch($reglement->RG_No, $docRegl->DR_No,$docEntete->DO_Domaine,$docEntete->DO_Type,$docEntete->DO_Piece, round($_GET["montant"]));
//        echo json_encode($record);
        */
        break;
    case "getLigneFacture":
        envoiRequete($objet->getLigneFacture($_GET['DO_Piece'],$_GET['DO_Domaine'],$_GET['DO_Type']),$objet);
        break;
    case "getAffaire":
        envoiRequete($objet->getAffaire(),$objet);
        break;
    case "updateReglementCaisse":
        $mobile ="";
        execRequete($objet->updateReglementCaisse(str_replace("'", "''", $_GET['RG_Libelle']),$_GET['RG_Montant'],$_GET['RG_No']),$objet);
        if($objet->db->flagDataOr==1) {
            $creglement = new ReglementClass(0);
            $creglement->setuserName("",$mobile);
            $creglement->majZ_REGLEMENT_ANALYTIQUE($_GET["RG_No"], $_GET["CA_Num"]);
            $result = $objet->db->requete($objet->getCollaborateurEnvoiMail("Modification mouvement de caisse"));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if ($rows != null) {
                foreach ($rows as $row) {
                    $email = $row->CO_EMail;
                    $nom= $row->CO_Prenom." ".$row->CO_Nom;
                    $tiers = new ComptetClass($creglement->CT_NumPayeur);
                    $corpsMail="
                Le règlement ".$creglement->RG_Piece." a été supprimé par ".$_SESSION["login"]."<br/>
                    Le règlement concerne le client ".$tiers->CT_Intitule."<br/> 
                    Libellé :".$creglement->RG_Libelle."<br/> 
                    Montant du règlement : ".$objet->formatChiffre(ROUND($creglement->RG_Montant,2))."<br/> 
                    Date du règlement : ".$objet->getDateDDMMYYYY($creglement->RG_Date)."<br/><br/>
                Cordialement.<br/><br/>
                
                ";
                    if (preg_match('#^[\w.-]+@[\w.-]+\.[a-z]{2,6}$#i', $email)){
                        $mail = new Mail();
                        $mail->sendMail($corpsMail."<br/><br/><br/> {$this->db->db}", $email,  "Modification mouvement de caisse {$creglement->RG_Piece}");
                    }
                }
            }
        }
        break;
    case "updateReglementCaisseDAF":
        $fichier = $_GET['nomFichier'];
        if($fichier!="")
            $result=$objet->db->requete($objet->insert_REGLEMENTPIECE($_GET['RG_No'],$fichier));
        execRequete($objet->updateReglementCaisseDAF(str_replace("'", "''", $_GET['RG_Libelle']),$_GET['RG_No']),$objet);
        break;
    case "listeReglementCaisse":
        $reglementClass = new ReglementClass(0);
        envoiRequete($reglementClass->listeReglementCaisse($_GET["datedeb"],$_GET["datefin"],$_GET["ca_no"],$_GET["type"],$_GET["Prot_No"]));
        break;
    case "detteMois":
        session_start();
        $etat = new EtatClass();
        $listTopDetteMois =  $etat->detteDuMois($_GET["protNo"],$_GET["month"]);
        ?>
        <thead>
                        <tr>
                            <th>Intitule</th>
                            <th style="width: 100px">Reste à payer</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $totalResteAPayer = 0;
                        foreach ($listTopDetteMois as $value){
                            $totalResteAPayer = $totalResteAPayer + $value->Reste_A_Payer;
                            ?>
                            <tr>
                                <td><?= $value->CT_Intitule ?></td>
                                <td class="text-right"><?= $objet->formatChiffre($value->Reste_A_Payer) ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                        <tfoot class="font-weight-bold">
                            <td>Total</td>
                            <td class="text-right"><?= $objet->formatChiffre($totalResteAPayer) ?></td>
                        </tfoot>
    <?php
        break;
    case "statistiqueCaisse":
        session_start();
        ?>
        <thead>
        <tr>
            <th>Caisse</th>
            <th class="text-center" style="width: 150px">Solde Initial</th>
            <th class="text-center" style="width: 150px">Entrée</th>
            <th class="text-center" style="width: 150px">Sortie</th>
            <th class="text-center" style="width: 150px">Solde Final</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $totalDebit = 0;
        $totalCredit = 0;
        $totalSoldeInitial = 0;
        $totalSoldeFinal = 0;

        $etat = new EtatClass();
        $listStatCaisseDuJour =  $etat->statCaisseDuJour($_GET["PROT_No"]);
        foreach ($listStatCaisseDuJour as $value){
            $totalDebit = $totalDebit + $value->DEBIT;
            $totalCredit = $totalCredit + $value->CREDIT;
            $totalSoldeInitial = $totalSoldeInitial + $value->SoldeInitial;
            $totalSoldeFinal = $totalSoldeFinal + $value->SoldeFinal;
            ?>
            <tr>
                <td><?= $value->CA_Intitule ?></td>
                <td class="text-right"><?= $objet->formatChiffre($value->SoldeInitial) ?></td>
                <td class="text-right"><?= $objet->formatChiffre($value->CREDIT) ?></td>
                <td class="text-right"><?= $objet->formatChiffre($value->DEBIT) ?></td>
                <td class="text-right"><?= $objet->formatChiffre($value->SoldeFinal) ?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
        <tfoot class="font-weight-bold">
        <td>Total</td>
        <td class="text-right"><?= $objet->formatChiffre($totalSoldeInitial) ?></td>
        <td class="text-right"><?= $objet->formatChiffre($totalCredit) ?></td>
        <td class="text-right"><?= $objet->formatChiffre($totalDebit) ?></td>
        <td class="text-right"><?= $objet->formatChiffre($totalSoldeFinal) ?></td>
        </tfoot>
        <?php
        break;
    case "top10Vente":
        session_start();
        $flagPxRevient = $_GET["flagPrixRevient"];
        $etat = new EtatClass();
        $list =  $etat->top10Vente($_GET["period"],$_GET["month"]);
        ?>
            <thead>
                <tr>
                    <th>Désignation</th>
                    <th style="width: 150px">CA</th>
                    <?php if($flagPxRevient==0) echo "<th style=\"width: 150px\">Marge</th>" ?>
                </tr>
                </thead>
                <tbody>
                    <?php
                    $totalCATTCNet = 0;
                    $totalMarge = 0;
                    foreach ($list as $value){
                        $totalCATTCNet = $totalCATTCNet +$value->CATTCNet;
                        $totalMarge = $totalMarge +$value->Marge;
                        ?>
                        <tr>
                            <td><?= $value->AR_Design ?></td>
                            <td class="text-right"><?= $objet->formatChiffre($value->CATTCNet) ?></td>
                            <?php if($flagPxRevient==0) echo "<td class=\"text-right\">{$objet->formatChiffre($value->Marge)}</td>" ?>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
                <tfoot class="font-weight-bold">
                    <td>Total</td>
                    <td class="text-right"><?= $objet->formatChiffre($totalCATTCNet) ?></td>
                    <?php if($flagPxRevient==0) echo "<td class='text-right'>{$objet->formatChiffre($totalMarge)}</td>"; ?>
                </tfoot>
        <?php
        break;
    case "listeTable":
        $reglement = new ReglementClass(0);
        $rows = $reglement->getMajAnalytique($objet->getDate($_GET["dateDeb"]),$objet->getDate($_GET["dateFin"]),$_GET["statut"],$_GET["caNum"]);
        foreach ($rows as $row){
            ?>
            <tr>
                <td><?= $row->RG_No ?></td>
                <td><?= $objet->getDateDDMMYYYY($row->RG_Date) ?></td>
                <td><?= $row->CG_Num ?></td>
                <td><?= $row->RG_Libelle ?></td>
                <td class="text-right"><?= $objet->formatChiffre($row->RG_Montant) ?></td>
                <td><?= $row->CA_Intitule ?></td>
                <td class="text-center"> -> </td>
                <td><?= $row->CA_Num ?></td>
                <td class="text-right"><?= $objet->formatChiffre($row->EA_Montant) ?></td>
            </tr>
            <?php
        }
        break;
    case "getComptetg":
        $compteg = new CompteGClass($_GET["CG_Num"]);
        echo json_encode($compteg->getComtpetg());
        break;
    case "listeTableNonComptabiliser":
        $reglement = new ReglementClass(0);
        $rows = $reglement->getMajAnalytiqueNonComptabilisable($objet->getDate($_GET["dateDeb"]),$objet->getDate($_GET["dateFin"]),$_GET["caNum"]);
        if(sizeof($rows)>0){
            ?>
            <div>Les règlements suivants ne peuvent pas être comptabilisés ! L'écriture comptable n'existent pas !</div>
                <?php
            foreach ($rows as $row){
                ?>
                <div><?= $row->RG_No ?></div>
                <?php
            }
        }
        break;
    case "listeReglementCaisseFormat":
        if(isset($_GET["BQ_No"])){
            $banque = new BanqueClass(0,$objet->db);
            $list = $banque->listeReglementBanque($objet->getDate($_GET["datedeb"]), $objet->getDate($_GET["datefin"]), $_GET["BQ_No"], $_GET["type"], $_GET["Prot_No"]);
            $banque->afficheMvtBanque($list, $_GET["flagAffichageValCaisse"], $_GET["flagCtrlTtCaisse"]);
        }else {
            $reglement = new ReglementClass(0,$objet->db);
            $list = $reglement->listeReglementCaisse($objet->getDate($_GET["datedeb"]), $objet->getDate($_GET["datefin"]), $_GET["ca_no"], $_GET["type"], $_GET["Prot_No"]);
            $reglement->afficheMvtCaisse($list, $_GET["flagAffichageValCaisse"], $_GET["flagCtrlTtCaisse"]);
        }
        break;
    case "getCompteEntree":
        envoiRequete($objet->getCompteEntree(),$objet);
        break;
    case "getCompteSortie":
        envoiRequete($objet->getCompteSortie(),$objet);
        break;
    case "getPPreference":
        envoiRequete($objet->getPPreference(),$objet);
        break;
    case "clients":
        switch ($_GET["op"]) {
            case "tiers":
                $comptet = new ComptetClass(0);
                echo json_encode($comptet->allTiersMax());
                break;
            case "tiersMax":
                $comptet = new ComptetClass(0);
                echo json_encode($comptet->allTiersMax());
                break;
            case "all":
                $comptet = new ComptetClass(0);
                echo json_encode($comptet->allClients());
                break;
            case "fournisseur":
                $comptet = new ComptetClass(0);
                echo json_encode($comptet->allFournisseur());
                break;
            default:
                $comptet = new ComptetClass($_GET["op"]);
                echo json_encode($comptet->allClients());
                break;
        }
        break;
}



?>
