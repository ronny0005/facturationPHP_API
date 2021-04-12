<?php
    $objet = new ObjetCollector(); 
    $datedeb=""; 
    $depot_no=0;
    $depot=0;
    $depot = $_SESSION["DE_No"];
    if(isset($_GET["datedebut"]) && !empty($_GET["datedebut"]))
        $datedeb=$_GET["datedebut"];
    if(isset($_GET["depot"])){
        $depot=$_GET["depot"];
    }
?>    
<script src="js/jquery.dynatable.js" type="text/javascript"></script>
<script src="js/scriptCombobox.js?d=<?php echo time(); ?>"></script>
<script src="js/script_saisieInventaire.js?d=<?php echo time(); ?>"></script>

<section class="enteteMenu bg-light p-2 mb-3">
    <h3 class="text-center text-uppercase">Saisie d'inventaire</h3>
</section>
<div style="float:left">Depot :
<select class="form-control" id="depot" name="depot">
<?php
$depot = new DepotClass(0);
    if($profil_caisse==1)
        $rows =$depot->getDepotUser($_SESSION["id"]);
    else
        $rows = $depot->alldepotShortDetail();
        foreach($rows as $row){
            echo "<option value='{$row->DE_No}'";
            if($depot== $row->DE_No) echo " selected ";
            echo ">{$row->DE_Intitule}</option>";
        }
?>
</select>        
</div> 
        <div style="float:right">
            <input type="button" class="btn btn-primary" value="Valider" id="valide" name="valide" />
        </div>
 
        
        <div style="clear: both;height: 300px;">
            
            <table id="table" class="table">
    <tbody style="">

        <tr>
        <td><select id="reference" class="form-control" onchange="changeValue();">
        <?php

        $article = new ArticleClass(0,$this->db);
        $rows = $article->all();
            foreach($rows as $row){
                echo "<option value='{$row->AR_Ref}'";
                echo ">{$row->AR_Ref} - {$row->AR_Design}</option>";
            }
        ?>
        </select></td>
        <td><input id="designation" class="form-control" type="text" disabled/></td>
        <td><input id="qte" type="text" class="form-control" disabled/></td>
        <td><input id="pr_unit" type="text" class="form-control" disabled/></td>
        <td><input id="valeur" type="text" class="form-control" disabled/></td>
        <td><input id="conditionnement" type="text" class="form-control" disabled/></td>
        <td><input id="qte_ajustee" class="form-control" onkeyup="this.value=this.value.replace(/\D/g,'')" type="text"/></td>
        <td><input id="pr_ajuste" class="form-control" type="text"/></td>
        <td><input id="valeur_ajustee" class="form-control" type="text"/></td>
    </tr>
    <tr style="background-color: #dbdbed;">
            <td>Reference</td>
            <td>Désignation</td>
            <td>Qté</td>
            <td>Prix unitaire</td>
            <td>Valeur</td>
            <td>Conditionnement</td>
            <td>Qté ajustée</td>
            <td>PR ajusté</td>
            <td>Valeur ajustée</td>
        </tr>
    <?php
        $result=$objet->db->requete($objet->getInventairePrepa('0','2','0','0',$depot,'2'));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $classe="";
        $total=0;
        if($rows==null){
            echo "<tr><td>Aucun élément trouvé ! </td></tr>";
        }else{
            foreach ($rows as $row){
                $i++;
                if($i%2==0) $classe = "info";
                else $classe="";
                echo "<tr id='item'>"
                ."<td id='tab_ref'>".$row->AR_Ref."</td>"
                ."<td id='tab_design'>".$row->DL_Design."</td>"
                ."<td id='tab_qte'>".ROUND($row->DL_Qte,2)."</td>"
                ."<td id='tab_prix'>".ROUND($row->DL_PrixRU,2)."</td>"
                ."<td id='tab_mtstk'>".ROUND($row->MontantSto,2)."</td>"
                ."<td id='tab_enum'>".$row->EC_Enumere."</td>"
                ."<td id='tab_qteajust'></td>"
                ."<td id='tab_prajust'></td>"
                ."<td id='tab_valajust'></td>"
                ."<td id='tab_valide'><input type='hidden' value='0' id='valide' /></td>"
                . "</tr>";
            }
        }
    ?>
    </tbody>
    </table> 
        </div>