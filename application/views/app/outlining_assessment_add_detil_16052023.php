<?

$this->load->model("base-app/ListArea");
$this->load->model("base-app/StandarReferensi");
$this->load->model("base-app/ItemAssessment");
$this->load->model("base-app/KategoriItemAssessment");

$reqUniqId = $this->input->get("reqUniqId");
$reqDistrikId = $this->input->get("reqDistrikId");
$reqBlokId = $this->input->get("reqBlokId");
$reqUnitMesinId = $this->input->get("reqUnitMesinId");

$statementarea="  ";

if(!empty($reqDistrikId))
{
    $statementarea .=" AND C.DISTRIK_ID = ".$reqDistrikId;
}

if(!empty($reqBlokId))
{
    $statementarea .=" AND C.BLOK_UNIT_ID = ".$reqBlokId;
}

if(!empty($reqUnitMesinId))
{
    $statementarea .=" AND C.UNIT_MESIN_ID = ".$reqUnitMesinId;
}


$set= new ListArea();
$arrlist= [];

$statementarea .=" AND A.STATUS IS NULL AND B.STATUS_KONFIRMASI = 1 ";
$set->selectduplikatfilter(array(), -1,-1,$statementarea);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("LIST_AREA_ID");
    $arrdata["text"]=$set->getField("KODE_INFO")." - ".$set->getField("NAMA");
    $arrdata["ITEM_ASSESSMENT_DUPLIKAT_ID"]= $set->getField("ITEM_ASSESSMENT_DUPLIKAT_ID");
    $arrdata["AREA_UNIT"]= $set->getField("AREA_UNIT");
    $arrdata["STATUS_CONFIRM"]= $set->getField("STATUS_CONFIRM");
    array_push($arrlist, $arrdata);
}

unset($set);


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
    $arrdata["text"]= $vnama;
    $arrdata["desc"]= $vdeskripsi;
    $arrdata["html"]= "<div><b>".$vkode."</b></div><div><small>".$vdeskripsi."</small></div>";
    $arrdata["title"]= $vnama;
    array_push($arrstandar, $arrdata);
}
unset($set);


$set= new KategoriItemAssessment();
$arrkategori= [];
$set->selectByParamsAreaFilter(array(), -1,-1,"  ");
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata["id"]= $set->getField("KATEGORI_ITEM_ASSESSMENT_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrkategori, $arrdata);
}
unset($set);

$set= new ItemAssessment();
$arrformulir= [];
$set->selectByParamsFormulir(array(), -1,-1,"  ");
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
    array_push($arrformulir, $arrdata);
}
unset($set);


?>

<tr>
    <td> <?=$reqUniqId?></td>
    <td>
        <select class="form-control jscaribasicmultiple" required id="reqListAreaId<?=$reqUniqId?>" <?=$disabled?> name="reqListAreaId[]"  style="width:300px;"   >
            <option value="" >Pilih Area </option>
            <?
            foreach($arrlist as $item) 
            {
                $selectvalid= $item["id"];
                $selectvalidduplikat= $item["ITEM_ASSESSMENT_DUPLIKAT_ID"];
                $selectvaltext= $item["text"];

                $selected="";
                if($selectvalid == $reqListAreaId)
                {
                    $selected="selected";
                }
                ?>
                <option value="<?=$selectvalid?>-<?=$selectvalidduplikat?>" <?=$selected?>><?=$selectvaltext?></option>
                <?
            }
            ?>
        </select>
    </td>
    <td>
        <input class="easyui-validatebox textbox form-control" type="text" name="reqNama[]" id="reqNama<?=$reqUniqId?>" disabled  value="" style="width: 500px" >
    </td>
    <td> 
        <textarea class="easyui-validatebox textbox form-control"  style="width: 340px;" disabled name="reqDeskripsi[]"  id="reqDeskripsi<?=$reqUniqId?>"></textarea>
    </td>
    <td>
           <select class="form-control jscaribasicmultiple" required id="reqKategoriItemAssessment<?=$reqUniqId?>" <?=$disabled?> name="reqKategoriItemAssessment[]"   style="width:100%;"  >
            <?
            foreach($arrkategori as $item) 
            {
                $selectvalid= $item["id"];
                $selectvaltext= $item["text"];

                $selected="";
                if( in_array($selectvalid, $reqKategoriItemAssessment))
                {
                    $selected="selected";
                }
                ?>
                <option value="<?=$selectvalid?>" <?=$selected?>><?=$selectvaltext?></option>
                <?
            }
            ?>
        </select>
    </td>
    <td> 
        <select class="form-control jscaribasicmultiple"  required id="reqFormulirId<?=$reqUniqId?>" <?=$disabled?> name="reqFormulirId[]"  style="width:100%;"  >
            <?
            foreach($arrformulir as $item) 
            {
                $selectvalid= $item["id"];
                $selectvaltext= $item["text"];

                $selected="";
                if( in_array($selectvalid, $reqFormulirId))
                {
                    $selected="selected";
                }
                ?>
                <option value="<?=$selectvalid?>" <?=$selected?>><?=$selectvaltext?></option>
                <?
            }
            ?>
        </select>
    </td>
    <td>
        <select class="form-control deskripsiselect<?=$reqUniqId?> jscaribasic<?=$reqUniqId?>" name="reqStandarId[]" required id="reqStandarId<?=$reqUniqId?>" <?=$disabled?>   style="width:500px;vertical-align: middle;" >
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
    </td>
    <td style="
    transform: scale(1.7) translateX(7%); z-index: 1;
    transform-origin: top left;"><input type="radio" name="reqConfirm[<?=$reqUniqId?>]" id="reqConfirm<?=$reqUniqId?>" value="1"></td>
    <td style="
    transform: scale(1.7) translateX(7%); z-index: 1;
    transform-origin: top left;"><input type="radio" name="reqConfirm[<?=$reqUniqId?>]" id="reqConfirm<?=$reqUniqId?>" value="0"></td>
    <td>  
        <textarea class="easyui-validatebox textbox form-control" style="width: 340px;"  name="reqKeterangan[]"  id="reqKeterangan"></textarea>
    </td>
</tr>

<script type="text/javascript">

$(document).ready(function() {
        $('.jscaribasic<?=$reqUniqId?>').select2();
    });



$(document).ready(function() {
    $('.jscaribasicmultiple').select2();
});


$("#reqKategoriItemAssessment<?=$reqUniqId?> option").remove();
$("#reqKategoriItemAssessment<?=$reqUniqId?>").append('<option value="" >Pilih Item Assessment</option>');
$("#reqFormulirId<?=$reqUniqId?> option").remove();
$("#reqFormulirId<?=$reqUniqId?>").append('<option value="" >Pilih Item Assessment</option>');
$("#reqStandarId<?=$reqUniqId?> option").remove();
// $("#reqStandarId<?=$reqUniqId?>").append('<option value="" >Pilih Standar Referensi</option>');


$('#reqListAreaId<?=$reqUniqId?>').on('change', function() {
    var reqDistrikId= $("#reqDistrikId").val();
    var reqBlokId= $("#reqBlokId").val();
    var reqUnitMesinId= $("#reqUnitMesinId").val();
    var reqAreaId = $(this).val();
    var str = reqAreaId.split('-');
    var reqListAreaId=str[0];
    var reqItemAssessmentDuplikatId=str[1];
    // console.log(reqListAreaId);
    $.getJSON("json-app/outlining_assessment_json/filter_area?reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId+"&reqUnitMesinId="+reqUnitMesinId+"&reqListAreaId="+reqListAreaId+"&reqItemAssessmentDuplikatId="+reqItemAssessmentDuplikatId,
        function(data)
        {
            // console.log(reqAreaDuplikatId);
            jQuery(data).each(function(i, item){
                $("#reqNama<?=$reqUniqId?>").val(item.AREA_UNIT);
                $("#reqDeskripsi<?=$reqUniqId?>").val(item.DESKRIPSI);
            });

             $.getJSON("json-app/outlining_assessment_json/filter_kategori?reqListAreaId="+reqListAreaId,
                function(datax)
                {
                   $("#reqKategoriItemAssessment<?=$reqUniqId?> option").remove();
                   $("#reqKategoriItemAssessment<?=$reqUniqId?>").append('<option value="" >Pilih Item Assessment</option>');
                   jQuery(datax).each(function(x, itemx){
                    $("#reqKategoriItemAssessment<?=$reqUniqId?>").append('<option value="'+itemx.id+'" >'+itemx.text+'</option>');
                    });
                });

            $("#reqFormulirId<?=$reqUniqId?> option").remove();
            $("#reqFormulirId<?=$reqUniqId?>").append('<option value="" >Pilih Item Assessment</option>');
            $("#reqStandarId<?=$reqUniqId?> option").remove();
            // $("#reqStandarId<?=$reqUniqId?>").append('<option value="" >Pilih Standar Referensi</option>');
        });
});

$('#reqKategoriItemAssessment<?=$reqUniqId?>').on('change', function() {
    var reqAreaId = $("#reqListAreaId<?=$reqUniqId?>").val();
    var str = reqAreaId.split('-');
    var reqListAreaId=str[0];
    var reqItemAssessmentDuplikatId=str[1];
    var reqKategoriItemAssessmentId= $(this).val();
    // console.log(reqListAreaId);

    $.getJSON("json-app/outlining_assessment_json/filter_item?reqListAreaId="+reqListAreaId+"&reqKategoriItemAssessmentId="+reqKategoriItemAssessmentId,
        function(datax)
        {
            $("#reqFormulirId<?=$reqUniqId?> option").remove();
            $("#reqFormulirId<?=$reqUniqId?>").append('<option value="" >Pilih Item Assessment</option>');
            jQuery(datax).each(function(x, itemx){
                $("#reqFormulirId<?=$reqUniqId?>").append('<option value="'+itemx.id+'" >'+itemx.text+'</option>');
            });
            $("#reqStandarId<?=$reqUniqId?> option").remove();
            // $("#reqStandarId<?=$reqUniqId?>").append('<option value="" >Pilih Standar Referensi</option>');
        });
  
});

$('#reqFormulirId<?=$reqUniqId?>').on('change', function() {
    var reqAreaId = $("#reqListAreaId<?=$reqUniqId?>").val();
    var str = reqAreaId.split('-');
    var reqListAreaId=str[0];
    var reqItemAssessmentDuplikatId=str[1];
    var reqKategoriItemAssessmentId= $("#reqKategoriItemAssessment<?=$reqUniqId?>").val();
    var reqFormulirId= $(this).val();
    // console.log(reqListAreaId);

    $.getJSON("json-app/outlining_assessment_json/filter_standar?reqListAreaId="+reqListAreaId+"&reqKategoriItemAssessmentId="+reqKategoriItemAssessmentId+"&reqFormulirId="+reqFormulirId,
        function(datax)
        {
            $("#reqStandarId<?=$reqUniqId?> option").remove();
            jQuery(datax).each(function(x, itemx){
                $("#reqStandarId<?=$reqUniqId?>").append('<option value="'+itemx.id+'" title="'+itemx.DESKRIPSI+'"  >'+itemx.text+'</option>');

            });

            getarrstandar= datax;
            $(".deskripsiselect<?=$reqUniqId?>").select2({
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
        });
});

function matcher(params, data) {

    if ($.trim(params.term) === '') {
        return data;
    }

    if (typeof data.text === 'undefined') {
        return null;
    }

    if (data.text.toLowerCase().indexOf(params.term.toLowerCase()) > -1 || (typeof data.html !== 'undefined' && data.html.toLowerCase().indexOf(params.term.toLowerCase()) > -1)) {
        var modifiedData = $.extend({}, data, true);
        modifiedData.text += ' (matched)';

        return modifiedData;
    }

    return null;
}

</script>