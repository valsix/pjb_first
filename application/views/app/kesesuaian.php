<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/OutliningAssessment");
$this->load->model("base-app/Distrik");
$this->load->model("base-app/Crud");
$this->load->model("base/Users");


$this->load->library('libapproval');
$this->load->library('globalfunc');





$appuserkodehak= $this->appuserkodehak;
$reqPenggunaid= $this->appuserid;
// print_r($appuserkodehak);exit;

$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");


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

$disabled="";

if($reqLihat==1 || $reqRead==1)
{
    $disabled="disabled";
}
// echo $reqMaxTahun;exit;

$checkrole= new Crud();
$statement=" AND A.KODE_HAK LIKE '%".$appuserkodehak."%'";
// $statement=" ";

$checkrole->selectByParams(array(), -1, -1, $statement);
// echo $checkrole->query;exit;
$checkrole->firstRow();
$reqPenggunaHakId= $checkrole->getField("PENGGUNA_HAK_ID");

if($reqPenggunaHakId==1)
{}
else
{
    $arridDistrik=[];
    $usersdistrik = new Users();
    $usersdistrik->selectByPenggunaDistrik($reqPenggunaid);
    while($usersdistrik->nextRow())
    {
        $arridDistrik[]= $usersdistrik->getField("DISTRIK_ID"); 

    }

    $idDistrik = implode(",",$arridDistrik);  
}


//array distrik start
$set= new Distrik();
$arrdistrik= [];

if(!empty($idDistrik))
{
    // $statement=" AND A.DISTRIK_ID IN (".$idDistrik.") AND A.STATUS IS NULL AND A.NAMA IS NOT NULL AND EXISTS(SELECT A.DISTRIK_ID FROM AREA_UNIT B WHERE A.DISTRIK_ID=B.DISTRIK_ID)";
    // $statement=" AND A.DISTRIK_ID IN (".$idDistrik.") AND A.STATUS IS NULL AND A.NAMA IS NOT NULL AND EXISTS(SELECT A.DISTRIK_ID FROM AREA_UNIT B WHERE A.DISTRIK_ID=B.DISTRIK_ID)";
    $statement=" AND A.DISTRIK_ID IN (".$idDistrik.") AND A.STATUS IS NULL AND A.NAMA IS NOT NULL 
    AND EXISTS
    (
        SELECT A.DISTRIK_ID FROM AREA_UNIT B  
        INNER JOIN  AREA_UNIT_DETIL C ON C.AREA_UNIT_ID = B.AREA_UNIT_ID  
        WHERE A.DISTRIK_ID=B.DISTRIK_ID
    )";
}
else
{
    // $statement="AND A.STATUS IS NULL AND A.NAMA IS NOT NULL AND EXISTS(SELECT A.DISTRIK_ID FROM AREA_UNIT B WHERE A.DISTRIK_ID=B.DISTRIK_ID)";
    $statement=" AND A.STATUS IS NULL AND A.NAMA IS NOT NULL 
    AND EXISTS
    (
        SELECT A.DISTRIK_ID FROM AREA_UNIT B  
        INNER JOIN  AREA_UNIT_DETIL C ON C.AREA_UNIT_ID = B.AREA_UNIT_ID  
        WHERE A.DISTRIK_ID=B.DISTRIK_ID
    )";
}

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

$arrBulan=setBulanLoop();
$arrTahun= setTahunLoop(2,1);


$setbulan= new OutliningAssessment();
$setbulan->selectByParams(array(), -1, -1, ""," ORDER BY OUTLINING_ASSESSMENT_ID DESC ");
$setbulan->firstRow();
$reqTahun= $setbulan->getField("TAHUN");
$reqBulan= $setbulan->getField("BULAN");

if($reqBulan == "")
    $reqBulan= date("m");
elseif($reqBulan == "x")
    $reqBulan= "";

if($reqTahun == "")
    $reqTahun= date("Y");

//array distrik end
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


/*.select2-container {
    width: 100% !important;
}*/
/****/
#reqDeskripsi,
#reqKeterangan {
    width: 340px;
}

table { width: 50% }

/*td span {
  display: block;
}
*/

table.table>tbody>tr.area:hover td,
table.table>tbody> tr.area:hover th {
  background-color: #f8a92f !important;
}

table.table>tbody>tr.distrik:hover td,
table.table>tbody> tr.distrik:hover th {
  background-color: #f8a92f !important;
}

table.table>tbody>tr.detil:hover td,
table.table>tbody> tr.detil:hover th {
  background-color: #f8a92f !important;
}

.bigdrop{
    width: 600px !important;

}

select[readonly].select2-hidden-accessible + .select2-container {
    pointer-events: none;
    touch-action: none;
}

select[readonly].select2-hidden-accessible + .select2-container .select2-selection {
    background: #eee;
    box-shadow: none;
}

select[readonly].select2-hidden-accessible + .select2-container .select2-selection__arrow, select[readonly].select2-hidden-accessible + .select2-container .select2-selection__clear {
    display: none;
}

input[readonly]
{
    background: #eee;
}
textarea[readonly]
{
    background: #eee;
}


.parent {
  float:left;
width:100%;
overflow-x: auto;
height: 100%;
}


</style>


<div class="col-md-12">
    <div class="judul-halaman"> Data Kesesuaian </div>

    <div class="konten-area" style="overflow: auto;">
        <div class="konten-inner">
            <div >
                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data" autocomplete="off">
                    <div class="page-header" style="background-color: green;width:1500px">
                        <h3><i class="fa fa-file-text fa-lg"></i> Kesesuaian </h3>       
                    </div>
                    <br>
                    <div class="col-md-12" style="margin-bottom: 20px;" >               
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Distrik </label>
                            <div class="col-sm-4">
                                <select class="form-control jscaribasicmultiple" id="reqDistrik"  style="width:100%;" >
                                    <option value="">Semua Distrik</option>
                                    <? 
                                    foreach($arrdistrik as $item) 
                                    {
                                        $selectvalid= $item["id"];
                                        $selectvaltext= $item["text"];

                                        $selected="";
                                        ?>
                                        <option value="<?=$selectvalid?>" <?=$selected?>><?=$selectvaltext?></option>
                                        <?
                                    }
                                    ?>
                                </select>
                            </div>

                            <label for="inputEmail3" class="col-sm-2 control-label">Blok/Unit </label>
                            <div class="col-sm-4">
                                <select class="form-control jscaribasicmultiple" id="reqBlok"   style="width:100%;" >
                                    <option value="">Semua Blok/Unit</option>
                                </select>
                            </div>  
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Bulan </label>
                            <div class="col-sm-4">
                                <select name="reqBulan" id="reqBulan" class="form-control datatable-input">
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
                            <label for="inputEmail3" class="col-sm-2 control-label">Tahun </label>
                            <div class="col-sm-4">
                                <select name="reqTahun" id="reqTahun" class="form-control datatable-input">
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
                        <br>
                        <br>
                    </div>


                    <div style="float:left;width:1500px;overflow: auto;height: auto">
                        <table id="" class="table table-bordered table-striped table-hovered" style="width: 100%;" >
                            <thead >
                                <tr>
                                    <th class="text-center" style=" width: 10%;vertical-align: middle">No</th>
                                    <th class="text-center" style=" width: 40%;vertical-align: middle">Area</th>
                                    <th class="text-center" style=" width: 40%;vertical-align: middle">Nama Peralatan</th>
                                    <th class="text-center" style="vertical-align: middle">Jumlah Klausul</th>
                                    <th class="text-center" style="vertical-align: middle">Confirm</th>
                                    <th class="text-center" style="vertical-align: middle">Not Confirm</th>
                                    <th class="text-center" style="vertical-align: middle">% Confirm</th>
                                    <th class="text-center" style="vertical-align: middle">% Not Confirm</th>
                                    <th class="text-center" style="vertical-align: middle">Rating (MP)</th>
                                    <th class="text-center" style="vertical-align: middle">Dampak (MP)</th>
                                    <th class="text-center" style="vertical-align: middle">Rating (PP)</th>
                                    <th class="text-center" style="vertical-align: middle">Kemungkinan (PP)</th>
                                    <th class="text-center" style="vertical-align: middle">Risiko</th>
                                    <th class="text-center" style="vertical-align: middle">Matriks Risiko</th>
                                    <th class="text-center" style="vertical-align: middle">Status</th>
                                    <th class="text-center" style="vertical-align: middle">Belum Di Isi</th>
                                </tr>
                            </thead>
                            <tbody id="datam" >
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</div>

<script>
$('.pilihan').select2({
    dropdownAutoWidth : true,
    width: 'auto'
});


$('#reqDistrik,#reqBlok,#reqBulan,#reqTahun').on('change', function() {
    var reqDistrik=$("#reqDistrik").val();
    var reqBlok=$("#reqBlok").val();
    var reqBulan= $("#reqBulan").val();
    var reqTahun= $("#reqTahun").val();

    // console.log(bulan);
    $("#datam").empty();
    $.getJSON("json-app/Kesesuaian_json/filter_kesesuaian?reqDistrik="+reqDistrik+"&reqBlok="+reqBlok+"&reqBulan="+reqBulan+"&reqTahun="+reqTahun,
    function(data){
         // console.log(data);
         if(data.length > 0)
         {
           data.forEach(function(entry) {
             $('#datam').append("<tr class='distrik'><td class='text-center' style='vertical-align: middle'><label style='font-weight: normal !important;'>"+entry.NO+"</label></td><td style='vertical-align: middle'><label style='font-weight: normal !important;'>"+entry.AREA_NAMA+"</label></td><td style='vertical-align: middle'><label style='font-weight: normal !important;'>"+entry.AREA_UNIT+"</label></td><td class='text-center' style='vertical-align: middle'><label style='font-weight: normal !important;'>"+entry.JUMLAH_KLAUSUL+"</label></td><td class='text-center' style='vertical-align: middle'><label style='font-weight: normal !important;'>"+entry.CONFIRM+"</label></td><td class='text-center' style='vertical-align: middle'><label style='font-weight: normal !important;'>"+entry.NOT_CONFIRM+"</label></td><td class='text-center' style='vertical-align: middle'>"+entry.PERSEN_CONFIRM+" %</td><td class='text-center' style='vertical-align: middle'>"+entry.PERSEN_NOT_CONFIRM+" %</td><td class='text-center' style='vertical-align: middle'>"+entry.RATING_MP+"</td><td class='text-center' style='vertical-align: middle'>"+entry.DAMPAK_NAMA+"</td><td class='text-center' style='vertical-align: middle'>"+entry.RATING_PP+"</td><td class='text-center' style='vertical-align: middle'>"+entry.KEMUNGKINAN_NAMA+"</td><td class='text-center' style='vertical-align: middle'>"+entry.RISIKO_NAMA+"</td><td class='text-center' style='vertical-align: middle;background-color:#"+entry.RISIKO_WARNA+"'>"+entry.RISIKO_KODE+"</td><td class='text-center' style='vertical-align: middle'>"+entry.STATUS_COMPLY+"</td><td class='text-center' style='vertical-align: middle'>"+entry.BELUM_ISI+"</td></tr>");
             });

         }
         else
         {
            $('#datam').append("<tr class='distrik'><td colspan='16' class='text-center'  bgcolor='yellow'><label style='font-weight: normal !important;'>Tidak Ada Data</label></td>/tr>");
         }
       
    });
});

$(function() {
   filterdata();

});


function filterdata() {
   $("#datam").empty();
       var reqBulan= $("#reqBulan").val();
       var reqTahun= $("#reqTahun").val();
       // console.log(reqTahun);
       $.getJSON("json-app/Kesesuaian_json/filter_kesesuaian?reqBulan="+reqBulan+"&reqTahun="+reqTahun,
        function(data){
            if(data.length > 0)
            {
          
                data.forEach(function(entry) {
                $('#datam').append("<tr class='distrik'><td class='text-center' style='vertical-align: middle'><label style='font-weight: normal !important;'>"+entry.NO+"</label></td><td style='vertical-align: middle'><label style='font-weight: normal !important;'>"+entry.AREA_NAMA+"</label></td><td style='vertical-align: middle'><label style='font-weight: normal !important;'>"+entry.AREA_UNIT+"</label></td><td class='text-center' style='vertical-align: middle'><label style='font-weight: normal !important;'>"+entry.JUMLAH_KLAUSUL+"</label></td><td class='text-center' style='vertical-align: middle' ><label style='font-weight: normal !important;'>"+entry.CONFIRM+"</label></td><td class='text-center' style='vertical-align: middle'><label style='font-weight: normal !important;'>"+entry.NOT_CONFIRM+"</label></td><td class='text-center' style='vertical-align: middle'>"+entry.PERSEN_CONFIRM+" %</td><td class='text-center' style='vertical-align: middle'>"+entry.PERSEN_NOT_CONFIRM+" %</td><td class='text-center' style='vertical-align: middle'>"+entry.RATING_MP+"</td><td class='text-center' style='vertical-align: middle'>"+entry.DAMPAK_NAMA+"</td><td class='text-center' style='vertical-align: middle'>"+entry.RATING_PP+"</td><td class='text-center' style='vertical-align: middle'>"+entry.KEMUNGKINAN_NAMA+"</td><td class='text-center' style='vertical-align: middle'>"+entry.RISIKO_NAMA+"</td><td class='text-center' style='vertical-align: middle;background-color:#"+entry.RISIKO_WARNA+"'>"+entry.RISIKO_KODE+"</td><td class='text-center' style='vertical-align: middle'>"+entry.STATUS_COMPLY+"</td><td class='text-center' style='vertical-align: middle'>"+entry.BELUM_ISI+"</td></tr>");

                });
            }
            else
            {
               $('#datam').append("<tr class='distrik'><td colspan='16' class='text-center'  bgcolor='yellow'><label style='font-weight: normal !important;'>Tidak Ada Data</label></td>/tr>");
            }
    });
}



    
// set value dropdown start

$('#reqDistrik').on('change', function() {
var reqDistrikId= this.value;


$.getJSON("json-app/outlining_assessment_json/filter_blok?reqDistrikId="+reqDistrikId,
    function(data)
    {
        // console.log(data);
        $("#reqBlok option").remove();
        $("#reqUnitMesin option").remove();
        $("#reqBlok").append('<option value="" >Pilih Blok Unit</option>');
        jQuery(data).each(function(i, item){
            $("#reqBlok").append('<option value="'+item.id+'" >'+item.text+'</option>');
        });
    });

});

$('#reqBlok').on('change', function() {

    var reqDistrikId= $("#reqDistrik").val();
    var reqBlokId= $("#reqBlok").val();
    var reqUnitMesinId= $("#reqUnitMesin").val();
    var reqBulan= $("#reqBulan").val();
    var reqTahun= $("#reqTahun").val();

    $.getJSON("json-app/outlining_assessment_json/filter_unit?reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId+"&reqBulan="+reqBulan+"&reqTahun="+reqTahun,
        function(data)
        {
            $("#reqUnitMesin option").remove();
            $("#reqUnitMesin").append('<option value="" >Pilih Unit Mesin </option>');
            jQuery(data).each(function(i, item){
                $("#reqUnitMesin").append('<option value="'+item.id+'" >'+item.text+'</option>');
            });
        });

});



// set value dropdown end

</script>