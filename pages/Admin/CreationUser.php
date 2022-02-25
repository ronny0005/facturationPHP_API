<?php
    $id = 0;
    $username = "";
    $description = "";
    $password = "";
    $email="";
    $designationprofil="";
    $securiteAdmin=0;
    $protectionUser = new ProtectionClass("","");
    if(isset($_GET["id"])){
        $objet = new ObjetCollector();
        $protectionUser->connexionProctectionByProtNo($_GET["id"]);
        $id = $protectionUser->Prot_No;
        $username = $protectionUser->PROT_User;
        $description = $protectionUser->PROT_Description;
        $password = $objet->decrypteMdp($protectionUser->PROT_Pwd);
        $groupeid = $protectionUser->PROT_Right;
        $profiluser= $protectionUser->PROT_UserProfil;
        $email= $protectionUser->PROT_Email;
        $securiteAdmin = $protectionUser->ProtectAdmin;
        //ancien profil
        $protectionProfil = new ProtectionClass("","");
        $protectionProfil->connexionProctectionByProtNo($profiluser);
        $designationprofil = $protectionProfil->PROT_User;
    }
    
//    if(isset($_GET["ajouter"]) ||isset($_GET["modifier"]) ){
//        $username = $_GET["username"];
//        $password = $_GET["password"];
//        $email = $_GET["email"];
//        $groupeid = $_GET["groupeid"];
//        //$profiluser = $_GET["profiluser"];
//        $description= $_GET["description"];
//    }
?>
<script src="js/script_creationUser.js?d=<?php echo time(); ?>"></script>
</head>
<body>    

            <section class="enteteMenu bg-light p-2 mb-3">
                <h3 class="text-center text-uppercase">Fiche utilisateur</h3>
            </section>
    <div class="err" id="add_err"></div>
    <form id="formUser" class="formUser" action="indexMVC.php?module=8&action=4" method="GET">
        <input name="action" value="4" type="hidden"/>
        <input name="module" value="8" type="hidden"/>
		<input name="id" id="id" value="<?= $protectionUser->Prot_No ?>" type="hidden"/>
        <div class="row">
        <div class="col-6" >
            <label> Nom : </label>
            <input value="<?= $protectionUser->PROT_User ?>" name="username" type="text" class="form-control" id="username" placeholder="Nom et prenom"/>
        </div>
        <div class="col-6" >
            <label> Description : </label>
            <input value="<?= $protectionUser->PROT_Description ?>" name="description" type="text" class="form-control" id="description" placeholder="Description"/>
        </div>
        <div class="col-6" >
            <label> Mot de passe : </label>
            <input value="<?= $objet->decrypteMdp($protectionUser->PROT_Pwd) ?>" type="text" class="form-control" name="password" id="password" placeholder="Mot de passe" />
        </div>
        <div class="col-6" >
            <label> Email : </label>
            <input value="<?= $protectionUser->PROT_Email ?>" type="text" class="form-control" name="email" id="email" placeholder="email" />
        </div>
        <div class="col-6 col-lg-3" >
            <label> Groupe : </label>
            <select name="groupeid" class="form-control"  id="groupeid">
               <option value="1" <?= ($protectionUser->PROT_Right == 1) ? " selected " : "" ?>>Administrateurs</option>
               <option value="2" <?= ($protectionUser->PROT_Right == 2) ? " selected " : "" ?>>Utilisateurs</option>
            </select>
        </div>
        <div class="col-6 col-lg-3" >
            <label> Profil Utilisateur : </label>
            <select name="profiluser" class="form-control"  id="profiluser">
                <option value="0">PAS DE PROFIL</option>
                <?php
                $result=$objet->db->requete($objet->getAllProfils());   
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if($rows==null){
                }else{
                    foreach($rows as $row){
                        echo "<option value='{$row->PROT_No}'";
                        if($protectionUser->PROT_UserProfil == $row->PROT_No) echo " selected ";
                        echo ">{$row->PROT_User}</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-6 col-lg-3" >
            <label> Forcer Changement Mot de passe : </label>
            <select name="changepass" class="form-control"  id="changepass">
                <option value="0">NON</option>
                <option value="1">OUI</option>
            </select>
        </div>
        <div class="col-6 col-lg-3" >
            <label> Sécurité admin : </label>
            <select name="securiteAdmin" class="form-control"  id="securiteAdmin">
                <option value="0" <?= ($securiteAdmin==0) ? "selected" : "" ?>>NON</option>
                <option value="1" <?= ($securiteAdmin==1) ? "selected" : "" ?>>OUI</option>
            </select>
        </div>
        <div class="col-6 col-lg-3" >
            <label>Liste des dépôts</label>
            <select class="form-control" id="depot" name="depot[]" multiple>

                <?php
                $result=$objet->db->requete($objet->getDepotUserByUser($id));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if($rows==null){
                }else{
                    foreach($rows as $row){
                        echo "<option value='{$row->DE_No}'";
                        if($row->Valide_Depot==1) echo " selected ";
                        echo ">{$row->DE_No} - {$row->DE_Intitule}</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-6 col-lg-3" >
            <label>Liste des dépôts principaux</label>
            <select class="form-control" id="depotprincipal" name="depotprincipal[]" multiple>
                <?php
                $result=$objet->db->requete($objet->getDepotUserByUser($id));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if($rows==null){
                }else{
                    foreach($rows as $row){
                        if($row->Valide_Depot==1) {
                            echo "<option value={$row->DE_No}";
                            if ($row->IsPrincipal== 1) echo " selected";
                            echo ">{$row->DE_No} - {$row->DE_Intitule}</option>";
                        }
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-6 col-lg-3" >
            <label>Liste emplacement</label>
            <select class="form-control" id="emplacement" name="emplacement[]" multiple>
            </select>
            <input type="button" value="Effacer" id="clearEmpl" class="btn btn-primary mt-3 w-100" />
        </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 col-lg-2" >
                <input type="button" id="ajouterUser" name="ajouterUser" class="btn btn-primary w-100" <?php if(isset($_GET["id"])) echo 'value="Modifier"'; else echo 'value="Ajouter"'; ?> />
            </div>
        </div>
    </form>
        <?php
        
        ?>