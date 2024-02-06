<?php
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->model("base-app/Crud");
$this->load->model("base-app/Distrik");

$appuserkodehak= $this->appuserkodehak;

$pgtitle= $pg;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$arrtabledata= array(
    array("label"=>"No", "field"=> "NO", "display"=>"",  "width"=>"20", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Bulan", "field"=> "BULAN_INFO", "display"=>"",  "width"=>"20", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Tahun", "field"=> "TAHUN", "display"=>"",  "width"=>"20", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Distrik", "field"=> "DISTRIK_INFO", "display"=>"",  "width"=>"20", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Blok Unit", "field"=> "BLOK_INFO", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Unit Mesin", "field"=> "UNIT_MESIN_INFO", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Status", "field"=> "STATUS_INFO", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"fieldid", "field"=> "STATUS", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")

    , array("label"=>"fieldid", "field"=> "OUTLINING_ASSESSMENT_ID", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
);

$set= new Crud();
$statement=" AND KODE_MODUL ='1001'";
// $statement=" ";

$kode= $appuserkodehak;
$set->selectByParamsMenus(array(), -1, -1, $statement, $kode);
// echo $set->query;exit;
$set->firstRow();
$reqMenu= $set->getField("MENU");
$reqCreate= $set->getField("MODUL_C");
$reqRead= $set->getField("MODUL_R");
$reqUpdate= $set->getField("MODUL_U");
$reqDelete= $set->getField("MODUL_D");

$set= new Distrik();
$arrdistrik= [];

$statement=" AND A.STATUS IS NULL AND A.NAMA IS NOT NULL AND EXISTS(SELECT A.DISTRIK_ID FROM AREA_UNIT B WHERE A.DISTRIK_ID=B.DISTRIK_ID)";
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
    <div class="judul-halaman"> Data <?=$pgtitle?></div>
    <div class="konten-area">
    	<div id="bluemenu" class="aksi-area">
            <?
            if($reqCreate ==1)
            {
            ?>
            <span><a id="btnAdd"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> Tambah</a></span>
            <?   
            }
            if($reqUpdate ==1)
            {
            ?>
            <span><a id="btnEdit"><i class="fa fa-check-square fa-lg" aria-hidden="true"></i> Edit</a></span>
            <?
            }
            if($reqRead ==1)
            {
            ?>
            <span><a id="btnLihat"><i class="fa fa-eye fa-lg" aria-hidden="true"></i> Lihat</a></span>
            <?
            }
            if($reqDelete ==1)
            {
            ?>            
            <span><a id="btnDelete"><i class="fa fa-times-rectangle fa-lg" aria-hidden="true"></i>Non Aktifkan</a></span>
            <!-- <span><a id="btnDeleteNew"><i class="fa fa-times-rectangle fa-lg" aria-hidden="true"></i>Hapus</a></span> -->

            <?
            }
            if($reqCreate ==1)
            {
            ?>
            <span><a id="btnImport"><i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i> Import</a></span>
            <?
            }
            ?>
        </div>

        <div style=" border: none;  padding: 4px 5px; top: 90px;
        z-index: 10;clear: both;">
            <div class="col-md-12" style="margin-bottom: 20px; border: none;">
                <button id="btnfilter" class="filter btn btn-default pull-left">Filter <i class="fa fa-caret-down" aria-hidden="true"></i></button>
            </div>
            <div class="divfilter filterbaru"  >
                <div class="col-md-12" style="margin-bottom: 20px;" >
               
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
                        <label for="inputEmail3" class="col-sm-1 control-label">Unit Mesin</label>
                        <div class="col-sm-4">
                            <select class="form-control jscaribasicmultiple" id="reqUnitMesin" <?=$disabled?>  style="width:100%;" >
                                <option value="">Pilih Unit Mesin</option>
                            </select>
                        </div>
                        <label for="inputEmail3" class="col-sm-1 control-label">Status</label>
                        <div class="col-sm-4">
                            <select class="form-control jscaribasicmultiple" id="reqStatus" <?=$disabled?>  style="width:100%;" >
                                <option value="">Pilih Status</option>
                                <option value="NULL">Aktif</option>
                                <option value="1">Tidak Aktif</option>
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

        <div class="area-filter">
		</div>
            
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
    var indexfieldstatus= arrdata.length - 2;
    var valinfoid= valinforowid= valinfostatus='';
	var datainforesponsive= "1";
	var datainfoscrollx= 100;

    var datainfostatesave=1;

	infoscrolly= 50;

	$("#btnAdd, #btnEdit").on("click", function () {
        btnid= $(this).attr('id');

        if(btnid=="btnAdd")
        {
            valinfoid="";
        }
        else
        {
            if(valinfoid == "" )
            {
                $.messager.alert('Info', "Pilih salah satu data terlebih dahulu.", 'warning');
                return false;
            }
        }

        varurl= "app/index/outlining_assessment_add?reqId="+valinfoid;
        document.location.href = varurl;
    });

    $("#btnLihat").on("click", function () {
        btnid= $(this).attr('id');

        if(valinfoid == "" )
        {
            $.messager.alert('Info', "Pilih salah satu data terlebih dahulu.", 'warning');
            return false;
        }
        
        varurl= "app/index/outlining_assessment_add?reqId="+valinfoid+"&reqLihat=1";
        document.location.href = varurl;
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

        $.messager.confirm('program',pesan,function(r){
            if (r){
                $.getJSON("json-app/outlining_assessment_json/update_status/?reqId="+valinfoid+"&reqStatus="+reqStatus,
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
                $.getJSON("json-app/outlining_assessment_json/delete/?reqId="+valinfoid,
                    function(data){
                        $.messager.alert('Info', data.PESAN, 'info');
                        valinfoid= "";
                        setCariInfo();
                    });

            }
        }); 
    });

    $('#btnImport').on('click', function () {
        openAdd("app/index/outline_assessment_import");
    });

	$('#btnCari').on('click', function () {
        reqUnitMesinId= reqBlokId = reqStatus="";
		reqPencarian= $('#example_filter input').val();
        // reqStatus=$('#reqStatus').val();
        reqDistrik=$('#reqDistrik').val();

        var reqBlokId= $("#reqBlok").val();
        var reqUnitMesinId= $("#reqUnitMesin").val();
        var reqStatus= $("#reqStatus").val();

        if(reqBlokId == null || reqBlokId== undefined)
        {
            var reqBlokId=""
        }

        if(reqUnitMesinId == null || reqUnitMesinId== undefined)
        {
            var reqUnitMesinId=""
        }

        jsonurl= "json-app/outlining_assessment_json/json?reqPencarian="+reqPencarian+"&reqStatus="+reqStatus+"&reqDistrik="+reqDistrik+"&reqBlokId="+reqBlokId+"&reqUnitMesinId="+reqUnitMesinId;
        datanewtable.DataTable().ajax.url(jsonurl).load();
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
		var jsonurl= "json-app/outlining_assessment_json/json";
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
                fieldinfostatus= arrdata[indexfieldstatus]["field"];
                valinfoid= dataselected[fieldinfoid];
                valinfostatus= dataselected[fieldinfostatus];

                if(valinfostatus=='' || valinfostatus==null )
                {
                    var pesan='Non Aktifkan';
                    var icon='fa fa-times-rectangle';
                }
                else
                {
                    var pesan='Aktifkan';
                    var icon='fa fa-toggle-on';
                }    

                $('#btnDelete').html('<i class="'+icon+'" aria-hidden="true"></i>'+pesan+'</a>');
                
            }
        } );

        $('#'+infotableid+' tbody').on( 'dblclick', 'tr', function () {
            $("#btnEdit").click();
        });

        $('#button').click( function () {
            table.row('.selected').remove().draw( false );
        } );
    } );

    $('#reqDistrik').on('change', function() {
        var reqDistrikId= this.value;

        $.getJSON("json-app/outlining_assessment_json/filter_blok?reqDistrikId="+reqDistrikId,
            function(data)
            {
            // console.log(data);
            $("#reqBlok option").remove();
            $("#reqUnitMesin option").remove();
            $("#reqBlok").append('<option value="" >Pilih Blok Unit</option>');
            jQuery(data).each(function(i, item){
                $("#reqBlok").append('<option value="'+item.id+'" >'+item.text+'</option>');
            });
        });

    });

    $('#reqBlok').on('change', function() {

        var reqDistrikId= $("#reqDistrik").val();
        var reqBlokId= $("#reqBlok").val();
        var reqUnitMesinId= $("#reqUnitMesin").val();

        $.getJSON("json-app/outlining_assessment_json/filter_unit?reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId,
            function(data)
            {
                $("#reqUnitMesin option").remove();
                $("#reqUnitMesin").append('<option value="" >Pilih Unit Mesin </option>');
                jQuery(data).each(function(i, item){
                    $("#reqUnitMesin").append('<option value="'+item.id+'" >'+item.text+'</option>');
                });
            });

    });



</script>