<?php
include_once("functions/string.func.php");
include_once("functions/date.func.php");
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

    <script src="assets/bootstrap-4.1.2/docs/dist/js/bootstrap.min.js"></script>
    <script src="assets/bootstrap-4.1.2/docs/assets/js/ie10-viewport-bug-workaround.js"></script>

      <!-- EASYUI 1.4.5 -->
    <link rel="stylesheet" type="text/css" href="assets/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="assets/easyui/themes/icon.css">
    <script type="text/javascript" src="assets/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="assets/easyui/datagrid-groupview.js"></script>
    <script type="text/javascript" src="assets/easyui/globalfunction.js"></script>
    <script type="text/javascript" src="assets/easyui/kalender-easyui.js"></script>    

    

    <!-- select multi -->
    <link href="assets/select2/select2.min.css" rel="stylesheet" />
    <script src="assets/select2/select2.min.js"></script>
    <link href="assets/select2totreemaster/src/select2totree.css" rel="stylesheet">
    <script src="assets/select2totreemaster/src/select2totree.js"></script>
        
    <script type="text/javascript">
        $(document).ready(function() {
            $('.jscaribasicmultiple').select2();
        });
    </script>

    <!-- TAMBAHAN UNTUK ALERT -->
    <link href="assets/mbox/mbox.css" rel="stylesheet">
    <script src="assets/mbox/mbox.js"></script>
    <link href="assets/mbox/mbox-modif.css" rel="stylesheet">

    <style type="text/css">
        [class*="sidebar-dark-"] .nav-sidebar > .nav-item.menu-open > .nav-link,
        [class*="sidebar-dark-"] .nav-sidebar > .nav-item:hover > .nav-link,
        [class*="sidebar-dark-"] .nav-sidebar > .nav-item > .nav-link:focus {
          background-color: rgba(255, 255, 255, 0.1);
          color: #050505;
        }

    </style>
</head>

    <body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">

        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <?=$content?>
        </div>

    </body>
</html>