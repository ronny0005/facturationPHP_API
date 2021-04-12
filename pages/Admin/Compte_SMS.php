<?php
    $id = 0;
$contactD = new ContatDClass(1);

$nom = "";
$mdp = "";
$source = "";
$correct = 0;
$url="";
if($contactD->CD_No!=""){
    $nom = $contactD->CD_Nom;
    $mdp = $contactD->CD_Prenom;
    $source = $contactD->CD_Fonction;
    $url = $contactD->CD_EMail;
}

if(isset($_POST["compteSMS"]))
    $nom = $_POST["compteSMS"];

if(isset($_POST["motDePasseSMS"]))
    $mdp = $_POST["motDePasseSMS"];

if(isset($_POST["sourceSMS"]))
    $source = $_POST["sourceSMS"];

if(isset($_POST["urlSMS"]))
    $url = $_POST["urlSMS"];

    $objet = new ObjetCollector();
    if(isset($_POST["compteSMS"]) && isset($_POST["motDePasseSMS"])&& isset($_POST["sourceSMS"])&& isset($_POST["urlSMS"])){
        $contactD->setValue();
        $contactD->CD_Nom=$_POST["compteSMS"];
        $contactD->CD_Prenom=$_POST["motDePasseSMS"];
        $contactD->CD_Fonction=$_POST["sourceSMS"];
        $contactD->CD_EMail=$_POST["urlSMS"];
        $contactD->setuserName("","");
        if($contactD->CD_No=="") {
            $contactD->insertContactD();
        }
        else
            $contactD->maj_ContactD();
        $correct =1;
    }

?>
</head>
<body>    
<?php
include("module/Menu/BarreMenu.php");
?>
</head>
<div id="milieu">    
    <div class="container">

    <div class="container clearfix">
        <section class="enteteMenu bg-light p-2 mb-3">
            <h3 class="text-center text-uppercase">Compte SMS</h3>
        </section>
    </div>

    <?php
    if($correct){
    ?>
        <div class="alert alert-success" role="alert">
            Les informations ont bien été enregistrées !
        </div>
    <?php
    }
    ?>
    <form id="codeClient" class="codeClient" action="indexMVC.php?module=8&action=9" method="POST">
        <input name="action" value="9" type="hidden"/>
        <input name="module" value="8" type="hidden"/>
        <div class="row">
            <div class="col-6">
                <label for="exampleInputLogin">Compte</label>
                <input type="text" class="form-control" id="compteSMS" name="compteSMS" value="<?php echo $nom; ?>" placeholder="Compte">
            </div>
            <div class="col-6">
                <label for="exampleInputSource">Source</label>
                <input type="text" class="form-control" id="sourceSMS" name="sourceSMS" value="<?php echo $source; ?>" placeholder="Source">
            </div>
            <div class="col-6">
                <label for="exampleInputUrl">Url</label>
                <input type="text" class="form-control" id="urlSMS" name="urlSMS" value="<?php echo $url; ?>" placeholder="Url">
            </div>
            <div class="col-6">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="motDePasseSMS" name ="motDePasseSMS" value="<?php echo $mdp; ?>" placeholder="Password">
            </div>
            <div class="col-12 col-lg-2 mt-3">
                <button type="submit" class="w-100 btn btn-primary">Valider</button>
            </div>
        </div>
    </form>
        <?php
        
        ?>