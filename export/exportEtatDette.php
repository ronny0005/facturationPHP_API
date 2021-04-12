<?php
use Spipu\Html2Pdf\Html2Pdf;
set_time_limit(0);
ini_set('max_execution_time', 0);
include("enteteParam.php");
$nomEtat="Etat dette";
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
    $depotClass = new DepotClass(0,$objet->db);
    foreach($depotClass->all() as $row){
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
            <th style="width:200px">Numéro client</th>
            <th style="width:200px">Nom client</th>
            <th style="width:100px">Montant</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $etatList = new EtatClass();
    $rows = $etatList->etatDette($val_depot, $datedeb, $datefin,'',$clientdebut);
    $i=0;
    $qte=0;
    $cumul=0;
    $dlprix=0;
    $cumulPrix=0;
    $somMnt=0;
    $classe="";
    $ref="";
    foreach ($rows as $row){
        $somMnt=$somMnt+ROUND($row->MONTANT,2);
        $i++;
        if($i%2==0) $classe = "info";
        else $classe="";
        echo "  <tr class='eqstock $classe'>
                    <td><a href='indexMVC.php?action=17&module=5&DE_No=$val_depot&CT_Num={$row->CT_NUM}&datedebut=$datedeb&datefin=$datefin'>{$row->CT_NUM}</a></td>
                    <td>{$row->CT_Intitule}</td>
                    <td>".$objet->formatChiffre(ROUND($row->MONTANT,2))."</td>
                </tr>";
    }
    echo "<tr style='background-color: #46464be6;color: white;font-weight: bold;'><td colspan='2' >Total</td><td>".$objet->formatChiffre($somMnt)."</td></tr>";



    ?>
        </tbody>
    </table>
                </page>
<br/>
<br/>
        <?php 
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