<?php
session_start();
include("modele/Mail.php");
include("modele/LogFile.php");
include("Modele/DB.php");
include("Modele/Objet.php");
include("Modele/ObjetCollector.php");
include("Modele/CaisseClass.php");
include("Modele/CollaborateurClass.php");
include("Modele/JournalClass.php");
include("modele/ArtClientClass.php");
include("Modele/DepotClass.php");
include("Modele/DepotCaisseClass.php");
include("Modele/DepotUserClass.php");
include("Modele/DocEnteteClass.php");
include("Modele/CatComptaClass.php");
include("Modele/DocReglClass.php");
include("Modele/ReglEchClass.php");
include("Modele/EtatClass.php");
include("modele/ReglementClass.php");
include("modele/CompteaClass.php");
include("modele/P_CommunicationClass.php");
include("modele/LiaisonEnvoiMailUser.php");
include("Modele/LiaisonEnvoiSMSUser.php");
include("modele/DepotEmplClass.php");
include("modele/DepotEmplUserClass.php");
include("Modele/ContatDClass.php");
include("Modele/DocLigneClass.php");
include("Modele/ComptetClass.php");
include("Modele/CatTarifClass.php");
include("Modele/ProtectionClass.php");
include("Modele/TaxeClass.php");
include("Modele/FamilleClass.php");
include("Modele/ArticleClass.php");
include("Modele/F_TarifClass.php");
include("Modele/CompteGClass.php");
include("Modele/BanqueClass.php");
include("Modele/PReglementClass.php");
include("module/Menu.php");
include("module/Facturation.php");
include("module/Creation.php");
include("module/Mouvement.php");
include("module/Caisse.php");
include("module/Etat.php");
include("module/Admin.php");
include("module/PlanComptable.php");
if(isset($_SESSION) && sizeof($_SESSION)==0) {
    header('Location: connexion');
    die();
}
$objet = new ObjetCollector();
$protection = new ProtectionClass("","");
if(isset($_SESSION["id"]))
    $protection->connexionProctectionByProtNo($_SESSION["id"]);

if($protection->Prot_No=="") {
    header('Location: connexion');
    die();
}
?>