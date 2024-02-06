<? 
include_once(APPPATH.'/models/Entity.php');

class Direktorat extends Entity { 

	var $query;

    function Direktorat()
	{
      	$this->Entity(); 
    }


    function insert()
    {
    	$this->setField("DIREKTORAT_ID", $this->getNextId("DIREKTORAT_ID","DIREKTORAT"));

    	$str = "
    	INSERT INTO DIREKTORAT
    	(
    		DIREKTORAT_ID,NAMA, LAST_CREATE_USER,LAST_CREATE_DATE,KODE
    	)
    	VALUES 
    	(
    		".$this->getField("DIREKTORAT_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, '".$this->getField("KODE")."'
	    )"; 

	    $this->id= $this->getField("DIREKTORAT_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function insertwilayah()
    {
    	$this->setField("DIREKTORAT_WILAYAH_ID", $this->getNextId("DIREKTORAT_WILAYAH_ID","DIREKTORAT_WILAYAH"));

    	$str = "
    	INSERT INTO DIREKTORAT_WILAYAH
    	(
    		DIREKTORAT_WILAYAH_ID,WILAYAH_ID,DIREKTORAT_ID
    	)
    	VALUES 
    	(
    		".$this->getField("DIREKTORAT_WILAYAH_ID")."
	    	, ".$this->getField("WILAYAH_ID")."
	    	, ".$this->getField("DIREKTORAT_ID")."
	    )"; 

	    $this->id= $this->getField("DIREKTORAT_WILAYAH_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function insertdistrik()
    {
    	$this->setField("DIREKTORAT_DISTRIK_ID", $this->getNextId("DIREKTORAT_DISTRIK_ID","DIREKTORAT_DISTRIK"));

    	$str = "
    	INSERT INTO DIREKTORAT_DISTRIK
    	(
    		DIREKTORAT_DISTRIK_ID,DISTRIK_ID,DIREKTORAT_ID
    	)
    	VALUES 
    	(
    		".$this->getField("DIREKTORAT_DISTRIK_ID")."
	    	, ".$this->getField("DISTRIK_ID")."
	    	, ".$this->getField("DIREKTORAT_ID")."
	    )"; 

	    $this->id= $this->getField("DIREKTORAT_DISTRIK_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE DIREKTORAT
		SET
		NAMA= '".$this->getField("NAMA")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
		, KODE= '".$this->getField("KODE")."'
		WHERE DIREKTORAT_ID = '".$this->getField("DIREKTORAT_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}

	function update_status()
	{
		$str = "
		UPDATE DIREKTORAT
		SET
		STATUS = ".$this->getField("STATUS")."
		WHERE DIREKTORAT_ID = '".$this->getField("DIREKTORAT_ID")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM DIREKTORAT
		WHERE 
		DIREKTORAT_ID = ".$this->getField("DIREKTORAT_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deletewilayah()
	{
		$str = "
		DELETE FROM DIREKTORAT_WILAYAH
		WHERE 
		DIREKTORAT_ID = ".$this->getField("DIREKTORAT_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deletedistrik()
	{
		$str = "
		DELETE FROM DIREKTORAT_DISTRIK
		WHERE 
		DIREKTORAT_ID = ".$this->getField("DIREKTORAT_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY DIREKTORAT_ID ASC")
	{
		$str = "
			SELECT 
				A.*,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
				, B.WILAYAH_ID_INFO
				, B.DIREKTORAT_WILAYAH_ID_INFO
				, C.DISTRIK_ID_INFO
				, C.DIREKTORAT_DISTRIK_ID_INFO
			FROM DIREKTORAT A
			LEFT JOIN 
			(
				SELECT A.DIREKTORAT_ID
				,STRING_AGG(A.WILAYAH_ID::TEXT, ', ') AS WILAYAH_ID_INFO
				,STRING_AGG(A.DIREKTORAT_WILAYAH_ID::TEXT, ', ') AS DIREKTORAT_WILAYAH_ID_INFO
				FROM DIREKTORAT_WILAYAH A
				GROUP BY A.DIREKTORAT_ID
			) B ON B.DIREKTORAT_ID = A.DIREKTORAT_ID
			LEFT JOIN 
			(
				SELECT A.DIREKTORAT_ID
				,STRING_AGG(A.DISTRIK_ID::TEXT, ', ') AS DISTRIK_ID_INFO
				,STRING_AGG(A.DIREKTORAT_DISTRIK_ID::TEXT, ', ') AS DIREKTORAT_DISTRIK_ID_INFO
				FROM DIREKTORAT_DISTRIK A
				GROUP BY A.DIREKTORAT_ID
			) C ON C.DIREKTORAT_ID = A.DIREKTORAT_ID
			WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
	}


	function selectByParamsCombo($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY DIREKTORAT_ID ASC")
	{
		$str = "
			SELECT 
				A.*,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
				, B.NAMA WILAYAH_NAMA
			FROM DIREKTORAT A
			INNER JOIN WILAYAH B ON  B.DIREKTORAT_ID = A.DIREKTORAT_ID
			WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
	}


} 
?>