<script src="js/scriptRecouvrement.js?d=<?php echo time(); ?>"></script>
<script src="js/scriptCombobox.js?d=<?php echo time(); ?>" type="text/javascript"></script>
<?php
$objet = new ObjetCollector();

$affaire="";
$souche="";
$co_no=0;
$depot_no=0;
$client="";
$caisse = 0;
$type=0;
$treglement=0;
$caissier = 0;
$datedeb="";
$datesaisie="";
$datefin="";
$typeRegl = "Client";
if(isset($_GET["typeRegl"]))
    $typeRegl = $_GET["typeRegl"];
$protectionClass = new ProtectionClass($_SESSION["login"],$_SESSION["mdp"]);

/*if($profil_caisse==1)
    $caisse=$_SESSION["CA_No"];*/
$souche=$_SESSION["DO_Souche"];
$depot_no=$_SESSION["DE_No"];

$co_no=$_SESSION["CO_No"];
$caissier = $_SESSION["CO_No"];
$client = -1;
$clientLibelle ="";
if (isset($_GET["CT_Num"])) {
    if($typeRegl=="Collaborateur"){
        $client = $_GET["CT_Num"];
        $comptet = new CollaborateurClass($client);
        $clientLibelle = $comptet->CO_Nom;
    }else {
        $client = $_GET["CT_Num"];
        $comptet = new ComptetClass($client, "none");
        $clientLibelle = $comptet->CT_Intitule;
    }
}
if(isset($_GET["type"])) $type=$_GET["type"];
if(isset($_GET["caisse"])) $caisse=$_GET["caisse"];
if(isset($_GET["mode_reglement"])) $treglement=$_GET["mode_reglement"];
if(isset($_GET["dateReglementEntete_deb"])) $datedeb=$_GET["dateReglementEntete_deb"];
if(isset($_GET["dateReglementEntete_fin"])) $datefin=$_GET["dateReglementEntete_fin"];
$objet = new ObjetCollector();
$protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
if ($typeRegl == "Client") {
    $flagProtected = $protection->protectedType("ReglementClient");
    $flagSuppr = $protection->SupprType("ReglementClient");
    $flagNouveau = $protection->NouveauType("ReglementClient");
}
else {
    $flagProtected = $protection->protectedType("ReglementFournisseur");
    $flagSuppr = $protection->SupprType("ReglementFournisseur");
    $flagNouveau = $protection->NouveauType("ReglementFournisseur");
}

?>

<div id="protectionPage" style="visibility: hidden;"><?php echo $flagProtected;?></div>

<div id="listInfoRglt" style="display: none">
    <div class="row">
        <div class="col"><input class="btn btn-primary" value="Remboursement règlement"/></div>
        <div class="col"><input class="btn btn-primary" value="Régler facture"/></div>
        <div class="col"><input class="btn btn-primary" value="Voir facture réglée"/></div>
    </div>
</div>

<input type="hidden" class="form-control" id="flagCtrlTtCaisse" value="<?= $flagCtrlTtCaisse/*$flagModifSupprComptoir;*/ ?>" />
<div id="protectionSupprPage" style="visibility: hidden;"><?php echo $flagSuppr;?></div>


        <section class="enteteMenu bg-light p-2 mb-3">
            <h3 class="text-center text-uppercase">Règlement <?= $titleMenu; ?></h3>
        </section>
        <?php
//        $lienForm="Reglement-$typeRegl";
        $lienForm="indexMVC.php?action=2&module=1";
        $actionForm="2";
        if($typeRegl=="Fournisseur"){
            $lienForm="indexMVC.php?action=4&module=1";
            $actionForm = "4";
        }
        if($typeRegl=="Collaborateur"){
            $lienForm="indexMVC.php?action=5&module=1";
            $actionForm = "5";
        }
        ?>
        <input type="hidden" value="" name="ValRGPiece" id="Val_RG_Piece" />
        <input type="hidden" value="<?= $_SESSION["CO_No"] ?>" name="CO_NoSession" id="CO_NoSession" />
        <?php
        if(ISSET($_GET["cloture"])){
            if($_GET["cloture"]>0)
            {
                ?>
                <div class="alert alert-danger"> La journée a été cloturée !</div>
        <?php
            }
        }
        ?>
        <fieldset  class="card p-3 mt-3">
        <form action="<?= $lienForm; ?>" method="GET">
            <legend>Entête</legend>
            <input type="hidden" value="1" name="module"/>
            <input type="hidden" value="<?= $actionForm; ?>" name="action"/>
            <input type="hidden" value="<?= $caissier; ?>" name="caissier" id="caissier" />
            <input type="hidden" value="<?= $typeRegl; ?>" name="typeRegl" id="typeRegl" />
            <div class="row">
                <div class="col-12 col-sm-12 col-md-6 col-lg-3" >
                    <label><?= $typeRegl; ?></label>
                    <input type="hidden" class="form-control" name="CT_Num" id="CT_Num" value="<?= $client ?>"/>
                    <input type="text" class="form-control" name="client" id="client" value="<?= $clientLibelle ?>"/>
                </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2" >
                <label>Début</label>
                <input  type="text"  class="form-control" id="dateReglementEntete_deb" name="dateReglementEntete_deb" placeholder="Date" value="<?= $datedeb; ?>"/>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2" >
                <label>Fin</label>
                <input  type="text" class="form-control" id="dateReglementEntete_fin" name="dateReglementEntete_fin" placeholder="Date" value="<?= $datefin; ?>"/>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2" >
                <label>Type Règlement</label>
                <select type="checkbox" id="mode_reglement" name="mode_reglement" class="form-control">
                    <?php
                    $preglementClass = new PReglementClass(0);
                    $rows = $preglementClass->all();
                    echo "<option value='0'";
                    if($treglement==0) echo " selected ";
                    echo ">TOUT REGLEMENTS</option>";
                    if($rows !=null){
                        foreach ($rows as $row){
                            echo "<option value='{$row->R_Code}' ";
                            if ($row->R_Code == $treglement) echo "selected";
                            echo ">{$row->R_Intitule}</option>";
                        }
                    }
                    ?>
                    <!--           <option value="07">REMBOURSEMENT CLIENT</option> -->
                </select>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-3" >
                <label>Journal</label>
                <select class="form-control" name="journal" id="journal">
                    <?php
                    $journalClass = new JournalClass(0);
                    $rows = $journalClass->getJournaux(1);
                    foreach($rows as $row)
                        echo "<option value='{$row->JO_Num}'>{$row->JO_Intitule}</option>";
                    ?>
                </select>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-3" >
                <?php
                $isPrincipal = 0;
                $caisseClass = new CaisseClass(0);
                if($admin==0){
                    $isPrincipal = 1;
                    $rows = $caisseClass->getCaisseDepot($_SESSION["id"]);
                }else{
                    $rows = $caisseClass->listeCaisseShort();
                }
                ?>
                <label>Caisse</label>
                <select class="form-control" name="caisse" id="caisse" <?php if(/*$profil_caisse==1 || */sizeof($rows)==1) echo "disabled"; ?>>
                    <?= ($admin==1 && sizeof($rows)>1) ? "<option value='0'>TOUTES LES CAISSES</option>" : "" ;

                    if($rows!=null){
                        foreach($rows as $row) {
                            if ($isPrincipal == 0) {
                                echo "<option value='{$row->CA_No}'";
                                if ($row->CA_No == $caisse) echo " selected";
                                echo ">{$row->CA_Intitule}</option>";
                            } else {
                                if ($row->IsPrincipal != 0) {
                                    echo "<option value='{$row->CA_No}'";
                                    if($row->IsPrincipal == 2 && $caisse==0) echo " selected";
                                    if ($row->CA_No == $caisse) echo " selected";

                                    echo ">{$row->CA_Intitule}</option>";
                                }
                            }
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="col-6 col-sm-4 col-md-3 col-lg-2" >
                <label>Type réglement</label>
                <select class="form-control" name="type" id="type">
                    <option value="-1" <?= ($type==-1) ? "selected" : "" ; ?> >Tout les règlements</option>
                    <option value="1"  <?= ($type==1) ? "selected" : "" ; ?> >Règlements imputés</option>
                    <option value="0"  <?= ($type==0) ? "selected" : "" ; ?> >Règlements non imputés</option>
                </select>
            </div>

            <div class="mt-0 col-0 col-sm-0 col-md-0 col-lg-7" >
            </div>
            <div class="mt-2 col-6 col-sm-8 col-md-10 col-lg-10" >
                <label>&nbsp;</label>
                <input type="button" id="imprimer" class="btn btn-primary" value="Imprimer"/>
            </div>
            <div class="mt-2 col-6 col-sm-4 col-md-2 col-lg-2 text-right" >
                <input type="submit" class="btn btn-primary" value="Rechercher"/>
            </div>
            </div>
        </form>
        </fieldset>
        <div style="margin-bottom: 10px;clear: both">
        </div>
        <fieldset class="card p-3 mt-3">
            <form id="formValider" action="Traitement/Recouvrement.php" method="GET" class="form-horizontal">
                <input type="hidden" value="1" name="module"/>
                <input type="hidden" value="2" name="action"/>
                <input type="hidden" value="addReglement" name="acte"/>
                <input type="hidden" value="<?= $client ?>" name="client_ligne" id="client_ligne" />
                <input type="hidden" value="<?= $protection->Prot_No ?>" name="PROT_No" id="PROT_No" />
                <input type="hidden" value="" name="dateReglementEntete_deb" id="dateReglementEntete_deb_ligne" />
                <input type="hidden" value="" name="dateReglementEntete_fin" id="dateReglementEntete_fin_ligne" />
                <input type="hidden" value="" name="mode_reglement" id="mode_reglement_ligne" />
                <input type="hidden" value="" name="journal" id="journal_ligne" />
                <input type="hidden" value="" name="caisse" id="caisse_ligne" />
                <input type="hidden" value="" name="caissier" id="caissier_ligne" />
                <input type="hidden" value="" name="JO_Num" id="journal_ligne" />
                <input type="hidden" value="" name="boncaisse" id="boncaisse_ligne" />
                <input type="hidden" value="" name="RG_NoLier" id="rgnolier_ligne" />
                <input type="hidden" value="" name="typeRegl" id="typeRegl_ligne" />
                <input type="hidden" value="" name="type" id="type_ligne" />
                <input type="hidden" id="flagDelai" value="<?= $protection->getDelai(); ?>"/>
                <input type="hidden" value="0" name="RG_Type" id="RG_Type"/>
                <input type="hidden" value="0" name="impute" id="impute"/>
                <legend class="entete">Ligne</legend>
                <?php if($flagProtected) { ?>
                    <div class="row">
                        <div class="col-12 col-sm-4 col-md-4 col-lg-2">
                            <input type="text" class="form-control" id="dateRec" name="dateRec" value="<?= $datesaisie;?>"placeholder="Date" <?= ($flagDateRglt!=0) ? "readonly" : "" ; ?>/>
                        </div>
                        <div class="col-12 col-sm-8 col-md-8 col-lg-4">
                            <input type="text" maxlength="25" class="form-control" id="libelleRec" name="libelleRec" placeholder="Libelle"/>
                        </div>
                        <div class="col-6 col-sm-6 col-md-4 col-lg-2">
                            <input type="text" class="form-control" id="montantRec" name="montantRec" placeholder="Montant"/>
                        </div>
                        <div class="col-6 col-sm-6 col-md-4 col-lg-2">
                            <select type="checkbox" id="mode_reglementRec" name="mode_reglementRec" class="form-control">
                                <?php
                                $reglementClass = new ReglementClass(0);
                                $rows = $reglementClass->listeTypeReglement();
                                if($rows !=null) {
                                    foreach ($rows as $row) {

                                        if ($row->R_Code == "01") {
                                            echo "<option value='{$row->R_Code}'>{$row->R_Intitule}</option>";
                                        } else {
                                            if ($flagRisqueClient == 0) {
                                                echo "<option value='{$row->R_Code}'>{$row->R_Intitule}</option>";
                                            }
                                        }
                                    }
                                }
                                //echo "<option value='07'>REMBOURSEMENT CLIENT</option>";
                                if($typeRegl=="Collaborateur")
                                    echo"<option value='10'>RETOUR BON DE CAISSE</option>";

                                ?>
                            </select>
                        </div>
                        <div class="col-md-1 col-lg-1 mb-2">
                            <input name="client" id="client_valide" type="hidden" value="2" name="action"/>
                            <input type="button" class="btn btn-primary" name="acte" id = "validerRec" value="Valider"/>
                        </div>
                    </div>
                <?php } ?>
            </form>
            <div class="row">
                <div class="col-lg-6 table-responsive" id="blocListeReglement" style="height: 300px">
                    <table class="table table-striped" id="tableRecouvrement">
                        <thead>
                        <tr class="text-center">
                            <th></th>
                            <?= ($flagProtected) ? "<th></th>" : "" ?>
                            <?= ($flagSuppr) ? "<th></th>" : "" ?>
                            <th>N° Piece</th>
                            <th>Date</th>
                            <th>Libelle</th>
                            <th style="min-width: 130px;">Montant</th>
                            <th style="min-width: 130px;">Montant imputé</th>
                            <th style="min-width: 130px;">Reste à imputer</th>
                            <th>Caisse</th>
                            <th>Caissier</th>
                            <?= ($protection->PROT_Right==1) ? "<th>Créateur</th>" : "" ; ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $collab= 0;
                        if($typeRegl=="Collaborateur") $collab=1;
                        $datedebval = "";
                        if($datedeb!="") $datedebval = $objet->getDate($datedeb);
                        $datefinval = "";
                        if($datefin!="") $datefinval = $objet->getDate($datefin);
                        $typeSelectRegl = 0;
                        if($typeRegl!="Client") $typeSelectRegl = 1;
                        $reglementClass = new ReglementClass(0);
                        if($profil_daf==1){
                            $rows = $reglementClass->getReglementByClient($client,0,$type,$treglement,$datedebval,$datefinval,$caissier,$collab,$protection->Prot_No,$typeSelectRegl);
                        }
                        else {
                            $rows = $reglementClass->getReglementByClient($client, $caisse, $type, $treglement, $datedebval, $datefinval, $caissier, $collab,$protection->Prot_No, $typeSelectRegl);
                        }
                        $i=0;
                        $classe="";
                        $someRC=0;
                        $someRG=0;
                        if($rows==null){
                        }else{
                            foreach ($rows as $row){
                                $someRC=$someRC+$row->RC_Montant;
                                $someRG=$someRG+$row->RG_Montant;
                                $i++;
                                if($i%2==0) $classe = "info";
                                else $classe="";
                                echo "<tr class='reglement $classe' id='reglement_{$row->RG_No}'>
                                        <td><input type='checkbox' id='checkRgNo' /></td>";
                                if($flagProtected)  echo "<td id='modifRG_Piece'><i class='fa fa-pencil fa-fw'></i></td>";
                                if($flagSuppr)  echo "<td id='supprRG_Piece'><i class='fa fa-trash-o'></i></td>";
                                echo "<td id='RG_Piece' style='color:blue;text-decoration: underline;'>{$row->RG_Piece}</td>
                                        <td id='RG_Date'>{$objet->getDateDDMMYYYY($row->RG_Date)}</td>
                                        <td id='RG_Libelle'>{$row->RG_Libelle}</td>
                                        <td class='text-right' id='RG_Montant'>{$objet->formatChiffre(round($row->RG_Montant))}</td>
                                        <td class='text-right' id='RC_Montant'>{$objet->formatChiffre(round($row->RC_Montant))}</td>
                                        <td class='text-right' id='RA_Montant'>{$objet->formatChiffre(round($row->RG_Montant-$row->RC_Montant))}</td>
                                        <td id='CA_NoTable'>{$row->CA_Intitule}</td>
                                        <td>{$row->CO_Nom}<span style='display:none' id='N_Reglement'>{$row->N_Reglement}</span></td>";
                                if($protection->PROT_Right==1)
                                    echo "<td>{$row->PROT_User}</td>";

                                echo"   <td style='display:none' id='RG_No'>{$row->RG_No}</td>
                                        <td style='display:none' id='RG_Impute'>{$row->RG_Impute}</td>
                                        <td style='display:none' id='CO_NoCaissier'>{$row->CO_NoCaissier}</td>
                                        <td style='display:none' id='JO_Num'>{$row->JO_Num}</td>
                                        <td style='display:none' id='DO_Modif'>{$row->DO_Modif}</td>
                                        </tr>";
                            }
                            $diffSomme=$someRG-$someRC;
                            echo "<tr class='reglement font-weight-bold' style='background-color:grey;color:white'>
                                        <td></td><td>Total</td><td></td><td></td><td></td><td></td>
                                        <td class='text-right' >{$objet->formatChiffre($someRG)}</td>
                                        <td class='text-right' >{$objet->formatChiffre($someRC)}</td>
                                        <td class='text-right' >{$objet->formatChiffre($diffSomme)}</td><td></td><td></td>";
                            if($protection->PROT_Right==1)
                                echo "<td></td>";
                            echo"</tr>";
                        }

                        ?>
                        </tbody>
                    </table>
                </div>
                    <div class="col-lg-6 table-responsive" id="blocFacture">
                        <form id="form_facture" name="form_facture" >
                        <div style="clear: both;height: 300px;">
                            <table class="table table-striped" id="tableFacture">
                                <thead>
                                <tr class="text-center">
                                    <th>Date</th>
                                    <th>Libelle</th>
                                    <th>Référence</th>
                                    <th style="min-width: 130px">Avance</th>
                                    <th style="min-width: 130px">TTC</th>
                                    <th style="min-width: 130px">Reste à payer</th>
                                </tr>
                                </thead>
                                <tbody id="Listefacture">
                                </tbody>
                            </table>
                        </div>
                        <div style="float :right" id="total_reste">Total reste à payer : <b>0</b></div>
                    </div>

                    <div  id="blocFactureRGNO" style="display: none;">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tableFactureRGNO">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Libelle</th>
                                    <th>Référence</th>
                                    <th>Avance</th>
                                    <th>TTC</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody id="ListefactureRGNO">
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="blocFacture_dialog" style="display: none;">
                        <div class="float-right" style="font-size: 13px;font-weight: bold" id="montant_reglement"></div>
                        <div class="table-responsive">
                            <table class="table table-striped" id="tableFacture_dialog">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Date</th>
                                    <th>Libelle</th>
                                    <th>Référence</th>
                                    <th class="mw">Avance</th>
                                    <th>TTC</th>
                                    <th>Montant réglé</th>
                                </tr>
                                </thead>
                                <tbody id="Listefacture_dialog">
                                </tbody>
                            </table>
                        </div>
                </form>
                    </div>
            </div>



            <div title="Choississez un collaborateur" id="choose_caissier" style="display: none;">
                <div class="row">
                <div class="col-12">
                    <label>Journal :</label>
                    <select class="form-control" name="journal_choix" id="journal_choix">
                        <?php
                        $journalClass = new JournalClass(0);
                        $rows = $journalClass->getJournauxReglement(1);
                        if($rows!=null){
                            foreach($rows as $row)
                                echo "<option value='{$row->JO_Num}'>{$row->JO_Intitule}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-12">
                    <label>Collaborateur :</label>
                    <select class="form-control" name="caissier_choix" id="caissier_choix">
                        <?php
                        $caisseClass = new CaisseClass(0);
                        $rows = $caisseClass->getCaissierByCaisse($caisse);
                        $depot="";
                        if($rows!=null){
                            foreach($rows as $row){
                                echo "<option value='{$row->CO_No}'";
                                echo ">{$row->CO_Nom}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                </div>
            </div>
            <div id="blocTransfert" title="CONVERSION DU TRANSFERT" style="display: none;">
                <label for="inputdateofbirth" class="col-md-1 control-label">Caisse </label>
                <div class="col-md-3">
                    <select class="form-control" name="caisseTransfert" id="caisseTransfert" <?php if($profil_caisse==1) echo "disabled"; ?>>
                        <?php
                        $caisseClass = new CaisseClass(0);
                        $rows = $caisseClass->listeCaisseShort();
                        if($rows!=null){
                            foreach($rows as $row){
                                echo "<option value='{$row->CA_No}'";
                                if($row->CA_No==$caisse) echo " selected";
                                echo ">{$row->CA_Intitule}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
        </fieldset>
    </div>
</div>
<div id="blocDateRemiseBon" style="display: none;">
    <input  type='text'  class='form-control' id='dateRemiseBon' name='dateRemiseBon' placeholder='Date' />
</div>
<div id="blocRemboursementRglt" style="display: none;">
    <div class="row">
        <div class="col-6">
            <label>Date</label>
            <input  type='text'  class='form-control' id='dateRemboursement' name='dateRemboursement' placeholder='Date' />
        </div>
        <div class="col-6">
            <label>Montant</label>
            <input  type='text'  class='form-control only_float' id='mttRemboursement' name='mttRemboursement' placeholder='Montant' />
        </div>
    </div>
</div>