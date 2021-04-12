<?php
    $objet = new ObjetCollector();
    $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
    $flagProtected = $protection->protectedType("collaborateur");
    $flagSuppr = $protection->SupprType("collaborateur");
    $flagNouveau = $protection->NouveauType("collaborateur");
?>
<script src="js/jquery.dynatable.js?d=<?php echo time(); ?>" type="text/javascript"></script>
<script src="js/script_listeCollaborateur.js?d=<?php echo time(); ?>"></script>
</head>
<body>
    <section class="enteteMenu bg-light p-2 mb-3">
        <h3 class="text-center text-uppercase">
            Liste collaborateur
        </h3>
    </section>
<div class="corps">        
        <input type="hidden" id="mdp" value="<?php echo $_SESSION["mdp"]; ?>"/>
        <input type="hidden" id="login" value="<?php echo $_SESSION["login"]; ?>"/>
   
     <div class="col-md-12">

<fieldset class="entete card p-3">
    <legend class="entete">Liste collaborateur</legend>
<div class="form-group">
<form action="indexMVC.php?module=2&action=2" method="GET">
    <table style="margin-bottom: 20px;width:100%">
    <thead>
        <tr>
        <?php if($flagNouveau){ ?><td style="float:right"><a href="indexMVC.php?module=3&action=13"><button type="button" id="nouveau" class="btn btn-primary">Nouveau</button></a></td> <?php } ?>
        </tr>
        </form>
</table>
<div class="err" id="add_err"></div>
<table id="table" class="table table-striped table-bordered">
        <thead>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Fonction</th>
            <?php if($flagSuppr)  echo"<th></th>";?>
        </thead>
    <tbody id="liste_collaborateur" >
        <?php
        $collaborateur = new CollaborateurClass(0); 
        $rows = $collaborateur->all();
        $i=0;
        $classe="";
        if($rows==null){
            echo "<tr><td colspan='3'>Aucun élément trouvé ! </td></tr>";
        }else{
            foreach ($rows as $row){
            $i++;
            if($i%2==0) $classe = "info";
                    else $classe="";
            echo "<tr class='article $classe' id='article_{$row->CO_No}'>
                    <td><a href='indexMVC.php?module=3&action=13&CO_No={$row->CO_No}'>{$row->CO_Nom}</a></td>
                    <td>{$row->CO_Prenom}</td>
                    <td>{$row->CO_Fonction}</td>";
                    if($flagSuppr) 
						echo "<td>
								<a href='Traitement\Collaborateur.php?acte=suppr&CO_No=".$row->CO_No."' onclick=\"if(window.confirm('Voulez-vous vraiment supprimer ".$row->CO_Nom." ".$row->CO_Prenom." ?')){return true;}else{return false;}\">
							<i class='fa fa-trash-o'></i></a></td>";
                    echo "</tr>";
            }
        }
        ?>
</tbody>
</table>
 </div>   
</div>
</div>
