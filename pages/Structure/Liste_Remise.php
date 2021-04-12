<?php
    $objet = new ObjetCollector();   
    $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
    $flagProtected = $protection->protectedType("remise");
    $flagSuppr = $protection->SupprType("remise");
    $flagNouveau = $protection->NouveauType("remise");

?>
<script src="js/jquery.dynatable.js?d=<?php echo time(); ?>" type="text/javascript"></script>
<script src="js/script_listeRemise.js?d=<?php echo time(); ?>"></script>

<section class="enteteMenu bg-light p-2 mb-3">
    <h3 class="text-center text-uppercase">
        Rabais remise et ristournes
    </h3>
</section>
<div class="corps">        
        <input type="hidden" id="mdp" value="<?php echo $_SESSION["mdp"]; ?>"/>
        <input type="hidden" id="login" value="<?php echo $_SESSION["login"]; ?>"/>
   
     <div class="col-md-12">

<fieldset class="entete card p-3">
    <legend class="entete">Liste Rabais</legend>
<div class="form-group">
<form action="indexMVC.php?module=2&action=17" method="GET">
    <table style="margin-bottom: 20px;width:100%">
    <thead>
        <tr>
        <?php if($flagNouveau){ ?>
            <td style="float:right"><a href="indexMVC.php?module=3&action=19"><button type="button" id="nouveau" class="btn btn-primary">Nouveau</button></a></td> <?php } ?>
        </tr>
        </form>
</table>
<div class="err" id="add_err"></div>
<table id="table" class="table table-striped">
        <thead>
            <th>Intitulé</th>
            <?php if($flagSuppr) echo "<th></th>"; ?>
        </thead>
    <tbody id="liste_elt">
        <?php
        $rows = new F_TarifClass(0);
        $i=0;
        $classe="";
        if($rows->all()==null){
        }else{
            foreach ($rows->all() as $row){
            $i++;
            if($i%2==0) $classe = "info";
                    else $classe="";
            echo "<tr class='elt $classe' id='elt_{$row->TF_No}'>";
                        echo "<td><a href='indexMVC.php?module=3&action=19&cbMarq={$row->cbMarq}'>{$row->TF_Intitule}</a></td>";
                    if($flagSuppr) echo "<td><a href='Traitement\Creation.php?acte=suppr&TF_No={$row->TF_No}' onclick=\"if(window.confirm('Voulez-vous vraiment supprimer {$row->TF_Intitule} ?')){return true;}else{return false;}\"><i class='fa fa-trash-o'></i></a></td>";
                    echo "</tr>";
            }
        }
//      ?>
</tbody>
</table>
 </div>   
</div>
 
</div>
