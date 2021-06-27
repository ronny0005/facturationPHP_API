<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class DocReglClass Extends Objet{
    //put your code here
    public $db,$DR_No,$DO_Domaine,$DO_Type
    ,$DO_Piece,$DR_TypeRegl,$DR_Date,$DR_Libelle,$DR_Pourcent,$DR_Montant,$DR_MontantDev
    ,$DR_Equil,$EC_No,$DR_Regle,$N_Reglement,$cbProt,$cbMarq,$cbCreateur,$cbModification
    ,$cbReplication,$cbFlag;
    public $table = 'F_DOCREGL';

    function __construct($id,$db=null)
    {
        $this->setValue();
        if (sizeof($this->data) > 0) {
            $this->DR_No = $this->data[0]->DR_No;
            $this->DO_Domaine = $this->data[0]->DO_Domaine;
            $this->DO_Type = $this->data[0]->DO_Type;
            $this->DO_Piece = $this->data[0]->DO_Piece;
            $this->DR_TypeRegl = $this->data[0]->DR_TypeRegl;
            $this->DR_Date = $this->data[0]->DR_Date;
            $this->DR_Libelle = $this->data[0]->DR_Libelle;
            $this->DR_Pourcent = $this->data[0]->DR_Pourcent;
            $this->DR_Montant = $this->data[0]->DR_Montant;
            $this->DR_MontantDev = $this->data[0]->DR_MontantDev;
            $this->DR_Equil = $this->data[0]->DR_Equil;
            $this->EC_No = $this->data[0]->EC_No;
            $this->DR_Regle = $this->data[0]->DR_Regle;
            $this->N_Reglement = $this->data[0]->N_Reglement;
            $this->cbProt = $this->data[0]->cbProt;
            $this->cbMarq = $this->data[0]->cbMarq;
            $this->cbCreateur = $this->data[0]->cbCreateur;
            $this->cbModification = $this->data[0]->cbModification;
            $this->cbReplication = $this->data[0]->cbReplication;
            $this->cbFlag = $this->data[0]->cbFlag;
        }
    }

    function setValue(){
        $this->DR_TypeRegl = 2;
        $this->DR_Libelle = "";
        $this->DR_Pourcent = 0;
        $this->DR_Montant = 0;
        $this->DR_MontantDev = 0;
        $this->DR_Equil = 1;
        $this->EC_No = 0;
        $this->cbProt = 0;
        $this->cbReplication = 0;
        $this->cbFlag = 0;
    }
}