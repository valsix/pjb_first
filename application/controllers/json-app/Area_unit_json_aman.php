<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class area_unit_json extends CI_Controller
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
		$this->load->model("base-app/AreaUnit");

		$set= new AreaUnit();

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
		$reqDistrikId= $this->input->get("reqDistrikId");
		$reqStatus= $this->input->get("reqStatus");
		$reqArea= $this->input->get("reqArea");
		$reqPerusahaanId= $this->input->get("reqPerusahaanId");
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

		$statement="";

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
		if(!empty($reqDistrikId))
		{
			$statement .= " AND A.DISTRIK_ID ='".$reqDistrikId."'";
		}
		if(!empty($reqArea))
		{
			$statement .= " AND A.LIST_AREA_ID ='".$reqArea."'";
		}
		if(!empty($reqPerusahaanId))
		{
			$statement .= " AND E.PERUSAHAAN_EKSTERNAL_ID ='".$reqPerusahaanId."'";
		}

		$sOrder = " ORDER BY A.DISTRIK_ID ASC ";
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

	function add()
	{
		$this->load->model("base-app/AreaUnit");

		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		$reqNama= $this->input->post("reqNama");
		$reqKode= $this->input->post("reqKode");
		$reqDistrikId= $this->input->post("reqDistrikId");
		$reqListAreaId= $this->input->post("reqListAreaId");
		$reqTersedia= $this->input->post("reqTersedia");
		$reqStatusKonfirmasi= $this->input->post("reqStatusKonfirmasi");
		$reqNamaUnit= $this->input->post("reqNamaUnit");
		$reqListAreaIdDetil= $this->input->post("reqListAreaIdDetil");
		$iddetil= $this->input->post("iddetil");
		$reqStatusConfirm= $this->input->post("reqStatusConfirm");
		// $reqStatusKonfirmasi= $this->input->post("reqStatusKonfirmasi");\

		// print_r($reqNamaUnit);exit;

		$reqBlokId= $this->input->post("reqBlokId");
		$reqUnitMesinId= $this->input->post("reqUnitMesinId");
		$reqAreaKode= $this->input->post("reqAreaKode");

		if (empty($reqListAreaId))
		{
			echo "xxx***Kolom area harus dipilih";exit;
		}

		$set = new AreaUnit();
		$set->setField("AREA_UNIT_ID", $reqId);
		$set->setField("DISTRIK_ID", ValToNullDB($reqDistrikId));
		// $set->setField("LIST_AREA_ID", ValToNullDB($reqListAreaId));
		$set->setField("TERSEDIA", ValToNullDB($reqTersedia));
		$set->setField("STATUS_KONFIRMASI", ValToNullDB($reqStatusKonfirmasi));
		$set->setField("BLOK_UNIT_ID", ValToNullDB($reqBlokId));
		$set->setField("UNIT_MESIN_ID", ValToNullDB($reqUnitMesinId));
		$set->setField("NAMA", $reqNama);
		$set->setField("KODE", $reqKode);
		$set->setField("KODE_DUPLIKAT", $reqAreaKode);

		
		// if ( preg_match('/\s/',$reqKode) )
		// {
		// 	echo "xxx***Kolom kode tidak boleh terdapat spasi";exit;
		// }

		$reqSimpan= "";
		if ($reqMode == "insert")
		{
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			$set->setField("LAST_CREATE_DATE", 'NOW()');

			// $statement=" AND A.KODE =  '".$reqKode."' ";
			// $check = new AreaUnit();
			// $check->selectByParams(array(), -1, -1, $statement);
			// // echo $check->query;exit;
			// $check->firstRow();
			// $checkKode= $check->getField("KODE");

			// if(!empty($checkKode))
			// {
			// 	echo "xxx***Kode  ".$checkKode." sudah ada";exit;	
			// }

			if($set->insert())
			{
				$reqId=$set->id;
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

		unset($set);

		if($reqSimpan == 1 )
		{
			if (!empty($reqListAreaId))
			{
				$reqSimpan="";
				$set = new AreaUnit();
				$set->setField("AREA_UNIT_ID", $reqId);
				$set->deleteareaall();
				unset($set);
				
				foreach ($reqListAreaId as $key => $value) {
					$set = new AreaUnit();
					$set->setField("AREA_UNIT_ID", $reqId);
					$set->setField("LIST_AREA_ID", $value);
					if($set->insertarea())
					{
						$reqSimpan= 1;
					}
				}
			}

			if (!empty($reqNamaUnit))
			{
				$reqSimpan="";
				$set = new AreaUnit();
				$set->setField("AREA_UNIT_ID", $reqId);
				$set->deletedetilall();
				unset($set);

				foreach ($reqNamaUnit as $key => $value) {
					$set = new AreaUnit();
					$set->setField("AREA_UNIT_ID", $reqId);
					$set->setField("LIST_AREA_ID", $reqListAreaIdDetil[$key]);
					$set->setField("STATUS_KONFIRMASI", $reqStatusConfirm[$key]);
					$set->setField("ITEM_ASSESSMENT_DUPLIKAT_ID", $iddetil[$key]);
					$set->setField("NAMA", $value);
					if($set->insertdetil())
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

	function delete()
	{
		$this->load->model("base-app/AreaUnit");
		$set = new AreaUnit();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');

		$set->setField("AREA_UNIT_ID", $reqId);

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


	function deletedetil()
	{
		$this->load->model("base-app/AreaUnit");
		$set = new AreaUnit();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');
		$reqListAreaId =  $this->input->get('reqListAreaId');

		$set->setField("AREA_UNIT_ID", $reqId);
		$set->setField("LIST_AREA_ID", $reqListAreaId);
		if($set->deleteareasingle())
		{
			if($set->deletedetilsingle())
			{
				$arrJson["PESAN"] = "Data berhasil dihapus.";
			}
			else
			{
				$arrJson["PESAN"] = "Data gagal dihapus.";	
			}
			
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}


	function update_status()
	{
		$this->load->model("base-app/AreaUnit");
		$set = new AreaUnit();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');

		$reqStatus =  $this->input->get('reqStatus');

		$set->setField("AREA_UNIT_ID", $reqId);
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


	function filter_distrik()
	{

		$this->load->model("base-app/Distrik");

		$reqPerusahaanId =  $this->input->get('reqPerusahaanId');

		$set= new Distrik();
		$arrset= [];
		$statement=" ";

		if(!empty($reqPerusahaanId))
		{
			$statement .=" AND A.PERUSAHAAN_EKSTERNAL_ID = ".$reqPerusahaanId;
		}

		// print_r($reqPerusahaanId);exit;
		
		$set->selectByParams(array(), -1,-1,$statement);
		// echo $set->query;exit;
		while($set->nextRow())
		{
		    $arrdata= array();
		    $arrdata["id"]= $set->getField("DISTRIK_ID");
		    $arrdata["text"]= $set->getField("NAMA");
		    array_push($arrset, $arrdata);
		}
		unset($set);

		echo json_encode( $arrset, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	

		// echo $arrarea;

	}


	function filter_blok()
	{
		$this->load->model("base-app/BlokUnit");

		$reqDistrikId =  $this->input->get('reqDistrikId');

		$set= new BlokUnit();
		$arrarea= [];
		$statement=" AND 1=2 ";

		if(!empty($reqDistrikId))
		{
			$statement =" AND B.DISTRIK_ID = ".$reqDistrikId;
		}

		// print_r($reqDistrikId);exit;
		
		$set->selectByParams(array(), -1,-1,$statement);
		// echo $set->query;exit;
		while($set->nextRow())
		{
		    $arrdata= array();
		    $arrdata["id"]= $set->getField("BLOK_UNIT_ID");
		    $arrdata["text"]= $set->getField("NAMA");
		    array_push($arrarea, $arrdata);
		}
		unset($set);

		echo json_encode( $arrarea, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	

		// echo $arrarea;

	}

	function filter_unit()
	{
		$this->load->model("base-app/UnitMesin");

		$reqBlokId =  $this->input->get('reqBlokId');

		$set= new UnitMesin();
		$arrarea= [];
		$statement=" AND 1=2 ";

		if(!empty($reqBlokId))
		{
			$statement =" AND C.BLOK_UNIT_ID = ".$reqBlokId;
		}

		// print_r($reqDistrikId);exit;
		
		$set->selectByParams(array(), -1,-1,$statement);
		// echo $set->query;exit;
		while($set->nextRow())
		{
		    $arrdata= array();
		    $arrdata["id"]= $set->getField("UNIT_MESIN_ID");
		    $arrdata["text"]= $set->getField("NAMA");
		    array_push($arrarea, $arrdata);
		}
		unset($set);

		echo json_encode( $arrarea, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	

		// echo $arrarea;

	}

}