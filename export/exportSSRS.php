<?php
require_once 'SSRSReport.php';
set_time_limit(100);
$settings = parse_ini_file(__DIR__."\..\config\app.config", 1);

$societe = $_GET["societe"];
$format = $_GET["format"];
$type = $_GET["type"];
$login ="";
session_start();
if(isset($_SESSION["login"]))
    $login = $_SESSION["login"];
if($societe=="ZUMI"){
    define("REPORT", "/MFZUMI/Reports/{$format}_Facture");
    $saveName = "Facture{$format}.pdf";
}

if($societe=="CMI") {
    define("REPORT", "/MFCMI/Reports/{$format}_{$type}");
    $saveName = "{$format}_{$type}.pdf";
}

if($societe=="BOUM"){
    define("REPORT", "/MFBOUMKO/Reports/{$format}_Facture");
    $saveName = "Facture{$format}.pdf";
}

if($societe=="SODIPROVET"){
    define("REPORT", "/MFSODIPROVET/Reports/{$format}_Facture");
    $saveName = "Facture{$format}.pdf";
}

if($societe=="SOMBACAM"){
    define("REPORT", "/MFSOMBACAM/Reports/{$format}_Facture");
    $saveName = "Facture{$format}.pdf";
}

if($societe=="ALTO"){
    define("REPORT", "/MFALTO/Reports/{$format}_Facture");
    $saveName = "Facture{$format}.pdf";
}

if($societe=="BAPHARMA"){
    define("REPORT", "/MFBAPHARMA/Reports/{$format}_Facture");
    $saveName = "{$format}_Facture.pdf";
}

try
{
    $ssrs_report = new SSRSReport(new Credentials($settings["UID"], $settings["PASWD"]),$settings["SERVICE_URL"]);
    if (isset($_REQUEST['rs:ShowHideToggle']))
    {
        $ssrs_report->ToggleItem($_REQUEST['rs:ShowHideToggle']);
    }
    else
    {
        $executionInfo = $ssrs_report->LoadReport2(REPORT, NULL);
        $parameters = array();
        $dataParam = new ParameterValue();
        $dataParam->Name = "cbMarq";
        $dataParam->Value = $_GET["cbMarq"];
        $parameters[]=  $dataParam;
        $facture = "0";
        if(isset($_GET["facture"])) {
            $facture = $_GET["facture"];
            $dataParam = new ParameterValue();
            $dataParam->Name = "facture";
            $dataParam->Value = $facture;
            $parameters[]=  $dataParam;
        }
        $dataParam = new ParameterValue();
        $dataParam->Name = "vendeur";
        $dataParam->Value = "$login";
        $parameters[] = $dataParam;
        $ssrs_report->SetExecutionParameters2($parameters);

    }

    $renderAsHTML = new RenderAsPDF();
    $renderAsHTML->ReplacementRoot = getPageURL();
    $result_html = $ssrs_report->Render2($renderAsHTML,
        PageCountModeEnum::$Estimate,
        $Extension,
        $MimeType,
        $Encoding,
        $Warnings,
        $StreamIds);


    header('Content-type: application/pdf');
    header('Content-Disposition: inline; filename="' . $saveName . '"');
    header('Content-Transfer-Encoding: binary');
    header('Accept-Ranges: bytes');
    echo $result_html;
}
catch (SSRSReportException $serviceException)
{
    print("<pre>");
    print_r($serviceException);
    print("</pre>");
}

function getPageURL()
{
    $PageUrl = isset($_SERVER["HTTPS"]) == "on"? 'https://' : 'http://';
    $uri = $_SERVER["REQUEST_URI"];
    $index = strpos($uri, '?');
    if($index !== false)
    {
        $uri = substr($uri, 0, $index);
    }
    $PageUrl .= $_SERVER["SERVER_NAME"] .
        ":" .
        $_SERVER["SERVER_PORT"] .
        $uri;
    return $PageUrl;
}
?>