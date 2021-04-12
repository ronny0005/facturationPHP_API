<?php
$compl = "";
if($type=="Transfert_detail")
    $compl = "(Dépôt source)";
?>
<fieldset class="card p-3">
    <legend class="entete">Pied</legend>
    <div id="piedPage" class="form-group">
    </div>
</fieldset>
<form action="indexMVC.php?action=1&module=4" method="GET" name="form-valider" id="form-valider">
<div class="row mt-3">
    <input type="hidden" value="4" name="module"/>
    <input type="hidden" value="1" name="action"/>
        <input type="hidden" name="entete" id="valide_entete" value="0"/>
        <input type="hidden" name="client" id="valide_client" value="0"/>
        <input type="hidden" name="uid" id="uid" value="<?php echo $_SESSION["id"];?>"/>
        <input type="hidden" name="montant_avance" id="montant_avance" value="0"/>
        <input type="hidden" name="montant_total" id="montant_total" value="<?php if($flagPxRevient==0) echo $totalttc; ?>"/>
        <input type="hidden" id="imprime_val" name="imprime_val" value="0"/>
    <div class="<?= ($type!="Transfert_confirmation" && $type!="Transfert_valid_confirmation") ? "col-4" : "col-6" ?>">
        <button type="button" class="btn btn-primary w-100" id="annuler" <?php if($isVisu==1 || !isset($_GET["cbMarq"])) echo "disabled"; ?> >Annuler</button>
    </div>
    <div class="<?= ($type!="Transfert_confirmation" && $type!="Transfert_valid_confirmation") ? "col-4" : "col-6" ?>">
        <button type="button" class="btn btn-primary w-100" id="valider" <?php if($type!="Transfert_valid_confirmation" && ($isVisu==1 || !isset($_GET["cbMarq"]))) echo "disabled"; ?>>Valider</button>
    </div>
    <?php
    if($type!="Transfert_confirmation" && $type!="Transfert_valid_confirmation"){
    ?>
    <div class="col-4">
        <input type="button"  class="btn btn-primary w-100" value="Imprimer" id="imprimer" <?php if($isVisu==1 || !isset($_GET["cbMarq"])) echo "disabled"; ?>/>
    </div>
    <?php
    }
    ?>
</div>
</form>

<div id="dialog-confirm" title="Suppression" style="display:none">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>Voulez vous supprimez cette ligne ?</p>
</div>

<?php
echo "<div id='formArticleFactureBis' style='display: none;'>";

echo "</div>";
?>
