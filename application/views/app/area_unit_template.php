<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->library('Classes/PHPExcel');

$this->load->model("base-app/Peraturan");
$this->load->model("base-app/AreaUnit");
$this->load->model("base-app/ListArea");

$reqId = $this->input->get("reqId");


// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

$objPHPexcel = PHPExcel_IOFactory::load('template/export/area_unit.xlsx');
$objPHPExcel = new PHPExcel();

$BStyle = array(
	'borders' => array(
		'allborders' => array(

			'style' => PHPExcel_Style_Border::BORDER_THIN
		)				
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	)
);

$style = array(
	'borders' => array(
		'allborders' => array(

			'style' => PHPExcel_Style_Border::BORDER_THIN
		)				
	),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'wrap' => true
    )
);

$objPHPExcel->getSheetByName('Worksheet')
->setSheetState(PHPExcel_Worksheet::SHEETSTATE_VERYHIDDEN);

$set= new AreaUnit();
$statement = " AND A.AREA_UNIT_ID = '".$reqId."' ";
$set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
$set->firstRow();
$reqListAreaIdDetil= $set->getField("LIST_AREA_ID_INFO");


$tempRowAwal= 1;

$sheetIndex= 1;

if(!empty($reqListAreaIdDetil))
{

	$statement=" AND A.STATUS IS NULL 
	AND A.LIST_AREA_ID IN ( ".$reqListAreaIdDetil.") ";
	$set= new ListArea();

	$set->selectByParams(array(), -1,-1,$statement);
        // echo $set->query;exit;
	while($set->nextRow())
	{

		$listareaid =$set->getField("LIST_AREA_ID");
		$listareaNama =$set->getField("NAMA");

		// print_r($sheetIndex);

		$objWorksheet = $objPHPExcel->createSheet($sheetIndex);
		$objPHPExcel->setActiveSheetIndex($sheetIndex);
		$objWorksheet= $objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle($listareaNama);

		$objWorksheet->getStyle("C1")->applyFromArray($BStyle);
		$objWorksheet->getStyle("D1")->applyFromArray($BStyle);
		$objWorksheet->getStyle("E1")->applyFromArray($BStyle);


		$objWorksheet->setCellValue("C1","List Area");
		$objWorksheet->setCellValue("D1","Nama Area Di Unit");
		$objWorksheet->setCellValue("E1","Status");


		$row = 2;

		$new= new ListArea();
		$arrset= [];

		$statement=" AND A.STATUS IS NULL AND A.LIST_AREA_ID =  ".$listareaid." AND B.AREA_UNIT_ID =  ".$reqId."";
		$new->selectduplikat(array(), -1,-1,$statement);
        // echo $new->query;
		while($new->nextRow())
		{
			$arrdata= array();
			$arrdata["id"]= $new->getField("LIST_AREA_ID");
			$arrdata["text"]=$new->getField("KODE_INFO")." - ".$new->getField("NAMA");
			$arrdata["ITEM_ASSESSMENT_DUPLIKAT_ID"]= $new->getField("ITEM_ASSESSMENT_DUPLIKAT_ID");
			$arrdata["AREA_UNIT_DETIL_ID"]= $new->getField("AREA_UNIT_DETIL_ID");
			$arrdata["AREA_UNIT"]= $new->getField("AREA_UNIT");
			$arrdata["STATUS_CONFIRM"]= $new->getField("STATUS_CONFIRM");
			array_push($arrset, $arrdata);
		}

		foreach($arrset as $item) 
		{

			$index_area= 3;
			$index_unit= 4;
			$index_status= 5;
			$index_id_area= 1;
			$kolom_area= getColoms($index_area);
			$kolom_unit= getColoms($index_unit);
			$kolom_status= getColoms($index_status);
			$kolom_id_area= getColoms($index_id_area);

			$objWorksheet->getStyle($kolom_area.$row)->applyFromArray($BStyle);
			$objWorksheet->getStyle($kolom_unit.$row)->applyFromArray($BStyle);
			$objWorksheet->getStyle($kolom_status.$row)->applyFromArray($BStyle);
			$objWorksheet->setCellValue($kolom_id_area.$row,$item["AREA_UNIT_DETIL_ID"]);
			$objWorksheet->getColumnDimension('A')->setVisible(false);
			$objWorksheet->getColumnDimension('B')->setVisible(false);
			$objWorksheet->setCellValue($kolom_area.$row,$item["text"]);
			$objWorksheet->setCellValue($kolom_unit.$row,$item["AREA_UNIT"]);
			$objWorksheet->setCellValue($kolom_status.$row,$item["STATUS_CONFIRM"]);
			$objWorksheet->getColumnDimension($kolom_area)->setAutoSize(TRUE);
			$objWorksheet->getColumnDimension($kolom_unit)->setAutoSize(TRUE);
			$objWorksheet->getColumnDimension($kolom_status)->setAutoSize(TRUE);
			// print_r($kolom);
			// $index_kolom++;
			$row++;
			
		}

		$sheetIndex++;

	}

	unset($set);
}

// exit;



$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('template/import/area_unit.xls');

$down = 'template/import/area_unit.xls';
header('Content-Description: File Transfer');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename='.basename($down));
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($down));
ob_clean();
flush();
readfile($down);
unlink($down);
//unlink($save);
?>