<?php
if(!isset($mobile)){
    session_start();
    include("../Modele/DB.php");
    include("../Modele/Objet.php");
    include("../Modele/ObjetCollector.php");
    include("../Modele/DocEnteteClass.php");
    include("../Modele/DocLigneClass.php");
    include("../Modele/ComptetClass.php");
    include("../Modele/CaisseClass.php");
    include("../Modele/DepotClass.php");
    include("../Modele/ArticleClass.php");
    include("../Modele/FamilleClass.php");
    include("../Modele/ContatDClass.php");
    include("../Modele/P_ParametreLivrClass.php");
    include("../Modele/ProtectionClass.php");
    include("../Modele/P_CommunicationClass.php");
    include("../Modele/LogFile.php");



    $objet = new ObjetCollector();
}



?>