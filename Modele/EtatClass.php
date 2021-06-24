<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class EtatClass extends Objet {
    //put your code here
    public $db;
    public $lien = 'etat';

    function __construct()
    {
        $this->db = new DB();
    }


    public function statCaisseDuJour($protNo){
        return $this->getApiJson("/statCaisseDuJour&protNo=$protNo");
    }

    public function detteDuMois($protNo,$period=0){
        return $this->getApiJson("/detteDuMois&protNo=$protNo&period=$period");
    }

    public function top10Vente($period,$time=0){
        return $this->getApiJson("/top10Vente&period=$period&time=$time&protNo={$_SESSION["id"]}");
    }

    public function ech_client($centre, $datedeb, $datefin,$clientdebut,$clientfin,$type_reg,$facCompta,$typeTiers)
    {
        $query = "
    WITH _Ligne_ AS (
        SELECT  DO_Domaine,DO_Type,cbDO_Piece, SUM(DL_MontantTTC) DL_MontantTTC 
        FROM    F_DOCLIGNE
        WHERE (($typeTiers =0 AND DO_Domaine = 0) OR ($typeTiers =1 AND DO_Domaine = 1))
        AND     (($facCompta=0 AND (   ($typeTiers =0 AND DO_Type in (6,7)) OR ($typeTiers =1 AND DO_Type in (16,17)) ) 
                    OR ($facCompta=1 AND ($typeTiers =0 AND DO_Type in (6)) OR ($typeTiers =1 AND DO_Type in (16)) ) 
                    OR ($facCompta=2 AND ($typeTiers =0 AND DO_Type in (7)) OR ($typeTiers =1 AND DO_Type in (17)) ))) 
        GROUP BY DO_Domaine,DO_Type,cbDO_Piece
    )
    ,_Reglement_ AS (
        	SELECT DO_Domaine,DO_Type,cbDO_Piece,MAX(DR_No)DR_No,MAX(CT_NumPayeur) CT_NumPayeur,MAX(RG_Montant)RG_Montant,SUM(RC_Montant) RC_Montant
            FROM F_CREGLEMENT A 
            LEFT JOIN F_REGLECH B 
                ON A.RG_No = B.RG_No
            WHERE RG_Type IN (0,1)
            AND (($typeTiers =0 AND DO_Domaine = 0) OR ($typeTiers =1 AND DO_Domaine = 1))
            AND     (($facCompta=0 AND (   ($typeTiers =0 AND DO_Type in (6,7)) OR ($typeTiers =1 AND DO_Type in (16,17)) ) 
                OR ($facCompta=1 AND ($typeTiers =0 AND DO_Type in (6)) OR ($typeTiers =1 AND DO_Type in (16)) ) 
                OR ($facCompta=2 AND ($typeTiers =0 AND DO_Type in (7)) OR ($typeTiers =1 AND DO_Type in (17)) ))) 
            GROUP BY DO_Domaine,DO_Type,cbDO_Piece
    )
    SELECT *
FROM(
SELECT DO_Tiers,D.CT_NumPayeur,CASE WHEN DO_Tiers IS NULL THEN D.cbCT_NumPayeur ELSE cbDO_Tiers END cbTiers
     ,CASE WHEN DO_Tiers IS NULL THEN D.CT_NumPayeur ELSE DO_Tiers END Tiers,A.DO_Domaine,A.DO_Type,A.DO_Piece,DL_MontantTTC,RG_Montant,RC_Montant,ISNULL(DR_Regle,0) DR_Regle
                    FROM F_DOCENTETE A
                    LEFT JOIN _Ligne_ B 
                        ON A.DO_Domaine=B.DO_Domaine 
                        AND A.DO_Type=B.DO_Type 
                        AND A.cbDO_Piece=B.cbDO_Piece
                    LEFT JOIN F_DOCREGL C 
                        ON  C.DO_Domaine = A.DO_Domaine 
                        AND C.DO_Type = A.DO_Type 
                        AND C.cbDO_Piece = A.cbDO_Piece
                    FULL OUTER JOIN _Reglement_ D 
                        ON D.DO_Domaine = A.DO_Domaine 
                       AND D.DO_Type = A.DO_Type 
                       AND D.cbDO_Piece = A.cbDO_Piece 
                       AND C.DR_No = D.DR_No)A
                    WHERE ('-1'= $type_reg OR ISNULL(DR_Regle,0) = '$type_reg')
                    AND         ('0'='$clientdebut' OR cbTiers>='$clientdebut') 
                    AND ('0'='$clientfin' OR Tiers<='$clientfin')";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function etatCommande($de_no,$ar_refdebut,$ar_reffin,$famille){
        $query ="   DECLARE @DE_No AS INT
                    DECLARE @AR_RefDebut AS VARCHAR(30)
                    DECLARE @AR_RefFin AS VARCHAR(30)
                    DECLARE @FA_CodeFamille AS VARCHAR(30)
                    SET @DE_No=$de_no
                    SET @AR_RefDebut='$ar_refdebut'
                    SET @AR_RefFin='$ar_reffin'
                    SET @FA_CodeFamille='$famille'
                    SELECT *
                    FROM(
                    SELECT a.AR_Ref
                            ,AR_Design
                            ,SUM(AS_QteSto)AS_QteSto
                            ,SUM(AS_QteMini) AS AS_QteMini
                            ,SUM(AS_QteMaxi) AS_QteMaxi
                            ,SUM(AS_QteMini) - SUM(AS_QteSto) as QteCommande
                    FROM F_ARTSTOCK A
                    INNER JOIN F_ARTICLE B 
                        ON A.cbAR_Ref=B.cbAR_Ref
                    WHERE (0=@DE_No OR DE_No=@DE_No)
                    AND ('0'=@AR_RefDebut OR a.cbAR_Ref>=@AR_RefDebut)
                    AND ('0'=@AR_RefFin OR a.cbAR_Ref<=@AR_RefFin)
                    AND ('0'=@FA_CodeFamille OR cbFA_CodeFamille=@FA_CodeFamille)
                    AND AS_QteMini<>0
                    GROUP BY a.AR_Ref,AR_Design)A
                    WHERE QteCommande>0";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }


    public function etat_balance_tiers($datedeb, $datefin,$type_tiers,$clientdeb,$clientfin,$depot)
    {
        return "DECLARE @P1 datetime
DECLARE @P2 datetime
DECLARE @P3 datetime
DECLARE @P4 datetime
DECLARE @P5 datetime
DECLARE @P6 datetime
DECLARE @P7 datetime
DECLARE @P8 datetime
DECLARE @P9 varchar(256)
DECLARE @P10 varchar(256)
DECLARE @P11 smallint
DECLARE @P12 smallint
DECLARE @P13 varchar(256)
DECLARE @P14 varchar(256)
DECLARE @P15 smallint
DECLARE @P16 datetime
DECLARE @P17 datetime
DECLARE @P18 smallint
DECLARE @P19 smallint

SET @P1 ='$datedeb'
SET @P2 ='$datedeb'
SET @P3 ='$datedeb'
SET @P4 ='$datedeb'
SET @P5 ='$datedeb'
SET @P6 ='$datedeb'
SELECT @P7 =CONCAT(LEFT('$datedeb',4),'-01-01')
SET @P8 ='$datefin'
SET @P9 ='$clientdeb'
SET @P10 ='$clientfin'
SET @P11 =$type_tiers
SET @P12 =1
SET @P13 ='$clientdeb'
SET @P14 ='$clientfin'
SET @P15 =$type_tiers
SELECT @P16 =CONCAT(LEFT('$datedeb',4),'-01-01')
SET @P17 ='$datefin'
SET @P18 =1
SET @P19 =$depot

SELECT *,
CASE WHEN tiersD>tiersC THEN tiersD-tiersC ELSE 0 END CumulD,
CASE WHEN tiersD<tiersC THEN tiersC-tiersD ELSE 0 END CumulC
FROM(
SELECT A.CT_Num,A.CT_Intitule,A.CT_Saut,tiersAntD,tiersAntC,tiersD,tiersC,tiersAND,tiersANC
	FROM
	(
		SELECT fCptT.CT_Num,fCptT.CT_Intitule,fCptT.CT_Saut,
			 	SUM(case when (DATEADD(d,fEcg.EC_Jour - 1,fEcg.JM_Date) < @P1 AND fEcg.EC_Sens = 0) then fEcg.EC_Montant else 0 end) tiersAntD,
			 	SUM(case when (DATEADD(d,fEcg.EC_Jour - 1,fEcg.JM_Date) < @P2 AND fEcg.EC_Sens = 1) then fEcg.EC_Montant else 0 end) tiersAntC,
			SUM(case when (DATEADD(d,fEcg.EC_Jour - 1,fEcg.JM_Date) >= @P3 AND fEcg.EC_ANType = 0 AND fEcg.EC_Sens = 0) then fEcg.EC_Montant else 0 end) tiersD,
			SUM(case when (DATEADD(d,fEcg.EC_Jour - 1,fEcg.JM_Date) >= @P4 AND fEcg.EC_ANType = 0 AND fEcg.EC_Sens = 1) then fEcg.EC_Montant else 0 end) tiersC,
			SUM(case when (DATEADD(d,fEcg.EC_Jour - 1,fEcg.JM_Date) >= @P5 AND fEcg.EC_ANType > 0 AND fEcg.EC_Sens = 0) then fEcg.EC_Montant else 0 end) tiersAND,
			SUM(case when (DATEADD(d,fEcg.EC_Jour - 1,fEcg.JM_Date) >= @P6 AND fEcg.EC_ANType > 0 AND fEcg.EC_Sens = 1) then fEcg.EC_Montant else 0 end) tiersANC
		FROM F_COMPTET fCptT
		INNER JOIN F_ECRITUREC fEcg
			ON fCptT.cbCT_Num = fEcg.cbCT_Num
		 INNER JOIN F_JOURNAUX fCjr
			ON fEcg.cbJO_Num = fCjr.cbJO_Num
		 LEFT JOIN (SELECT A.DE_No,JO_Num
					FROM Z_DEPOTCAISSE A
					INNER JOIN F_CAISSE B ON A.CA_No=B.CA_No) A ON A.JO_Num = fCjr.JO_Num

		WHERE DATEADD(d,fEcg.EC_Jour - 1,fEcg.JM_Date) >= @P7 AND DATEADD(d,fEcg.EC_Jour - 1,fEcg.JM_Date) <= @P8
			AND fCptT.CT_Num >= @P9
			AND fCptT.CT_Num <= @P10
			AND fCptT.CT_Type = @P11
		
			AND (EC_Norme = 0 OR EC_Norme = @P12)
		
			AND JO_Type BETWEEN 0 AND 3
			AND (@P19=0 OR A.DE_No= @P19)
		GROUP BY fCptT.CT_Num,fCptT.CT_Intitule,fCptT.CT_Saut
		
		 UNION
		
		SELECT fCptT.CT_Num,fCptT.CT_Intitule,fCptT.CT_Saut,0,0,0,0,0,0
		FROM F_COMPTET fCptT
		WHERE
				fCptT.CT_Num >= @P13
				 AND fCptT.CT_Num <= @P14
				 AND fCptT.CT_Type = @P15
			 AND fCptT.cbCT_Num NOT IN
				(SELECT fEcg.cbCT_Num
				FROM F_ECRITUREC fEcg
				 INNER JOIN F_JOURNAUX fCjr
					ON fEcg.cbJO_Num = fCjr.cbJO_Num
		 LEFT JOIN (SELECT A.DE_No,JO_Num
					FROM Z_DEPOTCAISSE A
					INNER JOIN F_CAISSE B ON A.CA_No=B.CA_No) A ON A.JO_Num = fCjr.JO_Num
				WHERE DATEADD(d,fEcg.EC_Jour - 1,fEcg.JM_Date) >= @P16 AND DATEADD(d,fEcg.EC_Jour - 1,fEcg.JM_Date) <= @P17
				
					AND (EC_Norme = 0 OR EC_Norme = @P18)
				
					AND JO_Type BETWEEN 0 AND 3
					AND (@P19=0 OR A.DE_No= @P19))
		GROUP BY fCptT.CT_Num,fCptT.CT_Intitule,fCptT.CT_Saut
	) A) A 
	WHERE tiersAntC+tiersAntD+tiersD+tiersC+tiersANC+tiersAND<>0
	ORDER BY A.CT_Num";
    }

    public function stat_collaborateurClient($depot, $datedeb, $datefin,$do_type){
        return "SELECT CO_Nom, CT_Num,CT_Intitule,SUM(CA_NET_HT) CA_NET_HT, SUM(CA_NET_TTC) CA_NET_TTC, SUM(CA_NET_HT)-SUM(PrxRevientU) MARGE, SUM(CAHTBrut)CAHTBrut, SUM(Rem) Rem
FROM(SELECT *,CASE WHEN (DO_Type=4 OR DO_Type=14) THEN -CAHTBrut ELSE CAHTBrut END Rem
	FROM(
	SELECT	ISNULL(CO_Nom,'') CO_Nom,CT_Intitule,fDoc.CT_Num,DO_Type, 
	CASE WHEN (fDoc.DO_Type = 4 OR fDoc.DO_Type = 5 OR fDoc.DO_Type = 14 OR fDoc.DO_Type = 15)
								THEN -DL_MontantHT 
								ELSE DL_MontantHT
								END AS CA_NET_HT,CASE WHEN (fDoc.DO_Type = 4 OR fDoc.DO_Type = 5 OR fDoc.DO_Type = 14 OR fDoc.DO_Type = 15)
								THEN -DL_MontantTTC 
								ELSE DL_MontantTTC
								END AS CA_NET_TTC,  
	DL_Qte*(DL_PrixUnitaire-DL_PrixRU) AS MARGE, 
	CASE WHEN (DL_TRemPied>0 OR DL_TRemExep>0 OR 
		DO_Type=5 OR DO_Type=15 OR DL_TypePL=2 OR DL_TypePL=3) THEN 0
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
		END CAHTBrut,
                (CASE WHEN fDoc.cbAR_Ref =convert(varbinary(255),AR_RefCompose) THEN
							(select SUM(toto)
									from (SELECT  
												CASE WHEN fDoc2.DL_TRemPied = 0 AND fDoc2.DL_TRemExep = 0 THEN
													CASE WHEN (fDoc2.DL_FactPoids = 0 OR fArt2.AR_SuiviStock > 0 OR fDoc2.DO_Domaine = 1) THEN
														CASE WHEN fDoc2.DO_Type <= 2 THEN
															fDoc2.DL_Qte * fDoc2.DL_CMUP
														ELSE
															CASE WHEN (
																		fDoc2.DO_Type = 4 OR fDoc2.DO_Type = 14
																		
																		)
															THEN
																	fDoc2.DL_PrixRU * (-fDoc2.DL_Qte)
															ELSE
																	fDoc2.DL_PrixRU * fDoc2.DL_Qte
															END
														END
													ELSE CASE WHEN (fDoc2.DO_Type = 4 OR fDoc2.DO_Type = 14
																	
																	) THEN
															fDoc2.DL_PrixRU * (-fDoc2.DL_PoidsNet) / 1000
														 ELSE
															fDoc2.DL_PrixRU * fDoc2.DL_PoidsNet / 1000
														END
													END
												ELSE 0
												END toto
										FROM F_DOCLIGNE fDoc2 INNER JOIN F_ARTICLE fArt2 ON (fArt2.cbAR_Ref = fDoc2.cbAR_Ref) 
										WHERE fDoc.cbAR_Ref =convert(varbinary(255),fDoc2.AR_RefCompose)
										AND fDoc2.DL_Valorise<>fDoc.DL_Valorise
										AND fDoc2.cbDO_Piece=fDoc.cbDO_Piece 
										AND fDoc2.DO_Type=fDoc.DO_Type
										AND fDoc2.DL_Ligne > fDoc.DL_Ligne
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
									CASE WHEN (fDoc.DL_FactPoids = 0 OR fArt.AR_SuiviStock > 0 OR fDoc.DO_Domaine = 1) THEN
										CASE WHEN fDoc.DO_Type <= 2 THEN
											fDoc.DL_Qte * fDoc.DL_CMUP
										ELSE
											CASE WHEN (
														fDoc.DO_Type = 4 OR fDoc.DO_Type = 14
														)
											THEN
													fDoc.DL_PrixRU * (-fDoc.DL_Qte)
											ELSE
													fDoc.DL_PrixRU * fDoc.DL_Qte
											END
										END
									ELSE CASE WHEN (fDoc.DO_Type = 4 OR fDoc.DO_Type = 14
													) THEN
											fDoc.DL_PrixRU * (-fDoc.DL_PoidsNet) / 1000
										 ELSE
											fDoc.DL_PrixRU * fDoc.DL_PoidsNet / 1000
										END
									END
								ELSE 0
								END
							END) PrxRevientU,
	(CASE WHEN (DL_MontantHT)<>0 THEN (((DL_Qte*(DL_PrixUnitaire-DL_PrixRU))/(DL_MontantHT))*100) ELSE 0 END) AS MARGE_CA 
	FROM F_DOCLIGNE fDoc
	INNER JOIN F_ARTICLE fArt 
	ON fArt.AR_Ref = fDoc.AR_Ref
	LEFT JOIN dbo.F_COMPTET  CO
	ON CO.CT_Num = fDoc.CT_Num
	INNER JOIN F_DEPOT D  
	ON D.DE_No = fDoc.DE_No 
	LEFT JOIN dbo.F_COLLABORATEUR C  
	ON C.CO_No = fDoc.CO_No
	WHERE  ('$depot'='0' OR D.DE_No = $depot) 
	AND fArt.AR_HorsStat = 0 
	AND		DO_Date >= '$datedeb' AND DO_Date <= '$datefin' 
    AND ($do_type = 2 AND fDoc.DO_Type IN (30)
    OR $do_type = 7 AND fDoc.DO_Type IN (7,30)
    OR $do_type = 6 AND fDoc.DO_Type IN (6,7,30)
    OR $do_type = 3 AND fDoc.DO_Type IN (6,7,30,3))
    AND		fDoc.AR_Ref IS NOT NULL)A
	)A
	GROUP BY CO_Nom,CT_Num,CT_Intitule
	ORDER BY 1,2";
    }


    public function etatDette($depot_no, $datedeb, $datefin,$client,$ct_num){
        $query=" DECLARE @ctNum NVARCHAR(150) = '$ct_num';
                 DECLARE @dateDebut NVARCHAR(150) = '$datedeb';
                 DECLARE @dateFin NVARCHAR(150) = '$datefin';
                 DECLARE @depot INT = '$depot_no';
                 
                WITH _REGLECH_ AS (
                            SELECT  DO_Piece,cbDO_Piece,DO_Domaine,DO_Type, SUM(RC_Montant) RC_Montant 
                            FROM    F_REGLECH
                            GROUP BY DO_Piece,cbDO_Piece,DO_Domaine,DO_Type)
                , _DOCLIGNE_ AS (
                    SELECT  ent.DO_Domaine,ent.DO_Provenance,ent.DO_Type,ent.cbDO_Piece,ent.DO_Piece,cbDO_Tiers,ent.DO_Tiers,ent.DE_No,ent.DO_Date, SUM(DL_MontantTTC) DL_MontantTTC 
                    FROM    F_DOCENTETE ent
                    INNER JOIN F_DOCLIGNE lig
                        ON  ent.DO_Domaine=lig.DO_Domaine
                        AND ent.DO_Type = lig.DO_Type
                        AND ent.cbDO_Piece = lig.cbDO_Piece 
                    GROUP BY ent.DO_Domaine,ent.DO_Provenance,ent.DO_Type,ent.cbDO_Piece,ent.DO_Piece,ent.cbDO_Tiers,ent.DO_Tiers,ent.DE_No,ent.DO_Date)
                SELECT  $client C.CT_NUM,CT_Intitule
                            ,RC_Montant = SUM(CASE WHEN L.DO_Provenance = 1 THEN ABS(DL_MontantTTC) ELSE ISNULL(RC_Montant,0) END)
                            ,DL_MontantTTC = SUM(CASE WHEN L.DO_Provenance = 1 THEN ISNULL(RC_Montant,0) ELSE DL_MontantTTC END) 
                            , MONTANT = SUM(DL_MontantTTC) - SUM(ISNULL(RC_Montant,0)) 
                FROM    _DOCLIGNE_ L
                INNER JOIN 	F_COMPTET C
                    ON  L.DO_Tiers = C.CT_Num
                INNER JOIN	F_DOCREGL D 
                    ON  L.DO_Piece=D.DO_Piece 
                    AND DR_Regle = 0
                LEFT JOIN _REGLECH_ RE 
                    ON  L.DO_Piece=RE.DO_Piece 
                    AND L.DO_Domaine=RE.DO_Domaine 
                    AND L.DO_Type=RE.DO_Type
                INNER JOIN  F_DEPOT DE 
                    ON  L.DE_No = DE.DE_No
                WHERE	L.DO_Type IN (6,7)
                AND		l.DO_Date >= @dateDebut AND l.DO_Date<= @dateFin 
                AND		(@depot='0' OR DE.DE_No=@depot) 
                AND		(@ctNum='' OR L.DO_Tiers= @ctNum) 
                GROUP BY	$client C.CT_NUM,CT_Intitule 
                ORDER BY	CT_Intitule";
        $result=$this->db->requete($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function stat_clientParAgence($depot, $datedeb, $datefin,$do_type,$id=0) {
        $requete="  
                declare @dt_deb as varchar(20)
                declare @dt_fin as varchar(20)
                declare @doType as int
                declare @deNo as int
                declare @protNo as int
                set @deNo='{$depot}'
                set @dateDeb='{$datedeb}'
                set @dateFin='{$datefin}'
                set @doType='{$do_type}'
                set @protNo={$id} ;
            SELECT  CT_Intitule,
		TotNbDoc,
		TotCAHTNet,TotCATTCNet-TotCAHTNet as PRECOMPTE,TotCATTCNet,TotQteVendues,TotMarge,TotCAHTBrut,TotCATTCBrut
	FROM
		(SELECT NumTiers,
				SUM(CAHTNet) TotCAHTNet,SUM(CATTCNet) TotCATTCNet,SUM(QteVendues) TotQteVendues,SUM(CATTCNet*DL_Taxe1/100) PRECOMPTE,
					SUM(CAHTNet)-SUM(PrxRevientU) TotMarge,
				SUM(CASE WHEN (DO_Type=4 OR DO_Type=14)  
								THEN -CAHTBrut  
								ELSE CAHTBrut 
								END) TotCAHTBrut,
				SUM(CASE WHEN (DO_Type=4 OR DO_Type=14)  
								THEN -CATTCBrut  
								ELSE CATTCBrut 
								END) TotCATTCBrut
	,COUNT (DISTINCT fr.DO_Piece) TotNbDoc
				FROM (SELECT DO_Piece,DO_Type,DL_Taxe1,
				fDoc.CT_Num NumTiers,
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
												WHERE fDoc.cbAR_Ref = convert(varbinary(255),fDoc2.AR_RefCompose)
												AND fDoc2.DL_Valorise<>fDoc.DL_Valorise
												AND fDoc2.cbDO_Piece=fDoc.cbDO_Piece 
												AND fDoc2.DO_Type=fDoc.DO_Type
												AND fDoc2.DL_Ligne > fDoc.DL_Ligne
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
					 (@doType = 2 AND fDoc.DO_Type IN (30)
					OR @doType = 7 AND fDoc.DO_Type IN (7,30)
					OR @doType = 6 AND fDoc.DO_Type IN (6,7,30)
					OR @doType = 3 AND fDoc.DO_Type IN (6,7,30,3))
					AND fDoc.DO_Type <= 8
					AND fDoc.DL_Valorise=1
					AND fDoc.DL_TRemExep <2
					AND fDoc.DO_Date >= @dateDeb AND fDoc.DO_Date <= @dateFin
					AND ((@deNo='0' AND fDoc.DE_No IN (  SELECT DE_No
                                                                                    FROM Z_DEPOTUSER
                                                                                    WHERE PROT_No = @protNo)) OR fDoc.DE_No = @deNo)
					   
					AND fDoc.DL_NonLivre=0
					AND fArt.AR_SuiviStock>0 
 AND fArt.AR_HorsStat = 0
				)) fr
		GROUP BY NumTiers  
		) totcum 
                INNER JOIN F_COMPTET C ON C.CT_Num = NumTiers
ORDER BY	CT_Intitule,TotCAHTNet DESC";
        return $requete;
    }

    public function etatCaisse($ca_no, $datedeb, $datefin,$mode_reglement,$type_reglement){
        return"
                declare @dt_deb as varchar(20)
                declare @dt_fin as varchar(20)
                declare @ct_num as varchar(30)
                declare @ca_no as int
                declare @mode_reglement as int
                declare @type_reglement as int
                declare @premierFondDeCaisse as int
                set @dt_deb='{$datedeb}'
                set @dt_fin='{$datefin}'
                set @ca_no={$ca_no} ;
                set @mode_reglement={$mode_reglement}
                set @type_reglement={$type_reglement}

                SELECT @premierFondDeCaisse = min(cbMarq)
                FROM F_CREGLEMENT
                WHERE RG_Date between @dt_deb AND @dt_fin
                and CA_No=@ca_no
                AND RG_TypeReg=2;
                
                with cte (ligne,RG_No,RG_Date,RG_Libelle,R_Intitule,N_Reglement,RG_Type,RG_TypeReg,FOND_CAISSE,DEBIT,CREDIT,CT_Intitule,cumul) 
                as(
                select ROW_NUMBER() OVER(ORDER BY RG_Date,RG_Type,RG_No) Ligne,*,FOND_CAISSE+ CREDIT   -abs(CASE WHEN N_Reglement=5 THEN 0 ELSE DEBIT END) AS CUMUL
                FROM (
                    
                    SELECT  CASE WHEN RG_TypeReg = 2 THEN 0 ELSE RG_No END RG_No,RG_Date,RG_Libelle,R_Intitule,N_Reglement,CASE WHEN RG_TypeReg = 2 THEN 0 ELSE RG_Type END RG_Type,RG_TypeReg
                            ,CASE WHEN RG_TypeReg=2 THEN RG_MONTANT ELSE 0 END AS FOND_CAISSE
                            ,CASE WHEN (RG_Type = 0 AND RG_Montant<0) OR (RG_BANQUE =3 AND RG_TypeReg=0) OR (RG_BANQUE <>3 AND ((RG_Type=1 AND RG_Montant>0)OR RG_TypeReg = 4))  OR RG_TypeReg = 3 THEN ABS(RG_Montant) ELSE 0 END AS DEBIT 
                            ,CASE WHEN RG_Type = 3 OR (RG_Type = 0 AND RG_Montant>=0) OR (RG_Type = 1 AND RG_Montant<0) OR (RG_BANQUE =3 AND RG_TypeReg=4) OR RG_TypeReg = 5 THEN ABS(RG_MONTANT) ELSE 0 END AS CREDIT
                            ,CT_Intitule
                
                    FROM (
                    select LEFT(T.CT_Intitule,10) CT_Intitule,RC_Montant, C.RG_No,RG_BANQUE,CT_Type, C.CT_NUMPAYEUR,RG_DATE,RG_LIBELLE,N_Reglement,ISNULL(R.R_Intitule,'') R_Intitule,RG_TYPE,RG_TYPEREG,RG_HEURE,CA_NO,CASE WHEN RG_TYPEREG = 4 THEN -RG_MONTANT ELSE RG_MONTANT END AS RG_MONTANT 
                from F_CREGLEMENT C 
                LEFT JOIN (SELECT RG_No,SUM(RC_Montant) RC_Montant
							FROM F_REGLECH
							GROUP BY RG_No) RE 
                    ON RE.RG_No=C.RG_No
                 LEFT JOIN P_REGLEMENT R 
                    ON R.cbIndice = C.N_Reglement
                LEFT JOIN F_COMPTET T 
                    ON T.CT_Num = C.CT_NumPayeur
                WHERE (0=@ca_no OR CA_NO = @ca_no)
                AND RG_DATE BETWEEN @dt_deb AND @dt_fin 
                AND (0=@mode_reglement OR N_Reglement=@mode_reglement)
                AND (((-1=@type_reglement AND ((RG_TypeReg=5 AND RG_Banque IN (0,3)) OR RG_TypeReg<>5) )
                        OR (RG_TypeReg=@type_reglement AND @type_reglement NOT IN (6,4))
                        OR (RG_TypeReg=4 AND RG_Banque = 1 AND @type_reglement=6)
                        OR (RG_TypeReg=4 AND RG_Banque = 0 AND @type_reglement=4))
                        OR (5=@type_reglement AND RG_TypeReg=5 AND RG_Banque=0) 
							OR (@type_reglement NOT IN(-1,5) AND RG_TypeReg=@type_reglement))
			    
                
			    AND (rg_typereg=2 AND @premierFondDeCaisse = C.cbMarq OR rg_typereg<>2)
			    )A)A)

                SELECT T1.ligne,T1.CT_Intitule,CAST(T1.RG_Date AS DATE) RG_Date,T1.RG_Libelle,T1.R_Intitule,T1.N_Reglement,T1.RG_TypeReg, T1.FOND_CAISSE,T1.CREDIT,ABS(T1.DEBIT)DEBIT,SUM(CASE WHEN T2.N_Reglement IN (1,10) THEN T2.cumul ELSE 0 END) AS CUMUL
                FROM CTE T1
                INNER JOIN CTE T2 ON T1.ligne>=T2.ligne
                GROUP BY T1.ligne,T1.CT_Intitule,T1.RG_Date,T1.RG_Libelle,T1.R_Intitule,T1.N_Reglement,T1.RG_TypeReg,T1.FOND_CAISSE,T1.CREDIT,T1.DEBIT
                ORDER BY T1.RG_Date,T1.ligne";
    }

    public function stat_collaborateurparArticleClient($depot, $datedeb, $datefin,$do_type){
        return "SELECT CO_Nom, AR_Ref,AR_Design,SUM(CA_NET_HT) CA_NET_HT, SUM(CA_NET_TTC) CA_NET_TTC, SUM(CA_NET_HT)-SUM(PrxRevientU) MARGE, SUM(CAHTBrut)CAHTBrut, SUM(Rem) Rem
FROM(SELECT *,CASE WHEN (DO_Type=4 OR DO_Type=14) THEN -CAHTBrut ELSE CAHTBrut END Rem
	FROM(
	SELECT	ISNULL(CO_Nom,'')CO_Nom,AR_Design,fDoc.AR_Ref,DO_Type, 
	CASE WHEN (fDoc.DO_Type = 4 OR fDoc.DO_Type = 5 OR fDoc.DO_Type = 14 OR fDoc.DO_Type = 15)
								THEN -DL_MontantHT 
								ELSE DL_MontantHT
								END AS CA_NET_HT,CASE WHEN (fDoc.DO_Type = 4 OR fDoc.DO_Type = 5 OR fDoc.DO_Type = 14 OR fDoc.DO_Type = 15)
								THEN -DL_MontantTTC 
								ELSE DL_MontantTTC
								END AS CA_NET_TTC,  
	DL_Qte*(DL_PrixUnitaire-DL_PrixRU) AS MARGE, 
	CASE WHEN (DL_TRemPied>0 OR DL_TRemExep>0 OR 
		DO_Type=5 OR DO_Type=15 OR DL_TypePL=2 OR DL_TypePL=3) THEN 0
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
		END CAHTBrut,
                (CASE WHEN fDoc.cbAR_Ref =convert(varbinary(255),AR_RefCompose) THEN
							(select SUM(toto)
									from (SELECT  
												CASE WHEN fDoc2.DL_TRemPied = 0 AND fDoc2.DL_TRemExep = 0 THEN
													CASE WHEN (fDoc2.DL_FactPoids = 0 OR fArt2.AR_SuiviStock > 0 OR fDoc2.DO_Domaine = 1) THEN
														CASE WHEN fDoc2.DO_Type <= 2 THEN
															fDoc2.DL_Qte * fDoc2.DL_CMUP
														ELSE
															CASE WHEN (
																		fDoc2.DO_Type = 4 OR fDoc2.DO_Type = 14
																		
																		)
															THEN
																	fDoc2.DL_PrixRU * (-fDoc2.DL_Qte)
															ELSE
																	fDoc2.DL_PrixRU * fDoc2.DL_Qte
															END
														END
													ELSE CASE WHEN (fDoc2.DO_Type = 4 OR fDoc2.DO_Type = 14
																	
																	) THEN
															fDoc2.DL_PrixRU * (-fDoc2.DL_PoidsNet) / 1000
														 ELSE
															fDoc2.DL_PrixRU * fDoc2.DL_PoidsNet / 1000
														END
													END
												ELSE 0
												END toto
										FROM F_DOCLIGNE fDoc2 INNER JOIN F_ARTICLE fArt2 ON (fArt2.cbAR_Ref = fDoc2.cbAR_Ref) 
										WHERE fDoc.cbAR_Ref =convert(varbinary(255),fDoc2.AR_RefCompose)
										AND fDoc2.DL_Valorise<>fDoc.DL_Valorise
										AND fDoc2.cbDO_Piece=fDoc.cbDO_Piece 
										AND fDoc2.DO_Type=fDoc.DO_Type
										AND fDoc2.DL_Ligne > fDoc.DL_Ligne
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
									CASE WHEN (fDoc.DL_FactPoids = 0 OR fArt.AR_SuiviStock > 0 OR fDoc.DO_Domaine = 1) THEN
										CASE WHEN fDoc.DO_Type <= 2 THEN
											fDoc.DL_Qte * fDoc.DL_CMUP
										ELSE
											CASE WHEN (
														fDoc.DO_Type = 4 OR fDoc.DO_Type = 14
														)
											THEN
													fDoc.DL_PrixRU * (-fDoc.DL_Qte)
											ELSE
													fDoc.DL_PrixRU * fDoc.DL_Qte
											END
										END
									ELSE CASE WHEN (fDoc.DO_Type = 4 OR fDoc.DO_Type = 14
													) THEN
											fDoc.DL_PrixRU * (-fDoc.DL_PoidsNet) / 1000
										 ELSE
											fDoc.DL_PrixRU * fDoc.DL_PoidsNet / 1000
										END
									END
								ELSE 0
								END
							END) PrxRevientU,
	(CASE WHEN (DL_MontantHT)<>0 THEN (((DL_Qte*(DL_PrixUnitaire-DL_PrixRU))/(DL_MontantHT))*100) ELSE 0 END) AS MARGE_CA 
	FROM F_DOCLIGNE fDoc
	INNER JOIN F_ARTICLE fArt 
	ON fArt.AR_Ref = fDoc.AR_Ref
	LEFT JOIN dbo.F_COMPTET  CO
	ON CO.CT_Num = fDoc.CT_Num
	INNER JOIN F_DEPOT D  
	ON D.DE_No = fDoc.DE_No 
	LEFT JOIN dbo.F_COLLABORATEUR C  
	ON C.CO_No = fDoc.CO_No
	WHERE  ('$depot'='0' OR D.DE_No = $depot) 
	AND fArt.AR_HorsStat = 0 
	AND		DO_Date >= '$datedeb' AND DO_Date <= '$datefin'  
        AND ($do_type = 2 AND fDoc.DO_Type IN (30)
					OR $do_type = 7 AND fDoc.DO_Type IN (7,30)
					OR $do_type = 6 AND fDoc.DO_Type IN (6,7,30)
					OR $do_type = 3 AND fDoc.DO_Type IN (6,7,30,3))
        AND		fDoc.AR_Ref IS NOT NULL)A
	)A
	GROUP BY CO_Nom,AR_Ref,AR_Design
	ORDER BY 1,2";
    }

    public function stat_mouvementStock($depot, $datedeb, $datefin,$articledebut,$articlefin){
        $requete ="
        SET NOCOUNT ON ;
DECLARE @depot as int
DECLARE @dateDebut as varchar(10)
DECLARE @dateFin as varchar(10)
DECLARE @articleDebut as varchar(30)
DECLARE @articleFin as varchar(30)

SET @depot = $depot
SET @dateDebut ='$datedeb'
SET @dateFin ='$datefin'
SET @articleDebut ='$articledebut'
SET @articleFin ='$articlefin'

BEGIN 
     SELECT *,CASE WHEN DL_Qte<0 THEN 1 ELSE 0 END Sens INTO #TMP
                    FROM (
                    SELECT  0 AS ligne,0 AS cbMarq,'1960-01-01' DO_Date,AR.AR_Ref,AR_Design,'' DO_Piece,'' CT_Num,'' AS CT_Intitule,
                    SUM(CASE WHEN DL_MvtStock=3 THEN -1 ELSE 1 END * ABS(DL_Qte))DL_Qte,0 DO_Type,0 DO_Domaine,0 DL_MvtStock,0 AR_PrixAch,SUM(CASE WHEN DL_MvtStock=3 THEN -DL_PrixRU ELSE DL_PrixRU END) DL_PrixRU,SUM(CASE WHEN DL_MvtStock=3 THEN -DL_PrixRU*ABS(DL_Qte) ELSE DL_PrixRU*ABS(DL_Qte) END) cumul
                    FROM F_DOCENTETE E
                    INNER JOIN F_DOCLIGNE D 
                        ON  D.DO_Domaine = E.DO_Domaine 
                        AND D.DO_Type = E.DO_Type 
                        AND E.cbDO_Piece = D.cbDO_Piece
                    INNER JOIN F_ARTICLE AR 
                        ON AR.cbAR_Ref=D.cbAR_Ref
                    INNER JOIN F_DEPOT DE 
                        ON DE.DE_No=D.DE_No
                    WHERE   (@depot='0' OR D.DE_No = @depot) 
                    AND     DL_MvtStock<>0
                    AND     D.DO_Date < @dateDebut
                    AND     ('0' =@articleDebut OR AR.cbAR_Ref>=@articleDebut)
                    AND     ('0' =@articleFin OR AR.cbAR_Ref<= @articleFin)
                    GROUP BY AR.AR_Ref,AR_Design
                    union
                    SELECT  ROW_NUMBER() OVER(PARTITION BY AR.AR_Ref order by E.DO_Date,DL_MvtStock,D.cbMarq) AS ligne,D.cbMarq,D.DO_Date,AR.AR_Ref,AR_Design,D.DO_Piece,CASE WHEN T.CT_Num IS NULL THEN DT.DE_No ELSE T.CT_Num END CT_Num
,CASE WHEN CT_Intitule IS NULL THEN DT.DE_Intitule ELSE CT_Intitule END CT_Intitule,CASE WHEN DL_MvtStock=3 THEN -1 ELSE 1 END * ABS(DL_Qte),D.DO_Type,D.DO_Domaine,DL_MvtStock,AR_PrixAch,DL_PrixRU,CASE WHEN DL_MvtStock=3 THEN -(DL_PrixRU*ABS(DL_Qte)) ELSE (DL_PrixRU*ABS(DL_Qte)) END cumul
                    FROM F_DOCENTETE E
                    INNER JOIN F_DOCLIGNE D 
                        ON  D.DO_Domaine = E.DO_Domaine 
                        AND D.DO_Type = E.DO_Type 
                        AND E.cbDO_Piece = D.cbDO_Piece
                    INNER JOIN F_ARTICLE AR 
                        ON AR.cbAR_Ref=D.cbAR_Ref
                    LEFT JOIN F_COMPTET T 
                        ON T.cbCT_Num = D.cbDO_Tiers
                    INNER JOIN F_DEPOT DE 
                        ON DE.DE_No=D.DE_No
                    LEFT JOIN (SELECT CAST(DE_No AS VARCHAR(50)) DE_No,DE_Intitule FROM F_DEPOT) DT 
                        ON DT.DE_No = D.CT_Num
                    WHERE   (@depot ='0' OR D.DE_No = @depot) 
                    AND     DL_MvtStock<>0
                    AND     ('0' = @articleDebut OR AR.AR_Ref>=@articleDebut)
                    AND     ('0' =@articleFin OR AR.AR_Ref<=@articleFin)
                    AND D.DO_Date >= @dateDebut AND D.DO_Date <= @dateFin)A;

SELECT *
        FROM(
            SELECT T1.ligne,T1.Sens,CAST(T1.DO_Date as Date) DO_Date,T1.AR_Ref,T1.DO_Piece,T1.AR_Design,T1.CT_Num,T1.CT_Intitule,T1.DL_Qte,T1.DO_Type,T1.DO_Domaine,T1.DL_MvtStock,T1.AR_PrixAch,T1.DL_PrixRU,SUM(T2.DL_Qte) as cumul,SUM(T2.cumul) as cumul_PRIX,T1.cbMarq
                        FROM #TMP T1
                        INNER JOIN #TMP T2 ON T1.ligne>=T2.ligne and T1.AR_Ref=T2.AR_Ref
                        GROUP BY T1.ligne,T1.Sens,T1.cbMarq,T1.DO_Date,T1.AR_Ref,T1.DO_Piece,T1.AR_Design,T1.CT_Num,T1.CT_Intitule,T1.DL_Qte,T1.DO_Type,T1.DO_Domaine,T1.DL_MvtStock,T1.AR_PrixAch,T1.DL_PrixRU,T1.cbMarq)A
                        WHERE NOT EXISTS (
            SELECT 1
                        FROM(
                            SELECT T1.ligne,CAST(T1.DO_Date as Date) DO_Date,T1.AR_Ref,T1.DO_Piece,T1.AR_Design,T1.CT_Num,T1.CT_Intitule,T1.DL_Qte,T1.DO_Type,T1.DO_Domaine,T1.DL_MvtStock,T1.AR_PrixAch,T1.DL_PrixRU,SUM(T2.DL_Qte) as cumul,SUM(T2.cumul) as cumul_PRIX,T1.cbMarq
                        FROM #TMP  T1
                        INNER JOIN #TMP  T2 ON T1.ligne>=T2.ligne and T1.AR_Ref=T2.AR_Ref
                        GROUP BY T1.ligne,T1.cbMarq,T1.DO_Date,T1.AR_Ref,T1.DO_Piece,T1.AR_Design,T1.CT_Num,T1.CT_Intitule,T1.DL_Qte,T1.DO_Type,T1.DO_Domaine,T1.DL_MvtStock,T1.AR_PrixAch,T1.DL_PrixRU,T1.cbMarq)B
                        WHERE DL_Qte=0 AND YEAR(DO_Date)=1960 AND A.AR_Design=B.AR_Design AND A.DO_Date=B.DO_Date AND A.DL_Qte=B.DL_Qte)
                        ORDER BY AR_Ref,DO_Date,Sens,cbMarq;
END";
        return $this->db->requete($requete);
    }


    public function stat_articleParAgence($depot, $datedeb, $datefin, $famille,$articledebut,$articlefin,$do_type,$siteMarchand,$id=0) {
        $requete = "
        DECLARE @DE_No AS INT 
        DECLARE @DateDeb AS  VARCHAR(10)
        DECLARE @DateFin AS VARCHAR(10) 
        DECLARE @Famille AS VARCHAR(50) 
        DECLARE @ArticleDebut AS VARCHAR(50) 
        DECLARE @ArticleFin AS VARCHAR(50) 
        DECLARE @DO_Type AS INT 
        DECLARE @PROT_No AS INT
        DECLARE @siteMarchand AS INT
        DECLARE @admin INT
        CREATE TABLE #TMPDEPOT (DE_No INT)
        SET @DE_No = $depot 
        SET @DateDeb = '$datedeb'
        SET @DateFin = '$datefin'
        SET @Famille = '$famille'
        SET @ArticleDebut = '$articledebut'
        SET @ArticleFin = '$articlefin'
        SET @DO_Type = $do_type
        SET @PROT_No = $id
        SET @siteMarchand = $siteMarchand;
        SET NOCOUNT ON;
        SELECT @admin = CASE WHEN PROT_Administrator=1 OR PROT_Right=1 THEN 1 ELSE 0 END FROM F_PROTECTIONCIAL WHERE PROT_No = @PROT_No 
        IF (@admin=0)
        BEGIN 
            INSERT INTO #TMPDEPOT
            SELECT	A.DE_No 
            FROM	F_DEPOT A
            LEFT JOIN Z_DEPOTUSER D 
                ON  A.DE_No=D.DE_No
            WHERE	(1 = (SELECT CASE WHEN PROT_Administrator=1 OR PROT_Right=1 THEN 1 ELSE 0 END FROM F_PROTECTIONCIAL WHERE PROT_No=@PROT_No) OR D.PROT_No =@PROT_No)
            AND     (@DE_No='0' OR @DE_No=A.DE_No)
            AND     IsPrincipal = 1
            GROUP BY A.DE_No
        END
        ELSE 
        BEGIN
            INSERT	INTO #TMPDEPOT 
            SELECT  DE_No 
            FROM    F_DEPOT 
            WHERE   (@DE_No='0' OR @DE_No=DE_No)

        END ;

        WITH _StatArticle_ AS (
        SELECT  d.DE_No,DE_Intitule,f.AR_Ref,f.cbAR_Ref,f.AR_Design,
		TotCAHTNet,TotCATTCNet
		,PRECOMPTE = TotCATTCNet-TotCAHTNet
		,TotQteVendues
		,TotPrxRevientU,TotPrxRevientCA
		,PourcMargeHT = CASE WHEN TotCAHTNet=0 THEN 0 ELSE ROUND(TotPrxRevientU/TotCAHTNet*100,2) END 
		,PourcMargeTT = CASE WHEN TotCATTCNet=0 THEN 0 ELSE ROUND(TotPrxRevientCA/TotCATTCNet*100,2) END 
		
	FROM
		(SELECT cbAR_Ref
		        ,TotCAHTNet = SUM(CAHTNet) 
		        ,TotCATTCNet = SUM(CATTCNet) 
				,TotQteVendues = SUM(QteVendues) 
				,TotPrxRevientU = SUM(CAHTNet)-SUM(PrxRevientU)
				,TotPrxRevientCA = SUM(CATTCNet)-SUM(PrxRevientU)
				,PRECOMPTE = SUM(CATTCNet*DL_Taxe1/100) 
				,DE_No
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
                                        (@DO_Type = 2 AND fDoc.DO_Type IN (30)
					OR @DO_Type = 7 AND fDoc.DO_Type IN (7,30)
					OR @DO_Type = 6 AND fDoc.DO_Type IN (6,7,30)
					OR @DO_Type = 3 AND fDoc.DO_Type IN (6,7,30,3))
					AND fDoc.DL_Valorise=1
					AND fDoc.DL_TRemExep <2
					AND		(@Famille='0' OR cbFA_CodeFamille = @Famille) 
                                        AND		(@ArticleDebut='0' OR fDoc.cbAR_Ref >= @ArticleDebut) 
                                        AND		(@ArticleFin='0' OR fDoc.cbAR_Ref <= @ArticleFin) 
                                        AND		fDoc.DE_No IN (	SELECT  DE_No
				                                                FROM    #TMPDEPOT)
                                        AND		fDoc.DO_Date >= @DateDeb AND fDoc.DO_Date <= @DateFin  
                   AND fDoc.DL_NonLivre=0
					 AND fArt.AR_HorsStat = 0 
					 AND fArt.AR_SuiviStock>0
				)) fr
		GROUP BY cbAR_Ref,DE_No 
		
		) totcum
		 INNER JOIN F_ARTICLE f ON (totcum.cbAR_Ref = f.cbAR_Ref) 
		 INNER JOIN F_DEPOT d ON (totcum.DE_No = d.DE_No)
		 WHERE (CASE WHEN @siteMarchand=2 THEN f.AR_Publie ELSE @siteMarchand END) = f.AR_Publie  
        )
		,_StockReel_ AS (
			SELECT  DE_No 
					,cbAR_Ref
					,AS_QteSto AS DL_Qte
			FROM F_ARTSTOCK
			WHERE	DE_No IN (SELECT DE_No FROM #TMPDEPOT) 
			AND		('0' = @ArticleDebut OR cbAR_Ref >= @ArticleDebut)
			AND		('0' = @ArticleFin OR cbAR_Ref <= @ArticleFin)
		)

		SELECT  Stat.*,DL_Qte
		FROM    _StatArticle_ Stat
		LEFT JOIN _StockReel_ Stock
			ON	Stat.DE_No = Stock.DE_No
			AND	Stat.cbAR_Ref = Stock.cbAR_Ref
		ORDER BY  	DE_Intitule,	
					Stat.AR_Ref";

        $result=$this->db->requete($requete);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getReglementByClient2($ct_num,$ca_no,$type,$treglement,$datedeb,$datefin,$caissier,$collab,$typeSelectRegl=0,$rgNo){
        $rgNoList= "";
        if(sizeof($rgNo)>0)
            $rgNoList= " AND c.RG_No IN (". implode(",",$rgNo).") ";

        $query = "  DECLARE @RG_Type AS INT 
                    DECLARE @DateDeb AS DATE 
                    DECLARE @DateFin AS DATE 
                    DECLARE @RG_Impute AS INT 
                    DECLARE @CT_Num AS NVARCHAR(50)
                      
                    DECLARE @Collab AS INT
                    DECLARE @CA_No AS INT
                    DECLARE @Caissier AS INT
                    DECLARE @N_Reglement AS INT
                    SET @RG_Type = $typeSelectRegl
                    SET @DateDeb = '$datedeb'
                    SET @DateFin = '$datefin'
                    SET @RG_Impute = $type
                    SET @CT_Num = '$ct_num'
                    SET @Collab = $collab
                    SET @CA_No = $ca_no
                    SET @Caissier = $caissier
                    SET @N_Reglement = $treglement;
                    WITH _MaxRegl_ AS (
                        SELECT RG_No,SUM(RC_Montant) AS RC_Montant, Max(DO_Piece)DO_Piece
                        FROM F_REGLECH
                        GROUP BY RG_No) 
                    ,_Reglech_ AS (
                        SELECT DO_Piece,A.RG_No,RC_Montant + ISNULL(RG_Montant,0) AS RC_Montant
                        FROM _MaxRegl_ A
                        LEFT JOIN Z_RGLT_BONDECAISSE B 
                            ON A.RG_No = B.RG_No_RGLT
                        LEFT JOIN F_CREGLEMENT C 
                            ON C.RG_No = B.RG_No 
                    )
                    SELECT  DO_Piece,C.CT_NumPayeur,C.CG_Num,RG_Piece
                            ,ISNULL(RC_Montant,0) AS RC_Montant,C.RG_No
                            ,CAST(RG_Date as date) RG_Date,RG_Libelle,RG_Montant,C.CA_No,C.CO_NoCaissier
                            ,ISNULL(CO_Nom,'')CO_Nom,ISNULL(CA_Intitule,'')CA_Intitule
                            ,RG_Impute,RG_TypeReg,N_Reglement
                    FROM    F_CREGLEMENT C
                    LEFT JOIN F_CAISSE CA 
                        ON CA.CA_No=C.CA_No 
                    LEFT JOIN F_COLLABORATEUR CO 
                        ON C.CO_NoCaissier = CO.CO_No
                    LEFT JOIN _Reglech_ R 
                        ON R.RG_No=c.RG_No
			        WHERE @RG_Type = RG_Type 
			        AND RG_Date BETWEEN @DateDeb AND @DateFin 
			        $rgNoList
			        AND (-1=@RG_Impute OR RG_Impute=@RG_Impute)
                    AND ((''=@CT_Num AND ct_numpayeur IS NOT NULL) OR ct_numpayeur = @CT_Num OR ('1'=@Collab AND CAST(C.CO_NoCaissier AS VARCHAR(20))=@CT_Num))
                    AND (((0=@N_Reglement OR N_Reglement=@N_Reglement) 
			                AND ((@Collab = 1 AND RG_Banque=3) OR (@Collab = 0))
                                AND ('0'=@CA_No OR CA.CA_No=@CA_No)) OR ('0'<>@CA_No AND C.CO_NoCaissier=@Caissier AND N_Reglement='05') )
                    ORDER BY C.RG_No ";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }
    public function etatVrstBancaire($ca_no, $datedeb, $datefin,$type){
        return "SELECT  Lien_Fichier,RG_Piece,CT_NumPayeur,RG_Libelle,RG_Montant
                        ,ISNULL(RC_Montant,0)RC_Montant,RG_Montant-ISNULL(RC_Montant,0) ResteAPayer
                        ,CA_Intitule,CO_Nom
                        ,CAST(RG_Date AS DATE) RG_Date,RG_BANQUE
                        ,CASE WHEN RG_Type=2 THEN 'Non lettré' ELSE 'lettré'END Type_lettre,RG_TypeReg,RG_Type,N_Reglement
                FROM F_CREGLEMENT C
                LEFT JOIN (SELECT RG_No,SUM(RC_Montant) RC_Montant FROM F_REGLECH GROUP BY RG_No) R 
                    ON  C.RG_No= R.RG_No
                LEFT JOIN F_CAISSE CA 
                    ON  C.CA_No=CA.CA_No
                LEFT JOIN Z_REGLEMENTPIECE RG 
                    ON  RG.RG_No=C.RG_No
                LEFT JOIN DBO.F_COLLABORATEUR Co 
                    ON  Co.CO_No=C.CO_NoCaissier
                WHERE   RG_TypeReg=4 AND RG_Banque = 1 
                AND     (('0'=$type AND RG_Type IN (2,4)) OR (RG_Type=$type))
                AND     RG_DATE BETWEEN '$datedeb' AND '$datefin'
                AND     (0=$ca_no OR C.CA_NO = $ca_no)";
    }

    public function etatFondCaisse($ca_no, $datedeb, $datefin){
        return "WITH CTE (Num,RG_Piece,RG_Libelle,CA_Intitule,RG_Date,FOND_CAISSE,SOLDE_JOURNEE) AS (
                select ROW_NUMBER() OVER(ORDER BY RG_Date) Num,MAX(CASE WHEN RG_TypeReg=2 THEN RG_Piece ELSE '' END) RG_Piece,MAX(CASE WHEN RG_TypeReg=2 THEN RG_Libelle ELSE '' END)RG_Libelle,ISNULL(CA_Intitule,'')CA_Intitule,
                CAST(RG_Date AS DATE) RG_Date,SUM(FOND_CAISSE)FOND_CAISSE
                ,SUM(CASE WHEN N_Reglement=1 THEN FOND_CAISSE+ CREDIT   +(CASE WHEN N_Reglement=5 THEN 0 ELSE ABS(DEBIT) END) ELSE 0 END) AS CUMUL
                FROM (
                    
                    SELECT  CA_Intitule,RG_Piece,CASE WHEN RG_TypeReg = 2 THEN 0 ELSE RG_No END RG_No,RG_Date,RG_Libelle,R_Intitule,N_Reglement,CASE WHEN RG_TypeReg = 2 THEN 0 ELSE RG_Type END RG_Type,RG_TypeReg,
                CASE WHEN RG_TypeReg=2 THEN RG_MONTANT ELSE 0 END AS FOND_CAISSE
                ,CASE WHEN RG_MONTANT < 0 OR (RG_MONTANT>0 AND RG_BANQUE=1) OR (RG_MONTANT>0 AND RG_BANQUE=2) THEN CASE WHEN RC_Montant IS NULL THEN -1* ABS(RG_MONTANT) ELSE -1* ABS(RG_Montant) END ELSE 0 END AS DEBIT
                ,CASE WHEN RG_MONTANT > 0 AND RG_TypeReg<>2 AND RG_BANQUE NOT IN (1,2) THEN 
                    CASE WHEN CT_Type =1 THEN -CASE WHEN RC_Montant IS NULL THEN RG_MONTANT ELSE RG_Montant END ELSE CASE WHEN RC_Montant IS NULL THEN RG_MONTANT ELSE RG_Montant END  END ELSE 0 END AS CREDIT,CT_Intitule
                
                    FROM (
                    select CA_Intitule,RG_Piece,T.CT_Intitule,RC_Montant, C.RG_No,RG_BANQUE,CT_Type, C.CT_NUMPAYEUR,RG_DATE,RG_LIBELLE,N_Reglement,ISNULL(R.R_Intitule,'') R_Intitule,RG_TYPE,RG_TYPEREG,RG_HEURE,C.CA_NO,CASE WHEN RG_TYPEREG = 4 THEN -RG_MONTANT ELSE RG_MONTANT END AS RG_MONTANT 
                from F_CREGLEMENT C 
				LEFT JOIN F_CAISSE CA ON C.CA_No=CA.CA_No
                LEFT JOIN (SELECT RG_No,SUM(RC_Montant) RC_Montant
                            FROM F_REGLECH
                            GROUP BY RG_No) RE ON RE.RG_No=C.RG_No
                 LEFT JOIN DBO.P_REGLEMENT R ON R.cbIndice = C.N_Reglement
                LEFT JOIN DBO.F_COMPTET T ON T.CT_Num = C.CT_NumPayeur
                WHERE (0=$ca_no OR C.CA_NO = $ca_no)
                AND RG_DATE BETWEEN DATEADD(d,-1,'$datedeb') AND '$datefin' 
                )A)A
                GROUP BY RG_DATE,CA_Intitule)

            SELECT *
            FROM(
            SELECT A.RG_Piece,A.RG_Libelle,A.RG_Date,A.CA_Intitule,
            ISNULL(A.FOND_CAISSE,0) FOND_CAISSE,
            ISNULL(A.SOLDE_JOURNEE,0) SOLDE_JOURNEE,CASE WHEN A.Num=1 THEN 0 ELSE ISNULL(A.FOND_CAISSE,0) - ISNULL(A.SOLDE_JOURNEE,0) END  ECART
            FROM CTE A 
            LEFT JOIN CTE B ON  A.Num = B.Num-1 AND A.CA_Intitule = B.CA_Intitule
                WHERE A.RG_DATE>=DATEADD(d,-1,'$datedeb'))A";
    }

    public function __toString() {
        return "";
    }

    public function getetatpreparatoire($depot,$datedeb){
        return "declare @date_deb varchar(69)
            declare @depot int 

            set @date_deb = '$datedeb'
            set @depot = $depot;
                
            SELECT AR_Ref,AR_Design,SUM(Qte) Qte,ROUND(SUM(PR),2) PR,ROUND(MAX(PU),2) PU,MAX(SUIVI) SUIVI
            FROM(
            SELECT * FROM (SELECT INVENTAIRE.DE_Intitule, INVENTAIRE.AR_Ref,INVENTAIRE.AR_Design,INVENTAIRE.Qte,INVENTAIRE.PR/INVENTAIRE.Qte PU,INVENTAIRE.PR,INVENTAIRE.AR_SuiviStock,S.SUIVI FROM(	SELECT 
                    Article.DE_No,fDep.DE_Intitule,Article.IntituleTri,Article.IntituleTri2,fArt.AR_Ref,fArt.AR_Design,fArt.AR_SuiviStock,Article.AG_No1,
                    Article.AG_No2,Article.Enumere1,Article.Enumere2,Article.AE_Ref,Article.LS_NoSerie,Article.LS_Peremption,Article.LS_Fabrication,
                    Article.Qte,Article.CMUP,Article.PR,
                    CASE WHEN 0 = 0 THEN 1 ELSE ISNULL(fCondi.EC_Quantite,1)END EC_Quantite
            FROM(
            SELECT sousReqSelLigne.DE_No,'' IntituleTri,'' IntituleTri2,sousReqSelLigne.cbAR_Ref,sousReqSelLigne.AG_No1,sousReqSelLigne.AG_No2,fgam1.EG_Enumere Enumere1,
                       fgam2.EG_Enumere Enumere2,fArtEnumRef.AE_Ref AE_Ref,LS_NoSerie,LS_Peremption,LS_Fabrication,SUM(Qte) Qte,SUM(CMUP*Sens) CMUP,SUM(PR*Sens) PR
            FROM(
                    SELECT fDoc.DE_No,fDoc.cbAR_Ref,fDoc.AG_No1,fDoc.AG_No2,NULL LS_NoSerie,NULL LS_Peremption,NULL LS_Fabrication,
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
                                                            ROUND(DL_CMUP * ABS(fDoc.DL_Qte),2)
                                                    ELSE
                                                            DL_CMUP
                                                    END) CMUP,

                                                    ( CASE WHEN (DL_MvtStock = 4 OR DL_MvtStock = 2) AND AR_SuiviStock<>2 THEN
                                                            0
                                                    ELSE
                                                            CASE WHEN DL_MvtStock = 3 OR DL_MvtStock = 1 THEN
                                                                    ROUND(DL_PrixRU * ABS(fDoc.DL_Qte),2)
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
                                                    AND ISNULL(NULLIF(DL_DateBL,{d '1900-01-01'}),DO_Date) <= @date_deb
                                                            AND 	(fArt.AR_SuiviStock>=2 AND fArt.AR_SuiviStock<=4)




                                                            AND (0=@depot OR fDoc.DE_No = @depot)
             UNION all
                                    SELECT 
                                            fDoc.DE_No,
                                            fDoc.cbAR_Ref,




                                            fDoc.AG_No1,
                                            fDoc.AG_No2,
                                            fLot.LS_NoSerie,
                                            fLot.LS_Peremption,
                                            fLot.LS_Fabrication,
             ( CASE WHEN DL_MvtStock = 3 THEN
                                                            CASE WHEN DO_Type=14 THEN
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
                                                            ROUND(DL_CMUP * ABS(fDoc.DL_Qte),2)
                                                    ELSE
                                                            DL_CMUP
                                                    END) CMUP,

                                                    ( CASE WHEN (DL_MvtStock = 4 OR DL_MvtStock = 2) AND AR_SuiviStock<>2 THEN
                                                            0
                                                    ELSE
                                                            CASE WHEN DL_MvtStock = 3 OR DL_MvtStock = 1 THEN
                                                                    ROUND(DL_PrixRU * ABS(fDoc.DL_Qte),2)
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

                                    FROM 	F_DOCLIGNE fDoc INNER JOIN F_ARTICLE fArt ON (fArt.cbAR_Ref = fDoc.cbAR_Ref)
                                                    INNER JOIN (	SELECT DL_NoIn DL_No, LS_Peremption, LS_Fabrication, LS_NoSerie FROM F_LOTSERIE WHERE DL_NoOut = 0
                                                                                    UNION 
                                                                                    SELECT DL_NoOut DL_No, LS_Peremption, LS_Fabrication, LS_NoSerie FROM F_LOTSERIE WHERE DL_NoOut> 0
                                                                            ) fLot ON (fDoc.DL_No = fLot.DL_No)



                                    WHERE	(fDoc.DL_MvtStock=1 OR fDoc.DL_MvtStock = 3)
                                                    AND	(fDoc.DO_Type<5 OR fDoc.DO_Type>5)
                                                    AND ISNULL(NULLIF(DL_DateBL,{d '1900-01-01'}),DO_Date) <= @date_deb



                                                            AND (0=@depot OR fDoc.DE_No = @depot)

            )
            sousReqSelLigne		
                                                     LEFT OUTER JOIN F_ARTGAMME fgam1 ON (sousReqSelLigne.AG_No1=fgam1.AG_No AND fgam1.AG_Type = 0)
                                                    LEFT OUTER JOIN F_ARTGAMME fgam2 ON (sousReqSelLigne.AG_No2 = fgam2.AG_No AND fgam2.AG_Type = 1)
                                                    LEFT OUTER JOIN F_ARTENUMREF fArtEnumRef ON (sousReqSelLigne.AG_No1 = fArtEnumRef.AG_No1 AND sousReqSelLigne.AG_No2 = fArtEnumRef.AG_No2 AND sousReqSelLigne.cbAR_Ref = fArtEnumRef.cbAR_Ref)


                    GROUP BY
                     sousReqSelLigne.DE_No,
                     sousReqSelLigne.cbAR_Ref,
                     sousReqSelLigne.AG_No1,
                     sousReqSelLigne.AG_No2,
                     fgam1.EG_Enumere,
                     fgam2.EG_Enumere,
                     fArtEnumRef.AE_Ref,
                     LS_NoSerie,
                     LS_Peremption,
                     LS_Fabrication
                            HAVING SUM(Qte)>0)	Article INNER JOIN F_ARTICLE fArt ON (Article.cbAR_Ref = fArt.cbAR_Ref)
                                                                            INNER JOIN F_DEPOT fDep ON (Article.DE_No = fDep.DE_No)
                                                                    LEFT OUTER JOIN F_CONDITION fCondi ON (fArt.CO_No = fCondi.CO_No))INVENTAIRE

             LEFT JOIN (SELECT S.CODE,S.SUIVI  FROM(SELECT 0 AS CODE, 'AUCUN' AS SUIVI  FROM F_ARTICLE
                    UNION 
                    SELECT 1 AS CODE, 'SERIALISE' AS SUIVI FROM F_ARTICLE
                    UNION 
                    SELECT 2 AS CODE, 'CUMP' AS SUIVI FROM F_ARTICLE
                    UNION 
                    SELECT 3 AS CODE, 'FIFO' AS SUIVI FROM F_ARTICLE
                    UNION 
                    SELECT 4 AS CODE, 'LIFO' AS SUIVI FROM F_ARTICLE
                    UNION 
                    SELECT 5 AS CODE, 'PAR LOT' AS SUIVI FROM F_ARTICLE)S)S ON S.CODE = INVENTAIRE.AR_SuiviStock

                    )A
                    )A
                    GROUP BY AR_Ref,AR_Design
                    ";

    }

    public function getPreparatoireCumul($depot){
        return"
            DECLARE @MAXREPL int,@P1 smallint,@P2 int,@P3 int,@P4 int,@P5 float,@P6 int;
	SET @MAXREPL =  (select ISNULL(MAX(DE_Replication),0) from F_DEPOT);
	SET @P1=0;
	SET @P2=$depot;
	SET @P3=$depot;
	SET @P4=$depot;
	SET @P5=2
	SET @P6 =$depot;
            
SELECT AR_Ref,AR_Design, SUM(Qte)Qte,SUM(PR) PR
FROM(
SELECT


	ReqGlobal.DE_No,
	fDep.DE_Intitule DE_Intitule,
	ReqGlobal.IntituleTri,
	ReqGlobal.IntituleTri2,
	fArt.AR_Ref AR_Ref,
	fArt.AR_Design AR_Design,
	fArt.AR_SuiviStock AR_SuiviStock,
	ReqGlobal.AG_No1,
	ReqGlobal.AG_No2,
	ReqGlobal.Enumere1,
	ReqGlobal.Enumere2,
	ReqGlobal.AE_Ref,
	ReqGlobal.LS_NoSerie,
	ReqGlobal.LS_Peremption,
	ReqGlobal.LS_Fabrication,
	ReqGlobal.PR,
	ReqGlobal.Qte,
	CASE WHEN @P1 = 0 THEN 1 ELSE ISNULL(fCondi.EC_Quantite,1)END EC_Quantite
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
	''''	Enumere1,
	''''	Enumere2,
	''''	AE_Ref,
	''''	LS_NoSerie,
	NULL	LS_Peremption,
	NULL	LS_Fabrication,
		AS_MontSto



 PR,
	AS_QteSto	Qte

,''''	IntituleTri





 ,'''' IntituleTri2
FROM
		F_ARTICLE fArt INNER JOIN F_ARTSTOCK fSto ON (fArt.cbAR_Ref = fSto.cbAR_Ref)
		INNER JOIN F_DEPOT fDepot ON (fDepot.DE_No = fSto.DE_No)
		
		
 		
		
WHERE	fSto.AS_QteSto>0
		 AND AR_SuiviStock>=2 AND AR_SuiviStock<=4
		 AND AR_Gamme1=0
		
		
		
		 AND (('0'=@P2) OR (fDepot.DE_No = @P2))
		
		
 UNION
	SELECT DE_No,ReqGamme.cbAR_Ref cbAR_Ref,ReqGamme.AG_No1 AG_No1,ReqGamme.AG_No2 AG_No2,Enumere1,
	Enumere2,fArtEnumRef.AE_Ref AE_Ref,LS_NoSerie,LS_Peremption,LS_Fabrication,PR,Qte,IntituleTri,IntituleTri2

	FROM 
	(SELECT
		
		fDepot.DE_No DE_No,
		fArt.cbAR_Ref cbAR_Ref,fGam.AG_No AG_No1,0 AG_No2,fGam.EG_Enumere Enumere1,'''' Enumere2,
		'''' LS_NoSerie,NULL LS_Peremption,NULL LS_Fabrication,
		GS_MontSto



  PR,
			GS_QteSto Qte 
		,'''' IntituleTri
		
		
		
		
		
		 ,'''' IntituleTri2
	FROM
		F_ARTICLE fArt INNER JOIN F_ARTGAMME fGam ON (fArt.cbAR_Ref = fGam.cbAR_Ref)
		INNER JOIN F_GAMSTOCK fGamSto ON (fGam.AG_No = fGamSto.AG_No1)
		INNER JOIN F_DEPOT fDepot ON (fDepot.DE_No = fGamSto.DE_No)


		
		
		
		
		
	WHERE fArt.cbAR_Ref = fGamSto.cbAR_Ref
		AND AG_Type=0 
		AND AR_SuiviStock>0 AND AR_Gamme1>0 AND AR_Gamme2=0 AND fGamSto.GS_QteSto>0
		
		
		
		 AND ('0'=@P3) OR (fDepot.DE_No = @P3)
		
		

UNION
	SELECT
	
	
		fDepot.DE_No DE_No,
		fArt.cbAR_Ref cbAR_Ref,
		fGam1.AG_No AG_No1,
		fGam2.AG_No AG_No2,
		fGam1.EG_Enumere Enumere1,
		fGam2.EG_Enumere Enumere2,
		'''' LS_NoSerie,
		NULL LS_Peremption,
		NULL LS_Fabrication,
		GS_MontSto



  PR,
		GS_QteSto Qte 
	,'''' IntituleTri
	
	
	
	
	
	 ,'''' IntituleTri2
	FROM
			F_ARTICLE fArt
			INNER JOIN F_GAMSTOCK fGamSto ON (fArt.cbAR_Ref = fGamSto.cbAR_Ref)
			INNER JOIN F_DEPOT fDepot ON (fDepot.DE_No = fGamSto.DE_No)
			INNER JOIN F_ARTGAMME fGam1 ON (fArt.cbAR_Ref = fGam1.cbAR_Ref AND fGam1.AG_No = fGamSto.AG_No1)
			INNER JOIN F_ARTGAMME fGam2 ON (fArt.cbAR_Ref = fGam2.cbAR_Ref AND fGam2.AG_No = fGamSto.AG_No2)


			
			
			
			
			
	WHERE
		fGam1.AG_Type=0 AND fGam2.AG_Type=1
		AND	AR_SuiviStock>0 
		AND AR_Gamme2>0
		AND fGamSto.GS_QteSto>0
		
		
		
		 AND ('0'=@P4) OR (fDepot.DE_No = @P4)
		
		
	) ReqGamme INNER JOIN F_ARTENUMREF fArtEnumRef ON (fArtEnumRef.cbAR_Ref = ReqGamme.cbAR_Ref AND fArtEnumRef.AG_No1 = ReqGamme.AG_No1 AND fArtEnumRef.AG_No2 = ReqGamme.AG_No2)
)
 UNION all
	SELECT
	
	
		fDepot.DE_No DE_No,
	
		fArt.cbAR_Ref cbAR_Ref,
		0 AG_No1,
		0 AG_No2,
		'''' Enumere1,
		'''' Enumere2,
		'''' AE_Ref,
		LS_NoSerie LS_NoSerie,
		LS_Peremption LS_Peremption,
		LS_Fabrication LS_Fabrication,
		(ROUND(
		DL_PrixRU * ABS(LS_QteRestant)



 
		,@P5)) PR,
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
	,'''' IntituleTri
	
	
	
	
	
	 ,'''' IntituleTri2
	FROM
		F_ARTICLE fArt INNER JOIN F_LOTSERIE fLot ON (fArt.cbAR_Ref = fLot.cbAR_Ref)
		INNER JOIN F_DEPOT fDepot ON (fDepot.DE_No = fLot.DE_No)
		INNER JOIN F_DOCLIGNE fLig ON (fLig.DL_No = fLot.DL_NoIn)
		INNER JOIN F_ARTSTOCK fSto ON (fArt.cbAR_Ref = fSto.cbAR_Ref AND fDepot.DE_No = fSto.DE_No)
		
		
		
		
	WHERE LS_MvtStock = 1
		AND LS_LotEpuise=0
		AND DL_MvtStock=1
		
		
		
		 AND ('0'=@P6) OR (fDepot.DE_No = @P6)
		
		
	) Req
	GROUP BY
		DE_No,IntituleTri,IntituleTri2,cbAR_Ref,AG_No1,AG_No2,Enumere1,Enumere2,AE_Ref,LS_NoSerie,LS_Peremption,LS_Fabrication
	) ReqGlobal		INNER JOIN F_ARTICLE fArt ON (fArt.cbAR_Ref = ReqGlobal.cbAR_Ref)
					 INNER JOIN F_DEPOT fDep ON (fDep.DE_No = ReqGlobal.DE_No)
					LEFT OUTER JOIN F_CONDITION fCondi ON (fArt.CO_No = fCondi.CO_No)
	)A
        GROUP BY AR_Ref,AR_Design";

//            --ORDER BY
//	--	ReqGlobal.DE_No,
//	--	ISNULL(ReqGlobal.IntituleTri,''''),
//	--	ReqGlobal.IntituleTri2,
//	--	fArt.AR_Ref,
//	--	ReqGlobal.AG_No1,
//	--	ReqGlobal.AG_No2,
//	--	ISNULL(ReqGlobal.LS_NoSerie,'''')"
    }


}