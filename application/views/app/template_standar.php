<?
$reqNama	 = $this->input->post("reqNama");
$reqStandarId = $this->input->post("reqStandarId");


?>

<!-- <div class="item"><?=$reqJenis?>:<?=$reqNama?> --> 
<div class="item">
	<label  ><?=$reqNama?></label>

	<i class="fa fa-times-circle" onclick="$(this).parent().remove(); $('#itemisi').empty();"></i>
    <input type="hidden" name="reqStandarId[]" value="<?=$reqStandarId?>">
   
</div>