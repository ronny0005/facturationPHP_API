<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class DepotUserClass Extends Objet{
    //put your code here
    public $db,$DE_No,$Prot_No,$Is_Principal;
    public $table = 'Z_DEPOTUSER';
    public $lien ="zdepotuser";

    function __construct($id,$db=null) {
        $this->db = new DB();
        parent::__construct($this->table, $id,'Prot_No',$db);

    }

    public function __toString() {
        return "";
    }

    public function getDepotUser($Prot_No){
        return $this->getApiJson("/user&protNo=$Prot_No");
    }

    public function getPrincipalDepot($Prot_No){
        return $this->getApiJson("/getPrincipalDepot&protNo=$Prot_No");
    }
}