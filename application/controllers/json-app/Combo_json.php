<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class Combo_json extends CI_Controller
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

		$this->infoemail= $this->config->config["infotitle"];
		// print_r($this->infoemail);exit;
	}

	function combostatusaktif() 
	{
		$i = 0;
		$arr_json[$i]['id']= "";
		$arr_json[$i]['text']= "Aktif";
		$i++;
		$arr_json[$i]['id']= "1";
		$arr_json[$i]['text']= "Inactive";
		$i++;
		echo json_encode($arr_json);
	}


	function comborisiko() 
	{
		$this->load->model('base-app/Risiko');
		$set = new Risiko();

		$arrStatement = array();
		$statement=" AND A.STATUS IS NULL";
		$set->selectByParams($arrStatement,-1,-1, $statement);
		
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id']		= $set->getField("RISIKO_ID");
			$arr_json[$i]['text']	= $set->getField("NAMA") ;
			$i++;
		}
		
		echo json_encode($arr_json);
	}


	function combodampak() 
	{
		$this->load->model('base-app/Dampak');
		$set = new Dampak();

		$arrStatement = array();
		
		$statement=" AND A.STATUS IS NULL";
		$set->selectByParams($arrStatement,-1,-1, $statement);
		
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id']		= $set->getField("DAMPAK_ID");
			$arr_json[$i]['text']	= $set->getField("NAMA")." - ".$set->getField("BOBOT") ;
			$i++;
		}
		
		echo json_encode($arr_json);
	}

	function combokemungkinan() 
	{
		$this->load->model('base-app/Kemungkinan');
		$set = new Kemungkinan();

		$arrStatement = array();
		
		$statement=" AND A.STATUS IS NULL";
		$set->selectByParams($arrStatement,-1,-1, $statement);
		
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id']		= $set->getField("KEMUNGKINAN_ID");
			$arr_json[$i]['text']	= $set->getField("NAMA")." - ".$set->getField("BOBOT") ;
			$i++;
		}
		
		echo json_encode($arr_json);
	}


	function combodistrik() 
	{
		$this->load->model('base-app/Distrik');
		$distrik = new Distrik();

		$arrStatement = array();
		
		$distrik->selectByParams($arrStatement);
		
		$i = 0;
		while($distrik->nextRow())
		{
			$arr_json[$i]['id']		= $distrik->getField("DISTRIK_ID");
			$arr_json[$i]['kode']		= $distrik->getField("KODE");
			$arr_json[$i]['text']	= $distrik->getField("KODE") ;
			$arr_json[$i]['campur']		= $distrik->getField("KODE") .' - '.  $distrik->getField("NAMA");
			$i++;
		}
		
		echo json_encode($arr_json);
	}

	function comborole() 
	{
		$this->load->model('base-app/RoleApproval');
		$distrik = new RoleApproval();

		$arrStatement = array();
		
		$distrik->selectByParams($arrStatement);
		
		$i = 0;
		while($distrik->nextRow())
		{
			$arr_json[$i]['id']		= $distrik->getField("ROLE_ID");
			$arr_json[$i]['text']	= $distrik->getField("ROLE_NAMA")." - ".$distrik->getField("ROLE_DESK") ;
			$i++;
		}
		
		echo json_encode($arr_json);
	}



	function combotipepengukuran() 
	{
		$i = 0;
		$arr_json[$i]['id']= "1";
		$arr_json[$i]['text']= "Analog";
		$i++;
		$arr_json[$i]['id']= "2";
		$arr_json[$i]['text']= "Binary";
		$i++;
		$arr_json[$i]['id']= "3";
		$arr_json[$i]['text']= "Text";
		$i++;
		$arr_json[$i]['id']= "4";
		$arr_json[$i]['text']= "Pict";
		$i++;
		echo json_encode($arr_json);
	}


    function combomenu() 
	{
		$this->load->model('base-app/Crud');
		$set = new Crud();

		$arrStatement = array();
		
		$set->selectByParamsMenus($arrStatement);

		// echo $set->query;exit;
		
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id']		= $set->getField("KODE_MODUL");
			$arr_json[$i]['text']	= $set->getField("MENU_MODUL") ;
			$i++;
		}
		
		echo json_encode($arr_json);
	}

	function combomenuapproval() 
	{
		$this->load->model('base-app/Crud');
		$set = new Crud();

		$arrStatement = array();
		
		$set->selectByParamsMenus($arrStatement,-1,-1," AND KODE_MODUL = '1001' OR  KODE_MODUL = '1002'   OR KODE_MODUL = '1006' ");

		// echo $set->query;exit;
		
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id']		= $set->getField("KODE_MODUL");
			$arr_json[$i]['text']	= $set->getField("MENU_MODUL") ;
			$i++;
		}
		
		echo json_encode($arr_json);
	}


	function combounit() 
	{
		$this->load->model('base-app/Unit');
		$distrik = new Unit();

		$arrStatement = array();
		
		$distrik->selectByParams($arrStatement);
		
		$i = 0;
		while($distrik->nextRow())
		{
			$arr_json[$i]['id']		= $distrik->getField("UNIT_ID");
			$arr_json[$i]['text']	= $distrik->getField("NAMA") ;
			$i++;
		}
		
		echo json_encode($arr_json);
	}

	function combouser() 
	{
		$this->load->model('base-app/Pengguna');
		$set = new Pengguna();

		$arrStatement = array();
		$statement=" AND B.STATUS <> '1'";
		
		$set->selectByParamsCombo(array(),-1,-1,$statement);
		// echo $set->query;exit;
		
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id']		= $set->getField("PENGGUNA_ID");
			$arr_json[$i]['text']	= $set->getField("NAMA") ;
			$i++;
		}
		
		echo json_encode($arr_json);
	}



	function combouserpemeriksa() 
	{
		$this->load->model('base-app/Pengguna');
		$set = new Pengguna();

		$arrStatement = array();
		$statement=" AND B.STATUS = '1'";
		
		$set->selectByParamsCombo(array(),-1,-1,$statement);
		// echo $set->query;exit;
		
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id']		= $set->getField("PENGGUNA_ID");
			$arr_json[$i]['text']	= $set->getField("NAMA") ;
			$i++;
		}
		
		echo json_encode($arr_json);
	}





	function comboperusahaan() 
	{
		$this->load->model('base-app/PerusahaanEksternal');
		$set = new PerusahaanEksternal();

		$arrStatement = array();
		
		$set->selectByParams($arrStatement);
		
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id']		= $set->getField("PERUSAHAAN_EKSTERNAL_ID");
			$arr_json[$i]['text']	= $set->getField("KODE")." - ".$set->getField("NAMA") ;
			$i++;
		}
		
		echo json_encode($arr_json);
	}

	function combojabatan() 
	{
		$this->load->model('base-app/Jabatan');
		$set = new Jabatan();

		$arrStatement = array();
		
		$set->selectByParams($arrStatement);
		
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id']		= $set->getField("JABATAN_ID");
			$arr_json[$i]['text']	= $set->getField("KODE")." - ".$set->getField("NAMA") ;
			$i++;
		}
		
		echo json_encode($arr_json);
	}

	function comboroleappr() 
	{
		$this->load->model('base-app/RoleApproval');
		$set = new RoleApproval();

		$arrStatement = array();
		
		$set->selectByParams($arrStatement);
		$arr_json[0]['id']		= '';
		$arr_json[0]['text']	= 'Pilih Role Approval';
		$i = 1;
		while($set->nextRow())
		{
			$arr_json[$i]['id']		= $set->getField("ROLE_ID");
			$arr_json[$i]['text']	= $set->getField("ROLE_NAMA");
			$i++;
		}
		
		echo json_encode($arr_json);
	}

	function combomasterjabatan() 
	{
		$this->load->model('base-app/MasterJabatan');
		$set = new MasterJabatan();

		$arrStatement = array();
		
		$set->selectByParams($arrStatement);
		
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id']		= $set->getField("POSITION_ID");
			$arr_json[$i]['text']	= $set->getField("NAMA_POSISI") ;
			$i++;
		}
		
		echo json_encode($arr_json);
	}

	function combotipeformuji() 
	{
		$this->load->model('base-app/FormUjiTipe');
		$set = new FormUjiTipe();

		$arrStatement = array();
		
		$set->selectByParams($arrStatement);
		
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id']		= $set->getField("FORM_UJI_TIPE_ID");
			$arr_json[$i]['text']	= $set->getField("NAMA") ;
			$i++;
		}
		
		echo json_encode($arr_json);
	}


	function combokelompokeq() 
	{
		$this->load->model('base-app/KelompokEquipment');
		$distrik = new KelompokEquipment();

		$reqKelompokEquipmentId = $this->input->get("reqKelompokEquipmentId");
		

		$arrStatement = array();

		$statement="";

		if($reqKelompokEquipmentId)
		{
			$statement = " AND A.KELOMPOK_EQUIPMENT_ID IN (".$reqKelompokEquipmentId.")";
		}
		
		$distrik->selectByParams($arrStatement,-1,-1,$statement);

		// echo $distrik->query;exit; 
		
		$i = 0;
		while($distrik->nextRow())
		{
			$arr_json[$i]['id']		= $distrik->getField("KELOMPOK_EQUIPMENT_ID");
			$arr_json[$i]['text']	= $distrik->getField("NAMA") ;
			$i++;
		}
		
		echo json_encode($arr_json);
	}


	function autocompletedistrik()
	{
		$this->load->model("base-app/Distrik");

		$set= new Distrik();

		$q= $this->input->get('q');
		$page= $this->input->get('page');

		$search_term= !empty($q) ? $q : "";

		$limit= 30;
		if(empty($page))
		{
			$from= 0;
		}
		else
		{
			$from= 30*$page;
		}

		$jumlahdata= 0;
		$arrdetildata= [];
		$sorder= "ORDER BY A.NAMA";
		$statement.= " AND UPPER(A.NAMA) LIKE '%".strtoupper($search_term)."%' ";
		$jumlahdata= $set->getCountByParams();
		$set->selectByParams(array(), $limit, $from, $statement, $sorder);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= [];
			$arrdata["id"]= $set->getField("DISTRIK_ID");
			$arrdata["text"]= $set->getField("NAMA");
			$arrdata["description"]= $set->getField("NAMA");
			array_push($arrdetildata, $arrdata);
		}

		$result = [
		    'total_count' => $jumlahdata,
		    'items' => $arrdetildata,
		];

		header('Content-Type: application/json');
		echo json_encode( $result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function autocompleteunit()
	{
		$this->load->model("base-app/Unit");

		$set= new Unit();

		$q= $this->input->get('q');
		$page= $this->input->get('page');

		$search_term= !empty($q) ? $q : "";

		$limit= 30;
		if(empty($page))
		{
			$from= 0;
		}
		else
		{
			$from= 30*$page;
		}

		$jumlahdata= 0;
		$arrdetildata= [];
		$sorder= "ORDER BY A.NAMA";
		$statement.= " AND UPPER(A.NAMA) LIKE '%".strtoupper($search_term)."%' ";
		$jumlahdata= $set->getCountByParams();
		$set->selectByParams(array(), $limit, $from, $statement, $sorder);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= [];
			$arrdata["id"]= $set->getField("UNIT_ID");
			$arrdata["text"]= $set->getField("NAMA");
			$arrdata["description"]= $set->getField("NAMA");
			array_push($arrdetildata, $arrdata);
		}

		$result = [
		    'total_count' => $jumlahdata,
		    'items' => $arrdetildata,
		];

		header('Content-Type: application/json');
		echo json_encode( $result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function autocompletetabletemplate()
	{
		$this->load->model("base-app/TabelTemplate");

		$set= new TabelTemplate();

		$q= $this->input->get('q');
		$page= $this->input->get('page');

		$search_term= !empty($q) ? $q : "";

		$limit= 30;
		if(empty($page))
		{
			$from= 0;
		}
		else
		{
			$from= 30*$page;
		}

		$jumlahdata= 0;
		$arrdetildata= [];
		$sorder= "ORDER BY A.NAMA";
		$statement.= " AND UPPER(A.NAMA) LIKE '%".strtoupper($search_term)."%' ";
		$jumlahdata= $set->getCountByParams();
		$set->selectByParams(array(), $limit, $from, $statement, $sorder);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= [];
			$arrdata["id"]= $set->getField("TABEL_TEMPLATE_ID");
			$arrdata["text"]= $set->getField("NAMA");
			$arrdata["description"]= $set->getField("NAMA");
			array_push($arrdetildata, $arrdata);
		}

		$result = [
		    'total_count' => $jumlahdata,
		    'items' => $arrdetildata,
		];

		header('Content-Type: application/json');
		echo json_encode( $result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}


	function combodirektoratwilayah() 
	{
		$this->load->model('base-app/Direktorat');
		$set = new Direktorat();

		$reqWilayahId= $this->input->get('reqWilayahId');

		if(empty($reqWilayahId))
		{
			exit;
		}

		$arrStatement = array();
		
		$statement=" AND A.STATUS IS NULL";

		if(!empty($reqWilayahId))
		{
			$statement.=" AND B.WILAYAH_ID =".$reqWilayahId."";
		}
		
		$set->selectByParamsCombo($arrStatement,-1,-1, $statement);

		// echo $set->query;exit; 
		
		$i = 0;
		$arr_json[$i]['id']= "";
		$arr_json[$i]['text']= "";
		$i = 1;
		while($set->nextRow())
		{
			$arr_json[$i]['id']		= $set->getField("DIREKTORAT_ID");
			$arr_json[$i]['text']	= $set->getField("NAMA");
			$i++;
		}
		
		echo json_encode($arr_json);
	}

	function comboarea() 
	{
		$this->load->model('base-app/Area');
		$set = new Area();

		$reqWilayahId= $this->input->get('reqWilayahId');
		$arrStatement = array();
		
		$statement=" AND A.STATUS IS NULL";

		
		$set->selectByParams($arrStatement,-1,-1, $statement);

		// echo $set->query;exit; 
		
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id']		= $set->getField("AREA_ID");
			$arr_json[$i]['text']	= $set->getField("NAMA");
			$i++;
		}
		
		echo json_encode($arr_json);
	}


	function autocompletecomboarea()
	{
		$this->load->model("base-app/Area");

		$set= new Area();

		$q= $this->input->get('q');
		$page= $this->input->get('page');

		$search_term= !empty($q) ? $q : "";

		$limit= 30;
		if(empty($page))
		{
			$from= 0;
		}
		else
		{
			$from= 30*$page;
		}

		$jumlahdata= 0;
		$arrdetildata= [];
		$sorder= "ORDER BY A.NAMA";
		$statement.= " AND UPPER(A.NAMA) LIKE '%".strtoupper($search_term)."%' ";
		$jumlahdata= $set->getCountByParams();
		$set->selectByParams(array(), $limit, $from, $statement, $sorder);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= [];
			$arrdata["id"]= $set->getField("AREA_ID");
			$arrdata["text"]= $set->getField("NAMA");
			$arrdata["description"]= $set->getField("NAMA");
			array_push($arrdetildata, $arrdata);
		}

		$result = [
		    'total_count' => $jumlahdata,
		    'items' => $arrdetildata,
		];

		header('Content-Type: application/json');
		echo json_encode( $result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}


}