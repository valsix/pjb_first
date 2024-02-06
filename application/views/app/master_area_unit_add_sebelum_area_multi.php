<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/AreaUnit");
$this->load->model("base-app/Distrik");
$this->load->model("base-app/ListArea");
$this->load->model("base-app/BlokUnit");

$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");
$this->load->model("base-app/UnitMesin");


$set= new AreaUnit();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

	$statement = " AND AREA_UNIT_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("AREA_UNIT_ID");
    $reqNama= $set->getField("NAMA");
    $reqKode= $set->getField("KODE");

    $reqDistrikId= $set->getField("DISTRIK_ID");
    $reqListAreaId= $set->getField("LIST_AREA_ID");
    $reqTersedia= $set->getField("TERSEDIA");
    $reqStatusKonfirmasi= $set->getField("STATUS_KONFIRMASI");
    $reqBlokId= $set->getField("BLOK_UNIT_ID");
    $reqUnitMesinId= $set->getField("UNIT_MESIN_ID");

    $reqAreaNama= $set->getField("KODE_INFO");
    $reqAreaKode= $set->getField("KODE_DUPLIKAT");

    $set= new ListArea();
    $arrarea= [];

    $statement=" AND A.STATUS IS NULL ";
    $set->selectByParams(array(), -1,-1,$statement);
    // echo $set->query;exit;
    while($set->nextRow())
    {
        $arrdata= array();
        $arrdata["id"]= $set->getField("LIST_AREA_ID");
        $arrdata["text"]= $set->getField("NAMA");
        array_push($arrarea, $arrdata);
    }
    unset($set);


    $set= new BlokUnit();
    $arrstandar= [];
    $set->selectByParams(array(), -1,-1," AND A.DISTRIK_ID =".$reqDistrikId);
    // echo $set->query;exit;
    while($set->nextRow())
    {
        $arrdata= array();
        $arrdata["id"]= $set->getField("BLOK_UNIT_ID");
        $arrdata["text"]= $set->getField("NAMA");
        array_push($arrstandar, $arrdata);
    }
    unset($set);


    $set= new UnitMesin();
    $arrprogram= [];
    $set->selectByParams(array(), -1,-1," AND A.DISTRIK_ID =".$reqDistrikId."  AND A.BLOK_UNIT_ID =".$reqBlokId);
    // echo $set->query;exit;
    while($set->nextRow())
    {
        $arrdata= array();
        $arrdata["id"]= $set->getField("UNIT_MESIN_ID");
        $arrdata["text"]= $set->getField("NAMA");
        array_push($arrprogram, $arrdata);
    }
    unset($set);


}

$disabled="";

if($reqLihat ==1)
{
    $disabled="disabled";  
}

$set= new Distrik();
$arrdistrik= [];

$statement=" AND A.STATUS IS NULL AND A.NAMA IS NOT NULL";
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

                   <!--  <div class="form-group">  
                        <label class="control-label col-md-2">Kode </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <input autocomplete="off" placeholder="Kode Harus unik dan tidak boleh ada spasi" class="easyui-validatebox textbox form-control" type="text" name="reqKode"  id="reqKode" value="<?=$reqKode?>" <?=$disabled?> data-options="required:true" style="width:100%" />
                               </div>
                           </div>
                       </div>
                    </div> -->

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
                                  foreach($arrstandar as $item) 
                                  {
                                    $selectvalid= $item["id"];
                                    $selectvaltext= $item["text"];
                                    $selected="";
                                    if($selectvalid == $reqBlokId)
                                    {
                                        $selected="selected";
                                    }

                                    ?>
                                    <!-- <input autocomplete="off" class="easyui-validatebox textbox form-control" type="hidden" name="reqBlokId[]"  id="reqBlokId" value="<?=$selectvalid?>" style="width:100%" readonly />
                                    <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqBlokNama"  id="reqBlokNama" value="<?=$selectvaltext?>" style="width:100%" readonly /> -->
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
                                    foreach($arrprogram as $item) 
                                    {
                                        $selectvalid= $item["id"];
                                        $selectvaltext= $item["text"];
                                        $selected="";
                                        if($selectvalid == $reqUnitMesinId)
                                        {
                                            $selected="selected";
                                        }

                                        ?>
                                       <!--  <input autocomplete="off" class="easyui-validatebox textbox form-control" type="hidden" name="reqUnitMesinId[]"  id="reqUnitMesinId" value="<?=$selectvalid?>" style="width:100%" readonly />
                                        <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqUnitMesinNama"  id="reqUnitMesinNama" value="<?=$selectvaltext?>" style="width:100%" readonly /> -->
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
                        <label class="control-label col-md-2">Area </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <select class="form-control jscaribasicmultiple" required id="reqListAreaId" <?=$disabled?> name="reqListAreaId[]"  style="width:100%;" multiple >
                                        <?
                                        foreach($arrarea as $item) 
                                        {
                                            $selectvalid= $item["id"];
                                            $selectvaltext= $item["text"];

                                            $selected="";
                                            if($selectvalid==$reqListAreaId)
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

                  <!--   <div class="form-group">  
                        <label class="control-label col-md-2">Area </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input type="hidden" name="reqListAreaId" id="reqListAreaId" value="<?=$reqListAreaId?>" style="width:100%" />
                                    <input autocomplete="off" required class="easyui-validatebox textbox form-control" type="text" name="reqAreaNama"  id="reqAreaNama" <?=$disabled?> value="<?=$reqAreaNama?>" style="width:100%" readonly />
                                    <input autocomplete="off" class="easyui-validatebox textbox form-control" type="hidden" name="reqAreaKode"  id="reqAreaKode" <?=$disabled?> value="<?=$reqAreaKode?>" style="width:100%" readonly />
                                </div>
                                <?/*
                                if($reqLihat == 1)
                                {}
                                else
                                {
                                ?>
                                    <div class="col-md-1">
                                        <a id="btnAdd" onclick="openArea()"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> </a>
                                    </div>
                                <?
                                }
                                */?>
                            </div>
                        </div>
                    </div> -->

      
                    <div class="form-group">  
                        <label class="control-label col-md-2">Nama Area Di Unit </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input autocomplete="off" <?=$disabled?>  class="easyui-validatebox textbox form-control" type="text" name="reqNama"  id="reqNama" value="<?=$reqNama?>"  style="width:100%"  required />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Status Confirm </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <select class="form-control jscaribasicmultiple" required id="reqTersedia" <?=$disabled?> name="reqTersedia"  style="width:15%;" >
                                     <option value="1" <? if($reqTersedia==1) echo 'selected' ?> >Ya</option>
                                     <option value="2" <? if($reqTersedia==2) echo 'selected' ?> >Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>


                    <input type="hidden" name="reqId" value="<?=$reqId?>" />
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
                    <input type="hidden" name="reqStatusKonfirmasi" id="reqStatusKonfirmasi" value="<?=$reqStatusKonfirmasi?>" />

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
            </div>
           
            <?
            }
            ?>
            
        </div>
    </div>
    
</div>

<script>
$(document).on('keydown', '#reqKode', function(e) {
    if (e.keyCode == 32) return false;
});

$('#reqDistrikId').on('change', function() {
    $("#blok").empty();
    var reqDistrikId= this.value;
    $.get("app/loadUrl/app/blok_unit_template?reqDistrikId="+reqDistrikId, function(data) { 
        // console.log(data);
        $("#blok").append(data);
        var reqBlokId= $("#reqBlokId").val();
        $("#unit").empty();
        $.get("app/loadUrl/app/unit_mesin_template?reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId, function(data) { 
            $("#unit").append(data);
        });

    });
    // console.log(reqBlokId);

   
});

$('#reqBlokId').on('change', function() {
    // console.log(1);

    $("#unit").empty();
    var reqDistrikId= $("#reqDistrikId").val();
    $.get("app/loadUrl/app/unit_mesin_template?reqDistrikId="+reqDistrikId+"&reqBlokId="+this.value, function(data) { 
        $("#unit").append(data);
    });
});


function submitForm(){

    $.messager.confirm('Konfirmasi'," Apakah data yang anda ajukan sudah benar?",function(r){
        if (r)
        {
            $('#reqStatusKonfirmasi').val(1);
            $('#ff').form('submit',
            {
                url:'json-app/area_unit_json/add',
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
    }); 
    
}

function clearForm(){
    $('#ff').form('clear');
}

function setArea(values){
    // console.log(values);
    $('#reqListAreaId').val(values.LIST_AREA_ID);
    $('#reqAreaNama').val(values.KODE_INFO+' - '+values.NAMA);
    $('#reqAreaKode').val(values.KODE_DUPLIKAT);
}

function openArea()
{
    // openAdd('iframe/index/lookup_area');
    // openAdd('app/loadUrl/app//lookup_list_area_multi');
}   
</script>