<?php
$typeTiers=0;
if(isset($_GET["typeTiers"]))
    $typeTiers = $_GET["typeTiers"];
?>
<script src="js/jquery.dynatable.js" type="text/javascript"></script>
<script src="js/script_etat.js"></script>
<script src="js/script_listefacturation.js"></script>
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
<form action="indexMVC.php?module=5&action=6" method="GET">
    <div class="form-group col-lg-2" >
            <label>Début</label>
            <input type="hidden" value="<?php echo $_SESSION["DE_No"];?>" id="de_no" />
            <input type="hidden" value="5" name="module"/>
            <input type="hidden" value="22" name="action"/>
            <input type="hidden" value="<?php echo $typeTiers; ?>" name="typeTiers"/>
            <input type="text" class="form-control" name="datedebut" style="width : 100px" value="<?php echo $datedeb; ?>" id="datedebut" placeholder="Date" />
            <label>Fin</label>
            <input type="text" class="form-control" name="datefin"  style="width : 100px" value="<?php echo $datefin; ?>" id="datefin" placeholder="Date" />
    </div>
    <div class="form-group col-lg-2" >
            <label>Client de</label>
            <select class="form-control" name="clientdebut" id="clientdebut">
                                <option value="0">Tous</option>
                                <?php
                                $comptet = new ComptetClass(0);
                                if($typeTiers==0)
                                $rows = $comptet->allClients();
                                else
                                $rows = $comptet->allFournisseur();

                                foreach($rows as $row){
                                    echo "<option value=".$row->CT_Num."";
                                    if($row->CT_Num==$clientdebut) echo " selected";
                                    echo ">".$row->CT_Num." - ".$row->CT_Intitule."</option>";
                                }
                                ?>
                            </select>
            <label>à </label>
            <select class="form-control" name="clientfin" id="clientfin">
                                <option value="0">Tous</option>
                                <?php
                                $comptet = new ComptetClass(0);
                                if($typeTiers==0)
                                $rows = $comptet->allClients();
                                else
                                $rows = $comptet->allFournisseur();
                                    foreach($rows as $row){
                                        echo "<option value=".$row->CT_Num."";
                                        if($row->CT_Num==$clientfin) echo " selected";
                                        echo ">".$row->CT_Num." - ".$row->CT_Intitule."</option>";
                                    }
                                ?>
                            </select>
    </div>
    <div class="form-group col-lg-3" >
            <label>Centre</label>
            <select class="form-control" name="depot" id="depot">
                    <?php
                        echo"<option value='0'";
                        if(0==$depot_no) echo " selected";
                        echo ">Tous</option>";
                    $depotClass = new DepotClass(0);
                    if($admin==0){
                        $rows = $depotClass->getDepotUser($_SESSION["id"]);
                    }
                    else {
                        $depotClass = new DepotClass(0);
                        $rows = $depotClass->all();
                    }
                    if($rows==null){
                    }else{
                        foreach($rows as $row){
                            echo "<option value=".$row->DE_No."";
                            if($row->DE_No==$depot_no) echo " selected";
                            echo ">".$row->DE_Intitule."</option>";
                        }
                    }
                    ?>
                </select>
            <label>Rupture par agence</label>
        <input style="margin:auto" name="rupture" class="checkbox-inline" id="rupture" type="checkbox" value="1" <?php if($rupture==1) echo "checked";?> />
    </div>
    <div class="form-group col-lg-2" >
        <label>Type Facture</label>
        <select class="form-control" name="facComptabilise" id="facComptabilise">
            <option value="0" <?php if($facComptabilise==0) echo " selected "; ?>>Tous</option>
            <option value="1" <?php if($facComptabilise==1) echo " selected "; ?>>Facture</option>
            <option value="2" <?php if($facComptabilise==2) echo " selected "; ?>>Facture Comptabilisée</option>
        </select>
    </div>
    <div class="form-group col-lg-2" >
        <label>Type de reglement</label>
        <select class="form-control" name="type_reg" id="type_reg">
            <option value="-1" <?php if($type_reg==-1) echo " selected "; ?>>Tous</option>
            <option value="0" <?php if($type_reg==0) echo " selected "; ?>>Non réglé</option>
            <option value="1" <?php if($type_reg==1) echo " selected "; ?>>Réglé</option>
        </select>
        <input type="submit" id="valider" class="btn btn-primary" value="Valider"/>
        <input type="submit"  class="btn btn-primary" value="Imprimer" <?php  echo "onClick=\"window.open('./export/exportEcheanceClient.php?type=mvtStock&datedeb=".$datedeb."&datefin=".$datefin."&depot=".$depot_no."&rupture=".$rupture."&clientdebut=".$clientdebut."&clientfin=".$clientfin."&type_reg=".$type_reg."&typeTiers=".$typeTiers."&facComptabilise=".$facComptabilise."')\""; ?> />
    </div>
</form>

<?php
$totalMontantG=0;
$totalMontantAvanceG=0;
$totalResteAPayerG=0;
$result=$objet->db->requete($objet->depot());
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    foreach($rows as $row){
        if(($rupture==0 && $cmp==0)|| $rupture==1){
            if($depot_no==0 || $depot_no==$row->DE_No){
                $val=0;
                if($rupture==1 || $depot_no==$row->DE_No){
                    echo "<div style='clear:both'><h3 style='text-align:center'>".$row->DE_Intitule."</h3></div>";
                    $val=$row->DE_No;
                }
                $etat = new EtatClass();

        $rows=$etat->ech_client($val, $objet->getDate($datedeb),$objet->getDate($datefin),$clientdebut,$clientfin,$type_reg,$facComptabilise,$typeTiers);
        $i=0;
   ?>
<table id="table" class="table table-striped table-bordered" cellspacing="0">
    <tr>
        <th>Piece</th>
        <th>N° Tiers</th>
        <th>Montant facture</th>
        <th>Règlement</th>
    </tr>
    <?php

         $classe="";
        if($rows==null){
            echo "<tr><td>Aucun élément trouvé ! </td></tr>";
        }else{
            $totalttc=0;
            $totalrc=0;
            $totalreste=0;
            foreach ($rows as $row){
                $i++;
            if($i%2==0) $classe = "info";
                    else $classe="";
                echo "<tr class='eqstock $classe'>";
                echo "<td>".$row->DO_Piece."</td>"
                ."<td>".$row->Tiers."</td>"
                ."<td>".$objet->formatChiffre(ROUND($row->DL_MontantTTC,2))."</td>"
                ."<td>".$objet->formatChiffre(ROUND($row->RG_Montant,2))."</td>"
                . "</tr>";
                $totalttc=$totalttc+ROUND($row->DL_MontantTTC,2);
                $totalrc=$totalrc + ROUND($row->RG_Montant,2) ;
            }
            echo "<tr style='background-color: #46464be6;color: white;font-weight: bold;'><td>Total</td>";
            echo "<td></td><td>".$objet->formatChiffre($totalttc)."</td><td>".$objet->formatChiffre($totalrc)."</td></tr>";
            $totalMontantG=$totalMontantG+$totalttc;
            $totalMontantAvanceG=$totalMontantAvanceG+$totalrc;
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
        <td style="padding:10px">Montant : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalMontantG); ?></td>
        <td style="padding:10px">Somme règlement : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalMontantAvanceG); ?></td>
    </tr>
</table>
<?php
    }
?>