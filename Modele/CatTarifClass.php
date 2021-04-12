<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class CatTarifClass Extends Objet{
    //put your code here
    public $db,$CT_Intitule
    ,$CT_PrixTTC
    ,$cbIndice
    ,$cbMarq;
    public $table = 'P_CATTARIF';
    public $lien = 'pcattarif';

    function __construct($id,$db=null)
    {

    }

    public function maj_cattarif(){
        parent::maj(CT_Intitule , $this->CT_Intitule);
        parent::maj(CT_PrixTTC , $this->CT_PrixTTC);
        parent::maj(cbIndice , $this->cbIndice);
        parent::maj(cbMarq , $this->cbMarq);
    }

    public function allCatTarif() {
        return $this->getApiJson("/all");
    }

    public function allCatTarifRemise() {
        $query = "SELECT CT_Intitule,RIGHT(CONCAT('0',cbIndice),2)cbIndice FROM P_CATTARIF where CT_Intitule <>''";
        $result= $this->db->query($query);
        $this->list = array();
        foreach ($result->fetchAll(PDO::FETCH_OBJ) as $resultat)
        {
            array_push($this->list,new CatTarifClass($resultat->cbIndice));
        }
        return $this->list;
    }


    public function __toString() {
        return "";
    }

}