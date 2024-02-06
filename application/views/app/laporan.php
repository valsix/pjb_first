<?

include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/MatriksRisiko");
$this->load->model("base-app/Dampak");
$this->load->model("base-app/Kemungkinan");
$this->load->model("base-app/Kesesuaian");


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
    $arrdata["CONFIRM"]= $set->getField("CONFIRM");
    $arrdata["NOT_CONFIRM"]= $set->getField("NOT_CONFIRM");
    $arrdata["PERSEN_CONFIRM"]= $set->getField("PERSEN_CONFIRM");
    $arrdata["PERSEN_NOT_CONFIRM"]= $set->getField("PERSEN_NOT_CONFIRM");

    $no++;

    array_push($arrkesesuaian, $arrdata);
}



// print_r($jmldampak);exit;


?>
<style type="text/css">
    .zoom-loop {
        -webkit-animation: myzoom 0.3s;
        /* Safari 4.0 - 8.0 */
        animation: myzoom 0.3s;
        -webkit-animation-iteration-count: infinite;
        /* Safari 4.0 - 8.0 */
        animation-iteration-count: infinite;
        animation-direction: alternate;
        -webkit-animation-direction: alternate;
        /* Safari 4.0 - 8.0 */
    }

    .zoom-1 {
        -webkit-animation: myzooma 3s;
        /* Safari 4.0 - 8.0 */
        -webkit-animation-iteration-count: infinite;
        /* Safari 4.0 - 8.0 */
        animation: myzooma 3s;
        animation-iteration-count: infinite;
    }

    .zoom-2 {
        -webkit-animation: myzoomb 3s;
        /* Safari 4.0 - 8.0 */
        -webkit-animation-iteration-count: infinite;
        /* Safari 4.0 - 8.0 */
        animation: myzoomb 3s;
        animation-iteration-count: infinite;
    }

    .zoom-3 {
        -webkit-animation: myzoomz 3s;
        /* Safari 4.0 - 8.0 */
        -webkit-animation-iteration-count: infinite;
        /* Safari 4.0 - 8.0 */
        animation: myzoomz 3s;
        animation-iteration-count: infinite;
    }

    @-webkit-keyframes myzoom {
        0% {
            background-color: #666;
        }
        
        100% {
            background-color: #ccc;
        }
    }

    @keyframes myzoom {
        0% {
            background-color: #666;
        }
        
        100% {
            background-color: #ccc;
        }
    }

    @-webkit-keyframes myzooma {
        0% {
            background-color: #666;
            color: #fff;
        }
        
        11% {
            background-color: #ccc;
            color: #fff;
        }
        
        22% {
            background-color: #666;
            color: #fff;
        }
        
        33% {
            transform: scale(1);
        }
        
        44% {
            transform: scale(1);
        }
        
        55% {
            transform: scale(1);
        }
        
        66% {
            transform: scale(1);
        }
        
        100% {
            transform: scale(1);
        }
    }

    @keyframes myzooma {
        0% {
            background-color: #666;
            color: #fff;
        }
        
        11% {
            background-color: #ccc;
            color: #fff;
        }
        
        22% {
            background-color: #666;
            color: #fff;
        }
        
        33% {
            transform: scale(1);
        }
        
        44% {
            transform: scale(1);
        }
        
        55% {
            transform: scale(1);
        }
        
        66% {
            transform: scale(1);
        }
        
        100% {
            transform: scale(1);
        }
    }

    @-webkit-keyframes myzoomb {
        0% {
            transform: scale(1);
        }
        
        11% {
            background-color: #666;
            color: #fff;
        }
        
        22% {
            background-color: #ccc;
            color: #fff;
        }
        
        33% {
            background-color: #666;
            color: #fff;
        }
        
        44% {
            transform: scale(1);
        }
        
        55% {
            transform: scale(1);
        }
        
        66% {
            transform: scale(1);
        }
        
        100% {
            transform: scale(1);
        }
    }

    @keyframes myzoomb {
        0% {
            transform: scale(1);
        }
        
        11% {
            background-color: #666;
            color: #fff;
        }
        
        22% {
            background-color: #ccc;
            color: #fff;
        }
        
        33% {
            background-color: #666;
            color: #fff;
        }
        
        44% {
            transform: scale(1);
        }
        
        55% {
            transform: scale(1);
        }
        
        66% {
            transform: scale(1);
        }
        
        100% {
            transform: scale(1);
        }
    }

    @-webkit-keyframes myzoomz {
        0% {
            transform: scale(1);
        }
        
        11% {
            transform: scale(1);
        }
        
        22% {
            transform: scale(1);
        }
        
        33% {
            background-color: #666;
            color: #fff;
        }
        
        44% {
            transform: scale(1);
        }
        
        55% {
            transform: scale(1);
        }
        
        66% {
            transform: scale(1);
        }
        
        100% {
            transform: scale(1);
        }
    }

    @keyframes myzoomz {
        0% {
            transform: scale(1);
        }
        
        11% {
            transform: scale(1);
        }
        
        22% {
            transform: scale(1);
        }
        
        33% {
            background-color: #666;
            color: #fff;
        }
        
        44% {
            transform: scale(1);
        }
        
        55% {
            transform: scale(1);
        }
        
        66% {
            transform: scale(1);
        }
        
        100% {
            transform: scale(1);
        }
    }

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
      width:100%;
      display: inline-block
      height:100%;
      overflow: auto;
    }
</style>
<div class="col-md-12">
    <div class="judul-halaman"> <?=$pgtitle?></div>
    <div class="body" style="padding: 15px 8px;">
        <div class="row">
            <div  class="parent">
                <div class="col-sm-12 col-lg-4 widthmtrix c-4" style="padding: 0px 7px !important; height: fit-content;">
                    <div style="text-align: center; ">
                        <div id="belumdiisi" style="text-align: left; width:100%;">
                            <div class="page-header" style="background-color: green;width:100%;">
                                <h3><i class="fa fa-file-text fa-lg"></i> Jumlah Item Assessment Yang Belum Diisi </h3>      
                            </div>
                            <br>
                            <table class="tbmatrix"  style="width:100%;">
                                <tr> 
                                    <th class="text-center headcolor" >No</th>
                                    <th class="text-center headcolor" >Area</th>
                                    <th class="text-center headcolor" >Jumlah Klausul Belum Diisi</th>
                                </tr>
                                <?
                                $no=1;
                                foreach ($arrkesesuaian as $key => $value) 
                                {
                                ?>
                                <tr>
                                    <td><?=$no?></td>
                                    <td><?=$value["AREA_NAMA"]?></td>
                                </tr>
                                <?
                                $no++;
                                }
                                ?>
                            </table>        
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-4 widthmtrix c-4" style="padding: 0px 7px !important; height: fit-content">
                    <div style="text-align: center; ">
                        <div id="belumdiisi" style="text-align: left; width:100%;">
                            <div class="page-header" style="background-color: green;width:100%;">
                                <h3><i class="fa fa-file-text fa-lg"></i> Rekapitulasi Matriks Risiko per Area </h3>      
                            </div>
                            <br>
                            <table class="tbmatrix"  style="width:100%;">
                                <tr> 
                                    <th class="text-center headcolor" >No</th>
                                    <th class="text-center headcolor" >Area</th>
                                    <th class="text-center headcolor" >Confirm</th>
                                    <th class="text-center headcolor" >Not Confirm</th>
                                    <th class="text-center headcolor" >Risiko</th>
                                    <th class="text-center headcolor" >Matriks Risiko</th>
                                </tr>
                                <?
                                $no=1;
                                foreach ($arrkesesuaian as $key => $value) 
                                {
                                ?>
                                <tr>
                                    <td class="text-center"><?=$no?></td>
                                    <td ><?=$value["AREA_UNIT"]?></td>
                                    <td class="text-center"><?=$value["CONFIRM"]?></td>
                                    <td class="text-center"><?=$value["NOT_CONFIRM"]?></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                </tr>
                                <?
                                $no++;
                                }
                                ?>
                            </table>        
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-4 widthmtrix c-4" style="padding: 0px 7px !important; height: fit-content">
                    <div style="text-align: center; margin-top: 10px;position: inherit; width:fit-content; margin: auto; height:fit-content">
                        <div id="divmatrix" style="text-align: left; width:500px;">
                            <div class="page-header" style="background-color: green;width:100%;">
                                <h3><i class="fa fa-file-text fa-lg"></i> Rekapitulasi Matriks Risiko per Area </h3>      
                            </div>
                            <br>
                            <table class="tbmatrix">
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
                                    // echo $set->query;exit;
                                    while($set->nextRow())
                                    {
                                        $arrdata= array();
                                        $arrdata["id"]= $set->getField("MATRIKS_RISIKO_ID");
                                        $arrdata["text"]= $set->getField("NAMA");
                                        $arrdata["RISIKO"]= $set->getField("RISIKO");
                                        $arrdata["DAMPAK"]= $set->getField("DAMPAK");
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
                                                <div style='position:absolute;top:5px;right:5px;'></div>
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
                    <div style="text-align: center; margin-top: 10px;position: inherit; width:fit-content; margin: auto; height:fit-content">
                        <div id="divmatrix" style="text-align: left; width:500px;">
                            <div class="page-header" style="background-color: green;width:100%;">
                                <h3><i class="fa fa-file-text fa-lg"></i> Chart Rekapitulasi Rekomendasi </h3>      
                            </div>
                            <br>  
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-4 widthmtrix c-4" style="padding: 0px 7px !important; height: fit-content">
                    <div style="text-align: center; margin-top: 10px;position: inherit; width:fit-content; margin: auto; height:fit-content">
                        <div id="divmatrix" style="text-align: left; width:500px;">
                            <div class="page-header" style="background-color: green;width:100%;">
                                <h3><i class="fa fa-file-text fa-lg"></i> Persentase Tingkat Kesesuaian </h3>      
                            </div>
                            <br>    
                        </div>
                    </div>
                    <div style="text-align: center; margin-top: 10px;position: inherit; width:fit-content; margin: auto; height:fit-content">
                        <div id="divmatrix" style="text-align: left; width:500px;">
                            <div class="page-header" style="background-color: green;width:100%;">
                                <h3><i class="fa fa-file-text fa-lg"></i> Rekapitulasi Assessment </h3>      
                            </div>
                            <br>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
