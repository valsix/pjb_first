<?php
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->model("base-app/CetakFormUjiDinamis");
$this->load->model('base-app/PlanRla');
$this->load->model('base-app/FormUji');
$this->load->model('base-app/Nameplate');


$appuserkodehak= $this->appuserkodehak;

$pgtitle= $pg;
$pgtitle= churuf(str_replace("_", " ", str_replace("transaksi_", "", $pgtitle)));
$reqIdRla = $this->input->get("reqIdRla");
$reqId = $this->input->get("reqId");
$reqKelompokEquipmentId = $this->input->get("reqKelompokEquipmentId");
$reqKelompokEquipmentParentId = $this->input->get("reqKelompokEquipmentParentId");
$reqNameplateId = $this->input->get("reqNameplateId");
$reqIdParent = $this->input->get("reqIdParent");
$reqIdParent = substr($reqIdParent, 0, 3); 
$reqCheck = $this->input->get("reqCheck");

$set= new CetakFormUjiDinamis();

$statement = " AND D.PLAN_RLA_ID = '".$reqId."' AND F.KELOMPOK_EQUIPMENT_ID = '".$reqKelompokEquipmentId."' OR F.KELOMPOK_EQUIPMENT_PARENT_ID = '".$reqKelompokEquipmentId."' AND J.NAMEPLATE_ID=".$reqNameplateId." ";

$set->selectByParamsFormUjiReportNameplateNew(array(), -1, -1, $statement);
// echo $set->query;
$set->firstRow();

$reqNameplateNama= $set->getField("NAMA_NAMEPLATE");
$reqNameplateKelompok= $set->getField("NAMA_KELOMPOK");



unset($set);

// print_r($arrnameplate);exit;


$set= new CetakFormUjiDinamis();

$statement = " AND A.PLAN_RLA_ID = '".$reqId."' ";
$set->selectByParams(array(), -1, -1, $statement);
$set->firstRow();
$reqUnit = $set->getField("NAMA_UNIT");
$reqTahun = $set->getField("TAHUN");
$reqKodeMaster = $set->getField("KODE_MASTER_PLAN");
$reqIya = $set->getField("STATUS_CATATAN");
unset($set);

$tanggalsekarang=getFormattedDate(date("Y-m-d"));

$set= new CetakFormUjiDinamis();
$arrformnameplate= [];

$statement = " AND A.NAMEPLATE_ID=".$reqNameplateId." ";
$set->selectByParamsNameplate(array(), -1, -1, $statement);
                // echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("NAMEPLATE_ID");
    $arrdata["NAMEPLATE_DETIL_ID"]= $set->getField("NAMEPLATE_DETIL_ID");
    $arrdata["MASTER_ID"]= $set->getField("MASTER_ID");
    $arrdata["NAMA"]= $set->getField("NAMA");
    $arrdata["NAMA_NAMEPLATE"]= $set->getField("NAMA_NAMEPLATE");
    $arrdata["NAMA_TABEL"]= $set->getField("NAMA_TABEL");
    $arrdata["STATUS"]= $set->getField("STATUS");
    $arrdata["ISI"]= $set->getField("ISI");

    if(!empty($arrdata["id"]))
    {
        array_push($arrformnameplate, $arrdata);
    }
}

unset($set);



// var_dump($reqIya);exit;
?>


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="<?=base_url()?>lib/startbootstrap-sb-admin-2-1.0.7/bower_components/bootstrap/dist/css/btn.css" rel="stylesheet">

    <style type="text/css" media="screen,print">
       /* Page Breaks */

/***Always insert a page break before the element***/
       .pb_before {
           page-break-before: always !important;
       }

/***Always insert a page break after the element***/
       .pb_after {
           page-break-after: always !important;
       }

/***Avoid page break before the element (if possible)***/
       .pb_before_avoid {
           page-break-before: avoid !important;
       }

/***Avoid page break after the element (if possible)***/
       .pb_after_avoid {
           page-break-after: avoid !important;
       }

/* Avoid page break inside the element (if possible) */
       .pbi_avoid {
           page-break-inside: avoid !important;
       }

   </style>

</head>
<body>
    <div class="col-md-12">
       
        <div class="konten-area"  >
            <div class="tab-content" >
                <div id="nameplate" class="tab-pane fade in active" >
                    <div class='col-md-12' >
                        <br>
                        <div class="pbi_avoid">
                            <table style="border-collapse: collapse; border: 1px solid black; font-size:11px; width: 100%;">
                                <thead>
                                    <tr>
                                        <td rowspan="4" style="width:80px;">
                                            <img src="<?=base_url()?>/images/logo-pjb.png" style="width: 120px;" class="logo-slip">
                                        </td>
                                        <td colspan="6" style="border: 1px solid black;" align="center"><strong>PT PEMBANGKITAN JAWA BALI</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="border: 1px solid black;" align="center">
                                            <strong>PJB INTEGRATED MANAGEMENT SYSTEM</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="border: 1px solid black;" align="center">
                                            <strong>LAPORAN ASSESSMENT <?=strtoupper($reqNameplateNama)?></strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="border: 1px solid black;" align="center">
                                            <strong> <?=$reqUnit?></strong>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <br />
                        <div class='judul-laporan' style="font-family: tahoma">
                            <h4 style="margin-left:60px;"><b><?=$reqNameplateKelompok?> </b></h4>
                            <h4 style="margin-left:60px;"><b>Nameplate <?=$reqNameplateNama?> </b></h4>
                            <br>

                            <table style="border-collapse: collapse;margin-left:80px;font-size:12px;font-family: tahoma" >
                                <?
                                if(!empty($arrformnameplate))
                                {
                                    foreach ($arrformnameplate as $vnameplate)
                                    {
                                        $reqFormUjiNameplateId= $vnameplate["FORM_UJI_NAMEPLATE_ID"];
                                        $reqNameplateDetilId= $vnameplate["NAMEPLATE_DETIL_ID"];
                                        $reqMasterId= $vnameplate["MASTER_ID"];
                                        $reqNameplateNama= $vnameplate["NAMA"];
                                        $reqNamaNameplate= $vnameplate["NAMA_NAMEPLATE"];
                                        $reqNamaTabel= $vnameplate["NAMA_TABEL"];
                                        $reqStatusTable= $vnameplate["STATUS"];
                                        $reqIsiNameplate= $vnameplate["ISI"];

                                        if(!empty($reqNamaTabel) && $reqStatusTable==1)
                                        {
                                            $statement= "AND ".$reqNamaTabel."_ID = ".$reqIsiNameplate;
                                            $setmaster= new Nameplate();
                                            $setmaster->selectByParamsCheckTabel(array(), -1, -1, $statement,$sOrder,$reqNamaTabel);
                                            $setmaster->firstRow();
                                            $reqIsiNameplate=$setmaster->getField("NAMA");

                                        }
                                        ?>

                                        <tr style="">
                                            <td style="vertical-align: top;width: 50px">-</td>
                                            <td style="vertical-align: top;width: 200px"><?=$reqNameplateNama?></td>
                                            <td style="vertical-align: top;">: &nbsp;</td>
                                            <td><?=$reqIsiNameplate?></td>
                                        </tr>
                                        <?
                                    }
                                    ?>
                                    <?
                                }
                                ?>
                            </table>

                            <br>
                        </div>
                    </div>
                </div>
                 

            </div>
    </div>
    <div class="pb_after"></div>
   
</body>
