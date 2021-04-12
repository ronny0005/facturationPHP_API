<?php
    $depot = 0;
    $protected= 0;
    $TA_Code = "";
    $TA_Intitule = "";
    $TA_Taux = "";
    $TA_TTaux = "";
    $TA_Type = "";
    $CG_Num = "";
    $TA_NP= 0;
    $TA_Sens= 0;
    $TA_No= 0;
    $TA_Provenance= 0;
    $TA_Regroup = "";
    $TA_Assujet= 100;
    $TA_GrilleBase= 0;
    $TA_GrilleTaxe= 0;
    $objet = new ObjetCollector();   
    $result=$objet->db->requete($objet->connexionProctection($_SESSION["login"], $_SESSION["mdp"]));     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if($rows!=null){
        if($rows[0]->PROT_DEPOT==1) $protected = $rows[0]->PROT_DEPOT;
    }
    if(isset($_GET["TA_Code"])){
        $objet = new ObjetCollector();   
        $result=$objet->db->requete($objet->getTaxeByTACode($_GET["TA_Code"]));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $classe="";
        if($rows==null){
        }else{
            $TA_Code = $rows[0]->TA_Code;
            $TA_Intitule = $rows[0]->TA_Intitule;
            $TA_Taux = ROUND($rows[0]->TA_Taux,2);
            $TA_TTaux = $rows[0]->TA_TTaux;
            $TA_Type = $rows[0]->TA_Type;
            $CG_Num = $rows[0]->CG_Num;
            $TA_No = $rows[0]->TA_No;
            $TA_NP= $rows[0]->TA_NP;
            $TA_Sens= $rows[0]->TA_Sens;
            $TA_Provenance= $rows[0]->TA_Provenance;
            $TA_Regroup = $rows[0]->TA_Regroup;
            $TA_Assujet= ROUND($rows[0]->TA_Assujet,0);
            $TA_GrilleBase= $rows[0]->TA_GrilleBase;
            $TA_GrilleTaxe= $rows[0]->TA_GrilleTaxe;
        }
       
    }
?>
<script src="js/Structure/Comptabilite/script_creationTaxe.js?d=<?php echo time(); ?>"></script>
</head>
<body>    
<?php
include("module/Menu/BarreMenu.php");
?>
<div id="milieu">    
    <div class="container">
    
<div class="container clearfix">
    <h4 id="logo" style="text-align: center;background-color:#eee;padding: 10px;text-transform: uppercase">
        <?php echo $texteMenu; ?>
    </h4>
</div>
    </head>  
        <div><h1>Fiche taxe</h1></div>
<form id="formTaxe" class="formTaxe" action="indexMVC.php?module=9&action=6" method="GET">
        <div class="form-group col-lg-4" >
            <label> Code taxe : </label>
                <input maxlength="5" style="text-transform: uppercase" value="<?php echo $TA_Code; ?>" type="text" name="TA_Code" onkeyup="this.value=this.value.replace(' ','')" class="form-control only_alpha_num" id="TA_Code" placeholder="Code taxe" <?php if($protected==1 || isset($_GET["TA_Code"])) echo "disabled"; ?>/>
        </div>
        <div class="form-group col-lg-4" >
            <label> Intitulé : </label>
                <input maxlength="35" value="<?php echo $TA_Intitule; ?>" type="text" name="TA_Intitule" class="form-control" id="TA_Intitule" placeholder="Intitulé" <?php if($protected==1) echo "disabled"; ?> />
        </div>
        <div class="form-group col-lg-4 ui-widget" >
            <label> Compte taxe : </label>
            <select class="form-control" id="CG_Num" name="CG_Num" <?php if($protected==1) echo "disabled"; ?>>
                <option value="" <?php if($CG_Num=="") echo " selected "; ?> ></option>
                <?php
                    $result=$objet->db->requete($objet->getCompteg());     
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    if($rows==null){
                    }else{
                        foreach($rows as $row){
                            echo "<option value=".$row->CG_Num."";
                            if($row->CG_Num == $CG_Num) echo " selected";
                            echo ">".$row->CG_Num." - ".$row->CG_Intitule."</option>";
                        }
                    }
                    ?>
            </select>
        </div>
        <div class="form-group col-lg-2" >
            <label></label>
        <select class="form-control" id="TA_TTaux" name="TA_TTaux" <?php if($protected==1) echo "disabled"; ?>>
                <?php
                    $result=$objet->db->requete($objet->getTypeValeurTaxe());     
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    if($rows==null){
                    }else{
                        foreach($rows as $row){
                            echo "<option value=".$row->ID."";
                            if($row->ID == $TA_TTaux) echo " selected";
                            echo ">".$row->Libelle."</option>";
                        }
                    }
                    ?>
        </select>
        <input value="<?php echo $TA_Taux; ?>" type="text" name="TA_Taux" class="form-control only_float" id="TA_Taux" placeholder="" <?php if($protected==1) echo "disabled"; ?> />
        </div>
        <div class="form-group col-lg-2" >
            <label> Type de taxe </label>
            <select class="form-control" id="TA_Type" name="TA_Type" <?php if($protected==1) echo "disabled"; ?>>
                <?php
                    $result=$objet->db->requete($objet->getTypeTaxe());     
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    if($rows==null){
                    }else{
                        foreach($rows as $row){
                            echo "<option value=".$row->ID."";
                            if($row->ID == $TA_Type) echo " selected";
                            echo ">".$row->Libelle."</option>";
                        }
                    }
                    ?>
            </select>
        </div>
        <div class="form-group col-lg-2" >
            <label> Sens </label>
            <select class="form-control" id="TA_Sens" name="TA_Sens" <?php if($protected==1) echo "disabled"; ?>>
                <?php
                    $result=$objet->db->requete($objet->getSensTaxe());     
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    if($rows==null){
                    }else{
                        foreach($rows as $row){
                            echo "<option value=".$row->ID."";
                            if($row->ID == $TA_Sens) echo " selected";
                            echo ">".$row->Libelle."</option>";
                        }
                    }
                    ?>
            </select>
        </div>
        <div class="form-group col-lg-2" >
            <label> Provenance : </label>
            <select class="form-control" id="TA_Provenance" name="TA_Provenance" <?php if($protected==1) echo "disabled"; ?>>
                <option value="0" <?php if($TA_Provenance==0) echo " selected "; ?> ></option>
                <?php
                    $result=$objet->db->requete($objet->getProvenanceTaxe());     
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    if($rows==null){
                    }else{
                        foreach($rows as $row){
                            echo "<option value=".$row->ID."";
                            if($row->ID == $TA_Provenance) echo " selected ";
                            echo ">".$row->Libelle."</option>";
                        }
                    }
                    ?>
            </select>
        </div>
        <div class="form-group col-lg-2" >
            <label> Code regroupement : </label>
            <input class="form-control" type="text" class="" name="TA_Regroup" id="TA_Regroup" value="<?php echo $TA_Regroup; ?>" <?php if($protected==1) echo "disabled"; ?>/>
        </div>
        <div class="form-group col-lg-2" >
            <label> Assujettissement % : </label>
            <input class="form-control" type="text" class="only_float" name="TA_Assujet" id="TA_Assujet" value="<?php echo $TA_Assujet; ?>" <?php if($protected==1) echo "disabled"; ?>/>
        </div>
        <div class="form-group col-lg-2" >
            <label> Taxe non perçue : </label>
            <input type="checkbox" class="" name="TA_NP" id="TA_NP" <?php if($TA_NP==1) echo " checked "; ?> <?php if($protected==1) echo "disabled"; ?>/>
        </div>
        <div class="form-group col-lg-2" >
            <label> Compte généraux rattachés : </label>
            <select class="form-control" id="CompteRattache" name="CompteRattache[]" multiple="">
                <?php
                    $result=$objet->db->requete($objet->getCompteRattacheTaxe($TA_No));     
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    if($rows==null){
                    }else{
                        foreach($rows as $row){
                            echo "<option value=".$row->CG_Num."";
                            echo ">".$row->CG_Num." - ".$row->CG_Intitule."</option>";
                        }
                    }
                    ?>
            </select>
            Intitulé :
            <select class="form-control" id="compteRat" name="compteRat">
                <option value="" ></option>
                <?php
                    $result=$objet->db->requete($objet->getCompteg());     
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    if($rows==null){
                    }else{
                        foreach($rows as $row){
                            echo "<option value='".$row->CG_Num."'";
                            echo ">".$row->CG_Num." - ".$row->CG_Intitule."</option>";
                        }
                    }
                    ?>
            </select>
        </div>
    <div style="clear:both"></div>
        <div class="form-group col-lg-2" >
            <input type="button" id="Ajouter" name="Ajouter" class="btn btn-primary" value="Valider" <?php if($protected==1) echo "disabled"; ?>/>
        </div>        

</form>
