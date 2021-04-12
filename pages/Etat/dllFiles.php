<?php

if (file_exists($_GET["fichier"])) {
    $file = $_GET["fichier"];
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.basename($file).'"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($file));
readfile($file);
unlink($file);
echo "<script type='text/javascript'>window.close();</script>";
}
?>