<?php
include("../../Modele/DB.php");
include("../../Modele/ObjetCollector.php");
include("../../Modele/Objet.php");
include("../../Modele/ComptetClass.php");
session_start();
$objet = new ObjetCollector();



$cat_tarif=0;
$format=$_GET["format"];
$hideDivers =0;
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
$telclient="";
$emailclient="";
$bpclient="";
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
$titre_client="DOIT : ";
$profil_caisse=0;
$profil_special=0;
$profil_commercial=0;
$profil_daf=0;
$profil_superviseur=0;
$profil_gestionnaire=0;
if (isset($_GET["Type"]))
    $hideDivers = $_GET["Type"];

if($_GET["type"]=="Vente" || $_GET["type"]=="VenteRetour" || $_GET["type"]=="Avoir"){
    $do_domaine = 0;
    $do_type = 6;
    $nomEtat="Facture de vente ".$entete;
}

if($_GET["type"]=="VenteC"){
    $do_domaine = 0;
    $do_type = 7;
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
    $nomEtat="PROFORMA ".$entete;
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
    if($rows[0]->ProfilName=="RAF" || $rows[0]->ProfilName=="GESTIONNAIRE" || $rows[0]->ProfilName=="SUPERVISEUR" )
        $profil_special =1;
    if($rows[0]->ProfilName=="RAF")
        $profil_daf=1;
    if($rows[0]->ProfilName=="SUPERVISEUR")
        $profil_superviseur=1;
    if($rows[0]->ProfilName=="GESTIONNAIRE")
        $profil_gestionnaire=1;
}

$catcompta=0;
$cattarif=0;

$ct_ape="";
$d_siret="";
$ct_identifiant="";
$complement ="";
$modeReglement ="";
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
        $catcompta=$rows[0]->N_CatCompta;
        $cattarif=$rows[0]->DO_Tarif;
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
        $telclient=$comptet->CT_Telephone;
        $emailclient=$comptet->CT_EMail;
        $bpclient=$comptet->CT_CodePostal;
        $complement=$comptet->CT_Complement;
        $ct_ape=$comptet->CT_Ape;
        $d_siret=$comptet->CT_Siret;
        $ct_identifiant=$comptet->CT_Identifiant;
        $modeReglement = $rowsClient[0]->MR_No;
    }
}

$collaborateur = "";
$result=$objet->db->requete($objet->getCollaborateurByCOno($co_no));
$rowsClient = $result->fetchAll(PDO::FETCH_OBJ);
if($rowsClient!=null){
    $collaborateur=$rowsClient[0]->CO_Nom;
}
$villeDepot="";
$complementDepot="";
$emailDepot = "";
$telDepot = "";
$adresseDepot = "";
$cpDepot = "";
$villeDepot = "";
$result=$objet->db->requete($objet->getDepotByDE_No($depot));
$rows = $result->fetchAll(PDO::FETCH_OBJ);
if($rows==null){
}
else{
    $villeDepot=$rows[0]->DE_Ville;
    $complementDepot=$rows[0]->DE_Complement;
    $emailDepot = $rows[0]->DE_EMail;
    $telDepot = $rows[0]->DE_Telephone;
    $adresseDepot = $rows[0]->DE_Adresse;
    $cpDepot = $rows[0]->DE_CodePostal;
}

$nomSociete="";
$bp="";
$rcn="";
$nc="";
$cp="";
$ville = "";
$pays = "";
$tel = "";
$email = "";
$commentaire ="";
$profession = "";
$result=$objet->db->requete($objet->getNumContribuable());
$rows = $result->fetchAll(PDO::FETCH_OBJ);
if($rows==null){
}
else{

    $commentaire =$rows[0]->D_Commentaire;
    $profession = $rows[0]->D_Profession;
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


function getItem($table,$val){
    $pos=-1;
    for($i=0;$i<sizeof($table);$i++){
        if(strcmp($table[$i],$val)==0){
            $pos = $i;
        }
    }
    return $pos;
}
// mise à jour de la référence
    $typefac=$_GET["type"];
    $totalHT=0;
    $totalTTC=0;
    $table= array();
    $tabLib= array();
    $typeTiers=0;
    if($do_domaine!=0)
        $typeTiers=1;
    $result=$objet->db->requete($objet->getLigneFacture($entete,$do_domaine,$do_type));
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    $i=0;
    foreach( $rows as $row){
        if($typefac =="VenteRetour"){
            $totalHT=$totalHT-$row->DL_MontantHT;
            $totalTTC=$totalTTC-$row->DL_MontantTTC;
        }else {
            $totalHT = $totalHT + $row->DL_MontantHT;
            $totalTTC = $totalTTC + $row->DL_MontantTTC;
        }
        $prix = $row->DL_PUTTC;
        $rem=0;
        if($row->DL_TTC==0)
            $prix = $row->DL_PrixUnitaire;
        $catcomptafinal = $catcompta;
        if($do_type==11)
            $catcomptafinal=$row->DL_NoColis;
        $result=$objet->db->requete($objet->getPrixClientHT($row->AR_Ref, $catcomptafinal, $cattarif, $prix,$rem,$row->DL_Qte,$typeTiers));
        $rowsPrix = $result->fetchAll(PDO::FETCH_OBJ);
        $pos = getItem($tabLib,$rowsPrix[0]->IntituleT1);
        if($pos==-1){
            array_push ($tabLib, $rowsPrix[0]->IntituleT1);
            if($typefac =="VenteRetour")
                array_push ($table, -$row->MT_Taxe1);
            else
                array_push ($table, $row->MT_Taxe1);
        }
        else{
            if($typefac =="VenteRetour")
                $table[$pos]=$table[$pos]-$row->MT_Taxe1;
            else
                $table[$pos]=$table[$pos]+$row->MT_Taxe1;
        }
        $pos = getItem($tabLib,$rowsPrix[0]->IntituleT2);
        if($pos==-1){
            array_push ($tabLib, $rowsPrix[0]->IntituleT2);

            if($typefac =="VenteRetour")
                array_push ($table, -$row->MT_Taxe2);
            else
                array_push ($table, $row->MT_Taxe2);
        }
        else{
            if($typefac =="VenteRetour")
                $table[$pos]=$table[$pos]-$row->MT_Taxe2;
            else
                $table[$pos]=$table[$pos]+$row->MT_Taxe2;
        }
        $pos = getItem($tabLib,$rowsPrix[0]->IntituleT3);
        if($pos==-1){
            array_push ($tabLib, $rowsPrix[0]->IntituleT3);
            if($typefac =="VenteRetour")
                array_push ($table, -$row->MT_Taxe3);
            else
                array_push ($table, $row->MT_Taxe3);
        }
        else{
            if($typefac =="VenteRetour")
                $table[$pos]=$table[$pos]-$row->MT_Taxe3;
            else
                $table[$pos]=$table[$pos]+$row->MT_Taxe3;
        }
    }
ob_start();

?>
    <style>
        table {
            font-size:11px;
            border-collapse : collapse ;
            margin-left : 25px
        }
        table.collap {
            font-size:10px;
        }
        table.facture {
        }
        table.facture th{
            border:0px solid black;
            margin:5px;
        }

        .borderRad {
            border-radius: 10px 10px 10px 10px;
            -moz-border-radius: 10px 10px 10px 10px;
            -webkit-border-radius: 10px 10px 10px 10px;
            border: 0px solid #;
            background-color:gray;
        }

        table.facture td {
            border:0px solid black;
            border-left : 0px;
            border-bottom: 0px
        }

        table.reglement {
            font-size: 10px;
        }
        table.reglement th, table.reglement td{
            border:0px solid black;
            padding : 2px;
            font-size: 10px;
        }
        table.reglement th{
            text-align:center;
        }
        table.reglement td{
            border-left : 1px;
            border-bottom: 0px
        }

    </style>
    <page>
            <table id="Tableentete">
                <tr style="font-size:13px">
                    <td>
                        <img  style="width:86px; height:85px;" alt="logo CM" src="../../images/LOGO CMI.png" />
                    </td><td>
                        <?php echo "<b>$nomSociete</b><br/>Compagnie de Matériel Industriel du Cameroun<br/>Electricité générale Informatique et Télécom";//$commentaire<br/>$profession"; ?>
                    </td>
                </tr>
                <tr style="font-size:11px">
                    <td colspan="2">
                        <?php echo "Email : $emailDepot<br/><b>Téléphone : $telDepot </b><br/>BP : $cpDepot <br/>";
                        if(!$hideDivers) echo "RCN° : $rcn <br/>NC : $nc"; ?>
                    </td>
                </tr>
            </table>
            <?php if($format=="A4"){ ?>

                <br/>
                <br/>
                <table>
                    <tr>
                        <td style="width:500px">
                        </td>
                        <td>
                            <?php "<br/>RCN° : ".$rcn."<br/>NC : ".$nc;$date = new DateTime($dateEntete); echo $villeDepot." le ".$date->format('d/m/y')."<br/><br/>".$complementDepot; ?>
                        </td>
                    <tr></tr>
                    </tr>
                </table>
                <div style="padding:5px;width:150px;font-size: 11px;margin-left:25px" class="borderRad">Référence : </div>
                <div style="margin-left:25px" ><?php echo $reference; ?></div>
                <table>
                    <tr>
                        <td style="padding:10px;width:150px;float:left"></td>
                        <td style="padding:10px;width:300px;float:left"></td>
                        <td style="padding:10px;width:150px;float:right" class="borderRad"><?php
                            echo "<b> $titre_client </b> $nomclient"; // $ct_identifiant;
                            echo "<br/>BP : $bpclient <br/>Tel : $telclient <br>RC : $complement <br>NC : $ct_identifiant <br>Email : $emailclient <br/><br/>";
                            ?></td>
                    </tr>
                    <tr><td></td>
                    <td></td>
                    <td><?php
//                        $date = new DateTime(); echo $villeDepot." le ".$date->format('d/m/y')."<br/><br/>".$complementDepot; ?></td></tr>
                </table>
                <div ></div>
                <div >

                </div>
                <div style="text-align:center"><b><?php echo $nomEtat." du ".$date->format('d/m/y'); ?> </b></div>
                <table id="table" class="facture" >
                    <thead>
                    <tr style="text-align:center">
                        <th class="borderRad" style="padding:6px">Référence</th>
                        <th class="borderRad" style="padding:6px;width: 300px">Désignation</th>
                        <th class="borderRad" style="padding:6px;width: 35px">Qté</th>
                        <th class="borderRad" style="padding:6px;width: 50px">PxUnitaire</th>
                        <th class="borderRad" style="padding:6px;width: 50px">Remise</th>
                        <th class="borderRad" style="padding:6px;width: 50px">MontantHT</th>
                    </tr>
                    </thead>
                    <tbody id="article_body">
                    <tr>
                        <td style="height:5px"></td>
                    </tr>
                    <?php
                    $totalMontantHT=0;
                    $totalMontantTTC=0;
                    $totalTaxe1=0;
                    $totalTaxe2=0;
                    $totalTaxe3=0;
                    $totalremise=0;
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
                            $totalremise= $totalremise+ROUND($row->DL_PUTTC_Rem,2);
                            $bordure = "";

                            echo "<tr class='borderRad' style='background-color:lightgray ;padding:10px$bordure'>"
                                . "<td style='padding:2px;border-left:0px;$bordure'>".substr($row->AR_Ref,0,7)."</td>"
                                . "<td style='padding:2px;width: 250px;$bordure'>".$row->DL_Design."</td>"
                                . "<td style='padding:2px;width: 25px;$bordure'>".$objet->formatChiffre($row->DL_Qte)."</td>"
                                . "<td style='padding:2px;$bordure'>".$objet->formatChiffre($row->DL_PrixUnitaire)."</td>"
                                . "<td style='padding:2px;$bordure'>".$objet->formatChiffre($row->DL_PUTTC_Rem)."</td>"
                                . "<td style='padding:2px;$bordure'>".$objet->formatChiffre($row->DL_MontantHT)."</td>";
                            //if($profil_gestionnaire==0)
                            echo "</tr>";
                        }
                    }
                    ?>
                    </tbody>
                </table>
                <table style="margin-top:20px;margin-bottom: 20px; float:left;width:300px" class="collap">
                    <tr class="borderRad" >
                        <th style="padding:5px" class="borderRad">Code</th>
                        <th style="padding:5px" class="borderRad" >Base</th>
                        <th style="padding:5px" class="borderRad">Taux</th>
                        <th style="padding:5px" class="borderRad" >Montant</th>
                        <th style="padding:5px" style="width:50px;background-color: white;"> </th>
                        <th style="padding:5px" class="borderRad" >Total HT</th>
                        <th style="padding:5px" class="borderRad">Escompte</th>
                        <th style="padding:5px" class="borderRad" >Total TTC</th>
                        <th style="padding:5px" class="borderRad" >Acompte</th>
                        <th style="padding:5px" style="width:50px;background-color: white;" > </th>
                        <th style="padding:5px" class="borderRad" >NET A PAYER</th>
                    </tr>
<?php
    if(sizeof($tabLib)>0){
        $i=0;
        echo"<tr>";
        if($tabLib[$i]!=""){
            $result=$objet->db->requete($objet->getTaxeByTAIntitule($tabLib[$i]));
            $rowsTaxe = $result->fetchAll(PDO::FETCH_OBJ);
            echo"   <td>".$rowsTaxe[0]->TA_Code."</td>
                    <td></td>
                    <td>".$rowsTaxe[0]->FormatTaxe."</td>
                    <td style=\"text-align: right\">".$objet->formatChiffre($table[$i])."</td>
                    ";
        }else{
            echo"<td></td>
                    <td></td>
                    <td></td>
                    <td style=\"text-align: right\"></td>";
        }
        echo "<td></td>
                    <td style=\"text-align: right\">". $objet->formatChiffre($totalMontantHT)."</td>
                    <td style=\"text-align: right\">". $objet->formatChiffre(0)."</td>
                    <td style=\"text-align: right\">". $objet->formatChiffre(ROUND($totalMontantTTC,0))."</td>
                    <td style=\"text-align: right\">". $objet->formatChiffre(0)."</td>
                    <td></td>
                    <td style=\"text-align: right\">". $objet->formatChiffre(ROUND($totalMontantTTC,0))."</td>
                </tr>";
    }

if(sizeof($tabLib)>1){
    for($i=1;$i<sizeof($tabLib);$i++){
        if($tabLib[$i]!=""){
            $result=$objet->db->requete($objet->getTaxeByTAIntitule($tabLib[$i]));
            $rowsTaxe = $result->fetchAll(PDO::FETCH_OBJ);

            echo"<tr>
                <td>".$rowsTaxe[0]->TA_Code."</td>
                <td></td>
                <td>".$rowsTaxe[0]->TA_Taux."</td>
                <td style=\"text-align: right\">".$objet->formatChiffre($table[$i])."</td>
                <td>  </td>
                <td style=\"text-align: right\"></td>
                <td style=\"text-align: right\"></td>
                <td style=\"text-align: right\"></td>
                <td style=\"text-align: right\"></td>
                <td></td>
                <td style=\"text-align: right\"></td>
            </tr>";
        }
    }
}
 ?>
                </table>
                <br/>
    <?php
    if($_GET["type"]!="Devis"){
        ?>
    <table>
        <tr></tr>
        <tr></tr>
    </table>
            <?php
    }
            }
            ?>
            <?php
            if($format=="A5"){
                ?>
                <!--<div style="clear:both;text-align: center">
    <?php echo "<b>$nomdepot - $complementDepot</b>"; ?>
</div>-->
                <BR/>
                <table>
                    <tr>
                        <td style="width:500px">
                        </td>
                        <td>
                            <?php "<br/>RCN° : ".$rcn."<br/>NC : ".$nc;$date = new DateTime($dateEntete); echo $villeDepot; ?>
                        </td>
                    <tr></tr>
                    </tr>
                </table>
                <div style='font-size:11px;'><?php echo "<span style='text-decoration:underline'><b>Collaborateur :</b></span> $collaborateur"; ?></div>
                <div style="text-align:center"><b><?php echo $nomEtat." du ".$date->format('d/m/y'); ?> </b></div>
                <table id="table" class="facture" style="border:1px solid black;">
                    <thead>
                    <tr style="text-align:center">
                        <th style="padding:6px">Référence</th>
                        <th style="padding:6px;width: 170px">Désignation</th>
                        <th style="padding:6px;width: 30px">Qté</th>
                        <th style="padding:6px;width: 30px">PuHT</th>
                        <th style="padding:6px;width: 30px">Rse</th>
                        <th style="padding:6px;width: 30px">PUttc</th>
                        <th style="padding:6px;width: 30px">MtHT</th>
                        <th style="padding:6px;width: 30px">TVA</th>
                        <th style="padding:6px;width: 30px">MtTTC</th>
                    </tr>
                    </thead>
                    <tbody id="article_body">
                    <?php
                    $totalMontantHT=0;
                    $totalMontantTTC=0;
                    $totalTaxe1=0;
                    $totalTaxe2=0;
                    $totalTaxe3=0;
                    $totalremise=0;
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
                            $totalremise= $totalremise+ROUND($row->DL_PUTTC_Rem,2);
                            $bordure = "";
                            if(end($rows)->cbMarq==$row->cbMarq)
                                $bordure=";border-bottom:1 px black solid";

                            echo "<tr style='padding:10px$bordure'>"
                                . "<td style='padding:2px;$bordure'>".substr($row->AR_Ref,0,7)."</td>"
                                . "<td style='width:250px;padding:2px;$bordure'>".$row->DL_Design."</td>"
                                . "<td style='padding:2px;$bordure'>".$objet->formatChiffre($row->DL_Qte)."</td>"
                                . "<td style='padding:2px;$bordure'>".$objet->formatChiffre($row->DL_PrixUnitaire)."</td>"
                                . "<td style='padding:2px;$bordure'>".$objet->formatChiffre($row->DL_PUTTC_Rem)."</td>"
                                . "<td style='padding:2px;$bordure'>".$objet->formatChiffre($row->DL_PUTTC)."</td>"
                                . "<td style='padding:2px;$bordure'>".$objet->formatChiffre($row->DL_MontantHT)."</td>";



                            //if($profil_gestionnaire==0)
                                echo "<td style='padding:2px;text-align:right$bordure'>".$objet->formatChiffre(round($row->MT_Taxe1,2))."</td>"
                                    . "<td style='padding:2px;text-align:right$bordure'>".$objet->formatChiffre(ROUND($row->DL_MontantTTC,2))."</td></tr>";
                        }
                    }
                    ?>
                    <tr><td colspan="5" style="border-top: 1px;border-left: 1px;border-right: 0px"></td><td colspan="1" style="border-left: 0px"><b>Total</b></td>
                        <td style="border-left : 1px;border-bottom: 1px;text-align:left"><?php echo $objet->formatChiffre($totalMontantHT); ?></td>
                        <td style="border-left : 1px;border-bottom: 1px;text-align:right"><?php echo $objet->formatChiffre($totalTaxe1); ?></td>
                        <td style="border-left : 1px;border-bottom: 1px;text-align:right"><?php echo $objet->formatChiffre(ROUND($totalMontantTTC,0)); ?></td></tr>
                    <tr>
                        <td style="border-left:1px; border-right : 0px;"></td>
                        <td style="border-right : 0px;border-left : 0px;"></td>
                        <td style="border-right : 0px;"></td>
                        <td style="border-right : 0px;"></td>
                        <td style="border-right : 0px;"></td>
                        <td style="border-right : 0px;"></td>
                        <td style="border-right : 0px;"></td>
                        <td style="border-right : 0px;"></td>
                        <td style="border-right : 1px;border-left : 1px;"></td>
                    </tr>
                    <tr>
                        <td style="border-right : 0px;"></td>
                        <td style="border-right : 0px;"></td>
                        <td style="border-right : 0px;"></td>
                        <td style="border-right : 0px;"><b>Remise</b> : </td>
                        <td style="border-right: 0px;"><?php echo $objet->formatChiffre($totalremise); ?></td>
                        <td style="border-right : 0px;"></td>
                        <td style="border-right : 0px;"></td>
                        <td style="border-right : 0px;"></td>
                        <td style="border-right : 1px;border-left : 1px;"></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="border-right : 0px;border-bottom: 1px"></td>
                        <td style="border-left : 0px;border-right : 0px;border-bottom: 1px"><b>NET A PAYER</b> : </td>
                        <td style="border-left : 0px;border-right : 0px;border-bottom: 1px"><?php echo $objet->formatChiffre(ROUND($totalMontantTTC,0)); ?></td>
                        <td style="border-right : 0px;border-bottom: 1px"></td>
                        <td style="border-right : 0px;border-bottom: 1px"></td>
                        <td style="border-right : 0px;border-bottom: 1px"></td>
                        <td style="border-right : 1px;border-left : 1px;border-bottom: 1px"></td>
                    </tr>
                    </tbody>

                </table>
                <br/>
                <?php
            }
            ?>
            <table>
                <tr>
                    <td>Arrêter la présente facture à la somme de : <b><?php echo $objet->asLetters(ROUND($totalMontantTTC,0))." Francs CFA."; ?></b></td>
                </tr>
                <tr>
                    <td >Veuillez toujours vérifier la qualité et la quantité de vos marchandises avant de les emporter.</td><td style=" width : 150px;text-align: right">La direction</td>
                </tr>
            </table>

            <?php
            if($_GET["type"]!="Devis" && $_GET["type"]!="Achat") {

                ?>
                <table id="table" class="table" style="margin-top:20px; float:right;font-size: 11px">
                    <thead>
                    <tr>
                        <th class="borderRad" style="padding: 5px">Date</th>
                        <th class="borderRad" style="padding: 5px">Libelle</th>
                        <th class="borderRad" style="padding: 5px">Montant</th>
                        <th class="borderRad" style="padding: 5px">Solde progressif</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $result = $objet->db->requete($objet->getReglementByClientFacture($client, $entete,$do_type,$do_domaine));
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    $i = 0;
                    $classe = "";
                    $resteapayer = 0;
                    if ($rows == null) {
                        echo "<tr><td></td><td>SOLDE INITIAL</td><td style='text-align:center'>0,00</td><td style='text-align:center'>" . $objet->formatChiffre($totalMontantTTC) . "</td></tr>";
                    } else {
                        foreach ($rows as $row) {
                            $i++;
                            if ($i % 2 == 0) $classe = "info";
                            else $classe = "";
                            $date = date("d-m-Y", strtotime($row->RG_Date));
                            if ($date == "01-01-1970") $date = "";
                            $bordure="";
                            echo "<tr class='$classe'>"
                                . "<td style='$bordure'>" . $date . "</td>"
                                . "<td style='$bordure'>" . $row->RG_Libelle . "</td>"
                                . "<td style='text-align:center $bordure'>" . $objet->formatChiffre(round($row->RG_Montant)) . "</td>"
                                . "<td style='text-align:center $bordure'>" . $objet->formatChiffre(round($row->CUMUL)) . "</td>"
                                . "</tr>";
                            $resteapayer = round($row->CUMUL);
                        }
                    }
                    $result=$objet->db->requete($objet->montantRegle($entete,$do_domaine,$do_type));
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    if($rows==null){
                    }else{
                        $total_regle=$rows[0]->montantRegle;
                    }
                    $result=$objet->db->requete($objet->AvanceDoPiece($entete,$do_domaine,$do_type));
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    if($rows==null){
                    }else{
                        $avance=$rows[0]->avance_regle;
                    }
                    $resteapayer=$total_regle - $avance;
                    ?>
                    <tr> <td style="border-right : 0px;border-left : 0px;"><br/>Reste à payer :</td><td style="border-right : 0px;"><br/><b><?php echo $objet->formatChiffre($resteapayer); ?> </b></td></tr>
                    </tbody>
                </table>

                <br/>
                <?php
            }
            if($modeReglement !="") {
                $result = $objet->db->requete($objet->getModeleReglementByMRNo($modeReglement));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if($rows==null){
                }else {
                    echo "Date limite : " . $rows[0]->MR_Intitule;
                }
            }
            ?>
            <hr/>
            <table>
                <tr style="font-size: 11px">
                    <td style="width:100px">
                        <?php echo "BP : ".$cpDepot." ".$villeDepot; ?>
                    </td>
                    <td style="width:450px;text-align: center">
                        <?php echo "Situé à ".$adresseDepot."<br/>";
                        if(!$hideDivers) echo "N Contrib ".$nc." - RC : ".$rcn; ?>

                    </td>
                    <td>
                        <?php echo "Tel : ".$telDepot."<br/>Email : ".$emailDepot; ?>
                    </td>
                </tr>
            </table>
    </page>
<?php
$content = ob_get_clean();
// convert in PDF/*
require_once("../../vendor/autoload.php");
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