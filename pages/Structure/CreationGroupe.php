<?php
     $id = 0;
    $username = "";
    $description = "";
    $password = "";
    $email="";
    $objet = new ObjetCollector(); 
    if(isset($_GET["id"])){
        $objet = new ObjetCollector();   
        $result=$objet->db->requete($objet->UsersByid($_GET["id"]));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $classe="";
        if($rows==null){
        }else{
            $id = $rows[0]->PROT_No;
            $username = $rows[0]->PROT_User;
            $description = $rows[0]->PROT_Description;
            $password = $rows[0]->PROT_Pwd;
            $groupeid = $rows[0]->PROT_Right;
            $profiluser= $rows[0]->PROT_UserProfil;
            $email= $rows[0]->PROT_EMail;
        }
    }
?>
<script src="js/script_creationGroupe.js?d=<?php echo time(); ?>"></script>
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
    </head>
 <ul style="margin-top:30px" class="menu">
    <li><a href="indexMVC.php?module=8&action=1">Utilisateurs</a></li>
    <li><a class="active" href="indexMVC.php?module=8&action=2">Profils</a></li>
	<li><a href="indexMVC.php?module=8&action=5">Droits</a></li>
</ul>       
    <form class="ajax1" action="indexMVC.php?module=8&action=3" method="POST">
        <input name="action" value="3" type="hidden"/>
        <input name="module" value="8" type="hidden"/>
	<input name="id" value="<?php echo "$id"; ?>" type="hidden"/>
        <div><h1><?= "FICHE MODIFICATION DES DROITS DU PROFIL  <b>{$username}</b>"; ?></h1></div>
       
        <table id="table" class="table">
        <thead>
            <th>Numéro</th>
            <th>Fonction</th>
            <th>Droit</th>
        </thead>
    <tbody id="liste_groupe">
        <?php
        
        $objet = new ObjetCollector();   
        
        $result2=$objet->db->requete($objet->getAllDroitsByProfil($_GET["u"],$_GET["gu"]));     
        $rows2 = $result2->fetchAll(PDO::FETCH_OBJ);
        $j=0;
        if($rows2==null){
            echo "<tr><td>Aucun élément trouvé ! </td></tr>";
        }else{
            foreach ($rows2 as $row2){
            $j++;
            if($j%2==0) $classe = "info";
                    else $classe="";
                   $numcmd= $row2->Libelle_Cmd;
            echo "<tr class='groupe' id='groupe_{$row2->PROT_Cmd}'>
                    <td>{$j}</td>
                    <td><input type='hidden' class='data-id' id='protno' name = 'protno' value='{$_GET["id"]}'>
                    <input type='hidden' class='data2-id' id='cmd' name = 'cmd' value='{$row2->PROT_Cmd}'>
                    <input type='hidden' class='data3-id' id='u' name = 'u' value='{$_GET["u"]}'>
                    <input type='hidden' class='data4-id' id='gu' name = 'gu' value='{$_GET["gu"]}'>
                    {$numcmd}</td>";
                  
            $resultdroit=$objet->db->requete($objet->getDroitByProfil($_GET["id"],$row2->PROT_Cmd));     
            $rowsdroit = $resultdroit->fetchAll(PDO::FETCH_OBJ);
            if($rowsdroit==null){
                $protrightdefaut =0;
                $intituledroit="Pas encore attribué";
            }else{
                $protrightdefaut = $rowsdroit[0]->EPROT_Right;
            }
            if($protrightdefaut==0){
                $intituledroit="Pas d'accès";
            }else if($protrightdefaut==1){
                $intituledroit="Ecriture";
            }else if($protrightdefaut==2){
                $intituledroit="Lecture et Ecriture";
            }else if($protrightdefaut==3){
                $intituledroit="Suppression";
            }else {}
            
            echo'   <td><select style="float:left;font-size: 10px" name="protright" class="form-control"  id="protright" ">';
            $tabvaleur=array("Pas d'accès","Ecriture","Lecture et Ecriture","Suppression");
            for($i=0;$i<sizeof($tabvaleur);$i++){
                echo "<option value='$i' ";
                if($protrightdefaut==$i) echo "selected";
                echo ">".$tabvaleur[$i]."</option>";
            }
echo"                        </select>
                    </td>
                </tr>";
            }
        }
        ?>
    </tbody>
    </table>
        <br/>
   <input type="submit" id="modifierProfil" name="modifierProfil" class="btn btn-success" value="Modifier et Retourner "/>
    </form>
       