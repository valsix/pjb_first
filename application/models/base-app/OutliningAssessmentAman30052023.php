<? 
include_once(APPPATH.'/models/Entity.php');

class OutliningAssessment extends Entity { 

	var $query;

    function OutliningAssessment()
	{
      	$this->Entity(); 
    }
 
    function insert()
    {
    	$this->setField("OUTLINING_ASSESSMENT_ID", $this->getNextId("OUTLINING_ASSESSMENT_ID","OUTLINING_ASSESSMENT"));

    	$str = "
    	INSERT INTO OUTLINING_ASSESSMENT
    	(
    		OUTLINING_ASSESSMENT_ID,DISTRIK_ID,BLOK_UNIT_ID,UNIT_MESIN_ID,BULAN,TAHUN,STATUS,LAST_CREATE_USER,LAST_CREATE_DATE
    	)
    	VALUES 
    	(
    		".$this->getField("OUTLINING_ASSESSMENT_ID")."
	    	, ".$this->getField("DISTRIK_ID")."
	    	, ".$this->getField("BLOK_UNIT_ID")."
	    	, ".$this->getField("UNIT_MESIN_ID")."
	    	, '".$this->getField("BULAN")."'
	    	, ".$this->getField("TAHUN")."
	    	, ".$this->getField("STATUS")."
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    )"; 

	    $this->id= $this->getField("OUTLINING_ASSESSMENT_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function insertdetil()
    {
    	$this->setField("OUTLINING_ASSESSMENT_DETIL_ID", $this->getNextId("OUTLINING_ASSESSMENT_DETIL_ID","OUTLINING_ASSESSMENT_DETIL"));

    	$str = "
    	INSERT INTO OUTLINING_ASSESSMENT_DETIL
    	(
    		OUTLINING_ASSESSMENT_DETIL_ID,OUTLINING_ASSESSMENT_ID,LIST_AREA_ID,KATEGORI_ITEM_ASSESSMENT_ID,ITEM_ASSESSMENT_DUPLIKAT_ID,ITEM_ASSESSMENT_FORMULIR_ID,STANDAR_REFERENSI_ID,STATUS_CONFIRM,KETERANGAN,LAST_CREATE_USER,LAST_CREATE_DATE,AREA_UNIT_DETIL_ID,PROGRAM_ITEM_ASSESSMENT_ID,STATUS_KONFIRMASI,BOBOT
    	)
    	VALUES 
    	(
    		".$this->getField("OUTLINING_ASSESSMENT_DETIL_ID")."
    		, ".$this->getField("OUTLINING_ASSESSMENT_ID")."
	    	, ".$this->getField("LIST_AREA_ID")."
	    	, ".$this->getField("KATEGORI_ITEM_ASSESSMENT_ID")."
	    	, ".$this->getField("ITEM_ASSESSMENT_DUPLIKAT_ID")."
	    	, ".$this->getField("ITEM_ASSESSMENT_FORMULIR_ID")."
	    	, ".$this->getField("STANDAR_REFERENSI_ID")."
	    	, ".$this->getField("STATUS_CONFIRM")."
	    	, '".$this->getField("KETERANGAN")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, ".$this->getField("AREA_UNIT_DETIL_ID")."
	    	, ".$this->getField("PROGRAM_ITEM_ASSESSMENT_ID")."
	    	, ".$this->getField("STATUS_KONFIRMASI")."
	    	, ".$this->getField("BOBOT")."
	    )"; 

	    $this->id= $this->getField("OUTLINING_ASSESSMENT_DETIL_ID");
	    $this->query= $str;
		// echo $str;exit;
	    return $this->execQuery($str);
	}


	function insertrekomendasi()
    {
    	$this->setField("OUTLINING_ASSESSMENT_REKOMENDASI_ID", $this->getNextId("OUTLINING_ASSESSMENT_REKOMENDASI_ID","OUTLINING_ASSESSMENT_REKOMENDASI"));

    	$str = "
    	INSERT INTO OUTLINING_ASSESSMENT_REKOMENDASI
    	(
    		OUTLINING_ASSESSMENT_REKOMENDASI_ID,OUTLINING_ASSESSMENT_DETIL_ID,OUTLINING_ASSESSMENT_ID,LIST_AREA_ID,ITEM_ASSESSMENT_DUPLIKAT_ID,REKOMENDASI,JENIS_REKOMENDASI_ID,PRIORITAS_REKOMENDASI_ID,KATEGORI_REKOMENDASI_ID,SEM_1_1,SEM_2_1,SEM_1_2,SEM_2_2,SEM_1_3,SEM_2_3,STATUS_CHECK,ANGGARAN,LAST_CREATE_USER,LAST_CREATE_DATE,AREA_UNIT_DETIL_ID
    	)
    	VALUES 
    	(
    		".$this->getField("OUTLINING_ASSESSMENT_REKOMENDASI_ID")."
    		, ".$this->getField("OUTLINING_ASSESSMENT_DETIL_ID")."
	    	, ".$this->getField("OUTLINING_ASSESSMENT_ID")."
	    	, ".$this->getField("LIST_AREA_ID")."
	    	, ".$this->getField("ITEM_ASSESSMENT_DUPLIKAT_ID")."
	    	, '".$this->getField("REKOMENDASI")."'
	    	, ".$this->getField("JENIS_REKOMENDASI_ID")."
	    	, ".$this->getField("PRIORITAS_REKOMENDASI_ID")."
	    	, ".$this->getField("KATEGORI_REKOMENDASI_ID")."
	    	, ".$this->getField("SEM_1_1")."
	    	, ".$this->getField("SEM_2_1")."
	    	, ".$this->getField("SEM_1_2")."
	    	, ".$this->getField("SEM_2_2")."
	    	, ".$this->getField("SEM_1_3")."
	    	, ".$this->getField("SEM_2_3")."
	    	, ".$this->getField("STATUS_CHECK")."
	    	, ".$this->getField("ANGGARAN")."
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, ".$this->getField("AREA_UNIT_DETIL_ID")."
	    )"; 

	    $this->id= $this->getField("OUTLINING_ASSESSMENT_DETIL_ID");
	    $this->query= $str;
		// echo $str;
	    return $this->execQuery($str);
	}

	function updaterekomendasi()
	{
		$str = "
		UPDATE OUTLINING_ASSESSMENT_REKOMENDASI
		SET

			OUTLINING_ASSESSMENT_REKOMENDASI_ID = ".$this->getField("OUTLINING_ASSESSMENT_REKOMENDASI_ID")."
    		, OUTLINING_ASSESSMENT_DETIL_ID = ".$this->getField("OUTLINING_ASSESSMENT_DETIL_ID")."
	    	, OUTLINING_ASSESSMENT_ID = ".$this->getField("OUTLINING_ASSESSMENT_ID")."
	    	, LIST_AREA_ID = ".$this->getField("LIST_AREA_ID")."
	    	, ITEM_ASSESSMENT_DUPLIKAT_ID = ".$this->getField("ITEM_ASSESSMENT_DUPLIKAT_ID")."
	    	, REKOMENDASI = '".$this->getField("REKOMENDASI")."'
	    	, JENIS_REKOMENDASI_ID = ".$this->getField("JENIS_REKOMENDASI_ID")."
	    	, PRIORITAS_REKOMENDASI_ID = ".$this->getField("PRIORITAS_REKOMENDASI_ID")."
	    	, KATEGORI_REKOMENDASI_ID = ".$this->getField("KATEGORI_REKOMENDASI_ID")."
	    	, SEM_1_1 = ".$this->getField("SEM_1_1")."
	    	, SEM_2_1 = ".$this->getField("SEM_2_1")."
	    	, SEM_1_2 = ".$this->getField("SEM_1_2")."
	    	, SEM_2_2 = ".$this->getField("SEM_2_2")."
	    	, SEM_1_3 = ".$this->getField("SEM_1_3")."
	    	, SEM_2_3 = ".$this->getField("SEM_2_3")."
	    	, STATUS_CHECK = ".$this->getField("STATUS_CHECK")."
	    	, ANGGARAN = ".$this->getField("ANGGARAN")."
	    	, LAST_UPDATE_USER = '".$this->getField("LAST_UPDATE_USER")."'
			, LAST_UPDATE_DATE = ".$this->getField("LAST_UPDATE_DATE")."
			, AREA_UNIT_DETIL_ID = ".$this->getField("AREA_UNIT_DETIL_ID")."
		WHERE OUTLINING_ASSESSMENT_DETIL_ID = '".$this->getField("OUTLINING_ASSESSMENT_DETIL_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE OUTLINING_ASSESSMENT
		SET
		DISTRIK_ID = ".$this->getField("DISTRIK_ID")."
		, BLOK_UNIT_ID = ".$this->getField("BLOK_UNIT_ID")."
		, UNIT_MESIN_ID = ".$this->getField("UNIT_MESIN_ID")."
		, BULAN = '".$this->getField("BULAN")."'
		, TAHUN = ".$this->getField("TAHUN")."
		, STATUS = ".$this->getField("STATUS")."
		, LAST_UPDATE_USER = '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE = ".$this->getField("LAST_UPDATE_DATE")."
		WHERE OUTLINING_ASSESSMENT_ID = '".$this->getField("OUTLINING_ASSESSMENT_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}

	function updatedetil()
	{
		$str = "
		UPDATE OUTLINING_ASSESSMENT_DETIL
		SET
			OUTLINING_ASSESSMENT_ID= ".$this->getField("OUTLINING_ASSESSMENT_ID")."
			, LIST_AREA_ID = ".$this->getField("LIST_AREA_ID")."
			, KATEGORI_ITEM_ASSESSMENT_ID = ".$this->getField("KATEGORI_ITEM_ASSESSMENT_ID")."
			, ITEM_ASSESSMENT_DUPLIKAT_ID = ".$this->getField("ITEM_ASSESSMENT_DUPLIKAT_ID")."
			, ITEM_ASSESSMENT_FORMULIR_ID = ".$this->getField("ITEM_ASSESSMENT_FORMULIR_ID")."
			, STANDAR_REFERENSI_ID = ".$this->getField("STANDAR_REFERENSI_ID")."
			, STATUS_CONFIRM = ".$this->getField("STATUS_CONFIRM")."
			, KETERANGAN = '".$this->getField("KETERANGAN")."'
			, LAST_UPDATE_USER = '".$this->getField("LAST_UPDATE_USER")."'
			, LAST_UPDATE_DATE = ".$this->getField("LAST_UPDATE_DATE")."
			, AREA_UNIT_DETIL_ID = ".$this->getField("AREA_UNIT_DETIL_ID")."
			, PROGRAM_ITEM_ASSESSMENT_ID = ".$this->getField("PROGRAM_ITEM_ASSESSMENT_ID")."
			, STATUS_KONFIRMASI = ".$this->getField("STATUS_KONFIRMASI")."
			, BOBOT = ".$this->getField("BOBOT")."

		WHERE OUTLINING_ASSESSMENT_DETIL_ID = '".$this->getField("OUTLINING_ASSESSMENT_DETIL_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}

	function update_status()
	{
		$str = "
		UPDATE OUTLINING_ASSESSMENT
		SET
		STATUS = ".$this->getField("STATUS")."
		WHERE OUTLINING_ASSESSMENT_ID = '".$this->getField("OUTLINING_ASSESSMENT_ID")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM OUTLINING_ASSESSMENT
		WHERE 
		OUTLINING_ASSESSMENT_ID = ".$this->getField("OUTLINING_ASSESSMENT_ID").";
		";
		$str .= "
		DELETE FROM OUTLINING_ASSESSMENT_DETIL
		WHERE 
		OUTLINING_ASSESSMENT_ID = ".$this->getField("OUTLINING_ASSESSMENT_ID").";
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deletedetil()
	{
		$str = "
		DELETE FROM OUTLINING_ASSESSMENT_DETIL
		WHERE 
		OUTLINING_ASSESSMENT_DETIL_ID = ".$this->getField("OUTLINING_ASSESSMENT_DETIL_ID")."
		AND OUTLINING_ASSESSMENT_ID = ".$this->getField("OUTLINING_ASSESSMENT_ID")."
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deleterekomendasi()
	{
		$str = "
		DELETE FROM OUTLINING_ASSESSMENT_REKOMENDASI
		WHERE 
		OUTLINING_ASSESSMENT_REKOMENDASI_ID = ".$this->getField("OUTLINING_ASSESSMENT_REKOMENDASI_ID")."
		AND OUTLINING_ASSESSMENT_ID = ".$this->getField("OUTLINING_ASSESSMENT_ID")."
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY OUTLINING_ASSESSMENT_ID ASC")
	{
		$str = "
			SELECT 
				A.*, B.NAMA DISTRIK_INFO,C.NAMA BLOK_INFO, D.NAMA UNIT_MESIN_INFO
				, CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
				, CONCAT( A.BULAN,'',A.TAHUN)  
			FROM OUTLINING_ASSESSMENT A
			INNER JOIN DISTRIK B ON B.DISTRIK_ID = A.DISTRIK_ID
			INNER JOIN BLOK_UNIT C ON C.BLOK_UNIT_ID = A.BLOK_UNIT_ID
			INNER JOIN UNIT_MESIN D ON D.UNIT_MESIN_ID = A.UNIT_MESIN_ID
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

	function selectByParamsRekomendasi($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.OUTLINING_ASSESSMENT_ID,A,OUTLINING_ASSESSMENT_DETIL_ID ASC")
	{
		$str = "
			SELECT 
				 A.OUTLINING_ASSESSMENT_REKOMENDASI_ID,A.OUTLINING_ASSESSMENT_ID,A.OUTLINING_ASSESSMENT_DETIL_ID,A.LIST_AREA_ID
				 , A.ITEM_ASSESSMENT_DUPLIKAT_ID,A.REKOMENDASI,A.SEM_1_1,A.SEM_2_1,A.SEM_1_2,A.SEM_2_2,A.SEM_1_3,A.SEM_2_3
				 , A.STATUS_CHECK,A.ANGGARAN
				 , D.KODE || GENERATEZERO(E.KODE,2) ||' - '|| D.NAMA  AREA_INFO
				 , F.NAMA NAMA_INFO
				 , C.KETERANGAN
				 , G.NAMA JENIS_INFO
				 , H.NAMA PRIORITAS_INFO
				 , I.NAMA KATEGORI_INFO
				 , J.NAMA DISTRIK_INFO,K.NAMA BLOK_INFO, L.NAMA UNIT_MESIN_INFO
				 , B.BULAN,B.TAHUN
			FROM OUTLINING_ASSESSMENT_REKOMENDASI A
			INNER JOIN OUTLINING_ASSESSMENT B ON B.OUTLINING_ASSESSMENT_ID = A.OUTLINING_ASSESSMENT_ID
			INNER JOIN OUTLINING_ASSESSMENT_DETIL C ON C.OUTLINING_ASSESSMENT_DETIL_ID = A.OUTLINING_ASSESSMENT_DETIL_ID
			INNER JOIN LIST_AREA  D ON D.LIST_AREA_ID = A.LIST_AREA_ID
			INNER JOIN ITEM_ASSESSMENT_DUPLIKAT  E ON E.ITEM_ASSESSMENT_DUPLIKAT_ID = A.ITEM_ASSESSMENT_DUPLIKAT_ID AND E.LIST_AREA_ID = A.LIST_AREA_ID
			INNER JOIN AREA_UNIT_DETIL F ON  F.AREA_UNIT_DETIL_ID=A.AREA_UNIT_DETIL_ID
			LEFT JOIN JENIS_REKOMENDASI G ON  G.JENIS_REKOMENDASI_ID=A.JENIS_REKOMENDASI_ID
			LEFT JOIN PRIORITAS_REKOMENDASI H ON  H.PRIORITAS_REKOMENDASI_ID=A.PRIORITAS_REKOMENDASI_ID 
			LEFT JOIN KATEGORI_REKOMENDASI I ON  I.KATEGORI_REKOMENDASI_ID=A.KATEGORI_REKOMENDASI_ID
			INNER JOIN DISTRIK J ON J.DISTRIK_ID = B.DISTRIK_ID
			INNER JOIN BLOK_UNIT K ON K.BLOK_UNIT_ID = B.BLOK_UNIT_ID
			INNER JOIN UNIT_MESIN L ON L.UNIT_MESIN_ID = B.UNIT_MESIN_ID  
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

	function selectByParamsDetil($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY OUTLINING_ASSESSMENT_DETIL_ID ASC")
	{
		$str = "
			SELECT 
				A.*,B.DISTRIK_ID,B.BLOK_UNIT_ID,B.UNIT_MESIN_ID
			FROM OUTLINING_ASSESSMENT_DETIL A
			INNER JOIN  OUTLINING_ASSESSMENT B ON B.OUTLINING_ASSESSMENT_ID = A.OUTLINING_ASSESSMENT_ID
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

	function selectByParamsDetilRekomendasi($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.OUTLINING_ASSESSMENT_DETIL_ID ASC")
	{
		$str = "
			SELECT 
				A.*,B.DISTRIK_ID,B.BLOK_UNIT_ID,B.UNIT_MESIN_ID,c.OUTLINING_ASSESSMENT_REKOMENDASI_ID,C.REKOMENDASI,C.JENIS_REKOMENDASI_ID,C.PRIORITAS_REKOMENDASI_ID,C.KATEGORI_REKOMENDASI_ID
				, C.SEM_1_1, C.SEM_2_1,C.SEM_1_2, C.SEM_2_2,C.SEM_1_3, C.SEM_2_3,C.STATUS_CHECK,C.ANGGARAN
			FROM OUTLINING_ASSESSMENT_DETIL A
			INNER JOIN  OUTLINING_ASSESSMENT B ON B.OUTLINING_ASSESSMENT_ID = A.OUTLINING_ASSESSMENT_ID
			LEFT JOIN OUTLINING_ASSESSMENT_REKOMENDASI C ON C.OUTLINING_ASSESSMENT_DETIL_ID = A.OUTLINING_ASSESSMENT_DETIL_ID
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
		FROM OUTLINING_ASSESSMENT a
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