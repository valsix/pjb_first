<?php
include_once("assets/lib/MPDF60/mpdf.php");
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
			$urllink= $CI->config->item('base_report')."report/loadUrl/report/laporan_psikologi/?reqJadwalTesId=".$reqJadwalTesId."&reqPegawaiId=".$reqPegawaiId."&reqAsesorId=".$reqAsesorId;

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

		// $mpdf->SetDefaultBodyCSS('background', "url('../WEB-INF/images/bg-cetak.jpg')");
		$mpdf->SetDefaultBodyCSS('background', "url('assets/images/bg-cetak.jpg')");
		$mpdf->SetDefaultBodyCSS('background-image-resize', 6);

		$mpdf->SetHTMLFooter('<div style="text-align: right;color:black"><b>RATIH PARAMITHA - {PAGENO}</b></div>');
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

		// $mpdf->SetDefaultBodyCSS('background', "url('../WEB-INF/images/bg-cetak.jpg')");
		$mpdf->SetDefaultBodyCSS('background', "url('assets/images/bg-cetak.jpg')");
		$mpdf->SetDefaultBodyCSS('background-image-resize', 6);

		$mpdf->SetHTMLFooter('<div style="text-align: right;color:black"><b>RATIH PARAMITHA - {PAGENO}</b></div>');
		$mpdf->WriteHTML($html,2);

		$saveAs= "penggalian".(generateZero($reqJadwalTesId, 6) . generateZero($reqPegawaiId, 6));
		$mpdf->Output($FILE_DIR . $saveAs . ".pdf", "F");
		return $saveAs . ".pdf";
	}
}
