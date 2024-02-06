<?
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_apping(E_ALL);

ini_set('max_execution_time', 2500); //300 seconds = 5 minutes
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

include_once("assets/MPDF60/mpdf.php");

$this->load->model("base-app/CetakFormUjiDinamis");
$this->load->model('base-app/PlanRla');
$this->load->model('base-app/FormUji');
$this->load->model('base-app/Nameplate');



$reqId	  	= $this->input->get("reqId");
$reqCheck  	= $this->input->get("reqCheck");
$reqMode  	= $this->input->get("reqMode");
$reqKelompokEquipmentId  	= $this->input->get("reqKelompokEquipmentId");
$reqKelompokEquipmentParentId  	= $this->input->get("reqKelompokEquipmentParentId");
$reqIdParent  	= $this->input->get("reqIdParent");


if($reqCheck==1)
{
$statement = " AND D.PLAN_RLA_ID = '".$reqId."' AND F.KELOMPOK_EQUIPMENT_ID = '".$reqKelompokEquipmentId."'  ";
}
else
{

$statement = " AND D.PLAN_RLA_ID = '".$reqId."'  AND LEFT(F.ID,3)  LIKE '%".$reqIdParent."%'  ";
}

$set= new CetakFormUjiDinamis();
$arrnameplate= [];


$set->selectByParamsFormUjiReportNameplateNew(array(), -1, -1, $statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["NAMEPLATE_ID"]= $set->getField("NAMEPLATE_ID");
    $arrdata["MASTER_ID"]= $set->getField("MASTER_ID");
    $arrdata["NAMA_NAMEPLATE"]= $set->getField("NAMA_NAMEPLATE");
    $arrdata["KELOMPOK_EQUIPMENT_ID"]= $set->getField("KELOMPOK_EQUIPMENT_ID");
    $arrdata["NAMA_KELOMPOK"]= $set->getField("NAMA_KELOMPOK");
    $arrdata["PARENT_ID"]= $set->getField("PARENT_ID");
    $arrdata["ID"]= $set->getField("ID");

    if(!empty($arrdata["NAMEPLATE_ID"]))
    {
        array_push($arrnameplate, $arrdata);
    }
}

unset($set);

$arrformuji= [];
if($reqCheck==1)
{
$statement = " AND D.PLAN_RLA_ID = '".$reqId."' AND D.KELOMPOK_EQUIPMENT_ID = '".$reqKelompokEquipmentId."'  ";
}
else
{

$statement = " AND D.PLAN_RLA_ID = '".$reqId."'  AND LEFT(E.ID,3)  LIKE '%".$reqIdParent."%'  ";

}

$set= new CetakFormUjiDinamis();


$set->selectByParamsFormUjiReport(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["FORM_UJI_ID"]= $set->getField("FORM_UJI_ID");
    $arrdata["KELOMPOK_EQUIPMENT_ID"]= $set->getField("KELOMPOK_EQUIPMENT_ID");
    $arrdata["NAMA"]= $set->getField("NAMA");
    $arrdata["NAMA_KELOMPOK"]= $set->getField("NAMA_KELOMPOK");
    $arrdata["JUMLAH"]= $set->rowCount;
    $arrdata["NAMEPLATE_ID"]= $set->getField("NAMEPLATE_ID");
    $arrdata["PARENT_ID"]= $set->getField("PARENT_ID");
    $arrdata["ID"]= $set->getField("ID");

    array_push($arrformuji, $arrdata);
}
unset($set);





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

// $arrData = array("reqId"=>$reqId, "reqIdParent"=>$reqIdParent, "reqKelompokEquipmentId"=>$reqKelompokEquipmentId, "reqKelompokEquipmentParentId"=>$reqKelompokEquipmentParentId, "reqIdParent"=>$reqIdParent);

$html="";


if(!empty($arrnameplate))
{

	foreach ($arrnameplate as $key => $vnameplate) 
	{

		$reqNameplateNewId= $vnameplate["NAMEPLATE_ID"];
		$reqNamaNameplate= $vnameplate["NAMA_NAMEPLATE"];
		$reqKelompokEquipmentNewId= $vnameplate["KELOMPOK_EQUIPMENT_ID"];
		$reqKelompokEquipment= $vnameplate["NAMA_KELOMPOK"];
		$reqIdParent= $vnameplate["PARENT_ID"];
		if($reqIdParent==0)
		{
			$reqIdParent= $vnameplate["ID"];
		}


		$urllink=base_url()."report/index/cetak_pdf_plan_rla_nameplate.php?reqId=".$reqId."&reqIdParent=".$reqIdParent."&reqKelompokEquipmentId=".$reqKelompokEquipmentNewId."&reqNameplateId=".$reqNameplateNewId."&reqIdParent=".$reqIdParent."&reqCheck=".$reqCheck;
      
		// $html .= $this->load->view("app/cetak_pdf_plan_rla_nameplate", $arrData, true);
		$html.= file_get_contents($urllink);
		$html.= "<pagebreak />";

    }

}

if(!empty($arrformuji))
{
	foreach ($arrformuji as $key => $value) 
	{

		$reqNamaFormUji= $value["NAMA"];
		$reqFormUjiNewId=$value["FORM_UJI_ID"];
		$reqKelompokEquipmentNewId=$value["KELOMPOK_EQUIPMENT_ID"];
		$reqIdParent= $value["PARENT_ID"];
		$reqKelompokEquipment= $value["NAMA_KELOMPOK"];
		if($reqIdParent==0)
		{
			$reqIdParent= $value["ID"];
		}

		$urllink=base_url()."report/index/cetak_pdf_plan_rla_form_uji.php?reqId=".$reqId."&reqIdParent=".$reqIdParent."&reqKelompokEquipmentId=".$reqKelompokEquipmentNewId."&reqFormUjiId=".$reqFormUjiNewId."&reqIdParent=".$reqIdParent."&reqCheck=".$reqCheck;
      
		$html.= file_get_contents($urllink);

		// print_r($urllink);
		$html.= "<pagebreak />";

    }

}

$stylesheet = file_get_contents('css/cetak_plan_rla.css'); // external css
$mpdf->WriteHTML($stylesheet,1);

// print_r($html);exit;

// exit;


// $html .= $this->load->view("app/cetak_".$reqMode, $arrData, true);

$mpdf->WriteHTML($html, 2);
$mpdf->Output('cetak_'.$reqMode.'_tes_pdf.pdf', 'I');
exit;
