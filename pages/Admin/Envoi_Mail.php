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
<script src="js/script_envoiMail.js?d=<?php echo time(); ?>"></script>
</head>
<body>    
<?php
include("module/Menu/BarreMenu.php");
?>
</head>
<div id="milieu">    
    <div class="container">

        <div class="container clearfix">
            <section class="enteteMenu bg-light p-2 mb-3">
                <h3 class="text-center text-uppercase">Envoi mail</h3>
            </section>
        </div>
    <form id="codeClient" class="codeClient" action="indexMVC.php?module=8&action=7" method="GET">
        <input name="action" value="7" type="hidden"/>
        <input name="module" value="8" type="hidden"/>
        <input name="boolenvoiMail" id="boolenvoiMail" value="<?= $boolenvoiMail ?>" type="hidden"/>
        <input name="id" value="<?= $id ?>" type="hidden"/>
        <table class="table" id="table">
            <thead>
                <th></th>
                <?php
                    $protectionClass = new ProtectionClass("","");
                    if($boolenvoiMail==1) {
                        $envoiMail = new LiaisonEnvoiMailUser();
                        $rows = $envoiMail->getEnvoiMailLib();
                        if ($rows != null) {
                            foreach ($rows as $row) {
                                echo "<th>{$row->TE_Intitule}</th>";
                            }
                        }
                    }else{
                        $envoiMail = new LiaisonEnvoiSMSUser();
                        $rows = $envoiMail->getEnvoiSMSLib();
                        if ($rows != null) {
                            foreach ($rows as $row) {
                                echo "<th>{$row->TE_Intitule}</th>";
                            }
                        }
                    }
                ?>
            </thead>
            <tbody>
                <?php
                $protectionClass = new ProtectionClass("","");
                $rows = $protectionClass->getUserAdminMain();
                if($rows!=null) {
                    foreach ($rows as $row) {
                        $valueProfil = $row->PROT_No_User;
                        $color = "white";
                        $protValue = $row->PROT_No_User;
                        if($valueProfil == 0){
                            $color = "#4d4f53";
                            $protValue = $row->PROT_No;
                        }
                        echo "<tr style='background-color: $color' id='ligneTENo'><td><span id='PROT_No_Profil' style='display: none'>" . $row->PROT_No . "</span>" . $row->Prot_User . "</td>";
                        if($boolenvoiMail==1) {
                            $envoiMail = new LiaisonEnvoiMailUser();
                            $rowstr = $envoiMail->getDataUser($protValue);
                            if ($rowstr != null) {
                                foreach ($rowstr as $rowtr) {
                                    echo "<td id='blocValue'>
                                        <span id='TE_No' style='display: none'>{$rowtr->TE_No}</span>
                                        <input type='checkbox' ";
                                    if ($rowtr->Prot_No == 1) echo "checked";
                                    echo "/></span>";
                                }
                            }
                        }else{
                            $envoiMail = new LiaisonEnvoiSMSUser();
                            $rowstr = $envoiMail->getDataUser($protValue);
                            if ($rowstr != null) {
                                foreach ($rowstr as $rowtr) {
                                    echo "<td id='blocValue'>
                                        <span id='TE_No' style='display: none'>{$rowtr->TE_No}</span>
                                        <input type='checkbox' ";
                                    if ($rowtr->Prot_No == 1) echo "checked";
                                    echo "/></span>";
                                }
                            }
                        }
                        echo "<td id='PROT_No' style='display: none'>{$row->PROT_No_User}</td></tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </form>