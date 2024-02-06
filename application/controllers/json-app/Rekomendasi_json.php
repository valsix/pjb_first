<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class rekomendasi_json extends CI_Controller
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

		$this->configtitle= $this->config->config["configtitle"];
		// print_r($this->configtitle);exit;
	}

	function json()
	{
		$this->load->model("base-app/OutliningAssessment");

		$set= new OutliningAssessment();

		if ( isset( $_REQUEST['columnsDef'] ) && is_array( $_REQUEST['columnsDef'] ) ) {
			$columnsDefault = [];
			foreach ( $_REQUEST['columnsDef'] as $field ) {
				$columnsDefault[ $field ] = "true";
			}
		}
		// print_r($columnsDefault);exit;

		$displaystart= -1;
		$displaylength= -1;

		$arrinfodata= [];

		$reqPencarian= $this->input->get("reqPencarian");
		$reqStatus= $this->input->get("reqStatus");
		$reqDistrik= $this->input->get("reqDistrik");
		$reqBlokId= $this->input->get("reqBlokId");
		$reqUnitMesinId= $this->input->get("reqUnitMesinId");
		$reqBulan= $this->input->get("reqBulan");
		$reqTahun= $this->input->get("reqTahun");
		$reqItemAssessmentId= $this->input->get("reqItemAssessmentId");

		$statement="  
			AND EXISTS
			(
				SELECT A.OUTLINING_ASSESSMENT_ID FROM OUTLINING_ASSESSMENT_AREA_DETIL B  
				WHERE A.OUTLINING_ASSESSMENT_ID=B.OUTLINING_ASSESSMENT_ID AND B.STATUS_CONFIRM = 0
			)  ";
		$searchJson= "";
		if(!empty($reqPencarian))
		{
			$searchJson= " 
			AND 
			(
				UPPER(A.NAMA) LIKE '%".strtoupper($reqPencarian)."%'
				OR UPPER(A.NAMA) LIKE '%".strtoupper($reqPencarian)."%'
			)";
		}

		// if(!empty($reqStatus))
		// {
		// 	if($reqStatus== 'NULL')
		// 	{
		// 		$statement .= " AND A.STATUS IS NULL";
		// 	}
		// 	else
		// 	{
		// 		$statement .= " AND A.STATUS =".$reqStatus;
		// 	}
			
		// }

		if(!empty($reqDistrik))
		{
			$statement .= " AND J.DISTRIK_ID =".$reqDistrik;
			
		}

		if(!empty($reqBlokId))
		{
			$statement .= " AND K.BLOK_UNIT_ID =".$reqBlokId;
			
		}

		if(!empty($reqUnitMesinId))
		{
			$statement .= " AND L.UNIT_MESIN_ID =".$reqUnitMesinId;
			
		}

		if(!empty($reqBulan))
		{
			$statement .= " AND B.BULAN ='".$reqBulan."'";
		}

		if(!empty($reqTahun))
		{
			$statement .= " AND B.TAHUN ='".$reqTahun."'";
		}

		if(!empty($reqItemAssessmentId))
		{
			$statement .= " AND C.ITEM_ASSESSMENT_FORMULIR_ID ='".$reqItemAssessmentId."'";
		}

		$sOrder = " ORDER BY A.OUTLINING_ASSESSMENT_ID";
		$set->selectByParamsRekomendasiMonitoring(array(), $dsplyRange, $dsplyStart, $statement.$searchJson, $sOrder);

		// echo $set->query;exit;
		$infobatasdetil= $_REQUEST['start'] + $_REQUEST['length'];
		$infonomor= 0;
		while ($set->nextRow()) 
		{
			$infonomor++;

			$row= [];
			foreach($columnsDefault as $valkey => $valitem) 
			{
				if ($valkey == "SORDERDEFAULT")
				{
					$row[$valkey]= $set->getField("NAMA");
				}
				else if ($valkey == "NO")
				{
					$row[$valkey]= $infonomor;
				}
				else if ($valkey == "BULAN_INFO")
				{
					$row[$valkey]= getNameMonthNew($set->getField("BULAN"));
				}
				else
					$row[$valkey]= $set->getField($valkey);
			}
			array_push($arrinfodata, $row);
		}

		// get all raw data
		$alldata = $arrinfodata;
		// print_r($alldata);exit;

		$data = [];
		// internal use; filter selected columns only from raw data
		foreach ( $alldata as $d ) {
			// $data[] = filterArray( $d, $columnsDefault );
			$data[] = $d;
		}

		// count data
		$totalRecords = $totalDisplay = count( $data );

		// filter by general search keyword
		if ( isset( $_REQUEST['search'] ) ) {
			$data         = filterKeyword( $data, $_REQUEST['search'] );
			$totalDisplay = count( $data );
		}

		if ( isset( $_REQUEST['columns'] ) && is_array( $_REQUEST['columns'] ) ) {
			foreach ( $_REQUEST['columns'] as $column ) {
				if ( isset( $column['search'] ) ) {
					$data         = filterKeyword( $data, $column['search'], $column['data'] );
					$totalDisplay = count( $data );
				}
			}
		}

		// sort
		if ( isset( $_REQUEST['order'][0]['column'] ) && $_REQUEST['order'][0]['dir'] ) {
			$column = $_REQUEST['order'][0]['column'];

				$dir    = $_REQUEST['order'][0]['dir'];
				usort( $data, function ( $a, $b ) use ( $column, $dir ) {
					$a = array_slice( $a, $column, 1 );
					$b = array_slice( $b, $column, 1 );
					$a = array_pop( $a );
					$b = array_pop( $b );

					if ( $dir === 'asc' ) {
						return $a > $b ? true : false;
					}

					return $a < $b ? true : false;
				} );
		}

		// pagination length
		if ( isset( $_REQUEST['length'] ) ) {
			if($_REQUEST['length'] =="-1")
			{
				$data=$data;
			}
			else
			{
				$data = array_splice( $data, $_REQUEST['start'], $_REQUEST['length'] );
			}
		}

		// return array values only without the keys
		if ( isset( $_REQUEST['array_values'] ) && $_REQUEST['array_values'] ) {
			$tmp  = $data;
			$data = [];
			foreach ( $tmp as $d ) {
				$data[] = array_values( $d );
			}
		}

		$result = [
		    'recordsTotal'    => $totalRecords,
		    'recordsFiltered' => $totalDisplay,
		    'data'            => $data,
		];

		header('Content-Type: application/json');
		echo json_encode( $result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function add()
	{
		$this->load->model("base-app/OutliningAssessment");

		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		$reqBulan= $this->input->post("reqBulan");
		$reqTahun= $this->input->post("reqTahun");
		$reqDistrikId= $this->input->post("reqDistrikId");
		$reqBlokId= $this->input->post("reqBlokId");
		$reqUnitMesinId= $this->input->post("reqUnitMesinId");
		$reqListAreaId= $this->input->post("reqListAreaId");
		$reqNama= $this->input->post("reqNama");
		$reqDeskripsi= $this->input->post("reqDeskripsi");
		$reqKategoriItemAssessment= $this->input->post("reqKategoriItemAssessment");
		$reqFormulirId= $this->input->post("reqFormulirId");
		$reqStandarId= $this->input->post("reqStandarId");
		$reqConfirm= $this->input->post("reqConfirm");
		
		$reqKeterangan= $this->input->post("reqKeterangan");
		$reqStatus= $this->input->post("reqStatus");

		$reqDetilId= $this->input->post("reqDetilId");

		$reqListAreaId=array_filter($reqListAreaId);


		$set = new OutliningAssessment();
		$set->setField("OUTLINING_ASSESSMENT_ID", $reqId);
		$set->setField("DISTRIK_ID", $reqDistrikId);
		$set->setField("BLOK_UNIT_ID", $reqBlokId);
		$set->setField("UNIT_MESIN_ID", $reqUnitMesinId);
		$set->setField("BULAN", $reqBulan);
		$set->setField("TAHUN", $reqTahun);
		$set->setField("STATUS", ValToNullDB($reqStatus));


		$reqSimpan= "";
		if ($reqMode == "insert")
		{
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			$set->setField("LAST_CREATE_DATE", 'NOW()');

			if($set->insert())
			{
				$reqSimpan= 1;
				$reqId=$set->id;
			}
		}
		else
		{	
			$set->setField("LAST_UPDATE_USER", $this->appusernama);
			$set->setField("LAST_UPDATE_DATE", 'NOW()');
			if($set->update())
			{
				$reqSimpan= 1;
			}
		}

		if($reqSimpan == 1 )
		{
			if(!empty($reqListAreaId))
			{
				$i=1;
				$reqSimpan= "";
				foreach ($reqListAreaId as $key => $value) {
					$arrval = explode("-", $value);
					$reqAreaId= $arrval[0];
					$reqItemAssessmentDuplikatId= $arrval[1];
					$setdetil = new OutliningAssessment();
					$setdetil->setField("OUTLINING_ASSESSMENT_ID", $reqId);
					$setdetil->setField("LIST_AREA_ID", $reqAreaId);
					$setdetil->setField("KATEGORI_ITEM_ASSESSMENT_ID", $reqKategoriItemAssessment[$key]);
					$setdetil->setField("ITEM_ASSESSMENT_DUPLIKAT_ID", $reqItemAssessmentDuplikatId);
					$setdetil->setField("ITEM_ASSESSMENT_FORMULIR_ID", $reqFormulirId[$key]);
					$setdetil->setField("STANDAR_REFERENSI_ID", $reqStandarId[$key]);
					$setdetil->setField("STATUS_CONFIRM", $reqConfirm[$i]);
					$setdetil->setField("KETERANGAN", $reqKeterangan[$key]);
					$setdetil->setField("LAST_CREATE_USER", $this->appusernama);
					$setdetil->setField("LAST_CREATE_DATE", 'NOW()');
					if(empty($reqDetilId[$key]))
					{
						if($setdetil->insertdetil())
						{
							$reqSimpan= 1;
						}
					}
					else
					{
						$setdetil->setField("OUTLINING_ASSESSMENT_DETIL_ID", $reqDetilId[$key]);

						$setdetil->setField("LAST_UPDATE_USER", $this->appusernama);
						$setdetil->setField("LAST_UPDATE_DATE", 'NOW()');

						if($setdetil->updatedetil())
						{
							$reqSimpan= 1;
						}

					}

					$i++;
				}
			}
		}

		// exit;
		

		if($reqSimpan == 1 )
		{
			echo $reqId."***Data berhasil disimpan";
		}
		else
		{
			echo "xxx***Data gagal disimpan";
		}
				
	}

	function addrekomendasi()
	{
		$this->load->model("base-app/OutliningAssessment");

		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		$reqDetilId= $this->input->post("reqDetilId");
		$reqListAreaId= $this->input->post("reqListAreaId");
		$reqDuplikatId= $this->input->post("reqDuplikatId");
		$reqRekomendasi= $this->input->post("reqRekomendasi");
		$reqJenisRekomendasi= $this->input->post("reqJenisRekomendasi");
		$reqPrioritas= $this->input->post("reqPrioritas");
		$reqKategoriRekomendasi= $this->input->post("reqKategoriRekomendasi");
		$reqSem1_1= $this->input->post("reqSem1_1");
		$reqSem2_1= $this->input->post("reqSem2_1");
		$reqSem1_2= $this->input->post("reqSem1_2");
		$reqSem2_2= $this->input->post("reqSem2_2");
		$reqSem1_3= $this->input->post("reqSem1_3");
		$reqSem2_3= $this->input->post("reqSem2_3");
		// $reqSem3= $this->input->post("reqSem3");
		// $reqSem4= $this->input->post("reqSem4");
		// $reqSem5= $this->input->post("reqSem5");
		// $reqSem6= $this->input->post("reqSem6");
		$reqCheck= $this->input->post("reqCheck");
		$reqPerkiraan= $this->input->post("reqPerkiraan");
		
		$reqRekomendasiId= $this->input->post("reqRekomendasiId");

		// print_r($reqSem1_1);exit;

		$reqSimpan= "";
		if(!empty($reqListAreaId))
		{
			foreach ($reqListAreaId as $key => $value) {

				$set = new OutliningAssessment();
				$set->setField("OUTLINING_ASSESSMENT_ID", $reqId);
				$set->setField("OUTLINING_ASSESSMENT_DETIL_ID", $reqDetilId[$key]);
				$set->setField("LIST_AREA_ID", $value);
				$set->setField("ITEM_ASSESSMENT_DUPLIKAT_ID", $reqDuplikatId[$key]);
				$set->setField("REKOMENDASI", $reqRekomendasi[$key]);
				$set->setField("JENIS_REKOMENDASI_ID", ValToNullDB($reqJenisRekomendasi[$key]));
				$set->setField("PRIORITAS_REKOMENDASI_ID", ValToNullDB($reqPrioritas[$key]));
				$set->setField("KATEGORI_REKOMENDASI_ID", ValToNullDB($reqKategoriRekomendasi[$key]));
				$set->setField("SEM_1_1", ValToNullDB($reqSem1_1[$key]));
				$set->setField("SEM_2_1", ValToNullDB($reqSem2_1[$key]));
				$set->setField("SEM_1_2", ValToNullDB($reqSem1_2[$key]));
				$set->setField("SEM_2_2", ValToNullDB($reqSem2_2[$key]));
				$set->setField("SEM_1_3", ValToNullDB($reqSem1_3[$key]));
				$set->setField("SEM_2_3", ValToNullDB($reqSem2_3[$key]));

				// print_r($reqSem1_1[$key]);
				// $set->setField("SEM_3", ValToNullDB($reqSem3[$key]));
				// $set->setField("SEM_4", ValToNullDB($reqSem4[$key]));
				// $set->setField("SEM_5", ValToNullDB($reqSem5[$key]));
				// $set->setField("SEM_6", ValToNullDB($reqSem6[$key]));
				$set->setField("STATUS_CHECK", $reqCheck[$key]);
				$set->setField("ANGGARAN", ValToNullDB(str_replace(".", "", $reqPerkiraan[$key])));
				$set->setField("OUTLINING_ASSESSMENT_REKOMENDASI_ID", $reqRekomendasiId[$key]);

				// print_r(expression);


				if (empty($reqRekomendasiId[$key]))
				{
					$set->setField("LAST_CREATE_USER", $this->appusernama);
					$set->setField("LAST_CREATE_DATE", 'NOW()');

					if($set->insertrekomendasi())
					{
						$reqSimpan= 1;
					}
				}
				else
				{	
					$set->setField("LAST_UPDATE_USER", $this->appusernama);
					$set->setField("LAST_UPDATE_DATE", 'NOW()');
					if($set->updaterekomendasi())
					{
						$reqSimpan= 1;
					}
				}

			}
		}

		

		if($reqSimpan == 1 )
		{
			echo $reqId."***Data berhasil disimpan";
		}
		else
		{
			echo "xxx***Data gagal disimpan";
		}
				
	}

	function delete()
	{
		$this->load->model("base-app/OutliningAssessment");
		$set = new OutliningAssessment();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');

		$set->setField("OUTLINING_ASSESSMENT_ID", $reqId);

		if($set->delete())
		{
			$arrJson["PESAN"] = "Data berhasil dihapus.";
		}
		else
		{
			$arrJson["PESAN"] = "Data gagal dihapus.";	
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function update_status()
	{
		$this->load->model("base-app/OutliningAssessment");
		$set = new OutliningAssessment();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');

		$reqStatus =  $this->input->get('reqStatus');

		$set->setField("OUTLINING_ASSESSMENT_ID", $reqId);
		$set->setField("STATUS", ValToNullDB($reqStatus));

		if($reqStatus==1)
		{
			$pesan="dinonaktifkan.";
		}
		else
		{
			$pesan="diaktifkan.";
		}

		if($set->update_status())
		{
			$arrJson["PESAN"] = "Data berhasil ".$pesan;
		}
		else
		{
			$arrJson["PESAN"] =  "Data gagal ".$pesan;
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}


	function filter_blok()
	{
		$this->load->model("base-app/BlokUnit");

		$reqDistrikId =  $this->input->get('reqDistrikId');
		
		$statement="  ";

		if(!empty($reqDistrikId))
		{
			$statement .=" AND A.DISTRIK_ID = ".$reqDistrikId;
		}

		$set= new BlokUnit();
		$arrset= [];

		// $statement .=" AND A.STATUS IS NULL AND A.NAMA IS NOT NULL AND EXISTS(SELECT A.BLOK_UNIT_ID FROM AREA_UNIT B WHERE A.BLOK_UNIT_ID=B.BLOK_UNIT_ID)";
		$statement .=" AND A.STATUS IS NULL AND EXISTS(SELECT A.BLOK_UNIT_ID FROM OUTLINING_ASSESSMENT B WHERE A.BLOK_UNIT_ID=B.BLOK_UNIT_ID)";

		$set->selectByParams(array(), -1,-1,$statement);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= array();
			$arrdata["id"]= $set->getField("BLOK_UNIT_ID");
			$arrdata["text"]= $set->getField("NAMA");
			array_push($arrset, $arrdata);
		}
		unset($set);
		echo json_encode( $arrset, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	

	}


	function filter_unit()
	{
		$this->load->model("base-app/UnitMesin");

		$reqDistrikId =  $this->input->get('reqDistrikId');
		$reqBlokId = $this->input->get("reqBlokId");

		
		$statement="  ";

		if(!empty($reqDistrikId))
		{
			$statement .=" AND A.DISTRIK_ID = ".$reqDistrikId;
		}

		if(!empty($reqBlokId))
		{
			$statement .=" AND A.BLOK_UNIT_ID =".$reqBlokId;
		}

		$set= new UnitMesin();
		$arrset= [];

		$statement .=" AND A.STATUS IS NULL  AND EXISTS(SELECT A.UNIT_MESIN_ID FROM OUTLINING_ASSESSMENT B WHERE A.UNIT_MESIN_ID=B.UNIT_MESIN_ID)";
		$set->selectByParams(array(), -1,-1,$statement);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= array();
			$arrdata["id"]= $set->getField("UNIT_MESIN_ID");
			$arrdata["text"]= $set->getField("NAMA");
			array_push($arrset, $arrdata);
		}
		unset($set);
		echo json_encode( $arrset, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	

	}


	function filter_area()
	{
		$this->load->model("base-app/ListArea");

		$reqDistrikId =  $this->input->get('reqDistrikId');
		$reqBlokId =  $this->input->get('reqBlokId');
		$reqUnitMesinId =  $this->input->get('reqUnitMesinId');
		$reqListAreaId =  $this->input->get('reqListAreaId');
		$reqItemAssessmentDuplikatId =  $this->input->get('reqItemAssessmentDuplikatId');

		$statement="  ";

		if(!empty($reqDistrikId))
		{
			$statement .=" AND C.DISTRIK_ID = ".$reqDistrikId;
		}

		if(!empty($reqBlokId))
		{
			$statement .=" AND C.BLOK_UNIT_ID = ".$reqBlokId;
		}

		if(!empty($reqUnitMesinId))
		{
			$statement .=" AND C.UNIT_MESIN_ID = ".$reqUnitMesinId;
		}

		if(!empty($reqListAreaId))
		{
			$statement .=" AND B.LIST_AREA_ID = ".$reqListAreaId;
		}

		if(!empty($reqItemAssessmentDuplikatId))
		{
			$statement .=" AND B.ITEM_ASSESSMENT_DUPLIKAT_ID = ".$reqItemAssessmentDuplikatId;
		}


		$set= new ListArea();
		$arrset= [];

		$statement .=" AND A.STATUS IS NULL ";
		$set->selectduplikatfilter(array(), -1,-1,$statement);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= array();
			$arrdata["id"]= $set->getField("LIST_AREA_ID");
			$arrdata["text"]=$set->getField("KODE_INFO")." - ".$set->getField("NAMA");
			$arrdata["ITEM_ASSESSMENT_DUPLIKAT_ID"]= $set->getField("ITEM_ASSESSMENT_DUPLIKAT_ID");
			$arrdata["AREA_UNIT"]= $set->getField("AREA_UNIT");
			$arrdata["STATUS_CONFIRM"]= $set->getField("STATUS_CONFIRM");
			$arrdata["DESKRIPSI"]= $set->getField("DESKRIPSI");
			array_push($arrset, $arrdata);
		}
		unset($set);

		echo json_encode( $arrset, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	

	}

	function filter_kategori()
	{
		$this->load->model("base-app/KategoriItemAssessment");

		$reqListAreaId =  $this->input->get('reqListAreaId');
		
		$statement="  ";

		if(!empty($reqListAreaId))
		{
			$statement .=" AND A.LIST_AREA_ID = ".$reqListAreaId;
		}

		$set= new KategoriItemAssessment();
		$arrset= [];

		$statement .=" AND A.STATUS IS NULL ";
		$set->selectByParamsAreaFilter(array(), -1,-1,$statement);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= array();
			$arrdata["id"]= $set->getField("KATEGORI_ITEM_ASSESSMENT_ID");
			$arrdata["text"]=$set->getField("NAMA");
			array_push($arrset, $arrdata);
		}
		unset($set);

		echo json_encode( $arrset, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	

	}

	function filter_item()
	{
		$this->load->model("base-app/ItemAssessment");

		$reqListAreaId =  $this->input->get('reqListAreaId');

		$reqKategoriItemAssessmentId =  $this->input->get('reqKategoriItemAssessmentId');
		
		$statement="  ";

		if(!empty($reqKategoriItemAssessmentId))
		{
			$statement .=" AND A.KATEGORI_ITEM_ASSESSMENT_ID = ".$reqKategoriItemAssessmentId;
		}
		else
		{
			$statement .=" AND 1=2 ";
		}

		if(!empty($reqListAreaId))
		{
			$statement .=" AND B.LIST_AREA_ID = ".$reqListAreaId;
		}

		$set= new ItemAssessment();
		$arrset= [];

		$statement .=" AND A.STATUS_KONFIRMASI = 1 ";
		$set->selectByParamsAreaOutline(array(), -1,-1,$statement);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= array();
			$arrdata["id"]= $set->getField("ITEM_ASSESSMENT_FORMULIR_ID");
			$arrdata["text"]=$set->getField("NAMA");
			$arrdata["STANDAR_REFERENSI_ID"]=$set->getField("STANDAR_REFERENSI_ID");
			array_push($arrset, $arrdata);
		}
		unset($set);

		echo json_encode( $arrset, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	

	}

	function filter_standar()
	{
		$this->load->model("base-app/StandarReferensi");

		$reqListAreaId =  $this->input->get('reqListAreaId');

		$reqKategoriItemAssessmentId =  $this->input->get('reqKategoriItemAssessmentId');
		$reqFormulirId =  $this->input->get('reqFormulirId');
		
		$statement="  ";

		if(!empty($reqKategoriItemAssessmentId))
		{
			$statement .=" AND D.KATEGORI_ITEM_ASSESSMENT_ID = ".$reqKategoriItemAssessmentId;
		}

		if(!empty($reqListAreaId))
		{
			$statement .=" AND B.LIST_AREA_ID = ".$reqListAreaId;
		}

		if(!empty($reqFormulirId))
		{
			$statement .=" AND D.ITEM_ASSESSMENT_FORMULIR_ID = ".$reqFormulirId;
		}

		$set= new StandarReferensi();
		$arrset= [];

		$statement .=" ";
		$set->selectByParamsFilterOutline(array(), -1,-1,$statement);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= array();
			$vnama= $set->getField("NAMA");
			$vdeskripsi= $set->getField("DESKRIPSI");
			$vkode= $set->getField("KODE");
			$arrdata["id"]= $set->getField("STANDAR_REFERENSI_ID");
			$arrdata["text"]=$set->getField("NAMA");
			$arrdata["DESKRIPSI"]=$set->getField("DESKRIPSI");
			$arrdata["desc"]= $set->getField("DESKRIPSI");
			$arrdata["html"]= "<div><b>".$vkode."</b></div><div><small>".$vdeskripsi."</small></div>";
			$arrdata["title"]= $vnama;
			array_push($arrset, $arrdata);
		}
		unset($set);

		echo json_encode( $arrset, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	

	}

	function deletedetil()
	{
		$this->load->model("base-app/OutliningAssessment");
		$set = new OutliningAssessment();
		
		$reqId =  $this->input->get('reqId');
		$reqDetilId =  $this->input->get('reqDetilId');
		$reqMode =  $this->input->get('reqMode');

		$set->setField("OUTLINING_ASSESSMENT_DETIL_ID", $reqDetilId);
		$set->setField("OUTLINING_ASSESSMENT_ID", $reqId);

		if($set->deletedetil())
		{
			$arrJson["PESAN"] = "Data berhasil dihapus.";
		}
		else
		{
			$arrJson["PESAN"] = "Data gagal dihapus.";	
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function deleterekomendasi()
	{
		$this->load->model("base-app/OutliningAssessment");
		$set = new OutliningAssessment();
		
		$reqId =  $this->input->get('reqId');
		$reqRekomendasiId =  $this->input->get('reqRekomendasiId');
		$reqMode =  $this->input->get('reqMode');

		$set->setField("OUTLINING_ASSESSMENT_REKOMENDASI_ID", $reqRekomendasiId);
		$set->setField("OUTLINING_ASSESSMENT_ID", $reqId);

		if($set->deleterekomendasi())
		{
			$arrJson["PESAN"] = "Data berhasil dihapus.";
		}
		else
		{
			$arrJson["PESAN"] = "Data gagal dihapus.";	
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

}