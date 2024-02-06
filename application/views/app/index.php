<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->model("base-app/Approval");
$this->load->model("base-app/Crud");
$this->load->model("base/Users");
$this->load->model("base-app/Notif");
$this->load->model("base-app/Distrik");


$appuserpilihankodehak= $this->appuserpilihankodehak;
$arrpilihanmulti= explode(",", $this->appuserpilihankodehak);
// print_r($appuserpilihankodehak);exit;
$appuserkodehak= $this->appuserkodehak;
$appuserroleid= $this->appuserroleid;

$reqPenggunaid= $this->appuserid;
// echo $appuserroleid;exit;

$carigroup= "";
$infolinkmodul= $pg;
$infolinkmodul= str_replace("_add", "", $infolinkmodul);
// echo $infolinkmodul;exit;

$statement= " AND LINK_MODUL = '".$infolinkmodul."'";
$set= new Approval();
$set->selectmenu($appuserkodehak, $statement);
// echo $set->query;exit;
$set->firstRow();
$infodatagroupmodul= $set->getField("GROUP_MODUL");
// echo $infodatagroupmodul;exit;

$set= new Approval();
$set->selectmenu($appuserkodehak,' AND MENU = 1');
// echo $set->query;exit;
$arrMenu=[];
while($set->nextRow())
{
    $arrdata= [];
    $arrdata["ID"]= $set->getField("KODE_MODUL");
    $arrdata["ID_PARENT"]= $set->getField("LEVEL_MODUL");
    $arrdata["NAMA"]= $set->getField("MENU_MODUL");
    $arrdata["NAMA_GROUP"]= $set->getField("GROUP_MODUL");
    $arrdata["LINK_MODUL"]= $set->getField("LINK_MODUL");
    array_push($arrMenu, $arrdata);
}
// print_r($arrMenu);exit();



$set= new Crud();
$statement=" AND A.KODE_HAK = '".$appuserkodehak."'";

$set->selectByParams(array(), -1, -1, $statement);
        // echo $set->query;exit;

$set->firstRow();
$reqPenggunaHakId= $set->getField("PENGGUNA_HAK_ID");
unset($set);

$statement="";
$statementdistrik="";

if($reqPenggunaHakId==1)
{}
else
{
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
}

$statementstatus=" ";
$statement .=" AND A.REF_TABEL ='outlining_assessment'";
$set= new Notif();
$jmlOutliningAll= $set->getCountByParamsNotifOutlining(array(),$statementstatus,$appuserroleid, $statementdistrik.$statement);
// echo $set->query;exit;


unset($set);

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

$statementstatus=" ";
$statement =" AND A.REF_TABEL ='outlining_assessment_detil'";
$set= new Notif();
$jmlOutliningAllHasil= $set->getCountByParamsNotifOutlining(array(),$statementstatus,$appuserroleid, $statementdistrik.$statement);
// echo $set->query;exit;


unset($set);

$statementstatus=" AND APPR_STATUS = '0'";

$set= new Notif();
$jmlBelumOutliningHasil= $set->getCountByParamsNotifOutlining(array(),$statementstatus,$appuserroleid, $statementdistrik.$statement);
// echo $set->query;exit;


unset($set);

$statementstatus=" AND APPR_STATUS = '1'";

$set= new Notif();
$jmlDraftOutliningHasil= $set->getCountByParamsNotifOutlining(array(),$statementstatus,$appuserroleid, $statementdistrik.$statement);
// print_r($jmlProsesOutlining);exit;
unset($set);

$statementstatus=" AND APPR_STATUS = '10'";

$set= new Notif();
$jmlProsesOutliningHasil= $set->getCountByParamsNotifOutlining(array(),$statementstatus,$appuserroleid, $statementdistrik.$statement);
// echo $set->query;exit;
// print_r($jmlProsesOutlining);exit;
unset($set);

$statementstatus=" AND APPR_STATUS = '20'";

$set= new Notif();
$jmlStjOutliningHasil= $set->getCountByParamsNotifOutlining(array(),$statementstatus,$appuserroleid, $statementdistrik.$statement);
// print_r($jmlProsesOutlining);exit;
unset($set);

$statementstatus=" AND APPR_STATUS = '30'";

$set= new Notif();
$jmlReturnOutliningHasil= $set->getCountByParamsNotifOutlining(array(),$statementstatus,$appuserroleid, $statementdistrik.$statement);
// print_r($jmlProsesOutlining);exit;
unset($set);

$statementstatus=" AND APPR_STATUS = '90'";

$set= new Notif();
$jmlRejectOutliningHasil= $set->getCountByParamsNotifOutlining(array(),$statementstatus,$appuserroleid, $statementdistrik.$statement);
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
$jmlRejectRekomendasi= $set->getCountByParamsNotifRekomendasi(array(),$statementstatus,"", $statementdistrik.$statement);
// echo $set->query;exit;
// print_r($jmlRejectRekomendasi);exit;
unset($set);

// $set= new Users();
// $statement=" AND A.PENGGUNA_ID = '".$reqPenggunaid."'";

// $set->selectByPenggunaDetail($statement);
// // echo $set->query;exit;
// $set->firstRow();
// $urlFoto= $set->getField("FOTO");
// unset($set);

$foto = new Users();
$foto->selectByPenggunaFoto(" AND A.PENGGUNA_ID=".$reqPenggunaid);
// echo $foto->query;exit;
$foto->firstRow();
$reqLinkFoto= $foto->getField("FOTO_EKT");
$reqUsername= $foto->getField("USERNAME");
$reqPenggunaInternalid= $foto->getField("PENGGUNA_INTERNAL_ID");


unset($foto);

// $arrDistrik=[];
// $set= new Distrik();

// $statement=" AND A.DISTRIK_ID IN ('".$idDistrik."')";


// $set->selectByParams(array(),-1,-1,$statement);
// // echo $set->query;exit;
// $set->firstRow();
// $urlFoto= $set->getField("FOTO");
// unset($set);

$statement="";
if($reqPenggunaHakId==8 || $reqPenggunaHakId==7) 
{
  $statement .= " AND 1=2 ";
}
elseif ($reqPenggunaHakId==1)
{
  $statement .= "";
}
else
{
  $statement .= " AND E.OUTLINING_ASSESSMENT_REKOMENDASI_ID IS NOT NULL  AND E.KETERANGAN ='' AND  E.V_STATUS=20  ";
}

$set= new Notif();
$set->selectByParamsRekomendasiNull(array(),-1,-1, $statement);
// echo $set->query;exit;
$set->firstRow();
$reqJmlLanjut= $set->getField("JUMLAH");

// print_r($reqPenggunaHakId);exit;
unset($set);




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$this->configtitle["home"]?></title>
    <base href="<?=base_url();?>" />

    <link rel="stylesheet" href="assets/AdminLTE-3.1.0/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="assets/AdminLTE-3.1.0/dist/css/adminlte.min.css">
    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase.js"></script>
    <link href="assets/bootstrap-3.3.7/docs/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/bootstrap-3.3.7/docs/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <script src="assets/bootstrap-3.3.7/docs/assets/js/ie-emulation-modes-warning.js"></script>

    <link rel="stylesheet" href="css/halaman.css" type="text/css">
    <link rel="stylesheet" href="css/gaya-egateway.css" type="text/css">
    <link rel="stylesheet" href="css/gaya-datatable-egateway.css" type="text/css">
    <link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.css">
    <script type='text/javascript' src="assets/bootstrap/js/jquery-1.12.4.min.js"></script>

    <link rel="stylesheet" type="text/css" href="assets/DataTables-1.10.7/extensions/Responsive/css/dataTables.responsive.css">
    <link rel="stylesheet" type="text/css" href="assets/DataTables-1.10.7/examples/resources/syntax/shCore.css">
    <link rel="stylesheet" type="text/css" href="assets/DataTables-1.10.7/examples/resources/demo.css">
    
    <script type="text/javascript" language="javascript" src="assets/DataTables-1.10.7/media/js/jquery.js"></script>
    <script type="text/javascript" language="javascript" src="assets/DataTables-1.10.7/media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" language="javascript" src="assets/DataTables-1.10.7/extensions/Responsive/js/dataTables.responsive.js"></script>
    <script type="text/javascript" language="javascript" src="assets/DataTables-1.10.7/examples/resources/syntax/shCore.js"></script>
    <script type="text/javascript" language="javascript" src="assets/DataTables-1.10.7/examples/resources/demo.js"></script>

    <link rel="stylesheet" type="text/css" href="assets/drupal-pagination/pagination.css" />

    <script src="assets/js/valsix-serverside.js"></script>

    <script src="assets/bootstrap-3.3.7/docs/dist/js/bootstrap.min.js"></script>
    <script src="assets/bootstrap-3.3.7/docs/assets/js/ie10-viewport-bug-workaround.js"></script>

      <!-- EASYUI 1.4.5 -->
    <link rel="stylesheet" type="text/css" href="assets/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="assets/easyui/themes/icon.css">
    <script type="text/javascript" src="assets/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="assets/easyui/datagrid-groupview.js"></script>
    <script type="text/javascript" src="assets/easyui/globalfunction.js"></script>
    <script type="text/javascript" src="assets/easyui/kalender-easyui.js"></script>    

    

    <!-- select multi -->
    <link href="assets/select2/select2.min.css" rel="stylesheet" />
    <script src="assets/select2/select2.min.js"></script>
    <link href="assets/select2totreemaster/src/select2totree.css" rel="stylesheet">
    <script src="assets/select2totreemaster/src/select2totree.js"></script>
        
    <script type="text/javascript">
        $(document).ready(function() {
            $('.jscaribasicmultiple').select2();
        });
    </script>

    <!-- TAMBAHAN UNTUK ALERT -->
    <link href="assets/mbox/mbox.css" rel="stylesheet">
    <script src="assets/mbox/mbox.js"></script>
    <link href="assets/mbox/mbox-modif.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="css/gaya-notif.css">

    <style type="text/css">
        [class*="sidebar-dark-"] .nav-sidebar > .nav-item.menu-open > .nav-link,
        [class*="sidebar-dark-"] .nav-sidebar > .nav-item:hover > .nav-link,
        [class*="sidebar-dark-"] .nav-sidebar > .nav-item > .nav-link:focus {
          background-color: rgba(255, 255, 255, 0.1);
          color: #333333;
        }

        .notification {
          color: white;
          text-decoration: none;
          padding: 15px 50px;
          position: relative;
          display: inline-block;
          border-radius: 2px;

         
        }

        .notification:hover {
          background: red;
        }

        .notification .badge {
          position: absolute;
          top: -2px;
          right: 12px;
          padding: 5px 10px;
          border-radius: 50%;
          background: red;
          color: white;
        }

        .dropdown-new {
              position: absolute;
              right: 0;
              left: auto;
              width: 280px;
              padding: 0 0 0 0;
              margin: 0;
              top: 100%;
          }

          .modal-header .close {
            margin-top: -9px;
          }

    </style>
</head>

<body>
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item menu-bars">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block <? if($pg == "" || $pg == "home"|| $pg == "home_logsheet"|| $pg == "home_pemeliharaan"){?>active<? } ?>">
                    <a href="app/" class="nav-link"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">

                <!-- <li>&nbsp;&nbsp;</li> -->
             <!--    <li class="nav-item">
                    <a class="nav-link logout"  data-toggle="modal" data-target="#myModal"><i class="fa fa-key fa-xs"></i> Ubah Password</a>
                </li> -->
                <?
                if(!empty($appuserroleid))
                {
                ?>
                <li class="dropdown dropdown-info-user" style=" margin-right: 30px">
                    <a href="#" class="dropdown-toggle notification" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell"></i>
                        <span class="badge" style="font-size: 11.5px;"><?=$jmlOutliningAll+$jmlRekomendasiAll+$reqJmlLanjut+$jmlOutliningAllHasil?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-test" style="width: 100%;min-width: 250px; ">
                        <?
                        if($jmlOutliningAll > 0)
                        {
                        ?>
                            <li class="header" >Anda Punya <?=$jmlOutliningAll?>  Notifikasi Outlining</li>
                        <?
                        }
                        else
                        {
                        ?>
                            <li class="header" >Anda Punya 0  Notifikasi Approval</li>
                        <?
                        }
                        ?>
                        <?
                        if($jmlOutliningAll > 0)
                        {
                        ?>
                            <li>
                                <div >
                                    <ul class="menu" style="border-right: 0px;border-left: 0px;border-bottom: 0px; position: relative;" >
                                        <li style="border-bottom: 1px solid ;">
                                          <a href="app/index/outlining_assessment_approval">
                                            <i class="fa fa-database text-aqua"></i>&nbsp;&nbsp; Lihat Semua
                                          </a>
                                        </li>

                                        <?
                                        if($jmlBelumOutlining > 0)
                                        {
                                        ?>
                                       
                                            <li style="border-bottom: 1px solid ;">
                                                <a href="app/index/outlining_assessment_approval?reqVstatus=0">
                                                    <i class="fa fa-times text-aqua"></i>&nbsp;&nbsp; <?=$jmlBelumOutlining?>  Belum Disetujui
                                                </a>
                                            </li>
                                        <?
                                        }
                                        ?>

                                        <?
                                        if($jmlDraftOutlining > 0)
                                        {
                                        ?>
                                       
                                        <li style="border-bottom: 1px solid ;">
                                          <a href="app/index/outlining_assessment_approval?reqVstatus=1">
                                            <i class="fa fa-file-text-o text-yellow"></i>&nbsp;&nbsp; <?=$jmlDraftOutlining?>  Draft
                                          </a>
                                        </li>

                                        <?
                                        }
                                        ?>

                                        <?
                                        if($jmlProsesOutlining > 0)
                                        {
                                        ?>
                                       
                                        <li style="border-bottom: 1px solid ;">
                                          <a href="app/index/outlining_assessment_approval?reqVstatus=10">
                                            <i class="fa fa-refresh text-red"></i>&nbsp;&nbsp; <?=$jmlProsesOutlining?>  On Proses
                                          </a>
                                        </li>

                                        <?
                                        }
                                        ?>
                                       
                                        <?
                                        if($jmlStjOutlining > 0)
                                        {
                                        ?>

                                        <!-- <li style="border-bottom: 1px solid ;">
                                          <a href="app/index/outlining_assessment_approval?reqVstatus=20">
                                            <i class="fa fa-check text-green"></i>&nbsp; <?=$jmlStjOutlining?>  Disetujui
                                          </a>
                                        </li> -->

                                        <?
                                        }
                                        ?>

                                        <?
                                        if($jmlReturnOutlining > 0)
                                        {
                                        ?>
                                       
                                        <li style="border-bottom: 1px solid ;">
                                          <a href="app/index/outlining_assessment_approval?reqVstatus=30">
                                            <i class="fa fa-reply text-yellow"></i>&nbsp; <?=$jmlReturnOutlining?>  Dikembalikan
                                          </a>
                                        </li>

                                        <?
                                        }
                                        ?>

                                        <?
                                        if($jmlRejectOutlining > 0)
                                        {
                                        ?>
                                        
                                        <li style="border-bottom: 1px solid ;">
                                          <a href="app/index/outlining_assessment_approval?reqVstatus=90">
                                            <i class="fa fa-reply text-red"></i>&nbsp; <?=$jmlRejectOutlining?>  Ditolak
                                          </a>
                                        </li>

                                        <?
                                        }
                                        ?>
                                    
                                    </ul>

                                </div>
                            </li>

                        <?
                        }
                        ?>

                        <?
                        if($jmlOutliningAllHasil > 0)
                        {
                        ?>
                            <li class="header" >Anda Punya <?=$jmlOutliningAllHasil?>  Notifikasi Outlining Hasil</li>
                        <?
                        }
                        else
                        {
                        ?>
                            <!-- <li class="header" >Anda Punya 0  Notifikasi Approval Hasil</li> -->
                        <?
                        }
                        ?>
                        <?
                        if($jmlOutliningAllHasil > 0)
                        {
                        ?>
                            <li>
                                <div >
                                    <ul class="menu" style="border-right: 0px;border-left: 0px;border-bottom: 0px; position: relative;" >

                                        <?
                                        if($jmlBelumOutliningHasil > 0)
                                        {
                                        ?>
                                       
                                            <li style="border-bottom: 1px solid ;">
                                                <a href="app/index/outlining_assessment_approval?reqVstatus1=0">
                                                    <i class="fa fa-times text-aqua"></i>&nbsp;&nbsp; <?=$jmlBelumOutliningHasil?>  Belum Disetujui
                                                </a>
                                            </li>
                                        <?
                                        }
                                        ?>

                                        <?
                                        if($jmlDraftOutliningHasil > 0)
                                        {
                                        ?>
                                       
                                        <li style="border-bottom: 1px solid ;">
                                          <a href="app/index/outlining_assessment_approval?reqVstatus1=1">
                                            <i class="fa fa-file-text-o text-yellow"></i>&nbsp;&nbsp; <?=$jmlDraftOutliningHasil?>  Draft
                                          </a>
                                        </li>

                                        <?
                                        }
                                        ?>

                                        <?
                                        if($jmlProsesOutliningHasil > 0)
                                        {
                                        ?>
                                       
                                        <li style="border-bottom: 1px solid ;">
                                          <a href="app/index/outlining_assessment_approval?reqVstatus1=10">
                                            <i class="fa fa-refresh text-red"></i>&nbsp;&nbsp; <?=$jmlProsesOutliningHasil?>  On Proses
                                          </a>
                                        </li>

                                        <?
                                        }
                                        ?>
                                       
                                       

                                        <?
                                        if($jmlReturnOutliningHasil > 0)
                                        {
                                        ?>
                                       
                                        <li style="border-bottom: 1px solid ;">
                                          <a href="app/index/outlining_assessment_approval?reqVstatus1=30">
                                            <i class="fa fa-reply text-yellow"></i>&nbsp; <?=$jmlReturnOutliningHasil?>  Dikembalikan
                                          </a>
                                        </li>

                                        <?
                                        }
                                        ?>

                                        <?
                                        if($jmlRejectOutliningHasil > 0)
                                        {
                                        ?>
                                        
                                        <li style="border-bottom: 1px solid ;">
                                          <a href="app/index/outlining_assessment_approval?reqVstatus1=90">
                                            <i class="fa fa-reply text-red"></i>&nbsp; <?=$jmlRejectOutliningHasil?>  Ditolak
                                          </a>
                                        </li>

                                        <?
                                        }
                                        ?>
                                    
                                    </ul>

                                </div>
                            </li>

                        <?
                        }
                        ?>
                        <?
                        $jmlRekomendasiAll=$jmlBelumRekomendasi+$jmlDraftRekomendasi+$jmlProsesRekomendasi+$jmlReturnRekomendasi+$jmlRejectRekomendasi;
                        if($jmlRekomendasiAll > 0)
                        {
                        ?>
                         <div style="border: 1px solid"></div>
                         <li class="header" >Anda Punya <?=$jmlRekomendasiAll?>  Notifikasi Rekomendasi</li>
                         <li>
                                <div >
                                    <ul class="menu" style="border-right: 0px;border-left: 0px;border-bottom: 0px; position: relative;" >
                                         <li style="border-bottom: 1px solid ;">
                                            <a href="app/index/outlining_assessment_rekomendasi?reqNotif=1">
                                                <i class="fa fa-database text-aqua"></i>&nbsp;&nbsp; Lihat Semua
                                            </a>
                                        </li>

                                        <?
                                        if($jmlBelumRekomendasi > 0)
                                        {
                                        ?>

                                        <li style="border-bottom: 1px solid ;">
                                            <a href="app/index/rekomendasi_notif?reqVstatus=0">
                                                <i class="fa fa-times text-aqua"></i>&nbsp;&nbsp; <?=$jmlBelumRekomendasi?>  Belum Disetujui
                                            </a>
                                        </li>

                                        <?
                                        }
                                        ?>

                                        <?
                                        if($jmlDraftRekomendasi > 0)
                                        {
                                        ?>

                                        <li style="border-bottom: 1px solid ;">
                                            <a href="app/index/rekomendasi_notif?reqVstatus=1">
                                              <i class="fa fa-file-text-o text-yellow"></i>&nbsp;&nbsp; <?=$jmlDraftRekomendasi?>  Draft
                                            </a>
                                        </li>

                                        <?
                                        }
                                        ?>

                                        <?
                                        if($jmlProsesRekomendasi > 0)
                                        {
                                        ?>   
                                        <li style="border-bottom: 1px solid ;">
                                            <a href="app/index/rekomendasi_notif?reqVstatus=10">
                                            <i class="fa fa-refresh text-red"></i>&nbsp;&nbsp; <?=$jmlProsesRekomendasi?>  On Proses
                                            </a>
                                        </li>

                                        <?
                                        }
                                        ?>

                                        <?
                                        if($jmlStjRekomendasi > 0)
                                        {
                                        ?>
                                           
                                        <?
                                        }
                                        ?>

                                        <?
                                        if($jmlReturnRekomendasi > 0)
                                        {
                                        ?>
                                      
                                        <li style="border-bottom: 1px solid ;">
                                            <a href="app/index/rekomendasi_noti?reqVstatus=30">
                                            <i class="fa fa-reply text-yellow"></i>&nbsp; <?=$jmlReturnRekomendasi?>  Dikembalikan
                                             </a>
                                        </li>

                                        <?
                                        }
                                        ?>

                                        <?
                                        if($jmlRejectRekomendasi > 0)
                                        {
                                        ?>
                                            
                                        <li style="border-bottom: 1px solid ;">
                                            <a href="app/index/rekomendasi_notif?reqVstatus=90">
                                            <i class="fa fa-reply text-red"></i>&nbsp; <?=$jmlRejectRekomendasi?>  Ditolak
                                            </a>
                                        </li>

                                        <?
                                        }
                                        ?>
                                    
                                    </ul>
                                </div>
                            </li>
                                        
                                 
                        <?
                        }
                        ?>
                        <?
                        if($reqJmlLanjut > 0)
                        {
                        ?>
                        <div style="border: 1px solid"></div>
                        <li class="header" >Anda Punya <?=$reqJmlLanjut?>  Notifikasi Tindak Lanjut</li>
                        <li>
                            <div >
                                <ul class="menu" style="border-right: 0px;border-left: 0px;border-bottom: 0px; position: relative;" >
                                    <li>
                                        <a href="app/index/tindak_lanjut?reqNotif=1">
                                            <i class="fa fa-times text-aqua"></i>&nbsp;&nbsp; <?=$reqJmlLanjut?>  Belum Diisi
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <?
                        }
                        ?>
                    </ul>
                </li>
                <?
                }
                ?>

                <?
                if(count($arrpilihanmulti) > 1)
                {
                ?>
                <li class="nav-item" style=" margin-top: 10px">
                    <a class="nav-link logout" href="app/gantirule"><i class="fa fa-edit fa-xs"></i> Ganti Role</a>
                </li>
                <?
                }
                ?>
                <li>&nbsp;&nbsp;</li>

                <li class="nav-item" style=" margin-top: 10px">
                    <a class="nav-link logout" href="doc/dokumen_penggunaan_first.pdf" target="_blank"><i class="fa fa-question-circle" aria-hidden="true"></i>&nbsp; Help</a>
                </li>

                <li>&nbsp;&nbsp;</li>
                <li class="nav-item" style=" margin-top: 10px">
                    <a class="nav-link logout" href="login/logout"><i class="fa fa-sign-out fa-xs"></i> Logout</a>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4 bg-blur">
            <a href="app/" class="brand-link" style="position: relative;">
                <img src="images/logo_new.png" class="img-responsive"> 
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex" style="margin-bottom: 0px !important;">
                    <div class="image">
                        <?
                        if(file_exists($reqLinkFoto))
                        {
                          ?>
                          <img src="<?=$reqLinkFoto?>" class="img-circle elevation-2" alt="User Image">
                          <?
                        }
                        else
                        {
                          ?>
                            <?
                            if(!empty($reqPenggunaInternalid))
                            {
                            ?>
                            <img src="http://ldap.plnnusantarapower.co.id/profiles/photo.do?uid=<?=$reqUsername?>" class="img-circle elevation-2" alt="User Image">
                            <?
                            }
                            else
                            {
                            ?>
                              <img src="images/foto.png" class="img-circle elevation-2" alt="User Image">
                            <?
                            }
                            ?>
                        <?
                        }
                        ?>
                    </div>
                    <div class="info" style="min-height: 0px !important;">
                       <!--  <a href="#" class="d-block">
                            <div class="user-login"><?=$this->USER_LOGIN?> <br><?=$this->USER_NAMA?></div>
                            <div class="distrik"><?=coalesce($this->CABANG, $this->DISTRIK)?></div>
                        </a> -->
                        <div class="jabatan"> <?=ucwords(strtolower($this->appusernama))?> </div>
                        <div class="jabatan">Role : <?=$appuserkodehak?></div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <?
                function getmenubyparent($infoid, $arrMenu, $infolinkmodul)
                {
                    $arrayKey= [];
                    $arrayKey= in_array_column($infoid, "ID_PARENT", $arrMenu);
                    // print_r($arrayKey);exit;
                    foreach ($arrayKey as $valkey => $indexkey) 
                    {
                        $infoid= $arrMenu[$indexkey]["ID"];
                        $infonama= $arrMenu[$indexkey]["NAMA"];
                        $infolink= $arrMenu[$indexkey]["LINK_MODUL"];

                        $infoactive= "";
                        if($infolinkmodul == $infolink)
                            $infoactive= "active";
                ?>
                    <a class=" <?=$infoactive?>" href="app/index/<?=$infolink?>"><?=$infonama?></a>
                <?
                    }
                }
                ?>

                <nav class="mt-2" id="myDIV">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <?
                        $arrayKey= [];
                        $arrayKey= in_array_column("0", "ID_PARENT", $arrMenu);
                        // print_r($arrayKey);exit;
                        foreach ($arrayKey as $valkey => $indexkey) 
                        {
                            $infoid= $arrMenu[$indexkey]["ID"];
                            $infogroupmodul= $arrMenu[$indexkey]["NAMA_GROUP"];
                            $infonama= $arrMenu[$indexkey]["NAMA"];
                            $infolink= $arrMenu[$indexkey]["LINK_MODUL"];
                        ?>
                        <li class="nav-item <?=(stristr($infogroupmodul, $infodatagroupmodul) ? "menu-is-opening menu-open" : "")?>">
                            <a href="<?=$infolink?>" class="nav-link <?=(stristr($infogroupmodul, $infodatagroupmodul) ? "active" : "")?>"><strong><?=$infonama?></strong>
                            <span class="<? if($infogroupmodul == $infodatagroupmodul){ ?>caret<? } else {?>arrow-right<? } ?>"></span></a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <?=getmenubyparent($infoid, $arrMenu, $infolinkmodul);?>
                                </li>
                            </ul>
                        </li>
                        <?
                        }
                        ?>
                    </ul>

                </nav>
            </div>
      </aside>

      <div class="content-wrapper">

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <?=($content ? $content:'')?>
                </div>
            </div>
        </div>

      </div>

      <aside class="control-sidebar control-sidebar-dark">
      </aside>

    </div>

    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>

    
    <!-- SCROLLBAR -->
    <script type='text/javascript' src="assets/js/enscroll-0.6.0.min.js"></script>
    <script type='text/javascript'>//<![CDATA[
    $(function(){
        $('.operator-inner').enscroll({
            showOnHover: false,
            verticalTrackClass: 'track3',
            verticalHandleClass: 'handle3'
        });
    });//]]> 
    
    </script>
    
    <!-- EMODAL -->
    <script src="assets/emodal/eModal.js"></script>
    <script src="assets/emodal/eModal-cabang.js"></script>
    
    <script>
    function openAdd(pageUrl) {
        eModal.iframe(pageUrl, '')
    }
    function openCabang(pageUrl) {
        eModalCabang.iframe(pageUrl, '')
    }
    function closePopup() {
        eModal.close();
    }
    
    function windowOpener(windowHeight, windowWidth, windowName, windowUri)
    {
        var centerWidth = (window.screen.width - windowWidth) / 2;
        var centerHeight = (window.screen.height - windowHeight) / 2;
    
        newWindow = window.open(windowUri, windowName, 'resizable=0,width=' + windowWidth + 
            ',height=' + windowHeight + 
            ',left=' + centerWidth + 
            ',top=' + centerHeight);
    
        newWindow.focus();
        return newWindow.name;
    }
    
    function windowOpenerPopup(windowHeight, windowWidth, windowName, windowUri)
    {
        var centerWidth = (window.screen.width - windowWidth) / 2;
        var centerHeight = (window.screen.height - windowHeight) / 2;
    
        newWindow = window.open(windowUri, windowName, 'resizable=1,scrollbars=yes,width=' + windowWidth + 
            ',height=' + windowHeight + 
            ',left=' + centerWidth + 
            ',top=' + centerHeight);
    
        newWindow.focus();
        return newWindow.name;
    }
    
    </script>
    
    <?
    if($pg == "verifikasi_pr_group_number_detil" || $pg == "pr_group_number_detil"){
    ?>

    <link rel="stylesheet" href="assets/ScrollingTable-master/style.css" />
    <script src="assets/ScrollingTable-master/scrollingtable.js"></script>
    <script>
        $('#Demo').ScrollingTable();
    </script>
    <?
    }
    ?>
    
    <!-- SELECTED ROW ON TABLE SCROLLING -->
    <style>
    *table#Demo tbody tr:nth-child(odd){ background-color: #ddf7ef;}
    table#Demo tbody tr:hover{background-color: #333; color: #FFFFFF;}
    table#Demo tbody tr.selectedRow{background-color: #0072bc; color: #FFFFFF;}
    </style>
    <script>
    $("table#Demo tbody tr").click(function(){
        //alert("haii");
        $("table tr").removeClass('selectedRow');
        $(this).addClass('selectedRow');
    });
    </script>
    
    <!-- CHANGE BGCOLOR WHEN SCROLL -->
    <script>
    $(function () {
      $(document).scroll(function () {
        var $nav = $(".navbar-fixed-top");
        $nav.toggleClass('scrolled', $(this).scrollTop() > $nav.height());
      });
    });
    </script>
    <style>
    .navbar-fixed-top.scrolled {
      background-color: #2b2655 !important;
      transition: background-color 1000ms linear;
    }
    </style>
    
    <?
    if($pg = "data_wo_detil")
    {
    ?>
    <script type="text/javascript" src="assets/fancyBox-master/source/jquery.fancybox.pack.js?v=2.1.5"></script>
    <link rel="stylesheet" type="text/css" href="assets/fancyBox-master/source/jquery.fancybox.css?v=2.1.5" media="screen" />

    <script type="text/javascript">
        $(document).ready(function() {
            /*
             *  Simple image gallery. Uses default settings
             */

            $('.fancybox').fancybox();

            /*
             *  Different effects
             */

            // Change title type, overlay closing speed
            $(".fancybox-effects-a").fancybox({
                helpers: {
                    title : {
                        type : 'outside'
                    },
                    overlay : {
                        speedOut : 0
                    }
                }
            });

            // Disable opening and closing animations, change title type
            $(".fancybox-effects-b").fancybox({
                openEffect  : 'none',
                closeEffect : 'none',

                helpers : {
                    title : {
                        type : 'over'
                    }
                }
            });

            // Set custom style, close if clicked, change title type and overlay color
            $(".fancybox-effects-c").fancybox({
                wrapCSS    : 'fancybox-custom',
                closeClick : true,

                openEffect : 'none',

                helpers : {
                    title : {
                        type : 'inside'
                    },
                    overlay : {
                        css : {
                            'background' : 'rgba(238,238,238,0.85)'
                        }
                    }
                }
            });

            // Remove padding, set opening and closing animations, close if clicked and disable overlay
            $(".fancybox-effects-d").fancybox({
                padding: 0,

                openEffect : 'elastic',
                openSpeed  : 150,

                closeEffect : 'elastic',
                closeSpeed  : 150,

                closeClick : true,

                helpers : {
                    overlay : null
                }
            });

            /*
             *  Button helper. Disable animations, hide close button, change title type and content
             */

            $('.fancybox-buttons').fancybox({
                openEffect  : 'none',
                closeEffect : 'none',

                prevEffect : 'none',
                nextEffect : 'none',

                closeBtn  : false,

                helpers : {
                    title : {
                        type : 'inside'
                    },
                    buttons : {}
                },

                afterLoad : function() {
                    this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
                }
            });


            /*
             *  Thumbnail helper. Disable animations, hide close button, arrows and slide to next gallery item if clicked
             */

            $('.fancybox-thumbs').fancybox({
                prevEffect : 'none',
                nextEffect : 'none',

                closeBtn  : false,
                arrows    : false,
                nextClick : true,

                helpers : {
                    thumbs : {
                        width  : 50,
                        height : 50
                    }
                }
            });

            /*
             *  Media helper. Group items, disable animations, hide arrows, enable media and button helpers.
            */
            $('.fancybox-media')
                .attr('rel', 'media-gallery')
                .fancybox({
                    openEffect : 'none',
                    closeEffect : 'none',
                    prevEffect : 'none',
                    nextEffect : 'none',

                    arrows : false,
                    helpers : {
                        media : {},
                        buttons : {}
                    }
                });

            /*
             *  Open manually
             */

            $("#fancybox-manual-a").click(function() {
                $.fancybox.open('1_b.jpg');
            });

            $("#fancybox-manual-b").click(function() {
                $.fancybox.open({
                    href : 'iframe.html',
                    type : 'iframe',
                    padding : 5
                });
            });

            $("#fancybox-manual-c").click(function() {
                $.fancybox.open([
                    {
                        href : '1_b.jpg',
                        title : 'My title'
                    }, {
                        href : '2_b.jpg',
                        title : '2nd title'
                    }, {
                        href : '3_b.jpg'
                    }
                ], {
                    helpers : {
                        thumbs : {
                            width: 75,
                            height: 50
                        }
                    }
                });
            });


        });
    </script>
    <style type="text/css">
        .fancybox-custom .fancybox-skin {
            *box-shadow: 0 0 50px #222;
        }
    </style>
    
    <script>
    $(function() {
    // OPACITY OF BUTTON SET TO 0%
    $(".roll").css("opacity","0");
     
    // ON MOUSE OVER
    $(".roll").hover(function () {
     
    // SET OPACITY TO 70%
    $(this).stop().animate({
    opacity: .7
    }, "fast");
    },
                  
     
    // ON MOUSE OUT
    function () {
     
    // SET OPACITY BACK TO 50%
    $(this).stop().animate({
    opacity: 0
    }, "slow");
    });
    });
    </script>
    
    <? } ?>
      
    <script src="assets/jquery-vertical-sidenav-accordeon/js/sidebar-accordion.js"></script>
    <script src="assets/AdminLTE-3.1.0/dist/js/adminlte.js"></script>
    <script type="text/javascript">

    var socket;
    
    // initWebSocket();

    function initWebSocket() {
      // socket = new WebSocket('<?=$this->config->item('base_websocket')?>?token=<?=$this->TOKEN_USER_LOGIN?>');
       socket = new WebSocket('<?=$this->config->item('base_websocket')?>?token=<?=$this->TOKEN_USER_LOGIN?>');


      socket.onopen = function(e) {
        console.log('onopen', e);
        socket.onclose = function(event) {
          if(event.reason != "force_close"){
            initWebSocket();
          }
          console.log('onclose', event);
        };
      };

      socket.onerror = function(error) {
        console.log('onerror', error);
        initWebSocket();
      };
    }

    $(window).scroll(function(){
        if ($(this).scrollTop() > 50) {
            $('.judul-halaman').addClass('stickyClass');
            $('#bluemenu.aksi-area').addClass('stickyClass');
            $('#example_filter.dataTables_filter').addClass('stickyClass');

        } else {
            $('.judul-halaman').removeClass('stickyClass');
            $('#bluemenu.aksi-area').removeClass('stickyClass');
            $('#example_filter.dataTables_filter').removeClass('stickyClass');
        }
    });
    </script>
    
    <div id="myModal" class="modal fade modal-lupa-password" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><strong>Ubah Password</strong></h4>
          </div>
          <div class="modal-body">
              <form class="form-horizontal">
                <?
                if(!empty($this->USER_LOGIN_ID_APP))
                {
                ?>
                  <div class="form-group">
                      <label class="control-label col-sm-4" for="nid">Password Baru</label>
                      <div class="col-sm-8">
                          <input type="password" class="form-control" id="password" placeholder="Masukkan password baru">
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label col-sm-4" for="nid">Ulangi Password</label>
                      <div class="col-sm-8">
                          <input type="password" class="form-control" id="password2" placeholder="Ulangi password baru">
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label col-sm-4 tombol" >&nbsp;</label>
                      <div class="col-sm-8">
                          <button class="btn btn-primary" type="button" onclick="ubahPassword()"><span id="spanLogin">Submit</span><div id="spanLoading" class="loader" style="display:none">Loading...</div></button>
                      </div>
                  </div>

                  <script type="text/javascript">
                                      
                        function ubahPassword()
                        {

                            var password  = $("#password").val();
                            var password2 = $("#password2").val();

                            if(password.trim() == "")
                            {
                                $.messager.alert('Info', 'Masukkan password baru anda terlebih dahulu.', 'warning');   
                                return;
                            }

                            if(password2.trim() == "")
                            {
                                $.messager.alert('Info', 'Masukkan konfirmasi password baru anda terlebih dahulu.', 'warning');   
                                return;
                            }


                            if(password2.trim() == password.trim())
                            {}
                            else
                            {
                                $.messager.alert('Info', 'Password tidak sesuai.', 'warning');   
                                return;                            
                            }


                            var win = $.messager.progress({
                                title:'ICARLA | PT Pembangkitan Jawa-Bali',
                                msg:'proses...'
                            });             
                            
                            $.post( "app/ubah_password", { reqPassword: password })
                              .done(function( data ) {

                                    $.messager.progress('close');

                                    $("#nid").val("");

                                    data = JSON.parse(data);

                                    if(data.status == 'success')
                                       $.messager.alertLink('Info', data.message, 'info', 'app');
                                    else
                                       $.messager.alert('Info', data.message, 'warning');

                              });
                        }
                  </script>
                <?
                }
                ?>
              </form>

                <br>

                <div class="alert alert-danger">
                    <strong>Ubah password hanya bagi pengguna eksternal!</strong>
                </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>
    


    <div id="myModalEAM" class="modal fade modal-lupa-password" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><strong>Konfigurasi Akun EAM</strong></h4>
          </div>
          <div class="modal-body">
              <form class="form-horizontal">
                
                <?
                    // $sql = " SELECT  a.distrik_id, a.pegawai_id, b.workgroup, c.nama distrik, b.user_login, b.user_password, 
                    //                 b.position_id, b.position_nama,
                    //                 c.orgid, c.siteid, c.eam
                    //          FROM pegawai a 
                    //          left join user_login_eam b on a.pegawai_id =  b.pegawai_id 
                    //          left join distrik c on a.distrik_id = c.distrik_id
                    //          WHERE a.pegawai_id = '".$this->NRP."' ";
                    // $rowResult = $this->db->query($sql)->row();
                    if(!empty($rowResult->eam))
                    {
                ?>
                  <div class="form-group">
                      <label class="control-label col-sm-4" for="nid">EAM</label>
                      <div class="col-sm-8" style="margin-top: 7px;">
                         <?=$rowResult->eam?>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label col-sm-4" for="nid">ORG ID</label>
                      <div class="col-sm-8" style="margin-top: 7px;">
                         <?=$rowResult->orgid?>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label col-sm-4" for="nid">SITE ID</label>
                      <div class="col-sm-8" style="margin-top: 7px;">
                         <?=$rowResult->siteid?>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label col-sm-4" for="nid">EMPLOYEE ID</label>
                      <div class="col-sm-8" style="margin-top: 7px;">
                         <?=coalesce($this->EMPLOYEE_ID, $this->ID)?>
                      </div>
                  </div>
                  <?
                  if($rowResult->eam == "ELLIPSE")
                  {
                  ?>
                  <div class="form-group">
                      <label class="control-label col-sm-4" for="nid">POSITION ID</label>
                      <div class="col-sm-8" style="margin-top: 7px;">
                         <?=$rowResult->position_id?> - <?=$rowResult->position_nama?>
                      </div>
                  </div>
                  <?
                  }
                  ?>
                  <div class="form-group">
                      <label class="control-label col-sm-4" for="nid">User EAM</label>
                      <div class="col-sm-8">
                          <input type="text" class="form-control" id="reqUserEAM" placeholder="Masukkan username EAM" value="<?=$rowResult->user_login?>">
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label col-sm-4" for="nid">Password EAM</label>
                      <div class="col-sm-8">
                          <input type="password" class="form-control" id="reqPasswordEAM" placeholder="Masukkan password EAM" value="<?=$rowResult->user_password?>">
                      </div>
                  </div>
                  <div class="form-group" id="divPositionId" style="display:none">
                      <label class="control-label col-sm-4" for="nid">Position ID</label>
                      <div class="col-sm-8">
                          <select id="position_id">
                          </select>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label col-sm-4 tombol" >&nbsp;</label>
                      <div class="col-sm-8">
                          <button class="btn btn-primary" type="button" onclick="ubahEAM()"><span id="spanLogin">Submit</span><div id="spanLoading" class="loader" style="display:none">Loading...</div></button>
                      </div>
                  </div>

                  <script type="text/javascript">

                        <?
                        if($rowResult->user_login == "")
                        {
                            if(stristr($this->USER_TYPE, "VIEWER") || stristr($this->USER_TYPE, "REVIEW"))
                            {}
                            else
                            {
                        ?>
                                $( document ).ready(function() {
                                    $("#btnEAM").click();
                                });
                        <?
                            }
                        }
                        ?>
                                      
                        function ubahEAM()
                        {

                            var password  = $("#reqPasswordEAM").val();
                            var username = $("#reqUserEAM").val();
                            var position_id  = $("#position_id").val();
                            var position_nama  = "";

                            if(position_id == "")
                            {}
                            else
                                position_nama = $('#position_id option:selected').text();



                            if(password.trim() == "")
                            {
                                $.messager.alert('Info', 'Masukkan password anda terlebih dahulu.', 'warning');   
                                return;
                            }

                            if(username.trim() == "")
                            {
                                $.messager.alert('Info', 'Masukkan username anda terlebih dahulu.', 'warning');   
                                return;
                            }



                            var win = $.messager.progress({
                                title:'ICARLA | PT Pembangkitan Jawa-Bali',
                                msg:'proses...'
                            });             
                            
                            $.post( "app/ubah_eam", { reqUsername: username, reqPassword: password, reqEAM: "<?=$rowResult->eam?>", reqPositionID: position_id, reqPositionNama: position_nama })
                              .done(function( data ) {

                                    $.messager.progress('close');

                                    $("#nid").val("");

                                    data = JSON.parse(data);

                                    if(data.status == 'success')
                                    {
                                        if(data.jumlah_posisi == "1")
                                            $.messager.alertLink('Info', data.message, 'info', 'app');
                                        else
                                        {

                                           $.messager.alert('Info', data.message, 'info');

                                            $("#divPositionId").show();

                                           
                                            jQuery.each(data.arr_position, function(i, val) {

                                                $('#position_id').append(`<option value="`+val.ns1name+`">`+val.ns1value+`</option>`);

                                            });

                                        }
                                    }
                                    else
                                       $.messager.alert('Info', data.message, 'warning');

                              });
                        }
                  </script>
              </form>
              <?
              }
              else
              {
              ?>
                <div class="alert alert-danger">
                    <strong>EAM <?=$rowResult->distrik?> belum dikonfigurasi</strong>
                </div>
              <?
                }
              ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>
</body>
</html>