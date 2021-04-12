<?php
$id = 0;
$username = "";
$description = "";
$password = "";
$email="";
$depot_no="";
$caisse_no="";
$objet = new ObjetCollector();
$boolenvoiMail=1;
if($_GET["action"]==8)
    $boolenvoiMail=0;
?>
    <script src="js/script_configProfilUtilisateur.js?d=<?php echo time(); ?>"></script>
            <section class="enteteMenu bg-light p-2 mb-3">
                <h3 class="text-center text-uppercase"><?= $titleMenu; ?></h3>
            </section>
            <form id="codeClient" class="codeClient" action="indexMVC.php?module=8&action=7" method="GET">
                <input name="action" value="7" type="hidden"/>
                <input name="module" value="8" type="hidden"/>
                <input name="boolenvoiMail" id="boolenvoiMail" value="<?php echo $boolenvoiMail; ?>" type="hidden"/>
                <input name="id" value="<?php echo "$id"; ?>" type="hidden"/>
                <table class="table table-striped" id="table">
                    <thead>
                    <th></th>
                    <?php
                    $protectionClass = new ProtectionClass("","");
                    $rows = $protectionClass->getProfilAdminMain();
                    if ($rows != null) {
                        foreach ($rows as $row) {
                            echo "<th>{$row->Prot_User}</th>";
                        }
                    }

                    ?>
                    </thead>
                    <tbody>
                    <?php
                    $protectionClass = new ProtectionClass("","");
                    $rows = $protectionClass->getUtilisateurAdminMain();
                    if($rows!=null) {
                        foreach ($rows as $row) {
                            $valueProfil = $row->PROT_No_User;
                            $color = "white";
                            $protValue = $row->PROT_No_User;
                            if($valueProfil == 0){
                                $color = "white";
                                $protValue = $row->PROT_No;
                            }
                            echo "<tr style='background-color: $color' id='ligneTENo'>
            <td><span id='PROT_No_Profil' style='display: none'>{$row->PROT_No}</span>{$row->Prot_User}</td>";
                            $rowstr = $protectionClass->getDataUserProfil($protValue);
                            if ($rowstr != null) {
                                foreach ($rowstr as $rowtr) {
                                    echo "<td id='blocValue'>
                                        <span id='TE_No' style='display: none'>{$rowtr->TE_No}</span>
                                        <input type='checkbox' ";
                                    if ($rowtr->Prot_No == 1) echo "checked";
                                    echo "/></span>";
                                }
                            }
                            echo "<td id='PROT_No' style='display: none'>{$row->PROT_No_User}</td></tr>";
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </form>
<?php

?>