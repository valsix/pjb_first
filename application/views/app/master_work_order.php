<?php
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/Eam");
$this->load->model("base-app/Distrik");



$pgtitle= $pg;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqDistrikId= $this->input->get("reqDistrikId");
$reqEquipmentId= $this->input->get("reqEquipmentId");


$arrtabledata= array(
    array("label"=>"No", "field"=> "NO", "display"=>"",  "width"=>"20", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Asset Num", "field"=> "ASSET_NUM", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"WO", "field"=> "WO", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Desc", "field"=> "DESCRIPTION", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Status", "field"=> "STATUS", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Site Id", "field"=> "SITE_ID", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Project No", "field"=> "PROJECT_NO", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Work Type", "field"=> "WORKTYPE", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")

    , array("label"=>"fieldid", "field"=> "WORK_ORDER_ID", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
);

$set= new Distrik();
$arrdistrik= [];
$set->selectByParams(array(), -1,-1," AND A.NAMA IS NOT NULL AND A.KODE IS NOT NULL");
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("DISTRIK_ID");
    $arrdata["text"]= $set->getField("KODE_SITE")." / ".$set->getField("NAMA");
    array_push($arrdistrik, $arrdata);
}
unset($set);

$set= new Eam();
$arream= [];
$set->selectByParams(array(), -1,-1);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("EAM_ID");
    $arrdata["text"]=  $set->getField("NAMA");
    array_push($arream, $arrdata);
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
    td {
        white-space: pre-wrap !important;
        word-wrap:break-word;
    }
    thead.stick-datatable th:nth-child(1){  width:440px !important; *border:1px solid cyan;}
    thead.stick-datatable ~ tbody td:nth-child(1){  width:440px !important; *border:1px solid yellow;}
</style>

<div class="col-md-12">
    <div class="judul-halaman"> Data <?=$pgtitle?></div>
    <div class="konten-area">
        <div id="bluemenu" class="aksi-area">
             <span><a id="btnGenerate"><i class="fa fa-refresh  fa-lg" aria-hidden="true"></i> Generate</a></span>
        </div>

        <div class="area-filter" style="background-color: #4bab71">

            <label>Distrik  </label>
            <select id="reqDistrikId" style="margin-left:20px " >
                <option value="">Pilih Distrik</option>
                <?
                foreach($arrdistrik as $item) 
                {
                    $selectvalid= $item["id"];
                    $selectvaltext= $item["text"];
                    ?>
                    <option value="<?=$selectvalid?>"><?=$selectvaltext?></option>
                    <?
                }
                ?>
            </select>

            <label>Eam / Source  </label>
            <select id="reqEquipmentId" style="margin-left:20px " >
                <option value="">Pilih Eam</option>
                <?
                foreach($arream as $item) 
                {
                    $selectvalid= $item["id"];
                    $selectvaltext= $item["text"];
                    ?>
                    <option value="<?=$selectvalid?>"><?=$selectvaltext?></option>
                    <?
                }
                ?>
            </select>
          
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


    var datanewtable;
    var infotableid= "example";
    var carijenis= "";
    var arrdata= <?php echo json_encode($arrtabledata); ?>;
    var indexfieldid= arrdata.length - 1;
    var valinfoid= valinforowid='';
    var datainforesponsive= "";
    // var datainfoscrollx= 0;

    var datainfostatesave=0;
    var datainfoautowidth=1;

    infoscrolly= 50;

    $('#reqDistrikId').on('change', function() {
        var reqDistrikId=$("#reqDistrikId").val();
        reqPencarian= $('#example_filter input').val();
        // console.log(bulan);
        jsonurl= "json-app/work_json/json_work_order?reqPencarian="+reqPencarian+"&reqDistrikId="+reqDistrikId;
        datanewtable.DataTable().ajax.url(jsonurl).load();
    });



    $('#btnCari').on('click', function () {
        reqPencarian= $('#example_filter input').val();

        jsonurl= "json-app/work_json/json_work_order?reqPencarian="+reqPencarian;
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

    // $('#reqEquipmentId').change(function(){
    //     // var reqDistrikId=$('#reqDistrikId').val();
    // });

    $('#btnGenerate').on('click', function () {
        var reqEquipmentId=$('#reqEquipmentId').val();
        var reqDistrikId=$('#reqDistrikId').val();

        if(reqEquipmentId=="")
        {
            $.messager.alert('Info', "Pilih eam/source terlebih dahulu.", 'warning');
            return false;
        }

        if(reqDistrikId=="")
        {
            $.messager.alert('Info', "Pilih Distrik terlebih dahulu.", 'warning');
            return false;
        }
         // console.log(reqEquipmentId);return false;       
        $.messager.confirm('Konfirmasi',"Generate data ?",function(r){
            $.messager.progress({
                title:'Please waiting',
                msg:'Loading data...'
            });
            if (r){
                $.ajax({
                    url: "json-app/generate_json/work_order/?reqDistrikId="+reqDistrikId+"&reqEquipmentId="+reqEquipmentId,
                    cache: false,
                    success: function(data){
                    // console.log(data);return false;
                    $.messager.progress('close');
                    $.messager.alert('Info', data, 'info');
                    setTimeout(function(){  document.location.href = "app/index/master_work_order"; }, 3000); 
                }
            });


            }
        }); 
    });

    jQuery(document).ready(function() {
        var jsonurl= "json-app/work_json/json_work_order";
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
                valinfoid= dataselected[fieldinfoid];
                
            }
        } );

        $('#'+infotableid+' tbody').on( 'dblclick', 'tr', function () {
            var dataselected= datanewtable.DataTable().row(this).data();
            // console.log(dataselected);
            parent.setWO(dataselected);
            top.closePopup();
            
        });

        $('#button').click( function () {
            table.row('.selected').remove().draw( false );
        } );
    } );
</script>