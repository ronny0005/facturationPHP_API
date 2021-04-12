<?php
    $objet = new ObjetCollector();   
    $depot=$_SESSION["DE_No"];  
    $protected = 0;
    $val=0;
    $action=0;
    $module=0;
    if(isset($_GET["action"])) $action = $_GET["action"];
    if(isset($_GET["module"])) $module = $_GET["module"];

    if(isset($_GET["type"])) $val=$_GET["type"];
    $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"],$objet->db);
?>
<script src="js/jquery.dynatable.js?d=<?= time(); ?>" type="text/javascript"></script>
<script src="js/Structure/Comptabilite/script_majComptable.js?d=<?= time(); ?>"></script>

<div id="loading" class="spinner-border" style="display: none">
    <span class="sr-only">Loading...</span>
</div>

<fieldset class="card p-3 mb-2">
    <legend class="text-center text-uppercase bg-light p-2"> Mise à jour Comptable </legend>
        <input type="hidden" id="mdp" value="<?= $_SESSION["mdp"]; ?>"/>
        <input type="hidden" id="login" value="<?= $_SESSION["login"]; ?>"/>

    <form id="form-entete" class="form-horizontal" action="majComptable" method="GET" >

    <div class="form-row">
        <div class="col-12 col-sm-4 col-md-4 col-lg-3">
            <label>Transfert : </label>
            <select name="typeTransfert" id="typeTransfert" class="form-control">
                <option value="1">Facture des ventes</option>
                <option value="2">Facture des achats</option>
                <option value="3">Règlement des ventes</option>
                <option value="4">Règlement des achats</option>
                <option value="5">Engagement des ventes</option>
                <option value="6">Engagement des achats</option>
            </select>
        </div>
        <div class="col-6 col-sm-2 col-md-2 col-lg-3">
            <label>Période : </label>
            <input type="text" class="form-control" id="datedebut" name="datedebut" placeholder="Date début" value=""/>
        </div>
        <div class="col-6 col-sm-2 col-md-2 col-lg-3">
            <label>à</label>
            <input type="text" class="form-control" id="datefin" name="datefin" placeholder="Date fin" value=""/>
        </div>
        <div class="col-6 col-sm-2 col-md-2 col-lg-3">
            <label>N° de fact.: </label>
            <input type="text" class="form-control" id="facturedebut" name="facturedebut" value=""/>
        </div>
        <div class="col-6 col-sm-2 col-md-2 col-lg-3">
        <label>à</label>
            <input type="text" class="form-control" id="facturefin" name="facturefin" value=""/>
        </div>
        <div class="col-6 col-md-2 col-sm-2 col-lg-3">
            <label>Souche : </label>
            <select class="form-control" id="souche" name="souche">
                <option value="-1">Toutes</option>
                <?php
                $result=$objet->db->requete($objet->getSoucheVente());
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if($rows==null){
                }else{
                    foreach($rows as $row){
                        echo "<option value='{$row->cbIndice}'";
                        echo ">{$row->S_Intitule}</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-6 col-md-3 col-sm-4 col-lg-3">
            <label>Etat des pièces : </label>
            <select name="transfert" id="transfert" class="form-control">
                <option value="2">Non Comptabilisées</option>
                <option value="1">Comptabilisées</option>
            </select>
        </div>
        <div class="col-6 col-md-3 col-sm-3 col-lg-3">
            <label>Caisse : </label>
            <select class="form-control" id="caisse" name="caisse">
                <option value="0">Toutes les caisses</option>
                <?php
                $caisse = new CaisseClass(0);
                foreach($caisse->all()  as $row){
                    echo "<option value='{$row->CA_No}'";
                    echo ">{$row->CA_Intitule}</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-6 col-md-2 col-sm-3 col-lg-3">
            <label>Cat. Comptable: </label>
            <select class="form-control" id="catCompta" name="catCompta">
                <option value="0">Toutes</option>
                <?php
                $result=$objet->db->requete($objet->getCatCompta());
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if($rows==null){
                }else{
                    foreach($rows as $row){
                        echo "<option value='{$row->idcompta}'";
                        echo ">{$row->marks}</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-6 col-md-2 col-sm-4 col-lg-3">
            <label>Devise export: </label>
            <select class="form-control" id="devise" name="devise">
                <option value="-1">Tenue commerciale</option>
                <option value="0">Tenue comptabilité</option>
                <?php
                $result=$objet->db->requete($objet->getDevise());
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if($rows==null){
                }else{
                    foreach($rows as $row){
                        echo "<option value={$row->cbIndice}";
                        echo ">{$row->D_Intitule}</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-6 col-md-4 col-sm-4 col-lg-3">
            <label>Code journal: </label>
            <select class="form-control" id="soucheJournal" name="soucheJournal">
                <option value="0">Toutes</option>
                <?php
                $result=$objet->db->requete($objet->getSoucheVente());
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if($rows==null){
                }else{
                    foreach($rows as $row){
                        echo "<option value='{$row->cbIndice}'";
                        echo ">{$row->S_Intitule}</option>";
                    }
                }
                ?>
            </select>
            <select class="form-control" id="journal" name="journal">
                <option value="0">Toutes</option>
                <?php
                $journal = new JournalClass(0,$objet->db);
                foreach($journal->getJournaux(1) as $row){
                    echo "<option value='{$row->JO_Num}'";
                    echo ">{$row->JO_Intitule}</option>";
                }
                ?>
            </select>
        </div>
    </div>
        <div class="col-12 col-md-2 col-sm-2 col-lg-2 mt-3">
            <input type="button" class="btn btn-primary w-100" id="majCompta" value="Valider"/>
        </div>
    </form>
</fieldset>
