<?php
include("../Modele/DB.php");
include("../Modele/ObjetCollector.php");
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
$entete=$_GET["entete"];
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

if(isset($_GET["entete"]) ){
    $entete = $_GET["entete"];
    $result=$objet->db->requete($objet->getDoPiece($entete,$do_domaine,$do_type));
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if($rows==null){
    }
    else{
        $reference=$rows[0]->DO_Ref;
        $dateEntete=$rows[0]->DO_Date;
        $dateEntete=$rows[0]->DO_Date;
        $nomdepot=$rows[0]->DE_Intitule;
        $depot=$rows[0]->DE_No;
        $client=$rows[0]->DO_Tiers;
        $souche = $rows[0]->DO_Souche;
        $co_no = $rows[0]->CO_No;
        $caisse = $rows[0]->CA_No;
        $result=$objet->db->requete($objet->getLibTaxePied($typeFac,$rows[0]->N_CatCompta));
        $rowsLibelle = $result->fetchAll(PDO::FETCH_OBJ);
        if($rowsLibelle!=null){
            $libelle1 = $rowsLibelle[0]->LIB1;
            $libelle2 = $rowsLibelle[0]->LIB2;
            $libelle3 = $rowsLibelle[0]->LIB3;
        }
        $comptet = new ComptetClass($client);
        $nomclient=$comptet->CT_Intitule;
    }
}

$villeDepot="";
$complementDepot="";
$depotClass = new DepotClass($depot);
$villeDepot=$depotClass->DE_Ville;
$complementDepot=$depotClass->DE_Complement;

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
}

table.facture td {
}

table.reglement {
    border-collapse:collapse;
    font-size: 8px;
}
table.reglement th, table.reglement td{
    padding : 5px;
}
table.reglement th{
    text-align:center;
}
table.reglement td{
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
            <?php echo $nomSociete."<br/>Tel : ".$tel."<br/>Email : ".$email."<br/>BP : ".$bp."<br/>RCN° : ".$rcn."<br/>NC : ".$nc; ?>
        </td>
    </tr>
</table>

<table>
    <tr>
        <td style="width:500px">
            <?php $date = new DateTime($dateEntete); echo "Date <br/><br/>".$villeDepot." le ".$date->format('d/m/y')."<br/><br/>Référence<br/><br/>".$reference; ?>
        </td>
        <td>
            <?php echo $complementDepot; ?>
        </td>
    </tr>
</table>
<br/>
    <div style="text-align:center"><b><?php echo $nomEtat; ?> </b></div>
    <br/>
<table id="table" class="facture" >
    <thead>
        <tr style="text-align:center">
        <th style="padding:6px">Référence</th>
        <th style="padding:6px;width: 200px">Désignation</th>
        <th style="padding:6px;width: 50px">Qté</th>
        <th style="padding:6px;width: 100px">Prix unitaire</th>
            <th style="padding:6px;width: 100px">Remise</th>
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
        $result=$objet->db->requete($objet->getLigneFacture($entete,$do_domaine,$do_type));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if($rows==null){
        }else{
            foreach ($rows as $row){
                $totalMontantTTC= $totalMontantTTC+ROUND($row->DL_MontantTTC,2);
                $totalMontantHT= $totalMontantHT+ROUND($row->DL_MontantHT,2);
                $totalTaxe1= $totalTaxe1+ROUND($row->MT_Taxe1,2);
                $totalTaxe2= $totalTaxe2+ROUND($row->MT_Taxe2,2);
                $totalTaxe3= $totalTaxe3+ROUND($row->MT_Taxe3,2);
                $bordure = "";

                echo "<tr style='padding:10px'>"
                    . "<td style='padding:3px$bordure'>".$row->AR_Ref."</td>"
                    . "<td style='padding:3px$bordure'>".$row->DL_Design."</td>"
                    . "<td style='padding:3px;text-align:center$bordure'>".round($row->DL_Qte)."</td>";
                    if($profil_gestionnaire==0)
                        echo  "<td style='padding:3px;text-align:right$bordure'>".$objet->formatChiffre(round($row->DL_PrixUnitaire_Rem,2))."</td>"
                    ."<td style='padding:3px;text-align:right$bordure'>".$row->DL_Remise."</td>"
                    . "<td style='padding:3px;text-align:right$bordure'>".$objet->formatChiffre(ROUND($row->DL_MontantHT,2))."</td></tr>";
            }
        }
        ?>
    </tbody>
</table>
<br/>
<br/>
    <table id="table" class="" >
        <thead>
        <tr style="text-align:center">
            <th style="padding:6px">Code</th>
            <th style="padding:6px;width: 200px">Base</th>
            <th style="padding:6px;width: 50px">Qté</th>
            <th style="padding:6px;width: 100px">Montant</th>
            <th style="padding:6px;width: 100px">Total HT</th>
            <th style="padding:6px;width: 100px">Escompte</th>
            <th style="padding:6px;width: 100px">Total TTC</th>
            <th style="padding:6px;width: 100px">Acompte</th>
            <th style="padding:6px;width: 100px">Net à payer</th>
        </tr>
        </thead>
        <tbody id="article_body">
        <?php if($libelle1!=null || $libelle1 != "") { ?>
            <tr><td></td><td colspan="2" style="border-left : 1px;border-bottom: 0px"><?php echo $libelle1; ?>:</td><td style="border-left : 1px;border-bottom: 0px;text-align: right"><?php echo $objet->formatChiffre($totalTaxe1); ?></td></tr>
        <?php } ?>
        <?php if($libelle2!=null || $libelle2 != "") { ?>
            <tr><td></td><td colspan="2" style="border-left : 1px;border-bottom: 0px"><?php echo $libelle2; ?>:</td><td style="border-left : 1px;border-bottom: 0px;text-align: right"><?php echo $objet->formatChiffre($totalTaxe2); ?></td></tr>
        <?php } ?>
        <?php if($libelle3!=null || $libelle3 != "") { ?>
            <tr><td></td><td colspan="2" style="border-left : 1px;border-bottom: 0px"><?php echo $libelle3; ?>:</td><td style="border-left : 1px;border-bottom: 0px;text-align: right"><?php echo $objet->formatChiffre($totalTaxe3); ?></td></tr>
        <?php } ?>
        </tbody>
    </table>
<?php
}
if($format=="A5"){
    ?>
<div style="clear:both;text-align: center">
    <?php echo "<b>$nomdepot - $complementDepot</b>"; ?>
</div>
<br/>
<div style="text-align:center"><b></b><?php echo "<b>".$titre_client."</b> ".$nomclient; ?></div>
<br/>
<table>
    <tr>
        <td style="width:500px">
        </td>
        <td>
            <?php "<br/>RCN° : ".$rcn."<br/>NC : ".$nc;$date = new DateTime($dateEntete); echo $villeDepot." le ".$date->format('d/m/y'); ?>
        </td>
        <tr></tr>
    </tr>
</table>
<div style=""><b><?php echo $nomEtat; ?> </b></div>
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
        $result=$objet->db->requete($objet->getLigneFacture($entete,$do_domaine,$do_type));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if($rows==null){
        }else{
            foreach ($rows as $row){
                $totalMontantTTC= $totalMontantTTC+ROUND($row->DL_MontantTTC,2);
                $totalMontantHT= $totalMontantHT+ROUND($row->DL_MontantHT,2);
                $totalTaxe1= $totalTaxe1+ROUND($row->MT_Taxe1,2);
                $totalTaxe2= $totalTaxe2+ROUND($row->MT_Taxe2,2);
                $totalTaxe3= $totalTaxe3+ROUND($row->MT_Taxe3,2);
                $bordure = "";
                if(end($rows)->cbMarq==$row->cbMarq)
                    $bordure=";border-bottom:1 px black solid";

                echo "<tr style='padding:10px$bordure'>"
                    . "<td style='padding:3px;$bordure'>".$row->AR_Ref."</td>"
                    . "<td style='padding:3px;$bordure'>".$row->DL_Design."</td>"
                    . "<td style='padding:3px;text-align:center$bordure'>".round($row->DL_Qte)."</td>";
                if($profil_gestionnaire==0)
                    echo "<td style='padding:3px;;text-align:right$bordure'>".$objet->formatChiffre(round($row->DL_PUTTC_Rem,2))."</td>"
                    . "<td style='padding:3px;;text-align:right$bordure'>".$objet->formatChiffre(ROUND($row->DL_MontantTTC,2))."</td></tr>";
            }
        }
        ?>
        <tr><td colspan="3" style="border-top: 1px;border-left: 0px;border-right: 0px"></td><td colspan="1" style="border-left: 0px"><b>Montant</b></td><td style="border-left : 1px;border-bottom: 1px;text-align:right"><?php echo $objet->formatChiffre($totalMontantTTC); ?></td></tr>
    </tbody></table>
<br/>
<br/>
<?php
}
?>
Arrêter la présente facture à la somme de : <b><?php echo $objet->asLetters($totalMontantTTC)." Francs CFA."; ?></b>
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
        $result=$objet->db->requete($objet->getReglementByClientFacture($client,$entete));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $classe="";
        $resteapayer=0;
        if($rows==null){
            echo "<tr><td></td><td>SOLDE INITIAL</td><td style='text-align:center'>0,00</td><td style='text-align:center'>".$objet->formatChiffre($totalMontantTTC)."</td></tr>";
        }else{
            foreach ($rows as $row){
                $i++;
                if($i%2==0) $classe = "info";
                else $classe="";
                $date=date("d-m-Y", strtotime($row->RG_Date));
                if($date=="01-01-1970") $date="";
                echo "<tr class='$classe'>"
                . "<td>".$date."</td>"
                . "<td>".$row->RG_Libelle."</td>"
                . "<td style='text-align:center'>".$objet->formatChiffre(round($row->RG_Montant))."</td>"
                . "<td style='text-align:center'>".$objet->formatChiffre(round($row->CUMUL))."</td>"
                . "</tr>";
                $resteapayer=round($row->CUMUL);
            }
        }
        ?>
    <tr><td style="border-bottom:1px"></td><td style="border-bottom:1px"></td><td style="border-bottom:1px"></td><td style="border-bottom:1px"></td></tr>
</tbody>
</table>
<br/>
<br/>
<div>
    Reste à payer : <b><?php echo $objet->formatChiffre($resteapayer); ?> </b>
</div>
<br/>
<?php if($format=="A5"){ ?>
<hr/>
<table>
    <tr>
        <td style="width:100px">
            <?php echo "BP : ".$cp." ".$ville; ?>
        </td>
        <td style="width:450px;text-align: center">
                <?php echo "N Contrib ".$nc." - RC : ".$rcn; ?>

        </td>
        <td>
            <?php echo "Tel : ".$tel."<br/>Email : ".$email; ?>
        </td>
    </tr>
</table>
<?php } ?>
<br/>

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