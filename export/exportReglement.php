<?php 
ob_start();
use Spipu\Html2Pdf\Html2Pdf;
include("../Modele/DB.php");
include("../Modele/ObjetCollector.php");
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
    
    $bp=$rows[0]->D_CodePostal." ".$rows[0]->D_Ville." ".$rows[0]->D_Pays;
    $rcn=$rows[0]->D_Identifiant;
    $nc=$rows[0]->D_Siret;
}
$intitule="";
$comptet = new ComptetClass($_GET["CT_Num"]);
$intitule=$comptet->CT_Intitule;

$requete="SELECT ISNULL(RC_Montant,0) AS RC_Montant, C.RG_No,DO_PIECE,RIGHT( '00'+CAST(DAY(RG_Date) AS VARCHAR(2)),2)+'/'+RIGHT( '00'+CAST(MONTH(RG_Date)AS VARCHAR(2)),2)+'/'+CAST(YEAR(RG_Date) AS VARCHAR(4))  AS RG_Date,RG_Libelle,RG_Montant,CA_No
FROM F_CREGLEMENT C
LEFT JOIN (SELECT RG_No,DO_PIECE,sum(RC_Montant) AS RC_Montant FROM F_REGLECH GROUP BY RG_No,DO_PIECE) R ON R.RG_No=c.RG_No
WHERE C.RG_NO= ".$_GET["RG_NO"]." ORDER BY RG_DATE DESC;";
$result=$objet->db->requete($requete);     
$rows = $result->fetchAll(PDO::FETCH_OBJ);

$total = 0;
        for($i=0;$i<count($rows);$i++){
            $total=$total+round($rows[$i]->RC_Montant,0);
        }
    ?>
<style>
#bloc{
    font-size:15px;
}
table.facture {
}
table.facture th , table.facture td{
    padding-left: 10px;
    padding-right: 10px;
}
table.facture td {
}

</style>
<div id="bloc">    
<table>
        <tr>
            <td style="width: 400px">
                <?php echo "<b>".$nomSociete."</b><br/>".$profession."<br/>BP ".$cp." ".$ville."<br/>"; ?>
            </td>
            <td>
                <?php echo $intitule; ?>
            </td>
        </tr>
    </table>
    <br/>
    <div style="font-size:28px" id="numFacture">Recu de règlement<br/></div>
    <br/>
    <div style="text-align:right" id="date"><b>Numéro : <?php echo $_GET["RG_NO"];?></b></div>
    <div>Cher client,<br/><br/>
    Nous avons bien recu votre règlement et nous vous en remercions.<br/>
    Veuillez prendre note des échéances auxquelles il se rapporte :<br/><br/>
    </div>
    <table>
        <tr>
            <td style="width: 300px">Règlement en date du </td>
            <td>Pour un montant de : <b><?php echo $objet->formatChiffre($total); ?></b></td></tr>
    </table>
<br/>        
        <table id="table" class="facture" style="">
            <thead>
            <tr>
                <th style="text-align:left">N de facture</th>
                <th style="text-align:left">Date</th>
                <th style="text-align:left">Votre référence</th>
                <th style="text-align:left">Date échéance</th>
                <th style="text-align:left">Montant échéance</th>
                <th style="text-align:left">Règlement</th>
            </tr>
            </thead>
        <tbody>
<?php
        for($i=0;$i<count($rows);$i++){
            echo "<tr><td style='text-align:left'>".$rows[$i]->DO_PIECE."</td>\n\
            <td style='text-align:left'>".$rows[$i]->RG_Date."</td><td style='text-align:left'>".$rows[$i]->RG_Libelle."</td>"
            . "<td style='text-align:left'>".$rows[$i]->RG_Date."</td>"
            ."<td style='text-align:left'>".$objet->formatChiffre(round($rows[$i]->RG_Montant,0))."</td>"
            ."<td style='text-align:left'>".$objet->formatChiffre(round($rows[$i]->RC_Montant,0))."</td></tr>";
        }
        ?>
        </tbody>
        </table>
        <br/><div><br/>Recevez cher client, nos sincères salutations<br/></div>
        <div style="text-align:right"><b>La caisière</b></div>
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
        $html2pdf->Output('REGLEMENT.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>