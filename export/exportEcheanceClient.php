<?php

ini_set('max_execution_time', 700);
ini_set('memory_limit', '-1');
include("enteteParam.php");

$nomEtat = "Echéance client";
if($typeTiers==1)
    $nomEtat = "Echéance fournisseur";
$nomSociete="";
$result=$objet->db->requete($objet->getNumContribuable());
$rows = $result->fetchAll(PDO::FETCH_OBJ);
if($rows==null){
}
else{
    $nomSociete=$rows[0]->D_RaisonSoc;
}
// get the HTML
ob_start();
?>
<?php
$totalMontantG=0;
$totalMontantAvanceG=0;
$totalResteAPayerG=0;
$result=$objet->db->requete($objet->depot());
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    foreach($rows as $row){
        if(($rupture==0 && $cmp==0)|| $rupture==1){
            $val_nom="";
            if($depot_no==0 || $depot_no==$row->DE_No){
                $val=0;
                $val_nom=$row->DE_Intitule;
                if($rupture==1 || $depot_no==$row->DE_No){
                    $val=$row->DE_No;
                };
                $result=$objet->db->requete($objet->echeance_client($val, $datedeb, $datefin,$clientdebut,$clientfin,$type_reg,$facComptabilise,$typeTiers));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
                include("styleExportEtat.php");
                ?>
                 <page>

                     <?php
                     include("headerEtat.php");
                     ?>
        <br/>
        <br/>
<table class="facture">
    <tr style="text-align:center">
        <th style="width:50px">Piece</th>
        <th style="width:50px">Date</th>
        <th style="width:100px">Montant</th>
        <th style="width:120px">Montant avance</th>
        <th style="width:120px">Reste à payer</th>
    </tr>
    <?php
    $ref = "";
    $soustotalMontant=0;
    $soustotalMontantImputer=0;
    $soustotalMontantRAI=0;
    $classe="";
    if($rows==null){
    }else{
        $cmpligne=0;
        $totalttc=0;
        $totalrc=0;
        $totalreste=0;
        foreach ($rows as $row){
            if($ref!=$row->CT_Num){
                if($cmpligne>0){
                    echo "<tr class='soustotalTable'><td colspan='2'>Sous total $ref</td><td>".$objet->formatChiffre($soustotalMontant)."</td><td>".$objet->formatChiffre($soustotalMontantImputer)."</td>";
                    echo"<td>".$objet->formatChiffre($soustotalMontantRAI)."</td>";
                    echo "</tr>";
                }
                $soustotalMontant=0;
                $soustotalMontantImputer=0;
                $soustotalMontantRAI=0;
                $ref=$row->CT_Num." - ".$row->CT_Intitule;
                echo "<tr style='background-color:#f9f9f9'><td style='padding-left:20px;text-align: left' colspan='5'><b>$ref</b></td>";
                echo "</tr>";
                $i=0;
            }
            $i++;
            if($i%2==0) $classe = "info";
            else $classe="";
            echo "<tr class='eqstock $classe'>";
            echo "<td>".$row->DO_Piece."</td>"
                ."<td>".$objet->getDateDDMMYYYY($row->DO_Date)."</td>"
                ."<td>".$objet->formatChiffre(ROUND($row->DL_MontantTTC,2))."</td>"
                ."<td>".$objet->formatChiffre(ROUND($row->RC_Montant,2))."</td>"
                ."<td>".$objet->formatChiffre(ROUND($row->Reste_A_Payer,2))."</td>"
                . "</tr>";
            $totalttc=$totalttc+ROUND($row->DL_MontantTTC,2);
            $totalrc=$totalrc + ROUND($row->RC_Montant,2) ;
            $totalreste=$totalreste + ROUND($row->Reste_A_Payer,2) ;
            $totalMontantG=$totalMontantG+ROUND($row->DL_MontantTTC,2);
            $totalMontantAvanceG=$totalMontantAvanceG+ROUND($row->RC_Montant,2);
            $totalResteAPayerG=$totalResteAPayerG+ROUND($row->Reste_A_Payer,2);
            $soustotalMontant=$soustotalMontant+ROUND($row->DL_MontantTTC,2);
            $soustotalMontantImputer=$soustotalMontantImputer+ROUND($row->RC_Montant,2);
            $soustotalMontantRAI=$soustotalMontantRAI+ROUND($row->Reste_A_Payer,2);
            $cmpligne++;
        }
        if($cmpligne>0){
            echo "<tr style='background-color:#a4a4a4;font-weight: bold'><td colspan='2'>Sous total $ref</td><td>".$objet->formatChiffre($soustotalMontant)."</td><td>".$objet->formatChiffre($soustotalMontantImputer)."</td>";
            echo"<td>".$objet->formatChiffre($soustotalMontantRAI)."</td>";
            echo "</tr>";
        }

        echo "<tr class='totalTable'><td>Total</td>";
        echo "<td></td><td>".$objet->formatChiffre($totalttc)."</td><td>".$objet->formatChiffre($totalrc)."</td><td>".$objet->formatChiffre($totalreste)."</td></tr>";
    }
    ?>
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
        <td style="padding:10px">Montant avance : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalMontantAvanceG); ?></td>
        <td style="padding:10px">Reste à payer : </td>
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
        $html2pdf->Output('ECHEANCE_CLIENT.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>