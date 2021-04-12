<?php
$objet = new ObjetCollector();

?>
<script>
    jQuery(function($) {
        $("#topVenteMoisDate").select2({
            theme: "bootstrap"
        }).on("select2:select", function (e) {
            $.ajax({
                url: "indexServeur.php?page=top10Vente",
                method: 'GET',
                dataType: 'html',
                data : "flagPrixRevient="+$("#flagPxRevient").val()+"&month="+$("#topVenteMoisDate").val()+"&period=MONTH",
                success: function (data) {
                    $("#topVenteMois").html(data)
                }
            });
        });
        $("#DetteMoisDate").select2({
            theme: "bootstrap"
        }).on("select2:select", function (e) {
            $.ajax({
                url: "indexServeur.php?page=detteMois",
                method: 'GET',
                dataType: 'html',
                data : "protNo="+$("#PROT_No").val()+"&month="+$("#DetteMoisDate").val(),
                success: function (data) {
                    $("#tableDetteMois").html(data)
                }
            });
        });


        $("#dateTopVenteJour").datepicker({
            dateFormat: "dd",
            altFormat: "dd",
            autoclose: true,
            onSelect: function(dateText, inst) {
                $.ajax({
                    url: "indexServeur.php?page=top10Vente",
                    method: 'GET',
                    dataType: 'html',
                    data : "flagPrixRevient="+$("#flagPxRevient").val()+"&month="+$("#dateTopVenteJour").val()+"&period=DAY",
                    success: function (data) {
                        $("#topVenteJour").html(data)
                    }

                });
            }

        }).focus(function () {
            $(".ui-datepicker-next").hide();
            $(".ui-datepicker-prev").hide();
        }).datepicker("setDate", new Date());


    })
</script>
<section>
    <?php
    $arrayDateMonth = array("1"=> "Janvier","2" =>"Févier","3" =>"Mars","4" =>"Avril","5" =>"Mai","6" =>"Juin","7" =>"Juillet"
        ,"8" =>"Aout","9" =>"Septembre","10" =>"Octobre","11" =>"Novembre","12" =>"Décembre")   ;

    $etat = new EtatClass();
    $list =  $etat->top10Vente("MONTH");
    $listTopVenteJour =  $etat->top10Vente("DAY");
    $listStatCaisseDuJour =  $etat->statCaisseDuJour($_SESSION["id"]);
    $listTopDetteMois =  $etat->detteDuMois($_SESSION["id"]);
    $protectioncial = new ProtectionClass("","");
    $protectioncial->connexionProctectionByProtNo($_SESSION["id"]);
    $flagPxRevient = $protectioncial->PROT_PX_REVIENT;
    if ($protectioncial->PROT_Right == 1 || ($protectioncial->PROT_ETAT_STAT_ARTICLE_PAR_ART == 0)){
    ?>
    <div class="row">
        <input type="hidden" value="<?= $flagPxRevient ?>" id="flagPxRevient"/>
        <div class="col-12 col-sm-6">
            <div class="col-12 text-center mb-3">
                <h5>Top Vente du mois</h5>
            </div>

            <div class="table-responsive mt-3">
                <div class="col p-0 mb-2">
                    <select id="topVenteMoisDate" class="form-control">
                        <?php
                        foreach ($arrayDateMonth as $key => $value)
                        {
                            echo "<option value='{$key}'";
                            if(date('m') == $key) echo " selected ";
                                echo ">{$value}</option>";
                        }
                        ?>
                    </select>
                </div>
                <table id="topVenteMois" style="color:black; font-size: 10px" class="table table-striped mt-3" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Désignation</th>
                    <th style="width: 150px">CA</th>
                    <?php if($flagPxRevient==0) echo "<th style=\"width: 150px\">Marge</th>" ?>
                </tr>
                </thead>
                <tbody>
                    <?php
                    $totalCATTCNet = 0;
                    $totalMarge = 0;
                    foreach ($list as $value){
                        $totalCATTCNet = $totalCATTCNet +$value->CATTCNet;
                        $totalMarge = $totalMarge +$value->Marge;
                        ?>
                        <tr>
                            <td><?= $value->AR_Design ?></td>
                            <td class="text-right"><?= $objet->formatChiffre($value->CATTCNet) ?></td>
                            <?php if($flagPxRevient==0) echo "<td class=\"text-right\">{$objet->formatChiffre($value->Marge)}</td>" ?>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
                <tfoot class="font-weight-bold">
                    <td>Total</td>
                    <td class="text-right"><?= $objet->formatChiffre($totalCATTCNet) ?></td>
                    <?php if($flagPxRevient==0) echo "<td class='text-right'>{$objet->formatChiffre($totalMarge)}</td>"; ?>
                </tfoot>
                </table>
            </div>
        </div>
        <div class="col-12 col-sm-6">
            <table style="color:black" class="table table-striped">
                <div class="col-12 text-center mb-3">
                    <h5>Top Vente du jour</h5>
                </div>
                <div class="row">
                    <div class="col-1 my-auto"> Jour : </div>
                    <div class="col-11"><input type="text" class="form-control" id="dateTopVenteJour" /></div>
                </div>
                <table id="topVenteJour"  class="table table-striped mt-3" style="color:black; font-size: 10px">
                    <thead>
                    <tr>
                        <th>Désignation</th>
                        <th style="width: 100px">CA</th>
                        <?php if($flagPxRevient==0) echo "<th style=\"width: 100px\">Marge</th>" ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $totalCATTCNet = 0;
                    $totalMarge = 0;
                    foreach ($listTopVenteJour as $value){
                        $totalCATTCNet = $totalCATTCNet +$value->CATTCNet;
                        $totalMarge = $totalMarge +$value->Marge;
                        ?>
                        <tr>
                            <td><?= $value->AR_Design ?></td>
                            <td class='text-right'><?= $objet->formatChiffre($value->CATTCNet) ?></td>
                            <?php if($flagPxRevient==0) echo "<td class='text-right'>{$objet->formatChiffre($value->Marge)}</td>" ?>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                    <tfoot class="font-weight-bold">
                        <td>Total</td>
                        <td class="text-right"><?= $objet->formatChiffre($totalCATTCNet) ?></td>
                        <?php if($flagPxRevient==0) echo "<td class='text-right'>{$objet->formatChiffre($totalMarge)}</td>"; ?>
                    </tfoot>
                </table>
            </table>
        </div>
    </div>
        <?php
        }

        ?>
    <div class="row">
    <?php
            if ($protectioncial->PROT_Right == 1 || ($protectioncial->PROT_ETAT_CAISSE_MODE_RGLT == 0)){
?>
            <div class="col-12 col-sm-6">
                <div class="col-12 text-center mb-3">
                    <h5>Statistique caisse</h5>
                </div>
                <table id="statCaisse" class="table table-striped" style="color:black;font-size: 10px">
                    <thead>
                    <tr>
                        <th>Caisse</th>
                        <th style="width: 100px">Entrée</th>
                        <th style="width: 100px">Sortie</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $totalDebit = 0;
                    $totalCredit = 0;
                    foreach ($listStatCaisseDuJour as $value){
                        $totalDebit = $totalDebit + $value->DEBIT;
                        $totalCredit = $totalCredit + $value->CREDIT;
                        ?>
                        <tr>
                            <td><?= $value->CA_Intitule ?></td>
                            <td class="text-right"><?= $objet->formatChiffre($value->CREDIT) ?></td>
                            <td class="text-right"><?= $objet->formatChiffre($value->DEBIT) ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                    <tfoot class="font-weight-bold">
                        <td>Total</td>
                        <td class="text-right"><?= $objet->formatChiffre($totalCredit) ?></td>
                        <td class="text-right"><?= $objet->formatChiffre($totalDebit) ?></td>
                    </tfoot>
                </table>
            </div>
        <?php
            }
    if ($protectioncial->PROT_Right == 1 || ($protectioncial->PROT_ETAT_RELEVE_ECH_CLIENT == 0)){

    ?>
            <div class="col-12 col-sm-6">
                <table style="color:black" id="detteMois" class="table table-striped">
                    <div class="col-12 text-center mb-3">
                        <h5>Dette du mois</h5>
                    </div>
                    <div class="col p-0 mb-2">
                        <select id="DetteMoisDate" class="form-control">
                            <?php
                            foreach ($arrayDateMonth as $key => $value)
                            {
                                echo "<option value='{$key}'";
                                if(date('m') == $key) echo " selected ";
                                echo ">{$value}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <table id="tableDetteMois" class="table table-striped" style="color:black;font-size: 10px">
                        <thead>
                        <tr>
                            <th>Intitule</th>
                            <th style="width: 100px">Reste à payer</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $totalResteAPayer = 0;
                        foreach ($listTopDetteMois as $value){
                            $totalResteAPayer = $totalResteAPayer + $value->Reste_A_Payer;
                            ?>
                            <tr>
                                <td><?= $value->CT_Intitule ?></td>
                                <td class="text-right"><?= $objet->formatChiffre($value->Reste_A_Payer) ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                        <tfoot class="font-weight-bold">
                            <td>Total</td>
                            <td class="text-right"><?= $objet->formatChiffre($totalResteAPayer) ?></td>
                        </tfoot>
                    </table>
                </table>
            </div>
        </div>
<?php
    }
?>
</section>



