<?php

$objet = new ObjetCollector();
$login = "";
if(isset($_SESSION["login"]))
    $login = $_SESSION["login"];
$mdp = "";
if(isset($_SESSION["mdp"]))
    $mdp = $_SESSION["mdp"];
$protection = new ProtectionClass($login, $mdp,$objet->db);
$docEntete = new DocEnteteClass(0,$objet->db);

$menu = $protection->BarreMenu($_SESSION["id"],$_GET["module"],$_GET["action"],(isset($_GET["type"])?$_GET["type"] : ""),"gauche");

?>
<nav class="navbar navbar-dark bg-light align-items-start sidebar sidebar-dark accordion p-0 shadow" style="display:none;background-color: rgb(255,255,255);background-image: url(&quot;none&quot;);width: 222px;">
    <div class="container-fluid d-flex flex-column p-0">
        <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="accueil">
            <div class="sidebar-brand-icon"><img src="assets/img/it_solution.png" style="width: 66px;"></div>
            <div class="sidebar-brand-text mx-3"></div>
        </a>
        <hr class="sidebar-divider my-0">
        <ul class="nav navbar-nav text-light" id="accordionSidebar">
            <?php
            foreach ($menu as $menuItem){
            if(sizeof($menuItem->subMenu)>0){
            ?>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><?= $menuItem->menuName ?></a>
                <div class="dropdown-menu" role="menu">
                <?php
                    foreach ($menuItem->subMenu as $subMenu) {
                        if (isset($subMenu->active) && $subMenu->active != "")
                            $titleMenu = $subMenu->menuName;
                        ?>
                        <a class="dropdown-item <?= (isset($subMenu->active)) ? $subMenu->active : "" ?>" role="presentation" href="<?= $subMenu->link ?>"><?= $subMenu->menuName ?></a>
                    <?php
                    }
                    ?>
                </div>
            </li>
            <?php
            }else{
            ?>
            <li class="nav-item" role="presentation">
                <a class="<?= (isset($menuItem->active)) ? $menuItem->active : "" ?> nav-link" href="<?= $menuItem->link ?>"><span><?= $menuItem->menuName ?></span></a>
            </li>
            <?php
            }
            }
            ?>
        </ul>
       <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button" style="background-color: #007bff;color: rgb(255,255,255);"></button></div>
        <div><input id="machineName" style="visibility:hidden;" value="<?= gethostname(); ?>"/></div>
    </div>
</nav>


