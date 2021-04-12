<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class CompteaClass Extends Objet{
    //put your code here
    public      $db,$CA_Num,$CA_Intitule,$CA_Type,$N_Analytique
                ,$cbMarq,$cbCreateur,$cbModification;

    public $table = 'dbo.F_COMPTEA';

    function __construct($id,$mode="all",$db=null)
    {
        parent::__construct($this->table, $id, 'CA_Num', $db);
        if ($id == NULL) {
            $this->CA_Num = "";
            $this->CA_Intitule = "";
            $this->CA_Type = "";
            $this->N_Analytique = "";
        } else
            if (sizeof($this->data) > 0) {
                $this->CA_Num = $this->data[0]->CA_Num;
                $this->CA_Intitule = $this->data[0]->CA_Intitule;
                $this->CA_Type = $this->data[0]->CA_Type;
                $this->N_Analytique = $this->data[0]->N_Analytique;
                $this->cbMarq = $this->data[0]->cbMarq;
                $this->cbCreateur = $this->data[0]->cbCreateur;
                $this->cbModification = $this->data[0]->cbModification;
            }
    }

    public function maj_comptea(){
        parent::maj(CA_Num , $this->CA_Num);
        parent::maj(CA_Intitule , $this->CA_Intitule);
        parent::maj(CA_Type , $this->CA_Type);
        parent::maj(N_Analytique , $this->N_Analytique);
        parent::maj(cbMarq , $this->cbMarq);
        parent::maj(cbCreateur , $this->userName);
        parent::maj(cbModification , $this->cbModification);
    }

    public function allSearch($intitule="",$top=0){
        $valeurSaisie =str_replace(" ","%",$intitule);
        $value = "";
        if($top!=0)
            $value = "TOP $top";
        $query = "SELECT  $value CA_Num
                          ,CA_Intitule
                          ,CA_type as id
                          ,N_Analytique
                          ,CONCAT(CONCAT(CA_Num,' - '),CA_Intitule) as text
                          ,CONCAT(CONCAT(CA_Num,' - '),CA_Intitule) as value
                  FROM $this->table
                  WHERE CA_Type=0
                  AND CONCAT(CONCAT(CA_Num,' - '),CA_Intitule) LIKE '%{$valeurSaisie}%'";
        $result= $this->db->query($query);
        $this->list = Array();
        $this->list = $result->fetchAll(PDO::FETCH_OBJ);
        return $this->list;
    }


    public function __toString() {
        return "";
    }
}
