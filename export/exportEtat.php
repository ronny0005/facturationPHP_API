<?php
// get the HTML
include("enteteParam.php");
ob_start();
 
    if($type=="mvtStock"){
        $tottalCumulG=0;
        $tottalQteG=0;
        $result=$objet->db->requete($objet->depot());
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        foreach($rows as $row){
            if(($rupture==0 && $cmp==0)|| $rupture==1){
            if($depot_no==0 || $depot_no==$row->DE_No){
                $val=0;
                    $val_nom = $row->DE_Intitule;
                if($rupture==1){
                    $val_nom = $row->DE_Intitule;
                    $val=$row->DE_No;
                }
        ?>
<page>
                <?php
            $nomEtat="Mouvement de stock";
                include("styleExportEtat.php");
                include("headerEtat.php");
                ?>
        <br/>
        <br/>

<?php
                $etatList = new EtatClass();
            $result=$etatList->stat_mouvementStock($val, $datedeb, $datefin,$articledebut,$articlefin);
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            $i=0;
            $qte=0;
            $cumul=0;
            $dlprix=0;
            $cumulPrix=0;
            $classe="";
            $ref="";
            ?>

    <table clas="facture">
        <thead>
        <tr>
                <th style='text-align: center'>Date</th>
                <th style='text-align: center'>Type <br/>mouvement</th>
                <th style='text-align: center'>Pièce</th>
                <th style='text-align: center'>Référence - Désignation</th>
                <th style='text-align: center'>Qté<br/> en stock</th>
                <th style='text-align: center'>Qté<br/> en stock (solde)</th>
                <?php if($affichePrix>1) echo "<th style='text-align: center'>Prix <br/>de revient</th>
                <th style='text-align: center'>Valeur <br/>stock</th>"; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if($rows==null){
            }else{
                $cmpligne=0;
                foreach ($rows as $row){
                    if($ref!=$row->AR_Ref){
                        if($cmpligne>0){
                            echo "<tr class='sousTotaltable'><td colspan='5'>Sous total - $ref</td><td style='text-align:center'>".$objet->formatChiffre($soustotalqte)."</td>";
                            if($affichePrix>1)echo"<td></td><td style='text-align:right'>".$objet->formatChiffre($soustotalprix)."</td>";
                            echo "</tr>";
                        }
                        $soustotalqte=0;
                        $soustotalprix=0;
                        $ref=$row->AR_Ref." - ".$row->AR_Design;
                        echo "<tr><td style='text-align: center' colspan='8'><b>$ref</b></td>";
                        echo"</tr>";
                        $i=0;
                    }
                    $ref=$row->AR_Ref;
                    $i++;
                if($i%2==0) $classe = "info";
                        else $classe="";
                        $datet="Report stock";
                        if($row->DO_Date!="1960-01-01")
                            $datet=$objet->getDateDDMMYYYY($row->DO_Date);
                    echo "<tr class='eqstock $classe'>"
                    ."<td style='width: 10px'>".$datet."</td>"
                    ."<td></td>"
                    ."<td>".$row->DO_Piece."</td>"
                    ."<td>".$row->CT_Intitule."</td>"
                    ."<td style='text-align:center'>".$objet->formatChiffre($row->DL_Qte,2)."</td>"
                    ."<td style='text-align:center'>".$objet->formatChiffre($row->cumul,2)."</td>";
                     if($affichePrix>1) echo "<td style='text-align:right'>".$objet->formatChiffre(ROUND($row->DL_PrixRU,2))."</td>"
                    ."<td style='text-align:right'>".$objet->formatChiffre(ROUND($row->cumul_PRIX,2))."</td>";
                    echo "</tr>";
                    $qte=$qte+ROUND($row->DL_Qte,2);
                    $cumul=$cumul+ROUND($row->cumul,2);
                    $dlprix=$dlprix+ROUND($row->DL_PrixRU,2);
                    $cumulPrix=$cumulPrix+ROUND($row->DL_PrixRU,2);
                    $soustotalqte=ROUND($row->cumul,2);
                    $soustotalprix=ROUND($row->cumul_PRIX,2);
                    $tottalQteG=$tottalQteG + ROUND($row->DL_Qte,2);
                    $cmpligne++;
                }
                $tottalCumulG=$tottalCumulG+$soustotalprix;
                echo "<tr class='totalTable'><td colspan='4'>Total</td><td></td><td style='text-align: center'>".$objet->formatChiffre($qte)."</td>";
                if($affichePrix>1) echo "<td></td><td style='text-align: right'>".$objet->formatChiffre($soustotalprix)."</td>";
                echo "</tr>";
            }

        ?>
            </tbody>
        </table>
    <?php

            }
            $cmp++;
        }
        }
        if($rupture==1){
    ?>
    <table>
        <tr style='background-color: #a5a5a5;font-weight: bold;'>
            <td style="padding:10px">Quantité en stock (solde) : </td>
            <td style="padding:10px"><?php echo $objet->formatChiffre($tottalQteG); ?></td>

            <td style="padding:10px">Valeur stock général : </td>
            <td style="padding:10px"><?php echo $objet->formatChiffre($tottalCumulG); ?></td>

        </tr>
    </table>
    <?php
        }
  
    }
    
    if($type=="echeanceClient"){
$totalMontantG=0;
$totalMontantAvanceG=0;
$totalResteAPayerG=0;
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
        $result=$objet->db->requete($objet->echeance_client($val, $datedeb, $datefin,$clientdebut,$clientfin,$type_reg));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
   ?>
<table>
    <tr>
        <th>Piece</th>
        <th>N° Tiers</th>
        <th>Date</th>
        <th>Montant</th>
        <th>Montant avance</th>
        <th>Reste à payer</th>
    </tr>
    <?php
    
         $classe="";
        if($rows==null){
            echo "<tr><td>Aucun élément trouvé ! </td></tr>";
        }else{
            $totalttc=0;
            $totalrc=0;
            $totalreste=0;
            foreach ($rows as $row){
                $i++;
            if($i%2==0) $classe = "info";
                    else $classe="";
                echo "<tr class='eqstock $classe'>";
                echo "<td>".$row->DO_Piece."</td>"
                ."<td>".$row->CT_Num."</td>"
                ."<td>".$row->DO_Date."</td>"
                ."<td style='text-align:right'>".$objet->formatChiffre(ROUND($row->DL_MontantTTC,2))."</td>"
                ."<td style='text-align:right'>".$objet->formatChiffre(ROUND($row->RC_Montant,2))."</td>"
                ."<td style='text-align:right'>".$objet->formatChiffre(ROUND($row->Reste_A_Payer,2))."</td>"
                . "</tr>";
                $totalttc=$totalttc+ROUND($row->DL_MontantTTC,2);
                $totalrc=$totalrc + ROUND($row->RC_Montant,2) ;
                $totalreste=$totalreste + ROUND($row->Reste_A_Payer,2) ;
                $totalMontantG=$totalMontantG+ROUND($row->DL_MontantTTC,2);
                $totalMontantAvanceG=$totalMontantAvanceG+ROUND($row->RC_Montant,2);
                $totalResteAPayerG=$totalResteAPayerG+ROUND($row->Reste_A_Payer,2);

            }
            echo "<tr style='background-color: #46464be6;color: white;font-weight: bold;'><td colspan='3'>Total</td>";
            echo "<td style='text-align:right'>".$objet->formatChiffre($totalttc)."</td><td style='text-align:right'>".$objet->formatChiffre($totalrc)."</td><td style='text-align:right'>".$objet->formatChiffre($totalreste)."</td></tr>";
        }
        
    ?>
</table>
        <?php 
            }
        }
        $cmp++;
    }
 if($rupture==1){
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
    }
    ?>
    </page>
    <?php
    $content = ob_get_clean();
require_once("../vendor/autoload.php");
    // convert in PDF

    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        ob_end_clean();
        $html2pdf->Output($type.'.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>