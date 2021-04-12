<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class BanqueClass Extends Objet{
    //put your code here
    public $db
        ,$BQ_No
        ,$BQ_Intitule
        ,$BQ_Adresse
    ,$BQ_Complement
    ,$BQ_CodePostal
    ,$BQ_Ville
    ,$BQ_CodeRegion
    ,$BQ_Pays
    ,$BQ_Contact
    ,$BQ_Abrege
    ,$BQ_ModeRemise
    ,$BQ_BordRemise
    ,$JO_Num
    ,$CA_No
    ,$cbMarq
    ,$cbCreateur
    ,$cbModification;

    public $table = 'F_BANQUE';

    function __construct($id,$db=null)
    {
        parent::__construct($this->table, $id, 'BQ_No',$db);
        if (sizeof($this->data) > 0) {

            $this->CA_No = 1;
            $this->BQ_No = $this->data[0]->BQ_No;
            $this->BQ_Intitule = $this->data[0]->BQ_Intitule;
            $this->BQ_Adresse = $this->data[0]->BQ_Adresse;
            $this->BQ_Complement = $this->data[0]->BQ_Complement;
            $this->BQ_CodePostal = $this->data[0]->BQ_CodePostal;
            $this->BQ_Ville = $this->data[0]->BQ_Ville;
            $this->BQ_CodeRegion = $this->data[0]->BQ_CodeRegion;
            $this->BQ_Pays = $this->data[0]->BQ_Pays;
            $this->BQ_Contact = $this->data[0]->BQ_Contact;
            $this->BQ_Abrege = $this->data[0]->BQ_Abrege;
            $this->BQ_ModeRemise = $this->data[0]->BQ_ModeRemise;
            $this->BQ_BordRemise = $this->data[0]->BQ_BordRemise;
            $this->cbMarq = $this->data[0]->cbMarq;
            $this->cbCreateur = $this->data[0]->cbCreateur;
            $this->cbModification = $this->data[0]->cbModification;
            $query ="SELECT JO_Num FROM F_EBANQUE WHERE BQ_No={$this->BQ_No}";
            $result= $this->db->query($query);
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if(sizeof($rows)>0)
                $this->JO_Num = $rows[0]->JO_Num;
            else
                $this->JO_Num = "";
        }
    }

    public function setuserName($login,$mobile){
        if(!isset($_SESSION))
            session_start();
        if($login!="")
            $this->cbCreateur = $login;
        else
            if($mobile==""){
                $this->cbCreateur = $_SESSION["id"];
            }
    }


    public function maj_article(){
        parent::maj("BQ_Intitule" , $this->BQ_Intitule);
        parent::maj("BQ_Adresse" , $this->BQ_Adresse);
        parent::maj("BQ_Complement" , $this->BQ_Complement);
        parent::maj("BQ_CodePostal" , $this->BQ_CodePostal);
        parent::maj("BQ_Ville" , $this->BQ_Ville);
        parent::maj("BQ_CodeRegion" , $this->BQ_CodeRegion);
        parent::maj("BQ_Pays" , $this->BQ_Pays);
        parent::maj("BQ_Contact" , $this->BQ_Contact);
        parent::maj("BQ_Abrege" , $this->BQ_Abrege);
        parent::maj("BQ_ModeRemise" , $this->BQ_ModeRemise);
        parent::maj("BQ_BordRemise" , $this->BQ_BordRemise);
        parent::maj("cbCreateur" , $this->userName);
        parent::maj("cbModification" , $this->cbModification);
        $this->majcbModification();
        parent::maj("cbCreateur" , $this->cbCreateur);
    }


    public function insertFArtModele(){
        $query ="INSERT INTO [dbo].[F_ARTMODELE]
                    ([AR_Ref],[MO_No],[AM_Domaine],[cbProt]
                    ,[cbCreateur],[cbModification],[cbReplication],[cbFlag])
              VALUES
                    (/*AR_Ref*/'{$this->AR_Ref}',/*MO_No*/(SELECT MAX(MO_No) FROM F_MODELE),/*AM_Domaine*/0,/*cbProt*/0
                    ,/*cbCreateur*/'{$this->userName}',/*cbModification*/CAST(GETDATE() AS DATE),/*cbReplication*/0,/*cbFlag*/0)";
        $this->db->query($query);
    }

    public function all(){
        $query = "  SELECT ba.*
                    FROM    F_BANQUE ba
                    LEFT JOIN F_EBANQUE eba
                        ON ba.BQ_No = eba.BQ_No
                    WHERE eba.BQ_No IS NOT NULL
        ";

        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function addReglementBanque($rg_typereg,$montant,$cg_num,$jo_num,$co_nocaissier,$libelle,$banque,$login,$date,$bqNo,$journalRec,$caNoDest,$CA_Num,$CG_Analytique)
    {
        $banque = new BanqueClass($bqNo,$this->db);
        $creglement = new ReglementClass(0,$this->db);
        try {
            $this->db->connexion_bdd->beginTransaction();
            if ($rg_typereg != 16) {
                $rg_typeregVal = $rg_typereg;
                if ($rg_typereg == 6)
                    $rg_typeregVal = 5;
                if ($rg_typereg == 6) {
                    $caisse = new CaisseClass($bqNo, $this->db);

                    $creglement->setReglement('NULL', $this->objetCollection->getDate($date), $montant, $journalRec, $cg_num, $banqueClass->CA_No, $co_nocaissier, $this->objetCollection->getDate($date), $libelle, 0, 2, 1, $rg_typeregVal, 1, 1, $login);
                    $rg_no = $creglement->insertF_Reglement();
                    $creglement->setReglement('NULL', $this->objetCollection->getDate($date), $montant, $caisse->JO_Num, $cg_num, $banqueClass->CA_No, $co_nocaissier, $this->objetCollection->getDate($date), $libelle . "_" . $banque->JO_Num, 0, 2, 8, 4, 1, 1, $login);
                    $rg_noDest = $creglement->insertF_Reglement();
                    $creglement->insertF_ReglementVrstBancaire($rg_no, $rg_noDest);
                } else {
                    $banqueClass = new BanqueClass($bqNo, $this->db);
                    if($rg_typereg == 2) {
                        $rg_typereg = 4;
                        $libelle = "*agio $libelle";
                    }
                    $creglement->setReglement('NULL', $this->objetCollection->getDate($date), $montant, $banqueClass->JO_Num, $cg_num, $banqueClass->CA_No, $co_nocaissier, $this->objetCollection->getDate($date), $libelle, 0, 2, 1, $rg_typeregVal, 1, 15, $login);
                    $rg_no = $creglement->insertF_Reglement();
                }
            } else {
                $this->db->connexion_bdd->beginTransaction();
                $creglement->setReglement('NULL', $this->objetCollection->getDate($date), $montant, $jo_num, $cg_num, $banqueClass->CA_No, $co_nocaissier, $this->objetCollection->getDate($date), $libelle, 0, 2, 1, 4, 1, $banque, $login);
                $rg_no = $creglement->insertF_Reglement();
                $caisseDest = new CaisseClass($caNoDest);
                $creglement->setReglement('NULL', $this->objetCollection->getDate($date), $montant, $caisseDest->JO_Num, $cg_num, $caisseDest->CA_No, $caisseDest->CO_NoCaissier, $this->objetCollection->getDate($date), $libelle, 0, 2, 1, 5, 1, $banque, $login);
                $rg_no = $creglement->insertF_Reglement();
            }

        if ($rg_typereg == 4) {
            /*
            try {
                $objet->db->connexion_bdd->beginTransaction();
                $message = "SORTIE D' UN MONTANT DE {$objet->formatChiffre($montant)} POUR $libelle DANS LA CAISSE $ca_intitule  SAISI PAR $user LE " . date("d/m/Y", strtotime($objet->getDate($_POST['date'])));
                $result = $objet->db->requete($objet->getCollaborateurEnvoiMail("Mouvement de sortie"));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if ($rows != null) {
                    foreach ($rows as $row) {
                        $email = $row->CO_EMail;
                        $collab_intitule = $row->CO_Nom;
                        if (($email != "" || $email != null)) {
                            $mail = new Mail();
                            $mail->sendMail($message."<br/><br/><br/> {$objet->db->db}", $email,  "Mouvement de sortie");
                        }
                    }
                }

                $result = $objet->db->requete($objet->getCollaborateurEnvoiSMS("Mouvement de sortie"));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if ($rows != null) {
                    foreach ($rows as $row) {
                        $telephone = $row->CO_Telephone;
                        if (($telephone != "" || $telephone != null)) {
                            $message = "SORTIE DE {$objet->formatChiffre($montant)} POUR $libelle LE " . date('d/m/Y', strtotime($objet->getDate($_POST['date']))) . " DANS $ca_intitule";
                            $contactD = new ContatDClass(1,$objet->db);
                            $contactD->sendSms($telephone, $message);
                        }
                    }
                }
                $objet->db->connexion_bdd->commit();
            }
            catch(Exception $e){
                $objet->db->connexion_bdd->rollBack();
                return json_encode($e);
            }
            */
        }

        if ($rg_typereg == 6) {
            /*
            try {
                $objet->db->connexion_bdd->beginTransaction();
                $message = "VERSEMENT BANCAIRE D'UN MONTANT DE $montant DANS LA CAISSE $ca_intitule SAISI PAR $user LE {$objet->getDate($_POST['date'])}";
                $result = $objet->db->requete($objet->getCollaborateurEnvoiMail("Versement bancaire"));
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

                $result = $objet->db->requete($objet->getCollaborateurEnvoiSMS("Versement bancaire"));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if ($rows != null) {
                    foreach ($rows as $row) {
                        $telephone = $row->CO_Telephone;
                        if (($telephone != "" || $telephone != null)) {
                            $message = "SORTIE DE $montant POUR $libelle LE {$objet->getDate($_POST['date'])} DANS $ca_intitule";
                            $contactD = new ContatDClass(1,$objet->db);
                            $contactD->sendSms($telephone, $message);
                        }
                    }
                }
                $objet->db->connexion_bdd->commit();
            }
            catch(Exception $e){
                $objet->db->connexion_bdd->rollBack();
                return json_encode($e);
            }
            */
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

    public function modifReglementBanque($rg_typeregModif,$RG_NoLigne,$date,$BQ_No,$libelle,$CG_NumBanque,$montant,$journalRec,$RG_NoDestLigne,$CA_No_Dest)
    {
        try {
            $this->db->connexion_bdd->beginTransaction();
            if ($rg_typeregModif == 4 || $rg_typeregModif == 2 || $rg_typeregModif == 5) {
                $creglement = new ReglementClass($RG_NoLigne,$this->db);
                $creglement->RG_Date = $this->objetCollection->getDate($date);
                $banqueClass = new BanqueClass($BQ_No,$this->db);
                $creglement->JO_Num = $banqueClass->JO_Num;
                $creglement->CA_No = 1;
                $creglement->RG_Libelle = $libelle;
                $creglement->CG_Num = $CG_NumBanque;


                $creglement->RG_Montant = str_replace(" ", "", $montant);
                $creglement->maj_reglement();
            }

            if ($rg_typeregModif == 6) {
                $creglement = new ReglementClass($RG_NoLigne,$this->db);
                $creglement->RG_Date = $this->objetCollection->getDate($date);
                $banqueClass = new BanqueClass($BQ_No,$this->db);
                $creglement->CA_No = $banqueClass->CA_No;
                $creglement->RG_Libelle = $libelle;
                $creglement->CG_Num = $CG_NumBanque;
                $creglement->RG_TypeReg = 5;
                $creglement->RG_Montant = str_replace(" ", "", $montant);
                $creglement->JO_Num = $journalRec;
                $creglement->maj_reglement();
            }

            if ($rg_typeregModif == 16) {
                $creglement = new ReglementClass($RG_NoLigne,$this->db);
                $creglement->RG_Date = $this->objetCollection->getDate($date);
                $creglement->CA_No = $CA_No;
                $caisse = new CaisseClass($CA_No,$this->db);
                $creglement->JO_Num = $caisse->JO_Num;
                $creglement->RG_Libelle = $libelle;
                $creglement->CG_Num = $CG_NumBanque;
                $creglement->RG_TypeReg = 4;
                $creglement->RG_Montant = str_replace(" ", "", $montant);
                $creglement->maj_reglement();

                $creglement = new ReglementClass($RG_NoDestLigne,$this->db);
                $creglement->RG_Date = $this->objetCollection->getDate($date);
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

    public function listeReglementBanque($datedeb,$datefin,$bq_no,$type,$protNo){
        if($bq_no==-1)
            $bq_no=0;
        $query = "BEGIN 
                        DECLARE @ProtNo AS INT
                        DECLARE @CA_No AS INT
                        DECLARE @BQ_No AS INT
                        DECLARE @DateDeb AS VARCHAR(10)
                        DECLARE @DateFin AS VARCHAR(10)
                        DECLARE @Type AS INT
                        
                        SET @ProtNo = $protNo
                        SET @CA_No = 0
						SET @BQ_No = '$bq_no'
                        SET @DateDeb = '$datedeb'
                        SET @DateFin = '$datefin'
                        SET @Type = $type;
                        
                        CREATE TABLE #TMPCAISSE (CA_No INT)
                        SET NOCOUNT ON;
                        
                        IF (SELECT CASE WHEN PROT_Administrator=1 OR PROT_Right=1 THEN 1 ELSE 0 END FROM F_PROTECTIONCIAL WHERE Prot_No=@ProtNo) = 1 
                        BEGIN 
                            INSERT INTO #TMPCAISSE
                            SELECT	ISNULL(CA.CA_No,0) CA_No 
                            FROM F_CAISSE CA
                            INNER JOIN Z_DEPOTCAISSE C 
                                ON CA.CA_No=C.CA_No
                            INNER JOIN F_DEPOT D 
                                ON C.DE_No=D.DE_No
                            INNER JOIN F_COMPTET CT 
                                ON CT.cbCT_Num = CA.cbCT_Num
                            WHERE (@CA_No=0 OR @CA_No=CA.CA_No)
                            GROUP BY CA.CA_No
                        END 
                        ELSE 
                        BEGIN 
                            INSERT INTO #TMPCAISSE
                            SELECT	ISNULL(CA.CA_No,0) CA_No
                            FROM F_CAISSE CA
                            LEFT JOIN Z_DEPOTCAISSE C 
                                ON CA.CA_No=C.CA_No
                            LEFT JOIN (	SELECT * 
                                        FROM Z_DEPOTUSER
                                        WHERE IsPrincipal=1) D 
                                ON C.DE_No=D.DE_No
                            LEFT JOIN F_COMPTET CT 
                                ON CT.cbCT_Num = CA.cbCT_Num
                            WHERE Prot_No=@ProtNo
                            AND	(@CA_No=0 OR @CA_No=CA.CA_No)
                            GROUP BY CA.CA_No
                        END;

SELECT RG_No,RG_Piece,CA_No,16 RG_TypeReg,CG_Num
                    ,RG_Banque,RG_Type,RG_Montant,RG_Date
                    ,RG_Impute,RG_Libelle,CO_NoCaissier
                    ,CA_No_Dest
                    ,RG_No_Source,RG_No_Dest
                    ,JO_Num into #tmpTrsft
FROM (          SELECT  count(*) nb,0 RG_No,RG_Piece
                        ,SUM(CASE WHEN RG_TypeReg=4 THEN CA_No ELSE 0 END)CA_No,16 RG_TypeReg,CG_Num
                        ,SUM(CASE WHEN RG_TypeReg=4 THEN RG_No ELSE 0 END)RG_No_Source
                        ,SUM(CASE WHEN RG_TypeReg=5 THEN RG_No ELSE 0 END)RG_No_Dest
                        ,RG_Banque,RG_Type,RG_Montant,RG_Date
                        ,RG_Impute,RG_Libelle,CO_NoCaissier
                        ,SUM(CASE WHEN RG_TypeReg=5 THEN CA_No ELSE 0 END)CA_No_Dest
                        ,'' JO_Num 
                FROM    F_CREGLEMENT 
                WHERE   ((@Type) IN(-1,16) AND RG_TypeReg IN (5,4))
                AND     RG_Banque = 0
                GROUP BY RG_Piece,CG_Num
                    ,RG_Banque,RG_Type,RG_Montant,RG_Date
                    ,RG_Impute,RG_Libelle,CO_NoCaissier)A
                    	WHERE nb=2;

                    SELECT C.RG_No,RG_Piece,C.CA_No,CA_No_Dest,CO_Nom
                          ,CA_Intitule,CO.CO_No,RG_TypeReg
                          ,C.CG_Num,CONCAT(CONCAT(C.CG_Num,' - '),CG_Intitule) CG_Intitule
                          ,RG_Banque,RG_Type,RG_Montant,CAST(RG_Date AS DATE) RG_Date
                          ,RG_Impute,RG_Libelle,Lien_Fichier
                          ,ISNULL(ZCPTEA.CA_Num,'') CA_Num
                          ,ZCPTEA.CA_IntituleText
                          ,RG_No_Source,RG_No_Dest 
                          ,C.JO_Num,eba.BQ_No
                FROM (  
                    SELECT RG_No,RG_Piece,CA_No,RG_TypeReg,CG_Num
                    ,RG_Banque,RG_Type,RG_Montant,RG_Date
                    ,RG_Impute,RG_Libelle,CO_NoCaissier
                    ,CA_No_Dest
                    ,RG_No_Source,RG_No_Dest 
                    ,JO_Num 
                    FROM #tmpTrsft

                    UNION
                        SELECT  RG_No,RG_Piece,CA_No,6 RG_TypeReg,CG_Num
                                ,RG_Banque,RG_Type,RG_Montant,RG_Date
                                ,RG_Impute,RG_Libelle,CO_NoCaissier
                                ,0 CA_No_Dest,RG_No RG_No_Source,0 RG_No_Dest 
                                ,JO_Num 
                        FROM    F_CREGLEMENT 
                        WHERE   (('-1' IN (@Type) AND RG_TypeReg IN ('5') AND RG_Banque=1) 
                        OR (@Type=6 AND RG_TypeReg IN (5) AND RG_Banque=1))
                        UNION
                        SELECT  RG_No,RG_Piece,CA_No,RG_TypeReg,CG_Num
                                ,RG_Banque,RG_Type,RG_Montant,RG_Date
                                ,RG_Impute,RG_Libelle,CO_NoCaissier
                                ,0 CA_No_Dest,RG_No RG_No_Source,0 RG_No_Dest 
                                ,JO_Num 
                        FROM    F_CREGLEMENT 
                        WHERE   
                        (RG_No NOT IN (SELECT RG_No_Source FROM #tmpTrsft) AND RG_No NOT IN (SELECT RG_No_Dest FROM #tmpTrsft))
                        AND ('-1' IN (@Type) AND (((RG_TypeReg IN ('2','4','3','5') AND RG_Banque=15) OR (RG_TypeReg=4 AND RG_Banque=1)) ) 
                        OR (@Type NOT IN (6,4) AND RG_TypeReg =@Type) 
                        OR (@Type=6 AND RG_TypeReg =4 AND RG_Banque=1)
                        OR (@Type=5 AND RG_TypeReg =5 AND RG_Banque=15)
                        OR (@Type=4 AND RG_TypeReg =4 AND RG_Banque=15)
						)) C
                LEFT JOIN F_CAISSE CA 
                    ON C.CA_No=CA.CA_No
				INNER JOIN F_EBANQUE eba
					ON eba.JO_Num = C.JO_Num
                LEFT JOIN F_COMPTEG CptG 
                    ON CptG.CG_Num=C.CG_Num
                LEFT JOIN ( SELECT RG_No,A.CA_Num,CONCAT(CONCAT(A.CA_Num,' - '),CA_Intitule) CA_IntituleText
                            FROM Z_RGLT_COMPTEA A
                            INNER JOIN F_COMPTEA B ON A.CA_Num=B.CA_Num) ZCPTEA 
                    ON ZCPTEA.RG_No=C.RG_No
                LEFT JOIN Z_REGLEMENTPIECE RG
                    ON RG.RG_No=C.RG_No
                LEFT JOIN F_COLLABORATEUR CO 
                    ON C.CO_NoCaissier=CO.CO_No
                WHERE RG_Date BETWEEN @DateDeb AND @DateFin 
                AND (C.CA_No IN (SELECT CA_No FROM #TMPCAISSE))
				AND (@BQ_No = 0 OR (@BQ_No =eba.BQ_No))
                AND C.RG_No NOT IN (SELECT RG_NoCache FROM [dbo].[Z_RGLT_VRSTBANCAIRE])
                ORDER BY C.RG_No
END;";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    function typeCaisse($val){
        if($val==5) return "Entrée espèce";
        if($val==4) return "Sortie espèce";
        if($val==2) return "Agio";
        if($val==16) return "Transfert caisse";
        if($val==6) return "Vrst bancaire";
    }

    public function afficheMvtBanque($rows,$flagAffichageValCaisse,$flagCtrlTtCaisse){
        $i=0;
        $classe="";
        $sommeMnt = 0;
        if($rows==null){
            echo "<tr id='reglement_' class='reglement'><td>Aucun élément trouvé !</td></tr>";
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
                                                <td id='RG_Libelle'>".str_replace("*agio ","",$row->RG_Libelle)."</td>
                                                <td id='RG_Montant'>{$this->objetCollection->formatChiffre($montant)}</td>
                                                <td style='display:none' id='RG_MontantHide'>$montant</td>
                                                <td style='display:none' id='BQ_No'>{$row->BQ_No}</td>
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
            echo "<tr class='reglement' style='background-color:grey;color:white'><td id='rgltTotal'><b>Total</b></td><td></td><td></td><td></td><td><b>{$this->objetCollection->formatChiffre($sommeMnt)}</b></td><td></td><td></td><td></td><td></td><td></td></tr>";
        }
    }
/*
    public function all($sommeil=-1,$intitule="",$top=0){
        $valeurSaisie =str_replace(" ","%",$intitule);
        $value = "";
        if($top!=0)
            $value = "TOP $top";
        $query = "DECLARE @arSommeil INT = $sommeil
                  DECLARE @arText NVARCHAR(250) = '$valeurSaisie'
                  
                  SELECT  $value AR_Type
                          ,AR_Sommeil
                          ,AR_Ref
                          ,AR_Design
                          ,AR_Ref as id
                          ,CONCAT(CONCAT(AR_Ref,' - '),AR_Design) as text
                          ,CONCAT(CONCAT(AR_Ref,' - '),AR_Design) as value
                        ,AR_PrixAch
                        ,AR_PrixVen
                  FROM F_ARTICLE
                  WHERE (-1=@arPublie OR AR_Publie=@arPublie)
                  AND (-1=@arSommeil OR AR_Sommeil=@arSommeil)
                  AND CONCAT(CONCAT(AR_Ref,' - '),AR_Design) LIKE CONCAT(CONCAT('%',@arText),'%') 
                  $rechEtat
                  ORDER BY AR_Design";
        $result= $this->db->query($query);
        $this->list = Array();
        $this->list = $result->fetchAll(PDO::FETCH_OBJ);
        return $this->list;
    }
*/
}