<script src="js/scriptCombobox.js?d=<?php echo time(); ?>"></script>
<script src="js/caisse/transfertCaisse.js?d=<?php echo time(); ?>"></script>
<script type="text/javascript" src="js/jquery.js?d=<?php echo time(); ?>"></script>

</head>
</head>
<body>    
<?php
include("module/Menu/BarreMenu.php");

$caisse = new CaisseClass(0);
if($admin==1)
    $rows = $caisse->all();
else
    $rows = $caisse->getCaisseDepot($_SESSION["id"]);

if(isset($_POST["CA_NoSource"])){
    $caisseSource = new CaisseClass($_POST["CA_NoSource"]);
    $caisseDest = new CaisseClass($_POST["CA_NoDest"]);
    $reglement = new ReglementClass(0);
    $reglement->addReglement("",$caisseSource->JO_Num,null,null,$caisseSource->CA_No,0,$_POST["libelle"],$caisseSource->CO_NoCaissier,$_POST["date"],4,$_POST["montant"],0,2);
    $reglement->addReglement("",$caisseDest->JO_Num,null,null,$caisseDest->CA_No,0,$_POST["libelle"],$caisseDest->CO_NoCaissier,$_POST["date"],5,$_POST["montant"],0,2);
}
?>
    <div id="milieu">    
        <div class="container">
    
<div class="container clearfix">
    <h4 id="logo" style="text-align: center;background-color: #eee;padding: 10px;text-transform: uppercase">
        <?php echo $texteMenu; ?>
    </h4>

<form name="form" id="form" action="#" method="POST">
<div class="row">
    <div class="col-sm-2">
        <label>Caisse source</label>
        <select name="CA_NoSource" id="CA_NoSource" class="form-control">
            <?php
            foreach($rows as $row)
                echo "<option value='{$row->CA_No}'>{$row->CA_Intitule}</option>";
            ?>
        </select>
    </div>
    <div class="col-sm-2">
        <label>Caisse destinataie</label>
        <select name="CA_NoDest" id="CA_NoDest" class="form-control">
            <?php
            foreach($rows as $row)
                echo "<option value='{$row->CA_No}'>{$row->CA_Intitule}</option>";
            ?>
        </select>
    </div>
    <div class="col-sm-4">
        <label>Date</label>
        <input type="text" class="form-control" name="date" id="date" value="">
    </div>
    <div class="col-sm-4">
        <label>Libellé</label>
        <input type="text" class="form-control" name="libelle" id="libelle" value="" placeholder="Libellé">
    </div>
    <div class="col-sm-4">
        <label>Montant</label>
        <input type="text" class="form-control" name="montant" id="montant" value="" placeholder="Montant">
    </div>
    <input type="button" id="valide" class="btn btn-primary" name="valide" value="valide"/>
</div>
</form>