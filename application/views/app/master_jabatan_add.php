<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/MasterJabatan");
$this->load->model('base-app/Distrik');

$this->load->model("base-app/Crud");
$appuserkodehak= $this->appuserkodehak;

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


$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqIdDetil = $this->input->get("reqIdDetil");


$set= new MasterJabatan();

if($reqId == "")
{
    $reqMode = "insert";
    $reqTipeInfo="External";
    $reqSuperiorId="TOP";
    $kodedisabled="";

    if(!empty($reqIdDetil))
    {
        $statement = " AND A.POSITION_ID = '".$reqIdDetil."' ";
        $set->selectByParams(array(), -1, -1, $statement);
         // echo $set->query;exit;
        $set->firstRow();
        $reqSuperiorId= $set->getField("POSITION_ID");
        $reqNamaParent= $set->getField("NAMA_POSISI");
    }
}
else
{
    $reqMode = "update";

	$statement = " AND A.POSITION_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("POSITION_ID");
    $reqDistrikKode= $set->getField("KODE_DISTRIK");
    // echo ($reqDistrikKode);exit;
    $reqNama= $set->getField("NAMA_POSISI");
    $reqKode= $set->getField("POSITION_ID");
    $reqKategori= $set->getField("KATEGORI");
    $reqJenjang= $set->getField("JENJANG_JABATAN");
    $reqTipeUnit= $set->getField("UNIT");
    $reqDitBid= $set->getField("DITBID");
    $reqTipe= $set->getField("TIPE");
    $reqTipeInfo= $set->getField("TIPE_INFO");
    $reqSuperiorId= $set->getField("SUPERIOR_ID");
    $reqKodeUnit= $set->getField("KODE_UNIT");
    $kodedisabled="readonly";

}


$set= new Distrik();
$arrdistrik= [];
$set->selectByParams(array(), -1,-1);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("DISTRIK_ID");
    $arrdata["kode"]= $set->getField("KODE");
    $arrdata["text"]= $set->getField("KODE")." - ".$set->getField("NAMA") ;

    array_push($arrdistrik, $arrdata);
}
unset($set);

if($reqRead==1)
{
    $reqTipe=1;
}

$disabled="";
if($reqTipe == 1)
{
    $disabled="disabled";
}

?>

<script src='assets/multifile-master/jquery.form.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MetaData.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MultiFile.js' type="text/javascript" language="javascript"></script> 
<link rel="stylesheet" href="css/gaya-multifile.css" type="text/css">


<div class="col-md-12">
    
  <div class="judul-halaman"> <a href="app/index/<?=$pgreturn?>">Data <?=$pgtitle?></a> &rsaquo; Kelola <?=$pgtitle?></div>

    <div class="konten-area">
        <div class="konten-inner">

            <div>

                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">

                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i> <?=$pgtitle?></h3>       
                    </div>
                    <?
                    if(!empty($reqIdDetil))
                    {
                    ?>
                    <div class="form-group">  
                        <label class="control-label col-md-2">Jabatan Parent </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" value="<?=$reqNamaParent?>" disabled style="width:100%" />
                               </div>
                           </div>
                       </div>
                    </div>
                    <?
                    }
                    ?>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Kode Jabatan</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqKode"  id="reqKode" value="<?=$reqKode?>" <?=$kodedisabled?> data-options="required:true" style="width:100%" />
                               </div>
                           </div>
                       </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Nama Jabatan</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqNama"  id="reqNama" value="<?=$reqNama?>" <?=$disabled?> data-options="required:true" style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Distrik</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <select class="form-control jscaribasicmultiple" <?=$disabled?> id="reqDistrikKode" <?=$disabled?> name="reqDistrikKode" style="width:100%;">
                                        <option value="" >Pilih Distrik</option>
                                        <?
                                        foreach($arrdistrik as $item) 
                                        {
                                            $selectvalid= $item["id"];
                                            $selectvalidkode= $item["kode"];
                                            $selectvaltext= $item["text"];

                                            $selected="";
                                            if($selectvalidkode==$reqDistrikKode)
                                            {
                                                $selected="selected";
                                            }
                                            ?>
                                            <option value="<?=$selectvalidkode?>" <?=$selected?>><?=$selectvaltext?></option>
                                            <?
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Kategori</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" <?=$disabled?> class="easyui-validatebox textbox form-control" type="text" name="reqKategori"  id="reqKategori" value="<?=$reqKategori?>" style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Jenjang</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" <?=$disabled?> class="easyui-validatebox textbox form-control" type="text" name="reqJenjang"  id="reqJenjang" value="<?=$reqJenjang?>" style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Kode Unit</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" <?=$disabled?> class="easyui-validatebox textbox form-control" type="text" name="reqKodeUnit"  id="reqKodeUnit" value="<?=$reqKodeUnit?>" style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Tipe Unit</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" <?=$disabled?> class="easyui-validatebox textbox form-control" type="text" name="reqTipeUnit"  id="reqTipeUnit" value="<?=$reqTipeUnit?>" style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Dit Bid</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" <?=$disabled?> class="easyui-validatebox textbox form-control" type="text" name="reqDitBid"  id="reqDitBid" value="<?=$reqDitBid?>" style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Tipe</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <input autocomplete="off" disabled class="easyui-validatebox textbox form-control" type="text" name="reqTipeInfo"  id="reqTipeInfo" value="<?=$reqTipeInfo?>" style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="reqId" value="<?=$reqId?>" />
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
                    <input type="hidden" name="reqSuperiorId" value="<?=$reqSuperiorId?>" />

                </form>

            </div>
            <div style="text-align:center;padding:5px">
                <? if($reqTipe != 1)
                {
                ?>
                    <a href="javascript:void(0)" class="btn btn-primary" onclick="submitForm()">Submit</a>
                <?
                }
                ?>
            </div>
            
        </div>
    </div>
    
</div>

<script>
function submitForm(){
    $('#ff').form('submit',{
        url:'json-app/jabatan_json/add',
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
                $.messager.alertLink('Info', infoSimpan, 'info', "app/index/<?=$pgreturn?>");
        }
    });
}

function clearForm(){
    $('#ff').form('clear');
}   
</script>