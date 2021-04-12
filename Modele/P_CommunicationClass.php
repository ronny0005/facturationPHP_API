<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class P_CommunicationClass Extends Objet{
    //put your code here
    public $db
            ,$N_CatTarif
      ,$N_CatCompta
      ,$CO_SoucheSite
      ,$DE_No
      ,$cbMarq;
    public $table = 'P_Communication';

    function __construct($db=null) {
        parent::__construct($this->table, 1,'cbMarq',$db);
        if(sizeof($this->data)>0) {
            $this->N_CatCompta = $this->data[0]->N_CatCompta;
            $this->N_CatTarif = $this->data[0]->N_CatTarif;
            $this->CO_SoucheSite = $this->data[0]->CO_SoucheSite;
            $this->DE_No = $this->data[0]->DE_No;
        }
    }

    public function __toString() {
        return "";
    }

}