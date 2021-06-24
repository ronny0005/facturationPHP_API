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
        $this->db = new DB();
        parent::__construct($this->table, $id,'DE_No',$db);
        if(sizeof($this->data)>0) {
            $this->list = $this->data;
        }
    }

    public function maj_depotcaisse(){
//        parent::maj(DE_Intitule, $this->DE_Intitule,'DE_No',$this->DE_No);
//        parent::maj(DE_Complement, $this->DE_Complement,'DE_No',$this->DE_No);
    }

    public function getDepotCaisseSelect($caisse){
        $query = "SELECT  C.DE_No,DE_Intitule,CASE WHEN $caisse=CA_No THEN 1 ELSE 0 END Valide_Caisse
                    FROM F_DEPOT C
                    LEFT JOIN Z_DEPOTCAISSE D ON C.DE_No=D.DE_No";
        $result= $this->db->query($query);
        $this->list = array();
        foreach ($result->fetchAll(PDO::FETCH_OBJ) as $resultat)
            array_push($this->list,$resultat);
        return $this->list;
    }

    public function __toString() {
        return "";
    }

}