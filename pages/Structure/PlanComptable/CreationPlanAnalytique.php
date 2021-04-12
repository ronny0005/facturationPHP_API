<?php
    $depot = 0;
    $protected= 0;
    $N_Analytique = $_GET["N_Analytique"];
    $CA_Num = "";
    $CA_Intitule = "";
    $CA_Type = 0;
    $CA_Classement = "";
    $CA_Raccourci= "";
    $CA_Report= 0;
    $N_Analyse = 1;
    $CA_Saut = 1;
    $CA_Sommeil= 0;
    $CA_Domaine = 0;
    $CA_Achat = 0;
    $CA_Vente = 0;
    $objet = new ObjetCollector();   
    $result=$objet->db->requete($objet->connexionProctection($_SESSION["login"], $_SESSION["mdp"]));     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if($rows!=null){
        if($rows[0]->PROT_DEPOT==1) $protected = $rows[0]->PROT_DEPOT;
    }
    if(isset($_GET["CA_Num"])){
        $objet = new ObjetCollector();   
        $result=$objet->db->requete($objet->getPlanAnalytiqueByCANum($_GET["CA_Num"]));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $classe="";
        if($rows==null){
        }else{
            $N_Analytique = $rows[0]->N_Analytique;
            $CA_Num = $rows[0]->CA_Num;
            $CA_Intitule = $rows[0]->CA_Intitule;
            $CA_Type = $rows[0]->CA_Type;
            $CA_Classement = $rows[0]->CA_Classement;
            $CA_Raccourci= $rows[0]->CA_Raccourci;
            $CA_Report= $rows[0]->CA_Report;
            $N_Analyse = $rows[0]->N_Analyse;
            $CA_Saut = $rows[0]->CA_Saut;
            $CA_Sommeil= $rows[0]->CA_Sommeil;
            $CA_Domaine = $rows[0]->CA_Domaine;
            $CA_Achat = $rows[0]->CA_Achat;
            $CA_Vente = $rows[0]->CA_Vente;
        }
       
    }
?>
<script src="js/Structure/Comptabilite/script_creationPlanAnalytique.js"></script>
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
        <div><h1>Fiche plan analytique</h1></div>
<form id="formPlanAnalytique" class="formPlanAnalytique" action="indexMVC.php?module=9&action=4" method="GET">
        <div class="form-group col-lg-2" >
            <label> Type : </label>
            <select class="form-control" id="CA_Type" name="CA_Type" <?php if($protected==1 || isset($_GET["CA_Num"])) echo "disabled"; ?>>
                <?php
                    $result=$objet->db->requete($objet->getTypePlanComptable());     
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    if($rows==null){
                    }else{
                        foreach($rows as $row){
                            echo "<option value=".$row->ID."";
                            if($row->ID == $CA_Type) echo " selected";
                            echo ">".$row->Libelle."</option>";
                        }
                    }
                    ?>
            </select>
        </div>
        <div class="form-group col-lg-4" >
            <label> N° section : </label>
                <input maxlength="13" value="<?php echo $CA_Num; ?>" style="text-transform: uppercase" type="text" name="CA_Num" onkeyup="this.value=this.value.replace(' ','')" class="form-control only_alpha_num" id="CA_Num" placeholder="N° section" <?php if($protected==1 || isset($_GET["CA_Num"])) echo "disabled"; ?>/>
        </div>
        <div class="form-group col-lg-4" >
            <label> Intitulé : </label>
                <input maxlength="35" value="<?php echo $CA_Intitule; ?>" type="text" name="CA_Intitule" class="form-control" id="CA_Intitule" placeholder="Intitulé" <?php if($protected==1) echo "disabled"; ?> />
        </div>
        <div class="form-group col-lg-4" >
            <label> Abrégé : </label>
            <input maxlength="17" name="CA_Classement" type="text" class="form-control" id="CA_Classement" placeholder="Abrégé" value="<?php echo $CA_Classement; ?>" <?php if($protected==1) echo "disabled"; ?>/>
        </div>
        <div class="form-group col-lg-2" >
            <label> Niveau d'analyse : </label>
        <select class="form-control" id="N_Analyse" name="N_Analyse" <?php if($protected==1) echo "disabled"; ?>>
                <?php
                    $result=$objet->db->requete($objet->getNiveauAnalyse());     
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    if($rows==null){
                    }else{
                        foreach($rows as $row){
                            echo "<option value=".$row->cbIndice."";
                            if($row->cbIndice == $N_Analyse) echo " selected";
                            echo ">".$row->A_Intitule."</option>";
                        }
                    }
                    ?>
            </select>
        </div>
        <div class="form-group col-lg-2" >
            <label> Plan analytique : </label>
            <select class="form-control" id="N_Analytique" name="N_Analytique" <?php if($protected==1) echo "disabled"; ?>>
                <?php
                    $result=$objet->db->requete($objet->getListeTypePlan());     
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    if($rows==null){
                    }else{
                        foreach($rows as $row){
                            echo "<option value=".$row->cbIndice."";
                            if($row->cbIndice == $N_Analytique) echo " selected";
                            echo ">".$row->A_Intitule."</option>";
                        }
                    }
                    ?>
            </select>
        </div>
        <div class="form-group col-lg-2" >
            <label> Report à nouveau : </label>
            <input type="checkbox" class="" name="CA_Report" id="CA_Report" <?php if($CA_Report==1) echo " checked "; ?> <?php if($protected==1) echo "disabled"; ?>/>
        </div>
        <div class="form-group col-lg-2" >
            <label> Mise en sommeil : </label>
            <input type="checkbox" class="" name="CA_Sommeil" id="CA_Sommeil" <?php if($CA_Sommeil==1) echo " checked "; ?> <?php if($protected==1) echo "disabled"; ?>/>
        </div>
    <div style="clear:both"></div>
        <div class="form-group col-lg-2" >
            <input type="button" id="Ajouter" name="Ajouter" class="btn btn-primary" value="Valider" <?php if($protected==1) echo "disabled"; ?>/>
        </div>        

</form>
