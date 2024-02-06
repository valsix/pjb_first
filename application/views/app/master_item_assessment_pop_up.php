<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/KategoriItemAssessment");
$this->load->model("base-app/Area");
$this->load->model("base-app/ItemAssessment");
$this->load->model("base-app/StandarReferensi");
$this->load->model("base-app/ProgramItemAssessment");



$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");


$set= new ItemAssessment();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

    $statement = " AND ITEM_ASSESSMENT_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("ITEM_ASSESSMENT_ID");
    $reqStandarId= $set->getField("STANDAR_REFERENSI_ID");
    $reqNama= $set->getField("NAMA");
    $reqDeskripsi= $set->getField("DESKRIPSI");
    $reqDuplikat= $set->getField("DUPLIKAT");

    // $reqKodeReadonly= " readonly ";
}


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
    array_push($arrformulir, $arrdata);
}
unset($set);


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
                        <h3><i class="fa fa-file-text fa-lg"></i> Area</h3>       
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Area </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input type="hidden" name="reqListAreaId" id="reqListAreaId" value="<?=$reqListAreaId?>" style="width:100%" />
                                    <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqAreaNama"  id="reqAreaNama" <?=$disabled?> value="<?=$reqAreaNama?>" style="width:100%" readonly />
                                </div>
                                <?
                                if($reqLihat == 1)
                                {}
                                else
                                {
                                ?>
                                    <div class="col-md-1">
                                        <a id="btnAdd" onclick="openArea()"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> </a>
                                    </div>
                                <?
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Duplikat </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqDuplikat"  id="reqDuplikat" <?=$disabled?> value="<?=$reqDuplikat?>" style="width:10%"  />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i> Formulir Assessment</h3>       
                    </div>
                    <br>

                    <a href="javascript:void(0)" class="btn btn-primary" onclick="AddFormulir()">Tambah</a>
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

                            $set= new ItemAssessment();
                            $arrstandar= [];
                            $set->selectByParamsStandar(array(), -1,-1," AND A.ITEM_ASSESSMENT_FORMULIR_ID=".$reqFormulirId);
                            // echo $set->query;exit;
                            while($set->nextRow())
                            {
                                $arrdata= array();
                                $arrdata["id"]= $set->getField("STANDAR_REFERENSI_ID");
                                $arrdata["text"]= $set->getField("NAMA");
                                $arrdata["UNIQ_ID"]= $set->getField("UNIQ_ID");
                                array_push($arrstandar, $arrdata);
                            }
                            unset($set);

                        ?>
                            <div id="border" style="border:1px solid black; ">   
                                <div class="form-group"> 
                                    <label class="control-label col-md-2">Kategori Item Assessment </label>
                                    <div class='col-md-8'>
                                        <div class='form-group'>
                                            <div class='col-md-11'>
                                                <select class="form-control jscaribasicmultiple" required id="reqKategoriId" <?=$disabled?> name="reqKategoriId[]"  style="width:100%;" >
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
                                                <textarea class="easyui-validatebox textbox form-control" required name="reqNama[]" style="width:100%"><?=$reqNama?></textarea>
                                            </div>              
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">  
                                    <label class="control-label col-md-2">Konfirmasi  </label>
                                    <div class='col-md-8'>
                                        <div class='form-group'>
                                            <div class='col-md-11'>
                                                <select class="form-control jscaribasicmultiple" required id="reqTersedia" <?=$disabled?> name="reqTersedia[]"  style="width:15%;" >
                                                   <option value="1" <? if($reqTersedia==1) echo 'selected' ?> >Iya</option>
                                                   <option value="2" <? if($reqTersedia==2)echo 'selected' ?> >Tidak</option>
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
                                                <select class="form-control jscaribasicmultiple" required id="reqProgramId" <?=$disabled?> name="reqProgramId[]"  style="width:100%;" >
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
                                                <a id="btnAdd" onclick="openStandar('<?=$reqUniqId?>')"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i>&nbsp; </a>
                                                <div class="inner" id="divlistform<?=$reqUniqId?>">
                                                    <?
                                                    foreach($arrstandar as $item) 
                                                    {
                                                        $reqStandarId= $item["id"];
                                                        $reqNama= $item["text"];
                                                        ?>
                                                        <div class="item">
                                                            <label  ><?=$reqNama?></label>

                                                            <i class="fa fa-times-circle" onclick="$(this).parent().remove(); $('#itemisi').empty();"></i>
                                                            <input type="hidden" name="reqStandarId[]" value="<?=$reqStandarId?>">

                                                        </div>
                                                        <?
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

$('#reqDuplikat').bind('keyup paste', function(){
    this.value = this.value.replace(/[^0-9]/g, '');
});

function addmultiarea(id, multiinfonama, IDFIELD) 
{
    batas= id.length;

    if(batas > 0)
    {
        rekursivemultisatuanKerja(0, id, multiinfonama, IDFIELD);
    }
}

function rekursivemultisatuanKerja(index, id, multiinfonama, IDFIELD) 
{
    urllink= "app/loadUrl/app/template_standar";
    method= "POST";
    batas= id.length;
    if(index < batas)
    {
        STANDAR_REFERENSI_ID= id[index];
        NAMA= multiinfonama[index];

        var rv = true;

        if (rv == true) 
        {
            $.ajax({
                url: urllink,
                method: method,
                data: {
                    reqStandarId: STANDAR_REFERENSI_ID,
                    reqNama: NAMA
                },
                    // dataType: 'json',
                    success: function (response) {
                        $("#"+IDFIELD).append(response);

                        index= parseInt(index) + 1;
                        rekursivemultisatuanKerja(index,id, multiinfonama, IDFIELD);
                    },
                    error: function (response) {
                    },
                    complete: function () {
                    }
                });
        }
        else
        {
            index= parseInt(index) + 1;
            rekursivemultisatuanKerja(index,id, multiinfonama, IDFIELD);
        }
    }
}

const uniqId = (() => {
    let i = 0;
    return () => {
        return i++;
    }
})();


// console.log(uniqId());
function AddFormulir() {
    $.get("app/loadUrl/app/item_assessment_template?reqId=<?=$reqId?>&reqUniqId="+uniqId(), function(data) { 
        $("#tabelitem").append(data);
    });
}

function openStandar(id)
{
    openAdd('app/loadUrl/app/lookup_standar_multi?reqUniqId='+id);
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
            console.log(data);return false;

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
</script>