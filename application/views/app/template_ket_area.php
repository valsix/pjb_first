<?
$reqAreaId = $this->input->get("reqAreaId");

$this->load->model("base-app/ListArea");

$set= new ListArea();

$statement=" AND A.STATUS IS NULL AND A.LIST_AREA_ID = ".$reqAreaId;
$set->selectByParams(array(), -1,-1,$statement);
    // echo $set->query;exit;
$set->firstRow();
$reqNama= $set->getField("DESKRIPSI");
$reqKode= $set->getField("KODE");

?>

<div class="form-group">  
	<label class="control-label col-md-2">Kode Area </label>
	<div class='col-md-8'>
		<div class='form-group'>
			<div class='col-md-11'>
				<textarea class="easyui-validatebox textbox form-control" disabled><?=$reqKode?></textarea>
			</div>
		</div>
	</div>
</div>

<div class="form-group">  
	<label class="control-label col-md-2">Deskripsi Area </label>
	<div class='col-md-8'>
		<div class='form-group'>
			<div class='col-md-11'>
				<textarea class="easyui-validatebox textbox form-control" disabled><?=$reqNama?></textarea>
			</div>
		</div>
	</div>
</div>
