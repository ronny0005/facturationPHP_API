<?php
    $objet = new ObjetCollector();   
    $depot=$_SESSION["DE_No"];
    $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
    $flagProtected = $protection->protectedType("famille");
    $flagSuppr = $protection->SupprType("famille");
    $flagNouveau = $protection->NouveauType("famille");

?>
<script src="js/jquery.dynatable.js?d=<?php echo time(); ?>" type="text/javascript"></script>
<script src="js/script_listeFamille.js?d=<?php echo time(); ?>"></script>
</head>

<body>

<section class="enteteMenu bg-light p-2 mb-3">
    <h3 class="text-center text-uppercase">Liste Famille</h3>
</section>

<div class="corps">        
        <input type="hidden" id="mdp" value="<?php echo $_SESSION["mdp"]; ?>"/>
        <input type="hidden" id="login" value="<?php echo $_SESSION["login"]; ?>"/>
   
     <div class="col-md-12">

<fieldset class="entete card">
<legend class="entete">Liste famille</legend>

<div class="form-group">
<form action="indexMVC.php?module=2&action=2" method="GET">
    <table style="margin-bottom: 20px;width:100%">
    <thead>
        <tr>
            <?php if($flagNouveau){ ?>
                <td style="float:right"><a href="indexMVC.php?module=3&action=7"><button type="button" id="nouveau" class="btn btn-primary">Nouveau</button></a></td><?php } ?>
        </tr>
        </form>
</table>
<div class="err" id="add_err"></div>
<table id="table" class="table table-striped">
    <thead>
            <th>Code</th>
            <th>Intitulé</th>
            <?php if($flagSuppr) echo "<th></th>"; ?>
    </thead>
    <tbody id="liste_article">
        <?php
        $objet = new ObjetCollector();
        $familleClass = new FamilleClass(0);
        $rows = $familleClass->getShortList();
        $i=0;
        $classe="";
        if($rows==null){
            echo "<tr><td>Aucun élément trouvé ! </td></tr>";
        }else{
            foreach ($rows as $row){
            $i++;
            if($i%2==0) $classe = "info";
                    else $classe="";
            echo "<tr class='article $classe' id='article_{$row->FA_CodeFamille}'>
                    <td><a href='indexMVC.php?module=3&action=7&FA_CodeFamille={$row->FA_CodeFamille}'>{$row->FA_CodeFamille}</a></td>
                    <td>{$row->FA_Intitule}</td>";
                    if($flagSuppr) echo "<td><a href='Traitement\Creation.php?acte=suppr_famille&FA_CodeFamille={$row->FA_CodeFamille}' onclick=\"if(window.confirm('Voulez-vous vraiment supprimer {$row->FA_CodeFamille} ?')){return true;}else{return false;}\"><i class='fa fa-trash-o'></i></a></td>";
                    echo "</tr>";
            }
        }
      ?>
</tbody>
</table>
 </div>

   
</div>
 
</div>
