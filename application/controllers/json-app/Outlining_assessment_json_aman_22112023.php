<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class outlining_assessment_json extends CI_Controller
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

	function json()
	{
		$this->load->model("base-app/OutliningAssessment");
		$this->load->model("base-app/Crud");
		$this->load->model("base/Users");
		$this->load->library('libapproval');


		$set= new Crud();
		$appuserkodehak= $this->appuserkodehak;
		$reqPenggunaid= $this->appuserid;


		$statement=" AND A.KODE_HAK = '".$appuserkodehak."'";

		$set->selectByParams(array(), -1, -1, $statement);
		// echo $set->query;exit;

		$set->firstRow();
		$reqPenggunaHakId= $set->getField("PENGGUNA_HAK_ID");
		unset($set);

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
		// $reqBlokId= $this->input->get("reqBlokId");
		$reqUnitMesin= $this->input->get("reqUnitMesin");
		$reqBulan= $this->input->get("reqBulan");
		$reqTahun= $this->input->get("reqTahun");
		$reqBlok= $this->input->get("reqBlok");
		$reqVstatus= $this->input->get("reqVstatus");

		$statement="";
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

		if(!empty($reqStatus))
		{
			if($reqStatus== 'NULL')
			{
				$statement .= " AND A.STATUS IS NULL";
			}
			else
			{
				$statement .= " AND A.STATUS =".$reqStatus;
			}
			
		}

		if(!empty($reqDistrik))
		{
			$statement .= " AND A.DISTRIK_ID =".$reqDistrik;
			
		}
		else
		{
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
				if(!empty($idDistrik))
				{
					$statement .= " AND A.DISTRIK_ID IN (".$idDistrik.")";
				} 
			}
		}

		if(!empty($reqBlok))
		{
			$statement .= " AND A.BLOK_UNIT_ID =".$reqBlok;
			
		}

		if(!empty($reqUnitMesin))
		{
			$statement .= " AND A.UNIT_MESIN_ID =".$reqUnitMesin;
			
		}

		if(!empty($reqBulan))
		{
			$statement .= " AND A.BULAN ='".$reqBulan."'";
			
		}
		if(!empty($reqTahun))
		{
			$statement .= " AND A.TAHUN =".$reqTahun;
			
		}
		if(!empty($reqBlok))
		{
			$statement .= " AND A.BLOK_UNIT_ID =".$reqBlok;
			
		}

		if($reqPenggunaHakId ==1 || $reqPenggunaHakId ==3  )
		{}
		else
		{
			$statement .= " AND A.V_STATUS IS NOT NULL";
		}

		if($reqVstatus !=="" )
		{
			$statement .= " AND A.V_STATUS =".$reqVstatus;
			
		}

		
		$sOrder = " ORDER BY A.OUTLINING_ASSESSMENT_ID ASC ";
		$set->selectByParams(array(), $dsplyRange, $dsplyStart, $statement.$searchJson, $sOrder);

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
				else if ($valkey == "STATUS_APPROVAL")
				{
					$vappr= new libapproval();
					$approval_info_pg="outlining_assessment";
					$arrparam= ["ref_tabel"=>$approval_info_pg, "ref_id"=>$set->getField("OUTLINING_ASSESSMENT_ID")];
					$detaildok= $vappr->getdetaildok($arrparam);

					$arrparam= ["ref_tabel"=>$approval_info_pg, "ref_id"=>$set->getField("OUTLINING_ASSESSMENT_ID")];
					$datastatus= $vappr->listapprovalstatus($arrparam);

					$arrparam= ["ref_tabel"=>$approval_info_pg, "ref_id"=>$set->getField("OUTLINING_ASSESSMENT_ID")];

					$datatabel= $vappr->listapproval($arrparam);
					$statusapproval='';
					if(isset($detaildok))
					{
						$dokinfostatus= $detaildok[0]['APPR_STATUS'];
						$dokinfostatusnama= $detaildok[0]['APPR_STATUS_NAMA'];

						if(is_numeric($dokinfostatus) && $dokinfostatus == "0")
						{
							$statusapproval=" 
							<div >
							<h4>".$dokinfostatusnama."</h4>
							<p>Status menunggu approval oleh :";
							foreach ($datatabel as $key => $rows)
							{
								$statusapproval .= '<br> - '.$rows['ROLE_NAMA'];

							}
							$lastApprove=$datatabel[0]['ROLE_NAMA'];
							$statusapproval .="</p></div>";
							$statusapproval=$dokinfostatusnama." : ".$lastApprove;
						}
						elseif($dokinfostatus == 10)
						{
							$checkappr= new OutliningAssessment();
							$statement=" AND A.OUTLINING_ASSESSMENT_ID = '".$set->getField("OUTLINING_ASSESSMENT_ID")."'";

							$checkappr->selectByParamsLastApproval(array(), -1, -1, $statement);
						// echo $checkappr->query;exit;

							$checkappr->firstRow();
							$reqRoleCheck= $checkappr->getField("NEXT_ROLE_ID");

							$arrlanjut=array();
							if(!empty($reqRoleCheck))
							{
								$keyslanjut = array_keys(array_column($datatabel, 'ROLE_ID'), $reqRoleCheck);
								$arrlanjut = array_map(function($k) use ($datatabel){return $datatabel[$k];}, $keyslanjut);
							}



							$lastApprove="";

						// print_r($arrrendah);exit;

							$statusapproval=" 
							<div >
							<h4>".$dokinfostatusnama."</h4>
							<p>Disetujui oleh :";
							foreach ($datastatus as $key => $rows)
							{
								$statusapproval .= '<br> - '.$rows['NAMA'];

							}

							$lastApprove=$arrlanjut[0]['ROLE_NAMA'];
							$statusapproval .="</p></div>";
							$statusapproval=$dokinfostatusnama." : ".$lastApprove;
						}
						elseif($dokinfostatus==20)
						{
							$lastApprove="";
							$statusapproval=" 
							<div >
							<h4>".$dokinfostatusnama."</h4>
							<p>Disetujui oleh :";
							foreach ($datastatus as $key => $rows)
							{
								$statusapproval .= '<br> - '.$rows['NAMA'];
							}
							if(!empty($datastatus))
							{
								$lastApprove=end((array_values($datastatus)))["NAMA"];
							}

							$statusapproval .="</p></div>";
							$statusapproval=$dokinfostatusnama." : ".$lastApprove;
						}
						elseif($dokinfostatus == 90 )
						{
							$statusapproval=" 
							<div >
							<h4>".$dokinfostatusnama."</h4>
							<p>Ditolak oleh :";
							foreach ($datastatus as $key => $rows)
							{
								$statusapproval .= '<br> - '.$rows['NAMA'];
							}

							$lastApprove=$rows['NAMA'];
							$statusapproval .="</p></div>";
							$statusapproval=$dokinfostatusnama." : ".$lastApprove;
						}
						elseif($dokinfostatus == 30 )
						{
							$statusapproval=" 
							<div >
							<h4>".$dokinfostatusnama."</h4>
							<p>Dikembalikan oleh :";
							foreach ($datastatus as $key => $rows)
							{
								$statusapproval .= '<br> - '.$rows['NAMA'];
							}
							$lastApprove=$rows['NAMA'];
							$statusapproval .="</p></div>";
							$statusapproval=$dokinfostatusnama." : ".$lastApprove;
						}
					}

					$row[$valkey]= $statusapproval  ;
				}
				else if ($valkey == "STATUS_APPROVAL_HASIL")
				{
					$vappr= new libapproval();
					$approval_info_pg="outlining_assessment_detil";
					$arrparam= ["ref_tabel"=>$approval_info_pg, "ref_id"=>$set->getField("OUTLINING_ASSESSMENT_ID")];
					$detaildok= $vappr->getdetaildok($arrparam);

					$arrparam= ["ref_tabel"=>$approval_info_pg, "ref_id"=>$set->getField("OUTLINING_ASSESSMENT_ID")];
					$datastatus= $vappr->listapprovalstatus($arrparam);

					$arrparam= ["ref_tabel"=>$approval_info_pg, "ref_id"=>$set->getField("OUTLINING_ASSESSMENT_ID")];

					$datatabel= $vappr->listapproval($arrparam);
					$statusapproval='';
					if(isset($detaildok))
					{
						$dokinfostatus= $detaildok[0]['APPR_STATUS'];
						$dokinfostatusnama= $detaildok[0]['APPR_STATUS_NAMA'];

						if(is_numeric($dokinfostatus) && $dokinfostatus == "0")
						{
							$statusapproval=" 
							<div >
							<h4>".$dokinfostatusnama."</h4>
							<p>Status menunggu approval oleh :";
							foreach ($datatabel as $key => $rows)
							{
								$statusapproval .= '<br> - '.$rows['ROLE_NAMA'];

							}
							$lastApprove=$datatabel[0]['ROLE_NAMA'];
							$statusapproval .="</p></div>";
							$statusapproval=$dokinfostatusnama." : ".$lastApprove;
						}
						elseif($dokinfostatus == 10)
						{
							$checkappr= new OutliningAssessment();
							$statement=" AND A.OUTLINING_ASSESSMENT_ID = '".$set->getField("OUTLINING_ASSESSMENT_ID")."'";

							$checkappr->selectByParamsLastApprovalNew(array(), -1, -1, $statement);
						// echo $checkappr->query;exit;

							$checkappr->firstRow();
							$reqRoleCheck= $checkappr->getField("NEXT_ROLE_ID");

							$arrlanjut=array();
							if(!empty($reqRoleCheck))
							{
								$keyslanjut = array_keys(array_column($datatabel, 'ROLE_ID'), $reqRoleCheck);
								$arrlanjut = array_map(function($k) use ($datatabel){return $datatabel[$k];}, $keyslanjut);
							}



							$lastApprove="";

						// print_r($arrrendah);exit;

							$statusapproval=" 
							<div >
							<h4>".$dokinfostatusnama."</h4>
							<p>Disetujui oleh :";
							foreach ($datastatus as $key => $rows)
							{
								$statusapproval .= '<br> - '.$rows['NAMA'];

							}

							$lastApprove=$arrlanjut[0]['ROLE_NAMA'];
							$statusapproval .="</p></div>";
							$statusapproval=$dokinfostatusnama." : ".$lastApprove;
						}
						elseif($dokinfostatus==20)
						{
							$lastApprove="";
							$statusapproval=" 
							<div >
							<h4>".$dokinfostatusnama."</h4>
							<p>Disetujui oleh :";
							foreach ($datastatus as $key => $rows)
							{
								$statusapproval .= '<br> - '.$rows['NAMA'];
							}
							if(!empty($datastatus))
							{
								$lastApprove=end((array_values($datastatus)))["NAMA"];
							}

							$statusapproval .="</p></div>";
							$statusapproval=$dokinfostatusnama." : ".$lastApprove;
						}
						elseif($dokinfostatus == 90 )
						{
							$statusapproval=" 
							<div >
							<h4>".$dokinfostatusnama."</h4>
							<p>Ditolak oleh :";
							foreach ($datastatus as $key => $rows)
							{
								$statusapproval .= '<br> - '.$rows['NAMA'];
							}

							$lastApprove=$rows['NAMA'];
							$statusapproval .="</p></div>";
							$statusapproval=$dokinfostatusnama." : ".$lastApprove;
						}
						elseif($dokinfostatus == 30 )
						{
							$statusapproval=" 
							<div >
							<h4>".$dokinfostatusnama."</h4>
							<p>Dikembalikan oleh :";
							foreach ($datastatus as $key => $rows)
							{
								$statusapproval .= '<br> - '.$rows['NAMA'];
							}
							$lastApprove=$rows['NAMA'];
							$statusapproval .="</p></div>";
							$statusapproval=$dokinfostatusnama." : ".$lastApprove;
						}
					}

					$row[$valkey]= $statusapproval  ;
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
		// exit;

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
				$data=array_values($data);
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
		$reqTersedia= $this->input->post("reqTersedia");
		$reqProgramId= $this->input->post("reqProgramId");
		$reqBobot= $this->input->post("reqBobot");

		// print_r($reqBlokId);exit;
		
		$reqKeterangan= $this->input->post("reqKeterangan");
		$reqStatus= $this->input->post("reqStatus");

		$reqDetilId= $this->input->post("reqDetilId");
		$reqAreaUnitId= $this->input->post("reqAreaUnitId");
		$reqAreaUnitDetilId= $this->input->post("reqAreaUnitDetilId");

		$reqItemAssessmentDuplikatId= $this->input->post("reqItemAssessmentDuplikatId");
		$reqStatusAktif= $this->input->post("reqStatusAktif");
		
		$reqVstatus= $this->input->post("reqVstatus");
		$reqFinish= $this->input->post("reqFinish");
		$is_draft= $this->input->post("is_draft");
		$is_draft1= $this->input->post("is_draft1");
		$reqBlokUnitId= $this->input->post("reqBlokUnitId");
		if(empty($reqBlokId))
		{
			echo "xxx***Blok Unit harus dipilih";exit;
		}
		$reqBlokUnitIdChar = implode (",", $reqBlokId);
		$reqBlokId = array_intersect($reqBlokId, $reqBlokUnitId);

		$set = new OutliningAssessment();
		$set->setField("OUTLINING_ASSESSMENT_ID", $reqId);
		$set->setField("DISTRIK_ID", $reqDistrikId);
		$set->setField("BLOK_UNIT_ID", ValToNullDB(''));
		$set->setField("BLOK_UNIT_ID_CHAR", $reqBlokUnitIdChar);
		$set->setField("UNIT_MESIN_ID", ValToNullDB($reqUnitMesinId));
		$set->setField("BULAN", $reqBulan);
		$set->setField("TAHUN", $reqTahun);
		$set->setField("STATUS", ValToNullDB($reqStatus));
		$set->setField("V_STATUS", ValToNullDB($is_draft));
		$set->setField("V_STATUS_1", ValToNullDB($is_draft1));


		$reqSimpan= "";
		if ($reqMode == "insert")
		{
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			$set->setField("LAST_CREATE_DATE", 'NOW()');

			$statement=" AND A.BULAN =  '".$reqBulan."'  AND A.TAHUN =  '".$reqTahun."'  AND A.DISTRIK_ID =  '".$reqDistrikId."' AND A.BLOK_UNIT_ID_CHAR =  '".$reqBlokUnitIdChar."'  ";

			
			$check = new OutliningAssessment();
			$check->selectByParams(array(), -1, -1, $statement);
			// echo $check->query;exit;
			$check->firstRow();
			$checkId= $check->getField("OUTLINING_ASSESSMENT_ID");

			if(!empty($checkId))
			{
				echo "xxx***Data untuk periode ini sudah ada ";exit;	
			}

			if($set->insert())
			{
				$reqSimpan= 1;
				$reqId=$set->id;
			}
		}
		else
		{	

			$statement=" AND A.BULAN =  '".$reqBulan."'  AND A.TAHUN =  '".$reqTahun."'  AND A.DISTRIK_ID =  '".$reqDistrikId."'  AND A.OUTLINING_ASSESSMENT_ID =  '".$reqId."' AND A.BLOK_UNIT_ID_CHAR =  '".$reqBlokUnitIdChar."'  ";

		
			$check = new OutliningAssessment();
			$check->selectByParams(array(), -1, -1, $statement);
			// echo $check->query;exit;
			$check->firstRow();
			$checkBulan= $check->getField("BULAN");
			$checkTahun= $check->getField("TAHUN");
			$checkDistrikId= $check->getField("DISTRIK_ID");
			$checkBlokUnitId= $check->getField("BLOK_UNIT_ID_CHAR");
			$checkUnitMesinId= $check->getField("UNIT_MESIN_ID");

			unset($check);

			if(empty($reqUnitMesinId))
			{
				if($reqBulan == $checkBulan && $reqTahun == $checkTahun &&  $reqDistrikId == $checkDistrikId  &&  $reqBlokUnitIdChar == $checkBlokUnitId )
				{}
				else
				{

					$statement=" AND A.BULAN =  '".$reqBulan."'  AND A.TAHUN =  '".$reqTahun."'  AND A.DISTRIK_ID =  '".$reqDistrikId."'   ";

					$check = new OutliningAssessment();
					$check->selectByParams(array(), -1, -1, $statement);
					// echo $check->query;exit;
					$check->firstRow();
					$checkId= $check->getField("OUTLINING_ASSESSMENT_ID");

					if(!empty($checkId))
					{
						echo "xxx***Data untuk periode ini sudah ada ";exit;	
					}

					unset($check);

				}
			}
			

			$set->setField("LAST_UPDATE_USER", $this->appusernama);
			$set->setField("LAST_UPDATE_DATE", 'NOW()');
			if($set->update())
			{
				$reqSimpan= 1;
			}
		}

		// print_r($reqStatusAktif);exit;
		if($reqSimpan == 1 )
		{
			if(!empty($reqBlokId))
			{
				// print_r($reqBlokId);exit;
				$i=1;
				$reqSimpan= "";

				$sethapus = new OutliningAssessment();
				$sethapus->setField("OUTLINING_ASSESSMENT_ID", $reqId);
				$sethapus->deleteblok();
				
				foreach ($reqBlokId as $key => $value) {
					
					$setdetil = new OutliningAssessment();
					$setdetil->setField("OUTLINING_ASSESSMENT_ID", $reqId);
					$setdetil->setField("BLOK_UNIT_ID", ValToNullDB($reqBlokId[$key]));

					if($setdetil->insertblok())
					{
						$reqSimpan= 1;
					}


					$i++;
				}
			}

			// print_r($reqBlokUnitId);exit;

			if(!empty($reqListAreaId))
			{
				$i=1;
				$reqSimpan= "";

				if($reqStatusAktif==1)
				{
					$sethapus = new OutliningAssessment();
					$sethapus->setField("OUTLINING_ASSESSMENT_ID", $reqId);
					// $sethapus->deletedetilnew();

				}


				foreach ($reqListAreaId as $key => $value) {
					
					$setdetil = new OutliningAssessment();
					$setdetil->setField("OUTLINING_ASSESSMENT_ID", $reqId);
					$setdetil->setField("LIST_AREA_ID", ValToNullDB($reqListAreaId[$key]));
					$setdetil->setField("ITEM_ASSESSMENT_DUPLIKAT_ID", ValToNullDB($reqItemAssessmentDuplikatId[$key]));
					$setdetil->setField("BLOK_UNIT_ID", ValToNullDB($reqBlokUnitId[$key]));
					$setdetil->setField("AREA_UNIT_ID", ValToNullDB($reqAreaUnitId[$key]));
					$setdetil->setField("AREA_UNIT_DETIL_ID", ValToNullDB($reqAreaUnitDetilId[$key]));
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

			

			// untuk approval
			if($is_draft == "0")
			{
				$infopg= $this->input->post("infopg");
				$infoketerangan= "Outlining Assessment Usulan";
				$this->load->library('libapproval');
				$vappr= new libapproval();
				$arrparam= ["ref_id"=>$reqId, "ref_tabel"=>$infopg, "infoketerangan"=>$infoketerangan];
				$vappr->approvaldata($arrparam);

			}

			if($is_draft1 == "0")
			{

				$infopgnew= $this->input->post("infopgnew");
				$infoketerangan= "Outlining Assessment Hasil";
				$this->load->library('libapproval');
				$vappr= new libapproval();
				$arrparam= ["ref_id"=>$reqId, "ref_tabel"=>$infopgnew, "infoketerangan"=>$infoketerangan];
				$vappr->approvaldata($arrparam);
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

	function adddetil()
	{
		$this->load->model("base-app/OutliningAssessment");

		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		$reqItemAssessmentFormulirId= $this->input->post("reqItemAssessmentFormulirId");
		$reqItemAssessmentId= $this->input->post("reqItemAssessmentId");
		$reqStandarId= $this->input->post("reqStandarId");
		$reqConfirm= $this->input->post("reqConfirm");	
		$reqKeterangan= $this->input->post("reqKeterangan");
		$reqStatus= $this->input->post("reqStatus");

		$reqAreaUnitId= $this->input->post("reqAreaUnitId");

		$reqAreaUnitDetilId= $this->input->post("reqAreaUnitDetilId");
		$reqAreaDetilId= $this->input->post("reqAreaDetilId");
		$reqDetilId= $this->input->post("reqDetilId");
		$reqListAreaId= $this->input->post("reqListAreaId");
		$reqItemAssessmentDuplikatId= $this->input->post("reqItemAssessmentDuplikatId");
		$reqFoto = $_FILES['reqFoto']['name'];
		$reqStatusSudah= $this->input->post("reqStatusSudah");

		$reqVstatus= $this->input->post("reqVstatus");
		$reqFinish= $this->input->post("reqFinish");
		$is_draft= $this->input->post("is_draft");

		// print_r($is_draft);exit;

		
		$reqSimpan= "";
		if (!empty($reqKeterangan))
		{
			$z=1;
			foreach ($reqKeterangan as $chk => $val) {
				if($reqConfirm[$z]=="0" && empty($reqKeterangan[$chk]))
				{
					echo "xxx***Keterangan Assessment Not Confirm Harus diisi";exit;
				}

				$reqTipeFile=$_FILES['reqFoto']['type'][$chk];

				if(!empty($reqTipeFile))
				{
					$checkfile=checkFile($reqTipeFile,3);

					if(empty($checkfile))
					{
						echo "xxx***File Gagal diupload, Pastikan File berformat png,jpg,pdf,doc,docx,xls,xlsx";exit;
					}
				}
				$z++;
			}


			$i=1;
			foreach ($reqKeterangan as $key => $value) {

				$set = new OutliningAssessment();
				$set->setField("OUTLINING_ASSESSMENT_ID", $reqId);
				$set->setField("OUTLINING_ASSESSMENT_DETIL_ID", $reqDetilId);
				$set->setField("AREA_UNIT_ID", $reqAreaUnitId);
				$set->setField("AREA_UNIT_DETIL_ID", $reqAreaUnitDetilId);
				$set->setField("LIST_AREA_ID", $reqListAreaId);
				$set->setField("ITEM_ASSESSMENT_DUPLIKAT_ID", $reqItemAssessmentDuplikatId);
				$set->setField("ITEM_ASSESSMENT_FORMULIR_ID", $reqItemAssessmentFormulirId[$key]);
				$set->setField("ITEM_ASSESSMENT_ID", $reqItemAssessmentId[$key]);
				$set->setField("STANDAR_REFERENSI_ID", ValToNullDB($reqStandarId[$key]));
				$set->setField("STATUS_CONFIRM", $reqConfirm[$i]);
				$set->setField("KETERANGAN", $reqKeterangan[$key]);
				$set->setField("OUTLINING_ASSESSMENT_AREA_DETIL_ID", $reqAreaDetilId[$key]);

				$set->setField("V_STATUS", ValToNullDB($is_draft));

				if(!empty($reqFoto[$key]))
				{
					$linkupload="uploads/outlining_assessment/".$reqId."/".$reqAreaUnitDetilId."/";
					if (!is_dir($linkupload)) {
						makedirs($linkupload);
					}
					$reqLinkFile=$_FILES['reqFoto']['tmp_name'][$key];
					$namefile= $linkupload.$reqFoto[$key];
					// print_r($reqLinkFile);exit;
					if(move_uploaded_file($reqLinkFile, $namefile))
					{
						
					}
				}
				else
				{
					$statement=" AND A.OUTLINING_ASSESSMENT_AREA_DETIL_ID = ".$reqAreaDetilId[$key]." AND A.OUTLINING_ASSESSMENT_ID = ".$reqId."";

					$chkfoto = new OutliningAssessment();
					$chkfoto->selectByParamsAreaDetil(array(), -1,-1,$statement);
					$chkfoto->firstRow();
					$namefile=$chkfoto->getField("LINK_FOTO");

				}

				$set->setField("LINK_FOTO", $namefile);

				if (empty($reqAreaDetilId[$key]))
				{
					$set->setField("LAST_CREATE_USER", $this->appusernama);
					$set->setField("LAST_CREATE_DATE", 'NOW()');

					if($set->insertareadetil())
					{
						$reqSimpan= 1;
						$reqIdAreaDetil=$set->id;
					}
				}
				else
				{	
					$set->setField("LAST_UPDATE_USER", $this->appusernama);
					$set->setField("LAST_UPDATE_DATE", 'NOW()');
					if($set->updateareadetil())
					{
						$reqSimpan= 1;
					}
				}

				if($is_draft == "0")
				{
					$infopg= $this->input->post("infopg");
					$infoketerangan= "Outlining Assessment Hasil";
					// print_r($infopg);exit;
					$this->load->library('libapproval');
					$vappr= new libapproval();
					$arrparam= ["ref_id"=>$reqId, "ref_tabel"=>$infopg, "infoketerangan"=>$infoketerangan];
					// print_r($arrparam);exit;
					$vappr->approvaldata($arrparam);
				}
				$i++;
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
		$reqAreaUnitId= $this->input->post("reqAreaUnitId");
		$reqAreaUnitDetilId= $this->input->post("reqAreaUnitDetilId");
		$reqAreaDetilId= $this->input->post("reqAreaDetilId");
		// print_r($reqAreaDetilId);exit;

		$reqSimpan= "";
		if(!empty($reqListAreaId))
		{
			foreach ($reqListAreaId as $key => $value) {

				$set = new OutliningAssessment();
				$set->setField("OUTLINING_ASSESSMENT_ID", $reqId);
				$set->setField("OUTLINING_ASSESSMENT_DETIL_ID", $reqDetilId[$key]);
				$set->setField("OUTLINING_ASSESSMENT_AREA_DETIL_ID", $reqAreaDetilId);
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
				$set->setField("STATUS_CHECK", $reqCheck[$key]);
				$set->setField("ANGGARAN", ValToNullDB(str_replace(".", "", $reqPerkiraan[$key])));
				$set->setField("OUTLINING_ASSESSMENT_REKOMENDASI_ID", $reqRekomendasiId[$key]);
				$set->setField("AREA_UNIT_DETIL_ID", $reqAreaUnitDetilId[$key]);
				$set->setField("AREA_UNIT_ID", $reqAreaUnitId[$key]);

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

	function addrekomendasinew()
	{
		$this->load->model("base-app/OutliningAssessment");

		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		$reqDetilId= $this->input->post("reqDetilId");
		$reqAreaDetilId= $this->input->post("reqAreaDetilId");
		$reqRekomendasiId= $this->input->post("reqRekomendasiId");

		$reqNomorWo= $this->input->post("reqNomorWo");
		$reqSumberAnggaranId= $this->input->post("reqSumberAnggaranId");
		$reqRencanaEksekusi= $this->input->post("reqRencanaEksekusi");
		$reqDetailRekomendasi= $this->input->post("reqDetailRekomendasi");
		$reqRealisasiEksekusi= $this->input->post("reqRealisasiEksekusi");
		$reqJenisRekomendasiId= $this->input->post("reqJenisRekomendasiId");
		$reqStatusRekomendasiId= $this->input->post("reqStatusRekomendasiId");
		$reqPrioritasRekomendasiId= $this->input->post("reqPrioritasRekomendasiId");
		$reqKeteranganRekomendasi= $this->input->post("reqKeteranganRekomendasi");
		$reqKategoriRekomendasiId= $this->input->post("reqKategoriRekomendasiId");
		$reqTimelineRekomendasiId= $this->input->post("reqTimelineRekomendasiId");
		$reqNomorWoId= $this->input->post("reqNomorWoId");

		$reqVstatus= $this->input->post("reqVstatus");
		$reqFinish= $this->input->post("reqFinish");
		$is_draft= $this->input->post("is_draft");

		$reqLinkFile = $_FILES['reqLinkFile']['name'];
		$reqTipeFile=$_FILES['reqLinkFile']['type'];

		$reqSimpan= "";

		if(empty($reqDetailRekomendasi))
		{
			echo "xxx*** Detail Rekomendasi harus diisi";exit;
		}
	
		$set = new OutliningAssessment();
		$set->setField("OUTLINING_ASSESSMENT_ID", $reqId);
		$set->setField("OUTLINING_ASSESSMENT_DETIL_ID", $reqDetilId);
		$set->setField("OUTLINING_ASSESSMENT_AREA_DETIL_ID", $reqAreaDetilId);
		$set->setField("OUTLINING_ASSESSMENT_REKOMENDASI_ID", $reqRekomendasiId);
		// $set->setField("NOMOR_WO", $reqNomorWo);
		$set->setField("SUMBER_ANGGARAN_ID", ValToNullDB($reqSumberAnggaranId));
		$set->setField("RENCANA_EKSEKUSI", dateToDBCheck($reqRencanaEksekusi));
		$set->setField("DETAIL", $reqDetailRekomendasi);
		$set->setField("REALISASI_EKSEKUSI", dateToDBCheck($reqRealisasiEksekusi));

		$set->setField("JENIS_REKOMENDASI_ID", ValToNullDB($reqJenisRekomendasiId));
		$set->setField("STATUS_REKOMENDASI_ID", ValToNullDB($reqStatusRekomendasiId));
		$set->setField("PRIORITAS_REKOMENDASI_ID", ValToNullDB($reqPrioritasRekomendasiId));
		$set->setField("KETERANGAN", $reqKeteranganRekomendasi);
		$set->setField("KATEGORI_REKOMENDASI_ID", ValToNullDB($reqKategoriRekomendasiId));
		$set->setField("TIMELINE_REKOMENDASI_ID", $reqTimelineRekomendasiId);
		$set->setField("WORK_ORDER_ID", ValToNullDB($reqNomorWoId));
		$set->setField("V_STATUS", ValToNullDB($is_draft));


		// print_r($reqTipeFile);exit;

		if (empty($reqRekomendasiId))
		{
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			$set->setField("LAST_CREATE_DATE", 'NOW()');

			if($set->insertrekomendasi())
			{
				$reqSimpan= 1;
				$reqRekomendasiId=$set->id;
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

		if(!empty($reqTipeFile))
		{
			$checkfile=checkFile($reqTipeFile,3);

			// print_r($reqTipeFile);exit;

			$reqSimpan="";

			if(empty($checkfile))
			{
				echo "xxx***File Gagal diupload, Pastikan Format file sesuai.";exit;
			}

			$linkupload="uploads/outlining_assessment/rekomendasi/".$reqDetilId."/".$reqRekomendasiId."/";
			if (!is_dir($linkupload)) {
				makedirs($linkupload);
			}
			$reqLink=$_FILES['reqLinkFile']['tmp_name'];
			$namefile= $linkupload.$reqLinkFile;
					// print_r($namefile);exit;
			if(move_uploaded_file($reqLink, $namefile))
			{

				$set = new OutliningAssessment();
				$set->setField("OUTLINING_ASSESSMENT_REKOMENDASI_ID", $reqRekomendasiId);
				$set->setField("LAST_UPDATE_USER", $this->appusernama);
				$set->setField("LAST_UPDATE_DATE", 'NOW()');
				$set->setField("LINK_FILE", $namefile);
				if($set->updaterekomendasifile())
				{
					$reqSimpan= 1;
				}

			}
		}

		// untuk approval
		if($is_draft == "0")
		{
			$infopg= $this->input->post("infopg");
			// print_r($infopg);exit;
			$infoketerangan= "Outlining Assessment Rekomendasi";
			$this->load->library('libapproval');
			$vappr= new libapproval();
			$arrparam= ["ref_id"=>$reqRekomendasiId, "ref_tabel"=>$infopg, "infoketerangan"=>$infoketerangan];
			$vappr->approvaldata($arrparam);
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
		
		$statement=" AND 1=2 ";

		if(!empty($reqDistrikId))
		{
			$statement =" AND A.DISTRIK_ID = ".$reqDistrikId;
		}

		$set= new BlokUnit();
		$arrset= [];

		$statement .=" AND A.STATUS IS NULL AND A.NAMA IS NOT NULL AND EXISTS(SELECT A.BLOK_UNIT_ID FROM AREA_UNIT B INNER JOIN  AREA_UNIT_DETIL C ON C.AREA_UNIT_ID = B.AREA_UNIT_ID   WHERE A.BLOK_UNIT_ID=B.BLOK_UNIT_ID)";
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
		$reqBulan = $this->input->get("reqBulan");
		$reqTahun = $this->input->get("reqTahun");

		
		$statement=" AND 1=2 ";

		// if(!empty($reqDistrikId))
		// {
		// 	$statement .=" AND A.DISTRIK_ID = ".$reqDistrikId;
		// }

		if(!empty($reqBlokId))
		{
			$statement =" AND C.BLOK_UNIT_ID_INFO IN (".$reqBlokId.")";
		}

		$set= new UnitMesin();
		$arrset= [];
		$statementbulan="";
		$statementtahun="";
		if(!empty($reqBulan))
		{
			$statementbulan .="AND D.BULAN= '".$reqBulan."'";
		}
		if(!empty($reqTahun))
		{
			$statementtahun .="AND D.TAHUN= ".$reqTahun;
		}

		// $statement .=" AND A.STATUS IS NULL AND A.NAMA IS NOT NULL 
		// AND EXISTS
		// (
		// SELECT A.UNIT_MESIN_ID FROM AREA_UNIT B INNER JOIN  AREA_UNIT_DETIL C ON C.AREA_UNIT_ID = B.AREA_UNIT_ID   WHERE A.UNIT_MESIN_ID=B.UNIT_MESIN_ID
		// )
		// AND  EXISTS
		// (
		// 	SELECT A.UNIT_MESIN_ID FROM OUTLINING_ASSESSMENT D 
		// 	WHERE A.UNIT_MESIN_ID=D.UNIT_MESIN_ID ".$statementbulan.$statementtahun." 
		// ) 
		// ";
		$statement .=" AND A.STATUS IS NULL AND A.NAMA IS NOT NULL 
		AND EXISTS
		(
		SELECT A.UNIT_MESIN_ID FROM AREA_UNIT B INNER JOIN  AREA_UNIT_DETIL C ON C.AREA_UNIT_ID = B.AREA_UNIT_ID   WHERE A.UNIT_MESIN_ID=B.UNIT_MESIN_ID
		)
		";
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
			$arrdata["AREA_UNIT_DETIL_ID"]= $set->getField("AREA_UNIT_DETIL_ID");
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

		$statement .=" AND A.STATUS_KONFIRMASI IS NOT NULL ";
		$set->selectByParamsAreaOutline(array(), -1,-1,$statement);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= array();
			$arrdata["id"]= $set->getField("ITEM_ASSESSMENT_FORMULIR_ID");
			$arrdata["text"]=$set->getField("NAMA");
			$arrdata["STANDAR_REFERENSI_ID"]=$set->getField("STANDAR_REFERENSI_ID");
			$arrdata["BOBOT"]=$set->getField("BOBOT");
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
			$arrdata["STATUS_KONFIRMASI"]=$set->getField("STATUS_KONFIRMASI");
			$arrdata["PROGRAM_ITEM_ASSESSMENT_ID"]=$set->getField("PROGRAM_ITEM_ASSESSMENT_ID");
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

	function deletedetilblok()
	{
		$this->load->model("base-app/OutliningAssessment");
		$set = new OutliningAssessment();
		
		$reqId =  $this->input->get('reqId');
		$reqDetilId =  $this->input->get('reqDetilId');
		$reqMode =  $this->input->get('reqMode');
		$reqBlokId =  $this->input->get('reqBlokId');

		$set->setField("OUTLINING_ASSESSMENT_ID", $reqId);
		$set->setField("BLOK_UNIT_ID", $reqBlokId);

		if($set->deletedetilblok())
		{
			$arrJson["PESAN"] = "Data berhasil dihapus.";
		}
		else
		{
			$arrJson["PESAN"] = "Data gagal dihapus.";	
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function deleteareadetilnew()
	{
		$this->load->model("base-app/OutliningAssessment");
		$set = new OutliningAssessment();
		
		$reqId =  $this->input->get('reqId');
		$reqDetilId =  $this->input->get('reqDetilId');
		$reqMode =  $this->input->get('reqMode');

		$set->setField("OUTLINING_ASSESSMENT_DETIL_ID", $reqDetilId);
		$set->setField("OUTLINING_ASSESSMENT_ID", $reqId);

		if($set->deleteareadetilnew())
		{
			$arrJson["PESAN"] = "Data berhasil dihapus.";
		}
		else
		{
			$arrJson["PESAN"] = "Data gagal dihapus.";	
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function deleteareadetiltabel()
	{
		$this->load->model("base-app/OutliningAssessment");
		$set = new OutliningAssessment();
		
		$reqId =  $this->input->get('reqId');
		$reqDetilId =  $this->input->get('reqDetilId');
		$reqMode =  $this->input->get('reqMode');

		$set->setField("OUTLINING_ASSESSMENT_DETIL_ID", $reqDetilId);
		$set->setField("OUTLINING_ASSESSMENT_ID", $reqId);

		if($set->deleteareadetiltabel())
		{
			$arrJson["PESAN"] = "Data berhasil dihapus.";
		}
		else
		{
			$arrJson["PESAN"] = "Data gagal dihapus.";	
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function deleteareadetil()
	{
		$this->load->model("base-app/OutliningAssessment");
		$set = new OutliningAssessment();
		
		$reqId =  $this->input->get('reqId');
		$reqAreaDetilId =  $this->input->get('reqAreaDetilId');
		$reqMode =  $this->input->get('reqMode');

		$set->setField("OUTLINING_ASSESSMENT_AREA_DETIL_ID", $reqAreaDetilId);
		$set->setField("OUTLINING_ASSESSMENT_ID", $reqId);

		if($set->deleteareadetil())
		{
			$arrJson["PESAN"] = "Data berhasil dihapus.";
		}
		else
		{
			$arrJson["PESAN"] = "Data gagal dihapus.";	
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}


	function deleteareadetilgambar()
	{
		$this->load->model("base-app/OutliningAssessment");
		$set = new OutliningAssessment();
		
		$reqId =  $this->input->get('reqId');
		$reqAreaDetilId =  $this->input->get('reqAreaDetilId');
		$reqMode =  $this->input->get('reqMode');

		$set->setField("OUTLINING_ASSESSMENT_AREA_DETIL_ID", $reqAreaDetilId);
		$set->setField("OUTLINING_ASSESSMENT_ID", $reqId);

		$statement=" AND A.OUTLINING_ASSESSMENT_AREA_DETIL_ID = ".$reqAreaDetilId." AND A.OUTLINING_ASSESSMENT_ID = ".$reqId."";

		$setcheck = new OutliningAssessment();
		$setcheck->selectByParamsAreaDetil(array(), -1,-1,$statement);
		$setcheck->firstRow();
		$reqLinkFoto=$setcheck->getField("LINK_FOTO");

		if(!empty($reqLinkFoto))
		{
			unlink($reqLinkFoto);
		}

		if($set->deleteareadetilgambar())
		{
			$arrJson["PESAN"] = "Lampiran berhasil dihapus.";
		}
		else
		{
			$arrJson["PESAN"] = "Lampiran gagal dihapus.";	
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

		$statement=" AND A.OUTLINING_ASSESSMENT_REKOMENDASI_ID = ".$reqRekomendasiId."";

		$setcheck = new OutliningAssessment();
		$setcheck->selectByParamsRekomendasi(array(), -1,-1,$statement);
		$setcheck->firstRow();
		$reqLinkFIle=$setcheck->getField("LINK_FILE");

		if(!empty($reqLinkFIle))
		{
			unlink($reqLinkFIle);
		}

		if($set->deleterekomendasi())
		{
			$arrJson["PESAN"] = "Data Berhasil diclear.";
		}
		else
		{
			$arrJson["PESAN"] = "Data gagal diclear.";	
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function deleterekomendasifile()
	{
		$this->load->model("base-app/OutliningAssessment");
		$set = new OutliningAssessment();
		
		$reqRekomendasiId =  $this->input->get('reqRekomendasiId');
		$reqMode =  $this->input->get('reqMode');

		$set->setField("OUTLINING_ASSESSMENT_REKOMENDASI_ID", $reqRekomendasiId);

		$statement=" AND A.OUTLINING_ASSESSMENT_REKOMENDASI_ID = ".$reqRekomendasiId."";

		$setcheck = new OutliningAssessment();
		$setcheck->selectByParamsRekomendasi(array(), -1,-1,$statement);
		$setcheck->firstRow();
		$reqLinkFIle=$setcheck->getField("LINK_FILE");

		if(!empty($reqLinkFIle))
		{
			unlink($reqLinkFIle);
		}

		if($set->deleterekomendasifile())
		{
			$arrJson["PESAN"] = "File berhasil dihapus.";
		}
		else
		{
			$arrJson["PESAN"] = "File gagal dihapus.";	
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function filter_rekomendasi()
	{
		$this->load->model("base-app/OutliningAssessment");
		$this->load->model("base/Users");
		$this->load->model("base-app/Crud");

		// $reqBulan =  $this->input->get('reqBulan');

		$reqTahun =  $this->input->get('reqTahun');
		$reqBlok =  $this->input->get('reqBlok');
		$reqDistrik =  $this->input->get('reqDistrik');
		$reqVstatus =  $this->input->get('reqVstatus');
		$reqStatus =  $this->input->get('reqStatus');

		$reqPenggunaid= $this->appuserid;
		$appuserkodehak= $this->appuserkodehak;

		$set= new Crud();
		$statement=" AND A.KODE_HAK = '".$appuserkodehak."'";

		$set->selectByParams(array(), -1, -1, $statement);
		// echo $set->query;exit;

		$set->firstRow();
		$reqPenggunaHakId= $set->getField("PENGGUNA_HAK_ID");
		unset($set);
		// print_r($reqPenggunaid);exit;
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

		
		$statement=" AND EXISTS
			(
			SELECT * FROM OUTLINING_ASSESSMENT_AREA_DETIL X WHERE A.OUTLINING_ASSESSMENT_ID =X.OUTLINING_ASSESSMENT_ID AND X.STATUS_CONFIRM = 0
			)
		";

		// if(!empty($reqBulan))
		// {
		// 	$statement .=" AND A.BULAN = '".$reqBulan."'";
		// }

		if(!empty($reqTahun))
		{
			$statement .=" AND A.TAHUN = ".$reqTahun;
		}
		if(!empty($reqDistrik))
		{
			$statement .=" AND a.DISTRIK_ID = ".$reqDistrik;
		}
		if(!empty($reqBlok))
		{
			$statement .=" AND a.BLOK_UNIT_ID = ".$reqBlok;
		}

		if(!empty($idDistrik))
		{
			$statement .=" AND A.DISTRIK_ID IN (".$idDistrik.")";
		}

		if(!empty($reqStatus))
		{
			$statement .=" AND A.statusnya = '".$reqStatus."'";
		}

		if($reqVstatus !=="")
		{
			$statement .=" AND EXISTS
			(
				SELECT * FROM OUTLINING_ASSESSMENT_REKOMENDASI Z WHERE A.OUTLINING_ASSESSMENT_ID =Z.OUTLINING_ASSESSMENT_ID 
				AND Z.V_STATUS= '".$reqVstatus."'
			)
			";
		}

		$set= new OutliningAssessment();
		$arrset= [];

		$set->selectByParamsRekomendasiDistrik(array(), -1,-1,$statement);
		// echo $set->query;exit;
		$no=1;
		while($set->nextRow())
		{
			$arrdata= array();
			$arrdata["NO"]= $no;
			$arrdata["OUTLINING_ASSESSMENT_ID"]= $set->getField("OUTLINING_ASSESSMENT_ID");
			$arrdata["DISTRIK_ID"]= $set->getField("DISTRIK_ID");
			$arrdata["DISTRIK_NAMA"]= $set->getField("DISTRIK_NAMA");
			$arrdata["BLOK_UNIT_ID"]= $set->getField("BLOK_UNIT_ID");
			$arrdata["BLOK_NAMA"]= $set->getField("BLOK_NAMA");
			$arrdata["ITEM_ASSESSMENT_INFO"]= $set->getField("ITEM_ASSESSMENT_INFO");
			$arrdata["KETERANGAN"]= $set->getField("KETERANGAN");
			$arrdata["BULAN"]= $set->getField("BULAN");
			$arrdata["BULAN_NAMA"]= getNameMonthNew($set->getField("BULAN"));
			$arrdata["TAHUN"]= $set->getField("TAHUN");

			$statement=" AND B.DISTRIK_ID=".$set->getField("DISTRIK_ID")." AND A.BLOK_UNIT_ID IN (".$set->getField("BLOK_UNIT_ID").") AND A.OUTLINING_ASSESSMENT_ID=".$set->getField("OUTLINING_ASSESSMENT_ID");

			$statement.=" AND EXISTS
			(
			SELECT A.OUTLINING_ASSESSMENT_DETIL_ID FROM OUTLINING_ASSESSMENT_AREA_DETIL B  
			WHERE A.OUTLINING_ASSESSMENT_DETIL_ID=B.OUTLINING_ASSESSMENT_DETIL_ID AND B.STATUS_CONFIRM = 0
			)";

			$settotal= new OutliningAssessment();
			$settotal->selectByParamsRekomendasiTotalArea(array(), -1,-1,$statement);
			// echo $settotal->query;
			$settotal->firstRow();
			$arrdata["TOTAL"]= $settotal->getField("TOTAL_AREA");

			$statement=" AND B.DISTRIK_ID=".$set->getField("DISTRIK_ID")." AND A.BLOK_UNIT_ID IN (".$set->getField("BLOK_UNIT_ID").")  AND A.OUTLINING_ASSESSMENT_ID= ".$set->getField("OUTLINING_ASSESSMENT_ID");

			$setterisi= new OutliningAssessment();
			$setterisi->selectByParamsRekomendasiJumlahAreaNew(array(), -1,-1,"",$statement);
			// echo $setterisi->query;
			$setterisi->firstRow();
			$arrdata["TERISI"]= $setterisi->getField("TERISI");

			$statement=" AND C.BLOK_UNIT_ID IN (".$set->getField("BLOK_UNIT_ID").") AND A.OUTLINING_ASSESSMENT_ID= ".$set->getField("OUTLINING_ASSESSMENT_ID");
			$setarea= new OutliningAssessment();
			$setarea->selectByParamsRekomendasiPercArea(array(), -1,-1,$statement);
			// echo $setarea->query; 
			$setarea->firstRow();
			$arrdata["PERC_AREA"]= $setarea->getField("PERC_AREA");

			if($setarea->getField("PERC_AREA") < 100)
			{
				$arrdata["STATUS"]="Belum Selesai";
			}
			else
			{
				$arrdata["STATUS"]="Selesai";
			}

			$no++;


			array_push($arrset, $arrdata);
		}
		unset($set);

		echo json_encode( $arrset, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	

	}

}