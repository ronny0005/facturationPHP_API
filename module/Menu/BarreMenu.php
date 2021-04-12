<?php
$admin=0;
$vente=0;
$reglt=0;
$profil_caisse=0;
$profil_special=0;
$profil_commercial=0;
$profil_daf=0;
$profil_superviseur=0;
$profil_gestionnaire=0;
$qte_negative = 0;
$objet = new ObjetCollector();
$flag_minMax = 0;
$flagPxRevient = 0;
$flagPxAchat = 0;
$flagDateMvtCaisse = 0;
$flagDateVente = 0;
$flagDateAchat = 0;
$flagDateStock = 0;
$flagProtApresImpression = 0;
$flagModifClient = 0;
$flagPxVenteRemise = 0;
$login = "";
if(isset($_SESSION["login"]))
    $login = $_SESSION["login"];
$mdp = "";
if(isset($_SESSION["mdp"]))
    $mdp = $_SESSION["mdp"];
$protection = new ProtectionClass($login, $mdp,$objet->db);
$result=$objet->db->requete($objet->getParametrecial());
$rows = $result->fetchAll(PDO::FETCH_OBJ);
if($rows[0]->P_GestionPlanning==1 || $protection->getPrixParCatCompta()==1)
    $flag_minMax = $rows[0]->P_GestionPlanning;
$titleMenu ="";
if($protection->Prot_No!=""){

    if($_GET["module"]==1 && $_GET["action"]==1)
        $texteMenu="Accueil";
    if($_GET["module"]==1 && $_GET["action"]==2)
        $texteMenu="Règlement client";
    if($_GET["module"]==7 && ($_GET["action"]==1 || $_GET["action"]==2))
        $texteMenu="Factures d'achat";
    if($_GET["module"]==6 && $_GET["action"]==1)
        $texteMenu="Caisse";
    if($_GET["module"]==1 && $_GET["action"]==3)
        $texteMenu="Saisie d'inventaire";
    if($_GET["module"]==1 && $_GET["action"]==6)
        $texteMenu="Mot de passe";
    if($protection ->PROT_Administrator==1 || $protection ->PROT_Right==1)
        $admin=1;
    $vente=$protection ->PROT_DOCUMENT_VENTE;
    $qte_negative= $protection ->PROT_QTE_NEGATIVE;
    $rglt=$protection ->PROT_DOCUMENT_REGLEMENT;
    $flagPxRevient = $protection ->PROT_PX_REVIENT;
    $flagPxAchat = $protection ->PROT_PX_ACHAT;
    $flagProtCatCompta = $protection->PROT_CATCOMPTA;
    $flagPxVenteRemise = $protection ->PROT_SAISIE_PX_VENTE_REMISE;
    $flagDateRglt = $protection ->PROT_DATE_RGLT;
    $flagModifClient = $protection->PROT_MODIFICATION_CLIENT;
    $flagRisqueClient = $protection ->PROT_RISQUE_CLIENT;
    $flagCtrlTtCaisse = $protection ->PROT_CTRL_TT_CAISSE;
    $flagAffichageValCaisse = $protection ->PROT_AFFICHAGE_VAL_CAISSE;
    $flagModifSupprComptoir = $protection->PROT_MODIF_SUPPR_COMPTOIR;
    $flagInfoLibreArticle = $protection ->PROT_INFOLIBRE_ARTICLE;
    $flagDateMvtCaisse = $protection ->PROT_DATE_MVT_CAISSE;
    $flagDateVente = $protection ->PROT_DATE_VENTE;
    $flagDateAchat = $protection ->PROT_DATE_ACHAT;
    $flagDateStock = $protection ->PROT_DATE_STOCK;
    $flagProtApresImpression = $protection ->PROT_APRES_IMPRESSION;
    if($protection ->ProfilName=="VENDEUR" || $protection ->ProfilName=="GESTIONNAIRE")
        $profil_caisse=1;
    if($protection ->ProfilName=="COMMERCIAUX")
        $profil_commercial=1;
    if($protection ->ProfilName=="RAF" ||$protection ->ProfilName=="GESTIONNAIRE" ||$protection ->ProfilName=="SUPERVISEUR" )
        $profil_special =1;
    if($protection ->ProfilName=="RAF")
        $profil_daf=1;
    if($protection ->ProfilName=="SUPERVISEUR")
        $profil_superviseur=1;
    if($protection ->ProfilName=="GESTIONNAIRE")
        $profil_gestionnaire=1;
//$lien="http://209.126.69.121/ReportServer/Pages/ReportViewer.aspx?%2fEtatFacturation%2fAccueil&rs:Command=Render&droit=$profil_commercial";
$lien="http://209.126.69.121/ReportServer/Pages/ReportViewer.aspx?%2fEtatBiopharma%2fACCUEIL&rs:Command=Render&droit=$profil_commercial";
    $menu = $protection->BarreMenu($_SESSION["id"],$_GET["module"],$_GET["action"],(isset($_GET["type"])?$_GET["type"] : ""),"Haut");


    ?>
        <script>
            $(function() {
                // ------------------------------------------------------- //
                // Multi Level dropdowns
                // ------------------------------------------------------ //
                $("ul.dropdown-menu [data-toggle='dropdown']").on("click", function(event) {
                    event.preventDefault();
                    event.stopPropagation();

                    $(this).siblings().toggleClass("show");


                    if (!$(this).next().hasClass('show')) {
                        $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
                    }
                    $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
                        $('.dropdown-submenu .show').removeClass("show");
                    });

                });
            });
        </script>
        <style>
            .dropdown-submenu {
                position: relative;
            }

            .dropdown-submenu>a:after {
                content: "\f0da";
                float: right;
                border: none;
                font-family: 'FontAwesome';
            }

            .dropdown-submenu>.dropdown-menu {
                top: 0;
                left: 100%;
                margin-top: 0px;
                margin-left: 0px;
            }
        </style>
    <nav class="navbar navbar-expand-lg navbar-light bg-light py-1 shadow-sm mb-3">
        <button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
        <div id="navbarContent" class="">
            <ul class="navbar-nav mr-auto">
                <!-- Level one dropdown -->
                <?php
                foreach ($menu as $menuItem){
                    if(is_array($menuItem->subMenu) && sizeof($menuItem->subMenu)>0){
                        ?>
                        <li class="<?= isset($menuItem->class) ? $menuItem->class:"" ?> nav-item dropdown">
                            <a id="dropdownMenu1" href="<?= $menuItem->link ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">
                                <?= $menuItem->menuName ?>
                            </a>
                            <ul aria-labelledby="dropdownMenu1" class="dropdown-menu border-0 shadow" style="width: 250px;">
                                <?php
                                foreach ($menuItem->subMenu as $subMenu){
                                    if(is_array($subMenu->subMenu) && sizeof($subMenu->subMenu)>0){
                                        ?>
                                        <li class="<?= isset($subMenu->class) ? $subMenu->class:"" ?> dropdown-submenu">
                                            <a id="dropdownMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">
                                                <?= $subMenu->menuName ?></a>
                                            <ul aria-labelledby="dropdownMenu2" class="dropdown-menu border-0 shadow" style="width: 250px;">
                                                <?php
                                                foreach ($subMenu->subMenu as $subMenu2){
                                                    if($subMenu2->active!="") {
                                                        $titleMenu = $subMenu2->menuName;
                                                        $_SESSION->titleName = $titleMenu;
                                                    }
                                                    ?><li>
                                                    <a tabindex="-1" href="<?= $subMenu2->link ?>" class="<?= isset($subMenu2->active) ? $subMenu2->active : "" ?> dropdown-item <?= isset($subMenu2->class) ? $subMenu2->class:"" ?> "><?= $subMenu2->menuName ?></a>
                                                    </li>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </li>
                                        <?php
                                    }else{
                                        if(isset($subMenu->active) && $subMenu->active!="") {
                                            $titleMenu = $subMenu->menuName;
                                            $_SESSION->titleName = $titleMenu;
                                        }
                                        ?>
                                        <li><a href="<?= $subMenu->link ?>" class="<?= isset($subMenu->active) ? $subMenu->active : "" ?> <?= isset($subMenu->class) ? $subMenu->class:"" ?> dropdown-item"><?= $subMenu->menuName ?></a></li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </li>
                        <?php
                    }else{
                        ?>

                        <li class="nav-item <?= isset($menuItem->class) ? $menuItem->class:"" ?>"><a href="<?= $menuItem->link ?>" class="<?= isset($menuItem->active) ? $menuItem->active : "" ?> nav-link"><?= $menuItem->menuName ?></a></li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>

        <span class="navbar-text pl-3">
            <span id="userName" class="d-none"><?php echo $_SESSION["login"]; ?></span>
            Bienvenue <span id="userNameLogin" ><?php echo $_SESSION["login"]; ?>
            <a href="index.php?action=logout">Déconnexion <i class="fa fa-sign-out"></i></a>
            <span id="machineName" style="visibility:hidden; width:1px"><?php echo gethostname(); ?></span>
            <input type="hidden" id="PROT_No" value="<?= $protection->Prot_No; ?>"/>
        </span>
    </nav>
<?php
}
?>
