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
    		OUTLINING_ASSESSMENT_ID,DISTRIK_ID,BLOK_UNIT_ID,UNIT_MESIN_ID,BULAN,TAHUN,STATUS,LAST_CREATE_USER,LAST_CREATE_DATE,V_STATUS,BLOK_UNIT_ID_CHAR
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
	    	, ".$this->getField("V_STATUS")."
	    	, '".$this->getField("BLOK_UNIT_ID_CHAR")."'
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
    		OUTLINING_ASSESSMENT_DETIL_ID,OUTLINING_ASSESSMENT_ID,LIST_AREA_ID,ITEM_ASSESSMENT_DUPLIKAT_ID,AREA_UNIT_ID,AREA_UNIT_DETIL_ID,LAST_CREATE_USER,LAST_CREATE_DATE,BLOK_UNIT_ID
    	)
    	VALUES 
    	(
    		".$this->getField("OUTLINING_ASSESSMENT_DETIL_ID")."
    		, ".$this->getField("OUTLINING_ASSESSMENT_ID")."
	    	, ".$this->getField("LIST_AREA_ID")."
	    	, ".$this->getField("ITEM_ASSESSMENT_DUPLIKAT_ID")."
	    	, ".$this->getField("AREA_UNIT_ID")."
	    	, ".$this->getField("AREA_UNIT_DETIL_ID")."
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, ".$this->getField("BLOK_UNIT_ID")."
	    )"; 

	    $this->id= $this->getField("OUTLINING_ASSESSMENT_DETIL_ID");
	    $this->query= $str;
		// echo $str;
	    return $this->execQuery($str);
	}


	function insertblok()
    {
    	$this->setField("OUTLINING_ASSESSMENT_BLOK_UNIT_ID", $this->getNextId("OUTLINING_ASSESSMENT_BLOK_UNIT_ID","OUTLINING_ASSESSMENT_BLOK_UNIT"));

    	$str = "
    	INSERT INTO OUTLINING_ASSESSMENT_BLOK_UNIT
    	(
    		OUTLINING_ASSESSMENT_BLOK_UNIT_ID,OUTLINING_ASSESSMENT_ID,BLOK_UNIT_ID
    	)
    	VALUES 
    	(
    		".$this->getField("OUTLINING_ASSESSMENT_BLOK_UNIT_ID")."
    		, ".$this->getField("OUTLINING_ASSESSMENT_ID")."
	    	, ".$this->getField("BLOK_UNIT_ID")."
	    )"; 

	    $this->id= $this->getField("OUTLINING_ASSESSMENT_BLOK_UNIT_ID");
	    $this->query= $str;
		// echo $str;exit;
	    return $this->execQuery($str);
	}


	function insertdetilnew()
    {
    	$str = "
    	select area_unit(".$this->getField("OUTLINING_ASSESSMENT_ID").",".$this->getField("DISTRIK_ID").",".$this->getField("BLOK_UNIT_ID").",".$this->getField("UNIT_MESIN_ID").")
    	";
    	
    	$this->query= $str;
    	// echo $str;exit;
	    return $this->execQuery($str);
	}

	function insertareadetil()
    {
    	$this->setField("OUTLINING_ASSESSMENT_AREA_DETIL_ID", $this->getNextId("OUTLINING_ASSESSMENT_AREA_DETIL_ID","OUTLINING_ASSESSMENT_AREA_DETIL"));

    	$str = "
    		
    	INSERT INTO OUTLINING_ASSESSMENT_AREA_DETIL
    	(
    		OUTLINING_ASSESSMENT_AREA_DETIL_ID, OUTLINING_ASSESSMENT_DETIL_ID, 
            OUTLINING_ASSESSMENT_ID,AREA_UNIT_ID, AREA_UNIT_DETIL_ID, LIST_AREA_ID, ITEM_ASSESSMENT_DUPLIKAT_ID, 
            ITEM_ASSESSMENT_FORMULIR_ID, ITEM_ASSESSMENT_ID, STANDAR_REFERENSI_ID, 
            STATUS_CONFIRM, KETERANGAN, LAST_CREATE_USER,
            LAST_CREATE_DATE,LINK_FOTO,V_STATUS
    	)
    	VALUES 
    	(
    		".$this->getField("OUTLINING_ASSESSMENT_AREA_DETIL_ID")."
    		, ".$this->getField("OUTLINING_ASSESSMENT_DETIL_ID")."
    		, ".$this->getField("OUTLINING_ASSESSMENT_ID")."
    		, ".$this->getField("AREA_UNIT_ID")."
    		, ".$this->getField("AREA_UNIT_DETIL_ID")."
	    	, ".$this->getField("LIST_AREA_ID")."
	    	, ".$this->getField("ITEM_ASSESSMENT_DUPLIKAT_ID")."
	    	, ".$this->getField("ITEM_ASSESSMENT_FORMULIR_ID")."
	    	, ".$this->getField("ITEM_ASSESSMENT_ID")."
	    	, ".$this->getField("STANDAR_REFERENSI_ID")."
	    	, ".$this->getField("STATUS_CONFIRM")."
	    	, '".$this->getField("KETERANGAN")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, '".$this->getField("LINK_FOTO")."'
	    	, ".$this->getField("V_STATUS")."
	    )"; 

	    $this->id= $this->getField("OUTLINING_ASSESSMENT_AREA_DETIL_ID");
	    $this->query= $str;
		// echo $str;exit;
	    return $this->execQuery($str);
	}

	function selectByParamsInsertDetil($reqId,$reqDistrikId,$reqBlokid,$reqUnitMesinId)
    {
    	$str="SELECT setval('outlining_assessment_detil_seq', 1, FALSE);";
    	$str .=" SELECT area_unit(".$reqId.", ".$reqDistrikId.",".$reqBlokid.",".$reqUnitMesinId."); ";
    	
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
	}


	function insertrekomendasiold()
    {
    	$this->setField("OUTLINING_ASSESSMENT_REKOMENDASI_ID", $this->getNextId("OUTLINING_ASSESSMENT_REKOMENDASI_ID","OUTLINING_ASSESSMENT_REKOMENDASI"));

    	$str = "
    	INSERT INTO OUTLINING_ASSESSMENT_REKOMENDASI
    	(
    		OUTLINING_ASSESSMENT_REKOMENDASI_ID,OUTLINING_ASSESSMENT_DETIL_ID,OUTLINING_ASSESSMENT_ID,LIST_AREA_ID,ITEM_ASSESSMENT_DUPLIKAT_ID,REKOMENDASI,JENIS_REKOMENDASI_ID,PRIORITAS_REKOMENDASI_ID,KATEGORI_REKOMENDASI_ID,SEM_1_1,SEM_2_1,SEM_1_2,SEM_2_2,SEM_1_3,SEM_2_3,STATUS_CHECK,ANGGARAN,LAST_CREATE_USER,LAST_CREATE_DATE,AREA_UNIT_DETIL_ID,AREA_UNIT_ID,OUTLINING_ASSESSMENT_AREA_DETIL_ID
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
	    	, ".$this->getField("AREA_UNIT_ID")."
	    	
	    	, ".$this->getField("OUTLINING_ASSESSMENT_AREA_DETIL_ID")."
	    )"; 

	    $this->id= $this->getField("OUTLINING_ASSESSMENT_DETIL_ID");
	    $this->query= $str;
		// echo $str;exit;
	    return $this->execQuery($str);
	}

	function updaterekomendasiold()
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
			, AREA_UNIT_ID = ".$this->getField("AREA_UNIT_ID")."
			, AREA_UNIT_DETIL_ID = ".$this->getField("AREA_UNIT_DETIL_ID")."
			, OUTLINING_ASSESSMENT_AREA_DETIL_ID = ".$this->getField("OUTLINING_ASSESSMENT_AREA_DETIL_ID")."
		WHERE OUTLINING_ASSESSMENT_DETIL_ID = '".$this->getField("OUTLINING_ASSESSMENT_DETIL_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}


	function insertrekomendasi()
    {
    	$this->setField("OUTLINING_ASSESSMENT_REKOMENDASI_ID", $this->getNextId("OUTLINING_ASSESSMENT_REKOMENDASI_ID","OUTLINING_ASSESSMENT_REKOMENDASI"));

    	$str = "
    	INSERT INTO OUTLINING_ASSESSMENT_REKOMENDASI
    	(
    		OUTLINING_ASSESSMENT_REKOMENDASI_ID,OUTLINING_ASSESSMENT_AREA_DETIL_ID,OUTLINING_ASSESSMENT_DETIL_ID,OUTLINING_ASSESSMENT_ID,JENIS_REKOMENDASI_ID
    		,PRIORITAS_REKOMENDASI_ID,KATEGORI_REKOMENDASI_ID,TIMELINE_REKOMENDASI_ID,STATUS_REKOMENDASI_ID,SUMBER_ANGGARAN_ID,DETAIL,NOMOR_WO,RENCANA_EKSEKUSI,REALISASI_EKSEKUSI,KETERANGAN,LINK_FILE,CATATAN,LAST_CREATE_USER,LAST_CREATE_DATE,WORK_ORDER_ID,V_STATUS
    	)
    	VALUES 
    	(
    		".$this->getField("OUTLINING_ASSESSMENT_REKOMENDASI_ID")."
    		, ".$this->getField("OUTLINING_ASSESSMENT_AREA_DETIL_ID")."
    		, ".$this->getField("OUTLINING_ASSESSMENT_DETIL_ID")."
	    	, ".$this->getField("OUTLINING_ASSESSMENT_ID")."
	    	, ".$this->getField("JENIS_REKOMENDASI_ID")."
	    	, ".$this->getField("PRIORITAS_REKOMENDASI_ID")."
	    	, ".$this->getField("KATEGORI_REKOMENDASI_ID")."
	    	, '".$this->getField("TIMELINE_REKOMENDASI_ID")."'
	    	, ".$this->getField("STATUS_REKOMENDASI_ID")."
	    	, ".$this->getField("SUMBER_ANGGARAN_ID")."
	    	, '".$this->getField("DETAIL")."'
	    	, '".$this->getField("NOMOR_WO")."'
	    	, ".$this->getField("RENCANA_EKSEKUSI")."
	    	, ".$this->getField("REALISASI_EKSEKUSI")."
	    	, '".$this->getField("KETERANGAN")."'
	    	, '".$this->getField("LINK_FILE")."'
	    	, '".$this->getField("CATATAN")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, ".$this->getField("WORK_ORDER_ID")."
	    	, ".$this->getField("V_STATUS")."
	    )"; 

	    $this->id= $this->getField("OUTLINING_ASSESSMENT_REKOMENDASI_ID");
	    $this->query= $str;
		// echo $str;exit;
	    return $this->execQuery($str);
	}

	function updaterekomendasi()
	{
		$str = "
		UPDATE OUTLINING_ASSESSMENT_REKOMENDASI
		SET
			OUTLINING_ASSESSMENT_REKOMENDASI_ID = ".$this->getField("OUTLINING_ASSESSMENT_REKOMENDASI_ID")."
			, OUTLINING_ASSESSMENT_AREA_DETIL_ID = ".$this->getField("OUTLINING_ASSESSMENT_AREA_DETIL_ID")."
    		, OUTLINING_ASSESSMENT_DETIL_ID = ".$this->getField("OUTLINING_ASSESSMENT_DETIL_ID")."
	    	, OUTLINING_ASSESSMENT_ID = ".$this->getField("OUTLINING_ASSESSMENT_ID")."
	    	, JENIS_REKOMENDASI_ID = ".$this->getField("JENIS_REKOMENDASI_ID")."
	    	, PRIORITAS_REKOMENDASI_ID = ".$this->getField("PRIORITAS_REKOMENDASI_ID")."
	    	, KATEGORI_REKOMENDASI_ID = ".$this->getField("KATEGORI_REKOMENDASI_ID")."
	    	, TIMELINE_REKOMENDASI_ID= '".$this->getField("TIMELINE_REKOMENDASI_ID")."'
	    	, STATUS_REKOMENDASI_ID = ".$this->getField("STATUS_REKOMENDASI_ID")."
	    	, SUMBER_ANGGARAN_ID = ".$this->getField("SUMBER_ANGGARAN_ID")."
	    	, DETAIL= '".$this->getField("DETAIL")."'
	    	, NOMOR_WO= '".$this->getField("NOMOR_WO")."'
	    	, RENCANA_EKSEKUSI= ".$this->getField("RENCANA_EKSEKUSI")."
	    	, REALISASI_EKSEKUSI= ".$this->getField("REALISASI_EKSEKUSI")."
	    	, KETERANGAN= '".$this->getField("KETERANGAN")."'
	    	, CATATAN= '".$this->getField("CATATAN")."'
	    	, LAST_UPDATE_USER = '".$this->getField("LAST_UPDATE_USER")."'
			, LAST_UPDATE_DATE = ".$this->getField("LAST_UPDATE_DATE")."
			, WORK_ORDER_ID = ".$this->getField("WORK_ORDER_ID")."
			, V_STATUS = ".$this->getField("V_STATUS")."
		WHERE OUTLINING_ASSESSMENT_REKOMENDASI_ID = '".$this->getField("OUTLINING_ASSESSMENT_REKOMENDASI_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}


	function updaterekomendasifile()
	{
		$str = "
		UPDATE OUTLINING_ASSESSMENT_REKOMENDASI
		SET
			LINK_FILE = '".$this->getField("LINK_FILE")."'
			, LAST_UPDATE_USER = '".$this->getField("LAST_UPDATE_USER")."'
			, LAST_UPDATE_DATE = ".$this->getField("LAST_UPDATE_DATE")."
		WHERE OUTLINING_ASSESSMENT_REKOMENDASI_ID = '".$this->getField("OUTLINING_ASSESSMENT_REKOMENDASI_ID")."'
		"; 
		$this->query = $str;
			// echo $str;
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
		, V_STATUS = ".$this->getField("V_STATUS")."
		, V_STATUS_1 = ".$this->getField("V_STATUS_1")."
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
			, ITEM_ASSESSMENT_DUPLIKAT_ID = ".$this->getField("ITEM_ASSESSMENT_DUPLIKAT_ID")."
			, AREA_UNIT_ID = ".$this->getField("AREA_UNIT_ID")."
			, AREA_UNIT_DETIL_ID = ".$this->getField("AREA_UNIT_DETIL_ID")."
			, BLOK_UNIT_ID = ".$this->getField("BLOK_UNIT_ID")."
			, LAST_UPDATE_USER = '".$this->getField("LAST_UPDATE_USER")."'
			, LAST_UPDATE_DATE = ".$this->getField("LAST_UPDATE_DATE")."

		WHERE OUTLINING_ASSESSMENT_DETIL_ID = '".$this->getField("OUTLINING_ASSESSMENT_DETIL_ID")."'
		"; 
		$this->query = $str;
			// echo $str;
		return $this->execQuery($str);
	}

	function updateareadetil()
	{
		$str = "
		UPDATE OUTLINING_ASSESSMENT_AREA_DETIL
		SET
			OUTLINING_ASSESSMENT_DETIL_ID= ".$this->getField("OUTLINING_ASSESSMENT_DETIL_ID")."
			, OUTLINING_ASSESSMENT_ID = ".$this->getField("OUTLINING_ASSESSMENT_ID")."
			, AREA_UNIT_ID = ".$this->getField("AREA_UNIT_ID")."
			, AREA_UNIT_DETIL_ID = ".$this->getField("AREA_UNIT_DETIL_ID")."
			, LIST_AREA_ID = ".$this->getField("LIST_AREA_ID")."
			, ITEM_ASSESSMENT_DUPLIKAT_ID = ".$this->getField("ITEM_ASSESSMENT_DUPLIKAT_ID")."
			, ITEM_ASSESSMENT_FORMULIR_ID = ".$this->getField("ITEM_ASSESSMENT_FORMULIR_ID")."
			, ITEM_ASSESSMENT_ID = ".$this->getField("ITEM_ASSESSMENT_ID")."
			, STANDAR_REFERENSI_ID = ".$this->getField("STANDAR_REFERENSI_ID")."
			, STATUS_CONFIRM = ".$this->getField("STATUS_CONFIRM")."
			, KETERANGAN = '".$this->getField("KETERANGAN")."'
			, LAST_UPDATE_USER = '".$this->getField("LAST_UPDATE_USER")."'
			, LAST_UPDATE_DATE = ".$this->getField("LAST_UPDATE_DATE")."
			, LINK_FOTO = '".$this->getField("LINK_FOTO")."'
			, V_STATUS = ".$this->getField("V_STATUS")."

		WHERE OUTLINING_ASSESSMENT_AREA_DETIL_ID = '".$this->getField("OUTLINING_ASSESSMENT_AREA_DETIL_ID")."'
		"; 
		$this->query = $str;
			// echo $str;
		return $this->execQuery($str);
	}

	function updateareadetilfoto()
	{
		$str = "
		UPDATE OUTLINING_ASSESSMENT_AREA_DETIL
		SET
			LINK_FOTO = '".$this->getField("LINK_FOTO")."'
			, LAST_UPDATE_USER = '".$this->getField("LAST_UPDATE_USER")."'
			, LAST_UPDATE_DATE = ".$this->getField("LAST_UPDATE_DATE")."
		WHERE OUTLINING_ASSESSMENT_AREA_DETIL_ID = '".$this->getField("OUTLINING_ASSESSMENT_AREA_DETIL_ID")."'
		"; 
		$this->query = $str;
			// echo $str;
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

	function update_status_detil()
	{
		$str = "
		UPDATE OUTLINING_ASSESSMENT_DETIL
		SET
		STATUS_AKTIF = '".$this->getField("STATUS_AKTIF")."'
		WHERE OUTLINING_ASSESSMENT_ID = '".$this->getField("OUTLINING_ASSESSMENT_ID")."' AND AREA_UNIT_ID = ".$this->getField("AREA_UNIT_ID")." 
		";

		// echo $str; exit;

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

	function deletedetilblok()
	{
		$str = "
		DELETE FROM OUTLINING_ASSESSMENT_DETIL
		WHERE OUTLINING_ASSESSMENT_ID = ".$this->getField("OUTLINING_ASSESSMENT_ID")."
		AND BLOK_UNIT_ID = ".$this->getField("BLOK_UNIT_ID").";
		";

		$str .= "
		DELETE FROM OUTLINING_ASSESSMENT_BLOK_UNIT
		WHERE 
		OUTLINING_ASSESSMENT_ID = ".$this->getField("OUTLINING_ASSESSMENT_ID")."
		AND BLOK_UNIT_ID = ".$this->getField("BLOK_UNIT_ID").";

		;
		";  
		// echo $str; exit;
		$this->query = $str;
		return $this->execQuery($str);
	}


	function deletedetilnew()
	{
		$str = "
		DELETE FROM OUTLINING_ASSESSMENT_DETIL
		WHERE 
		OUTLINING_ASSESSMENT_ID = ".$this->getField("OUTLINING_ASSESSMENT_ID").";
		";

		$str .= "
		DELETE FROM OUTLINING_ASSESSMENT_AREA_DETIL
		WHERE 
		OUTLINING_ASSESSMENT_ID = ".$this->getField("OUTLINING_ASSESSMENT_ID").";
		"; 

		$str .= "
		DELETE FROM OUTLINING_ASSESSMENT_REKOMENDASI
		WHERE 
		OUTLINING_ASSESSMENT_ID = ".$this->getField("OUTLINING_ASSESSMENT_ID").";
		";  

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deleteareadetil()
	{
		$str = "
		DELETE FROM OUTLINING_ASSESSMENT_AREA_DETIL
		WHERE 
		OUTLINING_ASSESSMENT_AREA_DETIL_ID = ".$this->getField("OUTLINING_ASSESSMENT_AREA_DETIL_ID").";
		";

		$str .= "
		DELETE FROM OUTLINING_ASSESSMENT_REKOMENDASI
		WHERE 
		OUTLINING_ASSESSMENT_AREA_DETIL_ID = ".$this->getField("OUTLINING_ASSESSMENT_AREA_DETIL_ID").";
		"; 

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function deleteareadetilgambar()
	{

		$str = "
		UPDATE OUTLINING_ASSESSMENT_AREA_DETIL
		SET
		LINK_FOTO = ''
		WHERE OUTLINING_ASSESSMENT_AREA_DETIL_ID = '".$this->getField("OUTLINING_ASSESSMENT_AREA_DETIL_ID")."' AND OUTLINING_ASSESSMENT_ID = ".$this->getField("OUTLINING_ASSESSMENT_ID")." 
		";

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function deleteareadetilnew()
	{
		$str = "
		DELETE FROM OUTLINING_ASSESSMENT_AREA_DETIL
		WHERE 
		OUTLINING_ASSESSMENT_DETIL_ID = ".$this->getField("OUTLINING_ASSESSMENT_DETIL_ID")."
		AND OUTLINING_ASSESSMENT_ID = ".$this->getField("OUTLINING_ASSESSMENT_ID")."
		;
		";

		$str .= "
		DELETE FROM OUTLINING_ASSESSMENT_REKOMENDASI
		WHERE 
		OUTLINING_ASSESSMENT_DETIL_ID = ".$this->getField("OUTLINING_ASSESSMENT_DETIL_ID")."
		AND OUTLINING_ASSESSMENT_ID = ".$this->getField("OUTLINING_ASSESSMENT_ID")."
		;
		"; 

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function deleteareadetiltabel()
	{
		$str = "
		DELETE FROM OUTLINING_ASSESSMENT_DETIL
		WHERE 
		OUTLINING_ASSESSMENT_DETIL_ID = ".$this->getField("OUTLINING_ASSESSMENT_DETIL_ID")."
		AND OUTLINING_ASSESSMENT_ID = ".$this->getField("OUTLINING_ASSESSMENT_ID")."
		;
		"; 

		$str .= "
		DELETE FROM OUTLINING_ASSESSMENT_AREA_DETIL
		WHERE 
		OUTLINING_ASSESSMENT_DETIL_ID = ".$this->getField("OUTLINING_ASSESSMENT_DETIL_ID")."
		AND OUTLINING_ASSESSMENT_ID = ".$this->getField("OUTLINING_ASSESSMENT_ID")."
		;
		";

		$str .= "
		DELETE FROM OUTLINING_ASSESSMENT_REKOMENDASI
		WHERE 
		OUTLINING_ASSESSMENT_DETIL_ID = ".$this->getField("OUTLINING_ASSESSMENT_DETIL_ID")."
		AND OUTLINING_ASSESSMENT_ID = ".$this->getField("OUTLINING_ASSESSMENT_ID")."
		;
		"; 

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function deleterekomendasi()
	{
		$str = "
		DELETE FROM OUTLINING_ASSESSMENT_REKOMENDASI
		WHERE 
		OUTLINING_ASSESSMENT_REKOMENDASI_ID = ".$this->getField("OUTLINING_ASSESSMENT_REKOMENDASI_ID")."
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deleterekomendasifile()
	{

		$str = "
		UPDATE OUTLINING_ASSESSMENT_REKOMENDASI
		SET
		LINK_FILE = ''
		WHERE OUTLINING_ASSESSMENT_REKOMENDASI_ID = '".$this->getField("OUTLINING_ASSESSMENT_REKOMENDASI_ID")."' 
		";

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}



	function deleteblok()
	{
		$str = "
		DELETE FROM OUTLINING_ASSESSMENT_BLOK_UNIT
		WHERE 
		OUTLINING_ASSESSMENT_ID = ".$this->getField("OUTLINING_ASSESSMENT_ID").";
		";

	

		$this->query = $str;
		return $this->execQuery($str);
	}

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY OUTLINING_ASSESSMENT_ID ASC")
	{
		$str = "
			SELECT 
				A.*, B.NAMA DISTRIK_INFO, D.NAMA UNIT_MESIN_INFO
				, CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
				, CONCAT( A.BULAN,'',A.TAHUN) 
				,  BLOK_INFO
				, BLOK_UNIT_ID_INFO
			FROM OUTLINING_ASSESSMENT A
			INNER JOIN DISTRIK B ON B.DISTRIK_ID = A.DISTRIK_ID
			-- LEFT JOIN BLOK_UNIT C ON C.BLOK_UNIT_ID = A.BLOK_UNIT_ID
			LEFT JOIN
			(
				SELECT 
				A.OUTLINING_ASSESSMENT_ID
				,STRING_AGG(A.BLOK_UNIT_ID::TEXT, ', ') AS BLOK_UNIT_ID_INFO
				,STRING_AGG(B.NAMA::TEXT, ', ') AS BLOK_INFO
				FROM OUTLINING_ASSESSMENT_BLOK_UNIT A
				INNER JOIN BLOK_UNIT B ON B.BLOK_UNIT_ID = A.BLOK_UNIT_ID
				GROUP BY A.OUTLINING_ASSESSMENT_ID
			) C ON C.OUTLINING_ASSESSMENT_ID = A.OUTLINING_ASSESSMENT_ID
			LEFT JOIN UNIT_MESIN D ON D.UNIT_MESIN_ID = A.UNIT_MESIN_ID
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

	function selectByParamsApproval($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY OUTLINING_ASSESSMENT_ID ASC")
	{
		$str = "
			SELECT  
				A.*, B.NAMA DISTRIK_INFO,C.NAMA BLOK_INFO, D.NAMA UNIT_MESIN_INFO
				, CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
				, CONCAT( A.BULAN,'',A.TAHUN)  
			FROM OUTLINING_ASSESSMENT A
			INNER JOIN DISTRIK B ON B.DISTRIK_ID = A.DISTRIK_ID
			LEFT JOIN BLOK_UNIT C ON C.BLOK_UNIT_ID = A.BLOK_UNIT_ID
			LEFT JOIN UNIT_MESIN D ON D.UNIT_MESIN_ID = A.UNIT_MESIN_ID
			--INNER JOIN APPROVAL E ON E.REF_ID::INTEGER = A.OUTLINING_ASSESSMENT_ID AND E.REF_TABEL ='outlining_assessment'
			WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY OUTLINING_ASSESSMENT_ID,B.NAMA,C.NAMA,D.NAMA ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
	}

	// function selectByParamsRekomendasi($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.OUTLINING_ASSESSMENT_ID,A,OUTLINING_ASSESSMENT_DETIL_ID ASC")
	// {
	// 	$str = "
			
	// 		SELECT 
	// 			 A.OUTLINING_ASSESSMENT_REKOMENDASI_ID,A.OUTLINING_ASSESSMENT_ID,A.OUTLINING_ASSESSMENT_DETIL_ID,A.LIST_AREA_ID
	// 			 , A.ITEM_ASSESSMENT_DUPLIKAT_ID,A.REKOMENDASI,A.SEM_1_1,A.SEM_2_1,A.SEM_1_2,A.SEM_2_2,A.SEM_1_3,A.SEM_2_3
	// 			 , A.STATUS_CHECK,A.ANGGARAN
	// 			 , D.KODE || GENERATEZERO(E.KODE,2) ||' - '|| D.NAMA  AREA_INFO
	// 			 , F.NAMA NAMA_INFO
	// 			 , M.KETERANGAN
	// 			 , G.NAMA JENIS_INFO
	// 			 , H.NAMA PRIORITAS_INFO
	// 			 , I.NAMA KATEGORI_INFO
	// 			 , J.NAMA DISTRIK_INFO,K.NAMA BLOK_INFO, L.NAMA UNIT_MESIN_INFO
	// 			 , B.BULAN,B.TAHUN
	// 			 , A.OUTLINING_ASSESSMENT_AREA_DETIL_ID
	// 		FROM OUTLINING_ASSESSMENT_REKOMENDASI A
	// 		INNER JOIN OUTLINING_ASSESSMENT B ON B.OUTLINING_ASSESSMENT_ID = A.OUTLINING_ASSESSMENT_ID
	// 		INNER JOIN OUTLINING_ASSESSMENT_DETIL C ON C.OUTLINING_ASSESSMENT_DETIL_ID = A.OUTLINING_ASSESSMENT_DETIL_ID
	// 		INNER JOIN LIST_AREA  D ON D.LIST_AREA_ID = A.LIST_AREA_ID
	// 		INNER JOIN ITEM_ASSESSMENT_DUPLIKAT  E ON E.ITEM_ASSESSMENT_DUPLIKAT_ID = A.ITEM_ASSESSMENT_DUPLIKAT_ID AND E.LIST_AREA_ID = A.LIST_AREA_ID
	// 		INNER JOIN AREA_UNIT_DETIL F ON  F.AREA_UNIT_DETIL_ID=A.AREA_UNIT_DETIL_ID
	// 		LEFT JOIN JENIS_REKOMENDASI G ON  G.JENIS_REKOMENDASI_ID=A.JENIS_REKOMENDASI_ID
	// 		LEFT JOIN PRIORITAS_REKOMENDASI H ON  H.PRIORITAS_REKOMENDASI_ID=A.PRIORITAS_REKOMENDASI_ID 
	// 		LEFT JOIN KATEGORI_REKOMENDASI I ON  I.KATEGORI_REKOMENDASI_ID=A.KATEGORI_REKOMENDASI_ID
	// 		INNER JOIN DISTRIK J ON J.DISTRIK_ID = B.DISTRIK_ID
	// 		INNER JOIN BLOK_UNIT K ON K.BLOK_UNIT_ID = B.BLOK_UNIT_ID
	// 		INNER JOIN UNIT_MESIN L ON L.UNIT_MESIN_ID = B.UNIT_MESIN_ID
	// 		INNER JOIN OUTLINING_ASSESSMENT_AREA_DETIL M ON M.OUTLINING_ASSESSMENT_AREA_DETIL_ID = A.OUTLINING_ASSESSMENT_AREA_DETIL_ID  
	// 		WHERE 1=1
	// 	"; 
		
	// 	while(list($key,$val) = each($paramsArray))
	// 	{
	// 		$str .= " AND $key = '$val' ";
	// 	}
		
	// 	$str .= $statement." ".$sOrder;
	// 	$this->query = $str;
				
	// 	return $this->selectLimit($str,$limit,$from); 
	// }
	function selectByParamsRekomendasiMonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.OUTLINING_ASSESSMENT_ID")
	{
		$str = "
			SELECT 
				 A.*,J.NAMA DISTRIK_INFO,K.NAMA BLOK_INFO,L.NAMA UNIT_MESIN_INFO
			FROM OUTLINING_ASSESSMENT A
			INNER JOIN DISTRIK J ON J.DISTRIK_ID = A.DISTRIK_ID
			INNER JOIN BLOK_UNIT K ON K.BLOK_UNIT_ID = A.BLOK_UNIT_ID
			LEFT JOIN UNIT_MESIN L ON L.UNIT_MESIN_ID = A.UNIT_MESIN_ID
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
			LEFT JOIN  OUTLINING_ASSESSMENT B ON B.OUTLINING_ASSESSMENT_ID = A.OUTLINING_ASSESSMENT_ID
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

	function selectByParamsCheckDetil($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY OUTLINING_ASSESSMENT_DETIL_ID ASC")
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


	function selectByParamsDetilRekomendasi($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.OUTLINING_ASSESSMENT_REKOMENDASI_ID ASC")
	{
		$str = "
			SELECT 
				A.*
			FROM OUTLINING_ASSESSMENT_REKOMENDASI A
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

	function selectByParamsDetilAreaRekomendasi($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.OUTLINING_ASSESSMENT_AREA_DETIL_ID ASC")
	{
		$str = "
			SELECT 
				A.*,B.DISTRIK_ID,B.BLOK_UNIT_ID,B.UNIT_MESIN_ID
			FROM OUTLINING_ASSESSMENT_AREA_DETIL A
			INNER JOIN  OUTLINING_ASSESSMENT B ON B.OUTLINING_ASSESSMENT_ID = A.OUTLINING_ASSESSMENT_ID
			INNER JOIN OUTLINING_ASSESSMENT_DETIL D ON D.OUTLINING_ASSESSMENT_DETIL_ID = A.OUTLINING_ASSESSMENT_DETIL_ID
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

	function selectByParamsAreaDetil($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY OUTLINING_ASSESSMENT_AREA_DETIL_ID ASC")
	{
		$str = "
			SELECT 
				A.*,C.DISTRIK_ID,C.NAMA DISTRIK_NAMA,D.BLOK_UNIT_ID,D.NAMA BLOK_NAMA,E.UNIT_MESIN_ID,E.NAMA UNIT_NAMA,B1.NAMA ITEM_ASSESSMENT_INFO
			FROM OUTLINING_ASSESSMENT_AREA_DETIL A
			INNER JOIN OUTLINING_ASSESSMENT B ON B.OUTLINING_ASSESSMENT_ID = A.OUTLINING_ASSESSMENT_ID
			INNER JOIN ITEM_ASSESSMENT_FORMULIR B1 ON B1.ITEM_ASSESSMENT_FORMULIR_ID = A.ITEM_ASSESSMENT_FORMULIR_ID
			LEFT JOIN DISTRIK C ON C.DISTRIK_ID = B.DISTRIK_ID
			LEFT JOIN BLOK_UNIT D ON D.BLOK_UNIT_ID = B.BLOK_UNIT_ID
			LEFT JOIN UNIT_MESIN E ON E.UNIT_MESIN_ID = B.UNIT_MESIN_ID
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

	function selectByParamsRekomendasiDistrik($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY OUTLINING_ASSESSMENT_ID ASC")
	{
		$str = "
		select a.* 
		from (
				SELECT 
				A.OUTLINING_ASSESSMENT_ID,A.BULAN,A.TAHUN,A.DISTRIK_ID,C.NAMA DISTRIK_NAMA,D.NAMA BLOK_NAMA,E.NAMA UNIT_NAMA,D.BLOK_UNIT_ID ,
				case when f.sukses != 0 and f. belum_sukses = 0 then 'selesai' else 'belum' end statusnya
				FROM OUTLINING_ASSESSMENT A
				LEFT JOIN DISTRIK C ON C.DISTRIK_ID = A.DISTRIK_ID
				LEFT JOIN OUTLINING_ASSESSMENT_DETIL Z ON Z.OUTLINING_ASSESSMENT_ID = A.OUTLINING_ASSESSMENT_ID
				LEFT JOIN BLOK_UNIT D ON D.BLOK_UNIT_ID = Z.BLOK_UNIT_ID
				LEFT JOIN UNIT_MESIN E ON E.UNIT_MESIN_ID = A.UNIT_MESIN_ID
				left join 
				(
						SELECT 
						A.OUTLINING_ASSESSMENT_id, count (b.status_rekomendasi_id) belum_sukses, count (c.status_rekomendasi_id) sukses
					FROM OUTLINING_ASSESSMENT_AREA_DETIL A
					left join OUTLINING_ASSESSMENT_rekomendasi b on a.OUTLINING_ASSESSMENT_AREA_DETIL_id=b.OUTLINING_ASSESSMENT_AREA_DETIL_id and b.status_rekomendasi_id !='2'
					left join OUTLINING_ASSESSMENT_rekomendasi c on a.OUTLINING_ASSESSMENT_AREA_DETIL_id=c.OUTLINING_ASSESSMENT_AREA_DETIL_id and c.status_rekomendasi_id ='2'
					group by A.OUTLINING_ASSESSMENT_id
				) f on f.OUTLINING_ASSESSMENT_id=a.OUTLINING_ASSESSMENT_id
				GROUP BY A.BLOK_UNIT_ID,A.OUTLINING_ASSESSMENT_ID,A.BULAN,A.TAHUN,A.DISTRIK_ID,C.NAMA,D.NAMA,E.NAMA,D.BLOK_UNIT_ID,f.sukses,f. belum_sukses
					 
			) a
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement."  ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
	}

	function selectByParamsRekomendasiTahun($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
	{
		$str = "
		SELECT 
		A.TAHUN
		FROM OUTLINING_ASSESSMENT A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.TAHUN ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
	}


	function selectByParamsDetilNew($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY D.OUTLINING_ASSESSMENT_DETIL_ID ASC")
	{
		$str = "
		SELECT 
			A.KODE || GENERATEZERO(A1.KODE,2) KODE_INFO
			, CASE WHEN A.STATUS = 1 THEN 'TIDAK  AKTIF' ELSE 'AKTIF' END STATUS_INFO
			, A.*
			, A1.KODE KODE_DUPLIKAT
			, A1.ITEM_ASSESSMENT_DUPLIKAT_ID
			, B.NAMA AREA_UNIT
			, B.STATUS_KONFIRMASI STATUS_CONFIRM
			, B.AREA_UNIT_ID
			, B.AREA_UNIT_DETIL_ID
			, E.BLOK_UNIT_ID
			, E.NAMA NAMA_BLOK
			, F.NAMA NAMA_MESIN
		FROM LIST_AREA A 
		INNER JOIN ITEM_ASSESSMENT_DUPLIKAT A1 ON A.LIST_AREA_ID = A1.LIST_AREA_ID
		INNER JOIN AREA_UNIT_DETIL B ON B.ITEM_ASSESSMENT_DUPLIKAT_ID = A1.ITEM_ASSESSMENT_DUPLIKAT_ID AND B.LIST_AREA_ID = A1.LIST_AREA_ID
		INNER JOIN AREA_UNIT C ON C.AREA_UNIT_ID = B.AREA_UNIT_ID
		INNER JOIN OUTLINING_ASSESSMENT_DETIL D ON  D.AREA_UNIT_DETIL_ID = B.AREA_UNIT_DETIL_ID AND D.STATUS_AKTIF IS NULL
		LEFT JOIN BLOK_UNIT E ON E.BLOK_UNIT_ID = C.BLOK_UNIT_ID
		LEFT JOIN UNIT_MESIN F ON F.UNIT_MESIN_ID = C.UNIT_MESIN_ID
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


	function selectByParamsAssessmentDetil($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY OUTLINING_ASSESSMENT_DETIL_ID ASC")
	{
		$str = "
			SELECT A.*,F.KODE || GENERATEZERO(G.KODE,2) KODE_INFO,F.NAMA
			FROM OUTLINING_ASSESSMENT_DETIL A
			INNER JOIN OUTLINING_ASSESSMENT B ON B.OUTLINING_ASSESSMENT_ID = A.OUTLINING_ASSESSMENT_ID
			INNER JOIN DISTRIK C ON C.DISTRIK_ID = B.DISTRIK_ID
			LEFT JOIN BLOK_UNIT D ON D.BLOK_UNIT_ID = B.BLOK_UNIT_ID
			LEFT JOIN UNIT_MESIN E ON E.UNIT_MESIN_ID = B.UNIT_MESIN_ID
			INNER JOIN LIST_AREA F ON F.LIST_AREA_ID = A.LIST_AREA_ID
			INNER JOIN ITEM_ASSESSMENT_DUPLIKAT G ON G.ITEM_ASSESSMENT_DUPLIKAT_ID = A.ITEM_ASSESSMENT_DUPLIKAT_ID AND G.LIST_AREA_ID = A.LIST_AREA_ID
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

	function selectByParamsAreaDetilRekomendasi($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY OUTLINING_ASSESSMENT_AREA_DETIL_ID ASC")
	{
		$str = "
			SELECT 
				A.*,C.DISTRIK_ID,C.NAMA DISTRIK_NAMA,D.BLOK_UNIT_ID,D.NAMA BLOK_NAMA,E.UNIT_MESIN_ID,E.NAMA UNIT_NAMA,B1.NAMA ITEM_ASSESSMENT_INFO
				, F.OUTLINING_ASSESSMENT_REKOMENDASI_ID
			FROM OUTLINING_ASSESSMENT_AREA_DETIL A
			INNER JOIN OUTLINING_ASSESSMENT B ON B.OUTLINING_ASSESSMENT_ID = A.OUTLINING_ASSESSMENT_ID
			INNER JOIN ITEM_ASSESSMENT_FORMULIR B1 ON B1.ITEM_ASSESSMENT_FORMULIR_ID = A.ITEM_ASSESSMENT_FORMULIR_ID
			LEFT JOIN DISTRIK C ON C.DISTRIK_ID = B.DISTRIK_ID
			LEFT JOIN BLOK_UNIT D ON D.BLOK_UNIT_ID = B.BLOK_UNIT_ID
			LEFT JOIN UNIT_MESIN E ON E.UNIT_MESIN_ID = B.UNIT_MESIN_ID
			LEFT JOIN OUTLINING_ASSESSMENT_REKOMENDASI F ON F.OUTLINING_ASSESSMENT_AREA_DETIL_ID = A.OUTLINING_ASSESSMENT_AREA_DETIL_ID
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

	function selectByParamsTotalAreaRekomendasi($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
	{
		$str = "
		SELECT COUNT(B.OUTLINING_ASSESSMENT_AREA_DETIL_ID) AS SAMA, COUNT(A.OUTLINING_ASSESSMENT_AREA_DETIL_ID) AS TOTAL,
		CASE WHEN count(B.OUTLINING_ASSESSMENT_AREA_DETIL_ID) > 0 THEN
		ROUND(COUNT(B.OUTLINING_ASSESSMENT_AREA_DETIL_ID) * 100 /  SUM(COUNT(A.OUTLINING_ASSESSMENT_AREA_DETIL_ID)) OVER () )
		ELSE 0
		END
		PERSEN 
		FROM OUTLINING_ASSESSMENT_AREA_DETIL AS A 
		LEFT JOIN OUTLINING_ASSESSMENT_REKOMENDASI AS B ON A.OUTLINING_ASSESSMENT_AREA_DETIL_ID = B.OUTLINING_ASSESSMENT_AREA_DETIL_ID AND B.STATUS_REKOMENDASI_ID = 2 
		WHERE 1=1
		AND  A.STATUS_CONFIRM = 0 
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
	}

	function selectByParamsTotalAreaRekomendasiNonStatus($paramsArray=array(),$limit=-1,$from=-1, $statement='', $statementnew="", $sOrder="")
	{
		$str = "
		SELECT COUNT(B.OUTLINING_ASSESSMENT_AREA_DETIL_ID) AS SAMA, COUNT(A.OUTLINING_ASSESSMENT_AREA_DETIL_ID) AS TOTAL,
		CASE WHEN count(B.OUTLINING_ASSESSMENT_AREA_DETIL_ID) > 0 THEN
		ROUND(COUNT(B.OUTLINING_ASSESSMENT_AREA_DETIL_ID) * 100 /  SUM(COUNT(A.OUTLINING_ASSESSMENT_AREA_DETIL_ID)) OVER () )
		ELSE 0
		END
		PERSEN 
		FROM OUTLINING_ASSESSMENT_AREA_DETIL AS A 
		LEFT JOIN OUTLINING_ASSESSMENT_REKOMENDASI AS B ON A.OUTLINING_ASSESSMENT_AREA_DETIL_ID = B.OUTLINING_ASSESSMENT_AREA_DETIL_ID 
		WHERE 1=1
		AND  A.STATUS_CONFIRM = 0 
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
	}


	function selectByParamsTotalAreaDistrik($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
	{
		$str = "
		SELECT COUNT(B.OUTLINING_ASSESSMENT_DETIL_ID) AS SAMA, COUNT(A.OUTLINING_ASSESSMENT_DETIL_ID) AS TOTAL,
		CASE WHEN count(B.OUTLINING_ASSESSMENT_DETIL_ID) > 0 THEN
		ROUND(COUNT(B.OUTLINING_ASSESSMENT_DETIL_ID) * 100 /  SUM(COUNT(A.OUTLINING_ASSESSMENT_DETIL_ID)) OVER () )
		ELSE 0
		END
		PERSEN 
		FROM OUTLINING_ASSESSMENT_DETIL AS A 
		LEFT JOIN
		(
			SELECT B.OUTLINING_ASSESSMENT_DETIL_ID,COUNT(A.OUTLINING_ASSESSMENT_DETIL_ID) AS TOTAL
			FROM OUTLINING_ASSESSMENT_AREA_DETIL A
			INNER JOIN OUTLINING_ASSESSMENT_REKOMENDASI B ON A.OUTLINING_ASSESSMENT_AREA_DETIL_ID = B.OUTLINING_ASSESSMENT_AREA_DETIL_ID AND B.STATUS_REKOMENDASI_ID = 2
			WHERE A.STATUS_CONFIRM = 0 
			GROUP BY B.OUTLINING_ASSESSMENT_DETIL_ID
		) B ON B.OUTLINING_ASSESSMENT_DETIL_ID = A.OUTLINING_ASSESSMENT_DETIL_ID
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

	function selectByParamsTotalAllRekomendasi($paramsArray=array(),$limit=-1,$from=-1, $statement='',$statementnew='', $sOrder="")
	{
		$str = "
		SELECT
		JUMLAH_AREA_DETIL,
		JUMLAH_AREA,
		SUDAH_ISI
		,ROUND(PERSEN / JUMLAH_AREA_DETIL) TOTAL_PERSEN
		FROM
		(
			SELECT
			SUM (JUMLAH_DETIL) JUMLAH_AREA_DETIL
			, SUM(A.JUMLAH) JUMLAH_AREA
			, SUM(A.SUDAH_ISI) SUDAH_ISI
			,SUM(A.PERSEN) PERSEN
			, A.OUTLINING_ASSESSMENT_ID
			FROM
			(		
				SELECT
				COUNT(B.OUTLINING_ASSESSMENT_DETIL_ID) AS JUMLAH_DETIL
				, B.OUTLINING_ASSESSMENT_ID
				, B.OUTLINING_ASSESSMENT_DETIL_ID
				, B.JUMLAH
				, B.SUDAH_ISI
				,PERSENTASE(COALESCE(B.SUDAH_ISI,0), COALESCE(B.JUMLAH,0)) PERSEN
				FROM
				(
					SELECT A.OUTLINING_ASSESSMENT_DETIL_ID,A.OUTLINING_ASSESSMENT_ID,COUNT(A.OUTLINING_ASSESSMENT_DETIL_ID) AS JUMLAH
					,COUNT(C.OUTLINING_ASSESSMENT_DETIL_ID) AS SUDAH_ISI
					FROM OUTLINING_ASSESSMENT_DETIL AS A 
					INNER JOIN OUTLINING_ASSESSMENT_AREA_DETIL AS B ON A.OUTLINING_ASSESSMENT_DETIL_ID = B.OUTLINING_ASSESSMENT_DETIL_ID AND B.STATUS_CONFIRM = 0 
					LEFT JOIN
					(
						SELECT A.OUTLINING_ASSESSMENT_AREA_DETIL_ID,A.OUTLINING_ASSESSMENT_DETIL_ID
						FROM OUTLINING_ASSESSMENT_REKOMENDASI A
						WHERE 1=1
						AND A.STATUS_REKOMENDASI_ID = 2 
						GROUP BY A.OUTLINING_ASSESSMENT_AREA_DETIL_ID,A.OUTLINING_ASSESSMENT_DETIL_ID
					) C ON B.OUTLINING_ASSESSMENT_AREA_DETIL_ID = C.OUTLINING_ASSESSMENT_AREA_DETIL_ID
					WHERE 1=1
					".$statementnew."
					GROUP BY A.OUTLINING_ASSESSMENT_DETIL_ID
				) B
				GROUP BY B.OUTLINING_ASSESSMENT_DETIL_ID, B.JUMLAH, B.SUDAH_ISI, B.OUTLINING_ASSESSMENT_ID
			)A
			GROUP BY A.OUTLINING_ASSESSMENT_ID
		) Z
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


	function selectByParamsRekomendasi($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY OUTLINING_ASSESSMENT_REKOMENDASI_ID ASC")
	{
		$str = "
		SELECT A.*,B.WO || ' - ' || B.DESCRIPTION NAMA_WO
		FROM OUTLINING_ASSESSMENT_REKOMENDASI A
		LEFT JOIN WORK_ORDER B ON B.WORK_ORDER_ID = A.WORK_ORDER_ID
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

     function getCountByParamsAreaDetilRekomendasi($paramsArray=array(),$statement='')
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
		FROM OUTLINING_ASSESSMENT_AREA_DETIL a
		WHERE 1 = 1  ".$statement; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}

		// echo $str;
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsAreaDetilStatus($paramsArray=array(),$statement='')
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
			FROM OUTLINING_ASSESSMENT_AREA_DETIL A
			INNER JOIN OUTLINING_ASSESSMENT B ON B.OUTLINING_ASSESSMENT_ID = A.OUTLINING_ASSESSMENT_ID
			INNER JOIN ITEM_ASSESSMENT_FORMULIR B1 ON B1.ITEM_ASSESSMENT_FORMULIR_ID = A.ITEM_ASSESSMENT_FORMULIR_ID
			WHERE 1=1  ".$statement; 
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

     function getCountByParamsAreaDetil($paramsArray=array(),$statement='')
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
			FROM ITEM_ASSESSMENT_FORMULIR A 
			INNER JOIN ITEM_ASSESSMENT B ON B.ITEM_ASSESSMENT_ID = A.ITEM_ASSESSMENT_ID
			LEFT JOIN KATEGORI_ITEM_ASSESSMENT C ON C.KATEGORI_ITEM_ASSESSMENT_ID = A.KATEGORI_ITEM_ASSESSMENT_ID
			WHERE 1=1  ".$statement; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		// echo $str;
		$this->select($str); 
		
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function selectByParamsRekomendasiPercArea($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
	{
		$str = "
		SELECT  ROUND(SUM (A.PERSEN)/ SUM(A.TOTAL))  PERC_AREA FROM
		(
				SELECT COUNT(B.OUTLINING_ASSESSMENT_AREA_DETIL_ID) AS SAMA
				, COUNT(A.OUTLINING_ASSESSMENT_AREA_DETIL_ID) AS TOTAL,
				CASE WHEN count(B.OUTLINING_ASSESSMENT_DETIL_ID) > 0 THEN
				ROUND(COUNT(B.OUTLINING_ASSESSMENT_AREA_DETIL_ID) * 100 /  COUNT(A.OUTLINING_ASSESSMENT_AREA_DETIL_ID) )
				ELSE 0
				END
				PERSEN 
				FROM OUTLINING_ASSESSMENT_AREA_DETIL AS A 
				LEFT JOIN OUTLINING_ASSESSMENT_REKOMENDASI AS B ON A.OUTLINING_ASSESSMENT_AREA_DETIL_ID = B.OUTLINING_ASSESSMENT_AREA_DETIL_ID AND B.STATUS_REKOMENDASI_ID = 2 
				LEFT JOIN OUTLINING_ASSESSMENT_DETIL AS C ON C.OUTLINING_ASSESSMENT_DETIL_ID = A.OUTLINING_ASSESSMENT_DETIL_ID  
				WHERE 1=1
				AND  A.STATUS_CONFIRM = 0 
				".$statement."
				GROUP BY A.OUTLINING_ASSESSMENT_DETIL_ID
		) A

		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
	}
	 function selectByParamsRekomendasiTotalArea($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
	{
		$str = "
		SELECT COUNT (1) TOTAL_AREA
		FROM OUTLINING_ASSESSMENT_DETIL A
		INNER JOIN OUTLINING_ASSESSMENT B ON B.OUTLINING_ASSESSMENT_ID = A.OUTLINING_ASSESSMENT_ID
		INNER JOIN DISTRIK C ON C.DISTRIK_ID = B.DISTRIK_ID
		LEFT JOIN BLOK_UNIT D ON D.BLOK_UNIT_ID = B.BLOK_UNIT_ID
		LEFT JOIN UNIT_MESIN E ON E.UNIT_MESIN_ID = B.UNIT_MESIN_ID
		INNER JOIN LIST_AREA F ON F.LIST_AREA_ID = A.LIST_AREA_ID
		INNER JOIN ITEM_ASSESSMENT_DUPLIKAT G ON G.ITEM_ASSESSMENT_DUPLIKAT_ID = A.ITEM_ASSESSMENT_DUPLIKAT_ID AND G.LIST_AREA_ID = A.LIST_AREA_ID
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

	 function selectByParamsRekomendasiJumlahArea($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
	{
		$str = "
		SELECT COUNT(B.OUTLINING_ASSESSMENT_AREA_DETIL_ID) AS TERISI
		FROM OUTLINING_ASSESSMENT_AREA_DETIL AS A 
		INNER JOIN OUTLINING_ASSESSMENT_REKOMENDASI AS B ON A.OUTLINING_ASSESSMENT_AREA_DETIL_ID = B.OUTLINING_ASSESSMENT_AREA_DETIL_ID 
		INNER JOIN OUTLINING_ASSESSMENT_DETIL AS C ON C.OUTLINING_ASSESSMENT_DETIL_ID = A.OUTLINING_ASSESSMENT_DETIL_ID 
		WHERE 1=1
		AND  A.STATUS_CONFIRM = 0

		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
	}

	function selectByParamsRekomendasiJumlahAreaNew($paramsArray=array(),$limit=-1,$from=-1, $statement='',$statementnew='', $sOrder="")
	{
		$str = "
		SELECT COUNT(1) AS TERISI
		FROM 
		(
			SELECT  A.OUTLINING_ASSESSMENT_DETIL_ID,F.KODE,G.KODE,F.NAMA
			FROM OUTLINING_ASSESSMENT_DETIL A
			INNER JOIN OUTLINING_ASSESSMENT B ON B.OUTLINING_ASSESSMENT_ID = A.OUTLINING_ASSESSMENT_ID
			INNER JOIN DISTRIK C ON C.DISTRIK_ID = B.DISTRIK_ID
			LEFT JOIN BLOK_UNIT D ON D.BLOK_UNIT_ID = B.BLOK_UNIT_ID
			LEFT JOIN UNIT_MESIN E ON E.UNIT_MESIN_ID = B.UNIT_MESIN_ID
			INNER JOIN LIST_AREA F ON F.LIST_AREA_ID = A.LIST_AREA_ID
			INNER JOIN ITEM_ASSESSMENT_DUPLIKAT G ON G.ITEM_ASSESSMENT_DUPLIKAT_ID = A.ITEM_ASSESSMENT_DUPLIKAT_ID AND G.LIST_AREA_ID = A.LIST_AREA_ID
			INNER JOIN OUTLINING_ASSESSMENT_AREA_DETIL AS H ON H.OUTLINING_ASSESSMENT_DETIL_ID = A.OUTLINING_ASSESSMENT_DETIL_ID 
			INNER JOIN OUTLINING_ASSESSMENT_REKOMENDASI AS I ON I.OUTLINING_ASSESSMENT_AREA_DETIL_ID = H.OUTLINING_ASSESSMENT_AREA_DETIL_ID 

			WHERE 1=1
			".$statementnew."
			group by a.list_area_id,A.OUTLINING_ASSESSMENT_DETIL_ID,F.KODE,G.KODE,F.NAMA
		) A


		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
	}

	function selectByParamsRekomendasiMaxTahun($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
	{
		$str = "
		SELECT max(A.TAHUN) MaxTahun
		FROM OUTLINING_ASSESSMENT A
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

	function selectByParamsLastApproval($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY OUTLINING_ASSESSMENT_ID ASC")
	{
		$str = "
			SELECT  
				B.* 
			FROM OUTLINING_ASSESSMENT A
			INNER JOIN APPROVAL B ON B.REF_ID::INTEGER = A.OUTLINING_ASSESSMENT_ID AND B.REF_TABEL ='outlining_assessment'
			INNER JOIN PENGGUNA C ON C.ROLE_ID = B.NEXT_ROLE_ID 
			WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement."  ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
	}

	function selectByParamsLastApprovalNew($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY OUTLINING_ASSESSMENT_ID ASC")
	{
		$str = "
			SELECT  
				B.* 
			FROM OUTLINING_ASSESSMENT A
			INNER JOIN APPROVAL B ON B.REF_ID::INTEGER = A.OUTLINING_ASSESSMENT_ID AND B.REF_TABEL ='outlining_assessment_detil'
			INNER JOIN PENGGUNA C ON C.ROLE_ID = B.NEXT_ROLE_ID 
			WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement."  ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
	}

  
} 
?>