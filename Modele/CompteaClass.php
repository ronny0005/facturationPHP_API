<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class CompteaClass Extends Objet{
    //put your code here
    public      $db,$CA_Num,$CA_Intitule,$CA_Type,$N_Analytique
    ,$CA_Classement,$CA_Raccourci,$CA_Report,$N_Analyse,$CA_Saut,$CA_Sommeil,$CA_DateCreate,$CA_Domaine,$CA_Achat,$CA_Vente
    ,$cbMarq,$cbCreateur,$cbModification;

    public $table = 'dbo.F_COMPTEA';
    public $lien = 'fcomptea';

    function __construct($id,$mode="all",$db=null)
    {
        $this->data = $this->getApiJson("/caNum=$id");
        if ($id == NULL) {
            $this->CA_Num = "";
            $this->CA_Intitule = "";
            $this->CA_Type = "";
            $this->N_Analytique = "";
        } else
            if (sizeof($this->data) > 0) {
                $this->CA_Num = $this->data[0]->CA_Num;
                $this->CA_Intitule = $this->data[0]->CA_Intitule;
                $this->CA_Type = $this->data[0]->CA_Type;
                $this->N_Analytique = $this->data[0]->N_Analytique;
                $this->cbMarq = $this->data[0]->cbMarq;
                $this->cbCreateur = $this->data[0]->cbCreateur;
                $this->cbModification = $this->data[0]->cbModification;
            }
    }

    public function maj_comptea(){
        parent::maj(CA_Num , $this->CA_Num);
        parent::maj(CA_Intitule , $this->CA_Intitule);
        parent::maj(CA_Type , $this->CA_Type);
        parent::maj(N_Analytique , $this->N_Analytique);
        parent::maj(cbMarq , $this->cbMarq);
        parent::maj(cbCreateur , $this->userName);
        parent::maj(cbModification , $this->cbModification);
    }

    public function allSearch($intitule="",$top=0){
        return $this->getApiJson("/allSeach/intitule={$this->formatString($intitule)}&top=$top");
    }

    public function insertFComptea()
    {
        $query = "INSERT INTO [F_COMPTEA]
           ([N_Analytique],[CA_Num],[CA_Intitule],[CA_Type]
           ,[CA_Classement],[CA_Raccourci],[CA_Report],[N_Analyse]
           ,[CA_Saut],[CA_Sommeil],[CA_DateCreate],[CA_Domaine]
           ,[CA_Achat],[CA_Vente],[cbProt],[cbCreateur]
           ,[cbModification],[cbReplication],[cbFlag])
     VALUES
           (/*N_Analytique*/{$this->N_Analytique},/*CA_Num*/'{$this->CA_Num}',/*CA_Intitule*/'{$this->CA_Intitule}',/*CA_Type*/{$this->CA_Type}
           ,/*CA_Classement*/'{$this->CA_Classement}',/*CA_Raccourci*/'{$this->CA_Raccourci}',/*CA_Report*/{$this->CA_Report},/*N_Analyse*/{$this->N_Analyse}
           ,/*CA_Saut*/{$this->CA_Saut},/*CA_Sommeil*/{$this->CA_Sommeil},/*CA_DateCreate*/CAST(GETDATE() AS DATE),/*CA_Domaine*/{$this->CA_Domaine}
           ,/*CA_Achat*/{$this->CA_Achat},/*CA_Vente*/{$this->CA_Vente},/*cbProt*/0,/*cbCreateur*/'{$this->userName}'
           ,/*cbModification*/CAST(GETDATE() AS DATE),/*cbReplication*/0,/*cbFlag*/0)";
    }



    public function __toString() {
        return "";
    }
}
