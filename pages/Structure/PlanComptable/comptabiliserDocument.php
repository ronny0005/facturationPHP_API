<?php
$objet = new ObjetCollector();
$protected = 0;
$val=0;
$action=0;
$module=0;
if(isset($_GET["action"])) $action = $_GET["action"];
if(isset($_GET["module"])) $module = $_GET["module"];

if(isset($_GET["type"])) $val=$_GET["type"];
$protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);

?>
<script src="js/jquery.dynatable.js?d=<?php echo time(); ?>" type="text/javascript"></script>
<script src="js/Structure/Comptabilite/script_comptabiliserDocument.js?d=<?php echo time(); ?>"></script>
<section class="enteteMenu bg-light p-2 mb-3">
    <h3 class="text-center text-uppercase">
        Comptabiliser Document
    </h3>
</section>

<?php
if(isset($_POST["valider"])){
    $compta = ($_POST["Comptabiliser"] == "comptabiliser") ? "comptabilisé" : "décomptabilisé";
    echo "<div class='alert alert-success'>Le document {$_POST["DO_Piece"]} a bien été $compta !</div>";
}
?>
<input type="hidden" id="mdp" value="<?php echo $_SESSION["mdp"]; ?>"/>
<input type="hidden" id="login" value="<?php echo $_SESSION["login"]; ?>"/>


<fieldset class="entete card p-3">
    <legend class="entete">Comptabiliser</legend>
    <form action="indexMVC.php?module=9&action=21" method="POST">
        <input type="hidden" value="<?= $module; ?>" name="module"/>
        <input type="hidden" value="<?= $action; ?>" name="action"/>
        <div class="row">
            <div class="col-6 col-sm-2">
                <label>Option</label>
                <select class="form-control" name="Comptabiliser" id="Comptabiliser">
                    <option value="decomptabiliser">Décomptabiliser</option>
                    <option value="comptabiliser">Comptabiliser</option>
                </select>
            </div>
            <div class="col-6 col-sm-2">
                <label>Type de document</label>
                <select class="form-control" name="TypeDocument" id="TypeDocument">
                    <option value="Vente">Vente</option>
                    <option value="Achat">Achat</option>
                </select>
            </div>
            <div class="col-6 col-sm-2">
                <label>N° Piece</label>
                <input type="text" value="" name="DO_Piece" id="DO_Piece" class="form-control"/>
            </div>
        </div>
        <div class="row pt-3">
            <div class="col-12">
                <input type="submit" name="valider" value="Valider" class="btn btn-primary w-100" />
            </div>
        </div>
    </form>
</fieldset>
