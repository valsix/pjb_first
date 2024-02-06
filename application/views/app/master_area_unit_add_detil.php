<?
    $this->load->model("base-app/ListArea");
    $reqListAreaId = $this->input->get("reqListAreaId");
    $reqId = $this->input->get("reqId");

    $set= new ListArea();
    $arrlist= [];

    $statement=" AND  EXISTS (SELECT LIST_AREA_ID FROM ITEM_ASSESSMENT B  WHERE A.LIST_AREA_ID = B.LIST_AREA_ID ) AND A.STATUS IS NULL 
            AND A.LIST_AREA_ID IN ( ".$reqListAreaId.") ";
    $set->selectByParams(array(), -1,-1,$statement);
    // echo $set->query;exit;
    while($set->nextRow())
    {
        $arrdata= array();
        $arrdata["id"]= $set->getField("LIST_AREA_ID");
        $arrdata["text"]=$set->getField("NAMA");
        array_push($arrlist, $arrdata);
    }
    unset($set);
?>

<?
foreach($arrlist as $itemlist) 
{

   $listareaid= $itemlist["id"];
   $selectvaltext= $itemlist["text"];
?>
    <div id="detil-<?=$listareaid?>">
        <div class="page-header" style="background-color: green">
            <h3><i class="fa fa-file-text fa-lg"></i> <?=$selectvaltext?></h3>       
        </div>

        <table class="table table-bordered table-striped table-hovered">
            <thead>
                <tr>
                    <th style="vertical-align : middle;text-align:center;">List Area</th>
                    <th style="vertical-align : middle;text-align:center;">Nama Area Di Unit</th>
                    <th style="vertical-align : middle;text-align:center;width: 20%">Status</th>
                </tr>
            </thead>
            <tbody>
                <?

                $set= new ListArea();
                $arrset= [];

                $statement=" AND A.STATUS IS NULL AND A.LIST_AREA_ID =  ".$listareaid."  ";
                $set->selectduplikatnew(array(), -1,-1,$statement);
                // echo $set->query;
                while($set->nextRow())
                {
                    $arrdata= array();
                    $arrdata["id"]= $set->getField("LIST_AREA_ID");
                    $arrdata["text"]=$set->getField("KODE_INFO")." - ".$set->getField("NAMA");
                    $arrdata["ITEM_ASSESSMENT_DUPLIKAT_ID"]= $set->getField("ITEM_ASSESSMENT_DUPLIKAT_ID");
                    $arrdata["AREA_UNIT"]= $set->getField("AREA_UNIT");
                    $arrdata["STATUS_CONFIRM"]= $set->getField("STATUS_CONFIRM");
                    array_push($arrset, $arrdata);
                }
                unset($set);
         
                foreach($arrset as $item) 
                {
                    $selectvalid= $item["id"];
                    $selectvaltext= $item["text"];
                    $selectvaliddetil= $item["ITEM_ASSESSMENT_DUPLIKAT_ID"];
                    $selectvalareaunit= $item["AREA_UNIT"];
                    $status_confirm= $item["STATUS_CONFIRM"];

                    $set= new ListArea();

                    $statement=" AND A.STATUS IS NULL AND A.LIST_AREA_ID =  ".$listareaid." AND B.AREA_UNIT_ID=  ".$reqId." AND A1.ITEM_ASSESSMENT_DUPLIKAT_ID=  ".$selectvaliddetil."  ";
                    $set->selectduplikat(array(), -1, -1, $statement);
                    // echo $set->query;exit;
                    $set->firstRow();
                    $reqNamaUnit= $set->getField("AREA_UNIT");
                    // var_dump($status_confirm);
                ?>
                    <tr>
                        <td style="display: none"> <input type="hidden" name="iddetil[]" value="<?=$selectvaliddetil?>">
                            <input type="hidden" name="reqListAreaIdDetil[]" value="<?=$listareaid?>"></td>
                        <td style="vertical-align : middle;text-align:center;">  <?=$selectvaltext?></td>
                        <td style="vertical-align : middle;text-align:center;"> 
                            <input autocomplete="off" <?=$disabled?>  class="easyui-validatebox textbox form-control" type="text" name="reqNamaUnit[]"  id="reqNamaUnit" value="<?=$reqNamaUnit?>"  style="width:100%"   /> 
                        </td>
                        <td style="vertical-align : middle;text-align:center;"> 
                            <select class="form-control jscaribasicmultiple cobaselect" required id="reqStatusConfirm" <?=$disabled?> name="reqStatusConfirm[]"  style="width: 50%;" >
                               <option value="0" <? if($status_confirm=="0") echo 'selected' ?> >Tidak Aktif</option>
                               <option value="1" <? if($status_confirm=="1") echo 'selected' ?> >Aktif</option>
                               
                           </select> 
                        </td>
                    </tr>
                <?
                }
                ?>
           </tbody>
        </table>
     </div>
<?
}
?>
