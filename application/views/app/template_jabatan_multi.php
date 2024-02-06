<?

$this->load->model("base-app/ListArea");
$this->load->model("base-app/OutliningAssessment");



$reqPositionId = $this->input->post("reqPositionId");
$reqNama = $this->input->post("reqNama");



?>

<?


?>
    <tr id="<?=$reqUniqId?>">
        <td style="display: none"><input type="hidden" name="reqPositionId[]" id="reqPositionId" value="<?=$reqPositionId?>" /></td>
        <td> <?=$reqNama?></td>
        <td style="text-align: center;vertical-align: middle;"><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a class='btn-remove' ><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span></td>
    </tr>
<?

?>
<script type="text/javascript">
   

    $(document).ready(function(){
        var i=1;

        $('.sno').each(function(){
            $(this).text(i);
            i++;
        });
    });


</script>
