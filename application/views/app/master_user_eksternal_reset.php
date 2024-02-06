<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/PenggunaEksternal");
$this->load->model("base-app/RoleApproval");
$this->load->model("base-app/MasterJabatan");



$pgreturn= str_replace("_reset", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");


$set= new PenggunaEksternal();

if($reqId == "")
{
    $reqMode = "insert";
    $reqExpiredDate=date('d-m-Y', strtotime('+1 year'));
}
else
{
    $reqMode = "update";

	$statement = " AND PENGGUNA_EXTERNAL_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("PENGGUNA_EXTERNAL_ID");
    $reqNid= $set->getField("NID");
    $reqNama= $set->getField("NAMA");
    $reqNoTelpon= $set->getField("NO_TELP");
    $reqEmail= $set->getField("EMAIL");
    $reqDistrikId= $set->getField("DISTRIK_ID");
    $reqPositionId= $set->getField("POSITION_ID");
    $reqRoleId= $set->getField("ROLE_ID");
    $reqPerusahaanId= $set->getField("PERUSAHAAN_EKSTERNAL_ID");
    $reqStatus= $set->getField("STATUS");
    $reqLinkFoto= $set->getField("FOTO");
    $reqExpiredDate= dateToPageCheck($set->getField("EXPIRED_DATE"));
    // $reqKodeReadonly= " readonly ";
}

$set= new RoleApproval();
$arrset= [];
$set->selectByParams(array(), -1,-1);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("ROLE_ID");
    $arrdata["text"]= $set->getField("ROLE_NAMA");
    array_push($arrset, $arrdata);
}
unset($set);

$set= new MasterJabatan();
$statement=" AND A.TIPE = '1' AND A.NAMA_POSISI <> ''";
$arrjabatan= [];
$set->selectByParamsCombo(array(), 30,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("POSITION_ID");
    $arrdata["text"]= $set->getField("NAMA_POSISI");
    array_push($arrjabatan, $arrdata);
}
unset($set);



$disabled="disabled";  



?>

<script src='assets/multifile-master/jquery.form.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MetaData.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MultiFile.js' type="text/javascript" language="javascript"></script> 
<link rel="stylesheet" href="css/gaya-multifile.css" type="text/css">

<div class="col-md-12">
    
  <div class="judul-halaman"> <a href="app/index/<?=$pgreturn?>">Data <?=$pgtitle?></a> &rsaquo; Reset Password User Eksternal</div>

    <div class="konten-area">
        <div class="konten-inner">

            <div>

                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">

                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i>  Reset Password</h3>       
                    </div>
                                                                             
                    <div class="form-group">  
                        <label class="control-label col-md-2">NID</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqNid"  id="reqNid" value="<?=$reqNid?>" data-options="required:true" style="width:100%" <?=$disabled?> />
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
                                       <input autocomplete="off" class="easyui-validatebox textbox form-control" type="password" name="reqPassword"  id="reqPassword"  style="width:50%" />
                                   </div>
                               </div>
                           </div>
                    </div>

                    <div class="form-group">  
                            <label class="control-label col-md-2">Konfirmasi Password</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="password" name="reqKonfirmasiPassword"  id="reqKonfirmasiPassword"  style="width:50%" />
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
        url:'json-app/user_json/reset_password',
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
            //console.log(data);return false;

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
function delete_gambar()
{
    $.messager.confirm('Konfirmasi',"Hapus gambar?",function(r){
        if (r){
            $.getJSON("json-app/user_json/delete_gambar/?reqId=<?=$reqId?>",
                function(data){
                    $.messager.alert('Info', data.PESAN, 'info');
                    valinfoid= "";
                    location.reload();
                });
        }
    }); 
}   
</script>