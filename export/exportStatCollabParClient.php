<?php
include("enteteParam.php");
$nomEtat="Statistique collaborateur par client";
// get the HTML
ob_start();
include("styleExportEtat.php");
$totalCANetHTG=0;
    $totalPrecompteG=0;
    $totalCANetTTCG=0;
    $totalQteVendueG=0;
    $totalMargeG=0;

        $CA_NET_HT_GR=0;
        $CA_NET_TTC_GR=0;
        $MARGE_GR=0;
$result=$objet->db->requete($objet->depot());     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    foreach($rows as $row){
        if(($rupture==0 && $cmp==0)|| $rupture==1){
            if($depot_no==0 || $depot_no==$row->DE_No){
                $val=0;
                $val_nom=$row->DE_Intitule;
                if($rupture==1 || $depot_no==$row->DE_No){
                $val=$row->DE_No;
                }
        $etatList = new EtatClass();
        $result=$objet->db->requete($etatList->stat_collaborateurClient($val, $datedeb, $datefin,$do_type));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $qte=0; 
        $cumul=0;
        $CA_NET_HT=0;
        $CA_NET_TTC=0;
        $MARGE=0;
        $classe="";
        $ref="-";
        $rem=0;
        $pourcent =0;
        ?>
<page>
        <?php
        include("headerEtat.php");
        ?>
<br/>
<br/>  
<table class="facture" >
<thead>
        <tr style="text-align:center">
            <th>N° Tiers</th>
            <th>Intitulé</th>
            <th>CA<br/> HT net</th>
            <th>CA<br/> TTC net</th>
            <th>%<br/> Remise</th>
            <?php if($flagPxRevient==0) { echo "<th style='width:80px'>Marge</th>"; } ?>
            <?php if($flagPxRevient==0) { echo "<th style='width:100px'>% Marge <br/>sur CA net</th>";} ?>
        </tr>
    </thead>
    <tbody>
        <?php
        if($rows==null){
        }else{
            $cmpligne=0;
            foreach ($rows as $row){
                if($ref!=$row->CO_Nom){
                if($cmpligne>0){
                   $soustotMarge=0;
                    if($totalCANetHTG!=0)
                        $soustotMarge=$soustotalMarge/$soustotalCAHT;
                    echo "<tr class='soustotalTable'><td colspan='2'>Sous total $ref</td><td style='text-align:right'>".$objet->formatChiffre($soustotalCAHT)."</td><td style='text-align:right'>".$objet->formatChiffre($soustotalCATTC)."</td><td></td>";
                   if($flagPxRevient==0)echo"<td style='text-align:right'>".$objet->formatChiffre($soustotalMarge)."</td><td style='text-align:right'>".$objet->formatChiffre(ROUND($soustotMarge*100,2))."</td>";
                    echo "</tr>";
                }
                    $soustotalCAHT=0;
                    $soustotalCATTC=0;
                    $soustotalMarge=0;
                    $ref=$row->CO_Nom;
                    $colspan= 5;
                    if($flagPxRevient==0) $colspan=8;
                    echo "<tr style='background-color:#f9f9f9'><td colspan='$colspan'><b>$ref</b></td>";
                    echo "</tr>";
                    $i=0;
                }
                $ref=$row->CO_Nom;
                $rem=$row->Rem-$row->CA_NET_HT;
                $pourcent=0;
                if($row->CA_NET_HT!=0)
                    $pourcent = $row->MARGE*100/$row->CA_NET_HT;
                
                $i++;
                echo "<tr class='eqstock'>"
                ."<td>".substr($row->CT_Num,0,13)."</td>"
                ."<td>".substr($row->CT_Intitule,0,25)."</td>"
                ."<td style='text-align:right'>".$objet->formatChiffre(ROUND($row->CA_NET_HT,2))."</td>"
                ."<td style='text-align:right'>".$objet->formatChiffre(ROUND($row->CA_NET_TTC,2))."</td>"
                ."<td style='text-align:right'>".$objet->formatChiffre(ROUND($rem,2))."</td>";
                if($flagPxRevient==0) { echo "<td style='text-align:right'>".$objet->formatChiffre(ROUND($row->MARGE,2))."</td>"
                ."<td style='text-align:right'>".ROUND($pourcent,2)."</td>"; }
                echo "</tr>";
                $CA_NET_HT=$CA_NET_HT+ROUND($row->CA_NET_HT,2);
                $CA_NET_TTC=$CA_NET_TTC+ROUND($row->CA_NET_TTC,2);
                $MARGE=$MARGE+ROUND($row->MARGE,2);
                $soustotalCAHT=$soustotalCAHT+ROUND($row->CA_NET_HT,2);
                $soustotalCATTC=$soustotalCATTC+ROUND($row->CA_NET_TTC,2);
                $soustotalMarge=$soustotalMarge+ROUND($row->MARGE,2);
                $CA_NET_HT_GR=$CA_NET_HT_GR+ROUND($row->CA_NET_HT,2);
                $CA_NET_TTC_GR=$CA_NET_TTC_GR+ROUND($row->CA_NET_TTC,2);
                $MARGE_GR=$MARGE_GR+ROUND($row->MARGE,2);
                $totalCANetHTG=$totalCANetHTG+ROUND($row->CA_NET_HT,2);
                $totalCANetTTCG=$totalCANetTTCG+ROUND($row->CA_NET_TTC,2);
                $totalMargeG=$totalMargeG+ROUND($row->MARGE,2);
                $cmpligne++;
            }
            if($cmpligne>0){
                
            $soustotMarge=0;
            if($soustotalCAHT!=0)
                $soustotMarge=$soustotalMarge/$soustotalCAHT;
                echo "<tr class='totalTable'><td style='width:100px' colspan='2'>Sous total $ref</td>
                <td style='text-align:right'>".$objet->formatChiffre($soustotalCAHT)."</td>
                <td style='text-align:right'>".$objet->formatChiffre($soustotalCATTC)."</td><td></td>";
                if($flagPxRevient==0)echo"<td style='text-align:right'>".$objet->formatChiffre($soustotalMarge)."</td><td style='text-align:right'>".$objet->formatChiffre(ROUND($soustotMarge*100,2))."</td>";
                 echo "</tr>";
             }
             $soustotMarge=0;
        if($totalCANetHTG!=0)
            $soustotMarge=$MARGE/$CA_NET_HT;
        echo "<tr class='totalTable'><td colspan='2'>Total</td><td style='text-align:right'>".$objet->formatChiffre($CA_NET_HT)."</td><td style='text-align:right'>".$objet->formatChiffre($CA_NET_TTC)."</td><td></td>";
        if($flagPxRevient==0) { echo "<td style='text-align:right'>".$objet->formatChiffre($MARGE)."</td>".
        "<td style='text-align:right'>".ROUND($soustotMarge*100,2)."</td></tr>";}
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
if($rupture==3){
        $soustotMarge=0;
        if($totalCANetHTG!=0)
            $soustotMarge=$totalMargeG/$totalCANetHTG;
?>
<table>
    <tr style='background-color: #46464be6;color: white;font-weight: bold;'>
        <td style="padding:10px">CA Net HT : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalCANetHTG); ?></td>
        <td style="padding:10px">CA Net TTC : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalCANetTTCG); ?></td>
        <?php if($flagPxRevient==0){ ?>
        <td style="padding:10px">Marge : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalMargeG); ?></td>
        <td style="padding:10px">% de Marge : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre(ROUND($soustotMarge*100,2)); ?></td>
        <?php } ?>
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
        $html2pdf->Output('STAT_COLLAB_PAR_CLIENT.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>