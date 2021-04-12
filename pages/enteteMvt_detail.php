<fieldset class="entete">
<legend class="entete">Entete</legend>
                <div class="err" id="add_err"></div>
		<form id="form-entete" class="form-horizontal" action="indexMVC.php?module=4&action=5" method="GET" >
                    <input type="hidden" value="4" name="module"/>
                    <input type="hidden" value="5" name="action"/>
                    <input type="hidden" value="ajout_entete" name="acte"/>
                <input type="hidden" id="flagDelai" value="<?= $protection->getDelai() ?>"/>
                <input type="hidden" value="<?= $_SESSION["id"] ?>" name="id"/>
                <input type="hidden" id="flagPxRevient" value="<?= $flagPxRevient; ?>"/>
                <input type="hidden" id="isModif" value="<?= $isModif; ?>"/>
                <input type="hidden" id="isVisu" value="<?= $isVisu; ?>"/>
    <div class="form-group">
       <label style="float:left;width:100px" for="inputfirstname" class="control-label"> R&eacute;f&eacute;rence : </label>
       <div style="float:left;width:200px" class="">
           <input type="text" class="form-control" name="reference" id="ref" placeholder="Référence" value="<?php echo $reference; ?>" <?php if($reference!="") echo "disabled"?> /></div>
        <label for="inputfirstname" style="float:left;width:100px" class="control-label">N Doc : </label>
        <div style="float:left;width:200px"><input type="text" class="form-control" id="n_doc" placeholder="N Document" value="<?php echo $entete; ?>" disabled/></div>   
    </div>
    <div class="form-group">
        <label for="inputdateofbirth" style="float:left;width:100px" class="control-label">Dépot : </label>
        <div style="float:left;width:200px">
            <select class="form-control" name="depot" id="depot">
                    <?php
                    $depotClass= new DepotClass(0);
                    if($admin==0){
                        $isPrincipal = 1;
                        $rows=$depotClass->getDepotUser($_SESSION["id"]);
                    }
                    else
                        $rows = $depotClass->alldepotShortDetail();
                        foreach($rows as $row){
                            echo "<option value='{$row->DE_No}'";
                            if($row->DE_No==$depot_no) echo " selected";
                            echo ">{$row->DE_Intitule}</option>";
                    }
                    ?>
                </select>
        </div>
        <?php 
        if($type=="Transfert" || $type=="Transfert_detail"){
        ?>    
        <label for="inputdateofbirth" style="float:left;width:100px" class="control-label">Destination : </label>
            <div class="">
                <select class="form-control" name="collaborateur" style="float:left;width:200px" id="collaborateur">
                    <?php
                    if($admin==0){
                        $isPrincipal = 1;
                        $rows=$depotClass->getDepotUser($_SESSION["id"]);
                    }
                    else
                        $rows = $depotClass->alldepotShortDetail();
                    $depot="";
                    $cmp=0;
                        foreach($rows as $row){
                            echo "<option value='{$row->DE_No}'";
                            if($cmp==0 && $row->DE_No!=$depot_no && $type!="Transfert_detail"){ echo " selected";
                            $cmp=$cmp+1;}
                            if(isset($_GET["entete"]) && $depot_dest == $row->DE_No)
                                echo "selected";
                            echo ">{$row->DE_Intitule}</option>";
                    }
                    ?>
                </select>
            </div>	
        <?php
        }
        ?>
    </div>
    <div class="form-group">
        <label for="inputfirstname" style="float:left;width:100px" class="control-label">Affaire : </label>
        <div style="float:left;width:200px"><input type="text" class="form-control" id="affaire" name="affaire" placeholder="Affaire" value="<?php echo $affaire;?>" disabled/></div>
        <label for="inputfirstname" style="float:left;width:100px" class="control-label">Date : </label>
        <div style="float:left;width:200px"><input type="text" class="form-control" id="dateentete" name="dateentete" placeholder="Date" value="<?php echo $dateEntete;?>" <?php if(isset($_GET["visu"])) echo "disabled"; ?>/></div>
   </div>
    <input type="hidden" name="EntetecbMarq" id="EntetecbMarq" value="<?php echo $cbMarq; ?>" />
</form>
</fieldset>