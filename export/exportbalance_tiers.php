<?php   

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
$totalsommeTiersAntD=0;
$totalsommeTiersAntC=0;
$totalsommeTiersD=0;
$totalsommeTiersC=0;
$totalsommeTiersAND=0;
$totalsommeTiersANC=0;
$result=$objet->db->requete($objet->depot());
$rows = $result->fetchAll(PDO::FETCH_OBJ);
foreach($rows as $row){
    if(($rupture==0 && $cmp==0)|| $rupture==1){
        if($depot_no==0 || $depot_no==$row->DE_No){
            $val=0;
            if($rupture==1 || $depot_no==$row->DE_No){
                echo "<div style='clear:both'><h3 style='text-align:center'>".$row->DE_Intitule."</h3></div>";
                $val=$row->DE_No;
            }
            $etatList = new EtatClass();
            $result=$objet->db->requete($etatList->etat_balance_tiers($datedeb,$datefin,$type_tiers,$clientdebut,$clientfin,$val));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            $ref="";

            include("headerEtat.php");
            ?>

            <table id="table" class="table table-bordered" cellspacing="0" >
            <thead>
            <tr style="background-color: lightgray ">
                <th>N° de compte</th>
                <th>Intitulé des comptes</th>
                <th colspan="2">Mouvements au 31/12/<?php echo substr($datedeb,0,4)-1; ?></th>
                <th colspan="2">Mouvements</th>
                <th colspan="2">Soldes cumulés</th>
            </tr>
            <tr style="background-color: lightgray ">
                <td colspan="2"></td>
                <td style="text-align: center;font-weight: bold">Débit</td>
                <td style="text-align: center;font-weight: bold">Crédit</td>
                <td style="text-align: center;font-weight: bold">Débit</td>
                <td style="text-align: center;font-weight: bold">Crédit</td>
                <td style="text-align: center;font-weight: bold">Débit</td>
                <td style="text-align: center;font-weight: bold">Crédit</td>
            </tr>
            </thead>
            <tbody>
            <?php
            if($rows==null){
            }else{
                $sommeTiersAntD=0;
                $sommeTiersAntC=0;
                $sommeTiersD=0;
                $sommeTiersC=0;
                $sommeTiersAND=0;
                $sommeTiersANC=0;
                foreach ($rows as $row){
                    echo "<tr class='eqstock'>"
                        ."<td>".$row->CT_Num."</td>"
                        ."<td>".$row->CT_Intitule."</td>"
                        ."<td>".$objet->formatChiffre(ROUND($row->tiersAntD,2))."</td>"
                        ."<td>".$objet->formatChiffre(ROUND($row->tiersAntC,2))."</td>"
                        ."<td>".$objet->formatChiffre(ROUND($row->tiersD,2))."</td>"
                        ."<td>".$objet->formatChiffre(ROUND($row->tiersC,2))."</td>"
                        ."<td>".$objet->formatChiffre(ROUND($row->CumulD,2))."</td>"
                        ."<td>".$objet->formatChiffre(ROUND($row->CumulC,2))."</td>";
                    echo "</tr>";
                    $sommeTiersAntD=$sommeTiersAntD+ROUND($row->tiersAntD,2);
                    $sommeTiersAntC=$sommeTiersAntC+ROUND($row->tiersAntC,2);
                    $sommeTiersD=$sommeTiersD+ROUND($row->tiersD,2);
                    $sommeTiersC=$sommeTiersC+ROUND($row->tiersC,2);
                    $sommeTiersAND=$sommeTiersAND+ROUND($row->CumulD,2);
                    $sommeTiersANC=$sommeTiersANC+ROUND($row->CumulC,2);

                    $totalsommeTiersAntD=$totalsommeTiersAntD+ROUND($row->tiersAntD,2);
                    $totalsommeTiersAntC=$totalsommeTiersAntC+ROUND($row->tiersAntC,2);
                    $totalsommeTiersD=$totalsommeTiersD+ROUND($row->tiersD,2);
                    $totalsommeTiersC=$totalsommeTiersC+ROUND($row->tiersC,2);
                    $totalsommeTiersAND=$totalsommeTiersAND+ROUND($row->CumulD,2);
                    $totalsommeTiersANC=$totalsommeTiersANC+ROUND($row->CumulC,2);

                }
                echo "<tr style='background-color: #46464be6;color: white;font-weight: bold;'><td colspan='2'>A reporter</td>
                        <td>".$objet->formatChiffre($sommeTiersAntD)."</td>
                        <td>".$objet->formatChiffre($sommeTiersAntC)."</td>
                        <td>".$objet->formatChiffre($sommeTiersD)."</td>
                        <td>".$objet->formatChiffre($sommeTiersC)."</td>
                        <td>".$objet->formatChiffre($sommeTiersAND)."</td>
                        <td>".$objet->formatChiffre($sommeTiersANC)."</td>
                        </tr>";}
        }


        ?>
        </tbody>
        </table>
        <?php
    }$cmp++;
//    if($rupture!=1) echo "</page>";
}


if($rupture==1){

    ?>
    <table>
        <tr style='background-color: #46464be6;color: white;font-weight: bold;'>
            <td style="padding:10px">Mvt au 31/12/<?php echo substr($datedeb,0,4)-1; ?> (Débit): </td>
            <td style="padding:10px"><?php echo $objet->formatChiffre($totalsommeTiersAntD); ?></td>
            <td style="padding:10px">Mvt au 31/12/<?php echo substr($datedeb,0,4)-1; ?> (Crédit): </td>
            <td style="padding:10px"><?php echo $objet->formatChiffre($totalsommeTiersAntC); ?></td>
        </tr>
        <tr style='background-color: #46464be6;color: white;font-weight: bold;'>
            <td style="padding:10px">Mvt (Débit): </td>
            <td style="padding:10px"><?php echo $objet->formatChiffre($totalsommeTiersD); ?></td>
            <td style="padding:10px">Mvt (Crédit): </td>
            <td style="padding:10px"><?php echo $objet->formatChiffre($totalsommeTiersC); ?></td>
        </tr>
        <tr style='background-color: #46464be6;color: white;font-weight: bold;'>
            <td style="padding:10px">Cumul (Débit): </td>
            <td style="padding:10px"><?php echo $objet->formatChiffre($totalsommeTiersAND); ?></td>
            <td style="padding:10px">Cumul (Crédit): </td>
            <td style="padding:10px"><?php echo $objet->formatChiffre($totalsommeTiersANC); ?></td>
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
        $html2pdf->Output('STAT_ARTICLE_PAR_AGENCE.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>