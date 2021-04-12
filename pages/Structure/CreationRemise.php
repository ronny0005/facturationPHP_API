<?php
$protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
$flagProtected = $protection->protectedType("Remise");
$flagSuppr = $protection->SupprType("Remise");
$flagNouveau = $protection->NouveauType("Remise");
$listtarifremise = Array();
$listtarifselect = Array();
$datedeb = "";
$datefin = "";

if(isset($_GET["cbMarq"])) {
    $tarifClass = new F_TarifClass($_GET["cbMarq"]);
    $listtarifremise = Array();
    $listtarifselect = Array();
    $listtarifremise = $tarifClass->gettarifRemise();
    $listtarifselectArt = $tarifClass->gettarifSelect(1);
    $listtarifselectClt = $tarifClass->gettarifSelect(2);
    $listtarifremise  = $tarifClass->gettarifRemise();
    if(strpos($tarifClass->formatDate($tarifClass->TF_Debut),"1900")!=0)
        $datedeb = $tarifClass->formatDateSage($tarifClass->TF_Debut);
    if(strpos($tarifClass->formatDate($tarifClass->TF_Fin),"1900")!=0)
        $datefin = $tarifClass->formatDateSage($tarifClass->TF_Fin);
}

?>
<script src="js/script_creationRemise.js?d=<?php echo time(); ?>"></script>

<section class="enteteMenu bg-light p-2 mb-3">
    <h3 class="text-center text-uppercase">
        Rabais remise et ristournes
    </h3>
</section>
<form id="formEnteteRemise" class="formEnteteRemise" action="indexMVC.php?module=3&action=19" method="GET">
    <div class="row">
    <div class="col-6" >
            <label> Intitul&eacute; : </label>
                <input maxlength="35" value="<?php if(isset($tarifClass))if($tarifClass->TF_No!="") echo $tarifClass->TF_Intitule; ?>" type="text" name="TF_Intitule" class="form-control" id="TF_Intitule" placeholder="Intitulé" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-6" >
            <label> A Appliquer : </label>
            <select class="form-control" id="a_appliquer" name="a_appliquer" <?php if(!$flagProtected) echo "disabled"; ?>>
                <option value="0" <?php if(isset($tarifClass)) if($tarifClass->TF_Intitule==0) echo " selected"; ?>>En permanence</option>
                <option value="1" <?php if(isset($tarifClass)) if($tarifClass->TF_Intitule==0) echo " selected"; ?>>Le</option>
                <option value="2" <?php if(isset($tarifClass)) if($tarifClass->TF_Intitule==0) echo " selected"; ?>>Jusqu'au</option>
                <option value="3" <?php if(isset($tarifClass)) if($tarifClass->TF_Intitule==0) echo " selected"; ?>>A partir du</option>
                <option value="4" <?php if(isset($tarifClass)) if($tarifClass->TF_Intitule==0) echo " selected"; ?>>Pendant</option></select>
        </div>
    <div class="col-6 col-lg-3" >
        <label> Du : </label>
        <input maxlength="6" value="<?php if(isset($tarifClass)) if($tarifClass->TF_Intitule==0) echo $datedeb; ?>" type="text" class="form-control" id="TF_DateDeb" placeholder="" <?php if(!$flagProtected) echo "disabled"; ?> />
    </div>
    <div class="col-6 col-lg-3" >
        <label> Au : </label>
        <input maxlength="6" value="<?php if(isset($tarifClass)) if($tarifClass->TF_Intitule==0) echo $datefin; ?>" type="text" class="form-control" id="TF_DateFin" placeholder="" <?php if(!$flagProtected) echo "disabled"; ?> />
    </div>
    <div class="col-6" >
        <label> Article / Famille : </label>
        <select name="ListArticle" class="form-control" id="ListArticle" <?php if(!$flagProtected) echo "disabled"; ?> multiple>
            <?php
                foreach ($listtarifselectArt as $list){
                    $libelle ="Famille : ";
                    if($list->TS_Interes==1) $libelle="Article : ";
                    echo "<option value='".$list->TS_Interes."'>$libelle ".$list->TS_Ref."</option>";
                }
            ?>
        </select>
        <br/>
        <select name="ChoixArticle" type="textarea" class="form-control" style="float:left;width: 25%" id="ChoixArticle" <?php if(!$flagProtected) echo "disabled"; ?>>
            <option value="0">Famille</option>
            <option value="1">Article</option>
        </select>
        <select type="text" class="form-control" name="ChoixArticleSelect" style="left;width: 75%" id="ChoixArticleSelect" <?php if(!$flagProtected) echo "disabled"; ?>>
        </select>
    </div>
    <div class="col-6" >
        <label> Client / Catégorie : </label>
        <select name="ListClient" class="form-control" id="ListClient" <?php if(!$flagProtected) echo "disabled"; ?> multiple>
            <?php
            foreach ($listtarifselectClt as $list){
                $libelle ="Client : ";
                if($list->TS_Interes==2) $libelle="Catégorie : ";
                echo "<option value='".$list->TS_Interes."'>$libelle ".$list->TS_Ref."</option>";
            }
            ?>
        </select>
        <br/>
        <select name="ChoixClient" type="textarea" class="form-control" style="float:left;width: 25%" id="ChoixClient" <?php if(!$flagProtected) echo "disabled"; ?>>
            <option value="2">Catégorie</option>
            <option value="3">Client</option>
        </select>
        <select class="form-control" name="ChoixClientSelect" style="left;width: 75%" id="ChoixClientSelect" <?php if(!$flagProtected) echo "disabled"; ?>>
        </select>
    </div>
        <div class="col-6" >
            <label style="width:100%;clear:both"> Jusqu'à - remise : </label>
            <select style="width: 50%;float:left" name="ListJusquaMontant" class="form-control" id="ListJusquaMontant" <?php if(!$flagProtected) echo "disabled"; ?> multiple>
                <?php
                foreach ($listtarifremise as $list){
                    echo "<option value='".$list->cbMarq."'>".$objet->formatChiffre($list->TR_BorneSup)."</option>";
                }
                ?>
            </select>
            <select style="width: 50%;float:left" name="ListJusquaRemise" class="form-control" id="ListJusquaRemise" <?php if(!$flagProtected) echo "disabled"; ?> multiple>
                <?php
                foreach ($listtarifremise as $list){
                    echo "<option value='".$list->cbMarq."'>".$list->Remise01."</option>";
                }
                ?>
            </select>
            <br/>
            <input type="text" class="form-control" name="ChoixJusqua" style="float:left;width: 50%" id="ChoixJusqua" <?php if(!$flagProtected) echo "disabled"; ?>/>
            <input type="text" class="form-control only_remise" name="ChoixJRemise" style="width: 50%" id="ChoixJRemise" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-6" >
            <label> Objectif : </label>
            <select name="Objectif" class="form-control" id="Objectif" <?php if(!$flagProtected) echo "disabled"; ?>>
                <option value="1" <?php if(isset($tarifClass)) if($tarifClass->TF_Objectif==1) echo "selected"; ?>>Montant</option>
                <option value="0" <?php if(isset($tarifClass)) if($tarifClass->TF_Objectif==0) echo "selected"; ?>>Quantité</option>
            </select>
            <br/>
            <label> Calcul : </label>
            <select name="Calcul" class="form-control" id="Calcul" <?php if(!$flagProtected) echo "disabled"; ?>>
                <option value="1" <?php if(isset($tarifClass)) if($tarifClass->TF_Calcul==1) echo "selected"; ?>>Global</option>
                <option value="0" <?php if(isset($tarifClass)) if($tarifClass->TF_Calcul==0) echo "selected"; ?>>Tranche</option>
            </select>
            <br/>
            <label> Article remise : </label>
            <select name="ArticleRemise" class="form-control" id="ArticleRemise" <?php if(!$flagProtected) echo "disabled"; ?>>
                <?php   $articleClass = new ArticleClass(0);
                        $listArt = $articleClass->all();
                        foreach ($listArt as $article){
                            echo "<option value ='".$article->AR_Ref."'";
                            if(isset($tarifClass)) if($tarifClass->AR_Ref== $article->AR_Ref) echo "selected";
                            echo">".$article->AR_Ref." - ".$article->AR_Design."</option>";
                        }
                        ?>
            </select>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-2 col-12" >
            <input type="button" id="ajouterRemise" name="ajouterRemise" class="w-100 btn btn-primary" value="Valider" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
    </div>
</form>
