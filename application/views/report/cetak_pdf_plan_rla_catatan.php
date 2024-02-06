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

$statement = " AND A.PLAN_RLA_ID = '".$reqId."' ";
$set->selectByParams(array(), -1, -1, $statement);

// echo $set->query;exit; 
$set->firstRow();
$reqUnit = $set->getField("NAMA_UNIT");
$reqTahun = $set->getField("TAHUN");
$reqKodeMaster = $set->getField("KODE_MASTER_PLAN");
$reqIya = $set->getField("STATUS_CATATAN");
unset($set);

$tanggalsekarang=getFormattedDate(date("Y-m-d"));

$arrcatatan= [];
$set= new CetakFormUjiDinamis();
$arrcatatan= [];
$statement = " AND A.PLAN_RLA_ID = '".$reqId."' AND A.STATUS_CATATAN = '1'  ";

$set->selectByParamsPlanRlaCatatan(array(), -1,-1,$statement);
            // echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["NAMA_CATATAN"]= $set->getField("NAMA_CATATAN");
    $arrdata["TANGGAL_CATATAN"]= $set->getField("TANGGAL_CATATAN");
    $arrdata["CATATAN"]= $set->getField("CATATAN");
    array_push($arrcatatan, $arrdata);
}
unset($set);




// var_dump($reqIya);exit;
?>


<style>
	thead.stick-datatable th:nth-child(1){	width:440px !important; *border:1px solid cyan;}
	thead.stick-datatable ~ tbody td:nth-child(1){	width:440px !important; *border:1px solid yellow;}
</style>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="<?=base_url()?>lib/startbootstrap-sb-admin-2-1.0.7/bower_components/bootstrap/dist/css/btn.css" rel="stylesheet">

    <style type="text/css" media="screen,print">
       .pb_before {
           page-break-before: always !important;
       }

       .pb_after {
           page-break-after: always !important;
       }

       .pb_before_avoid {
           page-break-before: avoid !important;
       }

       .pb_after_avoid {
           page-break-after: avoid !important;
       }

       .pbi_avoid {
           page-break-inside: avoid !important;
       }

     </style>

</head>
<body>
    <!-- <div class="pb_before "></div> -->
    <div class="col-md-12">
        <div class="konten-area"  >
            <div class="tab-content" >

                <div id="nameplate" class="tab-pane fade in active" >
                    <div class='col-md-12'  >
                        <br>
                        <div >
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
                                            <strong>Catatan Rla <?=$reqKodeMaster?></strong>
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
                        <br />
                        <br />
                        <div class='judul-laporan' style="font-family: tahoma;text-align: center">
                            <table style="border-collapse: collapse;text-align: center;font-size:12px;font-family: tahoma" >
                                  <tr style="">
                                            <th style="vertical-align: top;width: 50px;border: 1px solid black;">No</th>
                                            <th style="vertical-align: top;width: 200px;border: 1px solid black;">Nama/Nid</th>
                                            <th style="vertical-align: top;border: 1px solid black;">Tanggal</th>
                                            <th style="vertical-align: top;border: 1px solid black;">Catatan</th>
                                        </tr>
                                <?
                                if(!empty($arrcatatan))
                                {
                                    $z=1;
                                    foreach ($arrcatatan as $key => $vcatatan) {

                                        $reqNamaCatatan=$vcatatan["NAMA_CATATAN"]; 
                                        $reqTanggalCatatan=$vcatatan["TANGGAL_CATATAN"]; 
                                        $reqCatatan=$vcatatan["CATATAN"];
                                        ?>

                                        <tr style="">
                                             <td style="vertical-align: top;width: 50px;border: 1px solid black;"><?=$z?></td>
                                            <td style="vertical-align: top;width: 50px;border: 1px solid black;"><?=$reqNamaCatatan?></td>
                                            <td style="vertical-align: top;width: 200px;border: 1px solid black;"><?=$reqTanggalCatatan?></td>
                                            <td style="vertical-align: top;border: 1px solid black;"><?=$reqCatatan?></td>
                                            <td></td>
                                        </tr>
                                        <?
                                        $z++;
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
 
</body>
