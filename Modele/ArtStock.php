<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class ArtStockClass Extends Objet{
    //put your code here
    public $db,$AR_Ref
    ,$cbAR_Ref
    ,$DE_No
    ,$AS_QteMini
    ,$AS_QteMaxi
    ,$AS_MontSto
    ,$AS_QteSto
    ,$AS_QteRes
    ,$AS_QteCom
    ,$AS_Principal
    ,$AS_QteResCM
    ,$AS_QteComCM
    ,$AS_QtePrepa
    ,$DP_NoPrincipal
    ,$cbDP_NoPrincipal
    ,$DP_NoControle
    ,$cbDP_NoControle
    ,$AS_QteAControler
    ,$cbProt
    ,$cbMarq
    ,$cbCreateur
    ,$cbModification
    ,$cbReplication
    ,$cbFlag;
    public $table = 'F_ARTSTOCK';

    function __construct()
    {
//        parent::__construct($this->table, $id, 'CA_No');
    }

    public function isStock($DE_No,$AR_Ref){
        $query = "SELECT	[AS_QteSto] = ISNULL(AS_QteSto,0)
							,[AS_MontSto] = ISNULL(AS_MontSto,0)
							,[AS_QteMini] = ISNULL(AS_QteMini,0)
							,[AS_QteMaxi] = ISNULL(AS_QteMaxi,0) 
				  FROM F_ARTSTOCK WHERE DE_No = $DE_No AND cbAR_Ref = '$AR_Ref'";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }
    public function __toString() {
        return "";
    }

}