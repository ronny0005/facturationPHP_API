<?php
    $depot = 0;
    $protected= 0;
    $BQ_No = 0;
    $BQ_Intitule = "";
    $BQ_Adresse = "";
    $BQ_Complement = "";
    $BQ_CodePostal = "";
    $BQ_Ville = "";
    $BQ_CodeRegion = "";
    $BQ_Pays = "";
    $BQ_Contact = "";
    $BQ_Abrege = "";
    $BQ_ModeRemise = 0;
    $BQ_BordRemise = 0;
    $BQ_DaillyDateConv = "";
    $BQ_DaillyNatJur = "";
    $BQ_DaillyAdresse = "";
    $BQ_DaillyComplement = "";
    $BQ_DaillyCodePostal = "";
    $BQ_DaillyVille = "";
    $BQ_DaillyRCS = "";
    $BQ_BIC = "";
    $BQ_CodeIdent = "";
    $BQ_Achat = 0;
    $BQ_Remise = 0;
    $BQ_DOAdresse = 0;
    $BQ_DOVille = 0;
    $BQ_DOCodePostal = 0;
    $BQ_DOSiret = 1;
    $BQ_DOCodeIdent = 0;
    $BQ_DOAgenceVille = 0;
    $BQ_DOAgenceCP = 0;
    $BQ_DOTypeIdent = 0;
    $BQ_DOCle = 1;
    $BQ_DOTauxChange = 0;
    $BQ_VTAdresse = 0;
    $BQ_VTVille = 1;
    $BQ_VTCodePostal = 1;
    $BQ_VTSiret = 0;
    $BQ_VTPays = 0;
    $BQ_VTContrat = 0;
    $BQ_VTDateAchat = 0;
    $BQ_VTTauxChange = 0;
    $BQ_VTInstruction = 0;
    $BQ_BBIntitule = 1;
    $BQ_BBBIC = 0;
    $BQ_BBAdresse = 1;
    $BQ_BBVille = 1;
    $BQ_BBCodePostal = 1;
    $BQ_BBCompte = 0;
    $BQ_BIIntitule = 0;
    $BQ_BIBIC = 0;
    $BQ_BIAdresse = 0;
    $BQ_BIVille = 0;
    $BQ_BICodePostal = 0;
    $BQ_BIPays = 0;
    $BQ_Telephone = "";
    $BQ_Telecopie = "";
    $BQ_EMail = "";
    $BQ_Site = "";
    $objet = new ObjetCollector();   
    $result=$objet->db->requete($objet->connexionProctection($_SESSION["login"], $_SESSION["mdp"]));     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if($rows!=null){
        if($rows[0]->PROT_DEPOT==1) $protected = $rows[0]->PROT_DEPOT;
    }
    if(isset($_GET["BQ_No"])){
        $objet = new ObjetCollector();   
        $result=$objet->db->requete($objet->getBanqueByBQNo($_GET["BQ_No"]));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $classe="";
        if($rows==null){
        }else{
            $BQ_No = $rows[0]->BQ_No;
            $BQ_Intitule = $rows[0]->BQ_Intitule;
            $BQ_Adresse = ROUND($rows[0]->BQ_Adresse,2);
            $BQ_Complement = $rows[0]->BQ_Complement;
            $BQ_CodePostal = $rows[0]->BQ_CodePostal;
            $BQ_Ville = $rows[0]->BQ_Ville;
            $BQ_CodeRegion = $rows[0]->BQ_CodeRegion;
            $BQ_Pays = $rows[0]->BQ_Pays;
            $BQ_Contact = $rows[0]->BQ_Contact;
            $BQ_Abrege = $rows[0]->BQ_Abrege;
            $BQ_ModeRemise = $rows[0]->BQ_ModeRemise;
            $BQ_BordRemise = $rows[0]->BQ_BordRemise;
            $BQ_DaillyDateConv = $rows[0]->BQ_DaillyDateConv;
            $BQ_DaillyNatJur = $rows[0]->BQ_DaillyNatJur;
            $BQ_DaillyAdresse = $rows[0]->BQ_DaillyAdresse;
            $BQ_DaillyComplement = $rows[0]->BQ_DaillyComplement;
            $BQ_DaillyCodePostal = $rows[0]->BQ_DaillyCodePostal;
            $BQ_DaillyVille = $rows[0]->BQ_DaillyVille;
            $BQ_DaillyRCS = $rows[0]->BQ_DaillyRCS;
            $BQ_BIC = $rows[0]->BQ_BIC;
            $BQ_CodeIdent = $rows[0]->BQ_CodeIdent;
            $BQ_Achat = $rows[0]->BQ_Achat;
            $BQ_Remise = $rows[0]->BQ_Remise;
            $BQ_DOAdresse = $rows[0]->BQ_DOAdresse;
            $BQ_DOVille = $rows[0]->BQ_DOVille;
            $BQ_DOCodePostal = $rows[0]->BQ_DOCodePostal;
            $BQ_DOSiret = $rows[0]->BQ_DOSiret;
            $BQ_DOCodeIdent = $rows[0]->BQ_DOCodeIdent;
            $BQ_DOAgenceVille = $rows[0]->BQ_DOAgenceVille;
            $BQ_DOAgenceCP = $rows[0]->BQ_DOAgenceCP;
            $BQ_DOTypeIdent = $rows[0]->BQ_DOTypeIdent;
            $BQ_DOCle = $rows[0]->BQ_DOCle;
            $BQ_DOTauxChange = $rows[0]->BQ_DOTauxChange;
            $BQ_VTAdresse = $rows[0]->BQ_VTAdresse;
            $BQ_VTVille = $rows[0]->BQ_VTVille;
            $BQ_VTCodePostal = $rows[0]->BQ_VTCodePostal;
            $BQ_VTSiret = $rows[0]->BQ_VTSiret;
            $BQ_VTPays = $rows[0]->BQ_VTPays;
            $BQ_VTContrat = $rows[0]->BQ_VTContrat;
            $BQ_VTDateAchat = $rows[0]->BQ_VTDateAchat;
            $BQ_VTTauxChange = $rows[0]->BQ_VTTauxChange;
            $BQ_VTInstruction = $rows[0]->BQ_VTInstruction;
            $BQ_BBIntitule = $rows[0]->BQ_BBIntitule;
            $BQ_BBBIC = $rows[0]->BQ_BBBIC;
            $BQ_BBAdresse = $rows[0]->BQ_BBAdresse;
            $BQ_BBVille = $rows[0]->BQ_BBVille;
            $BQ_BBCodePostal = $rows[0]->BQ_BBCodePostal;
            $BQ_BBCompte = $rows[0]->BQ_BBCompte;
            $BQ_BIIntitule = $rows[0]->BQ_BIIntitule;
            $BQ_BIBIC = $rows[0]->BQ_BIBIC;
            $BQ_BIAdresse = $rows[0]->BQ_BIAdresse;
            $BQ_BIVille = $rows[0]->BQ_BIVille;
            $BQ_BICodePostal = $rows[0]->BQ_BICodePostal;
            
            
            
            
        }
       
    }
?>
<script src="js/Structure/Comptabilite/script_creationTaxe.js"></script>
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
        <div><h1>Fiche banque</h1></div>
<form id="formTaxe" class="formTaxe" action="indexMVC.php?module=9&action=10" method="GET">
        <div class="form-group col-lg-4" >
            <label> Abrégé : </label>
            <input maxlength="17" value="<?php echo $BQ_Abrege; ?>" type="text" name="BG_Abrege" style="text-transform: uppercase" onkeyup="this.value=this.value.replace(' ','')" class="form-control only_alpha_num" id="BG_Abrege" placeholder="Abrégé" <?php if($protected==1 || isset($_GET["TA_Code"])) echo "disabled"; ?>/>
        </div>
        <div class="form-group col-lg-4" >
            <label> Intitulé : </label>
                <input maxlength="35" value="<?php echo $BQ_Intitule; ?>" type="text" name="BQ_Intitule" class="form-control" id="TA_Intitule" placeholder="Intitulé" <?php if($protected==1) echo "disabled"; ?> />
        </div>
        <div class="form-group col-lg-4" >
            <label> Code BIC : </label>
            <input maxlength="13" value="<?php echo $BQ_BIC; ?>" type="text" name="BQ_BIC" class="form-control" id="BQ_BIC" placeholder="Code BIC" <?php if($protected==1) echo "disabled"; ?> />
        </div>
        <div class="form-group col-lg-2" >
            <label>Contact</label>
            <input maxlength="35" value="<?php echo $BQ_Contact; ?>" type="text" name="BQ_Contact" class="form-control" id="BQ_Contact" placeholder="Contact" <?php if($protected==1) echo "disabled"; ?> />
        </div>
        <div class="form-group col-lg-2" >
            <label> Adresse </label>
            <input maxlength="35" value="<?php echo $BQ_Adresse; ?>" type="text" name="BQ_Adresse" class="form-control" id="BQ_Adresse" placeholder="Adresse" <?php if($protected==1) echo "disabled"; ?> />
        </div>
        <div class="form-group col-lg-2" >
            <label> Sens </label>
            <input maxlength="35" value="<?php echo $BQ_Complement; ?>" type="text" name="BQ_Complement" class="form-control" id="BQ_Complement" placeholder="Complément" <?php if($protected==1) echo "disabled"; ?> />
        </div>
        <div class="form-group col-lg-2" >
            <label> C.P. : </label>
            <input maxlength="9" value="<?php echo $BQ_CodePostal; ?>" type="text" name="BQ_CodePostal" class="form-control only_integer" id="BQ_CodePostal" placeholder="C.P." <?php if($protected==1) echo "disabled"; ?> />
        </div>
        <div class="form-group col-lg-2" >
            <label> Ville : </label>
            <input maxlength="35" value="<?php echo $BQ_Ville; ?>" type="text" name="BQ_Ville" class="form-control" id="BQ_Ville" placeholder="Ville" <?php if($protected==1) echo "disabled"; ?> />
        </div>
        <div class="form-group col-lg-2" >
            <label> Région : </label>
            <input maxlength="25" value="<?php echo $BQ_CodeRegion; ?>" type="text" name="BQ_CodeRegion" class="form-control" id="BQ_CodeRegion" placeholder="Région" <?php if($protected==1) echo "disabled"; ?> />
        </div>
        <div class="form-group col-lg-2" >
            <label> Pays : </label>
            <input maxlength="35" value="<?php echo $BQ_Pays; ?>" type="text" name="BQ_Pays" class="form-control" id="BQ_Pays" placeholder="Pays" <?php if($protected==1) echo "disabled"; ?> />
        </div>
    <fieldset class="entete">
        <legend class="entete">Télécomunication</legend>
        <div class="form-group col-lg-2" >
            <label> Téléphone : </label>
            <input maxlength="21" value="<?php echo $BQ_Telephone; ?>" type="text" name="BQ_Telephone" class="form-control only_integer" id="BQ_Telephone" placeholder="Téléphone" <?php if($protected==1) echo "disabled"; ?> />
        </div>
        <div class="form-group col-lg-2" >
            <label> Télécopie : </label>
            <input maxlength="21" value="<?php echo $BQ_Telecopie; ?>" type="text" name="BQ_Telecopie" class="form-control only_integer" id="BQ_Telecopie" placeholder="Télécopie" <?php if($protected==1) echo "disabled"; ?> />
        </div>
        <div class="form-group col-lg-2" >
            <label> Email : </label>
            <input maxlength="69" value="<?php echo $BQ_EMail; ?>" type="text" name="BQ_EMail" class="form-control" id="BQ_EMail" placeholder="Email" <?php if($protected==1) echo "disabled"; ?> />
        </div>
        <div class="form-group col-lg-2" >
            <label> Site : </label>
            <input maxlength="69" value="<?php echo $BQ_Site; ?>" type="text" name="BQ_Site" class="form-control" id="BQ_Site" placeholder="Site" <?php if($protected==1) echo "disabled"; ?> />
        </div>
    </fieldset>
        <div style="clear:both"></div>
        <div class="form-group col-lg-2" >
            <input type="button" id="Ajouter" name="Ajouter" class="btn btn-primary" value="Valider" <?php if($protected==1) echo "disabled"; ?>/>
        </div>        

</form>
