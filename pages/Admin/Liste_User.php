<?php
    $objet = new ObjetCollector();   
    $depot=$_SESSION["DE_No"];  
?>
<script src="js/jquery.dynatable.js?d=<?php echo time(); ?>" type="text/javascript"></script>
<script src="js/script_listeUser.js?d=<?php echo time(); ?>"></script>

<div class="corps">
        <input type="hidden" id="mdp" value="<?php echo $_SESSION["mdp"]; ?>"/>
        <input type="hidden" id="login" value="<?php echo $_SESSION["login"]; ?>"/>
   

<fieldset class="card p-3">
    <legend class="text-uppercase text-center bg-light p-2 mb-3">Liste Utilisateurs</legend>
<div class="form-group">
<form action="indexMVC.php?module=8&action=1" method="GET">
    <div class="row float-left">
        <div id="numberRow" class="col-6">
        </div>
        <div class="col-6 my-auto">
        </div>
    </div>
    <div class="row float-right">
        <div id="searchBar" class="col-6">
        </div>
        <div class="col-6 my-auto">
            <a class="btn btn-primary" href="indexMVC.php?module=8&action=4">Nouveau</a>
        </div>
    </div>
<table id="table" class="table table-striped">
        <thead>
            <th>Nom</th>
            <th>Description</th>
            <th>Mail</th>
            <th>Date creation</th>
            <th>Date Modification</th>
            <th>Dernière Connexion</th>
            <th>Profil</th>
            <th>Groupe</th>
        </thead>
    <tbody id="liste_user">
        <?php
        $objet = new ObjetCollector();
        $protection = new ProtectionClass("","");
        $rows = $protection->getListProfil();
        if($rows==null){
        }else{
            foreach ($rows as $row){

            echo "<tr class='user' id='user'>
                    <td><a href='indexMVC.php?module=8&action=4&id={$row->PROT_No}'>{$row->PROT_User}</a></td>
                    <td>{$row->PROT_Description}</td>
                    <td>{$row->PROT_EMail}</td>
                    <td>{$row->PROT_DateCreate}</td>
                    <td>{$row->cbModification}</td>
                    <td>{$row->PROT_LastLoginDate}</td>
                    <td>{$row->Intituleprofil}</td>
                    <td>{$row->Intitulegroupe}</td>
                  </tr>";
            }
        }
        //      ?>
</tbody>
</table>
 </div>   

</div>
