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
    $reglement = new ReglementClass(0,$objet->db);
    $valide = 0;

    $datedeb = date('dmy');
    $datefin = date('dmy');
$selectedStatut1 ="";
$selectedStatut0 ="";
$caNum="";
$caNumIntitule="";
    if(isset($_POST["action"])){
        $datedeb = $_POST["dateDeb"];
        $datefin = $_POST["dateFin"];
        if($_POST["statut"]==0){
            $selectedStatut1 ="";
            $selectedStatut0 =" selected ";
        }else{
            $selectedStatut0 ="";
            $selectedStatut1 =" selected ";
        }
        $caNum=$_POST["caNumIntitule"];
        $caNumIntitule=$_POST["caNumIntitule"];
        if($_POST["statut"]==0) {
            $rows = $reglement->getMajAnalytique($objet->getDate($datedeb), $objet->getDate($datefin),$_POST["statut"],$_POST["caNumIntitule"]);
            $reglement->setuserName("", "");
            $reglement->setMajAnalytique($objet->getDate($datedeb), $objet->getDate($datefin),$_POST["caNumIntitule"],$_SESSION["id"]);
            if (sizeof($rows) > 0)
                $valide = 1;
        }
    }
//$date = new DateTime($datedeb);

//var_dump($date->format('dmY'));
?>
<script src="js/jquery.dynatable.js?d=<?= time(); ?>" type="text/javascript"></script>
<script src="js/Structure/Comptabilite/script_majAnalytique.js?d=<?= time(); ?>"></script>


<section class="enteteMenu bg-light p-2 mb-3">
    <h3 class="text-center text-uppercase">Mise à jour Analytique</h3>
</section>
    <input type="hidden" id="mdp" value="<?= $_SESSION["mdp"]; ?>"/>
    <input type="hidden" id="login" value="<?= $_SESSION["login"]; ?>"/>
<?php
    if($valide==1)
        echo "<div class='alert alert-success'>La saisie analytique a bien été éfectuée !</div>";
?>

    <div id="nonComptabilisable" class="row alert alert-danger" style="display: none">

    </div>
<form id="form-entete" class="form-horizontal" action="majAnalytique" method="POST" >
    <div class="form-row mb-3">
        <div class="col-xs-6 col-sm-2 col-md-2 col-lg-2">
            <label>Date début</label>
            <input type="text" class="form-control" name="dateDeb" id="dateDeb" value="<?=$datedeb ?>" placeholder="Date début"/>
        </div>
        <div class="col-xs-6 col-sm-2 col-md-2 col-lg-2">
            <label>Date fin</label>
            <input type="text" class="form-control" name="dateFin" id="dateFin" value="<?=$datefin ?>" placeholder="Date fin"/>
        </div>
        <div class="col-xs-4 col-md-2 col-sm-2 col-lg-2">
            <label>Statut</label>
            <select class="form-control" name="statut" id="statut">
                <option value="0" <?= $selectedStatut0 ?>>Non</option>
                <option value="1" <?= $selectedStatut1 ?>>Oui</option>
            </select>
        </div>
        <div class="col-xs-8 col-md-4  col-sm-6 col-lg-4">
            <label>Compte analytique</label>
            <select class="form-control" name="caNumIntitule" id="caNumIntitule" >
                <option value="">Tout les comptes</option>
                <?php
                $comptea = new CompteaClass(0,$objet);
                $rows = $comptea->allSearch();
                foreach($rows as $row)
                    echo "<option value='{$row->CA_Num}'>{$row->text}</option>";
                ?>
            </select>
        </div>
        <div class="col-xs-12 col-md-2 col-lg-2 text-right">
            <label>&nbsp;</label>
            <input type="button" class="btn btn-primary"  name="rechercher" id="rechercher" value="rechercher" />
        </div>
        <input type="hidden" name="action" id="action" value="17" />
        <input type="hidden" name="module" id="module" value="9" />
    </div>


    <table class="mt-3 table table-striped">
        <thead>
            <tr>
                <th>N° Reglement</th>
                <th>Date opération</th>
                <th>Compte Générale</th>
                <th>Libellé</th>
                <th>Montant</th>
                <th>Caisse</th>
                <th></th>
                <th>N° Analytique</th>
                <th>Montant Analytique</th>
            </tr>
        </thead>
        <tbody id="listeTable">

        </tbody>
    </table>

    <div class="row">
        <div class="col-md-2">
            <input type="button" class="btn btn-primary" id="majCompta" name="majCompta" value="Comptabiliser"/>
        </div>
    </div>
</form>
