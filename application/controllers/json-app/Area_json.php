<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class area_json extends CI_Controller
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
		$this->load->model("base-app/Area");

		$set= new Area();

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

		$sOrder = " ";
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
				$data=$data;
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
		$this->load->model("base-app/Area");

		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		$reqNama= $this->input->post("reqNama");
	
		$set = new Area();
		$set->setField("AREA_ID", $reqId);
		$set->setField("NAMA", $reqNama);

		$reqSimpan= "";
		if ($reqMode == "insert")
		{
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			$set->setField("LAST_CREATE_DATE", 'NOW()');

			$statement=" AND A.NAMA =  '".$reqNama."' ";
			$check = new Area();
			$check->selectByParams(array(), -1, -1, $statement);
			// echo $check->query;exit;
			$check->firstRow();
			$checkKode= $check->getField("NAMA");

			if(!empty($checkKode))
			{
				echo "xxx***Nama Area ".$checkKode." sudah ada";exit;	
			}

			if($set->insert())
			{
				$reqSimpan= 1;
			}
		}
		else
		{	
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
		$this->load->model("base-app/Area");
		$set = new Area();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');

		$set->setField("AREA_ID", $reqId);

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
		$this->load->model("base-app/Area");
		$set = new Area();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');

		$reqStatus =  $this->input->get('reqStatus');

		$set->setField("AREA_ID", $reqId);
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

	function area_popup() 
	{	
		$reqUnitKerjaId = $this->input->get("reqUnitKerjaId");
		$reqStatus = $this->input->get("reqStatus");
		$reqId = $this->input->get("reqId");
		
		if($reqUnitKerjaId == "")
			$reqUnitKerjaId = $this->CABANG_ID;
		
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$rows = isset($_GET['rows']) ? intval($_GET['rows']) : 50;
		$id   = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$offset = ($page-1)*$rows;

		// print_r($_GET['rows']);exit;
		
		$reqPencarian = trim($this->input->get("reqPencarian"));
		$reqMode = $this->input->get("reqMode");
		$reqKelompokEquipmentId = $this->input->get("reqKelompokEquipmentId");
		
		$this->load->model("base-app/Area");

		$formuji = new Area();

		$statement="";


		if(!empty($reqPencarian))
		{
			$statement .= " AND UPPER(A.NAMA) LIKE '%".strtoupper($reqPencarian)."%'  ";
		}

		if(!empty($reqId))
		{
			$statementid .= " AND B.AREA_ASSESSMENT_ID = ".$reqId;

			$statement .=" 
			AND NOT EXISTS 
			( 
				SELECT AREA_ID FROM AREA_ASSESSMENT_AREA B WHERE A.AREA_ID=B.AREA_ID  ".$statementid."
			)
			";
		}
		
		$rowCount = $formuji->getCountByParams($arrStatement, $statement.$statement_privacy);
		$formuji->selectByParams($arrStatement, $rows, $offset, $statement.$statement_privacy, " ORDER BY A.AREA_ID  ASC ");
		// echo $formuji->query;exit;
		$i = 0;
		$items = array();
		while($formuji->nextRow())
		{
			// print_r($check);exit;
			$this->TREETABLE_COUNT++;
			
			$row['id']				= $formuji->getField("AREA_ID");
			$row['text']			= $formuji->getField("NAMA");
			$row['AREA_ID']				= $formuji->getField("AREA_ID");
			$row['NAMA']			= $formuji->getField("NAMA");
		
			$i++;
			array_push($items, $row);
			unset($row);
		}

		$result["rows"] = $items;
		$result["total"] = $rowCount;
		
		// print_r($result);exit;
		echo json_encode($result);
	}

	function distrik_popup() 
	{	
		$reqUnitKerjaId = $this->input->get("reqUnitKerjaId");
		$reqId = $this->input->get("reqId");
		
		if($reqUnitKerjaId == "")
			$reqUnitKerjaId = $this->CABANG_ID;
		
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$rows = isset($_GET['rows']) ? intval($_GET['rows']) : 50;
		$id   = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$offset = ($page-1)*$rows;

		// print_r($_GET['rows']);exit;
		
		$reqPencarian = trim($this->input->get("reqPencarian"));
		$reqMode = $this->input->get("reqMode");
		$reqKelompokEquipmentId = $this->input->get("reqKelompokEquipmentId");
		
		$this->load->model("base-app/Distrik");

		$formuji = new Distrik();

		$statement=" ";
		$statementid="";


		if(!empty($reqPencarian))
		{
			$statement .= " AND UPPER(A.NAMA) LIKE '%".strtoupper($reqPencarian)."%'  OR UPPER(A.KODE) LIKE '%".strtoupper($reqPencarian)."%' ";
		}

		if(!empty($reqId))
		{
			$statementid .= " AND B.AREA_ASSESSMENT_ID = ".$reqId;

			$statement .=" 
			AND NOT EXISTS 
			( 
				SELECT DISTRIK_ID FROM AREA_ASSESSMENT_DISTRIK B WHERE A.DISTRIK_ID=B.DISTRIK_ID  ".$statementid."
			)
			";
		}

		// print_r($statementid);exit;

		$rowCount = $formuji->getCountByParamsAreaDistrik($arrStatement, $statement);
		$formuji->selectByParamsAreaDistrik($arrStatement, $rows, $offset, $statement,$statementid, " ORDER BY A.DISTRIK_ID  ASC ");
		// echo $formuji->query;exit;
		$i = 0;
		$items = array();
		while($formuji->nextRow())
		{
			// print_r($check);exit;
			$this->TREETABLE_COUNT++;
			
			$row['id']				= $formuji->getField("DISTRIK_ID");
			$row['text']			= $formuji->getField("KODE")." - ".$formuji->getField("NAMA") ;
			$row['DISTRIK_ID']		= $formuji->getField("DISTRIK_ID");
			$row['NAMA']			= $formuji->getField("KODE")." - ".$formuji->getField("NAMA") ;
		
			$i++;
			array_push($items, $row);
			unset($row);
		}

		$result["rows"] = $items;
		$result["total"] = $rowCount;
		
		// print_r($result);exit;
		echo json_encode($result);
	}

	function area_duplikat_popup() 
	{	
		$reqUnitKerjaId = $this->input->get("reqUnitKerjaId");
		$reqStatus = $this->input->get("reqStatus");
		$reqId = $this->input->get("reqId");
		
		if($reqUnitKerjaId == "")
			$reqUnitKerjaId = $this->CABANG_ID;
		
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$rows = isset($_GET['rows']) ? intval($_GET['rows']) : 50;
		$id   = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$offset = ($page-1)*$rows;

		// print_r($_GET['rows']);exit;
		
		$reqPencarian = trim($this->input->get("reqPencarian"));
		$reqMode = $this->input->get("reqMode");
		$reqKelompokEquipmentId = $this->input->get("reqKelompokEquipmentId");
		
		$this->load->model("base-app/ListArea");

		$formuji = new ListArea();

		$statement="";


		if(!empty($reqPencarian))
		{
			$statement .= " AND UPPER(A.NAMA) LIKE '%".strtoupper($reqPencarian)."%'  ";
		}

		// if(!empty($reqId))
		// {
		// 	$statementid .= " AND B.AREA_ASSESSMENT_ID = ".$reqId;

		// 	$statement .=" 
		// 	AND NOT EXISTS 
		// 	( 
		// 		SELECT AREA_ID FROM AREA_ASSESSMENT_AREA B WHERE A.AREA_ID=B.AREA_ID  ".$statementid."
		// 	)
		// 	";
		// }
		
		$rowCount = $formuji->getCountduplikat($arrStatement, $statement.$statement_privacy);
		$formuji->selectduplikat($arrStatement, $rows, $offset, $statement.$statement_privacy, " ORDER BY A.NAMA  ASC ");
		// echo $formuji->query;exit;
		$i = 0;
		$items = array();
		while($formuji->nextRow())
		{
			// print_r($check);exit;
			$this->TREETABLE_COUNT++;
			
			$row['id']				= $formuji->getField("LIST_AREA_ID");
			$row['text']			= $formuji->getField("KODE_INFO") ." - ". $formuji->getField("NAMA");
			$row['LIST_AREA_ID']	= $formuji->getField("LIST_AREA_ID");
			$row['NAMA']			= $formuji->getField("KODE_INFO") ." - ". $formuji->getField("NAMA");
			$row['KODE_DUPLIKAT']			= $formuji->getField("KODE_DUPLIKAT") ;
		
			$i++;
			array_push($items, $row);
			unset($row);
		}

		$result["rows"] = $items;
		$result["total"] = $rowCount;
		
		// print_r($result);exit;
		echo json_encode($result);
	}

}