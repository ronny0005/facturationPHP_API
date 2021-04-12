<?php
    $depot = 0;
    $CG_Num = "";
    $CG_Intitule = "";
    $CG_Classement = "";
    $nature = 0;
    $CG_Saut= 0;
    $CG_Type= 0;
    $CG_Regroup= 0;
    $CG_Analytique= 0;
    $CG_Echeance= 0;
    $CG_Quantite= 0;
    $CG_Lettrage= 0;
    $CG_Tiers= 0;
    $CG_Devise= 0;
    $N_Devise= 0;
    $TA_Code = "0";
    $CG_Sommeil= 0;
    $CG_Report= 0;
    $protected= 0;
    $objet = new ObjetCollector();
    $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"],$objet->db);
    if(isset($_GET["CG_Num"])){
        $compteg = new CompteGClass($_GET["CG_Num"],$objet->db);
        $CG_Num = $compteg->CG_Num;
        $CG_Type = $compteg->CG_Type;
        $CG_Intitule = $compteg->CG_Intitule;
        $CG_Classement = $compteg->CG_Classement;
        $nature = $compteg->N_Nature;
        $CG_Saut= $compteg->CG_Saut;
        $CG_Regroup= $compteg->CG_Regroup;
        $CG_Analytique= $compteg->CG_Analytique;
        $CG_Echeance= $compteg->CG_Echeance;
        $CG_Quantite= $compteg->CG_Quantite;
        $CG_Lettrage= $compteg->CG_Lettrage;
        $CG_Tiers= $compteg->CG_Tiers;
        $CG_Report= $compteg->CG_Report;
        $CG_Devise= $compteg->CG_Devise;
        $N_Devise= $compteg->N_Devise;
        $TA_Code = $compteg->TA_Code;
        $CG_Sommeil= $compteg->CG_Sommeil;
    }
?>
<script src="js/Structure/Comptabilite/script_creationPlanComptable.js?d=<?php echo time(); ?>"></script>

<section class="enteteMenu bg-light p-2 mb-3">
    <h3 class="text-center text-uppercase">
        Fiche Plan comptable
    </h3>
</section>

<form id="formPlanComptable" class="formPlanComptable" action="indexMVC.php?module=9&action=2" method="GET">
        <div class="row">
         <div class="col-6 col-sm-2 col-md-2 col-lg-2" >
            <label> Type : </label>
            <select class="form-control" id="CG_Type" name="CG_Type" <?php if($protected==1 || isset($_GET["CG_Num"])) echo "disabled"; ?>>
                <?php
                    $result=$objet->db->requete($objet->getTypePlanComptable());     
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    if($rows==null){
                    }else{
                        foreach($rows as $row){
                            echo "<option value='{$row->ID}'";
                            if($row->ID == $CG_Type) echo " selected";
                            echo ">{$row->Libelle}</option>";
                        }
                    }
                    ?>
            </select>
        </div>
        <div class="col-6 col-sm-2 col-md-2 col-lg-2" >
            <label> N° compte : </label>
                <input maxlength="13" value="<?php echo $CG_Num; ?>" style="text-transform: uppercase" type="text" name="CG_Num" onkeyup="this.value=this.value.replace(' ','')" class="form-control only_integer" id="CG_Num" placeholder="Numéro de compte" <?php if($protected==1 || isset($_GET["CG_Num"])) echo "disabled"; ?>/>
        </div>
        <div class="col-6 col-sm-4 col-md-4 col-lg-4" >
            <label> Intitulé : </label>
                <input maxlength="35" value="<?php echo $CG_Intitule; ?>" type="text" name="CG_Intitule" class="form-control" id="CG_Intitule" placeholder="Intitulé" <?php if($protected==1) echo "disabled"; ?> />
        </div>
        <div class="col-6 col-sm-4 col-md-4 col-lg-4" >
            <label> Abrégé : </label>
            <input maxlength="17" name="CG_Classement" type="text" class="form-control" id="CG_Classement" placeholder="Abrégé" value="<?php echo $CG_Classement; ?>" <?php if($protected==1) echo "disabled"; ?>/>
        </div>
        <div class="col-6 col-sm-3 col-md-3 col-lg-2" >
            <label> Nature du compte : </label>
        <select class="form-control" id="N_Nature" name="N_Nature" <?php if($protected==1) echo "disabled"; ?>>
                <?php
                    $result=$objet->db->requete($objet->getNatureCompte());     
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    if($rows==null){
                    }else{
                        foreach($rows as $row){
                            echo "<option value='{$row->ID}'";
                            if($row->ID == $nature) echo " selected";
                            echo ">{$row->Libelle}</option>";
                        }
                    }
                    ?>
            </select>
        </div>
        <div class="col-6 col-sm-3 col-md-3 col-lg-2" >
            <label> Report à nouveau : </label>
            <select class="form-control" id="CG_Report" name="CG_Report" <?php if($protected==1) echo "disabled"; ?>>
                <?php
                    $result=$objet->db->requete($objet->getTypeReport());     
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    if($rows==null){
                    }else{
                        foreach($rows as $row){
                            echo "<option value='{$row->ID}'";
                            if($row->ID == $CG_Report) echo " selected";
                            echo ">{$row->Libelle}</option>";
                        }
                    }
                    ?>
            </select>
        </div>
        <div class="col-6 col-sm-3 col-md-3 col-lg-2" >
            <label> Code taxe : </label>
            <select class="form-control" id="TA_Code" name="TA_Code" <?php if($protected==1) echo "disabled"; ?>>
                <option value="0" <?php if($TA_Code==0) echo " selected "; ?> ></option>
                <?php
                    $taxe = new TaxeClass(0,$objet->db);
                    foreach($taxe->all() as $row){
                        echo "<option value='{$row->TA_Code}'";
                        if($row->TA_Code == $TA_Code) echo " selected ";
                        echo ">{$row->TA_Intitule}</option>";
                    }
                    ?>
            </select>
        </div>
        <div class="col-6 col-sm-3 col-md-3 col-lg-2 text-center" >
            <label> Regroupement : </label>
            <input type="checkbox" class="form-control" name="CG_Regroup" id="CG_Regroup" <?php if($CG_Regroup==1) echo " checked "; ?> <?php if($protected==1) echo "disabled"; ?>/>
        </div>
        <div class="col-6 col-sm-3 col-md-3 col-lg-2 text-center" >
            <label> Saisie analytique : </label>
            <input type="checkbox" class="form-control" name="CG_Analytique" id="CG_Analytique" <?php if($CG_Analytique==1) echo " checked "; ?> <?php if($protected==1) echo "disabled"; ?>/>
        </div>
        <div class="col-6 col-sm-3 col-md-3 col-lg-2 text-center" >
            <label> Saisie de l'écheance : </label>
            <input type="checkbox" class="form-control" name="CG_Echeance" id="CG_Echeance" <?php if($CG_Echeance==1) echo " checked "; ?> <?php if($protected==1) echo "disabled"; ?>/>
        </div>
        <div class="col-6 col-sm-3 col-md-3 col-lg-2 text-center" >
            <label> Saisie de la quantité : </label>
            <input type="checkbox" class="form-control" name="CG_Quantite" id="CG_Quantite" <?php if($CG_Quantite==1) echo " checked "; ?> <?php if($protected==1) echo "disabled"; ?>/>
        </div>
        <div class="col-6 col-sm-3 col-md-3 col-lg-2 text-center" >
            <label> Saisie compte Tiers : </label>
            <input type="checkbox" class="form-control" name="CG_Tiers" id="CG_Tiers" <?php if($CG_Tiers==1) echo " checked "; ?> <?php if($protected==1) echo "disabled"; ?>/>
        </div>
        <div class="col-6 col-sm-3 col-md-3 col-lg-2 text-center" >
            <label> Lettrage automatique : </label>
            <input type="checkbox" class="form-control" name="CG_Lettrage" id="CG_Lettrage" <?php if($CG_Lettrage==1) echo " checked "; ?> <?php if($protected==1) echo "disabled"; ?>/>
        </div>
        <div class="col-6 col-sm-3 col-md-3 col-lg-2 text-center" >
            <label> Mise en sommeil : </label>
            <input type="checkbox" class="form-control" name="CG_Sommeil" id="CG_Sommeil" <?php if($CG_Sommeil==1) echo " checked "; ?> <?php if($protected==1) echo "disabled"; ?>/>
        </div>
        <div class="col-12 mt-3" >
            <input type="button" id="Ajouter" name="Ajouter" class="btn btn-primary" value="Valider" <?php if($protected==1) echo "disabled"; ?>/>
        </div>
        </div>

</form>
