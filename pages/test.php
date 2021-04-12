<?php
    include("../Modele/DB.php");
    include("../Modele/ObjetCollector.php");
    session_start();
    $objet = new ObjetCollector(); 
    $affaire="";
    $souche="";
    $co_no=0;
    $depot_no=0;
    $client="";
    $caisse = 0;
    $type=0;
    $treglement=0;
    $caissier = 0;
    $datedeb=date("Y-m-d");
    $datefin=date("Y-m-d");
    
    $result=$objet->db->requete($objet->getParametre($_SESSION["id"]));     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if($rows==null){
    }else{ 
        $caisse=$rows[0]->CA_No;
        $souche=$rows[0]->CA_Souche;
        $co_no=$rows[0]->CO_No;
        $depot_no=$rows[0]->DE_No;
    }
    if(isset($_GET["client"])) $client=$_GET["client"];
    if(isset($_GET["type"])) $type=$_GET["type"];
    if(isset($_GET["acte"]) && $_GET["acte"]=="Valider"){ 
        $date = $_GET["date"];
        $libelle = $_GET["libelle"];
        $montant = $_GET["montant"];
        $objet->addReglement($client,1,$date,$montant,$libelle,0);     
    }
?>
        <script src="../js/scriptRecouvrement.js"></script>
        <script src="../js/scriptCombobox.js" type="text/javascript"></script>
 </head>
<body>    
<div id="milieu">    
    <div class="container">
       <input type="hidden" id="mdp" value="<?php echo $_SESSION["mdp"]; ?>"/>
        <input type="hidden" id="login" value="<?php echo $_SESSION["login"]; ?>"/>
        <div class="container">
            <div class="col-md-12">
                <fieldset class="entete">
                    <legend class="entete">Entete</legend>
                    <form id="form-client" action="indexMVC.php?action=2&module=1" method="GET" class="form-horizontal" >
                        <input type="hidden" value="1" name="module"/>
                        <input type="hidden" value="2" name="action"/>
                        <input type="hidden" value="<?php echo $co_no; ?>" id="co_no" name="co_no"/>
 
                        <div class="form-group">

                            <label for="inputdateofbirth" class="col-md-1 control-label">Client</label>
                            <div class="col-md-3">
                                <select class="form-control" name="client" id="client">
                                    <?php
                                        $result=$objet->db->requete($objet->allClients());     
                                        $rows = $result->fetchAll(PDO::FETCH_OBJ);
                                        $depot="";
                                        if($rows==null){
                                        }else{
                                            foreach($rows as $row){
                                                echo "<option value=".$row->CT_Num."";
                                                if($row->CT_Num==$client) echo " selected";
                                                echo ">".$row->CT_Intitule."</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <label for="inputdateofbirth" class="col-md-1 control-label">Caisse </label>
                            <div class="col-md-2">
                                <select class="form-control" name="caisse" id="caisse">
                                    <?php
                                        $result=$objet->db->requete($objet->caisse());     
                                        $rows = $result->fetchAll(PDO::FETCH_OBJ);
                                        $depot="";
                                        if($rows==null){
                                        }else{
                                            foreach($rows as $row){
                                                echo "<option value=".$row->CA_No."";
                                                if($row->CA_No==$caisse) echo " selected";
                                                echo ">".$row->CA_Intitule."</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" style="width:200px" name="type" id="type">
                                    <option value="-1">Tout les règlements</option>
                                    <option value="1">Règlements imputés</option>
                                    <option value="0">Règlements non imputés</option>
                                </select>
                            </div>

                            <div class="col-md-1">
                                <input type="submit" class="btn btn-success" name="rechercher" id="recherche" value="Rechercher"/>
                            </div>




                        </div>

                    </form>
                </fieldset>

                <fieldset class="entete">
                    <form id="form-valider" action="indexMVC.php?action=2&module=1" method="GET" class="form-horizontal">
                        <input type="hidden" value="1" name="module"/>
                        <input type="hidden" value="2" name="action"/>
                        <legend class="entete">Ligne</legend>
                        <div class="form-group">
                            <div class="col-md-2">
                                <input type="text" class="form-control" id="dateRec" name="date" placeholder="Date" />
                            </div>
                            <div class="col-md-5">
                                <input type="text" class="form-control" id="libelleRec" name="libelle" placeholder="Libelle" />
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" id="montantRec" name="montant" placeholder="Montant" />
                            </div>
                            <div class="col-md-1">
                                <input name="client" id="client_valide" type="hidden" value="2" name="action"/>
                                <input type="submit" class="btn btn-success" name="acte" id = "validerRec" value="Valider" />
                            </div>
                        </div>
                    </form>

                    <div class="form-group">
                        <table class="table" id="tableRecouvrement">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Libelle</th>
                                    <th>Montant</th>
                                    <th>Solde</th>
                                    <th>Caisse</th>
                                    <th>Caissier</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $result=$objet->db->requete($objet->getReglementByClient($client,$caisse,$type,$treglement,$datedeb,$datefin,$caissier));     
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
                                        echo "<tr class='reglement $classe' id='reglement_".$row->RG_No."'>"
                                                . "<td>".$row->RG_Date."</td>"
                                                . "<td>".$row->RG_Libelle."</td>"
                                                . "<td id='RG_Montant'>".round($row->RG_Montant)."</td>"
                                                . "<td id='RC_Montant'>".round($row->RC_Montant)."</td>"
                                                . "<td>".$row->CA_Intitule."</td>"
                                                . "<td>".$row->CO_NoCaissier."</td>"
                                                . "<td style='display:none' id='RG_No'>".$row->RG_No."</td>"
                                                . "<td style='display:none' id='RG_Impute'>".$row->RG_Impute."</td>"
                                                . "</tr>";
                                        }
                                    }

                                ?>
                            </tbody>
                        </table>
                        <table class="table" id="tableFacture">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Libelle</th>
                                    <th>Référence</th>
                                    <th>Avance</th>
                                    <th>TTC</th>
                                </tr>
                            </thead>
                            <tbody id="Listefacture">
                            </tbody>
                        </table>
 
                    </div>

                </fieldset>

            </div>
        </div>
