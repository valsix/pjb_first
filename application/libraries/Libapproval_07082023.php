<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once("functions/string.func.php");
include_once("functions/date.func.php");

class libapproval
{
	function __construct() {
        $CI =& get_instance();
        $CI->load->driver('session');

        $this->appuserid= $CI->session->userdata("appuserid");
        $this->appuserroleid= $CI->session->userdata("appuserroleid");

        date_default_timezone_set('Asia/Jakarta');
    }

	function setpg($pg)
	{
		$infolinkmodul= $pg;
		$infolinkmodul= str_replace("_add", "", $infolinkmodul);
		return $infolinkmodul;
	}

	function view($arrparam)
	{
		$CI =& get_instance();
		$CI->load->view('app/approval', $arrparam);
	}

	// buat data approval
	function approvaldata($arrparam)
	{
		$ref_tabel= $arrparam["ref_tabel"];
		// if($ref_tabel == "outlining_assessment_rekomendasi")
		// {
		// 	$ref_tabel=$ref_tabel;
		// }
		// else
		// {
			$ref_tabel= $this->setpg($ref_tabel);
		// }

		// print_r($ref_tabel);exit;

		$ref_id= $arrparam["ref_id"];
		$infoketerangan= $arrparam["infoketerangan"];
		$infostatus= 0;

		$CI =& get_instance();
		$CI->load->model("base-app/Approval");

		$statement= " AND A.REF_TABEL = '".$ref_tabel."' AND A.REF_ID = '".$ref_id."'";
		$set= new Approval();
		$set->selectapproval(array(), -1,-1, $statement);
		// echo $set->query;exit;
		$set->firstRow();
		$vapprid= $set->getField("APPR_ID");

		$set= new Approval();
		$set->setField("APPR_ID", $vapprid);
		$set->setField("REF_TABEL", $ref_tabel);
		$set->setField("REF_ID", $ref_id);
		$set->setField("APPR_DESK", $infoketerangan);
		$set->setField("APPR_STATUS", $infostatus);
		$set->setField("APPR_TYPE", ValToNullDB($req));
		$set->setField("PERUSAHAAN_ID", ValToNullDB($req));

		if(empty($vapprid))
		{
			$set->insertapproval();
		}
		else
		{
			$set->updateapproval();
			$set->deleteapprdetil();
		}
		// print_r($arrparam);exit;
		/*
		code dari portis
		$result = array();
		$this->db->_protect_identifiers=false;
		$this->db->select('*');
		$this->db->from('r_approval a');
		$this->db->where('ref_tabel',"'".$appr['ref_tabel']."'",false);
		$this->db->where('ref_id',"'".$appr['ref_id']."'",false);
		$query  = $this->db->get();
		// echo $this->db->last_query();exit;
		
		$this->db->trans_start();
		if($query->num_rows() > 0)
		{
			// update
			$result = $query->row_array();
			$appr['appr_status'] = 0;
			$this->db->where('appr_id',$result['appr_id'],false);
			$this->db->update('r_approval',$appr);
			
			$this->db->where('appr_id',$result['appr_id'],false);
			$this->db->delete('r_apprdetail');
			
		}else{
			$appr['appr_status'] = 0;
			$appr['created_at'] = date('Y-m-d H:i:s');
			$this->db->insert('r_approval',$appr);
		}
		$this->db->trans_complete();*/
	}

	function getdetaildok($arrparam)
	{
		$ref_tabel= $arrparam["ref_tabel"];
		// if($ref_tabel == "outlining_assessment_rekomendasi")
		// {
		// 	$ref_tabel=$ref_tabel;
		// }
		// else
		// {
			$ref_tabel= $this->setpg($ref_tabel);
		// }
		$ref_id= $arrparam["ref_id"];

		$CI =& get_instance();
		$CI->load->model("base-app/Approval");

		$statement= " AND A.REF_ID = '".$ref_id."' AND A.REF_TABEL = '".$ref_tabel."'";
		$set= new Approval();
		$set->selectapproval(array(), -1,-1, $statement);
		// echo $set->query;

		$vreturn=[];
		while($set->nextRow())
		{
		    $arrdata= [];
		    $arrdata["APPR_STATUS"]= $set->getField("APPR_STATUS");
		    $arrdata["APPR_STATUS_NAMA"]= $set->getField("APPR_STATUS_NAMA");
		    array_push($vreturn, $arrdata);
		}
		// print_r($vreturn);exit();
		return $vreturn;

		/*$result = array();
		$this->db->_protect_identifiers=false;
		$this->db->select('*');
		$this->db->from('r_approval a');
		$this->db->where('a.ref_tabel',"'".$ref_tabel."'",false);
		$this->db->where('a.ref_id',"'".$ref_id."'",false);
		// $this->db->where('ref_id',"'".$ref_id."'",false);
		$query  = $this->db->get();
		// print_r($query->row_array());exit;
		return $query->row_array();*/
	}

	function listapproval($arrparam)
	{
		$ref_tabel= $arrparam["ref_tabel"];
		// if($ref_tabel == "outlining_assessment_rekomendasi")
		// {
		// 	$ref_tabel=$ref_tabel;
		// }
		// else
		// {
			$ref_tabel= $this->setpg($ref_tabel);
		// }
		$ref_id= $arrparam["ref_id"];

		$CI =& get_instance();
		$CI->load->model("base-app/Approval");

		$set= new Approval();
		$set->selectlistapproval($ref_tabel, $ref_id);
		// echo $set->query;exit;

		$vreturn=[];
		while($set->nextRow())
		{
		    $arrdata= [];
		    $arrdata["ROLE_ID"]= $set->getField("ROLE_ID");
		    $arrdata["FLOWD_INDEX"]= $set->getField("FLOWD_INDEX");
		    $arrdata["ROLE_NAMA"]= $set->getField("ROLE_NAMA");
		    $arrdata["APPR_ID"]= $set->getField("APPR_ID");
		    array_push($vreturn, $arrdata);
		}
		// print_r($vreturn);exit();
		return $vreturn;

		/*
		code dari portis
		$result = array();
		$this->db->_protect_identifiers=false;
		$this->db->select('*');
		$this->db->from('r_flow_approval a');
		$this->db->join('r_flow_appdetail b','a.flow_id=b.flow_id');
		$this->db->join('r_role_approval c','b.role_id=c.role_id');
		$this->db->join('r_approval d',"d.ref_tabel=a.ref_tabel and ref_id = '$ref_id'");
		$this->db->join('t_perusahaan e','d.perusahaan_id=e.perusahaan_id and a.jp_id=e.perusahaan_jenis');
		$this->db->where('a.ref_tabel',"'".$ref_tabel."'",false);
		$this->db->order_by('flowd_index','asc');
		// $this->db->where('ref_id',"'".$ref_id."'",false);
		$query  = $this->db->get();*/
	}

	function listapprovalstatus($arrparam)
	{
		$ref_tabel= $arrparam["ref_tabel"];
		// if($ref_tabel == "outlining_assessment_rekomendasi")
		// {
		// 	$ref_tabel=$ref_tabel;
		// }
		// else
		// {
			$ref_tabel= $this->setpg($ref_tabel);
		// }
		$ref_id= $arrparam["ref_id"];

		$CI =& get_instance();
		$CI->load->model("base-app/Approval");

		$set= new Approval();
		$set->selectlistapprovalstatus($ref_tabel, $ref_id);
		// echo $set->query;exit;

		$vreturn=[];
		while($set->nextRow())
		{
		    $arrdata= [];
		    $arrdata["ROLE_ID"]= $set->getField("ROLE_ID");
		    $arrdata["NAMA"]= $set->getField("NAMA");
		    $arrdata["APRD_TGL"]= $set->getField("APRD_TGL");
		    $arrdata["APRD_STATUS"]= $set->getField("APRD_STATUS");
		    $arrdata["APRD_STATUS_NAMA"]= $set->getField("APRD_STATUS_NAMA");
		    $arrdata["APRD_ALASANTOLAK"]= $set->getField("APRD_ALASANTOLAK");
		    array_push($vreturn, $arrdata);
		}
		// print_r($vreturn);exit();
		return $vreturn;
		
		/*
		code dari portis
		$result = array();
		$this->db->_protect_identifiers=false;
		$this->db->select('*');
		$this->db->from('r_approval a');
		$this->db->join('r_apprdetail b','a.appr_id=b.appr_id');
		$this->db->join('pengguna c','b.user_id=c.ID');
		$this->db->where('a.ref_tabel',"'".$ref_tabel."'",false);
		$this->db->where('a.ref_id',"'".$ref_id."'",false);
		// $this->db->where('ref_id',"'".$ref_id."'",false);
		$query  = $this->db->get();
		foreach($query->result_array() as $rows)
		{
			$result[$rows['role_id']] = $rows;
		}
		return $result;*/
	}

	function approve($kode,$tabel,$id,$status,$ref_id,$reqwaktu="")
	{
		$appuserid= $this->appuserid;
		$appuserroleid= $this->appuserroleid;

		$CI =& get_instance();
		$CI->load->model("base-app/Approval");

		$vaprdstatus = 11;
		// $reqwaktu="";
		if(empty($reqwaktu))
			$reqwaktu= date('d-m-Y H:i:s');
		else
		{
			$vdate= $reqwaktu;
			$arrDateTime = explode(" ", $vdate);
			// echo $vdate;exit;

			$arrDate= explode("/", $arrDateTime[0]);

			$reqwaktu= generateZero($arrDate[1],2)."-".generateZero($arrDate[0],2)."-".$arrDate[2]." ".$arrDateTime[1];
		}
		// echo $appuserroleid;exit;

		$set= new Approval();
		$set->setField("APPR_ID", $kode);
		$set->setField("USER_ID", $appuserid);
		$set->setField("ROLE_ID", $appuserroleid);
		$set->setField("APRD_TGL", dateTimeToDBCheck($reqwaktu));
		$set->setField("APRD_STATUS", $vaprdstatus);

		$statement=" AND A.APRD_STATUS=30 AND A.APPR_ID = ".$kode;
		$setcheck= new Approval();
		$setcheck->selectapprdetail(array(),-1,-1,$statement);
		// echo $setcheck->query;exit;
		$setcheck->firstRow();
		$reqaprdid= $setcheck->getField("APRD_ID");

		unset($setcheck);


		if(!empty($reqaprdid))
		{
			$setdelete= new Approval();
			$setdelete->setField("APRD_ID", $reqaprdid);
			$setdelete->deleteapprdetilreturn();
		}

		if($set->insertapprdetail())
		{
			$this->updateapproval($kode,$tabel,$id,$status,$ref_id,$vaprdstatus);


			$statement=" AND A.APRD_STATUS=11 AND A.APPR_ID = ".$kode;
			$setcheck= new Approval();
			$setcheck->selectapprdetail(array(),-1,-1,$statement);
			// echo $setcheck->query;exit;
			$setcheck->firstRow();
			$reqapprid= $setcheck->getField("APPR_ID");
			unset($setcheck);

			if(!empty($reqapprid))
			{
				$setdelete= new Approval();
				$setdelete->setField("APPR_ID", $reqapprid);
				$setdelete->setField("APRD_STATUS", "30");
				$setdelete->deleteapprdetilreturnall();
			}

			return 1;
		}
		return 0;

		/*$this->db->trans_start();
		$data['appr_id'] = $kode;
		$data['user_id'] = $this->session->userdata('user_id');
		$data['role_id'] = $this->session->userdata('role_id');

		if(empty($reqwaktu))
			$reqwaktu= date('Y-m-d H:i:s');
		$data['aprd_tgl'] = $reqwaktu;

		$data['aprd_status'] = 11; // cek harus lengkap smua
		$this->db->_protect_identifiers=false;
		$this->db->insert('r_apprdetail',$data);
		
		$this->db->trans_complete();
		
		if($this->db->trans_status())
		{
			$this->updateapproval($kode,$tabel,$id,$status,$ref_id,$data['aprd_status']);
			return 1;
		}
		return 0;*/
	}
	
	function reject($kode,$tabel,$id,$status,$ref_id,$alasan,$reqwaktu="")
	{
		$appuserid= $this->appuserid;
		$appuserroleid= $this->appuserroleid;

		$CI =& get_instance();
		$CI->load->model("base-app/Approval");

		$vaprdstatus = 90;
		// $reqwaktu="";
		if(empty($reqwaktu))
			$reqwaktu= date('d-m-Y H:i:s');
		else
		{
			$vdate= $reqwaktu;
			$arrDateTime = explode(" ", $vdate);
			// echo $vdate;exit;

			$arrDate= explode("/", $arrDateTime[0]);

			$reqwaktu= generateZero($arrDate[1],2)."-".generateZero($arrDate[0],2)."-".$arrDate[2]." ".$arrDateTime[1];
		}
		// echo $id;exit;

		$set= new Approval();
		$set->setField("APPR_ID", $kode);
		$set->setField("USER_ID", $appuserid);
		$set->setField("ROLE_ID", $appuserroleid);
		$set->setField("APRD_TGL", dateTimeToDBCheck($reqwaktu));
		$set->setField("APRD_STATUS", $vaprdstatus);
		$set->setField("APRD_ALASANTOLAK", $alasan);
		if($set->insertapprdetail())
		{

			$this->updateapproval($kode,$tabel,$id,$status,$ref_id,$vaprdstatus);
			return 1;
		}
		return 0;

		/*$this->db->trans_start();
		$data['appr_id'] = $kode;
		$data['user_id'] = $this->session->userdata('user_id');
		$data['role_id'] = $this->session->userdata('role_id');

		if(empty($reqwaktu))
			$reqwaktu= date('Y-m-d H:i:s');
		$data['aprd_tgl'] = $reqwaktu;
		
		$data['aprd_status'] = 90; // cek harus lengkap smua
		$data['aprd_alasantolak'] = $alasan; // cek harus lengkap smua
		$this->db->_protect_identifiers=false;
		$this->db->insert('r_apprdetail',$data);
		
		$this->db->trans_complete();
		
		if($this->db->trans_status())
		{
			$this->updateapproval($kode,$tabel,$id,$status,$ref_id,$data['aprd_status']);
			return 1;
		}
		return 0;*/
	}

	function returnapp($kode,$tabel,$id,$status,$ref_id,$alasan,$reqwaktu="")
	{
		$appuserid= $this->appuserid;
		$appuserroleid= $this->appuserroleid;

		$CI =& get_instance();
		$CI->load->model("base-app/Approval");

		$vaprdstatus = 30;
		// $reqwaktu="";
		if(empty($reqwaktu))
			$reqwaktu= date('d-m-Y H:i:s');
		else
		{
			$vdate= $reqwaktu;
			$arrDateTime = explode(" ", $vdate);
			// echo $vdate;exit;

			$arrDate= explode("/", $arrDateTime[0]);

			$reqwaktu= generateZero($arrDate[1],2)."-".generateZero($arrDate[0],2)."-".$arrDate[2]." ".$arrDateTime[1];
		}
		// echo $reqwaktu;exit;

		$set= new Approval();
		$set->setField("APPR_ID", $kode);
		$set->setField("USER_ID", $appuserid);
		$set->setField("ROLE_ID", $appuserroleid);
		$set->setField("APRD_TGL", dateTimeToDBCheck($reqwaktu));
		$set->setField("APRD_STATUS", $vaprdstatus);
		$set->setField("APRD_ALASANTOLAK", $alasan);

		$statement=" AND A.APRD_STATUS=11 AND A.APPR_ID = ".$kode;
		$setcheck= new Approval();
		$setcheck->selectapprdetail(array(),-1,-1,$statement);
		// echo $setcheck->query;exit;
		$setcheck->firstRow();
		$reqaprdid= $setcheck->getField("APRD_ID");

		if(!empty($reqaprdid))
		{
			$setdelete= new Approval();
			$setdelete->setField("APRD_ID", $reqaprdid);
			if($setdelete->deleteapprdetilreturn())
			{
				if($set->insertapprdetail())
				{

					$this->updateapproval($kode,$tabel,$id,$status,$ref_id,$vaprdstatus);
					return 1;

				}
				
			}

		}

		return 0;

	}


	function updateapproval($kode,$tabel,$id,$status,$ref_id,$status_app)
	{
		$jumlahflow= $this->jumlahflow($kode);
		$jumlahapproval= $this->jumlahapproval($kode);
		// echo $jumlahflow."-".$jumlahapproval;

		if($status_app==90)
		{
			$vapprstatus= $status_app;
		}
		elseif($status_app==30)
		{
			$vapprstatus= $status_app;
		}
		else
		{
			if($jumlahflow == $jumlahapproval)
			{
				$vapprstatus= 20;
			}
			else
			{
				$vapprstatus= 10;
			}
		}
		// echo $vapprstatus;exit;
		// echo $kode;exit;

		$set= new Approval();
		$set->setField("APPR_ID", $kode);
		$set->setField("APPR_STATUS", $vapprstatus);
		$set->updateapproval();

		// echo $tabel;exit;
		// echo $ref_id;exit;

		// if($tabel=="outlining_assessment_rekomendasi")
		// {
		// 	$infovalid= $id;
		// 	$infovalid= strtoupper($infovalid);
		// }
		// else
		// {
			$infovalid= $tabel."_id";
			$infovalid= strtoupper($infovalid);
		// }
		
		// echo $infovalid;exit;

		$set= new Approval();
		$set->setField("TABLE", $tabel);
		$set->setField("FIELD_ID", $infovalid);
		$set->setField("VAL_ID", $ref_id);
		$set->setField("V_STATUS", $vapprstatus);
		$set->updatetableapprove();


		/*$this->db->where('appr_id',$kode,false);
		$this->db->update('r_approval',$data);
		
		$data_doc[$status] = $data['appr_status'];
		$this->db->where($id,$ref_id,false);
		$this->db->update($tabel,$data_doc);*/
	}

	function jumlahflow($vapprid)
	{
		$CI =& get_instance();
		$CI->load->model("base-app/Approval");

		$set= new Approval();
		$vreturn= $set->getjumlahflow($vapprid);
		// echo $vreturn;exit;
		return $vreturn;

		/*$result = array();
		$this->db->_protect_identifiers=false;
		$this->db->select('max(flowd_index) as jml');
		$this->db->from('r_flow_approval a');
		$this->db->join('r_flow_appdetail b','a.flow_id = b.flow_id');
		$this->db->join('r_approval d',"d.ref_tabel = a.ref_tabel");
		$this->db->join('t_perusahaan e',"d.perusahaan_id = e.perusahaan_id and a.jp_id = e.perusahaan_jenis");
		$this->db->where('appr_id',$vapprid);
		$query  = $this->db->get();
		// echo $this->db->last_query();exit;

		if($query->num_rows() > 0)
		{
			$result = $query->row_array();
			return $result['jml'];
		}
		return 0;*/
	}
	
	function jumlahapproval($vapprid)
	{
		$CI =& get_instance();
		$CI->load->model("base-app/Approval");

		$set= new Approval();
		$vreturn= $set->getjumlahapproval($vapprid);
		// echo $vreturn;exit;
		return $vreturn;
		
		/*$sql= "select role_id from r_apprdetail where appr_id = ".$vapprid." group by role_id";
		$query= $this->db->query($sql);
		return $query->num_rows();*/
	}

}