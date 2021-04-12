<?php
include("enteteParam.php");
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
                 $val_nom=$row->CA_Intitule;
                if($rupture==1 || $caisse_no==$row->CA_No){
                 $val=$row->CA_No;
                }
    $result=$objet->db->requete($objet->etatVrstDistant($val, $datedeb, $datefin,$type));     
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
            <th style="width:20px">N°</th>
            <th style="width:120px">N° client</th>
            <th style="width:80px">Libellé</th>
            <th style="width:80px">Montant</th>
            <th style="width:80px">Montant imputé</th>
            <th style="width:80px">Reste à imputer</th>
            <th style="width:70px">Caisse</th>
            <th style="width:70px">Affecté à</th>
            <th style="width:70px">Date saisie</th>
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
                ."<td style='width:20px'>".$row->RG_Piece."</td>"
                ."<td style='width:120px'>".$row->CT_NumPayeur."</td>"
                ."<td style='width:120px'>".$row->RG_Libelle."</td>"
                ."<td style='text-align:right'>".$objet->formatChiffre(ROUND($row->RG_Montant,2))."</td>"
                ."<td style='text-align:right'>".$objet->formatChiffre(ROUND($row->RC_Montant,2))."</td>"
                ."<td style='text-align:right'>".$objet->formatChiffre(ROUND($row->ResteAPayer,2))."</td>"
                ."<td style='width:70px'>".$row->CA_Intitule."</td>"
                ."<td style='width:70px'>".$row->CO_Nom."</td>"
                ."<td style='width:70px'>".$row->RG_Date."</td>"
                . "</tr>";
            }
            
        echo "<tr style='background-color: #46464be6;color: white;font-weight: bold;'><td colspan='3' >Total</td><td style='text-align:right'>".$objet->formatChiffre($somMontant)."</td><td style='text-align:right'>".$objet->formatChiffre($somMontantImputer)."</td><td style='text-align:right'>".$objet->formatChiffre($somResteAImputer)."</td>"
                . "<td></td><td></td><td></td></tr>";
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
    <tr style='background-color: #46464be6;color: white;font-weight: bold;'>
        <td style="padding:10px">Montant : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalMontant); ?></td>
        <td style="padding:10px">Montant imputé : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalMontantImpute); ?></td>
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
        $html2pdf->Output('VRST_DISTANT.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>