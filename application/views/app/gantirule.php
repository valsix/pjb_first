<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$arrpilihanmulti= explode(",", $this->appuserpilihankodehak);
// print_r($arrpilihanmulti);exit;
$appuserkodehak= $this->appuserkodehak;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>PLN NP FIRST</title>
    <base href="<?=base_url();?>" />
    
    <script type="text/javascript" src="assets/vegas/jquery-3.7.1.min.js"></script>
    <link href="assets/bootstrap-4.1.2/docs/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/bootstrap-4.1.2/docs/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="assets/bootstrap-4.1.2/docs/examples/signin/signin.css" rel="stylesheet">
    <script src="assets/bootstrap-4.1.2/docs/assets/js/ie-emulation-modes-warning.js"></script>
    <link rel="stylesheet" href="css/gaya-egateway_lawas.css" type="text/css">
          
    <style>
    body{
        margin-bottom: 0px !important;
        background: #eef3f5 url(images/bg-abstract-corner.png) top right no-repeat;
        background-size: 805px auto;
    }
        #myModal.modal {
            position: fixed;
        }
        .modal-title {
            color: #333333;
            text-align: left;
        }
        .modal-body {
            color: #333333;
            text-align: left;
        }
        h4.modal-title strong {
            font-family: 'avenir-next-demibold';
            font-size: 18px;
        }
    </style>
    
  </head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5 area-login-kiri">
                <div class="inner">
                    <div class="logo"><img src="images/logo-pjb.png"></div>
                    <h3>First</h3>
                    <p></p>
                </div>
            </div>
            <div class="col-md-7 area-login-kanan">
                <form class="form-signin bg-blur" action="app/ubahrule" method="post">
                    <h2 class="form-signin-heading">Ganti Role</h2>
                    <select class="form-control" name="reqhak">
                      <?php
                      foreach ($arrpilihanmulti as $valkey => $valitem) 
                      {
                        $selected = '';
                        if($appuserkodehak == $valitem)
                        {
                          $selected = "selected";
                        }

                        echo "<option $selected value='".$valitem."'>".$valitem."</option>";
                      }
                      ?>
                    </select>
                    <br/>
                    <button class="btn btn-lg btn-block" type="submit">Change Role</button>
                </form>
            </div>
        </div>
    </div>
    
    <script src="assets/bootstrap-4.1.2/docs/assets/js/ie10-viewport-bug-workaround.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="assets/easyui/themes/icon.css">
    <script type="text/javascript" src="assets/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="assets/easyui/globalfunction.js"></script>

    <script language='JavaScript' type='text/javascript'>
        $('#reqCapcha').on('change', function() {
            var val = this.value;
            var capcha = $("#capcha").val();
            if (capcha !== val) {
            }
        });
        $(document).ready(function() {
            $('#reqCapcha').keyup(function() {
                this.value = this.value.toUpperCase();
            });

            refreshing_Captcha();
        });

        function refreshing_Captcha() {
            $.get("login/getcapcha?", function(data) {
                var img = document.images['image_captcha'];
                img.src = "capcha/capcha.php?reqId="+data;
                $("#capcha").val(data);
            });
        }

        function buttonHandle()
        {                         
        }

        function lupaPassword()
        {
            var nid = $("#nid").val();

            if(nid.trim() == "")
            {
                $.messager.alert('Info', 'Masukkan NID anda terlebih dahulu.', 'warning');   
                return;
            }

            var win = $.messager.progress({
                title:'FIRST | PT PLN NP',
                msg:'proses...'
            });             
            
            $.post( "login/lupa_password", { reqId: nid })
            .done(function( data ) {
                $.messager.progress('close');
                $("#nid").val("");
                data = JSON.parse(data);
                if(data.status == 'success')
                    $.messager.alertLink('Info', data.message, 'info', 'login');
                else
                    $.messager.alert('Info', data.message, 'warning');
            });
        }
    </script>
    <script src="assets/bootstrap-4.1.2/dist/js/bootstrap.js"></script>

  </body>
</html>