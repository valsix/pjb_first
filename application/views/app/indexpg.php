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
    <link href="assets/bootstrap-3.3.7/docs/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/bootstrap-3.3.7/docs/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <script src="assets/bootstrap-3.3.7/docs/assets/js/ie-emulation-modes-warning.js"></script>

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
    <script src="assets/select2/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.jscaribasicmultiple').select2();
        });
    </script>
    
    
</head>

<body>
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item menu-bars">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block <? if($pg == "" || $pg == "home"|| $pg == "home_logsheet"|| $pg == "home_pemeliharaan"){?>active<? } ?>">
                    <a href="app/" class="nav-link"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <?
                if(count($arrpilihanmulti) > 1)
                {
                ?>
                <li class="nav-item">
                    <a class="nav-link logout" href="app/gantirule"><i class="fa fa-edit fa-xs"></i> Ganti Rule</a>
                </li>
                <?
                }
                ?>
                <li>&nbsp;&nbsp;</li>
                <li class="nav-item">
                    <a class="nav-link logout"  data-toggle="modal" data-target="#myModal"><i class="fa fa-key fa-xs"></i> Ubah Password</a>
                </li>
                <li>&nbsp;&nbsp;</li>
                <li class="nav-item">
                    <a class="nav-link logout" href="login/logout"><i class="fa fa-sign-out fa-xs"></i> Logout</a>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4 bg-blur">
            <a href="app/" class="brand-link" style="position: relative;">
                <img src="images/logo.png" class="img-responsive"> 
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <?
                        if(file_exists("uploads/foto/".$this->ID.".jpg"))
                            $urlFoto= "uploads/foto/".$this->ID.".jpg";
                        else
                            $urlFoto= "images/foto.png";
                        ?>
                        <img src="<?=$urlFoto?>" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info" style="min-height: 0px !important;">
                        <a href="#" class="d-block">
                            <div class="user-login"><?=$this->USER_LOGIN?> <br><?=$this->USER_NAMA?></div>
                            <div class="distrik"><?=coalesce($this->CABANG, $this->DISTRIK)?></div>
                        </a>
                        <div class="jabatan"><?=$this->USER_TYPE_NAMA?> </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <?
                function getmenubyparent($infoid, $arrMenu, $infolinkmodul)
                {
                    $arrayKey= [];
                    $arrayKey= in_array_column($infoid, "ID_PARENT", $arrMenu);
                    // print_r($arrayKey);exit;
                    foreach ($arrayKey as $valkey => $indexkey) 
                    {
                        $infoid= $arrMenu[$indexkey]["ID"];
                        $infonama= $arrMenu[$indexkey]["NAMA"];
                        $infolink= $arrMenu[$indexkey]["LINK_MODUL"];

                        $infoactive= "";
                        if($infolinkmodul == $infolink)
                            $infoactive= "active";
                ?>
                    <a class=" <?=$infoactive?>" href="app/index/<?=$infolink?>"><?=$infonama?></a>
                <?
                    }
                }
                ?>

                <nav class="mt-2" id="myDIV">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <?
                        $arrayKey= [];
                        $arrayKey= in_array_column("0", "ID_PARENT", $arrMenu);
                        // print_r($arrayKey);exit;
                        foreach ($arrayKey as $valkey => $indexkey) 
                        {
                            $infoid= $arrMenu[$indexkey]["ID"];
                            $infogroupmodul= $arrMenu[$indexkey]["NAMA_GROUP"];
                            $infonama= $arrMenu[$indexkey]["NAMA"];
                            $infolink= $arrMenu[$indexkey]["LINK_MODUL"];
                        ?>
                        <li class="nav-item <?=(stristr($infogroupmodul, $infodatagroupmodul) ? "menu-is-opening menu-open" : "")?>">
                            <a href="<?=$infolink?>" class="nav-link <?=(stristr($infogroupmodul, $infodatagroupmodul) ? "active" : "")?>"><strong><?=$infonama?></strong>
                            <span class="<? if($infogroupmodul == $infodatagroupmodul){ ?>caret<? } else {?>arrow-right<? } ?>"></span></a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <?=getmenubyparent($infoid, $arrMenu, $infolinkmodul);?>
                                </li>
                            </ul>
                        </li>
                        <?
                        }
                        ?>
                    </ul>

                </nav>
            </div>
      </aside>

      <div class="content-wrapper">

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <?=($content ? $content:'')?>
                </div>
            </div>
        </div>

      </div>

      <aside class="control-sidebar control-sidebar-dark">
      </aside>

    </div>

    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="assets/bootstrap-3.3.7/docs/dist/js/bootstrap.min.js"></script>
    <script src="assets/bootstrap-3.3.7/docs/assets/js/ie10-viewport-bug-workaround.js"></script>
    
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
    
    <?
    if($pg = "data_wo_detil")
    {
    ?>
    <script type="text/javascript" src="assets/fancyBox-master/source/jquery.fancybox.pack.js?v=2.1.5"></script>
    <link rel="stylesheet" type="text/css" href="assets/fancyBox-master/source/jquery.fancybox.css?v=2.1.5" media="screen" />

    <script type="text/javascript">
        $(document).ready(function() {
            /*
             *  Simple image gallery. Uses default settings
             */

            $('.fancybox').fancybox();

            /*
             *  Different effects
             */

            // Change title type, overlay closing speed
            $(".fancybox-effects-a").fancybox({
                helpers: {
                    title : {
                        type : 'outside'
                    },
                    overlay : {
                        speedOut : 0
                    }
                }
            });

            // Disable opening and closing animations, change title type
            $(".fancybox-effects-b").fancybox({
                openEffect  : 'none',
                closeEffect : 'none',

                helpers : {
                    title : {
                        type : 'over'
                    }
                }
            });

            // Set custom style, close if clicked, change title type and overlay color
            $(".fancybox-effects-c").fancybox({
                wrapCSS    : 'fancybox-custom',
                closeClick : true,

                openEffect : 'none',

                helpers : {
                    title : {
                        type : 'inside'
                    },
                    overlay : {
                        css : {
                            'background' : 'rgba(238,238,238,0.85)'
                        }
                    }
                }
            });

            // Remove padding, set opening and closing animations, close if clicked and disable overlay
            $(".fancybox-effects-d").fancybox({
                padding: 0,

                openEffect : 'elastic',
                openSpeed  : 150,

                closeEffect : 'elastic',
                closeSpeed  : 150,

                closeClick : true,

                helpers : {
                    overlay : null
                }
            });

            /*
             *  Button helper. Disable animations, hide close button, change title type and content
             */

            $('.fancybox-buttons').fancybox({
                openEffect  : 'none',
                closeEffect : 'none',

                prevEffect : 'none',
                nextEffect : 'none',

                closeBtn  : false,

                helpers : {
                    title : {
                        type : 'inside'
                    },
                    buttons : {}
                },

                afterLoad : function() {
                    this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
                }
            });


            /*
             *  Thumbnail helper. Disable animations, hide close button, arrows and slide to next gallery item if clicked
             */

            $('.fancybox-thumbs').fancybox({
                prevEffect : 'none',
                nextEffect : 'none',

                closeBtn  : false,
                arrows    : false,
                nextClick : true,

                helpers : {
                    thumbs : {
                        width  : 50,
                        height : 50
                    }
                }
            });

            /*
             *  Media helper. Group items, disable animations, hide arrows, enable media and button helpers.
            */
            $('.fancybox-media')
                .attr('rel', 'media-gallery')
                .fancybox({
                    openEffect : 'none',
                    closeEffect : 'none',
                    prevEffect : 'none',
                    nextEffect : 'none',

                    arrows : false,
                    helpers : {
                        media : {},
                        buttons : {}
                    }
                });

            /*
             *  Open manually
             */

            $("#fancybox-manual-a").click(function() {
                $.fancybox.open('1_b.jpg');
            });

            $("#fancybox-manual-b").click(function() {
                $.fancybox.open({
                    href : 'iframe.html',
                    type : 'iframe',
                    padding : 5
                });
            });

            $("#fancybox-manual-c").click(function() {
                $.fancybox.open([
                    {
                        href : '1_b.jpg',
                        title : 'My title'
                    }, {
                        href : '2_b.jpg',
                        title : '2nd title'
                    }, {
                        href : '3_b.jpg'
                    }
                ], {
                    helpers : {
                        thumbs : {
                            width: 75,
                            height: 50
                        }
                    }
                });
            });


        });
    </script>
    <style type="text/css">
        .fancybox-custom .fancybox-skin {
            *box-shadow: 0 0 50px #222;
        }
    </style>
    
    <script>
    $(function() {
    // OPACITY OF BUTTON SET TO 0%
    $(".roll").css("opacity","0");
     
    // ON MOUSE OVER
    $(".roll").hover(function () {
     
    // SET OPACITY TO 70%
    $(this).stop().animate({
    opacity: .7
    }, "fast");
    },
                  
     
    // ON MOUSE OUT
    function () {
     
    // SET OPACITY BACK TO 50%
    $(this).stop().animate({
    opacity: 0
    }, "slow");
    });
    });
    </script>
    
    <? } ?>
      
    <script src="assets/jquery-vertical-sidenav-accordeon/js/sidebar-accordion.js"></script>
    <script src="assets/AdminLTE-3.1.0/dist/js/adminlte.js"></script>
    <script type="text/javascript">

    var socket;
    
    // initWebSocket();

    function initWebSocket() {
      // socket = new WebSocket('<?=$this->config->item('base_websocket')?>?token=<?=$this->TOKEN_USER_LOGIN?>');
       socket = new WebSocket('<?=$this->config->item('base_websocket')?>?token=<?=$this->TOKEN_USER_LOGIN?>');


      socket.onopen = function(e) {
        console.log('onopen', e);
        socket.onclose = function(event) {
          if(event.reason != "force_close"){
            initWebSocket();
          }
          console.log('onclose', event);
        };
      };

      socket.onerror = function(error) {
        console.log('onerror', error);
        initWebSocket();
      };
    }

    $(window).scroll(function(){
        if ($(this).scrollTop() > 50) {
            $('.judul-halaman').addClass('stickyClass');
            $('#bluemenu.aksi-area').addClass('stickyClass');
            $('#example_filter.dataTables_filter').addClass('stickyClass');

        } else {
            $('.judul-halaman').removeClass('stickyClass');
            $('#bluemenu.aksi-area').removeClass('stickyClass');
            $('#example_filter.dataTables_filter').removeClass('stickyClass');
        }
    });
    </script>
    
    <div id="myModal" class="modal fade modal-lupa-password" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><strong>Ubah Password</strong></h4>
          </div>
          <div class="modal-body">
              <form class="form-horizontal">
                <?
                if(!empty($this->USER_LOGIN_ID_APP))
                {
                ?>
                  <div class="form-group">
                      <label class="control-label col-sm-4" for="nid">Password Baru</label>
                      <div class="col-sm-8">
                          <input type="password" class="form-control" id="password" placeholder="Masukkan password baru">
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label col-sm-4" for="nid">Ulangi Password</label>
                      <div class="col-sm-8">
                          <input type="password" class="form-control" id="password2" placeholder="Ulangi password baru">
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label col-sm-4 tombol" >&nbsp;</label>
                      <div class="col-sm-8">
                          <button class="btn btn-primary" type="button" onclick="ubahPassword()"><span id="spanLogin">Submit</span><div id="spanLoading" class="loader" style="display:none">Loading...</div></button>
                      </div>
                  </div>

                  <script type="text/javascript">
                                      
                        function ubahPassword()
                        {

                            var password  = $("#password").val();
                            var password2 = $("#password2").val();

                            if(password.trim() == "")
                            {
                                $.messager.alert('Info', 'Masukkan password baru anda terlebih dahulu.', 'warning');   
                                return;
                            }

                            if(password2.trim() == "")
                            {
                                $.messager.alert('Info', 'Masukkan konfirmasi password baru anda terlebih dahulu.', 'warning');   
                                return;
                            }


                            if(password2.trim() == password.trim())
                            {}
                            else
                            {
                                $.messager.alert('Info', 'Password tidak sesuai.', 'warning');   
                                return;                            
                            }


                            var win = $.messager.progress({
                                title:'ICARLA | PT Pembangkitan Jawa-Bali',
                                msg:'proses...'
                            });             
                            
                            $.post( "app/ubah_password", { reqPassword: password })
                              .done(function( data ) {

                                    $.messager.progress('close');

                                    $("#nid").val("");

                                    data = JSON.parse(data);

                                    if(data.status == 'success')
                                       $.messager.alertLink('Info', data.message, 'info', 'app');
                                    else
                                       $.messager.alert('Info', data.message, 'warning');

                              });
                        }
                  </script>
                <?
                }
                ?>
              </form>

                <br>

                <div class="alert alert-danger">
                    <strong>Ubah password hanya bagi pengguna eksternal!</strong>
                </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>
    


    <div id="myModalEAM" class="modal fade modal-lupa-password" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><strong>Konfigurasi Akun EAM</strong></h4>
          </div>
          <div class="modal-body">
              <form class="form-horizontal">
                
                <?
                    // $sql = " SELECT  a.distrik_id, a.pegawai_id, b.workgroup, c.nama distrik, b.user_login, b.user_password, 
                    //                 b.position_id, b.position_nama,
                    //                 c.orgid, c.siteid, c.eam
                    //          FROM pegawai a 
                    //          left join user_login_eam b on a.pegawai_id =  b.pegawai_id 
                    //          left join distrik c on a.distrik_id = c.distrik_id
                    //          WHERE a.pegawai_id = '".$this->NRP."' ";
                    // $rowResult = $this->db->query($sql)->row();
                    if(!empty($rowResult->eam))
                    {
                ?>
                  <div class="form-group">
                      <label class="control-label col-sm-4" for="nid">EAM</label>
                      <div class="col-sm-8" style="margin-top: 7px;">
                         <?=$rowResult->eam?>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label col-sm-4" for="nid">ORG ID</label>
                      <div class="col-sm-8" style="margin-top: 7px;">
                         <?=$rowResult->orgid?>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label col-sm-4" for="nid">SITE ID</label>
                      <div class="col-sm-8" style="margin-top: 7px;">
                         <?=$rowResult->siteid?>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label col-sm-4" for="nid">EMPLOYEE ID</label>
                      <div class="col-sm-8" style="margin-top: 7px;">
                         <?=coalesce($this->EMPLOYEE_ID, $this->ID)?>
                      </div>
                  </div>
                  <?
                  if($rowResult->eam == "ELLIPSE")
                  {
                  ?>
                  <div class="form-group">
                      <label class="control-label col-sm-4" for="nid">POSITION ID</label>
                      <div class="col-sm-8" style="margin-top: 7px;">
                         <?=$rowResult->position_id?> - <?=$rowResult->position_nama?>
                      </div>
                  </div>
                  <?
                  }
                  ?>
                  <div class="form-group">
                      <label class="control-label col-sm-4" for="nid">User EAM</label>
                      <div class="col-sm-8">
                          <input type="text" class="form-control" id="reqUserEAM" placeholder="Masukkan username EAM" value="<?=$rowResult->user_login?>">
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label col-sm-4" for="nid">Password EAM</label>
                      <div class="col-sm-8">
                          <input type="password" class="form-control" id="reqPasswordEAM" placeholder="Masukkan password EAM" value="<?=$rowResult->user_password?>">
                      </div>
                  </div>
                  <div class="form-group" id="divPositionId" style="display:none">
                      <label class="control-label col-sm-4" for="nid">Position ID</label>
                      <div class="col-sm-8">
                          <select id="position_id">
                          </select>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label col-sm-4 tombol" >&nbsp;</label>
                      <div class="col-sm-8">
                          <button class="btn btn-primary" type="button" onclick="ubahEAM()"><span id="spanLogin">Submit</span><div id="spanLoading" class="loader" style="display:none">Loading...</div></button>
                      </div>
                  </div>

                  <script type="text/javascript">

                        <?
                        if($rowResult->user_login == "")
                        {
                            if(stristr($this->USER_TYPE, "VIEWER") || stristr($this->USER_TYPE, "REVIEW"))
                            {}
                            else
                            {
                        ?>
                                $( document ).ready(function() {
                                    $("#btnEAM").click();
                                });
                        <?
                            }
                        }
                        ?>
                                      
                        function ubahEAM()
                        {

                            var password  = $("#reqPasswordEAM").val();
                            var username = $("#reqUserEAM").val();
                            var position_id  = $("#position_id").val();
                            var position_nama  = "";

                            if(position_id == "")
                            {}
                            else
                                position_nama = $('#position_id option:selected').text();



                            if(password.trim() == "")
                            {
                                $.messager.alert('Info', 'Masukkan password anda terlebih dahulu.', 'warning');   
                                return;
                            }

                            if(username.trim() == "")
                            {
                                $.messager.alert('Info', 'Masukkan username anda terlebih dahulu.', 'warning');   
                                return;
                            }



                            var win = $.messager.progress({
                                title:'ICARLA | PT Pembangkitan Jawa-Bali',
                                msg:'proses...'
                            });             
                            
                            $.post( "app/ubah_eam", { reqUsername: username, reqPassword: password, reqEAM: "<?=$rowResult->eam?>", reqPositionID: position_id, reqPositionNama: position_nama })
                              .done(function( data ) {

                                    $.messager.progress('close');

                                    $("#nid").val("");

                                    data = JSON.parse(data);

                                    if(data.status == 'success')
                                    {
                                        if(data.jumlah_posisi == "1")
                                            $.messager.alertLink('Info', data.message, 'info', 'app');
                                        else
                                        {

                                           $.messager.alert('Info', data.message, 'info');

                                            $("#divPositionId").show();

                                           
                                            jQuery.each(data.arr_position, function(i, val) {

                                                $('#position_id').append(`<option value="`+val.ns1name+`">`+val.ns1value+`</option>`);

                                            });

                                        }
                                    }
                                    else
                                       $.messager.alert('Info', data.message, 'warning');

                              });
                        }
                  </script>
              </form>
              <?
              }
              else
              {
              ?>
                <div class="alert alert-danger">
                    <strong>EAM <?=$rowResult->distrik?> belum dikonfigurasi</strong>
                </div>
              <?
                }
              ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>
</body>
</html>