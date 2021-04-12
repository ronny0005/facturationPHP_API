<?php
include("enteteParam.php");
$val_nom="Versement bancaire";
$nomEtat="Versement distant";
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
    $totalMontant=0;
    $totalMontantImpute=0;
    $totalResteAImpute=0;
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
                $etatList = new EtatClass();
    $result=$objet->db->requete($etatList->etatVrstBancaire($val, $datedeb, $datefin,$type));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $qte=0; 
        $cumul=0;
        $somMontant=0;
        $somMontantImputer=0;
        $somResteAImputer=0;
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
        <tr style="text-transform: uppercase;text-align: center">
            <th style="width:100px">Numéro</th>
            <th style="width:100px">Libellé</th>
            <th style="width:100px">Montant sortie</th>
            <th style="width:100px">Type</th>
            <th style="width:100px">Solde non imputé</th>
            <th style="width:100px">Caisse</th>
            <th style="width:100px">Date de sortie</th>
        </tr>
    </thead>
    <tbody>
    <?php
        if($rows==null){
        }else{
            foreach ($rows as $row){
                $somMontant=$somMontant+ROUND($row->RG_Montant,2);
                $somMontantImputer=$somMontantImputer+ROUND($row->RC_Montant,2);
                $somResteAImputer=$somResteAImputer+ROUND($row->ResteAPayer,2);
                $totalMontant=$totalMontant+$somMontant;
                $totalMontantImpute=$totalMontantImpute+$somMontantImputer;
                $totalResteAImpute=$totalResteAImpute+$somResteAImputer;

                $i++;
            if($i%2==0) $classe = "info";
                    else $classe="";
                echo "<tr class='eqstock $classe'>"
                ."<td style='width:100px'>".$row->RG_Piece."</td>"
                ."<td style='width:100px'>".$row->RG_Libelle."</td>"
                ."<td style='width:100px;text-align:right'>".$objet->formatChiffre(ROUND($row->RG_Montant,2))."</td>"
                ."<td style='width:100px'>".$row->Type_lettre   ."</td>"
                ."<td style='width:100px;text-align:right'>".$objet->formatChiffre(ROUND($row->ResteAPayer,2))."</td>"
                ."<td style='width:100px'>".$row->CA_Intitule."</td>"
                ."<td style='width:100px'>".$row->RG_Date."</td>"
                . "</tr>";
            }
            
        echo "<tr style='background-color:#a4a4a4;font-weight: bold'><td colspan='2' >Total</td><td style='text-align:right'>".$objet->formatChiffre($somMontant)."</td><td></td><td style='text-align:right'>".$objet->formatChiffre($somResteAImputer)."</td>"
                . "<td></td><td></td></tr>";
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
        <td style="padding:10px">Montant : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalMontant); ?></td>
        <td style="padding:10px">Reste à imputer : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalResteAImpute); ?></td>
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
        $html2pdf->Output('VRST_BANCAIRE.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>