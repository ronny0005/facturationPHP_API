<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
</head>
<body>
<form name="reportForm" id="reportForm" method="POST" action="Download.php">
    <?php
    /**
     *
     * Copyright (c) 2009, Persistent Systems Limited
     *
     * Redistribution and use, with or without modification, are permitted
     *  provided that the following  conditions are met:
     *   - Redistributions of source code must retain the above copyright notice,
     *     this list of conditions and the following disclaimer.
     *   - Neither the name of Persistent Systems Limited nor the names of its contributors
     *     may be used to endorse or promote products derived from this software
     *     without specific prior written permission.
     *
     * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
     * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
     * THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
     * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR
     * CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
     * EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
     * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS;
     * OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY,
     * WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR
     * OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
     * EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
     */
    require_once 'SSRSReport.php';
    //load config file variables
    $settings = parse_ini_file(__DIR__."\..\..\config\app.config", 1);
    $saveName = "file";
    if(isset($_REQUEST["amp;rs:Format"]))
        $_REQUEST["amp;rs:Format"] = $_POST["exportSelect"];

    try
    {
        $ssrs_report = new SSRSReport(new Credentials($settings["UID"], $settings["PASWD"]),$settings["SERVICE_URL"]);

        $controls = null;
        if(key_exists("DateDebut", $_POST)) {
            if(strlen($_POST["DateDebut"])==6)
            $_POST["DateDebut"] = "20".substr($_POST["DateDebut"],4,2)."-".substr($_POST["DateDebut"],2,2)."-".substr($_POST["DateDebut"],0,2);
        }
        if(key_exists("DateFin", $_POST)) {
            if(strlen($_POST["DateFin"])==6)
            $_POST["DateFin"] = "20".substr($_POST["DateFin"],4,2)."-".substr($_POST["DateFin"],2,2)."-".substr($_POST["DateFin"],0,2);
        }


        if(key_exists("exportSelect", $_POST))
        {
            $executionInfo = $ssrs_report->LoadReport2($_POST["reportName"], NULL);

            $parameters = getReportParameters(true);
            $ssrs_report->SetExecutionParameters2($parameters);
            $render = getRenderType($_POST["exportSelect"]);

            if (isset($_REQUEST['rs:ShowHideToggle']))
            {
                $ssrs_report->ToggleItem($_REQUEST['rs:ShowHideToggle']);
            }
            else if (isset($_REQUEST['rs:Command']))
            {
                switch($_REQUEST['rs:Command'])
                {
                    case 'Sort':
                        $ssrs_report->Sort2($_REQUEST['rs:SortId'],
                            $_REQUEST['rs:SortDirection'],
                            $_REQUEST['rs:ClearSort'],
                            PageCountModeEnum::$Estimate,
                            $ReportItem,
                            $executionInfo);
                        break;
                    default:
                        echo 'Unknown :' . $_REQUEST['rs:Command'];
                        exit;
                }
            }

            $result_html = $ssrs_report->Render2($render,
                PageCountModeEnum::$Estimate,
                $Extension,
                $MimeType,
                $Encoding,
                $Warnings,
                $StreamIds);
            $useragent=$_SERVER['HTTP_USER_AGENT'];
            $isMobile = false;
            if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
                $isMobile = true;
            $saveName = $_POST["exportName"] . getExtension($_POST["exportSelect"]);
            if (!$handle = fopen($saveName, 'wb')) {
                echo "Cannot open file for writing output";
                exit;
            }

            if (fwrite($handle, $result_html) === FALSE) {
                echo "Cannot write to file";
                exit;
            }
            fclose($handle);
            if(!$isMobile && $_POST["exportSelect"]=="PDF"){
                echo"
                        <html>
                          <head></head>
                          <style>
                          .internal {
                                width: 100%;
                                height: 100%;
                            }
                            
                            .container {
                                position: absolute;
                                top: 0;
                                left: 0;
                                right: 0;
                                bottom: 0;
                             }
                            </style>
                          <body>
                            <div class='container box'>
                              <object data=\"{$saveName}\" type=\"application/pdf\" class='internal box'></object>
                            </div>
                          </body>
                        </html>";
            }else{
                echo "<script type='text/javascript'>window.location.replace('./dllFiles.php?fichier=$saveName');setTimeout(function () { window.close();}, 10000);</script>";
            //    echo "<script type='text/javascript'>alert('Export failed'); window.close();</script>";
            }
        }
    }
    catch(SSRSReportException $serviceExcprion)
    {
        echo  "\n<br/>" . $serviceExcprion->GetErrorMessage();
        $trace = str_replace("#", "<br />", $serviceExcprion->getTraceAsString());
        echo  "<br />" . $trace;
    }

    function getRenderType($type)
    {

        switch($type)
        {
            case "CSV":
                return new RenderAsCSV();

            case "EXCEL":
                return new RenderAsEXCEL();

            case "IMAGE":
                return new RenderAsIMAGE();

            case "PDF":
                return new RenderAsPDF();

            case "WORD":
                return new RenderAsWORD();

            case "XML":
                return new RenderAsXML();

            default:
                return null;
        }
    }

    function getExtension($type)
    {

        switch($type)
        {
            case "CSV":
                return ".csv";

            case "EXCEL":
                return ".xls";

            case "IMAGE":
                return ".jpg";

            case "PDF":
                return ".pdf";

            case "WORD":
                return ".doc";

            case "XML":
                return ".xml";

            default:
                return null;
        }
    }

    function getStreamRootParams()
    {
        $params = null;
        $module = null;
        $i=0;
        foreach($_REQUEST as $key => $post)
        {
            if($key == "params")
                continue;
            if(strpos($key,'rc:') === 0)
                continue;
            if(strpos($key,'rs:') === 0)
                continue;
            if(strpos($key,'ps:') === 0)
                continue;
            if($key!="module" && $key!="action")
            {
                if(!empty($post))
                {
                    $params .= $key . '=' . $post . '$$';
                    $i++;
                }
            }else{
                if($key=="module")
                    $module .= $key . '=' . $post . '&';
                if($key=="action")
                    $module .= $key . '=' . $post . '';
                $i++;
            }
            if($i > 100)
                break;
        }

        return ($params == null ? null: '?params=' . $params);
    }

    function getReportParameters($ex)
    {

        $parameters = array();
        $i=0;
        foreach($_POST as $key => $post)
        {
            /*
            if($ex && $key == "reportName")
                continue;
            if($key == "parameters")
                continue;
            if($key == "exportSelect")
                continue;
            if($key == "exportName")
                continue;
            */
            if($ex && $key == "reportName")
                continue;
            if($key == "parameters")
                continue;
            if($key == "exportSelect")
                continue;
            if($key == "exportName")
                continue;
            if($key == "params")
                continue;
            if($key == "module")
                continue;
            if($key == "action")
                continue;
            if(strpos($key,'rc:') !== false)
                continue;
            if(strpos($key,'rs:') !== false)
                continue;
            if(strpos($key,'ps:') !== false)
                continue;

            if(!empty($post))
            {
                $parameters[$i] = new ParameterValue();
                $parameters[$i]->Name = $key;
                $parameters[$i]->Value = $post;
                $i++;
            }
            if($i > 100)
                break;
        }
        return $parameters;
    }

    function getExportFormats($ssrs_report)
    {
        $extensions = $ssrs_report->ListRenderingExtensions();
        $result = array();
        foreach($extensions as $extension)
        {
            $result[] = $extension->Name;
        }

        /*$controls = "Format d'impression: <select id='exportSelect' class='form-control' name='exportSelect' onchange='exportType(value)' >";
        foreach ($result as $format)
        {
            $selected = ($format == "HTML4.0")
                ? "selected='selected'"
                : "";

            if($format != "RGDI" && $format != "RPL")
                $controls .= "\n<option value='$format' $selected>$format</option>";
        }
        $controls .= "\n</select>";
        return $controls;*/
        return "<input type='hidden' id='exportSelect' class='form-control' name='exportSelect'/>";
    }
    ?>

    <div align="center">
        <div style='background-color:gray; width:700px; height: 50px; text-align: left;' align='left'>
            <?php echo $controls; ?>
        </div>
    </div>
</form>
</body>
</html>
