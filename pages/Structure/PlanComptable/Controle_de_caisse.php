<?php
    $depot = 0;
    $protected= 0;
    $objet = new ObjetCollector();
    $protection = new ProtectionClass("","",$objet->db);
    if(isset($_SESSION["login"]))
        $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"],$objet->db);
    if($protection->Prot_No!=""){
//        if($rows[0]->PROT_DEPOT==1)
  //          $protected = $rows[0]->PROT_DEPOT;
    }
    
?>
<script src="js/Structure/Comptabilite/script_controleDeCaisse.js"></script>

<section class="enteteMenu bg-light p-2 mb-3">
    <h3 class="text-center text-uppercase">Controle de caisse</h3>
</section>

<form id="formCtrleCaisse" class="formCtrleCaisse" action="indexMVC.php?module=9&action=15" method="GET">

        <div class="row" >
            <div class="col-6 col-lg-2" >
                <label>Date</label>
                <input type="text" id="dateControle" class="form-control" name="dateControle"/>
            </div>
            <div class="col-6 col-lg-2" >
                <label>Caisse</label>
                <select  class="form-control" id="caisseControle" name="caisseControle">
                    <option value="0"></option>
                    <?php

                        $caisseClass = new CaisseClass(0,$this->db);

                        if($admin==0){
                            $isPrincipal = 1;
                            $rows = $caisseClass->getCaisseDepot($_SESSION["id"]);
                        }else{
                            $rows = $caisseClass->listeCaisseShort();
                        }
                        if($rows==null){
                        }else{
                            foreach($rows as $row){
                                echo "<option value='{$row->CA_No}'";
                                echo ">{$row->CA_Intitule}</option>";
                            }
                        }
                    ?>
                </select>
                <input type="hidden" id="dateControle" name="dateControle"/>
            </div>
        </div>
    <div class="row">
        <div class="col-6 col-lg-2" style="text-align: center">
            <label>Total caisse</label>
        </div>
        <div class="col-6 col-lg-2" id="totalConstate" style="text-align: center">
            <label>Total constaté</label>
        </div>
        <div class="col-6 col-lg-2" id="totalEcart" style="text-align: center">
            <label>Total écart</label>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2 col-12" >
            <input type="hidden" id="saisiejourn" name="saisiejourn" value="<?php echo $saisiejourn; ?>" />
            <input type="button" id="Ajouter" name="Ajouter" class="w-100 btn btn-primary" value="Valider" <?php if($protected==1) echo "disabled"; ?>/>
        </div>
    </div>
</form>
