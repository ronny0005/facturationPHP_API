<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class LiaisonEnvoiMailUser Extends Objet{
    //put your code here
    public $TE_No,$Prot_No,$cbModification ,$cbUser;
    public $table = 'Z_LiaisonEnvoiMailUser';

    function __construct($db=null) {
        parent::__construct($this->table, "", 'TE_No',$db);
    }

    public function __toString() {
        return "";
    }

    public function getDataUser($prot_no){
        $query = "  SELECT A.TE_No,TE_Intitule,CASE WHEN ISNULL(B.Prot_No,0)=0 THEN 0 ELSE 1 END Prot_No
                    FROM Z_TypeEnvoiMail A
                    LEFT JOIN (SELECT * FROM Z_LiaisonEnvoiMailUser WHERE Prot_No=$prot_no) B on A.TE_No=B.TE_No
                    ORDER BY A.TE_No";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getConfigMail($prot_no,$PROT_No_Profil,$te_no,$check){
        $this->setuserName("","");
        $query = "  
        DECLARE @PROT_No as INT;
        DECLARE @PROT_No_Profil as INT;
        DECLARE @TE_No as INT;
        DECLARE @check as INT;
        SET @PROT_No = $prot_no;
        SET @PROT_No_Profil = $PROT_No_Profil;
        SET @TE_No = $te_no;
        SET @check =$check;
        
                IF @PROT_No <> 0  
                    IF NOT EXISTS (SELECT 1 FROM Z_LiaisonEnvoiMailUser WHERE TE_No=@TE_No AND PROT_No=@PROT_No)  
                    BEGIN
                        INSERT INTO Z_LiaisonEnvoiMailUser VALUES (@TE_No,@PROT_No,GETDATE(),".$this->userName.")
                    END 
                    ELSE 
                        BEGIN
                            DELETE FROM Z_LiaisonEnvoiMailUser WHERE TE_No=@TE_No AND PROT_No=@PROT_No
                        END
                ELSE 
                    BEGIN 
                        IF @check = 1
                            INSERT INTO Z_LiaisonEnvoiMailUser
                            SELECT @TE_No,PROT_No,GETDATE(),".$this->userName."
                            FROM F_PROTECTIONCIAL A
                            WHERE PROT_UserProfil = @PROT_No_Profil
                            UNION SELECT @TE_No,@PROT_No_Profil,GETDATE(),".$this->userName."
                        ELSE 
                            DELETE FROM Z_LiaisonEnvoiMailUser
                            FROM (SELECT PROT_No
                                    FROM F_PROTECTIONCIAL A
                                    WHERE PROT_UserProfil = @PROT_No_Profil
                                    UNION SELECT @PROT_No_Profil) A
                            WHERE A.PROT_No =Z_LiaisonEnvoiMailUser.Prot_No AND TE_No = @TE_No
                    END";

        $result= $this->db->query($query);
    }

    public function getEnvoiMailLib(){
        $query = "SELECT TE_No,TE_Intitule
                    FROM Z_TypeEnvoiMail
                    ORDER BY TE_No";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

}