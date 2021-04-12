<?php
    $objet = new ObjetCollector();
$sommeil = 0;
if(isset($_POST["sommeil"]))
    $sommeil = $_POST["sommeil"];
$stockFlag = -1;
if(isset($_POST["stockFlag"]))
    $stockFlag = $_POST["stockFlag"];
$prixFlag = -1;
if(isset($_POST["prixFlag"]))
    $prixFlag = $_POST["prixFlag"];
$depot=$_SESSION["DE_No"];
    $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
    $flagProtected = $protection->protectedType("article");
    $flagSuppr = $protection->SupprType("article");
    $flagNouveau = $protection->NouveauType("article");

?>
<script src="js/jquery.dynatable.js?d=<?php echo time(); ?>" type="text/javascript"></script>
<script src="js/script_listeArticle.js?d=<?php echo time(); ?>"></script>

    <input type="hidden" id="mdp" value="<?= $_SESSION["mdp"]; ?>"/>
    <input type="hidden" id="login" value="<?= $_SESSION["login"]; ?>"/>
    <input type="hidden" id="flagInfoLibreArticle" value="<?= $flagInfoLibreArticle; ?>"/>
    <input type="hidden" id="flagPxRevient" value="<?= $flagPxRevient; ?>"/>
    <input type="hidden" id="flagPxAchat" value="<?= $flagPxAchat; ?>"/>
    <input type="hidden" id="DE_No" value="<?= $_SESSION["DE_No"]; ?>"/>
    <input type="hidden" id="protected" value="<?= $flagProtected; ?>"/>
    <input type="hidden" id="supprProtected" value="<?= $flagSuppr; ?>"/>
    <input type="hidden" id="flagCreateur" value="<?= $protection->PROT_Right; ?>"/>
    <input type="hidden" id="acte" value="<?= (isset($_GET["acte"])) ? $_GET["acte"] : "" ; ?>"/>
    <input type="hidden" id="arRef" value="<?= (isset($_GET["AR_Ref"])) ? $_GET["AR_Ref"] : "" ; ?>"/>

    <div class="col-md-12">

<fieldset class="card p-2">
<legend class="bg-light text-center text-uppercase p-2">Liste article</legend>

<div>
<form action="#" method="POST" name="formParam" id="formParam">
    <div class="row">
        <div class="col-4 col-sm-4 col-md-4 col-lg-2">
            <label>Sommeil</label>
            <select id="sommeil" style="" class="form-control" name="sommeil">
                <option value="-1" <?php if($sommeil==-1) echo " selected "; ?> >Tout</option>
                <option value="1" <?php if($sommeil==1) echo " selected "; ?> >Oui</option>
                <option value="0" <?php if($sommeil==-0) echo " selected "; ?> >Non</option>
            </select>
        </div>
        <div class="col-4 col-sm-4 col-md-4 col-lg-2">
            <label>Stock</label>
            <select id="stockFlag" name="stockFlag" class="form-control">
                <option value="-1" <?php if($stockFlag==-1) echo " selected "; ?> >Tout</option>
                <option value="1" <?php if($stockFlag==1) echo " selected "; ?> >Oui</option>
                <option value="0" <?php if($stockFlag==-0) echo " selected "; ?> >Non</option>
            </select>
        </div>
        <div class="col-4 col-sm-4 col-md-4 col-lg-2">
            <label>Prix min/max</label>
            <select id="prixFlag" name="prixFlag" class="form-control">
                <option value="-1" <?php if($prixFlag==-1) echo " selected "; ?> >Tout</option>
                <option value="1" <?php if($prixFlag==1) echo " selected "; ?> >Oui</option>
                <option value="0" <?php if($prixFlag==-0) echo " selected "; ?> >Non</option>
            </select>
        </div>
        <div class="col-6 col-sm-6 col-md-6 col-lg-4 mt-4">
            <input type="button" class="btn btn-primary" id="imprimer" value="Exporter excel"/>
        </div>
        <div class="col-6 col-sm-6 col-md-6 col-lg-2 text-right mt-4">
            <a href="indexMVC.php?module=3&action=1"><button type="button" id="nouveau" class="btn btn-primary">Nouveau</button></a>
        </div>
    </div>
    <?php
    if($flagNouveau){ ?>
    <?php } ?>
        </form>
<div class="err" id="add_err"></div>
<div class="table-responsive">
    <table id="users" class="table table-striped">
        <thead>
                <th>Référence</th>
                <th>Désignation</th>
                <th>Code famille</th>
                <th>Quantité en stock (cumul)</th>
                <?php if($flagPxAchat==0) echo"<th>Prix d'achat</th>"; ?>
                <?php if($flagInfoLibreArticle!=2) echo"<th>Prix de vente</th>"; ?>
                <?php  if($flagPxRevient==0) echo "<th>Montant</th>"; ?>
                <?php if($flagSuppr) echo "<th></th>"; ?>
                <?php if($protection->PROT_Right==1) echo "<th>Créateur</th>"; ?>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
</div>

   
</div>
