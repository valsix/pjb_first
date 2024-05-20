
<?
$this->load->model("base-app/HasilAssessment");
$this->load->model("base-app/Kemungkinan");
$this->load->model("base-app/Dampak");
$this->load->model("base-app/Kesesuaian");
$this->load->model("base-app/MatriksRisiko");
$this->load->model("base-app/Crud");
$this->load->model("base/Users");





$reqDistrikId= $this->input->get("reqDistrikId");
$reqBlok= $this->input->get("reqBlok");
$reqTahun= $this->input->get("reqTahun");
$reqStatus= $this->input->get("reqStatus");
$reqListAreaId= $this->input->get("reqListAreaId");
$reqBulan= $this->input->get("reqBulan");

$appuserkodehak= $this->appuserkodehak;
$appuserkodehak= $this->appuserkodehak;
$reqPenggunaid= $this->appuserid;

$checkrole= new Crud();
$statement=" AND A.KODE_HAK LIKE '%".$appuserkodehak."%'";

$checkrole->selectByParams(array(), -1, -1, $statement);
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

if(!empty($idDistrik))
{
    $reqDistrikId=$idDistrik;
}



$statement="";

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
$arrrekap= [];
$statement="";

if(!empty($reqDistrikId))
{
    $statement.=" AND A.DISTRIK_ID IN (".$reqDistrikId.")";
}
if(!empty($reqBlok))
{
    $statement.=" AND A.BLOK_UNIT_ID=".$reqBlok;
}
if(!empty($reqTahun))
{
    $statemenstatus.=" AND F.TAHUN=".$reqTahun;
}
if($reqStatus==20)
{
    $statemenstatus=" AND F.V_STATUS=".$reqStatus;
}
elseif($reqStatus==100)
{
    $statemenstatus=" AND F.V_STATUS <> 20";
}
if(!empty($reqListAreaId))
{
            // $statemenstatus.=" AND A.LIST_AREA_ID=".$reqListAreaId;
    $statemenstatus.=" AND A.LIST_AREA_ID IN (".$reqListAreaId.")";
}

if(!empty($reqBulan))
{
    $statemenstatus.=" AND F.BULAN ='".$reqBulan."'";
}
        

$set->selectByParamsNew(array(), -1,-1,$statement,"","",$statemenstatus);// echo $set->query;exit;
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


    $statement=" AND A.LIST_AREA_ID =".$set->getField("LIST_AREA_ID")."  AND A.AREA_UNIT_DETIL_ID= ".$set->getField("AREA_UNIT_DETIL_ID")." AND a.ITEM_ASSESSMENT_DUPLIKAT_ID= ".$set->getField("ITEM_ASSESSMENT_DUPLIKAT_ID");

    $mp= new Kesesuaian();

    $mp->selectByParamsNew(array(), -1,-1,$statement,"",""," AND B1.STATUS_KONFIRMASI  =1
      AND B4.PROGRAM_ITEM_ASSESSMENT_ID =1");
            // echo $mp->query;
    $mp->firstRow();

    $arrdata["TOTAL_BOBOT_MP"]= $mp->getField("TOTAL_BOBOT");

    $mpnot= new Kesesuaian();

    $mpnot->selectByParamsNew(array(), -1,-1,$statement,"",""," AND B4.PROGRAM_ITEM_ASSESSMENT_ID = 1
        AND B1.STATUS_KONFIRMASI  =1
        AND B4.PROGRAM_ITEM_ASSESSMENT_ID =1 AND E.STATUS_CONFIRM  =0");
            // echo $mp->query;
    $mpnot->firstRow();

    $arrdata["TOTAL_BOBOT_MP_NOT"]= $mpnot->getField("TOTAL_BOBOT");

    $rating_mp=number_format($mpnot->getField("TOTAL_BOBOT")/ $mp->getField("TOTAL_BOBOT"),2);


    if (!is_numeric($rating_mp)) {
        $arrdata["RATING_MP"]=number_format(0.00,2);
    } else {
        $arrdata["RATING_MP"]=$rating_mp;
    }


    $statement=" AND A.LIST_AREA_ID =".$set->getField("LIST_AREA_ID")."  AND A.AREA_UNIT_DETIL_ID= ".$set->getField("AREA_UNIT_DETIL_ID")." AND a.ITEM_ASSESSMENT_DUPLIKAT_ID= ".$set->getField("ITEM_ASSESSMENT_DUPLIKAT_ID");

    $pp= new Kesesuaian();

    $pp->selectByParamsNew(array(), -1,-1,$statement,""," AND B1.STATUS_KONFIRMASI  =1
      AND B4.PROGRAM_ITEM_ASSESSMENT_ID =2");
            // echo $mp->query;
    $pp->firstRow();

    $arrdata["TOTAL_BOBOT_PP"]= $pp->getField("TOTAL_BOBOT");


    $ppnot= new Kesesuaian();

    $ppnot->selectByParamsNew(array(), -1,-1,$statement,"",""," AND B1.STATUS_KONFIRMASI  =1
      AND B4.PROGRAM_ITEM_ASSESSMENT_ID =2 AND E.STATUS_CONFIRM  =0");
            // echo $mp->query;
    $ppnot->firstRow();

    $arrdata["TOTAL_BOBOT_PP_NOT"]= $ppnot->getField("TOTAL_BOBOT");

    $rating_pp=number_format($ppnot->getField("TOTAL_BOBOT")/ $pp->getField("TOTAL_BOBOT"),2);

    if (!is_numeric($rating_pp)) {
        $arrdata["RATING_PP"]=number_format(0.00,2);
    } else {
        $arrdata["RATING_PP"]=$rating_pp;
    } 

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


?> 

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