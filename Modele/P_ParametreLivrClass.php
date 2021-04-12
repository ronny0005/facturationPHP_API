<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class P_ParametreLivrClass Extends Objet{
    //put your code here
    public $db
            ,$PL_Priorite1
      ,$PL_Priorite2
      ,$PL_Priorite3
      ,$PL_Duree
      ,$PL_TypeDuree
      ,$PL_Reliquat
      ,$PL_Quantite
      ,$PL_Generation
      ,$PL_Statut
      ,$cbMarq;
    public $table = 'P_ParametreLivr';

    function __construct($id,$db=null) {
        parent::__construct($this->table, $id,'cbMarq',$db);
        if(sizeof($this->data)>0) {
            $this->PL_Priorite1 = $this->data[0]->PL_Priorite1;
            $this->PL_Priorite2 = $this->data[0]->PL_Priorite2;
            $this->PL_Priorite3 = $this->data[0]->PL_Priorite3;
            $this->PL_Duree = $this->data[0]->PL_Duree;
            $this->PL_TypeDuree = $this->data[0]->PL_TypeDuree;
            $this->PL_Reliquat = $this->data[0]->PL_Reliquat;
            $this->PL_Quantite = $this->data[0]->PL_Quantite;
            $this->PL_Generation = $this->data[0]->PL_Generation;
            $this->PL_Statut = $this->data[0]->PL_Statut;
            $this->cbMarq = $this->data[0]->cbMarq;
        }
    }

    public function __toString() {
        return "";
    }

}