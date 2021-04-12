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
<script src="js/Structure/Comptabilite/script_listeJournaux.js?d=<?php echo time(); ?>"></script>
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
<legend class="entete">Journaux</legend>
<div class="form-group">
<form action="indexMVC.php?module=9&action=7" method="GET">
    <table style="margin-bottom: 20px;width:100%">
    <thead>
        <tr>
            <!--<td><input type="text" class="form-control" name="rechercher"  style="width : 200px" value="" id="rechercher_article_ref" placeholder="Rechercher" /></td>
            <td><input type="text" class="form-control" name="rechercher"  style="width : 200px" value="" id="rechercher_article_design" placeholder="Rechercher" /></td>-->
            <?php if($protected!=1){ ?><td style="float:right"><a href="indexMVC.php?module=9&action=8"><button type="button" id="nouveau" class="btn btn-primary">Nouveau</button></a></td> <?php } ?>
        </tr>
        <tr>
            <td>
                <input type="hidden" value="<?php echo $module; ?>" name="module"/>
                <input type="hidden" value="<?php echo $action; ?>" name="action"/>
                <select name="type" id="type" class="form-control" style="width: 200px">
                    <option value="0" <?php if($val==0) echo " selected "; ?>>Tout les codes journaux</option>
                    <option value="1" <?php if($val==1) echo " selected "; ?>>Code journaux actifs</option>
                    <option value="2" <?php if($val==2) echo " selected "; ?>>Code journaux mis en sommeil</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><input class="btn btn-primary" type="submit" value="Filtrer" name="filtre" id="filtre" /></td>
        </tr>
        </form>
</table>
<div class="err" id="add_err"></div>
<table id="table" class="table">
    <thead style="background-color: #dbdbed;color:black">
        <th>Code</th>
        <th>Intitulé du journal</th>
        <th></th>
    </thead>
    <tbody id="liste_journaux">
        <?php
        $objet = new ObjetCollector();   
        $result=$objet->db->requete($objet->getJournaux($val));     
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
            echo "<tr class='article $classe' id='compte_".$row->JO_Num."'>"
                    . "<td><a href='indexMVC.php?module=9&action=8&JO_Num=".$row->JO_Num."'>".$row->JO_Num."</a></td>"
                    . "<td>".$row->JO_Intitule."</td>"
                    . "<td><a href='Traitement\Structure\Comptabilite\Journal.php?JO_Num=".$row->JO_Num."&acte=suppr' onclick=\"if(window.confirm('Voulez-vous vraiment supprimer ".$row->JO_Num."?')){return true;}else{return false;}\"><i class='fa fa-trash-o'></i></a></td>";
                    echo "</tr>";
            }
        }
      ?>
</tbody>
</table>
 </div>

   
</div>
 
</div>
