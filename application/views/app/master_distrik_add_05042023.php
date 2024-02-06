<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/Distrik");
$this->load->model("base-app/Wilayah");
$this->load->model("base-app/Direktorat");
$this->load->model("base-app/PerusahaanEksternal");
$this->load->model("base-app/JenisUnitKerja");
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
    $reqJenisUnitKerjaId= $set->getField("JENIS_UNIT_KERJA_ID");
    $reqLocationId= $set->getField("LOCATION_ID");
    $reqWilayahNama= $set->getField("WILAYAH_NAMA");
    $reqNama= $set->getField("NAMA");
    $reqPerusahaanEksternalId= $set->getField("PERUSAHAAN_EKSTERNAL_ID");

    $reqDirektoratId= getmultiseparator($set->getField("DIREKTORAT_ID_INFO"));
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

$set= new JenisUnitKerja();
$arrjenis= [];
$set->selectByParams(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("JENIS_UNIT_KERJA_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrjenis, $arrdata);
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

<div class="col-md-12">
    
  <div class="judul-halaman"> <a href="app/index/<?=$pgreturn?>">Data Distrik/Unit</a> &rsaquo; Kelola Distrik/Unit</div>

    <div class="konten-area">
        <div class="konten-inner">

            <div>

                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">

                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i> <?=$pgtitle?></h3>       
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Kode Distrik</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqKode"  id="reqKode" value="<?=$reqKode?>"  <?=$disabled?> data-options="required:true" style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>
                                                                             
                    <div class="form-group">  
                        <label class="control-label col-md-2">Kode Site</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqKodeSite"  id="reqKodeSite" value="<?=$reqKodeSite?>" <?=$disabled?> data-options="required:true" style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">  
                        <label class="control-label col-md-2">Deskripsi/ Nama</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqNama"  id="reqNama" value="<?=$reqNama?>" <?=$disabled?> data-options="required:true" style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="form-group">  
                        <label class="control-label col-md-2">Wilayah</label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <input  name="reqWilayahNama" class="easyui-validatebox textbox form-control" id="reqWilayahNama" value="<?=$reqWilayahNama?>"  disabled/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="direktorat">
                        <div class="form-group">  
                            <label class="control-label col-md-2">Direktorat</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                        <textarea  class="easyui-validatebox textbox form-control"  name="reqDirektoratNama" id="reqDirektoratNama" disabled> <?=$reqDirektoratNama?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <div class="form-group">  
                        <label class="control-label col-md-2">Wilayah </label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <select class="form-control jscaribasicmultiple" id="reqWilayahId" <?=$disabled?> name="reqWilayahId" style="width:100%;" >
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
                        <label class="control-label col-md-2">Direktorat </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <select class="form-control jscaribasicmultiple" id="reqDirektoratId" <?=$disabled?> name="reqDirektoratId[]" multiple style="width:100%;" >
                                        <?
                                        foreach($arrdirektorat as $item) 
                                        {
                                            $selectvalid= $item["id"];
                                            $selectvaltext= $item["text"];

                                            $selected="";
                                            if(in_array($selectvalid, $reqDirektoratId))
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
                        <label class="control-label col-md-2">Perusahaan Eksternal </label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <select class="form-control jscaribasicmultiple" id="reqPerusahaanEksternalId" <?=$disabled?> name="reqPerusahaanEksternalId" style="width:100%;" >
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
                        <label class="control-label col-md-2">Jenis Unit Kerja</label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <select class="form-control jscaribasicmultiple" id="reqJenisUnitKerjaId" <?=$disabled?> name="reqJenisUnitKerjaId" style="width:100%;" >
                                    <option value="" >Pilih Jenis Unit Kerja</option>
                                        <?
                                        foreach($arrjenis as $item) 
                                        {
                                            $selectvalid= $item["id"];
                                            $selectvaltext= $item["text"];

                                            $selected="";
                                            if($selectvalid==$reqJenisUnitKerjaId)
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
            </div>

                    <input type="hidden" name="reqId" value="<?=$reqId?>" />
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>" />

                    <input type="hidden" name="infopg" value="<?=$pg?>" />
                   

                </form>

            </div>
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
                    <a href="javascript:void(0)" class="btn btn-success" onclick="blokunit('<?=$reqId?>')">Tambah/Edit Unit</a>
                <?
                }
                ?>
                <a href="javascript:void(0)" class="btn btn-primary" onclick="submitForm()">Submit</a>
            </div>
            <?
            }
            ?>

        </div>
    </div>
    
</div>

<script>

function blokunit(id)
{
    window.open('app/index/master_blok_unit?reqDistrikId='+id, '_blank'); 
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
            // console.log(data);
            // return false;

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

function clearForm(){
    $('#ff').form('clear');
} 
</script>