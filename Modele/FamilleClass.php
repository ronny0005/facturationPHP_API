<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class FamilleClass Extends Objet{
    //put your code here
    public $db,$FA_CodeFamille
    ,$FA_Type
    ,$FA_Intitule
    ,$FA_UniteVen
    ,$FA_Coef
    ,$FA_SuiviStock
    ,$FA_Garantie
    ,$FA_Central
    ,$FA_Stat01
    ,$FA_Stat02
    ,$FA_Stat03
    ,$FA_Stat04
    ,$FA_Stat05
    ,$FA_CodeFiscal
    ,$FA_Pays
    ,$FA_UnitePoids
    ,$FA_Escompte
    ,$FA_Delai
    ,$FA_HorsStat
    ,$FA_VteDebit
    ,$FA_NotImp
    ,$FA_Frais01FR_Denomination
    ,$FA_Frais01FR_Rem01REM_Valeur
    ,$FA_Frais01FR_Rem01REM_Type
    ,$FA_Frais01FR_Rem02REM_Valeur
    ,$FA_Frais01FR_Rem02REM_Type
    ,$FA_Frais01FR_Rem03REM_Valeur
    ,$FA_Frais01FR_Rem03REM_Type
    ,$FA_Frais02FR_Denomination
    ,$FA_Frais02FR_Rem01REM_Valeur
    ,$FA_Frais02FR_Rem01REM_Type
    ,$FA_Frais02FR_Rem02REM_Valeur
    ,$FA_Frais02FR_Rem02REM_Type
    ,$FA_Frais02FR_Rem03REM_Valeur
    ,$FA_Frais02FR_Rem03REM_Type
    ,$FA_Frais03FR_Denomination
    ,$FA_Frais03FR_Rem01REM_Valeur
    ,$FA_Frais03FR_Rem01REM_Type
    ,$FA_Frais03FR_Rem02REM_Valeur
    ,$FA_Frais03FR_Rem02REM_Type
    ,$FA_Frais03FR_Rem03REM_Valeur
    ,$FA_Frais03FR_Rem03REM_Type
    ,$FA_Contremarque
    ,$FA_FactPoids
    ,$FA_FactForfait
    ,$FA_Publie
    ,$FA_RacineRef
    ,$FA_RacineCB
    ,$CL_No1
    ,$CL_No2
    ,$CL_No3
    ,$CL_No4
    ,$cbMarq
    ,$cbCreateur
    ,$cbModification;
    public $table = 'F_Famille';
    public $lien ="ffamille";

    function __construct($id,$db=null)
    {
        parent::__construct($this->table, $id, 'FA_CodeFamille',$db);
        $this->db = new DB();
        if (sizeof($this->data) > 0) {
            $this->FA_CodeFamille = $this->data[0]->FA_CodeFamille;
            $this->FA_Type = $this->data[0]->FA_Type;
            $this->FA_Intitule = $this->data[0]->FA_Intitule;
            $this->FA_UniteVen = $this->data[0]->FA_UniteVen;
            $this->FA_Coef = $this->data[0]->FA_Coef;
            $this->FA_SuiviStock = $this->data[0]->FA_SuiviStock;
            $this->FA_Garantie = $this->data[0]->FA_Garantie;
            $this->FA_Central = $this->data[0]->FA_Central;
            $this->FA_Stat01 = $this->data[0]->FA_Stat01;
            $this->FA_Stat02 = $this->data[0]->FA_Stat02;
            $this->FA_Stat03 = $this->data[0]->FA_Stat03;
            $this->FA_Stat04 = $this->data[0]->FA_Stat04;
            $this->FA_Stat05 = $this->data[0]->FA_Stat05;
            $this->FA_CodeFiscal = $this->data[0]->FA_CodeFiscal;
            $this->FA_Pays = $this->data[0]->FA_Pays;
            $this->FA_UnitePoids = $this->data[0]->FA_UnitePoids;
            $this->FA_Escompte = $this->data[0]->FA_Escompte;
            $this->FA_Delai = $this->data[0]->FA_Delai;
            $this->FA_HorsStat = $this->data[0]->FA_HorsStat;
            $this->FA_VteDebit = $this->data[0]->FA_VteDebit;
            $this->FA_NotImp = $this->data[0]->FA_NotImp;
            $this->FA_Frais01FR_Denomination = $this->data[0]->FA_Frais01FR_Denomination;
            $this->FA_Frais01FR_Rem01REM_Valeur = $this->data[0]->FA_Frais01FR_Rem01REM_Valeur;
            $this->FA_Frais01FR_Rem01REM_Type = $this->data[0]->FA_Frais01FR_Rem01REM_Type;
            $this->FA_Frais01FR_Rem02REM_Valeur = $this->data[0]->FA_Frais01FR_Rem02REM_Valeur;
            $this->FA_Frais01FR_Rem02REM_Type = $this->data[0]->FA_Frais01FR_Rem02REM_Type;
            $this->FA_Frais01FR_Rem03REM_Valeur = $this->data[0]->FA_Frais01FR_Rem03REM_Valeur;
            $this->FA_Frais01FR_Rem03REM_Type = $this->data[0]->FA_Frais01FR_Rem03REM_Type;
            $this->FA_Frais02FR_Denomination = $this->data[0]->FA_Frais02FR_Denomination;
            $this->FA_Frais02FR_Rem01REM_Valeur = $this->data[0]->FA_Frais02FR_Rem01REM_Valeur;
            $this->FA_Frais02FR_Rem01REM_Type = $this->data[0]->FA_Frais02FR_Rem01REM_Type;
            $this->FA_Frais02FR_Rem02REM_Valeur = $this->data[0]->FA_Frais02FR_Rem02REM_Valeur;
            $this->FA_Frais02FR_Rem02REM_Type = $this->data[0]->FA_Frais02FR_Rem02REM_Type;
            $this->FA_Frais02FR_Rem03REM_Valeur = $this->data[0]->FA_Frais02FR_Rem03REM_Valeur;
            $this->FA_Frais02FR_Rem03REM_Type = $this->data[0]->FA_Frais02FR_Rem03REM_Type;
            $this->FA_Frais03FR_Denomination = $this->data[0]->FA_Frais03FR_Denomination;
            $this->FA_Frais03FR_Rem01REM_Valeur = $this->data[0]->FA_Frais03FR_Rem01REM_Valeur;
            $this->FA_Frais03FR_Rem01REM_Type = $this->data[0]->FA_Frais03FR_Rem01REM_Type;
            $this->FA_Frais03FR_Rem02REM_Valeur = $this->data[0]->FA_Frais03FR_Rem02REM_Valeur;
            $this->FA_Frais03FR_Rem02REM_Type = $this->data[0]->FA_Frais03FR_Rem02REM_Type;
            $this->FA_Frais03FR_Rem03REM_Valeur = $this->data[0]->FA_Frais03FR_Rem03REM_Valeur;
            $this->FA_Frais03FR_Rem03REM_Type = $this->data[0]->FA_Frais03FR_Rem03REM_Type;
            $this->FA_Contremarque = $this->data[0]->FA_Contremarque;
            $this->FA_FactPoids = $this->data[0]->FA_FactPoids;
            $this->FA_FactForfait = $this->data[0]->FA_FactForfait;
            $this->FA_Publie = $this->data[0]->FA_Publie;
            $this->FA_RacineRef = $this->data[0]->FA_RacineRef;
            $this->FA_RacineCB = $this->data[0]->FA_RacineCB;
            $this->CL_No1 = $this->data[0]->CL_No1;
            $this->CL_No2 = $this->data[0]->CL_No2;
            $this->CL_No3 = $this->data[0]->CL_No3;
            $this->CL_No4 = $this->data[0]->CL_No4;
            $this->cbMarq = $this->data[0]->cbMarq;
            $this->cbCreateur = $this->data[0]->cbCreateur;
            $this->cbModification = $this->data[0]->cbModification;
        }
    }

    public function maj_famille(){
        parent::maj(FA_CodeFamille , $this->FA_CodeFamille);
        parent::maj(FA_Type , $this->FA_Type);
        parent::maj(FA_Intitule , $this->FA_Intitule);
        parent::maj(FA_UniteVen , $this->FA_UniteVen);
        parent::maj(FA_Coef , $this->FA_Coef);
        parent::maj(FA_SuiviStock , $this->FA_SuiviStock);
        parent::maj(FA_Garantie , $this->FA_Garantie);
        parent::maj(FA_Central , $this->FA_Central);
        parent::maj(FA_Stat01 , $this->FA_Stat01);
        parent::maj(FA_Stat02 , $this->FA_Stat02);
        parent::maj(FA_Stat03 , $this->FA_Stat03);
        parent::maj(FA_Stat04 , $this->FA_Stat04);
        parent::maj(FA_Stat05 , $this->FA_Stat05);
        parent::maj(FA_CodeFiscal , $this->FA_CodeFiscal);
        parent::maj(FA_Pays , $this->FA_Pays);
        parent::maj(FA_UnitePoids , $this->FA_UnitePoids);
        parent::maj(FA_Escompte , $this->FA_Escompte);
        parent::maj(FA_Delai , $this->FA_Delai);
        parent::maj(FA_HorsStat , $this->FA_HorsStat);
        parent::maj(FA_VteDebit , $this->FA_VteDebit);
        parent::maj(FA_NotImp , $this->FA_NotImp);
        parent::maj(FA_Frais01FR_Denomination , $this->FA_Frais01FR_Denomination);
        parent::maj(FA_Frais01FR_Rem01REM_Valeur , $this->FA_Frais01FR_Rem01REM_Valeur);
        parent::maj(FA_Frais01FR_Rem01REM_Type , $this->FA_Frais01FR_Rem01REM_Type);
        parent::maj(FA_Frais01FR_Rem02REM_Valeur , $this->FA_Frais01FR_Rem02REM_Valeur);
        parent::maj(FA_Frais01FR_Rem02REM_Type , $this->FA_Frais01FR_Rem02REM_Type);
        parent::maj(FA_Frais01FR_Rem03REM_Valeur , $this->FA_Frais01FR_Rem03REM_Valeur);
        parent::maj(FA_Frais01FR_Rem03REM_Type , $this->FA_Frais01FR_Rem03REM_Type);
        parent::maj(FA_Frais02FR_Denomination , $this->FA_Frais02FR_Denomination);
        parent::maj(FA_Frais02FR_Rem01REM_Valeur , $this->FA_Frais02FR_Rem01REM_Valeur);
        parent::maj(FA_Frais02FR_Rem01REM_Type , $this->FA_Frais02FR_Rem01REM_Type);
        parent::maj(FA_Frais02FR_Rem02REM_Valeur , $this->FA_Frais02FR_Rem02REM_Valeur);
        parent::maj(FA_Frais02FR_Rem02REM_Type , $this->FA_Frais02FR_Rem02REM_Type);
        parent::maj(FA_Frais02FR_Rem03REM_Valeur , $this->FA_Frais02FR_Rem03REM_Valeur);
        parent::maj(FA_Frais02FR_Rem03REM_Type , $this->FA_Frais02FR_Rem03REM_Type);
        parent::maj(FA_Frais03FR_Denomination , $this->FA_Frais03FR_Denomination);
        parent::maj(FA_Frais03FR_Rem01REM_Valeur , $this->FA_Frais03FR_Rem01REM_Valeur);
        parent::maj(FA_Frais03FR_Rem01REM_Type , $this->FA_Frais03FR_Rem01REM_Type);
        parent::maj(FA_Frais03FR_Rem02REM_Valeur , $this->FA_Frais03FR_Rem02REM_Valeur);
        parent::maj(FA_Frais03FR_Rem02REM_Type , $this->FA_Frais03FR_Rem02REM_Type);
        parent::maj(FA_Frais03FR_Rem03REM_Valeur , $this->FA_Frais03FR_Rem03REM_Valeur);
        parent::maj(FA_Frais03FR_Rem03REM_Type , $this->FA_Frais03FR_Rem03REM_Type);
        parent::maj(FA_Contremarque , $this->FA_Contremarque);
        parent::maj(FA_FactPoids , $this->FA_FactPoids);
        parent::maj(FA_FactForfait , $this->FA_FactForfait);
        parent::maj(FA_Publie , $this->FA_Publie);
        parent::maj(FA_RacineRef , $this->FA_RacineRef);
        parent::maj(FA_RacineCB , $this->FA_RacineCB);
        parent::maj(CL_No1 , $this->CL_No1);
        parent::maj(CL_No2 , $this->CL_No2);
        parent::maj(CL_No3 , $this->CL_No3);
        parent::maj(CL_No4 , $this->CL_No4);
        parent::maj(cbMarq , $this->cbMarq);
        parent::maj(cbCreateur , $this->userName);
        parent::maj(cbModification , $this->cbModification);
    }

    public function getLibTaxePied($cattarif,$catcompta){
        $this->lien="ffamcompta";
        return $this->getApiJson("/getLibTaxePied&fcpType=$cattarif&fcpChamp=$catcompta");
    }

    public function getShortList() {
        $query = "SELECT cbModification,FA_CodeFamille,FA_Intitule,FA_Type
                  FROM F_FAMILLE  
                  ORDER BY FA_CodeFamille";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getFamilleCount()
    {
        $query ="    SELECT  count(*) Nb
                             ,max(cbModification)cbModification 
                     FROM    F_FAMILLE";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getNextArticleByFam($codeFam)
    {
        $query = "SELECT  F.FA_CodeFamille
                        ,CONCAT(F.FA_CodeFamille
                        ,RIGHT('000000000000'+CAST((CASE WHEN MAX(AR_Ref) IS NOT NULL THEN count(*) ELSE 0 END)+1 AS VARCHAR(100))
                        ,(SELECT GE_ArtLen FROM P_GENAUTO)-LEN(F.FA_CodeFamille))) AR_Ref 
                 FROM   F_FAMILLE F 
                 LEFT JOIN F_ARTICLE A 
                     ON F.FA_CodeFamille = A.FA_CodeFamille  
                 WHERE F.FA_CodeFamille='$codeFam'
                GROUP BY F.FA_CodeFamille";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function modifFamille($code, $intitule, $catal1, $catal2, $catal3, $catal4)
    {
        $requete = "UPDATE F_FAMILLE SET FA_Intitule='$intitule', CL_No1=$catal1,cbCL_No1=(SELECT CASE WHEN $catal1=0 THEN NULL ELSE $catal1 END),
                CL_No2=$catal2,cbCL_No2=(SELECT CASE WHEN $catal2=0 THEN NULL ELSE $catal2 END),cbModification=GETDATE(),
                CL_No3=$catal3,cbCL_No3=(SELECT CASE WHEN $catal3=0 THEN NULL ELSE $catal3 END),
                CL_No4=$catal4,cbCL_No4=(SELECT CASE WHEN $catal4=0 THEN NULL ELSE $catal4 END)
                WHERE FA_CodeFamille='$code'";
        $this->db->query($requete);
    }

    public function insertFamille($code, $intitule, $catal1, $catal2, $catal3, $catal4)
    {
        $requete = "INSERT INTO [dbo].[F_FAMILLE]
           ([FA_CodeFamille],[FA_Type],[FA_Intitule],[FA_UniteVen]
           ,[FA_Coef],[FA_SuiviStock],[FA_Garantie],[FA_Central]
           ,[FA_Stat01],[FA_Stat02],[FA_Stat03],[FA_Stat04]
           ,[FA_Stat05],[FA_CodeFiscal],[FA_Pays],[FA_UnitePoids]
           ,[FA_Escompte],[FA_Delai],[FA_HorsStat],[FA_VteDebit]
           ,[FA_NotImp],[FA_Frais01FR_Denomination],[FA_Frais01FR_Rem01REM_Valeur],[FA_Frais01FR_Rem01REM_Type]
           ,[FA_Frais01FR_Rem02REM_Valeur],[FA_Frais01FR_Rem02REM_Type],[FA_Frais01FR_Rem03REM_Valeur],[FA_Frais01FR_Rem03REM_Type]
           ,[FA_Frais02FR_Denomination],[FA_Frais02FR_Rem01REM_Valeur],[FA_Frais02FR_Rem01REM_Type],[FA_Frais02FR_Rem02REM_Valeur]
           ,[FA_Frais02FR_Rem02REM_Type],[FA_Frais02FR_Rem03REM_Valeur],[FA_Frais02FR_Rem03REM_Type],[FA_Frais03FR_Denomination]
           ,[FA_Frais03FR_Rem01REM_Valeur],[FA_Frais03FR_Rem01REM_Type],[FA_Frais03FR_Rem02REM_Valeur],[FA_Frais03FR_Rem02REM_Type]
           ,[FA_Frais03FR_Rem03REM_Valeur],[FA_Frais03FR_Rem03REM_Type],[FA_Contremarque],[FA_FactPoids]
           ,[FA_FactForfait],[FA_Publie],[FA_RacineRef],[FA_RacineCB]
           ,[CL_No1],[cbCL_No1],[CL_No2],[cbCL_No2],[CL_No3],[cbCL_No3],[CL_No4],[cbCL_No4]
           ,[cbProt],[cbCreateur],[cbModification],[cbReplication],[cbFlag])
     VALUES
           (/*FA_CodeFamille*/'$code',/*FA_Type*/0,/*FA_Intitule, */'$intitule',/*FA_UniteVen*/4
           ,/*FA_Coef*/0,/*FA_SuiviStock*/2,/*FA_Garantie*/0,/*FA_Central*/''
           ,/*FA_Stat01*/'',/*FA_Stat02*/'',/*FA_Stat03*/'',/*FA_Stat04*/''
           ,/*FA_Stat05*/'',/*FA_CodeFiscal*/'',/*FA_Pays, */'',/*FA_UnitePoids*/2
           ,/*FA_Escompte*/0,/*FA_Delai*/0,/*FA_HorsStat*/0,/*FA_VteDebit*/0
           ,/*FA_NotImp*/0,/*FA_Frais01FR_Denomination*/'Coût de stockage'
           ,/*FA_Frais01FR_Rem01REM_Valeur*/0,/*FA_Frais01FR_Rem01REM_Type*/0
           ,/*FA_Frais01FR_Rem02REM_Valeur*/0,/*FA_Frais01FR_Rem02REM_Type*/0
           ,/*FA_Frais01FR_Rem03REM_Valeur*/0,/*FA_Frais01FR_Rem03REM_Type*/0
           ,/*FA_Frais02FR_Denomination*/'Coût de transport',/*FA_Frais02FR_Rem01REM_Valeur*/0
           ,/*FA_Frais02FR_Rem01REM_Type*/0,/*FA_Frais02FR_Rem02REM_Valeur*/0
           ,/*FA_Frais02FR_Rem02REM_Type*/0,/*FA_Frais02FR_Rem03REM_Valeur*/0
           ,/*FA_Frais02FR_Rem03REM_Type*/0,/*FA_Frais03FR_Denomination*/0
           ,/*FA_Frais03FR_Rem01REM_Valeur*/0,/*FA_Frais03FR_Rem01REM_Type*/0
           ,/*FA_Frais03FR_Rem02REM_Valeur*/0,/*FA_Frais03FR_Rem02REM_Type*/0
           ,/*FA_Frais03FR_Rem03REM_Valeur*/0,/*FA_Frais03FR_Rem03REM_Type*/0
           ,/*FA_Contremarque*/0,/*FA_FactPoids*/0,/*FA_FactForfait*/0,/*FA_Publie*/0
           ,/*FA_RacineRef*/'$code',/*FA_RacineCB*/''
           ,/*CL_No1*/$catal1,/*cbCL_No1*/(SELECT CASE WHEN $catal1=0 THEN NULL ELSE $catal1 END),/*CL_No2*/$catal2,/*cbCL_No2*/(SELECT CASE WHEN $catal2=0 THEN NULL ELSE $catal2 END)
           ,/*CL_No3*/$catal3,/*cbCL_No3*/(SELECT CASE WHEN $catal3=0 THEN NULL ELSE $catal3 END),/*CL_No4*/$catal4,/*cbCL_No4*/(SELECT CASE WHEN $catal4=0 THEN NULL ELSE $catal4 END)
           ,/*cbProt*/0,/*cbCreateur, char(4)*/'AND',/*cbModification, smalldatetime*/CAST(GETDATE() AS DATE),/*cbReplication*/0,/*cbFlag*/0)
";
        $this->db->query($requete);

    }


    public function __toString() {
        return "";
    }

}