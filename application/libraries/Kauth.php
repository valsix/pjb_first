<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'kloader.php';
include_once("libraries/nusoap-0.9.5/lib/nusoap.php");
include_once("functions/date.func.php");

class kauth {
    
    function __construct() {
        $CI =& get_instance();
        $CI->load->driver('session');
    }

    function penggunahak($penggunaid)
    {
        $CI =& get_instance();
        $CI->load->model("base/Users");

        $set= new Users();
        $set->selectpenggunahak($penggunaid);
        // echo $set->query;exit;
        $kodehak= "";
        while($set->nextRow())
        {
            if(empty($kodehak))
                $kodehak= $set->getField("KODE_HAK");
            else
                $kodehak.= ",".$set->getField("KODE_HAK");
        }
        return $kodehak;
    }

    public function cekuserapp($username,$credential) {
        $CI =& get_instance();
        $CI->load->model("base/Users");

        $username= $CI->db->escape($username);
        $credential= $CI->db->escape(md5($credential));

        $users = new Users();
        // $users->selectByIdPersonal($username, md5($credential));
        $users->selectByIdPersonal($username, $credential);
        // echo $users->query;exit;

        if($users->firstRow())
        {
            $penggunaid= $users->getField("PENGGUNA_ID");
            $CI->session->set_userdata("appuserid", $penggunaid);
            $CI->session->set_userdata("appusernama", $users->getField("NAMA"));
            $CI->session->set_userdata("appusergroupid", $users->getField("USER_GROUP_ID"));
            $CI->session->set_userdata("appuserroleid", $users->getField("ROLE_ID"));


            if($users->getField("PENGGUNA_ID") == "" || $users->getField("PENGGUNA_ID") == $username)
                return "Username atau password salah.";
            else
            {
                $pilihanmulti= $this->penggunahak($penggunaid);
                $CI->session->set_userdata("appuserpilihankodehak", $pilihanmulti);
                $arrpilihanmulti= explode(",", $pilihanmulti);
                if(count($arrpilihanmulti) > 1)
                {
                    return "multi";
                }
                else
                {
                    $CI->session->set_userdata("appuserkodehak", $pilihanmulti);
                    return "1";
                }
            }
        }
        else
            return "Username atau password";
    }

    public function unsetcekuserapp() {
        $CI =& get_instance();
        $CI->session->unset_userdata("appuserid");
        $CI->session->unset_userdata("appusernama");
        $CI->session->unset_userdata("appusergroupid");
        $CI->session->unset_userdata("appuserpilihankodehak");
        $CI->session->unset_userdata("appuserkodehak");
        $CI->session->unset_userdata("appuserroleid");
    }

    public function cekuserpersonal($username,$credential) {
        $CI =& get_instance();
        $CI->load->model("base/Users");  
        $users = new Users();
        $users->selectByIdPersonal($username, md5($credential));
        // echo $users->query;exit;
        
        if($users->firstRow())
        {
            // if( $users->getField("USER_GROUP_ID") == 1 || ($users->getField("USER_GROUP_ID") == 2 && $users->getField("PEGAWAI_ID") == "") || $users->getField("USER_LOGIN") !== $username)
            // if($users->getField("USER_GROUP_ID") == 1 || $users->getField("USER_LOGIN") !== $username || ($users->getField("USER_GROUP_ID") == 2 && $users->getField("PEGAWAI_ID") == ""))

            // $users->getField("USER_GROUP_ID") == 1 || $users->getField("USER_GROUP_ID") == 2 || 
            if($users->getField("USER_LOGIN") !== $username || $users->getField("USER_PASS") !== md5($credential))
            {
                return "Username atau password salah.";
            }
            else
            {
                $CI->session->set_userdata("personaluserid", $users->getField("PEGAWAI_ID"));
                $CI->session->set_userdata("personalusergroupid", $users->getField("USER_GROUP_ID"));
                $CI->session->set_userdata("personalusernama", $users->getField("ASESOR_NAMA"));
                $CI->session->set_userdata("personalusernosk", $users->getField("ASESOR_NO_SK"));
                $CI->session->set_userdata("personalusernip", $users->getField("NIP_BARU"));
                $CI->session->set_userdata("personaluserlogin", $users->getField("ASESOR_NAMA"));
                $CI->session->set_userdata("personaluserloginid", $users->getField("PENGGUNA_ID"));
                $CI->session->set_userdata("reqAsesorId", $users->getField("PEGAWAI_ID"));

                return "1";
            }
        }
        else
            return "Username atau password";
    }

    public function unsetcekusercatlogin() {
        $CI =& get_instance();
        $CI->session->unset_userdata("personaluserid");
        $CI->session->unset_userdata("personalusernama");
        $CI->session->unset_userdata("personalusernip");
        $CI->session->unset_userdata("personaluserlogin");
        $CI->session->unset_userdata("personaluserloginid");
        $CI->session->unset_userdata("reqAsesorId");
    }

     public function unsetcekuserpersonal() {
        $CI =& get_instance();
        $CI->session->unset_userdata("personaluserid");
        $CI->session->unset_userdata("personalusergroupid");
        $CI->session->unset_userdata("personalusernama");
        $CI->session->unset_userdata("personalusernip");
        $CI->session->unset_userdata("personaluserlogin");
        $CI->session->unset_userdata("personaluserloginid");
        $CI->session->unset_userdata("reqAsesorId");
    }

    public function cekusercustomer($username,$credential) {
        $CI =& get_instance();
        $CI->load->model("base/Users");  
        $users = new Users();
        $users->selectByIdPersonal($username, md5($credential));
        // echo $users->query;exit;
        
        if($users->firstRow())
        {
            if($users->getField("USER_GROUP_ID") !== "5" || $users->getField("USER_LOGIN") !== $username || $users->getField("USER_PASS") !== md5($credential))
            {
                // echo $users->getField("USER_GROUP_ID")."<br/>";
                // echo $users->getField("USER_LOGIN")." !== ".$username."<br/>";
                // echo $users->getField("USER_PASS")." !== ".md5($credential)."<br/>";
                // exit;
                return "Username atau password salah.";
            }
            else
            {
                $CI->session->set_userdata("customeruserid", $users->getField("PEGAWAI_ID"));
                $CI->session->set_userdata("customerusergroupid", $users->getField("USER_GROUP_ID"));
                $CI->session->set_userdata("customerusernama", $users->getField("ASESOR_NAMA"));
                $CI->session->set_userdata("customerusernosk", $users->getField("ASESOR_NO_SK"));
                $CI->session->set_userdata("customerusernip", $users->getField("NIP_BARU"));
                $CI->session->set_userdata("customeruserlogin", $users->getField("ASESOR_NAMA"));
                $CI->session->set_userdata("customeruserloginid", $users->getField("PENGGUNA_ID"));
                // $CI->session->set_userdata("reqAsesorId", $users->getField("PEGAWAI_ID"));

                return "1";
            }
        }
        else
            return "Username atau password";
    }

    public function unsetcekusercustomer() {
        $CI =& get_instance();
        $CI->session->unset_userdata("customeruserid");
        $CI->session->unset_userdata("customerusergroupid");
        $CI->session->unset_userdata("customerusernama");
        $CI->session->unset_userdata("customerusernip");
        $CI->session->unset_userdata("customeruserlogin");
        $CI->session->unset_userdata("customeruserloginid");
        // $CI->session->unset_userdata("reqAsesorId");
    }

    function settingcapcha($kode){
        $CI =& get_instance();
        $CI->session->unset_userdata("capchalogin");
        $CI->session->set_userdata("capchalogin", $kode);
    }

}
?>