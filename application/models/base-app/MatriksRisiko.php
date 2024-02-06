<? 
include_once(APPPATH.'/models/Entity.php');

class MatriksRisiko extends Entity { 

	var $query;

    function MatriksRisiko()
	{
      	$this->Entity(); 
    }


    function insert()
    {
    	$this->setField("MATRIKS_RISIKO_ID", $this->getNextId("MATRIKS_RISIKO_ID","MATRIKS_RISIKO"));

    	$str = "
    	INSERT INTO MATRIKS_RISIKO
    	(
    		MATRIKS_RISIKO_ID,RISIKO_ID, DAMPAK_ID, KEMUNGKINAN_ID, LINK_FILE,LAST_CREATE_USER,LAST_CREATE_DATE,KODE,PERATURAN_ID
    	)
    	VALUES 
    	(
    		".$this->getField("MATRIKS_RISIKO_ID")."
	    	, ".$this->getField("RISIKO_ID")."
	    	, ".$this->getField("DAMPAK_ID")."
	    	, ".$this->getField("KEMUNGKINAN_ID")."
	    	, '".$this->getField("LINK_FILE")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, '".$this->getField("KODE")."'
	    	, ".$this->getField("PERATURAN_ID")."
	    )"; 

	    $this->id= $this->getField("MATRIKS_RISIKO_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	
	function update()
	{
			$str = "
			UPDATE MATRIKS_RISIKO
			SET
			RISIKO_ID= ".$this->getField("RISIKO_ID")."
			, DAMPAK_ID= ".$this->getField("DAMPAK_ID")."
			, KEMUNGKINAN_ID= ".$this->getField("KEMUNGKINAN_ID")."
			, LINK_FILE= '".$this->getField("LINK_FILE")."'
			, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
			, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
			, KODE= '".$this->getField("KODE")."'
			, PERATURAN_ID= ".$this->getField("PERATURAN_ID")."
			WHERE MATRIKS_RISIKO_ID = '".$this->getField("MATRIKS_RISIKO_ID")."'
			"; 
			$this->query = $str;
			// echo $str;exit;
			return $this->execQuery($str);
	}


	function update_status()
	{
		$str = "
		UPDATE MATRIKS_RISIKO
		SET
		STATUS = ".$this->getField("STATUS")."
		WHERE MATRIKS_RISIKO_ID = '".$this->getField("MATRIKS_RISIKO_ID")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM MATRIKS_RISIKO
		WHERE 
		MATRIKS_RISIKO_ID = ".$this->getField("MATRIKS_RISIKO_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}


	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY MATRIKS_RISIKO_ID ASC")
	{
		$str = "
			
			SELECT 
				A.*,B.NAMA RISIKO,C.NAMA  || ' - ' || C.BOBOT  DAMPAK,D.NAMA  || ' - ' || D.BOBOT KEMUNGKINAN
				, CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
				,  E.NAMA PERATURAN_INFO
			FROM MATRIKS_RISIKO A 
			LEFT JOIN RISIKO B ON B.RISIKO_ID = A.RISIKO_ID
			LEFT JOIN DAMPAK C ON C.DAMPAK_ID = A.DAMPAK_ID
			LEFT JOIN KEMUNGKINAN D ON D.KEMUNGKINAN_ID = A.KEMUNGKINAN_ID
			LEFT JOIN PERATURAN E ON E.PERATURAN_ID = A.PERATURAN_ID
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

	function selectByParamsLaporan($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY KODE ASC")
	{
		$str = "
			
			SELECT 
				A.*,B.NAMA RISIKO,C.NAMA DAMPAK,D.NAMA  KEMUNGKINAN
				, CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
				, E.KODE_WARNA
			FROM MATRIKS_RISIKO A 
			INNER JOIN RISIKO B ON B.RISIKO_ID = A.RISIKO_ID
			INNER JOIN DAMPAK C ON C.DAMPAK_ID = A.DAMPAK_ID
			INNER JOIN KEMUNGKINAN D ON D.KEMUNGKINAN_ID = A.KEMUNGKINAN_ID
			INNER JOIN PENANGANAN_RISIKO E ON E.RISIKO_ID = B.RISIKO_ID
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