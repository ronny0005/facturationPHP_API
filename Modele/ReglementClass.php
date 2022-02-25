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
        $this->db = new DB();
        if($id!=0)
        if (sizeof($this->data) > 0) {
            $this->RG_No = $this->data[0]->RG_No;
            $this->CT_NumPayeur = $this->data[0]->CT_NumPayeur;
            $this->RG_Date = substr($this->data[0]->RG_Date,0,10);
            $this->RG_Reference = $this->data[0]->RG_Reference;
            $this->RG_Libelle = $this->data[0]->RG_Libelle;
            $this->RG_DateSage = $this->formatDateSage(str_replace("T"," ",substr($this->data[0]->RG_Date,0,19)));
            $this->RG_Montant = $this->data[0]->RG_Montant;
            $this->RG_MontantDev = $this->data[0]->RG_MontantDev;
            $this->N_Reglement = $this->data[0]->N_Reglement;
            $this->RG_Impute = $this->data[0]->RG_Impute;
            $this->RG_Compta = $this->data[0]->RG_Compta;
            $this->EC_No = $this->data[0]->EC_No;
            $this->RG_Type = $this->data[0]->RG_Type;
            $this->RG_Cours = $this->data[0]->RG_Cours;
            $this->N_Devise = $this->data[0]->N_Devise;
            $this->JO_Num = $this->data[0]->JO_Num;
            $this->CG_NumCont = $this->data[0]->CG_NumCont;
            $this->RG_Impaye = $this->data[0]->RG_Impaye;
            $this->CG_Num = $this->data[0]->CG_Num;
            $this->RG_TypeReg = $this->data[0]->RG_TypeReg;
            $this->RG_Heure = $this->data[0]->RG_Heure;
            $this->RG_Piece = $this->data[0]->RG_Piece;
            $this->CA_No = $this->data[0]->CA_No;
            $this->CO_NoCaissier = $this->data[0]->CO_NoCaissier;
            $this->RG_Banque = $this->data[0]->RG_Banque;
            $this->RG_Transfere = $this->data[0]->RG_Transfere;
            $this->RG_Cloture = $this->data[0]->RG_Cloture;
            $this->RG_Ticket = $this->data[0]->RG_Ticket;
            $this->RG_Souche = $this->data[0]->RG_Souche;
            $this->CT_NumPayeurOrig = $this->data[0]->CT_NumPayeurOrig;
            $this->RG_DateEchCont = $this->data[0]->RG_DateEchCont;
            $this->CG_NumEcart = $this->data[0]->CG_NumEcart;
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
        return $this->getApiJson("/getMajAnalytique&dateDeb={$dateDeb}&dateFin={$dateFin}&caNum={$caNum}&statut={$statut}");
    }

    public function getMajAnalytiqueNonComptabilisable($dateDeb,$dateFin,$caNum=''){
        return $this->getApiJson("/getMajAnalytiqueNonComptabilisable&dateDeb={$dateDeb}&dateFin={$dateFin}&caNum={$caNum}");
    }

    public function setMajAnalytique($datedeb,$datefin,$caNum,$protNo){
        $this->getApiExecute("/setMajAnalytique&dateDeb={$datedeb}&dateFin={$datefin}&caNum={$caNum}&cbCreateur={$protNo}");
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

    public function majReglement($protNo,$bonCaisse,$rgNo,$rgLibelle,$montant,$rgDate,$joNum,$ctNum,$coNo){
        $this->getApiExecute("/modifReglementTiers&protNo=$protNo&coNo=$coNo&bonCaisse=$bonCaisse&rgNo=$rgNo&rgLibelle={$this->formatString($rgLibelle)}&montant=$montant&rgDate=$rgDate&joNum={$this->formatString($joNum)}&ctNum={$this->formatString($ctNum)}");
    }

    function typeCaisse($val){
        if($val==5) return "Entrée";
        if($val==4) return "Sortie";
        if($val==2) return "Fond de caisse";
        if($val==16) return "Transfert caisse";
        if($val==6) return "Vrst bancaire";
    }

    function TitreTypeCaisse($val){
        if($val==5) return "Entrée de caisse";
        if($val==4) return "Sortie de caisse";
        if($val==2) return "Fond de caisse";
        if($val==16) return "Transfert caisse";
        if($val==6) return "Versement bancaire";
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
                                                <td id='RG_Date'>{$this->objetCollection->getDateDDMMYYYY($row->RG_Date)}</td>
                                                <td id='RG_Libelle'>{$row->RG_Libelle}</td>
                                                <td id='RG_Montant'>{$this->objetCollection->formatChiffre($montant)}</td>
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
                echo "<td><i id='imprimMvt' class='fa fa-print fa-fw'></i></td>";
                echo "</tr>";
                $sommeMnt = $sommeMnt + $montant;
            }
            echo "<tr class='reglement' style='background-color:grey;color:white'>
<td id='rgltTotal'><b>Total</b></td><td></td><td></td><td></td><td><b>{$this->formatChiffre($sommeMnt)}</b></td><td></td><td></td><td></td>";
if($flagAffichageValCaisse==0) echo "<td></td>";
if($flagCtrlTtCaisse==0) echo "<td></td>";
            echo "<td></td></tr>";
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

    public function supprReglement($protNo=0)
    {
        $this->getApiExecute("/supprReglement&rgNo={$this->RG_No}&protNo=$protNo");
    }

    public function remboursementRglt($date,$montant){
        return $this->getApiExecute("/remboursementRglt/rgNo={$this->RG_No}&date=$date&montant=$montant");
    }

    public function getFactureRGNo($rg_no){
        return $this->getApiJson("/getFactureRGNo&rgNo=$rg_no");
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
        $this->getApiExecute("/insertCaNum&rgNo=$rgNo&caNum=$caNum");
    }

    public function insertF_ReglementVrstBancaire($rgNo,$rgNoCache){
        $this->getApiExecute("/insertF_ReglementVrstBancaire&rgNo=$rgNo&rgNoCache=$rgNoCache");
    }

    public function deleteF_ReglementVrstBancaire($rgNo){
        $this->getApiExecute("/deleteF_ReglementVrstBancaire&rgNo=$rgNo");
    }

    public function deleteF_ReglementCaNum($rgNo){
        $this->getApiExecute("/deleteF_ReglementVrstBancaire&rgNo=$rgNo");
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

    public function majZ_REGLEMENT_ANALYTIQUE($RG_No, $CA_Num){
        $requete = "UPDATE Z_REGLEMENT_ANALYTIQUE SET CA_Num='$CA_Num',cbModification=GETDATE(),cbCreateur='".$this->userName."' WHERE RG_No = $RG_No";
        $this->db->query($requete);
    }

    public function getReglementByClient($ct_num,$ca_no,$type,$treglement,$datedeb,$datefin,$caissier,$collab,$protNo,$typeSelectRegl=0) {
        $treglementParam = 0;
        if($treglement!="")
            $treglementParam = $treglement;
        return $this->getApiJson("/getReglementByClient&dateDeb=$datedeb&dateFin=$datefin&rgImpute=$type&ctNum=$ct_num&collab=$collab&nReglement=$treglementParam&caNo=$ca_no&coNoCaissier=$caissier&rgType=$typeSelectRegl&protNo=$protNo");
    }

    public function insertMvtCaisse($rgMontant,$protNo,$caNum,$libelle,$rgTypeReg,$caNo,$cgNumBanque,$isModif,$rgDate,$joNum,$caNoDest,$cgAnalytique,$rgTyperegModif,$journalRec,$rgNoDest){
        $this->getApiExecute("/insertMvtCaisse&rgMontant=$rgMontant&protNo=$protNo&caNum=$caNum&libelle={$this->formatString($libelle)}&rgTypeReg=$rgTypeReg&caNo=$caNo&cgNumBanque=$cgNumBanque&isModif=$isModif&rgDate=$rgDate&joNum=$joNum&caNoDest=$caNoDest&cgAnalytique=$cgAnalytique&rgTyperegModif=$rgTyperegModif&journalRec=$journalRec&rgNoDest=$rgNoDest");
    }

    public function addReglement($protNo,$mobile/*$_GET["mobile"]*/,$jo_num/*$_GET["JO_Num"]*/,$rg_no_lier/*$_GET["RG_NoLier"]*/,$ct_num /*$_GET['CT_Num']*/
                                ,$ca_no/*$_GET["CA_No"]*/,$boncaisse /*$_GET["boncaisse"]*/,$libelle /*$_GET['libelle']*/,$caissier /*$_GET['caissier']*/
                                ,$date/*$_GET['date']*/,$modeReglementRec /*$_GET["mode_reglementRec"]*/
                                ,$montant /*$_GET['montant']*/,$impute/*$_GET['impute']*/,$RG_Type /*$_GET['RG_Type']*/,$afficheData=true,$typeRegl=""){
        $url = "/addReglement&protNo={$protNo}&joNum=$jo_num&rgNoLier=$rg_no_lier&ctNum=$ct_num&caNo=$ca_no&bonCaisse=$boncaisse&libelle={$this->formatString($libelle)}&caissier=$caissier&date=$date&modeReglementRec=$modeReglementRec&montant=$montant&impute=$impute&rgType=$RG_Type&afficheData=$afficheData&typeRegl=$typeRegl";
        $info = $this->getApiJson($url);
        if($afficheData)
            echo json_encode($info);
    }


    public function clotureComptable($dateCloture,$journalDebut,$journalFin,$ProtNo,$typeCloture)
    {
        $this->getApiExecute("/clotureComptable&protNo={$ProtNo}&journalDebut={$journalDebut}&journalFin={$journalFin}&dateCloture={$dateCloture}&typeCloture={$typeCloture}");
    }

    public function getMajComptaListe()
    {
        return $this->getApiJson("/getMajComptaListe&rgNo={$this->RG_No}");
    }

    public function __toString() {
        return "";
    }

    public function formatDate($val){
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $val);
        return $date->format('Y-m-d');
    }

}