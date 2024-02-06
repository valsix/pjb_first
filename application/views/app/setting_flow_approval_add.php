<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/FlowApproval");

$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("setting_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");

$set= new FlowApproval();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

    $statement = " AND FLOW_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqRefModul= $set->getField("REF_TABEL");
    $reqRefDesk= $set->getField("REF_DESK");
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
                        <label class="control-label col-md-2">Ref Modul</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input   name="reqRefModul" class="easyui-combobox form-control" id="reqRefModul"
                                    data-options="width:'300',editable:false,valueField:'id',textField:'text',url:'json-app/Combo_json/combomenuapproval'" value="<?=$reqRefModul?>" required  <?=$disabled?>/>
                                </div>
                            </div>
                        </div>
                    </div>
                                                                             
                    <div class="form-group">  
                        <label class="control-label col-md-2">Deskripsi</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <textarea name="reqRefDesk" class="easyui-validatebox form-control" id="reqRefDesk" data-options="required:true" <?=$disabled?>><?=$reqRefDesk?></textarea>
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

            <?
            if(!empty($reqId))
            {
            ?>
            <div>
                <div class="page-header">
                    <h3><i class="fa fa-file-text fa-lg"></i> <?=$pgtitle?></h3>       
                </div>

                <?php 
                // $list_detail = $this->mod->get_listdetail($row_id);
                $list_detail = "";
                ?>
                <table class="table table-bordered table-striped table-hovered">
                    <thead>
                        <th>No</th>
                        <th>Role</th>
                        <th>Index</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                    <?
                    $setDetil= new FlowApproval();
                    $setDetil->selectByParamsDetil(array(), -1, -1, $statement);
                    // echo $setDetil->query;exit;
                    $i=1;
                    while ($setDetil->nextRow()) {
                        $reqIndex= $setDetil->getField("FLOWD_INDEX");
                        $reqNamaRole= $setDetil->getField("nama_role");
                        $reqIdDetil= $setDetil->getField("FLOWD_ID");
                    ?>
                    <tr>
                        <td><?=$i?></td>
                        <td><?=$reqNamaRole?></td>
                        <td><?=$reqIndex?></td>
                        <td>
                            <?
                            if($reqLihat ==1)
                            {}
                            else
                            {
                                ?>
                                <span style="background-color: red;padding: 8px; border-radius: 5px;"><a onclick="hapus(<?=$reqIdDetil?>)"><i class="fa fa-trash fa-lg" style="color: white;" aria-hidden="true"></i></a></span>
                                <span style="background-color: blue;padding: 8px; border-radius: 5px;"><a onclick="edit(<?=$reqIdDetil?>)"><i class="fa fa-pencil fa-lg" style="color: white;" aria-hidden="true"></i></a></span>
                                <?
                            }
                            ?>
                        </td>
                    </tr>
                    <?
                    $i++;
                    }?>
                    </tbody>
                </table>

                <?
                if($reqLihat ==1)
                {}
                else
                {
                ?>
                <div style="text-align:center;padding:5px">
                    <a id="triggerTambahDetil"  class='btn btn-primary btn-sm btn-flat' data-remote='false' data-target='#compose-modal' data-toggle='modal'>Tambah Detail</a>
                </div>
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
function submitForm(){
    
    $('#ff').form('submit',{
        url:'json-app/flow_approval_json/add',
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

$("#triggerTambahDetil").on("click", function () {
    // console.log('<?=$reqId?>')
    varurl= "app/index/setting_flow_approval_add_detil?reqHead=<?=$reqId?>";
        document.location.href = varurl;
});  

function hapus(val){
    let text = "Hapus data terpilih?";
    if (confirm(text) == true) {
   
    $.getJSON("json-app/flow_approval_json/delete_detil/?reqId="+val,
        function(data){
            $.messager.alert('Info', data.PESAN, 'info');
            valinfoid= "";
            location.reload();
        });
    }
}

function edit(val){
    varurl= "app/index/setting_flow_approval_add_detil?reqId="+val;
    document.location.href = varurl;
}
</script>