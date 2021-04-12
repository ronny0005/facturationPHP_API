<?php
use Spipu\Html2Pdf\Html2Pdf;
set_time_limit(0);
ini_set('max_execution_time', 0);
$daydate=date('d-m-Y H:i:s');
require_once("../Modele/DB.php");
require_once("../Modele/ObjetCollector.php");
require_once("../Modele/Objet.php");
require_once("../Modele/ProtectionClass.php");
require_once("../Modele/DocEnteteClass.php");
require_once("../Modele/ComptetClass.php");
require_once("../Modele/DepotClass.php");
require_once("../Modele/CollaborateurClass.php");
session_start();
ob_start();
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
//
//    if(isset($_GET["atk"]) && is_numeric($_GET["atk"])){
//            $uid= $_GET["atk"];
//        }

    // Création de l'entete de document
$docEntete = new DocEnteteClass($_GET["cbMarq"]);
    if(isset($_GET["cbMarq"])){
        $entete = $docEntete->DO_Piece;
        $reference=$docEntete->DO_Ref;
        $depot=$docEntete->DE_No;
        $dotiers=$docEntete->DO_Tiers;
        $date=$docEntete->DO_Date;
        $cono=$docEntete->CO_No;
    }
    //intitule depot
    $depot = new DepotClass($dotiers);
    $depotnom=$depot->DE_Intitule;

    $collaborateur = new CollaborateurClass($cono);
        $nom= $collaborateur->CO_Nom;
        $prenom= $collaborateur->CO_Prenom;
    $nomuser = $_SESSION["login"];

    $resultdate=$objet->db->requete($objet->getDateEnJMA($date));
   while ($re = $resultdate->fetch()) {$dateenJMA=$re[0];
   }

$profil_caisse=0;
$profil_special=0;
$profil_commercial=0;
$profil_daf=0;
$profil_superviseur=0;
$profil_gestionnaire=0;
$prixRevient=0;
$protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
$admin=$protection->PROT_Right;
$vente=$protection->PROT_DOCUMENT_VENTE;
$rglt=$protection->PROT_DOCUMENT_REGLEMENT;
$prixRevient=$protection->PROT_PX_REVIENT;
if($protection->ProfilName=="VENDEUR")
    $profil_caisse=1;
if($protection->ProfilName=="COMMERCIAUX" || $protection->ProfilName=="GESTIONNAIRE" || $protection->ProfilName=="VENDEUR")
    $profil_commercial=1;
if($protection->ProfilName=="RAF" || $protection->ProfilName=="GESTIONNAIRE" || $protection->ProfilName=="SUPERVISEUR" )
    $profil_special =1;
if($protection->ProfilName=="RAF")
    $profil_daf=1;
if($protection->ProfilName=="SUPERVISEUR")
    $profil_superviseur=1;
if($protection->ProfilName=="GESTIONNAIRE")
    $profil_gestionnaire=1;

?><style>
        table {
            font-size: 12px;
        }
    </style>
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
                                        <td style='width:200px; height:20px'><?= $docEntete->getcbCreateurName() ?></td>
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

      <h4 style="text-align:center">MOUVEMENT D'ENTREE</h4>

<table style="width:730px;border:1;border-radius:12" align="center">
<tr>
    <th style='width:70px'>Référence</th>
    <th style='width:175px'>Désignation</th>
    <th style='width:75px'>Prix Unitaire</th>
    <th style='width:100px'>Quantité</th>
    <th style='width:100px'>Remise</th>
    <th style='width:100px'>Montant HT</th>
    <th style='width:100px'>Montant TTC</th>
</tr>
<?php
    $rows=$docEntete->getLigneFacture();
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
                if($prixRevient==0)
                    echo "<td style='width:75px' align='center'>".$objet->formatChiffre(round($row->DL_PrixUnitaire,2))."</td>";
                else
                    echo "<td></td>";
                echo "<td style='width:100px' align='center'>".$objet->formatChiffre(round($row->DL_Qte))."</td>";
                if($prixRevient==0)
                    echo "<td style='width:100px' align='center'>".$row->DL_Remise."</td>"
                        . "<td style='width:100px' align='center'>".$objet->formatChiffre(round(($prix- $rem)*$qte))."</td>"
                        . "<td style='width:100px' align='center'>".$objet->formatChiffre(round($row->DL_MontantTTC))."</td>";
                else
                    echo "<td></td><td></td><td></td>";
                echo "</tr>";
            }
                echo "<tr style='background-color: #46464be6;color: white;font-weight: bold;'>
                    <td style='width:50px; border:0'><b>TOTAL</b></td>
                    <td style='width:50px; border:0'></td>
                    <td style='width:50px; border:0'></td>
                    <td style='width:50px; border:0'>{$objet->formatChiffre($totalqte)}</td>
                    <td style='width:50px; border:0'></td>
                    <td style='width:100px; border:0'><b>"; if($prixRevient==0) echo $objet->formatChiffre($totalht); echo"</b></td>
                    <td style='width:100px; border:0'><b>"; if($prixRevient==0) echo $objet->formatChiffre($totalttc); echo "</b></td>
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
        $html2pdf->Output($type.'Mouvement_entree.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>