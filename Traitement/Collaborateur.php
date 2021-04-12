<?php
if(!isset($mobile)){
    session_start();
    include("../Modele/DB.php");
    include("../Modele/Objet.php");
    include("../Modele/ObjetCollector.php");
    include("../Modele/CollaborateurClass.php");
    $objet = new ObjetCollector(); 
}
if($_GET["acte"] =="suppr"){
    $CO_No = $_GET["CO_No"];
    $collaborateurClass = new CollaborateurClass($CO_No,$objet->db);
    $collaborateurClass ->delete();
    header('Location: ../indexMVC.php?module=3&action=12&acte=supprOK&CO_No='.$CO_No);
}

if($_GET["acte"]=="ajout"){
    $nom = str_replace("'", "''", $_GET["nom"]);
    $prenom = str_replace("'", "''", $_GET["prenom"]);
	$collaborateur = new CollaborateurClass(0);
    $rows = $collaborateur->getCollaborateurByNom($nom);
    if($rows==null){
		$fonction = str_replace("'", "''", $_GET["fonction"]);
		$service = str_replace("'", "''", $_GET["service"]);
		$adresse = str_replace("'", "''", $_GET["adresse"]);
		$complement = str_replace("'", "''", $_GET["complement"]);
		$codePostal = str_replace("'", "''", $_GET["codePostal"]);
		$ville= str_replace("'", "''", $_GET["ville"]);
		$region= str_replace("'", "''", $_GET["region"]);
		$pays= str_replace("'", "''", $_GET["pays"]);
		$email= str_replace("'", "''", $_GET["email"]);
		$telephone= $_GET["telephone"];
		$telecopie= $_GET["telecopie"];
		if(isset($_GET["vendeur"]))$btnVendeur=1;
		else $btnVendeur=0;
		if(isset($_GET["caissier"]))$btnCaissier=1;
		else $btnCaissier=0;
		if(isset($_GET["acheteur"]))$btnAcheteur=1;
		else $btnAcheteur=0;
		if(isset($_GET["controleur"]))$btnControleur=1;
		else $btnControleur=0;
		if(isset($_GET["recouvrement"]))$btnRecouv=1;
		else $btnRecouv=0;
		$collaborateurClass = new CollaborateurClass(0,$objet->db);
		$coNo = $collaborateurClass->insertCollaborateur($nom,$prenom,$adresse,$complement,$codePostal,$fonction,$ville,$region,$pays,$service,$btnVendeur,$btnCaissier,$btnAcheteur,$telephone,$telecopie,$email,$btnControleur,$btnRecouv);
		$data = array('CO_No' => $coNo);
		echo json_encode($data);
    }else {
        echo "$nom existe déjà !";
    }
}

if($_GET["acte"]=="modif"){
    $co_no=$_GET["CO_No"];
    $nom = str_replace("'", "''", $_GET["nom"]);
    $prenom = str_replace("'", "''", $_GET["prenom"]);
    $fonction = str_replace("'", "''", $_GET["fonction"]);
    $service = str_replace("'", "''", $_GET["service"]);
    $adresse = str_replace("'", "''", $_GET["adresse"]);
    $complement = str_replace("'", "''", $_GET["complement"]);
    $codePostal = str_replace("'", "''", $_GET["codePostal"]);
    $ville= str_replace("'", "''", $_GET["ville"]);
    $region= str_replace("'", "''", $_GET["region"]);
    $pays= str_replace("'", "''", $_GET["pays"]);
    $email= str_replace("'", "''", $_GET["email"]);
    $telephone= $_GET["telephone"];
    $telecopie= $_GET["telecopie"];
    if(isset($_GET["vendeur"]))$btnVendeur=1;
    else $btnVendeur=0;
    if(isset($_GET["caissier"]))$btnCaissier=1;
    else $btnCaissier=0;
    if(isset($_GET["acheteur"]))$btnAcheteur=1;
    else $btnAcheteur=0;
    if(isset($_GET["controleur"]))$btnControleur=1;
    else $btnControleur=0;
    if(isset($_GET["recouvrement"]))$btnRecouv=1;
    else $btnRecouv=0;
    $collaborateurClass = new CollaborateurClass($co_no,$objet->db);
    $collaborateurClass->modifCollaborateur($nom,$prenom,$adresse,$complement,$codePostal,$fonction,$ville,$region,$pays,$service,$btnVendeur,$btnCaissier,$btnAcheteur,$telephone,$telecopie,$email,$btnControleur,$btnRecouv,$co_no);
    $data = array('CO_No' => $co_no);
    echo json_encode($data);
}
?>
