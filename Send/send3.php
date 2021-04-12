<?php

include "../Modele/MailComplete.php";
// Load Composer's autoloader

$mail = new Mail();
$mail->sendMail("<br/><br/><br/> ","ronald2000fr@gmail.com","Liste des transferts à une ligne");


?>