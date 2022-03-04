<?php
use Spipu\Html2Pdf\Html2Pdf;
set_time_limit(0);
ini_set('max_execution_time', 0);
ob_start();

include("../Modele/DB.php");
include("../Modele/ObjetCollector.php");
include("../Modele/Objet.php");
include("../Modele/ComptetClass.php");
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
if($_GET["CT_Num"]!="")
    $client =$_GET["CT_Num"];
$treglement=0;
$caisse=0;
if(isset($_GET["RG_No"]) && $_GET["RG_No"]!="")
    $rgNo = explode("|",$_GET["RG_No"]);
if(isset($_GET["datedeb"]))
    $datedeb=date_format(date_create($_GET["datedeb"]),"d/m/Y");
if(isset($_GET["datefin"]))
    $datefin=date_format(date_create($_GET["datefin"]),"d/m/Y");
if(isset($_GET["datedeb"]))
    $datedeb=$_GET["datedeb"];
if(isset($_GET["datefin"]))
    $datefin=$_GET["datefin"];
if(isset($_GET["type"]))
    $type=$_GET["type"];
if(isset($_GET["type"])) $type=$_GET["type"];
if(isset($_GET["caisse"])) $caisse=$_GET["caisse"];
if(isset($_GET["mode_reglement"])) $treglement=$_GET["mode_reglement"];
$protectioncial = new ProtectionClass("","");
$protectioncial->connexionProctectionByProtNo($_SESSION["id"]);
$rows = $protectioncial->getNumContribuable();
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
$intitule="";
$comptet = new ComptetClass($_GET["CT_Num"]);
$intitule=$comptet->CT_Intitule;

$typeRegl="Client";
if(isset($_GET["typeRegl"]))
    $typeRegl=$_GET["typeRegl"];
$typeSelectRegl = 0;
if($typeRegl!="Client") $typeSelectRegl = 1;
$collab= 0;
if($typeRegl=="Collaborateur") $collab=1;
$etat = new EtatClass();
$rows = $etat->getReglementByClient2($client, $caisse, $type, $treglement, $datedeb, $datefin, 0, $collab, $typeSelectRegl,$rgNo);
$total = 0;
foreach ($rows as $row)
    $total=$total+round($row->RC_Montant,0);

    ?>
<style>
#bloc{
    font-size:14px;
}
table.facture {
}
table.facture th , table.facture td{
    padding-left: 10px;
    padding-right: 10px;
    padding-top: 10px;
    padding-bottom: 10px;
}
table.facture td {
}

</style>
<div id="bloc">
    <?php
    if(substr($nomSociete,0,3)=="CMI"){
    ?>
    <div style="float:left">
        <img src="../images/logoCMI.png" height="80" alt="logo">
    </div>
    <?php
    }
    ?>
    <div style="clear: both"></div>
    <div>
        <?= "<b> $nomSociete </b><br/> $profession <br/> BP $cp $ville <br/>"; ?>
    </div>
    <br/>
    <div style="text-align:center; font-size:20px" id="numFacture"><b>REGLEMENT CLIENT</b><br/></div>
    <br/>
    <div style="text-align:right" id="date">Référence</div>
    <div>Cher client,<br/><br/>
    Nous avons bien recu votre règlement et nous vous en remercions.<br/>
    Veuillez prendre note des échéances auxquelles il se rapporte :<br/><br/>
    </div>
    <table>
        <tr>
            <td style="width: 350px">Règlement en date du <?php $datedebf = new DateTime($datedeb);$datefinf = new DateTime($datedeb); echo $datedebf->format("d/m/Y")." au ".$datefinf->format("d/m/Y"); ?></td>
            <td>Pour un montant de : <b><?php echo $objet->formatChiffre($total); ?></b></td></tr>
    </table>
<br/>        
        <table id="table" class="facture" style="">
            <thead>
            <tr>
                <th style="text-align:left">N de facture</th>
                <th style="text-align:left">N° Tiers</th>
                <th style="text-align:left">Date</th>
                <th style="text-align:left;width: 50px">Libellé règlement</th>
                <th style="text-align:left">Montant facture</th>
                <th style="text-align:left">Règlement</th>
                <th style="text-align:left">Reste à régler</th>
            </tr>
            </thead>
        <tbody>
<?php
        $somRG=0;
        $somRC=0;
        $somRegle=0;
        foreach ($rows as $row){
            $somRG=$somRG+$row->RG_Montant;
            $somRC=$somRC+$row->RC_Montant;
            $somRegle=$somRegle+($row->RG_Montant - $row->RC_Montant);
            $datefinf = new DateTime($row->RG_Date);
            echo "<tr>
                    <td style='text-align:left'>{$row->DO_Piece}</td>
                    <td style='text-align:left'>{$row->CT_NumPayeur}</td>
                    <td style='text-align:left;width: 50px'>{$datedebf->format("d/m/Y")}</td><td style='text-align:left'>{$row->RG_Libelle}</td>
                    <td style='text-align:right'>{$objet->formatChiffre(round($row->RG_Montant,0))}</td>
                    <td style='text-align:right'>{$objet->formatChiffre(round($row->RC_Montant,0))}</td>
                    <td style='text-align:right'>{$objet->formatChiffre(ROUND($row->RG_Montant - $row->RC_Montant))}</td>
                </tr>";
        }
        echo "<tr style='font-weight:bold'><td colspan='4'>Total</td><td style='text-align:right'>{$objet->formatChiffre($somRG)}</td>
                    <td style='text-align:right'>{$objet->formatChiffre($somRC)}</td>
                    <td style='text-align:right'>{$objet->formatChiffre($somRegle)}</td></tr>";
        ?>
        </tbody>
        </table>
<br/>
<br/>
<br/>
<br/>
<br/>
<hr/>
<table style="width: 100%">
    <tr>
        <td style="font-size: 12px;width:300px;text-align: center"><?="BP $cp $ville"; ?></td>
        <td style="font-size: 12px;width:500px;text-align: center">Situé à la <br/>N° Contrib : <?= "$rcn - RC $nc"; ?></td>
        <td style="font-size: 12px;width:200px;text-align: center"><?= "Tel : $tel <br/>Email : $email"; ?></td>
    </tr>
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