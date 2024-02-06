<? 
include_once(APPPATH.'/models/Entity.php');

class Wilayah extends Entity { 

	var $query;

    function Wilayah()
	{
      	$this->Entity(); 
    }


    function insert()
    {
    	$this->setField("WILAYAH_ID", $this->getNextId("WILAYAH_ID","WILAYAH"));

    	$str = "
    	INSERT INTO WILAYAH
    	(
    		WILAYAH_ID,NAMA,LAST_CREATE_USER,LAST_CREATE_DATE,KODE
    	)
    	VALUES 
    	(
    		".$this->getField("WILAYAH_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, '".$this->getField("KODE")."'
	    )"; 

	    $this->id= $this->getField("WILAYAH_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function insertdistrik()
    {
    	$this->setField("WILAYAH_DISTRIK_ID", $this->getNextId("WILAYAH_DISTRIK_ID","WILAYAH_DISTRIK"));

    	$str = "
    	INSERT INTO WILAYAH_DISTRIK
    	(
    		WILAYAH_DISTRIK_ID,DISTRIK_ID,WILAYAH_ID
    	)
    	VALUES 
    	(
    		".$this->getField("WILAYAH_DISTRIK_ID")."
	    	, ".$this->getField("DISTRIK_ID")."
	    	, ".$this->getField("WILAYAH_ID")."
	    )"; 

	    $this->id= $this->getField("WILAYAH_DISTRIK_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE WILAYAH
		SET
		NAMA= '".$this->getField("NAMA")."'
		, KODE= '".$this->getField("KODE")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
		WHERE WILAYAH_ID = '".$this->getField("WILAYAH_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}

	function update_status()
	{
		$str = "
		UPDATE WILAYAH
		SET
		STATUS = ".$this->getField("STATUS")."
		WHERE WILAYAH_ID = '".$this->getField("WILAYAH_ID")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM WILAYAH
		WHERE 
		WILAYAH_ID = ".$this->getField("WILAYAH_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deletedistrik()
	{
		$str = "
		DELETE FROM WILAYAH_DISTRIK
		WHERE 
		WILAYAH_ID = ".$this->getField("WILAYAH_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY WILAYAH_ID ASC")
	{
		$str = "
			SELECT 
				A.*,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
				, B.DISTRIK_ID_INFO
				, B.WILAYAH_DISTRIK_ID_INFO
			FROM WILAYAH A
			LEFT JOIN 
			(
				SELECT A.WILAYAH_ID
				,STRING_AGG(A.DISTRIK_ID::TEXT, ', ') AS DISTRIK_ID_INFO
				,STRING_AGG(A.WILAYAH_DISTRIK_ID::TEXT, ', ') AS WILAYAH_DISTRIK_ID_INFO
				FROM WILAYAH_DISTRIK A
				GROUP BY A.WILAYAH_ID
			) B ON B.WILAYAH_ID = A.WILAYAH_ID 
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

	function selectByParamsCheckDistrik($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY WILAYAH_ID ASC")
	{
		$str = "
			SELECT 
				A.*,B.NAMA
			FROM WILAYAH_DISTRIK A
			INNER JOIN WILAYAH B ON B.WILAYAH_ID = A.WILAYAH_ID
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


	function selectByParamsDistrik($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
	{
		$str = "
			SELECT 
				A.*
			FROM DISTRIK A
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