<?php
    $objet = new ObjetCollector();
    $result = $objet->db->requete($objet->getSoucheVente());
    $soucheClass = $result->fetchAll(PDO::FETCH_OBJ);
    $caisseClass = new CaisseClass(0,$objet->db);
    $message=0;
    if(isset($_POST["dateCloture"])){
        $caisseClass->clotureCaisse($objet->getDate($_POST["dateCloture"]),$_POST["caisseDebut"],$_POST["caisseFin"],$_SESSION["id"],$_POST["type"]);
        $message=1;
    }
?>
<script src="js/jquery.dynatable.js?d=<?= time(); ?>" type="text/javascript"></script>
<script src="js/Structure/Comptabilite/script_clotureCaisse.js?d=<?= time(); ?>"></script>
</head>

<body>
<section class="enteteMenu bg-light p-2 mb-3">
    <h3 class="text-center text-uppercase">Cloture de caisse</h3>
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
            <label>Caisse de </label>
            <select id="caisseDebut" name="caisseDebut" class="form-control">
                <?php
                $isPrincipal = 0;

                $caisse = new CaisseClass(0);
                if($admin==0){
                    $isPrincipal = 1;
                    $rows = $caisse->getCaisseDepot($_SESSION["id"]);
                }else{
                    $rows = $caisse->listeCaisseShort();
                }
                if($rows==null){
                }else{
                    if(sizeof($rows)>1)
                        echo "<option value='0'></option>";

                    foreach($rows as $row) {
                        if ($isPrincipal == 0) {
                            echo "<option value='{$row->CA_No}'>{$row->CA_Intitule}</option>";
                        } else {
                            if ($row->IsPrincipal != 0 ) {
                                echo "<option value='{$row->CA_No}'>{$row->CA_Intitule}</option>";
                            }
                        }
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <label>à</label>
            <select id="caisseFin" name="caisseFin" class="form-control">
                <?php
                $isPrincipal = 0;

                $caisse = new CaisseClass(0);
                if($admin==0){
                    $isPrincipal = 1;
                    $rows = $caisse->getCaisseDepot($_SESSION["id"]);
                }else{
                    $rows = $caisse->listeCaisseShort();
                }
                if($rows==null){
                }else{
                    if(sizeof($rows)>1)
                        echo "<option value='0'></option>";

                    foreach($rows as $row) {
                        if ($isPrincipal == 0) {
                            echo "<option value='{$row->CA_No}'>{$row->CA_Intitule}</option>";
                        } else {
                            if ($row->IsPrincipal != 0 ) {
                                echo "<option value='{$row->CA_No}'>{$row->CA_Intitule}</option>";
                            }
                        }
                    }
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

    <fieldset class="card p-3">
        <legend>Génération des factures</legend>
        <div class="row">
            <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                <label>Souche des factures générées</label>
                <select id="soucheGenere" name="soucheGenere" class="form-control">
                    <?php
                    foreach($soucheClass as $row){
                        ?>
                        <option value="<?=$row->cbIndice ?>"><?= $row->S_Intitule ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                <label>Premier numéro</label>
                <input type="text" class="form-control" name="premierNumero" id="premierNumero" value="<?="" ?>" />
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                <label>Regroupements tickets</label>
                <select id="regrTicket" name="regrTicket" class="form-control">
                    <option value="1">Par jour</option>
                    <option value="2">Par semaine</option>
                    <option value="3">Par quinzaine</option>
                    <option value="4">Par mois</option>
                    <option value="5">Une facutre par ticket</option>
                </select>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                <label>Regroupements réglements</label>
                <select id="regrReglt" name="regrReglt" class="form-control">
                    <option value="1">Aucun regroupement</option>
                    <option value="2">Regrouper les espèces uniquement</option>
                    <option value="3">Regrouper tout les mode de règlements</option>
                </select>
            </div>
        </div>
        <div class="row">
            <label>&nbsp;</label>
            <div class="col-12 col-sm-12 col-md-12 col-lg-2 mt-3">
                <input type="submit" name="valide" id="valide" value="Valider" class="w-100 btn btn-primary"/>
            </div>
        </div>
    </fieldset>
</form>
