<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once("functions/image.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");

class Customerlogin extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		//kauth

		$this->sesscustomerinfopesan= $this->session->userdata("sesscustomerinfopesan");
		$this->customeruserid= $this->session->userdata("customeruserid");
		$this->customerusernama= $this->session->userdata("customerusernama");
	}

	public function index()
	{
		if(!empty($this->customeruserid))
		{
			redirect('customer');
		}

		$this->session->set_userdata('sesscustomerinfopesan', "");
		$data['pesan']="";
		$this->load->view('customer/login', $data);
	}

	function action()
	{
		$this->load->library("crfs_protect"); $csrf = new crfs_protect('_crfs_login');
		if (!$csrf->isTokenValid($_POST['_crfs_login']))
		{
		?>
			<script language="javascript">
				alert('<?=$respon?>');
				document.location.href = 'logout';
			</script>
		<?
			exit();
		}
		
		$reqUser= $this->input->post("reqUser");
		$reqPasswd= $this->input->post("reqPasswd");
		$reqCaptcha= $this->input->post("reqCaptcha");
		
		if(!empty($reqUser) AND !empty($reqPasswd))
		{
			$respon = $this->kauth->cekusercustomer($reqUser,$reqPasswd);
			// echo $respon;exit;
			if($respon == "1")
			{
				redirect('customer');
			}
			else
			{
				$this->session->set_userdata('sesscustomerinfopesan', "Username dan password tidak sesuai.");
				redirect ('customerlogin');
			}
		}
		else
		{
			$this->session->set_userdata('sesscustomerinfopesan', "Masukkan username dan password.");
			redirect ('customerlogin');
		}
	}

	public function logout()
	{
		$this->kauth->unsetcekusercustomer();
		redirect ('customerlogin');
	}
}