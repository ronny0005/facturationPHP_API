<?php
use Spipu\Html2Pdf\Html2Pdf;
set_time_limit(0);
ini_set('max_execution_time', 0);
ob_start();
session_start();
include("../Modele/DB.php");
include("../Modele/ObjetCollector.php");
include("../Modele/Objet.php");
include("../Modele/ComptetClass.php");
include("../Modele/ReglementClass.php");
include("../Modele/ProtectionClass.php");
include("../Modele/EtatClass.php");
$objet = new ObjetCollector();
$nomSociete="";
$bp="";
$rcn="";
$nc="";
$cp="";
$ville = "";
$pays = "";
$tel = "";
$email = "";
$profession = "";
$type=0;
$client="0";
$rgNo = array();
$treglement=0;
$caisse=0;
if(isset($_GET["rgNo"]) && $_GET["rgNo"]!="")
    $rgNo = $_GET["rgNo"];

$creglement = new ReglementClass($rgNo,$objet->db);
$protection = new ProtectionClass("","");
$protection->connexionProctectionByProtNo($_SESSION["id"]);
$result=$objet->db->requete($objet->getNumContribuable());
$rows = $result->fetchAll(PDO::FETCH_OBJ);
if($rows==null){
}
else{
    $nomSociete=$rows[0]->D_RaisonSoc;
    $cp = $rows[0]->D_CodePostal;
    $ville = $rows[0]->D_Ville;
    $pays=$rows[0]->D_Pays;
    $email = $rows[0]->D_EmailSoc;
    $tel = $rows[0]->D_Telephone;
    $profession = $rows[0]->D_Profession;

    $bp="{$rows[0]->D_CodePostal} {$rows[0]->D_Ville} {$rows[0]->D_Pays}";
    $rcn=$rows[0]->D_Identifiant;
    $nc=$rows[0]->D_Siret;
}

?>
    <style>
        #bloc{
            font-size:14px;
        }
        table { width: 100%; }
        table.facture th , table.facture td{
            padding: 10px;
            text-align: center;
        }
        table.facture td {
        }

    </style>
    <div id="bloc">
        <?php
        if(substr($nomSociete,0,3)=="CMI"){
            ?>
            <div>
                <img src="../images/logoCMI.png" height="80" alt="logo">
            </div>
            <?php
        }
        ?>
        <div style="clear: both"></div>
        <div style="float: right">
            <?= "<b> $nomSociete </b><br/> $profession <br/> BP $cp $ville <br/>"; ?>
        </div>
        <br/>
        <div style="width: 100%;float: right">Imprimé par <?= $protection->PROT_User ?> le <?= date('d/m/Y à H:i:s') ?></div>
        <br/>
        <div style="text-align:center; font-size:20px;text-transform: uppercase" id="numFacture"><b><?= $creglement->TitreTypeCaisse($creglement->RG_TypeReg) ?></b><br/></div>
        <br/>

        <br/>
        <table id="table" class="facture" style="width: 100%;">
            <thead>
            <tr>
                <th style="width: 5%"></th>
                <th style="width: 30%">Date</th>
                <th style="width: 30%">Libellé</th>
                <th style="width: 30%">Montant</th>
                <th style="width: 5%"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            echo "<tr>
<td></td>
                    <td>{$objet->getDateDDMMYYYY($creglement->RG_Date)}</td>
                    <td>{$creglement->RG_Libelle}</td>
                    <td>{$objet->formatChiffre(round($creglement->RG_Montant,0))}</td>
                    <td></td>
                </tr>";
            ?>
            <tr style="font-weight: bold">
                <td></td>
                <td style="padding-top: 150px">Caissier</td>
                <td style="padding-top: 150px">Bénéficiaire</td>
                <td style="padding-top: 150px">Contrôleur</td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
<?php
$content = ob_get_clean();

// convert in PDF
require_once("../vendor/autoload.php");
try
{

    $html2pdf = new HTML2PDF('L', 'A4', 'fr');
    $html2pdf->setDefaultFont('Arial');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    ob_end_clean();
    $html2pdf->Output('REGLEMNT.pdf');
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>