<html moznomarginboxes mozdisallowselectionprint>
<?
include_once("functions/default.func.php");
include_once("functions/date.func.php");
include_once("functions/string.func.php");
// $this->load->model('base-mobile/PermohonanCutiTahunan');
// $permohonan_cuti_tahunan= new PermohonanCutiTahunan();

// $reqId = $this->input->get("reqId");
// $mode = $this->input->get("mode");
// $reqTipe = $this->input->get("reqTipe");
// $this->load->model('JobPlan');

// if($reqId == "") {} 
// else 
// {
//     $set = new JobPlan();

//     $set->selectByParams(array("A.JOB_PLAN_ID" => $reqId));
//     $set->firstRow();
//     $reqRegisterPekerjaan= $set->getField("REGISTER_PEKERJAAN");
//     $reqPemberiTugas= $set->getField("CUSTOMER_NAMA");
//     unset($set);

//     $stat= " AND B.VERSI IS NULL";

//     $set = new JobPlan();
//     $set->selectByParamsRapRabHead(array("A.JOB_PLAN_ID"=>$reqId, "B.TIPE"=>'rap'),-1,-1,$stat);
//     // echo $set->query;exit;
//     $set->firstRow();
//     $reqRapRabHeadId= $set->getField("RAP_RAB_HEAD_ID");
//     $reqJudul= $set->getField("JUDUL");
//     $reqLokasi= $set->getField("LOKASI");
//     $reqWaktuPelaksanaan= $set->getField("WAKTU_PELAKSANAAN");
    
//     $reqStatus= $set->getField("STATUS");
//     $reqCatatan= $set->getField("CATATAN");
//     $reqTanggal= getFormattedDate2($set->getField("TANGGAL"));

//     $reqPembuatPegJabatan= $set->getField("PEMBUAT_JABATAN");
//     $reqPembuatPegNama= $set->getField("PEMBUAT_PEG_NAMA");

//     $reqEstimasiBiaya= 0;
//     $reqEstimasiBiayaPph= 0;

//     if ($reqRapRabHeadId) 
//     {
//         $statemennn= " AND B.VERSI IS NULL";
//         $reqEstimasiBiaya= $set->getSumEstimasi(array("B.JOB_PLAN_ID"=>$reqId, "B.TIPE"=>"rap"), $statemennn);
//         $reqEstimasiPph= $set->getSumEstimasiPph(array("B.JOB_PLAN_ID"=>$reqId, "B.TIPE"=>"rap"), $statemennn);
//         $reqEstimasiBiayaPph= $reqEstimasiBiaya+$reqEstimasiPph;
//     }
//     unset($set);

//     $set = new JobPlan();

//     $statement = " AND JOB_PLAN_ID = ".$reqId." AND TIPE = '".$reqTipe."' AND RAP_RAB_HEAD_ID = '".$reqRapRabHeadId."'";
//     $set->selectByParamsTree(array(), -1,-1, $statement); 
//     // echo $set->query;exit;
// }

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
                    <td style="width: 150px;">FMR-04.2.3.e17.1 (DINAMIS)</td>
                </tr>
                <tr>
                    <td colspan="6" style="border: 1px solid black;" align="center">
                        <strong>PJB INTEGRATED MANAGEMENT SYSTEM</strong>
                    </td>
                    <td style="width: 60px;">Tgl. Terbit</td>
                    <td style="width: 5px;">:</td>
                    <td style="width: 150px;">16 Juli 2022</td>
                </tr>
                <tr>
                    <td colspan="6" style="border: 1px solid black;" align="center">
                        <strong>FORM UJI</strong>
                    </td>
                    <td style="width: 60px;">Revisi</td>
                    <td style="width: 5px;">:</td>
                    <td style="width: 150px;">1</td>
                </tr>
                <tr>
                    <td colspan="6" style="border: 1px solid black;" align="center">
                        <strong>LEAKAGE REACTANCE UAT (DINAMIS)</strong>
                    </td>
                    <td style="width: 60px;">Halaman</td>
                    <td style="width: 5px;">:</td>
                    <td style="width: 150px;">1 of 8</td>
                </tr>

                <tr>
                    <td style="border: 1px solid black;" colspan="2">Site : PLTU Indramayu</td>
                    <td style="border: 1px solid black;">manufaktur</td>
                    <td style="border: 1px solid black;">:</td>
                    <td style="border: 1px solid black;">TBEA HENGYANG </td>
                    <td style="border: 1px solid black;" rowspan="2" style="word-wrap: break-word;">tahun 2015</td>
                    <td style="border: 1px solid black;" colspan="2">QP No. Y-01-3-2113</td>
                    <td style="border: 1px solid black;" colspan="2">FU No. Y-25-2-530101 </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black;" colspan="2">Unit : 1</td>
                    <td style="border: 1px solid black;">Inspeksi</td>
                    <td style="border: 1px solid black;">:</td>
                    <td style="border: 1px solid black;">Serious Inspection</td>
                    <td style="border: 1px solid black;" colspan="4">OEM Doc. No. </td>
                </tr>
            </thead>
        </table>
    </div>
    <br />

    <div class='judul-laporan'>
        Leakage Reactance (HV-TV)<br>
        Pengujian Leakage reactance dengan metode per-phase
        <table style="border-collapse: collapse; border: 1px solid black; font-size:11px; ">
            <thead>
                <tr>
                    <td style="border: 1px solid black; text-align: center;" colspan="2">Inputs</td>
                    <td style="border: 1px solid black; text-align: center;" colspan="4">Test Results</td>
                    <td style="border: 1px solid black; text-align: center;" colspan="2">% Reactance</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align: center;">DETC</td>
                    <td style="border: 1px solid black; text-align: center;">Phase</td>
                    <td style="border: 1px solid black; text-align: center;">Current (Amp)</td>
                    <td style="border: 1px solid black; text-align: center;">Voltage (Volt)</td>
                    <td style="border: 1px solid black; text-align: center;">Reactance ()</td>
                    <td style="border: 1px solid black; text-align: center;">Resistance ()</td>
                    <td style="border: 1px solid black; text-align: center;">Reactance (%)</td>
                    <td style="border: 1px solid black; text-align: center;">Delta Avg. (%)</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 1px solid black; text-align: center;" rowspan="3">3</td>
                    <td style="border: 1px solid black; text-align: center;">A</td>
                    <td style="border: 1px solid black; text-align: center;">2.151</td>
                    <td style="border: 1px solid black; text-align: center;">18.360</td>
                    <td style="border: 1px solid black; text-align: center;">8.455</td>
                    <td style="border: 1px solid black; text-align: center;">1.095</td>
                    <td style="border: 1px solid black; text-align: center;">19.572</td>
                    <td style="border: 1px solid black; text-align: center;">0.234</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align: center;">B</td>
                    <td style="border: 1px solid black; text-align: center;">2.151</td>
                    <td style="border: 1px solid black; text-align: center;">18.360</td>
                    <td style="border: 1px solid black; text-align: center;">8.455</td>
                    <td style="border: 1px solid black; text-align: center;">1.095</td>
                    <td style="border: 1px solid black; text-align: center;">19.572</td>
                    <td style="border: 1px solid black; text-align: center;">0.234</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align: center;">C</td>
                    <td style="border: 1px solid black; text-align: center;">2.151</td>
                    <td style="border: 1px solid black; text-align: center;">18.360</td>
                    <td style="border: 1px solid black; text-align: center;">8.455</td>
                    <td style="border: 1px solid black; text-align: center;">1.095</td>
                    <td style="border: 1px solid black; text-align: center;">19.572</td>
                    <td style="border: 1px solid black; text-align: center;">0.234</td>
                </tr>
            </tbody>
        </table>
        <br>

        Leakage Reactance (HV-TV)<br>
        Pengujian Leakage reactance dengan metode 3 phase equivalent
        <table style="border-collapse: collapse; border: 1px solid black; font-size:11px; ">
            <thead>
                <tr>
                    <td style="border: 1px solid black; text-align: center;" colspan="2">Inputs</td>
                    <td style="border: 1px solid black; text-align: center;" colspan="4">Test Results</td>
                    <td style="border: 1px solid black; text-align: center;" rowspan="2">% Reactance</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align: center;">DETC</td>
                    <td style="border: 1px solid black; text-align: center;">Phase</td>
                    <td style="border: 1px solid black; text-align: center;">Current (Amp)</td>
                    <td style="border: 1px solid black; text-align: center;">Voltage (Volt)</td>
                    <td style="border: 1px solid black; text-align: center;">Reactance ()</td>
                    <td style="border: 1px solid black; text-align: center;">Resistance ()</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 1px solid black; text-align: center;" rowspan="3">3</td>
                    <td style="border: 1px solid black; text-align: center;">A</td>
                    <td style="border: 1px solid black; text-align: center;">2.151</td>
                    <td style="border: 1px solid black; text-align: center;">18.360</td>
                    <td style="border: 1px solid black; text-align: center;">8.455</td>
                    <td style="border: 1px solid black; text-align: center;">1.095</td>
                    <td style="border: 1px solid black; text-align: center;">19.572</td>
                    <td style="border: 1px solid black; text-align: center;" rowspan="3">0.234</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align: center;">B</td>
                    <td style="border: 1px solid black; text-align: center;">2.151</td>
                    <td style="border: 1px solid black; text-align: center;">18.360</td>
                    <td style="border: 1px solid black; text-align: center;">8.455</td>
                    <td style="border: 1px solid black; text-align: center;">1.095</td>
                    <td style="border: 1px solid black; text-align: center;">19.572</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align: center;">C</td>
                    <td style="border: 1px solid black; text-align: center;">2.151</td>
                    <td style="border: 1px solid black; text-align: center;">18.360</td>
                    <td style="border: 1px solid black; text-align: center;">8.455</td>
                    <td style="border: 1px solid black; text-align: center;">1.095</td>
                    <td style="border: 1px solid black; text-align: center;">19.572</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- <div style="font-size:9px; text-align: center;"><b>Terbilang :</b></div> -->
    <br>
    <div>
        <table style="border-collapse: collapse;">
            <tr>
                <td>Reference</td>
                <td>:</td>
                <td></td>
            </tr><tr>
                <td>Results</td>
                <td>:</td>
                <td></td>
            </tr>
            <tr>
                <td>Note</td>
                <td>:</td>
                <td></td>
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