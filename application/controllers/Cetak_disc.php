<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");
include_once("assets/lib/Classes/PHPExcel.php");
// include_once("libraries/Classes/PHPExcel.php");
// require("libraries/phpexcelchart/PHPExcel/IOFactory.php");

// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);


class cetak_disc extends CI_Controller {
	function __construct() {
		parent::__construct();
	}

	function cetak()
	{
		$reqId= $this->input->get("reqId");
		$reqTipeUjianId= $this->input->get("reqTipeUjianId");
		$reqPegawaiId= $this->input->get("reqRowId");
		$this->load->model("base-asesor/Rekap");

		$inputFileType = 'Excel2007';
		$inputFileName = 'template/tipeujian/disk.xlsx';

		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		// $objReader->setIncludeCharts(TRUE);
		$objPHPExcel = $objReader->load($inputFileName);

		$objWorksheet = $objPHPExcel->getActiveSheet();

		$statement= " AND B.UJIAN_ID = ".$reqId." AND B.PEGAWAI_ID = ".$reqPegawaiId;
		$set = new Rekap();
		$set->selectByParamsInfoPegawai(array(), -1, -1, $statement);
		$set->firstRow();
		$infopegawainama= $set->getField("NAMA_PEGAWAI");
		$infopegawaiumur= $set->getField("PEGAWAI_UMUR_NORMA");
		$infopegawaijeniskelamin= $set->getField("JENIS_KELAMIN");
		$infopegawaitanggalujian= $set->getField("TANGGAL_UJIAN");
		unset($set);

		$arrpegawaidata= array($infopegawainama, $infopegawaiumur, $infopegawaijeniskelamin, $infopegawaitanggalujian);
			// print_r($arrpegawaidata);exit();
		$rowdatacolom= 2;
		$rowdatarow=4;
		for($x=0; $x<count($arrpegawaidata);$x++)
		{
			$objWorksheet->setCellValue(toAlpha($rowdatacolom).$rowdatarow, $arrpegawaidata[$x]);
			$rowdatarow++;
		}

		$arrdata= array("D", "I", "S", "C");
		$statement= " AND A.UJIAN_ID = ".$reqId." AND A.PEGAWAI_ID = ".$reqPegawaiId;
		$set = new Rekap();
		$set->selectByParamsMonitoringDisc(array(), -1, -1, $reqId, $statement);
		$set->firstRow();
			 // echo $set->query;exit();
		$valdata= array();
		$indexdata=0;

		$rowdatarow=10;
		$rowdatanextrow=7;
		for($x=1; $x<=3;$x++)
		{
			$rowdatacolom= 3;
			$rowdatanextcolom= 53;
			for($y=0;$y<count($arrdata);$y++)
			{
				$modestatus= $arrdata[$y];
				$modestatuskondisi= $modestatus.$x;

				$field= $modestatus."_".$x;
				$nilai= $set->getField($field);
					// $valdata[$indexdata][$field]= $nilai;

				$statementdetil= " AND STATUS_AKTIF = 1 AND MODE_STATUS = '".$modestatuskondisi."' AND NILAI = ".$nilai;
				$setdetil= new Rekap();
				$hasil= $setdetil->setkonversidisk(array(), $statementdetil);
				unset($setdetil);
				$valdata[$indexdata][$field."_KONVERSI"]= $hasil;

				$objWorksheet->setCellValue(toAlpha($rowdatacolom).$rowdatarow, $nilai);
				$rowdatacolom++;

					// kalau data terakhir ambil data * dan x bukan 3
				if($y == count($arrdata) - 1 && $x < 3)
				{
					$nilai= $set->getField("X_".$x);
					$objWorksheet->setCellValue(toAlpha($rowdatacolom).$rowdatarow, $nilai);
				}

				$objWorksheet->setCellValue(toAlpha($rowdatanextcolom).$rowdatanextrow, $hasil);
				$rowdatanextcolom++;
			}
			$rowdatarow++;
			$rowdatanextrow= $rowdatanextrow + 2;
		}
		unset($set);
			// print_r($valdata);exit();

		$indexdata= 0;
		$nkesimpulan= array();
		for($x=1; $x<=3;$x++)
		{
			$d= $valdata[0]["D_".$x."_KONVERSI"];
			$i= $valdata[0]["I_".$x."_KONVERSI"];
			$s= $valdata[0]["S_".$x."_KONVERSI"];
			$c= $valdata[0]["C_".$x."_KONVERSI"];

			$setdetil= new Rekap();
			$hasil= $setdetil->setnkesimpulandisk($d, $i, $s, $c);
				// echo $setdetil->query;exit();
			unset($setdetil);

			$nkesimpulan[$indexdata]= $hasil;
			$indexdata++;
		}
			// print_r($nkesimpulan);exit();

		$infoketerangan= array(
			array("kolomindex"=>12, "rowindex"=>6)
			, array("kolomindex"=>21, "rowindex"=>6)
			, array("kolomindex"=>12, "rowindex"=>21, "deskripsikolomindex"=>11, "deskripsirowindex"=>44, "jobkolomindex"=>11, "jobrowindex"=>59)
		);
			// print_r($infoketerangan);exit();
			// echo toAlpha(12);exit();

		for($x=0; $x < count($infoketerangan); $x++)
		{
			$statementdetil= " AND A.LINE = ".$nkesimpulan[$x]." AND A.STATUS_AKTIF = 1";
			$setdetil= new Rekap();
			$setdetil->selectByParamsDiscKesimpulan(array(), -1,-1, $statementdetil);
			$setdetil->firstRow();
			$infokesimpulanjudul= $setdetil->getField("JUDUL");
			$infokesimpulanjuduldetil= $setdetil->getField("JUDUL_DETIL");
			$infokesimpulandeskripsi= $setdetil->getField("DESKRIPSI");
			$infokesimpulansaran= $setdetil->getField("SARAN");
			unset($setdetil);

			$colkesimpulan= $infoketerangan[$x]["kolomindex"];
			$rowkesimpulan= $infoketerangan[$x]["rowindex"];
			$objWorksheet->setCellValue(toAlpha($colkesimpulan).$rowkesimpulan, $infokesimpulanjudul);

			$rowkesimpulan++;
			$arrinfokesimpulanjuduldetil= explode("<br/>", $infokesimpulanjuduldetil);
				// print_r($arrinfokesimpulanjuduldetil);exit();
			$jumlahkesimpulan= count($arrinfokesimpulanjuduldetil);
			for($k=0; $k<$jumlahkesimpulan; $k++)
			{
				$objWorksheet->setCellValue(toAlpha($colkesimpulan).$rowkesimpulan, $arrinfokesimpulanjuduldetil[$k]);
					// echo toAlpha($colkesimpulan).$rowkesimpulan.";;".$arrinfokesimpulanjuduldetil[$k]."<br/>";
				$rowkesimpulan++;
			}

			if($x == 2)
			{
				$hasildeskripsi= $infokesimpulandeskripsi;
				$colkesimpulan= $infoketerangan[$x]["deskripsikolomindex"];
				$rowkesimpulan= $infoketerangan[$x]["deskripsirowindex"];
					// echo toAlpha($colkesimpulan).$rowkesimpulan.";;".$hasildeskripsi."<br/>";exit();
				$objWorksheet->setCellValue(toAlpha($colkesimpulan).$rowkesimpulan, $hasildeskripsi);

				$hasilsaran= $infokesimpulansaran;
				$colkesimpulan= $infoketerangan[$x]["jobkolomindex"];
				$rowkesimpulan= $infoketerangan[$x]["jobrowindex"];
					// echo toAlpha($colkesimpulan).$rowkesimpulan.";;".$hasilsaran."<br/>";exit();
				$objWorksheet->setCellValue(toAlpha($colkesimpulan).$rowkesimpulan, $hasilsaran);
			}

		}
			// exit();

		$outputFileName= 'template/tipeujian/hasil.xlsx';
		// $outputFileName= ' /var/www/html/portalcbt/asesor/template/tipeujian/hasil.xlsx';

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		// $objWriter->setIncludeCharts(TRUE);
		$objWriter->save($outputFileName);

		$objPHPExcel->disconnectWorksheets();
		unset($objPHPExcel);

		header('Content-Description: File Transfer');
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename='.basename($outputFileName));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($outputFileName));
		ob_clean(); flush();
		readfile($outputFileName);
		unlink($outputFileName);
		exit;
		
	}

}
?>