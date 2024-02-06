<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class hasil_assessment_json extends CI_Controller {

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
		$this->appuserkodehak= $this->session->userdata("appuserkodehak");

		$this->configtitle= $this->config->config["configtitle"];
	}

	function jumlahitem()
	{
		$this->load->model("base-app/Kesesuaian");
		$statement="";
		
		$reqDistrikId= $this->input->get("reqDistrikId");
		$reqBlok= $this->input->get("reqBlok");
		$reqTahun= $this->input->get("reqTahun");
		$reqStatus= $this->input->get("reqStatus");
		$reqListAreaId= $this->input->get("reqListAreaId");
		$reqBulan= $this->input->get("reqBulan");

		$statement="";
		$statemenstatus="";
		if(!empty($reqDistrikId))
		{
			$statement.=" AND A.DISTRIK_ID=".$reqDistrikId;
		}
		if(!empty($reqBlok))
		{
			$statement.=" AND A.BLOK_UNIT_ID=".$reqBlok;
		}
		if(!empty($reqTahun))
		{
			$statemenstatus.=" AND F.TAHUN=".$reqTahun;
		}
		if($reqStatus==20)
		{
			$statemenstatus=" AND F.V_STATUS=".$reqStatus;
		}
		elseif($reqStatus==100)
		{
			$statemenstatus=" AND F.V_STATUS <> 20";
		}
		if(!empty($reqListAreaId))
		{
			// $statemenstatus.=" AND A.LIST_AREA_ID=".$reqListAreaId;
			$statemenstatus.=" AND A.LIST_AREA_ID IN (".$reqListAreaId.")";
		}
		if(!empty($reqBulan))
		{
			$statemenstatus.=" AND F.BULAN ='".$reqBulan."'";
		}

		$set= new Kesesuaian();
		$arrkesesuaian= [];

		$set->selectByParamsNew(array(), -1,-1,$statement,"","",$statemenstatus);
		// echo $set->query;exit;
		$no=1;
		while($set->nextRow())
		{
			$arrdata= array();
			$arrdata["NO"]= $no;
			$arrdata["AREA_NAMA"]= $set->getField("KODE_INFO")." - ".$set->getField("NAMA");
			$arrdata["AREA_UNIT"]= $set->getField("AREA_UNIT");
			$arrdata["NAMA"]= $set->getField("NAMA");
			$arrdata["JUMLAH_KLAUSUL"]= $set->getField("JUMLAH_KLAUSUL");
			$arrdata["BELUM_DIISI"]= $set->getField("BELUM_DIISI");

			$no++;

			array_push($arrkesesuaian, $arrdata);
		}

		unset($set);

		echo json_encode($arrkesesuaian, JSON_NUMERIC_CHECK);
	}

	function rekapmatrik()
	{
		$this->load->model("base-app/Kesesuaian");
		$this->load->model("base-app/MatriksRisiko");
		$this->load->model("base-app/Dampak");
		$this->load->model("base-app/Kemungkinan");
		$statement="";
		
		$reqDistrikId= $this->input->get("reqDistrikId");
		$reqBlok= $this->input->get("reqBlok");
		$reqTahun= $this->input->get("reqTahun");
		$reqStatus= $this->input->get("reqStatus");
		$reqListAreaId= $this->input->get("reqListAreaId");
		$reqBulan= $this->input->get("reqBulan");

		

		$set= new Dampak();
		$arrdampak= [];

		$statement=" AND A.STATUS IS NULL AND EXISTS(SELECT B.DAMPAK_ID FROM MATRIKS_RISIKO B WHERE B.DAMPAK_ID=A.DAMPAK_ID AND B.STATUS IS NULL)";
		$set->selectByParams(array(), -1,-1,$statement);
		// echo $set->query;exit;
		$jmldampak=1;
		while($set->nextRow())
		{
			$arrdata= array();
			$arrdata["id"]= $set->getField("DAMPAK_ID");
			$arrdata["text"]= $set->getField("NAMA");
			$arrdata["DAMPAK_ID"]= $set->getField("DAMPAK_ID");
			$arrdata["NAMA"]=$set->getField("NAMA");
			$arrdata["N_MIN"]=$set->getField("N_MIN");
			$arrdata["N_MAX"]=$set->getField("N_MAX");
			$arrdata["BOBOT"]=$set->getField("BOBOT");
			$jmldampak++;
			array_push($arrdampak, $arrdata);
		}
		unset($set);

		$set= new Kemungkinan();
		$arrkemungkinan= [];

		$statement=" AND A.STATUS IS NULL AND EXISTS(SELECT B.KEMUNGKINAN_ID FROM MATRIKS_RISIKO B WHERE B.KEMUNGKINAN_ID=A.KEMUNGKINAN_ID AND B.STATUS IS NULL)";
		$set->selectByParams(array(), -1,-1,$statement);
		// echo $set->query;exit;
		$jmlkemungkinan=0;
		while($set->nextRow())
		{
			$arrdata= array();
			$arrdata["id"]= $set->getField("KEMUNGKINAN_ID");
			$arrdata["text"]= $set->getField("NAMA");
			$arrdata["KEMUNGKINAN_ID"]= $set->getField("KEMUNGKINAN_ID");
			$arrdata["NAMA"]=$set->getField("NAMA");
			$arrdata["N_MIN"]=$set->getField("N_MIN");
			$arrdata["N_MAX"]=$set->getField("N_MAX");
			$arrdata["BOBOT"]=$set->getField("BOBOT");
			$jmlkemungkinan++;
			array_push($arrkemungkinan, $arrdata);
		}
		unset($set);

		$statement="";
		$statemenstatus="";
		if(!empty($reqDistrikId))
		{
			$statement.=" AND A.DISTRIK_ID=".$reqDistrikId;
		}
		if(!empty($reqBlok))
		{
			$statement.=" AND A.BLOK_UNIT_ID=".$reqBlok;
		}
		if(!empty($reqTahun))
		{
			$statemenstatus.=" AND F.TAHUN=".$reqTahun;
		}
		if($reqStatus==20)
		{
			$statemenstatus=" AND F.V_STATUS=".$reqStatus;
		}
		elseif($reqStatus==100)
		{
			$statemenstatus=" AND F.V_STATUS <> 20";
		}
		if(!empty($reqListAreaId))
		{
			$statemenstatus.=" AND A.LIST_AREA_ID IN (".$reqListAreaId.")";
		}
		if(!empty($reqBulan))
		{
			$statemenstatus.=" AND F.BULAN ='".$reqBulan."'";
		}

		$set= new Kesesuaian();
		$arrrekap= [];

		$set->selectByParamsNew(array(), -1,-1,$statement," ORDER BY A.KODE_INFO,A.NAMA ","",$statemenstatus);
		// echo $set->query;exit;
		$no=1;
		$jumlahcomply=0;
		$jumlahklausul=0;
		$jumlahconfirm=0;
		$jumlahnotconfirm=0;

		while($set->nextRow())
		{
			$arrdata= array();
			$arrdata["NO"]= $no;
			$arrdata["AREA_NAMA"]= $set->getField("KODE_INFO")." - ".$set->getField("NAMA");
			$arrdata["AREA_UNIT"]= $set->getField("AREA_UNIT");
			$arrdata["NAMA"]= $set->getField("NAMA");
			$arrdata["JUMLAH_KLAUSUL"]= $set->getField("JUMLAH_KLAUSUL");
			$arrdata["CONFIRM"]= $set->getField("CONFIRM");
			$arrdata["NOT_CONFIRM"]= $set->getField("NOT_CONFIRM");
			$arrdata["PERSEN_CONFIRM"]= $set->getField("PERSEN_CONFIRM");
			$arrdata["PERSEN_NOT_CONFIRM"]= $set->getField("PERSEN_NOT_CONFIRM");
			$arrdata["STATUS_COMPLY"]= $set->getField("STATUS_COMPLY");

			if($set->getField("STATUS_COMPLY") == "COMPLY")
			{
				$jumlahcomply+=1;
			}


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
			// echo $mp->query;
			$pp->firstRow();

			$arrdata["TOTAL_BOBOT_PP"]= $pp->getField("TOTAL_BOBOT");


			$ppnot= new Kesesuaian();

			$ppnot->selectByParamsNew(array(), -1,-1,$statement,"",""," AND B1.STATUS_KONFIRMASI  =1
				  AND B4.PROGRAM_ITEM_ASSESSMENT_ID =2 AND E.STATUS_CONFIRM  =0");
			// echo $mp->query;
			$ppnot->firstRow();

			$arrdata["TOTAL_BOBOT_PP_NOT"]= $ppnot->getField("TOTAL_BOBOT");

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
			$arrdata["RISIKO_ID"]="";
			$arrdata["RISIKO_NAMA"]= "";
			$arrdata["RISIKO_KODE"]= "";
			$arrdata["RISIKO_WARNA"]= "";

			if(!empty($arrdata["DAMPAK_NAMA"]) && !empty($arrdata["KEMUNGKINAN_NAMA"]) )
			{

				$statement=" AND A.DAMPAK_ID =".$arrdata["DAMPAK_ID"]." AND A.KEMUNGKINAN_ID =".$arrdata["KEMUNGKINAN_ID"];

				$risiko= new MatriksRisiko();

				$risiko->selectByParamsLaporan(array(), -1,-1,$statement,"");
                // echo $mp->query;
				$risiko->firstRow();

				$arrdata["RISIKO_ID"]= $risiko->getField("RISIKO_ID");
				$arrdata["RISIKO_NAMA"]= $risiko->getField("RISIKO");
				$arrdata["RISIKO_KODE"]= $risiko->getField("KODE");
				$arrdata["RISIKO_WARNA"]= $risiko->getField("KODE_WARNA");
			}

			$no++;

			array_push($arrrekap, $arrdata);
		}

		// print_r($arrrekap);exit;


		echo json_encode($arrrekap, JSON_NUMERIC_CHECK);
	}

	function rekaptingkat()
	{
		$this->load->model("base-app/Kesesuaian");
		$this->load->model("base-app/MatriksRisiko");
		$this->load->model("base-app/Dampak");
		$this->load->model("base-app/Kemungkinan");
		$statement="";
		
		$reqDistrikId= $this->input->get("reqDistrikId");
		$reqBlok= $this->input->get("reqBlok");
		$reqTahun= $this->input->get("reqTahun");
		$reqStatus= $this->input->get("reqStatus");
		$reqListAreaId= $this->input->get("reqListAreaId");
		$reqBulan= $this->input->get("reqBulan");
		

		$set= new Dampak();
		$arrdampak= [];

		$statement=" AND A.STATUS IS NULL AND EXISTS(SELECT B.DAMPAK_ID FROM MATRIKS_RISIKO B WHERE B.DAMPAK_ID=A.DAMPAK_ID AND B.STATUS IS NULL)";
		$set->selectByParams(array(), -1,-1,$statement);
		// echo $set->query;exit;
		$jmldampak=1;
		while($set->nextRow())
		{
			$arrdata= array();
			$arrdata["id"]= $set->getField("DAMPAK_ID");
			$arrdata["text"]= $set->getField("NAMA");
			$arrdata["DAMPAK_ID"]= $set->getField("DAMPAK_ID");
			$arrdata["NAMA"]=$set->getField("NAMA");
			$arrdata["N_MIN"]=$set->getField("N_MIN");
			$arrdata["N_MAX"]=$set->getField("N_MAX");
			$arrdata["BOBOT"]=$set->getField("BOBOT");
			$jmldampak++;
			array_push($arrdampak, $arrdata);
		}
		unset($set);

		$set= new Kemungkinan();
		$arrkemungkinan= [];

		$statement=" AND A.STATUS IS NULL AND EXISTS(SELECT B.KEMUNGKINAN_ID FROM MATRIKS_RISIKO B WHERE B.KEMUNGKINAN_ID=A.KEMUNGKINAN_ID AND B.STATUS IS NULL)";
		$set->selectByParams(array(), -1,-1,$statement);
		// echo $set->query;exit;
		$jmlkemungkinan=0;
		while($set->nextRow())
		{
			$arrdata= array();
			$arrdata["id"]= $set->getField("KEMUNGKINAN_ID");
			$arrdata["text"]= $set->getField("NAMA");
			$arrdata["KEMUNGKINAN_ID"]= $set->getField("KEMUNGKINAN_ID");
			$arrdata["NAMA"]=$set->getField("NAMA");
			$arrdata["N_MIN"]=$set->getField("N_MIN");
			$arrdata["N_MAX"]=$set->getField("N_MAX");
			$arrdata["BOBOT"]=$set->getField("BOBOT");
			$jmlkemungkinan++;
			array_push($arrkemungkinan, $arrdata);
		}
		unset($set);

		$statement="";
		$statemenstatus="";
		if(!empty($reqDistrikId))
		{
			$statement.=" AND A.DISTRIK_ID=".$reqDistrikId;
		}
		if(!empty($reqBlok))
		{
			$statement.=" AND A.BLOK_UNIT_ID=".$reqBlok;
		}
		if(!empty($reqTahun))
		{
			$statemenstatus.=" AND F.TAHUN=".$reqTahun;
		}
		if($reqStatus==20)
		{
			$statemenstatus=" AND F.V_STATUS=".$reqStatus;
		}
		elseif($reqStatus==100)
		{
			$statemenstatus=" AND F.V_STATUS <> 20";
		}
		if(!empty($reqListAreaId))
		{
			// $statemenstatus.=" AND A.LIST_AREA_ID=".$reqListAreaId;
			$statemenstatus.=" AND A.LIST_AREA_ID IN (".$reqListAreaId.")";
		}

		if(!empty($reqBulan))
		{
			$statemenstatus.=" AND F.BULAN ='".$reqBulan."'";
		}

		$set= new Kesesuaian();
		$arrrekap= [];

		$set->selectByParamsNew(array(), -1,-1,$statement,"","",$statemenstatus);
		// echo $set->query;exit;
		$no=1;
		$jumlahcomply=0;
		$jumlahklausul=0;
		$jumlahconfirm=0;
		$jumlahnotconfirm=0;

		while($set->nextRow())
		{
			$arrdata= array();
			$arrdata["NO"]= $no;
			$arrdata["AREA_NAMA"]= $set->getField("KODE_INFO")." - ".$set->getField("NAMA");
			$arrdata["AREA_UNIT"]= $set->getField("AREA_UNIT");
			$arrdata["NAMA"]= $set->getField("NAMA");
			$arrdata["JUMLAH_KLAUSUL"]= $set->getField("JUMLAH_KLAUSUL");
			$arrdata["CONFIRM"]= $set->getField("CONFIRM");
			$arrdata["NOT_CONFIRM"]= $set->getField("NOT_CONFIRM");
			$arrdata["PERSEN_CONFIRM"]= $set->getField("PERSEN_CONFIRM");
			$arrdata["PERSEN_NOT_CONFIRM"]= $set->getField("PERSEN_NOT_CONFIRM");
			$arrdata["STATUS_COMPLY"]= $set->getField("STATUS_COMPLY");

			if($set->getField("STATUS_COMPLY") == "COMPLY")
			{
				$jumlahcomply+=1;
			}

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
            // echo $mp->query;
			$pp->firstRow();

			$arrdata["TOTAL_BOBOT_PP"]= $pp->getField("TOTAL_BOBOT");


			$ppnot= new Kesesuaian();

			$ppnot->selectByParamsNew(array(), -1,-1,$statement,"",""," AND B1.STATUS_KONFIRMASI  =1
				AND B4.PROGRAM_ITEM_ASSESSMENT_ID =2 AND E.STATUS_CONFIRM  =0");
            // echo $mp->query;
			$ppnot->firstRow();

			$arrdata["TOTAL_BOBOT_PP_NOT"]= $ppnot->getField("TOTAL_BOBOT");

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
			$arrdata["RISIKO_ID"]="";
			$arrdata["RISIKO_NAMA"]= "";
			$arrdata["RISIKO_KODE"]= "";
			$arrdata["RISIKO_WARNA"]= "";

			if(!empty($arrdata["DAMPAK_NAMA"]) && !empty($arrdata["KEMUNGKINAN_NAMA"]) )
			{

				$statement=" AND A.DAMPAK_ID =".$arrdata["DAMPAK_ID"]." AND A.KEMUNGKINAN_ID =".$arrdata["KEMUNGKINAN_ID"];

				$risiko= new MatriksRisiko();

				$risiko->selectByParamsLaporan(array(), -1,-1,$statement,"");
                // echo $mp->query;
				$risiko->firstRow();

				$arrdata["RISIKO_ID"]= $risiko->getField("RISIKO_ID");
				$arrdata["RISIKO_NAMA"]= $risiko->getField("RISIKO");
				$arrdata["RISIKO_KODE"]= $risiko->getField("KODE");
				$arrdata["RISIKO_WARNA"]= $risiko->getField("KODE_WARNA");
			}

			$no++;

			array_push($arrrekap, $arrdata);
		}

		$jumlahrendah=0;
		$jumlahmoderat=0;
		$jumlahtinggi=0;
		$jumlahsangattinggi=0;
		$jumlahekstrem=0;

		if(!empty($arrrekap))
		{
			$keysrendah = array_keys(array_column($arrrekap, 'RISIKO_ID'), 1);
			$arrrendah = array_map(function($k) use ($arrrekap){return $arrrekap[$k];}, $keysrendah);
			$jumlahrendah= count($arrrendah);

			$keysmoderat = array_keys(array_column($arrrekap, 'RISIKO_ID'), 2);
			$arrmoderat = array_map(function($k) use ($arrrekap){return $arrrekap[$k];}, $keysmoderat);
			$jumlahmoderat= count($arrmoderat);

			$keystinggi = array_keys(array_column($arrrekap, 'RISIKO_ID'), 3);
			$arrtinggi = array_map(function($k) use ($arrrekap){return $arrrekap[$k];}, $keystinggi);
			$jumlahtinggi= count($arrtinggi);

			$keyssangattinggi = array_keys(array_column($arrrekap, 'RISIKO_ID'), 4);
			$arrsangattinggi = array_map(function($k) use ($arrrekap){return $arrrekap[$k];}, $keyssangattinggi);
			$jumlahsangattinggi= count($arrsangattinggi);

			$keysekstrem = array_keys(array_column($arrrekap, 'RISIKO_ID'), 5);
			$arrekstrem = array_map(function($k) use ($arrrekap){return $arrrekap[$k];}, $keysekstrem);
			$jumlahekstrem= count($arrekstrem);
		}

		// print_r($keysekstrem);exit;


		$jumlahconfirm = array_sum(array_column($arrrekap, 'CONFIRM'));
		$jumlahnotconfirm = array_sum(array_column($arrrekap, 'NOT_CONFIRM'));


		$jumlahklausul=$no-1;
		$percomply=0;
		$arrcmp=[];
		$jumlahklausulassessment=$jumlahconfirm+$jumlahnotconfirm;
		$arrcmp["PERC_COMPLY"]=0;


		if(!empty($jumlahcomply))
		{
			$percomply=round($jumlahcomply/$jumlahklausul * 100 ,1);
			$arrcmp["PERC_COMPLY"]=$percomply;
		}
		// $arrcmpdata=[];
		$arrcmp["JUMLAH_AREA_TOTAL"]=$jumlahklausul;
		$arrcmp["JUMLAH_KLS"]=$jumlahklausulassessment;
		$arrcmp["JUMLAH_AREA_RENDAH"]=$jumlahrendah;
		$arrcmp["JUMLAH_AREA_MODERAT"]=$jumlahmoderat;
		$arrcmp["JUMLAH_AREA_TINGGI"]=$jumlahtinggi;
		$arrcmp["JUMLAH_AREA_SANGAT_TINGGI"]=$jumlahsangattinggi;
		$arrcmp["JUMLAH_AREA_EKSTREM"]=$jumlahekstrem;


		echo json_encode($arrcmp, JSON_NUMERIC_CHECK);
	}

	function rekapkategori()
	{
		$this->load->model("base-app/HasilAssessment");
		$statement="";
		
		$reqDistrikId= $this->input->get("reqDistrikId");
		$reqBlok= $this->input->get("reqBlok");
		$reqTahun= $this->input->get("reqTahun");
		$reqStatus= $this->input->get("reqStatus");
		$reqListAreaId= $this->input->get("reqListAreaId");
		$reqBulan= $this->input->get("reqBulan");


		$statement="";
		$statemenstatus="";
		if(!empty($reqDistrikId))
		{
			$statement.=" AND C.DISTRIK_ID=".$reqDistrikId;
		}
		if(!empty($reqBlok))
		{
			$statement.=" AND C.BLOK_UNIT_ID=".$reqBlok;
		}
		if(!empty($reqTahun))
		{
			$statement.=" AND C.TAHUN=".$reqTahun;
		}
		if($reqStatus==20)
		{
			$statement=" AND C.V_STATUS=".$reqStatus;
		}
		elseif($reqStatus==100)
		{
			$statement=" AND C.V_STATUS <> 20";
		}

		if(!empty($reqBulan))
		{
			$statement.=" AND C.BULAN ='".$reqBulan."'";
		}

		$set= new HasilAssessment();
		$arrRekomendasi= [];

		$set->selectByParamsRekomendasi(array(), -1,-1,$statement);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= array();
			$arrdata["KATEGORI_INFO"]= $set->getField("KATEGORI_INFO");
			$arrdata["JUMLAH_REKOMENDASI"]= $set->getField("JUMLAH_REKOMENDASI");
			array_push($arrRekomendasi, $arrdata);
		}
		unset($set);

		echo json_encode($arrRekomendasi, JSON_NUMERIC_CHECK);
	}

	function rekapjenis()
	{
		$this->load->model("base-app/HasilAssessment");
		$statement="";
		
		$reqDistrikId= $this->input->get("reqDistrikId");
		$reqBlok= $this->input->get("reqBlok");
		$reqTahun= $this->input->get("reqTahun");
		$reqStatus= $this->input->get("reqStatus");
		$reqListAreaId= $this->input->get("reqListAreaId");
		$reqBulan= $this->input->get("reqBulan");


		$statement="";
		$statemenstatus="";
		if(!empty($reqDistrikId))
		{
			$statement.=" AND C.DISTRIK_ID=".$reqDistrikId;
		}
		if(!empty($reqBlok))
		{
			$statement.=" AND C.BLOK_UNIT_ID=".$reqBlok;
		}
		if(!empty($reqTahun))
		{
			$statement.=" AND C.TAHUN=".$reqTahun;
		}
		if($reqStatus==20)
		{
			$statement=" AND C.V_STATUS=".$reqStatus;
		}
		elseif($reqStatus==100)
		{
			$statement=" AND C.V_STATUS <> 20";
		}

		if(!empty($reqBulan))
		{
			$statement.=" AND C.BULAN ='".$reqBulan."'";
		}

		$set= new HasilAssessment();
		$arrJenisRekomendasi= [];

		$set->selectByParamsJenisRekomendasi(array(), -1,-1,$statement);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= array();
			$arrdata["JENIS_INFO"]= $set->getField("JENIS_INFO");
			$arrdata["JUMLAH_JENIS"]= $set->getField("JUMLAH_JENIS");
			array_push($arrJenisRekomendasi, $arrdata);
		}
		unset($set);


		echo json_encode($arrJenisRekomendasi, JSON_NUMERIC_CHECK);
	}

	function rekapprioritas()
	{
		$this->load->model("base-app/HasilAssessment");
		$statement="";
		
		$reqDistrikId= $this->input->get("reqDistrikId");
		$reqBlok= $this->input->get("reqBlok");
		$reqTahun= $this->input->get("reqTahun");
		$reqStatus= $this->input->get("reqStatus");
		$reqListAreaId= $this->input->get("reqListAreaId");
		$reqBulan= $this->input->get("reqBulan");


		$statement="";
		$statemenstatus="";
		if(!empty($reqDistrikId))
		{
			$statement.=" AND C.DISTRIK_ID=".$reqDistrikId;
		}
		if(!empty($reqBlok))
		{
			$statement.=" AND C.BLOK_UNIT_ID=".$reqBlok;
		}
		if(!empty($reqTahun))
		{
			$statement.=" AND C.TAHUN=".$reqTahun;
		}
		if($reqStatus==20)
		{
			$statement=" AND C.V_STATUS=".$reqStatus;
		}
		elseif($reqStatus==100)
		{
			$statement=" AND C.V_STATUS <> 20";
		}

		if(!empty($reqBulan))
		{
			$statement.=" AND C.BULAN ='".$reqBulan."'";
		}

		$set= new HasilAssessment();
		$arrPrioritasRekomendasi= [];

		$set->selectByParamsPrioritasRekomendasi(array(), -1,-1,$statement);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= array();
			$arrdata["PRIORITAS_INFO"]= $set->getField("PRIORITAS_INFO");
			$arrdata["PRIORITAS_REKOMENDASI"]= $set->getField("PRIORITAS_REKOMENDASI");
			array_push($arrPrioritasRekomendasi, $arrdata);
		}
		unset($set);



		echo json_encode($arrPrioritasRekomendasi, JSON_NUMERIC_CHECK);
	}


	function grafik_tingkat()
	{
		$this->load->model("base-app/Kesesuaian");

		$reqDistrikId= $this->input->get("reqDistrikId");
		$reqBlok= $this->input->get("reqBlok");
		$reqTahun= $this->input->get("reqTahun");
		$reqStatus= $this->input->get("reqStatus");
		$reqListAreaId= $this->input->get("reqListAreaId");
		$reqBulan= $this->input->get("reqBulan");		
		
		$jumlahklausul=0;
		$jumlahcomply=0;
		$jumlahnotcomply=0;

		$statement="";
		$statemenstatus="";
		if(!empty($reqDistrikId))
		{
			$statement.=" AND A.DISTRIK_ID=".$reqDistrikId;
		}
		if(!empty($reqBlok))
		{
			$statement.=" AND A.BLOK_UNIT_ID=".$reqBlok;
		}
		if(!empty($reqTahun))
		{
			$statemenstatus.=" AND F.TAHUN=".$reqTahun;
		}
		if($reqStatus==20)
		{
			$statemenstatus=" AND F.V_STATUS=".$reqStatus;
		}
		elseif($reqStatus==100)
		{
			$statemenstatus=" AND F.V_STATUS <> 20";
		}
		if(!empty($reqListAreaId))
		{
			// $statemenstatus.=" AND A.LIST_AREA_ID=".$reqListAreaId;
			$statemenstatus.=" AND A.LIST_AREA_ID IN (".$reqListAreaId.")";
		}

		if(!empty($reqBulan))
		{
			$statemenstatus.=" AND F.BULAN ='".$reqBulan."'";
		}

		$set= new Kesesuaian();
		$arrgrafik= array();

		$set->selectByParamsNew(array(), -1,-1,$statement,"","",$statemenstatus);
		// echo $set->query;exit;
		$x=0;
		while($set->nextRow())
		{
			if($set->getField("STATUS_COMPLY") == "COMPLY")
			{
				$jumlahcomply+=1;
			}
			else if($set->getField("STATUS_COMPLY") == "NOT COMPLY")
			{
				$jumlahnotcomply+=1;
			}
			$x++;

		}
		$jumlahklausul=$x;

		$percomply=0;
		if(!empty($jumlahcomply))
		{
			$percomply=round($jumlahcomply/$jumlahklausul * 100 ,1);
			
		}

		if(!empty($jumlahnotcomply))
		{
			$pernotcomply=round($jumlahnotcomply/$jumlahklausul * 100 ,1);
		}

		$arrgrafikgol= array();

		$arrdata= [];
		$arrdata["name"]= "Compliance Percentage (%)";
		$arrdata["x"]= 0;
		$arrdata["y"]= $percomply;
		$arrdata["color"]= '#00B050';
		array_push($arrgrafik, $arrdata);

		$arrdata["name"]= "Not Percentage (%)";
		$arrdata["x"]= 0;
		$arrdata["y"]= $pernotcomply;
		$arrdata["color"]= '#FFFF00';

		array_push($arrgrafik, $arrdata);

		echo json_encode($arrgrafik, JSON_NUMERIC_CHECK);
	}

	function grafik_jenis_rekomendasi()
	{
		$this->load->model("base-app/HasilAssessment");
		
		$reqDistrikId= $this->input->get("reqDistrikId");
		$reqBlok= $this->input->get("reqBlok");
		$reqTahun= $this->input->get("reqTahun");
		$reqStatus= $this->input->get("reqStatus");
		$reqListAreaId= $this->input->get("reqListAreaId");
		$reqBulan= $this->input->get("reqBulan");


		$statement="";
		$statemenstatus="";
		if(!empty($reqDistrikId))
		{
			$statement.=" AND C.DISTRIK_ID=".$reqDistrikId;
		}
		if(!empty($reqBlok))
		{
			$statement.=" AND C.BLOK_UNIT_ID=".$reqBlok;
		}
		if(!empty($reqTahun))
		{
			$statement.=" AND C.TAHUN=".$reqTahun;
		}
		if($reqStatus==20)
		{
			$statement=" AND C.V_STATUS=".$reqStatus;
		}
		elseif($reqStatus==100)
		{
			$statement=" AND C.V_STATUS <> 20";
		}

		$statemenstatus="";
		if(!empty($reqBulan))
		{
			$statement.=" AND C.BULAN ='".$reqBulan."'";
		}


		$set= new HasilAssessment();
		$arrgrafik= [];

		// echo $statementstatus;

		$set->selectByParamsJenisRekomendasi(array(), -1,-1,$statement,$statementstatus);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= array();
			$arrdata["JENIS_INFO"]= $set->getField("JENIS_INFO");
			$arrdata["JUMLAH_JENIS"]= $set->getField("JUMLAH_JENIS");
			$arrdata["name"]= $set->getField("JENIS_INFO");
			$arrdata["y"]= $set->getField("JUMLAH_JENIS");
			array_push($arrgrafik, $arrdata);
		}
		unset($set);


		echo json_encode($arrgrafik, JSON_NUMERIC_CHECK);
	}

	function grafik_kategori_rekomendasi()
	{
		$this->load->model("base-app/HasilAssessment");
		$statement="";

		$set= new HasilAssessment();
		$arrgrafik= [];

		$reqDistrikId= $this->input->get("reqDistrikId");
		$reqBlok= $this->input->get("reqBlok");
		$reqTahun= $this->input->get("reqTahun");
		$reqStatus= $this->input->get("reqStatus");
		$reqListAreaId= $this->input->get("reqListAreaId");
		$reqBulan= $this->input->get("reqBulan");

		$statement="";
		$statemenstatus="";
		if(!empty($reqDistrikId))
		{
			$statement.=" AND C.DISTRIK_ID=".$reqDistrikId;
		}
		if(!empty($reqBlok))
		{
			$statement.=" AND C.BLOK_UNIT_ID=".$reqBlok;
		}
		if(!empty($reqTahun))
		{
			$statement.=" AND C.TAHUN=".$reqTahun;
		}
		if($reqStatus==20)
		{
			$statement=" AND C.V_STATUS=".$reqStatus;
		}
		elseif($reqStatus==100)
		{
			$statement=" AND C.V_STATUS <> 20";
		}

		if(!empty($reqBulan))
		{
			$statement.=" AND C.BULAN ='".$reqBulan."'";
		}


		$set->selectByParamsRekomendasi(array(), -1,-1,$statement);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= array();
			$arrdata["KATEGORI_INFO"]= $set->getField("KATEGORI_INFO");
			$arrdata["JUMLAH_REKOMENDASI"]= $set->getField("JUMLAH_REKOMENDASI");
			$arrdata["name"]= $set->getField("KATEGORI_INFO");
			$arrdata["y"]= $set->getField("JUMLAH_REKOMENDASI");
			array_push($arrgrafik, $arrdata);
		}
		unset($set);
		

		echo json_encode($arrgrafik, JSON_NUMERIC_CHECK);
	}

	function grafik_prioritas_rekomendasi()
	{
		$this->load->model("base-app/HasilAssessment");
		$statement="";

		$set= new HasilAssessment();
		$arrgrafik= [];

		$reqDistrikId= $this->input->get("reqDistrikId");
		$reqBlok= $this->input->get("reqBlok");
		$reqTahun= $this->input->get("reqTahun");
		$reqStatus= $this->input->get("reqStatus");
		$reqListAreaId= $this->input->get("reqListAreaId");
		$reqBulan= $this->input->get("reqBulan");

		$statement="";
		$statemenstatus="";
		if(!empty($reqDistrikId))
		{
			$statement.=" AND C.DISTRIK_ID=".$reqDistrikId;
		}
		if(!empty($reqBlok))
		{
			$statement.=" AND C.BLOK_UNIT_ID=".$reqBlok;
		}
		if(!empty($reqTahun))
		{
			$statement.=" AND C.TAHUN=".$reqTahun;
		}
		if($reqStatus==20)
		{
			$statement=" AND C.V_STATUS=".$reqStatus;
		}
		elseif($reqStatus==100)
		{
			$statement=" AND C.V_STATUS <> 20";
		}

		if(!empty($reqBulan))
		{
			$statement.=" AND C.BULAN ='".$reqBulan."'";
		}

		if(!empty($reqListAreaId))
		{
			// $statement.=" AND C.LIST_AREA_ID=".$reqListAreaId;
			$statemenstatus.=" AND C.LIST_AREA_ID IN (".$reqListAreaId.")";
		}
		$set->selectByParamsPrioritasRekomendasi(array(), -1,-1,$statement);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= array();
			$arrdata["PRIORITAS_INFO"]= $set->getField("PRIORITAS_INFO");
			$arrdata["PRIORITAS_REKOMENDASI"]= $set->getField("PRIORITAS_REKOMENDASI");
			$arrdata["name"]= $set->getField("PRIORITAS_INFO");
			$arrdata["y"]= $set->getField("PRIORITAS_REKOMENDASI");
			array_push($arrgrafik, $arrdata);
		}
		unset($set);
		

		echo json_encode($arrgrafik, JSON_NUMERIC_CHECK);
	}

	function grafik_kesesuaian()
	{
		$this->load->model("base-app/Kesesuaian");
		$statement="";

		$set= new Kesesuaian();
		$arrgrafik= [];

		$reqDistrikId= $this->input->get("reqDistrikId");
		$reqBlok= $this->input->get("reqBlok");
		$reqTahun= $this->input->get("reqTahun");
		$reqStatus= $this->input->get("reqStatus");
		$reqListAreaId= $this->input->get("reqListAreaId");
		$reqBulan= $this->input->get("reqBulan");

		$statement="";
		$statemenstatus="";
		if(!empty($reqDistrikId))
		{
			$statement.=" AND A.DISTRIK_ID=".$reqDistrikId;
		}
		if(!empty($reqBlok))
		{
			$statement.=" AND A.BLOK_UNIT_ID=".$reqBlok;
		}
		if(!empty($reqTahun))
		{
			$statemenstatus.=" AND F.TAHUN=".$reqTahun;
		}
		if($reqStatus==20)
		{
			$statemenstatus=" AND F.V_STATUS=".$reqStatus;
		}
		elseif($reqStatus==100)
		{
			$statemenstatus=" AND F.V_STATUS <> 20";
		}
		if(!empty($reqListAreaId))
		{
			// $statemenstatus.=" AND A.LIST_AREA_ID=".$reqListAreaId;
			$statemenstatus.=" AND A.LIST_AREA_ID IN (".$reqListAreaId.")";
		}

		if(!empty($reqBulan))
		{
			$statemenstatus.=" AND F.BULAN ='".$reqBulan."'";
		}
		
		$set->selectByParamsNew(array(), -1,-1,$statement,"","",$statemenstatus);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= array();
			// $arrdata["name"]= $set->getField("KODE_INFO")." - ".$set->getField("NAMA");
			$arrdata["name"]= $set->getField("NAMA");
			$arrdata["AREA_UNIT"]= $set->getField("AREA_UNIT");
			$arrdata["PERSEN_CONFIRM"]= [$set->getField("PERSEN_CONFIRM")];
			$arrdata["PERSEN_NOT_CONFIRM"]= [$set->getField("PERSEN_NOT_CONFIRM")];
			array_push($arrgrafik, $arrdata);
		}
		unset($set);
		

		echo json_encode($arrgrafik, JSON_NUMERIC_CHECK);
	}


	


}
?>