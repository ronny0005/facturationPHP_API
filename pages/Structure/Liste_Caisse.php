<?php
    $objet = new ObjetCollector();   
    $depot=$_SESSION["DE_No"];

    $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
    $flagProtected = $protection->protectedType("caisse");
    $flagSuppr = $protection->SupprType("caisse");
    $flagNouveau = $protection->NouveauType("caisse");
?>
<script src="js/jquery.dynatable.js?d=<?php echo time(); ?>" type="text/javascript"></script>
<script src="js/script_listeCaisse.js?d=<?php echo time(); ?>"></script>

<section class="enteteMenu bg-light p-2 mb-3">
    <h3 class="text-center text-uppercase">Liste caisse</h3>
</section>
<div class="corps">        
        <input type="hidden" id="mdp" value="<?php echo $_SESSION["mdp"]; ?>"/>
        <input type="hidden" id="login" value="<?php echo $_SESSION["login"]; ?>"/>
   
     <div class="col-md-12">

<fieldset class="entete card p-3">
    <legend class="entete">Liste caisse</legend>
<div class="form-group">
<form action="indexMVC.php?module=2&action=2" method="GET">
    <table class="table table-striped">
    <thead>
        <tr>
        <?php if($flagNouveau){ ?>
            <td style="float:right"><a href="indexMVC.php?module=3&action=15"><button type="button" id="nouveau" class="btn btn-primary">Nouveau</button></a></td> <?php } ?>
        </tr>
        </form>
</table>
<div class="err" id="add_err"></div>
<table id="table" class="table table-striped">
        <thead>
            <th>Intitulé</th>
            <?php if($flagSuppr) echo "<th></th>"; ?>
        </thead>
    <tbody id="liste_depot">
        <?php
        
        $objet = new ObjetCollector(); 
        $result=$objet->db->requete($objet->caisse());     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $classe="";
        if($rows==null){
            echo "<tr><td>Aucun élément trouvé ! </td></tr>";
        }else{
            foreach ($rows as $row){
            $i++;
            if($i%2==0) $classe = "info";
                    else $classe="";
            echo "<tr class='article $classe' id='article_{$row->CA_No}'>
                    <td><a href='indexMVC.php?module=3&action=15&CA_No=$row->CA_No'>{$row->CA_Intitule}</a></td>";
                    if($flagSuppr) echo "<td><a href='Traitement\Depot.php?acte=suppr&CA_No={$row->CA_No}' onclick=\"if(window.confirm('Voulez-vous vraiment supprimer ".$row->CA_Intitule." ?')){return true;}else{return false;}\"><i class='fa fa-trash-o'></i></a></td>";
                    echo "</tr>";
            }
        }
      ?>
</tbody>
</table>
 </div>   
</div>
 
</div>
