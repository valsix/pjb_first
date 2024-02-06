<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/PenggunaInternal");
$this->load->model("base-app/RoleApproval");
$this->load->model("base-app/MasterJabatan");



$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");

$set= new PenggunaInternal();

if($reqId == "")
{
    $reqMode = "insert";
    $reqExpiredDate=date('d-m-Y', strtotime('+1 year'));
}
else
{
    $reqMode = "update";

	$statement = " AND PENGGUNA_INTERNAL_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("NID");
    $reqNid= $set->getField("NID");
    $reqNama= $set->getField("NAMA_LENGKAP");
    $reqKodeBagian= $set->getField("KODE_BAGIAN");
    $reqBagian= $set->getField("BAGIAN");
    $reqKodeDitbid= $set->getField("KODE_DITBID");
    $reqDitbid= $set->getField("DITBID");
    $reqKodeUnit= $set->getField("KODE_UNIT");
    $reqUnit= $set->getField("UNIT");
    $reqKodeKlasifikasi= $set->getField("KODE_KLASIFIKASI_UNIT");
    $reqKlasifikasi= $set->getField("KLASIFIKASI_UNIT");
    $reqPosisi= $set->getField("NAMA_POSISI");
    $reqEmail= $set->getField("EMAIL");

    // $reqKodeReadonly= " readonly ";
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
                                                                             
                    <div class="form-group">  
                        <label class="control-label col-md-2">NID</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqNid"  id="reqNid" value="<?=$reqNid?>" readonly style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Nama Lengkap</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqNama" readonly id="reqNama" value="<?=$reqNama?>" style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Email</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <input autocomplete="off" readonly class="easyui-validatebox textbox form-control" type="text" name="reqEmail"  id="reqEmail" value="<?=$reqEmail?>"  style="width:100%" />
                               </div>
                           </div>
                       </div>
                   </div>


                    <div class="form-group">  
                        <label class="control-label col-md-2">Bagian</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <input autocomplete="off" readonly class="easyui-validatebox textbox form-control" type="text" name="reqBagian"  id="reqBagian" value="<?=$reqBagian?>"  style="width:100%" />
                               </div>
                           </div>
                       </div>
                   </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Ditbid</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <input autocomplete="off" readonly class="easyui-validatebox textbox form-control" type="text" name="reqDitbid"  id="reqDitbid" value="<?=$reqDitbid?>"  style="width:100%" />
                               </div>
                           </div>
                       </div>
                   </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Unit</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <input autocomplete="off" readonly class="easyui-validatebox textbox form-control" type="text" name="reqUnit"  id="reqUnit" value="<?=$reqUnit?>"  style="width:100%" />
                               </div>
                           </div>
                       </div>
                   </div>


                    <div class="form-group">  
                        <label class="control-label col-md-2">Klasifikasi</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <input autocomplete="off" readonly class="easyui-validatebox textbox form-control" type="text" name="reqKlasifikasi"  id="reqKlasifikasi" value="<?=$reqKlasifikasi?>"  style="width:100%" />
                               </div>
                           </div>
                       </div>
                   </div>

                   <div class="form-group">  
                        <label class="control-label col-md-2">Nama Posisi</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <input autocomplete="off" readonly class="easyui-validatebox textbox form-control" type="text" name="reqPosisi"  id="reqPosisi" value="<?=$reqPosisi?>"  style="width:100%" />
                               </div>
                           </div>
                       </div>
                   </div>


                    <input type="hidden" name="reqId" value="<?=$reqId?>" />
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>" />

                </form>

            </div>
            <div style="text-align:center;padding:5px">

            </div>
            
        </div>
    </div>
    
</div>

<script>


</script>