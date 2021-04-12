<?php
include("enteteParam.php");
$nomEtat="Equation du stock"; 
// get the HTML
ob_start();
include("styleExportEtat.php");
    $totalStockG=0;
    $totalEntreeG=0;
    $totalSortieG=0;
    $totalStockFinalG=0;
    $totalQteVendueG=0;
    $totalStockRestantG=0;
    $result=$objet->db->requete($objet->depot());     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    foreach($rows as $row){
        if(($rupture==0 && $cmp==0)|| $rupture==1){
            if($depot_no==0 || $depot_no==$row->DE_No){
                $val=0;
                if($rupture==1 || $depot_no==$row->DE_No){
                    $val=$row->DE_No;
                }
                $val_nom=$row->DE_Intitule;
                $result=$objet->db->requete($objet->equationStkVendeur($val, $datedeb, $datefin));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $classe="";
        $stock=0;
        $entree=0;
        $retours=0;
        $sorties=0;
        $stock_final=0;
        $qte_vendues=0;
        $stk_restant=0;
?>
                <page>
                <?php
                    include("headerEtat.php");
                    ?>
<table class="facture">
    <tr style="text-align:center">
            <th style="width:100px">Désignation</th>
            <th style="width:50px">Stocks</th>
            <th style="width:50px">Entrées</th>
            <th style="width:50px">Sorties</th>
            <th style="width:50px">Stock <br/>final</th>
            <th style="width:50px">Qtés <br/>vendues</th>
            <th style="width:50px">Stocks <br/>restants</th>
        </tr>
    <?php
    
        if($rows==null){
        }else{
            foreach ($rows as $row){
                $i++;
            if($i%2==0) $classe = "info";
                    else $classe="";
                echo "<tr class='eqstock $classe'>";
                echo "<td>".substr($row->AR_Design,0,40)."</td>"
                ."<td style='width:50px;text-align:center'>".$objet->formatChiffre($row->STOCKS)."</td>"
                ."<td style='width:50px;text-align:center'>".$objet->formatChiffre($row->ENTREES)."</td>"
                ."<td style='width:50px;text-align:center'>".$objet->formatChiffre($row->SORTIES)."</td>"
                ."<td style='width:50px;text-align:center'>".$objet->formatChiffre($row->STOCK_FINAL)."</td>"
                ."<td style='width:50px;text-align:center'>".$objet->formatChiffre($row->QTE_VENDUES)."</td>"
                ."<td style='width:50px;text-align:center'>".$objet->formatChiffre($row->STOCK_RESTANTS)."</td>"
                . "</tr>";
                $stock=$stock+$row->STOCKS;
                $entree=$entree+$row->ENTREES;
                $sorties=$sorties+$row->SORTIES;
                $stock_final=$stock_final+$row->STOCK_FINAL;
                $qte_vendues=$qte_vendues+$row->QTE_VENDUES;
                $stk_restant=$stk_restant+$row->STOCK_RESTANTS;
                $totalStockG=$totalStockG + $row->STOCKS;
                $totalEntreeG=$totalEntreeG + $row->ENTREES;
                $totalSortieG=$totalSortieG + $row->SORTIES;
                $totalStockFinalG=$totalStockFinalG + $row->STOCK_FINAL;
                $totalQteVendueG=$totalQteVendueG + $row->QTE_VENDUES;
                $totalStockRestantG=$totalStockRestantG + $row->STOCK_RESTANTS;
            }
        }
        echo "<tr class='totalTable'><td>Total</td>";
                
        echo "<td style='text-align:center'>".$objet->formatChiffre($stock)."</td><td style='text-align:center'>".$objet->formatChiffre($entree)."</td>
                <td style='text-align:center'>".$objet->formatChiffre($sorties)."</td><td style='text-align:center'>".$objet->formatChiffre($stock_final)."</td>"
                . "<td style='text-align:center'>".$objet->formatChiffre($qte_vendues)."</td><td style='text-align:center'>".$objet->formatChiffre($stk_restant)."</td></tr>";
        
    ?>
    </table>
</page>
<?php
}
        }$cmp++;
    }
if($rupture==3){
?>
<table>
    <tr class="tableRupture">
        <td style="padding:10px">Stocks : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalStockG); ?></td>
        <td style="padding:10px">Entrées : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalEntreeG); ?></td>
        <td style="padding:10px">Sorties : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalSortieG); ?></td>
        <td style="padding:10px">Quantités vendues : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalQteVendueG); ?></td>
        <td style="padding:10px">Stocks restants : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalStockRestantG); ?></td>
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
        $html2pdf->Output('EQUATION_STOCK.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>