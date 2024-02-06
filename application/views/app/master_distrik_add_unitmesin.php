<?
$reqUniqId= $this->input->get("reqUniqId");
$reqUniqMesinId= $this->input->get("reqUniqMesinId");
$infokey= $reqUniqId."-".$reqUniqMesinId;
?>
<div class="form-group infogroupunitmesin<?=$infokey?>"> 
    <label class="control-label col-md-4">Nama Unit Mesin</label>
    <div class='col-md-8'>
        <div class='form-group'>
            <div class='col-md-11'>
            	<input autocomplete="off" class="easyui-validatebox textbox form-control itemblokunit" type="text" name="reqNamaDinamis[]" data-options="required:true" style="width:100%" />
            	<input type="hidden" name="reqUnitKe[]" value="<?="unitke".$reqUniqId?>" />
            	<input type="hidden" name="reqModeDinamis[]" value="unitmesin" />
                 <input type="hidden" name="reqJenisUnitKerjaId[]" value="" />
            	<a href="javascript:void(0)" class="btn btn-danger btn-remove" onclick="unitmesinhapus('<?=$infokey?>')">Hapus</a>
            </div>
        </div>
    </div>
</div>