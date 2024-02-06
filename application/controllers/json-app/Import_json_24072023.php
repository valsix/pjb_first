<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");
include_once("functions/excel_reader2.php");

class Import_json extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		if($this->session->userdata("appuserid") == "")
		{
			redirect('login');
		}
		
		$this->appuserid= $this->session->userdata("appuserid");
		$this->appusernama= $this->session->userdata("appusernama");
		$this->personaluserlogin= $this->session->userdata("personaluserlogin");
		$this->appusergroupid= $this->session->userdata("appusergroupid");

		$this->configtitle= $this->config->config["configtitle"];
	}


	function perusahaan_eksternal() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("KODE","NAMA");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="KODE")
				{
					if (!empty($tempValueCheck))
					{
						$statement =" AND A.KODE = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsCheckPerusahaanExternal(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("PERUSAHAAN_EKSTERNAL_ID");
						// unset($check);
						if(!empty($reqCheckId))
						{
							array_push($arrbaris, $z);
						}
					}
					else
					{
						echo "xxx***Kode Perusahaan baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				$colIndexCheck++;	
			}
		}

		if(!empty($arrbaris))
		{
			$strbaris = implode (",", $arrbaris);
			echo "xxx***Kode Perusahaan baris ke ".$strbaris." sudah ada";exit;
		}

		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				$set->setField($arrField[$row],$tempValue);
				$colIndex++;
			}

			$set->setField("LAST_CREATE_DATE", "NOW()");
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			if($set->insertperusahaaneksternal())
			{
				$reqSimpan = 1;

			}
		}

		if($reqSimpan == 1 )
		{
			echo $reqId."***Data berhasil disimpan";
		}
		else
		{
			echo "xxx***Data gagal disimpan";
		}
	}


	function direktorat() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("KODE","NAMA");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="KODE")
				{
					if (!empty($tempValueCheck))
					{
						$statement =" AND A.KODE = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsCheckDirektorat(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("DIREKTORAT_ID");
						// unset($check);
						if(!empty($reqCheckId))
						{
							array_push($arrbaris, $z);
						}
					}
					else
					{
						echo "xxx***Kode Direktorat baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				$colIndexCheck++;	
			}
		}

		if(!empty($arrbaris))
		{
			$strbaris = implode (",", $arrbaris);
			echo "xxx***Kode Direktorat baris ke ".$strbaris." sudah ada";exit;
		}

		// exit;

		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				$set->setField($arrField[$row],$tempValue);
				$colIndex++;
			}

			$set->setField("LAST_CREATE_DATE", "NOW()");
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			if($set->insertdirektorat())
			{
				$reqSimpan = 1;
			}
		}

		if($reqSimpan == 1 )
		{
			echo $reqId."***Data berhasil disimpan";
		}
		else
		{
			echo "xxx***Data gagal disimpan";
		}
	}


	function wilayah() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("KODE","NAMA");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="KODE")
				{
					if (!empty($tempValueCheck))
					{
						$statement =" AND A.KODE = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsCheckWilayah(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("WILAYAH_ID");
						// unset($check);
						if(!empty($reqCheckId))
						{
							array_push($arrbaris, $z);
						}
					}
					else
					{
						echo "xxx***Kode wilayah baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				$colIndexCheck++;	
			}

		}

		if(!empty($arrbaris))
		{
			$strbaris = implode (",", $arrbaris);
			echo "xxx***Kode wilayah baris ke ".$strbaris." sudah ada";exit;
		}

		// exit;
		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				$set->setField($arrField[$row],$tempValue);
				$colIndex++;
			}

			$set->setField("LAST_CREATE_DATE", "NOW()");
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			if($set->insertwilayah())
			{
				$reqSimpan = 1;
			}
		}

		if($reqSimpan == 1 )
		{
			echo $reqId."***Data berhasil disimpan";
		}
		else
		{
			echo "xxx***Data gagal disimpan";
		}
	}


	function jenis_unit_kerja() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("KODE","NAMA");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="KODE")
				{
					if (!empty($tempValueCheck))
					{
						$statement =" AND A.KODE = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsCheckJenisUnit(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("JENIS_UNIT_KERJA_ID");
						// unset($check);
						if(!empty($reqCheckId))
						{
							array_push($arrbaris, $z);
						}
					}
					else
					{
						echo "xxx***Kode jenis unit kerja baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				$colIndexCheck++;	
			}
		}

		if(!empty($arrbaris))
		{
			$strbaris = implode (",", $arrbaris);
			echo "xxx***Kode jenis unit kerja baris ke ".$strbaris." sudah ada";exit;
		}

		// exit;
		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				$set->setField($arrField[$row],$tempValue);
				$colIndex++;
			}

			$set->setField("LAST_CREATE_DATE", "NOW()");
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			if($set->insertjenis())
			{
				$reqSimpan = 1;
			}
		}

		if($reqSimpan == 1 )
		{
			echo $reqId."***Data berhasil disimpan";
		}
		else
		{
			echo "xxx***Data gagal disimpan";
		}
	}


	function list_area() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("KODE","NAMA");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="KODE")
				{
					if (!empty($tempValueCheck))
					{
						$statement =" AND A.KODE = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsCheckArea(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("LIST_AREA_ID");
						// unset($check);
						if(!empty($reqCheckId))
						{
							array_push($arrbaris, $z);
						}
					}
					else
					{
						echo "xxx***Kode area baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				$colIndexCheck++;	
			}
		}

		if(!empty($arrbaris))
		{
			$strbaris = implode (",", $arrbaris);
			echo "xxx***Kode area baris ke ".$strbaris." sudah ada";exit;
		}

		// exit;
		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				$set->setField($arrField[$row],$tempValue);
				$colIndex++;
			}

			$set->setField("LAST_CREATE_DATE", "NOW()");
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			if($set->insertarea())
			{
				$reqSimpan = 1;
			}
		}

		if($reqSimpan == 1 )
		{
			echo $reqId."***Data berhasil disimpan";
		}
		else
		{
			echo "xxx***Data gagal disimpan";
		}
	}


	function kategori_item() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("KODE","NAMA","BOBOT");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="KODE")
				{
					if (!empty($tempValueCheck))
					{
						$statement =" AND A.KODE = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsCheckKategori(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("KATEGORI_ITEM_ASSESSMENT_ID");
						// unset($check);
						if(!empty($reqCheckId))
						{
							array_push($arrbaris, $z);
						}
					}
					else
					{
						echo "xxx***Kode area baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				elseif ($arrField[$rowCheck]=="BOBOT") {

					// print_r($tempValueCheck);exit;
					if(is_numeric($tempValueCheck))
					{}
					else
					{
						echo "xxx***Pastikan bobot baris ke ".$z." sudah diisi dan berformat numeric";
						exit();
					}
				}
				$colIndexCheck++;
			}
		}

		if(!empty($arrbaris))
		{
			$strbaris = implode (",", $arrbaris);
			echo "xxx***Kode area baris ke ".$strbaris." sudah ada";exit;
		}

		// exit;
		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				$set->setField($arrField[$row],$tempValue);
				$colIndex++;
			}

			$set->setField("LAST_CREATE_DATE", "NOW()");
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			if($set->insertkategori())
			{
				$reqSimpan = 1;
			}
		}

		if($reqSimpan == 1 )
		{
			echo $reqId."***Data berhasil disimpan";
		}
		else
		{
			echo "xxx***Data gagal disimpan";
		}
	}

	function standar_referensi() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("NAMA","NOMOR","TAHUN","BAB","DESKRIPSI");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="NAMA")
				{
					if (!empty($tempValueCheck))
					{}
					else
					{
						echo "xxx***Intitusi baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				elseif($arrField[$rowCheck]=="NOMOR")
				{
					if (!empty($tempValueCheck))
					{}
					else
					{
						echo "xxx***Nomor Referensi ke ".$z." Belum Diisi";
						exit();
					}
				}
				elseif($arrField[$rowCheck]=="TAHUN")
				{
					if(is_numeric($tempValueCheck))
					{}
					else
					{
						echo "xxx***Pastikan Tahun baris ke ".$z." sudah diisi dan berformat numeric";
						exit();
					}
				}
				elseif ($arrField[$rowCheck]=="BAB") {
					if(is_numeric($tempValueCheck))
					{}
					else
					{
						echo "xxx***Pastikan Bab baris ke ".$z." sudah diisi dan berformat numeric";
						exit();
					}
				}
				// print_r($tempValueCheck);
				$colIndexCheck++;
			}
		}

		// exit;

		// exit;
		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){
				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				$set->setField($arrField[$row],$tempValue);
				$colIndex++;
			}

			$set->setField("LAST_CREATE_DATE", "NOW()");
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			if($set->insertstandar())
			{
				$reqSimpan = 1;
			}
		}

		if($reqSimpan == 1 )
		{
			echo $reqId."***Data berhasil disimpan";
		}
		else
		{
			echo "xxx***Data gagal disimpan";
		}
	}

	function konfirmasi_item() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("KODE","NILAI","NAMA","KETERANGAN");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="KODE")
				{
					if (!empty($tempValueCheck))
					{
						$checkspace=preg_match('/\s/',$tempValueCheck);
						if($checkspace==1)
						{
							echo "xxx***Kode baris ke ".$z.", tidak boleh ada spasi";
							exit();
						}
						$statement =" AND A.KODE = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsCheckKonfirmasi(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("KONFIRMASI_ITEM_ASSESSMENT_ID");
						// unset($check);
						if(!empty($reqCheckId))
						{
							array_push($arrbaris, $z);
						}
					}
					else
					{
						echo "xxx***Kode baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				elseif($arrField[$rowCheck]=="NAMA")
				{
					if (!empty($tempValueCheck))
					{}
					else
					{
						echo "xxx***Nama baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				elseif($arrField[$rowCheck]=="NILAI")
				{
					if (!empty($tempValueCheck))
					{						
						if(is_numeric($tempValueCheck))
						{}
						else
						{
							echo "xxx***Nilai baris ke ".$z." harus berformat angka ";
							exit();
						}
					}
					else
					{
						echo "xxx***Nilai baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				
				// print_r($tempValueCheck);
				$colIndexCheck++;
			}
		}

		// exit;

		// exit;
		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){
				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				$set->setField($arrField[$row],$tempValue);
				$colIndex++;
			}

			$set->setField("LAST_CREATE_DATE", "NOW()");
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			if($set->insertkonfirmasi())
			{
				$reqSimpan = 1;
			}
		}

		if($reqSimpan == 1 )
		{
			echo $reqId."***Data berhasil disimpan";
		}
		else
		{
			echo "xxx***Data gagal disimpan";
		}
	}

	function program_item() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("KODE","NAMA","RATING");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="KODE")
				{
					if (!empty($tempValueCheck))
					{
						$checkspace=preg_match('/\s/',$tempValueCheck);
						if($checkspace==1)
						{
							echo "xxx***Kode baris ke ".$z.", tidak boleh ada spasi";
							exit();
						}
						$statement =" AND A.KODE = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsCheckProgram(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("PROGRAM_ITEM_ASSESSMENT_ID");
						// unset($check);
						if(!empty($reqCheckId))
						{
							array_push($arrbaris, $z);
						}
					}
					else
					{
						echo "xxx***Kode baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				elseif($arrField[$rowCheck]=="NAMA")
				{
					if (!empty($tempValueCheck))
					{}
					else
					{
						echo "xxx***Nama baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				elseif($arrField[$rowCheck]=="RATING")
				{
					if(is_numeric($tempValueCheck))
					{}
					else
					{
						echo "xxx***Pastikan bobot baris ke ".$z." sudah diisi dan berformat numeric";
						exit();
					}
				}
				
				// print_r($tempValueCheck);
				$colIndexCheck++;
			}
		}

		// exit;

		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){
				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				$set->setField($arrField[$row],$tempValue);
				$colIndex++;
			}

			$set->setField("LAST_CREATE_DATE", "NOW()");
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			if($set->insertprogram())
			{
				$reqSimpan = 1;
			}
		}

		if($reqSimpan == 1 )
		{
			echo $reqId."***Data berhasil disimpan";
		}
		else
		{
			echo "xxx***Data gagal disimpan";
		}
	}

	function peraturan() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("NAMA");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="NAMA")
				{
					if (!empty($tempValueCheck))
					{}
					else
					{
						echo "xxx***Nama baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				
				// print_r($tempValueCheck);
				$colIndexCheck++;
			}
		}

		// exit;

		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){
				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				$set->setField($arrField[$row],$tempValue);
				$colIndex++;
			}

			$set->setField("LAST_CREATE_DATE", "NOW()");
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			if($set->insertPeraturan())
			{
				$reqSimpan = 1;
			}
		}

		if($reqSimpan == 1 )
		{
			echo $reqId."***Data berhasil disimpan";
		}
		else
		{
			echo "xxx***Data gagal disimpan";
		}
	}


	function item_assessment_detil() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];
		$reqId= $this->input->post("reqId");

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("KATEGORI_ITEM_ASSESSMENT_ID","NAMA","STATUS_KONFIRMASI","PROGRAM_ITEM_ASSESSMENT_ID","STANDAR_REFERENSI_ID");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		$arrStandarId=array();
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="KATEGORI_ITEM_ASSESSMENT_ID")
				{
					if (!empty($tempValueCheck))
					{}
					else
					{
						echo "xxx***Kategori baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				elseif($arrField[$rowCheck]=="NAMA")
				{
					if (!empty($tempValueCheck))
					{}
					else
					{
						echo "xxx***Item Assessment baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				elseif($arrField[$rowCheck]=="STATUS_KONFIRMASI")
				{
					if (!empty($tempValueCheck))
					{}
					else
					{
						echo "xxx***Konfirmasi Nilai baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				elseif($arrField[$rowCheck]=="PROGRAM_ITEM_ASSESSMENT_ID")
				{
					if (!empty($tempValueCheck))
					{}
					else
					{
						echo "xxx***Program Item baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				elseif($arrField[$rowCheck]=="STANDAR_REFERENSI_ID")
				{
					if (!empty($tempValueCheck))
					{
					}
					else
					{
						echo "xxx***Standar Referensi baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				// print_r($tempValueCheck);
				$colIndexCheck++;
			}
		}

		// exit;

		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){
				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				$set->setField($arrField[$row],$tempValue);
				$set->setField("ITEM_ASSESSMENT_ID",$reqId);
				if($arrField[$row]=="STANDAR_REFERENSI_ID")
				{
					if (!empty($tempValue))
					{
						$arrStandarId=$tempValue;
					}
				}
				$colIndex++;
			}

			$set->setField("LAST_CREATE_DATE", "NOW()");
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			if($set->insertformulir())
			{
				$reqFormulirId=$set->id;
				$reqSimpan = 1;
			}

			$arrStandar = explode(',', $arrStandarId);

			if(!empty($arrStandar))
			{
				$reqSimpan="";
				foreach ($arrStandar as $key => $value) {

					$setstandar = new Import();
					$setstandar->setField("STANDAR_REFERENSI_ID", $value);
					$setstandar->setField("ITEM_ASSESSMENT_ID", $reqId);
					$setstandar->setField("ITEM_ASSESSMENT_FORMULIR_ID", $reqFormulirId);

					if($setstandar->insertstandaritem())
					{
						$reqSimpan= 1;
					}

				}

			}

			
		}

		if($reqSimpan == 1 )
		{
			echo $reqId."***Data berhasil disimpan";
		}
		else
		{
			echo "xxx***Data gagal disimpan";
		}
	}

	function jenis_rekomendasi() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("KODE","NAMA");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="KODE")
				{
					if (!empty($tempValueCheck))
					{
						$statement =" AND A.KODE = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsCheckJenisRekomendasi(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("JENIS_REKOMENDASI_ID");
						// unset($check);
						if(!empty($reqCheckId))
						{
							array_push($arrbaris, $z);
						}
					}
					else
					{
						echo "xxx***Kode  baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				$colIndexCheck++;	
			}
		}

		if(!empty($arrbaris))
		{
			$strbaris = implode (",", $arrbaris);
			echo "xxx***Kode  baris ke ".$strbaris." sudah ada";exit;
		}

		// exit;
		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				$set->setField($arrField[$row],$tempValue);
				$colIndex++;
			}

			$set->setField("LAST_CREATE_DATE", "NOW()");
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			if($set->insertjenisrekomendasi())
			{
				$reqSimpan = 1;
			}
		}

		if($reqSimpan == 1 )
		{
			echo $reqId."***Data berhasil disimpan";
		}
		else
		{
			echo "xxx***Data gagal disimpan";
		}
	}

	function kategori_rekomendasi() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("KODE","NAMA");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="KODE")
				{
					if (!empty($tempValueCheck))
					{
						$statement =" AND A.KODE = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsKategoriRekomendasi(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("KATEGORI_REKOMENDASI_ID");
						// unset($check);
						if(!empty($reqCheckId))
						{
							array_push($arrbaris, $z);
						}
					}
					else
					{
						echo "xxx***Kode baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				$colIndexCheck++;	
			}
		}

		if(!empty($arrbaris))
		{
			$strbaris = implode (",", $arrbaris);
			echo "xxx***Kode baris ke ".$strbaris." sudah ada";exit;
		}

		// exit;
		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				$set->setField($arrField[$row],$tempValue);
				$colIndex++;
			}

			$set->setField("LAST_CREATE_DATE", "NOW()");
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			if($set->insertkategorirekomendasi())
			{
				$reqSimpan = 1;
			}
		}

		if($reqSimpan == 1 )
		{
			echo $reqId."***Data berhasil disimpan";
		}
		else
		{
			echo "xxx***Data gagal disimpan";
		}
	}

	function prioritas_rekomendasi() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("KODE","NAMA");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="KODE")
				{
					if (!empty($tempValueCheck))
					{
						$statement =" AND A.KODE = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsPrioritasRekomendasi(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("PRIORITAS_REKOMENDASI_ID");
						// unset($check);
						if(!empty($reqCheckId))
						{
							array_push($arrbaris, $z);
						}
					}
					else
					{
						echo "xxx***Kode baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				$colIndexCheck++;	
			}
		}

		if(!empty($arrbaris))
		{
			$strbaris = implode (",", $arrbaris);
			echo "xxx***Kode baris ke ".$strbaris." sudah ada";exit;
		}

		// exit;
		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				$set->setField($arrField[$row],$tempValue);
				$colIndex++;
			}

			$set->setField("LAST_CREATE_DATE", "NOW()");
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			if($set->insertprioritasrekomendasi())
			{
				$reqSimpan = 1;
			}
		}

		if($reqSimpan == 1 )
		{
			echo $reqId."***Data berhasil disimpan";
		}
		else
		{
			echo "xxx***Data gagal disimpan";
		}
	}

	function status_rekomendasi() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("KODE","NAMA");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="KODE")
				{
					if (!empty($tempValueCheck))
					{
						$statement =" AND A.KODE = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsStatusRekomendasi(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("STATUS_REKOMENDASI_ID");
						// unset($check);
						if(!empty($reqCheckId))
						{
							array_push($arrbaris, $z);
						}
					}
					else
					{
						echo "xxx***Kode baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				$colIndexCheck++;	
			}
		}

		if(!empty($arrbaris))
		{
			$strbaris = implode (",", $arrbaris);
			echo "xxx***Kode baris ke ".$strbaris." sudah ada";exit;
		}

		// exit;
		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				$set->setField($arrField[$row],$tempValue);
				$colIndex++;
			}

			$set->setField("LAST_CREATE_DATE", "NOW()");
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			if($set->insertstatusrekomendasi())
			{
				$reqSimpan = 1;
			}
		}

		if($reqSimpan == 1 )
		{
			echo $reqId."***Data berhasil disimpan";
		}
		else
		{
			echo "xxx***Data gagal disimpan";
		}
	}

	function timeline_rekomendasi() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("KODE","NAMA","TAHUN");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="KODE")
				{
					if (!empty($tempValueCheck))
					{
						$statement =" AND A.KODE = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsTimelineRekomendasi(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("TIMELINE_REKOMENDASI_ID");
						// unset($check);
						if(!empty($reqCheckId))
						{
							array_push($arrbaris, $z);
						}
					}
					else
					{
						echo "xxx***Kode baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				elseif ($arrField[$rowCheck]=="TAHUN") {
					if(is_numeric($tempValueCheck))
					{}
					else
					{
						echo "xxx***Pastikan bobot baris ke ".$z." sudah diisi dan berformat numeric";
						exit();
					}
				}
				$colIndexCheck++;	
			}
		}

		if(!empty($arrbaris))
		{
			$strbaris = implode (",", $arrbaris);
			echo "xxx***Kode baris ke ".$strbaris." sudah ada";exit;
		}

		// exit;
		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				$set->setField($arrField[$row],$tempValue);
				$colIndex++;
			}

			$set->setField("LAST_CREATE_DATE", "NOW()");
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			if($set->insertTimelineRekomendasi())
			{
				$reqSimpan = 1;
			}
		}

		if($reqSimpan == 1 )
		{
			echo $reqId."***Data berhasil disimpan";
		}
		else
		{
			echo "xxx***Data gagal disimpan";
		}
	}

	function sumber_anggaran() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("KODE","NAMA");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="KODE")
				{
					if (!empty($tempValueCheck))
					{
						$statement =" AND A.KODE = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsSumberAnggaran(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("SUMBER_ANGGARAN_ID");
						// unset($check);
						if(!empty($reqCheckId))
						{
							array_push($arrbaris, $z);
						}
					}
					else
					{
						echo "xxx***Kode baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				$colIndexCheck++;	
			}
		}

		if(!empty($arrbaris))
		{
			$strbaris = implode (",", $arrbaris);
			echo "xxx***Kode baris ke ".$strbaris." sudah ada";exit;
		}

		// exit;
		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				$set->setField($arrField[$row],$tempValue);
				$colIndex++;
			}

			$set->setField("LAST_CREATE_DATE", "NOW()");
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			if($set->insertSumberAnggaran())
			{
				$reqSimpan = 1;
			}
		}

		if($reqSimpan == 1 )
		{
			echo $reqId."***Data berhasil disimpan";
		}
		else
		{
			echo "xxx***Data gagal disimpan";
		}
	}

	function risiko_template() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];
		$reqId= $this->input->post("reqId");

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("PERATURAN_ID","KODE","NAMA");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		$arrperaturan=[];
		$arrStandarId=array();
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="PERATURAN_ID")
				{
					if (!empty($tempValueCheck))
					{
						$statement =" AND A.PERATURAN_ID = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsCheckPeraturan(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("PERATURAN_ID");
						// unset($check);
						if(empty($reqCheckId))
						{
							array_push($arrperaturan, $z);
						}
					}
					else
					{
						echo "xxx***Peraturan baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				elseif($arrField[$rowCheck]=="KODE")
				{
					if (!empty($tempValueCheck))
					{
						$statement =" AND A.KODE = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsRisiko(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("RISIKO_ID");
						// unset($check);
						if(!empty($reqCheckId))
						{
							array_push($arrbaris, $z);
						}
					}
					else
					{
						echo "xxx***Kode  baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				// print_r($tempValueCheck);
				$colIndexCheck++;
			}
		}

		if(!empty($arrbaris))
		{
			$strbaris = implode (",", $arrbaris);
			echo "xxx***Kode baris ke ".$strbaris." sudah ada";exit;
		}

		if(!empty($arrperaturan))
		{
			$strbaris = implode (",", $arrperaturan);
			echo "xxx*** Peraturan Id baris ke ".$strbaris." tidak ditemukan";exit;
		}

		// exit;

		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){
				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				$set->setField($arrField[$row],$tempValue);
				$set->setField("RISIKO_ID",$reqId);

				$colIndex++;
			}

			$set->setField("LAST_CREATE_DATE", "NOW()");
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			if($set->insertrisiko())
			{
				$reqSimpan = 1;
			}
			
		}

		if($reqSimpan == 1 )
		{
			echo $reqId."***Data berhasil disimpan";
		}
		else
		{
			echo "xxx***Data gagal disimpan";
		}
	}

	function dampak_template() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];
		$reqId= $this->input->post("reqId");

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("PERATURAN_ID","KODE","NAMA","N_MIN","N_MAX","BOBOT");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		$arrperaturan=[];
		$arrStandarId=array();
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="PERATURAN_ID")
				{
					if (!empty($tempValueCheck))
					{
						$statement =" AND A.PERATURAN_ID = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsCheckPeraturan(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("PERATURAN_ID");
						// unset($check);
						if(empty($reqCheckId))
						{
							array_push($arrperaturan, $z);
						}
					}
					else
					{
						echo "xxx***Peraturan baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				elseif($arrField[$rowCheck]=="KODE")
				{
					if (!empty($tempValueCheck))
					{
						$statement =" AND A.KODE = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsDampak(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("DAMPAK_ID");
						// unset($check);
						if(!empty($reqCheckId))
						{
							array_push($arrbaris, $z);
						}
					}
					else
					{
						echo "xxx***Kode  baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				elseif ($arrField[$rowCheck]=="N_MIN") {

					// print_r($tempValueCheck);exit;
					if(is_numeric($tempValueCheck))
					{}
					else
					{
						echo "xxx***Pastikan Lebih besar daripada baris ke ".$z." sudah diisi dan berformat numeric";
						exit();
					}
				}
				elseif ($arrField[$rowCheck]=="N_MAX") {

					// print_r($tempValueCheck);exit;
					if(is_numeric($tempValueCheck))
					{}
					else
					{
						echo "xxx***Pastikan Lebih Kecil daripada baris ke ".$z." sudah diisi dan berformat numeric";
						exit();
					}
				}
				elseif ($arrField[$rowCheck]=="BOBOT") {

					// print_r($tempValueCheck);exit;
					if(is_numeric($tempValueCheck))
					{}
					else
					{
						echo "xxx***Pastikan bobot baris ke ".$z." sudah diisi dan berformat numeric";
						exit();
					}
				}
				// print_r($tempValueCheck);
				$colIndexCheck++;
			}
		}

		if(!empty($arrbaris))
		{
			$strbaris = implode (",", $arrbaris);
			echo "xxx***Kode baris ke ".$strbaris." sudah ada";exit;
		}

		if(!empty($arrperaturan))
		{
			$strbaris = implode (",", $arrperaturan);
			echo "xxx*** Peraturan Id baris ke ".$strbaris." tidak ditemukan";exit;
		}

		// exit;

		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){
				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				$set->setField($arrField[$row],$tempValue);
				$set->setField("DAMPAK_ID",$reqId);

				$colIndex++;
			}

			$set->setField("LAST_CREATE_DATE", "NOW()");
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			if($set->insertdampak())
			{
				$reqSimpan = 1;
			}
			
		}

		if($reqSimpan == 1 )
		{
			echo $reqId."***Data berhasil disimpan";
		}
		else
		{
			echo "xxx***Data gagal disimpan";
		}
	}

	function kemungkinan_template() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];
		$reqId= $this->input->post("reqId");

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("PERATURAN_ID","KODE","NAMA","N_MIN","N_MAX","BOBOT");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		$arrperaturan=[];
		$arrStandarId=array();
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="PERATURAN_ID")
				{
					if (!empty($tempValueCheck))
					{
						$statement =" AND A.PERATURAN_ID = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsCheckPeraturan(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("PERATURAN_ID");
						// unset($check);
						if(empty($reqCheckId))
						{
							array_push($arrperaturan, $z);
						}
					}
					else
					{
						echo "xxx***Peraturan baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				elseif($arrField[$rowCheck]=="KODE")
				{
					if (!empty($tempValueCheck))
					{
						$statement =" AND A.KODE = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsKemungkinan(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("KEMUNGKINAN_ID");
						// unset($check);
						if(!empty($reqCheckId))
						{
							array_push($arrbaris, $z);
						}
					}
					else
					{
						echo "xxx***Kode baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				elseif ($arrField[$rowCheck]=="N_MIN") {

					// print_r($tempValueCheck);exit;
					if(is_numeric($tempValueCheck))
					{}
					else
					{
						echo "xxx***Pastikan Lebih besar daripada baris ke ".$z." sudah diisi dan berformat numeric";
						exit();
					}
				}
				elseif ($arrField[$rowCheck]=="N_MAX") {

					// print_r($tempValueCheck);exit;
					if(is_numeric($tempValueCheck))
					{}
					else
					{
						echo "xxx***Pastikan Lebih Kecil daripada baris ke ".$z." sudah diisi dan berformat numeric";
						exit();
					}
				}
				elseif ($arrField[$rowCheck]=="BOBOT") {

					// print_r($tempValueCheck);exit;
					if(is_numeric($tempValueCheck))
					{}
					else
					{
						echo "xxx***Pastikan bobot baris ke ".$z." sudah diisi dan berformat numeric";
						exit();
					}
				}
				// print_r($tempValueCheck);
				$colIndexCheck++;
			}
		}

		if(!empty($arrbaris))
		{
			$strbaris = implode (",", $arrbaris);
			echo "xxx***Kode baris ke ".$strbaris." sudah ada";exit;
		}

		if(!empty($arrperaturan))
		{
			$strbaris = implode (",", $arrperaturan);
			echo "xxx*** Peraturan Id baris ke ".$strbaris." tidak ditemukan";exit;
		}

		// exit;

		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){
				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				$set->setField($arrField[$row],$tempValue);
				$set->setField("KEMUNGKINAN_ID",$reqId);

				$colIndex++;
			}

			$set->setField("LAST_CREATE_DATE", "NOW()");
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			if($set->insertkemungkinan())
			{
				$reqSimpan = 1;
			}
			
		}

		if($reqSimpan == 1 )
		{
			echo $reqId."***Data berhasil disimpan";
		}
		else
		{
			echo "xxx***Data gagal disimpan";
		}
	}

	function matriks_risiko_template() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];
		$reqId= $this->input->post("reqId");

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("KODE","RISIKO_ID","DAMPAK_ID","KEMUNGKINAN_ID");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		$arrRisiko=[];
		$arrDampak=[];
		$arrKemungkinan=[];
		$arrStandarId=array();
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="RISIKO_ID")
				{
					if (!empty($tempValueCheck))
					{
						$statement =" AND A.RISIKO_ID = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsRisiko(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("RISIKO_ID");
						// unset($check);
						if(empty($reqCheckId))
						{
							array_push($arrRisiko, $z);
						}
					}
					else
					{
						echo "xxx***Risiko baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				elseif($arrField[$rowCheck]=="KODE")
				{
					if (!empty($tempValueCheck))
					{
						$statement =" AND A.KODE = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsKemungkinan(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("KEMUNGKINAN_ID");
						// unset($check);
						if(!empty($reqCheckId))
						{
							array_push($arrbaris, $z);
						}
					}
					else
					{
						echo "xxx***Kode baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				elseif($arrField[$rowCheck]=="DAMPAK_ID")
				{
					if (!empty($tempValueCheck))
					{
						$statement =" AND A.DAMPAK_ID = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsDampak(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("DAMPAK_ID");
						// unset($check);
						if(empty($reqCheckId))
						{
							array_push($arrDampak, $z);
						}
					}
					else
					{
						echo "xxx***Dampak baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				elseif($arrField[$rowCheck]=="KEMUNGKINAN_ID")
				{
					if (!empty($tempValueCheck))
					{
						$statement =" AND A.KEMUNGKINAN_ID = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsKemungkinan(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("KEMUNGKINAN_ID");
						// unset($check);
						if(empty($reqCheckId))
						{
							array_push($arrKemungkinan, $z);
						}
					}
					else
					{
						echo "xxx***Kemungkinan baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				// print_r($tempValueCheck);
				$colIndexCheck++;
			}
		}

		if(!empty($arrbaris))
		{
			$strbaris = implode (",", $arrbaris);
			echo "xxx***Kode baris ke ".$strbaris." sudah ada";exit;
		}

		if(!empty($arrRisiko))
		{
			$strbaris = implode (",", $arrRisiko);
			echo "xxx*** Risiko Id baris ke ".$strbaris." tidak ditemukan";exit;
		}

		if(!empty($arrDampak))
		{
			$strbaris = implode (",", $arrDampak);
			echo "xxx*** Dampak Id baris ke ".$strbaris." tidak ditemukan";exit;
		}

		if(!empty($arrKemungkinan))
		{
			$strbaris = implode (",", $arrKemungkinan);
			echo "xxx*** Kemungkinan Id baris ke ".$strbaris." tidak ditemukan";exit;
		}

		// exit;

		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){
				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				$set->setField($arrField[$row],$tempValue);
				$set->setField("MATRIKS_RISIKO_ID",$reqId);

				$colIndex++;
			}

			$set->setField("LAST_CREATE_DATE", "NOW()");
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			if($set->insertmatriksrisiko())
			{
				$reqSimpan = 1;
			}
			
		}

		if($reqSimpan == 1 )
		{
			echo $reqId."***Data berhasil disimpan";
		}
		else
		{
			echo "xxx***Data gagal disimpan";
		}
	}

	


	

}