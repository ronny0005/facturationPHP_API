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
    if(isset($_GET["depot"])) $depot_no=$_GET["depot"];
	
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
     echo'<h4 style="text-align:center">ECHEANCE CLIENT TOUTES AGENCES <br/>POUR LA PERIODE DU '.$datedeb.'  AU  '.$datefin.'</h4>';   
    }else{
      echo'<h4 style="text-align:center">ECHEANCE CLIENT DE '.$depotnom.'<br/>POUR LA PERIODE DU '.$datedeb.' AU '.$datefin.'</h4>';  
    }
?>
<table style="width:730px;border:1;border-radius:12" align="center">
<tr>                    
    <?php if($depot_no==0) echo "<th style='width:150px'>Agence</th>"; ?>
   <th style='width:100px'>Numéro client</th>
   <th style='width:300px'>Nom client</th>
   <th style='width:150px'>Montant</th>
</tr>	
<?php
	 
    $result=$objet->db->requete($objet->echeance_client($depot_no, $datedeb, $datefin));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        if($rows==null){
            echo "<tr><td>Aucun élément trouvé ! </td></tr>";
        }else{
            $total=0;
            foreach ($rows as $row){
                $i++;
                echo "<tr>";
                if($depot_no==0) echo "<td style='width:150px'>".$row->DE_Intitule."</td>";
                echo "<td style='width:100px' align='center'>".$row->CT_NUM."</td>"
                ."<td style='width:300px'>".$row->CT_Intitule."</td>"
                ."<td style='width:150px' align='center'>".$objet->formatChiffre(ROUND($row->MONTANT,2))."</td>"
                . "</tr>";
                $total=$total+ROUND($row->MONTANT,2);
            }
            echo "<tr style='background-color: #46464be6;color: white;font-weight: bold;'><td>Total</td>";
            if($depot_no==0) echo "<td></td>";
            echo "<td></td><td>".$objet->formatChiffre($total)."</td></tr>";
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
                'file' => 'echeance_client.pdf',
                'content' => $content
		);
 require_once("../etatspdf/pdf.php");
?>