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
    public function __toString() {
        return "";
    }

}