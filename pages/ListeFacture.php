<?php

$datedeb=date("dmy");
$datefin=date("dmy");
if(isset($_POST["datedebut"]) && $_POST["datedebut"]!="")
    $datedeb=$_POST["datedebut"];
if(isset($_POST["datefin"]) && $_POST["datefin"]!="")
    $datefin=$_POST["datefin"];


$depot=0;
$depotUserClass = new DepotUserClass(0);
$rows=$depotUserClass->getDepotUser($_SESSION["id"]);
if(sizeof($rows)>1)
    $depot = 0;
if(sizeof($rows)==1)
    $depot = $rows[0]->DE_No;

if(isset($_POST["depot"]))
    $depot=$_POST["depot"];


if(isset($_POST["type"]))
    $type=$_POST["type"];
else
    $type=$_GET["type"];

$client='0';
$clientLibelle="";
$clientLibelle="TOUT LES CLIENTS";
if(isset($_POST["CT_Num"]) && !empty($_POST["CT_Num"])) {
    $client = $_POST["CT_Num"];
    $comptet = new ComptetClass($client,"none");
    $clientLibelle = $comptet->CT_Intitule;
}

if($client==-1 || $client==0) {
    $clientLibelle="TOUT LES CLIENTS";
    if ($type == "Achat" || $type == "AchatT" || $type == "AchatC"
        || $type == "AchatRetour" || $type == "AchatRetourT" || $type == "AchatRetourC"
        || $type == "AchatPreparationCommande" || $type == "PreparationCommande") {
        $clientLibelle = "TOUT LES FOURNISSEURS";
    }
}
$admin=0;

if($protection->PROT_Administrator==1 || $protection->PROT_Right==1)
    $admin=1;

$docEntete = new DocEnteteClass(0);
$docEntete->setTypeFac($type);
$typeListe= "documentVente";
if($docEntete->DO_Domaine==4 || $docEntete->DO_Domaine == 2 || $type=="Transfert_valid_confirmation")
    $typeListe = "documentStock";
if($docEntete->DO_Domaine == 1)
    $typeListe = "documentAchat";
$protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
$protected = $protection->protectedType($type);

$protectedSuppression = $protection->SupprType($typeListe);
$protectedNouveau = $protection->NouveauType($type);
$action=0;
if(isset($_GET["action"])) $action = $_GET["action"];
if(isset($_GET["module"])) $module = $_GET["module"];
$titre="";

?>
    <script src="js/script_listeFacture.js?d=<?php echo time(); ?>"></script>
        <div class="content">
            <div class="corps">
                <fieldset class="card p-3">
                    <legend class="bg-light text-center text-uppercase p-2"><?= $protection->listeFactureNom($_GET["type"]) ?></legend>
                    <form class="row p-2" action="#" method="POST">
                        <input type="hidden" value="<?= $module; ?>" name="module"/>
                        <input type="hidden" value="<?= $action; ?>" name="action"/>
                        <input type="hidden" value="<?= $type; ?>" id="typedocument" name="typedocument"/>
                        <input type="hidden" id="flagDelai" value="<?= $protection->getDelai(); ?>"/>
                        <input type="hidden" value="<?= sizeof($_POST) ?>" name="post" id="post"/>
                        <input type="hidden" value="<?= $protection->PROT_CBCREATEUR; ?>" name="PROT_CbCreateur" id="PROT_CbCreateur"/>
                        <?php if($type!="Vente" && $type!="VenteC" && $type!="VenteRetourC"){
                            ?><input type="hidden" value="<?php echo $type; ?>" name="type"/>
                        <?php } ?>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-2">
                                <label>Début : </label>
                                <input type="text" class="form-control" maxlength="6" name="datedebut" value="<?php if(isset($_POST["datedebut"])) echo $datedeb; ?>" id="datedebut" placeholder="Date" />
                            </div>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-2">
                                <label>Fin : </label>
                                <input type="text" class="form-control" maxlength="6" name="datefin" value="<?php if(isset($_POST["datefin"])) echo $datefin; ?>" id="datefin" placeholder="Date" />
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-2">
                                <label>Dépôt : </label>
                                <select class="form-control" name="depot" id="depot">
                        <?php
                                    $rows=$depotUserClass->getDepotUser($protection->Prot_No);
                                    if(sizeof($rows)>1){
                                        echo "<option value='0'";
                                        if('0'== $depot) echo " selected ";
                                        echo">TOUT LES DEPOTS</option>";
                                    }
                                    if($rows==null){
                                    }else{
                                        foreach($rows as $row) {
                                            echo "<option value='{$row->DE_No}'";
                                            if ($row->DE_No == $depot) echo " selected";
                                            echo ">{$row->DE_Intitule}</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <?php
                            if($docEntete->DO_Domaine == 1 || $docEntete->DO_Domaine == 0 || $docEntete->DO_Domaine == 3 ){
                                ?>
                                <div class="col-12 col-sm-6 col-md-6 col-lg-2">
                                    <?php
                                    $libTiers = "Client";
                                    $libToutTiers = "TOUS LES CLIENTS";
                                    if($docEntete->DO_Domaine == 1) {
                                        $libTiers = "Fournisseur";
                                        $libToutTiers = "TOUS LES FOURNISSEURS";
                                    }
                                    ?>
                                    <label><?= $libTiers; ?> : </label>
                                    <input type="hidden" class="form-control" name="CT_Num" id="CT_Num" value="<?= $client ?>"/>
                                    <input type="text" class="form-control" name="client" id="client" value="<?= $clientLibelle ?>" />
                                </div>
                            <?php }

                            if($docEntete->DO_Domaine == 0  && ($type=="Vente" || $type=="VenteC" || $type=="VenteT"
                                || $type=="VenteRetour" || $type=="VenteRetourC" || $type=="VenteRetourT" )){
                                $valueT = "VenteT";
                                $value = "Vente";
                                $valueC = "VenteC";
                                if ($_GET["type"] == "VenteRetour") {
                                    $valueT = "VenteRetourT";
                                    $value = "VenteRetour";
                                    $valueC = "VenteRetourC";
                                }
                                $selected="";
                                $selectedC="";
                                $selectedT="";
                                if($type=="VenteRetourT") {$selectedT="selected";}
                                if($type=="VenteRetour") {$selected="selected";}
                                if($type=="VenteRetourC") {$selectedC="selected";}
                                if($type=="VenteT") {$selectedT="selected";}
                                if($type=="Vente") {$selected="selected";}
                                if($type=="VenteC") {$selectedC="selected";}
                                ?>
                                <div class="col-12 col-sm-6 col-md-6 col-lg-2">
                                    <label>&nbsp;</label>
                                    <select style="" id="type" name="type" class="form-control">
                                            <option value="<?= $valueT ?>" <?= $selectedT ?>>Tous</option>
                                            <option value="<?= $value ?>" <?= $selected ?>>Facture</option>
                                            <option value="<?= $valueC ?>" <?= $selectedC ?>>Facture comptabilisée</option>
                                        </select>
                                </div>
                            <?php }
                            if($docEntete->DO_Domaine == 1 && ($type=="AchatT" || $type=="Achat" || $type=="AchatC"
                                    || $type=="AchatRetourT" || $type=="AchatRetour" || $type=="AchatRetourC" )){
                                ?>
                                <div class="col-12 col-sm-6 col-md-6 col-lg-2">
                                    <label>&nbsp;</label>
                                    <select id="type" name="type" class="form-control">
                                        <?php
                                        $valueT = "AchatT";
                                        $value = "Achat";
                                        $valueC = "AchatC";
                                        if($_GET["action"]==7){
                                            $valueT = "AchatRetourT";
                                            $value = "AchatRetour";
                                            $valueC = "AchatRetourC";
                                        }
                                        $selected="";
                                        $selectedC="";
                                        $selectedT="";
                                        if($type=="AchatRetourT") {$valueT = "AchatRetourT"; $selectedT="selected";}
                                        if($type=="AchatRetour") {$value = "AchatRetour";$selected="selected";}
                                        if($type=="AchatRetourC") {$valueC = "AchatRetourC";$selectedC="selected";}
                                        if($type=="AchatT") {$valueT = "Achat"; $selectedT="selected";}
                                        if($type=="Achat") {$value = "Achat";$selected="selected";}
                                        if($type=="AchatC") {$valueC = "AchatC";$selectedC="selected";}
                                        ?>
                                        <option value="<?= $valueT ?>" <?= $selectedT ?>>Tous</option>
                                        <option value="<?= $value ?>" <?= $selected ?>>Facture</option>
                                        <option value="<?= $valueC ?>" <?= $selectedC ?>>Facture comptabilisée</option>
                                    </select>
                                </div>
                            <?php }
                            ?>

                        <div class="col-12 col-sm-6 col-md-6 col-lg-2">
                            <label>N° Pièce</label>
                            <input type="text" class="form-control" name="DOPiece" id="DOPiece" />
                        </div>
                        <div class="col-6 col-lg-2 mt-3 mt-lg-4">
                                <input type="submit" id="valider" class="btn btn-primary w-100" value="Valider"/>
                        </div>
<?php
                            if($protectedNouveau && ($type!="VenteC" && $type!="VenteRetourC" && $type!="Livraison")){
                                    if($type!="Transfert_valid_confirmation"){
                                    ?>

                                    <div class="col-6 col-lg-2 mt-3 mt-lg-4">
                                        <a href="<?= $docEntete->redirectToNouveau($type) ?>" id="nouveau" class="btn btn-primary w-100">Nouveau</a>
                                    </div>
                    <?php   }
                            }

                        ?>

                </fieldset>
                </form>


                <div class="table-responsive mt-3">
                    <table id="tableListeFacture" class="table table-striped" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Numéro Pièce</th>
                            <th>Reference</th>
                            <th class="d-none"></th>
                            <th>Date</th>
                            <?php if($docEntete->DO_Domaine==0) echo"<th>Client</th>";
                            if($docEntete->DO_Domaine==0 || $type=="Entree"|| $type=="Sortie") echo "<th>Dépot</th>";
                            if($docEntete->DO_Domaine == 1) echo"<th>Fournisseur</th>
                            <th>Dépot</th>";
                            if($type=="Transfert_detail" || $type=="Transfert" || $type=="Transfert_valid_confirmation" || $type=="Transfert_confirmation") echo"<th>Dépot source</th>
                            <th>Dépot dest.</th>";
                            ?>
                            <th>Total TTC</th>
                            <?php
                            if($type=="Ticket" || ($docEntete->DO_Domaine==0 && ($docEntete->DO_Type!=0 && $docEntete->DO_Type!=1)) ||  $docEntete->DO_Domaine==1)
                                echo "<th>Montant r&eacute;gl&eacute;</th>
                            <th>Statut</th>"; ?>
                            <?php if(($type=="BonLivraison" || $type=="Devis") && ($admin==1 || ($protected))) echo "<th></th>"; ?>
                            <?php if($protectedSuppression) echo "<th></th>"; ?>
                            <th></th>
                            <?php
                            if($protection->PROT_CBCREATEUR!=2)
                                echo "<th>Créateur</th>";
                            ?>
                        </tr>
                        </thead>


                        <tbody>
                        <?php
                        $listFacture = $docEntete->listeFacture($depot,$objet->getDate($datedeb),$objet->getDate($datefin),$_SESSION["id"],$client,"");
                        if(sizeof($listFacture)==0){

                        }else{
                        foreach ($listFacture as $row){
                        $message="";
                        $avance="";
                        $total = round($row->ttc);
                        if($docEntete->type_fac=="Ticket" || $docEntete->DO_Domaine ==1 || $docEntete->DO_Domaine == 0){
                            $avance = round($row->avance);
                            if($avance==null) $avance = 0;
                            $message =$row->statut;
                        }
                        $date = new DateTime($row->DO_Date);
                        ?>
                        <tr data-toggle="tooltip" data-placement="top" title="<?= $row->PROT_User ?>"
                            class='facture' id='article_<?= $row->DO_Piece ?>'>
                            <td id='entete'><a href='<?= $docEntete->lien($row->cbMarq) ?>'><?= $row->DO_Piece ?></a></td>
                            <td id="DO_Ref"><?= $row->DO_Ref ?></td>
                            <td class="d-none"><span class="d-none" id='cbMarq'><?= $row->cbMarq ?></span>
                                <span style='display:none' id='DL_PieceBL'><?= $row->DL_PieceBL ?></span>
                                <span style='display:none' id='cbCreateur'><?= $row->PROT_User ?></span>
                            </td>
                            <td id="DO_Date"><?= $date->format('d-m-Y') ?></td>
                            <?php
                            if($docEntete->DO_Domaine==0 || $docEntete->DO_Domaine==1)
                                echo "<td>{$row->CT_Intitule}</td>";
                            if($docEntete->DO_Domaine==0 || $docEntete->DO_Domaine==1 || $docEntete->type_fac=="Entree"|| $docEntete->type_fac=="Sortie")
                                echo "<td>{$row->DE_Intitule}</td>";
                            if($docEntete->type_fac=="Transfert_detail" || $docEntete->type_fac=="Transfert" || $docEntete->type_fac=="Transfert_confirmation" || $type=="Transfert_valid_confirmation")
                                echo"<th>{$row->DE_Intitule}</th>
                                        <th>{$row->DE_Intitule_dest}</th>";
                            ?>
                            <td><?= $objet->formatChiffre($total) ?></td>
                            <?php
                            if($type=="Ticket" || ($docEntete->DO_Domaine==0 && ($docEntete->DO_Type!=0 && $docEntete->DO_Type!=1)) ||  $docEntete->DO_Domaine==1)
                            echo "<td>{$objet->formatChiffre($avance)}</td>
                                    <td id='statut'>{$message}</td>";
                            if(($type=="BonLivraison" || $type=="Devis") && ($admin==1 || ($protected))) echo '<td><input type="button" class="btn btn-primary" value="Convertir en facture" id="transform"/></td>';
                            if(($protectedSuppression)){
                                echo "<td id='supprFacture'>";
                                if($protectedSuppression) //if(($type=="Ticket" || $type=="BonLivraison" || $type=="Vente" || $type=="AchatRetour" || $type=="AchatRetourC" || $type=="AchatRetourT" || $type=="AchatT" || $type=="VenteT" || $type=="VenteC" || $type=="Achat" || $type=="AchatC" || $type=="Entree"|| $type=="Sortie"|| $type=="Transfert"|| $type=="Transfert_valid_confirmation" || $type=="Transfert_confirmation" || $type=="Transfert_detail") && $avance==0)
                                    echo "<i class='fa fa-trash-o'></i></td>";
                            }
                            echo "<td>";
                            if($type!="Transfert_valid_confirmation" && $row->DO_Imprim ==1)
                                echo "<i class='fa fa-print'></i>";
                            echo "</td>";
                            if($protection->PROT_CBCREATEUR!=2)
                                echo "<td>{$row->PROT_User}</td>";
                            echo "</tr>";
                            }
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <div style="text-align: center" id="menu_transform">
        <div class="row">
            <div class="col-4">
                <label>Type<br/></label>
                <select id="type_trans" name="type_trans" class="form-control">
                    <option value="6">Facture</option>
                    <?php
                    if($type=="Devis")
                        echo "<option value='3'>Bon de livraison</option>";
                    ?>
                </select>
            </div>
            <div class="col-4">
                <label>Choisisser une nouvelle date</label>
                <input class="form-control" type="text" id="date_transform"/>
            </div>
            <div class="col-4">
                <label>Choisisser une nouvelle référence</label>
                <input class="form-control" type="text" id="reference"/>
            </div>
        </div>
    </div>