<fieldset class="card entete">
<legend class="entete">Pied</legend>
 <div id="piedPage" class="">
</div>
</fieldset>
<fieldset id="liste_reglement" class="card entete" style="<?php if($isVisu == 0) echo "display:none"; ?>">
    <legend class="entete">R&egrave;glement</legend>
    <table class="table table-striped table-responsive-sm table-responsive-md" id="tableRecouvrement">
                            <thead>
                                <tr>
                                    <th>Date du règlement</th>
                                    <th>Date de l'échéance</th>
                                    <th>Libelle</th>
                                    <th>Montant</th>
                                    <th>Solde progressif</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <?php
                                 $creglement = new ReglementClass(0);
                                    $rows = $creglement->getReglementByClientFacture($docEntete->cbMarq);
                                    $i=0;
                                    $classe="";
                                    if($rows==null){
                                        echo "<tr><td>Aucun élément trouvé ! </td></tr>";
                                    }else{
                                        foreach ($rows as $row){
                                            $i++;
                                            if($i%2==0) $classe = "info";
                                            else $classe="";
                                            $date=date("d-m-Y", strtotime($row->RG_Date));
                                            $dr_date=date("d-m-Y", strtotime($row->DR_Date));
                                            if($date=="01-01-1970" || $date=="01-01-1900") $date="";
                                            if($dr_date=="01-01-1970" || $dr_date=="01-01-1900") $dr_date="";
                                            echo "<tr class='$classe'>
                                                <td>{$date}</td>
                                                <td>{$dr_date}</td>
                                                <td>{$row->RG_Libelle}</td>
                                                <td>{$objet->formatChiffre(round($row->RC_Montant))}</td>
                                                <td>{$objet->formatChiffre(round($row->CUMUL))}</td>
                                                </tr>";
                                        }
                                    }
                                    ?>
                            </tbody>
                        </table>
               
</fieldset> 

<?php 
if($type=="PreparationCommande" || $type=="AchatPreparationCommande"){
?>
    <fieldset id="liste_saisieEC" class="card entete">
        <legend class="entete">Création écriture compta</legend>
        <table class="table" id="tableEC">
            <thead>
            <tr>
                <th>Code journal</th>
                <th>Exercice</th>
                <th>Jour</th>
                <th>N° Facture</th>
                <th>Référence</th>
                <th>N° Compte général</th>
                <th>N° Compte tiers</th>
                <th>Libellé écriture</th>
                <th>Date échéance</th>
                <th>Débit</th>
                <th>Crédit</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </fieldset>

    <fieldset id="liste_saisieAnal" class="card entete">
        <legend class="entete">Création écriture analytique</legend>
        <table class="table" id="tableAnal">
            <thead>
            <tr>
                <th>Code journal</th>
                <th>Plan analytique</th>
                <th>N° Compte général</th>
                <th>Exercice</th>
                <th>Section</th>
                <th>Qte/Dévise</th>
                <th>Montant</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </fieldset>
<?php }?>
<form action="indexMVC.php?action=3&module=2" method="GET" name="form-valider" id="form-valider">
    <input type="hidden" value="2" name="module"/>
    <input type="hidden" value="3" name="action"/>
    <input type="hidden" name="entete" id="valide_entete" value="0"/>
    <input type="hidden" name="client" id="valide_client" value="0"/>
    <input type="hidden" name="montant_avance" id="montant_avance" value="0"/>
    <input type="hidden" name="reste_a_payer" id="reste_a_payer" value="<?= $reste_a_payer; ?> "/>
    <input type="hidden" name="montant_total" id="montant_total" value="<?= $totalttc; ?>"/>
    <input type="hidden" name="PROT_Reglement" id="PROT_Reglement" value="<?= $protection->PROT_DOCUMENT_REGLEMENT; ?>"/>
    <input type="hidden" id="imprime_val" name="imprime_val" value="0"/>

    <div class="row">
        <div class="col-4">
            <button type="button" class="btn btn-primary w-100" id="annuler" disabled>Annuler</button>
        </div>
        <?php
        if ($isModif /*&& $reste_a_payer!=0*/){ ?>
        <div class="col-4">
            <button type="button" class="btn btn-primary w-100" id="valider" disabled>Valider</button>
         </div>
        <?php } ?>
        <div class="col-4">
            <button type="button" class="btn btn-primary w-100" id="imprimer" disabled>Imprimer</button>
         </div>
    </div>
</form>
<?php
?>
   
<div id="dialog-confirm" title="Suppression" style="display: none;">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>Voulez vous supprimez cette ligne ?</p>
</div>

<?php
$bloqueReglement = 0;

if($type=="Vente" && $protection->PROT_GEN_ECART_REGLEMENT!=0) {
    $bloqueReglement =1;
}
?>
<div class="validFacture" style="display: none">
    <form action="Traitement/Facturation.php" method="GET" id="redirectFacture">
        <input type="hidden" value="<?= $type ?>" id="typeFacture" name="typeFacture" />
        <input type="hidden" value="redirect" id="acte" name="acte" />
    </form>
</div>

<div class="valideReglement"  style="display:none">
     <form action="Traitement/Facturation.php" method="GET" id="valideRegltForm">
         <input type="hidden" value="0" id="DO_Imprim" name="DO_Imprim" />
         <div class="row p-2">
             <div style="<?php if($bloqueReglement) echo";display:none"; ?>" class="col-6 text-center" >
               <label>Comptant</label>
                   <input type="checkbox" id="comptant" name="comptant"/>
            </div>
            <div style="<?php if($bloqueReglement) echo";display:none"; ?>" class="col-6 text-center" >
                <label>Crédit</label>
                    <input type="checkbox" id="credit" name="credit"/>
            </div>
         </div>
         <div class="row p-2">
             <div class="col-6" >
                <label>Date reglement</label>
                <input type="text" id="date_rglt" name="date_rglt" class="form-control only_integer" <?php if($flagDateRglt!=0) echo"readonly"; ?>/>
            </div>
            <div class="col-6" >
                <label>Date échéance</label>
                <input type="text" id="date_ech" name="date_ech" class="form-control only_integer" <?php if($bloqueReglement) echo"readonly"; ?>/>
            </div>
         </div>
        <div class="col-12 p-2" >
            <label>Libellé règlt</label>
            <input type="text" id="libelle_rglt" maxlength="35" name="libelle_rglt" class="form-control" <?php if($bloqueReglement) echo"readonly"; ?>/>
        </div>
        <div class="row p-2">
            <div class="col-6" >
                <label>Mode de rglt</label>
                <select id="mode_reglement_val" name="mode_reglement_val" class="form-control" <?php if($bloqueReglement) echo"readonly"; ?>>
                    <?php
                    $rows = $creglement->listeTypeReglement();
                    if($rows !=null) {
                        foreach ($rows as $row) {

                            if ($row->R_Code == "01") {
                                echo "<option value='{$row->R_Code}'>{$row->R_Intitule}</option>";
                            } else {
                                if ($flagRisqueClient == 0) {
                                    echo "<option value='{$row->R_Code}'>{$row->R_Intitule}</option>";
                                }
                            }
                        }
                    }

                    ?>
                </select>
            </div>
             <div class="col-6" >
                 <label>Modele rglt</label>
                 <select id="modele_reglement_val" name="modele_reglement_val" class="form-control" <?php if($bloqueReglement) echo"readonly"; ?>>
                 <option value=""></option>
                     <?php
                     $rows =  $creglement->getModeleReglement();
                     if($rows !=null) {
                         foreach($rows as $row){
                             ?>
                            <option value="<?= $row->MR_No; ?>"><?= $row->MR_Intitule ?></option>
                            <?php
                         }
                     }
                 ?>
                 </select>
             </div>
         </div>
         <div class="col-12 p-2" >
            <label>Montant avance</label>
            <input type="hidden" id="valideRegltImprime" name="valideRegltImprime" />
            <input type="hidden" id="cbMarqEntete" name="cbMarqEntete" value="<?= ($docEntete->cbMarq == "") ? 0 : $docEntete->cbMarq ?>"/>
            <input type="hidden" id="valideRegle" name="valideRegle" value="0"/>
             <input type="hidden" id="typeFacture" name="typeFacture" value="<?= $_GET["type"]; ?>"/>
             <input type="hidden" id="PROT_No" name="PROT_No" value="<?= $_SESSION["id"]; ?>"/>
            <input type="hidden" id="acte" name="acte" value="regle"/>
            <input type="input" id="mtt_avance" name="mtt_avance" class="form-control" READONLY/>
        </div>
    <?php if(isset($_GET["cbMarq"])){
        ?>
     <div id="reste_a_payer_text" class="col-12 mt-2 text-right">
         Le reste à payer est de <b><?php echo $reste_a_payer; ?></b>
     </div>
     <?php } ?>
     </form>
</div>

<?php
echo "<div id='formArticleFactureBis' style='display: none;'>";

echo "</div>";
?>
<div id="formArticleFacture">
</div>

<?php 
$typeclient="client";
$valtype = 0;
if($_GET["type"]=="Achat" || $_GET["type"]=="PreparationCommande" || $type=="AchatPreparationCommande") {
    $typeclient="fournisseur";
    $valtype = 1;
}
?>
<div id="formCreationClient"  style="display:none">
</div>

<div id="formAnalytique"  style="display:none">
<div class="form-group" >
    <div class="col-lg-2">
        <label>Plan</label>
        <select class="form-control" id="N_Analytique" name="N_Analytique">
                <?php
                    $result=$objet->db->requete($objet->getListeTypePlan());     
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    if($rows==null){
                    }else{
                        foreach($rows as $row){
                            echo "<option value={$row->cbIndice}";
                            //if($row->cbIndice == $N_Analytique) echo " selected";
                            echo ">{$row->A_Intitule}</option>";
                        }
                    }
                    ?>
            </select>
    </div>
</div>

<div style="display:none">
    <table id="table">
        <th style="text-align: center"><td style="padding: 10px">Qté/Devise</td><td style="padding: 10px">Montant</td></th>
        <tr style="text-align: center"><td>A imputer</td><td id="qte_imputer"></td><td id="montant_imputer"></td></tr>
        <tr style="text-align: center"><td>Total imputé</td><td id="qte_timputer"></td><td id="montant_timputer"></td></tr>
        <tr style="text-align: center"><td>Solde</td><td id="qte_solde"></td><td id="montant_solde"></td></tr>
    </table>
</div>
        
<div class="form-group" style="display:none" >
       <table class="table" id="table_anal" style="width:100%">
           <thead>
               <tr style="text-align: center;font-weight: bold">
                   <td>Section</td>
                   <td>Qte/Devise</td>
                   <td>Montant</td>
               </tr>
               <tr id="param">
                   <td>
                       <select name="CA_Num" class="form-control" id="CA_Num">
                           <option value=""></option>
                           <?php 
                            $result =  $objet->db->requete( $objet->getAnalytiqueSaisie());
                            $rows = $result->fetchAll(PDO::FETCH_OBJ);
                            if($rows !=null){
                                foreach ($rows as $row){
                                    echo "<option value='{$row->CA_Num}'>{$row->CA_Intitule}</option>";
                                }
                            }
                            ?>
                       </select>
                   </td>
                   <td>
                       <input value="" type="text" name="A_Qte" class="form-control" id="A_Qte"/>
                   </td>
                   <td>
                       <input value="" type="text" name="A_Montant" class="form-control" id="A_Montant"/>
                   </td>
               </tr>
           </thead>
           <tbody>
               <?php 
                /*   $result =  $objet->db->requete($objet->getSaisieAnal(5,1));
                   $rows = $result->fetchAll(PDO::FETCH_OBJ);
                   if($rows !=null){
                       foreach ($rows as $row){
                           echo "<tr id='emodeler_anal_$saisiejourn'>
                                   <td id='tabCA_Num'>".$row->CA_Intitule."</td>
                                   <td id='tabA_Qte'>".$row->EA_Quantite."</td>
                                   <td id='tabA_Montant'>".$row->EA_Montant."</td>
                                   <td id='data' style='visibility:hidden' ><span style='visibility:hidden' id='tabcbMarq'>".$row->cbMarq."</span></td>
                               </tr>";                    
                           $saisiejourn = $saisiejourn + 1;
                       }
                   }
*/
               ?>
               </tbody>
           <tfoot>
               </tfoot>

       </table>
   </div>        
</div>


<div style="display: none;" id="barCode">
    <form id="form1" enctype="multipart/form-data" method="post" action="Upload.aspx">
        <div class="custom-file">
            <label class="custom-file-label" for="fileToUpload">Take or select photo(s)</label><br />
            <input class="custom-file-input" type="file" name="fileToUpload" id="fileToUpload" onchange="fileSelected();" accept="image/*" capture="camera" />
        </div>
        <div id="details"></div>
        <div>
            <input type="button"  class="btn btn-primary" onclick="uploadFile()" value="Valider" />
        </div>
        <div id="progress"></div>
    </form>
    <input type="hidden" id="barCodeValue" value="" />
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
            $("#barCode").hide("slow")
            $("#reference").focus()

        }

        function uploadFailed(evt) {

            alert("There was an error attempting to upload the file.");

        }

        function uploadCanceled(evt) {

            alert("The upload has been canceled by the user or the browser dropped the connection.");

        }

    </script>
</div>