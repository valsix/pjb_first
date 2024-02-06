<style type="text/css">* {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}
</style>

<?

$this->load->model("base-app/KategoriItemAssessment");
$this->load->model("base-app/ProgramItemAssessment");

$reqUniqId = $this->input->get("reqUniqId");



$set= new KategoriItemAssessment();
$arrstandar= [];
$set->selectByParams(array(), -1,-1,"");
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("KATEGORI_ITEM_ASSESSMENT_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrstandar, $arrdata);
}
unset($set);


$set= new ProgramItemAssessment();
$arrprogram= [];
$set->selectByParams(array(), -1,-1,"");
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("PROGRAM_ITEM_ASSESSMENT_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrprogram, $arrdata);
}
unset($set);

?>
<div id="border" style="border:1px solid black; ">   
    <div class="form-group"> 
        <label class="control-label col-md-2">Kategori Item Assessment </label>
        <div class='col-md-8'>
            <div class='form-group'>
                <div class='col-md-11'>
                    <select class="form-control jscaribasicmultiple" required id="reqKategoriId" <?=$disabled?> name="reqKategoriId[]"  style="width:100%;" >
                            <?
                            foreach($arrstandar as $item) 
                                {
                                    $selectvalid= $item["id"];
                                    $selectvaltext= $item["text"];

                                    $selected="";
                                    if($selectvalid==$reqKategoriId)
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
        <label class="control-label col-md-2"> Item Assessment </label>
        <div class='col-md-8'>
            <div class='form-group'>
                <div class='col-md-11'>
                    <textarea class="easyui-validatebox textbox form-control" required name="reqNama[]" style="width:100%"></textarea>
                </div>              
            </div>
        </div>
    </div>

    <div class="form-group">  
        <label class="control-label col-md-2">Konfirmasi  </label>
        <div class='col-md-8'>
            <div class='form-group'>
                <div class='col-md-11'>
                    <select class="form-control jscaribasicmultiple" required id="reqTersedia" <?=$disabled?> name="reqTersedia[]"  style="width:15%;" >
                       <option value="1" >Iya</option>
                       <option value="2" >Tidak</option>
                   </select>
               </div>
           </div>
       </div>
    </div>

    <div class="form-group"> 
        <label class="control-label col-md-2">Program Item Assessment </label>
        <div class='col-md-8'>
            <div class='form-group'>
                <div class='col-md-11'>
                    <select class="form-control jscaribasicmultiple" required id="reqProgramId" <?=$disabled?> name="reqProgramId[]"  style="width:100%;" >
                            <?
                            foreach($arrprogram as $item) 
                                {
                                    $selectvalid= $item["id"];
                                    $selectvaltext= $item["text"];

                                    $selected="";
                                    if($selectvalid==$reqProgramId)
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
        <label class="control-label col-md-2">Standar Referensi </label>
        <div class='col-md-8'>
                <div class='form-group'>
                    <div class='col-md-11'>
                        <a id="btnAdd" onclick="openStandar('<?=$reqUniqId?>')"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i>&nbsp; </a>
                        <div class="inner" id="divlistform<?=$reqUniqId?>">
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="reqUniqId" value="<?=$reqUniqId?>" />
    <br>
    <br>
</div>

<script type="text/javascript">


    
</script>
