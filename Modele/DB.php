<?php
/*define("UID", 'sa');
define("PWD", "sa2015");
define("DATABASE", "CMI");
define("BASECOMPTA", "CMI");
$flagDataOr = 0;
if(DATABASE=="GOLD") $flagDataOr =1;
define("FLAGDATAOR", $flagDataOr);
$dataSSRS =DATABASE;
if(DATABASE=="ZUMI_DEV") $dataSSRS = "ZUMI";
if(DATABASE=="CMI_DEV") $dataSSRS = "CMI";
*/
class DB {
    public $host,$user,$mdp,$db,$conn;
    public $baseCompta;
    public $RapportsSSRS;
    public $flagDataOr;

    function __construct(){
        $settings = parse_ini_file(__DIR__."\..\config\db.config", 1);
        $this->user=$settings["db_user"];
        $this->mdp=$settings["db_pass"];
        $this->db=$settings["db_name"];
        $this->host=$settings["db_host"];
        $this->baseCompta = $settings["db_name"];
        $dataSSRS = $this->db;
        if($this->db=="ZUMI_DEV") $dataSSRS = "ZUMI";
        if($this->db=="CMI_DEV") $dataSSRS = "CMI";
        $this->RapportsSSRS ="Rapport$dataSSRS";

        $this->flagDataOr = 0;
        if($this->db=="GOLD") $this->flagDataOr =1;


        try{
            $this->connexion_bdd = new PDO('sqlsrv:Server='.$this->host.';Database='.$this->db, $this->user, $this->mdp);
        // Fixe les options d'erreur (ici nous utiliserons les exceptions)
            $this->connexion_bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch (\PDOException $e){
            echo  $e->getMessage();
            die();
        }
    }

    public function requete($requete)
    {
        try{
            $prepare = $this->connexion_bdd->prepare("SET DATEFORMAT ymd;$requete");
            $prepare->execute();
        }catch (\PDOException $e){
            echo    $requete." ".$e->getMessage();
            die();
        }
return $prepare;
    }


    public function query($requete)
    {
        try{
            $prepare = $this->connexion_bdd->prepare("SET DATEFORMAT ymd; $requete");
            $prepare->execute();
        }catch (\PDOException $e){
            echo  $requete." ".$e->getMessage();
            die();
        }
        return $prepare;
    }

    public function test($requete)
    {
        $prepare = $this->connexion_bdd->exec($requete);
        return $prepare;
    }
}

?>