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
        parent::maj(cbMarq , $this->cbMarq);
    }

    public function getCatCompta() {
        return $this->getApiJson("/getCatComptaVente");
    }

    public function getCatComptaAll(){
        $query =  "select  row_number() over (order by u.subject) as idcompta,u.marks,1 AS Type
                from P_CATCOMPTA
                unpivot
                (
                  marks
                  for subject in (CA_ComptaAch01, CA_ComptaAch02,CA_ComptaAch03,CA_ComptaAch04,CA_ComptaAch05,CA_ComptaAch06,CA_ComptaAch07,CA_ComptaAch08,CA_ComptaAch09,CA_ComptaAch10,CA_ComptaAch11,CA_ComptaAch12,CA_ComptaAch13,CA_ComptaAch14,CA_ComptaAch15,CA_ComptaAch16,CA_ComptaAch17,CA_ComptaAch18,CA_ComptaAch19,CA_ComptaAch20,CA_ComptaAch21,CA_ComptaAch22)
                ) u WHERE marks<>''
                union
                select  row_number() over (order by u.subject) as idcompta,u.marks,0 AS Type
                from P_CATCOMPTA
                unpivot
                (
                  marks
                  for subject in (CA_ComptaVen01, CA_ComptaVen02,CA_ComptaVen03,CA_ComptaVen04,CA_ComptaVen05,CA_ComptaVen06,CA_ComptaVen07,CA_ComptaVen08,CA_ComptaVen09,CA_ComptaVen10,CA_ComptaVen11,CA_ComptaVen12,CA_ComptaVen13,CA_ComptaVen14,CA_ComptaVen15,CA_ComptaVen16,CA_ComptaVen17,CA_ComptaVen18,CA_ComptaVen19,CA_ComptaVen20,CA_ComptaVen21,CA_ComptaVen22)
                ) u
                WHERE marks<>''
                ";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getCatComptaByArRef($AR_Ref,$ACP_Champ,$ACP_Type){
        $query =  "SELECT ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.ACP_Champ ELSE B.ACP_Champ END,0) ACP_Champ,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.CG_Num ELSE B.CG_Num END,'') CG_Num,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.CG_Intitule ELSE B.CG_Intitule END,'') CG_Intitule,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.CG_NumA ELSE B.CG_NumA END,'') CG_NumA,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.CG_IntituleA ELSE B.CG_IntituleA END,'') CG_IntituleA,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.Taxe1 ELSE B.Taxe1 END,'') Taxe1,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.TA_Intitule1 ELSE B.TA_Intitule1 END,'') TA_Intitule1,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.Taxe2 ELSE B.Taxe2 END,'') Taxe2,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.TA_Intitule2 ELSE B.TA_Intitule2 END,'') TA_Intitule2,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.Taxe3 ELSE B.Taxe3 END,'') Taxe3,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.TA_Intitule3 ELSE B.TA_Intitule3 END,'') TA_Intitule3,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.TA_Taux1 ELSE B.TA_Taux1 END,0) TA_Taux1,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.TA_Taux2 ELSE B.TA_Taux2 END,0) TA_Taux2,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.TA_Taux3 ELSE B.TA_Taux3 END,0) TA_Taux3
                FROM (
                SELECT 	A.cbFA_CodeFamille,FCP_Type ACP_Type,AR_Ref,FCP_Champ ACP_Champ,FCP_ComptaCPT_CompteG CG_Num
						,CG.CG_Intitule,FCP_ComptaCPT_CompteA CG_NumA,CA.CG_Intitule CG_IntituleA,FCP_ComptaCPT_Taxe1 Taxe1,TU.TA_Intitule TA_Intitule1,TU.TA_Taux TA_Taux1
                ,FCP_ComptaCPT_Taxe2 Taxe2,TD.TA_Intitule TA_Intitule2,TD.TA_Taux TA_Taux2,FCP_ComptaCPT_Taxe3 Taxe3,TT.TA_Intitule TA_Intitule3,TT.TA_Taux TA_Taux3
                FROM 	F_FAMCOMPTA A 
                INNER JOIN F_ARTICLE AR 
					ON AR.cbFA_CodeFamille = A.cbFA_CodeFamille
                LEFT JOIN F_TAXE TU 
					ON A.FCP_ComptaCPT_Taxe1 = TU.TA_Code
                LEFT JOIN F_TAXE TD 
					ON A.FCP_ComptaCPT_Taxe2 = TD.TA_Code
                LEFT JOIN F_TAXE TT 
					ON A.FCP_ComptaCPT_Taxe3 = TT.TA_Code
                LEFT JOIN F_COMPTEG CG 
					ON A.FCP_ComptaCPT_CompteG = CG.CG_Num
                LEFT JOIN F_COMPTEG CA 
					ON A.FCP_ComptaCPT_CompteA = CA.CG_Num) A
					LEFT JOIN (	SELECT 	A.cbAR_Ref,A.AR_Ref,ACP_Type,cbFA_CodeFamille,ACP_Champ,ACP_ComptaCPT_CompteG CG_Num,CG.CG_Intitule
										,ACP_ComptaCPT_CompteA CG_NumA,CA.CG_Intitule CG_IntituleA,ACP_ComptaCPT_Taxe1 Taxe1,TU.TA_Intitule TA_Intitule1,TU.TA_Taux TA_Taux1
										,ACP_ComptaCPT_Taxe2 Taxe2,TD.TA_Intitule TA_Intitule2,TD.TA_Taux TA_Taux2,ACP_ComptaCPT_Taxe3 Taxe3,TT.TA_Intitule TA_Intitule3,TT.TA_Taux TA_Taux3
								FROM 	F_ARTCOMPTA A 
								INNER JOIN F_ARTICLE AR 
									ON AR.cbAR_Ref = A.cbAR_Ref
								LEFT JOIN F_TAXE TU 
									ON A.ACP_ComptaCPT_Taxe1 = TU.TA_Code
								LEFT JOIN F_TAXE TD 
									ON A.ACP_ComptaCPT_Taxe2 = TD.TA_Code
								LEFT JOIN F_TAXE TT 
									ON A.ACP_ComptaCPT_Taxe3 = TT.TA_Code
								LEFT JOIN F_COMPTEG CG 
									ON A.ACP_ComptaCPT_CompteG = CG.CG_Num
								LEFT JOIN F_COMPTEG CA 
									ON A.ACP_ComptaCPT_CompteA = CA.CG_Num)B 
						ON 	A.cbFA_CodeFamille=B.cbFA_CodeFamille 
						AND A.cbAR_Ref=B.cbAR_Ref 
						AND A.ACP_Champ=B.ACP_Champ 
						AND A.ACP_Type=B.ACP_Type
                WHERE 	A.AR_Ref='$AR_Ref'
                AND 	A.ACP_Type=$ACP_Type
                AND 	A.ACP_Champ=$ACP_Champ";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getCatComptaByCodeFamille($CodeFamille,$ACP_Champ,$ACP_Type){
        $query =  "SELECT 	A.FA_CodeFamille,FCP_Type ACP_Type,[ACP_Champ] = FCP_Champ ,[CG_Num] = ISNULL(FCP_ComptaCPT_CompteG,'') ,[CG_Intitule] = ISNULL(CG.CG_Intitule,'') 
							,[CG_NumA] = ISNULL(FCP_ComptaCPT_CompteA,''),[CG_IntituleA] = ISNULL(CA.CG_Intitule,'')
							,[Taxe1] = ISNULL(FCP_ComptaCPT_Taxe1,''),[TA_Intitule1] = ISNULL(TU.TA_Intitule,''),[TA_Taux1] = ISNULL(TU.TA_Taux,0) 
							,[Taxe2] = ISNULL(FCP_ComptaCPT_Taxe2,''),[TA_Intitule2] = ISNULL(TD.TA_Intitule,''),[TA_Taux2] = ISNULL(TD.TA_Taux,0) 
							,[Taxe3] = ISNULL(FCP_ComptaCPT_Taxe3,''),[TA_Intitule3] = ISNULL(TT.TA_Intitule,''),[TA_Taux3] = ISNULL(TT.TA_Taux,0) 
					FROM 	F_FAMCOMPTA A 
					LEFT JOIN F_TAXE TU 
						ON A.FCP_ComptaCPT_Taxe1 = TU.TA_Code
					LEFT JOIN F_TAXE TD 
						ON A.FCP_ComptaCPT_Taxe2 = TD.TA_Code
					LEFT JOIN F_TAXE TT 
						ON A.FCP_ComptaCPT_Taxe3 = TT.TA_Code
					LEFT JOIN F_COMPTEG CG 
						ON A.FCP_ComptaCPT_CompteG = CG.CG_Num
					LEFT JOIN F_COMPTEG CA 
						ON A.FCP_ComptaCPT_CompteA = CA.CG_Num
					WHERE	A.cbFA_CodeFamille='$CodeFamille'
					AND 	A.FCP_Type=$ACP_Type
					AND 	A.FCP_Champ=$ACP_Champ";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

        public function getCatComptaAchat() {
            return $this->getApiJson("/getCatComptaAchat");
        }

    public function __toString() {
        return "";
    }

}