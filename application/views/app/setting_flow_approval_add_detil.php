<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/FlowApproval");

$pgtitle= 'Flow Approval';

$reqId = $this->input->get("reqId");

$set= new FlowApproval();

if($reqId == "")
{
    $reqMode = "insert";
    $reqHead = $this->input->get("reqHead");
}
else
{
    $reqMode = "update";

	$statement = " AND A.FLOWD_ID = '".$reqId."' ";
    $set->selectByParamsDetil(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("FLOWD_ID");
    $reqRole= $set->getField("ROLE_ID");
    $reqIndex= $set->getField("FLOWD_INDEX");
    $reqHead= $set->getField("FLOW_ID");
}

?>

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


</style>

<script src='assets/multifile-master/jquery.form.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MetaData.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MultiFile.js' type="text/javascript" language="javascript"></script> 
<link rel="stylesheet" href="css/gaya-multifile.css" type="text/css">


<div class="col-md-12">
    
  <div class="judul-halaman"> <a href="app/index/setting_flow_approval_add?reqId<?=$reqHead?>">Kelola <?=$pgtitle?></a> &rsaquo; Detil <?=$pgtitle?></div>

    <div class="konten-area">
        <div class="konten-inner">

            <div>

                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">

                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i> <?=$pgtitle?></h3>       
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Role </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input  name="reqRole" class="easyui-combobox form-control" id="reqRole"
                                    data-options="width:'300',editable:false,valueField:'id',textField:'text',url:'json-app/combo_json/comborole'" value="<?=$reqRole?>" required />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Index </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqIndex"  id="reqIndex" value="<?=$reqIndex?>" data-options="required:true" style="width:100%" onkeypress="return (event.charCode !=8 && event.charCode ==0 || ( event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)))" maxlength='3' />
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="reqId" value="<?=$reqId?>" />
                    <input type="hidden" name="reqHead" value="<?=$reqHead?>" />
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
                </form>

            </div>
            <div style="text-align:center;padding:5px">
                <a href="javascript:void(0)" class="btn btn-primary" onclick="submitForm()">Submit</a>

            </div>
            
        </div>
    </div>
    
</div>

<script>
function submitForm(){
    
    $('#ff').form('submit',{
        url:'json-app/flow_approval_json/add_detil',
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
                $.messager.alertLink('Info', infoSimpan, 'info', "app/index/setting_flow_approval_add?reqId=<?=$reqHead?>");
            // console.log('berhasil');
        }
    });
}

function clearForm(){
    $('#ff').form('clear');
}
 
</script>