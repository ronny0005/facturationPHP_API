<?php
    $objet = new ObjetCollector();
    $protection = new ProtectionClass("","");
    $soucheClass = $protection->getSoucheVente();
    $reglement = new ReglementClass(0);
    $message=0;
    if(isset($_POST["dateCloture"])){
        $reglement->clotureComptable($objet->getDate($_POST["dateCloture"]),$_POST["journalDebut"],$_POST["journalFin"],$_SESSION["id"],$_POST["type"]);
        $message=1;
    }
?>
<script src="js/jquery.dynatable.js?d=<?= time(); ?>" type="text/javascript"></script>
<script src="js/Structure/Comptabilite/script_clotureComptable.js?d=<?= time(); ?>"></script>
</head>

<body>
<section class="enteteMenu bg-light p-2 mb-3">
    <h3 class="text-center text-uppercase">Cloture comptable</h3>
</section>

<div class="corps">        
    <input type="hidden" id="mdp" value="<?php echo $_SESSION["mdp"]; ?>"/>
    <input type="hidden" id="login" value="<?php echo $_SESSION["login"]; ?>"/>
<?php
if($message!=0)
    echo "<div class='alert alert-success'>L'opération a été réalisé avec succès !</div>";
?>
<form id="form-entete" class="form-horizontal" action="#" method="POST" >
    <div class="form-row">
        <div class="col-6 col-sm-6 col-md-6 col-lg-2">
            <label>Date</label>
            <input type="text" class="form-control" name="dateCloture" id="dateCloture" value="<?="" ?>" placeholder="Date"/>
        </div>
        <div class="col-6 col-sm-6 col-md-6 col-lg-2">
            <label>Heure</label>
            <input type="text" class="form-control" name="heureCloture" id="heureCloture" value="<?="" ?>" placeholder="Heure" readonly/>
        </div>
        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <label>Journal de </label>
            <select id="journalDebut" name="journalDebut" class="form-control">
                <option value='0'></option>
                <?php
                $isPrincipal = 0;
                $journal = new JournalClass(0);
                $rows = $journal->getJournaux(1);
                foreach($rows as $row) {
                    echo "<option value='{$row->JO_Num}'>{$row->JO_Intitule}</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <label>à</label>
            <select id="journalFin" name="journalFin" class="form-control">
                <option value='0'></option>
                <?php
                $journal = new JournalClass(0);
               $rows = $journal->getJournaux(1);
                foreach($rows as $row) {
                    echo "<option value='{$row->JO_Num}'>{$row->JO_Intitule}</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-6 col-sm-6 col-md-6 col-lg-2">
            <label>Type</label>
            <select name="type" id="type" class="form-control">
                <option value="1">Clôturer</option>
                <?php
                if($protection->PROT_AFFICHAGE_VAL_CAISSE==0) {
                    ?>
                    <option value="0">Déclôturer</option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>

    <div class="row">
        <label>&nbsp;</label>
        <div class="col-12 col-sm-12 col-md-12 col-lg-2 mt-3">
            <input type="submit" name="valide" id="valide" value="Valider" class="w-100 btn btn-primary"/>
        </div>
    </div>
</form>
