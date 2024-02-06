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
$reqReference= $set->getField("REFERENCE");
$reqResult= $set->getField("RESULT");
$reqNote= $set->getField("NOTE");
$reqNama= $set->getField("NAMA");
$reqAirTemp= $set->getField("AIR_TEMP");
$reqHumidity= $set->getField("HUMIDITY");
$reqApparatusTemp= $set->getField("APPARATUS_TEMP");

$arrtanref= [];
$statementDetil3 = " AND A.TIPE_TAN = '3' ";
$set->selectByParamsDetil(array(), -1, -1, $statement.$statementDetil3);
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("FORM_UJI_DETIL_ID");
    $arrdata["parent"]= $set->getField("FORM_UJI_ID");
    $arrdata["tipe"]= $set->getField("FORM_UJI_TIPE_ID");

    $arrdata["CONDITION_TAN"]= $set->getField("CONDITION_TAN");
    $arrdata["GOOD_TAN"]= $set->getField("GOOD_TAN");
    $arrdata["MAYBE_TAN"]= $set->getField("MAYBE_TAN");
    $arrdata["INVESTIGATED_TAN"]= $set->getField("INVESTIGATED_TAN");

   array_push($arrtanref, $arrdata);
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

        <table style="border-collapse: collapse; font-size:11px; margin-left: auto; margin-right: auto; width: 85%;">
            <thead>
                <tr>
                    <td style="border: 1px solid black;">Winding</td>
                    <td style="border: 1px solid black;">Measure</td>
                    <td style="border: 1px solid black;">Test (kV)</td>
                    <td style="border: 1px solid black;">Arus (mA)</td>
                    <td style="border: 1px solid black;">Daya (W)</td>
                    <td style="border: 1px solid black;">% PF corr</td>
                    <td style="border: 1px solid black;">Corr Fact</td>
                    <td style="border: 1px solid black;">Cap(pF)</td>
                </tr>
            </thead>
            <tbody>
                <?
                $statementDetil1= " AND A.TIPE_TAN = '1' ";

                $set->selectByParamsDetil(array(), -1, -1, $statement.$statementDetil1);
                while($set->nextRow())
                {
                    // $arrdata= array();
                    $selectvalid= $set->getField("FORM_UJI_DETIL_ID");
                    $selectparent= $set->getField("FORM_UJI_ID");
                    $selecttipe= $set->getField("FORM_UJI_TIPE_ID");

                    ?>
                    <tr>
                        <td style="border: 1px solid black;" rowspan="4"><?=$set->getField("WINDING_TAN")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("MEASURE_TAN_CH_CHL")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("TEST_TAN_CH_CHL")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("ARUS_TAN_CH_CHL")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("DAYA_TAN_CH_CHL")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("PF_CORR_TAN_CH_CHL")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("CORR_FACT_TAN_CH_CHL")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("CAP_TAN_CH_CHL")?></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black;"><?=$set->getField("MEASURE_TAN_CH")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("TEST_TAN_CH")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("ARUS_TAN_CH")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("DAYA_TAN_CH")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("PF_CORR_TAN_CH")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("CORR_FACT_TAN_CH")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("CAP_TAN_CH")?></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black;"><?=$set->getField("MEASURE_TAN_CHL_UST")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("TEST_TAN_CHL_UST")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("ARUS_TAN_CHL_UST")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("DAYA_TAN_CHL_UST")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("PF_CORR_TAN_CHL_UST")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("CORR_FACT_TAN_CHL_UST")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("CAP_TAN_CHL_UST")?></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black;"><?=$set->getField("MEASURE_TAN_CHL")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("TEST_TAN_CHL")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("ARUS_TAN_CHL")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("DAYA_TAN_CHL")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("PF_CORR_TAN_CHL")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("CORR_FACT_TAN_CHL")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("CAP_TAN_CHL")?></td>
                    </tr>
                    <?
                    // array_push($arrwindingtan, $arrdata);
                }
                ?>
            </tbody>
        </table>

        <br>

        <table style="border-collapse: collapse; font-size:11px; margin-left: auto; margin-right: auto; width: 85%;">
            <tr>
                <td style="border: 1px solid black;" colspan="8">Winding without Attached Bushing Calculation</td>
            </tr>

            <?
            $statementDetil2 = " AND A.TIPE_TAN = '2' ";

            $set->selectByParamsDetil(array(), -1, -1, $statement.$statementDetil2);
            while($set->nextRow())
            {
                $selectvalid= $set->getField("FORM_UJI_DETIL_ID");
                $selectparent= $set->getField("FORM_UJI_ID");
                $selecttipe= $set->getField("FORM_UJI_TIPE_ID");

                ?>
                <tr>
                    <td style="border: 1px solid black;"><?=$set->getField("WINDING_WITHOUT_TAN_1")?></td>
                    <td style="border: 1px solid black;"><?=$set->getField("WINDING_WITHOUT_TAN_2")?></td>
                    <td style="border: 1px solid black;"><?=$set->getField("WINDING_WITHOUT_TAN_3")?></td>
                    <td style="border: 1px solid black;"><?=$set->getField("WINDING_WITHOUT_TAN_4")?></td>
                    <td style="border: 1px solid black;"><?=$set->getField("WINDING_WITHOUT_TAN_5")?></td>
                    <td style="border: 1px solid black;"><?=$set->getField("WINDING_WITHOUT_TAN_6")?></td>
                    <td style="border: 1px solid black;"><?=$set->getField("WINDING_WITHOUT_TAN_7")?></td>
                    <td style="border: 1px solid black;"><?=$set->getField("WINDING_WITHOUT_TAN_8")?></td>
                </tr>
                <?
            }
            ?>
                
            <tr>
                <td colspan="4">Note : C : Capacitance</td>
                <td colspan="4">UST : Ungrounded Specimen Test</td>
            </tr>
            <tr>
                <td colspan="4">L : Low  H : Hight</td>
                <td colspan="4">PF : Power Factor  Corr : Correction</td>
            </tr>
            <tr>
                <td style="height: 10px;"></td>
            </tr>
            <tr>
                <td colspan="4">Air Temp. : <?=$reqAirTemp?></td>
                <td colspan="4">Apparatus Temp. : <?=$reqHumidity?></td>
            </tr>
            <tr>
                <td>Humidity : <?=$reqApparatusTemp?></td>
            </tr>
        </table>
    </div>

    <!-- <div style="font-size:9px; text-align: center;"><b>Terbilang :</b></div> -->
    <br>
    <div>
        <table style="border-collapse: collapse; width: 100%;">
            <tr>
                <td style="vertical-align: top;">Reference</td>
                <td style="vertical-align: top;">:</td>
                <td style="">
                    <?=$reqReference?>
                    <?
                    if (count($arrtanref)!='0') 
                    {
                        ?>
                        <br>
                        <table style="border-collapse: collapse; font-size:11px; width: 80%;">
                            <tr>
                                <td style="border: 1px solid black; width: 20%; text-align: center;">Condition</td>
                                <td style="border: 1px solid black; width: 20%; text-align: center;">Good</td>
                                <td style="border: 1px solid black; width: 20%; text-align: center;">Maybe acceptable</td>
                                <td style="border: 1px solid black; width: 20%; text-align: center;">Investigated</td>
                            </tr>
                            <?
                            foreach ($arrtanref as $item) 
                            {
                                ?>
                                <tr>
                                    <td style="border: 1px solid black; text-align: center;"><?=$item["CONDITION_TAN"]?></td>
                                    <td style="border: 1px solid black; text-align: center;"><?=$item["GOOD_TAN"]?></td>
                                    <td style="border: 1px solid black; text-align: center;"><?=$item["MAYBE_TAN"]?></td>
                                    <td style="border: 1px solid black; text-align: center;"><?=$item["INVESTIGATED_TAN"]?></td>
                                </tr>
                                <?
                            }
                            ?>
                        </table> 
                        <?
                    }
                    ?>       
                </td>
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