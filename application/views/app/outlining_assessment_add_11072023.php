<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/OutliningAssessment");
$this->load->model("base-app/ListArea");
$this->load->model("base-app/Distrik");
$this->load->model("base-app/StandarReferensi");
$this->load->model("base-app/ItemAssessment");
$this->load->model("base-app/BlokUnit");
$this->load->model("base-app/UnitMesin");
$this->load->model("base-app/KategoriItemAssessment");
$this->load->model("base-app/ProgramItemAssessment");


$arrBulan=setBulanLoop();
$arrTahun= setTahunLoop(2,1);


// print_r($arrBulan);exit;


$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");
$reqBulan = $this->input->get("reqBulan");
$reqTahun = $this->input->get("reqTahun");


$set= new OutliningAssessment();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

    $statement = " AND A.OUTLINING_ASSESSMENT_ID = '".$reqId."' AND A.BULAN = '".$reqBulan."' AND A.TAHUN = '".$reqTahun."'";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("OUTLINING_ASSESSMENT_ID");
    $reqDistrikId= $set->getField("DISTRIK_ID");
    $reqBlokId= $set->getField("BLOK_UNIT_ID");
    $reqUnitMesinId= $set->getField("UNIT_MESIN_ID");
    $reqBulan= $set->getField("BULAN");
    $reqTahun= $set->getField("TAHUN");
    unset($set);

 
    $set= new OutliningAssessment();
    $arrlist= [];

    $statement=" AND A.STATUS IS NULL AND B.STATUS_KONFIRMASI = 1 AND D.OUTLINING_ASSESSMENT_ID = '".$reqId."'    ";

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
        // $statement .=" AND 1=2 = ";
    }

    // if(!empty($reqListAreaId))
    // {
    //     $statement .=" AND B.LIST_AREA_ID = ".$reqListAreaId;
    // }

    // if(!empty($reqItemAssessmentDuplikatId))
    // {
    //     $statement .=" AND B.ITEM_ASSESSMENT_DUPLIKAT_ID = ".$reqItemAssessmentDuplikatId;
    // }

    // if(!empty($reqListAreaId))
    // {
    //     $statement .=" AND A.LIST_AREA_ID = ".$reqListAreaId;
    // }

    // if(!empty($reqItemAssessmentDuplikatId))
    // {
    //     $statement .=" AND A1.ITEM_ASSESSMENT_DUPLIKAT_ID = ".$reqItemAssessmentDuplikatId;
    // }
    $set->selectByParamsDetilNew(array(), -1,-1,$statement);
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
        $arrdata["AREA_UNIT_ID"]= $set->getField("AREA_UNIT_ID");
        $arrdata["AREA_UNIT_DETIL_ID"]= $set->getField("AREA_UNIT_DETIL_ID");
        array_push($arrlist, $arrdata);
    }

    unset($set);

    // print_r($arrdetil);exit;

}

// if($reqBulan == "")
//     $reqBulan= date("m");
// elseif($reqBulan == "x")
//     $reqBulan= "";
    
// if($reqTahun == "")
//     $reqTahun= date("Y");


$disabled="";

if($reqLihat ==1)
{
    $disabled="disabled";  
}



$set= new Distrik();
$arrdistrik= [];

$statement=" AND A.STATUS IS NULL AND A.NAMA IS NOT NULL 
AND EXISTS
(
SELECT A.DISTRIK_ID FROM AREA_UNIT B  
INNER JOIN  AREA_UNIT_DETIL C ON C.AREA_UNIT_ID = B.AREA_UNIT_ID  
WHERE A.DISTRIK_ID=B.DISTRIK_ID
)";
$set->selectByParamsAreaDistrik(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("DISTRIK_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrdistrik, $arrdata);
}
unset($set);



$set= new BlokUnit();
$arrblok= [];

if(empty($reqDistrikId))
{
    $statement=" AND 1=2";
}
else
{
    $statement=" AND EXISTS
    (
        SELECT A.BLOK_UNIT_ID FROM AREA_UNIT B
        INNER JOIN  AREA_UNIT_DETIL C ON C.AREA_UNIT_ID = B.AREA_UNIT_ID  
        WHERE A.BLOK_UNIT_ID=B.BLOK_UNIT_ID
    )  
    AND A.DISTRIK_ID =".$reqDistrikId;
}
$set->selectByParams(array(), -1,-1,$statement);
    // echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("BLOK_UNIT_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrblok, $arrdata);
}
unset($set);

if(empty($reqBlokId))
{
    $statement=" AND 1=2";
}
else
{
    $statement="  AND EXISTS
    (
        SELECT A.UNIT_MESIN_ID FROM AREA_UNIT B 
        INNER JOIN  AREA_UNIT_DETIL C ON C.AREA_UNIT_ID = B.AREA_UNIT_ID 
        WHERE A.UNIT_MESIN_ID=B.UNIT_MESIN_ID
    ) 
    AND A.BLOK_UNIT_ID =".$reqBlokId;
}

$set= new UnitMesin();
$arrunitmesin= [];
$set->selectByParams(array(), -1,-1,$statement);
    // echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("UNIT_MESIN_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrunitmesin, $arrdata);
}
unset($set);




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

select[readonly]:-moz-read-only {
  /* For Firefox */
  pointer-events: none;
}

select[readonly]:read-only {
  pointer-events: none;
}

table { width: 50% }
tbody tr:hover.selected td,
tbody tr:hover td {
  background-color: #fbfdb3;
  cursor: pointer;
}
/*tbody tr.selected td {
  background-color: #b3ccfd ;
}*/

td {border: 1px #DDD solid; padding: 5px; cursor: pointer;}

.pilihtabel {
    background-color: #06ae48;
    /*color: #FFF;*/
}

</style>


<div class="col-md-12">
    
  <div class="judul-halaman"> <a href="app/index/<?=$pgreturn?>">Data <?=$pgtitle?></a> &rsaquo; Kelola <?=$pgtitle?></div>

    <div class="konten-area">
        <div class="konten-inner">

            <div>

                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">

                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i> <?=$pgtitle?></h3>       
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Periode </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-3'>
                                    <select name="reqBulan" id="reqBulan"   class="form-control datatable-input">
                                    <option value="">Semua</option>
                                    <?
                                    for($i=0;$i<count($arrBulan);$i++)
                                    {
                                    ?>
                                       <option value="<?=$arrBulan[$i]?>" <? if(generateZeroDate($reqBulan, 2) == $arrBulan[$i]) { ?> selected <? } ?>><?=getNameMonthNew($arrBulan[$i])?></option>
                                    <?    
                                    }
                                    ?>
                                     </select>
                                </div>
                                <div class='col-md-3'>
                                    <select name="reqTahun" id="reqTahun"   class="form-control datatable-input">
                                        <option value="">Semua</option>
                                        <?
                                        for($tahun=0;$tahun < count($arrTahun);$tahun++)
                                        {
                                            ?>
                                            <option value="<?=$arrTahun[$tahun]?>" <? if($reqTahun == $arrTahun[$tahun]) echo "selected";?>><?=$arrTahun[$tahun]?></option>
                                            <?
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Distrik </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <select class="form-control jscaribasicmultiple" required id="reqDistrikId" <?=$disabled?> name="reqDistrikId"  style="width:100%;" >
                                        <option value="" >Pilih Distrik</option>
                                        <?
                                        foreach($arrdistrik as $item) 
                                        {
                                            $selectvalid= $item["id"];
                                            $selectvaltext= $item["text"];

                                            $selected="";
                                            if($selectvalid == $reqDistrikId)
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
                        <label class="control-label col-md-2">UL / PL / BLOK UNIT </label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11' id="blok">
                                <select class="form-control jscaribasicmultiple"  id="reqBlokId" <?=$disabled?> name="reqBlokId"  style="width:100%;" >
                                <?
                                foreach($arrblok as $item) 
                                {
                                    $selectvalid= $item["id"];
                                    $selectvaltext= $item["text"];
                                    $selected="";
                                    if($selectvalid == $reqBlokId)
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
                        <label class="control-label col-md-2">UNIT MESIN </label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'  id="unit">
                                    <select class="form-control jscaribasicmultiple"  id="reqUnitMesinId" <?=$disabled?> name="reqUnitMesinId"  style="width:100%;" >
                                    <option value="" >Pilih Unit Mesin</option>
                                    <?
                                    foreach($arrunitmesin as $item) 
                                    {
                                        $selectvalid= $item["id"];
                                        $selectvaltext= $item["text"];
                                        $selected="";
                                        if($selectvalid == $reqUnitMesinId)
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

                    <?
                    // if(!empty($reqId))
                    // {
                    ?>
                        <div class="page-header" style="background-color: green">
                            <h3><i class="fa fa-file-text fa-lg"></i> Area</h3>       
                        </div>

                        <div style="overflow-y: auto;height: 300px;width: 100%;">
                           <!--  <table id="tabel" class="table table-bordered table-striped table-hovered" style="width: 100%;" > -->
                             <table id="tabel" class="table table-bordered" style="width: 100%;" >
                                <thead >
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Area</th>
                                        <th class="text-center">Nama di Unit</th>
                                        <th class="text-center" style="width: 20%">Status</th>
                                        <th class="text-center" style="width: 5%;text-align: center">Confirm </th>
                                        <th class="text-center" style="width: 5%;text-align: center">Not Confirm </th>
                                    </tr>
                                </thead>
                                <tbody id="outlinedetil">
                                    <?
                                    $arriduniq=[];
                                    if(!empty($arrlist))
                                    {
                                    ?>
                                        <?
                                        $reqUniqId=1;
                                       
                                        foreach ($arrlist as $key => $value) 
                                        {   

                                            $reqListAreaId=$value["id"];
                                            $reqItemAssessmentDuplikatId=$value["ITEM_ASSESSMENT_DUPLIKAT_ID"];
                                            $reqAreaUnitId=$value["AREA_UNIT_ID"];
                                            $reqAreaUnitDetilId=$value["AREA_UNIT_DETIL_ID"];

                                            $setdetil= new OutliningAssessment();
                                            $statement = " AND A.OUTLINING_ASSESSMENT_ID = '".$reqId."' AND A.LIST_AREA_ID= ".$reqListAreaId." AND A.ITEM_ASSESSMENT_DUPLIKAT_ID= ".$reqItemAssessmentDuplikatId." AND A.AREA_UNIT_DETIL_ID= ".$reqAreaUnitDetilId." ";
                                            $setdetil->selectByParamsDetil(array(), -1,-1,$statement);

                                            // echo $setdetil->query;
                                            $setdetil->firstRow();
                                            $reqDetilId= $setdetil->getField("OUTLINING_ASSESSMENT_DETIL_ID");

                                            $setareadetil= new OutliningAssessment();
                                            $statement = " AND A.OUTLINING_ASSESSMENT_DETIL_ID = '".$reqDetilId."'";
                                            $setareadetil->selectByParamsAreaDetil(array(), -1,-1,$statement);

                                            // echo $setareadetil->query;exit;
                                            $setareadetil->firstRow();
                                            $reqAreaDetilId= $setareadetil->getField("OUTLINING_ASSESSMENT_AREA_DETIL_ID");

                                            $setarea= new OutliningAssessment();
                                            $statement = " AND A.OUTLINING_ASSESSMENT_DETIL_ID = '".$reqDetilId."' AND A.STATUS_CONFIRM = 1";
                                            $jumlahstatusconfirm = $setarea->getCountByParamsAreaDetilStatus(array(), $statement);

                                            $setarea= new OutliningAssessment();
                                            $statement = " AND A.OUTLINING_ASSESSMENT_DETIL_ID = '".$reqDetilId."' AND A.STATUS_CONFIRM = 0";
                                            $jumlahstatusnotconfirm = $setarea->getCountByParamsAreaDetilStatus(array(), $statement);

                                            $setarea= new OutliningAssessment();
                                            $statement = " AND A.OUTLINING_ASSESSMENT_DETIL_ID = '".$reqDetilId."' ";
                                            $jumlahstatussudah = $setarea->getCountByParamsAreaDetilStatus(array(), $statement);

                                            $setarea= new OutliningAssessment();
                                            $statement = " AND A.STATUS_KONFIRMASI IS NOT NULL  AND B.LIST_AREA_ID = '".$reqListAreaId."' ";
                                            $jumlahdata = $setarea->getCountByParamsAreaDetil(array(), $statement);

                                            // echo $setarea->query;

                                            $statussudah="";

                                            if($jumlahstatussudah > 0  )
                                            {
                                                if($jumlahstatussudah !== $jumlahdata )
                                                {
                                                    $statussudah="Belum Lengkap";
                                                }
                                                else
                                                {
                                                    $statussudah="Sudah Terisi";
                                                }
                                            }

                                            // print($jumlahstatussudah);                                       

                                        ?>
                                            <tr id="<?=$reqUniqId?>">
                                                <td> <?=$reqUniqId?></td>
                                                <td >
                                                    <input class="easyui-validatebox textbox form-control" type="hidden" name="reqListAreaId[]" id="reqListAreaId<?=$reqUniqId?>"   value="<?=$reqListAreaId?>"  >
                                                    <input class="easyui-validatebox textbox form-control" type="hidden" name="reqItemAssessmentDuplikatId[]" id="reqItemAssessmentDuplikatId<?=$reqUniqId?>"   value="<?=$reqItemAssessmentDuplikatId?>"  >
                                                    <label style="font-weight: normal !important;"><?=$value["text"]?></label>
                                                </td>
                                                <td>
                                                    <input class="easyui-validatebox textbox form-control" type="hidden" name="reqAreaUnitId[]" id="reqAreaUnitId<?=$reqUniqId?>"   value="<?=$reqAreaUnitId?>"  >
                                                    <input class="easyui-validatebox textbox form-control" type="hidden" name="reqAreaUnitDetilId[]" id="reqAreaUnitDetilId<?=$reqUniqId?>"   value="<?=$reqAreaUnitDetilId?>"  >
                                                   <!--  <input class="easyui-validatebox textbox form-control" type="text" name="reqNama[]" id="reqNama<?=$reqUniqId?>" disabled  value="<?/*=$value["AREA_UNIT"]*/?>" style="width: 500px" > -->
                                                    <label style="font-weight: normal !important;" ><?=$value["AREA_UNIT"]?></label>

                                                </td>
                                                <td  style='white-space: nowrap' >
                                                    <?
                                                    if(!empty($reqAreaDetilId))
                                                    {
                                                        ?>
                                                         <label style="font-weight: normal !important;"><?=$statussudah?></label>
                                                        <?
                                                    }
                                                    ?>
                                                </td>
                                                <td style="text-align: center"> <?=$jumlahstatusconfirm?></td> 
                                                <td style="text-align: center"> <?=$jumlahstatusnotconfirm?></td>    
                                                <td style="display: none">   
                                                    <input class="easyui-validatebox textbox form-control" type="text" name="reqDetilId[]" id="reqDetilId<?=$reqUniqId?>"   value="<?=$reqDetilId?>" style="width: 500px" >
                                                   
                                                </td>
                                            </tr>
                                        <?
                                        $reqUniqId++;
                                        }
                                        ?>
                                    <?
                                    }
                                    ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    <?
                    // }
                    ?>


                    <input type="hidden" name="reqId" value="<?=$reqId?>" />
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
                    <input type="hidden" name="reqStatusAktif" id="reqStatusAktif"   value="" style="width: 500px" >

                    <div id="inputselect">
                    </div>

                   

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

<script src="assets/emodal/eModal.js"></script>
<script src="assets/emodal/eModal-cabang.js"></script>

<script>


$('tr').dblclick(function(){
  var id = $(this).attr('id');
  var reqDetilId= $("#reqDetilId"+id).val();
  var reqListAreaId= $("#reqListAreaId"+id).val();
  var reqItemAssessmentDuplikatId= $("#reqItemAssessmentDuplikatId"+id).val();
  var reqAreaUnitDetilId= $("#reqAreaUnitDetilId"+id).val();
  var reqAreaUnitId= $("#reqAreaUnitId"+id).val();

  // console.log(reqDetilId);

   if(reqDetilId == "" || reqDetilId=='undefined'  )
    {
        $.messager.alert('Info', "Simpan data terlebih dahulu.", 'warning');
        return false;
    }
    else
    {

        window.open('app/index/outlining_assessment_add_detil?reqId=<?=$reqId?>&reqBulan=<?=$reqBulan?>&reqTahun=<?=$reqTahun?>&reqDetilId='+reqDetilId+'&reqListAreaId='+reqListAreaId+'&reqItemAssessmentDuplikatId='+reqItemAssessmentDuplikatId+'&reqAreaUnitDetilId='+reqAreaUnitDetilId+'&reqAreaUnitId='+reqAreaUnitId, '_self'); 
    }
 
});

function AddRekomendasi(reqDetilId,reqId,reqListAreaId,reqItemAssessmentDuplikatId,reqTahun)
{
    openAdd('iframe/index/outlining_assessment_add_rekomendasi?reqDetilId='+reqDetilId+'&reqId='+reqId+'&reqListAreaId='+reqListAreaId+'&reqItemAssessmentDuplikatId='+reqItemAssessmentDuplikatId+'&reqTahun='+reqTahun);
}

function detilform(reqId,reqTahun,reqDetilId,reqListAreaId,reqItemAssessmentDuplikatId,reqAreaUnitDetilId,reqAreaUnitId)
{
    // window.open('app/index/outlining_assessment_add_detil?reqId='+reqId+'&reqDetilId='+reqDetilId+'&reqListAreaId='+reqListAreaId+'&reqItemAssessmentDuplikatId='+reqItemAssessmentDuplikatId, '_self');
    if(reqDetilId == "" || reqDetilId=='undefined'  )
    {
        // $.messager.alert('Info', "Simpan data terlebih dahulu.", 'warning');
        // return false;
    }
    else
    {

    window.open('app/index/outlining_assessment_add_detil?reqId=<?=$reqId?>&reqBulan=<?=$reqBulan?>&reqTahun=<?=$reqTahun?>&reqDetilId='+reqDetilId+'&reqListAreaId='+reqListAreaId+'&reqItemAssessmentDuplikatId='+reqItemAssessmentDuplikatId+'&reqAreaUnitDetilId='+reqAreaUnitDetilId+'&reqAreaUnitId='+reqAreaUnitId, '_self'); 
    } 
}

$("#reqTahun").on("input", function(evt) {
   var self = $(this);
   self.val(self.val().replace(/[^0-9]/g, ''));
   if ((evt.which != 46 ) && (evt.which < 48 || evt.which > 57)) 
   {
     evt.preventDefault();
   }
});


var z = "<?=$reqUniqId?>";
// console.log(z);
if( z== "" )
{
    id=1;
}
else
{
    id=z;
}
const uniqid = (() => {
    let i = id;
    return () => {
        return i++;
    }
})();


$('#reqDistrikId').on('change', function() {
    // $("#blok").empty();
    var reqDistrikId= this.value;
     // $("#outlinedetil").empty();
   
    $.getJSON("json-app/outlining_assessment_json/filter_blok?reqDistrikId="+reqDistrikId,
        function(data)
        {
            // console.log(data);
            $("#reqBlokId option").remove();
            $("#reqUnitMesinId option").remove();
            $("#reqListAreaId option").remove();
            $("#reqBlokId").append('<option value="" >Pilih Blok Unit</option>');
            jQuery(data).each(function(i, item){
                $("#reqBlokId").append('<option value="'+item.id+'" >'+item.text+'</option>');
            });
        });
    // console.log(reqBlokId);
   
});

$('#reqBlokId').on('change', function() {
    // console.log(1);

    var reqDistrikId= $("#reqDistrikId").val();
    var reqBlokId= $("#reqBlokId").val();
    var reqUnitMesinId= $("#reqUnitMesinId").val();
    var reqBulan= '<?=$reqBulan?>';
    var reqTahun= '<?=$reqTahun?>';
    $("#outlinedetil").empty();

    $.getJSON("json-app/outlining_assessment_json/filter_unit?reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId+"&reqBulan="+reqBulan+"&reqTahun="+reqTahun,
        function(data)
        {
            // console.log(data);
            $("#reqUnitMesinId option").remove();
            $("#reqListAreaId option").remove();
            $("#reqUnitMesinId").append('<option value="" >Pilih Unit Mesin </option>');
            jQuery(data).each(function(i, item){
                $("#reqUnitMesinId").append('<option value="'+item.id+'" >'+item.text+'</option>');
            });
        });

    $("#reqStatusAktif").val(1);

    $.get("app/loadUrl/app/outlining_assessment_add_area?reqId=<?=$reqId?>&reqUniqId="+uniqid()+"&reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId+"&reqTahun=<?=$reqTahun?>", function(data) { 
        $("#outlinedetil").append(data);
    });   
});

$('#reqUnitMesinId').on('change', function() {

    var reqDistrikId= $("#reqDistrikId").val();
    var reqBlokId= $("#reqBlokId").val();
    var reqUnitMesinId= $(this).val();
    var reqDetilId= "";
    $("#outlinedetil").empty();
    $.get("app/loadUrl/app/outlining_assessment_add_area?reqId=<?=$reqId?>&reqUniqId="+uniqid()+"&reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId+"&reqUnitMesinId="+reqUnitMesinId+"&reqTahun=<?=$reqTahun?>", function(data) { 
        $("#outlinedetil").append(data);
    });

    $("#reqStatusAktif").val(1);
    // $.getJSON("json-app/outlining_assessment_json/filter_area?reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId+"&reqUnitMesinId="+reqUnitMesinId,
    //     function(data)
    //     {
    //         // console.log(data);
    //         $("#outlinedetil").empty();
    //         jQuery(data).each(function(i, item){
    //             $.get("app/loadUrl/app/outlining_assessment_add_area?reqId=<?=$reqId?>&reqUniqId="+uniqid()+"&reqDetilId="+reqDetilId+"&reqListAreaId="+item.id+"&reqItemAssessmentDuplikatId="+item.ITEM_ASSESSMENT_DUPLIKAT_ID, function(data) { 
    //                 $("#outlinedetil").append(data);
    //             });
    //         });
    //     });
});

function HapusDetil(iddetil,reqId) {
    $.messager.confirm('Konfirmasi',"Hapus data terpilih?",function(r){
        if (r){
            $.getJSON("json-app/outlining_assessment_json/deleteareadetilnew?reqDetilId="+iddetil+"&reqId="+reqId,
                function(data){
                    // console.log(data);return false;
                    $.messager.alert('Info', data.PESAN, 'info');                    
                    location.reload();
                });
        }
    }); 
}

function submitForm(){

    var listareaid=[];
    $("#inputselect").empty();

    var checkid='<?=$reqId?>';
    if(checkid=="")
    {
        $("#tabel tr.pilihtabel").each(function(){
            // listareaid.push($('td:first', this).html());

            var valListAreaId = $(this).closest('tr').find('td:eq(0)').text();
            var valItemAssessmentDuplikatId= $(this).closest('tr').find('td:eq(1)').text();
            var valAreaUnitDetilId= $(this).closest('tr').find('td:eq(2)').text();
            var valAreaUnitId= $(this).closest('tr').find('td:eq(3)').text();

            // console.log(valItemAssessmentDuplikatId);

            var ListAreaId =" <input  type='hidden' name='reqListAreaId[]' id='reqListAreaId' value="+valListAreaId+" />";
            var ItemAssessmentDuplikatId =" <input  type='hidden' name='reqItemAssessmentDuplikatId[]' id='reqItemAssessmentDuplikatId' value="+valItemAssessmentDuplikatId+" />";
            var AreaUnitDetilId =" <input  type='hidden' name='reqAreaUnitDetilId[]' id='reqAreaUnitDetilId' value="+valAreaUnitDetilId+" />";
            var AreaUnitId =" <input  type='hidden' name='reqAreaUnitId[]' id='reqAreaUnitId' value="+valAreaUnitId+" />";

            $("#inputselect").append(ListAreaId+ItemAssessmentDuplikatId+AreaUnitDetilId+AreaUnitId);

        });

    }
  
    // $.messager.confirm('Konfirmasi',"Apakah anda yakin dengan data yang terpilih?",function(r)
    // {
    //     if (r)
    //     {
            $('#ff').form('submit',{
                url:'json-app/outlining_assessment_json/add',
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
                        $.messager.alertLink('Info', infoSimpan, 'info', "app/index/<?=$pgreturn?>_add?reqId="+reqId+"&reqBulan=<?=$reqBulan?>&reqTahun=<?=$reqTahun?>");
                }
            });

    //     }
    // }); 
    
   
}

function clearForm(){
    $('#ff').form('clear');
}   
</script>