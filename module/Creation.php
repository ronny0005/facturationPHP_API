<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Menu
 *
 * @author Test
 */
class Creation {

public function doAction($action) {
    $objet = new ObjetCollector();
    $protection = new ProtectionClass("","",$objet->db);
    if(isset($_SESSION["login"]))
        $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"],$objet->db);
    if($protection->Prot_No!=""){
        switch($action) {
            case 1 :
                if($protection->PROT_Right==1 || ($protection->PROT_ARTICLE!=2)) $this->Nouvel_Article();  else header('Location: accueil');//rechercher un étudiant par domaine d'activité
                break;
            case 2 :
                if($protection->PROT_Right==1 || ($protection->PROT_CLIENT!=2)) $this->Nouvel_Client();  else header('Location: accueil');//rechercher un étudiant par domaine d'activité
                break;
            case 3 :
                if($protection->PROT_Right==1 || ($protection->PROT_ARTICLE!=2)) $this->Liste_Article(); else header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                break;
            case 4 :
                if($protection->PROT_Right==1 || ($protection->PROT_CLIENT!=2)) $this->Liste_Client();  else header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                break;
            case 5 :
                if($protection->PROT_Right==1 || ($protection->PROT_FAMILLE!=2)) $this->Liste_Catalogue();  else header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                break;
            case 6 :
                if($protection->PROT_Right==1 || ($protection->PROT_FAMILLE!=2)) $this->Liste_Famille();  else header('Location: accueil');//rechercher un étudiant par domaine d'activité
                break;
            case 7 :
                if($protection->PROT_Right==1 || ($protection->PROT_FAMILLE!=2)) $this->Nouvel_Famille();  else header('Location: accueil');//rechercher un étudiant par domaine d'activité
                break;
            case 8 :
                if($protection->PROT_Right==1 || ($protection->PROT_CLIENT!=2)) $this->Liste_Fournisseur();  else header('Location: accueil');//rechercher un étudiant par domaine d'activité
                break;
            case 9 :
                if($protection->PROT_Right==1 || ($protection->PROT_CLIENT!=2)) $this->Nouveau_Fournisseur();  else header('Location: accueil');//rechercher un étudiant par domaine d'activité
                break;
            case 10 :
                if($protection->PROT_Right==1 || ($protection->PROT_DEPOT!=2)) $this->Liste_Depot();  else header('Location: accueil');//rechercher un étudiant par domaine d'activité
                break;
            case 11 :
                if($protection->PROT_Right==1 || ($protection->PROT_DEPOT!=2)) $this->Nouveau_Depot();  else header('Location: accueil');//rechercher un étudiant par domaine d'activité
                break;
            case 12 :
                if($protection->PROT_Right==1 || ($protection->PROT_COLLABORATEUR!=2)) $this->Liste_Collaborateur();  else header('Location: accueil');//rechercher un étudiant par domaine d'activité
                break;
            case 13 :
                if($protection->PROT_Right==1 || ($protection->PROT_COLLABORATEUR!=2)) $this->Nouveau_Collaborateur();  else header('Location: accueil');//rechercher un étudiant par domaine d'activité
                break;
            case 14 :
                if($protection->PROT_Right==1 || ($protection->PROT_COLLABORATEUR!=2)) $this->Liste_Caisse();  else header('Location: accueil');//rechercher un étudiant par domaine d'activité
                break;
            case 15 :
                if($protection->PROT_Right==1 || ($protection->PROT_COLLABORATEUR!=2)) $this->Nouvelle_Caisse();  else header('Location: accueil');//rechercher un étudiant par domaine d'activité
                break;
            case 16 :
                if($protection->PROT_Right==1 || ($protection->PROT_CLIENT!=2)) $this->Liste_Salarie();  else header('Location: accueil');//rechercher un étudiant par domaine d'activité
                break;
            case 17 :
                if($protection->PROT_Right==1 || ($protection->PROT_CLIENT!=2)) $this->Nouveau_Salarie();  else header('Location: accueil');//rechercher un étudiant par domaine d'activité
                break;
            case 18 :
                if($protection->PROT_Right==1 || ($protection->PROT_CLIENT!=2)) $this->Liste_Remise();  else header('Location: accueil');//rechercher un étudiant par domaine d'activité
                break;
            case 19 :
                if($protection->PROT_Right==1 || ($protection->PROT_CLIENT!=2)) $this->Nouveau_Remise();  else header('Location: accueil');//rechercher un étudiant par domaine d'activité
                break;
            default :
                $this->Liste_Article(); // On décide ce que l'on veut faire
        }

    } else
        header('Location: index.php');
}

public function Nouvel_Article() {
$ref = "";
$design = "";
$pxAch = "";
$famille = "";
$pxVtHT = "";
$pxVtTTC = "";
$pxMin="";
$pxMax="";
$ar_cond=0;
$cl_no1 = 0;
$cl_no2 = 0;
$cl_no3 = 0;
$cl_no4 = 0;
$fcl_no1 = 0;
$fcl_no2 = 0;
$fcl_no3 = 0;
$fcl_no4 = 0;
$CT_PrixTTC = 0;
$qte_gros="";
$objet = new ObjetCollector();

$result=$objet->db->requete($objet->typeArticle());
$rows = $result->fetchAll(PDO::FETCH_OBJ);
if($rows!=null){
    $CT_PrixTTC= $rows[0]->CT_PrixTTC;
}


$AR_Sommeil0="";
$AR_Sommeil1="";

if(isset($_GET["AR_Ref"])){
    $article = new ArticleClass(0);
    $article = $article->getCbMarq($_GET["AR_Ref"]);
    $ref = $article->AR_Ref;
    $design = $article->AR_Design;
    $pxAch = $article->AR_PrixAch;
    $famille = $article->FA_CodeFamille;
    $ar_cond = $article->AR_Condition;
    $pxVtHT = $article->AR_PrixVen;
    $pxMin = $article->Prix_Min;
    $pxMax = $article->Prix_Max;
    $cl_no1 = $article->CL_No1;
    $cl_no2 = $article->CL_No2;
    $cl_no3 = $article->CL_No3;
    $cl_no4 = $article->CL_No4;
    $CT_PrixTTC= $article->AR_PrixTTC;
    $qte_gros = $article->Qte_Gros;
    if($article->AR_Sommeil==0)
        $AR_Sommeil0 = " selected ";
    if($article->AR_Sommeil==1)
        $AR_Sommeil1 = " selected ";
    if(isset($famille)){
        $familleClass = new FamilleClass($famille);
        $fcl_no1 = $familleClass->CL_No1;
        $fcl_no2 = $familleClass->CL_No2;
        $fcl_no3 = $familleClass->CL_No3;
        $fcl_no4 = $familleClass->CL_No4;
    }
}
$cbIndice=0;
$PrixTTC_Design = "HT";
if($CT_PrixTTC==1) $PrixTTC_Design = "TTC";
function valTTC($id){
    if($id==1) return "TTC";
    else return "HT";
}
?>
</head>
<body>
<?php
include("settings.php");

$flagProtected = $protection->protectedType("article");
$flagSuppr = $protection->SupprType("article");
$flagNouveau = $protection->NouveauType("article");
$flagInfoLibreArticle = $protection->NouveauType("infoLibreArticle");

?>

<section class="enteteMenu bg-light p-2 mb-3">
    <h3 class="text-center text-uppercase">Fiche article</h3>
</section>

<?php
include("pages/Structure/CreationArticle.php");
}

public function Nouveau_Fournisseur() {
    include("settings.php");
    include("pages/Structure/CreationClient.php");
}

public function Nouvel_Client() {
    include("settings.php");
    include("pages/Structure/CreationClient.php");
}

public function Liste_Article() {
    include("settings.php");
    include("pages/Structure/Liste_Article.php");
}

public function Liste_Client() {
    include("settings.php");
    include("pages/Structure/Liste_Client.php");
}

public function Liste_Fournisseur() {
    include("settings.php");
    include("pages/Structure/Liste_Client.php");
}

public function Liste_Catalogue() {
    include("settings.php");
    include("pages/Structure/Gestion_Catalogue.php");
}

public function Liste_Famille() {
    include("settings.php");
    include("pages/Structure/Gestion_Famille.php");
}

public function Liste_Collaborateur() {
    include("settings.php");
    include("pages/Structure/Liste_Collaborateur.php");
}

public function Nouvel_Famille() {
    include("settings.php");
    include("pages/Structure/CreationFamille.php");
}

public function Liste_Depot() {
    include("pages/Structure/Liste_depot.php");
}

public function Nouveau_Depot() {
    include("settings.php");
    include("pages/Structure/CreationDepot.php");
}


public function Liste_Caisse() {
    include("settings.php");
    include("pages/Structure/Liste_Caisse.php");
}

public function Nouvelle_Caisse() {
    include("settings.php");
    include("pages/Structure/CreationCaisse.php");
}

public function Nouveau_Collaborateur() {
    include("settings.php");
    include("pages/Structure/CreationCollaborateur.php");
}

public function Nouveau_Salarie() {
    include("settings.php");
    include("pages/Structure/CreationClient.php");
}

public function Liste_Salarie() {
    include("settings.php");
    include("pages/Structure/Liste_Client.php");
}

public function Nouveau_Remise() {
    include("settings.php");
    include("pages/Structure/CreationRemise.php");
}

public function Liste_Remise() {
    include("settings.php");
    include("pages/Structure/Liste_Remise.php");
}

}
?>
