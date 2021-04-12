<?php
include("enteteParam.php");
$nomEtat="Statistique article achat par agence";
// get the HTML
ob_start();
include("styleExportEtat.php");
$totalCANetHTG=0;
$totalPrecompteG=0;
$totalCANetTTCG=0;
$totalQteVendueG=0;
$totalMargeG=0;
$result=$objet->db->requete($objet->depot());     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    foreach($rows as $row){
        if(($rupture==0 && $cmp==0)|| $rupture==1){
            if($depot_no==0 || $depot_no==$row->DE_No){
                $val=0;
                $val_nom=$row->DE_Intitule;
                if($rupture==1 || $depot_no==$row->DE_No){
                    $val=$row->DE_No;
                }
        $result=$objet->db->requete($objet->stat_articleParAgenceAchat($val, $datedeb, $datefin,$famille,$article,$do_type));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $canetht=0;
        $canetttc=0;
        $precompte=0;
        $qte=0;
        $marge=0;
        $margeca=0;
        $classe="";
        
?>
                <page>
                    <?php
                include("headerEtat.php");
                ?>
<br/>
<br/>

<table class="facture">
    <tr style="text-align: center">
            <th style="width:80px">Référence</th>
            <th style="width:100px">Désignation</th>
            <th>CA <br/>Net HT</th>
            <th>Precompte</th>
            <th>CA <br/>Net TTC</th>
            <th>Qtés <br/>achetées</th>
        </tr>
    <?php
        if($rows==null){
        }else{
            foreach ($rows as $row){
                $i++;
                if($i%2==0) $classe = "info";
                    else $classe="";
                echo "<tr class='eqstock $classe'>";
                echo "<td>".$row->AR_Ref."</td>"
                ."<td style='width:220px'>".$row->AR_Design."</td>"
                ."<td style='text-align:right'>".$objet->formatChiffre(ROUND($row->TotCAHTNet,2))."</td>"
                ."<td style='text-align:right'>".$objet->formatChiffre(ROUND($row->PRECOMPTE,2))."</td>"
                ."<td style='text-align:right'>".$objet->formatChiffre(ROUND($row->TotCATTCNet,2))."</td>";
                 echo"<td style='text-align:center'>".$objet->formatChiffre(ROUND($row->TotQteVendues,2))."</td>";
                echo "</tr>";
                $canetht=$canetht+ROUND($row->TotCAHTNet,2);
                $canetttc=$canetttc+ROUND($row->TotCATTCNet,2);
                $precompte=$precompte+ROUND($row->PRECOMPTE,2);
                $qte=$qte+ROUND($row->TotQteVendues,2);
                $marge=$marge+ROUND($row->TotPrxRevientU,2);
                $totalCANetHTG=$totalCANetHTG+ROUND($row->TotCAHTNet,2);
                $totalPrecompteG=$totalPrecompteG+ROUND($row->PRECOMPTE,2);
                $totalCANetTTCG=$totalCANetTTCG+ROUND($row->TotCATTCNet,2);
                $totalQteVendueG=$totalQteVendueG+ROUND($row->TotQteVendues,2);
                $totalMargeG=$totalMargeG+ROUND($row->TotPrxRevientU,2);
            }
            $totmargepourc=0;
            if($canetht>0)$totmargepourc=ROUND($marge/$canetht*100,2);
            echo "<tr class='totalTable'>";
            echo "<td colspan='2'>Total</td><td style='text-align:right'>".$objet->formatChiffre($canetht)."</td>
                    <td style='text-align:right'>".$objet->formatChiffre($precompte)."</td>
                    <td style='text-align:right'>".$objet->formatChiffre($canetttc)."</td>";
            echo "<td style='text-align:center'>".$objet->formatChiffre($qte)."</td>";
            echo "</tr>";
        }
    ?>        
</table>
</page>
<br/>
<br/>
<?php
            }
        }
        $cmp++;
    }
if($rupture==3){
?>
<table>
    <tr style='background-color:#a4a4a4;font-weight: bold'>
        <td style="padding:10px">CA Net HT : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalCANetHTG); ?></td>
        <td style="padding:10px">Precompte : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalPrecompteG); ?></td>
        <td style="padding:10px">CA Net TTC : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalCANetTTCG); ?></td>
        <td style="padding:10px">Quantités achetées : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalQteVendueG); ?></td>
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
        $html2pdf->Output('STAT_ARTICLE_PAR_AGENCE_ACHAT.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>