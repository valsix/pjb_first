<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/BobotItemAssessment");
$this->load->model("base-app/KategoriItemAssessment");


$this->load->library('libapproval');

$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");


$set= new BobotItemAssessment();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

	$statement = " AND BOBOT_ITEM_ASSESSMENT_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("BOBOT_ITEM_ASSESSMENT_ID");
    $reqKategoriId= $set->getField("KATEGORI_ITEM_ASSESSMENT_ID");
    $reqBobot= $set->getField("BOBOT");
    // $reqKodeReadonly= " readonly ";
}

unset($set);


$disabled="";


$set= new KategoriItemAssessment();
$arrset= [];
$set->selectByParams(array(), -1,-1);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("KATEGORI_ITEM_ASSESSMENT_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrset, $arrdata);
}
unset($set);



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
                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">

                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i> <?=$pgtitle?></h3>       
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Kategori Item Assesment</label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                <select class="form-control jscaribasicmultiple" id="reqKategoriId" <?=$disabled?> name="reqKategoriId" style="width:100%;" >
                                    <?
                                    foreach($arrset as $item) 
                                    {
                                        $selectvalid= $item["id"];
                                        $selectvaltext= $item["text"];

                                        $selected="";
                                        if($selectvalid==$reqKategoriId)
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
                        <label class="control-label col-md-2">Bobot </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqBobot"  id="reqBobot" value="<?=$reqBobot?>" <?=$disabled?> data-options="required:true" style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                   <input type="hidden" name="reqId" value="<?=$reqId?>" />
                   <input type="hidden" name="reqMode" value="<?=$reqMode?>" />

                   <input type="hidden" name="infopg" value="<?=$pg?>" />

                </form>
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
</div>

<script>

$("#reqBobot").on("input", function(evt) {
   var self = $(this);
   self.val(self.val().replace(/[^0-9\.]/g, ''));
   if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) 
   {
     evt.preventDefault();
   }
});


function submitForm(){
    
    $('#ff').form('submit',{
        url:'json-app/bobot_item_assessment_json/add',
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
            // console.log(data);
            // $.messager.alert('Info', "masih trace bug", 'warning');
            // return false;

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