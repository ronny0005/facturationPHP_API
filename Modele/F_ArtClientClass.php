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
            ,$AR_Ref,$AC_Categorie,$AC_PrixVen
            ,$AC_Coef,$AC_PrixTTC,$AC_Arrondi,$AC_QteMont
            ,$EG_Champ,$AC_PrixDev,$AC_Devise,$CT_Num
            ,$AC_Remise,$AC_Calcul,$AC_TypeRem,$AC_RefClient
            ,$AC_CoefNouv,$AC_PrixVenNouv,$AC_PrixDevNouv,$AC_RemiseNouv
            ,$AC_DateApplication,$cbProt,$cbMarq,$cbCreateur
            ,$cbModification,$cbReplication,$cbFlag;
    public  $lien = 'fartclient';
    public  $table = 'F_ArtClient';

    function __construct($id,$db=null) {
        parent::__construct($this->table, $id,'cbMarq',$db);
    }

    public function selectFArtClient($arRef,$acCategorie){
        return $this->getApiJson("/selectFArtClient&arRef={$this->formatString($arRef)}&acCategorie={$acCategorie}");
    }

    public function updateFArtClient($acPrixVen,$acCoef,$arRef,$acCategorie,$acPrixTTC){
        $this->getApiExecute("/updateFArtClient&arRef={$this->formatString($arRef)}&acCategorie=$acCategorie&acPrixTTC=$acPrixTTC&acPrixVen=$acPrixVen&acCoef=$acCoef");
    }
}