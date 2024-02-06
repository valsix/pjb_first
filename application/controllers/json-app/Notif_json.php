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

      
        $set= new Notif();
        $jumlahnotif= $set->getCountByParamsNotifOutlining(array(),$appuserroleid, $statement);
        echo json_encode($jumlahnotif);


        // $statement=" AND A.V_STATUS > 0 ";
        // $set= new Notif();
        // $jumlahnotif= $set->getCountByParamsNotifOutlining(array(), $statement);
        // echo json_encode($jumlahnotif);
    }


}