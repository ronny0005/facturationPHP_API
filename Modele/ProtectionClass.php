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
        return $this->getApiExecute("/setSecuriteAdmin&protNo={$this->PROT_No}&value=$value");
    }

    public function update()
    {
        $this->maj("PROT_User",$this->PROT_User);
    }

    public function createUser() {
        return $this->getApiJson("/createUser/protUser={$this->PROT_User}&protPwd={$this->PROT_Pwd}&protDescription={$this->PROT_Description}&protRight={$this->PROT_Right}&protEmail={$this->PROT_Email}&protUserProfil={$this->PROT_UserProfil}&ProtPwdStatus={$this->PROT_PwdStatus}");
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

    public function ajoutUser($securiteAdmin,$depot,$depotPrincipal){
        $protNo = $this->getApiJson("/ajoutUser&username={$this->formatString($this->PROT_User)}&description={$this->formatString($this->PROT_Description)}&password={$this->formatString($this->PROT_Pwd)}&email={$this->formatString($this->PROT_Email)}&protRight={$this->PROT_Right}&protUserProfil={$this->PROT_UserProfil}&protPwdStatus={$this->PROT_PwdStatus}&securiteAdmin=$securiteAdmin&protNo=".$_SESSION["id"]."&depot=$depot");
        $this->setDepotUser($this->PROT_No,implode( ",",$depotPrincipal));
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

    public function getListProfil()
    {
        return $this->getApiJson("/getListProfil");

    }

    public function annee_exercice()
    {
        return $this->getApiJson("/annee_exercice");
    }

    public function deconnexionTotale()
    {
        return $this->getApiExecute("/annee_exercice");
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


    public function getUser(){
        return $this->getApiJson("/getUser");
    }

    public function getProtectionListTitre(){
        return $this->getApiJson("/getProtectionListTitre");
    }

    public function getProtectionListElement($idParent){
        return $this->getApiJson("/getProtectionListElement&parent=$idParent");
    }


    public function getUserAdminMain(){
        return $this->getApiJson("/getUserAdminMain");
    }
    public function getProfilAdminMain(){
        return $this->getApiJson("/getProfilAdminMain");
    }

    public function getUtilisateurAdminMain(){
        return $this->getApiJson("/getUtilisateurAdminMain");
    }

    public function getUtilisateurAdminMainConnexion()
    {
        return $this->getApiJson("/getUtilisateurAdminMainConnexion");
    }


    public function getDataUser($prot_no)
    {
        return $this->getApiJson("/getDataUser&protNo=$prot_no");
    }

    public function getDataUserNo($te_no,$prot_no){
        return $this->getApiJson("/getDataUserNo&teNo=$te_no&protNo=$prot_no");
    }
    public function getPrixParCatCompta(){
        $this->lien='pparametrecial';
        $rows = $this->getApiJson("/getPrixParCatCompta");
        return $rows[0]->P_ReportPrixRev;
    }

    public function getFormatReferenceEcriture()
    {
        $this->lien='pparametrecial';
        $rows = $this->getApiJson("/getFormatReferenceEcriture");
        return $rows[0]->P_Piece02;
    }

    public function getFormatPieceFacturation()
    {
        $this->lien='pparametrecial';
        $rows = $this->getApiJson("/getFormatPieceFacturation");
        return $rows[0]->P_Piece01;
    }

    public function getDataUserProfil($prot_no){
        return $this->getApiJson("/getDataUserProfil&protNo=$prot_no");
    }


    public function updateEProtection($prot_no,$eprot_cmd,$prot_right){
        return $this->getApiExecute("/updateEProtection&protNo=$prot_no&eprotCmd=$eprot_cmd&protRight=$prot_right");
    }

    public function updateProfil($prot_no, $prot_no_profil)
    {
        $this->Prot_No = $prot_no;
        $this->maj("PROT_UserProfil",$prot_no_profil);
    }

    public function insertIntoZ_Calendar_user($PROT_No, $ID_JourDebut, $ID_JourFin, $ID_HeureDebut, $ID_MinDebut, $ID_HeureFin, $ID_MinFin)
    {
        $this->lien = "zCalendarUser";
        $this->getApiExecute("/insertIntoZ_Calendar_user&protNo={$PROT_No}&idJourDebut={$ID_JourDebut}&idJourFin={$ID_JourFin}&idHeureDebut={$ID_HeureDebut}&idHeureFin={$ID_HeureFin}&idMinDebut={$ID_MinDebut}&idMinFin={$ID_MinFin}");

    }


    public function deleteZ_Calendar_user($PROT_No)
    {
        $this->lien = "zCalendarUser";
        return $this->getApiExecute("/deleteZ_Calendar_user&protNo={$PROT_No}");
    }

    public function getZ_Calendar_user($PROT_No, $i)
    {
        $this->lien = "zCalendarUser";
        return $this->getApiJson("/getZ_Calendar_user&protNo={$PROT_No}&i=$i");
    }

    public function listUserProfil()
    {
        return $this->getApiJson("/listUserProfil&protNo={$this->Prot_No}");
    }

    public function majZ_Calendar_user($PROT_No, $ID_JourDebut, $ID_JourFin, $ID_HeureDebut, $ID_MinDebut, $ID_HeureFin, $ID_MinFin)
    {
        $this->lien = "zCalendarUser";
        $this->getApiExecute("/majZ_Calendar_user&protNo={$PROT_No}&idJourDebut={$ID_JourDebut}&idJourFin={$ID_JourFin}&idHeureDebut={$ID_HeureDebut}&idHeureFin={$ID_HeureFin}&idMinDebut={$ID_MinDebut}&idMinFin={$ID_MinFin}");
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
        return $this->getApiJson("/listAlertTransfert");
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
        return $this->getApiJson("/listAlerteDocumentCatComptaTaxe");
    }

    public function fixCatCompta()
    {
        $this->getApiExecute("/fixCatCompta");
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
        $this->getApiExecute("/modifUser&userName={$username}&description={$description}&password={$password}&eMail={$email}&changePass={$changepass}&profilUser={$username}&protNo={$id}&groupeId={$groupeid}");
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
