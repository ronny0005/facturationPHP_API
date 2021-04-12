<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class ContatDClass Extends Objet{
    //put your code here
    public $CD_Nom,$CD_Prenom,$N_Service,$CD_Fonction
    ,$CD_Telephone,$CD_TelPortable,$CD_Telecopie,$CD_EMail
    ,$CD_Civilite,$N_Contact,$CD_Adresse,$CD_Complement
    ,$CD_CodePostal,$CD_Ville,$CD_No,$cbProt
    ,$cbCreateur,$cbModification,$cbReplication,$cbFlag,$cbMarq;
    public $table = 'F_CONTACTD';

    function __construct($id,$db=null) {
            parent::__construct($this->table, $id, 'CD_No',$db);
        if (sizeof($this->data) > 0) {
            $this->CD_Nom = $this->data[0]->CD_Nom;
            $this->CD_Prenom = stripslashes($this->data[0]->CD_Prenom);
            $this->N_Service = $this->data[0]->N_Service;
            $this->CD_Fonction = $this->data[0]->CD_Fonction;
            $this->CD_Telephone = $this->data[0]->CD_Telephone;
            $this->CD_TelPortable = stripslashes($this->data[0]->CD_TelPortable);
            $this->CD_Telecopie = stripslashes($this->data[0]->CD_Telecopie);
            $this->CD_EMail = $this->data[0]->CD_EMail;
            $this->CD_Civilite = $this->data[0]->CD_Civilite;
            $this->N_Contact = $this->data[0]->N_Contact;
            $this->CD_Adresse = $this->data[0]->CD_Adresse;
            $this->CD_Complement = $this->data[0]->CD_Complement;
            $this->CD_CodePostal = $this->data[0]->CD_CodePostal;
            $this->CD_Ville = $this->data[0]->CD_Ville;
            $this->CD_No = $this->data[0]->CD_No;
            $this->cbProt = $this->data[0]->cbProt;
            $this->cbCreateur = $this->data[0]->cbCreateur;
            $this->cbModification = $this->data[0]->cbModification;
        }
    }

    public function maj_ContactD(){
        parent::maj('CD_Nom', $this->CD_Nom);
        parent::maj('CD_Prenom', $this->CD_Prenom);
        parent::maj('N_Service', $this->N_Service);
        parent::maj('CD_Fonction', $this->CD_Fonction);
        parent::maj('CD_Telephone', $this->CD_Telephone);
        parent::maj('CD_TelPortable', $this->CD_TelPortable);
        parent::maj('CD_Telecopie', $this->CD_Telecopie);
        parent::maj('CD_EMail', $this->CD_EMail);
        parent::maj('CD_Civilite', $this->CD_Civilite);
        parent::maj('N_Contact', $this->N_Contact);
        parent::maj('CD_Adresse', $this->CD_Adresse);
        parent::maj('CD_Complement', $this->CD_Complement);
        parent::maj('CD_CodePostal', $this->CD_CodePostal);
        parent::maj('CD_Ville', $this->CD_Ville);
        parent::maj('CD_No', $this->CD_No);
        parent::maj('cbModification', $this->cbModification);
        parent::maj('cbCreateur', $this->userName);
    }

    public function __toString() {
        return "";
    }

    public function setValue(){
        $this->N_Service = 0;
        $this->CD_Telephone = "";
        $this->CD_TelPortable = "";
        $this->CD_Telecopie = "";
        $this->CD_EMail = "";
        $this->CD_Civilite = 0;
        $this->N_Contact = 1;
        $this->CD_Adresse = "";
        $this->CD_Complement = "";
        $this->CD_CodePostal = "";
        $this->CD_Ville = "";
        $this->cbProt = 0;
        $this->cbCreateur = "";
        $this->cbModification = "";
    }

    public function envoiSms($telephone,$message){
        $this->sendSms($telephone,$message);
    }


public function sendSms($destination,$message){
//    $url = 'http://lmtgroup.dyndns.org/sendsms/sendsmsGold.php?';
        $url = $this->CD_Email;
        $this->db = new DB();
        if($this->db->db=="CMI" || $this->db->db=="ZUMI") {
            $url = "http://mmp.gtsnetwork.cloud/gts/sendsms?";
            $request = $url . "version=2&phone=694547803&password=" . $this->CD_Prenom . "&from=IT-Solution&to=" . urlencode($destination) . "&text=" . urlencode($message);
        } else {
            $request = $url . "UserName=" . urlencode($this->CD_Nom) . "&Password=" . $this->CD_Prenom;
            $request .= "&SOA=" . urlencode($this->CD_Fonction) . "&MN=" . urlencode($destination) . "&SM=" . urlencode($message);
        }
        $url =$request;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POST, 1);
        $response = curl_exec($ch);
        curl_close($ch);
    }

    public function insertContactD(){
        $query = "INSERT INTO [dbo].[F_CONTACTD]
                   ([CD_Nom],[CD_Prenom],[N_Service],[CD_Fonction]
                   ,[CD_Telephone],[CD_TelPortable],[CD_Telecopie],[CD_EMail]
                   ,[CD_Civilite],[N_Contact],[CD_Adresse],[CD_Complement]
                   ,[CD_CodePostal],[CD_Ville],[CD_No],[cbProt]
                   ,[cbCreateur],[cbModification],[cbReplication],[cbFlag])
                     VALUES
       (/*CD_Nom*/'".$this->CD_Nom."',/*CD_Prenom*/'".$this->CD_Prenom."',/*N_Service*/".$this->N_Service.",
       /*CD_Fonction*/'".$this->CD_Fonction."',/*CD_Telephone*/'".$this->CD_Telephone."'
       ,/*CD_TelPortable*/'".$this->CD_TelPortable."',/*CD_Telecopie*/'".$this->CD_Telecopie."',/*CD_EMail*/'".$this->CD_EMail."',
       /*CD_Civilite*/".$this->CD_Civilite.",/*N_Contact*/".$this->N_Contact.",/*CD_Adresse*/'".$this->CD_Adresse."',
       /*CD_Complement*/'".$this->CD_Complement."',/*CD_CodePostal*/'".$this->CD_CodePostal."',/*CD_Ville*/'".$this->CD_Ville."',
       /*CD_No*/ISNULL((SELECT MAX(CD_No) FROM F_CONTACTD),0)+1,/*cbProt*/0,/*cbCreateur*/'".$this->userName."',
       /*cbModification*/GETDATE(),/*cbReplication*/0,/*cbFlag*/0)";
        $result= $this->db->query($query);
    }

}