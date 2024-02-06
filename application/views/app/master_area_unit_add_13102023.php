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
$reqDistrikId = $this->input->get("reqDistrikId");
$reqBlokId = $this->input->get("reqBlok");
$reqUnitMesinId = $this->input->get("reqUnitMesin");

$this->load->model("base-app/UnitMesin");


$set= new AreaUnit();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

	$statement = " AND A.AREA_UNIT_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("AREA_UNIT_ID");
    $reqNama= $set->getField("NAMA");
    $reqKode= $set->getField("KODE");

    $reqDistrikId= $set->getField("DISTRIK_ID");
    $reqListAreaIdDetil= $set->getField("LIST_AREA_ID_INFO");
    $reqListAreaId= getmultiseparator($set->getField("LIST_AREA_ID_INFO"));
    $jumlaharea = count($reqListAreaId);

    $reqTersedia= $set->getField("TERSEDIA");
    $reqStatusKonfirmasi= $set->getField("STATUS_KONFIRMASI");
    $reqBlokId= $set->getField("BLOK_UNIT_ID");
    $reqUnitMesinId= $set->getField("UNIT_MESIN_ID");

    $reqAreaNama= $set->getField("KODE_INFO");
    $reqAreaKode= $set->getField("KODE_DUPLIKAT");

  

    $set= new ListArea();
    $arrlist= [];

    if(!empty($reqListAreaIdDetil))
    {

        $statement=" AND A.STATUS IS NULL 
        AND A.LIST_AREA_ID IN ( ".$reqListAreaIdDetil.") ";
        $set->selectByParams(array(), -1,-1,$statement);
        // echo $set->query;exit;
        while($set->nextRow())
        {
            $arrdata= array();
            $arrdata["id"]= $set->getField("LIST_AREA_ID");
            $arrdata["text"]=$set->getField("NAMA");
            array_push($arrlist, $arrdata);
        }
        unset($set);
    }


    // print_r($arrlist);exit;


}


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

$set= new ListArea();
$arrarea= [];

$statement=" AND  EXISTS (SELECT LIST_AREA_ID FROM ITEM_ASSESSMENT B  WHERE A.LIST_AREA_ID = B.LIST_AREA_ID ) AND A.STATUS IS NULL  AND A.LIST_AREA_ID IN  
(
SELECT LIST_AREA_ID FROM ITEM_ASSESSMENT_DUPLIKAT
) ";
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
                                    <select class="form-control jscaribasicmultiple" readonly required id="reqDistrikId" <?=$disabled?> name="reqDistrikId"  style="width:100%;" >
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
                                <select class="form-control jscaribasicmultiple" readonly id="reqBlokId" <?=$disabled?> name="reqBlokId"  style="width:100%;" >
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
                       
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">UNIT MESIN </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'  id="unit">
                                    <select class="form-control jscaribasicmultiple" readonly  id="reqUnitMesinId" <?=$disabled?> name="reqUnitMesinId"  style="width:100%;" >
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
                                            if( in_array($selectvalid, $reqListAreaId))
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


                    <!-- <div class="form-group">  
                        <label class="control-label col-md-2">Nama Area Di Unit </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input autocomplete="off" <?=$disabled?>  class="easyui-validatebox textbox form-control" type="text" name="reqNama"  id="reqNama" value="<?=$reqNama?>"  style="width:100%"  required />
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- <div class="form-group">  
                        <label class="control-label col-md-2">Status Confirm </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    
                               </div>
                           </div>
                       </div>
                    </div> -->

                    <div class="form-group">  
                        <label class="control-label col-md-2">Ubah Semua Status </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <select class="form-control jscaribasicmultiple" required id="reqUbahStatus" <?=$disabled?>  style="width: 20%;" >
                                     <option value="" >Pilih Status</option>
                                     <option value="1" >Aktif</option>
                                     <option value="0" >Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?
                    if(!empty($reqId) && !empty($reqListAreaIdDetil))
                    {
                    ?>
                        <div class="form-group">  
                            <label class="control-label col-md-2">Import Area di Unit </label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                        <div id="bluemenu" class="aksi-area" style="padding:0px;border-bottom:0px">
                                           <span><a id="btnImport"><i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i> Import</a></span>
                                       </div>
                                   </div>
                                </div>
                            </div>
                        </div>
                    <?
                    }
                    ?>

                    <div id="tabelareaunit">

                        <?
                        foreach($arrlist as $itemlist) 
                        {
                           $listareaid= $itemlist["id"];
                           $selectvaltext= $itemlist["text"];
                        ?>
                            <div id="detil-<?=$listareaid?>" >
                                <div class="page-header headerarea" style="background-color: green" id="detil-header-<?=$listareaid?>">
                                    <h3><i class="fa fa-file-text fa-lg"></i> <?=$selectvaltext?></h3>       
                                </div>

                                 

                                <div id="tabel-detil-header-<?=$listareaid?>">
                                    <table class="table table-bordered table-striped table-hovered" >
                                        <thead>
                                            <tr>
                                                <th style="vertical-align : middle;text-align:center;">List Area</th>
                                                <th style="vertical-align : middle;text-align:center;">Nama Area Di Unit</th>
                                                <th style="vertical-align : middle;text-align:center;width: 20%">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?

                                            $set= new ListArea();
                                            $arrset= [];

                                            $statement=" AND A.STATUS IS NULL AND A.LIST_AREA_ID =  ".$listareaid." AND B.AREA_UNIT_ID =  ".$reqId."";
                                            $set->selectduplikat(array(), -1,-1,$statement);
                                            // echo $set->query;
                                            while($set->nextRow())
                                            {
                                                $arrdata= array();
                                                $arrdata["id"]= $set->getField("LIST_AREA_ID");
                                                $arrdata["text"]=$set->getField("KODE_INFO")." - ".$set->getField("NAMA");
                                                $arrdata["ITEM_ASSESSMENT_DUPLIKAT_ID"]= $set->getField("ITEM_ASSESSMENT_DUPLIKAT_ID");
                                                $arrdata["AREA_UNIT"]= $set->getField("AREA_UNIT");
                                                $arrdata["STATUS_CONFIRM"]= $set->getField("STATUS_CONFIRM");
                                                array_push($arrset, $arrdata);
                                            }
                                            unset($set);
                                     
                                            foreach($arrset as $item) 
                                            {
                                                $selectvalid= $item["id"];
                                                $selectvaltext= $item["text"];
                                                $selectvaliddetil= $item["ITEM_ASSESSMENT_DUPLIKAT_ID"];
                                                $selectvalareaunit= $item["AREA_UNIT"];
                                                $status_confirm= $item["STATUS_CONFIRM"];

                                            ?>
                                                <tr>
                                                    <td style="display: none"> <input type="hidden" name="iddetil[]" value="<?=$selectvaliddetil?>"> 
                                                        <input type="hidden" name="reqListAreaIdDetil[]" value="<?=$listareaid?>"></td>
                                                    <td style="vertical-align : middle;text-align:center;">  <?=$selectvaltext?></td>
                                                    <td style="vertical-align : middle;text-align:center;"> 
                                                        <input autocomplete="off" <?=$disabled?>  class="easyui-validatebox textbox form-control" type="text" name="reqNamaUnit[]"  id="reqNamaUnit" value="<?=$selectvalareaunit?>"  style="width:100%"   /> 
                                                    </td>
                                                    <td > 
                                                        <select class="form-control jscaribasicmultiple cobaselect" required id="reqStatusConfirm" <?=$disabled?> name="reqStatusConfirm[]"  style="width: 50%;" >
                                                           <option value="0" <? if($status_confirm=="0") echo 'selected' ?> >Tidak Aktif</option>
                                                           <option value="1" <? if($status_confirm=="1") echo 'selected' ?> >Aktif</option>
                                                          
                                                       </select> 
                                                    </td>
                                                </tr>
                                            <?
                                            }
                                            ?>
                                       </tbody>
                                    </table>
                                </div>
                             </div>
                        <?
                        }
                        ?>

                    </div>

                    <input type="hidden" name="reqId" value="<?=$reqId?>" />
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
                    <input type="hidden" name="reqStatusKonfirmasi" id="reqStatusKonfirmasi" value="<?=$reqStatusKonfirmasi?>" />
                    <input type="hidden"  id="reqCheckArea" value="" />

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


$(".headerarea").click(function () {
    var bidValue = this.id;
    // console.log(bidValue);
    $('#tabel-'+bidValue).slideToggle(100);
});

$('#reqUbahStatus').on('change', function() {
    if(this.value!=="")
    {
        $(".cobaselect").val(this.value).change();
    }
    
});

$(document).on('keydown', '#reqKode', function(e) {
    if (e.keyCode == 32) return false;
});
var changearea="";
$('#reqListAreaId').on('select2:selecting', function(e) {
    var idarea= e.params.args.data.id;
    changearea=1;
    // console.log(idarea);
    $.get("app/loadUrl/app/master_area_unit_add_detil?reqListAreaId="+idarea+"&reqId=<?=$reqId?>", function(data) {
        $("#tabelareaunit").append(data);
    });
});


$('#reqListAreaId').on("select2:unselecting", function(e){
       changearea=1;
       var value = e.params.args.data.id;
       var keterangan = e.params.args.data.text;
       var ids = $('[id=detil-' + value + ']');
       var reqId='<?=$reqId?>';

       if(reqId=="")
       {
            $.getJSON("json-app/area_unit_json/deletedetil/?reqListAreaId="+value+"&reqId=<?=$reqId?>",
            function(data)
            {
                ids.remove();
            });
       }
       else
       {
            $.messager.confirm('Konfirmasi',"Hapus data terpilih?",function(r){
                if (r){
                    $.getJSON("json-app/area_unit_json/deletedetil/?reqListAreaId="+value+"&reqId=<?=$reqId?>",
                        function(data){
                            // console.log(data);return false;
                            if(data==null || data=="" )
                            {
                                ids.remove();
                            }
                            else
                            {
                                $.messager.alert('Info', data.PESAN, 'info');
                                ids.remove();
                            }
                        });
                }
                else
                {
                    location.reload();
                }
            });    
       }
        
}).trigger('change');

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

$('#btnImport').on('click', function () {
    if(changearea==1)
    {
        $.messager.alert('Info', "Simpan data terlebih dahulu.", 'warning');
            return false;
    }    
    openAdd("app/index/master_area_unit_import?reqId=<?=$reqId?>&reqDistrikId=<?=$reqDistrikId?>&reqBlok=<?=$reqBlokId?>&reqUnitMesin=<?=$reqUnitMesinId?>&reqJumlahArea=<?=$jumlaharea?>");
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
                        $.messager.alertLink('Info', infoSimpan, 'info', "app/index/<?=$pgreturn?>");
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