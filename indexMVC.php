<!DOCTYPE html>
<?php
include("importFile.php");
?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Dashboard - Brand</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/untitled.css">
    <!--    <link href="css/bootstrap.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="css/style.css" media="screen" />
    <!--        <link href="css/bootstrap.css" rel="stylesheet"> -->
    <link href="css/jquery-ui.css" rel="stylesheet">
    <link href="css/jquery-ui.theme.css" rel="stylesheet">
    <link href="css/fieldset.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/ionicons.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.23/datatables.min.css"/>
    <link rel="stylesheet" href="css/bootstrap-clockpicker.css"/>
    <link rel="stylesheet" href="css/bootstrap-datepicker.css" />
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/chart.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/jquery-dateformat.js"></script>
    <script src="assets/js/jquery-dateformat.min.js"></script>
    <!--<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>-->
    <script src="js/notify.js"></script>
    <script src="js/jquery_ui.js"></script>
    <!--           <script src="js/bootstrap-3.1.1.min.js"></script> -->
    <script src="js/bootstrap-clockpicker.js"></script>
    <script src="js/scriptCombobox.js"></script>
    <script src="js/jqModal.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.23/datatables.min.js"></script>
    <script src="js/jquery.fileupload.js"></script>
    <script src="js/scriptFonctionUtile.js?d=<?php echo time(); ?>"></script>
    <script src="js/jquery.inputmask.bundle.js"></script>
    <link rel="stylesheet" href="css/select2.min.css">
    <link rel="stylesheet" href="css/select2-bootstrap.css">
    <script src="js/select2.min.js"></script>
    <script>
        jQuery(function ($) {

            (function ($) {
                $(document).ready(function () {
                    $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function (event) {
                        event.preventDefault();
                        event.stopPropagation();
                        $(this).parent().siblings().removeClass('open');
                        $(this).parent().toggleClass('open');
                    });
                });
            })(jQuery);

            $.datepicker.regional['fr'] = {
                closeText: 'Fermer',
                prevText: '&#x3c;Préc',
                nextText: 'Suiv&#x3e;',
                currentText: 'Aujourd\'hui',
                monthNames: ['Janvier','Fevrier','Mars','Avril','Mai','Juin',
                    'Juillet','Aout','Septembre','Octobre','Novembre','Decembre'],
                monthNamesShort: ['Jan','Fev','Mar','Avr','Mai','Jun',
                    'Jul','Aou','Sep','Oct','Nov','Dec'],
                dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
                dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
                dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
                weekHeader: 'Sm',
                dateFormat: 'ddmmyy',
                firstDay: 1
            };
            $.datepicker.setDefaults($.datepicker.regional['fr']);
        }); // End of use strict
    </script>
</head>

<body id="page-top">
<!--<div class="se-pre-con"></div> -->
<div id="wrapper">
    <?php include ("module/Menu/barreMenuGauche.php"); ?>
    <div class="d-flex flex-column" id="content-wrapper">
        <div id="content" style="min-height: 1000px">

            <?php include ("module/Menu/barreMenu.php"); ?>
            <div class="container-fluid">
                <?php
                $module = new Menu(); // Par defaut on fait l'action 1 du module 1
                $action = 1;
                if(isset($_GET['module'])){
                    switch($_GET['module']){
                        case 1 : //Rien a faire, dÃ©jÃ  fait plus haut//$module = new Module1();
                            break;
                        case 2 :
                            $module = new Facturation();
                            break;
                        case 3 :
                            $module = new Creation();
                            break;
                        case 4 :
                            $module = new Mouvement();
                            break;
                        case 5 :
                            $module = new Etat();
                            break;
                        case 6 :
                            $module = new Caisse();
                            break;
                        case 8 :
                            $module = new Admin();
                            break;
                        case 9 :
                            $module = new PlanComptable();
                            break;
                    }
                }
                // On rÃ©cupï¿½&#168;re l'action faite..
                if(isset($_GET['action']))
                    $action = (int)$_GET['action'];
                // On demande au module concernÃ© de gÃ©rer l'action associÃ©e.
                $module->doAction($action);

                //redirection à la page d'accueil a la deconnexion
                if(isset($_GET['action']) && ($_GET['action'] == 'logout'))
                {
                    $_SESSION = array();
                    unset($_SESSION['login']);
                    unset($_SESSION['mdp']);
                    unset($_SESSION["DE_No"]);
                    unset($_SESSION["CT_Num"]);
                    unset($_SESSION["DO_Souche"]);
                    unset($_SESSION["Affaire"]);
                    unset($_SESSION["Vehicule"]);
                    unset($_SESSION["CO_No"]);
                    unset($_SESSION["id"]);
                    session_destroy();
                    ob_get_clean();
                    header("location:index.php");
                }
                ?>
            </div>
        </div>
        <footer class="bg-white sticky-footer">
            <div class="container my-auto">
                <div class="text-center my-auto copyright"><span>Copyright © IT-Solution 2020</span></div>
            </div>
        </footer>
    </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a></div>

</body>

</html>