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
        $this->db = new DB();
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

    public function modifDocligneFactureMagasin($DL_Qte, $prix, $type_fac,$protNo,$cbMarqEntete)
    {
        return $this->ajout_ligneFacturation($DL_Qte," ",$cbMarqEntete,$type_fac,0,$prix," "," ","modif_ligne",$protNo);
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

    public function delete($protNo=0){
        parent::delete();
        $this->userName = $protNo;
        $this->logMvt("suppr_ligne", $this->DE_No, $this->AR_Ref, $this->DL_Qte, $this->DL_MontantTTC, $this->DL_Remise01REM_Valeur, $this->DL_MontantTTC,$this->cbCreateur,$this->cbMarq,$this->DO_Date);
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

    public function verifSupprAjout()
    {
        return $this->getApiJson("/verifSupprAjout&cbMarq={$this->cbMarq}");
    }

    public function ajout_ligneFacturation($qteG, $ARRefG, $cbMarqEntete, $typeFacG, $cattarifG, $prixG, $remiseG, $machinepcG, $acte,$protNo,$depotLigne=0)
    {
        return $this->getApiString("/ajoutLigne&cbMarq={$this->cbMarq}&protNo=$protNo&dlQte={$this->formatAmount($qteG)}&arRef={$this->formatString($ARRefG)}&cbMarqEntete=$cbMarqEntete&typeFacture=$typeFacG&catTarif=$cattarifG&dlPrix={$this->formatAmount($prixG)}&dlRemise={$this->formatString($remiseG)}&machineName={$this->formatString($machinepcG)}&acte=$acte&entete_prev=&depotLigne=$depotLigne");
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

    public function  getPrixClientHT($ar_ref, $catcompta, $cattarif, $prix,$rem,$qte,$fournisseur) {
        return $this->getApiJson("/getPrixClientHT&arRef={$this->formatString($ar_ref)}&catCompta=$catcompta&catTarif=$cattarif&prix=$prix&rem=$rem&qte=$qte&fournisseur=$fournisseur");
    }

    public function supprLigneFacture($cbMarq,$cbMarqSec,$typeFacture,$protNo){
        return $this->getApiJson("/supprLigneFacture&cbMarq=$cbMarq&cbMarqSec=$cbMarqSec&typeFacture=$typeFacture&protNo=$protNo");
    }

    public function __toString() {
        return "";
    }


}