<? 
  include_once(APPPATH.'/models/Entity.php');

  class PenggunaInternal extends Entity{ 

	var $query;

    function PenggunaInternal()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	$this->setField("PENGGUNA_INTERNAL_ID", $this->getNextId("PENGGUNA_INTERNAL_ID","pengguna_internal"));

    	$str = "
    	INSERT INTO pengguna_internal
    	(
    		PENGGUNA_INTERNAL_ID,DISTRIK_ID,POSITION_ID,ROLE_ID,PERUSAHAAN_EKSTERNAL_ID, NID, NAMA, STATUS, NO_TELP, EMAIL, FOTO, PASSWORD,EXPIRED_DATE
    	)
    	VALUES 
    	(
	    	".$this->getField("PENGGUNA_INTERNAL_ID")."
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

		$this->id= $this->getField("PENGGUNA_INTERNAL_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE pengguna_internal
		SET
		PENGGUNA_INTERNAL_ID= ".$this->getField("PENGGUNA_INTERNAL_ID")."
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
		WHERE PENGGUNA_INTERNAL_ID = '".$this->getField("PENGGUNA_INTERNAL_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updateupload($field)
	{
		$str = "
		UPDATE pengguna_internal
		SET
		FOTO = '".$this->getField("FOTO")."'
		WHERE PENGGUNA_INTERNAL_ID = '".$this->getField("PENGGUNA_INTERNAL_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM pengguna_internal
		WHERE 
		PENGGUNA_INTERNAL_ID = ".$this->getField("PENGGUNA_INTERNAL_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function delete_gambar()
	{
		$str = "
		UPDATE pengguna_internal
		SET
		FOTO = ''
		WHERE PENGGUNA_INTERNAL_ID = '".$this->getField("PENGGUNA_INTERNAL_ID")."'
		"; 
		$this->query = $str;
		return $this->execQuery($str);
	}

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $pengguna_internalment='', $sOrder="ORDER BY NID ASC")
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
		
		$str .= $pengguna_internalment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

  } 
?>