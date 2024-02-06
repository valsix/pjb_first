<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/Distrik");
$this->load->model("base-app/Wilayah");
$this->load->model("base-app/Direktorat");
$this->load->model("base-app/PerusahaanEksternal");
$this->load->model("base-app/Location");
$this->load->library('libapproval');

$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");

$set= new Distrik();
if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

	$statement = " AND A.DISTRIK_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("DISTRIK_ID");
    $reqKodeSite= $set->getField("KODE_SITE");
    $reqKode= $set->getField("KODE");
    $reqWilayahId= $set->getField("WILAYAH_ID");
    // $reqJenisUnitKerjaId= $set->getField("JENIS_UNIT_KERJA_ID");
    $reqLocationId= $set->getField("LOCATION_ID");
    $reqWilayahNama= $set->getField("WILAYAH_NAMA");
    $reqNama= $set->getField("NAMA");
    $reqPerusahaanEksternalId= $set->getField("PERUSAHAAN_EKSTERNAL_ID");

    // print_r($reqPerusahaanEksternalId);exit;

    $reqDirektoratId= $set->getField("DIREKTORAT_ID");
    $reqJenisUnitKerjaId= getmultiseparator($set->getField("JENIS_UNIT_KERJA_ID_INFO"));

    // var_dump($reqKode);
    // $reqKodeReadonly= " readonly ";
}

$set= new Wilayah();
$arrwilayah= [];

$statement=" AND A.STATUS IS NULL";
$set->selectByParams(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("WILAYAH_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrwilayah, $arrdata);
}
unset($set);


$set= new Location();
$arrlocation= [];
$set->selectByParams(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("LOCATION_ID");
    $arrdata["text"]= $set->getField("LOCATION_NAMA");
    array_push($arrlocation, $arrdata);
}
unset($set);


$set= new Direktorat();
$arrdirektorat= [];

$statement=" AND A.STATUS IS NULL";
$set->selectByParams(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("DIREKTORAT_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrdirektorat, $arrdata);
}
unset($set);

$set= new PerusahaanEksternal();
$arrperusahaan= [];

$statement=" AND A.STATUS IS NULL";
$set->selectByParams(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("PERUSAHAAN_EKSTERNAL_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrperusahaan, $arrdata);
}
unset($set);


// $set= new Distrik();
// $arrdirektorat= [];
// $statement = " AND A.DISTRIK_ID = '".$reqId."' ";
// $set->selectByParamsDirektorat(array(), -1,-1,$statement);
// // echo $set->query;exit;
// while($set->nextRow())
// {
//     array_push($arrdirektorat, $set->getField("DIREKTORAT_NAMA"));
// }
// unset($set);

// $reqDirektoratNama = implode (", ", $arrdirektorat);

// print_r($reqDirektoratNama);exit;

$disabled="";


if($reqLihat ==1)
{
    $disabled="disabled";  
}


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

<div class="col-md-12" >
    
    <div class="judul-halaman"> <a href="app/index/<?=$pgreturn?>">Data Distrik/Unit</a> &rsaquo; Kelola Distrik/Unit</div>

    <div class="konten-area">
        <div class="konten-inner" >

            <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">

                <div class="page-header">
                    <h3><i class="fa fa-file-text fa-lg"></i> <?=$pgtitle?></h3>       
                </div>

                <div class="form-group">  
                    <label class="control-label col-md-2">Perusahaan  </label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <select class="form-control jscaribasicmultiple edittext" id="reqPerusahaanEksternalId" <?=$disabled?> name="reqPerusahaanEksternalId" style="width:100%;" >
                                <option value="" >Pilih Perusahaan</option>
                                    <?
                                    foreach($arrperusahaan as $item) 
                                    {
                                        $selectvalid= $item["id"];
                                        $selectvaltext= $item["text"];

                                        $selected="";
                                        if($selectvalid==$reqPerusahaanEksternalId)
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
                    <label class="control-label col-md-2">Direktorat </label>
                    <div class='col-md-8'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <select class="form-control jscaribasicmultiple edittext" id="reqDirektoratId" <?=$disabled?> name="reqDirektoratId"  style="width:100%;" >
                                    <?
                                    foreach($arrdirektorat as $item) 
                                    {
                                        $selectvalid= $item["id"];
                                        $selectvaltext= $item["text"];

                                        $selected="";
                                        if($selectvalid==$reqDirektoratId)
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
                    <label class="control-label col-md-2">Wilayah </label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <select class="form-control jscaribasicmultiple edittext" id="reqWilayahId" <?=$disabled?> name="reqWilayahId" style="width:100%;" >
                                <option value="" >Pilih Wilayah</option>
                                    <?
                                    foreach($arrwilayah as $item) 
                                    {
                                        $selectvalid= $item["id"];
                                        $selectvaltext= $item["text"];

                                        $selected="";
                                        if($selectvalid==$reqWilayahId)
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
                    <label class="control-label col-md-2">Kode Distrik</label>
                    <div class='col-md-8'>
                        <div class='form-group'>
                            <div class='col-md-8' id="kode_distrik">
                                 <input autocomplete="off"   placeholder="Kode Harus diisi" class="easyui-validatebox textbox form-control edittext" type="text" name="reqKode"  id="reqKode" value="<?=$reqKode?>"  <?=$disabled?> data-options="required:true" style="width:90%" />
                                 
                            </div>
                        </div>
                    </div>
                </div>
                                                                         
                <div class="form-group">  
                    <label class="control-label col-md-2">Kode Site</label>
                    <div class='col-md-8'>
                        <div class='form-group'>
                            <div class='col-md-8'>
                                 <input autocomplete="off"  class="easyui-validatebox textbox form-control edittext" type="text" name="reqKodeSite"  id="reqKodeSite" readonly value="<?=$reqKodeSite?>" <?=$disabled?> data-options="required:true" style="width:90%" />
                                 <a id="btnArea" onclick="openArea()"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">  
                    <label class="control-label col-md-2">Nama Unit</label>
                    <div class='col-md-8'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                 <input autocomplete="off" readonly class="easyui-validatebox textbox form-control edittext" type="text" name="reqNama"  id="reqNama" value="<?=$reqNama?>" <?=$disabled?>  style="width:100%" />
                            </div>
                        </div>
                    </div>
                </div>
      

               
                
                <!--  <div class="form-group">  
                    <label class="control-label col-md-2">Location</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <select class="form-control jscaribasicmultiple" id="reqLocationId" <?=$disabled?> name="reqLocationId" style="width:100%;" >
                                <option value="" >Pilih Location</option>
                                    <?/*
                                    foreach($arrlocation as $item) 
                                    {
                                        $selectvalid= $item["id"];
                                        $selectvaltext= $item["text"];

                                        $selected="";
                                        if($selectvalid==$reqLocationId)
                                        {
                                            $selected="selected";
                                        }
                                        ?>
                                        <option value="<?=$selectvalid?>" <?=$selected?>><?=$selectvaltext?></option>
                                        <?
                                    }
                                    */?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div> -->

                <input type="hidden" name="reqId" value="<?=$reqId?>" />
                <input type="hidden" name="reqMode" value="<?=$reqMode?>" />

                <input type="hidden" name="infopg" value="<?=$pg?>" />

                <!-- untuk tambah sub menu -->
                <div id="tabelblokunit">
                    <a href="javascript:void(0)" class="btn btn-primary" id="tambahunit" onclick="blokunittambah()">Add Blok/Unit</a>
                </div>

            </form>
            <?
            if($reqLihat ==1)
            {}
            else
            {
            ?>
            <div style="text-align:center;padding:5px">
                <?
                if(!empty($reqId))
                {
                ?>
                    <!-- <a href="javascript:void(0)" class="btn btn-success" onclick="blokunit('<?=$reqId?>')">Tambah/Edit Unit</a> -->
                <?
                }
                ?>
                <a href="javascript:void(0)" class="btn btn-primary" id="reqSimpan"  onclick="submitForm()">Submit</a>
                <a href="javascript:void(0)" class="btn btn-success" id='editform' onclick="editform()">Edit Form</a>
                <a href="javascript:void(0)" class="btn btn-success" id='tutupform' onclick="tutupform()">Tutup Form</a>

                <br>
                <br>
                <br>

                <?
                if(!empty($reqId))
                {
                ?>
                    <iframe src="iframe/index/master_blok_unit?reqDistrikId=<?=$reqId?>" width="100%" height="800"></iframe>
                <?
                }
                ?>
            </div>
            <?
            }
            ?>

        </div>
    </div>
    
</div>

<script>
$(function(){
  $(".edittext").attr("disabled", true);
});

function openArea()
{
    openAdd('iframe/index/lookup_kode_distrik?reqId=<?=$reqId?>&reqUniqId=<?=$reqUniqId?>');
}

$("#reqSimpan").hide();
$("#tutupform").hide();
$("#tambahformulir").hide();
$("#deleteformulir").hide();
$("#tambahunit").hide();
$("#btnArea").hide();

function editform()
{
    $(".edittext").attr("disabled", false);
    $("#reqSimpan").show();
    $("#tutupform").show();
    $("#editform").hide();
    $("#tambahformulir").show();
    $("#tambahunit").show();
    $("#btnArea").show();

}

function tutupform()
{
    $(".edittext").attr("disabled", true);
    $("#reqSimpan").hide();
    $("#tutupform").hide();
    $("#editform").show();
    $("#tambahformulir").hide();
    $("#tambahunit").hide();
    $("#btnArea").hide();
}


const uniqblokunit = (() => {
    let i = 0;
    return () => {
        return i++;
    }
})();

function blokunittambah() {
    $.get("app/loadUrl/app/master_distrik_add_blokunit?reqId=<?=$reqId?>&reqUniqId="+uniqblokunit(), function(data) { 
        $("#tabelblokunit").append(data);
        $('.itemblokunit').validatebox({required: true});
    });
}

function blokunithapus(infoid) {
    $("#itemblokunit"+infoid).remove();
}

const uniqunitmesin = (() => {
    let i = 0;
    return () => {
        return i++;
    }
})();

function unitmesintambah(infoid) {
    $.get("app/loadUrl/app/master_distrik_add_unitmesin?reqId=<?=$reqId?>&reqUniqId="+infoid+"&reqUniqMesinId="+uniqunitmesin(), function(data) { 
        $("#itemunitmesinblok"+infoid).append(data);
        $('.itemblokunit').validatebox({required: true});
    });
}

function unitmesinhapus(infoid) {
    $(".infogroupunitmesin"+infoid).remove();
    // $('.infogroupunitmesin:last').remove();
}

function blokunit(id)
{
    window.open('iframe/index/master_blok_unit?reqDistrikId='+id, '_blank'); 
}

$(document).on('keydown', '#reqKode', function(e) {
    if (e.keyCode == 32) return false;
});

// var dirnama= "<?=$reqDirektoratNama?>";

// // console.log(dirnama);

// if(dirnama=="")
// {
//     $('#direktorat').hide();
// }

// $('#reqWilayahId').on('change', function() {
//   $.ajax({
//     url : 'json-app/combo_json/combodirektoratwilayah?reqWilayahId='+this.value,
//     type : 'GET',
//     dataType:'json',
//     success : function(data) {         
//     data.forEach(function(e) {
//         // console.log(e.text);
//         if(e.id !="")
//         {
//             $('#direktorat').show();
//             $('#reqDirektoratNama').val(e.text);
//         }
//         else
//         {
//             $('#direktorat').hide();
//         }
//     });              
//     }
// });

// });

function setArea(values){
    // $('#myTable tr:last').after('<tr><td>'+someValue+'</td><td>New Row</td><td>New Row</td></tr>');
    // console.log(values);
    $('#reqKodeSite').val(values.KODE_UNIT);
    $('#reqNama').val(values.UNIT);
} 


function submitForm(){
    
    $('#ff').form('submit',{
        url:'json-app/distrik_json/add',
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