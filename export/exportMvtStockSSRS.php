<?php
include("enteteParam.php");
?>
<page>
    <?php


    require_once 'SSRSReport.php';
    define("REPORT", "/Rapports/Mouvement_de_stock");
    define("FILENAME", "Sales_Summary_of_Employee_282_For_July_2003.pdf");
    $settings = parse_ini_file("app.config", 1);

    try
    {
        $ssrs_report = new SSRSReport(new Credentials($settings["UID"], $settings["PASWD"]),$settings["SERVICE_URL"]);


        $executionInfo = $ssrs_report->LoadReport2(REPORT, NULL);


        $parameters = array();
        $parameters = array();
        $parameters[0] = new ParameterValue();
        $parameters[0]->Name = "Agence";
        $parameters[0]->Value = "$depot_no";
        $parameters[1] = new ParameterValue();
        $parameters[1]->Name = "ArticleDebut";
        $parameters[1]->Value = "$articledebut";
        $parameters[2] = new ParameterValue();
        $parameters[2]->Name = "ArticleFin";
        $parameters[2]->Value = "$articlefin";
        $parameters[3] = new ParameterValue();
        $parameters[3]->Name = "DateDebut";
        $parameters[3]->Value = "".($datedeb)."";
        $parameters[4] = new ParameterValue();
        $parameters[4]->Name = "DateDebut";
        $parameters[4]->Value = "".($datefin)."";
        $ruptureSSRS= "false";
        if($rupture==1) $ruptureSSRS="true";
        $parameters[5] = new ParameterValue();
        $parameters[5]->Name = "rupture";
        $parameters[5]->Value = "$ruptureSSRS";
        $executionInfo = $ssrs_report->SetExecutionParameters2($parameters, "en-us");

        $renderAsPDF = new RenderAsPDF();
        $renderAsPDF->PageWidth = "12.5in";
        $result = $ssrs_report->Render2($renderAsPDF,
            PageCountModeEnum::$Estimate,
            $Extension,
            $MimeType,
            $Encoding,
            $Warnings,
            $StreamIds);

        header("Content-Type: application/force-download");
        header("Content-Disposition: attachment; filename=\"".FILENAME."\"");
        header("Content-length: ".(string)(strlen($result)));
        header("Expires: ".gmdate("D, d M Y H:i:s", mktime(date("H")+2,
                date("i"), date("s"),
                date("m"), date("d"),
                date("Y")))." GMT");
        header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        echo $result;
    }
    catch(SSRSReportException $serviceExcprion)
    {
        echo $serviceExcprion->GetErrorMessage();
    }

    /**
     *
     * @return <url>
     * This function returns the url of current page.
     */
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
