
<script src="js/jquery.dynatable.js" type="text/javascript"></script>
<script src="js/script_etat.js"></script>
<?php
include("enteteParam.php");
?>

<section class="enteteMenu bg-light p-2 mb-3">
    <h3 class="text-center text-uppercase">Etat des dettes <?= $client ?></h3>
</section>

<form action="indexMVC.php?module=5&action=10" method="GET">
    <table style="margin-bottom: 20px">
    <thead>
        <tr>
            <td style="width:100px;vertical-align: middle">D&eacute;but :</td>
            <input type="hidden" value="5" name="module"/>
            <input type="hidden" value="10" name="action"/>
            <td><input type="text" class="form-control" name="datedebut" style="width : 100px" value="<?= $datedeb; ?>" id="datedebut" placeholder="Date" /></td>
            <td style="padding-left: 10px;width:95px;vertical-align: middle">Fin :</td>
            <td><input type="text" class="form-control" name="datefin"  style="width : 100px" value="<?= $datefin; ?>" id="datefin" placeholder="Date" /></td>
            <td style="padding-left: 10px;width:60px;vertical-align: middle"> Centre :</td>
            <td style="padding-left: 10px;width:200px;">
                <select class="form-control" name="depot" id="depot">
                    <option value="0" <?php if(0==$depot_no) echo " selected";?>>Tous</option>
                    <?php
                    $result=$objet->db->requete($objet->depot());     
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    if($rows==null){
                    }else{
                        foreach($rows as $row){
                            echo "<option value={$row->DE_No}";
                            if($row->DE_No==$depot_no) echo " selected";
                            echo ">{$row->DE_Intitule}</option>";
                        }
                    }
                    ?>
                </select>
            </td>
            <td style="padding-left:30px"><input type="submit" id="valider" class="btn btn-primary" value="Valider"/></td>
            <td style="padding-left:30px"><input type="submit"  class="btn btn-primary" value="Imprimer" <?php  echo "onClick=\"window.open('./export/exportEtatDette_detail.php?CT_Num=$client&datedebut=".$datedeb."&datefin=".$datefin."&amp;depot=".$depot_no."')\""; ?>/></td>
        </tr>
</table>
</form>
<?php 
    $result=$objet->db->requete($objet->depot());     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if($rows!=null){
        foreach($rows as $row){
            $val_depot=$row->DE_No;
            if($depot_no==0 || $depot_no==$row->DE_No){
            
            echo "<h4 style='text-align: center'>{$row->DE_Intitule}</h4>";
       
?><table id="table" class="table table-striped table-bordered" cellspacing="0" >
    <thead>
        <tr style="text-transform: uppercase">
            <th>N° Piece</th>
            <th>Date</th>
            <th>Débit</th>
            <th>Crédit</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $etatList = new EtatClass();
    $rows = $etatList->etatDette($val_depot, $objet->getDate($datedeb), $objet->getDate($datefin),'L.DO_Piece,L.cbDO_Piece,L.DO_Date ,',$client);
        $i=0;
        $qte=0; 
        $cumul=0;
        $dlprix=0;
        $cumulPrix=0;
        $somMntDebit=0;
        $somMntCredit=0;
        $classe="";
        $ref="";
        if($rows==null){
            echo "<tr><td colspan='4'>Aucun élément trouvé ! </td></tr>";
        }else{
            foreach ($rows as $row){
                $somMntDebit=$somMntDebit+ROUND($row->DL_MontantTTC,2);
                $somMntCredit=$somMntCredit+ROUND($row->RC_Montant,2);
                $date = new DateTime(''.$row->DO_Date.'');
                $i++;
            if($i%2==0) $classe = "info";
                    else $classe="";
                echo "<tr class='eqstock $classe'>"
                ."<td>".$row->DO_Piece."</td>"
                ."<td>".$date->format('d-m-Y')."</td>"
                ."<td>".$objet->formatChiffre($row->DL_MontantTTC)."</td>"
                ."<td>".$objet->formatChiffre(ROUND($row->RC_Montant,2))."</td>"
                . "</tr>";
            }
        echo "<tr style='background-color: #46464be6;color: white;font-weight: bold;'>
                <td colspan='2' >Total</td><td>".$objet->formatChiffre($somMntDebit)."</td>
                <td>".$objet->formatChiffre($somMntCredit)."</td></tr>";
        }
        
    ?>
        </tbody>
    </table>
        <?php 
        }
        
        }
    }
        ?>
