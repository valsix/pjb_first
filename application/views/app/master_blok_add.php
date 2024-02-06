<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/Blok");

$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");


$set= new Blok();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

	$statement = " AND BLOK_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("BLOK_ID");
    $reqDistrikId= $set->getField("DISTRIK_ID");
    $reqNama= $set->getField("NAMA");
    $reqKode= $set->getField("KODE");
    // $reqJenis= $set->getField("JENIS_ENTERPRISE");
    // $reqUrl= $set->getField("URL");
    $reqEamId= $set->getField("EAM_ID");
    $reqEamNama= $set->getField("EAM_NAMA");
    $reqEamUrl= $set->getField("EAM_URL");
    // $reqKodeReadonly= " readonly ";
}

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
                        <label class="control-label col-md-2">Kode Distrik</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input  name="reqDistrikId" class="easyui-combobox form-control" id="reqDistrikId"
                                    data-options="width:'300',editable:false,valueField:'id',textField:'text',url:'json-app/combo_json/combodistrik'" value="<?=$reqDistrikId?>" required <?=$disabled?> />
                                </div>
                            </div>
                        </div>
                    </div>
                  
                    <div class="form-group">  
                        <label class="control-label col-md-2">Kode Blok / Entitas </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqKode"  id="reqKode" value="<?=$reqKode?>" data-options="required:true" style="width:100%" <?=$disabled?> />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Nama Blok / Entitas </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqNama"  id="reqNama" value="<?=$reqNama?>" data-options="required:true" style="width:100%" <?=$disabled?> />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Jenis Enterprise Asset Management </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input type="hidden" name="reqEamId" id="reqEamId" value="<?=$reqEamId?>" style="width:100%" />
                                    <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqEamNama"  id="reqEamNama" <?=$disabled?> value="<?=$reqEamNama?>" style="width:100%" readonly />
                                </div>
                                <?
                                if($reqLihat == 1)
                                {}
                                else
                                {
                                ?>
                                    <div class="col-md-1">
                                        <a id="btnAdd" onclick="openEam()"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> </a>
                                    </div>
                                <?
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">URL Web Service </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqEamUrl"  id="reqEamUrl" <?=$disabled?> value="<?=$reqEamUrl?>" style="width:100%" readonly />
                                </div>
                            </div>
                        </div>
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

            </div>
            <?
            }
            ?>
            
        </div>
    </div>
    
</div>

<script>
function submitForm(){
    
    $('#ff').form('submit',{
        url:'json-app/blok_json/add',
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

function clearForm(){
    $('#ff').form('clear');
}   

function openEam()
{
    openAdd('app/index/lookup_eam');
}

function setEam(values)
{
    console.log(values);

    $('#reqEamId').val(values.EAM_ID);
    $('#reqEamNama').val(values.NAMA);
    $('#reqEamUrl').val(values.URL);
}
</script>