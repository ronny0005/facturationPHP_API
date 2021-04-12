<?php 
ob_start(); 
set_time_limit(0);
ini_set('max_execution_time', 0);
$daydate=date('d-m-Y H:i:s');
require_once("../Modele/DB.php");
require_once("../Modele/ObjetCollector.php");
?>
<div style="width:730px;font-size: 9px">

<?php
$objet = new ObjetCollector(); 
$cat_tarif=0;
$intitule="";
$telecopie="";
$email="";
$adresse="";
$numcontribuable="";
$ville="";
$registrecommerce ="";
$cat_compta=0;
$libcat_tarif="";
$libcat_compta="";
$entete="";
$affaire="";
$souche="";
$co_no=0;
$depot_no=0;
$modif=0;
$client = "";
$totalht=0;
$tva=0;
$precompte=0;
$marge=0;
$totalttc=0;
$reference="";
$dateEntete=date("Y-m-d");
$type= $_GET["type"];
if($_GET["type"]=="Vente" || $_GET["type"]=="VenteRetour" || $_GET["type"]=="Avoir"){
    $do_domaine = 0;
    $do_type = 6;
}   
if($_GET["type"]=="BonLivraison"){
    $do_domaine = 0;
    $do_type = 3;
}   
if($_GET["type"]=="Devis"){
    $do_domaine = 0;
    $do_type = 0;
}   
if($_GET["type"]=="Achat"){
    $do_domaine = 1;
    $do_type = 16;
} 
    // Données liées au client
    if(isset($_GET["client"])){
        $client=$_GET["client"];
        $result=$objet->db->requete($objet->clientsByCT_Num($_GET["client"]));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if($rows==null){
        }else{
            $cat_tarif=$rows[0]->N_CatTarif;
            $cat_compta=$rows[0]->N_CatCompta;
            $libcat_tarif=$rows[0]->LibCatTarif;
            $libcat_compta=$rows[0]->LibCatCompta;
        }
    }else{
		
	}
	
    // Création de l'entete de document
    if(isset($_GET["entete"]) ){
        $entete = $_GET["entete"];
        $result=$objet->db->requete($objet->getDoPiece($entete,$do_domaine,$do_type));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if($rows==null){
        }else{
            $reference=$rows[0]->DO_Ref;
            $dateEntete=$rows[0]->DO_Date;
        }
    } 
      //date du doc entete
	  $resultdate=$objet->db->requete($objet-> getDateEnJMA($dateEntete)); 
	 while ($re = $resultdate->fetch()) {$dateenJMA=$re[0];
	 }
 
	  //infos client
	  $resultctnum=$objet->db->requete($objet->getCtnumBydopiece($entete)); 
          $rowsctnum = $resultctnum->fetchAll(PDO::FETCH_OBJ);
	  if($rowsctnum==null){
        }else{
            $dotiers=$rowsctnum[0]->DO_Tiers;
        }
		
	if (isset($dotiers)){
		$resultclient=$objet->db->requete($objet->getAllinfoClientByCTNum($dotiers)); 
		$rowsclient = $resultclient->fetchAll(PDO::FETCH_OBJ);
		if($rowsclient==null){
        }else{
            $intitule=$rowsclient[0]->CT_Intitule;
            $adresse=$rowsclient[0]->CT_Adresse;
			$contact=$rowsclient[0]->CT_Contact;
            $codepostal=$rowsclient[0]->CT_CodePostal;
			$coderegion=$rowsclient[0]->CT_CodeRegion;
            $ville=$rowsclient[0]->CT_Ville;
			$registrecommerce=$rowsclient[0]->CT_Identifiant;
            $numcontribuable=$rowsclient[0]->CT_Siret;
			$email=$rowsclient[0]->CT_EMail;
			$telecopie=$rowsclient[0]->CT_Telecopie;
        }
	}	
?>
<div style="float:left;width:690px;height:52px;">
	<table border="0" height="52" width="690">
		<tr>
			<td style='width:500px'>   
				<table border="1" height="52" width="400">
				
				   <tr>
					<th style='width:100px'>Numéro</th>
					<th style='width:200px'>Date</th>
					<th style='width:100px'>N° télécopie client</th>
				   </tr>
				   <tr>
					<td style='width:100px'><?php echo $entete; ?></td>
					<td style='width:200px'> <?php echo $dateenJMA; ?></td>
					<td style='width:100px'><?php echo $telecopie; ?></td>
				   </tr>
				   
				   <tr>
					<th style='width:100px'>Référence</th>
					<th style='width:200px'>N° intracom. client</th>
				   </tr>
				   <tr>
					<td style='width:100px; height:20px'><?php echo $reference; ?></td>
					<td style='width:200px; height:20px' align='left'><?php echo $email; ?></td>
				   </tr>
				
				</table>
			</td>
	   
			<td style='width:35px'>

			</td>
		  
			<td style='width:200px'>
			  <table style="width:180px; height:52; border:1; border-radius:12">
					<tr>
						<td style='width:180px; border:0'>
						 <b><?php echo $intitule; ?></b><br/><br/>
							<?php echo $registrecommerce; ?><br/><br/>
							<?php echo $adresse; ?><br/>
							<?php echo "N° CONT:".$numcontribuable.""; ?><br/>
							<?php echo $ville; ?><br/><br/>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
 

</div>
    <div style="clear:both;"></div>
<br/><br/>	
 <h4 style="text-align:center">BON DE LIVRAISON</h4>
<table style="width:700px; border:1;border-radius:12" align="center">
	<tr >
			<th style='width:80px;'>Référence</th>
			<th style='width:200px;'>Désignation</th>
			<th style='width:50px;'>Prix Unitaire</th>
			<th style='width:50px;'>Quantité</th>
			<th style='width:100px;'>Remise</th>
                        <th style='width:100px;'>Montant HT</th>
			<th style='width:100px;'>Montant TTC</th>
	</tr>	
<?php
	$result=$objet->db->requete($objet->getLigneFacture($entete,$do_domaine,$do_type));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $classe="";
        if($rows==null){
        }else{
            foreach ($rows as $row){
            $i++;
            $prix = $row->DL_PrixUnitaire;
            $remise = $row->DL_Remise;
            $qte=$row->DL_Qte;
            $type_remise = 0;
            $rem=0;
            if(strlen($remise)!=0){
                if(strpos($remise, "%")){
                    $remise=str_replace("%","",$remise);
                $rem = $prix * $remise / 100;
                }
                if(strpos($remise, "U")){
                    $remise=str_replace("U","",$remise);
                    $rem = $remise;
                }
            }else $remise=0;

            if($i%2==0) $classe = "info";
                    else $classe="";
                    $a=round(($prix- $rem)*$qte,0);
                    $b=round(($a * $row->DL_Taxe1)/100,0);
                    $c=round(($a * $row->DL_Taxe2)/100,0);
                    $d=round(($a * $row->DL_Taxe3)/100,0);;
                    $totalht=$totalht+$a;
                    $tva = $tva +$b;
                    $precompte=$precompte+$c;
                    $marge=$marge+$d;
                    $e = round(($a+$b+$c)+$d,0);
                    $totalttc=$totalttc+round(($a+$b+$c)+$d,0);
                echo "<tr style='border-top:1px'>"
                    . "<td style='width:80px; ' align='center'>".$row->AR_Ref."</td>"
                    . "<td style='width:200px;' align='center'>".$row->DL_Design."</td>"
                    . "<td style='width:50px;' align='center'></td>"
                    . "<td style='width:50px;' align='center'>".round($row->DL_Qte)."</td>"
                    . "<td style='width:100px;' align='center'>".$row->DL_Remise."</td>"
                    . "<td style='width:100px;' align='center'></td>"
                    . "<td style='width:100px;' align='center'></td>"
					. "</tr>";

            }
        }
?>		
</table><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
<?php
$montantenlettres=$objet->asLetters($totalttc);
 ?>
 
  <br/><br/>
	
Arrêtée la présente Facture à la somme de : <b> <?php echo $montantenlettres; ?> Francs CFA</b>.<br/><br/>
 <b>N.B.</b> Les marchandises vendues ne sont ni reprises, ni échangées.<br/><br/>
 <div style='text-align:right;width:690px'><b>LA DIRECTION</b></div>
</div>
<?php $content = ob_get_clean(); 
ob_end_clean();
if($_GET["format"]=="A5"){
$params = array(
                'margin-top' => '35mm',
                'margin-left' => '3mm',
                'margin-bottom' => '0mm',
                'margin-right' => '0mm',
                'orientation' => 'L',
                'format' => 'A5',
                'lang' => 'fr',
                'display' => 'fullpage',
                'file' => 'Bon_de_livraison.pdf',
                'content' => $content
        );
}else {
$params = array(
        'margin-top' => '35mm',
        'margin-left' => '3mm',
        'margin-bottom' => '0mm',
        'margin-right' => '0mm',
        'orientation' => 'P',
        'format' => 'A4',
        'lang' => 'fr',
        'display' => 'fullpage',
        'file' => 'Bon_de_livraison.pdf',
        'content' => $content
);
}
 require_once("../etatspdf/pdf.php");
?>
