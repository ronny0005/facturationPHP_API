<?php
use Spipu\Html2Pdf\Html2Pdf;
set_time_limit(0);
ini_set('max_execution_time', 0);
$daydate=date('d-m-Y H:i:s');
require_once("../Modele/DB.php");
require_once("../Modele/ObjetCollector.php");
require_once("../Modele/Objet.php");
require_once("../Modele/ProtectionClass.php");
require_once("../Modele/ReglementClass.php");
require_once("../Modele/CompteaClass.php");
session_start();
ob_start();
?>
<div style="width:730px;">
<?php
$objet = new ObjetCollector();
$protection = new ProtectionClass($_SESSION["login"],$_SESSION["mdp"],$objet->db);
$dateEntete=date("Y-m-d");
$datedeb = $objet->getDate($_GET["dateDebut"]);
$datefin = $objet->getDate($_GET["dateFin"]);
$statut = $_GET["statut"];
$caNum = $_GET["caNum"];
if($caNum=="Tout")
    $caNum="";
$reglement = new ReglementClass(0,$objet->db);
$rows = $reglement->getMajAnalytique($datedeb, $datefin,1,$caNum);
$comptea = new CompteaClass($caNum,$objet->db);
?><style>
        table {
            font-size: 12px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th{
            vertical-align: middle;
            text-align: center;
            width:100px
        }
    </style>
    <div>
    <h1 style="text-align: center">
        MISE A JOUR ANALYTIQUE
    </h1>
    </div>
    <div style="clear: both"></div>
    <div>Période du <?= $objet->getDateDDMMYYYY($objet->getDate($datedeb)) ?> à <?= $objet->getDateDDMMYYYY($objet->getDate($datefin)) ?></div>
    <?php
    if($caNum!="")
        echo "<div>Compte Analytique : $caNum - {$comptea->CA_Intitule}</div>";
    ?>
    <div>Imprimé par : <?= $protection->PROT_User ?></div><br/>
    <table height="52" width="800">
        <tr>
            <th>N° Reglement</th>
            <th>Date opération</th>
            <th>Compte Générale</th>
            <th style="width: 240px">Libellé</th>
            <th>Montant</th>
            <th>Caisse</th>
            <th>N° Analytique</th>
            <th>Montant Analytique</th>
        </tr>
        <?php
        foreach($rows as $row){
        ?>
            <tr>
                <td><?= $row->RG_No ?></td>
                <td><?= $objet->getDateDDMMYYYY($row->RG_Date) ?></td>
                <td><?= $row->CG_Num ?></td>
                <td><?= $row->RG_Libelle ?></td>
                <td style="text-align: right"><?= $objet->formatChiffre($row->RG_Montant) ?></td>
                <td><?= $row->CA_Intitule ?></td>
                <td><?= $row->CA_Num ?></td>
                <td style="text-align: right"><?= $objet->formatChiffre($row->EA_Montant) ?></td>
            </tr>
            <?php
        }
        ?>
    </table>

</div>
<?php
$content = ob_get_clean();
require_once("../vendor/autoload.php");

try
    {
        $html2pdf = new HTML2PDF("L", "A4", 'fr');
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        ob_end_clean();
        $html2pdf->Output('A4MajAnalytique.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>