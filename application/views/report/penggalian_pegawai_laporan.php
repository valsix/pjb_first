<?php
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-asesor/JadwalPegawai");
$this->load->model("base-asesor/JadwalAsesor");
$this->load->model("base-asesor/KelasJabatan");

$reqJadwalTesId= $this->input->get("reqJadwalTesId");
$reqPegawaiId= $this->input->get("reqPegawaiId");
$reqPenggalianId= $this->input->get("reqPenggalianId");

$statement= "
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
$reqJadwalPegawaiPermenId= $set->getField("PERMEN_ID");
$reqJadwalPegawaiNama= $set->getField("PEGAWAI_NAMA");
$reqJadwalPegawaiNamaJabatan= $set->getField("NAMA_JABATAN");
$reqJadwalPegawaiKelasJabatanKelompok= $set->getField("KELAS_JABATAN_KELOMPOK");
$reqJadwalPegawaiTanggalTes= getFormattedDate($set->getField("TANGGAL_TES_NAMA"));
$reqJadwalPegawaiKompetensiId= $set->getField("PROFIL_KOMPETENSI_ID_PARENT");
$reqJadwalPegawaiPerusahaan= $set->getField("PERUSAHAAN_NAMA");

$baseimage= $this->config;
$baseimage= $baseimage->config["baseimage"];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<base href="<?=base_url()?>">
	<link rel="stylesheet" href="assets/css/cetaknew.css" type="text/css">
</head>
<body>
	<div class="container">
		<!-- start halaman 1 -->
		<div style="margin-bottom: 30px ; text-align: center">
			<p style="font-family: calibri; font-size: 14pt;"><strong><?=$reqJadwalPegawaiNama?><br>
			</strong></p>			
		</div>

		<div style="border: 3px solid black; padding: 30px,30px,0px,30px; margin: 50px,0px,50px,0px">
			<table >
				<tr style="border: solid black 1px">
					<td>
						<table>
							<tr>
								<td>
									<?
					                $newfoto= $baseimage.$reqJadwalTesId."/photo/pic_".$reqPegawaiId.".jpeg";
									if(!file_exists($newfoto))
									{
										$newfoto= "assets/images/FotoContoh.jpg";
					            	}
					                ?>
									<img src="<?=$newfoto?>" style="width: 120px; height: 180px; margin-right: 30px;">
								</td>
							</tr>
						</table>
					</td>
					<td>
						<table style="border: solid black 1 px; width: 100%">
							<tr>
								<td>
									PERUSAHAAN 	:
								</td>
							</tr>
							<tr>
								<td>
									<b><?=$reqJadwalPegawaiPerusahaan?></b>
									<hr>
								</td>
							</tr>
							<tr></tr>
							<tr>
								<td>
									POSISI SAAT INI 	:
								</td>
							</tr>
							<tr>
								<td>
									<b><?=$reqJadwalPegawaiNamaJabatan?></b>
									<hr>
								</td>
							</tr>
							<tr></tr>
							<tr>
								<td>
									KELAS JABATAN	:
								</td>
							</tr>
							<tr>
								<td>
									<b><?=$reqJadwalPegawaiKelasJabatanKelompok?></b>
									<hr>
								</td>
							</tr>
							<tr></tr>
							<tr>
								<td>
									TANGGAL PELAKSANAAN ASSESSMENT 	:
								</td>
							</tr>
							<tr>
								<td>
									<b><?=$reqJadwalPegawaiTanggalTes?></b>
									<hr>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>

		<div style="margin-bottom: 30px; text-align: center">
			<center><img src="assets/images/cetakan_pelindo.jpg"></center>			
		</div>

		<!-- end halaman 1 -->
		<pagebreak />

		<!-- start halaman 3 -->
		<?
		$setdetil= new KelasJabatan();
		$statement= " AND A.UJIAN_ID = ".$reqJadwalTesId." AND A.PEGAWAI_ID = ".$reqPegawaiId." AND A.PENGGALIAN_ID = ".$reqPenggalianId;
		$setdetil->selectByParamsLaporanUjianPenggalian(array(), -1, -1, $statement);
		$setdetil->firstRow();
							  // echo $setdetil->query;exit;
		$infodetilketerangan= $setdetil->getField("KETERANGAN");
		?>
		<div>
			<p style="font-family: calibri; font-size: 14pt;"><strong>Laporan<br>
			</strong></p>			
		</div>

		<div class="center" style="margin-left: 30px; ">
			<table style="border: 3px solid black;  width: 100%; border-collapse: collapse;">
				<tr>
					<td style="padding-left: 10px; padding-right: 10px;"><?=$infodetilketerangan?></td>
				</tr>
			</table>
		</div>

	</div>
</body>
</html>