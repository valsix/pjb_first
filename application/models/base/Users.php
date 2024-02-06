<? 
include_once(APPPATH.'/models/Entity.php');

class Users extends Entity{

  var $query;
  function Users()
  {
    $this->Entity(); 
  }


  function insert()
    {
      $this->setField("PENGGUNA_ID", $this->getNextId("PENGGUNA_ID","PENGGUNA"));

      $str = "
      INSERT INTO PENGGUNA
      (
        PENGGUNA_ID, USERNAME, NAMA, STATUS, PENGGUNA_INTERNAL_ID,TIPE,PASS
      )
      VALUES 
      (
        '".$this->getField("PENGGUNA_ID")."'
        , '".$this->getField("USERNAME")."'
        , '".$this->getField("NAMA")."'
        , '1'
        , ".$this->getField("PENGGUNA_INTERNAL_ID")."
        , '1'
        , '".$this->getField("PASS")."'
      )"; 

    $this->id= $this->getField("PENGGUNA_ID");
    $this->query= $str;
    // echo $str;exit;
    return $this->execQuery($str);
  }

  function update()
  {
    $str = "
    UPDATE PENGGUNA
    SET
    PASS= '".$this->getField("PASS")."'
    WHERE USERNAME = '".$this->getField("USERNAME")."'
    "; 
    $this->query = $str;
    // echo $str;exit;
    return $this->execQuery($str);
  }

  function selectByInternal($nid)
  {
    $str = "
    SELECT 
      A.*
    FROM pengguna_internal A
    WHERE 1=1
    AND NID = '".$nid."'
    ";
    
    $this->query = $str;
    // echo $str;exit;
    return $this->select($str);
  }

  function selectByIdPersonal($id_usr,$passwd)
  {
    $str = "
    SELECT
    A.*
    FROM pengguna A
    WHERE 1=1
    AND USERNAME= ".$id_usr." AND PASS=".$passwd."";
    
    $this->query = $str;
    // echo $str;exit;
    return $this->select($str);
  }

  function selectByCheckUser($id_usr,$passwd)
  {
    $str = "
    SELECT
    A.*
    FROM pengguna A
    WHERE 1=1
    AND USERNAME= '".$id_usr."' ";
    
    $this->query = $str;
    // echo $str;exit;
    return $this->select($str);
  }

  function selectpenggunahak($penggunaid)
  {
    $str = "
    SELECT
    A.*
    FROM pengguna_hak A
    WHERE
    PENGGUNA_HAK_ID IN (SELECT PENGGUNA_HAK_ID FROM pengguna_hak_akses WHERE PENGGUNA_ID = ".$penggunaid.")
    ";
    
    $this->query = $str;
    // echo $str;exit;
    return $this->select($str);
  }

  function selectByPenggunaDistrik($penggunaid)
  {
    $str = "
    SELECT
    A.*
    FROM pengguna_distrik A
    WHERE PENGGUNA_ID = ".$penggunaid."
    ";
    
    $this->query = $str;
    // echo $str;exit;
    return $this->select($str);
  }


  function selectByPenggunaDetail($statement="")
  {
    $str = "
    SELECT
    A.*,B.NAMA NAMA_EKT,B.FOTO
    FROM pengguna A
    LEFT JOIN pengguna_external B ON B.pengguna_external_id = A.pengguna_external_id
    WHERE 1=1
    ".$statement."
    ";
    
    $this->query = $str;
    // echo $str;exit;
    return $this->select($str);
  }

  function selectByPenggunaFoto($statement="")
  {
    $str = "
    SELECT
    A.*,B.NAMA NAMA_EKT,B.FOTO FOTO_EKT,C.NAMA_LENGKAP NAMA_INT,C.UNIT
    FROM pengguna A
    LEFT JOIN pengguna_external B ON B.pengguna_external_id = A.pengguna_external_id
    LEFT JOIN pengguna_internal C ON c.pengguna_internal_id = A.pengguna_internal_id
    WHERE 1=1
    ".$statement."
    ";
    
    $this->query = $str;
    // echo $str;exit;
    return $this->select($str);
  }

}
?>