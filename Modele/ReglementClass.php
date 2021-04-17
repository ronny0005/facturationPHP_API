<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class ReglementClass Extends Objet{
    //put your code here
    public $db,$RG_No,$CT_NumPayeur,$cbCT_NumPayeur,$RG_Date
    ,$RG_Reference,$RG_Libelle,$RG_Montant,$RG_MontantDev
    ,$N_Reglement,$RG_Impute,$RG_Compta,$EC_No
    ,$cbEC_No,$RG_Type,$RG_Cours,$N_Devise
    ,$JO_Num,$CG_NumCont,$cbCG_NumCont,$RG_Impaye
    ,$CG_Num,$cbCG_Num,$RG_TypeReg,$RG_Heure
    ,$RG_Piece,$cbRG_Piece,$CA_No,$cbCA_No
    ,$CO_NoCaissier,$cbCO_NoCaissier,$RG_Banque,$RG_Transfere
    ,$RG_Cloture,$RG_Ticket,$RG_Souche,$CT_NumPayeurOrig
    ,$cbCT_NumPayeurOrig,$RG_DateEchCont,$CG_NumEcart,$cbCG_NumEcart
    ,$JO_NumEcart,$RG_MontantEcart,$RG_NoBonAchat,$cbProt
    ,$cbMarq,$cbCreateur,$cbModification,$cbReplication
    ,$cbFlag,$DO_Modif,$RG_DateSage;
    public $table = 'F_CREGLEMENT';
    public $lien ="fcreglement";

    function __construct($id,$db=null)
    {
        $this->data = $this->getApiJson("/rgNo=$id");
        if($id!=0)
        if (sizeof($this->data) > 0) {
            $this->RG_No = $this->data[0]->RG_No;
            $this->CT_NumPayeur = $this->data[0]->CT_NumPayeur;
            $this->cbCT_NumPayeur = $this->data[0]->cbCT_NumPayeur;
            $this->RG_Date = $this->formatDate($this->data[0]->RG_Date);
            $this->RG_Reference = $this->data[0]->RG_Reference;
            $this->RG_Libelle = $this->data[0]->RG_Libelle;
            $this->RG_DateSage = $this->formatDateSage($this->data[0]->RG_Date);
            $this->RG_Montant = $this->data[0]->RG_Montant;
            $this->RG_MontantDev = $this->data[0]->RG_MontantDev;
            $this->N_Reglement = $this->data[0]->N_Reglement;
            $this->RG_Impute = $this->data[0]->RG_Impute;
            $this->RG_Compta = $this->data[0]->RG_Compta;
            $this->EC_No = $this->data[0]->EC_No;
            $this->cbEC_No = $this->data[0]->cbEC_No;
            $this->RG_Type = $this->data[0]->RG_Type;
            $this->RG_Cours = $this->data[0]->RG_Cours;
            $this->N_Devise = $this->data[0]->N_Devise;
            $this->JO_Num = $this->data[0]->JO_Num;
            $this->CG_NumCont = $this->data[0]->CG_NumCont;
            $this->cbCG_NumCont = $this->data[0]->cbCG_NumCont;
            $this->RG_Impaye = $this->data[0]->RG_Impaye;
            $this->CG_Num = $this->data[0]->CG_Num;
            $this->cbCG_Num = $this->data[0]->cbCG_Num;
            $this->RG_TypeReg = $this->data[0]->RG_TypeReg;
            $this->RG_Heure = $this->data[0]->RG_Heure;
            $this->RG_Piece = $this->data[0]->RG_Piece;
            $this->cbRG_Piece = $this->data[0]->cbRG_Piece;
            $this->CA_No = $this->data[0]->CA_No;
            $this->cbCA_No = $this->data[0]->cbCA_No;
            $this->CO_NoCaissier = $this->data[0]->CO_NoCaissier;
            $this->cbCO_NoCaissier = $this->data[0]->cbCO_NoCaissier;
            $this->RG_Banque = $this->data[0]->RG_Banque;
            $this->RG_Transfere = $this->data[0]->RG_Transfere;
            $this->RG_Cloture = $this->data[0]->RG_Cloture;
            $this->RG_Ticket = $this->data[0]->RG_Ticket;
            $this->RG_Souche = $this->data[0]->RG_Souche;
            $this->CT_NumPayeurOrig = $this->data[0]->CT_NumPayeurOrig;
            $this->cbCT_NumPayeurOrig = $this->data[0]->cbCT_NumPayeurOrig;
            $this->RG_DateEchCont = $this->data[0]->RG_DateEchCont;
            $this->CG_NumEcart = $this->data[0]->CG_NumEcart;
            $this->cbCG_NumEcart = $this->data[0]->cbCG_NumEcart;
            $this->JO_NumEcart = $this->data[0]->JO_NumEcart;
            $this->RG_MontantEcart = $this->data[0]->RG_MontantEcart;
            $this->RG_NoBonAchat = $this->data[0]->RG_NoBonAchat;
            $this->cbProt = $this->data[0]->cbProt;
            $this->cbMarq = $this->data[0]->cbMarq;
            $this->cbCreateur = $this->data[0]->cbCreateur;
            $this->cbModification = $this->data[0]->cbModification;
            $this->cbReplication = $this->data[0]->cbReplication;
            $this->cbFlag = $this->data[0]->cbFlag;
            $this->setDO_Modif();
        }
    }

    public function updateImpute(){
        $this->getApiExecute("/updateImpute&rgNo={$this->RG_No}");
    }
    public function addEcheance($protNo,$rgNo,$typeRegl,$cbMarqEntete,$montant){
        $this->getApiExecute("/addEcheance&protNo=$protNo&rgNo=$rgNo&typeRegl=$typeRegl&cbMarqEntete=$cbMarqEntete&montant=$montant");
    }
    public function getReglementByClientFacture($cbMarq) {
        return $this->getApiJson("/getReglementByClientFacture&cbMarq=$cbMarq");
    }

    public function formatDateSage($val){
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $val);
        return $date->format('dmy');
    }

    public function getMajAnalytique($dateDeb,$dateFin,$statut,$caNum=''){
        $query = "    DECLARE @statut INT = $statut;
                      DECLARE @datedeb NVARCHAR(10) = '$dateDeb';
                      DECLARE @datefin NVARCHAR(10) = '$dateFin';
                      DECLARE @caNum NVARCHAR(50) = '$caNum';
                            
                    SELECT  A.RG_No,A.RG_Date,RG_Libelle
                            ,RG_Montant,ca.CA_Intitule,EC_No
                            ,N_Analytique,Cpa.CA_Num
                            ,EA_Montant = RG_Montant
                            ,EA_Quantite = 0
                            ,A.CG_Num
                    FROM    F_CREGLEMENT A
                    INNER JOIN F_CAISSE CA ON CA.CA_No = A.CA_No
                    INNER JOIN Z_RGLT_COMPTEA B ON A.RG_No = B.RG_No
                    INNER JOIN F_COMPTEA Cpa ON Cpa.CA_Num = B.CA_Num
                    WHERE RG_Compta=1
                    AND RG_Banque=0
                    AND RG_Date BETWEEN @datedeb AND @datefin
                    AND (CASE WHEN @caNum='' THEN 1 
                                WHEN @caNum=B.CA_Num THEN 1 END = 1)
                    AND (CASE WHEN (@statut = 0 AND EC_No NOT IN (SELECT EC_No FROM F_ECRITUREA)) THEN 1 
                                WHEN (@statut = 1 AND EC_No IN (SELECT EC_No FROM F_ECRITUREA)) THEN 1 END = 1)";

        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getMajAnalytiqueNonComptabilisable($dateDeb,$dateFin,$caNum=''){
        $query = "  DECLARE @dateDeb NVARCHAR(20) = '$dateDeb'
                    DECLARE @dateFin NVARCHAR(20) = '$dateFin'
                    DECLARE @caNum NVARCHAR(20) = '$caNum';
                    
                    SELECT  A.RG_No,RG_Libelle,RG_Date,RG_Montant
                            ,ca.CA_Intitule,EC_No,N_Analytique
                            ,Cpa.CA_Num,EA_Montant = RG_Montant
                            ,EA_Quantite = 0
                            ,A.CG_Num
                    FROM    F_CREGLEMENT A
                    INNER JOIN F_CAISSE CA ON CA.CA_No = A.CA_No
                    INNER JOIN Z_RGLT_COMPTEA B ON A.RG_No = B.RG_No
                    INNER JOIN F_COMPTEA Cpa ON Cpa.CA_Num = B.CA_Num
                    WHERE RG_Compta=1
                    AND RG_Date BETWEEN @dateDeb AND @dateFin
                    AND (@caNum='' OR (@caNum=B.CA_Num))
                    AND EC_No NOT IN (SELECT EC_No FROM F_ECRITUREA)
                    AND	EC_No NOT IN (SELECT EC_No FROM F_ECRITUREC)
                    ";

        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function setMajAnalytique($datedeb,$datefin,$caNum,$protNo){
        $query = "  DECLARE @dateDeb NVARCHAR(50) = '$datedeb'
                    DECLARE @dateFin NVARCHAR(50) = '$datefin'
                    DECLARE @caNum NVARCHAR(50) = '$caNum'
                    DECLARE @protNo NVARCHAR(50) = '$protNo';
                    INSERT INTO F_ECRITUREA (EC_No,N_Analytique,EA_Ligne,CA_Num,EA_Montant,EA_Quantite,cbCreateur,cbModification)
                    SELECT	EC_No,N_Analytique,1,Cpa.CA_Num,RG_Montant,0,@protNo,GETDATE()
                    FROM	F_CREGLEMENT A
                    INNER JOIN F_CAISSE CA ON CA.CA_No = A.CA_No
                    INNER JOIN Z_RGLT_COMPTEA B ON A.RG_No = B.RG_No
                    INNER JOIN F_COMPTEA Cpa ON Cpa.CA_Num = B.CA_Num
                    WHERE	RG_Compta=1
                    AND RG_Banque=0
                    AND     RG_Date BETWEEN @dateDeb AND @dateFin
                    AND (@caNum='' OR (@caNum = B.CA_Num))
                    AND     EC_No NOT IN (SELECT EC_No FROM F_ECRITUREA)
                    AND		EC_No IN (SELECT EC_No FROM F_ECRITUREC)";
        $result= $this->db->query($query);
    }

    public function listeTypeReglement()
    {
        $this->lien = "preglement";
        return $this->getApiJson("/all");
    }

    function getModeleReglement() {
        $this->lien ="fmodeler";
        return $this->getApiJson("/all");
    }
    public function getDateEcgetTiersheanceSelectSage($MR_No,$N_Reglement,$date){
        $this->lien ="fmodeler";
        return $this->getApiJson("/getDateEcgetTiersheanceSelectSage&mrNo=$MR_No&nReglement=$N_Reglement&date=$date");
    }


    public function setDO_Modif(){
        $this->DO_Modif=$this->getApiJson("/setDO_Modif&rgNo={$this->RG_No}");
    }

    public function listeReglementCaisse($datedeb,$datefin,$ca_no,$type,$protNo){
        if($ca_no==-1)
            $ca_no=0;
        return $this->getApiJson("/listeReglementCaisse&dateDeb=$datedeb&dateFin=$datefin&caNo=$ca_no&type=$type&protNo=$protNo");
    }


    public function journeeCloture($date,$caNo){
            $valCaNo = 0;
            if($caNo!="")
                $valCaNo = $caNo;
            return $this->getApiString("/journeeCloture&date=$date&caNo=$valCaNo");
    }

    function typeCaisse($val){
        if($val==5) return "Entrée";
        if($val==4) return "Sortie";
        if($val==2) return "Fond de caisse";
        if($val==16) return "Transfert caisse";
        if($val==6) return "Vrst bancaire";
    }

    public function afficheMvtCaisse($rows,$flagAffichageValCaisse,$flagCtrlTtCaisse){
        $i=0;
        $classe="";
        $sommeMnt = 0;
        if($rows==null){
            echo "<tr id='reglement_' class='reglement'><td>Aucun élément trouvé ! </td></tr>";
        }else{
            foreach ($rows as $row){
                $rg_banque = $row->RG_Banque;
                $rg_type = $row->RG_Type;
                $rg_typereg = $row->RG_TypeReg;
                if($rg_typereg==4){
                    if($rg_banque==1 && $rg_type==4)
                        $rg_typereg = 3;
                }
                if($rg_typereg==4){
                    if($rg_banque==1 && $rg_type==2)
                        $rg_typereg = 6;
                }
                $i++;
                $fichier="";
                if($row->Lien_Fichier!=null)
                    $fichier="<a target='_blank' class='fa fa-download' href='upload/files/{$row->Lien_Fichier}'></a>";
                $montant = round($row->RG_Montant);
                if($row->RG_TypeReg==3 || $row->RG_TypeReg==4)
                    $montant =$montant*-1;
                if($i%2==0) $classe = "info";
                else $classe="";
                echo "<tr class='reglement $classe' id='reglement_{$row->RG_No}'>
                                                <td style='color:blue;text-decoration:underline' id='RG_No'>{$row->RG_No}</a></td>
                                                <td id='RG_Piece'>{$row->RG_Piece}</td>
                                                <td id='RG_Date'>{$this->getDateDDMMYYYY($row->RG_Date)}</td>
                                                <td id='RG_Libelle'>{$row->RG_Libelle}</td>
                                                <td id='RG_Montant'>{$this->formatChiffre($montant)}</td>
                                                <td style='display:none' id='RG_MontantHide'>$montant</td>
                                                <td style='display:none' id='CA_No'>{$row->CA_No}</td>
                                                <td style='display:none' id='CA_No_DestLigne'>{$row->CA_No_Dest}</td>
                                                <td style='display:none' id='RG_No_Source'>{$row->RG_No_Source}</td>
                                                <td style='display:none' id='RG_No_Dest'>{$row->RG_No_Dest}</td>
                                                <td style='display:none' id='JO_NumLigne'>{$row->JO_Num}</td>
                                                <td id='CA_Intitule'>{$row->CA_Intitule}</td>
                                                <td id='CO_Nom'><span id='RG_No' style='visibility:hidden'>{$row->RG_No}</span>{$row->CO_Nom}</td>
                                                <td id='RG_TypeReg'>{$this->typeCaisse($rg_typereg)}</td>
                                                <td style='display:none' id='RG_TypeRegLigne'>$rg_typereg</td>";

                if($flagAffichageValCaisse==0) echo "<td id='RG_Modif'><i class='fa fa-pencil fa-fw'></i></td>";
                if($flagCtrlTtCaisse==0) echo "<td id='RG_Suppr'><i class='fa fa-trash-o'></i></td>";
                if($rg_banque==1 && $rg_type==4)
                    echo "<td>$fichier</td><td><input type='checkbox'  id='check_vrst' checked disabled/></td>";
                else
                    if($rg_typereg==3)
                        echo "<td>$fichier</td><td><input type='checkbox' id='check_vrst' disabled/></td>";
                    else "<td></td>";

                echo "<td style='display:none' id='CG_NumLigne'>{$row->CG_Num}</td>";
                echo "<td style='display:none' id='CG_NumIntituleLigne'>{$row->CG_Intitule}</td>";

                echo "<td style='display:none' id='CA_NumLigne'>{$row->CA_Num}</td>";
                echo "<td style='display:none' id='CA_NumIntituleLigne'>{$row->CA_IntituleText}</td>";

                echo "<td style='display:none' id='RG_DateLigne'>".date("dmy", strtotime($row->RG_Date))."</td>";
                echo "</tr>";
                $sommeMnt = $sommeMnt + $montant;
            }
            echo "<tr class='reglement' style='background-color:grey;color:white'>
<td id='rgltTotal'><b>Total</b></td><td></td><td></td><td></td><td><b>{$this->formatChiffre($sommeMnt)}</b></td><td></td><td></td><td></td>";
if($flagAffichageValCaisse==0) echo "<td></td>";
if($flagCtrlTtCaisse==0) echo "<td></td>";
            echo "</tr>";
        }
    }
    public function initVariables(){
        $this->RG_Reference="";
        $this->RG_MontantDev=0;
        $this->RG_Compta=0;
        $this->EC_No=0;
        $this->cbEC_No=NULL;
        $this->RG_Cours=0;
        $this->N_Devise=0;
        $this->CG_NumCont=null;
        $this->RG_Impaye='1900-01-01';
        $this->RG_Transfere = 0;
        $this->RG_Cloture=0;
        $this->RG_Souche=0;
        $this->CG_NumEcart=NULL;
        $this->JO_NumEcart=NULL;
        $this->RG_MontantEcart=0;
        $this->RG_NoBonAchat=0;
        $this->cbProt=0;
        $this->cbCreateur=$_SESSION["id"];
        $this->cbReplication=0;
        $this->cbFlag=0;
    }

    public function maj_reglement(){
        if($this->CT_NumPayeur=="") {
            parent::majNull('CT_NumPayeur');
        }
        else {
            parent::maj('CT_NumPayeur', $this->CT_NumPayeur);
        }
        parent::maj('RG_Date' , $this->RG_Date);
        parent::maj('RG_Reference' , $this->RG_Reference);
        parent::maj('RG_Libelle' , $this->RG_Libelle);
        parent::maj('RG_Montant' , $this->RG_Montant);
        parent::maj('RG_MontantDev' , $this->RG_MontantDev);
        parent::maj('N_Reglement' , $this->N_Reglement);
        parent::maj('RG_Impute' , $this->RG_Impute);
        parent::maj('RG_Compta' , $this->RG_Compta);
        parent::maj('EC_No' , $this->EC_No);
        parent::maj('RG_Type' , $this->RG_Type);
        parent::maj('RG_Cours' , $this->RG_Cours);
        parent::maj('N_Devise' , $this->N_Devise);
        parent::maj('JO_Num' , $this->JO_Num);
        if($this->CG_NumCont=="") {
            parent::majNull('CG_NumCont');
        }
        else {
            parent::maj('CG_NumCont', $this->CG_NumCont);
        }
        parent::maj('RG_Impaye' , $this->RG_Impaye);
        if($this->CG_Num=="") {
            parent::majNull('CG_Num');
        }
        else {
            parent::maj('CG_Num', $this->CG_Num);
        }
        parent::maj('RG_TypeReg' , $this->RG_TypeReg);
        parent::maj('RG_Heure' , $this->RG_Heure);
        parent::maj('RG_Piece' , $this->RG_Piece);
        parent::maj('CA_No' , $this->CA_No);
        parent::maj('CO_NoCaissier' , $this->CO_NoCaissier);
        parent::maj('RG_Banque' , $this->RG_Banque);
        parent::maj('RG_Transfere' , $this->RG_Transfere);
        parent::maj('RG_Cloture' , $this->RG_Cloture);
        parent::maj('RG_Ticket' , $this->RG_Ticket);
        parent::maj('RG_Souche' , $this->RG_Souche);
        if($this->CT_NumPayeurOrig=="") {
            parent::majNull('CT_NumPayeurOrig');
        }
        else {
            parent::maj('CT_NumPayeurOrig', $this->CT_NumPayeurOrig);
        }
        parent::maj('RG_DateEchCont' , $this->RG_DateEchCont);
        if($this->CG_NumEcart=="") {
            parent::majNull('CG_NumEcart');
        }
        else {
            parent::maj('CG_NumEcart' , $this->CG_NumEcart);
        }
        parent::maj('JO_NumEcart' , $this->JO_NumEcart);
        parent::maj('RG_MontantEcart' , $this->RG_MontantEcart);
        parent::maj('RG_NoBonAchat' , $this->RG_NoBonAchat);
        parent::maj('cbProt' , $this->cbProt);
        parent::maj('cbCreateur' , $this->userName);
        parent::maj('cbModification' , $this->cbModification);
        parent::maj('cbReplication' , $this->cbReplication);
        parent::maj('cbFlag' , $this->cbFlag);
        $this->majcbModification();
    }

    public function majcbNull()
    {
        $requete = "INSERT INTO [dbo].[F_CREGLEMENT] WHERE RG_No=".$this->RG_No;
        $this->db->query($requete);

    }

    public function supprRgltAssocie()
    {
        $requete = "BEGIN 
                        SET NOCOUNT ON;
                        DELETE FROM F_CREGLEMENT WHERE RG_No IN (   SELECT RG_No 
                                                                    FROM [Z_RGLT_BONDECAISSE] 
                                                                    WHERE RG_No_RGLT={$this->RG_No})
                        DELETE FROM [Z_RGLT_BONDECAISSE] WHERE RG_No_RGLT={$this->RG_No}; END";
        $this->db->query($requete);
    }


    public function supprReglement($protNo=0)
    {
        $requete = "DELETE FROM F_REGLECH WHERE RG_No = {$this->RG_No} AND RC_Montant=0;
                    DELETE FROM F_CREGLEMENT WHERE RG_No = {$this->RG_No};
                    DELETE FROM Z_RGLT_BONDECAISSE WHERE RG_No = {$this->RG_No};
                    DELETE FROM Z_RGLT_BONDECAISSE WHERE RG_No_RGLT = {$this->RG_No};";
        $log = new LogFile();
        $log->writeReglement("Suppr Reglement",$this->RG_Montant,$this->RG_No,$this->CT_NumPayeur,$this->cbMarq,"F_CREGLEMENT",$protNo,$this->cbCreateur,$this->RG_Date);
        $this->db->query($requete);
    }

    public function remboursementRglt($date,$montant,$mobile){
        // création du remboursement
        $creglement = new ReglementClass(0,$this->db);
        $creglement->initVariables();
        $creglement->RG_Date = $date;
        $creglement->RG_DateEchCont = $date;
        $creglement->JO_Num = $this->JO_Num;
        $creglement->CG_Num = $this->CG_Num;
        $creglement->CA_No = $this->CA_No;
        $creglement->CO_NoCaissier = $this->CO_NoCaissier;
        $creglement->RG_Libelle = "Remboursement N° ".$this->RG_Piece;
        $creglement->RG_Montant = -$montant;
        $creglement->RG_Impute = 1;
        $creglement->RG_Type = $this->RG_Type;
        $creglement->N_Reglement = "01";
        $creglement->RG_TypeReg=4;
        if($this->RG_Type==1)
            $creglement->RG_TypeReg=5;
        $creglement->RG_Ticket=0;
        $creglement->RG_Banque=$this->RG_Banque;
        $creglement->CT_NumPayeur = $this->CT_NumPayeur;
        $creglement->setuserName("",$mobile);
        $rg_noRembours = $creglement->insertF_Reglement();
        //liaison du remboursement et reglement
        $this->insertZ_RGLT_BONDECAISSE($rg_noRembours,$this->RG_No);
        $this->RG_Impute = $this->isImpute()[0]->isImpute;
        $this->maj_reglement();
    }

    public function getFactureRGNo($rg_no){
        return $this->getApiJson("/getFactureRGNo&rgNo=$rg_no");
    }

    public function insertZ_RGLT_BONDECAISSE($RG_No,$RG_NoLier){
        $requete ="INSERT INTO [dbo].[Z_RGLT_BONDECAISSE] VALUES ($RG_No,$RG_NoLier)";
        $this->db->query($requete);
    }

    public function setReglement($ct_num, $rg_date, $rg_montant, $jo_num, $cg_num, $ca_no, $co_nocaissier, $do_date
        , $rg_libelle, $impute,$rg_type,$mode_reglement,$RG_TypeReg,$RG_Ticket,$rgbanque,$login){
        $this->initVariables();
        $this->RG_Date = $rg_date;
        $this->CT_NumPayeur = $ct_num;
        $this->CT_NumPayeurOrig = $ct_num;
        $this->CA_No = $ca_no;
        $this->CG_Num = $cg_num;
        $this->RG_Reference = "";
        //$caisse = new CaisseClass($creglement->CA_No);
        $this->JO_Num = $jo_num;
        $this->CO_NoCaissier = 0;
        $this->setuserName($login,"");
        $this->RG_Montant = $rg_montant;
        $this->RG_Libelle = $rg_libelle;
        $this->RG_Impute = $impute;
        $this->RG_Type = $rg_type;
        $this->N_Reglement = $mode_reglement;
        $this->RG_TypeReg=$RG_TypeReg;
        $this->RG_Ticket=$RG_Ticket;
        $this->RG_Banque=$rgbanque;
        $this->N_Devise = 0;
        $this->RG_Cours = 0;
        $this->RG_DateEchCont=$rg_date;
        $this->userName = $login;
    }

    public function insertCaNum($rgNo,$caNum){
        $query = "INSERT INTO [Z_RGLT_COMPTEA](RG_No,CA_Num) values($rgNo,'$caNum')";
        $this->db->query($query);
        //$requete = "UPDATE F_CREGLEMENT SET RG_Cloture=1 WHERE RG_No = $rgNo";
        //$this->db->query($requete);

    }

    public function insertF_ReglementVrstBancaire($rgNo,$rgNoCache){
        $requete = " INSERT INTO [dbo].[Z_RGLT_VRSTBANCAIRE] VALUES($rgNo,$rgNoCache)";
        $this->db->query($requete);
    }

    public function deleteF_ReglementVrstBancaire($rgNo){
        $requete = " DECLARE @RG_No INT = $rgNo;
                     DELETE FROM F_CREGLEMENT
                     WHERE RG_No=(SELECT RG_NoCache FROM [dbo].[Z_RGLT_VRSTBANCAIRE] WHERE RG_No=@RG_No);
                     DELETE FROM [dbo].[Z_RGLT_VRSTBANCAIRE] WHERE RG_No=@RG_No";
        $this->db->query($requete);
    }
    public function deleteF_ReglementCaNum($rgNo){
        $requete = " DELETE FROM Z_RGLT_COMPTEA
                     WHERE  RG_No=$rgNo";
        $this->db->query($requete);
    }

    public function insertF_Reglement(){

        $requete = "BEGIN 
                SET NOCOUNT ON;
                IF NOT EXISTS ( SELECT 1 
                                FROM F_CREGLEMENT 
                                WHERE RG_Libelle = '{$this->RG_Libelle}' 
                                AND RG_Date='{$this->RG_Date}' 
                                AND RG_Montant={$this->RG_Montant} 
                                AND RG_Type={$this->RG_Type} 
                                AND RG_TypeReg = {$this->RG_TypeReg}
                                AND CA_No={$this->CA_No}) 
                INSERT INTO [dbo].[F_CREGLEMENT] 
                 ([RG_No],[CT_NumPayeur],[RG_Date],[RG_Reference] 
                 ,[RG_Libelle],[RG_Montant],[RG_MontantDev],[N_Reglement] 
                 ,[RG_Impute],[RG_Compta],[EC_No] 
                 ,[RG_Type],[RG_Cours],[N_Devise],[JO_Num] 
                 ,[CG_NumCont],[RG_Impaye],[CG_Num],[RG_TypeReg] 
                 ,[RG_Heure],[RG_Piece],[CA_No] 
                 ,[CO_NoCaissier],[RG_Banque],[RG_Transfere] 
                 ,[RG_Cloture],[RG_Ticket],[RG_Souche],[CT_NumPayeurOrig] 
                 ,[RG_DateEchCont],[CG_NumEcart],[JO_NumEcart],[RG_MontantEcart] 
                 ,[RG_NoBonAchat],[cbProt],[cbCreateur],[cbModification] 
                 ,[cbReplication],[cbFlag]) 
                 VALUES 
                    (/*RG_No*/ISNULL((SELECT MAX(RG_No)+1 FROM F_CREGLEMENT),0),/*CT_NumPayeur*/
                    (CASE WHEN '{$this->CT_NumPayeur}' ='' THEN NULL 
                        WHEN '{$this->CT_NumPayeur}' = 'NULL' THEN NULL ELSE '{$this->CT_NumPayeur}' END)
                    ,/*RG_Date*/'{$this->RG_Date}',/*RG_Reference*/'{$this->RG_Reference}' 
                   ,/*RG_Libelle*/'".mb_ereg_replace("'","''",$this->RG_Libelle)."',/*RG_Montant*/ {$this->RG_Montant}
                   ,/*RG_MontantDev*/{$this->RG_MontantDev},/*N_Reglement*/{$this->N_Reglement}
                   ,/*RG_Impute*/{$this->RG_Impute},/*RG_Compta*/{$this->RG_Compta}
                   ,/*EC_No*/{$this->EC_No},/*RG_Type*/{$this->RG_Type},/*RG_Cours*/{$this->RG_Cours}
                   ,/*N_Devise*/{$this->N_Devise},/*JO_Num*/'{$this->JO_Num}'
                   ,/*CG_NumCont*/(CASE WHEN '{$this->CG_NumCont}' ='' OR '{$this->CG_NumCont}' = 'NULL' THEN NULL ELSE '{$this->CG_NumCont}' END)
                    ,/*RG_Impaye*/'{$this->RG_Impaye}'
                   ,/*CG_Num*/(CASE WHEN '{$this->CG_Num}' ='' OR '{$this->CG_Num}' = 'NULL' THEN NULL ELSE '{$this->CG_Num}' END),/*RG_TypeReg*/ {$this->RG_TypeReg},
                /*RG_Heure, char(9),*/(SELECT '000' + CAST(DATEPART(HOUR, GETDATE()) as VARCHAR(2)) + CAST(DATEPART(MINUTE, GETDATE()) as VARCHAR(2)) + CAST(DATEPART(SECOND, GETDATE()) as VARCHAR(2))),
                /*RG_Piece*/(CASE WHEN {$this->RG_TypeReg}=2 THEN '' ELSE 
                (SELECT(ISNULL((SELECT TOP 1 CR_Numero01 AS valeur FROM P_COLREGLEMENT ORDER BY cbMarq DESC),1)) as VAL) END)
               ,/*CA_No*/(SELECT CASE WHEN {$this->CA_No}=0 THEN NULL ELSE {$this->CA_No} END)
               ,/*CO_NoCaissier*/(SELECT CASE WHEN {$this->CO_NoCaissier} =0 THEN NULL ELSE {$this->CO_NoCaissier} END)
               ,/*RG_Banque*/{$this->RG_Banque},/*RG_Transfere*/{$this->RG_Transfere} 
               ,/*RG_Cloture*/{$this->RG_Cloture},/*RG_Ticket*/{$this->RG_Ticket}
               ,/*RG_Souche*/{$this->RG_Souche},/*CT_NumPayeurOrig*/(CASE WHEN '{$this->CT_NumPayeurOrig}' ='' THEN NULL 
                    WHEN '{$this->CT_NumPayeurOrig}' = 'NULL' THEN NULL ELSE '{$this->CT_NumPayeurOrig}' END)
                ,/*RG_DateEchCont*/'{$this->RG_DateEchCont}',/*CG_NumEcart*/
                (CASE WHEN '{$this->CG_NumEcart}' ='' OR '{$this->CG_NumEcart}' = 'NULL' THEN NULL ELSE '{$this->CG_NumEcart}' END),/*JO_NumEcart*/
                (CASE WHEN '{$this->JO_NumEcart}' ='' THEN '' 
                    WHEN '{$this->JO_NumEcart}' = 'NULL' THEN NULL ELSE '{$this->JO_NumEcart}' END),/*RG_MontantEcart*/{$this->RG_MontantEcart}
               ,/*RG_NoBonAchat*/{$this->RG_NoBonAchat},/*cbProt*/{$this->cbProt},/*cbCreateur*/'{$this->userName}',/*cbModification*/GETDATE()
               ,/*cbReplication*/{$this->cbReplication},/*cbFlag*/{$this->cbFlag});
                IF EXISTS (SELECT 1 FROM F_CREGLEMENT WHERE RG_Libelle = '{$this->RG_Libelle}' AND RG_Date='{$this->RG_Date}' AND RG_Montant={$this->RG_Montant} AND RG_Type={$this->RG_Type} AND RG_TypeReg = {$this->RG_TypeReg}) 
                    SELECT RG_No FROM F_CREGLEMENT WHERE RG_Libelle = '{$this->RG_Libelle}' AND RG_Date='{$this->RG_Date}' AND RG_Montant={$this->RG_Montant} AND RG_Type={$this->RG_Type} AND RG_TypeReg = {$this->RG_TypeReg}
                ELSE 
                SELECT RG_No FROM F_CREGLEMENT 
                    WHERE cbMarq = (select @@IDENTITY);
                END;";
        $result= $this->db->query($requete);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $creglement = new ReglementClass($rows[0]->RG_No,$this->db);
        $log = new LogFile($this->db);
        $log->writeReglement("Ajout Règlement",$this->RG_Montant,$rows[0]->RG_No,$creglement->CT_NumPayeur,$rows[0]->RG_No,'F_ARTSTOCK',$this->userName,$this->userName,$this->RG_Date);

        return $rows[0]->RG_No;
    }

    public function delete($protNo=0){
        parent::delete();
        $log = new LogFile($this->db);
        $log->writeReglement("Suppr Reglement",$this->RG_Montant,$this->RG_No,$this->CT_NumPayeur,$this->cbMarq,"F_CREGLEMENT",$protNo,$this->cbCreateur,$this->RG_Date);
    }

    public function insertZ_REGLEMENT_ANALYTIQUE($RG_No, $CA_Num){
        $requete = "    INSERT INTO Z_REGLEMENT_ANALYTIQUE(CA_Num,RG_No,cbModification,cbCreateur) 
                        VALUES ('$CA_Num',$RG_No,GETDATE(),'{$this->userName}')";
        $this->db->query($requete);
        echo "rgNo : $RG_No caNum:$CA_Num";
        die();
    }


    public function insertFactReglSuppr($DO_Domaine,$DO_Type,$DO_Piece,$CbMarq_Entete){
        $requete="  DECLARE @DO_Domaine INT = $DO_Domaine
                            ,@DO_Type INT = $DO_Type       
                            ,@DO_Piece NVARCHAR(50) = '$DO_Piece'
                            ,@CbMarq_Entete INT = $CbMarq_Entete       
                            ,@RG_No INT = {$this->RG_No}         
                            ,@CbMarq_RG INT = {$this->cbMarq};
                            
                    INSERT INTO [dbo].[Z_FACT_REGL_SUPPR]([DO_Domaine],[DO_Type],[DO_Piece],[CbMarq_Entete],[RG_No],[CbMarq_RG])
                    VALUES      (/*DO_Domaine*/ @DO_Domaine          ,/*DO_Type*/    @DO_Type       ,/*DO_Piece, varchar(25),*/@DO_Piece
                               ,/*CbMarq_Entete*/    @CbMarq_Entete       ,/*RG_No*/  @RG_No         ,/*CbMarq_RG*/@CbMarq_RG)";
        $this->db->query($requete);

    }

    public function removeFacRglt($do_piece,$do_type,$do_domaine){
        $requete="  DECLARE @RG_No INT = {$this->RG_No}
                            ,@DO_Piece NVARCHAR(50) = '$do_piece'
                            ,@DO_Type INT = $do_type
                            ,@DO_Domaine INT = $do_domaine
                    UPDATE F_DOCREGL SET DR_Regle = 
                     (  SELECT  CASE WHEN DR_Regle= 1 THEN 0 ELSE DR_Regle END
                        FROM    F_DOCREGL A
                        INNER JOIN F_REGLECH B 
                            ON  A.DR_No=B.DR_No
                        WHERE   RG_No=@RG_No 
                        AND     A.DO_Piece=@DO_Piece 
                        AND     A.DO_Domaine=@DO_Domaine 
                        AND     A.DO_Type=@DO_Type)
                    FROM    F_REGLECH 
                    WHERE   F_DOCREGL.DR_No=F_REGLECH.DR_No 
                    AND     RG_No=@RG_No 
                    AND     F_DOCREGL.DO_Piece=@DO_Piece 
                    AND     F_DOCREGL.DO_Domaine=@DO_Domaine 
                    AND     F_DOCREGL.DO_Type=@DO_Type;
                    DELETE FROM F_REGLECH
                    WHERE   RG_No=@RG_No 
                    AND     DO_Piece=@DO_Piece 
                    AND     DO_Domaine=@DO_Domaine 
                    AND     DO_Type=@DO_Type;
                    UPDATE F_CREGLEMENT SET RG_Impute = 
                     (SELECT CASE WHEN RG_Impute = 1 THEN 0 ELSE RG_Impute END
                    FROM F_CREGLEMENT
                    WHERE RG_No=@RG_No) WHERE RG_No=@RG_No";
        $this->db->query($requete);
    }

    public function majZ_REGLEMENT_ANALYTIQUE($RG_No, $CA_Num){
        $requete = "UPDATE Z_REGLEMENT_ANALYTIQUE SET CA_Num='$CA_Num',cbModification=GETDATE(),cbCreateur='".$this->userName."' WHERE RG_No = $RG_No";
        $this->db->query($requete);
    }

    public function isImpute(){
        $query ="
                DECLARE @rgNo INT = {$this->RG_No};
                WITH _UnionReglEch_ AS(
                    SELECT  RG_No
                            ,RC_Montant = sum(RC_Montant) 
                    FROM    F_REGLECH
                    GROUP BY RG_No
                    UNION
                    SELECT  A.RG_No
                            ,SUM(ISNULL(ABS(C.RG_Montant),0)) 
                    FROM    F_CREGLEMENT A
                    INNER JOIN Z_RGLT_BONDECAISSE B 
                        ON  A.RG_No = B.RG_No_RGLT
                    INNER JOIN F_CREGLEMENT C
                        ON  B.RG_No = C.RG_No
                    GROUP BY A.RG_No
                )
                
                SELECT  A.RG_No
                        ,MontantImpute = RG_Montant-isnull(RC_Montant,0)
                        ,isImpute = CASE WHEN RG_Montant-isnull(RC_Montant,0) = 0 THEN 1 ELSE 0 END 
                FROM    F_CREGLEMENT A
                LEFT JOIN (
                    SELECT  A.RG_No
                            ,RC_Montant = SUM(RC_Montant)
                    FROM    _UnionReglEch_ A 
                    GROUP BY RG_No
                )B 
                    ON A.RG_No = B.RG_No
                WHERE A.RG_No =@rgNo;";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getReglementByClient($ct_num,$ca_no,$type,$treglement,$datedeb,$datefin,$caissier,$collab,$typeSelectRegl=0) {
        $treglementParam = 0;
        if($treglement!="")
            $treglementParam = $treglement;
        return $this->getApiJson("/getReglementByClient&dateDeb={$datedeb}&dateFin={$datefin}&rgImpute={$type}&ctNum={$ct_num}&collab={$collab}&nReglement={$treglementParam}&caNo={$ca_no}&coNoCaissier={$caissier}&rgType={$typeSelectRegl}&protNo={$_SESSION["id"]}");
    }

    public function addReglementCaisse($rg_typereg,$montant,$cg_num,$jo_num,$co_nocaissier,$libelle,$banque,$login,$date,$caNo,$journalRec,$caNoDest,$CA_Num,$CG_Analytique){
        try {
            $this->db->connexion_bdd->beginTransaction();
            if ($rg_typereg != 16) {
                $rg_typeregVal = $rg_typereg;
                if ($rg_typereg == 6)
                    $rg_typeregVal = 5;
                if ($rg_typereg == 6) {
                    $caisse = new CaisseClass($caNo,$this->db);
                    $this->setReglement('NULL', $this->objetCollection->getDate($date), $montant, $journalRec, $cg_num, $caNo, $co_nocaissier, $this->objetCollection->getDate($date), $libelle, 0, 2, 1, $rg_typeregVal, 1, 1, $login);
                    $rg_no = $this->insertF_Reglement();
                    $this->setReglement('NULL', $this->objetCollection->getDate($date), $montant, $caisse->JO_Num, $cg_num, $caNo, $co_nocaissier, $this->objetCollection->getDate($date), $libelle."_".$caisse->JO_Num, 0, 2, 8, 4, 1, 1, $login);
                    $rg_noDest = $this->insertF_Reglement();
                    $this->insertF_ReglementVrstBancaire($rg_no, $rg_noDest);
                } else {
                    $this->setReglement('NULL', $this->objetCollection->getDate($date), $montant, $jo_num, $cg_num, $caNo, $co_nocaissier, $this->objetCollection->getDate($date), $libelle, 0, 2, 1, $rg_typeregVal, 1, $banque, $login);
                    $rg_no = $this->insertF_Reglement();
                }
            } else {
                $this->setReglement('NULL', $this->objetCollection->getDate($date), $montant, $jo_num, $cg_num, $caNo, $co_nocaissier, $this->objetCollection->getDate($date), $libelle, 0, 2, 1, 4, 1, $banque, $login);
                $rg_no = $this->insertF_Reglement();
                $caisseDest = new CaisseClass($caNoDest,$this->db);
                $this->setReglement('NULL', $this->objetCollection->getDate($date), $montant, $caisseDest->JO_Num, $cg_num, $caisseDest->CA_No, $caisseDest->CO_NoCaissier, $this->objetCollection->getDate($date), $libelle, 0, 2, 1, 5, 1, $banque, $login);
                $rg_no = $this->insertF_Reglement();
            }

            if ($CA_Num != "" && $CG_Analytique == 1) {
                $this->insertCaNum($rg_no, $CA_Num);
            }

            if ($rg_typereg == 4) {
                $caisse = new CaisseClass($_POST["CA_No"],$this->db);
                $message = "SORTIE D' UN MONTANT DE {$this->objetCollection->formatChiffre($montant)} POUR $libelle DANS LA CAISSE {$caisse->CA_Intitule}  SAISI PAR $login LE " . date("d/m/Y", strtotime($this->objetCollection->getDate($date)));
                $result = $this->db->requete($this->objetCollection->getCollaborateurEnvoiMail("Mouvement de sortie"));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if ($rows != null) {
                    foreach ($rows as $row) {
                        $email = $row->CO_EMail;
                        $collab_intitule = $row->CO_Nom;
                        if (($email != "" || $email != null)) {
                            $mail = new Mail();
                            $mail->sendMail($message."<br/><br/><br/> {$this->db->db}", $email,  "Mouvement de sortie");
                        }
                    }
                }

                $result = $this->db->requete($this->objetCollection->getCollaborateurEnvoiSMS("Mouvement de sortie"));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if ($rows != null) {
                    foreach ($rows as $row) {
                        $telephone = $row->CO_Telephone;
                        if (($telephone != "" || $telephone != null)) {
                            $message = "SORTIE DE {$this->objetCollection->formatChiffre($montant)} POUR $libelle LE " . date('d/m/Y', strtotime($this->objetCollection->getDate($date))) . " DANS {$caisse->CA_Intitule}";
                            $contactD = new ContatDClass(1,$this->db);
                            $contactD->sendSms($telephone, $message);
                        }
                    }
                }
            }

            if ($rg_typereg == 6) {
                $caisse = new CaisseClass($_POST["CA_No"],$this->db);
                $message = "VERSEMENT BANCAIRE D'UN MONTANT DE $montant DANS LA CAISSE {$caisse->CA_Intitule} SAISI PAR $login LE {$this->objetCollection->getDate($date)}";
                $result = $this->db->requete($this->objetCollection->getCollaborateurEnvoiMail("Versement bancaire"));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if ($rows != null) {
                    foreach ($rows as $row) {
                        $email = $row->CO_EMail;
                        $collab_intitule = $row->CO_Nom;
                        $telephone = $row->CO_Telephone;
                        if (($email != "" || $email != null)) {
                            $mail = new Mail();
                            $mail->sendMail($message."<br/><br/><br/> {$this->db->db}", $email,  "Versement bancaire");
                        }
                    }
                }

                $result = $this->db->requete($this->objetCollection->getCollaborateurEnvoiSMS("Versement bancaire"));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if ($rows != null) {
                    foreach ($rows as $row) {
                        $telephone = $row->CO_Telephone;
                        if (($telephone != "" || $telephone != null)) {
                            $message = "SORTIE DE $montant POUR $libelle LE {$this->objetCollection->getDate($date)} DANS {$caisse->CA_Intitule}";
                            $contactD = new ContatDClass(1,$this->db);
                            $contactD->sendSms($telephone, $message);
                        }
                    }
                }
            }
            if ($rg_typereg != 2)
                $this->objetCollection->incrementeCOLREGLEMENT();

            $this->db->connexion_bdd->commit();
        }
        catch(Exception $e){
            $this->db->connexion_bdd->rollBack();
            return json_encode($e);
        }
    }

    public function insertMvtCaisse($rgMontant,$protNo,$caNum,$libelle,$rgTypeReg,$caNo,$cgNumBanque,$isModif,$rgDate,$joNum,$caNoDest,$cgAnalytique,$rgTyperegModif,$journalRec,$rgNoDest){
        $this->getApiExecute("/insertMvtCaisse&rgMontant=$rgMontant&protNo=$protNo&caNum=$caNum&libelle={$this->formatString($libelle)}&rgTypeReg=$rgTypeReg&caNo=$caNo&cgNumBanque=$cgNumBanque&isModif=$isModif&rgDate=$rgDate&joNum=$joNum&caNoDest=$caNoDest&cgAnalytique=$cgAnalytique&rgTyperegModif=$rgTyperegModif&journalRec=$journalRec&rgNoDest=$rgNoDest");
    }

    public function modifReglementCaisse($rg_typeregModif,$RG_NoLigne,$date,$CA_No,$libelle,$CG_NumBanque,$montant,$journalRec,$RG_NoDestLigne,$CA_No_Dest){
        try {
            if ($rg_typeregModif == 4 || $rg_typeregModif == 2 || $rg_typeregModif == 5) {
                    $this->db->connexion_bdd->beginTransaction();
                    $creglement = new ReglementClass($RG_NoLigne,$this->db);
                    $creglement->RG_Date = $this->objetCollection->getDate($date);
                    $caisse = new CaisseClass($CA_No,$this->db);
                    $creglement->JO_Num = $caisse->JO_Num;
                    $creglement->CA_No = $CA_No;
                    $creglement->RG_Libelle = $libelle;
                    $creglement->CG_Num = $CG_NumBanque;
                    $creglement->RG_Montant = str_replace(" ", "", $montant);
                    $creglement->maj_reglement();
            }

            if ($rg_typeregModif == 6) {
                    $creglement = new ReglementClass($RG_NoLigne,$this->db);
                    $creglement->RG_Date = $this->getDate($date);
                    $creglement->CA_No = $CA_No;
                    $creglement->RG_Libelle = $libelle;
                    $creglement->CG_Num = $CG_NumBanque;
                    $creglement->RG_TypeReg = 5;
                    $creglement->RG_Montant = str_replace(" ", "", $montant);
                    $creglement->JO_Num = $journalRec;
                    $creglement->maj_reglement();
            }

            if ($rg_typeregModif == 16) {
                    $creglement = new ReglementClass($RG_NoLigne,$this->db);
                    $creglement->RG_Date = $this->getDate($date);
                    $creglement->CA_No = $CA_No;
                    $caisse = new CaisseClass($CA_No,$this->db);
                    $creglement->JO_Num = $caisse->JO_Num;
                    $creglement->RG_Libelle = $libelle;
                    $creglement->CG_Num = $CG_NumBanque;
                    $creglement->RG_TypeReg = 4;
                    $creglement->RG_Montant = str_replace(" ", "", $montant);
                    $creglement->maj_reglement();

                    $creglement = new ReglementClass($RG_NoDestLigne,$this->db);
                    $creglement->RG_Date = $this->getDate($date);
                    $creglement->CA_No = $CA_No_Dest;
                    $caisse = new CaisseClass($CA_No_Dest,$this->db);
                    $creglement->JO_Num = $caisse->JO_Num;
                    $creglement->RG_Libelle = $libelle;
                    $creglement->CG_Num = $CG_NumBanque;
                    $creglement->RG_TypeReg = 5;
                    $creglement->RG_Montant = str_replace(" ", "", $montant);
                    $creglement->maj_reglement();
            }
            $this->db->connexion_bdd->commit();
        }
        catch(Exception $e){
            $this->db->connexion_bdd->rollBack();
            return json_encode($e);
        }
    }

    public function addCReglementFacture($cbMarqEntete, $montant,$rg_type,$mode_reglement,$caisse,$date_reglt,$lib_reglt,$date_ech,$protNo) {
        $docEntete = new DocEnteteClass($cbMarqEntete,$this->db);
        $DO_Date = $date_reglt;
        $CT_Num = $docEntete->DO_Tiers;
        $DE_No = $docEntete->DE_No;
        $CA_Num = $docEntete->CA_Num;
        $DO_Ref = $docEntete->DO_Ref;
        if(isset($_SESSION)){
            $protection = new ProtectionClass($_SESSION["login"],$_SESSION["mdp"]);
            $co_noProt = $protection->getCoNo();
            if($co_noProt == null)
                $CO_No = $docEntete->CO_No;
            else {
                $CO_No = $co_noProt;
            }
        }else {
            $CO_No = $docEntete->CO_No;
        }
        $cg_num = $docEntete->CG_Num;
        $DO_Devise = $docEntete->DO_Devise !="" ? $docEntete->DO_Devise : 0 ;
        $DO_Cours = $docEntete->DO_Cours !="" ? $docEntete->DO_Cours : 0 ;
        $DO_Domaine = $docEntete->DO_Domaine;
        $DO_Type = $docEntete->DO_Type;
        $caisseVal = new CaisseClass($caisse,$this->db);
        if($caisseVal->CA_No==""){
            $co_nocaissier = 0;
            $ca_no = 0;
            $jo_num = "";
        }else {
            $co_nocaissier = $caisseVal->CO_NoCaissier;
            $ca_no = $caisseVal->CA_No;
            $jo_num = $caisseVal->JO_Num;
        }
        $ticket = 0;
        if($DO_Type==30) $ticket = 1;
        $creglement = new ReglementClass(0,$this->db);
        $creglement->initVariables();
        $creglement->RG_Date = $DO_Date;
        $creglement->CT_NumPayeur = $CT_Num;
        $creglement->CT_NumPayeurOrig = $CT_Num;
        $creglement->CA_No = $ca_no;
        $creglement->CG_Num = $cg_num;
        $creglement->RG_Reference = $DO_Ref;
        //$caisse = new CaisseClass($creglement->CA_No);
        $creglement->JO_Num = $jo_num;
        $creglement->CO_NoCaissier = $CO_No;
        $creglement->setuserName("","");
        $creglement->RG_Montant = $montant;
        $creglement->RG_Libelle = $lib_reglt;
        $creglement->RG_Impute = 1;
        $creglement->RG_Type = $rg_type;
        $creglement->N_Reglement = $mode_reglement;
        $creglement->RG_TypeReg=0;
        $creglement->RG_Ticket=$ticket;
        $creglement->RG_Banque=0;
        $creglement->N_Devise = $DO_Devise;
        $creglement->RG_Cours = $DO_Cours;
        $creglement->RG_DateEchCont=$DO_Date;
        $creglement->userName = $protNo;

        $rg_no = $creglement->insertF_Reglement();
        $creglement = new ReglementClass($rg_no);
        $this->objetCollection->incrementeCOLREGLEMENT();
        $docRegl = new DocReglClass(0);
        $docRegl = $docRegl->setDocReglByEntete($cbMarqEntete);
        if($docRegl->cbMarq==""){
            $cbMarqDocRegl = $docRegl->addDocRegl( $docEntete->DO_Domaine, $docEntete->DO_Type, $docEntete->DO_Piece,0,$mode_reglement,$date_reglt);
            $docRegl = new DocReglClass($cbMarqDocRegl);
        }
        $dr_no = $docRegl->DR_No;
        $montantTTC = ($docEntete->montantRegle());
        $montantTTC_regle = ($docEntete->AvanceDoPiece());
        $reste_a_regler = $montantTTC - $montantTTC_regle;
        $reglEch = new ReglEchClass(0);

        if(($reste_a_regler>=0 && $montant>$reste_a_regler) || ($reste_a_regler<0 && $montant<$reste_a_regler)){
            $reglEch->addReglEch($rg_no, $dr_no, $docEntete->DO_Domaine, $docEntete->DO_Type, $docEntete->DO_Piece, round($reste_a_regler,2));
        }else{
            $reglEch->addReglEch($rg_no, $dr_no, $docEntete->DO_Domaine, $docEntete->DO_Type, $docEntete->DO_Piece, round($montant,2));
            if($montant==$reste_a_regler){
                $docRegl->maj("DR_Regle",1);
                $docRegl->majcbModification();
                $creglement->maj("RG_Impute",1);
                $creglement->majcbModification();
            }
        }
        $docRegl->maj("DR_Date",$date_ech);
        $docRegl->majcbModification();
        return $rg_no;
    }


    public function isRegleFull(){

        $query = "  SELECT CASE WHEN RG_Montant = RC_Montant THEN 1 ELSE 0 END AS VAL
                    FROM(SELECT Max(RG_Montant)RG_Montant,ISNULL(SUM(RC_Montant),0) RC_Montant
                         FROM F_CREGLEMENT C
                         LEFT JOIN F_REGLECH D 
                             ON D.RG_No=C.RG_No
                         WHERE C.cbMarq={$this->cbMarq})A";

        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ)[0]->VAL;
    }

    public function addReglement($mobile/*$_GET["mobile"]*/,$jo_num/*$_GET["JO_Num"]*/,$rg_no_lier/*$_GET["RG_NoLier"]*/,$ct_num /*$_GET['CT_Num']*/
                                ,$ca_no/*$_GET["CA_No"]*/,$boncaisse /*$_GET["boncaisse"]*/,$libelle /*$_GET['libelle']*/,$caissier /*$_GET['caissier']*/
                                ,$date/*$_GET['date']*/,$modeReglementRec /*$_GET["mode_reglementRec"]*/
                                ,$montant /*$_GET['montant']*/,$impute/*$_GET['impute']*/,$RG_Type /*$_GET['RG_Type']*/,$afficheData=true,$typeRegl=""){
        $url = "/addReglement&protNo={$_SESSION["id"]}&joNum=$jo_num&rgNoLier=$rg_no_lier&ctNum=$ct_num&caNo=$ca_no&bonCaisse=$boncaisse&libelle=$libelle&caissier=$caissier&date=$date&modeReglementRec=$modeReglementRec&montant=$montant&impute=$impute&rgType=$RG_Type&afficheData=$afficheData&typeRegl=$typeRegl";
        $info = $this->getApiJson($url);
        if($afficheData)
            echo json_encode($info);
    }


    public function clotureComptable($dateCloture,$journalDebut,$journalFin,$ProtNo,$typeCloture)
    {
        $query = "      BEGIN 
                        SET NOCOUNT ON;
                        DECLARE @ProtNo INT = $ProtNo
                        ,@journalDebut NVARCHAR(200) = '$journalDebut'
                        ,@journalFin NVARCHAR(200) = '$journalFin'
                        ,@dateCloture DATE = '$dateCloture'
                        ,@typeCloture INT = $typeCloture
                        ;
                        
                      UPDATE F_ECRITUREC 
						SET EC_Cloture = @typeCloture
                      WHERE @dateCloture = CAST(DATEADD(Day,EC_Jour-1,JM_Date) AS DATE)
                      AND   EC_Cloture<>@typeCloture
                      AND   (@journalDebut ='0' OR JO_Num>=@journalDebut)
                      AND   (@journalFin ='0' OR JO_Num<=@journalFin);
                END;";
        $this->db->query($query);
    }



    public function getMajComptaListe()
    {
        $query = "BEGIN 
DECLARE @rgNo AS INT
DECLARE @pLigneNeg INT;
DECLARE @rgTypeReg INT;
SET @rgNo = {$this->RG_No}
SELECT @pLigneNeg = P_LigneNeg FROM P_PARAMETRECIAL;
SELECT @rgTypeReg = RG_TypeReg FROM F_CREGLEMENT WHERE RG_No = @rgNo;
WITH _ReglementCredit_ AS (
	SELECT CT_NumCont = CASE WHEN	doc.DO_Domaine IS NULL 
								AND cg.CG_Tiers = 0 THEN '' ELSE cre.CT_NumPayeur END
			,CT_Num = ''
			,CG_NumCont = cre.CG_Num
			,CG_Num = CASE WHEN jo.CG_Num IS NOT NULL THEN jo.CG_Num ELSE cre.CG_Num END
			,cre.JO_Num
			,Annee_Exercice = CAST(YEAR(cre.RG_Date) AS NVARCHAR(10)) + RIGHT('0'+ CAST(MONTH(cre.RG_Date) AS NVARCHAR(10)),2)
			,EC_Jour = DAY(cre.RG_Date)
			,EC_RefPiece = doc.DO_Piece
			,doc.DO_Domaine
			,EC_Reference = doc.DO_Ref
			,cre.RG_TypeReg
			,cre.RG_Date
			,doc.DO_Provenance
			,EC_Echeance = CASE WHEN cre.RG_TypeReg NOT IN (4,5) AND doc.DO_Domaine IS NULL 
						THEN '1900-01-01' ELSE docR.DR_Date END	
			,RG_Montant = CASE WHEN doc.DO_Domaine IS NOT NULL THEN
				CASE WHEN doc.DO_Provenance IN (1,2) AND @pLigneNeg = 0 THEN 
					-cre.RG_Montant
					ELSE cre.RG_Montant END
					ELSE cre.RG_Montant END
			,N_Reglement = CASE WHEN doc.DO_Domaine IS NULL THEN 1 ELSE 0 END
			,cre.RG_Libelle
	FROM F_CREGLEMENT cre
	LEFT JOIN (SELECT DO_Domaine,DO_Type,cbDO_Piece,RG_No,TopRG = ROW_NUMBER() OVER(PARTITION BY RG_No ORDER BY RG_No)
				FROM F_REGLECH
				GROUP BY DO_Domaine,DO_Type,cbDO_Piece,RG_No) reg
		ON cre.RG_No = reg.RG_No
		AND reg.TopRG=1
	LEFT JOIN F_DOCENTETE doc
		ON	doc.DO_Domaine = reg.DO_Domaine
		AND	doc.DO_Type = reg.DO_Type
		AND doc.cbDO_Piece = reg.cbDO_Piece
	LEFT JOIN (SELECT DO_Domaine,DO_Type,cbDO_Piece,DR_Date = MIN(DR_Date)
				FROM F_DOCREGL 
				GROUP BY DO_Domaine,DO_Type,cbDO_Piece)docR
		ON	doc.DO_Domaine = docR.DO_Domaine
		AND	doc.DO_Type = docR.DO_Type
		AND doc.cbDO_Piece = docR.cbDO_Piece
	LEFT JOIN F_COMPTET co
		ON	co.cbCT_Num = cre.cbCT_NumPayeur
	LEFT JOIN F_COMPTEG cg
		ON co.cbCG_NumPrinc = cg.cbCG_Num
	LEFT JOIN F_JOURNAUX jo
		ON jo.JO_Num = cre.JO_Num
	WHERE cre.RG_No = @rgNo
)
, _LettrageCredit_ AS (
	SELECT  lettrage = ISNULL(lettrage,'A')
	FROM (
		SELECT  lettrage = CHAR(ASCII(MAX(EC_Lettrage))+1)
		FROM    F_ECRITUREC A
		WHERE   EC_Lettre=1
		AND		CT_Num = (SELECT MAX(CT_Num) FROM _ReglementCredit_ )
		AND		CG_Num = (SELECT MAX(CG_Num) FROM _ReglementCredit_ ) 
		AND     CAST(DATEADD(DAY,A.EC_Jour-1,A.JM_Date) AS DATE) = (SELECT MAX(RG_Date) FROM _ReglementCredit_) 
	) A
)
,_PreSourceCredit_ AS (
SELECT	
		nomFichier = ''
		,JO_Num 
		,Annee_Exercice
        ,EC_Jour
		,EC_RefPiece
		,EC_Reference
		,CG_Num
        ,TA_Provenance = 0
		,EC_StatusRegle = 0
		,EC_MontantRegle = 0
		,EC_Sens = CASE WHEN DO_Domaine IS NOT NULL THEN
						CASE WHEN DO_Domaine = 0 AND CT_Num <>'' THEN 
								CASE WHEN DO_Provenance IN (1,2) AND @pLigneNeg = 0 THEN 1 ELSE 0 END
							 WHEN DO_Domaine = 1 AND CT_Num = '' THEN 
								CASE WHEN DO_Provenance IN (1,2) AND @pLigneNeg = 0 THEN 0 ELSE 1 END
							 WHEN RG_TypeReg = 4 THEN 1
						ELSE 0 END 
					ELSE
						CASE WHEN @rgTypeReg=5 AND  @pLigneNeg = 0 THEN 1 
								WHEN @rgTypeReg=5 AND  @pLigneNeg = 1 THEN 0
								WHEN @rgTypeReg=4 AND  @pLigneNeg = 0 THEN 0
								WHEN @rgTypeReg=4 AND  @pLigneNeg = 1 THEN 1 ELSE 0 END
					END
		,EC_Lettrage = ''--(SELECT Lettrage FROM _LettrageCredit_)
		,CG_NumCont
        ,CT_Num
		,CT_NumCont
		,EC_Intitule = RG_Libelle
		,N_Reglement
		,EC_Echeance	
		,TA_Code =''
		,RG_Montant
FROM _ReglementCredit_
)

,_Reglement_ AS (
	SELECT CT_Num = CASE WHEN cre.RG_TypeReg NOT IN (4,5) 
								AND doc.DO_Domaine IS NULL 
								AND cg.CG_Tiers = 0 THEN '' ELSE cre.CT_NumPayeur END
			,CG_Num =CASE WHEN cre.RG_TypeReg NOT IN (4,5) AND doc.DO_Domaine IS NULL 
						THEN CASE WHEN co.CG_NumPrinc IS NOT NULL THEN cg.CG_Num ELSE '' END 
						ELSE cre.CG_Num END
			,cre.JO_Num
			,Annee_Exercice = CAST(YEAR(cre.RG_Date) AS NVARCHAR(10)) + RIGHT('0'+ CAST(MONTH(cre.RG_Date) AS NVARCHAR(10)),2)
			,EC_Jour = DAY(cre.RG_Date)
			,EC_RefPiece = doc.DO_Piece
			,doc.DO_Domaine
			,doc.DO_Provenance
			,EC_Reference = doc.DO_Ref
			,cre.RG_TypeReg
			,cre.RG_Date
			,EC_Echeance = CASE WHEN cre.RG_TypeReg NOT IN (4,5) AND doc.DO_Domaine IS NULL 
						THEN '1900-01-01' ELSE docR.DR_Date END	
			,RG_Montant = CASE WHEN doc.DO_Domaine IS NOT NULL THEN
				CASE WHEN doc.DO_Provenance IN (1,2) AND @pLigneNeg = 0 THEN 
					-cre.RG_Montant
					ELSE cre.RG_Montant END
					ELSE cre.RG_Montant END
			,N_Reglement = CASE WHEN doc.DO_Domaine IS NULL THEN 1 ELSE 0 END
			,cre.RG_Libelle
	FROM F_CREGLEMENT cre
	LEFT JOIN (SELECT DO_Domaine,DO_Type,cbDO_Piece,RG_No,TopRG = ROW_NUMBER() OVER(PARTITION BY RG_No ORDER BY RG_No)
				FROM F_REGLECH
				GROUP BY DO_Domaine,DO_Type,cbDO_Piece,RG_No) reg
		ON cre.RG_No = reg.RG_No
		AND reg.TopRG = 1
	LEFT JOIN F_DOCENTETE doc
		ON	doc.DO_Domaine = reg.DO_Domaine
		AND	doc.DO_Type = reg.DO_Type
		AND doc.cbDO_Piece = reg.cbDO_Piece
	LEFT JOIN (SELECT DO_Domaine,DO_Type,cbDO_Piece,DR_Date = MIN(DR_Date)
				FROM F_DOCREGL 
				GROUP BY DO_Domaine,DO_Type,cbDO_Piece) docR
		ON	doc.DO_Domaine = docR.DO_Domaine
		AND	doc.DO_Type = docR.DO_Type
		AND doc.cbDO_Piece = docR.cbDO_Piece
	LEFT JOIN F_COMPTET co
		ON	co.cbCT_Num = cre.cbCT_NumPayeur
	LEFT JOIN F_COMPTEG cg
		ON co.cbCG_NumPrinc = cg.cbCG_Num
	WHERE cre.RG_No = @rgNo
)
, _Lettrage_ AS (
	SELECT  lettrage = ISNULL(lettrage,'A')
	FROM (
		SELECT  lettrage = CHAR(ASCII(MAX(EC_Lettrage))+1)
		FROM    F_ECRITUREC A
		WHERE   EC_Lettre=1
		AND		CT_Num = (SELECT MAX(CT_Num) FROM _Reglement_)
		AND		CG_Num = (SELECT MAX(CG_Num) FROM _Reglement_) 
		AND     CAST(DATEADD(DAY,A.EC_Jour-1,A.JM_Date) AS DATE) = (SELECT MAX(RG_Date) FROM _Reglement_) 
	) A
)
,_PreSource_ AS (
SELECT	
		nomFichier = ''
		,JO_Num 
		,Annee_Exercice
        ,EC_Jour
		,EC_RefPiece
		,EC_Reference
		,CG_Num
        ,TA_Provenance = 0
		,EC_StatusRegle = 0
		,EC_MontantRegle = 0
		,EC_Sens = CASE WHEN DO_Domaine IS NOT NULL THEN
						CASE WHEN DO_Domaine = 0 AND CT_Num IS NOT NULL THEN 
								CASE WHEN DO_Provenance IN (1,2) AND @pLigneNeg = 0 THEN 0 ELSE 1 END
							 WHEN DO_Domaine = 1 AND CT_Num IS NULL THEN 
								CASE WHEN DO_Provenance IN (1,2) AND @pLigneNeg = 0 THEN 0 ELSE 1 END
							 WHEN RG_TypeReg = 5 THEN 1
						ELSE 0 END 
					ELSE 
						CASE WHEN @rgTypeReg=5 AND  @pLigneNeg = 0 THEN 0 
								WHEN @rgTypeReg=5 AND  @pLigneNeg = 1 THEN 1
								WHEN @rgTypeReg=4 AND  @pLigneNeg = 0 THEN 1
								WHEN @rgTypeReg=4 AND  @pLigneNeg = 1 THEN 0 ELSE 0 END
					END
		,EC_Lettrage = ISNULL((SELECT Lettrage FROM _Lettrage_),'A')
		,CG_NumCont = ''
        ,CT_Num
		,CT_NumCont = ''
		,EC_Intitule = RG_Libelle
		,N_Reglement
		,EC_Echeance	
		,TA_Code =''
		,RG_Montant
FROM _Reglement_ reg
)
,_Union_ AS (
SELECT	Ligne = CASE WHEN @rgTypeReg IN (4,5) THEN 1 ELSE 0 END
		,nomFichier
		,JO_Num
		,Annee_Exercice
        ,EC_Jour
		,EC_RefPiece
		,EC_Reference
		,CG_Num
        ,TA_Provenance
		,EC_StatusRegle
		,EC_MontantRegle
		,EC_Sens
		,EC_Lettrage
		,CG_NumCont
        ,CT_Num
		,CT_NumCont
		,EC_Intitule
		,N_Reglement
		,EC_Echeance
		,EC_MontantCredit = CASE WHEN EC_Sens = 0 THEN RG_Montant ELSE 0 END
        ,EC_MontantDebit = CASE WHEN EC_Sens = 1 THEN RG_Montant ELSE 0 END
		,EC_Montant = RG_Montant
		,TA_Code =''
FROM	_PreSource_
UNION
SELECT	Ligne = CASE WHEN @rgTypeReg IN (4,5) THEN 2 ELSE 1 END
		,nomFichier
		,JO_Num
		,Annee_Exercice
        ,EC_Jour
		,EC_RefPiece
		,EC_Reference
		,CG_Num
        ,TA_Provenance
		,EC_StatusRegle
		,EC_MontantRegle
		,EC_Sens
		,EC_Lettrage
		,CG_NumCont
        ,CT_Num
		,CT_NumCont
		,EC_Intitule
		,N_Reglement
		,EC_Echeance
		,EC_MontantCredit = CASE WHEN EC_Sens = 0 THEN RG_Montant ELSE 0 END
        ,EC_MontantDebit = CASE WHEN EC_Sens = 1 THEN RG_Montant ELSE 0 END
		,EC_Montant = RG_Montant
		,TA_Code =''
FROM	_PreSourceCredit_
)
SELECT *
FROM _Union_
ORDER BY Ligne
END
";
        $result = $this->db->requete($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        return $rows;
    }
    public function getListeReglementMajComptable($typeTransfert,$datedeb, $datefin,$caisse,$transfert){
        $typeValue = 0;
        if($typeTransfert == 4)
            $typeValue = 1;
        $compta=0;
        if($transfert == 1)
            $compta = 1;
        $query = "
                    DECLARE @datedeb NVARCHAR(50) ='$datedeb'
                    DECLARE @datefin NVARCHAR(50) ='$datefin'
                    DECLARE @caisse INT = $caisse
                    DECLARE @compta INT = $compta
                    DECLARE @typeValue INT = $typeValue
                  SELECT DISTINCT cre.RG_No
                  FROM F_CREGLEMENT cre
                  LEFT JOIN F_REGLECH reg
                    ON cre.RG_No = reg.RG_No
                  WHERE (@datedeb='' OR cre.RG_Date>=@datedeb)
                  AND (@datefin='' OR cre.RG_Date<=@datefin)
                  AND (@caisse=0 OR cre.CA_No = @caisse)
                  AND @compta = cre.RG_Compta 
                  AND cre.EC_No NOT IN (SELECT EC_No FROM F_ECRITUREC)
                  AND (CASE WHEN reg.RG_No IS NULL AND RG_Cloture = 1 THEN 1
                                WHEN reg.RG_No IS NOT NULL AND reg.DO_Domaine = @typeValue THEN 1 ELSE 0 END) = 1";

        $result= $this->db->query($query);
        $this->list = array();
        foreach ($result->fetchAll(PDO::FETCH_OBJ) as $resultat)
        {
            $docEntete = new ReglementClass($resultat->RG_No);
            array_push($this->list,$docEntete);
        }
        return $this->list;
    }

    public function __toString() {
        return "";
    }

    public function formatDate($val){
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $val);
        return $date->format('Y-m-d');
    }

}