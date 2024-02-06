<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->library('Classes/PHPExcel');


$this->load->model("base-app/Distrik");
$this->load->model("base-app/MasterJabatan");
$this->load->model("base-app/RoleApproval");
$this->load->model("base-app/PerusahaanEksternal");



// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

$objPHPexcel = PHPExcel_IOFactory::load('template/user_external.xlsx');
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


$sheetIndex= 0;
$objPHPexcel->setActiveSheetIndex($sheetIndex);
$objWorksheet= $objPHPexcel->getActiveSheet(0);
$objWorksheet->getStyle("A1")->applyFromArray($BStyle);
$objWorksheet->getStyle("B1")->applyFromArray($BStyle);
$objWorksheet->getStyle("C1")->applyFromArray($BStyle);
$objWorksheet->getStyle("D1")->applyFromArray($BStyle);
$objWorksheet->getStyle("E1")->applyFromArray($BStyle);
$objWorksheet->getStyle("F1")->applyFromArray($BStyle);
$objWorksheet->getStyle("G1")->applyFromArray($BStyle);
$objWorksheet->getStyle("H1")->applyFromArray($BStyle);
$objWorksheet->getStyle("I1")->applyFromArray($BStyle);


$objWorksheet->setCellValue("A1","NID");
$objWorksheet->setCellValue("B1","Nama Lengkap");
$objWorksheet->setCellValue("C1","No Telpon");
$objWorksheet->setCellValue("D1","Email");
$objWorksheet->setCellValue("E1","Distrik ID");
$objWorksheet->setCellValue("F1","Position ID");
$objWorksheet->setCellValue("G1","Role Id");
$objWorksheet->setCellValue("H1","Perusahaan Id");
$objWorksheet->setCellValue("I1","Expired Date");


$objPHPExcel->createSheet();

$sheetIndex= 1;
$objPHPexcel->setActiveSheetIndex($sheetIndex);
$objWorksheet1= $objPHPexcel->getActiveSheet();
$objWorksheet1->getStyle("A1")->applyFromArray($BStyle);
$objWorksheet1->getStyle("B1")->applyFromArray($BStyle);
$objWorksheet1->getStyle("C1")->applyFromArray($BStyle);


$objWorksheet1->setCellValue("A1","Distrik ID");
$objWorksheet1->setCellValue("B1","Nama");
$objWorksheet1->setCellValue("C1","Kode");


$row = 2;
$tempRowAwal= 1;

$field= array();
$field= array("DISTRIK_ID", "NAMA", "KODE");

$statement="";
$sOrder=" ORDER BY A.DISTRIK_ID ASC";

$set = new Distrik();
$set->selectByParams(array(), -1,-1, $statement,$sOrder);
// echo  $set->query;exit;
while($set->nextRow())
{
	$index_kolom= 1;
	for($i=0; $i<count($field); $i++)
	{
		$kolom= getColoms($index_kolom);
		
		$objWorksheet1->getStyle($kolom.$row)->applyFromArray($BStyle);
		$objWorksheet1->setCellValue($kolom.$row,$set->getField($field[$i]));
		$objWorksheet1->getColumnDimension($kolom)->setAutoSize(TRUE);
		
		$index_kolom++;
	}
	$row++;

}


$objPHPExcel->createSheet();
$sheetIndex= 2;
$objPHPexcel->setActiveSheetIndex($sheetIndex);
$objWorksheet2= $objPHPexcel->getActiveSheet();
$objWorksheet2->getStyle("A1")->applyFromArray($BStyle);
$objWorksheet2->getStyle("B1")->applyFromArray($BStyle);
$objWorksheet2->getStyle("C1")->applyFromArray($BStyle);



$objWorksheet2->setCellValue("A1","Position ID / Kode");
$objWorksheet2->setCellValue("B1","Nama");
$objWorksheet2->setCellValue("C1","NID");


$row = 2;
$tempRowAwal= 1;

$field= array();
$field= array("POSITION_ID", "NAMA_POSISI","NID");

$statement=" AND NAMA_POSISI <> '' ";
$sOrder=" ORDER BY A.POSITION_ID ASC";

$set = new MasterJabatan();
$set->selectByParamsCombo(array(), -1,-1, $statement,$sOrder);
// echo  $set->query;exit;
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

$objPHPExcel->createSheet();
$sheetIndex= 3;
$objPHPexcel->setActiveSheetIndex($sheetIndex);
$objWorksheet3= $objPHPexcel->getActiveSheet();
$objWorksheet3->getStyle("A1")->applyFromArray($BStyle);
$objWorksheet3->getStyle("B1")->applyFromArray($BStyle);

$objWorksheet3->setCellValue("A1","Role Id");
$objWorksheet3->setCellValue("B1","Nama");


$row = 2;
$tempRowAwal= 1;

$field= array();
$field= array("ROLE_ID", "ROLE_NAMA");

$statement=" ";
$sOrder=" ORDER BY A.ROLE_ID ASC";

$set = new RoleApproval();
$set->selectByParams(array(), -1,-1, $statement,$sOrder);
// echo  $set->query;exit;
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

$objPHPExcel->createSheet();
$sheetIndex= 4;
$objPHPexcel->setActiveSheetIndex($sheetIndex);
$objWorksheet3= $objPHPexcel->getActiveSheet();
$objWorksheet3->getStyle("A1")->applyFromArray($BStyle);
$objWorksheet3->getStyle("B1")->applyFromArray($BStyle);
$objWorksheet3->getStyle("C1")->applyFromArray($BStyle);


$objWorksheet3->setCellValue("A1","Perusahaan External Id");
$objWorksheet3->setCellValue("B1","Nama");
$objWorksheet3->setCellValue("C1","Kode");



$row = 2;
$tempRowAwal= 1;

$field= array();
$field= array("PERUSAHAAN_EKSTERNAL_ID", "NAMA", "KODE");

$statement=" ";
$sOrder=" ORDER BY A.PERUSAHAAN_EKSTERNAL_ID ASC";

$set = new PerusahaanEksternal();
$set->selectByParams(array(), -1,-1, $statement,$sOrder);
// echo  $set->query;exit;
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
$objWriter->save('template/export/user_external.xls');

$down = 'template/export/user_external.xls';
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