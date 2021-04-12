<?php
include("enteteParam.php");
$nomEtat="Relevé compte client";
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
include("headerEtat.php");
?>
<br/>
<br/>

<table class="facture">
    <thead>
    <tr style="text-align: center">
            <th style="width:50px">Date</th>
            <th style="width:100px">Livraison</th>
            <th style="width:50px">Retard</th>
            <th style="width:50px">Piece</th>
            <th style="width:50px">BL</th>
            <th style="width:100px">Net à payer</th>
            <th style="width:100px">Règlement</th>
            <th style="width:100px">Solde</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $result=$objet->db->requete($objet->releveCompteClient($depot_no, $datedeb, $datefin,0));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $classe="";
        if($rows==null){
        }else{
            foreach ($rows as $row){
                $i++;
            if($i%2==0) $classe = "info";
                    else $classe="";
                echo "<tr class='eqstock $classe'>"
                ."<td>".$objet->getDateDDMMYYYY($row->DO_DATE)."</td>"
                ."<td>".$objet->getDateDDMMYYYY($row->DR_DATE)."</td>"
                ."<td>".$row->RETARD."</td>"
                ."<td>".$row->DO_PIECE."</td>"
                ."<td>".$row->DO_REF."</td>"
                ."<td>".$objet->formatChiffre($row->NET_VERSER)."</td>"
                ."<td>".$objet->formatChiffre($row->REGLEMENT)."</td>"
                ."<td>".$objet->formatChiffre($row->cumul)."</td>"
                . "</tr>";
            }
            
        }
        
    ?>
        </tbody>
    </table>
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
        $html2pdf->Output('RELEVE_COMPTE_CLIENT.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>