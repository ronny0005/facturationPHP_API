<?php
if($docEntete->DO_Modif==1 && $isVisu)
        echo "<div class=\"alert alert-danger\">La date limite de modification du document est dépassée !</div>";

$readonly = false ;
$styleTicket = "";
//if($type == "Ticket" && !isset($_GET["visu"]) && !isset($_GET["modif"])) {
if($type == "Ticket" && (!isset($_GET["cbMarq"]))) {
    $readonly = true;
    $styleTicket ="pointer-events: none;";
}
$protectDate = 0;
if(!($type=="Vente" || $type=="VenteC" || $type=="BonLivraison" || $type=="VenteRetour") && $flagDateVente!=0)
    $protectDate=1;
if(($type=="Achat" || $type=="AchatC" || $type=="AchatRetour" || $type=="AchatRetourC" || $type=="PreparationCommande" || $type=="AchatPreparationCommande") && $flagDateAchat!=0)
    $protectDate=1;

?>

<fieldset class="card entete">
<legend class="entete">Entete</legend>
<div class="err" id="add_err"></div>
<form id="form-entete" class="form-horizontal" action="indexMVC.php?module=2&action=3" method="GET" >
    <input type="hidden" id="flagMinMax" value="<?php if($type=="Vente" || $type=="BonLivraison") echo $flag_minMax; else echo "0"; ?>"/>
    <input type="hidden" id="flagDelai" value="<?= $protection->getDelai(); ?>"/>
    <input type="hidden" id="flagPxRevient" value="<?= $flagPxRevient; ?>"/>
    <input type="hidden" id="flagPxAchat" value="<?= $flagPxAchat; ?>"/>
    <input type="hidden" id="flagModifClient" value="<?= $flagModifClient; ?>"/>
    <input type="hidden" id="protectDate" value="<?= $protectDate; ?>"/>
    <input type="hidden" id="isModif" value="<?= $isModif; ?>"/>
    <input type="hidden" id="isVisu" value="<?= $isVisu; ?>"/>

    <?php
    if($_GET["type"]=="PreparationCommande" || $_GET["type"]=="AchatPreparationCommande"){
    ?>
    <div class="form-group">
        <div class="form-group col-lg-3">
            <label></label>
            <input class="btn btn-primary" type="button" name="majCompta" id="majCompta" value="Mise à jour comptable <?php if($docEntete->DO_Coord03==1) echo "(effectué)"; ?>" <?php if($docEntete->DO_Coord03==1) echo "disabled"; ?>/>
        </div>
        <div class="form-group col-lg-3">
            <label></label>
            <input class="btn btn-primary" type="button" name="rattacher" id="rattacher" value="Rattacher" />
        </div>
        <div class="form-group col-lg-3">
            <label>Transfert des documents de caisse</label>
            <input class="form-control" type="checkbox" name="transDoc" id="transDoc" value="" <?= ($docEntete->DO_Coord03==1 || $entete=="") ? "checked" : "" ?>/>
        </div>
    </div>
    <?php
    }
    ?>
    <div class="form-row">
        <div class="col-12 col-sm-6 col-md-4">
    <?php

    $client = new ComptetClass($docEntete->DO_Tiers);
    if($type!="Achat" && $type!="AchatC" && $type!="AchatRetour" && $type!="AchatRetourC" && $type!="PreparationCommande" && $type!="AchatPreparationCommande"){
    ?><label>Client : <span id="libelleCtNum" style="color:blue; text-decoration: underline"><?= $client->CT_Num ?></span></label>
        <input type="hidden" class="form-control" name="CT_Num" id="CT_Num" value="<?= $client->CT_Num ?>"/>
        <input type="text" class="form-control" name="client" id="client" value="<?= $client->CT_Intitule ?>"
<?php if($type=="Ticket" || (($type=="Vente" || $type=="VenteC" || $type=="VenteT") && $flagModifClient!=0) || $readonly
                || isset($_GET["cbMarq"])) echo "disabled"; ?> />
    <?php
    } else{
    ?>
    <label>Fournisseur : </label>
        <input type="hidden" class="form-control" name="CT_Num" id="CT_Num" value="<?= $client->CT_Num ?>"/>
        <input type="text" class="form-control" name="client" id="client" value="<?= $client->CT_Intitule ?>"
            <?php if($type=="Ticket" || (($type=="Vente" || $type=="VenteC" || $type=="VenteT") && $flagModifClient!=0) || $readonly
                || isset($_GET["cbMarq"])) echo "disabled"; ?> />
    <?php
    }
    ?>
    </div>
    <div class="col-6 col-sm-3 col-md-4">
        <label>Cat tarif : </label>
                <select class="form-control"
                        type="input" name="cat_tarif" id="cat_tarif" style="<?php if($protection->PROT_TARIFICATION_CLIENT!=0) echo "pointer-events:none;"; echo $styleTicket ?>"
                    <?php if($protection->PROT_TARIFICATION_CLIENT!=0 || $isVisu || $flagProtCatCompta != 0) echo "disabled"; ?>>
                    <?php
                    $cattarif = new CatTarifClass(0);
                    foreach($cattarif->allCatTarif() as $row){
                        echo "<option value='{$row->cbIndice}'";
                        if($row->cbIndice==$cat_tarif) echo " selected";
                        echo ">{$row->CT_Intitule}</option>";
                    }
                    ?>
                </select>
    </div>
    <div class="col-6 col-sm-3 col-md-4">
        <label>Cat compta :</label>
        <select type="input" name="cat_compta" id="cat_compta" class="form-control" style="<?= $styleTicket ?>" <?php if($protection->PROT_TARIFICATION_CLIENT!=0 || $flagProtCatCompta != 0 || (isset($_GET["cbMarq"]) && $isLigne==1) || $isVisu) echo "disabled"; ?>>
        <?php
        $catComptaClass = new CatComptaClass(0);
                if($type=="Achat" || $type=="AchatC" ||$type=="AchatRetour" || $type=="AchatRetourC" || $type=="PreparationCommande"|| $type=="AchatPreparationCommande")
                    $rows=$catComptaClass->getCatComptaAchat();
                else
                    $rows=$catComptaClass->getCatCompta();
                if($rows==null){
                }else{
                    foreach($rows as $row){
                        echo "<option value='{$row->idcompta}'";
                        if($row->idcompta==$docEntete->N_CatCompta) echo " selected";
                        echo ">{$row->marks}</option>";
                    }
                }
                ?>
        </select>
    </div>
        <div class="col-6 col-xs-6 col-sm-4 col-md-4">
            <label>Souche : </label>
            <select class="form-control" id="souche" name="souche" style="<?= $styleTicket ?>" <?php if(isset($_GET["cbMarq"]) || $isVisu) echo "disabled"; ?>>
                <?php
                    if($admin==1 && $type!="VenteRetour" && $type!="BonLivraison"&& $type!="Devis")
                    echo "<option value=''></option>";
                $isPrincipal = 0;
                    if($admin==0){

                        $isPrincipal = 1;
                        $rows = $protection->getSoucheDepotGrpSouche($_SESSION["id"],$type);
                    }else{
                        if($type=="Achat" || $type=="AchatC" || $type=="AchatRetour" || $type=="AchatRetourC" || $type=="PreparationCommande" || $type=="AchatPreparationCommande" )
                            $rows = $protection->getSoucheAchat();
                        else {
                            $rows = $protection->getSoucheVente();
                        }
                    }
                    if($rows==null){
                    }else{
                        foreach($rows as $row){
                            if ($isPrincipal == 0) {
                                echo "<option value='{$row->cbIndice}'";
                                if($row->cbIndice==$docEntete->DO_Souche) echo " selected";
                                echo ">{$row->S_Intitule}</option>";
                            } else {
                                if ($row->IsPrincipal == 1) {
                                    echo "<option value='{$row->cbIndice}'";
                                    if($row->cbIndice==$docEntete->DO_Souche) echo " selected";
                                    echo ">{$row->S_Intitule}</option>";
                                }
                            }
                        }
                    }

                    ?>
            </select>
        </div>
        <div class="col-6 col-xs-6 col-sm-4 col-md-4">
            <label>Affaire : </label>
            <select class="form-control" id="affaire" name="affaire" style="<?= $styleTicket ?>" <?php if($isVisu || $readonly || (isset($_GET["cbMarq"]))) echo "disabled"; ?>>
                <php
                        if($admin!=0){
                    echo "<option value=''></option>";
                }
                ?>
                <?php
                    if($admin==0){
                        $isPrincipal = 1;
                            $rows = $protection->getSoucheDepotGrpAffaire($_SESSION["id"],$type,0);
                    }else{
                        $rows = $protection->getAffaire(0);
                    }
                        if($rows==null){
                        }else{
                            foreach($rows as $row)
                            if ($isPrincipal == 0) {
                                echo "<option value='{$row->CA_Num}'";
                                if($row->CA_Num==$docEntete->CA_Num) echo " selected ";
                                echo ">{$row->CA_Intitule}</option>";
                            } else {
                                if ($row->IsPrincipal == 1) {
                                    echo "<option value='{$row->CA_Num}'";
                                    if($row->CA_Num==$docEntete->CA_Num) echo " selected ";
                                    echo ">{$row->CA_Intitule}</option>";
                                }
                            }
                        }

                    ?>
            </select>
        </div>
        <div class="col-6 col-xs-6 col-sm-4 col-md-4">
            <label>Date : </label>
            <input type="text" class="form-control" id="dateentete" name="dateentete" style="<?= $styleTicket ?>" placeholder="Date" value="<?php if($docEntete->DO_Date!="")echo $docEntete->DO_DateSage;?>" <?php if(isset($_GET["cbMarq"]) || (!isset($_GET["cbMarq"]) && $protectDate!=0))echo "disabled"; else if($readonly) echo "readonly"; ?> />
        </div>
        <div class="col-6 col-xs-6 col-sm-4 col-md-4">
        <label>Depot : </label>
            <select class="form-control" name="depot" id="depot" style="<?= $styleTicket ?>" <?php
                                    if($isVisu || $readonly || (isset($_GET["cbMarq"]))) echo "disabled"; ?>>
                    <?php
                    $isPrincipal = 0;
                    $depotClass = new DepotClass(0);
                    if($admin==0){
                        $isPrincipal = 1;
                        $rows = $depotClass->getDepotUser($_SESSION["id"]);
                    }
                    else
                        $rows = $depotClass->alldepotShortDetail();
                    $depot="";
                    foreach($rows as $row) {
                        if ($isPrincipal == 0) {
                            echo "<option value='{$row->DE_No}'";
                            if ($row->DE_No == $docEntete->DE_No) echo " selected";
                            echo ">{$row->DE_Intitule}</option>";
                        } else {
                            if ($row->IsPrincipal == 1) {
                                echo "<option value='{$row->DE_No}'";
                                if ($row->DE_No == $docEntete->DE_No) echo " selected";
                                echo ">{$row->DE_Intitule}</option>";
                            }
                        }
                    }
                    ?>
                </select>
        </div>
        <div class="col-6 col-xs-6 col-sm-4 col-md-4">
            <label>Collaborateur : </label>
            <select class="form-control" name="collaborateur" id="collaborateur" style="<?= $styleTicket ?>" <?php if($readonly || $isVisu) echo "disabled"; ?>>
                <option value="0"></option>
                <?php
                $collaborateur = new CollaborateurClass(0,$objet->db);
                if($_GET["type"]=="Achat" || $type=="AchatC" || $_GET["type"]=="AchatRetour" || $type=="AchatRetourC" || $_GET["type"]=="PreparationCommande" || $type=="AchatPreparationCommande" ){
                    $rows =  $collaborateur->allAcheteur();
                }else{
                    $rows =  $collaborateur->allVendeur();
                }

                foreach($rows as $row){
                    echo "<option value='{$row->CO_No}'";
                    if($row->CO_No==$docEntete->CO_No) echo " selected";
                    echo ">{$row->CO_Nom}</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-6 col-xs-6 col-sm-4 col-md-4">
            <label>Caisse : </label>
            <select class="form-control" name="caisse" id="caisse" style="<?= $styleTicket ?>" <?php if($readonly || isset($_GET["cbMarq"]) || $isVisu) echo "disabled"; ?>>
                    <?php
                    $isPrincipal = 0;
                    $caisseClass= new CaisseClass(0);
                    if($admin==0){
                        $isPrincipal = 1;
                        $rows=$caisseClass->getCaisseDepot($_SESSION["id"]);
                    }else{
                        echo "<option value=''";
                        if($docEntete->CA_No=="") echo " selected ";
                        echo "></option>";
                        $rows=$caisseClass->all();
                    }
                    foreach($rows as $row){
                        if ($isPrincipal == 0) {
                            echo "<option value='{$row->CA_No}'";
                            if($type=="Achat" || $type=="AchatC" || $type=="AchatRetour" || $type=="AchatRetourC" || $type=="PreparationCommande" || $type=="AchatPreparationCommande" ){
                                if(isset($_GET["entete"]) && $row->CA_No==$docEntete->CA_No) echo " selected";
                            }else{
                                if($row->CA_No==$docEntete->CA_No) echo " selected";
                            }
                            echo ">{$row->CA_Intitule}</option>";
                        } else {
                            if ($row->IsPrincipal == 1 || $row->IsPrincipal == 2) {
                                echo "<option value='{$row->CA_No}'";
                                if($type=="Achat" || $type=="AchatC" || $type=="AchatRetour" || $type=="AchatRetourC" || $type=="PreparationCommande" || $type=="AchatPreparationCommande" ){
                                    if(isset($_GET["entete"]) && $row->CA_No==$docEntete->CA_No) echo " selected";
                                }else{
                                    if($row->CA_No==$docEntete->CA_No) echo " selected";
                                }
                                echo ">{$row->CA_Intitule}</option>";
                            }
                        }
                    }

                    ?>
            </select>
        </div>
        <div class="col-6 col-xs-12 col-sm-4 col-md-4">
            <label> R&eacute;f&eacute;rence : </label>
            <input maxlength="17" type="text" class="form-control" name="reference" id="ref" placeholder="Référence" value="<?= $docEntete->DO_Ref; ?>"  <?php if($isVisu) echo "readonly"; ?>/>
        </div>
        <div class="col-6 col-xs-6 col-sm-4 col-md-4">
            <label>N Doc : </label>
            <input type="text" class="form-control" id="n_doc" placeholder="N Document" value="<?= $docEntete->DO_Piece; ?>" disabled/>
            <input type="hidden" id="prot_no" class="prot_no" value="<?= $_SESSION["id"] ?>"/>
            <input type="hidden" id="modifClient" class="modifClient" value="<?= $flagModifClient ?>"/>
        </div>
        <div class="col-6 col-xs-6 col-sm-4 col-md-4">
            <label>Statut : </label>
                <select class="form-control" name="do_statut" id="do_statut" style="<?= $styleTicket ?>" <?php if($readonly || $isVisu) echo "disabled"; ?>>
                    <?php
                    if( $docEntete->DO_Domaine==0 ) {
                        $typeparam = $type;
                        $rows = $docEntete->getStatutVente($typeparam);
                    }
                    else {
                        $typeach = $type;
                        if($type=="AchatPreparationCommande") $typeach ="PreparationCommande";
                        if($type=="AchatRetour") $typeach ="Retour";

                        $rows = $docEntete->getStatutAchat($typeach);
                    }
                    if($rows==null){
                    }else{
                        foreach($rows as $row){
                            echo "<option value='{$row->Val}'";
                            if($row->Val==$docEntete->DO_Statut) echo  " selected ";
                            echo ">{$row->Lib}</option>";
                        }
                    }
                    ?>
            </select>
        </div>
    </div>

    <input type="hidden" name="EntetecbMarq" id="EntetecbMarq" value="<?= $docEntete->cbMarq ?>" />
    <?php
    if($type=="Vente" || $type=="VenteC") {
        ?>
        <div id="nomClientDivers" style="display: none;">
            <label>Nom client :</label>
        <input type="text" class="form-control" name="nomClient" id="nomClient" value="<?= $docEntete->DO_Coord04; ?>"/>
        </div>
<?php
    }?>
</form>
</fieldset>



