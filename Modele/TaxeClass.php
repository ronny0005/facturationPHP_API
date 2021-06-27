<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class TaxeClass Extends Objet{
    //put your code here
    public $db,$TA_Intitule
    ,$TA_TTaux
    ,$TA_Taux
    ,$TA_Type
    ,$CG_Num
    ,$TA_No
    ,$TA_Code
    ,$TA_NP
    ,$TA_Sens
    ,$TA_Provenance
    ,$TA_Regroup
    ,$TA_Assujet
    ,$TA_GrilleBase
    ,$TA_GrilleTaxe
    ,$cbMarq
    ,$cbCreateur
    ,$cbModification;

    public $table = 'F_TAXE';

    function __construct($id,$db=null)
    {
        $this->data = $this->getApiJson("/taNo={$id}");
        if (sizeof($this->data) > 0) {
            $this->TA_Intitule = $this->data[0]->TA_Intitule;
            $this->TA_TTaux = $this->data[0]->TA_TTaux;
            $this->TA_Taux = $this->data[0]->TA_Taux;
            $this->TA_Type = $this->data[0]->TA_Type;
            $this->CG_Num = $this->data[0]->CG_Num;
            $this->TA_No = $this->data[0]->TA_No;
            $this->TA_Code = $this->data[0]->TA_Code;
            $this->TA_NP = $this->data[0]->TA_NP;
            $this->TA_Sens = $this->data[0]->TA_Sens;
            $this->TA_Provenance = $this->data[0]->TA_Provenance;
            $this->TA_Regroup = $this->data[0]->TA_Regroup;
            $this->TA_Assujet = $this->data[0]->TA_Assujet;
            $this->TA_GrilleBase = $this->data[0]->TA_GrilleBase;
            $this->TA_GrilleTaxe = $this->data[0]->TA_GrilleTaxe;
            $this->cbMarq = $this->data[0]->cbMarq;
            $this->cbCreateur = $this->data[0]->cbCreateur;
            $this->cbModification = $this->data[0]->cbModification;
        }
    }

    public function maj_taxe(){
        parent::maj(TA_Intitule , $this->TA_Intitule);
        parent::maj(TA_TTaux , $this->TA_TTaux);
        parent::maj(TA_Taux , $this->TA_Taux);
        parent::maj(TA_Type , $this->TA_Type);
        parent::maj(CG_Num , $this->CG_Num);
        parent::maj(TA_No , $this->TA_No);
        parent::maj(TA_Code , $this->TA_Code);
        parent::maj(TA_NP , $this->TA_NP);
        parent::maj(TA_Sens , $this->TA_Sens);
        parent::maj(TA_Provenance , $this->TA_Provenance);
        parent::maj(TA_Regroup , $this->TA_Regroup);
        parent::maj(TA_Assujet , $this->TA_Assujet);
        parent::maj(TA_GrilleBase , $this->TA_GrilleBase);
        parent::maj(TA_GrilleTaxe , $this->TA_GrilleTaxe);
        parent::maj(cbMarq , $this->cbMarq);
        parent::maj(cbCreateur , $this->userName);
        parent::maj(cbModification , $this->cbModification);
    }

    public function taxeFromTaCode($taCode){
        return $this->getApiJson("/taCode={$taCode}");
    }

    public function taxeAttache($cgNumTaxe,$cgNumAssocie){
        return $this->getApiJson("/taxeAttache&cgNumTaxe={$cgNumTaxe}&cgNumAssocie={$cgNumAssocie}");
    }

    public function __toString() {
        return "";
    }

}