<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->library('Classes/PHPExcel');

$this->load->model("base-app/Risiko");
$this->load->model("base-app/Dampak");
$this->load->model("base-app/Kemungkinan");


// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

$objPHPexcel = PHPExcel_IOFactory::load('template/export/matriks_risiko.xlsx');
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
$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style);

$sheetIndex= 1;
$objPHPexcel->setActiveSheetIndex($sheetIndex);
$objWorksheet= $objPHPexcel->getActiveSheet();
$objWorksheet->getStyle("A1")->applyFromArray($BStyle);
$objWorksheet->getStyle("B1")->applyFromArray($BStyle);


$objWorksheet->setCellValue("A1","Risiko Id");
$objWorksheet->setCellValue("B1","Nama");


$row = 2;
$tempRowAwal= 1;

$field= array();
$field= array("RISIKO_ID","NAMA");

$statement=" AND A.STATUS IS NULL";

$set = new Risiko();
$sOrder=" ORDER BY RISIKO_ID ASC ";
$set->selectByParams(array(), -1,-1, $statement,$sOrder);
// echo $set->query;exit;
while($set->nextRow())
{
	$index_kolom= 1;
	for($i=0; $i<count($field); $i++)
	{
		$kolom= getColoms($index_kolom);
		
		$objWorksheet->getStyle($kolom.$row)->applyFromArray($BStyle);
		$objWorksheet->setCellValue($kolom.$row,$set->getField($field[$i]));
		$objWorksheet->getColumnDimension($kolom)->setAutoSize(TRUE);
		
		$index_kolom++;
	}
	$row++;

}

$sheetIndex= 2;
$objPHPexcel->setActiveSheetIndex($sheetIndex);
$objWorksheet2= $objPHPexcel->getActiveSheet();
$objWorksheet2->getStyle("A1")->applyFromArray($BStyle);
$objWorksheet2->getStyle("B1")->applyFromArray($BStyle);


$objWorksheet2->setCellValue("A1","Dampak Id");
$objWorksheet2->setCellValue("B1","Nama");


$row = 2;
$tempRowAwal= 1;

$field= array();
$field= array("DAMPAK_ID","NAMA");

$statement=" AND A.STATUS IS NULL";

$set = new Dampak();
$sOrder=" ORDER BY DAMPAK_ID ASC ";
$set->selectByParams(array(), -1,-1, $statement,$sOrder);
while($set->nextRow())
{
	$index_kolom= 1;
	for($i=0; $i<count($field); $i++)
	{
		$kolom= getColoms($index_kolom);
		
		$objWorksheet2->getStyle($kolom.$row)->applyFromArray($BStyle);
		$objWorksheet2->setCellValue($kolom.$row,$set->getField($field[$i]));
		$objWorksheet2->getColumnDimension($kolom)->setAutoSize(TRUE);
		
		$index_kolom++;
	}
	$row++;

}

$sheetIndex= 3;
$objPHPexcel->setActiveSheetIndex($sheetIndex);
$objWorksheet3= $objPHPexcel->getActiveSheet();
$objWorksheet3->getStyle("A1")->applyFromArray($BStyle);
$objWorksheet3->getStyle("B1")->applyFromArray($BStyle);


$objWorksheet3->setCellValue("A1","Kemungkinan Id");
$objWorksheet3->setCellValue("B1","Nama");


$row = 2;
$tempRowAwal= 1;

$field= array();
$field= array("KEMUNGKINAN_ID","NAMA");

$statement=" AND A.STATUS IS NULL";

$set = new Kemungkinan();
$sOrder=" ORDER BY KEMUNGKINAN_ID ASC ";
$set->selectByParams(array(), -1,-1, $statement,$sOrder);
while($set->nextRow())
{
	$index_kolom= 1;
	for($i=0; $i<count($field); $i++)
	{
		$kolom= getColoms($index_kolom);
		
		$objWorksheet3->getStyle($kolom.$row)->applyFromArray($BStyle);
		$objWorksheet3->setCellValue($kolom.$row,$set->getField($field[$i]));
		$objWorksheet3->getColumnDimension($kolom)->setAutoSize(TRUE);
		
		$index_kolom++;
	}
	$row++;

}


$objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel5');
$objWriter->save('template/import/matriks_risiko.xls');

$down = 'template/import/matriks_risiko.xls';
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