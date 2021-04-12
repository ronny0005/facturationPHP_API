<?php
if(isset($_GET["id"])){
    $profil = new ProtectionClass("","");
    $profil->connexionProctectionByProtNo($_GET["id"]);
}
$value=0;
if(isset($_POST["valider"])) {
    if ($_POST["profilName"] != "") {
        if($_POST["update"]==0) {
            $protection = new ProtectionClass("", "");
            $protection->PROT_User = $_POST["profilName"];
            $value = $protection->createUser();
        }else{
            $protection = new ProtectionClass("","");
            $protection->connexionProctectionByProtNo($_POST["PROT_No"]);
            $protection->PROT_User = $_POST["profilName"];
            $protection->update();
            header('Location: ../indexMVC.php?module=8&action=2');
        }
    }
}
?>
<script src="js/script_creationGroupe.js?d=<?php echo time(); ?>"></script>
</head>
<body>    
<?php
include("module/Menu/BarreMenu.php");
?>
<div id="milieu">    
    <div class="container">
    <?php if($value==-1) echo "<div class='alert alert-danger'> Le profil ".$_POST["profilName"]." existe déjà !</div>"; ?>
    <?php if($value>0) echo "<div class='alert alert-success'> Le profil ".$_POST["profilName"]." a été crée !</div>"; ?>
<div class="container clearfix">
    <h4 id="logo" style="text-align: center;background-color: #eee;padding: 10px;text-transform: uppercase">
        <?php echo $texteMenu; ?>
    </h4>
</div>
    <form class="ajax1" action="indexMVC.php?module=8&action=3" method="POST">
        <input name="action" value="3" type="hidden"/>
        <input name="module" value="8" type="hidden"/>
        <div class="row card">
            <div class="col-lg-6">
                <label>Nom du profil </label>
                <input type="hidden" name="update" value="<?= (isset($_GET['id'])) ? 1 : 0 ?>" />
                <input type="hidden" name="PROT_No" value="<?= (isset($_GET['id'])) ? $_GET['id'] : 0 ?>" />
                <input type="text" class="form-control" id="profilName" name="profilName" value="<?= (isset($_GET["id"])) ? $profil->PROT_User : "" ?>" />
            </div>
            <div class="col-lg-12" style="margin-top: 10px">
                <input type="submit" class="btn btn-primary" value="Valider" id="valider" name="valider">
            </div>

        </div>
    </form>

       