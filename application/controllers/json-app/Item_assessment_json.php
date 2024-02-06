<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class item_assessment_json extends CI_Controller
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
		// print_r($this->configtitle);exit;
	}

	function json()
	{
		$this->load->model("base-app/ItemAssessment");

		$set= new ItemAssessment();

		if ( isset( $_REQUEST['columnsDef'] ) && is_array( $_REQUEST['columnsDef'] ) ) {
			$columnsDefault = [];
			foreach ( $_REQUEST['columnsDef'] as $field ) {
				$columnsDefault[ $field ] = "true";
			}
		}
		// print_r($columnsDefault);exit;

		$displaystart= -1;
		$displaylength= -1;

		$arrinfodata= [];

		$reqPencarian= $this->input->get("reqPencarian");
		$reqStatus= $this->input->get("reqStatus");
		$reqArea= $this->input->get("reqArea");
		$searchJson= "";
		if(!empty($reqPencarian))
		{
			$searchJson= " 
			AND 
			(
				UPPER(A.NAMA) LIKE '%".strtoupper($reqPencarian)."%'
				OR UPPER(A.NAMA) LIKE '%".strtoupper($reqPencarian)."%'
			)";
		}


		if(!empty($reqStatus))
		{
			if($reqStatus== 'NULL')
			{
				$statement .= " AND A.STATUS IS NULL";
			}
			else
			{
				$statement .= " AND A.STATUS =".$reqStatus;
			}
			
		}

		if(!empty($reqArea))
		{
			$statement .= " AND LIST_AREA_ID_INFO like  '%".$reqArea."%'";
		}

		$sOrder = " ORDER BY A.KODE ASC ";
		$set->selectByParams(array(), $dsplyRange, $dsplyStart, $statement.$searchJson, $sOrder);

		// echo $set->query;exit;
		$infobatasdetil= $_REQUEST['start'] + $_REQUEST['length'];
		$infonomor= 0;
		while ($set->nextRow()) 
		{
			$infonomor++;

			$row= [];
			foreach($columnsDefault as $valkey => $valitem) 
			{
				if ($valkey == "SORDERDEFAULT")
				{
					$row[$valkey]= $set->getField("NAMA");
				}
				else if ($valkey == "NO")
				{
					$row[$valkey]= $infonomor;
				}
				else
					$row[$valkey]= $set->getField($valkey);
			}
			array_push($arrinfodata, $row);
		}

		// get all raw data
		$alldata = $arrinfodata;
		// print_r($alldata);exit;

		$data = [];
		// internal use; filter selected columns only from raw data
		foreach ( $alldata as $d ) {
			// $data[] = filterArray( $d, $columnsDefault );
			$data[] = $d;
		}

		// count data
		$totalRecords = $totalDisplay = count( $data );

		// filter by general search keyword
		if ( isset( $_REQUEST['search'] ) ) {
			$data         = filterKeyword( $data, $_REQUEST['search'] );
			$totalDisplay = count( $data );
		}

		if ( isset( $_REQUEST['columns'] ) && is_array( $_REQUEST['columns'] ) ) {
			foreach ( $_REQUEST['columns'] as $column ) {
				if ( isset( $column['search'] ) ) {
					$data         = filterKeyword( $data, $column['search'], $column['data'] );
					$totalDisplay = count( $data );
				}
			}
		}

		// sort
		if ( isset( $_REQUEST['order'][0]['column'] ) && $_REQUEST['order'][0]['dir'] ) {
			$column = $_REQUEST['order'][0]['column'];

				$dir    = $_REQUEST['order'][0]['dir'];
				usort( $data, function ( $a, $b ) use ( $column, $dir ) {
					$a = array_slice( $a, $column, 1 );
					$b = array_slice( $b, $column, 1 );
					$a = array_pop( $a );
					$b = array_pop( $b );

					if ( $dir === 'asc' ) {
						return $a > $b ? true : false;
					}

					return $a < $b ? true : false;
				} );
		}

		// pagination length
		if ( isset( $_REQUEST['length'] ) ) {
			if($_REQUEST['length'] =="-1")
			{
				$data=array_values($data);
			}
			else
			{
				$data = array_splice( $data, $_REQUEST['start'], $_REQUEST['length'] );
			}
		}

		// return array values only without the keys
		if ( isset( $_REQUEST['array_values'] ) && $_REQUEST['array_values'] ) {
			$tmp  = $data;
			$data = [];
			foreach ( $tmp as $d ) {
				$data[] = array_values( $d );
			}
		}

		$result = [
		    'recordsTotal'    => $totalRecords,
		    'recordsFiltered' => $totalDisplay,
		    'data'            => $data,
		];

		header('Content-Type: application/json');
		echo json_encode( $result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function add()
	{
		$this->load->model("base-app/ItemAssessment");

		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		$reqNama= $this->input->post("reqNama");
		$reqDuplikat= $this->input->post("reqDuplikat");

		$reqKategoriId= $this->input->post("reqKategoriId");
		$reqNama= $this->input->post("reqNama");
		$reqStandarId= $this->input->post("reqStandarId");
		$reqTersedia= $this->input->post("reqTersedia");
		$reqProgramId= $this->input->post("reqProgramId");
		$reqUniqId= $this->input->post("reqUniqId");
		$reqArrFormulirId= $this->input->post("reqFormulirId");

		$reqListAreaId= $this->input->post("reqListAreaId");
		$reqKode= $this->input->post("reqKode");

		// print_r($reqStandarId);exit;

	
		$set = new ItemAssessment();
		$set->setField("ITEM_ASSESSMENT_ID", $reqId);
		$set->setField("DUPLIKAT", ValToNullDB($reqDuplikat));
		$set->setField("LIST_AREA_ID", ValToNullDB($reqListAreaId));
		$set->setField("KODE", $reqKode);

		
		if ( preg_match('/\s/',$reqKode) )
		{
			echo "xxx***Kolom kode tidak boleh terdapat spasi";exit;
		}
		
		$reqSimpan= "";
		if ($reqMode == "insert")
		{
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			$set->setField("LAST_CREATE_DATE", 'NOW()');

			// $statement=" AND A.KODE =  '".$reqKode."' ";
			// $check = new ItemAssessment();
			// $check->selectByParams(array(), -1, -1, $statement);
			// // echo $check->query;exit;
			// $check->firstRow();
			// $checkKode= $check->getField("KODE");
			// unset($check);

			// if(!empty($checkKode))
			// {
			// 	echo "xxx***Kode  ".$checkKode." sudah ada";exit;	
			// }

			$statement=" AND A.LIST_AREA_ID =  '".$reqListAreaId."'  ";
			$check = new ItemAssessment();
			$check->selectByParams(array(), -1, -1, $statement);
			// echo $check->query;exit;
			$check->firstRow();
			$checkarea= $check->getField("LIST_AREA_NAMA");
			unset($check);

			if(!empty($checkarea))
			{
				echo "xxx***Area ".$checkarea." sudah ada";exit;	
			}


			if($set->insert())
			{
				$reqSimpan= 1;
				$reqId=$set->id;
			}
		}
		else
		{	
			$set->setField("LAST_UPDATE_USER", $this->appusernama);
			$set->setField("LAST_UPDATE_DATE", 'NOW()');

			$statement=" AND A.LIST_AREA_ID =  '".$reqListAreaId."' AND A.ITEM_ASSESSMENT_ID <> '".$reqId."'   ";
			$check = new ItemAssessment();
			$check->selectByParams(array(), -1, -1, $statement);
			// echo $check->query;exit;
			$check->firstRow();
			$checkarea= $check->getField("LIST_AREA_NAMA");
			unset($check);

			if(!empty($checkarea))
			{
				echo "xxx***Area ".$checkarea." sudah ada";exit;	
			}

			if($set->update())
			{
				$reqSimpan= 1;
			}
		}

		// print_r($reqStandarId);exit;

		// if(!empty($reqListAreaId))
		// {
		// 	$setdelete = new ItemAssessment();
		// 	$reqSimpan="";
		// 	$setdelete->setField("ITEM_ASSESSMENT_ID", $reqId);
		// 	$setdelete->deletearea();

		// 	foreach ($reqListAreaId as $key => $value) 
		// 	{
		// 		$setpengukuran = new ItemAssessment();
		// 		$setpengukuran->setField("LIST_AREA_ID", $value);
		// 		$setpengukuran->setField("ITEM_ASSESSMENT_ID", $reqId);

		// 		if($setpengukuran->insertarea())
		// 		{
		// 			$reqSimpan= 1;
		// 		}
		// 	}
		// }

		// print_r($reqArrFormulirId);exit;
		if(!empty($reqNama))
		{
			// $setdelete = new ItemAssessment();
			$reqSimpan="";
			// $setdelete->setField("ITEM_ASSESSMENT_ID", $reqId);
			// $setdelete->deleteformulir();

			$setdeletestandar = new ItemAssessment();
			$setdeletestandar->setField("ITEM_ASSESSMENT_ID", $reqId);
			$setdeletestandar->deletestandar();

			// print_r( $reqNama);exit;
			foreach ($reqNama as $key => $value) 
			{
				$setpengukuran = new ItemAssessment();
				$setpengukuran->setField("NAMA", $value);
				$setpengukuran->setField("KATEGORI_ITEM_ASSESSMENT_ID", ValToNullDB($reqKategoriId[$key]));
				$setpengukuran->setField("PROGRAM_ITEM_ASSESSMENT_ID", ValToNullDB($reqProgramId[$key]));
				$setpengukuran->setField("STATUS_KONFIRMASI", ValToNullDB($reqTersedia[$key]));
				$setpengukuran->setField("ITEM_ASSESSMENT_ID", $reqId);
				$setpengukuran->setField("STANDAR_REFERENSI_ID", $reqStandarId[$key]);

				if(empty($reqArrFormulirId[$key]))
				{

					if($setpengukuran->insertformulir())
					{
						$reqFormulirId=$setpengukuran->id;
						$reqSimpan= 1;
					}

				}
				else
				{
					$reqFormulirId=$reqArrFormulirId[$key];
					$setpengukuran->setField("ITEM_ASSESSMENT_FORMULIR_ID", $reqFormulirId);
					if($setpengukuran->updateformulir())
					{
						
						$reqSimpan= 1;
					}
				}

				

				if(!empty($reqStandarId[$key]) && !empty($reqFormulirId) )
				{
					$arrStandar = explode(',', $reqStandarId[$key]);

					foreach ($arrStandar as $key => $value) {

						$setstandar = new ItemAssessment();
						$setstandar->setField("STANDAR_REFERENSI_ID", $value);
						$setstandar->setField("ITEM_ASSESSMENT_ID", $reqId);
						$setstandar->setField("ITEM_ASSESSMENT_FORMULIR_ID", $reqFormulirId);

						if($setstandar->insertstandar())
						{
							// print_r($reqFormulirId);
							$reqSimpan= 1;
						}
								
					}
					
				}
				
			}
		}

		if($reqSimpan == 1 )
		{
			$setdetil= new ItemAssessment();
			$setdetil->setField("ITEM_ASSESSMENT_ID", $reqId);
			$setdetil->duplikatitemassessment();

			echo $reqId."***Data berhasil disimpan";
		}
		else
		{
			echo "xxx***Data gagal disimpan";
		}
				
	}

	function delete()
	{
		$this->load->model("base-app/ItemAssessment");
		$set = new ItemAssessment();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');

		$set->setField("ITEM_ASSESSMENT_ID", $reqId);

		if($set->deleteall())
		{
			$arrJson["PESAN"] = "Data berhasil dihapus.";
		}
		else
		{
			$arrJson["PESAN"] = "Data gagal dihapus / data sudah dipakai ditransaksi";	
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function deletedetil()
	{
		$this->load->model("base-app/ItemAssessment");
		$set = new ItemAssessment();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');
		$reqRowId =  $this->input->get('reqRowId');

		$set->setField("ITEM_ASSESSMENT_ID", $reqId);
		$set->setField("ITEM_ASSESSMENT_FORMULIR_ID", $reqRowId);

		if($set->deleteformulirdetil())
		{
			$arrJson["PESAN"] = "Data berhasil dihapus.";
		}
		else
		{
			$arrJson["PESAN"] = "Data gagal dihapus.";	
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}


	function update_status()
	{
		$this->load->model("base-app/ItemAssessment");
		$set = new ItemAssessment();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');

		$reqStatus =  $this->input->get('reqStatus');

		$set->setField("ITEM_ASSESSMENT_ID", $reqId);
		$set->setField("STATUS", ValToNullDB($reqStatus));

		if($reqStatus==1)
		{
			$pesan="dinonaktifkan.";
		}
		else
		{
			$pesan="diaktifkan.";
		}

		if($set->update_status())
		{
			$arrJson["PESAN"] = "Data berhasil ".$pesan;
		}
		else
		{
			$arrJson["PESAN"] =  "Data gagal ".$pesan;
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

}