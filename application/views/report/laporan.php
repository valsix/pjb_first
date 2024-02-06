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
$reqJadwalPegawaiTanggalTtd= getFormattedDate($set->getField("TTD_TANGGAL"));
$reqJadwalPegawaiKompetensiId= $set->getField("PROFIL_KOMPETENSI_ID_PARENT");
$reqJadwalPegawaiPerusahaan= $set->getField("PERUSAHAAN_NAMA");
$reqJadwalPegawaiKompetensiNama= $set->getField("PROFIL_KOMPETENSI_NAMA");
$reqJadwalPegawaiSpiNama= $set->getField("SPI_NAMA");
if(!empty($reqJadwalPegawaiSpiNama))
{
	$reqJadwalPegawaiKompetensiNama.= " - ".$reqJadwalPegawaiSpiNama;
}
// echo $reqJadwalPegawaiSpiNama;exit;

$statement= " AND A.JADWAL_TES_ID = ".$reqJadwalTesId." AND A.JENIS = 4";
$set= new KelasJabatan();
$set->selectByParamsPetugas(array(), -1,-1, $statement);
$set->firstRow();
$infokepalanama= $set->getField("ASESOR_NAMA");
$infokepalanosk= $set->getField("ASESOR_NO_SK");

$baseimage= $this->config;
$baseimage= $baseimage->config["baseimage"];
// $basesvg= base_url()."assets/svg/";
$basesvg= "assets/svg/";
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

		<!-- start halaman 2 -->
		<div style="text-align: center">
			<p style="font-family: calibri; font-size: 14pt;"><strong>PENGANTAR<br>
			</strong></p>			
		</div>

		<div style="margin-bottom: 30px; text-align: justify;">
			Laporan ini merupakan laporan individual yang bertujuan untuk memberikan gambaran profil kompetensi relatif terhadap profil kompetensi yang dipersyaratkan bagi calon pejabat setingkat dibawah direksi dalam rangka Asesmen Kompetensi. Individu ini didapatkan dari hasil penilaian melalui metode assessment center. Metode ini memberikan kesempatan pada masing-masing individu untuk menangani permasalahan manajerial yang biasa dihadapi oleh seorang calon pejabat setingkat dibawah direksi. Dengan demikian, respon individu terhadap persoalan-persoalan di dalam assessment center dapat menjadi salah satu sumber informasi untuk menilai tingkat kesiapan individu untuk menjalankan peran sebagai calon pejabat setingkat dibawah direksi.			
		</div>
		<div class="justify" style="margin-bottom: 30px; text-align: justify">
			Laporan ini terdiri dari beberapa bagian. Pada bagian awal, terdapat executive summary  yang merupakan kesimpulan umum mengenai unjuk kerja yang bersangkutan dalam program assesment center, serta rekomendasi tim konsultan terkait dengan tujuan asesmen kompetensi ini. Laporan ini juga menyertakan informasi lebih spesifik mengenai unjuk kerja individu pada setiap kompetensi secara deskriptif. Informasi ini dapat dimanfaatkan untuk melihat kekuatan maupun catatan pengembangan yang perlu dipertimbangkan untuk mengambil keputusan asesmen kompetensi.			
		</div>
		<div class="justify" style="margin-bottom: 30px; text-align: justify">
			Hasil asesmen ini hanya merupakan salah satu sumber informasi mengenai kompetensi dan potensi individu dan tidak mempresentasikan kinerja yang sebesar-besarnya bagi pengembangan diri individu yang bersangkutan.			
		</div>
		<br>
		<br>
		<table>
			<tr>
				<td style="text-align:center">
					Hormat Kami,
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
			</tr>
			<tr>
				<td style="text-align:center">
					SIPP. <?=$infokepalanosk?>
				</td>
			</tr>
		</table>

		<!-- end halaman 2 -->
		<pagebreak />

		<!-- start halaman 3 -->
		<?
		$infojenis= "kesimpulan_umum";
		$infoasesorlaporan= infoasesorlaporanget($infojenis, "data");
		$statement= " AND A.JADWAL_TES_ID = ".$reqJadwalTesId." AND A.PEGAWAI_ID = ".$reqPegawaiId." AND A.JENIS = '".$infojenis."'";
		$set= new KelasJabatan();
		$set->selectByParamsLaporanAsesor(array(), -1,-1, $statement);
		$set->firstRow();
		$infoketerangan= $set->getField("KETERANGAN");
		?>
		<div>
			<p style="font-family: calibri; font-size: 14pt;"><strong>I.	HASIL ASESMEN<br>
			</strong></p>			
		</div>

		<div class="center" style="margin-left: 30px; ">
			<table >
				<tr style="border: solid black 1px">
					<td>
						<p style="font-family: calibri; font-size: 14pt;"><strong>1.	<?=$infoasesorlaporan[0]?><br>
						</strong></p>	
					</td>
				</tr>
				<tr>
					<td><br></td>
				</tr>
				<tr>
					<td>
						<table style="border: 3px solid black;  width: 100%; border-collapse: collapse;">
							<tr>
								<td style="padding-left: 10px; border: 3px solid black;border-right-style: none;border-left-style: none;">
									<p style="font-family: calibri; font-size: 14pt;"><strong><?=$infoasesorlaporan[1]?>	</strong></p>	
								</td>
							</tr>
							<tr>
								<td style="padding-left: 10px; padding-right: 10px;text-align: justify">
									<?=$infoketerangan?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>

		<!-- end halaman 3 -->
		<pagebreak />

		<!-- start halaman 4 -->
		<div>
			<p style="font-family: calibri; font-size: 14pt;"><strong>2.	PROFIL KOMPETENSI<br>
			</strong></p>			
		</div>
		<div class="center" style="margin-left: 30px; ">
			<table >
				<tr>
					<td>
						<table style="border: 1px solid black;border-right-style: none;border-left-style: none;" >
							<tr>
								<td style="width:500px; text-align: center;" rowspan="2">Kompetensi</td>
								<td style="text-align: center;width:250px;">Level</td>
							</tr>
							<tr>
								<td>
									<table style="border: 1px solid black; border-bottom-style: none;border-right-style: none;border-left-style: none; ">
										<tr>
											<td style="text-align: center;background-color: #B1BAC2 ;width:50px;">1</td>
											<td style="text-align: center;background-color: #B1BAC2 ;width:50px;">2</td>
											<td style="text-align: center;background-color: #B1BAC2 ;width:50px;">3</td>
											<td style="text-align: center;background-color: #B1BAC2 ;width:50px;">4</td>
											<td style="text-align: center;background-color: #B1BAC2 ;width:50px;">5</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table style="border: 1px solid black;border-right-style: none;border-left-style: none;border-top-style: none;" >
							<tr>
								<td style="width:750px; text-align: center;">KOMPETENSI INTI</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
					<?
					$arrakhirnilai= [];
					$set= new KelasJabatan();
					$set->selectByParamsLaporanKompetensi(array(), -1,-1, $reqJadwalTesId, $reqPegawaiId);
					// echo $set->query;exit();
					while($set->nextRow())
					{
					    $arrdata= [];
					    $arrdata["NAMA"]= $set->getField("NAMA");
					    $arrdata["NILAI_STANDAR"]= $set->getField("NILAI_STANDAR");
					    $arrdata["NILAI"]= $set->getField("NILAI");
					    $arrdata["KELAS_JABATAN_ID"]= $set->getField("KELAS_JABATAN_ID");
					    $arrdata["KELAS_JABATAN_ID_ATAS"]= $set->getField("KELAS_JABATAN_ID_ATAS");
					    $arrdata["ASESOR_ID"]= $set->getField("ASESOR_ID");
					    $arrdata["PROFIL_KOMPETENSI_ID"]= $set->getField("PROFIL_KOMPETENSI_ID");
					    $arrdata["KETERANGAN_DESKRIPSI"]= $set->getField("KETERANGAN_DESKRIPSI");
					    $arrdata["KETERANGAN"]= $set->getField("KETERANGAN");
					    array_push($arrakhirnilai, $arrdata);
					}

					for($index=0; $index < count($arrakhirnilai); $index++)
					{
						$nomor= $index + 1;
						$infoprofilkompetensinama= $nomor.". ".$arrakhirnilai[$index]["NAMA"];
						$infoprofilkompetensistandarnilai= $arrakhirnilai[$index]["NILAI_STANDAR"];
						$infoprofilkompetensinilai= $arrakhirnilai[$index]["NILAI"];

						if($infoprofilkompetensistandarnilai == 0)
							$arrWarnaChecked= "";
						else
							$arrWarnaChecked= radioPenilaian($infoprofilkompetensistandarnilai, "#B1BAC2");

						$arrChecked= radioPenilaian($infoprofilkompetensinilai, "√");

						$infoprofilkompetensikelasjabatanid= $arrakhirnilai[$index]["KELAS_JABATAN_ID"];
						$infoprofilkompetensikelasjabatanidatas= $arrakhirnilai[$index]["KELAS_JABATAN_ID_ATAS"];
						$infoprofilkompetensiasesorid= $arrakhirnilai[$index]["ASESOR_ID"];
						$infoprofilkompetensiid= substr($arrakhirnilai[$index]["PROFIL_KOMPETENSI_ID"], 0, 2);
					?>
						<table style="border: 1px solid black;border-right-style: none;border-left-style: none;border-top-style: none;" >
							<tr>
								<td style="text-align: left; width:505px;" rowspan="2"><?=$infoprofilkompetensinama?></td>
								<td class="text-center" style="text-align: center;width:50px; background-color: <?=$arrWarnaChecked[0]?>;"><?=$arrChecked[0]?></td>
								<td class="text-center" style="text-align: center;width:50px; background-color: <?=$arrWarnaChecked[1]?>;"><?=$arrChecked[1]?></td>
								<td class="text-center" style="text-align: center;width:50px; background-color: <?=$arrWarnaChecked[2]?>;"><?=$arrChecked[2]?></td>
								<td class="text-center" style="text-align: center;width:50px; background-color: <?=$arrWarnaChecked[3]?>;"><?=$arrChecked[3]?></td>
								<td class="text-center" style="text-align: center;width:50px; background-color: <?=$arrWarnaChecked[4]?>;"><?=$arrChecked[4]?></td>
							</tr>
						</table>
					<?
					}

					if(empty($infoprofilkompetensiasesorid))
						$infoprofilkompetensiasesorid= $reqAsesorId;
					
					$statement= " AND B.ASESOR_ID = ".$infoprofilkompetensiasesorid;
					$set= new KelasJabatan();
					$set->selectByParamsAsesor(array(), -1,-1, $statement);
					$set->firstRow();
					// echo $set->query;exit;
					$infoasesorpenilaiannama= $set->getField("ASESOR_NAMA");
					$infoasesorpenilaiannosk= $set->getField("ASESOR_NO_SK");

					$infokelasjabatanid= $infoprofilkompetensikelasjabatanid;
					$reqParentId= $infoprofilkompetensiid;
					$infopermenid= $reqJadwalPegawaiPermenId;

					$setnilai= new KelasJabatan();
					$setnilai->selectrekomendasinilai($reqParentId, $infopermenid, $infokelasjabatanid, $infokelasjabatanid, $reqJadwalPegawaiKompetensiId, $reqPegawaiId, $reqJadwalTesId);
					$setnilai->firstRow();
					// echo $setnilai->query;exit;
					$saatiniinfostaff= $setnilai->getField("INFO_STAFF");
					$saatiniinfostuktural= $setnilai->getField("INFO_STRUKTURAL");
					$saatiniinfofungsional= $setnilai->getField("INFO_FUNGSIONAL");
					$saatiniinfostaffjenis= $setnilai->getField("JENIS_STAFF");
					$saatiniinfostukturaljenis= $setnilai->getField("JENIS_STRUKTURAL");
					$saatiniinfofungsionaljenis= $setnilai->getField("JENIS_FUNGSIONAL");
					?>
					</td>
				</tr>
				<tr>
					<td>
						<table style="border: 1px solid black;border-right-style: none;border-left-style: none;background-color: #B1BAC2 ;" >
							<tr>
								<td style="width:750px; text-align: center;"><b><?=$reqJadwalPegawaiNamaJabatan?> - <?=$reqJadwalPegawaiKompetensiNama?></b></td>
							</tr>
							<tr>
								<td style="width:750px; text-align: center;"><b>KJ <?=$reqJadwalPegawaiKelasJabatanKelompok?></b></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table>
							<tr>
								<td style="width:250px; text-align: center;">STAF (<?=$saatiniinfostaff?>%)</td>
								<td style="width:250px; text-align: center;">STRUKTURAL (<?=$saatiniinfostuktural?>%)</td>
								<td style="width:250px; text-align: center;">FUNGSIONAL (<?=$saatiniinfofungsional?>%)</td>
							</tr>
							<tr style="background-color: #B1BAC2 ;">
								<td style="width:250px; text-align: center;"><?=kesimpulanasesor($saatiniinfostaffjenis)?></td>
								<td style="width:250px; text-align: center;"><?=kesimpulanasesor($saatiniinfostukturaljenis)?></td>
								<td style="width:250px; text-align: center;"><?=kesimpulanasesor($saatiniinfofungsionaljenis)?></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<br>
			<br>
			<br>
			<table>
				<tr>
					<td style="text-align:center">
						Psikolog,
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
						<u><?=$infoasesorpenilaiannama?></u>
					</td>
				</tr>
				<tr>
					<td style="text-align:center">
						SIPP. <?=$infoasesorpenilaiannosk?>
					</td>
				</tr>
			</table>
		</div>

		<!-- end halaman 4 -->
		<pagebreak />

		<!-- start halaman 5 -->
		<div>
			<p style="font-family: calibri; font-size: 14pt;"><strong>3.	DESKRIPSI KOMPETENSI<br>
			</strong></p>			
		</div>
		<div class="center" style="margin-left: 30px; ">
			<?
			for($index=0; $index < count($arrakhirnilai); $index++)
			{
				$nomor= $index + 1;
				$infoprofilkompetensinama= $nomor.". ".$arrakhirnilai[$index]["NAMA"];
				$infoprofilkompetensistandarnilai= $arrakhirnilai[$index]["NILAI_STANDAR"];
				if($infoprofilkompetensistandarnilai == 0)
					$infoprofilkompetensistandarnilai= "-";

				$infoprofilkompetensinilai= $arrakhirnilai[$index]["NILAI"];
				$infoprofilkompetensiketerangandeskripsi= $arrakhirnilai[$index]["KETERANGAN_DESKRIPSI"];
				$infoprofilkompetensiketerangan= $arrakhirnilai[$index]["KETERANGAN"];
			?>
				<table style="border: 1px solid black;border-collapse: collapse; margin-bottom: 3px">
					<tr>
						<td rowspan="2" style="text-align: justify;">
							<strong><?=$infoprofilkompetensinama?></strong><br/>
							<?=$infoprofilkompetensiketerangandeskripsi?>
						</td>
						<td style="background-color: #B1BAC2 ;vertical-align: text-top; text-align: right;border: 1px solid black" width="100px">
							Standart
						</td>
						<td width="40px" style="vertical-align: text-top;text-align: center;border: 1px solid black">
							<?=$infoprofilkompetensistandarnilai?>
						</td>
					</tr>
					<tr style="border: 1px solid black;">
						<td style="background-color: #B1BAC2 ;vertical-align: text-top;text-align: right;border: 1px solid black">
							Pribadi
						</td>
						<td style="vertical-align: text-top;text-align: center;border: 1px solid black">
							<?=$infoprofilkompetensinilai?>
						</td>
					</tr>
					<tr style="border: 1px solid black;">
						<td colspan="3" style="text-align: left;text-align: justify">
							<?=$infoprofilkompetensiketerangan?>
						</td>
					</tr>
				</table>
				<br>
			<?
			}
			?>
		</div>

		<!-- end halaman 5 -->
		<pagebreak />

		<!-- start halaman 6 -->
		<div>
			<p style="font-family: calibri; font-size: 14pt;"><strong>4.	PROFIL POTENSI<br>
			</strong></p>			
		</div>
		<div class="center" style="margin-left: 30px; ">
			<table >
				<tr>
					<td>
						<table style="border: 1px solid black;border-right-style: none;border-left-style: none;" >
							<tr>
								<td style="width:500px; text-align: center;" rowspan="2">Potensi</td>
								<td style="text-align: center;width:250px;">Level</td>
							</tr>
							<tr>
								<td>
									<table style="border: 1px solid black; border-bottom-style: none;border-right-style: none;border-left-style: none; ">
										<tr>
											<td style="text-align: center;background-color: #B1BAC2 ;width:50px;">1</td>
											<td style="text-align: center;background-color: #B1BAC2 ;width:50px;">2</td>
											<td style="text-align: center;background-color: #B1BAC2 ;width:50px;">3</td>
											<td style="text-align: center;background-color: #B1BAC2 ;width:50px;">4</td>
											<td style="text-align: center;background-color: #B1BAC2 ;width:50px;">5</td>
											<td style="text-align: center;background-color: #B1BAC2 ;width:50px;">6</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table style="border: 1px solid black;border-right-style: none;border-left-style: none;border-top-style: none;" >
							<tr>
								<td style="width:750px; text-align: center;">KOMPETENSI INTI</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
					<?
					$arrpotensinilai= [];
					$set= new KelasJabatan();
					$set->selectByParamsLaporanPotensi(array(), -1,-1, $reqJadwalTesId, $reqPegawaiId);
					// echo $set->query;exit();
					while($set->nextRow())
					{
					    $arrdata= [];
					    $arrdata["NAMA"]= $set->getField("NAMA");
					    $arrdata["NILAI_STANDAR"]= $set->getField("NILAI_STANDAR");
					    $arrdata["NILAI"]= $set->getField("NILAI");
					    array_push($arrpotensinilai, $arrdata);
					}

					for($index=0; $index < count($arrpotensinilai); $index++)
					{
						$nomor= $index + 1;
						$infoprofilpotensinama= $nomor.". ".$arrpotensinilai[$index]["NAMA"];
						$infoprofilpotensistandarnilai= $arrpotensinilai[$index]["NILAI_STANDAR"];
						$infoprofilpotensinilai= $arrpotensinilai[$index]["NILAI"];
						$arrWarnaChecked= radioPenilaian($infoprofilpotensistandarnilai, "#B1BAC2");
						$arrChecked= radioPenilaian($infoprofilpotensinilai, "√");
					?>
						<table style="border: 1px solid black;border-right-style: none;border-left-style: none;border-top-style: none;" >
							<tr>
								<td style="text-align: left; width:505px;" rowspan="2"><?=$infoprofilpotensinama?></td>
								<td class="text-center" style="text-align: center;width:50px; background-color: <?=$arrWarnaChecked[0]?>;"><?=$arrChecked[0]?></td>
								<td class="text-center" style="text-align: center;width:50px; background-color: <?=$arrWarnaChecked[1]?>;"><?=$arrChecked[1]?></td>
								<td class="text-center" style="text-align: center;width:50px; background-color: <?=$arrWarnaChecked[2]?>;"><?=$arrChecked[2]?></td>
								<td class="text-center" style="text-align: center;width:50px; background-color: <?=$arrWarnaChecked[3]?>;"><?=$arrChecked[3]?></td>
								<td class="text-center" style="text-align: center;width:50px; background-color: <?=$arrWarnaChecked[4]?>;"><?=$arrChecked[4]?></td>
								<td class="text-center" style="text-align: center;width:50px; background-color: <?=$arrWarnaChecked[5]?>;"><?=$arrChecked[5]?></td>
							</tr>
						</table>
					<?
					}
					?>
					</td>
				</tr>
			</table>
		</div>

		<div style="margin-bottom: 30px">
			<p style="font-family: calibri; font-size: 14pt;"><strong>5.	PROFIL KEPEMIMPINAN<br>
			</strong></p>			
		</div>

		<div style="position: absolute; left:0; right: 0; top: 0; bottom: 0; padding-left: 30px">
			<?
            $newfoto= $basesvg."disc1_".$reqJadwalTesId."_".$reqPegawaiId.".svg";
			if(file_exists($newfoto))
			{
			?>
			<img src="<?=$newfoto?>" style="width: 60mm; height: 97mm; margin: 0;" />
			<?
			}

			$newfoto= $basesvg."disc2_".$reqJadwalTesId."_".$reqPegawaiId.".svg";
			if(file_exists($newfoto))
			{
			?>
			<img src="<?=$newfoto?>" style="width: 60mm; height: 97mm; margin: 0;" />
			<?
			}

            $newfoto= $basesvg."disc3_".$reqJadwalTesId."_".$reqPegawaiId.".svg";
			if(file_exists($newfoto))
			{
			?>
			<img src="<?=$newfoto?>" style="width: 60mm; height: 97mm; margin: 0;" />
			<?
			}
			?>
		</div>

		<!-- end halaman 6 -->
		<pagebreak />

		<!-- start halaman 7 -->
		<?
		$infojenis= "deskripsi_potensi";
		$infoasesorlaporan= infoasesorlaporanget($infojenis, "text");
		$statement= " AND A.JADWAL_TES_ID = ".$reqJadwalTesId." AND A.PEGAWAI_ID = ".$reqPegawaiId." AND A.JENIS = '".$infojenis."'";
		$set= new KelasJabatan();
		$set->selectByParamsLaporanAsesor(array(), -1,-1, $statement);
		// echo $set->query;exit;
		$set->firstRow();
		$infoketerangan= $set->getField("KETERANGAN");
		?>
		<div>
			<p style="font-family: calibri; font-size: 14pt;"><strong>6.	<?=$infoasesorlaporan?><br>
			</strong></p>			
		</div>

		<div class="justify" style="margin-left: 30px;margin-bottom: 30px;text-align: justify">
			<?=$infoketerangan?>
		</div>

		<!-- end halaman 7 -->
		<pagebreak />

		<!-- start halaman 8 -->
		<div >
			<p style="font-family: calibri; font-size: 14pt;"><strong>7.	SARAN PENGEMBANGAN<br>
			</strong></p>
			Kompetensi yang perlu dikembangkan lebih lanjut oleh <?=$reqJadwalPegawaiNama?> adalah :			
		</div>
		<div class="center" style="margin-left: 30px; ">
			

			<table  style="border: 1px solid black;border-right-style: none;border-left-style: none; border-collapse: collapse; width: 100%">
				<tr style="border: 1px solid black;">
					<td style="text-align:center;border: 1px solid black;width: 100px">
						KOMPETENSI
					</td>
					<td style="text-align:center;border: 1px solid black;">
						PENGEMBANGAN
					</td>
				</tr>

				<?
				$arrsaranpengembangan= [];
				$set= new KelasJabatan();
				$set->selectByParamsLaporanSaran(array(), -1,-1, $reqJadwalTesId, $reqPegawaiId);
				// echo $set->query;exit();
				while($set->nextRow())
				{
				    $arrdata= [];
				    $arrdata["NAMA"]= $set->getField("NAMA");
				    $arrdata["KETERANGAN"]= $set->getField("KETERANGAN");
				    array_push($arrsaranpengembangan, $arrdata);
				}

				for($index=0; $index < count($arrsaranpengembangan); $index++)
				{
					$nomor= $index + 1;
					$infosaranpengembangannama= $arrsaranpengembangan[$index]["NAMA"];
					$infosaranpengembanganketerangan= $arrsaranpengembangan[$index]["KETERANGAN"];
				?>
				<tr style="border: 1px solid black;border: 1px solid black;">
					<td style="vertical-align: text-top;border: 1px solid black;">
						<b><?=$infosaranpengembangannama?></b> 
					</td>
					<td style="text-align:justify; padding-left: 10px;">
						<?=$infosaranpengembanganketerangan?>
					</td>
				</tr>
				<?
				}
				?>
			</table>

			<br/>

			<table  style="border: 1px solid black;border-collapse: collapse;; width: 100%">
				<tr style="border: 1px solid black;">
					<td style="text-align:center;border: 1px solid black;width: 100px">
						POTENSI
					</td>
					<td style="text-align:center;border: 1px solid black;">
						PENGEMBANGAN
					</td>
				</tr>

				<?
				$arrsaranpengembangan= [];
				$set= new KelasJabatan();
				$set->selectByParamsLaporanSaranPotensi(array(), -1,-1, $reqJadwalTesId, $reqPegawaiId);
				// echo $set->query;exit();
				while($set->nextRow())
				{
				    $arrdata= [];
				    $arrdata["NAMA"]= $set->getField("NAMA");
				    $arrdata["KETERANGAN"]= $set->getField("KETERANGAN");
				    array_push($arrsaranpengembangan, $arrdata);
				}

				for($index=0; $index < count($arrsaranpengembangan); $index++)
				{
					$nomor= $index + 1;
					$infosaranpengembangannama= $arrsaranpengembangan[$index]["NAMA"];
					$infosaranpengembanganketerangan= $arrsaranpengembangan[$index]["KETERANGAN"];
				?>
				<tr style="border: 1px solid black;border: 1px solid black;">
					<td style="vertical-align: text-top;border: 1px solid black;">
						<b><?=$infosaranpengembangannama?></b> 
					</td>
					<td style="text-align:justify; padding-left: 10px;">
						<?=$infosaranpengembanganketerangan?>
					</td>
				</tr>
				<?
				}
				?>
			</table>

			<br>
			<br>
			<br>
			<table width="100%">
				<tr>
					<td style="text-align:center;" width="50%">
						Surabaya, <?=$reqJadwalPegawaiTanggalTtd?>
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

		<!-- end halaman 8 -->
		<pagebreak />
		
		<!-- start halaman 9 -->
		<div class="center">
			<p style="font-family: calibri; font-size: 14pt;text-align:center;"><strong>LAMPIRAN<br>INFORMASI AWAL TALENT MANAGEMENT
			</strong></p>		
		</div>

		<table>
			<tr>
				<td>Nama		:</td>
				<td><?=$reqJadwalPegawaiNama?></td>
			</tr>
			<tr>
				<td>Posisi saat ini	:</td>
				<td><?=$reqJadwalPegawaiNamaJabatan?></td>
			</tr>
			<tr>
				<td>Kelas Jabatan	:</td>
				<td><?=$reqJadwalPegawaiKelasJabatanKelompok?></td>
			</tr>
		</table>
		<br>
		<br>
		<?
		$arrprofilkompetensi= [];
		$set= new KelasJabatan();
		$set->selectByParamsPenggalianProfilKompetensi(array(), -1,-1, $reqJadwalTesId, $reqPegawaiId);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$infoprofilkompetensiid= $set->getField("PROFIL_KOMPETENSI_ID_PARENT");

			$detilinfo= $set->getField("DETIL_INFO");

			if(!empty($reqJadwalPegawaiSpiNama) && $infoprofilkompetensiid == "07" )
				continue;

			if($detilinfo == "SPI")
			{
				$detilinfo.= " - ".$reqJadwalPegawaiKompetensiNama;
			}

			if(!empty($reqJadwalPegawaiSpiNama))
			{
				$detilinfo= "SPI - ".$detilinfo;
			}

		    $arrdata= [];
		    $arrdata["DETIL_INFO"]= $detilinfo;
		    $arrdata["PROFIL_KOMPETENSI_ID_PARENT"]= $infoprofilkompetensiid;

		    $infokelasjabatanid= $infoprofilkompetensikelasjabatanid;
		    $infokelasjabatanidatas= $infoprofilkompetensikelasjabatanidatas;
			$reqParentId= $infoprofilkompetensiid;
			$infopermenid= $reqJadwalPegawaiPermenId;

			$setnilai= new KelasJabatan();
			$setnilai->selectrekomendasinilai($reqParentId, $infopermenid, $infokelasjabatanid, $infokelasjabatanid, $reqJadwalPegawaiKompetensiId, $reqPegawaiId, $reqJadwalTesId);
			$setnilai->firstRow();
			// if($infoprofilkompetensiid == "05")
			// {
				// echo $setnilai->query;exit;
			// }
			$saatiniinfostaff= $setnilai->getField("INFO_STAFF");
			$saatiniinfostuktural= $setnilai->getField("INFO_STRUKTURAL");
			$saatiniinfofungsional= $setnilai->getField("INFO_FUNGSIONAL");
			$saatiniinfostaffjenis= $setnilai->getField("JENIS_STAFF");
			$saatiniinfostukturaljenis= $setnilai->getField("JENIS_STRUKTURAL");
			$saatiniinfofungsionaljenis= $setnilai->getField("JENIS_FUNGSIONAL");

			$arrdata["SAAT_INI_INFO_STAFF"]= $saatiniinfostaff;
			$arrdata["SAAT_INI_INFO_STRUKTURAL"]= $saatiniinfostuktural;
			$arrdata["SAAT_INI_INFO_FUNGSIONAL"]= $saatiniinfofungsional;
			$arrdata["SAAT_INI_JENIS_STAFF"]= $saatiniinfostaffjenis;
			$arrdata["SAAT_INI_JENIS_STRUKTURAL"]= $saatiniinfostukturaljenis;
			$arrdata["SAAT_INI_JENIS_FUNGSIONAL"]= $saatiniinfofungsionaljenis;

			$setnilai->selectrekomendasinilai($reqParentId, $infopermenid, $infokelasjabatanid, $infokelasjabatanidatas, $reqJadwalPegawaiKompetensiId, $reqPegawaiId, $reqJadwalTesId);
			$setnilai->firstRow();
			if($infoprofilkompetensiid == "07")
			{
				// echo $setnilai->query;exit;
			}
			$atasinfostaff= $setnilai->getField("INFO_STAFF");
			$atasinfostuktural= $setnilai->getField("INFO_STRUKTURAL");
			$atasinfofungsional= $setnilai->getField("INFO_FUNGSIONAL");
			$atasinfostaffjenis= $setnilai->getField("JENIS_STAFF");
			$atasinfostukturaljenis= $setnilai->getField("JENIS_STRUKTURAL");
			$atasinfofungsionaljenis= $setnilai->getField("JENIS_FUNGSIONAL");

			$arrdata["ATAS_INFO_STAFF"]= $atasinfostaff;
			$arrdata["ATAS_INFO_STRUKTURAL"]= $atasinfostuktural;
			$arrdata["ATAS_INFO_FUNGSIONAL"]= $atasinfofungsional;
			$arrdata["ATAS_JENIS_STAFF"]= $atasinfostaffjenis;
			$arrdata["ATAS_JENIS_STRUKTURAL"]= $atasinfostukturaljenis;
			$arrdata["ATAS_JENIS_FUNGSIONAL"]= $atasinfofungsionaljenis;

		    array_push($arrprofilkompetensi, $arrdata);
		}
		// print_r($arrprofilkompetensi);exit;
		?>

		<?
		for($index=0; $index < count($arrprofilkompetensi); $index++)
		{
			$infoprofilnama= $arrprofilkompetensi[$index]["DETIL_INFO"];

			$saatiniinfostaff= $arrprofilkompetensi[$index]["SAAT_INI_INFO_STAFF"];
			$saatiniinfostuktural= $arrprofilkompetensi[$index]["SAAT_INI_INFO_STRUKTURAL"];
			$saatiniinfofungsional= $arrprofilkompetensi[$index]["SAAT_INI_INFO_FUNGSIONAL"];
			$saatiniinfostaffjenis= $arrprofilkompetensi[$index]["SAAT_INI_JENIS_STAFF"];
			$saatiniinfostukturaljenis= $arrprofilkompetensi[$index]["SAAT_INI_JENIS_STRUKTURAL"];
			$saatiniinfofungsionaljenis= $arrprofilkompetensi[$index]["SAAT_INI_JENIS_FUNGSIONAL"];

			$atasinfostaff= $arrprofilkompetensi[$index]["ATAS_INFO_STAFF"];
			$atasinfostuktural= $arrprofilkompetensi[$index]["ATAS_INFO_STRUKTURAL"];
			$atasinfofungsional= $arrprofilkompetensi[$index]["ATAS_INFO_FUNGSIONAL"];
			$atasinfostaffjenis= $arrprofilkompetensi[$index]["ATAS_JENIS_STAFF"];
			$atasinfostukturaljenis= $arrprofilkompetensi[$index]["ATAS_JENIS_STRUKTURAL"];
			$atasinfofungsionaljenis= $arrprofilkompetensi[$index]["ATAS_JENIS_FUNGSIONAL"];
		?>
			<table style="width:100%; text-align: center;">
				<tr  style="border: 1px solid black;border-right-style: none;border-left-style: none; background-color: #81ADD1;">
					<td colspan=4>REKOMENDASI BIDANG <?=$infoprofilnama?>
					</td>
				</tr>
				<tr  style="border: 1px solid black;border-right-style: none;border-left-style: none;">
					<td style="width:25%;">KELAS JABATAN
					</td>
					<td style="width:25%">STAF
					</td>
					<td style="width:25%">STRUKTURAL
					</td>
					<td style="width:25%">FUNGSIONAL
					</td>
				</tr>
				<tr style="border: 1px solid black;border-right-style: none;border-left-style: none;background-color: #81ADD1;">
					<td>1 kelompok jabatan diatasnya</td>
					<td><?=kesimpulanasesor($atasinfostaffjenis)?></td>
					<td><?=kesimpulanasesor($atasinfostukturaljenis)?></td>
					<td><?=kesimpulanasesor($atasinfofungsionaljenis)?></td>
				</tr>
				<tr style="border: 1px solid black;border-right-style: none;border-left-style: none;">
					<td>Saat ini</td>
					<td><?=kesimpulanasesor($saatiniinfostaffjenis)?></td>
					<td><?=kesimpulanasesor($saatiniinfostukturaljenis)?></td>
					<td><?=kesimpulanasesor($saatiniinfofungsionaljenis)?></td>
				</tr>
			</table>
			<br>
		<?
		}
		?>

	</div>
</body>
</html>