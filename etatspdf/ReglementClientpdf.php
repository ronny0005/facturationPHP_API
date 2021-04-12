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
 <h4 style="text-align:center">REGLEMENTS DU CLIENT <?php echo $clientnom; ?><br/>POUR LA PERIODE DU <?php echo $datedeb; ?> AU <?php echo $datefin; ?></h4><br/>
<table style="width:730px;border:1;border-radius:12" align="center">
        <tr>	
            <th style='width:100px'>Date</th>
            <th style='width:200px'>Libelle</th>
            <th style='width:100px'>Montant</th>
            <th style='width:100px'>Solde</th>
            <th style='width:100px'>Caisse</th>
            <th style='width:100px'>Caissier</th>
        </tr>	
<?php
    $result=$objet->db->requete($objet->getReglement($depot_no,$datedeb,$datefin));     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    $i=0;
    $classe="";
    if($rows==null){
        echo "<tr><td>Aucun élément trouvé ! </td></tr>";
    }else{
        foreach ($rows as $row){
        $i++;
        
        //Formatage de la date du reglement
	  $resultdate=$objet->db->requete($objet-> getDateEnJMA($row->RG_Date)); 
	 while ($re = $resultdate->fetch()) {$dateok=$re[0];
	 }
        echo "<tr>"
                . "<td style='width:100px'>".$dateok."</td>"
                . "<td style='width:200px'>".$row->RG_Libelle."</td>"
                . "<td style='width:100px'>".round($row->RG_Montant)."</td>"
                . "<td style='width:100px'>".round($row->RC_Montant)."</td>"
                . "<td style='width:100px'>".$row->CA_Intitule."</td>"
                . "<td style='width:100px'>".$row->CO_Nom."</td>"
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
			'file' => 'Reglement_Client.pdf',
			'content' => $content
		);
 require_once("../etatspdf/pdf.php");
?>