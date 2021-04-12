<?php
    $depot = 0;
    $protected= 0;
    $JO_Num = "";
    $JO_Intitule = "";
    $CG_Num = "";
    $JO_Type = 0;
    $JO_NumPiece = 1;
    $JO_Contrepartie= 0;
    $JO_SaisAnal = 0;
    $JO_NotCalcTot = 0;
    $JO_Rappro = 0;
    $JO_Sommeil = 0;
    $JO_IFRS = 0;
    $JO_Reglement = 0;
    $JO_SuiviTreso = 0;
    $objet = new ObjetCollector();   
    $result=$objet->db->requete($objet->connexionProctection($_SESSION["login"], $_SESSION["mdp"]));     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if($rows!=null){
        if($rows[0]->PROT_DEPOT==1) $protected = $rows[0]->PROT_DEPOT;
    }
    if(isset($_GET["JO_Num"])){
        $objet = new ObjetCollector();   
        $result=$objet->db->requete($objet->getJournauxByJONum($_GET["JO_Num"]));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $classe="";
        if($rows==null){
        }else{
            $JO_Num = $rows[0]->JO_Num;
            $JO_Intitule = $rows[0]->JO_Intitule;
            $CG_Num = $rows[0]->CG_Num;
            $JO_Type = $rows[0]->JO_Type;
            $JO_NumPiece = $rows[0]->JO_NumPiece;
            $JO_Contrepartie= $rows[0]->JO_Contrepartie;
            $JO_SaisAnal = $rows[0]->JO_SaisAnal;
            $JO_NotCalcTot = $rows[0]->JO_NotCalcTot;
            $JO_Rappro = $rows[0]->JO_Rappro;
            $JO_Sommeil = $rows[0]->JO_Sommeil;
            $JO_IFRS = $rows[0]->JO_IFRS;
            $JO_Reglement = $rows[0]->JO_Reglement;
            $JO_SuiviTreso = $rows[0]->JO_SuiviTreso;
        }
       
    }
?>
<script src="js/Structure/Comptabilite/script_creationJournaux.js"></script>
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
        <div><h1>Fiche journal</h1></div>
<form id="formJournal" class="formJournal" action="indexMVC.php?module=9&action=8" method="GET">
        <div class="form-group col-lg-4" >
            <label> Code : </label>
                <input maxlength="7" value="<?php echo $JO_Num; ?>" type="text" name="JO_Num" onkeyup="this.value=this.value.replace(' ','')" class="form-control" id="JO_Num" placeholder="Code" <?php if($protected==1 || isset($_GET["JO_Num"])) echo "disabled"; ?>/>
        </div>
        <div class="form-group col-lg-4" >
            <label> Intitulé : </label>
                <input maxlength="35" value="<?php echo $JO_Intitule; ?>" type="text" name="JO_Intitule" class="form-control" id="JO_Intitule" placeholder="Intitulé" <?php if($protected==1) echo "disabled"; ?> />
        </div>
        <div class="form-group col-lg-4" >
            <label> Numérotation des pièces : </label>
            <select class="form-control" id="JO_NumPiece" name="JO_NumPiece" <?php if($protected==1) echo "disabled"; ?>>
                <?php
                    $result=$objet->db->requete($objet->getPieceJournal());     
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    if($rows==null){
                    }else{
                        foreach($rows as $row){
                            echo "<option value=".$row->ID."";
                            if($row->ID == $JO_NumPiece) echo " selected";
                            echo ">".$row->Libelle."</option>";
                        }
                    }
                    ?>
            </select>
        </div>
        <div class="form-group col-lg-2" >
            <label> Type : </label>
        <select class="form-control" id="JO_Type" name="JO_Type" <?php if($protected==1 || isset($_GET["JO_Num"])) echo "disabled"; ?>>
                <?php
                    $result=$objet->db->requete($objet->getTypeJournal());     
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    if($rows==null){
                    }else{
                        foreach($rows as $row){
                            echo "<option value=".$row->ID."";
                            if($row->ID == $JO_Type) echo " selected";
                            echo ">".$row->Libelle."</option>";
                        }
                    }
                    ?>
            </select>
        </div>
        <div class="form-group col-lg-2" >
            <label> Compte trésorerie : </label>
            <select class="form-control" id="CG_Num" name="CG_Num" <?php if($protected==1) echo "disabled"; ?>>
                <option value="" <?php if($CG_Num=="") echo " selected "; ?>></option>
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
            <label> Contrepartie à chaque ligne : </label>
            <input type="checkbox" class="" name="JO_Contrepartie" id="JO_Contrepartie" <?php if($JO_Contrepartie==1) echo " checked "; ?> <?php if($protected==1) echo "disabled"; ?>/>
        </div>
        <div class="form-group col-lg-2" >
            <label> Rapprochement : </label>
            <select class="form-control" id="JO_Rappro" name="JO_Rappro" <?php if($protected==1) echo "disabled"; ?>>
                <?php
                    $result=$objet->db->requete($objet->getRapproJournal());     
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    if($rows==null){
                    }else{
                        foreach($rows as $row){
                            echo "<option value=".$row->ID."";
                            if($row->ID == $JO_Rappro) echo " selected";
                            echo ">".$row->Libelle."</option>";
                        }
                    }
                    ?>
            </select>
        </div>
        <div class="form-group col-lg-2" >
            <label> Règlement définitif : </label>
            <input type="checkbox" class="" name="JO_Reglement" id="JO_Reglement" <?php if($JO_Reglement==1) echo " checked "; ?> <?php if($protected==1) echo "disabled"; ?>/>
        </div>
        <div class="form-group col-lg-2" >
            <label> Mis en sommeil : </label>
            <input type="checkbox" class="" name="JO_Sommeil" id="JO_Sommeil" <?php if($JO_Sommeil==1) echo " checked "; ?> <?php if($protected==1) echo "disabled"; ?>/>
        </div>
    <div style="clear:both"></div>
        <div class="form-group col-lg-2" >
            <input type="button" id="Ajouter" name="Ajouter" class="btn btn-primary" value="Valider" <?php if($protected==1) echo "disabled"; ?>/>
        </div>        

</form>
