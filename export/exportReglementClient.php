<?php
include("enteteParam.php");
$nomEtat="Règlement client";

use Spipu\Html2Pdf\Html2Pdf;
// get the HTML
ob_start();
?>
<style>
    table.facture {
 border-collapse:collapse;
}
table.facture th , table.facture td{
 border:1px solid black;
}
table.facture td {
    border-left : 1px;
    border-bottom: 0px;
    font-size : 11px;
}

</style>
<?php
$totalMontantG=0;
$totalMontantAvanceG=0;
$totalResteAPayerG=0;
$result=$objet->db->requete($objet->caisse());     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    foreach($rows as $row){
        if(($rupture==0 && $cmp==0)|| $rupture==1){
            if($caisse==0 || $caisse==$row->CA_No){
                $val=0;
                if($rupture==1 || $caisse==$row->CA_No){
                    $val=$row->CA_No;
                }
                $val_nom=$row->CA_Intitule;
                $result=$objet->db->requete($objet->getReglement($client,$type,$treglement,$datedeb,$datefin,$val,$facComptabilise));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                $i=0;

                $somRG=0;
                $somRC=0;
                $somRAP=0;
                $classe="";

?>
                 <page>
                     <?php
                     include("headerEtat.php");
                     ?>
<br/>
<br/>

<table class="facture">
    <thead>
    <tr style="text-align: center">
            <th style="width:50px">Date</th>
            <th style="width:100px">Libelle</th>
            <th style="width:80px">Montant</th>
            <th style="width:80px">Montant imputé</th>
            <th style="width:80px">Reste à imputer</th>
            <th style="width:80px">Caisse</th>
            <th style="width:80px">Caissier</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $ref = "";
    $soustotalMontant=0;
    $soustotalMontantImputer=0;
    $soustotalMontantRAI=0;
    if($rows==null){
    }else{
        $cmpligne=0;
        foreach ($rows as $row){
            if($ref!=$row->CT_NumPayeur){
                if($cmpligne>0){
                    echo "<tr style='background-color:#a4a4a4;font-weight: bold'><td colspan='2'>Sous total $ref</td><td>".$objet->formatChiffre($soustotalMontant)."</td><td>".$objet->formatChiffre($soustotalMontantImputer)."</td>";
                    echo"<td>".$objet->formatChiffre($soustotalMontantRAI)."</td><td></td><td></td>";
                    echo "</tr>";
                }
                $soustotalMontant=0;
                $soustotalMontantImputer=0;
                $soustotalMontantRAI=0;
                $ref=$row->CT_NumPayeur;
                echo "<tr style='background-color:#f9f9f9'><td style='padding-left:20px;text-align: left' colspan='7'><b>$ref</b></td>";
                echo "</tr>";
                $i=0;
            }
            $i++;
            if($i%2==0) $classe = "info";
            else $classe="";
            echo "<tr background-color='background-color:#c8c6c6cc;' class='reglement' id='reglementetat".$row->RG_No."'>"
                . "<td>".$objet->getDateDDMMYYYY($row->RG_Date)."</td>"
                . "<td>".$row->RG_Libelle."</td>"
                . "<td id='RG_Montant'>".$objet->formatChiffre(ROUND($row->RG_Montant))."</td>"
                . "<td id='RC_Montant'>".$objet->formatChiffre(ROUND($row->RC_Montant))."</td>"
                . "<td id='RC_Montant'>".$objet->formatChiffre(ROUND($row->RG_Montant - $row->RC_Montant))."</td>"
                . "<td>".$row->CA_Intitule."</td>"
                . "<td>".$row->CO_Nom."</td>"
                . "</tr>";
            $result=$objet->db->requete($objet->getFactureRGNo($row->RG_No));
            $rowsFacture = $result->fetchAll(PDO::FETCH_OBJ);
            foreach($rowsFacture as $rowfacture){
                echo "<tr>"
                    . "<td id='RC_Montant'></td>"
                    . "<td>".$rowfacture->DO_Date."</td>"
                    . "<td>".$rowfacture->DO_Piece."</td>"
                    . "<td id='RG_Montant'>".$objet->formatChiffre(ROUND($rowfacture->ttc))."</td>"
                    . "<td id='RC_Montant'></td>"
                    . "<td></td>"
                    . "<td></td>"
                    . "</tr>";
            }
            $somRG=$somRG+ROUND($row->RG_Montant,2);
            $somRC=$somRC+ROUND($row->RC_Montant,2);
            $somRAP=$somRAP+ROUND($row->RG_Montant - $row->RC_Montant,2);
            $totalMontantG=$totalMontantG+ROUND($row->RG_Montant,2);
            $totalMontantAvanceG=$totalMontantAvanceG+ROUND($row->RC_Montant,2);
            $totalResteAPayerG=$totalResteAPayerG+ROUND($row->RG_Montant - $row->RC_Montant,2);
            $soustotalMontant=$soustotalMontant+ROUND($row->RG_Montant,2);
            $soustotalMontantImputer=$soustotalMontantImputer+ROUND($row->RC_Montant,2);
            $soustotalMontantRAI=$soustotalMontantRAI+ROUND($row->RG_Montant - $row->RC_Montant,2);
            $cmpligne++;

        }
        if($cmpligne>0){
            echo "<tr style='background-color:#a4a4a4;font-weight: bold'><td colspan='2'>Sous total $ref</td><td>".$objet->formatChiffre($soustotalMontant)."</td><td>".$objet->formatChiffre($soustotalMontantImputer)."</td>";
            echo"<td>".$objet->formatChiffre($soustotalMontantRAI)."</td><td></td><td></td>";
            echo "</tr>";
        }
        echo "<tr style='background-color: #46464be6;color: white;font-weight: bold;'><td colspan='2'>Total</td>"
            . "<td>".$objet->formatChiffre($somRG)."</td><td>".$objet->formatChiffre($somRC)."</td><td>".$objet->formatChiffre($somRAP)."</td><td></td><td></td></tr>";
    }


    ?>
        </tbody>
    </table>
                 </page>

<?php 
            }
        }
        $cmp++;
    }
    
 if($rupture==3){
?>
<table>
    <tr style='background-color:#a4a4a4;font-weight: bold'>
        <td style="padding:10px">Montant : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalMontantG); ?></td>
        <td style="padding:10px">Montant imputé : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalMontantAvanceG); ?></td>
        <td style="padding:10px">Reste à imputer : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalResteAPayerG); ?></td>
    </tr>
</table>
<?php 
}
    $content = ob_get_clean();
    // convert in PDF
    require_once("../vendor/autoload.php");
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        ob_end_clean();
        $html2pdf->Output('REGLEMENT_CLIENT.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>