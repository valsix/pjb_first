<style type="text/css">* {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}
</style>

<?

$this->load->model("base-app/UnitMesin");

$reqDistrikId = $this->input->get("reqDistrikId");
$reqBlokId = $this->input->get("reqBlokId");


$set= new UnitMesin();
$arrprogram= [];


$statement=" AND A.DISTRIK_ID =".$reqDistrikId;
if(!empty($reqBlokId))
{
  $statement .=" AND A.BLOK_UNIT_ID =".$reqBlokId;

}
$set->selectByParams(array(), -1,-1, $statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("UNIT_MESIN_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrprogram, $arrdata);
}
unset($set);

?>

<select class="form-control jscaribasicmultiple"  id="reqUnitMesinId" <?=$disabled?> name="reqUnitMesinId"  style="width:100%;" >
<?
foreach($arrprogram as $item) 
{
    $selectvalid= $item["id"];
    $selectvaltext= $item["text"];

    ?>
    <option value="<?=$selectvalid?>" <?=$selected?>><?=$selectvaltext?></option>
   <!--  <input autocomplete="off" class="easyui-validatebox textbox form-control" type="hidden" name="reqUnitMesinId[]"  id="reqUnitMesinId" value="<?=$selectvalid?>" style="width:100%" readonly />
    <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqUnitMesinNama"  id="reqUnitMesinNama" value="<?=$selectvaltext?>" style="width:100%" readonly /> -->
    <?
}
?>
</select>



