<? 
  include_once(APPPATH.'/models/Entity.php');

  class SumberAnggaran extends Entity{ 

	var $query;

    function SumberAnggaran()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	$this->setField("SUMBER_ANGGARAN_ID", $this->getNextId("SUMBER_ANGGARAN_ID","sumber_anggaran"));

    	$str = "
    	INSERT INTO sumber_anggaran
    	(
    		SUMBER_ANGGARAN_ID, NAMA, KODE
    	)
    	VALUES 
    	(
	    	'".$this->getField("SUMBER_ANGGARAN_ID")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("KODE")."'
	    )"; 

		$this->id= $this->getField("SUMBER_ANGGARAN_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	

	function update()
	{
		$str = "
		UPDATE sumber_anggaran
		SET
		NAMA= '".$this->getField("NAMA")."'
		, KODE= '".$this->getField("KODE")."'
		WHERE SUMBER_ANGGARAN_ID = '".$this->getField("SUMBER_ANGGARAN_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}




	function update_status()
	{
		$str = "
		UPDATE sumber_anggaran
		SET
		STATUS = ".$this->getField("STATUS")."
		WHERE SUMBER_ANGGARAN_ID = '".$this->getField("SUMBER_ANGGARAN_ID")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM sumber_anggaran
		WHERE 
		SUMBER_ANGGARAN_ID = ".$this->getField("SUMBER_ANGGARAN_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}



    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $sumber_anggaranment='', $sOrder="ORDER BY SUMBER_ANGGARAN_ID ASC")
	{
		$str = "
		SELECT 
			A.*
			,CASE WHEN A.STATUS = '1' THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
		FROM sumber_anggaran A 
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $sumber_anggaranment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }



  } 
?>