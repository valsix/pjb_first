<?php
include_once("assets/MPDF60/mpdf.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");

class ReportPDF
{
	var $reqId;
	var $reqTemplate;
	var $reqJenisReport;
	function generate($reqJadwalTesId, $reqPegawaiId, $reqAsesorId, $reqJenis)
	{
		$FILE_DIR= "uploads/".$reqJadwalTesId."/";
		if (!file_exists($FILE_DIR)) 
		{
			makedirs($FILE_DIR, 0777, true);
		}

		$CI = &get_instance();
		// $urllink= $CI->config->item('base_report')."report/index/laporan/?reqJadwalTesId=".$reqJadwalTesId."&reqPegawaiId=".$reqPegawaiId."&reqAsesorId=".$reqAsesorId;

		if(empty($reqJenis))
			$urllink= $CI->config->item('base_report')."report/loadUrl/report/laporan/?reqJadwalTesId=".$reqJadwalTesId."&reqPegawaiId=".$reqPegawaiId."&reqAsesorId=".$reqAsesorId;
		else
		{
			if($reqJenis == "kompetensipds")
				$urllink= $CI->config->item('base_report')."report/loadUrl/report/laporan_kompetensi_pds/?reqJadwalTesId=".$reqJadwalTesId."&reqPegawaiId=".$reqPegawaiId."&reqAsesorId=".$reqAsesorId;
			else
				$urllink= $CI->config->item('base_report')."report/loadUrl/report/laporan_psikologi/?reqJadwalTesId=".$reqJadwalTesId."&reqPegawaiId=".$reqPegawaiId."&reqAsesorId=".$reqAsesorId;
		}

		// echo $urllink;exit;
		$html = file_get_contents($urllink);
		// echo $html;exit;

		$mpdf = new mPDF('',    // mode - default ''
		 'FOLIO',    // format - A4, for example, default ''
		 0,     // font size - default 0
		 'cambria',    // default font family
		 10,    // margin_left
		 15,    // margin right
		 30,     // margin top
		 10,    // margin bottom
		 9,     // margin header
		 9,     // margin footer
		 'L');  // L - landscape, P - portrait

		$CI->load->model("base-asesor/JadwalPegawai");

		$statement= "
		AND E.JADWAL_TES_ID = ".$reqJadwalTesId."
		AND A.PEGAWAI_ID = ".$reqPegawaiId."
		AND EXISTS
		(
		  SELECT 1
		  FROM
		  (
		    SELECT A.JADWAL_TES_ID 
		    FROM jadwal_asesor A
		    WHERE JADWAL_TES_ID = ".$reqJadwalTesId." --AND A.ASESOR_ID = ".$reqAsesorId."
		    GROUP BY A.JADWAL_TES_ID
		  ) X WHERE C.JADWAL_TES_ID = X.JADWAL_TES_ID
		)";
		$set= new JadwalPegawai();
		$set->selectByParamsPegawai(array(), -1,-1, $statement);
		$set->firstRow();
		// echo $set->query;exit;
		$reqJadwalPegawaiNama= $set->getField("PEGAWAI_NAMA");

		// $mpdf->SetDefaultBodyCSS('background', "url('../WEB-INF/images/bg-cetak.jpg')");
		$mpdf->SetDefaultBodyCSS('background', "url('assets/images/bg-cetak.jpg')");
		$mpdf->SetDefaultBodyCSS('background-image-resize', 6);

		$mpdf->SetHTMLFooter('<div style="text-align: right;color:black"><b>'.$reqJadwalPegawaiNama.' - {PAGENO}</b></div>');
		$mpdf->WriteHTML($html,2);

		$saveAs= (generateZero($reqJadwalTesId, 6) . generateZero($reqPegawaiId, 6));
		$mpdf->Output($FILE_DIR . $saveAs . ".pdf", "F");
		return $saveAs . ".pdf";
	}

	function penggalianpegawai($reqJadwalTesId, $reqPegawaiId, $reqPenggalianId)
	{
		$FILE_DIR= "uploads/".$reqJadwalTesId."/";
		if (!file_exists($FILE_DIR)) 
		{
			makedirs($FILE_DIR, 0777, true);
		}

		$CI = &get_instance();
		$urllink= $CI->config->item('base_report')."report/loadUrl/report/penggalian_pegawai_laporan/?reqJadwalTesId=".$reqJadwalTesId."&reqPegawaiId=".$reqPegawaiId."&reqPenggalianId=".$reqPenggalianId;
		// echo $urllink;exit;
		$html = file_get_contents($urllink);
		// echo $html;exit;

		$mpdf = new mPDF('',    // mode - default ''
		 'FOLIO',    // format - A4, for example, default ''
		 0,     // font size - default 0
		 'cambria',    // default font family
		 10,    // margin_left
		 15,    // margin right
		 30,     // margin top
		 10,    // margin bottom
		 9,     // margin header
		 9,     // margin footer
		 'L');  // L - landscape, P - portrait

		$CI->load->model("base-asesor/JadwalPegawai");

		$statement= "
		AND E.JADWAL_TES_ID = ".$reqJadwalTesId."
		AND A.PEGAWAI_ID = ".$reqPegawaiId."
		AND EXISTS
		(
		  SELECT 1
		  FROM
		  (
		    SELECT A.JADWAL_TES_ID 
		    FROM jadwal_asesor A
		    WHERE JADWAL_TES_ID = ".$reqJadwalTesId." --AND A.ASESOR_ID = ".$reqAsesorId."
		    GROUP BY A.JADWAL_TES_ID
		  ) X WHERE C.JADWAL_TES_ID = X.JADWAL_TES_ID
		)";
		$set= new JadwalPegawai();
		$set->selectByParamsPegawai(array(), -1,-1, $statement);
		$set->firstRow();
		// echo $set->query;exit;
		$reqJadwalPegawaiNama= $set->getField("PEGAWAI_NAMA");

		// $mpdf->SetDefaultBodyCSS('background', "url('../WEB-INF/images/bg-cetak.jpg')");
		$mpdf->SetDefaultBodyCSS('background', "url('assets/images/bg-cetak.jpg')");
		$mpdf->SetDefaultBodyCSS('background-image-resize', 6);

		$mpdf->SetHTMLFooter('<div style="text-align: right;color:black"><b>'.$reqJadwalPegawaiNama.' - {PAGENO}</b></div>');
		$mpdf->WriteHTML($html,2);

		$saveAs= "penggalian".(generateZero($reqJadwalTesId, 6) . generateZero($reqPegawaiId, 6));
		$mpdf->Output($FILE_DIR . $saveAs . ".pdf", "F");
		return $saveAs . ".pdf";
	}
}
