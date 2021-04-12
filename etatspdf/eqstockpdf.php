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
       // echo "<tr><td>Aucun depot trouvé ! </td></tr>";
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
     echo'<h4 style="text-align:center">EQUATION DU STOCK TOUTES AGENCES <br/>POUR LA PERIODE DU '.$datedeb.'  AU  '.$datefin.'</h4>';   
    }else{
      echo'<h4 style="text-align:center">EQUATION DU STOCK DE '.$depotnom.'<br/>POUR LA PERIODE DU '.$datedeb.' AU '.$datefin.'</h4>';  
    }
?>
<table style="width:730px;border:1;border-radius:12" align="center">
<tr>
    <?php if($depot_no==0) echo "<th style='width:150px'>Agence</th>"; ?>
    <th style='width:150px'>Désignation</th>
    <th style='width:50px'>Stocks</th>
    <th style='width:50px'>Entrées</th>
    <th style='width:50px'>Sorties</th>
    <th style='width:50px'>Stock final</th>
    <th style='width:50px'>Quantités vendues</th>
    <th style='width:50px'>Stocks restants</th>
</tr>	
<?php
		
     $result=$objet->db->requete($objet->equationStkVendeur($depot_no, $datedeb, $datefin));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $classe="";
        $stock=0;
        $entree=0;
        $retours=0;
        $sorties=0;
        $stock_final=0;
        $qte_vendues=0;
        $stk_restant=0;
        if($rows==null){
            echo "<tr><td>Aucun élément trouvé ! </td></tr>";
        }else{
            foreach ($rows as $row){
                $i++;
                echo "<tr>";
                if($depot_no==0 ) echo "<td style='width:150px'>".$row->DE_Intitule."</td>";
                echo "<td style='width:150px'>".$row->AR_Design."</td>"
                ."<td style='width:50px' align='center'>".$row->STOCKS."</td>"
                ."<td style='width:50px' align='center'>".$row->ENTREES."</td>"
                ."<td style='width:50px' align='center'>".$row->SORTIES."</td>"
                ."<td style='width:50px' align='center'>".$row->STOCK_FINAL."</td>"
                ."<td style='width:50px' align='center'>".$row->QTE_VENDUES."</td>"
                ."<td style='width:50px' align='center'>".$row->STOCK_RESTANTS."</td>"
                . "</tr>";
                $stock=$stock+$row->STOCKS;
                $entree=$entree+$row->ENTREES;
                $sorties=$sorties+$row->SORTIES;
                $stock_final=$stock_final+$row->STOCK_FINAL;
                $qte_vendues=$qte_vendues+$row->QTE_VENDUES;
                $stk_restant=$stk_restant+$row->STOCK_RESTANTS;
            }
        }
        echo "<tr style='background-color: #46464be6;color: white;font-weight: bold;'>";
        if($depot_no==0 ){echo "<td style='width:150px' align='center'>Total</td><td style='width:150px' align='center'></td>";
        } else{echo "<td >Total</td>";}
        echo"<td style='width:50px' align='center'>$stock</td><td style='width:50px' align='center'>$entree</td><td style='width:50px' align='center'>$sorties</td><td style='width:50px' align='center'>$stock_final</td>"
                . "<td style='width:50px' align='center'>$qte_vendues</td><td style='width:50px' align='center'>$stk_restant</td></tr>";
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
			'file' => 'equation_de_stock.pdf',
			'content' => $content
		);
 require_once("../etatspdf/pdf.php");
?>