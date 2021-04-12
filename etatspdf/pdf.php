<?php
 ob_start();
 require_once("../vendor/autoload.php");
?>
<?php
	$configs = array(
			'margin-top' => '14mm',
			'margin-left' => '10mm',
			'margin-bottom' => '14mm',
			'margin-right' => '10mm',
			'orientation' => 'p',
			'format' => 'A4',
			'lang' => 'fr',
			'display' => 'fullpage',
			'file' => 'output.pdf',
			'content' => ''
		);
	if(isset($params))
		$configs = array_merge($configs,$params);

?>
<page style="font-size: 11px" backtop="<?php echo $configs['margin-top']; ?>" backbottom="<?php echo $configs['margin-bottom']; ?>" backleft="<?php echo $configs['margin-left']; ?>" backright="<?php echo $configs['margin-right']; ?>">
	<page_header>
	<div>
		<table align="center">
			<tr>
				<td style="border:1px solid #333; width:695px; height:85px;">
				<?php
                    if(isset($configs['header']))
                    	echo $configs['header']; 
                    else
                    	include("../etatspdf/pdf_header.php");
                   ?>
				  </td>
			</tr>
		</table>
		</div>
    </page_header>
    <page_footer>
		<div style="height:20px;">
		<table align="center" style=" background:#ccc">
			<tr>
				<td style="width:630px;"><?php
                    if(isset($configs['footer']))
                    	echo $configs['footer']; 
                    else
                    	include("../etatspdf/pdf_footer.php");
                   ?>
				</td>
				<td style="text-align: right; width:100px">page [[page_cu]]/[[page_nb]]</td>
			</tr>
		</table>
		</div>
    </page_footer>
	<?php echo $configs['content']; ?>
</page>
<?php
$content = ob_get_clean();	
try
{
	header('Content-type: application/pdf');
    $html2pdf = new HTML2PDF($configs["orientation"],$configs["format"], $configs["lang"]);
    //$html2pdf->pdf->SetDisplayMode($configs["display"]);
    $html2pdf->writeHTML($content, false);
    $html2pdf->Output($configs["file"],false);
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}
die();
 ?>