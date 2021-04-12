<?php
$objet = new ObjetCollector();
$protectioncial = new ProtectionClass($_SESSION["login"],$_SESSION["mdp"],$objet->db);
$i=0;
$classe="";
$texte="";
$style="";
$color = "";
$id = $protectioncial->Prot_No;
$username = $protectioncial->PROT_User;
$password = $objet->decrypteMdp($protectioncial->PROT_Pwd);
if(isset($_POST["valide"])){
    $pwd = $_POST["mdp"];
    if ($_SESSION["mdp"] == $pwd) {
        $txtNewPassword = $_POST["txtNewPassword"];
        $txtConfirmPassword = $_POST["txtConfirmPassword"];
        if($txtNewPassword==$txtConfirmPassword) {
            $result = $objet->db->requete($objet->modifierMdp($objet->crypteMdp($txtNewPassword), $_SESSION["id"]));
            $_SESSION["mdp"] = $txtNewPassword;
            $texte = "Le mot de passe a bien été changé !";
            $color="color: green;";
        }
    }else{
        $style="border-color: red";
        $color="color: red;";
        $texte = "Le mot de passe est incorrect !";
    }
}
?>
<script src="js/jquery.dynatable.js" type="text/javascript"></script>
<script src="js/scriptCombobox.js"></script>
<script src="js/script_motDePasse.js"></script>


<section class="enteteMenu bg-light p-2 mb-3">
    <h3 class="text-center text-uppercase">Mot de passe</h3>
</section>
<form id="form-entete" class="form-horizontal" action="indexMVC.php?module=1&action=6" method="POST" >
    <div class="form-group">
        <input class="btn btn-primary" type="hidden" name="module" id="module" value="1" />
        <input class="btn btn-primary" type="hidden" name="action" id="action" value="6" />
        <div style="<?= $color ?> ;margin: 10px"><?= $texte ?></div>
        <div class="form-group col-lg-3">
            <label>Mot de passe actuel</label>
            <input class="form-control" type="password" style="<?= $style ?>" name="mdp" id="mdp" value="" />
            <label>Nouveau mot de passe</label>
            <input class="form-control" type="password" name="txtNewPassword" id="txtNewPassword" value="" />
            <label>Retaper nouveau mot de passe</label>
            <input class="form-control" type="password" name="txtConfirmPassword" id="txtConfirmPassword" value="" />
            <div class="registrationFormAlert" id="divCheckPasswordMatch" style="color: red;margin: 10px"></div>
            <input class="btn btn-primary" type="submit" name="valide" id="valide" value="Valider" />
        </div>
        <div class="form-group col-lg-3">
        </div>
    </div>
</form>