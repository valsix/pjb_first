<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class kategori_item_assessment_json extends CI_Controller
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
		$this->load->model("base-app/KategoriItemAssessment");

		$set= new KategoriItemAssessment();

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
		$searchJson= "";
		$statement="";
		if(!empty($reqPencarian))
		{
			$searchJson= " 
			AND 
			(
				UPPER(A.NAMA) LIKE '%".strtoupper($reqPencarian)."%'
				OR UPPER(A.NAMA) LIKE '%".strtoupper($reqPencarian)."%'
			)";
		}

		$sOrder = " ORDER BY A.NAMA ASC ";

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
		$this->load->model("base-app/KategoriItemAssessment");

		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		$reqNama= $this->input->post("reqNama");
		$reqBobot= $this->input->post("reqBobot");
		$reqKode= $this->input->post("reqKode");

		// $reqAreaId= $this->input->post("reqAreaId");
		// $reqItemId= $this->input->post("reqItemId");
		// print_r($reqKategoriItemAssessmentId);exit;

		$set = new KategoriItemAssessment();
		$set->setField("KATEGORI_ITEM_ASSESSMENT_ID", $reqId);
		$set->setField("NAMA", $reqNama);
		$set->setField("BOBOT", ValToNullDB($reqBobot));
		$set->setField("KODE", $reqKode);

		// $set->setField("AREA_ID", ValToNullDB($reqAreaId));
		// $set->setField("ITEM_ASSESSMENT_ID", ValToNullDB($reqItemId));

		
		if ( preg_match('/\s/',$reqKode) )
		{
			echo "xxx***Kolom kode tidak boleh terdapat spasi";exit;
		}

		$reqSimpan= "";
		if ($reqMode == "insert")
		{
			$statement=" AND A.KODE =  '".$reqKode."' ";
			$check = new KategoriItemAssessment();
			$check->selectByParams(array(), -1, -1, $statement);
			// echo $check->query;exit;
			$check->firstRow();
			$checkKode= $check->getField("KODE");

			if(!empty($checkKode))
			{
				echo "xxx***Kode  ".$checkKode." sudah ada";exit;	
			}

			$set->setField("LAST_CREATE_USER", $this->appusernama);
			$set->setField("LAST_CREATE_DATE", 'NOW()');

			if($set->insert())
			{
				$reqSimpan= 1;
			}
		}
		else
		{	
			$statement=" AND A.KATEGORI_ITEM_ASSESSMENT_ID =  '".$reqId."' ";
			$check = new KategoriItemAssessment();
			$check->selectByParams(array(), -1, -1, $statement);
			// echo $check->query;exit;
			$check->firstRow();
			$checkKode= $check->getField("KODE");

			if($checkKode !== $reqKode)  
			{
				$statement=" AND A.KODE =  '".$reqKode."' ";
				$check = new KategoriItemAssessment();
				$check->selectByParams(array(), -1, -1, $statement);
				// echo $check->query;exit;
				$check->firstRow();
				$checkKode= $check->getField("KODE");
				if(!empty($checkKode))
				{
					echo "xxx***Kode  ".$checkKode." sudah ada";exit;	
				}	
			}

			$set->setField("LAST_UPDATE_USER", $this->appusernama);
			$set->setField("LAST_UPDATE_DATE", 'NOW()');
			if($set->update())
			{
				$reqSimpan= 1;
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

	function delete()
	{
		$this->load->model("base-app/KategoriItemAssessment");
		$set = new KategoriItemAssessment();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');

		$set->setField("KATEGORI_ITEM_ASSESSMENT_ID", $reqId);

		if($set->delete())
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
		$this->load->model("base-app/KategoriItemAssessment");
		$set = new KategoriItemAssessment();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');

		$reqStatus =  $this->input->get('reqStatus');

		$set->setField("KATEGORI_ITEM_ASSESSMENT_ID", $reqId);
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