<style type="text/css">* {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}
</style>

<?

$this->load->model("base-app/BlokUnit");

$reqDistrikId = $this->input->get("reqDistrikId");


$set= new BlokUnit();
$arrstandar= [];
$set->selectByParams(array(), -1,-1," AND A.DISTRIK_ID =".$reqDistrikId);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("BLOK_UNIT_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrstandar, $arrdata);
}
unset($set);


?>


<select class="form-control jscaribasicmultiple"  id="reqBlokId" <?=$disabled?> name="reqBlokId"  style="width:100%;" >
  <?
  foreach($arrstandar as $item) 
  {
    $selectvalid= $item["id"];
    $selectvaltext= $item["text"];

    ?>

     <!-- <input autocomplete="off" class="easyui-validatebox textbox form-control" type="hidden" name="reqBlokId[]"  id="reqBlokId" value="<?=$selectvalid?>" style="width:100%" readonly />
      <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqBlokNama"  id="reqBlokNama" value="<?=$selectvaltext?>" style="width:100%" readonly /> -->

    <option value="<?=$selectvalid?>" <?=$selected?>><?=$selectvaltext?></option>

    <?
  }
  ?>
</select>

<script type="text/javascript">
  $('#reqBlokId').on('change', function() {
    // console.log(1);

    $("#unit").empty();
    var reqDistrikId= $("#reqDistrikId").val();
    $.get("app/loadUrl/app/unit_mesin_template?reqDistrikId="+reqDistrikId+"&reqBlokId="+this.value, function(data) { 
        $("#unit").append(data);
    });
});

</script>
