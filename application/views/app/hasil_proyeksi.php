
<?
$this->load->model("base-app/HasilAssessment");

$reqDistrikId= $this->input->get("reqDistrikId");
$reqBlok= $this->input->get("reqBlok");
$reqTahun= $this->input->get("reqTahun");
$reqStatus= $this->input->get("reqStatus");
$reqListAreaId= $this->input->get("reqListAreaId");
$reqBulan= $this->input->get("reqBulan");



$statement="";

$set= new HasilAssessment();
$arrKategoriRekomendasi= [];

$statement=" AND TIMELINE_REKOMENDASI_ID IS NOT NULL";
if(!empty($reqDistrikId))
{
    $statement.=" AND C.DISTRIK_ID=".$reqDistrikId;
}
if(!empty($reqBlok))
{
    $statement.=" AND C.BLOK_UNIT_ID=".$reqBlok;
}
if(!empty($reqTahun))
{
    $statement.=" AND C.TAHUN=".$reqTahun;
}
if($reqStatus==20)
{
    $statement.=" AND C.V_STATUS=".$reqStatus;
}
elseif($reqStatus==100)
{
    $statement.=" AND C.V_STATUS <> 20";
}
if(!empty($reqListAreaId))
{
    $statement.=" AND C.LIST_AREA_ID=".$reqListAreaId;
}

if(!empty($reqBulan))
{
    $statement.=" AND C.BULAN='".$reqBulan."'";
}



$set->selectByParamsRekomendasiKategori(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["KATEGORI_REKOMENDASI_ID"]= $set->getField("KATEGORI_REKOMENDASI_ID");
    $arrdata["KATEGORI_INFO"]= $set->getField("KATEGORI_INFO");
    array_push($arrKategoriRekomendasi, $arrdata);
}

unset($set);

$reqTahun= date('Y');
$semester="SMT";
$arrSmtTahun=[];
for ($i=0; $i < 4 ; $i++) { 
    for ($z=1; $z < 3 ; $z++) { 
        $arrdata= array();
        $smtahun=  $semester.' - '.$z;
        $arrdata["ID"]= $reqTahun."_".$z;
        $arrdata["NAMA"]= $smtahun;
        array_push($arrSmtTahun, $arrdata);
    }
    $reqTahun++;
}


$reqTahun= $this->input->get("reqTahun");


?> 

<?
foreach ($arrKategoriRekomendasi as $key => $value) 
{

    ?>
    <tr>
        <td ><?=$value["KATEGORI_INFO"]?></td>

        <?
        foreach ($arrSmtTahun as $keys => $values) 
        {   
            $set= new HasilAssessment();

            $arrRekomendasiProyeksi= [];

            $statement=" AND TIMELINE_REKOMENDASI_ID IS NOT NULL 
            AND A.KATEGORI_REKOMENDASI_ID=".$value["KATEGORI_REKOMENDASI_ID"]." 
            AND B.TIMELINE_REKOMENDASI_ID='".$values["ID"]. "' ";
            if(!empty($reqDistrikId))
            {
                $statement.=" AND C.DISTRIK_ID=".$reqDistrikId;
            }
            if(!empty($reqBlok))
            {
                $statement.=" AND C.BLOK_UNIT_ID=".$reqBlok;
            }
            if(!empty($reqTahun))
            {
                $statement.=" AND C.TAHUN=".$reqTahun;
            }
            if($reqStatus==20)
            {
                $statement.=" AND C.V_STATUS=".$reqStatus;
            }
            elseif($reqStatus==100)
            {
                $statement.=" AND C.V_STATUS <> 20";
            }
            if(!empty($reqListAreaId))
            {
                $statement.=" AND C.LIST_AREA_ID=".$reqListAreaId;
            }

            if(!empty($reqBulan))
            {
               $statement.=" AND C.BULAN='".$reqBulan."'";
            }


            $set->selectByParamsRekomendasiProyeksi(array(), -1,-1,$statement);
            $jmlsem=0;                                                   
            while($set->nextRow())
            {
                $arrdata= array();
                $arrdata["KATEGORI_REKOMENDASI_ID"]= $set->getField("KATEGORI_REKOMENDASI_ID");
                $arrdata["KATEGORI_INFO"]= $set->getField("KATEGORI_INFO");
                $arrdata["JUMLAH_SEM"]= $set->getField("JUMLAH_SEM");
                $arrdata["TAHUN"]= $set->getField("TAHUN");
                $arrdata["TIMELINE_REKOMENDASI_ID"]= $set->getField("TIMELINE_REKOMENDASI_ID");
                array_push($arrRekomendasiProyeksi, $arrdata);

            }

            ?>
            <?
            if( in_array( $values["ID"] ,array_column($arrRekomendasiProyeksi, 'TIMELINE_REKOMENDASI_ID') ) )
            {
                ?>
                <?
                foreach ($arrRekomendasiProyeksi as $keyx => $valuex) 
                {
                    ?>
                    <td class="text-center"><?=$valuex["JUMLAH_SEM"]?></td>
                    <?
                }
                ?>
                <?
            }
            else
            {
                ?>
                <td class="text-center">0</td>
                <?
            }
        }
        ?>
    </tr>
    <?
}
?>


<tr>
    <td class="text-center headcolor">Jumlah Rekomendasi</td>

    <?
    foreach ($arrSmtTahun as $keys => $values) 
    {
        ?> 
        <?

        $set= new HasilAssessment();
        $arrTotalRekomendasi= [];        

        $statement=" AND TIMELINE_REKOMENDASI_ID IS NOT NULL 
        AND B.TIMELINE_REKOMENDASI_ID='".$values["ID"]. "' ";

        if(!empty($reqDistrikId))
        {
            $statement.=" AND C.DISTRIK_ID=".$reqDistrikId;
        }
        if(!empty($reqBlok))
        {
            $statement.=" AND C.BLOK_UNIT_ID=".$reqBlok;
        }
        if(!empty($reqTahun))
        {
            $statement.=" AND C.TAHUN=".$reqTahun;
        }
        if($reqStatus==20)
        {
            $statement.=" AND C.V_STATUS=".$reqStatus;
        }
        elseif($reqStatus==100)
        {
            $statement.=" AND C.V_STATUS <> 20";
        }
        if(!empty($reqListAreaId))
        {
            $statement.=" AND C.LIST_AREA_ID=".$reqListAreaId;
        }


        if(!empty($reqBulan))
        {
            $statement.=" AND C.BULAN='".$reqBulan."'";
        }

        $set->selectByParamsRekomendasiProyeksiTotal(array(), -1,-1,"",$statement);
        // echo $set->query;exit;
        $jmlsem=0;                                                   
        while($set->nextRow())
        {

           $arrdata= array();
           $arrdata["TOTAL_SEM"]= $set->getField("TOTAL_SEM");
           $arrdata["TIMELINE_REKOMENDASI_ID"]= $set->getField("TIMELINE_REKOMENDASI_ID");
           array_push($arrTotalRekomendasi, $arrdata);
       }
       ?>

       <?
       if( in_array( $values["ID"] ,array_column($arrTotalRekomendasi, 'TIMELINE_REKOMENDASI_ID') ) )
       {
        ?>
        <?
        foreach ($arrTotalRekomendasi as $keyx => $valuex) 
        {
            ?>
            <td class="text-center"><?=$valuex["TOTAL_SEM"]?></td>
            <?
        }
        ?>
        <?
    }
    else
    {
        ?>
        <td class="text-center">0</td>
        <?
    }
    ?>
    <?
}
?>


</tr>

<tr>
    <td class="text-center headcolor">Proyeksi Tingkat Kesesuaian</td>
    <?
    foreach ($arrSmtTahun as $keys => $values) 
    {

        $smt = substr($values["ID"], strpos($values["ID"], "_") + 1);
        $thn =substr($values["ID"],0,strrpos($values["ID"],'_'));   

        if($smt==1)
        {
            $smt=" AND F.BULAN <= '06' ";
        }
        else
        {
            $smt=" AND F.BULAN > '06' ";
        }

        $statement =  $smt." AND F.TAHUN=".$thn;

        $set= new HasilAssessment();
        $arrTotalRekomendasi= [];                                           
        $set->selectByParamsRekomendasiProyeksiPersentase(array(), -1,-1,"",$statement);
        $jmlsem=0;
        $jumlahcomplysmt=$jumlahcomplynotsmt=$jumlahklausulsmt=0;                                                  
        while($set->nextRow())
        {

           $arrdata= array();
           $arrdata["STATUS_COMPLY"]= $set->getField("STATUS_COMPLY");
           $arrdata["PERSEN_CONFIRM"]= $set->getField("PERSEN_CONFIRM");
           array_push($arrTotalRekomendasi, $arrdata);

           if($set->getField("STATUS_COMPLY")=="COMPLY")
           {
            $jumlahcomplysmt+=1;
        }
        else
        {
            $jumlahcomplynotsmt+=1;
        }
        $jumlahklausulsmt++;
    }

    if(!empty($jumlahcomplysmt))
    {
        $percomplysmt=round($jumlahcomplysmt/$jumlahklausulsmt * 100 ,1);
    }


    $stylebg="";
    if($percomplysmt <=30)
    {
        $stylebg="background-color: red";
    }
    elseif($percomplysmt > 30 && $percomplysmt <= 50 )
    {
        $stylebg="background-color: yellow";
    }
    elseif($percomplysmt > 50 && $percomplysmt < 75 )
    {
        $stylebg="background-color: blue";
    }
    elseif($percomplysmt > 75  )
    {
        $stylebg="background-color: green";
    }



    ?>
    <td class="text-center" style="<?=$stylebg?>"><?=$percomplysmt?> %</td>
    <?
}
?>
</tr>