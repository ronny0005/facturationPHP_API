<?php
$libQte="Qté";
$classQte = "col-lg-1";
if($objet->db->flagDataOr==1 && ($type=="Vente" || $type=="VenteC")) {
$libQte = "Poid brut";
$classQte = "col-lg-2";
}
if($objet->db->flagDataOr==1 && ($type=="Achat" || $type=="AchatC")) {
$libQte = "gramme";
$classQte = "col-lg-2";
}
?>
<fieldset class="card entete">
<legend class="entete">Ligne</legend>
<div class="err" id="add_err"></div>
<div>
    <?php //($admin==1) ? "<i id='getBarCode' class='fa fa-camera'></i>" : "" ?>
    <!--    <div style="display: none;" id="barCode">
        <form id="form1" enctype="multipart/form-data" method="post" action="Upload.aspx">
            <div>
                <label for="fileToUpload">Take or select photo(s)</label><br />
                <input class="btn btn-primary" type="file" name="fileToUpload" id="fileToUpload" onchange="fileSelected();" accept="image/*" capture="camera" />
            </div>
            <div id="details"></div>
            <div>
                <input type="button"  class="btn btn-primary" onclick="uploadFile()" value="Upload" />
            </div>
            <div id="progress"></div>
        </form>
        <input type="hidden" id="barCodeValue"value="" />
        <script>

            function fileSelected() {

                var count = document.getElementById('fileToUpload').files.length;

                document.getElementById('details').innerHTML = "";

                for (var index = 0; index < count; index ++)

                {

                    var file = document.getElementById('fileToUpload').files[index];

                    var fileSize = 0;

                    if (file.size > 1024 * 1024)

                        fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';

                    else

                        fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';

                    document.getElementById('details').innerHTML += 'Name: ' + file.name + '<br>Size: ' + fileSize + '<br>Type: ' + file.type;

                    document.getElementById('details').innerHTML += '<p>';

                }

            }

            function uploadFile() {

                var fd = new FormData();

                var count = document.getElementById('fileToUpload').files.length;

                for (var index = 0; index < count; index ++)

                {

                    var file = document.getElementById('fileToUpload').files[index];

                    fd.append('myFile', file);

                }

                var xhr = new XMLHttpRequest();

                xhr.upload.addEventListener("progress", uploadProgress, false);

                xhr.addEventListener("load", uploadComplete, false);

                xhr.addEventListener("error", uploadFailed, false);

                xhr.addEventListener("abort", uploadCanceled, false);

                xhr.open("POST", "savetofile.php");

                xhr.send(fd);

            }

            function uploadProgress(evt) {

                if (evt.lengthComputable) {

                    var percentComplete = Math.round(evt.loaded * 100 / evt.total);

                    document.getElementById('progress').innerHTML = percentComplete.toString() + '%';

                }

                else {

                    document.getElementById('progress').innerHTML = 'unable to compute';

                }

            }

            function uploadComplete(evt) {

                /* This event is raised when the server send back a response */
                $("#reference").val(evt.target.responseText)

            }

            function uploadFailed(evt) {

                alert("There was an error attempting to upload the file.");

            }

            function uploadCanceled(evt) {

                alert("The upload has been canceled by the user or the browser dropped the connection.");

            }

        </script>
    </div>
</div>-->
<form action="indexMVC.php?action=3&module=2" method="GET" name="form-ligne" id="form-ligne">
    <input type="hidden" value="2" name="module"/>
    <input type="hidden" value="3" name="action"/>
    <input type="hidden" value="<?php echo $qte_negative; ?>" name="qte_negative" id="qte_negative"/>
    <input type="hidden" value="<?php echo $do_imprim; ?>" name="do_imprim" id="do_imprim"/>
    <div class="form-row">
    <div class="col-12 col-sm-3 col-md-2 col-lg-2">
        <input class="form-control" id="entete" name="entete" name="entete" type="hidden" value="<?php echo $entete; ?>"/>
        <input type="text" id="reference" name="reference" class="form-control" placeholder="Référence" <?php if(!isset($_GET["cbMarq"]) || $isVisu) echo "disabled" ?>/>
        <input type="hidden" class="form-control" id="AR_Ref" name="AR_Ref" value="" />
    </div>
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <input class="form-control" id="designation" name="designation" placeholder="Désignation" <?php if(!isset($_GET["cbMarq"]) || $isVisu) echo "disabled" ?>/>
    </div>
    <div class="<?php echo $classQte; ?> col-6 col-sm-3 col-md-2 col-lg-1" >
        <input type="text" class="form-control"  value="" name="quantite" id="quantite" placeholder="<?php echo $libQte; ?> " <?php if(!isset($_GET["cbMarq"]) || $isVisu) echo "disabled" ?>/>
    </div>
    <div class="col-6 col-sm-5 col-md-4 col-lg-2" style="<?php if((($type=="Achat" || $type=="AchatC" || $type=="AchatT" ||
            $type=="AchatPreparationCommande"|| $type=="PreparationCommande")&& $flagPxAchat!=0)) echo "display:none" ?>">
          <input type="text" class="form-control"   value="" id="prix" name="prix" placeholder="P.U" <?php if($flagPxVenteRemise!=0) echo " readonly "; ?>/>
    </div>
    <div class="col-6 col-sm-3 col-md-2 col-lg-2">
          <input type="text" class="form-control" id="quantite_stock" value="" placeholder="Quantité en stock" disabled/>
    </div>
        <div class="col-6 col-sm-4 col-md-4 col-lg-2">
            <input type="text" class="form-control only_remise" value="" id="remise" name="remise" placeholder="Remise"
                   disabled <?php if($flagPxVenteRemise!=0) echo " readonly "; ?>/>
        </div>
    <div class="col-lg-1">
        <input type="hidden" name="taxe1" id="taxe1" value="0" />
        <input type="hidden" name="taxe2" id="taxe2" value="0"/>
        <input type="hidden" name="taxe3" id="taxe3" value="0"/>
        <input type="hidden" name="ADL_Qte" id="ADL_Qte" value="0"/>
        <input type="hidden" name="APrix" id="APrix" value="0"/>
        <input type="hidden" name="database" id="database" value="<?php if($objet->db->flagDataOr==1)  echo "1"; else echo "0"; ?>"/>
        <input type="hidden" name="cbMarq" id="cbMarq" value="0"/>
        <input type="hidden" name="client" id="client" value="<?php echo $client; ?>"/>
        <input type="hidden" name="acte" id="acte" value="ajout_ligne"/>

    </div>
</div>
</form>
<div class="form-row">
    <table id="tableLigne" class="table table-striped table-responsive-sm table-responsive-md mt-3">
    <thead>
        <tr>
            <th>Référence</th>
            <th>Désignation</th>
            <th style="<?php
            if((($type=="Achat" || $type=="AchatC" || $type=="AchatT" || $type=="AchatPreparationCommande"|| $type=="PreparationCommande")&& $flagPxAchat!=0))
                echo "display:none";?>
                    ">PU HT</th>
            <th><?php echo $libQte; ?></th>
            <th>Remise</th>
            <th style="
            <?php
            if((($type=="Achat" || $type=="AchatC" || $type=="AchatT" || $type=="AchatPreparationCommande"|| $type=="PreparationCommande")&& $flagPxAchat!=0))
                echo "display:none";?>
                ">PU TTC</th>
            <th style="<?php
            if((($type=="Achat" || $type=="AchatC" || $type=="AchatT" || $type=="AchatPreparationCommande"|| $type=="PreparationCommande")&& $flagPxAchat!=0))
                echo "display:none";?>">Montant HT</th>
            <th style="<?php
            if((($type=="Achat" || $type=="AchatC" || $type=="AchatT" || $type=="AchatPreparationCommande"|| $type=="PreparationCommande")&& $flagPxAchat!=0))
                echo "display:none";?>">Montant TTC</th>
            <th></th>

<?php
if (!$isVisu)
    echo "<th></th>
            <th></th>";

        if($protection->PROT_CBCREATEUR!=2)
                echo "<th>Createur</th>";
?>
        </tr>
    </thead>
    <tbody id="article_body">
      <?php
      if(isset($_GET["cbMarq"])) {
          $rows = $docEntete->listeLigneFacture();
          $i = 0;
          $classe = "";
          $fournisseur = 0;
          if ($docEntete->DO_Domaine != 0)
              $fournisseur = 1;

          if ($rows == null) {
          } else {
              foreach ($rows as $row) {
                  $docligne = new DocLigneClass($row->cbMarq);
                  $typefac = 0;
                  if($cat_tarif == null)
                      $cat_tarif =0;
                  $rows = $docligne->getPrixClientHT($docligne->AR_Ref, $docEntete->N_CatCompta, $cat_tarif, 0, 0, $docligne->DL_Qte, $fournisseur);
                  if (sizeof($rows)>0) {
                      $typefac = $rows[0]->AC_PrixTTC;
                  }
                  $i++;
                  if ($i % 2 == 0) $classe = "info";
                  else $classe = "";
                  $qteLigne = (round($docligne->DL_Qte * 100) / 100);
                  $remiseLigne = $docligne->DL_Remise;
                  $puttcLigne = ROUND($docligne->DL_PUTTC, 2);
                  $montantHTLigne = ROUND($docligne->DL_MontantHT, 2);
                  $montantTTCLigne = ROUND($docligne->DL_MontantTTC, 2);
                    $articleClass= new ArticleClass($docligne->AR_Ref);
                  if ($_GET["type"] == "VenteRetour") {
                      $qteLigne = -$qteLigne;
                      $montantTTCLigne = -$montantTTCLigne;
                      $montantHTLigne = -$montantHTLigne;
                  }
?>
                  <tr class='facture <?= $classe; ?>' id='article_<?= $docligne->cbMarq; ?>'>
                      <td id='AR_Ref' style='color:blue;text-decoration: underline'><?= $docligne->AR_Ref; ?></td>
                      <td id='DL_Design' style='align:left'><?= $docligne->DL_Design; ?></td>
                    <td id='DL_PrixUnitaire'
                    style="<?php
                    if((($type=="Achat" || $type=="AchatC" || $type=="AchatT" || $type=="AchatPreparationCommande"|| $type=="PreparationCommande")&& $flagPxAchat!=0))
                        echo "display:none";?>">
                        <?= $objet->formatChiffre(round($docligne->DL_PrixUnitaire, 2)); ?></td>
                    <td id='DL_Qte'><?= $objet->formatChiffre($qteLigne); ?></td>
                  <?php
                        if($objet->db->flagDataOr!=1) echo "<td id='DL_Remise'>$remiseLigne</td>";
                    ?>
                      <td id='PUTTC'
                          style="<?php
                          if((($type=="Achat" || $type=="AchatC" || $type=="AchatT" || $type=="AchatPreparationCommande"|| $type=="PreparationCommande")&& $flagPxAchat!=0))
                              echo "display:none";?>"><?= $objet->formatChiffre($puttcLigne); ?></td>
                      <td id='DL_MontantHT' style="<?php
                      if((($type=="Achat" || $type=="AchatC" || $type=="AchatT" || $type=="AchatPreparationCommande"|| $type=="PreparationCommande")&& $flagPxAchat!=0))
                          echo "display:none";?>"><?= $objet->formatChiffre($montantHTLigne); ?></td>
                      <td id='DL_MontantTTC' style="<?php
                          if((($type=="Achat" || $type=="AchatC" || $type=="AchatT" || $type=="AchatPreparationCommande"|| $type=="PreparationCommande")&& $flagPxAchat!=0))
                              echo "display:none";?>">
                      <?= $objet->formatChiffre($montantTTCLigne); ?></td>
                      <td style='display:none' id='DL_NoColis'><?= $docligne->DL_NoColis; ?></td>
                      <td style='display:none' id='cbMarq'><?= $docligne->cbMarq; ?></td>
                      <td style='display:none' id='cbMarqArticle'><?= $articleClass->cbMarq; ?></td>

                      <td style='display:none' id='DL_CMUP'><?= $docligne->DL_CMUP; ?></td>
                      <td style='display:none' id='DL_TYPEFAC'><?= $typefac; ?></td>
                      <td style='display:none' id='DL_PieceBL'><?= $docligne->DL_PieceBL; ?></td>
                  <?php
                  if (!isset($_GET["visu"]) && ($_GET["type"] == "PreparationCommande" || $_GET["type"] == "AchatPreparationCommande"))
                      echo "<td id='lignea_" . $docligne->cbMarq . "'><i class='fa fa-sticky-note fa-fw'></i></td>";
                  if (!$isVisu)
                      echo "<td id='modif_{$docligne->cbMarq}'>
                                <i class='fa fa-pencil fa-fw'></i>
                            </td>
                            <td id='suppr_{$docligne->cbMarq}'><i class='fa fa-trash-o'></i></a></td>";
                  if($protection->PROT_CBCREATEUR!=2)
                      echo "<td></td><td>{$docligne->getcbCreateurName()}</td>";
                  echo "</tr>";
                  $totalht = $totalht + ROUND($docligne->DL_MontantHT, 2);
                  $tva = $tva + ROUND($docligne->MT_Taxe1, 2);
                  $precompte = $precompte + ROUND($docligne->MT_Taxe2, 2);
                  $marge = $marge + ROUND($docligne->MT_Taxe3, 2);
                  $totalttc = $totalttc + ROUND($docligne->DL_MontantTTC, 2);
              }
          }
      }
      ?>
    </tbody>
    </table>
</div>
</fieldset>
 