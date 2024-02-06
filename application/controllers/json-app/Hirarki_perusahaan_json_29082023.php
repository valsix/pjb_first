<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class hirarki_perusahaan_json extends CI_Controller
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
		$this->load->model("base-app/HirarkiPerusahaan");

		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;//
		$id = isset($_POST['id']) ? $_POST['id'] : 0;//
		$result = array();
		
		$reqId= $this->input->get('reqId');
		
		$statementunit= "";

		$statement=  "";
		// print_r($id);exit;

		if ($id == "0")
		{
			$sorder= " ORDER BY A.PERUSAHAAN_EKSTERNAL_ID ASC";
			$statement= " AND A.STATUS IS NULL ";
			$set= new HirarkiPerusahaan();
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
				$set= new HirarkiPerusahaan();
				$set->selectByParamsDirektorat(array(), -1, -1, $statement, $sOrder);
				// echo $set->query;exit;
				$i=0;
				while($set->nextRow())
				{
					$valinfoid= $set->getField("DIR_ID");
					$result[$i]['ID'] = $valinfoid;
					$result[$i]['NAMA'] = $set->getField("DIREKTORAT_NAMA");
					$result[$i]['state'] = $this->hasunitchildwilayah($valinfoid) ? 'closed' : 'open';
					$i++;
				}
			}
			else if($checkid==1)
			{
				// print_r($id);exit;
				$perusahaanid=strtok($id, ' - ');
				$direktoratid = substr($id, strrpos($id, '-') + 1);

				$statement= " AND A.DIREKTORAT_ID ='".$direktoratid."' AND A.PERUSAHAAN_EKSTERNAL_ID ='".$perusahaanid."'";

				$sOrder=" ";
				$set= new HirarkiPerusahaan();
				$set->selectByParamsWilayah(array(), -1, -1, $statement, $sOrder);
				// echo $set->query;exit;
				$i=0;
				while($set->nextRow())
				{
					$valinfoid= $set->getField("WIL_ID");
					$result[$i]['ID'] = $valinfoid;
					$result[$i]['NAMA'] = $set->getField("WILAYAH_NAMA");
					$checkidwil= explode(' - ', $valinfoid);
					
					if($checkidwil[0] == 'DIS')
					{
						$result[$i]['state'] = $this->hasunitchildblokunit($valinfoid) ? 'closed' : 'open';
					}
					else
					{
						// print_r($checkidwil[0]);
						$result[$i]['state'] = $this->hasunitchilddistrik($valinfoid) ? 'closed' : 'open';
					}

					$i++;
				}
			}
			else if($checkid==2)
			{
				// print_r($id);exit;
				$id= explode(' - ', $id);
				if($id[0]=='DIS')
				{
					$perusahaanid=$id[1];
					$dirid=$id[2];
					$disid=$id[3];
					// print_r($id);exit;

					$statement= " AND B.PERUSAHAAN_EKSTERNAL_ID ='".$perusahaanid."' AND B.DIREKTORAT_ID ='".$dirid."'  AND B.DISTRIK_ID ='".$disid."'   " ;

					$set = new HirarkiPerusahaan();
					$set->selectByParamsBlokUnitDistrik(array(), -1,-1, $statement);

					$i=0;
					while($set->nextRow())
					{
						$valinfoid= $set->getField("BLOK_UNIT_ID");
						$result[$i]['ID'] = $valinfoid;
						$result[$i]['NAMA'] = $set->getField("NAMA");
						$result[$i]['state'] = $this->hasunitchildunitmesin($valinfoid) ? 'closed' : 'open';
						$i++;
					}
				}
				else
				{
					$perusahaanid=$id[0];
					$dirid=$id[1];
					$wilid=$id[2];
					// print_r($id);exit;
					$statement= " AND C.PERUSAHAAN_EKSTERNAL_ID ='".$perusahaanid."' AND C.DIREKTORAT_ID ='".$dirid."' AND A.WILAYAH_ID ='".$wilid."'";

					$sOrder=" ";
					$set= new HirarkiPerusahaan();
					$set->selectByParamsDistrikWilayah(array(), -1, -1, $statement, $sOrder);

					$i=0;
					while($set->nextRow())
					{
						$valinfoid= $set->getField("DIS_ID");
						$result[$i]['ID'] = $valinfoid;
						$result[$i]['NAMA'] = $set->getField("DISTRIK_NAMA");
						$result[$i]['state'] = $this->hasunitchildblokunit($valinfoid) ? 'closed' : 'open';
						$i++;
					}
				}
				
			}
			else if($checkid==3)
			{

				// print_r($id);exit;
				$id= explode('-', $id);
				$perusahaanid=$id[0];
				$dirid=$id[1];
				$wilid=$id[2];
				$disid=$id[3];
	
				$statement= " AND B.PERUSAHAAN_EKSTERNAL_ID ='".$perusahaanid."' AND B.DIREKTORAT_ID ='".$dirid."' AND B.WILAYAH_ID ='".$wilid."' AND B.DISTRIK_ID ='".$disid."' " ;

				$sOrder=" ";
				$set= new HirarkiPerusahaan();
				$set->selectByParamsBlokUnit(array(), -1, -1, $statement, $sOrder);
				// echo $set->query;exit;
				$i=0;
				while($set->nextRow())
				{
					$valinfoid= 'WIL'.' - '.$set->getField("BLOK_UNIT_ID");
					$result[$i]['ID'] = $valinfoid;
					$result[$i]['NAMA'] = $set->getField("NAMA");
					$result[$i]['state'] = $this->hasunitchildunitmesin($valinfoid) ? 'closed' : 'open';
					$i++;
				}
			}
			else if($checkid==4)
			{
				// print_r($id);exit;
				$id= explode(' - ', $id);

				if($id[0]=='WIL')
				{
					$perusahaanid=$id[1];
					$dirid=$id[2];
					$wilid=$id[3];
					$disid=$id[4];
					$blokid=$id[5];

					$statement= " AND B.PERUSAHAAN_EKSTERNAL_ID ='".$perusahaanid."' AND B.DIREKTORAT_ID ='".$dirid."' AND A.DISTRIK_ID ='".$disid."'  AND D.BLOK_UNIT_ID ='".$blokid."'
					";

					$sOrder=" ";
					$set= new HirarkiPerusahaan();
					$set->selectByParamsUnitMesin(array(), -1, -1, $statement, $sOrder);
					// echo $set->query;exit;
					$i=0;
					while($set->nextRow())
					{
						$valinfoid= 'WIL'.' - '.$set->getField("UNIT_MESIN_ID");
						$result[$i]['ID'] = $valinfoid;
						$result[$i]['NAMA'] = $set->getField("NAMA");
						$result[$i]['state'] = $this->hasunitchildsubunitmesin($valinfoid) ? 'closed' : 'open';
						$i++;
					}
				}
				else
				{

					$perusahaanid=$id[0];
					$dirid=$id[1];
					$disid=$id[2];
					$blokid=$id[3];

					$statement= " AND B.PERUSAHAAN_EKSTERNAL_ID ='".$perusahaanid."' AND B.DIREKTORAT_ID ='".$dirid."' AND A.DISTRIK_ID ='".$disid."'  AND D.BLOK_UNIT_ID ='".$blokid."'
					";

					$sOrder=" ";
					$set= new HirarkiPerusahaan();
					$set->selectByParamsUnitMesin(array(), -1, -1, $statement, $sOrder);
					// echo $set->query;exit;
					$i=0;
					while($set->nextRow())
					{
						$valinfoid= $set->getField("UNIT_MESIN_ID");
						$result[$i]['ID'] = $valinfoid;
						$result[$i]['NAMA'] = $set->getField("NAMA");
						$result[$i]['state'] = $this->hasunitchildsubunitmesin($valinfoid) ? 'closed' : 'open';
						$i++;
					}

				}
			}

			else if($checkid==5)
			{
				// print_r($id);exit;
				$id= explode(' - ', $id);

				if($id[0]=='WIL')
				{
					$perusahaanid=$id[1];
					$dirid=$id[2];
					$disid=$id[3];
					$unitid=$id[4];

					$statement= " AND B.PERUSAHAAN_EKSTERNAL_ID ='".$perusahaanid."' AND B.DIREKTORAT_ID ='".$dirid."' AND A.DISTRIK_ID ='".$disid."'  AND A.UNIT_MESIN_ID ='".$unitid."'
					";

					$sOrder=" ";
					$set= new HirarkiPerusahaan();
					$set->selectByParamsSubUnitMesin(array(), -1, -1, $statement, $sOrder);
					// echo $set->query;exit;
					$i=0;
					while($set->nextRow())
					{
						$valinfoid= 'WIL'.' - '.$set->getField("SUB_MESIN_ID");
						$result[$i]['ID'] = $valinfoid;
						$result[$i]['NAMA'] = $set->getField("NAMA");
						// $result[$i]['state'] = $this->hasunitchildsubunitmesin($valinfoid) ? 'closed' : 'open';
						$i++;
					}
				}
				else
				{

					$perusahaanid=$id[0];
					$dirid=$id[1];
					$disid=$id[2];
					$unitid=$id[3];
					
					$statement= " AND B.PERUSAHAAN_EKSTERNAL_ID ='".$perusahaanid."' AND B.DIREKTORAT_ID ='".$dirid."' AND A.DISTRIK_ID ='".$disid."'  AND A.UNIT_MESIN_ID ='".$unitid."'
					";


					$sOrder=" ";
					$set= new HirarkiPerusahaan();
					$set->selectByParamsSubUnitMesin(array(), -1, -1, $statement, $sOrder);
					// echo $set->query;exit;
					$i=0;
					while($set->nextRow())
					{
						$valinfoid= $set->getField("SUB_MESIN_ID");
						$result[$i]['ID'] = $valinfoid;
						$result[$i]['NAMA'] = $set->getField("NAMA");
						// $result[$i]['state'] = $this->hasunitchildsubunitmesin($valinfoid) ? 'closed' : 'open';
						$i++;
					}

				}
			}

		}
		
		echo json_encode($result);
	}

	function hasunitchild($id)
	{
	
		$statement= " AND A.PERUSAHAAN_EKSTERNAL_ID = '".$id."'";
			
		$child = new HirarkiPerusahaan();
		$child->selectByParamsDirektorat(array(), -1,-1, $statement);
		// echo $child->query;exit;
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
	
		$perusahaanid=strtok($id, ' - ');
		$direktoratid = substr($id, strrpos($id, '-') + 1);
		// $id= explode('-', $id);

		// print_r($id);exit;

		$statement= " AND A.DIREKTORAT_ID ='".$direktoratid."' AND A.PERUSAHAAN_EKSTERNAL_ID ='".$perusahaanid."'";

		// $statement= " AND A.WILAYAH_ID ='".$wilid."' AND A.DISTRIK_ID ='".$direktoratid."'";
		// print_r($id);exit;
			
		$child = new HirarkiPerusahaan();
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
		// print_r($id);exit;
		$id= explode('-', $id);
		$perusahaanid=$id[0];
		$dirid=$id[1];
		$wilid=$id[2];
			
		$statement= " AND C.PERUSAHAAN_EKSTERNAL_ID ='".$perusahaanid."' AND C.DIREKTORAT_ID ='".$dirid."' AND A.WILAYAH_ID ='".$wilid."'";
			
		$child = new HirarkiPerusahaan();
		$child->selectByParamsDistrikWilayah(array(), -1,-1, $statement);
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


	function hasunitchildblokunit($id)
	{
		$id= explode(' - ', $id);
		if($id[0]=='DIS')
		{
			$perusahaanid=$id[1];
			$dirid=$id[2];
			$disid=$id[3];
			// print_r($id);exit;
			$statement= " AND B.PERUSAHAAN_EKSTERNAL_ID ='".$perusahaanid."' AND B.DIREKTORAT_ID ='".$dirid."'  AND B.DISTRIK_ID ='".$disid."'   " ;
			
			$child = new HirarkiPerusahaan();
			$child->selectByParamsBlokUnitDistrik(array(), -1,-1, $statement);
		}
		else
		{
			$perusahaanid=$id[0];
			$dirid=$id[1];
			$wilid=$id[2];
			$disid=$id[3];
			$statement= " AND B.PERUSAHAAN_EKSTERNAL_ID ='".$perusahaanid."' AND B.DIREKTORAT_ID ='".$dirid."' AND B.WILAYAH_ID ='".$wilid."'  " ;
			
			$child = new HirarkiPerusahaan();
			$child->selectByParamsBlokUnit(array(), -1,-1, $statement);
		}
		
		// $statement= " AND LPAD(a.distrik_id::text, 4, '0') = '".$id."'";
		
		// echo $child->query;exit;
		$child->firstRow();
		$tempId= $child->getField("BLOK_UNIT_ID");
		// echo $tempId;exit;
		if($tempId == "")
		return false;
		else
		return true;
		unset($child);
	}


	function hasunitchildunitmesin($id)
	{
		// print_r($id);exit;
		$id= explode(' - ', $id);
		if($id[0]=='WIL')
		{
			$perusahaanid=$id[1];
			$dirid=$id[2];
			$wilid=$id[3];
			$disid=$id[4];
			$blokid=$id[5];

			$statement= " AND B.PERUSAHAAN_EKSTERNAL_ID ='".$perusahaanid."' AND B.DIREKTORAT_ID ='".$dirid."' AND A.DISTRIK_ID ='".$disid."'  AND D.BLOK_UNIT_ID ='".$blokid."'
			";
		}
		else
		{

			$perusahaanid=$id[0];
			$dirid=$id[1];
			$disid=$id[2];
			$blokid=$id[3];
			
			$statement= " AND B.PERUSAHAAN_EKSTERNAL_ID ='".$perusahaanid."' AND B.DIREKTORAT_ID ='".$dirid."' AND A.DISTRIK_ID ='".$disid."'  AND D.BLOK_UNIT_ID ='".$blokid."'
			";

		}
		
			
		$child = new HirarkiPerusahaan();
		$child->selectByParamsUnitMesin(array(), -1,-1, $statement);
		// echo $child->query;exit;
		$child->firstRow();
		$tempId= $child->getField("UNIT_MESIN_ID");
		// echo $tempId;exit;
		if($tempId == "")
		return false;
		else
		return true;
		unset($child);
	}

	function hasunitchildsubunitmesin($id)
	{
		// print_r($id);exit;
		$id= explode(' - ', $id);
		if($id[0]=='WIL')
		{
			$perusahaanid=$id[1];
			$dirid=$id[2];
			$disid=$id[3];
			$unitid=$id[4];

			$statement= " AND B.PERUSAHAAN_EKSTERNAL_ID ='".$perusahaanid."' AND B.DIREKTORAT_ID ='".$dirid."' AND A.DISTRIK_ID ='".$disid."'  AND A.UNIT_MESIN_ID ='".$unitid."'
			";
		}
		else
		{

			$perusahaanid=$id[0];
			$dirid=$id[1];
			$disid=$id[2];
			$unitid=$id[3];
			
			$statement= " AND B.PERUSAHAAN_EKSTERNAL_ID ='".$perusahaanid."' AND B.DIREKTORAT_ID ='".$dirid."' AND A.DISTRIK_ID ='".$disid."'  AND A.UNIT_MESIN_ID ='".$unitid."'
			";

		}
		
			
		$child = new HirarkiPerusahaan();
		$child->selectByParamsSubUnitMesin(array(), -1,-1, $statement);
		// echo $child->query;exit;
		$child->firstRow();
		$tempId= $child->getField("UNIT_MESIN_ID");
		// echo $tempId;exit;
		if($tempId == "")
		return false;
		else
		return true;
		unset($child);
	}


}