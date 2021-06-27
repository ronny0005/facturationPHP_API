<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class DepotCaisseClass Extends Objet{
    //put your code here
    public $db,$DE_No,$CA_No;
    public $table = 'Z_DEPOTCAISSE';

    function __construct($id,$db=null) {

        if(sizeof($this->data)>0) {
            $this->list = $this->data;
        }
    }

    public function getDepotCaisseSelect($caisseVal){
        return $this->getApiJson("/getDepotCaisseSelect&caNo=$caisseVal");
    }

    public function __toString() {
        return "";
    }

}