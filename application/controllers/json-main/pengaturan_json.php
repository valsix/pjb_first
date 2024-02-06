<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class pengaturan_json extends CI_Controller {

	function __construct() {
		parent::__construct();
		//kauth
		if($this->session->userdata("appuserid") == "")
		{
			redirect('applogin');
		}
		
		$this->appuserid= $this->session->userdata("appuserid");
		$this->appusernama= $this->session->userdata("appusernama");
		$this->appusergroupid= $this->session->userdata("appusergroupid");
	}

	function jsonformula()
	{
		$this->load->model("base/Pengaturan");

		$set= new Pengaturan();

		if ( isset( $_REQUEST['columnsDef'] ) && is_array( $_REQUEST['columnsDef'] ) ) {
			$columnsDefault = [];
			foreach ( $_REQUEST['columnsDef'] as $field ) {
				$columnsDefault[ $field ] = "true";
			}
		}
		$displaystart= -1;
		$displaylength= -1;

		$arrinfodata= [];

		$statement= "";
		$sOrder = "";
		$set->selectByParamsFormula(array(), $displaylength, $displaystart, $statement, $sOrder);
		// echo $set->query;exit;
		while ($set->nextRow()) 
		{
			$row= [];
			foreach($columnsDefault as $valkey => $valitem) 
			{
				if ($valkey == "SORDERDEFAULT")
					$row[$valkey]= "1";
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
			if(count($columnsDefault) - 2 == $column){}
			else
			{
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
	
	function jsonformuladelete()
	{
		$this->load->model("base-validasi/DiklatStruktural");
		$reqDetilId= $this->input->get("reqDetilId");
		$set= new DiklatStruktural();
		$set->setField('TEMP_VALIDASI_ID', $reqDetilId);
		$set->setField('PEGAWAI_ID', $reqPegawaiId);
		$reqSimpan="";
		if($set->delete())	
		{
			$reqSimpan=1;
		}
		if($reqSimpan == 1 )
		{
			echo json_response(200, 'Data berhasil dihapus');
		}
		else
		{
			echo json_response(400, 'Data gagal dihapus');
		}
				
	}

	function jsonformulaadd()
	{
		$this->load->model("base-validasi/DiklatStruktural");

		$reqMode= $this->input->post("reqMode");
		$reqPegawaiId= $this->input->post('reqPegawaiId');
		$reqRowId= $this->input->post("reqRowId");
		$reqDataId= $this->input->post("reqDataId");
		$reqDiklat= $this->input->post("reqDiklat");
		$reqTempat= $this->input->post("reqTempat");
		$reqPenyelenggara= $this->input->post("reqPenyelenggara");
		$reqAngkatan= $this->input->post("reqAngkatan");
		$reqTahun= $this->input->post("reqTahun");
		$reqNoSTTPP= $this->input->post("reqNoSTTPP");
		$reqTglMulai= $this->input->post("reqTglMulai");
		$reqTglSTTPP= $this->input->post("reqTglSTTPP");
		$reqTglSelesai= $this->input->post("reqTglSelesai");
		$reqJumlahJam= $this->input->post("reqJumlahJam"); 

		$set = new DiklatStruktural();
		$set->setField('TAHUN', ValToNullDB($reqTahun));
		$set->setField('DIKLAT_ID', $reqDiklat);
		$set->setField('NO_STTPP', $reqNoSTTPP);
		$set->setField('TANGGAL_MULAI', dateToDBCheck($reqTglMulai));
		$set->setField('TANGGAL_SELESAI', dateToDBCheck($reqTglSelesai));
		$set->setField('TANGGAL_STTPP', dateToDBCheck($reqTglSTTPP));
		$set->setField('PENYELENGGARA', $reqPenyelenggara);
		$set->setField('ANGKATAN', $reqAngkatan);
		$set->setField('TEMPAT', $reqTempat);
		$set->setField('JUMLAH_JAM', ValToNullDB($reqJumlahJam));
		$set->setField('PEGAWAI_ID', $reqPegawaiId);
		$set->setField('USER_APP_ID', $userLogin->UID);
		
		$reqSimpan= "";
		if($reqMode == "insert")
		{
			$set->setField("LAST_CREATE_USER", $userLogin->idUser);
			$set->setField("LAST_CREATE_DATE", "CURRENT_DATE");	
			$set->setField("LAST_CREATE_SATKER", $userLogin->userSatkerId);
			$set->setField('DIKLAT_STRUKTURAL_ID', ValToNullDB($reqRowId));

			if($set->insert())
			{
				$reqSimpan= 1;
			}
		}
		elseif($reqMode == "update")
		{	
			$set->setField("LAST_UPDATE_USER", $userLogin->idUser);
			$set->setField("LAST_UPDATE_DATE", "CURRENT_DATE");	
			$set->setField("LAST_UPDATE_SATKER", $userLogin->userSatkerId);
			$set->setField('TEMP_VALIDASI_ID', $reqDataId);
			$set->setField('DIKLAT_STRUKTURAL_ID', $reqRowId);
			if($set->update())
			{
				$reqSimpan= 1;
			}
		}

		if($reqSimpan == 1 )
		{
			echo json_response(200, 'Data berhasil disimpan');
		}
		else
		{
			echo json_response(400, 'Data gagal disimpan');
		}
				
	}
}
?>