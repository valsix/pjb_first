<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->library('Classes/PHPExcel');


$this->load->model("base-app/Crud");
$this->load->model("base-app/RoleApproval");
$this->load->model("base-app/PenggunaEksternal");
$this->load->model("base-app/Distrik");


// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

$objPHPexcel = PHPExcel_IOFactory::load('template/pengguna.xlsx');
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

$objWorksheet->setCellValue("A1","Username");
$objWorksheet->setCellValue("B1","Nama User");
$objWorksheet->setCellValue("C1","Hak Akses");
$objWorksheet->setCellValue("D1","Role Approval");
$objWorksheet->setCellValue("E1","Pengguna Eksternal");
$objWorksheet->setCellValue("F1","Distrik");


// =======================================================
$objPHPExcel->createSheet();
$sheetIndex= 1;
$objPHPexcel->setActiveSheetIndex($sheetIndex);
$objWorksheet3= $objPHPexcel->getActiveSheet();
$objWorksheet3->getStyle("A1")->applyFromArray($BStyle);
$objWorksheet3->getStyle("B1")->applyFromArray($BStyle);

$objWorksheet3->setCellValue("A1","Hak Akses ID");
$objWorksheet3->setCellValue("B1","Hak Akses Nama");
$objWorksheet3->setCellValue("C1","Hak Akses Deskripsi");


$row = 2;
$tempRowAwal= 1;

$field= array();
$field= array("PENGGUNA_HAK_ID", "NAMA_HAK", "DESKRIPSI");

$statement=" ";
$sOrder=" ORDER BY A.PENGGUNA_HAK_ID ASC";

$set = new Crud();
$set->selectByParams(array(), -1,-1, $statement, $sOrder);
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


// =======================================================
$objPHPExcel->createSheet();
$sheetIndex= 2;
$objPHPexcel->setActiveSheetIndex($sheetIndex);
$objWorksheet3= $objPHPexcel->getActiveSheet();
$objWorksheet3->getStyle("A1")->applyFromArray($BStyle);
$objWorksheet3->getStyle("B1")->applyFromArray($BStyle);

$objWorksheet3->setCellValue("A1","Role ID");
$objWorksheet3->setCellValue("B1","Role Nama");


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


// =======================================================
$objPHPExcel->createSheet();
$sheetIndex= 3;
$objPHPexcel->setActiveSheetIndex($sheetIndex);
$objWorksheet3= $objPHPexcel->getActiveSheet();
$objWorksheet3->getStyle("A1")->applyFromArray($BStyle);
$objWorksheet3->getStyle("B1")->applyFromArray($BStyle);
$objWorksheet3->getStyle("C1")->applyFromArray($BStyle);


$objWorksheet3->setCellValue("A1","Pengguna External ID");
$objWorksheet3->setCellValue("B1","Nama");
$objWorksheet3->setCellValue("C1","Jabatan");



$row = 2;
$tempRowAwal= 1;

$field= array();
$field= array("PENGGUNA_EXTERNAL_ID", "NAMA", "JABATAN_INFO");

$statement=" ";
$sOrder=" ORDER BY A.PENGGUNA_EXTERNAL_ID ASC";

$set = new PenggunaEksternal();
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


// =======================================================
$objPHPExcel->createSheet();
$sheetIndex= 4;
$objPHPexcel->setActiveSheetIndex($sheetIndex);
$objWorksheet3= $objPHPexcel->getActiveSheet();
$objWorksheet3->getStyle("A1")->applyFromArray($BStyle);
$objWorksheet3->getStyle("B1")->applyFromArray($BStyle);


$objWorksheet3->setCellValue("A1","Distrik ID");
$objWorksheet3->setCellValue("B1","Distrik Nama");

$row = 2;
$tempRowAwal= 1;

$field= array();
$field= array("DISTRIK_ID", "NAMA");

$statement=" ";
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
		
		$objWorksheet3->getStyle($kolom.$row)->applyFromArray($BStyle);
		$objWorksheet3->setCellValue($kolom.$row,$set->getField($field[$i]));
		$objWorksheet3->getColumnDimension($kolom)->setAutoSize(TRUE);
		
		$index_kolom++;
	}
	$row++;
}



$objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel5');
$objWriter->save('template/export/pengguna.xls');

$down = 'template/export/pengguna.xls';
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