<?php 
ob_start(); 
set_time_limit(0);
ini_set('max_execution_time', 0);
$daydate=date('d-m-Y H:i:s');
require_once("../Modele/DB.php");
require_once("../Modele/ObjetCollector.php");
session_start();

if($_GET["type"]=="Transfert"){
    $do_domaine = 2;
    $do_type = 23;
}   
if($_GET["type"]=="Entree"){
    $do_domaine = 2;
    $do_type = 20;
}    
if($_GET["type"]=="Sortie"){
    $do_domaine = 2;
    $do_type = 21;
}    
$type=$_GET["type"];
?>
<div style="width:730px;">

<?php 
$objet = new ObjetCollector(); 
$cat_tarif=0;
$cat_compta=0;
$libcat_tarif="";
$libcat_compta="";
$entete="";
$affaire="";
$souche="";
$co_no=0;
$depot_no=0;
$collaborateur=0;
$modif=0;
$client = 0;
$totalht=0;
$totalqte=0;
$tva=0;
$precompte=0;
$marge=0;
$totalttc=0;
$reference="";
$dateEntete=date("Y-m-d");
//    if(isset($_GET["atk"]) && is_numeric($_GET["atk"])){
//        $uid= $_GET["atk"];
//    }

$profil_caisse=0;
$profil_special=0;
$profil_commercial=0;
$profil_daf=0;
$profil_superviseur=0;
$profil_gestionnaire=0;
$objet = new ObjetCollector();
$result=$objet->db->requete($objet->connexionProctection($_SESSION["login"], $_SESSION["mdp"]));
$rows = $result->fetchAll(PDO::FETCH_OBJ);
if($rows!=null){
    $admin=$rows[0]->PROT_Right;
    $vente=$rows[0]->PROT_DOCUMENT_VENTE;
    $rglt=$rows[0]->PROT_DOCUMENT_REGLEMENT;
    if($rows[0]->ProfilName=="VENDEUR")
        $profil_caisse=1;
    if($rows[0]->ProfilName=="COMMERCIAUX" || $rows[0]->ProfilName=="GESTIONNAIRE" || $rows[0]->ProfilName=="VENDEUR")
        $profil_commercial=1;
    if($rows[0]->ProfilName=="RAF" ||$rows[0]->ProfilName=="GESTIONNAIRE" ||$rows[0]->ProfilName=="SUPERVISEUR" )
        $profil_special =1;
    if($rows[0]->ProfilName=="RAF")
        $profil_daf=1;
    if($rows[0]->ProfilName=="SUPERVISEUR")
        $profil_superviseur=1;
    if($rows[0]->ProfilName=="GESTIONNAIRE")
        $profil_gestionnaire=1;
}

// Création de l'entete de document
    if(isset($_GET["entete"])){
        $entete = $_GET["entete"];
        $result=$objet->db->requete($objet->getDoPiece($entete,$do_domaine,$do_type));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if($rows==null){
        }else{
            $reference=$rows[0]->DO_Ref;
            $depot=$rows[0]->DE_No;
            $dotiers=$rows[0]->DO_Tiers;
            $date=$rows[0]->DO_Date;
            $cono=$rows[0]->CO_No;
        }
    }
    //intitule depot
     $resultdepot=$objet->db->requete($objet->getDepotByDE_No($dotiers));     
    $rowsdepot = $resultdepot->fetchAll(PDO::FETCH_OBJ);
    $i=0;
    if($rowsdepot==null){
        //echo "<tr><td>Aucun depot trouvé !</td></tr>";
    }else{
        foreach ($rowsdepot as $rowdepot){
            $i++;
            $depotnom=$rowdepot->DE_Intitule;
        }
    }
    //infos collaborateur
    $resultcollabotareur=$objet->db->requete($objet-> getCollaborateurByCOno($cono)); 
    while ($colla = $resultcollabotareur->fetch()) {
        $nom=$colla['CO_Nom'];
        $prenom=$colla['CO_Prenom'];
    }
//    $resultconnecte=$objet->db->requete($objet->getProfilByid($uid)); 
//    while ($uconnecte = $resultconnecte->fetch()) {
//        $nomuser=$uconnecte['PROT_User'];
//    }
    
//date du doc entete
    $resultdate=$objet->db->requete($objet->getDateEnJMA($date)); 
   while ($re = $resultdate->fetch()) {$dateenJMA=$re[0];
   }
    //infos client
  $resultctnum=$objet->db->requete($objet->getCtnumBydopiece($entete)); 
  $rowsctnum = $resultctnum->fetchAll(PDO::FETCH_OBJ);
  if($rowsctnum==null){
  }else{
      $dotiers2=$rowsctnum[0]->DO_Tiers;
  }	
?>
<div style="float:left;width:690px;height:52px;">
	<table border="0" height="52" width="690">
		<tr>
			<td style='width:400px'>   
				<table border="1" height="52" width="400">
				
				   <tr>
					<th style='width:200px'>N° de Mouvement</th>
					<th style='width:200px'>Date du Document</th>
				   </tr>
				   <tr>
					<td style='width:200px'><?php echo $entete; ?></td>
					<td style='width:200px'><?php echo $dateenJMA; ?></td>
				   </tr>
				   
				   <tr>
					<th style='width:200px'>Référence</th>
					<th style='width:200px'>Saisie par:</th>
				   </tr>
                                  
				   <tr>
					<td style='width:200px; height:20px'><?php echo $reference; ?></td>
                                        <td style='width:200px; height:20px'><?php if(isset($nomuser)){echo $nomuser;} ?> </td>
				   </tr>
				
				</table>
			</td>
	   
			<td style='width:65px'>

			</td>
		  
			<td style='width:200px'>
                            <table style="width:200px; height:52; border:1; border-radius:12">
                                <tr>
                                        <td style='width:180px; border:0'>
                                         <b>AGENCE <?php echo $depotnom; ?></b>
                                        </td>
                                </tr>
                            </table>
			</td>
		</tr>
	</table>
 

</div>
    <div style="clear:both;"></div>
<br/><br/>	

      <h4 style="text-align:center">MOUVEMENT DE SORTIE</h4>  

<table style="width:730px;border:1;border-radius:12" align="center">
<tr>
    <th style='width:50px'>Référence</th>
    <th style='width:175px'>Désignation</th>
    <th style='width:75px'>Prix Unitaire</th>
    <th style='width:100px'>Quantité</th>
    <th style='width:100px'>Remise</th>
    <th style='width:100px'>Montant HT</th>
    <th style='width:100px'>Montant TTC</th>
</tr>	
<?php
   $result=$objet->db->requete($objet->getLigneFactureTransfert($entete,$client,$do_domaine,$do_type));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $id_sec=0;
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
                $a=round(($prix- $rem)*$qte,0);
                $b=round(($a * $row->DL_Taxe1)/100,0);
                $c=round(($a * $row->DL_Taxe2)/100,0);
                $d=($row->DL_Taxe3 * $qte);
                $totalht=$totalht+$a;
                $totalqte=$totalqte+$qte;
                $tva = $tva +$b;
                $precompte=$precompte+$c;
                $marge=$marge+$d;
                $totalttc=$totalttc+round(($a+$b+$c)+$d,0);
            
                echo "<tr><td style='width:50px' align='center'>".$row->AR_Ref."</td>"
                    . "<td style='width:175px'>".$row->DL_Design."</td>";
                    if($profil_gestionnaire==0)
                        echo "<td style='width:75px' align='center'>".round($row->DL_PrixUnitaire,2)."</td>";
                    else
                        echo "<td></td>";
                    echo "<td style='width:100px' align='center'>".round($row->DL_Qte)."</td>";
                    if($profil_gestionnaire==0)
                        echo "<td style='width:100px' align='center'>".$row->DL_Remise."</td>"
                    . "<td style='width:100px' align='center'>".round(($prix- $rem)*$qte)."</td>"
                    . "<td style='width:100px' align='center'>".round($row->DL_MontantTTC)."</td>";
                    else
                        echo "<td></td><td></td><td></td>";
                    echo "</tr>";
            }
                echo "<tr style='background-color: #46464be6;color: white;font-weight: bold;'>
                    <td style='width:50px; border:0'><b>TOTAL</b></td>
                    <td style='width:50px; border:0'></td>
                    <td style='width:50px; border:0'></td>
                    <td style='width:50px; border:0'>".$totalqte."</td>
                    <td style='width:50px; border:0'></td>
                    <td style='width:100px; border:0'><b>".$totalht."</b></td>
                    <td style='width:100px; border:0'><b>".$totalttc."</b></td>
                    </tr>";

        }
?>		
</table><br/><br/><br/>	
<br/><br/><br/><br/>

</div>
<?php 
$content = ob_get_clean(); 
require_once("../vendor/autoload.php");
$type="P"; 
if($_GET["format"]=="A5"){
  $type="L"; 
}
try
    {
        $html2pdf = new HTML2PDF($type, $_GET["format"], 'fr');
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        ob_end_clean();
        $html2pdf->Output('Mouvement_'.$_GET["type"].'.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

?>