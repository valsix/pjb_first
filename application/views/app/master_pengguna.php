<?php
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->model("base-app/Crud");
$appuserkodehak= $this->appuserkodehak;

$pgtitle= $pg;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$arrtabledata= array(
    array("label"=>"No", "field"=> "NO", "display"=>"",  "width"=>"10", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Username", "field"=> "USERNAME", "display"=>"",  "width"=>"20", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Nama User", "field"=> "NAMA", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Role Approval", "field"=> "ROLE_NAMA", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Hak User", "field"=> "PENGGUNA_HAK_NAMA_INFO", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")

    , array("label"=>"fieldid", "field"=> "PENGGUNA_EXTERNAL_ID", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"fieldid", "field"=> "PENGGUNA_INTERNAL_ID", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"fieldid", "field"=> "PENGGUNA_ID", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
);

$set= new Crud();
$statement=" AND KODE_MODUL ='0304'";
$kode= $appuserkodehak;
$set->selectByParamsMenus(array(), -1, -1, $statement, $kode);
// echo $set->query;exit;
$set->firstRow();
$reqMenu= $set->getField("MENU");
$reqCreate= $set->getField("MODUL_C");
$reqRead= $set->getField("MODUL_R");
$reqUpdate= $set->getField("MODUL_U");
$reqDelete= $set->getField("MODUL_D");


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
            <span><a id="btnReset"><i class="fa fa-lock fa-stack-1" aria-hidden="true"></i> Reset Password</a></span>
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
            <span><a id="btnDelete"><i class="fa fa-times-rectangle fa-lg" aria-hidden="true"></i> Hapus</a></span>
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

                    	// $infowidth= "";
                        $infowidth= $valitem["width"];
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
	var datanewtable;
	var infotableid= "example";
	var carijenis= "";
	var arrdata= <?php echo json_encode($arrtabledata); ?>;
	var indexfieldid= arrdata.length - 1;
    var indexfieldinternalid= arrdata.length - 2;
    var indexfieldexternalid= arrdata.length - 3;
	var valinfoid= valinfointernalid= valinfoexternalid='';
	var datainforesponsive= "1";
	var datainfoscrollx= 100;

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

        varurl= "app/index/master_pengguna_add?reqId="+valinfoid;
        document.location.href = varurl;
    });

    $("#btnLihat").on("click", function () {
        btnid= $(this).attr('id');

        if(valinfoid == "" )
        {
            $.messager.alert('Info', "Pilih salah satu data terlebih dahulu.", 'warning');
            return false;
        }
        

        varurl= "app/index/master_pengguna_add?reqId="+valinfoid+"&reqLihat=1";
        document.location.href = varurl;
    });

    $('#btnImport').on('click', function () {
        openAdd("app/index/master_pengguna_import");
    });

    $('#btnDelete').on('click', function () {
        if(valinfoid == "")
            return false; 

        $.messager.confirm('Konfirmasi',"Hapus data terpilih?",function(r){
            if (r){
                $.getJSON("json-app/pengguna_json/delete/?reqId="+valinfoid,
                    function(data){
                        $.messager.alert('Info', data.PESAN, 'info');
                        valinfoid= "";
                        setCariInfo();
                    });

            }
        }); 
    });

	$('#btnCari').on('click', function () {
		reqPencarian= $('#example_filter input').val();

        jsonurl= "json-app/pengguna_json/json?reqPencarian="+reqPencarian;
        datanewtable.DataTable().ajax.url(jsonurl).load();
	});

    $("#btnReset").on("click", function () {
        btnid= $(this).attr('id');

        if(valinfoid == "" )
        {
            $.messager.alert('Info', "Pilih salah satu data terlebih dahulu.", 'warning');
            return false;
        }

        if(valinfoexternalid)
        {
            varurl= "app/index/master_user_eksternal_reset?reqId="+valinfoexternalid;
            document.location.href = varurl;
        }
        else
        {
            if(valinfointernalid)
            {
                $.messager.alert('Info', "Reset Password hanya untuk user selain internal", 'warning');
                return false;
            }
            varurl= "app/index/master_pengguna_reset?reqId="+valinfoid;
            document.location.href = varurl;
        } 

        
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
		var jsonurl= "json-app/pengguna_json/json";
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
                fieldinfointernal= arrdata[indexfieldinternalid]["field"];
                fieldinfoexternal= arrdata[indexfieldexternalid]["field"];
                valinfoid= dataselected[fieldinfoid];
                valinfointernalid= dataselected[fieldinfointernal];
                valinfoexternalid= dataselected[fieldinfoexternal];
                
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