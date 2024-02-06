<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once("functions/image.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");

class Personallogin extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		//kauth

		$this->sesspersonalinfopesan= $this->session->userdata("sesspersonalinfopesan");
		$this->personaluserid= $this->session->userdata("personaluserid");
		$this->personalusernama= $this->session->userdata("personalusernama");
	}

	public function index()
	{
		if(!empty($this->personaluserid))
		{
			redirect('personal');
		}

		$this->session->set_userdata('sesspersonalinfopesan', "");
		$data['pesan']="";
		$this->load->view('personal/login', $data);
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
			$respon = $this->kauth->cekuserpersonal($reqUser,$reqPasswd);
			// echo $respon;exit;
			if($respon == "1")
			{
				if($this->session->userdata("personalusergroupid") == "3")
					redirect('admin');
				elseif($this->session->userdata("personalusergroupid") == "4")
					redirect('kepala');
				// elseif($this->session->userdata("personalusergroupid") == "5")
				// 	redirect('customer');
				else
					redirect('personal');
			}
			else
			{
				$this->session->set_userdata('sesspersonalinfopesan', "Username dan password tidak sesuai.");
				redirect ('personallogin');
			}
		}
		else
		{
			$this->session->set_userdata('sesspersonalinfopesan', "Masukkan username dan password.");
			redirect ('personallogin');
		}
	}

	public function logout()
	{
		$this->kauth->unsetcekuserpersonal();
		redirect ('personallogin');
	}
}