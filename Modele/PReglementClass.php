<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class PReglementClass Extends Objet{
    //put your code here
    public $db,$R_Intitule
    ,$R_ModePaieDebit
    ,$IB_AFBDecaissPrinc
    ,$IB_AFBEncaissPrinc
    ,$EB_NoDecaiss
    ,$EB_NoEncaiss
    ,$cbIndice
    ,$cbMarq;

    public $lien = 'preglement';
    public $table = 'P_REGLEMENT';

    function __construct($id,$db=null) {
        $this->db = new DB();
        $this->data = $this->getApiJson("/cbMarq=$id");
        if(sizeof($this->data)>0) {
            $this->R_Intitule = $this->data[0]->R_Intitule;
            $this->R_ModePaieDebit = $this->data[0]->R_ModePaieDebit;
            $this->IB_AFBDecaissPrinc = $this->data[0]->IB_AFBDecaissPrinc;
            $this->IB_AFBEncaissPrinc = $this->data[0]->IB_AFBEncaissPrinc;
            $this->EB_NoDecaiss = $this->data[0]->EB_NoDecaiss;
            $this->EB_NoEncaiss = $this->data[0]->EB_NoEncaiss;
            $this->cbIndice = $this->data[0]->cbIndice;
            $this->cbMarq = $this->data[0]->cbMarq;
        }
    }

    public function __toString() {
        return "";
    }

}