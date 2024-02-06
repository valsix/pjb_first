<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/Pengguna");
$this->load->model("base-app/RoleApproval");
$this->load->model("base-app/MasterJabatan");



$pgreturn= str_replace("_reset", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");


$set= new Pengguna();

if($reqId == "")
{
    $reqMode = "insert";
    $reqExpiredDate=date('d-m-Y', strtotime('+1 year'));
}
else
{
    $reqMode = "update";

	$statement = " AND A.PENGGUNA_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("PENGGUNA_ID");
    $reqUsername= $set->getField("USERNAME");
    $reqNama= $set->getField("NAMA");
   
    // $reqKodeReadonly= " readonly ";
}



$disabled="disabled";  



?>

<script src='assets/multifile-master/jquery.form.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MetaData.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MultiFile.js' type="text/javascript" language="javascript"></script> 
<link rel="stylesheet" href="css/gaya-multifile.css" type="text/css">

<div class="col-md-12">
    
  <div class="judul-halaman"> <a href="app/index/<?=$pgreturn?>">Data <?=$pgtitle?></a> &rsaquo; Reset Password Pengguna</div>

    <div class="konten-area">
        <div class="konten-inner">

            <div>

                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">

                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i>  Reset Password</h3>       
                    </div>
                                                                             
                    <div class="form-group">  
                        <label class="control-label col-md-2">Username</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqUsername"  id="reqUsername" value="<?=$reqUsername?>" data-options="required:true" style="width:100%" <?=$disabled?> />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Nama Lengkap</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqNama"  id="reqNama" value="<?=$reqNama?>" style="width:100%" <?=$disabled?>/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                            <label class="control-label col-md-2">Password</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                       <input autocomplete="new-password" class="easyui-validatebox textbox form-control" type="password" name="reqPassword"  id="reqPassword"  style="width:50%" />
                                   </div>
                               </div>
                           </div>
                    </div>

                    <div class="form-group">  
                            <label class="control-label col-md-2">Konfirmasi Password</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                     <input autocomplete="new-password" class="easyui-validatebox textbox form-control" type="password" name="reqKonfirmasiPassword"  id="reqKonfirmasiPassword"  style="width:50%" />
                                 </div>
                             </div>
                         </div>
                      </div>

                    <div class="form-group">  
                        <label class="col-md-2"></label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input type='checkbox' id='check' />
                                    <label>Show Password</label>
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

$(document).ready(function(){

    $(document).on("input", "#reqNoTelpon", function() {
        this.value = this.value.replace(/\D/g,'');
    });

    $('#check').click(function(){
        if ($("#reqPassword").attr("type") === "password" || $("#reqKonfirmasiPassword").attr("type") === "password" ) {
            $("#reqPassword").attr("type", "text");
            $("#reqKonfirmasiPassword").attr("type", "text");
        } else {
            $("#reqPassword").attr("type", "password");
            $("#reqKonfirmasiPassword").attr("type", "password");
        }
   });
});
function submitForm(){
    
    $('#ff').form('submit',{
        url:'json-app/pengguna_json/reset_password',
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