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
	$clientnom="";
    if(isset($_GET["debut"]) && !empty($_GET["debut"]))
        $datedeb=$_GET["debut"];
    if(isset($_GET["fin"]) && !empty($_GET["fin"]))
        $datefin=$_GET["fin"];
    if(isset($_GET["depot"]))
        $depot_no=$_GET["depot"];
    
     $resultclient=$objet->db->requete($objet->getAllinfoClientByCTNum($depot_no));     
        $rowsclient = $resultclient->fetchAll(PDO::FETCH_OBJ);
		$i=0;
		if($rowsclient==null){
            echo "<tr><td>Aucun client trouvé ! </td></tr>";
        }else{
            foreach ($rowsclient as $rowclient){
                $i++;
                $clientnom=$rowclient->CT_Intitule;
            }
		} 
	
?>
<br/><br/>	
 <h4 style="text-align:center">RELEVE COMPTE DU CLIENT <?php echo $clientnom; ?><br/>POUR LA PERIODE DU <?php echo $datedeb; ?> AU <?php echo $datefin; ?></h4>
<table style="width:730px;border:1;border-radius:12" align="center">
<tr>
			<th style='width:70px'>Date</th>
			<th style='width:70px'>Livraison</th>
			<th style='width:50px'>Retard</th>
                        <th style='width:100px'>Pièce</th>
			<th style='width:100px'>BL</th>
			<th style='width:120px'>Net à payer</th>
                        <th style='width:120px'>Règlement</th>
                        <th style='width:100px'>Solde</th>
			</tr>	
<?php
	$result=$objet->db->requete($objet->releveCompteClient($depot_no, $datedeb, $datefin));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $classe="";
        if($rows==null){
            echo "<tr><td>Aucun élément trouvé ! </td></tr>";
        }else{
            foreach ($rows as $row){
                $do_date=$row->DO_DATE;
                $dr_date=$row->DR_DATE;
                if($do_date=='1960-01-01'){ 
                    $do_date='';
                    $dr_date='';
                }
                $i++;
            if($i%2==0) $classe = "info";
                    else $classe="";
                echo "<tr class='eqstock $classe'>"
                ."<td style='width:50px' align='center'>".$do_date."</td>"
                ."<td style='width:50px' align='center'>".$dr_date."</td>"
                ."<td style='width:30px' align='center'>".$row->RETARD."</td>"
                ."<td style='width:100px' align='center'>".$row->DO_PIECE."</td>"
                ."<td style='width:100px' align='center'>".$row->DO_REF."</td>"
                ."<td style='width:150px' align='center'>".number_format(round($row->NET_VERSER,2), 2, ',', ' ')."</td>"
                ."<td style='width:150px' align='center'>".number_format(round($row->REGLEMENT,2), 2, ',', ' ')."</td>"
                ."<td style='width:100px' align='center'>".number_format(round($row->cumul,2), 2, ',', ' ')."</td>"
                . "</tr>";
            }
            
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
			'file' => 'Releve_Compte_client.pdf',
			'content' => $content
		);
 require_once("../etatspdf/pdf.php");
?>