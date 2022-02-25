<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class DepotEmplClass Extends Objet{
    //put your code here
    public $db,$DE_No,$DP_No,$DP_Intitule,$DP_Code,$DP_Zone,$DP_Type,$cbMarq,$cbModification;
    public $table = 'F_DEPOTEMPL';
    public $lien = "fdepotempl";

    function __construct($id,$db=null) {
        $this->data = $this->getApiJson("/dpNo=$id");
        if(sizeof($this->data) > 0) {
            $this->DE_No = $this->data[0]->DE_No;
            $this->DP_No = $this->data[0]->DP_No;
            $this->DP_Intitule = stripslashes($this->data[0]->DP_Intitule);
            $this->DP_Code = $this->data[0]->DP_Code;
            $this->DP_Zone = $this->data[0]->DP_Zone;
            $this->DP_Type = $this->data[0]->DP_Type;
            $this->cbMarq = $this->data[0]->cbMarq;
            $this->cbModification = $this->data[0]->cbModification;
        }
    }

    public function maj_depotEmpl(){
        parent::maj('DE_No', $this->DE_No);
        parent::maj('DP_No', $this->DP_No);
        parent::maj('DP_Intitule', $this->DP_Intitule);
        parent::maj('DP_Code', $this->DP_Code);
        parent::maj('DP_Zone', $this->DP_Zone);
        parent::maj('DP_Type', $this->DP_Type);
        parent::maj('cbCreateur', $this->userName);
        $this->majcbModification();
    }


    public function allSearch($intitule="",$top=0){
        return $this->getApiJson("/allSearch&intitule={$intitule}");
    }

    public function allSearchUser($intitule="",$protNo,$top=0){
        return $this->getApiJson("/allSearchUser&intitule={$intitule}&protNo={$protNo}");
    }

    public function listEmplacementByDepot($ids){
        return $this->getApiJson("/listEmplacementByDepot&ids={".implode(",",$ids)."}");
    }

    public function __toString() {
        return "";
    }

}