<?
/* *******************************************************************************************************
MODUL NAME 			: 
FILE NAME 			: excel.func.php
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: Functions to handle string operation
***************************************************************************************************** */
include_once("application/libraries/phpexcelnew/Classes/PHPExcel.php");
// $this->load->library('Classes/PHPExcel');

function StyleExcel($id,$color,$align,$alignatas)
{
	$style=array();
	if($id ==1)
	{
		//style default tengah
		$style = array(
			'borders' => array(
				'allborders' => array(

					'style' => PHPExcel_Style_Border::BORDER_THIN
				)				
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			),
			'font'  => array(
				'size' => 8,
				'name'  => 'Tahoma'
				
			),
		);

		// print_r($style);exit;
	}
	elseif($id ==2)
	{
		$style = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array(
						'rgb' => 'FFFFFF'
					)	
				)

			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => '335593')
			),
			'font'  => array(
				'color' => array('rgb' => 'FFFFFF')
				
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			)		
		);
	}
	elseif($id ==3)
	{
		$style = array(
			'borders' => array(
				'allborders' => array(

					'style' => PHPExcel_Style_Border::BORDER_THIN
				)				
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => $color)
			),
			'font'  => array(
				'size' => 8,
				'name'  => 'Tahoma'
				
			),
		);
	}
	elseif($id ==4)
	{
		//style dinamis

		// print_r($align);exit;
		$styledinamis=array();
		$style = array(
			'borders' => array(
				'allborders' => array(

					'style' => PHPExcel_Style_Border::BORDER_THIN
				)				
			),
			'font' => [
				'size' => 8,
				'name'  => 'Tahoma'
			]
		);

		if($align)
		{
			if($alignatas){}
				else
				{ 
					$alignatas = 'horizontal';
				}

			$style["alignment"] = array(
					$alignatas => $align,
				);
		}

		if($color)
		{
			$style["fill"] = array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => $color)
			);
		}

		// print_r($style);exit;
	}

    return $style;
}

 

?>