<?
$this->load->model("base-app/ItemAssessment");
$this->load->model("base-app/ListArea");
$this->load->model("base-app/StandarReferensi");
$this->load->model("base-app/OutliningAssessment");


// $reqBulan = $this->input->get("reqBulan");
$reqId = $this->input->get("reqId");
$reqDetilId = $this->input->get("reqDetilId");
$reqListAreaId = $this->input->get("reqListAreaId");
$reqItemAssessmentDuplikatId = $this->input->get("reqItemAssessmentDuplikatId");
$reqAreaUnitDetilId = $this->input->get("reqAreaUnitDetilId");
$reqAreaUnitId = $this->input->get("reqAreaUnitId");

$reqBulan = $this->input->get("reqBulan");
$reqTahun = $this->input->get("reqTahun");

$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$set= new OutliningAssessment();
$statement = " AND A.OUTLINING_ASSESSMENT_ID = '".$reqId."' ";
$set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
$set->firstRow();

$vstatus= $set->getField("V_STATUS");
// print_r($vstatus);exit;
unset($set);

$reqLihat="";
if($vstatus !== "20")
{
    $reqLihat=1;
}


$set= new ListArea();
$arrlist= [];

$statement=" AND A.STATUS IS NULL AND B.STATUS_KONFIRMASI = 1 ";


if(!empty($reqItemAssessmentDuplikatId))
{
    $statement .=" AND B.ITEM_ASSESSMENT_DUPLIKAT_ID = ".$reqItemAssessmentDuplikatId;
}

if(!empty($reqListAreaId))
{
    $statement .=" AND A.LIST_AREA_ID = ".$reqListAreaId;
}

if(!empty($reqItemAssessmentDuplikatId))
{
    $statement .=" AND A1.ITEM_ASSESSMENT_DUPLIKAT_ID = ".$reqItemAssessmentDuplikatId;
}
$set->selectduplikatfilter(array(), -1,-1,$statement);
$set->firstRow();
$reqAreaDuplikatInfo=$set->getField("KODE_INFO")." - ".$set->getField("NAMA");


$statement =" AND A.STATUS_KONFIRMASI IS NOT NULL ";

if(!empty($reqListAreaId))
{
    $statement .=" AND B.LIST_AREA_ID = ".$reqListAreaId;
}

$set= new ItemAssessment();
$arrformulir= [];
$set->selectByParamsAreaOutline(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("ITEM_ASSESSMENT_FORMULIR_ID");
    $arrdata["text"]=$set->getField("NAMA");
    $arrdata["STANDAR_REFERENSI_ID"]=$set->getField("STANDAR_REFERENSI_ID");
    $arrdata["ITEM_ASSESSMENT_ID"]= $set->getField("ITEM_ASSESSMENT_ID");
   
    array_push($arrformulir, $arrdata);
}
unset($set);

$setarea= new OutliningAssessment();
$statement = " AND A.OUTLINING_ASSESSMENT_DETIL_ID = '".$reqDetilId."'";
$jumlahdetil = $setarea->getCountByParamsAreaDetilStatus(array(), $statement);
// print_r($jumlahdetil);
unset($setarea);

if($reqLihat ==1)
{
    $disabled="disabled";  
}




?>
<style type="text/css">input[type=radio] {
  width: 50px;
  height: 22px;
}</style>
<div class="col-md-12">
    
  <div class="judul-halaman"> Data Item Assessment  </div>

    <div class="konten-area">
        <div class="konten-inner">

            <div>

                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">

                    <div class="page-header" style="background-color: green">
                        <h3><i class="fa fa-file-text fa-lg"></i> Area <?=$reqAreaDuplikatInfo?></h3>       
                    </div>

                    <div style="overflow-y: auto;height: 400px;width: 100%;">
                        <table id="" class="table table-bordered table-striped table-hovered" style="width: 100%;" >
                            <thead >
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Item Assesment</th>
                                    <th class="text-center">Referensi Standar</th>
                                    <th class="text-center">Confirm</th>
                                    <th class="text-center">Not Confirm</th>
                                    <th class="text-center">Keterangan</th>
                                    <th class="text-center" style="width: 20%" >Upload Foto/Gambar</th>
                                    <th class="text-center" style="width: 20%" id="rekom" >Rekomendasi</th>
                                </tr>
                            </thead>
                            <tbody id="outlinedetil">

                                <?
                                $reqUniqId=1;
                                $reqCheckRekom=0;
                                $jmldata=0;
                                foreach ($arrformulir as $key => $value) 
                                {   
                                    $reqItemAssessmentFormulirId= $value["id"];
                                    $reqItemAssessmentId= $value["ITEM_ASSESSMENT_ID"];
                                    $reqItemAssessment= $value["text"];
                                    $reqStandarId= $value["STANDAR_REFERENSI_ID"];

                                    // $setstandar= new StandarReferensi();

                                    
                                    // $setstandar->selectByParamsFilterOutline(array(), -1,-1,$statement);
                                     // echo $set->query;exit;
                                    // $setstandar->firstRow();
                                    // $reqStandar= $setstandar->getField("KODE")." \n ".$setstandar->getField("NAMA")." ".$setstandar->getField("DESKRIPSI");

                                    $setstandar= new StandarReferensi();
                                    $arrstandar= [];
                                    $statement =" AND A.ITEM_ASSESSMENT_FORMULIR_ID= ".$reqItemAssessmentFormulirId." AND A.STANDAR_REFERENSI_ID IN (".$reqStandarId.")";
                                    $setstandar->selectByParamsFilterOutline(array(), -1,-1,$statement);
                                    // echo $setstandar->query;
                                    while($setstandar->nextRow())
                                    {
                                        $arrdata= array();
                                        $arrdata["id"]= $setstandar->getField("STANDAR_REFERENSI_ID");
                                        $arrdata["text"]=$setstandar->getField("KODE")." \n ".$setstandar->getField("NAMA")." ".$setstandar->getField("DESKRIPSI");
                                        array_push($arrstandar, $arrdata);
                                    }
                                    unset($set);

                                    $setdetil= new OutliningAssessment();

                                    $statement =" AND A.OUTLINING_ASSESSMENT_DETIL_ID=".$reqDetilId." AND A.ITEM_ASSESSMENT_DUPLIKAT_ID=".$reqItemAssessmentDuplikatId."  AND A.ITEM_ASSESSMENT_FORMULIR_ID=".$reqItemAssessmentFormulirId."";
                                    $setdetil->selectByParamsAreaDetil(array(), -1,-1,$statement);
                                     // echo $setdetil->query;exit;
                                    $setdetil->firstRow();
                                    $reqConfirm= $setdetil->getField("STATUS_CONFIRM");
                                    // var_dump($reqConfirm);
                                    $reqKeterangan= $setdetil->getField("KETERANGAN");
                                    $reqAreaDetilId= $setdetil->getField("OUTLINING_ASSESSMENT_AREA_DETIL_ID");
                                    $reqFoto= $setdetil->getField("LINK_FOTO");

                                ?>
                                    <tr>
                                        <td style="display: none">
                                            <?=$reqItemAssessmentFormulirId?>
                                            <input class="easyui-validatebox  textbox form-control"  <?=$disabled?> type="hidden" name="reqItemAssessmentFormulirId[]" id="reqItemAssessmentFormulirId<?=$reqUniqId?>"   value="<?=$reqItemAssessmentFormulirId?>"  >
                                        </td>
                                        <td> <?=$reqUniqId?></td>
                                        <td >
                                            <input class="easyui-validatebox textbox form-control" <?=$disabled?> type="hidden" name="reqItemAssessmentId[]" id="reqItemAssessmentId<?=$reqUniqId?>"   value="<?=$reqItemAssessmentId?>"  >
                                           <!--  <textarea class="easyui-validatebox textbox form-control"  style="width: 340px;" disabled ><?=$reqItemAssessment?></textarea> -->
                                            <label style="width: 250px;font-weight: normal !important; text-align: justify;"><?=$reqItemAssessment?></label>
                                        </td>
                                        <td>
                                            <!-- <input class="easyui-validatebox textbox form-control" type="hidden" name="reqStandarId[]" id="reqStandarId<?=$reqUniqId?>"   value="<?=$reqStandarId?>"  > -->
                                            <?
                                            foreach ($arrstandar as $key => $value) {
                                            ?>
                                                <!-- <textarea class="easyui-validatebox textbox form-control"  style="width: 340px;" disabled ><?/*=$value["text"]*/?></textarea> -->
                                                <label style="font-weight: normal !important; text-align: justify;"><?=$value["text"]?></label>
                                                <br>
                                            <?
                                            }
                                            ?>
                                        </td>
                                        <td style="vertical-align:middle;"><input type="radio" name="reqConfirm[<?=$reqUniqId?>]" <?=$disabled?> id="reqConfirm<?=$reqUniqId?>" <? if($reqConfirm=="1") echo 'checked';?> value="1"></td>
                                        <td style="vertical-align:middle;"><input type="radio" name="reqConfirm[<?=$reqUniqId?>]" <?=$disabled?> id="reqConfirm<?=$reqUniqId?>" <? if($reqConfirm=="0") echo 'checked';?> value="0"></td>
                                        <td>  
                                            <textarea  class="easyui-validatebox textbox form-control" style="width: 340px;"  name="reqKeterangan[]" <?=$disabled?>  id="reqKeterangan"><?=$reqKeterangan?></textarea>
                                        </td>
                                        <td  style='white-space: nowrap' >
                                            <input type="file" name="reqFoto[]"  <?=$disabled?>id="reqFoto<?=$reqUniqId?>" accept="image/png, image/jpeg" >
                                            <?
                                            if(!empty($reqFoto))
                                            {
                                                ?>
                                                <a onclick='HapusGambar("<?=$reqAreaDetilId?>","<?=$reqId?>")'><img src="images/delete-icon.png"></a> 
                                                <br>
                                                <a href="<?=$reqFoto?>" target="_blank"><img src="<?=$reqFoto?>" width=200 height=200></a>
                                                <?
                                            }
                                            ?>
                                            <?
                                            if(!empty($reqAreaDetilId))
                                            {
                                            ?>
                                                <!-- <button class="btn btn-danger btn-sm " type="button"  onclick='HapusDetil("<?=$reqAreaDetilId?>","<?=$reqId?>")'>
                                                    <i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a> 
                                                </button> -->
                                            <?
                                            }
                                            ?>
                                        </td>
                                        <td class="checkcon">
                                            <?
                                            if($reqConfirm=="0" && $reqLihat == "")
                                            {
                                                $reqCheckRekom=1;

                                            ?>
                                            <button class="btn btn-success btn-sm " type="button" <?=$disabled?>  onclick='AddRekomendasi("<?=$reqAreaDetilId?>","<?=$reqDetilId?>","<?=$reqId?>")'>
                                                <i class='fa fa-pencil-square-o' style='color: white;' aria-hidden='true'></i></a> 
                                            </button>
                                            <?
                                            }
                                            ?>
                                        </td>

                                        <td style="display: none">   
                                            <input class="easyui-validatebox textbox form-control" type="text" name="reqAreaDetilId[]" id="reqAreaDetilId<?=$reqUniqId?>"   value="<?=$reqAreaDetilId?>" style="width: 500px" >
                                        </td>
                                    </tr>
                                <?
                                $jmldata++;
                                $reqUniqId++;
                                }
                                ?>
                                  
                                
                            </tbody>
                        </table>
                    </div>


                    <input type="hidden" name="reqId" value="<?=$reqId?>" />
                    <input type="hidden" name="reqDetilId" value="<?=$reqDetilId?>" />
                    <input type="hidden" name="reqListAreaId" value="<?=$reqListAreaId?>" />
                    <input type="hidden" name="reqItemAssessmentDuplikatId" value="<?=$reqItemAssessmentDuplikatId?>" />
                    <input type="hidden" name="reqAreaUnitId" value="<?=$reqAreaUnitId?>" />
                    <input type="hidden" name="reqAreaUnitDetilId" value="<?=$reqAreaUnitDetilId?>" />
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
                    <div style="text-align:center;padding:5px">
                    <a href="javascript:void(0)" class="btn btn-warning" onclick="kembali()">Kembali</a>
                    <?
                    if($reqLihat ==1)
                    {}
                    else
                    {
                    ?>
                    
                       
                       <a href="javascript:void(0)" class="btn btn-primary" onclick="submitForm()">Submit</a>
                    
                    <?
                    }
                    ?>
                    </div>

                </form>

            </div>
           
        </div>
    </div>
    
</div>

<script type="text/javascript">

    function kembali()
    {
        // window.location=document.referrer;
        window.open('app/index/outlining_assessment_add?reqId=<?=$reqId?>&reqBulan=<?=$reqBulan?>&reqTahun=<?=$reqTahun?>', '_self'); 
    }

    function HapusDetil(iddetil,reqId) {
        $.messager.confirm('Konfirmasi',"Hapus data terpilih?",function(r){
            if (r){
                $.getJSON("json-app/outlining_assessment_json/deleteareadetil?reqAreaDetilId="+iddetil+"&reqId="+reqId,
                    function(data){
                    // console.log(data);return false;
                    $.messager.alert('Info', data.PESAN, 'info');                    
                    location.reload();
                });
            }
        }); 
    }

     function HapusGambar(iddetil,reqId) {
        $.messager.confirm('Konfirmasi',"Hapus Gambar terpilih?",function(r){
            if (r){
                $.getJSON("json-app/outlining_assessment_json/deleteareadetilgambar?reqAreaDetilId="+iddetil+"&reqId="+reqId,
                    function(data){
                    // console.log(data);return false;
                    $.messager.alert('Info', data.PESAN, 'info');                    
                    location.reload();
                });
            }
        }); 
    }

    function AddRekomendasi(reqAreaDetilId,reqDetilId,reqId)
    {
        // openAdd('iframe/index/outlining_assessment_add_rekomendasi?reqAreaDetilId='+reqAreaDetilId+'&reqDetilId='+reqDetilId+'&reqId='+reqId+'&reqListAreaId='+reqListAreaId+'&reqItemAssessmentDuplikatId='+reqItemAssessmentDuplikatId+'&reqTahun='+reqTahun);
        window.open('app/index/outlining_assessment_rekomendasi?reqAreaDetilId='+reqAreaDetilId+'&reqDetilId='+reqDetilId+'&reqId='+reqId+'&reqKembali=1&reqPage=4', '_self'); 
    } 

$(function() {
    $('#rekom').hide();
    $('.checkcon').hide();
    var reqCheckRekom= '<?=$reqCheckRekom?>';

    if(reqCheckRekom=="1")
    {
       $('#rekom').show();
       $('.checkcon').show();
   }

   // console.log(reqCheckRekom);
});
function submitForm(){
    $('#ff').form('submit',{
        url:'json-app/outlining_assessment_json/adddetil',
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
                // $.messager.alertLink('Info', infoSimpan, 'info', "app/index/outlining_assessment_add_detil?reqId=<?=$reqId?>&reqBulan=<?=$reqBulan?>&reqTahun=<?=$reqTahun?>&reqDetilId=<?=$reqDetilId?>&reqListAreaId=<?=$reqListAreaId?>&reqItemAssessmentDuplikatId=<?=$reqItemAssessmentDuplikatId?>&reqAreaUnitDetilId=<?=$reqAreaUnitDetilId?>&reqAreaUnitId=<?=$reqAreaUnitId?>");
             $.messager.alertLink('Info', infoSimpan, 'info', "app/index/outlining_assessment_add?reqId=<?=$reqId?>&reqBulan=<?=$reqBulan?>&reqTahun=<?=$reqTahun?>");
        }
    });
}

function clearForm(){
    $('#ff').form('clear');
}   
</script>
