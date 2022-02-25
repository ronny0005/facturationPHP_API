<?php
use Spipu\Html2Pdf\Html2Pdf;
set_time_limit(0);
ini_set('max_execution_time', 0);
include("../Modele/DB.php");
include("../Modele/ObjetCollector.php");
include("../Modele/Objet.php");
include("../Modele/ComptetClass.php");
include("../Modele/DepotClass.php");
include("../Modele/ProtectionClass.php");
include("../Modele/DocEnteteClass.php");

session_start();
ob_start();

$objet = new ObjetCollector();
$format=$_GET["format"];
$comptet = "";
$protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
$docEntete = new DocEnteteClass($_GET["cbMarq"]);
if(isset($_GET["cbMarq"]) ){
    $result=$objet->db->requete($objet->getLibTaxePied($docEntete->DO_Domaine,$docEntete->N_CatCompta));
    $rowsLibelle = $result->fetchAll(PDO::FETCH_OBJ);
    if($rowsLibelle!=null){
        $libelle1 = $rowsLibelle[0]->LIB1;
        $libelle2 = $rowsLibelle[0]->LIB2;
        $libelle3 = $rowsLibelle[0]->LIB3;
    }
    $comptet = new ComptetClass($docEntete->DO_Tiers);
    $nomclient=$comptet->CT_Intitule;
}

$depot = new DepotClass($docEntete->DE_No);

$nomSociete="";
$bp="";
$rcn="";
$nc="";
$cp="";
$ville = "";
$pays = "";
$tel = "";
$email = "";
$D_Profession = "";
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
    $bp=$rows[0]->D_CodePostal." ".$rows[0]->D_Ville." ".$rows[0]->D_Pays;
    $rcn=$rows[0]->D_Identifiant;
    $nc=$rows[0]->D_Siret;
    $D_Profession = $rows[0]->D_Profession;
}
ob_start();
?>
    <style>
        #bloc{
            font-size:11px;
        }
        table.facture {
            border-collapse:collapse;
        }
        table.facture th , table.facture td{
            border:1px solid black;
        }
        table.facture td {
            border-left : 1px;border-bottom: 0px
        }

        table.reglement {
            border-collapse:collapse;
            font-size: 8px;
        }
        table.reglement th, table.reglement td{
            border:1px solid black;
            padding : 5px;
        }
        table.reglement th{
            text-align:center;
        }
        table.reglement td{
            border-left : 1px;border-bottom: 0px
        }

    </style>
    <div id="bloc">
        <div id="entete">
            <table style="width:760px">
                <tr>
                    <td style="width:50%;font-weight: bold;font-size: 20px"><?= $nomSociete ?>
                    </td>
                    <td style="width:50%;text-align: right">Date de tirage <?= date('d/m/Y'); ?> à <?= date('H:i'); ?> </td>
                </tr>
                <tr>
                    <td><?= $D_Profession ?></td>
                    <td></td>
                </tr>
            </table>


            <table style="padding-top: 5px; width:760px">
                <tr style="border:1px solid black">
                    <td style="width:50%">
                        <br/>
                        <table style="width: 100%;border:1px solid black;padding : 5px">
                            <tr>
                                <td style="width: 50%;font-weight: bold">CLIENT</td>
                                <td style="font-weight: bold"><?= $comptet->CT_Intitule ?></td>
                            </tr>
                            <tr>
                                <td style="width: 50%;font-weight: bold">REFERENCE</td>
                                <td style="width: 50%;font-weight: bold"><?= $docEntete->DO_Ref ?></td>
                            </tr>
                        </table>
                    </td>
                    <td style="width:35%">
                        <table style="width: 100%;border:1px solid black;padding : 5px">
                            <tr>
                                <td  style="width: 50%;font-weight: bold;font-size: 20px">BDL</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="width: 50%;font-weight: bold">NUMERO</td>
                                <td style="width: 50%;font-weight: bold"><?= (count($docEntete->getLigneFacture($protection->Prot_No))>0) ? ($docEntete->getLigneFacture($protection->Prot_No))[0]->DL_PieceBL : "" ?></td>
                            </tr>
                        </table>
                        <br/>
                    </td>
                    <td style="width:15%;text-align: center">
                        <?= $protection->PROT_User ?>
                    </td>
                </tr>
            </table>


            <table style="margin-top: 5px; width::760px">
                <tr>
                    <td style="width:50%;font-weight: bold">Date du doc : <?= str_replace('-','/',$objet->getDateDDMMYYYY($docEntete->DO_Date)) ?></td>
                    <td style="width:25%;text-align: center"></td>
                    <td style="width:25%;text-align: center">Page : </td>
                </tr>
            </table>

            <table style="margin-top: 5px; width:760px" class="facture">
                <tr style="text-align:center">
                    <th style="width:50px;padding : 3px">Référence</th>
                    <th style="width:270px;padding : 3px">Désignation</th>
                    <th style="width:30px;padding : 3px">Qté</th>
                    <th style="width:30px;padding : 3px">Qté<br/>Livrée</th>
                    <th style="width:60px;padding : 3px">BL</th>
                    <th style="width:100px;padding : 3px">Dépot</th>
                    <th style="width:10%;padding : 3px">Emplacement</th>
                </tr>
                    <?php
                        $totalMontantHT=0;
                        $totalMontantTTC=0;
                        $totalTaxe1=0;
                        $totalTaxe2=0;
                        $totalTaxe3=0;
                    $totalQte=0;
                    $totalQteBL=0;
                        $rows = $docEntete->getLigneFacture($protection->Prot_No);
                        $numItems = count($rows);
                        $i = 0;
                        foreach ($rows as $row){
                            $i++;
                            $totalMontantTTC= $totalMontantTTC+ROUND($row->DL_MontantTTC,2);
                            $totalMontantHT= $totalMontantHT+ROUND($row->DL_MontantHT,2);
                            $totalTaxe1= $totalTaxe1+ROUND($row->MT_Taxe1,2);
                            $totalTaxe2= $totalTaxe2+ROUND($row->MT_Taxe2,2);
                            $totalTaxe3= $totalTaxe3+ROUND($row->MT_Taxe3,2);
                            $totalQte= $totalQte+ROUND($row->DL_Qte,2);
                            $totalQteBL= $totalQteBL+ROUND($row->Qte_LivreeBL,2);
                    ?>
                <tr>
                            <td style="text-align: center;padding : 3px <?= ($i === $numItems) ? ";border-bottom:1px solid black":"" ?>"><?= $row->AR_Ref ?></td>
                            <td style="text-align: left;padding : 3px <?= ($i === $numItems) ? ";border-bottom:1px solid black":"" ?>"><?= $row->DL_Design ?></td>
                            <td style="text-align: right;padding : 3px <?= ($i === $numItems) ? ";border-bottom:1px solid black":"" ?>"><?= $objet->formatChiffre($row->DL_Qte) ?></td>
                            <td style="text-align: right;padding : 3px <?= ($i === $numItems) ? ";border-bottom:1px solid black":"" ?>"><?= $objet->formatChiffre($row->Qte_LivreeBL) ?></td>
                            <td style="text-align: right;padding : 3px <?= ($i === $numItems) ? ";border-bottom:1px solid black":"" ?>"><?= $row->DO_Piece ?></td>
                            <td style="text-align: right;padding : 3px <?= ($i === $numItems) ? ";border-bottom:1px solid black":"" ?>"><?= (new DepotClass($row->DE_No))->DE_Intitule ?></td>
                            <td style="<?= ($i === $numItems) ? ";border-bottom:1px solid black":"" ?>"><?= $row->DP_Code ?></td>

                </tr>
                    <?php
                        }
                    ?>
                <tr style="text-align:center">
                    <td style="width:50px;padding : 3px;border-right: 0px;border-left: 0px"></td>
                    <td style="width:270px;padding : 3px;border-right: 0px">TOTAL QTE :</td>
                    <td style="width:30px;padding : 3px;border-right: 0px"><?= $objet->formatChiffre($totalQte) ?></td>
                    <td style="width:30px;padding : 3px;border-right: 0px"><?= $objet->formatChiffre($totalQteBL) ?></td>
                    <td style="width:60px;padding : 3px;border-right: 0px"></td>
                    <td style="width:100px;padding : 3px;border-right: 0px"></td>
                    <td style="width:10%;padding : 3px;border-right: 0px"></td>
                </tr>
            </table>


            <table style="width:760px">
                <tr>
                    <td style="width:20%;font-weight: bold">Signature Client</td>
                    <td style="width:20%;font-weight: bold">Signature Magasinier</td>
                </tr>
            </table>
        </div>
    </div>
<?php
$content = ob_get_clean();

// convert in PDF
require_once("../vendor/autoload.php");
try
{
    $type="P";
    if($_GET["format"]=="A5"){
        $type="L";
    }

    $html2pdf = new HTML2PDF($type, $_GET["format"], 'fr');
    $html2pdf->setDefaultFont('Arial');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    ob_end_clean();
    $html2pdf->Output("{$_GET["format"]}_FACTURE.pdf");
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>