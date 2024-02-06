<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class Approval_json extends CI_Controller
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

		// exit;
		$this->load->library('libapproval');
		$vappr= new libapproval();

		$no= $this->input->post('kode');
		$tabel= $this->input->post('tabel');
		$id= $this->input->post('id');
		$status= $this->input->post('status');
		$ref_id= $this->input->post('ref_id');

		$reqwaktu= $this->input->post('reqwaktu');
		$result= $vappr->approve($no,$tabel,$id,$status,$ref_id,$reqwaktu);
		echo $result;
	}

	function reject()
	{
		$this->load->library('libapproval');
		$vappr= new libapproval();

		$no= $this->input->post('kode');
		$tabel= $this->input->post('tabel');
		$id= $this->input->post('id');
		$status= $this->input->post('status');
		$ref_id= $this->input->post('ref_id');
		$alasan= $this->input->post('alasan');

		if($alasan==''){
			echo 'Alasan Tidak Boleh Kosong';exit;
		}
		
		$reqwaktu= $this->input->post('reqwaktu');
		$result= $vappr->reject($no,$tabel,$id,$status,$ref_id,$alasan,$reqwaktu);
		echo $result;
	}

	function returnapp()
	{
		$this->load->library('libapproval');
		$vappr= new libapproval();

		$no= $this->input->post('kode');
		$tabel= $this->input->post('tabel');
		$id= $this->input->post('id');
		$status= $this->input->post('status');
		$ref_id= $this->input->post('ref_id');
		$alasan= $this->input->post('alasan');

		if($alasan==''){
			echo 'Alasan Tidak Boleh Kosong';exit;
		}
		
		$reqwaktu= $this->input->post('reqwaktu');
		$result= $vappr->returnapp($no,$tabel,$id,$status,$ref_id,$alasan,$reqwaktu);
		echo $result;
	}

}