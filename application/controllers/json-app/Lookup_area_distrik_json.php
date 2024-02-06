<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class lookup_area_distrik_json extends CI_Controller
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
		$this->load->model("base-app/ListArea");
		$this->load->model("base-app/OutliningAssessment");

		$set= new ListArea();
		$outliningassessment= new OutliningAssessment();

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

		$reqId= $this->input->get("reqId");
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


		$statementn=" AND A.OUTLINING_ASSESSMENT_ID = ".$reqId;
		$statement=" AND A.STATUS IS NULL AND B.STATUS_KONFIRMASI = 1";

		
		$outliningassessment->selectByParams(array(), -1, -1, $statementn);
		$outliningassessment->firstRow();
		$reqDistrikId= $outliningassessment->getField("DISTRIK_ID");
		$reqBlokId= $outliningassessment->getField("BLOK_UNIT_ID");
		$reqUnitMesinId= $outliningassessment->getField("UNIT_MESIN_ID");

		if(!empty($reqDistrikId))
		{
			$statement .=" AND C.DISTRIK_ID = ".$reqDistrikId;
		}

		if(!empty($reqBlokId))
		{
			$statement .=" AND C.BLOK_UNIT_ID = ".$reqBlokId;
		}

		if(!empty($reqUnitMesinId))
		{
			$statement .=" AND C.UNIT_MESIN_ID = ".$reqUnitMesinId;
		}

		$statement .=" AND NOT  EXISTS 
		(
			SELECT 1
			FROM OUTLINING_ASSESSMENT_DETIL X
			WHERE X.ITEM_ASSESSMENT_DUPLIKAT_ID = A1.ITEM_ASSESSMENT_DUPLIKAT_ID
			AND X.AREA_UNIT_ID = C.AREA_UNIT_ID AND X.AREA_UNIT_DETIL_ID = B.AREA_UNIT_DETIL_ID
			AND X.OUTLINING_ASSESSMENT_ID = ".$reqId."

		) ";

		$sOrder = " ORDER BY A.KODE || GENERATEZERO(A1.KODE,2) ASC";
		$set->selectduplikatfilter(array(), $dsplyRange, $dsplyStart, $statement.$searchJson, $sOrder);

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
				elseif ($valkey == "KODE_INFO")
				{
					$row[$valkey]= $set->getField("KODE_INFO")." - ".$set->getField("NAMA");
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
			$data = array_splice( $data, $_REQUEST['start'], $_REQUEST['length'] );
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

	function multi() 
	{	
		$reqId = $this->input->get("reqId");
		
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$rows = isset($_GET['rows']) ? intval($_GET['rows']) : 50;
		$id   = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$offset = ($page-1)*$rows;

		// print_r($_GET['rows']);exit;
		
		$reqPencarian = trim($this->input->get("reqPencarian"));
		$reqMode = $this->input->get("reqMode");
		// $reqBlokId = $this->input->get("reqBlokId");
		
		$this->load->model("base-app/ListArea");
		$this->load->model("base-app/OutliningAssessment");

		$formuji = new ListArea();
		$outliningassessment = new OutliningAssessment();

		$statement="";



		$statementn=" AND A.OUTLINING_ASSESSMENT_ID = ".$reqId;
		$statement=" AND A.STATUS IS NULL AND B.STATUS_KONFIRMASI = 1";


		if(!empty($reqPencarian))
		{
			$statement.= " 
			AND 
			(
				UPPER(A.NAMA) LIKE '%".strtoupper($reqPencarian)."%'
				OR UPPER(A.NAMA) LIKE '%".strtoupper($reqPencarian)."%'
			)";
		}

		
		$outliningassessment->selectByParams(array(), -1, -1, $statementn);
		$outliningassessment->firstRow();
		$reqDistrikId= $outliningassessment->getField("DISTRIK_ID");
		$reqBlokId= $outliningassessment->getField("BLOK_UNIT_ID_INFO");
		$reqUnitMesinId= $outliningassessment->getField("UNIT_MESIN_ID");

		if(!empty($reqDistrikId))
		{
			$statement .=" AND C.DISTRIK_ID = ".$reqDistrikId;
		}

		if(!empty($reqBlokId))
		{
			// $statement .=" AND C.BLOK_UNIT_ID = ".$reqBlokId;
			 $statement .=" AND C.BLOK_UNIT_ID IN (".$reqBlokId.")";
		}

		if(!empty($reqUnitMesinId))
		{
			$statement .=" AND C.UNIT_MESIN_ID = ".$reqUnitMesinId;
		}

		$statement .=" AND NOT  EXISTS 
		(
			SELECT 1
			FROM OUTLINING_ASSESSMENT_DETIL X
			WHERE X.ITEM_ASSESSMENT_DUPLIKAT_ID = A1.ITEM_ASSESSMENT_DUPLIKAT_ID
			AND X.AREA_UNIT_ID = C.AREA_UNIT_ID AND X.AREA_UNIT_DETIL_ID = B.AREA_UNIT_DETIL_ID
			AND X.OUTLINING_ASSESSMENT_ID = ".$reqId."

		) ";

		$sOrder = " ORDER BY A.KODE || GENERATEZERO(A1.KODE,2) ASC";
		
		$rowCount = $formuji->getCountduplikat($arrStatement, $statement.$statement_privacy);
		$formuji->selectduplikatfilter($arrStatement, $rows, $offset, $statement.$statement_privacy, " ORDER BY A.NAMA  ASC ");
		// echo $formuji->query;exit;
		$i = 0;
		$items = array();
		while($formuji->nextRow())
		{
			// print_r($check);exit;
			$this->TREETABLE_COUNT++;
			
			$row['id']				= $formuji->getField("LIST_AREA_ID")."_". $formuji->getField("ITEM_ASSESSMENT_DUPLIKAT_ID");
			$row['text']			= $formuji->getField("KODE_INFO") ." - ". $formuji->getField("NAMA");
			$row['LIST_AREA_ID']	= $formuji->getField("LIST_AREA_ID");
			$row['NAMA']			= $formuji->getField("KODE_INFO") ." - ". $formuji->getField("NAMA");
			$row['KODE_DUPLIKAT']			= $formuji->getField("KODE_DUPLIKAT") ;
			$row['AREA_UNIT']			= $formuji->getField("AREA_UNIT") ;
			$row['AREA_UNIT_ID']			= $formuji->getField("AREA_UNIT_ID") ;
			$row['AREA_UNIT_DETIL_ID']			= $formuji->getField("AREA_UNIT_DETIL_ID") ;
			$row['ITEM_ASSESSMENT_DUPLIKAT_ID']			= $formuji->getField("ITEM_ASSESSMENT_DUPLIKAT_ID") ;
		
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