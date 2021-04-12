
<script src="js/jquery.dynatable.js" type="text/javascript"></script>
<script src="js/script_etat.js"></script>
<?php
$objet = new ObjetCollector();
include("enteteParam.php");
?>
<section class="enteteMenu bg-light p-2 mb-3">
    <h3 class="text-center text-uppercase">Etat des dettes</h3>
</section>
<form action="indexMVC.php?module=5&action=10" method="GET">
    <input type="hidden" value="5" name="module"/>
    <input type="hidden" value="10" name="action"/>
    <div class="row">
        <div class="col-6 col-lg-2">
            <label>Début</label>
            <input type="text" class="form-control" name="datedebut" value="<?php echo $datedeb; ?>" id="datedebut" placeholder="Date" />
        </div>
        <div class="col-6 col-lg-2">
            <label>Fin</label>
            <input type="text" class="form-control" name="datefin" value="<?php echo $datefin; ?>" id="datefin" placeholder="Date" />
        </div>
        <div class="col-6 col-lg-2">
            <label>Agence</label>
            <select class="form-control" name="depot" id="depot">
                <?php
                $depotClass = new DepotClass(0,$objet->db);
                if($admin==0){
                    $rows = $depotClass->getDepotUser($_SESSION["id"]);
                }
                else {
                    echo"<option value='0'";
                    if(0==$depot_no) echo " selected";
                    echo ">Tous</option>";
                    $rows = $depotClass->all();
                }
                foreach($rows as $row){
                    echo "<option value={$row->DE_No}";
                    if($row->DE_No==$depot_no) echo " selected";
                    echo ">{$row->DE_Intitule}</option>";
                }
                ?>
            </select>
        </div>

        <div class="col-6 col-lg-2">
            <label>Client</label>
            <select class="form-control" name="ClientDebut" id="ClientDebut">
            <?php
                $comptetClass= new ComptetClass($clientdebut,$objet->db);
                    echo "<option value='{$comptetClass->CT_Num}' selected>{$comptetClass->CT_Intitule}</option>";
                ?>
            </select>
        </div>
        <div class=" mt-4 col-6 col-lg-2">
            <input style="float:right" type="submit" id="valider" class="btn btn-primary w-100" value="Valider"/></div>
        <div class=" mt-4 col-6 col-lg-2">
            <input style="float:right;margin-right:20px" type="submit"  class="btn btn-primary  w-100" value="Imprimer" <?php  echo "onClick=\"window.open('./export/exportEtatDette.php?datedebut={$datedeb}&datefin={$datefin}&depot={$depot_no}&clientdebut={$clientdebut}')\""; ?>/></div>
    </div>
</form>
<?php 
    $depotClass = new DepotClass(0, $objet->db);
    if($rows!=null){
        foreach($depotClass->all() as $row){
            $val_depot=$row->DE_No;
            if($depot_no==0 || $depot_no==$row->DE_No){
            
            echo "<div class='row text-center'><h4 class='mt-3'>{$row->DE_Intitule}</h4></div>";
       
?>
<div class="table-responsive mt-3">
<table id="table" class="table table-striped table-bordered" cellspacing="0" >
    <thead>
        <tr style="text-transform: uppercase">
            <th>Numéro client</th>
            <th>Nom client</th>
            <th>Montant</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $etatList = new EtatClass();
    $rows = $etatList->etatDette($val_depot,$objet->getDate($datedeb), $objet->getDate($datefin),'',$clientdebut);
        $i=0;
        $qte=0; 
        $cumul=0;
        $dlprix=0;
        $cumulPrix=0;
        $somMnt=0;
        $classe="";
        $ref="";
        if($rows==null){
            echo "<tr><td colspan='3'>Aucun élément trouvé ! </td></tr>";
        }else{
            foreach ($rows as $row){
                $somMnt=$somMnt+ROUND($row->MONTANT,2);
                $i++;
            if($i%2==0) $classe = "info";
                    else $classe="";
                echo "<tr class='eqstock $classe'>
                    <td><a href='indexMVC.php?action=17&module=5&DE_No=$val_depot&CT_Num={$row->CT_NUM}&datedebut=$datedeb&datefin=$datefin'>{$row->CT_NUM}</a></td>
                <td>{$row->CT_Intitule}</td>
                <td>{$objet->formatChiffre(ROUND($row->MONTANT,2))}</td>
                </tr>";
            }
        echo "<tr style='background-color: #46464be6;color: white;font-weight: bold;'><td colspan='2' >Total</td><td>{$objet->formatChiffre($somMnt)}</td></tr>";
        }
        
    ?>
        </tbody>
    </table>
</div>
        <?php 
        }
        
        }
    }
        ?>
