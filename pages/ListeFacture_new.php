<?php
    $objet = new ObjetCollector();
    $depot=$_SESSION["DE_No"];
    $datedeb=date("dmy");
    $datefin=date("dmy");
    include("module/Menu/BarreMenu.php");

    $client='0';
    if(isset($_GET["datedebut"]) && $_GET["datedebut"]!="")
        $datedeb=$_GET["datedebut"];
    if(isset($_GET["datefin"]) && $_GET["datefin"]!="")
        $datefin=$_GET["datefin"];
    if(isset($_GET["depot"]) && !empty($_GET["depot"]))
        $depot=$_GET["depot"];  
    if(isset($_GET["client"]) && !empty($_GET["client"]))
        $client=$_GET["client"];  

    $type=$_GET["type"];
    $admin=0;
    if($protection->PROT_Administrator==1 || $protection->PROT_Right==1)
        $admin=1;

    $typeListe= "documentVente";
    if($type=="Sortie" || $type=="Entree" || $type=="Transfert" || $type=="TransfertDetail")
    $typeListe = "documentStock";
    if($type=="Achat" || $type=="AchatC" || $type=="AchatT" || $type=="PreparationCommande" || $type=="AchatPreparationCommande")
    $typeListe = "documentAchat";
    $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
    $protected = $protection->protectedType($type);
    $protectedSuppression = $protection->SupprType($typeListe);
    $protectedNouveau = $protection->NouveauType($type);
    $action=0;
    if(isset($_GET["action"])) $action = $_GET["action"];
    if(isset($_GET["module"])) $module = $_GET["module"];
    $titre="";
function lienfinal($statut,$avance,$entete,$type,$depot,$admini,$cbMarq,$do_domaine,$do_type,$do_modif,$administrateur,$protectedDocP,$flagProtApresImpressionP){

    if($type!="VenteDevise")
    if($do_domaine ==0 && $do_type==6)
        $type="Vente";
    if($do_domaine ==0 && $do_type==7)
        $type="VenteC";
    if($do_domaine ==1 && $do_type==16)
        $type="Achat";
    if($do_domaine ==1 && $do_type==17)
        $type="AchatC";
    if($type=="BonLivraison" ||$type == "Vente"||$type == "VenteDevise" ||$type == "VenteC"||$type == "VenteT" ||$type == "AchatC" ||$type == "AchatT" || $type == "Achat"|| $type == "PreparationCommande"|| $type == "AchatPreparationCommande"){
    $complement="&modif=1";
    if($administrateur==1)
        $complement="&modif=1";
    else {
        if($do_modif==1){
            $complement="&visu=1";
        }
            else{
            if($protectedDocP==0){
                $complement="&visu=1";
            }else{
                if($flagProtApresImpressionP!=0){
                    $complement="&visu=1";
                }else{
                    if($statut=="comptant" || $avance>"0"){
                        $complement="&visu=1";
                    }
                }
            }
            }
            }


     return lien($entete, $depot, $type, $cbMarq) . $complement;
/*    if( $flagProtApresImpressionP !=0 || $protectedDocP==0 || ($statut=="comptant" || $avance>"0" || ($do_modif==1 && $administrateur==0))) {
        return lien($entete, $depot, $type, $cbMarq) . "&visu=1";
    }
    else {
            return lien($entete, $depot, $type, $cbMarq) . "&modif=1";
    }*/
}
else {
    if($protectedDocP==0)
        return lien($entete, $depot, $type, $cbMarq) . "&visu=1";
    else
        return lien($entete, $depot, $type, $cbMarq) . "&modif=1";
}
}

function lien ($entete,$depot,$type,$cbMarq){
    $lienentete="";
        $lienfinal="";
        if($entete!="")
            $lienentete="&cbMarq=".$cbMarq."&entete=".$entete;
    if($type=="Vente")
        $lienfinal = "indexMVC.php?module=2&action=3".$lienentete."&type=".$type."&depot=".$depot;
    if($type=="VenteC")
        $lienfinal = "indexMVC.php?module=2&action=3".$lienentete."&type=".$type."&depot=".$depot;
    if($type=="VenteT")
        $lienfinal = "indexMVC.php?module=2&action=3".$lienentete."&type=Vente&depot=".$depot;
    if($type=="BonLivraison")
            $lienfinal = "indexMVC.php?module=2&action=6".$lienentete."&type=".$type."&depot=".$depot;
        if($type=="Avoir")
            $lienfinal = "indexMVC.php?module=2&action=8".$lienentete."&type=".$type."&depot=".$depot;
    if($type=="VenteRetour")
        $lienfinal = "indexMVC.php?module=2&action=10".$lienentete."&type=".$type."&depot=".$depot;
        if($type=="Devis")
            $lienfinal = "indexMVC.php?module=2&action=4".$lienentete."&type=".$type."&depot=".$depot;
        if($type=="Transfert")
            $lienfinal = "indexMVC.php?module=4&action=5".$lienentete."&type=".$type."&depot=".$depot;
        if($type=="Transfert_detail")
            $lienfinal = "indexMVC.php?module=4&action=10".$lienentete."&type=".$type."&depot=".$depot;
        if($type=="Entree")
            $lienfinal = "indexMVC.php?module=4&action=7".$lienentete."&type=".$type."&depot=".$depot;
        if($type=="Sortie")
            $lienfinal = "indexMVC.php?module=4&action=8".$lienentete."&type=".$type."&depot=".$depot;
    if($type=="Achat")
        $lienfinal = "indexMVC.php?module=7&action=2".$lienentete."&type=".$type."&depot=".$depot;
    if($type=="AchatC")
        $lienfinal = "indexMVC.php?module=7&action=2".$lienentete."&type=".$type."&depot=".$depot;
    if($type=="AchatT")
        $lienfinal = "indexMVC.php?module=7&action=2".$lienentete."&type=Achat&depot=".$depot;
    if($type=="PreparationCommande")
            $lienfinal = "indexMVC.php?module=7&action=4".$lienentete."&type=".$type."&depot=".$depot;
        if($type=="AchatPreparationCommande")
            $lienfinal = "indexMVC.php?module=7&action=6".$lienentete."&type=".$type."&depot=".$depot;
        if($type=="VenteDevise")
            $lienfinal = "indexMVC.php?module=2&action=12".$lienentete."&type=".$type."&depot=".$depot;
    return $lienfinal;
}

?>
<script src="js/script_listeFacture.js?d=<?php echo time(); ?>"></script>
</head>
<body>    
<div id="milieu">
    <div class="container">

<div class="container clearfix">
    <h4 id="logo" style="text-align: center;background-color: #eee;padding: 10px;text-transform: uppercase">
        <?= $texteMenu; ?>
    </h4>
</div>
        
<div class="corps"><?= $titre; ?>

    <div class="form-group">
         <form action="indexMVC.php?module=<?php echo $module; ?>&action=<?php echo $action; ?>" method="GET">
            <input type="hidden" value="<?php echo $_SESSION["DE_No"];?>" id="de_no" />
            <input type="hidden" value="<?php echo $module; ?>" name="module"/>
            <input type="hidden" value="<?php echo $action; ?>" name="action"/>
            <?php if($type!="Vente" && $type!="VenteC"){
            ?><input type="hidden" value="<?php echo $type; ?>" name="type"/><?php } ?>
          <div style="margin-bottom:10px" class="row">
          <div class="col-sm-2">
              <label>Début : </label>
              <input type="text" class="form-control" maxlength="6" name="datedebut" value="<?php if(isset($_GET["datedebut"])) echo $datedeb; ?>" id="datedebut" placeholder="Date" />
          </div>
           <div class="col-sm-2">
                <label>Fin : </label>
                <input type="text" class="form-control" maxlength="6" name="datefin" value="<?php if(isset($_GET["datefin"])) echo $datefin; ?>" id="datefin" placeholder="Date" />
          </div>
           <div class="col-sm-4">
                <label>Dépôt : </label>
                <select class="form-control" name="depot" id="depot">
                <?php
                $isPrincipal = 0;
                if($admin==0){
                    $isPrincipal = 1;
                    $depotUserClass = new DepotUserClass(0);
                    $rows=$depotUserClass->getDepotUser($_SESSION["id"]);
                }
                else {
                    $depotClass = new DepotClass(0);
                    $rows = $depotClass->alldepotShortDetail();
                }
                      if($rows==null){
                      }else{
                          $var = 0;
                          foreach($rows as $row) {
                              if ($isPrincipal == 0) {
                                  if(!isset($_GET["depot"]) && $var==0)
                                      $depot= $row->DE_No;
                                  echo "<option value=" . $row->DE_No . "";
                                  if ($row->DE_No == $depot) echo " selected";
                                  echo ">" . $row->DE_Intitule . "</option>";
                                  $var++;
                              } else {
                                  echo $var." lol";
                                  if ($row->IsPrincipal == 1) {
                                      if(!isset($_GET["depot"]) && $var==0)
                                          $depot= $row->DE_No;
                                      echo "<option value=" . $row->DE_No . "";
                                      if ($row->DE_No == $depot) echo " selected";
                                      echo ">" . $row->DE_Intitule . "</option>";
                                    $var++;
                                  }
                              }

                          }
                      }
                  ?>
                </select>
          </div>

        <?php
        if($type=="Vente" ||$type=="VenteC" || $type=="BonLivraison" || $type=="Devis" || $type=="VenteRetour" || $type=="Avoir"
            || $type=="Achat" || $type=="AchatT"|| $type=="AchatC"){
        ?>
        <div class="col-sm-4">
            <?php
            $libTiers = "Client";
            $libToutTiers = "TOUT LES CLIENTS";
            if($type=="Achat" ||$type=="AchatC"||$type=="AchatPreparationCommande"||$type=="PreparationCommande") {
                $libTiers = "Fournisseur";
                $libToutTiers = "TOUT LES FOURNISSEURS";
            }
            ?>
            <label><?php echo $libTiers; ?> : </label>

          <select class="form-control" name="client" id="client">
              <option value="0" <?php if($client==0) echo " selected"; ?> ><?php echo $libToutTiers; ?></option>
                      <?php
                      $comptet = new ComptetClass(-1,"short");
                      $result = Array();
                      if($type=="Achat" || $type=="AchatT"|| $type=="AchatC")
                          $result=$comptet->allFournisseur();
                      else
                          $result=$comptet->allClients();
                        foreach($result as $row){
                          echo "<option value=".$row->CT_Num."";
                          if($row->CT_Num==$client) echo " selected";
                          echo ">".$row->CT_Intitule."</option>";
                        }
                      ?>
            </select>
          </div>
        <?php }?>
        </div>

        <div class="form-group" style="float:right">
              <input type="submit" id="valider" class="btn btn-primary" value="Valider"/>
        <?php if($protectedNouveau && $type!="VenteC"){ ?>
                <button type="button" id="nouveau" class="btn btn-primary">Nouveau</button>
         <?php } ?>
            <?php if($type=="Vente" || $type=="VenteC" || $type=="VenteT"){
                ?>
                        <select style="width:100px" id="type" name="type" class="form-control">
                            <option value="VenteT" <?php if($type=="VenteT") echo " selected ";  ?>>Tous</option>
                            <option value="Vente" <?php if($type=="Vente") echo " selected ";  ?>>Facture</option>
                            <option value="VenteC" <?php if($type=="VenteC") echo " selected ";  ?>>Facture comptabilisée</option>
                        </select>
                    </div>
                </div>
            <?php }
            if($type=="Achat" || $type=="AchatC"|| $type=="AchatT"){
                ?>
                <div class="form-group" >
                    <div style="float:right">
                        <select style="width:100px" id="type" name="type" class="form-control">
                            <option value="AchatT" <?php if($type=="AchatT") echo " selected ";  ?>>Tous</option>
                            <option value="Achat" <?php if($type=="Achat") echo " selected ";  ?>>Facture</option>
                            <option value="AchatC" <?php if($type=="AchatC") echo " selected ";  ?>>Facture comptabilisée</option>
                        </select>
                    </div>
                </div>
            <?php }
    ?>
        <?php if($objet->db->flagDataOr==1 && $type=="Vente"){ ?>
            <div class="form-group col-lg-2">
                <button type="button" id="ClotureVente" class="btn btn-primary">Cloturer une affaire</button>
            </div>
        <?php } ?>
        </form>
    
    

<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
<thead>
    <tr>
        <th>Numéro Pièce</th>
        <th>Reference</th>
        <th>Date</th>
        <?php if($module==2) echo"<th>Client</th>
        <th>Dépot</th>";
        if($type=="Achat" || $type=="AchatC" || $type=="AchatT" || $type=="PreparationCommande"|| $type=="AchatPreparationCommande") echo"<th>Fournisseur</th>
        <th>Dépot</th>";
        if($type=="Transfert_detail" || $type=="Transfert") echo"<th>Dépot source</th>
        <th>Dépot dest.</th>";
        ?>
        <th>Total TTC</th>
        <?php if($type=="BonLivraison" || $type=="Vente"  || $type=="VenteT" || $type=="VenteC" || $type=="AchatC" || $type=="Achat"  || $type=="AchatT"
            || $type=="PreparationCommande"|| $type=="AchatPreparationCommande") echo "<th>Montant r&eacute;gl&eacute;</th>
        <th>Statut</th>"; ?> 
        <?php if(($type=="BonLivraison" || $type=="Devis") && ($admin==1 || ($protected))) echo "<th></th>"; ?>
        <?php if($protectedSuppression) echo "<th></th>"; ?>
        <th></th>
    </tr>
</thead>


<tbody>
<?php
        $objet = new ObjetCollector();
        $docEntete = new DocEnteteClass(0);
        $listFacture = Array();
if($type=="Vente"){
    $listFacture = $docEntete->getListeFacture($depot,0,$objet->getDate($datedeb) ,$objet->getDate($datefin),$client,0,6);
}
if($type=="VenteDevise"){
    $listFacture = $docEntete->getListeFacture($depot,4,$objet->getDate($datedeb) ,$objet->getDate($datefin),$client,0,6);
}

if($type=="VenteC"){
    $listFacture = $docEntete->getListeFacture($depot,0,$objet->getDate($datedeb) ,$objet->getDate($datefin),$client,0,7);
}
if($type=="VenteT"){
    $listFacture = $docEntete->getListeFacture($depot,0,$objet->getDate($datedeb) ,$objet->getDate($datefin),$client,0,67);
}
        if($type=="VenteRetour"){
            $listFacture = $docEntete->getListeFacture($depot,1,$objet->getDate($datedeb) ,$objet->getDate($datefin),$client,0,6);
        }
        if($type=="Avoir"){
            $listFacture = $docEntete->getListeFacture($depot,2,$objet->getDate($datedeb) ,$objet->getDate($datefin),$client,0,6);
        }
        if($type=="Devis"){
            $listFacture = $docEntete->getListeFacture($depot,0,$objet->getDate($datedeb) ,$objet->getDate($datefin),$client,0,0);
        }
        if($type=="BonLivraison"){
            $listFacture = $docEntete->getListeFacture($depot,0,$objet->getDate($datedeb) ,$objet->getDate($datefin),$client,0,3);
        }
        if($type=="Transfert"){
            $listFacture = $docEntete->listeTransfert($depot, $objet->getDate($datedeb), $objet->getDate($datefin));
        }
        if($type=="Transfert_detail"){
            $listFacture = $docEntete->listeTransfertDetail($depot, $objet->getDate($datedeb), $objet->getDate($datefin));
        }
        if($type=="Entree"){
            $listFacture = $docEntete->listeEntree($depot, $objet->getDate($datedeb), $objet->getDate($datefin));
        }
        if($type=="Sortie"){
            $listFacture = $docEntete->listeSortie($depot, $objet->getDate($datedeb), $objet->getDate($datefin));
        }

        if($type=="Achat"){
            $listFacture = $docEntete->getListeFacture($depot,0,$objet->getDate($datedeb) ,$objet->getDate($datefin),$client,1,16);
        }

        if($type=="AchatC"){
            $listFacture = $docEntete->getListeFacture($depot,0,$objet->getDate($datedeb) ,$objet->getDate($datefin),$client,1,17);
        }

        if($type=="AchatT"){
            $listFacture = $docEntete->getListeFacture($depot,0,$objet->getDate($datedeb) ,$objet->getDate($datefin),$client,1,1617);
        }

        if($type=="PreparationCommande"){
            $listFacture = $docEntete->getListeFacture($depot,0,$objet->getDate($datedeb) ,$objet->getDate($datefin),$client,1,11);
        }
        if($type=="AchatPreparationCommande"){
            $listFacture = $docEntete->getListeFacture($depot,0,$objet->getDate($datedeb) ,$objet->getDate($datefin),$client,1,12);
        }
        $ajout="";
        if(isset($_GET["datedebut"]))
            $ajout=$ajout."&datedebut=".$_GET["datedebut"];
        if(isset($_GET["datefin"]))
            $ajout=$ajout."&datefin=".$_GET["datefin"];
        if(isset($_GET["depot"]))
            $ajout=$ajout."&depot=".$_GET["depot"];
        
        $i=0;
        $classe="";
        if(sizeof($listFacture)==0){

        }else{
            foreach ($listFacture as $row){
                $message="";
                $avance="";
                $total = round($row->ttc);
                if($type=="BonLivraison" || $type=="Vente" || $type=="VenteC" || $type=="VenteT" || $type=="Achat" || $type=="AchatC"  || $type=="AchatT" || $type=="PreparationCommande"|| $type=="AchatPreparationCommande"){
                    $avance = round($row->avance);
                    if($avance==null) $avance = 0;
                    $message =$row->statut;
                }
                $i++;
                $date = new DateTime($row->DO_Date);
                echo "<tr class='facture $classe' id='article_".$row->DO_Piece."'>"
                        . "<td><a href='".lienfinal($message,$avance,$row->DO_Piece,$type,$depot,$admin,$row->cbMarq,$row->DO_Domaine,$row->DO_Type,$row->DO_Modif,$admin,$protected,$flagProtApresImpression)."'>".$row->DO_Piece."</a></td>"
                        . "<td>".$row->DO_Ref."</td>"
                        . "<td>".$date->format('d-m-Y')."</td>";
                if($module==2 || $type=="Achat" || $type=="AchatC" || $type=="AchatT" || $type=="PreparationCommande"|| $type=="AchatPreparationCommande") echo "<td>".$row->CT_Intitule."</td>"
                        . "<td>".$row->DE_Intitule."</td>";
                if($type=="Transfert_detail" || $type=="Transfert") echo"<th>".$row->DE_Intitule."</th>
                <th>".$row->DE_Intitule_dest."</th>";

                        echo "<td>";
                 echo $objet->formatChiffre($total);
                echo "</td>";
                if($type=="BonLivraison" || $type=="Vente" || $type=="AchatT" || $type=="VenteT"  || $type=="VenteC" || $type=="Achat" || $type=="AchatC" || $type=="PreparationCommande"|| $type=="AchatPreparationCommande") echo "<td>".$objet->formatChiffre($avance)."</td>"
                        . "<td id='statut'>".$message."</td>";
                    if(($type=="BonLivraison" || $type=="Devis") && ($admin==1 || ($protected))) echo '<td><input type="button" class="btn btn-primary" value="Convertir en facture" id="transform"/></td>';
                    if(($protectedSuppression)){
                        echo "<td>";
                        if(($type=="BonLivraison" || $type=="Vente" || $type=="AchatT" || $type=="VenteT" || $type=="VenteC" || $type=="Achat" || $type=="AchatC" || $type=="Entree"|| $type=="Sortie"|| $type=="Transfert" || $type=="Transfert_detail") && $avance==0)
                        echo "<a href='Traitement\Facturation.php?type=$type&acte=suppr_facture&DO_Piece=".$row->DO_Piece."&DO_Type=".$row->DO_Type."&DO_Domaine=".$row->DO_Domaine."$ajout' onclick=\"if(window.confirm('Voulez-vous vraiment supprimer la facture ".$row->DO_Piece." ?')){return true;}else{return false;}\"><i class='fa fa-trash-o'></i></a></td>";
                    }
                    echo "<td>";
                    if($row->DO_Imprim ==1)
                        echo "<i class='fa fa-print'></i>";
                    echo "</td>";
                    echo "</tr>";
            }
        }
//      ?>

</tbody>
</table>
 </div>   
</div>
</div>
        
<div style="text-align: center" id="menu_transform">
            <div class="form-group col-lg-4">
                <label>Type<br/></label> 
                <select id="type_trans" name="type_trans" class="form-control">
                    <option value="6">Facture</option>
                    <?php
                    if($_GET["type"]=="Devis")
                    echo "<option value='3'>Bon de livraison</option>";
                    ?>
                </select>
            </div>
            <div class="form-group col-lg-4">
                <label>Choisisser une nouvelle date</label> 
                <input class="form-control" type="text" id="date_transform"/>
            </div>
            <div class="form-group col-lg-4">
                <label>Choisisser une nouvelle référence</label>
                <input class="form-control" type="text" id="reference"/>
            </div>
</div>


        <?php if($objet->db->flagDataOr==1 && $type=="Vente"){ ?>
<div id="FormClotureVente" class="form-group" style="display: none;">
            <div class="form-group col-lg-2">
                <label>Affaire : </label>
                <select class="form-control" id="affaire" name="affaire">
                    <option value=""></option>
                    <?php
                    $result=$objet->db->requete($objet->getAffaire(0));
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    if($rows==null){
                    }else{
                        foreach($rows as $row)
                            if ($isPrincipal == 0) {
                                echo "<option value='".$row->CA_Num."'";
                                echo ">".$row->CA_Intitule."</option>";
                            } else {
                                if ($row->IsPrincipal == 1) {
                                    echo "<option value='".$row->CA_Num."'";
                                    echo ">".$row->CA_Intitule."</option>";
                                }
                            }
                    }
                    ?>
                </select>
            </div>
</div>
        <?php } ?>