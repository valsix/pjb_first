
<?php
$hash = '$2a$06$fUA1r698CFX0rCFVhjtMF.WX3rj6hbQCAmXHtrT6vuaMjrn882GB6';

if (password_verify('admin', $hash)) {
    echo 'Password is valid!';
} else {
    echo 'Invalid password.';
}
?>
