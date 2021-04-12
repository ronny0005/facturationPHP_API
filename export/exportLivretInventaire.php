<?php
use Spipu\Html2Pdf\Html2Pdf;
include("enteteParam.php");
$nomEtat="Livret d'inventaire";
// get the HTML
ob_start();
?>
<style>
    table.facture {
 border-collapse:collapse;
}
table.facture th {
    padding: 2px;
}
table.facture th{
    border:1px solid black;
    font-size : 10px;
}
table.facture td {
    border:1px solid black;
    border-left : 1px;
    border-bottom: 0px;
    font-size : 10px;
}

</style>
<?php
    $result=$objet->db->requete($objet->depot());     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    foreach($rows as $row){
        if(($rupture==0 && $cmp==0)|| $rupture==1){
        if($depot_no==0 || $depot_no==$row->DE_No){
            $val=0;
            $val_nom=$row->DE_Intitule;
            if($rupture==1){
                $val=$row->DE_No;
            }
            if($choix_inv!=2)
                $result=$objet->db->requete($objet->livretInventaireCumulStock(" ReqGlobal.DE_No,fDep.DE_Intitule,ReqGlobal.IntituleTri,ReqGlobal.IntituleTri2,fArt.AR_Ref,fArt.AR_Design,fArt.AR_SuiviStock,ReqGlobal.AG_No1,ReqGlobal.AG_No2,ReqGlobal.Enumere1,ReqGlobal.Enumere2,ReqGlobal.AE_Ref,ReqGlobal.LS_NoSerie,ReqGlobal.LS_Peremption,ReqGlobal.LS_Fabrication,CASE WHEN 0 = 0 THEN 1 ELSE ISNULL(fCondi.EC_Quantite,1)END",$val,$articledebut,$articlefin));
            else
                $result=$objet->db->requete($objet->livretInventaireDate($datedeb,$articledebut,$articlefin,$val));

            $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $qte=0; 
        $cumul=0;
        $CA_NET_HT=0;
        $MARGE=0;
        $classe="";
        $ref="";
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
        <tr style="text-align: center">
            <?php if($rupture==0 && $depot_no==0) echo "<th>Dépot</th>"; ?>
            <th>Référence</th>
            <th>Désignation</th>
            <th>Qté en stock</th>
            <?php if($flagPxRevient==0) echo "<th>P.R. unitaire</th>
            <th>P.R. global</th>";?>
        </tr>
    </thead>
    <tbody>
        <?php
        if($rows==null){
        }else{
            $qtestk=0;
            $pr=0;
            $prglobal=0;
            foreach ($rows as $row){
                $i++;
                $qtestk=$qtestk+ROUND($row->Qte,2);
                $prglobal =$prglobal +ROUND($row->PR,2);
                $pr= $pr+ROUND($row->Qte *$row->PR,2);
                echo "<tr class='eqstock'>";
                if($rupture==0 && $depot_no==0) echo "<td>".$row->DE_Intitule."</td>";
                echo "<td>".$row->AR_Ref."</td>"
                    ."<td>".$row->AR_Design."</td>"
                    ."<td>".ROUND($row->Qte,2)."</td>";
                if($flagPxRevient==0) echo  "<td>".$objet->formatChiffre(ROUND($row->PR/$row->Qte ,2))."</td>"
                    ."<td>".$objet->formatChiffre(ROUND($row->PR,2))."</td>";
                echo "</tr>";
            }
            echo "<tr style='background-color: #46464be6;color: white;font-weight: bold;'><td>Total</td>";
            if($rupture==0 && $depot_no==0) echo "<td></td>";
            echo "<td></td><td>$qtestk</td>";
            if($flagPxRevient==0) echo  "<td>".$objet->formatChiffre(ROUND($prglobal/$qtestk,2))."</td><td>".$objet->formatChiffre($prglobal)."</td>";
            echo "</tr>";
        }
        
    ?>
        </tbody>
    </table>
</page>
<?php 
        }
        $cmp++;
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
        $html2pdf->Output('LIVRET_INVENTAIRE.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>