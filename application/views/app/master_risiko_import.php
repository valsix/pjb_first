<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));
$reqId = $this->input->get("reqId");


$link="app/loadUrl/app/risiko_template";
?>

<style type="text/css">

.box {
  width: 100%;
  height: 100%;
  border: 2px solid #000;
  margin: 0 auto 15px;
  text-align: center;
  padding: 20px;
  /*font-weight: bold;*/
  border-radius: 10px;
}
.warning {
  background-color: #FFF484;
  border-color: #DCC600;
}

div.box {
    overflow: auto;
    height: 8em;
    padding: 1em;
    /*! color: #444; */
    background-color: #FFF484;
    border: 1px solid #e0e0e0;
    margin-bottom: 2em;
}




</style>

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
                            <div class="warning box" style="text-align: justify;font-size: 18px">
                                <ol>
                                    <li>Pastikan data import format <b>(xls)</b> sesuai dengan contoh template yang sudah ada</li>
                                    <li>Kolom <b>Peraturan ID</b> berformat <b>Angka/Integer</b>
                                    </li>
                                    <li>Kolom <b>Kode</b> harus unik dan tidak boleh ada spasi
                                    </li>
                                </ol>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-6 col-sm-12" style="font-size: 15px">Contoh Template <a class="link-button" href="<?=$link?>" target="_blank"><img src="images/icon-download.png" width="15" height="15" /> Download </a></label>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-4 col-sm-12" style="font-size: 15px;">File :</label>
                                <input type="file" name="reqLinkFile" id="reqLinkFile" class="easyui-validatebox" accept="application/vnd.ms-excel" />
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="reqId" value="<?=$reqId?>" />
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>" />

                </form>
            </div>
            <div style="text-align:center;padding:5px">
                <a href="javascript:void(0)" class="btn btn-primary" onclick="submitForm()">Submit</a>

            </div>
        </div>
    </div>
</div>

<script>

function submitForm(){
    $('#ff').form('submit',{
        url:'json-app/import_json/risiko_template',
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
                    top.location.href= "app/index/master_risiko";
                });
        }
    });
}

function clearForm(){
    $('#ff').form('clear');
}   
</script>