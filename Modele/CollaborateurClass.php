<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class CollaborateurClass Extends Objet{
    //put your code here
    public $db,$CO_No,$CO_Nom,$CO_Prenom,$CO_Fonction,$CO_Adresse
    ,$CO_Complement,$CO_CodePostal,$CO_Ville,$CO_CodeRegion
    ,$CO_Pays,$CO_Service,$CO_Vendeur,$CO_Caissier
    ,$CO_DateCreation,$CO_Acheteur,$CO_Telephone,$CO_Telecopie
    ,$CO_EMail,$CO_Receptionnaire,$PROT_No,$CO_TelPortable,$CO_ChargeRecouvr,$cbCreateur;
    public $table = 'F_COLLABORATEUR';
    public $lien ="fcollaborateur";

    function __construct($id,$db=null)
    {
        $this->data = $this->getApiJson("/$id");
        if (sizeof($this->data)>0) {

            $this->CO_No = $this->data[0]->CO_No;
            $this->CO_Nom = stripslashes($this->data[0]->CO_Nom);
            $this->CO_Prenom = stripslashes($this->data[0]->CO_Prenom);
            $this->CO_Fonction = stripslashes($this->data[0]->CO_Fonction);
            $this->CO_Adresse = stripslashes($this->data[0]->CO_Adresse);
            $this->CO_Complement = stripslashes($this->data[0]->CO_Complement);
            $this->CO_Ville = stripslashes($this->data[0]->CO_Ville);
            $this->CO_Prenom = stripslashes($this->data[0]->CO_Prenom);
            $this->CO_EMail = stripslashes($this->data[0]->CO_EMail);
            $this->CO_Prenom = stripslashes($this->data[0]->CO_Prenom);
            $this->CO_CodePostal = $this->data[0]->CO_CodePostal;
            $this->CO_CodeRegion = $this->data[0]->CO_CodeRegion;
            $this->CO_Pays = $this->data[0]->CO_Pays;
            $this->CO_Service = stripslashes($this->data[0]->CO_Service);
            $this->CO_Vendeur = stripslashes($this->data[0]->CO_Vendeur);
            $this->CO_Caissier = $this->data[0]->CO_Caissier;
            $this->CO_DateCreation = $this->data[0]->CO_DateCreation;
            $this->CO_Acheteur = $this->data[0]->CO_Acheteur;
            $this->CO_Telephone = $this->data[0]->CO_Telephone;
            $this->CO_Receptionnaire = $this->data[0]->CO_Receptionnaire;
            $this->PROT_No = $this->data[0]->PROT_No;
            $this->CO_TelPortable = $this->data[0]->CO_TelPortable;
            $this->CO_ChargeRecouvr = $this->data[0]->CO_ChargeRecouvr;
            $this->cbCreateur = $this->data[0]->cbCreateur;
        }
    }

    public function maj_collaborateur(){
        parent::maj(CO_No, $this->CO_No);
        parent::maj(CO_Nom, $this->CO_Nom);
        parent::maj(CO_Prenom, $this->CO_Prenom);
        parent::maj(CO_Fonction, $this->CO_Fonction);
        parent::maj(CO_Adresse, $this->CO_Adresse);
        parent::maj(CO_Complement, $this->CO_Complement);
        parent::maj(CO_Ville, $this->CO_Ville);
        parent::maj(CO_Prenom, $this->CO_Prenom);
        parent::maj(CO_EMail, $this->CO_EMail);
        parent::maj(CO_CodePostal, $this->CO_CodePostal);
        parent::maj(CO_CodeRegion, $this->CO_CodeRegion);
        parent::maj(CO_Service, $this->CO_Service);
        parent::maj(CO_Vendeur, $this->CO_Vendeur);
        parent::maj(CO_Caissier, $this->CO_Caissier);
        parent::maj(CO_DateCreation, $this->CO_DateCreation);
        parent::maj(CO_Acheteur, $this->CO_Acheteur);
        parent::maj(CO_Telephone, $this->CO_Telephone);
        parent::maj(CO_Receptionnaire, $this->CO_Receptionnaire);
        parent::maj(PROT_No, $this->PROT_No);
        parent::maj(CO_TelPortable, $this->CO_TelPortable);
        parent::maj(CO_ChargeRecouvr, $this->CO_ChargeRecouvr);
        parent::maj("cbCreateur", $this->userName);
    }

    public function getCollaborateurByNom($intitule){
        return $this->getApiJson("/getCollaborateurByNom&coNom={$this->formatString($intitule)}");
    }

    public function getCaissierByIntitule($intitule){
        $rows = array();
        $value = $this->getApiJson("/getCaissierByIntitule&coNom={$this->formatString($intitule)}");
        foreach ($value as $val){
            $rows[] = array("label" => $val->CT_Intitule
            ,"value" => $val->CT_Num);
        }
        return $rows;
    }


    public function allCaissier(){
        return $this->getApiJson("/allCaissier"); //converts to an object
    }

    public function allAcheteur(){
        return $this->getApiJson("/allAcheteur"); //converts to an object
    }

    public function allVendeur(){
        return $this->getApiJson("/allVendeur"); //converts to an object
    }


    public function __toString() {
        return "";
    }

    public function insertCollaborateur($nom, $prenom, $adresse, $complement, $codepostal, $fonction, $ville, $region, $pays, $service, $vendeur, $caissier, $acheteur, $telephone, $telecopie, $email, $controleur, $recouvrement,$protNo)
    {

        return $this->getApiJson("/insertCollaborateur/coNom={$this->formatString($nom)}&coPrenom={$this->formatString($prenom)}
        &codePostal={$this->formatString($codepostal)}
        &coFonction={$this->formatString($fonction)}&coAdresse={$this->formatString($adresse)}&coComplement={$this->formatString($complement)}&coVille={$this->formatString($ville)}
        &coCodeRegion={$this->formatString($region)}&coPays={$this->formatString($pays)}&coService={$this->formatString($service)}&coVendeur={$vendeur}&coCaissier={$caissier}
        &coAcheteur={$acheteur}&coTelephone={$telephone}&coTelecopie={$telecopie}&coEmail={$this->formatString($email)}
        &coReceptionnaire=$controleur&coChargeRecouvr={$recouvrement}&cbCreateur={$protNo}");

    }


    public function modifCollaborateur($nom, $prenom, $adresse, $complement, $codepostal, $fonction, $ville, $region, $pays, $service, $vendeur, $caissier, $acheteur, $telephone, $telecopie, $email, $controleur, $recouvrement, $co_no,$protNo)
    {
        $this->getApiJson("/modifCollaborateur/coNom={$this->formatString($nom)}&coPrenom={$this->formatString($prenom)}&codePostal=$codepostal&coFonction={$this->formatString($fonction)}&coAdresse={$this->formatString($adresse)}&coComplement={$this->formatString($complement)}&coVille={$this->formatString($ville)}&coCodeRegion={$this->formatString($region)}&coPays={$this->formatString($pays)}&coService={$this->formatString($service)}&coVendeur=$vendeur&coCaissier=$caissier&coAcheteur=$acheteur&coTelephone=$telephone&coTelecopie=$telecopie&coEmail={$this->formatString($email)}&coReceptionnaire=$controleur&coChargeRecouvr=$recouvrement&cbCreateur=$protNo&coNo=$co_no");
    }


}