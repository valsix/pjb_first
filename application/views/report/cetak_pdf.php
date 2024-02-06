<?
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

ini_set('max_execution_time', 2500); //300 seconds = 5 minutes
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

include_once("assets/MPDF60/mpdf.php");


$reqId	  	= $this->input->get("reqId");
$reqTipe  	= $this->input->get("reqTipe");
$reqMode  	= $this->input->get("reqMode");
$reqNameplateId  	= $this->input->get("reqNameplateId");



$mpdf = new mPDF('c', 'A4');

$mpdf->AddPage(
	'P', // L - landscape, P - portrait
	'',
	'',
	'',
	'',
	10, // margin_left
	10, // margin right
	10, // margin top
	10, // margin bottom
	9, // margin header
	9
);

$mpdf->mirroMargins = true;
$mpdf->SetDisplayMode('fullpage');
$mpdf->list_indent_first_level = 0;

// LOAD a stylesheet
$stylesheet = file_get_contents('css/permohonan-pdf.css');
$mpdf->WriteHTML($stylesheet, 1);

$arrData = array("reqId"=>$reqId, "reqTipe"=>$reqTipe, "reqNameplateId"=>$reqNameplateId);
$html .= $this->load->view("report/cetak_nameplate", $arrData, true);


$html .= $this->load->view("report/cetak_".$reqMode, $arrData, true);

$mpdf->WriteHTML($html, 2);
$mpdf->Output('cetak_'.$reqMode.'_pdf.pdf', 'I');
exit;