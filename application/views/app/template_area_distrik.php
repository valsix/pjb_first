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
$reqListAreaId = $this->input->post("reqListAreaId");
$reqItemAssessmentDuplikatId = $this->input->post("reqItemAssessmentDuplikatId");
$reqAreaUnitDetilId = $this->input->post("reqAreaUnitDetilId");
$reqAreaUnitId = $this->input->post("reqAreaUnitId");


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

if(!empty($reqAreaUnitId))
{
    $statement .=" AND B.AREA_UNIT_ID = ".$reqAreaUnitId;
}

if(!empty($reqAreaUnitDetilId))
{
    $statement .=" AND B.AREA_UNIT_DETIL_ID = ".$reqAreaUnitDetilId;
}

$statement .=" AND NOT  EXISTS 
(
SELECT 1
FROM OUTLINING_ASSESSMENT_DETIL X
WHERE X.ITEM_ASSESSMENT_DUPLIKAT_ID = A1.ITEM_ASSESSMENT_DUPLIKAT_ID
AND X.AREA_UNIT_ID = C.AREA_UNIT_ID AND X.AREA_UNIT_DETIL_ID = B.AREA_UNIT_DETIL_ID
AND X.OUTLINING_ASSESSMENT_ID = ".$reqId."

) ";


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
    $arrdata["NAMA_MESIN"]= $set->getField("NAMA_MESIN");
    $arrdata["BLOK_UNIT_ID"]= $set->getField("BLOK_UNIT_ID");
    $arrdata["NAMA_BLOK"]= $set->getField("NAMA_BLOK");
    array_push($arrset, $arrdata);
}
unset($set);


?>

<?
$z=$reqUniqId;
foreach ($arrset as $key => $value) 
{

    $reqListAreaId=$value["id"];
    $reqItemAssessmentDuplikatId=$value["ITEM_ASSESSMENT_DUPLIKAT_ID"];
    $reqAreaUnitDetilId=$value["AREA_UNIT_DETIL_ID"];
    $reqAreaUnitId=$value["AREA_UNIT_ID"];
    $reqBlokUnitId=$value["BLOK_UNIT_ID"];
    $reqNamaBlok=$value["NAMA_BLOK"];
    $reqNamaMesin=$value["NAMA_MESIN"];

    $setdetil= new OutliningAssessment();
    $statement = " AND A.OUTLINING_ASSESSMENT_ID = '".$reqId."' AND A.LIST_AREA_ID= ".$reqListAreaId." AND A.ITEM_ASSESSMENT_DUPLIKAT_ID= ".$reqItemAssessmentDuplikatId." AND A.AREA_UNIT_DETIL_ID= ".$reqAreaUnitDetilId." ";
    $setdetil->selectByParamsDetil(array(), -1,-1,$statement);
    // echo $setdetil->query;
    $setdetil->firstRow();
    $reqDetilId= $setdetil->getField("OUTLINING_ASSESSMENT_DETIL_ID");

?>
    <tr id="<?=$reqUniqId?>" class="detildistrik">
        <td style="display: none"><?=$reqListAreaId?></td>
        <td style="display: none"><?=$reqItemAssessmentDuplikatId?></td>
        <td style="display: none"><?=$reqAreaUnitDetilId?></td>
        <td style="display: none"><?=$reqAreaUnitId?></td>
        <td style="display: none"><?=$reqBlokUnitId?></td>
        <td style="vertical-align: middle;text-align: center" class="sno"> </td>
        <td> <?=$reqNamaBlok?></td>
        <td> <?=$reqNamaMesin?></td>
        <td >
         
            <label style="width: 350px;font-weight: normal !important;"><?=$value["text"]?></label>
        </td>
        <td>
          
            <label style="font-weight: normal !important;" ><?=$value["AREA_UNIT"]?></label>
        </td>
        <td> 
          
        </td>
        <td> 
        </td>
        <td> 
        </td>
        <td style="display: none">   
            <input class="easyui-validatebox textbox form-control" type="text" name="reqDetilId[]" id="reqDetilId<?=$i?>"   value="" style="width: 500px" >
            <input class="easyui-validatebox textbox form-control" type="text" name="reqListAreaId[]" id="reqListAreaId<?=$i?>"   value="<?=$reqListAreaId?>" style="width: 500px" >
            <input class="easyui-validatebox textbox form-control" type="text" name="reqItemAssessmentDuplikatId[]" id="reqItemAssessmentDuplikatId<?=$i?>"   value="<?=$reqItemAssessmentDuplikatId?>" style="width: 500px" >
            <input class="easyui-validatebox textbox form-control" type="text" name="reqAreaUnitDetilId[]" id="reqAreaUnitDetilId<?=$i?>"   value="<?=$reqAreaUnitDetilId?>" style="width: 500px" >
            <input class="easyui-validatebox textbox form-control" type="text" name="reqAreaUnitId[]" id="reqAreaUnitId<?=$i?>"   value="<?=$reqAreaUnitId?>" style="width: 500px" >
             <input class="easyui-validatebox textbox form-control" type="text" name="reqBlokUnitId[]" id="reqBlokUnitId<?=$i?>"   value="<?=$reqBlokUnitId?>" style="width: 500px" >
        </td>
        <td style="text-align: center;vertical-align: middle;"><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a class='btn-remove' ><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span></td>                                        
    </tr>
<?
$z++;
}
?>
<script type="text/javascript">
    
    $(document).ready(function(){
        var i=1;

        $('.sno').each(function(){
            $(this).text(i);
            i++;
        });
    });


</script>
