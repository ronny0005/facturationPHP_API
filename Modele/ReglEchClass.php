<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class ReglEchClass Extends Objet{
    //put your code here
    public $db, $RG_No    ,$DR_No    ,$DO_Domaine    ,$DO_Type    ,$DO_Piece    ,$RC_Montant    ,$RG_TypeReg
    ,$cbProt    ,$cbMarq    ,$cbCreateur    ,$cbModification    ,$cbReplication    ,$cbFlag;
    public $table = 'F_DOCREGL';

    function __construct($id,$db=null)
    {
        $this->setValue();
        if (sizeof($this->data) > 0) {
            $this->RG_No = $this->data[0]->RG_No;
            $this->DR_No = $this->data[0]->DR_No;
            $this->DO_Type = $this->data[0]->DO_Type;
            $this->DO_Piece = $this->data[0]->DO_Piece;
            $this->DO_Domaine = $this->data[0]->DO_Domaine;
            $this->RC_Montant = $this->data[0]->RC_Montant;
            $this->RG_TypeReg = $this->data[0]->RG_TypeReg;
            $this->cbProt = $this->data[0]->cbProt;
            $this->cbMarq = $this->data[0]->cbMarq;
            $this->cbCreateur = $this->data[0]->cbCreateur;
            $this->cbModification = $this->data[0]->cbModification;
            $this->cbReplication = $this->data[0]->cbReplication;
            $this->cbFlag = $this->data[0]->cbFlag;
        }
    }

    function setValue(){
        $this->RG_TypeReg = 0;
        $this->cbProt = 0;
        $this->cbReplication = 0;
        $this->cbFlag = 0;
    }
}