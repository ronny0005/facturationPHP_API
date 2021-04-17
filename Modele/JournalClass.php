<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class JournalClass Extends Objet{
    //put your code here
    public $db,$JO_Num,$JO_Intitule,$CG_Num,$JO_Type,$JO_NumPiece
    ,$JO_Contrepartie,$JO_SaisAnal,$JO_NotCalcTot,$JO_Rappro
    ,$JO_Sommeil,$JO_IFRS,$JO_Reglement
    ,$JO_SuiviTreso,$cbCreateur,$cbModification;
    public $table = 'F_JOURNAUX';
    public $lien = "fjournaux";

    function __construct($id,$db=null) {
        $this->data = $this->getApiJson("/$id");
        if(sizeof($this->data)>0) {
            $this->JO_Num = $this->data[0]->JO_Num;
            $this->JO_Intitule = stripslashes($this->data[0]->JO_Intitule);
            $this->CG_Num = $this->data[0]->CG_Num;
            $this->JO_Type = $this->data[0]->JO_Type;
            $this->JO_NumPiece = $this->data[0]->JO_NumPiece;
            $this->JO_Contrepartie = stripslashes($this->data[0]->JO_Contrepartie);
            $this->JO_SaisAnal = stripslashes($this->data[0]->JO_SaisAnal);
            $this->JO_NotCalcTot = $this->data[0]->JO_NotCalcTot;
            $this->JO_Rappro = $this->data[0]->JO_Rappro;
            $this->JO_Sommeil = $this->data[0]->JO_Sommeil;
            $this->JO_IFRS = $this->data[0]->JO_IFRS;
            $this->JO_Reglement = $this->data[0]->JO_Reglement;
            $this->JO_SuiviTreso = $this->data[0]->JO_SuiviTreso;
            $this->cbCreateur = $this->data[0]->cbCreateur;
            $this->cbModification = $this->data[0]->cbModification;
        }
    }

    public function maj_journal(){
        parent::maj(JO_Intitule, $this->JO_Intitule);
        parent::maj(CG_Num, $this->CG_Num);
        parent::maj(JO_Type, $this->JO_Type);
        parent::maj(JO_NumPiece, $this->JO_NumPiece);
        parent::maj(JO_Contrepartie, $this->JO_Contrepartie);
        parent::maj(JO_SaisAnal, $this->JO_SaisAnal);
        parent::maj(JO_NotCalcTot, $this->JO_NotCalcTot);
        parent::maj(JO_Rappro, $this->JO_Rappro);
        parent::maj(JO_Sommeil, $this->JO_Sommeil);
        parent::maj(JO_IFRS, $this->JO_IFRS);
        parent::maj(JO_Reglement, $this->JO_Reglement);
        parent::maj(JO_SuiviTreso, $this->JO_SuiviTreso);
        parent::maj(cbCreateur, $this->userName);
        parent::maj(cbModification, $this->cbModification);
    }

    public function getJournaux($val){
        return $this->getApiJson("/getJournaux&joSommeil=$val");
    }

    public function getJournauxReglement($val){
        return $this->getApiJson("/getJournauxReglement&joSommeil=$val");
    }

    public function getJournauxSaufTotaux(){
        return $this->getApiJson("/getJournauxSaufTotaux");
    }

    public function getJournauxType($type,$sommeil=-1){
        return $this->getApiJson("/getJournauxType/$type/$sommeil");
    }


    function getJournauxSaisieSelect($ouvert,$mois,$journal){
        return $this->getApiJson("/getJournauxSaisieSelect/ouvert=$ouvert&mois=$mois&joNum={$this->formatString($journal)}");
    }

    function getJournauxSaisie($ouvert,$NomMois,$JO_Num,$annee){
        return $this->getApiJson("/getJournauxSaisie/ouvert=$ouvert&NomMois=$NomMois&joNum={$this->formatString($JO_Num)}&annee=$annee");
    }

    public function calculSoldeLettrage($listCbMarq){
        if($listCbMarq=="")
            $listCbMarq = 0;
        return $this->getApiJson("/calculSoldeLettrage/listCbMarq=$listCbMarq");
    }
    public function getSaisieJournalExercice($JO_Num,$Mois,$Annee,$CT_Num,$dateDebut,$dateFin,$lettrage,$CG_Num){
        $query= "
                DECLARE @joNum VARCHAR(50) = '$JO_Num';
                DECLARE @Mois INT = $Mois;
                DECLARE @Annee INT = $Annee;
                DECLARE @ctNum NVARCHAR(50) = '$CT_Num';
                DECLARE @dateDebut NVARCHAR(50) = '$dateDebut';
                DECLARE @dateFin NVARCHAR(50) = '$dateFin';
                DECLARE @lettrage INT = '$lettrage';
                DECLARE @cgNum NVARCHAR(50) = '$CG_Num';
                
                SELECT  A.JO_Num
                        ,A.cbMarq
                        ,A.EC_No
                        ,JM_Date
                        ,EC_Jour
                        ,EC_Reference
                        ,EC_Piece
                        ,EC_Date
                        ,A.EC_Lettrage
                        ,EC_RefPiece,EC_TresoPiece
                        ,Lien_Fichier = ISNULL(Lien_Fichier,'')
                        ,A.CG_Num,A.CT_Num,EC_Intitule,N_Reglement
                        ,EC_Echeance,EC_Sens,EC_Montant
                        ,EC_MontantCredit = CASE WHEN EC_Sens=1 THEN EC_Montant ELSE 0 END 
                        ,EC_MontantDebit = CASE WHEN EC_Sens=0 THEN EC_Montant ELSE 0 END 
                        ,EC_Echeance_C = CAST(EC_Echeance AS DATE) 
                        ,B.CG_Analytique
                        ,compteA = CASE WHEN ea.EC_No IS NOT NULL THEN 1 ELSE 0 END
                FROM    F_ECRITUREC A
                LEFT JOIN  F_COMPTEG B 
                    ON  A.CG_Num = B.CG_Num
                LEFT JOIN Z_ECRITURECPIECE C 
                    ON  A.EC_No = C.EC_No
                LEFT JOIN F_ECRITUREA ea
                    ON  ea.EC_No = A.EC_No
                WHERE   (@joNum ='' OR JO_Num=@joNum) 
                AND     (@ctNum ='' OR A.CT_Num=@ctNum) 
                AND     (@cgNum ='' OR A.CG_Num=@cgNum) 
                AND     (   (@dateDebut <>'' OR @dateFin<>'') 
                            OR (@dateDebut ='' AND @dateFin='' AND MONTH(JM_Date) = @Mois))
                AND     YEAR(JM_Date) = @Annee
                AND     (@lettrage = -1 OR A.EC_Lettre = @lettrage)
                AND     (@dateDebut = '' OR CAST(DATEADD(DAY,A.EC_Jour-1,A.JM_Date) AS DATE) >= @dateDebut)
                AND     (@dateFin = '' OR CAST(DATEADD(DAY,A.EC_Jour-1,A.JM_Date) AS DATE) <= @dateFin)
                ORDER BY A.cbMarq";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function headerSaisiJournal ($anneeExercice,$joNum,$position = 0){
        $query = "
                DECLARE @exercice AS INT = $anneeExercice; 
                DECLARE @joNum AS VARCHAR(50) = '$joNum'; 
                DECLARE @position AS INT = $position; 
                DECLARE @debutExercice AS INT = CONCAT(LEFT(@exercice,4),'01')
                DECLARE @annee AS INT = LEFT(@exercice,4); 
                
                WITH _AncienSolde_ AS (
                    SELECT	Debit = SUM(CASE WHEN C.EC_Sens=0 THEN C.EC_Montant ELSE -C.EC_Montant END)
                            ,Credit = SUM(CASE WHEN C.EC_Sens=1 THEN C.EC_Montant ELSE -C.EC_Montant END)
                            ,Total = SUM(CASE WHEN C.EC_Sens=1 THEN C.EC_Montant ELSE -C.EC_Montant END)
                    FROM	F_ECRITUREC C
                    LEFT JOIN F_JOURNAUX J 
                    ON		C.CG_Num=J.CG_Num
                    WHERE	YEAR(C.JM_Date) = @annee
                    AND		(
                    (J.JO_Num=@joNum
                    AND		C.JO_Num<>@joNum)
                    OR 
                    (C.JO_Num=@joNum
                        AND	MONTH(JM_Date) < RIGHT(@exercice,2)
                        AND C.CG_Num IN (	SELECT	CG_Num 
                                    FROM	F_JOURNAUX 
                                    WHERE	JO_Num=@joNum))				
                    )
                )
                ,_TotalSolde_ AS (
                    SELECT	Debit = SUM(CASE WHEN EC_Sens=0 THEN EC_Montant ELSE 0 END)
                            ,Credit = SUM(CASE WHEN EC_Sens=1 THEN EC_Montant ELSE 0 END)
                            ,Total = SUM(CASE WHEN EC_Sens=1 THEN EC_Montant ELSE -EC_Montant END)
                    FROM	F_ECRITUREC
                    WHERE	YEAR(JM_Date) = LEFT(@exercice,4)
                    AND		JO_Num = @joNum
                    AND		Month(JM_Date) = RIGHT(@exercice,2)
                )
                ,_NouveauSolde_ AS (
                    SELECT	Debit = SUM(CASE WHEN EC_Sens=0 THEN (EC_Montant) ELSE 0 END)-SUM(CASE WHEN EC_Sens=1 THEN (EC_Montant) ELSE 0 END)
                            ,Credit = SUM(CASE WHEN EC_Sens=1 THEN (EC_Montant) ELSE 0 END)-SUM(CASE WHEN EC_Sens=0 THEN (EC_Montant) ELSE 0 END)
                            ,Total = SUM(CASE WHEN EC_Sens=1 THEN (EC_Montant) ELSE -EC_Montant END)
                    FROM	F_ECRITUREC C
                    LEFT JOIN F_JOURNAUX J 
                    ON		C.CG_Num=J.CG_Num
                    WHERE YEAR(C.JM_Date) = LEFT(@annee,4)
                    AND (
                        (C.JO_Num=@joNum
                        AND	MONTH(JM_Date) <= RIGHT(@exercice,2)
                        AND C.CG_Num IN (	SELECT	CG_Num 
                                    FROM	F_JOURNAUX 
                                    WHERE	JO_Num=@joNum))
                
                        OR (J.JO_Num=@joNum
                            AND	C.JO_Num<>@joNum))
                
                )
                ,_NouveauSoldeFinal_ AS (
                    SELECT	Debit
                                ,Credit
                                ,Total
                        FROM	_NouveauSolde_
                )
                SELECT  Position
                        ,Libelle
                        ,Debit
                        ,Credit
                        ,Total
                FROM (
                    SELECT	Position = 1
                            ,Libelle = 'Ancien solde' 
                            ,Debit = CASE WHEN Debit<0 THEN 0 ELSE Debit END
                            ,Credit = CASE WHEN Credit<0 THEN 0 ELSE Credit END
                            ,Total = ABS(Total)
                    FROM	_AncienSolde_
                    UNION ALL
                    SELECT	Position = 2
                            ,Libelle = 'Total journal' 
                            ,Debit
                            ,Credit
                            ,Total
                    FROM	_TotalSolde_
                    UNION ALL 
                    SELECT	Position = 3
                            ,Libelle = 'Nouveau solde' 
                            ,Debit = CASE WHEN Debit<0 THEN 0 ELSE Debit END
                            ,Credit = CASE WHEN Credit<0 THEN 0 ELSE Credit END
                            ,ABS(Total)
                    FROM _NouveauSoldeFinal_
                ) unionSaisie 
                WHERE @position = 0 OR @position = Position
                ";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);

    }
    public function getTotalJournal($JO_Num,$Mois,$Annee,$sens,$CT_Num,$dateDebut,$dateFin,$lettrage,$CG_Num){
        $query= "
                DECLARE @joNum VARCHAR(50) ='$JO_Num';
                DECLARE @Mois INT =$Mois;
                DECLARE @Annee INT =$Annee;
                DECLARE @sens INT =$sens;
                DECLARE @ctNum NVARCHAR(50) ='$CT_Num';
                DECLARE @cgNum NVARCHAR(50) ='$CG_Num';
                DECLARE @dateDebut NVARCHAR(50) ='$dateDebut';
                DECLARE @dateFin NVARCHAR(50) ='$dateFin';
                DECLARE @lettrage INT ='$lettrage';
                
                SELECT EC_Montant = CASE WHEN @sens = 0 THEN ABS(EC_Montant) ELSE EC_Montant END
                FROM(
                SELECT  EC_Montant = SUM(CASE WHEN EC_Sens = 1 THEN EC_Montant ELSE - EC_Montant END) 
                FROM    F_ECRITUREC A
                LEFT JOIN   F_COMPTEG B 
                    ON  A.CG_Num = B.CG_Num
                LEFT JOIN   Z_ECRITURECPIECE C 
                    ON  A.EC_No = C.EC_No
                WHERE   (@joNum ='' OR JO_Num=@joNum) 
                AND     (@ctNum ='' OR A.CT_Num=@ctNum) 
                AND     (@cgNum ='' OR A.CG_Num=@cgNum) 
                AND     (   (@dateDebut <>'' OR @dateFin<>'') 
                            OR (@dateDebut ='' AND @dateFin='' AND MONTH(JM_Date) = @Mois) )
                AND     YEAR(JM_Date) = @Annee
                AND     (@sens=2 OR EC_Sens = @sens)
                AND     (@lettrage = -1 OR A.EC_Lettre = @lettrage)
                AND     (@dateDebut = '' OR CAST(DATEADD(DAY,A.EC_Jour-1,A.JM_Date) AS DATE) >= @dateDebut)
                AND     (@dateFin = '' OR CAST(DATEADD(DAY,A.EC_Jour-1,A.JM_Date) AS DATE) <= @dateFin)
                )A
                ";
        $result= $this->db->query($query);
        $row = $result->fetchAll(PDO::FETCH_OBJ);
        $result = 0;
        if(sizeof($row)>0)
            $result = $row[0]->EC_Montant;

        $list = ["EC_Montant" => $result];
        return (object)$list;
    }

    public function getJournalLastDate($JO_Num,$Mois,$Annee){
        $query= "
                DECLARE @joNum VARCHAR(50) ='$JO_Num';
                DECLARE @Mois INT =$Mois;
                DECLARE @Annee INT =$Annee;
                
                SELECT  EC_Jour = ISNULL(MAX(EC_Jour),1)
                FROM    F_ECRITUREC A
                LEFT JOIN  F_COMPTEG B 
                    ON  A.CG_Num = B.CG_Num
                LEFT JOIN Z_ECRITURECPIECE C 
                    ON  A.EC_No = C.EC_No
                WHERE   JO_Num=@joNum 
                AND     MONTH(JM_Date) = @Mois
                AND     YEAR(JM_Date) = @Annee
                ";
        $result= $this->db->query($query);
        $row = $result->fetchAll(PDO::FETCH_OBJ);
        $result = 1;
        if(sizeof($row)>0)
            $result = $row[0]->EC_Jour;
        $list = ["EC_Jour" => $result];
        return (object)$list;
    }

    public function getJournalPiece($date){
        $query= "
                DECLARE @joNum VARCHAR(50) ='{$this->JO_Num}';
                DECLARE @date VARCHAR(10)= '$date';
                DECLARE @ecPiece INT =1;
                
                WITH _MaxPiece_ AS (
                    SELECT  EC_Montant = SUM(CASE WHEN EC_Sens = 1 THEN EC_Montant ELSE - EC_Montant END)
                            ,MaxEC_Piece = MAX(EC_Piece)
                    FROM    F_ECRITUREC C
                    WHERE   JO_Num=@joNum 
                    AND     JM_Date = @date
                )
                
                SELECT	@ecPiece = CASE WHEN EC_Montant = 0 THEN ISNULL(TRY_CAST(MaxEC_Piece AS INT),0)+1 ELSE ISNULL(MaxEC_Piece,1) END
                FROM	_MaxPiece_ 
                
                SELECT EC_Piece = @ecPiece
                ";
        $result= $this->db->query($query);
        $row = $result->fetchAll(PDO::FETCH_OBJ);
        $result = 1;
        if(sizeof($row)>0)
            $result = $row[0]->EC_Piece;
        $list = ["EC_Piece" => $result];
        return (object)$list;
    }

    public function getECPiece($date,$typeFacture,$doPiece){
        $query = "
                    BEGIN 
                    DECLARE @joNum VARCHAR(50) = '{$this->JO_Num}'
                    DECLARE @joNumPiece INT = 0
                    DECLARE @date VARCHAR(10)= '$date'
                    DECLARE @typeFacture INT = $typeFacture;
                    DECLARE @doPiece NVARCHAR(50) = '$doPiece';
                    DECLARE @typeFormat INT;
                    SELECT  @typeFormat = CASE WHEN @typeFacture = 1 THEN P_Piece01 ELSE P_Piece03 END 
                    FROM    P_PARAMETRECIAL;
                    
                    SELECT @joNumPiece = JO_NumPiece FROM F_JOURNAUX WHERE JO_Num=@joNum
                    
                    IF @typeFormat = 0 
                        SELECT	EC_Piece = @doPiece
                        
                    IF @joNumPiece = 1 AND @typeFormat = 1
                        SELECT	EC_Piece = ISNULL(MAX(TRY_CAST(EC_Piece AS INT)),0) + 1
                        FROM	F_ECRITUREC 
                        WHERE	JO_Num=@joNum
                    	AND     TRY_CAST(EC_Piece AS INT) IS NOT NULL
                    IF @joNumPiece = 2 AND @typeFormat = 1  	
                        SELECT	EC_Piece = ISNULL(MAX(TRY_CAST(EC_Piece AS INT)),0) + 1
                        FROM	F_ECRITUREC 
                    	WHERE   TRY_CAST(EC_Piece AS INT) IS NOT NULL
                    IF @joNumPiece = 3 AND @typeFormat = 1  
                        SELECT	EC_Piece = ISNULL(MAX(TRY_CAST(EC_Piece AS INT)),0) + 1
                        FROM	F_JOURNAUX fj
                        LEFT JOIN (SELECT JO_Num,EC_Piece
                                  FROM F_ECRITUREC 
                                  WHERE JM_Date = @date) ec	
                            ON	ec.JO_Num = fj.JO_Num
                        WHERE	fj.JO_Num=@joNum
                    	AND     TRY_CAST(EC_Piece AS INT) IS NOT NULL
                        END";

        $result= $this->db->query($query);
        $row = $result->fetchAll(PDO::FETCH_OBJ);
        $result = 0;
        if(sizeof($row)>0)
            $result = $row[0]->EC_Piece;
        $list = ["EC_Piece" => $result];
        return (object)$list;
    }
    public function getLettrage($CT_Num,$dateDebut,$dateFin,$CG_Num){
        $query= "
                BEGIN 
				DECLARE @result VARCHAR(10);
				DECLARE @ctNum VARCHAR(50) ='$CT_Num';
				DECLARE @cgNum VARCHAR(50) ='$CG_Num';
                DECLARE @dateDebut NVARCHAR(50) ='$dateDebut';
                DECLARE @dateFin NVARCHAR(50) ='$dateFin';
                
				SELECT  @result = CHAR(ASCII(EC_Lettrage)+1)
                FROM    F_ECRITUREC A
                WHERE   EC_Lettre=1
				AND		(@ctNum='' OR CT_Num=@ctNum)
                AND		(@cgNum='' OR CG_Num=@cgNum)
                AND     (@dateDebut = '' OR CAST(DATEADD(DAY,A.EC_Jour-1,A.JM_Date) AS DATE) >= @dateDebut)
                AND     (@dateFin = '' OR CAST(DATEADD(DAY,A.EC_Jour-1,A.JM_Date) AS DATE) <= @dateFin)
                
				select EC_Lettrage = ISNULL(@result,'A')
				END
                ";
        $result= $this->db->query($query);
        $row = $result->fetchAll(PDO::FETCH_OBJ);
        $result = 1;
        if(sizeof($row)>0)
            $result = $row[0]->EC_Lettrage;
        $list = ["EC_Lettrage" => $result];
        return (object)$list;
    }

    public function pointerEcriture($annuler,$listCbMarq,$ecLettrage){
        $query = "  BEGIN
                        SET NOCOUNT ON;
                        DECLARE @amount FLOAT;
                        DECLARE @result INT;
                        DECLARE @annuler INT = $annuler;
                        DECLARE @ecLettrage VARCHAR(50) = '$ecLettrage';
                        SELECT  @amount = SUM(CASE WHEN EC_Sens = 1 THEN EC_Montant ELSE - EC_Montant END) 
                        FROM    F_ECRITUREC
                        WHERE   cbMarq IN ($listCbMarq)
                        
                        IF  @amount=0 
                            BEGIN 
                                UPDATE F_ECRITUREC SET EC_Lettre = @annuler
                                                    ,EC_Lettrage = @ecLettrage 
                                WHERE cbMarq IN ($listCbMarq)
                                SELECT @result = 1
                            END 
                        ELSE 
                            BEGIN 
                                SELECT @result = 0
                            END
                            SELECT Result = @result 
                    END ";
        $result= $this->db->query($query);
        $row = $result->fetchAll(PDO::FETCH_OBJ);
        $result = 1;
        if(sizeof($row)>0)
            $result = $row[0]->Result;
        $list = ["Result" => $result];
        return (object)$list;
    }

    public function __toString() {
        return "";
    }

}