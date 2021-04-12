<?php
    $objet = new ObjetCollector();   
    $depot=$_SESSION["DE_No"];  
    $protected = 0;
    $val=0;
    $action=0;
    $module=0;
    $exercice = 0;
    $codeJournal = 0;
    $codeMois = 0;
    $annee_exercice=0;
    if(isset($_GET["annee_exercice"]))
        $annee_exercice = $_GET["annee_exercice"];
    if(isset($_GET["codeJournal"]))
        $codeJournal = $_GET["codeJournal"];
    if(isset($_GET["codeMois"]))
        $codeMois = $_GET["codeMois"];
    if(isset($_GET["action"]))
        $action = $_GET["action"];
    if(isset($_GET["module"]))
        $module = $_GET["module"];

    if(isset($_GET["type"])) $val=$_GET["type"];

    $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"],$objet->db);

?>
<script src="js/jquery.dynatable.js?d=<?php echo time(); ?>" type="text/javascript"></script>
<script src="js/Structure/Comptabilite/script_listeJournaux.js?d=<?php echo time(); ?>"></script>
        <section class="enteteMenu bg-light p-2 mb-3">
            <h3 class="text-center text-uppercase">
                Saisie comptable
            </h3>
        </section>
<div class="corps">        
        <input type="hidden" id="mdp" value="<?php echo $_SESSION["mdp"]; ?>"/>
        <input type="hidden" id="login" value="<?php echo $_SESSION["login"]; ?>"/>
   
     <div class="col-md-12">

<fieldset class="entete">
<legend class="entete">Journaux</legend>
<div class="form-group">
<form id="filter" action="indexMVC.php?module=9&action=13" method="GET">
    <div>
        <div class="row">
            <div class="col-lg-2">
                <select class="form-control"  id='annee_exercice' name='annee_exercice'>
                    <?php
                    $rows = $protection->annee_exercice();
                    if($annee_exercice == 0)
                        $annee_exercice = $rows[0]->ANNEE_EXERCICE;
                    foreach ($rows as $row){
                        echo "<option value='{$row->ANNEE_EXERCICE}' ";
                        if($annee_exercice==$row->ANNEE_EXERCICE) echo " selected";
                        echo ">{$row->ANNEE_EXERCICE}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-lg-2">
                    <input type="hidden" value="<?php echo $module; ?>" name="module"/>
                    <input type="hidden" value="<?php echo $action; ?>" name="action"/>
                    <select name="type" id="type" class="form-control">
                        <option value="0" <?php if($val==0) echo " selected "; ?>>Tous</option>
                        <option value="1" <?php if($val==1) echo " selected "; ?>>Ouvert</option>
                        <option value="2" <?php if($val==2) echo " selected "; ?>>Non ouvert</option>
                    </select>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2">
                <label>Journal</label>
                <select class="form-control" name="codeJournal" id="codeJournal">
                    <option value="0"></option>
                    <?php
                    $journal = new JournalClass(0);
                    $rows=$journal->getJournauxSaisieSelect($val,0,1);
                    if($rows!=null){
                        foreach ($rows as $row){
                            echo "<option value='{$row->JO_Num}' ";
                            if($codeJournal === $row->JO_Num) echo " selected ";
                            echo ">{$row->JO_Num}</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-lg-2">
                <label>Mois</label>
                <select class="form-control" name="codeMois" id="codeMois">
                    <option value="0"></option>
                    <?php
                    $journal = new JournalClass(0);
                    $rows=$journal->getJournauxSaisieSelect($val,1,0);
                    if($rows!=null){
                        foreach ($rows as $row){
                            echo "<option value='{$row->NomMois}' ";
                            if($codeMois === $row->NomMois) echo "selected";
                            echo ">{$row->NomMois}</option>";
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3" style="margin-top: 10px;margin-bottom: 10px">
                <input class="btn btn-primary" type="submit" value="Filtrer" name="filtre" id="filtre" />
            </div>
        </div>
    </div>
        </form>
</table>
<div class="err" id="add_err"></div>

<table id="tableJournal" class="table table-striped">
    <thead>
        <th style="display:none"></th>
        <th>Période</th>
        <th>Code</th>
        <th>Intitulé du journal</th>
    </thead>
    <tbody>
        <?php
            $rows = $journal->getJournauxSaisie($val,$codeMois,$codeJournal,$annee_exercice);
            foreach ($rows as $row){
            $val = '0'.$row->MonthNumber;
            $val = substr($val, -2);
            echo " <tr class='article' id='compte_{$row->JO_Num}'>
                        <td style='display: none'>{$row->MonthNumber}</td>
                        <td>{$row->NomMois}</td>
                        <td><a href='indexMVC.php?module=9&action=14&JO_Num={$row->JO_Num}&exercice={$annee_exercice}{$val}'>{$row->JO_Num}</a></td>
                        <td>{$row->JO_Intitule}</td>
                    </tr>";
        }
      ?>
    </tbody>
</table>
</div>

   
</div>
 
</div>
