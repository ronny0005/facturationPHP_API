<?php 
ob_start(); 
set_time_limit(0);
ini_set('max_execution_time', 0);
$daydate=date('d-m-Y H:i:s');
require_once("../Modele/DB.php");
require_once("../Modele/ObjetCollector.php");
?>
<div style="width:730px;">

<?php 
	$objet = new ObjetCollector(); 
    $datedeb=date("Y-m-d");
    $datefin=date("Y-m-d"); 
    $depot_no=0;
	$depotnom="";
    if(isset($_GET["debut"]) && !empty($_GET["debut"]))
        $datedeb=$_GET["debut"];
    if(isset($_GET["fin"]) && !empty($_GET["fin"]))
        $datefin=$_GET["fin"];
    if(isset($_GET["depot"]))
        $depot_no=$_GET["depot"];
	
    $resultdepot=$objet->db->requete($objet->getDepotByDE_No($depot_no));     
    $rowsdepot = $resultdepot->fetchAll(PDO::FETCH_OBJ);
    $i=0;
    if($rowsdepot==null){
        //echo "<tr><td>Aucun depot trouvé ! </td></tr>";
    }else{
        foreach ($rowsdepot as $rowdepot){
           $i++;
           $depotnom=$rowdepot->DE_Intitule;
        }
    }
	
?>
<br/><br/>	
<?php
    if ($_GET["depot"]==0){
     echo'<h4 style="text-align:center">STATISTIQUE ARTICLES TOUTES AGENCES <br/>POUR LA PERIODE DU '.$datedeb.'  AU  '.$datefin.'</h4>';   
    }else{
      echo'<h4 style="text-align:center">STATISTIQUE ARTICLES DE '.$depotnom.'<br/>POUR LA PERIODE DU '.$datedeb.' AU '.$datefin.'</h4>';  
    }
?>
<table style="width:730px;border:1;border-radius:12" align="center">
<tr>
    <?php if($depot_no==0) echo "<th style='width:50px'>Agence</th>"; ?>
    <th style='width:60px'>Référence</th>
    <th style='width:120px'>Désignation</th>
    <th style='width:70px'>CA Net HT</th>
    <th style='width:70px'>CA Net TTC</th>
    <th style='width:50px'>Quantités vendues</th>
    <th style='width:75px'>Marge</th>
    <th style='width:75px'>Marge CA</th>
</tr>	
<?php
		
    $result=$objet->db->requete($objet->stat_articleParAgence($depot_no, $datedeb, $datefin,0,0));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $canetht=0;
        $canetttc=0;
        $qte=0;
        $marge=0;
        $margeca=0;
        if($rows==null){
            echo "<tr><td>Aucun élément trouvé ! </td></tr>";
        }else{
            foreach ($rows as $row){
                $i++;
                echo "<tr>";
                if($depot_no==0 ) echo "<td style='width:50px'>".$row->DE_Intitule."</td>"
                ."<td style='width:60px' align='center'>".$row->AR_Ref."</td>"
                ."<td style='width:120px'>".$row->AR_Design."</td>"
                ."<td style='width:70px' align='center'>".ROUND($row->CA_NET_HT,2)."</td>"
                ."<td style='width:70px' align='center'>".ROUND($row->CA_NET_TTC,2)."</td>"
                ."<td style='width:100px' align='center'>".ROUND($row->QTE_VENDU,2)."</td>"
                ."<td style='width:75px' align='center'>".ROUND($row->MARGE,2)."</td>"
                ."<td style='width:75px' align='center'>".ROUND($row->MARGE_CA,2)."</td>"
                . "</tr>";
                $canetht=$canetht+ROUND($row->CA_NET_HT,2);
                $canetttc=$canetttc+ROUND($row->CA_NET_TTC,2);
                $qte=$qte+ROUND($row->QTE_VENDU,2);
                $marge=$marge+ROUND($row->MARGE,2);
                $margeca=$margeca+ROUND($row->MARGE_CA,2);
            }
            
        echo "<tr style='background-color: #46464be6;color: white;font-weight: bold;'>";
         if($depot_no==0 ){echo "<td style='width:110px' align='center'>Total</td><td style='width:100px' align='center'></td>";
        } else{echo "<td >Total</td>";}
            echo "<td></td><td>$canetht</td><td>$canetttc</td><td>$qte</td><td>$marge</td>"
                . "<td>$margeca</td></tr>";
        }
?>		
</table><br/><br/><br/>	
<br/><br/><br/><br/>

</div>
<?php $content = ob_get_clean(); 
ob_end_clean();
                $params = array(
			'margin-top' => '35mm',
			'margin-left' => '3mm',
			'margin-bottom' => '20mm',
			'margin-right' => '0mm',
			'orientation' => 'p',
			'format' => 'A5',
			'lang' => 'fr',
			'display' => 'fullpage',
			'file' => 'statistique_article_par_agence.pdf',
			'content' => $content
		);
 require_once("../etatspdf/pdf.php");
?>