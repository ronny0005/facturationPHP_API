<?php
    $objet = new ObjetCollector();
    $depot=$_SESSION["DE_No"];

    if(isset($_POST["AR_RefNouveau"])){
        $articleAncien = new ArticleClass($_POST["AR_RefAncien"],$objet->db);
        $articleNouveau = new ArticleClass($_POST["AR_RefNouveau"],$objet->db);
        $articleAncien->majRefArticle($articleNouveau->AR_Ref);
    }
?>
<script src="js/Admin/script_fusionArticle.js?d=<?= time(); ?>"></script>
</head>
<body>
<?php
include("module/Menu/BarreMenu.php");
?>
<div id="milieu">
    <div class="container">
    <section class="enteteMenu bg-light p-2 mb-3">
        <h3 class="text-center text-uppercase"><?= $titleMenu; ?></h3>
    </section>
<?php
if(isset($_POST["AR_RefNouveau"])){
    ?>
    <div class="alert alert-success">
        Les mouvements de l'article <?= $_POST["AR_RefAncien"] ?> ont migrés vers <?= $_POST["AR_RefNouveau"] ?>.<br/>
        L'article <?= $_POST["AR_RefAncien"] ?> a été mis en sommeil.
    </div>
    <?php
}
?>
<div class="corps">
    <form id="formulaire" action="#" method="POST">
        <input type="hidden" id="mdp" value="<?= $_SESSION["mdp"]; ?>"/>
        <input type="hidden" id="login" value="<?= $_SESSION["login"]; ?>"/>

    <div class="row">
        <div class="col-lg-4 col-12">
            <label>Ancienne référence :</label>
            <select class="form-control" id="AR_RefAncien" name="AR_RefAncien">
                <?php
                $article = new ArticleClass(0,$objet->db);
                $rows = $article->all(0);
                foreach($rows as $row){
                    ?>
                    <option value="<?= $row->AR_Ref ?>"><?= $row->AR_Ref." - ".$row->AR_Design ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div class="col-lg-4 col-12">
            <label>Nouvelle référence :</label>
            <select class="form-control" id="AR_RefNouveau" name="AR_RefNouveau">
                <?php
                foreach($rows as $row){
                    ?>
                    <option value="<?= $row->AR_Ref ?>"><?= $row->AR_Ref." - ".$row->AR_Design ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-3 mt-3">
            <input type="button" class="w-100 btn btn-primary" value="Valider" name="Valider" id="valider"/>
        </div>
    </div>
    </form>
    </div>


</div>
