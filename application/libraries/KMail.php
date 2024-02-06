<?
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

//include_once 'class.phpmailer.php';
// require 'mail/PHPMailerAutoload.php';

class KMail extends PHPMailer{
    function __construct($exceptions = false) {
        parent::__construct($exceptions);
        
        $CI =& get_instance();
        $infoemail= $CI->config->config["infoemail"];
        // print_r($infoemail);exit;

        $Hostname= $infoemail["Host"];
        $Port= $infoemail["Port"];
        $SMTPAuth= $infoemail["SMTPAuth"];
        $Username= $infoemail["Username"];
        $Password= $infoemail["Password"];
        $From= $infoemail["From"];
        $FromName= $infoemail["FromName"];

        $this->IsSMTP();
        $this->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        
        $this->SMTPDebug = 0;
        //Ask for HTML-friendly debug output

        $this->Host= $Hostname;
        $this->Port= $Port;
        $this->SMTPAuth= true;
        $this->Username= $Username;
        $this->Password= $Password;
        $this->From= $From;
        $this->FromName= $FromName;

        $this->SMTPSecure  = "TLS";
        $this->SMTPAutoTLS = true;

        $this->WordWrap= 50;
        $this->Priority= 1;
        $this->CharSet= "UTF-8";
        $this->IsHTML(TRUE);
        $this->AltBody= "To view the message, please use an HTML compatible email viewer!";
    }
}
?>