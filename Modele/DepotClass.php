<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class DepotClass Extends Objet{
    //put your code here
    public $db,$DE_No,$DE_Intitule,$DE_Adresse,$DE_Complement,$DE_CodePostal,$DE_Ville,$DE_Contact,$DE_Principal
    ,$DE_CatCompta,$DE_Region,$DE_Pays,$DE_EMail,$DE_Code,$DE_Telephone,$DE_Telecopie,$DE_Replication
    ,$DP_NoDefaut,$cbMarq,$cbModification,$CA_CatTarif;
    public $table = 'F_DEPOT';
    public $lien = "fdepot";

    function __construct($id,$db=null) {
        if($id =="")
            $id = 0;
        $this->data = $this->getApiJson("/deNo=$id");
        if(sizeof($this->data) > 0) {
            $this->DE_No = $this->data[0]->DE_No;
            $this->DE_Intitule = stripslashes($this->data[0]->DE_Intitule);
            $this->DE_Complement = $this->data[0]->DE_Complement;
            $this->DE_CodePostal = $this->data[0]->DE_CodePostal;
            $this->DE_Ville = $this->data[0]->DE_Ville;
            $this->DE_Contact = stripslashes($this->data[0]->DE_Contact);
            $this->DE_Principal = stripslashes($this->data[0]->DE_Principal);
            $this->DE_CatCompta = $this->data[0]->DE_CatCompta;
            $this->DE_Region = $this->data[0]->DE_Region;
            $this->DE_Pays = $this->data[0]->DE_Pays;
            $this->DE_EMail = $this->data[0]->DE_EMail;
            $this->DE_Code = $this->data[0]->DE_Code;
            $this->DE_Telephone = $this->data[0]->DE_Telephone;
            $this->DE_Telecopie = $this->data[0]->DE_Telecopie;
            $this->DE_Replication = $this->data[0]->DE_Replication;
            $this->DP_NoDefaut = $this->data[0]->DP_NoDefaut;
            $this->cbMarq = $this->data[0]->cbMarq;
            $this->cbModification = $this->data[0]->cbModification;
            $this->setCatTarif();
        }
    }


    public function setCatTarif(){
        $this->CA_CatTarif = $this->getApiString("/setCatTarif&deNo={$this->DE_No}");
    }

    public function maj_depot(){
        parent::maj('DE_Intitule', $this->DE_Intitule);
        parent::maj('DE_Complement', $this->DE_Complement);
        parent::maj('DE_CodePostal', $this->DE_CodePostal);
        parent::maj('DE_Ville', $this->DE_Ville);
        parent::maj('DE_Contact', $this->DE_Contact);
        parent::maj('DE_Principal', $this->DE_Principal);
        parent::maj('DE_CatCompta', $this->DE_CatCompta);
        parent::maj('DE_Region', $this->DE_Region);
        parent::maj('DE_Pays', $this->DE_Pays);
        parent::maj('DE_EMail', $this->DE_EMail);
        parent::maj('DE_Code', $this->DE_Code);
        parent::maj('DE_Telephone', $this->DE_Telephone);
        parent::maj('DE_Telecopie', $this->DE_Telecopie);
        parent::maj('DE_Replication', $this->DE_Replication);
        parent::maj('DP_NoDefaut', $this->DP_NoDefaut);
        parent::maj('cbModification', $this->cbModification);
        parent::maj('cbCreateur', $this->userName);
        $this->majCatTarif();
        $this->majcbModification();
    }

    public function __toString() {
        return "";
    }

    public function majCatTarif(){
        $this->getApiExecute("/majCatTarif&deNo={$this->DE_No}&catTarif={$this->CA_CatTarif}");
    }


    public function insertFDepot($caSoucheVente,$caSoucheAchat,$caSoucheInterne,$caisse,$codeClient)
    {
        return $this->getApiJson("/insertDepot&deIntitule={$this->formatString($this->DE_Intitule)}&deAdresse={$this->formatString($this->DE_Adresse)}&deComplement={$this->formatString($this->DE_Complement)}&deCodePostal={$this->formatString($this->DE_CodePostal)}&deVille={$this->formatString( $this->DE_Ville)}&deContact={$this->formatString($this->DE_Contact)}&deRegion={$this->formatString($this->DE_Region)}&dePays={$this->formatString($this->DE_Pays)}&deEmail={$this->formatString($this->DE_EMail)}&deTelephone={$this->formatString($this->DE_Telephone)}&deTelecopie={$this->formatString($this->DE_Telecopie)}&protNo=".$_SESSION["id"]."&caSoucheVente=$caSoucheVente&caSoucheAchat=$caSoucheAchat&caSoucheInterne=$caSoucheInterne&affaire={$this->formatString($this->CA_Num)}&caisse=$caisse&codeClient={$this->formatString($codeClient)}");

//        $this->majCatTarif();
    }

    public function insertDepotClient($codeClient)
    {
        $this->getApiExecute("/insertDepotClient&deNo={$this->DE_No}&value=$codeClient");
    }

    public function insertDepotSouche($CA_SoucheVente,$CA_SoucheAchat,$CA_SoucheStock,$CA_Num){
        $this->getApiExecute( "/insertDepotSouche&deNo={$this->DE_No}&caNum=$CA_Num&caSoucheVente=$CA_SoucheVente&caSoucheAchat=$CA_SoucheAchat&caSoucheStock=$CA_SoucheStock");
    }

    public function updateDepotSouche($CA_SoucheVente,$CA_SoucheAchat,$CA_SoucheStock,$CA_Num){
        $this->getApiExecute("/updateDepotSouche&caSoucheVente={$CA_SoucheVente}&caSoucheAchat={$CA_SoucheAchat}&caSoucheStock={$CA_SoucheStock}&caNum={$CA_Num}");
    }

    public function insertDepotCaisse($CA_No){
        $this->getApiExecute( "/insertDepotCaisse&deNo={$this->DE_No}&caNo=$CA_No");
    }

    public function modifDepotCaisse($CA_No){
        $this->getApiExecute("/modifDepotCaisse&deNo={$this->DE_No}&caNo=$CA_No");
    }

    public function getDepotCaisse(){
        return $this->getApiJson("/modifDepotCaisse&deNo={$this->DE_No}");
    }

    public function getDepotSouche(){
        return $this->getApiJson("/getDepotSouche&deNo={$this->DE_No}");
    }

    public function supprDepotClient(){
        $this->getApiExecute("/supprDepotClient&deNo={$this->DE_No}");
    }

    public function alldepotShortDetail(){
        return $this->getApiJson("/depotShortDetail");
    }

    public function getDepotUser($Prot_No){
        return $this->getApiJson("/getDepotUser&protNo=$Prot_No");
    }

    public function getDepotUserSearch($Prot_No,$depotExclude,$searchTerm,$principal=1){
        return $this->getApiJson("/getDepotUserSearch&protNo=$Prot_No&depotExclude=$depotExclude&searchTerm={$this->formatString($searchTerm)}&principal=$principal");
    }

    public function getDepotUserPrincipal($Prot_No){
        return $this->getApiJson("/getDepotUserPrincipal&protNo=$Prot_No");
    }

    public function delete() {
        $this->getApiJson("/deleteDepot&deNo={$this->DE_No}");
    }

    public function supprDepotUser($prot_user)
    {
        $this->lien = "zdepotuser";
        return $this->getApiExecute("/supprDepotUser&protNo=$prot_user");
    }

    public function insertDepotUser($prot_user)
    {
        $query = "INSERT INTO Z_DEPOTUSER VALUES({$prot_user},{$this->DE_No},0)";
        $this->db->query($query);
    }

    public function setPrincipalDepotUser($prot_user, $de_no)
    {
        $query = " UPDATE Z_DEPOTUSER SET IsPrincipal=1 
                    WHERE DE_No=$de_no 
                    AND   prot_no=$prot_user";
        $this->db->query($query);
    }

    public function getDepotByIntitule($intitule,$depotExclude=-1){
        $value = $this->getApiJson("/getDepotByIntitule&deNo=$depotExclude&intitule={$this->formatString($intitule)}");
        $rows=array();
        foreach ($value as $val){
            $rows[] = array("id" => $val->DE_No , "text" => $val->DE_Intitule,"DE_Intitule" => $val->DE_Intitule,"DE_No" => $val->DE_No , "value" => $val->DE_Intitule );
        }
        return $rows;
    }

    public function listEmpl($listId,$protNo){
        $this->getApiJson("/listEmpl&listId={$listId}&protNo={$protNo}");
    }
}