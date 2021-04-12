<?php
include("enteteParam.php");
$nomEtat="Mouvement stock";
// get the HTML
ob_start();
include("styleExportEtat.php");
?>
<page>
    <?php
    include("headerEtat.php");

    $tottalCumulG=0;
    $tottalQteG=0;
    $result=$objet->db->requete($objet->depot());
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    foreach($rows as $row){
        if(($rupture==0 && $cmp==0)|| $rupture==1){
        if($depot_no==0 || $depot_no==$row->DE_No){
            $val=0;
            if($rupture==1){
                echo "<div style='clear:both'><h3 style='text-align:center'>".$row->DE_Intitule."</h3></div>";
                $val=$row->DE_No;
            }
        $etatList = new EtatClass();
        $result=$etatList->stat_mouvementStock($val, ($datedeb),($datefin),$articledebut,$articlefin);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $qte=0;
        $cumul=0;
        $dlprix=0;
        $cumulPrix=0;
        $classe="";
        $ref="";
        ?>

    <table id="table" class="table table-striped table-bordered" cellspacing="0" >
        <thead>
        <tr>
            <th style="padding: 5px">Date</th>
            <th style="padding: 5px">Type <br/>mouvement</th>
            <th style="padding: 5px">Pièce</th>
            <th style="padding: 5px">Référence - Désignation</th>
            <th style="padding: 5px">Quantité <br/>en stock</th>
            <th style="padding: 5px">Quantité <br/>en stock <br/>(solde)</th>
            <?php if($flagPxRevient==0) echo "<th style=\"padding: 5px\">Prix de revient</th>
            <th style=\"padding: 5px\">Valeur stock</th>"; ?>
        </tr>
        </thead>
        <tbody>
        <?php
        if($rows==null){
            echo "<tr><td  colspan='8'> Aucun élément trouvé ! </td></tr>";
        }else{
            $cmpligne=0;
            foreach ($rows as $row){
                if($ref!=$row->AR_Ref){
                    if($cmpligne>0){
                        echo "<tr style='background-color:#a4a4a4;font-weight: bold'>
                                <td colspan='5'>Sous total - $ref</td>
                                <td>".$objet->formatChiffre($soustotalqte)."</td>";
                        if($flagPxRevient==0) echo"<td></td><td>".$objet->formatChiffre($soustotalprix)."</td>";
                        echo "</tr>";
                    }
                    $soustotalqte=0;
                    $soustotalprix=0;
                    $ref=$row->AR_Ref." - ".$row->AR_Design;
                    $valCol = 6;
                    if($flagPxRevient==0) $valCol=8;
                    echo "<tr><td colspan='$valCol'><b>$ref</b></td>";
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
                    ."<td>".$datet."</td>"
                    ."<td></td>"
                    ."<td>".$row->DO_Piece."</td>"
                    ."<td>".$row->CT_Intitule."</td>"
                    ."<td>".$objet->formatChiffre($row->DL_Qte,2)."</td>"
                    ."<td>".$objet->formatChiffre($row->cumul,2)."</td>";
                if($flagPxRevient==0) echo "<td>".$objet->formatChiffre(ROUND($row->DL_PrixRU,2))."</td>"
                    ."<td>".$objet->formatChiffre(ROUND($row->cumul_PRIX,2))."</td>";
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
            echo "<tr style='background-color: #46464be6;color: white;font-weight: bold;'><td colspan='4'>Total</td><td></td><td>".$objet->formatChiffre($qte)."</td>";
            if($flagPxRevient==0) echo "<td></td><td>".$objet->formatChiffre($soustotalprix)."</td>";
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
        <tr style='background-color: #46464be6;color: white;font-weight: bold;'>
            <td style="padding:10px">Quantité en stock (solde) : </td>
            <td style="padding:10px"><?php echo $objet->formatChiffre($tottalQteG); ?></td>
            <?php if($flagPxRevient==0){ ?>
                <td style="padding:10px">Valeur stock général : </td>
                <td style="padding:10px"><?php echo $objet->formatChiffre($tottalCumulG); ?></td>
            <?php } ?>
        </tr>
    </table>
    <?php
    }

    echo "</page>";



    $content = ob_get_clean();
    // convert in PDF
    require_once("../vendor/autoload.php");
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        ob_end_clean();
        $html2pdf->Output('CAISSE.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
