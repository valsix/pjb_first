<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$pgreturn= str_replace("_add", "", $pg);
$reqDistrikId = $this->input->get("reqDistrikId");
$reqLihat = $this->input->get("reqLihat");
$reqBlokUnitId = $this->input->get("reqBlokUnitId");





$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$link="template/import/unit_mesin.xls";
?>

<div class="col-md-12">
    
  <div class="judul-halaman"> <a href="app/index/<?=$pgreturn?>">Master <?=$pgtitle?></a> &rsaquo; Form Import</div>

    <div class="konten-area">
        <div class="konten-inner">
            <div>
                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">

                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i> <?=$pgtitle?></h3>       
                    </div>
                                                                             
                    <div class="form-group">  
                         <div class="card-body">
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-10 col-sm-12" style="font-size: 18px">Pastikan data import format <b>(xls)</b> sesuai dengan contoh template yang sudah ada</label>
                            </div>
                            <br>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-6 col-sm-12" style="font-size: 15px">Contoh Template <a class="link-button" href="<?=$link?>" target="_blank"><img src="images/icon-download.png" width="15" height="15" /> Download </a></label>
                            </div>
                            <br>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-4 col-sm-12" style="font-size: 15px;">File :</label>
                                <input type="file" name="reqLinkFile" id="reqLinkFile" class="easyui-validatebox" accept="application/vnd.ms-excel" />
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="reqDistrikId" value="<?=$reqDistrikId?>" />
                    <input type="hidden" name="reqBlokUnitId" value="<?=$reqBlokUnitId?>" />
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>" />

                </form>
            </div>
            <div style="text-align:center;padding:5px">
                 <a href="javascript:void(0)" class="btn btn-warning" onclick="kembali()">Kembali</a>
                <a href="javascript:void(0)" class="btn btn-primary" onclick="submitForm()">Submit</a>

            </div>
        </div>
    </div>
</div>

<script>

    function kembali(){
       varurl= "iframe/index/master_unit_mesin?reqDistrikId=<?=$reqDistrikId?>&reqBlokUnitId=<?=$reqBlokUnitId?>";
       document.location.href = varurl;
   }

function submitForm(){
    $('#ff').form('submit',{
        url:'json-app/import_json/unit_mesin',
        onSubmit:function(){

            if($(this).form('validate'))
            {
                var win = $.messager.progress({
                    title:'<?=$this->configtitle["progres"]?>',
                    msg:'proses data...'
                });
            }

            return $(this).form('enableValidation').form('validate');
        },
        success:function(data){
            $.messager.progress('close');
            // console.log(data);return false;
            data = data.split("***");
            reqId= data[0];
            infoSimpan= data[1];

            if(reqId == 'xxx')
                $.messager.alert('Info', infoSimpan, 'warning');
            else
                $.messager.alert('Info', infoSimpan ,null,function(){
                    // top.location.href= "iframe/index/master_unit_mesin?reqDistrikId=<?=$reqDistrikId?>&reqBlokUnitId=<?=$reqBlokUnitId?>";
                    varurl= "iframe/index/master_unit_mesin?reqDistrikId=<?=$reqDistrikId?>&reqBlokUnitId=<?=$reqBlokUnitId?>";
                    document.location.href = varurl;
                });
        }
    });
}

function clearForm(){
    $('#ff').form('clear');
}   
</script>