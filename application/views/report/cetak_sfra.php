<html moznomarginboxes mozdisallowselectionprint>
<?
include_once("functions/default.func.php");
include_once("functions/date.func.php");
include_once("functions/string.func.php");
// $this->load->model('base-mobile/PermohonanCutiTahunan');
// $permohonan_cuti_tahunan= new PermohonanCutiTahunan();

$reqTipe= $this->input->get("reqTipe");
$reqId= $this->input->get("reqId");
// print_r($reqId);exit;
$this->load->model('base-app/FormUji');

$tahun=date("Y");

$set= new FormUji();

$statement= " AND A.FORM_UJI_ID = ".$reqId." AND A.FORM_UJI_TIPE_ID = ".$reqTipe."";

$set->selectByParams(array(), -1, -1, $statement);
// echo $set->query;exit;
$set->firstRow();
$reqId= $set->getField("FORM_UJI_ID");
$reqOilTemp=  $set->getField("OIL_TEMP");
$reqTapChanger=  $set->getField("TAP_CHANGER");
$reqReference= $set->getField("REFERENCE");
$reqResult= $set->getField("RESULT");
$reqNote= $set->getField("NOTE");

$reqNama= $set->getField("NAMA");


$set= new FormUji();
$arrgambarsfra= [];
$set->selectByParamsGambar(array(), -1, -1, $statement);
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("FORM_UJI_GAMBAR_ID");
    $arrdata["parent"]= $set->getField("FORM_UJI_ID");
    $arrdata["tipe"]= $set->getField("FORM_UJI_TIPE_ID");

    $arrdata["LINK_GAMBAR"]= $set->getField("LINK_GAMBAR");
    $arrdata["NAMA"]= $set->getField("NAMA");
   array_push($arrgambarsfra, $arrdata);
}
// print_r($arrgambarsfra);exit;


$arrsfraHv= [];
$statementDetil1 = " AND A.TIPE_SFRA = '1' ";
$set->selectByParamsDetil(array(), -1, -1, $statement.$statementDetil1);
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("FORM_UJI_DETIL_ID");
    $arrdata["parent"]= $set->getField("FORM_UJI_ID");
    $arrdata["tipe"]= $set->getField("FORM_UJI_TIPE_ID");

    $arrdata["HV_SFRA"]= $set->getField("HV_SFRA");
    $arrdata["HV_DL_SFRA"]= $set->getField("HV_DL_SFRA");
    $arrdata["HV_NCEPRI_SFRA"]= $set->getField("HV_NCEPRI_SFRA");

   array_push($arrsfraHv, $arrdata);
}

$arrsfraLv= [];
$statementDetil2 = " AND A.TIPE_SFRA = '2' ";
$set->selectByParamsDetil(array(), -1, -1, $statement.$statementDetil2);
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("FORM_UJI_DETIL_ID");
    $arrdata["parent"]= $set->getField("FORM_UJI_ID");
    $arrdata["tipe"]= $set->getField("FORM_UJI_TIPE_ID");

    $arrdata["LV_SFRA"]= $set->getField("LV_SFRA");
    $arrdata["LV_DL_SFRA"]= $set->getField("LV_DL_SFRA");
    $arrdata["LV_NCEPRI_SFRA"]= $set->getField("LV_NCEPRI_SFRA");

   array_push($arrsfraLv, $arrdata);
}


$arrsfraHvLv= [];
$statementDetil3 = " AND A.TIPE_SFRA = '3' ";
$set->selectByParamsDetil(array(), -1, -1, $statement.$statementDetil3);
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("FORM_UJI_DETIL_ID");
    $arrdata["parent"]= $set->getField("FORM_UJI_ID");
    $arrdata["tipe"]= $set->getField("FORM_UJI_TIPE_ID");

    $arrdata["HVLV_SFRA"]= $set->getField("HVLV_SFRA");
    $arrdata["HVLV_DL_SFRA"]= $set->getField("HVLV_DL_SFRA");
    $arrdata["HVLV_NCEPRI_SFRA"]= $set->getField("HVLV_NCEPRI_SFRA");

   array_push($arrsfraHvLv, $arrdata);
}


$arrsfraHvShort= [];
$statementDetil4 = " AND A.TIPE_SFRA = '4' ";
$set->selectByParamsDetil(array(), -1, -1, $statement.$statementDetil4);
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("FORM_UJI_DETIL_ID");
    $arrdata["parent"]= $set->getField("FORM_UJI_ID");
    $arrdata["tipe"]= $set->getField("FORM_UJI_TIPE_ID");

    $arrdata["HV_SHORT_SFRA"]= $set->getField("HV_SHORT_SFRA");
    $arrdata["HV_SHORT_DL_SFRA"]= $set->getField("HV_SHORT_DL_SFRA");
    $arrdata["HV_SHORT_NCEPRI_SFRA"]= $set->getField("HV_SHORT_NCEPRI_SFRA");

   array_push($arrsfraHvShort, $arrdata);
}


$arrsfraHvGround= [];
$statementDetil5 = " AND A.TIPE_SFRA = '5' ";
$set->selectByParamsDetil(array(), -1, -1, $statement.$statementDetil5);
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("FORM_UJI_DETIL_ID");
    $arrdata["parent"]= $set->getField("FORM_UJI_ID");
    $arrdata["tipe"]= $set->getField("FORM_UJI_TIPE_ID");

    $arrdata["HVLV_GROUND_SFRA"]= $set->getField("HVLV_GROUND_SFRA");
    $arrdata["HVLV_GROUND_DL_SFRA"]= $set->getField("HVLV_GROUND_DL_SFRA");
    $arrdata["HVLV_GROUND_NCEPRI_SFRA"]= $set->getField("HVLV_GROUND_NCEPRI_SFRA");

   array_push($arrsfraHvGround, $arrdata);
}

?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- <base href="<?=base_url();?>"> -->

    <link rel="stylesheet" href="<?=base_url()?>css/laporan.css" type="text/css">
    <link href="<?=base_url()?>lib/startbootstrap-sb-admin-2-1.0.7/bower_components/bootstrap/dist/css/btn.css" rel="stylesheet">

</head>

<body>
    <div style="page-break-inside:avoid;">
        <table style="border-collapse: collapse; border: 1px solid black; font-size:11px; width: 100%;">
            <thead>
                <tr>
                    <td rowspan="4" style="width:80px;">
                        <img src="images/logo-pjb.png" style="width: 120px;" class="logo-slip">
                    </td>
                    <td colspan="6" style="border: 1px solid black;" align="center"><strong>PT PEMBANGKITAN JAWA BALI</strong></td>
                    <td style="width: 60px;">No. Dok.</td>
                    <td style="width: 5px;">:</td>
                    <td style="width: 150px;"></td>
                </tr>
                <tr>
                    <td colspan="6" style="border: 1px solid black;" align="center">
                        <strong>PJB INTEGRATED MANAGEMENT SYSTEM</strong>
                    </td>
                    <td style="width: 60px;">Tgl. Terbit</td>
                    <td style="width: 5px;">:</td>
                    <td style="width: 150px;"></td>
                </tr>
                <tr>
                    <td colspan="6" style="border: 1px solid black;" align="center">
                        <strong>FORM UJI</strong>
                    </td>
                    <td style="width: 60px;">Revisi</td>
                    <td style="width: 5px;">:</td>
                    <td style="width: 150px;"></td>
                </tr>
                <tr>
                    <td colspan="6" style="border: 1px solid black;" align="center">
                        <strong><?=$reqNama?></strong>
                    </td>
                    <td style="width: 60px;">Halaman</td>
                    <td style="width: 5px;">:</td>
                    <td style="width: 150px;"></td>
                </tr>

                <tr>
                    <td style="border: 1px solid black;" colspan="2">Site : </td>
                    <td style="border: 1px solid black;">Manufaktur</td>
                    <td style="border: 1px solid black;">:</td>
                    <td style="border: 1px solid black;"></td>
                    <td style="border: 1px solid black;" rowspan="2" style="word-wrap: break-word;">Tahun <?=$tahun?></td>
                    <td style="border: 1px solid black;" colspan="2">QP No. </td>
                    <td style="border: 1px solid black;" colspan="2">FU No. </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black;" colspan="2">Unit : </td>
                    <td style="border: 1px solid black;">Inspeksi</td>
                    <td style="border: 1px solid black;">:</td>
                    <td style="border: 1px solid black;"></td>
                    <td style="border: 1px solid black;" colspan="4">OEM Doc. No. </td>
                </tr>
            </thead>
        </table>
    </div>
    <br />

    <div class='judul-laporan'>
        Traces SFRA
        <br>
        <table style="border-collapse: collapse; font-size:11px; width: 100%;">
            <tr>
                <td style="text-align: center;"><img src="<?=$arrgambarsfra[0]['LINK_GAMBAR']?>"></td>
            </tr>
        </table>
        <br>

        <div class="row">
            Perbandingan Traces SFRA ME 2021 dan IB3 202
            <div style="float: left; width: 50%;">
                <table style="border-collapse: collapse; font-size:11px; margin-left: auto; margin-right: auto; width: 90%;">
                    <tr>
                        <td style="border: 1px solid black; text-align: center; width: 15%;">HV</td>
                        <td style="border: 1px solid black; text-align: center; width: 15%;">DL/T911-2004</td>
                        <td style="border: 1px solid black; text-align: center; width: 15%;">NCEPRI</td>
                    </tr>
                    <?
                    foreach ($arrsfraHv as $item) 
                    {
                        ?>
                        <tr>
                            <td style="border: 1px solid black; text-align: center;"><?=$item["HV_SFRA"]?></td>
                            <td style="border: 1px solid black; text-align: center;"><?=$item["HV_DL_SFRA"]?></td>
                            <td style="border: 1px solid black; text-align: center;"><?=$item["HV_NCEPRI_SFRA"]?></td>
                        </tr>
                        <?
                    }
                    ?>
                </table>
                <br>

                <table style="border-collapse: collapse; font-size:11px; margin-left: auto; margin-right: auto; width: 90%;">
                    <tr>
                        <td style="border: 1px solid black; text-align: center; width: 15%;">HV - LV</td>
                        <td style="border: 1px solid black; text-align: center; width: 15%;">DL/T911-2004</td>
                        <td style="border: 1px solid black; text-align: center; width: 15%;">NCEPRI</td>
                    </tr>
                    <?
                    foreach ($arrsfraHvLv as $item) 
                    {
                        ?>
                        <tr>
                            <td style="border: 1px solid black; text-align: center;"><?=$item["HVLV_SFRA"]?></td>
                            <td style="border: 1px solid black; text-align: center;"><?=$item["HVLV_DL_SFRA"]?></td>
                            <td style="border: 1px solid black; text-align: center;"><?=$item["HVLV_NCEPRI_SFRA"]?></td>
                        </tr>
                        <?
                    }
                    ?>
                </table>
                <br>
                
                <table style="border-collapse: collapse; font-size:11px; margin-left: auto; margin-right: auto; width: 90%;">
                    <tr>
                        <td style="border: 1px solid black; text-align: center; width: 15%;">HV - LV  (grounded)</td>
                        <td style="border: 1px solid black; text-align: center; width: 15%;">DL/T911-2004</td>
                        <td style="border: 1px solid black; text-align: center; width: 15%;">NCEPRI</td>
                    </tr>
                    <?
                    foreach ($arrsfraHvGround as $item) 
                    {
                        ?>
                        <tr>
                            <td style="border: 1px solid black; text-align: center;"><?=$item["HVLV_GROUND_SFRA"]?></td>
                            <td style="border: 1px solid black; text-align: center;"><?=$item["HVLV_GROUND_DL_SFRA"]?></td>
                            <td style="border: 1px solid black; text-align: center;"><?=$item["HVLV_GROUND_NCEPRI_SFRA"]?></td>
                        </tr>
                        <?
                    }
                    ?>
                </table>
            </div>

            <div style="float: left; width: 50%;">
                <table style="border-collapse: collapse; font-size:11px; margin-left: auto; margin-right: auto; width: 90%;">
                    <tr>
                        <td style="border: 1px solid black; text-align: center; width: 15%;">LV</td>
                        <td style="border: 1px solid black; text-align: center; width: 15%;">DL/T911-2004</td>
                        <td style="border: 1px solid black; text-align: center; width: 15%;">NCEPRI</td>
                    </tr>
                    <?
                    foreach ($arrsfraLv as $item) 
                    {
                        ?>
                        <tr>
                            <td style="border: 1px solid black; text-align: center;"><?=$item["LV_SFRA"]?></td>
                            <td style="border: 1px solid black; text-align: center;"><?=$item["LV_DL_SFRA"]?></td>
                            <td style="border: 1px solid black; text-align: center;"><?=$item["LV_NCEPRI_SFRA"]?></td>
                        </tr>
                        <?
                    }
                    ?>
                </table>
                <br>

                <table style="border-collapse: collapse; font-size:11px; margin-left: auto; margin-right: auto; width: 90%;">
                    <tr>
                        <td style="border: 1px solid black; text-align: center; width: 15%;">HV (shorted)</td>
                        <td style="border: 1px solid black; text-align: center; width: 15%;">DL/T911-2004</td>
                        <td style="border: 1px solid black; text-align: center; width: 15%;">NCEPRI</td>
                    </tr>
                    <?
                    foreach ($arrsfraHvShort as $item) 
                    {
                        ?>
                        <tr>
                            <td style="border: 1px solid black; text-align: center;"><?=$item["HV_SHORT_SFRA"]?></td>
                            <td style="border: 1px solid black; text-align: center;"><?=$item["HV_SHORT_DL_SFRA"]?></td>
                            <td style="border: 1px solid black; text-align: center;"><?=$item["HV_SHORT_NCEPRI_SFRA"]?></td>
                        </tr>
                        <?
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>

    <!-- <div style="font-size:9px; text-align: center;"><b>Terbilang :</b></div> -->
    <br>
    <div>
        <table style="border-collapse: collapse;">
            <tr>
                <td style="vertical-align: top;">Oil Temp.</td>
                <td style="vertical-align: top;">:</td>
                <td><?=$reqOilTemp?></td>
            </tr>
            <tr>
                <td style="vertical-align: top;">Tap Charger</td>
                <td style="vertical-align: top;">:</td>
                <td><?=$reqTapChanger?></td>
            </tr>
            <tr>
                <td style="vertical-align: top;">Reference</td>
                <td style="vertical-align: top;">:</td>
                <td><?=$reqReference?></td>
            </tr>
            <tr>
                <td style="vertical-align: top;">Results</td>
                <td style="vertical-align: top;">:</td>
                <td><?=$reqResult?></td>
            </tr>
            <tr>
                <td style="vertical-align: top;">Note</td>
                <td style="vertical-align: top;">:</td>
                <td><?=$reqNote?></td>
            </tr>
        </table>

        <br>
        <table style="border-collapse: collapse; border: 1px solid black; font-size:11px; width: 100%;">
            <tr>
                <td style="border: 1px solid black;" colspan="2">RECOMENDATION</td>
                <td style="border: 1px solid black;" colspan="4">ACCEPTED/REWORK/REPLACE/REPAIR/MONITORING<br>(by Quality Control)</td>
            </tr>
            <tr>
                <td style="border: 1px solid black;" colspan="2">MEASURING TOOL:</td>
                <td style="border: 1px solid black; text-align: center;" colspan="4">OMICRON DIRANA</td>
            </tr>
            <tr>
                <td style="border: 1px solid black; width: 10%;">Description</td>
                <td style="border: 1px solid black; width: 22.5%; text-align: center;" colspan="2">Tested/measured by</td>
                <td style="border: 1px solid black; width: 22.5%; text-align: center;">Coordinator</td>
                <td style="border: 1px solid black; width: 22.5%; text-align: center;">Quality Control</td>
                <td style="border: 1px solid black; width: 22.5%; text-align: center;">Witness</td>
            </tr>
            <tr>
                <td style="border: 1px solid black;">Name</td>
                <td style="border: 1px solid black; text-align: center;" colspan="2">Eka Sanjaya</td>
                <td style="border: 1px solid black; text-align: center;">Triyadi, N.S</td>
                <td style="border: 1px solid black; text-align: center;">Ramot Mangihut H.</td>
                <td style="border: 1px solid black; text-align: center;">Gregorius Sutrisno</td>
            </tr>
            <tr>
                <td style="border: 1px solid black; height: 50px;">Signature</td>
                <td style="border: 1px solid black; text-align: center;" colspan="2"></td>
                <td style="border: 1px solid black; text-align: center;"></td>
                <td style="border: 1px solid black; text-align: center;"></td>
                <td style="border: 1px solid black; text-align: center;"></td>
            </tr>
            <tr>
                <td style="border: 1px solid black;">Date</td>
                <td style="border: 1px solid black; text-align: center;" colspan="2">3 Agustus 2020</td>
                <td style="border: 1px solid black; text-align: center;">3 Agustus 2020</td>
                <td style="border: 1px solid black; text-align: center;">3 Agustus 2020</td>
                <td style="border: 1px solid black; text-align: center;">3 Agustus 2020</td>
            </tr>
        </table>
    </div>

    <div style='clear:both;'>&nbsp;</div>

    
</body>
</html>