<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/MatriksRisiko");
$this->load->model("base-app/Peraturan");


$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");


$set= new MatriksRisiko();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

	$statement = " AND MATRIKS_RISIKO_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("MATRIKS_RISIKO_ID");
    $reqRisikoId= $set->getField("RISIKO_ID");
    $reqDampakId= $set->getField("DAMPAK_ID");
    $reqKemungkinanId= $set->getField("KEMUNGKINAN_ID");
    $reqLinkFile= $set->getField("LINK_FILE");
    $reqKode= $set->getField("KODE");
    $reqPeraturanId= $set->getField("PERATURAN_ID");
    $reqNmin= $set->getField("N_MIN");
    $reqNmax= $set->getField("N_MAX");


    // $reqKodeReadonly= " readonly ";
}

$disabled="";

if($reqLihat ==1)
{
    $disabled="disabled";  
}


$set= new Peraturan();
$arrperaturan= [];

$statement=" AND A.STATUS IS NULL ";
$set->selectByParams(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("PERATURAN_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrperaturan, $arrdata);
}
unset($set);



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


                    <div class="form-group" style="display: none">  
                        <label class="control-label col-md-2">Peraturan </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <select class="form-control jscaribasicmultiple"  id="reqPeraturanId" <?=$disabled?> name="reqPeraturanId"  style="width:100%;" >
                                         <option value="" >Pilih Peraturan</option>
                                        <?
                                        foreach($arrperaturan as $item) 
                                        {
                                            $selectvalid= $item["id"];
                                            $selectvaltext= $item["text"];

                                            $selected="";
                                            if($selectvalid == $reqPeraturanId)
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
                        <label class="control-label col-md-2">Kode </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <input autocomplete="off" placeholder="Kode Harus unik dan tidak boleh ada spasi" class="easyui-validatebox textbox form-control" type="text" name="reqKode"  id="reqKode" value="<?=$reqKode?>" <?=$disabled?> data-options="required:true" style="width:100%" />
                               </div>
                           </div>
                       </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Risiko </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input  name="reqRisikoId" class="easyui-combobox form-control" id="reqRisikoId"
                                    data-options="width:'300',editable:false,valueField:'id',textField:'text',url:'json-app/combo_json/comborisiko'" value="<?=$reqRisikoId?>"   <?=$disabled?>/>
                                </div>
                            </div>
                        </div>
                    </div>
                                                                             
                    <div class="form-group">  
                        <label class="control-label col-md-2">Dampak </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input  name="reqDampakId" class="easyui-combobox form-control" id="reqDampakId"
                                    data-options="width:'300',editable:false,valueField:'id',textField:'text',url:'json-app/combo_json/combodampak'" value="<?=$reqDampakId?>"   <?=$disabled?>/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Kemungkinan </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input  name="reqKemungkinanId" class="easyui-combobox form-control" id="reqKemungkinanId"
                                    data-options="width:'300',editable:false,valueField:'id',textField:'text',url:'json-app/combo_json/combokemungkinan'" value="<?=$reqKemungkinanId?>"   <?=$disabled?>/>
                                </div>
                            </div>
                        </div>
                    </div>

                   <!--  <div class="form-group">  
                        <label class="control-label col-md-2">Mix </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input autocomplete="off" <?=$disabled?>  class="easyui-validatebox textbox form-control" type="text" name="reqNmin"  id="reqNmin" value="<?=$reqNmin?>"  style="width:100%"  />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Max </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input autocomplete="off" <?=$disabled?>  class="easyui-validatebox textbox form-control" type="text" name="reqNmax"  id="reqNmax" value="<?=$reqNmax?>"  style="width:100%"  />
                                </div>
                            </div>
                        </div>
                    </div> -->

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

$(document).on('keydown', '#reqKode', function(e) {
    if (e.keyCode == 32) return false;
});
function submitForm(){
    
    $('#ff').form('submit',{
        url:'json-app/matriks_risiko_json/add',
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