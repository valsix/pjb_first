<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->model("base-app/Notif");
$this->load->model("base-app/Crud");
$this->load->model("base/Users");
$this->load->model("base-app/Distrik");


$appuserkodehak= $this->appuserkodehak;
$appuserroleid= $this->appuserroleid;
$reqPenggunaid= $this->appuserid;
$appusername= $this->appusername;



$set= new Crud();
$statement=" AND A.KODE_HAK = '".$appuserkodehak."'";

$set->selectByParams(array(), -1, -1, $statement);
        // echo $set->query;exit;

$set->firstRow();
$reqPenggunaHakId= $set->getField("PENGGUNA_HAK_ID");
unset($set);

$statement="";
$statementdistrik="";

$arridDistrik=[];
$usersdistrik = new Users();
$usersdistrik->selectByPenggunaDistrik($reqPenggunaid);
    // echo $usersdistrik->query;exit;
while($usersdistrik->nextRow())
{
	$arridDistrik[]= $usersdistrik->getField("DISTRIK_ID"); 
}
$idDistrik = implode(",",$arridDistrik); 
if(!empty($idDistrik))
{
	$statementdistrik= " AND E.DISTRIK_ID IN (".$idDistrik.")";
} 

$statementstatus=" ";
$statement .=" AND A.REF_TABEL ='outlining_assessment'";
$set= new Notif();
$jmlOutliningAll= $set->getCountByParamsNotifOutlining(array(),$statementstatus,$appuserroleid, $statementdistrik.$statement);
// echo $set->query;exit;


$statementstatus=" AND APPR_STATUS = '0'";

$set= new Notif();
$jmlBelumOutlining= $set->getCountByParamsNotifOutlining(array(),$statementstatus,$appuserroleid, $statementdistrik.$statement);
// echo $set->query;exit;

unset($set);

$statementstatus=" AND APPR_STATUS = '1'";

$set= new Notif();
$jmlDraftOutlining= $set->getCountByParamsNotifOutlining(array(),$statementstatus,$appuserroleid, $statementdistrik.$statement);
// print_r($jmlProsesOutlining);exit;
unset($set);

$statementstatus=" AND APPR_STATUS = '10'";

$set= new Notif();
$jmlProsesOutlining= $set->getCountByParamsNotifOutlining(array(),$statementstatus,$appuserroleid, $statementdistrik.$statement);
// echo $set->query;exit;
// print_r($jmlProsesOutlining);exit;
unset($set);

$statementstatus=" AND APPR_STATUS = '20'";

$set= new Notif();
$jmlStjOutlining= $set->getCountByParamsNotifOutlining(array(),$statementstatus,$appuserroleid, $statementdistrik.$statement);
// print_r($jmlProsesOutlining);exit;
unset($set);

$statementstatus=" AND APPR_STATUS = '30'";

$set= new Notif();
$jmlReturnOutlining= $set->getCountByParamsNotifOutlining(array(),$statementstatus,$appuserroleid, $statementdistrik.$statement);
// print_r($jmlProsesOutlining);exit;
unset($set);

$statementstatus=" AND APPR_STATUS = '90'";

$set= new Notif();
$jmlRejectOutlining= $set->getCountByParamsNotifOutlining(array(),$statementstatus,$appuserroleid, $statementdistrik.$statement);
// echo $set->query;exit;

// print_r($jmlProsesOutlining);exit;
unset($set);

//REKOMENDASI
$statement="";
$statementstatus="";
$statementdistrik="";
if(!empty($idDistrik))
{
    $statementdistrik="  
    AND EXISTS
    (
    SELECT OUTLINING_ASSESSMENT_ID FROM OUTLINING_ASSESSMENT X WHERE X.OUTLINING_ASSESSMENT_ID = E.OUTLINING_ASSESSMENT_ID
    AND X.DISTRIK_ID IN (".$idDistrik.")
    )";
} 

$statement .=" AND A.REF_TABEL ='outlining_assessment_rekomendasi'";
$set= new Notif();
$jmlRekomendasiAll= $set->getCountByParamsNotifRekomendasi(array(),$statementstatus,$appuserroleid, $statementdistrik.$statement);
// echo $set->query;exit;
unset($set);

$statementstatus=" AND APPR_STATUS = '0'";

$set= new Notif();
$jmlBelumRekomendasi= $set->getCountByParamsNotifRekomendasi(array(),$statementstatus,$appuserroleid, $statementdistrik.$statement);
// echo $set->query;exit;


unset($set);

$statementstatus=" AND APPR_STATUS = '1'";

$set= new Notif();
$jmlDraftRekomendasi= $set->getCountByParamsNotifRekomendasi(array(),$statementstatus,$appuserroleid, $statementdistrik.$statement);
// print_r($jmlProsesRekomendasi);exit;
unset($set);

$statementstatus=" AND APPR_STATUS = '10'";

$set= new Notif();
$jmlProsesRekomendasi= $set->getCountByParamsNotifRekomendasi(array(),$statementstatus,$appuserroleid, $statementdistrik.$statement);
// print_r($jmlProsesRekomendasi);exit;
unset($set);

$statementstatus=" AND APPR_STATUS = '20'";

$set= new Notif();
$jmlStjRekomendasi= $set->getCountByParamsNotifRekomendasi(array(),$statementstatus,$appuserroleid, $statementdistrik.$statement);
// print_r($jmlProsesRekomendasi);exit;
unset($set);

$statementstatus=" AND APPR_STATUS = '30'";

$set= new Notif();
$jmlReturnRekomendasi= $set->getCountByParamsNotifRekomendasi(array(),$statementstatus,$appuserroleid, $statementdistrik.$statement);
// print_r($jmlProsesRekomendasi);exit;
unset($set);

$statementstatus=" AND APPR_STATUS = '90'";

$set= new Notif();
$jmlRejectRekomendasi= $set->getCountByParamsNotifRekomendasi(array(),$statementstatus,$appuserroleid, $statementdistrik.$statement);
// print_r($jmlProsesRekomendasi);exit;
unset($set);

$set= new Distrik();
$jmlDistrik= $set->getCountByParamsPenggunaDistrik(array()," ");
// print_r($jmlDistrik);exit;
unset($set);

$jumlahdistrik = substr_count($idDistrik, ',') + 1;
$alldis="";
if($jumlahdistrik == $jmlDistrik )
{
   $alldis=" All Distrik";
}


$set= new Distrik();
$statement=" AND A.NAMA IS NOT NULL AND A.DISTRIK_ID IN (".$idDistrik.")";
$arrdistrik= [];
$set->selectByParams(array(), 30,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("DISTRIK_ID");
    $arrdata["kode"]=  $set->getField("KODE");
    $arrdata["text"]=  $set->getField("NAMA");
    array_push($arrdistrik, $arrdata);
}
unset($set);

$foto = new Users();
$foto->selectByPenggunaFoto(" AND A.PENGGUNA_ID=".$reqPenggunaid);
// echo $foto->query;exit;
$foto->firstRow();
$reqLinkFoto= $foto->getField("FOTO_EKT");
$reqUsername= $foto->getField("USERNAME");
$reqPenggunaInternalid= $foto->getField("PENGGUNA_INTERNAL_ID");


unset($foto);

if($reqPenggunaHakId==1 || $reqPenggunaHakId==7)
{
  $statement ="  
     AND A.REF_TABEL ='1002'  ";
} 
else
{
  $statement =" AND  B.ROLE_ID = ".$appuserroleid."   
     AND A.REF_TABEL ='1002'  ";
}

$checkrole = new Notif();
$checkrole->selectcheckapprekom(array(), $statement);
// echo $checkrole->query;exit;
$checkrole->firstRow();
$reqCheckRekomendasi= $checkrole->getField("ROLE_ID");

unset($checkrole);

$statement="";
if($reqPenggunaHakId==7)
{
  $statement .= " AND E.OUTLINING_ASSESSMENT_REKOMENDASI_ID IS NULL ";
}
elseif ($reqPenggunaHakId==1)
{
  $statement .= "";
}
else
{
  $statement .= " AND E.OUTLINING_ASSESSMENT_REKOMENDASI_ID IS NOT NULL AND E.KETERANGAN ='' ";
}

$set= new Notif();
$set->selectByParamsRekomendasiNull(array(),-1,-1, $statement);
// echo $set->query;exit;
$set->firstRow();
$reqJmlLanjut= $set->getField("JUMLAH");

// print_r($jmlProsesRekomendasi);exit;
unset($set);



// print_r($idDistrik);exit;


?>
    <style type="text/css">
      body {
        /*background: #e0ebee ;  
        background:  linear-gradient(to right,#a5e1f1,#4d99cd);*/
        padding: 0;
        margin: 0;
        font-family: 'Lato', sans-serif;
        color: #000;
      }
      .student-profile .card {
        border-radius: 10px;
      }
      .student-profile .card .card-header .profile_img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        margin: 10px auto;
        border: 10px solid #ccc;
        border-radius: 50%;
      }
      .student-profile .card h3 {
        font-size: 20px;
        font-weight: 700;
      }
      .student-profile .card p {
        font-size: 16px;
        color: #000;
      }
      .student-profile .table th,
      .student-profile .table td {
        font-size: 14px;
        padding: 5px 10px;
        color: #000;

      </style>

      <div class="student-profile py-4">
        <div class="container">
          <div class="row">
            <div class="col-lg-4">
              <div class="card shadow-sm">
                <div class="card-header bg-transparent text-center">
                  <!-- <img class="profile_img" src="images/foto.png" alt="student dp"> -->
                  <?
                  if(file_exists($reqLinkFoto))
                  {
                  ?>
                    <img class="profile_img" src="<?=$reqLinkFoto?>" alt="student dp">
                  <?
                  }
                  else
                  {
                  ?>
                    <?
                    if(!empty($reqPenggunaInternalid))
                    {
                    ?>
                    <img class="profile_img" src="http://ldap.plnnusantarapower.co.id/profiles/photo.do?uid=<?=$reqUsername?>" alt="student dp">
                    <?
                    }
                    else
                    {
                    ?>
                      <img class="profile_img" src="images/foto.png" alt="student dp">
                    <?
                    }
                    ?>
                  <?
                  }
                  ?>
                 
                  
                  <h3><?=$this->appusernama?></h3>
                </div>
               <!--  <div class="card-body">
                  <p class="mb-0"><strong class="pr-1">Student ID:</strong>321000001</p>
                  <p class="mb-0"><strong class="pr-1">Class:</strong>4</p>
                </div> -->
              </div>
            </div>
            <div class="col-lg-8">
              <div class="card shadow-sm">
                <div class="card-header bg-transparent border-0">
                  <h3 class="mb-0"><i class="far fa-clone pr-1"></i>Informasi Pengguna</h3>
                </div>
                <div class="card-body pt-0">
                  <table class="table table-bordered">
                    <tr>
                      <th width="30%">Nama</th>
                      <td width="2%">:</td>
                      <td><?=$this->appusernama?></td>
                    </tr>
                    <tr>
                      <th width="30%">Role</th>
                      <td width="2%">:</td>
                      <td><?=$appuserkodehak?></td>
                    </tr>
                    <?
                    if(!empty($alldis))
                    {
                    ?>
                      <tr>
                        <th width="30%">Unit</th>
                        <td width="2%">:</td>
                        <td><?=$alldis?></td>
                      </tr>
                    <?
                    }
                    else
                    {
                        foreach ($arrdistrik as $key => $value) 
                        { 
                    ?>
                        <tr>
                          <?
                          if($key==0)
                          {
                          ?>
                          <th width="30%">Unit</th>
                          <?
                          }
                          else
                          {
                          ?>
                          <th width="30%"></th>
                           <?
                          }
                          ?>
                          <td width="2%">:</td>
                          <?
                          if(!empty($value["text"]))
                          {
                          ?>
                            <td><?=$value["text"]?></td>
                          <?
                          }
                          else
                          {
                          ?>
                            <td>-</td>
                          <?
                          }
                          ?>

                        </tr>
                    <?
                        }
                    }
                    ?>
                  </table>
                </div>
              </div>
                <?
                if(!empty($appuserroleid) || $reqPenggunaHakId ==1)
                {
                ?>
                    <div class="card shadow-sm">
                      <div class="card-header bg-transparent border-0">
                        <h3 class="mb-0"><i class="far fa-clone pr-1"></i>Informasi Approval Outlining</h3>
                      </div>
                      <div class="card-body pt-0">
                        <table class="table table-bordered">
                          <tr>
                            <th width="30%">Belum Disetujui </th>
                            <td width="2%">:</td>
                            <?
                            if($jmlBelumOutlining==0)
                            {
                            ?>
                            <td><?=$jmlBelumOutlining?></td>
                            <?
                            }
                            else
                            {
                            ?>
                            <td><a href="app/index/outlining_assessment_approval?reqVstatus=0"><?=$jmlBelumOutlining?></a>
                            </td>
                            <?
                            }
                            ?>
                          </tr>
                          <tr>
                            <th width="30%">Draft</th>
                            <td width="2%">:</td>
                            <?
                            if($jmlDraftOutlining==0)
                            {
                            ?>
                            <td><?=$jmlDraftOutlining?></td>
                            <?
                            }
                            else
                            {
                            ?>
                            <td><a href="app/index/outlining_assessment_approval?reqVstatus=1"><?=$jmlDraftOutlining?></a>
                            </td>
                            <?
                            }
                            ?>
                          </tr>
                          <tr>
                            <th width="30%"> On Proses</th>
                            <td width="2%">:</td>
                            <?
                            if($jmlProsesOutlining==0)
                            {
                            ?>
                            <td><?=$jmlProsesOutlining?></td>
                            <?
                            }
                            else
                            {
                            ?>
                            <td><a href="app/index/outlining_assessment_approval?reqVstatus=10"><?=$jmlProsesOutlining?></a>
                            </td>
                            <?
                            }
                            ?>
                          </tr>
                          <tr>
                            <th width="30%">Dikembalikan</th>
                            <td width="2%">:</td>
                            <?
                            if($jmlReturnOutlining==0)
                            {
                            ?>
                            <td><?=$jmlReturnOutlining?></td>
                            <?
                            }
                            else
                            {
                            ?>
                            <td><a href="app/index/outlining_assessment_approval?reqVstatus=30"><?=$jmlReturnOutlining?></a>
                            </td>
                            <?
                            }
                            ?>
                          </tr>
                           <tr>
                            <th width="30%">Ditolak</th>
                            <td width="2%">:</td>
                            <?
                            if($jmlRejectOutlining==0)
                            {
                            ?>
                            <td><?=$jmlRejectOutlining?></td>
                            <?
                            }
                            else
                            {
                            ?>
                            <td><a href="app/index/outlining_assessment_approval?reqVstatus=90"><?=$jmlRejectOutlining?></a>
                            </td>
                            <?
                            }
                            ?>
                          </tr>
                        </table>
                      </div>
                    </div>
                    <?
                    if(!empty($reqCheckRekomendasi))
                    {
                    ?>
                      <div class="card shadow-sm">
                        <div class="card-header bg-transparent border-0">
                          <h3 class="mb-0"><i class="far fa-clone pr-1"></i>Informasi Approval Rekomendasi</h3>
                        </div>
                        <div class="card-body pt-0">
                          <table class="table table-bordered">
                            <tr>
                              <th width="30%">Belum Disetujui </th>
                              <td width="2%">:</td>
                              <?
                              if($jmlBelumRekomendasi==0)
                              {
                                ?>
                                <td><?=$jmlBelumRekomendasi?></td>
                                <?
                              }
                              else
                              {
                                ?>
                                <td><a href="app/index/rekomendasi_notif?reqVstatus=0"><?=$jmlBelumRekomendasi?></a>
                                </td>
                                <?
                              }
                              ?>
                            </tr>
                            <tr>
                              <th width="30%">Draft</th>
                              <td width="2%">:</td>
                              <?
                              if($jmlDraftRekomendasi==0)
                              {
                                ?>
                                <td><?=$jmlDraftRekomendasi?></td>
                                <?
                              }
                              else
                              {
                                ?>
                                <td><a href="app/index/rekomendasi_notif?reqVstatus=1"><?=$jmlDraftRekomendasi?></a>
                                </td>
                                <?
                              }
                              ?>
                            </tr>
                            <tr>
                              <th width="30%"> On Proses</th>
                              <td width="2%">:</td>
                              <?
                              if($jmlProsesRekomendasi==0)
                              {
                                ?>
                                <td><?=$jmlProsesRekomendasi?></td>
                                <?
                              }
                              else
                              {
                                ?>
                                <td><a href="app/index/rekomendasi_notif?reqVstatus=10"><?=$jmlProsesRekomendasi?></a>
                                </td>
                                <?
                              }
                              ?>
                            </tr>
                            <tr>
                              <th width="30%">Dikembalikan</th>
                              <td width="2%">:</td>
                              <?
                              if($jmlReturnRekomendasi==0)
                              {
                                ?>
                                <td><?=$jmlReturnRekomendasi?></td>
                                <?
                              }
                              else
                              {
                                ?>
                                <td><a href="app/index/rekomendasi_notif?reqVstatus=30"><?=$jmlReturnRekomendasi?></a>
                                </td>
                                <?
                              }
                              ?>
                            </tr>
                             <tr>
                              <th width="30%">Ditolak</th>
                              <td width="2%">:</td>
                              <?
                              if($jmlRejectRekomendasi==0)
                              {
                                ?>
                                <td><?=$jmlRejectRekomendasi?></td>
                                <?
                              }
                              else
                              {
                                ?>
                                <td><a href="app/index/rekomendasi_notif?reqVstatus=90"><?=$jmlRejectRekomendasi?></a>
                                </td>
                                <?
                              }
                              ?>
                            </tr>
                          </table>
                        </div>
                      </div>
                    <?
                    }
                    ?>

                    <div class="card shadow-sm">
                        <div class="card-header bg-transparent border-0">
                          <h3 class="mb-0"><i class="far fa-clone pr-1"></i>Informasi Tindak Lanjut</h3>
                        </div>
                        <div class="card-body pt-0">
                          <table class="table table-bordered">
                            <tr>
                              <th width="30%">Belum Diisi </th>
                              <td width="2%">:</td>
                              <td><?=$reqJmlLanjut?></td>
                            </tr>
                          </table>
                        </div>
                      </div>
                  <?
                  }
                  ?>
            </div>

          </div>
        </div>
      </div>

