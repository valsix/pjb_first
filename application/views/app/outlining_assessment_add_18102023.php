<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/OutliningAssessment");
$this->load->model("base-app/ListArea");
$this->load->model("base-app/Distrik");
$this->load->model("base-app/StandarReferensi");
$this->load->model("base-app/ItemAssessment");
$this->load->model("base-app/BlokUnit");
$this->load->model("base-app/UnitMesin");
$this->load->model("base-app/KategoriItemAssessment");
$this->load->model("base-app/ProgramItemAssessment");
$this->load->model("base-app/Crud");
$this->load->model("base/Users");


$this->load->library('libapproval');
$this->load->library('globalfunc');

$appuserkodehak= $this->appuserkodehak;
$reqPenggunaid= $this->appuserid;

$arrBulan=setBulanLoop();
$arrTahun= setTahunLoop(2,1);



$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");
$reqBulan = $this->input->get("reqBulan");
$reqTahun = $this->input->get("reqTahun");
$reqAppr = $this->input->get("reqAppr");
$reqVstatus = $this->input->get("reqVstatus");



$readonlyfilter="";
$set= new OutliningAssessment();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

    $statement = " AND A.OUTLINING_ASSESSMENT_ID = '".$reqId."' AND A.BULAN = '".$reqBulan."' AND A.TAHUN = '".$reqTahun."'";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("OUTLINING_ASSESSMENT_ID");
    $reqDistrikId= $set->getField("DISTRIK_ID");
    $reqBlokId= $set->getField("BLOK_UNIT_ID");
    $reqUnitMesinId= $set->getField("UNIT_MESIN_ID");
    $reqBulan= $set->getField("BULAN");
    $reqTahun= $set->getField("TAHUN");
    $vstatus= $set->getField("V_STATUS");
    unset($set);

 
    $set= new OutliningAssessment();
    $arrlist= [];

    $statement=" AND A.STATUS IS NULL AND B.STATUS_KONFIRMASI = 1 AND D.OUTLINING_ASSESSMENT_ID = '".$reqId."'    ";

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
    else
    {
        // $statement .=" AND 1=2 = ";
    }

    // if(!empty($reqListAreaId))
    // {
    //     $statement .=" AND B.LIST_AREA_ID = ".$reqListAreaId;
    // }

    // if(!empty($reqItemAssessmentDuplikatId))
    // {
    //     $statement .=" AND B.ITEM_ASSESSMENT_DUPLIKAT_ID = ".$reqItemAssessmentDuplikatId;
    // }

    // if(!empty($reqListAreaId))
    // {
    //     $statement .=" AND A.LIST_AREA_ID = ".$reqListAreaId;
    // }

    // if(!empty($reqItemAssessmentDuplikatId))
    // {
    //     $statement .=" AND A1.ITEM_ASSESSMENT_DUPLIKAT_ID = ".$reqItemAssessmentDuplikatId;
    // }
    $set->selectByParamsDetilNew(array(), -1,-1,$statement);
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
        $arrdata["AREA_UNIT_ID"]= $set->getField("AREA_UNIT_ID");
        $arrdata["AREA_UNIT_DETIL_ID"]= $set->getField("AREA_UNIT_DETIL_ID");
        $arrdata["NAMA_MESIN"]= $set->getField("NAMA_MESIN");
        $arrdata["NAMA_BLOK"]= $set->getField("NAMA_BLOK");
        array_push($arrlist, $arrdata);
    }

    unset($set);

    // print_r($arrdetil);exit;

    $readonlyfilter="readonly";

}

$editable= ($vstatus<10 || $vstatus>=90) ? '':'style="display:none"';


// if($reqBulan == "")
//     $reqBulan= date("m");
// elseif($reqBulan == "x")
//     $reqBulan= "";
    
// if($reqTahun == "")
//     $reqTahun= date("Y");


$disabled="";


if($reqLihat ==1 || $vstatus==20)
{
    $disabled="disabled";  
}

$arridDistrik=[];
$usersdistrik = new Users();
$usersdistrik->selectByPenggunaDistrik($reqPenggunaid);
while($usersdistrik->nextRow())
{
    $arridDistrik[]= $usersdistrik->getField("DISTRIK_ID"); 
   
}

$idDistrik = implode(",",$arridDistrik);  


$set= new Distrik();
$arrdistrik= [];

if(!empty($idDistrik))
{

    $statement=" AND A.DISTRIK_ID IN (".$idDistrik.") AND A.STATUS IS NULL AND A.NAMA IS NOT NULL 
    AND EXISTS
    (
    SELECT A.DISTRIK_ID FROM AREA_UNIT B  
    INNER JOIN  AREA_UNIT_DETIL C ON C.AREA_UNIT_ID = B.AREA_UNIT_ID  
    WHERE A.DISTRIK_ID=B.DISTRIK_ID
    )";
}
else
{
    $statement=" AND A.STATUS IS NULL AND A.NAMA IS NOT NULL 
    AND EXISTS
    (
    SELECT A.DISTRIK_ID FROM AREA_UNIT B  
    INNER JOIN  AREA_UNIT_DETIL C ON C.AREA_UNIT_ID = B.AREA_UNIT_ID  
    WHERE A.DISTRIK_ID=B.DISTRIK_ID
    )";
}


$set->selectByParamsAreaDistrik(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("DISTRIK_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrdistrik, $arrdata);
}
unset($set);



$set= new BlokUnit();
$arrblok= [];

if(empty($reqDistrikId))
{
    $statement=" AND 1=2";
}
else
{
    $statement=" AND EXISTS
    (
        SELECT A.BLOK_UNIT_ID FROM AREA_UNIT B
        INNER JOIN  AREA_UNIT_DETIL C ON C.AREA_UNIT_ID = B.AREA_UNIT_ID  
        WHERE A.BLOK_UNIT_ID=B.BLOK_UNIT_ID
    )  
    AND A.DISTRIK_ID =".$reqDistrikId;
}
$set->selectByParams(array(), -1,-1,$statement);
    // echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("BLOK_UNIT_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrblok, $arrdata);
}
unset($set);

if(empty($reqBlokId))
{
    $statement=" AND 1=2";
}
else
{
    $statement="  AND EXISTS
    (
        SELECT A.UNIT_MESIN_ID FROM AREA_UNIT B 
        INNER JOIN  AREA_UNIT_DETIL C ON C.AREA_UNIT_ID = B.AREA_UNIT_ID 
        WHERE A.UNIT_MESIN_ID=B.UNIT_MESIN_ID
    ) 
    AND A.BLOK_UNIT_ID =".$reqBlokId;
}

$set= new UnitMesin();
$arrunitmesin= [];
$set->selectByParams(array(), -1,-1,$statement);
    // echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("UNIT_MESIN_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrunitmesin, $arrdata);
}
unset($set);

$set= new Crud();

$statement=" AND A.KODE_HAK = '".$appuserkodehak."'";
// $statement=" ";

$set->selectByParamsCrudHak(array(), -1, -1, $statement);
$set->firstRow();
$reqPenggunaHakId= $set->getField("PENGGUNA_HAK_ID");


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

/****/
#reqDeskripsi,
#reqKeterangan {
    width: 340px;
}

select[readonly]:-moz-read-only {
  /* For Firefox */
  pointer-events: none;
}

select[readonly]:read-only {
  pointer-events: none;
}

table { width: 50% }
tbody tr:hover.selected td,
tbody tr:hover td {
  background-color: #fbfdb3;
  cursor: pointer;
}
/*tbody tr.selected td {
  background-color: #b3ccfd ;
}*/

td {border: 1px #DDD solid; padding: 5px; cursor: pointer;}

.pilihtabel {
    background-color: #06ae48;
    /*color: #FFF;*/
}

</style>


<div class="col-md-12">
    <?
    if($reqAppr==1)
    {
    ?>
        <div class="judul-halaman"> <a href="app/index/outlining_assessment_approval?reqVstatus=<?=$reqVstatus?>">Data <?=$pgtitle?></a> &rsaquo; Kelola <?=$pgtitle?></div>
    <?
    }
    else
    {
    ?>
        <div class="judul-halaman"> <a href="app/index/<?=$pgreturn?>">Data <?=$pgtitle?></a> &rsaquo; Kelola <?=$pgtitle?></div>
       
    <?
    }
    ?>

    <div class="konten-area">

        <div class="konten-inner">
        
            <div>
                <?
                if(isset($vstatus))
                {
                   if($vstatus !=="1")
                   {
                ?>
                    <div style="margin-bottom: 10px">
                        <button id="btnfilter" type='button' class="filter btn btn-default pull-left">Show/hide Approval <i class="fa fa-caret-down" aria-hidden="true"></i></button>
                    </div>
                    <br>
                <?
                    }
                }
                ?>
                
                
                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data" autocomplete="off">


                    <?
                    // untuk approval
                    ?>
                    <input type="hidden" name="infopg" value="<?=$pg?>" />
                    <?
                    $approval_table= "outlining_assessment";
                    $approval_field_id= "OUTLINING_ASSESSMENT_ID";
                    $approval_field_status= "V_STATUS";
                    $vappr= new libapproval();
                    $arrparam= ["approval_info_pg"=>$pg, "approval_info_id"=>$reqId, "approval_table"=>$approval_table, "approval_field_id"=>$approval_field_id, "approval_field_status"=>$approval_field_status];
                            // print_r($arrparam);
                    $vappr->view($arrparam);
                    ?>


                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i> <?=$pgtitle?></h3>       
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Periode </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-3'>
                                    <select name="reqBulan" id="reqBulan"  <?=$disabled?> <?=$readonlyfilter?>   class="form-control datatable-input">
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
                                    <select name="reqTahun" id="reqTahun"  <?=$disabled?>   <?=$readonlyfilter?>  class="form-control datatable-input">
                                        <option value="">Semua</option>
                                        <?
                                        for($tahun=0;$tahun < count($arrTahun);$tahun++)
                                        {
                                            ?>
                                            <option value="<?=$arrTahun[$tahun]?>" <? if($reqTahun == $arrTahun[$tahun]) echo "selected";?>><?=$arrTahun[$tahun]?></option>
                                            <?
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Distrik </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <select class="form-control jscaribasicmultiple" <?=$readonlyfilter?>  required id="reqDistrikId" <?=$disabled?> name="reqDistrikId"  style="width:100%;" >
                                        <option value="" >Pilih Distrik</option>
                                        <?
                                        foreach($arrdistrik as $item) 
                                        {
                                            $selectvalid= $item["id"];
                                            $selectvaltext= $item["text"];

                                            $selected="";
                                            if($selectvalid == $reqDistrikId)
                                            {
                                                $selected="selected";
                                            }
                                            ?>
                                            <option value="<?=$selectvalid?>" <?=$selected?>><?=$selectvaltext?></option>
                                            <?
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">UL / PL / BLOK UNIT </label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11' id="blok">
                                <select class="form-control jscaribasicmultiple"  id="reqBlokId" <?=$readonlyfilter?> <?=$disabled?> name="reqBlokId"  style="width:100%;" >
                                <?
                                foreach($arrblok as $item) 
                                {
                                    $selectvalid= $item["id"];
                                    $selectvaltext= $item["text"];
                                    $selected="";
                                    if($selectvalid == $reqBlokId)
                                    {
                                        $selected="selected";
                                    }

                                    ?>
                                    <option value="<?=$selectvalid?>" <?=$selected?>><?=$selectvaltext?></option>

                                    <?
                                }
                                ?>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div style="display: none;">
                            <label class="control-label col-md-2">UNIT MESIN </label>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <div class='col-md-11'  id="unit">
                                        <select class="form-control jscaribasicmultiple"  id="reqUnitMesinId" <?=$disabled?> name="reqUnitMesinId"  style="width:100%;" >
                                        <option value="" >Pilih Unit Mesin</option>
                                        <?
                                        foreach($arrunitmesin as $item) 
                                        {
                                            $selectvalid= $item["id"];
                                            $selectvaltext= $item["text"];
                                            $selected="";
                                            if($selectvalid == $reqUnitMesinId)
                                            {
                                                $selected="selected";
                                            }

                                            ?>
                                            <option value="<?=$selectvalid?>" <?=$selected?>><?=$selectvaltext?></option>

                                            <?
                                        }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="tambaharea">  
                        <label class="control-label col-md-2">Tambah Area</label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11' id="blok">
                                     <a id="btnAdd" onclick="openArea()"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?
                    // if(!empty($reqId))
                    // {
                    ?>
                        <div class="page-header" style="background-color: green">
                            <h3><i class="fa fa-file-text fa-lg"></i> Area</h3>       
                        </div>

                        <div style="overflow-y: auto;height: 300px;width: 100%;">
                           <!--  <table id="tabel" class="table table-bordered table-striped table-hovered" style="width: 100%;" > -->
                             <table id="tabel" class="table table-bordered" style="width: 100%;" >
                                <thead >
                                    <tr>
                                        <th class="text-center" style="vertical-align: middle;">No</th>
                                        <th class="text-center" style="vertical-align: middle;">Blok Unit</th>
                                        <th class="text-center" style="vertical-align: middle;">Unit Mesin</th>
                                        <th class="text-center" style="vertical-align: middle;">Area</th>
                                        <th class="text-center" style="vertical-align: middle;">Nama di Unit</th>
                                        <th class="text-center" style="width: 20%;vertical-align: middle;">Status</th>
                                        <th class="text-center" style="width: 5%;text-align: center;vertical-align: middle;">Confirm </th>
                                        <th class="text-center" style="width: 5%;text-align: center;vertical-align: middle;">Not Confirm </th>
                                    </tr>
                                </thead>
                                <tbody id="outlinedetil">
                                    <?
                                    $arriduniq=[];
                                    if(!empty($arrlist))
                                    {
                                    ?>
                                        <?
                                        $reqUniqId=1;
                                       
                                        foreach ($arrlist as $key => $value) 
                                        {   

                                            $reqListAreaId=$value["id"];
                                            $reqItemAssessmentDuplikatId=$value["ITEM_ASSESSMENT_DUPLIKAT_ID"];
                                            $reqAreaUnitId=$value["AREA_UNIT_ID"];
                                            $reqAreaUnitDetilId=$value["AREA_UNIT_DETIL_ID"];
                                            $reqNamaBlok=$value["NAMA_BLOK"];
                                            $reqNamaMesin=$value["NAMA_MESIN"];

                                            $setdetil= new OutliningAssessment();
                                            $statement = " AND A.OUTLINING_ASSESSMENT_ID = '".$reqId."' AND A.LIST_AREA_ID= ".$reqListAreaId." AND A.ITEM_ASSESSMENT_DUPLIKAT_ID= ".$reqItemAssessmentDuplikatId." AND A.AREA_UNIT_DETIL_ID= ".$reqAreaUnitDetilId." ";
                                            $setdetil->selectByParamsDetil(array(), -1,-1,$statement);

                                            // echo $setdetil->query;
                                            $setdetil->firstRow();
                                            $reqDetilId= $setdetil->getField("OUTLINING_ASSESSMENT_DETIL_ID");

                                            $setareadetil= new OutliningAssessment();
                                            $statement = " AND A.OUTLINING_ASSESSMENT_DETIL_ID = '".$reqDetilId."'";
                                            $setareadetil->selectByParamsAreaDetil(array(), -1,-1,$statement);

                                            // echo $setareadetil->query;exit;
                                            $setareadetil->firstRow();
                                            $reqAreaDetilId= $setareadetil->getField("OUTLINING_ASSESSMENT_AREA_DETIL_ID");

                                            $setarea= new OutliningAssessment();
                                            $statement = " AND A.OUTLINING_ASSESSMENT_DETIL_ID = '".$reqDetilId."' AND A.STATUS_CONFIRM = 1";
                                            $jumlahstatusconfirm = $setarea->getCountByParamsAreaDetilStatus(array(), $statement);

                                            $setarea= new OutliningAssessment();
                                            $statement = " AND A.OUTLINING_ASSESSMENT_DETIL_ID = '".$reqDetilId."' AND A.STATUS_CONFIRM = 0";
                                            $jumlahstatusnotconfirm = $setarea->getCountByParamsAreaDetilStatus(array(), $statement);

                                            $setarea= new OutliningAssessment();
                                            $statement = " AND A.OUTLINING_ASSESSMENT_DETIL_ID = '".$reqDetilId."' ";
                                            $jumlahstatussudah = $setarea->getCountByParamsAreaDetilStatus(array(), $statement);

                                            $setarea= new OutliningAssessment();
                                            $statement = " AND A.STATUS_KONFIRMASI IS NOT NULL  AND B.LIST_AREA_ID = '".$reqListAreaId."' ";
                                            $jumlahdata = $setarea->getCountByParamsAreaDetil(array(), $statement);

                                            // echo $setarea->query;

                                            $statussudah="";

                                            if($jumlahstatussudah > 0  )
                                            {
                                                if($jumlahstatussudah !== $jumlahdata )
                                                {
                                                    $statussudah="Belum Lengkap";
                                                }
                                                else
                                                {
                                                    $statussudah="Sudah Terisi";
                                                }
                                            }

                                            // print($jumlahstatussudah);                                       

                                        ?>
                                            <tr id="<?=$reqUniqId?>">
                                                <td> <?=$reqUniqId?></td>
                                                <td> <?=$reqNamaBlok?></td>
                                                <td> <?=$reqNamaMesin?></td>
                                                <td >
                                                    <input class="easyui-validatebox textbox form-control" type="hidden" name="reqListAreaId[]" id="reqListAreaId<?=$reqUniqId?>"   value="<?=$reqListAreaId?>"  >
                                                    <input class="easyui-validatebox textbox form-control" type="hidden" name="reqItemAssessmentDuplikatId[]" id="reqItemAssessmentDuplikatId<?=$reqUniqId?>"   value="<?=$reqItemAssessmentDuplikatId?>"  >
                                                    <label style="font-weight: normal !important;"><?=$value["text"]?></label>
                                                </td>
                                                <td>
                                                    <input class="easyui-validatebox textbox form-control" type="hidden" name="reqAreaUnitId[]" id="reqAreaUnitId<?=$reqUniqId?>"   value="<?=$reqAreaUnitId?>"  >
                                                    <input class="easyui-validatebox textbox form-control" type="hidden" name="reqAreaUnitDetilId[]" id="reqAreaUnitDetilId<?=$reqUniqId?>"   value="<?=$reqAreaUnitDetilId?>"  >
                                                   <!--  <input class="easyui-validatebox textbox form-control" type="text" name="reqNama[]" id="reqNama<?=$reqUniqId?>" disabled  value="<?/*=$value["AREA_UNIT"]*/?>" style="width: 500px" > -->
                                                    <label style="font-weight: normal !important;" ><?=$value["AREA_UNIT"]?></label>

                                                </td>
                                                <td  style='white-space: nowrap' >
                                                    <?
                                                    if(!empty($reqAreaDetilId))
                                                    {
                                                        ?>
                                                         <label style="font-weight: normal !important;"><?=$statussudah?></label>
                                                        <?
                                                    }
                                                    ?>
                                                </td>
                                                <td style="text-align: center"> <?=$jumlahstatusconfirm?></td> 
                                                <td style="text-align: center"> <?=$jumlahstatusnotconfirm?></td>    
                                                <td style="display: none">   
                                                    <input class="easyui-validatebox textbox form-control" type="text" name="reqDetilId[]" id="reqDetilId<?=$reqUniqId?>"   value="<?=$reqDetilId?>" style="width: 500px" >
                                                   
                                                </td>
                                            </tr>
                                        <?
                                        $reqUniqId++;
                                        }
                                        ?>
                                    <?
                                    }
                                    ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    <?
                    // }
                    ?>


                    <input type="hidden" name="reqId" value="<?=$reqId?>" />
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
                    <input type="hidden" name="reqStatusAktif" id="reqStatusAktif"   value="" style="width: 500px" >

                    <div id="inputselect">
                    </div>

                   

               

            </div>
            <?
            if($reqLihat ==1)
            {}
            else
            {
            ?>
                <div style="text-align:center;padding:5px">
                    <input type='hidden' name='is_draft' id="is_draft" value='<?php echo ($vstatus==1)?1:0?>'>

                    <?
                    if($vstatus==1 || $vstatus =='')
                    {
                        if($reqPenggunaHakId == 1 || $reqPenggunaHakId==3)
                        {

                        ?>
                        <a href="javascript:void(0)" class="btn btn-primary" id='draft'>Simpan Draft</a>
                        <?
                        }
                    }
                    ?>

                    <?
                    if($vstatus==20)
                    {

                        ?>
                        <?
                        if(empty($reqFinish))
                        {
                            ?>
                            <!-- <a href="javascript:void(0)" class="btn btn-primary" id='updateapp'>Simpan</a> -->
                            <?
                        }
                        else
                        {
                            ?>
                            <!-- <a href="javascript:void(0)" class="btn btn-primary" id='updateapp'>Update Status Finish</a> -->
                            <?
                        }
                        ?>
                        <?
                    }
                    ?>


                    <?

                    // if($vstatus==1 || $vstatus =='' || $vstatus ==90 && ( $reqPenggunaHakId == 1 || $reqPenggunaHakId == 3 ))
                    // {
                    ?>
                        <!-- <a href="javascript:void(0)" class="btn btn-warning" id='update' <? /*php echo  $editable*/?>>Kirim</a> -->
                        <a href="javascript:void(0)" class="btn btn-warning" id='update' >Kirim</a>
                        <a href="javascript:void(0)" class="btn btn-primary" id='simpannew' >Simpan</a>
                       
                    <?
                    // }
                    ?>
                </div>

            <?
            }
            ?>
             </form>
            
        </div>
    </div>
    
</div>

<script src="assets/emodal/eModal.js"></script>
<script src="assets/emodal/eModal-cabang.js"></script>

<script>



var check_vstatus='<?=$vstatus?>';
var cekroleid='<?=$reqPenggunaHakId?>';

// console.log(check_vstatus);

if(check_vstatus==20)
{
    $('#tambaharea').hide();
}
else
{
    $('#tambaharea').show();
}

var checkkirim = $('#checkkirim').val();
$('#simpannew').hide();
$('#update').hide();
// console.log(check_vstatus);
if(cekroleid == 1 || cekroleid == 3)
{
    if(check_vstatus==1 || check_vstatus =='' || check_vstatus ==90)
    {
        $('#update').show();
    }
}

// console.log(check_vstatus);

if(check_vstatus ==30 && checkkirim==1 )
{
    $('#simpannew').show();
}

$('#simpannew').click(function() {
    $('#is_draft').val(30);
    submitForm();
    return false; // avoid to execute the actual submit of the form.
});



$('#update,#update2').click(function() {
    $('#is_draft').val(0);
    submitForm();
    return false; // avoid to execute the actual submit of the form.
});

$('#updateapp').click(function() {
    $('#is_draft').val(1);
    submitForm();
    return false; // avoid to execute the actual submit of the form.
});


$('#draft,#draft2').click(function() {
    $('#is_draft').val(1);
    submitForm();
    return false; // avoid to execute the actual submit of the form.
});

$('#outlinedetil tr').dblclick(function(){
  var id = $(this).attr('id');
  var reqDetilId= $("#reqDetilId"+id).val();
  var reqListAreaId= $("#reqListAreaId"+id).val();
  var reqItemAssessmentDuplikatId= $("#reqItemAssessmentDuplikatId"+id).val();
  var reqAreaUnitDetilId= $("#reqAreaUnitDetilId"+id).val();
  var reqAreaUnitId= $("#reqAreaUnitId"+id).val();

  var readonly="";


    if(check_vstatus !== "20" )
    {
        // $.messager.alert('Info', " Selesaikan Proses Approval terlebih dahulu.", 'warning');
        // return false;
        // var readonly=1;
    }

    // console.log(check_vstatus);

    if(reqDetilId == "" || reqDetilId=='undefined'  )
    {
        $.messager.alert('Info', "Simpan data terlebih dahulu.", 'warning');
        return false;
    }
    else
    {

        window.open('app/index/outlining_assessment_add_detil?reqId=<?=$reqId?>&reqBulan=<?=$reqBulan?>&reqTahun=<?=$reqTahun?>&reqDetilId='+reqDetilId+'&reqListAreaId='+reqListAreaId+'&reqItemAssessmentDuplikatId='+reqItemAssessmentDuplikatId+'&reqAreaUnitDetilId='+reqAreaUnitDetilId+'&reqAreaUnitId='+reqAreaUnitId, '_self'); 
    }
 
});

function AddRekomendasi(reqDetilId,reqId,reqListAreaId,reqItemAssessmentDuplikatId,reqTahun)
{
    openAdd('iframe/index/outlining_assessment_add_rekomendasi?reqDetilId='+reqDetilId+'&reqId='+reqId+'&reqListAreaId='+reqListAreaId+'&reqItemAssessmentDuplikatId='+reqItemAssessmentDuplikatId+'&reqTahun='+reqTahun);
}

function detilform(reqId,reqTahun,reqDetilId,reqListAreaId,reqItemAssessmentDuplikatId,reqAreaUnitDetilId,reqAreaUnitId)
{
    // window.open('app/index/outlining_assessment_add_detil?reqId='+reqId+'&reqDetilId='+reqDetilId+'&reqListAreaId='+reqListAreaId+'&reqItemAssessmentDuplikatId='+reqItemAssessmentDuplikatId, '_self');
    if(reqDetilId == "" || reqDetilId=='undefined'  )
    {
        // $.messager.alert('Info', "Simpan data terlebih dahulu.", 'warning');
        // return false;
    }
    else
    {

    window.open('app/index/outlining_assessment_add_detil?reqId=<?=$reqId?>&reqBulan=<?=$reqBulan?>&reqTahun=<?=$reqTahun?>&reqDetilId='+reqDetilId+'&reqListAreaId='+reqListAreaId+'&reqItemAssessmentDuplikatId='+reqItemAssessmentDuplikatId+'&reqAreaUnitDetilId='+reqAreaUnitDetilId+'&reqAreaUnitId='+reqAreaUnitId, '_self'); 
    } 
}

$("#reqTahun").on("input", function(evt) {
   var self = $(this);
   self.val(self.val().replace(/[^0-9]/g, ''));
   if ((evt.which != 46 ) && (evt.which < 48 || evt.which > 57)) 
   {
     evt.preventDefault();
   }
});


var z = "<?=$reqUniqId?>";
// console.log(z);
if( z== "" )
{
    id=1;
}
else
{
    id=z;
}
const uniqid = (() => {
    let i = id;
    return () => {
        return i++;
    }
})();

function openArea()
{
    openAdd('app/loadUrl/app/lookup_area_distrik_multi?reqId=<?=$reqId?>&reqUniqId=<?=$reqUniqId?>');
}
function setArea(values){
    // $('#myTable tr:last').after('<tr><td>'+someValue+'</td><td>New Row</td><td>New Row</td></tr>');
    // console.log(values);
    // $('#reqNomorWoId').val(values.WORK_ORDER_ID);
    // $('#reqNomorWo').val(values.WO+' - '+values.DESCRIPTION);
} 

function addmultiarea(id,iddpl, multiinfonama,idareaunit,idareaunitdetil, IDFIELD) 
{
    batas= id.length;

    if(batas > 0)
    {
        rekursivemultiarea(0, id,iddpl, multiinfonama,idareaunit,idareaunitdetil, IDFIELD);
    }
}

function rekursivemultiarea(index, id,iddpl, multiinfonama,idareaunit,idareaunitdetil, IDFIELD) 
{
    urllink= "app/loadUrl/app/template_area_distrik?reqId=<?=$reqId?>&reqUniqId="+uniqid();
    method= "POST";
    batas= id.length;
    if(index < batas)
    {
        AREA_ID= id[index];
        NAMA= multiinfonama[index];
        ITEM_ASSESSMENT_DUPLIKAT_ID= iddpl[index];
        AREA_UNIT_ID= idareaunit[index];
        AREA_UNIT_DETIL_ID= idareaunitdetil[index];

        // console.log(ITEM_ASSESSMENT_DUPLIKAT_ID);

        var rv = true;

        if (rv == true) 
        {
            $.ajax({
                url: urllink,
                method: method,
                data: {
                    reqListAreaId: AREA_ID,
                    reqNama: NAMA,
                    reqItemAssessmentDuplikatId: ITEM_ASSESSMENT_DUPLIKAT_ID,
                    reqAreaUnitId: AREA_UNIT_ID,
                    reqAreaUnitDetilId: AREA_UNIT_DETIL_ID
                },
                    // dataType: 'json',
                    success: function (response) {
                        $("#"+IDFIELD+"").append(response);

                        index= parseInt(index) + 1;
                        rekursivemultiarea(index,id,iddpl, multiinfonama,idareaunit,idareaunitdetil, IDFIELD);
                    },
                    error: function (response) {
                    },
                    complete: function () {
                    }
                });
        }
        else
        {
            index= parseInt(index) + 1;
            rekursivemultiarea(index,id,iddpl, multiinfonama,idareaunit,idareaunitdetil, IDFIELD);
        }
    }
}



$('#reqDistrikId').on('change', function() {
    // $("#blok").empty();
    var reqDistrikId= this.value;
     // $("#outlinedetil").empty();

     // var tableContent = localStorage.getItem('tableContent');
     // var lcldistrikid = localStorage.getItem('reqDistrikId');
   
    $.getJSON("json-app/outlining_assessment_json/filter_blok?reqDistrikId="+reqDistrikId,
        function(data)
        {
            // console.log(data);
            $("#reqBlokId option").remove();
            $("#reqUnitMesinId option").remove();
            $("#reqListAreaId option").remove();
            $("#reqBlokId").append('<option value="" >Pilih Blok Unit</option>');
            jQuery(data).each(function(i, item){
                $("#reqBlokId").append('<option value="'+item.id+'" >'+item.text+'</option>');
            });
        });
    // console.log(reqBlokId);
    // if (localStorage.getItem("tableContent") !== null && lcldistrikid==reqDistrikId ) {
    //     var tableContent = localStorage.getItem('tableContent');
    //     $("#outlinedetil").append(tableContent);
    // }
    // else
    // {
    //    $.get("app/loadUrl/app/outlining_assessment_add_area?reqId=<?=$reqId?>&reqUniqId="+uniqid()+"&reqDistrikId="+reqDistrikId+"&reqTahun=<?=$reqTahun?>", function(data) { 
    //     $("#outlinedetil").append(data);
    //     });
    // }

    // $.get("app/loadUrl/app/outlining_assessment_add_area?reqId=<?=$reqId?>&reqUniqId="+uniqid()+"&reqDistrikId="+reqDistrikId+"&reqTahun=<?=$reqTahun?>", function(data) { 
    //     $("#outlinedetil").append(data);
    // });

    $('#tambaharea').hide();
});

$('#reqBlokId').on('change', function() {
    // console.log(1);

    var reqDistrikId= $("#reqDistrikId").val();
    var reqBlokId= $("#reqBlokId").val();
    var reqUnitMesinId= $("#reqUnitMesinId").val();
    var reqBulan= '<?=$reqBulan?>';
    var reqTahun= '<?=$reqTahun?>';
    $("#outlinedetil").empty();

    var tableContent = localStorage.getItem('tableContent');
    var lclblokid = localStorage.getItem('reqBlokId');
    // console.log(lclblokid);
    // console.log(reqBlokId);
    

    $.getJSON("json-app/outlining_assessment_json/filter_unit?reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId+"&reqBulan="+reqBulan+"&reqTahun="+reqTahun,
        function(data)
        {
            // console.log(data);
            $("#reqUnitMesinId option").remove();
            $("#reqListAreaId option").remove();
            $("#reqUnitMesinId").append('<option value="" >Pilih Unit Mesin </option>');
            jQuery(data).each(function(i, item){
                $("#reqUnitMesinId").append('<option value="'+item.id+'" >'+item.text+'</option>');
            });
        });

    $("#reqStatusAktif").val(1);

    if (localStorage.getItem("tableContent") !== null && lclblokid==reqBlokId ) {
        var tableContent = localStorage.getItem('tableContent');
        $("#outlinedetil").append(tableContent);
    }
    else
    {
       $.get("app/loadUrl/app/outlining_assessment_add_area?reqId=<?=$reqId?>&reqUniqId="+uniqid()+"&reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId+"&reqTahun=<?=$reqTahun?>", function(data) { 
        $("#outlinedetil").append(data);
        });
    }

   
    $('#tambaharea').hide();

   
});


$('#reqUnitMesinId').on('change', function() {

    var reqDistrikId= $("#reqDistrikId").val();
    var reqBlokId= $("#reqBlokId").val();
    var reqUnitMesinId= $(this).val();
    var reqDetilId= "";
    $("#outlinedetil").empty();
    $.get("app/loadUrl/app/outlining_assessment_add_area?reqId=<?=$reqId?>&reqUniqId="+uniqid()+"&reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId+"&reqUnitMesinId="+reqUnitMesinId+"&reqTahun=<?=$reqTahun?>", function(data) { 
        $("#outlinedetil").append(data);
    });

    $("#reqStatusAktif").val(1);
     $('#tambaharea').hide();
    // $.getJSON("json-app/outlining_assessment_json/filter_area?reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId+"&reqUnitMesinId="+reqUnitMesinId,
    //     function(data)
    //     {
    //         // console.log(data);
    //         $("#outlinedetil").empty();
    //         jQuery(data).each(function(i, item){
    //             $.get("app/loadUrl/app/outlining_assessment_add_area?reqId=<?=$reqId?>&reqUniqId="+uniqid()+"&reqDetilId="+reqDetilId+"&reqListAreaId="+item.id+"&reqItemAssessmentDuplikatId="+item.ITEM_ASSESSMENT_DUPLIKAT_ID, function(data) { 
    //                 $("#outlinedetil").append(data);
    //             });
    //         });
    //     });
});

function HapusDetil(iddetil,reqId) {
    $.messager.confirm('Konfirmasi',"Hapus data terpilih?",function(r){
        if (r){
            $.getJSON("json-app/outlining_assessment_json/deleteareadetilnew?reqDetilId="+iddetil+"&reqId="+reqId,
                function(data){
                    // console.log(data);return false;
                    $.messager.alert('Info', data.PESAN, 'info');                    
                    location.reload();
                });
        }
    }); 
}

function save_check(){
    var tableContent = document.getElementById('outlinedetil').innerHTML;
    var reqBlokId= $("#reqBlokId").val();
    var reqDistrikId= $("#reqDistrikId").val();
    localStorage.setItem('tableContent', tableContent);
    localStorage.setItem('reqBlokId', reqBlokId);
    localStorage.setItem('reqDistrikId', reqDistrikId);
}

function submitForm(){

    var listareaid=[];
    $("#inputselect").empty();

    var checkid='<?=$reqId?>';
    // if(checkid=="")
    // {
        $("#tabel tr.pilihtabel").each(function(){
            // listareaid.push($('td:first', this).html());

            var valListAreaId = $(this).closest('tr').find('td:eq(0)').text();
            var valItemAssessmentDuplikatId= $(this).closest('tr').find('td:eq(1)').text();
            var valAreaUnitDetilId= $(this).closest('tr').find('td:eq(2)').text();
            var valAreaUnitId= $(this).closest('tr').find('td:eq(3)').text();

            // console.log(valItemAssessmentDuplikatId);

            var ListAreaId =" <input  type='hidden' name='reqListAreaId[]' id='reqListAreaId' value="+valListAreaId+" />";
            var ItemAssessmentDuplikatId =" <input  type='hidden' name='reqItemAssessmentDuplikatId[]' id='reqItemAssessmentDuplikatId' value="+valItemAssessmentDuplikatId+" />";
            var AreaUnitDetilId =" <input  type='hidden' name='reqAreaUnitDetilId[]' id='reqAreaUnitDetilId' value="+valAreaUnitDetilId+" />";
            var AreaUnitId =" <input  type='hidden' name='reqAreaUnitId[]' id='reqAreaUnitId' value="+valAreaUnitId+" />";

            $("#inputselect").append(ListAreaId+ItemAssessmentDuplikatId+AreaUnitDetilId+AreaUnitId);

        });

    // }
    var checkpertanyaan="";


    if(checkid=="")
    {

        var checkarea= $("#reqListAreaId").val();
        if(checkarea=='' || checkarea==undefined || checkarea==null)
        {
           $.messager.alert('Info', "Pilih salah satu area terlebih dahulu.", 'warning');
           return false;
        }

        $.messager.confirm('Konfirmasi',"Apakah anda yakin dengan data yang terpilih?",function(r)
        {
            if (r)
            {
               $('#ff').form('submit',{
                url:'json-app/outlining_assessment_json/add',
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

                        var reqBulan=  $("#reqBulan").val();
                        var reqTahun=  $("#reqTahun").val();

                        if(reqId == 'xxx')
                        {
                            $.messager.alert('Info', infoSimpan, 'warning');
                        }
                        else
                        {
                            localStorage.removeItem("tableContent");
                            localStorage.removeItem("reqBlokId");
                            $.messager.alertLink('Info', infoSimpan, 'info', "app/index/<?=$pgreturn?>_add?reqId="+reqId+"&reqBulan="+reqBulan+"&reqTahun="+reqTahun);
                        }
                    }
                }); 
            }
        });
    }
    else
    {
        $('#ff').form('submit',{
            url:'json-app/outlining_assessment_json/add',
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

                var reqBulan=  $("#reqBulan").val();
                var reqTahun=  $("#reqTahun").val();

                if(reqId == 'xxx')
                {
                    $.messager.alert('Info', infoSimpan, 'warning');
                }
                else
                {
                    localStorage.removeItem("tableContent");
                    localStorage.removeItem("reqBlokId");
                    $.messager.alertLink('Info', infoSimpan, 'info', "app/index/<?=$pgreturn?>_add?reqId="+reqId+"&reqBulan="+reqBulan+"&reqTahun="+reqTahun);
                }
            }
        }); 
    }
  
    
}

function clearForm(){
    $('#ff').form('clear');
}   
</script>