<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class Jabatan_json extends CI_Controller
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

	function add()
	{
		$this->load->model("base-app/MasterJabatan");

		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		$reqDistrikKode= $this->input->post("reqDistrikKode");
		$reqNama= $this->input->post("reqNama");
		$reqKode= $this->input->post("reqKode");
		$reqKategori= $this->input->post("reqKategori");
		$reqJenjang= $this->input->post("reqJenjang");
		$reqTipeUnit= $this->input->post("reqTipeUnit");
		$reqDitBid= $this->input->post("reqDitBid");
		$reqSuperiorId= $this->input->post("reqSuperiorId");

		$set = new MasterJabatan();
		$set->setField("NAMA_POSISI", $reqNama);
		$set->setField("POSITION_ID", $reqKode);
		$set->setField("KATEGORI", $reqKategori);
		$set->setField("JENJANG_JABATAN", $reqJenjang);
		// $set->setField("POSITION_ID", $reqId);
		$set->setField("UNIT", $reqTipeUnit);
		$set->setField("DITBID", $reqDitBid);
		$set->setField("KODE_DISTRIK", $reqDistrikKode);
		$set->setField("SUPERIOR_ID", $reqSuperiorId);

		$reqSimpan= "";
		if ($reqMode == "insert")
		{
			$set->setField("LAST_CREATE_USER", $this->adminusernama);
			$set->setField("LAST_CREATE_DATE", 'SYSDATE');
			if($set->insert())
			{
				$reqSimpan= 1;
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
		$this->load->model("base-app/MasterJabatan");
		$set = new MasterJabatan();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');

		$set->setField("POSITION_ID", $reqId);

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

	function change_status()
	{
		$this->load->model("base-app/MasterJabatan");
		$set = new MasterJabatan();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');
		$reqStatus =  $this->input->get('reqStatus');

		$statement= " AND A.SUPERIOR_ID ='".$reqId."'";
				
		$check= new MasterJabatan();
		$check->selectByParams(array(), -1, -1, $statement, '');
		// echo $check->query;exit;
		$check->firstRow();
		$tempId= $check->getField("POSITION_ID");


		if($reqStatus==1)
		{
			$aktif="dinonaktikan.";
		}
		else
		{
			$aktif="diaktikan.";
		}
		$reqSimpan="";
		if(!empty($tempId))
		{
			$set->setField("SUPERIOR_ID", $reqId);
			$set->setField("POSITION_ID", $reqId);
			$set->setField("STATUS",$reqStatus);
			if($set->change_status_parent())
			{
				$reqSimpan=1;
				$pesan="Data berhasil ".$aktif;
			}
			else
			{
				$pesan="Data gagal ".$aktif;
			}
			if($set->change_status())
			{
				$reqSimpan=1;
				$pesan="Data berhasil ".$aktif;
			}
			else
			{
				$pesan="Data gagal ".$aktif;
			}

		}
		else
		{

			$set->setField("POSITION_ID", $reqId);
			$set->setField("STATUS",$reqStatus);
			if($set->change_status())
			{
				$reqSimpan=1;
				$pesan="Data berhasil ".$aktif;
			}
			else
			{
				$pesan="Data gagal ".$aktif;
			}

		}

		
		$arrJson["PESAN"] = $pesan;

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function tree()
	{
		$this->load->model("base-app/MasterJabatan");

		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;//
		$id = isset($_POST['id']) ? $_POST['id'] : 0;//

		// print_r($id);exit;

		$result = array();
		
		$reqId= $this->input->get('reqId');
		$reqSearch= $this->input->get('reqSearch');
		// print_r($reqSearch);exit;
		$reqPeriode= $reqBulan.$reqTahun;
		
		$statementunit= "";

		$statement= $statementperiode= "";

		if(empty($reqSearch))
		{

			if ($id == "0")
			{
				$sorder= "";
				$statement= " AND A.SUPERIOR_ID ='TOP'";
				
				$set= new MasterJabatan();
				$result["total"] = 0;
				$set->selectByParams(array(), -1, -1, $statement.$statementunit, $sorder);
			// echo $set->query;exit;
				$i=0;
				while($set->nextRow())
				{
					$valinfoid= trim($set->getField("POSITION_ID"));
					$items[$i]['ID'] = $valinfoid;
					$items[$i]['NAMA'] = $set->getField("NAMA_POSISI");
					$items[$i]['UNIT'] = $set->getField("UNIT");
					$items[$i]['LINK_URL_INFO'] = $set->getField("LINK_URL_INFO");
					$items[$i]['state'] = $this->hasunitchild($valinfoid) ? 'closed' : 'open';
					$i++;
				}
				$result["rows"] = $items;
			} 
			else 
			{
				$statementperiode= "";
				$statement= " AND TRIM(A.SUPERIOR_ID) = TRIM('".$id."')";
				
				$sOrder=" ORDER BY A.NAMA_POSISI";
				$set= new MasterJabatan();
				$set->selectByParams(array(), -1, -1, $statement, $sOrder);
			// echo $set->query;exit;
				$i=0;
				while($set->nextRow())
				{
					$valinfoid= trim($set->getField("POSITION_ID"));
					$result[$i]['ID'] = $valinfoid;
					$result[$i]['NAMA'] = $set->getField("NAMA_POSISI");
					$result[$i]['UNIT'] = $set->getField("UNIT");
					$result[$i]['LINK_URL_INFO'] = $set->getField("LINK_URL_INFO");
					$result[$i]['state'] = $this->hasunitchild($valinfoid) ? 'closed' : 'open';
					$i++;
				}
			}

		}
		else
		{
			if ($id == "0")
			{
				$sorder= "";
				$statement= " ";
				if(!empty($reqSearch))
				{
					$statement.= " AND lower(A.NAMA_POSISI) like lower('%".$reqSearch."%') or lower(A.unit) like lower('%".$reqSearch."%') ";
				}
				$set= new MasterJabatan();
				$result["total"] = 0;
				$set->selectByParams(array(), -1, -1, $statement.$statementunit, $sorder);
				$i=0;
				while($set->nextRow())
				{
					$valinfoid= trim($set->getField("POSITION_ID"));
					$items[$i]['ID'] = $valinfoid;
					$items[$i]['NAMA'] = $set->getField("NAMA_POSISI");
					$items[$i]['UNIT'] = $set->getField("UNIT");
					$items[$i]['LINK_URL_INFO'] = $set->getField("LINK_URL_INFO");
					$items[$i]['state'] = $this->hasunitchild($valinfoid) ? 'closed' : 'open';
					$i++;
				}
				$result["rows"] = $items;
			}
			else
			{
				$statementperiode= "";
				$statement= " AND TRIM(A.SUPERIOR_ID) = TRIM('".$id."')";
				
				$sOrder=" ORDER BY A.NAMA_POSISI";
				$set= new MasterJabatan();
				$set->selectByParams(array(), -1, -1, $statement, $sOrder);
				// echo $set->query;exit;
				$i=0;
				while($set->nextRow())
				{
					$valinfoid= trim($set->getField("POSITION_ID"));
					$result[$i]['ID'] = $valinfoid;
					$result[$i]['NAMA'] = $set->getField("NAMA_POSISI");
					$result[$i]['UNIT'] = $set->getField("UNIT");
					$result[$i]['LINK_URL_INFO'] = $set->getField("LINK_URL_INFO");
					$result[$i]['state'] = $this->hasunitchild($valinfoid) ? 'closed' : 'open';
					$i++;
				}
			} 

		}
		
		
		echo json_encode($result);
	}

	function tree_multi()
	{
		$this->load->model("base-app/MasterJabatan");

		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;//
		$id = isset($_POST['id']) ? $_POST['id'] : 0;//

		// print_r($id);exit;

		$result = array();
		
		$reqId= $this->input->get('reqId');
		$reqSearch= $this->input->get('reqSearch');
		$reqPositionId= $this->input->get('reqPositionId');
		$reqPositionId = explode(",", $reqPositionId);
		$reqPositionId = "'" . implode("', '", $reqPositionId) ."'";
		// print_r($reqPositionId);exit;
		$reqPeriode= $reqBulan.$reqTahun;
		
		$statementunit= "";

		$statement= $statementperiode= "";

		if(empty($reqSearch))
		{

			if ($id == "0")
			{
				$sorder= "";
				$statement= " AND A.SUPERIOR_ID ='TOP'";

				// if(!empty($reqPositionId))
				// {
				// 	$statement .= " AND A.POSITION_ID NOT IN (".$reqPositionId.")";
				// }
				
				$set= new MasterJabatan();
				$result["total"] = 0;
				$set->selectByParams(array(), -1, -1, $statement.$statementunit, $sorder);
				// echo $set->query;exit;
				$i=0;
				while($set->nextRow())
				{
					$valinfoid= trim($set->getField("POSITION_ID"));
					$items[$i]['ID'] = $valinfoid;
					$items[$i]['NAMA'] = $set->getField("NAMA_POSISI");
					$items[$i]['UNIT'] = $set->getField("UNIT");
					$items[$i]['LINK_URL_INFO'] = $set->getField("LINK_URL_INFO");
					$items[$i]['state'] = $this->hasunitchild($valinfoid) ? 'closed' : 'open';
					$i++;
				}
				$result["rows"] = $items;
			} 
			else 
			{
				$statementperiode= "";
				$statement= " AND TRIM(A.SUPERIOR_ID) = TRIM('".$id."')";
				// if(!empty($reqPositionId))
				// {
				// 	$statement .= " AND A.POSITION_ID NOT IN (".$reqPositionId.")";
				// }
				
				$sOrder=" ORDER BY A.NAMA_POSISI";
				$set= new MasterJabatan();
				$set->selectByParams(array(), -1, -1, $statement, $sOrder);
				// echo $set->query;exit;
				$i=0;
				while($set->nextRow())
				{
					$valinfoid= trim($set->getField("POSITION_ID"));
					$result[$i]['ID'] = $valinfoid;
					$result[$i]['NAMA'] = $set->getField("NAMA_POSISI");
					$result[$i]['UNIT'] = $set->getField("UNIT");
					$result[$i]['LINK_URL_INFO'] = $set->getField("LINK_URL_INFO");
					$result[$i]['state'] = $this->hasunitchild($valinfoid) ? 'closed' : 'open';
					$i++;
				}
			}

		}
		else
		{
			if ($id == "0")
			{
				$sorder= "";
				$statement= " ";
				if(!empty($reqSearch))
				{
					$statement.= " AND lower(A.NAMA_POSISI) like lower('%".$reqSearch."%') or lower(A.unit) like lower('%".$reqSearch."%') ";
				}
				$set= new MasterJabatan();
				$result["total"] = 0;
				$set->selectByParams(array(), -1, -1, $statement.$statementunit, $sorder);
				$i=0;
				while($set->nextRow())
				{
					$valinfoid= trim($set->getField("POSITION_ID"));
					$items[$i]['ID'] = $valinfoid;
					$items[$i]['NAMA'] = $set->getField("NAMA_POSISI");
					$items[$i]['UNIT'] = $set->getField("UNIT");
					$items[$i]['LINK_URL_INFO'] = $set->getField("LINK_URL_INFO");
					$items[$i]['state'] = $this->hasunitchild($valinfoid) ? 'closed' : 'open';
					$i++;
				}
				$result["rows"] = $items;
			}
			else
			{
				$statementperiode= "";
				$statement= " AND TRIM(A.SUPERIOR_ID) = TRIM('".$id."')";
				// if(!empty($reqPositionId))
				// {
				// 	$statement .= " AND A.POSITION_ID NOT IN (".$reqPositionId.")";
				// }
				
				$sOrder=" ORDER BY A.NAMA_POSISI";
				$set= new MasterJabatan();
				$set->selectByParams(array(), -1, -1, $statement, $sOrder);
				// echo $set->query;exit;
				$i=0;
				while($set->nextRow())
				{
					$valinfoid= trim($set->getField("POSITION_ID"));
					$result[$i]['ID'] = $valinfoid;
					$result[$i]['NAMA'] = $set->getField("NAMA_POSISI");
					$result[$i]['UNIT'] = $set->getField("UNIT");
					$result[$i]['LINK_URL_INFO'] = $set->getField("LINK_URL_INFO");
					$result[$i]['state'] = $this->hasunitchild($valinfoid) ? 'closed' : 'open';
					$i++;
				}
			} 

		}
		
		
		echo json_encode($result);
	}

	function hasunitchild($id)
	{
	
		$infosuperiorid= trim($id);

		$statement= " AND TRIM(A.SUPERIOR_ID) = TRIM('".$infosuperiorid."')";
			
		$child = new MasterJabatan();
		$child->selectByParams(array(), -1,-1, $statement);
		// echo $child->query;exit;
		$child->firstRow();
		$tempId= $child->getField("POSITION_ID");
		// echo $tempId;exit;
		if($tempId == "")
		return false;
		else
		return true;
		unset($child);
	}


}