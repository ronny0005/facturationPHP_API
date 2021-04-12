<?php

require_once("./Modele/DB.php");
require_once("./Modele/ObjetCollector.php");

// initialize variables 
if(!isset($_POST['Valider'])) $_POST['Valider'] = ''; 
if(!isset($_POST['oldpwd'])) $_POST['oldpwd'] = ''; 
if(!isset($_POST['newpwd1'])) $_POST['newpwd1'] = ''; 
if(!isset($_POST['newpwd2'])) $_POST['newpwd2'] = ''; 
if(!isset($updated)) $updated =0; 
if(!isset($oldpassword)) $oldpassword =0; 
 

$result=$objet->db->requete($objet->getOldPasswordByid($_SESSION["id"]));
 while ($re = $result->fetch()) {
             $solution=$re[0];
          }
 $ru=$solution;
 //var_dump($ru);die();
if($_POST['Valider'])
{
	$oldpassword=0;
	if($objet->crypteMdp($_POST['oldpwd'])==$ru) $oldpassword=1;
	// check empty password
	if ($_POST['oldpwd']=="" || $_POST['newpwd1']=="" || $_POST['newpwd2']=="")
	{
		echo "<div> Veuillez saisir votre mot de passe.</div><br/><br/>";
	}
	// check old password
	else if ($oldpassword!='1')
	{
		echo "<div> Ancien mot de passe éronné.</div><br/><br/>";
	}
	// check new passwords
	else if ($_POST['newpwd1']!=$_POST['newpwd2'])
	{
		echo "<div> Vos nouveaux mots de passe sont différents.</div><br/><br/>";
	}
	else
	{
		$result1=$objet->db->requete($objet->UpdatePasswordByid($uid,$_POST['newpwd1']));
		echo '
		<script type="text/javascript" language="javascript">
		$().ready(function() { jqmCloseBtn});
		</script>
		';
		$updated=1;
                $result2=$objet->db->requete($objet->UpdateStatutPasswordByid($uid));
		//unset($_SESSION['last_login']);
	} 
}
if ($updated==1)
{
	echo '<div> Le mot de passe à été changé.</div><br /><br />
	<div>
		<button name="Fermer" value="Fermer" type="submit"  class="jqmClose"  id="jqmCloseBtn">
                    Fermer
		</button>
	</div>
	
	';
}else{
	echo '
	<center><b>Pour votre sécurité, veuillez modifier votre ancien mot de passe:</b></center><br />
	<br /><br />
	<form method="post" action="">
		<b>Ancien mot de passe: </b></td><td><input name="oldpwd" type="password" size="20" required = "true" /><br /><br />
		<b>Nouveau mot de passe: </b></td><td><input name="newpwd1" type="password" size="20" required = "true" /><br /><br />
		<b>Confirmer nouveau mot de passe: </b></td><td><input name="newpwd2" type="password" size="20"  required = "true" /><br /><br />
		<div>
                    <button name="Valider" value="Valider" class="btn btn-success" type="submit" id="Valider">
                    Valider
                    </button>
		</div>
	</form>
	';
}

?>

