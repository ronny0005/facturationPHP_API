
<script src="js/jquery.dynatable.js?d=<?php echo time(); ?>" type="text/javascript"></script>
<script src="js/script_etat.js?d=<?php echo time(); ?>"></script>
</head>
<body>
<?php
include("module/Menu/BarreMenu.php");
include("enteteParam.php");
?>
<div id="milieu">
    <div class="container">

        <div class="container clearfix">
            <h4 id="logo" style="text-align: center;background-color: #eee;padding: 10px;text-transform: uppercase">
                <?php echo $texteMenu; ?>
            </h4>
        </div>
        <form action="indexMVC.php?module=5&action=19" method="GET">
            <div class="form-group col-lg-2" >
                <label>Début</label>
                <input type="hidden" value="<?php echo $_SESSION["DE_No"];?>" id="de_no" />
                <input type="hidden" value="5" name="module"/>
                <input type="hidden" value="19" name="action"/>
                <input type="text" class="form-control" name="datedebut" style="width : 100px" value="<?php echo $datedeb; ?>" id="datedebut" placeholder="Date" />
            </div>
            <div class="form-group col-lg-2" >
                <label>Fin</label>
                <input type="text" class="form-control" name="datefin"  style="width : 100px" value="<?php echo $datefin; ?>" id="datefin" placeholder="Date" />
            </div>
            <div class="form-group col-lg-3" >
                <label>Centre</label>
                <select class="form-control" name="depot" id="depot">
                    <?php
                    $depotClass = new DepotClass(0);
                    //if($admin==0){
                    //     $rows = $depotClass->getDepotUserPrincipal($_SESSION["id"]);
                    //}
                    //else {
                        echo"<option value='0'";
                        if(0==$depot_no) echo " selected";
                        echo ">Tous</option>";
                        $depotClass = new DepotClass(0);
                        $rows = $depotClass->all();
                    //}
                    if($rows==null){
                    }else{
                        foreach($rows as $row){
                            echo "<option value='{$row->DE_No}'";
                            if($row->DE_No==$depot_no) echo " selected";
                            echo ">{$row->DE_Intitule}</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group col-lg-3" >
                <label>Famille</label>
                <select class="form-control" id="famille" name="famille"><option value="0">Tous</option>
                    <?php
                    $familleClass= new FamilleClass(0);
                    foreach($familleClass->getShortList() as $row){
                        echo "<option value='{$row->FA_CodeFamille}'";
                        if(isset($_GET["famille"]) && $row->FA_CodeFamille==$famille) echo " selected";
                        echo ">{$row->FA_Intitule}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group col-lg-2" >
                <label>Article</label>
                <select  class="form-control" id="article" name="article"><option value="0">Tous</option>
                    <?php
                    $articleClass = new ArticleClass(0);
                    foreach($articleClass->getShortList() as $row){
                        echo "<option value='{$row->AR_Ref}'";
                        if(isset($_GET["article"]) && $row->AR_Ref==$article) echo " selected";
                        echo ">{$row->AR_Design}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group col-lg-2" >
                <label>Type</label>
                <select name="do_type" id="do_type" class="form-control">
                    <option value="7" <?php if($do_type==7) echo "selected"; ?>>FC </option>
                    <option value="6" <?php if($do_type==6) echo "selected"; ?>>FC + FA</option>
                    <option value="3" <?php if($do_type==3) echo "selected"; ?>>FC + FA + BL</option>
                </select>
            </div>
            <div class="form-group col-lg-2" >
                <label>Rupture par agence</label>
                <input style="margin:auto" name="rupture" class="checkbox" id="rupture" type="checkbox" value="1" <?php if($rupture==1) echo "checked";?> />
            </div>
            <div class="form-group col-lg-3">
                <input type="submit" id="valider" class="btn btn-primary" value="Valider"/>
                <input type="submit"  class="btn btn-primary" value="Imprimer" <?php  echo "onClick=\"window.open('./export/exportStatArticleParAgenceAchat.php?type=mvtStock&datedeb=".$datedeb."&datefin=".$datefin."&depot=".$depot_no."&rupture=".$rupture."&article=".$article."&famille=".$famille."&do_type=".$do_type."')\""; ?> />
            </div>
        </form>

        <?php

        $totalCANetHTG=0;
        $totalPrecompteG=0;
        $totalCANetTTCG=0;
        $totalQteVendueG=0;
        $totalMargeG=0;
        $result=$objet->db->requete($objet->depot());
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        foreach($rows as $row){
            if(($rupture==0 && $cmp==0)|| $rupture==1){
                if($depot_no==0 || $depot_no==$row->DE_No){
                    $val=0;
                    if($rupture==1 || $depot_no==$row->DE_No){
                        echo "<div style='clear:both'><h3 style='text-align:center'>{$row->DE_Intitule}</h3></div>";
                        $val=$row->DE_No;
                    }

                    $result=$objet->db->requete($objet->stat_articleParAgenceAchat($val, $objet->getDate($datedeb),$objet->getDate($datefin),$famille,$article,$do_type));
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    $i=0;
                    $canetht=0;
                    $canetttc=0;
                    $precompte=0;
                    $qte=0;
                    $marge=0;
                    $margeca=0;
                    $classe="";

                    ?>
                    <table id="table" class="table table-striped table-bordered" cellspacing="0">
                        <tr>
                            <th>Référence</th>
                            <th>Désignation</th>
                            <th>CA Net HT</th>
                            <th>Precompte</th>
                            <th>CA Net TTC</th>
                            <th>Quantités achetées</th>
                        </tr>
                        <?php
                        if($rows==null){
                            echo "<tr><td>Aucun élément trouvé ! </td></tr>";
                        }else{
                            foreach ($rows as $row){
                                $i++;
                                if($i%2==0) $classe = "info";
                                else $classe="";
                                echo "<tr class='eqstock $classe'>
                                        <td>{$row->AR_Ref}</td>
                                        <td>{$row->AR_Design}</td>
                                        <td>{$objet->formatChiffre(ROUND($row->TotCAHTNet,2))}</td>
                                        <td>{$objet->formatChiffre(ROUND($row->PRECOMPTE,2))}</td>
                                        <td>{$objet->formatChiffre(ROUND($row->TotCATTCNet,2))}</td>
                                        <td>{$objet->formatChiffre(ROUND($row->TotQteVendues,2))}</td>
                                </tr>";
                                $canetht=$canetht+ROUND($row->TotCAHTNet,2);
                                $canetttc=$canetttc+ROUND($row->TotCATTCNet,2);
                                $precompte=$precompte+ROUND($row->PRECOMPTE,2);
                                $qte=$qte+ROUND($row->TotQteVendues,2);
                                $marge=$marge+ROUND($row->TotPrxRevientU,2);
                                $totalCANetHTG=$totalCANetHTG+ROUND($row->TotCAHTNet,2);
                                $totalPrecompteG=$totalPrecompteG+ROUND($row->PRECOMPTE,2);
                                $totalCANetTTCG=$totalCANetTTCG+ROUND($row->TotCATTCNet,2);
                                $totalQteVendueG=$totalQteVendueG+ROUND($row->TotQteVendues,2);
                                $totalMargeG=$totalMargeG+ROUND($row->TotPrxRevientU,2);
                            }
                            $totmargepourc=0;
                            if($canetht>0)$totmargepourc=ROUND($marge/$canetht*100,2);
                            echo "<tr style='background-color: #46464be6;color: white;font-weight: bold;'>";
                            echo "<td>Total</td><td></td><td>".$objet->formatChiffre($canetht)."</td><td>".$objet->formatChiffre($precompte)."</td><td>".$objet->formatChiffre($canetttc)."</td>";
                            echo "<td>".$objet->formatChiffre($qte)."</td>";
                            echo "</tr>";
                        }

                        ?>
                    </table>
                    <?php
                }
            }
            $cmp++;
        }
        if($rupture==1){

            ?>
            <table>
                <tr style='background-color: #46464be6;color: white;font-weight: bold;'>
                    <td style="padding:10px">CA Net HT : </td>
                    <td style="padding:10px"><?php echo $objet->formatChiffre($totalCANetHTG); ?></td>
                    <td style="padding:10px">Precompte : </td>
                    <td style="padding:10px"><?php echo $objet->formatChiffre($totalPrecompteG); ?></td>
                    <td style="padding:10px">CA Net TTC : </td>
                    <td style="padding:10px"><?php echo $objet->formatChiffre($totalCANetTTCG); ?></td>
                    <td style="padding:10px">Quantités Achetées : </td>
                    <td style="padding:10px"><?php echo $objet->formatChiffre($totalQteVendueG); ?></td>
                </tr>
            </table>
            <?php
        }
        ?>

        <div style="width:500px;float:left;height:300px;margin-right: 20px" id="chartContainer"></div>
        <div style="width:500px;float:right;height:300px" id="chartContainer2"></div>
