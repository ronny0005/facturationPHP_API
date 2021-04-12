<?php
    $objet = new ObjetCollector();
    $protection = new ProtectionClass("","",$objet->db);
    var_dump($_POST);
?>

<fieldset class="card p-3">
    <legend class="text-uppercase text-center bg-light p-2 mb-3">Mouvement de transfert à une ligne</legend>
    <form action="indexMVC.php?module=8&action=16" method="POST">
        <div class=" table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th>Piece</th>
                        <th>Date</th>
                        <th>Réference</th>
                        <th>cbMarq</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    foreach($protection->listAlertTransfert() as $row){
                        ?>
                        <tr>
                            <td><input type="checkbox" class="form-control" name="checkRow[]" id="checkRow" value="<?= $row->cbMarq ?>" /></td>
                            <td><?= $row->DO_PIECE ?></td>
                            <td><?= $objet->getDateDDMMYYYY($row->do_date) ?></td>
                            <td><?= $row->AR_REF ?></td>
                            <td><?= $row->cbMarq ?></td>
                        </tr>
                        <?php
                    }
                ?>
                </tbody>
            </table>
        </div>
        <div class="col-lg-2">
            <input type="submit" class="w-100 btn btn-primary" name="valider" id="valider" value="Valider" />
        </div>
    </form>
</fieldset>
