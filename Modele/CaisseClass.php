<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class CaisseClass Extends Objet{
    //put your code here
    public $db,$CA_No,$CA_Intitule,$DE_No,$CO_No,$CO_NoCaissier,$CT_Num,$JO_Num,$CA_Souche,$cbCreateur;
    public $table = 'F_CAISSE';
    public $lien ="fcaisse";

    function __construct($id,$db=null)
    {
        $this->data = $this->getApiJson("/$id");
        if($id!=0)
        if (sizeof($this->data) > 0) {
            $this->CA_No = $this->data[0]->CA_No;
            $this->CA_Intitule = stripslashes($this->data[0]->CA_Intitule);
            $this->DE_No = $this->data[0]->DE_No;
            $this->CO_No = $this->data[0]->CO_No;
            $this->CO_NoCaissier = $this->data[0]->CO_NoCaissier;
            $this->CT_Num = stripslashes($this->data[0]->CT_Num);
            $this->JO_Num = stripslashes($this->data[0]->JO_Num);
            $this->CA_Souche = $this->data[0]->CA_Souche;
            $this->cbCreateur = $this->data[0]->cbCreateur;

        }
    }

    public function insertDepotCaisse($DE_No){
        $query = "INSERT INTO Z_DEPOTCAISSE VALUES ($DE_No,{$this->CA_No})";
        $this->db->query($query);
    }

    public function maj_caisse(){
        parent::maj('CA_Intitule', $this->CA_Intitule);
        parent::maj('DE_No', $this->DE_No);
        parent::maj('CO_No', $this->CO_No);
        parent::maj('CO_NoCaissier', $this->CO_NoCaissier);
        parent::maj('CT_Num', $this->CT_Num);
        parent::maj('JO_Num', $this->JO_Num);
        parent::maj('CA_Souche', $this->CA_Souche);
        parent::maj('cbCreateur', $this->userName);
        parent::majcbModification();

    }

    public function insertCaisse(){
        $query = "
                  BEGIN 
                  SET NOCOUNT ON;
                  INSERT INTO [dbo].[F_CAISSE]
                ([CA_No],[CA_Intitule],[DE_No],[CO_No]
                ,[cbCO_No],[CO_NoCaissier],[cbCO_NoCaissier],[CT_Num]
                ,[JO_Num],[CA_IdentifCaissier],[CA_DateCreation],[N_Comptoir]
                ,[N_Clavier],[CA_LignesAfficheur],[CA_ColonnesAfficheur],[CA_ImpTicket]
                ,[CA_SaisieVendeur],[CA_Souche],[cbProt],[cbCreateur]
                ,[cbModification],[cbReplication],[cbFlag])
          VALUES
                (/*CA_No*/ISNULL((SELECT MAX(CA_No) FROM F_CAISSE)+1,0),/*CA_Intitule*/'{$this->CA_Intitule}',/*DE_No*/1
                ,/*CO_No*/0,/*cbCO_No*/NULL,/*CO_NoCaissier*/{$this->CO_NoCaissier}
                ,/*cbCO_NoCaissier*/(SELECT CASE WHEN {$this->CO_NoCaissier}=0 THEN NULL ELSE {$this->CO_NoCaissier} END)
                ,/*CT_Num*/(SELECT TOP 1 CT_Num
                            FROM F_COMPTET
                            WHERE CT_Num LIKE '%DIVERS%'
                            AND CT_Type=0),/*JO_Num*/'{$this->JO_Num}',/*CA_IdentifCaissier*/0
                ,/*CA_DateCreation*/CAST(GETDATE() AS DATE),/*N_Comptoir*/1,/*N_Clavier*/1
                ,/*CA_LignesAfficheur*/0,/*CA_ColonnesAfficheur*/0,/*CA_ImpTicket*/0
                ,/*CA_SaisieVendeur*/0,/*CA_Souche*/0,/*cbProt*/0
                ,/*cbCreateur*/'AND',/*cbModification*/CAST(GETDATE() AS DATE),/*cbReplication*/0,/*cbFlag*/0)
                SELECT *
                FROM F_CAISSE WHERE cbMarq =@@IDENTITY; 
                END
                ";
        $result=$this->db->query($query);
        $row = $result->fetchAll(PDO::FETCH_OBJ);
        $this->majcbModification();
        return $row[0];
    }

    public function supprDepotCaisse()
    {
        $query = "DELETE FROM Z_DEPOTCAISSE WHERE CA_No={$this->CA_No}";
        $this->db->query($query);
    }

    public function clotureCaisse($dateCloture,$caisseDebut,$caisseFin,$ProtNo,$typeCloture)
    {
        $this->getApiExecute("/clotureCaisse/dateCloture=$dateCloture&caisseDebut=$caisseDebut&caisseFin=$caisseFin&protNo=$ProtNo&typeCloture=$typeCloture");
    }

    public function listeCaisseShort(){
        return $this->getApiJson("/listeCaisseShort");
    }

    public function getCaisseProtNo($protNo){
        $query="
                    SELECT	ISNULL(fca.CA_No,0) CA_No
                            ,MAX(CASE WHEN fco.CO_No IS NOT NULL THEN 2
                                WHEN zdu.IsPrincipal = 1 THEN 1 ELSE 0 END) IsPrincipal
                            ,ISNULL(fca.CA_Intitule,'') CA_Intitule
                    FROM F_CAISSE fca
                    LEFT JOIN Z_DEPOTCAISSE zde 
                        ON fca.CA_No=zde.CA_No
                    LEFT JOIN Z_DEPOTUSER zdu 
                        ON zde.DE_No=zdu.DE_No
                    LEFT JOIN F_COMPTET fct
                        ON fct.CT_Num = fca.CT_Num
                    LEFT JOIN F_PROTECTIONCIAL fpr
                        ON fpr.PROT_No = zdu.Prot_No
                    LEFT JOIN F_COLLABORATEUR fco 
                        ON fco.CO_Nom = fpr.PROT_User
                        AND fco.CO_No = fca.CO_NoCaissier
                    WHERE	zdu.Prot_No=$protNo
                    
                    GROUP BY fca.CA_No
                            ,fca.CA_Intitule;";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getCaisseDepot($prot_no){
        return $this->getApiJson("/getCaisseDepot/$prot_no");
    }

    public function getCaNum(){
        return $this->getApiJson("/getCaNum&caNo={$this->CA_No}");
    }

    public function getCaissierByCaisse($ca_no)
    {
        return $this->getApiJson("/getCaissierByCaisse&caNo=$ca_no");
    }

    public function getCaisseByCA_No($ca_no) {
        return $this->getApiJson("/getCaisseByCA_No&caNo=$ca_no");
    }

    public function __toString() {
        return "";
    }

    public function getCaisseUser($Prot_No,$depotExclude,$searchTerm,$principal=1){
        $query = "  
                    SELECT A.CA_No,CA_Intitule
                    FROM Z_DEPOTCAISSE A
                    INNER JOIN F_CAISSE Ca ON A.CA_No=Ca.CA_No
                    INNER JOIN (SELECT DE_No FROM(
                    SELECT  A.DE_No
                            ,DE_Intitule
                            ,DE_Intitule as value
                            ,IsPrincipal
                    FROM    F_DEPOT A
                    INNER JOIN Z_DEPOTUSER B ON A.DE_No = B.DE_No
                    WHERE   Prot_No=$Prot_No
                    AND ($depotExclude=-1 OR A.DE_No<>$depotExclude)
                    AND DE_Intitule like '%{$searchTerm}%'
                    GROUP BY A.DE_No
                            ,DE_Intitule
                            ,IsPrincipal) A WHERE $principal=-1 OR IsPrincipal=$principal) B ON A.DE_No=B.DE_No
                    GROUP BY A.CA_No,CA_Intitule";
        $result= $this->db->query($query);
        $this->list = Array();
        $this->list = $result->fetchAll(PDO::FETCH_OBJ);
        return $this->list;
    }


    public function getCaisseByIntitule($intitule,$depotExclude=-1){
        $query="DECLARE @intitule NVACHAR(100) = '$intitule'
                DECLARE @depotExclude INT = $depotExclude
                SELECT  CA_No
                        ,CA_Intitule
                        ,CA_Intitule as value
                FROM F_CAISSE
                WHERE CONCAT(CONCAT(CA_No,' - '),CA_Intitule) LIKE CONCAT(CONCAT('%',@intitule),'%')
                AND (@depotExclude = -1 OR DE_No<>@depotExclude)";
        $result= $this->db->query($query);
        $rows = array();
        $value = $result->fetchAll(PDO::FETCH_OBJ);
        foreach ($value as $val){
            $rows[] = array("id" => $val->CA_No , "text" => $val->CA_Intitule,"CA_Intitule" => $val->CA_Intitule,"CA_No" => $val->CA_No , "value" => $val->CA_Intitule );
        }
        return $rows;
    }


}