<html>
    <head>
        <meta charset="UTF-8">
        <title>Facturation</title>
    </head>
<?php
include("../Modele/DB.php");
include("../Modele/ObjetCollector.php");
$objet = new ObjetCollector();   
$requete="SELECT ISNULL(RC_Montant,0) AS RC_Montant, C.RG_No,DO_PIECE,RIGHT( '00'+CAST(DAY(RG_Date) AS VARCHAR(2)),2)+'/'+RIGHT( '00'+CAST(MONTH(RG_Date)AS VARCHAR(2)),2)+'/'+CAST(YEAR(RG_Date) AS VARCHAR(4))  AS RG_Date,RG_Libelle,RG_Montant,CA_No
FROM F_CREGLEMENT C
LEFT JOIN (SELECT RG_No,DO_PIECE,sum(RC_Montant) AS RC_Montant FROM F_REGLECH GROUP BY RG_No,DO_PIECE) R ON R.RG_No=c.RG_No
WHERE C.RG_NO= ".$_GET["RG_NO"]." ORDER BY RG_DATE DESC;";
$result=$objet->db->requete($requete);     
$rows = $result->fetchAll(PDO::FETCH_OBJ);

$total = 0;
        for($i=0;$i<count($rows);$i++){
            $total=$total+round($rows[$i]->RC_Montant,0);
        }
$html = '<div style="font-size:10px">
    <div style="text-align: left;"><b>ZUMI SARL BONAMOUSSADI GROS</b> <br/>
    COMMERCE GENERALE<br/>
    BP 1432 DOUALA<br/>
    SITUE PRES DES IMPOTS BONAMOUSSADI<br/>
    237 DOUALA</div>
    <div style="text-align: right" id="nomClient"><b>'.$_GET["CT_Num"].'</b></div>
    <div style="font-size:28px" id="numFacture">Recu de règlement<br/></div>
    <div style="float:right" id="date"><b>Numéro :</b></div>
    <div>Cher client,<br/>
    Nous avons bien recu votre règlement et nous vous en remercions.<br/>
    Veuillez prendre note des échéances auxquelles il se rapporte :<br/><br/>
    </div>
    <div style="float:left;">Règlement en date du </div><div style="float:left;margin-left:20px"> Pour un montant de : '.$total.'</div>
        <br/>
        <table id="table" class="table" style="font-size:10px;width:90%;">
            <thead>
            <tr>
                <th style="text-align:left">N de facture</th>
                <th style="text-align:left">Date</th>
                <th style="text-align:left">Votre référence</th>
                <th style="text-align:left">Date échéance</th>
                <th style="text-align:left">Montant échéance</th>
                <th style="text-align:left">Règlement</th>
            </tr>
            </thead>
        <tbody>';      
        for($i=0;$i<count($rows);$i++){
            $html= $html."<tr><td style='text-align:left'>".$rows[$i]->DO_PIECE."</td>\n\
            <td style='text-align:left'>".$rows[$i]->RG_Date."</td><td style='text-align:left'>".$rows[$i]->RG_Libelle."</td>"
            . "<td style='text-align:left'>".$rows[$i]->RG_Date."</td>"
            ."<td style='text-align:left'>".round($rows[$i]->RG_Montant,0)."</td>"
            ."<td style='text-align:left'>".round($rows[$i]->RC_Montant,0)."</td></tr>";
        }
        
      $html= $html.'
        </tbody>
        </table>
        <br/><div><br/>Recevez cher client, nos sincères salutations<br/></div>
        <div style="text-align:right"><b>La caisière</b></div>
        <br/></div>';
        
echo $html;
include("../mpdf60/mpdf.php");
$mpdf=new mPDF('c'); 
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
?>