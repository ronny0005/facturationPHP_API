<?php
    $objet = new ObjetCollector();   
    $depot=$_SESSION["DE_No"];
    $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
    $flagProtected = $protection->protectedType("depot");
    $flagSuppr = $protection->SupprType("depot");
    $flagNouveau = $protection->NouveauType("depot");

?>
<script src="js/jquery.dynatable.js?d=<?php echo time(); ?>" type="text/javascript"></script>
<script src="js/script_listeDepot.js?d=<?php echo time(); ?>"></script>
</head>
<body>

<section class="enteteMenu bg-light p-2 mb-3">
    <h3 class="text-center text-uppercase">Liste depot</h3>
</section>

        <div class="corps">
        <input type="hidden" id="mdp" value="<?php echo $_SESSION["mdp"]; ?>"/>
        <input type="hidden" id="login" value="<?php echo $_SESSION["login"]; ?>"/>
   
     <div class="col-md-12">

<fieldset class="entete card p-3">
    <legend class="entete">Liste dépôt</legend>
<div class="form-group">
<form action="indexMVC.php?module=2&action=2" method="GET">
    <table style="margin-bottom: 20px;width:100%">
    <thead>
        <tr>
        <?php if($flagNouveau){ ?>
            <td style="float:right"><a href=indexMVC.php?module=3&action=11"><button type="button" id="nouveau" class="btn btn-primary">Nouveau</button></a></td> <?php } ?>
        </tr>
        </form>
</table>
<div class="err" id="add_err"></div>
<table id="table" class="table table-striped">
        <thead style="background-color: #dbdbed;">
            <th>Intitulé</th>
            <th>Code postal</th>
            <th>Ville</th>
            <?php if($flagSuppr) echo "<th></th>"; ?>
        </thead>
    <tbody id="liste_depot">
        <?php
        
        $objet = new ObjetCollector(); 
        $result=$objet->db->requete($objet->depot());     
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
            echo "<tr class='article $classe' id='article_".$row->DE_No."'>"
                    . "<td><a href='indexMVC.php?module=3&action=11&DE_No=$row->DE_No'>".$row->DE_Intitule."</a></td>"
                    . "<td>".$row->DE_CodePostal."</td>"
                    . "<td>".$row->DE_Ville."</td>";
                    if($flagSuppr) echo "<td><a href='Traitement\Depot.php?acte=suppr&DE_No=".$row->DE_No."' onclick=\"if(window.confirm('Voulez-vous vraiment supprimer ".$row->DE_Intitule." ?')){return true;}else{return false;}\"><i class='fa fa-trash-o'></i></a></td>";
                    echo "</tr>";
            }
        }
//      ?>
</tbody>
</table>
 </div>   
</div>
 
</div>
