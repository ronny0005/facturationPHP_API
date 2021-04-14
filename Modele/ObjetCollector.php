<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ObjetCollector
 *
 * @author Test
 */
class ObjetCollector
{
    public $db;


    /**  Variable pour les données surchargées.  */
    public $list = Array();

    function __construct($db=null)
    {
        if($db!=null)
            $this->db=$db;
        else
            $this->db = new DB();
    }

    function getTarif()
    {
        return "SELECT CT_Intitule,cbIndice FROM P_CATTARIF where CT_Intitule <>''";
    }

    public function getTarifCount()
    {
        return "SELECT Count(*) Nb FROM P_CATTARIF where CT_Intitule <>''";
    }

    public function getTaxe()
    {
        return "SELECT TA_Code,TA_Intitule,CG_Num,TA_Taux,TA_TTaux,TA_No,CASE WHEN TA_TTaux=0 THEN cast(cast(TA_Taux as numeric(9,2)) as varchar(10))+'%' 
ELSE CASE WHEN TA_TTaux=1 THEN cast(cast(TA_Taux as numeric(9,2)) as varchar(10))+'F' ELSE cast(cast(TA_Taux as numeric(9,2)) as varchar(10)) END END FormatTaxe FROM " . $this->db->baseCompta . ".dbo.F_Taxe";
    }

    function getTaxeByTACode($ta_code)
    {
        return "SELECT *,CASE WHEN TA_TTaux=0 THEN cast(cast(TA_Taux as numeric(9,2)) as varchar(10))+'%' 
ELSE CASE WHEN TA_TTaux=1 THEN cast(cast(TA_Taux as numeric(9,2)) as varchar(10))+'F' ELSE cast(cast(TA_Taux as numeric(9,2)) as varchar(10)) END END FormatTaxe
                FROM " . $this->db->baseCompta . ".dbo.F_Taxe
                WHERE TA_Code='$ta_code'";
    }

    function getTaxeByTAIntitule($ta_intitule)
    {
        return "SELECT *,CASE WHEN TA_TTaux=0 THEN cast(cast(TA_Taux as numeric(9,2)) as varchar(10))+'%' 
ELSE CASE WHEN TA_TTaux=1 THEN cast(cast(TA_Taux as numeric(9,2)) as varchar(10))+'F' ELSE cast(cast(TA_Taux as numeric(9,2)) as varchar(10)) END END FormatTaxe
                FROM " . $this->db->baseCompta . ".dbo.F_Taxe
                WHERE TA_Intitule='$ta_intitule'";
    }

    public function getBanque()
    {
        return "SELECT 	* 
                FROM 	F_Banque";
    }

    function getBanqueByBQNo($bq_no)
    {
        return "SELECT  *    
                FROM    F_Banque
                WHERE   BQ_No=$bq_no";
    }

    public function typeArticle()
    {
        return "SELECT  MAX(CT_PrixTTC) CT_PrixTTC 
                FROM    P_CATTARIF";
    }
	
    public function getArticleWithStock($deno)
    {
        return "SELECT B.cbModification,A.AR_Ref,AR_Type,AR_Sommeil,AR_Design,AR_PrixTTC,FA_CodeFamille,ISNULL(AR_PrixAch,0)AR_PrixAch,ISNULL(AR_PrixVen,0)AR_PrixVen,ISNULL(Prix_Min,0)Prix_Min,ISNULL(Prix_Max,0)Prix_Max,ISNULL(AS_QteSto,0) AS_QteSto,ISNULL(AS_MontSto,0) AS_MontSto
                FROM F_ARTICLE A
                INNER JOIN (SELECT AR_Ref, AS_QteSto, AS_MontSto,cbModification FROM F_ARTSTOCK WHERE DE_No = $deno )B on A.AR_Ref = B.AR_Ref
                WHERE AS_QteSto IS NOT NULL AND AS_QteSto <>0";
    }

    public function getArticleWithStockMax($deno)
    {
        return "SELECT Max(B.cbModification)cbModification,COUNT(*) Nb
                FROM F_ARTICLE A
                INNER JOIN (SELECT AR_Ref, AS_QteSto, AS_MontSto,cbModification FROM F_ARTSTOCK WHERE DE_No = $deno )B on A.AR_Ref = B.AR_Ref
                WHERE AS_QteSto IS NOT NULL AND AS_QteSto <>0";
    }


    public function getArticleWithStockAndroid($deno)
    {
        return "SELECT AR_Condition,A.cbModification,A.AR_Ref,AR_Type,AR_Sommeil,AR_Design,AR_PrixTTC,FA_CodeFamille,ISNULL(AR_PrixAch,0)AR_PrixAch,ISNULL(AR_PrixVen,0)AR_PrixVen,ISNULL(Prix_Min,0)Prix_Min,ISNULL(Prix_Max,0)Prix_Max,ISNULL(AS_QteSto,0) AS_QteSto,ISNULL(AS_MontSto,0) AS_MontSto
                FROM F_ARTICLE A
                LEFT JOIN (SELECT AR_Ref, AS_QteSto, AS_MontSto FROM F_ARTSTOCK WHERE DE_No = $deno )B on A.AR_Ref = B.AR_Ref";
    }

    public function getArticleWithStockAndroidCount($deno)
    {
        return "SELECT max(A.cbModification) cbModification, count(*) Nb
                FROM F_ARTICLE A
                LEFT JOIN (SELECT AR_Ref, AS_QteSto, AS_MontSto 
                FROM F_ARTSTOCK WHERE DE_No = $deno )B on A.AR_Ref = B.AR_Ref";
    }

    public function getDate($date)
    {
        return "20" . substr($date, 4, 2) . "-" . substr($date, 2, 2) . "-" . substr($date, 0, 2);
    }

    public function getDateDDMMYYYY($date)
    {
        $date = new DateTime($date);
        return $date->format('d-m-Y');
    }

    public function getListeTypePlan()
    {
        return "SELECT * FROM P_ANALYTIQUE";
    }

    public function getListeTypePlanByVal($val)
    {
        return "SELECT  * 
                FROM    P_ANALYTIQUE 
                WHERE   ($val=0 OR cbIndice = $val)";
    }

    public function listeTypeReglement()
    {
        return " SELECT * 
                 FROM P_REGLEMENT P
                 WHERE R_Intitule<>''";
    }

    public function listeTypeReglementCount()
    {
        return " SELECT COUNT(*) Nb 
                 FROM P_REGLEMENT P
                 WHERE R_Intitule<>''";
    }


    public function asLetters($number)
    {
        $convert = explode('.', $number);
        $num[17] = array('zero', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit',
            'neuf', 'dix', 'onze', 'douze', 'treize', 'quatorze', 'quinze', 'seize');

        $num[100] = array(20 => 'vingt', 30 => 'trente', 40 => 'quarante', 50 => 'cinquante',
            60 => 'soixante', 70 => 'soixante-dix', 80 => 'quatre-vingt', 90 => 'quatre-vingt-dix');

        if (isset($convert[1]) && $convert[1] != '') {
            return $this->asLetters($convert[0]) . ' et ' . $this->asLetters($convert[1]);
        }
        if ($number < 0) return 'moins ' . $this->asLetters(-$number);
        if ($number < 17) {
            return $num[17][$number];
        } elseif ($number < 20) {
            return 'dix-' . $this->asLetters($number - 10);
        } elseif ($number < 100) {
            if ($number % 10 == 0) {
                return $num[100][$number];
            } elseif (substr($number, -1) == 1) {
                if (((int)($number / 10) * 10) < 70) {
                    return $this->asLetters((int)($number / 10) * 10) . '-et-un';
                } elseif ($number == 71) {
                    return 'soixante-et-onze';
                } elseif ($number == 81) {
                    return 'quatre-vingt-un';
                } elseif ($number == 91) {
                    return 'quatre-vingt-onze';
                }
            } elseif ($number < 70) {
                return $this->asLetters($number - $number % 10) . '-' . $this->asLetters($number % 10);
            } elseif ($number < 80) {
                return $this->asLetters(60) . '-' . $this->asLetters($number % 20);
            } else {
                return $this->asLetters(80) . '-' . $this->asLetters($number % 20);
            }
        } elseif ($number == 100) {
            return 'cent';
        } elseif ($number < 200) {
            return $this->asLetters(100) . ' ' . $this->asLetters($number % 100);
        } elseif ($number < 1000) {
            return $this->asLetters((int)($number / 100)) . ' ' . $this->asLetters(100) . ($number % 100 > 0 ? ' ' . $this->asLetters($number % 100) : '');
        } elseif ($number == 1000) {
            return 'mille';
        } elseif ($number < 2000) {
            return $this->asLetters(1000) . ' ' . $this->asLetters($number % 1000) . ' ';
        } elseif ($number < 1000000) {
            return $this->asLetters((int)($number / 1000)) . ' ' . $this->asLetters(1000) . ($number % 1000 > 0 ? ' ' . $this->asLetters($number % 1000) : '');
        } elseif ($number == 1000000) {
            return 'millions';
        } elseif ($number < 2000000) {
            return $this->asLetters(1000000) . ' ' . $this->asLetters($number % 1000000);
        } elseif ($number < 1000000000) {
            return $this->asLetters((int)($number / 1000000)) . ' ' . $this->asLetters(1000000) . ($number % 1000000 > 0 ? ' ' . $this->asLetters($number % 1000000) : '');
        }
    }

    public function crypteMdp($mdp)
    {
        $mdp = str_replace("1", "›", $mdp);
        $mdp = str_replace("2", "˜", $mdp);
        $mdp = str_replace("3", "™", $mdp);
        $mdp = str_replace("4", "ž", $mdp);
        $mdp = str_replace("5", "Ÿ", $mdp);
        $mdp = str_replace("6", "œ", $mdp);
        $mdp = str_replace("7", " ", $mdp);
        $mdp = str_replace("8", "’", $mdp);
        $mdp = str_replace("9", "“", $mdp);
        $mdp = str_replace("0", "š", $mdp);
        $mdp = str_replace("A", "ë", $mdp);
        $mdp = str_replace("B", "è", $mdp);
        $mdp = str_replace("C", "é", $mdp);
        $mdp = str_replace("D", "î", $mdp);
        $mdp = str_replace("E", "ï", $mdp);
        $mdp = str_replace("F", "ì", $mdp);
        $mdp = str_replace("G", "í", $mdp);
        $mdp = str_replace("H", "â", $mdp);
        $mdp = str_replace("I", "ã", $mdp);
        $mdp = str_replace("J", "à", $mdp);
        $mdp = str_replace("L", "æ", $mdp);
        $mdp = str_replace("M", "ç", $mdp);
        $mdp = str_replace("N", "ä", $mdp);
        $mdp = str_replace("O", "å", $mdp);
        $mdp = str_replace("P", "ú", $mdp);
        $mdp = str_replace("Q", "û", $mdp);
        $mdp = str_replace("R", "ø", $mdp);
        $mdp = str_replace("S", "ù", $mdp);
        $mdp = str_replace("T", "þ", $mdp);
        $mdp = str_replace("U", "ÿ", $mdp);
        $mdp = str_replace("V", "ü", $mdp);
        $mdp = str_replace("W", "ý", $mdp);
        $mdp = str_replace("X", "ò", $mdp);
        $mdp = str_replace("Y", "ó", $mdp);
        $mdp = str_replace("Z", "ð", $mdp);
        $mdp = str_replace("é", "C", $mdp);
        $mdp = str_replace("è", "B", $mdp);
        $mdp = str_replace("ç", "M", $mdp);
        $mdp = str_replace("à", "J", $mdp);
        $mdp = str_replace("ï", "E", $mdp);
        $mdp = str_replace("a", "Ë", $mdp);
        $mdp = str_replace("b", "È", $mdp);
        $mdp = str_replace("c", "É", $mdp);
        $mdp = str_replace("d", "Î", $mdp);
        $mdp = str_replace("e", "Ï", $mdp);
        $mdp = str_replace("f", "Ì", $mdp);
        $mdp = str_replace("g", "Í", $mdp);
        $mdp = str_replace("h", "Â", $mdp);
        $mdp = str_replace("i", "Ã", $mdp);
        $mdp = str_replace("j", "À", $mdp);
        $mdp = str_replace("l", "Æ", $mdp);
        $mdp = str_replace("m", "Ç", $mdp);
        $mdp = str_replace("n", "Ä", $mdp);
        $mdp = str_replace("o", "Å", $mdp);
        $mdp = str_replace("p", "Ú", $mdp);
        $mdp = str_replace("q", "Û", $mdp);
        $mdp = str_replace("r", "Ø", $mdp);
        $mdp = str_replace("s", "Ù", $mdp);
        $mdp = str_replace("t", "Þ", $mdp);
        $mdp = str_replace("u", "ß", $mdp);
        $mdp = str_replace("v", "Ü", $mdp);
        $mdp = str_replace("w", "Ý", $mdp);
        $mdp = str_replace("x", "Ò", $mdp);
        $mdp = str_replace("y", "Ó", $mdp);
        $mdp = str_replace("z", "Ð", $mdp);
        $mdp = str_replace("É", "c", $mdp);
        $mdp = str_replace("È", "b", $mdp);
        $mdp = str_replace("Ç", "m", $mdp);
        $mdp = str_replace("À", "j", $mdp);
        $mdp = str_replace("Ï", "e", $mdp);
        //sha1($mdp);
        //md5($mdp);
        return $mdp;
    }

    public function decrypteMdp($mdp)
    {
        $mdp = str_replace("›", "1", $mdp);
        $mdp = str_replace("˜", "2", $mdp);
        $mdp = str_replace("™", "3", $mdp);
        $mdp = str_replace("ž", "4", $mdp);
        $mdp = str_replace("Ÿ", "5", $mdp);
        $mdp = str_replace("œ", "6", $mdp);
        $mdp = str_replace(" ", "7", $mdp);
        $mdp = str_replace("’", "8", $mdp);
        $mdp = str_replace("“", "9", $mdp);
        $mdp = str_replace("š", "0", $mdp);
        $mdp = str_replace("ë", "A", $mdp);
        $mdp = str_replace("è", "B", $mdp);
        $mdp = str_replace("é", "C", $mdp);
        $mdp = str_replace("î", "D", $mdp);
        $mdp = str_replace("ï", "E", $mdp);
        $mdp = str_replace("ì", "F", $mdp);
        $mdp = str_replace("í", "G", $mdp);
        $mdp = str_replace("â", "H", $mdp);
        $mdp = str_replace("ã", "I", $mdp);
        $mdp = str_replace("à", "J", $mdp);
        $mdp = str_replace("æ", "L", $mdp);
        $mdp = str_replace("ç", "M", $mdp);
        $mdp = str_replace("ä", "N", $mdp);
        $mdp = str_replace("å", "O", $mdp);
        $mdp = str_replace("ú", "P", $mdp);
        $mdp = str_replace("û", "Q", $mdp);
        $mdp = str_replace("ø", "R", $mdp);
        $mdp = str_replace("ù", "S", $mdp);
        $mdp = str_replace("þ", "T", $mdp);
        $mdp = str_replace("ÿ", "U", $mdp);
        $mdp = str_replace("ü", "V", $mdp);
        $mdp = str_replace("ý", "W", $mdp);
        $mdp = str_replace("ò", "X", $mdp);
        $mdp = str_replace("ó", "Y", $mdp);
        $mdp = str_replace("ð", "Z", $mdp);
        $mdp = str_replace("C", "é", $mdp);
        $mdp = str_replace("B", "è", $mdp);
        $mdp = str_replace("M", "ç", $mdp);
        $mdp = str_replace("J", "à", $mdp);
        $mdp = str_replace("E", "ï", $mdp);
        $mdp = str_replace("Ë", "a", $mdp);
        $mdp = str_replace("È", "b", $mdp);
        $mdp = str_replace("É", "c", $mdp);
        $mdp = str_replace("Î", "d", $mdp);
        $mdp = str_replace("Ï", "e", $mdp);
        $mdp = str_replace("Ì", "f", $mdp);
        $mdp = str_replace("Í", "g", $mdp);
        $mdp = str_replace("Â", "h", $mdp);
        $mdp = str_replace("Ã", "i", $mdp);
        $mdp = str_replace("À", "j", $mdp);
        $mdp = str_replace("Æ", "l", $mdp);
        $mdp = str_replace("Ç", "m", $mdp);
        $mdp = str_replace("Ä", "n", $mdp);
        $mdp = str_replace("Å", "o", $mdp);
        $mdp = str_replace("Ú", "p", $mdp);
        $mdp = str_replace("Û", "q", $mdp);
        $mdp = str_replace("Ø", "r", $mdp);
        $mdp = str_replace("Ù", "s", $mdp);
        $mdp = str_replace("Þ", "t", $mdp);
        $mdp = str_replace("ß", "u", $mdp);
        $mdp = str_replace("Ü", "v", $mdp);
        $mdp = str_replace("Ý", "w", $mdp);
        $mdp = str_replace("Ò", "x", $mdp);
        $mdp = str_replace("Ó", "y", $mdp);
        $mdp = str_replace("Ð", "z", $mdp);
        $mdp = str_replace("c", "É", $mdp);
        $mdp = str_replace("b", "È", $mdp);
        $mdp = str_replace("m", "Ç", $mdp);
        $mdp = str_replace("j", "À", $mdp);
        $mdp = str_replace("e", "Ï", $mdp);
        //sha1($mdp);
        //md5($mdp);
        return $mdp;
    }

    public function depot()
    {
        return "select DE_No,DE_Intitule,DE_Ville,DE_CodePostal,cbModification,1 as IsPrincipal from F_DEPOT";
    }

    public function depotCount()
    {
        return "select count(*)Nb,max(cbModification)cbModification from F_DEPOT";
    }

    public function insertFCompteg($CG_Num, $CG_Type, $CG_Intitule, $CG_Classement, $N_Nature, $CG_Report, $CG_Regroup, $CG_Analytique, $CG_Echeance, $CG_Quantite, $CG_Lettrage, $CG_Tiers, $CG_Devise, $N_Devise, $TA_Code, $CG_Sommeil, $CG_Saut)
    {
        return "INSERT INTO " . $this->db->baseCompta . ".dbo.[F_COMPTEG]
           ([CG_Num],[CG_Type],[CG_Intitule],[CG_Classement]
           ,[N_Nature],[CG_Report],[CR_Num],[CG_Raccourci],[CG_Saut],[CG_Regroup],[CG_Analytique],[CG_Echeance]
           ,[CG_Quantite],[CG_Lettrage],[CG_Tiers],[CG_DateCreate],[CG_Devise],[N_Devise]
           ,[TA_Code],[CG_Sommeil],[cbProt],[cbCreateur]
           ,[cbModification],[cbReplication],[cbFlag])
     VALUES
           (/*CG_Num*/'$CG_Num',/*CG_Type*/$CG_Type,/*CG_Intitule*/'$CG_Intitule'
           ,/*CG_Classement*/'$CG_Classement',/*N_Nature*/$N_Nature,/*CG_Report*/$CG_Report
           ,/*CR_Num*/NULL,/*CG_Raccourci*/'',/*CG_Saut*/$CG_Saut
           ,/*CG_Regroup*/$CG_Regroup,/*CG_Analytique*/$CG_Analytique,/*CG_Echeance*/$CG_Echeance
           ,/*CG_Quantite*/$CG_Quantite,/*CG_Lettrage*/$CG_Lettrage,/*CG_Tiers*/$CG_Tiers
           ,/*CG_DateCreate*/CAST(GETDATE() AS DATE),/*CG_Devise*/$CG_Devise,/*N_Devise*/$N_Devise
           ,/*TA_Code, varchar(5),*/CASE WHEN '$TA_Code'='0' THEN NULL ELSE '$TA_Code' END,/*CG_Sommeil*/$CG_Sommeil
           ,/*cbProt*/0,/*cbCreateur*/'AND',/*cbModification*/CAST(GETDATE() AS DATE)
           ,/*cbReplication*/0,/*cbFlag*/0)";
    }

    public function modifFCompteg($CG_Num, $CG_Type, $CG_Intitule, $CG_Classement, $N_Nature, $CG_Report, $CG_Regroup, $CG_Analytique, $CG_Echeance, $CG_Quantite, $CG_Lettrage, $CG_Tiers, $CG_Devise, $N_Devise, $TA_Code, $CG_Sommeil, $CG_Saut)
    {

        return "UPDATE " . $this->db->baseCompta . ".dbo.[F_COMPTEG]
   SET [CG_Intitule] = '$CG_Intitule',cbModification=GETDATE()
      ,[CG_Classement] = '$CG_Classement',[N_Nature] = $N_Nature,[CG_Report] = $CG_Report
      ,[CG_Raccourci] = '',[CG_Saut] = $CG_Saut,[CG_Regroup] = $CG_Regroup
      ,[CG_Analytique] = $CG_Analytique,[CG_Echeance] = $CG_Echeance,[CG_Quantite] = $CG_Quantite,[CG_Lettrage] = $CG_Lettrage
      ,[CG_Tiers] = $CG_Tiers,[CG_Devise] = $CG_Devise,[N_Devise] = $N_Devise,[TA_Code] = (CASE WHEN '$TA_Code'='0' THEN NULL ELSE '$TA_Code' END)
      ,[CG_Sommeil] = $CG_Sommeil,[cbModification] = CAST(GETDATE() AS DATE)
       WHERE [CG_Num] = '$CG_Num'";
    }

    public function deleteAllTaCode($TA_No)
    {
        return "DELETE FROM " . $this->db->baseCompta . ".dbo.[F_ETAXE] WHERE TA_No=$TA_No";
    }

    public function modifTaxe($TA_Intitule, $TA_TTaux, $TA_Taux, $TA_Type, $CG_Num, $TA_NP, $TA_Sens, $TA_Provenance, $TA_Regroup, $TA_Assujet, $TA_GrilleBase, $TA_GrilleTaxe, $TA_Code)
    {
        return "UPDATE [F_TAXE]
            SET [TA_Intitule] = '$TA_Intitule',[TA_TTaux] = $TA_TTaux,cbModification=GETDATE()
               ,[TA_Taux] = $TA_Taux,[TA_Type] = $TA_Type
               ,[CG_Num] = '$CG_Num'
               ,[TA_NP] = $TA_NP
               ,[TA_Sens] = $TA_Sens,[TA_Provenance] = $TA_Provenance
               ,[TA_Regroup] = '$TA_Regroup',[TA_Assujet] = $TA_Assujet
               ,[TA_GrilleBase] = '$TA_GrilleBase',[TA_GrilleTaxe] = '$TA_GrilleTaxe'
               ,[cbModification] = CAST(GETDATE() AS DATE)
                   WHERE [TA_Code] = '$TA_Code'";
    }

    public function deleteTaxe($TA_No)
    {
        return "DELETE FROM [F_ETAXE] WHERE TA_No=$TA_No; DELETE FROM [F_TAXE] WHERE TA_No=$TA_No;";
    }

    public function deleteSaisieJournal($JO_Num, $mois, $annee, $JM_Date)
    {
        return "DELETE FROM F_ECRITUREC WHERE JO_Num='$JO_Num' AND MONTH(JM_Date) = $mois AND YEAR(JM_Date) = $annee;
            DELETE FROM F_JMOUV WHERE JO_Num='$JO_Num' AND MONTH(JM_Date) = $mois AND YEAR(JM_Date) = $annee;
            
INSERT INTO [F_JMOUV]
           ([JO_Num],[JM_Date],[JM_Cloture],[JM_Impression]
           ,[JM_DateCloture],[cbProt],[cbCreateur],[cbModification]
           ,[cbReplication],[cbFlag])
     VALUES
           (/*JO_Num*/'$JO_Num',/*JM_Date*/'$JM_Date',/*JM_Cloture*/0,/*JM_Impression*/0
           ,/*JM_DateCloture*/'1900-01-01',/*cbProt*/0,/*cbCreateur*/'AND',/*cbModification*/CAST(GETDATE() AS DATE)
           ,/*cbReplication*/0,/*cbFlag*/0)";
    }


    public function searchJMouv($JO_Num, $JM_Date)
    {
        return "SELECT * FROM [F_JMOUV] WHERE JO_Num='$JO_Num' AND JM_Date='$JM_Date'";
    }

    public function insertJMouv($JO_Num, $JM_Date)
    {
        return "INSERT INTO [F_JMOUV] 
           ([JO_Num],[JM_Date],[JM_Cloture],[JM_Impression]
           ,[JM_DateCloture],[cbProt],[cbCreateur],[cbModification]
           ,[cbReplication],[cbFlag])
     VALUES
           (/*JO_Num*/'$JO_Num',/*JM_Date*/'$JM_Date',/*JM_Cloture*/0,/*JM_Impression*/0
           ,/*JM_DateCloture*/'1900-01-01',/*cbProt*/0,/*cbCreateur*/'AND',/*cbModification*/CAST(GETDATE() AS DATE)
           ,/*cbReplication*/0,/*cbFlag*/0)";
    }

    public function deleteEcritureC($EC_No)
    {
        return "DELETE FROM " . $this->db->baseCompta . ".dbo.F_ECRITUREA WHERE EC_No='$EC_No';DELETE FROM " . $this->db->baseCompta . ".dbo.F_ECRITUREC WHERE EC_No='$EC_No';";
    }

    public function deleteZ_ECRITURECPIECE($EC_No)
    {
        return "DELETE FROM Z_ECRITURECPIECE WHERE EC_No='$EC_No';";
    }

    public function deleteCompteCompta($CG_Num)
    {
        return "DELETE FROM [F_COMPTETG] WHERE CG_Num='$CG_Num'";
    }

    public function deleteCompteAnal($CA_Num)
    {
        return "DELETE FROM [F_COMPTEA] WHERE CA_Num='$CA_Num'";
    }

    public function deleteJournal($JO_Num)
    {
        return "DELETE FROM " . $this->db->baseCompta . ".dbo.[F_JOURNAUX] WHERE JO_Num='$JO_Num'";
    }

    public function deleteModeRglt($MR_No)
    {
        return "DELETE FROM " . $this->db->baseCompta . ".dbo.[F_EMODELER] WHERE MR_No='$MR_No';DELETE FROM " . $this->db->baseCompta . ".dbo.[F_MODELER] WHERE MR_No='$MR_No'";
    }

    public function insertTaxe($TA_Intitule, $TA_TTaux, $TA_Taux, $TA_Type, $CG_Num, $TA_Code, $TA_NP, $TA_Sens, $TA_Provenance, $TA_Regroup, $TA_Assujet, $TA_GrilleBase, $TA_GrilleTaxe)
    {
        return "INSERT INTO " . $this->db->baseCompta . ".dbo.[F_TAXE]
           ([TA_Intitule],[TA_TTaux],[TA_Taux],[TA_Type]
           ,[CG_Num],[TA_No],[TA_Code],[TA_NP]
           ,[TA_Sens],[TA_Provenance],[TA_Regroup],[TA_Assujet]
           ,[TA_GrilleBase],[TA_GrilleTaxe],[cbProt],[cbCreateur]
           ,[cbModification],[cbReplication],[cbFlag])
     VALUES
           (/*TA_Intitule*/'$TA_Intitule',/*TA_TTaux*/$TA_TTaux,/*TA_Taux*/$TA_Taux,/*TA_Type*/$TA_Type
           ,/*CG_Num*/'$CG_Num',/*TA_No*/ISNULL((SELECT MAX(TA_No)TA_No FROM " . $this->db->baseCompta . ".dbo.F_TAXE),0)+1,/*TA_Code*/'$TA_Code',/*TA_NP*/$TA_NP
           ,/*TA_Sens*/$TA_Sens,/*TA_Provenance*/$TA_Provenance,/*TA_Regroup*/'$TA_Regroup',/*TA_Assujet*/$TA_Assujet
           ,/*TA_GrilleBase*/'$TA_GrilleBase',/*TA_GrilleTaxe*/'$TA_GrilleTaxe',/*cbProt*/0,/*cbCreateur*/'AND'
           ,/*cbModification*/CAST(GETDATE() AS DATE),/*cbReplication*/0,/*cbFlag*/0)";
    }

    public function insertETaxe($TA_No, $CG_Num)
    {
        return "INSERT INTO " . $this->db->baseCompta . ".dbo.[F_ETAXE]
           ([TA_No],[CG_Num],[cbProt],[cbCreateur]
           ,[cbModification],[cbReplication],[cbFlag])
     VALUES
           (/*TA_No*/$TA_No,/*CG_Num*/'$CG_Num',/*cbProt*/0,/*cbCreateur*/'AND'
           ,/*cbModification*/CAST(GETDATE() AS DATE),/*cbReplication*/0,/*cbFlag*/0)";
    }

    public function insertFComptea($N_Analytique, $CA_Num, $CA_Intitule, $CA_Type, $CA_Classement, $CA_Raccourci, $CA_Report, $N_Analyse, $CA_Saut, $CA_Sommeil, $CA_Domaine, $CA_Achat, $CA_Vente)
    {
        return "INSERT INTO " . $this->db->baseCompta . ".dbo.[F_COMPTEA]
           ([N_Analytique],[CA_Num],[CA_Intitule],[CA_Type]
           ,[CA_Classement],[CA_Raccourci],[CA_Report],[N_Analyse]
           ,[CA_Saut],[CA_Sommeil],[CA_DateCreate],[CA_Domaine]
           ,[CA_Achat],[CA_Vente],[cbProt],[cbCreateur]
           ,[cbModification],[cbReplication],[cbFlag])
     VALUES
           (/*N_Analytique*/$N_Analytique,/*CA_Num*/'$CA_Num',/*CA_Intitule*/'$CA_Intitule',/*CA_Type*/$CA_Type
           ,/*CA_Classement*/'$CA_Classement',/*CA_Raccourci*/'$CA_Raccourci',/*CA_Report*/$CA_Report,/*N_Analyse*/$N_Analyse
           ,/*CA_Saut*/$CA_Saut,/*CA_Sommeil*/$CA_Sommeil,/*CA_DateCreate*/CAST(GETDATE() AS DATE),/*CA_Domaine*/$CA_Domaine
           ,/*CA_Achat*/$CA_Achat,/*CA_Vente*/$CA_Vente,/*cbProt*/0,/*cbCreateur*/'AND'
           ,/*cbModification*/CAST(GETDATE() AS DATE),/*cbReplication*/0,/*cbFlag*/0)";
    }

    public function modifFComptea($N_Analytique, $CA_Num, $CA_Intitule, $CA_Type, $CA_Classement, $CA_Raccourci, $CA_Report, $N_Analyse, $CA_Saut, $CA_Sommeil, $CA_Domaine, $CA_Achat, $CA_Vente)
    {
        return "UPDATE [dbo].[F_COMPTEA]
   SET [CA_Intitule] = '$CA_Intitule',cbModification=GETDATE()
      ,[CA_Classement] = '$CA_Classement'
      ,[CA_Raccourci] = '$CA_Raccourci'
      ,[CA_Report] = $CA_Report
      ,[N_Analyse] = $N_Analyse
      ,[CA_Saut] = $CA_Saut
      ,[CA_Sommeil] = $CA_Sommeil
      ,[CA_Achat] = $CA_Achat
      ,[CA_Vente] = $CA_Vente
 WHERE [CA_Num] = '$CA_Num'";
    }

    public function getParametrecial()
    {
        return "select * from  P_PARAMETRECIAL";
    }
    public function getCANumPlanAffaire()
    {
        $query = "  SELECT  CA_Num
                    FROM    P_ANALYTIQUE
                    WHERE   CA_Num<>''";
        $result = $this->db->requete($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function depotByDE_No($de_no)
    {
        return "select * from F_DEPOT WHERE DE_No=" . $de_no;
    }

    public function getParametre($param)
    {
        return $this->getApiJson("/getParametre&protNo=$param");
    }

    public function caisse()
    {
        return "select JO_Num,CA_Intitule,CA_No,CO_NoCaissier,CA_Souche,CT_Num,cbModification from F_CAISSE";
    }


    public function caissier()
    {
        return "SELECT  *
                FROM  DBO.F_COLLABORATEUR
                WHERE CO_Caissier=1";
    }

    public function journal()
    {
        return "SELECT  *
                FROM  F_JOURNAUX";
    }

    public function updateDLColis($dl_nocolis, $cbMarq)
    {
        return "UPDATE F_DOCLIGNE SET DL_NoColis='$dl_nocolis',cbModification=GETDATE() WHERE cbMarq=$cbMarq";
    }

    public function getDepotByDE_No($de_no)
    {
        return "SELECT  D.*  
                        ,ISNULL(CA_No,0) CA_No
                        ,ISNULL(CA_SoucheVente,-1)CA_SoucheVente
                        ,ISNULL(CA_SoucheStock,-1)CA_SoucheStock
                        ,ISNULL(CA_SoucheAchat,-1)CA_SoucheAchat
                        ,CA_Num 
                FROM    F_DEPOT D 
                LEFT JOIN Z_DEPOTSOUCHE Z 
                    ON  Z.DE_No=D.DE_No 
                LEFT JOIN Z_DEPOTCAISSE C 
                    ON  C.DE_No=D.DE_No 
                WHERE   D.DE_No=$de_no";
    }

    public function getAllArticleDispoByArRef($de_no,$codeFamille=0)
    {
        return "SELECT AR_Type,AR_Sommeil,A.AR_Ref,AR_Design,AR_PrixAch,AR_PrixVen 
                FROM F_ARTICLE A 
                INNER JOIN F_ARTSTOCK S ON A.AR_Ref=S.AR_Ref  
                WHERE DE_No=$de_no AND S.AS_QteSto>0
                AND ('0'=$codeFamille OR FA_CodeFamille=$codeFamille)
                ORDER BY AR_Design";
    }

    public function getAllArticleDispoByArRefTrsftDetail($de_no, $ar_publie)
    {
        return "SELECT A.AR_Ref,AR_Design,AR_PrixAch,AR_PrixVen FROM F_ARTICLE A INNER JOIN F_ARTSTOCK S ON A.AR_Ref=S.AR_Ref AND S.AS_QteSto>0 AND DE_No=" . $de_no . " AND AR_Publie=$ar_publie ORDER BY AR_Design";
    }

    public function getAllArticle()
    {
        return "SELECT AR_Type,AR_Sommeil,A.AR_Ref,AR_Design,AR_PrixAch,AR_PrixVen FROM F_ARTICLE A ORDER BY AR_Ref";
    }

    public function getAllArticleTrsftDetail($ar_publie)
    {
        return "SELECT A.AR_Ref,AR_Design,AR_PrixAch,AR_PrixVen FROM F_ARTICLE A WHERE AR_Publie = $ar_publie ORDER BY AR_Ref";
    }

    public function getAllArticleByDesign($val)
    {
        return "SELECT A.AR_Ref,AR_Design,AR_PrixAch,AR_PrixVen FROM F_ARTICLE A WHERE AR_Design like '%$val%' ORDER BY AR_Design";
    }

    public function getInventairePrepa($P1, $P2, $P3, $P4, $P5, $P6)
    {
        return "SELECT funion.AR_Ref,DL_Design,funion.AG_No1,funion.AG_No2,LS_NoSerie, DL_Qte,DL_PrixRU,MontantSto,0 QteAjust,0 PRUAjust,
		0 ValeurAjust,Mini,Maxi,DP_Code,
		CASE WHEN LS_NoSerie='' THEN 0 ELSE CASE WHEN ISNULL(LS_QteRestant,0)=0 THEN 2 
				ELSE CASE WHEN LS_QteRestant<>DL_Qte THEN 1 ELSE 0 END END END Etat,
		LS_Fabrication,LS_Peremption,
		CASE WHEN ISNULL(DL_Qte,0)=0 THEN 1 ELSE 0 END StockZero,
		0 ValSaisieQte,0 ValSaisiePR,funion.FA_CodeFamille,LS_QteRestant,0 NewSerie,CL_Intitule,
		ISNULL(CT_FournPrinc,'') CT_Num,ROUND(DL_Qte/CASE WHEN $P1 = 1 THEN ISNULL(fcondi.EC_Quantite,1) ELSE 1 END,$P2) QteCol, 0 QteAjustCol,
		CASE WHEN $P3 = 1 THEN ISNULL(fcondi.EC_Quantite,1) ELSE 1 END EC_Quantite,
		CASE WHEN $P4 = 1 THEN ISNULL(fcondi.EC_Enumere,(select U_Intitule from P_UNITE where cbIndice = AR_UniteVen)) ELSE (select U_Intitule from P_UNITE where cbIndice = AR_UniteVen) END EC_Enumere,
		LS_Complement,funion.DL_NoIn,funion.cbMarq,DP_Zone,DP_No
FROM 
(SELECT 
		0 DL_NoIn,0 cbMarq,fArt.AR_Ref,fArt.AR_Design DL_Design,0 AG_No1,0 AG_No2,'' LS_NoSerie, AS_QteSto DL_Qte,
		CASE WHEN (AS_QteSto=0) THEN AS_MontSto ELSE AS_MontSto/AS_QteSto END DL_PrixRU,
			AS_MontSto MontantSto,AS_QteMini Mini,AS_QteMaxi Maxi,CASE WHEN AR_SuiviStock IN (1,5) THEN '' ELSE CASE WHEN ISNULL(fstock.DP_NoPrincipal,0) <> 0 THEN fdepEmp.DP_Code ELSE depot.DP_Code END END DP_Code,
		{d '1900-01-01'} LS_Fabrication,{d '1900-01-01'} LS_Peremption,fArt.FA_CodeFamille,0 LS_QteRestant,
		'' LS_Complement,CASE WHEN AR_SuiviStock IN (1,5) THEN 0 ELSE CASE WHEN (CASE WHEN ISNULL(fstock.DP_NoPrincipal,0) <> 0 THEN fdepEmp.DP_Zone ELSE depot.DP_Zone END = 0) THEN 4 ELSE CASE WHEN ISNULL(fstock.DP_NoPrincipal,0) <> 0 THEN fdepEmp.DP_Zone ELSE depot.DP_Zone END END END DP_Zone, CASE WHEN AR_SuiviStock IN (1,5) THEN 0 ELSE CASE WHEN ISNULL(fstock.DP_NoPrincipal,0) <> 0 THEN fdepEmp.DP_No ELSE depot.DP_No END END DP_No
		FROM	(SELECT DP_Code,DP_Zone,DP_No FROM F_DEPOT fDepot, F_DEPOTEMPL fDepEmpl WHERE fDepot.DE_No = $P5 AND fDepot.DP_NoDefaut = fDepEmpl.DP_No) depot, 
				F_ARTICLE fArt INNER JOIN F_ARTSTOCK fstock ON (fArt.cbAR_Ref = fstock.cbAR_Ref)
				LEFT OUTER JOIN F_DEPOTEMPL fdepEmp ON (fstock.DP_NoPrincipal = fdepEmp.DP_No) 
		WHERE	AR_Gamme1 = 0
		AND AR_SuiviStock>=2 AND AR_SuiviStock<=4
		AND fstock.DE_No=$P5
	UNION ALL
	SELECT 
		0 DL_NoIn,0 cbMarq,fArt.AR_Ref,fArt.AR_Design DL_Design,AG_No1,AG_No2,'' LS_NoSerie, GS_QteSto DL_Qte,
		CASE WHEN (GS_QteSto=0) THEN
			GS_MontSto
			ELSE
			GS_MontSto/GS_QteSto
			END DL_PrixRU,
		GS_MontSto MontantSto,CASE WHEN ISNULL(GS_QteMini,0)=0 AND ISNULL(GS_QteMaxi,0)=0 THEN AS_QteMini ELSE GS_QteMini END Mini,CASE WHEN ISNULL(GS_QteMini,0)=0 AND ISNULL(GS_QteMaxi,0)=0 THEN AS_QteMaxi ELSE GS_QteMaxi END Maxi,
		CASE WHEN ISNULL(fgamstock.DP_NoPrincipal,0) <> 0 THEN fDepempl.DP_Code ELSE CASE WHEN ISNULL(fstock.DP_NoPrincipal,0) <> 0 THEN fDepempl2.DP_Code ELSE  Depot.DP_Code END END DP_Code,{d '1900-01-01'} LS_Fabrication,{d '1900-01-01'} LS_Peremption,
		fArt.FA_CodeFamille,0 LS_QteRestant,'' LS_Complement,CASE WHEN (CASE WHEN ISNULL(fgamstock.DP_NoPrincipal,0) <> 0 THEN fDepempl.DP_Zone ELSE CASE WHEN ISNULL(fstock.DP_NoPrincipal,0) <> 0 THEN fDepempl2.DP_Zone ELSE  Depot.DP_Zone END END = 0 ) THEN 4 ELSE CASE WHEN ISNULL(fgamstock.DP_NoPrincipal,0) <> 0 THEN fDepempl.DP_Zone ELSE CASE WHEN ISNULL(fstock.DP_NoPrincipal,0) <> 0 THEN fDepempl2.DP_Zone ELSE  Depot.DP_Zone END END END DP_Zone,
		CASE WHEN ISNULL(fgamstock.DP_NoPrincipal,0) <> 0 THEN fDepempl.DP_No ELSE CASE WHEN ISNULL(fstock.DP_NoPrincipal,0) <> 0 THEN fDepempl2.DP_No ELSE  Depot.DP_No END END DP_No
	FROM	(SELECT DP_Code,DP_Zone,DP_No FROM F_DEPOT fDepot, F_DEPOTEMPL fDepempl  WHERE fDepot.DE_No = $P5 AND fDepot.DP_NoDefaut = fDepempl.DP_No) Depot, 
			F_ARTICLE fArt INNER JOIN F_ARTSTOCK fstock ON (fArt.cbAR_Ref = fstock.cbAR_Ref)
			INNER JOIN F_GAMSTOCK fgamstock ON (fgamstock.DE_No = fstock.DE_No AND fArt.cbAR_Ref = fgamstock.cbAR_Ref) 
			LEFT OUTER JOIN F_DEPOTEMPL fDepempl ON (fgamstock.DP_NoPrincipal = fDepempl.DP_No) 
			LEFT OUTER JOIN F_DEPOTEMPL fDepempl2 ON (fstock.DP_NoPrincipal = fDepempl2.DP_No) 
	WHERE AR_SuiviStock>=2 AND AR_SuiviStock<=4
	AND AR_Gamme1 >0
	AND fstock.DE_No=$P5
			UNION ALL
	SELECT
		fLot.DL_NoIn,fLot.cbMarq,fArt.AR_Ref,fArt.AR_Design DL_Design,0 AG_No1,0 AG_No2,LS_NoSerie,
		SUM( CASE WHEN DO_Type = 4 THEN LS_QteRestant ELSE CASE WHEN DL_TypePL>0 OR (DL_Qte<0 AND DO_Domaine<>2) THEN
					CASE WHEN DL_Qte>0 THEN -LS_QteRestant ELSE LS_QteRestant END
				ELSE CASE WHEN DL_Qte>0 THEN LS_QteRestant ELSE -LS_QteRestant END END
			END) DL_Qte,
		AVG(DL_PrixRU) DL_PrixRU,
		AVG(ROUND(DL_PrixRU * ABS(LS_QteRestant),$P6)) MontantSto,AS_QteMini Mini,AS_QteMaxi Maxi,
		CASE WHEN ISNULL(fstock.DP_NoPrincipal,0) <> 0 THEN fdepEmp.DP_Code ELSE depot.DP_Code END DP_Code,
		LS_Fabrication,LS_Peremption,fArt.FA_CodeFamille,SUM(LS_QteRestant),LS_Complement,
		CASE WHEN (CASE WHEN ISNULL(fstock.DP_NoPrincipal,0) <> 0 THEN fdepEmp.DP_Zone ELSE depot.DP_Zone END = 0) THEN 4 ELSE CASE WHEN ISNULL(fstock.DP_NoPrincipal,0) <> 0 THEN fdepEmp.DP_Zone ELSE depot.DP_Zone END END DP_Zone,
		CASE WHEN ISNULL(fstock.DP_NoPrincipal,0) <> 0 THEN fdepEmp.DP_No ELSE depot.DP_No END DP_No
		FROM	(SELECT DP_Code,DP_Zone,DP_No FROM F_DEPOT fDepot, F_DEPOTEMPL fDepEmpl WHERE fDepot.DE_No = $P5 AND fDepot.DP_NoDefaut = fDepEmpl.DP_No) depot,
				F_ARTICLE fArt INNER JOIN F_ARTSTOCK fstock ON (fArt.cbAR_Ref = fstock.cbAR_Ref)
				INNER JOIN F_LOTSERIE fLot ON (fArt.cbAR_Ref = fLot.cbAR_Ref AND fstock.DE_No = fLot.DE_No)
				INNER JOIN F_DOCLIGNE fLig ON (fLig.DL_No = fLot.DL_NoIn)
				LEFT OUTER JOIN F_DEPOTEMPL fdepEmp ON (fstock.DP_NoPrincipal = fdepEmp.DP_No) 
			WHERE fstock.DE_No=$P5
			AND	LS_MvtStock = 1
			AND LS_LotEpuise=0
			AND DL_MvtStock=1
		GROUP BY fLot.DL_NoIn,fLot.cbMarq,fArt.AR_Ref,fArt.AR_Design,LS_NoSerie,LS_Complement,fstock.AS_QteMini,fstock.AS_QteMaxi,
		CASE WHEN ISNULL(fstock.DP_NoPrincipal,0) <> 0 THEN fdepEmp.DP_Code ELSE depot.DP_Code END,
		fLot.LS_Fabrication,fLot.LS_Peremption,fArt.FA_CodeFamille,
		CASE WHEN (CASE WHEN ISNULL(fstock.DP_NoPrincipal,0) <> 0 THEN fdepEmp.DP_Zone ELSE depot.DP_Zone END = 0) THEN 4 ELSE CASE WHEN ISNULL(fstock.DP_NoPrincipal,0) <> 0 THEN fdepEmp.DP_Zone ELSE depot.DP_Zone END END,
		CASE WHEN ISNULL(fstock.DP_NoPrincipal,0) <> 0 THEN fdepEmp.DP_No ELSE depot.DP_No END
			UNION ALL
SELECT 	0 DL_NoIn,0 cbMarq,fArt.AR_Ref,fArt.AR_Design DL_Design,0 AG_No1,0 AG_No2,'' LS_NoSerie, 0 DL_Qte,
		0 DL_PrixRU,0 MontantSto,0 Mini,0 Maxi, Depot.DP_Code  DP_Code, 
		{d '1900-01-01'} LS_Fabrication,{d '1900-01-01'} LS_Peremption,
		fArt.FA_CodeFamille,0 LS_QteRestant,'' LS_Complement, CASE WHEN Depot.DP_Zone = 0 THEN 4 ELSE Depot.DP_Zone END  DP_Zone, CASE WHEN AR_SuiviStock <> 1 AND AR_SuiviStock <> 5 THEN Depot.DP_No ELSE 0 END DP_No
FROM	(SELECT DP_Code,DP_Zone,DP_No FROM F_DEPOT fdepot ,F_DEPOTEMPL fdepempl WHERE fdepot.DE_No = $P5 AND fdepot.DP_NoDefaut = fdepempl.DP_No) Depot,
		F_ARTICLE fArt 
WHERE   AR_Gamme1=0
	AND AR_SuiviStock>0
	AND NOT EXISTS (SELECT null 
	FROM F_ARTSTOCK fst
	WHERE	fst.cbAR_Ref= fArt.cbAR_Ref
		AND fst.DE_No=$P5)
UNION ALL
SELECT 	0 DL_NoIn,0 cbMarq,fArt.AR_Ref,fArt.AR_Design DL_Design, AG_No1,AG_No2,'' LS_NoSerie, 0 DL_Qte,
		0 DL_PrixRU,0 MontantSto,0 Mini,0 Maxi,'' DP_Code, 
		{d '1900-01-01'} LS_Fabrication,{d '1900-01-01'} LS_Peremption,
		fArt.FA_CodeFamille,0 LS_QteRestant,'' LS_Complement,CASE WHEN Depot.DP_Zone = 0 THEN 4 ELSE Depot.DP_Zone END DP_Zone,Depot.DP_No DP_No
FROM	(SELECT DP_Code,DP_Zone,DP_No FROM F_DEPOT fDepot, F_DEPOTEMPL fDepempl WHERE fDepot.DE_No = $P5 AND fDepot.DP_NoDefaut = fDepempl.DP_No) Depot,
		F_ARTICLE fArt INNER JOIN F_ARTENUMREF fEnumRef ON (fArt.cbAR_Ref = fEnumRef.cbAR_Ref) 
WHERE AR_Gamme1>0
	AND AR_SuiviStock>0
	AND NOT EXISTS (SELECT null 
	FROM F_GAMSTOCK fst
	WHERE	fst.cbAR_Ref= fArt.cbAR_Ref
		AND fst.DE_No=$P5
		AND fEnumRef.AG_No1 = fst.AG_No1 AND fEnumRef.AG_No2 = fst.AG_No2)
	UNION ALL
SELECT 0 DL_NoIn,0 cbMarq,fArt.AR_Ref,fArt.AR_Design DL_Design,0 AG_No1,0 AG_No2,'' LS_NoSerie,
0  DL_Qte,0 DL_PrixRU,0 MontantSto,AS_QteMini Mini,AS_QteMaxi Maxi,CASE WHEN ISNULL(fstock.DP_NoPrincipal,0) <> 0 THEN fDepEmpl.DP_Code ELSE depot.DP_Code END DP_Code,
		{d '1900-01-01'} LS_Fabrication,{d '1900-01-01'} LS_Peremption,fArt.FA_CodeFamille, 0 LS_QteRestant,
		'' LS_Complement,CASE WHEN (CASE WHEN ISNULL(fstock.DP_NoPrincipal,0) <> 0 THEN fDepEmpl.DP_Zone ELSE depot.DP_Zone END = 0) THEN 4 ELSE CASE WHEN ISNULL(fstock.DP_NoPrincipal,0) <> 0 THEN fDepEmpl.DP_Zone ELSE depot.DP_Zone END END DP_Zone,
		CASE WHEN ISNULL(fstock.DP_NoPrincipal,0) <> 0 THEN fDepEmpl.DP_No ELSE depot.DP_No END DP_No
FROM	(SELECT DP_Code,DP_Zone,DP_No FROM F_DEPOT fDepot, F_DEPOTEMPL fDepEmpl WHERE fDepot.DE_No = $P5 AND fDepot.DP_NoDefaut = fDepEmpl.DP_No) depot, 
		F_ARTICLE fArt INNER JOIN F_ARTSTOCK fstock ON (fArt.cbAR_Ref = fstock.cbAR_Ref) 
		LEFT OUTER JOIN F_DEPOTEMPL fDepEmpl ON (fstock.DP_NoPrincipal = fDepEmpl.DP_No) 
			WHERE fstock.DE_No=$P5
			AND (AR_SuiviStock =1 or AR_SuiviStock = 5)
			AND NOT EXISTS (select null FROM F_LOTSERIE WHERE cbAR_Ref=fArt.cbAR_Ref AND DE_No=$P5)
UNION ALL
SELECT DISTINCT 0 DL_NoIn,0 cbMarq,fArt.AR_Ref,fArt.AR_Design DL_Design,0 AG_No1,0 AG_No2,'' LS_NoSerie, 0 DL_Qte,
		0 DL_PrixRU,0 MontantSto,fstock.AS_QteMini,fstock.AS_QteMaxi,CASE WHEN ISNULL(fstock.DP_NoPrincipal,0) <> 0 THEN fDepEmpl.DP_Code ELSE depot.DP_Code END DP_Code,
		{d '1900-01-01'} LS_Fabrication,{d '1900-01-01'} LS_Peremption,
		fArt.FA_CodeFamille,0 LS_QteRestant,'' LS_Complement,CASE WHEN (CASE WHEN ISNULL(fstock.DP_NoPrincipal,0) <> 0 THEN fDepEmpl.DP_Zone ELSE depot.DP_Zone END = 0) THEN 4 ELSE CASE WHEN ISNULL(fstock.DP_NoPrincipal,0) <> 0 THEN fDepEmpl.DP_Zone ELSE depot.DP_Zone END END DP_Zone,
		CASE WHEN ISNULL(fstock.DP_NoPrincipal,0) <> 0 THEN fDepEmpl.DP_No ELSE depot.DP_No END DP_No
		FROM	(SELECT DP_Code,DP_Zone,DP_No FROM F_DEPOT fDepot, F_DEPOTEMPL fDepEmpl WHERE fDepot.DE_No = $P5 AND fDepot.DP_NoDefaut = fDepEmpl.DP_No) depot, 
				F_ARTICLE fArt INNER JOIN F_LOTSERIE fLot ON (fArt.cbAR_Ref=fLot.cbAR_Ref)
				INNER JOIN F_ARTSTOCK fstock ON (fArt.cbAR_Ref = fstock.cbAR_Ref)
				LEFT OUTER JOIN F_DEPOTEMPL fDepEmpl ON (fstock.DP_NoPrincipal = fDepEmpl.DP_No) 
	WHERE
				fLot.DE_No=$P5 AND
				fstock.DE_No=$P5
				AND (fArt.AR_SuiviStock=1 OR fArt.AR_SuiviStock=5)
				AND NOT EXISTS(SELECT NULL FROM F_LOTSERIE WHERE LS_LotEpuise=0 AND LS_MvtStock=1 AND fArt.cbAR_Ref=F_LOTSERIE.cbAR_Ref and fstock.DE_No=$P5)
)funion 
	INNER JOIN F_ARTICLE fArticle ON (funion.AR_Ref = fArticle.AR_Ref) 
	INNER JOIN F_FAMILLE fFam ON (fArticle.FA_CodeFamille = fFam.FA_CodeFamille) 
	LEFT OUTER JOIN F_CONDITION fcondi ON (fArticle.CO_No = fcondi.CO_No)
	LEFT OUTER JOIN (select AR_Ref, CT_Num CT_FournPrinc  FROM F_ARTFOURNISS where AF_Principal = 1) fArtFourn ON (fArticle.AR_Ref = fArtFourn.AR_Ref)
	LEFT OUTER JOIN F_CATALOGUE fCata ON (fArticle.CL_No1 = fCata.CL_No)
	where fFam.FA_Type=0"
            . " order by 1";
    }

    public function recoiMsgSite($nom,$msg){
        $query = "INSERT INTO JIRA.DBO.MsgSite(Nom,Msg,DtMsg) VALUES('$nom','$msg',GETDATE());";
        return $query;
    }
    public function SendMsgSite(){
        $query = "SELECT * FROM JIRA.DBO.MsgSite ORDER BY Idmsg desc;";
        return $query;
    }

    public function getEnteteTable($domaine, $souche, $type)
    {
        return "SELECT ISNULL((SELECT DC_Piece
                from F_DOCCURRENTPIECE D
                WHERE DC_Domaine=$domaine AND DC_Souche=$souche AND DC_IdCol=$type),0) as DC_Piece";
    }

    public function getEnteteDispo($domaine, $type, $do_piece)
    {
        $dopiece = $do_piece;
        $rowsTour = $do_piece;
        $result = $this->db->requete($this->getEnteteByDOPiece($dopiece, $domaine, $type));
        $rowsTour = $result->fetchAll(PDO::FETCH_OBJ);
        while ($rowsTour != null) {
            $dopiece = $this->incrementeDOPiece($dopiece);
            $result = $this->db->requete($this->getEnteteByDOPiece($dopiece, $domaine, $type));
            $rowsTour = $result->fetchAll(PDO::FETCH_OBJ);
        }
        if ($type == 30) {
            $result = $this->db->requete($this->getEnteteTicketByDOPiece($domaine, $type));
            $rowsTour = $result->fetchAll(PDO::FETCH_OBJ);
            $dopiece = $rowsTour[0]->DO_Piece + 1; // $this->incrementeDOPiece($rowsTour[0]->DO_Piece);
        }
        return $dopiece;
    }

    public function incrementeDOPiece($var)
    {
        preg_match_all('!\d+!', $var, $matches);
        $len = strlen($matches[0][0]);
        if (strlen($var) < 2)
            return $var + 1;
        else
            return substr($var, 0, strlen($var) - $len) . substr("00000" . ($matches[0][0] + 1), -$len);
    }


    public function incrementeCOLREGLEMENT()
    {
        $result = $this->db->requete("SELECT CR_Numero01 FROM P_COLREGLEMENT");
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if ($rows != null) {
            $result = $this->db->requete("UPDATE P_COLREGLEMENT SET CR_Numero01 = CR_Numero01+1");
        } else {
            $result = $this->initP_COLREGLEMENT();
        }
    }

    public function calculDateEcheance($nbjour, $jour, $dateech)
    {
        return "declare @date as date
                declare @date_ech as date
                declare @nbjour as int
                declare @datecivil as date
                declare @day as int 
                declare @val as int 
                set @val = $jour
                set @nbjour = $nbjour
                set @date_ech = '$dateech'
                set @date = (select dateadd(day,@nbjour,@date_ech))
                set @datecivil = (select dateadd(month,(@nbjour/30),@date_ech))
                set @day = CASE WHEN @val=0 THEN 1 ELSE @val END

                SELECT
                (SELECT CAST(CASE WHEN @val=0 THEN @date ELSE DATEADD(day,@day-1,CAST(YEAR(@date) AS VARCHAR(4))+'-'+RIGHT(CAST(MONTH(@date)+1 AS VARCHAR(2)),2)+'-01') END AS DATE)AS DATE) AS JourNet,
                (SELECT CASE WHEN @val = 0 THEN EOMONTH(DATEADD(day,@day,EOMONTH(@datecivil)))
                ELSE DATEADD(day,@day,EOMONTH(@datecivil)) END) FinMoisCivil, 
                (SELECT CASE WHEN @val = 0 THEN CAST(EOMONTH(@date) AS VARCHAR(10))
                ELSE DATEADD(day,@day,EOMONTH(@date)) END) FinMois";
    }

    public function compareVal($ttc, $avance)
    {
        return "SELECT CASE WHEN $ttc>=0 THEN CASE WHEN  $ttc>=$avance THEN 1 ELSE 0 END ELSE CASE WHEN  $ttc<=$avance THEN 1 ELSE 0 END END AS VAL";
    }

    public function modifDocligneFactureMagasin($DO_Piece, $AR_Ref, $DL_Qte, $cbMarq, $prix, $DO_Domaine, $DO_Type, $login, $type_fac,$carat=0)
    {
        $AR_PrixAch = "";
        $AR_Design = "";
        $AR_PrixVen = "";
        $montantHT = "";
        $AR_UniteVen = 0;
        $U_Intitule = "";
        $DO_Date = "";
        $result = $this->db->requete($this->getArticleByARRef($AR_Ref));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if ($rows != null) {
            $AR_PrixAch = $prix;//$rows[0]->AR_PrixAch;
            $AR_Design = str_replace("'", "''", $rows[0]->AR_Design);
            $AR_PrixVen = $rows[0]->AR_PrixVen;
            $AR_UniteVen = $rows[0]->AR_UniteVen;
            if ($AR_PrixVen == "") $AR_PrixVen = 0;
            if ($AR_PrixAch == "") $AR_PrixAch = 0;
            $montantHT = round(($AR_PrixAch) * $DL_Qte);
            $DL_PUTTC = $montantHT;
            if ($type_fac == "Transfert")
                $DL_PUTTC = round($AR_PrixAch);
            $result = $this->db->requete($this->getUnite($AR_UniteVen));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if ($rows != null) {
                $U_Intitule = $rows[0]->U_Intitule;
            }
            $result = $this->db->requete($this->getEnteteByDOPiece($DO_Piece, $DO_Domaine, $DO_Type));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if ($rows != null) {
                $DO_Date = $rows[0]->DO_DateC;
                $do_ref = $rows[0]->DO_Ref;
                $this->db->requete($this->majDocligneFacture($cbMarq, $DL_Qte, 0, $AR_PrixAch, 0, 0, 0, $AR_PrixAch, $U_Intitule, $DL_PUTTC, $montantHT, $montantHT, 0, 0, 0, 0, $login, 0, 0, 0, 0, 0, $type_fac, $AR_PrixAch));
                $result = $this->db->requete($this->getLigneFactureElementByCbMarq($cbMarq));
                $result->fetchAll(PDO::FETCH_OBJ);
                if($this->db->flagDataOr==1){
                    $this->carat = $carat;
                    $this->updateCaratTrsft($cbMarq);
                }
            }
        }
    }

    public function majDocligneFacture($cbMarq, $dl_qte, $remise, $prixUnitaire, $taxe1, $taxe2, $taxe3, $ar_prixach, $u_intitule, $pu_ttc, $montantht, $montantttc, $type_remise, $qte_pl, $qte_bl, $pu_devise, $login, $typeHT, $Typetaxe1, $Typetaxe2, $Typetaxe3, $DL_TypePL, $typefac, $DL_CMUP)
    {
        $rem = 0;
        $val = 0;
        if ($taxe3 != 0)
            $val = 2;
        if ($remise != 0)
            $rem = 1;
        $requete = "UPDATE F_DOCLIGNE SET DL_Qte=$dl_qte,DL_QteBC=$dl_qte,DL_QteBL= $qte_bl,EU_Qte=$dl_qte, 
                DL_QtePL=$qte_pl,DL_Remise01REM_Valeur=$remise,DL_PrixUnitaire=$prixUnitaire,cbModification=GETDATE(),
                ";
        if ($typefac == "Entree" || $typefac == "Sortie" || $typefac == "Transfert" || $typefac == "Achat" || $typefac == "AchatPreparationCommande")
            $requete = $requete . "DL_CMUP=$DL_CMUP,DL_PrixRU=$ar_prixach,";
        $requete = $requete . "DL_Remise01REM_Type=$type_remise,DL_Taxe3=$taxe3,DL_TypeTaux1=$Typetaxe1,DL_TypeTaux2=$Typetaxe2,DL_TypeTaux3=$Typetaxe3,DL_Taxe1=$taxe1,DL_Taxe2=$taxe2,
                DL_TTC=$typeHT,EU_Enumere='$u_intitule',DL_MontantHT=$montantht,DL_TypePL = $DL_TypePL,
                DL_MontantTTC=$montantttc,DL_PUDevise=$pu_devise,DL_PUTTC=$pu_ttc,USERGESCOM='$login',DATEMODIF=GETDATE() WHERE cbMarq=$cbMarq";
        return $requete;
    }

    public function modifiePrix($AR_Ref,$AR_Design,$pxAch,$pxVen,$prix,$pxMin,$DO_Piece,$user){
        $textMail="";
        $titreMail="";
        if($prix<$pxAch) {
            $textMail = "Le prix de l'article $AR_Ref - $AR_Design " . $this->formatChiffre($prix) . " lié à la facture $DO_Piece est inférieur au prix d'achat " . $this->formatChiffre($pxAch) . ".<br/>
                          Le document a été saisie par $user.<br/><br/>
                                                Cordialement.<br/><br/>";
            $titreMail="Prix de revient inférieur au prix d'achat";
        }
        if($prix<$pxVen) {
            $textMail = "Le prix de l'article $AR_Ref - $AR_Design " . $this->formatChiffre($prix) . " lié à la facture $DO_Piece est inférieur au prix de vente " . $this->formatChiffre($pxVen) . ".<br/>
                          Le document a été saisie par $user.<br/><br/>
                                                Cordialement.<br/><br/>";
            $titreMail="Prix de revient inférieur au prix de vente";
        }
        if($prix<$pxMin) {
            $textMail = "Le prix de l'article $AR_Ref - $AR_Design " . $this->formatChiffre($prix) . " lié à la facture $DO_Piece est inférieur au prix minimum " . $this->formatChiffre($pxMin) . ".<br/>
                          Le document a été saisie par $user.<br/><br/>
                                                Cordialement.<br/><br/>";
            $titreMail="Prix de revient inférieur au prix minimum";
        }

        if($textMail!=""){
            $result = $this->db->requete($this->getInfoRAFControleur());
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if ($rows != null) {
                foreach ($rows as $row) {
                    $email = $row->CO_EMail;
                    if (preg_match('#^[\w.-]+@[\w.-]+\.[a-z]{2,6}$#i', $email)) {
                        $this->envoiMailComplete($textMail, $titreMail, $email);
                    }
                }
            }
        }
    }

    public function commandeStock($DE_No,$AR_Ref,$AR_Design){
        $AS_QteMini= 0;
        $AS_QteMaxi= 0;
        $result = $this->db->requete($this->isStock($DE_No, $AR_Ref));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if ($rows != null) {
            $AS_QteSto = $rows[0]->AS_QteSto;
            $AS_QteMini = $rows[0]->AS_QteMini;
            $AS_QteMaxi = $rows[0]->AS_QteMaxi;
            $qteCommande = $AS_QteMaxi - $AS_QteSto;
            if($AS_QteMini!=0 && $AS_QteMaxi!=0){
                if($AS_QteSto<=$AS_QteMini){
                    $result = $this->db->requete($this->getInfoRAFControleur());
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    if ($rows != null) {
                        foreach ($rows as $row) {
                            $email = $row->CO_EMail;
                            if (preg_match('#^[\w.-]+@[\w.-]+\.[a-z]{2,6}$#i', $email)) {
                                //
                                $nom = $row->CO_Prenom . " " . $row->CO_Nom;
                                $corpsMail = "Le stock de l'article $AR_Ref - $AR_Design est en dessous de la limite (".$this->formatChiffre($AS_QteSto).")
                                                              La commande de ".$this->formatChiffre($qteCommande)." pièces doit être passé.<br/><br/>
                                                Cordialement.<br/><br/>";
                                $mail = new Mail();
                                $mail->sendMail($corpsMail."<br/><br/><br/> {$this->db->db}", $email,  "Stock de l'article $AR_Ref");
                            }
                        }
                    }
                }
            }
        }

    }

    public function equationStkVendeur($de_no, $datedeb, $datefin) {
        $requete = "
            DECLARE @dateDeb VARCHAR(20);
            DECLARE @dateFin VARCHAR(20);
            DECLARE @deNo INT;
            SET @dateDeb = '$datedeb';
            SET @dateFin = '$datefin';
            SET @deNo = $de_no;
            
            SELECT * FROM (SELECT AR_Design,AR_Ref,
                STOCKS,ENTREES,SORTIES, 
                (STOCKS+ENTREES)-(SORTIES) AS STOCK_FINAL, 
                VENTES AS QTE_VENDUES, 
                STOCKS+ENTREES-SORTIES-VENTES AS STOCK_RESTANTS 
                FROM( 
                SELECT  fArt.AR_Design,fArt.AR_Ref,
                                SUM(CASE WHEN FDOC.DO_Date BETWEEN @datedeb AND @datefin AND ((DO_Domaine=1 AND DO_Type=16) OR (DO_Domaine=2 AND DO_Type IN (20,21))) THEN FDOC.DL_Qte ELSE 0 END) ENTREES, 
                                SUM(CASE WHEN FDOC.DO_Date BETWEEN @datedeb AND @datefin AND FDOC.DO_Domaine = 2 AND FDOC.DO_Type IN (21,23) THEN FDOC.DL_Qte ELSE 0 END) SORTIES,  
                                SUM(CASE WHEN FDOC.DO_Date BETWEEN @datedeb AND @datefin AND LEFT(DO_Piece,2)<>'MT' AND FDOC.DL_MvtStock = 3 AND NOT(FDOC.DL_TypePL>0 OR FDOC.DL_Qte<0)  THEN FDOC.DL_Qte ELSE 0 END) VENTES, 
                                sum(CASE WHEN FDOC.DO_Date<@datedeb AND DL_MvtStock = 3 AND NOT(DL_TypePL>0 OR FDOC.DL_Qte<0) THEN -FDOC.DL_Qte ELSE 0 END) +sum(CASE WHEN FDOC.DO_Date<'$datedeb' AND DL_MvtStock = 1 AND NOT (DL_TypePL>0 OR (FDOC.DL_Qte<0 AND DO_Domaine<>2)) THEN FDOC.DL_Qte ELSE 0 END) STOCKS, 
                       sum(CASE WHEN FDOC.DO_Date<@datefin AND DL_MvtStock = 3 AND NOT(DL_TypePL>0 OR FDOC.DL_Qte<0) THEN -FDOC.DL_Qte ELSE 0 END) +sum(CASE WHEN FDOC.DO_Date<'$datefin' AND DL_MvtStock = 1 AND NOT (DL_TypePL>0 OR (FDOC.DL_Qte<0 AND DO_Domaine<>2)) THEN FDOC.DL_Qte ELSE 0 END) STOCK_RESTANTS 
                                 FROM F_DOCLIGNE FDoc 
                LEFT JOIN F_DEPOT FDepSource 
                    ON CASE WHEN isnumeric(FDOC.CT_Num)=1 THEN FDOC.CT_Num ELSE 0 END = FDepSource.DE_No 
                INNER JOIN F_DEPOT fdep 
                    ON fdep.DE_No=fDoc.DE_No 
                INNER JOIN F_ARTICLE fArt  
                    ON (fArt.cbAR_Ref = fDoc.cbAR_Ref)
                WHERE ISNULL(NULLIF(DO_Date,{d '1900-01-01'}),fDoc.DO_Date)<= @datefin  
                AND (@deNo = 0 OR FDEP.DE_No = @deNo) 
                GROUP BY fArt.AR_Design,fArt.AR_Ref
                ) A) A 
                WHERE A.SORTIES <> 0 OR A.ENTREES <> 0 OR A.STOCK_FINAL <> 0 OR A.QTE_VENDUES <> 0 
                 ORDER BY AR_Design";
        return $requete;
    }

    public function getPPreference() {
        $requete = "SELECT *
                    FROM P_PREFERENCES";
        return $requete;
    }

    public function formatChiffre($chiffre){
        return number_format($chiffre, 2, '.', ' ');
    }

    public function echeance_client($centre, $datedeb, $datefin,$clientdebut,$clientfin,$type_reg,$facCompta,$typeTiers) {
        $requete = "
                    SELECT *
                    FROM(
                    SELECT L.DO_Piece,L.CT_Num, CT_Intitule, CAST(L.DO_Date AS DATE)DO_Date, SUM(DL_MontantTTC) AS DL_MontantTTC , ISNULL(SUM(RC_Montant),0)  AS RC_Montant ,SUM(DL_MontantTTC) - ISNULL(SUM(RC_Montant),0)  AS Reste_A_Payer
                    FROM (  
                        SELECT A.DO_Domaine,A.DO_Type,A.DO_Piece,A.CT_Num,A.DE_No,A.DO_Date,DL_MontantTTC
                        FROM(SELECT DO_Domaine,DO_Type,DO_Piece,cbDO_Piece,DO_Date,DE_No,DO_Tiers AS CT_Num
                        FROM F_DOCENTETE
                        GROUP BY DO_Domaine,DO_Type,DO_Piece,cbDO_Piece,DO_Date,DE_No,DO_Tiers) A 
                        LEFT JOIN( SELECT DO_Domaine,DO_Type,cbDO_Piece,SUM(DL_MontantTTC) DL_MontantTTC
                                    FROM	F_DOCLIGNE L
                                    GROUP BY DO_Domaine,DO_Type,cbDO_Piece) B 
                        ON  A.DO_Domaine=B.DO_Domaine 
                        AND A.DO_Type=B.DO_Type 
                        AND A.cbDO_Piece=B.cbDO_Piece
                    ) L
                    INNER JOIN 	F_COMPTET C 
                        ON		L.CT_NUM = C.CT_Num 
                    LEFT JOIN F_DOCREGL D ON L.DO_Piece=D.DO_Piece AND L.DO_Domaine=D.DO_Domaine AND L.DO_Type=D.DO_Type  
                    LEFT JOIN (SELECT DO_Piece,DO_Domaine,DO_Type, SUM(RC_Montant) RC_Montant 
                                FROM F_REGLECH
                                GROUP BY DO_Piece,DO_Domaine,DO_Type) RE ON L.DO_Piece=RE.DO_Piece AND L.DO_Domaine=RE.DO_Domaine AND L.DO_Type=RE.DO_Type
                    INNER JOIN  F_DEPOT DE ON L.DE_No = DE.DE_No 
                    WHERE	(($typeTiers =0 AND L.DO_Domaine = 0) OR ($typeTiers =1 AND L.DO_Domaine = 1))
                    AND     (($facCompta=0 AND (   ($typeTiers =0 AND L.DO_Type in (6,7)) OR ($typeTiers =1 AND L.DO_Type in (16,17)) ) 
                                OR ($facCompta=1 AND ($typeTiers =0 AND L.DO_Type in (6)) OR ($typeTiers =1 AND L.DO_Type in (16)) ) 
                                OR ($facCompta=2 AND ($typeTiers =0 AND L.DO_Type in (7)) OR ($typeTiers =1 AND L.DO_Type in (17)) ))) 
                    AND		('' ='$datedeb' OR l.DO_Date >= '$datedeb')
                    AND         ('-1'= $type_reg OR ISNULL(DR_Regle,0) = '$type_reg')
                    AND         ('' ='$datefin' OR l.DO_Date<= '$datefin')
                    AND         ('0'='$clientdebut' OR L.CT_NUM>='$clientdebut') 
                    AND ('0'='$clientfin' OR L.CT_NUM<='$clientfin')
                    AND		($centre= 0 OR L.DE_No = $centre) 
                    GROUP BY L.DO_Piece,L.CT_Num,CT_Intitule, L.DO_Date)A
                     WHERE  ('0'<> $type_reg OR (0 = '$type_reg' AND Reste_A_Payer<>0))
                ORDER BY DO_DATE DESC";
        return $requete;
    }

    public function releveCompteClient($centre, $datedeb, $datefin,$depot) {
        $requete = "declare @dt_deb as varchar(10)
                    declare @dt_fin as varchar(10)
                    declare @ct_num as varchar(30)
                    declare @depot as int
                    set @dt_deb='$datedeb'
                    set @dt_fin='$datefin'
                    set @ct_num='$centre';
                    set @depot=$depot;

                    with cte (ligne,DO_DATE,DR_DATE,RETARD,DO_PIECE,DO_REF,NET_VERSER,REGLEMENT,cumul) 
                    as(
                    SELECT ROW_NUMBER() OVER(order by DO_DATE) AS ligne,DO_DATE,DR_DATE,RETARD,DO_PIECE,DO_REF,NET_VERSER,REGLEMENT,cumul
                    FROM(select '1960-01-01' AS DO_DATE,'1960-01-01' AS DR_DATE, 0 AS RETARD,'' AS DO_PIECE,'' AS DO_REF,0 AS NET_VERSER,0 AS REGLEMENT,ISNULL(MAX(RG_Montant),0) - ISNULL(SUM(RC_MONTANT),0) as cumul
                    from F_CREGLEMENT C
                    LEFT JOIN F_REGLECH r ON C.RG_No = R.RG_No
                    WHERE C.RG_Date <@dt_deb
                    AND CT_NumPayeur=@ct_num
                    UNION
                    SELECT D.DO_Date, R.DR_Date,DATEDIFF(DAY,GETDATE(),R.DR_Date) as RETARD, D.DO_Piece,D.DO_Ref , SUM(L.DL_MontantTTC) AS  NET_VERSER,SUM(C.RC_Montant) AS REGLEMENT, SUM(L.DL_MontantTTC)-ISNULL(SUM(C.RC_Montant),0) AS CUMUL 
                    FROM F_DOCENTETE D
                    INNER JOIN F_DOCREGL R ON R.DO_Piece = D.DO_Piece
                    INNER JOIN (SELECT DO_Piece,SUM(DL_MontantTTC) AS DL_MontantTTC FROM F_DOCLIGNE GROUP BY DO_Piece) L ON L.DO_Piece = D.DO_Piece
                    LEFT JOIN F_REGLECH C ON C.DO_Piece = D.DO_Piece
                    WHERE D.DO_Date BETWEEN @dt_deb and @dt_fin
                    AND DO_Tiers=@ct_num
                    AND (0=@depot OR D.DE_No=@depot)
                    GROUP BY D.DO_Piece,D.DO_Date, R.DR_Date,DATEDIFF(DAY,GETDATE(),R.DR_Date),D.DO_Ref) A
                    )

                    SELECT T1.ligne,CAST(T1.DO_DATE AS DATE)DO_DATE,CAST(T1.DR_DATE AS DATE)DR_DATE,T1.RETARD,T1.DO_PIECE,T1.DO_REF,T1.NET_VERSER,T1.REGLEMENT,CASE WHEN SUM(T2.cumul) BETWEEN -5 AND 5 THEN 0 ELSE SUM(T2.cumul) END as cumul
                    FROM CTE T1
                    INNER JOIN CTE T2 ON T1.ligne>=T2.ligne
                    GROUP BY T1.ligne,T1.DO_DATE,T1.DR_DATE,T1.RETARD,T1.DO_PIECE,T1.DO_REF,T1.NET_VERSER,T1.REGLEMENT
                    ORDER BY T1.ligne";
        return $requete;

    }

    public function livretInventaireDate($datedeb,$articledeb,$articlefin,$depot){
        return "exec sp_executesql N';
	SELECT 
    Article.DE_No,
	fDep.DE_Intitule,
	Article.IntituleTri,
	Article.IntituleTri2,
	fArt.AR_Ref,
	fArt.AR_Design,
	fArt.AR_SuiviStock,
	Article.AG_No1,
	Article.AG_No2,
	Article.Enumere1,
	Article.Enumere2,
	Article.AE_Ref,
	Article.LS_NoSerie,
	Article.LS_Peremption,
	Article.LS_Fabrication,
	Article.Qte,
	Article.CMUP,
	Article.PR,
	CASE WHEN @P1 = 0 THEN 1 ELSE ISNULL(fCondi.EC_Quantite,1)END EC_Quantite
FROM
	(
	SELECT
	 sousReqSelLigne.DE_No,
	
	 '''' IntituleTri,
	
	
	
	
	
	 '''' IntituleTri2,
		sousReqSelLigne.cbAR_Ref,
		sousReqSelLigne.AG_No1,
		sousReqSelLigne.AG_No2,
	fgam1.EG_Enumere Enumere1,
		fgam2.EG_Enumere Enumere2,
		fArtEnumRef.AE_Ref AE_Ref,


	NULL LS_NoSerie,
		NULL LS_Peremption,
		NULL LS_Fabrication,
		SUM(Qte) Qte,
		SUM(CMUP*Sens) CMUP,
		SUM(PR*Sens) PR
		FROM
	 
	
	(SELECT 
				fDoc.DE_No,
				fDoc.cbAR_Ref,
	
	
	
	
		fDoc.AG_No1,
				fDoc.AG_No2,
	
				NULL LS_NoSerie,
				NULL LS_Peremption,
				NULL LS_Fabrication,
 ( CASE WHEN DL_MvtStock = 3 THEN
						CASE WHEN DO_Type = 14 THEN
							-fDoc.DL_Qte
						ELSE
							CASE WHEN DL_TypePL>0 OR fDoc.DL_Qte<0 THEN
								fDoc.DL_Qte
							ELSE
								-fDoc.DL_Qte
							END
						END
					ELSE
						CASE WHEN DL_MvtStock = 1 THEN
							CASE WHEN DO_Type = 27 OR DO_Type = 4 THEN
								fDoc.DL_Qte
							ELSE
								CASE WHEN DL_TypePL>0 OR (fDoc.DL_Qte<0 AND DO_Domaine<>2) THEN
									-fDoc.DL_Qte
								ELSE
									fDoc.DL_Qte
								END
							END
						ELSE
							0
						END
					END) Qte,
					(CASE WHEN DL_MvtStock = 3 OR DL_MvtStock = 1 THEN
						ROUND(DL_CMUP * ABS(fDoc.DL_Qte),@P2)
					ELSE
						DL_CMUP
					END) CMUP,

 
					( CASE WHEN (DL_MvtStock = 4 OR DL_MvtStock = 2) AND AR_SuiviStock<>2 THEN
						0
					ELSE
						CASE WHEN DL_MvtStock = 3 OR DL_MvtStock = 1 THEN
							ROUND(DL_PrixRU * ABS(fDoc.DL_Qte),@P3)
						ELSE
							DL_PrixRU
						END
					END)



					PR,

				(CASE WHEN DL_MvtStock = 3 THEN
						-1
					ELSE
						CASE WHEN DL_MvtStock = 1 THEN
							CASE WHEN DO_Type=27 AND fDoc.DL_Qte<0 THEN
								-1
							ELSE
								1
							END
						ELSE
							CASE WHEN DL_MvtStock = 4 THEN
							CASE WHEN DO_Domaine = 1 AND (DL_TypePL = 2 OR DL_TypePL=3) THEN
									1
								ELSE
									-1
								END
							ELSE
								1
							END
						END
					END) Sens
			FROM	F_DOCLIGNE fDoc INNER JOIN F_ARTICLE fArt ON (fArt.cbAR_Ref = fDoc.cbAR_Ref)


			
			WHERE
					fDoc.DL_MvtStock > 0
					AND	(fDoc.DO_Type<5 OR fDoc.DO_Type>5)
					AND CAST(ISNULL(NULLIF(DL_DateBL,{d ''1900-01-01''}),DO_Date)AS DATE) <= @P4
					
					
							AND (@P7=''0'' OR fDoc.DE_No = @P7)					
							AND (@P5=''0'' OR fArt.cbAR_Ref >= convert(varbinary(255),@P5))
							AND (@P5=''0'' OR fArt.cbAR_Ref <= convert(varbinary(255),@P6))
					

)
sousReqSelLigne		
					 LEFT OUTER JOIN F_ARTGAMME fgam1 ON (sousReqSelLigne.AG_No1=fgam1.AG_No AND fgam1.AG_Type = 0)
					LEFT OUTER JOIN F_ARTGAMME fgam2 ON (sousReqSelLigne.AG_No2 = fgam2.AG_No AND fgam2.AG_Type = 1)
					LEFT OUTER JOIN F_ARTENUMREF fArtEnumRef ON (sousReqSelLigne.AG_No1 = fArtEnumRef.AG_No1 AND sousReqSelLigne.AG_No2 = fArtEnumRef.AG_No2 AND sousReqSelLigne.cbAR_Ref = fArtEnumRef.cbAR_Ref)
					
					
	GROUP BY
	 sousReqSelLigne.DE_No,
	
	
	
	
	
		sousReqSelLigne.cbAR_Ref,
		sousReqSelLigne.AG_No1,
		sousReqSelLigne.AG_No2
	,fgam1.EG_Enumere,
		fgam2.EG_Enumere,
		fArtEnumRef.AE_Ref

		HAVING SUM(Qte)>0)	Article INNER JOIN F_ARTICLE fArt ON (Article.cbAR_Ref = fArt.cbAR_Ref) AND fArt.AR_SuiviStock>0
								INNER JOIN F_DEPOT fDep ON (Article.DE_No = fDep.DE_No)
							LEFT OUTER JOIN F_CONDITION fCondi ON (fArt.CO_No = fCondi.CO_No)
	ORDER BY
	Article.DE_No,   ISNULL(Article.IntituleTri,'' ''),Article.IntituleTri2, Article.cbAR_Ref,Article.AG_No1,Article.AG_No2,ISNULL(Article.LS_NoSerie,'''')
	',N'@P1 smallint,@P2 float,@P3 float,@P4 DATE,@P5 varchar(256),@P6 varchar(256),@P7 int',0,0,0,'$datedeb','$articledeb','$articlefin','$depot'";
    }

    public function livretInventaireCumulStock($string,$depot,$articledebut,$articlefin){


        $order ="ORDER BY $string";
        if($string==" fArt.AR_Ref,fArt.AR_Design ")
            $order ="ORDER BY fArt.AR_Ref";
        return"DECLARE @MAXREPL int;
	SET @MAXREPL =  (select ISNULL(MAX(DE_Replication),0) from F_DEPOT);
SELECT $string
,SUM(ReqGlobal.PR)PR,SUM(ReqGlobal.Qte)Qte
FROM
(SELECT
	DE_No,
	IntituleTri,
	IntituleTri2,
	cbAR_Ref,
	AG_No1,
	AG_No2,
	Enumere1,
	Enumere2,
	AE_Ref,
	LS_NoSerie,
	LS_Peremption,
	LS_Fabrication,
	SUM(PR) PR,
	SUM(Qte) Qte
FROM
((
SELECT
	fDepot.DE_No DE_No,
	fArt.cbAR_Ref cbAR_Ref,
	0	AG_No1,
	0	AG_No2,
	''	Enumere1,
	''	Enumere2,
	''	AE_Ref,
	''	LS_NoSerie,
	NULL	LS_Peremption,
	NULL	LS_Fabrication,
		AS_MontSto PR,
	AS_QteSto	Qte
,''	IntituleTri
 ,'' IntituleTri2
FROM
		F_ARTICLE fArt INNER JOIN F_ARTSTOCK fSto ON (fArt.cbAR_Ref = fSto.cbAR_Ref)
		INNER JOIN F_DEPOT fDepot ON (fDepot.DE_No = fSto.DE_No)
WHERE	fSto.AS_QteSto>0
		
		AND (0='$depot' OR fDepot.DE_No='$depot')
		
		 AND AR_SuiviStock>=2 AND AR_SuiviStock<=4
		 AND AR_Gamme1=0
 UNION
	SELECT DE_No,ReqGamme.cbAR_Ref cbAR_Ref,ReqGamme.AG_No1 AG_No1,ReqGamme.AG_No2 AG_No2,Enumere1,
	Enumere2,fArtEnumRef.AE_Ref AE_Ref,LS_NoSerie,LS_Peremption,LS_Fabrication,PR,Qte,IntituleTri,IntituleTri2
	FROM 
	(SELECT
		fDepot.DE_No DE_No,
		fArt.cbAR_Ref cbAR_Ref,fGam.AG_No AG_No1,0 AG_No2,fGam.EG_Enumere Enumere1,'' Enumere2,
		'' LS_NoSerie,NULL LS_Peremption,NULL LS_Fabrication,
		GS_MontSto  PR,
			GS_QteSto Qte 
		,'' IntituleTri
		 ,'' IntituleTri2
	FROM
		F_ARTICLE fArt INNER JOIN F_ARTGAMME fGam ON (fArt.cbAR_Ref = fGam.cbAR_Ref)
		INNER JOIN F_GAMSTOCK fGamSto ON (fGam.AG_No = fGamSto.AG_No1)
		INNER JOIN F_DEPOT fDepot ON (fDepot.DE_No = fGamSto.DE_No)
	WHERE fArt.cbAR_Ref = fGamSto.cbAR_Ref
		AND AG_Type=0 
		AND (0='$depot' OR fDepot.DE_No='$depot')
		AND AR_SuiviStock>0 AND AR_Gamme1>0 AND AR_Gamme2=0 AND fGamSto.GS_QteSto>0
UNION
	SELECT
		fDepot.DE_No DE_No,
		fArt.cbAR_Ref cbAR_Ref,
		fGam1.AG_No AG_No1,
		fGam2.AG_No AG_No2,
		fGam1.EG_Enumere Enumere1,
		fGam2.EG_Enumere Enumere2,
		'' LS_NoSerie,
		NULL LS_Peremption,
		NULL LS_Fabrication,
		GS_MontSto  PR,
		GS_QteSto Qte 
	,'' IntituleTri
	 ,'' IntituleTri2
	FROM
			F_ARTICLE fArt
			INNER JOIN F_GAMSTOCK fGamSto ON (fArt.cbAR_Ref = fGamSto.cbAR_Ref)
			INNER JOIN F_DEPOT fDepot ON (fDepot.DE_No = fGamSto.DE_No)
			INNER JOIN F_ARTGAMME fGam1 ON (fArt.cbAR_Ref = fGam1.cbAR_Ref AND fGam1.AG_No = fGamSto.AG_No1)
			INNER JOIN F_ARTGAMME fGam2 ON (fArt.cbAR_Ref = fGam2.cbAR_Ref AND fGam2.AG_No = fGamSto.AG_No2)
	WHERE
		fGam1.AG_Type=0 AND fGam2.AG_Type=1
		AND	AR_SuiviStock>0 
		AND (0='$depot' OR fDepot.DE_No='$depot')
		AND AR_Gamme2>0
		AND fGamSto.GS_QteSto>0
	) ReqGamme INNER JOIN F_ARTENUMREF fArtEnumRef ON (fArtEnumRef.cbAR_Ref = ReqGamme.cbAR_Ref AND fArtEnumRef.AG_No1 = ReqGamme.AG_No1 AND fArtEnumRef.AG_No2 = ReqGamme.AG_No2)
)
 UNION all
	SELECT
		fDepot.DE_No DE_No,
		fArt.cbAR_Ref cbAR_Ref,
		0 AG_No1,
		0 AG_No2,
		'' Enumere1,
		'' Enumere2,
		'' AE_Ref,
		LS_NoSerie LS_NoSerie,
		LS_Peremption LS_Peremption,
		LS_Fabrication LS_Fabrication,
		(ROUND(
		DL_PrixRU * ABS(LS_QteRestant)
		,0)) PR,
		( CASE WHEN DO_Type = 4 THEN
				LS_QteRestant
			ELSE
				CASE WHEN DL_TypePL>0 OR (fLig.DL_Qte<0 AND DO_Domaine<>2) THEN
					CASE WHEN fLig.DL_Qte>0 THEN
						-LS_QteRestant
					ELSE
						LS_QteRestant
					END
				ELSE
					CASE WHEN fLig.DL_Qte>0 THEN
						LS_QteRestant
					ELSE
						-LS_QteRestant
					END
				END
			END) Qte
	,'' IntituleTri
	,'' IntituleTri2
	FROM
		F_ARTICLE fArt INNER JOIN F_LOTSERIE fLot ON (fArt.cbAR_Ref = fLot.cbAR_Ref)
		INNER JOIN F_DEPOT fDepot ON (fDepot.DE_No = fLot.DE_No)
		INNER JOIN F_DOCLIGNE fLig ON (fLig.DL_No = fLot.DL_NoIn)
		INNER JOIN F_ARTSTOCK fSto ON (fArt.cbAR_Ref = fSto.cbAR_Ref AND fDepot.DE_No = fSto.DE_No)
	WHERE LS_MvtStock = 1
		AND LS_LotEpuise=0
		AND DL_MvtStock=1
		AND (0='$depot' OR fDepot.DE_No='$depot')
	) Req
	
	GROUP BY
		DE_No,IntituleTri,IntituleTri2,cbAR_Ref,AG_No1,AG_No2,Enumere1,Enumere2,AE_Ref,LS_NoSerie,LS_Peremption,LS_Fabrication
	) ReqGlobal		INNER JOIN F_ARTICLE fArt ON (fArt.cbAR_Ref = ReqGlobal.cbAR_Ref)
					 INNER JOIN F_DEPOT fDep ON (fDep.DE_No = ReqGlobal.DE_No)
					LEFT OUTER JOIN F_CONDITION fCondi ON (fArt.CO_No = fCondi.CO_No)
	WHERE 
	    ('0'='$articledebut' OR fArt.AR_Ref>='$articledebut')
		AND ('0'='$articlefin' OR fArt.AR_Ref<='$articlefin')
	GROUP BY $string
	$order";
    }

    public function stat_articleAchatByCANum($compl,$datedeb, $datefin, $famille,$articledebut,$articlefin,$ca_num)
    {
        $requete="SELECT $compl,
                    SUM(DL_Qte) TotQteVendues,
                    SUM(DL_MontantTTC) TotCATTCNet,
                    SUM(DL_MontantHT) TotCAHTNet
                    FROM F_DOCENTETE E
                    INNER JOIN (SELECT AR_Ref,DE_No,CA_Intitule,DO_Date,CASE WHEN B.CA_Num IS NULL THEN A.CA_Num ELSE B.CA_Num END CA_Num,B.N_Analytique,DO_Domaine,DO_Type,DO_Piece
                                ,SUM((CASE WHEN DL_MvtStock=3 THEN -1 ELSE 1 END) * ABS(CASE WHEN DL_Qte IS NULL THEN EA_Quantite ELSE DL_Qte END)) DL_Qte
                                ,SUM((CASE WHEN DL_MvtStock=3 THEN -1 ELSE 1 END) * CASE WHEN DL_Qte IS NULL THEN EA_Montant ELSE DL_MontantHT END) DL_MontantHT
                                ,SUM((CASE WHEN DL_MvtStock=3 THEN -1 ELSE 1 END) * DL_MontantTTC) DL_MontantTTC
                                --,SUM(DL_MontantTTC) OVER(PARTITION BY DO_Domaine,DO_Type,DO_Piece) DL_MontantTTC
                                FROM F_DOCLIGNE A
                                LEFT JOIN Z_LIGNE_COMPTEA B ON A.cbMarq = B.cbMarq_Ligne
                                LEFT JOIN F_COMPTEA CA ON CA.CA_Num = B.CA_Num
                                WHERE DL_MvtStock<>0
                                AND DO_Domaine=1
                                GROUP BY AR_Ref,DE_No,CA_Intitule,DO_Date,CASE WHEN B.CA_Num IS NULL THEN A.CA_Num ELSE B.CA_Num END,B.N_Analytique,DO_Domaine,DO_Type,DO_Piece) D ON D.DO_Domaine = E.DO_Domaine AND D.DO_Type = E.DO_Type AND E.DO_Piece = D.DO_Piece
                    INNER JOIN F_ARTICLE AR ON AR.AR_Ref=D.AR_Ref
                    INNER JOIN F_FAMILLE FA ON FA.FA_CodeFamille = AR.FA_CodeFamille
                    INNER JOIN F_DEPOT DE ON DE.DE_No=D.DE_No
                    LEFT JOIN F_COMPTET CT ON CT.CT_Num = E.DO_Tiers
                    LEFT JOIN F_COLLABORATEUR CO ON CO.CO_No = E.CO_No
                    WHERE ('$ca_num'='0' OR D.N_Analytique = '$ca_num') 
                    AND D.DO_Date BETWEEN '$datedeb' and '$datefin'
                    AND ('0' ='$famille'OR AR.FA_CodeFamille='$famille')
                    AND ('0' ='$articledebut'OR AR.AR_Ref>='$articledebut')
                    AND ('0' ='$articlefin'OR AR.AR_Ref<='$articlefin')
                    GROUP BY $compl";
        return $requete;
    }

    public function stat_articleFournisseurParAgence($depot, $datedeb, $datefin, $famille,$article,$do_type) {
        $requete = "DECLARE @do_type as smallint
DECLARE @famille as nvarchar(50)
DECLARE @article as nvarchar(50)
DECLARE @depot as int
DECLARE @datedeb as datetime
DECLARE @datefin as datetime

SET @do_type = $do_type
SET @famille = '$famille'
SET @article = '$article'
SET @depot = $depot
SET @article = '$article'
SET @datedeb = '$datedeb'
SET @datefin = '$datefin'

SELECT  NumTiers,d.DE_No,DE_Intitule,
		f.AR_Ref,f.AR_Design,TotCATTCNet-TotCAHTNet as PRECOMPTE,
		TotCAHTNet,TotCATTCNet,TotQteVendues,TotCAHTBrut,TotCATTCBrut,
		 0 as TotPrxRevientU,0 as TotPrxRevientCA,
		0 as PourcMargeHT,
		0 as PourcMargeTT
	FROM
		(SELECT NumTiers,cbAR_Ref,DE_No,SUM(CAHTNet)-SUM(0) TotPrxRevientU,
				SUM(CATTCNet)-SUM(0) TotPrxRevientCA,
				SUM(CATTCNet*DL_Taxe1/100) PRECOMPTE,
				
				SUM(CAHTNet) TotCAHTNet,SUM(CATTCNet) TotCATTCNet,SUM(QteVendues) TotQteVendues,
					
				SUM(CASE WHEN (DO_Type=4 OR DO_Type=14)  
								THEN -CAHTBrut  
								ELSE CAHTBrut 
								END) TotCAHTBrut,
				SUM(CASE WHEN (DO_Type=4 OR DO_Type=14)  
								THEN -CATTCBrut  
								ELSE CATTCBrut 
								END) TotCATTCBrut
				FROM (SELECT DO_Piece,DO_Type,fDoc.cbAR_Ref,DE_No,
				fDoc.CT_Num NumTiers,DL_Taxe1,
					(CASE WHEN ((fDoc.DO_Type>=4 AND fDoc.DO_Type<=5) OR (fDoc.DO_Type>=14 AND 
						fDoc.DO_Type<=15)) 
								THEN -DL_MontantHT 
								ELSE DL_MontantHT
								END) CAHTNet,
					(	CASE WHEN ((fDoc.DO_Type>=4 AND fDoc.DO_Type<=5) OR (fDoc.DO_Type>=14 AND 
								fDoc.DO_Type<=15)) 
								THEN -DL_MontantTTC 
								ELSE DL_MontantTTC
								END) CATTCNet,
					(CASE WHEN fDoc.DO_Type<>5 AND fDoc.DO_Type<>15 AND DL_TRemPied=0 AND DL_TRemExep =0 
					AND (DL_TypePL<2 OR DL_TypePL>3) AND AR_FactForfait=0 THEN 
											CASE WHEN (fDoc.DO_Domaine = 4) THEN
													0
											ELSE CASE WHEN (fDoc.DO_Type=4 OR fDoc.DO_Type=14) THEN
													-DL_Qte 
												ELSE
													DL_Qte
												END
											END
								ELSE 0
								END) QteVendues,
					(CASE WHEN (DL_TRemPied>0 OR DL_TRemExep>0 OR 
									DO_Type=5 OR DO_Type=15 OR DL_TypePL=2 OR DL_TypePL=3) THEN
									0
								ELSE
									CASE WHEN (DL_FactPoids=0) THEN
										CASE WHEN (DL_Qte=0) THEN
											DL_PrixUnitaire 
										ELSE
											DL_PrixUnitaire*DL_Qte
										END
									ELSE
										DL_PrixUnitaire*DL_PoidsNet/1000
									END
								END) CAHTBrut,
					(CASE WHEN (DL_TRemPied>0 OR DL_TRemExep>0 OR 
									DO_Type=5 OR DO_Type=15 OR DL_TypePL=2 OR DL_TypePL=3) THEN
									0
								ELSE
									CASE WHEN (DL_FactPoids=0) THEN
										CASE WHEN (DL_Qte=0) THEN
											DL_PUTTC 
										ELSE
											DL_PUTTC*DL_Qte
										END
									ELSE
										DL_PUTTC*DL_PoidsNet/1000
									END
								END) CATTCBrut
				FROM F_ARTICLE fArt 
					INNER JOIN F_DOCLIGNE fDoc ON (fArt.cbAR_Ref = fDoc.cbAR_Ref)
				WHERE (
				(@do_type = 2 AND fDoc.DO_Type IN (30)
					OR @do_type = 7 AND fDoc.DO_Type IN (17)
					OR @do_type = 6 AND fDoc.DO_Type IN (16,17)
					OR @do_type = 3 AND fDoc.DO_Type IN (16,17,13))
					AND fDoc.DL_Valorise=1
					AND fDoc.DL_TRemExep <2
					AND		(@famille='0' OR FA_CodeFamille = @famille) 
                                        AND		(@article='0' OR fDoc.AR_Ref = @article) 
                                        AND		(@depot='0' OR fDoc.DE_No = @depot) 
                                        AND		fDoc.DO_Date >= @datedeb AND fDoc.DO_Date <= @datefin 
					AND fDoc.DL_Valorise=1
					AND fDoc.DL_TRemExep <2
					AND fDoc.DL_NonLivre=0
 AND fArt.AR_HorsStat = 0
				)) fr
		GROUP BY NumTiers ,cbAR_Ref,DE_No
		) totcum 
		 INNER JOIN F_ARTICLE f ON (f.cbAR_Ref = totcum.cbAR_Ref)
		 INNER JOIN F_DEPOT d ON (d.DE_No = totcum.DE_No)
ORDER BY  	totcum.NumTiers ,f.AR_Ref 
";
        return $requete;
    }

    public function stat_articleParAgenceAchat($depot, $datedeb, $datefin, $famille,$article,$do_type) {
        $requete = "SELECT  DE_Intitule,f.AR_Ref,f.AR_Design,
		TotCAHTNet,TotCATTCNet,TotCATTCNet-TotCAHTNet as PRECOMPTE,TotQteVendues,
		TotPrxRevientU,TotPrxRevientCA,
		CASE WHEN TotCAHTNet=0 THEN 0 ELSE ROUND(TotPrxRevientU/TotCAHTNet*100,2) END PourcMargeHT,
		CASE WHEN TotCAHTNet=0 THEN 0 ELSE ROUND(TotPrxRevientCA/TotCATTCNet*100,2) END PourcMargeTT
		
	FROM
		(SELECT cbAR_Ref,
				SUM(CAHTNet) TotCAHTNet,SUM(CATTCNet) TotCATTCNet,SUM(QteVendues) TotQteVendues,
				SUM(CAHTNet)-SUM(PrxRevientU) TotPrxRevientU,
				SUM(CATTCNet)-SUM(PrxRevientU) TotPrxRevientCA,
				SUM(CATTCNet*DL_Taxe1/100) PRECOMPTE,DE_No
				FROM (SELECT fDoc.cbAR_Ref,DL_Taxe1,DE_No,
					(	CASE WHEN (fDoc.DO_Type>=4 AND fDoc.DO_Type<=5) 
								THEN -DL_MontantHT 
								ELSE DL_MontantHT
								END) CAHTNet,
						(	CASE WHEN (fDoc.DO_Type>=4 AND fDoc.DO_Type<=5) 
								THEN -DL_MontantTTC 
								ELSE DL_MontantTTC
								END) CATTCNet,
						ROUND((CASE WHEN fDoc.cbAR_Ref =convert(varbinary(255),AR_RefCompose) THEN
								(select SUM(toto)
										from (SELECT  
												CASE WHEN fDoc2.DL_TRemPied = 0 AND fDoc2.DL_TRemExep = 0 THEN
													CASE WHEN (fDoc2.DL_FactPoids = 0 OR fArt2.AR_SuiviStock > 0) THEN
														CASE WHEN fDoc2.DO_Type <= 2 THEN
															fDoc2.DL_Qte * fDoc2.DL_CMUP
														ELSE
															CASE WHEN (
																		fDoc2.DO_Type = 4
																		)
															THEN
																	fDoc2.DL_PrixRU * (-fDoc2.DL_Qte)
															ELSE
																	fDoc2.DL_PrixRU * fDoc2.DL_Qte
															END
														END
													ELSE CASE WHEN (fDoc2.DO_Type = 4
																	) THEN
															fDoc2.DL_PrixRU * (-fDoc2.DL_PoidsNet) / 1000
														 ELSE
															fDoc2.DL_PrixRU * fDoc2.DL_PoidsNet / 1000
														END
													END
												ELSE 0
												END
 toto
											FROM F_DOCLIGNE fDoc2 INNER JOIN F_ARTICLE fArt2 ON (fDoc2.cbAR_Ref = fArt2.cbAR_Ref)

											WHERE fDoc.cbAR_Ref =convert(varbinary(255),fDoc2.AR_RefCompose)
												AND fDoc2.DL_Valorise<>fDoc.DL_Valorise
												AND fDoc2.cbDO_Piece=fDoc.cbDO_Piece 
												AND fDoc2.DO_Type=fDoc.DO_Type
												AND fDoc2.DL_Ligne>fDoc.DL_Ligne
												AND (NOT EXISTS (SELECT TOP 1 DL_Ligne FROM F_DOCLIGNE fDoc3
																	WHERE	fDoc.AR_Ref = fDoc3.AR_Ref
																			AND fDoc3.AR_Ref = fDoc3.AR_RefCompose
																			AND fDoc3.cbDO_Piece=fDoc.cbDO_Piece
																			AND fDoc3.DO_Type=fDoc.DO_Type
																			AND fDoc3.DL_Ligne>fDoc.DL_Ligne
																	)
															OR fDoc2.DL_Ligne < (SELECT TOP 1 DL_Ligne FROM F_DOCLIGNE fDoc3
																					WHERE	fDoc.AR_Ref = fDoc3.AR_Ref
																							AND fDoc3.AR_Ref = fDoc3.AR_RefCompose
																							AND fDoc3.cbDO_Piece=fDoc.cbDO_Piece
																							AND fDoc3.DO_Type=fDoc.DO_Type
																							AND fDoc3.DL_Ligne>fDoc.DL_Ligne
																				)
													)
										)fcompo
								)ELSE
									CASE WHEN fDoc.DL_TRemPied = 0 AND fDoc.DL_TRemExep = 0 THEN
										CASE WHEN (fDoc.DL_FactPoids = 0 OR fArt.AR_SuiviStock > 0) THEN
											CASE WHEN fDoc.DO_Type <= 2 THEN
												fDoc.DL_Qte * fDoc.DL_CMUP
											ELSE
												CASE WHEN (
															fDoc.DO_Type = 4
															)
												THEN
														fDoc.DL_PrixRU * (-fDoc.DL_Qte)
												ELSE
														fDoc.DL_PrixRU * fDoc.DL_Qte
												END
											END
										ELSE CASE WHEN (fDoc.DO_Type = 4
														) THEN
												fDoc.DL_PrixRU * (-fDoc.DL_PoidsNet) / 1000
											 ELSE
												fDoc.DL_PrixRU * fDoc.DL_PoidsNet / 1000
											END
										END
									ELSE 0
									END
								END),0) PrxRevientU,
				(CASE WHEN (fDoc.DO_Type<5 OR fDoc.DO_Type>5)AND DL_TRemPied=0 AND DL_TRemExep =0
							AND (DL_TypePL < 2 OR DL_TypePL >3)  AND AR_FactForfait=0 THEN 
									CASE WHEN fDoc.DO_Domaine = 4 THEN 
										0
										ELSE CASE WHEN (fDoc.DO_Type=4) THEN
												-DL_Qte 
											ELSE
												DL_Qte
											END
										END
								ELSE 0
								END) QteVendues
					FROM F_ARTICLE fArt INNER JOIN F_DOCLIGNE fDoc ON (fArt.cbAR_Ref = fDoc.cbAR_Ref)
				WHERE
					( 
                                        ($do_type = 2 AND fDoc.DO_Type IN (30)
					OR $do_type = 7 AND fDoc.DO_Type IN (17)
					OR $do_type = 6 AND fDoc.DO_Type IN (16,17)
					OR $do_type = 3 AND fDoc.DO_Type IN (16,17,13))
					AND fDoc.DL_Valorise=1
					AND fDoc.DL_TRemExep <2
					AND		('$famille'='0' OR FA_CodeFamille = '$famille') 
                                        AND		('$article'='0' OR fDoc.AR_Ref = '$article') 
                                        AND		('$depot'='0' OR fDoc.DE_No = $depot) 
                                        AND		fDoc.DO_Date >= '$datedeb' AND fDoc.DO_Date <= '$datefin'  
                   AND fDoc.DL_NonLivre=0
					 AND fArt.AR_HorsStat = 0 
				)) fr
		GROUP BY cbAR_Ref,DE_No 
		
		) totcum
		 INNER JOIN F_ARTICLE f ON (totcum.cbAR_Ref = f.cbAR_Ref)
		 INNER JOIN F_DEPOT d ON (totcum.DE_No = d.DE_No)
ORDER BY  DE_Intitule,	
			f.cbAR_Ref  
";
        return $requete;
    }






    public function stat_articleParAgenceArticle($depot, $datedeb, $datefin, $article, $famille) {
        $requete = "SELECT A.AR_Ref,AR_Design ".
            "   FROM F_DOCLIGNE L " .
            "   INNER JOIN F_ARTICLE A " .
            "   ON A.AR_Ref = L.AR_Ref " .
            "   INNER JOIN F_FAMILLE F " .
            "   ON F.FA_CodeFamille = A.FA_CodeFamille " .
            "   INNER JOIN F_DEPOT D  " .
            "   ON D.DE_No = L.DE_No " .
            "   WHERE	DO_Type = 6  " .
            "   AND		('$famille'='0' OR F.FA_CodeFamille = '$famille') " .
            "   AND		('$article'='0' OR L.AR_Ref = '$article') " .
            "   AND		('$depot'='0' OR D.DE_No = $depot) " .
            "   AND		DO_Date >= '$datedeb' AND DO_Date <= '$datefin'  " .
            "   AND		L.AR_Ref IS NOT NULL   " .
            "   GROUP BY A.AR_Ref,AR_Design " .
            "   ORDER BY 1;  ";
        return $requete;
    }


    public function miseEnSommeil($ca_num){
        return "UPDATE F_COMPTEA SET CA_Sommeil=1 WHERE CA_Num='$ca_num'";
    }


    public function etatVrstDistant($ca_no, $datedeb, $datefin,$impute){
        return "SELECT RG_Piece,CT_NumPayeur,RG_Libelle,RG_Montant,ISNULL(RC_Montant,0)RC_Montant,RG_Montant-ISNULL(RC_Montant,0) ResteAPayer,CA_Intitule,CO_Nom,CAST(RG_Date AS DATE) RG_Date
                FROM F_CREGLEMENT C
                LEFT JOIN (SELECT RG_No,SUM(RC_Montant) RC_Montant FROM F_REGLECH GROUP BY RG_No) R ON C.RG_No= R.RG_No
                LEFT JOIN F_CAISSE CA ON C.CA_No=CA.CA_No
                LEFT JOIN ".$this->db->baseCompta.".DBO.F_COLLABORATEUR Co ON Co.CO_No=C.CO_NoCaissier
                WHERE C.N_Reglement=5 AND RG_Banque=2
                AND RG_DATE BETWEEN '$datedeb' AND '$datefin'
                AND (0=$ca_no OR C.CA_NO = $ca_no)
                AND (-1=$impute OR RG_Impute = $impute)";
    }

    public function initP_COLREGLEMENT(){
        return "INSERT INTO [dbo].[P_COLREGLEMENT]
           ([CR_NumPiece01],[CR_NumPiece02],[CR_Numero01]
           ,[CR_Numero02],[CR_ColReglement01],[CR_ColReglement02],[CR_ColReglement03]
           ,[CR_ColReglement04],[CR_ColReglement05],[CR_ColReglement06],[CR_ColReglement07]
           ,[CR_ColReglement08],[CR_ColReglement09],[CR_ColReglement10],[CR_ColReglement11]
           ,[CR_ColReglement12],[CR_ColReglement13],[CR_ColReglement14],[CR_ColReglement15]
           ,[CR_ColReglement16],[CR_ColReglement17],[CR_ColReglement18],[CR_ColReglement19]
           ,[CR_ColReglement20],[CR_ColReglement21],[CR_ColReglement22],[CR_ColReglement23])
     VALUES
           (/*CR_NumPiece01*/0,/*CR_NumPiece02*/0,/*CR_Numero01*/'0',/*CR_Numero02*/'0'
           ,/*CR_ColReglement01*/0,/*CR_ColReglement02*/0,/*CR_ColReglement03*/0,/*CR_ColReglement04*/0
           ,/*CR_ColReglement05*/0,/*CR_ColReglement06*/0,/*CR_ColReglement07*/0,/*CR_ColReglement08*/0
           ,/*CR_ColReglement09*/0,/*CR_ColReglement10*/0,/*CR_ColReglement11*/0,/*CR_ColReglement12*/0
           ,/*CR_ColReglement13*/0,/*CR_ColReglement14*/0,/*CR_ColReglement15*/0,/*CR_ColReglement16*/0
           ,/*CR_ColReglement17*/0,/*CR_ColReglement18*/0,/*CR_ColReglement19*/0,/*CR_ColReglement20*/0
           ,/*CR_ColReglement21*/0,/*CR_ColReglement22*/0,/*CR_ColReglement23*/0)";
    }
    public function isStock($de_no, $ar_ref) {
        return "SELECT ISNULL(AS_QteSto,0)AS_QteSto,ISNULL(AS_MontSto,0)AS_MontSto,ISNULL(AS_QteMini,0)AS_QteMini,ISNULL(AS_QteMaxi,0)AS_QteMaxi FROM 
                F_ARTSTOCK WHERE DE_No = $de_no AND AR_Ref = '$ar_ref'";
    }
    public function sectionByPlan($nAnalytique) {
        $sql ="SELECT CA_Num,CA_Intitule
                FROM F_COMPTEA
                WHERE N_Analytique =$nAnalytique";
        $result= $this->db->query($sql);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }
    public function isStockDENo($de_no, $ar_ref,$dlQte) {
        return "SELECT  ISNULL(AS_QteSto,0)AS_QteSto
                        ,ISNULL(AS_MontSto,0)AS_MontSto
                        ,ISNULL(AS_QteMini,0)AS_QteMini
                        ,ISNULL(AS_QteMaxi,0)AS_QteMaxi
                        ,CASE WHEN $dlQte > ISNULL(AS_QteSto,0) THEN 1 ELSE 0 END isSuppr 
                FROM F_ARTSTOCK 
                WHERE DE_No = $de_no 
                AND   AR_Ref = '$ar_ref'";
    }
    public function cumulStock() {
        return "SELECT SUM(ISNULL(AS_QteSto,0))-SUM(ISNULL(AS_QteMini,0)) Alerte
                FROM F_ARTSTOCK
                WHERE AS_QteMini<>0";
    }

    public function cumulStockDetail()
    {
        return "SELECT  AR_Design
                        ,DE_Intitule
                        ,AS_QteSto
                        ,AS_QteMini
                        ,QteACommander 
                FROM (  SELECT	AR_Design
                                ,DE_Intitule
                                ,Alerte = SUM(ISNULL(AS_QteSto,0))-SUM(ISNULL(AS_QteMini,0)) 
                                ,QteACommander = SUM(ISNULL(AS_QteMaxi,0))-SUM(ISNULL(AS_QteSto,0)) 
                                ,AS_QteSto = SUM(ISNULL(AS_QteSto,0)) 
                                ,AS_QteMini = SUM(ISNULL(AS_QteMini,0)) 
                        FROM    F_ARTSTOCK A
                        INNER JOIN F_ARTICLE B 
                            ON  A.cbAR_Ref=B.cbAR_Ref
                        INNER JOIN F_DEPOT C 
                            ON  A.DE_No=C.DE_No
                        WHERE   AS_QteMini<>0
                        GROUP BY AR_Design,DE_Intitule)A
                WHERE   Alerte<0";
    }

    public function updateReglementCaisse($libelle,$montant,$rg_no) {
        return "UPDATE F_CREGLEMENT SET RG_Libelle = '$libelle',cbModification=GETDATE(),RG_Montant=$montant WHERE RG_No= '$rg_no'";
    }

    public function updateReglementCaisseDAF($libelle,$rg_no) {
        return "UPDATE F_CREGLEMENT SET RG_Libelle = '$libelle',RG_Banque=1,RG_Type=4 WHERE RG_No= '$rg_no'";
    }

    public function getCompteEntree() {
        return "SELECT  P_CreditCaisse
                        ,CG_Intitule
                        ,CONCAT(CONCAT(P_CreditCaisse,' - '),CG_Intitule) info
                        ,CG_Analytique
                FROM P_PARAMETRECIAL A
                LEFT JOIN F_COMPTEG B ON P_CreditCaisse = CG_Num";
    }
    public function getCompteSortie() {
        return "SELECT  P_DebitCaisse
                        ,CG_Intitule
                        ,CONCAT(CONCAT(P_DebitCaisse,' - '),CG_Intitule) info
                        ,CG_Analytique
                FROM P_PARAMETRECIAL A
                LEFT JOIN F_COMPTEG B ON P_DebitCaisse = CG_Num";
    }

    public function getLigneFacture($do_piece,$domaine,$type) {
        $val = "";
        return "SELECT DL_PUDevise,CA_Num,DL_TTC,$val DL_PUTTC,DL_MvtStock,CT_Num,cbMarq,DL_TypeTaux1,DL_TypeTaux2,DL_TypeTaux3,cbCreateur,DL_NoColis
                      ,CASE WHEN DL_TypeTaux1=0 THEN DL_MontantHT*(DL_Taxe1/100) 
                              WHEN DL_TypeTaux1=1 THEN DL_Taxe1*DL_Qte ELSE DL_Taxe1 END MT_Taxe1
                      , CASE WHEN DL_TypeTaux2=0 THEN DL_MontantHT*(DL_Taxe2/100) 
                              WHEN DL_TypeTaux2=1 THEN DL_Taxe2*DL_Qte ELSE DL_Taxe2 END MT_Taxe2
                      , CASE WHEN DL_TypeTaux3=0 THEN DL_MontantHT*(DL_Taxe3/100) 
                              WHEN DL_TypeTaux3=1 THEN DL_Taxe3*DL_Qte ELSE DL_Taxe3 END MT_Taxe3
	                  ,DL_MontantHT,DO_Piece,
        AR_Ref,DE_No,DL_CMUP AS AR_PrixAch,DL_Design,DL_Qte,DL_PrixUnitaire,DL_CMUP,DL_Taxe1,DL_Taxe2,DL_Taxe3,DL_MontantTTC,DL_Ligne,DL_Remise01REM_Valeur,DL_Remise01REM_Type,
        CASE WHEN DL_Remise01REM_Type=0 THEN ''  
                WHEN DL_Remise01REM_Type=1 THEN cast(cast(DL_Remise01REM_Valeur as numeric(9,2)) as varchar(10))+'%' ELSE cast(cast(DL_Remise01REM_Valeur as numeric(9,2)) as varchar(10))+'U' END DL_Remise,
        DL_PrixUnitaire -(CASE WHEN DL_Remise01REM_Type= 0 THEN DL_PrixUnitaire
	                          WHEN DL_Remise01REM_Type=1 THEN  DL_PrixUnitaire * DL_Remise01REM_Valeur / 100
                                WHEN DL_Remise01REM_Type=2 THEN DL_Remise01REM_Valeur ELSE 0 END) DL_PrixUnitaire_Rem,
        DL_PUTTC -(CASE WHEN DL_Remise01REM_Type= 0 THEN DL_PUTTC
	                      WHEN DL_Remise01REM_Type=1 THEN  DL_PrixUnitaire * DL_Remise01REM_Valeur / 100
                            WHEN DL_Remise01REM_Type=2 THEN DL_Remise01REM_Valeur ELSE 0 END) DL_PUTTC_Rem,
		DL_PrixUnitaire -(CASE WHEN DL_Remise01REM_Type= 0 THEN 0
                                WHEN DL_Remise01REM_Type=1 THEN  DL_PrixUnitaire * DL_Remise01REM_Valeur / 100
                                  WHEN DL_Remise01REM_Type=2 THEN DL_Remise01REM_Valeur ELSE 0 END) DL_PrixUnitaire_Rem0,
        DL_PUTTC -(CASE WHEN DL_Remise01REM_Type= 0 THEN 0
                          WHEN DL_Remise01REM_Type=1 THEN  DL_PrixUnitaire * DL_Remise01REM_Valeur / 100
		                    WHEN DL_Remise01REM_Type=2 THEN DL_Remise01REM_Valeur ELSE 0 END) DL_PUTTC_Rem0
        FROM F_DOCLIGNE  
        WHERE DO_Piece ='$do_piece' AND DO_Domaine=$domaine AND DO_Type = $type
        ORDER BY cbMarq";
    }



    public function getLigneFactureTransfert($do_piece, $ct_num,$do_domaine,$do_type) {
        return "SELECT 0 AS idSec,cbMarq,DO_Piece,AR_Ref,DL_Design,DL_Qte,DL_PrixUnitaire,DL_CMUP,DL_Taxe1,DL_Taxe2,DL_Taxe3,DL_MontantTTC,DL_MontantHT,DL_Ligne,CASE WHEN DL_Remise01REM_Type=0 THEN ''  ELSE CASE WHEN DL_Remise01REM_Type=1 THEN cast(cast(DL_Remise01REM_Valeur as numeric(9,2)) as varchar(10))+'%' ELSE cast(cast(DL_Remise01REM_Valeur as numeric(9,2)) as varchar(10))+'U' END END DL_Remise  FROM F_DOCLIGNE  WHERE DO_Domaine=$do_domaine AND DO_Type=$do_type AND DO_Piece ='$do_piece' order by cbMarq";
    }


    public function getLigneTransfert($do_piece){
        return "SELECT idSec, *
                FROM (SELECT ROW_NUMBER() OVER(ORDER BY DL_Ligne) AS Ligne,cbMarq,DO_Piece,AR_Ref,DL_Design,DL_Qte,DL_PrixUnitaire,DL_CMUP,DL_Taxe1,DL_Taxe2,DL_Taxe3,DL_MontantTTC,DL_MontantHT,DL_Ligne,CASE WHEN DL_Remise01REM_Type=0 THEN ''  ELSE CASE WHEN DL_Remise01REM_Type=1 THEN cast(cast(DL_Remise01REM_Valeur as numeric(9,2)) as varchar(10))+'%' ELSE cast(cast(DL_Remise01REM_Valeur as numeric(9,2)) as varchar(10))+'U' END END DL_Remise
                FROM F_DOCLIGNE M 
                WHERE DO_Piece='$do_piece' AND DO_Type=23 AND DO_Domaine=2) AS A
                INNER JOIN (SELECT Ligne,cbMarq as idSec
                                        FROM(SELECT ROW_NUMBER() OVER(ORDER BY DL_Ligne) AS Ligne,cbMarq
                                        FROM F_DOCLIGNE M 
                                        WHERE DO_Piece='$do_piece' AND DO_Type=23 AND DO_Domaine=2)B
                                        WHERE Ligne%2=0) B on (A.Ligne+1) = B.Ligne
                WHERE A.Ligne%2<>0
                ORDER BY A.cbMarq";
    }

    public function getLigneFactureDernierElement($do_piece) {
        return "SELECT top 1 cbMarq,DL_PUTTC,DL_NoColis,DO_Piece,AR_Ref,DL_Design,DL_Qte,DL_PrixUnitaire,DL_CMUP,DL_Taxe1,DL_Taxe2,
                DL_Taxe3,DL_MontantTTC,DL_MontantHT,DL_Ligne,
                CASE WHEN DL_Remise01REM_Type=0 THEN ''  ELSE CASE WHEN DL_Remise01REM_Type=1 THEN cast(cast(DL_Remise01REM_Valeur as numeric(9,2)) as varchar(10))+'%' ELSE cast(cast(DL_Remise01REM_Valeur as numeric(9,2)) as varchar(10))+'U' END END DL_Remise  
                FROM F_DOCLIGNE  WHERE DO_Piece ='$do_piece' order by cbMarq desc";
    }

    public function getLigneFactureElementByCbMarq($cbmarq) {
        return "SELECT  DO_Domaine, DO_Type,DO_Date,DL_PUTTC,DL_NoColis,DE_No,cbMarq,DO_Piece,AR_Ref
                        ,DL_Qte,DL_Design,DL_PrixUnitaire,DL_CMUP,DL_Taxe1,DL_Taxe2,DL_Taxe3,DL_MontantTTC
                        ,DL_MontantHT,DL_Ligne,CASE WHEN DL_Remise01REM_Type=0 THEN ''  ELSE CASE WHEN DL_Remise01REM_Type=1 THEN cast(cast(DL_Remise01REM_Valeur as numeric(9,2)) as varchar(10))+'%' ELSE cast(cast(DL_Remise01REM_Valeur as numeric(9,2)) as varchar(10))+'U' END END DL_Remise  
                FROM F_DOCLIGNE  WHERE cbMarq =$cbmarq";
    }

    public function getZFactReglSuppr($DO_Domaine,$DO_Type,$DO_Piece){
        $query="SELECT 1 FROM [Z_FACT_REGL_SUPPR] WHERE DO_Domaine=$DO_Domaine AND DO_Piece='$DO_Piece' AND DO_Type=$DO_Type";
        return $query;
    }

    public function getPrixClient($ar_ref, $catcompta, $cattarif) {
        return "
BEGIN 
SET NOCOUNT ON;
DECLARE @flagCat AS TINYINT
SELECT @flagCat = P_ReportPrixRev
FROM P_PARAMETRECIAL

            SELECT *,CASE WHEN AC_PrixTTC = 1 THEN Prix /(1+taxe1/100)/(1+taxe2/100)/(1+taxe3/100) ELSE Prix END PrixVente
            FROM( 
                SELECT	a.FA_CodeFamille
                        , a.AR_Ref
                        , ISNULL(AR_PrixAch,0)AR_PrixAch
                        , AR_Design
                        , ISNULL(AR_PrixVen,0)AR_PrixVen
                        ,Qte_Gros
                        ,CASE WHEN @flagCat=0 THEN Prix_Min ELSE ISNULL(AC_Coef,0) END Prix_Min
				        ,CASE WHEN @flagCat=0 THEN Prix_Max ELSE ISNULL(AC_PrixVen,0) END Prix_Max
                        ,ISNULL(CASE WHEN AC_PrixVen<>0 THEN AC_PrixVen ELSE AR_PrixVen END,0) AS Prix, AC_PrixTTC, AR_PrixTTC,
			(CASE WHEN ISNULL(TU.TA_Sens,0)=0 THEN -1 ELSE 1 END)*ISNULL(TU.TA_Taux,0) as taxe1, 
			(CASE WHEN ISNULL(TD.TA_Sens,0)=0 THEN -1 ELSE 1 END)*ISNULL(TD.TA_Taux,0) as taxe2,
			(CASE WHEN ISNULL(TT.TA_Sens,0)=0 THEN -1 ELSE 1 END)*ISNULL(TT.TA_Taux,0) as taxe3, FCP_Champ 
                 FROM F_ARTICLE A 
                 LEFT JOIN (select * from F_ARTCLIENT where AC_Categorie=(SELECT ISNULL((SELECT AC_Categorie FROM F_ARTCLIENT WHERE AR_REF = '$ar_ref' AND AC_Categorie=$cattarif),1)))AR on AR.AR_Ref = A.AR_Ref
                 LEFT JOIN (SELECT * FROM F_FAMCOMPTA WHERE FCP_Type=0 AND FCP_Champ=$catcompta)FA ON FA.FA_CodeFamille = A.FA_CodeFamille 
                 LEFT JOIN ".$this->db->baseCompta.".DBO.F_TAXE TU ON TU.TA_Code = FA.FCP_ComptaCPT_Taxe1 
                 LEFT JOIN ".$this->db->baseCompta.".DBO.F_TAXE TD ON TD.TA_Code = FA.FCP_ComptaCPT_Taxe2 
                 LEFT JOIN ".$this->db->baseCompta.".DBO.F_TAXE TT ON TT.TA_Code = FA.FCP_ComptaCPT_Taxe3 
                 WHERE  A.AR_REF = '$ar_ref'  )A;
                 
                 END;";
    }

    public function getLibTaxePied($cattarif,$catcompta){
        return" SELECT  LIB1 = TU.TA_Intitule
                        ,LIB2 = TD.TA_Intitule
                        ,LIB3 = TT.TA_Intitule
                        ,TA_Code1 = TU.TA_Code
                        ,TA_Code2 = TD.TA_Code
                        ,TA_Code3 = TT.TA_Code
                FROM F_FAMCOMPTA FA
                        LEFT JOIN DBO.F_TAXE TU 
                            ON  TU.TA_Code = FA.FCP_ComptaCPT_Taxe1 
                        LEFT JOIN DBO.F_TAXE TD 
                            ON  TD.TA_Code = FA.FCP_ComptaCPT_Taxe2 
                        LEFT JOIN DBO.F_TAXE TT 
                            ON  TT.TA_Code = FA.FCP_ComptaCPT_Taxe3 
                        WHERE   FCP_Type=$cattarif 
                        AND     FCP_Champ=$catcompta
                GROUP BY TU.TA_Intitule,TD.TA_Intitule,TT.TA_Intitule,TU.TA_Code,TD.TA_Code,TT.TA_Code";
    }

    public function getF_Artclient(){
        return "SELECT AR_Ref,AC_Categorie,AC_PrixVen,AC_PrixTTC,cbModification 
            FROM F_ARTCLIENT";
    }

    public function getF_ArtclientCount(){
        return "SELECT count(*)Nb,max(cbModification)cbModification  
            FROM F_ARTCLIENT";
    }

    public function insertF_ArtCompta($ar_ref,$acp_type,$acp_champ,$cg_num,$cg_numA,$ta_code1,$ta_code2,$ta_code3){
        return "INSERT INTO [dbo].[F_ARTCOMPTA]
           ([AR_Ref],[ACP_Type],[ACP_Champ],[ACP_ComptaCPT_CompteG]
           ,[ACP_ComptaCPT_CompteA],[ACP_ComptaCPT_Taxe1]
           ,[ACP_ComptaCPT_Taxe2],[ACP_ComptaCPT_Taxe3]
           ,[ACP_TypeFacture],[cbProt],[cbCreateur],[cbModification]
           ,[cbReplication],[cbFlag])
     VALUES
           (/*AR_Ref*/'$ar_ref',/*ACP_Type*/$acp_type
           ,/*ACP_Champ*/$acp_champ,/*ACP_ComptaCPT_CompteG*/'$cg_num'
           ,/*ACP_ComptaCPT_CompteA*/'$cg_numA'
           ,/*ACP_ComptaCPT_Taxe1*/(CASE WHEN '$ta_code1' ='' THEN NULL ELSE '$ta_code1' END)
           ,/*ACP_ComptaCPT_Taxe2*/(CASE WHEN '$ta_code2' ='' THEN NULL ELSE '$ta_code2' END)
           ,/*ACP_ComptaCPT_Taxe3*/(CASE WHEN '$ta_code3' ='' THEN NULL ELSE '$ta_code3' END)
           ,/*ACP_TypeFacture*/0,/*cbProt*/0,/*cbCreateur*/'AND',/*cbModification*/GETDATE()
           ,/*cbReplication*/0,/*cbFlag*/0)";
    }

    public function insertF_FamCompta($fa_codeFamille,$acp_type,$acp_champ,$cg_num,$cg_numA,$ta_code1,$ta_code2,$ta_code3){
        return "INSERT INTO [dbo].[F_FAMCOMPTA]
           ([FA_CodeFamille],[FCP_Type],[FCP_Champ],[FCP_ComptaCPT_CompteG]
           ,[FCP_ComptaCPT_CompteA],[FCP_ComptaCPT_Taxe1]
           ,[FCP_ComptaCPT_Taxe2],[FCP_ComptaCPT_Taxe3]
           ,[FCP_TypeFacture],[cbProt],[cbCreateur],[cbModification]
           ,[cbReplication],[cbFlag])
     VALUES
           (/*AR_Ref*/'$fa_codeFamille',/*FCP_Type*/$acp_type
           ,/*FCP_Champ*/$acp_champ,/*FCP_ComptaCPT_CompteG*/'$cg_num'
           ,/*FCP_ComptaCPT_CompteA*/'$cg_numA'
           ,/*FCP_ComptaCPT_Taxe1*/(CASE WHEN '$ta_code1' ='' THEN NULL ELSE '$ta_code1' END)
           ,/*FCP_ComptaCPT_Taxe2*/(CASE WHEN '$ta_code2' ='' THEN NULL ELSE '$ta_code2' END)
           ,/*FCP_ComptaCPT_Taxe3*/(CASE WHEN '$ta_code3' ='' THEN NULL ELSE '$ta_code3' END)
           ,/*FCP_TypeFacture*/0,/*cbProt*/0,/*cbCreateur*/'AND',/*cbModification*/GETDATE()
           ,/*cbReplication*/0,/*cbFlag*/0)";
    }

    public function modifF_ArtCompta($ar_ref,$acp_type,$acp_champ,$cg_num,$cg_numA,$ta_code1,$ta_code2,$ta_code3){
        return "UPDATE [dbo].[F_ARTCOMPTA] SET ACP_ComptaCPT_CompteG='$cg_num',ACP_ComptaCPT_CompteA='$cg_numA'
                ,ACP_ComptaCPT_Taxe1=(CASE WHEN '$ta_code1' ='' THEN NULL ELSE '$ta_code1' END)
                ,ACP_ComptaCPT_Taxe2=(CASE WHEN '$ta_code2' ='' THEN NULL ELSE '$ta_code2' END)
                ,ACP_ComptaCPT_Taxe3=(CASE WHEN '$ta_code3' ='' THEN NULL ELSE '$ta_code3' END)
                WHERE AR_Ref='$ar_ref' AND ACP_Type=$acp_type AND ACP_Champ=$acp_champ";
    }

    public function modifF_FamCompta($fa_codeFamille,$acp_type,$acp_champ,$cg_num,$cg_numA,$ta_code1,$ta_code2,$ta_code3){
        return "UPDATE [dbo].[F_FAMCOMPTA] SET FCP_ComptaCPT_CompteG='$cg_num',FCP_ComptaCPT_CompteA='$cg_numA'
                ,FCP_ComptaCPT_Taxe1=(CASE WHEN '$ta_code1' ='' THEN NULL ELSE '$ta_code1' END)
                ,FCP_ComptaCPT_Taxe2=(CASE WHEN '$ta_code2' ='' THEN NULL ELSE '$ta_code2' END)
                ,FCP_ComptaCPT_Taxe3=(CASE WHEN '$ta_code3' ='' THEN NULL ELSE '$ta_code3' END)
                WHERE FA_CodeFamille='$fa_codeFamille' AND FCP_Type=$acp_type AND FCP_Champ=$acp_champ";
    }

    public function getF_ArtCompta(){
        return "SELECT AR_Ref,ACP_ComptaCPT_CompteA,ACP_ComptaCPT_CompteG,ACP_Champ,ACP_ComptaCPT_Taxe1,ACP_ComptaCPT_Taxe2,ACP_ComptaCPT_Taxe3,ACP_Type,cbModification
            FROM F_ARTCOMPTA";
    }
    public function getF_ArtComptaCount(){
        return "SELECT count(*)Nb,max(cbModification)cbModification
            FROM F_ARTCOMPTA";
    }

    public function getF_FamCompta(){
        return "SELECT FA_CodeFamille,FCP_ComptaCPT_CompteA,FCP_ComptaCPT_CompteG,FCP_Champ,FCP_ComptaCPT_Taxe1,FCP_ComptaCPT_Taxe2,FCP_ComptaCPT_Taxe3,FCP_Type,cbModification
            FROM F_FAMCOMPTA";
    }

    public function getF_FamComptaCount(){
        return "SELECT count(*)Nb,max(cbModification)cbModification
            FROM F_FAMCOMPTA";
    }

    public function getF_Taxe(){
        return "SELECT TA_Intitule,TA_TTaux,TA_Taux,TA_Type,CG_Num,TA_No,TA_Code,TA_NP,TA_Sens,TA_Provenance,TA_Regroup,TA_Assujet,cbModification FROM ".$this->db->baseCompta.".DBO.F_Taxe ORDER BY TA_Code";
    }

    public function getF_TaxeCount(){
        return "SELECT count(*) Nb,max(cbModification)cbModification  
                FROM F_Taxe";
    }


    public function getPrixClientAch($ar_ref, $catcompta, $cattarif,$ct_num="") {
        return "SELECT *,CASE WHEN AC_PrixTTC = 1 THEN Prix /(1+taxe1/100)/(1+taxe2/100)/(1+taxe3/100) ELSE Prix END PrixVente 
                 FROM( 
                     SELECT a.FA_CodeFamille, 
							a.AR_Ref, 
							CASE WHEN AF_PrixAch IS NULL THEN AR_PrixAch ELSE AF_PrixAch END AR_PrixAch, 
							AR_Design, 
							AR_PrixVen,
							Prix_Min,
							Prix_Max,
							CASE WHEN AC_Categorie= 1 THEN AR_PrixVen 
									WHEN AC_PrixVen<>0 THEN AC_PrixVen ELSE AR_PrixVen END AS Prix, 
							AC_PrixTTC, 
							AR_PrixTTC,
                     (CASE WHEN ISNULL(TU.TA_Sens,0)=0 THEN 1 ELSE -1 END)*ISNULL(TU.TA_Taux,0) as taxe1, 
                   (CASE WHEN ISNULL(TD.TA_Sens,0)=0 THEN 1 ELSE -1 END)*ISNULL(TD.TA_Taux,0) as taxe2,
                   (CASE WHEN ISNULL(TT.TA_Sens,0)=0 THEN 1 ELSE -1 END)*ISNULL(TT.TA_Taux,0) as taxe3, FCP_Champ 
                FROM F_ARTICLE A 
                LEFT JOIN (SELECT AR_Ref,CT_Num,AF_PrixAch FROM F_ARTFOURNISS WHERE CT_Num ='$ct_num') AF ON A.AR_Ref = AF.AR_Ref
                  LEFT JOIN (select * from F_ARTCLIENT where AC_Categorie=(SELECT ISNULL((SELECT AC_Categorie FROM F_ARTCLIENT WHERE AR_REF = '$ar_ref' AND AC_Categorie=$cattarif),1)))AR on AR.AR_Ref = A.AR_Ref
                 LEFT JOIN (SELECT * FROM F_FAMCOMPTA WHERE FCP_Type=1 AND FCP_Champ=$catcompta)FA ON FA.FA_CodeFamille = A.FA_CodeFamille 
                 LEFT JOIN F_TAXE TU ON TU.TA_Code = FA.FCP_ComptaCPT_Taxe1 
                 LEFT JOIN F_TAXE TD ON TD.TA_Code = FA.FCP_ComptaCPT_Taxe2 
                 LEFT JOIN F_TAXE TT ON TT.TA_Code = FA.FCP_ComptaCPT_Taxe3 
                 WHERE  A.AR_REF = '$ar_ref')A";
    }

    public function getPrixClientAchHT($ar_ref, $catcompta, $cattarif,$prix,$rem) {
        return "SELECT *,CASE WHEN AC_PrixTTCS = 1 AND AR_PrixTTCS = 1 THEN ROUND(".($prix-$rem)."/(1+taxe1/100)/(1+taxe2/100)/(1+taxe3/100),2) ELSE ".($prix-$rem)." END DL_MontantHT,taxe1,taxe2,taxe3,
            CASE WHEN AC_PrixTTCS = 1 AND AR_PrixTTCS = 1 THEN ROUND($prix /(1+taxe1/100)/(1+taxe2/100)/(1+taxe3/100),2) ELSE $prix END DL_PrixUnitaire,
            CASE WHEN AC_PrixTTCS = 1 AND AR_PrixTTCS = 1 THEN ".($prix-$rem)." ELSE (".($prix-$rem)." +(".($prix-$rem)."*taxe1/100)+(".($prix-$rem)."*taxe2/100)+(".($prix-$rem)."*taxe3/100)) END DL_MontantTTC,
            CASE WHEN AC_PrixTTCS = 1 AND AR_PrixTTCS = 1 THEN $prix ELSE ($prix +($prix*taxe1/100)+($prix*taxe2/100)+($prix*taxe3/100)) END DL_PUTTC 
                 FROM( 
                     SELECT a.FA_CodeFamille, a.AR_Ref, AR_PrixAch, AR_Design, AR_PrixVen,Prix_Min,Prix_Max,
                     CASE WHEN AC_Categorie= 1 THEN AR_PrixVen ELSE CASE WHEN AC_PrixVen<>0 THEN AC_PrixVen ELSE AR_PrixVen END END AS Prix, 0 AS AC_PrixTTCS, 0 AS AR_PrixTTCS,
                    (CASE WHEN ISNULL(TU.TA_Sens,0)=0 THEN 1 ELSE -1 END)*ISNULL(TU.TA_Taux,0) as taxe1, 
                   (CASE WHEN ISNULL(TD.TA_Sens,0)=0 THEN 1 ELSE -1 END)*ISNULL(TD.TA_Taux,0) as taxe2,
                   (CASE WHEN ISNULL(TT.TA_Sens,0)=0 THEN 1 ELSE -1 END)*ISNULL(TT.TA_Taux,0) as taxe3, FCP_Champ 
                FROM F_ARTICLE A 
                LEFT JOIN (select * from F_ARTCLIENT where AC_Categorie=(SELECT ISNULL((SELECT AC_Categorie FROM F_ARTCLIENT WHERE AR_REF = '$ar_ref' AND AC_Categorie=$cattarif),1)))AR on AR.AR_Ref = A.AR_Ref
                 LEFT JOIN (SELECT * FROM F_FAMCOMPTA WHERE FCP_Type=1 AND FCP_Champ=$catcompta)FA ON FA.FA_CodeFamille = A.FA_CodeFamille 
                 LEFT JOIN ".$this->db->baseCompta.".DBO.F_TAXE TU ON TU.TA_Code = FA.FCP_ComptaCPT_Taxe1 
                 LEFT JOIN ".$this->db->baseCompta.".DBO.F_TAXE TD ON TD.TA_Code = FA.FCP_ComptaCPT_Taxe2 
                 LEFT JOIN ".$this->db->baseCompta.".DBO.F_TAXE TT ON TT.TA_Code = FA.FCP_ComptaCPT_Taxe3 
                 WHERE  A.AR_REF = '$ar_ref')A";
    }

    public function getDateEcgetTiersheance($ct_num,$date){
        $requete = "SELECT CAST(ISNULL(DATEADD(DAY,ER_NbJour,'$date'),'$date') AS DATE) date_ech
                    FROM F_COMPTET C
                    LEFT JOIN F_MODELER M ON C.MR_No = M.MR_No
                    LEFT JOIN (SELECT * FROM F_EMODELER EM WHERE N_Reglement=1) EM ON EM.MR_No = M.MR_No
                    WHERE CT_Num='$ct_num'";
        $result = $this->db->requete($requete);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        return json_encode($rows);

    }


    public function getDateEcgetTiersheanceSage($ct_num,$date){
        $requete = "SELECT REPLACE(CONVERT(VARCHAR(8), CAST(ISNULL(DATEADD(DAY,ER_NbJour,'$date'),'$date')  AS DATE), 5),'-','') date_ech
                    FROM F_COMPTET C
                    LEFT JOIN F_MODELER M ON C.MR_No = M.MR_No
                    LEFT JOIN (SELECT * FROM F_EMODELER EM WHERE N_Reglement=1) EM ON EM.MR_No = M.MR_No
                    WHERE CT_Num='$ct_num'";
        $result = $this->db->requete($requete);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        return json_encode($rows);

    }

    public function getDateEcgetTiersheanceSelect($MR_No,$N_Reglement,$date){
        $requete = "SELECT CAST(ISNULL(DATEADD(DAY,ER_NbJour,'$date'),'$date') AS DATE) date_ech
                    FROM F_MODELER M 
                    LEFT JOIN F_EMODELER EM ON EM.MR_No = M.MR_No
                    WHERE M.MR_No=$MR_No AND N_Reglement=$N_Reglement";
        $result = $this->db->requete($requete);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        return json_encode($rows);

    }

    public function montantRegle($do_piece,$do_domaine,$do_type) {
        return "SELECT SUM(DL_MontantTTC) as montantRegle FROM F_DOCLIGNE WHERE DO_Piece='$do_piece' AND DO_Domaine=$do_domaine AND DO_Type=$do_type";
    }

    public function AvanceDoPiece($do_piece,$do_domaine,$do_type) {
        return "SELECT SUM(RC_Montant) as avance_regle 
                FROM F_REGLECH 
                WHERE DO_Piece='$do_piece' AND DO_Domaine=$do_domaine AND DO_Type=$do_type";
    }

    public function getFacture($do_tiers, $datedeb, $datefin) {
        $requete = "SELECT E.cbMarq,DE_Intitule,E.DO_Piece,E.DO_Ref,CAST(CAST(E.DO_Date AS DATE) AS VARCHAR(10)) AS DO_Date,E.DO_Tiers as CT_Num,CT_Intitule, ISNULL(ROUND(SUM(L.DL_MontantTTC),0),0) AS ttc, 
                    ISNULL(MAX(latitude),0) as latitude,ISNULL(MAX(longitude),0) as longitude,ISNULL(sum(avance),0) AS avance  ,'' as statut
                    FROM  F_DOCENTETE E 
                    LEFT JOIN (SELECT DO_Piece,DO_Type,DO_Domaine,DO_Ref,DO_Date,CT_Num,SUM(DL_MontantTTC) DL_MontantTTC FROM F_DOCLIGNE L GROUP BY DO_Piece,DO_Type,DO_Domaine,DO_Ref,DO_Date,CT_Num) L  on E.DO_Piece=L.DO_Piece  AND E.DO_Domaine= L.DO_Domaine AND E.DO_Type=L.DO_Type
                    INNER JOIN F_DOCREGL R on R.DO_Piece=E.DO_Piece  
                    INNER JOIN ".$this->db->baseCompta.".dbo.F_COMPTET C on C.CT_Num=E.DO_Tiers
                    LEFT JOIN (SELECT DR_No, SUM(RC_MONTANT) avance FROM F_REGLECH R INNER JOIN F_Creglement Re on Re.RG_No=R.RG_No GROUP BY DR_No) A ON A.DR_No=R.DR_No  
                    WHERE E.CO_No =" . $do_tiers . " AND CAST(E.DO_Date as DATE) BETWEEN '" . $datedeb . "' AND '" . $datefin . "'
                    GROUP BY E.cbMarq,E.DO_Piece,E.DO_Ref,E.DO_Date,E.DO_Tiers,CT_Intitule
                    ORDER BY E.cbMarq ";
        return $requete;
    }

    public function getTicketByDENo($de_no,$do_provenance, $datedeb, $datefin,$client) {
        $requete = "SELECT E.cbModification,E.cbMarq,E.DO_Type,E.DO_Domaine,DE_Intitule,E.DO_Piece,E.DO_Ref,CAST(CAST(E.DO_Date AS DATE) AS VARCHAR(10)) AS DO_Date,E.DO_Tiers as CT_Num,CT_Intitule, (ISNULL(ROUND(SUM(L.DL_MontantTTC),0),0)) AS ttc, 
                    ISNULL(MAX(CASE WHEN E.N_CatCompta=0 THEN (C.N_CatCompta) ELSE (E.N_CatCompta) END),'0') N_CatCompta,ISNULL(MAX(latitude),0) as latitude,ISNULL(MAX(longitude),0) as longitude,ISNULL(sum(avance),0) AS avance,
                    CASE WHEN (SUM(L.DL_MontantTTC)>=0 AND SUM(avance) IS NULL OR sum(avance)<SUM(L.DL_MontantTTC)) OR (SUM(L.DL_MontantTTC)<0 AND SUM(avance) IS NULL OR sum(avance)>SUM(L.DL_MontantTTC)) OR  (ISNULL(SUM(L.DL_MontantTTC),0)=0 AND ISNULL(SUM(avance),0)=0 ) OR  (SUM(L.DL_MontantTTC) IS NULL AND SUM(avance) IS NULL) THEN 'crédit' else 'comptant' END AS statut
                    FROM F_DOCENTETE E 
                    LEFT JOIN (SELECT DO_Piece,DO_Ref,DO_Date,DO_Domaine,DO_Type,CT_Num,SUM(DL_MontantTTC) DL_MontantTTC FROM F_DOCLIGNE L GROUP BY DO_Piece,DO_Ref,DO_Date,CT_Num,DO_Domaine,DO_Type) L on E.DO_Piece=L.DO_Piece AND E.DO_Domaine=L.DO_Domaine AND E.DO_Type = L.DO_Type
                    INNER JOIN F_DOCREGL R on R.DO_Piece=E.DO_Piece  AND E.DO_Domaine= R.DO_Domaine AND E.DO_Type=R.DO_Type
                    INNER JOIN F_DEPOT D on D.DE_No=E.DE_No 
                    INNER JOIN ".$this->db->baseCompta.".dbo.F_COMPTET C on C.CT_Num=E.DO_Tiers
                    LEFT JOIN (SELECT DR_No, SUM(RC_MONTANT) avance FROM F_REGLECH R INNER JOIN F_Creglement Re on Re.RG_No=R.RG_No GROUP BY DR_No) A ON A.DR_No=R.DR_No  
                    WHERE E.DO_Provenance=$do_provenance 
                    AND E.DO_Domaine=3 AND E.DO_Type=30 
                    AND (0=$de_no OR E.DE_No =$de_no)  
                    AND ('0'='$client' OR E.DO_Tiers ='$client') 
                    AND CAST(E.DO_Date as DATE) >= '$datedeb' AND CAST(E.DO_Date as DATE) <='$datefin'
                    GROUP BY E.cbModification,E.cbMarq,E.DO_Type,E.DO_Domaine,DE_Intitule,E.DO_Piece,E.DO_Ref,E.DO_Date,E.DO_Tiers,CT_Intitule
                    ORDER BY E.cbMarq 
                 ";
        return $requete;
    }

    public function getFactureCO($co_no, $ct_num) {

        $requete = "SELECT E.cbMarq,DE_Intitule,E.DO_Piece,E.DO_Ref,CAST(CAST(E.DO_Date AS DATE) AS VARCHAR(10)) AS DO_Date,E.DO_Tiers as CT_Num,CT_Intitule, ROUND(SUM(L.DL_MontantTTC),0) AS ttc, 
                 ISNULL(MAX(latitude),0) as latitude,ISNULL(MAX(longitude),0) as longitude,ISNULL(MAX(CASE WHEN E.N_CatCompta=0 THEN (C.N_CatCompta) ELSE (E.N_CatCompta) END),'0') N_CatCompta,ISNULL(sum(avance),0) AS avance  
                 FROM  F_DOCENTETE E 
                 LEFT JOIN (SELECT DO_Piece,DO_Type,DO_Domaine,DO_Ref,DO_Date,CT_Num,SUM(DL_MontantTTC) DL_MontantTTC FROM F_DOCLIGNE L GROUP BY DO_Piece,DO_Type,DO_Domaine,DO_Ref,DO_Date,CT_Num) L on E.DO_Piece=L.DO_Piece  AND E.DO_Domaine= L.DO_Domaine AND E.DO_Type=L.DO_Type
                 INNER JOIN F_DOCREGL R on R.cbDO_Piece=E.cbDO_Piece  
                 INNER JOIN F_DEPOT D on D.DE_No=E.DE_No 
                 INNER JOIN F_COMPTET C on C.cbCT_Num=E.cbDO_Tiers
                 LEFT JOIN (SELECT DR_No, SUM(RC_MONTANT) avance 
                             FROM F_REGLECH R 
                             INNER JOIN F_Creglement Re 
                             on Re.RG_No=R.RG_No GROUP BY DR_No) A 
                 ON A.DR_No=R.DR_No  
                 WHERE E.DO_Domaine=0 AND E.DO_Type=6 AND DO_Provenance = 0 
                  AND r.dr_regle=0 and E.CO_No = $co_no  AND C.CT_Num = '$ct_num'
                GROUP BY E.cbMarq,DE_Intitule,E.DO_Piece,E.DO_Ref,E.DO_Date,E.DO_Tiers,CT_Intitule
                    ORDER BY E.cbMarq ";
        return $requete;
    }


    public function getFactureRGNo($rg_no){
        return "SELECT E.cbMarq,DE_Intitule,L.DO_Piece,L.DO_Ref,CAST(CAST(L.DO_Date AS DATE) AS VARCHAR(10)) AS DO_Date,CO.CT_Num,CT_Intitule, ROUND(SUM(L.DL_MontantTTC),0) AS ttc, 
                ISNULL(sum(avance),0) AS avance  
                FROM F_CREGLEMENT C
                INNER JOIN (SELECT RG_No,DO_Piece,DO_Domaine,DO_Type, SUM(RC_MONTANT) avance FROM F_REGLECH R GROUP BY RG_No,DO_Piece,DO_Domaine,DO_Type) R ON C.RG_No=R.RG_No 
                LEFT JOIN (SELECT cbMarq,DO_Piece,DO_Type,DO_Domaine,DE_No,DO_Ref,DO_Date,DO_Tiers FROM F_DOCENTETE  GROUP BY cbMarq,DO_Piece,DO_Type,DO_Domaine,DE_No,DO_Ref,DO_Date,DO_Tiers) E on R.DO_Piece=E.DO_Piece  AND R.DO_Domaine= E.DO_Domaine AND R.DO_Type=E.DO_Type
                LEFT JOIN (SELECT DO_Piece,DO_Type,DO_Domaine,DE_No,DO_Ref,DO_Date,CT_Num,SUM(DL_MontantTTC) DL_MontantTTC FROM F_DOCLIGNE L GROUP BY DO_Piece,DO_Type,DO_Domaine,DE_No,DO_Ref,DO_Date,CT_Num) L on R.DO_Piece=L.DO_Piece  AND R.DO_Domaine= L.DO_Domaine AND R.DO_Type=L.DO_Type
                LEFT JOIN F_COMPTET CO on CO.CT_Num=L.CT_Num
                LEFT JOIN F_DEPOT D on D.DE_No=(CASE WHEN L.DE_No=0 THEN E.DE_No ELSE L.DE_No END)
                WHERE C.RG_No=$rg_no
                GROUP BY E.cbMarq,DE_Intitule,L.DO_Piece,L.DO_Ref,L.DO_Date,CO.CT_Num,CT_Intitule
                UNION
                SELECT 0 cbMarq,'' AS DE_Intitule,'' AS DO_Piece,RG_Libelle AS DO_Ref,CAST(CAST(RG_Date AS DATE) AS VARCHAR(10)) AS DO_Date,CT_NumPayeur CT_Num,'' CT_Intitule, RG_Montant AS ttc,0 AS avance 
                FROM [dbo].[Z_RGLT_BONDECAISSE] A
                INNER JOIN F_CREGLEMENT B ON A.RG_No=B.RG_No
                WHERE RG_No_RGLT=$rg_no";
    }

    public function addDocligneEntreeMagasinProcess($AR_Ref, $DO_Piece, $DL_Qte, $MvtStock, $DE_No,$mvtEntree,$prix,$login,$type_fac,$machine) {
        $AR_PrixAch = 0;
        $AR_Design = "";
        $AR_PrixVen = 0;
        $montantHT = 0;
        $AR_UniteVen = 0;
        $U_Intitule = "";
        $DO_Date = "";
        $DO_Domaine="";
        $DO_Type="";
        $result = $this->db->requete($this->getArticleByARRef($AR_Ref));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if ($rows != null) {
            $AR_Design = str_replace("'","''",$rows[0]->AR_Design);
            $AR_Ref = $rows[0]->AR_Ref;
            if($mvtEntree==1){
                $AR_PrixAch = $rows[0]->AR_PrixAch;
                $AR_PrixVen = $rows[0]->AR_PrixVen;
                if($AR_PrixVen=="") $AR_PrixVen=0;
                if($AR_PrixAch=="") $AR_PrixAch=0;
            }else $AR_PrixAch=$prix;
            $AR_UniteVen = $rows[0]->AR_UniteVen;
            $montantHT = ROUND($AR_PrixAch * $DL_Qte, 2);
            $DL_PUTTC = $montantHT;
            if($type_fac=="Transfert")
                $DL_PUTTC = round($AR_PrixAch);
            $result = $this->db->requete($this->getUnite($AR_UniteVen));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if ($rows != null) {
                $U_Intitule = $rows[0]->U_Intitule;
            }
            $result = $this->db->requete($this->getEnteteByDOPieceDOType($DO_Piece,2,20));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if ($rows != null) {
                $DO_Date = $rows[0]->DO_DateC;
                $do_ref = $rows[0]->DO_Ref;
                $DO_Domaine = $rows[0]->DO_Domaine;
                $DO_Type = $rows[0]->DO_Type;
                $result = $this->db->requete($this->insertDocligneEntreeMagasin($DO_Domaine,$DO_Type,$DE_No, $DO_Piece, $DO_Date, $AR_Ref, $AR_Design, $DL_Qte, $do_ref, $AR_PrixAch, $MvtStock, $U_Intitule, $DE_No, $montantHT, "", $login,$type_fac,$DL_PUTTC,$machine));
                $result = $this->db->requete($this->getLigneFactureDernierElement($DO_Piece));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                return json_encode($rows);
            }
        }
    }

    public function insertDocligneEntreeMagasin($do_domaine,$do_type,$ct_num, $do_piece, $do_date, $ar_ref, $ar_design, $dl_qte, $do_ref, $ar_prixach, $mvtstock, $u_intitule, $de_no, $montantht, $ca_num,$login,$type_fac,$machine) {
        $requete = "INSERT INTO [dbo].[F_DOCLIGNE]" .
            "    ([DO_Domaine], [DO_Type], [CT_Num], [DO_Piece], [DL_PieceBC], [DL_PieceBL], [DO_Date], [DL_DateBC]" .
            "    , [DL_DateBL], [DL_Ligne], [DO_Ref], [DL_TNomencl], [DL_TRemPied], [DL_TRemExep], [AR_Ref], [DL_Design]" .
            "    , [DL_Qte], [DL_QteBC], [DL_QteBL], [DL_PoidsNet], [DL_PoidsBrut], [DL_Remise01REM_Valeur], [DL_Remise01REM_Type], [DL_Remise02REM_Valeur]" .
            "    , [DL_Remise02REM_Type], [DL_Remise03REM_Valeur], [DL_Remise03REM_Type], [DL_PrixUnitaire]" .
            "    , [DL_PUBC], [DL_Taxe1], [DL_TypeTaux1], [DL_TypeTaxe1], [DL_Taxe2], [DL_TypeTaux2], [DL_TypeTaxe2], [CO_No]" .
            "    , [cbCO_No], [AG_No1], [AG_No2], [DL_PrixRU], [DL_CMUP], [DL_MvtStock], [DT_No], [cbDT_No]" .
            "    , [AF_RefFourniss], [EU_Enumere], [EU_Qte], [DL_TTC], [DE_No], [cbDE_No], [DL_NoRef], [DL_TypePL]" .
            "    , [DL_PUDevise], [DL_PUTTC], [DL_No], [DO_DateLivr], [CA_Num], [DL_Taxe3], [DL_TypeTaux3], [DL_TypeTaxe3]" .
            "    , [DL_Frais], [DL_Valorise], [AR_RefCompose], [DL_NonLivre], [AC_RefClient], [DL_MontantHT], [DL_MontantTTC], [DL_FactPoids]" .
            "    , [DL_Escompte], [DL_PiecePL], [DL_DatePL], [DL_QtePL], [DL_NoColis], [DL_NoLink], [cbDL_NoLink], [RP_Code]" .
            "    , [DL_QteRessource], [DL_DateAvancement], [cbProt], [cbCreateur], [cbModification], [cbReplication], [cbFlag],[USERGESCOM],[DATEMODIF])" .
            "VALUES" .
            "    (/*DO_Domaine*/$do_domaine,/*DO_Type*/$do_type,/*CT_Num*/'" . $ct_num . "',/*DO_Piece*/'" . $do_piece . "'" .
            "    ,/*DL_PieceBC*/'',/*DL_PieceBL*/'',/*DO_Date*/'" . $do_date . "',/*DL_DateBC*/'1900-01-01'" .
            "    ,/*DL_DateBL*/'" . $do_date . "',/*DL_Ligne*/ (SELECT (1+COUNT(*))*10000 FROM F_DOCLIGNE WHERE DO_PIECE='" . $do_piece . "' AND DO_Domaine=$do_domaine AND DO_Type=$do_type),/*DO_Ref*/'" . $do_ref . "',/*DL_TNomencl*/0" .
            "    ,/*DL_TRemPied*/0,/*DL_TRemExep*/0,/*AR_Ref*/'" . $ar_ref . "',/*DL_Design*/'" . $ar_design . "'" .
            "   ,/*DL_Qte*/" . $dl_qte . ",/*DL_QteBC*/" . $dl_qte . ",/*DL_QteBL*/0,/*DL_PoidsNet*/0" .
            "    ,/*DL_PoidsBrut*/0,/*DL_Remise01REM_Valeur*/0" .
            "    ,/*DL_Remise01REM_Type*/0,/*DL_Remise02REM_Valeur*/0" .
            "    ,/*DL_Remise02REM_Type*/0,/*DL_Remise03REM_Valeur*/0" .
            "   ,/*DL_Remise03REM_Type*/0,/*DL_PrixUnitaire*/" . $ar_prixach .
            "    ,/*DL_PUBC*/0,/*DL_Taxe1*/0,/*DL_TypeTaux1*/0,/*DL_TypeTaxe1*/0,/*DL_Taxe2*/0,/*DL_TypeTaux2*/0" .
            "    ,/*DL_TypeTaxe2*/0,/*CO_No*/0,/*cbCO_No*/NULL,/*AG_No1*/0" .
            "    ,/*AG_No2*/0,/*DL_PrixRU*/$ar_prixach,/*DL_CMUP*/$ar_prixach,/*DL_MvtStock*/'$mvtstock'" .
            "    ,/*DT_No*/0,/*cbDT_No*/NULL,/*AF_RefFourniss*/''" .
            "    ,/*EU_Enumere*/'$u_intitule',/*EU_Qte*/$dl_qte,/*DL_TTC*/0,/*DE_No*/'$de_no',/*cbDE_No*/'" . $de_no . "',/*DL_NoRef*/''" .
            "    ,/*DL_TypePL*/0,/*DL_PUDevise*/0" .
            "    ,/*DL_PUTTC*/$ar_prixach,/*DL_No*/ISNULL((SELECT MAX(DL_No) FROM F_DOCLIGNE),0)+1,/*DO_DateLivr*/'1900-01-01',/*CA_Num*/''" .
            "    ,/*DL_Taxe3*/0,/*DL_TypeTaux3*/0,/*DL_TypeTaxe3*/0," .
            "   /*DL_Frais*/0,/*DL_Valorise*/1,/*AR_RefCompose*/NULL" .
            "    ,/*DL_NonLivre*/0,/*AC_RefClient*/'',/*DL_MontantHT*/" . $montantht . ",/*DL_MontantTTC*/" . $montantht .
            "    ,/*DL_FactPoids*/0,/*DL_Escompte*/0,/*DL_PiecePL*/'',/*DL_DatePL*/'1900-01-01'" .
            "    ,/*DL_QtePL*/0,/*DL_NoColis*/'',/*DL_NoLink*/0,/*cbDL_NoLink*/NULL" .
            "    ,/*RP_Code*/NULL,/*DL_QteRessource*/0,/*DL_DateAvancement*/'1900-01-01',/*cbProt*/0" .
            "    ,/*cbCreateur*/'AND',/*cbModification*/GETDATE()" .
            "    ,/*cbReplication*/0,/*cbFlag*/0,/*USERGESCOM*/'$login',/*DATEMODIF*/GETDATE())";
        return $requete;
    }

    public function getCaisseDepotSouche($CA_No,$DE_No,$CA_Souche){
        return "SELECT C.CA_No,CA_Intitule,CA_Souche,D.DE_No,DE_Intitule
                FROM F_CAISSE C
                INNER JOIN F_DEPOT D ON C.DE_No=D.DE_No
                LEFT JOIN P_SOUCHEVENTE S ON S.cbindice=C.CA_Souche
                WHERE ('0'='$CA_No' OR CA_No IN ($CA_No))
                AND ('0'='$DE_No' OR C.DE_No IN ($DE_No))
                AND (0=$CA_Souche OR CA_Souche=$CA_Souche)";
    }


    public function allTiers() {
        return "SELECT CO_No,C.CT_Sommeil,C.CT_Intitule,0 AS CT_Type,CT_Num,CG_NumPrinc,N_CatTarif,N_CatCompta,P.CT_Intitule AS LibCatTarif,LibCatCompta,C.cbModification,
                CT_Adresse,CG_NumPrinc,CT_Telephone,CT_CodeRegion,CT_Ville,CT_Siret,CT_Identifiant,MR_No,DE_No,CA_Num
                FROM ".$this->db->baseCompta.".dbo.F_COMPTET C 
                 LEFT JOIN P_CATTARIF P ON P.cbIndice = C.N_CatTarif 
                 LEFT JOIN (select  row_number() over (order by u.subject) as idcompta, u.LibCatCompta 
                 from P_CATCOMPTA 
                 unpivot 
                       ( 
                        LibCatCompta 
                 for subject in (CA_ComptaVen01, CA_ComptaVen02, CA_ComptaVen03, CA_ComptaVen04, CA_ComptaVen05, CA_ComptaVen06, CA_ComptaVen07, CA_ComptaVen08, CA_ComptaVen09, CA_ComptaVen10, CA_ComptaVen11, CA_ComptaVen12, CA_ComptaVen13, CA_ComptaVen14, CA_ComptaVen15, CA_ComptaVen16, CA_ComptaVen17, CA_ComptaVen18, CA_ComptaVen19, CA_ComptaVen20, CA_ComptaVen21, CA_ComptaVen22)
                 ) u) M ON M.idcompta = C.N_CatCompta WHERE CT_Type=0
                UNION
                SELECT CO_No,C.CT_Sommeil,C.CT_Intitule,1 AS CT_Type,CT_Num,CG_NumPrinc,N_CatTarif,N_CatCompta,P.CT_Intitule AS LibCatTarif,LibCatCompta,C.cbModification,CT_Adresse,CG_NumPrinc,CT_Telephone,CT_CodeRegion,CT_Ville,CT_Siret,CT_Identifiant,MR_No,DE_No,CA_Num
                FROM ".$this->db->baseCompta.".dbo.F_COMPTET C
                LEFT JOIN P_CATTARIF P ON P.cbIndice = C.N_CatTarif 
                 LEFT JOIN (select  row_number() over (order by u.subject) as idcompta, u.LibCatCompta 
                 from P_CATCOMPTA 
                 unpivot 
                      ( 
                        LibCatCompta 
                        for subject in (CA_ComptaAch01, CA_ComptaAch02, CA_ComptaAch03, CA_ComptaAch04, CA_ComptaAch05, CA_ComptaAch06, CA_ComptaAch07, CA_ComptaAch08, CA_ComptaAch09, CA_ComptaAch10, CA_ComptaAch11, CA_ComptaAch12, CA_ComptaAch13, CA_ComptaAch14, CA_ComptaAch15, CA_ComptaAch16, CA_ComptaAch17, CA_ComptaAch18, CA_ComptaAch19, CA_ComptaAch20, CA_ComptaAch21, CA_ComptaAch22) 
                 ) u) M ON M.idcompta = C.N_CatCompta WHERE CT_Type=1
    ";
    }

    public function affichePDevise($value)
    {
        $result = $this->db->query($this->getDevise());
        $liste = $result->fetchAll(PDO::FETCH_OBJ);

        $html="";
        foreach ($liste as $row) {
            $html = $html ."<option value='".$row->cbIndice."'";
            if ($value == $row->cbIndice)
                $html." selected";
            $html = $html.">".$row->D_Intitule."</option>";
        }
        return $html;
    }

    public function selectDefautCompte($type){
        return "DECLARE @val NVARCHAR(10)
                SET @val = '$type'
                SELECT  *
                FROM    P_TIERS 
                WHERE T_Val01T_Intitule LIKE CONCAT(@val,'%') ";
    }


    public function allClientsByCT_Intitule($val) {
        return "SELECT C.CT_Intitule,CT_Num,CG_NumPrinc,N_CatTarif,N_CatCompta,P.CT_Intitule AS LibCatTarif,LibCatCompta FROM ".$this->db->baseCompta.".dbo.F_COMPTET C " .
            " LEFT JOIN P_CATTARIF P ON P.cbIndice = C.N_CatTarif " .
            " LEFT JOIN (select  row_number() over (order by u.subject) as idcompta, u.LibCatCompta " .
            " from P_CATCOMPTA " .
            " unpivot " .
            "       ( " .
            "        LibCatCompta " .
            " for subject in (CA_ComptaVen01, CA_ComptaVen02, CA_ComptaVen03, CA_ComptaVen04, CA_ComptaVen05, CA_ComptaVen06, CA_ComptaVen07, CA_ComptaVen08, CA_ComptaVen09, CA_ComptaVen10, CA_ComptaVen11, CA_ComptaVen12, CA_ComptaVen13, CA_ComptaVen14, CA_ComptaVen15, CA_ComptaVen16, CA_ComptaVen17, CA_ComptaVen18, CA_ComptaVen19, CA_ComptaVen20, CA_ComptaVen21, CA_ComptaVen22) " .
            " ) u) M ON M.idcompta = C.N_CatCompta"
            . " WHERE C.CT_Intitule like '%$val%' ";
    }

    public function clientsByCT_Num($code) {
        return "SELECT CT_Sommeil,MR_No,CO_No,CT_Adresse,CA_Num,CT_CodePostal,DE_No,CT_CodeRegion,CT_Ville,CT_Siret,CT_Identifiant,CT_Telephone,C.CT_Intitule, CT_Num, CG_NumPrinc, N_CatTarif, N_CatCompta, P.CT_Intitule AS LibCatTarif, LibCatCompta 
                FROM ".$this->db->baseCompta.".dbo.F_COMPTET C 
                 LEFT JOIN P_CATTARIF P ON P.cbIndice = C.N_CatTarif 
                 LEFT JOIN (select  row_number() over (order by u.subject) as idcompta, u.LibCatCompta 
                 from P_CATCOMPTA 
                 unpivot 
                       ( 
                        LibCatCompta 
                 for subject in (CA_ComptaVen01, CA_ComptaVen02, CA_ComptaVen03, CA_ComptaVen04, CA_ComptaVen05, CA_ComptaVen06, CA_ComptaVen07, CA_ComptaVen08, CA_ComptaVen09, CA_ComptaVen10, CA_ComptaVen11, CA_ComptaVen12, CA_ComptaVen13, CA_ComptaVen14, CA_ComptaVen15, CA_ComptaVen16, CA_ComptaVen17, CA_ComptaVen18, CA_ComptaVen19, CA_ComptaVen20, CA_ComptaVen21, CA_ComptaVen22) 
                 ) u) M ON M.idcompta = C.N_CatCompta 
                 WHERE CT_Num ='" . $code . "' ";
    }

    public function envoiSms($telephone,$message){
        $url = 'http://lmtgroup.dyndns.org/sendsms/sendsmsGold.php?';

        $contactD = new ContatDClass(1);

        $username='itsolutions';
        $source='ITSOLUTIONS';
        $mdp='it!@sol145';
        if($contactD->CD_No!=""){
            $username = $contactD->CD_Nom;
            $mdp = $contactD->CD_Prenom;
            $source = $contactD->CD_Fonction;
        }
        $destination=$telephone;//'695975180';
        sendSms($url, $username,$destination,$source,$message,$mdp);
    }


    public function getInfoRAFDG(){
        return"SELECT CO_No,CO_Nom,CO_EMail,CO_Telephone,PROT_User
                FROM ( SELECT P.* FROM F_PROTECTIONCIAL P 
                LEFT JOIN (SELECT PROT_No FROM F_PROTECTIONCIAL WHERE PROT_User='RAF') A ON A.PROT_No=P.PROT_UserProfil 
                LEFT JOIN (SELECT PROT_No FROM F_PROTECTIONCIAL WHERE PROT_User='DG') B ON B.PROT_No=P.PROT_UserProfil  
                LEFT JOIN (SELECT PROT_No FROM F_PROTECTIONCIAL WHERE PROT_User='DG') C ON C.PROT_No=P.PROT_No
                WHERE A.PROT_No IS NOT NULL 
                OR 
                B.PROT_No IS NOT NULL
                OR 
                C.PROT_No IS NOT NULL
                ) A 
                INNER JOIN F_COLLABORATEUR C ON C.CO_Nom = A.PROT_User";
    }

    public function insertZ_RGLT_BONDECAISSE($RG_No,$RG_NoLier){
        $requete ="INSERT INTO [dbo].[Z_RGLT_BONDECAISSE] VALUES ($RG_No,$RG_NoLier)";
        return $requete;
    }

    public function getInfoRAFControleur(){
        return"SELECT CO_No,CO_Nom,CO_Prenom,CO_EMail,CO_Telephone,PROT_User
                FROM ( SELECT P.* FROM F_PROTECTIONCIAL P 
                LEFT JOIN (SELECT PROT_No FROM F_PROTECTIONCIAL WHERE PROT_User='RAF') A ON A.PROT_No=P.PROT_UserProfil 
                WHERE A.PROT_No IS NOT NULL 
                ) A 
                INNER JOIN ".$this->db->baseCompta.".dbo.F_COLLABORATEUR C ON C.CO_Nom = A.PROT_User";
    }

    public function getCollaborateurEnvoiMail($intitule){
        return "SELECT CO_No,CO_Nom,CO_Prenom,CO_EMail,CO_Telephone,PROT_User
                FROM [Z_LiaisonEnvoiMailUser] A
                INNER JOIN F_PROTECTIONCIAL B 
                    ON A.PROT_No=B.PROT_No
                INNER JOIN F_COLLABORATEUR C 
                    ON C.CO_Nom=B.PROT_User
                INNER JOIN [dbo].[Z_TypeEnvoiMail] D 
                    ON D.TE_No=A.TE_No
                WHERE TE_Intitule='$intitule'";
    }
    public function getCollaborateurEnvoiSMS($intitule){
        return "SELECT CO_No,CO_Nom,CO_Prenom,CO_EMail,CO_Telephone,PROT_User
                FROM [Z_LiaisonEnvoiSMSUser] A
                INNER JOIN F_PROTECTIONCIAL B 
                    ON A.PROT_No=B.PROT_No
                INNER JOIN F_COLLABORATEUR C 
                    ON C.CO_Nom=B.PROT_User
                INNER JOIN [dbo].[Z_TypeEnvoiMail] D 
                    ON D.TE_No=A.TE_No
                WHERE TE_Intitule='$intitule'";
    }


    public function getP_Unite(){
        return "SELECT cbIndice,U_Intitule
                FROM P_UNITE
                WHERE U_Intitule<>''";
    }
    public function getInfoRAFDGCommerciaux(){
        return"SELECT CO_No,CO_Nom,CO_EMail,CO_Telephone,PROT_User
                FROM ( SELECT P.* FROM F_PROTECTIONCIAL P 
                LEFT JOIN (SELECT PROT_No FROM F_PROTECTIONCIAL WHERE PROT_User='RAF') A ON A.PROT_No=P.PROT_UserProfil 
                LEFT JOIN (SELECT PROT_No FROM F_PROTECTIONCIAL WHERE PROT_User='DG') B ON B.PROT_No=P.PROT_UserProfil  
                LEFT JOIN (SELECT PROT_No FROM F_PROTECTIONCIAL WHERE PROT_User='DG') C ON C.PROT_No=P.PROT_No
                LEFT JOIN (SELECT PROT_No FROM F_PROTECTIONCIAL WHERE PROT_User='COMMERCIAUX') D ON D.PROT_No=P.PROT_UserProfil
                WHERE A.PROT_No IS NOT NULL 
                OR 
                B.PROT_No IS NOT NULL
                OR 
                C.PROT_No IS NOT NULL
                OR 
                D.PROT_No IS NOT NULL
                ) A 
                INNER JOIN ".$this->db->baseCompta.".dbo.F_COLLABORATEUR C ON C.CO_Nom = A.PROT_User";
    }

    public function lastLigneBycbMarqTrsftDetail($cbMarq,$id_sec){
        return "SELECT *
FROM(SELECT cbMarq AS cbMarq_prem,DO_Piece,AR_Ref,DL_Design,DL_Qte,DL_CMUP,DL_MontantHT,DL_PrixUnitaire,DL_MontantTTC
	FROM F_DOCLIGNE A
	WHERE cbMarq =$cbMarq)A
LEFT JOIN (SELECT cbMarq,DO_Piece AS DO_Piece_Dest,DL_PrixUnitaire AS DL_PrixUnitaire_Dest,AR_Ref AS AR_Ref_Dest,DL_Design AS DL_Design_Dest,DL_Qte AS DL_Qte_Dest,DL_CMUP AS DL_CMUP_Dest,
			DL_MontantHT AS DL_MontantHT_Dest,DL_MontantTTC AS DL_MontantTTC_Dest
			FROM  F_DOCLIGNE
			WHERE cbMarq =$id_sec) B ON DO_Piece = DO_Piece_Dest";
    }

    public function lastDOPieceByDE_No($de_no) {
        return "SELECT * FROM F_DOCENTETE WHERE cbMarq=(SELECT Max(cbmarq) FROM F_DOCENTETE WHERE  DE_No='$de_no')";
    }

    public function ValideSaisie_comptable($do_domaine,$do_type,$do_piece) {
        return "UPDATE F_DOCLIGNE SET DO_Type=17 WHERE DO_Domaine=$do_domaine and DO_Type=$do_type and DO_Piece='$do_piece';
                UPDATE F_DOCENTETE SET DO_Type=17 WHERE DO_Domaine=$do_domaine and DO_Type=$do_type and DO_Piece='$do_piece';";
    }

    public function getArticleByARRef($ar_ref) {
        return " SELECT A.*
                FROM F_ARTICLE A
                WHERE A.AR_Ref='" . $ar_ref . "'";
    }

    public function getFamilleByCode($code) {
        return "SELECT * FROM F_FAMILLE WHERE FA_CodeFamille='" . $code . "'";
    }

    public function getCollaborateur($type) {
        return "SELECT CO_No, CO_Nom FROM ".$this->db->baseCompta.".dbo.f_collaborateur WHERE CO_ACHETEUR=$type AND CO_Vendeur=1 ORDER BY CO_Nom";
    }

    public function getCollaborateurCount() {
        return "SELECT COUNT(*) Nb, MAX(cbModification)cbModification
                f_collaborateur";
    }

    public function getEnteteDocument($do_domaine,$do_type,$do_souche,$type_fac){
        $do_domaine_doc = 0;
        $do_doccurenttype=$do_type;
        if ($do_souche == "") $do_souche = 0;
        if ($type_fac == "Achat") {
            $do_domaine_doc = 1;
            $do_doccurenttype = 6;
        }
        if ($type_fac == "AchatPreparationCommande") {
            $do_domaine_doc = 1;
            $do_doccurenttype = 6;
        }
        if ($type_fac == "PreparationCommande") {
            $do_domaine_doc = 1;
            $do_doccurenttype = 1;
        }
        if ($type_fac == "Transfert_detail") {
            $do_domaine_doc = 4;
            $do_domaine=4;
            $do_type=41;
            $do_doccurenttype = 1;
        }

        if ($type_fac == "Entree") {
            $do_domaine_doc = 2;
            $do_type_doc = 0;
            $do_doccurenttype = 0;
        }
        if ($type_fac == "Sortie") {
            $do_domaine_doc = 2;
            $do_type_doc = 0;
            $do_doccurenttype = 1;
        }
        if ($type_fac == "Transfert") {
            $do_domaine_doc = 2;
            $do_doccurenttype = 3;
        }
        if ($type_fac == "VenteRetour") {
            $do_doccurenttype = 7;
        }
        $result = $this->db->requete($this->getEnteteTable($do_domaine_doc, $do_souche, $do_doccurenttype));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if ($rows != null) {
            $do_piece = $this->getEnteteDispo($do_domaine, $do_type, $rows[0]->DC_Piece);
        }
        return $do_piece;
    }

    public function getEnteteByDOPiece($do_piece,$DO_Domaine,$DO_Type) {
        return "SELECT *,CONVERT(char(10), CAST(DO_Date AS DATE),126) AS DO_DateC 
                FROM F_DOCENTETE 
                WHERE DO_Piece='" . $do_piece . "' AND DO_Domaine=$DO_Domaine AND (($DO_Type=6 AND (DO_Type IN(6,7))) OR ($DO_Type=16 AND (DO_Type IN(16,17))) OR (DO_Type NOT IN (16,6) AND $DO_Type=DO_Type )) ";
    }

    public function getEnteteTicketByDOPiece($DO_Domaine,$DO_Type) {
        return "SELECT ISNULL(Max(DO_Piece),0) DO_Piece 
                FROM(
                SELECT CAST(DO_Piece AS INT) AS DO_Piece
                FROM F_DOCENTETE 
                WHERE DO_Domaine=$DO_Domaine AND DO_Type = $DO_Type
                UNION
                SELECT TA_Piece AS DO_Piece
                FROM F_TICKETARCHIVE)A";
    }

    public function getEnteteByDOPieceDOType($do_piece,$do_domaine,$do_type) {
        return "SELECT *,CONVERT(char(10), CAST(DO_Date AS DATE),126) AS DO_DateC FROM F_DOCENTETE WHERE DO_Domaine=$do_domaine AND DO_Type = $do_type AND DO_Piece='$do_piece'";
    }

    public function getReglementByClient($ct_num,$ca_no,$type,$treglement,$datedeb,$datefin,$caissier,$collab,$typeSelectRegl=0) {
        $query= "    SELECT CASE WHEN ABS(DATEDIFF(d,GETDATE(),C.RG_Date))>= (select PR_DelaiPreAlert
                from P_PREFERENCES) THEN 1 ELSE 0 END DO_Modif,C.JO_Num,C.CO_NoCaissier
         ,C.CT_NumPayeur,C.CG_Num,RG_Piece,ISNULL(RC_Montant,0) AS RC_Montant,C.RG_No,CAST(RG_Date as date) RG_Date
         ,RG_Libelle,RG_Montant,C.CA_No,C.CO_NoCaissier,ISNULL(CO_Nom,'')CO_Nom,ISNULL(CA_Intitule,'')CA_Intitule
         ,RG_Impute,RG_TypeReg,N_Reglement,cbCreateur = pr.PROT_User
                    FROM F_CREGLEMENT C
                    LEFT JOIN F_CAISSE CA ON CA.CA_No=C.CA_No 
                    LEFT JOIN F_COLLABORATEUR CO ON C.CO_NoCaissier = CO.CO_No
                    LEFT JOIN F_PROTECTIONCIAL pr ON CAST(pr.PROT_No AS NVARCHAR(50)) = c.cbCreateur
                    LEFT JOIN (	SELECT A.RG_No,RC_Montant + ISNULL(RG_Montant,0) AS RC_Montant
                                FROM(	SELECT RG_No,sum(RC_Montant) AS RC_Montant 
                                        FROM F_REGLECH
                                        GROUP BY RG_No)A
                                LEFT JOIN Z_RGLT_BONDECAISSE B ON A.RG_No = B.RG_No_RGLT
                                LEFT JOIN F_CREGLEMENT C ON C.RG_No = B.RG_No  
                                ) R ON R.RG_No=c.RG_No
			        WHERE 
			        $typeSelectRegl = RG_Type AND RG_Date BETWEEN '$datedeb' AND '$datefin' AND (-1=$type OR RG_Impute=$type)
                    AND ((''='$ct_num' AND ct_numpayeur IS NOT NULL) OR ct_numpayeur = '$ct_num' OR ('1'=$collab AND C.CO_NoCaissier='$ct_num'))
                    AND (((0=$treglement OR N_Reglement=$treglement) AND (($collab = 1 AND RG_Banque=3) OR ($collab = 0))
                    AND ('0'=$ca_no OR CA.CA_No=$ca_no)) OR ('0'<>$ca_no AND C.CO_NoCaissier=$caissier AND N_Reglement='05') )
                    ORDER BY C.RG_No";
        return $query;
    }

    public function convertTransToRegl($ca_no,$co_no,$jo_num,$rg_no){
        return"UPDATE F_CREGLEMENT SET CA_No=$ca_no,cbModification=GETDATE(),JO_Num='$jo_num',cbCA_No=$ca_no,CO_NoCaissier=$co_no,cbCO_NoCaissier=$co_no WHERE RG_No=$rg_no";
    }

    public function updateCaratTrsft($cbMarq){
        $query = "UPDATE F_DOCLIGNE SET carat=".$this->carat." WHERE cbMarq = $cbMarq";
        $this->db->requete($query);
    }
    public function getUnite($AR_UniteVen) {
        return "SELECT * FROM P_UNITE WHERE cbIndice='$AR_UniteVen'";
    }

    public function getDoPiece($dopiece,$do_domaine,$do_type) {
        return "SELECT DO_Statut,DO_Type,DO_Domaine,DO_Coord03,Latitude,Longitude,CA_Num,E.cbMarq,DO_Souche,DO_Piece,DO_Ref,DO_Tiers,DE_Intitule,E.DE_No,CAST(DO_Date as DATE) DO_Date,CO_No,DO_Tarif,DO_Souche,N_CatCompta,CA_No
                FROM F_DOCENTETE E
                LEFT JOIN F_DEPOT D ON E.DE_No = D.DE_No
                WHERE DO_Piece='$dopiece' AND DO_Domaine=$do_domaine AND DO_Type=$do_type";
    }

    public function getCatCompta() {
        return "select  row_number() over (order by u.subject) as idcompta,u.marks
            from P_CATCOMPTA
            unpivot
            (
              marks
              for subject in (CA_ComptaVen01, CA_ComptaVen02,CA_ComptaVen03,CA_ComptaVen04,CA_ComptaVen05,CA_ComptaVen06,CA_ComptaVen07,CA_ComptaVen08,CA_ComptaVen09,CA_ComptaVen10,CA_ComptaVen11,CA_ComptaVen12,CA_ComptaVen13,CA_ComptaVen14,CA_ComptaVen15,CA_ComptaVen16,CA_ComptaVen17,CA_ComptaVen18,CA_ComptaVen19,CA_ComptaVen20,CA_ComptaVen21,CA_ComptaVen22)
            ) u
            WHERE marks<>''";
    }
    public function getDevise() {
        return "SELECT D_Intitule,D_Format,cbIndice
                FROM P_DEVISE
                WHERE D_Intitule<>''";
    }

    public function getCatComptaAll(){
        return "select  row_number() over (order by u.subject) as idcompta,u.marks,1 AS Type
                from P_CATCOMPTA
                unpivot
                (
                  marks
                  for subject in (CA_ComptaAch01, CA_ComptaAch02,CA_ComptaAch03,CA_ComptaAch04,CA_ComptaAch05,CA_ComptaAch06,CA_ComptaAch07,CA_ComptaAch08,CA_ComptaAch09,CA_ComptaAch10,CA_ComptaAch11,CA_ComptaAch12,CA_ComptaAch13,CA_ComptaAch14,CA_ComptaAch15,CA_ComptaAch16,CA_ComptaAch17,CA_ComptaAch18,CA_ComptaAch19,CA_ComptaAch20,CA_ComptaAch21,CA_ComptaAch22)
                ) u WHERE marks<>''
                union
                select  row_number() over (order by u.subject) as idcompta,u.marks,0 AS Type
                from P_CATCOMPTA
                unpivot
                (
                  marks
                  for subject in (CA_ComptaVen01, CA_ComptaVen02,CA_ComptaVen03,CA_ComptaVen04,CA_ComptaVen05,CA_ComptaVen06,CA_ComptaVen07,CA_ComptaVen08,CA_ComptaVen09,CA_ComptaVen10,CA_ComptaVen11,CA_ComptaVen12,CA_ComptaVen13,CA_ComptaVen14,CA_ComptaVen15,CA_ComptaVen16,CA_ComptaVen17,CA_ComptaVen18,CA_ComptaVen19,CA_ComptaVen20,CA_ComptaVen21,CA_ComptaVen22)
                ) u
                WHERE marks<>''
                ";
    }

    public function getCatComptaByArRef($AR_Ref,$ACP_Champ,$ACP_Type){
        return "SELECT ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.ACP_Champ ELSE B.ACP_Champ END,0) ACP_Champ,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.CG_Num ELSE B.CG_Num END,'') CG_Num,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.CG_Intitule ELSE B.CG_Intitule END,'') CG_Intitule,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.CG_NumA ELSE B.CG_NumA END,'') CG_NumA,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.CG_IntituleA ELSE B.CG_IntituleA END,'') CG_IntituleA,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.Taxe1 ELSE B.Taxe1 END,'') Taxe1,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.TA_Intitule1 ELSE B.TA_Intitule1 END,'') TA_Intitule1,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.Taxe2 ELSE B.Taxe2 END,'') Taxe2,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.TA_Intitule2 ELSE B.TA_Intitule2 END,'') TA_Intitule2,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.Taxe3 ELSE B.Taxe3 END,'') Taxe3,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.TA_Intitule3 ELSE B.TA_Intitule3 END,'') TA_Intitule3,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.TA_Taux1 ELSE B.TA_Taux1 END,0) TA_Taux1,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.TA_Taux2 ELSE B.TA_Taux2 END,0) TA_Taux2,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.TA_Taux3 ELSE B.TA_Taux3 END,0) TA_Taux3
                FROM (
                SELECT  A.FA_CodeFamille,FCP_Type ACP_Type,AR_Ref,FCP_Champ ACP_Champ
                        ,FCP_ComptaCPT_CompteG CG_Num,CG.CG_Intitule,FCP_ComptaCPT_CompteA CG_NumA
                        ,CA.CG_Intitule CG_IntituleA,FCP_ComptaCPT_Taxe1 Taxe1,TU.TA_Intitule TA_Intitule1
                        ,TU.TA_Taux TA_Taux1,FCP_ComptaCPT_Taxe2 Taxe2,TD.TA_Intitule TA_Intitule2
                        ,TD.TA_Taux TA_Taux2,FCP_ComptaCPT_Taxe3 Taxe3,TT.TA_Intitule TA_Intitule3
                        ,TT.TA_Taux TA_Taux3
                FROM    F_FAMCOMPTA A 
                INNER JOIN F_ARTICLE AR 
                    ON AR.FA_CodeFamille = A.FA_CodeFamille
                LEFT JOIN F_TAXE TU 
                    ON A.FCP_ComptaCPT_Taxe1 = TU.TA_Code
                LEFT JOIN F_TAXE TD 
                    ON A.FCP_ComptaCPT_Taxe2 = TD.TA_Code
                LEFT JOIN F_TAXE TT 
                    ON A.FCP_ComptaCPT_Taxe3 = TT.TA_Code
                LEFT JOIN F_COMPTEG CG 
                    ON A.FCP_ComptaCPT_CompteG = CG.CG_Num
                LEFT JOIN F_COMPTEG CA 
                    ON A.FCP_ComptaCPT_CompteA = CA.CG_Num) A
                LEFT JOIN (SELECT A.AR_Ref,ACP_Type,FA_CodeFamille,ACP_Champ,ACP_ComptaCPT_CompteG CG_Num,CG.CG_Intitule,ACP_ComptaCPT_CompteA CG_NumA,CA.CG_Intitule CG_IntituleA,ACP_ComptaCPT_Taxe1 Taxe1,TU.TA_Intitule TA_Intitule1,TU.TA_Taux TA_Taux1
                ,ACP_ComptaCPT_Taxe2 Taxe2,TD.TA_Intitule TA_Intitule2,TD.TA_Taux TA_Taux2,ACP_ComptaCPT_Taxe3 Taxe3,TT.TA_Intitule TA_Intitule3,TT.TA_Taux TA_Taux3
                FROM F_ARTCOMPTA A 
                INNER JOIN F_ARTICLE AR 
                    ON AR.AR_Ref = A.AR_Ref
                LEFT JOIN F_TAXE TU 
                    ON A.ACP_ComptaCPT_Taxe1 = TU.TA_Code
                LEFT JOIN F_TAXE TD 
                    ON A.ACP_ComptaCPT_Taxe2 = TD.TA_Code
                LEFT JOIN F_TAXE TT 
                    ON A.ACP_ComptaCPT_Taxe3 = TT.TA_Code
                LEFT JOIN F_COMPTEG CG 
                    ON A.ACP_ComptaCPT_CompteG = CG.CG_Num
                LEFT JOIN F_COMPTEG CA 
                    ON A.ACP_ComptaCPT_CompteA = CA.CG_Num)B 
                    ON  A.FA_CodeFamille=B.FA_CodeFamille 
                    AND A.AR_Ref=B.AR_Ref 
                    AND A.ACP_Champ=B.ACP_Champ 
                    AND A.ACP_Type=B.ACP_Type
                WHERE A.AR_Ref='$AR_Ref'
                AND A.ACP_Type=$ACP_Type
                AND A.ACP_Champ=$ACP_Champ";
    }

    public function getCatComptaByCodeFamille($CodeFamille,$ACP_Champ,$ACP_Type){
        return "SELECT A.FA_CodeFamille,FCP_Type ACP_Type,FCP_Champ ACP_Champ,ISNULL(FCP_ComptaCPT_CompteG,'') CG_Num,ISNULL(CG.CG_Intitule,'') CG_Intitule,
                ISNULL(FCP_ComptaCPT_CompteA,'') CG_NumA,ISNULL(CA.CG_Intitule,'') CG_IntituleA,
                ISNULL(FCP_ComptaCPT_CompteA,'')CG_NumA,ISNULL(FCP_ComptaCPT_Taxe1,'') Taxe1,
                ISNULL(TU.TA_Intitule,'') TA_Intitule1,ISNULL(TU.TA_Taux,0) TA_Taux1
                ,ISNULL(FCP_ComptaCPT_Taxe2,'') Taxe2,ISNULL(TD.TA_Intitule,'') TA_Intitule2,ISNULL(TD.TA_Taux,0) TA_Taux2,
                ISNULL(FCP_ComptaCPT_Taxe3,'') Taxe3,ISNULL(TT.TA_Intitule,'') TA_Intitule3,ISNULL(TT.TA_Taux,0) TA_Taux3
                FROM F_FAMCOMPTA A 
                LEFT JOIN F_TAXE TU ON A.FCP_ComptaCPT_Taxe1 = TU.TA_Code
                LEFT JOIN F_TAXE TD ON A.FCP_ComptaCPT_Taxe2 = TD.TA_Code
                LEFT JOIN F_TAXE TT ON A.FCP_ComptaCPT_Taxe3 = TT.TA_Code
                LEFT JOIN F_COMPTEG CG ON A.FCP_ComptaCPT_CompteG = CG.CG_Num
                LEFT JOIN F_COMPTEG CA ON A.FCP_ComptaCPT_CompteA = CA.CG_Num
                WHERE A.FA_CodeFamille='$CodeFamille'
                AND A.FCP_Type=$ACP_Type
                AND A.FCP_Champ=$ACP_Champ";
    }

    public function modifClientUpdateCANum($ct_num,$CA_Num) {
        $requete = "UPDATE [F_COMPTET] SET CA_Num=(CASE WHEN '$CA_Num'='' THEN NULL ELSE '$CA_Num' END),cbModification=GETDATE(),
            N_Analytique=(CASE WHEN '$CA_Num'='' THEN NULL ELSE (SELECT N_Analytique FROM F_COMPTEA WHERE CA_Num='$CA_Num') END),
            cbN_Analytique=(CASE WHEN '$CA_Num'='' THEN NULL ELSE (SELECT N_Analytique FROM F_COMPTEA WHERE CA_Num='$CA_Num') END)
            WHERE CT_Num='$ct_num'";
        return $requete;
    }

    public function createFLivraison($ct_num,$ct_intitule,$adresse,$ct_complement,$ct_codepostal,$ct_ville,$ct_coderegion,$expedition,$condition,$ct_telecopie,$ct_email,$ct_pays,$ct_contact,$ct_telephone){
        $requete="INSERT INTO ".$this->db->baseCompta.".[dbo].[F_LIVRAISON]
                    ([LI_No],[CT_Num],[LI_Intitule],[LI_Adresse]
		   ,[LI_Complement],[LI_CodePostal],[LI_Ville],[LI_CodeRegion],[LI_Pays],[LI_Contact]
                    ,[N_Expedition],[N_Condition],[LI_Principal],[LI_Telephone]
                    ,[LI_Telecopie],[LI_EMail],[cbProt],[cbCreateur],[cbModification],[cbReplication],[cbFlag])
              VALUES
                    (/*LI_No*/ISNULL((SELECT Max(LI_No) FROM ".$this->db->baseCompta.".[dbo].[F_LIVRAISON]),0)+1,/*CT_Num*/LEFT('$ct_num',17)
                    ,/*LI_Intitule*/LEFT('$ct_intitule',35),/*LI_Adresse*/LEFT('$adresse',35)
                    ,/*LI_Complement*/LEFT('$ct_complement',35),/*LI_CodePostal*/LEFT('$ct_codepostal',9)
                    ,/*LI_Ville*/LEFT('$ct_ville',35),/*LI_CodeRegion*/LEFT('$ct_coderegion',25)
                    ,/*LI_Pays*/LEFT('$ct_pays',35),/*LI_Contact*/LEFT('$ct_contact',35)
                    ,/*N_Expedition*/$expedition,/*N_Condition*/$condition
                    ,/*LI_Principal*/1,/*LI_Telephone, varchar(21),*/LEFT('$ct_telephone',21)
                    ,/*LI_Telecopie*/LEFT('$ct_telecopie',21),/*LI_EMail*/LEFT('$ct_email',69)
                    ,/*cbProt*/0,/*cbCreateur*/'AND',/*cbModification*/CAST(GETDATE() AS DATE)
                    ,/*cbReplication*/0,/*cbFlag*/0)";
        return $requete;
    }

    public function creationComptetg($ct_num,$cg_num){
        $requete = "INSERT INTO ".$this->db->baseCompta.".[dbo].[F_COMPTETG]
           ([CT_Num],[CG_Num],[cbProt],[cbCreateur],[cbModification]
           ,[cbReplication],[cbFlag])
     VALUES
           (/*CT_Num*/'$ct_num',/*CG_Num*/'$cg_num',/*cbProt*/0
           ,/*cbCreateur*/'AND',/*cbModification*/CAST(GETDATE() AS DATE)
           ,/*cbReplication*/0,/*cbFlag*/0)";
        return $requete;
    }

    public function insertFReglementT($CT_Num,$Condition,$nbJour,$jour,$trepart,$vrepart){
        return "
            DELETE FROM [dbo].[F_REGLEMENTT] WHERE CT_Num ='$CT_Num';
            INSERT INTO [dbo].[F_REGLEMENTT]
           ([CT_Num],[N_Reglement],[RT_Condition],[RT_NbJour]
           ,[RT_JourTb01],[RT_JourTb02],[RT_JourTb03],[RT_JourTb04]
           ,[RT_JourTb05],[RT_JourTb06],[RT_TRepart],[RT_VRepart]
           ,[cbProt],[cbCreateur],[cbModification],[cbReplication],[cbFlag])
     VALUES
           (/*CT_Num*/'$CT_Num',/*N_Reglement*/1
           ,/*RT_Condition*/$Condition,/*RT_NbJour*/$nbJour
           ,/*RT_JourTb01*/$jour,/*RT_JourTb02*/0
           ,/*RT_JourTb03*/0,/*RT_JourTb04*/0
           ,/*RT_JourTb05*/0,/*RT_JourTb06*/0
           ,/*RT_TRepart*/$trepart,/*RT_VRepart*/$vrepart
           ,/*cbProt*/0,/*cbCreateur*/'AND'
           ,/*cbModification*/CAST(GETDATE() AS DATE),/*cbReplication*/0,/*cbFlag*/0)";
    }

    public function createClientMin($ct_num, $ct_intitule, $cg_num, $adresse, $cp, $ville, $coderegion, $siret, $ape, $numpayeur, $co_no, $cattarif, $catcompta, $de_no, $tel, $anal,$type,$identifiant,$mode_reglement,$CA_Num) {
        $requete = "INSERT INTO ".$this->db->baseCompta.".[dbo].[F_COMPTET] " .
            " ([CT_Num],[CT_Intitule],[CT_Type],[CG_NumPrinc],[CT_Qualite],[CT_Classement] " .
            " ,[CT_Contact],[CT_Adresse],[CT_Complement],[CT_CodePostal],[CT_Ville],[CT_CodeRegion] " .
            " ,[CT_Pays],[CT_Raccourci],[BT_Num],[N_Devise],[CT_Ape],[CT_Identifiant],[CT_Siret],[CT_Statistique01] " .
            " ,[CT_Statistique02],[CT_Statistique03],[CT_Statistique04],[CT_Statistique05],[CT_Statistique06],[CT_Statistique07] " .
            " ,[CT_Statistique08],[CT_Statistique09],[CT_Statistique10],[CT_Commentaire],[CT_Encours],[CT_Assurance] " .
            " ,[CT_NumPayeur],[N_Risque],[CO_No],[cbCO_No],[N_CatTarif],[CT_Taux01] " .
            " ,[CT_Taux02],[CT_Taux03],[CT_Taux04],[N_CatCompta],[N_Period],[CT_Facture] " .
            " ,[CT_BLFact],[CT_Langue],[CT_Edi1],[CT_Edi2],[CT_Edi3],[N_Expedition] " .
            " ,[N_Condition],[CT_DateCreate],[CT_Saut],[CT_Lettrage],[CT_ValidEch],[CT_Sommeil] " .
            " ,[DE_No],[cbDE_No],[CT_ControlEnc],[CT_NotRappel],[N_Analytique],[cbN_Analytique] " .
            " ,[CA_Num],[CT_Telephone],[CT_Telecopie],[CT_EMail],[CT_Site],[CT_Coface] " .
            " ,[CT_Surveillance],[CT_SvDateCreate],[CT_SvFormeJuri],[CT_SvEffectif],[CT_SvCA],[CT_SvResultat] " .
            " ,[CT_SvIncident],[CT_SvDateIncid],[CT_SvPrivil],[CT_SvRegul],[CT_SvCotation],[CT_SvDateMaj] " .
            " ,[CT_SvObjetMaj],[CT_SvDateBilan],[CT_SvNbMoisBilan],[N_AnalytiqueIFRS],[cbN_AnalytiqueIFRS],[CA_NumIFRS] " .
            " ,[CT_PrioriteLivr],[CT_LivrPartielle],[MR_No],[cbMR_No],[CT_NotPenal],[EB_No] " .
            " ,[cbEB_No],[CT_NumCentrale],[CT_DateFermeDebut],[CT_DateFermeFin],[CT_FactureElec],[CT_TypeNIF] " .
            " ,[CT_RepresentInt],[CT_RepresentNIF],[cbProt],[cbCreateur],[cbModification],[cbReplication] " .
            " ,[cbFlag]) " .
            " VALUES  " .
            "       (/*CT_Num*/LEFT('$ct_num',17),/*CT_Intitule*/LEFT('$ct_intitule',35),/*CT_Type,*/$type,/*CG_NumPrinc*/(SELECT CASE WHEN '$cg_num'='' THEN NULL ELSE '$cg_num' END) " .
            "       ,/*CT_Qualite*/'',/*CT_Classement*/LEFT('$ct_intitule',17),/*CT_Contact*/'',/*CT_Adresse*/LEFT('".str_replace("'","''",$adresse)."',35) " .
            "       ,/*CT_Complement*/'',/*CT_CodePostal*/LEFT('$cp',9),/*CT_Ville*/LEFT('$ville',35),/*CT_CodeRegion*/LEFT('$coderegion',9) " .
            "       ,/*CT_Pays*/'',/*CT_Raccourci*/'',/*BT_Num*/0,/*N_Devise*/0 " .
            "       ,/*CT_Ape*/'',/*CT_Identifiant*/LEFT('$identifiant',25),/*CT_Siret*/LEFT('$siret',15),/*CT_Statistique01*/'' " .
            "       ,/*CT_Statistique02*/'',/*CT_Statistique03*/'',/*CT_Statistique04*/'',/*CT_Statistique05*/'' " .
            "       ,/*CT_Statistique06*/'',/*CT_Statistique07*/'',/*CT_Statistique08*/'',/*CT_Statistique09*/'' " .
            "       ,/*CT_Statistique10*/'',/*CT_Commentaire*/'',/*CT_Encours*/0,/*CT_Assurance*/0 " .
            "       ,/*CT_NumPayeur*/LEFT('$numpayeur',17),/*N_Risque*/1,/*CO_No*/(CASE WHEN $co_no=='' OR $co_no=='0' OR $co_no=='null' THEN NULL ELSE $co_no END),/*cbCO_No*/(CASE WHEN $co_no=='' OR $co_no=='0' OR $co_no=='null' THEN NULL ELSE $co_no END) " .
            "       ,/*N_CatTarif*/'" . $cattarif . "',/*CT_Taux01*/0,/*CT_Taux02*/0,/*CT_Taux03*/0 " .
            "       ,/*CT_Taux04*/0,/*N_CatCompta*/'" . $catcompta . "',/*N_Period*/1,/*CT_Facture*/1 " .
            "       ,/*CT_BLFact*/0,/*CT_Langue*/0,/*CT_Edi1*/'',/*CT_Edi2*/'' " .
            "       ,/*CT_Edi3*/'',/*N_Expedition*/1,/*N_Condition*/1,/*CT_DateCreate*/GETDATE() " .
            "       ,/*CT_Saut*/1,/*CT_Lettrage*/1,/*CT_ValidEch*/0,/*CT_Sommeil*/0 " .
            "       ,/*DE_No*/(SELECT CASE WHEN '$de_no'='0' THEN NULL ELSE '$de_no' END),/*cbDE_No*/(SELECT CASE WHEN '$de_no'='0' THEN NULL ELSE '$de_no' END)
                    ,/*CT_ControlEnc*/0,/*CT_NotRappel*/0,/*N_Analytique*/(CASE WHEN '$CA_Num'='' THEN NULL ELSE (SELECT N_Analytique FROM ".$this->db->baseCompta.".[dbo].F_COMPTEA WHERE CA_Num='$CA_Num') END) " .
            "       ,/*cbN_Analytique*/(CASE WHEN '$CA_Num'='' THEN NULL ELSE (SELECT N_Analytique FROM ".$this->db->baseCompta.".[dbo].F_COMPTEA WHERE CA_Num='$CA_Num') END),/*CA_Num*/(CASE WHEN '$CA_Num'='' THEN NULL ELSE '$CA_Num' END),/*CT_Telephone*/LEFT('$tel',21),/*CT_Telecopie*/'' " .
            "       ,/*CT_EMail*/'',/*CT_Site*/'',/*CT_Coface*/'',/*CT_Surveillance*/0 " .
            "       ,/*CT_SvDateCreate*/'1900-01-01',/*CT_SvFormeJuri*/'',/*CT_SvEffectif*/'',/*CT_SvCA*/0 " .
            "       ,/*CT_SvResultat*/0,/*CT_SvIncident*/0,/*CT_SvDateIncid*/'1900-01-01',/*CT_SvPrivil*/0 " .
            "       ,/*CT_SvRegul*/'',/*CT_SvCotation*/'',/*CT_SvDateMaj*/'1900-01-01',/*CT_SvObjetMaj*/'' " .
            "       ,/*CT_SvDateBilan*/'1900-01-01',/*CT_SvNbMoisBilan*/0,/*N_AnalytiqueIFRS*/0,/*cbN_AnalytiqueIFRS*/NULL " .
            "       ,/*CA_NumIFRS*/NULL,/*CT_PrioriteLivr*/0,/*CT_LivrPartielle*/0,/*MR_No*/$mode_reglement " .
            "       ,/*cbMR_No*/(CASE WHEN $mode_reglement=0 THEN NULL ELSE $mode_reglement END),/*CT_NotPenal*/0,/*EB_No*/0,/*cbEB_No*/NULL " .
            "       ,/*CT_NumCentrale*/NULL,/*CT_DateFermeDebut*/'1900-01-01',/*CT_DateFermeFin*/'1900-01-01',/*CT_FactureElec*/0 " .
            "       ,/*CT_TypeNIF*/0,/*CT_RepresentInt*/'',/*CT_RepresentNIF*/'',/*cbProt*/0 " .
            "       ,/*cbCreateur*/'AND',/*cbModification*/GETDATE(),/*cbReplication*/0,/*cbFlag*/0)";

        return $requete;
    }

    public function getLastClient() {
        return "SELECT TOP 1 * FROM ".$this->db->baseCompta.".dbo.COMPTET ORDER BY CbMarq desc";
    }


    public function getSoucheDepotCaisse($prot_no,$type,$souche,$ca_no,$depot,$ca_num){
        return"
                SELECT DE_No,CA_No,CA_Souche,CA_Num,CA_CatTarif
                FROM (SELECT D.DE_No,ISNULL(CA_No,0)CA_No,
                    ISNULL(CASE WHEN ('$type'='Vente') OR ('$type'='Devis') OR ('$type'='Retour') OR ('$type'='BonLivraison') THEN CA_SoucheVente ELSE 
                                CASE WHEN '$type'='Achat' OR '$type'='AchatRetour' OR '$type'='AchatPreparationCommande'  THEN CA_SoucheAchat ELSE CA_SoucheStock END END,0) CA_Souche,
                    ISNULL(CA_Num,'')CA_Num
                    ,ISNULL(CA_CatTarif,1)CA_CatTarif
                    FROM Z_DEPOTUSER D
                    LEFT JOIN Z_DEPOTCAISSE C ON C.DE_No=D.DE_No
                    LEFT JOIN Z_DEPOTSOUCHE S ON S.DE_No=D.DE_No
                    LEFT JOIN Z_DEPOT_DETAIL DD ON DD.DE_No=D.DE_No)A
                    WHERE ('-1'='$souche' OR CA_Souche ='$souche')
                    AND ('0'='$depot' OR DE_No ='$depot')
                    AND ('0'='$ca_no' OR CA_No ='$ca_no')
                    AND (''='$ca_num' OR CA_Num ='$ca_num')
                GROUP BY DE_No,CA_No,CA_Souche,CA_Num,CA_CatTarif
                    ";
    }

    public function getSoucheVenteByIndice($cbIndice){
        return "SELECT S_Intitule,cbIndice-1 as cbIndice,JO_Num FROM P_SOUCHEVENTE WHERE cbIndice='$cbIndice'+1";
    }



    public function getDepotClient($depot,$type){
        return "SELECT C.*,CASE WHEN $depot=DE_No THEN 1 ELSE 0 END Valide_Depot
                    FROM Z_CODECLIENT C
                    LEFT JOIN Z_DEPOTCLIENT D ON C.CodeClient=D.CodeClient WHERE CT_Type=$type";
    }

    public function getDepotCaisseSelect($caisse){
        return "SELECT  C.DE_No,DE_Intitule,CASE WHEN $caisse=CA_No THEN 1 ELSE 0 END Valide_Caisse
                    FROM F_DEPOT C
                    LEFT JOIN Z_DEPOTCAISSE D ON C.DE_No=D.DE_No";
    }
    public function getDepotUserByUser($prot_no){
        return "SELECT C.*,ISNULL(IsPrincipal,0) IsPrincipal, CASE WHEN $prot_no=Prot_No THEN 1 ELSE 0 END Valide_Depot
                    FROM F_DEPOT C 
                    LEFT JOIN (SELECT * FROM Z_DEPOTUSER WHERE PROT_No=$prot_no) D ON C.DE_No= D.DE_No";
    }
    public function getCodeClient(){
        return "SELECT C.*
                    FROM Z_CODECLIENT C";
    }

    public function getPrincipalDepot($id){
        return "SELECT * FROM Z_DEPOTUSER WHERE Prot_No=$id AND IsPrincipal=1";
    }
    public function getCodeClientByCode($code){
        return "SELECT C.*
                    FROM Z_CODECLIENT C
                    WHERE CodeClient='$code'";
    }
    public function supprCodeClientByCode(){
        return "TRUNCATE TABLE Z_CODECLIENT";
    }

    public function insertCodeClientByCode($code,$libelle,$type){
        return "INSERT INTO Z_CODECLIENT VALUES ('$code','$libelle',$type)";
    }

    public function majCodeClientByCode($code,$libelle,$type){
        return "UPDATE Z_CODECLIENT SET Libelle_ville='$libelle',CT_Type=$type WHERE CodeClient='$code'";
    }

    public function envoiSMSTest($code,$nom,$numero){
        return "INSERT INTO TEST_MSG values(LEFT('$code',50),LEFT('$nom',250),LEFT('$numero',250),GETDATE());";
    }

    public function getConditionnement(){
        return "SELECT 'Aucun' AS P_Conditionnement,0 AS cbIndice 
                UNION 
                SELECT  P_Conditionnement,cbIndice FROM P_CONDITIONNEMENT 
                WHERE   P_Conditionnement<>'' ";
    }
    public function getConditionnementMax()
    {
        return "SELECT  COUNT(*) Nb 
                FROM    (SELECT 'Aucun' AS P_Conditionnement,0 AS cbIndice 
                        UNION 
                        SELECT  P_Conditionnement,cbIndice 
                        FROM    P_CONDITIONNEMENT 
                        WHERE   P_Conditionnement<>'')A ";
    }

    public function getPrixConditionnement($val){
        return "SELECT  cbIndice
                        ,AC_Categorie
                        ,CT_Intitule
                        ,AC_PrixTTC as AC_PrixTTCExist
                        ,AC_Coef
                        ,AC_Remise
                        ,ISNULL(AC_PrixTTC,(SELECT AR_PrixTTC FROM F_ARTICLE WHERE AR_Ref='$val')) AC_PrixTTC
                        ,CASE WHEN AC_PrixVen IS NULL OR AC_PrixVen=0 THEN (SELECT AR_PrixVen FROM F_ARTICLE WHERE AR_Ref='$val') ELSE AC_PrixVen END AC_PrixVen 
                    FROM P_CATTARIF C 
                    LEFT JOIN (SELECT AR_Ref,AC_Categorie,AC_Coef,AC_PrixVen,AC_Remise,AC_PrixTTC FROM F_ARTCLIENT WHERE ar_ref='$val') A ON C.cbIndice=AC_Categorie
                    where CT_Intitule <>''";
    }

    public function majPrixDetail($prix,$ac_coef,$ref,$val,$pxTTC,$ac_remise){
        return "UPDATE F_ARTCLIENT SET  AC_PrixVen = $prix
                                        , AC_PrixTTC= $pxTTC 
                                        , AC_Coef= $ac_coef 
                                        , AC_Remise= $ac_remise 
                    WHERE AR_Ref='$ref' AND AC_Categorie=$val";
    }
    public function insertFCondition($AR_Ref,$enumere,$qte){
        return"INSERT INTO [dbo].[F_CONDITION]
                    ([AR_Ref],[CO_No],[EC_Enumere],[EC_Quantite]
                    ,[CO_Ref],[CO_CodeBarre],[CO_Principal],[cbProt]
                    ,[cbCreateur],[cbModification],[cbReplication],[cbFlag])
              VALUES
                    (/*AR_Ref*/'$AR_Ref',/*CO_No*/ISNULL((SELECT MAX(CO_No)+1 FROM F_CONDITION),0),/*EC_Enumere*/'$enumere',/*EC_Quantite*/$qte
                    ,/*CO_Ref*/NULL,/*CO_CodeBarre*/NULL,/*CO_Principal*/0,/*cbProt*/0
                    ,/*cbCreateur*/'AND',/*cbModification*/CAST(GETDATE() AS DATE),/*cbReplication*/0,/*cbFlag*/0)";
    }

    public function insertFTarifCond($AR_Ref,$nbCat,$prix){
        return "INSERT INTO [dbo].[F_TARIFCOND]
                    ([AR_Ref],[TC_RefCF],[CO_No],[TC_Prix]
                    ,[TC_PrixNouv],[cbProt],[cbCreateur],[cbModification],[cbReplication],[cbFlag])
              VALUES
                    (/*AR_Ref*/'$AR_Ref',/*TC_RefCF*/(SELECT 'a'+RIGHT('00'+'$nbCat',2)),/*CO_No*/ISNULL((SELECT MAX(CO_No) FROM F_CONDITION),0),
                    /*TC_Prix*/$prix,/*TC_PrixNouv*/0,/*cbProt*/0,/*cbCreateur*/'AND',/*cbModification*/GETDATE()
                    ,/*cbReplication*/0,/*cbFlag*/0)";
    }

    public function selectFCondition($enumere,$AR_Ref){
        return "SELECT * FROM F_CONDITION WHERE EC_Enumere='$enumere' AND AR_Ref='$AR_Ref'";
    }

    public function supprFCondition($cbmarq){
        return "DELETE FROM F_CONDITION WHERE cbMarq=$cbmarq";
    }

    public function supprFTarifCond($ar_ref,$co_no){
        return "DELETE FROM F_TarifCond WHERE AR_Ref='$ar_ref' AND CO_No='$co_no'";
    }

    public function supprFamille($codeFam){
        return "IF EXISTS(SELECT * FROM sys.objects WHERE NAME='TG_CBDEL_F_FAMILLE')
                    ALTER TABLE F_ARTICLE DISABLE TRIGGER TG_CBDEL_F_FAMILLE;
                    DELETE FROM F_FAMILLE WHERE FA_CodeFamille='$codeFam';
                    IF EXISTS(SELECT * FROM sys.objects WHERE NAME='TG_CBDEL_F_FAMILLE')
                    ALTER TABLE F_ARTICLE ENABLE TRIGGER TG_CBDEL_F_FAMILLE;";
    }

    public function supprClient($ct_num){
        return  "BEGIN 
                    DELETE FROM F_COMPTETG WHERE CT_Num='$ct_num';
                    DELETE FROM dbo.F_LIVRAISON WHERE CT_Num='$ct_num';
                    DELETE FROM dbo.F_REGLEMENTT WHERE CT_Num='$ct_num';
                    DELETE FROM F_COMPTET WHERE CT_Num='$ct_num';
                 END;";

    }

    public function isFamilleLigne($ar_ref){
        return "SELECT cbMarq FROM F_ARTICLE WHERE FA_CodeFamille='$ar_ref'";
    }

    public function isClientLigne($ct_num){
        return "SELECT cbMarq FROM F_CREGLEMENT WHERE CT_NumPayeur='$ct_num'"
            . " UNION SELECT cbMarq FROM F_DOCENTETE WHERE DO_Tiers='$ct_num'";
    }

    public function detailConditionnement($ref,$val){
        return "SELECT C.AR_Ref,EC_Enumere,EC_Quantite,TC_Prix
                    FROM F_CONDITION C
                    INNER JOIN F_TARIFCOND T ON T.AR_Ref=C.AR_Ref
                    where C.ar_ref='$ref' AND C.CO_No=T.CO_No
                    AND TC_RefCF LIKE '%$val'";
    }


    public function majDetailConditionnement($prix,$ref,$val,$enum,$qte,$AEnum){
        return "UPDATE F_TARIFCOND SET TC_Prix=$prix,cbModification=GETDATE()
            FROM (SELECT AR_Ref,CO_No,EC_Enumere FROM F_CONDITION) C
            where C.AR_Ref=F_TARIFCOND.AR_Ref AND C.CO_No=F_TARIFCOND.CO_No AND C.AR_Ref='$ref' AND TC_RefCF LIKE '%$val';
            UPDATE F_CONDITION SET EC_Enumere='$enum',EC_Quantite=$qte,cbModification=GETDATE()
            where AR_Ref='$ref' AND EC_Enumere ='$AEnum'";
    }


    public function getCatalogue($niv){
        return "SELECT CL_No,CL_Intitule FROM F_CATALOGUE WHERE CL_Niveau=$niv";
    }

    public function getCatalogueByCL($cl){
        return "SELECT CL_No,CL_Intitule FROM F_CATALOGUE WHERE CL_No=$cl";
    }

    public function getCatalogueChildren($niv,$no){
        return "SELECT CL_No,CL_Intitule FROM F_CATALOGUE WHERE CL_Niveau=$niv AND CL_NoParent=$no";
    }

    public function getLastCatalogue(){
        return "SELECT top 1 CL_No,CL_Intitule FROM F_CATALOGUE ORDER by Cbmarq desc";
    }

    public function insertFCatalogue($intitule,$no_parent,$niveau){
        return"INSERT INTO [dbo].[F_CATALOGUE]
            ([CL_No],[CL_Intitule],[CL_Code],[CL_Stock]
            ,[CL_NoParent],[cbCL_NoParent],[CL_Niveau],[cbProt]
            ,[cbCreateur],[cbModification],[cbReplication],[cbFlag])
      VALUES
            (/*CL_No*/(SELECT ISNULL(MAX(CL_No),0)+1 FROM F_CATALOGUE),/*CL_Intitule*/'$intitule',/*CL_Code*/'',/*CL_Stock*/0
            ,/*CL_NoParent*/$no_parent,/*cbCL_NoParent*/(SELECT(CASE WHEN $no_parent=0 THEN NULL ELSE $no_parent END)),/*CL_Niveau*/$niveau,/*cbProt*/0
            ,/*cbCreateur*/'AND',/*cbModification*/GETDATE(),/*cbReplication*/0,/*cbFlag*/0)";
    }

    public function updateFCatalogue($no,$intitule){
        return "UPDATE F_CATALOGUE SET CL_Intitule='$intitule',cbModification=GETDATE() WHERE CL_No=$no";
    }

    public function deleteFCatalogue($no){
        return "DELETE FROM F_CATALOGUE WHERE CL_No=$no";
    }

    public function getAllinfoClientByCTNum($CTNum){
        return "SELECT * FROM ".$this->db->baseCompta.".dbo.F_COMPTET WHERE CT_Num=LEFT('$CTNum',17)";
    }

    public function getDateEnJMA($date){
        return "SELECT LEFT(CONVERT(varchar, cast('{$date}' as datetime) , 103), 10)";
    }

    public function getAllTaxesByDopiece($dopiece){
        return "DECLARE @DO_PIECE VARCHAR(79)
                    SET @DO_PIECE = '$dopiece'
                    SELECT T.TA_Taux,T.TA_Sens, A.*,
                    CASE WHEN T.TA_Sens = 1 THEN T.TA_Taux ELSE -T.TA_Taux END AS TAUX
                    FROM(SELECT FA.FCP_ComptaCPT_Taxe1 AS CODE_TAXE, SUM(DL_MontantHT) AS BASE 
						 from 	F_DOCLIGNE  L 
						 INNER JOIN F_ARTICLE  A 
							ON A.cbAR_Ref=L.cbAR_Ref
						INNER JOIN F_FAMILLE F 
							ON F.cbFA_CodeFamille=A.cbFA_CodeFamille
						INNER JOIN F_FAMCOMPTA FA 
							ON FA.cbFA_CodeFamille=F.cbFA_CodeFamille
						INNER JOIN F_DOCENTETE D 
							ON D.cbDO_Piece = L.cbDO_Piece
						WHERE 	L.cbDO_Piece=@DO_PIECE 
						AND   	FA.FCP_Champ = D.N_CatCompta 
						AND 	FA.FCP_Type = D.DO_Domaine --AND L.DL_Taxe1 <> 
					GROUP BY FA.FCP_ComptaCPT_Taxe1
                    
					UNION 

                    SELECT	FA.FCP_ComptaCPT_Taxe2 AS CODE_TAXE, SUM(DL_MontantHT) AS BASE 
					FROM 	F_DOCLIGNE  L 
					INNER JOIN F_ARTICLE  A 
						ON A.cbAR_Ref=L.cbAR_Ref
					INNER JOIN F_FAMILLE F 
						ON F.cbFA_CodeFamille=A.cbFA_CodeFamille
					INNER JOIN F_FAMCOMPTA FA 
						ON FA.cbFA_CodeFamille=F.cbFA_CodeFamille
					INNER JOIN F_DOCENTETE D 
						ON D.cbDO_Piece = L.cbDO_Piece
					WHERE	L.cbDO_Piece=@DO_PIECE 
					AND   	FA.FCP_Champ = D.N_CatCompta 
					AND 	FA.FCP_Type = D.DO_Domaine
					GROUP BY FA.FCP_ComptaCPT_Taxe2

                    UNION 

                    SELECT FA.FCP_ComptaCPT_Taxe3 AS CODE_TAXE, SUM(DL_MontantHT) AS BASE 
					FROM F_DOCLIGNE  L 
					INNER JOIN F_ARTICLE  A 
						ON A.cbAR_Ref=L.cbAR_Ref
					INNER JOIN F_FAMILLE F 
						ON F.cbFA_CodeFamille=A.cbFA_CodeFamille
					INNER JOIN F_FAMCOMPTA FA 
						ON FA.cbFA_CodeFamille=F.cbFA_CodeFamille
					INNER JOIN F_DOCENTETE D 
						ON D.cbDO_Piece = L.cbDO_Piece
					WHERE 	L.cbDO_Piece=@DO_PIECE 
					AND   	FA.FCP_Champ = D.N_CatCompta 
					AND		FA.FCP_Type = D.DO_Domaine
					GROUP BY FA.FCP_ComptaCPT_Taxe3

                    )A
                    LEFT JOIN F_TAXE T 
						ON T.TA_Code = A.CODE_TAXE
                    WHERE A.CODE_TAXE IS NOT NULL";
    }

    public function modifierMdp($mdp,$userid){
        $query="UPDATE F_PROTECTIONCIAL SET Prot_Pwd='$mdp' WHERE Prot_No=$userid;
                UPDATE F_PROTECTIONCPTA SET Prot_Pwd='$mdp' WHERE Prot_No=$userid;";
        return $query;
    }

    public function UsersByid($id){
        return "SELECT P.*,DE_No,CA_No 
                     FROM F_PROTECTIONCIAL P 
                     LEFT JOIN (SELECT	C.CO_No,CA.CA_No,DE_No
										,CA_Souche,PROT_No,CO_Nom
								FROM 	F_COLLABORATEUR C 
								LEFT JOIN F_CAISSECAISSIER CC 
									ON 	C.CO_No= CC.CO_No
								LEFT JOIN F_CAISSE CA 
									ON 	CA.CA_No = CC.CA_No) A 
						ON A.CO_Nom=P.PROT_User
                     WHERE P.PROT_No=$id";
    }

    public function getAllProfils(){
        return "SELECT 	PROT_No
                        ,PROT_User
                        ,PROT_Pwd
                        ,PROT_DateCreate
                        ,cbModification
				FROM 	F_PROTECTIONCIAL
				WHERE 	PROT_UserProfil=0
				AND 	PROT_Right=2";
    }

    public function getProfilByid($id){
        return "SELECT 	* 
				FROM 	F_PROTECTIONCIAL 
				WHERE 	Prot_No=$id";
    }

    public function getMaxProtNoCial(){
        $sqlprotno="SELECT 	Max(Prot_No) 
					FROM 	F_PROTECTIONCIAL";
        $resultno=$this->db->requete($sqlprotno);
        while ($re = $resultno->fetch()) {
            $solution=$re[0];
        }
        $solu=$solution+1;
        return $solu;
    }

    public function getMaxProtNoCompta(){
        $sqlprotno="SELECT 	Max(Prot_No) 
					FROM 	F_PROTECTIONCPTA";
        $resultno=$this->db->requete($sqlprotno);
        while ($re = $resultno->fetch()) {
            $solution=$re[0];
        }
        $solu=$solution+1;
        return $solu;
    }

    public function createUser($username,$description,$password,$groupeid,$email,$profiluser,$changepass){
        $cbprofiluser=0;
        if($profiluser==0){
            $cbprofiluser='NULL';
        }else $cbprofiluser=$profiluser;

        $sql = "INSERT INTO F_PROTECTIONCPTA
           ([PROT_User],[PROT_Pwd]
           ,[PROT_Description],[PROT_Right]
           ,[PROT_No],[PROT_EMail],[PROT_UserProfil]
           ,[cbPROT_UserProfil]
           ,[PROT_Administrator]
           ,[PROT_DatePwd]
           ,[PROT_DateCreate]
           ,[PROT_LastLoginDate]
           ,[PROT_LastLoginTime]
           ,[PROT_PwdStatus]
           ,[cbProt]
           ,[cbCreateur]
           ,[cbModification]
           ,[cbReplication]
           ,[cbFlag])
     VALUES
           ('".$username."'
           ,'".$this->crypteMdp($password)."'
           ,'".$description."'
           ,".$groupeid."
           ,".$this->getMaxProtNoCompta()."
           ,'".$email."'
           ,0
           ,NULL
           ,0
           ,GETDATE()
           ,GETDATE()
           ,'1900-01-01 00:00:00'
           ,000000000
           ,".$changepass."
           ,0
           ,'COLU'
           ,GETDATE()
           ,0
           ,0)";

        $sql1 = "INSERT INTO [F_PROTECTIONCIAL]
           ([PROT_User]
           ,[PROT_Pwd]
           ,[PROT_Description]
           ,[PROT_Right]
           ,[PROT_No]
           ,[PROT_EMail]
           ,[PROT_UserProfil]
           ,[cbPROT_UserProfil]
           ,[PROT_Administrator]
           ,[PROT_DatePwd]
           ,[PROT_DateCreate]
           ,[PROT_LastLoginDate]
           ,[PROT_LastLoginTime]
           ,[PROT_PwdStatus]
           ,[cbProt]
           ,[cbCreateur]
           ,[cbModification]
           ,[cbReplication]
           ,[cbFlag])
     VALUES
           ('".$username."'
           ,'".$this->crypteMdp($password)."'
           ,'".$description."'
           ,".$groupeid."
           ,".$this->getMaxProtNoCial()."
           ,'".$email."'
           ,".$profiluser."
           ,".$cbprofiluser."
           ,0
           ,GETDATE()
           ,GETDATE()
           ,'1900-01-01 00:00:00'
           ,000000000
           ,".$changepass."
           ,0
           ,'COLU'
           ,GETDATE()
           ,0
           ,0)  
           ";
        return $sql.";".$sql1;
    }

    public function UpdateLastLogin($uid){
        $sql= "UPDATE ".$this->db->baseCompta.".[dbo].[F_PROTECTIONCPTA]
                SET [PROT_LastLoginDate] =GETDATE(),cbModification=GETDATE() WHERE PROT_No=".$uid."";

        $sql2 = "UPDATE F_PROTECTIONCIAL
                SET [PROT_LastLoginDate] =GETDATE(),cbModification=GETDATE() WHERE PROT_No=".$uid."";
        return $sql.";".$sql2;
    }

    public function getOldPasswordByid($uid){
        $sql="SELECT PROT_Pwd FROM F_PROTECTIONCIAL WHERE PROT_No=".$uid."";
        return $sql;
    }

    public function ajoutModeleR($MR_Intitule){
        return "INSERT INTO ".$this->db->baseCompta.".[dbo].[F_MODELER]
           ([MR_No],[MR_Intitule],[cbProt],[cbCreateur]
           ,[cbModification],[cbReplication],[cbFlag])
            VALUES
           (/*MR_No*/ISNULL( (SELECT MAX(MR_No) FROM ".$this->db->baseCompta.".[dbo].F_MODELER),0)+1,/*MR_Intitule*/'$MR_Intitule'
           ,/*cbProt*/0,/*cbCreateur*/'AND',/*cbModification*/CAST(GETDATE() AS DATE),/*cbReplication*/0
           ,/*cbFlag*/0);";
    }

    public function getModeleRByIntitule($MR_Intitule){
        return "SELECT MAX(MR_No)MR_No  FROM ".$this->db->baseCompta.".[dbo].F_MODELER WHERE MR_Intitule='$MR_Intitule';";
    }
    public function modifModeleR($MR_Intitule,$MR_No){
        return "UPDATE ".$this->db->baseCompta.".[dbo].[F_MODELER] SET MR_Intitule= '$MR_Intitule',cbModification=GETDATE() WHERE MR_No = $MR_No;";
    }

    public function supprEModeleR($MR_No){
        return "DELETE FROM ".$this->db->baseCompta.".[dbo].[F_EMODELER] WHERE MR_No=$MR_No";
    }

    public function ajoutEModeleR ($MR_No,$N_Reglement,$ER_Condition,$ER_NbJour,$ER_JourTb01,$ER_TRepart,$ER_VRepart){
        return "INSERT INTO ".$this->db->baseCompta.".[dbo].[F_EMODELER]
           ([MR_No],[N_Reglement],[ER_Condition],[ER_NbJour]
           ,[ER_JourTb01],[ER_JourTb02],[ER_JourTb03],[ER_JourTb04]
           ,[ER_JourTb05],[ER_JourTb06],[ER_TRepart],[ER_VRepart]
           ,[cbProt],[cbCreateur],[cbModification],[cbReplication],[cbFlag])
            VALUES
           (/*MR_No*/$MR_No,
            /*N_Reglement*/$N_Reglement,/*ER_Condition*/$ER_Condition,/*ER_NbJour*/$ER_NbJour
           ,/*ER_JourTb01*/$ER_JourTb01,/*ER_JourTb02*/0,/*ER_JourTb03*/0,/*ER_JourTb04*/0
           ,/*ER_JourTb05*/0,/*ER_JourTb06*/0,/*ER_TRepart*/$ER_TRepart,/*ER_VRepart*/$ER_VRepart
           ,/*cbProt*/0,/*cbCreateur*/'AND',/*cbModification*/CAST(GETDATE() AS DATE),/*cbReplication*/0,/*cbFlag*/0)
            ";
    }

    public function UpdateStatutPasswordByid($uid){
        $sql1= "UPDATE [F_PROTECTIONCPTA]
                SET [PROT_PwdStatus] =0,cbModification=GETDATE() WHERE PROT_No=".$uid."";

        $sql2 = "UPDATE F_PROTECTIONCIAL
                SET [PROT_PwdStatus] =0,cbModification=GETDATE() WHERE PROT_No=".$uid."";
        return $sql1.";".$sql2;
    }

    public function UpdatePasswordByid($uid,$pass){
        $sql1= "UPDATE [F_PROTECTIONCPTA]
                SET [PROT_Pwd] ='{$this->crypteMdp($pass)}',cbModification=GETDATE() WHERE PROT_No={$uid}";

        $sql2 = "UPDATE F_PROTECTIONCIAL
                SET [PROT_Pwd] ='{$this->crypteMdp($pass)}',cbModification=GETDATE() WHERE PROT_No={$uid}";
        return $sql1.";".$sql2;
    }

    public function getAllDroits(){
        return "SELECT * FROM LIB_CMD";
    }

    public function getCollaborateurByCOno($cono){
        return "SELECT C.*,CA_No FROM F_COLLABORATEUR C LEFT JOIN F_CAISSECAISSIER CA ON C.CO_No = CA.CO_No  WHERE C.CO_No=$cono";
    }

    public function getAllDroitsByProfil($username,$password){
        return "SELECT *
                    FROM LIB_CMD C
                    LEFT JOIN (			SELECT 	PROT_User,PROT_Pwd,EPROT_Cmd,EPROT_Right 
                                        FROM 	F_PROTECTIONCIAL F 
                                        INNER JOIN F_EPROTECTIONCIAL E 
											ON E.PROT_No=F.PROT_No
                                        WHERE 	PROT_User='$username' 
										AND 	PROT_Pwd='$password') E 
						ON EPROT_Cmd=PROT_Cmd
                    WHERE PROT_Cmd IN (33541,33537,33538,34051,34049,6150,6145,34050,8193,8194,34056,6147)";
    }

    public function getDroitByProfil($protno,$cmd){
        return "SELECT EPROT_Right FROM F_EPROTECTIONCIAL  WHERE EPROT_Cmd=".$cmd." AND PROT_No=".$protno."";
    }

    public function addDroitByProfil($protno,$cmd,$protright){
        return "INSERT INTO [F_EPROTECTIONCIAL]
                    ([PROT_No]
                    ,[EPROT_Cmd]
                    ,[EPROT_Right]
                    ,[cbProt]
                    ,[cbCreateur]
                    ,[cbModification]
                    ,[cbReplication]
                    ,[cbFlag])
                 VALUES
                    ($protno
                    ,$cmd
                    ,$protright
                    ,0
                    ,'COLS'
                    ,GETDATE()
                    ,0
                    ,0)";
    }

    public function updateDroitByProfil($protno,$cmd,$protright){
        return "UPDATE [F_EPROTECTIONCIAL]
                    SET [EPROT_Right] = $protright,cbModification=GETDATE()
                       ,[cbModification] = GETDATE()
                  WHERE PROT_No=$protno
                    AND EPROT_Cmd=$cmd";
    }

    public function removeDroitByProfil($protno,$cmd){
        return "DELETE FROM [F_EPROTECTIONCIAL]
                    WHERE PROT_No=".$protno."
                    AND EPROT_Cmd=".$cmd."";
    }

    public function DroitByProfilProcess($protno,$cmd,$protright){

        $sql1="SELECT * FROM F_EPROTECTIONCIAL WHERE PROT_No=".$protno." AND EPROT_Cmd=".$cmd."";
        $result = $this->db->requete($sql1);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        //$result2="";
        if ($rows != null) {
            $idprofil = $rows[0]->PROT_No;
            $idcommande = $rows[0]->EPROT_Cmd;
            $iddroit = $rows[0]->EPROT_Right;
            if($protright==0){ //la suppression des droits est demandée
                return $result2 = $this->db->requete($this->removeDroitByProfil($protno,$cmd));
            }else if($protright!=0 && $iddroit!=$protright){ // on veut modifier le droit correspondant
                return $result2 = $this->db->requete($this->updateDroitByProfil($protno,$cmd,$protright));
            }else{ //le droit choisi est le meme que l'on souhaite modifier alors on ne fait rien

            }

        }else{ //aucun droit pour le profil n'existe
            if($protright==0){ //la suppression des droits est demandée et on ne fait rien car il n'existe aucun droit dans la bd

            }else{ //on enregistre en bd
                return $result2 =$this->db->requete($this->addDroitByProfil($protno,$cmd,$protright));
            }
        }
        //return $result2;
    }

    public function getReglement($ct_num,$impute,$mode,$datedeb,$datefin,$caisse,$facComptabilise) {
        return "
                    WITH _Caisse_ AS (
                        SELECT  CA_No
                                ,CA_Intitule
                                ,CO_NoCaissier
                        FROM    F_CAISSE CA
                    )
                    , _Collaborateur_ AS (
                        SELECT  CO_No
                                ,CO_Nom
                        FROM    F_COLLABORATEUR
                    )
                    SELECT DO_Piece,CT_NumPayeur,C.RG_No,CAST(RG_Date AS Date) RG_Date,RG_Libelle,RG_Montant,ISNULL(RC_Montant,0) AS RC_Montant,
                    C.CA_No,CA.CO_NoCaissier,CA_Intitule,CO_Nom, ISNULL(DL_MontantTTC,0) AS DL_MontantTTC,ISNULL(DL_MontantTTC,0) - ISNULL(RC_Montant,0) RESTE_A_PAYER
                    FROM F_CREGLEMENT C
                    LEFT JOIN _Caisse_ CA 
                        ON CA.CA_No=C.CA_No 
                    LEFT JOIN _Collaborateur_ CO 
                        ON CO.CO_No=C.CO_NoCaissier
                    LEFT  JOIN (	SELECT RG_No,MAX(R.DO_PIECE)DO_PIECE,MAX(R.DO_Domaine)DO_Domaine,MAX(R.DO_Type)DO_Type,SUM(RC_Montant) AS RC_Montant,SUM(DL_MontantTTC)DL_MontantTTC
                                    FROM F_REGLECH R
                                    INNER JOIN (SELECT DO_Domaine,DO_Type,DO_Piece,SUM(DL_MontantTTC) DL_MontantTTC
                                                            FROM F_DOCLIGNE D 
                                                            GROUP BY DO_Domaine,DO_Type,DO_Piece) L
                                                            ON R.DO_Domaine=L.DO_Domaine AND R.DO_Type=L.DO_Type AND R.DO_Piece=L.DO_Piece
                                            GROUP BY RG_No) R ON R.RG_No=c.RG_No 
                    WHERE	('0' = '$ct_num' OR CT_NumPayeur= '$ct_num') 
                    AND RG_TypeReg = 0
                    AND     (($facComptabilise=0 AND (R.DO_Type in (6,7))) OR ($facComptabilise=1 AND R.DO_Type = 6) OR ($facComptabilise=2 AND R.DO_Type = 7)) 
                    AND         ('0' = $caisse OR C.CA_No = '$caisse')
                    AND		('' ='$datedeb' OR RG_Date >= '$datedeb')
                    AND         ('' ='$datefin' OR RG_Date<= '$datefin')
                    AND		(-1='$impute' OR RG_Impute=$impute)
                    AND		(0='$mode' OR N_Reglement=$mode)
                    ORDER BY CT_NumPayeur";
    }

    public function insert_REGLEMENTPIECE($rg_no,$fichier){
        return "INSERT INTO Z_REGLEMENTPIECE VALUES($rg_no,'$fichier'); ";
    }

    public function insert_ECRITURECPIECE($ec_no,$fichier){
        return "INSERT INTO Z_ECRITURECPIECE VALUES($ec_no,'$fichier'); ";
    }

    public function modif_ECRITURECPIECE($ec_no,$fichier){
        return "UPDATE Z_ECRITURECPIECE SET Lien_Fichier = '$fichier' WHERE EC_No =$ec_no; ";
    }

    function sendSms($url, $username,$destination,$source,$message,$mdp){
        $timeout = 10;
        $request  = $url."UserName=".urlencode($username)."&Password=$mdp";
        $request .="&SOA=".urlencode($source)."&MN=".urlencode($destination)."&SM=".urlencode($message);
        $url =$request;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POST, 1);
        $response = curl_exec($ch);
        curl_close($ch);
    }

    public function getAlerteMontantCaisse($ca_no) {
        return "
SELECT 
A.CA_No,A.CA_Intitule,FORMAT(A.MONTANT,'### ### ###') AS MONTANT,ISNULL(A.NB,0) AS NB
FROM(SELECT 
A.CA_No,A.CA_Intitule,SUM(A.MONTANT) AS MONTANT,ISNULL(B.NB,0) AS NB
FROM(SELECT  
CASE WHEN A.RG_TypeReg = 4 THEN -A.RG_Montant ELSE A.RG_Montant END MONTANT,*
FROM(SELECT C.CA_Intitule,R.RG_Montant,R.RG_TypeReg,R.CA_No FROM F_CREGLEMENT R 
INNER JOIN F_CAISSE C ON C.CA_No = R.CA_No
WHERE C.CA_No = $ca_no AND R.RG_Date BETWEEN '2015-01-01' AND LEFT(CONVERT(VARCHAR, GETDATE(), 120), 10) )A)A
LEFT JOIN (SELECT S.CA_No,COUNT(S.CA_No) AS NB FROM Z_SMS S 
			WHERE DATE_S >= LEFT(CONVERT(VARCHAR, GETDATE(), 120), 10)  GROUP BY CA_No)B ON B.CA_No = A.CA_No
GROUP BY A.CA_No,A.CA_Intitule,B.NB
)A WHERE A.NB <= 4 AND A.MONTANT >= 1000000";
    }

    public function insertSms($ca_no,$msg,$number)
    {
        return "INSERT INTO Z_SMS ([CA_No],[MSG],[NUMBER_R],[DATE_S],[ETAT])
            VALUES($ca_no,'$msg','$number',GETDATE(),'1')";
    }

    function getCompteg() {
        return "SELECT CG_Num,CG_Intitule,TA_Code,cbModification FROM F_COMPTEG WHERE CG_Type=0 ORDER BY CG_Num";
    }

    function getCompteRattacheTaxe($TA_No){
        return "SELECT TA_No,E.CG_Num,CG_Intitule
                FROM ".$this->db->baseCompta.".dbo.F_ETAXE E
                INNER JOIN ".$this->db->baseCompta.".dbo.F_COMPTEG C ON E.CG_Num = C.CG_Num
                WHERE TA_No = $TA_No";
    }
    public function ajoutJournal($JO_Num,$JO_Intitule,$CG_Num,$JO_Type,$JO_NumPiece,$JO_Contrepartie,$JO_SaisAnal,$JO_NotCalcTot,$JO_Rappro,$JO_Sommeil,$JO_IFRS,$JO_Reglement,$JO_SuiviTreso){
        return "INSERT INTO ".$this->db->baseCompta.".dbo.[F_JOURNAUX]
           ([JO_Num],[JO_Intitule],[CG_Num],[JO_Type]
           ,[JO_NumPiece],[JO_Contrepartie],[JO_SaisAnal],[JO_NotCalcTot]
           ,[JO_Rappro],[JO_Sommeil],[JO_IFRS],[JO_Reglement]
           ,[JO_SuiviTreso],[cbProt],[cbCreateur],[cbModification]
           ,[cbReplication],[cbFlag])
     VALUES
           (/*JO_Num*/'$JO_Num',/*JO_Intitule*/'$JO_Intitule'
           ,/*CG_Num*/(CASE WHEN '$CG_Num'='' THEN NULL ELSE '$CG_Num' END),/*JO_Type*/$JO_Type
           ,/*JO_NumPiece*/$JO_NumPiece,/*JO_Contrepartie*/$JO_Contrepartie
           ,/*JO_SaisAnal*/$JO_SaisAnal,/*JO_NotCalcTot*/$JO_NotCalcTot
           ,/*JO_Rappro*/$JO_Rappro,/*JO_Sommeil*/$JO_Sommeil
           ,/*JO_IFRS*/$JO_IFRS,/*JO_Reglement*/$JO_Reglement
           ,/*JO_SuiviTreso*/$JO_SuiviTreso,/*cbProt*/0
           ,/*cbCreateur*/'AND',/*cbModification*/CAST(GETDATE() AS DATE)
           ,/*cbReplication*/0,/*cbFlag*/0)";
    }
    public function modifJournal($JO_Num,$JO_Intitule,$CG_Num,$JO_NumPiece,$JO_Contrepartie,$JO_SaisAnal,$JO_NotCalcTot,$JO_Rappro,$JO_Sommeil,$JO_IFRS,$JO_Reglement,$JO_SuiviTreso){
        return "UPDATE ".$this->db->baseCompta.".dbo.[F_JOURNAUX]
                SET [JO_Intitule] = '$JO_Intitule',cbModification=GETDATE(),[CG_Num] = (CASE WHEN '$CG_Num'='' THEN NULL ELSE '$CG_Num' END),[JO_NumPiece] = $JO_NumPiece,[JO_Contrepartie] = $JO_Contrepartie
                   ,[JO_SaisAnal] = $JO_SaisAnal,[JO_NotCalcTot] = $JO_NotCalcTot,[JO_Rappro] = $JO_Rappro,[JO_Sommeil] = $JO_Sommeil
                   ,[JO_IFRS] = $JO_IFRS,[JO_Reglement] = $JO_Reglement,[JO_SuiviTreso] = $JO_SuiviTreso,[cbModification] = CAST(GETDATE() AS DATE)
              WHERE [JO_Num] = '$JO_Num'";
    }
    function getPlanComptable($val) {
        return "SELECT CG_Num,CG_Intitule
                FROM ".$this->db->baseCompta.".dbo.F_COMPTEG
                WHERE ($val=0 AND 1=1) OR ($val=1 AND 1=1) OR ($val=2 AND CG_Sommeil=1)"
            ;
    }
    function getPlanComptableByCGNum($cg_num) {
        return "SELECT *
                FROM ".$this->db->baseCompta.".dbo.F_COMPTEG
                WHERE CG_Num='$cg_num'";
    }



    function getPlanAnalytique($val,$n_anal) {
        return "SELECT CA_Num,CA_Intitule,N_Analytique
                FROM ".$this->db->baseCompta.".dbo.F_COMPTEA
                WHERE N_Analytique = $n_anal
                AND (($val=0 AND 1=1) OR ($val=1 AND CA_Sommeil=0) OR ($val=2 AND CA_Sommeil=1))";
    }

    function getPlanAnalytiqueHorsTotal($val,$n_anal) {
        return "SELECT CA_Num,CA_Intitule
                FROM ".$this->db->baseCompta.".dbo.F_COMPTEA
                WHERE N_Analytique = $n_anal
                AND CA_Type=0
                AND (($val=0 AND 1=1) OR ($val=1 AND CA_Sommeil=0) OR ($val=2 AND CA_Sommeil=1))";
    }
    function getPlanAnalytiqueByCANum($ca_num) {
        return "SELECT *
                FROM ".$this->db->baseCompta.".dbo.F_COMPTEA
                WHERE CA_Num='$ca_num'";
    }

    function getAnalytiqueSaisie() {
        return "SELECT *
                FROM ".$this->db->baseCompta.".dbo.F_COMPTEA
                WHERE N_Analytique=1
                AND CA_Type=0";
    }

    function getJournaux($val) {
        return "SELECT JO_Num,JO_Intitule,CG_Num,cbModification
                FROM ".$this->db->baseCompta.".dbo.F_JOURNAUX
                WHERE ($val=0 AND 1=1) OR ($val=1 AND JO_Sommeil=0) OR ($val=2 AND JO_Sommeil=1)";
    }

    function getJournauxTreso() {
        return "SELECT  JO_Num,JO_Intitule,CG_Num,cbModification
                FROM    F_JOURNAUX
                WHERE   JO_Type = 2";
    }


    function getJournauxCount($val) {
        return "DECLARE @val INT = $val
                SELECT count(*) Nb,max(cbModification)cbModification
                FROM F_JOURNAUX
                WHERE (@val=0 AND 1=1) 
                        OR (@val=1 AND JO_Sommeil=0) 
                            OR (@val=2 AND JO_Sommeil=1)";
    }


    function getMaxEC_No(){
        return" SELECT ISNULL(EC_No,0) EC_No,ISNULL(CG_Analytique,0) AS CG_Analytique
                FROM F_ECRITUREC A
                LEFT JOIN F_COMPTEG B ON A.CG_Num = B.CG_Num
                WHERE EC_No=(SELECT ISNULL((SELECT MAX(EC_No)EC_No FROM F_ECRITUREC),0));";
    }

    function getEcritureA($ecNo,$caNum){
        $query = "  DECLARE @ecNo INT = $ecNo
                    DECLARE @caNum NVARCHAR(50) = '$caNum'
                    SELECT	ec.EC_No
                            ,N_Analytique = (SELECT N_Analytique FROM F_COMPTEA WHERE CA_Num=@caNum)
                            ,EA_Ligne = 1
                            ,CA_Num=@caNum
                            ,EA_Montant = EC_Montant
                            ,EA_Qte=0
                    FROM	F_ECRITUREC ec
                    LEFT JOIN F_COMPTEG cg
                        ON	cg.CG_Num= ec.CG_Num
                    WHERE	ec.EC_No = @ecNo
                    AND		cg.CG_Analytique=1";
        $result = $this->db->requete($query);
        return $result->fetchAll(PDO::FETCH_OBJ);

    }
    function insertFComptetC($JO_Num,$JM_Date,$EC_Jour,$EC_Date,$EC_Piece,$EC_RefPiece,$EC_TresoPiece,$CG_Num,$CG_NumCont,$CT_Num,$EC_Intitule,$N_Reglement,$EC_Echeance,$EC_Sens,$EC_Montant,$CT_NumCont,$TA_Code,$EC_Reference,$TA_Provenance,$EC_StatusRegle,$EC_Lettrage,$EC_MontantRegle){
        return
            "DECLARE @joNum VARCHAR(50) = '$JO_Num'
            DECLARE @ecNo INT = (ISNULL((SELECT MAX(EC_No)EC_No FROM F_ECRITUREC),0)+1)
        DECLARE @jmDate VARCHAR(50) = '$JM_Date'
        DECLARE @ecJour INT = '$EC_Jour'
        DECLARE @ecDate VARCHAR(50) = '$EC_Date'
        DECLARE @ecRefPiece VARCHAR(50) = '$EC_RefPiece'
        DECLARE @ecPiece VARCHAR(50) = '$EC_Piece'
        DECLARE @ecTresoPiece VARCHAR(50) = '$EC_TresoPiece'
        DECLARE @cgNum VARCHAR(50) = '$CG_Num'
        DECLARE @cgNumCont VARCHAR(50) = '$CG_NumCont'
        DECLARE @ecIntitule VARCHAR(50) = '$EC_Intitule'
        DECLARE @nReglement INT = '$N_Reglement'
        DECLARE @ecEcheance VARCHAR(50) = '$EC_Echeance'
        DECLARE @ecSens INT = '$EC_Sens'
        DECLARE @ecMontant FLOAT = '$EC_Montant'
        DECLARE @ecLettrage NVARCHAR(50) = '$EC_Lettrage'
        DECLARE @ctNumCont NVARCHAR(50) = '$CT_NumCont'
        DECLARE @ctNum NVARCHAR(50) = '$CT_Num'
        DECLARE @taCode NVARCHAR(50) = '$TA_Code'
        DECLARE @taProvenance INT = '$TA_Provenance'
        DECLARE @ecReference NVARCHAR(50) = '$EC_Reference'
        DECLARE @ecStatutRegle INT = '$EC_StatusRegle'
        DECLARE @ecMontantRegle FLOAT = '$EC_MontantRegle'
        
           INSERT INTO [F_ECRITUREC]
           ([JO_Num],[EC_No],[EC_NoLink],[JM_Date]
           ,[EC_Jour],[EC_Date],[EC_Piece],[EC_RefPiece]
           ,[EC_TresoPiece],[CG_Num],[CG_NumCont],[CT_Num]
           ,[EC_Intitule],[N_Reglement],[EC_Echeance],[EC_Parite]
           ,[EC_Quantite],[N_Devise],[EC_Sens],[EC_Montant]
           ,[EC_Lettre],[EC_Lettrage],[EC_Point],[EC_Pointage]
           ,[EC_Impression],[EC_Cloture],[EC_CType],[EC_Rappel]
           ,[CT_NumCont],[EC_LettreQ],[EC_LettrageQ],[EC_ANType]
           ,[EC_RType],[EC_Devise],[EC_Remise],[EC_ExportExpert]
           ,[TA_Code],[EC_Norme],[TA_Provenance],[EC_PenalType]
           ,[EC_DatePenal],[EC_DateRelance],[EC_DateRappro],[EC_Reference]
           ,[EC_StatusRegle],[EC_MontantRegle],[EC_DateRegle],[EC_RIB]
           ,[EC_DateOp],[EC_NoCloture],[cbProt],[cbCreateur]
           ,[cbModification],[cbReplication],[cbFlag])
     VALUES 
           (/*JO_Num*/@joNum,/*EC_No*/@ecNo,/*EC_NoLink*/0,/*JM_Date*/@jmDate
           ,/*EC_Jour*/@ecJour,/*EC_Date*/@ecDate,/*EC_Piece*/@ecPiece,/*EC_RefPiece*/@ecRefPiece
           ,/*EC_TresoPiece*/@ecTresoPiece,/*CG_Num*/(CASE WHEN @cgNum='' THEN NULL ELSE @cgNum END)
           ,/*CG_NumCont*/(CASE WHEN @cgNumCont='' THEN NULL ELSE @cgNumCont END),/*CT_Num*/(CASE WHEN @ctNum='' THEN NULL ELSE @ctNum END)
           ,/*EC_Intitule*/@ecIntitule,/*N_Reglement*/@nReglement,/*EC_Echeance*/@ecEcheance,/*EC_Parite*/0
           ,/*EC_Quantite*/0,/*N_Devise*/0,/*EC_Sens*/@ecSens,/*EC_Montant*/@ecMontant
           ,/*EC_Lettre*/0,/*EC_Lettrage*/@ecLettrage,/*EC_Point*/0,/*EC_Pointage*/''
           ,/*EC_Impression*/0,/*EC_Cloture*/0,/*EC_CType*/0,/*EC_Rappel*/0
           ,/*CT_NumCont*/(CASE WHEN @ctNumCont='' THEN NULL ELSE @ctNumCont END),/*EC_LettreQ*/0
           ,/*EC_LettrageQ*/'',/*EC_ANType*/0
           ,/*EC_RType*/0,/*EC_Devise*/0,/*EC_Remise*/0,/*EC_ExportExpert*/0
           ,/*TA_Code*/(CASE WHEN @taCode='' THEN NULL ELSE @taCode END),/*EC_Norme*/0
           ,/*TA_Provenance*/@taProvenance,/*EC_PenalType*/0
           ,/*EC_DatePenal*/'1900-01-01',/*EC_DateRelance*/'1900-01-01',/*EC_DateRappro*/'1900-01-01',/*EC_Reference*/@ecReference
           ,/*EC_StatusRegle*/@ecStatutRegle,/*EC_MontantRegle*/@ecMontantRegle
           ,/*EC_DateRegle*/CASE WHEN @ecStatutRegle = 2 THEN DATEADD(DAY,@ecJour-1,CAST(@jmDate AS DATE)) ELSE '1900-01-01' END,/*EC_RIB*/0
           ,/*EC_DateOp*/'1900-01-01',/*EC_NoCloture*/0,/*cbProt*/0,/*cbCreateur*/'AND'
           ,/*cbModification*/CAST(GETDATE() AS DATE),/*cbReplication*/0,/*cbFlag*/0);
           SELECT @ecNo AS EC_No;";
    }

    function insertFEcritureA($EC_No,$N_Analytique,$CA_Num,$EA_Montant,$EA_Quantite){

        $query = "INSERT INTO [F_ECRITUREA]
                        ([EC_No],[N_Analytique],[EA_Ligne],[CA_Num],[EA_Montant],[EA_Quantite]
                        ,[cbProt],[cbCreateur],[cbModification],[cbReplication],[cbFlag])
                  VALUES
                        (/*EC_No*/$EC_No,/*N_Analytique*/$N_Analytique
                        ,/*EA_Ligne*/ISNULL((SELECT MAX(EA_Ligne)EA_Ligne FROM [F_ECRITUREA] WHERE EC_No=$EC_No),0)+1
                        ,/*CA_Num*/CASE WHEN '$CA_Num' = '' THEN NULL ELSE '$CA_Num' END,/*EA_Montant*/$EA_Montant
                        ,/*EA_Quantite*/$EA_Quantite,/*cbProt*/0,/*cbCreateur*/'AND',/*cbModification*/CAST(GETDATE() AS DATE)
                        ,/*cbReplication*/0,/*cbFlag*/0)";
        return $query;

    }

    function insertFLigneA($cbMarq,$N_Analytique,$CA_Num,$EA_Montant,$EA_Quantite){
        return "INSERT INTO [Z_LIGNE_COMPTEA]
                        ([CbMarq_Ligne],[N_Analytique],[EA_Ligne],[CA_Num],[EA_Montant],[EA_Quantite]
                        ,[cbModification])
                  VALUES
                        (/*CbMarq_Ligne*/$cbMarq,/*N_Analytique*/$N_Analytique,/*EA_Ligne*/ISNULL((SELECT MAX(EA_Ligne)EA_Ligne FROM [Z_LIGNE_COMPTEA] WHERE CbMarq_Ligne=$cbMarq),0)+1
                        ,/*CA_Num*/'$CA_Num',/*EA_Montant*/$EA_Montant,/*EA_Quantite*/$EA_Quantite
                                ,/*cbModification*/CAST(GETDATE() AS DATE))";
    }

    function getLastFCompteA(){
        return "SELECT MAX(cbMarq) cbMarq FROM ".$this->db->baseCompta.".[dbo].[F_ECRITUREA]";
    }

    function supprFEcritureA($cbMarq){
        return "DELETE FROM [F_ECRITUREA] WHERE cbMarq=$cbMarq";
    }

    function supprLigneA($cbMarq){
        return "DELETE FROM [Z_LIGNE_COMPTEA] WHERE cbMarq=$cbMarq";
    }

    function modifFEcritureA($cbMarq,$EC_No,$N_Analytique,$CA_Num,$EA_Montant,$EA_Quantite){
        return "UPDATE [F_ECRITUREA]
                SET CA_Num='$CA_Num',EA_Montant=$EA_Montant,EA_Quantite=$EA_Quantite,cbModification=GETDATE()
                WHERE cbMarq=$cbMarq";
    }

    function modifLigneA($cbMarq,$cbMarqLigne,$N_Analytique,$CA_Num,$EA_Montant,$EA_Quantite){
        return "UPDATE [Z_LIGNE_COMPTEA]
                SET CA_Num='$CA_Num',EA_Montant=$EA_Montant,EA_Quantite=$EA_Quantite,cbModification=GETDATE()
                WHERE cbMarq=$cbMarq";
    }

    function modifLigneAL($cbMarq,$N_Analytique,$CA_Num,$EA_Montant,$EA_Quantite){
        return "UPDATE [Z_LIGNE_COMPTEA]
                SET CA_Num='$CA_Num',EA_Montant=$EA_Montant,EA_Quantite=$EA_Quantite,cbModification=GETDATE()
                WHERE cbMarq_Ligne=$cbMarq AND cbMarq = (SELECT MAX(cbMarq) FROM Z_LIGNE_COMPTEA WHERE cbMarq_Ligne=$cbMarq)";
    }

    function modifFComptetC($EC_No,$JO_Num,$JM_Date,$EC_Jour,$EC_Date,$EC_Piece,$EC_RefPiece,$EC_TresoPiece,$CG_Num,$CG_NumCont,$CT_Num,$EC_Intitule,$N_Reglement,$EC_Echeance,$EC_Sens,$EC_Montant,$CT_NumCont,$TA_Code,$EC_Reference){
        return
            "UPDATE ".$this->db->baseCompta.".dbo.[F_ECRITUREC]
           SET EC_Jour=$EC_Jour,EC_Date='$EC_Date',EC_Piece='$EC_Piece',EC_RefPiece='$EC_RefPiece'
           ,EC_TresoPiece='$EC_TresoPiece',CG_Num='$CG_Num',cbModification=GETDATE()
           ,CG_NumCont='$CG_NumCont',CT_Num=(CASE WHEN '$CT_Num'='' THEN NULL ELSE '$CT_Num' END)
           ,EC_Intitule='$EC_Intitule',N_Reglement=$N_Reglement,EC_Echeance='$EC_Echeance'
           ,EC_Sens=$EC_Sens,EC_Montant=$EC_Montant,EC_Reference='$EC_Reference'
           ,CT_NumCont=(CASE WHEN '$CT_NumCont'='' THEN NULL ELSE '$CT_NumCont' END)
           ,TA_Code=(CASE WHEN '$TA_Code'='' THEN NULL ELSE '$TA_Code' END)
           WHERE EC_No=$EC_No";
    }

    function getModeleReglementByMRNo($mr_no) {
        return "SELECT MR_No,MR_Intitule
                FROM F_MODELER
                WHERE MR_No = $mr_no";
    }

    function getOptionModeleReglementByMRNo($mr_no) {
        return "SELECT E.*,R_Intitule
                FROM F_EMODELER E
                INNER JOIN P_REGLEMENT P ON E.N_Reglement = P.R_Code
                WHERE MR_No = $mr_no";
    }

    public function getSaisieAnal($EC_No,$N_Analytique){
        return "SELECT A.cbMarq,EC_No,A.N_Analytique,EA_Ligne,A.CA_Num,CA_Intitule,EA_Montant,EA_Quantite,A.cbMarq
                FROM F_ECRITUREA A
                LEFT JOIN F_COMPTEA B ON A.CA_Num = B.CA_Num 
                WHERE EC_No=$EC_No
                AND A.N_Analytique=$N_Analytique
                ORDER BY EC_No,EA_Ligne";
    }


    public function getSaisieAnalLigneA($cbMarq,$N_Analytique){
        return "SELECT A.CbMarq_Ligne,A.N_Analytique,EA_Ligne,A.CA_Num,CA_Intitule,EA_Montant,EA_Quantite,A.cbMarq
                FROM Z_LIGNE_COMPTEA A
                LEFT JOIN F_COMPTEA B ON A.CA_Num = B.CA_Num 
                WHERE CbMarq_Ligne=$cbMarq
                AND A.N_Analytique=$N_Analytique
                ORDER BY CbMarq_Ligne,EA_Ligne";
    }

    public function getLigne_compteA($cbMarq){
        return "SELECT A.CbMarq_Ligne,A_Intitule,A.N_Analytique,EA_Ligne,A.CA_Num,CA_Intitule,EA_Montant,EA_Quantite,A.cbMarq
                FROM Z_LIGNE_COMPTEA A
                LEFT JOIN F_COMPTEA B ON A.CA_Num = B.CA_Num 
                LEFT JOIN P_Analytique PA ON PA.cbIndice = A.N_Analytique
                WHERE CbMarq_Ligne=$cbMarq
                ORDER BY CbMarq_Ligne,EA_Ligne";
    }

    function getJournauxByJONum($jo_num) {
        return "SELECT  *
                FROM    F_JOURNAUX J
                WHERE   JO_Num='$jo_num'";
    }

    function getTypeJournal(){
        return "SELECT 0 as ID, 'Achats' Libelle
                UNION
                SELECT 1 as ID, 'Ventes' Libelle
                UNION
                SELECT 2 as ID, 'Trésorerie' Libelle
                UNION
                SELECT 3 as ID, 'Général' Libelle
                UNION
                SELECT 4 as ID, 'Situation' Libelle";
    }

    function getValeurTaux($val,$value){
        if($val==0)
            return "%";
        if($val==1 && $value==0)
            return "Equilibre";
        if($val==2)
            return "F";
    }

    function getTypeConditionVal($val){
        if($val==0)
            return "Jour Net";
        if($val==1)
            return "Fin mois civil";
        if($val==2)
            return "Fin mois";
    }
    function getTypeCondition(){
        return "SELECT 0 as ID, 'Jour Net' Libelle
                UNION
                SELECT 1 as ID, 'Fin mois civil' Libelle
                UNION
                SELECT 2 as ID, 'Fin mois' Libelle";
    }

    function getPieceJournal(){
        return "SELECT 0 as ID, 'Manuelle' Libelle
                UNION
                SELECT 1 as ID, 'Continu pour le journal' Libelle
                UNION
                SELECT 2 as ID, 'Continu pour la base' Libelle
                UNION
                SELECT 3 as ID, 'Mensuelle' Libelle";
    }
    function getRapproJournal(){
        return "SELECT 0 as ID, 'Aucun' Libelle
                UNION
                SELECT 1 as ID, 'Contrepartie' Libelle
                UNION
                SELECT 2 as ID, 'Trésorerie' Libelle";
    }

    function getTypePlanComptable(){
        return "SELECT 0 as ID, 'Détail' Libelle
                UNION
                SELECT 1 as ID, 'Total' Libelle";
    }

    function getNiveauAnalyse(){
        return "SELECT cbIndice,A_Intitule FROM ".$this->db->baseCompta.".dbo.P_Analyse";

    }

    function getNatureCompte(){
        return "SELECT 0 as ID, 'Aucune' Libelle
                UNION
                SELECT 1 as ID, 'Client' Libelle
                UNION
                SELECT 2 as ID, 'Fournisseur' Libelle
                UNION
                SELECT 3 as ID, 'Salarié' Libelle
                UNION
                SELECT 4 as ID, 'Banque' Libelle
                UNION
                SELECT 5 as ID, 'Caisse' Libelle
                UNION
                SELECT 6 as ID, 'Amortissement/Provision' Libelle
                UNION
                SELECT 7 as ID, 'Résultat bilan' Libelle
                UNION
                SELECT 8 as ID, 'Charge' Libelle
                UNION
                SELECT 9 as ID, 'Produit' Libelle
                UNION
                SELECT 10 as ID, 'Résultat Gestion' Libelle
                UNION
                SELECT 11 as ID, 'Immobilisation' Libelle
                UNION
                SELECT 12 as ID, 'Capitaux' Libelle
                UNION
                SELECT 13 as ID, 'Stock' Libelle
                UNION
                SELECT 14 as ID, 'Titre' Libelle";
    }

    function getProvenanceTaxe(){
        return "SELECT 0 as ID, 'Nationale' Libelle
                UNION
                SELECT 1 as ID, 'Intracommunautaire' Libelle
                UNION
                SELECT 2 as ID, 'Export' Libelle
                UNION
                SELECT 3 as ID, 'Div1' Libelle
                UNION
                SELECT 4 as ID, 'Div2' Libelle";
    }

    function getSensTaxe(){
        return "SELECT 0 as ID, 'Déductible' Libelle
                UNION
                SELECT 1 as ID, 'Collectée' Libelle";
    }
    function getTypeTaxe(){
        return "SELECT 0 as ID, 'TVA/Débit' Libelle
                UNION
                SELECT 1 as ID, 'TVA/Encaissement' Libelle
                UNION
                SELECT 2 as ID, 'TP/HT' Libelle
                UNION
                SELECT 3 as ID, 'TP/TTC' Libelle
                UNION
                SELECT 4 as ID, 'TP/Poids' Libelle
                UNION
                SELECT 5 as ID, 'TVA/CEE' Libelle
                UNION
                SELECT 6 as ID, 'Surtaxe Spécifique version espagnole' Libelle
                UNION
                SELECT 7 as ID, 'IRPF' Libelle
                UNION
                SELECT 8 as ID, 'Agraire' Libelle
                UNION
                SELECT 9 as ID, 'IGIC' Libelle";
    }

    function getTypeValeurTaxe(){
        return "SELECT 0 as ID, 'Taux %' Libelle
                UNION
                SELECT 1 as ID, 'Montant F' Libelle
                UNION
                SELECT 2 as ID, 'Quantité U' Libelle"
            ;
    }

    public function getTypeReport(){
        return "SELECT 0 as ID, 'Aucun' Libelle
                UNION
                SELECT 1 as ID, 'Solde' Libelle
                UNION
                SELECT 2 as ID, 'Détail' Libelle";
    }
}
