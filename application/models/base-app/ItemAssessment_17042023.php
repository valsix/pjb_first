<? 
include_once(APPPATH.'/models/Entity.php');

class ItemAssessment extends Entity { 

	var $query;

    function ItemAssessment()
	{
      	$this->Entity(); 
    }

    function insert()
    {
    	$this->setField("ITEM_ASSESSMENT_ID", $this->getNextId("ITEM_ASSESSMENT_ID","ITEM_ASSESSMENT"));

    	$str = "
    	INSERT INTO ITEM_ASSESSMENT
    	(
    		ITEM_ASSESSMENT_ID,DUPLIKAT,LAST_CREATE_USER,LAST_CREATE_DATE,KODE
    	)
    	VALUES 
    	(
    		".$this->getField("ITEM_ASSESSMENT_ID")."
    		, ".$this->getField("DUPLIKAT")."
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, '".$this->getField("KODE")."'
	    )"; 

	    $this->id= $this->getField("ITEM_ASSESSMENT_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function insertarea()
    {
    	$this->setField("ITEM_ASSESSMENT_AREA_ID", $this->getNextId("ITEM_ASSESSMENT_AREA_ID","ITEM_ASSESSMENT_AREA"));

    	$str = "
    	INSERT INTO ITEM_ASSESSMENT_AREA
    	(
    		ITEM_ASSESSMENT_AREA_ID,ITEM_ASSESSMENT_ID,LIST_AREA_ID    	
    	)
    	VALUES 
    	(
    		".$this->getField("ITEM_ASSESSMENT_AREA_ID")."
    		, ".$this->getField("ITEM_ASSESSMENT_ID")."
    		, ".$this->getField("LIST_AREA_ID")."
	    )"; 

	    $this->id= $this->getField("ITEM_ASSESSMENT_AREA_ID");
	    $this->query= $str;
		//echo $str;
	    return $this->execQuery($str);
	}

	
	function insertformulir()
    {
    	$this->setField("ITEM_ASSESSMENT_FORMULIR_ID", $this->getNextId("ITEM_ASSESSMENT_FORMULIR_ID","ITEM_ASSESSMENT_FORMULIR"));

    	$str = "
    	INSERT INTO ITEM_ASSESSMENT_FORMULIR
    	(
    		ITEM_ASSESSMENT_FORMULIR_ID,ITEM_ASSESSMENT_ID,KATEGORI_ITEM_ASSESSMENT_ID,PROGRAM_ITEM_ASSESSMENT_ID,STATUS_KONFIRMASI,NAMA,STANDAR_REFERENSI_ID
    	)
    	VALUES 
    	(
    		".$this->getField("ITEM_ASSESSMENT_FORMULIR_ID")."
    		, ".$this->getField("ITEM_ASSESSMENT_ID")."
    		, ".$this->getField("KATEGORI_ITEM_ASSESSMENT_ID")."
    		, ".$this->getField("PROGRAM_ITEM_ASSESSMENT_ID")."
    		, ".$this->getField("STATUS_KONFIRMASI")."
    		, '".$this->getField("NAMA")."'
    		, '".$this->getField("STANDAR_REFERENSI_ID")."'
	    )"; 

	    $this->id= $this->getField("ITEM_ASSESSMENT_FORMULIR_ID");
	    $this->query= $str;
			// echo $str;
	    return $this->execQuery($str);
	}

	function insertstandar()
    {
    	$this->setField("ITEM_ASSESSMENT_STANDAR_ID", $this->getNextId("ITEM_ASSESSMENT_STANDAR_ID","ITEM_ASSESSMENT_STANDAR"));

    	$str = "
    	INSERT INTO ITEM_ASSESSMENT_STANDAR
    	(
    		ITEM_ASSESSMENT_STANDAR_ID,ITEM_ASSESSMENT_FORMULIR_ID,ITEM_ASSESSMENT_ID,STANDAR_REFERENSI_ID    	
    	)
    	VALUES 
    	(
    		".$this->getField("ITEM_ASSESSMENT_STANDAR_ID")."
    		, ".$this->getField("ITEM_ASSESSMENT_FORMULIR_ID")."
    		, ".$this->getField("ITEM_ASSESSMENT_ID")."
    		, ".$this->getField("STANDAR_REFERENSI_ID")."
	    )"; 

	    $this->id= $this->getField("ITEM_ASSESSMENT_FORMULIR_ID");
	    $this->query= $str;
		// echo $str;
	    return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE ITEM_ASSESSMENT
		SET
		DUPLIKAT= ".$this->getField("DUPLIKAT")."
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
		, KODE= '".$this->getField("KODE")."'
		WHERE ITEM_ASSESSMENT_ID = '".$this->getField("ITEM_ASSESSMENT_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}

	function update_status()
	{
		$str = "
		UPDATE ITEM_ASSESSMENT
		SET
		STATUS = ".$this->getField("STATUS")."
		WHERE ITEM_ASSESSMENT_ID = '".$this->getField("ITEM_ASSESSMENT_ID")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM ITEM_ASSESSMENT
		WHERE 
		ITEM_ASSESSMENT_ID = ".$this->getField("ITEM_ASSESSMENT_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deleteall()
	{
		$str = "
		DELETE FROM ITEM_ASSESSMENT
		WHERE 
		ITEM_ASSESSMENT_ID = ".$this->getField("ITEM_ASSESSMENT_ID").";";
		$str .= "
		DELETE FROM ITEM_ASSESSMENT_FORMULIR
		WHERE 
		ITEM_ASSESSMENT_ID = ".$this->getField("ITEM_ASSESSMENT_ID").";";
		$str .= "
		DELETE FROM ITEM_ASSESSMENT_AREA
		WHERE 
		ITEM_ASSESSMENT_ID = ".$this->getField("ITEM_ASSESSMENT_ID").";"; 
		$str .= "
		DELETE FROM ITEM_ASSESSMENT_STANDAR
		WHERE 
		ITEM_ASSESSMENT_ID = ".$this->getField("ITEM_ASSESSMENT_ID").";";  

		$this->query = $str;
		return $this->execQuery($str);
	}



	function deleteformulir()
	{
		$str = "
		DELETE FROM ITEM_ASSESSMENT_FORMULIR
		WHERE 
		ITEM_ASSESSMENT_ID = ".$this->getField("ITEM_ASSESSMENT_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}


	function deletearea()
	{
		$str = "
		DELETE FROM ITEM_ASSESSMENT_AREA
		WHERE 
		ITEM_ASSESSMENT_ID = ".$this->getField("ITEM_ASSESSMENT_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deletestandar()
	{
		$str = "
		DELETE FROM ITEM_ASSESSMENT_STANDAR
		WHERE 
		ITEM_ASSESSMENT_ID = ".$this->getField("ITEM_ASSESSMENT_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY ITEM_ASSESSMENT_ID ASC")
	{
		$str = "
			SELECT 
				A.*
				, CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
				, LIST_AREA_ID_INFO
				, LIST_AREA_NAMA_INFO
			FROM ITEM_ASSESSMENT A 
			LEFT JOIN 
			(
				SELECT A.ITEM_ASSESSMENT_ID
				,STRING_AGG(A.LIST_AREA_ID::TEXT, ', ') AS LIST_AREA_ID_INFO
				,STRING_AGG(B.NAMA::TEXT, ', ') AS LIST_AREA_NAMA_INFO
				FROM ITEM_ASSESSMENT_AREA A
				LEFT JOIN LIST_AREA B ON B.LIST_AREA_ID= A.LIST_AREA_ID
				GROUP BY A.ITEM_ASSESSMENT_ID
			) B ON B.ITEM_ASSESSMENT_ID = A.ITEM_ASSESSMENT_ID
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

	function selectByParamsFormulir($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY ITEM_ASSESSMENT_FORMULIR_ID ASC")
	{
		$str = "
			SELECT 
				A.*
			FROM ITEM_ASSESSMENT_FORMULIR A 
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

	function selectByParamsStandar($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY ITEM_ASSESSMENT_STANDAR_ID ASC")
	{
		$str = "
			SELECT 
				A.*,B.NAMA
			FROM ITEM_ASSESSMENT_STANDAR A
			LEFT JOIN STANDAR_REFERENSI B ON B.STANDAR_REFERENSI_ID = A.STANDAR_REFERENSI_ID
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
			B.NAMA AREA_NAMA
			,B.LIST_AREA_ID
			FROM ITEM_ASSESSMENT_AREA A 
			INNER JOIN LIST_AREA B ON B.LIST_AREA_ID= A.LIST_AREA_ID 
			WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement. " GROUP BY B.LIST_AREA_ID ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
	}


	
} 
?>