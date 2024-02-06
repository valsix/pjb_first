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



$arrBulan=setBulanLoop();
$arrTahun= setTahunLoop(2,1);


// print_r($arrBulan);exit;


$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");


$set= new OutliningAssessment();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

	$statement = " AND OUTLINING_ASSESSMENT_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("OUTLINING_ASSESSMENT_ID");
    $reqDistrikId= $set->getField("DISTRIK_ID");
    $reqBlokId= $set->getField("BLOK_UNIT_ID");
    $reqUnitMesinId= $set->getField("UNIT_MESIN_ID");
    $reqBulan= $set->getField("BULAN");
    $reqTahun= $set->getField("TAHUN");
    unset($set);

    $setdetil= new OutliningAssessment();
    $arrdetil= [];

    $statement = " AND A.OUTLINING_ASSESSMENT_ID = '".$reqId."' ";
    $setdetil->selectByParamsDetil(array(), -1,-1,$statement);
    // echo $setdetil->query;exit;
    while($setdetil->nextRow())
    {
        $arrdata= array();
        $arrdata["id"]= $setdetil->getField("OUTLINING_ASSESSMENT_DETIL_ID");
        $arrdata["text"]=$setdetil->getField("KODE_INFO");
        $arrdata["LIST_AREA_ID_INFO"]=$setdetil->getField("LIST_AREA_ID")." - ".$setdetil->getField("ITEM_ASSESSMENT_DUPLIKAT_ID");
        $arrdata["KATEGORI_ITEM_ASSESSMENT_ID"]= $setdetil->getField("KATEGORI_ITEM_ASSESSMENT_ID");
        $arrdata["ITEM_ASSESSMENT_FORMULIR_ID"]= $setdetil->getField("ITEM_ASSESSMENT_FORMULIR_ID");
        $arrdata["STANDAR_REFERENSI_ID"]= $setdetil->getField("STANDAR_REFERENSI_ID");
        $arrdata["STATUS_CONFIRM"]= $setdetil->getField("STATUS_CONFIRM");
        $arrdata["KETERANGAN"]= $setdetil->getField("KETERANGAN");
        $arrdata["DISTRIK_ID"]= $setdetil->getField("DISTRIK_ID");
        $arrdata["BLOK_UNIT_ID"]= $setdetil->getField("BLOK_UNIT_ID");
        $arrdata["UNIT_MESIN_ID"]= $setdetil->getField("UNIT_MESIN_ID");
        array_push($arrdetil, $arrdata);
    }

    unset($setdetil);

    // print_r($arrdetil);exit;

}

if($reqBulan == "")
    $reqBulan= date("m");
elseif($reqBulan == "x")
    $reqBulan= "";
    
if($reqTahun == "")
    $reqTahun= date("Y");


$disabled="";

if($reqLihat ==1)
{
    $disabled="disabled";  
}



$set= new Distrik();
$arrdistrik= [];

$statement=" AND A.STATUS IS NULL AND A.NAMA IS NOT NULL AND EXISTS(SELECT A.DISTRIK_ID FROM AREA_UNIT B WHERE A.DISTRIK_ID=B.DISTRIK_ID)";
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
    $statement=" AND EXISTS(SELECT A.BLOK_UNIT_ID FROM AREA_UNIT B WHERE A.BLOK_UNIT_ID=B.BLOK_UNIT_ID)  AND A.DISTRIK_ID =".$reqDistrikId;
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

if(empty($reqDistrikId))
{
    $statement=" AND 1=2";
}
else
{
    $statement="  AND EXISTS(SELECT A.UNIT_MESIN_ID FROM AREA_UNIT B WHERE A.UNIT_MESIN_ID=B.UNIT_MESIN_ID) AND A.DISTRIK_ID =".$reqDistrikId;
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

$set= new ListArea();
$arrlist= [];

$statement=" AND A.STATUS IS NULL ";

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
    array_push($arrlist, $arrdata);
}

unset($set);




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

/****/
#reqDeskripsi,
#reqKeterangan {
    width: 340px;
}

</style>


<div class="col-md-12">
    
  <div class="judul-halaman"> <a href="app/index/<?=$pgreturn?>">Data <?=$pgtitle?></a> &rsaquo; Kelola <?=$pgtitle?></div>

    <div class="konten-area">
        <div class="konten-inner">

            <div>

                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">

                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i> <?=$pgtitle?></h3>       
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Periode </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-3'>
                                    <select name="reqBulan" id="reqBulan" class="form-control datatable-input">
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
                                    <select name="reqTahun" id="reqTahun" class="form-control datatable-input">
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
                                    <select class="form-control jscaribasicmultiple" required id="reqDistrikId" <?=$disabled?> name="reqDistrikId"  style="width:100%;" >
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
                                <select class="form-control jscaribasicmultiple"  id="reqBlokId" <?=$disabled?> name="reqBlokId"  style="width:100%;" >
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
                        <label class="control-label col-md-2">UNIT MESIN </label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'  id="unit">
                                    <select class="form-control jscaribasicmultiple"  id="reqUnitMesinId" <?=$disabled?> name="reqUnitMesinId"  style="width:100%;" >
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


                    <div class="page-header" style="background-color: green">
                        <h3><i class="fa fa-file-text fa-lg"></i> Area</h3>       
                    </div>

                    <div style="text-align:left;padding:5px">
                        <a href="javascript:void(0)" class="btn btn-primary" onclick="btnTambah()">Tambah</a>

                    </div>

                    <div style="overflow-y: auto;height: 400px;width: 100%;">
                        <table id="" class="table table-bordered table-striped table-hovered" style="width: 100%;" >
                            <thead >
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Area</th>
                                    <th class="text-center">Nama di Unit</th>
                                    <th class="text-center">Deskripsi Area</th>
                                    <th class="text-center">Kategori Item Assessment</th>
                                    <th class="text-center">Item Assessment</th>
                                    <th class="text-center">Referensi Standard</th>
                                    <th class="text-center">Confirm</th>
                                    <th class="text-center">Not Confirm</th>
                                    <th class="text-center">Keterangan</th>
                                    <th class="text-center" style="width: 20%" >Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="outlinedetil">
                                <?
                                $arriduniq=[];
                                if(!empty($arrdetil))
                                {
                                ?>
                                    <?
                                    $reqUniqId=1;
                                   
                                    foreach ($arrdetil as $key => $value) 
                                    {

                                        $reqListAreaInfo=$value["LIST_AREA_ID_INFO"];
                                        $reqListAreaInfo = str_replace(' ', '', $reqListAreaInfo);
                                        $reqDetilId=$value["id"];
                                        $arrval = explode("-", $reqListAreaInfo);

                                        $reqListAreaId= $arrval[0];
                                        $reqItemAssessmentDuplikatId= $arrval[1];

                                        $reqDistrikId=$value["DISTRIK_ID"];
                                        $reqBlokId=$value["BLOK_UNIT_ID"];
                                        $reqUnitMesinId=$value["UNIT_MESIN_ID"];
                                        $reqKategoriItemAssessment=$value["KATEGORI_ITEM_ASSESSMENT_ID"];
                                        $reqFormulirId=$value["ITEM_ASSESSMENT_FORMULIR_ID"];
                                        $reqStandarId=$value["STANDAR_REFERENSI_ID"];
                                        $reqStatusConfirm=$value["STATUS_CONFIRM"];
                                        $reqKeterangan=$value["KETERANGAN"];

                                        $set= new ListArea();
                                        $statement=" AND B.LIST_AREA_ID = ".$reqListAreaId." AND B.ITEM_ASSESSMENT_DUPLIKAT_ID = ".$reqItemAssessmentDuplikatId." AND C.DISTRIK_ID = ".$reqDistrikId." AND C.BLOK_UNIT_ID = ".$reqBlokId." AND C.UNIT_MESIN_ID = ".$reqUnitMesinId;
                                        $set->selectduplikatfilter(array(), -1, -1, $statement);
                                            // echo $set->query;exit;
                                        $set->firstRow();
                                        $reqNama=$set->getField("AREA_UNIT");
                                        $reqAreaUnitDetilId=$set->getField("AREA_UNIT_DETIL_ID");
                                        $reqDeskripsi=$set->getField("DESKRIPSI");
                                        $arriduniq[]= $reqUniqId;

                                        $set= new KategoriItemAssessment();
                                        $arrkategori= [];



                                        if(!empty($reqListAreaId))
                                        {
                                            $statement =" AND A.LIST_AREA_ID = ".$reqListAreaId;
                                        }
                                        $set->selectByParamsAreaFilter(array(), -1,-1, $statement);
                                        // echo $set->query;
                                        while($set->nextRow())
                                        {
                                            $arrdata["id"]= $set->getField("KATEGORI_ITEM_ASSESSMENT_ID");
                                            $arrdata["text"]= $set->getField("NAMA");
                                            array_push($arrkategori, $arrdata);
                                        }

                                        $statement =" AND A.STATUS_KONFIRMASI = 1 ";

                                        if(!empty($reqKategoriItemAssessment))
                                        {
                                            $statement .=" AND A.KATEGORI_ITEM_ASSESSMENT_ID = ".$reqKategoriItemAssessment;
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
                                        $arrformulir= [];
                                        $set->selectByParamsAreaOutline(array(), -1,-1,$statement);
                                        // echo $set->query;exit;
                                        while($set->nextRow())
                                        {
                                            $arrdata= array();
                                            $arrdata["id"]= $set->getField("ITEM_ASSESSMENT_FORMULIR_ID");
                                            $arrdata["text"]=$set->getField("NAMA");
                                            $arrdata["STANDAR_REFERENSI_ID"]=$set->getField("STANDAR_REFERENSI_ID");
                                            array_push($arrformulir, $arrdata);
                                        }
                                        unset($set);

                                        $statement="  ";

                                        if(!empty($reqKategoriItemAssessment))
                                        {
                                            $statement .=" AND D.KATEGORI_ITEM_ASSESSMENT_ID = ".$reqKategoriItemAssessment;
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
                                        $arrstandar= [];
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
                                            array_push($arrstandar, $arrdata);
                                        }
                                        unset($set);


                                        // print_r($reqListAreaInfo);
                                    ?>
                                        <tr>
                                            <td> <?=$reqUniqId?></td>
                                            <td>
                                                <select class="form-control jscaribasicmultiple" required id="reqListAreaId<?=$reqUniqId?>" <?=$disabled?> name="reqListAreaId[]"  style="width:300px;"   >
                                                    <option value="" >Pilih Area </option>
                                                    <?
                                                    foreach($arrlist as $item) 
                                                    {
                                                        $selectvalid= $item["id"];
                                                        $selectvalidduplikat= $item["ITEM_ASSESSMENT_DUPLIKAT_ID"];
                                                        $selectvaltext= $item["text"];

                                                        $check=$selectvalid.'-'.$selectvalidduplikat;

                                                        // var_dump($check);
                                                        // var_dump($reqListAreaInfo);

                                                        $selected="";
                                                        if($check == $reqListAreaInfo )
                                                        {
                                                            $selected="selected";
                                                        }
                                                        ?>
                                                        <option value="<?=$selectvalid?>-<?=$selectvalidduplikat?>" <?=$selected?>><?=$selectvaltext?></option>
                                                        <?
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <input class="easyui-validatebox textbox form-control" type="hidden" name="reqAreaUnitDetilId[]" id="reqAreaUnitDetilId<?=$reqUniqId?>"   value="<?=$reqAreaUnitDetilId?>"  >
                                                <input class="easyui-validatebox textbox form-control" type="text" name="reqNama[]" id="reqNama<?=$reqUniqId?>" disabled  value="<?=$reqNama?>" style="width: 500px" >
                                            </td>
                                            <td> 
                                                <textarea class="easyui-validatebox textbox form-control"  style="width: 340px;" disabled name="reqDeskripsi[]"  id="reqDeskripsi<?=$reqUniqId?>"><?=$reqDeskripsi?></textarea>
                                            </td>
                                            <td>
                                            <select class="form-control jscaribasicmultiple" required id="reqKategoriItemAssessment<?=$reqUniqId?>" <?=$disabled?> name="reqKategoriItemAssessment[]"   style="width:100%;"  >
                                                <?
                                                foreach($arrkategori as $item) 
                                                {
                                                    $selectvalid= $item["id"];
                                                    $selectvaltext= $item["text"];

                                                    $selected="";
                                                    if($selectvalid==$reqKategoriItemAssessment)
                                                    {
                                                        $selected="selected";
                                                    }
                                                    ?>
                                                    <option value="<?=$selectvalid?>" <?=$selected?>><?=$selectvaltext?></option>
                                                    <?
                                                }
                                                ?>
                                            </select>
                                            </td>
                                            <td> 
                                                <select class="form-control jscaribasicmultiple"  required id="reqFormulirId<?=$reqUniqId?>" <?=$disabled?> name="reqFormulirId[]"  style="width:100%;"  >
                                                    <?
                                                    foreach($arrformulir as $item) 
                                                    {
                                                        $selectvalid= $item["id"];
                                                        $selectvaltext= $item["text"];

                                                        $selected="";
                                                        if($selectvalid==$reqFormulirId)
                                                        {
                                                            $selected="selected";
                                                        }
                                                        ?>
                                                        <option value="<?=$selectvalid?>" <?=$selected?>><?=$selectvaltext?></option>
                                                        <?
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control deskripsiselect<?=$reqUniqId?> edittext" name="reqStandarId[]" required id="reqStandarId<?=$reqUniqId?>" <?=$disabled?>   style="width:500px;vertical-align: middle;" >
                                                    <?
                                                    foreach($arrstandar as $item) 
                                                    {
                                                        $selectvalid= $item["id"];
                                                        $selectvaltext= $item["text"];
                                                        $selectvaldesc= $item["desc"];

                                                        $selected="";
                                                        if($selectvalid==$reqStandarId)
                                                        {
                                                            $selected="selected";
                                                        }
                                                        ?>
                                                        <option value="<?=$selectvalid?>" title="<?=$selectvaldesc?>" <?=$selected?>><?=$selectvaltext?></option>
                                                        <?
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td style="
                                            transform: scale(1.7) translateX(7%); z-index: 1;
                                            transform-origin: top left;"><input type="radio" name="reqConfirm[<?=$reqUniqId?>]" id="reqConfirm<?=$reqUniqId?>" value="1" <? if($reqStatusConfirm==1) echo 'checked';?> ></td>
                                            <td style="
                                            transform: scale(1.7) translateX(7%); z-index: 1;
                                            transform-origin: top left;"><input type="radio" name="reqConfirm[<?=$reqUniqId?>]" id="reqConfirm<?=$reqUniqId?>" value="0" <? if($reqStatusConfirm==0) echo 'checked';?>></td>
                                            <td>  
                                                <textarea class="easyui-validatebox textbox form-control" style="width: 340px;"  name="reqKeterangan[]"  id="reqKeterangan"><?=$reqKeterangan?></textarea>
                                            </td>
                                            <td  style='white-space: nowrap' >
                                                <button class="btn btn-danger btn-sm " type="button"  onclick='HapusDetil("<?=$reqDetilId?>","<?=$reqId?>")'>
                                                    <i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a> 
                                                </button>
                                                <? if($reqStatusConfirm==0)
                                                {
                                                ?>
                                                    <button class="btn btn-success btn-sm " type="button"  onclick='AddRekomendasi("<?=$reqDetilId?>","<?=$reqId?>","<?=$reqListAreaId?>","<?=$reqItemAssessmentDuplikatId?>","<?=$reqTahun?>")'>
                                                        <i class='fa fa-pencil-square-o' style='color: white;' aria-hidden='true'></i></a> 
                                                    </button>
                                                <?
                                                }
                                                ?>
                                            </td>

                                            <td style="display: none">   
                                                <input class="easyui-validatebox textbox form-control" type="text" name="reqDetilId[]" id="reqDetilId<?=$reqUniqId?>"   value="<?=$reqDetilId?>" style="width: 500px" >
                                            </td>
                                        </tr>
                                        <script type="text/javascript">getarrstandar= <?=JSON_encode($arrstandar)?>;
                                            $(".deskripsiselect<?=$reqUniqId?>").select2({
                                              data: getarrstandar,
                                              escapeMarkup: function(markup) {
                                                return markup;
                                              },
                                              templateResult: function(data) {
                                                return data.html;
                                              },
                                              templateSelection: function(data) {
                                                return data.text;
                                              },
                                              matcher: matcher
                                            });


                                            function matcher(params, data) {

                                                if ($.trim(params.term) === '') {
                                                    return data;
                                                }

                                                if (typeof data.text === 'undefined') {
                                                    return null;
                                                }
                                                
                                                if (data.text.toLowerCase().indexOf(params.term.toLowerCase()) > -1 || (typeof data.html !== 'undefined' && data.html.toLowerCase().indexOf(params.term.toLowerCase()) > -1)) {
                                                    var modifiedData = $.extend({}, data, true);
                                                    modifiedData.text += ' (matched)';

                                                   
                                                    return modifiedData;
                                                }

                                                return null;
                                            }
                                        </script>
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


                    <input type="hidden" name="reqId" value="<?=$reqId?>" />
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>" />

                </form>

            </div>
            <?
            if($reqLihat ==1)
            {}
            else
            {
            ?>

            <div style="text-align:center;padding:5px">
                <a href="javascript:void(0)" class="btn btn-primary" onclick="submitForm()">Submit</a>
                <!-- <a href="javascript:void(0)" class="btn btn-success" onclick='AddRekomendasi("<?=$reqDetilId?>","<?=$reqId?>")'>Rekomendasi</a> -->

            </div>
            <?
            }
            ?>
            
        </div>
    </div>
    
</div>

<script src="assets/emodal/eModal.js"></script>
<script src="assets/emodal/eModal-cabang.js"></script>

<script>
function AddRekomendasi(reqDetilId,reqId,reqListAreaId,reqItemAssessmentDuplikatId,reqTahun)
{
    openAdd('iframe/index/outlining_assessment_add_rekomendasi?reqDetilId='+reqDetilId+'&reqId='+reqId+'&reqListAreaId='+reqListAreaId+'&reqItemAssessmentDuplikatId='+reqItemAssessmentDuplikatId+'&reqTahun='+reqTahun);
}   

$("#reqTahun").on("input", function(evt) {
   var self = $(this);
   self.val(self.val().replace(/[^0-9]/g, ''));
   if ((evt.which != 46 ) && (evt.which < 48 || evt.which > 57)) 
   {
     evt.preventDefault();
   }
});


$('#reqDistrikId').on('change', function() {
    // $("#blok").empty();
    var reqDistrikId= this.value;
   
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
   
});

$('#reqBlokId').on('change', function() {
    // console.log(1);

    var reqDistrikId= $("#reqDistrikId").val();
    var reqBlokId= $("#reqBlokId").val();
    var reqUnitMesinId= $("#reqUnitMesinId").val();

    $.getJSON("json-app/outlining_assessment_json/filter_unit?reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId,
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
   
});


$('#reqUnitMesinId').on('change', function() {

    var reqDistrikId= $("#reqDistrikId").val();
    var reqBlokId= $("#reqBlokId").val();
    var reqUnitMesinId= $(this).val();
    $.getJSON("json-app/outlining_assessment_json/filter_area?reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId+"&reqUnitMesinId="+reqUnitMesinId,
        function(data)
        {
            // console.log(data);
            $("#reqListAreaId option").remove();
            $("#reqListAreaId").append('<option value="" >Pilih Area</option>');
            jQuery(data).each(function(i, item){
                $("#reqListAreaId").append('<option value="'+item.id+'" >'+item.text+'</option>');
            });
        });
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


function btnTambah()
{
    var reqDistrikId= $("#reqDistrikId").val();
    var reqBlokId= $("#reqBlokId").val();
    var reqUnitMesinId= $("#reqUnitMesinId").val();

    if((reqBlokId == null || reqBlokId=="" ) || (reqUnitMesinId ==null || reqUnitMesinId=="") )
    {
        $.messager.alert('Info', "Pilih Blok unit dan Unit Mesin terlebih dahulu", 'warning');
                return false;
    }
    // console.log(reqUnitMesinId);
    $.get("app/loadUrl/app/outlining_assessment_add_detil?reqId=<?=$reqId?>&reqUniqId="+uniqid()+"&reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId+"&reqUnitMesinId="+reqUnitMesinId, function(data) { 
        $("#outlinedetil").append(data);
    });
}

var arridcheck = <?php echo json_encode($arriduniq); ?>;
arridcheck.forEach(function(idx) {
    $('#reqListAreaId'+idx).on('change', function() {
        var reqDistrikId= $("#reqDistrikId").val();
        var reqBlokId= $("#reqBlokId").val();
        var reqUnitMesinId= $("#reqUnitMesinId").val();
        var reqAreaId = $(this).val();
        var str = reqAreaId.split('-');
        var reqListAreaId=str[0];
        var reqItemAssessmentDuplikatId=str[1];
        // console.log(reqListAreaId);
        $.getJSON("json-app/outlining_assessment_json/filter_area?reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId+"&reqUnitMesinId="+reqUnitMesinId+"&reqListAreaId="+reqListAreaId+"&reqItemAssessmentDuplikatId="+reqItemAssessmentDuplikatId,
            function(data)
            {
                // console.log(reqAreaDuplikatId);
                jQuery(data).each(function(i, item){
                    $("#reqNama"+idx).val(item.AREA_UNIT);
                    $("#reqDeskripsi>"+idx).val(item.DESKRIPSI);
                });

                $.getJSON("json-app/outlining_assessment_json/filter_kategori?reqListAreaId="+reqListAreaId,
                    function(datax)
                    {
                     $("#reqKategoriItemAssessment"+idx+" option").remove();
                     $("#reqKategoriItemAssessment"+idx).append('<option value="" >Pilih Item Assessment</option>');
                     jQuery(datax).each(function(x, itemx){
                        $("#reqKategoriItemAssessment"+idx).append('<option value="'+itemx.id+'" >'+itemx.text+'</option>');
                    });
                 });

                $("#reqFormulirId"+idx+" option").remove();
                $("#reqFormulirId"+idx).append('<option value="" >Pilih Item Assessment</option>');
                $("#reqStandarId"+idx+" option").remove();
            });
    });

    $('#reqKategoriItemAssessment'+idx).on('change', function() {
        var reqAreaId = $("#reqListAreaId"+idx).val();
        var str = reqAreaId.split('-');
        var reqListAreaId=str[0];
        var reqItemAssessmentDuplikatId=str[1];
        var reqKategoriItemAssessmentId= $(this).val();
        // console.log(idx);
        $.getJSON("json-app/outlining_assessment_json/filter_item?reqListAreaId="+reqListAreaId+"&reqKategoriItemAssessmentId="+reqKategoriItemAssessmentId,
            function(datax)
            {
                $("#reqFormulirId"+idx+" option").remove();
                $("#reqFormulirId"+idx).append('<option value="" >Pilih Item Assessment</option>');
                jQuery(datax).each(function(x, itemx){
                    $("#reqFormulirId"+idx).append('<option value="'+itemx.id+'" >'+itemx.text+'</option>');
                });
                $("#reqStandarId"+idx+" option").remove();
            });
      
    });

    $('#reqFormulirId'+idx).on('change', function() {
        var reqAreaId = $("#reqListAreaId"+idx).val();
        var str = reqAreaId.split('-');
        var reqListAreaId=str[0];
        var reqItemAssessmentDuplikatId=str[1];
        var reqKategoriItemAssessmentId= $("#reqKategoriItemAssessment"+idx).val();
        var reqFormulirId= $(this).val();
        // console.log(idx);

        $.getJSON("json-app/outlining_assessment_json/filter_standar?reqListAreaId="+reqListAreaId+"&reqKategoriItemAssessmentId="+reqKategoriItemAssessmentId+"&reqFormulirId="+reqFormulirId,
            function(datax)
            {
                $("#reqStandarId"+idx+" option").remove();
                jQuery(datax).each(function(x, itemx){
                    console.log(idx);
                    $("#reqStandarId"+idx).append('<option value="'+itemx.id+'" title="'+itemx.DESKRIPSI+'"  >'+itemx.text+'</option>');
                    
                });

                // test(datax);
                // $('.deskripsiselect').select2();
            });
      
    });


});

function HapusDetil(iddetil,reqId) {
    $.messager.confirm('Konfirmasi',"Hapus data terpilih?",function(r){
        if (r){
            $.getJSON("json-app/outlining_assessment_json/deletedetil?reqDetilId="+iddetil+"&reqId="+reqId,
                function(data){
                    // console.log(data);return false;
                    $.messager.alert('Info', data.PESAN, 'info');                    
                    location.reload();
                });
        }
    }); 
}

function submitForm(){
    
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

            if(reqId == 'xxx')
                $.messager.alert('Info', infoSimpan, 'warning');
            else
                $.messager.alertLink('Info', infoSimpan, 'info', "app/index/<?=$pgreturn?>_add?reqId="+reqId);
        }
    });
}

function clearForm(){
    $('#ff').form('clear');
}   
</script>