<?php
$prot_no = 0;
if(isset($_POST["protData"]))
    $prot_no = $_POST["protData"];
$objet = new ObjetCollector();
?>
    <script src="js/script_configProfil.js?d=<?php echo time(); ?>"></script>
    <script>
        $( function() {
            $( "#accordion" ).accordion({
                collapsible: true
            });
        } );
    </script>
        <section class="enteteMenu bg-light p-2 mb-3">
            <h3 class="text-center text-uppercase">Configuration accès</h3>
        </section>
        <form id="codeClient" class="codeClient" action="indexMVC.php?module=8&action=10" method="POST">
            <input name="action" value="10" type="hidden"/>
            <input name="module" value="8" type="hidden"/>
            <div class="row">
                <div class="col-6">
                    <label>Profil :</label>
                    <select id="protData" name="protData" class="form-control">
                        <?php
                        $protectionClass = new ProtectionClass("","");
                        $rows = $protectionClass->getProfilAdminMain();
                        if ($rows != null) {
                            foreach ($rows as $row) {
                                echo "<option value='{$row->PROT_No}'";
                                if($prot_no==$row->PROT_No) echo "selected";
                                echo ">{$row->Prot_User}";
                                echo "</option>";
                            }
                        }
                        ?>
                    </select>
                    <input type="button" value="valider" name="valide" id="valide" class="col-12 col-lg-3 mt-2 mb-2 w-100 btn btn-primary"/>
                </div>
                <div id="accordion" class="col-6">
                    <?php
                    $rows = $protectionClass->getProtectionListTitre();
                    if ($rows != null) {
                        foreach ($rows as $row) {
                            echo "<h3>{$row->TE_Intitule}</h3>";
                            $rowstr = $protectionClass->getProtectionListElement($row->TE_No);
                            echo "<div>";
                            if ($rowstr != null) {
                                foreach ($rowstr as $rowtr) {
                                    echo "<p>{$rowtr->TE_Intitule}";
                                    $rowstritem = $protectionClass->getDataUserNo($rowtr->TE_No,$prot_no);
                                    if ($rowstritem != null) {
                                        foreach ($rowstritem as $rowtritem) {
                                            if($rowtritem->TypeFlag==0) {
                                                echo "
                                <span id='TE_No'  style='display: none'>{$rowtritem->TE_No}</span>
                                <select class='form-control' name='selectProtect' id='selectProtect'>
                                <option value='1'";
                                                if ($rowtritem->EPROT_Right == 1) echo "selected";
                                                echo ">écriture</option>
                                <option value='2'";
                                                if ($rowtritem->EPROT_Right == 2) echo "selected";
                                                echo ">lecture et écriture</option>
                                <option value='3'";
                                                if ($rowtritem->EPROT_Right == 3) echo "selected";
                                                echo ">suppression</option>
                                <option value='-1'";
                                                if ($rowtritem->Prot_No == 0) echo "selected";
                                                echo ">aucune</select>";
                                                echo "<input type='hidden' name='modif' id='modif' value='0'/>";
                                            }else{
                                                echo "<span id='TE_No'  style='display: none'>{$rowtritem->TE_No}</span>
                                                <select class='form-control' name='selectProtect' id='selectProtect'>
                                                <option value='0'";
                                                if ($rowtritem->EPROT_Right == 0) echo "selected";
                                                echo ">non</option>
                                                <option value='2'";
                                                if ($rowtritem->EPROT_Right == 2) echo "selected";
                                                echo ">oui</option></select>";
                                                echo "<input type='hidden' name='modif' id='modif' value='0'/>";
                                            }
                                        }
                                    }
                                    echo "</p>";
                                }
                            }
                            echo "</div>";
                        }
                    }

                    ?>
                </div>
            </div>
        </form>
<?php

?>