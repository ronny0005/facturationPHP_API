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

    function __construct($arRef,$acCategorie,$db=null)
    {
        $this->db = new DB();
        $query = "SELECT cbMarq 
                  FROM F_ARTCLIENT
                  WHERE AR_Ref = '$arRef' AND AC_Categorie = $acCategorie";
        $result= $this->db->query($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
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

    public function insertFArtClient($AR_Ref,$ncat,$AR_PrixTTC,$AC_PrixTTC,$AC_Coef){
        $this->AR_Ref=$AR_Ref;
        $this->AC_Categorie=$ncat;
        $this->AC_Coef = $AC_Coef;
        $this->AC_PrixVen=$AR_PrixTTC;
        $this->AC_PrixTTC=$AC_PrixTTC;
        $this->insertIntoFArtClient();
    }

    public function insertIntoFArtClient(){
        $query= "
        DECLARE @arRef NVARCHAR(50) = '{$this->AR_Ref}'
        DECLARE @acPrixTTC FLOAT = {$this->AC_PrixTTC}
        DECLARE @acCategorie FLOAT = {$this->AC_Categorie}
        DECLARE @acPrixVen FLOAT = {$this->AC_PrixVen}
        DECLARE @acCoef FLOAT = {$this->AC_Coef}
        DECLARE @acRemise FLOAT = {$this->AC_Remise};
        
        IF (SELECT TOP 1 1 FROM F_ARTCLIENT WHERE AR_Ref = @arRef AND AC_Categorie = @acCategorie) = 1
            UPDATE F_ARTCLIENT SET  AC_PrixVen = @acPrixVen
                                        , AC_PrixTTC= @acPrixTTC 
                                        , AC_Coef= @acCoef
                                        , AC_Remise= @acRemise 
                    WHERE AR_Ref=@arRef AND AC_Categorie=@acCategorie
        ELSE
            INSERT INTO [dbo].[F_ARTCLIENT]
                        ([AR_Ref],[AC_Categorie],[AC_PrixVen],[AC_Coef]
                        ,[AC_PrixTTC],[AC_Arrondi],[AC_QteMont],[EG_Champ]
                        ,[AC_PrixDev],[AC_Devise],[CT_Num],[AC_Remise]
                        ,[AC_Calcul],[AC_TypeRem],[AC_RefClient],[AC_CoefNouv]
                        ,[AC_PrixVenNouv],[AC_PrixDevNouv],[AC_RemiseNouv],[AC_DateApplication]
                        ,[cbProt],[cbCreateur],[cbModification],[cbReplication],[cbFlag])
                  VALUES
                        (/*AR_Ref, varchar(19),*/@arRef,/*AC_Categorie*/@acCategorie,/*AC_PrixVen*/@acPrixVen,/*AC_Coef*/@acCoef
                        ,/*AC_PrixTTC*/@acPrixTTC,/*AC_Arrondi*/0,/*AC_QteMont*/0,/*EG_Champ*/0
                        ,/*AC_PrixDev*/0,/*AC_Devise*/0,/*CT_Num*/NULL,/*AC_Remise*/@acRemise
                        ,/*AC_Calcul*/0,/*AC_TypeRem*/0,/*AC_RefClient*/'',/*AC_CoefNouv*/0
                        ,/*AC_PrixVenNouv*/0,/*AC_PrixDevNouv*/0,/*AC_RemiseNouv*/0,/*AC_DateApplication*/'1900-01-01'
                        ,/*cbProt*/0,/*cbCreateur, char(4),*/'AND',/*cbModification*/GETDATE(),/*cbReplication*/0,/*cbFlag*/0)
             ";
        $this->db->query($query);
    }

    public function __toString() {
        return "";
    }

}