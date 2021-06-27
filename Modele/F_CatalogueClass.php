<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class F_CatalogueClass Extends Objet{
    //put your code here
    public $db
        ,$CL_No
		,$CL_Intitule
        ,$CL_Code
        ,$CL_Stock
        ,$CL_NoParent
        ,$CL_Niveau
		,$cbMarq;
    public $lien = 'fcatalogue';
    public $table = 'F_Catalogue';

    function __construct($id,$db=null) {
        parent::__construct($this->table, $id,'CL_No',$db);
        $this->data = $this->getApiJson("/clNo=$id");
        if(sizeof($this->data)>0) {
            $this->CL_No = $this->data[0]->CL_No ;
            $this->CL_Intitule = $this->data[0]->CL_Intitule ;
            $this->CL_Code = $this->data[0]->CL_Code ;
            $this->CL_Stock = $this->data[0]->CL_Stock ;
            $this->CL_NoParent = $this->data[0]->CL_NoParent ;
            $this->CL_Niveau = $this->data[0]->CL_Niveau ;
            $this->cbMarq = $this->data[0]->cbMarq ;
        }
    }

    public function getCatalogue($clNiv){
        return $this->getApiJson("/getCatalogue&clNiv=$clNiv");
    }

    public function getCatalogueChildren($clNiv,$clNoParent){
        return $this->getApiJson("/getCatalogueChildren&clNiv=$clNiv&clNoParent=$clNoParent");
    }

    public function getCatalogueByCL($clNiv,$clNoParent){
        return $this->getApiJson("/getCatalogueByCL&clNiveau=$clNiv&clNoParent=$clNoParent");
    }

    public function getLastCatalogue(){
        return $this->getApiJson("/getLastCatalogue");
    }

    public function insertFCatalogue($clIntitule,$clNoParent,$clNiveau,$cbCreateur){
        return $this->getApiJson("/insertFCatalogue&clIntitule=$clIntitule&clNoParent=$clNoParent&clNiveau=$clNiveau&cbCreateur=$cbCreateur");
    }

    public function deleteFCatalogue($clNo){
        return $this->getApiJson("/deleteFCatalogue&clNo=$clNo");
    }
}