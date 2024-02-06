<? 
  include_once(APPPATH.'/models/Entity.php');

  class MasterJabatan extends Entity{ 

	var $query;

    function MasterJabatan()
	{
      $this->Entity(); 
    }

   function insert()
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

	function update()
	{
	    $str = "
	    UPDATE MASTER_JABATAN 
	    SET
	      NAMA_POSISI= '".$this->getField("NAMA_POSISI")."'
	      , SUPERIOR_ID= '".$this->getField("SUPERIOR_ID")."'
	      , KODE_KATEGORI= '".$this->getField("KODE_KATEGORI")."'
	      , KATEGORI= '".$this->getField("KATEGORI")."'
	      , KODE_KELOMPOK_JABATAN= '".$this->getField("KODE_KELOMPOK_JABATAN")."'
	      , KELOMPOK_JABATAN= '".$this->getField("KELOMPOK_JABATAN")."'
	      , KODE_JENJANG_JABATAN= '".$this->getField("KODE_JENJANG_JABATAN")."'
	      , JENJANG_JABATAN= '".$this->getField("JENJANG_JABATAN")."'
	      , KODE_KLASIFIKASI_UNIT= '".$this->getField("KODE_KLASIFIKASI_UNIT")."'
	      , KLASIFIKASI_UNIT= '".$this->getField("KLASIFIKASI_UNIT")."'
	      , KODE_UNIT= '".$this->getField("KODE_UNIT")."'
	      , UNIT= '".$this->getField("UNIT")."'
	      , KODE_DITBID= '".$this->getField("KODE_DITBID")."'
	      , DITBID= '".$this->getField("DITBID")."'
	      , KODE_BAGIAN= '".$this->getField("KODE_BAGIAN")."'
	      , BAGIAN= '".$this->getField("BAGIAN")."'
	      , OCCUP_STATUS= '".$this->getField("OCCUP_STATUS")."'
	      , NAMA_LENGKAP= '".$this->getField("NAMA_LENGKAP")."'
	      , EMAIL= '".$this->getField("EMAIL")."'
	      , NID= '".$this->getField("NID")."'
	      , POSISI= '".$this->getField("POSISI")."'
	      , CHANGE_REASON= '".$this->getField("CHANGE_REASON")."'
	      , KODE_DISTRIK= '".$this->getField("KODE_DISTRIK")."'
	    WHERE POSITION_ID = '".$this->getField("POSITION_ID")."'
	    "; 
	    $this->query = $str;
	    // echo $str;exit;
	    return $this->execQuery($str);
	 }

	function delete()
	{
		$str = "
		DELETE FROM MASTER_JABATAN
		WHERE 
		POSITION_ID = '".$this->getField("POSITION_ID")."'"; 

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function change_status()
	{
		$str = "
	    UPDATE MASTER_JABATAN 
	    SET
	      STATUS= '".$this->getField("STATUS")."'
	    WHERE POSITION_ID = '".$this->getField("POSITION_ID")."'
	    "; 
	    $this->query = $str;
	    // echo $str;
	    return $this->execQuery($str);
	}

	function change_status_parent()
	{
		$str = "
	    UPDATE MASTER_JABATAN 
	    SET
	      STATUS= '".$this->getField("STATUS")."'
	    WHERE SUPERIOR_ID = '".$this->getField("SUPERIOR_ID")."' 
	    "; 
	    $this->query = $str;
	    // echo $str;exit;
	    return $this->execQuery($str);
	}


    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
    {
    	$str = "
 		SELECT
 		TRIM(A.POSITION_ID) POSITION_ID
 		, A.NAMA_POSISI
 		, TRIM(A.SUPERIOR_ID) SUPERIOR_ID
 		, TRIM(A.KODE_KATEGORI) KODE_KATEGORI
 		, A.KATEGORI
 		, TRIM(A.KODE_KELOMPOK_JABATAN) KODE_KELOMPOK_JABATAN 
 		, A.KELOMPOK_JABATAN
 		, TRIM(A.KODE_JENJANG_JABATAN) KODE_JENJANG_JABATAN
 		, A.JENJANG_JABATAN
 		, TRIM(A.KODE_KLASIFIKASI_UNIT) KODE_KLASIFIKASI_UNIT
 		, A.KLASIFIKASI_UNIT
 		, TRIM(A.KODE_UNIT) KODE_UNIT
 		, A.UNIT
 		, TRIM(A.KODE_DITBID) KODE_DITBID
 		, A.DITBID, TRIM(A.KODE_BAGIAN) KODE_BAGIAN
 		, A.BAGIAN
 		, A.OCCUP_STATUS
 		, A.NAMA_LENGKAP
 		, A.EMAIL
 		, A.NID
 		, A.POSISI
 		, A.CHANGE_REASON
 		, A.TIPE
 		,  CASE WHEN A.TIPE IS NULL THEN 'Eksternal' else 'Internal' END TIPE_INFO
 		,  A.KODE_DISTRIK
 		,  A.STATUS
    	, CASE WHEN A.TIPE IS NULL THEN 
    	'<a class=\"addjabdetil\" onClick=\"openurl(''app/index/master_jabatan_add?reqId=&reqIdDetil=' || TRIM(A.POSITION_ID) || '&reqSuperiorId=TOP'')\" 
    	style=\"cursor:pointer\" title=\"Tambah\"><img src=\"images/icn_add.gif\" width=\"15px\" heigth=\"15px\"></a>'
    	'<a class=\"editjabdetil\" onClick=\"openurl(''app/index/master_jabatan_add?reqId=' || TRIM(A.POSITION_ID) || ''')\" 
    	style=\"cursor:pointer\" title=\"Ubah\"><img src=\"images/icn_edit.gif\" width=\"15px\" heigth=\"15px\"></a>'
    	'<a class=\"deljabdetil\" onClick=\"delete_detail(''' || TRIM(A.POSITION_ID) || ''')\" 
    	style=\"cursor:pointer\" title=\"Hapus\"><img src=\"images/icon-hapus.png\" width=\"15px\" heigth=\"15px\"></a>'
    	'<a class=\"impjabdetil\" onClick=\"import_child(''' || TRIM(A.POSITION_ID) || ''')\" 
    	style=\"cursor:pointer\" title=\"Import\"><img src=\"images/icn-excel.png\" width=\"15px\" heigth=\"15px\"></a>'
    	WHEN A.TIPE IS NOT NULL 
    	THEN
	    	CASE WHEN A.STATUS = '1' THEN 
	    	'<a class=\"aktifjabdetil\" onClick=\"change_status_aktif(''' || TRIM(A.POSITION_ID) || ''')\" 
	    	style=\"cursor:pointer\" title=\"Aktifkan\"><i class=\"fa fa-ban\" aria-hidden=\"true\"></i></a>'
	    	'<a class=\"editjabdetil\" onClick=\"openurl(''app/index/master_jabatan_add?reqId=' || TRIM(A.POSITION_ID) || ''')\" 
	    	style=\"cursor:pointer\" title=\"Ubah\"><img src=\"images/icn_edit.gif\" width=\"15px\" heigth=\"15px\"></a>' 
	    	
	    	ELSE
	    	'<a class=\"nonaddjabdetil\" onClick=\"change_status(''' || TRIM(A.POSITION_ID) || ''')\" 
	    	style=\"cursor:pointer\" title=\"Non Aktifkan\"><i class=\"fa fa-toggle-on\" aria-hidden=\"true\"></i></a>'
	    	'<a class=\"editjabdetil\" onClick=\"openurl(''app/index/master_jabatan_add?reqId=' || TRIM(A.POSITION_ID) || ''')\" 
	    	style=\"cursor:pointer\" title=\"Ubah\"><img src=\"images/icn_edit.gif\" width=\"15px\" heigth=\"15px\"></a>' 
	    	
    	END
    	
    	END LINK_URL_INFO
    	FROM MASTER_JABATAN A
    	LEFT JOIN DISTRIK B ON B.KODE = A.KODE_DISTRIK
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

    function selectByParamsJabatan($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
    {
    	$str = "
 		SELECT
 		
    	*
    	FROM MASTER_JABATAN A
    	LEFT JOIN DISTRIK B ON B.KODE = A.KODE_DISTRIK
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

    function selectByParamsCombo($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
    {
    	$str = "
 		SELECT A.POSITION_ID,A.NAMA_POSISI,A.NID 
 		FROM MASTER_JABATAN A
 		WHERE 1=1
		
    	";

    	while(list($key,$val) = each($paramsArray))
    	{
    		$str .= " AND $key = '$val' ";
    	}

    	$str .= $statement." GROUP BY  A.POSITION_ID,A.NAMA_POSISI,A.NID  ".$sOrder;
    	$this->query = $str;

    	return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsDistrik($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder=" ORDER BY UNIT ASC")
    {
    	$str = "
    	SELECT TRIM(KODE_UNIT) KODE_UNIT,TRIM(UNIT) UNIT
    	FROM MASTER_JABATAN A
    	WHERE KODE_UNIT IS NOT NULL AND TRIM(KODE_UNIT) <> ''
    	
    	";

    	while(list($key,$val) = each($paramsArray))
    	{
    		$str .= " AND $key = '$val' ";
    	}

    	$str .= $statement."GROUP BY  KODE_UNIT,UNIT  ".$sOrder;
    	$this->query = $str;

    	return $this->selectLimit($str,$limit,$from); 
    }


  } 
?>