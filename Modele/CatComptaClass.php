<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class CatComptaClass Extends Objet{
    //put your code here
    public $db,$CA_ComptaVen01
    ,$CA_ComptaVen02
    ,$CA_ComptaVen03
    ,$CA_ComptaVen04
    ,$CA_ComptaVen05
    ,$CA_ComptaVen06
    ,$CA_ComptaVen07
    ,$CA_ComptaVen08
    ,$CA_ComptaVen09
    ,$CA_ComptaVen10
    ,$CA_ComptaVen11
    ,$CA_ComptaVen12
    ,$CA_ComptaVen13
    ,$CA_ComptaVen14
    ,$CA_ComptaVen15
    ,$CA_ComptaVen16
    ,$CA_ComptaVen17
    ,$CA_ComptaVen18
    ,$CA_ComptaVen19
    ,$CA_ComptaVen20
    ,$CA_ComptaVen21
    ,$CA_ComptaVen22
    ,$CA_ComptaVen23
    ,$CA_ComptaVen24
    ,$CA_ComptaVen25
    ,$CA_ComptaVen26
    ,$CA_ComptaVen27
    ,$CA_ComptaVen28
    ,$CA_ComptaVen29
    ,$CA_ComptaVen30
    ,$CA_ComptaVen31
    ,$CA_ComptaVen32
    ,$CA_ComptaVen33
    ,$CA_ComptaVen34
    ,$CA_ComptaVen35
    ,$CA_ComptaVen36
    ,$CA_ComptaVen37
    ,$CA_ComptaVen38
    ,$CA_ComptaVen39
    ,$CA_ComptaVen40
    ,$CA_ComptaVen41
    ,$CA_ComptaVen42
    ,$CA_ComptaVen43
    ,$CA_ComptaVen44
    ,$CA_ComptaVen45
    ,$CA_ComptaVen46
    ,$CA_ComptaVen47
    ,$CA_ComptaVen48
    ,$CA_ComptaVen49
    ,$CA_ComptaVen50
    ,$CA_ComptaAch01
    ,$CA_ComptaAch02
    ,$CA_ComptaAch03
    ,$CA_ComptaAch04
    ,$CA_ComptaAch05
    ,$CA_ComptaAch06
    ,$CA_ComptaAch07
    ,$CA_ComptaAch08
    ,$CA_ComptaAch09
    ,$CA_ComptaAch10
    ,$CA_ComptaAch11
    ,$CA_ComptaAch12
    ,$CA_ComptaAch13
    ,$CA_ComptaAch14
    ,$CA_ComptaAch15
    ,$CA_ComptaAch16
    ,$CA_ComptaAch17
    ,$CA_ComptaAch18
    ,$CA_ComptaAch19
    ,$CA_ComptaAch20
    ,$CA_ComptaAch21
    ,$CA_ComptaAch22
    ,$CA_ComptaAch23
    ,$CA_ComptaAch24
    ,$CA_ComptaAch25
    ,$CA_ComptaAch26
    ,$CA_ComptaAch27
    ,$CA_ComptaAch28
    ,$CA_ComptaAch29
    ,$CA_ComptaAch30
    ,$CA_ComptaAch31
    ,$CA_ComptaAch32
    ,$CA_ComptaAch33
    ,$CA_ComptaAch34
    ,$CA_ComptaAch35
    ,$CA_ComptaAch36
    ,$CA_ComptaAch37
    ,$CA_ComptaAch38
    ,$CA_ComptaAch39
    ,$CA_ComptaAch40
    ,$CA_ComptaAch41
    ,$CA_ComptaAch42
    ,$CA_ComptaAch43
    ,$CA_ComptaAch44
    ,$CA_ComptaAch45
    ,$CA_ComptaAch46
    ,$CA_ComptaAch47
    ,$CA_ComptaAch48
    ,$CA_ComptaAch49
    ,$CA_ComptaAch50
    ,$CA_ComptaSto01
    ,$CA_ComptaSto02
    ,$CA_ComptaSto03
    ,$CA_ComptaSto04
    ,$CA_ComptaSto05
    ,$CA_ComptaSto06
    ,$CA_ComptaSto07
    ,$CA_ComptaSto08
    ,$CA_ComptaSto09
    ,$CA_ComptaSto10
    ,$CA_ComptaSto11
    ,$CA_ComptaSto12
    ,$CA_ComptaSto13
    ,$CA_ComptaSto14
    ,$CA_ComptaSto15
    ,$CA_ComptaSto16
    ,$CA_ComptaSto17
    ,$CA_ComptaSto18
    ,$CA_ComptaSto19
    ,$CA_ComptaSto20
    ,$CA_ComptaSto21
    ,$CA_ComptaSto22
    ,$CA_ComptaSto23
    ,$CA_ComptaSto24
    ,$CA_ComptaSto25
    ,$CA_ComptaSto26
    ,$CA_ComptaSto27
    ,$CA_ComptaSto28
    ,$CA_ComptaSto29
    ,$CA_ComptaSto30
    ,$CA_ComptaSto31
    ,$CA_ComptaSto32
    ,$CA_ComptaSto33
    ,$CA_ComptaSto34
    ,$CA_ComptaSto35
    ,$CA_ComptaSto36
    ,$CA_ComptaSto37
    ,$CA_ComptaSto38
    ,$CA_ComptaSto39
    ,$CA_ComptaSto40
    ,$CA_ComptaSto41
    ,$CA_ComptaSto42
    ,$CA_ComptaSto43
    ,$CA_ComptaSto44
    ,$CA_ComptaSto45
    ,$CA_ComptaSto46
    ,$CA_ComptaSto47
    ,$CA_ComptaSto48
    ,$CA_ComptaSto49
    ,$CA_ComptaSto50
    ,$cbMarq;
    public $table = 'P_CATCOMPTA';
    public $lien = 'pcatcompta';

    function __construct($id,$db=null)
    {
    }

    public function maj_cattarif(){
        parent::maj(CT_Intitule , $this->CT_Intitule);
        parent::maj(CT_PrixTTC , $this->CT_PrixTTC);
        parent::maj(cbIndice , $this->cbIndice);
    }

    public function getCatCompta() {
        return $this->getApiJson("/getCatComptaVente");
    }

    public function getCatComptaAll(){
        return $this->getApiJson("/all");
    }

    public function getCatComptaByArRef($arRef,$acpChamp,$acpType){
        return $this->getApiJson("/getCatComptaByArRef&arRef=$arRef&acpChamp=$acpChamp&acpType=$acpType");
    }

    public function getCatComptaByCodeFamille($CodeFamille,$ACP_Champ,$ACP_Type){
        return $this->getApiJson("/getCatComptaByCodeFamille&faCodeFamille=$CodeFamille&fcpType=$ACP_Champ&fcpChamp=$ACP_Type");
    }

    public function getCatComptaAchat() {
        return $this->getApiJson("/getCatComptaAchat");
    }

    public function __toString() {
        return "";
    }

}