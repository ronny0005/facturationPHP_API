<?php
include("enteteParam.php");
$nomEtat="CONTROLE DES REPORTS FOND DE CAISSE";
// get the HTML
ob_start();
include("styleExportEtat.php");

    $totalFondCaisse=0;
    $totalSoldeJournee=0;
    $totalEcart=0;
    $result=$objet->db->requete($objet->caisse());     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if($rows!=null){
        foreach($rows as $row){
            if(($rupture==0 && $cmp==0)|| $rupture==1){
            if($caisse_no==0 || $caisse_no==$row->CA_No){
                $val=0;
                if($rupture==1 || $caisse_no==$row->CA_No){
                 $val=$row->CA_No;
                }
                $val_nom=$row->CA_Intitule;
                $etatList = new EtatClass();
        $result=$objet->db->requete($etatList->etatFondCaisse($val, $datedeb, $datefin));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $qte=0; 
        $cumul=0;
        $somFondCaisse=0;
        $somSoldeJournee=0;
        $somEcart=0;
        $classe="";
        $ref="";
       
?>
                <page>
<?php
                    include("headerEtat.php");
                    ?>
<br/>
<br/>  
<table class="facture" >
  <thead>
        <tr style="text-align: center">
            <th style="width:100px">Numéro</th>
            <th style="width:50px">Date</th>
            <th style="width:100px">Libellé</th>
            <th style="width:100px">Fond <br/>de caisse</th>
            <th style="width:100px">Solde fin <br/>de journée</th>
            <th style="width:100px">Ecart</th>
            <th style="width:100px">Caisse</th>
        </tr>
    </thead>
    <tbody>
    <?php
        if($rows==null){
        }else{
            foreach ($rows as $row){
                
                $somFondCaisse=$somFondCaisse+ROUND($row->FOND_CAISSE,2);
                $totalSoldeJournee=$somSoldeJournee+ROUND($row->SOLDE_JOURNEE,2);
                $somEcart=$somEcart+ROUND($row->ECART,2);
                $totalFondCaisse=$totalFondCaisse+$somFondCaisse;
                $totalSoldeJournee=$totalSoldeJournee+$somSoldeJournee;
                $totalEcart=$totalEcart+$somEcart;

                $i++;
            if($i%2==0) $classe = "info";
                    else $classe="";
                echo "<tr class='eqstock $classe'>"
                ."<td>".$row->RG_Piece."</td>"
                ."<td>".$objet->getDateDDMMYYYY($row->RG_Date)."</td>"
                ."<td style='width:100px'>".$row->RG_Libelle."</td>"
                ."<td style='width:100px'>".$objet->formatChiffre(ROUND($row->FOND_CAISSE,2))."</td>"
                ."<td style='width:100px'>".$objet->formatChiffre(ROUND($row->SOLDE_JOURNEE,2))."</td>"
                ."<td style='width:100px'>".$objet->formatChiffre(ROUND($row->ECART,2))."</td>"
                ."<td style='width:100px'>".$row->CA_Intitule."</td>"
                . "</tr>";
            }
            
        echo "<tr class='totalTable'><td colspan='3' >Total</td><td>".$objet->formatChiffre($somFondCaisse)."</td><td>".$objet->formatChiffre($somSoldeJournee)."</td>"
                . "<td>".$objet->formatChiffre($somEcart)."</td><td></td></tr>";
        }
        
    ?>
        </tbody>
    </table>
                </page>
<br/>
<br/>
        <?php 
               }
        }
        $cmp++;
    }
    }
    
    if($rupture==3){
?>
<table>
    <tr style='background-color:#a4a4a4;font-weight: bold'>
        <td style="padding:10px">Total fond de caisse : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalFondCaisse); ?></td>
        <td style="padding:10px">Total solde : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalSoldeJournee); ?></td>
        <td style="padding:10px">Total ecart : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalEcart); ?></td>
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
        $html2pdf->Output('REPORT_STOCK.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>