<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once("functions/image.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");

class Applogin extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		//kauth
		// $this->load->library('session');

		$this->sessappinfopesan= $this->session->userdata("sessappinfopesan");
		$this->appuserid= $this->session->userdata("appuserid");
		$this->appusernama= $this->session->userdata("appusernama");
		$this->appusergroupid= $this->session->userdata("appusergroupid");
	}

	public function index()
	{
		if(!empty($this->appuserid))
		{
			redirect('app');
		}

		$this->session->set_userdata('sessappinfopesan', "");
		$data['pesan']="";
		$this->load->view('main/login', $data);
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
			$respon = $this->kauth->cekuserapp($reqUser,$reqPasswd);
			// echo $respon;exit;
			if($respon == "1")
			{
				redirect('app');
			}
			else
			{
				$this->session->set_userdata('sessappinfopesan', "Username dan password tidak sesuai.");
				redirect ('applogin');
			}
		}
		else
		{
			$this->session->set_userdata('sessappinfopesan', "Masukkan username dan password.");
			redirect ('applogin');
		}
	}

	public function logout()
	{
		$this->kauth->unsetcekuserapp();
		redirect ('applogin');
	}
}