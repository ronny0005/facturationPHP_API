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

$totalQteReel=0;
$totalQteMini=0;
$totalQteMax=0;
$totalQteCommande=0;
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

                $etatClass = new EtatClass();
                $rows = $etatClass->etatCommande($val,$articledebut,$articlefin);
        $i=0;
        $classe="";

                $QteReel=0;
                $QteMini=0;
                $QteMax=0;
                $QteCommande=0;
?>
                <page>
                <?php
                include("headerEtat.php");
                ?>
<br/>
<br/>

<table class="facture">
    <tr style="text-align: center">
        <th style="padding: 5px">Référence</th>
        <th style="padding: 5px">Désignation</th>
        <th style="padding: 5px">Qté <br/>réel</th>
        <th style="padding: 5px">Qté <br/>stock minimum</th>
        <th style="padding: 5px">Qté <br/>stock maximum</th>
        <th style="padding: 5px">Qté à <br/>commander</th>
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
                    ."<td>".$row->AR_Design."</td>"
                    ."<td style='text-align:center'>".$objet->formatChiffre(ROUND($row->AS_QteSto,2))."</td>"
                    ."<td style='text-align:center'>".$objet->formatChiffre(ROUND($row->AS_QteMini,2))."</td>"
                    ."<td style='text-align:center'>".$objet->formatChiffre(ROUND($row->AS_QteMaxi,2))."</td>";
                    echo "<td style='text-align:center'>".ROUND($row->QteCommande,2)."</td>";
                echo "</tr>";

                $QteReel=$QteReel+ROUND($row->AS_QteSto,2);
                $QteMini=$QteMini+ROUND($row->AS_QteMini,2);
                $QteMax=$QteMax+ROUND($row->AS_QteMaxi,2);
                $QteCommande=$QteCommande+ROUND($row->QteCommande,2);

                $totalQteReel=$totalQteReel+ROUND($row->AS_QteSto,2);
                $totalQteMini=$totalQteMini+ROUND($row->AS_QteMini,2);
                $totalQteMax=$totalQteMax+ROUND($row->AS_QteMaxi,2);
                $totalQteCommande=$totalQteCommande+ROUND($row->QteCommande,2);
            }
        echo "<tr style='background-color:#a4a4a4;font-weight: bold'>";
        echo "<td style='font-size:12px'>Total</td><td></td><td style='font-size:12px;text-align:center'>".$objet->formatChiffre($QteReel)."</td><td style='font-size:12px;text-align:center'>".$objet->formatChiffre($QteMini)."</td><td style='font-size:12px;text-align:center'>".$objet->formatChiffre($QteMax)."</td>";
        echo "<td style='font-size:12px;text-align:center'>".$objet->formatChiffre($QteCommande)."</td>";
        echo "</tr>";
        }
        
    ?>        
</table>
<br/>
<br/>
                <?php
            }
        }
        $cmp++;

            ?>


<?php
if($rupture!=0)
    echo "</page>";
    }
if($rupture==0)
echo "</page>";
if($rupture==3){
        
?>
<table>
    <tr style='background-color: #46464be6;color: white;font-weight: bold;'>
        <td style="padding:10px">Qté réel : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalQteReel); ?></td>
        <td style="padding:10px">Qté minimum : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalQteMini); ?></td>
        <td style="padding:10px">Qté maximum : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalQteMax); ?></td>
        <td style="padding:10px">Qté à commandée : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalQteCommande); ?></td>
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