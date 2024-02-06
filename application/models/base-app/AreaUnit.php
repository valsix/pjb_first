<? 
include_once(APPPATH.'/models/Entity.php');

class AreaUnit extends Entity { 

	var $query;

    function AreaUnit()
	{
      	$this->Entity(); 
    }


    function insert()
    {
    	$this->setField("AREA_UNIT_ID", $this->getNextId("AREA_UNIT_ID","AREA_UNIT"));

    	$str = "
    	INSERT INTO AREA_UNIT
    	(
    		AREA_UNIT_ID,DISTRIK_ID,NAMA,TERSEDIA,STATUS_KONFIRMASI,LAST_CREATE_USER,LAST_CREATE_DATE,KODE,BLOK_UNIT_ID,UNIT_MESIN_ID,KODE_DUPLIKAT
    	)
    	VALUES 
    	(
    		".$this->getField("AREA_UNIT_ID")."
    		, ".$this->getField("DISTRIK_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, ".$this->getField("TERSEDIA")."
	    	, ".$this->getField("STATUS_KONFIRMASI")."
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, '".$this->getField("KODE")."'
	    	, ".$this->getField("BLOK_UNIT_ID")."
	    	, ".$this->getField("UNIT_MESIN_ID")."
	    	, '".$this->getField("KODE_DUPLIKAT")."'
	    )"; 

	    $this->id= $this->getField("AREA_UNIT_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function insertarea()
    {
    	$this->setField("AREA_UNIT_AREA_ID", $this->getNextId("AREA_UNIT_AREA_ID","AREA_UNIT_AREA"));

    	$str = "
    	INSERT INTO AREA_UNIT_AREA
    	(
    		AREA_UNIT_AREA_ID,LIST_AREA_ID,AREA_UNIT_ID
    	)
    	VALUES 
    	(
    		".$this->getField("AREA_UNIT_AREA_ID")."
    		, ".$this->getField("LIST_AREA_ID")."
    		, ".$this->getField("AREA_UNIT_ID")."
	    )"; 

	    $this->id= $this->getField("AREA_UNIT_AREA_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function insertdetil()
    {
    	$this->setField("AREA_UNIT_DETIL_ID", $this->getNextId("AREA_UNIT_DETIL_ID","AREA_UNIT_DETIL"));

    	$str = "
    	INSERT INTO area_unit_detil
    	(
    		AREA_UNIT_DETIL_ID,LIST_AREA_ID,AREA_UNIT_ID,STATUS_KONFIRMASI,ITEM_ASSESSMENT_DUPLIKAT_ID,NAMA
    	)
    	VALUES 
    	(
    		".$this->getField("AREA_UNIT_DETIL_ID")."
    		, ".$this->getField("LIST_AREA_ID")."
    		, ".$this->getField("AREA_UNIT_ID")."
    		, ".$this->getField("STATUS_KONFIRMASI")."
    		, ".$this->getField("ITEM_ASSESSMENT_DUPLIKAT_ID")."
    		, '".$this->getField("NAMA")."'
	    )"; 

	    $this->id= $this->getField("AREA_UNIT_DETIL_ID");
	    $this->query= $str;
			// echo $str;
	    return $this->execQuery($str);
	}

	function update_detil()
	{
		$str = "
		UPDATE AREA_UNIT_DETIL
		SET
		 STATUS_KONFIRMASI= ".$this->getField("STATUS_KONFIRMASI")."
		, NAMA= '".$this->getField("NAMA")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
		WHERE AREA_UNIT_DETIL_ID = '".$this->getField("AREA_UNIT_DETIL_ID")."' AND AREA_UNIT_ID = '".$this->getField("AREA_UNIT_ID")."' 
		";  
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}


	function update()
	{
		$str = "
		UPDATE AREA_UNIT
		SET
		NAMA= '".$this->getField("NAMA")."'
		, DISTRIK_ID= ".$this->getField("DISTRIK_ID")."
		, TERSEDIA= ".$this->getField("TERSEDIA")."
		, STATUS_KONFIRMASI= ".$this->getField("STATUS_KONFIRMASI")."
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
		, KODE= '".$this->getField("KODE")."'
		, BLOK_UNIT_ID= ".$this->getField("BLOK_UNIT_ID")."
		, UNIT_MESIN_ID= ".$this->getField("UNIT_MESIN_ID")."
		, KODE_DUPLIKAT= '".$this->getField("KODE_DUPLIKAT")."'
		WHERE AREA_UNIT_ID = '".$this->getField("AREA_UNIT_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}

	function update_status()
	{
		$str = "
		UPDATE AREA_UNIT
		SET
		STATUS = ".$this->getField("STATUS")."
		WHERE AREA_UNIT_ID = '".$this->getField("AREA_UNIT_ID")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM AREA_UNIT
		WHERE 
		AREA_UNIT_ID = ".$this->getField("AREA_UNIT_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}


	function deleteareaall()
	{
		$str = "
		DELETE FROM area_unit_area
		WHERE 
		AREA_UNIT_ID = ".$this->getField("AREA_UNIT_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}


	function deletedetilall()
	{
		$str = "
		DELETE FROM area_unit_detil
		WHERE 
		AREA_UNIT_ID = ".$this->getField("AREA_UNIT_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deleteareasingle()
	{
		$str = "
		DELETE FROM area_unit_area
		WHERE 
		AREA_UNIT_ID = ".$this->getField("AREA_UNIT_ID")."
		AND
		LIST_AREA_ID = ".$this->getField("LIST_AREA_ID")."
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deletedetilsingle()
	{
		$str = "
		DELETE FROM area_unit_detil
		WHERE 
		AREA_UNIT_ID = ".$this->getField("AREA_UNIT_ID")." 
		AND
		LIST_AREA_ID = ".$this->getField("LIST_AREA_ID")."
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.DISTRIK_ID ASC")
	{
		$str = "
			SELECT	A.*,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
				, C.NAMA DISTRIK_NAMA
				, CASE WHEN A.TERSEDIA = 1 THEN 'Iya' WHEN A.TERSEDIA = 2 THEN 'Tidak' ELSE 'Belum Didefinisikan' END TERSEDIA_INFO
				, E.NAMA PERUSAHAAN_NAMA
				, F.NAMA BLOK_NAMA
				, G.NAMA UNIT_NAMA
				, D.LIST_AREA_ID_INFO
				, D.LIST_AREA_NAMA_INFO
			FROM AREA_UNIT A 
			LEFT JOIN DISTRIK C ON C.DISTRIK_ID= A.DISTRIK_ID
			LEFT JOIN
			(
				SELECT 
					A.AREA_UNIT_ID
					,STRING_AGG(A.LIST_AREA_ID::TEXT, ', ') AS LIST_AREA_ID_INFO
					,STRING_AGG(B.NAMA::TEXT, ', ') AS LIST_AREA_NAMA_INFO
				FROM area_unit_area A
				INNER JOIN LIST_AREA B ON B.LIST_AREA_ID = A.LIST_AREA_ID
				GROUP BY A.AREA_UNIT_ID
			) D ON D.AREA_UNIT_ID = A.AREA_UNIT_ID
			LEFT JOIN PERUSAHAAN_EKSTERNAL E ON E.PERUSAHAAN_EKSTERNAL_ID= C.PERUSAHAAN_EKSTERNAL_ID 
			LEFT JOIN BLOK_UNIT F ON F.BLOK_UNIT_ID = A.BLOK_UNIT_ID
			LEFT JOIN UNIT_MESIN G ON G.UNIT_MESIN_ID = A.UNIT_MESIN_ID
			
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

	function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.DISTRIK_ID ASC")
	{
		$str = "
			SELECT	A.AREA_UNIT_ID,A.STATUS,A.TERSEDIA,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
				, C.DISTRIK_ID
				, C.NAMA DISTRIK_NAMA
				, CASE WHEN A.TERSEDIA = 1 THEN 'Iya' WHEN A.TERSEDIA = 2 THEN 'Tidak' ELSE 'Belum Didefinisikan' END TERSEDIA_INFO
				, E.NAMA PERUSAHAAN_NAMA
				, F.BLOK_UNIT_ID
				, F.NAMA BLOK_NAMA
				, G.UNIT_MESIN_ID
				, G.NAMA UNIT_NAMA
			FROM DISTRIK C
			INNER JOIN BLOK_UNIT F ON F.DISTRIK_ID = C.DISTRIK_ID
			INNER JOIN UNIT_MESIN G ON G.BLOK_UNIT_ID = F.BLOK_UNIT_ID 
			LEFT JOIN AREA_UNIT A ON A.DISTRIK_ID= C.DISTRIK_ID AND A.BLOK_UNIT_ID =  F.BLOK_UNIT_ID AND A.UNIT_MESIN_ID =  G.UNIT_MESIN_ID
			LEFT JOIN PERUSAHAAN_EKSTERNAL E ON E.PERUSAHAAN_EKSTERNAL_ID= C.PERUSAHAAN_EKSTERNAL_ID 
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


	function selectByParamsDistrikFilter($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.DISTRIK_ID ASC")
	{
		$str = "
			SELECT 
				A.*
				, B.NAMA DISTRIK_NAMA
			FROM AREA_UNIT A 
			INNER JOIN DISTRIK B ON B.DISTRIK_ID= A.DISTRIK_ID 
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


	function selectByParamsAreaFilter($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY B.LIST_AREA_ID ASC")
	{
		$str = "
			SELECT 
				 B.LIST_AREA_ID,B.NAMA AREA_NAMA
			FROM AREA_UNIT A 
			INNER JOIN LIST_AREA B ON B.LIST_AREA_ID= A.LIST_AREA_ID 
			WHERE 1=1
			
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY B.LIST_AREA_ID ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
	}


    function getCountByParams($paramsArray=array(),$statement='')
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
		FROM list_area a
		WHERE 1 = 1  ".$statement; 
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


   
	
} 
?>