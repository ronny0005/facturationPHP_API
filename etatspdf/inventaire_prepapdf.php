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
    $datedeb=""; 
    $depot_no=0;
    $choix_inv = $_GET["choix_inv"];
    if(isset($_GET["debut"]) && !empty($_GET["debut"]))
        $datedeb=$_GET["debut"];
    if(isset($_GET["depot"])){
        $depot_no=$_GET["depot"];
    }
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
     echo'<h4 style="text-align:center">INVENTAIRE PREPARATOIRE TOUTES AGENCES <br/>'; if(isset($datedeb) && !empty($datedeb)){echo ' DU '.$datedeb.'';} echo '</h4>';   
    }else{
      echo'<h4 style="text-align:center">INVENTAIRE PREPARATOIRE DE '.$depotnom.'<br/>'; if(isset($datedeb) && !empty($datedeb)){echo ' DU '.$datedeb.'';} echo'</h4>';  
    }
?>
<table style="width:730px;border:1;border-radius:12" align="center">
  <tr>
    <?php if($depot_no==0) echo "<th style='width:150px'>Agence</th>"; ?>
    <th style='width:50px'>Reference</th>
    <th style='width:200px'>Désignation</th>
    <th style='width:75px'>Quantité</th>
    <th style='width:75px'>Prix Revient</th>
    <?php if(isset($datedeb) && !empty($datedeb)) {echo "<th style='width:75px'>Prix Unitaire</th>
    <th style='width:50px'>Suivi</th> "; } ?>
    
</tr>
<?php
$etat = new EtatClass(0);
    if($choix_inv==1)
        $result=$objet->db->requete($etat->getPreparatoireCumul($depot_no));
    else
        $result=$objet->db->requete($etat->getetatpreparatoire($depot_no,$datedeb));

    $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $total=0;
        if($rows==null){
            echo "<tr><td>Aucun élément trouvé ! </td></tr>";
        }else{
            foreach ($rows as $row){
                $i++;
                echo "<tr>";
                if($depot_no==0 ) echo "<td style='width:150px'>".$row->DE_Intitule."</td>";
                echo "<td style='width:50px'>".$row->AR_Ref."</td>"
                ."<td style='width:200px'>".$row->AR_Design."</td>"
                ."<td style='width:75px'>".$objet->formatChiffre(ROUND($row->Qte,2))."</td>";
                if($choix_inv==2) echo "<td style='width:100px'>".$objet->formatChiffre(ROUND($row->PR,2))."</td>"
                ."<td style='width:75px'>".$objet->formatChiffre(ROUND($row->PU,2))."</td>"
                ."<td style='width:50px'>".$row->SUIVI."</td>";
                echo "</tr>";
                $total=$total+$row->Qte;
            }
        }
         echo "<tr style='background-color: #46464be6;color: white;font-weight: bold;'><td>Total</td>";
        if($depot_no==0) echo "<td></td>";
                
        echo "<td></td><td>$total</td><td></td><td></td><td></td></tr>";
?>		
</table><br/><br/><br/>	
<br/><br/><br/><br/>

</div>
<?php $content = ob_get_clean(); 
ob_end_clean();
            $params = array(
			'margin-top' => '35mm',
			'margin-left' => '0mm',
			'margin-bottom' => '0mm',
			'margin-right' => '0mm',
			'orientation' => 'L',
			'format' => 'A5',
			'lang' => 'fr',
			'display' => 'fullpage',
			'file' => 'Inventaire_Preparatoire.pdf',
			'content' => $content
		);
 require_once("../etatspdf/pdf.php");
?>