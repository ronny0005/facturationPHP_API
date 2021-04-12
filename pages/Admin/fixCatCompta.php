<?php
    $objet = new ObjetCollector();
    $protection = new ProtectionClass("","",$objet->db);
$valid = 0;
    if(isset($_POST["valider"])){
        $protection->fixCatCompta();
        $valid =1;
    }
?>

<fieldset class="card p-3">
    <legend class="text-uppercase text-center bg-light p-2 mb-3">Cat compta éronnée</legend>
    <form action="indexMVC.php?module=8&action=17" method="POST">
        <?php
        if($valid == 1){
        ?>
            <div class="alert alert-success">
                Cat compta fixée !
            </div>
        <?php
        }
        ?>
        <div class=" table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Domaine</th>
                        <th>Type</th>
                        <th>Piece</th>
                        <th>Cat Compta</th>
                        <th>cbMarq</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $rows =$protection->listAlerteDocumentCatComptaTaxe() ;
                    foreach($rows as $row){
                            ?>
                        <tr>
                            <td><?= $row->DO_Domaine ?></td>
                            <td><?= $row->DO_Type ?></td>
                            <td><?= $row->DO_Piece ?></td>
                            <td><?= $row->catCompta ?></td>
                            <td><?= $row->cbMarq ?></td>
                        </tr>
                        <?php
                    }
                ?>
                </tbody>
            </table>
        </div>
        <div class="col-lg-2">
            <input type="submit" class="w-100 btn btn-primary" name="valider" id="valider" value="Valider" <?php if(sizeof($rows)==0) echo"disabled"; ?>/>
        </div>
    </form>
</fieldset>
