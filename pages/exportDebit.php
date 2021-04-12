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
//include("Modele/DB.php");
//include("Modele/ObjetCollector.php");
//$objet = new ObjetCollector();   
//$requete="SELECT DO_Piece,AR_Ref,DL_Design,ROUND(DL_Qte,2) AS DL_Qte,ROUND(DL_PrixUnitaire,2) AS DL_PrixUnitaire,DL_Taxe1,DL_Taxe2,DL_Taxe3,ROUND(DL_MontantTTC,2) AS DL_MontantTTC,DL_Ligne  FROM F_DOCLIGNE  WHERE DO_Piece ='" . $_GET["DO_Piece"] . "'";
//$result=$objet->db->requete($requete);     
//$rows = $result->fetchAll(PDO::FETCH_OBJ);
?>
    <style>
        table {
            border-collapse: collapse;
        }

        table, th {
            border: 1px solid black;
            font-size : 12px;
        }
        
        tr {
            font-size : 12px;
        }
        
        body {
            font-size : 12px;
            width: 1000px
        }
        
        .padleft {
            padding-right: 70px;
            padding-left: 10px;
        }
        
        .borderfull{
            border: 1px solid black;
            font-size : 12px;
        }
        .borderlright{
            border-right: 1px solid black;
            border-left: 1px solid black;
            font-size : 12px;
        }
    </style>
    <div style='width: 100%;height:160px;float:left;clear:both'>
        <div style='float:left'>
        <table class='header'>
            <thead>
                <tr>
                    <th class='padleft' style='height: 30px'>Numéro</th>
                    <th class='padleft'>Date</th>
                    <th class='padleft'>N° télécopie client</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class='padleft borderfull' style='padding-bottom: 25px;'>DEB000003</td>
                    <td class='padleft borderfull' style='padding-bottom: 25px;'>18/03/2015</td>
                    <td class='borderfull'></td>
                </tr>
                <tr>
                    <td colspan='2' class='borderfull padleft' style='height: 30px'><b>Référence</b></td>
                    <td class='padleft borderfull' style='height: 30px'><b>N° intracom. client</b></td>
                </tr>
                <tr>
                    <td colspan='2'></td><td class='borderfull padleft' style='height: 30px'>RC</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class='padleft' style='padding-bottom: 12px;float: right;border-radius: 10px;border: 1px solid black;'>
        Nom client <br/>
        RC/DLA/2014/B/3121 <br/>
        BP 3409 Douala <br/>
        N° CONT: MO31200040266S<br/>
        Douala <br/>
    </div>
    </div>
    <br/>
    <div style='font-size: 20px;font-weight: bold'>FACTURE PROFORMA</div>
    <br/><br/>
    <table style='width: 100%;'>
        <thead>
            <tr>
                <th>Référence</th>
                <th>Désignation</th>
                <th>Qté</th>
                <th>Px unitaire</th>
                <th>Remise</th>
                <th>Montant HT</th>
            </tr>
            <tr >
                <td class='borderlright' style='text-align:right'>1000111</td>
                <td class='borderlright'>AGRAFEUSE 24/6 HP45 KANGARO</td>
                <td class='borderlright' style='text-align:right'>2,00</td>
                <td class='borderlright' style='text-align:right'>5000,00</td>
                <td class='borderlright'></td>
                <td style='text-align:center'>10000,00</td>
            </tr>
            <tr >
                <td class='borderlright' style='text-align:right'>1000111</td>
                <td class='borderlright'>AGRAFEUSE 24/6 HP45 KANGARO</td>
                <td class='borderlright' style='text-align:right'>2,00</td>
                <td class='borderlright' style='text-align:right'>5000,00</td>
                <td class='borderlright'></td>
                <td class='borderlright' style='text-align:center'>10000,00</td>
            </tr>
        </thead>
    </table>
    <div style='margin-top: 205px;clear: both;float:right;border: 1px black solid;border-radius: 10px;'>
        <div style='border: 1px black solid;padding:6px 6px 6px 20px;border-radius: 10px;'>Total HT</div>
        <div style='float:right;padding-right: 10px'>10000,00</div>
    </div>
    <br/>
    <br/>
    <div style='clear:both;float:right;margin-right: 100px;margin-top: 15px;'>LA DIRECTION</div>
<?php

//include("mpdf60/mpdf.php");
//$mpdf=new mPDF('c'); 
//$mpdf->WriteHTML($html);
//$mpdf->Output();
//exit;
?>