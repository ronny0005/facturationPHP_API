<script src="js/scriptCombobox.js?d=<?php echo time(); ?>"></script>
<script src="js/script_Mouvement.js?d=<?php echo time(); ?>"></script>
<?php
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

$do_imprim = 0;
$result=$objet->db->requete($objet->getParametre($_SESSION["id"]));     
$rows = $result->fetchAll(PDO::FETCH_OBJ);
if($rows==null){

}else{
    $souche=$rows[0]->CA_Souche;
    $co_no=$rows[0]->CO_No;
    $depot_no=$rows[0]->DE_No;
}   

$depot_no = $_SESSION["DE_No"];
    
// Données liées au client
if(isset($_GET["client"])){
    $client=$_GET["client"];
    $comptet = new ComptetClass($_GET["client"],$objet->db);
    $cat_tarif=$comptet->N_CatTarif;
    $cat_compta=$comptet->N_CatCompta;
    $libcat_tarif=$comptet->LibCatTarif;
    $libcat_compta=$comptet->LibCatCompta;
}
// Création de l'entete de document
$isModif = 1;
$isVisu = 1;
$type = $_GET["type"];
$docEntete = new DocEnteteClass(0,$objet->db);
$docEntete->type_fac=$type;
$isSecurite = 0;
$isSecurite = $protection->IssecuriteAdmin($docEntete->DE_No);
if(isset($_GET["cbMarq"])){
    $docEntete = new DocEnteteClass($_GET["cbMarq"],$objet->db);
    $docEntete->type_fac=$type;
    $reference=$docEntete->DO_Ref;
    $do_imprim = $docEntete->DO_Imprim;
    if($_GET["type"]=="Entree" || $_GET["type"]=="Sortie")
        $depot_no=$docEntete->DO_Tiers;
    else
        $depot_no=$docEntete->DE_No;
    $collaborateur=$docEntete->DO_Tiers;
    $affaire= $docEntete->CA_Num;
    $dateEntete = $docEntete->DO_Date;
}
$isModif = $docEntete->isModif($protection->PROT_Administrator,$protection->PROT_Right,$protection->protectedType($type),$flagProtApresImpression,$isSecurite);
$isVisu = $docEntete->isVisu($protection->PROT_Administrator,$protection->protectedType($type),$flagProtApresImpression,$isSecurite);
if($protection->ProtectAdmin==1)
    $admin=0;
?>
<input type="hidden" name="typeDocument" id="typeDocument" value="<?= $_GET["type"] ?>" />
<section class="enteteMenu bg-light p-2 mb-3">
    <h3 class="text-center text-uppercase">
        <?= $protection->listeFactureNom($type) ?>
    </h3>
</section>
<?php
include("pages/enteteMvt.php");
include("pages/ligneMvt.php");
include("pages/piedMvt.php");
?>