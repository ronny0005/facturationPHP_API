<?php
// get the HTML
    ob_start();

use Spipu\Html2Pdf\Html2Pdf;
set_time_limit(0);
ini_set('max_execution_time', 0);
$cat_tarif=0;
session_start();
$ca_no = $_GET["caisseComplete"];
$type = $_GET["type_mvt_ent"];
include("../Modele/DB.php");
include("../Modele/Objet.php");
include("../Modele/ObjetCollector.php");
include("../Modele/ProtectionClass.php");
include("../Modele/ReglementClass.php");
$objet = new ObjetCollector();

$datedeb = $objet->getDate($_GET["dateReglementEntete_deb"]);
$datefin = $objet->getDate($_GET["dateReglementEntete_fin"]);
$nomSociete="";
$cp = "";
$ville = "";
$pays="";
$email = "";
$tel = "";
$bp="";
$rcn="";
$nc="";
$profession="";
$result=$objet->db->requete($objet->getNumContribuable());
$rows = $result->fetchAll(PDO::FETCH_OBJ);
if($rows==null){
}
else{
    $nomSociete=$rows[0]->D_RaisonSoc;
    $cp = $rows[0]->D_CodePostal;
    $profession = $rows[0]->D_Profession;
    $ville = $rows[0]->D_Ville;
    $pays=$rows[0]->D_Pays;
    $email = $rows[0]->D_EmailSoc;
    $tel = $rows[0]->D_Telephone;
    $bp=$rows[0]->D_CodePostal." ".$rows[0]->D_Ville." ".$rows[0]->D_Pays;
    $rcn=$rows[0]->D_Identifiant;
    $nc=$rows[0]->D_Siret;
}
?>
<style>
#bloc{
        font-size:14px;
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
    font-size: 10px;
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
<table>
    <tr>
        <td style="width:500px">
            <?php 
                $libcaisse="Toutes les caisses";
                $libtype="Tous les types";
                if($ca_no!=-1){
                    $result=$objet->db->requete($objet->getCaisseByCA_No($ca_no));     
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    $libcaisse = $rows[0]->CA_Intitule;
                }
                if($type==5) $libtype="Mouvement d'entrée";
                if($type==4) $libtype="Mouvement de sortie";
                if($type==2) $libtype="Fond de caisse";
                if($type==3) $libtype="Verst bancaire";
            ?>
            <b>Caisse :</b> <?php echo $libcaisse; ?>  <br/>
            <b>Type de mouvement :</b> <?php echo $libtype; ?>  <br/>
            <b>Période de :</b> <?php $dated = new DateTime($datedeb);$datef = new DateTime($datefin);  echo $dated->format('d/m/y')." à ".$datef->format('d/m/y'); ?>  <br/>
        </td>
    </tr>
</table>

<div><?= "$nomSociete <br> $profession <br> $ville"; ?></div>
<div style="text-align: center"> <?= "<b> $libtype </b>"; ?> </div>

    <div>Date de l'opération :</div>
    <div>Motif :</div>
    <div>Montant :</div>
    <div>Collaborateur :</div>
    <div>Date de l'opération :</div>
<div style="text-align:center">
    <b><?= "Mouvement de caisse"; ?> </b>
</div>
<br/>
<table id="table" class="facture" style="border:1px solid black;">
    <thead>
        <tr style="text-align:center">
        <th style="padding:6px">Numéro</th>
        <th style="padding:6px;width: 200px">N° Piece</th>
        <th style="padding:6px;width: 50px">Date</th>
        <th style="padding:6px;width: 100px">Libelle</th>
        <th style="padding:6px;width: 100px">Montant</th>
        <th style="padding:6px;width: 100px">Caisse</th>
        <th style="padding:6px;width: 100px">Caissier</th>
        <th style="padding:6px;width: 50px">Type</th>
      </tr>
    </thead>
    <tbody id="article_body">
    <?php
        function typeCaisse($val){
            if($val==5) return "Entrée";
            if($val==4) return "Sortie";
            if($val==2) return "Fond de caisse";
            if($val==3) return "Vrst bancaire";
        }
    $reglement = new ReglementClass(0);
    $rows = $reglement->listeReglementCaisse($datedeb,$datefin,$ca_no,$type,$_SESSION["id"]);
        $i=0;
        $classe="";
        $sommeMnt = 0;
        if($rows==null){
            echo "<tr id='reglement_' class='reglement'><td>Aucun élément trouvé ! </td></tr>";
        }else{
            foreach ($rows as $row){
                $rg_banque = $row->RG_Banque;
                $rg_type = $row->RG_Type;
                $rg_typereg = $row->RG_TypeReg;
                if($rg_typereg==4){
                    if($rg_banque==1 && $rg_type==4)
                        $rg_typereg = 3;
                }
                $i++;
                $fichier="";
                $montant = round($row->RG_Montant);
                if($row->RG_TypeReg==3 || $row->RG_TypeReg==4)
                    $montant =$montant*-1; 
                if($i%2==0) $classe = "info";
                else $classe="";
                $sommeMnt = $sommeMnt + $montant;
                $bordure = "";
                $date = new DateTime($row->RG_Date);
                echo "<tr style='padding:10px'>
                        <td style='padding:3px'>{$row->RG_No}</td>
                        <td style='padding:3px$bordure'>{$row->RG_Piece}</td>
                        <td style='padding:3px;text-align:center'>{$date->format('d/m/Y')}</td>
                        <td style='padding:3px;text-align:right'>{$row->RG_Libelle}</td>
                        <td style='padding:3px;text-align:right'>{$objet->formatChiffre($montant)}</td>
                        <td style='padding:3px;text-align:right'>{$row->CA_Intitule}</td>
                        <td style='padding:3px;text-align:right'>{$row->CO_Nom}</td>
                        <td style='padding:3px;text-align:right'>".typeCaisse($rg_typereg)."</td></tr>";
            }
            echo "<tr class='reglement' style='background-color:#a4a4a4;font-weight: bold'><td id='rgltTotal'><b>Total</b></td><td></td><td></td><td></td><td style='padding:3px;text-align:right'><b>{$objet->formatChiffre($sommeMnt)}</b></td><td></td><td></td><td></td><td></td><td></td></tr>";
        }

        ?>
        
    </tbody></table>
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
        $html2pdf->Output('MOUVEMENT_CAISSE.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>