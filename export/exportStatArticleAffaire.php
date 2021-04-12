<?php
include("enteteParam.php");
$nomEtat="Statistique article par agence";
// get the HTML
ob_start();
include("styleExportEtat.php");
$totalCANetHTG=0;
$totalPrecompteG=0;
$totalCANetTTCG=0;
$totalQteVendueG=0;
$totalMargeG=0;
$result=$objet->db->requete($objet->getListeTypePlanByVal($N_Analytique));
$rows = $result->fetchAll(PDO::FETCH_OBJ);
foreach($rows as $row){
    if(($rupture==0 && $cmp==0)|| $rupture==1){
        if($N_Analytique==0 || $N_Analytique==$row->cbIndice){
            $val=0;
            $val_nom=$row->A_Intitule;
            if($rupture==1 || $N_Analytique==$row->cbIndice){
                $val=$row->cbIndice;
            }
            $result=$objet->db->requete($objet->stat_articleAchatByCANum("E.CA_Num,CA_Intitule,DO_Tiers,CT_Intitule,AR.AR_Ref,AR_Design,E.CO_No,CO_Nom",$datedeb, $datefin, $famille,$articledebut,$articlefin,$val));
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
                    <th>Code <br/>Analytique</th>
                    <th>Désignation <br/>Analytique</th>
                    <th>Désignation <br/>Fournisseur</th>
                    <th>Collaborateur</th>
                    <th>Ref. <br/>Article</th>
                    <th>Désignation</th>
                    <th>PU HT</th>
                    <th>PU TTC</th>
                    <th>Qtés</th>
                </tr>
                <?php
                if($rows==null){
                }else{
                    foreach ($rows as $row){
                        $i++;
                        if($i%2==0) $classe = "info";
                        else $classe="";
                        echo "<tr class='eqstock $classe'>";
                        echo "<td>".$row->CA_Num."</td>"
                            ."<td>".$row->CA_Intitule."</td>"
                            ."<td>".$row->CT_Intitule."</td>"
                            ."<td>".$row->CO_Nom."</td>"
                            ."<td>".$row->AR_Ref."</td>"
                            ."<td>".$row->AR_Design."</td>"
                            ."<td style='width:50px;text-align:right'>".$objet->formatChiffre(ROUND($row->TotCAHTNet,2))."</td>"
                            ."<td style='width:50px;text-align:right'>".$objet->formatChiffre(ROUND($row->TotCATTCNet,2))."</td>";
                        echo"<td style='width:50px;text-align:center'>".$objet->formatChiffre(ROUND($row->TotQteVendues,2))."</td>";
                        echo "</tr>";
                        $canetht=$canetht+ROUND($row->TotCAHTNet,2);
                        $canetttc=$canetttc+ROUND($row->TotCATTCNet,2);
                        $qte=$qte+ROUND($row->TotQteVendues,2);
                        $totalCANetHTG=$totalCANetHTG+ROUND($row->TotCAHTNet,2);
                        $totalCANetTTCG=$totalCANetTTCG+ROUND($row->TotCATTCNet,2);
                        $totalQteVendueG=$totalQteVendueG+ROUND($row->TotQteVendues,2);
                    }
                    $totmargepourc=0;
                    echo "<tr class='totalTable'>";
                    echo "<td colspan='6'>Total</td><td style='text-align:right'>".$objet->formatChiffre($canetht)."</td>
                            <td style='text-align:right'>".$objet->formatChiffre($canetttc)."</td>";
                    echo "<td style='text-align:center'>".$objet->formatChiffre($qte)."</td></tr>";
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
            <td style="padding:10px">PU HT : </td>
            <td style="padding:10px"><?php echo $objet->formatChiffre($totalCANetHTG); ?></td>
            <td style="padding:10px">PU TTC : </td>
            <td style="padding:10px"><?php echo $objet->formatChiffre($totalCANetTTCG); ?></td>
            <td style="padding:10px">Quantités : </td>
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
    $html2pdf->Output('STAT_ARTICLE_PAR_AFFAIRE.pdf');
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>