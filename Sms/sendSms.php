<?php

function sendSms(){
//$url = 'http://lmtgroup.dyndns.org/sendsms/sendsmsGold.php?';
$timeout = 10;
 $username='itsolutions';
 $destination='00237694414319';
 $source='ITSOLUTIONS';
 $message='FIRST TEST';

//$request  = $url."UserName=".urlencode($username)."&Password=$mdp";
//$request .="&SOA=".urlencode($source)."&MN=".urlencode($destination)."&SM=".urlencode($message);
$url  = "http://mmp.gtsnetwork.cloud/gts/sendsms?version=2&";
$request = $url."phone=694547803&password=sancoms@cmi&from=IT-Solution&to=".urlencode($destination)."&text=".urlencode($message);
$url =$request;
ECHO $url;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POST, 1);

$response = curl_exec($ch);
curl_close($ch);

}
sendSms();
?>