<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class DocEnteteClass Extends Objet{
    //put your code here
    public $db,$DO_Domaine,$DO_Type,$DO_Piece,$DO_Date,$DO_Ref,$DO_Tiers
    ,$CO_No,$DO_Period,$DO_Devise,$DO_Cours,$DE_No,$LI_No,$CT_NumPayeur,$DO_Expedit
    ,$DO_NbFacture,$DO_BLFact,$DO_TxEscompte,$DO_Reliquat
    ,$DO_Imprim,$CA_Num,$DO_Coord01,$DO_Coord02,$DO_Coord03
    ,$DO_Coord04,$DO_Souche,$DO_DateLivr,$DO_Condition
    ,$DO_Tarif,$DO_Colisage,$DO_TypeColis,$DO_Transaction
    ,$DO_Langue,$DO_Ecart,$DO_Regime,$N_CatCompta
    ,$DO_Ventile,$AB_No,$DO_DebutAbo,$DO_FinAbo
    ,$DO_DebutPeriod,$DO_FinPeriod,$CG_Num,$DO_Statut
    ,$DO_Heure,$CA_No,$CO_NoCaissier,$DO_Transfere
    ,$DO_Cloture,$DO_NoWeb,$DO_Attente,$DO_Provenance
    ,$CA_NumIFRS,$MR_No,$DO_TypeFrais,$DO_ValFrais,$DO_TypeLigneFrais,$DO_TypeFranco
    ,$DO_ValFranco,$DO_TypeLigneFranco,$DO_Taxe1,$DO_TypeTaux1
    ,$DO_TypeTaxe1,$DO_Taxe2,$DO_TypeTaux2,$DO_TypeTaxe2
    ,$DO_Taxe3,$DO_TypeTaux3,$DO_TypeTaxe3,$DO_MajCpta
    ,$DO_Motif,$CT_NumCentrale,$DO_Contact ,$DO_FactureElec,$DO_TypeTransac
    ,$cbMarq,$cbModification,$cbFlag,$longitude,$latitude,$VEHICULE,$CHAUFFEUR,
    $ttc,$avance,$resteAPayer, $statut,$typeFacture,$cbProt, $cbCreateur,
        //info supp
        $DO_Modif,
        $DO_DateSage,
        $CT_Intitule,$DE_Intitule,$DE_Intitule_dest,$type_fac,$doccurent_type;

    public $table = 'F_DOCENTETE';
    public $lien = 'fdocentete';

    function __construct($id,$db=null)
    {
        $this->objetCollection = new ObjetCollector();
        $this->cbMarq = $id;
        $this->avance = 0;
        $this->ttc = 0;
        $this->resteAPayer = 0;
        $this->statut="crédit";
        ini_set("allow_url_fopen", 1);
        $this->data = $this->getApiJson("/document&cbMarq=$id");
        $this->DO_Modif=0;
        if($id!=0)
        if (sizeof($this->data) > 0) {
            $this->DO_Domaine = $this->data[0]->DO_Domaine;
            $this->DO_Type = $this->data[0]->DO_Type;
            $this->DO_Piece = $this->data[0]->DO_Piece;
            $this->DO_Date = $this->data[0]->DO_Date;
            $this->DO_DateSage = $this->formatDateSageSimple($this->data[0]->DO_Date);
            $this->DO_Ref = $this->data[0]->DO_Ref;
            $this->DO_Tiers = $this->data[0]->DO_Tiers;
            $this->CO_No = $this->data[0]->CO_No;
            $this->DO_Period = $this->data[0]->DO_Period;
            $this->DO_Devise = $this->data[0]->DO_Devise;
            $this->DO_Cours = $this->data[0]->DO_Cours;
            $this->DE_No = $this->data[0]->DE_No;
            $this->LI_No = $this->data[0]->LI_No;
            $this->CT_NumPayeur = $this->data[0]->CT_NumPayeur;
            $this->DO_Expedit = $this->data[0]->DO_Expedit;
            $this->DO_NbFacture = $this->data[0]->DO_NbFacture;
            $this->DO_BLFact = $this->data[0]->DO_BLFact;
            $this->DO_TxEscompte = $this->data[0]->DO_TxEscompte;
            $this->DO_Reliquat = $this->data[0]->DO_Reliquat;
            $this->DO_Imprim = $this->data[0]->DO_Imprim;
            $this->CA_Num = $this->data[0]->CA_Num;
            $this->DO_Coord01 = $this->data[0]->DO_Coord01;
            $this->DO_Coord02 = $this->data[0]->DO_Coord02;
            $this->DO_Coord03 = $this->data[0]->DO_Coord03;
            $this->DO_Coord04 = $this->data[0]->DO_Coord04;
            $this->DO_Souche = $this->data[0]->DO_Souche;
            $this->DO_DateLivr = $this->data[0]->DO_DateLivr;
            $this->DO_Condition = $this->data[0]->DO_Condition;
            $this->DO_Tarif = $this->data[0]->DO_Tarif;
            $this->DO_Colisage = $this->data[0]->DO_Colisage;
            $this->DO_TypeColis = $this->data[0]->DO_TypeColis;
            $this->DO_Transaction = $this->data[0]->DO_Transaction;
            $this->DO_Langue = $this->data[0]->DO_Langue;
            $this->DO_Ecart = $this->data[0]->DO_Ecart;
            $this->DO_Regime = $this->data[0]->DO_Regime;
            $this->N_CatCompta = $this->data[0]->N_CatCompta == "" ? 0 : $this->data[0]->N_CatCompta;
            $this->DO_Ventile = $this->data[0]->DO_Ventile;
            $this->AB_No = $this->data[0]->AB_No;
            $this->DO_DebutAbo = $this->data[0]->DO_DebutAbo;
            $this->DO_FinAbo = $this->data[0]->DO_FinAbo;
            $this->DO_DebutPeriod = $this->data[0]->DO_DebutPeriod;
            $this->DO_FinPeriod = $this->data[0]->DO_FinPeriod;
            $this->CG_Num = $this->data[0]->CG_Num;
            $this->DO_Statut = $this->data[0]->DO_Statut;
            $this->DO_Heure = $this->data[0]->DO_Heure;
            $this->CA_No = $this->data[0]->CA_No;
            $this->CO_NoCaissier = $this->data[0]->CO_NoCaissier;
            $this->DO_Transfere = $this->data[0]->DO_Transfere;
            $this->DO_Transfere = $this->data[0]->DO_Transfere;
            $this->DO_Cloture = $this->data[0]->DO_Cloture;
            $this->DO_NoWeb = $this->data[0]->DO_NoWeb;
            $this->DO_Attente = $this->data[0]->DO_Attente;
            $this->DO_Provenance = $this->data[0]->DO_Provenance;
            $this->CA_NumIFRS = $this->data[0]->CA_NumIFRS;
            $this->MR_No = $this->data[0]->MR_No;
            $this->DO_TypeFrais = $this->data[0]->DO_TypeFrais;
            $this->DO_ValFrais = $this->data[0]->DO_ValFrais;
            $this->DO_TypeLigneFrais = $this->data[0]->DO_TypeLigneFrais;
            $this->DO_TypeFranco = $this->data[0]->DO_TypeFranco;
            $this->DO_ValFranco = $this->data[0]->DO_ValFranco;
            $this->DO_TypeLigneFranco = $this->data[0]->DO_TypeLigneFranco;
            $this->DO_Taxe1 = $this->data[0]->DO_Taxe1;
            $this->DO_Taxe2 = $this->data[0]->DO_Taxe2;
            $this->DO_Taxe3 = $this->data[0]->DO_Taxe3;
            $this->DO_TypeTaux1 = $this->data[0]->DO_TypeTaux1;
            $this->DO_TypeTaux2 = $this->data[0]->DO_TypeTaux2;
            $this->DO_TypeTaux3 = $this->data[0]->DO_TypeTaux3;
            $this->DO_TypeTaxe1 = $this->data[0]->DO_TypeTaxe1;
            $this->DO_TypeTaxe2 = $this->data[0]->DO_TypeTaxe2;
            $this->DO_TypeTaxe3 = $this->data[0]->DO_TypeTaxe3;
            $this->DO_MajCpta = $this->data[0]->DO_MajCpta;
            $this->DO_Motif = $this->data[0]->DO_Motif;
            $this->CT_NumCentrale = $this->data[0]->CT_NumCentrale;
            $this->DO_Contact = $this->data[0]->DO_Contact;
            $this->DO_FactureElec = $this->data[0]->DO_FactureElec;
            $this->DO_TypeTransac = $this->data[0]->DO_TypeTransac;
            $this->cbMarq = $this->data[0]->cbMarq;
            $this->cbModification = $this->data[0]->cbModification;
            $this->longitude = $this->data[0]->longitude;
            $this->latitude = $this->data[0]->latitude;
            $this->VEHICULE = $this->data[0]->VEHICULE;
            $this->CHAUFFEUR = $this->data[0]->CHAUFFEUR;
            $this->cbCreateur = $this->data[0]->cbCreateur;
            $this->cbProt = $this->data[0]->cbProt;
            $this->setDO_Modif();
            $this->avance = $this->AvanceDoPiece();
            $this->ttc = $this->montantRegle();
            $this->resteAPayer = $this->ttc - $this->avance;
            if (sizeof($this->listeLigneFacture(0)) == 0)
                $this->statut = "crédit";
            else {
                if (($this->DO_Domaine == 0 || $this->DO_Domaine == 1) && $this->dr_regle() == 1 && $this->resteAPayer == 0) {
                    $this->statut = "comptant";
                }
            }
        }

    }

    public function setDO_Modif(){
        $this->DO_Modif=$this->getApiString("/setDoModif&cbMarq={$this->cbMarq}");
    }

    public function removeFacRglt($rgNo){
        $this->getApiExecute("/removeFacRglt&cbMarqEntete={$this->cbMarq}&rgNo=$rgNo");
    }
    public function maj_docEntete(){
        parent::maj("DO_Domaine" ,$this->DO_Domaine);
        parent::maj("DO_Type" ,$this->DO_Type);
        parent::maj("DO_Piece" ,$this->DO_Piece);
        parent::maj("DO_Date",$this->DO_Date);
        parent::maj("DO_Ref" ,$this->DO_Ref );
        parent::maj("DO_Tiers" ,$this->DO_Tiers );
        parent::maj("CO_No" ,$this->CO_No);
        parent::maj("DO_Period" ,$this->DO_Period);
        parent::maj("DO_Devise" ,$this->DO_Devise);
        if($this->DO_Cours!="")
            parent::maj("DO_Cours" ,$this->DO_Cours);
        parent::maj("DE_No" ,$this->DE_No);
        parent::maj("LI_No" ,$this->LI_No);
        if($this->CT_NumPayeur!="")
            parent::maj("CT_NumPayeur",$this->CT_NumPayeur);
        parent::maj("DO_Expedit" ,$this->DO_Expedit);
        parent::maj("DO_NbFacture" ,$this->DO_NbFacture);
        parent::maj("DO_BLFact" ,$this->DO_BLFact);
        parent::maj("DO_TxEscompte" ,$this->DO_TxEscompte);
        parent::maj("DO_Reliquat" ,$this->DO_Reliquat);
        parent::maj("DO_Imprim" ,$this->DO_Imprim);
        parent::maj("CA_Num" ,$this->CA_Num);
        parent::maj("DO_Coord01" ,$this->DO_Coord01);
        parent::maj("DO_Coord02" ,$this->DO_Coord02);
        parent::maj("DO_Coord03" ,$this->DO_Coord03);
        parent::maj("DO_Coord04" ,$this->DO_Coord04);
        parent::maj("DO_Souche" ,$this->DO_Souche);
        parent::maj("DO_DateLivr" ,$this->DO_DateLivr);
        parent::maj("DO_Condition" ,$this->DO_Condition);
        parent::maj("DO_Tarif" ,$this->DO_Tarif);
        parent::maj("DO_Colisage" ,$this->DO_Colisage);
        parent::maj("DO_TypeColis" ,$this->DO_TypeColis);
        parent::maj("DO_Transaction" ,$this->DO_Transaction);
        parent::maj("DO_Langue" ,$this->DO_Langue);
        parent::maj("DO_Ecart" ,$this->DO_Ecart);
        parent::maj("DO_Regime" ,$this->DO_Regime);
        parent::maj("N_CatCompta" ,$this->N_CatCompta);
        parent::maj("DO_Ventile" ,$this->DO_Ventile);
        parent::maj("AB_No" ,$this->AB_No);
        parent::maj("DO_DebutAbo" ,$this->DO_DebutAbo);
        parent::maj("DO_FinAbo" ,$this->DO_FinAbo);
        parent::maj("DO_DebutPeriod" ,$this->DO_DebutPeriod);
        parent::maj("DO_FinPeriod" ,$this->DO_FinPeriod);
        parent::maj("CG_Num" ,$this->CG_Num);
        parent::maj("DO_Statut" ,$this->DO_Statut);
        parent::maj("DO_Heure" ,$this->DO_Heure);
        parent::maj("CA_No" ,$this->CA_No);
        parent::maj("CO_NoCaissier" ,$this->CO_NoCaissier);
        parent::maj("DO_Transfere" ,$this->DO_Transfere);
        parent::maj("DO_Transfere" ,$this->DO_Transfere);
        parent::maj("DO_Cloture" ,$this->DO_Cloture);
        parent::maj("DO_NoWeb" ,$this->DO_NoWeb);
        parent::maj("DO_Attente",$this->DO_Attente);
        parent::maj("DO_Provenance" ,$this->DO_Provenance);
        parent::maj("CA_NumIFRS" ,$this->CA_NumIFRS);
        parent::maj("MR_No" ,$this->MR_No);
        parent::maj("DO_TypeFrais" ,$this->DO_TypeFrais);
        parent::maj("DO_ValFrais" ,$this->DO_ValFrais);
        parent::maj("DO_TypeLigneFrais" ,$this->DO_TypeLigneFrais);
        parent::maj("DO_TypeFranco" ,$this->DO_TypeFranco);
        parent::maj("DO_ValFranco" ,$this->DO_ValFranco);
        parent::maj("DO_TypeLigneFranco" ,$this->DO_TypeLigneFranco);
        parent::maj("DO_Taxe1" ,$this->DO_Taxe1);
        parent::maj("DO_Taxe2" ,$this->DO_Taxe2);
        parent::maj("DO_Taxe3" ,$this->DO_Taxe3);
        parent::maj("DO_TypeTaux1" ,$this->DO_TypeTaux1);
        parent::maj("DO_TypeTaux2" ,$this->DO_TypeTaux2);
        parent::maj("DO_TypeTaux3" ,$this->DO_TypeTaux3);
        parent::maj("DO_TypeTaxe1" ,$this->DO_TypeTaxe1);
        parent::maj("DO_TypeTaxe2" ,$this->DO_TypeTaxe2);
        parent::maj("DO_TypeTaxe3" ,$this->DO_TypeTaxe3);
        parent::maj("DO_MajCpta" ,$this->DO_MajCpta);
        parent::maj("DO_Motif" ,$this->DO_Motif);
        if($this->CT_NumCentrale!="")
            parent::maj("CT_NumCentrale" ,$this->CT_NumCentrale);
        parent::maj("DO_Contact" ,$this->DO_Contact);
        parent::maj("DO_FactureElec" ,$this->DO_FactureElec);
        parent::maj("DO_TypeTransac" ,$this->DO_TypeTransac);
        parent::maj("cbModification" ,$this->cbModification);
        parent::maj("longitude" ,$this->longitude);
        parent::maj("latitude" ,$this->latitude);
        parent::maj("VEHICULE" ,$this->VEHICULE);
        parent::maj("CHAUFFEUR" ,$this->CHAUFFEUR);
        parent::maj("cbCreateur" ,$this->userName);
        parent::majcbModification();
    }

    public function getReglementByFacture($cbMarq){
        return $this->getApiJson("/getReglementByFacture&cbMarq=$cbMarq");
    }

    public function dr_regle(){
        return $this->getApiString("/drRegle&cbMarq={$this->cbMarq}");
    }

    public function protectionFacture($protection){
        if($this->type_fac == "Vente" || $this->type_fac == "VenteC" || $this->type_fac == "VenteT")
            return $protection->PROT_DOCUMENT_VENTE_FACTURE;
        if($this->type_fac == "Devis")
            return $protection->PROT_DOCUMENT_VENTE_DEVIS;
        if($this->type_fac == "BonLivraison")
            return $protection->PROT_DOCUMENT_VENTE_BLIVRAISON;
        if($this->type_fac == "Avoir" || $this->type_fac == "AvoirC" || $this->type_fac == "AvoirT")
            return $protection->PROT_DOCUMENT_VENTE_AVOIR;
        if($this->type_fac == "VenteRetour" || $this->type_fac == "VenteRetourC" || $this->type_fac == "VenteRetourT")
            return $protection->PROT_DOCUMENT_VENTE_RETOUR;
        if($this->type_fac == "Ticket")
            return $protection->PROT_VENTE_COMPTOIR;
        if($this->type_fac == "BonCommande")
            return $protection->PROT_DOCUMENT_VENTE_BONCOMMANDE;
        if($this->type_fac == "Achat" || $this->type_fac == "AchatC" || $this->type_fac == "AchatT")
            return $protection->PROT_DOCUMENT_ACHAT_FACTURE;
        if($this->type_fac == "AchatRetour" || $this->type_fac == "AchatRetourC" || $this->type_fac == "AchatRetourT")
            return $protection->PROT_DOCUMENT_ACHAT_RETOUR;
        if($this->type_fac == "AchatPreparationCommande" || $this->type_fac == "PreparationCommande")
            return $protection->PROT_DOCUMENT_ACHAT_PREPARATION_COMMANDE;
        if($this->type_fac == "Transfert")
            return $protection->PROT_DOCUMENT_STOCK;
        if($this->type_fac == "Entree")
            return $protection->PROT_DOCUMENT_ENTREE;
        if($this->type_fac == "Sortie")
            return $protection->PROT_DOCUMENT_SORTIE;
        if($this->type_fac == "Transfert_detail")
            return $protection->PROT_VIREMENT_DEPOT;
        if($this->type_fac == "Transfert_confirmation")
            return $protection->PROT_DOCUMENT_INTERNE_2;
        if($this->type_fac == "Transfert_valid_confirmation")
            return $protection->PROT_DOCUMENT_INTERNE_5;
    }

    public function getDocumentConfirmation($listDepot) {
        $query = "SELECT  cbMarqEntete 
                  FROM    Z_LIGNE_CONFIRMATION A 
                  INNER JOIN F_DOCENTETE B 
                      ON A.cbMarqEntete = B.cbMarq
                  WHERE B.DE_No IN ({$listDepot})
                  GROUP BY cbMarqEntete";
        $result= $this->db->query($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $list = array();
        foreach ($rows as $row){
            array_push($list,new DocEnteteClass($row->cbMarqEntete,$this->db));
        }
        return $list;
    }

    public function getLignetConfirmation() {
        $query = "SELECT  A.Prix as DL_PrixUnitaire
                         ,AR_Design as DL_Design
                         ,A.AR_Ref
                         ,A.DL_Qte
                        ,0 AS DL_Remise
                        ,0 AS DL_Taxe1
                        ,0 AS DL_Taxe2
                        ,0 AS DL_Taxe3
                        ,A.cbMarq
                             ,0 as idSec
                             ,cbMarqLigneFirst
                        ,ROUND(A.Prix*DL_Qte,2) DL_MontantHT
                  FROM    Z_LIGNE_CONFIRMATION A
                  INNER JOIN F_ARTICLE B 
                      ON A.AR_Ref=B.AR_Ref
                  WHERE   cbMarqEntete='{$this->cbMarq}'";
        $result= $this->db->query($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        return $rows ;
    }

        function lien ($cbMarq){
            $lienfinal="";
            if($this->DO_Domaine==0 || $this->type_fac=="Ticket" || $this->DO_Domaine==1)
                $lienfinal = "Document-Facture-$cbMarq-{$this->type_fac}";

            if($this->type_fac=="Transfert" || $this->type_fac=="Transfert_confirmation"
                || $this->type_fac=="Transfert_valid_confirmation"
                || $this->type_fac=="Entree"  || $this->type_fac=="Sortie")
                $lienfinal = "Document-Mvt-$cbMarq-{$this->type_fac}";
            if($this->type_fac=="Transfert_detail")
                $lienfinal = "Document-Mvttrft-$cbMarq-{$this->type_fac}";

            return $lienfinal;
        }

    public function getLigneMajAnalytique(){
        return $this->getApiJson("/getLigneMajAnalytique&cbMarq={$this->cbMarq}");
    }

    public function getLigneFacture() {
        return $this->getApiJson("/getLigneFacture&cbMarq={$this->cbMarq}");
    }

    public function saisie_comptable(){
        return $this->getApiJson("/saisie_comptable&cbMarq={$this->cbMarq}");
    }

    public function testCorrectLigneA()
    {
        return $this->getApiJson("/testCorrectLigneA&cbMarq={$this->cbMarq}");
    }

    public function getFLivraisonByCTNum($ct_num) {
        return "SELECT ISNULL((SELECT Max(LI_No) FROM ".$this->db->baseCompta.".dbo.F_LIVRAISON WHERE CT_Num ='$ct_num'),0) AS LI_No";
    }

    public function isFactureTransform() {
        $query = "  SELECT TOP 1 fdo.cbMarq
                    FROM    F_DOCENTETE fdo
                    INNER JOIN F_DOCLIGNE fdl 
                        ON  fdo.DO_Type=fdl.DO_Type
                        AND fdo.cbDO_Piece=fdl.cbDO_Piece
                        AND fdo.DO_Domaine=fdl.DO_Domaine
                    WHERE DL_PieceBL = '{$this->DO_Piece}'";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function addDocenteteTransfertDetailProcess($do_pieceParam,$do_domaine,$do_type,$do_date, $do_ref, $depot, $longitude, $latitude,$dcCol){
        $CT_Num = '41TRANSFERTDETAIL';
        $comptet = new ComptetClass($CT_Num);
        if($do_type==40) {
            $do_piece = $do_pieceParam;
        }
        else {
            $do_piece = $this->objetCollection->getEnteteDocument($do_domaine, $do_type, 0, "Transfert_detail");
        }
        $cg_num = $comptet->CG_NumPrinc;
        $result = $this->db->requete($this->getFLivraisonByCTNum($CT_Num));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $li_no = $rows[0]->LI_No;
        $result = $this->db->requete($this->objetCollection->getEnteteTable(4,1,$dcCol));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if ($rows != null) {
            $docEntete = new DocEnteteClass(0);
            $docEntete->defaultValue();
            $docEntete->setValueMvtEntree();
            $docEntete->DO_Domaine = $do_domaine;
            $docEntete->DO_Type = $do_type;
            $docEntete->DO_Piece = $do_piece;
            $docEntete->latitude = $latitude;
            $docEntete->longitude =  $longitude;
            $docEntete->DO_Ref = $do_ref;
            $docEntete->DO_Tiers = $CT_Num;
            $docEntete->CA_Num = "";
            $docEntete->DO_Date = $do_date;
            $docEntete->DO_DateLivr = '1900-01-01';
            $docEntete->DE_No = $depot;
            $docEntete->type_fac = "Transfert_detail";
            $docEntete->setValueMvt();

            $cbMarqCreate = $docEntete->insert_docEntete();
            return $do_piece;
			$docEntete = new DocEnteteClass($cbMarqCreate,$this->db);
			$nextDO_Piece = $this->getEnteteDispo();
			$this->updateEnteteTable($nextDO_Piece);
        }
    }

    public function setDefaultValueVente($client){
        if(($this->DO_Domaine ==0 && $this->DO_Type >=0 && $this->DO_Type <=7)|| $this->DO_Domaine ==3) {
            $this->DO_Tiers = $client->CT_Num;
            $this->AB_No = 0;
            $this->CA_No = 0;
            if($client->CA_Num!="")
                $this->CA_Num = $client->CA_Num;
            if($client->CG_NumPrinc!="")
                $this->CG_Num = $client->CG_NumPrinc;
            if($client->CT_BLFact!="")
                $this->DO_BLFact = $client->CT_BLFact;
            $this->DO_Cloture = 0;
            $this->DO_Colisage = 1;
            if($client->N_Condition!="")
                $this->DO_Condition = $client->N_Condition;
            $this->DO_Coord01 = "";
            $this->DO_Coord02 = "";
            $this->DO_Coord03 = "";
            $this->DO_Coord04 = "";
            $this->DO_DateLivr = "1900-01-01" ;
            $this->DO_DebutAbo  = "1900-01-01";
            $this->DO_DebutPeriod  = "1900-01-01";
            if($client->N_Devise!="")
                $this->DO_Devise = $client->N_Devise;
            $this->DO_Ecart = 0;
            if($client->N_Expedition!="")
                $this->DO_Expedit = $client->N_Expedition;
            $this->DO_FinAbo  = "1900-01-01";
            $this->DO_FinPeriod  = "1900-01-01";
            $this->DO_Imprim = 0;
            if($client->CT_Langue!="")
                $this->DO_Langue = $client->CT_Langue;
            if($client->CT_Facture!="")
                $this->DO_NbFacture = $client->CT_Facture;
            if($client->N_Period!="")
                $this->DO_Period = $client->N_Period;
            $this->DO_Ref ="";
            $this->DO_Reliquat =0;
            $this->DO_Souche=0;
            $this->DO_Statut = 2;
            if($client->N_CatTarif=="")
                $this->DO_Tarif = 0;
            else
                $this->DO_Tarif = $client->N_CatTarif;
            $this->DO_Transfere = 0 ;
            if($client->CT_Taux02!="")
                $this->DO_TxEscompte = $client->CT_Taux02;
            if($client->CT_NumPayeur!="")
                $this->CT_NumPayeur = $client->CT_NumPayeur;
            $this->DO_Tiers = $client->CT_Num;
            $this->DO_TypeColis = 1;
            $this->DO_Ventile = 0;
            if($client->N_CatCompta!="")
                $this->N_CatCompta = $client->N_CatCompta;
            if($client->CO_No!="")
                $this->CO_No = $client->CO_No;
            $this->CO_NoCaissier = 0;
            $this->DO_Attente = 0;
            $this->DO_NoWeb = "";
            $this->DO_Regime = "";
            $this->DO_Transaction = "";
        }
    }

    public function setDefaultValueAchat($client){
        if($this->DO_Domaine ==1 && $this->DO_Type >=10 && $this->DO_Type <=17) {
            $this->DO_Tiers = $client->CT_Num;
            $this->AB_No = 0;
            $this->CA_No = 0;
            if($client->CA_Num!="")
                $this->CA_Num = $client->CA_Num;
            if($client->CG_NumPrinc!="")
                $this->CG_Num = $client->CG_NumPrinc;
            $this->DO_BLFact = 0;
            $this->DO_Cloture = 0;
            $this->DO_Colisage = 1;
            if($client->N_Condition!="")
                $this->DO_Condition = $client->N_Condition;
            $this->DO_Coord01 = "";
            $this->DO_Coord02 = "";
            $this->DO_Coord03 = "";
            $this->DO_Coord04 = "";
            $this->DO_DateLivr = "1900-01-01" ;
            $this->DO_DebutAbo  = "1900-01-01";
            $this->DO_DebutPeriod  = "1900-01-01";
            if($client->N_Devise!="")
                $this->DO_Devise = $client->N_Devise;
            $this->DO_Ecart = 0;
            $this->DO_Expedit = 1;
            $this->DO_FinAbo  = "1900-01-01";
            $this->DO_FinPeriod  = "1900-01-01";
            $this->DO_Imprim = 0;
            if($client->CT_Langue!="")
                $this->DO_Langue = $client->CT_Langue;
            if($client->CT_Facture!="")
                $this->DO_NbFacture = $client->CT_Facture;
            $this->DO_Period = 1;
            $this->DO_Ref ="";
            $this->DO_Reliquat =0;
            $this->DO_Souche=0;
            $this->DO_Statut = 2;
            $this->DO_Tarif = 1;
            $this->DO_Transfere = 0 ;
            if($client->CT_Taux02!="")
                $this->DO_TxEscompte = $client->CT_Taux02;
            if($client->CT_NumPayeur!="")
                $this->CT_NumPayeur = $client->CT_NumPayeur;
            if($client->CT_Num!="")
                $this->DO_Tiers = $client->CT_Num;
            $this->DO_TypeColis = 1;
            $this->DO_Ventile = 0;
            if($client->N_CatCompta!="")
                $this->N_CatCompta = $client->N_CatCompta;
            if($client->CO_No!="")
                $this->CO_No = $client->CO_No;
            $this->CO_NoCaissier = 0;
            $this->DO_Attente = 0;
            $this->DO_NoWeb = "";
            $this->DO_Regime = "";
            $this->DO_Transaction = "";
        }
    }


    public function setDefaultValueStock(){
        if($this->DO_Domaine ==2 /*&& $this->DO_Type =10 && $this->DO_Type >=17*/) {
            //$this->DO_Tiers = $client->CT_Num;
            $this->AB_No = 0;
            $this->CA_No = 0;
            $this->CA_Num = "";
            $this->CG_Num = "NULL";
            $this->DE_No = 0;
            $this->DO_BLFact = 0;
            $this->DO_Cloture = 0;
            $this->DO_Colisage = 1;
            $this->DO_Condition = 0;
            $this->DO_Coord01 = "";
            $this->DO_Coord02 = "";
            $this->DO_Coord03 = "";
            $this->DO_Coord04 = "";
            $this->DO_DateLivr = "1900-01-01" ;
            $this->DO_DebutAbo  = "1900-01-01";
            $this->DO_DebutPeriod  = "1900-01-01";
            $this->DO_Devise = 0;
            $this->DO_Ecart = 0;
            $this->DO_Expedit = 0;
            $this->DO_FinAbo  = "1900-01-01";
            $this->DO_FinPeriod  = "1900-01-01";
            $this->DO_Imprim = 0;
            $this->DO_Langue = 0;
            $this->DO_NbFacture = 0;
            $this->DO_Period = 0;
            $this->DO_Ref ="";
            $this->DO_Reliquat =0;
            $this->DO_Souche=0;
            $this->DO_Statut = 0;
            $this->DO_Tarif = 0;
            $this->DO_Transfere = 0 ;
            $this->DO_TxEscompte = 0;
            $this->CT_NumPayeur = 0;
            $this->DO_Tiers = 0;
            $this->DO_TypeColis = 1;
            $this->DO_Ventile = 0;
            $this->N_CatCompta = 0;
            $this->CO_No = 0;
            $this->CO_NoCaissier = 0;
            $this->DO_Attente = 0;
            $this->DO_NoWeb = "";
            $this->DO_Regime = "";
            $this->DO_Transaction = "";
        }
    }

    public function setTypeFac($typefac){
        $this->type_fac = $typefac;
        if($typefac=="Vente" || $typefac=="Livraison"){
            $this->DO_Domaine = 0;
            $this->DO_Type = 6;
            $this->doccurent_type = 6;
            if($typefac=="Livraison")
                $this->DO_Provenance=-1;
            else
                $this->DO_Provenance=0;
        }
        if($typefac=="VenteT"){
            $this->DO_Domaine = 0;
            $this->DO_Type = 6;
            $this->doccurent_type = 6;
            $this->DO_Provenance=0;
        }
        if($typefac=="VenteRetour" ){
            $this->DO_Domaine = 0;
            $this->DO_Type = 6;
            $this->DO_Provenance = 1;
            $this->doccurent_type = 7;

        }
        if($typefac=="VenteRetourT" ){
            $this->DO_Domaine = 0;
            $this->DO_Type = 6;
            $this->DO_Provenance = 1;
            $this->doccurent_type = 7;
        }
        if($typefac=="BonCommande" ){
            $this->DO_Domaine = 0;
            $this->DO_Type = 1;
            $this->DO_Provenance = 0;
            $this->doccurent_type = 1;
        }
        if($typefac=="VenteRetourC" ){
            $this->DO_Domaine = 0;
            $this->DO_Type = 7;
            $this->DO_Provenance = 1;
            $this->doccurent_type = 7;
        }
        if($typefac=="Avoir"){
            $this->DO_Domaine = 0;
            $this->DO_Type = 6;
            $this->DO_Provenance = 2;
            $this->doccurent_type = 8;
        }

        if($typefac=="BonLivraison"){
            $this->DO_Domaine = 0;
            $this->DO_Type = 3;
            $this->doccurent_type = 1;
            $this->DO_Provenance=0;
        }

        if($typefac=="VenteC"){
            $this->DO_Domaine = 0;
            $this->DO_Type = 7;
            $this->doccurent_type = 6;
            $this->DO_Provenance=0;
        }

        if($typefac=="AchatC"){
            $this->DO_Domaine = 1;
            $this->DO_Type = 17;
            $this->doccurent_type = 6;
            $this->DO_Provenance=0;
        }

        if($typefac=="AchatRetourC"){
            $this->DO_Domaine = 1;
            $this->DO_Type = 17;
            $this->DO_Provenance = 1;
            $this->doccurent_type = 7;
        }

        if($typefac=="AchatRetour"){
            $this->DO_Domaine = 1;
            $this->DO_Type = 16;
            $this->DO_Provenance = 1;
            $this->doccurent_type = 7;
        }

        if($typefac=="Devis"){
            $this->DO_Domaine = 0;
            $this->DO_Type = 0;
            $this->doccurent_type = 0;
            $this->DO_Provenance=0;
        }

        if($typefac=="PreparationCommande"){
            $this->DO_Domaine  = 1;
            $this->DO_Type = 11;
            $this->doccurent_type =1;
            $this->DO_Provenance=0;
        }

        if($typefac=="Entree"){
            $this->DO_Domaine  = 2;
            $this->DO_Type = 20;
            $this->doccurent_type =0;
            $this->DO_Souche =0;
        }

        if($typefac=="Sortie"){
            $this->DO_Domaine  = 2;
            $this->DO_Type = 21;
            $this->doccurent_type =1;
            $this->DO_Souche =0;
        }

        if($typefac=="Transfert"){
            $this->DO_Domaine  = 2;
            $this->DO_Type = 23;
            $this->doccurent_type =3;
            $this->DO_Souche =0;
        }

        if($typefac=="Transfert_confirmation" || $typefac=="Transfert_valid_confirmation"){
            $this->DO_Domaine  = 4;
            $this->DO_Type = 44;
            $this->doccurent_type =4;
            $this->DO_Souche =0;
        }

        if($typefac=="Transfert_detail"){
            $this->DO_Domaine  = 4;
            $this->DO_Type = 41;
            $this->doccurent_type =0;
            $this->DO_Souche =0;
        }

        if($typefac=="Achat"){
            $this->DO_Domaine = 1;
            $this->DO_Type = 16;
            $this->doccurent_type =6;
            $this->DO_Provenance=0;
        }

        if($typefac=="AchatT"){
            $this->DO_Domaine = 1;
            $this->DO_Type = 16;
            $this->doccurent_type =6;
            $this->DO_Provenance=0;
        }

        if($typefac=="AchatPreparationCommande"){
            $this->DO_Domaine = 1;
            $this->doccurent_type =6;
            $this->DO_Type = 12;
            $this->DO_Provenance=0;
        }

        if($typefac=="Ticket") {
            $this->DO_Domaine = 3;
            $this->doccurent_type =6;
            $this->DO_Type = 30;
            $this->DO_Provenance=0;
        }

    }

    public function getTypeFac(){

        if($this->DO_Domaine == 0 && $this->DO_Type == 6){
            $this->type_fac = "Vente";
        }

        if($this->DO_Domaine == 0 && $this->DO_Type == 6 && $this->DO_Provenance == 1){
            $this->type_fac = "VenteRetour";
        }
        if($this->DO_Domaine == 0 && $this->DO_Type == 16 && $this->DO_Provenance == 1){
            $this->type_fac = "AchatRetour";
        }
        if($this->DO_Domaine == 0 && $this->DO_Type == 17 && $this->DO_Provenance == 1){
            $this->type_fac = "AchatRetourC";
        }

        if($this->DO_Domaine = 0 && $this->DO_Type = 6 && $this->DO_Provenance == 2){
            $this->type_fac = "Avoir";
        }

        if($this->DO_Domaine = 4 && $this->DO_Type == 44){
            $this->type_fac = "Transfert_confirmation";
        }

        if($this->DO_Domaine == 0 && $this->DO_Type == 3){
            $this->type_fac = "BonLivraison";
        }

        if($this->DO_Domaine == 0 && $this->DO_Type == 7){
            $this->type_fac = "VenteC";
        }

        if($this->DO_Domaine == 1 && $this->DO_Type == 17){
            $this->type_fac = "AchatC";
        }

        if($this->DO_Domaine == 0 && $this->DO_Type == 0){
            $this->type_fac = "Devis";
        }

        if($this->DO_Domaine == 1 && $this->DO_Type == 11){
            $this->type_fac = "PreparationCommande";
        }

        if($this->DO_Domaine == 2 && $this->DO_Type == 20){
            $this->type_fac = "Entree";
        }

        if($this->DO_Domaine == 2 && $this->DO_Type == 21){
            $this->type_fac = "Sortie";
        }

        if($this->DO_Domaine == 2 && $this->DO_Type == 23){
            $this->type_fac = "Transfert";
        }

        if($this->DO_Domaine == 1 && $this->DO_Type == 16){
            $this->type_fac = "Achat";
        }

        if($this->DO_Domaine == 1 && $this->DO_Type == 12){
            $this->type_fac = "AchatPreparationCommande";
        }

        if($this->DO_Domaine == 3 && $this->DO_Type == 30){
            $this->type_fac = "Ticket";
        }
    }

    public function enteteList($cbMarq){

    }

    public function setInfoAjoutEntete(){
        if($this->type_fac == "BonCommande" || $this->type_fac == "BonLivraison"
            || $this->type_fac == "Devis"
            || $this->type_fac == "Vente") {
            $this->DO_Transaction = 11;
            $this->DO_Regime = 21;
            $this->DO_Provenance = 0;
        }

        if($this->type_fac == "Achat" || $this->type_fac == "AchatRetour" || $this->type_fac == "AchatPreparationCommande"
            || $this->type_fac == "PreparationCommande" ) {
            $this->DO_Transaction = 11;
            $this->DO_Regime = 11;
            $this->DO_Provenance = 0;
        }

        if($this->type_fac == "Entree" || $this->type_fac == "Sortie" || $this->type_fac == "Transfert" || $this->type_fac == "Transfert_detail") {
            $this->DO_Transaction = 0;
            $this->DO_Regime = 0;
            $this->DO_Provenance = 0;
            $this->DO_Condition  = 0;
        }

        if($this->type_fac == "VenteRetour" || $this->type_fac == "AchatRetour")
            $this->DO_Provenance = 1;
        if($this->type_fac == "Avoir")
            $this->DO_Provenance = 2;
        if($this->type_fac == "Achat"|| $this->type_fac == "AchatRetour"|| $this->type_fac == "PreparationCommande")
            $this->DO_Regime = 11;
        if($this->type_fac == "Avoir"|| $this->type_fac == "VenteRetour"|| $this->type_fac == "AchatRetour"){
            $this->DO_Transaction = 21;
            $this->DO_Regime = 25;
        }
    }

    public function insert_docEntete(){

        $query="BEGIN 
                SET NOCOUNT ON;
                INSERT INTO [dbo].[F_DOCENTETE]
                ([DO_Domaine], [DO_Type], [DO_Date], [DO_Ref]
                , [DO_Tiers], [CO_No], [DO_Period], [DO_Devise]
                , [DO_Cours], [DE_No], [LI_No]
                , [CT_NumPayeur], [DO_Expedit], [DO_NbFacture], [DO_BLFact]
                , [DO_TxEscompte], [DO_Reliquat], [DO_Imprim], [CA_Num]
                , [DO_Coord01], [DO_Coord02], [DO_Coord03], [DO_Coord04]
                , [DO_Souche], [DO_DateLivr], [DO_Condition], [DO_Tarif]
                , [DO_Colisage], [DO_TypeColis], [DO_Transaction], [DO_Langue]
                , [DO_Ecart], [DO_Regime], [N_CatCompta], [DO_Ventile]
                , [AB_No], [DO_DebutAbo], [DO_FinAbo], [DO_DebutPeriod]
                , [DO_FinPeriod], [CG_Num], [DO_Statut], [DO_Heure]
                , [CA_No], [CO_NoCaissier]
                , [DO_Transfere], [DO_Cloture], [DO_NoWeb], [DO_Attente]
                , [DO_Provenance], [CA_NumIFRS], [MR_No], [DO_TypeFrais]
                , [DO_ValFrais], [DO_TypeLigneFrais], [DO_TypeFranco], [DO_ValFranco]
                    , [DO_TypeLigneFranco], [DO_Taxe1], [DO_TypeTaux1], [DO_TypeTaxe1]
                    , [DO_Taxe2], [DO_TypeTaux2], [DO_TypeTaxe2], [DO_Taxe3]
                    , [DO_TypeTaux3], [DO_TypeTaxe3], [DO_MajCpta], [DO_Motif]
                        , [CT_NumCentrale], [DO_Contact], [DO_FactureElec], [DO_TypeTransac]
                        , [cbProt], [cbCreateur], [cbModification], [cbReplication]
                        , [cbFlag], [VEHICULE], [CHAUFFEUR]
                        , [longitude], [latitude],[DO_Piece])
                        VALUES
                        (/*DO_Domaine*/{$this->DO_Domaine},/*DO_Type*/{$this->DO_Type},/*DO_Date*/'{$this->DO_Date}',/*DO_Ref*/LEFT('{$this->DO_Ref}',17)
                            ,/*DO_Tiers*/'{$this->DO_Tiers}',/*CO_No*/{$this->CO_No},/*DO_Period*/{$this->DO_Period},/*DO_Devise*/{$this->DO_Devise}
                            ,/*DO_Cours*/(SELECT D_Cours FROM P_Devise WHERE cbIndice = {$this->DO_Devise}),/*DE_No*/'{$this->DE_No}',/*LI_No*/ {$this->LI_No}
                        ,/*CT_NumPayeur*/(CASE WHEN '{$this->CT_NumPayeur}'='' OR '{$this->CT_NumPayeur}'='NULL' THEN NULL ELSE '{$this->CT_NumPayeur}' END)   
                        ,/*DO_Expedit*/{$this->DO_Expedit},/*DO_NbFacture*/{$this->DO_NbFacture},/*DO_BLFact*/{$this->DO_BLFact}
                        ,/*DO_TxEscompte*/{$this->DO_TxEscompte},/*DO_Reliquat*/{$this->DO_Reliquat},/*DO_Imprim*/{$this->DO_Imprim}
                        ,/*CA_Num*/CASE WHEN '{$this->CA_Num}'='' OR '{$this->CA_Num}'='0' OR '{$this->CA_Num}' ='null' THEN null else '{$this->CA_Num}' END
                        ,/*DO_Coord01*/'{$this->DO_Coord01}',/*DO_Coord02*/'{$this->DO_Coord02}',/*DO_Coord03*/'{$this->DO_Coord03}',/*DO_Coord04*/'{$this->DO_Coord04}'
                        ,/*DO_Souche*/{$this->DO_Souche},/*DO_DateLivr*/'{$this->DO_DateLivr}',/*DO_Condition*/1,/*DO_Tarif*/(CASE WHEN '{$this->DO_Tarif}'='' THEN NULL ELSE '{$this->DO_Tarif}' END)
                        ,/*DO_Colisage*/{$this->DO_Colisage},/*DO_TypeColis*/{$this->DO_TypeColis},/*DO_Transaction*/{$this->DO_Transaction},/*DO_Langue*/{$this->DO_Langue}
                        ,/*DO_Ecart*/0,/*DO_Regime*/{$this->DO_Regime},/*N_CatCompta*/ {$this->N_CatCompta} ,/*DO_Ventile*/{$this->DO_Ventile}
                        ,/*AB_No*/{$this->AB_No},/*DO_DebutAbo*/'{$this->DO_DebutAbo}',/*DO_FinAbo*/'{$this->DO_FinAbo}',/*DO_DebutPeriod*/'{$this->DO_DebutPeriod}'
                        ,/*DO_FinPeriod*/'{$this->DO_FinPeriod}',/*CG_Num*/(CASE WHEN '{$this->CG_Num}'='' OR '{$this->CG_Num}'='NULL' THEN NULL ELSE '{$this->CG_Num}' END)
						,/*DO_Statut*/{$this->DO_Statut},/*DO_Heure*/'000' + CAST(DATEPART(HOUR, GETDATE()) as VARCHAR(2)) + CAST(DATEPART(MINUTE, GETDATE()) as VARCHAR(2)) + CAST(DATEPART(SECOND, GETDATE()) as VARCHAR(2))
                        ,/*CA_No*/{$this->CA_No},/*CO_NoCaissier*/" .$this->CO_NoCaissier. ",/*DO_Transfere*/{$this->DO_Transfere}
                        ,/*DO_Cloture*/{$this->DO_Cloture},/*DO_NoWeb*/'{$this->DO_NoWeb}',/*DO_Attente*/{$this->DO_Attente},/*DO_Provenance*/{$this->DO_Provenance}
                        ,/*CA_NumIFRS*/'{$this->CA_NumIFRS}',/*MR_No*/{$this->MR_No},/*DO_TypeFrais*/{$this->DO_TypeFrais},/*DO_ValFrais*/{$this->DO_ValFrais}
                        ,/*DO_TypeLigneFrais*/{$this->DO_TypeLigneFrais},/*DO_TypeFranco*/{$this->DO_TypeFranco},/*DO_ValFranco*/{$this->DO_ValFranco},/*DO_TypeLigneFranco*/{$this->DO_TypeLigneFranco}
                        ,/*DO_Taxe1*/{$this->DO_Taxe1},/*DO_TypeTaux1*/{$this->DO_TypeTaux1},/*DO_TypeTaxe1*/{$this->DO_TypeTaxe1},/*DO_Taxe2*/{$this->DO_Taxe2}
                        ,/*DO_TypeTaux2*/{$this->DO_TypeTaux2},/*DO_TypeTaxe2*/{$this->DO_TypeTaxe2},/*DO_Taxe3*/{$this->DO_Taxe3},/*DO_TypeTaux3*/{$this->DO_Taxe3}
                        ,/*DO_TypeTaxe3*/{$this->DO_TypeTaxe3},/*DO_MajCpta*/{$this->DO_MajCpta},/*DO_Motif*/'{$this->DO_Motif}',/*CT_NumCentrale*/NULL
                        ,/*DO_Contact*/'{$this->DO_Contact}',/*DO_FactureElec*/{$this->DO_FactureElec},/*DO_TypeTransac*/{$this->DO_TypeTransac},/*cbProt*/{$this->cbProt}
                        ,/*cbCreateur*/'{$this->userName}',/*cbModification*/GETDATE(),/*cbReplication*/0,/*cbFlag*/{$this->cbFlag}
                        ,/*VEHICULE*/'{$this->VEHICULE}',/*CHAUFFEUR*/'{$this->CHAUFFEUR}',/*longitude*/{$this->longitude},/*latitude*/{$this->latitude},/*DO_Piece*/'{$this->DO_Piece}' );
                        select @@IDENTITY as cbMarq;
                END";
        $result= $this->db->query($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        return $rows[0]->cbMarq;
    }


    public function listeLigneFacture($protNo){
        return $this->getApiJson("/listeLigneFacture&cbMarq={$this->cbMarq}&protNo=$protNo");
    }


    public function getLastPieceInv()
    {
        $query = "SELECT(CONCAT('i',RIGHT(CONCAT('0000000',CAST(RIGHT((SELECT RIGHT(ISNULL(MAX(DO_Piece),0),6)
                FROM F_DOCENTETE
                WHERE DO_Piece LIKE 'i%'
                AND DO_Domaine=2 AND DO_Type=20),7) as INT)+1),7) )) as DO_Piece";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ)[0]->DO_Piece;
    }

    public function getLastPieceInv21()
    {
        $query = "SELECT(CONCAT('i',RIGHT(CONCAT('0000000',CAST(RIGHT((SELECT RIGHT(ISNULL(MAX(DO_Piece),0),6)
                FROM F_DOCENTETE
                WHERE DO_Piece LIKE 'i%'
                AND DO_Domaine=2 AND DO_Type=21),7) as INT)+1),7) )) as DO_Piece";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ)[0]->DO_Piece;
    }


    public function addDocenteteEntreeInventaireProcess($do_date, $do_ref, $do_tiers, $ca_num, $longitude, $latitude)
    {
        $do_piece = $this->getLastPieceInv();
        $cbMarq =$this->addDocenteteEntreeMagasin(20, $do_date, $do_ref, $do_tiers, $ca_num, $longitude, $latitude, $do_piece);
        return $cbMarq ;
    }

    public function addDocenteteEntreeInventaireProcess21($do_date, $do_ref, $do_tiers, $ca_num, $longitude, $latitude)
    {
        $do_piece = $this->getLastPieceInv21();
        $this->addDocenteteEntreeMagasin(21, $do_date, $do_ref, $do_tiers, $ca_num, $longitude, $latitude, $do_piece);
        return $do_piece;
    }

    public function majLigneByCbMarq($champ,$value,$cbMarq,$protNo){
        $this->getApiExecute("/majLigneByCbMarq&champ=$champ&value=$value&cbMarq=$cbMarq&protNo=$protNo");
    }

    public function addDocenteteEntreeMagasin($type, $do_date, $do_ref, $do_tiers, $ca_num, $longitude, $latitude, $do_piece)
    {
        $requete = "
            BEGIN 
            SET NOCOUNT ON;
            INSERT INTO [dbo].[F_DOCENTETE]" .
            "([DO_Domaine], [DO_Type], [DO_Date], [DO_Ref]" .
            ", [DO_Tiers], [CO_No], [cbCO_No], [DO_Period], [DO_Devise]" .
            ", [DO_Cours], [DE_No], [cbDE_No], [LI_No], [cbLI_No]" .
            ", [CT_NumPayeur], [DO_Expedit], [DO_NbFacture], [DO_BLFact]" .
            ", [DO_TxEscompte], [DO_Reliquat], [DO_Imprim], [CA_Num]" .
            ", [DO_Coord01], [DO_Coord02], [DO_Coord03], [DO_Coord04]" .
            ", [DO_Souche], [DO_DateLivr], [DO_Condition], [DO_Tarif]" .
            ", [DO_Colisage], [DO_TypeColis], [DO_Transaction], [DO_Langue]" .
            ", [DO_Ecart], [DO_Regime], [N_CatCompta], [DO_Ventile]" .
            ", [AB_No], [DO_DebutAbo], [DO_FinAbo], [DO_DebutPeriod]" .
            ", [DO_FinPeriod], [CG_Num], [DO_Statut], [DO_Heure]" .
            ", [CA_No], [cbCA_No], [CO_NoCaissier], [cbCO_NoCaissier]" .
            ", [DO_Transfere], [DO_Cloture], [DO_NoWeb], [DO_Attente]" .
            ", [DO_Provenance], [CA_NumIFRS], [MR_No], [DO_TypeFrais]" .
            ", [DO_ValFrais], [DO_TypeLigneFrais], [DO_TypeFranco], [DO_ValFranco]" .
            "    , [DO_TypeLigneFranco], [DO_Taxe1], [DO_TypeTaux1], [DO_TypeTaxe1]" .
            "    , [DO_Taxe2], [DO_TypeTaux2], [DO_TypeTaxe2], [DO_Taxe3]" .
            "    , [DO_TypeTaux3], [DO_TypeTaxe3], [DO_MajCpta], [DO_Motif]" .
            "        , [CT_NumCentrale], [DO_Contact], [DO_FactureElec], [DO_TypeTransac]" .
            "        , [cbProt], [cbCreateur], [cbModification], [cbReplication]" .
            "        , [cbFlag], [longitude], [latitude],[DO_Piece])" .
            "        VALUES" .
            "            (/*DO_Domaine*/2,/*DO_Type*/$type,/*DO_Date*/'" . $do_date . "',/*DO_Ref*/'" . $do_ref . "'" .
            "            ,/*DO_Tiers*/'" . $do_tiers . "',/*CO_No*/0,/*cbCO_No*/NULL,/*DO_Period*/0,/*DO_Devise*/0" .
            "            ,/*DO_Cours*/0,/*DE_No*/0,/*cbDE_No*/NULL,/*LI_No*/0,/*cbLI_No*/NULL" .
            "            ,/*CT_NumPayeur*/NULL,/*DO_Expedit*/0,/*DO_NbFacture*/0,/*DO_BLFact*/0" .
            "            ,/*DO_TxEscompte*/0,/*DO_Reliquat*/0,/*DO_Imprim*/0,/*CA_Num*/''" .
            "            ,/*DO_Coord01*/'',/*DO_Coord02*/'',/*DO_Coord03*/'',/*DO_Coord04*/''" .
            "            ,/*DO_Souche*/0,/*DO_DateLivr*/'" . $do_date . "',/*DO_Condition*/0,/*DO_Tarif*/0" .
            "            ,/*DO_Colisage*/1,/*DO_TypeColis*/1,/*DO_Transaction*/0,/*DO_Langue*/0" .
            "            ,/*DO_Ecart*/0,/*DO_Regime*/0,/*N_CatCompta*/0,/*DO_Ventile*/0" .
            "            ,/*AB_No*/0,/*DO_DebutAbo*/'1900-01-01',/*DO_FinAbo*/'1900-01-01',/*DO_DebutPeriod*/'1900-01-01'" .
            "            ,/*DO_FinPeriod*/'1900-01-01',/*CG_Num*/NULL,/*DO_Statut*/0,/*DO_Heure*/'000' + CAST(DATEPART(HOUR, GETDATE()) as VARCHAR(2)) + CAST(DATEPART(MINUTE, GETDATE()) as VARCHAR(2)) + CAST(DATEPART(SECOND, GETDATE()) as VARCHAR(2))" .
            "           ,/*CA_No*/0,/*cbCA_No*/NULL,/*CO_NoCaissier*/0,/*cbCO_NoCaissier*/NULL,/*DO_Transfere*/0" .
            "            ,/*DO_Cloture*/0,/*DO_NoWeb*/'',/*DO_Attente*/0,/*DO_Provenance*/0" .
            "            ,/*CA_NumIFRS*/'',/*MR_No*/0,/*DO_TypeFrais*/0,/*DO_ValFrais*/0" .
            "            ,/*DO_TypeLigneFrais*/0,/*DO_TypeFranco*/0,/*DO_ValFranco*/0,/*DO_TypeLigneFranco*/0" .
            "            ,/*DO_Taxe1*/0,/*DO_TypeTaux1*/0,/*DO_TypeTaxe1*/0,/*DO_Taxe2*/0" .
            "            ,/*DO_TypeTaux2*/0,/*DO_TypeTaxe2*/0,/*DO_Taxe3*/0,/*DO_TypeTaux3*/0" .
            "            ,/*DO_TypeTaxe3*/0,/*DO_MajCpta*/0,/*DO_Motif*/'',/*CT_NumCentrale*/NULL" .
            "            ,/*DO_Contact*/'',/*DO_FactureElec*/0,/*DO_TypeTransac*/0,/*cbProt*/0" .
            "            ,/*cbCreateur*/'AND',/*cbModification*/GETDATE(),/*cbReplication*/0,/*cbFlag*/0" .
            "            ,/*longitude*/" . $longitude . ",/*latitude*/" . $latitude . ",/*DO_Piece*/'$do_piece');
            SELECT @@identity cbMarq;
            END;";
        $result= $this->db->query($requete);
        return $result->fetchAll(PDO::FETCH_OBJ)[0]->cbMarq;
    }

    public function canTransform()
    {
        $isTransform = 0;
        $listeArticle ="";
        $rows = $this->listeLigneFacture();
        if ($rows != null) {
            foreach ($rows as $row) {
                $docLigne = new DocLigneClass($row->cbMarq,$this->db);
                $article = new ArticleClass($docLigne->AR_Ref,$this->db);
                $rows_stk = $article->isStock($this->DE_No);
                $qteStock = 0;
                if ($rows_stk != null) $qteStock = $rows_stk[0]->AS_QteSto;
                if (ROUND($qteStock, 2) - ROUND($docLigne->DL_Qte, 2) >= 0) {

                } else{
                    $listeArticle = $listeArticle.$docLigne->AR_Ref." (stock : ".ROUND($qteStock, 2)."), ";
                    $isTransform = 1;
                }
            }
        }
        if($isTransform==1)
            return $listeArticle;
    }

    public function redirectToListe($type){
        return "listeFacture-$type";
    }

    public function transformBL_Dev_Facture ($conserv,$canTransform,$type_trans,$ref,$type){
        $date_bl="";
        $listeArticle="";
        $type_res="Vente";
        if($type_trans==3) $type_res="BonLivraison";
        $resultat="";
        $enteteCbMarq = 0;
        $DE_No = 0;
        $docTransform = $this->isFactureTransform();
        if(Sizeof($this->getStatutVente($type_res))>0) {
            $date_ins = $this->DO_Date;
            $date_bl = $this->DO_Date;
            $entete_bl = $this->DO_Piece;
            $DE_No = $this->DE_No;
            if ($_GET["date"] != "") {
                $date_ins = "20" . substr($_GET["date"], -2) . "-" . substr($_GET["date"], 2, 2) . "-" . substr($_GET["date"], 0, 2);
            }
            $ref_ins = $this->DO_Ref;
            if ($ref != "")
                $ref_ins = $ref;
            $latitude = $this->Latitude;
            $longitude = $this->Longitude;
            if ($latitude == "") $latitude = 0;
            if ($longitude == "") $longitude = 0;


            $docEntete = new DocEnteteClass(0,$this->db);
            if($docTransform==null){
                $data = $docEntete->ajoutEntete("", $type_res,
                    $date_ins, $date_ins, $this->CA_Num, $this->DO_Tiers, "",
                    "", "", $this->DO_Coord01, $this->DO_Coord02, $this->DO_Coord03, $this->DO_Coord04,
                    $this->DO_Statut, $latitude, $longitude, $this->DE_No, $this->DO_Tarif, $this->N_CatCompta,
                    $this->DO_Souche, $this->CA_No, $this->CO_No, $ref_ins);
                $enteteCbMarq = $data["cbMarq"];
            }else
                $enteteCbMarq = $docTransform[0]->cbMarq;

            $docEntete = new DocEnteteClass($enteteCbMarq,$this->db);
            $rows = $this->listeLigneFacture();

            foreach ($rows as $elt) {
                $docligne = new DocLigneClass($elt->cbMarq,$this->db);
                $DL_DatePL = $docligne->DL_DatePL;
                $DL_DateBL = $docligne->DL_DateBL;
                $DL_DateBC = $docligne->DL_DateBC;
                $arRef = new ArticleClass($docligne->AR_Ref,$this->db);
                $rows_stk = $arRef->isStock($this->DE_No);
                $qteStock = 0;
                if ($rows_stk != null) $qteStock = $rows_stk[0]->AS_QteSto;
                if ((ROUND($qteStock, 2) - ROUND($docligne->DL_Qte, 2) >= 0) || $type != "Devis") {
                    if ($conserv == 0) {
                        $docligne->delete($_SESSION["id"]);
                    }
                    $prix = $docligne->DL_PrixUnitaire;
                    if ($docligne->DL_TTC == 1)
                        $prix = $docligne->DL_PUTTC;
                    if ($type != "Devis")
                        $arRef->updateArtStock($this->DE_No, $docligne->DL_Qte,(ROUND($docligne->DL_CMUP, 2) * $docligne->DL_Qte),$_SESSION["id"],"modif_ligne");
                    if ($conserv == 0) {
                        $docligne->ajout_ligneFacturation($docligne->DL_Qte, $docligne->AR_Ref,
                            $enteteCbMarq, $type_res,
                            0, $prix, "",
                            "", "ajout_ligne", $_SESSION["id"]);
                        $liste = $docEntete->listeLigneFacture();
                        foreach ($liste as $element) {
                            $docligne = new DocLigneClass($element->cbMarq,$this->db);
                            $docligne->maj("DL_PieceBL", $entete_bl);
                            $docligne->maj("DL_DateBL", $docligne->DL_DateBL);
                        }
                    } else {
                        $docligne->ajout_ligneFacturation($docligne->DL_Qte, $docligne->AR_Ref, $enteteCbMarq, $type_trans, 0, $prix, "", "", "ajout_ligne", $_SESSION["id"]);
                    }
                    if($type_trans==6 && $type=="BonLivraison") {
                        $docligne->maj("DL_DatePL", $DL_DatePL);
                        $docligne->maj("DL_DateBL", $DL_DateBL);
                        $docligne->maj("DL_DateBC", $DL_DateBC);
                    }
                    $docligne->maj("DL_DateBC",$date_bl);
                    $docligne->maj("DL_DateBL",$date_bl);
                } else $resultat = "$resultat {$docligne->AR_Ref}";

            }
                if($canTransform==1) {
                    $this->deleteEntete();
                }
            }
            else
            $listeArticle="La transfomation vers ce document n'est pas possible !";
            if($type=="Devis")
                echo $listeArticle;
    }

    public function redirectToNouveau($type){
        if($this->DO_Domaine == 0 || $this->DO_Domaine == 1)
            return "Document-Facture-$type";
        if($type=="Entree" || $type=="Sortie" || $type=="Transfert" || $type=="Transfert_confirmation" || $type=="Transfert_detail")
            return "Document-Mvt-$type";
        if($type=="Transfert_detail")
            return "Document-Mvttrft-$type";
    }

    public function getListeFacture($de_no, $datedeb, $datefin,$client,$protNo,$doPiece){
        $DO_Type = $this->DO_Type;
        if($this->type_fac =="VenteT")
            $DO_Type = 67;
        if($this->type_fac =="AchatT")
            $DO_Type = 1617;
        if($this->type_fac =="RetourT")
            $DO_Type = 67;
        if($this->type_fac =="Livraison")
            $DO_Type = -1;
        return $this->getApiJson( "/getListeFacture&doProvenance={$this->DO_Provenance}&doType=$DO_Type&doDomaine={$this->DO_Domaine}&deNo=$de_no&dateDeb=$datedeb&dateFin=$datefin&client=$client&protNo=$protNo&doPiece=$doPiece");
    }

public function setValueMvt(){
    $this->DO_Period=0;
    $this->DO_Expedit=0;
    $this->DO_NbFacture=0;
}

public function defaultValue(){
    $this->DO_Period=1;
    $this->DO_Devise=0;
    $this->DO_Cours=0;
    $this->DO_Expedit=1;
    $this->DO_NbFacture=1;
    $this->DO_BLFact=0;
    $this->DO_TxEscompte=0;
    $this->DO_Reliquat=0;
    $this->DO_Imprim=0;
    $this->DO_Coord01='';
    $this->DO_Coord04='';
    $this->DO_Colisage=1;
    $this->DO_TypeColis=1;
    $this->DO_Langue=0;
    $this->DO_Ecart=0;
    $this->DO_Ventile=0;
    $this->AB_No=0;
    $this->DO_DebutAbo='1900-01-01';
    $this->DO_FinAbo='1900-01-01';
    $this->DO_DebutPeriod='1900-01-01';
    $this->DO_FinPeriod='1900-01-01';
    $this->DO_Transfere=0;
    $this->DO_Cloture=0;
    $this->DO_NoWeb='';
    $this->DO_Attente=0;
    $this->CA_NumIFRS='';
    $this->MR_No=0;
    $this->DO_TypeFrais=0;
    $this->DO_ValFrais=0;
    $this->DO_TypeLigneFrais=0;
    $this->DO_TypeFranco=0;
    $this->DO_ValFranco=0;
    $this->DO_TypeLigneFranco=0
    ;$this->DO_Taxe1=0;
    $this->DO_TypeTaux1=0;
    $this->DO_TypeTaxe1=0;
    $this->DO_Taxe2=0
    ;$this->DO_TypeTaux2=0;
    $this->DO_TypeTaxe2=0;
    $this->DO_Taxe3=0;
    $this->DO_TypeTaux3=0;
    $this->DO_TypeTaxe3=0;
    $this->DO_MajCpta=0;
    $this->DO_Motif='';
    $this->CT_NumCentrale=NULL;
    $this->DO_Contact='';
    $this->DO_FactureElec=0;
    $this->DO_TypeTransac=0;
    $this->cbProt=0;
    $this->cbReplication=0;
    $this->cbFlag=0;
    $this->VEHICULE='';
    $this->CHAUFFEUR='';
    $this->DO_Provenance=0;
}

public function setValueMvtEntree (){
    $this->CO_No=0;$this->cbCO_No=NULL;$this->DO_Period=0;$this->DO_Devise=0
    ;$this->DO_Cours=0;$this->DE_No=0;$this->cbDE_No=NULL;$this->LI_No=0;$this->cbLI_No=NULL
    ;$this->CT_NumPayeur=NULL;$this->DO_Expedit=0;$this->DO_NbFacture=0;$this->DO_BLFact=0
    ;$this->DO_TxEscompte=0;$this->DO_Reliquat=0;$this->DO_Imprim=0;$this->CA_Num=''
    ;$this->DO_Coord01='';$this->DO_Coord02='';$this->DO_Coord03='';$this->DO_Coord04=''
    ;$this->DO_Souche=0;$this->DO_Condition=0;$this->DO_Tarif=0
    ;$this->DO_Colisage=1;$this->DO_TypeColis=1;$this->DO_Transaction=0;$this->DO_Langue=0
    ;$this->DO_Ecart=0;$this->DO_Regime=0;$this->N_CatCompta=0;$this->DO_Ventile=0
    ;$this->AB_No=0;$this->DO_DebutAbo='1900-01-01';$this->DO_FinAbo='1900-01-01';$this->DO_DebutPeriod='1900-01-01'
    ;$this->DO_FinPeriod='1900-01-01';$this->CG_Num=NULL;$this->DO_Statut=0;
    ;$this->CA_No=0;$this->cbCA_No=NULL;$this->CO_NoCaissier=0;$this->cbCO_NoCaissier=NULL;$this->DO_Transfere=0
    ;$this->DO_Cloture=0;$this->DO_NoWeb='';$this->DO_Attente=0;$this->DO_Provenance=0
    ;$this->CA_NumIFRS='';$this->MR_No=0;$this->DO_TypeFrais=0;$this->DO_ValFrais=0
    ;$this->DO_TypeLigneFrais=0;$this->DO_TypeFranco=0;$this->DO_ValFranco=0;$this->DO_TypeLigneFranco=0
    ;$this->DO_Taxe1=0;$this->DO_TypeTaux1=0;$this->DO_TypeTaxe1=0;$this->DO_Taxe2=0
    ;$this->DO_TypeTaux2=0;$this->DO_TypeTaxe2=0;$this->DO_Taxe3=0;$this->DO_TypeTaux3=0
    ;$this->DO_TypeTaxe3=0;$this->DO_MajCpta=0;$this->DO_Motif='';$this->CT_NumCentrale=NULL
    ;$this->DO_Contact='';$this->DO_FactureElec=0;$this->DO_TypeTransac=0;$this->cbProt=0
    ;$this->cbReplication=0;$this->cbFlag=0;
}

    public function listeFacture($depot,$datedeb,$datefin,$protNo,$client,$doPiece){
        $listFacture = array();
        if($this->type_fac == "Transfert"){
            $listFacture = $this->listeTransfert($depot, $datedeb, $datefin,$protNo);
        }else
            if($this->type_fac == "Transfert_confirmation"){
                $listFacture = $this->listeTransfertConfirmation($datedeb, $datefin,$this->DO_Domaine,$this->DO_Type,$this->type_fac,$protNo);
            }else
                if($this->type_fac == "Transfert_valid_confirmation"){
                    $listFacture = $this->listeTransfertConfirmation($datedeb, $datefin,$this->DO_Domaine,$this->DO_Type,$this->type_fac,$protNo);
                }
                else
                    if($this->type_fac == "Transfert_detail"){
                        $listFacture = $this->listeTransfertDetail($depot, $datedeb, $datefin,$protNo);
                    }else
                        if($this->type_fac == "Entree"){
                            $listFacture = $this->listeEntree($depot, $datedeb, $datefin,$protNo);
                        }else
                            if($this->type_fac == "Sortie"){
                                $listFacture = $this->listeSortie($depot, $datedeb, $datefin,$protNo);
                            }
                            else
                                $listFacture = $this->getListeFacture($depot,$datedeb ,$datefin,$client,$protNo,$doPiece);
        return $listFacture;
    }

    public function listeTransfert($do_tiers, $datedeb, $datefin){
        return $this->getApiJson("/getlisteTransfert&client={$this->formatString($do_tiers)}&dateDeb=$datedeb&dateFin=$datefin");
    }

    public function listeTransfertConfirmation($datedeb, $datefin,$doDomaine,$doType,$typeFac,$protNo){
        return $this->getApiJson("/getlisteTransfertConfirmation&dateDeb=$datedeb&dateFin=$datefin&doDomaine=$doDomaine&doType=$doType&protNo=$protNo&typeFac=$typeFac");
    }



    public function listeEntree($do_tiers, $datedeb, $datefin){
        return $this->getApiJson("/getlisteEntree&client={$this->formatString($do_tiers)}&dateDeb=$datedeb&dateFin=$datefin");
    }

    public function addDocenteteTransfertProcess($do_date, $do_ref, $do_tiers, $ca_num,$depot, $longitude, $latitude,$typefac="Transfert",$doPiece=""){
            $this->setTypeFac($typefac);
            $docEnteteTrsft= new DocEnteteClass(0,$this->db);
            $docEnteteTrsft->setTypeFac("Transfert");
           $do_piece=$this->getEnteteDocument(0);
            $docEntete = new DocEnteteClass(0,$this->db);
        if($do_piece!="") {
            $docEntete->defaultValue();
            $docEntete->setValueMvtEntree();
            $docEntete->DO_Domaine = $this->DO_Domaine;
            $docEntete->DO_Type = $this->DO_Type;
            $docEntete->DO_Piece = $do_piece;
            $docEntete->latitude = $latitude;
            $docEntete->longitude = $longitude;
            $docEntete->DO_Ref = $do_ref;
            if($typefac =="Transfert_confirmation") {
                $docEntete->DO_Coord02 = $do_tiers;
                $ctNum = new ComptetClass(0,$this->db);
                $docEntete->DO_Tiers = $ctNum->getfirstClientDivers();
            }
            else
                $docEntete->DO_Tiers = $do_tiers;

            $docEntete->CA_Num = $ca_num;
            $docEntete->DO_Date = $do_date;
            $docEntete->DO_DateLivr = '1900-01-01';
            $docEntete->DE_No = $depot;
            $docEntete->type_fac = $typefac;
            $docEntete->setValueMvt();
            $docEntete->setuserName("","");
            $docEntete = new DocEnteteClass($docEntete->insert_docEntete(),$this->db);
            $nextDO_Piece = $this->getEnteteDispo();
            $this->updateEnteteTable($nextDO_Piece);
        }
        return $docEntete;
    }

    public function getFactureByPieceTypeFac(){
        $query = "  SELECT  cbMarq
                    FROM    F_DOCENTETE
                    WHERE   DO_Type={$this->DO_Type} 
                    AND     DO_Domaine={$this->DO_Domaine} 
                    AND     DO_Piece='{$this->DO_Piece}'";
        $result= $this->db->query($query);
        foreach($result->fetchAll(PDO::FETCH_OBJ) as $res){
            return new DocEnteteClass($res->cbMarq);
        }
    }

    public function suppressionReglement(){
        $query= "DELETE 
                FROM F_CREGLEMENT 
                WHERE RG_No IN(SELECT RG_No
                                FROM F_REGLECH R
                                WHERE DO_PIECE='{$this->DO_Piece}' AND DO_Domaine={$this->DO_Domaine} AND DO_Type={$this->DO_Type});
                DELETE 
                FROM F_REGLECH 
                WHERE DO_PIECE='{$this->DO_Piece}' AND DO_Domaine={$this->DO_Domaine} AND DO_Type={$this->DO_Type};
                DELETE 
                FROM F_DOCREGL 
                WHERE DO_PIECE='{$this->DO_Piece}' AND DO_Domaine={$this->DO_Domaine} AND DO_Type={$this->DO_Type};
                DELETE
                FROM F_DOCENTETE
                WHERE DO_PIECE='{$this->DO_Piece}' AND DO_Domaine={$this->DO_Domaine} AND DO_Type={$this->DO_Type}";
        $this->db->requete($query);
    }


    public function getStatutAchat($type){
        return $this->getApiJson("/statutAchat&type=$type");
    }

    public function getStatutVente($type){
        return $this->getApiJson("/statutVente&type=$type");
    }

    public function addDocenteteEntreeProcess($do_date, $do_ref, $do_tiers, $ca_num, $longitude, $latitude){
        $this->setTypeFac("Entree");
        $do_piece=$this->getEnteteDocument(0);
        if($do_piece!="") {
            $this->updateEnteteTable(0);
            $docEntete = new DocEnteteClass(0);
            $docEntete->defaultValue();
            $docEntete->setValueMvtEntree();
            $docEntete->DO_Domaine = 2;
            $docEntete->DO_Type = 20;
            $docEntete->DO_Piece = $do_piece;
            $docEntete->latitude = $latitude;
            $docEntete->longitude = $longitude;
            $docEntete->DO_Ref = $do_ref;
            $docEntete->DO_Tiers = $do_tiers;
            $docEntete->CA_Num = $ca_num;
            $docEntete->DO_Date = $do_date;
            $docEntete->type_fac = "Entree";
            $docEntete->setValueMvt();
            $docEntete->setuserName("","");
            $docEntete->insert_docEntete();
            $nextDO_Piece = $this->getEnteteDispo();
            $this->updateEnteteTable($nextDO_Piece);
        }
            return $do_piece;
    }

    public function addDocenteteSortieProcess($do_date, $do_ref, $do_tiers, $ca_num, $longitude, $latitude){
        $this->setTypeFac("Sortie");
        $do_piece=$this->getEnteteDocument(0);
        $cbMarq=0;
        if($do_piece!="") {
            $docEntete = new DocEnteteClass(0);
            $docEntete->defaultValue();
            $docEntete->setValueMvtEntree();
            $docEntete->DO_Domaine = 2;
            $docEntete->DO_Type = 21;
            $docEntete->DO_Piece = $do_piece;
            $docEntete->latitude = $latitude;
            $docEntete->longitude =  $longitude;
            $docEntete->DO_Ref = $do_ref;
            $docEntete->DO_Tiers = $do_tiers;
            $docEntete->CA_Num = $ca_num;
            $docEntete->DO_Date = $do_date;
            $docEntete->DO_DateLivr = "1900-01-01";
            $docEntete->type_fac = "Sortie";
            $docEntete->setValueMvt();
            $docEntete->DO_Condition = 0;
            $docEntete->setuserName("","");
            $cbMarq = $docEntete->insert_docEntete();
            $nextDO_Piece = $this->getEnteteDispo();
            $this->updateEnteteTable($nextDO_Piece);
        }
        return $cbMarq;

    }

    public function getLigneTransfert_detail() {
        $query= "
                DECLARE @doPiece NVARCHAR(50) = '{$this->DO_Piece}'
                SELECT *
                FROM(
                SELECT L.cbMarq,A.AR_Ref,AR_Design AS DL_Design,P_Conditionnement,E.DO_Piece,E.cbDO_Piece, ROUND(DL_Qte*DL_CMUP,2) DL_MontantHT,DL_Ligne, ROUND(DL_Qte*DL_CMUP,2) DL_MontantTTC,DL_Qte
                ,DL_CMUP DL_PrixUnitaire,DL_CMUP,DL_Taxe1,DL_Taxe2,DL_Taxe3,0 AS DL_Remise
                FROM F_DOCENTETE E
                LEFT JOIN F_DOCLIGNE L 
                    on E.cbDO_Piece=L.cbDO_Piece 
                    AND E.DO_Domaine=L.DO_Domaine 
                   AND E.DO_Type= L.DO_Type
                INNER JOIN F_ARTICLE A 
                    ON L.AR_Ref=A.AR_Ref 
                LEFT JOIN P_CONDITIONNEMENT Co 
                    ON AR_Condition = Co.cbIndice
                INNER JOIN F_DEPOT DE 
                    ON DE.DE_No=E.DE_No 
                WHERE E.DO_Domaine=4 AND E.DO_Type=41 
                  AND E.DO_Piece=@doPiece)A 
                INNER JOIN(
                SELECT L.cbMarq AS idSec,A.AR_Ref AS AR_Ref_Dest,AR_Design AS DL_Design_Dest,P_Conditionnement as P_Conditionnement_Dest
                     ,E.cbDO_Piece AS DO_Piece_dest,ROUND(DL_Qte*DL_CMUP,2) AS DL_MontantHT_dest,ROUND(DL_Qte*DL_CMUP,2) AS DL_MontantTTC_dest
                     ,DL_Ligne AS DL_Ligne_dest,DL_Qte AS DL_Qte_dest
                ,DL_CMUP AS DL_PrixUnitaire_dest,DL_CMUP AS DL_CMUP_dest,0 AS DL_Remise_dest
                FROM F_DOCENTETE E
                LEFT JOIN F_DOCLIGNE L 
                    on E.cbDO_Piece=L.cbDO_Piece 
                    AND E.DO_Domaine=L.DO_Domaine 
                    AND E.DO_Type= L.DO_Type
                INNER JOIN F_ARTICLE A 
                    ON L.AR_Ref=A.AR_Ref 
                LEFT JOIN P_CONDITIONNEMENT Co 
                    ON AR_Condition = Co.cbIndice
                INNER JOIN F_DEPOT DE 
                    ON DE.DE_No=E.DE_No 
                WHERE E.DO_Domaine=4 AND E.DO_Type=40 AND E.DO_Piece=@doPiece) B 
                    ON A.cbDO_PIECE=B.DO_Piece_dest AND DL_Ligne=DL_Ligne_dest";
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }


    public function getDoPieceTrsftDetail(){
        $query = "SELECT *
                    FROM(
                    SELECT E.cbMarq, E.DO_Type,E.DO_Domaine,E.DO_Piece,E.DO_Ref,CAST(CAST(E.DO_Date AS DATE) AS VARCHAR(10)) AS DO_Date,E.DO_Tiers as CT_Num,E.DE_No,DE_Intitule
                    ,ISNULL(SUM(L.DL_Qte * DL_CMUP),0) AS ttc
                    FROM F_DOCENTETE E
                    LEFT JOIN F_DOCLIGNE L 
                        on E.cbDO_Piece=L.cbDO_Piece AND E.DO_Domaine= L.DO_Domaine AND E.DO_Type=L.DO_Type
                    INNER JOIN F_DEPOT DE ON DE.DE_No=E.DE_No 
                    WHERE E.DO_Domaine=4 AND E.DO_Type=41 AND E.DO_Piece ='{$this->DO_Piece}'
                    GROUP BY E.CbMarq,E.DO_Type,E.DO_Domaine,E.DO_Piece,E.DO_Ref,E.DO_Date,E.DO_Tiers,E.DE_No,DE_Intitule)A
                    LEFT JOIN(
                    SELECT E.DO_Type AS DO_Type_dest,E.DO_Domaine AS DO_Domaine_dest,E.DO_Piece AS DO_Piece_dest,E.DO_Ref AS DO_Ref_dest,
                    CAST(CAST(E.DO_Date AS DATE) AS VARCHAR(10)) AS DO_Date_dest,E.DO_Tiers as CT_Num_dest,E.DE_No AS DE_No_dest,DE_Intitule AS DE_Intitule_dest
                    ,ISNULL(SUM(L.DL_Qte * DL_CMUP),0) AS ttc_dest
                    FROM F_DOCENTETE E
                    LEFT JOIN F_DOCLIGNE L on E.DO_Piece=L.DO_Piece AND E.DO_Domaine= L.DO_Domaine AND E.DO_Type=L.DO_Type
                    INNER JOIN F_DEPOT DE ON DE.DE_No=E.DE_No 
                    WHERE E.DO_Domaine=4 AND E.DO_Type=40
                    GROUP BY E.DO_Type,E.DO_Domaine,E.DO_Piece,E.DO_Ref,E.DO_Date,E.DO_Tiers,E.DE_No,DE_Intitule) B ON A.DO_PIECE=B.DO_Piece_dest";
        $result = $this->db->query($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        foreach ($rows as $row){
            $this->DO_Type = $row->DO_Type;
            $this->DO_Domaine = $row->DO_Domaine;
            $this->DO_Piece = $row->DO_Piece;
            $this->DO_Ref = $row->DO_Ref;
            $this->DO_Tiers = $row->DE_No_dest;
            $this->DE_No = $row->DE_No;
            $this->DE_Intitule = $row->DE_Intitule;
            $this->DE_Intitule_dest = $row->DE_Intitule_dest;
            $this->ttc = $row->ttc;
        }
    }


    public function ajoutEntete($do_pieceG,$typeFacG,$doDate,$doDateEch,$affaireG,$client,$username,$mobile,$machine_pc,$doCoord1,$doCoord2,$doCoord3,$doCoord4,$doStatut,$latitude,$longitude,$de_no,$catTarif,$catCompta,$souche,$ca_no,$co_no,$reference,$transform=0){
        $DO_Coord01 = (isset($doCoord1) && $doCoord1!="") ? $doCoord1 : "";
        $DO_Coord02 = (isset($doCoord2)) ? $doCoord2 : "";
        $DO_Coord03 = (isset($doCoord3)) ? $doCoord3 : "";
        $DO_Coord04 = (isset($doCoord4)) ? $doCoord4 : "";
        $do_piece = (isset($do_pieceG)) ? $do_pieceG : "";
        $affaire = ($affaireG=="null" || $affaireG=="0") ? "" : $affaireG;
        $date_ech = (isset($doDateEch)) ? $doDateEch : $doDate;
        $user = (isset($username) && strcmp(trim($mobile),"android")) ? $username : "";
        $machine = (isset($machine_pc)) ? $machine_pc : "";
        $ca_no = ($ca_no=="") ? 0 : $ca_no;

        $url = "/ajoutEntete&protNo={$_SESSION["id"]}&doPiece={$this->formatString($do_piece)}&typeFacture=$typeFacG&doDate=$doDate&doSouche=$souche&caNum={$this->formatString($affaire)}&ctNum={$this->formatString($client)}&machineName={$this->formatString($machine_pc)}&doCoord01=$DO_Coord01&doCoord02=$DO_Coord02&doCoord03=$DO_Coord03&doCoord04=$DO_Coord04&doStatut=$doStatut&catTarif=$catTarif&catCompta=$catCompta&deNo=$de_no&caNo=$ca_no&coNo=$co_no&reference={$this->formatString($reference)}&longitude=$longitude&latitude=$latitude";
        $docEntete = $this->getApiJson($url);
        if(isset($docEntete[0]->message))
            return $docEntete[0]->message;

        $data = array('entete' => $docEntete[0]->DO_Piece,'cbMarq' => $docEntete[0]->cbMarq,'DO_Cours' => $docEntete[0]->DO_Cours);
        return $data;
    }


    public function isRegleFullDOPiece($cbMarq){
        $this->getApiExecute("/isRegleFullDOPiece&cbMarq=$cbMarq");
    }

    public function getListeReglementMajComptable($typeTransfert,$datedeb, $datefin,$caisse,$transfert,$journal){
        $typeValue = 0;
        if($typeTransfert == 4)
            $typeValue = 1;
        $compta=0;
        if($transfert == 1)
            $compta = 1;
        $query = "
                    DECLARE @datedeb DATE ='$datedeb'
                    DECLARE @datefin DATE ='$datefin'
                    DECLARE @caisse INT = $caisse
                    DECLARE @compta INT = $compta
                    DECLARE @typeValue INT = $typeValue
                    DECLARE @journal NVARCHAR(50) = $journal;        
                    DECLARE @protNo INT = {$_SESSION['id']};

                    DECLARE @typeFacture INT = 0;
                    DECLARE @typeFormat INT;
                    SELECT  @typeFormat = CASE WHEN @typeFacture = 1 THEN P_Piece01 ELSE P_Piece03 END 
                    FROM    P_PARAMETRECIAL;
                    DECLARE @pLigneNeg INT;
                    SELECT @pLigneNeg = P_LigneNeg FROM P_PARAMETRECIAL;
                  SELECT DISTINCT cre.RG_No
                    INTO #listCompta
                  FROM F_CREGLEMENT cre
                  LEFT JOIN F_REGLECH reg
                    ON cre.RG_No = reg.RG_No
                  WHERE cre.RG_Date BETWEEN @datedeb AND @datefin
                  AND (@caisse=0 OR cre.CA_No = @caisse)
                  AND (CASE WHEN @typeValue = 1 AND RG_Type = 1 THEN 1
                                WHEN @typeValue = 0 THEN 1 END) = 1
                  AND @compta = cre.RG_Compta 
                  AND cre.EC_No NOT IN (SELECT EC_No FROM F_ECRITUREC)
                  AND (CASE WHEN reg.RG_No IS NULL AND RG_Cloture = 1 THEN 1
                                WHEN reg.RG_No IS NOT NULL AND reg.DO_Domaine = @typeValue THEN 1 ELSE 0 END) = 1;
        WITH _ListRgltCompta_ AS (
                    SELECT *
                    FROM #listCompta
                )
        {$this->listEcritureCRglt()}

        {$this->insertEcritureRglt()}                        
        ";
        $result= $this->db->query($query);
    }
    public function getlistMajCompta (){
        return "WITH _Query_ AS (         
                SELECT	docE.cbMarq
                        ,docE.DO_Domaine
                        ,docE.DO_Type
                        ,docE.DO_Piece
                        ,RG_No
                        ,UniqueRG = ROW_NUMBER() OVER(PARTITION BY RG_No ORDER BY RG_No)
                        ,UniquecbMarq = ROW_NUMBER() OVER(PARTITION BY cbMarq ORDER BY cbMarq)
                        ,B.EC_No
                FROM	F_DOCENTETE docE
                LEFT JOIN (SELECT  fre.DO_Domaine,fre.DO_Type,fre.DO_Piece,fre.RG_No,EC_No = ISNULL(ecr.EC_No,0)
                            FROM    F_REGLECH fre
                            INNER JOIN F_CREGLEMENT fcre
                                ON fre.RG_No = fcre.RG_No
                            LEFT JOIN F_ECRITUREC ecr
                                ON ecr.EC_No = fcre.EC_No
                            GROUP BY fre.DO_Domaine,fre.DO_Type,fre.DO_Piece,fre.RG_No,ISNULL(ecr.EC_No,0))B 
                    ON	docE.DO_Domaine=B.DO_Domaine
                    AND docE.DO_Type=B.DO_Type
                    AND docE.DO_Piece=B.DO_Piece
                WHERE docE.DO_Domaine=@doDomaine AND docE.DO_Type=@doType
                AND DO_Date BETWEEN @dateDebut AND @dateFin
                AND (@doPieceDebut='' OR docE.DO_Piece>=@doPieceDebut)
                AND (@doPieceFin='' OR docE.DO_Piece<=@doPieceFin)
                AND (@doSouche=-1 OR DO_Souche=@doSouche)
                AND (@catCompta=0 OR N_CatCompta>=@catCompta)
                AND (@caisse=0 OR CA_No =@caisse)
                )
                ,_All_ AS (
                SELECT	cbMarq = CASE WHEN que.UniquecbMarq = 1 THEN que.cbMarq ELSE 0 END
                        ,que.DO_Domaine
                        ,que.DO_Type
                        ,que.DO_Piece
                        ,RG_No = CASE WHEN que.UniqueRG = 1 THEN que.RG_No ELSE 0 END
                        ,EC_No = CASE WHEN que.UniqueRG = 1 THEN que.EC_No ELSE 0 END
                        ,IsEcriture = CASE WHEN ecr.EC_RefPiece IS NOT NULL THEN 1 ELSE 0 END
                FROM	_Query_ que
                LEFT JOIN (SELECT DISTINCT EC_RefPiece FROM F_ECRITUREC) ecr
                    ON que.DO_Piece = ecr.EC_RefPiece 
                )
                
                SELECT  cbMarq
                        ,DO_Domaine
                        ,DO_Type
                        ,DO_Piece
                        ,RG_No
                        ,EC_No
                        ,IsEcriture
						into #listCompta
                FROM    _All_ ; ";
    }

    public function listEcritureCRglt(){
        return "
                , _ReglementCredit_ AS (
                    SELECT	cre.RG_No
                            ,CT_NumCont = CASE WHEN	doc.DO_Domaine IS NULL 
                                                AND cg.CG_Tiers = 0 THEN '' ELSE cre.CT_NumPayeur END
                            ,CT_Num = NULL
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
                                            THEN '1900-01-01' 
                                            ELSE CASE WHEN cgre.CG_Echeance = 1 THEN ISNULL(docR.DR_Date,cre.RG_Date) END	
                                            END
                            ,RG_Montant = CASE WHEN doc.DO_Domaine IS NOT NULL THEN
                                CASE WHEN doc.DO_Provenance IN (1,2) AND @pLigneNeg = 0 THEN 
                                    -cre.RG_Montant
                                    ELSE cre.RG_Montant END
                                    ELSE cre.RG_Montant END
                            ,N_Reglement = CASE WHEN doc.DO_Domaine IS NULL THEN 1 ELSE 0 END
                            ,cre.RG_Libelle
                            ,doc.CA_Num
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
                        ON co.cbCG_NumPrinc = cg.CG_Num
                    LEFT JOIN F_JOURNAUX jo
                        ON jo.JO_Num = cre.JO_Num
                    LEFT JOIN F_COMPTEG cgre 
                        ON cgre.CG_Num = CASE WHEN jo.CG_Num IS NOT NULL THEN jo.CG_Num ELSE cre.CG_Num END
                    WHERE cre.RG_No IN (SELECT RG_No FROM _ListRgltCompta_ )
                )
                
                ,_PreLettrageCredit_ AS (
                    SELECT	RG_No
                            ,CT_Num
                            ,CG_Num
                            ,RG_Date
                            ,JO_Num
                            ,Lettrage =(	SELECT	lettrage = ISNULL(MAX(EC_Lettrage),'A')
                                            FROM	F_ECRITUREC A
                                            WHERE   EC_Lettre=1
                                            AND		CT_Num = CT_Num
                                            AND		CG_Num = CG_Num 
                                            AND     CAST(DATEADD(DAY,A.EC_Jour-1,A.JM_Date) AS DATE) = RG_Date 
                                        )
                    FROM	_ReglementCredit_
                )
                ,_LettrageCredit_ AS (
                    SELECT	RG_No,Lettrage = CHAR(ASCII(Lettrage) +ROW_NUMBER() OVER (PARTITION BY JO_Num,CT_Num,CG_Num,RG_Date ORDER BY CT_Num,CG_Num,RG_Date)-1)
                    FROM	_PreLettrageCredit_
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
                                        CASE WHEN DO_Domaine = 0 AND ISNULL(CT_Num,'') <> '' THEN 
                                                CASE WHEN DO_Provenance IN (1,2) AND @pLigneNeg = 0 THEN 1 ELSE 0 END
                                             WHEN DO_Domaine = 1 AND ISNULL(CT_Num,'') = '' THEN 
                                                CASE WHEN DO_Provenance IN (1,2) AND @pLigneNeg = 0 THEN 0 ELSE 1 END
                                             WHEN RG_TypeReg = 4 THEN 1
                                        ELSE 0 END 
                                    ELSE
                                        CASE WHEN RG_TypeReg=5 AND  @pLigneNeg = 0 THEN 1 
                                                WHEN RG_TypeReg=5 AND  @pLigneNeg = 1 THEN 0
                                                WHEN RG_TypeReg=4 AND  @pLigneNeg = 0 THEN 0
                                                WHEN RG_TypeReg=4 AND  @pLigneNeg = 1 THEN 1 ELSE 0 END
                                    END
                        ,EC_Lettrage = ''/*(SELECT Lettrage FROM _LettrageCredit_)*/
                        ,CG_NumCont
                        ,CT_Num
                        ,CT_NumCont
                        ,EC_Intitule = RG_Libelle
                        ,N_Reglement
                        ,EC_Echeance	
                        ,TA_Code =NULL
                        ,RG_Montant
                        ,RG_No
                        ,RG_TypeReg
                        ,CA_Num
                FROM _ReglementCredit_
                )
                ,_Reglement_ AS (
                    SELECT	cre.RG_No
                            ,CT_Num = CASE WHEN cre.RG_TypeReg NOT IN (4,5) 
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
                                        THEN '1900-01-01' 
                                      ELSE CASE WHEN cgre.CG_Echeance = 1 THEN ISNULL(docR.DR_Date,RG_Date) END
                                        END	
                            ,RG_Montant = CASE WHEN doc.DO_Domaine IS NOT NULL THEN
                                CASE WHEN doc.DO_Provenance IN (1,2) AND @pLigneNeg = 0 THEN 
                                    -cre.RG_Montant
                                    ELSE cre.RG_Montant END
                                    ELSE cre.RG_Montant END
                            ,N_Reglement = CASE WHEN doc.DO_Domaine IS NULL THEN 1 ELSE 0 END
                            ,cre.RG_Libelle
                            ,doc.CA_Num
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
                    LEFT JOIN F_COMPTEG cgre
                        ON cgre.CG_Num = CASE WHEN cre.RG_TypeReg NOT IN (4,5) AND doc.DO_Domaine IS NULL 
                                        THEN CASE WHEN co.CG_NumPrinc IS NOT NULL THEN cg.CG_Num ELSE '' END 
                                        ELSE cre.CG_Num END
                    WHERE cre.RG_No IN (SELECT RG_No FROM _ListRgltCompta_)
                )
                ,_PreLettrage_ AS (
                    SELECT	RG_No
                            ,CT_Num
                            ,CG_Num
                            ,RG_Date
                            ,JO_Num
                            ,Lettrage =(	SELECT	lettrage = ISNULL(MAX(EC_Lettrage),'A')
                                            FROM	F_ECRITUREC A
                                            WHERE   EC_Lettre=1
                                            AND		CT_Num = CT_Num
                                            AND		CG_Num = CG_Num 
                                            AND     CAST(DATEADD(DAY,A.EC_Jour-1,A.JM_Date) AS DATE) = RG_Date 
                                        )
                    FROM	_Reglement_
                )
                ,_Lettrage_ AS (
                    SELECT	RG_No,Lettrage = CHAR(ASCII(Lettrage) +ROW_NUMBER() OVER (PARTITION BY JO_Num,CT_Num,CG_Num,RG_Date ORDER BY CT_Num,CG_Num,RG_Date)-1)
                    FROM	_PreLettrage_
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
                                        CASE WHEN RG_TypeReg=5 AND  @pLigneNeg = 0 THEN 0 
                                                WHEN RG_TypeReg=5 AND  @pLigneNeg = 1 THEN 1
                                                WHEN RG_TypeReg=4 AND  @pLigneNeg = 0 THEN 1
                                                WHEN RG_TypeReg=4 AND  @pLigneNeg = 1 THEN 0 ELSE 0 END
                                    END
                        ,EC_Lettrage = ISNULL(Lettrage,'A')
                        ,CG_NumCont = NULL
                        ,CT_Num
                        ,CT_NumCont = NULL
                        ,EC_Intitule = RG_Libelle
                        ,N_Reglement
                        ,EC_Echeance	
                        ,TA_Code = NULL
                        ,RG_Montant
                        ,reg.RG_No
                        ,RG_TypeReg
                        ,CA_Num
                FROM _Reglement_ reg
                LEFT JOIN _Lettrage_ let
                    ON reg.RG_No = let.RG_No
                )
                ,_Union_ AS (
                SELECT	Ligne = CASE WHEN RG_TypeReg IN (4,5) THEN 1 ELSE 0 END
                        ,RG_No
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
                        ,TA_Code =NULL
                        ,RG_TypeReg
                        ,CA_Num
                FROM	_PreSource_
                UNION
                SELECT	Ligne = CASE WHEN RG_TypeReg IN (4,5) THEN 2 ELSE 1 END
                        ,RG_No
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
                        ,TA_Code = NULL
                        ,RG_TypeReg
                        ,CA_Num
                FROM	_PreSourceCredit_
                )
                ,_Result_ AS (
                SELECT *
                FROM _Union_
                )
                ,_ListFacture_ AS (
                    SELECT L.DO_Piece,C.RG_No  
                    FROM F_CREGLEMENT C
                    INNER JOIN F_REGLECH R 
                        ON C.RG_No=R.RG_No 
                    LEFT JOIN F_DOCENTETE E 
                        ON R.DO_Piece=E.DO_Piece  
                        AND R.DO_Domaine= E.DO_Domaine 
                        AND R.DO_Type=E.DO_Type
                    LEFT JOIN F_DOCLIGNE L 
                        ON	R.DO_Piece=L.DO_Piece  
                        AND R.DO_Domaine= L.DO_Domaine 
                        AND R.DO_Type=L.DO_Type
                    LEFT JOIN F_COMPTET CO 
                        ON CO.CT_Num=L.CT_Num
                    LEFT JOIN F_DEPOT D 
                        ON D.DE_No=(CASE WHEN L.DE_No=0 THEN E.DE_No ELSE L.DE_No END)
                    WHERE C.RG_No IN (SELECT DISTINCT RG_No FROM _Result_)
                    GROUP BY L.DO_Piece,C.RG_No  
                    UNION
                    SELECT '' AS DO_Piece,A.RG_No
                    FROM [dbo].[Z_RGLT_BONDECAISSE] A
                    INNER JOIN F_CREGLEMENT B ON A.RG_No=B.RG_No
                    WHERE RG_No_RGLT IN (SELECT DISTINCT RG_No FROM _Result_)
                )
                SELECT JM_Date = CAST(Annee_Exercice+'01' AS DATE)
                        ,re.JO_Num
                        ,DO_Piece
                        ,re.Ligne
                        ,re.RG_No
                        ,re.nomFichier
                        ,re.Annee_Exercice
                        ,re.EC_Jour
                        ,re.EC_RefPiece
                        ,re.EC_Reference
                        ,re.CG_Num
                        ,re.TA_Provenance
                        ,re.EC_StatusRegle
                        ,re.EC_MontantRegle
                        ,re.EC_Sens
                        ,re.EC_Lettrage
                        ,re.CG_NumCont
                        ,re.CT_Num
                        ,re.CT_NumCont
                        ,re.EC_Intitule
                        ,re.N_Reglement
                        ,re.EC_Echeance
                        ,re.EC_MontantCredit
                        ,re.EC_MontantDebit
                        ,re.EC_Montant
                        ,re.TA_Code
                        ,re.CA_Num
						into #tmpInsertRglt
                FROM _Result_ re
                LEFT JOIN _ListFacture_ lf
                    ON re.RG_No = lf.RG_No;	
                
                
           
        WITH _journalTypeUn_ AS (
        SELECT JM_Date = CAST(Annee_Exercice+'01' AS DATE)
                ,tmp.JO_Num,DO_Piece,tmp.Ligne
                ,tmp.RG_No,tmp.nomFichier,tmp.Annee_Exercice,tmp.EC_Jour
                ,tmp.EC_RefPiece,tmp.EC_Reference,tmp.CG_Num,tmp.TA_Provenance
                ,tmp.EC_StatusRegle,tmp.EC_MontantRegle,tmp.EC_Sens,tmp.EC_Lettrage
                ,tmp.CG_NumCont,tmp.CT_Num,tmp.CT_NumCont,tmp.EC_Intitule
                ,tmp.N_Reglement,tmp.EC_Echeance,tmp.EC_MontantCredit,tmp.EC_MontantDebit
                ,tmp.EC_Montant,tmp.TA_Code
                ,EC_Piece = ISNULL(EC_Piece,0) + DENSE_RANK() OVER (PARTITION BY tmp.JO_Num ORDER BY tmp.EC_RefPiece) 
                ,tmp.CA_Num
        FROM #tmpInsertRglt tmp
        INNER JOIN F_JOURNAUX jou
            ON tmp.JO_Num = jou.JO_Num
        LEFT JOIN (SELECT JO_Num, EC_Piece = MAX(TRY_CAST(EC_Piece AS INT)) FROM F_ECRITUREC GROUP BY JO_Num) ecr
            ON tmp.JO_Num = ecr.JO_Num
        WHERE JO_NumPiece = 1
        AND @typeFormat = 1
        ), _journalTypeDeux_ AS (
        SELECT JM_Date = CAST(Annee_Exercice+'01' AS DATE)
                ,tmp.JO_Num,DO_Piece,tmp.Ligne
                ,tmp.RG_No,tmp.nomFichier,tmp.Annee_Exercice,tmp.EC_Jour
                ,tmp.EC_RefPiece,tmp.EC_Reference,tmp.CG_Num,tmp.TA_Provenance
                ,tmp.EC_StatusRegle,tmp.EC_MontantRegle,tmp.EC_Sens,tmp.EC_Lettrage
                ,tmp.CG_NumCont,tmp.CT_Num,tmp.CT_NumCont,tmp.EC_Intitule
                ,tmp.N_Reglement,tmp.EC_Echeance,tmp.EC_MontantCredit,tmp.EC_MontantDebit
                ,tmp.EC_Montant,tmp.TA_Code
                ,EC_Piece = ISNULL((SELECT	EC_Piece = ISNULL(MAX(TRY_CAST(EC_Piece AS INT)),0) + 1
                                                                FROM	F_ECRITUREC 
                                                                WHERE   TRY_CAST(EC_Piece AS INT) IS NOT NULL),0) + DENSE_RANK() OVER (PARTITION BY tmp.JO_Num ORDER BY tmp.EC_RefPiece) 
                ,tmp.CA_Num 
        FROM #tmpInsertRglt tmp
        INNER JOIN F_JOURNAUX jou
            ON tmp.JO_Num = jou.JO_Num
        WHERE JO_NumPiece = 2
        AND @typeFormat = 1
        )
        ,_journalTypeTrois_ AS (
        SELECT  JM_Date = CAST(Annee_Exercice+'01' AS DATE)
                ,tmp.JO_Num,DO_Piece,tmp.Ligne
                ,tmp.RG_No,tmp.nomFichier,tmp.Annee_Exercice,tmp.EC_Jour
                ,tmp.EC_RefPiece,tmp.EC_Reference,tmp.CG_Num,tmp.TA_Provenance
                ,tmp.EC_StatusRegle,tmp.EC_MontantRegle,tmp.EC_Sens,tmp.EC_Lettrage
                ,tmp.CG_NumCont,tmp.CT_Num,tmp.CT_NumCont,tmp.EC_Intitule
                ,tmp.N_Reglement,tmp.EC_Echeance,tmp.EC_MontantCredit,tmp.EC_MontantDebit
                ,tmp.EC_Montant,tmp.TA_Code
                ,EC_Piece = ISNULL(EC_Piece,0) + DENSE_RANK() OVER (PARTITION BY tmp.JO_Num ORDER BY tmp.RG_No)  
                ,tmp.CA_Num
        FROM #tmpInsertRglt tmp
        INNER JOIN F_JOURNAUX jou
            ON tmp.JO_Num = jou.JO_Num
        LEFT JOIN (SELECT JO_Num,JM_Date, EC_Piece = ISNULL(MAX(TRY_CAST(EC_Piece AS INT)),0) FROM F_ECRITUREC GROUP BY JO_Num,JM_Date) ecr
            ON	tmp.JO_Num = ecr.JO_Num
            AND CAST(tmp.Annee_Exercice+'01' AS DATE) = ecr.JM_Date 
        WHERE JO_NumPiece = 3
        AND @typeFormat = 1
        )
        ,_journalTypeFormat_ AS (
        SELECT  JM_Date = CAST(Annee_Exercice+'01' AS DATE)
                ,tmp.JO_Num,DO_Piece,tmp.Ligne
                ,tmp.RG_No,tmp.nomFichier,tmp.Annee_Exercice,tmp.EC_Jour
                ,tmp.EC_RefPiece,tmp.EC_Reference,tmp.CG_Num,tmp.TA_Provenance
                ,tmp.EC_StatusRegle,tmp.EC_MontantRegle,tmp.EC_Sens,tmp.EC_Lettrage
                ,tmp.CG_NumCont,tmp.CT_Num,tmp.CT_NumCont,tmp.EC_Intitule
                ,tmp.N_Reglement,tmp.EC_Echeance,tmp.EC_MontantCredit,tmp.EC_MontantDebit
                ,tmp.EC_Montant,tmp.TA_Code
                ,EC_Piece = DO_Piece 
                ,tmp.CA_Num
        FROM #tmpInsertRglt tmp
        INNER JOIN F_JOURNAUX jou
            ON tmp.JO_Num = jou.JO_Num
        LEFT JOIN (SELECT JO_Num,JM_Date, EC_Piece = ISNULL(MAX(TRY_CAST(EC_Piece AS INT)),0) FROM F_ECRITUREC GROUP BY JO_Num,JM_Date) ecr
            ON	tmp.JO_Num = ecr.JO_Num
            AND CAST(tmp.Annee_Exercice+'01' AS DATE) = ecr.JM_Date 
        WHERE JO_NumPiece = 3
        AND @typeFormat = 0
        )
        ,_UnionEcriture_ AS 
        (
            SELECT Ligne,nomFichier,JO_Num,Annee_Exercice
                ,EC_Jour,EC_RefPiece,EC_Reference,CG_Num,RG_No
                ,TA_Provenance,EC_StatusRegle,EC_MontantRegle,EC_Sens
                ,EC_Lettrage,CG_NumCont,CT_Num,CT_NumCont
                ,EC_Intitule,N_Reglement,EC_Echeance,EC_MontantCredit
                ,EC_MontantDebit,EC_Montant,TA_Code
                ,EC_Piece,CA_Num
                FROM _journalTypeUn_
            UNION
            
            SELECT Ligne,nomFichier,JO_Num,Annee_Exercice
                ,EC_Jour,EC_RefPiece,EC_Reference,CG_Num,RG_No
                ,TA_Provenance,EC_StatusRegle,EC_MontantRegle,EC_Sens
                ,EC_Lettrage,CG_NumCont,CT_Num,CT_NumCont
                ,EC_Intitule,N_Reglement,EC_Echeance,EC_MontantCredit
                ,EC_MontantDebit,EC_Montant,TA_Code
                ,EC_Piece,CA_Num
                FROM _journalTypeDeux_
            UNION
            
            SELECT Ligne,nomFichier,JO_Num,Annee_Exercice
                ,EC_Jour,EC_RefPiece,EC_Reference,CG_Num,RG_No
                ,TA_Provenance,EC_StatusRegle,EC_MontantRegle,EC_Sens
                ,EC_Lettrage,CG_NumCont,CT_Num,CT_NumCont
                ,EC_Intitule,N_Reglement,EC_Echeance,EC_MontantCredit
                ,EC_MontantDebit,EC_Montant,TA_Code
                ,EC_Piece,CA_Num
                FROM _journalTypeTrois_
            UNION
            
            SELECT Ligne,nomFichier,JO_Num,Annee_Exercice
                ,EC_Jour,EC_RefPiece,EC_Reference,CG_Num,RG_No
                ,TA_Provenance,EC_StatusRegle,EC_MontantRegle,EC_Sens
                ,EC_Lettrage,CG_NumCont,CT_Num,CT_NumCont
                ,EC_Intitule,N_Reglement,EC_Echeance,EC_MontantCredit
                ,EC_MontantDebit,EC_Montant,TA_Code
                ,EC_Piece,CA_Num
                FROM _journalTypeFormat_
        )
        SELECT  *
                ,EC_No = (SELECT Max(EC_No) FROM F_ECRITUREC)+ROW_NUMBER() OVER (
                                        ORDER BY RG_No)
                ,JM_Date = CAST(Annee_Exercice+'01' AS DATE) 
            INTO #tmpEcritureCRglt 
        FROM    _UnionEcriture_
        WHERE   (@journal = '0' OR JO_Num = @journal);";
    }

    public function insertEcritureRglt(){
        return "INSERT INTO [F_JMOUV] 
                       ([JO_Num],[JM_Date],[JM_Cloture],[JM_Impression]
                       ,[JM_DateCloture],[cbProt],[cbCreateur],[cbModification]
                       ,[cbReplication],[cbFlag])
            SELECT	DISTINCT JO_Num,JM_Date,0,0,'1900-01-01',0,@protNo,GETDATE(),0,0
            FROM	#tmpEcritureCRglt
            WHERE	NOT EXISTS (SELECT 1 
                                FROM F_JMOUV 
                                WHERE F_JMOUV.JO_Num =  #tmpEcritureCRglt.JO_Num 
                                AND F_JMOUV.JM_Date =  #tmpEcritureCRglt.JM_Date)
            ;

            
            INSERT INTO F_ECRITUREC ([JO_Num],[EC_No],[EC_NoLink],[JM_Date]
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
		   
		SELECT	JO_Num,EC_No,0,JM_Date
				,EC_Jour,CAST(GETDATE() AS DATE),EC_Piece,EC_RefPiece
				,'',CG_Num,CG_NumCont,CT_Num
				,LEFT(EC_Intitule,35),N_Reglement,EC_Echeance,0
				,0,0,EC_Sens,EC_Montant = ROUND(EC_Montant,2)
				,0,EC_Lettrage,0,''
				,0,0,0,0
				,CT_NumCont,0,'',0,0,0,0,0,TA_Code,0,TA_Provenance,0,'1900-01-01','1900-01-01','1900-01-01',EC_Reference
				,EC_StatusRegle,EC_MontantRegle,CASE WHEN EC_StatusRegle = 2 THEN DATEADD(DAY,EC_Jour-1,CAST(JM_Date AS DATE)) ELSE '1900-01-01' END,0,'1900-01-01',0,0,@protNo,GETDATE()
				,0,0
		FROM #tmpEcritureCRglt
		WHERE   ISNULL(EC_Montant,0) <> 0
        AND     ISNULL(JO_Num,'') <>''
        AND     ISNULL(CG_Num,'') <>'' 
        ORDER BY EC_No;
        

        IF (SELECT P_Analytique FROM P_PARAMETRECIAL) = 2 
        BEGIN
            INSERT INTO [F_ECRITUREA]
                        ([EC_No],[N_Analytique],[EA_Ligne],[CA_Num],[EA_Montant],[EA_Quantite]
                        ,[cbProt],[cbCreateur],[cbModification],[cbReplication],[cbFlag])
            SELECT	ec.EC_No,cpta.N_Analytique,1,ec.CA_Num,ec.EC_Montant,0,0,@protNo,GETDATE(),0,0
            FROM	#tmpEcritureCRglt ec
            LEFT JOIN F_COMPTEG cg
                ON	cg.CG_Num= ec.CG_Num
            LEFT JOIN F_COMPTEA cpta
                ON	cpta.CA_Num = ec.CA_Num
            WHERE	cg.CG_Analytique=1
            ORDER BY ec.RG_No;

        END; 

        UPDATE  F_CREGLEMENT 
                SET EC_No=#tmpEcritureCRglt.EC_No
                    ,RG_Compta=1 
        FROM    #tmpEcritureCRglt
        WHERE   #tmpEcritureCRglt.RG_No = F_CREGLEMENT.RG_No
	    AND     #tmpEcritureCRglt.CG_Num = F_CREGLEMENT.CG_Num;";
    }

    public function majComptaRglt($datedeb,$datefin,$dopieceDebut,$doPieceFin,$doDomaine,$doType,$doSouche,$catCompta,$caisse,$journal){

        $query ="
        DECLARE @rgNo AS INT
        DECLARE @pLigneNeg INT;
        DECLARE @rgTypeReg INT;
        DECLARE @typeFacture INT = 0;
        DECLARE @typeFormat INT;
        DECLARE @protNo INT = {$_SESSION['id']};
        SELECT  @typeFormat = CASE WHEN @typeFacture = 1 THEN P_Piece01 ELSE P_Piece03 END 
        FROM    P_PARAMETRECIAL;
        DECLARE @dateDebut DATE = '$datedeb' 
        DECLARE @dateFin DATE = '$datefin' 
        DECLARE @doPieceDebut NVARCHAR(50) ='$dopieceDebut' 
        DECLARE @doPieceFin NVARCHAR(50) ='$doPieceFin' 
        DECLARE @doDomaine INT = $doDomaine 
        DECLARE @doType INT = $doType 
        DECLARE @doSouche INT = $doSouche
        DECLARE @catCompta INT = $catCompta
        DECLARE @caisse INT = $caisse
        DECLARE @journal NVARCHAR(50) = '$journal'
        ;
        
        SELECT @pLigneNeg = P_LigneNeg FROM P_PARAMETRECIAL;
        DROP TABLE IF EXISTS #listCompta;
        DROP TABLE IF EXISTS #tmpInsertRglt;
        DROP TABLE IF EXISTS #tmpEcritureCRglt;
        DROP TABLE IF EXISTS #tmpEcritureCFacture;
        DROP TABLE IF EXISTS #tmpAllEcritureFacture;
        
        {$this->getlistMajCompta()}                
        
        WITH _ListRgltCompta_ AS (
                    SELECT *
                    FROM #listCompta
                    WHERE RG_No <> 0 AND EC_No = 0
                )
        {$this->listEcritureCRglt()}

        {$this->insertEcritureRglt()}
        
        {$this->listEcritureCFacture()}
        
        {$this->InsertecritureCFacture()}
        ";

        return $this->db->query($query);

    }

    public function listEcritureCFacture(){
        return "WITH _ListCompta_ AS (
                SELECT *
                FROM #listCompta
                WHERE IsEcriture=0 
                AND cbMarq<>0
                )
                ,_MontantRegle_ AS (
                    SELECT  ROUND(ISNULL(SUM(DL_MontantTTC),0),2) montantRegle,e.cbMarq
                    FROM    F_DOCENTETE E                    
                    LEFT JOIN F_DOCLIGNE D 
                        ON  E.cbDO_Piece = D.cbDO_Piece		
                        AND E.DO_Domaine = D.DO_Domaine 
                        AND E.DO_Type = D.DO_Type
                    WHERE   E.cbMarq IN (SELECT cbMarq FROM _ListCompta_)
                    GROUP BY e.cbMarq
                )
                ,_Avance_ AS (
                SELECT    ROUND(ISNULL(SUM(RC_Montant),0),2) avance_regle,e.cbMarq
                FROM    F_DOCENTETE E                    
                LEFT JOIN F_REGLECH D 
                    ON  E.cbDO_Piece = D.cbDO_Piece 
                    AND E.DO_Domaine = D.DO_Domaine 
                    AND E.DO_Type = D.DO_Type
                WHERE E.cbMarq  IN (SELECT cbMarq FROM _ListCompta_)
                GROUP BY e.cbMarq
                )
                
                ,_Taxe_ AS (
                    SELECT	T.TA_Code
                            ,T.cbTA_Code
                            ,T.CG_Num
                            ,C.CG_Tiers
                            ,T.TA_Provenance
                    FROM F_TAXE T
                    LEFT JOIN F_COMPTEG C 
                        ON T.cbCG_Num = C.cbCG_Num
                )
                ,_InfoTaxe_ AS (
                    SELECT  COMPTEG_ARTICLE = ISNULL(ACP_ComptaCPT_CompteG,FCP_ComptaCPT_CompteG) 
                        ,Cg.CG_Tiers CG_TiersArticle,CodeTaxe1 = TU.TA_Code,CG_NumTaxe1 = TU.CG_Num
                        ,CG_Tiers1 = TU.CG_Tiers,CodeTaxe2 = TD.TA_Code,CG_NumTaxe2 = TD.CG_Num,CG_Tiers2 = TD.CG_Tiers 
                        ,CodeTaxe3 = TT.TA_Code,CG_NumTaxe3 = TT.CG_Num,CG_Tiers3 = TT.CG_Tiers
                        ,TA_Provenance1 = TU.TA_Provenance
                        ,TA_Provenance2 = TD.TA_Provenance
                        ,TA_Provenance3 = TT.TA_Provenance
                        ,Art.AR_Ref
                        ,FCP_Champ
                        ,FCP_Type
                    FROM    F_ARTICLE Art 
                    LEFT JOIN F_FAMCOMPTA F 
                        ON  Art.cbFA_CodeFamille = F.cbFA_CodeFamille  
                    LEFT JOIN F_ARTCOMPTA A 
                        ON  A.cbAR_Ref = Art.cbAR_Ref 
                        AND ISNULL(ACP_Champ,FCP_Champ) =FCP_Champ 
                        AND ISNULL(ACP_Type,FCP_Type)=FCP_Type 
                    LEFT JOIN F_COMPTEG Cg 
                        ON  Cg.CG_Num = ISNULL(ACP_ComptaCPT_CompteG,FCP_ComptaCPT_CompteG)
                    LEFT JOIN _Taxe_ TU 
                        ON TU.cbTA_Code = (CASE WHEN ISNULL(FCP_ComptaCPT_Taxe1,'')  <> ISNULL(ACP_ComptaCPT_Taxe1,'')AND ACP_ComptaCPT_Taxe1 IS NOT NULL THEN
                                            ACP_ComptaCPT_Taxe1 ELSE FCP_ComptaCPT_Taxe1 END)
                    LEFT JOIN _Taxe_ TD 
                        ON TD.cbTA_Code = (CASE WHEN ISNULL(FCP_ComptaCPT_Taxe2,'')  <> ISNULL(ACP_ComptaCPT_Taxe2,'')  AND ACP_ComptaCPT_Taxe2 IS NOT NULL THEN 
                                                ACP_ComptaCPT_Taxe2 ELSE FCP_ComptaCPT_Taxe2 END) 
                    LEFT JOIN _Taxe_ TT 
                        ON TT.cbTA_Code = (CASE WHEN ISNULL(FCP_ComptaCPT_Taxe3,'')  <> ISNULL(ACP_ComptaCPT_Taxe3,'')  AND ACP_ComptaCPT_Taxe3 IS NOT NULL THEN 
                                    ACP_ComptaCPT_Taxe3 ELSE FCP_ComptaCPT_Taxe3 END) 
                )
                ,_docEntete_ AS (
                    SELECT	docE.CA_Num
                            ,docE.DO_Domaine
                            ,docE.DO_Piece
                            ,nomFichier =''
                            ,JO_Num = CASE WHEN docE.DO_Domaine = 0 THEN 
                                                (SELECT JO_Num 
                                                FROM P_SOUCHEVENTE 
                                                WHERE S_Intitule<>'' AND S_Valide=1 AND cbIndice-1 = docE.DO_Souche)
                                            ELSE 
                                                (SELECT JO_Num  
                                                FROM P_SOUCHEACHAT 
                                                WHERE S_Intitule<>'' AND S_Valide=1 AND cbIndice-1 = docE.DO_Souche)
                                        END
                            ,docE.DO_Date
                            ,Annee_Exercice = CAST(YEAR(docE.DO_Date) AS NVARCHAR(10)) + RIGHT('0'+ CAST(MONTH(docE.DO_Date) AS NVARCHAR(10)),2)
                            ,EC_Jour = DAY(docE.DO_Date)
                            ,EC_RefPiece = docE.DO_Piece
                            ,EC_Reference = docE.DO_Ref
                            ,CG_Num  = ISNULL(cptT.CG_NumPrinc,'')
                            ,EC_Sens =	CASE WHEN docE.DO_Domaine = 0 AND cptT.CT_Num IS NULL THEN 
                                                    CASE WHEN docE.DO_Provenance IN (2) AND @pLigneNeg = 1 THEN 0 ELSE 1 END
                                             WHEN docE.DO_Domaine = 1 AND cptT.CT_Num IS NOT NULL THEN 
                                                    CASE WHEN DO_Provenance IN (2) AND @pLigneNeg = 1 THEN 0 ELSE 1 END
                                        ELSE 
                                            CASE WHEN DO_Provenance IN (2) AND @pLigneNeg = 1 THEN 1 ELSE 0 END
                                        END
                            ,EC_StatusRegle = CASE WHEN abs(mor.montantRegle - ava.avance_regle)<5 THEN 2 ELSE 0 END
                            ,EC_MontantRegle = CASE WHEN ava.avance_regle<>0 THEN ava.avance_regle ELSE 0 END
                            ,MontantRegle = CASE WHEN DO_Provenance IN (1,2) AND @pLigneNeg = 0 THEN 
                                                    -mor.MontantRegle
                                                    ELSE mor.MontantRegle END
                            ,TA_Provenance = 0
                            ,CG_NumCont= ISNULL(infT.COMPTEG_ARTICLE,'')
                            ,CT_Num = docE.DO_Tiers
                            ,CT_NumCont = NULL
                            ,EC_Intitule = 'fact '+compt.CT_Intitule
                            ,N_Reglement = 1
                            ,EC_Echeance = docR.DR_Date
                            ,TA_Code = NULL
                            ,CbMarq = docE.cbMarq
                            ,position = ROW_NUMBER() OVER (PARTITION BY docE.DO_Piece ORDER BY infT.COMPTEG_ARTICLE DESC)
                        FROM F_DOCENTETE docE
                        LEFT JOIN F_COMPTET compt
                            ON  compt.CT_Num = docE.DO_Tiers
                        LEFT JOIN F_DOCREGL docR
                            ON	docR.DO_Domaine = docE.DO_Domaine
                            AND	docR.DO_Type = docE.DO_Type
                            AND	docR.cbDO_Piece = docE.cbDO_Piece
                        LEFT JOIN F_DOCLIGNE docL
                            ON	docL.DO_Domaine = docE.DO_Domaine
                            AND	docL.DO_Type = docE.DO_Type
                            AND	docL.cbDO_Piece = docE.cbDO_Piece
                        LEFT JOIN _InfoTaxe_ infT
                            ON	infT.FCP_Champ=docE.N_CatCompta 
                            AND infT.FCP_Type=docE.DO_Domaine
                            AND infT.AR_Ref=docL.AR_Ref
                        LEFT JOIN _Avance_ ava
                            ON ava.cbMarq = docE.cbMarq
                        LEFT JOIN _MontantRegle_ mor
                            ON mor.cbMarq = docE.cbMarq
                        LEFT JOIN F_COMPTET cptT
                            ON	docE.cbDO_Tiers = cptT.cbCT_Num
                        WHERE docE.cbMarq IN (SELECT cbMarq FROM _ListCompta_)
                )
                ,_PreLettrage_ AS (
                    SELECT	cbMarq
                            ,CT_Num
                            ,CG_Num
                            ,DO_Date
                            ,Lettrage =(	SELECT	lettrage = ISNULL(MAX(EC_Lettrage),'A')
                                            FROM	F_ECRITUREC A
                                            WHERE   EC_Lettre=1
                                            AND		CT_Num = CT_Num
                                            AND		CG_Num = CG_Num 
                                            AND     CAST(DATEADD(DAY,A.EC_Jour-1,A.JM_Date) AS DATE) = DO_Date 
                                        )
                    FROM	(SELECT DISTINCT cbMarq,CT_Num,CG_Num,DO_Date FROM _docEntete_) A
                )
                ,_Lettrage_ AS (
                    SELECT	cbMarq,Lettrage = CHAR(ASCII(Lettrage) +ROW_NUMBER() OVER (PARTITION BY CT_Num,CG_Num,DO_Date ORDER BY CT_Num,CG_Num,DO_Date)-1)
                    FROM	_PreLettrage_
                )
                ,_docLigne_ AS (
                    SELECT	nomFichier =''
                            ,JO_Num = CASE WHEN docE.DO_Domaine = 0 THEN 
                                                (SELECT JO_Num 
                                                FROM P_SOUCHEVENTE 
                                                WHERE S_Intitule<>'' AND S_Valide=1 AND cbIndice-1 = docE.DO_Souche)
                                            ELSE 
                                                (SELECT JO_Num  
                                                FROM P_SOUCHEACHAT 
                                                WHERE S_Intitule<>'' AND S_Valide=1 AND cbIndice-1 = docE.DO_Souche)
                                        END
                            ,docE.DO_Date
                            ,Annee_Exercice = CAST(YEAR(docE.DO_Date) AS NVARCHAR(10)) + RIGHT('0'+ CAST(MONTH(docE.DO_Date) AS NVARCHAR(10)),2)
                            ,EC_Jour = DAY(docE.DO_Date)
                            ,EC_RefPiece = docE.DO_Piece
                            ,EC_Reference = docE.DO_Ref
                            ,CG_Num=ISNULL(infT.COMPTEG_ARTICLE,'')
                            ,EC_Sens =	CASE WHEN docE.DO_Domaine = 0 THEN 
                                            CASE WHEN docE.DO_Provenance IN (2) AND @pLigneNeg = 1 THEN 0 ELSE 1 END
                                        ELSE 
                                            CASE WHEN DO_Provenance IN (2) AND @pLigneNeg = 1 THEN 1 ELSE 0 END
                                        END
                            ,EC_StatusRegle = 0
                            ,EC_MontantRegle = 0
                            ,MontantRegle = (CASE WHEN docE.DO_Provenance IN (1,2) AND @pLigneNeg = 0 THEN -1 ELSE 1 END) * docL.DL_MontantHT 
                            ,docL.DL_MontantTTC
                            ,TA_Provenance = ISNULL(infT.TA_Provenance1+1,0)
                            ,CG_NumCont  =  ISNULL(cptT.CG_NumPrinc,'')
                            ,CT_Num = NULL
                            ,CT_NumCont = ISNULL(docE.DO_Tiers,'')
                            ,EC_Intitule = 'fact '+compt.CT_Intitule
                            ,N_Reglement = 0
                            ,EC_Echeance = ''
                            ,TA_Code = infT.CodeTaxe1
                            ,cptT.CT_Lettrage
                            ,docL.AR_Ref
                            ,docE.N_CatCompta
                            ,docE.DO_Domaine
                            ,docE.DO_Type
                            ,docE.DO_Piece
                            ,docE.cbDO_Piece
                            ,CbMarq = docE.cbMarq
                            ,docE.DO_Provenance
                            ,CASE WHEN docL.DL_TypeTaux1=0 THEN docL.DL_MontantHT*(docL.DL_Taxe1/100) ELSE CASE WHEN docL.DL_TypeTaux1=1 THEN docL.DL_Taxe1*docL.DL_Qte ELSE docL.DL_Taxe1 END END MT_Taxe1
                            ,CASE WHEN docL.DL_TypeTaux2=0 THEN docL.DL_MontantHT*(docL.DL_Taxe2/100) ELSE CASE WHEN docL.DL_TypeTaux2=1 THEN docL.DL_Taxe2*docL.DL_Qte ELSE docL.DL_Taxe2 END END MT_Taxe2
                            ,CASE WHEN docL.DL_TypeTaux3=0 THEN docL.DL_MontantHT*(docL.DL_Taxe3/100) ELSE CASE WHEN docL.DL_TypeTaux3=1 THEN docL.DL_Taxe3*docL.DL_Qte ELSE docL.DL_Taxe3 END END MT_Taxe3
                            ,docE.CA_Num            
                        FROM F_DOCENTETE docE
                        LEFT JOIN F_COMPTET compt
                            ON  compt.CT_Num = docE.DO_Tiers
                        LEFT JOIN F_DOCLIGNE docL
                            ON	docL.DO_Domaine = docE.DO_Domaine
                            AND	docL.DO_Type = docE.DO_Type
                            AND	docL.cbDO_Piece = docE.cbDO_Piece
                        LEFT JOIN _Avance_ ava
                            ON ava.cbMarq = docE.cbMarq
                        LEFT JOIN _MontantRegle_ mor
                            ON mor.cbMarq = docE.cbMarq
                        LEFT JOIN F_COMPTET cptT
                            ON	docE.DO_Tiers = cptT.CT_Num
                        LEFT JOIN _InfoTaxe_ infT
                            ON	infT.FCP_Champ=docE.N_CatCompta 
                            AND infT.FCP_Type=docE.DO_Domaine
                            AND infT.AR_Ref=docL.AR_Ref
                        WHERE docE.cbMarq  IN (SELECT cbMarq FROM _ListCompta_)
                )
                ,_Ligne_ AS (
                    SELECT	CA_Num,nomFichier,JO_Num,DO_Date,Annee_Exercice,EC_Jour,EC_RefPiece
                            ,EC_Reference,CG_Num,EC_Sens,EC_StatusRegle,EC_MontantRegle
                            ,MontantRegle = CASE WHEN DR_Montant = 0 THEN MontantRegle - DR_MontantTotal ELSE DR_Montant END
                            ,DL_MontantTTC = CASE WHEN DR_Montant = 0 THEN DL_MontantTTC - DR_MontantTotal ELSE DR_Montant END
                            ,TA_Provenance
                            ,CG_NumCont,CT_Num,CT_NumCont,EC_Intitule,docL.N_Reglement
                            ,EC_Echeance,TA_Code,CT_Lettrage,N_CatCompta,docL.DO_Domaine
                            ,docL.DO_Type,docL.DO_Piece,docL.cbDO_Piece,docL.CbMarq
                            ,docR.DR_Montant
                            ,docR.DR_MontantTotal,docL.DO_Provenance
                    FROM	(SELECT CA_Num,nomFichier,JO_Num,DO_Date,Annee_Exercice,EC_Jour,EC_RefPiece
                            ,EC_Reference,CG_Num,EC_Sens,EC_StatusRegle,EC_MontantRegle
                            ,MontantRegle = SUM (MontantRegle),DL_MontantTTC = SUM(DL_MontantTTC),TA_Provenance
                            ,CG_NumCont,CT_Num,CT_NumCont,EC_Intitule,docL.N_Reglement
                            ,EC_Echeance,TA_Code,CT_Lettrage,N_CatCompta,docL.DO_Domaine
                            ,docL.DO_Type,docL.DO_Piece,docL.cbDO_Piece,docL.CbMarq,docL.DO_Provenance
                            
                            FROM _docLigne_ docL
                            GROUP BY CA_Num,nomFichier,JO_Num,DO_Date,Annee_Exercice,EC_Jour,EC_RefPiece
                            ,EC_Reference,CG_Num,EC_Sens,EC_StatusRegle,EC_MontantRegle
                            ,TA_Provenance
                            ,CG_NumCont,CT_Num,CT_NumCont,EC_Intitule,docL.N_Reglement
                            ,EC_Echeance,TA_Code,CT_Lettrage,N_CatCompta,docL.DO_Domaine,docL.DO_Provenance
                            ,docL.DO_Type,docL.DO_Piece,docL.cbDO_Piece,docL.CbMarq) docL
                    LEFT JOIN (SELECT DO_Domaine,DO_Type,cbDO_Piece,DR_Date,DR_Montant,DR_MontantTotal = SUM(DR_Montant) OVER (PARTITION BY DO_Domaine,DO_Type,cbDO_Piece)
                                FROM F_DOCREGL 
                                GROUP BY DO_Domaine,DO_Type,DR_Date,cbDO_Piece,DR_Montant) docR
                        ON	docR.DO_Domaine = docL.DO_Domaine
                        AND	docR.DO_Type = docL.DO_Type
                        AND	docR.cbDO_Piece = docL.cbDO_Piece
                )
                ,_PivotInfoTaxe_ AS (
                    SELECT COMPTEG_ARTICLE, Taxe, CodeTaxe,
                                CG_TiersArticle, CG_Tiers1
                                ,CG_Tiers2,CG_Tiers3,CG_NumTaxe1,CG_NumTaxe2,CG_NumTaxe3,TA_Provenance1
                                ,TA_Provenance2,TA_Provenance3,AR_Ref,FCP_Champ,FCP_Type
                    FROM   
                       (SELECT	COMPTEG_ARTICLE, CG_TiersArticle, CodeTaxe1,CodeTaxe2, CodeTaxe3, CG_Tiers1
                                ,CG_Tiers2,CG_Tiers3,CG_NumTaxe1,CG_NumTaxe2,CG_NumTaxe3,TA_Provenance1
                                ,TA_Provenance2,TA_Provenance3,AR_Ref,FCP_Champ,FCP_Type
                       FROM _InfoTaxe_) p  
                    UNPIVOT  
                       (CodeTaxe FOR Taxe IN   
                          (CodeTaxe1, CodeTaxe2, CodeTaxe3)  
                    )AS unpvt  
                )
                ,_LigneTaxe_ AS (
                
                        SELECT	DO_Domaine
                                ,DO_Piece
                                ,nomFichier
                                ,JO_Num
                                ,DO_Date
                                ,Annee_Exercice
                                ,EC_Jour
                                ,EC_RefPiece
                                ,EC_Reference
                                ,CG_Num
                                ,EC_Sens
                                ,EC_Lettrage 
                                ,EC_StatusRegle 
                                ,EC_MontantRegle
                                ,MontantRegle 
                                ,TA_Provenance
                                ,CG_NumCont
                                ,CT_Num
                                ,CT_NumCont
                                ,EC_Intitule
                                ,N_Reglement
                                ,EC_Echeance
                                ,TA_Code
                                ,EC_MontantCredit = ROUND(SUM(EC_MontantCredit),0)
                                ,EC_MontantDebit = ROUND(SUM(EC_MontantDebit),0)
                                ,CbMarq
                        FROM (
                        SELECT	docL.DO_Domaine
                                ,docL.DO_Piece
                                ,nomFichier =''
                                ,JO_Num
                                ,DO_Date
                                ,Annee_Exercice
                                ,EC_Jour
                                ,EC_RefPiece
                                ,EC_Reference
                                ,CG_Num = ISNULL(CASE WHEN Taxe ='CodeTaxe1' THEN infT.CG_NumTaxe1
                                                            WHEN Taxe ='CodeTaxe2' THEN infT.CG_NumTaxe2
                                                            WHEN Taxe ='CodeTaxe3' THEN infT.CG_NumTaxe3
                                                            END,'')
                                ,EC_Sens
                                ,EC_Lettrage = ''
                                ,EC_StatusRegle = 0
                                ,EC_MontantRegle = 0
                                ,MontantRegle = 0
                                ,TA_Provenance = ISNULL(CASE WHEN Taxe ='CodeTaxe1' THEN infT.TA_Provenance1+1
                                                            WHEN Taxe ='CodeTaxe2' THEN infT.TA_Provenance2+1
                                                            WHEN Taxe ='CodeTaxe3' THEN infT.TA_Provenance3+1
                                                            END,0)
                                ,CG_NumCont 
                                ,CT_Num
                                ,CT_NumCont
                                ,EC_Intitule
                                ,N_Reglement = 0
                                ,EC_Echeance = ''
                                ,TA_Code = CodeTaxe
                                ,EC_MontantCredit = (CASE WHEN docL.DO_Provenance IN (1,2) AND @pLigneNeg = 0 THEN -1 ELSE 1 END) * ROUND(CASE WHEN EC_Sens = 0 THEN 
                                                        ISNULL(CASE WHEN Taxe ='CodeTaxe1' THEN MT_Taxe1
                                                            WHEN Taxe ='CodeTaxe2' THEN MT_Taxe2
                                                            WHEN Taxe ='CodeTaxe3' THEN MT_Taxe3
                                                            END,0)
                                                             ELSE 0 END,2)
                                ,EC_MontantDebit =  (CASE WHEN docL.DO_Provenance IN (1,2) AND @pLigneNeg = 0 THEN -1 ELSE 1 END) * ROUND(CASE WHEN EC_Sens = 1 THEN 
                                                        ISNULL(CASE WHEN Taxe ='CodeTaxe1' THEN MT_Taxe1
                                                            WHEN Taxe ='CodeTaxe2' THEN MT_Taxe2
                                                            WHEN Taxe ='CodeTaxe3' THEN MT_Taxe3
                                                            END,0)
                                                             ELSE 0 END,2)
                                ,CbMarq = ''
                        FROM _docLigne_ docL
                        INNER JOIN _PivotInfoTaxe_ infT
                            ON	infT.FCP_Champ=docL.N_CatCompta 
                            AND infT.FCP_Type=docL.DO_Domaine
                            AND infT.AR_Ref=docL.AR_Ref
                            )A
                            GROUP BY 
                                DO_Piece
                                ,DO_Domaine
                                ,nomFichier
                                ,JO_Num
                                ,DO_Date
                                ,Annee_Exercice
                                ,EC_Jour
                                ,EC_RefPiece
                                ,EC_Reference
                                ,CG_Num
                                ,EC_Sens
                                ,EC_Lettrage 
                                ,EC_StatusRegle 
                                ,EC_MontantRegle
                                ,MontantRegle 
                                ,TA_Provenance
                                ,CG_NumCont
                                ,CT_Num
                                ,CT_NumCont
                                ,EC_Intitule
                                ,N_Reglement
                                ,EC_Echeance
                                ,TA_Code
                                ,CbMarq
                )
                ,_PreLettrageLigne_ AS (
                    SELECT	cbMarq
                            ,CT_Num
                            ,CG_Num
                            ,DO_Date
                            ,Lettrage =(	SELECT	lettrage = ISNULL(MAX(EC_Lettrage),'A')
                                            FROM	F_ECRITUREC A
                                            WHERE   EC_Lettre=1
                                            AND		CT_Num = CT_Num
                                            AND		CG_Num = CG_Num 
                                            AND     CAST(DATEADD(DAY,A.EC_Jour-1,A.JM_Date) AS DATE) = DO_Date 
                                        )
                    FROM	(SELECT DISTINCT cbMarq,CT_Num,CG_Num,DO_Date FROM _docLigne_) A
                )
                ,_LettrageLigne_ AS (
                    SELECT	cbMArq,Lettrage = CHAR(ASCII(Lettrage) +ROW_NUMBER() OVER (PARTITION BY CT_Num,CG_Num,DO_Date ORDER BY CT_Num,CG_Num,DO_Date)-1)
                    FROM	_PreLettrageLigne_
                )
                ,_ResultCpta_ AS (
                    SELECT	DO_Piece
                            ,CA_Num
                            ,DO_Domaine
                            ,docE.cbMarq
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
                            ,EC_Lettrage = lettrage
                            ,CG_NumCont
                            ,CT_Num
                            ,CT_NumCont
                            ,EC_Intitule
                            ,N_Reglement
                            ,EC_Echeance
                            ,EC_MontantCredit = CASE WHEN EC_Sens = 0 THEN (MontantRegle) ELSE 0 END
                            ,EC_MontantDebit = CASE WHEN EC_Sens = 1 THEN (MontantRegle) ELSE 0 END
                            ,TA_Code = NULL
                    FROM	_docEntete_ docE
                    LEFT JOIN _Lettrage_ let
                        ON docE.cbMarq =let.cbMarq
                    WHERE position = 1
                    UNION ALL
                    SELECT	DO_Piece
                            ,CA_Num = NULL
                            ,DO_Domaine
                            ,cbMarq
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
                            ,EC_MontantCredit
                            ,EC_MontantDebit
                            ,TA_Code
                    FROM	_LigneTaxe_
                
                    UNION ALL
                    SELECT	DO_Piece
                            ,CA_Num 
                            ,DO_Domaine
                            ,lig.cbMarq
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
                            ,EC_Lettrage = lettrage
                            ,CG_NumCont
                            ,CT_Num
                            ,CT_NumCont
                            ,EC_Intitule
                            ,N_Reglement
                            ,EC_Echeance
                            ,EC_MontantCredit = CASE WHEN EC_Sens = 0 THEN (MontantRegle) ELSE 0 END
                            ,EC_MontantDebit = CASE WHEN EC_Sens = 1 THEN (MontantRegle) ELSE 0 END
                            ,TA_Code
                    FROM _Ligne_ lig
                    LEFT JOIN _Lettrage_ let
                        ON lig.cbMarq =let.cbMarq
                )
                SELECT	DO_Piece
                        ,CA_Num
                        ,DO_Domaine
                        ,CbMarq
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
                        ,EC_MontantCredit
                        ,EC_MontantDebit
                        ,EC_Montant = EC_MontantCredit + EC_MontantDebit
                        ,TA_Code
                        INTO #tmpAllEcritureFacture
                FROM _ResultCpta_	;
                
                WITH _journalTypeUn_ AS (
                    SELECT CA_Num,DO_Domaine,tmp.CbMarq,nomFichier,tmp.JO_Num,Annee_Exercice
                            ,EC_Jour,EC_RefPiece,EC_Reference,tmp.CG_Num
                            ,TA_Provenance,EC_StatusRegle,EC_MontantRegle,EC_Sens
                            ,EC_Lettrage,CG_NumCont,CT_Num,CT_NumCont
                            ,EC_Intitule,N_Reglement,EC_Echeance,EC_MontantCredit
                            ,EC_MontantDebit,EC_Montant,TA_Code,EC_Piece = ISNULL(EC_Piece,0) + DENSE_RANK() OVER (PARTITION BY tmp.JO_Num ORDER BY tmp.EC_RefPiece) 
                    FROM #tmpAllEcritureFacture tmp
                    INNER JOIN F_JOURNAUX jou
                        ON tmp.JO_Num = jou.JO_Num
                    LEFT JOIN (SELECT JO_Num, EC_Piece = MAX(TRY_CAST(EC_Piece AS INT)) FROM F_ECRITUREC GROUP BY JO_Num) ecr
                        ON tmp.JO_Num = ecr.JO_Num
                    WHERE JO_NumPiece = 1
                    AND @typeFormat = 1
                    ), _journalTypeDeux_ AS (
                    SELECT CA_Num,DO_Domaine,tmp.CbMarq,nomFichier,tmp.JO_Num,Annee_Exercice
                            ,EC_Jour,EC_RefPiece,EC_Reference,tmp.CG_Num
                            ,TA_Provenance,EC_StatusRegle,EC_MontantRegle,EC_Sens
                            ,EC_Lettrage,CG_NumCont,CT_Num,CT_NumCont
                            ,EC_Intitule,N_Reglement,EC_Echeance,EC_MontantCredit
                            ,EC_MontantDebit,EC_Montant,TA_Code,EC_Piece = ISNULL((SELECT	EC_Piece = ISNULL(MAX(TRY_CAST(EC_Piece AS INT)),0) + 1
                                                                            FROM	F_ECRITUREC 
                                                                            WHERE   TRY_CAST(EC_Piece AS INT) IS NOT NULL),0) + DENSE_RANK() OVER (PARTITION BY tmp.JO_Num ORDER BY tmp.EC_RefPiece) 
                    FROM #tmpAllEcritureFacture tmp
                    INNER JOIN F_JOURNAUX jou
                        ON tmp.JO_Num = jou.JO_Num
                    WHERE JO_NumPiece = 2
                    AND @typeFormat = 1
                    )
                    ,_journalTypeTrois_ AS (
                    SELECT CA_Num,DO_Domaine,tmp.CbMarq,nomFichier,tmp.JO_Num,Annee_Exercice
                            ,EC_Jour,EC_RefPiece,EC_Reference,tmp.CG_Num
                            ,TA_Provenance,EC_StatusRegle,EC_MontantRegle,EC_Sens
                            ,EC_Lettrage,CG_NumCont,CT_Num,CT_NumCont
                            ,EC_Intitule,N_Reglement,EC_Echeance,EC_MontantCredit
                            ,EC_MontantDebit,EC_Montant,TA_Code
                            ,EC_Piece = ISNULL(EC_Piece,0) + DENSE_RANK() OVER (PARTITION BY tmp.JO_Num ORDER BY tmp.EC_RefPiece) 
                    FROM #tmpAllEcritureFacture tmp
                    INNER JOIN F_JOURNAUX jou
                        ON tmp.JO_Num = jou.JO_Num
                    LEFT JOIN (SELECT JO_Num,JM_Date, EC_Piece = ISNULL(MAX(TRY_CAST(EC_Piece AS INT)),0) FROM F_ECRITUREC GROUP BY JO_Num,JM_Date) ecr
                        ON	tmp.JO_Num = ecr.JO_Num
                        AND CAST(tmp.Annee_Exercice+'01' AS DATE) = ecr.JM_Date 
                    WHERE JO_NumPiece = 3
                    AND @typeFormat = 1
                    )
                    ,_journalTypeFormat_ AS (
                    SELECT CA_Num,DO_Domaine,tmp.CbMarq,nomFichier,tmp.JO_Num,Annee_Exercice
                            ,EC_Jour,EC_RefPiece,EC_Reference,tmp.CG_Num
                            ,TA_Provenance,EC_StatusRegle,EC_MontantRegle,EC_Sens
                            ,EC_Lettrage,CG_NumCont,CT_Num,CT_NumCont
                            ,EC_Intitule,N_Reglement,EC_Echeance,EC_MontantCredit
                            ,EC_MontantDebit,EC_Montant,TA_Code
                            ,EC_Piece = DO_Piece
                    FROM #tmpAllEcritureFacture tmp
                    INNER JOIN F_JOURNAUX jou
                        ON tmp.JO_Num = jou.JO_Num
                    LEFT JOIN (SELECT JO_Num,JM_Date, EC_Piece = ISNULL(MAX(TRY_CAST(EC_Piece AS INT)),0) FROM F_ECRITUREC GROUP BY JO_Num,JM_Date) ecr
                        ON	tmp.JO_Num = ecr.JO_Num
                        AND CAST(tmp.Annee_Exercice+'01' AS DATE) = ecr.JM_Date 
                    WHERE JO_NumPiece = 3
                    AND @typeFormat = 0
                    )
                    ,_UnionEcriture_ AS 
                    (
                        SELECT CA_Num,DO_Domaine,CbMarq,nomFichier,JO_Num,Annee_Exercice
                            ,EC_Jour,EC_RefPiece,EC_Reference,CG_Num
                            ,TA_Provenance,EC_StatusRegle,EC_MontantRegle,EC_Sens
                            ,EC_Lettrage,CG_NumCont,CT_Num,CT_NumCont
                            ,EC_Intitule,N_Reglement,EC_Echeance,EC_MontantCredit
                            ,EC_MontantDebit,EC_Montant,TA_Code
                            ,EC_Piece
                            FROM _journalTypeUn_
                        UNION
                        
                        SELECT CA_Num,DO_Domaine,CbMarq,nomFichier,JO_Num,Annee_Exercice
                            ,EC_Jour,EC_RefPiece,EC_Reference,CG_Num
                            ,TA_Provenance,EC_StatusRegle,EC_MontantRegle,EC_Sens
                            ,EC_Lettrage,CG_NumCont,CT_Num,CT_NumCont
                            ,EC_Intitule,N_Reglement,EC_Echeance,EC_MontantCredit
                            ,EC_MontantDebit,EC_Montant,TA_Code
                            ,EC_Piece
                            FROM _journalTypeDeux_
                        UNION
                        
                        SELECT CA_Num,DO_Domaine,CbMarq,nomFichier,JO_Num,Annee_Exercice
                            ,EC_Jour,EC_RefPiece,EC_Reference,CG_Num
                            ,TA_Provenance,EC_StatusRegle,EC_MontantRegle,EC_Sens
                            ,EC_Lettrage,CG_NumCont,CT_Num,CT_NumCont
                            ,EC_Intitule,N_Reglement,EC_Echeance,EC_MontantCredit
                            ,EC_MontantDebit,EC_Montant,TA_Code
                            ,EC_Piece
                            FROM _journalTypeTrois_
                    )
                    SELECT	*                
                            ,JM_Date = CAST(Annee_Exercice+'01' AS DATE) 
                            ,EC_No = (SELECT Max(EC_No) FROM F_ECRITUREC)+ROW_NUMBER() OVER (
                                        ORDER BY EC_RefPiece,EC_Piece,JO_Num,CG_Num)
                            INTO #tmpEcritureCFacture
                    FROM	_UnionEcriture_
                    WHERE   (@journal = '0' OR JO_Num = @journal)";
    }

    public function InsertecritureCFacture(){
        return "INSERT INTO [F_JMOUV] 
                       ([JO_Num],[JM_Date],[JM_Cloture],[JM_Impression]
                       ,[JM_DateCloture],[cbProt],[cbCreateur],[cbModification]
                       ,[cbReplication],[cbFlag])
            SELECT	DISTINCT JO_Num,JM_Date,0,0,'1900-01-01',0,@protNo,GETDATE(),0,0
            FROM	#tmpEcritureCFacture
            WHERE	NOT EXISTS (SELECT 1 
                                FROM F_JMOUV 
                                WHERE F_JMOUV.JO_Num =  #tmpEcritureCFacture.JO_Num 
                                AND F_JMOUV.JM_Date =  #tmpEcritureCFacture.JM_Date)
            ;

            
            INSERT INTO F_ECRITUREC ([JO_Num],[EC_No],[EC_NoLink],[JM_Date]
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
		   
		SELECT	JO_Num,EC_No,0,JM_Date
				,EC_Jour,CAST(GETDATE() AS DATE),EC_Piece,EC_RefPiece
				,'',CG_Num,CG_NumCont,CT_Num
				,LEFT(EC_Intitule,35),N_Reglement,EC_Echeance,0
				,0,0,EC_Sens,EC_Montant = ROUND(EC_Montant,2)
				,0,EC_Lettrage,0,''
				,0,0,0,0
				,CT_NumCont,0,'',0,0,0,0,0,TA_Code,0,TA_Provenance,0,'1900-01-01','1900-01-01','1900-01-01',EC_Reference
				,EC_StatusRegle,EC_MontantRegle,CASE WHEN EC_StatusRegle = 2 THEN DATEADD(DAY,EC_Jour-1,CAST(JM_Date AS DATE)) ELSE '1900-01-01' END,0,'1900-01-01',0,0,@protNo,GETDATE()
				,0,0
		FROM #tmpEcritureCFacture
		WHERE   ISNULL(EC_Montant,0) <> 0
        AND     ISNULL(JO_Num,'') <>''
        AND     ISNULL(CG_Num,'') <>''
        ORDER BY EC_No;
        

        IF (SELECT P_Analytique FROM P_PARAMETRECIAL) = 2 
        BEGIN
            INSERT INTO [F_ECRITUREA]
                        ([EC_No],[N_Analytique],[EA_Ligne],[CA_Num],[EA_Montant],[EA_Quantite]
                        ,[cbProt],[cbCreateur],[cbModification],[cbReplication],[cbFlag])
            SELECT	ec.EC_No,cpta.N_Analytique,1,ec.CA_Num,ec.EC_Montant,0,0,@protNo,GETDATE(),0,0
            FROM	#tmpEcritureCFacture ec
            LEFT JOIN F_COMPTEG cg
                ON	cg.CG_Num= ec.CG_Num
            LEFT JOIN F_COMPTEA cpta
                ON	cpta.CA_Num = ec.CA_Num
            WHERE	cg.CG_Analytique=1;
        END; 
        
            SELECT  DO_Piece,DO_Type,DO_Domaine,cbMarq
                INTO #listDocument
            FROM    F_DOCENTETE
            WHERE   cbMarq IN (
            SELECT  cbMarq 
            FROM    #tmpEcritureCFacture
            WHERE ISNULL(#tmpEcritureCFacture.EC_Montant,0) <> 0
			AND ISNULL(#tmpEcritureCFacture.JO_Num,'') <>''
			AND ISNULL(#tmpEcritureCFacture.CG_Num,'') <>'' 
            );
    
        UPDATE  F_DOCENTETE 
            SET DO_Type = CASE WHEN F_DOCENTETE.DO_Type = 6 THEN 7
                                 WHEN F_DOCENTETE.DO_Type = 16 THEN 17 END
		WHERE   F_DOCENTETE.cbMarq IN (SELECT cbMarq FROM #listDocument);
		
        UPDATE  F_DOCLIGNE 
            SET DO_Type = CASE WHEN F_DOCLIGNE.DO_Type = 6 THEN 7
                                 WHEN F_DOCLIGNE.DO_Type = 16 THEN 17 END
        FROM    #listDocument        
		WHERE   F_DOCLIGNE.DO_Type = #listDocument.DO_Type
        AND     F_DOCLIGNE.DO_Piece = #listDocument.DO_Piece
        AND     F_DOCLIGNE.DO_Domaine = #listDocument.DO_Domaine;

        UPDATE  F_DOCREGL 
            SET DO_Type = CASE WHEN F_DOCREGL.DO_Type = 6 THEN 7
                                 WHEN F_DOCREGL.DO_Type = 16 THEN 17 END
        FROM    #listDocument        
		WHERE   F_DOCREGL.DO_Type = #listDocument.DO_Type
        AND     F_DOCREGL.DO_Piece = #listDocument.DO_Piece
        AND     F_DOCREGL.DO_Domaine = #listDocument.DO_Domaine;

        UPDATE  F_REGLECH 
            SET DO_Type = CASE WHEN F_REGLECH.DO_Type = 6 THEN 7
                                 WHEN F_REGLECH.DO_Type = 16 THEN 17 END
        FROM    #listDocument        
		WHERE   F_REGLECH.DO_Type = #listDocument.DO_Type
        AND     F_REGLECH.DO_Piece = #listDocument.DO_Piece
        AND     F_REGLECH.DO_Domaine = #listDocument.DO_Domaine;
		
		";
    }
    public function majComptaFacture($datedeb,$datefin,$dopieceDebut,$doPieceFin,$doDomaine,$doType,$doSouche,$catCompta,$caisse){
        $query ="
        DECLARE @rgNo AS INT
        DECLARE @pLigneNeg INT;
        DECLARE @rgTypeReg INT;
        DECLARE @typeFacture INT = 0;
        DECLARE @typeFormat INT;
        SELECT  @typeFormat = CASE WHEN @typeFacture = 1 THEN P_Piece01 ELSE P_Piece03 END 
        FROM    P_PARAMETRECIAL;
        DECLARE @dateDebut NVARCHAR(50) = '$datedeb' 
        DECLARE @dateFin NVARCHAR(50) = '$datefin' 
        DECLARE @doPieceDebut NVARCHAR(50) ='$dopieceDebut' 
        DECLARE @doPieceFin NVARCHAR(50) ='$doPieceFin' 
        DECLARE @doDomaine INT = $doDomaine 
        DECLARE @doType INT = $doType 
        DECLARE @doSouche INT = $doSouche
        DECLARE @catCompta INT = $catCompta
        DECLARE @caisse INT = $caisse;
        SELECT @pLigneNeg = P_LigneNeg FROM P_PARAMETRECIAL;

        
        {$this->getlistMajCompta()}                
                
        {$this->listEcritureCFacture()}

            

";
        $this->db->query($query);
    }
    public function getcbMarqDocRegl(){
        $query= "SELECT cbMarq
                 FROM   F_DOCREGL
                 WHERE  DO_Piece='{$this->DO_Piece}'
                 AND    DO_Domaine={$this->DO_Domaine}
                 AND    DO_Type={$this->DO_Type}";
        $result = $this->db->query($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if(sizeof($rows)>0)
            return $rows[0]->cbMarq;
        else
            return 0;
    }


    function majEnteteComptable($cbMarq,$doTypeCible){
        $query= "DECLARE @cbMarq AS int
                DECLARE @do_typeCible AS int
                SET @cbMarq = $cbMarq
                SET @do_typeCible = $doTypeCible;
                
                DISABLE TRIGGER TG_UPD_F_DOCLIGNE ON F_DOCLIGNE;
                DISABLE TRIGGER TG_UPD_F_DOCREGL ON F_DOCREGL;
                DISABLE TRIGGER TG_UPD_F_REGLECH ON F_REGLECH;
                
                UPDATE F_DOCLIGNE SET F_DOCLIGNE.DO_Type=@do_typeCible
                FROM (SELECT DO_Piece,DO_Domaine,DO_Type	
                        FROM F_DOCENTETE		
                        WHERE cbMarq = @cbMarq)A
                WHERE A.DO_Piece= F_DOCLIGNE.DO_Piece AND A.DO_Domaine= F_DOCLIGNE.DO_Domaine AND A.DO_Type = F_DOCLIGNE.DO_Type
                
                UPDATE F_DOCREGL SET F_DOCREGL.DO_Type=@do_typeCible
                FROM (SELECT DO_Piece,DO_Domaine,DO_Type	
                        FROM F_DOCENTETE	
                        WHERE cbMarq = @cbMarq)A
                WHERE A.DO_Piece= F_DOCREGL.DO_Piece AND A.DO_Domaine= F_DOCREGL.DO_Domaine AND A.DO_Type = F_DOCREGL.DO_Type
                
                UPDATE F_REGLECH SET F_REGLECH.DO_Type=@do_typeCible
                FROM (SELECT DO_Piece,DO_Domaine,DO_Type	
                        FROM F_DOCENTETE		
                        WHERE cbMarq = @cbMarq)A
                WHERE A.DO_Piece= F_REGLECH.DO_Piece AND A.DO_Domaine= F_REGLECH.DO_Domaine AND A.DO_Type = F_REGLECH.DO_Type
                
                UPDATE F_DOCENTETE SET DO_Type=@do_typeCible
                WHERE cbMarq = @cbMarq;
                
                ENABLE TRIGGER TG_UPD_F_DOCLIGNE ON F_DOCLIGNE;
                ENABLE TRIGGER TG_UPD_F_DOCREGL ON F_DOCREGL;
                ENABLE TRIGGER TG_UPD_F_REGLECH ON F_REGLECH;
                ";
        $this->db->query($query);
    }

    public function majReglementComptabilise($ec_no, $cbMarq)
    {
        $query= "UPDATE F_CREGLEMENT 
                        SET EC_No=$ec_no
                            ,RG_Compta=1 
                 WHERE RG_No IN (SELECT  RG_No 
                                FROM    F_DOCENTETE docE
                                INNER JOIN F_REGLECH regl    
                                    ON docE.DO_Domaine = regl.DO_Domaine 
                                    AND docE.DO_Type = regl.DO_Type 
                                    AND docE.DO_Piece = regl.DO_Piece 
                                WHERE   docE.cbMarq = $cbMarq ) ";
        $this->db->query($query);
    }

    public function  updateDrRegleByDOPiece() {
        return "UPDATE F_DOCREGL 
                SET Dr_Regle = 1,cbModification=GETDATE() 
                FROM (SELECT DO_Domaine,DO_Type,cbDO_Piece
                      FROM F_DOCENTETE
                      WHERE cbMarq = {$this->cbMarq}) A     
                WHERE F_DOCREGL.DO_Domaine = A.DO_Domaine 
                AND   F_DOCREGL.DO_Type = A.DO_Type  
                AND   F_DOCREGL.cbDO_Piece = A.cbDO_Piece ";
    }

    public function getLigneTransfert(){
        return $this->getApiJson("/getLigneTransfert&cbMarq={$this->cbMarq}");
    }

    public function getLigneFactureTransfert() {
        return $this->getApiJson("/getLigneFactureTransfert&cbMarq={$this->cbMarq}");
    }

    public function  clotureVente($ca_num){
        $query = "SELECT TOP 1 DO_Ref,DO_Piece,DO_Domaine,DO_Type,DO_Statut,DO_Tiers,CAST(GETDATE() AS DATE) DO_Date,DE_No,CA_Num,CO_No,CA_No,N_CatCompta,DO_Statut,DO_Souche,DO_Cours
                    FROM F_DOCENTETE
                    WHERE CA_Num='$ca_num'
                    AND DO_Domaine=0
                    ORDER BY CBMARQ DESC";
        $result= $this->db->query($query);
        $infoEntete=Array();
        foreach($result->fetchAll(PDO::FETCH_OBJ) as $res)
            $infoEntete= $res;

        $var = $this->ajoutEntete($infoEntete->DO_Type,$infoEntete->DO_Piece,"Vente",$infoEntete->DO_Date,$infoEntete->DO_Date,
            $ca_num,$infoEntete->DO_Tiers,"","","","","","",$infoEntete->DO_Statut,"0","0",$infoEntete->DE_No,
            0,$infoEntete->N_CatCompta,$infoEntete->DO_Souche,$infoEntete->CA_No,$infoEntete->CO_No,"cloture ".$infoEntete->DO_Ref);
        $docEntete = new DocEnteteClass($var["cbMarq"]);
        $query = "SELECT MAX(AR_Ref)AR_Ref,SUM(QTE) QTE,SUM(CARAT)CARAT,SUM(CIOJ)CIOJ
        FROM(
            SELECT MAX(AR_Ref)AR_Ref,SUM(CASE WHEN A.DO_Domaine=1 THEN -DL_Qte ELSE DL_Qte END) QTE,null carat,MAX(CIOJ) CIOJ
        FROM F_DOCENTETE A
        INNER JOIN F_DOCLIGNE B ON A.DO_Domaine=B.DO_Domaine AND A.DO_Type=B.DO_Type AND A.DO_Piece=B.DO_Piece
        WHERE A.CA_Num='$ca_num'
        union
        SELECT null AR_Ref,null qte, AVG(carat) carat, null CIOJ
        FROM F_DOCENTETE A
        INNER JOIN F_DOCLIGNE B ON A.DO_Domaine=B.DO_Domaine AND A.DO_Type=B.DO_Type AND A.DO_Piece=B.DO_Piece
        WHERE A.CA_Num='$ca_num'
                AND a.DO_Domaine=0)A";
        $result= $this->db->query($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);

        $docligne = new DocLigneClass(0);
        $data = $docligne->ajout_ligneFacturation($rows[0]->QTE,0,
            $docEntete->cbMarq,$docEntete->DE_No,$rows[0]->AR_Ref,"Vente",
            0,$docEntete->DO_Domaine,$docEntete->DO_Piece,0,$docEntete->N_CatCompta,$rows[0]->CARAT,0,
            '','',0,
            0,$rows[0]->CARAT,0,$rows[0]->CIOJ,
            "","ajout_ligne",0,0,
            0,0);
        if($data!=null) {
            $docEntete->deleteEntete();
        }else
            $this->db->query($this->objetCollection->miseEnSommeil($ca_num));
    }

    public function deleteEntete(){
        $result = $this->db->requete( "
            DELETE FROM F_DOCREGL WHERE DO_Piece='{$this->DO_Piece}' AND DO_Domaine={$this->DO_Domaine} 
            AND DO_Type={$this->DO_Type};");
        $this->delete();
    }

    public function updateEnteteTable($nextDO_Piece)
    {
        $query = "UPDATE F_DOCCURRENTPIECE SET DC_Piece='{$nextDO_Piece}',cbModification=GETDATE() WHERE DC_Domaine={$this->DO_Domaine} AND DC_Souche={$this->DO_Souche} AND DC_IdCol={$this->doccurent_type}";
        $this->db->requete($query);
    }

    public function getEnteteDocument($do_souche){
        return $this->getApiString("/getEnteteDocument&typeFac={$this->type_fac}&doSouche=$do_souche");
    }

    public function montantRegle() {
        return $this->getApiJson("/montantRegle&cbMarq={$this->cbMarq}");
    }

    public function AvanceDoPiece() {
        return $this->getApiJson("/avanceDoPiece&cbMarq={$this->cbMarq}");
    }

    public function isVisu()
    {
        return $this->getApiJson("/isVisu&cbMarq={$this->cbMarq}&protNo={$_SESSION["id"]}&typeFacture={$this->type_fac}");
    }

    public function isModif(){
        return $this->getApiJson("/isModif&cbMarq={$this->cbMarq}&protNo={$_SESSION["id"]}&typeFacture={$this->type_fac}");
    }

    public function getEnteteDispo(){
        $dopiece = $this->DO_Piece;
        $rowsTour = $this->getEnteteByDOPiece($dopiece);
        while($rowsTour!=null){
            $dopiece = $this->incrementeDOPiece($dopiece);
            $rowsTour = $this->getEnteteByDOPiece($dopiece);
        }
        if($this->DO_Type==30){
            $rowsTour = $this->getEnteteTicketByDOPiece();
            $dopiece = $rowsTour+1;
        }
        return $dopiece;
    }

    public function ResteARegler($avance)
    {
        return $this->getApiJson("/resteARegler&cbMarq={$this->cbMarq}&avance=$avance");
    }

    public function getFactureCORecouvrement($collab,$ctNum){
        return $this->getApiJson("/getFactureCORecouvrement&collab={$collab}&ctNum={$ctNum}");
    }

    public function getEnteteTicketByDOPiece() {
        $result = $this->db->requete( "SELECT ISNULL(Max(DO_Piece),0) DO_Piece 
                FROM(
                SELECT  CAST(DO_Piece AS INT) AS DO_Piece
                FROM    F_DOCENTETE 
                WHERE   DO_Domaine={$this->DO_Domaine} 
                AND     DO_Type = {$this->DO_Type}
                UNION
                SELECT  TA_Piece AS DO_Piece
                FROM    F_TICKETARCHIVE)A");
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if($rows!=null)
            return $rows[0]->DO_Piece;
        return 0;
    }

    public function incrementeDOPiece($var){
        preg_match_all('!\d+!', $var, $matches);
        $len = strlen($matches[0][0]);
        if(strlen($var)<2)
            return $var+1;
        else
            return substr($var, 0,strlen($var)-$len).substr("00000".($matches[0][0]+1),-$len);
    }

    public function getDL_PieceBL(){
        $query = "  SELECT    DL_PieceBL = MAX(DL_PieceBL)
                    FROM    F_DOCLIGNE
                    WHERE   DO_Domaine={$this->DO_Domaine}
                    AND     DO_Piece = '{$this->DO_Piece}'
                    AND     DO_Type ={$this->DO_Type}";
        $result = $this->db->query($query);
        $rowsTour = $result->fetchAll(PDO::FETCH_OBJ);
        if($rowsTour!=null)
            return $rowsTour[0]->DL_PieceBL;
        return "";
    }
    public function getEnteteByDOPiece($dopiece) {
        $query = "
                DECLARE @doPiece NVARCHAR(50) = '{$dopiece}'
                DECLARE @doDomaine INT = {$this->DO_Domaine}
                DECLARE @doType INT = {$this->DO_Type}
                SELECT *
                        ,DO_DateC = CONVERT(char(10), CAST(DO_Date AS DATE),126) 
                FROM    F_DOCENTETE 
                WHERE   DO_Piece=@doPiece 
                AND     (CASE WHEN @doDomaine = 2 AND DO_Domaine IN (2,4) THEN 1 
                             WHEN @doDomaine <> 2 AND DO_Domaine=@doDomaine THEN 1 END) = 1
                AND     (CASE WHEN @doType=6 AND DO_Type IN(6,7) THEN 1
                                WHEN @doType=16 AND DO_Type IN(16,17) THEN 1
                                WHEN DO_Type NOT IN (16,6) AND @doType=DO_Type THEN 1 END) = 1;
                ";
        $result = $this->db->requete($query);
        $rowsTour = $result->fetchAll(PDO::FETCH_OBJ);
        if($rowsTour!=null)
            return $rowsTour[0]->DO_Piece;
        return null;
    }

    public function getDocumentByDOPiece($do_piece,$DO_Domaine,$DO_Type) {
        $result = $this->db->requete("  SELECT  cbMarq 
                                        FROM    F_DOCENTETE 
                                        WHERE   DO_Piece='$do_piece' 
                                        AND     DO_Domaine=$DO_Domaine 
                                        AND     $DO_Type=DO_Type");
        $rowsTour = $result->fetchAll(PDO::FETCH_OBJ);
        if($rowsTour!=null)
            return new DocEnteteClass($rowsTour[0]->cbMarq);
        return null;
    }

    public function getEnteteTable($souche){
        return $this->getApiString("/getEnteteDocument&typeFac={$this->type_fac}&doSouche=$souche");
    }

    public function getDO_DateC(){
        $result = $this->db->requete("  SELECT  CONVERT(char(10), CAST(DO_Date AS DATE),126) AS DO_DateC
                                        FROM    F_DOCENTETE
                                        WHERE   DO_Domaine={$this->DO_Domaine} 
                                        AND     DO_Type={$this->DO_Type}
                                        AND     DO_Piece='{$this->DO_Piece}'");
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if($rows!=null)
            return $rows[0]->DO_DateC;
    }

    public function listeTransfertDetail($do_tiers, $datedeb, $datefin){
        return $this->getApiJson("/getlisteTransfertDetail&client={$this->formatString($do_tiers)}&dateDeb=$datedeb&dateFin=$datefin");
    }


    public function listeSortie($do_tiers, $datedeb, $datefin){
        return $this->getApiJson("/getlisteSortie&client={$this->formatString($do_tiers)}&dateDeb=$datedeb&dateFin=$datefin");
    }

    public function getListeFactureMajComptable($typeTransfert, $datedeb, $datefin,$doPiecedeb,$doPiecefin,$souche,$etatPiece,$catCompta,$caisse){
        $do_domaine=0;
        if($typeTransfert==2) $do_domaine=1;
        $do_type =6;
        if($typeTransfert==2) {
            $do_type = 16;
            if($etatPiece==1)
                $do_type = 17;
        }else
            if($etatPiece==1)
                $do_type = 7;

        $query = "DECLARE @dateDebut NVARCHAR(50) = '$datedeb'
                DECLARE @dateFin NVARCHAR(50) = '$datefin'
                DECLARE @doPieceDebut NVARCHAR(50) ='$doPiecedeb'
                DECLARE @doPieceFin NVARCHAR(50) ='$doPiecefin'
                DECLARE @doDomaine INT = $do_domaine
                DECLARE @doType INT = $do_type
                DECLARE @doSouche INT = $souche
                DECLARE @catCompta INT = $catCompta
                DECLARE @caisse INT = $caisse;
         
                WITH _Query_ AS (         
                SELECT	docE.cbMarq
                        ,docE.DO_Domaine
                        ,docE.DO_Type
                        ,docE.DO_Piece
                        ,RG_No
                        ,UniqueRG = ROW_NUMBER() OVER(PARTITION BY RG_No ORDER BY RG_No)
                        ,UniquecbMarq = ROW_NUMBER() OVER(PARTITION BY cbMarq ORDER BY cbMarq)
                        ,B.EC_No
                FROM	F_DOCENTETE docE
                LEFT JOIN (SELECT  fre.DO_Domaine,fre.DO_Type,fre.DO_Piece,fre.RG_No,EC_No = ISNULL(ecr.EC_No,0)
                            FROM    F_REGLECH fre
                            INNER JOIN F_CREGLEMENT fcre
                                ON fre.RG_No = fcre.RG_No
                            LEFT JOIN F_ECRITUREC ecr
                                ON ecr.EC_No = fcre.EC_No
                            GROUP BY fre.DO_Domaine,fre.DO_Type,fre.DO_Piece,fre.RG_No,ISNULL(ecr.EC_No,0))B 
                    ON	docE.DO_Domaine=B.DO_Domaine
                    AND docE.DO_Type=B.DO_Type
                    AND docE.DO_Piece=B.DO_Piece
                WHERE docE.DO_Domaine=@doDomaine AND docE.DO_Type=@doType
                AND (@dateDebut='' OR DO_Date>=@dateDebut)
                AND (@dateFin='' OR DO_Date<=@dateFin)
                AND (@doPieceDebut='' OR docE.DO_Piece>=@doPieceDebut)
                AND (@doPieceFin='' OR docE.DO_Piece<=@doPieceFin)
                AND (@doSouche=-1 OR DO_Souche=@doSouche)
                AND (@catCompta=0 OR N_CatCompta>=@catCompta)
                AND (@caisse=0 OR CA_No =@caisse)
                )
                ,_All_ AS (
                SELECT	cbMarq = CASE WHEN que.UniquecbMarq = 1 THEN que.cbMarq ELSE 0 END
                        ,que.DO_Domaine
                        ,que.DO_Type
                        ,que.DO_Piece
                        ,RG_No = CASE WHEN que.UniqueRG = 1 THEN que.RG_No ELSE 0 END
                        ,EC_No = CASE WHEN que.UniqueRG = 1 THEN que.EC_No ELSE 0 END
                        ,IsEcriture = CASE WHEN ecr.EC_RefPiece IS NOT NULL THEN 1 ELSE 0 END
                FROM	_Query_ que
                LEFT JOIN (SELECT DISTINCT EC_RefPiece FROM F_ECRITUREC) ecr
                    ON que.DO_Piece = ecr.EC_RefPiece 
                )
                
                SELECT  cbMarq
                        ,DO_Domaine
                        ,DO_Type
                        ,DO_Piece
                        ,RG_No
                        ,EC_No
                        ,IsEcriture
                FROM    _All_    
                ";
        $result= $this->db->query($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $this->list = array();
        foreach ($rows as $resultat)
        {
            array_push($this->list, (object) array("DO_Domaine" =>  $resultat->DO_Domaine,"DO_Type" => $resultat->DO_Type
            ,"DO_Piece" => $resultat->DO_Piece,"cbMarq" => $resultat->cbMarq,"RG_No" => $resultat->RG_No
            ,"EC_No" => $resultat->EC_No,"IsEcriture" => $resultat->IsEcriture));
        }
        return $this->list;
    }


    public function getEnteteByRG_No($RG_No){
        $query = "  SELECT A.cbMarq
                    FROM F_DOCENTETE A
                    INNER JOIN F_REGLECH B 
                        ON  A.DO_Domaine=B.DO_Domaine 
                        AND A.DO_Type=B.DO_Type 
                        AND A.cbDO_Piece =B.cbDO_Piece 
                    WHERE   RG_No = $RG_No";
        $result= $this->db->query($query);
        $this->list = array();
        foreach ($result->fetchAll(PDO::FETCH_OBJ) as $resultat)
        {
            $docEntete = new DocEnteteClass($resultat->cbMarq);
            array_push($this->list,$docEntete);
        }
        return $this->list;
    }

    public function __toString() {
        return "";
    }

    public function displayListeFacture($depot,$datedeb,$datefin,$client,$admin,$protected,$protectedSuppression,$cbCreateur,$protNo){
        ?>
        <thead>
        <tr>
            <th>Numéro Pièce</th>
            <th>Reference</th>
            <th class="d-none"></th>
            <th>Date</th>
            <?php if($this->DO_Domaine==0) echo"<th>Client</th>";
            if($this->DO_Domaine==0 || $this->DO_Domaine==2 || $this->type_fac=="Entree"||  $this->type_fac=="Sortie") echo "<th>Dépot</th>";
            if($this->DO_Domaine == 1) echo"<th>Fournisseur</th>
                            <th>Dépot</th>";
            if( $this->type_fac=="Transfert_detail" ||  $this->type_fac=="Transfert" ||  $this->type_fac=="Transfert_valid_confirmation" ||  $this->type_fac=="Transfert_confirmation") echo"<th>Dépot source</th>
                            <th>Dépot dest.</th>";
            ?>
            <th>Total TTC</th>
            <?php
            if( $this->type_fac=="Ticket" || ($this->DO_Domaine==0 && ($this->DO_Type!=0 && $this->DO_Type!=1)) ||  $this->DO_Domaine==1)
                echo "<th>Montant r&eacute;gl&eacute;</th>
                            <th>Statut</th>"; ?>
            <?php if(($this->type_fac == "BonLivraison" || $this->type_fac == "Devis") && ($admin==1 || ($protected))) echo "<th></th>"; ?>
            <?php if($protectedSuppression) echo "<th></th>"; ?>
            <th></th>
            <?php
            if($cbCreateur!=2)
                echo "<th>Créateur</th>";
            ?>
        </tr>
        </thead>
        <tbody>
        <?php
        $listFacture = $this->listeFacture($depot,$this->objetCollection->getDate($datedeb),$this->objetCollection->getDate($datefin),$protNo,$client,"");
        if(sizeof($listFacture)==0){

        }else{
            foreach ($listFacture as $row){
                $message="";
                $avance="";
                $total = round($row->ttc);
                if($this->type_fac=="Ticket" || $this->DO_Domaine ==1 || $this->DO_Domaine == 0){
                    $avance = round($row->avance);
                    if($avance==null) $avance = 0;
                    $message =$row->statut;
                }
                $date = new DateTime($row->DO_Date);
                ?>
            <tr data-toggle="tooltip" data-placement="top" title="<?= $row->PROT_User ?>"
                class='facture' id='article_<?= $row->DO_Piece ?>'>
                <td id='entete'><a href='<?= $this->lien($row->cbMarq) ?>'><?= $row->DO_Piece ?></a></td>
                <td id="DO_Ref"><?= $row->DO_Ref ?></td>
                <td class="d-none"><span class="d-none" id='cbMarq'><?= $row->cbMarq ?></span>
                    <span style='display:none' id='DL_PieceBL'><?= $row->DL_PieceBL ?></span>
                    <span style='display:none' id='cbCreateur'><?= $row->PROT_User ?></span>
                </td>
                <td id="DO_Date"><?= $date->format('d-m-Y') ?></td>
                <?php
                if($this->DO_Domaine==0 || $this->DO_Domaine==1)
                    echo "<td>{$row->CT_Intitule}</td>";
                if($this->DO_Domaine==0 || $this->DO_Domaine==1 || $this->DO_Domaine==2 || $this->type_fac=="Entree"|| $this->type_fac=="Sortie")
                    echo "<td>{$row->DE_Intitule}</td>";
                if($this->type_fac=="Transfert_detail" || $this->type_fac=="Transfert" || $this->type_fac=="Transfert_confirmation" || $this->type_fac=="Transfert_valid_confirmation")
                    echo"<th>{$row->DE_Intitule}</th>
                        <th>{$row->DE_Intitule_dest}</th>";
                ?>
                <td><?= $this->objetCollection->formatChiffre($total) ?></td>
                <?php
                if($this->type_fac=="Ticket" || ($this->DO_Domaine==0 && ($this->DO_Type!=0 && $this->DO_Type!=1)) ||  $this->DO_Domaine==1)
                    echo "<td>{$this->objetCollection->formatChiffre($avance)}</td>
                    <td id='statut'>{$message}</td>";
                if(($this->type_fac == "BonLivraison" || $this->type_fac =="Devis") && ($admin==1 || ($protected))) echo '<td><input type="button" class="btn btn-primary" value="Convertir en facture" id="transform"/></td>';
                if(($protectedSuppression)){
                    echo "<td id='supprFacture'>";
                    if($protectedSuppression) //if(($type=="Ticket" || $type=="BonLivraison" || $type=="Vente" || $type=="AchatRetour" || $type=="AchatRetourC" || $type=="AchatRetourT" || $type=="AchatT" || $type=="VenteT" || $type=="VenteC" || $type=="Achat" || $type=="AchatC" || $type=="Entree"|| $type=="Sortie"|| $type=="Transfert"|| $type=="Transfert_valid_confirmation" || $type=="Transfert_confirmation" || $type=="Transfert_detail") && $avance==0)
                        echo "<i class='fa fa-trash-o'></i></td>";
                }
                echo "<td>";
                if($this->type_fac !="Transfert_valid_confirmation" && $row->DO_Imprim ==1)
                    echo "<i class='fa fa-print'></i>";
                echo "</td>";
                if($cbCreateur!=2)
                    echo "<td>{$row->PROT_User}</td>";
                echo "</tr>";
            }
        }
        echo"</tbody>";
    }
}