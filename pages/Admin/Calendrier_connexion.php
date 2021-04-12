<?php
    $objet = new ObjetCollector();
?>
<script src="js/Admin/Calendrier_connexion.js?d=<?php echo time(); ?>"></script>
    <section class="enteteMenu bg-light p-2 mb-3">
        <h3 class="text-center text-uppercase">CALENDRIER CONNEXION</h3>
    </section>
<?php
    if($action==1){
        echo "<div class='alert alert-success'>La modification a bien été effectuée !</div>";
    }
?>
        <form action="#" name="calendar" method="POST">
            <div class="row">
                <div class="col-lg-6 mb-3">
                    <label>Utilisateur</label>
                    <input type="hidden" class="btn btn-primary" id="PROT_NoUser" name="PROT_NoUser" value=""/>
                    <select class="form-control" name="user" id="user">
                        <?php
                        $prot_no=0;
                            $protectionClass = new ProtectionClass("","");
                            $rows = $protectionClass->getUtilisateurAdminMainConnexion();
                            if ($rows != null) {
                                foreach ($rows as $row) {
                                    echo "<option value='{$row->PROT_No_User}'";
                                    if($prot_no==$row->PROT_No_User) 
										echo "selected";
                                    echo ">{$row->PROT_User}</option>";
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <fieldset class="card p-3">
                <legend>Plage horaire</legend>
            <?php
                $day = array("Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche");
                foreach ($day as $value) {
                    ?>
                    <div class="row">
                        <div class="col-4 col-lg-2 text-center">
                            <?= $value ?>
                            <input type="checkbox" class="mt-2 form-control" name="check<?= $value ?>" id="check<?= $value ?>"/>
                        </div>
                        <div class="col-4 col-lg-2">
                            <label>Heure début</label>
                            <div class="clockpicker">
                                <input name="heureDebut<?= $value ?>" id="heureDebut<?= $value ?>" type="text" class="form-control" value="00:00">
                            </div>
                        </div>
                        <div class="col-4 col-lg-2">
                            <label>Heure Fin</label>
                            <div class="clockpicker">
                                <input name="heureFin<?= $value ?>" id="heureFin<?= $value ?>" type="text" class="form-control" value="00:00">
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="row mt-3">
                    <div class="col-lg-2 col-12">
                        <input type="button" class="w-100 btn btn-primary" id="valider" name="valider" value="Valider"/>
                    </div>
                </div>
            </fieldset>
        </form>
