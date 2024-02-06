<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class Approval_multi_json extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		if($this->session->userdata("appuserid") == "")
		{
			redirect('login');
		}
		
		$this->appuserid= $this->session->userdata("appuserid");
		$this->appuserroleid= $this->session->userdata("appuserroleid");

		$this->configtitle= $this->config->config["configtitle"];
	}

	function approve()
	{
		date_default_timezone_set("Asia/Jakarta");
		$ref_tabel= $this->input->post('ref_tabel');

		
		$appuserid= $this->appuserid;
		$appuserroleid= $this->appuserroleid;

		$reqwaktu= date('d-m-Y H:i:s');



		$this->load->model('base-app/Approval');

		$set= new Approval();
		$set->selectalllistapproval($ref_tabel);
		// echo $set->query;exit;

		$vreturn=[];
		while($set->nextRow())
		{
		    $arrdata= [];
		    $arrdata["ROLE_ID"]= $set->getField("ROLE_ID");
		    $arrdata["FLOWD_INDEX"]= $set->getField("FLOWD_INDEX");
		    $arrdata["ROLE_NAMA"]= $set->getField("ROLE_NAMA");
		    $arrdata["APPR_ID"]= $set->getField("APPR_ID");
		    $arrdata["REF_ID"]= $set->getField("REF_ID");
		    array_push($vreturn, $arrdata);
		}
		$reqSimpan="";
		if(!empty($vreturn))
		{
			foreach ($vreturn as $key => $value) 
			{
				
				$kode=$value["APPR_ID"];
				$ref_id=$value["REF_ID"];

				$status="V_STATUS";
				$id= "OUTLINING_ASSESSMENT_REKOMENDASI_ID";
				$tabel=$ref_tabel;

				$this->load->model('base-app/Approval');

				$vaprdstatus = 11;
				// $reqwaktu="";

				$set= new Approval();
				$set->setField("APPR_ID", $kode);
				$set->setField("USER_ID", $appuserid);
				$set->setField("ROLE_ID", $appuserroleid);
				$set->setField("APRD_TGL", dateTimeToDBCheck($reqwaktu));
				$set->setField("APRD_STATUS", $vaprdstatus);

				$statement=" AND A.APRD_STATUS=30 AND A.APPR_ID = ".$kode;
				$setcheck= new Approval();
				$setcheck->selectapprdetail(array(),-1,-1,$statement);
				// echo $setcheck->query;
				$setcheck->firstRow();
				$reqaprdid= $setcheck->getField("APRD_ID");

				unset($setcheck);

				$statement=" AND REF_TABEL='".$tabel."'  AND A.APPR_STATUS=0 AND A.REF_ID = '".$ref_id."'";
				$setcheck= new Approval();
				$setcheck->selectapproval(array(),-1,-1,$statement);
				// echo $setcheck->query;
				$setcheck->firstRow();
				$rfid= $setcheck->getField("REF_ID");

				unset($setcheck);


				if(!empty($reqaprdid))
				{
					$setdelete= new Approval();
					$setdelete->setField("APRD_ID", $reqaprdid);
					$setdelete->deleteapprdetilreturn();
				}

				if(empty($reqaprdid) && !empty($rfid))
				{
					// print_r($rfid);
					
					if($set->insertapprdetail())
					{
						$reqSimpan=1;
						$statement= " AND C.LINK_MODUL = '".$tabel."' AND b.ROLE_ID > '".$appuserroleid."'";
						$roledetil= new Approval();
						$roledetil->selectnextroleapproval(array(), 1,-1, $statement);
						// echo $roledetil->query;exit;
						$roledetil->firstRow();
						$nroleid= $roledetil->getField("ROLE_ID");

						$this->updateapproval($kode,$tabel,$id,$status,$ref_id,$vaprdstatus,$nroleid);


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

					}

				}

				
			}


		}
		$arrJson["PESAN"] = "Semua data berhasil di approve";
		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
	}

	function updateapproval($kode,$tabel,$id,$status,$ref_id,$status_app,$role_id)
	{

		$this->load->model('base-app/Approval');
		$set= new Approval();
		$jumlahflow= $set->getjumlahflow($kode);
		$jumlahapproval= $set->getjumlahapproval($kode);
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
		$set->setField("NEXT_ROLE_ID", ValToNullDB($role_id));
		$set->updateapproval();

		$infovalid= $tabel."_id";
		$infovalid= strtoupper($infovalid);

		$set= new Approval();
		$set->setField("TABLE", $tabel);
		$set->setField("FIELD_ID", $infovalid);
		$set->setField("VAL_ID", $ref_id);
		$zx="";
		$set->setField("V_STATUS", $vapprstatus);
		$set->updatetableapprove();
		
		


	}



}