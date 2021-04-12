
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
<form action="indexMVC.php?module=5&action=8" method="GET">
    <div class="form-group col-lg-2" >
            <label>Début</label>
            <input type="hidden" value="<?php echo $_SESSION["DE_No"];?>" id="de_no" />
            <input type="hidden" value="5" name="module"/>
            <input type="hidden" value="8" name="action"/>
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
                                $rows = $comptet->allClients();
                                $depot="";
                                    foreach($rows as $row){
                                        echo "<option value='{$row->CT_Num}'";
                                        if($row->CT_Num==$clientdebut) echo " selected";
                                        echo ">{$row->CT_Num} - {$row->CT_Intitule}</option>";
                                    }
                                ?>
                            </select>
            <label>à </label>
            <select class="form-control" name="clientfin" id="clientfin">
                                <option value="0">Tous</option>
                                <?php
                                $comptet = new ComptetClass(0);
                                $rows = $comptet->allClients();
                                foreach($rows as $row){
                                        echo "<option value='{$row->CT_Num}'";
                                        if($row->CT_Num==$clientfin) echo " selected";
                                        echo ">{$row->CT_Num} - {$row->CT_Intitule}</option>";
                                    }
                                ?>
                            </select>
    </div>
    <div class="form-group col-lg-3" >
            <label>Centre</label>
            <select class="form-control" name="depot" id="depot">
                <?php
                $depotClass = new DepotClass(0);
                if($admin==0){
                    $rows = $depotClass->getDepotUser($_SESSION["id"]);
                }
                else {
                    echo"<option value='0'";
                    if(0==$depot_no) echo " selected";
                    echo ">Tous</option>";
                    $depotClass = new DepotClass(0);
                    $rows = $depotClass->all();
                }
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
    <div class="form-group col-lg-2" >
        <input type="submit" id="valider" class="btn btn-primary" value="Valider"/>
        <input type="submit"  class="btn btn-primary" value="Imprimer" <?php  echo "onClick=\"window.open('./export/exportReleveCompteClient.php?datedeb=".$datedeb."&datefin=".$datefin."&depot=".$depot_no."&clientdebut=".$clientdebut."&clientfin=".$clientfin."')\""; ?> />
    </div>
    
</form>
<table id="table" class="table table-striped table-bordered" cellspacing="0">
    <thead>
    <tr>
            <th>Date</th>
            <th>Livraison</th>
            <th>Retard</th>
            <th>Piece</th>
            <th>BL</th>
            <th>Net à payer</th>
            <th>Règlement</th>
            <th>Solde</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $result=$objet->db->requete($objet->releveCompteClient($depot_no, $objet->getDate($datedeb),$objet->getDate($datefin),0));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $classe="";
        if($rows==null){
            echo "<tr><td>Aucun élément trouvé ! </td></tr>";
        }else{
            foreach ($rows as $row){
                $i++;
            if($i%2==0) $classe = "info";
                    else $classe="";
                echo "<tr class='eqstock $classe'>
                        <td>{$objet->getDateDDMMYYYY($row->DO_DATE)}</td>
                        <td>{$objet->getDateDDMMYYYY($row->DR_DATE)}</td>
                        <td>{$row->RETARD}</td>
                        <td>{$row->DO_PIECE}</td>
                        <td>{$row->DO_REF}</td>
                        <td>{$objet->formatChiffre($row->NET_VERSER)}</td>
                        <td>{$objet->formatChiffre($row->REGLEMENT)}</td>
                        <td>{$objet->formatChiffre($row->cumul)}</td>
                    </tr>";
            }
            
        }
        
    ?>
        </tbody>
    </table>
