<?
$reqNama	 = $this->input->post("reqNama");
$reqAreaId = $this->input->post("reqAreaId");


?>

<!-- <div class="item"><?=$reqJenis?>:<?=$reqNama?> --> 
<div class="item">
	<label  ><?=$reqNama?></label>

	<i class="fa fa-times-circle" onclick="$(this).parent().remove(); $('#itemisi<?=$reqSatkerId?>').empty();"></i>
    <input type="hidden" name="reqAreaId[]" value="<?=$reqAreaId?>">
   
</div>