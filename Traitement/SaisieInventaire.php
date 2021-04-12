<?php
if(!isset($mobile)){
    session_start();
    include("../Modele/DB.php");
    include("../Modele/ObjetCollector.php");
    include("../Modele/Objet.php");
    include("../Modele/DocEnteteClass.php");
    include("../Modele/DocLigneClass.php");
    $objet = new ObjetCollector(); 
}

if($_GET["acte"] =="inventaireEntree"){
    $entete="";
    $depot = $_GET["depot"];
    $date = $_GET["date"];
    $docEntete = new DocEnteteClass(0,$objet->db);
    $entete=$docEntete->addDocenteteEntreeInventaireProcess($date, 'inv du '.$date, $depot, 0, 0, 0);
/*    $objet->addDocenteteEntreeInventaireProcess($date, 'inv du '.$date, $depot, 0, 0, 0);
    $result=$objet->db->requete($objet->lastDOPieceByDomaine(2,20,$depot));     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if ($rows!=null)
        $entete = $rows[0]->DO_Piece;
*/
    $data = array('entete' => $entete);
    echo json_encode($data);
}

if($_GET["acte"] =="inventaireLigneEntree"){
    $entete=$_GET["entete"];
    $qte=$_GET["quantite"];
    $ref_article = $_GET["designation"];
    $prix = $_GET["prix"];
    $depot = $_GET["depot"];
    $date = $_GET["date"];
    $objet->addDocligneEntreeMagasinProcess($ref_article,$entete,$qte,"1",$depot,0,$prix,$_SESSION["login"],"Entree","");
    $article = new ArticleClass($ref_article);
    $article->updateArtStock($depot,$qte,($prix*$qte),$_SESSION["id"],"ajout_ligne");
}

if($_GET["acte"] =="inventaireEntree21"){
    $entete="";
    $depot = $_GET["depot"];
    $date = $_GET["date"];
    $docEntete = new DocEnteteClass(0,$objet->db);
    $entete=$docEntete->addDocenteteEntreeInventaireProcess21($date, 'inv du '.$date, $depot, 0, 0, 0);

/*    $objet->addDocenteteEntreeInventaireProcess21($date, 'inv du '.$date, $depot, 0, 0, 0);
    $result=$objet->db->requete($objet->lastDOPieceByDomaine(2,21,$depot));     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if ($rows!=null)
        $entete = $rows[0]->DO_Piece;
  */
    $data = array('entete' => $entete);
    echo json_encode($data);
}

if($_GET["acte"] =="inventaireLigneEntree21"){
    $entete=$_GET["entete"];
    $qte=$_GET["quantite"];
    $ref_article = $_GET["designation"]; 
    $prix = $_GET["prix"];
    $depot = $_GET["depot"];
    $date = $_GET["date"];
	$docligne = new DocLigneClass(0);
	$docligne->addDocligneEntreeMagasinProcess21($ref_article, $entete, $qte, "3", $depot, $prix, $_SESSION["login"]);
	$article = new ArticleClass($ref_article, $objet->db);
	$isStock = $article->isStock($depot);
	$article->updateArtStock($depot, -$qte, -($prix * $qte),$_SESSION["id"],"ajout_ligne");
}
?>