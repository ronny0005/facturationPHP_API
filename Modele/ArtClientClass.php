<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class ArtClientClass Extends Objet{
    //put your code here
    public $db,$AR_Ref
    ,$AC_Categorie
    ,$AC_PrixVen
    ,$AC_Coef
    ,$AC_PrixTTC
    ,$AC_Arrondi
    ,$AC_QteMont
    ,$EG_Champ
    ,$AC_PrixDev
    ,$AC_Devise
    ,$CT_Num
    ,$AC_Remise
    ,$AC_Calcul
    ,$AC_TypeRem
    ,$AC_RefClient
    ,$AC_CoefNouv
    ,$AC_PrixVenNouv
    ,$AC_PrixDevNouv
    ,$AC_RemiseNouv
    ,$AC_DateApplication
    ,$cbProt
    ,$cbMarq
    ,$cbCreateur
    ,$cbModification
    ,$cbReplication
    ,$cbFlag;
    public $table = 'F_ARTCLIENT';

    function __construct($arRef,$acCategorie)
    {
        $rows = $this->getApiJson("/getCbMarq&arRef={$this->formatString($arRef)}&acCategorie={$acCategorie}");
        if(sizeof($rows)>0) {
            parent::__construct($this->table, $rows[0]->cbMarq, 'cbMarq', $db);
            if (sizeof($this->data) > 0) {
                $this->AR_Ref = $this->data[0]->AR_Ref;
                $this->AC_Categorie = stripslashes($this->data[0]->AC_Categorie);
                $this->AC_PrixVen = $this->data[0]->AC_PrixVen;
                $this->AC_Coef = $this->data[0]->AC_Coef;
                $this->AC_PrixTTC = $this->data[0]->AC_PrixTTC;
                $this->AC_Arrondi = stripslashes($this->data[0]->AC_Arrondi);
                $this->AC_QteMont = stripslashes($this->data[0]->AC_QteMont);
                $this->EG_Champ = $this->data[0]->EG_Champ;
                $this->AC_PrixDev = $this->data[0]->AC_PrixDev;
                $this->AC_Devise = $this->data[0]->AC_Devise;
                $this->CT_Num = $this->data[0]->CT_Num;
                $this->AC_Remise = $this->data[0]->AC_Remise;
                $this->AC_Calcul = $this->data[0]->AC_Calcul;
                $this->AC_TypeRem = $this->data[0]->AC_TypeRem;
                $this->AC_RefClient = $this->data[0]->AC_RefClient;
                $this->AC_CoefNouv = $this->data[0]->AC_CoefNouv;
                $this->cbMarq = $this->data[0]->cbMarq;
            }
        }else{
            $this->AC_PrixTTC = 0;
            $this->AC_Categorie = 0;
            $this->AC_PrixVen = 0;
            $this->AC_Coef = 0;
            $this->AC_Remise = 0;
        }
    }

    public function __toString() {
        return "";
    }

}