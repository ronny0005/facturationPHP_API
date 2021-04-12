<?php
    $objet = new ObjetCollector();   
    $depot=$_SESSION["DE_No"];  
    $protected = 0;
    $flagNouveau = 1;
    $flagProtected = 0;
    $flagSuppr = 1;
    $sommeil = -1;
    if(isset($_GET["sommeil"]))
        $sommeil = $_GET["sommeil"];
    $type = "client";
    $titre = "Liste client";

    if($_GET["action"]==8) {
        $type="fournisseur";
        $titre = "Liste fournisseur";
    }
    if($_GET["action"]==16) {
        $type="salarie";
        $titre = "Liste salarié";
    }
    $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
    if($type=="client"){
        $flagProtected = $protection->protectedType($type);
        $flagSuppr = $protection->SupprType($type);
        $flagNouveau = $protection->NouveauType($type);
    }
    if($type=="fournisseur" || $type=="salarie"){
        $flagProtected = $protection->protectedType($type);
        $flagSuppr = $protection->SupprType($type);
        $flagNouveau = $protection->NouveauType($type);
    }
?>
<script src="js/jquery.dynatable.js?d=<?php echo time(); ?>" type="text/javascript"></script>
<script src="js/script_listeClient.js?d=<?php echo time(); ?>"></script>

    <input type="hidden" id="mdp" value="<?php echo $_SESSION["mdp"]; ?>"/>
    <input type="hidden" id="login" value="<?php echo $_SESSION["login"]; ?>"/>
    <input type="hidden" id="protected" value="<?php echo $protected; ?>"/>
    <input type="hidden" id="supprProtected" value="<?php echo $flagSuppr; ?>"/>
    <input type="hidden" id="flagCreateur" value="<?php echo $protection->PROT_Right; ?>"/>


<fieldset class="card p-3">
    <legend class="text-uppercase text-center bg-light p-2 mb-3"><?= $titre ?></legend>
<div class="form-group">
<form action="indexMVC.php?module=2&action=2" method="GET">
    <div class="row float-left">
        <div id="numberRow" class="col-6">

        </div>
        <div class="col-6 my-auto">
            <select id="sommeil" style="width:100px" class="form-control">
                <option value="-1" <?php if($sommeil==-1) echo " selected "; ?> >Tout</option>
                <option value="1" <?php if($sommeil==1) echo " selected "; ?> >Sommeil</option>
                <option value="0" <?php if($sommeil==-0) echo " selected "; ?> >Non Sommeil</option>
            </select>
        </div>
    </div>
    <div class="row float-right">
        <div id="searchBar" class="col-6">
        </div>
        <?php if($flagNouveau){ ?><div class="col-6 my-auto">
            <a class="btn btn-primary" href="<?php if($type=="fournisseur") echo "indexMVC.php?module=3&action=9"; if($type=="client") echo "indexMVC.php?module=3&action=2"; if($type=="salarie") echo "indexMVC.php?module=3&action=17"; ?>">
                Nouveau</a>
            </div> <?php } ?>
    </div>
<div class="err" id="add_err"></div>

<table id="users" class="table table-striped">
        <thead>
            <th>Num</th>
            <th>Intitulé</th>
            <th>CG Num</th>
            <th>Cat. Tarif</th>
            <th>Cat. Compta</th>
            <?php if($flagSuppr) echo "<th></th>"; ?>
            <?php if($protection->PROT_Right==1) echo "<th>Créateur</th>"; ?>
        </thead>
</table>
 </div>

</form>
</fieldset>

