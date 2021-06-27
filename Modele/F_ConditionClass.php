<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class F_ArtClientClass Extends Objet{
    //put your code here
    public  $db
            ,$AR_Ref,$CO_No,$EC_Enumere
            ,$EC_Quantite,$CO_Ref,$CO_CodeBarre
            ,$CO_Principal,$cbProt,$cbMarq
            ,$cbCreateur,$cbModification,$cbReplication,$cbFlag;
    public  $lien = 'fcondition';
    public  $table = 'F_CONDITION';

    function __construct($id,$db=null) {
        parent::__construct($this->table, $id,'cbMarq',$db);
    }

    public function selectFCondition($arRef,$ecEnumere){
        return $this->getApiJson("/selectFCondition&arRef={$this->formatString($arRef)}&ecEnumere={$ecEnumere}");
    }

    public function updateFArtClient($acPrixVen,$acCoef,$arRef,$acCategorie,$acPrixTTC){
        $this->getApiExecute("/updateFArtClient&arRef={$this->formatString($arRef)}&acCategorie=$acCategorie&acPrixTTC=$acPrixTTC&acPrixVen=$acPrixVen&acCoef=$acCoef");
    }
}