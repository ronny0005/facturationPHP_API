<?php
    $co_no = 0;
    $nom = "";
    $prenom = "";
    $fonction = "";
    $service = "";
    $adresse = "";
    $complement = "";
    $codePostal = "";
    $ville= "";
    $region= "";
    $pays= "";
    $email= "";
    $tel= "";
    $telecopie= "";
    $btnVendeur= "";
    $btnCaissier= "";
    $btnAcheteur = "";
    $btnControleur = "";
    $btnRecouv = "";
    $protected = 0;
    $flagNouveau = 0;
    $flagProtected = 0;
    $flagSuppr = 0;
    $objet = new ObjetCollector();
    $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
    $flagProtected = $protection->protectedType("collaborateur");
    $flagSuppr = $protection->SupprType("collaborateur");
    $flagNouveau = $protection->NouveauType("collaborateur");

    if(isset($_GET["CO_No"])){
        $objet = new ObjetCollector();   
        $result=$objet->db->requete($objet->getCollaborateurByCOno($_GET["CO_No"]));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $classe="";
        if($rows==null){
        }else{
            $co_no = $rows[0]->CO_No;
            $nom = $rows[0]->CO_Nom;
            $prenom = $rows[0]->CO_Prenom;
            $fonction = $rows[0]->CO_Fonction;
            $service = $rows[0]->CO_Service;
            $adresse = $rows[0]->CO_Adresse;
            $complement = $rows[0]->CO_Complement;
            $codePostal = $rows[0]->CO_CodePostal;
            $ville= $rows[0]->CO_Ville;
            $region= $rows[0]->CO_CodeRegion;
            $pays= $rows[0]->CO_Pays;
            $email= $rows[0]->CO_EMail;
            $tel= $rows[0]->CO_Telephone;
            $telecopie= $rows[0]->CO_Telecopie;
            $btnVendeur= $rows[0]->CO_Vendeur;
            $btnCaissier= $rows[0]->CO_Caissier;
            $btnAcheteur = $rows[0]->CO_Acheteur;
            $btnControleur = $rows[0]->CO_Receptionnaire;
            $btnRecouv = $rows[0]->CO_ChargeRecouvr;
        }
       
    }
?>
<script src="js/script_creationCollaborateur.js"></script>
    <section class="enteteMenu bg-light p-2 mb-3">
        <h3 class="text-center text-uppercase">
            Fiche collaborateur
        </h3>
    </section>
    </head>  
        <form action="indexMVC.php?module=3&action=13" method="GET" name="formCollab" id="formCollab">
        <div class="row">
        <div class="col-6" >
            <label>Nom</label>
            <input type="hidden" name="CO_No" id="CO_No" value="<?php echo $co_no; ?>" />
                <input type="text" class="form-control" value="<?php echo $nom; ?>" name="nom" id="nom" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-6">
            <label>Prénom</label>
                <input type="text" class="form-control" value="<?php echo $prenom; ?>" name="prenom" id="prenom" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-6">
            <label>Fonction</label>
            <input type="text"  class="form-control" value="<?php echo $fonction; ?>" name="fonction" id="fonction" <?php if(!$flagProtected) echo "disabled"; ?>/>
            
        </div>
        <div class="col-6">
            <label>Service</label>
                <input type="text" class="form-control" value="<?php echo $service; ?>" name="service" id="service" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        
        <div class="col-6">
            <label>Adresse</label>
            <input type="text"  class="form-control" value="<?php echo $adresse; ?>" name="adresse" id="adresse" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-6">    <label>Compl.</label>
            <input type="text" class="form-control" value="<?php echo $complement; ?>" name="complement" id="complement" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-6 col-md-3">
            <label>C.P.</label>
                <input type="text"  class="form-control" value="<?php echo $codePostal; ?>" name="codePostal" id="codePostal" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-6 col-md-3">
            <label>Ville</label>
            <input type="text" class="form-control" value="<?php echo $ville; ?>" name="ville" id="ville" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
            
        <div class="col-6 col-md-3">
            <label>Région</label>
            <input type="text"  class="form-control" value="<?php echo $region; ?>" name="region" id="region" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
            
        <div class="col-6 col-md-3">
            <label>Pays</label>
            <input type="text" class="form-control" value="<?php echo $pays; ?>" name="pays" id="pays" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-6 col-md-3">
            <label>Email</label>
            <input type="text"  class="form-control" value="<?php echo $email; ?>" name="email" id="email" <?php if(!$flagProtected) echo "disabled"; ?>/>
            
        </div>
        <div class="col-6 col-md-3">
            <label>Teléphone</label>
            <input type="text" class="form-control" value="<?php echo $tel; ?>" name="telephone" id="telephone" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-6 col-md-3">
            <label>Télécopie</label>
            <input type="text"  class="form-control" value="<?php echo $telecopie; ?>" name="telecopie" id="telecopie" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-6 col-md-3">
            <div class="col-2">
                Vendeur
                <input type="checkbox" style="margin: auto" class="checkbox" <?php if($btnVendeur==1) echo " checked "; ?> name="vendeur" id="vendeur" <?php if(!$flagProtected) echo "disabled"; ?>/>
            </div>
            <div class="col-2">
                Caissier
                <input type="checkbox" style="margin: auto" class="checkbox" <?php if($btnCaissier==1) echo " checked "; ?> name="caissier" id="caissier" <?php if(!$flagProtected) echo "disabled"; ?>/>
            </div>
            <div class="col-2">
                Acheteur
                <input type="checkbox" style="margin: auto" class="checkbox" <?php if($btnAcheteur==1) echo " checked "; ?> name="acheteur" id="acheteur" <?php if(!$flagProtected) echo "disabled"; ?>/>
            </div>
            <div class="col-2">
                Controleur
                <input type="checkbox" style="margin: auto" class="checkbox" <?php if($btnControleur==1) echo " checked "; ?> name="controleur" id="controleur" <?php if(!$flagProtected) echo "disabled"; ?>/>
            </div>
            <div class="col-2">
                Chrg. Recouvr.
                <input type="checkbox" style="margin: auto" class="checkbox" <?php if($btnRecouv==1) echo " checked "; ?> name="recouvrement" id="recouvrement" <?php if(!$flagProtected) echo "disabled"; ?>/>
            </div>
        </div>
            <div class="col-12 col-lg-2 mt-3">
                <input type="button"  class="w-100 btn btn-primary" value="Valider" name="valider" id="valider" <?php if(!$flagProtected) echo "disabled"; ?>/>
            </div>
        </div>
        </form>