<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/AreaAssessment");

$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");


$set= new AreaAssessment();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

	$statement = " AND AREA_ASSESSMENT_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("AREA_ASSESSMENT_ID");
    $reqNama= $set->getField("NAMA");
    $reqDistrikId= $set->getField("AREA_ID");
    $reqAreaNama= $set->getField("AREA_NAMA");
    $reqGrouping= $set->getField("GROUPING");

    $set= new AreaAssessment();
    $arrarea= [];
    $statement = " AND AREA_ASSESSMENT_ID = '".$reqId."' ";
    $set->selectByParamsArea(array(), -1,-1,$statement);
    // echo $set->query;exit;
    while($set->nextRow())
    {
        $arrdata= array();
        $arrdata["AREA_ID"]= $set->getField("AREA_ID");
        $arrdata["NAMA"]= $set->getField("NAMA");
        array_push($arrarea, $arrdata);
    }
    unset($set);

    // print_r($arrarea);exit;


    $set= new AreaAssessment();
    $arrdistrik= [];
    $statement = " AND AREA_ASSESSMENT_ID = '".$reqId."' ";
    $set->selectByParamsDistrik(array(), -1,-1,$statement);
    // echo $set->query;exit;
    while($set->nextRow())
    {
        $arrdata= array();
        $arrdata["DISTRIK_ID"]= $set->getField("DISTRIK_ID");
        $arrdata["NAMA"]= $set->getField("KODE")." - ".$set->getField("NAMA");
        array_push($arrdistrik, $arrdata);
    }
    unset($set);

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

    <div class="konten-area_assessment">
        <div class="konten-inner">

            <div>

                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">

                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i> <?=$pgtitle?></h3>       
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Area</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <a id="btnAdd" onclick="openArea('<?=$reqId?>')"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i>&nbsp; </a>
                                    <div class="inner" id="divlistform">
                                        <?
                                        if(!empty($arrarea))
                                        {
                                            foreach ($arrarea as $key => $value) 
                                            {
                                                $valareaid= $value["AREA_ID"];
                                                $valnama= $value["NAMA"];
                                                ?>
                                                <div class="item"><?=$valnama?> 
                                                <i class="fa fa-times-circle" onclick="$(this).parent().remove(); "></i>
                                                <input type="hidden" name="reqAreaId[]" value="<?=$valareaid?>">
                                                 </div>
                                            <?
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Distrik/Unit</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <a id="btnAdd" onclick="openDistrik('<?=$reqId?>')"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i>&nbsp; </a>
                                    <div class="inner" id="divlistdistrik">
                                        <?
                                        if(!empty($arrdistrik))
                                        {
                                            foreach ($arrdistrik as $key => $value) 
                                            {
                                                $valdistrikid= $value["DISTRIK_ID"];
                                                $valnama= $value["NAMA"];
                                                ?>
                                                <div class="item"><?=$valnama?> 
                                                    <i class="fa fa-times-circle" onclick="$(this).parent().remove(); "></i>
                                                    <input type="hidden" name="reqDistrikId[]" value="<?=$valdistrikid?>">
                                                </div>
                                            <?
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Nama Area di Unit </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input autocomplete="off" <?=$disabled?>  class="easyui-validatebox textbox form-control" type="text" name="reqNama"  id="reqNama" value="<?=$reqNama?>"  style="width:100%"  />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Grouping </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input autocomplete="off" <?=$disabled?>  class="easyui-validatebox textbox form-control" type="text" name="reqGrouping"  id="reqGrouping" value="<?=$reqGrouping?>"  style="width:100%"  />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Source Asset</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input type="hidden" name="reqAssetId" id="reqAssetId" value="<?=$reqAssetId?>" style="width:100%" />
                                    <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqAssetNama"  id="reqAssetNama" <?=$disabled?> value="<?=$reqAssetNama?>" style="width:100%" readonly />
                                </div>
                                <?
                                if($reqLihat == 1)
                                {}
                                else
                                {
                                    ?>
                                    <div class="col-md-1">
                                        <a id="btnAdd" onclick="openAsset()"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> </a>
                                    </div>
                                    <?
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Source Location</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input type="hidden" name="reqSourceId" id="reqSourceId" value="<?=$reqSourceId?>" style="width:100%" />
                                    <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqSourceNama"  id="reqSourceNama" <?=$disabled?> value="<?=$reqSourceNama?>" style="width:100%" readonly />
                                </div>
                                <?
                                if($reqLihat == 1)
                                {}
                                else
                                {
                                    ?>
                                    <div class="col-md-1">
                                        <a id="btnAdd" onclick="openLocation()"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> </a>
                                    </div>
                                    <?
                                }
                                ?>
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

function submitForm(){
    
    $('#ff').form('submit',{
        url:'json-app/area_assessment_json/add',
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

function openArea(id)
{
    openAdd('app/loadUrl/app/lookup_area_multi?reqId='+id);
}

function openDistrik(id)
{
    openAdd('app/loadUrl/app/lookup_distrik_multi?reqId='+id);
}  

function openAsset()
{
    // openAdd('app/index/lookup_asset');
}

function openLocation()
{
    // openAdd('app/index/lookup_asset');
}

function setArea(values)
{
    // console.log(values);
    $('#reqAreaId').val(values.AREA_ID);
    $('#reqAreaNama').val(values.NAMA);
}

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
    urllink= "app/loadUrl/app/template_area";
    method= "POST";
    batas= id.length;
    if(index < batas)
    {
        AREA_ID= id[index];
        NAMA= multiinfonama[index];

        var rv = true;

        if (rv == true) 
        {
            $.ajax({
                url: urllink,
                method: method,
                data: {
                    reqAreaId: AREA_ID,
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


function addmultidistrik(id, multiinfonama, IDFIELD) 
{
    batas= id.length;

    if(batas > 0)
    {
        rekursivemultidistrik(0, id, multiinfonama, IDFIELD);
    }
}

function rekursivemultidistrik(index, id, multiinfonama, IDFIELD) 
{
    urllink= "app/loadUrl/app/template_distrik";
    method= "POST";
    batas= id.length;
    if(index < batas)
    {
        DISTRIK_ID= id[index];
        NAMA= multiinfonama[index];

        var rv = true;

        if (rv == true) 
        {
            $.ajax({
                url: urllink,
                method: method,
                data: {
                    reqDistrikId: DISTRIK_ID,
                    reqNama: NAMA
                },
                    // dataType: 'json',
                    success: function (response) {
                        $("#"+IDFIELD).append(response);

                        index= parseInt(index) + 1;
                        rekursivemultidistrik(index,id, multiinfonama, IDFIELD);
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
            rekursivemultidistrik(index,id, multiinfonama, IDFIELD);
        }
    }
}



</script>