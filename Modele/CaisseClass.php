<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class CaisseClass Extends Objet{
    //put your code here
    public $db,$CA_No,$CA_Intitule,$DE_No,$CO_No,$CO_NoCaissier,$CT_Num,$JO_Num,$CA_Souche,$cbCreateur;
    public $table = 'F_CAISSE';
    public $lien ="fcaisse";

    function __construct($id)
    {
        $this->data = $this->getApiJson("/$id");
        if($id!=0)
        if (sizeof($this->data) > 0) {
            $this->CA_No = $this->data[0]->CA_No;
            $this->CA_Intitule = stripslashes($this->data[0]->CA_Intitule);
            $this->DE_No = $this->data[0]->DE_No;
            $this->CO_No = $this->data[0]->CO_No;
            $this->CO_NoCaissier = $this->data[0]->CO_NoCaissier;
            $this->CT_Num = stripslashes($this->data[0]->CT_Num);
            $this->JO_Num = stripslashes($this->data[0]->JO_Num);
            $this->CA_Souche = $this->data[0]->CA_Souche;
            $this->cbCreateur = $this->data[0]->cbCreateur;

        }
    }

    public function maj_caisse($codeDepot){
        parent::maj('CA_Intitule', $this->CA_Intitule);
        parent::maj('DE_No', $this->DE_No);
        parent::maj('CO_No', $this->CO_No);
        parent::maj('CO_NoCaissier', $this->CO_NoCaissier);
        parent::maj('CT_Num', $this->CT_Num);
        parent::maj('JO_Num', $this->JO_Num);
        parent::maj('CA_Souche', $this->CA_Souche);
        $this->udpdateCodeDepot($codeDepot);
    }

    public function udpdateCodeDepot($codeDepot){
        $this->getApiExecute("/udpdateCodeDepot&caNo={$this->CA_No}&codeDepot=$codeDepot");
    }
    public function insertCaisse($codeDepot,$protNo){
        return $this->getApiJson("/insertCaisse/caIntitule={$this->formatString($this->CA_Intitule)}&coNoCaissier={$this->CO_NoCaissier}&joNum={$this->formatString($this->JO_Num)}&cbCreateur={$protNo}&codeDepot=$codeDepot");
    }

    public function clotureCaisse($dateCloture,$caisseDebut,$caisseFin,$ProtNo,$typeCloture)
    {
        $this->getApiExecute("/clotureCaisse/dateCloture=$dateCloture&caisseDebut=$caisseDebut&caisseFin=$caisseFin&protNo=$ProtNo&typeCloture=$typeCloture");
    }

    public function listeCaisseShort(){
        return $this->getApiJson("/listeCaisseShort");
    }

    public function getCaisseProtNo($protNo){
        return $this->getApiJson("/getCaisseProtNo&protNo={$protNo}");
    }

    public function getCaisseDepot($prot_no){
        return $this->getApiJson("/getCaisseDepot/$prot_no");
    }

    public function getCaNum(){
        return $this->getApiJson("/getCaNum&caNo={$this->CA_No}");
    }

    public function getCaissierByCaisse($ca_no)
    {
        return $this->getApiJson("/getCaissierByCaisse&caNo=$ca_no");
    }

    public function getCaisseByCA_No($ca_no) {
        return $this->getApiJson("/getCaisseByCA_No&caNo=$ca_no");
    }

    public function __toString() {
        return "";
    }

    public function getCaisseUser($Prot_No,$depotExclude,$searchTerm,$principal=1){
        return $this->getApiJson("/getCaisseUser&protNo={$Prot_No}&depotExclude={$depotExclude}&searchTerm={$searchTerm}&principal={$principal}");
    }


    public function getCaisseByIntitule($intitule,$depotExclude=-1){
        $value = $this->getApiJson("/getCaisseByIntitule&intitule={$this->formatString($intitule)}&depotExclude={$depotExclude}");
        foreach ($value as $val){
            $rows[] = array("id" => $val->CA_No , "text" => $val->CA_Intitule,"CA_Intitule" => $val->CA_Intitule,"CA_No" => $val->CA_No , "value" => $val->CA_Intitule );
        }
        return $rows;
    }


}