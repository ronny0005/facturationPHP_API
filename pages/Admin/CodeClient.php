<?php
    $id = 0;
    $username = "";
    $description = "";
    $password = "";
    $email="";
    $depot_no="";
    $caisse_no="";
    $objet = new ObjetCollector(); 
    if(isset($_GET["id"])){
        $objet = new ObjetCollector();   
        $result=$objet->db->requete($objet->UsersByid($_GET["id"]));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $classe="";
        if($rows==null){
        }else{
            $id = $rows[0]->PROT_No;
            $username = $rows[0]->PROT_User;
            $description = $rows[0]->PROT_Description;
            $depot_no=$rows[0]->DE_No;
            $caisse_no=$rows[0]->CA_No;
            $password = $objet->decrypteMdp($rows[0]->PROT_Pwd);
            $groupeid = $rows[0]->PROT_Right;
            $profiluser= $rows[0]->PROT_UserProfil;
            $email= $rows[0]->PROT_EMail;
            //ancien profil
            $resultdefautprofil=$objet->db->requete($objet->getProfilByid($profiluser));
            $rowsdefautprofil = $resultdefautprofil->fetchAll(PDO::FETCH_OBJ);
            if($rowsdefautprofil==null){
            }else{
                 $designationprofil=$rowsdefautprofil[0]->PROT_User;
            }
        }
    }
?>
<script src="js/script_codeClient.js?d=<?php echo time(); ?>"></script>
</head>
<body>    
<?php
include("module/Menu/BarreMenu.php");
?>
</head>
<div id="milieu">    
    <div class="container">
            
<div class="container clearfix">
    <h4 id="logo" style="text-align: center;background-color: #eee;padding: 10px;text-transform: uppercase">
        <?php echo $texteMenu; ?>
    </h4>
</div>
    <form id="codeClient" class="codeClient" action="indexMVC.php?module=8&action=6" method="GET">
        <input name="action" value="6" type="hidden"/>
        <input name="module" value="8" type="hidden"/>
		<input name="id" value="<?php echo "$id"; ?>" type="hidden"/>
        
        <fieldset class="entete">
        <legend class="entete">Code client</legend>
        <div id="blocCode">
        <?php
            $result=$objet->db->requete($objet->getCodeClient());     
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if($rows==null){
            }else{
                ?>
        <div>
                <?php
                foreach($rows as $row){
                    ?>
                <div class="form-group" style="clear:both">
                    <div class="form-group col-lg-3" >
                        <label> Code : </label>
                            <input maxlength="13" value="<?php echo $row->CodeClient; ?>" type="text" name="code[]" class="form-control" id="code" placeholder="Code" />
                    </div>
                    <div class="form-group col-lg-3" >
                        <label> Libellé : </label>
                            <input maxlength="50" value="<?php echo $row->Libelle_ville; ?>" type="text" name="libelle[]" class="form-control" id="libelle" placeholder="Libellé"/>
                    </div>
                    <div class="form-group col-lg-3" >
                        <label> Type : </label>
                        <select name="type[]" class="form-control" id="type">
                        <option value="0" <?php if($row->CT_Type==0) echo " selected "; ?>>Client</option>
                        <option value="1" <?php if($row->CT_Type==1) echo " selected "; ?>>Fournisseur</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-3" ><i class="fa fa-trash-o"></i></div>
                </div>
                    <?php
                }
                ?>
        </div>
            <?php
            }
        ?>
        </div>
        </fieldset>
        <div class="form-group col-lg-2" >
        <input type="button" id="nouveau" name="nouveau" class="btn btn-primary" value="Nouveau code" />
        </div>
        <div class="form-group col-lg-2" >
        <input type="button" id="valider" name="valider" class="btn btn-primary" value="Valider" />
        </div>
        
    </form>
        <?php
        
        ?>