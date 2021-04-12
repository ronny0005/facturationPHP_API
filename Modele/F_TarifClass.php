<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class F_TarifClass Extends Objet{
    //put your code here
    public $db,$TF_No
    ,$TF_Intitule
    ,$TF_Interes
    ,$TF_Debut
    ,$TF_Fin
    ,$TF_Objectif
    ,$TF_Domaine
    ,$TF_Base
    ,$TF_Calcul
    ,$AR_Ref
    ,$TF_Remise01REM_Valeur
    ,$TF_Remise01REM_Type
    ,$TF_Remise02REM_Valeur
    ,$TF_Remise02REM_Type
    ,$TF_Remise03REM_Valeur
    ,$TF_Remise03REM_Type
    ,$TF_Type
    ,$CT_Num
    ,$cbProt
    ,$cbMarq
    ,$cbCreateur
    ,$cbModification
    ,$cbReplication
    ,$cbFlag;
    public $table = 'F_Tarif';

    function __construct($id,$db=null) {
        parent::__construct($this->table, $id,'cbMarq',$db);
        if(sizeof($this->data)>0) {
            $this->TF_No = $this->data[0]->TF_No;
            $this->TF_Intitule = $this->data[0]->TF_Intitule;
            $this->TF_Interes = $this->data[0]->TF_Interes;
            $this->TF_Debut = $this->data[0]->TF_Debut;
            $this->TF_Fin = $this->data[0]->TF_Fin;
            $this->TF_Objectif = $this->data[0]->TF_Objectif;
            $this->TF_Domaine = $this->data[0]->TF_Domaine;
            $this->TF_Base = $this->data[0]->TF_Base;
            $this->TF_Calcul = $this->data[0]->TF_Calcul;
            $this->AR_Ref = $this->data[0]->AR_Ref;
            $this->TF_Remise01REM_Valeur = $this->data[0]->TF_Remise01REM_Valeur;
            $this->TF_Remise01REM_Type = $this->data[0]->TF_Remise01REM_Type;
            $this->TF_Remise02REM_Valeur = $this->data[0]->TF_Remise02REM_Valeur;
            $this->TF_Remise02REM_Type = $this->data[0]->TF_Remise02REM_Type;
            $this->TF_Remise03REM_Valeur = $this->data[0]->TF_Remise03REM_Valeur;
            $this->TF_Remise03REM_Type = $this->data[0]->TF_Remise03REM_Type;
            $this->TF_Type = $this->data[0]->TF_Type;
            $this->CT_Num = $this->data[0]->CT_Num;
            $this->cbProt = $this->data[0]->cbProt;
            $this->cbMarq = $this->data[0]->cbMarq;
            $this->cbCreateur = $this->data[0]->cbCreateur;
            $this->cbModification = $this->data[0]->cbModification;
            $this->cbReplication = $this->data[0]->cbReplication;
            $this->cbFlag = $this->data[0]->cbFlag;
        }
    }

    public function maj_f_tarif(){
    //    parent::maj(TF_No,$this->TF_No);
        parent::maj("TF_Intitule",$this->TF_Intitule);
        //parent::maj("TF_Interes",$this->TF_Interes);
          if($this->TF_Debut=="")
              parent::majNull("TF_Debut");
          else
              parent::maj("TF_Debut",$this->TF_Debut);
          if($this->TF_Fin=="")
              parent::majNull("TF_Fin");
          else
              parent::maj("TF_Fin",$this->TF_Fin);
          parent::maj("TF_Objectif",$this->TF_Objectif);
          parent::maj("TF_Domaine",$this->TF_Domaine);
          parent::maj("TF_Base",$this->TF_Base);
          parent::maj("TF_Calcul",$this->TF_Calcul);
          parent::maj("AR_Ref",$this->AR_Ref);
          parent::maj("TF_Remise01REM_Valeur",$this->TF_Remise01REM_Valeur);
          parent::maj("TF_Remise01REM_Type",$this->TF_Remise01REM_Type);
          parent::maj("TF_Remise02REM_Valeur",$this->TF_Remise02REM_Valeur);
          parent::maj("TF_Remise02REM_Type",$this->TF_Remise02REM_Type);
          parent::maj("TF_Remise03REM_Valeur",$this->TF_Remise03REM_Valeur);
          parent::maj("TF_Remise03REM_Type",$this->TF_Remise03REM_Type);
        //  parent::maj("TF_Type",$this->TF_Type);
          if($this->CT_Num=="")
              parent::majNull("CT_Num");
          else
              parent::maj("CT_Num",$this->CT_Num);
          //parent::maj("cbCreateur",$this->cbCreateur);
          parent::majcbModification();
    }

    public function deleteF_TarifRemiseSelect(){
        $query="delete from F_TARIFSELECT
                delete from F_TARIFREMISE";
        $this->db->query($query);
    }

    public function insertF_Tarif(){
        $query="BEGIN 
              SET NOCOUNT ON;
                INSERT INTO [dbo].[F_TARIF]
                   ([TF_No],[TF_Intitule],[TF_Interes],[TF_Debut],[TF_Fin],[TF_Objectif],[TF_Domaine],[TF_Base]
                   ,[TF_Calcul],[AR_Ref],[TF_Remise01REM_Valeur],[TF_Remise01REM_Type]
                   ,[TF_Remise02REM_Valeur],[TF_Remise02REM_Type],[TF_Remise03REM_Valeur],[TF_Remise03REM_Type]
                   ,[TF_Type],[CT_Num],[cbProt],[cbCreateur],[cbModification],[cbReplication],[cbFlag])
                 VALUES
                 (/*TF_No*/(SELECT ISNULL((SELECT TF_No FROM F_TARIF),0)+1),
                       /*TF_Intitule*/'".$this->TF_Intitule."' ,/*TF_Interes*/".$this->TF_Interes."
                       ,/*TF_Debut*/(SELECT(CASE WHEN '".$this->TF_Debut."'='' THEN '1900-01-01' ELSE '".$this->TF_Debut."' END))
                       ,/*TF_Fin*/(SELECT(CASE WHEN '".$this->TF_Fin."'='' THEN '1900-01-01' ELSE '".$this->TF_Fin."' END))
                       ,/*TF_Objectif*/".$this->TF_Objectif.",/*TF_Domaine*/".$this->TF_Domaine.",/*TF_Base*/".$this->TF_Base.",/*TF_Calcul*/".$this->TF_Calcul."
                       ,/*AR_Ref*/'".$this->AR_Ref."',/*TF_Remise01REM_Valeur*/".$this->TF_Remise01REM_Valeur."
                       ,/*TF_Remise01REM_Type*/".$this->TF_Remise01REM_Type.",/*TF_Remise02REM_Valeur*/".$this->TF_Remise02REM_Valeur."
                       ,/*TF_Remise02REM_Type*/".$this->TF_Remise02REM_Type.",/*TF_Remise03REM_Valeur*/".$this->TF_Remise03REM_Valeur."
                       ,/*TF_Remise03REM_Type*/".$this->TF_Remise03REM_Type.",/*TF_Type*/".$this->TF_Type."
                       ,/*CT_Num*/(SELECT CASE WHEN '".$this->CT_Num."'='' THEN NULL ELSE '".$this->CT_Num."' END),/*cbProt*/0,/*cbCreateur*/'".$this->cbCreateur."'
                       ,/*cbModification*/GETDATE(),/*cbReplication*/0,/*cbFlag*/0);
        select @@IDENTITY as cbMarq;
                END;";
        $result= $this->db->query($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        return $rows[0]->cbMarq;
    }


    public function insertF_TarifSelect($tf_no,$tf_interes,$tf_ref){
        $query="INSERT INTO [dbo].[F_TARIFSELECT]
                ([TF_No],[TS_Interes],[TS_Ref],[cbProt]
                ,[cbCreateur],[cbModification],[cbReplication],[cbFlag])
                VALUES
                (/*TF_No*/ $tf_no,/*TS_Interes*/$tf_interes ,/*TS_Ref*/'$tf_ref'
                ,/*cbProt*/0 ,/*cbCreateur*/'' ,/*cbModification*/GETDATE()
                ,/*cbReplication*/0 ,/*cbFlag*/0)";
        $this->db->query($query);
    }

    public function insertF_TarifRemise($tf_no,$TR_BorneSup,$TR_Remise01REM_Valeur,$TR_Remise01REM_Type){

        $query="INSERT INTO [dbo].[F_TARIFREMISE]
           ([TF_No],[TR_BorneSup],[TR_Remise01REM_Valeur]
           ,[TR_Remise01REM_Type],[TR_Remise02REM_Valeur]
           ,[TR_Remise02REM_Type],[TR_Remise03REM_Valeur]
           ,[TR_Remise03REM_Type],[cbProt]
           ,[cbCreateur],[cbModification],[cbReplication],[cbFlag])
     VALUES
     (/*TF_No*/$tf_no,/*TR_BorneSup*/$TR_BorneSup,/*TR_Remise01REM_Valeur*/$TR_Remise01REM_Valeur
         ,/*TR_Remise01REM_Type*/$TR_Remise01REM_Type,/*TR_Remise02REM_Valeur*/0
         ,/*TR_Remise02REM_Type*/0,/*TR_Remise03REM_Valeur*/0
         ,/*TR_Remise03REM_Type*/0,/*cbProt*/0
         ,/*cbCreateur*/'',/*cbModification*/GETDATE()
         ,/*cbReplication*/0,/*cbFlag*/0)";
        $this->db->query($query);
    }

    public function updateF_TarifRemise ($TF_No,$position,$TR_Remise01REM_Valeur,$TR_Remise01REM_Type){
        $query="UPDATE F_TARIFREMISE SET [TR_Remise01REM_Valeur]=$TR_Remise01REM_Valeur,[TR_Remise01REM_Type]=$TR_Remise01REM_Type 
                WHERE cbMarq = (SELECT cbMarq
                                FROM(
                                SELECT TF_No,cbMarq,RANK() OVER(ORDER BY cbMarq) Rang
                                FROM F_TARIFREMISE
                                WHERE TF_No=$TF_No)A
                                WHERE Rang=$position)";
        $this->db->query($query);
    }

    public function gettarifSelect($type){
        $query="SELECT *
                FROM F_TARIFSELECT
                WHERE ($type=0 OR ($type=1 AND TS_Interes IN (0,1)) OR ($type=2 AND TS_Interes IN (2,3)))
                AND   TF_No=".$this->TF_No
                ;
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function gettarifRemise(){
        $query="SELECT  cbMarq,TF_No
                        ,TR_BorneSup
                        ,CASE WHEN TR_Remise01REM_Type=0 THEN ''  
                            WHEN TR_Remise01REM_Type=1 THEN CAST(CAST(TR_Remise01REM_Valeur as numeric(9,2)) as varchar(10))+'%' 
                            WHEN TR_Remise01REM_Type=2 THEN CAST(CAST(TR_Remise01REM_Valeur as numeric(9,2)) as varchar(10))+'U' END Remise01
                        ,CASE WHEN TR_Remise02REM_Type=0 THEN ''  
                            WHEN TR_Remise02REM_Type=1 THEN CAST(CAST(TR_Remise02REM_Valeur as numeric(9,2)) as varchar(10))+'%' 
                            WHEN TR_Remise02REM_Type=2 THEN CAST(CAST(TR_Remise02REM_Valeur as numeric(9,2)) as varchar(10))+'U' END Remise02
                        ,CASE WHEN TR_Remise03REM_Type=0 THEN ''  
                            WHEN TR_Remise03REM_Type=1 THEN CAST(CAST(TR_Remise03REM_Valeur as numeric(9,2)) as varchar(10))+'%' 
                            WHEN TR_Remise03REM_Type=2 THEN CAST(CAST(TR_Remise03REM_Valeur as numeric(9,2)) as varchar(10))+'U' END Remise03
                FROM F_TARIFREMISE
                WHERE TF_No=".$this->TF_No;
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function __toString() {
        return "";
    }

}