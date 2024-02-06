<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/StandarReferensi");

$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");


$set= new StandarReferensi();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

	$statement = " AND STANDAR_REFERENSI_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("STANDAR_REFERENSI_ID");
    $reqNama= $set->getField("NAMA");
    $reqNomor= $set->getField("NOMOR");
    $reqKlausul= $set->getField("KLAUSUL");
    $reqTahun= $set->getField("TAHUN");
    $reqDeskripsi= $set->getField("DESKRIPSI");
    $reqKode= $set->getField("KODE");
    $reqBab= $set->getField("BAB");

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
                        <label class="control-label col-md-2">Kode </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <input autocomplete="off" disabled class="easyui-validatebox textbox form-control" type="text" name="reqKode"  id="reqKode" value="<?=$reqKode?>" <?=$disabled?>  style="width:100%" />
                               </div>
                           </div>
                       </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Institusi </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input autocomplete="off" <?=$disabled?>  class="easyui-validatebox textbox form-control" type="text" name="reqNama"  id="reqNama" value="<?=$reqNama?>" data-options="required:true"  style="width:100%"  />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Nomor </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input autocomplete="off" <?=$disabled?>  class="easyui-validatebox textbox form-control" type="text" name="reqNomor"  id="reqNomor" value="<?=$reqNomor?>" data-options="required:true"  style="width:100%"  />
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="form-group">  
                        <label class="control-label col-md-2">Tahun Terbit </label>
                        <div class='col-md-2'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input autocomplete="off" <?=$disabled?>  class="easyui-validatebox textbox form-control" type="text" name="reqTahun" id="reqTahun" value="<?=$reqTahun?>" data-options="required:true" maxlength='4'  style="width:100%"  />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Bab </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input autocomplete="off" <?=$disabled?>  class="easyui-validatebox textbox form-control" type="text" name="reqBab"  id="reqBab" value="<?=$reqBab?>" data-options="required:true"  style="width:100%"  />
                                </div>
                            </div>
                        </div>
                    </div>

       

                   <!--  <div class="form-group">  
                        <label class="control-label col-md-2">Klausul </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <textarea name="reqKlausul" class="easyui-validatebox textbox form-control"><?=$reqKlausul?></textarea>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <div class="form-group">  
                        <label class="control-label col-md-2">Deskripsi </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <textarea name="reqDeskripsi" class="easyui-validatebox textbox form-control"><?=$reqDeskripsi?></textarea>
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


$(document).on('keydown', '#reqKode', function(e) {
    if (e.keyCode == 32) return false;
});

$("#reqTahun").on("input", function(evt) {
   var self = $(this);
   self.val(self.val().replace(/[^0-9]/g, ''));
   if ((evt.which != 46 ) && (evt.which < 48 || evt.which > 57)) 
   {
     evt.preventDefault();
   }
});


function submitForm(){
    
    $('#ff').form('submit',{
        url:'json-app/standar_referensi_json/add',
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