<fieldset class="entete">
<legend class="entete">Ligne</legend>
<div class="err" id="add_err"></div>
<form action="indexMVC.php?action=5&module=4" method="GET" name="form-ligne" id="form-ligne">
    <input type="hidden" value="4" name="module"/>
    <input type="hidden" value="5" name="action"/>
<div class="form-group">
     <div class="col-sm-2">
         <input class="form-control" id="entete" name="entete" name="entete" type="hidden" value="<?php echo $entete; ?>"/>
        <select class="form-control" id="reference" name="reference" placeholder="Référence">
        <?php 
        if($type!="Entree")
            $result=$objet->db->requete($objet->getAllArticleDispoByArRef($depot_no));     
        else
            $result=$objet->db->requete($objet->getAllArticle());     
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            $depot="";
        if($rows==null){
        }else{
            foreach($rows as $row){
                echo "<option value=".$row->AR_Ref."";
                echo ">".$row->AR_Ref." - ".$row->AR_Design."</option>";
            }
        }
        ?>
        </select>
     </div>
    <div class="col-sm-3">
        <input class="form-control" id="designation" name="designation" placeholder="Désignation" disabled/>
    </div>
    <div class="col-sm-3"  style="width:80px">
        <input type="text" class="form-control  only_float" name="quantite" id="quantite"  value="" placeholder="Qté" disabled/>
    </div>
    <div class="col-sm-2">
        <input type="text" class="form-control  only_float" id="prix"  value="" name="prix" placeholder="P.U" disabled />
    </div>
    <div class="col-sm-2">
        <input type="text" class="form-control" id="quantite_stock"  value="" placeholder="Quantité en stock" disabled />
        <input type="text" style="visibility: hidden" class="form-control" id="remise" name="remise"  value="" placeholder="Remise" disabled/>
        <input type="hidden" name="ADL_Qte" id="ADL_Qte" value="0"/>
        <input type="hidden" name="ADL_Qte_dest" id="ADL_Qte_dest" value="0"/>
        <input type="hidden" name="APrix" id="APrix" value="0"/>
        <input type="hidden" name="APrix_dest" id="APrix_dest" value="0"/>
        <input type="hidden" name="cb_Marq" id="cb_Marq" value="0"/>
        <input type="hidden" name="idSec" id="idSec" value="0"/>
        <input type="hidden" name="acte" id="acte" value="ajout_ligne"/>
    </div>
</div>
<?php if($type=="Transfert_detail"){ ?>
<div class="form-group">
<div class="col-sm-3">
    <select class="form-control" id="reference_dest" name="reference_dest" placeholder="Référence">
    <?php
        $result=$objet->db->requete($objet->getAllArticleTrsftDetail(0));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $depot="";
    if($rows==null){
    }else{
        foreach($rows as $row){
            echo "<option value=".$row->AR_Ref."";
            echo ">".$row->AR_Ref." - ".$row->AR_Design."</option>";
        }
    }
    ?>
    </select>
</div>
<div class="col-sm-3">
    <input class="form-control" id="designation_dest" name="designation_dest" placeholder="Désignation" disabled/>
</div>
    
<div class="col-sm-1" style="width:90px">
<input type="text" class="form-control  only_float" name="quantite_dest" id="quantite_dest"  value="" placeholder="Qté" disabled/>
</div>
    
<div class="col-sm-1" style="width:200px">
<input type="text" class="form-control  only_float" name="prix_dest" id="prix_dest"  value="" placeholder="Prix dest." disabled/>
</div>
</div>
<?php }?>
 </form>
<div class="form-group">
 <table id="tableLigne" class="table">
    <thead>
      <tr>
        <th>Référence</th>
        <th>Désignation</th>
        <th>Prix Unitaire</th>
        <th>Quantité</th>
        <th>Montant HT</th>
        <?php 
        if($type=="Transfert_detail")
            echo "<th>Référence Dest.</th>
                <th>Désignation Dest.</th>
                <th>Quantité Dest.</th>
                    <th>Montant HT Dest.</th>";
        ?>
        <th></th>
      </tr>
    </thead>
    <tbody id="article_body" >
      <?php 
        if($type=="Transfert")
            $result=$objet->db->requete($objet->getLigneTransfert($entete));   
         else
            if($type=="Transfert_detail")
                $result=$objet->db->requete($objet->getLigneTransfert_detail($entete)); 
            else
                $result=$objet->db->requete($objet->getLigneFactureTransfert($entete,$client,$do_domaine,$do_type));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $id_sec=0;
        $classe="";
        if($rows==null){
        }else{
            foreach ($rows as $row){
            $i++;
            $prix = $row->DL_PrixUnitaire;
            $remise = $row->DL_Remise;
            $qte=$row->DL_Qte;
            $type_remise = 0;
            $rem=0;
            if(strlen($remise)!=0){
                if(strpos($remise, "%")){
                    $remise=str_replace("%","",$remise);
                $rem = $prix * $remise / 100;
                }
                if(strpos($remise, "U")){
                    $remise=str_replace("U","",$remise);
                    $rem = $remise;
                }
            }else $remise=0;
            if($i%2==0)
                $classe = "info";
            else $classe = "";
                $montantHT = round($row->DL_MontantHT*100)/100;
                $montantHT_dest = round($row->DL_MontantHT_dest*100)/100;
                echo "<tr class='facture $classe' id='article_{$row->cbMarq}'>
                            <td id='AR_Ref'>{$row->AR_Ref}</td>
                            <td id='DL_Design'>{$row->DL_Design}</td>
                            <td id='DL_PrixUnitaire'>".round($row->DL_PrixUnitaire,2)."</td>
                            <td id='DL_Qte'>".(round($row->DL_Qte*100)/100)."</td>
                            <td id='DL_MontantHT'>$montantHT</td>
                            <td style='display:none' id='cbMarq'>{$row->cbMarq}</td>
                            <td style='display:none' id='id_sec'>{$row->idSec}</td>";
                    if($type=="Transfert_detail")
                        echo "<td id='AR_Ref_dest'>{$row->AR_Ref_Dest}</td>
                             <td id='AR_Design_dest'>{$row->DL_Design_Dest}</td>
                                <td id='DL_Qte_dest'>".(round($row->DL_Qte_dest*100)/100)."</td>
                                <td id='DL_MontantHT_dest'>$montantHT_dest</td>";
                    if(!isset($_GET["visu"])) echo "<td id='suppr_{$row->cbMarq}'><i class='fa fa-trash-o'></i></td></tr>";
            }

        }
      ?>
    </tbody>
  </table>
 </div>
 </fieldset>