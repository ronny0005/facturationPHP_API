<script src="js/scriptCombobox.js?d=<?php echo time(); ?>"></script>
<script src="js/script_Mouvement.js?d=<?php echo time(); ?>"></script>
</head>
<body>
<?php
include("module/Menu/BarreMenu.php");
$objet = new ObjetCollector();
$cat_tarif=0;
$cat_compta=0;
$libcat_tarif="";
$libcat_compta="";
$entete="";
$affaire="";
$souche="";
$co_no=0;
$depot_no=0;
$collaborateur=0;
$modif=0;
$client = "";
$totalht=0;
$totalqte=0;
$tva=0;
$precompte=0;
$marge=0;
$totalttc=0;
$reference="";

$dateEntete="";
if($_GET["type"]=="Transfert_detail"){
    $do_domaine = 4;
    $do_type = 41;
}   

$type = $_GET["type"];

$result=$objet->db->requete($objet->getParametre($_SESSION["id"]));     
$rows = $result->fetchAll(PDO::FETCH_OBJ);
if($rows==null){
}else{ 
    $souche=$rows[0]->CA_Souche;
    $co_no=$rows[0]->CO_No;
    $depot_no=$rows[0]->DE_No;
}   

$depot_no = $_SESSION["DE_No"];
if(isset($_GET["depot"]))
    $depot_no =$_GET["depot"];
if(isset($_GET["depot"]))
    $depot_no =$_GET["depot"];
    
    // Données liées au client
if(isset($_GET["client"])){
    $client=$_GET["client"];
    $comptet = new ComptetClass($_GET["client"]);
    $cat_tarif=$comptet->N_CatTarif;
    $cat_compta=$comptet->N_CatCompta;
    $libcat_tarif=$comptet->LibCatTarif;
    $libcat_compta=$comptet->LibCatCompta;
}
$cbMarq=0;

$docEntete = new DocEnteteClass(0,$objet->db);
$docEntete->type_fac=$type;
if(isset($_GET["cbMarq"])){
    $docEntete = new DocEnteteClass($_GET["cbMarq"],$objet->db);
    $docEntete->type_fac = $type;

    if($type=="Transfert_detail")
        $docEntete->getDoPieceTrsftDetail();
    $reference = $docEntete->DO_Ref;
    $do_imprim = $docEntete->DO_Imprim;
    if ($_GET["type"] == "Entree" || $_GET["type"] == "Sortie")
        $depot_no = $docEntete->DO_Tiers;
    else
        $depot_no = $docEntete->DE_No;
    $collaborateur = $docEntete->DO_Tiers;
    $affaire = $docEntete->CA_Num;
    $dateEntete = $docEntete->DO_Date;
}
$isSecurite = $protection->IssecuriteAdmin($docEntete->DE_No);
$isModif = $docEntete->isModif($protection->PROT_Administrator,$protection->PROT_Right,$protection->protectedType($type),$flagProtApresImpression,$isSecurite);
$isVisu = $docEntete->isVisu($protection->PROT_Administrator,$protection->protectedType($type),$flagProtApresImpression,$isSecurite);

$type = $_GET["type"];

?>
<div id="milieu">
    <div class="container">
        <input type="hidden" name="typeDocument" id="typeDocument" value="<?= $_GET["type"] ?>" />

<section class="enteteMenu bg-light p-2 mb-3">
    <h3 class="text-center text-uppercase">
    Transfert détail
    </h3>
</section>
<div class="col-md-12">
<?php
include("pages/enteteMvt.php");
include("pages/ligneMvt.php");
include("pages/piedMvt.php");
?>