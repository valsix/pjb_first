<?php
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
// include_once("lib/phpqrcode/qrlib.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
require_once('vendor/autoload.php');

$this->load->model("base-app/CetakFormUjiDinamis");
$this->load->model('base-app/PlanRla');
$this->load->model('base-app/FormUji');
$this->load->model('base-app/Nameplate');

use mikehaertl\wkhtmlto\Pdf;


class ReportPDFWk
{
	var $reqId;
	var $reqTemplate;
	var $reqJenisReport;
	// function generate($reqId, $reqLink, $="",$reqBulan="",$reqTahun="",$reqJenisKgb="",$reqPegawaiId="")
	function generate($arrparam)
	{
		// print_r($reqTemplate);exit;
		$reqId= $arrparam["reqId"];
		$reqLink= $arrparam["reqLink"];
		$reqCheck= $arrparam["reqCheck"];
		$reqMode= $arrparam["reqMode"];
		$reqKelompokEquipmentId= $arrparam["reqKelompokEquipmentId"];
		$reqKelompokEquipmentParentId= $arrparam["reqKelompokEquipmentParentId"];
		$reqIdParent= $arrparam["reqIdParent"];

		
		$CI = &get_instance();

		$basereport= $CI->config->item('base_url');

		$arrContextOptions=array(
			"ssl"=>array(
				"verify_peer"=>false,
				"verify_peer_name"=>false,
			),
		);


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


				$urllink=$basereport."report/loadUrl/report/cetak_pdf_plan_rla_nameplate.php?reqId=".$reqId."&reqIdParent=".$reqIdParent."&reqKelompokEquipmentId=".$reqKelompokEquipmentNewId."&reqNameplateId=".$reqNameplateNewId."&reqIdParent=".$reqIdParent."&reqCheck=".$reqCheck;

		// $html .= $this->load->view("app/cetak_pdf_plan_rla_nameplate", $arrData, true);
				$html.=file_get_contents($urllink, false, stream_context_create($arrContextOptions));
				// $html.= "<pagebreak />";

			}

		}

		if(!empty($arrformuji))
		{
			$i = 0;
			$len = count($arrformuji);

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

				$reqAkhir="";;

				if ($i == $len - 1) {

					$reqAkhir=1;
				}

				$urllink=$basereport."report/loadUrl/report/cetak_pdf_plan_rla_form_uji.php?reqId=".$reqId."&reqIdParent=".$reqIdParent."&reqKelompokEquipmentId=".$reqKelompokEquipmentNewId."&reqFormUjiId=".$reqFormUjiNewId."&reqIdParent=".$reqIdParent."&reqCheck=".$reqCheck."&reqAkhir=".$reqAkhir."&reqIya=".$reqIya;

				$html.= file_get_contents($urllink, false, stream_context_create($arrContextOptions));


				$i++;
			}
		}

		// exit;


		$set= new CetakFormUjiDinamis();

		$statement = " AND A.PLAN_RLA_ID = '".$reqId."' ";
		$set->selectByParams(array(), -1, -1, $statement);
		$set->firstRow();
		$reqUnit = $set->getField("NAMA_UNIT");
		$reqTahun = $set->getField("TAHUN");
		$reqKodeMaster = $set->getField("KODE_MASTER_PLAN");
		$reqIya = $set->getField("STATUS_CATATAN");

		// print_r($reqIya);exit;
		unset($set);

		if($reqIya==1)
		{
			$urllink=$basereport."report/loadUrl/report/cetak_pdf_plan_rla_catatan.php?reqId=".$reqId."&reqIdParent=".$reqIdParent."&reqKelompokEquipmentId=".$reqKelompokEquipmentNewId."&reqFormUjiId=".$reqFormUjiNewId."&reqIdParent=".$reqIdParent."&reqCheck=".$reqCheck;
			$html.= file_get_contents($urllink, false, stream_context_create($arrContextOptions));
		}


		$wkhtmltopdf = new PDF($html);

		$wkhtmltopdf->setOptions(
		    array(
		        "javascript-delay" => 1000
		        // , "margin-left"=> 25
		        // , "margin-right"=> 25
		        // , "margin-top"=> 10
		        , "margin-bottom"=> 20
				, "page-width" => '215'
				, "page-height" => '330'
		    )
		);

		if (!$wkhtmltopdf->send()) {
		    $error = $wkhtmltopdf->getError();
		    // ... handle error here
		    echo $error;
		}
		exit;
	}
}
