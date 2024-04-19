<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->model("base-app/Approval");

$appuserpilihankodehak= $this->appuserpilihankodehak;
$arrpilihanmulti= explode(",", $this->appuserpilihankodehak);
// print_r($appuserpilihankodehak);exit;
$appuserkodehak= $this->appuserkodehak;
// echo $appuserkodehak;exit;

$carigroup= "";
$infolinkmodul= $pg;
$infolinkmodul= str_replace("_add", "", $infolinkmodul);
// echo $infolinkmodul;exit;

$statement= " AND LINK_MODUL = '".$infolinkmodul."'";
$set= new Approval();
$set->selectmenu($appuserkodehak, $statement);
// echo $set->query;exit;
$set->firstRow();
$infodatagroupmodul= $set->getField("GROUP_MODUL");
// echo $infodatagroupmodul;exit;

$set= new Approval();
$set->selectmenu($appuserkodehak);
$arrMenu=[];
while($set->nextRow())
{
    $arrdata= [];
    $arrdata["ID"]= $set->getField("KODE_MODUL");
    $arrdata["ID_PARENT"]= $set->getField("LEVEL_MODUL");
    $arrdata["NAMA"]= $set->getField("MENU_MODUL");
    $arrdata["NAMA_GROUP"]= $set->getField("GROUP_MODUL");
    $arrdata["LINK_MODUL"]= $set->getField("LINK_MODUL");
    array_push($arrMenu, $arrdata);
}
// print_r($arrMenu);exit();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$this->configtitle["home"]?></title>
    <base href="<?=base_url();?>" />

    <link rel="stylesheet" href="assets/AdminLTE-3.1.0/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="assets/AdminLTE-3.1.0/dist/css/adminlte.min.css">
    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase.js"></script>
    <link href="assets/bootstrap-4.1.2/docs/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/bootstrap-4.1.2/docs/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <script src="assets/bootstrap-4.1.2/docs/assets/js/ie-emulation-modes-warning.js"></script>

    <link rel="stylesheet" href="css/halaman.css" type="text/css">
    <link rel="stylesheet" href="css/gaya-egateway.css" type="text/css">
    <link rel="stylesheet" href="css/gaya-datatable-egateway.css" type="text/css">
    <link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.css">
    <script type='text/javascript' src="assets/bootstrap/js/jquery-1.12.4.min.js"></script>

    <link rel="stylesheet" type="text/css" href="assets/DataTables-1.10.7/extensions/Responsive/css/dataTables.responsive.css">
    <link rel="stylesheet" type="text/css" href="assets/DataTables-1.10.7/examples/resources/syntax/shCore.css">
    <link rel="stylesheet" type="text/css" href="assets/DataTables-1.10.7/examples/resources/demo.css">
    
    <script type="text/javascript" language="javascript" src="assets/DataTables-1.10.7/media/js/jquery.js"></script>
    <script type="text/javascript" language="javascript" src="assets/DataTables-1.10.7/media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" language="javascript" src="assets/DataTables-1.10.7/extensions/Responsive/js/dataTables.responsive.js"></script>
    <script type="text/javascript" language="javascript" src="assets/DataTables-1.10.7/examples/resources/syntax/shCore.js"></script>
    <script type="text/javascript" language="javascript" src="assets/DataTables-1.10.7/examples/resources/demo.js"></script>

    <link rel="stylesheet" type="text/css" href="assets/drupal-pagination/pagination.css" />

    <script src="assets/js/valsix-serverside.js"></script>

      <!-- EASYUI 1.4.5 -->
    <link rel="stylesheet" type="text/css" href="assets/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="assets/easyui/themes/icon.css">
    <script type="text/javascript" src="assets/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="assets/easyui/datagrid-groupview.js"></script>
    <script type="text/javascript" src="assets/easyui/globalfunction.js"></script>
    <script type="text/javascript" src="assets/easyui/kalender-easyui.js"></script>    

    <!-- select multi -->
    <link href="assets/select2/select2.min.css" rel="stylesheet" />
    <style type="text/css">
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
          color: #000000;
      }
      .select2-container--default .select2-search--inline .select2-search__field:focus {
          outline: 0;
          border: 1px solid #ffff;
      }

      .select2-container--default .select2-selection--multiple .select2-selection__choice__display {
          cursor: default;
          padding-left: 6px;
          padding-right: 5px;
      }


  </style>

   <!--  <script src="assets/select2/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.jscaribasicmultiple').select2();
        });
    </script> -->
    
    
</head>

<body>
      <div>
        <div class="row">
            <?=($content ? $content:'')?>
        </div>
    </div>

    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="assets/bootstrap-4.1.2/docs/dist/js/bootstrap.min.js"></script>
    <script src="assets/bootstrap-4.1.2/docs/assets/js/ie10-viewport-bug-workaround.js"></script>
    
    <!-- SCROLLBAR -->
    <script type='text/javascript' src="assets/js/enscroll-0.6.0.min.js"></script>
    <script type='text/javascript'>//<![CDATA[
    $(function(){
        $('.operator-inner').enscroll({
            showOnHover: false,
            verticalTrackClass: 'track3',
            verticalHandleClass: 'handle3'
        });
    });//]]> 
    
    </script>
    
    <!-- EMODAL -->
    <script src="assets/emodal/eModal.js"></script>
    <script src="assets/emodal/eModal-cabang.js"></script>
    
    <script>
    function openAdd(pageUrl) {
        eModal.iframe(pageUrl, 'ICARLA | PT PJB')
    }
    function openCabang(pageUrl) {
        eModalCabang.iframe(pageUrl, 'ICARLA | PT PJB')
    }
    function closePopup() {
        eModal.close();
    }
    
    function windowOpener(windowHeight, windowWidth, windowName, windowUri)
    {
        var centerWidth = (window.screen.width - windowWidth) / 2;
        var centerHeight = (window.screen.height - windowHeight) / 2;
    
        newWindow = window.open(windowUri, windowName, 'resizable=0,width=' + windowWidth + 
            ',height=' + windowHeight + 
            ',left=' + centerWidth + 
            ',top=' + centerHeight);
    
        newWindow.focus();
        return newWindow.name;
    }
    
    function windowOpenerPopup(windowHeight, windowWidth, windowName, windowUri)
    {
        var centerWidth = (window.screen.width - windowWidth) / 2;
        var centerHeight = (window.screen.height - windowHeight) / 2;
    
        newWindow = window.open(windowUri, windowName, 'resizable=1,scrollbars=yes,width=' + windowWidth + 
            ',height=' + windowHeight + 
            ',left=' + centerWidth + 
            ',top=' + centerHeight);
    
        newWindow.focus();
        return newWindow.name;
    }
    
    </script>
    
    <?
    if($pg == "verifikasi_pr_group_number_detil" || $pg == "pr_group_number_detil"){
    ?>

    <link rel="stylesheet" href="assets/ScrollingTable-master/style.css" />
    <script src="assets/ScrollingTable-master/scrollingtable.js"></script>
    <script>
        $('#Demo').ScrollingTable();
    </script>
    <?
    }
    ?>
    
    <!-- SELECTED ROW ON TABLE SCROLLING -->
    <style>
    *table#Demo tbody tr:nth-child(odd){ background-color: #ddf7ef;}
    table#Demo tbody tr:hover{background-color: #333; color: #FFFFFF;}
    table#Demo tbody tr.selectedRow{background-color: #0072bc; color: #FFFFFF;}
    </style>
    <script>
    $("table#Demo tbody tr").click(function(){
        //alert("haii");
        $("table tr").removeClass('selectedRow');
        $(this).addClass('selectedRow');
    });
    </script>
    
    <!-- CHANGE BGCOLOR WHEN SCROLL -->
    <script>
    $(function () {
      $(document).scroll(function () {
        var $nav = $(".navbar-fixed-top");
        $nav.toggleClass('scrolled', $(this).scrollTop() > $nav.height());
      });
    });
    </script>
    <style>
    .navbar-fixed-top.scrolled {
      background-color: #2b2655 !important;
      transition: background-color 1000ms linear;
    }
    </style>
    
  
</body>
</html>