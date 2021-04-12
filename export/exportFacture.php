<?php
include("../Modele/DB.php");
include("../Modele/ObjetCollector.php");
include("../Modele/Objet.php");
include("../Modele/ComptetClass.php");
include("../Modele/DepotClass.php");
include("../Modele/ProtectionClass.php");
include("../Modele/DocEnteteClass.php");

session_start();
$objet = new ObjetCollector();
$cat_tarif=0;
$format=$_GET["format"];
$cat_compta=0;
$protected=0;
$entete="";
$affaire="";
$souche="";
$co_no=0;
$depot_no=0;
$modif=0;
$client = "";
$nomclient="";
$totalht=0;
$tva=0;
$precompte=0;
$marge=0;
$totalttc=0;
$reference="";
$dateEntete=date("Y-m-d");
$total_regle=0;
$avance=0;
$reste_a_payer = 0;
$caisse = 0;
$entete="";
$nomEtat="";
$type=$_GET["type"];
$typeFac=0;
$titre_client="Nom du client : ";
$profil_caisse=0;
$profil_special=0;
$profil_commercial=0;
$profil_daf=0;
$profil_superviseur=0;
$profil_gestionnaire=0;


if($_GET["type"]=="Vente" || $_GET["type"]=="VenteRetour" || $_GET["type"]=="Avoir"){
    $do_domaine = 0;
    $do_type = 6;
    $nomEtat="Facture de vente ".$entete;
}
if($_GET["type"]=="BonLivraison"){
    $do_domaine = 0;
    $do_type = 3;
    $nomEtat="Bon de livraison ".$entete;
}
if($_GET["type"]=="Devis"){
    $do_domaine = 0;
    $do_type = 0;
    $nomEtat="Devis ".$entete;
}
if($_GET["type"]=="Achat"){
    $do_domaine = 1;
    $do_type = 16;
    $nomEtat="Facture d'achat ".$entete;
    $titre_client="Nom du fournisseur : ";
    $typeFac=1;
}
if($_GET["type"]=="PreparationCommande"){
    $do_domaine = 1;
    $do_type = 11;
    $nomEtat="Préparation de commande ".$entete;
    $titre_client="Nom du fournisseur : ";
    $typeFac=1;
}
if($_GET["type"]=="AchatPreparationCommande"){
    $do_domaine = 1;
    $do_type = 12;
    $nomEtat="Achat Préparation de commande ".$entete;
    $titre_client="Nom du fournisseur : ";
    $typeFac=1;
}

$libelle1="";
$libelle2="";
$libelle3="";
$nomdepot="";
$depot=0;
$protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
    $admin=$protection->PROT_Right;
    $vente=$protection->PROT_DOCUMENT_VENTE;
    $rglt=$protection->PROT_DOCUMENT_REGLEMENT;
    if($protection->ProfilName=="VENDEUR")
        $profil_caisse=1;
    if($protection->ProfilName=="COMMERCIAUX" || $protection->ProfilName=="GESTIONNAIRE" || $protection->ProfilName=="VENDEUR")
        $profil_commercial=1;
    if($protection->ProfilName=="RAF" ||$protection->ProfilName=="GESTIONNAIRE" ||$protection->ProfilName=="SUPERVISEUR" )
        $profil_special =1;
    if($protection->ProfilName=="RAF")
        $profil_daf=1;
    if($protection->ProfilName=="SUPERVISEUR")
        $profil_superviseur=1;
    if($protection->ProfilName=="GESTIONNAIRE")
        $profil_gestionnaire=1;

$docEntete = new DocEnteteClass($_GET["cbMarq"]);
if(isset($_GET["cbMarq"]) ){
    $entete = $docEntete->DO_Piece;
        $reference=$docEntete->DO_Ref;
        $dateEntete=$docEntete->DO_Date;
        $dateEntete=$docEntete->DO_Date;
        $nomdepot=$docEntete->DE_Intitule;
        $depot=$docEntete->DE_No;
        $client=$docEntete->DO_Tiers;
        $souche = $docEntete->DO_Souche;
        $co_no =$docEntete->CO_No;
        $caisse = $docEntete->CA_No;
        $result=$objet->db->requete($objet->getLibTaxePied($typeFac,$docEntete->N_CatCompta));
        $rowsLibelle = $result->fetchAll(PDO::FETCH_OBJ);
        if($rowsLibelle!=null){
            $libelle1 = $rowsLibelle[0]->LIB1;
            $libelle2 = $rowsLibelle[0]->LIB2;
            $libelle3 = $rowsLibelle[0]->LIB3;
        }
        $comptet = new ComptetClass($docEntete->DO_Tiers);
            $nomclient=$comptet->CT_Intitule;
}

$villeDepot="";
$complementDepot="";
$depot = new DepotClass($docEntete->DE_No);
$villeDepot=$depot->DE_Ville;
$complementDepot=$depot->DE_Complement;

$nomSociete="";
$bp="";
$rcn="";
$nc="";
$cp="";
$ville = "";
$pays = "";
$tel = "";
$email = "";
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
    <div>
        <img style="width:700px; height:90px;" alt="logo CM" src="../images/Zumi_Logo.png" />
</div>
<?php if($format=="A4"){ ?>
<table>
    <tr>
        <td style="width:500px">
            <?= $nomSociete ?><br/>Tel : <?= $tel ?><br/>Email : <?= $email ?><br/>BP : <?= $bp ?><br/>RCN° : <?= $rcn ?><br/>NC : <?=$nc; ?>
        </td>
        <td>
            <?php $date = new DateTime($dateEntete); echo $villeDepot; ?> le <?= $date->format('d/m/y') ?> <br/><br/><?= $complementDepot; ?>
        </td>
    </tr>
</table>
<div style="text-align:center"><b><?= $nomEtat; ?> </b></div>
<br/>
<table id="table" class="facture" style="border:1px solid black;">
    <thead>
        <tr style="text-align:center">
        <th style="padding:6px">Référence</th>
        <th style="padding:6px;width: 200px">Désignation</th>
        <th style="padding:6px;width: 50px">Qté</th>
        <th style="padding:6px;width: 100px">Prix unitaire</th>
        <th style="padding:6px;width: 100px">Montant HT</th>
      </tr>
    </thead>
    <tbody id="article_body">
    <?php
        $totalMontantHT=0;
        $totalMontantTTC=0;
        $totalTaxe1=0;
        $totalTaxe2=0;
        $totalTaxe3=0;
        $rows = $docEntete->getLigneFacture();
            foreach ($rows as $row){
                $totalMontantTTC= $totalMontantTTC+ROUND($row->DL_MontantTTC,2);
                $totalMontantHT= $totalMontantHT+ROUND($row->DL_MontantHT,2);
                $totalTaxe1= $totalTaxe1+ROUND($row->MT_Taxe1,2);
                $totalTaxe2= $totalTaxe2+ROUND($row->MT_Taxe2,2);
                $totalTaxe3= $totalTaxe3+ROUND($row->MT_Taxe3,2);
                $bordure = "";
                if(end($rows)->cbMarq==$row->cbMarq)
                    $bordure=";border-bottom:1 px black solid";

                ?>
                <tr style='padding:10px'>
                    <td style='padding:3px$bordure'><?= $row->AR_Ref ?></td>
                    <td style='padding:3px$bordure'><?= $row->DL_Design ?></td>
                    <td style='padding:3px;text-align:center<?= $bordure ?>'><?= $objet->formatChiffre($row->DL_Qte) ?></td>
                    <?php
                    if($profil_gestionnaire==0){
                    ?>
                        <td style='padding:3px;text-align:right<?= $bordure ?>'><?= $objet->formatChiffre($row->DL_PrixUnitaire_Rem0) ?></td>
                    <?php
                    }
                    ?>
                    <td style='padding:3px;text-align:right<?= $bordure ?>'><?= $objet->formatChiffre($row->DL_MontantHT) ?></td></tr>
            <?php
            }
        }
        ?>
        <tr><td colspan="2" style="border-top: 1px;border-left: 0px"></td><td colspan="2" style="border-left : 1px;border-bottom: 0px">Montant total HT :</td><td style="border-left : 1px;border-bottom: 0px;text-align: right"><?= $objet->formatChiffre($totalMontantHT); ?></td></tr>
        <tr><td colspan="2" style="border-top: 1px;border-left: 0px"></td><td colspan="2" style="border-left : 1px;border-bottom: 0px">Remise :</td><td style="border-left : 1px;border-bottom: 0px;text-align: right"><?= $objet->formatChiffre("0"); ?></td></tr>
        <tr><td colspan="2" style="border-top: 1px;border-left: 0px"></td><td colspan="2" style="border-left : 1px;border-bottom: 0px">Net commercial :</td><td style="border-left : 1px;border-bottom: 0px;text-align: right"><?= $objet->formatChiffre($totalMontantHT); ?></td></tr>
        <?php if($libelle1!=null || $libelle1 != "") { ?>
        <tr><td colspan="2" style="border-top: 1px;border-left: 0px"></td><td colspan="2" style="border-left : 1px;border-bottom: 0px"><?= $libelle1; ?>:</td><td style="border-left : 1px;border-bottom: 0px;text-align: right"><?= $objet->formatChiffre($totalTaxe1); ?></td></tr>
        <?php } ?>
        <?php if($libelle2!=null || $libelle2 != "") { ?>
        <tr><td colspan="2" style="border-top: 1px;border-left: 0px"></td><td colspan="2" style="border-left : 1px;border-bottom: 0px"><?= $libelle2; ?>:</td><td style="border-left : 1px;border-bottom: 0px;text-align: right"><?= $objet->formatChiffre($totalTaxe2); ?></td></tr>
        <?php } ?>
        <?php if($libelle3!=null || $libelle3 != "") { ?>
        <tr><td colspan="2" style="border-top: 1px;border-left: 0px"></td><td colspan="2" style="border-left : 1px;border-bottom: 0px"><?= $libelle3; ?>:</td><td style="border-left : 1px;border-bottom: 0px;text-align: right"><?= $objet->formatChiffre($totalTaxe3); ?></td></tr>
        <?php } ?>
        <tr><td colspan="2" style="border-top: 1px;border-left: 0px"></td><td colspan="2" style="border-left : 1px;border-bottom: 1px">Net à payer :</td><td style="border-left : 1px;border-bottom: 1px;text-align: right"><?= $objet->formatChiffre($totalMontantTTC); ?></td></tr>
    </tbody></table>
<br/>
<br/>
<?php
if($format=="A5"){
    ?>
<div style="clear:both;text-align: center">
    <b><?= $nomdepot ?>- <?= $complementDepot ?></b>
</div>
<br/>
<div style="text-align:center"><b></b><b><?= $titre_client ?></b> <?= $nomclient ?></div>
<br/>
<table>
    <tr>
        <td style="width:500px">
        </td>
        <td>
            <br/>RCN° : <?= $rcn ?><br/>NC : <?= $nc ?><?php $date = new DateTime($dateEntete); echo $villeDepot; ?> le <?= $date->format('d/m/y'); ?>
        </td>
        <tr></tr>
    </tr>
</table>
<div style=""><b><?= $nomEtat ?> </b></div>
<table id="table" class="facture" style="border:1px solid black;">
    <thead>
        <tr style="text-align:center">
        <th style="padding:6px">Référence</th>
        <th style="padding:6px;width: 200px">Désignation</th>
        <th style="padding:6px;width: 50px">Qté</th>
        <th style="padding:6px;width: 100px">Prix unitaire</th>
       <th style="padding:6px;width: 100px">Montant</th>
      </tr>
    </thead>
    <tbody id="article_body">
    <?php
        $totalMontantHT=0;
        $totalMontantTTC=0;
        $totalTaxe1=0;
        $totalTaxe2=0;
        $totalTaxe3=0;
        $rows = $docEntete->getLigneFacture();
            foreach ($rows as $row){
                $totalMontantTTC= $totalMontantTTC+ROUND($row->DL_MontantTTC,2);
                $totalMontantHT= $totalMontantHT+ROUND($row->DL_MontantHT,2);
                $totalTaxe1= $totalTaxe1+ROUND($row->MT_Taxe1,2);
                $totalTaxe2= $totalTaxe2+ROUND($row->MT_Taxe2,2);
                $totalTaxe3= $totalTaxe3+ROUND($row->MT_Taxe3,2);
                $bordure = "";
                if(end($rows)->cbMarq==$row->cbMarq)
                    $bordure=";border-bottom:1 px black solid";
?>
                <tr style='padding:10px<?= $bordure ?>'>
                    <td style='padding:3px;<?= $bordure ?>'><?= $row->AR_Ref ?></td>
                    <td style='padding:3px;<?= $bordure ?>'><?= $row->DL_Design ?></td>
                    <td style='padding:3px;text-align:center<?= $bordure ?>'><?= $objet->formatChiffre($row->DL_Qte) ?></td>
<?php
                if($profil_gestionnaire==0){
                    ?>
                    <td style='padding:3px;;text-align:right<?= $bordure ?>'><?= $objet->formatChiffre($row->DL_PUTTC_Rem0) ?></td>
                    <td style='padding:3px;;text-align:right<?= $bordure ?>'><?= $objet->formatChiffre($row->DL_MontantTTC) ?></td>
<?php
                }
            }
        }
        ?>
        <tr>
            <td colspan="3" style="border-top: 1px;border-left: 0px;border-right: 0px"></td>
            <td colspan="1" style="border-left: 0px"><b>Montant</b></td>
            <td style="border-left : 1px;border-bottom: 1px;text-align:right"><?= $objet->formatChiffre($totalMontantTTC); ?></td>
        </tr>
    </tbody>
</table>
<br/>
<br/>
Arrêter la présente facture à la somme de : <b><?= $objet->asLetters($totalMontantTTC) ?> Francs CFA.</b>
<br/>
<br/>
<b>N.B. :</b>Les marchandises vendues ne sont ni reprises, ni échangées.
<br/>
<br/>
<table id="table" class="reglement" style="float:right">
<thead>
    <tr>
        <th>Date</th>
        <th>Libelle</th>
        <th>Montant</th>
        <th>Solde progressif</th>
    </tr>
</thead>
<tbody>
     <?php
        $result=$objet->db->requete($objet->getReglementByClientFacture($client,$entete,$do_type,$do_domaine));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $classe="";
        $resteapayer=0;
        if($rows==null){
            ?>
            <tr>
                <td></td>
                <td>SOLDE INITIAL</td>
                <td style='text-align:center'>0,00</td>
                <td style='text-align:center'><?= $objet->formatChiffre($totalMontantTTC) ?></td>
            </tr>
<?php
        }else{
            foreach ($rows as $row){
                $i++;
                if($i%2==0) $classe = "info";
                else $classe="";
                $date=date("d-m-Y", strtotime($row->RG_Date));
                if($date=="01-01-1970") $date="";
                ?>
                <tr class='<?= $classe ?>'>
                    <td><?= $date ?></td>
                    <td><?= $row->RG_Libelle ?></td>
                    <td style='text-align:center'><?= $objet->formatChiffre($row->RG_Montant) ?></td>
                    <td style='text-align:center'><?= $objet->formatChiffre($row->CUMUL) ?></td>
                </tr>
<?php
                $resteapayer=round($row->CUMUL);
            }
        }
         $total_regle=$docEntete->montantRegle();
         $avance=$docEntete->avance;
         $resteapayer=$total_regle - $avance;
        ?>
    <tr><td style="border-bottom:1px"></td><td style="border-bottom:1px"></td><td style="border-bottom:1px"></td><td style="border-bottom:1px"></td></tr>
</tbody>
</table>
<br/>
<br/>
<div>
    Reste à payer : <b><?= $objet->formatChiffre($resteapayer); ?> </b>
</div>
<br/>
<?php if($format=="A5"){ ?>
<hr/>
<table>
    <tr>
        <td style="width:100px">
            BP : <?= $cp?> <?= $ville ?>
        </td>
        <td style="width:450px;text-align: center">
            N Contrib  <?= $nc ?> - RC : <?= $rcn ?>
        </td>
        <td>
             Tel : <?= $tel ?> <br/>Email : <?= $email ?>
        </td>
    </tr>
</table>
<?php } ?>
<br/>

</div>
</div>
    <?php
    $content = ob_get_clean();

    // convert in PDF
    require_once("../vendor/autoload.php");
    try
    {
        if($format=="A4")
            $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        if($format=="A5")
            $html2pdf = new HTML2PDF('L', 'A5', 'fr');
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        ob_end_clean();
        $html2pdf->Output($type.'_'.$entete.'.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>