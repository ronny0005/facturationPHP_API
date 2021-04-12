<?php
include("enteteParam.php");
use Spipu\Html2Pdf\Html2Pdf;
set_time_limit(0);
ini_set('max_execution_time', 0);
$nomEtat="Règlement de ".$client;
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
    $result=$objet->db->requete($objet->depot());     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if($rows!=null){
        foreach($rows as $row){
            $val_depot=$row->DE_No;
            $val_nom=$row->DE_Intitule;
            if($depot_no==0 || $depot_no==$row->DE_No){
            
       
?>
                <page>
                    <?php
                    include("headerEtat.php");
                    ?>
<br/>
<br/>

<table class="facture">
    <thead>
        <tr style="text-transform: uppercase;text-align: center">
            <th style="width:200px">N° Piece</th>
            <th style="width:200px">Date</th>
            <th style="width:100px">Débit</th>
            <th style="width:100px">Crédit</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $etatlist = new EtatClass();
    $rows = $etatlist->etatDette($val_depot, $datedeb, $datefin,'L.DO_Piece,L.DO_Date ,',$client);
        $i=0;
        $qte=0; 
        $cumul=0;
        $dlprix=0;
        $cumulPrix=0;
        $somMnt=0;
        $somMntDebit=0;
        $somMntCredit=0;
        $classe="";
        $ref="";
        if($rows==null){
        }else{
            foreach ($rows as $row){
                $somMntDebit=$somMntDebit+ROUND($row->DL_MontantTTC,2);
                $somMntCredit=$somMntCredit+ROUND($row->RC_Montant,2);
                $date = new DateTime(''.$row->DO_Date.'');
                $i++;
                if($i%2==0) $classe = "info";
                    else $classe="";
                echo "<tr class='eqstock $classe'>"
                            ."<td>".$row->DO_Piece."</td>"
                ."<td>".$date->format('d-m-Y')."</td>"
                ."<td style='text-align:right'>".$objet->formatChiffre($row->DL_MontantTTC)."</td>"
                ."<td style='text-align:right'>".$objet->formatChiffre(ROUND($row->RC_Montant,2))."</td>"
                . "</tr>";
            }
        echo "<tr style='background-color:#a4a4a4;font-weight: bold'><td colspan='2' >Total</td>
            <td style='text-align:right'>".$objet->formatChiffre($somMntDebit)."</td>
            <td style='text-align:right'>".$objet->formatChiffre($somMntCredit)."</td></tr>";
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
        $html2pdf->Output('DETTE.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>