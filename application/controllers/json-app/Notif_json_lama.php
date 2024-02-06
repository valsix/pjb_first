<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class notif_json extends CI_Controller
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
		$this->appuserkodehak= $this->session->userdata("appuserkodehak");
		$this->appuserroleid= $this->session->userdata("appuserroleid");

		$this->configtitle= $this->config->config["configtitle"];
		// print_r($this->configtitle);exit;
	}

	function countnotif()
    {
        $this->load->model("base-app/Notif");
        $this->load->library('libapproval');
        $this->load->model("base-app/Crud");
        $this->load->model("base/Users");
        $appuserroleid= $this->appuserroleid;

        $appuserkodehak= $this->appuserkodehak;
		$reqPenggunaid= $this->appuserid;

		$set= new Notif();
		$set->selectlistapprovalstatus("outlining_assessment");
		// echo $set->query;exit;

		$datastatus=[];
		while($set->nextRow())
		{
			$arrdata= [];
			$arrdata["ROLE_ID"]= $set->getField("ROLE_ID");
			$arrdata["NAMA"]= $set->getField("NAMA");
			$arrdata["APRD_TGL"]= $set->getField("APRD_TGL");
			$arrdata["APRD_STATUS"]= $set->getField("APRD_STATUS");
			$arrdata["APRD_STATUS_NAMA"]= $set->getField("APRD_STATUS_NAMA");
			$arrdata["APRD_ALASANTOLAK"]= $set->getField("APRD_ALASANTOLAK");
			array_push($datastatus, $arrdata);
		}
		// print_r($vreturn);exit();
		

		$set= new Crud();
		$statement=" AND A.KODE_HAK = '".$appuserkodehak."'";

		$set->selectByParams(array(), -1, -1, $statement);
		// echo $set->query;exit;

		$set->firstRow();
		$reqPenggunaHakId= $set->getField("PENGGUNA_HAK_ID");
		unset($set);

		$statement="";

		if($reqPenggunaHakId==1)
		{}
		else
		{
			$arridDistrik=[];
			$usersdistrik = new Users();
			$usersdistrik->selectByPenggunaDistrik($reqPenggunaid);
			while($usersdistrik->nextRow())
			{
				$arridDistrik[]= $usersdistrik->getField("DISTRIK_ID"); 
			}
			$idDistrik = implode(",",$arridDistrik); 
			if(!empty($idDistrik))
			{
				$statement .= " AND E.DISTRIK_ID IN (".$idDistrik.")";
			} 
		}

        // print_r($appuserroleid);exit;

        $statement .=" AND E.V_STATUS < 30 AND D.REF_TABEL = 'outlining_assessment' AND C.ROLE_ID =".$appuserroleid;

        $set= new Notif();
        $datatabel= [];

        $set->selectlistapproval(array(),$statement);
		// echo $set->query;exit;
        while($set->nextRow())
        {
        	$arrdata= [];
		    $arrdata["ROLE_ID"]= $set->getField("ROLE_ID");
		    $arrdata["FLOWD_INDEX"]= $set->getField("FLOWD_INDEX");
		    $arrdata["ROLE_NAMA"]= $set->getField("ROLE_NAMA");
		    $arrdata["APPR_ID"]= $set->getField("APPR_ID");
        	array_push($datatabel, $arrdata);
        }
        unset($set);

        // print_r($appuserroleid);exit;
        $no=0;
        $index_before = 0;
        $status_before = NULL;
        $appr_before = NULL;
        foreach ($datatabel as $key => $rows) {
        	$vapprid= $rows['APPR_ID'];
        	$vroleid= $rows['ROLE_ID'];
        	$vflowdindex= $rows['FLOWD_INDEX'];

        	// print_r($vapprid);


        	$status= NULL;
        	$infocari= $vroleid;
        	$arraycari= in_array_column($infocari, "ROLE_ID", $datastatus);
        	if(!empty($arraycari))
        	{
        		$status= $datastatus[$arraycari[0]];
        	}

        	$urut = ($index_before < $vflowdindex && $index_before!=0 && $status_before == NULL)?1:0;

            var_dump( $status);
            if($appuserroleid == $vroleid && $status==NULL && $urut != 1 && $appr_before < 30   )
            {
            	// print_r(1);

            	$no++;
            }

            $index_before = $vflowdindex;
            $status_before = $status;
            $appr_before = $status['APRD_STATUS'];
        }
       

        // $set= new Notif();
        // $jumlahnotif= $set->getCountByParamsNotifOutlining(array(), $statement);
        // echo json_encode($jumlahnotif);


        // $statement=" AND A.V_STATUS > 0 ";
        // $set= new Notif();
        // $jumlahnotif= $set->getCountByParamsNotifOutlining(array(), $statement);
        // echo json_encode($jumlahnotif);
    }


}