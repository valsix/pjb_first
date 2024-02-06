<?
$reqNama	 = $this->input->post("reqNama");
$reqDistrikId = $this->input->post("reqDistrikId");


?>

<!-- <div class="item"><?=$reqJenis?>:<?=$reqNama?> --> 
<div class="item">
	<label  ><?=$reqNama?></label>

	<i class="fa fa-times-circle" onclick="$(this).parent().remove(); $('#itemisi<?=$reqSatkerId?>').empty();"></i>
    <input type="hidden" name="reqDistrikId[]" value="<?=$reqDistrikId?>">
   
</div>