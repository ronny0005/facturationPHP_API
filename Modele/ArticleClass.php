<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class ArticleClass Extends Objet{
    //put your code here
    public $db,$AR_Ref
    ,$AR_Design
    ,$FA_CodeFamille
    ,$AR_Substitut
    ,$AR_Raccourci
    ,$AR_Garantie
    ,$AR_UnitePoids
    ,$AR_PoidsNet
    ,$AR_PoidsBrut
    ,$AR_UniteVen
    ,$AR_PrixAch
    ,$AR_Coef
    ,$AR_PrixVen
    ,$AR_PrixTTC
    ,$AR_Gamme1
    ,$AR_Gamme2
    ,$AR_SuiviStock
    ,$AR_Nomencl
    ,$AR_Stat01
    ,$AR_Stat02
    ,$AR_Stat03
    ,$AR_Stat04
    ,$AR_Stat05
    ,$AR_Escompte
    ,$AR_Delai
    ,$AR_HorsStat
    ,$AR_VteDebit
    ,$AR_NotImp
    ,$AR_Sommeil
    ,$AR_Langue1
    ,$AR_Langue2
    ,$AR_CodeEdiED_Code1
    ,$AR_CodeEdiED_Code2
    ,$AR_CodeEdiED_Code3
    ,$AR_CodeEdiED_Code4
    ,$AR_CodeBarre
    ,$AR_CodeFiscal
    ,$AR_Pays
    ,$AR_Frais01FR_Denomination
    ,$AR_Frais01FR_Rem01REM_Valeur
    ,$AR_Frais01FR_Rem01REM_Type
    ,$AR_Frais01FR_Rem02REM_Valeur
    ,$AR_Frais01FR_Rem02REM_Type
    ,$AR_Frais01FR_Rem03REM_Valeur
    ,$AR_Frais01FR_Rem03REM_Type
    ,$AR_Frais02FR_Denomination
    ,$AR_Frais02FR_Rem01REM_Valeur
    ,$AR_Frais02FR_Rem01REM_Type
    ,$AR_Frais02FR_Rem02REM_Valeur
    ,$AR_Frais02FR_Rem02REM_Type
    ,$AR_Frais02FR_Rem03REM_Valeur
    ,$AR_Frais02FR_Rem03REM_Type
    ,$AR_Frais03FR_Denomination
    ,$AR_Frais03FR_Rem01REM_Valeur
    ,$AR_Frais03FR_Rem01REM_Type
    ,$AR_Frais03FR_Rem02REM_Valeur
    ,$AR_Frais03FR_Rem02REM_Type
    ,$AR_Frais03FR_Rem03REM_Valeur
    ,$AR_Frais03FR_Rem03REM_Type
    ,$AR_Condition
    ,$AR_PUNet
    ,$AR_Contremarque
    ,$AR_FactPoids
    ,$AR_FactForfait
    ,$AR_DateCreation
    ,$AR_SaisieVar
    ,$AR_Transfere
    ,$AR_Publie
    ,$AR_DateModif
    ,$AR_Photo
    ,$AR_PrixAchNouv
    ,$AR_CoefNouv
    ,$AR_PrixVenNouv
    ,$AR_DateApplication
    ,$AR_CoutStd
    ,$AR_QteComp
    ,$AR_QteOperatoire
    ,$CO_No
    ,$AR_Prevision,$CL_No1
    ,$CL_No2
    ,$CL_No3
    ,$CL_No4
    ,$AR_Type
    ,$RP_CodeDefaut
    ,$cbMarq
    ,$cbCreateur
    ,$cbModification
    ,$Prix_Min
    ,$Prix_Max
    ,$Qte_Gros;

    public $table = 'F_ARTICLE';
    public $lien = 'farticle';

    function __construct($id,$db=null)
    {
        $this->db = new DB();
        parent::__construct($this->table, $id, 'AR_Ref',$db);
        if (sizeof($this->data) > 0) {
            $this->AR_Ref = $this->data[0]->AR_Ref;
            $this->AR_Design = $this->data[0]->AR_Design;
            $this->FA_CodeFamille = $this->data[0]->FA_CodeFamille;
            $this->AR_Substitut = $this->data[0]->AR_Substitut;
            $this->AR_Raccourci = $this->data[0]->AR_Raccourci;
            $this->AR_Garantie = $this->data[0]->AR_Garantie;
            $this->AR_UnitePoids = $this->data[0]->AR_UnitePoids;
            $this->AR_PoidsNet = $this->data[0]->AR_PoidsNet;
            $this->AR_PoidsBrut = $this->data[0]->AR_PoidsBrut;
            $this->AR_UniteVen = $this->data[0]->AR_UniteVen;
            $this->AR_PrixAch = $this->data[0]->AR_PrixAch;
            $this->AR_Coef = $this->data[0]->AR_Coef;
            $this->AR_PrixVen = $this->data[0]->AR_PrixVen;
            $this->AR_PrixTTC = $this->data[0]->AR_PrixTTC;
            $this->AR_Gamme1 = $this->data[0]->AR_Gamme1;
            $this->AR_Gamme2 = $this->data[0]->AR_Gamme2;
            $this->AR_SuiviStock = $this->data[0]->AR_SuiviStock;
            $this->AR_Nomencl = $this->data[0]->AR_Nomencl;
            $this->AR_Stat01 = $this->data[0]->AR_Stat01;
            $this->AR_Stat02 = $this->data[0]->AR_Stat02;
            $this->AR_Stat03 = $this->data[0]->AR_Stat03;
            $this->AR_Stat04 = $this->data[0]->AR_Stat04;
            $this->AR_Stat05 = $this->data[0]->AR_Stat05;
            $this->AR_Escompte = $this->data[0]->AR_Escompte;
            $this->AR_Delai = $this->data[0]->AR_Delai;
            $this->AR_HorsStat = $this->data[0]->AR_HorsStat;
            $this->AR_VteDebit = $this->data[0]->AR_VteDebit;
            $this->AR_NotImp = $this->data[0]->AR_NotImp;
            $this->AR_Sommeil = $this->data[0]->AR_Sommeil;
            $this->AR_Langue1 = $this->data[0]->AR_Langue1;
            $this->AR_Langue2 = $this->data[0]->AR_Langue2;
            $this->AR_CodeEdiED_Code1 = $this->data[0]->AR_CodeEdiED_Code1;
            $this->AR_CodeEdiED_Code2 = $this->data[0]->AR_CodeEdiED_Code2;
            $this->AR_CodeEdiED_Code3 = $this->data[0]->AR_CodeEdiED_Code3;
            $this->AR_CodeEdiED_Code4 = $this->data[0]->AR_CodeEdiED_Code4;
            $this->AR_CodeBarre = $this->data[0]->AR_CodeBarre;
            $this->AR_CodeFiscal = $this->data[0]->AR_CodeFiscal;
            $this->AR_Pays = $this->data[0]->AR_Pays;
            $this->AR_Frais01FR_Denomination = $this->data[0]->AR_Frais01FR_Denomination;
            $this->AR_Frais01FR_Rem01REM_Valeur = $this->data[0]->AR_Frais01FR_Rem01REM_Valeur;
            $this->AR_Frais01FR_Rem01REM_Type = $this->data[0]->AR_Frais01FR_Rem01REM_Type;
            $this->AR_Frais01FR_Rem02REM_Valeur = $this->data[0]->AR_Frais01FR_Rem02REM_Valeur;
            $this->AR_Frais01FR_Rem02REM_Type = $this->data[0]->AR_Frais01FR_Rem02REM_Type;
            $this->AR_Frais01FR_Rem03REM_Valeur = $this->data[0]->AR_Frais01FR_Rem03REM_Valeur;
            $this->AR_Frais01FR_Rem03REM_Type = $this->data[0]->AR_Frais01FR_Rem03REM_Type;
            $this->AR_Frais02FR_Denomination = $this->data[0]->AR_Frais02FR_Denomination;
            $this->AR_Frais02FR_Rem01REM_Valeur = $this->data[0]->AR_Frais02FR_Rem01REM_Valeur;
            $this->AR_Frais02FR_Rem01REM_Type = $this->data[0]->AR_Frais02FR_Rem01REM_Type;
            $this->AR_Frais02FR_Rem02REM_Valeur = $this->data[0]->AR_Frais02FR_Rem02REM_Valeur;
            $this->AR_Frais02FR_Rem02REM_Type = $this->data[0]->AR_Frais02FR_Rem02REM_Type;
            $this->AR_Frais02FR_Rem03REM_Valeur = $this->data[0]->AR_Frais02FR_Rem03REM_Valeur;
            $this->AR_Frais02FR_Rem03REM_Type = $this->data[0]->AR_Frais02FR_Rem03REM_Type;
            $this->AR_Frais03FR_Denomination = $this->data[0]->AR_Frais03FR_Denomination;
            $this->AR_Frais03FR_Rem01REM_Valeur = $this->data[0]->AR_Frais03FR_Rem01REM_Valeur;
            $this->AR_Frais03FR_Rem01REM_Type = $this->data[0]->AR_Frais03FR_Rem01REM_Type;
            $this->AR_Frais03FR_Rem02REM_Valeur = $this->data[0]->AR_Frais03FR_Rem02REM_Valeur;
            $this->AR_Frais03FR_Rem02REM_Type = $this->data[0]->AR_Frais03FR_Rem02REM_Type;
            $this->AR_Frais03FR_Rem03REM_Valeur = $this->data[0]->AR_Frais03FR_Rem03REM_Valeur;
            $this->AR_Frais03FR_Rem03REM_Type = $this->data[0]->AR_Frais03FR_Rem03REM_Type;
            $this->AR_Condition = $this->data[0]->AR_Condition;
            $this->AR_PUNet = $this->data[0]->AR_PUNet;
            $this->AR_Contremarque = $this->data[0]->AR_Contremarque;
            $this->AR_FactPoids = $this->data[0]->AR_FactPoids;
            $this->AR_FactForfait = $this->data[0]->AR_FactForfait;
            $this->AR_DateCreation = $this->data[0]->AR_DateCreation;
            $this->AR_SaisieVar = $this->data[0]->AR_SaisieVar;
            $this->AR_Transfere = $this->data[0]->AR_Transfere;
            $this->AR_Publie = $this->data[0]->AR_Publie;
            $this->AR_DateModif = $this->data[0]->AR_DateModif;
            $this->AR_Photo = $this->data[0]->AR_Photo;
            $this->AR_PrixAchNouv = $this->data[0]->AR_PrixAchNouv;
            $this->AR_CoefNouv = $this->data[0]->AR_CoefNouv;
            $this->AR_PrixVenNouv = $this->data[0]->AR_PrixVenNouv;
            $this->AR_DateApplication = $this->data[0]->AR_DateApplication;
            $this->AR_CoutStd = $this->data[0]->AR_CoutStd;
            $this->AR_QteComp = $this->data[0]->AR_QteComp;
            $this->AR_QteOperatoire = $this->data[0]->AR_QteOperatoire;
            $this->CO_No = $this->data[0]->CO_No;
            $this->AR_Prevision = $this->data[0]->AR_Prevision;
            $this->AR_DateApplication = $this->data[0]->AR_DateApplication;
            $this->AR_CoutStd = $this->data[0]->AR_CoutStd;
            $this->AR_QteComp = $this->data[0]->AR_QteComp;
            $this->AR_QteOperatoire = $this->data[0]->AR_QteOperatoire;
            $this->CO_No = $this->data[0]->CO_No;
            $this->AR_Prevision = $this->data[0]->AR_Prevision;
            $this->CL_No1 = $this->data[0]->CL_No1;
            $this->CL_No2 = $this->data[0]->CL_No2;
            $this->CL_No3 = $this->data[0]->CL_No3;
            $this->CL_No4 = $this->data[0]->CL_No4;
            $this->AR_Type = $this->data[0]->AR_Type;
            $this->RP_CodeDefaut = $this->data[0]->RP_CodeDefaut;
            $this->cbMarq = $this->data[0]->cbMarq;
            $this->cbCreateur = $this->data[0]->cbCreateur;
            $this->cbModification = $this->data[0]->cbModification;
            $this->Prix_Min = $this->data[0]->Prix_Min;
            $this->Prix_Max = $this->data[0]->Prix_Max;
            $this->Qte_Gros = $this->data[0]->QTE_GROS;
        }
    }

    public function setuserName($login,$mobile){
        if(!isset($_SESSION))
            session_start();
        $this->cbCreateur = $_SESSION["id"];
    }


    public function maj_article(){
        parent::maj("AR_Design" , $this->AR_Design);
        parent::maj("FA_CodeFamille" , $this->FA_CodeFamille);
        parent::maj("AR_Raccourci" , $this->AR_Raccourci);
        parent::maj("AR_Garantie" , $this->AR_Garantie);
        parent::maj("AR_UnitePoids" , $this->AR_UnitePoids);
        parent::maj("AR_PoidsNet" , $this->AR_PoidsNet);
        parent::maj("AR_PoidsBrut" , $this->AR_PoidsBrut);
        parent::maj("AR_UniteVen" , $this->AR_UniteVen);
        parent::maj("AR_PrixAch" , $this->AR_PrixAch);
        parent::maj("AR_Coef" , $this->AR_Coef);
        parent::maj("AR_PrixVen" , $this->AR_PrixVen);
        parent::maj("AR_PrixTTC" , $this->AR_PrixTTC);
        parent::maj("AR_Gamme1" , $this->AR_Gamme1);
        parent::maj("AR_Gamme2" , $this->AR_Gamme2);
        //    parent::maj("AR_SuiviStock" , $this->AR_SuiviStock);
        parent::maj("AR_Nomencl" , $this->AR_Nomencl);
        /*parent::maj("AR_Stat01" , $this->AR_Stat01);
        parent::maj("AR_Stat02" , $this->AR_Stat02);
        parent::maj("AR_Stat03" , $this->AR_Stat03);
        parent::maj("AR_Stat04" , $this->AR_Stat04);
        parent::maj("AR_Stat05" , $this->AR_Stat05);*/
        parent::maj("AR_Escompte" , $this->AR_Escompte);
        parent::maj("AR_Delai" , $this->AR_Delai);
        parent::maj("AR_HorsStat" , $this->AR_HorsStat);
        parent::maj("AR_VteDebit" , $this->AR_VteDebit);
        parent::maj("AR_NotImp" , $this->AR_NotImp);
        parent::maj("AR_Sommeil" , $this->AR_Sommeil);
        parent::maj("AR_Langue1" , $this->AR_Langue1);
        parent::maj("AR_Langue2" , $this->AR_Langue2);
        parent::maj("AR_CodeEdiED_Code1" , $this->AR_CodeEdiED_Code1);
        parent::maj("AR_CodeEdiED_Code2" , $this->AR_CodeEdiED_Code2);
        parent::maj("AR_CodeEdiED_Code3" , $this->AR_CodeEdiED_Code3);
        parent::maj("AR_CodeEdiED_Code4" , $this->AR_CodeEdiED_Code4);
        parent::maj("AR_CodeBarre" , $this->AR_CodeBarre);
        parent::maj("AR_CodeFiscal" , $this->AR_CodeFiscal);
        parent::maj("AR_Pays" , $this->AR_Pays);
        /*parent::maj("AR_Frais01FR_Denomination" , $this->AR_Frais01FR_Denomination);
        parent::maj("AR_Frais01FR_Rem01REM_Valeur" , $this->AR_Frais01FR_Rem01REM_Valeur);
        parent::maj("AR_Frais01FR_Rem01REM_Type" , $this->AR_Frais01FR_Rem01REM_Type);
        parent::maj("AR_Frais01FR_Rem02REM_Valeur" , $this->AR_Frais01FR_Rem02REM_Valeur);
        parent::maj("AR_Frais01FR_Rem02REM_Type" , $this->AR_Frais01FR_Rem02REM_Type);
        parent::maj("AR_Frais01FR_Rem03REM_Valeur" , $this->AR_Frais01FR_Rem03REM_Valeur);
        parent::maj("AR_Frais01FR_Rem03REM_Type" , $this->AR_Frais01FR_Rem03REM_Type);
        parent::maj("AR_Frais02FR_Denomination" , $this->AR_Frais02FR_Denomination);
        parent::maj("AR_Frais02FR_Rem01REM_Valeur" , $this->AR_Frais02FR_Rem01REM_Valeur);
        parent::maj("AR_Frais02FR_Rem01REM_Type" , $this->AR_Frais02FR_Rem01REM_Type);
        parent::maj("AR_Frais02FR_Rem02REM_Valeur" , $this->AR_Frais02FR_Rem02REM_Valeur);
        parent::maj("AR_Frais02FR_Rem02REM_Type" , $this->AR_Frais02FR_Rem02REM_Type);
        parent::maj("AR_Frais02FR_Rem03REM_Valeur" , $this->AR_Frais02FR_Rem03REM_Valeur);
        parent::maj("AR_Frais02FR_Rem03REM_Type" , $this->AR_Frais02FR_Rem03REM_Type);
        parent::maj("AR_Frais03FR_Denomination" , $this->AR_Frais03FR_Denomination);
        parent::maj("AR_Frais03FR_Rem01REM_Valeur" , $this->AR_Frais03FR_Rem01REM_Valeur);
        parent::maj("AR_Frais03FR_Rem01REM_Type" , $this->AR_Frais03FR_Rem01REM_Type);
        parent::maj("AR_Frais03FR_Rem02REM_Valeur" , $this->AR_Frais03FR_Rem02REM_Valeur);
        parent::maj("AR_Frais03FR_Rem02REM_Type" , $this->AR_Frais03FR_Rem02REM_Type);
        parent::maj("AR_Frais03FR_Rem03REM_Valeur" , $this->AR_Frais03FR_Rem03REM_Valeur);
        parent::maj("AR_Frais03FR_Rem03REM_Type" , $this->AR_Frais03FR_Rem03REM_Type);*/
        parent::maj("AR_Condition" , $this->AR_Condition);
        parent::maj("AR_PUNet" , $this->AR_PUNet);
        parent::maj("AR_Contremarque" , $this->AR_Contremarque);
        parent::maj("AR_FactPoids" , $this->AR_FactPoids);
        parent::maj("AR_FactForfait" , $this->AR_FactForfait);
        //parent::maj("AR_DateCreation" , $this->AR_DateCreation);
        parent::maj("AR_SaisieVar" , $this->AR_SaisieVar);
        parent::maj("AR_Transfere" , $this->AR_Transfere);
        parent::maj("AR_Publie" , $this->AR_Publie);
        //parent::maj("AR_DateModif" , $this->AR_DateModif);
        parent::maj("AR_Photo" , $this->AR_Photo);
        parent::maj("AR_PrixAchNouv" , $this->AR_PrixAchNouv);
        parent::maj("AR_CoefNouv" , $this->AR_CoefNouv);
        parent::maj("AR_PrixVenNouv" , $this->AR_PrixVenNouv);
        parent::maj("AR_DateApplication" , $this->AR_DateApplication);
        parent::maj("AR_CoutStd" , $this->AR_CoutStd);
        parent::maj("AR_QteComp" , $this->AR_QteComp);
        parent::maj("AR_QteOperatoire" , $this->AR_QteOperatoire);
        parent::maj("CO_No" , $this->CO_No);
        parent::maj("AR_Prevision" , $this->AR_Prevision);
        parent::maj("AR_DateApplication" , $this->AR_DateApplication);
        parent::maj("AR_CoutStd" , $this->AR_CoutStd);
        parent::maj("AR_QteComp" , $this->AR_QteComp);
        parent::maj("AR_QteOperatoire" , $this->AR_QteOperatoire);
        parent::maj("CO_No" , $this->CO_No);
        parent::maj("cbCO_No" , $this->cbCO_No);
        parent::maj("AR_Prevision" , $this->AR_Prevision);
        //parent::maj("cbModification" , $this->cbModification);
        parent::maj("Prix_Min" , $this->Prix_Min);
        parent::maj("Prix_Max" , $this->Prix_Max);
        parent::maj("Qte_Gros" , $this->Qte_Gros);
        //parent::maj("cbCreateur" , $this->cbCreateur);
    }

    public function detailConditionnement($tcRefCf){
        return $this->getApiJson("/detailConditionnement&arRef={$this->AR_Ref}&tcRefCf=$tcRefCf");
    }
    public function insertArticle() {
        return $this->getApiJson("/ajout_article&reference={$this->formatString($this->AR_Ref)}&designation={$this->formatString($this->AR_Design)}&pxAchat={$this->AR_PrixAch}&faCodeFamille={$this->formatString($this->FA_CodeFamille)}".
        "&condition={$this->AR_Condition}&pxHt={$this->AR_PrixVen}&pxMin={$this->Prix_Min}&pxMax={$this->Prix_Max}&qteGros={$this->Qte_Gros}&arPrixTTC={$this->AR_PrixTTC}&clNo1={$this->CL_No1}".
        "&clNo2={$this->CL_No2}&clNo3={$this->CL_No3}&clNo4={$this->CL_No4}&cbCreateur={$this->userName}");
    }

    public function getPrixClient($catCompta, $catTarif){
        return $this->getApiJson("/getPrixClient&arRef={$this->formatString($this->AR_Ref)}&catCompta={$catCompta}&catTarif={$catTarif}");
    }

    public function getPrixClientAch($catCompta, $catTarif,$ctNum){
        return $this->getApiJson("/getPrixClientAch&arRef={$this->formatString($this->AR_Ref)}&catCompta={$catCompta}&catTarif={$catTarif}&ctNum={$this->formatString($ctNum)}");
    }

    public function getLibTaxePied($catCompta, $catTarif){
        return $this->getApiJson("/getLibTaxePied&fcpType={$catTarif}&fcpChamp={$catCompta}");
    }

    public function queryListeArticle($flagPxAchat,$flagPxRevient,$ar_sommeil,$prixFlag,$stockFlag,$searchString,$orderBy,$orderType ,$start , $length){
        $url = "/queryListeArticle&flagPxAchat=$flagPxAchat&flagPxRevient=$flagPxRevient&arSommeil=$ar_sommeil&prixFlag=$prixFlag&stockFlag=$stockFlag&searchString=$searchString&orderBy=$orderBy&orderType=$orderType&start=$start&length=$length";
        return $this->getApiJson($url);
    }

    public function getCbMarq($cbMarq){
        $rows = $this->getApiJson("/getArRefCbMarq&cbMarq={$cbMarq}");
        if(sizeof($rows)>0)
            return new ArticleClass($rows[0]->AR_Ref);
        else
            return new ArticleClass("");
    }

    public function getArticleAndDepot(){
        return $this->getApiJson("/getArticleAndDepot&arRef={$this->formatString($this->AR_Ref)}");
    }

    public function delete(){
        return $this->getApiJson("/deleteArticle&cbMarq={$this->cbMarq}");
    }

    public function listeArticlePagination(){
        if (!empty($_POST) ) {
            /* Useful $_POST Variables coming from the plugin */
            $draw = $_POST["draw"];//counter used by DataTables to ensure that the Ajax returns from server-side processing requests are drawn in sequence by DataTables
            $orderByColumnIndex  = $_POST['order'][0]['column'];// index of the sorting column (0 index based - i.e. 0 is the first record)
            $orderBy = $_POST['columns'][$orderByColumnIndex]['data'];//Get name of the sorting column from its index
            $orderType = $_POST['order'][0]['dir']; // ASC or DESC
            $start  = $_POST["start"];//Paging first record indicator.
            $length = $_POST['length'];//Number of records that the table can display in the current draw
            $flagPxAchat = $_GET["flagPxAchat"];
            $flagPxRevient = $_GET["flagPxRevient"];
            $prot_no = $_GET["PROT_No"];
            /* END of POST variables */
            $ar_sommeil = -1;
            $stockFlag = -1;
            $prixFlag = -1;
            if(isset($_GET['AR_Sommeil']))
                $ar_sommeil = $_GET['AR_Sommeil'];
            if(isset($_GET['stockFlag']))
                $stockFlag= $_GET['stockFlag'];

            if(isset($_GET['prixFlag']))
                $prixFlag = $_GET['prixFlag'];

            $recordsTotal = sizeof($this->queryListeArticle($flagPxAchat,$flagPxRevient,$ar_sommeil,$prixFlag,$stockFlag,$this->formatString(""),"","","",""));
            /* SEARCH CASE : Filtered data */
            if(!empty($_POST['search']['value'])){
                /* WHERE Clause for searching */
                for($i=0 ; $i<count($_POST['columns']);$i++){
                    $column = $_POST['columns'][$i]['data'];//we get the name of each column using its index from POST request
                }
                $where[]=" (AR_Design like '%".$_POST['search']['value']."%' OR AR_Ref like '%".$_POST['search']['value']."%') ";

                $where = " WHERE ".implode(" OR " , $where);// id like '%searchValue%' or name like '%searchValue%' ....
                /* End WHERE */
                $sql = sprintf(" %s", $where);//Search query without limit clause (No pagination)
                $recordsFiltered = count($this->queryListeArticle($flagPxAchat,$flagPxRevient,$ar_sommeil,$prixFlag,$stockFlag,$this->formatString($_POST['search']['value']),"","","",""));//Count of search result

                /* SQL Query for search with limit and orderBy clauses*/
                $sql = sprintf(" %s ORDER BY %s %s OFFSET %d ROWS FETCH NEXT %d ROWS ONLY",$where,$orderBy,$orderType ,$start , $length);
                $data = $this->queryListeArticle($flagPxAchat,$flagPxRevient,$ar_sommeil,$prixFlag,$stockFlag,$this->formatString($_POST['search']['value']),$orderBy,$orderType ,$start , $length);
            }
            /* END SEARCH */
            else {
                $sql = sprintf("ORDER BY %s %s OFFSET %d ROWS FETCH NEXT %d ROWS ONLY",$orderBy,$orderType ,$start , $length);
                $data = $this->queryListeArticle($flagPxAchat,$flagPxRevient,$ar_sommeil,$prixFlag,$stockFlag,$this->formatString($_POST['search']['value']),$orderBy,$orderType ,$start , $length);
                $recordsFiltered = $recordsTotal;
            }

            /* Response to client before JSON encoding */
            $response = array(
                "draw" => intval($draw),
                "recordsTotal" => $recordsTotal,
                "recordsFiltered" => $recordsFiltered,
                "data" => $data
            );

            echo json_encode($response);

        } else {
            echo "NO POST Query from DataTable";
        }
    }

    public function getArtFournisseur(){
        return $this->getApiJson("/getArtFournisseur&arRef={$this->formatString($this->AR_Ref)}");
    }

    public function deleteArtFournisseur ($cbMarq){
        $this->getApiExecute("/deleteArtFournisseur&cbMarq=$cbMarq");
    }

    public function getArtFournisseurSelect ($cbMarq){
        return $this->getApiJson("/getArtFournisseurSelect&cbMarq={$cbMarq}");
    }

    public function insertArtFournisseur(   $CT_Num,$AF_RefFourniss,$AF_PrixAch,$AF_Unite,
                                            $AF_Conversion,$AF_DelaiAppro,$AF_Garantie,$AF_Colisage,$AF_QteMini,$AF_QteMont,$EG_Champ,
                                            $AF_Principal,$AF_PrixDev,$AF_Devise,$AF_Remise,$AF_ConvDiv,$AF_TypeRem,$AF_CodeBarre,
                                            $AF_PrixAchNouv,$AF_PrixDevNouv,$AF_RemiseNouv,$AF_DateApplication,$protNo){
        $this->getApiExecute(" arRef={$this->formatString($this->AR_Ref)}&ctNum={$this->formatString($CT_Num)}
        &afRefFourniss={$AF_RefFourniss}&afPrixAch={$AF_PrixAch}&afUnite={$AF_Unite}&afConversion={$AF_Conversion}
        &afDelaiAppro={$AF_DelaiAppro}&afGarantie={$AF_Garantie}
        &afColissage={$AF_Colisage}&afQteMini={$AF_QteMini}&afQteMont={$AF_QteMont}&egChamp={$EG_Champ}&afPrincipal={$AF_Principal}
        &afPrixDev={$AF_PrixDev}&afDevise={$AF_Devise}&afRemise={$AF_Remise}&afConvDiv={$AF_ConvDiv}&afTypeRem={$AF_TypeRem}
        &afCodeBarre={$AF_CodeBarre}&afPrixAchNouv={$AF_PrixAchNouv}&afPrixDevNouv={$AF_PrixDevNouv}
        &afRemiseNouv={$AF_RemiseNouv}&afDateApplication={$AF_DateApplication}&protNo={$protNo}");
    }

    public function getShortList() {
        return $this->getApiJson("/getShortList");
    }

    public function  getStockDepot($DE_No) {
        return $this->getApiJson("/getStockDepot&arRef={$this->AR_Ref}&deNo=$DE_No");
    }

    public function stockMinDepasse($de_no){
        return $this->getApiJson("/stockMinDepasse&deNo=$de_no&arRef={$this->AR_Ref}");
    }

    public function getArticleByIntitule($intitule){
        return $this->getApiJson("/getArticleByIntitule&arIntitule={$this->formatString($intitule)}");
    }

    public function isStock($de_no)
    {
        $this->lien = "fartstock";
        return $this->getApiJson("/isStockJSON&arRef={$this->formatString($this->AR_Ref)}&deNo=$de_no");
    }

    public function isStockDENo($de_no,$dlQte)
    {
        $this->lien = "fartstock";
        return $this->getApiJson("/isStockDENo&dlQte={$dlQte}&deNo={$de_no}&arRef={$this->formatString($this->AR_Ref)}");
    }

    public function updateArtStock($de_no, $qte, $montant, $action,$protNo)
    {
        $this->lien = "fartstock";
        $this->getApiExecute("/updateArtStock&arRef={$this->AR_Ref}&deNo=$de_no&montant=$montant&qte=$qte&action=$action&protNo=$protNo");
    }

    public function __toString() {
        return "";
    }

    public function majRefArticle($newRef){
        $this->getApiExecute("/majRefArticle&newArRef=$newRef&arRef={$this->AR_Ref}");
    }

    public function getAllArticleDispoByArRef($de_no,$codeFamille=0,$intitule = "",$rechEtat="")
    {
        return $this->getApiJson("/getAllArticleDispoByArRef&deNo=$de_no&codeFamille=$codeFamille&valeur=$intitule&rechEtat=$rechEtat");
    }

    public function insertF_ArtCompta($ar_ref,$acp_type,$acp_champ,$cg_num,$cg_numA,$ta_code1,$ta_code2,$ta_code3,$protNo){
        $this->getApiExecute("/insertF_ArtCompta&arRef={$ar_ref}&acpChamp={$acp_champ}&acpType={$acp_type}&cgNum={$cg_num}&cgNumA={$cg_numA}&taCode1={$ta_code1}&taCode2={$ta_code2}&taCode3={$ta_code3}&protNo={$protNo}");
    }

    public function all($sommeil=-1,$intitule="",$top=0,$arPublie=-1,$rechEtat=""){
        return $this->getApiJson("/all&intitule=$intitule&top=$top&sommeil=$sommeil&arPublie=$arPublie&rechEtat=$rechEtat");
    }
}