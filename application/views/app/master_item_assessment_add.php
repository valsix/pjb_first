<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/KategoriItemAssessment");
$this->load->model("base-app/Area");
$this->load->model("base-app/ItemAssessment");
$this->load->model("base-app/StandarReferensi");
$this->load->model("base-app/ProgramItemAssessment");
$this->load->model("base-app/KonfirmasiItemAssessment");

$this->load->model("base-app/ListArea");

$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");


$set= new ItemAssessment();

if($reqId == "")
{
    $reqMode = "insert";
    // $statementarea= " AND NOT EXISTS (SELECT LIST_AREA_ID FROM ITEM_ASSESSMENT B  WHERE A.LIST_AREA_ID = B.LIST_AREA_ID )";
     $statementarea= " ";
}
else
{
    $reqMode = "update";

    $statement = " AND A.ITEM_ASSESSMENT_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("ITEM_ASSESSMENT_ID");
   
    $reqNama= $set->getField("NAMA");
    $reqDeskripsi= $set->getField("DESKRIPSI");
    $reqDuplikat= $set->getField("DUPLIKAT");
    // $reqAreaId= getmultiseparator($set->getField("LIST_AREA_ID_INFO"));
    $reqAreaId= $set->getField("LIST_AREA_ID");
    $reqKode= $set->getField("KODE");
    $statementarea= " ";

    // $reqKodeReadonly= " readonly ";
}

$set= new ListArea();
$arrarea= [];

$statement=" AND A.STATUS IS NULL ";
$set->selectByParams(array(), -1,-1,$statement.$statementarea);
    // echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("LIST_AREA_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrarea, $arrdata);
}
unset($set);

$set= new KategoriItemAssessment();
$arrkategori= [];
$set->selectByParams(array(), -1,-1,"");
                            // echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("KATEGORI_ITEM_ASSESSMENT_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrkategori, $arrdata);
}
unset($set);

$set= new ProgramItemAssessment();
$arrprogram= [];
$set->selectByParams(array(), -1,-1,"");
                            // echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("PROGRAM_ITEM_ASSESSMENT_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrprogram, $arrdata);
}
unset($set);

$set= new KonfirmasiItemAssessment();
$arrkonfirmasi= [];
$set->selectByParams(array(), -1,-1," AND A.STATUS IS NULL");
                            // echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("KONFIRMASI_ITEM_ASSESSMENT_ID");
    $arrdata["text"]= $set->getField("NAMA");
    $arrdata["NILAI"]= $set->getField("NILAI");
    array_push($arrkonfirmasi, $arrdata);
}
unset($set);


$set= new ItemAssessment();
$arrformulir= [];
$set->selectByParamsFormulir(array(), -1,-1," AND A.ITEM_ASSESSMENT_ID = '".$reqId."' ");
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("ITEM_ASSESSMENT_FORMULIR_ID");
    $arrdata["text"]= $set->getField("NAMA");
    $arrdata["KATEGORI_ITEM_ASSESSMENT_ID"]= $set->getField("KATEGORI_ITEM_ASSESSMENT_ID");
    $arrdata["PROGRAM_ITEM_ASSESSMENT_ID"]= $set->getField("PROGRAM_ITEM_ASSESSMENT_ID");
    $arrdata["STATUS_KONFIRMASI"]= $set->getField("STATUS_KONFIRMASI");
    $arrdata["NAMA"]= $set->getField("NAMA");
    $arrdata["UNIQ_ID"]= $set->getField("UNIQ_ID");

    $arrdata["STANDAR_REFERENSI_ID"]=$set->getField("STANDAR_REFERENSI_ID");

    if(!empty($arrdata["id"]))
    {
        array_push($arrformulir, $arrdata);
    }
    
}
unset($set);


$disabled="";

if($reqLihat ==1)
{
    $disabled="disabled";  
}

$set= new StandarReferensi();
$arrstandar= [];
$set->selectByParams(array(), -1,-1," ");
// echo $set->query;exit;
while($set->nextRow())
{
    $vnama= $set->getField("NAMA");
    $vdeskripsi= $set->getField("DESKRIPSI");
    $vkode= $set->getField("KODE");
    $arrdata= array();
    $arrdata["id"]= $set->getField("STANDAR_REFERENSI_ID");
    $arrdata["text"]= $vkode;
    $arrdata["desc"]= $vdeskripsi;
    $arrdata["html"]= "<div><b>".$vkode."</b></div><div><small>".$vdeskripsi."</small></div>";
    $arrdata["title"]= $vnama;
    array_push($arrstandar, $arrdata);
}
unset($set);
// print_r($arrstandar);exit;
?>
<script src='assets/multifile-master/jquery.form.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MetaData.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MultiFile.js' type="text/javascript" language="javascript"></script> 
<link rel="stylesheet" href="css/gaya-multifile.css" type="text/css">

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



</style>
<div class="col-md-12">
    
  <div class="judul-halaman"> <a href="app/index/<?=$pgreturn?>">Data <?=$pgtitle?></a> &rsaquo; Kelola <?=$pgtitle?></div>

    <div class="konten-area">
        <div class="konten-inner">

            <div>

                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">

                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i> Area</h3>       
                    </div>


                  <!--   <div class="form-group">  
                        <label class="control-label col-md-2">Kode </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <input autocomplete="off" placeholder="Kode Harus unik dan tidak boleh ada spasi" class="easyui-validatebox textbox form-control" type="text" name="reqKode"  id="reqKode" value="<?=$reqKode?>" <?=$disabled?> data-options="required:true" style="width:100%" />
                               </div>
                           </div>
                       </div>
                    </div> -->

                   <div class="form-group">  
                        <label class="control-label col-md-2">Area </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <select class="form-control jscaribasicmultiple edittext" required id="reqListAreaId" <?=$disabled?> name="reqListAreaId"  style="width:100%;" >
                                        <option value="">Pilih Area</option>
                                        <?
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
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="ket_area"> 
                    <?
                    if (!empty($reqAreaId))
                    {
                       

                            $set= new ListArea();

                            $statement=" AND A.STATUS IS NULL AND A.LIST_AREA_ID = ".$reqAreaId;
                            $set->selectByParams(array(), -1,-1,$statement);
                            $set->firstRow();
                            $reqNama= $set->getField("DESKRIPSI");
                            $reqKode= $set->getField("KODE");
                        
                    ?> 
                            <div class="form-group">  
                                <label class="control-label col-md-2">Kode Area </label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                            <textarea class="easyui-validatebox textbox form-control" disabled><?=$reqKode?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">  
                                <label class="control-label col-md-2">Deskripsi Area </label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                            <textarea class="easyui-validatebox textbox form-control" disabled><?=$reqNama?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                    <?
                          
                    }
                    ?>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Duplikat </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input autocomplete="off" class="easyui-validatebox textbox form-control edittext" type="text" name="reqDuplikat"  id="reqDuplikat" <?=$disabled?> value="<?=$reqDuplikat?>" style="width:10%"  />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i> Formulir Assessment</h3>       
                    </div>
                    <br>
                    
                   
                    <div style="
                    position: sticky;
                    top: 5rem;
                    z-index: 1">
                    <a href="javascript:void(0)" class="btn btn-primary" id='tambahformulir' onclick="AddFormulir()">Tambah</a>
                    <a href="javascript:void(0)" class="btn btn-success" id='excel' onclick="import_detil()">Import</a>
                    <a href="javascript:void(0)" class="btn btn-danger btn-remove" id='deleteformulir' onclick="deleteform()">Hapus</a>
                    </div>
                    
                    
                   <!--  <span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a class='btn-remove'  ><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true' onclick="delete_data('<?=$reqBaris?>','isi','<?=$reqDetilId?>')"></i></a></span> -->
                    <br>
                    <br>
                    <br>

                    <div id="tabelitem">

                        <?
                        foreach ($arrformulir as $key => $value) {

                            $reqKategoriId=$value["KATEGORI_ITEM_ASSESSMENT_ID"];
                            $reqTersedia=$value["STATUS_KONFIRMASI"];
                            $reqNama=$value["NAMA"];
                            $reqProgramId=$value["PROGRAM_ITEM_ASSESSMENT_ID"];
                            $reqFormulirId=$value["id"];
                            $reqUniqId=$value["UNIQ_ID"];
                            $reqStandarId= getmultiseparator($value["STANDAR_REFERENSI_ID"]);
                            
                            // $set= new ItemAssessment();
                            // $arrstandar= [];
                            // $set->selectByParamsStandar(array(), -1,-1," AND A.ITEM_ASSESSMENT_FORMULIR_ID=".$reqFormulirId);
                            // // echo $set->query;exit;
                            // while($set->nextRow())
                            // {
                            //     $arrdata= array();
                            //     $arrdata["id"]= $set->getField("STANDAR_REFERENSI_ID");
                            //     $arrdata["text"]= $set->getField("NAMA");
                            //     $arrdata["UNIQ_ID"]= $set->getField("UNIQ_ID");
                            //     array_push($arrstandar, $arrdata);
                            // }
                            // unset($set);

                        ?>
                            <div id="border" class="itemformulir" style="border:1px solid black; ">   
                                <div class="form-group"> 
                                    <label class="control-label col-md-2">Kategori Item Assessment </label>
                                    <div class='col-md-8'>
                                        <div class='form-group'>
                                            <div class='col-md-11'>
                                                <select class="form-control jscaribasicmultiple edittext" required id="reqKategoriId" <?=$disabled?> name="reqKategoriId[]"  style="width:100%;" >
                                                    <?
                                                    foreach($arrkategori as $item) 
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
                                    <label class="control-label col-md-2"> Item Assessment </label>
                                    <div class='col-md-8'>
                                        <div class='form-group'>
                                            <div class='col-md-11'>
                                                <textarea class="easyui-validatebox textbox form-control edittext" required name="reqNama[]" style="width:100%"><?=$reqNama?></textarea>
                                            </div>              
                                        </div>
                                    </div>
                                </div>

                              <!--   <div class="form-group">  
                                    <label class="control-label col-md-2">Konfirmasi  </label>
                                    <div class='col-md-8'>
                                        <div class='form-group'>
                                            <div class='col-md-11'>
                                                <select class="form-control jscaribasicmultiple edittext" required id="reqTersedia" <?=$disabled?> name="reqTersedia[]"  style="width:15%;" >
                                                   <option value="1" <?/* if($reqTersedia==1) echo 'selected' */?> >Ya</option>
                                                   <option value="0" <?/* if($reqTersedia==0)echo 'selected' */?> >Tidak</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="form-group">  
                                    <label class="control-label col-md-2">Konfirmasi  </label>
                                    <div class='col-md-8'>
                                        <div class='form-group'>
                                            <div class='col-md-11'>
                                                <select class="form-control jscaribasicmultiple edittext" required id="reqTersedia" <?=$disabled?> name="reqTersedia[]"  style="width:100%;" >
                                                    <?
                                                    foreach($arrkonfirmasi as $item) 
                                                    {
                                                        $selectvalid= $item["id"];
                                                        $selectvaltext= $item["text"];
                                                        $selectvalnilai= $item["NILAI"];

                                                        $selected="";
                                                        if($selectvalnilai==$reqTersedia)
                                                        {
                                                            $selected="selected";
                                                        }
                                                        ?>
                                                        <option value="<?=$selectvalnilai?>" <?=$selected?>><?=$selectvaltext?></option>
                                                        <?
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group"> 
                                    <label class="control-label col-md-2">Program Item Assessment </label>
                                    <div class='col-md-8'>
                                        <div class='form-group'>
                                            <div class='col-md-11'>
                                                <select class="form-control jscaribasicmultiple edittext" required id="reqProgramId" <?=$disabled?> name="reqProgramId[]"  style="width:100%;" >
                                                    <?
                                                    foreach($arrprogram as $item) 
                                                    {
                                                        $selectvalid= $item["id"];
                                                        $selectvaltext= $item["text"];

                                                        $selected="";
                                                        if($selectvalid==$reqProgramId)
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
                                    <label class="control-label col-md-2">Standar Referensi </label>
                                    <div class='col-md-8'>
                                        <div class='form-group'>
                                            <div class='col-md-11'>
                                                <input type="hidden" name="reqStandarId[]"  id="reqStandarValId<?=$reqFormulirId?>" value="<?=$value["STANDAR_REFERENSI_ID"]?>">
                                                <select class="form-control deskripsiselect edittext" required id="reqStandarId<?=$reqFormulirId?>" <?=$disabled?>  multiple style="width:100%;" >
                                                    <?
                                                    foreach($arrstandar as $item) 
                                                    {
                                                        $selectvalid= $item["id"];
                                                        $selectvaltext= $item["text"];
                                                        $selectvaldesc= $item["desc"];

                                                        $selected="";
                                                        if(in_array($selectvalid, $reqStandarId))
                                                        {
                                                            $selected="selected";
                                                        }
                                                        ?>
                                                        <option value="<?=$selectvalid?>" title="<?=$selectvaldesc?>" <?=$selected?>><?=$selectvaltext?></option>
                                                        <?
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div style="text-align:center;padding:5px">
                                 <a href="javascript:void(0)" class="btn btn-danger"  onclick="deleteformulirdetil('<?=$reqFormulirId?>')">Hapus Item</a>
                                <input type="hidden" name="reqFormulirId[]" value="<?=$reqFormulirId?>" />
                             </div>
                            </div>


                            <script type="text/javascript">
                                $('#reqStandarId<?=$reqFormulirId?>').change(function() {

                                    var result= $(this).val();
                                    console.log(result);
                                    if(result !==null)
                                    {
                                        var str1 = result.toString();
                                        $('#reqStandarValId<?=$reqFormulirId?>').val(str1);
                                    }                                        
                                   
                                });
                            </script>

                        <?
                        }
                        ?>
                        
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
                <a href="javascript:void(0)" class="btn btn-primary" id="reqSimpan" onclick="submitForm()">Submit</a>
                <?
                if(!empty($reqId))
                {
                ?>
                <a href="javascript:void(0)" class="btn btn-success" id='editform' onclick="editform()">Edit Form</a>
                <a href="javascript:void(0)" class="btn btn-success" id='tutupform' onclick="tutupform()">Tutup Form</a>
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
getarrstandar= <?=JSON_encode($arrstandar)?>;
$(".deskripsiselect").select2({
  data: getarrstandar,
  escapeMarkup: function(markup) {
    return markup;
  },
  templateResult: function(data) {
    return data.html;
  },
  templateSelection: function(data) {
    return data.text;
  },
  matcher: matcher
});

function matcher(params, data) {
    // If there are no search terms, return all of the data
    if ($.trim(params.term) === '') {
        return data;
    }

    // Do not display the item if there is no 'text' property
    if (typeof data.text === 'undefined') {
        return null;
    }

    // `params.term` should be the term that is used for searching
    // `data.text` is the text that is displayed for the data object
    // `data.html` is the additional / info text, within the option, seen once the dropdown is shown
    // The search is case insensitive
    if (data.text.toLowerCase().indexOf(params.term.toLowerCase()) > -1 || (typeof data.html !== 'undefined' && data.html.toLowerCase().indexOf(params.term.toLowerCase()) > -1)) {
        var modifiedData = $.extend({}, data, true);
        modifiedData.text += ' (matched)';

        // You can return modified objects from here
        // This includes matching the `children` how you want in nested data sets
        return modifiedData;
    }

    // Return `null` if the term should not be displayed
    return null;
}

function deleteform()
{
    $('#tabelitem .tambahitemform:last').remove();
    if ($.trim($(".tambahitemform").html())=='')
    {
        // console.log(1);
        $("#deleteformulir").hide();
    }
}

$(document).on('keydown', '#reqKode', function(e) {
    if (e.keyCode == 32) return false;
});

var reqid = '<?=$reqId?>';


$(function(){
    if(reqid)
    {
        $(".edittext").attr("disabled", true);
        $("#reqSimpan").hide();

    }
    else
    {
        $(".edittext").attr("disabled", false);
         $("#reqSimpan").show();
    }
});

$("#tutupform").hide();
$("#tambahformulir").hide();
$("#excel").hide();

$("#deleteformulir").hide();

function editform()
{
    $(".edittext").attr("disabled", false);
    $("#reqSimpan").show();
    $("#tutupform").show();
    $("#editform").hide();
    $("#tambahformulir").show();
    $("#excel").show();
}

function tutupform()
{
    $(".edittext").attr("disabled", true);
    $("#reqSimpan").hide();
    $("#tutupform").hide();
    $("#editform").show();
    $("#tambahformulir").hide();
    $("#excel").hide();
}

$('#reqListAreaId').change(function() {
    var result= $(this).val();
    if (result)
    {
        $("#ket_area").empty();
        // result.forEach(function(e) {
           $.get("app/loadUrl/app/template_ket_area?reqAreaId="+result, function(data) { 
               $("#ket_area").append(data);
            });
        // });
    }
    else
    {
        $("#ket_area").empty();
    }                              
});

$('#reqDuplikat').bind('keyup paste', function(){
    this.value = this.value.replace(/[^0-9]/g, '');
});

const uniqId = (() => {
    let i = 0;
    return () => {
        return i++;
    }
})();


// console.log(uniqId());
function AddFormulir() {

    $("#tutupform").hide();
    $.get("app/loadUrl/app/item_assessment_template?reqId=<?=$reqId?>&reqUniqId="+uniqId(), function(data) { 
        $("#tabelitem").append(data);
    });

    $("#deleteformulir").show();

}

function import_detil(reqId) {
    openAdd("app/index/master_item_assessment_import?reqId=<?=$reqId?>");
}

function submitForm(){
    
    $('#ff').form('submit',{
        url:'json-app/item_assessment_json/add',
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

function setArea(values){
    $('#reqListAreaId').val(values.LIST_AREA_ID);
    $('#reqAreaNama').val(values.NAMA);
}

function openArea()
{
    openAdd('app/index/lookup_area');
}


function deleteformulirdetil (id)
{
    var pesan='Apakah anda yakin untuk hapus data terpilih?';

    $.messager.confirm('Konfirmasi',pesan,function(r){
        if (r){
            $.getJSON("json-app/item_assessment_json/deletedetil/?reqId=<?=$reqId?>&reqRowId="+id,
                function(data){
                    $.messager.alert('Info', data.PESAN, 'info');
                    valinfoid= "";
                    location.reload();
                });

        }
    }); 
}

</script>


