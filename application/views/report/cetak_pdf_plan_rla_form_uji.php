<?php
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->model("base-app/CetakFormUjiDinamis");
$this->load->model('base-app/PlanRla');
$this->load->model('base-app/FormUji');
$this->load->model('base-app/Nameplate');
$this->load->model('base-app/TabelTemplate');
$this->load->model('base-app/PlanRlaFormUjiDinamis');




$appuserkodehak= $this->appuserkodehak;

$pgtitle= $pg;
$pgtitle= churuf(str_replace("_", " ", str_replace("transaksi_", "", $pgtitle)));
$reqIdRla = $this->input->get("reqIdRla");
$reqId = $this->input->get("reqId");
$reqKelompokEquipmentId = $this->input->get("reqKelompokEquipmentId");
$reqKelompokEquipmentParentId = $this->input->get("reqKelompokEquipmentParentId");
$reqFormUjiId = $this->input->get("reqFormUjiId");
$reqIdParent = $this->input->get("reqIdParent");
$reqIdParent = substr($reqIdParent, 0, 3); 
$reqCheck = $this->input->get("reqCheck");
$reqAkhir = $this->input->get("reqAkhir");
$reqIya = $this->input->get("reqIya");


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




if($reqCheck==1)
{
$statement = " AND D.PLAN_RLA_ID = '".$reqId."' AND D.KELOMPOK_EQUIPMENT_ID = '".$reqKelompokEquipmentId."'  ";
}
else
{

$statement = " AND D.PLAN_RLA_ID = '".$reqId."'  AND LEFT(E.ID,3)  LIKE '%".$reqIdParent."%'  ";

}
if(!empty($reqFormUjiId))
{
    $statement .= " AND B.FORM_UJI_ID = '".$reqFormUjiId."'   ";

}


$arrformujiisi= [];

$set= new CetakFormUjiDinamis();


$set->selectByParamsFormUjiReport(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["FORM_UJI_ID"]= $set->getField("FORM_UJI_ID");
    $arrdata["KELOMPOK_EQUIPMENT_ID"]= $set->getField("KELOMPOK_EQUIPMENT_ID");
    $arrdata["NAMA"]= $set->getField("NAMA");
    $arrdata["NAMA_KELOMPOK"]= $set->getField("NAMA_KELOMPOK");
    $arrdata["JUMLAH"]= $set->rowCount;
    $arrdata["NAMEPLATE_ID"]= $set->getField("NAMEPLATE_ID");
    $arrdata["PARENT_ID"]= $set->getField("PARENT_ID");
    $arrdata["ID"]= $set->getField("ID");

    array_push($arrformujiisi, $arrdata);
}
unset($set);


$statement = " AND A.PLAN_RLA_ID = '".$reqId."' ";
$set= new PlanRla();
$set->selectByParamsSummary(array(), -1, -1, $statement);
// echo  $set->query;exit;
$set->firstRow();
$reqTestedNama= $set->getField("TESTED_NAMA");
$reqCoordinatorNama= $set->getField("COORDINATOR_NAMA");
$reqQualityNama= $set->getField("QUALITY_NAMA");
$reqWitnessNama= $set->getField("WITNESS_NAMA");
unset($set);


// var_dump($reqIya);exit;
?>

<head>
        <style type="text/css">
 #holder {
    margin :0 auto;
    display:inline-block;
    width: 200px;
}
.left {
    float:left;
}
.right {
    float:right;
}
#logo {
    align:middle;
    text-align:center;
    display: flex;
}
#wrapper {
    height:200px;
    position: relative;
    padding: 0em 0em 0em 0em;
    background: #fff;
    border: 1px solid blue;
}
#container {
    width:100%;
    text-align:center;
}


#left {
    float:left;
    /*width:100px;*/
    height: 20px;
}

#center {
    display: inline-block;
    margin:0 auto;
    /*width:100px;*/
    height: 20px;
}

#right {
    float:right;
    height: 20px;
}

.alignMe b {
  display: inline-block;
  /*width: 50%;*/
  position: relative;
  padding-right: 32px; /* Ensures colon does not overlay the text */
}

.alignMe b::after {
  content: ":";
  position: absolute;
  right: 10px;
}


p.form_text1>span {
  display: inline-block;
  min-width: 120px;
}

* {
  box-sizing: border-box;
}

.row {
  margin-left:-5px;
  margin-right:-5px;
}
  
.column {
  float: left;
  width: 50%;
  padding: 5px;
}

/* Clearfix (clear floats) */
.row::after {
  content: "";
  clear: both;
  display: table;
}




</style>

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

                
                <?
                if(!empty($arrformujiisi))
                {
                ?>
                    <?
                    foreach ($arrformujiisi as $key => $value) 
                    {
                        $reqFormUjiId=$value["FORM_UJI_ID"]; 
                        $reqKelompokEquipmentId=$value["KELOMPOK_EQUIPMENT_ID"]; 
                        $reqNamaKelompok=$value["NAMA_KELOMPOK"]; 
                        $reqNamaFormUji= $value["NAMA"]; 
                        $jumlahdata=  $value["JUMLAH"];
                        $reqNameplateId= $value["NAMEPLATE_ID"];

                        $arrisirla= [];
                        $statement = " AND F.KELOMPOK_EQUIPMENT_ID = ".$reqKelompokEquipmentId." AND F.FORM_UJI_ID= ".$reqFormUjiId."  AND F.PLAN_RLA_ID = '".$reqId."'";

                        $setlist= new CetakFormUjiDinamis();
                        $setlist->selectByParamsPengukuranTipeInputBaru(array(), -1,-1,$statement);
                        // echo $setlist->query;
                        $tabeli=1;
                        $checkbinary=0;
                        $indexbinary=1;


                        while($setlist->nextRow())
                        {
                            $vpengukuranid= $setlist->getField("PENGUKURAN_ID");
                            $vstatustable= $setlist->getField("STATUS_TABLE");
                            $vtabeltemplateid= $setlist->getField("TABEL_TEMPLATE_ID");
                            $vkeystatus= $vpengukuranid."-".$vstatustable."-".$vtabeltemplateid;
                            $vseq= $setlist->getField("SEQ");

                            $vseqgroup= "";
                            $vseqgroupurut= "";
                            if( strpos($vseq, ".") !== false )
                            {
                                //FIX kalau seq 10.XX
                                $hitungvseq=strtok($vseq, '.');
                                $totalseq = strlen($hitungvseq) + 1;
                                //end
                                $vseqgroup= substr($vseq, $totalseq, 1);
                                $vseqgroupurut= substr($vseq, $totalseq) % $vseqgroup;
                            }

                            $arrdata= [];
                            $arrdata["TABEL_TEMPLATE_ID"]= $vtabeltemplateid;
                            $arrdata["STATUS_TABLE"]= $vstatustable;
                            $arrdata["VALUE"]= $setlist->getField("VALUE");
                            $arrdata["PENGUKURAN_ID"]= $vpengukuranid;
                            $arrdata["PENGUKURAN_TIPE_INPUT_ID"]= $setlist->getField("PENGUKURAN_TIPE_INPUT_ID");
                            $arrdata["SEQ"]= $vseq;
                            $arrdata["SEQ_GROUP"]= $vseqgroup;
                            $arrdata["SEQ_GROUP_URUT"]= $vseqgroupurut;
                            $arrdata["SEQCHECK"]=$setlist->getField("SEQ").$setlist->getField("STATUS_TABLE");
                            $arrdata["KEY_STATUS"]= $vkeystatus;
                            $arrdata["HITUNG_VSEQ"]= $hitungvseq;
                            array_push($arrisirla, $arrdata);
                        }

                    ?>
                         <div id="formuji_<?=$reqFormUjiId?>_<?=$reqKelompokEquipmentId?>" >
                            <div class='col-md-12' >
                                <br>
                                <div >

                                    <table style="border-collapse: collapse; border: 1px solid black; font-size:13px; width: 100%;">
                                        <thead>
                                            <tr>
                                                <td rowspan="4" style="width:80px;">
                                                    <img src="<?=base_url()?>/images/logo-pjb.png" style="width: 120px;" class="logo-slip">
                                                </td>
                                                <td colspan="6" style="border: 1px solid black;" align="center"><strong>PT PEMBANGKITAN JAWA BALI</strong></td>
                                                <td style="width: 60px;">No. Dok.</td>
                                                <td style="width: 5px;">:</td>
                                                <td style="width: 150px;"> <?=$reqKodeMaster?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" style="border: 1px solid black;" align="center">
                                                    <strong>PJB INTEGRATED MANAGEMENT SYSTEM</strong>
                                                </td>
                                                <td style="width: 60px;">Tgl. Terbit</td>
                                                <td style="width: 5px;">:</td>
                                                <td style="width: 150px;"> <?=$tanggalsekarang?></td>
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
                                                    <strong><?=$reqNamaFormUji?></strong>
                                                </td>
                                                <td style="width: 60px;">Halaman</td>
                                                <td style="width: 5px;">:</td>
                                                <td style="width: 150px;">1</td>
                                            </tr>

                                            <tr>
                                                <td style="border: 1px solid black;" colspan="2">Site :   </td>
                                                <td style="border: 1px solid black;">Manufaktur</td>
                                                <td style="border: 1px solid black;">:</td>
                                                <td style="border: 1px solid black;"></td>
                                                <td style="border: 1px solid black;" rowspan="2" style="word-wrap: break-word;">Tahun <?=$reqTahun?></td>
                                                <td style="border: 1px solid black;" colspan="2">QP No. </td>
                                                <td style="border: 1px solid black;" colspan="2">FU No. </td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black;" colspan="2">Unit : <?=$reqUnit?> </td>
                                                <td style="border: 1px solid black;">Inspeksi</td>
                                                <td style="border: 1px solid black;">:</td>
                                                <td style="border: 1px solid black;"></td>
                                                <td style="border: 1px solid black;" colspan="4">OEM Doc. No. </td>
                                            </tr>
                                        </thead>
                                    </table>
                                    <br>
                                    
                                    <?

                                    $arrbarisgroup= [];
                                    $barisglobal= 8; $indexgroup= 1;
                                    $indextext= 0;
                                    foreach ($arrisirla as $keyisi => $isiv) 
                                    {
                                        $reqMasterTabelId= $isiv["TABEL_TEMPLATE_ID"]; 
                                        $reqStatusTable= $isiv["STATUS_TABLE"]; 
                                        $reqValue= $isiv["VALUE"]; 
                                        $reqTipePengukuranId= $isiv["PENGUKURAN_ID"]; 

                                        $reqPengukuranTipeInputId= $isiv["PENGUKURAN_TIPE_INPUT_ID"];
                                        $reqSeq = $isiv["SEQ"];
                                        $vseqgroup= $isiv["SEQ_GROUP"];
                                        $vseqgroupurut= $isiv["SEQ_GROUP_URUT"];
                                        $infocaristatus= $isiv["SEQCHECK"];
                                        $reqHitungVSeq= $isiv["HITUNG_VSEQ"];


                                        $keybarisgroup= $reqFormUjiId."-".$reqStatusTable."-".$reqMasterTabelId."-".$reqTipePengukuranId."-".$reqSeq;


                                        // var_dump($keybarisgroup);

                                    ?>
                                        <?
                                        if($reqStatusTable == "TABLE")
                                        {
                                            
                                            $statement = " AND A.PENGUKURAN_ID = ".$reqTipePengukuranId." AND A.KELOMPOK_EQUIPMENT_ID = ".$reqKelompokEquipmentId." AND A.FORM_UJI_ID= ".$reqFormUjiId."  AND A.PLAN_RLA_ID = '".$reqId."' AND A.TABEL_TEMPLATE_ID= ".$reqMasterTabelId." AND A.PENGUKURAN_TIPE_INPUT_ID= ".$reqPengukuranTipeInputId;
                                            $setcheck= new CetakFormUjiDinamis();
                                            $setcheck->selectByParamsPlanRlaDinamis(array(), -1,-1,$statement);
                                             // echo $setcheck->query;
                                            $setcheck->firstRow();

                                            $reqTabelId= $setcheck->getField("TABEL_TEMPLATE_ID");
                                            $reqIdPlanRla= $setcheck->getField("PLAN_RLA_FORM_UJI_DINAMIS_ID");
                                            $reqTabelNama= $setcheck->getField("TABEL_NAMA");
                                            $reqPengukuranId= $setcheck->getField("PENGUKURAN_ID");
                                            $reqPengukuranNama= $setcheck->getField("PENGUKURAN_NAMA");


                                            if(!empty($reqTabelId))
                                            {
                                                $statement = " AND A.TABEL_TEMPLATE_ID = ".$reqTabelId." ";
                                                $set= new TabelTemplate();
                                                $set->selectByParamsMaxBaris(array(), -1, -1, $statement);
                                                $set->firstRow();
                                                $maxbarisrla= $set->getField("MAX");

                                                $tabeltemplate= [];
                                                $set= new CetakFormUjiDinamis();
                                                $statement = " AND A.TABEL_TEMPLATE_ID = ".$reqTabelId." AND C.FORM_UJI_ID = ".$reqFormUjiId." ";
                                                $set->selectByParamsDetil(array(), -1, -1, $statement);
                                                // echo $set->query;
                                                while ($set->nextRow())
                                                {
                                                    $inforowspan= $set->getField("ROWSPAN");
                                                    $infobaris= $set->getField("BARIS");

                                                    $inforowspancheck= "";
                                                    if(!empty($inforowspan))
                                                        $inforowspancheck= "ADA";

                                                    $arrdata= [];
                                                    $arrdata["ROWSPAN"]= $inforowspan;
                                                    $arrdata["COLSPAN"]= $set->getField("COLSPAN");
                                                    $arrdata["BARIS"]= $infobaris;
                                                    $arrdata["BARISROWSPAN"]= $infobaris.$inforowspancheck;
                                                    $arrdata["NAMA_TEMPLATE"]= $set->getField("NAMA_TEMPLATE");
                                                    $arrdata["TOTAL"]= $set->getField("TOTAL");
                                                    $arrdata["JUMLAH"]= $set->rowCount;
                                                    $arrdata["NOTE_ATAS"]= $set->getField("NOTE_ATAS");
                                                    $arrdata["NOTE_BAWAH"]= $set->getField("NOTE_BAWAH");
                                                    array_push($tabeltemplate, $arrdata);
                                                }

                                                $note= new CetakFormUjiDinamis();

                                                $statement = " AND A.TABEL_TEMPLATE_ID = ".$reqTabelId." AND C.FORM_UJI_ID = ".$reqFormUjiId." ";
                                                $note->selectByParamsDetil(array(), -1, -1, $statement);
                                                $note->firstRow();
                                                $noteatas= $note->getField("NOTE_ATAS");
                                                $notebawah= $note->getField("NOTE_BAWAH");
                                                // print_r($maxbarisrla);

                                                $widthgroup="";
                                                if($vseqgroup > 2 )
                                                {
                                                    $widthgroup="width:30%";
                                                }


                                                ?>
                                                <!-- <br> -->
                                               
                                                    <?
                                                    if(!empty($vseqgroup) )
                                                    {
                                                    ?>
                                                     <div class="column" style="<?=$widthgroup?>">
                                                    <?
                                                    }
                                                    ?>
                                                    <div style=" font-size:13px; border: 1px; margin-left: auto; margin-right: auto; width: 50%;" ><?=$noteatas?></div>
                                                    <table style=" font-size:13px; border: 1px; margin-left: auto; margin-right: auto; width: 60%;" >
                                                            <thead style="background-color: #B8CCE4">
                                                                <?
                                                                for($index= 1; $index <= $maxbarisrla; $index++)
                                                                {
                                                                    ?>
                                                                    <tr>
                                                                        <?
                                                                        $infocarikey= $index;
                                                                        $arrcheck= in_array_column($infocarikey, "BARIS", $tabeltemplate);
                                                                        // var_dump($arrcheck);
                                                                        foreach ($arrcheck as $vindex)
                                                                        {
                                                                            $reqRowspan= $tabeltemplate[$vindex]["ROWSPAN"];
                                                                            $reqColspan= $tabeltemplate[$vindex]["COLSPAN"];
                                                                            $reqNama= $tabeltemplate[$vindex]["NAMA_TEMPLATE"];
                                                                            $reqJumlah= $tabeltemplate[$vindex]["JUMLAH"];
                                                                            $reqNoteAtas= $tabeltemplate[$vindex]["NOTE_ATAS"];
                                                                            $reqNoteBawah= $tabeltemplate[$vindex]["NOTE_BAWAH"];
                                                                            // var_dump($reqNama);
                                                                            ?>
                                                                            <th rowspan="<?=$reqRowspan?>" colspan="<?=$reqColspan?>" style="vertical-align : middle;text-align:center;border: 1px solid black;"><?=$reqNama?></th>

                                                                            <?
                                                                        }
                                                                        ?>
                                                                    </tr>
                                                                <?
                                                                }
                                                                ?>
                                                                <br>
                                                            </thead>
                                                            <tbody>
                                                                <?
                                                                $isimaster= new FormUji();
                                                                $statement = " AND A.PENGUKURAN_ID = ".$reqPengukuranId." AND STATUS_TABLE = 'TABLE' AND A.FORM_UJI_ID = ".$reqFormUjiId." AND A.TABEL_TEMPLATE_ID = '".$reqTabelId."' AND B.SEQ = ".$reqSeq." AND A.PENGUKURAN_TIPE_INPUT_ID= ".$reqPengukuranTipeInputId;
                                                                $isimaster->selectformujipengukuran(array(), -1, -1, $statement);
                                                                while($isimaster->nextRow())
                                                                {

                                                                ?>
                                                                <tr>
                                                                <?
                                                                    $reqNamaMaster= $isimaster->getField("NAMA");
                                                                    $reqIdDetil= $isimaster->getField("FORM_UJI_DETIL_DINAMIS_ID");

                                                                    $setisi= new PlanRlaFormUjiDinamis();
                                                                    $statement = " AND A.PLAN_RLA_ID = '".$reqId."' AND A.FORM_UJI_ID = '".$reqFormUjiId."'  AND A.KELOMPOK_EQUIPMENT_ID = '".$reqKelompokEquipmentId."' AND A.TABEL_TEMPLATE_ID = '".$reqTabelId."' AND A.FORM_UJI_DETIL_DINAMIS_ID = '".$reqIdDetil."' AND A.PENGUKURAN_ID = ".$reqPengukuranId." AND A.PENGUKURAN_TIPE_INPUT_ID = ".$reqPengukuranTipeInputId;
                                                                    $setisi->selectByParamsDetil(array(), -1, -1, $statement);
                                                                        // echo "<br/>".$setisi->query."<br/>";
                                                                    while($setisi->nextRow())
                                                                    {
                                                                        $reqIsi= $setisi->getField("NAMA");
                                                                ?>
                                                                        <td style="vertical-align : middle;text-align:center;border: 1px solid black;"><?=$reqIsi?></td>
                                                                    <?
                                                                    }
                                                                    ?>
                                                                </tr>

                                                                <?
                                                                }
                                                                ?>
                                                                
                                                            </tbody>
                                                    </table>
                                                    <div style=" font-size:13px; border: 1px; margin-left: auto; margin-right: auto; width: 60%;" ><?=$notebawah?></div>
                                                    <br>
                                                    <?
                                                    if(!empty($vseqgroup))
                                                    {
                                                    ?>
                                                    </div>
                                                    <?
                                                    }
                                                    ?>
                                                   

                                                <?
                                            }
                                            ?>
                                      
                                            <!-- <br> -->
                                        <?
                                        }
                                        else if($reqStatusTable=="TEXT" )
                                        {

                                            $statementv = "  AND A.PENGUKURAN_TIPE_INPUT_ID= ".$reqPengukuranTipeInputId."  AND A.FORM_UJI_ID= ".$reqFormUjiId."  AND A.STATUS_TABLE ='TEXT' AND  A.PLAN_RLA_ID =".$reqId." AND  A.KELOMPOK_EQUIPMENT_ID =".$reqKelompokEquipmentId." ";
                                            $checkvalue= new CetakFormUjiDinamis();
                                            $checkvalue->selectplanrlaujidinamis(array(), -1,-1,$statementv);
                                            $baristextcheck=0;
                                            // echo $checkvalue->query;
                                            while ($checkvalue->nextRow())
                                            {
                                                $reqNamaText=  strip_tags($checkvalue->getField("NAMA"));
                                                $baristextcheck=$reqFormUjiId;
                                                $barisglobal++;
                                            
                                        ?>
                                                <table style="border-collapse: collapse;width: 60%; max-width: 100%; margin-left: auto; margin-right: auto;">
                                                    <tr>
                                                        <td style="vertical-align: top;width: 20%;"><?=$reqValue?></td>
                                                        <td style="vertical-align: top;width: 10%;">:</td>
                                                        <td><?=$reqNamaText?></td>
                                                    </tr>
                                                   
                                                </table>
                                                <br>
                                        <?
                                            
                                            }
                                        }
                                        else if($reqStatusTable=="PIC" )
                                        {

                                            $statementv = " AND A.PLAN_RLA_ID = ".$reqId." AND A.PENGUKURAN_TIPE_INPUT_ID= ".$reqPengukuranTipeInputId."  AND A.FORM_UJI_ID= ".$reqFormUjiId." AND A.STATUS_TABLE ='PIC' ";
                                            $setjumlah= new CetakFormUjiDinamis();
                                            $setjumlah->selectplanrlaujidinamis(array(), -1,-1,$statementv);
                                            $setjumlah->firstRow();
                                            // echo $setjumlah->query;
                                            $reqLinkGambar= $setjumlah->getField("LINK_FILE");

                                        ?>
                                        <?
                                        // if(file_exists($reqLinkGambar))
                                        // {
                                        ?>
                                            <br>
                                            <div class="gambar" style="width: 60%; max-width: 100%; margin-left: auto; margin-right: auto;">  
                                            <?
                                                    $statementv = " AND A.PLAN_RLA_ID = ".$reqId." AND A.PENGUKURAN_TIPE_INPUT_ID= ".$reqPengukuranTipeInputId."  AND A.FORM_UJI_ID= ".$reqFormUjiId." AND A.STATUS_TABLE ='PIC' ";
                                                    $checkvalue= new CetakFormUjiDinamis();
                                                    $checkvalue->selectplanrlaujidinamis(array(), -1,-1,$statementv);
                                                    // echo $checkvalue->query;
                                                    $indexloop=0;
                                                    $icheck=1;
                                                    $jumlah=0;
                                                    while ($checkvalue->nextRow())
                                                    {
                                                        // var_dump($checkvalue->rowCount);
                                                        $jumlah=$checkvalue->rowCount;
                                                        $reqNamaGambar= $checkvalue->getField("NAMA");
                                                        $reqLinkGambar= $checkvalue->getField("LINK_FILE");
                                                        if(file_exists($reqLinkGambar))
                                                        {
                                                            $checkbr="";
                                                            if(!empty($vseqgroup))
                                                            {
                                                                if($vseqgroup == $indexloop)
                                                                {
                                                                    $indexloop= 0;
                                                                    $vkolom=3;

                                                                }
                                                                else
                                                                {
                                                                    if($indexloop == 0)
                                                                    {
                                                                        $vkolom=3;
                                                                    }
                                                                    else
                                                                    {
                                                                        $vkolom=6;  
                                                                        $checkbr="<br>";   
                                                                    }

                                                                }
                                                            }
                                                            else
                                                            {
                                                                if($indexloop == 0)
                                                                {
                                                                    $vkolom=3;
                                                                }
                                                                else
                                                                {
                                                                    $vkolom=6;
                                                                }
                                                            }
                                                                                                                  
                                                            $classgambar="left";
                                                            $stylegambar="";
                                                            if($vkolom==6)
                                                            {
                                                                $classgambar="right";
                                                                $stylegambar="";
                                                            }

                                                            $indexloop++;
                                                            $icheck++;

                                                            if($icheck== $jumlah )
                                                            {
                                                                $checkbr="<br>";
                                                            }
                                                            ?>
                                                            <div id="holder" style="<?=$stylegambar?>"  >
                                                                <div id="logo" class='<?=$classgambar?>' >
                                                                    <img src="<?=base_url()?>/<?=$reqLinkGambar?>" width="200px" height="200px" />
                                                                </div>
                                                            </div>
                                                            <?=$checkbr?>
                                                        <?
                                                        }
                                                    }
                                                    ?>
                                            </div>

                                            <?=$checkbr?>
                                        <?
                                        // }
                                        ?>
                                        <?
                                        }
                                        else if($reqStatusTable=="BINARY" )
                                        {
                                            $brgroup="";
                                            $arrbrgroup=[];
                                            if(!empty($vseqgroup))
                                            {
                                                if($vseqgroupurut == "1")
                                                {
                                                    $vkolom= 3;
                                                    $indexgroup= 1;
                                                }
                                                else
                                                {
                                                    $vkolom+= 4;
                                                }

                                                $statement = " AND F.KELOMPOK_EQUIPMENT_ID = ".$reqKelompokEquipmentId." AND F.FORM_UJI_ID= ".$reqFormUjiId."  AND F.PLAN_RLA_ID = '".$reqId."' AND D.seq::text  like  '%".$reqHitungVSeq."%' ";

                                                $indexbinarygroup=1;

                                                $order=" ORDER BY A.PENGUKURAN_ID,D.SEQ DESC";

                                                $setlistcheck= new CetakFormUjiDinamis();
                                                $setlistcheck->selectByParamsPengukuranTipeInputBaru(array(), -1,-1,$statement,$order);
                                                // echo $setlistcheck->query;
                                                $setlistcheck->firstRow();
                                                $reqPengukuranTipeInputIdLast=  $setlistcheck->getField("PENGUKURAN_TIPE_INPUT_ID");
                                                
                                                if($reqPengukuranTipeInputIdLast == $reqPengukuranTipeInputId )
                                                {
                                                    $brgroup=1;

                                                }
                                                else
                                                {
                                                    $brgroup=0;
                                                }

                                                // print_r($brgroup);
                                                                                                 
                                            }
                                            else
                                            {
                                                $vkolom= 3;
                                            }
                                            $align="left";
                                            if($vkolom==7)
                                            {
                                               $align="right";
                                            }
                                            
                                            $statementv = "  AND A.PENGUKURAN_TIPE_INPUT_ID= ".$reqPengukuranTipeInputId."  AND A.FORM_UJI_ID= ".$reqFormUjiId."  AND A.STATUS_TABLE ='BINARY' AND  A.PLAN_RLA_ID =".$reqId." AND  A.KELOMPOK_EQUIPMENT_ID =".$reqKelompokEquipmentId." ";
                                            $setjumlah= new CetakFormUjiDinamis();
                                            $setjumlah->selectplanrlaujidinamis(array(), -1,-1,$statementv);
                                            $setjumlah->firstRow();
                                            // echo $setjumlah->query;
                                            $jumlah=$setjumlah->rowCount;
                                            if($jumlah > 0)
                                            {}
                                            else
                                            {
                                                continue;
                                            }

                                            $checkbr="";

                                            if($jumlah== $indexbinary && !empty($vseqgroup)  )
                                            {
                                                 $checkbr="<br>";
                                            }

                                            $indexbinary++;

                                            $indexgroup++;
                                       ?>
                                            <?
                                                $statementv = "  AND A.PENGUKURAN_TIPE_INPUT_ID= ".$reqPengukuranTipeInputId."  AND A.FORM_UJI_ID= ".$reqFormUjiId."  AND A.STATUS_TABLE ='BINARY' AND  A.PLAN_RLA_ID =".$reqId." AND  A.KELOMPOK_EQUIPMENT_ID =".$reqKelompokEquipmentId." ";
                                                $checkvalue= new CetakFormUjiDinamis();
                                                $checkvalue->selectplanrlaujidinamis(array(), -1,-1,$statementv);
                                                // echo $checkvalue->query;
                                                while ($checkvalue->nextRow())
                                                {
                                                    $reqNamaText=  $checkvalue->getField("NAMA");  
                                            ?>
                                              <!--   <div id="container" class="alignMe" style="width: 60%; max-width: 100%; margin-left: auto; margin-right: auto;"  >
                                                    <div id="<?=$align?>"  > <b>  <?=$reqValue?>  </b> <?=$reqNamaText?> </div> 
                                                </div> -->

                                                <?
                                                if(!empty($vseqgroup) )
                                                {
                                                    ?>
                                                    <div class="column">
                                                        <?
                                                    }
                                                    ?>

                                                    <table style="border-collapse: collapse;width: 60%; max-width: 100%; margin-left: auto; margin-right: auto;">
                                                        <tr>
                                                            <td style="vertical-align: top;width: 30%;"><?=$reqValue?></td>
                                                            <td style="vertical-align: top;width: 10%;">:</td>
                                                            <td><?=$reqNamaText?></td>
                                                        </tr>
                                                    </table>


                                                    <?
                                                    if(!empty($vseqgroup) )
                                                    {
                                                        ?>
                                                    </div>
                                                    <?
                                                }
                                                ?>
                                            <?
                                                }
                                            ?>

                                            <?
                                            if(empty($vseqgroup) )
                                            {
                                            ?>
                                            <br>
                                            <?
                                            }
                                            ?>

                                            <?
                                            if( $vkolom == 7 )
                                            {
                                            ?>
                                            <br>
                                            <br>
                                            <br>
                                            <?
                                            }
                                            ?>

                                            <?
                                            if($brgroup==1)
                                            {
                                            ?>
                                            <br>
                                            <br>
                                            <br>
                                            <?
                                            }
                                            ?>

                                            <?=$checkbr?>
                                        <?
                                        }
                                        else if($reqStatusTable=="ANALOG" )
                                        {
                                            
                                            $statementv = "  AND A.PENGUKURAN_TIPE_INPUT_ID= ".$reqPengukuranTipeInputId."  AND A.FORM_UJI_ID= ".$reqFormUjiId."  AND A.STATUS_TABLE ='ANALOG' AND  A.PLAN_RLA_ID =".$reqId." AND  A.KELOMPOK_EQUIPMENT_ID =".$reqKelompokEquipmentId." ";
                                            $setjumlah= new CetakFormUjiDinamis();
                                            $setjumlah->selectplanrlaujidinamis(array(), -1,-1,$statementv);
                                            $setjumlah->firstRow();
                                            // echo $setjumlah->query;
                                            $jumlah=$setjumlah->rowCount;
                                            if($jumlah > 0)
                                            {}
                                            else
                                            {
                                                continue;
                                            }

                                            if(!empty($vseqgroup))
                                            {

                                                if($vseqgroupurut == "1")
                                                {
                                                    $vkolom= 3;
                                                    $indexgroup= 1;
                                                }
                                                else
                                                {
                                                    $vkolom+= 4;
                                                }

                                                $statement = " AND F.KELOMPOK_EQUIPMENT_ID = ".$reqKelompokEquipmentId." AND F.FORM_UJI_ID= ".$reqFormUjiId."  AND F.PLAN_RLA_ID = '".$reqId."' AND D.seq::text  like  '%".$reqHitungVSeq."%' ";

                                                $indexbinarygroup=1;

                                                $order=" ORDER BY A.PENGUKURAN_ID,D.SEQ DESC";

                                                $setlistcheck= new CetakFormUjiDinamis();
                                                $setlistcheck->selectByParamsPengukuranTipeInputBaru(array(), -1,-1,$statement,$order);
                                                // echo $setlistcheck->query;
                                                $setlistcheck->firstRow();
                                                $reqPengukuranTipeInputIdLast=  $setlistcheck->getField("PENGUKURAN_TIPE_INPUT_ID");
                                                
                                                if($reqPengukuranTipeInputIdLast == $reqPengukuranTipeInputId )
                                                {
                                                    $brgroup=1;

                                                }
                                                else
                                                {
                                                    $brgroup=0;
                                                }
                                                                      
                                            }
                                            else
                                            {
                                                $vkolom= 3;
                                            }
                                            $align="left";
                                            if($vkolom==7)
                                            {
                                               $align="right";
                                            }
                                            $checkbr="<br>";
                                            if($vkolom==7)
                                            {
                                               $checkbr="";
                                            }

                                            $indexgroup++;

                                            $statementv = "  AND A.PENGUKURAN_TIPE_INPUT_ID= ".$reqPengukuranTipeInputId."  AND A.FORM_UJI_ID= ".$reqFormUjiId."  AND A.STATUS_TABLE ='ANALOG' AND  A.PLAN_RLA_ID =".$reqId." AND  A.KELOMPOK_EQUIPMENT_ID =".$reqKelompokEquipmentId." ";
                                            $checkvalue= new CetakFormUjiDinamis();
                                            $checkvalue->selectplanrlaujidinamis(array(), -1,-1,$statementv);
                                            while ($checkvalue->nextRow())
                                            {
                                                $reqNamaText=  $checkvalue->getField("NAMA");

                                                if(!empty($vseqgroup))
                                                {
                                                    if($vseqgroupurut == "1")
                                                    {
                                                        $vkolom= 3;
                                                        $tempbaris= $barisglobal;
                                                        $indexgroup= 1;
                                                    }
                                                    else
                                                    {
                                                        $vkolom+= 4;
                                                    }

                                                    if($indexgroup == $vseqgroup && !empty($tempbaris))
                                                    {
                                                        $barisglobal= $tempbaris;
                                                        $indexgroup= 1;
                                                    }
                                                }
                                                else
                                                {
                                                    $vkolom= 3;
                                                }

                                                $indexgroup++;

                                                // print_r($vkolom);

                                        ?>
                                            <?=$checkbr?>
                                               <!--  <div id="container" class="alignMe" style="width: 60%; max-width: 100%; margin-left: auto; margin-right: auto;"  >
                                                    <div id="<?=$align?>"  > <b>  <?=$reqValue?>  </b> <?=$reqNamaText?></div>
                                                </div> -->

                                                    <?
                                                    if(!empty($vseqgroup) )
                                                    {
                                                    ?>
                                                    <div class="column">
                                                    <?
                                                    }
                                                    ?>

                                                    <table style="border-collapse: collapse;width: 60%; max-width: 100%; margin-left: auto; margin-right: auto;">
                                                        <tr>
                                                            <td style="vertical-align: top;width: 30%;"><?=$reqValue?></td>
                                                            <td style="vertical-align: top;width: 10%;">:</td>
                                                            <td><?=$reqNamaText?></td>
                                                        </tr>
                                                    </table>

                                                    <?
                                                    if(!empty($vseqgroup) )
                                                    {
                                                    ?>
                                                    </div>

                                                    <?
                                                    }
                                                    ?>
                                        <?
                                            }
                                        ?>
                                            <?
                                            if(empty($vseqgroup))
                                            {
                                            ?>
                                            <br>  
                                            <?
                                            }
                                            ?>

                                            <?
                                            if( $vkolom == 11 )
                                            {
                                            ?>
                                            <br>
                                            <br>
                                            <br>
                                            <?
                                            }
                                            ?>

                                            <?
                                            if($brgroup==1)
                                            {
                                            ?>
                                            <br>
                                            <?
                                            }
                                            ?>
                                        <?
                                        }
                                        ?>
                                    <?
                                    }
                                    ?>
                                    <br>
                                    <table style="border-collapse: collapse; border: 1px solid black; font-size:13px; width: 100%;">
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
                                            <td style="border: 1px solid black; text-align: center;" colspan="2"><?=$reqTestedNama?></td>
                                            <td style="border: 1px solid black; text-align: center;"><?=$reqCoordinatorNama?></td>
                                            <td style="border: 1px solid black; text-align: center;"><?=$reqQualityNama?></td>
                                            <td style="border: 1px solid black; text-align: center;"><?=$reqWitnessNama?></td>
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
                                            <td style="border: 1px solid black; text-align: center;" colspan="2"><?=$tanggalsekarang?></td>
                                            <td style="border: 1px solid black; text-align: center;"><?=$tanggalsekarang?></td>
                                            <td style="border: 1px solid black; text-align: center;"><?=$tanggalsekarang?></td>
                                            <td style="border: 1px solid black; text-align: center;"><?=$tanggalsekarang?></td>
                                        </tr>
                                    </table>
                                </div>
                                 <br>
                            </div>
                        </div>
                    <?
                    }
                    ?>
                <?
                }
                ?>
                 

            </div>
    </div>

    <?
    if($reqAkhir !== "1")
    {
        ?>
        <div class="pb_after"></div>
        <?
    }
    ?>

    <?

    if($reqAkhir=="1" && !empty($reqIya))
    {

        ?>
        <div class="pb_after"></div>
        <?
    }
    ?>


</body>