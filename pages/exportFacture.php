<html>
    <head>
        <meta charset="UTF-8">
        <title>Facturation</title>
    </head>
<?php
function asLetters($number) {
    $convert = explode('.', $number);
    $num[17] = array('zero', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit',
                     'neuf', 'dix', 'onze', 'douze', 'treize', 'quatorze', 'quinze', 'seize');
                      
    $num[100] = array(20 => 'vingt', 30 => 'trente', 40 => 'quarante', 50 => 'cinquante',
                      60 => 'soixante', 70 => 'soixante-dix', 80 => 'quatre-vingt', 90 => 'quatre-vingt-dix');
                                      
    if (isset($convert[1]) && $convert[1] != '') {
      return asLetters($convert[0]).' et '.asLetters($convert[1]);
    }
    if ($number < 0) return 'moins '.asLetters(-$number);
    if ($number < 17) {
      return $num[17][$number];
    }
    elseif ($number < 20) {
      return 'dix-'.asLetters($number-10);
    }
    elseif ($number < 100) {
      if ($number%10 == 0) {
        return $num[100][$number];
      }
      elseif (substr($number, -1) == 1) {
        if( ((int)($number/10)*10)<70 ){
          return asLetters((int)($number/10)*10).'-et-un';
        }
        elseif ($number == 71) {
          return 'soixante-et-onze';
        }
        elseif ($number == 81) {
          return 'quatre-vingt-un';
        }
        elseif ($number == 91) {
          return 'quatre-vingt-onze';
        }
      }
      elseif ($number < 70) {
        return asLetters($number-$number%10).'-'.asLetters($number%10);
      }
      elseif ($number < 80) {
        return asLetters(60).'-'.asLetters($number%20);
      }
      else {
        return asLetters(80).'-'.asLetters($number%20);
      }
    }
    elseif ($number == 100) {
      return 'cent';
    }
    elseif ($number < 200) {
      return asLetters(100).' '.asLetters($number%100);
    }
    elseif ($number < 1000) {
      return asLetters((int)($number/100)).' '.asLetters(100).($number%100 > 0 ? ' '.asLetters($number%100): '');
    }
    elseif ($number == 1000){
      return 'mille';
    }
    elseif ($number < 2000) {
      return asLetters(1000).' '.asLetters($number%1000).' ';
    }
    elseif ($number < 1000000) {
      return asLetters((int)($number/1000)).' '.asLetters(1000).($number%1000 > 0 ? ' '.asLetters($number%1000): '');
    }
    elseif ($number == 1000000) {
      return 'millions';
    }
    elseif ($number < 2000000) {
      return asLetters(1000000).' '.asLetters($number%1000000);
    }
    elseif ($number < 1000000000) {
      return asLetters((int)($number/1000000)).' '.asLetters(1000000).($number%1000000 > 0 ? ' '.asLetters($number%1000000): '');
    }
  }
include("Modele/DB.php");
include("Modele/ObjetCollector.php");
$objet = new ObjetCollector();   
$requete="SELECT DO_Piece,AR_Ref,DL_Design,ROUND(DL_Qte,2) AS DL_Qte,ROUND(DL_PrixUnitaire,2) AS DL_PrixUnitaire,DL_Taxe1,DL_Taxe2,DL_Taxe3,ROUND(DL_MontantTTC,2) AS DL_MontantTTC,DL_Ligne  FROM F_DOCLIGNE  WHERE DO_Piece ='" . $_GET["DO_Piece"] . "'";
$result=$objet->db->requete($requete);     
$rows = $result->fetchAll(PDO::FETCH_OBJ);


$html = '
    <div style="text-align: right;font-weight: bold;clear:both">Sarl<hr></div>
    <div style="text-align: right;font-weight: bold;">Import-Export</div>
    <div style="text-align: center" id="nomClient"><b>NOM DU CLIENT : '.$_GET["CT_Num"].'</b></div>
    <div style="float: left" id="numFacture"><b>Facture N </b>'.$_GET["DO_Piece"].'</div><div style="float:right" id="date">Douala le, '.date("m/d/y").'</div>
        <br/><table id="table" class="table" style="border-collapse:collapse;width:90%;border:1px solid black;">
 
            <thead>
            <tr>
                <th style="border:1px solid black;">Code</th>
                <th style="border:1px solid black;">D&eacute;signation</th>
                <th style="border:1px solid black;">Quantit&eacute;</th>
                <th style="border:1px solid black;">PU</th>
                <th style="border:1px solid black;">Montant</th>
            </tr>
            </thead>
    <tbody>';      
$total = 0;
        for($i=0;$i<count($rows);$i++){
            $total = $total + round($rows[$i]->DL_MontantTTC,0);
            $html= $html."<tr><td style='border-right: 1px solid;'>".$rows[$i]->AR_Ref."</td>\n\
            <td style='border-right: 1px solid;'>".$rows[$i]->DL_Design."</td><td style='border-right: 1px solid;text-align:right'>".round($rows[$i]->DL_Qte,0)."</td>"
            . "<td style='border-right: 1px solid;text-align:center'>".round($rows[$i]->DL_PrixUnitaire,2)."</td>"
            ."<td style='border-right: 1px solid;text-align:right'>".round($rows[$i]->DL_MontantTTC,0)."</td></tr>";
        }
        
      $html= $html.'
          <tr><td style="border-top: 1px solid"></td><td style="border-top: 1px solid"></td><td style="border-top: 1px solid"></td><td style="border-right: 1px solid;border-top: 1px solid;text-align:right"><b>Total TTC</b></td><td style="border-right: 1px solid;text-align:right;border-top: 1px solid"><b>'.$total.'</b></td></tr>
    </tbody>
        </table>
        <br/>
        <div>Arr&ecirc;t&eacute;e la pr&eacute;sente Facture &agrave; la somme de :<b>'.asLetters($total).' Francs FCFA</b></div>
        <div><b>N.B.</b> Les marchandises vendues ne sont ni reprises, ni &eacute;chang&eacute;es.</div>
        <hr>
        <div style="float:left" id="cp">BP : 1432 Douala</div><div style="float: left;text-align: center;margin-left: 0px;">Situ&eacute; &agrave; la rue de la triperie du March&eacute; de Mboppi <br/>N Contrib : M101100038324S - RC RC/DLA/2011/B/2266</div>
        <div style="float:right" id="coordonee">Tel : 33 41 50 17<br/>Email : zuminegoce@yahoo.fr</div>';
include("mpdf60/mpdf.php");
$mpdf=new mPDF('c'); 
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
?>