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
$this->load->model("base-app/JenisRekomendasi");
$this->load->model("base-app/PrioritasRekomendasi");
$this->load->model("base-app/KategoriRekomendasi");
$this->load->model("base-app/Crud");

$appuserkodehak= $this->appuserkodehak;




$arrBulan=setBulanLoop();
$arrTahun= setTahunLoop(1,1);


// print_r($arrBulan);exit;


$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");
$reqDetilId = $this->input->get("reqDetilId");
$reqTahun = $this->input->get("reqTahun");

// print_r($reqTahun);
 // $reqTahunSem = date('Y', strtotime($reqTahun. ' +  years'));

 // print_r( $reqTahunSem);exit;

$setdetil= new OutliningAssessment();
$arrdetil= [];

$statement = " AND A.STATUS_CONFIRM = 0 AND A.OUTLINING_ASSESSMENT_ID = '".$reqId."' AND A.OUTLINING_ASSESSMENT_DETIL_ID = '".$reqDetilId."' ";
$setdetil->selectByParamsDetilRekomendasi(array(), -1,-1,$statement);
    // echo $setdetil->query;exit;

while($setdetil->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $setdetil->getField("OUTLINING_ASSESSMENT_DETIL_ID");
    $arrdata["text"]=$setdetil->getField("KODE_INFO");
    $arrdata["LIST_AREA_ID_INFO"]=$setdetil->getField("LIST_AREA_ID")." - ".$setdetil->getField("ITEM_ASSESSMENT_DUPLIKAT_ID");
    $arrdata["KATEGORI_ITEM_ASSESSMENT_ID"]= $setdetil->getField("KATEGORI_ITEM_ASSESSMENT_ID");
    $arrdata["ITEM_ASSESSMENT_FORMULIR_ID"]= $setdetil->getField("ITEM_ASSESSMENT_FORMULIR_ID");
    $arrdata["STANDAR_REFERENSI_ID"]= $setdetil->getField("STANDAR_REFERENSI_ID");
    $arrdata["STATUS_CONFIRM"]= $setdetil->getField("STATUS_CONFIRM");
    $arrdata["KETERANGAN"]= $setdetil->getField("KETERANGAN");
    $arrdata["DISTRIK_ID"]= $setdetil->getField("DISTRIK_ID");
    $arrdata["BLOK_UNIT_ID"]= $setdetil->getField("BLOK_UNIT_ID");
    $arrdata["UNIT_MESIN_ID"]= $setdetil->getField("UNIT_MESIN_ID");

    $arrdata["OUTLINING_ASSESSMENT_REKOMENDASI_ID"]= $setdetil->getField("OUTLINING_ASSESSMENT_REKOMENDASI_ID");
    $arrdata["REKOMENDASI"]= $setdetil->getField("REKOMENDASI");
    $arrdata["JENIS_REKOMENDASI_ID"]= $setdetil->getField("JENIS_REKOMENDASI_ID");
    $arrdata["PRIORITAS_REKOMENDASI_ID"]= $setdetil->getField("PRIORITAS_REKOMENDASI_ID");
    $arrdata["KATEGORI_REKOMENDASI_ID"]= $setdetil->getField("KATEGORI_REKOMENDASI_ID");
    $arrdata["SEM_1_1"]= $setdetil->getField("SEM_1_1");
    $arrdata["SEM_2_1"]= $setdetil->getField("SEM_2_1");
    $arrdata["SEM_1_2"]= $setdetil->getField("SEM_1_2");
    $arrdata["SEM_2_2"]= $setdetil->getField("SEM_2_2");
    $arrdata["SEM_1_3"]= $setdetil->getField("SEM_1_3");
    $arrdata["SEM_2_3"]= $setdetil->getField("SEM_2_3");

    $arrdata["STATUS_CHECK"]= $setdetil->getField("STATUS_CHECK");
    $arrdata["ANGGARAN"]= number_format($setdetil->getField("ANGGARAN"),0,',','.');;
    array_push($arrdetil, $arrdata);
}

$set= new JenisRekomendasi();
$arrjenisrekomendasi= [];
$set->selectByParams(array(), -1,-1,"");
    // echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("JENIS_REKOMENDASI_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrjenisrekomendasi, $arrdata);
}
unset($set);

$set= new PrioritasRekomendasi();
$arrPrioritas= [];
$set->selectByParams(array(), -1,-1,"");
    // echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("PRIORITAS_REKOMENDASI_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrPrioritas, $arrdata);
}
unset($set);

$set= new KategoriRekomendasi();
$arrKategori= [];
$set->selectByParams(array(), -1,-1,"");
    // echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("KATEGORI_REKOMENDASI_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrKategori, $arrdata);
}
unset($set);

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

</style>


<div class="col-md-12">
    
  <div class="judul-halaman"> Data Rekomendasi</div>

    <div class="konten-area">
        <div class="konten-inner">

            <div>

                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data" autocomplete="off">

                    <div class="page-header" style="background-color: green">
                        <h3><i class="fa fa-file-text fa-lg"></i> Rekomendasi</h3>       
                    </div>

                    <div style="overflow-y: auto;height: 100%;width: 100%;">
                        <table id="" class="table table-bordered table-striped table-hovered" style="width: 100%;" >
                            <thead >
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Area</th>
                                    <th class="text-center">Nama di Unit</th>
                                    <th class="text-center">Keterangan</th>
                                    <th class="text-center">Rekomendasi</th>
                                    <th class="text-center">Jenis Rekomendasi</th>
                                    <th class="text-center">Prioritas</th>
                                    <th class="text-center">Kategori Rekomendasi</th>
                                    <?
                                    $itahun=$reqTahun;
                                    for ($x = 0; $x <= 2; $x++) {
                                    ?>
                                        <th class="text-center">SEM 1 <?=$itahun?></th>
                                        <th class="text-center">SEM 2 <?=$itahun?></th>
                                    <?
                                    $itahun++;
                                    }
                                    ?>
                                    <th class="text-center">CHECK</th>
                                    <th class="text-center">Perkiraan Anggaran</th>
                                    <!-- <th class="text-center">Aksi</th> -->
                                </tr>
                            </thead>
                            <tbody id="outlinedetil">
                                <?
                                $z=1;
                                if(!empty($arrdetil))
                                {
                                ?>
                                    <?
                                    foreach ($arrdetil as $key => $value) 
                                    {
                                        $reqListAreaInfo=$value["LIST_AREA_ID_INFO"];
                                        $reqDetilId=$value["id"];

                                        $arrval = explode("-", $reqListAreaInfo);
                                        $reqListAreaId= $arrval[0];
                                        $reqItemAssessmentDuplikatId= $arrval[1];

                                        $reqDistrikId=$value["DISTRIK_ID"];
                                        $reqBlokId=$value["BLOK_UNIT_ID"];
                                        $reqUnitMesinId=$value["UNIT_MESIN_ID"];
                                        $reqKategoriItemAssessment=$value["KATEGORI_ITEM_ASSESSMENT_ID"];
                                        $reqFormulirId=$value["ITEM_ASSESSMENT_FORMULIR_ID"];
                                        $reqStandarId=$value["STANDAR_REFERENSI_ID"];
                                        $reqStatusConfirm=$value["STATUS_CONFIRM"];
                                        $reqKeterangan=$value["KETERANGAN"];

                                        $reqRekomendasiId=$value["OUTLINING_ASSESSMENT_REKOMENDASI_ID"];
                                        $reqRekomendasi=$value["REKOMENDASI"];
                                        $reqJenisRekomendasi=$value["JENIS_REKOMENDASI_ID"];
                                        $reqPrioritas=$value["PRIORITAS_REKOMENDASI_ID"];
                                        $reqKategoriRekomendasi=$value["KATEGORI_REKOMENDASI_ID"];
                                        $reqSem1_1=$value["SEM_1_1"];
                                        $reqSem2_1=$value["SEM_2_1"];
                                        $reqSem1_2=$value["SEM_1_2"];
                                        $reqSem2_2=$value["SEM_2_2"];
                                        $reqSem1_3=$value["SEM_1_3"];
                                        $reqSem2_3=$value["SEM_2_3"];
                                        $reqCheck=$value["STATUS_CHECK"];
                                        $reqPerkiraan=$value["ANGGARAN"];

                                        // var_dump($reqSem1_1);

                                        $set= new ListArea();
                                        $statement=" AND B.LIST_AREA_ID = ".$reqListAreaId." AND B.ITEM_ASSESSMENT_DUPLIKAT_ID = ".$reqItemAssessmentDuplikatId." AND C.DISTRIK_ID = ".$reqDistrikId." AND C.BLOK_UNIT_ID = ".$reqBlokId." AND C.UNIT_MESIN_ID = ".$reqUnitMesinId;
                                        $set->selectduplikatfilter(array(), -1, -1, $statement);
                                            // echo $set->query;exit;
                                        $set->firstRow();
                                        $reqNama=$set->getField("AREA_UNIT");
                                        $reqAreaUnitDetilId=$set->getField("AREA_UNIT_DETIL_ID");

                                        $set= new ListArea();
                                        $arrlist= [];

                                        $statement=" AND A.STATUS IS NULL ";


                                        if(!empty($reqUnitMesinId))
                                        {
                                            $statement .=" AND C.UNIT_MESIN_ID = ".$reqUnitMesinId;
                                        }

                                        if(!empty($reqListAreaId))
                                        {
                                            $statement .=" AND B.LIST_AREA_ID = ".$reqListAreaId;
                                        }

                                        if(!empty($reqItemAssessmentDuplikatId))
                                        {
                                            $statement .=" AND B.ITEM_ASSESSMENT_DUPLIKAT_ID = ".$reqItemAssessmentDuplikatId;
                                        }
                                        $set->selectduplikatfilter(array(), -1,-1,$statement);
                                        // $set->firstRow();
                                        // echo $set->query;
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
                                            array_push($arrlist, $arrdata);
                                        }

                                        unset($set);

                                    ?>
                                        <tr>
                                            <td> <?=$z?></td>
                                            <td>
                                                <!-- <select class="form-control jscaribasicmultiple" required id="reqListAreaId<?=$reqUniqId?>" <?=$disabled?> name="reqListAreaId[]"  style="width:300px;"   > -->
                                                    <?
                                                    foreach($arrlist as $item) 
                                                    {
                                                        $selectvalid= $item["id"];
                                                        $selectvalidduplikat= $item["ITEM_ASSESSMENT_DUPLIKAT_ID"];
                                                        $selectvaltext= $item["text"];
                                                        $selectvalareaunitdetil= $item["AREA_UNIT_DETIL_ID"];

                                                        $check=$selectvalid.' - '.$selectvalidduplikat;

                                                        // $selected="";
                                                        // if($check == $reqListAreaInfo )
                                                        // {
                                                        //     $selected="selected";
                                                        // }
                                                        ?>
                                                        <!-- <option value="<?=$selectvalid?>-<?=$selectvalidduplikat?>" <?=$selected?>><?=$selectvaltext?></option> -->
                                                        <input class="easyui-validatebox textbox form-control" type="hidden" name="reqListAreaId[]" id="reqListAreaId<?=$reqUniqId?>"   value="<?=$selectvalid?>"  >
                                                        <input class="easyui-validatebox textbox form-control" type="hidden" name="reqDuplikatId[]" id="reqDuplikatId<?=$reqUniqId?>"   value="<?=$selectvalidduplikat?>"  >
                                                        <input class="easyui-validatebox textbox form-control" type="text"  disabled  value="<?=$selectvaltext?>" style="width: 400px" >
                                                        <?
                                                    }
                                                    ?>
                                                <!-- </select> -->

                                            </td>
                                            <td>
                                                <input class="easyui-validatebox textbox form-control" type="hidden" name="reqAreaUnitDetilId[]" id="reqAreaUnitDetilId<?=$reqUniqId?>"   value="<?=$reqAreaUnitDetilId?>"  >
                                                <input class="easyui-validatebox textbox form-control" type="text" name="reqNama[]" id="reqNama<?=$reqUniqId?>" disabled  value="<?=$reqNama?>" style="width: 500px" >
                                            </td>
                                            <td> 
                                                <textarea class="easyui-validatebox textbox form-control"  style="width: 340px;" disabled name="reqKeterangan[]" <?=$disabled?>  id="reqKeterangan<?=$reqUniqId?>"><?=$reqKeterangan?></textarea>
                                            </td>
                                            <td> 
                                                <textarea class="easyui-validatebox textbox form-control"  style="width: 340px;"  name="reqRekomendasi[]" <?=$disabled?>  id="reqRekomendasi<?=$reqUniqId?>"><?=$reqRekomendasi?></textarea>
                                            </td>
                                            <td> 
                                                <select class="form-control jscaribasicmultiple" required id="reqJenisRekomendasi<?=$reqUniqId?>" <?=$disabled?> name="reqJenisRekomendasi[]"  style="width:300px;"   >
                                                    <option value="" >Pilih Jenis  </option>
                                                    <?
                                                    foreach($arrjenisrekomendasi as $item) 
                                                    {
                                                        $selectvalid= $item["id"];
                                                        $selectvaltext= $item["text"];
                                                        $selected="";
                                                        if($selectvalid == $reqJenisRekomendasi )
                                                        {
                                                            $selected="selected";
                                                        }
                                                        ?>
                                                        <option value="<?=$selectvalid?>" <?=$selected?>><?=$selectvaltext?></option>
                                                        <?
                                                    }
                                                    ?>
                                                </select>
                                               <!--  <textarea class="easyui-validatebox textbox form-control"  style="width: 340px;"  name="reqJenisRekomendasi[]"  id="reqJenisRekomendasi<?=$reqUniqId?>"><?=$reqJenisRekomendasi?></textarea> -->
                                            </td>
                                            <td>
                                                <!-- <input class="easyui-validatebox textbox form-control" type="text" name="reqPrioritas[]" id="reqPrioritas<?=$reqUniqId?>"   value="<?=$reqPrioritas?>" style="width: 200px" > -->
                                                <select class="form-control jscaribasicmultiple" required id="reqPrioritas<?=$reqUniqId?>" <?=$disabled?> name="reqPrioritas[]"  style="width:300px;"   >
                                                    <option value="" >Pilih Prioritas  </option>
                                                    <?
                                                    foreach($arrPrioritas as $item) 
                                                    {
                                                        $selectvalid= $item["id"];
                                                        $selectvaltext= $item["text"];
                                                        $selected="";
                                                        if($selectvalid == $reqPrioritas )
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
                                               <!--  <input class="easyui-validatebox textbox form-control" type="text" name="reqKategoriRekomendasi[]" id="reqKategoriRekomendasi<?=$reqUniqId?>"   value="<?=$reqKategoriRekomendasi?>" style="width: 200px" > -->
                                                <select class="form-control jscaribasicmultiple" required id="reqKategoriRekomendasi<?=$reqUniqId?>" <?=$disabled?> name="reqKategoriRekomendasi[]"  style="width:300px;"   >
                                                    <option value="" >Pilih Kategori  </option>
                                                    <?
                                                    foreach($arrKategori as $item) 
                                                    {
                                                        $selectvalid= $item["id"];
                                                        $selectvaltext= $item["text"];
                                                        $selected="";
                                                        if($selectvalid == $reqKategoriRekomendasi )
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
                                            <?
                                            $z=1;
                                            for ($x = 0; $x <= 2; $x++) {

                                            ?>
                                            <td style="
                                            transform: scale(1.5) translateX(5%); z-index: 1;
                                            transform-origin: top left;">
                                                <input type="checkbox" name="reqSem1_<?=$z?>[]" <?=$disabled?> id="reqSem1_<?=$z?>" <? if(${"reqSem1_".$z}=="1") echo 'checked' ?> value="1">
                                             <!--    <input class="easyui-validatebox textbox form-control biner" type="text" name="reqSem1[]"   maxlength='1'    style="width: 70px" > -->
                                            </td>
                                            <td  style="
                                            transform: scale(1.5) translateX(5%); z-index: 1;
                                            transform-origin: top left;">
                                                <!-- <input class="easyui-validatebox textbox form-control biner" type="text" name="reqSem2[]" id="reqSem2<?=$reqUniqId?>" maxlength='1'   value="<?=$reqSem2?>" style="width: 70px" > -->
                                                <input type="checkbox" name="reqSem2_<?=$z?>[]" <?=$disabled?> id="reqSem2_<?=$z?>" <? if(${"reqSem2_".$z}=="1") echo 'checked' ?>  value="1">
                                            </td>
                                            <?
                                            $z++;
                                            }
                                            ?>
                                            <td>
                                                <select class="form-control jscaribasicmultiple" required id="reqCheck" <?=$disabled?> name="reqCheck[]"  style="width: 200px;" >
                                                 <option value="1" <? if($reqCheck=="1") echo 'selected' ?> >Lengkap</option>
                                                 <option value="0" <? if($reqCheck=="0") echo 'selected' ?> >Belum Lengkap</option>
                                                </select> 
                                            </td>
                                            <td>
                                                <input class="easyui-validatebox textbox form-control harga" type="text" name="reqPerkiraan[]" id="reqPerkiraan<?=$reqUniqId?>"  <?=$disabled?>  value="<?=$reqPerkiraan?>" style="width: 200px" >
                                            </td>
                                            <td style="display: none">   
                                                <input class="easyui-validatebox textbox form-control" type="text" name="reqDetilId[]" id="reqDetilId<?=$reqUniqId?>"   value="<?=$reqDetilId?>" style="width: 500px" >
                                                <input class="easyui-validatebox textbox form-control" type="text" name="reqRekomendasiId[]" id="reqRekomendasiId<?=$reqUniqId?>"   value="<?=$reqRekomendasiId?>" style="width: 500px" >
                                            </td>                                            
                                        </tr> 
                                    <?
                                    $z++;
                                    }
                                    ?>
                                <?
                                }
                                ?>
                              
                            </tbody>
                        </table>
                    </div>


                    <input type="hidden" name="reqId" value="<?=$reqId?>" />
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>" />

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
                <a href="javascript:void(0)" class="btn btn-primary" onclick="submitForm()">Submit</a>
            </div>
            <?
            }
            ?>
            
        </div>
    </div>
    
</div>

<script>

    var format = function(num){
        var str = num.toString().replace("", ""), parts = false, output = [], i = 1, formatted = null;
        if(str.indexOf(",") > 0) {
            parts = str.split(",");
            str = parts[0];
        }
        str = str.split("").reverse();
        for(var j = 0, len = str.length; j < len; j++) {
            if(str[j] != ".") {
                output.push(str[j]);
                if(i%3 == 0 && j < (len - 1)) {
                    output.push(".");
                }
                i++;
            }
        }
        formatted = output.reverse().join("");
        return( formatted + ((parts) ? "," + parts[1].substr(0, 2) : ""));
    };


$('.harga').on('input blur paste', function(){
    var numeric = $(this).val().replace(/\D/g, '');
    $(this).val(format(numeric));
});

// $(".jscaribasicmultiple").select2("readonly", true);

$(function(){

    $('.biner').keypress(function(e){
        // console.log(e);
        if(e.which == 49 || e.which == 8)  // 8 is for backspace
        {
          // Do something here
        } 
        else 
        {
          return false;
        }
    });

    $('.biner').on('paste', function (event) {
      if (event.originalEvent.clipboardData.getData('Text').match(/[^1]/)) {
        event.preventDefault();
      }
    });
});




function submitForm(){
    
    $('#ff').form('submit',{
        url:'json-app/outlining_assessment_json/addrekomendasi',
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
            reqRekomendasiId= data[0];
            infoSimpan= data[1];
            if(reqRekomendasiId == 'xxx')
                $.messager.alert('Info', infoSimpan, 'warning');
            else
                $.messager.alertLink('Info', infoSimpan, 'info', "app/index/outlining_assessment_add_rekomendasi?reqRekomendasiId="+reqRekomendasiId+'&reqDetilId=<?=$reqDetilId?>'+'&reqId=<?=$reqId?>'+'&reqListAreaId=<?=$reqListAreaId?>'+'&reqItemAssessmentDuplikatId=<?=$reqItemAssessmentDuplikatId?>'+'&reqTahun=<?=$reqTahun?>');
            setTimeout(function() { 
                 parent.closePopup();
            }, 1000);
            
        }
    });
}

function clearForm(){
    $('#ff').form('clear');
}

function HapusRekomendasi(iddetil,reqId) {
    $.messager.confirm('Konfirmasi',"Hapus data terpilih?",function(r){
        if (r){
            $.getJSON("json-app/outlining_assessment_json/deleterekomendasi?reqRekomendasiId="+iddetil+"&reqId="+reqId,
                function(data){
                    // console.log(data);return false;
                    $.messager.alert('Info', data.PESAN, 'info');                    
                    location.reload();
                });
        }
    }); 
}

</script>