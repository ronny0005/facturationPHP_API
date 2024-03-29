<?php
$login = "";
$machine_pc = "";
$latitude = 0;
$longitude = 0;

session_start();

include("../Modele/DB.php");
include("../Modele/ObjetCollector.php");
include("../Modele/Objet.php");
include("../Modele/LogFile.php");
include("../Modele/ContatDClass.php");
include("../Modele/DepotClass.php");
include("../Modele/DocEnteteClass.php");
include("../Modele/DocLigneClass.php");
include("../Modele/ComptetClass.php");
include("../Modele/ReglementClass.php");
include("../Modele/ArtClientClass.php");
include("../Modele/P_CommunicationClass.php");
include("../Modele/CaisseClass.php");
include("../Modele/ArticleClass.php");
include("../Modele/ProtectionClass.php");
include("../Modele/P_ParametreLivrClass.php");
include("../Modele/DocReglClass.php");
include("../Modele/ReglEchClass.php");
include("../Modele/DepotUserClass.php");
include("../modele/MailComplete.php");
include("../modele/CompteGClass.php");
include("../modele/JournalClass.php");
include("../modele/TaxeClass.php");

$objet = new ObjetCollector();
if(isset ($_SESSION["login"]))
    $login = $_SESSION["login"];
$machine_pc = "";
$mobile="";

if($_GET["acte"] =="regle") {

    $cbMarq = 0;
    if (isset($_GET["cbMarqEntete"]))
        $cbMarq = $_GET["cbMarqEntete"];

        if (isset($_GET["cbMarqEntete"]))
            $docEntete = new DocEnteteClass($_GET["cbMarqEntete"], $objet->db);

        if (isset($_GET["PROT_No"])) {
            if (isset($_GET["valideRegle"]))
                $valideRegle = $_GET["valideRegle"];
            if ($valideRegle == 1) {
                if (!isset($_GET["valideRegltImprime"])) {
                    $mtt_avance = $_GET["montant_avance"];
                    $mode_reglement = $_GET["mode_reglement"];
                    $date_reglt = $_GET["date_reglt"];
                    $lib_reglt = substr($_GET["lib_reglt"], 0, 30);
                    $date_ech = $date_reglt;
                    if (isset($_GET["date_ech"]))
                        $date_ech = $_GET["date_ech"];

                } else {
                    $mtt_avance = str_replace(" ", "", $_GET["mtt_avance"]);
                    $mode_reglement = $_GET["mode_reglement_val"];
                    $date_reglt = $_GET["date_rglt"];
                    $lib_reglt = substr($_GET["libelle_rglt"], 0, 30);
                    $date_ech = $_GET["date_ech"];
                }
                $url = "/regle&cbMarq=$cbMarq&typeFacture={$docEntete->formatString($_GET["typeFacture"])}&protNo={$_SESSION["id"]}&valideRegle=$valideRegle&valideRegltImprime=".((isset($_GET["valideRegltImprime"])) ? 1:0)."&montantAvance=$mtt_avance&modeReglement=$mode_reglement&dateReglt={$objet->getDate($date_reglt)}&libReglt={$docEntete->formatString($lib_reglt)}&dateEch={$objet->getDate($date_ech)}";
                echo $url;
                $docEntete->getApiString($url);
            }
        }
    }


    function doImprim($cbMarq){
        $docEntete = new DocEnteteClass($cbMarq);
        $imprim = $docEntete->DO_Imprim;
        if ($imprim == 0) {
            $docEntete->maj("DO_Imprim", 1);
        }
    }

if(isset($_GET["Latitude"]))
    $latitude = $_GET["Latitude"];
if(isset($_GET["Longitude"]))
    $longitude = $_GET["Longitude"];

$cat_tarif=0;
$cat_compta=0;
$libcat_tarif="";
$libcat_compta="";
$entete="";
$affaire="";
$souche="";
$co_no=0;
$depot_no=0;
$modif=0;
$client = "";
$totalht=0;
$tva=0;
$precompte=0;
$marge=0;
$totalttc=0;
$reference="";
function dateDiff($date1, $date2){
    $diff = abs($date1 - $date2); // abs pour avoir la valeur absolute, ainsi éviter d'avoir une différence négative
    $retour = array();

    $tmp = $diff;
    $retour['second'] = $tmp % 60;

    $tmp = floor( ($tmp - $retour['second']) /60 );
    $retour['minute'] = $tmp % 60;

    $tmp = floor( ($tmp - $retour['minute'])/60 );
    $retour['hour'] = $tmp % 24;

    $tmp = floor( ($tmp - $retour['hour'])  /24 );
    $retour['day'] = $tmp;

    return $retour;
}
// Création de l'entete de document
if($_GET["acte"] =="ajout_entete"){
    $docEntete = new DocEnteteClass(0);
    echo json_encode($docEntete->ajoutEntete( isset($_GET["do_piece"]) ? $_GET["do_piece"] : "",
        $_GET["type_fac"], $_GET["date"], $_GET["date"], $_GET["affaire"], $_GET["client"], isset($_GET["userName"]) ? $_GET["userName"] : "",
        $mobile, isset($_GET["machineName"]) ? $_GET["machineName"] : "",isset($_GET["DO_Coord01"]) ? $_GET["DO_Coord01"] : "",
        isset($_GET["DO_Coord02"]) ? $_GET["DO_Coord02"] : "", isset($_GET["DO_Coord03"]) ? $_GET["DO_Coord03"] : "",isset($_GET["DO_Coord04"]) ? $_GET["DO_Coord04"] : "",
        $_GET["do_statut"], $latitude, $longitude, $_GET["de_no"], $_GET["cat_tarif"], $_GET["cat_compta"], $_GET["souche"], $_GET["ca_no"],
        $_GET["co_no"], str_replace("'","''",$_GET["reference"])));
}

// mise à jour de la référence
if( $_GET["acte"] =="ajout_reference"){
    $docEntete = new DocEnteteClass(0);
    $docEntete->majLigneByCbMarq("DO_Ref",$docEntete->formatString(str_replace("'","''",$_GET["reference"])),$_GET["cbMarq"],$_GET["protNo"]);
}

// mise à jour de la référence
if( $_GET["acte"] =="liste_article_source"){
    $article = new ArticleClass(0,$objet->db);
    $depot=$_GET["depot"];
    $rows = Array();
    if($depot!="null") {
        if ($_GET["type"] == "Ticket" || $_GET["type"] == "Vente" || $_GET["type"] == "BonLivraison" || $_GET["type"] == "Sortie" || $_GET["type"] == "Transfert" || $_GET["type"] == "Transfert_detail")
            $rows = $article->getAllArticleDispoByArRef($depot);
        else
            $rows = $article->all(0);
    }
    echo json_encode($rows);
}

// mise à jour de la référence
if( $_GET["acte"] =="entete_document") {
    $docEntete = new DocEnteteClass(0,$objet->db);
    $type_fac = $_GET["type_fac"];
    $docEntete->setTypeFac($type_fac);
    $do_souche = (isset($_GET["do_souche"])) ? ($_GET["do_souche"]=="") ? 0 : $_GET["do_souche"] : 0;
    $do_piece=$docEntete->getEnteteDocument($do_souche);
    $data = array('DC_Piece' => $do_piece);
    echo json_encode($data);
}

// mise à jour de la référence
if( $_GET["acte"] =="reste_a_payer"){
    $docEntete = new DocEnteteClass($_GET["EntetecbMarq"]);
    $reste_a_payer = $docEntete->resteAPayer;
    $data = array('reste_a_payer' => $reste_a_payer);
    echo json_encode($data);
}

// mise à jour de la référence
if( $_GET["acte"] =="ajout_date"){
    $docEntete = new DocEnteteClass(0);
    $docEntete->majByCbMarq("DO_Date",$_GET["date"],$_GET["cbMarq"]);
}

// mise à jour de la référence
if( $_GET["acte"] =="doImprim") {
    doImprim($_GET["cbMarq"]);
}

// mise à jour de la référence
if( $_GET["acte"] =="maj_collaborateur"){
    $docEntete = new DocEnteteClass(0);
    $docEntete->majLigneByCbMarq("CO_No",$_GET["collab"],$_GET["cbMarq"],$_GET["protNo"]);
}

if( $_GET["acte"] =="maj_Depot"){
    $docEntete = new DocEnteteClass(0);
    $docEntete->majByCbMarq("DE_No",$_GET["DE_No"],$_GET["cbMarq"]);
}

if( $_GET["acte"] =="client"){
    $tiers = new ComptetClass(0);
    $data = array("valeur" => $tiers-> tiersByCTIntitule($_GET["CT_Intitule"]));
    echo json_encode($data);
}

// mise à jour de la référence
if( $_GET["acte"] =="maj_affaire"){
    $docEntete = new DocEnteteClass(0);
    $docEntete->majLigneByCbMarq("CA_Num",$_GET["affaire"],$_GET["cbMarq"],$_GET["protNo"]);
}
// mise à jour de la référence
if( $_GET["acte"] == "liste_article"){
    $docEntete = new DocEnteteClass($_GET["cbMarq"]);
    $entete = $docEntete->DO_Piece;
    $typefac = $_GET["type_fac"];
    $catcompta = (isset($_GET["catcompta"]))? $_GET["catcompta"]:0;
    $cattarif = (isset($_GET["cattarif"])) ? $_GET["cattarif"] : 0;
    $totalHT = 0;
    $totalTTC = 0;
    $totalQte = 0;
    $totalDevise = 0;
    $totalCarat = 0;
    $totalPureway = 0;
    $do_domaine = $docEntete->DO_Domaine;
    $do_type = $docEntete->DO_Type;
    $table = array();
    $tabLib = array();

    $libMontantHT = "Montant HT";
    if($objet->db->flagDataOr == 1) $libMontantHT = "Montant dollar";
    array_push ($tabLib, $libMontantHT);
    array_push ($table, 0);
    $type=0;
    if($do_domaine!=0)
        $type=1;

    $i=0;
    $rowsligne=Array();

    $docligne = new DocLigneClass(0,$objet->db);
        if($entete!=null)
            $rowsligne=$docEntete->listeLigneFacture($_SESSION["id"]);
        foreach ($rowsligne as $row) {
            $docligne= new DocLigneClass($row->cbMarq);
            $totalQte = $totalQte + $docligne->DL_Qte;
            if ($typefac == "VenteRetour") {
                $totalHT = $totalHT - $docligne->DL_MontantHT;
                $totalTTC = $totalTTC - $docligne->DL_MontantTTC;
            } else {
                $totalHT = $totalHT + $docligne->DL_MontantHT;
                $totalTTC = $totalTTC + $docligne->DL_MontantTTC;
            }
            $prix = $docligne->DL_PUTTC;
            $rem = 0;
            if ($docligne->DL_TTC == 0)
                $prix = $docligne->DL_PrixUnitaire;
            $catcomptafinal = $catcompta;
            if ($do_type == 11)
                $catcomptafinal = $docligne->DL_NoColis;
            if($catcomptafinal=="")
                $catcomptafinal = 0;
            $rowsPrix = $docligne->getPrixClientHT($docligne->AR_Ref, $catcomptafinal, $cattarif, $prix, $rem, $docligne->DL_Qte, $type);
            $pos = getItem($tabLib, $rowsPrix[0]->IntituleT1);
            if ($pos == -1) {
                array_push($tabLib, $rowsPrix[0]->IntituleT1);
                if ($typefac == "VenteRetour")
                    array_push($table, -$docligne->MT_Taxe1);
                else
                    array_push($table, $docligne->MT_Taxe1);
            } else {
                if ($typefac == "VenteRetour")
                    $table[$pos] = $table[$pos] - $docligne->MT_Taxe1;
                else
                    $table[$pos] = $table[$pos] + $docligne->MT_Taxe1;
            }
            $pos = getItem($tabLib, $rowsPrix[0]->IntituleT2);
            if ($pos == -1) {
                array_push($tabLib, $rowsPrix[0]->IntituleT2);

                if ($typefac == "VenteRetour")
                    array_push($table, -$docligne->MT_Taxe2);
                else
                    array_push($table, $docligne->MT_Taxe2);
            } else {
                if ($typefac == "VenteRetour")
                    $table[$pos] = $table[$pos] - $docligne->MT_Taxe2;
                else
                    $table[$pos] = $table[$pos] + $docligne->MT_Taxe2;
            }
            $pos = getItem($tabLib, $rowsPrix[0]->IntituleT3);
            if ($pos == -1) {
                array_push($tabLib, $rowsPrix[0]->IntituleT3);
                if ($typefac == "VenteRetour")
                    array_push($table, -$docligne->MT_Taxe3);
                else
                    array_push($table, $docligne->MT_Taxe3);
            } else {
                if ($typefac == "VenteRetour")
                    $table[$pos] = $table[$pos] - $docligne->MT_Taxe3;
                else
                    $table[$pos] = $table[$pos] + $docligne->MT_Taxe3;
            }
        }

    $table[0]=$totalHT;
    array_push($tabLib, "Total quantité");
    array_push($table, $totalQte);

    if($do_domaine!=2) {
        array_push($tabLib, "Montant TTC");
        array_push($table, $totalTTC);
    }

    if(sizeof($rowsligne)>0){
        for($i=0;$i<sizeof($tabLib);$i++){
            if($tabLib[$i]!=""){
                $montant = $table[$i];
                if($do_domaine==2 && $do_type==23)
                    $montant = $montant /2;
                echo "  <div class='row mt-1 font-weight-bold'>
                        <div class='col-4 col-lg-2'>{$tabLib[$i]} : </div>
                        <div class='col-4 col-lg-2 text-right'> {$objet->formatChiffre($montant)}</div>
                        </div>";
            }
        }
    }
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
if( $_GET["acte"] =="calcul_pied"){
    $docEntete = new DocEnteteClass($_GET["cbMarq"],$objet->db);
    echo json_encode($docEntete->getLigneFacture(0));
}

if($_GET["acte"] =="saisie_comptable") {
    $docEntete = new DocEnteteClass($_GET["cbMarq"],$objet->db);
    $trans = 0;
    if(isset($_GET["TransDoc"]))
        $trans = $_GET["TransDoc"];
    echo json_encode(saisie_comptable($_GET["cbMarq"],$objet));
}

if($_GET["acte"] =="majComptaFonction") {
    $objet->db->connexion_bdd->beginTransaction();
    try {
        $typeTransfert = $_GET["typeTransfert"];
        if ($typeTransfert == 1 || $typeTransfert == 2) {
            $etatPiece = $_GET["souche"];
            $docEntete = new DocEnteteClass(0, $objet->db);
            $do_domaine = 0;
            if ($typeTransfert == 2) $do_domaine = 1;
            $do_type = 6;
            if ($typeTransfert == 2) {
                $do_type = 16;
                if ($etatPiece == 1)
                    $do_type = 17;
            } else
                if ($etatPiece == 1)
                    $do_type = 7;

            $docEntete->majComptaRglt($objet->getDate($_GET["datedebut"]), $objet->getDate($_GET["datefin"])
                , $_GET["facturedebut"], $_GET["facturefin"], $do_domaine, $do_type, $etatPiece, $_GET["catCompta"]
                , $_GET["caisse"],$_GET["journal"]);
        }
        if ($typeTransfert == 3 || $typeTransfert == 4) {
            $docEntete = new DocEnteteClass(0, $objet->db);
            $docEntete->getListeReglementMajComptable($_GET["typeTransfert"], $objet->getDate($_GET["datedebut"]), $objet->getDate($_GET["datefin"]), $_GET["caisse"], $_GET["transfert"],$_GET["journal"]);
        }
        $objet->db->connexion_bdd->commit();
    } catch (Exception $e) {
        $objet->db->connexion_bdd->rollBack();
        return json_encode($e);
    }
}


if($_GET["acte"] =="majCompta") {
    $trans = 0;
    if(isset($_GET["TransDoc"]))
        $trans = $_GET["TransDoc"];
//    majCompta($DO_Piece,$DO_Domaine,$DO_Type,$trans);
}

function saisie_comptable ($cbMarq,$objet){
    $docEntete = new DocEnteteClass($cbMarq);
    return $docEntete->saisie_comptable();
}

function getItemCompta($table,$val){
    $pos=-1;
    if($table!=null)
    for($i=0;$i<sizeof($table);$i++){
        if(strcmp($table[$i]["CG_Num"],$val)==0){
            $pos = $i;
        }
    }
    return $pos;
}

if($_GET["acte"] =="saisie_comptableAnal") {
    return saisie_comptableAnal($_GET["cbMarq"]);
}

function saisie_comptableAnal($cbMarq){
    $docEntete = new DocEnteteClass($cbMarq);
    echo json_encode($docEntete->getLigneMajAnalytique());
}

if($_GET["acte"] =="clotureVente") {
    $docEntete = new DocEnteteClass(0,$objet->db);
    $docEntete->clotureVente($_GET["CA_Num"]);
}

if($_GET["acte"] =="stockMinDepasse") {
    $article = new ArticleClass($_GET["AR_Ref"],$objet->db);
    echo json_encode($article->stockMinDepasse($_GET["DE_No"]));
}

if($_GET["acte"] =="saisie_comptableCaisse") {
    $trans = 0;
    $docEntete = new DocEnteteClass($_GET["cbMarq"]);
    if(isset($_GET["TransDoc"]))
        $trans = $_GET["TransDoc"];
    echo json_encode(saisieComptableCaisse($_GET["cbMarq"]));
}

function saisieComptableCaisse($cbMarq){
    $docEntete = new DocEnteteClass($cbMarq);
    $listReglt = $docEntete->getReglementByFacture($docEntete->cbMarq);
    $result = array();
    foreach ($listReglt as $rglt){
        foreach (saisieComptableCaisseReglement($rglt->RG_No) as $elem)
        array_push($result, $elem);
    }
    return $result;
}



    function saisieComptableCaisseReglement($RG_No){
        $reglement = new ReglementClass($RG_No);
        return $reglement->getMajComptaListe();
    }

if($_GET["acte"] =="verif_stock"){
    $article = new ArticleClass($_GET["designation"],$objet->db);
    $rows = $article->isStock($_GET["DE_No"]);
    $msg="";
    foreach ($rows as $row){
        $AS_QteSto = $row->AS_QteSto;
        if(($AS_QteSto+$_GET["ADL_Qte"])>=($_GET["quantite"])){
        }else{
            $msg = "La quantité de {$_GET["designation"]} ne doit pas dépasser ".ROUND($AS_QteSto+$_GET["ADL_Qte"],2)." !";
        }
    }
    $data = array('message' => $msg);
    echo json_encode($data);
}

//ajout article
if($_GET["acte"] =="ajout_ligne"|| $_GET["acte"] =="modif"){
    $cbMarq = 0;
    if(isset($_GET["cbMarq"]))
        $cbMarq = $_GET["cbMarq"];
    $docligne = new DocLigneClass($cbMarq,$objet->db);

    if(isset($_GET["PROT_No"])) {
            echo $docligne->ajout_ligneFacturation($_GET["quantite"],
                isset($_GET["designation"])? $_GET["designation"]:""
                ,$_GET["cbMarqEntete"],$_GET["type_fac"],
                $_GET["cat_tarif"],$_GET["prix"],$_GET["remise"],
                $_GET["machineName"], $_GET["acte"],$_GET["PROT_No"],$_GET["depotLigne"]);
    }
}

if($_GET["acte"]=="ligneFacture"){
    $docEntete = new DocEnteteClass($_GET["cbMarqEntete"],$objet->db);
    $flagPxRevient=$_GET["flagPxRevient"];
    $flagPxAchat=$_GET["flagPxAchat"];
    $protectionClass = new ProtectionClass("","",$objet->db);
    $protectionClass->connexionProctectionByProtNo($_GET["PROT_No"]);
    $typeDocument = $_GET["typeFac"];
    $rows = $docEntete->listeLigneFacture($_GET["PROT_No"]);
    $do_domaine = $docEntete->DO_Domaine;
    $i = 0;
    $classe = "";
    $fournisseur = 0;
    if ($do_domaine != 0)
        $fournisseur = 1;
    if ($rows != null) {
        foreach ($rows as $row) {
            $docligne = new DocLigneClass($row->cbMarq);
            $depotLigne = new DepotClass($docligne->DE_No);
            $typefac = 0;
            $rows = $docligne->getPrixClientHT($docligne->AR_Ref, $docEntete->N_CatCompta, $cat_tarif, 0, 0, $docligne->DL_Qte, $fournisseur);
            if (sizeof($rows)>0) {
                $typefac = $rows[0]->AC_PrixTTC;
            }
            $i++;
            if ($i % 2 == 0) $classe = "info";
            else $classe = "";
            $qteLigne = (round($docligne->DL_Qte * 100) / 100);
            $remiseLigne = $docligne->DL_Remise;


            $puttcLigne = ROUND($docligne->DL_PUTTC, 2);
            $montantHTLigne = ROUND($docligne->DL_MontantHT, 2);
            $montantTTCLigne = ROUND($docligne->DL_MontantTTC, 2);
            $qteLivreeLigne = (round($docligne->Qte_LivreeBLCalc * 100) / 100);
            if ($typeDocument == "VenteRetour") {
                $qteLigne = -$qteLigne;
                $montantTTCLigne = -$montantTTCLigne;
                $montantHTLigne = -$montantHTLigne;
            }
$isSecurite = $protectionClass->IssecuriteAdmin($docEntete->DE_No);

$isVisu = $docEntete->isVisu($protectionClass->PROT_Administrator,$protectionClass->protectedType($typeDocument),$protectionClass->PROT_APRES_IMPRESSION,$isSecurite);
            ?>
            <tr class='facture $classe' id='article_<?= $docligne->cbMarq; ?>'>
                <td id='AR_Ref' style='color:blue;text-decoration: underline'><?= $docligne->AR_Ref; ?></td>
                <td id='DL_Design' style='align:left'><?= $docligne->DL_Design; ?></td>
                <td id='DL_PrixUnitaire' style="<?php
                if((($typeDocument =="Achat" || $typeDocument =="AchatC" || $typeDocument =="AchatT" || $typeDocument =="AchatPreparationCommande"|| $typeDocument =="PreparationCommande")&& $flagPxAchat!=0))
                    echo "display:none";?>"><?= $objet->formatChiffre(round($docligne->DL_PrixUnitaire, 2)); ?> </td>
                <td id='DL_Qte'><?= $objet->formatChiffre($qteLigne) ?></td>
                <td style="<?php if($typeDocument!="Livraison") echo "display:none";?>" id='Qte_LivreeBL' ><?= $objet->formatChiffre($qteLivreeLigne); ?></td>
                <td id='DL_Remise'><?= $remiseLigne?></td>
                <td id='PUTTC' style="<?php
                if((($typeDocument =="Achat" || $typeDocument =="AchatC" || $typeDocument =="AchatT" || $typeDocument =="AchatPreparationCommande"|| $typeDocument =="PreparationCommande")&& $flagPxAchat!=0))
                    echo "display:none";?>"><?= $objet->formatChiffre($puttcLigne) ?></td>
                <td id='DL_MontantHT' style="<?php
                if((($typeDocument=="Achat" || $typeDocument =="AchatC" || $typeDocument =="AchatT" || $typeDocument =="AchatPreparationCommande"|| $typeDocument =="PreparationCommande")&& $flagPxAchat!=0))
                    echo "display:none";?>"><?= $objet->formatChiffre($montantHTLigne); ?></td>
                <td id='DL_MontantTTC' style="<?php
                if((($typeDocument =="Achat" || $typeDocument =="AchatC" || $typeDocument =="AchatT" || $typeDocument =="AchatPreparationCommande"|| $typeDocument =="PreparationCommande")&& $flagPxAchat!=0))
                    echo "display:none";?>"> <?= $objet->formatChiffre($montantTTCLigne); ?> </td>
                <td id="deIntitule"><?= $depotLigne->DE_Intitule ?></td>
                <td style='display:none' id="depotLigne"><?= $depotLigne->DE_No ?></td>
                <td style='display:none' id='DL_PieceBL'><?= $docligne->DL_PieceBL; ?></td>

                <td style='display:none' id='DL_NoColis'><?= $docligne->DL_NoColis; ?></td>
                <td style='display:none' id='cbMarq'><?= $docligne->cbMarq; ?></td>
                <td style='display:none' id='DL_CMUP'><?= $docligne->DL_CMUP; ?></td>
                <td style='display:none' id='DL_TYPEFAC'><?= $typefac; ?></td>
                <?php
            if ((!$isVisu && ($typeDocument == "PreparationCommande" || $typeDocument == "AchatPreparationCommande")))
                echo "<td id='lignea_{$docligne->cbMarq}'><i class='fa fa-sticky-note fa-fw'></i></td>";
                if ($protectionClass->PROT_Administrator || $protectionClass->PROT_Right) {
                    echo "  <td id='modif_{$docligne->cbMarq}'>
                            <i class='fa fa-pencil fa-fw'></i>
                        </td>";
                    if ($typeDocument == "Livraison"){
                        echo "<td id='editLivraison'>";
                        if($docligne->Qte_LivreeBL!=0)
                            echo"<i class='fa fa-list fa-fw'></i>";
                        echo "</td>";
                    }
                    echo"<td id='suppr_{$docligne->cbMarq}'>
                            <i class='fa fa-trash-o'></i>
                        </td>";
                }
                else {
                    if (!$isVisu || ($docEntete->DO_Modif==0 && $type == "Livraison"))
                        echo "<td id='modif_{$docligne->cbMarq}'>
                            <i class='fa fa-pencil fa-fw'></i></td>";
                    if ($type == "Livraison"){
                        echo "<td id='editLivraison'>";
                        if($docligne->Qte_LivreeBL!=0)
                            echo"<i class='fa fa-list fa-fw'></i>";
                        echo "</td>";
                    }

                    if (!$isVisu)
                        echo "<td id='suppr_{$docligne->cbMarq}'><i class='fa fa-trash-o'></i></a></td>";
                }
                if($protectionClass->PROT_CBCREATEUR!=2)
                    echo "<td></td><td>{$docligne->getcbCreateurName()}</td>";
                echo"</tr>";
            $totalht = $totalht + ROUND($docligne->DL_MontantHT, 2);
            $tva = $tva + ROUND($docligne->MT_Taxe1, 2);
            $precompte = $precompte + ROUND($docligne->MT_Taxe2, 2);
            $marge = $marge + ROUND($docligne->MT_Taxe3, 2);
            $totalttc = $totalttc + ROUND($docligne->DL_MontantTTC, 2);
        }
    }
}
                if($_GET["acte"]=="listeElementLivraison") {
                    $docligne = new DocLigneClass($_GET["cbMarq"]);

                    echo "  <div class='table-responsive'>
<table id='listQteLivree' class='table table-striped'>
<tr class='text-center'>
    <th>Qté BL</th>
    <th>User</th>
    <th>Date</th>";

                    if($_GET["admin"]==1)
                        echo "<th></th>";
                    echo"</tr>";
                    foreach($docligne->listeLivraison() as $row){
                        echo "<tr id='itemQteLivree'>
<td>";
                        if($_GET["admin"]==1)
                        {
                            echo "<input type='' name='qteLivree' class='form-control' id='qteLivree' value='{$objet->formatChiffre($row->DL_QteBL)}' />";
                        }
                        else{
                            echo $objet->formatChiffre($row->DL_QteBL);
                        }
                        echo"</td>
<td>{$row->USER_GESCOM}<span id='prevQte' style='display:none'>{$objet->formatChiffre($row->DL_QteBL)}</span></td>
    <td>{$objet->getDateDDMMYYYY($row->cbModification)}</td>
      <td style='display:none' id='cbMarq'>{$row->cbMarq}</td>";


                        if($_GET["admin"]==1)
                            echo "<td><i id='deleteQteLivree' class='fa fa-trash fa-fw'></i></td>";
                        echo"</tr>";
                    }
                    echo "</table></div>";
                }

                if($_GET["acte"]=="deleteQteLivree") {
                    $docligne = new DocLigneClass(0);
                    $docligne->deleteQteLivree($_GET["cbMarq"],$_GET["PROT_No"]);
                }

                if($_GET["acte"]=="updateQteLivree") {
                    $docligne = new DocLigneClass(0);
                    echo $docligne->updateQteLivree($_GET["cbMarq"],$_GET["PROT_No"],$_GET["qte"]);
                }
if($_GET["acte"]=="initLigneconfirmation_document") {
    $docligne = new DocLigneClass(0,$objet->db);
    $docligne->ligneConfirmationVisuel($_GET["cbMarq"]);
}

if($_GET["acte"]=="confirmation_document"){
    $cbMarq = $_GET["cbMarq"];
    $docEntete = new DocEnteteClass($cbMarq,$objet->db);
    $ligne = $docEntete->getLignetConfirmation();
    $listCbMarq = mb_split(";",$_GET["listCbMarq"]);
    $listQteRecu = mb_split(";",$_GET["listQteRecu"]);
    $enteteEmission = $docEntete->DO_Piece;
    $cbMarqTrsft = 0;
    $enteteContrepartie = null;
    try {
        $objet->db->connexion_bdd->beginTransaction();

        $entete = $docEntete->addDocenteteTransfertProcess($docEntete->DO_Date, $docEntete->DO_Ref, $docEntete->DO_Coord02,
            $docEntete->CA_Num, $docEntete->DE_No, $docEntete->longitude, $docEntete->latitude, "Transfert", "");
        $entete->maj("DO_Imprim","1");
        $cbMarqTrsft = $entete->cbMarq;
        $supplement = false;
        $listLigne = array();
        foreach ($ligne as $row) {
            $docligneSuppr = new DocLigneClass($row->cbMarqLigneFirst, $objet->db);
            $docligneSuppr->supprLigneTransfert(0,1);
            array_push($listLigne,$docligneSuppr);
            $docligne = new DocLigneClass(0, $objet->db);
            for ($i = 0; $i < sizeof($listCbMarq); $i++) {
                if ($listCbMarq[$i] == $row->cbMarqLigneFirst) {
                    if ($listQteRecu[$i] != $row->DL_Qte)
                        $supplement = true;
                }
            }
            $var1 = $docligne->addDocligneTransfertProcess($row->AR_Ref, $row->DL_PrixUnitaire, $row->DL_Qte
                , "3", "", $entete->cbMarq
                , $docEntete->cbCreateur, 0);
            $docLigneMaj = new DocLigneClass($var1->cbMarq,$objet->db);
            $docLigneMaj->maj("DL_PieceBC",$enteteEmission);
            $docLigneMaj->maj("DL_PieceBL",$enteteEmission);
            $var2 = $docligne->addDocligneTransfertProcess($row->AR_Ref, $row->DL_PrixUnitaire, $row->DL_Qte, "1"
                , "", $entete->cbMarq, $_SESSION["id"], $var1->cbMarq);
            $docLigneMaj = new DocLigneClass($var2->cbMarq,$objet->db);
            $docLigneMaj->maj("DL_PieceBC",$enteteEmission);
            $docLigneMaj->maj("DL_PieceBL",$enteteEmission);
        }
        if (!$supplement) {
        } else {
            $docEnteteContrePartie = new DocEnteteClass(0, $objet->db);
            $enteteContrepartie = $docEnteteContrePartie->addDocenteteTransfertProcess($docEntete->DO_Date, "RT {$docEntete->DO_Piece}", $docEntete->DE_No,
                $docEntete->CA_Num, $docEntete->DO_Coord02, $docEntete->longitude, $docEntete->latitude, "Transfert","");
            $enteteContrepartie->maj("DO_Imprim","1");
            foreach ($ligne as $row) {
                for ($i = 0; $i < sizeof($listCbMarq); $i++) {
                    if ($listCbMarq[$i] == $row->cbMarqLigneFirst) {
                        if ($listQteRecu[$i] != $row->DL_Qte) {
                            $docligne = new DocLigneClass(0, $objet->db);
                            $qte = $row->DL_Qte - $listQteRecu[$i];
                            $var1 = $docligne->addDocligneTransfertProcess($row->AR_Ref, $row->DL_PrixUnitaire, $qte
                                , "3", "", $enteteContrepartie->cbMarq
                                , $docEntete->cbCreateur, 0);
                            $docLigneMaj = new DocLigneClass($var1->cbMarq,$objet->db);
                            $docLigneMaj->maj("DL_PieceBC",$enteteEmission);
                            $docLigneMaj->maj("DL_PieceBL",$enteteEmission);
                            $var2 = $docligne->addDocligneTransfertProcess($row->AR_Ref, $row->DL_PrixUnitaire, $qte
                                , "1"
                                , "", $enteteContrepartie->cbMarq, $_SESSION["id"], $var1->cbMarq);
                            $docLigneMaj = new DocLigneClass($var2->cbMarq,$objet->db);
                            $docLigneMaj->maj("DL_PieceBC",$enteteEmission);
                            $docLigneMaj->maj("DL_PieceBL",$enteteEmission);
                        }
                    }
                }
            }
        }
        $docEntete->delete();
        $objet->db->connexion_bdd->commit();

        $data = array('cbMarq' =>  $entete->cbMarq,'cbMarqContrepartie' => ($supplement) ? $enteteContrepartie->cbMarq : 0);
        echo json_encode($data);
    }
    catch(Exception $e){
        $objet->db->connexion_bdd->rollBack();
        return json_encode($e);
    }
}

if($_GET["acte"]=="ligneFactureStock"){
    $protNo = $_GET["PROT_No"];
    $protection = new ProtectionClass("","");
    $protection->connexionProctectionByProtNo($protNo);
    $docEntete = new DocEnteteClass($_GET["cbMarqEntete"],$objet->db);
                $typeDocument = $_GET["typeFac"];
    $isSecurite = $protection->IssecuriteAdmin($docEntete->DE_No);

    $isVisu = $docEntete->isVisu($protection->PROT_Administrator,$protection->protectedType($typeDocument ),$protection->PROT_APRES_IMPRESSION,$isSecurite);
    $docligne = new DocLigneClass(0,$objet->db);
    $totalqte = 0;

    if($typeDocument=="Transfert")
        $rows=$docEntete->getLigneTransfert();
    else if($typeDocument=="Transfert_confirmation")
        $rows=$docEntete->getLigneTransfert();
    else if($typeDocument=="Transfert_detail")
        $rows = $docEntete->getLigneTransfert_detail();
    else if($typeDocument=="Transfert_valid_confirmation")
        $rows=$docEntete->getLignetConfirmation();
    else
        $rows=$docEntete->getLigneFactureTransfert();
    $flagPxRevient = $_GET["flagPxRevient"];
    $i=0;
    $id_sec=0;
    $classe="";
    if($rows==null){
    }else{
        foreach ($rows as $row){
            $i++;
            $docligne = new DocLigneClass($row->cbMarq,$objet->db);
            $prix = $row->DL_PrixUnitaire;
            $remise = $row->DL_Remise;
            $qte=$row->DL_Qte;
            $type_remise = 0;
            $rem=0;
            if(strlen($remise)!=0){
                if(strpos($remise, "%")){
                    $remise=str_replace("%","",$remise);
                    $rem = $prix * $remise / 100;
                }
                if(strpos($remise, "U")){
                    $remise=str_replace("U","",$remise);
                    $rem = $remise;
                }
            }else $remise=0;
            if($i%2==0)
                $classe = "info";
            else $classe = "";
            $a=round(($prix- $rem)*$qte,0);
            $b=round(($a * $row->DL_Taxe1)/100,0);
            $c=round(($a * $row->DL_Taxe2)/100,0);
            $d=($row->DL_Taxe3 * $qte);
            $totalht=$totalht+$a;
            $totalqte=$totalqte+$qte;
            $tva = $tva +$b;
            $precompte=$precompte+$c;
            $marge=$marge+$d;
            $totalttc=$totalttc+round(($a+$b+$c)+$d,0);

            if($typeDocument!="Transfert_detail") {
                echo "<tr class='facture $classe' id='article_{$row->cbMarq}'>
                        <td id='AR_Ref' style='color:blue;text-decoration: underline'>{$row->AR_Ref}</td>
                        <td id='DL_Design' style='align:left'>{$row->DL_Design}</td>";
                ?>
                <td id='DL_PrixUnitaire' style="<?php
                if ($flagPxRevient != 0)
                    echo "display:none"; ?>"><?= $objet->formatChiffre(round($row->DL_PrixUnitaire, 2)); ?> </td>
                <?php
                echo "<td id='DL_Qte'>{$objet->formatChiffre(round($row->DL_Qte * 100) / 100)}</td>";
                //. "<td id='DL_Remise'>".$row->DL_Remise."</td>"
                if ($flagPxRevient == 0)
                    echo "<td id='DL_MontantHT'>{$objet->formatChiffre($row->DL_MontantHT)}</td>";
                else "<td></td>";
                echo "<td style='display:none' id='cbMarq'>{$row->cbMarq}</td>
                      <td style='display:none' id='id_sec'>{$row->idSec}</td>";

                    if(!$isVisu && $typeDocument!="Transfert" && $typeDocument!="Transfert_confirmation" && $typeDocument!="Transfert_detail")
                        echo "<td id='modif_{$row->cbMarq}'><i class='fa fa-pencil fa-fw'></i></td>";
                    if(!$isVisu && $typeDocument!="Transfert_valid_confirmation")
                        echo "<td id='suppr_{$row->cbMarq}'><i class='fa fa-trash-o'></i></td>";

                    if($protection->PROT_CBCREATEUR!=2)
                        echo "<td>{$docligne->getcbCreateurName()}</td>";
                    echo"</tr>";
                }else{
                $montantHT = round($row->DL_MontantHT*100)/100;
                $montantHT_dest = round($row->DL_MontantHT_dest*100)/100;
                ?>
                <tr class='facture <?= $classe ?>' id='article_<?= $row->cbMarq ?>'>
                    <td id='AR_Ref'><?= $row->AR_Ref ?></td>
                    <td id='DL_Design'><?= $row->DL_Design ?></td>
                    <td id='DL_PrixUnitaire'><?= round($row->DL_PrixUnitaire,2); ?></td>
                    <td id='DL_Qte'><?= (round($row->DL_Qte*100)/100) ?></td>
                    <td id='DL_MontantHT'><?= $montantHT ?></td>
                    <td style='display:none' id='cbMarq'><?= $row->cbMarq ?></td>
                    <td style='display:none' id='id_sec'><?= $row->idSec ?></td>
                    <td id='AR_Ref_dest'><?= $row->AR_Ref_Dest ?></td>
                             <td id='AR_Design_dest'><?= $row->DL_Design_Dest ?></td>
                                <td id='DL_Qte_dest'><?= (round($row->DL_Qte_dest*100)/100) ?></td>
                                <td id='DL_MontantHT_dest'><?= $montantHT_dest ?></td>
                <?php
                if(!isset($_GET["visu"])) echo "<td id='suppr_{$row->cbMarq}'><i class='fa fa-trash-o'></i></td>";
                if($protection->PROT_CBCREATEUR!=2)
                    echo "<td>{$docligne->getcbCreateurName()}</td>";
                echo "</tr>";
            }
        }
    }
}
//suppression d'article
if($_GET["acte"] =="suppr"){
    $docligne = new DocLigneClass(0);
    $idSec = (isset($_GET["id_sec"])) ? $_GET["id_sec"] : 0;
    echo json_encode($docligne->supprLigneFacture($_GET["id"],$idSec,$_GET["type_fac"],$_GET["PROT_No"]));
}

if($_GET["acte"] =="canTransform") {
    $cbMarqBL=$_GET["cbMarq"];
    $docEnteteBL= new DocEnteteClass($cbMarqBL,$objet->db);
    $type_trans= $_GET["type_trans"];
    $type=$_GET["type"];
    $do_type=3;
    $type_res="Vente";
    if($type_trans==3) $type_res="BonLivraison";
    if($type=="Devis") $do_type=0;
    $listeArticle="";
    if($type!="BonLivraison" && Sizeof($docEnteteBL->getStatutVente($type_res))>0) {
        $listeArticle = $docEnteteBL->canTransform();
    }
    echo $listeArticle;
}

if($_GET["acte"] == "transBLFacture"){
    $docEnteteBL = new DocEnteteClass($_GET["cbMarq"]);
    $docEnteteBL->transformBL_Dev_Facture ($_GET["conserv_copie"],$_GET["canTransform"],$_GET["type_trans"],$_GET["reference"],$_GET["type"]);
}

if( $_GET["acte"] =="suppr_factureConversion"){
    $docEntete = new DocEnteteClass($_GET["cbMarq"], $objet->db);
    $protection = new ProtectionClass("","");
    $protection->connexionProctectionByProtNo($_SESSION["id"]);
    $isSecurite = $protection->IssecuriteAdmin($docEntete->DE_No);
    if($isSecurite==0){
        echo "securiteAdmin";
        return ;
    }

    $rows = $docEntete->getLigneFacture();
    if (sizeof($rows) > 0) {
        $docligne = new DocLigneClass($rows[0]->cbMarq);
        if($docligne->DL_PieceBL!="")
            echo "Voulez vous transformer le document {$docEntete->DO_Piece} vers {$docligne->DL_PieceBL} ?";
    }
}

                if( $_GET["acte"] =="transformDoc"){
                    $docEntete = new DocEnteteClass($_GET["cbMarq"],$objet->db);
                    $type = $_GET["type"];
                    $rows = $docEntete->getLigneFacture();
                    if(sizeof($rows)>0){
                        $docligne = new DocLigneClass($rows[0]->cbMarq);
                        $docEnteteDevis = new DocEnteteClass(0);
                        $docEnteteDevis->setTypeFac("Devis");
                        $doPieceDevis = $docEnteteDevis->getEnteteDocument($docEntete->DO_Souche);
                        $docEnteteBL = new DocEnteteClass(0);
                        $docEnteteBL->setTypeFac("BonLivraison");
                        $doPieceBL = $docligne->DL_PieceBL; //$docEnteteBL->getEnteteDocument($docEntete->DO_Souche);
                        if(substr($doPieceDevis,0,4) == substr($docligne->DL_PieceBL,0,4)){
                            $docEnteteBL =  $docEnteteDevis;
                            $doPieceBL = $docligne->DL_PieceBL;
                        }
                        $data = $docEnteteBL->ajoutEntete($doPieceBL,$docEnteteBL->type_fac,$docligne->DL_DateBC,$docEntete->DO_Date,$docEntete->CA_Num
                            ,$docEntete->DO_Tiers,"","","",$docEntete->DO_Coord01,$docEntete->DO_Coord02
                            ,$docEntete->DO_Coord03,$docEntete->DO_Coord04,$docEntete->DO_Statut,$docEntete->latitude
                            ,$docEntete->longitude,$docEntete->DE_No,$docEntete->DO_Tarif,$docEntete->N_CatCompta
                            ,$docEntete->DO_Souche,$docEntete->CA_No,$docEntete->CO_No,$docEntete->DO_Ref,1);
                        $cbMarq = $data['cbMarq'];
                        $docEnteteTransform = new DocEnteteClass($cbMarq);
                        foreach($rows as $row)  {
                            $docligneTransform = new DocLigneClass($row->cbMarq);
                            $docligneFinal = new DocLigneClass(0);
                            $docligneFinal->ajout_ligneFacturation($docligneTransform->DL_Qte,$docligneTransform->AR_Ref,$cbMarq,$docEnteteBL->type_fac
                                ,$docEnteteTransform->DO_Tarif,$docligneTransform->DL_PrixUnitaire,""
                                ,"","ajout_ligne",$_SESSION["id"]);
                            $docligneTransform->delete();
                        }
                        $docEntete->deleteEntete();
                    }
                }


if( $_GET["acte"] =="transformDocLigne"){
    $docligne = new DocLigneClass($_GET["cbMarq"],$objet->db);
    $docEntete = new DocEnteteClass($_GET["cbMarqEntete"]);
    $docEnteteDevis = new DocEnteteClass(0);
    $docEnteteDevis->setTypeFac("Devis");
    $doPieceDevis = $docEnteteDevis->getEnteteDocument($docEntete->DO_Souche);
    $docEnteteBL = new DocEnteteClass(0);
    $docEnteteBL->setTypeFac("BonLivraison");
    $doPieceBL = $docligne->DL_PieceBL; //$docEnteteBL->getEnteteDocument($docEntete->DO_Souche);
    if(substr($doPieceDevis,0,4) == substr($docligne->DL_PieceBL,0,4)){
        $docEnteteBL =  $docEnteteDevis;
        $doPieceBL = $docligne->DL_PieceBL;
    }
    $result = $docEnteteBL->getEnteteByDOPiece($doPieceBL);
    $cbMarq=0;
    if($result==null) {
        $data = $docEnteteBL->ajoutEntete($doPieceBL, $docEnteteBL->type_fac, $docligne->DL_DateBC, $docEntete->DO_Date, $docEntete->CA_Num
            , $docEntete->DO_Tiers, "", "", "", $docEntete->DO_Coord01, $docEntete->DO_Coord02
            , $docEntete->DO_Coord03, $docEntete->DO_Coord04, $docEntete->DO_Statut, $docEntete->latitude
            , $docEntete->longitude, $docEntete->DE_No, $docEntete->DO_Tarif, $docEntete->N_CatCompta
            , $docEntete->DO_Souche, $docEntete->CA_No, $docEntete->CO_No, $docEntete->DO_Ref,1);
        $cbMarq = $data['cbMarq'];
    }else{
        $cbMarq = $docEnteteBL->getDocumentByDOPiece($doPieceBL,$docEnteteBL->DO_Domaine,$docEnteteBL->DO_Type)->cbMarq;
    }
    $docEnteteBL = new DocEnteteClass($cbMarq);
    $docligneFinal = new DocLigneClass(0);
    $docligneFinal->ajout_ligneFacturation($docligne->DL_Qte,$docligne->AR_Ref,$cbMarq,$docEnteteBL->type_fac
        ,$docEnteteBL->DO_Tarif,$docligne->DL_PrixUnitaire,""
        ,"","ajout_ligne",$_SESSION["id"]);
    $docligne->delete($_SESSION["id"]);
}

                // mise à jour de la référence
if( $_GET["acte"] =="suppr_facture"){
    $docEntete = new DocEnteteClass($_GET["cbMarq"],$objet->db);
    $rows = $docEntete->getLigneFacture();
    if ($rows != null) {
        foreach ($rows as $row){
            $docligne = new DocLigneClass($row->cbMarq,$objet->db);
            $DL_Qte=$row->DL_Qte;
            $DE_No=$row->DE_No;
            $AR_PrixAch=$row->AR_PrixAch;
            $AR_Ref=$row->AR_Ref;
            $article = new ArticleClass($AR_Ref,$objet->db);
            $docligne ->delete($_SESSION["id"]);
            if($_GET["type"]=="Vente" ||$_GET["type"]=="BonLivraison"||$_GET["type"]=="Sortie")
                $article->updateArtStock($DE_No,+$DL_Qte,+($AR_PrixAch*$DL_Qte),$_SESSION["id"],$_GET["acte"]);
            if($_GET["type"]=="Entree" || $_GET["type"]=="Achat")
                $article->updateArtStock($DE_No,-$DL_Qte,-($AR_PrixAch*$DL_Qte),$_SESSION["id"],$_GET["acte"]);
            if($_GET["type"]=="Transfert"){
                if($row->DL_MvtStock==3)
                    $article->updateArtStock($DE_No,+$DL_Qte,+($AR_PrixAch*$DL_Qte),$_SESSION["id"],$_GET["acte"]);
                else
                    $article->updateArtStock($DE_No,-$DL_Qte,-($AR_PrixAch*$DL_Qte),$_SESSION["id"],$_GET["acte"]);
            }
        }
    }
    $type=$_GET["type"];
    $docEntete->suppressionReglement();
    $ajout="";
        if(isset($_GET["datedebut"]))
            $ajout=$ajout."&datedebut=".$_GET["datedebut"];
        if(isset($_GET["datefin"]))
            $ajout=$ajout."&datefin=".$_GET["datefin"];
        if(isset($_GET["depot"]))
            $ajout=$ajout."&depot=".$_GET["depot"];
}


if($_GET["acte"] =="redirect") {
    $docEntete = new DocEnteteClass(0, $objet->db);
    header('Location: ../' . $docEntete->redirectToListe($_GET["typeFacture"]));
}
if($_GET["acte"] =="listeArticle"){
    $article = new ArticleClass(0,$objet->db);
    if($_GET["type"]=="Vente" ||$_GET["type"]=="BonLivraison")
        $rows = $article->getAllArticleDispoByArRef($depot);
    else
        $rows = $article->all();
    echo "<ul>";
    if($rows==null){
    }else{
        foreach($rows as $row){
            echo "<li><span='ref'>".$row->AR_Ref."</span>";
            echo "<span ref='design'>".$row->AR_Ref." - ".$row->AR_Design."</span></li>";
        }
    }
    echo "</ul>";
}


if(strcmp($_GET["acte"],"ligneAnal") == 0){
    $cbMarq = $_GET["cbMarq"];
    $N_Analytique = $_GET["N_Analytique"];
    afficheLigne($cbMarq,$N_Analytique);
}

function afficheLigne($cbMarq,$N_Analytique){
    $objet = new ObjetCollector();
    $result =  $objet->db->requete($objet->getSaisieAnalLigneA($cbMarq,$N_Analytique));
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if($rows !=null){
        foreach ($rows as $row){
            echo "<tr id='emodeler_anal_".$row->cbMarq."'>
                    <td id='tabCA_Num'>".$row->CA_Num." - ".$row->CA_Intitule."</td>
                    <td id='tabA_Qte'>".ROUND($row->EA_Quantite,2)."</td>
                    <td id='tabA_Montant'>".ROUND($row->EA_Montant,2)."</td>
                    <td id='data' style='visibility:hidden' ><span style='visibility:hidden' id='tabcbMarq'>".$row->cbMarq."</span></td>
                    <td id='tabCA_NumVal' style='visibility:hidden' >".$row->CA_Num."</td>
                    <td id='modif_anal_'><i class='fa fa-pencil fa-fw'></i></td><td id='suppr_anal_'><i class='fa fa-trash-o'></i></td>
                </tr>";
        }
    }
}

if(strcmp($_GET["acte"],"ajout_ligneA") == 0){
    $cbMarq = $_GET["cbMarq"];
    $N_Analytique= $_GET["N_Analytique"];
    $CA_Num = $_GET["CA_Num"];
    $EA_Montant = $_GET["EA_Montant"];
    $EA_Quantite= $_GET["EA_Quantite"];
    if($_GET["EA_Quantite"]=="")
        $EA_Quantite=0;
    $result = $objet->db->requete($objet->insertFLigneA($cbMarq,$N_Analytique,$CA_Num,$EA_Montant,$EA_Quantite));
    afficheLigne($cbMarq,$N_Analytique);
}


if(strcmp($_GET["acte"],"suppr_ligneA") == 0){
    $cbMarq = $_GET["cbMarq"];
    $result = $objet->db->requete($objet->supprLigneA($cbMarq));
    $data = array('TA_Code' => 0);
    echo json_encode($data);
}
if(strcmp($_GET["acte"],"modif_ligneA") == 0){
    $cbMarq = $_GET["cbMarq"];
    $cbMarqLigne = $_GET["cbMarqLigne"];
    $N_Analytique= $_GET["N_Analytique"];
    $CA_Num = $_GET["CA_Num"];
    $EA_Montant = $_GET["EA_Montant"];
    $EA_Quantite= $_GET["EA_Quantite"];
    $result = $objet->db->requete($objet-> modifLigneA($cbMarq,$cbMarqLigne,$N_Analytique,$CA_Num,$EA_Montant,$EA_Quantite));
    $result = $objet->db->requete($objet->getLastFCompteA());
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    foreach( $rows as $row){
        afficheLigne($cbMarqLigne,$N_Analytique);
    }
}


if(strcmp($_GET["acte"],"modif_ligneAL") == 0){
    $cbMarq = $_GET["cbMarq"];
    $N_Analytique= $_GET["N_Analytique"];
    $CA_Num = $_GET["CA_Num"];
    $EA_Montant = $_GET["EA_Montant"];
    $EA_Quantite= $_GET["EA_Quantite"];
    $result = $objet->db->requete($objet-> modifLigneAL($cbMarq,$N_Analytique,$CA_Num,$EA_Montant,$EA_Quantite));

}


?>
