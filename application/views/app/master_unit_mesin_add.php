<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/BlokUnit");
$this->load->model("base-app/Distrik");
$this->load->model("base-app/UnitMesin");

$this->load->library('libapproval');

$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");
$reqDistrikId = $this->input->get("reqDistrikId");
$reqBlokUnitId= $this->input->get("reqBlokUnitId");

$set= new UnitMesin();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

    $statement = " AND UNIT_MESIN_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("UNIT_MESIN_ID");
    $reqDistrikId= $set->getField("DISTRIK_ID");
    $reqBlokUnitId= $set->getField("BLOK_UNIT_ID");
    $reqNama= $set->getField("NAMA");
    // $reqKodeReadonly= " readonly ";
}

$disabled="";


if($reqLihat ==1)
{
    $disabled="disabled";  
}


$set= new Distrik();


$statement = " AND A.DISTRIK_ID = '".$reqDistrikId."' ";
$set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
$set->firstRow();

$reqDistrikNama= $set->getField("NAMA");

unset($set);


$set= new BlokUnit();

$statement = " AND BLOK_UNIT_ID = '".$reqBlokUnitId."' ";
$set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
$set->firstRow();

$reqBlokUnitNama= $set->getField("NAMA");
unset($set);


?>
<script src='assets/multifile-master/jquery.form.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MetaData.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MultiFile.js' type="text/javascript" language="javascript"></script> 
<link rel="stylesheet" href="css/gaya-multifile.css" type="text/css">

<div class="col-md-12">
    
  <div class="judul-halaman"> <a href="iframe/index/<?=$pgreturn?>?reqDistrikId=<?=$reqDistrikId?>&reqBlokUnitId=<?=$reqBlokUnitId?>">Data Unit Mesin <?=$reqBlokUnitNama?></a> &rsaquo; Kelola Unit Mesin</div>

    <div class="konten-area">
        <div class="konten-inner">
            <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">

                <div class="page-header">
                    <h3><i class="fa fa-file-text fa-lg"></i> <?=$pgtitle?></h3>       
                </div>

                <div class="form-group">  
                    <label class="control-label col-md-2">Distrik</label>
                    <div class='col-md-8'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                 <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqDistrikNama"  id="reqDistrikNama" value="<?=$reqDistrikNama?>"  disabled style="width:100%" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">  
                    <label class="control-label col-md-2">Blok Unit</label>
                    <div class='col-md-8'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                 <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqBlokUnitNama"  id="reqBlokUnitNama" value="<?=$reqBlokUnitNama?>"  disabled style="width:100%" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">  
                    <label class="control-label col-md-2">Nama</label>
                    <div class='col-md-8'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                 <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqNama"  id="reqNama" value="<?=$reqNama?>"  <?=$disabled?> data-options="required:true" style="width:100%" />
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="reqId" value="<?=$reqId?>" />
                <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
                <input type="hidden" name="reqDistrikId" value="<?=$reqDistrikId?>" />
                <input type="hidden" name="reqBlokUnitId" value="<?=$reqBlokUnitId?>" />

                <input type="hidden" name="infopg" value="<?=$pg?>" />
            </form>
        </div>
        <div style="text-align:center;padding:5px">
            <?
            if(!empty($reqId))
            {
            ?>
            <?
            }
            ?>

            <?
            if($reqLihat ==1)
            {
            ?>
            <a href="javascript:void(0)" class="btn btn-success" onclick="editdata()">Edit Data</a>
            <?
            }
            else
            {
            ?>
            <a href="javascript:void(0)" class="btn btn-warning" onclick="submitForm()">Submit</a>
            <?
            }
            ?>
        </div>
    </div>
    
</div>

<script>
function editdata()
{
    varurl= "iframe/index/master_unit_mesin_add?reqId=<?=$reqId?>&reqDistrikId=<?=$reqDistrikId?>&reqBlokUnitId=<?=$reqBlokUnitId?>";
    document.location.href = varurl;
}

function tabbaru(id,distrikid,unitid)
{
    window.open('app/index/master_sub_mesin?reqUnitMesinId='+id+'&reqDistrikId='+distrikid+'&reqBlokUnitId='+unitid, '_blank'); 
}

function submitForm(){
    
    $('#ff').form('submit',{
        url:'json-app/unit_mesin_json/add',
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
                $.messager.alertLink('Info', infoSimpan, 'info', "app/index/<?=$pgreturn?>?reqBlokUnitId=<?=$reqBlokUnitId?>&reqDistrikId=<?=$reqDistrikId?>");
        }
    });
}

function clearForm(){
    $('#ff').form('clear');
} 
</script>