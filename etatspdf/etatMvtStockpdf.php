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
     echo'<h4 style="text-align:center">MOUVEMENT DU STOCK TOUTES AGENCES <br/>POUR LA PERIODE DU '.$datedeb.'  AU  '.$datefin.'</h4>';   
    }else{
      echo'<h4 style="text-align:center">MOUVEMENT DU STOCK DE '.$depotnom.'<br/>POUR LA PERIODE DU '.$datedeb.' AU '.$datefin.'</h4>';  
    }
?>

 
<table style="width:730px;border:1;border-radius:12" align="center">
<tr>
			<th style='width:90px'>Date</th>
			<th style='width:80px'>Type mouvement</th>
			<th style='width:100px'>Pièce</th>
                        <th style='width:130px'>Référence</th>
			<th style='width:50px'>Quantité en stock</th>
			<th style='width:50px'>Quantité en stock (solde)</th>
                        <th style='width:50px'>Prix unitaire</th>
			<th style='width:80px'>Valeur du stock</th>
			</tr>	
<?php
    $etatList = new EtatClass();
	$result=$objet->db->requete($etatList->stat_mouvementStock($depot_no, $datedeb, $datefin));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $qte=0; 
        $cumul=0;
        $dlprix=0;
        $cumulPrix=0;
        $classe="";
        $ref="";
        if($rows==null){
            echo "<tr><td>Aucun élément trouvé ! </td></tr>";
        }else{
            foreach ($rows as $row){
                if($ref!=$row->AR_Design){
                    $ref=$row->AR_Design;
                    echo "<tr><td></td><td></td><td></td><td><b>$ref</b></td><td></td><td></td><td></td><td></td></tr>";
                    $i=0;
                }
                $ref=$row->AR_Design;
                $i++;
                echo "<tr>"
                ."<td style='width:90px' align='center'>".$row->DO_Date."</td>"
                ."<td style='width:80px' align='center'></td>"
                ."<td style='width:100px' align='center'>".$row->DO_Piece."</td>"
                ."<td style='width:130px' align='center'>".$row->DE_Intitule."</td>"
                ."<td style='width:50px' align='center'>".ROUND($row->DL_Qte,2)."</td>"
                ."<td style='width:50px' align='center'>".ROUND($row->cumul,2)."</td>"
                ."<td style='width:50px' align='center'>".ROUND($row->DL_PrixRU,2)."</td>"
                ."<td style='width:80px' align='center'>".ROUND($row->cumul_PRIX,2)."</td>"
                ."</tr>";
                $qte=$qte+ROUND($row->DL_Qte,2);
                $cumul=$cumul+ROUND($row->cumul,2);
                $dlprix=$dlprix+ROUND($row->DL_PrixRU,2);
                $cumulPrix=$cumulPrix+ROUND($row->DL_PrixRU,2);
            }
            
        echo "<tr style='background-color: #46464be6;color: white;font-weight: bold;'><td>Total</td><td></td><td></td><td></td><td>$qte</td><td>$cumul</td>"
                . "<td>$dlprix</td><td>$cumulPrix</td></tr>";
        }	
?>		
</table><br/><br/><br/>	
<br/><br/><br/><br/>

</div>
<?php 
$content = ob_get_clean();
ob_end_clean();
$params =   array(
                'margin-top' => '35mm',
                'margin-left' => '3mm',
                'margin-bottom' => '20mm',
                'margin-right' => '0mm',
                'orientation' => 'p',
                'format' => 'A5',
                'lang' => 'fr',
                'display' => 'fullpage',
                'file' => 'etat_Mouvement_Stock.pdf',
                'content' => $content
            );
 require_once("../etatspdf/pdf.php");
?>