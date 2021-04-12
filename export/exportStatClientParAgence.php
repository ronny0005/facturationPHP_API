<?php
include("enteteParam.php");
$nomEtat="Statistique client par agence"; 
// get the HTML
ob_start();
include("styleExportEtat.php");

$totalCANetHTG=0;
$totalPrecompteG=0;
$totalCANetTTCG=0;
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
                if($rupture==1 || $depot_no==$row->DE_No){
                $val=$row->DE_No;
                }
                $val_nom=$row->DE_Intitule;
                $etatList = new EtatClass();
                $result=$objet->db->requete($etatList->stat_clientParAgence($val, $datedeb, $datefin,$do_type));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
    
        $i=0;
        $canetht=0;
        $canetttc=0;
        $precompte=0;
        $marge=0;
        $tva=0;
        $classe="";
?>
<page>
<?php
include("headerEtat.php");
?>
<br/>
<br/>
<table class="facture">
    <tr style="text-align:center">
            <th style="width:300px">Client</th>
            <th>CA<br/> HT</th>
            <th>Precompte</th>
            <?php if($flagPxRevient==0)  { echo"<th>Marge</th>";} ?>
            <th>CA<br/> TTC</th>
        </tr>
    <?php
        if($rows==null){
        }else{
            foreach ($rows as $row){
                $i++;
            if($i%2==0) $classe = "info";
                    else $classe="";
                echo "<tr class='eqstock $classe'>";
                echo "<td style='width:200px'>".$row->CT_Intitule."</td>"
                ."<td style='text-align:right'>".$objet->formatChiffre(ROUND($row->TotCAHTNet,2))."</td>"
                ."<td style='text-align:right'>".$objet->formatChiffre(ROUND($row->PRECOMPTE,2))."</td>";
                if($flagPxRevient==0)  { echo "<td style='text-align:right'>".$objet->formatChiffre(ROUND($row->TotMarge,2))."</td>";}
                echo "<td style='text-align:right'>".$objet->formatChiffre(ROUND($row->TotCATTCNet,2))."</td>"
                . "</tr>";
                $canetht=$canetht+ROUND($row->TotCAHTNet,2);
                $canetttc=$canetttc+ROUND($row->TotCATTCNet,2);
                $precompte=$precompte+ROUND($row->PRECOMPTE,2);
                $marge=$marge+ROUND($row->TotMarge,2);
                
                $totalCANetHTG=$totalCANetHTG+ROUND($row->TotCAHTNet,2);
                $totalPrecompteG=$totalPrecompteG+ROUND($row->PRECOMPTE,2);
                $totalCANetTTCG=$totalCANetTTCG+ROUND($row->TotCATTCNet,2);
                $totalMargeG=$totalMargeG+ROUND($row->TotMarge,2);
            }
            
        echo "<tr class='totalTable'><td>Total</td>";
        echo "<td style='text-align:right'>".$objet->formatChiffre($canetht)."</td>
                <td  style='text-align:right'>".$objet->formatChiffre($precompte)."</td>";
            if($flagPxRevient==0)  { echo "<td  style='text-align:right'>".$objet->formatChiffre($marge)."</td>";}
        echo "<td  style='text-align:right'>".$objet->formatChiffre($canetttc)."</td></tr>";
        }
        
    ?>
    </table>
</page>
<?php
            }
        }
        $cmp++;
//        if($rupture==1 && $depot_no==0) echo "</page>";
    }

//if($rupture==1 && $depot_no!=0) echo "</page>";
//if($rupture==0) echo "</page>";
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
        <?php if($flagPxRevient==0) { ?>
        <td style="padding:10px">Marge : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalMargeG); ?></td>
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
        $html2pdf->Output('STAT_COLLAB_PAR_AGENCE.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>