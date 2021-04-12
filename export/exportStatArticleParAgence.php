<?php
use Spipu\Html2Pdf\Html2Pdf;
set_time_limit(0);
ini_set('max_execution_time', 0);
include("enteteParam.php");
$nomEtat="Statistique article par agence";
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
$totalCANetHTG=0;
$totalPrecompteG=0;
$totalCANetTTCG=0;
$totalQteVendueG=0;
$totalMargeG=0;
$depotClass = new DepotClass(0);
if($admin==0){
    $rows = $depotClass->getDepotUserPrincipal($_SESSION["id"]);
}
else {
    $rows = $depotClass->all();
}
    $nbligne = sizeof($rows);
    foreach($rows as $row){
        if(($rupture==0 && $cmp==0)|| $rupture==1){
            if($depot_no==0 || $depot_no==$row->DE_No){
                $val=0;
                $val_nom=$row->DE_Intitule;
                if($rupture==1 || $depot_no==$row->DE_No){
                    $val=$row->DE_No;
                }
                $etatClass = new EtatClass();
        $rows = $etatClass->stat_articleParAgence($val, $datedeb, $datefin,$famille,$articledebut,$articlefin,$do_type,$_SESSION["id"]);
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
            <th style="width:80px">Réf.</th>
            <th style="width:100px">Désignation</th>
            <th style="width:80px">CA Net HT</th>
            <th style="width:80px">Precompte</th>
            <th style="width:80px">CA Net TTC</th>
            <?= ($flagPxRevient==0) ? "<th style='width:50px'>% de Marge</th>" : "" ?>
            <th style="width:50px">Qtés vendues</th>
            <?= ($flagPxRevient==0) ? "<th style='width:70px'>Marge</th>" : "" ?>
            <th style="width:50px">Stock Réel</th>
        </tr>
    <?php
        if($rows==null){
        }else{
            foreach ($rows as $row){
                $i++;
                if($i%2==0) $classe = "info";
                    else $classe="";
?>
                <tr class='eqstock <?=$classe?>'>
                    <td style='width:60px'><?= $row->AR_Ref ?></td>
                    <td style='width:180px'><?= $row->AR_Design ?></td>
                    <td style='width:50px;text-align:right'><?= $objet->formatChiffre(ROUND($row->TotCAHTNet,2)) ?></td>
                    <td style='width:50px;text-align:right'><?= $objet->formatChiffre(ROUND($row->PRECOMPTE,2)) ?></td>
                    <td style='width:50px;text-align:right'><?= $objet->formatChiffre(ROUND($row->TotCATTCNet,2))?></td>
                    <?= ($flagPxRevient==0) ? "<td style='width:50px;text-align:right'>".ROUND($row->PourcMargeHT,2)."</td>" : "" ?>
                    <td style='width:50px;text-align:center'><?= $objet->formatChiffre(ROUND($row->TotQteVendues,2)) ?></td>
                    <?= ($flagPxRevient==0) ? "<td style='width:70px;text-align:right'>{$objet->formatChiffre(ROUND($row->TotPrxRevientU,2))}</td>":"" ?>
                    <td style='width:50px;text-align:center'><?= $objet->formatChiffre(ROUND($row->DL_Qte)) ?></td>
                </tr>
                <?php
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
        echo "<tr style='background-color:#a4a4a4;font-weight: bold'>
                <td style='font-size:12px'>Total</td>
                <td></td>
                <td style='font-size:12px;text-align:right'>{$objet->formatChiffre($canetht)}</td>
                <td style='font-size:12px;text-align:right'>{$objet->formatChiffre($precompte)}</td>
                <td style='font-size:12px;text-align:right'>{$objet->formatChiffre($canetttc)}</td>";
        if($flagPxRevient==0) echo "<td style='font-size:12px;text-align:right'>{$objet->formatChiffre($totmargepourc)}</td>";
        echo "<td style='font-size:12px;text-align:center'>{$objet->formatChiffre($qte)}</td>";
        if($flagPxRevient==0) { echo "<td style='font-size:12px;text-align:right'>{$objet->formatChiffre($marge)}</td>"; }
        echo "</tr>";
        }
        
    ?>        
</table>
<br/>
<br/>
</page>
                <?php
            }
        }
        $cmp++;

            ?>


<?php
    }
if($rupture==3){
        
?>
<table>
    <tr style='background-color:#a4a4a4;font-weight: bold'>
        <td style="padding:10px">CA Net HT : </td>
        <td style="padding:10px"><?= $objet->formatChiffre($totalCANetHTG); ?></td>
        <td style="padding:10px">Precompte : </td>
        <td style="padding:10px"><?= $objet->formatChiffre($totalPrecompteG); ?></td>
        <td style="padding:10px">CA Net TTC : </td>
        <td style="padding:10px"><?= $objet->formatChiffre($totalCANetTTCG); ?></td>
        <td style="padding:10px">Quantités vendues : </td>
        <td style="padding:10px"><?= $objet->formatChiffre($totalQteVendueG); ?></td>
        <?php if($flagPxRevient==0){ ?>
        <td style="padding:10px">Marge : </td>
        <td style="padding:10px"><?= $objet->formatChiffre($totalMargeG); ?></td>
        <td style="padding:10px">% de Marge : </td>
        <td style="padding:10px"><?= $objet->formatChiffre(ROUND($totalMargeG/$totalCANetHTG*100,2)); ?></td>
        <?php } ?>
    </tr>
</table>
<?php
}
?>

                    <?php
    $content = ob_get_clean();

    // convert in PDF
   require_once("../vendor/autoload.php");
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        ob_end_clean();
        $html2pdf->Output('STAT_ARTICLE_PAR_AGENCE.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>