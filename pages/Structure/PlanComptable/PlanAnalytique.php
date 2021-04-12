<?php
    $objet = new ObjetCollector();   
    $depot=$_SESSION["DE_No"];  
    $protected = 0;
    $val=0;
    $n_anal=1;
    $action=0;
    $module=0;
    if(isset($_GET["action"])) $action = $_GET["action"];
    if(isset($_GET["module"])) $module = $_GET["module"];

    if(isset($_GET["type"])) $val=$_GET["type"];
    if(isset($_GET["N_Analytique"])) $n_anal=$_GET["N_Analytique"];
    $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"],$objet->db);
?>
<script src="js/jquery.dynatable.js?d=<?php echo time(); ?>" type="text/javascript"></script>
<script src="js/Structure/Comptabilite/script_listePlanAnalytique.js?d=<?php echo time(); ?>"></script>

        <section class="enteteMenu bg-light p-2 mb-3">
            <h3 class="text-center text-uppercase">
                Plan analytique
            </h3>
        </section>
<div class="corps">        
        <input type="hidden" id="mdp" value="<?php echo $_SESSION["mdp"]; ?>"/>
        <input type="hidden" id="login" value="<?php echo $_SESSION["login"]; ?>"/>
   
     <div class="col-md-12">

<fieldset class="entete card p-3">
<legend class="entete">Liste des plan analytiques</legend>
<div class="form-group">
<form action="indexMVC.php?module=9&action=3" method="GET" name="listePlanAnal" id="listePlanAnal">
    <table style="margin-bottom: 20px;width:100%">
    <thead>
        <tr>
            <?php if($protected!=1){ ?><td style="float:right"><a href="indexMVC.php?module=9&action=4&N_Analytique=<?php echo $n_anal; ?>" ><button type="button" id="nouveau" class="btn btn-primary">Nouveau</button></a></td> <?php } ?>
        </tr>
        <tr>
            <td>
                <input type="hidden" value="<?php echo $module; ?>" name="module"/>
                <input type="hidden" value="<?php echo $action; ?>" name="action"/>
                <select name="type" id="type" class="form-control" style="width: 200px">
                    <option value="0" <?php if($val==0) echo " selected "; ?>>Tout les sections</option>
                    <option value="1" <?php if($val==1) echo " selected "; ?>>Sections actives</option>
                    <option value="2" <?php if($val==2) echo " selected "; ?>>Sections mises en sommeil</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <select class="form-control" id="N_Analytique" name="N_Analytique" style="width: 200px">
                    <?php
                        $result=$objet->db->requete($objet->getListeTypePlan());
                        $rows = $result->fetchAll(PDO::FETCH_OBJ);
                        if($rows==null){
                        }else{
                            foreach($rows as $row){
                                echo "<option value={$row->cbIndice}'";
                                if($row->cbIndice == $n_anal) echo " selected ";
                                echo ">{$row->A_Intitule}</option>";
                            }
                        }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><input class="btn btn-primary" type="submit" value="Filtrer" name="filtre" id="filtre" /></td>
        </tr>
        </form>
</table>
<div class="err" id="add_err"></div>
<table id="table" class="table table-striped">
    <thead>
            <th>Numéro</th>
            <th>Intitulé de la section</th>
            <th></th>
    </thead>
    <tbody id="liste_planAnalytique">
        <?php
        $objet = new ObjetCollector();  
        $result=$objet->db->requete($objet->getPlanAnalytique($val,$n_anal));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $classe="";
        if($rows==null){
            echo "<tr><td>Aucun élément trouvé ! </td><td></td></tr>";
        }else{
            foreach ($rows as $row){
            echo "<tr class='article $classe' id='compte_{$row->CA_Num}'>
                    <td><a href='indexMVC.php?module=9&action=4&CA_Num={$row->CA_Num}&N_Analytique=$n_anal'>{$row->CA_Num}</a></td>
                    <td>{$row->CA_Intitule}</td>
                    <td><a href='Traitement\Structure\Comptabilite\PlanAnalytique.php?CA_Num={$row->CA_Num}&acte=suppr' onclick=\"if(window.confirm('Voulez-vous vraiment supprimer {$row->CA_Num}?')){return true;}else{return false;}\"><i class='fa fa-trash-o'></i></a></td>
                    </tr>";
            }
        }
      ?>
</tbody>
</table>
 </div>

   
</div>
 
</div>
