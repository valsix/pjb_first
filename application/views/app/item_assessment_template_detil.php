<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->library('Classes/PHPExcel');


$this->load->model("base-app/KategoriItemAssessment");
$this->load->model("base-app/KonfirmasiItemAssessment");
$this->load->model("base-app/ProgramItemAssessment");
$this->load->model("base-app/StandarReferensi");




// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

$objPHPexcel = PHPExcel_IOFactory::load('template/export/item_assessment_detil.xlsx');
$objPHPExcel = new PHPExcel();


$BStyle = array(
	'borders' => array(
		'allborders' => array(

			'style' => PHPExcel_Style_Border::BORDER_THIN
		)				
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
	)
);

$style = array(
	'borders' => array(
		'allborders' => array(

			'style' => PHPExcel_Style_Border::BORDER_THIN
		)				
	),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        'wrap' => true
    )
);
$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style);

$sheetIndex= 1;
$objPHPexcel->setActiveSheetIndex($sheetIndex);
$objWorksheet= $objPHPexcel->getActiveSheet();
$objWorksheet->getStyle("A1")->applyFromArray($BStyle);
$objWorksheet->getStyle("B1")->applyFromArray($BStyle);
$objWorksheet->getStyle("C1")->applyFromArray($BStyle);
$objWorksheet->getStyle("D1")->applyFromArray($BStyle);


$objWorksheet->setCellValue("A1","Kategori Item Assessment Id");
$objWorksheet->setCellValue("B1","Kode");
$objWorksheet->setCellValue("C1","Nama");
$objWorksheet->setCellValue("D1","Bobot");

$row = 2;
$tempRowAwal= 1;

$field= array();
$field= array("KATEGORI_ITEM_ASSESSMENT_ID","KODE","NAMA","BOBOT");

$statement=" AND A.STATUS IS NULL";

$set = new KategoriItemAssessment();
$sOrder=" ORDER BY KATEGORI_ITEM_ASSESSMENT_ID ASC ";
$set->selectByParams(array(), -1,-1, $statement,$sOrder);
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

$objPHPExcel->createSheet();
$objPHPexcel->setActiveSheetIndex($sheetIndex);
$objWorksheet2= $objPHPexcel->getActiveSheet();
$objWorksheet2->getStyle("A1")->applyFromArray($BStyle);
$objWorksheet2->getStyle("B1")->applyFromArray($BStyle);
$objWorksheet2->getStyle("C1")->applyFromArray($BStyle);
$objWorksheet2->getStyle("D1")->applyFromArray($BStyle);



$objWorksheet2->setCellValue("A1","Konfirmasi Item Assessment Id");
$objWorksheet2->setCellValue("B1","Kode");
$objWorksheet2->setCellValue("C1","Nilai");
$objWorksheet2->setCellValue("D1","Nama");
$objWorksheet2->setCellValue("E1","Keterangan");


$row = 2;
$tempRowAwal= 1;

$field= array();
$field= array("KONFIRMASI_ITEM_ASSESSMENT_ID","KODE","NILAI","NAMA","KETERANGAN");

$statement="";

$set = new KonfirmasiItemAssessment();
$sOrder=" ORDER BY A.KONFIRMASI_ITEM_ASSESSMENT_ID ASC";
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

$objPHPExcel->createSheet();
$objPHPexcel->setActiveSheetIndex($sheetIndex);
$objWorksheet3= $objPHPexcel->getActiveSheet();
$objWorksheet3->getStyle("A1")->applyFromArray($BStyle);
$objWorksheet3->getStyle("B1")->applyFromArray($BStyle);
$objWorksheet3->getStyle("C1")->applyFromArray($BStyle);
$objWorksheet3->getStyle("D1")->applyFromArray($BStyle);

$objWorksheet3->setCellValue("A1","Program Item Assessment Id");
$objWorksheet3->setCellValue("B1","Kode");
$objWorksheet3->setCellValue("C1","Nama");
$objWorksheet3->setCellValue("D1","Rating");


$row = 2;
$tempRowAwal= 1;

$field= array();
$field= array("PROGRAM_ITEM_ASSESSMENT_ID","KODE","NAMA","RATING");

$statement="";

$set = new ProgramItemAssessment();
$sOrder=" ORDER BY A.PROGRAM_ITEM_ASSESSMENT_ID ASC";
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

$sheetIndex= 4;

$objPHPExcel->createSheet();
$objPHPexcel->setActiveSheetIndex($sheetIndex);
$objWorksheet4= $objPHPexcel->getActiveSheet();
$objWorksheet4->getStyle("A1")->applyFromArray($BStyle);
$objWorksheet4->getStyle("B1")->applyFromArray($BStyle);
$objWorksheet4->getStyle("C1")->applyFromArray($BStyle);
$objWorksheet4->getStyle("D1")->applyFromArray($BStyle);
$objWorksheet4->getStyle("E1")->applyFromArray($BStyle);
$objWorksheet4->getStyle("F1")->applyFromArray($BStyle);
$objWorksheet4->getStyle("G1")->applyFromArray($BStyle);

$objWorksheet4->setCellValue("A1","Standar Referensi Id");
$objWorksheet4->setCellValue("B1","Kode");
$objWorksheet4->setCellValue("C1","Institusi");
$objWorksheet4->setCellValue("D1","Nomor");
$objWorksheet4->setCellValue("E1","Tahun Terbit");
$objWorksheet4->setCellValue("F1","Bab");
$objWorksheet4->setCellValue("G1","Deskripsi ");


$row = 2;
$tempRowAwal= 1;

$field= array();
$field= array("STANDAR_REFERENSI_ID","KODE","NAMA","NOMOR","TAHUN","BAB","DESKRIPSI");

$statement="";

$set = new StandarReferensi();
$sOrder=" ORDER BY A.STANDAR_REFERENSI_ID ASC";
$set->selectByParams(array(), -1,-1, $statement,$sOrder);
while($set->nextRow())
{
	$index_kolom= 1;
	for($i=0; $i<count($field); $i++)
	{
		$kolom= getColoms($index_kolom);
		
		$objWorksheet4->getStyle($kolom.$row)->applyFromArray($style);
		$objWorksheet4->setCellValue($kolom.$row,$set->getField($field[$i]));
		$objWorksheet4->getColumnDimension($kolom)->setAutoSize(TRUE);
		
		$index_kolom++;
	}
	$row++;

}

$objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel5');
$objWriter->save('template/import/item_assessment_formulir.xls');

$down = 'template/import/item_assessment_formulir.xls';
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