</head>
<body>    
<?php
$flagProtected = $protection->protectedType("famille");
$flagSuppr = $protection->SupprType("famille");
$flagNouveau = $protection->NouveauType("famille");

?>
        <section class="enteteMenu bg-light p-2 mb-3">
            <h3 class="text-center text-uppercase">
                Fiche famille
            </h3>
        </section>
<!DOCTYPE html>
<?php
    $ref = "";
    $design = "";
    $cl_no1 = 0;
    $cl_no2 = 0;
    $cl_no3 = 0;
    $cl_no4 = 0;
    
    if(isset($_GET["FA_CodeFamille"])){
        $objet = new ObjetCollector();   
        $result=$objet->db->requete($objet->getFamilleByCode($_GET["FA_CodeFamille"]));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $classe="";
        if($rows==null){
        }else{
            $ref = $rows[0]->FA_CodeFamille;
            $design = $rows[0]->FA_Intitule;
            $cl_no1 = $rows[0]->CL_No1;
            $cl_no2 = $rows[0]->CL_No2;
            $cl_no3 = $rows[0]->CL_No3;
            $cl_no4 = $rows[0]->CL_No4;
        }
    }
?>
    <div class="err" id="add_err"></div>    
        <script src="js/script_creationFamille.js?d=<?php echo time(); ?>"></script>
<body>
    <form action="indexMVC.php?module=3&action=1" method="GET">
        <div class="row">
            <div class="col-lg-6" >
                <input type="hidden" value="3" name="module"/>
                <input type="hidden" value="1" name="action"/>
                <label for="inputfirstname" class="control-label"> Code : </label>
                <input maxlength="11" onkeyup="this.value=this.value.replace(' ','')" type="text" value="<?php echo $ref; ?>" name="reference" class="form-control only_alpha_num" id="reference" placeholder="Référence" <?php if(isset($_GET["FA_CodeFamille"])) echo "disabled"; ?>/>
            </div>
            <div class="col-lg-6" >
                <label for="inputfirstname" class="control-label"> Intitulé     : </label>
                <input maxlength="35" type="text" value="<?php echo $design; ?>"  name="designation" class="form-control" id="designation" placeholder="Intitulé" <?php if(!$flagProtected) echo "disabled"; ?> />
            </div>
        </div><br/>

        <div class="row mt-3">

        <div class="col-lg-6">
        <fieldset class="card p-3">
            <legend class="entete">Catalogue</legend>
            <div class="form-group">
                Niveau 1 : <select id="catalniv1" class="form-control" <?php if(!$flagProtected) echo "disabled"; ?>>
                    <option value="0"></option>
                    <?php
                        $objet = new ObjetCollector();   

                        $result=$objet->db->requete($objet->getCatalogue(0));     
                        $rows = $result->fetchAll(PDO::FETCH_OBJ);
                        if($rows==null){
                        }else{
                            foreach ($rows as $row){
                            echo "<option value='".$row->CL_No."'";
                                    if($row->CL_No==$cl_no1) echo " selected";
                                    echo">".$row->CL_Intitule."</option>";
                            }
                        }
                      ?>
                </select><br/>
                Niveau 2 : <select id="catalniv2" class="form-control" <?php if($cl_no1!=0) if(!$flagProtected) echo "disabled"; else echo""; else echo "disabled";?>>
                <option value="0"></option>
                <?php
                        $objet = new ObjetCollector();   
                        $result=$objet->db->requete($objet->getCatalogueChildren(1,$cl_no1)); 
                        $rows = $result->fetchAll(PDO::FETCH_OBJ);
                        if($rows==null){
                        }else{
                            foreach ($rows as $row){
                            echo "<option value='".$row->CL_No."'";
                                    if($row->CL_No==$cl_no2) echo " selected";
                                    echo">".$row->CL_Intitule."</option>";
                            }
                        }
                      ?></select><br/>
                      
                Niveau 3 : <select id="catalniv3" class="form-control" <?php if($cl_no1!=0) if(!$flagProtected) echo "disabled"; else echo""; else echo "disabled";?>>
                <option value="0"></option>
                <?php
                        $objet = new ObjetCollector();   
                        $result=$objet->db->requete($objet->getCatalogueChildren(2,$cl_no2)); 
                        $rows = $result->fetchAll(PDO::FETCH_OBJ);
                        if($rows==null){
                        }else{
                            foreach ($rows as $row){
                            echo "<option value='".$row->CL_No."'";
                                    if($row->CL_No==$cl_no3) echo " selected";
                                    echo">".$row->CL_Intitule."</option>";
                            }
                        }
                      ?></select><br/>
                Niveau 4 : <select id="catalniv4" class="form-control" <?php if($cl_no1!=0) if(!$flagProtected) echo "disabled"; else echo""; else echo "disabled";?>>
                <option value="0"></option>
                <?php
                        $objet = new ObjetCollector();   
                        $result=$objet->db->requete($objet->getCatalogueChildren(3,$cl_no3)); 
                        $rows = $result->fetchAll(PDO::FETCH_OBJ);
                        if($rows==null){
                        }else{
                            foreach ($rows as $row){
                            echo "<option value='".$row->CL_No."'";
                                    if($row->CL_No==$cl_no4) echo " selected";
                                    echo">".$row->CL_Intitule."</option>";
                            }
                        }
                      ?></select>
            </div>
        </fieldset>
        </div>
        <?php
        $taxe1 =" - ";$taxe2 =" - ";$taxe3 =" - ";$cgnum=" - ";$cgnuma=" - ";
        $libtaxe1 ="";$libtaxe2 ="";$libtaxe3 ="";$libcgnum="";$libcgnuma="";
        $taux1 =0;$taux2 =0;$taux3 =0;
        $result=$objet->db->requete($objet->getCatComptaByCodeFamille($ref,1,0));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if($rows!=null){
            if($rows[0]->Taxe1!="")
                $taxe1 =$rows[0]->Taxe1;

            if($rows[0]->Taxe2!="")
                $taxe2 =$rows[0]->Taxe2;

            if($rows[0]->Taxe3!="")
                $taxe3 =$rows[0]->Taxe3;

            if($rows[0]->CG_Num!="")
                $cgnum=$rows[0]->CG_Num;
            if($rows[0]->CG_NumA!="")
                $cgnuma=$rows[0]->CG_NumA;
            $libtaxe1 =$rows[0]->TA_Intitule1;$libtaxe2 =$rows[0]->TA_Intitule2;$libtaxe3 =$rows[0]->TA_Intitule3;
            $libcgnum=$rows[0]->CG_Intitule;$libcgnuma=$rows[0]->CG_IntituleA;
            $taux1 =$rows[0]->TA_Taux1;$taux2 =$rows[0]->TA_Taux2;$taux3 =$rows[0]->TA_Taux3;
        }
        ?>
        <div class="col-lg-6">
            <table id="table_compteg" class="table table-striped">
                <thead>
                <tr style="background-color: #dbdbed;"><th>
                        <select name="p_catcompta" id="p_catcompta" class="form-control" <?php if(!$flagProtected) echo "disabled"; ?>>
                            <?php
                            $catCompta = new CatComptaClass(0);
                            $rows = $catCompta->getCatCompta();

                            foreach ($rows as $row) {
                                echo "<option value='{$row->idcompta}V'>{$row->marks}</option>";
                            }
                            $rows = $catCompta->getCatComptaAchat();
                            foreach ($rows as $row) {
                                echo "<option value='{$row->idcompta}A'>{$row->marks}</option>";
                            }
                            ?>
                        </select>
                    </th><th>Compte/Code</th><th>Intitulé</th><th>Taux</th></tr>
                </thead>
                <tbody>
                <tr><td id='libCompte'>Compte général</td><td id="codeCompte" style='text-decoration: underline;color:blue'><?php echo $cgnum; ?></td><td id="intituleCompte"><?php echo $libcgnum; ?></td><td id="valCompte"></td></tr>
                <tr><td id='libCompte'>Section analytique</td><td id="codeCompte" style='text-decoration: underline;color:blue'></td><td id="intituleCompte"></td><td id="valCompte"></td></tr>
                <tr><td id='libCompte'>Code taxe 1</td><td id="codeCompte" style='text-decoration: underline;color:blue'><?php echo $taxe1; ?></td><td id="intituleCompte"><?php echo $libtaxe1; ?></td><td id="valCompte"><?php echo $objet->formatChiffre($taux1); ?></td></tr>
                <tr><td id='libCompte'>Code taxe 2</td><td id="codeCompte" style='text-decoration: underline;color:blue'><?php echo $taxe2; ?></td><td id="intituleCompte"><?php echo $libtaxe2; ?></td><td id="valCompte"><?php echo $objet->formatChiffre($taux2); ?></td></tr>
                <tr><td id='libCompte'>Code taxe 3</td><td id="codeCompte" style='text-decoration: underline;color:blue'><?php echo $taxe3; ?></td><td id="intituleCompte"><?php echo $libtaxe3; ?></td><td id="valCompte"><?php echo $objet->formatChiffre($taux3); ?></td></tr>
                </tbody>
            </table>
            <div id="formSelectCompte">
                    <div class="col-12">
                        <label id="labelCode">Code</label>
                        <select class="form-control" id="CodeSelect<?php if(!$flagProtected) echo "disabled"; ?>" name="CodeSelect" <?php if(!$flagProtected) echo "disabled"; ?>>
                        </select>
                    </div>
            </div>
        </div>
            <div class="col-12">
                <input class="btn btn-primary" type="button" id="ajouter" name="<?php if(isset($_GET["AR_Ref"])) echo "modifier"; else echo "ajouter"; ?>" value="Valider" <?php if(!$flagProtected) echo "disabled"; ?>/>
            </div>
        </div>
        </form>
        
        