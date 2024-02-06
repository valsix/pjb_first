<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class tes_json extends CI_Controller
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


	function tree()
	{
		$this->load->model("base-app/Tes");

		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;//
		$id = isset($_POST['id']) ? $_POST['id'] : 0;//
		$result = array();
		
		$reqId= $this->input->get('reqId');
		
		$statementunit= "";

		$statement=  "";
		if ($id == "0")
		{
			$sorder= "";
			$statement= " ";
			$set= new Tes();
			$result["total"] = 0;
			$set->selectByParams(array(), -1, -1, $statement.$statementunit, $sorder);
			// echo $set->query;exit;
			$i=0;
			while($set->nextRow())
			{
				$valinfoid= $set->getField("PERUSAHAAN_EKSTERNAL_ID");
				$items[$i]['ID'] = $valinfoid;
				$items[$i]['NAMA'] = $set->getField("NAMA");
				// $items[$i]['LINK_URL_INFO'] = $set->getField("LINK_URL_INFO");
				$items[$i]['state'] = $this->hasunitchild($valinfoid) ? 'closed' : 'open';
				$i++;
			}
			$result["rows"] = $items;
		} 
		else 
		{
			$checkid = substr_count($id, "0");

			if($checkid==0)
			{
				$statement= " AND A.PERUSAHAAN_EKSTERNAL_ID = '".$id."'";
				$sOrder=" ";
				$set= new Tes();
				$set->selectByParamsDirektorat(array(), -1, -1, $statement, $sOrder);
				// echo $set->query;exit;
				$i=0;
				while($set->nextRow())
				{
					$valinfoid= $set->getField("DIR_ID");
					$result[$i]['ID'] = $valinfoid;
					$result[$i]['NAMA'] = $set->getField("NAMA");
					$result[$i]['state'] = $this->hasunitchildwilayah($valinfoid) ? 'closed' : 'open';
					$i++;
				}
			}
			else if($checkid==1)
			{
				$statement= " AND LPAD(wilayah_id::text, 2, '0') = '".$id."'";

				$sOrder=" ";
				$set= new Tes();
				$set->selectByParamsWilayah(array(), -1, -1, $statement, $sOrder);
				// echo $set->query;exit;
				$i=0;
				while($set->nextRow())
				{
					$valinfoid= $set->getField("WIL_ID");
					$result[$i]['ID'] = $valinfoid;
					$result[$i]['NAMA'] = $set->getField("NAMA");
					$result[$i]['state'] = $this->hasunitchilddistrik($valinfoid) ? 'closed' : 'open';
					$i++;
				}
			}
			else if($checkid==2)
			{
				$statement= " AND LPAD(distrik_id::text, 3, '0') = '".$id."'";

				$sOrder=" ";
				$set= new Tes();
				$set->selectByParamsDistrik(array(), -1, -1, $statement, $sOrder);
				// echo $set->query;exit;
				$i=0;
				while($set->nextRow())
				{
					$valinfoid= $set->getField("DIS_ID");
					$result[$i]['ID'] = $valinfoid;
					$result[$i]['NAMA'] = $set->getField("KODE").' - '. $set->getField("KODE_SITE");
					$i++;
				}
			}

		}
		
		echo json_encode($result);
	}

	function hasunitchild($id)
	{
	
		$statement= " AND A.PERUSAHAAN_EKSTERNAL_ID = '".$id."'";
			
		$child = new Tes();
		$child->selectByParamsDirektorat(array(), -1,-1, $statement);
		// echo $child->query;
		$child->firstRow();
		$tempId= $child->getField("DIR_ID");
		// echo $tempId;exit;
		if($tempId == "")
		return false;
		else
		return true;
		unset($child);
	}


	function hasunitchildwilayah($id)
	{
	
		$statement= " AND LPAD(wilayah_id::text, 2, '0') = '".$id."'";
			
		$child = new Tes();
		$child->selectByParamsWilayah(array(), -1,-1, $statement);
		// echo $child->query;exit;
		$child->firstRow();
		$tempId= $child->getField("WIL_ID");
		// echo $tempId;exit;
		if($tempId == "")
		return false;
		else
		return true;
		unset($child);
	}

	function hasunitchilddistrik($id)
	{
	
		$statement= " AND LPAD(distrik_id::text, 3, '0') = '".$id."'";
			
		$child = new Tes();
		$child->selectByParamsDistrik(array(), -1,-1, $statement);
		// echo $child->query;exit;
		$child->firstRow();
		$tempId= $child->getField("DIS_ID");
		// echo $tempId;exit;
		if($tempId == "")
		return false;
		else
		return true;
		unset($child);
	}

}