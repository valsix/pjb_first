<?

$this->load->model("base-app/ListArea");
$this->load->model("base-app/OutliningAssessment");



$reqId = $this->input->get("reqId");
$reqUniqId = $this->input->get("reqUniqId");
$reqDetilId = $this->input->get("reqDetilId");
$reqDistrikId =  $this->input->get('reqDistrikId');
$reqTahun = $this->input->get("reqTahun");

$reqBlokId =  $this->input->get('reqBlokId');
$reqUnitMesinId =  $this->input->get('reqUnitMesinId');
$reqListAreaId = $this->input->get("reqListAreaId");
$reqItemAssessmentDuplikatId = $this->input->get("reqItemAssessmentDuplikatId");
$reqAreaUnitDetilId = $this->input->get("reqAreaUnitDetilId");
$reqAreaUnitId = $this->input->get("reqAreaUnitId");


$statement="  ";

if(!empty($reqDistrikId))
{
    $statement .=" AND C.DISTRIK_ID = ".$reqDistrikId;
}

if(!empty($reqBlokId))
{
    $statement .=" AND C.BLOK_UNIT_ID = ".$reqBlokId;
}

if(!empty($reqUnitMesinId))
{
    $statement .=" AND C.UNIT_MESIN_ID = ".$reqUnitMesinId;
}
else
{
    // $statement .=" AND 1=2 ";
}

if(!empty($reqListAreaId))
{
    $statement .=" AND B.LIST_AREA_ID = ".$reqListAreaId;
}

if(!empty($reqItemAssessmentDuplikatId))
{
    $statement .=" AND B.ITEM_ASSESSMENT_DUPLIKAT_ID = ".$reqItemAssessmentDuplikatId;
}


$set= new ListArea();
$arrset= [];

$statement .=" AND A.STATUS IS NULL AND B.STATUS_KONFIRMASI = 1 ";
$set->selectduplikatfilter(array(), -1,-1,$statement);
        // echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("LIST_AREA_ID");
    $arrdata["text"]=$set->getField("KODE_INFO")." - ".$set->getField("NAMA");
    $arrdata["ITEM_ASSESSMENT_DUPLIKAT_ID"]= $set->getField("ITEM_ASSESSMENT_DUPLIKAT_ID");
    $arrdata["AREA_UNIT"]= $set->getField("AREA_UNIT");
    $arrdata["STATUS_CONFIRM"]= $set->getField("STATUS_CONFIRM");
    $arrdata["DESKRIPSI"]= $set->getField("DESKRIPSI");
    $arrdata["AREA_UNIT_DETIL_ID"]= $set->getField("AREA_UNIT_DETIL_ID");
    $arrdata["AREA_UNIT_ID"]= $set->getField("AREA_UNIT_ID");
    array_push($arrset, $arrdata);
}
unset($set);


?>

<?
$i=1;
foreach ($arrset as $key => $value) 
{

    $reqListAreaId=$value["id"];
    $reqItemAssessmentDuplikatId=$value["ITEM_ASSESSMENT_DUPLIKAT_ID"];
    $reqAreaUnitDetilId=$value["AREA_UNIT_DETIL_ID"];
    $reqAreaUnitId=$value["AREA_UNIT_ID"];

    $setdetil= new OutliningAssessment();
    $statement = " AND A.OUTLINING_ASSESSMENT_ID = '".$reqId."' AND A.LIST_AREA_ID= ".$reqListAreaId." AND A.ITEM_ASSESSMENT_DUPLIKAT_ID= ".$reqItemAssessmentDuplikatId." AND A.AREA_UNIT_DETIL_ID= ".$reqAreaUnitDetilId." ";
    $setdetil->selectByParamsDetil(array(), -1,-1,$statement);

                                            // echo $setdetil->query;
    $setdetil->firstRow();
    $reqDetilId= $setdetil->getField("OUTLINING_ASSESSMENT_DETIL_ID");

?>
    <tr id="<?=$i?>">
        <td> <?=$i?></td>
        <td onclick='detilform("<?=$reqId?>","<?=$reqTahun?>","<?=$reqDetilId?>","<?=$reqListAreaId?>","<?=$reqItemAssessmentDuplikatId?>","<?=$reqTahun?>");'>
            <input class="easyui-validatebox textbox form-control" type="hidden" name="reqListAreaId[]" id="reqListAreaId<?=$i?>"   value="<?=$reqListAreaId?>"  >
            <input class="easyui-validatebox textbox form-control" type="hidden" name="reqItemAssessmentDuplikatId[]" id="reqItemAssessmentDuplikatId<?=$i?>"   value="<?=$reqItemAssessmentDuplikatId?>"  >
           
            <label style="width: 350px;font-weight: normal !important;"><?=$value["text"]?></label>
        </td>
        <td>
            <input class="easyui-validatebox textbox form-control" type="hidden" name="reqAreaUnitDetilId[]" id="reqAreaUnitDetilId<?=$i?>"   value="<?=$reqAreaUnitDetilId?>"  >
            <input class="easyui-validatebox textbox form-control" type="hidden" name="reqAreaUnitId[]" id="reqAreaUnitId<?=$i?>"   value="<?=$reqAreaUnitId?>"  >
           <!--  <input class="easyui-validatebox textbox form-control" type="text" name="reqNama[]" id="reqNama<?=$i?>" disabled  value="<?/*=$value["AREA_UNIT"] */?>" style="width: 500px" > -->
            <label style="font-weight: normal !important;" ><?=$value["AREA_UNIT"]?></label>
        </td>
        <td> 
            <!-- <textarea class="easyui-validatebox textbox form-control"  style="width: 340px;" disabled name="reqDeskripsi[]"  id="reqDeskripsi<?=$i?>"><?/*=$value["DESKRIPSI"]*/?></textarea> -->
            <label style="font-weight: normal !important;" ><?=$value["DESKRIPSI"]?></label>
        </td>
        <td> 
        </td>
        <td style="display: none">   
            <input class="easyui-validatebox textbox form-control" type="text" name="reqDetilId[]" id="reqDetilId<?=$i?>"   value="" style="width: 500px" >
        </td>                                        
    </tr>
<?
$i++;
}
?>

