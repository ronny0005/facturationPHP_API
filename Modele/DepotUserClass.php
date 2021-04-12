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
        parent::__construct($this->table, $id,'Prot_No',$db);

    }

    public function __toString() {
        return "";
    }

    public function getDepotPrincipal($Prot_No){
        $query= "   SELECT	A.DE_No
                            ,DE_Intitule
                            ,IsPrincipal = ISNULL(D.IsPrincipal,0)
                    FROM	F_DEPOT A
                    LEFT JOIN Z_DEPOTUSER D 
                        ON A.DE_No=D.DE_No
                    WHERE	IsPrincipal = 1
                    AND     PROT_No = $Prot_No
                    GROUP BY A.DE_No
                             ,DE_Intitule
                             ,IsPrincipal";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }
    public function getDepotUser($Prot_No){
        return $this->getApiJson("/user&protNo=$Prot_No");
    }

    public function getPrincipalDepot($Prot_No){
        return $this->getApiJson("/getPrincipalDepot&protNo=$Prot_No");
    }
}