<?php
include("enteteParam.php");
$nomEtat="Etat caisse";
// get the HTML
ob_start();
include("styleExportEtat.php");
?>
<?php 
    $result=$objet->db->requete($objet->caisse());     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if($rows!=null){
        foreach($rows as $row){
            $val_caisse=$row->CA_No;
            $val_nom=$row->CA_Intitule;
            if($caisse_no==0 || $caisse_no==$row->CA_No){
       
?>
<page>
    <?php
    include("headerEtat.php");
    ?>
<br/>
<br/>
<table class="facture">
    <thead>
        <tr style="text-align: center;text-transform: uppercase">
            <th style="vertical-align: middle">Date</th>
            <th>Mode <br/>de règlement</th>
            <th>N° <br/>Tiers</th>
            <th style="vertical-align: middle">Libellé</th>
            <th>Fond <br/>de caisse</th>
            <th>Entrée<br/> caisse</th>
            <th>Sortie<br/> caisse</th>
            <th>Solde<br/> progressif</th>
            <!--
            <th style="">Date</th>
            <th style="">Mode de <br/>règlement</th>
            <th>N° <br/>Tiers</th>
            <th style="">Libellé</th>
            <th style="">Fond <br/> caisse</th>
            <th style="">Entrée <br/>caisse</th>
            <th style="">Sortie <br/>caisse</th>
            <th style="">Solde <br/>progressif</th> -->
        </tr>
    </thead>
    <tbody>
    <?php
    $etatList = new EtatClass();
    $result=$objet->db->requete($etatList->etatCaisse($val_caisse, $datedeb, $datefin,$mode_reglement,$type_reglement));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $qte=0; 
        $cumul=0;
        $dlprix=0;
        $cumulPrix=0;
        $somCredit=0;
        $somDebitt=0;
        $somFondCaisse=0;
        $classe="";
        $ref="";
        if($rows==null){
        }else{
            foreach ($rows as $row){
                $somCredit=$somCredit+ROUND($row->CREDIT,2);
                if($row->N_Reglement!=5)
                $somDebitt=$somDebitt+ROUND($row->DEBIT,2);
                $somFondCaisse=$somFondCaisse+ROUND($row->FOND_CAISSE,2);
                if($row->N_Reglement==1 || $row->N_Reglement==10)
                    $cumulPrix=ROUND($row->CUMUL,2);
                $i++;
            if($i%2==0) $classe = "info";
                    else $classe="";
                echo "<tr class='eqstock $classe'>"
                ."<td>".date("d-m-Y", strtotime($row->RG_Date))."</td>"
                ."<td>".$row->R_Intitule."</td>"
                ."<td>".$row->CT_Intitule."</td>"
                ."<td style='width:200px'>".$row->RG_Libelle."</td>"
                ."<td style='text-align:right'>".$objet->formatChiffre(ROUND($row->FOND_CAISSE,2))."</td>"
                ."<td style='text-align:right'>".$objet->formatChiffre(ROUND($row->CREDIT,2))."</td>"
                ."<td style='text-align:right'>".$objet->formatChiffre(ROUND($row->DEBIT,2))."</td>"
                ."<td style='text-align:right'>".$objet->formatChiffre(ROUND($row->CUMUL,2))."</td>"
                . "</tr>";
            }
            $total = $somCredit + $somDebitt + $somFondCaisse;
        echo "<tr style='font-weight: bold;'>
                <td class='totalTd' colspan='4' >Total</td>
                <td class='totalTd' style='text-align:right'>".$objet->formatChiffre($somFondCaisse)."</td>
                <td class='totalTd' style='text-align:right'>".$objet->formatChiffre($somCredit)."</td>
                <td class='totalTd' style='text-align:right'>".$objet->formatChiffre($somDebitt)."</td>"
                . "<td class='totalTd' style='text-align:right'>".$objet->formatChiffre($cumulPrix)."</td></tr>";
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
        $html2pdf->Output('CAISSE.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
