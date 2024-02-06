<? 
include_once(APPPATH.'/models/Entity.php');

class StandarReferensi extends Entity { 

	var $query;

    function StandarReferensi()
	{
      	$this->Entity(); 
    }

    function insert()
    {
    	$this->setField("STANDAR_REFERENSI_ID", $this->getNextId("STANDAR_REFERENSI_ID","STANDAR_REFERENSI"));

    	$str = "
    	INSERT INTO STANDAR_REFERENSI
    	(
    		STANDAR_REFERENSI_ID,NAMA, NOMOR, KLAUSUL, DESKRIPSI, TAHUN, LAST_CREATE_USER,LAST_CREATE_DATE,KODE,BAB
    	)
    	VALUES 
    	(
    		".$this->getField("STANDAR_REFERENSI_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("NOMOR")."'
	    	, '".$this->getField("KLAUSUL")."'
	    	, '".$this->getField("DESKRIPSI")."'
	    	, ".$this->getField("TAHUN")."
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, '".$this->getField("KODE")."'
	    	, '".$this->getField("BAB")."'
	    )"; 

	    $this->id= $this->getField("STANDAR_REFERENSI_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE STANDAR_REFERENSI
		SET
		STANDAR_REFERENSI_ID= ".$this->getField("STANDAR_REFERENSI_ID")."
		, NAMA= '".$this->getField("NAMA")."'
		, NOMOR= '".$this->getField("NOMOR")."'
		, KLAUSUL= '".$this->getField("KLAUSUL")."'
		, DESKRIPSI= '".$this->getField("DESKRIPSI")."'
		, TAHUN= ".$this->getField("TAHUN")."
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
		, KODE= '".$this->getField("KODE")."'
		, BAB= '".$this->getField("BAB")."'
		WHERE STANDAR_REFERENSI_ID = '".$this->getField("STANDAR_REFERENSI_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}

	function update_status()
	{
		$str = "
		UPDATE STANDAR_REFERENSI
		SET
		STATUS = ".$this->getField("STATUS")."
		WHERE STANDAR_REFERENSI_ID = '".$this->getField("STANDAR_REFERENSI_ID")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}


	function delete()
	{
		$str = "
		DELETE FROM STANDAR_REFERENSI
		WHERE 
		STANDAR_REFERENSI_ID = ".$this->getField("STANDAR_REFERENSI_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY STANDAR_REFERENSI_ID ASC")
	{
		$str = "
			SELECT 
				A.*,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
			FROM STANDAR_REFERENSI A 
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

	function selectByParamsFilterOutline($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.STANDAR_REFERENSI_ID ASC")
	{
		$str = "
			SELECT 
				A.*,C.NAMA,C.DESKRIPSI,C.KODE,D.STATUS_KONFIRMASI,D.PROGRAM_ITEM_ASSESSMENT_ID
			FROM ITEM_ASSESSMENT_STANDAR A 
			INNER JOIN ITEM_ASSESSMENT B ON B.ITEM_ASSESSMENT_ID = A.ITEM_ASSESSMENT_ID
			INNER JOIN STANDAR_REFERENSI C ON C.STANDAR_REFERENSI_ID = A.STANDAR_REFERENSI_ID
			INNER JOIN ITEM_ASSESSMENT_FORMULIR D ON D.ITEM_ASSESSMENT_FORMULIR_ID = A.ITEM_ASSESSMENT_FORMULIR_ID
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

	
    function getCountByParams($paramsArray=array(),$statement='')
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
		FROM STANDAR_REFERENSI a
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