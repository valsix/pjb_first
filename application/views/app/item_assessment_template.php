<style type="text/css">* {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}
</style>

<?

$this->load->model("base-app/KategoriItemAssessment");
$this->load->model("base-app/ProgramItemAssessment");
$this->load->model("base-app/KonfirmasiItemAssessment");

$this->load->model("base-app/StandarReferensi");


$reqUniqId = $this->input->get("reqUniqId");



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

$set= new StandarReferensi();
$arrstandar= [];
$set->selectByParams(array(), -1,-1," ");
// echo $set->query;exit;
while($set->nextRow())
{
    $vnama= $set->getField("NAMA");
    $vdeskripsi= $set->getField("DESKRIPSI");
    $arrdata= array();
    $arrdata["id"]= $set->getField("STANDAR_REFERENSI_ID");
    $arrdata["text"]= $vnama;
    $arrdata["desc"]= $vdeskripsi;
    $arrdata["html"]= "<div><b>".$vnama."</b></div><div><small>".$vdeskripsi."</small></div>";
    $arrdata["title"]= $vnama;
    array_push($arrstandar, $arrdata);
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

?>


<div id="border" style="border:1px solid black; " class="tambahitemform">   
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
                    <textarea class="easyui-validatebox textbox form-control" required name="reqNama[]" style="width:100%"></textarea>
                </div>              
            </div>
        </div>
    </div>

    <div class="form-group">  
        <label class="control-label col-md-2">Konfirmasi  </label>
        <div class='col-md-8'>
            <div class='form-group'>
                <div class='col-md-11'>
                   <!--  <select class="form-control jscaribasicmultiple" required id="reqTersedia" <?=$disabled?> name="reqTersedia[]"  style="width:15%;" >
                       <option value="1" >Iya</option>
                       <option value="2" >Tidak</option>
                   </select> -->

                   <select class="form-control jscaribasicmultiple edittext" required id="reqTersedia" <?=$disabled?> name="reqTersedia[]"  style="width:100%;" >
                    <?
                    foreach($arrkonfirmasi as $item) 
                    {
                        $selectvalid= $item["id"];
                        $selectvaltext= $item["text"];
                        $selectvalnilai= $item["NILAI"];

                        $selected="";
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
                    <select class="form-control jscaribasicmultiple" required id="reqStandarId" <?=$disabled?> name="reqProgramId[]"  style="width:100%;" >
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
                        <input type="hidden" name="reqStandarId[]"  id="reqStandarValId<?=$reqUniqId?>">
                        <select class="form-control deskripsiselect jscaribasic<?=$reqUniqId?>" required id="reqStandarId<?=$reqUniqId?>" <?=$disabled?>   style="width:100%;"  multiple>
                        <?
                        foreach($arrstandar as $item) 
                        {
                            $selectvalid= $item["id"];
                            $selectvaltext= $item["text"];
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

    <input type="hidden" name="reqUniqId" value="<?=$reqUniqId?>" />
    <br>
    <br>
</div>


<link href="assets/select2/select2.min.css" rel="stylesheet" />
<script src="assets/select2/select2.min.js"></script>
<link href="assets/select2totreemaster/src/select2totree.css" rel="stylesheet">
<script src="assets/select2totreemaster/src/select2totree.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.jscaribasic<?=$reqUniqId?>').select2();
    });

    $('#reqStandarId<?=$reqUniqId?>').change(function() {

        var result= $(this).val();

        if(result !=='')
        {
             var str1 = result.toString();
             $('#reqStandarValId<?=$reqUniqId?>').val(str1);   
        } 
       
    });

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
</script>


