<?php
    $depot = 0;
    $protected= 0;
    $MR_No = 0;
    $MR_Intitule = "";
    $objet = new ObjetCollector();   
    $result=$objet->db->requete($objet->connexionProctection($_SESSION["login"], $_SESSION["mdp"]));     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if($rows!=null){
        if($rows[0]->PROT_DEPOT==1) $protected = $rows[0]->PROT_DEPOT;
    }
    if(isset($_GET["MR_No"])){
        $objet = new ObjetCollector();   
        $result=$objet->db->requete($objet->getModeleReglementByMRNo($_GET["MR_No"]));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $classe="";
        if($rows==null){
        }else{
            $MR_No = $rows[0]->MR_No;
            $MR_Intitule = $rows[0]->MR_Intitule;
        }
       
    }
    
?>
<script src="js/Structure/Comptabilite/script_creationModeleReglement.js"></script>
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
        <div><h1>Modèle de règlement</h1></div>
<form id="formModeleReglement" class="formModeleReglement" action="indexMVC.php?module=9&action=12" method="GET">
        <div>
            <label> Intitulé : </label>
                <input maxlength="35" value="<?php echo $MR_Intitule; ?>" type="text" name="MR_Intitule" class="form-control" id="MR_Intitule" placeholder="Intitulé" <?php if($protected==1) echo "disabled"; ?> />
        </div>
        
        <div class="form-group" >
            <table class="table" id="table" style="width:100%">
                <thead>
                    <tr style="text-align: center;font-weight: bold">
                        <td>Valeur</td>
                        <td>Jour</td>
                        <td>Condition</td>
                        <td>Le</td>
                        <td>Mode de règlement</td>
                        <td></td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $result =  $objet->db->requete( $objet->getOptionModeleReglementByMRNo($MR_No));
                        $rows = $result->fetchAll(PDO::FETCH_OBJ);
                        if($rows !=null){
                            foreach ($rows as $row){
                                $value=ROUND($row->ER_VRepart,2);
                                if($value==0)
                                   $value="";
                                $valjour="";
                                if($row->ER_JourTb01!=0) 
                                    $valjour = $row->ER_JourTb01;
                                echo "<tr id='emodeler'>
                                        <td id='tabER_TRepart'>".$value."".$objet->getValeurTaux($row->ER_TRepart,$value)."</td>
                                        <td id='tabER_NbJour'>".$row->ER_NbJour."</td>
                                        <td id='tabER_Condition'>
                                            <span id='valER_Condition'>".$objet->getTypeConditionVal($row->ER_Condition)."</span>
                                            <span style='width:0px;visibility:hidden' id='idtabER_Condition'>".$row->ER_Condition."</span>
                                            <input style='width:0px;visibility:hidden' id='cbMarq' value='".$row->cbMarq."'/>
                                        </td>
                                        <td id='tabER_JourTb01'>".$valjour."</td>
                                        <td id='tabR_Intitule'>
                                        <span style='width:0px;visibility:hidden' id='idtabR_Intitule'>".$row->N_Reglement."</span><span id='valR_Intitule'>".$row->R_Intitule."</span></td>
                                        <td id='modif'><i class='fa fa-pencil fa-fw'></i></td>
                                        <td id='suppr'><i class='fa fa-trash-o'></i></td>
                                    </tr>";
                            }
                        }

                    ?>
                    </tbody>
                <tfoot>
                    <tr id="param">
                        <td>
                        <input value="" type="text" name="ER_VRepart" class="form-control only_modele_reglement" id="ER_VRepart"/>
                        </td>
                        <td>
                        <input value="" type="text" name="ER_NbJour" class="form-control only_integer" id="ER_NbJour"/>
                        </td>
                        <td>
                            <select name="ER_Condition" class="form-control" id="ER_Condition">
                                <?php 
                                $result =  $objet->db->requete( $objet->getTypeCondition());
                                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                                if($rows !=null){
                                    foreach ($rows as $row){
                                        echo "<option value='".$row->ID."'>".$row->Libelle."</option>";
                                    }
                                }

                                ?>
                            </select>
                        </td>
                        <td>
                        <input value="" type="text" name="ER_JourTb01" class="form-control only_integer" id="ER_JourTb01"/>
                        </td>
                        <td>
                            <select name="N_Reglement" class="form-control" id="N_Reglement">
                                <?php 
                                $result =  $objet->db->requete( $objet->listeTypeReglement());
                                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                                if($rows !=null){
                                    foreach ($rows as $row){
                                        if($row->R_Intitule!="VERS DISTANT")
                                        echo "<option value='".$row->R_Code."'>".$row->R_Intitule."</option>";
                                    }
                                }

                                ?>
                            </select>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tfoot>
                
            </table>
        </div>
        
    <div style="clear:both"></div>
        <div class="form-group col-lg-2" >
            <input type="button" id="Ajouter" name="Ajouter" class="btn btn-primary" value="Valider" <?php if($protected==1) echo "disabled"; ?>/>
        </div>        

</form>
