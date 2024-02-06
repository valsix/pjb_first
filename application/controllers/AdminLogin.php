<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once("functions/image.func.php");
include_once("functions/string.func.php");

class Admin extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		//kauth
		
		if($this->session->userdata("appuserid") == "")
		{
			redirect('login');
		}
		
		$this->appuserid= $this->session->userdata("appuserid");
		$this->appusernama= $this->session->userdata("appusernama");
		$this->personaluserlogin= $this->session->userdata("personaluserlogin");
		$this->appusergroupid= $this->session->userdata("appusergroupid");
		$this->appuserpilihankodehak= $this->session->userdata("appuserpilihankodehak");
		$this->appuserkodehak= $this->session->userdata("appuserkodehak");
		$this->appuserroleid= $this->session->userdata("appuserroleid");

		$this->configtitle= $this->config->config["configtitle"];
		// print_r($this->configtitle);exit;
	}
	
	public function index()
	{
		$pg = $this->uri->segment(3, "home");
		$reqId = $this->input->get("reqId");
				
		$view = array(
			'pg' => $pg,
			'linkBack' => $file."_detil"
		);	
		// print_r($view);exit;
		$data = array(
			'breadcrumb' => $breadcrumb,
			'content' => $this->load->view("app/".$pg,$view,TRUE),
			'pg' => $pg
		);	
		
		$this->load->view('app/index', $data);
	}

	public function indexcode()
	{
		$pg = $this->uri->segment(3, "home");
		$reqId = $this->input->get("reqId");
				
		$view = array(
			'pg' => $pg,
			'linkBack' => $file."_detil"
		);	
		// print_r($view);exit;
		$data = array(
			'breadcrumb' => $breadcrumb,
			'content' => $this->load->view("app/".$pg,$view,TRUE),
			'pg' => $pg
		);	
		
		$this->load->view('app/index_code', $data);
	}

	public function indexpg()
	{
		$pg = $this->uri->segment(3, "home");
		$reqId = $this->input->get("reqId");
				
		$view = array(
			'pg' => $pg,
			'linkBack' => $file."_detil"
		);	
		// print_r($view);exit;
		$data = array(
			'breadcrumb' => $breadcrumb,
			'content' => $this->load->view("app/".$pg,$view,TRUE),
			'pg' => $pg
		);	
		
		$this->load->view('app/indexpg', $data);
	}

	public function gantirule()
	{
		$pg = $this->uri->segment(3, "home");
		$reqId = $this->input->get("reqId");
				
		$view = array(
			'pg' => $pg,
			'linkBack' => $file."_detil"
		);	
		// print_r($view);exit;
		$data = array(
			'breadcrumb' => $breadcrumb,
			'content' => $this->load->view("app/".$pg,$view,TRUE),
			'pg' => $pg
		);	
		
		$this->load->view('app/gantirule', $data);
	}

	public function approval()
	{
		$this->load->view('app/approval', true);
	}

	public function ubahrule()
	{
		$reqhak= $this->input->post("reqhak");
		// echo $reqhak;exit;

		$this->session->set_userdata('appuserkodehak', $reqhak);
		redirect('app');
	}

	public function loadUrl()
	{		
		$reqFolder = $this->uri->segment(3, "");
		$reqFilename = $this->uri->segment(4, "");
		$reqParse1 = $this->uri->segment(5, "");
		$reqParse2 = $this->uri->segment(6, "");
		$reqParse3 = $this->uri->segment(7, "");
		$reqParse4 = $this->uri->segment(8, "");
		$reqParse5 = $this->uri->segment(9, "");
		$data = array(
			'reqParse1' => urldecode($reqParse1),
			'reqParse2' => urldecode($reqParse2),
			'reqParse3' => urldecode($reqParse3),
			'reqParse4' => urldecode($reqParse4),
			'reqParse5' => urldecode($reqParse5)
		);

		if($reqFolder == "main")
			$this->session->set_userdata('currentUrl', $reqFilename);
		
		$this->load->view($reqFolder.'/'.$reqFilename, $data);
	}	
	
	public function logout()
	{
		$this->kauth->unsetcekuserapp();
		redirect ('login');
	}
}