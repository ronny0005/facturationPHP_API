<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class ProtectionClass extends Objet
{
    //put your code here
    public $db, $PROT_User, $PROT_Pwd, $ProfilName, $PROT_Administrator, $PROT_Description, $PROT_Right, $Prot_No, $PROT_PwdStatus, $cbMarq, $PROT_UserProfil,
        $PROT_CLIENT, $PROT_FOURNISSEUR, $PROT_COLLABORATEUR, $PROT_FAMILLE, $PROT_ARTICLE, $PROT_DOCUMENT_STOCK, $PROT_CATCOMPTA,
        $PROT_DOCUMENT_ACHAT, $PROT_DOCUMENT_VENTE, $PROT_PX_ACHAT, $PROT_PX_REVIENT, $PROT_DOCUMENT_ACHAT_PREPARATION_COMMANDE,
        $PROT_DATE_VENTE, $PROT_DATE_ACHAT, $PROT_DATE_COMPTOIR, $PROT_DATE_RGLT, $PROT_DOCUMENT_VENTE_DEVIS,
        $PROT_DOCUMENT_VENTE_FACTURE, $PROT_DOCUMENT_VENTE_BLIVRAISON, $PROT_DOCUMENT_VENTE_RETOUR, $PROT_DOCUMENT_VENTE_AVOIR,
        $PROT_DOCUMENT_ENTREE, $PROT_DATE_STOCK, $PROT_DOCUMENT_SORTIE, $PROT_DOCUMENT_REGLEMENT, $PROT_MVT_CAISSE, $PROT_QTE_NEGATIVE,
        $PROT_SAISIE_REGLEMENT_FOURNISSEUR, $PROT_DEPRECIATION_STOCK, $PROT_SAISIE_REGLEMENT, $PROT_DEPOT, $PROT_RISQUE_CLIENT,
        $PROT_SAISIE_INVENTAIRE, $PROT_AFFICHAGE_VAL_CAISSE, $PROT_CTRL_TT_CAISSE, $PROT_INFOLIBRE_ARTICLE, $PROT_DATE_MVT_CAISSE
    , $PROT_Email, $ProtectAdmin
    , $PROT_GENERATION_RGLT_CLIENT, $PROT_DOCUMENT_ACHAT_FACTURE, $PROT_MODIF_SUPPR_COMPTOIR, $PROT_APRES_IMPRESSION
    , $PROT_TICKET_APRES_IMPRESSION, $PROT_AVANT_IMPRESSION, $PROT_DOCUMENT_INTERNE_2, $PROT_MODIFICATION_CLIENT
    , $PROT_ETAT_INVENTAIRE_PREP, $PROT_ETAT_LIVRE_INV, $PROT_ETAT_STAT_ARTICLE_PAR_ART, $PROT_ETAT_STAT_ARTICLE_PAR_FAM
    , $PROT_ETAT_STAT_ARTICLE_PALMARES, $PROT_ETAT_MVT_STOCK, $PROT_ETAT_CLT_PAR_FAM_ART, $PROT_ETAT_CLT_PAR_ARTICLE, $PROT_ETAT_PALMARES_CLT
    , $PROT_ETAT_STAT_FRS_FAM_ART, $PROT_ETAT_STAT_FRS, $PROT_DOCUMENT_ACHAT_RETOUR
    , $PROT_GEN_ECART_REGLEMENT, $PROT_ETAT_STAT_CAISSE_ARTICLE
    , $PROT_ETAT_STAT_CAISSE_FAM_ARTICLE, $PROT_ETAT_CAISSE_MODE_RGLT, $PROT_OUVERTURE_TOUTE_LES_CAISSES
    , $PROT_ETAT_RELEVE_CPTE_CLIENT, $PROT_ETAT_STAT_COLLAB_PAR_TIERS
    , $PROT_ETAT_STAT_COLLAB_PAR_ARTICLE, $PROT_ETAT_STAT_COLLAB_PAR_FAMILLE, $PROT_ETAT_STAT_FRS_PAR_FAMILLE, $PROT_ETAT_STAT_FRS_PAR_ARTICLE
    , $PROT_ETAT_STAT_ACHAT_ANALYTIQUE
    , $PROT_ETAT_RELEVE_ECH_CLIENT, $PROT_ETAT_RELEVE_ECH_FRS, $PROT_VENTE_COMPTOIR, $PROT_CLOTURE_CAISSE
    , $PROT_SAISIE_PX_VENTE_REMISE, $PROT_TARIFICATION_CLIENT, $PROT_CBCREATEUR
    , $PROT_PLAN_COMPTABLE, $PROT_PLAN_ANALYTIQUE, $PROT_TAUX_TAXE, $PROT_DOCUMENT_INTERNE_5
    , $PROT_CODE_JOURNAUX, $PROT_LISTE_BANQUE, $PROT_LISTE_MODELE_REGLEMENT, $PROT_REAPPROVISIONNEMENT
    , $PROT_DOCUMENT_VENTE_BONCOMMANDE, $PROT_VIREMENT_DEPOT;

    public $lien = 'fprotectioncial';
    public $table = 'F_PROTECTIONCIAL';

    function __construct($nom, $mdp)
    {
        $this->db = new DB();
        $objhigher = $this->getApiJson("/user={$this->formatString($nom)}&mdp={$this->formatString($mdp)}");
        if (isset($objhigher))
            $this->initParam($objhigher);
    }

    public function getDepotUser($protNo)
    {
        return $this->getApiJson("/getDepotUser&protNo=$protNo");
    }

    public function initParam($rows)
    {
        $this->PROT_User = "";
        $this->PROT_Pwd = "";
        $this->PROT_PwdStatus = 0;
        $this->PROT_Administrator = 0;
        $this->PROT_Description = "";
        $this->PROT_Right = 2;
        $this->PROT_Email = "";
        $this->PROT_UserProfil = 0;

        $this->cbMarq = $rows ->cbMarq;
        $this->PROT_User = $rows ->PROT_User;
        $this->PROT_Pwd = $rows ->PROT_Pwd;
        $this->ProfilName = $rows ->ProfilName;
        $this->PROT_PwdStatus = $rows ->PROT_PwdStatus;
        $this->PROT_Administrator = $rows ->PROT_Administrator;
        $this->PROT_Description = $rows ->PROT_Description;
        $this->PROT_Right = $rows ->PROT_Right;
        $this->PROT_Email = $rows ->PROT_Email;
        $this->ProtectAdmin = $rows ->ProtectAdmin;
        $this->Prot_No = $rows ->Prot_No;
        $this->PROT_UserProfil = $rows ->PROT_UserProfil;
        $this->PROT_CLIENT = $rows ->PROT_CLIENT;
        $this->PROT_FOURNISSEUR = $rows ->PROT_FOURNISSEUR;
        $this->PROT_COLLABORATEUR = $rows ->PROT_COLLABORATEUR;
        $this->PROT_FAMILLE = $rows ->PROT_FAMILLE;
        $this->PROT_ARTICLE = $rows ->PROT_ARTICLE;
        $this->PROT_CATCOMPTA = $rows ->PROT_CATCOMPTA;
        $this->PROT_MODIFICATION_CLIENT = $rows->PROT_MODIFICATION_CLIENT;
        $this->PROT_APRES_IMPRESSION = $rows ->PROT_APRES_IMPRESSION;
        $this->PROT_AVANT_IMPRESSION = $rows ->PROT_AVANT_IMPRESSION;
        $this->PROT_TICKET_APRES_IMPRESSION = $rows ->PROT_TICKET_APRES_IMPRESSION;
        $this->PROT_GENERATION_RGLT_CLIENT = $rows ->PROT_GENERATION_RGLT_CLIENT;
        $this->PROT_DOCUMENT_STOCK = $rows ->PROT_DOCUMENT_STOCK;
        $this->PROT_DOCUMENT_ACHAT = $rows ->PROT_DOCUMENT_ACHAT;
        $this->PROT_TARIFICATION_CLIENT = $rows ->PROT_TARIFICATION_CLIENT;
        $this->PROT_MODIF_SUPPR_COMPTOIR = $rows ->PROT_MODIF_SUPPR_COMPTOIR;
        $this->PROT_DOCUMENT_ACHAT_FACTURE = $rows ->PROT_DOCUMENT_ACHAT_FACTURE;
        $this->PROT_DOCUMENT_ACHAT_PREPARATION_COMMANDE = $rows ->PROT_DOCUMENT_ACHAT_PREPARATION_COMMANDE;
        $this->PROT_DOCUMENT_INTERNE_2 = $rows ->PROT_DOCUMENT_INTERNE_2;
        $this->PROT_DOCUMENT_VENTE = $rows ->PROT_DOCUMENT_VENTE;
        $this->PROT_PX_ACHAT = $rows ->PROT_PX_ACHAT;
        $this->PROT_DEPRECIATION_STOCK = $rows ->PROT_DEPRECIATION_STOCK;
        $this->PROT_PX_REVIENT = $rows ->PROT_PX_REVIENT;
        $this->PROT_DATE_STOCK = $rows ->PROT_DATE_STOCK;
        $this->PROT_DATE_VENTE = $rows ->PROT_DATE_VENTE;
        $this->PROT_DATE_ACHAT = $rows ->PROT_DATE_ACHAT;
        $this->PROT_DATE_COMPTOIR = $rows ->PROT_DATE_COMPTOIR;
        $this->PROT_VENTE_COMPTOIR = $rows ->PROT_VENTE_COMPTOIR;
        $this->PROT_DATE_RGLT = $rows ->PROT_DATE_RGLT;
        $this->PROT_GEN_ECART_REGLEMENT = $rows ->PROT_GEN_ECART_REGLEMENT;
        $this->PROT_ETAT_STAT_CAISSE_ARTICLE = $rows ->PROT_ETAT_STAT_CAISSE_ARTICLE;
        $this->PROT_ETAT_STAT_CAISSE_FAM_ARTICLE = $rows ->PROT_ETAT_STAT_CAISSE_FAM_ARTICLE;
        $this->PROT_ETAT_CAISSE_MODE_RGLT = $rows ->PROT_ETAT_CAISSE_MODE_RGLT;
        $this->PROT_DOCUMENT_VENTE_DEVIS = $rows ->PROT_DOCUMENT_VENTE_DEVIS;
        $this->PROT_DOCUMENT_VENTE_FACTURE = $rows ->PROT_DOCUMENT_VENTE_FACTURE;
        $this->PROT_DOCUMENT_VENTE_BLIVRAISON = $rows ->PROT_DOCUMENT_VENTE_BLIVRAISON;
        $this->PROT_DOCUMENT_VENTE_RETOUR = $rows ->PROT_DOCUMENT_VENTE_RETOUR;
        $this->PROT_DOCUMENT_VENTE_AVOIR = $rows ->PROT_DOCUMENT_VENTE_AVOIR;
        $this->PROT_DOCUMENT_ACHAT_RETOUR = $rows ->PROT_DOCUMENT_ACHAT_RETOUR;
        $this->PROT_DOCUMENT_ENTREE = $rows ->PROT_DOCUMENT_ENTREE;
        $this->PROT_DOCUMENT_SORTIE = $rows ->PROT_DOCUMENT_SORTIE;
        $this->PROT_DOCUMENT_REGLEMENT = $rows ->PROT_DOCUMENT_REGLEMENT;
        $this->PROT_MVT_CAISSE = $rows ->PROT_MVT_CAISSE;
        $this->PROT_QTE_NEGATIVE = $rows ->PROT_QTE_NEGATIVE;
        $this->PROT_SAISIE_INVENTAIRE = $rows->PROT_SAISIE_INVENTAIRE;
        $this->PROT_SAISIE_REGLEMENT = $rows->PROT_SAISIE_REGLEMENT;
        $this->PROT_SAISIE_REGLEMENT_FOURNISSEUR = $rows ->PROT_SAISIE_REGLEMENT_FOURNISSEUR;
        $this->PROT_DEPOT = $rows ->PROT_DEPOT;
        $this->PROT_RISQUE_CLIENT = $rows ->PROT_RISQUE_CLIENT;
        $this->PROT_AFFICHAGE_VAL_CAISSE = $rows ->PROT_AFFICHAGE_VAL_CAISSE;
        $this->PROT_CTRL_TT_CAISSE = $rows ->PROT_CTRL_TT_CAISSE;
        $this->PROT_INFOLIBRE_ARTICLE = $rows ->PROT_INFOLIBRE_ARTICLE;
        $this->PROT_DATE_MVT_CAISSE = $rows ->PROT_DATE_MVT_CAISSE;
        $this->PROT_ETAT_INVENTAIRE_PREP = $rows ->PROT_ETAT_INVENTAIRE_PREP;
        $this->PROT_ETAT_LIVRE_INV = $rows ->PROT_ETAT_LIVRE_INV;
        $this->PROT_ETAT_STAT_ARTICLE_PAR_ART = $rows ->PROT_ETAT_STAT_ARTICLE_PAR_ART;
        $this->PROT_ETAT_STAT_ARTICLE_PAR_FAM = $rows ->PROT_ETAT_STAT_ARTICLE_PAR_FAM;
        $this->PROT_ETAT_STAT_ARTICLE_PALMARES = $rows ->PROT_ETAT_STAT_ARTICLE_PALMARES;
        $this->PROT_ETAT_MVT_STOCK = $rows ->PROT_ETAT_MVT_STOCK;
        $this->PROT_ETAT_CLT_PAR_FAM_ART = $rows ->PROT_ETAT_CLT_PAR_FAM_ART;
        $this->PROT_ETAT_CLT_PAR_ARTICLE = $rows ->PROT_ETAT_CLT_PAR_ARTICLE;
        $this->PROT_ETAT_PALMARES_CLT = $rows ->PROT_ETAT_PALMARES_CLT;
        $this->PROT_ETAT_STAT_FRS_FAM_ART = $rows ->PROT_ETAT_STAT_FRS_FAM_ART;
        $this->PROT_ETAT_STAT_FRS = $rows ->PROT_ETAT_STAT_FRS;
        $this->PROT_ETAT_RELEVE_CPTE_CLIENT = $rows ->PROT_ETAT_RELEVE_CPTE_CLIENT;
        $this->PROT_ETAT_STAT_COLLAB_PAR_TIERS = $rows ->PROT_ETAT_STAT_COLLAB_PAR_TIERS;
        $this->PROT_ETAT_STAT_COLLAB_PAR_ARTICLE = $rows ->PROT_ETAT_STAT_COLLAB_PAR_ARTICLE;

        $this->PROT_ETAT_STAT_COLLAB_PAR_FAMILLE = $rows ->PROT_ETAT_STAT_COLLAB_PAR_FAMILLE;
        $this->PROT_ETAT_RELEVE_ECH_CLIENT = $rows ->PROT_ETAT_RELEVE_ECH_CLIENT;
        $this->PROT_ETAT_RELEVE_ECH_FRS = $rows ->PROT_ETAT_RELEVE_ECH_FRS;
        $this->PROT_SAISIE_PX_VENTE_REMISE = $rows ->PROT_SAISIE_PX_VENTE_REMISE;
        $this->PROT_CBCREATEUR = $rows ->PROT_CBCREATEUR;
        $this->PROT_CLOTURE_CAISSE = $rows ->PROT_CLOTURE_CAISSE;
        $this->PROT_OUVERTURE_TOUTE_LES_CAISSES = $rows ->PROT_OUVERTURE_TOUTE_LES_CAISSES;
        $this->PROT_PLAN_COMPTABLE = $rows ->PROT_PLAN_COMPTABLE;
        $this->PROT_PLAN_ANALYTIQUE = $rows ->PROT_PLAN_ANALYTIQUE;
        $this->PROT_TAUX_TAXE = $rows ->PROT_TAUX_TAXE;
        $this->PROT_CODE_JOURNAUX = $rows ->PROT_CODE_JOURNAUX;
        $this->PROT_LISTE_BANQUE = $rows ->PROT_LISTE_BANQUE;
        $this->PROT_LISTE_MODELE_REGLEMENT = $rows ->PROT_LISTE_MODELE_REGLEMENT;
        $this->PROT_REAPPROVISIONNEMENT = $rows->PROT_REAPPROVISIONNEMENT;
        $this->PROT_DOCUMENT_INTERNE_5 = $rows->PROT_DOCUMENT_INTERNE_5;
        $this->PROT_DOCUMENT_VENTE_BONCOMMANDE = $rows->PROT_DOCUMENT_VENTE_BONCOMMANDE;
        $this->PROT_VIREMENT_DEPOT = $rows->PROT_VIREMENT_DEPOT;
    }

    public function setSecuriteAdmin($value)
    {
        $query = "BEGIN 
                      SET NOCOUNT ON;
                      IF EXISTS (SELECT 1 FROM Z_ProtUser WHERE PROT_No = {$this->Prot_No})
                        BEGIN 
                            IF $value = 0  
                                DELETE FROM Z_ProtUser WHERE PROT_No = {$this->Prot_No}
                        END
                      ELSE 
                        IF $value = 1 
                            INSERT INTO Z_ProtUser VALUES ({$this->Prot_No},$value)
                    END;";
        $this->db->query($query);
    }

    public function update()
    {
        $query = "UPDATE F_PROTECTIONCIAL SET PROT_User = '{$this->PROT_User}' WHERE PROT_No = {$this->Prot_No}";
        $this->db->query($query);
    }

    public function createUser()
    {
        $sql = "
        BEGIN 
        DECLARE @ProtUser AS NVARCHAR(50) = '{$this->PROT_User}'
        DECLARE @ProtPwd AS NVARCHAR(50) = '{$this->PROT_Pwd}'
        DECLARE @ProtDescription AS NVARCHAR(50) = '{$this->PROT_Description}'
        DECLARE @ProtRight AS INT = {$this->PROT_Right}
        DECLARE @ProtEmail AS NVARCHAR(50) = '{$this->PROT_Email}'
        DECLARE @ProtUserProfil AS NVARCHAR(50) = '{$this->PROT_UserProfil}'
        DECLARE @ProtPwdStatus AS INT = {$this->PROT_PwdStatus};
        
        SET NOCOUNT ON;
        IF NOT EXISTS (SELECT 1 FROM F_PROTECTIONCIAL WHERE PROT_User = '{$this->PROT_User}')
        BEGIN 
            INSERT INTO F_PROTECTIONCPTA
           ([PROT_User]           ,[PROT_Pwd]
           ,[PROT_Description]           ,[PROT_Right]
           ,[PROT_No]           ,[PROT_EMail]
           ,[PROT_UserProfil]           ,[PROT_Administrator]
           ,[PROT_DatePwd]           ,[PROT_DateCreate]
           ,[PROT_LastLoginDate]           ,[PROT_LastLoginTime]
           ,[PROT_PwdStatus]           ,[cbProt]
           ,[cbCreateur]           ,[cbModification]
           ,[cbReplication]           ,[cbFlag])
     VALUES
           (@ProtUser,@ProtPwd
           , @ProtDescription,@ProtRight,(SELECT ISNULL((SELECT MAX(PROT_No) FROM F_PROTECTIONCIAL),0)+1)
           ,@ProtEmail,@ProtUserProfil,0,GETDATE(),GETDATE()
           ,'1900-01-01',000000000,@ProtPwdStatus,0
           ,'COLU',GETDATE(),0,0);
        INSERT INTO [F_PROTECTIONCIAL]
           ([PROT_User],[PROT_Pwd]
           ,[PROT_Description]           ,[PROT_Right]
           ,[PROT_No]           ,[PROT_EMail]
           ,[PROT_UserProfil]           ,[PROT_Administrator]
           ,[PROT_DatePwd]           ,[PROT_DateCreate]
           ,[PROT_LastLoginDate]           ,[PROT_LastLoginTime]
           ,[PROT_PwdStatus]           ,[cbProt]
           ,[cbCreateur]           ,[cbModification]
           ,[cbReplication]           ,[cbFlag])
     VALUES
           (@ProtUser,@ProtPwd
           , @ProtDescription,@ProtRight,(SELECT ISNULL((SELECT MAX(PROT_No) FROM F_PROTECTIONCIAL),0)+1)
           ,@ProtEmail,@ProtUserProfil,0,GETDATE(),GETDATE()
           ,'1900-01-01',000000000,@ProtPwdStatus,0
           ,'COLU',GETDATE(),0,0)  
           SELECT @@IDENTITY cbMarq
           END
           ELSE SELECT -1 cbMarq
       END
           ";
        $result = $this->db->query($sql);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        return $rows[0]->cbMarq;
    }

    public function connexionProctectionByProtNo($prot_no)
    {
        $this->initParam($this->getApiJson("/connexionProctectionByProtNo&protNo=$prot_no"));
    }


    public function jour($value)
    {
        switch ($value) {
            case 1:
                return "Lundi";
                break;
            case 2:
                return "Mardi";
                break;
            case 3:
                return "Mercredi";
                break;
            case 4:
                return "Jeudi";
                break;
            case 5:
                return "Vendredi";
                break;
            case 6:
                return "Samedi";
                break;
            case 7:
                return "Dimanche";
                break;
        }
    }

    public function setCalendarUser($protNo)
    {
        $this->deleteZ_Calendar_user($protNo);
        for ($i = 1; $i < 8; $i++) {
            $jour = $this->jour($i);
            if (isset($_POST["check$jour"])) {
                $heureDebut = mb_split(":", $_POST["heureDebut$jour"])[0];
                $minDebut = mb_split(":", $_POST["heureDebut$jour"])[1];
                $heureFin = mb_split(":", $_POST["heureFin$jour"])[0];
                $minFin = mb_split(":", $_POST["heureFin$jour"])[1];
                $row = $this->getZ_Calendar_user($protNo, $i);
                if (sizeof($row) == 0)
                    $this->insertIntoZ_Calendar_user($protNo, $i, $i, $heureDebut, $minDebut, $heureFin, $minFin);
                else
                    $this->majZ_Calendar_user($protNo, $i, $i, $heureDebut, $minDebut, $heureFin, $minFin);
                $action = 1;
            }
        }
    }

    public function IssecuriteAdmin($deNo)
    {
        return $this->getApiString("/IssecuriteAdmin&protNo={$_SESSION["id"]}&deNo=$deNo");
    }

    public function IssecuriteAdminCaisse($caNo)
    {
        $isSecurite = 0;
        if ($this->ProtectAdmin == 1) {
            $caisseDepot = new CaisseClass(0);
            $rows = $caisseDepot->getCaisseProtNo($_SESSION["id"]);
            foreach ($rows as $row) {
                if ($row->CA_No == $caNo)
                    $isSecurite = 1;
            }
        } else $isSecurite = 1;
        return $isSecurite;
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

    public function getDelai()
    {
        $lien = $this->lien;
        $this->lien="ppreference";
        $var = $this->getApiJson("/info")->pr_DelaiPreAlert;
        $this->lien = $lien ;
        return $var;
    }

    public function getCoNo()
    {
        $query = "SELECT CO_No
                FROM F_PROTECTIONCIAL P 
                INNER JOIN F_COLLABORATEUR C ON P.PROT_User = C.CO_Nom
                WHERE CO_Nom = '{$this->PROT_User}'";
        $result = $this->db->query($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if (sizeof($rows) == 0)
            return null;
        else
            return $rows[0]->CO_No;
    }

    public function getListProfil()
    {
        $query = "SELECT	pro.PROT_No
                            ,pro.PROT_User
                            ,pro.PROT_Description
                            ,pro.PROT_EMail
                            ,pro.PROT_DateCreate
                            ,pro.cbModification
                            ,PROT_LastLoginDate = CASE WHEN YEAR(pro.PROT_LastLoginDate) = 1900 THEN 'Pas encore connecté' ELSE FORMAT(pro.PROT_LastLoginDate,'dd-mm-yyyy') END 
                            ,Intituleprofil = CASE WHEN pro.PROT_UserProfil = 0 THEN 'Pas de profil associé' ELSE usr.PROT_User END
                            ,Intitulegroupe = CASE WHEN pro.PROT_Right = 1 THEN 'Administrateur'
                                WHEN pro.PROT_Right = 2 THEN 'Utilisateur'
                                ELSE 'Pas de groupe associé' END
                    FROM F_PROTECTIONCIAL pro
                    LEFT JOIN F_PROTECTIONCIAL usr
                        ON pro.cbPROT_UserProfil = usr.PROT_No";
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);

    }

    public function annee_exercice()
    {
        $query = "SELECT YEAR(D_DebutExo01) AS ANNEE_EXERCICE
                FROM(
                SELECT D_DebutExo01
                FROM P_DOSSIER
                UNION
                SELECT D_DebutExo02
                FROM P_DOSSIER
                UNION
                SELECT D_DebutExo03
                FROM P_DOSSIER
                UNION
                SELECT D_DebutExo04
                FROM P_DOSSIER
                UNION
                SELECT D_DebutExo05
                FROM P_DOSSIER) A
                WHERE YEAR(D_DebutExo01)<>1900
                ORDER BY 1 DESC";
        $result = $this->db->query($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        return $rows;
    }

    public function deconnexionTotale()
    {
        $query = "dbcc cbsqlxp(free);
                delete from cbnotification;
                delete from cbregmessage;
                delete from cbusersession;";
        $this->db->query($query);
    }

    public function setvalue($type)
    {
        $val = 0;
        if ($type == "famille")
            $val = $this->PROT_FAMILLE;
        if ($type == "client")
            $val = $this->PROT_CLIENT;
        if ($type == "fournisseur")
            $val = $this->PROT_FOURNISSEUR;
        if ($type == "collaborateur")
            $val = $this->PROT_COLLABORATEUR;
        if ($type == "depot")
            $val = $this->PROT_DEPOT;
        if ($type == "article")
            $val = $this->PROT_ARTICLE;
        if ($type == "Vente" || $type == "VenteC" || $type == "VenteT")
            $val = $this->PROT_DOCUMENT_VENTE_FACTURE;
        if ($type == "Achat" || $type == "AchatC" || $type == "AchatT")
            $val = $this->PROT_DOCUMENT_ACHAT_FACTURE;
        if ($type == "AchatRetour")
            $val = $this->PROT_DOCUMENT_ACHAT_RETOUR;
        if ($type == "AchatPreparationCommande" || $type == "PreparationCommande")
            $val = $this->PROT_DOCUMENT_ACHAT_PREPARATION_COMMANDE;
        if ($type == "Devis")
            $val = $this->PROT_DOCUMENT_VENTE_DEVIS;
        if ($type == "VenteRetour")
            $val = $this->PROT_DOCUMENT_VENTE_RETOUR;
        if ($type == "Avoir")
            $val = $this->PROT_DOCUMENT_VENTE_AVOIR;
        if ($type == "BonLivraison")
            $val = $this->PROT_DOCUMENT_VENTE_BLIVRAISON;
        if ($type == "Entree")
            $val = $this->PROT_DOCUMENT_ENTREE;
        if ($type == "Sortie")
            $val = $this->PROT_DOCUMENT_SORTIE;
        if ($type == "Transfert")
            $val = $this->PROT_VIREMENT_DEPOT;

        if ($type == "Transfert_detail")
            $val = $this->PROT_DOCUMENT_INTERNE_2;
        if ($type == "Transfert_confirmation")
            $val = $this->PROT_DOCUMENT_INTERNE_5;
        if ($type == "ReglementClient")
            $val = $this->PROT_SAISIE_REGLEMENT;
        if ($type == "ReglementFournisseur")
            $val = $this->PROT_SAISIE_REGLEMENT_FOURNISSEUR;
        if ($type == "MvtCaisse")
            $val = $this->PROT_MVT_CAISSE;
        if ($type == "documentVente")
            $val = $this->PROT_DOCUMENT_VENTE;
        if ($type == "documentAchat")
            $val = $this->PROT_DOCUMENT_ACHAT;
        if ($type == "documentStock")
            $val = $this->PROT_DOCUMENT_STOCK;
        if ($type == "infoLibreArticle")
            $val = $this->PROT_INFOLIBRE_ARTICLE;
        return $val;
    }

    public function protectedType($type)
    {
        // if($this->PROT_Administrator==0 || $this->PROT_Right==0) {
        $val = $this->setvalue($type);
        if ($val != 0 && $val != 3)
            return 0;
        // }else return 0;
        return 1;
    }


    public function supprType($type)
    {
        //    if($this->PROT_Administrator==0 && $this->PROT_Right==0) {
        $val = $this->setvalue($type);
        if ($val != 0)
            return 0;
        //    }else return 0;
        return 1;

    }

    public function nouveauType($type)
    {
        $val = $this->setvalue($type);

        if ($val == 2 || $val == 1)
            return 0;
        return 1;
    }

    public function majGescom()
    {
        if ($this->PROT_UserProfil == 0) {
            $cbprofiluser = 'NULL';
        } else $cbprofiluser = $profiluser;
        $sql = "UPDATE " . $this->db->baseCompta . ".[dbo].[F_PROTECTIONCPTA]
                SET [PROT_User] ='" . $this->PROT_User . "',cbModification=GETDATE()
                   ,[PROT_Pwd] ='" . $this->crypteMdp($this->PROT_Pwd) . "'
                   ,[PROT_Description] ='" . $this->PROT_Description . "'
                   ,[PROT_Right] =" . $this->PROT_Right . "
                   ,[PROT_EMail] ='" . $this->PROT_EMail . "'
                   ,PROT_PwdStatus =" . $this->PROT_PwdSatus . "
                   ,[PROT_DatePwd] =GETDATE()
                 WHERE PROT_User='" . $username . "'";

        $sql2 = "UPDATE F_PROTECTIONCIAL
                SET [PROT_User] ='$username',cbModification=GETDATE()
                   ,[PROT_Pwd] ='{$this->crypteMdp($password)}'
                   ,[PROT_Description] ='$description'
                   ,[PROT_Right] =$groupeid
                   ,[PROT_EMail] ='$email'
                   ,[PROT_UserProfil] =$profiluser
                   ,[cbPROT_UserProfil] = $cbprofiluser
                   ,PROT_PwdStatus = $changepass
                   ,[PROT_DatePwd] =GETDATE()
                 WHERE PROT_No=$id";
        return $sql . ";" . $sql2 . ";";
    }

    public function getUser()
    {
        $query = "SELECT PROT_No,Prot_User 
                FROM F_Protectioncial";
        $result = $this->db->requete($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getProtectionListTitre()
    {
        $query = "SELECT PROT_Cmd TE_No,Libelle_Cmd TE_Intitule 
                FROM LIB_CMD
                WHERE Parent=-1";
        $result = $this->db->requete($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getProtectionListElement($idParent)
    {
        $query = "SELECT PROT_Cmd TE_No,Libelle_Cmd TE_Intitule 
                FROM LIB_CMD
                WHERE Parent=$idParent AND Actif=1
                ORDER BY PROT_Cmd";
        $result = $this->db->requete($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getUserAdminMain()
    {
        $query = "select *,CASE WHEN userName='' THEN ProfilName ELSE userName END Prot_User
                from (
                SELECT 0 as position,PROT_No,0 PROT_No_User,PROT_User as ProfilName,'' as userName
                FROM F_Protectioncial
                WHERE PROT_UserProfil=0
                union
                SELECT ROW_NUMBER() OVER (ORDER BY A.Prot_No,A.PROT_User),A.Prot_No,B.Prot_No Prot_No_User,A.PROT_User,B.Prot_User--PROT_No,Prot_User 
                FROM F_Protectioncial A
                LEFT JOIN F_PROTECTIONCIAL B ON A.PROT_No=B.PROT_UserProfil
                WHERE A.PROT_UserProfil=0
                AND B.Prot_User is not null
                ) A
                order by 2,1";
        $result = $this->db->requete($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getProfilAdminMain()
    {
        $query = "select *,CASE WHEN userName='' THEN ProfilName ELSE userName END Prot_User
                from (
                SELECT 0 as position,PROT_No,0 PROT_No_User,PROT_User as ProfilName,'' as userName
                FROM F_Protectioncial
                WHERE PROT_UserProfil=0
                ) A
                order by 2,1";
        $result = $this->db->requete($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getUtilisateurAdminMain()
    {
        $query = "select *,CASE WHEN userName='' THEN ProfilName ELSE userName END Prot_User
                from (
                SELECT ROW_NUMBER() OVER (ORDER BY A.PROT_No,A.PROT_User)position,A.PROT_No,B.PROT_No PROT_No_User,A.PROT_User ProfilName,B.Prot_User as userName --PROT_No,Prot_User 
                FROM F_Protectioncial A
                LEFT JOIN F_PROTECTIONCIAL B ON A.PROT_No=B.PROT_UserProfil
                WHERE A.PROT_UserProfil=0
                AND B.Prot_User is not null
                ) A
                order by 2,1";
        $result = $this->db->requete($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getUtilisateurAdminMainConnexion()
    {
        $query = "SELECT	PROT_No_User = PROT_No
						,PROT_User
				FROM	F_PROTECTIONCIAL
				WHERE	PROT_UserProfil=0
				UNION
				SELECT	PROT_No_User = PROT_No
						,PROT_User
				FROM	F_PROTECTIONCIAL
				WHERE	PROT_UserProfil<>0";
        $result = $this->db->requete($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }


    public function getDataUser($prot_no)
    {
        $query = "  SELECT A.PROT_Cmd TE_No,Libelle_Cmd TE_Intitule,CASE WHEN ISNULL(B.Prot_No,0)=0 THEN 0 ELSE 1 END Prot_No,EPROT_Right
                    FROM LIB_CMD A
                    LEFT JOIN (SELECT * FROM F_EPROTECTIONCIAL WHERE Prot_No=$prot_no) B on A.PROT_Cmd=B.EPROT_Cmd
                    WHERE Actif=1 
                    ORDER BY A.PROT_Cmd";
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getDataUserNo($te_no, $prot_no)
    {
        $query = "  SELECT A.PROT_Cmd TE_No,TypeFlag,Libelle_Cmd TE_Intitule,CASE WHEN ISNULL(B.Prot_No,0)=0 THEN 0 ELSE 1 END Prot_No,EPROT_Right
                    FROM LIB_CMD A
                    LEFT JOIN (SELECT * FROM F_EPROTECTIONCIAL WHERE Prot_No=$prot_no) B on A.PROT_Cmd=B.EPROT_Cmd
                    WHERE Actif=1 AND $te_no = A.PROT_Cmd
                    ORDER BY A.PROT_Cmd";
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getPrixParCatCompta()
    {
        $query = "  SELECT P_ReportPrixRev
                    FROM P_PARAMETRECIAL";
        $result = $this->db->query($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        return $rows[0]->P_ReportPrixRev;
    }

    public function getFormatReferenceEcriture()
    {
        $query = "  SELECT P_Piece02
                    FROM P_PARAMETRECIAL";
        $result = $this->db->query($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        return $rows[0]->P_Piece02;
    }

    public function getFormatPieceFacturation()
    {
        $query = "  SELECT P_Piece01
                    FROM P_PARAMETRECIAL";
        $result = $this->db->query($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        return $rows[0]->P_Piece01;
    }

    public function getDataUserProfil($prot_no)
    {
        $query = "  SELECT  [TE_No] = A.PROT_No 
                            ,[TE_Intitule] = A.PROT_User 
                            ,[Prot_No] = CASE WHEN ISNULL(B.Prot_No,0)=0 THEN 0 ELSE 1 END 
                    FROM    F_PROTECTIONCIAL A
                    LEFT JOIN ( SELECT  Prot_No,PROT_UserProfil  
                                FROM    F_PROTECTIONCIAL 
                                WHERE   PROT_No=$prot_no) B 
                        ON A.PROT_No=B.PROT_UserProfil
                    WHERE   A.PROT_UserProfil=0
                    ORDER BY A.PROT_No";
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function updateEProtection($prot_no, $eprot_cmd, $prot_right)
    {
        $query = "IF $prot_right=-1 
              DELETE FROM F_EPROTECTIONCIAL
                    WHERE PROT_No = $prot_no 
                    AND  EPROT_Cmd = $eprot_cmd;
              ELSE IF EXISTS(SELECT 1 FROM F_EPROTECTIONCIAL WHERE PROT_No = $prot_no AND EPROT_Cmd = $eprot_cmd)
                    UPDATE F_EPROTECTIONCIAL SET EPROT_Right = $prot_right, cbModification = GETDATE()
                        WHERE PROT_No = $prot_no AND EPROT_Cmd = $eprot_cmd;
                    ELSE
                        INSERT INTO F_EPROTECTIONCIAL(PROT_No,EPROT_Cmd,EPROT_Right,cbCreateur,cbModification)
                            VALUES($prot_no,$eprot_cmd,$prot_right,'COLU',GETDATE())";
        $this->db->query($query);
    }

    public function updateProfil($prot_no, $prot_no_profil)
    {
        $query = "UPDATE F_PROTECTIONCIAL SET PROT_UserProfil= $prot_no_profil, cbModification = GETDATE()
                        WHERE PROT_No = $prot_no;";
        $this->db->query($query);
    }

    public function majCompta()
    {

    }

    public function insertIntoZ_Calendar_user($PROT_No, $ID_JourDebut, $ID_JourFin, $ID_HeureDebut, $ID_MinDebut, $ID_HeureFin, $ID_MinFin)
    {
        $query = "INSERT INTO [dbo].[Z_CALENDAR_USER]
                               ([PROT_No]
                               ,[ID_JourDebut]
                               ,[ID_JourFin]
                               ,[ID_HeureDebut]
                               ,[ID_MinDebut]
                               ,[ID_HeureFin]
                               ,[ID_MinFin])
                 VALUES
                       (/*PROT_No*/$PROT_No
                       ,/*ID_JourDebut*/$ID_JourDebut
                       ,/*ID_JourFin*/$ID_JourFin
                       ,/*ID_HeureDebut*/$ID_HeureDebut
                       ,/*ID_MinDebut*/$ID_MinDebut
                       ,/*ID_HeureFin*/$ID_HeureFin
                       ,/*ID_MinFin*/$ID_MinFin)";
        $this->db->query($query);
    }


    public function deleteZ_Calendar_user($PROT_No)
    {
        $query = "DELETE FROM  [dbo].[Z_CALENDAR_USER] WHERE PROT_No = $PROT_No";
        $this->db->query($query);
    }

    public function getZ_Calendar_user($PROT_No, $i)
    {
        $query = "SELECT *
                 FROM Z_CALENDAR_USER
                 WHERE PROT_No=$PROT_No AND ($i=0 OR ($i<>0 AND ID_JourDebut=$i))";
        $result = $this->db->query($query);
        $row = $result->fetchAll(PDO::FETCH_OBJ);
        return $row;
    }

    public function listUserProfil()
    {
        $query = "SELECT PROT_No
                 FROM F_PROTECTIONCIAL
                 WHERE PROT_UserProfil={$this->Prot_No}";
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function majZ_Calendar_user($PROT_No, $ID_JourDebut, $ID_JourFin, $ID_HeureDebut, $ID_MinDebut, $ID_HeureFin, $ID_MinFin)
    {
        $query = "UPDATE [dbo].[Z_CALENDAR_USER] SET ID_JourDebut = $ID_JourDebut
                               ,ID_JourFin = $ID_JourFin
                               ,ID_HeureDebut = $ID_HeureDebut
                               ,ID_MinDebut = $ID_MinDebut
                               ,ID_HeureFin = $ID_HeureFin
                               ,ID_MinFin = $ID_MinFin
                 WHERE PROT_No = $PROT_No";
        $this->db->query($query);
    }

    public function isCalendarUser($PROT_No)
    {
        $this->lien = "zCalendarUser";
        return $this->getApiString("/isCalendarUser/$PROT_No");
    }

    public function canConnect($PROT_No, $jour, $heure)
    {
        $this->lien = "zCalendarUser";
        return $this->getApiString("/canConnect/$PROT_No/$jour/$heure");
    }

    public function listAlertTransfert()
    {
        $query = "  SELECT *
                    FROM(   SELECT  A.DO_PIECE
                                    ,A.do_date
                                    ,A.AR_REF
                                    ,nb = count(*)
                                    ,E.cbMarq
                            FROM F_DOCLIGNE A 
                            INNER JOIN F_DOCENTETE E 
                                ON  A.DO_Domaine = E.DO_Domaine 
                                AND A.DO_Type = E.DO_Type 
                                AND A.DO_Piece=E.DO_Piece
                            WHERE   A.do_piece LIKE 'MT%'
                            GROUP BY A.DO_PIECE
                                    ,A.do_date
                                    ,A.AR_REF
                                    ,E.cbMarq) A
                    WHERE   nb%2=1 
                    AND     cbMarq NOT IN (SELECT cbMarqEntete FROM Z_LIGNE_CONFIRMATION GROUP BY cbMarqEntete)";
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function alerteTransfert()
    {
        $rows = $this->listAlertTransfert();
        $html = "";
        if ($rows != null) {
            $html = "<h1>Liste des transferts à une ligne {$this->db->db}</h1><br/><br/>";
            $html = $html . "<tr><th>N° Document</th><th>Date</th><th>Référence</th><th>Nombre de ligne</th>";
            foreach ($rows as $row) {
                $html = $html . "<tr><td>{$row->DO_PIECE}</td><td>{$row->do_date}</td><td>{$row->AR_REF}</td><td>{$row->nb}</td>";
            }
        }
        return $html;
    }

    public function listAlerteDocumentCatComptaTaxe()
    {
        $query = "  DECLARE @isHT AS INT = 0
                    DECLARE @catCompta AS NVARCHAR(50);
                    
                    SELECT  @isHT = CASE WHEN CA_ComptaVen01 LIKE '%HT%' THEN 1 
                                    WHEN CA_ComptaVen02 LIKE '%HT%' THEN 2 
                                    WHEN CA_ComptaVen03 LIKE '%HT%' THEN 3 
                                    WHEN CA_ComptaVen04 LIKE '%HT%' THEN 4 ELSE 0 END
                            ,@catCompta = CASE WHEN CA_ComptaVen01 LIKE '%HT%' THEN CA_ComptaVen01
                                    WHEN CA_ComptaVen02 LIKE '%HT%' THEN CA_ComptaVen02
                                    WHEN CA_ComptaVen03 LIKE '%HT%' THEN CA_ComptaVen03
                                    WHEN CA_ComptaVen04 LIKE '%HT%' THEN CA_ComptaVen04 ELSE '' END
                    FROM    P_CATCOMPTA
                    
                    SELECT	fde.DO_Domaine,fde.DO_Type,fde.DO_Piece,fde.cbMarq,catCompta = @catCompta
                    FROM	F_DOCENTETE fde
                    INNER JOIN F_DOCLIGNE fdl 
                        ON	fde.DO_Type = fdl.DO_Type 
                        AND fde.DO_Domaine = fdl.DO_Domaine 
                        AND fde.cbDO_Piece = fdl.cbDO_Piece
                    WHERE	N_CatCompta=@isHT 
                    AND		DL_Taxe1<>0
";

        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function alerteDocumentCatComptaTaxe()
    {

        $rows = $this->listAlerteDocumentCatComptaTaxe();
        $html = "";
        if ($rows != null) {
            $html = "<h1>Liste des documents Cat Compta HT avec taxe {$this->db->db}</h1><br/><br/>";
            $html = $html . "<tr><th>Do Domaine</th><th>Do Type</th><th>DO Piece</th><th>cbMarq</th>";
            foreach ($rows as $row) {
                $html = $html . "<tr><td>{$row->DO_Domaine}</td><td>{$row->DO_Type}</td><td>{$row->DO_Piece}</td><td>{$row->cbMarq}</td>";
            }
        }
        return $html;
    }

    public function fixCatCompta()
    {
        $query = "DECLARE @isHT AS INT = 0
					SELECT  @isHT = CASE WHEN CA_ComptaVen01 LIKE '%HT%' THEN 1 
                                    WHEN CA_ComptaVen02 LIKE '%HT%' THEN 2 
                                    WHEN CA_ComptaVen03 LIKE '%HT%' THEN 3 
                                    WHEN CA_ComptaVen04 LIKE '%HT%' THEN 4 ELSE 0 END
					FROM    P_CATCOMPTA
                    
					SELECT	A.DO_Piece 
							INTO #tmpTable
					FROM	F_DOCENTETE A
					LEFT JOIN F_DOCLIGNE B
						ON	A.DO_Domaine = B.DO_Domaine
						AND A.DO_Type = B.DO_Type
						AND A.DO_Piece = B.DO_Piece
					WHERE	N_CatCompta = @isHT 
					AND		DL_Taxe1<>0
					GROUP BY A.DO_Piece

					UPDATE	F_DOCENTETE
						SET N_CatCompta = 1
					WHERE	DO_Piece IN (
						SELECT	DO_Piece 
						FROM	#tmpTable
					)

					UPDATE F_DOCLIGNE 
						SET DL_Taxe1 = 0
					WHERE DO_Piece IN (
						SELECT	DO_Piece 
						FROM	#tmpTable
					)
					AND DL_Taxe1<>0";
        $this->db->query($query);
    }

    public function alerteStock()
    {
        $query = "  SELECT A.AR_Ref,A.DE_No,A.DL_Qte,B.AS_QteSto
                    FROM (
                    SELECT AR_Ref,DE_No,SUM(CASE WHEN DL_MvtStock=1 THEN ABS(DL_Qte)
                    WHEN DL_MvtStock =3 THEN -DL_Qte ELSE 0 END) DL_Qte
                    FROM F_DOCLIGNE
                    GROUP BY AR_Ref,DE_No)A
                    INNER JOIN F_ARTSTOCK B ON A.AR_Ref=B.AR_Ref AND A.DE_No=B.DE_No
                    WHERE DL_Qte<>AS_QteSto";
        $result = $this->db->query($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $html = "";
        if ($rows != null) {
            $html = "<h1>Liste des articles en écart de stock {$this->db->db}</h1><br/><br/>";
            $html = $html . "<tr><th>Référence</th><th>Depot</th><th>Quantité</th><th>Stock</th>";
            foreach ($rows as $row) {
                $html = $html . "<tr><td>{$row->AR_Ref}</td><td>{$row->DE_No}</td><td>{$row->DL_Qte}</td><td>{$row->AS_QteSto}</td>";
            }
        }

        return $html;
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

    public function modifUser($username, $description, $password, $groupeid, $email, $profiluser, $id, $changepass)
    {
        $query = "
            BEGIN    
            DECLARE @userName NVARCHAR(50) = '$username'
            ,@protPwd NVARCHAR(50) = '{$this->crypteMdp($password)}'
            ,@protDescription NVARCHAR(50) = '$description'
            ,@protRight NVARCHAR(50) = ''
            ,@protEmail NVARCHAR(50) = '$email'
            ,@protPwdStatus NVARCHAR(50) = '$changepass'
            ,@protUserProfil NVARCHAR(50) = '$profiluser'
            ,@protUser NVARCHAR(50) = '$username'
            ,@protNo INT = $id;
                UPDATE [dbo].[F_PROTECTIONCPTA]
                SET [PROT_User] =@protUser,cbModification=GETDATE()
                   ,[PROT_Pwd] =@protPwd
                   ,[PROT_Description] = @protDescription
                   /*,[PROT_Right] =$groupeid */
                   ,[PROT_EMail] = @protEmail
                   ,PROT_PwdStatus = @protPwdStatus
                   ,[PROT_DatePwd] =GETDATE()
                 WHERE PROT_User=@protUser;

                UPDATE F_PROTECTIONCIAL
                SET [PROT_User] =@protUser,cbModification=GETDATE()
                   ,[PROT_Pwd] =@protPwd
                   ,[PROT_Description] = @protDescription
                   /*,[PROT_Right] =$groupeid*/
                   ,[PROT_EMail] = @protEmail
                   ,[PROT_UserProfil] = @protUserProfil
                   ,PROT_PwdStatus =@protPwdStatus
                   ,[PROT_DatePwd] =GETDATE()
                 WHERE PROT_No=@protNo;
            END;";
        $this->db->query($query);
    }

    public function connexionProctection($user, $mdp, $prot_no = 0)
    {
        $query = "
        DECLARE @user NVARCHAR(50) = '$user'
        DECLARE @mdp NVARCHAR(50) = '{$this->crypteMdp($mdp)}'
        DECLARE @protNo INT = $prot_no    
        SELECT	cbMarq
		,PROT_User
		,PROT_Pwd
		,Prot_No
		,PROT_PwdStatus
		,ProfilName
        ,ProtectAdmin
		,PROT_UserProfil
		,CASE WHEN PROT_Administrator =1 OR PROT_Right=1 THEN 1 ELSE 0 END PROT_Administrator
		,PROT_Description
		,PROT_Email
		,PROT_Right 
        ,ISNULL([33068],0) PROT_CBCREATEUR
		,ISNULL([33541],0) PROT_CLIENT
,ISNULL([33537],0) PROT_FAMILLE
,ISNULL([12132],0) PROT_OUVERTURE_TOUTE_LES_CAISSES
,ISNULL([33538],0) PROT_ARTICLE
,ISNULL([34051],0) PROT_DOCUMENT_STOCK
,ISNULL([34049],0) PROT_DOCUMENT_VENTE
,ISNULL([6150],0) PROT_DOCUMENT_VENTE_FACTURE
,ISNULL([6145],0) PROT_DOCUMENT_VENTE_DEVIS
,ISNULL([34050],0) PROT_DOCUMENT_ACHAT
,ISNULL([6404],0) PROT_DOCUMENT_ACHAT_RETOUR
,ISNULL([8193],0) PROT_DOCUMENT_ENTREE
,ISNULL([8194],0) PROT_DOCUMENT_SORTIE
,ISNULL([34056],0) PROT_DOCUMENT_REGLEMENT	
,ISNULL([6147],0) PROT_DOCUMENT_VENTE_BLIVRAISON
,ISNULL([34089],0) PROT_SAISIE_INVENTAIRE
,ISNULL([6148],0) PROT_DOCUMENT_VENTE_RETOUR
,ISNULL([6149],0) PROT_DOCUMENT_VENTE_AVOIR
,ISNULL([33547],0) PROT_DEPOT
,ISNULL([33542],0) PROT_FOURNISSEUR
,ISNULL([33546],0) PROT_COLLABORATEUR
,ISNULL([34056],0) PROT_SAISIE_REGLEMENT 
,ISNULL([30081],0) PROT_SAISIE_REGLEMENT_FOURNISSEUR
,ISNULL([12125],0) PROT_PX_ACHAT
,ISNULL([12126],0) PROT_PX_REVIENT
,ISNULL([12119],0) PROT_DATE_COMPTOIR
,ISNULL([12116],0) PROT_DATE_VENTE
,ISNULL([12117],0) PROT_DATE_ACHAT
,ISNULL([12118],0) PROT_DATE_STOCK
,ISNULL([34563],0) PROT_MVT_CAISSE
,ISNULL([12129],0) PROT_QTE_NEGATIVE
,ISNULL([12124],0) PROT_DATE_RGLT
,ISNULL([9985],0) PROT_RISQUE_CLIENT
,ISNULL([5122],0) PROT_CATCOMPTA -- traitement liste client complément
,ISNULL([8195],0) PROT_DEPRECIATION_STOCK
,ISNULL([12136],0) PROT_CTRL_TT_CAISSE
,ISNULL([12137],0) PROT_AFFICHAGE_VAL_CAISSE
,ISNULL([4868],0) PROT_INFOLIBRE_ARTICLE
,ISNULL([12121],0) PROT_DATE_MVT_CAISSE
,ISNULL([6401],0) PROT_DOCUMENT_ACHAT_PREPARATION_COMMANDE
,ISNULL([6406],0) PROT_DOCUMENT_ACHAT_FACTURE
,ISNULL([12128],0) PROT_MODIF_SUPPR_COMPTOIR
,ISNULL([11009],0) PROT_AVANT_IMPRESSION
,ISNULL([11010],0) PROT_APRES_IMPRESSION
,ISNULL([11011],0) PROT_TICKET_APRES_IMPRESSION
,ISNULL([34067],0) PROT_GENERATION_RGLT_CLIENT
,ISNULL([12306],0) PROT_DOCUMENT_INTERNE_2
,ISNULL([12134],0) PROT_MODIFICATION_CLIENT
,ISNULL([36678],0) PROT_ETAT_INVENTAIRE_PREP
,ISNULL([36677],0) PROT_ETAT_LIVRE_INV
,ISNULL([36672],0) PROT_ETAT_STAT_ARTICLE_PAR_ART
,ISNULL([36673],0) PROT_ETAT_STAT_ARTICLE_PAR_FAM
,ISNULL([36674],0) PROT_ETAT_STAT_ARTICLE_PALMARES
,ISNULL([34316],0) PROT_ETAT_MVT_STOCK
,ISNULL([36645],0) PROT_ETAT_CLT_PAR_FAM_ART
,ISNULL([36646],0) PROT_ETAT_CLT_PAR_ARTICLE
,ISNULL([36647],0) PROT_ETAT_PALMARES_CLT
,ISNULL([36661],0) PROT_ETAT_STAT_FRS_FAM_ART
,ISNULL([36662],0) PROT_ETAT_STAT_FRS
,ISNULL([12133],0) PROT_GEN_ECART_REGLEMENT
,ISNULL([36736],0) PROT_ETAT_STAT_CAISSE_ARTICLE
,ISNULL([36737],0) PROT_ETAT_STAT_CAISSE_FAM_ARTICLE
,ISNULL([36738],0) PROT_ETAT_CAISSE_MODE_RGLT
,ISNULL([36356],0) PROT_ETAT_RELEVE_CPTE_CLIENT
,ISNULL([36688],0) PROT_ETAT_STAT_COLLAB_PAR_TIERS
,ISNULL([36689],0) PROT_ETAT_STAT_COLLAB_PAR_ARTICLE
,ISNULL([36690],0) PROT_ETAT_STAT_COLLAB_PAR_FAMILLE
,ISNULL([34306],0) PROT_ETAT_STAT_ACHAT_ANALYTIQUE
,ISNULL([36357],0) PROT_ETAT_RELEVE_ECH_CLIENT
,ISNULL([36358],0) PROT_ETAT_RELEVE_ECH_FRS
,ISNULL([34562],0) PROT_VENTE_COMPTOIR
,ISNULL([12130],0) PROT_SAISIE_PX_VENTE_REMISE
,ISNULL([5126],0) PROT_TARIFICATION_CLIENT
,ISNULL([34095],0) PROT_CLOTURE_CAISSE
,ISNULL([34817],0) PROT_PLAN_COMPTABLE
,ISNULL([34818],0) PROT_PLAN_ANALYTIQUE
,ISNULL([34819],0) PROT_TAUX_TAXE
,ISNULL([34820],0) PROT_CODE_JOURNAUX
,ISNULL([34821],0) PROT_LISTE_BANQUE
,ISNULL([34822],0) PROT_LISTE_MODELE_REGLEMENT
,ISNULL([34319],0) PROT_REAPPROVISIONNEMENT
,ISNULL([12309],0) PROT_DOCUMENT_INTERNE_5
,ISNULL([6146],0) PROT_DOCUMENT_VENTE_BONCOMMANDE
,ISNULL([8196],0) PROT_VIREMENT_DEPOT
FROM(
        SELECT	P.cbMarq
                ,PROT_User
                ,PROT_Pwd
                ,P.Prot_No
                ,Prot_UserProfil
                ,P.PROT_PwdStatus
                ,P.Prot_Email
                ,ProtectAdmin = ISNULL(zpu.ProtectAdmin,0)
                ,ISNULL(ProfilName,PROT_User)ProfilName
                ,PROT_Administrator
                ,PROT_Description
                ,(CASE WHEN PROT_Description='SUPERVISEUR' OR PROT_Description='RAF' THEN 1 ELSE PROT_Right END) PROT_Right 
                ,ISNULL(CASE WHEN C.EPROT_Cmd IS NULL THEN B.EPROT_Right ELSE C.EPROT_Right END,0)EPROT_Right
                ,B.EPROT_Cmd
        FROM    F_PROTECTIONCIAL P
        LEFT JOIN ( SELECT  Prot_No AS ProtUserProfilP
                            ,PROT_User AS ProfilName 
                    FROM    F_PROTECTIONCIAL) Profil 
            ON Prot_UserProfil = ProtUserProfilP 
        LEFT JOIN (SELECT   PROT_No
                            ,EPROT_Right
                            ,Libelle_Cmd,A.EPROT_Cmd
                    FROM    F_EPROTECTIONCIAL A 
                    LEFT JOIN LIB_CMD B 
                        ON  B.PROT_Cmd = A.EPROT_Cmd
                    ) B 
            ON B.PROT_No = ProtUserProfilP
        LEFT JOIN (SELECT PROT_No,EPROT_Right,Libelle_Cmd,A.EPROT_Cmd
                    FROM F_EPROTECTIONCIAL A 
                    LEFT JOIN LIB_CMD B 
                        ON B.PROT_Cmd = A.EPROT_Cmd) C
            ON C.PROT_No = P.PROT_No
        LEFT JOIN Z_ProtUser zpu            
            ON zpu.PROT_No = P.PROT_No
        WHERE (PROT_Right<>0 OR (PROT_Right=0 AND b.EPROT_Cmd IN (	'33541','33537','33538','34051','34049'
                                ,'6150','6145','34050','8193','8194','34067','12306','8196'
                                ,'36678','36677','36672','36673','36674','6404','12132'
                                ,'12133','36736','36737','36738','36357','36358','5122','34819','6146'
                                ,'34316','36645','36646','36647','34562','12130','34095','34817','34822','34319'
                                ,'34056','6147','34089','6148','6149','33547','33542','33546','34818','34820','12309'
                                ,'30081','12125','12126','12119','12116','12117','12118','34563','12134','5126','34821'
                                ,'12129','12124','9985','8195','12136','12137','4868','12121','6401','6406','12128','11009','11010','11011'
                                ,'36356','36688','36689','36690','36661','36662','34306','33068')))
        )A
        
        PIVOT(
        SUM(EPROT_RIGHT)
        FOR EPROT_Cmd IN (	[33541],[33537],[33538],[34051],[34049],[6150],[6145],[34050],[8193],[8194]
                            ,[34056],[6147],[34089],[6148],[6149],[33547],[33542],[33546],[34067],[12306]
                            ,[30081],[12125],[12126],[12119],[12116],[12117],[12118],[34563],[12134]
                            ,[36678],[36677],[36672],[36673],[36674],[34562],[6404],[12132],[6146]
                            ,[12133],[36736],[36737],[36738],[36357],[36358],[34095],[34817],[34822],[8196]
                            ,[36356],[36688],[36689],[36690],[34306],[12130],[33068],[5122],[34820],[34821]
                            ,[34316],[36645],[36646],[36647],[36661],[36662],[5126],[34818],[34819],[34319],[12309]
                            ,[12129],[12124],[9985],[8195],[12136],[12137],[4868],[12121],[6401],[6406],[12128],[11009],[11010],[11011]))AS PIVOTTABLE
                        WHERE (@protNo=0 AND PROT_User=@user AND PROT_Pwd=@mdp) OR (@protNo!=0 AND PROT_No=@protNo) ";
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function connectSage2()
    {
        $query = "SELECT  P.PROT_No,P.Prot_Administrator,P.Prot_Right,PR.Prot_Description,
                        P.PROT_User,P.PROT_UserProfil,ISNULL(CA_Souche,1)CA_Souche,
                        ISNULL(DE_No,1)DE_No,ISNULL(CA_No,1)CA_No,
                        ISNULL(CO_No,0)CO_No,P.cbModification,P.Prot_DateCreate
                FROM F_PROTECTIONCIAL P
                LEFT JOIN F_PROTECTIONCIAL Pr 
                    ON P.PROT_UserProfil = PR.Prot_No
                LEFT JOIN ( SELECT C.CO_No,CA.CA_No,DE_No,CA_Souche,PROT_No,CO_Nom
                            FROM    F_COLLABORATEUR C 
                            LEFT JOIN F_CAISSECAISSIER CC 
                                ON  C.CO_No= CC.CO_No
                            LEFT JOIN F_CAISSE CA 
                                ON  CA.CA_No = CC.CA_No 
                                AND CA.CO_No=C.CO_No) A 
                    ON  A.CO_Nom=P.PROT_User
                WHERE   P.Prot_User= '{$this->PROT_User}' 
                AND     P.PROT_pwd= '{$this->PROT_Pwd}'
                ORDER BY DE_No desc";
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    function listeFactureNom($value)
    {
        if ($value == "Vente" || $value == "VenteC" || $value == "VenteT")
            return "Document de vente";
        if ($value == "Devis")
            return "Document de devis";
        if ($value == "BonCommande")
            return "Bon de commande";
        if ($value == "BonLivraison")
            return "Document de bon de livraison";
        if ($value == "VenteAvoir")
            return "Document d'avoir de vente";
        if ($value == "VenteRetour")
            return "Document de retour de vente";
        if ($value == "Ticket")
            return "Document ticket";

        if ($value == "Achat" || $value == "AchatC" || $value == "AchatT")
            return "Document d'achat";
        if ($value == "PreparationCommande")
            return "Document de préparation de commande";
        if ($value == "AchatPreparationCommande")
            return "Document d'achat préparation de commande";
        if ($value == "AchatRetour")
            return "Document de retour d'achat ";

        if ($value == "Transfert")
            return "Document de transfert";
        if ($value == "Entree")
            return "Document d'entrée";
        if ($value == "Sortie")
            return "Document de sortie";
        if ($value == "Transfert_detail")
            return "Document de transfert détail";
        if ($value == "Transfert_confirmation")
            return "Document confirmation de transfert";
        if ($value == "Transfert_valid_confirmation")
            return "Document validation confirmation transfert";

        return "";
    }

    public function BarreMenu($protNo,$module,$action,$type,$position)
    {
        return $this->getApiJson("/barreMenu&protNo=$protNo&module=$module&action=$action&type=$type&position=$position");

    }

    public function getSoucheDepotCaisse($prot_no,$type,$souche,$ca_no,$depot,$ca_num){
        return $this->getApiJson("/getSoucheDepotCaisse&protNo=$prot_no&type=$type&doSouche=$souche&caNo=$ca_no&deNo=$depot&caNum={$this->formatString($ca_num)}");
    }
    public function getNumContribuable()
    {
        $this->lien = "pdossier";
        return $this->getApiJson("/all");
    }

    public function getAffaire($sommeil=-1) {
        $this->lien = "fcomptea";
        return $this->getApiJson("/affaire&sommeil=$sommeil");
    }

    public function getSoucheDepotGrpAffaire($prot_no,$type,$sommeil=-1){
        return $this->getApiJson("/getSoucheDepotGrpAffaire&protNo=$prot_no&type=$type&sommeil=$sommeil");
    }

    public function getSoucheDepotGrpSouche($prot_no,$type){
        return $this->getApiJson("/getSoucheDepotGrpSouche&protNo=$prot_no&type=$type");
    }

    public function getSoucheAchat(){
        $this->lien = "psouche";
        return $this->getApiJson("/soucheAchat");
    }

    public function getSoucheInterne(){
        $this->lien = "psouche";
        return $this->getApiJson("/soucheInterne");
    }

    public function getSoucheVente(){
        $this->lien = "psouche";
        return $this->getApiJson("/soucheVente");
    }

    public function __toString()
    {
        return "";
    }

}
