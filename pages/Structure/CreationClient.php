<?php

    $intitule = "";
    $adresse = "";
$ctEncours = 0;
$CT_ControlEnc = 0;
    $compteg = "";
    $codePostal = "";
    $depot = 0;
    $co_no = 0;
    $region= "";
    $ville="";
    $nsiret="";
    $identifiant="";
    $tel="";
    $mode_reglement="";
$catcompta="";
$affaire="";
    $cattarif="";
    $MR_No=0;
    $protected = 0;
    $flagNouveau = 0;
    $flagProtected = 0;
    $flagSuppr = 0;
    $objet = new ObjetCollector();

$comptet = new ComptetClass(0);


$type = "client";
if($_GET["action"]==9) $type="fournisseur";
if($_GET["action"]==17) $type="salarie";
$ncompte = $comptet->getCodeAuto($type);
        $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
        if($type=="client"){
            $flagProtected = $protection->protectedType($type);
            $flagSuppr = $protection->SupprType($type);
            $flagNouveau = $protection->NouveauType($type);
        }
        if($type=="fournisseur" || $type=="salarie"){
            $flagProtected = $protection->protectedType($type);
            $flagSuppr = $protection->SupprType($type);
            $flagNouveau = $protection->NouveauType($type);
        }
$ctSommeil=0;
    if(isset($_GET["CT_Num"])){
        $objet = new ObjetCollector();
        $clientClass = new ComptetClass($_GET["CT_Num"]);
        $ncompte = $clientClass->CT_Num;
        $intitule = $clientClass->CT_Intitule;
        $adresse = $clientClass->CT_Adresse;
        $CT_ControlEnc = $clientClass->CT_ControlEnc;
        $ctEncours = $clientClass->CT_Encours;
        $compteg = $clientClass->CG_NumPrinc;
        $codePostal = $clientClass->CT_CodePostal;
        $depot = $clientClass->DE_No;
        $co_no = $clientClass->CO_No;
        $region= $clientClass->CT_CodeRegion;
        $ville= $clientClass->CT_Ville;
        $nsiret= $clientClass->CT_Siret;
        $identifiant= $clientClass->CT_Identifiant;
        $tel= $clientClass->CT_Telephone;
        $catcompta= $clientClass->N_CatCompta;
        $cattarif= $clientClass->N_CatTarif;
        $MR_No = $clientClass->MR_No;
        $affaire = $clientClass->CA_Num;
        $ctSommeil = $clientClass->CT_Sommeil;
    }

    if(isset($_GET["ajouter"]) ||isset($_GET["modifier"]) ){
        $ncompte = $_GET["CT_Num"];
        $intitule = $_GET["CT_Intitule"];
        $adresse = $_GET["CT_Adresse"];
        $CT_ControlEnc = $_GET["CT_ControlEnc"];
        $ctEncours = $_GET["CT_Encours"];
        $compteg = $_GET["CG_NumPrinc"];
        $codePostal = $_GET["CT_CodePostal"];
        $region= $_GET["CT_CodeRegion"];
        $ville= $_GET["CT_Ville"];
        $nsiret= $_GET["CT_Siret"];
        $identifiant= $_GET["CT_Identifiant"];
        $tel= $_GET["CT_Telephone"];
        $catcompta= $_GET["N_CatCompta"];
        $cattarif= $_GET["N_CatTarif"];
        $depot= $_GET["depot"];
        $affaire = $_GET["CA_Num"];
    }
?>
<script src="js/script_creationClient.js"></script>
</head>
<body>
<fieldset class="card p-3">
    <legend class="bg-light text-center text-uppercase p-2">
            <?php if($type=="client") echo "Fiche client"; if($type=="fournisseur") echo "Fiche fournisseur"; if($type=="salarie") echo "Fiche salarié"; ?>
    </legend>

    <form id="form-creationClient" action="indexMVC.php?module=3&action=2" method="GET">
        <div>
            <div class="row mt-3" >
                <div class="col-6" >
                    <input type="hidden" id="type" name="type" type="hidden" value="<?php if($type=="fournisseur") echo "1"; if($type=="client") echo "0";if($type=="salarie") echo "2"; ?>"/>
                    <input type="hidden" id="DE_No" name="DE_No" type="hidden" value="1"/>
                    <label for="inputfirstname" class="control-label"> Num&eacute;ro compte : </label>
                    <input maxlength="17" value="<?php echo $ncompte; ?>" style=";text-transform:uppercase" type="text" onkeyup="this.value=this.value.replace(' ','')" name="CT_Num" id="CT_Num" class="form-control only_alpha_num" placeholder="Numéro compte" <?php if(isset($_GET["CT_Num"])) echo "disabled"; ?> />
                </div>
        <div class="col-6" >
            <label for="inputfirstname" class="control-label"> Intitul&eacute; : </label>
            <input maxlength="35" value="<?php echo $intitule; ?>" style="text-transform:uppercase" type="text" name="CT_Intitule" class="form-control" id="intitule" placeholder="Intitulé" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-6" >
            <label for="inputfirstname" class="control-label"> Adresse : </label>
            <input value="<?php echo $adresse; ?>" style="" name="CT_Adresse" type="text" class="form-control" id="adresse" placeholder="Adresse" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-6" >
            <label for="inputfirstname" class="control-label"> Compteg : </label>
            <?php

            $ctype=0;
            $cdefaut="C";
            if($type=="fournisseur"){
                $ctype=1;
                $cdefaut="F";
            }
            if($type=="salarie"){
                $ctype=2;
                $cdefaut="S";
            }

            $result=$objet->db->requete($objet->selectDefautCompte($cdefaut));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            $cdefaut="";
            if(sizeof($rows)>0)
                $cdefaut=$rows[0]->T_Val01T_Compte;
            ?>
            <input type="hidden" value="<?= $cdefaut ?>" name="cdefaut" id="cdefaut" />
            <select style="" name="CG_NumPrinc" class="form-control" id="CG_NumPrinc<?php if(!$flagProtected) echo "protected"?>" <?php if(!$flagProtected) echo "disabled"; ?>>
                <?php
                $result=$objet->db->requete($objet->getCompteg());
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                $cg_val =$cdefaut;
                if($rows==null){
                }else{
                    foreach($rows as $row){
                        echo "<option value='{$row->CG_Num}'";
                        if((!isset($_GET["CT_Num"]) && $row->CG_Num == $cg_val)|| $compteg==$row->CG_Num) echo " selected";
                        echo ">{$row->CG_Num} - {$row->CG_Intitule}</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-6" >
            <label for="inputfirstname" class="control-label"> T&eacute;l&eacute;phone : </label>
            <input value="<?= $tel; ?>" style="" name="CT_Telephone" type="text" class="form-control only_phone_number" id="tel" placeholder="Téléphone" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-6" >
            <label for="inputfirstname" class="control-label"> R&eacute;gion : </label>
            <input value="<?= $region; ?>" style="" type="text" class="form-control" name="CT_CodeRegion" id="CT_CodeRegion" placeholder="Région" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-6" >
            <label for="inputfirstname" class="control-label"> Ville : </label>
            <input value="<?= $ville; ?>" style=""  type="text" class="form-control" name="CT_Ville" id="CT_Ville" placeholder="ville" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-6" >
            <label for="inputfirstname" class="control-label"> N Siret/NContrib : </label>
            <input value="<?= $nsiret; ?>" style="" name="CT_Siret" type="text" class="form-control" id="CT_Siret" placeholder="N° Siret" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-6" >
            <label for="inputfirstname" class="control-label"> Identifiant/RC Num :  </label>
            <input value="<?= $identifiant; ?>" style="" name="CT_Identifiant" type="text" class="form-control" id="CT_Identifiant" placeholder="Identifiant" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-6" >
            <label for="inputfirstname" class="control-label"> Cat Tarif : </label>
            <select style="" name="N_CatTarif"  class="form-control" name="N_CatTarif" id="cattarif" <?php if(!$flagProtected) echo "disabled"; ?>>
                <?php
                $result=$objet->db->requete($objet->getTarif());     
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if($rows==null){
                }else{
                    foreach($rows as $row){
                        echo "<option value=".$row->cbIndice."";
                        if($row->cbIndice==$cattarif) echo " selected";
                        echo ">".$row->CT_Intitule."</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-6" >
            <label for="inputfirstname" class="control-label"> Cat compta : </label>
            <select style="" name="N_CatCompta" class="form-control" name="N_CatCompta" id="catcompta" <?php if(!$flagProtected) echo "disabled"; ?>>
                <?php
                $catCompta = new CatComptaClass(0);
                if($type=="client")
                    $rows = $catCompta->getCatCompta();
                else
                    $rows = $catCompta->getCatComptaAchat();
                if($rows==null){
                }else{
                    foreach($rows as $row){
                        echo "<option value={$row->idcompta}";
                        if($row->idcompta==$catcompta) echo " selected";
                        echo ">{$row->marks}</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-6" >
            <label for="inputfirstname" class="control-label"> Mode de règlement : </label>
        <select style="" name="mode_reglement" class="form-control" name="mode_reglement" id="mode_reglement" <?php if(!$flagProtected) echo "disabled"; ?>>
            <option value="0"></option>
            <?php
                $creglement= new ReglementClass(0);
                $rows = $creglement->getModeleReglement();

                if($rows==null){
                }else{
                    foreach ($rows as $row){
                        echo "<option value={$row->MR_No}";
                        if($row->MR_No==$MR_No) echo " selected";
                        echo ">{$row->MR_Intitule}</option>";
                    }
                }
        ?>
        </select>
        </div>
        <div class="col-6" >
            <label for="inputfirstname" class="control-label"> Affaire : </label>
            <select style="" name="CA_Num" class="form-control" name="CA_Num" id="CA_Num" <?php if(!$flagProtected) echo "disabled"; ?>>
                <option value=""></option>
                <?php
                $protection = new ProtectionClass("","");
                $rows = $protection->getAffaire();
                if($rows==null){
                }else{
                    foreach($rows as $row){
                        if($row->CA_Num!=""){
                            echo "<option value='{$row->CA_Num}'";
                            if($row->CA_Num!="" && $row->CA_Num==$affaire) echo " selected ";
                            echo ">{$row->CA_Intitule}</option>";
                        }
                    }
                }
                ?>
            </select>
        </div>

        <div class="col-6" >
            <label for="inputfirstname" class="control-label"> Dépôt : </label>
            <select style="" name="depot" class="form-control" name="depot" id="depot" <?php if(!$flagProtected) echo "disabled"; ?>>
                <?php
                $result=$objet->db->requete($objet->depot());
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if($rows==null){
                }else{
                    foreach($rows as $row){
                        echo "<option value='{$row->DE_No}'";
                        if($row->DE_No==$depot) echo " selected";
                        echo ">{$row->DE_Intitule}</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-6" >
            <label for="inputfirstname" class="control-label"> Collaborateur : </label>
            <select style="" class="form-control" name="CO_No" id="CO_No" <?= (!$flagProtected) ? " disabled" : "" ?>>
                <option value="0" <?= ($co_no==0) ? " selected" : "" ?>></option>
                <?php
                $collab = new CollaborateurClass(0);
                $rows = $collab->allVendeur();
                if(sizeof($rows)==0){
                }else{
                    foreach($rows as $row){
                        echo "<option value='{$row->CO_No}'";
                        if($row->CO_No==$co_no) echo " selected";
                        echo ">{$row->CO_Nom}</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-6" >
            <label for="inputfirstname" class="control-label"> Sommeil: </label>
            <select style="" class="form-control" name="CT_Sommeil" id="CT_Sommeil" <?= (!$flagProtected) ? "disabled":""; ?>>
                <option value="0" <?= ($ctSommeil==0) ? " selected" : "" ?>>Non</option>
                <option value="1" <?= ($ctSommeil==1) ? " selected" : "" ?>>Oui</option>
            </select>
        </div>
        <div class="col-6" >
            <label for="inputfirstname" class="control-label"> Encours max autorisé : </label>
            <input value="<?= $ctEncours ?>" style="" name="CT_Encours" type="text" class="form-control" id="CT_Encours" placeholder="" <?= (!$flagProtected) ? "disabled" : "" ?>/>
        </div>

        <div class="col-6" >
            <label for="inputfirstname" class="control-label"> Ctrle de l'encours client : </label>
            <select style="" class="form-control" name="CT_ControlEnc" id="CT_ControlEnc" <?= (!$flagProtected) ? "disabled":""; ?>>
                <option value="0" <?= ($CT_ControlEnc==0) ? " selected" : "" ?>>Contrôle automatique</option>
                <option value="1" <?= ($CT_ControlEnc==1) ? " selected" : "" ?>>Selon code risque</option>
                <option value="2" <?= ($CT_ControlEnc==2) ? " selected" : "" ?>>Compte bloqué</option>
            </select>
        </div>

        <div class="col-12 col-lg-2 mt-3">
            <input type="button" id="ajouterClient" name="ajouterClient" class="w-100 btn btn-primary" value="Valider" <?= (!$flagProtected) ? "disabled" : ""; ?>/>
        </div>
    </form>
</fieldset>