<?php
    $depot = 0;
    $intitule = "";
    $adresse = "";
    $complement = "";
    $codePostal = "";
    $ville= "";
    $contact= "";
    $principal= "";
    $caisse= "";
    $region= "";
    $pays= "";
    $email= "";
    $tel= "";
    $telecopie= "";
    $protected = 0;
    $flagNouveau = 0;
    $flagProtected = 0;
    $flagSuppr = 0;
    $soucheachat=-1;
    $souchevente=-1;
    $soucheinterne=-1;
    $codedepot = "";
    $affaire = "";
    $objet = new ObjetCollector();
    $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
    $flagProtected = $protection->protectedType("depot");
    $flagSuppr = $protection->SupprType("depot");
    $flagNouveau = $protection->NouveauType("depot");

if(isset($_GET["DE_No"])){
    $depotItem = new DepotClass($_GET["DE_No"]);
    $objet = new ObjetCollector();
        $result=$objet->db->requete($objet->getDepotByDE_No($_GET["DE_No"]));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $classe="";
        if($rows==null){
        }else{
            $depot = $rows[0]->DE_No;
            $intitule = $rows[0]->DE_Intitule;
            $adresse = $rows[0]->DE_Adresse;
            $complement = $rows[0]->DE_Complement;
            $codePostal = $rows[0]->DE_CodePostal;
            $ville= $rows[0]->DE_Ville;
            $contact= $rows[0]->DE_Contact;
            $principal= $rows[0]->DE_Principal;
            $caisse= $rows[0]->CA_No;
            $region= $rows[0]->DE_Region;
            $pays= $rows[0]->DE_Pays;
            $email= $rows[0]->DE_EMail;
            $tel= $rows[0]->DE_Telephone;
            $telecopie= $rows[0]->DE_Telecopie;
            $affaire= $rows[0]->CA_Num;
            $soucheachat= $rows[0]->CA_SoucheAchat;
            $souchevente= $rows[0]->CA_SoucheVente;
            $soucheinterne= $rows[0]->CA_SoucheStock;
            $codedepot = $rows[0]->DE_Complement;
            $affaire = $rows[0]->CA_Num;
        }
       
    }
?>
<script src="js/script_creationDepot.js?d=<?php echo time(); ?>"></script>

<section class="enteteMenu bg-light p-2 mb-3">
    <h3 class="text-center text-uppercase">Fiche Depot</h3>
</section>
<form id="formDepot" class="formDepot" action="indexMVC.php?module=3&action=10" method="GET">
<fieldset class="entete card">
<legend class="entete">Informations</legend>
    <div class="row">
        <div class="col-6" >
            <label> Intitul&eacute; : </label>
                <input maxlength="35" value="<?php echo $intitule; ?>" type="text" name="intitule" class="form-control" id="intitule" placeholder="Intitulé" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-6" >
            <label> Adresse : </label>
                <input maxlength="17" value="<?php echo $adresse; ?>" type="text" onkeyup="this.value=this.value.replace(' ','')" name="adresse" class="form-control" id="adresse" placeholder="Adresse" <?php if(!$flagProtected) echo "disabled"; ?> />
        </div>
        <div class="col-6" >
            <label> Complément : </label>
            <input name="complement" type="text" class="form-control" id="complement" placeholder="Complément" value="<?php echo $complement; ?>" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-6 col-lg-2" >
            <label> Code postal : </label>
            <input type="text" name="cp" class="form-control" name="cp" placeholder="C.P." id="cp" value="<?php echo $codePostal; ?>" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-6 col-lg-2" >
            <label> Région : </label>
            <input name="region"  type="text" class="form-control" id="region" placeholder="Région" value="<?php echo $region; ?>"  <?php if(!$flagProtected) echo "disabled"; ?> />
        </div>
        <div class="col-6 col-lg-2" >
            <label> Pays : </label>
            <input value="<?php echo $pays; ?>" name="pays" type="text" class="form-control" id="tel" placeholder="Pays" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-6 col-lg-3" >
            <label> Ville : </label>
            <input type="text" class="form-control" name="ville" id="cat_compta" placeholder="Ville" value="<?php echo $ville; ?>" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-6 col-lg-3" >
            <label> Caisse : </label>
        <select class="form-control" id="caisse" name="caisse" <?php if(!$flagProtected) echo "disabled"; ?>>
        <option value="0" <?php if(0==$caisse) echo " selected"; ?>></option>
                <?php
                    $result=$objet->db->requete($objet->caisse());     
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    if($rows==null){
                    }else{
                        foreach($rows as $row){
                            echo "<option value=".$row->CA_No."";
                            if($row->CA_No == $caisse) echo " selected";
                            echo ">".$row->CA_Intitule."</option>";
                        }
                    }
                    ?>
            </select>
        </div>
        <div class="col-6 col-lg-3" >
            <label> Code depot : </label>
            <input value="<?php echo $codedepot; ?>" name="code_depot" type="text" class="form-control" id="code_depot" placeholder="Code dépôt" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-6 col-lg-3" >
            <label> Téléphone : </label>
            <input name="tel" type="text" value="<?php echo $tel; ?>" class="form-control" id="tel" placeholder="Tel." <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>        
        <div class="col-6 col-lg-3" >
            <label> Affaire : </label>
            <select class="form-control" id="affaire" name="affaire" <?php if(!$flagProtected) echo "disabled"; ?>>
                <option value="0" <?php if($affaire=="") echo "selected"; ?>></option>
                <?php
                    $result=$objet->db->requete($objet->getAffaire());     
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    if($rows==null){
                    }else{
                        foreach($rows as $row){
                            echo "<option value=".$row->CA_Num."";
                            if($row->CA_Num==$affaire) echo " selected";
                            echo ">".$row->CA_Intitule."</option>";
                        }
                    }
                    ?>
            </select>
        </div>
        <div class="col-6 col-lg-3" >
            <label>Cat tarif :</label>
            <select class="form-control" id="CA_CatTarif" name="CA_CatTarif" <?php if(!$flagProtected) echo "disabled"; ?>>
                <option value="0"></option>
                <?php
                $cattarif = new CatTarifClass(0);
                $rows = $cattarif->allCatTarif();
                foreach($rows as $row){
                    ?>
                    <option value="<?= $row->cbIndice ?>"
                        <?php if(isset($_GET["DE_No"]) && $row->cbIndice == $depotItem ->CA_CatTarif) echo " selected "; ?>>
                        <?= $row->CT_Intitule ?>
                    </option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>
</fieldset>
<fieldset class="card entete">
<legend class="entete">Souche</legend>
    <div class="row">
<div class="col-4" >
    <label> Souche vente : </label>
    <select class="form-control" id="souche_vente" name="souche_vente" <?php if(!$flagProtected) echo "disabled"; ?>>
        <option value="0" <?php if(-1==$souchevente) echo " selected"; ?>></option>
                        <?php
                    $result=$objet->db->requete($objet->getSoucheVente());     
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    if($rows==null){
                    }else{
                        foreach($rows as $row){
                            echo "<option value=".$row->cbIndice."";
                            if($row->cbIndice==$souchevente) echo " selected";
                            echo ">".$row->S_Intitule."</option>";
                        }
                    }
                    ?>
            </select>
</div>        

<div class="col-4" >
    <label> Souche achat: </label>
    <select class="form-control" id="souche_achat" name="souche_achat" <?php if(!$flagProtected) echo "disabled"; ?>>
        <option value="0" <?php if(-1==$soucheachat) echo " selected"; ?>></option>
        <?php
            $result=$objet->db->requete($objet->getSoucheAchat());     
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if($rows==null){
            }else{
                foreach($rows as $row){
                    echo "<option value=".$row->cbIndice."";
                    if($row->cbIndice==$soucheachat) echo " selected";
                    echo ">".$row->S_Intitule."</option>";
                }
            }
            ?>
    </select>
</div>        

<div class="col-4" >
    <label> Souche interne : </label>
<select class="form-control" id="souche_interne" name="souche_interne" <?php if(!$flagProtected) echo "disabled"; ?>>
    <option value="0" <?php if(-1==$soucheinterne) echo " selected"; ?>></option>
        <?php
        $result=$objet->db->requete($objet->getSoucheInterne());     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if($rows==null){
        }else{
            foreach($rows as $row){
                echo "<option value=".$row->cbIndice."";
                if($row->cbIndice==$soucheinterne) echo " selected";
                echo ">".$row->S_Intitule."</option>";
            }
        }
        ?>
</select>
</div>
    </div>
</fieldset>
<fieldset class="card entete">
<legend class="entete">Code client</legend>
<select class="form-control" id="code_client" name="code_client[]" <?php if(!$flagProtected) echo "disabled"; ?> multiple>
        <?php
        $result=$objet->db->requete($objet->getDepotClient($depot,0));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if($rows==null){
        }else{
            foreach($rows as $row){
                echo "<option value=".$row->CodeClient."";
                if($row->Valide_Depot==1) echo " selected";
                echo ">".$row->CodeClient." - ".$row->Libelle_ville."</option>";
            }
        }
        ?>
</select>
</fieldset>
<div class="col-12 col-lg-2" >
    <input type="button" id="ajouterDepot" name="ajouterDepot" class="w-100 btn btn-primary" value="Valider" <?php if(!$flagProtected) echo "disabled"; ?>/>
</div>        

</form>
