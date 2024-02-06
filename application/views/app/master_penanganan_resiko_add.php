<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/PenangananRisiko");
$this->load->model("base-app/Risiko");


$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");


$set= new PenangananRisiko();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

	$statement = " AND A.PENANGANAN_RISIKO_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("PENANGANAN_RISIKO_ID");
    $reqWarna= $set->getField("KODE_WARNA");
    $reqRisikoId= $set->getField("RISIKO_ID");
}

$disabled="";

if($reqLihat ==1)
{
    $disabled="disabled";  
}


$set= new Risiko();
$arrRisiko= [];

if($reqId == "")
{
     $statement=" AND A.STATUS IS NULL AND NOT EXISTS(SELECT B.RISIKO_ID FROM PENANGANAN_RISIKO B WHERE A.RISIKO_ID=B.RISIKO_ID) ";
}
else
{
    $statement=" AND A.STATUS IS NULL ";
}

$set->selectByParams(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("RISIKO_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrRisiko, $arrdata);
}
unset($set);

$arrColorPicker=colorpicker();
// print_r($arrColorPicker);exit;

?>

<script src='assets/multifile-master/jquery.form.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MetaData.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MultiFile.js' type="text/javascript" language="javascript"></script> 
<link rel="stylesheet" href="css/gaya-multifile.css" type="text/css">

 <!--warna-->
 <script src="lib/colorpicker/jquery.colourPicker.js" type="text/javascript"></script>
 <link href="lib/colorpicker/jquery.colourPicker.css" rel="stylesheet" type="text/css">

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


.custom .colorpicker-saturation {
width: 110px;
height: 200px;
}
.custom .colorpicker-hue,
.custom .colorpicker-alpha {
width: 20px;
height: 200px;
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
                        <label class="control-label col-md-2">Risiko </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <select class="form-control jscaribasicmultiple"  id="reqRisikoId" <?=$disabled?> name="reqRisikoId"  style="width:100%;" >
                                         <option value="" >Pilih Risiko</option>
                                        <?
                                        foreach($arrRisiko as $item) 
                                        {
                                            $selectvalid= $item["id"];
                                            $selectvaltext= $item["text"];

                                            $selected="";
                                            if($selectvalid == $reqRisikoId)
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
                        <label class="control-label col-md-2">Kode Warna </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <div id="jquery-colour-picker-example">
                                        <select name="reqWarna">
                                            <?
                                            foreach ($arrColorPicker as $key => $value) 
                                            {
                                            ?>
                                                <option value="<?=$value?>" <? if ($reqWarna == $value) echo 'selected' ?>>#<?=$value?></option>   
                                            <?
                                            }
                                            ?>
                                            
                                        </select>
                                    </div> 
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
$(document).ready(function(){ jQuery('select[name="reqWarna"]').colourPicker({ ico:    'lib/colorpicker/jquery.colourPicker.gif',  title:    false });});

$(document).on('keydown', '#reqKode', function(e) {
    if (e.keyCode == 32) return false;
});
function submitForm(){
    
    $('#ff').form('submit',{
        url:'json-app/penanganan_risiko_json/add',
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
</script>