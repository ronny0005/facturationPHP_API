<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class DocLigneClass Extends Objet
{
    //put your code here
    public $db, $DO_Domaine, $DO_Type, $CT_Num, $DO_Piece, $DL_PieceBC, $DL_PieceBL, $DO_Date, $DL_DateBC
    , $DL_DateBL, $DL_Ligne, $DO_Ref, $DL_TNomencl, $DL_TRemPied, $DL_TRemExep, $AR_Ref, $DL_Design
    , $DL_Qte, $DL_QteBC, $DL_QteBL, $DL_PoidsNet, $DL_PoidsBrut, $DL_Remise01REM_Valeur, $DL_Remise01REM_Type, $DL_Remise02REM_Valeur
    , $DL_Remise02REM_Type, $DL_Remise03REM_Valeur, $DL_Remise03REM_Type, $DL_PrixUnitaire
    , $DL_PUBC, $DL_Taxe1, $DL_TypeTaux1, $DL_TypeTaxe1, $DL_Taxe2, $DL_TypeTaux2, $DL_TypeTaxe2, $CO_No
    , $AG_No1, $AG_No2, $DL_PrixRU, $DL_CMUP, $DL_MvtStock, $DT_No, $AF_RefFourniss, $EU_Enumere
    , $EU_Qte, $DL_TTC, $DE_No, $DL_NoRef, $DL_TypePL, $DL_PUDevise, $DL_PUTTC, $DL_No
    , $DO_DateLivr, $CA_Num, $cbCA_Num, $DL_Taxe3, $DL_TypeTaux3, $DL_TypeTaxe3, $DL_Frais, $DL_Valorise
    , $AR_RefCompose, $DL_NonLivre, $AC_RefClient, $DL_MontantHT, $DL_MontantTTC, $DL_FactPoids, $DL_Escompte, $DL_PiecePL
    , $DL_DatePL, $DL_QtePL, $DL_NoColis, $DL_NoLink, $RP_Code, $DL_QteRessource, $DL_DateAvancement, $cbMarq
    , $cbCreateur, $cbModification, $USERGESCOM, $NOMCLIENT, $DATEMODIF, $ORDONATEUR_REMISE, $MACHINEPC, $GROUPEUSER
    , $cag, $mag, $carat, $eau, $divise, $purity, $pureway, $oz, $cioj, $DL_PUTTC_Rem0, $DL_PrixUnitaire_Rem0, $DL_PUTTC_Rem
    , $DL_PrixUnitaire_Rem, $DL_Remise, $MT_Taxe1, $MT_Taxe2, $MT_Taxe3;
    public $table = 'F_DOCLIGNE';
    public $lien = 'fdocligne';

    function __construct($id, $db = null)
    {
        $this->data = $this->getApiJson("/cbMarq=$id");
        $this->cbMarq = 0;
        if ($this->data!=NULL && sizeof($this->data) > 0) {
            $this->DO_Domaine = $this->data[0]->DO_Domaine;
            $this->DO_Type = $this->data[0]->DO_Type;
            $this->CT_Num = $this->data[0]->CT_Num;
            $this->DO_Piece = $this->data[0]->DO_Piece;
            $this->DL_PieceBC = $this->data[0]->DL_PieceBC;
            $this->DL_PieceBL = $this->data[0]->DL_PieceBL;
            $this->DO_Date = $this->data[0]->DO_Date;
            $this->DL_DateBC = $this->data[0]->DL_DateBC;
            $this->DL_DateBL = $this->data[0]->DL_DateBL;
            $this->DL_Ligne = $this->data[0]->DL_Ligne;
            $this->DO_Ref = $this->data[0]->DO_Ref;
            $this->DL_TNomencl = $this->data[0]->DL_TNomencl;
            $this->DL_TRemPied = $this->data[0]->DL_TRemPied;
            $this->DL_TRemExep = $this->data[0]->DL_TRemExep;
            $this->AR_Ref = $this->data[0]->AR_Ref;
            $this->DL_Design = $this->data[0]->DL_Design;
            $this->DL_Qte = $this->data[0]->DL_Qte;
            $this->DL_QteBC = $this->data[0]->DL_QteBC;
            $this->DL_QteBL = $this->data[0]->DL_QteBL;
            $this->DL_PoidsNet = $this->data[0]->DL_PoidsNet;
            $this->DL_PoidsBrut = $this->data[0]->DL_PoidsBrut;
            $this->DL_Remise01REM_Valeur = $this->data[0]->DL_Remise01REM_Valeur;
            $this->DL_Remise01REM_Type = $this->data[0]->DL_Remise01REM_Type;
            $this->DL_Remise02REM_Valeur = $this->data[0]->DL_Remise02REM_Valeur;
            $this->DL_Remise02REM_Type = $this->data[0]->DL_Remise02REM_Type;
            $this->DL_Remise03REM_Valeur = $this->data[0]->DL_Remise03REM_Valeur;
            $this->DL_Remise03REM_Type = $this->data[0]->DL_Remise03REM_Type;
            $this->DL_PrixUnitaire = $this->data[0]->DL_PrixUnitaire;
            $this->DL_PUBC = $this->data[0]->DL_PUBC;
            $this->DL_Taxe1 = $this->data[0]->DL_Taxe1;
            $this->DL_TypeTaux1 = $this->data[0]->DL_TypeTaux1;
            $this->DL_TypeTaxe1 = $this->data[0]->DL_TypeTaxe1;
            $this->DL_Taxe2 = $this->data[0]->DL_Taxe2;
            $this->DL_TypeTaux2 = $this->data[0]->DL_TypeTaux2;
            $this->DL_TypeTaxe2 = $this->data[0]->DL_TypeTaxe2;
            $this->CO_No = $this->data[0]->CO_No;
            $this->AG_No1 = $this->data[0]->AG_No1;
            $this->AG_No2 = $this->data[0]->AG_No2;
            $this->DL_PrixRU = $this->data[0]->DL_PrixRU;
            $this->DL_CMUP = $this->data[0]->DL_CMUP;
            $this->DL_MvtStock = $this->data[0]->DL_MvtStock;
            $this->DT_No = $this->data[0]->DT_No;
            $this->AF_RefFourniss = $this->data[0]->AF_RefFourniss;
            $this->EU_Enumere = $this->data[0]->EU_Enumere;
            $this->EU_Qte = $this->data[0]->EU_Qte;
            $this->DL_TTC = $this->data[0]->DL_TTC;
            $this->DE_No = $this->data[0]->DE_No;
            $this->DL_NoRef = $this->data[0]->DL_NoRef;
            $this->DL_TypePL = $this->data[0]->DL_TypePL;
            $this->DL_PUDevise = $this->data[0]->DL_PUDevise;
            $this->DL_PUTTC = $this->data[0]->DL_PUTTC;
            $this->DL_No = $this->data[0]->DL_No;
            $this->DO_DateLivr = $this->data[0]->DO_DateLivr;
            $this->CA_Num = $this->data[0]->CA_Num;
            $this->DL_Taxe3 = $this->data[0]->DL_Taxe3;
            $this->DL_TypeTaux3 = $this->data[0]->DL_TypeTaux3;
            $this->DL_TypeTaxe3 = $this->data[0]->DL_TypeTaxe3;
            $this->DL_Frais = $this->data[0]->DL_Frais;
            $this->DL_Valorise = $this->data[0]->DL_Valorise;
            $this->AR_RefCompose = $this->data[0]->AR_RefCompose;
            $this->DL_NonLivre = $this->data[0]->DL_NonLivre;
            $this->AC_RefClient = $this->data[0]->AC_RefClient;
            $this->DL_MontantHT = $this->data[0]->DL_MontantHT;
            $this->DL_MontantTTC = $this->data[0]->DL_MontantTTC;
            $this->DL_FactPoids = $this->data[0]->DL_FactPoids;
            $this->DL_Escompte = $this->data[0]->DL_Escompte;
            $this->DL_PiecePL = $this->data[0]->DL_PiecePL;
            $this->DL_DatePL = $this->data[0]->DL_DatePL;
            $this->DL_QtePL = $this->data[0]->DL_QtePL;
            $this->DL_NoColis = $this->data[0]->DL_NoColis;
            $this->DL_NoLink = $this->data[0]->DL_NoLink;
            $this->RP_Code = $this->data[0]->RP_Code;
            $this->DL_QteRessource = $this->data[0]->DL_QteRessource;
            $this->DL_DateAvancement = $this->data[0]->DL_DateAvancement;
            $this->cbMarq = $this->data[0]->cbMarq;
            $this->cbCreateur = $this->data[0]->cbCreateur;
            $this->cbModification = $this->data[0]->cbModification;
            $this->NOMCLIENT = $this->data[0]->NOMCLIENT;
            $this->DATEMODIF = $this->data[0]->DATEMODIF;
            $this->ORDONATEUR_REMISE = $this->data[0]->ORDONATEUR_REMISE;
            $this->MACHINEPC = $this->data[0]->MACHINEPC;
            $this->GROUPEUSER = $this->data[0]->GROUPEUSER;
            $this->initRemise();
            $this->setcbCreateurName();
        }
    }

    public function initRemise()
    {

        $rows  = $this->getApiJson("/initRemise&cbMarq={$this->cbMarq}");
        $this->DL_PUTTC_Rem0 = $rows[0]->DL_PUTTC_Rem0;
        $this->DL_PrixUnitaire_Rem0 = $rows[0]->DL_PrixUnitaire_Rem0;
        $this->DL_PUTTC_Rem = $rows[0]->DL_PUTTC_Rem;
        $this->DL_PrixUnitaire_Rem = $rows[0]->DL_PrixUnitaire_Rem;
        $this->DL_Remise = $rows[0]->DL_Remise;
        $this->MT_Taxe1 = $rows[0]->MT_Taxe1;
        $this->MT_Taxe2 = $rows[0]->MT_Taxe2;
        $this->MT_Taxe3 = $rows[0]->MT_Taxe3;
    }

    public function getLigneFacture($do_piece, $domaine, $type)
    {
        $val = "";
        $query = "SELECT DL_PUDevise,CA_Num,DL_TTC,$val DL_PUTTC,DL_MvtStock,CT_Num,cbMarq,DL_TypeTaux1,DL_TypeTaux2,DL_TypeTaux3,cbCreateur,DL_NoColis
        ,CASE WHEN DL_TypeTaux1=0 THEN DL_MontantHT*(DL_Taxe1/100) 
				WHEN DL_TypeTaux1=1 THEN DL_Taxe1*DL_Qte ELSE DL_Taxe1 END MT_Taxe1
        ,CASE WHEN DL_TypeTaux2=0 THEN DL_MontantHT*(DL_Taxe2/100) 
				WHEN DL_TypeTaux2=1 THEN DL_Taxe2*DL_Qte ELSE DL_Taxe2 END MT_Taxe2
        ,CASE WHEN DL_TypeTaux3=0 THEN DL_MontantHT*(DL_Taxe3/100) 
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
        WHERE cbDO_Piece ='$do_piece' AND DO_Domaine=$domaine AND DO_Type = $type
        ORDER BY cbMarq";
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getLigneTransfert($do_piece)
    {
        $query = "  SELECT  ISNULL(idSec,0)idSec,*
                    FROM  (	SELECT	DL_Ligne AS Ligne , M.cbMarq,E.DO_Piece,AR_Ref,cbAR_Ref,DL_Design
                                    ,DL_Qte,DL_PrixUnitaire,DL_CMUP ,DL_Taxe1,DL_Taxe2,DL_Taxe3,DL_MontantTTC,DL_MontantHT,DL_Ligne 
                                    ,CASE WHEN DL_Remise01REM_Type=0 THEN '' WHEN DL_Remise01REM_Type=1 THEN cast(cast(DL_Remise01REM_Valeur as numeric(9,2)) as varchar(10))+'%' ELSE cast(cast(DL_Remise01REM_Valeur as numeric(9,2)) as varchar(10))+'U' END DL_Remise 
                            FROM	F_DOCENTETE E 
                            INNER JOIN F_DOCLIGNE M 
								ON 	E.DO_Domaine = M.DO_Domaine 
								AND E.DO_Type = M.DO_Type 
								AND E.cbDO_Piece = M.cbDO_Piece 
                            WHERE	M.DL_MvtStock=3 AND cbDO_Piece='$do_piece' 
							AND 	DO_Type=23 
							AND 	DO_Domaine=2) AS A 
                    LEFT JOIN (SELECT	DL_Ligne Ligne,cbMarq as idSec,AR_Ref,cbAR_Ref
                                FROM	(	SELECT DL_Ligne,M.cbMarq,M.AR_Ref,M.cbAR_Ref
                                            FROM	F_DOCENTETE E 
                                            INNER JOIN F_DOCLIGNE M 
												ON 	E.DO_Domaine = M.DO_Domaine 
												AND E.DO_Type = M.DO_Type 
												AND E.cbDO_Piece = M.cbDO_Piece 
                                            WHERE	M.DL_MvtStock=1 
											AND 	cbDO_Piece='$do_piece' 
											AND 	DO_Type=23 
											AND 	DO_Domaine=2)B 
                                ) B 
						ON 	(B.Ligne-A.Ligne )=10000 
						AND A.cbAR_Ref = B.cbAR_Ref";
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }


    public function getLigneFactureElementByCbMarq()
    {
        $query = "SELECT  DO_Domaine, DO_Type,DO_Date,DL_PUTTC,DL_NoColis,DE_No,cbMarq,DO_Piece,AR_Ref
                        ,DL_Qte,DL_Design,DL_PrixUnitaire,DL_CMUP,DL_Taxe1,DL_Taxe2,DL_Taxe3,DL_MontantTTC
                        ,DL_MontantHT,DL_Ligne
                        ,CASE WHEN DL_Remise01REM_Type=0 THEN ''  
                              WHEN DL_Remise01REM_Type=1 THEN cast(cast(DL_Remise01REM_Valeur as numeric(9,2)) as varchar(10))+'%' 
                              ELSE cast(cast(DL_Remise01REM_Valeur as numeric(9,2)) as varchar(10))+'U' END DL_Remise  
                FROM 	F_DOCLIGNE  
				WHERE 	cbMarq ={$this->cbMarq}";
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function modifDocligneFactureMagasin($DL_Qte, $prix, $type_fac,$protNo,$cbMarqEntete)
    {
        return $this->ajout_ligneFacturation($DL_Qte," ",$cbMarqEntete,$type_fac,0,$prix," "," ","modif_ligne",$protNo);
    }


    public function getLigneConfirmation($cbMarq)
    {
        $query = "SELECT  * 
                FROM    Z_LIGNE_CONFIRMATION 
                WHERE   cbMarq =$cbMarq";
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ)[0];
    }

    public function ligneConfirmationVisuel($cbMarqEntete)
    {
        echo "
        <table class='table table-striped'>
            <thead>
                <th><input type='checkbox' name='checkAll' id='checkAll'/></th>
                <th>Référence</th>
                <th>Désignation</th>
                <th>Quantité</th>
                <th>Prix</th>
            </thead>
            <tbody>";
        $docEntete = new DocEnteteClass($cbMarqEntete, $this->db);
        $list = $docEntete->getLignetConfirmation();
        foreach ($list as $row) {
            echo "<tr>
                            <td><input type='checkbox' name='itemCheck' id='itemCheck'/></td>
                            <td>{$row->AR_Ref}</td>
                            <td>{$row->AR_Design}</td>
                            <td><input type='text' name='qte' id='qte' value='{$this->objetCollection->formatChiffre($row->DL_Qte)}' class='form-control'/></td>
                            <td>{$this->objetCollection->formatChiffre($row->Prix)}<span id='cbMarq' style='display: none'>{$row->cbMarq}</span></td>
                            </tr>";
        }
        echo "
            </tbody>
        </table>";
    }

    public function getEnteteByDOPieceDOType($do_piece, $do_domaine, $do_type)
    {
        $query = "SELECT *,CONVERT(char(10), CAST(DO_Date AS DATE),126) AS DO_DateC 
                FROM 	F_DOCENTETE 
                WHERE 	DO_Domaine=$do_domaine 
				AND		DO_Type = $do_type 
				AND 	cbDO_Piece='$do_piece'";
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ)[0];
    }

    public function addDocligneEntreeMagasinProcess21($AR_Ref, $DO_Piece, $DL_Qte, $MvtStock, $DE_No, $prix, $login)
    {
        $AR_PrixAch = 0;
        $AR_Design = "";
        $AR_PrixVen = 0;
        $montantHT = 0;
        $AR_UniteVen = 0;
        $U_Intitule = "";
        $DO_Date = "";
        $DO_Domaine = "";
        $DO_Type = "";
        $article = new ArticleClass($AR_Ref, $this->db);
        $AR_Design = str_replace("'", "''", $article->AR_Design);
        $AR_Ref = $article->AR_Ref;
        $AR_PrixAch = $prix;
        $AR_UniteVen = $article->AR_UniteVen;
        $montantHT = ROUND($AR_PrixAch * $DL_Qte, 2);
        $result = $this->db->requete($this->objetCollection->getUnite($AR_UniteVen));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if ($rows != null) {
            $U_Intitule = $rows[0]->U_Intitule;
        }
        $rows = $this->getEnteteByDOPieceDOType($DO_Piece, 2, 21);
        if ($rows != null) {
            $DO_Date = $rows->DO_DateC;
            $do_ref = $rows->DO_Ref;
            $DO_Domaine = $rows->DO_Domaine;
            $DO_Type = $rows->DO_Type;
            $cbMarq = $this->insertDocligneEntreeMagasin($DO_Domaine, $DO_Type, $DE_No, $DO_Piece, $DO_Date, $AR_Ref, $AR_Design, $DL_Qte, $do_ref, $AR_PrixAch, $MvtStock, $U_Intitule, $DE_No, $montantHT, "", $login, "", "");
        }
    }

    public function insertDocligneEntreeMagasin($do_domaine, $do_type, $ct_num, $do_piece, $do_date, $ar_ref, $ar_design, $dl_qte, $do_ref, $ar_prixach, $mvtstock, $u_intitule, $de_no, $montantht, $ca_num, $login, $type_fac, $machine)
    {
        $requete = "
              BEGIN
              SET NOCOUNT ON;
              INSERT INTO [dbo].[F_DOCLIGNE]" .
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
            "    ,/*cbReplication*/0,/*cbFlag*/0,/*USERGESCOM*/'$login',/*DATEMODIF*/GETDATE());
          select @@IDENTITY as cbMarq;
          END";

        $result = $this->db->query($requete);
        return $result->fetchAll(PDO::FETCH_OBJ)[0]->cbMarq;
    }

    public function ajoutLigneTransfert($qte,$prix,$typeFacture,$cbMarq,$cbMarqEntete,$protNo,$acte,$arRef,$machineName){
        return $this->getApiJson("/ajoutLigneTransfert&qte=$qte&prix=$prix&typeFacture=$typeFacture&cbMarq=$cbMarq&cbMarqEntete=$cbMarqEntete&protNo=$protNo&acte=$acte&arRef={$this->formatString($arRef)}&machineName={$this->formatString($machineName)}");
    }

    public function deleteConfirmation()
    {
        $query = "DELETE FROM Z_LIGNE_CONFIRMATION WHERE cbMarqLigneFirst= {$this->cbMarq}";
        $this->db->query($query);
    }

    public function deleteConfirmationbyCbmarq($cbMarq)
    {
        $query = "DELETE FROM Z_LIGNE_CONFIRMATION WHERE cbMarq='$cbMarq'";
        $this->db->query($query);
    }

    public function initVariables()
    {
        $this->DL_PieceBC = '';
        $this->DL_PieceBL = '';
        $this->DL_DateBC = '1900-01-01';
        $this->DL_TNomencl = 0;
        $this->DL_TRemPied = 0;
        $this->DL_TRemExep = 0;
        $this->DL_QteBL = 0;
        $this->DL_PoidsNet = 0;
        $this->DL_PoidsBrut = 0;
        $this->DL_Remise01REM_Valeur = 0;
        $this->DL_Remise01REM_Type = 0;
        $this->DL_Remise02REM_Valeur = 0;
        $this->DL_Remise02REM_Type = 0;
        $this->DL_Remise03REM_Valeur = 0;
        $this->DL_Remise03REM_Type = 0;
        $this->DL_PUBC = 0;
        $this->DL_Taxe1 = 0;
        $this->DL_TypeTaux1 = 0;
        $this->DL_TypeTaxe1 = 0;
        $this->DL_Taxe2 = 0;
        $this->DL_TypeTaux2 = 0;
        $this->DL_TypeTaxe2 = 0;
        $this->CO_No = 0;
        $this->AG_No1 = 0;
        $this->AG_No2 = 0;
        $this->DT_No = 0;
        $this->AF_RefFourniss = '';
        $this->EU_Enumere = '';
        $this->DL_TTC = 0;
        $this->DL_NoRef = 1;
        $this->DL_TypePL = 0;
        $this->DL_PUDevise = 0;
        $this->DL_No = 0;
        $this->DO_DateLivr = '1900-01-01';
        $this->CA_Num = '';
        $this->DL_Taxe3 = 0;
        $this->DL_TypeTaux3 = 0;
        $this->DL_TypeTaxe3 = 0;
        $this->DL_Frais = 0;
        $this->DL_Valorise = 1;
        $this->DL_NonLivre = 0;
        $this->AC_RefClient = '';
        $this->DL_FactPoids = 0;
        $this->DL_Escompte = 0;
        $this->DL_PiecePL = '';
        $this->DL_DatePL = '1900-01-01';
        $this->DL_QtePL = 0;
        $this->DL_NoColis = '';
        $this->DL_NoLink = 0;
        $this->DL_QteRessource = 0;
        $this->DL_DateAvancement = '1900-01-01';
        $this->cbProt = 0;
        $this->cbReplication = 0;
        $this->cbFlag = 0;
    }

    public function maj_docLigne($prix=0,$cbCreateur=0)
    {
        parent::maj("DL_PieceBC", $this->DL_PieceBC);
        parent::maj("DL_PieceBL", $this->DL_PieceBL);
        parent::maj("DO_Date", $this->DO_Date);
        parent::maj("DL_DateBC", $this->DL_DateBC);
        parent::maj("DL_DateBL", $this->DL_DateBL);
        parent::maj("DL_Ligne", $this->DL_Ligne);
        parent::maj("DO_Ref", $this->DO_Ref);
        parent::maj("DL_TNomencl", $this->DL_TNomencl);
        parent::maj("DL_TRemPied", $this->DL_TRemPied);
        parent::maj("DL_TRemExep", $this->DL_TRemExep);
        parent::maj("DL_Qte", $this->DL_Qte);
        parent::maj("DL_QteBC", $this->DL_QteBC);
        parent::maj("DL_QteBL", $this->DL_QteBL);
        parent::maj("DL_PoidsNet", $this->DL_PoidsNet);

        parent::maj("DL_PoidsBrut", $this->DL_PoidsBrut);
        parent::maj("DL_Remise01REM_Valeur", $this->DL_Remise01REM_Valeur);
        parent::maj("DL_Remise01REM_Type", $this->DL_Remise01REM_Type);
        parent::maj("DL_Remise02REM_Valeur", $this->DL_Remise02REM_Valeur);
        parent::maj("DL_Remise02REM_Type", $this->DL_Remise02REM_Type);
        parent::maj("DL_Remise03REM_Valeur", $this->DL_Remise03REM_Valeur);
        parent::maj("DL_Remise03REM_Type", $this->DL_Remise03REM_Type);
        parent::maj("DL_PrixUnitaire", $this->DL_PrixUnitaire);
        parent::maj("DL_PUBC", $this->DL_PUBC);
        parent::maj("DL_Taxe1", $this->DL_Taxe1);
        parent::maj("DL_TypeTaux1", $this->DL_TypeTaux1);
        parent::maj("DL_TypeTaxe1", $this->DL_TypeTaxe1);
        parent::maj("DL_Taxe2", $this->DL_Taxe2);
        parent::maj("DL_TypeTaux2", $this->DL_TypeTaux2);
        parent::maj("DL_TypeTaxe2", $this->DL_TypeTaxe2);
//        parent::maj("AG_No1", $this->AG_No1);
//        parent::maj("AG_No2", $this->AG_No2);
        parent::maj("DL_PrixRU", $this->DL_PrixRU);
        parent::maj("DL_CMUP", $this->DL_CMUP);
        parent::maj("DL_MvtStock", $this->DL_MvtStock);
        parent::maj("AF_RefFourniss", $this->AF_RefFourniss);
        parent::maj("EU_Enumere", $this->EU_Enumere);
        parent::maj("EU_Qte", $this->EU_Qte);
        parent::maj("DL_TTC", $this->DL_TTC);
        parent::maj("DL_NoRef", $this->DL_NoRef);
        parent::maj("DL_TypePL", $this->DL_TypePL);
        parent::maj("DL_PUDevise", $this->DL_PUDevise);
        parent::maj("DL_PUTTC", $this->DL_PUTTC);
        parent::maj("DL_No", $this->DL_No);
        parent::maj("DO_DateLivr", $this->DO_DateLivr);
        parent::maj("DL_Taxe3", $this->DL_Taxe3);
        parent::maj("DL_TypeTaux3", $this->DL_TypeTaux3);
        parent::maj("DL_TypeTaxe3", $this->DL_TypeTaxe3);
        parent::maj("DL_Frais", $this->DL_Frais);
        parent::maj("DL_Valorise", $this->DL_Valorise);
        parent::maj("AR_RefCompose", $this->AR_RefCompose);
        parent::maj("DL_NonLivre", $this->DL_NonLivre);
        parent::maj("AC_RefClient", $this->AC_RefClient);
        parent::maj("DL_MontantHT", $this->DL_MontantHT);
        parent::maj("DL_MontantTTC", $this->DL_MontantTTC);
        parent::maj("DL_FactPoids", $this->DL_FactPoids);
        parent::maj("DL_Escompte", $this->DL_Escompte);
        parent::maj("DL_PiecePL", $this->DL_PiecePL);
        parent::maj("DL_DatePL", $this->DL_DatePL);
        parent::maj("DL_QtePL", $this->DL_QtePL);
        parent::maj("DL_NoColis", $this->DL_NoColis);
        parent::maj("DL_NoLink", $this->DL_NoLink);
        //parent::maj("RP_Code", $this->RP_Code);

        parent::maj("DL_QteRessource", $this->DL_QteRessource);
        parent::maj("DL_DateAvancement", $this->DL_DateAvancement);
        parent::maj("cbCreateur", $this->userName);
        parent::majcbModification();
        $this->majUSERGESCOM();
        $this->logMvt("modif_ligne", $this->DE_No, $this->AR_Ref, $this->DL_Qte, $prix, $this->DL_Remise01REM_Valeur, $this->DL_MontantTTC,$cbCreateur,$this->cbMarq,$this->DO_Date);

    }


    public function delete($protNo=0){
        parent::delete();
        $this->userName = $protNo;
        $this->logMvt("suppr_ligne", $this->DE_No, $this->AR_Ref, $this->DL_Qte, $this->DL_MontantTTC, $this->DL_Remise01REM_Valeur, $this->DL_MontantTTC,$this->cbCreateur,$this->cbMarq,$this->DO_Date);
    }

    public function majUSERGESCOM()
    {
        $query = "UPDATE F_DOCLIGNE SET USERGESCOM=(SELECT PROT_User FROM F_PROTECTIONCIAL WHERE PROT_No={$this->userName})
                WHERE cbMarq ={$this->cbMarq}";
        $this->db->query($query);

    }

    public function insertDocligneMagasin($DE_No=0,$prix=0)
    {
//        $article = new ArticleClass($this->AR_Ref);
        //$queryStock = $article->updateArtStockQuery($this->DE_No,-$this->DL_Qte,-(ROUND($this->DL_PrixRU, 2) * $this->DL_Qte));

        $requete = "
              BEGIN
                  SET NOCOUNT ON;
                  DECLARE @DO_Domaine INT = {$this->DO_Domaine}
                  ,@DO_Type INT = {$this->DO_Type}
                  ,@CT_Num NVARCHAR(50) = '{$this->CT_Num}'
                  ,@DO_Piece NVARCHAR(50) = '{$this->DO_Piece}'
                    ,@DL_PieceBC NVARCHAR(50) ='{$this->DL_PieceBC}'
                    ,@DL_PieceBL NVARCHAR(50) = '{$this->DL_PieceBL}'
                    ,@DO_Date NVARCHAR(50) ='{$this->DO_Date}'
                    ,@DL_DateBC NVARCHAR(50) = '{$this->DL_DateBC}'
                    ,@DL_DateBL NVARCHAR(50) = '{$this->DL_DateBL}';
                    DECLARE @DL_Ligne NVARCHAR(50) =  (SELECT (1+COUNT(*))*10000 FROM F_DOCLIGNE WHERE DO_PIECE=@DO_Piece AND DO_Domaine=@DO_Domaine AND DO_Type=@DO_Type)
                    ,@DO_Ref NVARCHAR(50) = '{$this->DO_Ref}'
                    ,@DL_TNomencl FLOAT = {$this->DL_TNomencl}
                    ,@DL_TRemPied FLOAT = {$this->DL_TRemPied}
                    ,@DL_TRemExep FLOAT = {$this->DL_TRemExep}
                    ,@AR_Ref NVARCHAR(50) = '{$this->AR_Ref}'
                    ,@DL_Design NVARCHAR(150) = '{$this->DL_Design}'
                    ,@DL_Qte FLOAT = {$this->DL_Qte}
                    ,@DL_QteBC FLOAT = {$this->DL_QteBC}
                    ,@DL_QteBL FLOAT = {$this->DL_QteBL}
                    ,@DL_PoidsNet FLOAT = {$this->DL_PoidsNet}
                    ,@DL_PoidsBrut FLOAT = {$this->DL_PoidsBrut}
                    ,@DL_Remise01REM_Valeur FLOAT = {$this->DL_Remise01REM_Valeur}
                   ,@DL_Remise01REM_Type INT = {$this->DL_Remise01REM_Type}
                   ,@DL_Remise02REM_Valeur FLOAT = {$this->DL_Remise02REM_Valeur}
                    ,@DL_Remise02REM_Type INT = {$this->DL_Remise02REM_Type}
                    ,@DL_Remise03REM_Valeur FLOAT = {$this->DL_Remise03REM_Valeur}
                   ,@DL_Remise03REM_Type INT = {$this->DL_Remise03REM_Type}
                   ,@DL_PrixUnitaire FLOAT = {$this->DL_PrixUnitaire}
                    ,@DL_PUBC INT = {$this->DL_PUBC}
                    ,@DL_Taxe1 FLOAT = {$this->DL_Taxe1}
                    ,@DL_TypeTaux1 FLOAT = {$this->DL_TypeTaux1}
                    ,@DL_TypeTaxe1 FLOAT = {$this->DL_TypeTaxe1}
                    ,@DL_NoRefDL_Taxe2 FLOAT = {$this->DL_Taxe2}
                    ,@DL_TypeTaux2 FLOAT = {$this->DL_TypeTaux2}
                    ,@DL_TypeTaxe2 FLOAT = {$this->DL_TypeTaxe2}
                    ,@CO_No INT = {$this->CO_No}
                    ,@AG_No1 INT = {$this->AG_No1}
                   ,@AG_No2 INT = {$this->AG_No2}
                   ,@DL_PrixRU FLOAT = {$this->DL_PrixRU}
                   ,@DL_CMUP FLOAT = {$this->DL_CMUP}
                   ,@DL_MvtStock INT = {$this->DL_MvtStock}
                    ,@DT_No INT = {$this->DT_No}
                    ,@AF_RefFourniss NVARCHAR(50) = '{$this->AF_RefFourniss}'
                    ,@EU_Enumere NVARCHAR(50) = '{$this->EU_Enumere}'
                    ,@EU_Qte FLOAT = {$this->EU_Qte}
                    ,@DL_TTC INT = {$this->DL_TTC}
                    ,@DE_No INT = {$this->DE_No}
                    ,@DL_NoRef INT = {$this->DL_NoRef}
                    ,@DL_TypePL INT = {$this->DL_TypePL}
                    ,@DL_PUDevise FLOAT = {$this->DL_PUDevise}
                   ,@DL_PUTTC FLOAT = {$this->DL_PUTTC}
                   ,@DL_No INT = ISNULL((SELECT MAX(DL_No)+1 FROM F_DOCLIGNE),0)
                   ,@DO_DateLivr NVARCHAR(50) = '{$this->DO_DateLivr}'
                   ,@CA_Num NVARCHAR(50) = '{$this->CA_Num}'
                    ,@DL_Taxe3 FLOAT = {$this->DL_Taxe3}
                    ,@DL_TypeTaux3 FLOAT = {$this->DL_TypeTaux3}
                    ,@DL_TypeTaxe3 FLOAT = {$this->DL_TypeTaxe3}
                    ,@DL_Frais FLOAT = {$this->DL_Frais}
                    ,@DL_Valorise FLOAT = {$this->DL_Valorise}
                    ,@AR_RefCompose NVARCHAR(50) = NULL
                    ,@DL_NonLivre INT = {$this->DL_NonLivre}
                    ,@AC_RefClient NVARCHAR(50) = '{$this->AC_RefClient}'
                    ,@DL_MontantHT FLOAT = {$this->DL_MontantHT}
                    ,@DL_MontantTTC FLOAT = {$this->DL_MontantTTC}
                    ,@DL_FactPoids FLOAT = {$this->DL_FactPoids}
                    ,@DL_Escompte FLOAT = {$this->DL_Escompte}
                    ,@DL_PiecePL NVARCHAR(50) = '{$this->DL_PiecePL}'
                    ,@DL_DatePL NVARCHAR(50) = '{$this->DL_DatePL}'
                    ,@DL_QtePL FLOAT = {$this->DL_QtePL}
                    ,@DL_NoColis NVARCHAR(50) = '{$this->DL_NoColis}'
                    ,@DL_NoLink INT = {$this->DL_NoLink}
                    ,@RP_Code NVARCHAR(50) = NULL
                    ,@DL_QteRessource FLOAT = {$this->DL_QteRessource}
                    ,@DL_DateAvancement NVARCHAR(50) = '{$this->DL_DateAvancement}'
                    ,@cbProt INT = 0
                   ,@cbCreateur NVARCHAR(50) = '{$this->userName}'
                   ,@cbModification NVARCHAR(50) = GETDATE()
                    ,@cbReplication INT = 0
                    ,@cbFlag INT = 0
                    ,@USERGESCOM NVARCHAR(50) = (SELECT PROT_User FROM F_PROTECTIONCIAL WHERE PROT_No={$this->userName})
                    ,@DATEMODIF NVARCHAR(50) = GETDATE()
                    ,@MACHINEPC NVARCHAR(50) = '{$this->MACHINEPC}'
                  INSERT INTO [dbo].[F_DOCLIGNE]
                    ([DO_Domaine], [DO_Type], [CT_Num], [DO_Piece], [DL_PieceBC], [DL_PieceBL], [DO_Date], [DL_DateBC]
                    , [DL_DateBL], [DL_Ligne], [DO_Ref], [DL_TNomencl], [DL_TRemPied], [DL_TRemExep], [AR_Ref], [DL_Design]
                    , [DL_Qte], [DL_QteBC], [DL_QteBL], [DL_PoidsNet], [DL_PoidsBrut], [DL_Remise01REM_Valeur], [DL_Remise01REM_Type], [DL_Remise02REM_Valeur]
                    , [DL_Remise02REM_Type], [DL_Remise03REM_Valeur], [DL_Remise03REM_Type], [DL_PrixUnitaire]
                    , [DL_PUBC], [DL_Taxe1], [DL_TypeTaux1], [DL_TypeTaxe1], [DL_Taxe2], [DL_TypeTaux2], [DL_TypeTaxe2], [CO_No]
                    , [AG_No1], [AG_No2], [DL_PrixRU], [DL_CMUP], [DL_MvtStock], [DT_No]
                    , [AF_RefFourniss], [EU_Enumere], [EU_Qte], [DL_TTC], [DE_No], [DL_NoRef], [DL_TypePL]
                    , [DL_PUDevise], [DL_PUTTC], [DL_No], [DO_DateLivr], [CA_Num], [DL_Taxe3], [DL_TypeTaux3], [DL_TypeTaxe3]
                    , [DL_Frais], [DL_Valorise], [AR_RefCompose], [DL_NonLivre], [AC_RefClient], [DL_MontantHT], [DL_MontantTTC], [DL_FactPoids]
                    , [DL_Escompte], [DL_PiecePL], [DL_DatePL], [DL_QtePL], [DL_NoColis], [DL_NoLink], [RP_Code]
                    , [DL_QteRessource], [DL_DateAvancement], [cbProt], [cbCreateur], [cbModification], [cbReplication], [cbFlag],[USERGESCOM],[DATEMODIF],[MACHINEPC])
                  VALUES
                    (@DO_Domaine,@DO_Type,@CT_Num,@DO_Piece,@DL_PieceBC,@DL_PieceBL,@DO_Date,@DL_DateBC
                    ,@DL_DateBL,@DL_Ligne,@DO_Ref,@DL_TNomencl,@DL_TRemPied,@DL_TRemExep,@AR_Ref,@DL_Design
                    ,@DL_Qte,@DL_QteBC,@DL_QteBL,@DL_PoidsNet,@DL_PoidsBrut,@DL_Remise01REM_Valeur
                    ,@DL_Remise01REM_Type,@DL_Remise02REM_Valeur,@DL_Remise02REM_Type,@DL_Remise03REM_Valeur
                    ,@DL_Remise03REM_Type,@DL_PrixUnitaire,@DL_PUBC,@DL_Taxe1,@DL_TypeTaux1,@DL_TypeTaxe1
                    ,@DL_NoRefDL_Taxe2,@DL_TypeTaux2,@DL_TypeTaxe2,@CO_No,@AG_No1,@AG_No2,@DL_PrixRU,@DL_CMUP,@DL_MvtStock
                    ,@DT_No,@AF_RefFourniss,@EU_Enumere,@EU_Qte,@DL_TTC,@DE_No,@DL_NoRef,@DL_TypePL,@DL_PUDevise
                    ,@DL_PUTTC,@DL_No,@DO_DateLivr,@CA_Num,@DL_Taxe3,@DL_TypeTaux3,@DL_TypeTaxe3
                    ,@DL_Frais,@DL_Valorise,@AR_RefCompose,@DL_NonLivre,@AC_RefClient,@DL_MontantHT,@DL_MontantTTC
                    ,@DL_FactPoids,@DL_Escompte,@DL_PiecePL,@DL_DatePL,@DL_QtePL,@DL_NoColis,@DL_NoLink
                    ,@RP_Code,@DL_QteRessource,@DL_DateAvancement,@cbProt,@cbCreateur,@cbModification
                    ,@cbReplication,@cbFlag,@USERGESCOM,@DATEMODIF,@MACHINEPC
                    );
                    select @@IDENTITY as cbMarq;
                END;";
        $result = $this->db->query($requete);
       $rows = $result->fetchAll(PDO::FETCH_OBJ);

        $this->logMvt("ajout_ligne", $DE_No,$this->AR_Ref, $this->DL_Qte, $prix, $this->DL_Remise01REM_Valeur, $prix,$this->userName,$rows[0]->cbMarq,$this->DO_Date);
        return $rows[0]->cbMarq;
    }


    public function getcbMarqEntete()
    {
        $query = "  SELECT cbMarq
                    FROM F_DOCENTETE 
                    WHERE  DO_Type = {$this->DO_Type} AND DO_Domaine = {$this->DO_Domaine} AND DO_Piece = '{$this->DO_Piece}'
                  ";
        $result = $this->db->query($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        return $rows[0]->cbMarq;
    }

    public function addDocligneTransfertDetailProcess($DO_Domaine, $DO_Type, $cbMarqEntete, $AR_Ref, $prix, $DL_Qte, $MvtStock, $DE_No, $machine, $protNo)
    {
        $AR_PrixAch = "";
        $AR_Design = "";
        $AR_PrixVen = "";
        $montantHT = "";
        $AR_UniteVen = 0;
        $U_Intitule = "";
        $DO_Date = "";
        $article = new ArticleClass($AR_Ref);
        $AR_PrixAch = $prix;
        $AR_Design = str_replace("'", "''", $article->AR_Design);
        $AR_PrixVen = $article->AR_PrixVen;
        $AR_UniteVen = $article->AR_UniteVen;
        if ($AR_PrixVen == "") $AR_PrixVen = 0;
        if ($AR_PrixAch == "") $AR_PrixAch = 0;
        $montantHT = round(($AR_PrixAch) * $DL_Qte);
        $result = $this->db->requete($this->objetCollection->getUnite($AR_UniteVen));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if ($rows != null) {
            $U_Intitule = $rows[0]->U_Intitule;
        }
        $docEntete = new DocEnteteClass($cbMarqEntete);
        $DO_Date = $docEntete->getDO_DateC();
        $docligne = new DocLigneClass(0);
        $docligne->initVariables();
        $docligne->DL_MvtStock = $MvtStock;
        $docligne->DO_Domaine = $DO_Domaine;
        $docligne->DO_Type = $DO_Type;
        $docligne->CT_Num = $docEntete->DO_Tiers;
        $docligne->DO_Piece = $docEntete->DO_Piece;
        $docligne->DO_Date = $DO_Date;
        $docligne->DO_Ref = $docEntete->DO_Ref;
        $docligne->AR_Ref = $AR_Ref;
        $docligne->DL_Design = $AR_Design;
        $docligne->DL_Qte = $DL_Qte;
        $docligne->DL_QteBC = $DL_Qte;
        $docligne->DL_QteBL = 0;
        $docligne->EU_Qte = $DL_Qte;
        $docligne->DL_Remise01REM_Valeur = 0;
        $docligne->DL_PrixUnitaire = $AR_PrixAch;
        $docligne->DL_Taxe1 = 0;
        $docligne->DL_Taxe2 = 0;
        $docligne->DL_Taxe3 = 0;
        $docligne->CO_No = 0;
        $docligne->DL_PrixRU = $AR_PrixAch;
        $docligne->EU_Enumere = $U_Intitule;
        $docligne->DE_No = $DE_No;
        $docligne->DL_PUTTC = $AR_PrixAch;
        $docligne->CA_Num = $docEntete->CA_Num;
        $docligne->DL_MontantHT = $montantHT;
        $docligne->DL_MontantTTC = $montantHT;
        $docligne->DL_Remise01REM_Type = 0;
        $docligne->DL_QtePL = 0;
        $docligne->DL_QteBL = 0;
        $docligne->DL_TypePL = 0;
        $docligne->DL_TTC = 0;
        $docligne->DL_TypeTaux1 = 0;
        $docligne->DL_TypeTaux2 = 0;
        $docligne->DL_TypeTaux3 = 0;
        $docligne->DL_TypeTaxe1 = 0;
        $docligne->DL_TypeTaxe2 = 0;
        $docligne->DL_TypeTaxe3 = 0;
        $docligne->DL_PieceBL = '';
        $docligne->DL_DateBC = '1900-01-01';
        $docligne->DL_DateBL = $DO_Date;
        $docligne->DL_CMUP = $AR_PrixAch;
        $docligne->DL_DatePL = '1900-01-01';
        $docligne->MACHINEPC = $machine;
        $docligne->userName=$protNo;
        $docligne->insertDocligneMagasin();
        if($MvtStock==1) {
            return $this->lastLigneByDOPieceTrsftDetail($docEntete->DO_Piece);
        }
    }

    public function lastLigneByDOPieceTrsftDetail($doPiece){
        $query = "  SELECT *
                    FROM(SELECT cbMarq as cbMarq_prem,DO_Piece,AR_Ref,DL_Design,DL_Qte,DL_CMUP,DL_MontantHT,DL_CMUP AS DL_PrixUnitaire, ROUND(DL_CMUP* DL_Qte,2)DL_MontantTTC
                        FROM F_DOCLIGNE A
                        WHERE cbMarq IN (SELECT Max(cbmarq) FROM F_DOCLIGNE WHERE  DO_Piece='$doPiece' AND DO_Domaine=4 AND DO_Type=41))A
                    LEFT JOIN (SELECT cbMarq,DO_Piece AS DO_Piece_Dest,DL_CMUP AS DL_PrixUnitaire_Dest,AR_Ref AS AR_Ref_Dest,DL_Design AS DL_Design_Dest,DL_Qte AS DL_Qte_Dest,DL_CMUP AS DL_CMUP_Dest,
                                ROUND(DL_CMUP* DL_Qte,2) AS DL_MontantHT_Dest,ROUND(DL_CMUP* DL_Qte,2) AS DL_MontantTTC_Dest
                                FROM  F_DOCLIGNE
                    WHERE cbMarq IN (SELECT Max(cbmarq) FROM F_DOCLIGNE WHERE  cbDO_Piece='$doPiece' AND DO_Domaine=4 AND DO_Type=40)) B ON DO_Piece = DO_Piece_Dest";
        $result = $this->db->requete($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function val_remise($remise, $type_remise, $prix)
    {
        $val_remise = 0;
        if ($type_remise == 2)
            $val_remise = $remise;
        if ($type_remise == 1)
            $val_remise = $prix * $remise / 100;
        return $val_remise;
    }

    public function val_remiseQuery()
    {
        return "DECLARE @valRemise FLOAT = 0;
        
		IF @typeRemise = 2 
			SET @valRemise = @remise;
		IF @typeRemise = 1 
			SET @valRemise = @prix * @remise /100;
		";
    }

    public function verifbornePrix($rows, $type,$protNo,$catTarif,$arRef)
    {
        if (isset($_SESSION)) {
            $protection = new ProtectionClass("","",$this->db);
            $protection->connexionProctectionByProtNo($protNo);
            $result = $this->db->requete($this->objetCollection->getParametrecial());
            $rowsp = $result->fetchAll(PDO::FETCH_OBJ);
            $flag_minMax = 0;
            if ($rowsp[0]->P_GestionPlanning == 1 || $protection->getPrixParCatCompta() == 1)
                $flag_minMax = 1;

            if ((($type == "Vente" || $type == "Devis" || $type == "BonLivraison") && $catTarif==1 && $protection->PROT_Right != 1 && $flag_minMax == 1)
                || ($rows->Prix_Min == 0 && $rows->Prix_Max == 0))
            {
                $min = $rows->Prix_Min;
                $max = $rows->Prix_Max;
                $pCommunication = new P_CommunicationClass($this->db);

                if($pCommunication->N_CatTarif ==3){
                    if($catTarif>=2){
                        $artClient = new ArtClientClass($arRef,$catTarif,$this->db);
                        $min = $artClient->AC_PrixVen;
                        $max = $artClient->AC_Coef;
                    }
                }
                if (($min != 0 && $max != 0 ) &&
                    (($pCommunication->N_CatTarif ==3 && $catTarif>=2 && ( $rows->DL_PUNetTTC < $min || $rows->DL_PUNetTTC > $max) )
                        || (/*$pCommunication->N_CatTarif !=3 &&*/ $rows->DL_PUNetTTC < $min))) {
                    $data = array('message' => "Le prix doit être compris entre " . $this->objetCollection->formatChiffre($min) . " et " . $this->objetCollection->formatChiffre($max) . " !");
                    return json_encode($data);
                }
            }
            if($catTarif != 1) {
                $artClient = new ArtClientClass($arRef,$catTarif, $this->db);
                if ($this->DO_Domaine == 0 && $catTarif > 1
                    && (($rows->DL_PUNetTTC == $artClient->AC_Coef && $rows->DL_PUNetTTC < $artClient->AC_Remise)
                        || ($rows->DL_PUNetTTC < $artClient->AC_Coef))) {
                    if (($rows->DL_PUNetTTC < $artClient->AC_Coef))
                        $data = array('message' => "Le montant saisie ({$this->objetCollection->formatChiffre($rows->DL_PUNetTTC)}) est inférieur au montant minimum ({$this->objetCollection->formatChiffre($artClient->AC_Coef)})");
                    else
                        $data = array('message' => "La quantité saisie ({$this->objetCollection->formatChiffre($rows->DL_PUNetTTC)})  est inférieure à la quantité minimum ({$this->objetCollection->formatChiffre($artClient->AC_Remise)})");
                    return json_encode($data);
                }
            }
        }
        return null;
    }

    public function verifbornePrixQuery()
    {

        return "DECLARE @pGestionPlanning INT =(select P_GestionPlanning from  P_PARAMETRECIAL)
				,@pReportingPrixRev INT =(select P_ReportPrixRev from  P_PARAMETRECIAL)
				,@flagMinMax INT = 0
				,@protRight AS INT = (SELECT (CASE WHEN PROT_Description='SUPERVISEUR' OR PROT_Description='RAF' THEN 1 ELSE PROT_Right END) PROT_Right FROM F_PROTECTIONCIAL WHERE PROT_No = @protNo) 
				,@valMin AS FLOAT = 0
				,@valMax AS FLOAT = 0
				,@nCatTarif INT = (SELECT N_CatTarif FROM P_Communication)
				,@verifbornePrixQuery NVARCHAR(1500) = NULL;
		IF @pGestionPlanning = 1 OR @pReportingPrixRev = 1 
			SET @flagMinMax = 0;
		
		IF (((@typeFacture = 'Vente' OR @typeFacture = 'BonLivraison') AND @protRight<>1 AND @flagMinMax = 1) OR ( @prixMin = 0 AND @prixMax = 0))
		BEGIN 
			SET @valMin =  @prixMin;
			SET @valMax =  @prixMax;
			IF @nCatTarif = 3 AND @catTarif >=2 
				SELECT @valMin = AC_Coef, @valMax = AC_PrixVen FROM F_ARTCLIENT
			IF ((@valMin <>0 AND @valMax <> 0) AND ((@nCatTarif = 3 AND @catTarif>=2 AND (@dlPUNetTTC< @valMin OR @dlPUNetTTC > @valMax)) OR ( @dlPUNetTTC < @valMin)))
				SET @verifbornePrixQuery = 'Le prix doit être compris entre @valMin et @valMax !'
		END";

    }

    public function addDocligneFactureProcess($dl_mvtStock, $AR_Ref, $DL_Qte, $remise, $type_remise, $cat_tarif, $prix, $login, $type_fac, $machine, $cbMarqEntete, $protNo, $entete_prev = "")
    {
        $docEntete = new DocEnteteClass($cbMarqEntete, $this->db);
        if($entete_prev=="")
            $entete_prev = $docEntete->getDL_PieceBL();

        $val_rem = $this->val_remise($remise, $type_remise, $prix);
        $DO_Date = $docEntete->getDO_DateC();
        $CT_Num = $docEntete->CT_NumPayeur;
        $DE_No = $docEntete->DE_No;
        if ($type_fac == "Entree")
            $DE_No = $docEntete->CT_NumPayeur;
        $CA_Num = $docEntete->CA_Num;
        $DO_Ref = $docEntete->DO_Ref;
        $CO_No = $docEntete->CO_No;
        $DO_Domaine = $docEntete->DO_Domaine;
        $DO_Type = $docEntete->DO_Type;
        $this->DO_Domaine = $DO_Domaine;
        $this->DO_Type = $DO_Type;
        $type_fourn = 0;
        if (strcmp($type_fac, "PreparationCommande") == 0)
            $type_fourn = 1;
        if (strcmp($type_fac, "VenteRetour") == 0)
            $DL_Qte = -$DL_Qte;
        $rows = $this->getPrixClientHT($AR_Ref, $docEntete->N_CatCompta, $cat_tarif, $prix, $val_rem, $DL_Qte, $type_fourn);
        $article = new ArticleClass($AR_Ref, $this->db);
        $tiers = new ComptetClass($CT_Num,"all",$this->db);
        $verifborne = null;
        if($type_fac != "VenteRetour")
            $verifborne = $this->verifbornePrix($rows, $type_fac,$protNo,$cat_tarif,$AR_Ref);

        if ($verifborne != null)
            return $verifborne;
        $montantHT = $rows->DL_MontantHT;
        $pu = $rows->DL_PrixUnitaire;
        $taxe1 = $rows->taxe1;
        $taxe2 = $rows->taxe2;
        $taxe3 = $rows->taxe3;
        $TypeTaxe1 = $rows->TU_TA_Type;
        $TypeTaxe2 = $rows->TD_TA_Type;
        $TypeTaxe3 = $rows->TT_TA_Type;
        $TypeTauxTaxe1 = $rows->TU_TA_TTaux;
        $TypeTauxTaxe2 = $rows->TD_TA_TTaux;
        $TypeTauxTaxe3 = $rows->TT_TA_TTaux;
        $DL_MontantTTC = $rows->DL_MontantTTC;
        $controleClient = null;
        $PparametreLivr = new P_ParametreLivrClass(1,$this->db);
        if($PparametreLivr->PL_Reliquat==1 && $docEntete->getTypeFac()!="Devis") {
            $comptet = new ComptetClass($docEntete->DO_Tiers, "all", $this->db);
            $controleClient = $comptet->controleEncours($type_fac, $DL_MontantTTC, $docEntete->getTypeFac());
        }

        if($controleClient != null)
            return $controleClient;
        $puttc = $rows->DL_PUTTC;
        $typeHT = $rows->AC_PrixTTC;
        $U_Intitule = "";

        $AR_PrixAch = $article->AR_PrixAch;
        $AR_Design = str_replace("'", "''", $article->AR_Design);
        $AR_Ref = $article->AR_Ref;
        $AR_PrixVen = $article->AR_PrixVen;
        $AR_UniteVen = $article->AR_UniteVen;
        $pxMin = $article->Prix_Min;
        if ($AR_PrixVen == "") $AR_PrixVen = 0;
        if ($AR_PrixAch == "") $AR_PrixAch = $prix;

        $rows = $article->isStock($docEntete->DE_No);
        if ($rows != null) {
            $AS_MontSto = $rows[0]->AS_MontSto;
            $AS_QteSto = $rows[0]->AS_QteSto;
            if (strcmp($type_fac, "PreparationCommande") != 0)
                if ($AS_QteSto > 0){
                    $AR_PrixAch = ($AS_MontSto / $AS_QteSto);
                }
                else {
                    if($type_fac!="VenteRetour" && $type_fac!="Entree")
                        $AR_PrixAch = 0;
                }
            $AS_MontSto = 0;
        }
        $result = $this->db->requete($this->objetCollection->getUnite($AR_UniteVen));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if ($rows != null) {
            $U_Intitule = $rows[0]->U_Intitule;
        }
        $dl_typl = 0;
        if ($type_fac == "VenteRetour")
            $dl_typl = 1;
        if ($type_fac == "Avoir")
            $dl_typl = 2;
        $do_dateBC = $DO_Date;
        $do_dateBL = $DO_Date;
        $do_datePL = $DO_Date;
        $DL_QtePL = $DL_Qte;
        $DL_QteBL = $DL_Qte;
        $DL_QteBC = $DL_Qte;
        $EU_Qte = $DL_Qte;
        $DL_CMUP = round($AR_PrixAch, 2);
        if (strcmp($type_fac, "PreparationCommande") == 0 || strcmp($type_fac, "BonCommande") == 0) {
            $do_dateBL = '1900-01-01';
            $do_datePL = '1900-01-01';
            if ($type_fac!= "BonCommande") {
                $do_dateBC = '1900-01-01';
                $DL_QtePL = 0;
                $DL_CMUP = 0;
            }
            $DL_QteBL = 0;
            $dl_mvtStock = 0;
        }
        if (strcmp($type_fac, "Devis") == 0) {
            $dl_mvtStock = 0;
        }

        $this->initVariables();
        $this->DL_MvtStock = $dl_mvtStock;
        $this->CT_Num = $CT_Num;
        $this->DO_Piece = $docEntete->DO_Piece;
        $this->DO_Date = $DO_Date;
        $this->DO_Ref = $DO_Ref;
        $this->AR_Ref = $AR_Ref;
        $this->DL_Design = $AR_Design;
        $this->DL_Qte = $DL_Qte;
        $this->DL_QteBC = $DL_QteBC;
        $this->DL_QteBL = $DL_QteBL;
        $this->EU_Qte = $EU_Qte;
        $this->DL_Remise01REM_Valeur = $remise;
        $this->DL_PrixUnitaire = $pu;
        $this->DL_Taxe1 = $taxe1;
        $this->DL_Taxe2 = $taxe2;
        $this->DL_Taxe3 = $taxe3;
        $this->CO_No = $CO_No;
        if($type_fac == "BonCommande")
            $this->DL_PrixRU = 0;
        else
            $this->DL_PrixRU = round($AR_PrixAch, 2);
        $this->EU_Enumere = $U_Intitule;
        $this->DE_No = $DE_No;
        $this->DL_PUTTC = $puttc;
        $this->CA_Num = $CA_Num;
        $this->DL_MontantHT = $montantHT;
        $this->DL_MontantTTC = $DL_MontantTTC;

        $this->DL_Remise01REM_Type = $type_remise;
        $this->DL_QtePL = $DL_QtePL;
        $this->DL_QteBL = $DL_QteBL;
        $this->DL_TypePL = $dl_typl;
        $this->DL_TTC = $typeHT;
        $this->DL_TypeTaux1 = $TypeTauxTaxe1;
        $this->DL_TypeTaux2 = $TypeTauxTaxe2;
        $this->DL_TypeTaux3 = $TypeTauxTaxe3;
        $this->DL_TypeTaxe1 = $TypeTaxe1;
        $this->DL_TypeTaxe2 = $TypeTaxe2;
        $this->DL_TypeTaxe3 = $TypeTaxe3;
        $this->DL_PieceBL = $entete_prev;
        $this->DL_DateBC = $do_dateBC;
        $this->DL_DateBL = $do_dateBL;
        $this->DL_CMUP = $DL_CMUP;
        $this->DL_DatePL = $do_datePL;
        $this->MACHINEPC = $machine;
        $this->userName= $protNo;
        $this->db->connexion_bdd->beginTransaction();
        try {
            $this->modifiePrix($AR_Ref, $AR_Design, $AR_PrixAch, $AR_PrixVen, $prix, $pxMin, $docEntete->DO_Piece, $login);
            $this->cbMarq = $this->insertDocligneMagasin($DE_No, $prix);
            $article = new ArticleClass($AR_Ref, $this->db);
            if (strcmp($type_fac, "PreparationCommande") != 0  && $type_fac != "BonCommande" && strcmp($type_fac, "Devis") != 0 && strcmp($type_fac, "Avoir") != 0) {
                $article->updateArtStock($DE_No, -$DL_Qte, -$AR_PrixAch * $DL_Qte, $protNo, "ajout_ligne");
            }

            if (strcmp($type_fac, "PreparationCommande") == 0) {
                $article->updateArtStockReel($DE_No, $DL_Qte);
            }
            if (strcmp($type_fac, "BonCommande") == 0) {
                $article->updateArtStockQteRes($DE_No, $DL_Qte);
            }

            $this->commandeStock($DE_No, $AR_Ref, $AR_Design);
            $this->modifiePrix($AR_Ref, $AR_Design, $AR_PrixAch, $AR_PrixVen, $prix, $pxMin, $docEntete->DO_Piece, $login);
            $result = $this->getLigneFactureDernierElement();
            if (strcmp($type_fac, "PreparationCommande") == 0 || strcmp($type_fac, "AchatPreparationCommande") == 0)
                $this->db->requete($this->objetCollection->updateDLColis($docEntete->N_CatCompta, $result->cbMarq));
            $this->db->connexion_bdd->commit();
        }
        catch(Exception $e){
            $this->db->connexion_bdd->rollBack();
            return json_encode($e);
        }
        return json_encode($result);
    }

    public function addDocligneFactureProcessQuery($dl_mvtStock, $AR_Ref, $DL_Qte, $remise, $type_remise, $cat_tarif, $prix, $login, $type_fac, $machine, $cbMarqEntete, $protNo, $entete_prev = "")
    {
        $article = new ArticleClass(0,$this->db);
        $comptet = new ComptetClass(0, "all", $this->db);
        $this->initVariables();
        $query =
            "DECLARE @doDate VARCHAR(20)
				,@ctNum VARCHAR(20)
				,@acte NVARCHAR(20) = 'ajout_ligne'
				,@deNo INT
				,@DO_Piece VARCHAR(50)
				,@caNum VARCHAR(20)
				,@U_Intitule VARCHAR(20)
				,@typeFacture VARCHAR(20) = '$type_fac'
				,@doRef VARCHAR(35)
				,@coNo INT
				,@doDomaine INT
				,@doType INT
				,@nCatCompta INT
				,@typeFourn INT = 0
				,@AR_Ref NVARCHAR(50) = '$AR_Ref'
				,@AR_Design NVARCHAR(250)
				,@prix FLOAT = $prix
				,@dlQte FLOAT = $DL_Qte
				,@typeRemise INT = $type_remise
                ,@remise FLOAT = $remise
                ,@catTarif INT = $cat_tarif
                ,@arPrixAch FLOAT
                ,@arPrixVen FLOAT
                ,@arUniteVen INT
                ,@prixMin FLOAT
                ,@pxMin FLOAT
				,@MACHINEPC NVARCHAR(150) = '$machine'
				,@prixMax FLOAT
				,@dlPUNetTTC FLOAT
				,@AS_QteSto FLOAT
                ,@AS_MontSto FLOAT
                ,@AS_QteMini FLOAT
                ,@AS_QteMaxi FLOAT
                ,@DL_TypePL INT=0
				,@entete_prev NVARCHAR(50) = '$entete_prev'
                ,@plReliquat INT = (SELECT PL_Reliquat FROM P_ParametreLivr)
                ,@protNo INT = $protNo;
				
				SELECT  @doDate = CONVERT(char(10), CAST(DO_Date AS DATE),126)
				        ,@ctNum = CT_NumPayeur
				        ,@deNo = DE_No
				        ,@caNum = CA_Num
				        ,@doRef = DO_Ref
				        ,@coNo = CO_No
				        ,@doDomaine = DO_Domaine
				        ,@nCatCompta = N_CatCompta
				        ,@doType = DO_Type
						,@DO_Piece = DO_Piece
                FROM    F_DOCENTETE
                WHERE   cbMarq = $cbMarqEntete;
				IF @typeFacture ='Entree'
					SET @deNo = @ctNum
				IF @typeFacture ='PreparationCommande'
					SET @typeFourn = 1;
				IF @typeFacture ='VenteRetour'
					SET @dlQte = -@dlQte
                
                SELECT  @arPrixAch = AR_PrixAch
                        ,@AR_Design = AR_Design
                        ,@arPrixVen = AR_PrixVen 
                        ,@arUniteVen = AR_UniteVen 
                        ,@pxMin = Prix_Min
                FROM    F_ARTICLE 
                WHERE   AR_Ref = @AR_Ref
                SELECT @U_Intitule = U_Intitule FROM P_UNITE WHERE cbIndice= @arUniteVen
              {$this->val_remiseQuery()} {$this->getPrixClientHTQuery()}
            {$this->verifbornePrixQuery()}
DECLARE @DL_DateBC VARCHAR(20) = @doDate
        ,@DL_DateBL VARCHAR(20) = @doDate
        ,@DL_DatePL VARCHAR(20) = @doDate
        ,@DL_QtePL FLOAT = @dlQte
        ,@DL_QteBL FLOAT = @dlQte
        ,@DL_QteBC FLOAT = @dlQte
        ,@EU_Qte FLOAT = @dlQte
        ,@DL_CMUP FLOAT = ROUND(@arPrixAch, 2)
        ,@DL_MvtStock INT; 
        IF @typeFacture = 'PreparationCommande'
        BEGIN         
            SET @DL_DateBC = '1900-01-01';
            SET @DL_DateBL = '1900-01-01';
            SET @DL_DatePL = '1900-01-01';
            SET @DL_QtePL = 0;
            SET @DL_QteBL = 0;
            SET @DL_CMUP = 0;
            SET @DL_MvtStock = 0;
        END
        IF @typeFacture ='Devis'
            SET @DL_MvtStock = 0;
            		DECLARE @DO_Domaine VARCHAR(20) = @doDomaine
				, @DO_Type int = @doType
				, @CT_Num VARCHAR(50) = @ctNum
				, @DL_PieceBC  VARCHAR(50) = '{$this->DL_PieceBC}'
				, @DL_PieceBL VARCHAR(50) = @entete_prev
				, @DO_Date VARCHAR(50) = @doDate
				, @DO_Ref VARCHAR(50) = @doRef
				, @DL_TNomencl VARCHAR(50) =  '{$this->DL_TNomencl}'
				, @DL_TRemPied VARCHAR(50) =  '{$this->DL_TRemPied}'
				, @DL_TRemExep VARCHAR(50) =  '{$this->DL_TRemExep}'
				, @DL_Design VARCHAR(50) = @AR_Design
				, @DL_Qte FLOAT = @dlQte
				, @DL_PoidsNet VARCHAR(50) = '{$this->DL_PoidsNet}'
				, @DL_PoidsBrut VARCHAR(50) = '{$this->DL_PoidsBrut}'
				, @DL_Remise01REM_Valeur FLOAT = @remise
				, @DL_Remise01REM_Type float = @typeRemise
				, @DL_Remise02REM_Valeur FLOAT = '{$this->DL_Remise02REM_Valeur}'
				, @DL_Remise02REM_Type float = '{$this->DL_Remise02REM_Type}'
				, @DL_Remise03REM_Valeur FLOAT = '{$this->DL_Remise03REM_Valeur}'
				, @DL_Remise03REM_Type float = '{$this->DL_Remise03REM_Type}'
				, @DL_PrixUnitaire FLOAT = @pu
				, @DL_PUBC FLOAT = '{$this->DL_PUBC}'
				, @DL_Taxe1 FLOAT = @taxe1
				, @DL_TypeTaux1 FLOAT = @TypeTauxTaxe1
				, @DL_TypeTaxe1 FLOAT = @TypeTaxe1
				, @DL_Taxe2 FLOAT = @taxe2
				, @DL_TypeTaux2 FLOAT = @TypeTauxTaxe2
				, @DL_TypeTaxe2 FLOAT = @TypeTaxe2
				, @DL_Taxe3 FLOAT = @taxe3
				, @DL_TypeTaux3 FLOAT = @TypeTauxTaxe3
				, @DL_TypeTaxe3 FLOAT = @TypeTaxe3
				, @CO_No INT = @coNo
				, @AG_No1 INT = '{$this->AG_No1}'
				, @AG_No2 INT = '{$this->AG_No2}'
				, @AR_PrixAch FLOAT = @arPrixAch
				, @DL_PrixRU FLOAT = (SELECT ROUND(@arPrixAch,2))
				, @DT_No INT = '{$this->DT_No}'
				, @AF_RefFourniss VARCHAR(50) = '{$this->AF_RefFourniss}'
				, @EU_Enumere VARCHAR(50) = @U_Intitule
				, @DL_TTC FLOAT = @AC_PrixTTC
				, @DE_No INT = @deNo
				, @DL_NoRef INT = '{$this->DL_NoRef}'
				, @DL_PUDevise FLOAT = '{$this->DL_PUDevise}'
				, @DO_DateLivr VARCHAR(50) = '{$this->DO_DateLivr}'
				, @CA_Num VARCHAR(50) = @caNum
				, @DL_Frais FLOAT = '{$this->DL_Frais}'
				, @DL_Valorise FLOAT = '{$this->DL_Valorise}'
				, @DL_NonLivre FLOAT = '{$this->DL_NonLivre}'
				, @AC_RefClient VARCHAR(50) = '{$this->AC_RefClient}'

				, @DL_MontantHT FLOAT = @montantHT
				, @DL_FactPoids FLOAT = '{$this->DL_FactPoids}'
				, @DL_Escompte FLOAT = '{$this->DL_Escompte}'
				, @DL_PiecePL VARCHAR(50) = '{$this->DL_PiecePL}'
				, @DL_NoColis VARCHAR(50) = '{$this->DL_NoColis}'
				, @DL_NoLink INT = '{$this->DL_NoLink}'
				, @DL_QteRessource FLOAT = '{$this->DL_QteRessource}'
				, @DL_DateAvancement VARCHAR(50) = '{$this->DL_DateAvancement}'
				, @cbCreateur VARCHAR(50) = @protNo
				, @cbMarqLigne INT;
				
INSERT INTO [dbo].[F_DOCLIGNE]
				  ([DO_Domaine], [DO_Type], [CT_Num], [DO_Piece], [DL_PieceBC], [DL_PieceBL], [DO_Date], [DL_DateBC]
				  , [DL_DateBL], [DL_Ligne], [DO_Ref], [DL_TNomencl], [DL_TRemPied], [DL_TRemExep], [AR_Ref], [DL_Design]
				  , [DL_Qte], [DL_QteBC], [DL_QteBL], [DL_PoidsNet], [DL_PoidsBrut], [DL_Remise01REM_Valeur], [DL_Remise01REM_Type], [DL_Remise02REM_Valeur]
				  , [DL_Remise02REM_Type], [DL_Remise03REM_Valeur], [DL_Remise03REM_Type], [DL_PrixUnitaire]
				  , [DL_PUBC], [DL_Taxe1], [DL_TypeTaux1], [DL_TypeTaxe1], [DL_Taxe2], [DL_TypeTaux2], [DL_TypeTaxe2], [CO_No]
				  , [AG_No1], [AG_No2], [DL_PrixRU], [DL_CMUP], [DL_MvtStock], [DT_No]
				  , [AF_RefFourniss], [EU_Enumere], [EU_Qte], [DL_TTC], [DE_No], [DL_NoRef], [DL_TypePL]
				  , [DL_PUDevise], [DL_PUTTC], [DL_No], [DO_DateLivr], [CA_Num], [DL_Taxe3], [DL_TypeTaux3], [DL_TypeTaxe3]
				  , [DL_Frais], [DL_Valorise], [AR_RefCompose], [DL_NonLivre], [AC_RefClient], [DL_MontantHT], [DL_MontantTTC], [DL_FactPoids]
				  , [DL_Escompte], [DL_PiecePL], [DL_DatePL], [DL_QtePL], [DL_NoColis], [DL_NoLink], [RP_Code]
				  , [DL_QteRessource], [DL_DateAvancement], [cbProt], [cbCreateur], [cbModification], [cbReplication], [cbFlag],[USERGESCOM],[DATEMODIF],[MACHINEPC])
							VALUES
				  (@DO_Domaine,@DO_Type ,@CT_Num,@DO_Piece
				  ,@DL_PieceBC,@DL_PieceBL,@DO_Date,@DL_DateBC
				  ,@DL_DateBL ,/*DL_Ligne*/ (SELECT (1+COUNT(*))*10000 FROM F_DOCLIGNE WHERE DO_PIECE=@DO_Piece AND DO_Domaine=@DO_Domaine AND DO_Type=@DO_Type),@DO_Ref
				,@DL_TNomencl,@DL_TRemPied,@DL_TRemExep,@AR_Ref,@DL_Design
				  ,@DL_Qte ,@DL_QteBC, @DL_QteBL ,@DL_PoidsNet,@DL_PoidsBrut,@DL_Remise01REM_Valeur
				  ,@DL_Remise01REM_Type,@DL_Remise02REM_Valeur,@DL_Remise02REM_Type,@DL_Remise03REM_Valeur
				  ,@DL_Remise03REM_Type,@DL_PrixUnitaire,@DL_PUBC,@DL_Taxe1,@DL_TypeTaux1,@DL_TypeTaxe1,@DL_Taxe2,@DL_TypeTaux2
				  ,@DL_TypeTaxe2,@CO_No,@AG_No1,@AG_No2,@DL_PrixRU,@DL_CMUP,@DL_MvtStock,@DT_No,@AF_RefFourniss
				  ,@EU_Enumere,@EU_Qte,@DL_TTC,@DE_No,@DL_NoRef,@DL_TypePL,@DL_PUDevise,@DL_PUTTC,/*DL_No*/ ISNULL((SELECT MAX(DL_No)+1 FROM F_DOCLIGNE),0),@DO_DateLivr
				,@CA_Num,@DL_Taxe3,@DL_TypeTaux3,@DL_TypeTaxe3,@DL_Frais,@DL_Valorise,NULL,@DL_NonLivre,@AC_RefClient,@DL_MontantHT,@DL_MontantTTC
				  ,@DL_FactPoids,@DL_Escompte,@DL_PiecePL,@DL_DatePL,@DL_QtePL,@DL_NoColis,@DL_NoLink,/*RP_Code*/NULL,@DL_QteRessource,@DL_DateAvancement,/*cbProt*/0
				  ,@cbCreateur,/*cbModification*/GETDATE(),/*cbReplication*/0,/*cbFlag*/0,/*USERGESCOM*/(SELECT PROT_User FROM F_PROTECTIONCIAL WHERE PROT_No=@cbCreateur)
				  ,/*DATEMODIF*/GETDATE(),/*MACHINEPC*/@MACHINEPC);
				  SELECT @cbMarqLigne = @@IDENTITY
		
        IF @typeFacture NOT IN ('PreparationCommande','Devis','Avoir')
		BEGIN 
			
                IF EXISTS (SELECT 1 FROM F_ARTSTOCK WHERE DE_No= @DE_No AND AR_Ref= @AR_Ref)
                    UPDATE F_ARTSTOCK SET AS_QteSto=AS_QteSto+@dlQte,cbModification=GETDATE(),
                    AS_MontSto=ROUND((CASE WHEN AS_MontSto+ @AR_PrixAch <0 THEN 0 ELSE ROUND(AS_MontSto+@AR_PrixAch,2) END),2) 
                    WHERE DE_No=@DE_No  AND AR_Ref=@AR_Ref;
                ELSE
                    INSERT INTO F_ARTSTOCK  
                        VALUES(/*AR_Ref*/@AR_Ref,/*DE_No*/@DE_No 
                               ,/*AS_QteMini*/0,/*AS_QteMaxi*/0
                               ,/*AS_MontSto*/ROUND(@AR_PrixAch,2),/*AS_QteSto*/@dlQte
                               ,/*AS_QteRes*/0,/*AS_QteCom*/0
                               ,/*AS_Principal*/0,/*AS_QteResCM*/0
                               ,/*AS_QteComCM*/0,/*AS_QtePrepa*/0
                               ,/*DP_NoPrincipal*/0,/*cbDP_NoPrincipal*/NULL
                               ,/*DP_NoControle*/0,/*cbDP_NoControle*/NULL
                               ,/*AS_QteAControler*/0,/*cbProt*/0
                               ,/*cbCreateur*/'AND',/*cbModification*/GETDATE()
                               ,/*cbReplication*/0,/*cbFlag*/0);
                INSERT INTO Z_LogInfo VALUES ('Artstock','ajout_ligne',0,'',@DE_No,0,@AR_Ref,(SELECT AS_QteSto FROM F_ARTSTOCK WHERE AR_Ref=@AR_Ref AND DE_No=@DE_No),0,''
			,(SELECT AS_MontSto FROM F_ARTSTOCK WHERE AR_Ref=@AR_Ref AND DE_No=@DE_No),GETDATE(),@protNo,(SELECT cbMarq FROM F_ARTSTOCK WHERE AR_Ref=@AR_Ref AND DE_No=@DE_No),'F_ARTSTOCK',@protNo);
		
		
		IF @typeFacture = 'PreparationCommande'
		BEGIN 
			{$article->updateArtStockReelQuery()}
		END
		IF @typeFacture IN ('PreparationCommande','AchatPreparationCommande')
		BEGIN 
			UPDATE F_DOCLIGNE SET DL_NoColis=@nCatCompta,cbModification=GETDATE() WHERE cbMarq=@cbMarqLigne
		END
		SELECT *
		FROM F_DOCLIGNE
		WHERE cbMarq= @cbMarqLigne
		END
        "
        ;
        //ECHO $query;
        $row = $this->db->query($query);

//        $this->commandeStock($DE_No, $AR_Ref, $AR_Design);
//        $this->modifiePrix($AR_Ref, $AR_Design, $AR_PrixAch, $AR_PrixVen, $prix, $pxMin, $docEntete->DO_Piece, $login);
        return json_encode($row);
    }

    public function ajout_ligneFacturation($qteG, $ARRefG, $cbMarqEntete, $typeFacG, $cattarifG, $prixG, $remiseG, $machinepcG, $acte,$protNo)
    {
        return $this->getApiString("/ajoutLigne&cbMarq={$this->cbMarq}&protNo=$protNo&dlQte={$this->formatAmount($qteG)}&arRef={$this->formatString($ARRefG)}&cbMarqEntete=$cbMarqEntete&typeFacture=$typeFacG&catTarif=$cattarifG&dlPrix={$this->formatAmount($prixG)}&dlRemise={$this->formatString($remiseG)}&machineName={$this->formatString($machinepcG)}&acte=$acte&entete_prev=");
    }

    public function logMvt($action, $DE_No, $AR_Ref, $Qte, $Prix, $Remise, $Montant,$cbCreateur,$cbMarq,$doDate)
    {
        $log = new LogFile();
        $log->writeFacture($action, $this->DO_Type, $this->DO_Piece, $DE_No, $this->DO_Domaine, $AR_Ref, $Qte, $Prix, $Remise, $Montant,$cbMarq,"F_DOCLIGNE",$this->userName,$cbCreateur,$doDate);
    }

    public function addDocligneEntreeMagasinProcess($AR_Ref, $cbMarqEntete, $DL_Qte, $MvtStock, $mvtEntree, $prix, $type_fac, $machine, $protNo)
    {
        return $this->ajout_ligneFacturation($DL_Qte,$AR_Ref,$cbMarqEntete,$type_fac,0,$prix,"",$machine,"ajout_ligne",$protNo);
    }

    public function addDocligneSortieMagasinProcess($AR_Ref, $cbMarqEntete, $DL_Qte, $MvtStock, $typefac, $machine, $protNo)
    {
        return $this->ajout_ligneFacturation($DL_Qte,$AR_Ref,$cbMarqEntete,$typefac,0,0,"",$machine,"ajout_ligne",$protNo);
    }


    public function addDocligneTransfertConfirmationProcess($AR_Ref, $prix, $DL_Qte, $cbMarqEntete, $cbFirst)
    {
        $query = "INSERT INTO Z_LIGNE_CONFIRMATION([AR_Ref],[Prix],[DL_Qte],[cbMarqEntete],[cbMarqLigneFirst]) VALUES ('$AR_Ref',$prix,$DL_Qte,$cbMarqEntete,$cbFirst)";
        $this->db->requete($query);
    }

    public function addDocligneTransfertProcess($AR_Ref, $prix, $DL_Qte, $MvtStock, $machine, $cbMarqEntete, $protNo, $cbFirst)
    {
        $docEntete = new DocEnteteClass($cbMarqEntete, $this->db);
        $CT_Num = $docEntete->DO_Tiers;
        $DE_No = $docEntete->DE_No;
        $U_Intitule = "";
        $article = new ArticleClass($AR_Ref, $this->db);
        $AR_PrixAch = $prix;
        $AR_Design = str_replace("'", "''", $article->AR_Design);
        $AR_UniteVen = $article->AR_UniteVen;
        if ($AR_PrixAch == "") $AR_PrixAch = 0;
        $montantHT = round(($AR_PrixAch) * $DL_Qte, 2);
        $result = $this->db->requete($this->objetCollection->getUnite($AR_UniteVen));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if ($rows != null) {
            $U_Intitule = $rows[0]->U_Intitule;
        }

        if ($MvtStock == 1)
            $DE_No = $docEntete->DO_Tiers;
        else {
            $isStock = $article->isStock($docEntete->DE_No);
            if($isStock[0]->AS_QteSto==0)
                $AR_PrixAch =0;
            else
                $AR_PrixAch = $isStock[0]->AS_MontSto / $isStock[0]->AS_QteSto;
        }

        $DO_Date = $docEntete->getDO_DateC();
        $this->initVariables();
        $this->DL_MvtStock = $MvtStock;
        $this->DO_Domaine = $docEntete->DO_Domaine;
        $this->DO_Type = $docEntete->DO_Type;
        $this->CT_Num = $CT_Num;
        $this->DO_Piece = $docEntete->DO_Piece;
        $this->DO_Date = $DO_Date;
        $this->DO_Ref = $docEntete->DO_Ref;
        $this->AR_Ref = $AR_Ref;
        $this->DL_Design = $AR_Design;
        $this->DL_Qte = $DL_Qte;
        $this->DL_QteBC = $DL_Qte;
        $this->EU_Qte = $DL_Qte;
        $this->DL_Remise01REM_Valeur = 0;
        $this->DL_PrixUnitaire = round($AR_PrixAch, 2);
        $this->DL_Taxe1 = 0;
        $this->DL_Taxe2 = 0;
        $this->DL_Taxe3 = 0;
        $this->CO_No = 0;
        $this->DL_PrixRU = round($AR_PrixAch, 2);
        $this->EU_Enumere = $U_Intitule;
        $this->DE_No = $DE_No;
        $this->DL_PUTTC = round($AR_PrixAch, 2);
        $this->CA_Num = $docEntete->CA_Num;
        $this->DL_MontantHT = $montantHT;
        $this->DL_MontantTTC = $montantHT;
        $this->DL_Remise01REM_Type = 0;
        $this->DL_QtePL = 0;
        $this->DL_QteBL = 0;
        $this->DL_TypePL = 0;
        $this->DL_TTC = 0;
        $this->DL_TypeTaux1 = 0;
        $this->DL_TypeTaux2 = 0;
        $this->DL_TypeTaux3 = 0;
        $this->DL_TypeTaxe1 = 0;
        $this->DL_TypeTaxe2 = 0;
        $this->DL_TypeTaxe3 = 0;
        $this->DL_PieceBL = '';
        $this->DL_DateBC = '1900-01-01';
        $this->DL_DateBL = $DO_Date;
        $this->DL_CMUP = round($AR_PrixAch, 2);
        $this->DL_DatePL = '1900-01-01';
        $this->MACHINEPC = $machine;
        $this->userName = $protNo;
        $cbmarqligne = $this->insertDocligneMagasin();
//        $this->logMvt("ajout_ligne", $cbMarqEntete, 0, $AR_Ref, $DL_Qte, $this->DL_PrixUnitaire, 0, $this->DL_MontantTTC,$protNo,$cbmarqligne,'F_DOCLIGNE',$protNo);

        $DE_No = $docEntete->DO_Tiers;
        if ($MvtStock == 3) $DE_No = $docEntete->DE_No;
        $article = new ArticleClass($AR_Ref, $this->db);
        $isStock = $article->isStock($DE_No);
        $isStockRepart = $article->isStock($docEntete->DE_No);
        if ($MvtStock == 1) {
            $qteTransfert = $DL_Qte;
            $montantTransfert = round($AR_PrixAch, 2) * $DL_Qte;
            $article->updateArtStock($DE_No, $qteTransfert, $montantTransfert,$protNo,"ajout_ligne");
        } else {
            $prixSource = $isStockRepart[0]->AS_MontSto;
            $qteSource = $isStockRepart[0]->AS_QteSto;
            $value = ($qteSource == 0) ? 0 : round($prixSource / $qteSource, 2);
            $qteTransfert = -$DL_Qte;
            $montantTransfert = $value * -$DL_Qte;
            $article->updateArtStock($DE_No, $qteTransfert, $montantTransfert,$protNo,"ajout_ligne");
        }
        return new DocLigneClass($cbmarqligne, $this->db);
    }


    public function addDocligneAchatProcess($dl_mvtStock, $cbMarqEntete, $AR_Ref, $DL_Qte, $remise, $type_remise, $cat_tarif, $prix, $type_fac, $machine,$protNo, $entete_prev = "")
    {
        $docEntete = new DocEnteteClass($cbMarqEntete);
        $val_rem = $this->val_remise($remise, $type_remise, $prix);
        if($type_fac=="AchatRetour") {
            $DL_Qte = -$DL_Qte;
            $dl_mvtStock=3;
        }
        $DO_Date = $docEntete->getDO_DateC();
        $CT_Num = $docEntete->CT_NumPayeur;
        $DE_No = $docEntete->DE_No;
        $CA_Num = $docEntete->CA_Num;
        $DO_Ref = $docEntete->DO_Ref;
        $CO_No = $docEntete->CO_No;
        $DO_Domaine = $docEntete->DO_Domaine;
        $DO_Type = $docEntete->DO_Type;
        $rows = $this->getPrixClientHT($AR_Ref, $docEntete->N_CatCompta, $cat_tarif, $prix, $val_rem, $DL_Qte, 1);
        $montantHT = $rows->DL_MontantHT;
        $pu = $rows->DL_PrixUnitaire;
        $taxe1 = $rows->taxe1;
        $taxe2 = $rows->taxe2;
        $taxe3 = $rows->taxe3;
        $TypeTaxe1 = $rows->TU_TA_Type;
        $TypeTaxe2 = $rows->TD_TA_Type;
        $TypeTaxe3 = $rows->TT_TA_Type;
        $TypeTauxTaxe1 = $rows->TU_TA_TTaux;
        $TypeTauxTaxe2 = $rows->TD_TA_TTaux;
        $TypeTauxTaxe3 = $rows->TT_TA_TTaux;
        $DL_MontantTTC = $rows->DL_MontantTTC;
        $puttc = $rows->DL_PUTTC;
        $typeHT = 0;
        $article = new ArticleClass($AR_Ref);
        $AR_PrixAch = $pu;
        $AR_Design = str_replace("'", "''", $article->AR_Design);
        $AR_Ref = $article->AR_Ref;
        $AR_PrixVen = $article->AR_PrixVen;
        $artfourn = $article->getArtFournisseurByTiers($CT_Num);
        $AR_UniteVen = $article->AR_UniteVen;
        if (sizeof($artfourn) != 0)
            $AR_UniteVen = $artfourn[0]->AF_Unite;
        if ($AR_PrixVen == "") $AR_PrixVen = 0;
        if ($AR_PrixAch == "") $AR_PrixAch = 0;
        $U_Intitule = "";
        $result = $this->db->requete($this->objetCollection->getUnite($AR_UniteVen));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if ($rows != null) {
            $U_Intitule = $rows[0]->U_Intitule;
        }

        if (strcmp($type_fac, "AchatRetour") == 0) {
            $isStock = $article->isStock($docEntete->DE_No);
            if($isStock[0]->AS_QteSto!=0)
                $AR_PrixAch = $isStock[0]->AS_MontSto/$isStock[0]->AS_QteSto;
        }

        $dl_typl = 0;
        if (strcmp($type_fac, "PreparationCommande") == 0) {
            $do_dateBC = '1900-01-01';
            $do_dateBL = '1900-01-01';
            $do_datePL = '1900-01-01';
            $DL_QtePL = 0;
            $DL_QteBL = 0;
            $DL_CMUP = 0;
            $dl_mvtStock = 0;
        }

        if (strcmp($type_fac, "AchatPreparationCommande") == 0) {
            $dl_mvtStock = 0;
        }

        if (strcmp($type_fac, "Achat") == 0 || strcmp($type_fac, "AchatRetour") == 0 || strcmp($type_fac, "AchatPreparationCommande") == 0) {
            $do_dateBC = $DO_Date;
            $do_dateBL = $DO_Date;
            $do_datePL = '1900-01-01';
            $DL_QtePL = 0;
            $DL_QteBL = $DL_Qte;
            $DL_CMUP = round($AR_PrixAch, 2);
        }
        $DL_QteBC = $DL_Qte;
        $EU_Qte = $DL_Qte;
        $this->initVariables();
        $this->DL_MvtStock = $dl_mvtStock;
        $this->DO_Domaine = $DO_Domaine;
        $this->DO_Type = $DO_Type;
        $this->CT_Num = $CT_Num;
        $this->DO_Piece = $docEntete->DO_Piece;
        $this->DO_Date = $DO_Date;
        $this->DO_Ref = $DO_Ref;
        $this->AR_Ref = $AR_Ref;
        $this->DL_Design = $AR_Design;
        $this->DL_Qte = $DL_Qte;
        $this->DL_QteBC = $DL_QteBC;
        $this->DL_QteBL = $DL_QteBL;
        $this->EU_Qte = $EU_Qte;
        $this->DL_Remise01REM_Valeur = $remise;
        $this->DL_PrixUnitaire = $pu;
        $this->DL_Taxe1 = $taxe1;
        $this->DL_Taxe2 = $taxe2;
        $this->DL_Taxe3 = $taxe3;
        $this->CO_No = $CO_No;
        $this->DL_PrixRU = round($AR_PrixAch, 2);
        $this->EU_Enumere = $U_Intitule;
        $this->DE_No = $DE_No;
        $this->DL_PUTTC = $puttc;
        $this->CA_Num = $CA_Num;
        $this->DL_MontantHT = $montantHT;
        $this->DL_MontantTTC = $DL_MontantTTC;
        $this->DL_Remise01REM_Type = $type_remise;
        $this->DL_QtePL = $DL_QtePL;
        $this->DL_QteBL = $DL_QteBL;
        $this->DL_TypePL = $dl_typl;
        $this->DL_TTC = $typeHT;
        $this->DL_TypeTaux1 = $TypeTauxTaxe1;
        $this->DL_TypeTaux2 = $TypeTauxTaxe2;
        $this->DL_TypeTaux3 = $TypeTauxTaxe3;
        $this->DL_TypeTaxe1 = $TypeTaxe1;
        $this->DL_TypeTaxe2 = $TypeTaxe2;
        $this->DL_TypeTaxe3 = $TypeTaxe3;
        $this->DL_PieceBL = $entete_prev;
        $this->DL_DateBC = $do_dateBC;
        $this->DL_DateBL = $do_dateBL;
        $this->DL_CMUP = $DL_CMUP;
        $this->DL_DatePL;
        $do_datePL;
        $this->MACHINEPC = $machine;
        $this->userName = $protNo;

        $this->db->connexion_bdd->beginTransaction();
        try {
            $this->cbMarq = $this->insertDocligneMagasin($docEntete->DE_No, $prix);
            $article = new ArticleClass($AR_Ref, $this->db);
            if (strcmp($type_fac, "PreparationCommande") == 0) {
                $article->updateArtStockReel($DE_No, $DL_Qte);
            }
            $isStock = $article->isStock($DE_No);
            if ($isStock == null) {
                if ($type_fac != "AchatRetour")
                    $article->updateArtStock($DE_No, $DL_Qte, $AR_PrixAch * $DL_Qte, $protNo, "ajout_ligne");
            } else {
                $article->updateArtStock($DE_No, $DL_Qte, $AR_PrixAch * $DL_Qte, $protNo, "ajout_ligne");
            }
            $rows = $this->getLigneFactureDernierElement();
            if (strcmp($type_fac, "PreparationCommande") == 0 || strcmp($type_fac, "AchatPreparationCommande") == 0)
                $this->db->requete($this->objetCollection->updateDLColis($docEntete->N_CatCompta, $rows->cbMarq));
            $this->db->connexion_bdd->commit();
        }
        catch(Exception $e){
            $this->db->connexion_bdd->rollBack();
            return json_encode($e);
        }
        return json_encode($rows);
    }

    public function modifDocligneAchat($cbMarqEntete, $AR_Ref, $DL_Qte, $remise, $type_remise, $cat_tarif, $prix, $type_fac, $machine, $protNo, $entete_prev = "")
    {
        $ANDL_Qte = $this->DL_Qte;
        $AN_CMUP = $this->DL_CMUP;
        $docEntete = new DocEnteteClass($cbMarqEntete, $this->db);
        $val_rem = $this->val_remise($remise, $type_remise, $prix);
        $CT_Num = $docEntete->CT_NumPayeur;
        $DE_No = $docEntete->DE_No;
        if($type_fac=="AchatRetour")
            $DL_Qte=-$DL_Qte;
        $rows = $this->getPrixClientHT($AR_Ref, $docEntete->N_CatCompta, $cat_tarif, $prix, $val_rem, $DL_Qte, 1);
        if ($rows != null) {
            $montantHT = $rows->DL_MontantHT;
            $pu = $rows->DL_PrixUnitaire;
            $taxe1 = $rows->taxe1;
            $taxe2 = $rows->taxe2;
            $taxe3 = $rows->taxe3;
            $TypeTauxTaxe1 = $rows->TU_TA_TTaux;
            $TypeTauxTaxe2 = $rows->TD_TA_TTaux;
            $TypeTauxTaxe3 = $rows->TT_TA_TTaux;
            $TypeTaxe1 = $rows->TU_TA_Type;
            $TypeTaxe2 = $rows->TD_TA_Type;
            $TypeTaxe3 = $rows->TT_TA_Type;
            $DL_MontantTTC = $rows->DL_MontantTTC;
            $puttc = $rows->DL_PUTTC;
            $typeHT = 0;
            $article = new ArticleClass($AR_Ref);
            $AR_PrixAch = $prix;
            $DL_QtePL = $DL_Qte;
            $DL_QteBL = $DL_Qte;
            $DL_CMUP = round($AR_PrixAch, 2);
            if (strcmp($type_fac, "PreparationCommande") == 0) {
                $DL_QtePL = 0;
                $DL_QteBL = 0;
                $DL_CMUP = 0;
            }
            if (strcmp($type_fac, "PreparationCommande") == 0 || strcmp($type_fac, "AchatPreparationCommande") == 0)
                $this->db->requete($this->objetCollection->updateDLColis($docEntete->N_CatCompta, $this->cbMarq));
            $DL_QteBC = $DL_Qte;
            $EU_Qte = $DL_Qte;
            $this->CT_Num = $CT_Num;
            $this->DL_Qte = $DL_Qte;
            $this->DL_QteBC = $DL_QteBC;
            $this->DL_QteBL = $DL_QteBL;
            $this->EU_Qte = $EU_Qte;
            $this->DL_Remise01REM_Valeur = $remise;
            $this->DL_PrixUnitaire = $pu;
            $this->DL_Taxe1 = $taxe1;
            $this->DL_Taxe2 = $taxe2;
            $this->DL_Taxe3 = $taxe3;
            $this->DL_PrixRU = round($AR_PrixAch, 2);
            $this->DL_PUTTC = $puttc;
            $this->DL_MontantHT = $montantHT;
            $this->DL_MontantTTC = $DL_MontantTTC;
            $this->DL_Remise01REM_Type = $type_remise;
            $this->DL_QtePL = $DL_QtePL;
            $this->DL_TTC = $typeHT;
            $this->DL_TypeTaux1 = $TypeTauxTaxe1;
            $this->DL_TypeTaux2 = $TypeTauxTaxe2;
            $this->DL_TypeTaux3 = $TypeTauxTaxe3;
            $this->DL_TypeTaxe1 = $TypeTaxe1;
            $this->DL_TypeTaxe2 = $TypeTaxe2;
            $this->DL_TypeTaxe3 = $TypeTaxe3;
            $this->DL_PieceBL = $entete_prev;
            $this->DL_CMUP = $DL_CMUP;
            $this->MACHINEPC = $machine;
            $this->userName = $protNo;

            $this->db->connexion_bdd->beginTransaction();
            try {
                $this->maj_docLigne($prix, $this->cbCreateur);
                if (strcmp($type_fac, "PreparationCommande") == 0) {
                    $article->updateArtStockReel($DE_No, $DL_Qte);
                }

                $isStock = $article->isStock($DE_No);
                if ($isStock == null) {
                    $article->updateArtStock($DE_No, $DL_Qte - $ANDL_Qte, ($AR_PrixAch * $DL_Qte) - ($AN_CMUP * $ANDL_Qte), $protNo, "modif_ligne");
                } else {
                    $article->updateArtStock($DE_No, $DL_Qte - $ANDL_Qte, ($AR_PrixAch * $DL_Qte) - ($AN_CMUP * $ANDL_Qte), $protNo, "modif_ligne");
                }
                $rows = $this->getLigneFactureDernierElement();
                $this->db->connexion_bdd->commit();
            }
            catch(Exception $e){
                $this->db->connexion_bdd->rollBack();
                return json_encode($e);
            }
            return json_encode($rows);
        }
    }


    public function getLigneFactureDernierElement()
    {
        $query = "SELECT cbMarq,DL_PUTTC,DL_NoColis,DO_Piece,AR_Ref,DL_Design,DL_Qte,DL_PrixUnitaire,DL_CMUP,DL_Taxe1,DL_Taxe2,
                DL_Taxe3,DL_MontantTTC,DL_MontantHT,DL_Ligne,
                CASE WHEN DL_Remise01REM_Type=0 THEN ''  
                      WHEN DL_Remise01REM_Type=1 THEN cast(cast(DL_Remise01REM_Valeur as numeric(9,2)) as varchar(10))+'%' 
                      ELSE cast(cast(DL_Remise01REM_Valeur as numeric(9,2)) as varchar(10))+'U' END DL_Remise  
                FROM F_DOCLIGNE  WHERE cbMarq ={$this->cbMarq}";
        $result = $this->db->requete($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        return $rows[0];
    }

    public function modifDocligneFacture($AR_Ref, $DL_Qte, $remise, $type_remise, $cbMarq, $cbMarqEntete, $cat_tarif, $prix, $login, $type_fac, $machine, $protNo, $entete_prev = "")
    {
        $ANDL_Qte = $this->DL_Qte;
        $AN_CMUP = $this->DL_CMUP;
        $dateTmp = DateTime::createFromFormat('Y-m-d H:i:s', $this->DO_Date);
        $dateFacture = $dateTmp->format('Ymd');
        $val_rem = $this->val_remise($remise, $type_remise, $prix);
        $docEntete = new DocEnteteClass($cbMarqEntete);
        $CT_Num = $docEntete->CT_NumPayeur;
        $DE_No = $docEntete->DE_No;
        $type_fourn = 0;
        if (strcmp($type_fac, "PreparationCommande") == 0 || strcmp($type_fac, "AchatPreparationCommande") == 0)
            $type_fourn = 1;
        if (strcmp($type_fac, "VenteRetour") == 0)
            $DL_Qte = -$DL_Qte;
        $rows = $this->getPrixClientHT($AR_Ref, $docEntete->N_CatCompta, $cat_tarif, $prix, $val_rem, $DL_Qte, $type_fourn);
        $tiers = new ComptetClass($CT_Num,"all",$this->db);
        $verifborne = $this->verifbornePrix($rows, $type_fac,$protNo,$cat_tarif,$AR_Ref);
        if ($verifborne != null)
            return $verifborne;
        if ($rows != null) {
            $montantHT = $rows->DL_MontantHT;
            $pu = ROUND($rows->DL_PrixUnitaire, 2);
            $taxe1 = $rows->taxe1;
            $taxe2 = $rows->taxe2;
            $taxe3 = $rows->taxe3;
            $TypeTauxTaxe1 = $rows->TU_TA_TTaux;
            $TypeTauxTaxe2 = $rows->TD_TA_TTaux;
            $TypeTauxTaxe3 = $rows->TT_TA_TTaux;
            $TypeTaxe1 = $rows->TU_TA_Type;
            $TypeTaxe2 = $rows->TD_TA_Type;
            $TypeTaxe3 = $rows->TT_TA_Type;
            $DL_MontantTTC = $rows->DL_MontantTTC;
            $controleClient = null;
            $PparametreLivr = new P_ParametreLivrClass(1,$this->db);
            if($PparametreLivr->PL_Reliquat==1 && $docEntete->getTypeFac()!="Devis") {
                $comptet = new ComptetClass($docEntete->DO_Tiers, "all", $this->db);
                $controleClient = $comptet->controleEncours($type_fac, $DL_MontantTTC, $docEntete->getTypeFac());
            }

            if($controleClient != null)
                return $controleClient;

            $puttc = $rows->DL_PUTTC;
            $typeHT = $rows->AC_PrixTTC;
            $article = new ArticleClass($AR_Ref);
            $AR_Design = str_replace("'", "''", $article->AR_Design);
            $AR_Ref = $article->AR_Ref;
            $AR_UniteVen = $article->AR_UniteVen;
            $AR_PrixVen = $article->AR_PrixVen;
            $pxMin = $article->Prix_Min;
            $AR_PrixAch = 0;
            $isStock = $article->isStock($DE_No);
            if ($isStock != null) {
                $AS_MontSto = $isStock[0]->AS_MontSto;
                $AS_QteSto = $isStock[0]->AS_QteSto;
            } else {
                $AS_MontSto = 0;
                $AS_QteSto = 0;
            }
            if ($type_fac == "VenteRetour" || $type_fac == "Achat" || $type_fac == "AchatPreparationCommande" || $type_fac == "PreparationCommande") {
                $AS_MontSto = $AS_MontSto - ($AN_CMUP * $ANDL_Qte);
                $AS_QteSto = $AS_QteSto - $ANDL_Qte;
            } else {
                $AS_MontSto = $AS_MontSto + ($AN_CMUP * $ANDL_Qte);
                $AS_QteSto = $AS_QteSto + $ANDL_Qte;
            }
            if (strcmp($type_fac, "PreparationCommande") != 0) {
                if ($AS_QteSto > 0)
                    $AR_PrixAch = ($AS_MontSto / $AS_QteSto);
            }

            $DL_TypePL = 0;
            if ($type_fac == "VenteRetour")
                $DL_TypePL = 1;
            if ($type_fac == "Avoir")
                $DL_TypePL = 2;
            //$this->DL_TypePL = $DL_TypePL;
            $DL_QtePL = $DL_Qte;
            $DL_QteBL = $DL_Qte;
            $DL_CMUP = round($AR_PrixAch, 2);
            if (strcmp($type_fac, "PreparationCommande") == 0 || strcmp($type_fac, "BonCommande") == 0) {
                if ($type_fac!= "BonCommande") {
                    $DL_QtePL = 0;
                    $DL_CMUP = 0;
                }
                $DL_QteBL = 0;
            }

            if (strcmp($type_fac, "PreparationCommande") == 0 || strcmp($type_fac, "AchatPreparationCommande") == 0)
                $this->db->requete($this->updateDLColis($docEntete->N_CatCompta, $cbMarq));

            $dateJour = date("Ymd");
            if ($dateFacture > $dateJour) {
                $result = $this->db->requete($this->getCollaborateurEnvoiMail("Modification de la facture"));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if ($rows != null) {
                    foreach ($rows as $row) {
                        $email = $row->CO_EMail;
                        if (preg_match('#^[\w.-]+@[\w.-]+\.[a-z]{2,6}$#i', $email)) {
                            require '../Send/class.phpmailer.php';
                            $nom = $row->CO_Prenom . " " . $row->CO_Nom;
                            $corpsMail = "Bonjour $nom,<br/><br/>
                                                La facture " . $docEntete->DO_Piece . " du " . $dateTmp->format('d-m-Y') . " a été modifiée par $login.<br/><br/>
                                                Cordialement.<br/><br/>";
                            $mail = new Mail();
                            $mail->sendMail($corpsMail."<br/><br/><br/> {$this->db->db}",$email,"Modification de la facture " . $docEntete->DO_Piece);
                        }
                    }
                }
            }

            $DL_QteBC = $DL_Qte;
            $EU_Qte = $DL_Qte;
            $this->CT_Num = $CT_Num;
            $this->DO_Piece = $docEntete->DO_Piece;
            $this->AR_Ref = $AR_Ref;
            $this->DL_Design = $AR_Design;
            $this->DL_Qte = $DL_Qte;
            $this->DL_QteBC = $DL_QteBC;
            $this->DL_QteBL = $DL_QteBL;
            $this->EU_Qte = $EU_Qte;
            $this->DL_Remise01REM_Valeur = $remise;
            $this->DL_PrixUnitaire = $pu;
            $this->DL_Taxe1 = $taxe1;
            $this->DL_Taxe2 = $taxe2;
            $this->DL_Taxe3 = $taxe3;
            if($type_fac == "BonCommande")
                $this->DL_PrixRU = 0;
            else
                $this->DL_PrixRU = round($AR_PrixAch, 2);
            //$this->EU_Enumere = $U_Intitule;
            $this->DL_PUTTC = $puttc;
            $this->DL_MontantHT = $montantHT;
            $this->DL_MontantTTC = $DL_MontantTTC;
            $this->DL_Remise01REM_Type = $type_remise;
            $this->DL_QtePL = $DL_QtePL;
            $this->DL_TTC = $typeHT;
            $this->DL_TypeTaux1 = $TypeTauxTaxe1;
            $this->DL_TypeTaux2 = $TypeTauxTaxe2;
            $this->DL_TypeTaux3 = $TypeTauxTaxe3;
            $this->DL_TypeTaxe1 = $TypeTaxe1;
            $this->DL_TypeTaxe2 = $TypeTaxe2;
            $this->DL_TypeTaxe3 = $TypeTaxe3;
            $this->DL_PieceBL = $entete_prev;
            $this->DL_CMUP = $DL_CMUP;
            $this->MACHINEPC = $machine;
            $this->userName = $protNo;
            $this->db->connexion_bdd->beginTransaction();
            try {
                $this->maj_docLigne($prix, $this->cbCreateur);

                if (strcmp($type_fac, "PreparationCommande") != 0  && strcmp($type_fac, "Devis") != 0  && $type_fac != "BonCommande" && strcmp($type_fac, "Avoir") != 0) {
                    $article->updateArtStock($DE_No, $ANDL_Qte - $DL_Qte, ($AN_CMUP * $ANDL_Qte) - ($AR_PrixAch * $DL_Qte), $protNo, "modif_ligne");
                }

                if (strcmp($type_fac, "PreparationCommande") == 0)
                    $article->updateArtStockReel($DE_No, $DL_Qte - $ANDL_Qte);

                if (strcmp($type_fac, "BonCommande") == 0)
                    $article->updateArtStockQteRes($DE_No, $DL_Qte - $ANDL_Qte);

                $this->commandeStock($DE_No, $AR_Ref, $AR_Design);
                $this->modifiePrix($AR_Ref, $AR_Design, $AR_PrixAch, $AR_PrixVen, $prix, $pxMin, $docEntete->DO_Piece, $login);
                $this->db->connexion_bdd->commit();
            }
            catch(Exception $e){
                $this->db->connexion_bdd->rollBack();
                return json_encode($e);
            }
            return json_encode($this->getLigneFactureDernierElement($cbMarq));
        }
    }


    public function modifiePrix($AR_Ref, $AR_Design, $pxAch, $pxVen, $prix, $pxMin, $DO_Piece, $user)
    {
        $textMail = "";
        $textSms = "";
        $titreMail = "";
        if ($prix < $pxAch) {
            $textMail = "Le prix de l'article $AR_Ref - $AR_Design " . $this->objetCollection->formatChiffre($prix) . " lié à la facture $DO_Piece est inférieur au prix d'achat " . $this->objetCollection->formatChiffre($pxAch) . ".<br/>
                          Le document a été saisie par $user.<br/><br/>
                                                Cordialement.<br/><br/>";
            $textSms = "Le prix de l'article $AR_Ref - $AR_Design " . $this->objetCollection->formatChiffre($prix) . " lié à la facture $DO_Piece est inférieur au prix d'achat " . $this->objetCollection->formatChiffre($pxAch) . "."
                . "Le document a été saisie par $user.";
            $titreMail = "Prix de revient inférieur au prix d'achat";
        }
        /*if($prix<$pxVen) {
            $textMail = "Le prix de l'article $AR_Ref - $AR_Design " . $this->objetCollection->formatChiffre($prix) . " lié à la facture $DO_Piece est inférieur au prix de vente " . $this->objetCollection->formatChiffre($pxVen) . ".<br/>
                          Le document a été saisie par $user.<br/><br/>
                                                Cordialement.<br/><br/>";
            $titreMail="Prix de revient inférieur au prix de vente";
        }*/
        if ($prix < $pxMin) {
            $textMail = "Le prix de l'article $AR_Ref - $AR_Design " . $this->objetCollection->formatChiffre($prix) . " lié à la facture $DO_Piece est inférieur au prix minimum " . $this->objetCollection->formatChiffre($pxMin) . ".<br/>
                          Le document a été saisie par $user.<br/><br/>
                                                Cordialement.<br/><br/>";
            $textSms = "Le prix de l'article $AR_Ref - $AR_Design " . $this->objetCollection->formatChiffre($prix) . " lié à la facture $DO_Piece est inférieur au prix minimum " . $this->objetCollection->formatChiffre($pxAch) . "."
                . "Le document a été saisie par $user.";
            $titreMail = "Prix de revient inférieur au prix minimum";
        }

        if ($textMail != "") {
            $result = $this->db->requete($this->getCollaborateurEnvoiMail("Prix modifié"));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if ($rows != null) {
                foreach ($rows as $row) {
                    $email = $row->CO_EMail;
                    if (preg_match('#^[\w.-]+@[\w.-]+\.[a-z]{2,6}$#i', $email)) {
                        $mail = new Mail();
                        $mail->sendMail($textMail."<br/><br/><br/> {$this->db->db}", $email,  $titreMail);
                    }
                }
            }
            $result = $this->db->requete($this->objetCollection->getCollaborateurEnvoiSMS("Prix modifié"));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if ($rows != null) {
                foreach ($rows as $row) {
                    $telephone = $row->CO_Telephone;
                    if (($telephone != "" || $telephone != null)) {
                        $contactD = new ContatDClass(1,$this->db);
                        $contactD->sendSms($telephone, $textSms);
                    }
                }
            }
        }
    }


    public function getCollaborateurEnvoiMail($intitule, $depot = 0)
    {
        return "SELECT CO_No,CO_Nom,CO_Prenom,CO_EMail,CO_Telephone,PROT_User
                FROM [Z_LiaisonEnvoiMailUser] A
                INNER JOIN F_PROTECTIONCIAL B ON A.PROT_No=B.PROT_No
                INNER JOIN F_COLLABORATEUR C ON C.CO_Nom=B.PROT_User
                INNER JOIN [dbo].[Z_TypeEnvoiMail] D ON D.TE_No=A.TE_No
                WHERE ((TE_Intitule ='$intitule' AND TE_Intitule <>'Prix modifié') OR ('$intitule' ='Prix modifié' AND EXISTS (SELECT DE_No 
																					FROM Z_DEPOTUSER B 
																					WHERE A.Prot_No=B.Prot_No AND DE_No=$depot))) 
                GROUP BY CO_No,CO_Nom,CO_Prenom,CO_EMail,CO_Telephone,PROT_User";
    }

    public function commandeStock($DE_No, $AR_Ref, $AR_Design)
    {
        $AS_QteMini = 0;
        $AS_QteMaxi = 0;
        $this->alerteCumulStock();
        $article = new ArticleClass($AR_Ref,$this->db);
        $rows = $article->isStock($DE_No);
        if ($rows != null) {
            $AS_QteSto = $rows[0]->AS_QteSto;
            $AS_QteMini = $rows[0]->AS_QteMini;
            $AS_QteMaxi = $rows[0]->AS_QteMaxi;
            $qteCommande = $AS_QteMaxi - $AS_QteSto;
            if ($AS_QteMini != 0 && $AS_QteMaxi != 0) {
                if ($AS_QteSto <= $AS_QteMini) {
                    $result = $this->db->requete($this->getCollaborateurEnvoiMail("Stock épuisé", $DE_No));
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    if ($rows != null) {
                        foreach ($rows as $row) {
                            $email = $row->CO_EMail;
                            if (preg_match('#^[\w.-]+@[\w.-]+\.[a-z]{2,6}$#i', $email)) {
                                //
                                $nom = $row->CO_Prenom . " " . $row->CO_Nom;
                                $corpsMail = "Le stock de l'article $AR_Ref - $AR_Design est en dessous de la limite (" . $this->objetCollection->formatChiffre($AS_QteSto) . ")
                                                              La commande de " . $this->objetCollection->formatChiffre($qteCommande) . " pièces doit être passé.<br/><br/>
                                                Cordialement.<br/><br/>";
                                $mail = new Mail();
                                $mail->sendMail($corpsMail."<br/><br/><br/> {$this->db->db}", $email,  "Stock de l'article $AR_Ref");
                            }
                        }
                    }

                    $result = $this->db->requete($this->objetCollection->getCollaborateurEnvoiSMS("Stock épuisé"));
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    if ($rows != null) {
                        foreach ($rows as $row) {
                            $telephone = $row->CO_Telephone;
                            if (($telephone != "" || $telephone != null)) {
                                $contactD = new ContatDClass(1,$this->db);
                                $textSms = "Le stock de l'article $AR_Ref - $AR_Design est en dessous de la limite (" . $this->objetCollection->formatChiffre($AS_QteSto) . ")
                                                              . La commande de " . $this->objetCollection->formatChiffre($qteCommande) . " pièces doit être passé.";
                                $contactD->sendSms($telephone, $textSms);
                            }
                        }
                    }
                }
            }
        }
    }

    public function getZLigneConfirmation($cbMarq){
        $query = "SELECT *
                    FROM Z_LIGNE_CONFIRMATION
                    WHERE cbMarq=$cbMarq";
        $result = $this->db->query($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        return $rows[0];
    }

    public function majQteZLigneConfirmation($cbMarq,$qte){
        $query = "UPDATE Z_LIGNE_CONFIRMATION SET DL_Qte=$qte 
                    WHERE cbMarq=$cbMarq";
        $this->db->query($query);
    }

    public function alerteCumulStock(){
        $result = $this->db->requete($this->objetCollection->cumulStock());
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $tableHtml="<table style='border-collapse:collapse;'>
                        <thead> <th style='border:1px solid black;'>Dépot</th>
                                <th style='border:1px solid black;'>Article</th>
                                <th style='border:1px solid black;'>Stock</th>
                                <th style='border:1px solid black;'>Qté min</th>
                                <th style='border:1px solid black;'>Qté à commander</th>
                        </thead><tbody>";
        if ($rows != null) {
            $alerte = $rows[0]->Alerte;
            if($alerte<0){
                $result = $this->db->requete($this->objetCollection->cumulStockDetail());
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if($rows != null) {
                    foreach ($rows as $row) {
                        $tableHtml = "$tableHtml 
                                        <tr>
                                            <td style='text-align:center;border:1px solid black;'>{$row->DE_Intitule}</td>
                                            <td style='text-align:center;border:1px solid black;'>{$row->AR_Design}</td>
                                            <td style='text-align:center;border:1px solid black;'>{$this->objetCollection->formatChiffre($row->AS_QteSto)}</td>
                                            <td style='text-align:center;border:1px solid black;'>{$this->objetCollection->formatChiffre($row->AS_QteMini)}</td>
                                            <td style='text-align:center;border:1px solid black;'>{$this->objetCollection->formatChiffre($row->QteACommander)}</td>
                                        </tr>";
                    }
                    $tableHtml = $tableHtml."</tbody>";
                }
                $tableHtml = $tableHtml."</table>";
                $result = $this->db->requete($this->getCollaborateurEnvoiMail("Stock cumul"));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if ($rows != null) {
                    foreach ($rows as $row) {
                        $email = $row->CO_EMail;
                        if (preg_match('#^[\w.-]+@[\w.-]+\.[a-z]{2,6}$#i', $email)) {
                            $nom = $row->CO_Prenom . " " . $row->CO_Nom;
                            $corpsMail = "Le stock de l'ensemble des articles des dépôts est en dessous de la limite.
                                            Retrouvez ci dessous la liste des articles dont le stock est en dessous du stock minimum<br/><br/>
                                                              $tableHtml <br/><br/>
                                                              
                                                Cordialement.<br/><br/>";
                            $mail = new Mail();
                            $mail->sendMail($corpsMail."<br/><br/><br/> {$this->db->db}", $email,  "Stock Cumulé");
                        }
                    }
                }
            }
        }
    }

    public function  getPrixClientHT($ar_ref, $catcompta, $cattarif, $prix,$rem,$qte,$fournisseur) {
        return $this->getApiJson("/getPrixClientHT&arRef={$this->formatString($ar_ref)}&catCompta=$catcompta&catTarif=$cattarif&prix=$prix&rem=$rem&qte=$qte&fournisseur=$fournisseur");
    }

    public function  getPrixClientHTQuery()
    {
        return "  
            declare @rem as float,@fcp_champ as int,@ac_categorie as int,@qte as float
            ,@fournisseur as int,@flagpxMinMax as int
            ,@montantHT as float
            ,@pu float
            ,@taxe1 float
            ,@taxe2 float
            ,@taxe3 float
            ,@TypeTaxe1 float
            ,@TypeTaxe2 float
            ,@TypeTaxe3 float
            ,@TypeTauxTaxe1 float
            ,@TypeTauxTaxe2 float
            ,@TypeTauxTaxe3 float
            ,@DL_MontantTTC float
            ,@DL_PUTTC float
            ,@AC_PrixTTC int
            
            set @rem = @valRemise;
            set @fcp_champ = @nCatCompta;
            set @ac_categorie=@catTarif;
            set @qte = @dlQte;
            set @fournisseur = @typeFourn;
            SELECT	@flagpxMinMax=P_ReportPrixRev
            FROM	P_PARAMETRECIAL;
            
            WITH _FARTCOMPTA_ AS (
                SELECT	cbAR_Ref
                        ,ACP_ComptaCPT_Taxe1
                        ,ACP_ComptaCPT_Taxe2
                        ,ACP_ComptaCPT_Taxe3
                FROM	F_ARTCOMPTA 
                WHERE	ACP_Type=@fournisseur 
                AND		ACP_Champ=@fcp_champ 
            )
            ,_FFAMCOMPTA_ AS (
                SELECT	cbFA_CodeFamille
                        ,FCP_ComptaCPT_Taxe1
                        ,FCP_ComptaCPT_Taxe2
                        ,FCP_ComptaCPT_Taxe3
                        ,FCP_Champ
                FROM	F_FAMCOMPTA 
                WHERE	FCP_Type=@fournisseur 
                AND		FCP_Champ=@fcp_champ 
            )
            ,_FARTCLIENT_ AS (
                SELECT	cbAR_Ref
                        ,AC_Coef
                        ,AC_PrixVen
                        ,AC_PrixTTC 
                FROM	F_ARTCLIENT 
                WHERE	AC_Categorie=(SELECT ISNULL((	SELECT	AC_Categorie 
                                                        FROM	F_ARTCLIENT 
                                                        WHERE	cbAR_REF = @ar_ref 
                                                        AND		AC_Categorie=@ac_categorie),1))
            )
            ,_QUERY_ AS (
            
            SELECT	
                ISNULL(TU.TA_Intitule,'') as IntituleT1,ISNULL(TD.TA_Intitule,'') as IntituleT2,ISNULL(TT.TA_Intitule,'') as IntituleT3 
                ,ISNULL(a.FA_CodeFamille,'') FA_CodeFamille, ISNULL(a.AR_Ref,'')AR_Ref, ISNULL(AR_PrixAch,0)AR_PrixAch, ISNULL(AR_Design,'')AR_Design 
                ,ISNULL(AR_PrixVen,0)AR_PrixVen,AC_PrixVen
                ,CASE WHEN @flagpxMinMax = 0 THEN ISNULL(Prix_Min,0) ELSE ISNULL(AC_Coef,0) END Prix_Min
                ,CASE WHEN @flagpxMinMax = 0 THEN ISNULL(Prix_Max,0) ELSE ISNULL(AC_PrixVen,0) END Prix_Max
                ,ISNULL(TU.TA_TTaux,0) AS TU_TA_TTaux
                ,ISNULL(TD.TA_TTaux,0) AS TD_TA_TTaux,ISNULL(TT.TA_TTaux,0) AS TT_TA_TTaux
                ,ISNULL(TU.TA_Type,0) AS TU_TA_Type
                ,ISNULL(TD.TA_Type,0) AS TD_TA_Type,ISNULL(TT.TA_Type,0) AS TT_TA_Type
                ,ISNULL(CASE WHEN AC_PrixVen<>0 THEN AC_PrixVen ELSE AR_PrixVen END,0) AS Prix
                ,ISNULL(CASE WHEN AC_PrixTTC IS NULL THEN AR_PrixTTC ELSE AC_PrixTTC END,0) AC_PrixTTC, ISNULL(AR_PrixTTC,0)AR_PrixTTC
                ,ISNULL((CASE WHEN @fournisseur=1 THEN CASE WHEN ISNULL(TU.TA_Sens,0)=0 THEN 1 ELSE -1 END ELSE CASE WHEN @fournisseur=0 THEN CASE WHEN ISNULL(TU.TA_Sens,0)=0 THEN -1 ELSE 1 END END END)*(CASE WHEN TU.TA_TTaux=0 THEN ISNULL(TU.TA_Taux,0) ELSE CASE WHEN TU.TA_TTaux IN (1,2) THEN ISNULL(TU.TA_Taux,0) ELSE 0 END END),0) as taxe1
                ,ISNULL((CASE WHEN @fournisseur=1 THEN CASE WHEN ISNULL(TD.TA_Sens,0)=0 THEN 1 ELSE -1 END ELSE CASE WHEN @fournisseur=0 THEN CASE WHEN ISNULL(TD.TA_Sens,0)=0 THEN -1 ELSE 1 END END END)*(CASE WHEN TD.TA_TTaux=0 THEN ISNULL(TD.TA_Taux,0) ELSE CASE WHEN TD.TA_TTaux IN (1,2) THEN ISNULL(TD.TA_Taux,0) ELSE 0 END END),0) as taxe2
                ,ISNULL((CASE WHEN @fournisseur=1 THEN CASE WHEN ISNULL(TT.TA_Sens,0)=0 THEN 1 ELSE -1 END ELSE CASE WHEN @fournisseur=0 THEN CASE WHEN ISNULL(TT.TA_Sens,0)=0 THEN -1 ELSE 1 END END END)*(CASE WHEN TT.TA_TTaux=0 THEN ISNULL(TT.TA_Taux,0) ELSE CASE WHEN TT.TA_TTaux IN (1,2) THEN ISNULL(TT.TA_Taux,0) ELSE 0 END END),0) as taxe3
                ,ISNULL(FCP_Champ,0)FCP_Champ  
            FROM F_ARTICLE A 
            LEFT JOIN _FARTCLIENT_ AR 
                ON AR.cbAR_Ref = A.cbAR_Ref
            LEFT JOIN _FFAMCOMPTA_ FF 
                ON FF.cbFA_CodeFamille = A.cbFA_CodeFamille 
            LEFT JOIN _FARTCOMPTA_ FA 
                ON FA.cbAR_Ref = A.cbAR_Ref
            LEFT JOIN F_TAXE TU 
                ON	TU.cbTA_Code = (CASE WHEN ISNULL(FCP_ComptaCPT_Taxe1,'0') <> ISNULL(ACP_ComptaCPT_Taxe1,'0') 
                AND ACP_ComptaCPT_Taxe1 IS NOT NULL THEN ACP_ComptaCPT_Taxe1 ELSE FCP_ComptaCPT_Taxe1 END)
            LEFT JOIN F_TAXE TD 
                ON	TD.cbTA_Code = (CASE WHEN ISNULL(FCP_ComptaCPT_Taxe2,'0') <> ISNULL(ACP_ComptaCPT_Taxe2,'0') 
                AND ACP_ComptaCPT_Taxe2 IS NOT NULL THEN ACP_ComptaCPT_Taxe2 ELSE FCP_ComptaCPT_Taxe2 END) 
            LEFT JOIN F_TAXE TT 
                ON	TT.cbTA_Code = (CASE WHEN ISNULL(FCP_ComptaCPT_Taxe3,'0') <> ISNULL(ACP_ComptaCPT_Taxe3,'0') 
                AND ACP_ComptaCPT_Taxe3 IS NOT NULL THEN ACP_ComptaCPT_Taxe3 ELSE FCP_ComptaCPT_Taxe3 END) 
            WHERE  A.cbAR_REF = @ar_ref
            )
            ,_CALCUL_PRIX_ AS (
                
            SELECT *,
            ROUND(CASE WHEN @fournisseur = 0 AND (AC_PrixTTC = 1  OR AR_PrixTTC = 1) THEN ROUND(((@prix-@rem)* @qte - (CASE WHEN TU_TA_TTaux=1 THEN taxe1 ELSE 0 END+CASE WHEN TD_TA_TTaux=1 THEN taxe2 ELSE 0 END+CASE WHEN TT_TA_TTaux=1 THEN taxe3 ELSE 0 END)
            -(CASE WHEN TU_TA_TTaux=2 THEN taxe1*@qte ELSE 0 END+CASE WHEN TD_TA_TTaux=2 THEN taxe2*@qte ELSE 0 END+CASE WHEN TT_TA_TTaux=2 THEN taxe3*@qte ELSE 0 END)) /
            (1 +CASE WHEN TU_TA_TTaux=0 THEN taxe1/100 ELSE 0 END+CASE WHEN TD_TA_TTaux=0 THEN taxe2/100 ELSE 0 END+CASE WHEN TT_TA_TTaux=0 THEN taxe3/100 ELSE 0 END)
            ,2) ELSE (@prix-@rem)* @qte END,2) DL_MontantHT,
            ROUND(CASE WHEN @fournisseur = 0 AND (AC_PrixTTC = 1  OR AR_PrixTTC = 1) THEN CASE WHEN @qte=0 THEN 0 ELSE ROUND(((@prix)*@qte - (CASE WHEN TU_TA_TTaux=1 THEN taxe1 ELSE 0 END+CASE WHEN TD_TA_TTaux=1 THEN taxe2 ELSE 0 END+CASE WHEN TT_TA_TTaux=1 THEN taxe3 ELSE 0 END)
            -(CASE WHEN TU_TA_TTaux=2 THEN taxe1*@qte ELSE 0 END+CASE WHEN TD_TA_TTaux=2 THEN taxe2*@qte ELSE 0 END+CASE WHEN TT_TA_TTaux=2 THEN taxe3*@qte ELSE 0 END)) /
            (1 +CASE WHEN TU_TA_TTaux=0 THEN taxe1/100 ELSE 0 END+CASE WHEN TD_TA_TTaux=0 THEN taxe2/100 ELSE 0 END+CASE WHEN TT_TA_TTaux=0 THEN taxe3/100 ELSE 0 END)
            ,2)/@qte END ELSE @prix END,2)  DL_PrixUnitaire,
            ROUND((CASE WHEN @fournisseur = 0 AND (AC_PrixTTC = 1  OR AR_PrixTTC = 1) THEN (@prix-@rem)* @qte ELSE ((@prix-@rem) +
            (CASE WHEN TU_TA_TTaux=0 THEN ((@prix-@rem)*taxe1/100) WHEN TU_TA_TTaux=2 THEN taxe1 ELSE 0 END)+
            (CASE WHEN TD_TA_TTaux=0 THEN ((@prix-@rem)*taxe2/100) WHEN TD_TA_TTaux=2 THEN taxe2 ELSE 0 END)+
            (CASE WHEN TT_TA_TTaux=0 THEN ((@prix-@rem)*taxe3/100) WHEN TT_TA_TTaux=2 THEN taxe3 ELSE 0 END))* @qte +
            CASE WHEN TU_TA_TTaux=1 THEN taxe1 ELSE 0 END+CASE WHEN TD_TA_TTaux=1 THEN taxe2 ELSE 0 END+CASE WHEN TT_TA_TTaux=1 THEN taxe3 ELSE 0 END END),2)  DL_MontantTTC,
            ROUND((CASE WHEN @fournisseur = 0 AND (AC_PrixTTC = 1  OR AR_PrixTTC = 1)  THEN @prix ELSE (@prix +
            (CASE WHEN TU_TA_TTaux=0 THEN (@prix*taxe1/100) WHEN TU_TA_TTaux=2 THEN taxe1 ELSE 0 END)+
            (CASE WHEN TD_TA_TTaux=0 THEN (@prix*taxe2/100) WHEN TD_TA_TTaux=2 THEN taxe2 ELSE 0 END)+
            (CASE WHEN TT_TA_TTaux=0 THEN (@prix*taxe3/100 ) WHEN TT_TA_TTaux=2 THEN taxe3 ELSE 0 END))+
            CASE WHEN TU_TA_TTaux=1 THEN taxe1 ELSE 0 END+CASE WHEN TD_TA_TTaux=1 THEN taxe2 ELSE 0 END+CASE WHEN TT_TA_TTaux=1 THEN taxe3 ELSE 0 END END),2)   DL_PUTTC 
            FROM _QUERY_ 
            )
            ,_CALCUL_TAXE_ AS (
            
            SELECT *
                , CASE WHEN TU_TA_TTaux=0 THEN DL_MontantHT*(taxe1/100) 
                    WHEN TU_TA_TTaux=1 THEN taxe1*@qte 
                    ELSE taxe1 END MTT_Taxe1
                , CASE WHEN TD_TA_TTaux=0 THEN DL_MontantHT*(taxe2/100) 
                    WHEN TD_TA_TTaux=1 THEN taxe2 
                    ELSE taxe2*@qte END MTT_Taxe2
                , CASE WHEN TT_TA_TTaux=0 THEN DL_MontantHT*(taxe3/100) 
                    WHEN TT_TA_TTaux=1 THEN taxe3 
                    ELSE taxe3*@qte END MTT_Taxe3
            FROM _CALCUL_PRIX_
            )
            
            SELECT  @montantHT = DL_MontantHT
                    ,@pu = DL_PrixUnitaire
                    ,@taxe1 = taxe1
                    ,@taxe2 = taxe2
                    ,@taxe3 = taxe3
                    ,@TypeTaxe1 = TU_TA_Type
                    ,@TypeTaxe2 = TD_TA_Type
                    ,@TypeTaxe3 = TT_TA_Type
                    ,@TypeTauxTaxe1 = TU_TA_TTaux
                    ,@TypeTauxTaxe2 = TD_TA_TTaux
                    ,@TypeTauxTaxe3 = TT_TA_TTaux
                    ,@DL_MontantTTC = DL_MontantTTC
                    ,@dlPUNetTTC = DL_PUTTC-@rem 
                    ,@prixMax = Prix_Max
                    ,@prixMin = Prix_Min
                    ,@DL_PUTTC = DL_PUTTC
                    ,@AC_PrixTTC = AC_PrixTTC
            FROM    _CALCUL_TAXE_
";
    }

    public function supprLigneFacture($cbMarq,$cbMarqSec,$typeFacture,$protNo){
        $this->getApiExecute("/supprLigneFacture&cbMarq=$cbMarq&cbMarqSec=$cbMarqSec&typeFacture=$typeFacture&protNo=$protNo");
    }

    public function __toString() {
        return "";
    }


}