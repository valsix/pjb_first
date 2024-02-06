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
$reqJadwalPegawaiPermenId= $set->getField("PERMEN_ID");
$reqJadwalPegawaiNama= $set->getField("PEGAWAI_NAMA");
$reqJadwalPegawaiNamaJabatan= $set->getField("NAMA_JABATAN");
$reqJadwalPegawaiVlevel= $set->getField("VLEVEL");
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
	<!-- <link rel="stylesheet" href="assets/css/cetaknew.css" type="text/css"> -->
	<link rel="stylesheet" type="text/css" href="assets/css/cetakpdf.css">
</head>
<body>
	<div class="container">
		<!-- start halaman 1 -->
		<p  style="text-align: center;font-size: 15pt"><strong>LAPORAN HASIL ASESMEN<br></strong></p> 
		<p  style="text-align: center;font-size: 15pt" ><strong>(JxxxI)</strong></p>

		<table style="width: 100%; height: 100%;border:1px solid black;" >
			<tr>					
				<td valign="top" width="35%"  style=" height: 30%;">		
					<table width="100%" style="color: white; padding-bottom: 25px;margin-top: 10px;">
						<tr>
							<td align="center">
								<?
				                $newfoto= $baseimage.$reqJadwalTesId."/photo/pic_".$reqPegawaiId.".jpeg";
								if(!file_exists($newfoto))
								{
									$newfoto= "assets/images/FotoContoh.jpg";
				            	}
				                ?>
								<img src="<?=$newfoto?>" width="125px" style="margin-bottom:5px ;">
							</td>
						</tr>
					</table>
				</td>
				<td valign="top">
					<table width="100%"  class="noBorder">
						<tr>
							<td width=2% ></td>
							<td valign="bottom">
							</td>
						</tr>
						<tr > 
							<td width=2% ></td>
							<td valign="bottom" >
								<p style="font-family: arial;font-size: 14px;">Perusahaan :</p>
								<br>
								<br>
								<br>
							</td>
						</tr>
						<tr > 
							<td width=2% ></td>
							<td valign="bottom" >
								<p style="font-family: arial;font-size: 14px;"><?=$reqJadwalPegawaiPerusahaan?></p>
								<hr>
							</td>
						</tr>
						<tr > 
							<td width=2% ></td>
							<td valign="bottom" >
								<p style="font-family: arial;font-size: 14px;">Jabatan  :</p>
								<br>
								<br>
								<br>
							</td>
						</tr>
						<tr > 
							<td width=2% ></td>
							<td valign="bottom" >
								<p style="font-family: arial;font-size: 14px;"><?=$reqJadwalPegawaiNamaJabatan?></p>
								<hr>
							</td>
						</tr>
						<tr > 
							<td width=2% ></td>
							<td valign="bottom" >
								<p style="font-family: arial;font-size: 14px;">Tanggal Pelaksanaan Asesmen : </p>
								<br>
								<br>
								<br>
							</td>
						</tr>
						<tr > 
							<td width=2% ></td>
							<td valign="bottom" >
								<p style="font-family: arial;font-size: 14px;"><?=$reqJadwalPegawaiTanggalTes?></p>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<!-- end halaman 1 -->
		<pagebreak />

		<!-- start halaman 2 -->
		<p style="font-size: 14pt" align="center" ><strong>RINGKASAN PROFIL KOMPETENSI</strong></p>
		<table style="font-size: 10pt; border-collapse: collapse;" class="bold-border table-border center " width="100%">
			<tr style="background: #02387d;" >
				<th class="white-text" style="color: white">NO</th>
				<th class="white-text" style="color: white">KOMPETENSI</th>
				<th class="white-text" style="color: white">REQUIRED LEVEL</th>
				<th class="white-text" style="color: white">Development Opputurnity</th>
				<th class="white-text" style="color: white">Proficient</th>
				<th class="white-text" style="color: white">Strenght</th>
			</tr>

			<?
			$arrakhirnilai= [];
			$set= new KelasJabatan();
			$set->selectByParamsLaporanPdsKompetensi(array(), -1,-1, $reqJadwalTesId, $reqPegawaiId);
			// echo $set->query;exit();
			while($set->nextRow())
			{
				$arrdata= [];
				$arrdata["NAMA"]= $set->getField("NAMA");
				$arrdata["NILAI_STANDAR"]= $set->getField("NILAI_STANDAR");
				$arrdata["REKOMENDASI_KETERANGAN"]= $set->getField("REKOMENDASI_KETERANGAN");
				$arrdata["KELAS_JABATAN_ID"]= $set->getField("KELAS_JABATAN_ID");
				$arrdata["PROFIL_KOMPETENSI_ID"]= $set->getField("PROFIL_KOMPETENSI_ID");
				array_push($arrakhirnilai, $arrdata);
			}

			for($index=0; $index < count($arrakhirnilai); $index++)
			{
				$nomor= $index + 1;
				$infoprofilkompetensiid= $arrakhirnilai[$index]["PROFIL_KOMPETENSI_ID"];
				$infoprofilkompetensiparentid= substr($infoprofilkompetensiid, 0, 2);
				$infoprofilkompetensikelasjabatanid= $arrakhirnilai[$index]["KELAS_JABATAN_ID"];
				$infoprofilkompetensinama= $arrakhirnilai[$index]["NAMA"];
				$infoprofilkompetensistandarnilai= $arrakhirnilai[$index]["NILAI_STANDAR"];
				$infoprofilkompetensirekomendasi= $arrakhirnilai[$index]["REKOMENDASI_KETERANGAN"];

				// &#10003;
				// √
				$arrChecked= [];
				if($infoprofilkompetensirekomendasi == "S")
				{
					$arrChecked= array("", "", "√");
				}
				elseif($infoprofilkompetensirekomendasi == "P")
				{
					$arrChecked= array("", "√", "");
				}
				else
				{
					$arrChecked= array("√", "", "");
				}	
				?>
				<tr class="bold-border">
					<td style="text-align: left"><?=$nomor?></td>
					<td style="text-align: left"><?=$infoprofilkompetensinama?></td>
					<td style="text-align: center; width:50px;"><?=$reqJadwalPegawaiVlevel?></td>
					<td><?=$arrChecked[0]?></td>
					<td><?=$arrChecked[1]?></td>
					<td><?=$arrChecked[2]?></td>
				</tr>
			<?
			}

			$set= new KelasJabatan();
			$set->selectByParamsLaporanPdsRekomKompetensi(array(), -1,-1, $reqJadwalTesId, $reqPegawaiId);
			// echo $set->query;exit();
			$set->firstRow();
			$nilairekom= $set->getField("PERSENTASE_REKOM");

			$arrChecked= [];
			if($nilairekom > 90)
		    {
		    	$arrChecked= array("", "", "", "#5AEDFF");
		    }
		    else if($nilairekom > 65 && $nilairekom <= 90)
		    {
		    	$arrChecked= array("", "", "#A1FF72", "");
		    }
		    else if($nilairekom > 41 && $nilairekom <= 65)
		    {
		    	$arrChecked= array("", "#E9F319", "", "");
		    }
		    else
		    {
		    	$arrChecked= array("#F33019", "", "", "");
		    }

			?>
			<tr class="bold-border">
				<th colspan="3" rowspan="2" >INDEKS INDIVIDU</th>
				<th colspan="3" >CURRENT LEVEL	100% <br> REQUIRED LEVEL 100%</th>
			</tr>
			<tr class="bold-border">
				<th colspan="4" ><?=$nilairekom?>%</th>
			</tr>
			<tr class="bold-border " style="background: #02387d;">
				<th colspan="6" class="white-text" style="color: white">REKOMENDASI</th>
			</tr>
			<tr class="bold-border">
				<td colspan="2" >Tidak Direkomendasikan</td>
				<td >Direkomendasikan dengan Pengembangan</td>
				<td colspan="2">Direkomendasikan</td>
				<td >Sangat Direkomendasikan</td>
			</tr>
			<tr class="bold-border">
				<td colspan="2" style="background-color: <?=$arrChecked[0]?>">< 50 %</td>
				<td style="background-color: <?=$arrChecked[1]?>">50 % - 70 %</td>
				<td colspan="2" style="background-color: <?=$arrChecked[2]?>">71 % - 90 %</td>
				<td style="background-color: <?=$arrChecked[3]?>"> 90 %</td>
			</tr>
		</table>
		<br>

		<!-- end halaman 2 -->
		<pagebreak />

		<!-- start halaman 3 -->
		<?
		$infojenis= "area_kekuatan";
		$infoasesorlaporan= infoasesorlaporanget($infojenis, "text", "pds");
		$statement= " AND A.JADWAL_TES_ID = ".$reqJadwalTesId." AND A.PEGAWAI_ID = ".$reqPegawaiId." AND A.JENIS = '".$infojenis."'";
		$set= new KelasJabatan();
		$set->selectByParamsLaporanAsesor(array(), -1,-1, $statement);
		$set->firstRow();
		$infoketerangan= $set->getField("KETERANGAN");
		?>
		<table style="font-size: 10pt; border-collapse: collapse;" class="bold-border table-border center " width="100%">
			<tr style="background: #09a7f1;" >
				<th >AREA KEKUATAN</th>
			</tr>
			<tr class="bold-border" >
				<td style="text-align: justify;">
					<?=$infoketerangan?>
				</td>
			</tr>
		</table>
		<br>

		<!-- end halaman 3 -->
		<pagebreak />

		<!-- start halaman 4 -->
		<?
		$infojenis= "area_pengembangan";
		$infoasesorlaporan= infoasesorlaporanget($infojenis, "text", "pds");
		$statement= " AND A.JADWAL_TES_ID = ".$reqJadwalTesId." AND A.PEGAWAI_ID = ".$reqPegawaiId." AND A.JENIS = '".$infojenis."'";
		$set= new KelasJabatan();
		$set->selectByParamsLaporanAsesor(array(), -1,-1, $statement);
		$set->firstRow();
		$infoketerangan= $set->getField("KETERANGAN");
		?>
		<table style="font-size: 10pt; border-collapse: collapse;" class="bold-border table-border center " width="100%">
			<tr style="background: #09a7f1;" >
				<th >AREA PENGEMBANGAN</th>
			</tr>
			<tr class="bold-border" >
				<td style="text-align: justify;">
					<?=$infoketerangan?>
				</td>
			</tr>
		</table>
		<br>

		<!-- end halaman 4 -->
		<pagebreak />

		<!-- start halaman 5 -->
		<table style="font-size: 10pt; border-collapse: collapse;" class="bold-border table-border center " width="100%">
			<tr style="background: #09a7f1;" >
				<th >SARAN PENGEMBANGAN</th>
			</tr>
			<tr class="bold-border" >
				<td style="text-align: justify; padding-left: 10px">
					Pengembangan Mandiri
					<table style="border-collapse: collapse; width: 100%;">
						<?
						$nomordetil= 1;
						$infoasesorlaporanjenis= "saran_pengembangan_mandiri";
						$setdetil= new KelasJabatan();
	            		$statement= " AND A.JADWAL_TES_ID = ".$reqJadwalTesId." AND A.PEGAWAI_ID = ".$reqPegawaiId." AND A.JENIS = '".$infoasesorlaporanjenis."' AND A.PERMEN_ID = ".$reqJadwalPegawaiPermenId;
	            		$setdetil->selectByParamsLaporanPdsAsesor(array(), -1, -1, $statement);
	            		// echo $setdetil->query;exit;
	            		while($setdetil->nextRow())
	            		{
						?>
						<tr>
							<td style="width: 45px; text-align: right; padding-right: 5px; border: none;"><?=$nomordetil?>.</td>
							<td style="border: none;"><?=$setdetil->getField("PNAMA")?></td>
						</tr>
						<tr>
							<td style="width: 45px; text-align: right; padding-right: 5px; border: none;"></td>
							<td style="border: none;text-align: justify;">
								<?=$setdetil->getField("KETERANGAN")?>
							</td>
						</tr>
						<?
						$nomordetil++;
						}
						?>
					</table>
				</td>
			</tr>
			<tr class="bold-border" >
				<td style="text-align: justify; padding-left: 10px">
					Penugasan Khusus
					<table style="border-collapse: collapse; width: 100%;">
						<?
						$nomordetil= 1;
						$infoasesorlaporanjenis= "saran_penugasan_khusus";
						$setdetil= new KelasJabatan();
	            		$statement= " AND A.JADWAL_TES_ID = ".$reqJadwalTesId." AND A.PEGAWAI_ID = ".$reqPegawaiId." AND A.JENIS = '".$infoasesorlaporanjenis."' AND A.PERMEN_ID = ".$reqJadwalPegawaiPermenId;
	            		$setdetil->selectByParamsLaporanPdsAsesor(array(), -1, -1, $statement);
	            		// echo $setdetil->query;exit;
	            		while($setdetil->nextRow())
	            		{
						?>
						<tr>
							<td style="width: 45px; text-align: right; padding-right: 5px; border: none;"><?=$nomordetil?>.</td>
							<td style="border: none;"><?=$setdetil->getField("PNAMA")?></td>
						</tr>
						<tr>
							<td style="width: 45px; text-align: right; padding-right: 5px; border: none;"></td>
							<td style="border: none;text-align: justify;">
								<?=$setdetil->getField("KETERANGAN")?>
							</td>
						</tr>
						<?
						$nomordetil++;
						}
						?>
					</table>
				</td>
			</tr>
		</table>
		<br>
		<br>
		<br>
		<table style="font-size: 10pt; width: 100%; padding-left: 15px" >
			<tr >
				<td align="left"></td>
				<td align="center"><strong>Surabaya,<?=$reqJadwalPegawaiTanggalTtd?> </strong> </td>
			</tr>
			<tr>
				<td align="center"><strong>ASESOR</strong></td>
				<td align="center"><strong>Psikolog Penanggungjawab, </strong></td>
			</tr>
			<tr>
				<? if (file_exists($reqTtdGambarAsesor))
				{
					?>
					<td align="left" style="height: 80px"><img src="<?=$reqTtdGambarAsesor?>" height="170px" /></td>
					<?
				}
				else
				{
				?>
					<td align="left" style="height: 80px"></td>
				<?
				}
				?>		
				
				<td align="right"></td>
			</tr>
			<tr>
				<td align="center"><strong><?=$infoasesorpenilaiannama?></strong></td>
				<td align="center" ><strong><?=$infokepalanama?></strong> </td>
				
			</tr>
			<tr>
				<td align="center"><strong>SIPP: <?=$infoasesorpenilaiannosk?></strong></td>

				<td align="center"><strong>SIPP:<?=$infokepalanosk?></strong></td>
			</tr>
		</table>
		<!-- end halaman 5 -->

	</div>
</body>
</html>