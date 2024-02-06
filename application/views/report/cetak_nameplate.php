<html moznomarginboxes mozdisallowselectionprint>
<?
include_once("functions/default.func.php");
include_once("functions/date.func.php");
include_once("functions/string.func.php");


$reqTipe= $this->input->get("reqTipe");
$reqId= $this->input->get("reqId");
$reqNameplateId= $this->input->get("reqNameplateId");

// print_r($reqId);exit;
$this->load->model('base-app/FormUji');
$this->load->model('base-app/Nameplate');


$set= new Nameplate();
$arrnameplate= [];
$statement = " AND A.NAMEPLATE_ID=".$reqNameplateId."";

$set->selectByParams(array(), -1, -1, $statement);
$set->firstRow();
$reqNamaNameplate= $set->getField("NAMA");
    // echo  $set->query;exit;

unset($set);

$set= new FormUji();
$arrformnameplate= [];

$statement = " AND A.NAMEPLATE_ID=".$reqNameplateId." AND A.FORM_UJI_ID=".$reqId."";
$set->selectByParamsNameplate(array(), -1, -1, $statement);
    // echo  $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("FORM_UJI_NAMEPLATE_ID");
    $arrdata["NAMEPLATE_DETIL_ID"]= $set->getField("NAMEPLATE_DETIL_ID");
    $arrdata["MASTER_ID"]= $set->getField("MASTER_ID");
    $arrdata["NAMA"]= $set->getField("NAMA");
    $arrdata["NAMA_NAMEPLATE"]= $set->getField("NAMA_NAMEPLATE");
    $arrdata["NAMA_TABEL"]= $set->getField("NAMA_TABEL");
    $arrdata["STATUS"]= $set->getField("STATUS");

    array_push($arrformnameplate, $arrdata);
}


?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">


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
                </tr>
                <tr>
                    <td colspan="6" style="border: 1px solid black;" align="center">
                        <strong>PJB INTEGRATED MANAGEMENT SYSTEM</strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" style="border: 1px solid black;" align="center">
                        <strong>LAPORAN ASSESSMENT</strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" style="border: 1px solid black;" align="center">
                        <strong><?=strtoupper($reqNamaNameplate)?></strong>
                    </td>
                </tr>
            </thead>
        </table>
    </div>
    <br />

    <div class='judul-laporan' style="font-family: tahoma">
        <br>
        <br>
        <h4 style="margin-left:60px;"><b>Nameplate <?=$reqNamaNameplate?> </b></h4>
       <?

        foreach($arrformnameplate as $item) 
        {
          $id= $item["id"];
          $detilnama=$item["NAMA"];
          $kolomnama=$item["NAMA_NAMEPLATE"];
          $tabelnama=$item["NAMA_TABEL"];
          $detilstatus=$item["STATUS"];
          $detilmasterid=$item["MASTER_ID"];

          $arrMaster= [];
          $statement = " ";
          $sOrder="";

            if(!empty($tabelnama) && $detilstatus==1)
            {
                $set= new Nameplate();
                $set->selectByParamsCheckTabel(array(), -1, -1, $statement,$sOrder,$tabelnama);
                while($set->nextRow())
                {
                    $arrdata= array();
                    $arrdata["id"]= $set->getField("".$tabelnama."_ID");
                    $arrdata["NAMA"]= $set->getField("NAMA");

                    array_push($arrMaster, $arrdata);
                }
            }
        ?>

            <table style="border-collapse: collapse;margin-left:80px;font-size:12px;font-family: tahoma" >
                <tr style="">
                    <td style="vertical-align: top;width: 50px">-</td>
                    <td style="vertical-align: top;width: 200px"><?=$kolomnama?></td>
                    <td style="vertical-align: top;">: &nbsp;</td>
                    <td><?=$detilnama?></td>
                </tr>
            </table>

        <?
        }
        ?>        
        <br>
    </div>

   

    <div style='clear:both;'>&nbsp;</div>

    
</body>
</html>
<pagebreak>