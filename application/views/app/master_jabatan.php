<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/Crud");
$appuserkodehak= $this->appuserkodehak;

$pgtitle= $pg;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$set= new Crud();
$statement=" AND KODE_MODUL ='0701'";
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


<div class="col-md-12">

    <div class="judul-halaman"> Data <?=$pgtitle?></div>
    
    <div class="konten-area">
        <div id="bluemenu" class="aksi-area">
            <!-- <span><a id="btnAdd"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> Tambah</a></span>
            <span><a id="btnImport"><i class="fa fa-file-excel-o  fa-lg" aria-hidden="true"></i> Import Parent Eksternal</a></span>
            <span><a id="btnGenerate"><i class="fa fa-refresh  fa-lg" aria-hidden="true"></i> Generate</a></span> -->
            <?
            if($reqCreate ==1)
            {
            ?>
            <span><a id="btnAdd"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> Tambah</a></span>
            <span><a id="btnImport"><i class="fa fa-file-excel-o  fa-lg" aria-hidden="true"></i> Import Parent Eksternal</a></span>
            <?   
            }
            if($reqUpdate ==1)
            {
            ?>
           
            <?
            }
            if($reqRead ==1)
            {
            ?>
            <?
            }
            if($reqDelete ==1)
            {
            ?>            
            <?
            }
            ?>
             <span><a id="btnGenerate"><i class="fa fa-refresh  fa-lg" aria-hidden="true"></i> Generate</a></span>

        </div>

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
                        <label for="inputEmail3" class="col-sm-1 control-label">Status</label>
                        <div class="col-sm-4">
                            <select class="form-control jscaribasicmultiple" id="reqStatus" <?=$disabled?>  style="width:100%;" >
                                <option value="">Semua</option>
                                <option value="NULL">Aktif</option>
                                <option value="1">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="text-center ">
                  <button class="btn btn-primary btn-sm" onclick="searchtree('')" ><i class="fas fa-search"></i> Cari</button>
                </div>
                <br>
            </div>
        </div>

        <div class="area-filter" style="text-align: right">
          <input type="text" placeholder="Search.." name="search" id="reqSearch">
          <button type="button" id="reqSearchButton"><i class="fa fa-search"></i></button>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="area-tabel-rekap-pemenuhan-ftk"> 
                    <div class="inner">
                        <table id="tt" class="easyui-treegrid"
                            data-options=
                            "
                            " style="width:100%;height:470px">
                            <thead>
                                <tr>
                                    <!-- <th data-options="field:'ID'" width="100">Kode Jabatan</th> -->
                                    <th data-options="field:'NAMA'" width="770">Nama Jabatan</th>
                                    <th data-options="field:'UNIT'" width="200">Unit</th>
                                    <th field="LINK_URL_INFO" width="90" align="center">Aksi</th>
                                </tr>
                            </thead>
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
</div>

<script type="text/javascript">
    var reqCreate= "<?=$reqCreate?>";
    var reqRead= "<?=$reqRead?>";
    var reqUpdate= "<?=$reqUpdate?>";
    var reqDelete= "<?=$reqDelete?>";

    $('#tt').treegrid({
         url: 'json-app/jabatan_json/tree'
         , rownumbers: false
         , pagination: false
         , idField: 'ID'
         , treeField: 'NAMA'
         , onSelect:function(node){
            selectedNodeId = node.ID;

        }
        , onLoadSuccess: function(row, data){
            $('.addjabdetil').hide();
            $('.impjabdetil').hide();
            $('.editjabdetil').hide();
            $('.deljabdetil').hide();
            $('.aktifjabdetil').hide();
            $('.nonaddjabdetil').hide();
            if(reqCreate==1)
            {
                $('.addjabdetil').show();
                $('.impjabdetil').show();
            }
            if(reqRead==1)
            {
                
            }
            if(reqUpdate==1)
            {
                $('.editjabdetil').show();
            }
            if(reqDelete==1)
            {
                $('.deljabdetil').show();
                $('.aktifjabdetil').show();
                $('.nonaddjabdetil').show();
            }

        }
        , onBeforeLoad: function(row,param){
            if (!row) {
                param.id = 0;
            }
        }
    });


var reloadunit= "";
$(function(){
    $(".divfilter").hide();
      $("#btnfilter").click(function(){
         $(".divfilter").toggle();
     });

    $("#btnAdd").on("click", function () {
        varurl= "app/index/master_jabatan_add?reqId=";
        document.location.href = varurl;
    });

    $('#reqSearch').keypress(function (e) {
        var key = e.which;
        if(key == 13)  
        {
            searchtree(e.target.value);
        }
    });   

     $("#reqSearchButton").on("click", function () {
        var reqSearch= $("#reqSearch").val();
        searchtree(reqSearch);
    });

    $('#btnImport').on('click', function () {
        openAdd("app/index/master_jabatan_parent_import?reqSuperiorId=TOP");
    });


    $('#btnGenerate').on('click', function () {
        $.messager.confirm('Konfirmasi',"Generate data?",function(r){
            $.messager.progress({
                title:'Please waiting',
                msg:'Loading data...'
            });
            if (r){
                $.ajax({
                    url: "json-app/generate_json/MasterJabatan/",
                    cache: false,
                    success: function(data){
                        // console.log(data);return false;
                        $.messager.progress('close');
                        $.messager.alert('Info', data, 'info');
                        setTimeout(function(){  document.location.href = "app/index/master_jabatan"; }, 3000); 
                    }
                });
            }
        }); 
    });
 
});

function searchtree(value)
{
    reqStatus=$('#reqStatus').val();
    reqSearch=$('#reqSearch').val();
    if(value=="")
    {
        value=reqSearch;
    }
    // console.log(reqStatus);
    $('#tt').treegrid({
        url: 'json-app/jabatan_json/tree?reqSearch='+value+'&reqStatus='+ reqStatus
        , rownumbers: false
        , pagination: false
        , idField: 'ID'
        , treeField: 'NAMA'
        , onSelect:function(node){
            selectedNodeId = node.ID;
        }
        , onLoadSuccess: function(row, data){
        }
        , onBeforeLoad: function(row,param){
            if (!row) {
                param.id = 0;
            }
        }
    });
}

function openurl(varurl)
{
    document.location.href = varurl;
}

function delete_detail(valinfoid)
{
    if(valinfoid == "")
        return false; 

    $.messager.confirm('Konfirmasi',"Hapus data terpilih?",function(r){
        if (r){
            $.getJSON("json-app/jabatan_json/delete/?reqId="+valinfoid,
                function(data){
                    $.messager.alert('Info', data.PESAN, 'info');
                    location.reload();
                });

        }
    }); 
}

function change_status(valinfoid)
{
       
      if(valinfoid == "")
        return false; 
         // console.log(reqEquipmentId);return false;       
        $.messager.confirm('Konfirmasi',"Non Aktifkan data terpilih?",function(r){
            $.messager.progress({
                title:'Please waiting',
                msg:'Loading data...'
            });
            if (r){
                $.ajax({
                    url: "json-app/jabatan_json/change_status/?reqStatus=1&reqId="+valinfoid,
                    cache: false,
                    contentType: "application/json",
                    dataType: "json",
                    success: function(data){
                    // console.log(data.PESAN);return false;
                    $.messager.progress('close');
                    $.messager.alert('Info', data.PESAN, 'info');
                    location.reload(); 
                }
            });


            }
        }); 
}

function change_status_aktif(valinfoid)
{
       
      if(valinfoid == "")
        return false; 
         // console.log(reqEquipmentId);return false;       
        $.messager.confirm('Konfirmasi',"Aktifkan data terpilih?",function(r){
            $.messager.progress({
                title:'Please waiting',
                msg:'Loading data...'
            });
            if (r){
                $.ajax({
                    url: "json-app/jabatan_json/change_status/?reqStatus=&reqId="+valinfoid,
                    cache: false,
                    contentType: "application/json",
                    dataType: "json",
                    success: function(data){
                    // console.log(data);return false;
                    $.messager.progress('close');
                    $.messager.alert('Info', data.PESAN, 'info');
                    location.reload(); 
                }
            });


            }
        }); 
}

// function change_status(valinfoid)
// {
//     if(valinfoid == "")
//         return false; 

//     $.messager.confirm('Konfirmasi',"Non Aktifkan data terpilih?",function(r){
//         if (r){
//             $.getJSON("json-app/jabatan_json/change_status/?reqStatus=1&reqId="+valinfoid,
//                 function(data){
//                      // console.log(data);return false;
//                     $.messager.alert('Info', data.PESAN, 'info');
//                     location.reload();
//                 });

//         }
//     }); 
// }

// function change_status_aktif(valinfoid)
// {
//     if(valinfoid == "")
//         return false; 

//     $.messager.confirm('Konfirmasi',"Aktifkan data terpilih?",function(r){
//         if (r){
//             $.getJSON("json-app/jabatan_json/change_status/?reqStatus=&reqId="+valinfoid,
//                 function(data){
//                     // console.log(data);return false;
//                     $.messager.alert('Info', data.PESAN, 'info');
//                     location.reload();
//                 });

//         }
//     }); 
// }

function import_child(valinfoid)
{
    if(valinfoid == "")
        return false; 

    openAdd("app/index/master_jabatan_import?reqMode=anak&reqSuperiorId="+valinfoid);
}

</script>