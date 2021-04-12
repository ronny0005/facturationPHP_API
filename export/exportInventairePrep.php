<?php
include("enteteParam.php");
$nomEtat="Inventaire préparatoire";
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
    $tottalQteG=0;
    $val_nom="";
    $result=$objet->db->requete($objet->depot());     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    foreach($rows as $row){
        if(($rupture==0 && $cmp==0)|| $rupture==1){
            if($depot_no==0 || $depot_no==$row->DE_No){
                $val=0;
                $val_nom = $row->DE_Intitule;
                if($rupture==1){
                    $val=$row->DE_No;
                }
                $etat = new EtatClass(0);
                if($choix_inv==1)
                    $result = $objet->db->requete($etat->getPreparatoireCumul($val));

                else
                    $result=$objet->db->requete($etat->getetatpreparatoire($val,$datedeb));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                $i=0;
                $classe="";
                $total=0;
        ?>
         <page>
             <?php
             include("headerEtat.php");
             ?>

<table class="facture" style="margin:auto;font-size: 12px">
    <tr style="text-align:center">
        <th>Ref.</th>
        <th style="width:150px">Désignation</th>
        <th style="width:50px">Qté</th>
        <?php if($choix_inv==2 && $affichePrix>0) echo"<th style='width:70px'>Prix <br/>Revient</th><th>Prix <br/>Unitaire</th><th style='width:60px'>Suivi</th>";?>
    </tr>
    
    <tbody><?php
    
        if($rows==null){
        }else{
            foreach ($rows as $row){
                $i++;
            if($i%2==0) $classe = "info";
                    else $classe="";
                echo "<tr class='eqstock $classe'>";
                echo "<td>".substr($row->AR_Ref,0,10)."</td>"
                ."<td>".$row->AR_Design."</td>"
                ."<td style='text-align:center'>".$objet->formatChiffre(ROUND($row->Qte,2))."</td>";
                if($choix_inv==2 && $affichePrix>0) echo "<td style='text-align:right'>".$objet->formatChiffre(ROUND($row->PR,2))."</td>"
                ."<td style='text-align:right'>".$objet->formatChiffre(ROUND($row->PU,2))."</td>"
                ."<td>".$row->SUIVI."</td>";
                echo "</tr>";
                $total=$total+$row->Qte;
                $tottalQteG=$tottalQteG+$row->Qte;
            }
        }
        echo "<tr style='background-color:#a4a4a4;font-weight: bold'><td style='font-size : 12px;'>Total</td>";
        echo "<td></td><td style='font-size : 12px;text-align:center'>".$objet->formatChiffre($total)."</td>";
        if($choix_inv==2 && $affichePrix>0) echo "<td></td><td></td><td></td>";
                echo "</tr>";
                  
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
    
      ?>

<?php
    if($rupture==1){
?>
<table>
    <tr style='background-color:#a4a4a4;font-weight: bold'>
        <td style="padding:10px">Quantité : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($tottalQteG); ?></td>
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
        $html2pdf->Output('INV_PREPARATOIRE.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>