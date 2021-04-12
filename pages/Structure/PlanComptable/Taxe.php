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
    $result=$objet->db->requete($objet->connexionProctection($_SESSION["login"], $_SESSION["mdp"]));     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if($rows!=null){
        if($rows[0]->PROT_ARTICLE==1 || $rows[0]->PROT_ARTICLE==3) $protected = $rows[0]->PROT_ARTICLE;
    }
?>
<script src="js/jquery.dynatable.js?d=<?php echo time(); ?>" type="text/javascript"></script>
<script src="js/Structure/Comptabilite/script_listeTaxe.js?d=<?php echo time(); ?>"></script>
</head>

<body>    
<?php
include("module/Menu/BarreMenu.php");
?>
<div id="milieu">    
    <div class="container">
    
<div class="container clearfix">
    <h4 id="logo" style="text-align: center;background-color: #eee;padding: 10px;text-transform: uppercase">
        <?php echo $texteMenu; ?>
    </h4>
</div>
<div class="corps">        
        <input type="hidden" id="mdp" value="<?php echo $_SESSION["mdp"]; ?>"/>
        <input type="hidden" id="login" value="<?php echo $_SESSION["login"]; ?>"/>
   
     <div class="col-md-12">

<fieldset class="entete">
<legend class="entete">Liste des taxes</legend>
<div class="form-group">
<form action="indexMVC.php?module=9&action=5" method="GET">
    <table style="margin-bottom: 20px;width:100%">
    <thead>
        <tr>
            <!--<td><input type="text" class="form-control" name="rechercher"  style="width : 200px" value="" id="rechercher_article_ref" placeholder="Rechercher" /></td>
            <td><input type="text" class="form-control" name="rechercher"  style="width : 200px" value="" id="rechercher_article_design" placeholder="Rechercher" /></td>-->
            <?php if($protected!=1){ ?><td style="float:right"><a href="indexMVC.php?module=9&action=6"><button type="button" id="nouveau" class="btn btn-primary">Nouveau</button></a></td> <?php } ?>
        </tr>
        </form>
</table>
<div class="err" id="add_err"></div>
<table id="table" class="table">
    <thead style="background-color: #dbdbed;color:black">
            <th>Code taxe</th>
            <th>Intitulé de la taxe</th>
            <th>Compte de base</th>
            <th>Valeur</th>
            <th></th>
    </thead>
    <tbody id="liste_planComptable">
        <?php
        $objet = new ObjetCollector();   
        $result=$objet->db->requete($objet->getTaxe());     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $classe="";
        $i=0;
        if($rows==null){
            echo "<tr><td>Aucun élément trouvé ! </td></tr>";
        }else{
            foreach ($rows as $row){
            if($row->TA_TTaux==1)
                $valtaux = "";
            if($row->TA_TTaux==0)
                $valtaux = "%";
            if($row->TA_TTaux==2)
                $valtaux = "U";
                
            $i++;
            if($i%2==0) $classe = "info";
                    else $classe="";
            echo "<tr class='article $classe' id='compte_".$row->TA_Code."'>"
                    . "<td><a href='indexMVC.php?module=9&action=6&TA_Code=".$row->TA_Code."'>".$row->TA_Code."</a></td>"
                    . "<td>".$row->TA_Intitule."</td>"
                    . "<td>".$row->CG_Num."</td>"
                    . "<td>".ROUND($row->TA_Taux,2)."$valtaux</td>"
                    . "<td><a href='Traitement\Structure\Comptabilite\Taxe.php?TA_No=".$row->TA_No."&TA_Code=".$row->TA_Code."&acte=suppr' onclick=\"if(window.confirm('Voulez-vous vraiment supprimer ".$row->TA_Code."?')){return true;}else{return false;}\"><i class='fa fa-trash-o'></i></a></td>";
                    echo "</tr>";
            }
        }
      ?>
</tbody>
</table>
 </div>

   
</div>
 
</div>
