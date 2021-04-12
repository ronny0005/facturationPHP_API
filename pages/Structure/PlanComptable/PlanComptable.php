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
    $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
    $compteg = new CompteGClass(0,$objet->db);

?>
<script src="js/jquery.dynatable.js?d=<?php echo time(); ?>" type="text/javascript"></script>
<script src="js/Structure/Comptabilite/script_listePlanComptable.js?d=<?php echo time(); ?>"></script>
<section class="enteteMenu bg-light p-2 mb-3">
    <h3 class="text-center text-uppercase">
        Plan comptable
    </h3>
</section>
        <input type="hidden" id="mdp" value="<?php echo $_SESSION["mdp"]; ?>"/>
        <input type="hidden" id="login" value="<?php echo $_SESSION["login"]; ?>"/>


<fieldset class="entete card p-3">
<legend class="entete">Liste des plan comptables</legend>
    <form action="indexMVC.php?module=9&action=1" method="GET">
        <input type="hidden" value="<?= $module; ?>" name="module"/>
        <input type="hidden" value="<?= $action; ?>" name="action"/>
        <div class="form-row">
            <div class="col-xs-10 col-sm-8 col-md-8 col-lg-3">
        <select name="type" id="type" class="form-control" style="">
                    <option value="0" <?= ($val==0) ? " selected ":""; ?>>Tout les comptes généraux</option>
                    <option value="1" <?= ($val==1) ? " selected ":""; ?>>Comptes généraux actifs</option>
                    <option value="2" <?= ($val==2) ? " selected ":""; ?>>Compte généraux mis en sommeil</option>
                </select>
        </div>
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-3">
            <input class="btn btn-primary" type="submit" value="Filtrer" name="filtre" id="filtre" />
        </div>
            <?php if($protected!=1){ ?>
                <div class="form-row">
                    <div class="col-xs-12  col-sm-2 col-md-2 col-lg-6 text-right">
                        <a href="indexMVC.php?module=9&action=2"><button type="button" id="nouveau" class="btn btn-primary">Nouveau</button></a>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </form>
<div class="err" id="add_err"></div>

<table id="table" class="table table-striped">
    <thead>
            <th>Numéro</th>
            <th>Intitulé de compte</th>
            <th></th>
    </thead>
    <tbody id="liste_planComptable">
        <?php
            foreach ($compteg->all() as $row){
            ?>
                <tr class="article" id="compte_<?=$row->CG_Num ?>">
                    <td>
                        <a href="indexMVC.php?module=9&action=2&CG_Num=<?= $row->CG_Num ?>"><?= $row->CG_Num ?></a>
                    </td>
                    <td><?= $row->CG_Intitule ?></td>
                    <td>
                        <a href="Traitement\Structure\Comptabilite\PlanComptable.php?CG_Num=<?= $row->CG_Num?>&acte=suppr" onclick="if(window.confirm('Voulez-vous vraiment supprimer <?=$row->CG_Num ?>?')){return true;}else{return false;}">
                            <i class='fa fa-trash-o'></i>
                        </a>
                    </td>
                </tr>
            <?php
            }
      ?>
    </tbody>
</table>
