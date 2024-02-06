<? 
include_once(APPPATH.'/models/Entity.php');

class KategoriRekomendasi extends Entity { 

	var $query;

    function KategoriRekomendasi()
	{
      	$this->Entity(); 
    }


    function insert()
    {
    	$this->setField("KATEGORI_REKOMENDASI_ID", $this->getNextId("KATEGORI_REKOMENDASI_ID","KATEGORI_REKOMENDASI"));

    	$str = "
    	INSERT INTO KATEGORI_REKOMENDASI
    	(
    		KATEGORI_REKOMENDASI_ID,NAMA,LAST_CREATE_USER,LAST_CREATE_DATE,KODE
    	)
    	VALUES 
    	(
    		".$this->getField("KATEGORI_REKOMENDASI_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, '".$this->getField("KODE")."'
	    )"; 

	    $this->id= $this->getField("KATEGORI_REKOMENDASI_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	
	function update()
	{
			$str = "
			UPDATE KATEGORI_REKOMENDASI
			SET
			 NAMA= '".$this->getField("NAMA")."'
			, KODE= '".$this->getField("KODE")."'
			, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
			, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
			WHERE KATEGORI_REKOMENDASI_ID = '".$this->getField("KATEGORI_REKOMENDASI_ID")."'
			"; 
			$this->query = $str;
			// echo $str;exit;
			return $this->execQuery($str);
	}

	function update_status()
	{
		$str = "
		UPDATE KATEGORI_REKOMENDASI
		SET
		STATUS = ".$this->getField("STATUS")."
		WHERE KATEGORI_REKOMENDASI_ID = '".$this->getField("KATEGORI_REKOMENDASI_ID")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM KATEGORI_REKOMENDASI
		WHERE 
		KATEGORI_REKOMENDASI_ID = ".$this->getField("KATEGORI_REKOMENDASI_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}


	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY KATEGORI_REKOMENDASI_ID ASC")
	{
		$str = "
			SELECT 
				A.*,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
			FROM KATEGORI_REKOMENDASI A 
			
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