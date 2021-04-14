<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class ComptetClass Extends Objet{
    //put your code here
    public $db,$CT_Num,$CT_Intitule,$CT_Type,$CG_NumPrinc,$CT_Qualite,$CT_Classement
    ,$CT_Contact,$CT_Adresse,$CT_Complement,$CT_CodePostal,$CT_Ville,$CT_CodeRegion
    ,$CT_Pays,$CT_Raccourci,$BT_Num,$N_Devise,$CT_Ape,$CT_Identifiant,$CT_Siret,$CT_Statistique01
    ,$CT_Statistique02,$CT_Statistique03,$CT_Statistique04,$CT_Statistique05,$CT_Statistique06,$CT_Statistique07
    ,$CT_Statistique08,$CT_Statistique09,$CT_Statistique10,$CT_Commentaire,$CT_Encours,$CT_Assurance,$CT_NumPayeur
    ,$N_Risque,$CO_No,$N_CatTarif,$CT_Taux01,$CT_Taux02,$CT_Taux03,$CT_Taux04,$N_CatCompta,$N_Period
    ,$CT_Facture,$CT_BLFact,$CT_Langue,$CT_Edi1,$CT_Edi2,$CT_Edi3,$N_Expedition,$N_Condition,$CT_DateCreate
    ,$CT_Saut,$CT_Lettrage,$CT_ValidEch,$CT_Sommeil,$DE_No,$CT_ControlEnc,$CT_NotRappel,$N_Analytique,$CA_Num
    ,$CT_Telephone,$CT_Telecopie,$CT_EMail,$CT_Site,$CT_Coface,$CT_Surveillance,$CT_SvDateCreate,$CT_SvFormeJuri,$CT_SvEffectif
    ,$CT_SvCA,$CT_SvResultat,$CT_SvIncident,$CT_SvDateIncid,$CT_SvPrivil,$CT_SvRegul,$CT_SvCotation,$CT_SvDateMaj,$CT_SvObjetMaj,$CT_SvDateBilan
    ,$CT_SvNbMoisBilan,$N_AnalytiqueIFRS,$CA_NumIFRS,$CT_PrioriteLivr,$CT_LivrPartielle
    ,$MR_No,$CT_NotPenal,$EB_No,$CT_NumCentrale,$CT_DateFermeDebut,$CT_DateFermeFin,$CT_FactureElec,$CT_TypeNIF,$CT_RepresentInt
    ,$CT_RepresentNIF,$cbMarq,$cbCreateur,$cbModification

    ,$LibCatTarif,$LibCatCompta;

    public $table = 'dbo.F_COMPTET';
    public $lien = 'fcomptet';

    function __construct($id,$mode="all",$type="ctNum")
    {
        $this->CT_Num = "";
        $this->CT_Intitule = "";
        $this->CT_Type = "";
        $this->CG_NumPrinc = "";
        if($type!="cbMarq")
            $this->data = $this->getApiJson("/ctNum=$id");
        else
            $this->data = $this->getApiJson("/cbMarq=$id");

        if (sizeof($this->data) > 0) {
            $this->CT_Num = $this->data[0]->CT_Num;
            $this->CT_Intitule = $this->data[0]->CT_Intitule;
            $this->CT_Type = $this->data[0]->CT_Type;
            $this->CG_NumPrinc = $this->data[0]->CG_NumPrinc;
            if($mode=="all") {
                $this->CT_Qualite = $this->data[0]->CT_Qualite;
                $this->CT_Classement = $this->data[0]->CT_Classement;
                $this->CT_Contact = $this->data[0]->CT_Contact;
                $this->CT_Adresse = $this->data[0]->CT_Adresse;
                $this->CT_Complement = $this->data[0]->CT_Complement;
                $this->CT_CodePostal = $this->data[0]->CT_CodePostal;
                $this->CT_Ville = $this->data[0]->CT_Ville;
                $this->CT_CodeRegion = $this->data[0]->CT_CodeRegion;
                $this->CT_Pays = $this->data[0]->CT_Pays;
                $this->CT_Raccourci = $this->data[0]->CT_Raccourci;
                $this->BT_Num = $this->data[0]->BT_Num;
                $this->N_Devise = $this->data[0]->N_Devise;
                $this->CT_Ape = $this->data[0]->CT_Ape;
                $this->CT_Identifiant = $this->data[0]->CT_Identifiant;
                $this->CT_Siret = $this->data[0]->CT_Siret;
                $this->CT_Statistique01 = $this->data[0]->CT_Statistique01;
                $this->CT_Statistique02 = $this->data[0]->CT_Statistique02;
                $this->CT_Statistique03 = $this->data[0]->CT_Statistique03;
                $this->CT_Statistique04 = $this->data[0]->CT_Statistique04;
                $this->CT_Statistique05 = $this->data[0]->CT_Statistique05;
                $this->CT_Statistique06 = $this->data[0]->CT_Statistique06;
                $this->CT_Statistique07 = $this->data[0]->CT_Statistique07;
                $this->CT_Statistique08 = $this->data[0]->CT_Statistique08;
                $this->CT_Statistique09 = $this->data[0]->CT_Statistique09;
                $this->CT_Statistique10 = $this->data[0]->CT_Statistique10;
                $this->CT_Commentaire = $this->data[0]->CT_Commentaire;
                $this->CT_Encours = $this->data[0]->CT_Encours;
                $this->CT_Assurance = $this->data[0]->CT_Assurance;
                $this->CT_NumPayeur = $this->data[0]->CT_NumPayeur;
                $this->N_Risque = $this->data[0]->N_Risque;
                $this->CO_No = $this->data[0]->CO_No;
                $this->N_CatTarif = $this->data[0]->N_CatTarif;
                $this->CT_Taux01 = $this->data[0]->CT_Taux01;
                $this->CT_Taux02 = $this->data[0]->CT_Taux02;
                $this->CT_Taux03 = $this->data[0]->CT_Taux03;
                $this->CT_Taux04 = $this->data[0]->CT_Taux04;
                $this->N_CatCompta = $this->data[0]->N_CatCompta;
                $this->N_Period = $this->data[0]->N_Period;
                $this->CT_Facture = $this->data[0]->CT_Facture;
                $this->CT_BLFact = $this->data[0]->CT_BLFact;
                $this->CT_Langue = $this->data[0]->CT_Langue;
                $this->CT_Edi1 = $this->data[0]->CT_Edi1;
                $this->CT_Edi2 = $this->data[0]->CT_Edi2;
                $this->CT_Edi3 = $this->data[0]->CT_Edi3;
                $this->N_Expedition = $this->data[0]->N_Expedition;
                $this->N_Condition = $this->data[0]->N_Condition;
                $this->CT_DateCreate = $this->data[0]->CT_DateCreate;
                $this->CT_Saut = $this->data[0]->CT_Saut;
                $this->CT_Lettrage = $this->data[0]->CT_Lettrage;
                $this->CT_ValidEch = $this->data[0]->CT_ValidEch;
                $this->CT_Sommeil = $this->data[0]->CT_Sommeil;
                $this->DE_No = $this->data[0]->DE_No;
                $this->CT_ControlEnc = $this->data[0]->CT_ControlEnc;
                $this->CT_NotRappel = $this->data[0]->CT_NotRappel;
                $this->N_Analytique = $this->data[0]->N_Analytique;
                $this->CA_Num = $this->data[0]->CA_Num;
                $this->CT_Telephone = $this->data[0]->CT_Telephone;
                $this->CT_Telecopie = $this->data[0]->CT_Telecopie;
                $this->CT_EMail = $this->data[0]->CT_EMail;
                $this->CT_Site = $this->data[0]->CT_Site;
                $this->CT_Coface = $this->data[0]->CT_Coface;
                $this->CT_Surveillance = $this->data[0]->CT_Surveillance;
                $this->CT_SvDateCreate = $this->data[0]->CT_SvDateCreate;
                $this->CT_SvFormeJuri = $this->data[0]->CT_SvFormeJuri;
                $this->CT_SvEffectif = $this->data[0]->CT_SvEffectif;
                $this->CT_SvCA = $this->data[0]->CT_SvCA;
                $this->CT_SvResultat = $this->data[0]->CT_SvResultat;
                $this->CT_SvIncident = $this->data[0]->CT_SvIncident;
                $this->CT_SvDateIncid = $this->data[0]->CT_SvDateIncid;
                $this->CT_SvPrivil = $this->data[0]->CT_SvPrivil;
                $this->CT_SvRegul = $this->data[0]->CT_SvRegul;
                $this->CT_SvCotation = $this->data[0]->CT_SvCotation;
                $this->CT_SvDateMaj = $this->data[0]->CT_SvDateMaj;
                $this->CT_SvObjetMaj = $this->data[0]->CT_SvObjetMaj;
                $this->CT_SvDateBilan = $this->data[0]->CT_SvDateBilan;
                $this->CT_SvNbMoisBilan = $this->data[0]->CT_SvNbMoisBilan;
                $this->N_AnalytiqueIFRS = $this->data[0]->N_AnalytiqueIFRS;
                $this->CA_NumIFRS = $this->data[0]->CA_NumIFRS;
                $this->CT_PrioriteLivr = $this->data[0]->CT_PrioriteLivr;
                $this->CT_LivrPartielle = $this->data[0]->CT_LivrPartielle;
                $this->MR_No = $this->data[0]->MR_No;
                $this->CT_NotPenal = $this->data[0]->CT_NotPenal;
                $this->EB_No = $this->data[0]->EB_No;
                $this->CT_NumCentrale = $this->data[0]->CT_NumCentrale;
                $this->CT_DateFermeDebut = $this->data[0]->CT_DateFermeDebut;
                $this->CT_DateFermeFin = $this->data[0]->CT_DateFermeFin;
                $this->CT_FactureElec = $this->data[0]->CT_FactureElec;
                $this->CT_TypeNIF = $this->data[0]->CT_TypeNIF;
                $this->CT_RepresentInt = $this->data[0]->CT_RepresentInt;
                $this->CT_RepresentNIF = $this->data[0]->CT_RepresentNIF;
                $this->cbMarq = $this->data[0]->cbMarq;
                $this->cbCreateur = $this->data[0]->cbCreateur;
                $this->cbModification = $this->data[0]->cbModification;
            }
        }
    }

    public function initVal(){

    }

    public function maj_client(){

        parent::maj("CT_Intitule" , $this->CT_Intitule);
        parent::maj("CG_NumPrinc" , $this->CG_NumPrinc);
        parent::maj("CT_Contact" , $this->CT_Contact);
        parent::maj("CT_Adresse" , $this->CT_Adresse);
        parent::maj("CT_Complement" , $this->CT_Complement);
        parent::maj("CT_CodePostal" , $this->CT_CodePostal);
        parent::maj("CT_Ville" , $this->CT_Ville);
        parent::maj("CT_CodeRegion" , $this->CT_CodeRegion);
        parent::maj("CT_Pays" , $this->CT_Pays);
        parent::maj("N_Devise" , $this->N_Devise);
        parent::maj("CT_Ape" , $this->CT_Ape);
        parent::maj("CT_Identifiant" , $this->CT_Identifiant);
        parent::maj("CT_Siret" , $this->CT_Siret);
        parent::maj("CO_No" , $this->CO_No);
        parent::maj("N_CatTarif" , $this->N_CatTarif);
        parent::maj("N_CatCompta" , $this->N_CatCompta);
        parent::maj("N_Expedition" , $this->N_Expedition);
        parent::maj("N_Condition" , $this->N_Condition);
        parent::maj("CT_Sommeil" , $this->CT_Sommeil);
        parent::maj("DE_No" , $this->DE_No);
//        parent::maj("N_Analytique" , $this->N_Analytique);
//        parent::maj("CA_Num" , $this->CA_Num);
        parent::maj("CT_Telephone" , $this->CT_Telephone);
        parent::maj("CT_Telecopie" , $this->CT_Telecopie);
        parent::maj("CT_EMail" , $this->CT_EMail);
//        parent::maj("N_AnalytiqueIFRS" , $this->N_AnalytiqueIFRS);
//        parent::maj("CA_NumIFRS" , $this->CA_NumIFRS);
        parent::maj("MR_No" , $this->MR_No);
        parent::maj("CT_Encours" , $this->CT_Encours);
        parent::maj("CT_ControlEnc" , $this->CT_ControlEnc);
    }


    public function controleEncours($typeFacG,$prixG,$acte){
        if($typeFacG=="Vente" || $typeFacG=="BonLivraison" || $typeFacG=="VenteRetour"){
            $montant = str_replace(",", ".", $prixG);
            if($acte=="modif"){
                $montant = $montant-$this->DL_MontantTTC;
            }
            if($this->CT_ControlEnc==2)
            {
                $data = array('message' => "Ce compte client est bloqué !");
                return json_encode($data);
            }

            $rows = $this->getMontantAutorise($montant);

            if($rows->MontantAutorise<0) {
                $data = array('message' => "Le montant de la dette ne doit pas dépasser {$this->objetCollection->formatChiffre($rows->CT_Encours)} !");
                return json_encode($data);
            }
        }
        return null;
    }

    public function controleEncoursQuery(){
        return "DECLARE @message NVARCHAR(1500) = NULL
						,@getMontantAutoriseQuery FLOAT
						,@ctEncours FLOAT = (SELECT CT_Encours FROM F_COMPTET WHERE CT_Num = @ctNum);
					
				IF @typeFacG IN ('Vente','BonLivraison','Retour')
				BEGIN 
					IF @acte = 'modif' 
					BEGIN 
						
					END 
					IF (SELECT CT_ControlEnc FROM F_COMPTET WHERE CT_Num = @ctNum) = 2
						SET @message = 'Ce compte client est bloqué !'
					". $this->getMontantAutoriseQuery()."
					IF @getMontantAutoriseQuery < 0
						SET @message = SELECT CONCAT('Le montant de la dette ne doit pas dépasser ',@ctEncours,' !')
					";
    }
    public function allClients($sommeil=-1) {
        $query = "SELECT CT_Sommeil,C.CT_Intitule,CT_Num,CG_NumPrinc,N_CatTarif,N_CatCompta,P.CT_Intitule AS LibCatTarif,LibCatCompta,
                CT_Adresse,CG_NumPrinc,CT_Telephone,CT_CodeRegion,CT_Ville,CT_Siret,CT_Identifiant,MR_No,DE_No,CA_Num
                FROM F_COMPTET C 
                LEFT JOIN P_CATTARIF P ON P.cbIndice = C.N_CatTarif 
                 LEFT JOIN (select  row_number() over (order by u.subject) as idcompta, u.LibCatCompta 
                 from P_CATCOMPTA 
                 unpivot 
                       ( 
                        LibCatCompta 
                 for subject in (CA_ComptaVen01, CA_ComptaVen02, CA_ComptaVen03, CA_ComptaVen04, CA_ComptaVen05, CA_ComptaVen06, CA_ComptaVen07, CA_ComptaVen08, CA_ComptaVen09, CA_ComptaVen10, CA_ComptaVen11, CA_ComptaVen12, CA_ComptaVen13, CA_ComptaVen14, CA_ComptaVen15, CA_ComptaVen16, CA_ComptaVen17, CA_ComptaVen18, CA_ComptaVen19, CA_ComptaVen20, CA_ComptaVen21, CA_ComptaVen22)
                 ) u) M ON M.idcompta = C.N_CatCompta 
                 WHERE CT_Type=0 
                 AND (-1=$sommeil OR CT_Sommeil=$sommeil)
                 ORDER BY CT_Num";
        $result= $this->db->query($query);
        $this->list = array();
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function allClientsSelect() {
        $query = "
                SELECT 'Tout' CT_Intitule,'0' CT_Num
                UNION
                SELECT C.CT_Intitule,CT_Num
                FROM ".$this->db->baseCompta.".dbo.F_COMPTET C 
                LEFT JOIN P_CATTARIF P ON P.cbIndice = C.N_CatTarif 
                 LEFT JOIN (select  row_number() over (order by u.subject) as idcompta, u.LibCatCompta 
                 from P_CATCOMPTA 
                 unpivot 
                       ( 
                        LibCatCompta 
                 for subject in (CA_ComptaVen01, CA_ComptaVen02, CA_ComptaVen03, CA_ComptaVen04, CA_ComptaVen05, CA_ComptaVen06, CA_ComptaVen07, CA_ComptaVen08, CA_ComptaVen09, CA_ComptaVen10, CA_ComptaVen11, CA_ComptaVen12, CA_ComptaVen13, CA_ComptaVen14, CA_ComptaVen15, CA_ComptaVen16, CA_ComptaVen17, CA_ComptaVen18, CA_ComptaVen19, CA_ComptaVen20, CA_ComptaVen21, CA_ComptaVen22)
                 ) u) M ON M.idcompta = C.N_CatCompta WHERE CT_Type=0
                 ORDER BY CT_Num";
        $result= $this->db->query($query);
        $this->list = array();
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function allFournisseur() {
        $query = "SELECT CT_Sommeil,C.CT_Intitule,CT_Num,CG_NumPrinc,N_CatTarif,N_CatCompta,P.CT_Intitule AS LibCatTarif,LibCatCompta,
                CT_Adresse,CG_NumPrinc,CT_Telephone,CT_CodeRegion,CT_Ville,CT_Siret,CT_Identifiant,MR_No,DE_No,CA_Num
                FROM ".$this->db->baseCompta.".dbo.F_COMPTET C
                LEFT JOIN P_CATTARIF P ON P.cbIndice = C.N_CatTarif 
                 LEFT JOIN (select  row_number() over (order by u.subject) as idcompta, u.LibCatCompta 
                 from P_CATCOMPTA 
                 unpivot 
                      ( 
                        LibCatCompta 
                        for subject in (CA_ComptaAch01, CA_ComptaAch02, CA_ComptaAch03, CA_ComptaAch04, CA_ComptaAch05, CA_ComptaAch06, CA_ComptaAch07, CA_ComptaAch08, CA_ComptaAch09, CA_ComptaAch10, CA_ComptaAch11, CA_ComptaAch12, CA_ComptaAch13, CA_ComptaAch14, CA_ComptaAch15, CA_ComptaAch16, CA_ComptaAch17, CA_ComptaAch18, CA_ComptaAch19, CA_ComptaAch20, CA_ComptaAch21, CA_ComptaAch22) 
                 ) u) M ON M.idcompta = C.N_CatCompta WHERE CT_Type=1
                 ORDER BY CT_Intitule";
        $result= $this->db->query($query);
        $this->list = array();
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function createClientMin(){
        $requete = "INSERT INTO [F_COMPTET] 
             ([CT_Num],[CT_Intitule],[CT_Type],[CG_NumPrinc],[CT_Qualite],[CT_Classement] 
             ,[CT_Contact],[CT_Adresse],[CT_Complement],[CT_CodePostal],[CT_Ville],[CT_CodeRegion] 
             ,[CT_Pays],[CT_Raccourci],[BT_Num],[N_Devise],[CT_Ape],[CT_Identifiant],[CT_Siret],[CT_Statistique01] 
             ,[CT_Statistique02],[CT_Statistique03],[CT_Statistique04],[CT_Statistique05],[CT_Statistique06],[CT_Statistique07] 
             ,[CT_Statistique08],[CT_Statistique09],[CT_Statistique10],[CT_Commentaire],[CT_Encours],[CT_Assurance] 
             ,[CT_NumPayeur],[N_Risque],[CO_No],[N_CatTarif],[CT_Taux01] 
             ,[CT_Taux02],[CT_Taux03],[CT_Taux04],[N_CatCompta],[N_Period],[CT_Facture] 
             ,[CT_BLFact],[CT_Langue],[CT_Edi1],[CT_Edi2],[CT_Edi3],[N_Expedition]
             ,[N_Condition],[CT_DateCreate],[CT_Saut],[CT_Lettrage],[CT_ValidEch],[CT_Sommeil] 
             ,[DE_No],[CT_ControlEnc],[CT_NotRappel],[N_Analytique] 
             ,[CA_Num],[CT_Telephone],[CT_Telecopie],[CT_EMail],[CT_Site],[CT_Coface] 
             ,[CT_Surveillance],[CT_SvDateCreate],[CT_SvFormeJuri],[CT_SvEffectif],[CT_SvCA],[CT_SvResultat] 
             ,[CT_SvIncident],[CT_SvDateIncid],[CT_SvPrivil],[CT_SvRegul],[CT_SvCotation],[CT_SvDateMaj] 
             ,[CT_SvObjetMaj],[CT_SvDateBilan],[CT_SvNbMoisBilan],[N_AnalytiqueIFRS],[CA_NumIFRS] 
             ,[CT_PrioriteLivr],[CT_LivrPartielle],[MR_No],[CT_NotPenal],[EB_No] 
             ,[CT_NumCentrale],[CT_DateFermeDebut],[CT_DateFermeFin],[CT_FactureElec],[CT_TypeNIF] 
             ,[CT_RepresentInt],[CT_RepresentNIF],[cbProt],[cbCreateur],[cbModification],[cbReplication] 
             ,[cbFlag]) 
             VALUES  
                (/*CT_Num*/LEFT('{$this->CT_Num}',17),/*CT_Intitule*/LEFT('{$this->CT_Intitule}',35),/*CT_Type,*/{$this->CT_Type}
                ,/*CG_NumPrinc*/(SELECT CASE WHEN '{$this->CG_NumPrinc}'='' THEN NULL ELSE '{$this->CG_NumPrinc}' END) 
                ,/*CT_Qualite*/'',/*CT_Classement*/LEFT('{$this->CT_Intitule}',17),/*CT_Contact*/''
                ,/*CT_Adresse*/LEFT('".str_replace("'","''",$this->CT_Adresse)."',35),/*CT_Complement*/''
                ,/*CT_CodePostal*/LEFT('{$this->CT_CodePostal}',9),/*CT_Ville*/LEFT('{$this->CT_Ville}',35)
                ,/*CT_CodeRegion*/LEFT('{$this->CT_CodeRegion}',9),/*CT_Pays*/'',/*CT_Raccourci*/''
                ,/*BT_Num*/0,/*N_Devise*/0 ,/*CT_Ape*/'',/*CT_Identifiant*/LEFT('{$this->CT_Identifiant}',25)
                ,/*CT_Siret*/LEFT('{$this->CT_Siret}',15),/*CT_Statistique01*/'',/*CT_Statistique02*/''
                ,/*CT_Statistique03*/'',/*CT_Statistique04*/'',/*CT_Statistique05*/'',/*CT_Statistique06*/''
                ,/*CT_Statistique07*/'',/*CT_Statistique08*/'',/*CT_Statistique09*/'',/*CT_Statistique10*/''
                ,/*CT_Commentaire*/'',/*CT_Encours*/{$this->CT_Encours},/*CT_Assurance*/0,/*CT_NumPayeur*/LEFT('{$this->CT_Num}',17)
                ,/*N_Risque*/1,/*CO_No*/(CASE WHEN {$this->CO_No}='' OR {$this->CO_No}='0' THEN NULL ELSE {$this->CO_No} END)
                ,/*N_CatTarif*/'{$this->N_CatTarif}',/*CT_Taux01*/0,/*CT_Taux02*/0,/*CT_Taux03*/0 
                ,/*CT_Taux04*/0,/*N_CatCompta*/'{$this->N_CatCompta}',/*N_Period*/1,/*CT_Facture*/1 
                ,/*CT_BLFact*/0,/*CT_Langue*/0,/*CT_Edi1*/'',/*CT_Edi2*/''
                ,/*CT_Edi3*/'',/*N_Expedition*/1,/*N_Condition*/1,/*CT_DateCreate*/GETDATE()
                ,/*CT_Saut*/1,/*CT_Lettrage*/1,/*CT_ValidEch*/0,/*CT_Sommeil*/0 
                ,/*DE_No*/(SELECT CASE WHEN '{$this->DE_No}'='0' THEN NULL ELSE '{$this->DE_No}' END)
                ,/*CT_ControlEnc*/{$this->CT_ControlEnc},/*CT_NotRappel*/0,/*N_Analytique*/(CASE WHEN '{$this->CA_Num}'='' THEN NULL ELSE (SELECT N_Analytique FROM F_COMPTEA WHERE CA_Num='{$this->CA_Num}') END)
                ,/*CA_Num*/(CASE WHEN '{$this->CA_Num}'='' THEN NULL ELSE '{$this->CA_Num}' END)
                ,/*CT_Telephone*/LEFT('{$this->CT_Telephone}',21),/*CT_Telecopie*/'' 
                ,/*CT_EMail*/'',/*CT_Site*/'',/*CT_Coface*/'',/*CT_Surveillance*/0
                ,/*CT_SvDateCreate*/'1900-01-01',/*CT_SvFormeJuri*/'',/*CT_SvEffectif*/'',/*CT_SvCA*/0
                ,/*CT_SvResultat*/0,/*CT_SvIncident*/0,/*CT_SvDateIncid*/'1900-01-01',/*CT_SvPrivil*/0
                ,/*CT_SvRegul*/'',/*CT_SvCotation*/'',/*CT_SvDateMaj*/'1900-01-01',/*CT_SvObjetMaj*/''
                ,/*CT_SvDateBilan*/'1900-01-01',/*CT_SvNbMoisBilan*/0,/*N_AnalytiqueIFRS*/0
                ,/*CA_NumIFRS*/NULL,/*CT_PrioriteLivr*/0,/*CT_LivrPartielle*/0,/*MR_No*/{$this->MR_No}
                ,/*CT_NotPenal*/0,/*EB_No*/0
                ,/*CT_NumCentrale*/NULL,/*CT_DateFermeDebut*/'1900-01-01',/*CT_DateFermeFin*/'1900-01-01',/*CT_FactureElec*/0 
                ,/*CT_TypeNIF*/0,/*CT_RepresentInt*/'',/*CT_RepresentNIF*/'',/*cbProt*/0 
                ,/*cbCreateur*/'{$this->userName}',/*cbModification*/GETDATE(),/*cbReplication*/0,/*cbFlag*/0)";
        $this->db->query($requete);
    }

    public function allFournisseurSelect() {
        $query = "  SELECT 'Tout' CT_Intitule,'0' CT_Num
                    UNION
                    SELECT  C.CT_Intitule,CT_Num
                    FROM    F_COMPTET C
                    LEFT JOIN P_CATTARIF P 
                        ON P.cbIndice = C.N_CatTarif 
                    LEFT JOIN (select  row_number() over (order by u.subject) as idcompta, u.LibCatCompta 
                    FROM P_CATCOMPTA 
                    UNPIVOT
                          ( 
                            LibCatCompta 
                            for subject in (CA_ComptaAch01, CA_ComptaAch02, CA_ComptaAch03, CA_ComptaAch04, CA_ComptaAch05, CA_ComptaAch06, CA_ComptaAch07, CA_ComptaAch08, CA_ComptaAch09, CA_ComptaAch10, CA_ComptaAch11, CA_ComptaAch12, CA_ComptaAch13, CA_ComptaAch14, CA_ComptaAch15, CA_ComptaAch16, CA_ComptaAch17, CA_ComptaAch18, CA_ComptaAch19, CA_ComptaAch20, CA_ComptaAch21, CA_ComptaAch22) 
                     ) u) M 
                        ON M.idcompta = C.N_CatCompta 
                     WHERE CT_Type=1
                     ORDER BY CT_Intitule";
        $result= $this->db->query($query);
        $this->list = array();
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getCodeAuto($type) {
        $query = "  SELECT T_Racine
                    FROM  P_TIERS
                    WHERE ('$type'='Client' AND T_Val01T_Intitule='Cl.')
                    OR   ('$type'='Fournisseur' AND T_Val01T_Intitule='Fr.')
                    OR   ('$type'='Salarie' AND T_Val01T_Intitule='Sal.')";
        $result= $this->db->query($query);
        $this->list = array();
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if(sizeof($rows)>0)
            return $rows[0]->T_Racine;
        else
            return "";
    }

    public function getFLivraisonByCTNum($ct_num) {
        $query = "SELECT  ISNULL((SELECT  Max(LI_No) 
                                  FROM    F_LIVRAISON 
                                  WHERE   cbCT_Num ='{$ct_num}'),0) AS LI_No";
        $result= $this->db->query($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);

    }
    public function getfirstClientDivers() {
        $query = "    SELECT TOP 1 CT_Num
                    FROM F_COMPTET
                    WHERE CT_Type=0
                    AND CT_Intitule like  '%DIVERS%'";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ)[0]->CT_Num;

    }

    public function tiersByCTIntitule($val) {
        $query = "  SELECT cbMarq
                    FROM  F_COMPTET
                    WHERE CT_Intitule='$val'";
        $result= $this->db->query($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if(sizeof($rows)>0)
            return $rows[0]->cbMarq;
        else
            return null;
    }

    public function ctNum() {
        $query = "  SELECT *
                    FROM  F_COMPTET
                    WHERE CT_Num='{$this->CT_Num}'";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function optionTiers($type,$value)
    {
        $liste = [];
        if ($type == 0)
            $liste = $this->allClients();
        else
            $liste = $this->allFournisseur();
        $html="";
        foreach ($liste as $row) {
            $html = $html ."<option value='{$row->CT_Num}'";
            if ($value == $row->CT_Num)
                $html." selected";
            $html = $html.">{$row->CT_Intitule}</option>";
        }
        return $html;
    }

    public function listeClientPagination(){
        if (!empty($_POST) ) {
            /* Useful $_POST Variables coming from the plugin */
            $draw = $_POST["draw"];//counter used by DataTables to ensure that the Ajax returns from server-side processing requests are drawn in sequence by DataTables
            $orderByColumnIndex  = $_POST['order'][0]['column'];// index of the sorting column (0 index based - i.e. 0 is the first record)
            $orderBy = $_POST['columns'][$orderByColumnIndex]['data'];//Get name of the sorting column from its index
            $orderType = $_POST['order'][0]['dir']; // ASC or DESC
            $start  = $_POST["start"];//Paging first record indicator.
            $length = $_POST['length'];//Number of records that the table can display in the current draw
            /* END of POST variables */
            $query="SELECT * FROM (SELECT CT_Num,C.CT_Intitule,CG_NumPrinc,P.CT_Intitule AS LibCatTarif,LibCatCompta,PROT_User
                                            FROM F_COMPTET C 
                                            LEFT JOIN P_CATTARIF P ON P.cbIndice = C.N_CatTarif 
                                            LEFT JOIN F_PROTECTIONCIAL Pr ON CAST(Pr.PROT_No AS VARCHAR(5)) = C.cbCreateur
                                             LEFT JOIN (select  row_number() over (order by u.subject) as idcompta, u.LibCatCompta 
                                             from P_CATCOMPTA 
                                             unpivot 
                                                   ( 
                                                    LibCatCompta 
                                             for subject in (CA_ComptaVen01, CA_ComptaVen02, CA_ComptaVen03, CA_ComptaVen04, CA_ComptaVen05, CA_ComptaVen06, CA_ComptaVen07, CA_ComptaVen08, CA_ComptaVen09, CA_ComptaVen10, CA_ComptaVen11, CA_ComptaVen12, CA_ComptaVen13, CA_ComptaVen14, CA_ComptaVen15, CA_ComptaVen16, CA_ComptaVen17, CA_ComptaVen18, CA_ComptaVen19, CA_ComptaVen20, CA_ComptaVen21, CA_ComptaVen22)
                                             ) u) M ON M.idcompta = C.N_CatCompta WHERE CT_Type=".$_GET['CT_Type']." AND (-1 = ".$_GET['CT_Sommeil']." OR CT_Sommeil=".$_GET['CT_Sommeil']."))A 
                                             ";
            $result = $this->db->query($query);
            $recordsTotal = count($result->fetchAll(PDO::FETCH_OBJ));

            /* SEARCH CASE : Filtered data */
            if(!empty($_POST['search']['value'])){

                /* WHERE Clause for searching */
                for($i=0 ; $i<count($_POST['columns']);$i++){
                    $column = $_POST['columns'][$i]['data'];//we get the name of each column using its index from POST request
                    $where[]=" (CT_Num like '%".$_POST['search']['value']."%' OR CT_Intitule like '%".$_POST['search']['value']."%') ";
                }
                $where = " WHERE ".implode(" OR " , $where);// id like '%searchValue%' or name like '%searchValue%' ....
                /* End WHERE */

                $sql = sprintf("$query %s", $where);//Search query without limit clause (No pagination)
                $result = $this->db->query($sql);

                $recordsFiltered = count($result->fetchAll(PDO::FETCH_OBJ));//Count of search result

                /* SQL Query for search with limit and orderBy clauses*/
                $sql = sprintf("$query %s ORDER BY %s %s OFFSET %d ROWS FETCH NEXT %d ROWS ONLY",$where,$orderBy,$orderType ,$start , $length);
                //$sql = sprintf("$query %s ORDER BY %s %s OFFSET %d ROWS FETCH NEXT %d ROWS ONLY %d , %d ", $where ,$orderBy, $orderType ,$start,$length  );
//            $sql = $query." $where ORDER BY $orderBy $orderType OFFSET $start ROWS FETCH NEXT $length ROWS ONLY ";
                $result = $this->db->query($sql);
                $data = $result->fetchAll(PDO::FETCH_OBJ);
            }
            /* END SEARCH */
            else {
                $sql = sprintf("$query ORDER BY %s %s OFFSET %d ROWS FETCH NEXT %d ROWS ONLY",$orderBy,$orderType ,$start , $length);
                //$sql = $query." $where ORDER BY $orderBy $orderType OFFSET $start ROWS FETCH NEXT $length ROWS ONLY ";
                $result = $this->db->query($sql);
                $data = $result->fetchAll(PDO::FETCH_OBJ);
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

    public function TiersDoublons(){
        $query="SELECT CT_Intitule
                FROM (
                SELECT CT_Intitule,COUNT(CT_Num) Nb
                FROM F_COMPTET
                GROUP BY CT_Intitule)A
                WHERE Nb>1";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getTiersByIntitule($intitule){
        $query="SELECT CT_Num
                FROM F_COMPTET
                WHERE CT_Intitule='$intitule'";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getTiersByNum($num){
        $query="SELECT CT_Intitule
                FROM F_COMPTET
                WHERE cbCT_Num='$num'";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getTiersByNumIntitule($intitule,$type,$select=-1,$CT_Sommeil=-1){
        $value =str_replace(" ","%",$intitule);
        return $this->getApiJson("/getTiersByNumIntituleSearch&intitule=$value&type=$type&ctSommeil=$CT_Sommeil");
//        return $rows;
    }



    public function getMontantAutoriseQuery(){
        return "      	DECLARE @CT_Num AS VARCHAR(50) 
						SET @CT_Num = @ctNum;
						
                        WITH _DocRegl_ AS (
                            SELECT	DR_No
									,avance = SUM(RC_MONTANT)  
                            FROM	F_REGLECH R 
                            INNER JOIN F_Creglement Re 
                                on 	Re.RG_No=R.RG_No 
                            WHERE 	Re.CT_NumPayeur= @CT_Num
                            GROUP BY DR_No
                        )
                        , _DocEntete_ AS (
                            SELECT	R.DR_No
                                    ,DO_Tiers
                                    ,E.DO_Domaine
                                    ,E.DO_Type
                                    ,DO_Provenance
                                    ,avance = SUM(ISNULL(avance,0)) 
                                    ,DL_MontantTTC = SUM(ISNULL(DL_MontantTTC,0))  
                            FROM	F_DOCENTETE E 
                            LEFT JOIN	F_DOCLIGNE L 
                                ON	E.cbDO_Piece=L.cbDO_Piece 
                                AND E.DO_Domaine= L.DO_Domaine 
                                AND E.DO_Type=L.DO_Type  
                            LEFT JOIN F_DOCREGL R 
                                ON	R.cbDO_Piece=E.cbDO_Piece 
                                AND R.DO_Type=E.DO_Type 
                                AND R.DO_Domaine=E.DO_Domaine
                            LEFT JOIN _DocRegl_ dregl
                                ON	R.DR_No = dregl.DR_No
                            WHERE 	E.DO_Tiers= @CT_Num
                            AND		ISNULL(r.dr_regle,0)=0 
                            GROUP BY R.DR_No
                                    ,E.DO_Tiers
                                    ,E.DO_Provenance
                                    ,E.DO_Domaine
                                    ,E.DO_Type
                        )
                        
                        , _RequeteStart_ AS (
                            SELECT	CT_ControlEnc
                                    ,CT_Encours
                                    ,DO_Provenance
                                    ,DL_MontantTTC
                                    ,avance
                                    ,CT_Num
                                    ,DO_Domaine
                                    ,DO_Type
                            FROM 	_DocEntete_ E
                            INNER JOIN F_COMPTET C 
                                ON 	C.CT_Num=E.DO_Tiers 
                        )
                        , _Requete_ AS (
                            SELECT	MAX(CT_ControlEnc)CT_ControlEnc
                                    ,MAX(CT_Encours) CT_Encours
                                    ,DO_Provenance
                                    ,ROUND(SUM(DL_MontantTTC),0) AS ttc
                                    ,ISNULL(sum(avance),0) AS avance 
                            FROM	_RequeteStart_
                            WHERE 	((DO_Domaine=0 AND (DO_Type=6 OR DO_Type=7) AND DO_Provenance IN(0,1)) 
                                        OR (DO_Domaine=1 AND (DO_Type=16 OR DO_Type=17 OR DO_Type=12)) ) 
                            GROUP BY DO_Provenance
                        )
                        SELECT 	CT_Encours ,TTC 
								,MontantDette = CT_Encours-TTC 
                                ,@getMontantAutoriseQuery = CASE WHEN CT_ControlEnc=0 AND CT_Encours !=0 THEN CT_Encours-@DL_MontantTTC-TTC 
																	WHEN (CT_ControlEnc=0 AND CT_Encours =0) THEN 1 
																		WHEN CT_ControlEnc!=0 THEN 1 END 
                        FROM(	SELECT	TTC = SUM(TTC)
										,CT_Encours = MAX(CT_Encours)
										,CT_ControlEnc = MAX(CT_ControlEnc) 
                                FROM 	_Requete_ A 
								WHERE 	((DO_Provenance =0 AND ttc>0) OR DO_Provenance=1) 
								AND 	NOT (TTC=AVANCE) 
						)A
";
    }

    public function getMontantAutorise($montant){
        $requete="      DECLARE @CT_Num AS VARCHAR(50) 
                        DECLARE @Montant AS FLOAT 
                        
                        SET @CT_Num = '{$this->CT_Num}'
                        SET @Montant = $montant
                        ;
                        WITH _DocRegl_ AS (
                            SELECT	DR_No, SUM(RC_MONTANT) avance 
                            FROM	F_REGLECH R 
                            INNER JOIN F_Creglement Re 
                                on Re.RG_No=R.RG_No 
                            WHERE Re.cbCT_NumPayeur= @CT_Num
                            GROUP BY DR_No
                        )
                        , _DocEntete_ AS (
                            SELECT	R.DR_No
                                    ,DO_Tiers
                                    ,E.DO_Domaine
                                    ,E.DO_Type
                                    ,DO_Provenance
                                    ,SUM(ISNULL(avance,0)) avance
                                    ,SUM(ISNULL(DL_MontantTTC,0)) DL_MontantTTC 
                            FROM	F_DOCENTETE E 
                            LEFT JOIN	F_DOCLIGNE L 
                                ON	E.DO_Piece=L.DO_Piece 
                                AND E.DO_Domaine= L.DO_Domaine 
                                AND E.DO_Type=L.DO_Type  
                            LEFT JOIN F_DOCREGL R 
                                ON	R.DO_Piece=E.DO_Piece 
                                AND R.DO_Type=E.DO_Type 
                                AND R.DO_Domaine=E.DO_Domaine
                            LEFT JOIN _DocRegl_ dregl
                                ON	R.DR_No = dregl.DR_No
                            WHERE E.cbDO_Tiers= @CT_Num
                            AND		ISNULL(r.dr_regle,0)=0 
                            GROUP BY R.DR_No
                                    ,E.DO_Tiers
                                    ,E.DO_Provenance
                                    ,E.DO_Domaine
                                    ,E.DO_Type
                        )
                        
                        , _RequeteStart_ AS (
                            SELECT	CT_ControlEnc
                                    ,CT_Encours
                                    ,DO_Provenance
                                    ,DL_MontantTTC
                                    ,avance
                                    ,CT_Num
                                    ,DO_Domaine
                                    ,DO_Type
                            FROM _DocEntete_ E
                            INNER JOIN F_COMPTET C 
                                ON C.CT_Num=E.DO_Tiers 
                        )
                        , _Requete_ AS (
                            SELECT	MAX(CT_ControlEnc)CT_ControlEnc
                                    ,MAX(CT_Encours) CT_Encours
                                    ,DO_Provenance
                                    ,ROUND(SUM(DL_MontantTTC),0) AS ttc
                                    ,ISNULL(sum(avance),0) AS avance 
                            FROM	_RequeteStart_
                            WHERE ((DO_Domaine=0 AND (DO_Type=6 OR DO_Type=7) AND DO_Provenance IN(0,1)) 
                                        OR (DO_Domaine=1 AND (DO_Type=16 OR DO_Type=17 OR DO_Type=12)) ) 
                            GROUP BY DO_Provenance
                        )
                        SELECT CT_Encours ,TTC ,CT_Encours-TTC MontantDette 
                                ,CASE WHEN CT_ControlEnc=0 AND CT_Encours !=0 THEN CT_Encours-@Montant-TTC 
                                        WHEN (CT_ControlEnc=0 AND CT_Encours =0) THEN 1 
                                            WHEN CT_ControlEnc!=0 THEN 1 END MontantAutorise 
                        FROM(	SELECT	SUM(TTC)TTC,MAX(CT_Encours)CT_Encours,MAX(CT_ControlEnc)CT_ControlEnc 
                                FROM _Requete_ A 
                        WHERE ((DO_Provenance =0 AND ttc>0) OR DO_Provenance=1) AND NOT (TTC=AVANCE) )A
";
        $result= $this->db->query($requete);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        return $rows[0];
    }

    public function remplacementTiers($CT_NumAncien,$CT_NumNouveau){
        $query="
            BEGIN 
                SET NOCOUNT ON;
                DECLARE @nouveau as VARCHAR(200)
                DECLARE @ancien as VARCHAR(200)
                DECLARE @LI_No as INT
                DECLARE @LI_NoOld as INT
                set @nouveau ='$CT_NumNouveau'
                set @ancien ='$CT_NumAncien'
                                
                SELECT @LI_NoOld=LI_No
                FROM F_LIVRAISON
                WHERE CT_Num=@ancien   
                
                SELECT @LI_No=LI_No
                FROM F_LIVRAISON
                WHERE CT_Num=@nouveau
                 
                update F_CREGLEMENT set CT_NumPayeur=@nouveau WHERE CT_NumPayeur=@ancien
                update F_CREGLEMENT set CT_NumPayeurOrig=@nouveau WHERE CT_NumPayeurOrig=@ancien
                update F_DOCENTETE set LI_No=@LI_No WHERE LI_No=@LI_NoOld
                update F_DOCENTETE set CT_NumPayeur=@nouveau WHERE CT_NumPayeur=@ancien
                update F_DOCENTETE set DO_Tiers=@nouveau WHERE DO_Tiers=@ancien
                UPDATE F_DOCLIGNE set CT_Num=@nouveau WHERE CT_Num=@ancien
                UPDATE F_TICKETARCHIVE set CT_Num=@nouveau WHERE CT_Num=@ancien
                UPDATE F_ECRITUREC set CT_Num=@nouveau WHERE CT_Num=@ancien
                UPDATE F_ECRITUREC set CT_NumCont=@nouveau WHERE CT_NumCont=@ancien
                DELETE FROM F_REGLEMENTT WHERE CT_Num=@ancien
                DELETE FROM F_LIVRAISON WHERE CT_Num=@ancien
                DELETE FROM F_COMPTETG WHERE CT_Num=@ancien
                DELETE FROM F_COMPTETMEDIA WHERE CT_Num=@ancien
                DELETE FROM F_COMPTETMODELE WHERE CT_Num=@ancien
                DELETE FROM F_COMPTETRAPPEL WHERE CT_Num=@ancien   
                UPDATE F_COMPTET SET CT_Sommeil=1 WHERE CT_Num=@ancien  
            END";
        $this->db->query($query);
    }

    public function __toString() {
        return "";
    }
}
