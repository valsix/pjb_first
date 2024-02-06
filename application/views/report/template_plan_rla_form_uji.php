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
$reqMaxDev= $set->getField("MAX_DEV");
$reqResult= $set->getField("RESULT");
$reqNote= $set->getField("NOTE");
$reqNama= $set->getField("NAMA");

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
       <div class="form-group">  
        <label class="control-label col-md-2">Template</label>
        <div class='col-md-4'>
            <?
            // foreach($reqListFormUji as $kunci => $nilai) 
            // {

                ?>
                <div class='form-group'>
                    <div class='col-md-12'>
                     
                        <table class="table table-bordered table-striped table-hovered" style="width: 100%">
                            <thead>
                                <th style="width: 50%" >Tipe</th>
                                <th>Link Template</th>
                                <th>Upload</th>
                            </thead>
                            <tbody>
                                <?
                                // foreach($reqTipeIdUji as $key => $value) 
                                // {
                                   
                                    ?>

                                    <tr>
                                        <td style="width: 50%"><?=$reqTipeIdNama[$key]?></td>
                                        <td style="text-align: center"><span style="background-color: green;padding: 8px; border-radius: 5px;"><a onclick="cetak_excel('<?=$value?>','<?=$reqId?>')"><i class="fa fa-download fa-lg" style="color: white;" aria-hidden="true"></i></a></span></td>
                                        <td style="text-align: center"><input type="file" name=""></td>
                                        
                                    </tr>
                                    <?
                                // }
                                ?>
                                
                            </tbody>
                        </table>
                        
                    </div>
                </div>
                <?
            // }
            ?>
        </div>
    </div> 
    
</body>
</html>