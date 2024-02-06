<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");
ini_set('max_execution_time', 0);
ini_set('memory_limit', '-1');

class generate_json extends CI_Controller {

	function __construct() {
		parent::__construct();
		//kauth

		// if($this->session->userdata("adminuserid") == "")
		// {
		// 	redirect('login');
		// }
		
		$this->appuserid= $this->session->userdata("appuserid");
		$this->appusernama= $this->session->userdata("appusernama");
		$this->personaluserlogin= $this->session->userdata("personaluserlogin");
		$this->appusergroupid= $this->session->userdata("appusergroupid");
	}	
	
	function MasterJabatan()
	{
		$this->load->model("base-app/Generate");
		$this->load->model("base-app/LogGenerate");

		// $set= new LogGenerate();
		// // $set->deleteJabatan();
		$check= new Generate();
		
		$json = file_get_contents('https://talentman.plnnusantarapower.co.id/api/daftar_jabatan_erm');
		$jsonJadi=json_decode($json);
		$jsonJadiproses=json_decode(json_encode($jsonJadi), true);

	    $gagal=0;
	    $berhasil=0;
	    // $berhasilupdate=0;
	    $setInsert= new Generate();
	   	for($i=0; $i<count($jsonJadiproses); $i++){
		    $reqPositionId= trim($jsonJadiproses[$i]['POSITION_ID']);
		    $reqNamaPosisi= $jsonJadiproses[$i]['NAMA_POSISI'];
		    $reqSuperiorId= $jsonJadiproses[$i]['SUPERIOR_ID'];
		    $reqKodeKategori= $jsonJadiproses[$i]['KODE_KATEGORI'];
		    $reqKategori= $jsonJadiproses[$i]['KATEGORI'];
		    $reqKodeKelompokJabatan= $jsonJadiproses[$i]['KODE_KELOMPOK_JABATAN'];
		    $reqKelompokJabatan= $jsonJadiproses[$i]['KELOMPOK_JABATAN'];
		    $reqKodeJenjangJabatan= $jsonJadiproses[$i]['KODE_JENJANG_JABATAN'];
		    $reqJenjangJabatan= $jsonJadiproses[$i]['JENJANG_JABATAN'];
		    $reqKodeKlasifikasiUnit= $jsonJadiproses[$i]['KODE_KLASIFIKASI_UNIT'];
		    $reqKlasifikasiUnit= $jsonJadiproses[$i]['KLASIFIKASI_UNIT'];
		    $reqKodeUnit= $jsonJadiproses[$i]['KODE_UNIT'];
		    $reqUnit= $jsonJadiproses[$i]['UNIT'];
		    $reqKodeDitbid= $jsonJadiproses[$i]['KODE_DITBID'];
		    $reqDitbid= $jsonJadiproses[$i]['DITBID'];
		    $reqKodeBagian= $jsonJadiproses[$i]['KODE_BAGIAN'];
		    $reqBagian= $jsonJadiproses[$i]['BAGIAN'];
		    $reqOccupStatus= $jsonJadiproses[$i]['OCCUP_STATUS'];
		    $reqNamaLengkap= $jsonJadiproses[$i]['NAMA_LENGKAP'];
		    $reqEmail= $jsonJadiproses[$i]['EMAIL'];
		    $reqNid= $jsonJadiproses[$i]['NID'];
		    $reqPosisi= $jsonJadiproses[$i]['POSISI'];
		    $reqChange= $jsonJadiproses[$i]['CHANGE_REASON'];

		    // $statement= " AND A.POSITION_ID LIKE '%".$reqPositionId."%'";
		    $statement= " AND TRIM(POSITION_ID) = TRIM('".$reqPositionId."')";
		    $check->selectByParamsCheckJabatan(array(), -1, -1, $statement);
		    // echo $check->query;exit;
		    $check->firstRow();
		    $checkkode= $check->getField("POSITION_ID");

		    $setInsert->setField('POSITION_ID', $reqPositionId);
		    $setInsert->setField('NAMA_POSISI', $reqNamaPosisi);
		    $setInsert->setField('SUPERIOR_ID', $reqSuperiorId);
		    $setInsert->setField('KODE_KATEGORI', $reqKodeKategori);
		    $setInsert->setField('KATEGORI', $reqKategori);
		    $setInsert->setField('KODE_KELOMPOK_JABATAN', $reqKodeKelompokJabatan);
		    $setInsert->setField('KELOMPOK_JABATAN', $reqKelompokJabatan);
		    $setInsert->setField('KODE_JENJANG_JABATAN', $reqKodeJenjangJabatan);
		    $setInsert->setField('JENJANG_JABATAN', $reqJenjangJabatan);
		    $setInsert->setField('KODE_KLASIFIKASI_UNIT', $reqKodeKlasifikasiUnit);
		    $setInsert->setField('KLASIFIKASI_UNIT', $reqKlasifikasiUnit);
		    $setInsert->setField('KODE_UNIT', $reqKodeUnit);
		    $setInsert->setField('UNIT', $reqUnit);
		    $setInsert->setField('KODE_DITBID', $reqKodeDitbid);
		    $setInsert->setField('DITBID', $reqDitbid);
		    $setInsert->setField('KODE_BAGIAN', $reqKodeBagian);
		    $setInsert->setField('BAGIAN', $reqBagian);
		    $setInsert->setField('OCCUP_STATUS', $reqOccupStatus);
		    $setInsert->setField('NAMA_LENGKAP', setQuote($reqNamaLengkap));
		    $setInsert->setField('EMAIL', setQuote($reqEmail));
		    $setInsert->setField('NID', $reqNid);
		    $setInsert->setField('POSISI', $reqPosisi);
		    $setInsert->setField('CHANGE_REASON', $reqChange);
		    $setInsert->setField('TIPE', 1);
		  
			if(empty($checkkode))
		    {
		    	if($setInsert->insertJabatan()){
		    		$berhasil++;
		    	}
		    	else{
		    		$gagal++;
		    		// echo $setInsert->query;
		    	}

		    }
		    else
		    {
		    	if($setInsert->updateJabatan()){
		    		$berhasil++;
		    	}
		    	else{
		    		$gagal++;
		    		// echo $setInsert->query;
		    	}
		    }
		}

		// exit;
		
		$set= new LogGenerate();
		$set->setField('TABLE_GENERATE', "MASTER JABATAN");
		$set->setField('USER_GENERATE', $this->appuserid);
		$set->setField('DATE_GENERATE', "CURRENT_DATE");
		$set->setField('BERHASIL_GENERATE', $berhasil);
		$set->setField('GAGAL_GENERATE', $gagal);
		$set->insert();

		// echo " ".$berhasilinsert." data telah berhasil di insert.   ".$berhasilupdate." data telah berhasil di update.  ".$gagal." data gagal di generate";
		echo $berhasil." data telah berhasil di generate.  ".$gagal." data gagal di generate";
			
	}

	function MasterUserInternal()
	{
		$this->load->model("base-app/Generate");
		$this->load->model("base-app/LogGenerate");

		$check= new Generate();
		
		$json = file_get_contents('https://talentman.plnnusantarapower.co.id/api/daftar_jabatan_erm');
		$jsonJadi=json_decode($json);
		$jsonJadiproses=json_decode(json_encode($jsonJadi), true);

		// print_r($jsonJadiproses);exit;

	

	    $gagal=0;
	    $berhasil=0;
	    // $berhasilupdate=0;
	    $setInsert= new Generate();
	   	for($i=0; $i<count($jsonJadiproses); $i++){
		    $reqPositionId= trim($jsonJadiproses[$i]['POSITION_ID']);
		    $reqNamaPosisi= $jsonJadiproses[$i]['NAMA_POSISI'];
		    $reqKodeKlasifikasiUnit= $jsonJadiproses[$i]['KODE_KLASIFIKASI_UNIT'];
		    $reqKlasifikasiUnit= $jsonJadiproses[$i]['KLASIFIKASI_UNIT'];
		    $reqKodeUnit= $jsonJadiproses[$i]['KODE_UNIT'];
		    $reqUnit= $jsonJadiproses[$i]['UNIT'];
		    $reqKodeDitbid= $jsonJadiproses[$i]['KODE_DITBID'];
		    $reqDitbid= $jsonJadiproses[$i]['DITBID'];
		    $reqKodeBagian= $jsonJadiproses[$i]['KODE_BAGIAN'];
		    $reqBagian= $jsonJadiproses[$i]['BAGIAN'];
		    $reqOccupStatus= $jsonJadiproses[$i]['OCCUP_STATUS'];
		    $reqNamaLengkap= $jsonJadiproses[$i]['NAMA_LENGKAP'];
		    $reqEmail= $jsonJadiproses[$i]['EMAIL'];
		    $reqNid= $jsonJadiproses[$i]['NID'];
		    $reqPosisi= $jsonJadiproses[$i]['POSISI'];

		    if(empty($reqNid))
		    {
		    	continue;
		    }

		    // $statement= " AND A.POSITION_ID LIKE '%".$reqPositionId."%'";
		    $statement= " AND TRIM(NID) = TRIM('".$reqNid."') ";
		    $check->selectByParamsCheckUserInternal(array(), -1, -1, $statement);
		    // echo $check->query;exit;
		    $check->firstRow();
		    $checknid= $check->getField("NID");
		    $checkid= $check->getField("PENGGUNA_INTERNAL_ID");

		    $setInsert->setField('POSITION_ID', $reqPositionId);
		    $setInsert->setField('NAMA_POSISI', $reqNamaPosisi);
		    $setInsert->setField('KODE_KLASIFIKASI_UNIT', $reqKodeKlasifikasiUnit);
		    $setInsert->setField('KLASIFIKASI_UNIT', $reqKlasifikasiUnit);
		    $setInsert->setField('KODE_UNIT', $reqKodeUnit);
		    $setInsert->setField('UNIT', $reqUnit);
		    $setInsert->setField('KODE_DITBID', $reqKodeDitbid);
		    $setInsert->setField('DITBID', $reqDitbid);
		    $setInsert->setField('KODE_BAGIAN', $reqKodeBagian);
		    $setInsert->setField('BAGIAN', $reqBagian);
		    $setInsert->setField('OCCUP_STATUS', $reqOccupStatus);
		    $setInsert->setField('NAMA_LENGKAP', setQuote($reqNamaLengkap));
		    $setInsert->setField('EMAIL', setQuote($reqEmail));
		    $setInsert->setField('NID', $reqNid);
		    $setInsert->setField('PENGGUNA_INTERNAL_ID', $checkid);
		  
			if(empty($checkid))
		    {
		    	if($setInsert->insertUserInternal()){
		    		$berhasil++;
		    	}
		    	else{
		    		$gagal++;
		    		// echo $setInsert->query;
		    	}

		    }
		    else
		    {
		    	if($setInsert->updateUserInternal()){
		    		$berhasil++;
		    	}
		    	else{
		    		$gagal++;
		    		// echo $setInsert->query;
		    	}
		    }
		}

		// exit;
		
		$set= new LogGenerate();
		$set->setField('TABLE_GENERATE', "MASTER USER INTERNAL");
		$set->setField('USER_GENERATE', $this->appuserid);
		$set->setField('DATE_GENERATE', "CURRENT_DATE");
		$set->setField('BERHASIL_GENERATE', $berhasil);
		$set->setField('GAGAL_GENERATE', $gagal);
		$set->insert();

		// echo " ".$berhasilinsert." data telah berhasil di insert.   ".$berhasilupdate." data telah berhasil di update.  ".$gagal." data gagal di generate";
		echo $berhasil." data telah berhasil di generate.  ".$gagal." data gagal di generate";
			
	}

	function work_order()
	{
		ini_set('max_execution_time', 500);
		ini_set("memory_limit", "-1"); 
		$this->load->model("base-app/Distrik");
		$this->load->model("base-app/WorkOrder");
		$this->load->model("base-app/LogGenerate");

		$set= new Distrik();

		$reqDistrikId= $this->input->get("reqDistrikId");
		$reqEquipmentId= $this->input->get("reqEquipmentId");
		$statement=" AND A.DISTRIK_ID=".$reqDistrikId;
		$set->selectByParams(array(), -1, -1, $statement);
   		 // echo $set->query;exit;
   		$set->firstRow();
   		$reqDistrikKode= $set->getField("KODE_SITE");
   		
   		$setInsert= new WorkOrder();

		// Prepare new cURL resource

		if($reqEquipmentId==1)
		{
			// $linkapi='http://maximo-training.ptpjb.com:9084/maxrest/oslc/os/mxwodetail?lean=1&oslc.where=spi%3Aistask%3D0%20and%20spi%3Astatus%20IN%20%5B%22APPR%22%2C%22INPROG%22%5D%20and%20spi%3Asiteid%3D%22'.$reqDistrikKode.'%22&collectioncount=1';
			// $linkapi='http://maximo-training.ptpjb.com:9084/maxrest/oslc/os/mxwodetail?lean=1&oslc.where=spi%3Aistask%3D0%20and%20spi%3Astatus%20IN%20%5B%22APPR%22%2C%22INPROG%22%5D%20and%20spi%3Asiteid%3D%22%22&collectioncount=1';

			// $linkapi='http://maximo-training.ptpjb.com:9084/maximo/oslc/os/mxwodetail?oslc.pageSize=10&lean=1&oslc.where%3Distask%3D0%20and%20siteid%3D%22PR%22%20and%20status%20IN%20%5B%22APPR%22%2C%22INPROG%22%5D%26collectioncount%3D1%20';
			// $linkapi='http://maximo-training.ptpjb.com:9084/maximo/oslc/os/mxwodetail?oslc.pageSize=10&lean=1&oslc.select=*&oslc.where=istask=0%20and%20siteid="PR"%20and%20status%20IN%20["APPR","INPROG"]&collectioncount=1';

			$linkapi="";
			if(empty($reqDistrikKode))
			{
				echo "Kode site distrik Kosong";exit;
			}
			else
			{
				$linkapi='http://maximo-training.ptpjb.com:9084/maximo/oslc/os/mxwodetail?lean=1&oslc.where=istask=0%20and%20siteid="'.$reqDistrikKode.'"%20and%20status%20IN%20["APPR","INPROG"]&collectioncount=1';
			}
			
			// echo $linkapi;exit;
			// $linkapi = urlencode($linkapi);
		}
		elseif($reqEquipmentId==2)
		{
			$linkapi='';
			echo 'Api ELLIPSE Belum Ada';exit;
			
		}
		else {
			echo 'Equiment Kosong';exit;
			# code...
		}
		
		// print_r($linkapi);exit;
		$ch = curl_init($linkapi);
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLINFO_HEADER_OUT, true);
		// curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		$var = array(
			'_lid' => 'maxadmin',
			'_lpwd' => 'maxhsh');

		$post_array = array();
		foreach ($var as $key => $value)
		{
			$post_array[] = urlencode($key) . '=' . urlencode($value);
		}
		$post_string = implode('&', $post_array);

		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
		 
		$resultdepart = curl_exec($ch);


		if (curl_errno($ch)) {
			$error_msg = curl_error($ch);

			var_dump( $error_msg);exit;
		}
		// var_dump($resultdepart);exit;


		// Close cURL session handle
		curl_close($ch);
		

		if(empty($resultdepart))
   		{
   			echo 'Koneksi Api Bermasalah / Data Tidak Ditemukan ';exit;
   		}

		$jsondepart=json_decode($resultdepart);
		$jsondepartproses = json_decode(json_encode($jsondepart), true);
		
		$jsondepartproses=$jsondepartproses["member"];
		

		$arrwo=array();

		foreach ($jsondepartproses as $key => $value) {
			$ch = curl_init($value['href']);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLINFO_HEADER_OUT, true);
			curl_setopt($ch, CURLOPT_VERBOSE, true);
			 
			// curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			//     'maxauth : ' . base64_encode('maxadmin' . ':' . 'maxadmintest76'))
			// );
			$var = array(
				'_lid' => 'maxadmin',
				'_lpwd' => 'maxhsh');

			$post_array = array();
			foreach ($var as $key => $value)
			{
				$post_array[] = urlencode($key) . '=' . urlencode($value);
			}
			$post_string = implode('&', $post_array);

			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);

			$arrdata=array();
			 
			$result= curl_exec($ch);
			$jsonwo=json_decode($result);
			// print_r($jsonwo);exit;

			$jsonwotes = json_decode(json_encode($jsonwo), true);
			$arrdata['assetnum']=$jsonwotes['spi:assetnum'];
			$arrdata['status']=$jsonwotes['spi:status'];
			$arrdata['desc']=$jsonwotes['spi:description'];
			$arrdata['wonum']=$jsonwotes['spi:wonum'];
			$arrdata['siteid']=$jsonwotes['spi:siteid'];
			$arrdata['project_no']=$jsonwotes['spi:project_no'];
			$arrdata['worktype']=$jsonwotes['spi:worktype'];
			// print_r($jsonwotes['spi:assetnum']);exit;
			array_push($arrwo, $arrdata);


			curl_close($ch);
		}

		
		if(empty($arrwo))
   		{
   			echo 'Data Distrik '.$reqDistrikKode.' Tidak Ditemukan ';exit;
   		}

		
		$infonomor= 0;
		$gagal=0;
	    $berhasil=0;
		foreach ($arrwo as $key => $value) 
		{
			$reqAssetNum= $value['assetnum'];
			$reqStatus= $value['status'];
			$reqDesc= $value['desc'];
			$reqWoNum= $value['wonum'];
			$reqSiteId= $value['siteid'];
			$reqProjectNo= $value['project_no'];
			$reqWorkType= $value['worktype'];

			$setInsert->setField('ASSET_NUM', $reqAssetNum);
		    $setInsert->setField('STATUS', $reqStatus);
		    $setInsert->setField('DESCRIPTION', $reqDesc);
		    $setInsert->setField('WO', $reqWoNum);
		    $setInsert->setField('SITE_ID', $reqSiteId);
		    $setInsert->setField('EQUIPMENT_ID', $reqEquipmentId);
		    $setInsert->setField('PROJECT_NO', $reqProjectNo);
		    $setInsert->setField('WORKTYPE', $reqWorkType);

		    $check= new WorkOrder();

		    $statement= " AND TRIM(WO) = TRIM('".$reqWoNum."')";
		    $check->selectByParams(array(), -1, -1, $statement);
		    // echo $check->query;exit;
		    $check->firstRow();
		    $checkwo= $check->getField("WO");

		    if(empty($checkwo))
		    {
		    	if($setInsert->insert()){
		    		$berhasil++;
		    	}
		    	else{
		    		$gagal++;
		    	}

		    }
		    else
		    {
		    	if($setInsert->update()){
		    		$berhasil++;
		    	}
		    	else{
		    		$gagal++;
		    		// echo $setInsert->query;
		    	}
		    }
			
		}

		$set= new LogGenerate();
		$set->setField('TABLE_GENERATE', "WORK ORDER");
		$set->setField('USER_GENERATE', $this->appuserid);
		$set->setField('DATE_GENERATE', "CURRENT_DATE");
		$set->setField('BERHASIL_GENERATE', $berhasil);
		$set->setField('GAGAL_GENERATE', $gagal);
		$set->insert();
		echo $berhasil." data telah berhasil di generate.  ".$gagal." data gagal di generate";
		// exit;

	}


	function work_request()
	{
		ini_set('max_execution_time', 500);
		ini_set("memory_limit", "-1"); 
		$this->load->model("base-app/Distrik");
		$this->load->model("base-app/WorkRequest");
		$this->load->model("base-app/LogGenerate");

		$set= new Distrik();

		$reqDistrikId= $this->input->get("reqDistrikId");
		$reqEquipmentId= $this->input->get("reqEquipmentId");


		$statement=" AND A.DISTRIK_ID=".$reqDistrikId;
		$set->selectByParams(array(), -1, -1, $statement);
   		 // echo $set->query;exit;
   		$set->firstRow();
   		$reqDistrikKode= $set->getField("KODE_SITE");
   		
   		$setInsert= new WorkRequest();


		// Prepare new cURL resource

		if($reqEquipmentId==1)
		{
			$linkapi='http://maximo-training.ptpjb.com:9084/maxrest/oslc/os/mxsr?lean=1&oslc.where=spi%3Asiteid%3D%22'.$reqDistrikKode.'%22%20and%20spi%3Astatus%20IN%20%5B%22QUEUED%22%2C%22WOCREATED%22%5D&collectioncount=1';
		}
		elseif($reqEquipmentId==2)
		{
			$linkapi='';
			exit;
		}
		else {
			echo 'Equiment Kosong';exit;
			# code...
		}

		

		// print_r($linkapi);exit;
		$ch = curl_init($linkapi);
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLINFO_HEADER_OUT, true);
		// curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		 
		// Set HTTP Header 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'maxauth : ' . base64_encode('maxadmin' . ':' . 'maxadmintest76'))
		);
		 
		$resultdepart = curl_exec($ch);

		// Close cURL session handle
		curl_close($ch);

		if(empty($resultdepart))
   		{
   			echo 'Koneksi Api Bermasalah / Data Tidak Ditemukan ';exit;
   		}


		$jsondepart=json_decode($resultdepart);
		$jsondepartproses = json_decode(json_encode($jsondepart), true);
		
		$jsondepartproses=$jsondepartproses["member"];

		// print_r($jsondepartproses);exit;

		$arrwo=array();

		foreach ($jsondepartproses as $key => $value) {
			$ch = curl_init($value['href']);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLINFO_HEADER_OUT, true);
			curl_setopt($ch, CURLOPT_VERBOSE, true);
			 
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			    'maxauth : ' . base64_encode('maxadmin' . ':' . 'maxadmintest76'))
			);

			$arrdata=array();
			 
			$result= curl_exec($ch);
			$jsonwo=json_decode($result);
			$jsonwotes = json_decode(json_encode($jsonwo), true);
			$arrdata['assetnum']=$jsonwotes['spi:assetnum'];
			$arrdata['status']=$jsonwotes['spi:status'];
			$arrdata['desc']=$jsonwotes['spi:description'];
			$arrdata['oprgroup']=$jsonwotes['spi:oprgroup'];
			$arrdata['faulttype']=$jsonwotes['spi:faulttype'];
			$arrdata['siteid']=$jsonwotes['spi:siteid'];
			// print_r($jsonwotes['spi:assetnum']);exit;
			array_push($arrwo, $arrdata);


			curl_close($ch);
		}

		// print_r($arrwo);exit;

		if(empty($arrwo))
   		{
   			echo 'Data Distrik '.$reqDistrikKode.' Tidak Ditemukan';exit;
   		}

		
		$infonomor= 0;
		$gagal=0;
	    $berhasil=0;
		foreach ($arrwo as $key => $value) 
		{
			$reqAssetNum= $value['assetnum'];
			$reqStatus= $value['status'];
			$reqDesc= $value['desc'];
			$reqOprgroup= $value['oprgroup'];
			$reqFaulttype= $value['faulttype'];
			$reqSiteId= $value['siteid'];

			$setInsert->setField('ASSET_NUM', $reqAssetNum);
		    $setInsert->setField('STATUS', $reqStatus);
		    $setInsert->setField('DESCRIPTION', $reqDesc);
		    $setInsert->setField('OPRGROUP', $reqOprgroup);
		    $setInsert->setField('FAULTTYPE', $reqFaulttype);
		    $setInsert->setField('SITE_ID', $reqSiteId);
		    $setInsert->setField('EQUIPMENT_ID', $reqEquipmentId);

		    $check= new WorkRequest();

		    $statement= " AND TRIM(WO) = TRIM('".$reqWoNum."')";
		    $check->selectByParams(array(), -1, -1, $statement);
		    // echo $check->query;exit;
		    $check->firstRow();
		    $checkwo= $check->getField("ASSET_NUM");

		    if(empty($checkwo))
		    {
		    	if($setInsert->insert()){
		    		$berhasil++;
		    	}
		    	else{
		    		$gagal++;
		    	}

		    }
		    else
		    {
		    	if($setInsert->update()){
		    		$berhasil++;
		    	}
		    	else{
		    		$gagal++;
		    		// echo $setInsert->query;
		    	}
		    }
			
		}

		$set= new LogGenerate();
		$set->setField('TABLE_GENERATE', "WORK REQUEST");
		$set->setField('USER_GENERATE', $this->appuserid);
		$set->setField('DATE_GENERATE', "CURRENT_DATE");
		$set->setField('BERHASIL_GENERATE', $berhasil);
		$set->setField('GAGAL_GENERATE', $gagal);
		$set->insert();
		echo $berhasil." data telah berhasil di generate.  ".$gagal." data gagal di generate";
		// exit;

	}


}
?>