<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once("functions/image.func.php");
include_once("functions/string.func.php");

class Customer extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		//kauth
		
		if( $this->session->userdata("customeruserid") == "" )
		{
			redirect('customerlogin');
		}

		$this->customeruserid= $this->session->userdata("customeruserid");
		$this->customerusergroupid= $this->session->userdata("customerusergroupid");
		$this->reqAsesorId= $this->session->userdata("reqAsesorId");
		$this->customeruserlogin= $this->session->userdata("customeruserlogin");
		$this->customeruserloginid= $this->session->userdata("customeruserloginid");
		$this->customerusernama= $this->session->userdata("customerusernama");
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
			'content' => $this->load->view("customer/".$pg,$view,TRUE),
			'pg' => $pg
		);	
		
		$this->load->view('customer/index', $data);
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

		if($reqFolder == "customer")
			$this->session->set_userdata('currentUrl', $reqFilename);
		
		$this->load->view($reqFolder.'/'.$reqFilename, $data);
	}	
	
	public function logout()
	{
		$this->kauth->unsetcekusercustomer();
		redirect ('customerlogin');
	}
}