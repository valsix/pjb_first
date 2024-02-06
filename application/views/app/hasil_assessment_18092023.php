<?

include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/MatriksRisiko");
$this->load->model("base-app/Dampak");
$this->load->model("base-app/Kemungkinan");
$this->load->model("base-app/Kesesuaian");
$this->load->model("base-app/HasilAssessment");
$this->load->model("base-app/OutliningAssessment");
$this->load->model("base-app/Crud");
$this->load->model("base/Users");
$this->load->model("base-app/Distrik");
$this->load->model("base-app/ListArea");


$appuserkodehak= $this->appuserkodehak;
$appuserkodehak= $this->appuserkodehak;
$reqPenggunaid= $this->appuserid;




$pgtitle= $pg;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));


$set= new Kemungkinan();
$arrkemungkinan= [];

$statement=" AND A.STATUS IS NULL AND EXISTS(SELECT B.KEMUNGKINAN_ID FROM MATRIKS_RISIKO B WHERE B.KEMUNGKINAN_ID=A.KEMUNGKINAN_ID AND B.STATUS IS NULL)";
$set->selectByParams(array(), -1,-1,$statement);
// echo $set->query;exit;
$jmlkemungkinan=0;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("KEMUNGKINAN_ID");
    $arrdata["text"]= $set->getField("NAMA");
    $arrdata["KEMUNGKINAN_ID"]= $set->getField("KEMUNGKINAN_ID");
    $arrdata["NAMA"]=$set->getField("NAMA");
    $arrdata["N_MIN"]=$set->getField("N_MIN");
    $arrdata["N_MAX"]=$set->getField("N_MAX");
    $arrdata["BOBOT"]=$set->getField("BOBOT");
    $jmlkemungkinan++;
    array_push($arrkemungkinan, $arrdata);
}
unset($set);


$set= new Dampak();
$arrdampak= [];

$statement=" AND A.STATUS IS NULL AND EXISTS(SELECT B.DAMPAK_ID FROM MATRIKS_RISIKO B WHERE B.DAMPAK_ID=A.DAMPAK_ID AND B.STATUS IS NULL)";
$set->selectByParams(array(), -1,-1,$statement);
// echo $set->query;exit;
$jmldampak=1;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("DAMPAK_ID");
    $arrdata["text"]= $set->getField("NAMA");
    $arrdata["DAMPAK_ID"]= $set->getField("DAMPAK_ID");
    $arrdata["NAMA"]=$set->getField("NAMA");
    $arrdata["N_MIN"]=$set->getField("N_MIN");
    $arrdata["N_MAX"]=$set->getField("N_MAX");
    $arrdata["BOBOT"]=$set->getField("BOBOT");
    $jmldampak++;
    array_push($arrdampak, $arrdata);
}
unset($set);


$set= new Kesesuaian();
$arrkesesuaian= [];

$set->selectByParamsNew(array(), -1,-1,"");
// echo $set->query;exit;
$no=1;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["NO"]= $no;
    $arrdata["AREA_NAMA"]= $set->getField("KODE_INFO")." - ".$set->getField("NAMA");
    $arrdata["AREA_UNIT"]= $set->getField("AREA_UNIT");
    $arrdata["NAMA"]= $set->getField("NAMA");
    $arrdata["JUMLAH_KLAUSUL"]= $set->getField("JUMLAH_KLAUSUL");
    $arrdata["BELUM_DIISI"]= $set->getField("BELUM_DIISI");

    $no++;

    array_push($arrkesesuaian, $arrdata);
}

unset($set);

$set= new Kesesuaian();
$arrrekap= [];

$set->selectByParamsNew(array(), -1,-1," ");
// echo $set->query;exit;
$no=1;
$jumlahcomply=0;
$jumlahklausul=0;
$jumlahconfirm=0;
$jumlahnotconfirm=0;

while($set->nextRow())
{
    $arrdata= array();
    $arrdata["NO"]= $no;
    $arrdata["AREA_NAMA"]= $set->getField("KODE_INFO")." - ".$set->getField("NAMA");
    $arrdata["AREA_UNIT"]= $set->getField("AREA_UNIT");
    $arrdata["NAMA"]= $set->getField("NAMA");
    $arrdata["JUMLAH_KLAUSUL"]= $set->getField("JUMLAH_KLAUSUL");
    $arrdata["CONFIRM"]= $set->getField("CONFIRM");
    $arrdata["NOT_CONFIRM"]= $set->getField("NOT_CONFIRM");
    $arrdata["PERSEN_CONFIRM"]= $set->getField("PERSEN_CONFIRM");
    $arrdata["PERSEN_NOT_CONFIRM"]= $set->getField("PERSEN_NOT_CONFIRM");
    $arrdata["STATUS_COMPLY"]= $set->getField("STATUS_COMPLY");

    if($set->getField("STATUS_COMPLY") == "COMPLY")
    {
        $jumlahcomply+=1;
    }


    $statement=" AND A.LIST_AREA_ID =".$set->getField("LIST_AREA_ID")." AND E.ITEM_ASSESSMENT_DUPLIKAT_ID= ".$set->getField("ITEM_ASSESSMENT_DUPLIKAT_ID");

    $mp= new Kesesuaian();

    $mp->selectByParamsRating(array(), -1,-1,$statement,""," AND B4.PROGRAM_ITEM_ASSESSMENT_ID =1");
            // echo $mp->query;
    $mp->firstRow();

    $arrdata["TOTAL_BOBOT_MP"]= $mp->getField("TOTAL_BOBOT");


    $statement=" AND E.LIST_AREA_ID =".$set->getField("LIST_AREA_ID")." AND E.ITEM_ASSESSMENT_DUPLIKAT_ID= ".$set->getField("ITEM_ASSESSMENT_DUPLIKAT_ID");

    $program= new Kesesuaian();

    $program->selectByParamsItemFormulir(array(), -1,-1,$statement," AND D.PROGRAM_ITEM_ASSESSMENT_ID =1");
            // echo $program->query;
    $arrdata["RATING_MP"]="";
    $sum = 0;
    while($program->nextRow())
    {
        $arrdata["RATING_MP"]= round($program->getField("KATEGORI_BOBOT") /  $mp->getField("TOTAL_BOBOT"),2);
                // print_r($sum);

        $sum+=$arrdata["RATING_MP"];

    }
    $arrdata["RATING_MP"]=number_format($sum,2);

    $statement=" AND A.LIST_AREA_ID =".$set->getField("LIST_AREA_ID")." AND E.ITEM_ASSESSMENT_DUPLIKAT_ID= ".$set->getField("ITEM_ASSESSMENT_DUPLIKAT_ID");

    $pp= new Kesesuaian();

    $pp->selectByParamsRating(array(), -1,-1,$statement,""," AND B4.PROGRAM_ITEM_ASSESSMENT_ID =2");
            // echo $mp->query;
    $pp->firstRow();

    $arrdata["TOTAL_BOBOT_PP"]= $pp->getField("TOTAL_BOBOT");


    $statement=" AND E.LIST_AREA_ID =".$set->getField("LIST_AREA_ID")." AND E.ITEM_ASSESSMENT_DUPLIKAT_ID= ".$set->getField("ITEM_ASSESSMENT_DUPLIKAT_ID");

    $programpp= new Kesesuaian();

    $programpp->selectByParamsItemFormulir(array(), -1,-1,$statement," AND D.PROGRAM_ITEM_ASSESSMENT_ID =2");
            // echo $programpp->query;
    $arrdata["RATING_PP"]="";
    $sumpp = 0;
    while($programpp->nextRow())
    {
        $arrdata["RATING_PP"]= round($programpp->getField("KATEGORI_BOBOT") /  $pp->getField("TOTAL_BOBOT"),2);
        $sumpp+=$arrdata["RATING_PP"];

    }
    $arrdata["RATING_PP"]=number_format($sumpp,2);

    $dampak='';
    $dampakid='';

    foreach ($arrdampak as $key => $value) 
    {
        if(($arrdata["RATING_MP"]  >= $value["N_MIN"]) && ( $arrdata["RATING_MP"] <= $value["N_MAX"]))
        {
            $dampak=$value["NAMA"];
            $dampakid=$value["DAMPAK_ID"];
        }
    }

    $arrdata["DAMPAK_ID"]=$dampakid;
    $arrdata["DAMPAK_NAMA"]=$dampak;

    $kemungkinan='';
    $kemungkinanid='';

    foreach ($arrkemungkinan as $keys => $values) 
    {
                // print_r($arrdata["RATING_PP"]." - ".$values["N_MIN"].'</br>');
        if(($arrdata["RATING_PP"]  >= $values["N_MIN"]) && ( $arrdata["RATING_PP"] <= $values["N_MAX"]))
        {
            $kemungkinan=$values["NAMA"];
            $kemungkinanid=$values["KEMUNGKINAN_ID"];
        }
    }

    $arrdata["KEMUNGKINAN_ID"]=$kemungkinanid;
    $arrdata["KEMUNGKINAN_NAMA"]=$kemungkinan;
    $arrdata["RISIKO_ID"]="";
    $arrdata["RISIKO_NAMA"]= "";
    $arrdata["RISIKO_KODE"]= "";
    $arrdata["RISIKO_WARNA"]= "";

    if(!empty($arrdata["DAMPAK_NAMA"]) && !empty($arrdata["KEMUNGKINAN_NAMA"]) )
    {

        $statement=" AND A.DAMPAK_ID =".$arrdata["DAMPAK_ID"]." AND A.KEMUNGKINAN_ID =".$arrdata["KEMUNGKINAN_ID"];

        $risiko= new MatriksRisiko();

        $risiko->selectByParamsLaporan(array(), -1,-1,$statement,"");
                // echo $mp->query;
        $risiko->firstRow();

        $arrdata["RISIKO_ID"]= $risiko->getField("RISIKO_ID");
        $arrdata["RISIKO_NAMA"]= $risiko->getField("RISIKO");
        $arrdata["RISIKO_KODE"]= $risiko->getField("KODE");
        $arrdata["RISIKO_WARNA"]= $risiko->getField("KODE_WARNA");
    }

    $no++;

    array_push($arrrekap, $arrdata);
}

$jumlahrendah=0;
$jumlahmoderat=0;
$jumlahtinggi=0;
$jumlahsangattinggi=0;
$jumlahekstrem=0;

if(!empty($arrrekap))
{
    $keysrendah = array_keys(array_column($arrrekap, 'RISIKO_ID'), 1);
    $arrrendah = array_map(function($k) use ($arrrekap){return $arrrekap[$k];}, $keysrendah);
    $jumlahrendah= count($arrrendah);

    $keysmoderat = array_keys(array_column($arrrekap, 'RISIKO_ID'), 2);
    $arrmoderat = array_map(function($k) use ($arrrekap){return $arrrekap[$k];}, $keysmoderat);
    $jumlahmoderat= count($arrmoderat);

    $keystinggi = array_keys(array_column($arrrekap, 'RISIKO_ID'), 3);
    $arrtinggi = array_map(function($k) use ($arrrekap){return $arrrekap[$k];}, $keystinggi);
    $jumlahtinggi= count($arrtinggi);

    $keyssangattinggi = array_keys(array_column($arrrekap, 'RISIKO_ID'), 4);
    $arrsangattinggi = array_map(function($k) use ($arrrekap){return $arrrekap[$k];}, $keyssangattinggi);
    $jumlahsangattinggi= count($arrsangattinggi);

    $keysekstrem = array_keys(array_column($arrrekap, 'RISIKO_ID'), 5);
    $arrekstrem = array_map(function($k) use ($arrrekap){return $arrrekap[$k];}, $keysekstrem);
    $jumlahekstrem= count($arrekstrem);
}

// print_r($keysekstrem);exit;


$jumlahconfirm = array_sum(array_column($arrrekap, 'CONFIRM'));
$jumlahnotconfirm = array_sum(array_column($arrrekap, 'NOT_CONFIRM'));


$jumlahklausul=$no-1;
$percomply=0;
$jumlahklausulassessment=$jumlahconfirm+$jumlahnotconfirm;
if(!empty($jumlahcomply))
{
    $percomply=round($jumlahcomply/$jumlahklausul * 100 ,1);
}



$set= new HasilAssessment();
$arrRekomendasi= [];

$statement="";
$set->selectByParamsRekomendasi(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["KATEGORI_INFO"]= $set->getField("KATEGORI_INFO");
    $arrdata["JUMLAH_REKOMENDASI"]= $set->getField("JUMLAH_REKOMENDASI");
    array_push($arrRekomendasi, $arrdata);
}
unset($set);

$set= new HasilAssessment();
$arrJenisRekomendasi= [];

$statement="";
$set->selectByParamsJenisRekomendasi(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["JENIS_INFO"]= $set->getField("JENIS_INFO");
    $arrdata["JUMLAH_JENIS"]= $set->getField("JUMLAH_JENIS");
    array_push($arrJenisRekomendasi, $arrdata);
}
unset($set);

$set= new HasilAssessment();
$arrPrioritasRekomendasi= [];

$statement="";
$set->selectByParamsPrioritasRekomendasi(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["PRIORITAS_INFO"]= $set->getField("PRIORITAS_INFO");
    $arrdata["PRIORITAS_REKOMENDASI"]= $set->getField("PRIORITAS_REKOMENDASI");
    array_push($arrPrioritasRekomendasi, $arrdata);
}
unset($set);

$set= new HasilAssessment();
$arrProyeksiRekomendasi= [];

$statement=" AND TIMELINE_REKOMENDASI_ID IS NOT NULL";
$set->selectByParamsRekomendasiProyeksi(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["KATEGORI_INFO"]= $set->getField("KATEGORI_INFO");
    $arrdata["JUMLAH_SEM"]= $set->getField("JUMLAH_SEM");
    $arrdata["TIMELINE_REKOMENDASI_ID"]= $set->getField("TIMELINE_REKOMENDASI_ID");
    $arrdata["TAHUN"]= $set->getField("TAHUN");
    array_push($arrProyeksiRekomendasi, $arrdata);
}

$jumlahProyeksiRekomendasi=count($arrProyeksiRekomendasi);
unset($set);

$set= new HasilAssessment();
$arrKategoriRekomendasi= [];

$statement=" AND TIMELINE_REKOMENDASI_ID IS NOT NULL";
$set->selectByParamsRekomendasiKategori(array(), -1,-1,$statement);
                                        // echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["KATEGORI_REKOMENDASI_ID"]= $set->getField("KATEGORI_REKOMENDASI_ID");
    $arrdata["KATEGORI_INFO"]= $set->getField("KATEGORI_INFO");
    array_push($arrKategoriRekomendasi, $arrdata);
}

unset($set);



// print_r($arrRekomendasiProyeksi);exit;



$reqTahun= date('Y');
$semester="SMT";
$arrSmtTahun=[];
for ($i=0; $i < 4 ; $i++) { 
    for ($z=1; $z < 3 ; $z++) { 
        $arrdata= array();
        $smtahun=  $semester.' - '.$z;
        $arrdata["ID"]= $reqTahun."_".$z;
        $arrdata["NAMA"]= $smtahun;
        array_push($arrSmtTahun, $arrdata);
    }
    $reqTahun++;
}


$set= new OutliningAssessment();
$statement = "";
$arrTahun=[];
$set->selectByParamsRekomendasiTahun(array(), -1, -1, $statement," ORDER BY A.TAHUN");

while($set->nextRow())
{
    $arrdata= array();
    $arrdata["TAHUN"]= $set->getField("TAHUN");
    array_push($arrTahun, $arrdata);
}

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


$set= new Distrik();
$arrdistrik= [];


if(!empty($idDistrik))
{
   
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


$set= new ListArea();
$arrlistarea= [];

$statement=" AND EXISTS
    (
        SELECT A.LIST_AREA_ID 
        FROM OUTLINING_ASSESSMENT_DETIL B  
        WHERE A.LIST_AREA_ID=B.LIST_AREA_ID
    )";
$set->selectByParams(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["LIST_AREA_ID"]= $set->getField("LIST_AREA_ID");
    $arrdata["KODE"]= $set->getField("KODE");
    $arrdata["NAMA"]= $set->getField("NAMA");
    array_push($arrlistarea, $arrdata);
}
unset($set);


?>
<style type="text/css">
   
    .tbmatrix {
        background-color: #fff;
    }

    .tbmatrix,
    .tbmatrix tr,
    .tbmatrix tr td,
    .tbmatrix tr th {
        border: 1px solid #9e9e9e;
        font-size: 11px;
        vertical-align: middle;
        padding: 5px;
        font-family: 'Lato', Arial, Tahoma, sans-serif !important;
    }

    .tbmatrix tr td div.zoom-loop {
        color: #000 !important;
    }

    .headcolor {
        background-color:yellow;
    }

    .parent {
     /* width:100%;
      display: inline-block;
      height:100%;
      overflow: auto;*/
    }

    .judul-halamana{
        padding: 10px 15px;
        margin-bottom: 20px;

        font-family: 'avenir-next-demibold';
        font-size: 18px;
        text-transform: uppercase;

        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        border-radius: 0px;

        border-bottom: 1px solid rgba(0,0,0,0.2);
        
        top: 0;
        z-index: 99;
    }

    .judul {
       /* background: url("../images/img-line.png") bottom left no-repeat;*/
        background-size: auto 1px;

        font-size: 15px;
        font-family: 'Montserrat-Bold';
        text-transform: uppercase;

        padding-top: 20px;
        padding-bottom: 10px;

    }

</style>
<!-- HIGHCHART -->
<!-- <script src="lib/highcharts-gauge/highcharts.js"></script>
<script src="lib/highcharts-gauge/highcharts-more.js"></script>
<script src="lib/highcharts-gauge/solid-gauge.js"></script> -->
<script src="lib/highcharts/highcharts.js"></script>
<script src="lib/highcharts/exporting.js"></script>
<script src="lib/html2canvas/html2canvas.min.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<div class="judul-halamana"> <?=$pgtitle?></div>
<div class="col-md-12" style="margin-bottom: 20px; border: none;">
    <button id="btnfilter" class="filter btn btn-default pull-left">Filter <i class="fa fa-caret-down" aria-hidden="true"></i></button>
</div>  
<div class="col-md-12 konten-area divfilter "  >   
             
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-1 control-label">Distrik </label>
        <div class="col-sm-2">
            <select class="form-control jscaribasicmultiple" id="reqDistrik"  style="width:100%;" >
                <option value="">Semua Distrik</option>
                <? 
                foreach($arrdistrik as $item) 
                {
                    $selectvalid= $item["id"];
                    $selectvaltext= $item["text"];

                    $selected="";
                    if($idDistrik== $selectvalid)
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
        
        <label for="inputEmail3" class="col-sm-1 control-label">Blok/Unit </label>
        <div class="col-sm-2">
            <select class="form-control jscaribasicmultiple" id="reqBlok" <?=$disabled?>  style="width:100%;" >
                <option value="">Pilih Blok/Unit</option>
            </select>
        </div> 

        <label for="inputEmail3" class="col-sm-1 control-label">Area </label>
        <div class="col-sm-2">
            <select name="reqListAreaId" id="reqListAreaId" class="form-control datatable-input">
                <option value="">Semua Area</option>
                <?
                foreach ($arrlistarea as $key => $value) 
                {
                    ?>
                    <option value="<?=$value["LIST_AREA_ID"]?>" ><?=$value["NAMA"]?></option>
                    <?
                }
                ?>
            </select>
        </div> 

        <div style="margin-left: 15px">
           <button class="btn btn-primary btn-sm" onclick="setCariInfo()" ><i class="fas fa-search"></i> Cari</button>
        </div>     
    </div>
</div>
<div class="col-md-12 konten-area divfilter "  >               
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-1 control-label">Tahun </label>
        <div class="col-sm-2">
            <select name="reqTahun" id="reqTahun" class="form-control datatable-input">
                <option value="">Semua</option>
                <?
                foreach ($arrTahun as $key => $value) 
                {
                    ?>
                    <option value="<?=$value["TAHUN"]?>" ><?=$value["TAHUN"]?></option>
                    <?
                }
                ?>
            </select>
        </div>
        
        <label for="inputEmail3" class="col-sm-1 control-label">Status </label>
        <div class="col-sm-2">
            <select name="reqStatus" id="reqStatus" class="form-control datatable-input">
                <option value="">Semua</option>
                <option value="20">Approve</option>
                <option value="100">Not Approve</option>
            </select>
        </div>    
    </div>
</div>
<div class="col-md-12 konten-area divfilter "  >               
    <div class="form-group">
       
    </div>
</div>

<div class="col-md-12 konten-area  divfilter "  >
    
</div>

<div class="col-md-12" style="overflow: auto;height: calc(100vh - 180px);" >
    <div class="konten-area" style="padding: 15px 8px;float:left;width:3000px;background-color: white" >
            <div class="row">
                    <div class="col-sm-4 col-lg-2 " style="padding: 0px 7px !important; height: fit-content;">
                        <span > <button class="btn btn-success btn-sm" onclick="btnCetakPng('ctkjumlahitem','item_diisi')">Download Png</button></span>
                        <div style="text-align: center; ">
                            <div id="ctkjumlahitem" style="text-align: left; width:100%;">
                                <div class="page-header" style="background-color: green;width:100%;">
                                    <h3><i class="fa fa-file-text fa-lg"></i> Jumlah Item Assessment Yang Belum Diisi </h3>      
                                </div>
                                <br>
                                <table class="tbmatrix"  style="width:100%;" id="jumlahitem">
                                    <tr> 
                                        <th class="text-center headcolor" style="width:5%;">No</th>
                                        <th class="text-center headcolor" style="width:40%;">Area</th>
                                        <th class="text-center headcolor" style="width:40%;">Nama Peralatan</th>
                                        <th class="text-center headcolor" >Jumlah Klausul Belum Diisi</th>
                                    </tr>
                                    <?
                                    $no=1;
                                    foreach ($arrkesesuaian as $key => $value) 
                                    {
                                    ?>
                                    <tr>
                                        <td class="text-center"><?=$no?></td>
                                        <td><?=$value["AREA_NAMA"]?></td>
                                         <td><?=$value["AREA_UNIT"]?></td>
                                        <td class="text-center"><?=$value["BELUM_DIISI"]?></td>
                                    </tr>
                                    <?
                                    $no++;
                                    }
                                    ?>
                                </table>        
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-lg-2" style="padding: 0px 7px !important; height: fit-content">
                        <span > <button class="btn btn-success btn-sm" onclick="btnCetakPng('ctkrekap','matriks_area')">Download Png</button></span>
                        <div style="text-align: center; ">
                            <div id="ctkrekap" style="text-align: left; width:100%;">
                                <div class="page-header" style="background-color: green;width:100%;">
                                    <h3><i class="fa fa-file-text fa-lg"></i> Rekapitulasi Matriks Risiko per Area </h3>      
                                </div>
                                <br>
                                <table class="tbmatrix"  style="width:100%;" id="rekapmatrik">
                                    <tr> 
                                        <th class="text-center headcolor" style="width:5%;">No</th>
                                        <th class="text-center headcolor" style="width:40%;">Area</th>
                                        <th class="text-center headcolor" style="width:40%;">Nama Peralatan</th>
                                        <th class="text-center headcolor" style="width:10%;">Confirm</th>
                                        <th class="text-center headcolor" style="width:10%;">Not Confirm</th>
                                        <th class="text-center headcolor" style="width:25%;">Risiko</th>
                                        <th class="text-center headcolor" >Matriks Risiko</th>
                                    </tr>
                                    <?
                                    $no=1;
                                    foreach ($arrrekap as $key => $value) 
                                    {
                                    ?>
                                    <tr>
                                        <td class="text-center" ><?=$no?></td>
                                        <td ><?=$value["AREA_NAMA"]?></td>
                                        <td ><?=$value["AREA_UNIT"]?></td>
                                        <td class="text-center"><?=$value["CONFIRM"]?></td>
                                        <td class="text-center"><?=$value["NOT_CONFIRM"]?></td>
                                        <td class="text-center"><?=$value["RISIKO_NAMA"]?></td>
                                        <td class="text-center" style="background-color:#<?=$value["RISIKO_WARNA"]?> "><?=$value["RISIKO_KODE"]?></td>
                                    </tr>
                                    <?
                                    $no++;
                                    }
                                    ?>
                                </table>        
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-lg-2" style="padding: 0px 7px !important; height: fit-content">
                        <span > <button class="btn btn-success btn-sm" onclick="btnCetakPng('ctkmatriks','matriks_risiko')">Download Png</button></span>
                        <div style="text-align: center; margin-top: 10px;position: inherit; width:fit-content; margin: auto; height:fit-content">
                            <div id="ctkmatriks" style="text-align: left; width:500px;">
                                <div class="page-header" style="background-color: green;width:100%;">
                                    <h3><i class="fa fa-file-text fa-lg"></i> Rekapitulasi Matriks Risiko</h3>      
                                </div>
                                <br>
                                <table class="tbmatrix" id="rmatriksrisiko">
                                    <tr> 
                                        <td rowspan='<?=$jmlkemungkinan+1?>' style='font-weight:bold;position:relative;width:25px'>
                                        <div style='position:absolute;right: 19px;top: 260px;width: 0px;-ms-transform: rotate(-90deg);-webkit-transform: rotate(-90deg);transform: rotate(-90deg);height: 0px;word-wrap: normal;'>TINGKAT&nbsp;KEMUNGKINAN
                                        </div>
                                        </td>
                                    </tr>

                                    <?
                                    $z=$jmlkemungkinan-1;
                                    foreach ($arrkemungkinan as $key => $value) 
                                    {

                                        $alpnum=toAlpha($z);

                                        $set= new MatriksRisiko();
                                        $arrmatrik= [];

                                        $statement=" AND A.STATUS IS NULL AND A.KEMUNGKINAN_ID= ".$value["id"];
                                        $set->selectByParamsLaporan(array(), -1,-1,$statement);
                                        // echo $set->query;
                                        while($set->nextRow())
                                        {
                                            $arrdata= array();
                                            $arrdata["id"]= $set->getField("MATRIKS_RISIKO_ID");
                                            $arrdata["text"]= $set->getField("NAMA");
                                            $arrdata["RISIKO"]= $set->getField("RISIKO");
                                            $arrdata["KODE"]= $set->getField("KODE");
                                            $arrdata["KEMUNGKINAN_ID"]= $set->getField("KEMUNGKINAN_ID");
                                            $arrdata["DAMPAK"]= $set->getField("DAMPAK");
                                            $arrdata["DAMPAK_ID"]= $set->getField("DAMPAK_ID");
                                            $arrdata["KEMUNGKINAN"]= $set->getField("KEMUNGKINAN");
                                            $arrdata["KODE_WARNA"]= $set->getField("KODE_WARNA");
                                            array_push($arrmatrik, $arrdata);
                                        }
                                        unset($set);

                                    ?>
                                    <tr>
                                        <td align='center' style='width: 25px;text-align:center;vertical-align:middle;font-weight:bold'><?=$value["text"]?></td>
                                        <td style='width: 25px;text-align:center;font-weight:bold;vertical-align:middle'><?=$alpnum?></td>
                                        <?
                                        foreach ($arrmatrik as $key => $value) 
                                        {

                                            ?>
                                            <td class='bg-#<?=$value["KODE_WARNA"]?>' style='border:1px solid #555;background-color:#<?=$value["KODE_WARNA"]?>;  padding:1px; ' height='75px' width='75px' align='center' valign='middle'>
                                                <div style='position:relative;height:75px;width:75px; vertical-align:middle; text-align:center;padding:30px 0px;'><?=$value["RISIKO"]?>
                                                    <div style='position:absolute;top:5px;right:5px;'>
                                                        <?

                                                        if( in_array( $value["KODE"] ,array_column($arrrekap, 'RISIKO_KODE') ) )
                                                        {

                                                            $keyskode = array_keys(array_column($arrrekap, 'RISIKO_KODE'), $value["KODE"]);
                                                            $arrkode = array_map(function($k) use ($arrrekap){return $arrrekap[$k];}, $keyskode);

                                                            $total= count($keyskode);


                                                            // foreach ($arrkode as $keyx => $valuex) 
                                                            // {
                                                                ?>
                                                                <div style="font-size: 13px;width:35px;height:20px;background-color:#fff;border:1px solid black;color:black;margin-right: 15px;" class="dot"><?=$total?>
                                                                </div>
                                                                <?
                                                            // }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </td>
                                        <?
                                        }
                                        ?>
                                    </tr>
                                    <?
                                     $z--;
                                    }
                                    ?>
                                   
                                    <tr >
                                        <td colspan='3' rowspan='3' ></td>
                                        <?
                                        for ($i=1; $i < $jmldampak ; $i++) 
                                        { 
                                        ?>
                                        <td style='font-weight:bold;text-align:center'><?=$i?></td>
                                        <?
                                        }
                                        ?>
                                            
                                    </tr>
                                    <tr>
                                        <?
                                        foreach ($arrdampak as $key => $value) 
                                        {
                                        ?>
                                            <td style='font-weight:bold;text-align:center;vertical-align:middle'><?=$value["text"]?></td>
                                        <?
                                        }
                                        ?>
                                    </tr>
                                    <tr>
                                        <td colspan='5' style='font-weight:bold;text-align:center'>TINGKAT DAMPAK</td>
                                    </tr> 
                                </table>        
                            </div>
                        </div>
                        <div style="text-align: center; margin-top: 10px;position: inherit; width:fit-content; margin: auto; height:fit-content;">
                            <div id="divmatrix" style="text-align: left; width:500px;">
                                <div class="page-header" style="background-color: green;width:100%;">
                                    <h3><i class="fa fa-file-text fa-lg"></i> Chart Rekapitulasi Rekomendasi </h3>      
                                </div>
                                <div class="judul" style="text-align: center;"></div>
                                <div class="area-konten" style="">
                                    <div id="pie-rekomendasi" style=" height: 300px; margin: 0 auto"></div>
                                </div> 

                                <div class="page-header" style="background-color: green;width:100%;">
                                    <h3><i class="fa fa-file-text fa-lg"></i> Chart Jenis Rekomendasi </h3>      
                                </div>
                                <div class="judul" style="text-align: center;"></div>
                                <div class="area-konten" style="">
                                    <div id="pie-jenisrekomendasi" style=" height: 300px; margin: 0 auto"></div>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 col-lg-2" style="padding: 0px 7px !important; height: fit-content" style="margin-right: 200px;">
                        <span > <button class="btn btn-success btn-sm" onclick="btnCetakPng('ctktingkat','rekap_tingkat')">Download Png</button></span>
                        <div style="text-align: center; margin-top: 10px;position: inherit; width:fit-content; margin: auto; height:fit-content">
                            <div id="ctktingkat" style="text-align: left; width:500px;">
                                <div class="page-header" style="background-color: green;width:100%;">
                                    <h3><i class="fa fa-file-text fa-lg"></i> Rekapitulasi Tingkat Kesesuaian </h3>     
                                </div>
                                <table class="tbmatrix"  style="width:100%;" id="rekaptingkat">
                                    <tr> 
                                        <th class="text-center headcolor" colspan="2" >Persentase Tingkat Kesesuaian</th>
                                    </tr>
                                    <tr>
                                        <td class="text-center" style="width: 60%">Compliance Percentage (%)</td>
                                        <td class="text-center" style="background-color: red"><?=$percomply?> %</td>
                                    </tr>
                                </table>    
                                <br>    
                            </div>
                            <div id="divmatrix" style="text-align: left; width:500px;">
                                <div class="page-header" style="background-color: green;width:100%;">
                                    <h3><i class="fa fa-file-text fa-lg"></i> Chart Persentase Tingkat Kesesuaian </h3>     
                                </div>
                                <div class="judul" style="text-align: center;"></div>
                                <div class="area-konten" style="">
                                    <div id="pie-kesesuaian" style=" height: 250px; margin: 0 auto;font-s"></div>
                                </div>    
                                <br>    
                            </div>
                            <div id="divmatrix" style="text-align: left; width:500px;">
                                <div class="page-header" style="background-color: green;width:100%;">
                                    <h3><i class="fa fa-file-text fa-lg"></i> Chart Jumlah Prioritas Rekomendasi </h3>     
                                </div>
                                <div class="judul" style="text-align: center;"></div>
                                <div class="area-konten" style="">
                                    <div id="pie-prioritas" style=" height: 250px; margin: 0 auto"></div>
                                </div>    
                                <br> 
                            </div>
                           
                        </div>
                        <span > <button class="btn btn-success btn-sm" onclick="btnCetakPng('jumlah_area','jumlah_area')">Download Png</button></span>
                        <div style="text-align: center; margin-top: 10px;position: inherit; width:fit-content; margin: auto; height:fit-content">
                            <div id="jumlah_area" style="text-align: left; width:500px;">
                                <div class="page-header" style="background-color: green;width:100%;">
                                    <h3><i class="fa fa-file-text fa-lg"></i> Rekapitulasi Assessment </h3>      
                                </div>
                                <table class="tbmatrix"  style="width:100%;"  id="rekaprekapitulasi">
                                    <tr> 
                                        <th class="text-center headcolor" style="width: 75%">Kategori</th>
                                        <th class="text-center headcolor" >Jumlah</th>
                                    </tr>
                                    <tr>
                                        <td >Jumlah Area Assessment</td>
                                        <td class="text-center"><?=$jumlahklausul?></td>
                                    </tr>
                                    <tr>
                                        <td >Jumlah Klausul Assessment</td>
                                        <td class="text-center"><?=$jumlahklausulassessment?></td>
                                    </tr>
                                    <tr>
                                        <td >Jumlah Area Risiko Rendah</td>
                                        <td class="text-center"><?=$jumlahrendah?></td>
                                    </tr>
                                    <tr>
                                        <td >Jumlah Area Risiko Moderat</td>
                                        <td class="text-center"><?=$jumlahmoderat?></td>
                                    </tr>
                                    <tr>
                                        <td >Jumlah Area Risiko Tinggi</td>
                                        <td class="text-center"><?=$jumlahtinggi?></td>
                                    </tr>
                                    <tr>
                                        <td >Jumlah Area Risiko Sangat Tinggi</td>
                                        <td class="text-center"><?=$jumlahsangattinggi?></td>
                                    </tr>
                                    <tr>
                                        <td >Jumlah Area Risiko Ekstrem</td>
                                        <td class="text-center"><?=$jumlahekstrem?></td>
                                    </tr>
                                </table>   
                            </div>
                        </div>
                        <br>
                        <span > <button class="btn btn-success btn-sm" onclick="btnCetakPng('rekapkategori','jumlah_kategori')">Download Png</button></span>
                        <div style="text-align: center; margin-top: 10px;position: inherit; width:fit-content; margin: auto; height:fit-content">
                            <div  style="text-align: left; width:500px;">
                                <div class="page-header" style="background-color: green;width:100%;">
                                    <h3><i class="fa fa-file-text fa-lg"></i> Rekapitulasi Rekomendasi </h3>      
                                </div>
                                <table class="tbmatrix"  style="width:100%;" id="rekapkategori">
                                    <tr> 
                                        <th class="text-center headcolor" style="width: 60%">Kategori Rekomendasi</th>
                                        <th class="text-center headcolor" >Jumlah</th>
                                    </tr>
                                    <?
                                        foreach ($arrRekomendasi as $key => $value) 
                                        {

                                    ?>
                                        <tr>
                                            <td class="" ><?=$value["KATEGORI_INFO"]?></td>
                                            <td class="text-center"><?=$value["JUMLAH_REKOMENDASI"]?></td>
                                        </tr>
                                    <?
                                        }
                                    ?>
                                </table>
                                <br>
                                <span > <button class="btn btn-success btn-sm" onclick="btnCetakPng('rekapjenis','jenis_rekomendasi')">Download Png</button></span>
                                <br>
                                <br>
                                <table class="tbmatrix"  style="width:100%;" id="rekapjenis">
                                    <tr> 
                                        <th class="text-center headcolor" style="width: 60%" >Jenis Rekomendasi</th>
                                        <th class="text-center headcolor" >Jumlah</th>
                                    </tr>
                                    <?
                                        foreach ($arrJenisRekomendasi as $key => $value) 
                                        {

                                    ?>
                                        <tr>
                                            <td class="" ><?=$value["JENIS_INFO"]?></td>
                                            <td class="text-center"><?=$value["JUMLAH_JENIS"]?></td>
                                        </tr>
                                    <?
                                        }
                                    ?>
                                </table>
                                <br>
                                <span > <button class="btn btn-success btn-sm" onclick="btnCetakPng('rekapprioritas','prioritas_rekomendasi')">Download Png</button></span>
                                <br>
                                <br>
                                <table class="tbmatrix"  style="width:100%;" id="rekapprioritas">
                                    <tr> 
                                        <th class="text-center headcolor" style="width: 60%">Prioritas Rekomendasi</th>
                                        <th class="text-center headcolor" >Jumlah</th>
                                    </tr>
                                    <?
                                        foreach ($arrPrioritasRekomendasi as $key => $value) 
                                        {

                                    ?>
                                        <tr>
                                            <td class="" ><?=$value["PRIORITAS_INFO"]?></td>
                                            <td class="text-center"><?=$value["PRIORITAS_REKOMENDASI"]?></td>
                                        </tr>
                                    <?
                                        }
                                    ?>
                                </table>     
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-lg-1" style="padding: 0px 7px !important; height: fit-content">
                        <span > <button class="btn btn-success btn-sm" onclick="btnCetakPng('ctkproyeksi','proyeksi_tingkat')">Download Png</button></span>
                        <div style="text-align: center; margin-top: 10px;position: inherit; width:fit-content; margin: auto; height:fit-content">
                            <div  style="text-align: left; width:600px;">
                                <div id="ctkproyeksi">
                                    <div class="page-header" style="background-color: green;width:100%;">
                                        <h3><i class="fa fa-file-text fa-lg"></i> Proyeksi Tingkat Kesesuaian </h3>     
                                    </div>
                                    <table class="tbmatrix"  style="width:100%;" id="rekapproyeksi">
                                        <tr>
                                            <th class="text-center headcolor" rowspan="2">Kategori Rekomendasi</th>
                                            <?
                                                $reqTahun= date('Y');
                                                for ($i=0; $i < 4 ; $i++) 
                                                {  
                                                ?>
                                                <th class="text-center headcolor" colspan="2"><?=$reqTahun?></th>
                                                <?
                                                $reqTahun++;
                                                }
                                            ?>

                                        </tr>
                                        <tr>
                                            <?
                                            foreach ($arrSmtTahun as $key => $value) 
                                            {

                                                ?>
                                                <th class="text-center headcolor" ><?=$value["NAMA"]?></th>
                                                <?
                                            }
                                            ?>
                                        </tr>
                                        
                                        <?
                                        foreach ($arrKategoriRekomendasi as $key => $value) 
                                        {

                                        ?>
                                            <tr>
                                                <td ><?=$value["KATEGORI_INFO"]?></td>

                                                <?
                                                foreach ($arrSmtTahun as $keys => $values) 
                                                {   
                                                    $set= new HasilAssessment();

                                                    $arrRekomendasiProyeksi= [];

                                                    $statement=" AND TIMELINE_REKOMENDASI_ID IS NOT NULL 
                                                    AND A.KATEGORI_REKOMENDASI_ID=".$value["KATEGORI_REKOMENDASI_ID"]." 
                                                    AND B.TIMELINE_REKOMENDASI_ID='".$values["ID"]. "' ";
                                                    $set->selectByParamsRekomendasiProyeksi(array(), -1,-1,$statement);
                                                    $jmlsem=0;                                                   // echo 1;
                                                    while($set->nextRow())
                                                    {
                                                        $arrdata= array();
                                                        $arrdata["KATEGORI_REKOMENDASI_ID"]= $set->getField("KATEGORI_REKOMENDASI_ID");
                                                        $arrdata["KATEGORI_INFO"]= $set->getField("KATEGORI_INFO");
                                                        $arrdata["JUMLAH_SEM"]= $set->getField("JUMLAH_SEM");
                                                        $arrdata["TAHUN"]= $set->getField("TAHUN");
                                                        $arrdata["TIMELINE_REKOMENDASI_ID"]= $set->getField("TIMELINE_REKOMENDASI_ID");
                                                        array_push($arrRekomendasiProyeksi, $arrdata);

                                                    }
                                                                                                        
                                                ?>
                                                        <?
                                                        if( in_array( $values["ID"] ,array_column($arrRekomendasiProyeksi, 'TIMELINE_REKOMENDASI_ID') ) )
                                                        {
                                                        ?>
                                                            <?
                                                            foreach ($arrRekomendasiProyeksi as $keyx => $valuex) 
                                                            {
                                                            ?>
                                                            <td class="text-center"><?=$valuex["JUMLAH_SEM"]?></td>
                                                            <?
                                                            }
                                                            ?>
                                                        <?
                                                        }
                                                        else
                                                        {
                                                        ?>
                                                        <td class="text-center">0</td>
                                                        <?
                                                        }
                                                }
                                                ?>
                                            </tr>
                                        <?
                                        }
                                        ?>


                                            <tr>
                                                <td class="text-center headcolor">Jumlah Rekomendasi</td>

                                            <?
                                            foreach ($arrSmtTahun as $keys => $values) 
                                            {
                                            ?> 
                                                <?

                                                $set= new HasilAssessment();
                                                $arrTotalRekomendasi= [];
                                               
                                                $statement=" AND TIMELINE_REKOMENDASI_ID IS NOT NULL 
                                                AND B.TIMELINE_REKOMENDASI_ID='".$values["ID"]. "' ";
                                                $set->selectByParamsRekomendasiProyeksiTotal(array(), -1,-1,"",$statement);
                                                // echo $set->query;exit;
                                                $jmlsem=0;                                                   
                                                while($set->nextRow())
                                                {

                                                   $arrdata= array();
                                                   $arrdata["TOTAL_SEM"]= $set->getField("TOTAL_SEM");
                                                   $arrdata["TIMELINE_REKOMENDASI_ID"]= $set->getField("TIMELINE_REKOMENDASI_ID");
                                                   array_push($arrTotalRekomendasi, $arrdata);
                                                }
                                                ?>

                                                <?
                                                if( in_array( $values["ID"] ,array_column($arrTotalRekomendasi, 'TIMELINE_REKOMENDASI_ID') ) )
                                                {
                                                    ?>
                                                    <?
                                                    foreach ($arrTotalRekomendasi as $keyx => $valuex) 
                                                    {
                                                        ?>
                                                        <td class="text-center"><?=$valuex["TOTAL_SEM"]?></td>
                                                        <?
                                                    }
                                                    ?>
                                                    <?
                                                }
                                                else
                                                {
                                                    ?>
                                                    <td class="text-center">0</td>
                                                    <?
                                                }
                                                ?>
                                            <?
                                            }
                                            ?>


                                            </tr>
                                       
                                        <tr>
                                            <td class="text-center headcolor">Proyeksi Tingkat Kesesuaian</td>
                                            <?
                                            foreach ($arrSmtTahun as $keys => $values) 
                                            {

                                                $smt = substr($values["ID"], strpos($values["ID"], "_") + 1);
                                                $thn =substr($values["ID"],0,strrpos($values["ID"],'_'));   

                                                if($smt==1)
                                                {
                                                    $smt=" AND F.BULAN <= '06' ";
                                                }
                                                else
                                                {
                                                    $smt=" AND F.BULAN > '06' ";
                                                }

                                                $statement =  $smt." AND F.TAHUN=".$thn;

                                                $set= new HasilAssessment();
                                                $arrTotalRekomendasi= [];                                           
                                                $set->selectByParamsRekomendasiProyeksiPersentase(array(), -1,-1,"",$statement);
                                                // echo $set->query;exit;
                                                $jmlsem=0;
                                                $jumlahcomplysmt=$jumlahcomplynotsmt=$jumlahklausulsmt=0;                                                  
                                                while($set->nextRow())
                                                {

                                                   $arrdata= array();
                                                   $arrdata["STATUS_COMPLY"]= $set->getField("STATUS_COMPLY");
                                                   $arrdata["PERSEN_CONFIRM"]= $set->getField("PERSEN_CONFIRM");
                                                   array_push($arrTotalRekomendasi, $arrdata);

                                                   if($set->getField("STATUS_COMPLY")=="COMPLY")
                                                   {
                                                        $jumlahcomplysmt+=1;
                                                   }
                                                   else
                                                   {
                                                        $jumlahcomplynotsmt+=1;
                                                   }
                                                   $jumlahklausulsmt++;
                                                }

                                                if(!empty($jumlahcomplysmt))
                                                {
                                                    $percomplysmt=round($jumlahcomplysmt/$jumlahklausulsmt * 100 ,1);
                                                }

                                                
                                                $stylebg="";
                                                if($percomplysmt <=30)
                                                {
                                                    $stylebg="background-color: red";
                                                }
                                                elseif($percomplysmt > 30 && $percomplysmt <= 50 )
                                                {
                                                    $stylebg="background-color: yellow";
                                                }
                                                elseif($percomplysmt > 50 && $percomplysmt < 75 )
                                                {
                                                    $stylebg="background-color: blue";
                                                }
                                                elseif($percomplysmt > 75  )
                                                {
                                                    $stylebg="background-color: green";
                                                }

                                                // var_dump($jumlahcomplysmt);


                                            ?>
                                                <td class="text-center" style="<?=$stylebg?>"><?=$percomplysmt?> %</td>
                                            <?
                                            }
                                            ?>
                                        </tr>
                                    </table>
                                </div>    
                                <br>
                                <div class="page-header" style="background-color: green;width:100%;">
                                    <h3><i class="fa fa-file-text fa-lg"></i> Kesesuaian Per Area </h3>      
                                </div>
                                <div class="area-konten" style="">
                                    <div id="pie-area" style=" height: 500px; margin: 0 auto"></div>
                                </div>    
                            </div>
                        </div>
                    </div>
                <!-- </div> -->
            </div>
        </div>
</div>
<a href="#" id="btnCari" style="display: none;" title="Cari"></a>
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script> -->
<script type="text/javascript">

    function btnCetakPng(id,name)
    {   
        const captureElement = document.querySelector('#'+id);
        html2canvas(captureElement, {
            scale: 2,
            onrendered : function(canvas) {

            }
        }).then(canvas => {
          canvas.style.display = 'none'
          document.body.appendChild(canvas);
          return canvas;
        }).then(canvas => {
            const image = canvas.toDataURL('image/png').replace('image/png', 'image/octet-stream')
            const a = document.createElement('a')
            a.setAttribute('download', name+'.png');
            a.setAttribute('href', image);
            a.click();
            canvas.remove();
        });

    }
    function setCariInfo()
    {
        $(document).ready( function () {
            $("#btnCari").click();
        });
    }

    $(document).ready(function(){
        $(".divfilter").hide();
        $("#btnfilter").click(function(){
           $(".divfilter").toggle();
        });
        getvaluetingkat();
        getvaluejenis();
        getvaluerekomendasi();
        getvalueprioritas();
        getvaluekesesuaian();

        var idDistrik="<?=$idDistrik?>";

        if(idDistrik !=="" && idDistrik.indexOf(',') == -1)
        {
            $("#reqDistrik").change();
            $('#btnCari').trigger('click');
        }

        // console.log(idDistrik);

    });

    $('#reqDistrik').on('change', function() {
        var reqDistrikId= reqBlok=reqTahun=reqStatus="";
        var reqDistrikId= this.value;
        var reqTahun=$("#reqTahun").val();
        var reqStatus=$("#reqStatus").val();

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


    $('#btnCari').on('click', function () {
        var reqDistrikId= reqBlok=reqTahun=reqStatus=reqListAreaId="";
        var reqDistrikId=$("#reqDistrik").val();
        var reqTahun=$("#reqTahun").val();
        var reqStatus=$("#reqStatus").val();
        var reqBlok=$("#reqBlok").val();
        var reqListAreaId=$("#reqListAreaId").val();

        getvaluetingkat();
        getvaluejenis();
        getvaluerekomendasi();
        getvalueprioritas();
        getvaluekesesuaian();
   
        $.getJSON("json-app/hasil_assessment_json/jumlahitem?reqDistrikId="+reqDistrikId+"&reqBlok="+reqBlok+"&reqTahun="+reqTahun+"&reqStatus="+reqStatus+"&reqListAreaId="+reqListAreaId,
            function(data)
            {
                $("#jumlahitem tr td").remove();
                jQuery(data).each(function(i, item){
                    $("#jumlahitem").append('<tr><td class="text-center">'+item.NO+'</td><td>'+item.AREA_NAMA+'</td><td>'+item.AREA_UNIT+'</td><td class="text-center">'+item.BELUM_DIISI+'</td></tr>');
                });
                
            });

        $.getJSON("json-app/hasil_assessment_json/rekapmatrik?reqDistrikId="+reqDistrikId+"&reqBlok="+reqBlok+"&reqTahun="+reqTahun+"&reqStatus="+reqStatus+"&reqListAreaId="+reqListAreaId,
            function(data)
            {
                $("#rekapmatrik tr td").remove();
                jQuery(data).each(function(i, item){
                    $("#rekapmatrik").append('<tr><td class="text-center">'+item.NO+'</td><td>'+item.AREA_NAMA+'</td><td>'+item.AREA_UNIT+'</td><td class="text-center">'+item.CONFIRM+'</td> <td class="text-center">'+item.NOT_CONFIRM+'</td> <td class="text-center">'+item.RISIKO_NAMA+'</td> <td class="text-center" style="background-color:#'+item.RISIKO_WARNA+' ">'+item.RISIKO_KODE+'</td></tr>');
                });

            });

        $.getJSON("json-app/hasil_assessment_json/rekaptingkat?reqDistrikId="+reqDistrikId+"&reqBlok="+reqBlok+"&reqTahun="+reqTahun+"&reqStatus="+reqStatus+"&reqListAreaId="+reqListAreaId,
            function(data)
            {
                $("#rekaptingkat tr td").remove();
                $("#rekaprekapitulasi tr td").remove();
                // console.log(data);
                jQuery(data).each(function(i, item){
                    $("#rekaptingkat").append('<tr><td class="text-center" style="width: 60%">Compliance Percentage (%)</td><td class="text-center" style="background-color: red">'+item.PERC_COMPLY+'</td></tr>');

                    // console.log(item);
                    $("#rekaprekapitulasi").append('<tr><td >Jumlah Area Assessment</td><td class="text-center">'+item.JUMLAH_AREA_TOTAL+'</td></tr><tr><td >Jumlah Klausul Assessment</td><td class="text-center">'+item.JUMLAH_KLS+'</td></tr><tr><td >Area Risiko Rendah</td><td class="text-center">'+item.JUMLAH_AREA_RENDAH+'</td></tr><tr><td >Area Risiko Moderat</td><td class="text-center">'+item.JUMLAH_AREA_MODERAT+'</td></tr><tr><td >Area Risiko Tinggi</td><td class="text-center">'+item.JUMLAH_AREA_TINGGI+'</td></tr><tr><td >Area Risiko Sangat Tinggi</td><td class="text-center">'+item.JUMLAH_AREA_SANGAT_TINGGI+'</td></tr><tr><td >Area Risiko Ekstrem</td><td class="text-center">'+item.JUMLAH_AREA_EKSTREM+'</td></tr>');
                });
                
            }); 


        $.getJSON("json-app/hasil_assessment_json/rekapkategori?reqDistrikId="+reqDistrikId+"&reqBlok="+reqBlok+"&reqTahun="+reqTahun+"&reqStatus="+reqStatus+"&reqListAreaId="+reqListAreaId,
            function(data)
            {
                $("#rekapkategori tr td").remove();
                jQuery(data).each(function(i, item){
                    $("#rekapkategori").append('<tr><td  >'+item.KATEGORI_INFO+'</td><td class="text-center" >'+item.JUMLAH_REKOMENDASI+'</td></tr>');
                });
                
            }); 

        $.getJSON("json-app/hasil_assessment_json/rekapjenis?reqDistrikId="+reqDistrikId+"&reqBlok="+reqBlok+"&reqTahun="+reqTahun+"&reqStatus="+reqStatus+"&reqListAreaId="+reqListAreaId,
            function(data)
            {
                $("#rekapjenis tr td").remove();
                jQuery(data).each(function(i, item){
                    $("#rekapjenis").append('<tr><td  >'+item.JENIS_INFO+'</td><td class="text-center" >'+item.JUMLAH_JENIS+'</td></tr>');
                });
                
            }); 

        $.getJSON("json-app/hasil_assessment_json/rekapprioritas?reqDistrikId="+reqDistrikId+"&reqBlok="+reqBlok+"&reqTahun="+reqTahun+"&reqStatus="+reqStatus+"&reqListAreaId="+reqListAreaId,
            function(data)
            {
                $("#rekapprioritas tr td").remove();
                jQuery(data).each(function(i, item){
                    $("#rekapprioritas").append('<tr><td  >'+item.PRIORITAS_INFO+'</td><td class="text-center" >'+item.PRIORITAS_REKOMENDASI+'</td></tr>');
                });
                
            }); 
       
        $.get("app/loadUrl/app/hasil_proyeksi?reqDistrikId="+reqDistrikId+"&reqBlok="+reqBlok+"&reqTahun="+reqTahun+"&reqStatus="+reqStatus+"&reqListAreaId="+reqListAreaId, function(data){
           $("#rekapproyeksi tr td").remove();           
           // $("#rekapproyeksi").html(data);
           $('#rekapproyeksi tr:last').after(data);
        });

        $.get("app/loadUrl/app/hasil_matriks?reqDistrikId="+reqDistrikId+"&reqBlok="+reqBlok+"&reqTahun="+reqTahun+"&reqStatus="+reqStatus+"&reqListAreaId="+reqListAreaId, function(data){
           $("#rmatriksrisiko tr td").remove();           
           // $("#rekapproyeksi").html(data);
           $('#rmatriksrisiko tr:last').after(data);
        });
    });




    function getvaluetingkat(reqDistrikId,reqBlok,reqTahun,reqStatus,reqListAreaId){
       var reqDistrikId= reqBlok=reqTahun=reqStatus=reqListAreaId="";
       var reqTahun=$("#reqTahun").val();
       var reqStatus=$("#reqStatus").val();
       var reqDistrikId=$("#reqDistrik").val();
       var reqBlok=$("#reqBlok").val();
       var reqListAreaId=$("#reqListAreaId").val();
        $.post( 'json-app/hasil_assessment_json/grafik_tingkat?reqDistrikId='+reqDistrikId+'&reqBlok='+reqBlok+'&reqTahun='+reqTahun+'&reqStatus='+reqStatus+"&reqListAreaId="+reqListAreaId,{}, function(data) {
                // console.log(data);return false;
            var object= JSON.parse(data);
            ubahvaluetingkat(object);
        });
    }

    function getvaluejenis(reqDistrikId,reqBlok,reqTahun,reqStatus,reqListAreaId){
        var reqDistrikId= reqBlok=reqTahun=reqStatus=reqListAreaId="";
        var reqTahun=$("#reqTahun").val();
        var reqStatus=$("#reqStatus").val();
        var reqDistrikId=$("#reqDistrik").val();
        var reqBlok=$("#reqBlok").val();
        var reqListAreaId=$("#reqListAreaId").val();
        $.post( 'json-app/hasil_assessment_json/grafik_jenis_rekomendasi?reqDistrikId='+reqDistrikId+'&reqBlok='+reqBlok+'&reqTahun='+reqTahun+'&reqStatus='+reqStatus+"&reqListAreaId="+reqListAreaId,{}, function(data) {
                // console.log(data);return false;
            var object= JSON.parse(data);
            ubahvaluejenis(object);
        });
    }

    function getvaluerekomendasi(reqDistrikId,reqBlok,reqTahun,reqStatus,reqListAreaId){
        var reqDistrikId= reqBlok=reqTahun=reqStatus=reqListAreaId="";
        var reqTahun=$("#reqTahun").val();
        var reqStatus=$("#reqStatus").val();
        var reqDistrikId=$("#reqDistrik").val();
        var reqBlok=$("#reqBlok").val();
        var reqListAreaId=$("#reqListAreaId").val();
        $.post( 'json-app/hasil_assessment_json/grafik_kategori_rekomendasi?reqDistrikId='+reqDistrikId+'&reqBlok='+reqBlok+'&reqTahun='+reqTahun+'&reqStatus='+reqStatus+"&reqListAreaId="+reqListAreaId,{}, function(data) {
                // console.log(data);return false;
            var object= JSON.parse(data);
            ubahvaluerekomendasi(object);
        });
    }

    function getvalueprioritas(reqDistrikId,reqBlok,reqTahun,reqStatus,reqListAreaId){
        var reqDistrikId= reqBlok=reqTahun=reqStatus=reqListAreaId="";
        var reqTahun=$("#reqTahun").val();
        var reqStatus=$("#reqStatus").val();
        var reqDistrikId=$("#reqDistrik").val();
        var reqBlok=$("#reqBlok").val();
        var reqListAreaId=$("#reqListAreaId").val();
        $.post( 'json-app/hasil_assessment_json/grafik_prioritas_rekomendasi?reqDistrikId='+reqDistrikId+'&reqBlok='+reqBlok+'&reqTahun='+reqTahun+'&reqStatus='+reqStatus+"&reqListAreaId="+reqListAreaId,{}, function(data) {
                // console.log(data);return false;
            var object= JSON.parse(data);
            ubahvalueprioritasrekomendasi(object);
        });
    }

    function getvaluekesesuaian(reqDistrikId,reqBlok,reqTahun,reqStatus,reqListAreaId){
        var reqDistrikId= reqBlok=reqTahun=reqStatus=reqListAreaId="";
        var reqTahun=$("#reqTahun").val();
        var reqStatus=$("#reqStatus").val();
        var reqDistrikId=$("#reqDistrik").val();
        var reqBlok=$("#reqBlok").val();
        var reqListAreaId=$("#reqListAreaId").val();
        $.post( 'json-app/hasil_assessment_json/grafik_kesesuaian?reqDistrikId='+reqDistrikId+'&reqBlok='+reqBlok+'&reqTahun='+reqTahun+'&reqStatus='+reqStatus+"&reqListAreaId="+reqListAreaId,{}, function(data) {
                // console.log(data);return false;
            var object= JSON.parse(data);
            // console.log(obj);
            ubahvaluekesesuaian(object);
        });
    }

    function ubahvaluetingkat(object){
        // console.log(object);
        Highcharts.chart('pie-kesesuaian', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie',
                    backgroundColor: null
                },
                credits: {
                    enabled: false
                },
                exporting: {
                    enabled: true
                },
                title: {
                    align: 'center',
                    text: 'Persentase Tingkat Kesesuaian',
                    style: {
                         fontSize:'20px'
                    }
                },
                tooltip: {
                    formatter: function() {
                        // console.log(this);
                        vartext= this.key + '<b>: '+this.percentage.toFixed(2)+' %</b>';
                        return vartext;
                    },
                    style: {
                         fontSize:'12px'
                    }
                   
                },
                legend: {
                    itemStyle: {
                        fontSize: "14px"
                    }
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: false
                        },
                        showInLegend: true,
                        size: 160
                    }
                },
                series: [{
                    name: '',
                    colorByPoint: true,
                    data: object
                }]
        });
    }
    function ubahvaluejenis(object){
        Highcharts.chart('pie-jenisrekomendasi', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie',
                    backgroundColor: null
                },
                credits: {
                    enabled: false
                },
                exporting: {
                    enabled: true
                },
                title: {
                    align: 'center',
                    text: 'Jenis Rekomendasi',
                    style: {
                         fontSize:'20px'
                    }
                },
                tooltip: {
                    style: {
                         fontSize:'15px'
                    }
                   
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                legend: {
                    itemStyle: {
                        fontSize: "12px"
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: false
                        },
                        showInLegend: true,
                        size: 160
                    }
                },
                series: [{
                    name: '',
                    colorByPoint: true,
                    data: object
                }]
        });
    }    
    function ubahvaluerekomendasi(object){
        Highcharts.chart('pie-rekomendasi', {
                chart: {
                    type: 'pie',
                    options3d: {
                        enabled: true,
                        alpha: 45,
                        beta: 0
                    }
                },
                credits: {
                    enabled: false
                },
                exporting: {
                    enabled: true
                },
                title: {
                    align: 'center',
                    text: 'Kategori Rekomendasi',
                    style: {
                         fontSize:'20px'
                    }
                },
                tooltip: {
                    formatter: function() {
                        // console.log(this);
                        vartext= this.key + '<b>: '+this.percentage.toFixed(2)+' %</b>';
                        return vartext;
                    },
                    style: {
                         fontSize:'15px'
                    }
                   
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        depth: 35,
                        dataLabels: {
                            enabled: false,
                            format: '{point.name} <br> {point.y} %',
                            style: {
                             fontSize:'12px'
                            }
                        },
                        showInLegend: false,
                        size: 200
                    }
                },
                series: [{
                     type: 'pie',
                    name: '',
                    colorByPoint: true,
                    data: object
                }]
        });
    }

    function ubahvalueprioritasrekomendasi(object){
        Highcharts.chart('pie-prioritas', {
            chart: {
                type: 'column'
            },
            title: {
                align: 'center',
                text: 'Prioritas Rekomendasi',
                style: {
                   fontSize:'20px'
                }
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category',
                labels: {
                    style: {
                         fontSize:'12px'
                    }
                }
            },
            yAxis: {
                title: {
                    text: 'Jumlah',
                    style: {
                     fontSize:'13px'
                    }
                }
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}',
                        style: {
                           fontSize:'13px'
                        }
                    }
                },
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>',
                style: {
                   fontSize:'13px'
                }
            },

            series: [
                {
                    name: 'Rekomendasi',
                    colorByPoint: true,
                    data: object
                }
            ]
            
        });
    }

    function ubahvaluekesesuaian(object){
        var arrCategories = [];
        var arrConfirm = [];
        var arrNotConfirm = [];
        $.each(object,function(key,value){
            arrCategories.push(value.name);
            arrConfirm.push(value.PERSEN_CONFIRM);
            arrNotConfirm.push(value.PERSEN_NOT_CONFIRM);
        }); 
        // console.log(arrCategories);
        Highcharts.chart('pie-area', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Kesesuaian Per Area',
                align: 'center',
                style: {
                  fontSize: '14px' 
                }
            },
            xAxis: {
                categories:arrCategories,
                labels: {
                    rotation: 270,
                    style: {
                         fontSize:'12px'
                    }
                }
            },
            legend: {
                itemStyle: {
                    fontSize: "14px"
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Percent',
                    style: {
                         fontSize:'12px'
                    }
                }
            },
            tooltip: {
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                shared: true,
                    style: {
                         fontSize:'13px'
                    }
            },
            plotOptions: {
                column: {
                    stacking: 'percent',
                    dataLabels: {
                        enabled: true,
                        format: '{point.percentage:.0f}%',
                        style: {
                           fontSize:'10px'
                        }
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Confirm',
                data: arrConfirm
            }, {
                name: 'Not Confirm',
                data: arrNotConfirm,
                 color:'#fecb4e'
            }]
            // series: [object]
        });
    }



</script>
