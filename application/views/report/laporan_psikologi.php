<?php
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-asesor/JadwalPegawai");
$this->load->model("base-asesor/JadwalAsesor");
$this->load->model("base-asesor/KelasJabatan");

$reqJadwalTesId= $this->input->get("reqJadwalTesId");
$reqPegawaiId= $this->input->get("reqPegawaiId");
$reqAsesorId= $this->input->get("reqAsesorId");

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

$statement= " AND A.JADWAL_TES_ID = ".$reqJadwalTesId." AND A.JENIS = 4";
$set= new KelasJabatan();
$set->selectByParamsPetugas(array(), -1,-1, $statement);
$set->firstRow();
$infokepalanama= $set->getField("ASESOR_NAMA");
$infokepalanosk= $set->getField("ASESOR_NO_SK");

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
		
		<!-- start halaman 4 -->
		<div>
			<p style="font-family: calibri; font-size: 14pt;"><strong>I.	HASIL PEMERIKSAAN PSIKOLOGIS<br>
			</strong></p>			
		</div>
		<div class="center" style="margin-left: 30px; ">
			<table >
				<tr>
					<td>
						<table style="border: 1px solid black;border-right-style: none;border-left-style: none;" >
							<tr>
								<td style="text-align: center;background-color: #B1BAC2 ;width:50px;">NO</td>
								<td style="width:500px; text-align: center;">ASPEK</td>
								<td style="text-align: center;background-color: #B1BAC2 ;width:50px;">KS</td>
								<td style="text-align: center;background-color: #B1BAC2 ;width:50px;">K</td>
								<td style="text-align: center;background-color: #B1BAC2 ;width:50px;">C</td>
								<td style="text-align: center;background-color: #B1BAC2 ;width:50px;">C+</td>
								<td style="text-align: center;background-color: #B1BAC2 ;width:50px;">B</td>
								<td style="text-align: center;background-color: #B1BAC2 ;width:50px;">BS</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
					<?
					$arrpsikologinilai= [];
					$set= new KelasJabatan();
					$set->selectByParamsProfilPsikologi(array(), -1,-1, $reqJadwalTesId, $reqPegawaiId);
					while($set->nextRow())
					{
						$asesorsaranid= $set->getField("ASESOR_ID");
					    $arrdata= [];
					    $arrdata["PROFIL_PSIKOLOGI_NILAI_ASESOR_ID"]= $set->getField("PROFIL_PSIKOLOGI_NILAI_ASESOR_ID");
					    $arrdata["PROFIL_PSIKOLOGI_ID"]= $set->getField("PROFIL_PSIKOLOGI_ID");
					    $arrdata["PROFIL_PSIKOLOGI_ID_PARENT"]= $set->getField("PROFIL_PSIKOLOGI_ID_PARENT");
					    $arrdata["PERMEN_ID"]= $set->getField("PERMEN_ID");
					    $arrdata["JADWAL_ACARA_ID"]= $set->getField("JADWAL_ACARA_ID");
					    $arrdata["JADWAL_ASESOR_ID"]= $set->getField("JADWAL_ASESOR_ID");
					    $arrdata["PERMEN_ID"]= $set->getField("PERMEN_ID");
					    $arrdata["NAMA"]= $set->getField("NAMA");
					    $arrdata["NILAI"]= $set->getField("NILAI");
					    $arrdata["NILAI_PESERTA"]= $set->getField("NILAI_PESERTA");
					    $arrdata["STATUS_KRITIS"]= $set->getField("STATUS_KRITIS");
					    array_push($arrpsikologinilai, $arrdata);
					    $jumlahpsikologi++;
					}
					?>

					<table style="border: 1px solid black;border-right-style: none;border-left-style: none;border-top-style: none;" >
					<?
					for($index=0; $index < count($arrpsikologinilai); $index++)
					{
						$inforowparentid= $arrpsikologinilai[$index]["PROFIL_PSIKOLOGI_ID_PARENT"];
						$infonama= $arrpsikologinilai[$index]["NAMA"];
						$infoprofilkompetensistandarnilai= 3;
						$infoprofilkompetensinilai= $arrpsikologinilai[$index]["NILAI"];
						$arrWarnaChecked= radioPenilaian($infoprofilkompetensistandarnilai, "#B1BAC2");
						$arrChecked= radioPenilaian($infoprofilkompetensinilai, "√");

						if($inforowparentid == "0")
						{
							$nomordetil= 1;
			        ?>
	        			<tr>
	        				<th colspan="8" class="text-center"><?=$infonama?></th>
	        			</tr>
					<?
						}
						else
						{
					?>
						<tr>
							<td class="text-center" style="text-align: center;width:50px;"><?=$nomordetil?></td>
							<td style="text-align: left; width:505px;"><?=$infonama?></td>
							<td class="text-center" style="text-align: center;width:50px; background-color: <?=$arrWarnaChecked[0]?>;"><?=$arrChecked[0]?></td>
							<td class="text-center" style="text-align: center;width:50px; background-color: <?=$arrWarnaChecked[1]?>;"><?=$arrChecked[1]?></td>
							<td class="text-center" style="text-align: center;width:50px; background-color: <?=$arrWarnaChecked[2]?>;"><?=$arrChecked[2]?></td>
							<td class="text-center" style="text-align: center;width:50px; background-color: <?=$arrWarnaChecked[3]?>;"><?=$arrChecked[3]?></td>
							<td class="text-center" style="text-align: center;width:50px; background-color: <?=$arrWarnaChecked[4]?>;"><?=$arrChecked[4]?></td>
							<td class="text-center" style="text-align: center;width:50px; background-color: <?=$arrWarnaChecked[5]?>;"><?=$arrChecked[5]?></td>
						</tr>
					<?
						$nomordetil++;
						}
					}
					?>
					</table>
					</td>
				</tr>
			</table>
		</div>

		<!-- end halaman 4 -->
		<pagebreak />

		<!-- start halaman 8 -->
		<div >
			<p style="font-family: calibri; font-size: 14pt;"><strong>II.	KESIMPULAN</strong></p>
		</div>
		<div class="center" style="margin-left: 30px; ">
			

			<table  style="border: 1px solid black;border-right-style: none;border-left-style: none; border-collapse: collapse; width: 100%">
				<tr style="border: 1px solid black;">
					<td style="text-align:center;border: 1px solid black;width: 100px">
						Hal yang mendukung kinerja
					</td>
					<td style="text-align:center;border: 1px solid black;">
						Hal yang menghambat kinerja
					</td>
				</tr>

				<tr style="border: 1px solid black;border: 1px solid black;">
				<?
				$infoasesorlaporan= infoasesorpsikologilaporan();
				foreach($infoasesorlaporan as $valkey => $valitem)
				{
					$infoasesorlaporanjenis= $valitem["jenis"];
					$infoasesorlaporantext= $valitem["text"];
					$infoasesordata= $valitem["data"];
					$infoasesorpenggalianid= $valitem["penggalianid"];

					$infopenggalianid= $infoasesorpenggalianid;
					$infojenis= $infoasesorlaporanjenis;

					if($infoasesorlaporanjenis == "kesimpulan")
					{
						for($index=0; $index < count($infoasesordata); $index++)
						{
							$infopenggalianid= $infoasesordata[$index]["penggalianid"];
							$infojenis= $infoasesordata[$index]["jenis"];

							$setdetil= new KelasJabatan();
							$statement= " AND A.JADWAL_TES_ID = ".$reqJadwalTesId." AND A.PEGAWAI_ID = ".$reqPegawaiId." AND A.PENGGALIAN_ID = ".$infopenggalianid." AND A.PROFIL_PSIKOLOGI_ID = '".$infojenis."'";
							$setdetil->selectByParamsLaporanPsikologiAsesor(array(), -1, -1, $statement);
							$setdetil->firstRow();
							// if($index == 1)
							// {	
							// 	echo $setdetil->query;exit;
							// }
							$infodetilketerangan= $setdetil->getField("KETERANGAN");
				?>
							<td style="text-align:justify; vertical-align: top; padding-left: 10px; padding-right: 10px; width: 50%">
								<?=$infodetilketerangan?>
							</td>
				<?
						}
					}
				}
				?>	
				</tr>
			</table>

			<br/>
			<?
			$setdetil= new KelasJabatan();
			$statement= " AND A.JADWAL_TES_ID = ".$reqJadwalTesId." AND A.PEGAWAI_ID = ".$reqPegawaiId." AND A.PENGGALIAN_ID = 4 AND A.PROFIL_PSIKOLOGI_ID = 'saran_pengembangan'";
			$setdetil->selectByParamsLaporanPsikologiAsesor(array(), -1, -1, $statement);
			$setdetil->firstRow();
			// echo $setdetil->query;exit;
			$infodetilketerangan= $setdetil->getField("KETERANGAN");
			?>
			<table  style="border: 1px solid black;border-collapse: collapse;; width: 100%">
				<tr style="border: 1px solid black;">
					<td style="text-align:center;border: 1px solid black;width: 100px">
						Saran Pengembangan
					</td>
					<td style="text-align:justify; vertical-align: top; padding-left: 10px; padding-right: 10px; border: 1px solid black;">
						<?=$infodetilketerangan?>
					</td>
				</tr>
			</table>

			<br>
			<br>
			<br>
			<table width="100%">
				<tr>
					<td style="text-align:center;" width="50%">
						Surabaya, 22 April 2020
					</td>
				</tr>
				<tr>
					<td style="text-align:center;" width="50%">
						Psikolog Penanggungjawab,
					</td>
					<td style="text-align:center" width="50%">
						Psikolog Laporan,
					</td>
				</tr>
				<tr>
					<td>
						<br>
						<br>
						<br>
						<br>
					</td>
				</tr>
				<tr>
					<td style="text-align:center">
						<u><?=$infokepalanama?></u>
					</td>
					<td style="text-align:center">
						<u><?=$infoasesorpenilaiannama?></u>
					</td>
				</tr>
				<tr>
					<td style="text-align:center">
						SIPP. <?=$infokepalanosk?>
					</td>
					<td style="text-align:center">
						SIPP. <?=$infoasesorpenilaiannosk?>
					</td>
				</tr>
			</table>

		</div>
		
	</div>
</body>
</html>