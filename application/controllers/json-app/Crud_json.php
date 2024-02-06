<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class Crud_json extends CI_Controller
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
		$this->load->model("base-app/Crud");

		$set= new Crud();

		$reqJenisNaskahId= $this->input->get("reqJenisNaskahId");

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
				UPPER(A.NAMA_HAK) LIKE '%".strtoupper($reqPencarian)."%'
				OR UPPER(A.KODE_HAK) LIKE '%".strtoupper($reqPencarian)."%'
				OR UPPER(A.DESKRIPSI) LIKE '%".strtoupper($reqPencarian)."%'
			)";
		}

		$sOrder = " ORDER BY PENGGUNA_HAK_ID ASC ";
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
					$row[$valkey]= $set->getField("TANGGAL_DISPOSISI");
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
		$this->load->model("base-app/Crud");

		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		$reqKodeHak= $this->input->post("reqKodeHak");
		$reqNamaHak= $this->input->post("reqNamaHak");
		$reqDeskripsi= $this->input->post("reqDeskripsi");
		$reqPositionId= $this->input->post("reqPositionId");

		$set = new Crud();
		$set->setField("KODE_HAK", strtoupper($reqKodeHak));
		$set->setField("NAMA_HAK", $reqNamaHak);
		$set->setField("DESKRIPSI", $reqDeskripsi);
		$set->setField("PENGGUNA_HAK_ID", $reqId);

		$reqSimpan= "";
		if ($reqMode == "insert")
		{
			$set->setField("LAST_CREATE_USER", $this->adminusernama);
			$set->setField("LAST_CREATE_DATE", 'SYSDATE');
			if($set->insert())
			{
				$reqSimpan= 1;
				$reqId= $set->id;
			}
		}
		else
		{	
			$set->setField("LAST_UPDATE_USER", $this->adminusernama);
			$set->setField("LAST_UPDATE_DATE", 'SYSDATE');
			if($set->update())
			{
				$reqSimpan= 1;
			}
		}

		if ($reqSimpan=="1") 
		{
			$list_modul= $this->input->post("modul");
			// print_r($list_modul);exit;

			$create= $this->input->post("create");
			$create_anak= $this->input->post("create_anak");
			$read= $this->input->post("read");
			$read_anak= $this->input->post("read_anak");
			$update= $this->input->post("update");
			$update_anak= $this->input->post("update_anak");
			$delete= $this->input->post("delete");
			$delete_anak= $this->input->post("delete_anak");
			$menu= $this->input->post("menu");

			if ($list_modul!='') 
			{
				$set = new Crud();
				$set->setField("KODE_HAK", strtoupper($reqKodeHak));
				$set->deletePenggunaCrud();

				foreach($list_modul as $key=>$value)
				{	
					$set = new Crud();
					$set->setField("pengguna_hak_id", $reqId);
					$set->setField("kode_hak", strtoupper($reqKodeHak));
					$set->setField("kode_modul", $value);
					$set->setField("menu", (isset($menu[$key]))?1:0);
					$set->setField("modul_c", (isset($create[$key]))?1:0);
					$set->setField("modul_anak_c", (isset($create_anak[$key]))?1:0);
					$set->setField("modul_r", (isset($read[$key]))?1:0);
					$set->setField("modul_anak_r", (isset($read_anak[$key]))?1:0);
					$set->setField("modul_u", (isset($update[$key]))?1:0);
					$set->setField("modul_anak_u", (isset($update_anak[$key]))?1:0);
					$set->setField("modul_d", (isset($delete[$key]))?1:0);
					$set->setField("modul_anak_d", (isset($delete_anak[$key]))?1:0);

					if($set->insertPenggunaCrud()) {}
				}
			}

			if(!empty($reqPositionId))
			{
				$set = new Crud();
				$set->setField("PENGGUNA_HAK_ID", $reqId);
				$set->deletejabatan();
				unset($set);
				foreach ($reqPositionId as $key => $value) 
				{
					$set = new Crud();
					$set->setField("PENGGUNA_HAK_ID", $reqId);
					$set->setField("POSITION_ID", $value);
					if($set->insertjabatan()) 
					{
						$penggunainternal = new Crud();
						$statement =" AND POSITION_ID='".$value."'";
						$penggunainternal->selectByParamsInternal(array(), -1, -1, $statement);
						while($penggunainternal->nextRow())
						{

							$inserthak = new Crud();
							$inserthak->setField("PENGGUNA_HAK_ID", $reqId);
							$inserthak->setField("POSITION_ID", $value);
							$inserthak->setField("PENGGUNA_ID", $penggunainternal->getField("PENGGUNA_ID"));
							$checkhak = new Crud();
							$statement =" AND PENGGUNA_ID='".$penggunainternal->getField("PENGGUNA_ID")."' AND PENGGUNA_HAK_ID='".$reqId."'";
							$checkhak->selectByParamsHakAkses(array(), -1, -1, $statement);
							$checkhak->firstRow();
							$reqPenggunaId= $checkhak->getField("PENGGUNA_ID");
							if(empty($reqPenggunaId))
							{
								if($inserthak->inserthakakses()) 
								{
								}
							}
							
						}
						
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
		$this->load->model("base-app/Crud");
		$set = new Crud();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');

		$set->setField("PENGGUNA_HAK_ID", $reqId);

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
		$this->load->model("base-app/Crud");
		$set = new Crud();
		
		$reqId =  $this->input->get('reqId');
		$reqDetilId =  $this->input->get('reqDetilId');
		$reqPositionId =  $this->input->get('reqPositionId');

		$set->setField("PENGGUNA_HAK_JABATAN_ID", $reqDetilId);
		$set->setField("PENGGUNA_HAK_ID", $reqId);

		if($set->deletejabatandetil())
		{

			$penggunainternal = new Crud();
			$statement =" AND POSITION_ID='".$reqPositionId."'";
			$penggunainternal->selectByParamsInternal(array(), -1, -1, $statement);
			while($penggunainternal->nextRow())
			{
				$checkhak = new Crud();
				$statement =" AND PENGGUNA_ID='".$penggunainternal->getField("PENGGUNA_ID")."' AND PENGGUNA_HAK_ID='".$reqId."'";
				$checkhak->selectByParamsHakAkses(array(), -1, -1, $statement);
				$checkhak->firstRow();
				$reqPenggunaId= $checkhak->getField("PENGGUNA_ID");	
				if(!empty($reqPenggunaId))
				{
					$setdelete = new Crud();
					$setdelete->setField("PENGGUNA_HAK_ID", $reqId);
					$setdelete->setField("PENGGUNA_ID", $reqPenggunaId);

					if($setdelete->deletePenggunaHakAkses())
					{
					}			

				}

			}

			$arrJson["PESAN"] = "Data berhasil dihapus.";
		}
		else
		{
			$arrJson["PESAN"] = "Data gagal dihapus.";	
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

}