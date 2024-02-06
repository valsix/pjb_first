<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/OutliningAssessment");
$this->load->model("base-app/Distrik");
$this->load->model("base-app/Crud");
$this->load->model("base-app/StatusRekomendasi");



$appuserkodehak= $this->appuserkodehak;


$arrBulan=setBulanLoop();
$arrTahun= setTahunLoop(1,1);

$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");
$reqDetilId = $this->input->get("reqDetilId");
$reqAreaDetilId = $this->input->get("reqAreaDetilId");
$reqDistrikId = $this->input->get("reqDistrikId");
$reqBlokId = $this->input->get("reqBlokId");
$reqKembali = $this->input->get("reqKembali");
$reqPage = $this->input->get("reqPage");

$set= new OutliningAssessment();
$arrdetil= [];

$statement=" AND B.DISTRIK_ID=".$reqDistrikId." AND B.BLOK_UNIT_ID=".$reqBlokId." AND A.OUTLINING_ASSESSMENT_ID=".$reqId;
if(!empty($reqDetilId))
{
    $statement.=" AND A.OUTLINING_ASSESSMENT_DETIL_ID=".$reqDetilId;
}
$set->selectByParamsAssessmentDetil(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("OUTLINING_ASSESSMENT_DETIL_ID");
    $arrdata["LIST_AREA_ID"]= $set->getField("LIST_AREA_ID");
    $arrdata["ITEM_ASSESSMENT_DUPLIKAT_ID"]= $set->getField("ITEM_ASSESSMENT_DUPLIKAT_ID");
    $arrdata["AREA"]=$set->getField("KODE_INFO") ." - ".$set->getField("NAMA");;
   
    array_push($arrdetil, $arrdata);
}
unset($set);
// echo $set->query;exit;

$set= new OutliningAssessment();

$statement=" AND A.OUTLINING_ASSESSMENT_AREA_DETIL_ID=".$reqAreaDetilId;
$set->selectByParamsAreaDetil(array(), -1,-1,$statement);
// echo $set->query;exit;

$set->firstRow();
$reqDistrikId= $set->getField("DISTRIK_ID");
$reqDistrikNama= $set->getField("DISTRIK_NAMA");
$reqBlokId= $set->getField("BLOK_UNIT_ID");
$reqBlokNama= $set->getField("BLOK_NAMA");
$reqItemAssessmentNama= $set->getField("ITEM_ASSESSMENT_INFO");
$reqKeterangan= $set->getField("KETERANGAN");

$set= new OutliningAssessment();

$statement=" AND A.OUTLINING_ASSESSMENT_AREA_DETIL_ID=".$reqAreaDetilId;
$set->selectByParamsAreaDetil(array(), -1,-1,$statement);
// echo $set->query;exit;

$set->firstRow();
$reqDistrikId= $set->getField("DISTRIK_ID");
$reqDistrikNama= $set->getField("DISTRIK_NAMA");
$reqBlokId= $set->getField("BLOK_UNIT_ID");
$reqBlokNama= $set->getField("BLOK_NAMA");
$reqItemAssessmentNama= $set->getField("ITEM_ASSESSMENT_INFO");

$set= new OutliningAssessment();
$arrareadetil= [];
$statement=" AND A.STATUS_CONFIRM=0 AND A.OUTLINING_ASSESSMENT_DETIL_ID=".$reqDetilId;

if(!empty($reqAreaDetilId))
{
    $statement.=" AND A.OUTLINING_ASSESSMENT_AREA_DETIL_ID=".$reqAreaDetilId;
}

$set->selectByParamsAreaDetilRekomendasi(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("OUTLINING_ASSESSMENT_AREA_DETIL_ID");
    $arrdata["OUTLINING_ASSESSMENT_REKOMENDASI_ID"]= $set->getField("OUTLINING_ASSESSMENT_REKOMENDASI_ID");
    $arrdata["KETERANGAN"]= $set->getField("KETERANGAN");
    $arrdata["STATUS_REKOMENDASI_ID"]= $set->getField("STATUS_REKOMENDASI_ID");
    $arrdata["TIPE_REKOMENDASI"]= $set->getField("TIPE_REKOMENDASI");
    $arrdata["STATUS_REKOMENDASI"]= $set->getField("STATUS_REKOMENDASI");
    array_push($arrareadetil, $arrdata);
}
unset($set);



unset($set);

$set= new StatusRekomendasi();
$arrstatus= [];
$statement=" AND A.STATUS IS NULL ";
$set->selectByParams(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("STATUS_REKOMENDASI_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrstatus, $arrdata);
}
unset($set);


$set= new OutliningAssessment();
$statement="";

if(empty($reqAreaDetilId))
{
    if(!empty($reqDetilId))
    {
       $statement.=" AND A.OUTLINING_ASSESSMENT_DETIL_ID=".$reqDetilId;

    }
}
else
{
     $statement.=" AND A.OUTLINING_ASSESSMENT_AREA_DETIL_ID=".$reqAreaDetilId;
}

$set->selectByParamsTotalAreaRekomendasi(array(), -1,-1,$statement);
// echo $set->query;exit;

$set->firstRow();
$reqAreaPersen= $set->getField("PERSEN");

$set= new Crud();
$statement=" AND KODE_MODUL ='1001'";
// $statement=" ";

$kode= $appuserkodehak;
$set->selectByParamsMenus(array(), -1, -1, $statement, $kode);
// echo $set->query;exit;
$set->firstRow();
$reqMenu= $set->getField("MENU");
$reqCreate= $set->getField("MODUL_C");
$reqRead= $set->getField("MODUL_R");
$reqUpdate= $set->getField("MODUL_U");
$reqDelete= $set->getField("MODUL_D");

// print_r($arrjenisrekomendasi);exit;
$disabled="";

if($reqLihat==1 || $reqRead==1)
{
    $disabled="disabled";
}

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

/****/
#reqDeskripsi,
#reqKeterangan {
    width: 340px;
}

table { width: 50% }
tbody tr:hover.selected td,
tbody tr:hover td {
  background-color: #fbfdb3;
  cursor: pointer;
}

</style>


<div class="col-md-12">
    
  <div class="judul-halaman"> Data Rekomendasi </div>

    <div class="konten-area">
        <div class="konten-inner">

            <div>

                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data" autocomplete="off">

                    <?
                    if($reqPage==1)
                    {
                    ?>
                        <div class="page-header" style="background-color: green">
                            <h3><i class="fa fa-file-text fa-lg"></i> Periode Assessment <?=$reqItemAssessmentNama?></h3>       
                        </div>

                        <div style="overflow-y: auto;height: 100%;width: 100%;">
                            <table id="" class="table table-bordered table-striped table-hovered" style="width: 100%;" >
                                <thead >
                                    <tr>
                                        <th class="text-center">Distrik</th>
                                        <th class="text-center">Blok Unit</th>
                                        <th class="text-center" style="width: 20%">Status</th>
                                        <th class="text-center" style="width: 10%">% Penyelesaian</th>
                                    </tr>
                                </thead>
                                <tbody >
                                    <tr class="distrik" >
                                        <td style="display: none"><?=$reqDistrikId?></td>
                                        <td style="display: none"><?=$reqBlokId?></td>
                                        <td><label style="font-weight: normal !important;"><?=$reqDistrikNama?></label></td>
                                        <td><label style="font-weight: normal !important;"><?=$reqBlokNama?></label></td>
                                        <td>Belum Selesai</td>
                                        <td>0%</td>                                          
                                    </tr> 
                                </tbody>
                            </table>
                        </div>
                    <?
                    }
                    else  if($reqPage==2)
                    {
                    ?>
                            <div class="page-header" style="background-color: green">
                                <h3><i class="fa fa-file-text fa-lg"></i> Area Assessment <?=$reqDistrikNama?></h3>       
                            </div>

                            <div style="overflow-y: auto;height: 100%;width: 100%;">
                                <table id="" class="table table-bordered table-striped table-hovered" style="width: 100%;" >
                                    <thead >
                                        <tr>
                                            <th class="text-center">Area</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center" style="width: 10%">% Penyelesaian</th>
                                        </tr>  
                                    </thead>
                                    <tbody >
                                        <?
                                        foreach ($arrdetil as $key => $value) 
                                        {
                                        ?>
                                        <tr class="area" >
                                            <td style="display: none"><?=$value["LIST_AREA_ID"]?></td>
                                            <td style="display: none"><?=$value["ITEM_ASSESSMENT_DUPLIKAT_ID"]?></td>
                                            <td><label style="font-weight: normal !important;"><?=$value["AREA"]?></label></td>
                                            <td>Belum Selesai</td>
                                            <td><?=$reqAreaPersen?> %</td>
                                                                                       
                                        </tr>
                                        <?
                                        }
                                        ?> 
                                    </tbody>
                                </table>
                            </div>
                    <?
                    }
                    else if($reqPage==3)
                    {
                    ?>

                        <div class="page-header" style="background-color: green">
                            <h3><i class="fa fa-file-text fa-lg"></i> Rekomendasi Assessment <?=$reqAreaNama?></h3>       
                        </div>

                        <div style="overflow-y: auto;height: 100%;width: 100%;">
                            <table id="" class="table table-bordered table-striped table-hovered" style="width: 100%;" >
                                <thead >
                                    <tr>
                                        <th class="text-center">Keterangan</th>
                                        <th class="text-center" style="width: 20%;">Status Rekomendasi</th>
                                        <th class="text-center" style="width: 20%;">Tipe Rekomendasi</th>
                                    </tr>
                                </thead>
                                <tbody >
                                    <?
                                    foreach ($arrareadetil as $key => $value) 
                                    {

                                        // var_dump($value["id"]);
                                        ?>
                                        <tr class="detil" >
                                            <td style="display: none"><?=$value["OUTLINING_ASSESSMENT_AREA_DETIL_ID"]?></td>
                                            <td><label style="font-weight: normal !important;"><?=$value["KETERANGAN"]?></label></td>
                                            <td>
                                                <select  class="form-control jscaribasicmultiple"  name="reqStatusRekomendasi[]">
                                                    <option value="">Pilih Status Rekomendasi</option>
                                                    <?
                                                    foreach ($arrstatus as $keys => $val) 
                                                    {
                                                        $selected="";
                                                        if($value["STATUS_REKOMENDASI_ID"]==$val['id'])
                                                        {
                                                            $selected="selected";
                                                        }

                                                        ?>

                                                        <option value="<?=$val['id']?>" <?=$selected?>><?=$val['text']?></option>
                                                        <?
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select  class="form-control jscaribasicmultiple"  name="reqTipeRekomendasi[]">
                                                    <option value="">Pilih Tipe Rekomendasi</option>
                                                    <option value="1" <? if($value["TIPE_REKOMENDASI"] == 1) echo 'selected'?>>Baru</option>
                                                    <option value="2" <? if($value["TIPE_REKOMENDASI"] == 2) echo 'selected'?>>Lama</option>
                                                </select>
                                            </td>
                                            <td style="display: none">
                                                <input class="easyui-validatebox textbox form-control" type="text" name="reqAreaDetilId[]" id="reqAreaDetilId"   value="<?=$value["id"]?>" style="width: 500px" > 
                                                <input class="easyui-validatebox textbox form-control" type="text" name="reqRekomendasiId[]" id="reqRekomendasiId"   value="<?=$value["OUTLINING_ASSESSMENT_REKOMENDASI_ID"]?>" style="width: 500px" >
                                            </td>                                      
                                        </tr>
                                        <?
                                    }
                                    ?> 
                                </tbody>
                            </table>
                        </div>

                    <?
                    }
                    else
                    {
                    ?>
                        <div class="page-header" style="background-color: red;text-align: center;">
                            <h3> Data Tidak Ada</h3>       
                        </div>
                    <?
                    }
                    ?>

                    <input type="hidden" name="reqId" value="<?=$reqId?>" />
                    <input type="hidden" name="reqDetilId" value="<?=$reqDetilId?>" />


                </form>

            </div>
            <?
            // var_dump($reqCreate);
            if($reqLihat ==1 || $reqCreate =="" )
            {}
            else
            {
            ?>
            <div style="text-align:center;padding:5px">
                <?
                if($reqKembali ==1)
                {
                ?>
                    <a href="javascript:void(0)" class="btn btn-warning" onclick="kembali()">Kembali</a>
                <?
                }
                ?>

                <?
                if($reqPage ==3)
                {
                ?>
                    <a href="javascript:void(0)" class="btn btn-primary" onclick="submitForm()">Submit</a>

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

$('tr').dblclick(function(){
    var id = $(this).attr('class');
    var reqDistrikId= reqBlokUnitId="";
    var reqAreaId="";
    var reqAreaDuplikatId="";
    var reqPage="<?=$reqPage?>";
    if(id=="distrik")
    {
       var reqDistrikId= jQuery(".distrik").find("td:eq(0)").text();
       var reqBlokId= jQuery(".distrik").find("td:eq(1)").text();
       var reqPage="2";
    }
    else
    {
       var reqDistrikId= "<?=$reqDistrikId?>";
       var reqBlokId= "<?=$reqBlokId?>";
    }

    if(id=="area")
    {
       var reqAreaDuplikatId= jQuery(".area").find("td:eq(0)").text();
       var reqAreaId= jQuery(".area").find("td:eq(1)").text();
       var reqPage="3";
    }
    else
    {
       var reqAreaDuplikatId= "<?=$reqAreaDuplikatId?>";
       var reqAreaId= "<?=$reqAreaId?>";
    }
   
    window.open('app/index/outlining_assessment_add_rekomendasi?reqAreaDetilId=<?=$reqAreaDetilId?>&reqDetilId=<?=$reqDetilId?>&reqId=<?=$reqId?>&reqKembali=<?=$reqKembali?>&reqPage='+reqPage+'&reqDistrikId='+reqDistrikId+'&reqBlokId='+reqBlokId+'&reqAreaDuplikatId='+reqAreaDuplikatId+'&reqAreaId='+reqAreaId, '_self'); 
});

function kembali()
{
    history.back();
}

function submitForm(){
    
    $('#ff').form('submit',{
        url:'json-app/outlining_assessment_json/addrekomendasinew',
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
                // $.messager.alertLink('Info', infoSimpan, 'info', "app/index/outlining_assessment_add_rekomendasi?reqRekomendasiId="+reqId+"&reqAreaDetilId=<?=$reqAreaDetilId?>&reqDetilId=<?=$reqDetilId?>&reqId=<?=$reqId?>&reqKembali=<?=$reqKembali?>&reqPage=<?=$reqPage?>&reqDistrikId=<?=$reqDistrikId?>&reqBlokId=<?=$reqBlokId?>&reqAreaDuplikatId=<?=$reqAreaDuplikatId?>&reqAreaId=<?=$reqAreaId?>");
            $.messager.alert('Info', infoSimpan, 'info');
            location.reload();
        }
    });
}

function clearForm(){
    $('#ff').form('clear');
} 

    
</script>