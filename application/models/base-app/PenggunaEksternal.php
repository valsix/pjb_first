<? 
  include_once(APPPATH.'/models/Entity.php');

  class PenggunaEksternal extends Entity{ 

	var $query;

    function PenggunaEksternal()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	$this->setField("PENGGUNA_EXTERNAL_ID", $this->getNextId("PENGGUNA_EXTERNAL_ID","pengguna_external"));

    	$str = "
    	INSERT INTO pengguna_external
    	(
    		PENGGUNA_EXTERNAL_ID,DISTRIK_ID,POSITION_ID,ROLE_ID,PERUSAHAAN_EKSTERNAL_ID, NID, NAMA, STATUS, NO_TELP, EMAIL, FOTO, PASSWORD,EXPIRED_DATE
    	)
    	VALUES 
    	(
	    	".$this->getField("PENGGUNA_EXTERNAL_ID")."
	    	, ".$this->getField("DISTRIK_ID")."
	    	, '".$this->getField("POSITION_ID")."'
	    	, ".$this->getField("ROLE_ID")."
	    	, ".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."
	    	, '".$this->getField("NID")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("STATUS")."'
	    	, ".$this->getField("NO_TELP")."
	    	, '".$this->getField("EMAIL")."'
	    	, '".$this->getField("FOTO")."'
	    	, '".$this->getField("PASSWORD")."'
	    	, ".$this->getField("EXPIRED_DATE")."
	    )"; 

		$this->id= $this->getField("PENGGUNA_EXTERNAL_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE pengguna_external
		SET
		PENGGUNA_EXTERNAL_ID= ".$this->getField("PENGGUNA_EXTERNAL_ID")."
		, DISTRIK_ID = ".$this->getField("DISTRIK_ID")."
		, POSITION_ID = '".$this->getField("POSITION_ID")."'
		, ROLE_ID = ".$this->getField("ROLE_ID")."
		, PERUSAHAAN_EKSTERNAL_ID = ".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."
		, NID = '".$this->getField("NID")."'
		, NAMA = '".$this->getField("NAMA")."'
		, STATUS = '".$this->getField("STATUS")."'
		, NO_TELP = ".$this->getField("NO_TELP")."
		, EMAIL = '".$this->getField("EMAIL")."'
		, EXPIRED_DATE = ".$this->getField("EXPIRED_DATE")."
		WHERE PENGGUNA_EXTERNAL_ID = '".$this->getField("PENGGUNA_EXTERNAL_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updateupload($field)
	{
		$str = "
		UPDATE pengguna_external
		SET
		FOTO = '".$this->getField("FOTO")."'
		WHERE PENGGUNA_EXTERNAL_ID = '".$this->getField("PENGGUNA_EXTERNAL_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function reset_password()
	{
		$str = "
		UPDATE pengguna_external
		SET
		 PASSWORD = '".$this->getField("PASSWORD")."'
		WHERE PENGGUNA_EXTERNAL_ID = '".$this->getField("PENGGUNA_EXTERNAL_ID")."';
		";

		$str .= "
		UPDATE pengguna
		SET
		 PASS = '".$this->getField("PASSWORD")."'
		WHERE PENGGUNA_EXTERNAL_ID = '".$this->getField("PENGGUNA_EXTERNAL_ID")."';
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM pengguna_external
		WHERE 
		PENGGUNA_EXTERNAL_ID = ".$this->getField("PENGGUNA_EXTERNAL_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function delete_gambar()
	{
		$str = "
		UPDATE pengguna_external
		SET
		FOTO = ''
		WHERE PENGGUNA_EXTERNAL_ID = '".$this->getField("PENGGUNA_EXTERNAL_ID")."'
		"; 
		$this->query = $str;
		return $this->execQuery($str);
	}

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $pengguna_externalment='', $sOrder="ORDER BY PENGGUNA_EXTERNAL_ID ASC")
	{
		$str = "
		SELECT 
			A.*
			,B.NAMA DISTRIK_NAMA,B.KODE || '-' || B.NAMA DISTRIK_INFO
			, D.NAMA PERUSAHAAN_EKSTERNAL_INFO,D.KODE || '-' || D.NAMA PERUSAHAAN_EKSTERNAL_INFO
			, CASE WHEN A.STATUS = '1' THEN 'Inactive' ELSE 'Aktif' END INFO_STATUS
			, C.NAMA_POSISI JABATAN_INFO
		FROM pengguna_external A
		LEFT JOIN DISTRIK B ON B.DISTRIK_ID = A.DISTRIK_ID
		LEFT JOIN MASTER_JABATAN C ON C.POSITION_ID = A.POSITION_ID
		LEFT JOIN PERUSAHAAN_EKSTERNAL D ON D.PERUSAHAAN_EKSTERNAL_ID = A.PERUSAHAAN_EKSTERNAL_ID
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $pengguna_externalment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsCekInternal($paramsArray=array(),$limit=-1,$from=-1, $pengguna_externalment='', $sOrder="ORDER BY PENGGUNA_INTERNAL_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM pengguna_internal A

		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $pengguna_externalment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

  } 
?>