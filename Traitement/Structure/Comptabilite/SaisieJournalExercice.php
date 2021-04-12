<?php
if(!isset($mobile)){
    session_start();
}
    include("../../../Modele/DB.php");
    include("../../../Modele/ObjetCollector.php");
    include("../../../Modele/Objet.php");
include("../../../Modele/CompteGClass.php");
include("../../../Modele/JournalClass.php");
    
    $objet = new ObjetCollector();
    if(isset($_GET["JO_Num"]))
        $JO_Num = $_GET["JO_Num"];
    if(isset($_GET["Annee_Exercice"])){
        $Annee_Exercice = $_GET["Annee_Exercice"];
        $mois = substr($Annee_Exercice, -2);
        $annee = substr($Annee_Exercice, 0, 4);
        $JM_Date  = $annee."-".$mois."-01";

        if(isset($_GET["EC_Echeance"]) && $_GET["EC_Echeance"]!=""){
            $EC_Date = $objet->getDate($_GET["EC_Echeance"]);
        }else {
            $EC_Date = $annee . "-" . $mois . "-01";
        }
    }
    if(isset($_GET["EC_Jour"]))
        $EC_Jour = $_GET["EC_Jour"];
    if(isset($_GET["EC_Piece"]))
        $EC_Piece = $_GET["EC_Piece"];
    if(isset($_GET["EC_RefPiece"]))
        $EC_RefPiece = $_GET["EC_RefPiece"];
    if(isset($_GET["EC_Reference"]))
        $EC_Reference = $_GET["EC_Reference"];
    $EC_TresoPiece = '';
    if(isset($_GET["CG_Num"]))
        $CG_Num = $_GET["CG_Num"];
    if(isset($_GET["CG_NumCont"]))
        $CG_NumCont = $_GET["CG_NumCont"];
    if(isset($_GET["CT_Num"]))
        $CT_Num = $_GET["CT_Num"];
    if(isset($_GET["EC_Intitule"]))
        $EC_Intitule = str_replace("'","''", $_GET["EC_Intitule"]);
    if(isset($_GET["N_Reglement"]))
        $N_Reglement = $_GET["N_Reglement"];
    if(isset($_GET["EC_Echeance"]))
        $EC_Echeance = $_GET["EC_Echeance"];
    $EC_Sens = 0;
    if(isset($_GET["EC_MontantDebit"]))
        $EC_Montant = $_GET["EC_MontantDebit"];
    if(isset($_GET["EC_MontantCredit"]))
        if($_GET["EC_MontantCredit"]!=0){
            $EC_Sens = 1;
            $EC_Montant = $_GET["EC_MontantCredit"];
        }
    if(isset($_GET["CT_NumCont"]))
        $CT_NumCont = $_GET["CT_NumCont"];
    $TA_Code = NULL;
    
if(strcmp($_GET["acte"],"contrepartie") == 0){
    $journal = new JournalClass($JO_Num);
    $compteg = new CompteGClass($journal->CG_Num);
    $data = array('CG_Num' => $compteg->CG_Num,'label' => $compteg->CG_Num." - ".$compteg->CG_Intitule);
    echo json_encode($data);
}
    
if(strcmp($_GET["acte"],"ajout") == 0){
    $result = $objet->db->requete($objet->searchJMouv($JO_Num,$JM_Date));
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if($rows!=null){
        foreach($rows as $row){
        }
    }else{
        $result = $objet->db->requete($objet->insertJMouv($JO_Num,$JM_Date));
    }

    $comptegclass = new CompteGClass($CG_Num);
    $result = $objet->db->requete($objet->insertFComptetC($JO_Num,$JM_Date,$EC_Jour,$EC_Date,$EC_Piece,$EC_RefPiece,$EC_TresoPiece,$CG_Num,$CG_NumCont,$CT_Num,$EC_Intitule,$N_Reglement,($EC_Echeance!="") ? $objet->getDate($EC_Echeance) : $EC_Echeance,$EC_Sens,$EC_Montant,$CT_NumCont,$TA_Code,$EC_Reference,0,0,"",0));
    $result = $objet->db->requete($objet->getMaxEC_No());
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    foreach($rows as $row){
        $fichier = $_GET['nomFichier']; 
        if($fichier!="")
        $result=$objet->db->requete($objet->insert_ECRITURECPIECE($row->EC_No,$fichier)); 
        $data = array('EC_No' => $row->EC_No);
        echo json_encode($data);
    }
}

if(strcmp($_GET["acte"],"suppr") == 0){
    $result = $objet->db->requete($objet->deleteSaisieJournal($JO_Num,$mois,$annee,$JM_Date));
    $data = array('TA_Code' => 0);
    echo json_encode($data);
}

if(strcmp($_GET["acte"],"ouvreAnalytique") == 0){
    $result = $objet->db->requete($objet->getPlanComptableByCGNum($CG_Num));
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    $data = array('JO_SaisAnal' => $rows[0]->CG_Analytique);
    echo json_encode($data);
}

if(strcmp($_GET["acte"],"supprEcriture") == 0){
    $EC_No = $_GET["EC_No"];
    $result = $objet->db->requete($objet->deleteEcritureC($EC_No));
    $result = $objet->db->requete($objet->deleteZ_ECRITURECPIECE($EC_No));
    $data = array('TA_Code' => 0);
    echo json_encode($data);
}



if(strcmp($_GET["acte"],"modif") == 0){
    //$cbMarq = $_GET["cbMarq"];
    $EC_No = $_GET["EC_No"];
    $result = $objet->db->requete($objet->modifFComptetC($EC_No,$JO_Num,$JM_Date,$EC_Jour,$EC_Date,$EC_Piece,$EC_RefPiece,$EC_TresoPiece,$CG_Num,$CG_NumCont,$CT_Num,$EC_Intitule,$N_Reglement,$EC_Echeance,$EC_Sens,$EC_Montant,$CT_NumCont,$TA_Code,$EC_Reference));
    $fichier = $_GET['nomFichier']; 
    if($fichier!="")
    $result=$objet->db->requete($objet->modif_ECRITURECPIECE($EC_No,$fichier)); 
    afficheLigne($JO_Num,$mois,$annee);
}


if(strcmp($_GET["acte"],"afficheLigne") == 0){
    afficheLigne($JO_Num,$mois,$annee);
}

if(strcmp($_GET["acte"],"afficheLigneTiers") == 0){
    $ctNum = $_GET["CT_Num"];
    $cgNum = "";
    if($_GET["typeInterrogation"] != "Tiers"){
        $cgNum = $_GET["CT_Num"];
        $ctNum = "";
    }
    afficheLigneTiers($ctNum,$_GET["dateDebut"],$_GET["dateFin"],$_GET["typeEcriture"],$cgNum);
}

function afficheLigne($JO_Num,$mois,$annee){
    $objet = new ObjetCollector();
    $journal = new JournalClass($JO_Num);
    $rows = $journal->getSaisieJournalExercice($JO_Num,$mois,$annee,"","","",0,"");
    foreach ($rows as $row){
        $class="";
        if($row->compteA == 1)
            $class="class='font-weight-bold'";
        echo "<tr $class id='emodeler_{$row->cbMarq}'>
                <td id='tabEC_Jour'>{$row->EC_Jour}</td>
                <td id='tabEC_Piece'>{$row->EC_Piece}</td>
                <td id='tabEC_Facture'>{$row->EC_RefPiece}</td>
                <td id='tabEC_RefPiece'>{$row->EC_Reference}</td>
                <td id='tabCG_Num'>{$row->CG_Num}</td>
                <td id='tabCT_Num'>{$row->CT_Num}</td>
                <td id='tabEC_Intitule'>{$row->EC_Intitule}</td>
                <td id='tabEC_Echeance'>";
        if($row->EC_Echeance_C=="1900-01-01") echo ""; else echo $objet->getDateDDMMYYYY($row->EC_Echeance); echo "</td>
                <td id='tabEC_MontantDebit' class='text-right'>{$objet->formatChiffre($row->EC_MontantDebit,2)}</td>
                <td id='tabEC_MontantCredit' class='text-right'>{$objet->formatChiffre($row->EC_MontantCredit,2)}</td>
                <td id='modif_{$row->cbMarq}'><i class='fa fa-pencil fa-fw'></i></td>
                <td id='suppr_{$row->cbMarq}'><i class='fa fa-trash-o'></i></td>";
        if($row->Lien_Fichier!="")
            echo "<td><a target='_blank' href='upload/files/{$row->Lien_Fichier}' class='fa fa-download'></a></td>";
        else echo "<td></td>";
        echo"
                <td id='data' style='display:none' ><span style='display:none' id='tabCG_Analytique'>{$row->CG_Analytique}</span><span style='display:none' id='tabEC_No'>{$row->EC_No}</span></td>
            </tr>";
    }
}

function afficheLigneTiers($ctTiers,$dateDebut,$dateFin,$typeEcriture,$cgNum){
    $journal = new JournalClass(0);
    $objet = new ObjetCollector();
    $listItem = $journal->getSaisieJournalExercice("",0,2020/*$_SESSION["annee"]*/,$ctTiers,$objet->getDate($dateDebut),$objet->getDate($dateFin),$typeEcriture,$cgNum);
    foreach ($listItem as $row){
        echo "<tr>
                <td><input type='checkbox' name='selectLigne' id='selectLigne' /></td>
                <td>{$row->JO_Num}</td>
                <td>{$row->EC_Jour}</td>
                <td>{$row->EC_Piece}</td>
                <td>{$row->EC_RefPiece}</td>
                <td>{$row->EC_Reference}</td>
                <td>{$row->CT_Num}</td>
                <td>{$row->EC_Intitule}</td>
                <td>";
                if($row->EC_Echeance_C=="1900-01-01")
                    echo "";
                else
                    echo $objet->getDateDDMMYYYY($row->EC_Echeance_C);
                echo"</td>
                <td>{$row->EC_Lettrage}</td>
                <td></td>
                <td  id='amountDebit'>{$objet->formatChiffre($row->EC_MontantDebit)}</td>
                <td  id='amountCredit'>{$objet->formatChiffre($row->EC_MontantCredit)}</td>
                <td style='display:none' id='cbMarq'>{$row->cbMarq}</td>
              </tr>";
    }
}


?>
