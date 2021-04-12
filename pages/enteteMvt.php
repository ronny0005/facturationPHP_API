<fieldset class="card p-3">
<legend class="entete">Entete</legend>
                <div class="err" id="add_err"></div>
		<form id="form-entete" class="form-horizontal" action="indexMVC.php?module=4&action=5" method="GET" >
                    <input type="hidden" value="4" name="module"/>
                    <input type="hidden" value="5" name="action"/>
                    <input type="hidden" value="ajout_entete" name="acte"/>
                    <input type="hidden" id="flagDelai" value="<?php echo $protection->getDelai(); ?>"/>
                    <input type="hidden" value="<?php echo $_SESSION["id"];?>" name="id"/>
                    <input type="hidden" id="flagPxRevient" value="<?php echo $flagPxRevient; ?>"/>
                    <input type="hidden" id="isModif" value="<?= $isModif; ?>"/>
                    <input type="hidden" id="isVisu" value="<?= $isVisu; ?>"/>
    <div class="row">
        <div class="col-6 col-sm-6 col-md-6">
            <label>Référence : </label>
            <input type="text" class="form-control" name="reference" id="ref" placeholder="Référence" value="<?= $docEntete->DO_Ref; ?>" <?php if($isVisu || $type=="Transfert_valid_confirmation") echo "readonly"; ?> />
        </div>
        <div class="col-6 col-sm-6 col-md-6">
            <label>N Doc : </label>
            <input type="text" class="form-control" id="n_doc" placeholder="N Document" value="<?= $docEntete->DO_Piece ?>" disabled/>
        </div>
        <div class="col-6 col-sm-6 col-md-6">
            <label>Dépot : </label>
            <input class="form-control" type="hidden" name="DE_No" id="DE_No" value="<?= ($type=="Transfert" || $type=="Transfert_detail" || $type=="Transfert_confirmation" || $type=="Transfert_valid_confirmation") ? $docEntete->DE_No : $docEntete->DO_Tiers  ?>" <?php if(isset($_GET["cbMarq"]) || $isVisu) echo "disabled"; ?> />
            <input class="form-control" type="text" name="depot" id="depot" value="<?= ($type=="Transfert" || $type=="Transfert_detail" || $type=="Transfert_confirmation" || $type=="Transfert_valid_confirmation") ? (new DepotClass($docEntete->DE_No,$objet->db))->DE_Intitule : (new DepotClass($docEntete->DO_Tiers,$objet->db))->DE_Intitule ?>" <?php if(isset($_GET["cbMarq"]) || $isVisu) echo "disabled"; ?> />
        </div>
        <?php
        if($type=="Transfert" || $type=="Transfert_detail" || $type=="Transfert_confirmation" || $type=="Transfert_valid_confirmation") {
            $depotNo = 0;
            $depotIntitule = "";
            if ($type == "Transfert" || $type == "Transfert_detail") {
                $depotNo = $docEntete->DO_Tiers;
                $depotIntitule = (new DepotClass($docEntete->DO_Tiers, $objet->db))->DE_Intitule;
            }
            if ($type == "Transfert_confirmation" || $type == "Transfert_valid_confirmation") {
                $depotNo = $docEntete->DO_Coord02;
                $depotIntitule = (new DepotClass($docEntete->DO_Coord02, $objet->db))->DE_Intitule;
            }


        ?>
        <div class="col-6 col-sm-6 col-md-6">
            <label>Destination : </label>
            <input class="form-control" type="hidden" name="CO_No" id="CO_No" value="<?= $depotNo ?>" <?php if(isset($_GET["cbMarq"]) || $isVisu) echo "disabled"; ?> />
            <input class="form-control" type="text" name="collaborateur" id="collaborateur" value="<?= $depotIntitule ?>" <?php if(isset($_GET["cbMarq"]) || $isVisu) echo "disabled"; ?> />
        </div>
        <?php
        }

        ?>
        <div class="col-6 col-sm-6 col-md-6">
            <label>Affaire : </label>
            <select class="form-control" id="affaire" name="affaire" <?php if(isset($_GET["cbMarq"]) || $isVisu) echo "disabled"; ?>>
                <?php
                    if($admin==0){
                            $result=$objet->db->requete($objet->getSoucheDepotGrpAffaire($_SESSION["id"],$type,-1,1));
                    }else{
                        $result=$objet->db->requete($objet->getAffaire());
                    }
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    if($rows==null){
                    }else{
                        foreach($rows as $row){
                            echo "<option value='{$row->CA_Num}'";
                            if($row->CA_Num==$affaire) echo " selected";
                            echo ">{$row->CA_Intitule}</option>";
                        }
                    }
                    ?>
            </select>
        </div>
        <div class="col-6 col-sm-6 col-md-6">
            <label>Date : </label>
            <?php
                $protectDate = 0;
                if($flagDateStock!=0)
                    $protectDate=1;

            ?>
            <input type="text" class="form-control" id="dateentete" name="dateentete" placeholder="Date" value="<?= $dateEntete;?>" <?php if(isset($_GET["cbMarq"]) || (!isset($_GET["cbMarq"]) && $flagDateStock==1)) echo "disabled" ?>/>
        </div>
        <input type="hidden" name="cbMarqEntete" id="cbMarqEntete" value="<?= $docEntete->cbMarq; ?>" />
   </div>

</form>
</fieldset>
