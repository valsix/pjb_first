<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/KategoriItemAssessment");
$this->load->model("base-app/Area");
$this->load->model("base-app/ItemAssessment");



$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");


$set= new KategoriItemAssessment();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

    $statement = " AND KATEGORI_ITEM_ASSESSMENT_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("KATEGORI_ITEM_ASSESSMENT_ID");
    $reqNama= $set->getField("NAMA");
    // $reqAreaId= $set->getField("AREA_ID");
    // $reqItemId= $set->getField("ITEM_ASSESSMENT_ID");
    $reqBobot= $set->getField("BOBOT");
    $reqKode= $set->getField("KODE");

    // $reqKodeReadonly= " readonly ";
}



// $set= new Area();
// $arrarea= [];
// $set->selectByParams(array(), -1,-1,"");
// // echo $set->query;exit;
// while($set->nextRow())
// {
//     $arrdata= array();
//     $arrdata["id"]= $set->getField("AREA_ID");
//     $arrdata["text"]= $set->getField("NAMA");
//     array_push($arrarea, $arrdata);
// }
// unset($set);

// $set= new ItemAssessment();
// $arritem= [];
// $set->selectByParams(array(), -1,-1,"");
// // echo $set->query;exit;
// while($set->nextRow())
// {
//     $arrdata= array();
//     $arrdata["id"]= $set->getField("ITEM_ASSESSMENT_ID");
//     $arrdata["text"]= $set->getField("NAMA");
//     array_push($arritem, $arrdata);
// }
// unset($set);

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
                                   <input autocomplete="off" placeholder="Kode Harus unik dan tidak boleh ada spasi" class="easyui-validatebox textbox form-control" type="text" name="reqKode"  id="reqKode" value="<?=$reqKode?>" <?=$disabled?> data-options="required:true" style="width:100%" />
                               </div>
                           </div>
                       </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Nama </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input autocomplete="off" <?=$disabled?> data-options="required:true"  class="easyui-validatebox textbox form-control" type="text" name="reqNama"  id="reqNama" value="<?=$reqNama?>"  style="width:100%"  />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Bobot </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqBobot"  id="reqBobot" value="<?=$reqBobot?>" <?=$disabled?>  style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="form-group">  
                        <label class="control-label col-md-2">Area</label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <select class="form-control jscaribasicmultiple" id="reqAreaId" <?=$disabled?> name="reqAreaId" style="width:100%;" >
                                    <option value="" >Pilih Area</option>
                                        <? /*
                                        foreach($arrarea as $item) 
                                        {
                                            $selectvalid= $item["id"];
                                            $selectvaltext= $item["text"];

                                            $selected="";
                                            if($selectvalid==$reqAreaId)
                                            {
                                                $selected="selected";
                                            }
                                            ?>
                                            <option value="<?=$selectvalid?>" <?=$selected?>><?=$selectvaltext?></option>
                                            <?
                                        }
                                        */?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- <div class="form-group">  
                        <label class="control-label col-md-2">Item Assessment</label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <select class="form-control jscaribasicmultiple" id="reqItemId" <?=$disabled?> name="reqItemId" style="width:100%;" >
                                    <option value="" >Pilih Item Assessment</option>
                                        <? /*
                                        foreach($arritem as $item) 
                                        {
                                            $selectvalid= $item["id"];
                                            $selectvaltext= $item["text"];

                                            $selected="";
                                            if($selectvalid==$reqItemId)
                                            {
                                                $selected="selected";
                                            }
                                            ?>
                                            <option value="<?=$selectvalid?>" <?=$selected?>><?=$selectvaltext?></option>
                                            <?
                                        }
                                        */?>
                                    </select>
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

$("#reqBobot").on("input", function(evt) {
   var self = $(this);
   self.val(self.val().replace(/[^0-9\.]/g, ''));
   if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) 
   {
     evt.preventDefault();
   }
});


$(document).on('keydown', '#reqKode', function(e) {
    if (e.keyCode == 32) return false;
});
function submitForm(){
    
    $('#ff').form('submit',{
        url:'json-app/kategori_item_assessment_json/add',
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