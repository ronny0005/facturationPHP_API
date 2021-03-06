<script src="js/scriptCombobox.js?d=<?php echo time(); ?>"></script>
<script src="js/script_banque.js?d=<?php echo time(); ?>"></script>

<?php
    $CA_Num="-1";
    $datedeb= date("dmy");
    $datefin= date("dmy");
    $bq_no=-1;
    $type=-1;
    $objet = new ObjetCollector();
    $creglement = new ReglementClass(0,$objet->db);
$datapost = 0;
$modif= 0;
if(isset($_POST["RG_Modif"]))
    $modif = $_POST["RG_Modif"];

        if(isset($_POST["dateReglementEntete_deb"])) {
            $datedeb = $_POST["dateReglementEntete_deb"];
            $datapost=1;
        }
        if(isset($_POST["dateReglementEntete_fin"]))
            $datefin = $_POST["dateReglementEntete_fin"];

        if(isset($_POST["banqueComplete"]))
            $bq_no = $_POST["banqueComplete"];

        if(isset($_POST["type_mvt_ent"]))
            $type = $_POST["type_mvt_ent"];
        $cloture=0;
        if(isset($_POST["date"]))
            $cloture = $creglement->journeeCloture($objet->getDate($_POST['date']),1);

        $messageMenu="";
        if($cloture>0)
            $messageMenu = "Cette journée a déjà été cloturée !";

        if(isset($_POST["libelle"]) && $cloture == 0) {
            $protection = new ProtectionClass("", "",$objet->db);
            $protection->connexionProctectionByProtNo($_SESSION["id"]);
            $isSecurite = $protection->IssecuriteAdminCaisse(1);
            if ($isSecurite == 1) {

                $montant = str_replace(" ", "", $_POST["montant"]);
                $login = $_SESSION["id"];
                $CA_Num = "";
                $libelle = str_replace("'", "''", $_POST['libelle']);
                $rg_typereg = 0;
                if (isset($_POST['rg_typereg']))
                    $rg_typereg = $_POST['rg_typereg'];
                $user = "";
                if (isset($_POST["user"]))
                    $user = $_POST["user"];
                if ($rg_typereg == 6) $libelle = $libelle;
                $caisse = new CaisseClass(1,$objet->db);
                $banqueClass = new BanqueClass($_POST["BQ_No"],$objet->db);
                $co_nocaissier = $caisse->CO_NoCaissier;
                $ca_intitule = $caisse->CA_Intitule;
                $jo_num = $banqueClass->JO_Num;
                $collabClass = new CollaborateurClass($co_nocaissier,$objet->db);
                if ($collabClass == null) {
                } else {
                    $collaborateur_caissier = $collabClass->CO_Nom;
                }
                $cg_num = $_POST['CG_NumBanque'];
                $banque = 0;
                //if ($rg_typereg == 2) $cg_num = "NULL";
                if ($rg_typereg == 6) {
                    // Pour les vrst bancaire mettre a jour le compteur du RGPIECE
                    $banque = 1;
                }

                if ($modif == 0)
                    $banqueClass->addReglementBanque($rg_typereg,$montant,$cg_num,$jo_num,$co_nocaissier,$libelle,$banqueClass->BQ_No,$login,$_POST['date'], $_POST['BQ_No'], "",$_POST['CA_No_Dest'],$CA_Num,$_POST["CG_Analytique"]);

                if ($modif == 1)
                    $banqueClass->modifReglementBanque($_POST["rg_typeregModif"] ,$_POST["RG_NoLigne"],$_POST["date"],$_POST["BQ_No"]
                        ,$_POST["libelle"],$_POST["CG_NumBanque"],$_POST["montant"],"",$_POST["RG_NoDestLigne"],$_POST["CA_No_Dest"]);

            }
        }

?>
    
<div>
    <?php
    if($messageMenu!=""){
        ?>
        <div class="alert alert-danger">
            <?= $messageMenu ?>
        </div>
            <?php
    } ?>
    <input type="hidden" class="form-control" id="flagAffichageValCaisse" value="<?= $flagAffichageValCaisse;/*$flagModifSupprComptoir;*/ ?>" />
    <input type="hidden" class="form-control" id="flagCtrlTtCaisse" value="<?= $flagCtrlTtCaisse/*$flagModifSupprComptoir;*/ ?>" />
</div>

<section class="enteteMenu bg-light p-2 mb-3">
    <h3 class="text-center text-uppercase">Banque</h3>
</section>
                <fieldset class="card p-3">
                    <legend class="text-uppercase">Entete</legend>
                    <form class="form-horizontal" action="indexMVC.php?module=6&action=2" method="POST">
                        <div class="row">
                                <div class="col-6 col-sm-6 col-md-6 col-lg-2">
                                    <label>Banque</label>
                                    <input type="hidden" id="action" name="action" value="1"/>
                                    <input type="hidden" id="module" name="module" value="6"/>
                                    <input type="hidden" id="postData" name="postData" value="<?= $datapost; ?>"/>
                                    <select class="form-control" name="banqueComplete" id="banqueComplete">
                                        <?php
                                            $banqueClass = new BanqueClass(0,$objet->db);
                                            $rows = $banqueClass->all();
                                            if($rows==null){
                                            }else{
                                                if(sizeof($rows)>1)
                                                    echo "<option value='-1'>Sélectionner une banque</option>";

                                                foreach($rows as $row) {
                                                    echo "<option value='{$row->BQ_No}'";
                                                    if ($row->BQ_No == $bq_no) echo " selected";
                                                    echo ">{$row->BQ_Intitule}</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="col-6 col-sm-6 col-md-6 col-lg-2">
                                    <label>Type</label>
                                    <select class="form-control" name="type_mvt_ent" id="type_mvt_ent">
                                        <option value="-1">Sélectionner un type</option>
                                        <?php
                                        if($profil_caisse==1 || $admin==1){
                                        ?>
                                            <option value="4" <?php if($type=="4") echo " selected"; ?>>sortie espèce</option>
                                            <option value="5" <?php if($type=="5") echo " selected"; ?>>entrée espèce</option>
                                            <option value="2" <?php if($type=="2") echo " selected"; ?>>agio</option>
                                            <option value="16" <?php if($type=="16") echo " selected"; ?>>Transfert de caisse</option>
                                        <?php
                                        }
                                        ?>
                                        <option value='6'<?php if($type=="6") echo " selected"; ?>>Verst bancaire</option>
                                    </select>
                                </div>
                                <div class="col-6 col-sm-6 col-md-6 col-lg-2">
                                    <label>Début</label>
                                    <input  type="text"  class="form-control" id="dateReglementEntete_deb" name="dateReglementEntete_deb" placeholder="Date" value="<?= $datedeb; ?>"/>
                                </div>
                                <div class="col-6 col-sm-6 col-md-6 col-lg-2">
                                    <label>Fin</label>
                                    <input  type="text"  class="form-control" id="dateReglementEntete_fin" name="dateReglementEntete_fin" placeholder="Date" value="<?= $datefin; ?>"/>
                                </div>
                                <div class="col-6 col-lg-2 mt-3 mt-lg-4">
                                    <button type="submit" class="btn btn-primary w-100" id="recherche" name="recherche">Rechercher</button>
                                </div>
                                <div class="col-6 col-lg-2  mt-3 mt-lg-4">
                                    <button type="button" class="w-100 btn btn-primary" id="imprimer">Imprimer</button>
                                </div>
                            </div>
                    </form>
                </fieldset>

                <fieldset class="card p-3">
                    <legend class="text-uppercase">Ligne</legend>
                    <?php 
                    if(1==1){
                    ?>
                        <form class="form-horizontal" action="indexMVC.php?module=6&action=2" method="POST" name="form_ligne" id="form_ligne">
                        <div class="row">
                                <input type="hidden" id="action" name="action" value="1"/>
                                <input type="hidden" id="module" name="module" value="6"/>
                                <input type="hidden" id="banqueComplete_ligne" name="banqueComplete" value=""/>
                                <input type="hidden" id="type_mvt_ent_ligne" name="type_mvt_ent" value=""/>
                                <input type="hidden" id="dateReglementEntete_deb_ligne" name="dateReglementEntete_deb" value=""/>
                                <input type='hidden' id='RG_Modif' name='RG_Modif' value='0'/>
                                <input type='hidden' id='rg_typeregModif' name='rg_typeregModif' value='0'/>

                                <input type='hidden' id='RG_NoLigne' name='RG_NoLigne' value='0'/>
                                <input type='hidden' id='RG_NoDestLigne' name='RG_NoDestLigne' value='0'/>

                                <input type="hidden" id="dateReglementEntete_fin_ligne" name="dateReglementEntete_fin" value=""/>
                                <input type="hidden" id="cg_num_ligne" name="cg_num" value=""/>
                              <?php //if($flagDateMvtCaisse!=2){ ?>
                                <div class="col-6 col-sm-6 col-md-6 col-lg-2">
                                    <input type="text"  class="form-control" id="dateReglement" name="date" placeholder="Date" <?php if($flagDateMvtCaisse==2) echo "readonly"; ?>/>
                                </div>
                                <?php //} ?>
                                <div class="col-6 col-sm-6 col-md-6 col-lg-2">
                                    <select class="form-control" name="BQ_No" id="banqueLigne" placeholder="Banque">
                                        <?php
                                        $banqueClass = new BanqueClass(0,$objet->db);
                                        $rows = $banqueClass->all();
                                        if(sizeof($rows)>1)
                                            echo "<option value='-1'>Sélectionner une banque</option>";
                                        if($rows==null){
                                        }else{
                                            foreach($rows as $row) {
                                                echo "<option value='{$row->BQ_No}'";
                                                if ($row->BQ_No == $bq_no) echo " selected";
                                                echo ">{$row->BQ_Intitule}</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-8">
                                    <input type="text" maxlength="27" class="form-control" id="libelleRec" name="libelle" placeholder="Libelle" />
                                </div>
                                <div class="col-12 col-sm-12 col-md-4 col-lg-2">
                                    <input type="hidden" class="form-control" name="CG_NumBanque" id="CG_NumBanque" value=""/>
                                    <input type="hidden" class="form-control" name="CG_Analytique" id="CG_Analytique" value="0"/>
                                    <input type="text" class="form-control" name="banque" id="banque" value="" placeholder="Compte générale"/>
                                </div>
                                <div class="col-6 col-sm-6 col-md-4 col-lg-2">
                                    <select class="form-control" name="rg_typereg" id="type_mvt_lig">
                                        <?php 
                                        if(1==1){
                                           ?>
                                        <option value='4'>sortie espèce</option>
                                            <option value="5">entrée espèce</option>
                                            <option value="2">agio</option>
                                        <?php }
                                        if($protection->PROT_OUVERTURE_TOUTE_LES_CAISSES==0) echo "<option value='16'>Transfert caisse</option>";
                                        ?>
                                        <option value='6'>Verst bancaire</option>
                                    </select>
                                </div>
                                <div class="col-6 col-sm-6 col-md-4 col-lg-2">
                                    <select class="form-control" name="typeReglement" placeholder="Type de Règlement" >

                                    </select>
                                </div>
                            <div class="col-6 col-sm-6 col-md-4 col-lg-2">
                                <input type="text" class="form-control" id="montantRec" name="montant" placeholder="Montant" />
                            </div>


                                <div class='col-12 col-sm-6 col-md-6 col-lg-2' id="divCaisseDest">
                                    <label>Caisse dest. :</label>
                                    <select style="float:left" class="form-control" name="CA_No_Dest" id="CA_No_Dest" placeholder="caisse">
                                        <option value="-1">Sélectionner une caisse</option>
                                        <?php
                                        $banqueClass = new BanqueClass(0,$objet->db);
                                        $rows = $banqueClass->all();
                                        if(sizeof($rows)>1)
                                            echo "<option value='-1'>Sélectionner une banque</option>";
                                        if($rows==null){
                                        }else{
                                            foreach($rows as $row) {
                                                echo "<option value='{$row->BQ_No}'";
                                                if ($row->BQ_No == $bq_no) echo " selected";
                                                echo ">{$row->BQ_Intitule}</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-12 col-lg-3 mt-4 mt-sm-0 mt-md-0 mt-lg-0">
                                <button type="button" class="btn btn-primary w-100" id = "validerRec" name= "validerRec">Valider</button>
                            </div>
                            </div>
                            <?php
                    echo "</form>";
                    }
    ?>
                        <table class="table table-striped mt-3" id="tableRecouvrement">
                            <thead>
                                <tr>
                                    <th>Numéro</th>
                                    <th>N° Piece</th>
                                    <th>Date</th>
                                    <th>Libelle</th>
                                    <th>Montant</th>
                                    <th>Caisse</th>
                                    <th>Caissier</th>
                                    <th>Type</th>
                                    <?=($flagAffichageValCaisse==0) ? "<th></th>" : ""; ?>
                                    <?= ($flagCtrlTtCaisse==0) ? "<th></th>" : ""; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    function typeCaisse($val){
                                        if($val==16) return "Transfert caisse";
                                        if($val==5) return "Entrée espèce";
                                        if($val==4) return "Sortie espèce";
                                        if($val==2) return "agio";
                                        if($val==6) return "Vrst bancaire";
                                    }
                                    $banque = new BanqueClass(0,$objet->db);
                                    $rows = $banque->listeReglementBanque($objet->getDate($datedeb),$objet->getDate($datefin),$bq_no,$type,$_SESSION["id"]);
                                $banque->afficheMvtBanque($rows,$flagAffichageValCaisse,$flagCtrlTtCaisse);
                                ?>
                            </tbody>
                        </table>
                        <div id="blocModal">
                            <div class='col-md-6'>
                            Libellé :<input type='text' class='form-control' id='libelleRecModif' placeholder='Libellé' />
                            </div>
                            <div class='col-md-6'>
                                Montant :<input type='text' class='form-control' id='montantRecModif' placeholder='Montant' />
                            </div>
                        </div>
                </fieldset>

        <div id="valide_vrst" title="VALIDATION VRST BANCAIRE DAF">
            <div class="form-group">
                <div class="col-lg-3">
                    <label>Bordereau</label>
                    <input class="form-control" name="bordereau" id="bordereau"/>
                </div>
                <div class="col-lg-3">
                    <label>Banque</label>
                    <input class="form-control" maxlength="8" name="libelle_banque" id="libelle_banque"/>
                </div>
                <div class="col-lg-3">
                    <label>Date</label>
                    <input class="form-control" maxlength="8" name="libelle_date" id="libelle_date"/>
                </div>
                <div id="fichier" class="col-md-3">
                    <!-- The file input field used as target for the file upload widget -->
                    <input id="fileupload" type="file" name="files[]" multiple>
                    <!-- The global progress bar -->
                    <div id="progress" class="progress">
                        <div class="progress-bar progress-bar-success"></div>
                    </div>
                    <!-- The container for the uploaded files -->
                    <div id="files" class="files"></div>
                </div>
            </div>
        </div>
