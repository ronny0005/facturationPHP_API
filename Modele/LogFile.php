<?php

class LogFile
{
    public $filename = 'log.csv';
    public $fh,$user,$db;
    function __construct($db=null)
    {
        if($db!=null)
            $this->db = $db;
        else
            $this->db = new DB();

        if (file_exists($this->filename)) {
            $this->fh = fopen($this->filename, 'a');
        } else {
            $this->fh = fopen($this->filename, 'w');
            fwrite($this->fh, 'Action;Type;DoType;DoEntete;DE_No;DoDomaine;AR_Ref;Qte;Prix;Remise;Montant;Date;User;cbMarq;tables;cbCreateur');
        }
    }

    function writeFacture($Action,$DoType,$DoEntete,$DE_No,$DoDomaine,$AR_Ref,$Qte,$Prix,$Remise,$Montant,$cbMarq,$table,$user,$cbCreateur,$doDate){
        $this->db = new DB();
        $Type="";
        if($DoDomaine==0){
            if($DoType==0)
                $Type="Devis";
            if($DoType==6)
                $Type="Vente";
            if($DoType==7)
                $Type="Vente Comptabilisée";
        }
        if($DoDomaine==1){
            if($DoType==12)
                $Type="AchatPrecommande";
            if($DoType==16)
                $Type="Achat";
            if($DoType==17)
                $Type="Achat comptabilisé";
        }
        fwrite($this->fh, "\n$Action;$Type;$DoType;$DoEntete;$DE_No;$DoDomaine;$AR_Ref;$Qte;$Prix;$Remise;$Montant;".(new DateTime())->format('Y-m-d H:i:s').";$user;$cbMarq;$table;$cbCreateur;$doDate");
        $sql ="DECLARE @action NVARCHAR(50)='$Action'
               DECLARE @type NVARCHAR(50)='$Type'
               DECLARE @doType NVARCHAR(50)='$DoType'
               DECLARE @doEntete NVARCHAR(50)='$DoEntete'
               DECLARE @deNo NVARCHAR(50)='$DE_No'
               DECLARE @doDomaine NVARCHAR(50)='$DoDomaine'
               DECLARE @arRef NVARCHAR(50)='$AR_Ref'
               DECLARE @qte NVARCHAR(50)='$Qte'
               DECLARE @prix NVARCHAR(50)='$Prix'
               DECLARE @remise NVARCHAR(50)='$Remise'
               DECLARE @montant NVARCHAR(50)='$Montant'
               DECLARE @user NVARCHAR(50)='$user'
               DECLARE @cbMarq NVARCHAR(50)='$cbMarq'
               DECLARE @table NVARCHAR(50)='$table'
               DECLARE @cbCreateur NVARCHAR(50)='$cbCreateur'
               DECLARE @doDate NVARCHAR(50)='$doDate';
               
                INSERT INTO Z_LogInfo VALUES (@action,@type,@doType,@doEntete,@deNo,@doDomaine,@arRef
                ,@qte,@prix,@remise,@montant,'".(new DateTime())->format('Y-m-d H:i:s')."',@user,@cbMarq,@table,@cbCreateur,@doDate)";
        $this->db->query($sql);
        $this->close ();
    }

    function writeReglement($action,$Montant,$rgNo,$ctNum,$cbMarq,$table,$user,$cbCreateur,$doDate){
        $this->db = new DB();
        fwrite($this->fh, "\n$action;;;;;;;;;;$Montant;".(new DateTime())->format('Y-m-d H:i:s').";$user;$cbMarq;$table;$cbCreateur;$doDate");
        $sql ="INSERT INTO Z_LogInfo VALUES ('$action','Reglement',0,'$rgNo',0,0,'$ctNum',0,0,'',$Montant,'".(new DateTime())->format('Y-m-d H:i:s')."','$user',$cbMarq,'$table','$cbCreateur','$doDate')";
        $this->db->query($sql);
        $this->close ();
    }

    function writeStock($Type,$AR_Ref,$DE_No,$Qte,$Montant,$cbMarq,$table,$user,$cbCreateur){
        $this->db = new DB();
        fwrite($this->fh, "\n$Type;Artstock;;;$DE_No;;$AR_Ref;$Qte;;;$Montant;".(new DateTime())->format('Y-m-d H:i:s').";{$this->user};$cbMarq;$table;$cbCreateur;NULL");
        $sql ="INSERT INTO Z_LogInfo VALUES ('Artstock','$Type',0,'',$DE_No,0,'$AR_Ref',$Qte,0,'',$Montant,'".(new DateTime())->format('Y-m-d H:i:s')."','$user',$cbMarq,'$table','$cbCreateur',NULL)";
        $this->db->query($sql);
        $this->close ();
    }

    function close (){
        fclose($this->fh);
        chmod($this->filename, 0777);
    }

}