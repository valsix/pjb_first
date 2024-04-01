<? 
  include_once(APPPATH.'/models/Entity.php');

  class Import extends Entity{ 

	var $query;

    function Import()
	{
      $this->Entity(); 
    }


    function insertperusahaaneksternal()
    {
    	$this->setField("PERUSAHAAN_EKSTERNAL_ID", $this->getNextId("PERUSAHAAN_EKSTERNAL_ID","perusahaan_eksternal"));

    	$str = "
    	INSERT INTO perusahaan_eksternal
    	(
    		PERUSAHAAN_EKSTERNAL_ID, NAMA, KODE
    	)
    	VALUES 
    	(
	    	'".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("KODE")."'
	    )"; 

		$this->id= $this->getField("PERUSAHAAN_EKSTERNAL_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updateperusahaaneksternal()
	{
		$str = "
		UPDATE perusahaan_eksternal
		SET
		NAMA= '".$this->getField("NAMA")."'
		, KODE= '".$this->getField("KODE")."'
		WHERE PERUSAHAAN_EKSTERNAL_ID = '".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

    function insertdirektorat()
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

	function updatedirektorat()
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

	function insertwilayah()
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


	function updatewilayah()
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


	function insertjenis()
    {
    	$this->setField("JENIS_UNIT_KERJA_ID", $this->getNextId("JENIS_UNIT_KERJA_ID","JENIS_UNIT_KERJA"));

    	$str = "
    	INSERT INTO JENIS_UNIT_KERJA
    	(
    		JENIS_UNIT_KERJA_ID,NAMA,LAST_CREATE_USER,LAST_CREATE_DATE,KODE
    	)
    	VALUES 
    	(
    		".$this->getField("JENIS_UNIT_KERJA_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, '".$this->getField("KODE")."'
	    )"; 

	    $this->id= $this->getField("JENIS_UNIT_KERJA_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}


	function updatejenis()
	{
			$str = "
			UPDATE JENIS_UNIT_KERJA
			SET
			 NAMA= '".$this->getField("NAMA")."'
			, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
			, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
			, KODE= '".$this->getField("KODE")."'
			WHERE JENIS_UNIT_KERJA_ID = '".$this->getField("JENIS_UNIT_KERJA_ID")."'
			"; 
			$this->query = $str;
			// echo $str;exit;
			return $this->execQuery($str);
	}


	function insertarea()
    {
    	$this->setField("LIST_AREA_ID", $this->getNextId("LIST_AREA_ID","LIST_AREA"));

    	$str = "
    	INSERT INTO LIST_AREA
    	(
    		LIST_AREA_ID,KODE,NAMA,DESKRIPSI,LAST_CREATE_USER,LAST_CREATE_DATE
    	)
    	VALUES 
    	(
    		".$this->getField("LIST_AREA_ID")."
	    	, '".$this->getField("KODE")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("DESKRIPSI")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    )"; 

	    $this->id= $this->getField("LIST_AREA_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function updatearea()
	{
		$str = "
		UPDATE LIST_AREA
		SET
		KODE= '".$this->getField("KODE")."'
		, NAMA= '".$this->getField("NAMA")."'
		, DESKRIPSI= '".$this->getField("DESKRIPSI")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
		WHERE LIST_AREA_ID = '".$this->getField("LIST_AREA_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}

	function updateareaunit()
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


	function insertkategori()
    {
    	$this->setField("KATEGORI_ITEM_ASSESSMENT_ID", $this->getNextId("KATEGORI_ITEM_ASSESSMENT_ID","KATEGORI_ITEM_ASSESSMENT"));

    	$str = "
    	INSERT INTO KATEGORI_ITEM_ASSESSMENT
    	(
    		KATEGORI_ITEM_ASSESSMENT_ID,NAMA,BOBOT,LAST_CREATE_USER,LAST_CREATE_DATE,KODE
    	)
    	VALUES 
    	(
    		".$this->getField("KATEGORI_ITEM_ASSESSMENT_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, ".$this->getField("BOBOT")."
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, '".$this->getField("KODE")."'
	    )"; 

	    $this->id= $this->getField("KATEGORI_ITEM_ASSESSMENT_ID");
	    $this->query= $str;
			// echo $str;exit;
			
	    return $this->execQuery($str);
	}

	function updatekategori()
	{
		$str = "
		UPDATE KATEGORI_ITEM_ASSESSMENT
		SET
		 NAMA= '".$this->getField("NAMA")."'
		, KODE= '".$this->getField("KODE")."'
		, BOBOT= ".$this->getField("BOBOT")."
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
		WHERE KATEGORI_ITEM_ASSESSMENT_ID = '".$this->getField("KATEGORI_ITEM_ASSESSMENT_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}

	function insertstandar()
    {
    	// $this->setField("STANDAR_REFERENSI_ID", $this->getNextId("STANDAR_REFERENSI_ID","STANDAR_REFERENSI"));

    	$str = "
    	INSERT INTO STANDAR_REFERENSI
    	(
    		NAMA, NOMOR, KLAUSUL, DESKRIPSI, TAHUN, LAST_CREATE_USER,LAST_CREATE_DATE,KODE,BAB
    	)
    	VALUES 
    	(
	    	 '".$this->getField("NAMA")."'
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

	function updatestandar()
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

	function insertkonfirmasi()
    {
    	$this->setField("KONFIRMASI_ITEM_ASSESSMENT_ID", $this->getNextId("KONFIRMASI_ITEM_ASSESSMENT_ID","KONFIRMASI_ITEM_ASSESSMENT"));

    	$str = "
    	INSERT INTO KONFIRMASI_ITEM_ASSESSMENT
    	(
    		KONFIRMASI_ITEM_ASSESSMENT_ID,NAMA,KETERANGAN,LAST_CREATE_USER,LAST_CREATE_DATE,KODE,NILAI
    	)
    	VALUES 
    	(
    		".$this->getField("KONFIRMASI_ITEM_ASSESSMENT_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("KETERANGAN")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, '".$this->getField("KODE")."'
	    	, ".$this->getField("NILAI")."
	    )"; 

	    $this->id= $this->getField("KONFIRMASI_ITEM_ASSESSMENT_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function updatekonfirmasi()
	{
		$str = "
		UPDATE KONFIRMASI_ITEM_ASSESSMENT
		SET
		KONFIRMASI_ITEM_ASSESSMENT_ID= ".$this->getField("KONFIRMASI_ITEM_ASSESSMENT_ID")."
		, NAMA= '".$this->getField("NAMA")."'
		, KETERANGAN= '".$this->getField("KETERANGAN")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
		, KODE= '".$this->getField("KODE")."'
		, NILAI= ".$this->getField("NILAI")."
		WHERE KONFIRMASI_ITEM_ASSESSMENT_ID = '".$this->getField("KONFIRMASI_ITEM_ASSESSMENT_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}


	function insertprogram()
    {
    	$this->setField("PROGRAM_ITEM_ASSESSMENT_ID", $this->getNextId("PROGRAM_ITEM_ASSESSMENT_ID","PROGRAM_ITEM_ASSESSMENT"));

    	$str = "
    	INSERT INTO PROGRAM_ITEM_ASSESSMENT
    	(
    		PROGRAM_ITEM_ASSESSMENT_ID,NAMA,LAST_CREATE_USER,LAST_CREATE_DATE,KODE
    	)
    	VALUES 
    	(
    		".$this->getField("PROGRAM_ITEM_ASSESSMENT_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, '".$this->getField("KODE")."'
	    )"; 

	    $this->id= $this->getField("PROGRAM_ITEM_ASSESSMENT_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function updateprogram()
	{
		$str = "
		UPDATE PROGRAM_ITEM_ASSESSMENT
		SET
		PROGRAM_ITEM_ASSESSMENT_ID= ".$this->getField("PROGRAM_ITEM_ASSESSMENT_ID")."
		, NAMA= '".$this->getField("NAMA")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
		, KODE= '".$this->getField("KODE")."'
		, RATING= ".$this->getField("RATING")."
		WHERE PROGRAM_ITEM_ASSESSMENT_ID = '".$this->getField("PROGRAM_ITEM_ASSESSMENT_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}

	function insertPeraturan()
    {
    	$this->setField("PERATURAN_ID", $this->getNextId("PERATURAN_ID","PERATURAN"));

    	$str = "
    	INSERT INTO PERATURAN
    	(
    		PERATURAN_ID,NAMA,LAST_CREATE_USER,LAST_CREATE_DATE
    	)
    	VALUES 
    	(
    		".$this->getField("PERATURAN_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    )"; 

	    $this->id= $this->getField("PERATURAN_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function updatePeraturan()
	{
		$str = "
		UPDATE PERATURAN
		SET
		PERATURAN_ID= ".$this->getField("PERATURAN_ID")."
		, NAMA= '".$this->getField("NAMA")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
		WHERE PERATURAN_ID = '".$this->getField("PERATURAN_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
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

	function insertstandaritem()
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

	    $this->id= $this->getField("ITEM_ASSESSMENT_STANDAR_ID");
	    $this->query= $str;
		// echo $str;
	    return $this->execQuery($str);
	}


	function insertjenisrekomendasi()
    {
    	$this->setField("JENIS_REKOMENDASI_ID", $this->getNextId("JENIS_REKOMENDASI_ID","JENIS_REKOMENDASI"));

    	$str = "
    	INSERT INTO JENIS_REKOMENDASI
    	(
    		JENIS_REKOMENDASI_ID,NAMA,LAST_CREATE_USER,LAST_CREATE_DATE,KODE
    	)
    	VALUES 
    	(
    		".$this->getField("JENIS_REKOMENDASI_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, '".$this->getField("KODE")."'
	    )"; 

	    $this->id= $this->getField("JENIS_REKOMENDASI_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	
	function updatejenisrekomendasi()
	{
			$str = "
			UPDATE JENIS_REKOMENDASI
			SET
			 NAMA= '".$this->getField("NAMA")."'
			, KODE= '".$this->getField("KODE")."'
			, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
			, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
			WHERE JENIS_REKOMENDASI_ID = '".$this->getField("JENIS_REKOMENDASI_ID")."'
			"; 
			$this->query = $str;
			// echo $str;exit;
			return $this->execQuery($str);
	}

	function insertkategorirekomendasi()
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

	
	function updatekategorirekomendasi()
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


    function insertprioritasrekomendasi()
    {
    	$this->setField("PRIORITAS_REKOMENDASI_ID", $this->getNextId("PRIORITAS_REKOMENDASI_ID","PRIORITAS_REKOMENDASI"));

    	$str = "
    	INSERT INTO PRIORITAS_REKOMENDASI
    	(
    		PRIORITAS_REKOMENDASI_ID,NAMA,LAST_CREATE_USER,LAST_CREATE_DATE,KODE
    	)
    	VALUES 
    	(
    		".$this->getField("PRIORITAS_REKOMENDASI_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, '".$this->getField("KODE")."'
	    )"; 

	    $this->id= $this->getField("PRIORITAS_REKOMENDASI_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function updateprioritasrekomendasi()
	{
			$str = "
			UPDATE PRIORITAS_REKOMENDASI
			SET
			 NAMA= '".$this->getField("NAMA")."'
			, KODE= '".$this->getField("KODE")."'
			, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
			, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
			WHERE PRIORITAS_REKOMENDASI_ID = '".$this->getField("PRIORITAS_REKOMENDASI_ID")."'
			"; 
			$this->query = $str;
			// echo $str;exit;
			return $this->execQuery($str);
	}


    function insertstatusrekomendasi()
    {
    	$this->setField("STATUS_REKOMENDASI_ID", $this->getNextId("STATUS_REKOMENDASI_ID","STATUS_REKOMENDASI"));

    	$str = "
    	INSERT INTO STATUS_REKOMENDASI
    	(
    		STATUS_REKOMENDASI_ID,NAMA,LAST_CREATE_USER,LAST_CREATE_DATE,KODE
    	)
    	VALUES 
    	(
    		".$this->getField("STATUS_REKOMENDASI_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, '".$this->getField("KODE")."'
	    )"; 

	    $this->id= $this->getField("STATUS_REKOMENDASI_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function updatestatusrekomendasi()
	{
			$str = "
			UPDATE STATUS_REKOMENDASI
			SET
			 NAMA= '".$this->getField("NAMA")."'
			, KODE= '".$this->getField("KODE")."'
			, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
			, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
			WHERE STATUS_REKOMENDASI_ID = '".$this->getField("STATUS_REKOMENDASI_ID")."'
			"; 
			$this->query = $str;
			// echo $str;exit;
			return $this->execQuery($str);
	}

	function insertTimelineRekomendasi()
    {
    	$this->setField("TIMELINE_REKOMENDASI_ID", $this->getNextId("TIMELINE_REKOMENDASI_ID","TIMELINE_REKOMENDASI"));

    	$str = "
    	INSERT INTO TIMELINE_REKOMENDASI
    	(
    		TIMELINE_REKOMENDASI_ID,NAMA,TAHUN,LAST_CREATE_USER,LAST_CREATE_DATE,KODE
    	)
    	VALUES 
    	(
    		".$this->getField("TIMELINE_REKOMENDASI_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, ".$this->getField("TAHUN")."
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, '".$this->getField("KODE")."'
	    )"; 

	    $this->id= $this->getField("TIMELINE_REKOMENDASI_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function updateTimelineRekomendasi()
	{
			$str = "
			UPDATE TIMELINE_REKOMENDASI
			SET
			 NAMA= '".$this->getField("NAMA")."'
			, KODE= '".$this->getField("KODE")."'
			, TAHUN= ".$this->getField("TAHUN")."
			, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
			, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
			WHERE TIMELINE_REKOMENDASI_ID = '".$this->getField("TIMELINE_REKOMENDASI_ID")."'
			"; 
			$this->query = $str;
			// echo $str;exit;
			return $this->execQuery($str);
	}

	function insertSumberAnggaran()
    {
    	$this->setField("SUMBER_ANGGARAN_ID", $this->getNextId("SUMBER_ANGGARAN_ID","sumber_anggaran"));

    	$str = "
    	INSERT INTO sumber_anggaran
    	(
    		SUMBER_ANGGARAN_ID, NAMA, KODE
    	)
    	VALUES 
    	(
	    	'".$this->getField("SUMBER_ANGGARAN_ID")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("KODE")."'
	    )"; 

		$this->id= $this->getField("SUMBER_ANGGARAN_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updateSumberAnggaran()
	{
		$str = "
		UPDATE sumber_anggaran
		SET
		NAMA= '".$this->getField("NAMA")."'
		, KODE= '".$this->getField("KODE")."'
		WHERE SUMBER_ANGGARAN_ID = '".$this->getField("SUMBER_ANGGARAN_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function insertrisiko()
    {
    	$this->setField("RISIKO_ID", $this->getNextId("RISIKO_ID","RISIKO"));

    	$str = "
    	INSERT INTO RISIKO
    	(
    		RISIKO_ID,NAMA,LAST_CREATE_USER,LAST_CREATE_DATE,KODE,PERATURAN_ID
    	)
    	VALUES 
    	(
    		".$this->getField("RISIKO_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, '".$this->getField("KODE")."'
	    	, ".$this->getField("PERATURAN_ID")."
	    	
	    )"; 

	    $this->id= $this->getField("RISIKO_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function updaterisiko()
	{
		$str = "
		UPDATE RISIKO
		SET
		RISIKO_ID= ".$this->getField("RISIKO_ID")."
		, NAMA= '".$this->getField("NAMA")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
		, KODE= '".$this->getField("KODE")."'
		, PERATURAN_ID= ".$this->getField("PERATURAN_ID")."
		WHERE RISIKO_ID = '".$this->getField("RISIKO_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}


    function insertblok()
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

	function insertunitmesin()
    {
    	$this->setField("UNIT_MESIN_ID", $this->getNextId("UNIT_MESIN_ID","unit_mesin"));

    	$str = "
    	INSERT INTO unit_mesin
    	(
    		UNIT_MESIN_ID, NAMA, DISTRIK_ID,BLOK_UNIT_ID
    	)
    	VALUES 
    	(
	    	'".$this->getField("UNIT_MESIN_ID")."'
	    	, '".$this->getField("NAMA")."'
	    	, ".$this->getField("DISTRIK_ID")."
	    	, ".$this->getField("BLOK_UNIT_ID")."
	    )"; 

		$this->id= $this->getField("UNIT_MESIN_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	 function insertdampak()
    {
    	$this->setField("DAMPAK_ID", $this->getNextId("DAMPAK_ID","DAMPAK"));

    	$str = "
    	INSERT INTO DAMPAK
    	(
    		DAMPAK_ID,NAMA,BOBOT,LAST_CREATE_USER,LAST_CREATE_DATE,KODE,PERATURAN_ID,N_MIN,N_MAX
    	)
    	VALUES 
    	(
    		".$this->getField("DAMPAK_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, ".$this->getField("BOBOT")."
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, '".$this->getField("KODE")."'
	    	, ".$this->getField("PERATURAN_ID")."
	    	, ".$this->getField("N_MIN")."
	    	, ".$this->getField("N_MAX")."
	    )"; 

	    $this->id= $this->getField("DAMPAK_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function updatedampak()
	{
		$str = "
		UPDATE DAMPAK
		SET
		DAMPAK_ID= ".$this->getField("DAMPAK_ID")."
		, NAMA= '".$this->getField("NAMA")."'
		, BOBOT= ".$this->getField("BOBOT")."
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
		, KODE= '".$this->getField("KODE")."'
		, PERATURAN_ID= ".$this->getField("PERATURAN_ID")."
		, N_MIN= ".$this->getField("N_MIN")."
		, N_MAX= ".$this->getField("N_MAX")."
		WHERE DAMPAK_ID = '".$this->getField("DAMPAK_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}


    function insertkemungkinan()
    {
    	$this->setField("KEMUNGKINAN_ID", $this->getNextId("KEMUNGKINAN_ID","KEMUNGKINAN"));

    	$str = "
    	INSERT INTO KEMUNGKINAN
    	(
    		KEMUNGKINAN_ID,NAMA,BOBOT,LAST_CREATE_USER,LAST_CREATE_DATE,KODE,PERATURAN_ID,N_MIN,N_MAX
    	)
    	VALUES 
    	(
    		".$this->getField("KEMUNGKINAN_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, ".$this->getField("BOBOT")."
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, '".$this->getField("KODE")."'
	    	, ".$this->getField("PERATURAN_ID")."
	    	, ".$this->getField("N_MIN")."
	    	, ".$this->getField("N_MAX")."
	    )"; 

	    $this->id= $this->getField("KEMUNGKINAN_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function updatekemungkinan()
	{
		$str = "
		UPDATE KEMUNGKINAN
		SET
		KEMUNGKINAN_ID= ".$this->getField("KEMUNGKINAN_ID")."
		, NAMA= '".$this->getField("NAMA")."'
		, BOBOT= ".$this->getField("BOBOT")."
		, KODE= '".$this->getField("KODE")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
		, PERATURAN_ID= ".$this->getField("PERATURAN_ID")."
		, N_MIN= ".$this->getField("N_MIN")."
		, N_MAX= ".$this->getField("N_MAX")."
		WHERE KEMUNGKINAN_ID = '".$this->getField("KEMUNGKINAN_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}

	 function insertmatriksrisiko()
    {
    	$this->setField("MATRIKS_RISIKO_ID", $this->getNextId("MATRIKS_RISIKO_ID","MATRIKS_RISIKO"));

    	$str = "
    	INSERT INTO MATRIKS_RISIKO
    	(
    		MATRIKS_RISIKO_ID,RISIKO_ID, DAMPAK_ID, KEMUNGKINAN_ID, LINK_FILE,LAST_CREATE_USER,LAST_CREATE_DATE,KODE
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
	    )"; 

	    $this->id= $this->getField("MATRIKS_RISIKO_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	 function insertdistrik()
    {
    	$this->setField("DISTRIK_ID", $this->getNextId("DISTRIK_ID","distrik"));

    	$str = "
    	INSERT INTO distrik
    	(
    		DISTRIK_ID, KODE_SITE, NAMA, KODE, WILAYAH_ID, PERUSAHAAN_EKSTERNAL_ID,DIREKTORAT_ID
    	)
    	VALUES 
    	(
	    	'".$this->getField("DISTRIK_ID")."'
	    	, '".$this->getField("KODE_SITE")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("KODE")."'
	    	, ".$this->getField("WILAYAH_ID")."
	    	, ".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."
	    	, ".$this->getField("DIREKTORAT_ID")."
	    )"; 

		$this->id= $this->getField("DISTRIK_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	
	function updatematriksrisiko()
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

	function deleteGroupStateDetail()
	{
		$str = "
		DELETE FROM GROUP_STATE_DETAIL
		WHERE 
		GROUP_STATE_ID = ".$this->getField("GROUP_STATE_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}


	function selectByParamsCheckPerusahaanExternal($paramsArray=array(),$limit=-1,$from=-1, $distrikment='', $sOrder="ORDER BY PERUSAHAAN_EKSTERNAL_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM perusahaan_eksternal A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $distrikment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsCheckDirektorat($paramsArray=array(),$limit=-1,$from=-1, $distrikment='', $sOrder="ORDER BY DIREKTORAT_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM DIREKTORAT A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $distrikment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsCheckWilayah($paramsArray=array(),$limit=-1,$from=-1, $distrikment='', $sOrder="ORDER BY WILAYAH_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM WILAYAH A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $distrikment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

     function selectByParamsCheckDistrik($paramsArray=array(),$limit=-1,$from=-1, $distrikment='', $sOrder="ORDER BY DISTRIK_ID ASC")
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
		
		$str .= $distrikment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsCheckJenisUnit($paramsArray=array(),$limit=-1,$from=-1, $distrikment='', $sOrder="ORDER BY JENIS_UNIT_KERJA_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM JENIS_UNIT_KERJA A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $distrikment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsCheckArea($paramsArray=array(),$limit=-1,$from=-1, $distrikment='', $sOrder="ORDER BY LIST_AREA_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM LIST_AREA A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $distrikment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsCheckKategori($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY KATEGORI_ITEM_ASSESSMENT_ID ASC")
	{
		$str = "
			SELECT 
				A.*,
			CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
			FROM KATEGORI_ITEM_ASSESSMENT A
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

	function selectByParamsCheckStandar($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY STANDAR_REFERENSI_ID ASC")
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


	function selectByParamsCheckKonfirmasi($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY KONFIRMASI_ITEM_ASSESSMENT_ID ASC")
	{
		$str = "
			SELECT 
				A.*,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
			FROM KONFIRMASI_ITEM_ASSESSMENT A 
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

	function selectByParamsCheckProgram($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY PROGRAM_ITEM_ASSESSMENT_ID ASC")
	{
		$str = "
			SELECT 
				A.*,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
			FROM PROGRAM_ITEM_ASSESSMENT A 
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

	function selectByParamsCheckPeraturan($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY PERATURAN_ID ASC")
	{
		$str = "
			SELECT 
				A.*,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
			FROM PERATURAN A 
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

	function selectByParamsCheckJenisRekomendasi($paramsArray=array(),$limit=-1,$from=-1, $distrikment='', $sOrder="ORDER BY JENIS_REKOMENDASI_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM JENIS_REKOMENDASI A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $distrikment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


	function selectByParamsKategoriRekomendasi($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY KATEGORI_REKOMENDASI_ID ASC")
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

	function selectByParamsPrioritasRekomendasi($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY PRIORITAS_REKOMENDASI_ID ASC")
	{
		$str = "
			SELECT 
				A.*,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
			FROM PRIORITAS_REKOMENDASI A 
			
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


	function selectByParamsStatusRekomendasi($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY STATUS_REKOMENDASI_ID ASC")
	{
		$str = "
			SELECT 
				A.*,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
			FROM STATUS_REKOMENDASI A 
			
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

	function selectByParamsTimelineRekomendasi($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY TIMELINE_REKOMENDASI_ID ASC")
	{
		$str = "
			SELECT 
				A.*,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
			FROM TIMELINE_REKOMENDASI A 
			
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

	 function selectByParamsSumberAnggaran($paramsArray=array(),$limit=-1,$from=-1, $sumber_anggaranment='', $sOrder="ORDER BY SUMBER_ANGGARAN_ID ASC")
	{
		$str = "
		SELECT 
			A.*
			,CASE WHEN A.STATUS = '1' THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
		FROM sumber_anggaran A 
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $sumber_anggaranment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsRisiko($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY RISIKO_ID ASC")
	{
		$str = "
			SELECT 
				A.*,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
				, B.NAMA PERATURAN_INFO
			FROM RISIKO A
			LEFT JOIN  PERATURAN B ON B.PERATURAN_ID = A.PERATURAN_ID
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


	function selectByParamsDampak($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY DAMPAK_ID ASC")
	{
		$str = "
			SELECT 
				A.*,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
				, B.NAMA PERATURAN_INFO
			FROM DAMPAK A 
			LEFT JOIN  PERATURAN B ON B.PERATURAN_ID = A.PERATURAN_ID
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

	function selectByParamsKemungkinan($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY KEMUNGKINAN_ID ASC")
	{
		$str = "
			SELECT 
				A.*,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
				, B.NAMA PERATURAN_INFO
			FROM KEMUNGKINAN A 
			LEFT JOIN  PERATURAN B ON B.PERATURAN_ID = A.PERATURAN_ID
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

	function selectByParamsCheckJabatan($paramsArray=array(),$limit=-1,$from=-1, $pengguna_externalment='', $sOrder="ORDER BY POSITION_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM MASTER_JABATAN A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $pengguna_externalment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function insertjabatan()
  	{
	    $str = "
	    INSERT INTO MASTER_JABATAN
	    (
	        POSITION_ID, NAMA_POSISI, SUPERIOR_ID, KODE_KATEGORI, KATEGORI, KODE_KELOMPOK_JABATAN, KELOMPOK_JABATAN
	        , KODE_JENJANG_JABATAN, JENJANG_JABATAN, KODE_KLASIFIKASI_UNIT, KLASIFIKASI_UNIT, KODE_UNIT, UNIT, KODE_DITBID, DITBID, KODE_BAGIAN, BAGIAN,OCCUP_STATUS,NAMA_LENGKAP,EMAIL,NID,POSISI,CHANGE_REASON,KODE_DISTRIK
	    )
	    VALUES 
	    (
	     	'".$this->getField("POSITION_ID")."'
	      , '".$this->getField("NAMA_POSISI")."'
	      , '".$this->getField("SUPERIOR_ID")."'
	      , '".$this->getField("KODE_KATEGORI")."'
	      , '".$this->getField("KATEGORI")."'
	      , '".$this->getField("KODE_KELOMPOK_JABATAN")."'
	      , '".$this->getField("KELOMPOK_JABATAN")."'
	      , '".$this->getField("KODE_JENJANG_JABATAN")."'
	      , '".$this->getField("JENJANG_JABATAN")."'
	      , '".$this->getField("KODE_KLASIFIKASI_UNIT")."'
	      , '".$this->getField("KLASIFIKASI_UNIT")."'
	      , '".$this->getField("KODE_UNIT")."'
	      , '".$this->getField("UNIT")."'
	      , '".$this->getField("KODE_DITBID")."'
	      , '".$this->getField("DITBID")."'
	      , '".$this->getField("KODE_BAGIAN")."'
	      , '".$this->getField("BAGIAN")."'
	      , '".$this->getField("OCCUP_STATUS")."'
	      , '".$this->getField("NAMA_LENGKAP")."'
	      , '".$this->getField("EMAIL")."'
	      , '".$this->getField("NID")."'
	      , '".$this->getField("POSISI")."'
	      , '".$this->getField("CHANGE_REASON")."'
	      , '".$this->getField("KODE_DISTRIK")."'
	    )"; 
	    $this->query= $str;
	    // echo $str;exit;
	    return $this->execQuery($str);
  	}

  	function selectByParamsCheckPenggunaEksternal($paramsArray=array(),$limit=-1,$from=-1, $pengguna_externalment='', $sOrder="ORDER BY PENGGUNA_EXTERNAL_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM pengguna_external A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $pengguna_externalment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

   	function selectByParamsCheckMasterJabatan($paramsArray=array(),$limit=-1,$from=-1, $pengguna_externalment='', $sOrder="ORDER BY POSITION_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM master_jabatan A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $pengguna_externalment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsCheckRole($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY ROLE_ID ASC")
	{
		$str = "
			SELECT 
				A.*
			FROM ROLE_APPROVAL A 
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

	function insertpenggunaeksternal()
    {
    	$this->setField("PENGGUNA_EXTERNAL_ID", $this->getNextId("PENGGUNA_EXTERNAL_ID","pengguna_external"));

    	$str = "
    	INSERT INTO pengguna_external
    	(
    		PENGGUNA_EXTERNAL_ID,DISTRIK_ID,POSITION_ID,ROLE_ID,PERUSAHAAN_EKSTERNAL_ID, NID, NAMA, STATUS, NO_TELP, EMAIL, FOTO, PASSWORD,EXPIRED_DATE
    	)
    	VALUES 
    	(
	    	".$this->getField("PENGGUNA_EXTERNAL_ID")."
	    	, ".$this->getField("DISTRIK_ID")."
	    	, '".$this->getField("POSITION_ID")."'
	    	, ".$this->getField("ROLE_ID")."
	    	, ".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."
	    	, '".$this->getField("NID")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("STATUS")."'
	    	, ".$this->getField("NO_TELP")."
	    	, '".$this->getField("EMAIL")."'
	    	, '".$this->getField("FOTO")."'
	    	, '".$this->getField("PASSWORD")."'
	    	, ".$this->getField("EXPIRED_DATE")."
	    )"; 

		$this->id= $this->getField("PENGGUNA_EXTERNAL_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updatepenggunaeksternal()
	{
		$str = "
		UPDATE pengguna_external
		SET
		DISTRIK_ID = ".$this->getField("DISTRIK_ID")."
		, POSITION_ID = '".$this->getField("POSITION_ID")."'
		, ROLE_ID = ".$this->getField("ROLE_ID")."
		, PERUSAHAAN_EKSTERNAL_ID = ".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."
		, NID = '".$this->getField("NID")."'
		, NAMA = '".$this->getField("NAMA")."'
		, STATUS = '".$this->getField("STATUS")."'
		, NO_TELP = ".$this->getField("NO_TELP")."
		, EMAIL = '".$this->getField("EMAIL")."'
		, EXPIRED_DATE = ".$this->getField("EXPIRED_DATE")."
		WHERE PENGGUNA_EXTERNAL_ID = '".$this->getField("PENGGUNA_EXTERNAL_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function disabletriggerstandar()
	{
		$str = "
		ALTER TABLE STANDAR_REFERENSI DISABLE TRIGGER kode_standar_t
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function enabletriggerstandar()
	{
		$str = "
		ALTER TABLE STANDAR_REFERENSI ENABLE TRIGGER kode_standar_t
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

  } 
?>