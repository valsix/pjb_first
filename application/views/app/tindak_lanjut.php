<?php
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->model("base-app/Crud");
$this->load->model("base-app/Distrik");
$this->load->model("base-app/OutliningAssessment");


$this->load->model("base/Users");


$appuserkodehak= $this->appuserkodehak;
$appuserkodehak= $this->appuserkodehak;
$reqPenggunaid= $this->appuserid;

$reqNotif = $this->input->get("reqNotif");


$pgtitle= $pg;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$arrtabledata= array(
    array("label"=>"No", "field"=> "NO", "display"=>"",  "width"=>"20", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Bulan", "field"=> "BULAN", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Tahun", "field"=> "TAHUN", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
     , array("label"=>"Distrik", "field"=> "DISTRIK_INFO", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Blok Unit", "field"=> "BLOK_INFO", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Nama Area", "field"=> "KODE_INFO", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    // , array("label"=>"Klausul Assessment", "field"=> "ITEM_ASSESSMENT_INFO", "display"=>"",  "width"=>"20", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Detail Rekomendasi", "field"=> "DETAIL", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    // , array("label"=>"Jenis Rekomendasi", "field"=> "JENIS_NAMA", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    // , array("label"=>"Prioritas Rekomendasi", "field"=> "PRIORITAS_NAMA", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    // , array("label"=>"Kategori Rekomendasi", "field"=> "KATEGORI_NAMA", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Status Rekomendasi", "field"=> "STATUS_INFO", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    // , array("label"=>"Timeline Rekomendasi", "field"=> "STATUS_INFO", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"fieldid", "field"=> "DISTRIK_ID", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"fieldid", "field"=> "OUTLINING_ASSESSMENT_ID", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"fieldid", "field"=> "OUTLINING_ASSESSMENT_DETIL_ID", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"fieldid", "field"=> "OUTLINING_ASSESSMENT_AREA_DETIL_ID", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")

    , array("label"=>"fieldid", "field"=> "OUTLINING_ASSESSMENT_REKOMENDASI_ID", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
);

$set= new Crud();
$statement=" AND KODE_MODUL ='1005'";
$kode= $appuserkodehak;
$set->selectByParamsMenus(array(), -1, -1, $statement, $kode);
// echo $set->query;exit;
$set->firstRow();
$reqMenu= $set->getField("MENU");
$reqCreate= $set->getField("MODUL_C");
$reqRead= $set->getField("MODUL_R");
$reqUpdate= $set->getField("MODUL_U");
$reqDelete= $set->getField("MODUL_D");

$arridDistrik=[];
$usersdistrik = new Users();
$usersdistrik->selectByPenggunaDistrik($reqPenggunaid);
while($usersdistrik->nextRow())
{
    $arridDistrik[]= $usersdistrik->getField("DISTRIK_ID"); 
   
}

$idDistrik = implode(",",$arridDistrik);  

$set= new Distrik();
$arrdistrik= [];

if(!empty($idDistrik))
{
    
    $statement=" AND A.DISTRIK_ID IN (".$idDistrik.") AND A.STATUS IS NULL AND A.NAMA IS NOT NULL 
    AND EXISTS
    (
        SELECT A.DISTRIK_ID FROM AREA_UNIT B  
        INNER JOIN  AREA_UNIT_DETIL C ON C.AREA_UNIT_ID = B.AREA_UNIT_ID  
        WHERE A.DISTRIK_ID=B.DISTRIK_ID
    )";
}
else
{
    // $statement="AND A.STATUS IS NULL AND A.NAMA IS NOT NULL AND EXISTS(SELECT A.DISTRIK_ID FROM AREA_UNIT B WHERE A.DISTRIK_ID=B.DISTRIK_ID)";
    $statement=" AND A.STATUS IS NULL AND A.NAMA IS NOT NULL 
    AND EXISTS
    (
        SELECT A.DISTRIK_ID FROM AREA_UNIT B  
        INNER JOIN  AREA_UNIT_DETIL C ON C.AREA_UNIT_ID = B.AREA_UNIT_ID  
        WHERE A.DISTRIK_ID=B.DISTRIK_ID
    )";
}

$set->selectByParamsAreaDistrik(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("DISTRIK_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrdistrik, $arrdata);
}
unset($set);

$set= new OutliningAssessment();
$statement = "";
$arrTahun=[];
$set->selectByParamsRekomendasiTahun(array(), -1, -1, $statement, " ORDER BY A.TAHUN");

while($set->nextRow())
{
    $arrdata= array();
    $arrdata["TAHUN"]= $set->getField("TAHUN");
    array_push($arrTahun, $arrdata);
}




?>
<script type="text/javascript" language="javascript" class="init">	
</script> 

<!-- FIXED AKSI AREA WHEN SCROLLING -->
<link rel="stylesheet" href="css/gaya-stick-when-scroll.css" type="text/css">
<script src="assets/js/stick.js" type="text/javascript"></script>
<script>
$(document).ready(function() {
    var s = $("#bluemenu");
	
    var pos = s.position();
    $(window).scroll(function() {
        var windowpos = $(window).scrollTop();
        if (windowpos >= pos.top) {
            s.addClass("stick");
			$('#example thead').addClass('stick-datatable');
        } else {
			s.removeClass("stick");
			$('#example thead').removeClass('stick-datatable');
        }
    });
});
</script>

<style>
	thead.stick-datatable th:nth-child(1){	width:440px !important; *border:1px solid cyan;}
	thead.stick-datatable ~ tbody td:nth-child(1){	width:440px !important; *border:1px solid yellow;}
</style>

<div class="col-md-12">
    <div class="judul-halaman"> Data Tindak Lanjut</div>
    <div class="konten-area">
    	<div id="bluemenu" class="aksi-area">
            <span><a id="btnEdit"><i class="fa fa-check-square fa-lg" aria-hidden="true"></i> Edit</a></span>
        </div>
        <br>
        <br>
        <br>

        <div  style=" border: none;  padding: 4px 5px; top: 90px;
        z-index: 10;clear: both;">
            <div class="col-md-12" style="margin-bottom: 20px; border: none;">
                <button id="btnfilter" class="filter btn btn-default pull-left">Filter <i class="fa fa-caret-down" aria-hidden="true"></i></button>
            </div>
            <div class="divfilter filterbaru"  >
                <div class="col-md-12" style="margin-bottom: 20px;" >
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-1 control-label">Distrik </label>
                        <div class="col-sm-4">
                            <select class="form-control jscaribasicmultiple" id="reqDistrik" <?=$disabled?>  style="width:100%;" >
                                <option value="">Pilih Distrik</option>
                                <? 
                                foreach($arrdistrik as $item) 
                                {
                                    $selectvalid= $item["id"];
                                    $selectvaltext= $item["text"];

                                    $selected="";
                                    ?>
                                    <option value="<?=$selectvalid?>" <?=$selected?>><?=$selectvaltext?></option>
                                    <?
                                }
                                ?>
                            </select>
                        </div>

                        <label for="inputEmail3" class="col-sm-1 control-label">Blok/Unit </label>
                        <div class="col-sm-4">
                            <select class="form-control jscaribasicmultiple" id="reqBlok" <?=$disabled?>  style="width:100%;" >
                                <option value="">Pilih Blok/Unit</option>
                            </select>
                        </div>  
                    </div>
                    <br>
                    <br>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-1 control-label">Tahun </label>
                        <div class="col-sm-4">
                            <select name="reqTahun" id="reqTahun" class="form-control datatable-input">
                                <option value="">Semua</option>
                                <?
                                foreach ($arrTahun as $key => $value) 
                                {
                                    ?>
                                    <option value="<?=$value["TAHUN"]?>" ><?=$value["TAHUN"]?></option>
                                    <?
                                }
                                ?>
                            </select>
                        </div>  
                    </div>
                </div>
                <div class="text-center ">
                  <button class="btn btn-primary btn-sm" onclick="setCariInfo()" ><i class="fas fa-search"></i> Cari</button>
                </div>
                <br>
            </div>
        </div>


        <div class="area-filter"></div>

            
        <table id="example" class="table table-striped table-hover dt-responsive" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <?php
                    foreach($arrtabledata as $valkey => $valitem) 
                    {
                    	$infotablelabel= $valitem["label"];
                    	$infotablecolspan= $valitem["colspan"];
                    	$infotablerowspan= $valitem["rowspan"];

                    	$infowidth= "";
                    	if(!empty($infotablecolspan))
                    	{
                    	}

                    	if(!empty($infotablelabel))
                    	{
                    ?>
                        <th style="text-align:center; width: <?=$infowidth?>%" colspan='<?=$infotablecolspan?>' rowspan='<?=$infotablerowspan?>'><?=$infotablelabel?></th>
                    <?
                    	}
                    }
                    ?>
                </tr>
             </thead>
        </table>
        
    </div>
</div>

<a href="#" id="triggercari" style="display:none" title="triggercari">triggercari</a>
<a href="#" id="btnCari" style="display: none;" title="Cari"></a>

<script type="text/javascript">

    $(document).ready(function(){
        $(".divfilter").hide();
        $("#btnfilter").click(function(){
           $(".divfilter").toggle();
       });
    });


	var datanewtable;
	var infotableid= "example";
	var carijenis= "";
	var arrdata= <?php echo json_encode($arrtabledata); ?>;
	var indexfieldid= arrdata.length - 1;
    var indexfieldareadetilid= arrdata.length - 2;
    var indexfielddetilid= arrdata.length - 3;
    var indexfieldreqid= arrdata.length - 4;
    var indexfielddistrikid= arrdata.length - 5;
    var valinfoid= valinforowid= valinfostatus=valinfoareadetilid=valinfodetilid=valinforeqid=valinfodistrikid='';
	var datainforesponsive= "";
	// var datainfoscrollx= 0;

    var datainfostatesave=0;
    var datainfoautowidth=1;

	infoscrolly= 50;

	$("#btnAdd, #btnEdit").on("click", function () {
        btnid= $(this).attr('id');

        if(btnid=="btnAdd")
        {
            valinfoid="";
        }
        else
        {
            if(valinfoid==null)
            {
                valinfoid="";
            }
            // if(valinfoid == "" )
            // {
            //     $.messager.alert('Info', "Pilih salah satu data terlebih dahulu.", 'warning');
            //     return false;
            // }
        }

        varurl= "app/index/outlining_assessment_rekomendasi?reqAreaDetilId="+valinfoareadetilid+"&reqDetilId="+valinforeqid+"&reqId="+valinforeqid+"&reqKembali=1&reqPage=4&reqRekomendasi="+valinfoid+"&reqDistrikId="+valinfodistrikid;
        // document.location.href = varurl;
         window.open(
          varurl,
          '_blank' 
          );
    });

    $("#btnLihat").on("click", function () {
        btnid= $(this).attr('id');

        if(valinfoid == "" )
        {
            $.messager.alert('Info', "Pilih salah satu data terlebih dahulu.", 'warning');
            return false;
        }
        

        varurl= "app/index/outlining_assessment_rekomendasi?reqPage=4&reqRekomendasiId="+valinfoid+"&reqLihat=1";
        document.location.href = varurl;
    });

    $('#btnImport').on('click', function () {
        openAdd("app/index/tindak_lanjut_import");
    });

    $('#btnDelete').on('click', function () {
        if(valinfoid == "" )
        {
            $.messager.alert('Info', "Pilih salah satu data terlebih dahulu.", 'warning');
            return false;
        }

        if(valinfostatus=='' || valinfostatus==null )
        {
            var reqStatus=1;
            var pesan='Non Aktifkan data terpilih?';
        }
        else
        {
            var reqStatus='';
            var pesan='Aktifkan data terpilih?';
        }  

        $.messager.confirm('Konfirmasi',pesan,function(r){
            if (r){
                $.getJSON("json-app/tindak_lanjut_json/update_status/?reqId="+valinfoid+"&reqStatus="+reqStatus,
                    function(data){
                        $.messager.alert('Info', data.PESAN, 'info');
                        valinfoid= "";
                        setCariInfo();
                    });

            }
        }); 
    });

     $('#btnDeleteNew').on('click', function () {
        if(valinfoid == "" )
        {
            $.messager.alert('Info', "Pilih salah satu data terlebih dahulu.", 'warning');
            return false;
        }

         var pesan='Apakah anda yakin untuk hapus data terpilih?';

        $.messager.confirm('Konfirmasi',pesan,function(r){
            if (r){
                $.getJSON("json-app/tindak_lanjut_json/delete/?reqId="+valinfoid,
                    function(data){
                        $.messager.alert('Info', data.PESAN, 'info');
                        valinfoid= "";
                        setCariInfo();
                    });

            }
        }); 
    });

	$('#btnCari').on('click', function () {
		reqUnitMesinId= reqBlokId = reqStatus=reqTahun="";
        reqPencarian= $('#example_filter input').val();
        var reqDistrik=$('#reqDistrik').val();
        var reqTahun=$('#reqTahun').val();

        var reqBlok= $("#reqBlok").val();

        if(reqBlok == null || reqBlok== undefined)
        {
            var reqBlok="";
        }

        jsonurl= "json-app/tindak_lanjut_json/json?reqPencarian="+reqPencarian+"&reqDistrikId="+reqDistrik+"&reqBlok="+reqBlok+"&reqTahun="+reqTahun;
        datanewtable.DataTable().ajax.url(jsonurl).load();
	});

    $('#reqDistrik').on('change', function() {
        var reqDistrikId= this.value;
        $.getJSON("json-app/outlining_assessment_json/filter_blok?reqDistrikId="+reqDistrikId,
            function(data)
            {
                $("#reqBlok option").remove();
                $("#reqUnitMesin option").remove();
                $("#reqBlok").append('<option value="" >Pilih Blok Unit</option>');
                jQuery(data).each(function(i, item){
                    $("#reqBlok").append('<option value="'+item.id+'" >'+item.text+'</option>');
                });
            });

    });



	$("#triggercari").on("click", function () {
        if(carijenis == "1")
        {
            pencarian= $('#'+infotableid+'_filter input').val();
            datanewtable.DataTable().search( pencarian ).draw();
        }
        else
        {
            
        }
    });

	jQuery(document).ready(function() {
		var jsonurl= "json-app/tindak_lanjut_json/json?reqNotif=<?=$reqNotif?>";
	    ajaxserverselectsingle.init(infotableid, jsonurl, arrdata);
	});

	function calltriggercari()
	{
	    $(document).ready( function () {
	      $("#triggercari").click();      
	    });
	}

	function setCariInfo()
	{
		$(document).ready( function () {
			$("#btnCari").click();
		});
	}

    $(document).ready(function() {
        var table = $('#example').DataTable();

        $('#example tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');

                var dataselected= datanewtable.DataTable().row(this).data();
                fieldinfoid= arrdata[indexfieldid]["field"];
                fieldinfoareadetilid= arrdata[indexfieldareadetilid]["field"];
                fieldinfodetilid= arrdata[indexfielddetilid]["field"];
                fieldinforeqid= arrdata[indexfieldreqid]["field"];
                fieldinfodistrikid= arrdata[indexfielddistrikid]["field"];


                valinfoid= dataselected[fieldinfoid];
                valinfoareadetilid= dataselected[fieldinfoareadetilid];
                valinfodetilid= dataselected[fieldinfodetilid];
                valinforeqid= dataselected[fieldinforeqid];
                valinfodistrikid= dataselected[fieldinfodistrikid];
 
            }
        } );

        $('#'+infotableid+' tbody').on( 'dblclick', 'tr', function () {
            $("#btnEdit").click();
        });

        $('#button').click( function () {
            table.row('.selected').remove().draw( false );
        } );
    } );
</script>