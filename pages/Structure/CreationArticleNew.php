</head>
<body>
<?php
include("module/Menu/BarreMenu.php");
$objet = new ObjetCollector();
?>
<div id="milieu">
    <div class="container">
        <section class="enteteMenu bg-light p-2 mb-3">
            <h3 class="text-center text-uppercase">Fiche article</h3>
        </section>

        <?php
        $ref = "";
        $design = "";
        $pxAch = "";
        $famille = "";
        $pxVtHT = "";
        $pxVtTTC = "";
        $pxMin="";
        $pxMax="";
        $ar_cond=0;
        $cl_no1 = 0;
        $cl_no2 = 0;
        $cl_no3 = 0;
        $cl_no4 = 0;
        $fcl_no1 = 0;
        $fcl_no2 = 0;
        $fcl_no3 = 0;
        $fcl_no4 = 0;
        $CT_PrixTTC = 0;

        $flagProtected = $protection->protectedType("article");
        $flagSuppr = $protection->SupprType("article");
        $flagNouveau = $protection->NouveauType("article");

        $result=$objet->db->requete($objet->typeArticle());
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if($rows!=null){
            $CT_PrixTTC= $rows[0]->CT_PrixTTC;
        }




        if(isset($_GET["AR_Ref"])){
            $objet = new ObjetCollector();
            $result=$objet->db->requete($objet->getArticleByArRef($_GET["AR_Ref"]));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            $i=0;
            $classe="";
            if($rows==null){
            }else{
                $ref = $rows[0]->AR_Ref;
                $design = $rows[0]->AR_Design;
                $pxAch = str_replace(".",",",round($rows[0]->AR_PrixAch,2));
                $famille = $rows[0]->FA_CodeFamille;
                $ar_cond = $rows[0]->AR_Condition;
                $pxVtHT = str_replace(".",",",round($rows[0]->AR_PrixVen,2));
                $pxMin = str_replace(".",",",round($rows[0]->Prix_Min,2));
                $pxMax = str_replace(".",",",round($rows[0]->Prix_Max,2));
                $cl_no1 = $rows[0]->CL_No1;
                $cl_no2 = $rows[0]->CL_No2;
                $cl_no3 = $rows[0]->CL_No3;
                $cl_no4 = $rows[0]->CL_No4;
                $CT_PrixTTC= $rows[0]->AR_PrixTTC;
                if(isset($famille)){
                    $objet = new ObjetCollector();
                    $result=$objet->db->requete($objet->getFamilleByCode($famille));
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    $i=0;
                    $classe="";
                    if($rows==null){
                    }else{
                        $fcl_no1 = $rows[0]->CL_No1;
                        $fcl_no2 = $rows[0]->CL_No2;
                        $fcl_no3 = $rows[0]->CL_No3;
                        $fcl_no4 = $rows[0]->CL_No4;
                    }
                }
            }
        }
        $PrixTTC_Design = "HT";
        if($CT_PrixTTC==1) $PrixTTC_Design = "TTC";
        function valTTC($id){
            if($id==1) return "TTC";
            else return "HT";
        }
        ?>
<script src="js/script_creationArticle.js?d=<?php echo time(); ?>"></script>
    <form action="indexMVC.php?module=3&action=1" method="GET" id="formArticle">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#FichePrincipale" role="tab" aria-controls="FichePrincipale" aria-selected="true">Fiche principale</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#Complement" role="tab" aria-controls="Complement" aria-selected="false">Complément</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#Descriptif" role="tab" aria-controls="Descriptif" aria-selected="false">Descriptif</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="FichePrincipale" role="tabpanel" aria-labelledby="home-tab">1...</div>
            <div class="tab-pane fade" id="Complement" role="tabpanel" aria-labelledby="profile-tab">2...</div>
            <div class="tab-pane fade" id="Descriptif" role="tabpanel" aria-labelledby="contact-tab">3...</div>
        </div>
    </form>