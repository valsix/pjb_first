<?
$reqUniqId= $this->input->get("reqUniqId");
$this->load->model("base-app/JenisUnitKerja");


$set= new JenisUnitKerja();
$arrjenis= [];
$set->selectByParams(array(), -1,-1," AND A.STATUS IS NULL");
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("JENIS_UNIT_KERJA_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrjenis, $arrdata);
}
unset($set);

?>
<div id="itemblokunit<?=$reqUniqId?>" style="border:1px solid black; margin-top: 10px">
    <div class="form-group">  
        <label class="control-label col-md-3">Jenis Pembangkit</label>
        <div class='col-md-8'>
            <div class='form-group'>
                <div class='col-md-11'>
                    <select class="form-control jscaribasicmultiple edittext" id="reqJenisUnitKerjaId" <?=$disabled?> name="reqJenisUnitKerjaId[]" style="width:100%;"  >
                        <option value="" >Pilih Jenis Unit Kerja</option>
                        <?
                        foreach($arrjenis as $item) 
                        {
                            $selectvalid= $item["id"];
                            $selectvaltext= $item["text"];

                            $selected="";
                            if(in_array($selectvalid, $reqJenisUnitKerjaId))
                            {
                                $selected="selected";
                            }
                            ?>
                            <option value="<?=$selectvalid?>" <?=$selected?>><?=$selectvaltext?></option>
                            <?
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group"> 
        <label class="control-label col-md-3">
            Nama Blok/Unit
        </label>
        <div class='col-md-8'>
            <div class='form-group'>

                <div class='col-md-11'>
                    <input autocomplete="off" class="easyui-validatebox textbox form-control itemblokunit" type="text" name="reqNamaDinamis[]" data-options="required:true" style="width:100%" />
                    <input type="hidden" name="reqUnitKe[]" value="<?="unitke".$reqUniqId?>" />
                    <input type="hidden" name="reqModeDinamis[]" value="blokunit" />

                    <a href="javascript:void(0)" class="btn btn-primary" onclick="unitmesintambah('<?=$reqUniqId?>')">Add Unit Mesin</a>
                    <a href="javascript:void(0)" class="btn btn-danger btn-remove" onclick="blokunithapus('<?=$reqUniqId?>')">Hapus</a>

                    <div id="itemunitmesinblok<?=$reqUniqId?>" style="border:1px solid black; margin-top: 10px">
                    </div>

               </div>
           </div>
       </div>
    </div>
</div>