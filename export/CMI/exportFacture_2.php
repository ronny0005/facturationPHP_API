<?php
include("../../Modele/DB.php");
include("../../Modele/ObjetCollector.php");
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
$titre_client="Nom du client : ";
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
    if ($hideDivers==2)
        $nomEtat="Bordereau de livraison ".$entete;
}
if($_GET["type"]=="VenteC"){
    $do_domaine = 0;
    $do_type = 7;
    $nomEtat="Facture de vente ".$entete;
    if ($hideDivers==2)
        $nomEtat="Bordereau de livraison ".$entete;
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
if($_GET["type"]=="AchatC"){
    $do_domaine = 1;
    $do_type = 17;
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

$modeReglement ="";
if(isset($_GET["entete"])){
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
        if($comptet->cbMarq!=""){
            $nomclient=$comptet->CT_Intitule;
            $telclient=$comptet->CT_Telephone;
            $emailclient=$comptet->CT_EMail;
            $bpclient=$comptet->CT_CodePostal;
            $ct_ape=$comptet->CT_Ape;
            $ct_identifiant=$comptet->CT_Identifiant;
            $modeReglement = $comptet->MR_No;
        }
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
ob_start();
?>
    <style>
        div {
            font-size:11px;
        }
        table {
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
            font-size: 11px;
        }
        table.reglement th, table.reglement td{
            border:1px solid black;
            padding : 2px;
            font-size: 11px;
        }
        table.reglement th{
            text-align:center;
        }
        table.reglement td{
            border-left : 1px;border-bottom: 0px
        }

    </style>
    <page>
            <table id="Tableentete">
                <tr>
                    <td style="width:200px">
                        <?php echo "<b>$nomSociete</b><br/>$commentaire<br/>$profession<br/>Tel : ".$telDepot."<br/>Email : ".$emailDepot."<br/>BP : ".$cpDepot."<br/>";
                        if(!$hideDivers) echo "RCN° : ".$rcn."<br/>NC : ".$nc; ?>  <br/>

                    </td>
                    <td style="width:150px">
                        <img  style="width:86px; height:85px;" alt="logo CM" src="../../images/LOGO CMI.png" />
                    </td>
                    <td>
                        <?php echo "<b>".$titre_client."</b> ".$nomclient;
                        echo "<br/>BP :".$bpclient." <br/>Tel : ".$telclient."<br>Email : ".$emailclient."<br/>NC : ".
$ct_identifiant."<br/>";
                        $date = new DateTime(); echo $villeDepot." le ".$date->format('d/m/y')."<br/><br/>".$complementDepot;
                        echo "<br/>Vendeur : ".$_SESSION["login"];
                        ?>
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
                            <?php "<br/>RCN° : ".$rcn."<br/>NC : ".$nc;$date = new DateTime($dateEntete); echo $villeDepot; ?>
                        </td>
                    <tr></tr>
                    </tr>
                </table>
                <div><?php echo "<span style='text-decoration:underline'><b>Collaborateur :</b></span> $collaborateur"; ?></div>
                <div style="text-align:center"><b><?php echo $nomEtat." du ".$date->format('d/m/y'); ?> </b></div>
                <table id="table" class="facture" style="border:1px solid black;">
                    <thead>
                    <tr style="text-align:center">
                        <th style="padding:2px;">Référence</th>
                        <th style="padding:6px;width: 150px">Désignation</th>
                        <th style="padding:6px;width: 25px">Qté</th>
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
                                . "<td style='padding:2px;width: 250px;$bordure'>".$row->DL_Design."</td>"
                                . "<td style='padding:2px;width: 25px;$bordure'>".$objet->formatChiffre($row->DL_Qte)."</td>"
                                . "<td style='padding:2px;$bordure'>".$objet->formatChiffre($row->DL_PrixUnitaire)."</td>"
                                . "<td style='padding:2px;$bordure'>".$objet->formatChiffre($row->DL_PUTTC_Rem)."</td>"
                                . "<td style='padding:2px;$bordure'>".$objet->formatChiffre($row->DL_PUTTC)."</td>"
                                . "<td style='padding:2px;$bordure'>".$objet->formatChiffre($row->DL_MontantHT)."</td>";



                            //if($profil_gestionnaire==0)
                                echo "<td style='padding:2px;;text-align:right$bordure'>".$objet->formatChiffre(round($row->MT_Taxe1,2))."</td>"
                                    . "<td style='padding:2px;;text-align:right$bordure'>".$objet->formatChiffre(ROUND($row->DL_MontantTTC,2))."</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                    <tr><td colspan="5" style="border-top: 1px;border-left: 0px;border-right: 0px"></td><td colspan="1" style="border-left: 0px"><b>Total</b></td>
                        <td style="border-left : 1px;border-bottom: 1px;text-align:left"><?php echo $objet->formatChiffre($totalMontantHT); ?></td>
                        <td style="border-left : 1px;border-bottom: 1px;text-align:right"><?php echo $objet->formatChiffre($totalTaxe1); ?></td>
                        <td style="border-left : 1px;border-bottom: 1px;text-align:right"><?php echo $objet->formatChiffre(ROUND($totalMontantTTC,0)); ?></td></tr>
                    <tr><td colspan="5" style="border-top: 1px;border-left: 0px;border-right: 0px"></td><td colspan="1" ><b>REMISE</b></td>
                        <td style=";text-align:right; border-left: 0px"><?php echo $objet->formatChiffre($totalremise); ?></td></tr>
                    <?php
                    if($_GET["type"]!="Devis"){
                        ?>
                        <tr><td colspan="5" style="border-left: 0px;border-right: 0px"></td><td colspan="1"><b>NET A PAYER</b></td>
                            <td style="text-align:right;border-bottom: 1px;"><?php echo $objet->formatChiffre(ROUND($totalMontantTTC,0)); ?></td></tr>
                    <?php }
                    ?>
                    </tbody></table>

            <?php }
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
                        <td style="width:350px">
                        </td>
                        <td>
                            <?php "<br/>RCN° : ".$rcn."<br/>NC : ".$nc;$date = new DateTime($dateEntete); echo $villeDepot; ?>
                        </td>
                    <tr></tr>
                    </tr>
                </table>
                <div style='<?php if($hideDivers==2) echo "width:400px;text-align: right";?>'>
                    <?php echo "<span style='text-decoration:underline;'><b>Collaborateur :</b></span> $collaborateur"; ?>
                </div>
                <div style="<?php if($hideDivers==2) echo "text-align: left"; else echo "text-align:center";?>"><b><?php echo $nomEtat." du ".$date->format('d/m/y'); ?> </b></div>
                <table id="table" class="facture" style="border:1px solid black;">
                    <thead>
                    <tr style="text-align:center">
                        <th style="padding:2px;<?php if($hideDivers==2) echo "width: 80px"; else echo "width: 80px"; ?>"><?php if($hideDivers==2) echo "Code"; else echo "Référence"; ?></th>
                        <th style="padding:3px;<?php if($hideDivers==2) echo "width: 200px"; else echo "width: 170px"; ?>">Désignation</th>
                        <th style="padding:3px;width: 30px">Qté</th>
                        <th style="padding:4px;width: 30px"><?php if($hideDivers==2) echo "PU"; else echo "PuHT"; ?></th>
                        <th style="padding:3px;;<?php if($hideDivers==2) echo "width: 45px"; else echo "width: 30px"; ?>">Rse</th>
                        <th style="padding:4px;;<?php if($hideDivers==2) echo "width: 45px"; else echo "width: 30px"; ?>"><?php if($hideDivers==2) echo "PU net"; else echo "PUttc"; ?></th>
                        <?php if($hideDivers!=2){
                         ?>
                        <th style="padding:6px;width: 30px">MtHT</th>
                        <th style="padding:6px">TVA</th>
                    <?php }?>
                        <th style="padding:6px;<?php if($hideDivers==2) echo "width: 50px"; else echo "width: 30px"; ?>"><?php if($hideDivers==2) echo "MtHT"; else echo "MtTTC"; ?></th>
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

                            echo "<tr style='padding:1px$bordure'>"
                                . "<td style='padding:1px;$bordure'>".substr($row->AR_Ref,0,7)."</td>"
                                . "<td style='width:250px;padding:2px;$bordure'>".$row->DL_Design."</td>"
                                . "<td style='padding:1px;$bordure;text-align: center'>".$objet->formatChiffre($row->DL_Qte)."</td>"
                                . "<td style='padding:1px;text-align:right;$bordure'>".$objet->formatChiffre($row->DL_PrixUnitaire)."</td>"
                                . "<td style='padding:1px;text-align:right;$bordure'>".$objet->formatChiffre($row->DL_PUTTC_Rem)."</td>"
                                . "<td style='padding:1px;text-align:right;$bordure'>".$objet->formatChiffre($row->DL_PUTTC)."</td>";
                                if($hideDivers!=2)
                                    echo "<td style='padding:1px;text-align:right;$bordure'>".$objet->formatChiffre($row->DL_MontantHT)."</td>"
                                  ."<td style='padding:1px;text-align:right$bordure'>".$objet->formatChiffre(round($row->MT_Taxe1,2))."</td>";
                                if($hideDivers==2)
                                    echo "<td style='padding:1px;text-align:right$bordure'>".$objet->formatChiffre(ROUND($row->DL_MontantHT,2))."</td></tr>";
                                else
                                    echo "<td style='padding:1px;text-align:right$bordure'>".$objet->formatChiffre(ROUND($row->DL_MontantTTC,2))."</td></tr>";

                        }
                    }
                    ?>
                    <tr><td colspan="5" style="border-top: 1px;border-left: 1px;border-right: 0px"></td><td colspan="1" style="border-left: 0px;"><b>Total</b></td>
                <?php if($hideDivers!=2){?> <td style="border-left : 1px;border-bottom: 1px;text-align:left"><?php echo $objet->formatChiffre($totalMontantHT); ?></td>
                        <td style="border-left : 1px;border-bottom: 1px;text-align:right"><?php echo $objet->formatChiffre($totalTaxe1); ?></td><?php } ?>
                        <td style="border-left : 1px;border-bottom: 1px;text-align:right"><?php if($hideDivers!=2) echo $objet->formatChiffre(ROUND($totalMontantTTC,0)); else echo $objet->formatChiffre(ROUND($totalMontantHT,0)) ?></td></tr>
                    <tr>
                        <td style="border-left:1px; border-right : 0px;"></td>
                        <td style="border-right : 0px;border-left : 0px;"></td>
                        <td style="border-right : 0px;"></td>
                        <td style="border-right : 0px;"></td>
                        <td style="border-right : 0px;"></td>
                        <td style="border-right : 0px;"></td>
                        <?php if($hideDivers!=2){?><td style="border-right : 0px;"></td>
                        <td style="border-right : 0px;"></td><?php } ?>
                        <td style="border-right : 1px;border-left : 1px;"></td>
                    </tr>
                <?php if($hideDivers!=2){?><tr>
                        <td style="border-right : 0px;"></td>
                        <td style="border-right : 0px;"></td>
                        <td style="border-right : 0px;"></td>
                        <td style="border-right : 0px;"><b>Remise</b> : </td>
                        <td style="border-right: 0px;"><?php echo $objet->formatChiffre($totalremise); ?></td>
                        <td style="border-right : 0px;"></td>
                <?php if($hideDivers!=2){?><td style="border-right : 0px;"></td>
                        <td style="border-right : 0px;"></td><?php } ?>
                        <td style="border-right : 1px;border-left : 1px;"></td>
                    </tr><?php } ?>
                    <tr>
                        <td colspan="3" style="border-right : 0px;border-bottom: 1px;text-align: center;"><?php if($hideDivers==2) echo "<b>".$objet->asLetters(ROUND($totalMontantTTC,0))."</b> FCFA."; ?></td>
                        <td style="border-left : 0px;border-right : 0px;border-bottom: 1px"><b>NET A PAYER</b> : </td>
                        <td style="border-left : 0px;border-right : 0px;border-bottom: 1px"><?php echo $objet->formatChiffre(ROUND($totalMontantTTC,0)); ?></td>
                        <td style="border-right : 0px;border-bottom: 1px"></td>
                    <?php if($hideDivers!=2){?><td style="border-right : 0px;border-bottom: 1px"></td>
                        <td style="border-right : 0px;border-bottom: 1px"></td><?php } ?>
                        <td style="border-right : 1px;border-left : 1px;border-bottom: 1px"></td>
                    </tr>
                    </tbody>

                </table>
                <br/>
                <?php
            }
            if($hideDivers!=2) {
                ?>

                <table>
                    <tr>
                        <td>Arrêter la présente facture à la somme de :
                            <b><?php echo $objet->asLetters(ROUND($totalMontantTTC, 0)) . " Francs CFA."; ?></b></td>
                    </tr>
                    <tr>
                        <td>Veuillez toujours vérifier la qualité et la quantité de vos marchandises avant de les
                            emporter.
                        </td>
                        <td style=" width : 150px;text-align: right">La direction</td>
                    </tr>
                </table>

                <?php
            }
            if($_GET["type"]!="Devis" && $_GET["type"]!="Achat") {

                ?>
                <table id="table" class="reglement">
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
                            if(end($rows)->RG_No==$row->RG_No)
                                $bordure=";border-bottom:1 px";
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
                    if(abs($resteapayer)<0.9) $resteapayer = 0;
                    ?>
                    <tr> <td style="border-right : 0px;border-left : 0px;"><br/>Reste à payer :</td><td style="border-right : 0px;"><br/><b><?php echo $objet->formatChiffre($resteapayer); ?> </b></td></tr>
                    </tbody>
                </table>

                <br/>
                <?php
            }
            if($hideDivers!=2){
                if($modeReglement !="") {
                    $result = $objet->db->requete($objet->getModeleReglementByMRNo($modeReglement));
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    if($rows==null){
                    }else {
                        echo "Date limite : " . $rows[0]->MR_Intitule;
                    }
                }
            }
            ?>
            <hr/>
            <table>
                <tr>
                    <td style="width:90px">
                        <?php echo "BP : ".$cpDepot." ".$villeDepot; ?>
                    </td>
                    <td style="width:350px;text-align: center">
                        <?php echo "Agence située à ".$adresseDepot."<br/>";
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
        $html2pdf = new HTML2PDF('P', 'A4', 'fr', true,'UTF-8',array(0, 0, 0, 0));
    if($format=="A5")
        $html2pdf = new HTML2PDF('L', 'A5', 'fr', true,'UTF-8',array(0, 0, 0, 0));
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