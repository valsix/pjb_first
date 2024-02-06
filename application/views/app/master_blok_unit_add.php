<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/BlokUnit");
$this->load->model("base-app/Distrik");
$this->load->model("base-app/JenisUnitKerja");


$this->load->library('libapproval');

$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");
$reqDistrikId = $this->input->get("reqDistrikId");

$set= new BlokUnit();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

    $statement = " AND BLOK_UNIT_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("BLOK_UNIT_ID");
    $reqDistrikId= $set->getField("DISTRIK_ID");
    $reqNama= $set->getField("NAMA");
    $reqJenisUnitKerjaId= $set->getField("JENIS_UNIT_KERJA_ID");
    // $reqKodeReadonly= " readonly ";
}

// print_r($reqJenisUnitKerjaId);exit;

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



$set= new JenisUnitKerja();
$arrjenis= [];
$statement="";
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

?>
<script src='assets/multifile-master/jquery.form.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MetaData.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MultiFile.js' type="text/javascript" language="javascript"></script> 
<link rel="stylesheet" href="css/gaya-multifile.css" type="text/css">

<div class="col-md-12">
    
  <div class="judul-halaman"> <a href="iframe/index/<?=$pgreturn?>?reqDistrikId=<?=$reqDistrikId?>">Data Blok Unit <?=$reqDistrikNama?></a> &rsaquo; Kelola Blok Unit</div>

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
                    <label class="control-label col-md-2">Nama</label>
                    <div class='col-md-8'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                 <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqNama"  id="reqNama" value="<?=$reqNama?>"  <?=$disabled?> data-options="required:true" style="width:100%" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">  
                    <label class="control-label col-md-2">Jenis Pembangkit</label>
                    <div class='col-md-8'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <select class="form-control jscaribasicmultiple edittext" id="reqJenisUnitKerjaId" <?=$disabled?> name="reqJenisUnitKerjaId" style="width:100%;"  >
                                    <option value="" >Pilih Jenis Unit Kerja</option>
                                    <?
                                    foreach($arrjenis as $item) 
                                    {
                                        $selectvalid= $item["id"];
                                        $selectvaltext= $item["text"];

                                        $selected="";
                                        if($selectvalid == $reqJenisUnitKerjaId)
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


                <input type="hidden" name="reqId" value="<?=$reqId?>" />
                <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
                <input type="hidden" name="reqDistrikId" value="<?=$reqDistrikId?>" />

                <input type="hidden" name="infopg" value="<?=$pg?>" />
            </form>
        </div>

        <div style="text-align:center;padding:5px">
            <?
            if(!empty($reqId))
            {
            ?>
                <!-- <a href="javascript:void(0)" class="btn btn-success" onclick="tabbaru('<?=$reqId?>','<?=$reqDistrikId?>')">Tambah/Edit Unit Mesin</a> -->
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
            <a href="javascript:void(0)" class="btn btn-success" onclick="submitForm()">Submit</a>
            <?
            }
            ?>

            <br>
            <br>
            <br>

            <?
            if(!empty($reqId))
            {
            ?>
                <iframe src="iframe/index/master_unit_mesin?reqBlokUnitId=<?=$reqId?>&reqDistrikId=<?=$reqDistrikId?>" width="100%" height="800"></iframe>
            <?
            }
            ?>
        </div>

    </div>
</div>

<script>
function editdata()
{
    varurl= "iframe/index/master_blok_unit_add?reqId=<?=$reqId?>&reqDistrikId=<?=$reqDistrikId?>";
    document.location.href = varurl;
}

function tabbaru(id,distrikid)
{
    window.open('iframe/index/master_unit_mesin?reqBlokUnitId='+id+'&reqDistrikId='+distrikid, '_blank'); 
}

function submitForm(){
    
    $('#ff').form('submit',{
        url:'json-app/blok_unit_json/add',
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
                $.messager.alertLink('Info', infoSimpan, 'info', "app/index/<?=$pgreturn?>?reqDistrikId=<?=$reqDistrikId?>");
        }
    });
}

function clearForm(){
    $('#ff').form('clear');
} 
</script>