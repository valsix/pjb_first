<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class kesesuaian_json extends CI_Controller
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

		$this->configtitle= $this->config->config["configtitle"];
		// print_r($this->configtitle);exit;
	}

	function filter_kesesuaian()
	{
		$this->load->model("base-app/Kesesuaian");
		$this->load->model("base/Users");
		$this->load->model("base-app/Crud");
		$this->load->model("base-app/Dampak");
		$this->load->model("base-app/Kemungkinan");
		$this->load->model("base-app/MatriksRisiko");

		// $reqBulan =  $this->input->get('reqBulan');

		$reqTahun =  $this->input->get('reqTahun');
		$reqBlok =  $this->input->get('reqBlok');
		$reqDistrik =  $this->input->get('reqDistrik');
		$reqVstatus =  $this->input->get('reqVstatus');
		$reqStatus =  $this->input->get('reqStatus');
		$reqBulan =  $this->input->get('reqBulan');

		$reqPenggunaid= $this->appuserid;
		$appuserkodehak= $this->appuserkodehak;

		$set= new Crud();
		$statement=" AND A.KODE_HAK = '".$appuserkodehak."'";

		$set->selectByParams(array(), -1, -1, $statement);
		// echo $set->query;exit;

		$set->firstRow();
		$reqPenggunaHakId= $set->getField("PENGGUNA_HAK_ID");
		unset($set);

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
		}

		

		$statement="";
		$set= new Dampak();
		$arrdampak= [];
		$set->selectByParams(array(), -1,-1,$statement);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= array();
			$arrdata["DAMPAK_ID"]= $set->getField("DAMPAK_ID");
			$arrdata["NAMA"]=$set->getField("NAMA");
			$arrdata["N_MIN"]=$set->getField("N_MIN");
			$arrdata["N_MAX"]=$set->getField("N_MAX");
			$arrdata["BOBOT"]=$set->getField("BOBOT");
			array_push($arrdampak, $arrdata);
		}
		unset($set);

		$statement="";
		$set= new Kemungkinan();
		$arrkemungkinan= [];
		$set->selectByParams(array(), -1,-1,$statement);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= array();
			$arrdata["KEMUNGKINAN_ID"]= $set->getField("KEMUNGKINAN_ID");
			$arrdata["NAMA"]=$set->getField("NAMA");
			$arrdata["N_MIN"]=$set->getField("N_MIN");
			$arrdata["N_MAX"]=$set->getField("N_MAX");
			$arrdata["BOBOT"]=$set->getField("BOBOT");
			array_push($arrkemungkinan, $arrdata);
		}
		unset($set);


		$statement=" 
		";
		$statementnew=" 
		";
		if(!empty($reqTahun))
		{
			$statementnew .=" AND F.TAHUN = ".$reqTahun;
		}
		if(!empty($reqBulan))
		{
			$statementnew .=" AND F.BULAN = '".$reqBulan."'";
		}
		if(!empty($reqDistrik))
		{
			$statement .=" AND A.DISTRIK_ID = ".$reqDistrik;
		}
		if(!empty($reqBlok))
		{
			$statement .=" AND A.BLOK_UNIT_ID = ".$reqBlok;
		}

		if(!empty($idDistrik))
		{
			$statement .=" AND A.DISTRIK_ID IN (".$idDistrik.")";
		}

		$set= new Kesesuaian();
		$arrset= [];

		$set->selectByParamsNew(array(), -1,-1,$statement," ORDER BY A.KODE_INFO,A.NAMA",$statementnew);
		// echo $set->query;exit;
		$no=1;
		while($set->nextRow())
		{
			$arrdata= array();
			$arrdata["NO"]= $no;
			$arrdata["LIST_AREA_ID"]= $set->getField("LIST_AREA_ID");
			$arrdata["ITEM_ASSESSMENT_DUPLIKAT_ID"]= $set->getField("ITEM_ASSESSMENT_DUPLIKAT_ID");
			$arrdata["AREA_NAMA"]= $set->getField("KODE_INFO")." - ".$set->getField("NAMA");
			$arrdata["AREA_UNIT"]= $set->getField("AREA_UNIT");
			$arrdata["NAMA"]= $set->getField("NAMA");
			$arrdata["JUMLAH_KLAUSUL"]= $set->getField("JUMLAH_KLAUSUL");
			$arrdata["CONFIRM"]= $set->getField("CONFIRM");
			$arrdata["NOT_CONFIRM"]= $set->getField("NOT_CONFIRM");
			$arrdata["PERSEN_CONFIRM"]= $set->getField("PERSEN_CONFIRM");
			$arrdata["PERSEN_NOT_CONFIRM"]= $set->getField("PERSEN_NOT_CONFIRM");
			$arrdata["STATUS_COMPLY"]= $set->getField("STATUS_COMPLY");
			$arrdata["BELUM_ISI"]= $set->getField("BELUM_DIISI");

			$statement=" AND A.LIST_AREA_ID =".$set->getField("LIST_AREA_ID")."  AND A.AREA_UNIT_DETIL_ID= ".$set->getField("AREA_UNIT_DETIL_ID")." AND a.ITEM_ASSESSMENT_DUPLIKAT_ID= ".$set->getField("ITEM_ASSESSMENT_DUPLIKAT_ID");

			$mp= new Kesesuaian();

			$mp->selectByParamsNew(array(), -1,-1,$statement,"",""," AND B1.STATUS_KONFIRMASI  =1
				  AND B4.PROGRAM_ITEM_ASSESSMENT_ID =1");
			// echo $mp->query;
			$mp->firstRow();

			$arrdata["TOTAL_BOBOT_MP"]= $mp->getField("TOTAL_BOBOT");

			$mpnot= new Kesesuaian();

			$mpnot->selectByParamsNew(array(), -1,-1,$statement,"",""," AND B4.PROGRAM_ITEM_ASSESSMENT_ID = 1
				AND B1.STATUS_KONFIRMASI  =1
				  AND B4.PROGRAM_ITEM_ASSESSMENT_ID =1 AND E.STATUS_CONFIRM  =0");
			// echo $mp->query;
			$mpnot->firstRow();

			$arrdata["TOTAL_BOBOT_MP_NOT"]= $mpnot->getField("TOTAL_BOBOT");

			$rating_mp=number_format($mpnot->getField("TOTAL_BOBOT")/ $mp->getField("TOTAL_BOBOT"),2);

			if (!is_numeric($rating_mp)) {
				$arrdata["RATING_MP"]=number_format(0.00,2);
			} else {
				$arrdata["RATING_MP"]=$rating_mp;
			}


			$statement=" AND A.LIST_AREA_ID =".$set->getField("LIST_AREA_ID")."  AND A.AREA_UNIT_DETIL_ID= ".$set->getField("AREA_UNIT_DETIL_ID")." AND a.ITEM_ASSESSMENT_DUPLIKAT_ID= ".$set->getField("ITEM_ASSESSMENT_DUPLIKAT_ID");

			$pp= new Kesesuaian();

			$pp->selectByParamsNew(array(), -1,-1,$statement,""," AND B1.STATUS_KONFIRMASI  =1
				  AND B4.PROGRAM_ITEM_ASSESSMENT_ID =2");
			// echo $pp->query;
			$pp->firstRow();

			$arrdata["TOTAL_BOBOT_PP"]= $pp->getField("TOTAL_BOBOT") ?: 0;


			$ppnot= new Kesesuaian();

			$ppnot->selectByParamsNew(array(), -1,-1,$statement,"",""," AND B1.STATUS_KONFIRMASI  =1
				  AND B4.PROGRAM_ITEM_ASSESSMENT_ID =2 AND E.STATUS_CONFIRM  =0");
			// echo $mp->query;
			$ppnot->firstRow();

			$arrdata["TOTAL_BOBOT_PP_NOT"]= $ppnot->getField("TOTAL_BOBOT") ?: 0;

			$rating_pp=number_format($ppnot->getField("TOTAL_BOBOT")/ $pp->getField("TOTAL_BOBOT"),2);

			if (!is_numeric($rating_pp)) {
				$arrdata["RATING_PP"]=number_format(0.00,2);
			} else {
				$arrdata["RATING_PP"]=$rating_pp;
			} 
			
			$dampak='';
			$dampakid='';

			foreach ($arrdampak as $key => $value) 
			{
				if(($arrdata["RATING_MP"]  >= $value["N_MIN"]) && ( $arrdata["RATING_MP"] <= $value["N_MAX"]))
				{
					$dampak=$value["NAMA"];
					$dampakid=$value["DAMPAK_ID"];
				}
			}

			$arrdata["DAMPAK_ID"]=$dampakid;
			$arrdata["DAMPAK_NAMA"]=$dampak;

			$kemungkinan='';
			$kemungkinanid='';

			foreach ($arrkemungkinan as $keys => $values) 
			{
				// print_r($arrdata["RATING_PP"]." - ".$values["N_MIN"].'</br>');
				if(($arrdata["RATING_PP"]  >= $values["N_MIN"]) && ( $arrdata["RATING_PP"] <= $values["N_MAX"]))
				{
					$kemungkinan=$values["NAMA"];
					$kemungkinanid=$values["KEMUNGKINAN_ID"];
				}
			}

			$arrdata["KEMUNGKINAN_ID"]=$kemungkinanid;
			$arrdata["KEMUNGKINAN_NAMA"]=$kemungkinan;
			$arrdata["RESIKO"]="";
			$arrdata["RISIKO_NAMA"]= "";
			$arrdata["RISIKO_KODE"]= "";
			$arrdata["RISIKO_WARNA"]= "";

			if(!empty($arrdata["DAMPAK_NAMA"]) && !empty($arrdata["KEMUNGKINAN_NAMA"]) )
			{

				$statement=" AND A.DAMPAK_ID =".$arrdata["DAMPAK_ID"]." AND A.KEMUNGKINAN_ID =".$arrdata["KEMUNGKINAN_ID"];

				$risiko= new MatriksRisiko();

				$risiko->selectByParamsLaporan(array(), -1,-1,$statement,"");
				// echo $risiko->query;
				$risiko->firstRow();

				$arrdata["RISIKO_NAMA"]= $risiko->getField("RISIKO");
				$arrdata["RISIKO_KODE"]= $risiko->getField("KODE");
				$arrdata["RISIKO_WARNA"]= $risiko->getField("KODE_WARNA");
			}

			

			$no++;

			array_push($arrset, $arrdata);
		}
		unset($set);

		// print_r($arrset);exit;

		echo json_encode( $arrset, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	

	}

}