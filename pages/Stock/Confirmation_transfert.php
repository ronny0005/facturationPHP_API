<script src="js/scriptCombobox.js?d=<?= time(); ?>"></script>
<script src="js/script_ConfirmationTransfert.js?d=<?= time(); ?>"></script>
</head>
<body>
<?php
include("module/Menu/BarreMenu.php");
$objet = new ObjetCollector();
$docEntete = new DocEnteteClass(0,$objet->db);
$depotUserClass = new DepotUserClass(0,$objet->db);
$rows=$depotUserClass->getDepotUser($_SESSION["id"]);
$list_depot = "";
foreach($rows as $row){
    $list_depot = $list_depot.$row->DE_No.",";
}

$list = $docEntete->getDocumentConfirmation(substr($list_depot,0,strlen($list_depot)-1));
$cbMarqEntete =0;
if(sizeof($list)>0)
    $cbMarqEntete = $list[0]->cbMarq;
?>
<div id="milieu">    
    <div class="container">
    
<div class="container clearfix">
    <input type="hidden" name="typeDocument" id="typeDocument" value="<?= $_GET["type"] ?>" />

    <h4 id="logo" style="text-align: center;background-color: #eee;padding: 10px;text-transform: uppercase">
        <?php echo $texteMenu; ?>
    </h4>

    <div>
        <h4>Document</h4>
        <form action="#" method="POST" name="entete" id="entete">
            <div class="row">
                <div class="col-2">
                    <select id="DO_Piece" name="DO_Piece" class="form-control">
                            <?php
                            foreach($list as $entete){
                                echo "<option value='{$entete->cbMarq}'>{$entete->DO_Piece}</option>";
                            }
                            ?>
                    </select>
                </div>
            </div>
        <div class="mt-2">
        </div>
        <h4>Ligne</h4>
        <div id="ligne">
            <?php
                $docligne = new DocLigneClass(0,$objet->db);
                $docligne->ligneConfirmationVisuel($cbMarqEntete);
            ?>
        </div>
        <div class="row">
            <input type="button" class="btn btn-primary" value="Valider" name="valider" id="valider" />
        </div>
        </form>
    </div>
</div>
