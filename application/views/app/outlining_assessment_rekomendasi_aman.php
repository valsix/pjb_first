<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/OutliningAssessment");
$this->load->model("base-app/Distrik");
$this->load->model("base-app/Crud");
$this->load->model("base-app/JenisRekomendasi");
$this->load->model("base-app/PrioritasRekomendasi");
$this->load->model("base-app/KategoriRekomendasi");
$this->load->model("base-app/TimelineRekomendasi");
$this->load->model("base-app/StatusRekomendasi");
$this->load->model("base-app/SumberAnggaran");
$this->load->model("base-app/BlokUnit");

$this->load->library('libapproval');
$this->load->library('globalfunc');





$appuserkodehak= $this->appuserkodehak;
// print_r($appuserkodehak);exit;


$arrBulan=setBulanLoop();
$arrTahun= setTahunLoop(1,1);

$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");
$reqDetilId = $this->input->get("reqDetilId");
$reqAreaDetilId = $this->input->get("reqAreaDetilId");
$reqDistrikId = $this->input->get("reqDistrikId");
$reqBlokId = $this->input->get("reqBlokId");
$reqKembali = $this->input->get("reqKembali");
$reqPage = $this->input->get("reqPage");
$reqRekomendasiId = $this->input->get("reqRekomendasiId");

if(empty($reqPage))
{
    $reqPage=1;
}

$set= new JenisRekomendasi();
$arrjenis= [];
$statement=" AND A.STATUS IS NULL ";
$set->selectByParams(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("JENIS_REKOMENDASI_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrjenis, $arrdata);
}
unset($set);


$set= new StatusRekomendasi();
$arrstatus= [];
$statement=" AND A.STATUS IS NULL ";
$set->selectByParams(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("STATUS_REKOMENDASI_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrstatus, $arrdata);
}
unset($set);

$set= new PrioritasRekomendasi();
$arrprioritas= [];
$statement=" AND A.STATUS IS NULL ";
$set->selectByParams(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("PRIORITAS_REKOMENDASI_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrprioritas, $arrdata);
}
unset($set);

$set= new KategoriRekomendasi();
$arrkategori= [];
$statement=" AND A.STATUS IS NULL ";
$set->selectByParams(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("KATEGORI_REKOMENDASI_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrkategori, $arrdata);
}
unset($set);

// $set= new TimelineRekomendasi();
// $arrtimeline= [];
// $statement=" AND A.STATUS IS NULL ";
// $set->selectByParams(array(), -1,-1,$statement);
// // echo $set->query;exit;
// while($set->nextRow())
// {
//     $arrdata= array();
//     $arrdata["id"]= $set->getField("TIMELINE_REKOMENDASI_ID");
//     $arrdata["text"]= $set->getField("NAMA")." - ". $set->getField("TAHUN");
//     array_push($arrtimeline, $arrdata);
// }
// unset($set);

$set= new SumberAnggaran();
$arrsumber= [];
$statement=" AND A.STATUS IS NULL ";
$set->selectByParams(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("SUMBER_ANGGARAN_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrsumber, $arrdata);
}
unset($set);



$set= new OutliningAssessment();
$arrdistrik= [];
// $statement=" AND A.OUTLINING_ASSESSMENT_ID=".$reqId;
$statement=" ";

$set->selectByParamsRekomendasiDistrik(array(), -1,-1,$statement);
// echo $set->query;exit;

// $set->firstRow();
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["DISTRIK_ID"]= $set->getField("DISTRIK_ID");
    $arrdata["DISTRIK_NAMA"]= $set->getField("DISTRIK_NAMA");
    $arrdata["BLOK_UNIT_ID"]= $set->getField("BLOK_UNIT_ID");
    $arrdata["BLOK_NAMA"]= $set->getField("BLOK_NAMA");
    $arrdata["ITEM_ASSESSMENT_INFO"]= $set->getField("ITEM_ASSESSMENT_INFO");
    $arrdata["KETERANGAN"]= $set->getField("KETERANGAN");
    $arrdata["BULAN"]= $set->getField("BULAN");
    $arrdata["TAHUN"]= $set->getField("TAHUN");
    array_push($arrdistrik, $arrdata);
}
unset($set);

$set= new OutliningAssessment();
$statement=" AND A.OUTLINING_ASSESSMENT_ID =".$reqId;

if(empty($reqAreaDetilId))
{
    // if(!empty($reqDetilId))
    // {
    //    $statement.=" AND A.OUTLINING_ASSESSMENT_DETIL_ID=".$reqDetilId;
    // }
}
else
{
     $statement.=" AND B.OUTLINING_ASSESSMENT_AREA_DETIL_ID=".$reqAreaDetilId;
}

$set->selectByParamsTotalAllRekomendasi(array(), -1,-1,"",$statement);
// echo $set->query;exit;

$set->firstRow();
$reqAreaPersen= $set->getField("TOTAL_PERSEN");
$status="Belum selesai";
if($reqAreaPersen==100)
{
    $status="Selesai";
}

;

$set= new OutliningAssessment();

$statement=" ";
if(!empty($reqDetilId))
{
    $statement.=" AND A.OUTLINING_ASSESSMENT_DETIL_ID=".$reqDetilId;
}

$set->selectByParamsAssessmentDetil(array(), -1,-1,$statement);
// echo $set->query;exit;
$set->firstRow();
$reqAreaNama= $set->getField("KODE_INFO") ." - ".$set->getField("NAMA");
unset($set);


$set= new Crud();
$statement=" AND KODE_MODUL ='1001'";
// $statement=" ";

$kode= $appuserkodehak;
$set->selectByParamsMenus(array(), -1, -1, $statement, $kode);
// echo $set->query;exit;
$set->firstRow();
$reqMenu= $set->getField("MENU");
$reqCreate= $set->getField("MODUL_C");
$reqRead= $set->getField("MODUL_R");
$reqUpdate= $set->getField("MODUL_U");
$reqDelete= $set->getField("MODUL_D");

$disabled="";

if($reqLihat==1 || $reqRead==1)
{
    $disabled="disabled";
}

$reqTahun= date('Y');
$semester="Semester";
$arrSmtTahun=[];
for ($i=0; $i < 4 ; $i++) { 
    for ($z=1; $z < 3 ; $z++) { 
        $arrdata= array();
        $smtahun=  $reqTahun.' - '.$semester.' '.$z;
        $arrdata["ID"]= $reqTahun."_".$z;
        $arrdata["NAMA"]= $smtahun;
        array_push($arrSmtTahun, $arrdata);
    }
    $reqTahun++;
}

$checkrole= new Crud();
$statement=" AND A.KODE_HAK LIKE '%".$appuserkodehak."%'";
// $statement=" ";

$checkrole->selectByParams(array(), -1, -1, $statement);
// echo $checkrole->query;exit;
$checkrole->firstRow();
$reqPenggunaHakId= $checkrole->getField("PENGGUNA_HAK_ID");


?>

<script src='assets/multifile-master/jquery.form.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MetaData.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MultiFile.js' type="text/javascript" language="javascript"></script> 
<link rel="stylesheet" href="css/gaya-multifile.css" type="text/css">

<style type="text/css">
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
  color: #000000;
}
.select2-container--default .select2-search--inline .select2-search__field:focus {
  outline: 0;
  border: 1px solid #ffff;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__display {
  cursor: default;
  padding-left: 6px;
  padding-right: 5px;
}

.select2-selection__rendered {
    line-height: 31px !important;
}
.select2-container .select2-selection--single {
    height: 35px !important;
}
.select2-selection__arrow {
    height: 34px !important;
}


/*.select2-container {
    width: 100% !important;
}*/
/****/
#reqDeskripsi,
#reqKeterangan {
    width: 340px;
}

table { width: 50% }

/*td span {
  display: block;
}
*/

table.table>tbody>tr.area:hover td,
table.table>tbody> tr.area:hover th {
  background-color: #f8a92f !important;
}

table.table>tbody>tr.distrik:hover td,
table.table>tbody> tr.distrik:hover th {
  background-color: #f8a92f !important;
}

table.table>tbody>tr.detil:hover td,
table.table>tbody> tr.detil:hover th {
  background-color: #f8a92f !important;
}

.bigdrop{
    width: 600px !important;

}

select[readonly].select2-hidden-accessible + .select2-container {
    pointer-events: none;
    touch-action: none;
}

select[readonly].select2-hidden-accessible + .select2-container .select2-selection {
    background: #eee;
    box-shadow: none;
}

select[readonly].select2-hidden-accessible + .select2-container .select2-selection__arrow, select[readonly].select2-hidden-accessible + .select2-container .select2-selection__clear {
    display: none;
}

input[readonly]
{
    background: #eee;
}
textarea[readonly]
{
    background: #eee;
}


</style>


<div class="col-md-12">
    
  <div class="judul-halaman"> Data Rekomendasi </div>

    <div class="konten-area">
        <div class="konten-inner">

            <div>

                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data" autocomplete="off">

                    <?
                    if($reqPage==4)
                    {
                    ?>
                        <input type="hidden" name="infopg" value="<?=$pg?>" />
                        <?
                        $approval_table= "outlining_assessment_rekomendasi";
                        $approval_field_id= "OUTLINING_ASSESSMENT_REKOMENDASI_ID";
                        $approval_field_status= "V_STATUS";
                        $vappr= new libapproval();
                        $arrparam= ["approval_info_pg"=>$pg, "approval_info_id"=>$reqRekomendasiId, "approval_table"=>$approval_table, "approval_field_id"=>$approval_field_id, "approval_field_status"=>$approval_field_status];
                                // print_r($arrparam);
                        $vappr->view($arrparam);
                        ?>
                    <?
                    }
                    ?>

                    <?
                    if($reqPage==1)
                    {

                        if($reqBulan == "")
                        {
                            $reqBulan= date("m");
                        }
                        elseif($reqBulan == "x")
                        {
                            $reqBulan= "";
                        }

                        $reqTahun= date('Y');

                        $set= new OutliningAssessment();
                        $statement = "";
                        $arrTahun=[];
                        $set->selectByParamsRekomendasiTahun(array(), -1, -1, $statement);
                        // echo $set->query;exit;

                        while($set->nextRow())
                        {
                            $arrdata= array();
                            $arrdata["TAHUN"]= $set->getField("TAHUN");
                            array_push($arrTahun, $arrdata);
                        }
                        // var_dump($reqTahun);

                    ?>


                        <div class="page-header" style="background-color: green">
                            <h3><i class="fa fa-file-text fa-lg"></i> Rekomendasi </h3>       
                        </div>

                        <div class="form-group">  
                            <label class="control-label col-md-2">Periode Assessment </label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-3'>
                                        <select name="reqBulan" id="reqBulan"   class="form-control datatable-input">
                                            <option value="">Semua</option>
                                            <?
                                            for($i=0;$i<count($arrBulan);$i++)
                                            {
                                                ?>
                                                <option value="<?=$arrBulan[$i]?>" <? if(generateZeroDate($reqBulan, 2) == $arrBulan[$i]) { ?> selected <? } ?>><?=getNameMonthNew($arrBulan[$i])?></option>
                                                <?    
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class='col-md-3'>
                                        <select name="reqTahun" id="reqTahun"   class="form-control datatable-input">
                                            <option value="">Semua</option>
                                            <?
                                            foreach ($arrTahun as $key => $value) 
                                            {
                                                ?>
                                                <option value="<?=$value["TAHUN"]?>" <? if($reqTahun == $value["TAHUN"]) echo "selected";?>><?=$value["TAHUN"]?></option>
                                                <?
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div style="overflow-y: auto;height: 100%;width: 100%;">
                            <table id="" class="table table-bordered table-striped table-hovered" style="width: 100%;" >
                                <thead >
                                    <tr>
                                        <th class="text-center" style="">Bulan</th>
                                        <th class="text-center">Tahun</th>
                                        <th class="text-center">Distrik</th>
                                        <th class="text-center">Blok Unit</th>
                                        <th class="text-center" style="width: 20%">Status</th>
                                        <th class="text-center" style="width: 20%">Area Terisi/Total Area</th>
                                        <th class="text-center" style="width: 10%">% Penyelesaian</th>
                                    </tr>
                                </thead>
                                <tbody id="distrikm" >
                                </tbody>
                            </table>
                        </div>
                    <?
                    }
                    else  if($reqPage==2)
                    {

                        $set= new OutliningAssessment();
                        $arrdetil= [];

                        $statement=" AND B.DISTRIK_ID=".$reqDistrikId." AND B.BLOK_UNIT_ID=".$reqBlokId." AND A.OUTLINING_ASSESSMENT_ID=".$reqId;
                        if(!empty($reqDetilId))
                        {
                            $statement.=" AND A.OUTLINING_ASSESSMENT_DETIL_ID=".$reqDetilId;
                        }
                        $statement.=" AND EXISTS
                        (
                            SELECT A.OUTLINING_ASSESSMENT_DETIL_ID FROM OUTLINING_ASSESSMENT_AREA_DETIL B  
                            WHERE A.OUTLINING_ASSESSMENT_DETIL_ID=B.OUTLINING_ASSESSMENT_DETIL_ID AND B.STATUS_CONFIRM = 0
                        )";

                        $set->selectByParamsAssessmentDetil(array(), -1,-1,$statement);
                        // echo $set->query;exit;
                        while($set->nextRow())
                        {
                            $arrdata= array();
                            $arrdata["id"]= $set->getField("OUTLINING_ASSESSMENT_DETIL_ID");
                            $arrdata["LIST_AREA_ID"]= $set->getField("LIST_AREA_ID");
                            $arrdata["ITEM_ASSESSMENT_DUPLIKAT_ID"]= $set->getField("ITEM_ASSESSMENT_DUPLIKAT_ID");
                            $arrdata["AREA"]=$set->getField("KODE_INFO") ." - ".$set->getField("NAMA");

                            array_push($arrdetil, $arrdata);
                        }
                        unset($set);

                        $statement=" AND A.DISTRIK_ID= ".$reqDistrikId;
                        $distrik= new Distrik();
                        $distrik->selectByParams(array(), -1,-1,$statement);
                         // echo $setarea->query;
                        $distrik->firstRow();
                        $reqDistrikNama= $distrik->getField("NAMA");

                        $statement=" AND A.BLOK_UNIT_ID= ".$reqBlokId;
                        $blok= new BlokUnit();
                        $blok->selectByParams(array(), -1,-1,$statement);
                         // echo $setarea->query;
                        $blok->firstRow();
                        $reqBlokNama= $blok->getField("NAMA");

                    ?>
                            <div class="page-header" style="background-color: green">
                                <h3><i class="fa fa-file-text fa-lg"></i> Area Assessment </h3>       
                            </div>

                            <div class='form-group' style="background-color: yellow">
                                <div class='col-md-3'>
                                    Distrik : <?=$reqDistrikNama?>
                                </div>
                                <div class='col-md-3'>
                                    Blok Unit : <?=$reqBlokNama?>
                                </div>
                            </div>

                            <div style="overflow-y: auto;height: 100%;width: 100%;text-align: center">
                                <table id="page2" class="table table-bordered table-striped table-hovered" style="width: 100%;" >
                                    <thead >
                                        <tr>
                                            <th class="text-center">Area</th>
                                            <th class="text-center">Terisi / Total Rekomendasi</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center" style="width: 10%">% Penyelesaian</th>
                                        </tr>  
                                    </thead>
                                    <tbody >
                                       
                                        <?
                                        $i=1;
                                        foreach ($arrdetil as $key => $value) 
                                        {
                                            $totaldata= new OutliningAssessment();
                                            $statement="";

                                            if(empty($reqAreaDetilId))
                                            {
                                                if(empty($reqDetilId))
                                                {
                                                   $statement.=" AND A.OUTLINING_ASSESSMENT_DETIL_ID=".$value["id"];

                                                }
                                                else
                                                {
                                                   $statement.=" AND A.OUTLINING_ASSESSMENT_DETIL_ID=".$reqDetilId;
                                                }
                                            }
                                            else
                                            {
                                                 $statement.=" AND A.OUTLINING_ASSESSMENT_AREA_DETIL_ID=".$reqAreaDetilId;
                                            }


                                            $totaldata->selectByParamsTotalAreaRekomendasiNonStatus(array(), -1,-1,$statement);
                                            // echo $set->query;

                                            $totaldata->firstRow();
                                            $reqTerisi= $totaldata->getField("SAMA");
                                            $reqTotal= $totaldata->getField("TOTAL");

                                            $set= new OutliningAssessment();
                                            $statement="";

                                            if(empty($reqAreaDetilId))
                                            {
                                                if(empty($reqDetilId))
                                                {
                                                   $statement.=" AND A.OUTLINING_ASSESSMENT_DETIL_ID=".$value["id"];

                                                }
                                                else
                                                {
                                                   $statement.=" AND A.OUTLINING_ASSESSMENT_DETIL_ID=".$reqDetilId;
                                                }
                                            }
                                            else
                                            {
                                                 $statement.=" AND A.OUTLINING_ASSESSMENT_AREA_DETIL_ID=".$reqAreaDetilId;
                                            }


                                            $set->selectByParamsTotalAreaRekomendasi(array(), -1,-1,$statement);
                                            // echo $set->query;

                                            $set->firstRow();
                                            $reqAreaPersen= $set->getField("PERSEN");
                                           
                                            $status="Belum selesai";
                                            if($reqAreaPersen==100)
                                            {
                                                $status="Selesai";
                                            }
                                            
                                        ?>
                                        <tr class="area" >
                                            <td style="display: none"><?=$value["LIST_AREA_ID"]?>,<?=$value["ITEM_ASSESSMENT_DUPLIKAT_ID"]?>,<?=$value["id"]?></td>
                                            <td style="display: none"><?=$reqId?></td>
                                            <td><label style="font-weight: normal !important;"><?=$value["AREA"]?></label></td>
                                            <td><?=$reqTerisi?> / <?=$reqTotal?> </td>
                                            <td><?=$status?></td>
                                            <td><?=$reqAreaPersen?> %</td>
                                                                                       
                                        </tr>                                         
                                        <?
                                        $i++;
                                        }
                                        ?> 
                                    </tbody>
                                </table>
                            </div>
                    <?
                    }
                    else if($reqPage==3)
                    {

                        $set= new OutliningAssessment();
                        $arrareadetil= [];
                        $statement=" AND A.STATUS_CONFIRM=0 AND A.OUTLINING_ASSESSMENT_DETIL_ID=".$reqDetilId;

                        if(!empty($reqAreaDetilId))
                        {
                            $statement.=" AND A.OUTLINING_ASSESSMENT_AREA_DETIL_ID=".$reqAreaDetilId;
                        }

                        $set->selectByParamsAreaDetilRekomendasi(array(), -1,-1,$statement);
                        // echo $set->query;exit;
                        while($set->nextRow())
                        {
                            $arrdata= array();
                            $arrdata["id"]= $set->getField("OUTLINING_ASSESSMENT_AREA_DETIL_ID");
                            $arrdata["OUTLINING_ASSESSMENT_REKOMENDASI_ID"]= $set->getField("OUTLINING_ASSESSMENT_REKOMENDASI_ID");
                            $arrdata["KETERANGAN"]= $set->getField("KETERANGAN");
                            $arrdata["STATUS_APPROVAL"]= $set->getField("STATUS_APPROVAL");
                            array_push($arrareadetil, $arrdata);
                        }
                        unset($set);

                       
                    ?>

                        <div class="page-header" style="background-color: green">
                            <h3><i class="fa fa-file-text fa-lg"></i> Rekomendasi Assessment <?=$reqAreaNama?></h3>       
                        </div>

                        <div style="overflow-y: auto;height: 100%;width: 100%;">
                            <table id="" class="table table-bordered table-striped table-hovered" style="width: 100%;text-align: center" >
                                <thead >
                                    <tr>
                                        <th class="text-center">Keterangan</th>
                                        <th class="text-center" style="width: 20%;">Status Rekomendasi</th>
                                        <th class="text-center" style="width: 20%;">Tipe Rekomendasi</th>
                                        <th class="text-center" style="width: 20%;">Status Approval</th>
                                    </tr>
                                </thead>
                                <tbody >
                                    <?
                                    $i=1;
                                    foreach ($arrareadetil as $key => $value) 
                                    {

                                       $set= new OutliningAssessment();
                                       $statement=" AND A.OUTLINING_ASSESSMENT_AREA_DETIL_ID=".$value["id"];

                                       $set->selectByParamsRekomendasi(array(), -1,-1,$statement);
                                       $set->firstRow();
                                       $reqStatusRekomendasiId= $set->getField("STATUS_REKOMENDASI_ID");
                                       // var_dump($reqStatusRekomendasiId);
                                       unset($set);

                                       $status= new StatusRekomendasi();
                                       $statement=" AND A.STATUS_REKOMENDASI_ID=".$reqStatusRekomendasiId;

                                       $status->selectByParams(array(), -1,-1,$statement);
                                       $status->firstRow();
                                       $reqStatusRekomendasiNama= $status->getField("NAMA");
                                       // var_dump($reqStatusRekomendasiId);
                                       unset($status);

                                       $set= new OutliningAssessment();
                                       $statement=" AND A.OUTLINING_ASSESSMENT_AREA_DETIL_ID=".$value["id"];

                                       $set->selectByParamsAreaDetil(array(), -1,-1,$statement);
                                       $set->firstRow();
                                       $reqAreaUnitDetilId= $set->getField("AREA_UNIT_DETIL_ID");
                                       $reqListAreaId= $set->getField("LIST_AREA_ID");
                                       $reqItemAssessmentDuplikatId= $set->getField("ITEM_ASSESSMENT_DUPLIKAT_ID");
                                       $reqItemAssessmentFormulirId= $set->getField("ITEM_ASSESSMENT_FORMULIR_ID");
                                       $reqItemAssessmentId= $set->getField("ITEM_ASSESSMENT_ID");
                                       // var_dump($reqStatusRekomendasiId);
                                       unset($set);

                                       $check= new OutliningAssessment();
                                       $statement=" AND A.AREA_UNIT_DETIL_ID=".$reqAreaUnitDetilId." AND A.LIST_AREA_ID=".$reqListAreaId." AND A.ITEM_ASSESSMENT_DUPLIKAT_ID=".$reqItemAssessmentDuplikatId." AND A.ITEM_ASSESSMENT_FORMULIR_ID=".$reqItemAssessmentFormulirId." AND A.ITEM_ASSESSMENT_ID=".$reqItemAssessmentId." ";


                                       $reqCheck = $check->getCountByParamsAreaDetilRekomendasi(array(),$statement);
                                       // var_dump($reqCheck);
                                       unset($check);

                                       if($reqCheck > 1)
                                       {
                                         $tipe="Lama";
                                       }
                                       else
                                       {
                                         $tipe="Baru";
                                       }
                        

                                        ?>
                                        <tr class="detil" >
                                            <td style="display: none"><?=$value["id"]?></td>
                                            <td style="display: none"><?=$reqId?></td>
                                            <td style="display: none"><?=$value["OUTLINING_ASSESSMENT_REKOMENDASI_ID"]?></td>
                                            <td><label style="font-weight: normal !important;"><?=$value["KETERANGAN"]?></label></td>
                                            <td><label style="font-weight: normal !important;"><?=$reqStatusRekomendasiNama?></label></td>
                                            <td><label style="font-weight: normal !important;"><?=$tipe?></label></td>
                                            <td><label style="font-weight: normal !important;"><?=$value["STATUS_APPROVAL"]?></label></td>
                                
                                        </tr>
                                        <?
                                        $i++;
                                    }
                                    ?> 
                                </tbody>
                            </table>
                        </div>

                    <?
                    }
                    else if($reqPage==4)
                    {

                        $set= new OutliningAssessment();
                        $statement=" AND A.STATUS_CONFIRM=0 AND A.OUTLINING_ASSESSMENT_DETIL_ID=".$reqDetilId;

                        if(!empty($reqAreaDetilId))
                        {
                            $statement.=" AND A.OUTLINING_ASSESSMENT_AREA_DETIL_ID=".$reqAreaDetilId;
                        }

                        $set->selectByParamsAreaDetilRekomendasi(array(), -1,-1,$statement);
                        // echo $set->query;exit;
                        $set->firstRow();
                        $reqKeteranganDetil=$set->getField("KETERANGAN");
                        $reqItemAssessmentNama=$set->getField("ITEM_ASSESSMENT_INFO");
                        unset($set);

                        $set= new OutliningAssessment();
                        $statement=" AND A.OUTLINING_ASSESSMENT_AREA_DETIL_ID=".$reqAreaDetilId;

                        $set->selectByParamsRekomendasi(array(), -1,-1,$statement);
                        // echo $set->query;exit;
                        $set->firstRow();
                        $reqRekomendasiId=$set->getField("OUTLINING_ASSESSMENT_REKOMENDASI_ID");
                        $reqSumberAnggaranId=$set->getField("SUMBER_ANGGARAN_ID");
                        $reqNomorWoId=$set->getField("WORK_ORDER_ID");
                        $reqNomorWo=$set->getField("NAMA_WO");

                        $reqSumberAnggaranId= $set->getField("SUMBER_ANGGARAN_ID");
                        $reqRencanaEksekusi= dateToPageCheck($set->getField("RENCANA_EKSEKUSI"));
                        $reqDetailRekomendasi= $set->getField("DETAIL");
                        $reqRealisasiEksekusi= dateToPageCheck($set->getField("REALISASI_EKSEKUSI"));
                        $reqJenisRekomendasiId= $set->getField("JENIS_REKOMENDASI_ID");
                        $reqStatusRekomendasiId= $set->getField("STATUS_REKOMENDASI_ID");
                        $reqPrioritasRekomendasiId= $set->getField("PRIORITAS_REKOMENDASI_ID");
                        $reqKeteranganRekomendasi=$set->getField("KETERANGAN");
                        $reqKategoriRekomendasiId= $set->getField("KATEGORI_REKOMENDASI_ID");
                        $reqTimelineRekomendasiId= $set->getField("TIMELINE_REKOMENDASI_ID");
                        $reqLinkFile= $set->getField("LINK_FILE");
                        $vstatus= $set->getField("V_STATUS");
                        unset($set);

                        $readonlywo="";
                        $readonlyassessor="";


                        if($reqPenggunaHakId == 7  || $reqPenggunaHakId == 8 || $reqPenggunaHakId == 9  )
                        {
                            $readonlywo="readonly";
                        }

                        if($reqPenggunaHakId == 3  )
                        {
                            $readonlyassessor="readonly";
                        }
                        
                    ?>

                      <div class="page-header" style="background-color: green">
                            <h3><i class="fa fa-file-text fa-lg"></i> Detail Rekomendasi Assessment </h3>       
                        </div>

                        <div style="overflow-y: auto;height: 100%;width: 100%;">
                            <table id="" class="table table-bordered table-striped table-hovered" style="width: 100%;" >
                                <tbody >
                                    <tr >
                                        <td style="background-color:#fdff85;text-align: center;width: 25%;">Nama Area</td>
                                        <td><label style="font-weight: normal !important;"><?=$reqAreaNama?></label></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color:#fdff85;text-align: center">Klausul Assessment</td>
                                        <td><label style="font-weight: normal !important;"><?=$reqItemAssessmentNama?></label></td>
                                        
                                    </tr>
                                    <tr>
                                        <td style="background-color:#fdff85;text-align: center">Keterangan</td>
                                        <td><label style="font-weight: normal !important;" ><?=$reqKeteranganDetil?></label></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color:#fdff85;text-align: center">Detail Rekomendasi</td>
                                        <td><textarea style="width: 100%" name="reqDetailRekomendasi" <?=$readonlyassessor?> ><?=$reqDetailRekomendasi?></textarea></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color:#fdff85;text-align: center">Jenis Rekomendasi</td>
                                        <td>
                                            <select class="easyui-validatebox textbox form-control pilihan" <?=$readonlyassessor?> name="reqJenisRekomendasiId">
                                                <option value="">Pilih Jenis Rekomendasi</option>
                                                <?
                                                foreach ($arrjenis as $keys => $val) 
                                                {
                                                    $selected="";
                                                    if($reqJenisRekomendasiId==$val['id'])
                                                    {
                                                        $selected="selected";
                                                    }

                                                    ?>
                                                    <option value="<?=$val['id']?>" <?=$selected?>><?=$val['text']?></option>
                                                    <?
                                                }
                                                ?>
                                            </select>
                                        </td>
                                       
                                    </tr>
                                    <tr>
                                        <td style="background-color:#fdff85;text-align: center">Prioritas Rekomendasi</td>
                                        <td>
                                            <select class="easyui-validatebox textbox form-control pilihan" <?=$readonlyassessor?>  name="reqPrioritasRekomendasiId">
                                            <option value="">Pilih Prioritas Rekomendasi</option>
                                            <?
                                            foreach ($arrprioritas as $keys => $val) 
                                            {
                                                $selected="";
                                                if($reqPrioritasRekomendasiId==$val['id'])
                                                {
                                                    $selected="selected";
                                                }

                                                ?>
                                                <option value="<?=$val['id']?>" <?=$selected?>><?=$val['text']?></option>
                                                <?
                                            }
                                            ?>
                                            </select>
                                        </td>
                                       
                                    </tr>
                                    <tr>
                                        <td style="background-color:#fdff85;text-align: center">Kategori Rekomendasi</td>
                                        <td>
                                        <select class="easyui-validatebox textbox form-control pilihan" <?=$readonlyassessor?>  name="reqKategoriRekomendasiId" >
                                            <option value="">Pilih Kategori Rekomendasi</option>
                                            <?
                                            foreach ($arrkategori as $keys => $val) 
                                            {
                                                $selected="";
                                                if($reqKategoriRekomendasiId==$val['id'])
                                                {
                                                    $selected="selected";
                                                }

                                                ?>
                                                <option value="<?=$val['id']?>" <?=$selected?>><?=$val['text']?></option>
                                                <?
                                            }
                                            ?>
                                        </select>
                                        </td>
                                       
                                    </tr>
                                    <tr>
                                        <td style="background-color:#fdff85;text-align: center">Timeline Rekomendasi</td>
                                        <td >
                                            <select class="easyui-validatebox textbox form-control pilihan"  <?=$readonlyassessor?> name="reqTimelineRekomendasiId">
                                                <option value="">Pilih Timeline Rekomendasi</option>
                                                <?
                                                foreach ($arrSmtTahun as $keys => $val) 
                                                {
                                                    $selected="";
                                                    if($reqTimelineRekomendasiId==$val['ID'])
                                                    {
                                                        $selected="selected";
                                                    }

                                                    ?>
                                                    <option value="<?=$val['ID']?>" <?=$selected?>><?=$val['NAMA']?></option>
                                                    <?
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div style="overflow-y: auto;height: 100%;width: 100%;">
                            <div class="page-header" style="background-color: green">
                                <h3><i class="fa fa-file-text fa-lg"></i> Diisi Oleh Unit </h3>       
                            </div>
                            <table class="table table-bordered table-striped table-hovered" style="width: 100%;"> 
                                <tbody >
                                    <tr>
                                        <td style="background-color:#fdff85;text-align: center;width: 25%;">Nomor Work Order</td>
                                        <!-- <td ><input style="width: 100%" type="text" name="reqNomorWo" value="<?=$reqNomorWo?>"></td>  -->
                                        <td >
                                            <input style="width: 70%" type="text" name="reqNomorWo" id="reqNomorWo" readonly value="<?=$reqNomorWo?>">
                                            <input style="width: 50%" type="hidden" name="reqNomorWoId"  id="reqNomorWoId" value="<?=$reqNomorWoId?>">
                                            <?
                                            if(empty($readonlywo))
                                            {
                                            ?>
                                            <a id="btnAdd" onclick="openWorkOrder()"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> </a>
                                            <?
                                            }
                                            ?>
                                        </td> 
                                     </tr>
                                    <tr>
                                        <td style="background-color:#fdff85;text-align: center">Sumber Anggaran</td>
                                        <td >
                                            <select class="easyui-validatebox textbox form-control pilihan" <?=$readonlywo?> name="reqSumberAnggaranId">
                                                <option value="">Pilih Sumber Anggaran</option>
                                                <?
                                                foreach ($arrsumber as $keys => $val) 
                                                {
                                                    $selected="";
                                                    if($reqSumberAnggaranId==$val['id'])
                                                    {
                                                        $selected="selected";
                                                    }
                                                    ?>
                                                    <option value="<?=$val['id']?>" <?=$selected?>><?=$val['text']?></option>
                                                    <?
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="background-color:#fdff85;text-align: center">Rencana Eksekusi </td>
                                        <td > 
                                           <input  class="easyui-datebox textbox form-control" <?=$readonlywo?>  name="reqRencanaEksekusi"  id="reqRencanaEksekusi" value="<?=$reqRencanaEksekusi?>"  style="width:100%" <?=$disabled?> />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="background-color:#fdff85;text-align: center">Realisasi Eksekusi </td>
                                        <td > <input id="reqRealisasiEksekusi" <?=$readonlywo?>   class="easyui-datebox textbox form-control"  name="reqRealisasiEksekusi" value="<?=$reqRealisasiEksekusi?>" style="width: 100%" /></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color:#fdff85;text-align: center">Status Rekomendasi</td>
                                        <td>
                                            <select class="easyui-validatebox textbox form-control pilihan" <?=$readonlywo?>  name="reqStatusRekomendasiId">
                                                <option value="">Pilih Status Rekomendasi</option>
                                                <?
                                                foreach ($arrstatus as $keys => $val) 
                                                {
                                                    $selected="";
                                                    if($reqStatusRekomendasiId==$val['id'])
                                                    {
                                                        $selected="selected";
                                                    }

                                                    ?>
                                                    <option value="<?=$val['id']?>" <?=$selected?>><?=$val['text']?></option>
                                                    <?
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="background-color:#fdff85;text-align: center">Keterangan</td>
                                        <td><textarea style="width: 100%" <?=$readonlywo?> name="reqKeteranganRekomendasi"><?=$reqKeteranganRekomendasi?></textarea></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color:#fdff85;text-align: center">Lampiran </td>
                                        <td >
                                            <?
                                            if(empty($readonlywo))
                                            {
                                            ?> 
                                            <input type="file" name="reqLinkFile" id="reqLinkFile" accept=".xlsx,.xls,.doc,.docx,.pdf,image/png, .jpg,.jpeg" >
                                            <?
                                            }
                                            ?>
                                            <?
                                            if(!empty($reqLinkFile))
                                            {
                                                ?>
                                                <br>
                                                <a href="<?=$reqLinkFile?>" target="_blank"><img src="images/icon-download.png"></a>
                                                <span style="margin-left: 7px"><a onclick='HapusFile("<?=$reqRekomendasiId?>")'><img src="images/delete-icon.png"></a> </span>                                               
                                                <?
                                            }
                                            ?>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td style="display: none">
                                            <input class="easyui-validatebox textbox form-control" type="text" name="reqAreaDetilId" id="reqAreaDetilId" value="<?=$reqAreaDetilId?>"  > 
                                            <input class="easyui-validatebox textbox form-control" type="text" name="reqRekomendasiId" id="reqRekomendasiId"  value="<?=$reqRekomendasiId?>" style="width: 500px" >
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <?   
                    }
                    else
                    {
                    ?>
                        <div class="page-header" style="background-color: red;text-align: center;">
                            <h3> Data Tidak Ada</h3>       
                        </div>
                    <?
                    }
                    ?>

                    <input type="hidden" name="reqId" value="<?=$reqId?>" />
                    <input type="hidden" name="reqDetilId" value="<?=$reqDetilId?>" />


               

            </div>

            <?
            if($reqLihat ==1)
            {}
            else
            {
            ?>
                <div style="text-align:center;padding:5px">
                    <?
                    if($reqPage > 1)
                    {
                    ?>
                    <a href="javascript:void(0)" class="btn btn-warning" onclick="kembali()">Kembali</a>
                     <?
                    }
                    ?>
                   

                    <?
                    if($reqPage ==4)
                    {
                    ?>

                        <input type='hidden' name='is_draft' id="is_draft" value='<?php echo ($vstatus==1)?1:0?>'>

                        <?
                        if($vstatus==1 || $vstatus =='')
                        {
                            if($reqPenggunaHakId == 1 || $reqPenggunaHakId==7)
                            {

                                ?>
                                <a href="javascript:void(0)" class="btn btn-primary" id='draft'>Simpan Draft</a>
                                <?
                            }
                        }
                        ?>

                        <?
                        if($reqKembali ==1)
                        {
                            ?>
                            <!-- <a href="javascript:void(0)" class="btn btn-warning" onclick="kembali()">Kembali</a> -->
                            <?
                        }
                        ?>

                        <a href="javascript:void(0)" class="btn btn-success" id='update' >Kirim</a>
                        <a href="javascript:void(0)" class="btn btn-primary" id='simpannew' >Simpan</a>
                        <?
                        if(!empty($reqRekomendasiId) )
                        {
                            ?>

                            <?
                            if($vstatus==1 || $vstatus =='')
                            {
                                if($reqPenggunaHakId == 1 || $reqPenggunaHakId==7)
                                {

                                    ?>
                                     <a href="javascript:void(0)" class="btn btn-danger" onclick="clearform('<?=$reqRekomendasiId?>')">Clear</a>
                                    <?
                                }
                            }
                            ?>

                           
                            <?
                        }
                        ?>

                    <?
                    }
                    ?>
                   
                       
                   
                </div>

            <?
            }
            ?>

             </form>


           
            
        </div>
    </div>
    
</div>

<script>
$('.pilihan').select2({
    dropdownAutoWidth : true,
    width: 'auto'
});

var check_vstatus='<?=$vstatus?>';
var cekroleid='<?=$reqPenggunaHakId?>';


var checkkirim = $('#checkkirim').val();
$('#simpannew').hide();
$('#update').hide();
// console.log(cekroleid);
if(cekroleid == 1 || cekroleid == 7)
{
    if(check_vstatus==1 || check_vstatus =='' || check_vstatus ==90)
    {
        $('#update').show();
    }
}

console.log(check_vstatus);

if(check_vstatus ==30 && checkkirim==1 )
{
    $('#simpannew').show();
}

$('#simpannew').click(function() {
    $('#is_draft').val(30);
    submitForm();
    return false; // avoid to execute the actual submit of the form.
});

$('#update').click(function() {
    $('#is_draft').val(0);
    submitForm();
    return false; // avoid to execute the actual submit of the form.
});

$('#draft').click(function() {
    $('#is_draft').val(1);
    submitForm();
    return false; // avoid to execute the actual submit of the form.
});

function openWorkOrder()
{
    openAdd('iframe/index/lookup_work_order?reqDistrikId=<?=$reqDistrikId?>');
} 

function clearform(reqRekomendasiId)
{
    $.messager.confirm('Konfirmasi',"Clear data form rekomendasi?",function(r){
        if (r){
            $.getJSON("json-app/outlining_assessment_json/deleterekomendasi?reqRekomendasiId="+reqRekomendasiId,
                function(data){
                    // console.log(data);return false;
                    $.messager.alert('Info', data.PESAN, 'info');                    
                    location.reload();
            });
        }
    }); 
} 

function setWO(values){
    // console.log(values);
    $('#reqNomorWoId').val(values.WORK_ORDER_ID);
    $('#reqNomorWo').val(values.WO+' - '+values.DESCRIPTION);
}

$('#reqBulan,#reqTahun').on('change', function() {
    var bulan=$("#reqBulan").val();
    var tahun=$("#reqTahun").val();
    // console.log(bulan);
    $("#distrikm").empty();
    $.getJSON("json-app/outlining_assessment_json/filter_rekomendasi?reqBulan="+bulan+"&reqTahun="+tahun,
    function(data){
        data.forEach(function(entry) {
        // console.log();
         $('#distrikm').append("<tr class='distrik'><td style='display: none'>"+entry.DISTRIK_ID+"</td><td style='display: none'>"+entry.BLOK_UNIT_ID+"</td><td style='display: none'>"+entry.OUTLINING_ASSESSMENT_ID+"</td><td><label style='font-weight: normal !important;'>"+entry.BULAN_NAMA+"</label></td><td><label class='text-center' style='font-weight: normal !important;'>"+entry.TAHUN+"</label></td><td><label style='font-weight: normal !important;'>"+entry.DISTRIK_NAMA+"</label></td><td><label style='font-weight: normal !important;'>"+entry.BLOK_NAMA+"</label></td><td>"+entry.STATUS+"</td><td class='text-center'>"+entry.TERISI+' / '+entry.TOTAL+"</td><td>"+entry.PERC_AREA+" %</td></tr>");
       });
    });
});

$(function() {
    var bulan=$("#reqBulan").val();
    var tahun=$("#reqTahun").val();

    var page='<?=$reqPage?>';
    if(page==1)
    {
        filterrekomendasi(bulan,tahun);
    }
   
    $(document).on("dblclick","tr",function() {  

    // $('tr').dblclick(function(){
        var id = $(this).attr('class');
       
        var reqDistrikId= reqBlokUnitId="";
        var reqAreaId="";
        var reqAreaDuplikatId="";
        var reqDetilId="";
        var reqPage="<?=$reqPage?>";
        var arr = [];

        var idarea =($('td:first', this).text());
        var idarea = idarea.split(',');
        var reqRekomendasiId="";

        var reqId="";
        if(id=="distrik")
        {

           var reqDistrikId = $(this).closest('tr').find('td:eq(0)').text();
           var reqBlokId = $(this).closest('tr').find('td:eq(1)').text();
           var reqId = $(this).closest('tr').find('td:eq(2)').text();
            // console.log(reqId);return false;
           var reqPage="2";
        }
        else
        {
           var reqDistrikId= "<?=$reqDistrikId?>";
           var reqBlokId= "<?=$reqBlokId?>";
           var reqId = $(this).closest('tr').find('td:eq(1)').text();
        }

        if(id=="area")
        {
            for (var i = 0; i < idarea.length; i++) {
               var reqAreaId= idarea[0];
               var reqAreaDuplikatId= idarea[1];
               var reqDetilId= idarea[2];
            }
           var reqPage="3";
        }
        else
        {
           var reqAreaDuplikatId= "<?=$reqAreaDuplikatId?>";
           var reqAreaId= "<?=$reqAreaId?>";
           var reqDetilId= "<?=$reqDetilId?>";
        }

        if(id=="detil")
        {
            var idareadetil =($('td:first', this).text());
            var reqAreaDetilId= idareadetil;        
            var reqPage="4";
            var reqId = $(this).closest('tr').find('td:eq(1)').text();
            var reqRekomendasiId = $(this).closest('tr').find('td:eq(2)').text();
        }
        else
        {
           var reqAreaDetilId= "<?=$reqAreaDetilId?>";
        }

        if(id ==""  || id ==undefined )
        {
            return false;
        }
        else
        {
            window.open('app/index/outlining_assessment_rekomendasi?reqAreaDetilId='+reqAreaDetilId+'&reqDetilId='+reqDetilId+'&reqId='+reqId+'&reqKembali=1&reqPage='+reqPage+'&reqDistrikId='+reqDistrikId+'&reqBlokId='+reqBlokId+'&reqAreaDuplikatId='+reqAreaDuplikatId+'&reqAreaId='+reqAreaId+'&reqRekomendasiId='+reqRekomendasiId, '_self'); 
        }
       
    });

});


function filterrekomendasi(bulan,tahun) {
   $("#distrikm").empty();
       $.getJSON("json-app/outlining_assessment_json/filter_rekomendasi?reqBulan="+bulan+"&reqTahun="+tahun,
        function(data){
            data.forEach(function(entry) {
            // console.log();
             $('#distrikm').append("<tr class='distrik'><td style='display: none'>"+entry.DISTRIK_ID+"</td><td style='display: none'>"+entry.BLOK_UNIT_ID+"</td><td style='display: none'>"+entry.OUTLINING_ASSESSMENT_ID+"</td><td><label style='font-weight: normal !important;'>"+entry.BULAN_NAMA+"</label></td><td class='text-center'><label style='font-weight: normal !important;'>"+entry.TAHUN+"</label></td><td><label style='font-weight: normal !important;'>"+entry.DISTRIK_NAMA+"</label></td><td><label style='font-weight: normal !important;'>"+entry.BLOK_NAMA+"</label></td><td>"+entry.STATUS+"</td><td class='text-center'>"+entry.TERISI+' / '+entry.TOTAL+"</td><td class='text-center'>"+entry.PERC_AREA+" %</td></tr>");
        });
    });
}

function HapusFile(reqRekomendasiId) {
    $.messager.confirm('Konfirmasi',"Hapus File terpilih?",function(r){
        if (r){
            $.getJSON("json-app/outlining_assessment_json/deleterekomendasifile?reqRekomendasiId="+reqRekomendasiId,
                function(data){
                    // console.log(data);return false;
                    $.messager.alert('Info', data.PESAN, 'info');                    
                    location.reload();
                });
        }
    }); 
}


function kembali()
{
    history.back();
}

function submitForm(){
    
    $('#ff').form('submit',{
        url:'json-app/outlining_assessment_json/addrekomendasinew',
        onSubmit:function(){

            if($(this).form('validate'))
            {
                var win = $.messager.progress({
                    title:'<?=$this->configtitle["progres"]?>',
                    msg:'proses data...'
                });
            }

            return $(this).form('enableValidation').form('validate');
        },
        success:function(data){
            $.messager.progress('close');
            // console.log(data);return false;

            data = data.split("***");
            reqId= data[0];
            infoSimpan= data[1];

            if(reqId == 'xxx')
                $.messager.alert('Info', infoSimpan, 'warning');
            else
            {
                // $.messager.alertLink('Info', infoSimpan, 'info', "app/index/outlining_assessment_rekomendasi?reqRekomendasiId="+reqId+"&reqAreaDetilId=<?=$reqAreaDetilId?>&reqDetilId=<?=$reqDetilId?>&reqId=<?=$reqId?>&reqKembali=<?=$reqKembali?>&reqPage=<?=$reqPage?>&reqDistrikId=<?=$reqDistrikId?>&reqBlokId=<?=$reqBlokId?>&reqAreaDuplikatId=<?=$reqAreaDuplikatId?>&reqAreaId=<?=$reqAreaId?>");
                $.messager.alert('Info', infoSimpan, 'info');
                location.reload();
            }
           
        }
    });
}

function clearForm(){
    $('#ff').form('clear');
} 

    
</script>