<?
$this->load->library("crfs_protect"); $csrf = new crfs_protect('_crfs_login');

include_once("functions/string.func.php");
include_once("functions/date.func.php");

$sessappinfouser= $this->sessappinfouser;
$sessappinfopass= $this->sessappinfopass;
$sessinfopesan= $this->sessappinfopesan;
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
    <link rel="stylesheet" href="css/gaya-egateway.css" type="text/css">
          
    <style>
    	body{
    		margin-bottom: 0px !important;
            background: #eef3f5 url(images/bg-login.png) top right no-repeat;
            background-size: 100% auto;
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
            <div class="col-md-7 area-login-kiri">
                <form class="form-signin bg-blur" action="login/action" method="post">                    
                    <h2 class="form-signin-heading">Selamat datang,</h2>
                    <p>Silahkan login ke akun anda. </p>
                    
                    <label for="inputEmail" class="sr-only">Username</label>
                    <input type="text" name="reqUser" id="inputEmail" class="form-control" placeholder="Username" required value="<?=$sessappinfouser?>" />
                    
                    <label for="inputPassword" class="sr-only">Password</label>
                    <input type="password" name="reqPasswd" id="inputPassword" class="form-control" placeholder="Password" required value="<?=$sessappinfopass?>" />

                    <div class="form-group row captcha">
                        <div class="ikon col-md-6">
                            <img src="login/captcha" id='image_captcha' onclick="refreshing_Captcha();" style="height:30px">
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="reqCapcha" autocomplete="off" id="reqCapcha" class="form-control" placeholder="Kode Captcha" maxlength="5" required>
                        </div>
                    </div>
                    
                    <br>
                    <button class="btn btn-lg btn-block" type="submit">Login</button>
                    <?=$csrf->echoInputField();?>

                  <!--   <div class="lupa-password">
                        Lupa Password? Klik <a data-toggle="modal" data-target="#myModal">disini</a>.
                    </div> -->
                    
                    <div class="checkbox">
                        <label style="color:#000; font-size:15px">
                            <?=$sessinfopesan?>
                        </label>
                    </div>

                </form>
                
            </div>
            <div class="col-md-5 area-login-kanan">
				<div class="inner">
                    <div class="logo"><img src="images/logo-first.png"></div>
                    <h3>FIRST</h3>
                    <p></p>
                </div>
            </div>
        </div>
    </div>
    
    <div id="myModal" class="modal fade modal-lupa-password" role="dialog">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><strong>Lupa Password</strong></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="nid">NID</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nid" placeholder="Masukkan NID Anda yang terdaftar pada aplikasi ICARLA">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2 tombol" >&nbsp;</label>
                            <div class="col-sm-10">
                                <button class="btn btn-primary" type="button" onclick="lupaPassword()"><span id="spanLogin">Submit</span><div id="spanLoading" class="loader" style="display:none">Loading...</div></button>
                            </div>
                        </div>
                    </form>
                    <br>

                    <div class="alert alert-danger">
                        <strong>Lupa password hanya bagi pengguna eksternal silahkan kontak administrator (helpdesk.ptpjb.com) !</strong>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
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
                title:'ICARLA | PT Pembangkitan Jawa-Bali',
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