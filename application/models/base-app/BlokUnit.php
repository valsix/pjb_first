<? 
  include_once(APPPATH.'/models/Entity.php');

  class BlokUnit extends Entity{ 

	var $query;

    function BlokUnit()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	$this->setField("BLOK_UNIT_ID", $this->getNextId("BLOK_UNIT_ID","blok_unit"));

    	$str = "
    	INSERT INTO blok_unit
    	(
    		BLOK_UNIT_ID, NAMA, DISTRIK_ID,JENIS_UNIT_KERJA_ID
    	)
    	VALUES 
    	(
	    	'".$this->getField("BLOK_UNIT_ID")."'
	    	, '".$this->getField("NAMA")."'
	    	, ".$this->getField("DISTRIK_ID")."
	    	, ".$this->getField("JENIS_UNIT_KERJA_ID")."
	    )"; 

		$this->id= $this->getField("BLOK_UNIT_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE blok_unit
		SET
		 NAMA= '".$this->getField("NAMA")."'
		, DISTRIK_ID= ".$this->getField("DISTRIK_ID")."
		, JENIS_UNIT_KERJA_ID= ".$this->getField("JENIS_UNIT_KERJA_ID")."
		WHERE BLOK_UNIT_ID = '".$this->getField("BLOK_UNIT_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update_status()
	{
		$str = "
		UPDATE blok_unit
		SET
		STATUS = ".$this->getField("STATUS")."
		WHERE BLOK_UNIT_ID = '".$this->getField("BLOK_UNIT_ID")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM blok_unit
		WHERE 
		BLOK_UNIT_ID = ".$this->getField("BLOK_UNIT_ID").""; 

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $blok_unitment='', $sOrder="ORDER BY BLOK_UNIT_ID ASC")
	{
		$str = "
		SELECT 
			A.*,B.NAMA DISTRIK_NAMA,
			CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
			, C.NAMA JENIS_NAMA
		FROM blok_unit A
		INNER JOIN DISTRIK B ON B.DISTRIK_ID = A.DISTRIK_ID
		LEFT JOIN JENIS_UNIT_KERJA C ON C.JENIS_UNIT_KERJA_ID = A.JENIS_UNIT_KERJA_ID
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $blok_unitment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function getCountByParams($paramsArray=array())
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
		FROM blok_unit A
		INNER JOIN DISTRIK B ON B.DISTRIK_ID = A.DISTRIK_ID
		WHERE 1 = 1  "; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }



    function selectByParamHirarki($paramsArray=array(),$limit=-1,$from=-1, $blok_unitment='', $sOrder="ORDER BY BLOK_UNIT_ID ASC")
	{
		$str = "
		SELECT 
			A.*,B.NAMA DISTRIK_NAMA,
			CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
			, C.NAMA UNIT_NAMA
		FROM blok_unit A
		INNER JOIN DISTRIK B ON B.DISTRIK_ID = A.DISTRIK_ID
		LEFT JOIN UNIT_MESIN C ON C.BLOK_UNIT_ID = A.BLOK_UNIT_ID AND C.DISTRIK_ID = A.DISTRIK_ID
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $blok_unitment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

  } 
?>