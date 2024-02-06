<? 
include_once(APPPATH.'/models/Entity.php');

class Kesesuaian extends Entity { 

	var $query;

    function Kesesuaian()
	{
      	$this->Entity(); 
    }
 
    function insert()
    {
    	$this->setField("KESESUAIAN_ID", $this->getNextId("KESESUAIAN_ID","KESESUAIAN"));

    	$str = "
    	INSERT INTO KESESUAIAN
    	(
    		KESESUAIAN_ID,OUTLINING_ASSESSMENT_ID,DISTRIK_ID,BLOK_UNIT_ID,UNIT_MESIN_ID,BULAN,TAHUN,STATUS,LAST_CREATE_USER,LAST_CREATE_DATE
    	)
    	VALUES 
    	(
    		".$this->getField("KESESUAIAN_ID")."
	    	, ".$this->getField("OUTLINING_ASSESSMENT_ID")."
	    	, ".$this->getField("STATUS")."
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    )"; 

	    $this->id= $this->getField("KESESUAIAN_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function insertdetil()
    {
    	$this->setField("KESESUAIAN_DETIL_ID", $this->getNextId("KESESUAIAN_DETIL_ID","KESESUAIAN_DETIL"));

    	$str = "
    	INSERT INTO KESESUAIAN_DETIL
    	(
    		KESESUAIAN_DETIL_ID,KESESUAIAN_ID,LIST_AREA_ID,KATEGORI_ITEM_ASSESSMENT_ID,ITEM_ASSESSMENT_DUPLIKAT_ID,ITEM_ASSESSMENT_FORMULIR_ID,STANDAR_REFERENSI_ID,STATUS_CONFIRM,KETERANGAN,LAST_CREATE_USER,LAST_CREATE_DATE,AREA_UNIT_DETIL_ID,PROGRAM_ITEM_ASSESSMENT_ID,STATUS_KONFIRMASI,BOBOT
    	)
    	VALUES 
    	(
    		".$this->getField("KESESUAIAN_DETIL_ID")."
    		, ".$this->getField("KESESUAIAN_ID")."
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

	    $this->id= $this->getField("KESESUAIAN_DETIL_ID");
	    $this->query= $str;
		// echo $str;exit;
	    return $this->execQuery($str);
	}


	
	function update()
	{
		$str = "
		UPDATE KESESUAIAN
		SET
		DISTRIK_ID = ".$this->getField("DISTRIK_ID")."
		, BLOK_UNIT_ID = ".$this->getField("BLOK_UNIT_ID")."
		, UNIT_MESIN_ID = ".$this->getField("UNIT_MESIN_ID")."
		, BULAN = '".$this->getField("BULAN")."'
		, TAHUN = ".$this->getField("TAHUN")."
		, STATUS = ".$this->getField("STATUS")."
		, LAST_UPDATE_USER = '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE = ".$this->getField("LAST_UPDATE_DATE")."
		WHERE KESESUAIAN_ID = '".$this->getField("KESESUAIAN_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}

	function updatedetil()
	{
		$str = "
		UPDATE KESESUAIAN_DETIL
		SET
			KESESUAIAN_ID= ".$this->getField("KESESUAIAN_ID")."
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

		WHERE KESESUAIAN_DETIL_ID = '".$this->getField("KESESUAIAN_DETIL_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}

	function update_status()
	{
		$str = "
		UPDATE KESESUAIAN
		SET
		STATUS = ".$this->getField("STATUS")."
		WHERE KESESUAIAN_ID = '".$this->getField("KESESUAIAN_ID")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM KESESUAIAN
		WHERE 
		KESESUAIAN_ID = ".$this->getField("KESESUAIAN_ID").";
		";
		$str .= "
		DELETE FROM KESESUAIAN_DETIL
		WHERE 
		KESESUAIAN_ID = ".$this->getField("KESESUAIAN_ID").";
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deletedetil()
	{
		$str = "
		DELETE FROM KESESUAIAN_DETIL
		WHERE 
		KESESUAIAN_DETIL_ID = ".$this->getField("KESESUAIAN_DETIL_ID")."
		AND KESESUAIAN_ID = ".$this->getField("KESESUAIAN_ID")."
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY KESESUAIAN_ID ASC")
	{
		$str = "
			SELECT 
				A.*, B.BULAN, B.TAHUN,C.NAMA DISTRIK_INFO,D.NAMA BLOK_INFO, E.NAMA UNIT_MESIN_INFO
				, CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
			FROM KESESUAIAN A
			INNER JOIN OUTLINING_ASSESSMENT B ON B.OUTLINING_ASSESSMENT_ID = A.OUTLINING_ASSESSMENT_ID
			INNER JOIN DISTRIK C ON C.DISTRIK_ID = B.DISTRIK_ID
			INNER JOIN BLOK_UNIT D ON D.BLOK_UNIT_ID = B.BLOK_UNIT_ID
			INNER JOIN UNIT_MESIN E ON E.UNIT_MESIN_ID = B.UNIT_MESIN_ID
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

	function selectByParamsNew($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.KODE_INFO,A.NAMA", $statementnew='', $statementstatus='')
	{
		$str = "
		SELECT *
		,round((sum(CONFIRM)/sum(JUMLAH_KLAUSUL) * 100),1) PERSEN_CONFIRM
		,round((sum(NOT_CONFIRM)/sum(JUMLAH_KLAUSUL) * 100),1) PERSEN_NOT_CONFIRM
		, CASE WHEN CONFIRM > 0  AND NOT_CONFIRM = 0 THEN 'COMPLY' ELSE  'NOT COMPLY' END STATUS_COMPLY
		, JUMLAH_KLAUSUL-CONFIRM-NOT_CONFIRM BELUM_DIISI
		FROM
		(
				SELECT 			
					A.KODE || GENERATEZERO(A1.KODE,2) KODE_INFO
					, A.NAMA
					, B.AREA_UNIT_DETIL_ID
					, B.NAMA AREA_UNIT
					, COUNT (E.ITEM_ASSESSMENT_DUPLIKAT_ID) JUMLAH_KLAUSUL
					, COUNT(CASE WHEN STATUS_CONFIRM = 1 THEN 1 END ) AS CONFIRM
					, COUNT(CASE WHEN STATUS_CONFIRM = 0 THEN 0 END ) AS NOT_CONFIRM
					, F.DISTRIK_ID
					, D.BLOK_UNIT_ID
					, COALESCE(SUM(B3.BOBOT),0) TOTAL_BOBOT
					, A.LIST_AREA_ID
					, A1.ITEM_ASSESSMENT_DUPLIKAT_ID
					
				FROM LIST_AREA A 
				INNER JOIN ITEM_ASSESSMENT_DUPLIKAT A1 ON A.LIST_AREA_ID = A1.LIST_AREA_ID
				INNER JOIN AREA_UNIT_DETIL B ON B.ITEM_ASSESSMENT_DUPLIKAT_ID = A1.ITEM_ASSESSMENT_DUPLIKAT_ID AND B.LIST_AREA_ID = A1.LIST_AREA_ID
				INNER JOIN AREA_UNIT C ON C.AREA_UNIT_ID = B.AREA_UNIT_ID
				INNER JOIN OUTLINING_ASSESSMENT_DETIL D ON  D.AREA_UNIT_DETIL_ID = B.AREA_UNIT_DETIL_ID AND D.STATUS_AKTIF IS NULL
				INNER JOIN OUTLINING_ASSESSMENT_AREA_DETIL E ON  E.OUTLINING_ASSESSMENT_DETIL_ID = D.OUTLINING_ASSESSMENT_DETIL_ID AND A1.ITEM_ASSESSMENT_DUPLIKAT_ID = E.ITEM_ASSESSMENT_DUPLIKAT_ID
				INNER JOIN OUTLINING_ASSESSMENT F ON  F.OUTLINING_ASSESSMENT_ID = D.OUTLINING_ASSESSMENT_ID 
				INNER JOIN ITEM_ASSESSMENT_FORMULIR B1 ON B1.ITEM_ASSESSMENT_FORMULIR_ID = E.ITEM_ASSESSMENT_FORMULIR_ID --AND B1.STATUS_KONFIRMASI = 1
				INNER JOIN ITEM_ASSESSMENT B2 ON B2.ITEM_ASSESSMENT_ID = B1.ITEM_ASSESSMENT_ID
				INNER JOIN KATEGORI_ITEM_ASSESSMENT B3 ON B3.KATEGORI_ITEM_ASSESSMENT_ID = B1.KATEGORI_ITEM_ASSESSMENT_ID AND B3.BOBOT IS NOT NULL
				INNER JOIN PROGRAM_ITEM_ASSESSMENT B4 ON B4.PROGRAM_ITEM_ASSESSMENT_ID = B1.PROGRAM_ITEM_ASSESSMENT_ID ".$statementnew."
				WHERE 1=1 
				--AND F.OUTLINING_ASSESSMENT_ID =1
				AND F.V_STATUS=20
				".$statementstatus."

				GROUP BY A.KODE || GENERATEZERO(A1.KODE,2),A.NAMA,B.NAMA, F.DISTRIK_ID, D.BLOK_UNIT_ID, A.LIST_AREA_ID,A1.ITEM_ASSESSMENT_DUPLIKAT_ID, B.AREA_UNIT_DETIL_ID
		) A

		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY KODE_INFO,A.NAMA,A.AREA_UNIT,A.JUMLAH_KLAUSUL,A.CONFIRM,A.NOT_CONFIRM, A.DISTRIK_ID, A.BLOK_UNIT_ID,A.TOTAL_BOBOT, A.LIST_AREA_ID,A.ITEM_ASSESSMENT_DUPLIKAT_ID, A.AREA_UNIT_DETIL_ID ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
	}

	function selectByParamsJumlahKlausul($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.KODE_INFO,A.NAMA", $statementnew='')
	{
		$str = "
		SELECT *
		, JUMLAH_KLAUSUL-CONFIRM-NOT_CONFIRM BELUM_DIISI
		FROM
		(
				SELECT 			
					A.KODE || GENERATEZERO(A1.KODE,2) KODE_INFO
					, A.NAMA
					, COUNT (E.ITEM_ASSESSMENT_DUPLIKAT_ID) JUMLAH_KLAUSUL
					, COUNT(CASE WHEN STATUS_CONFIRM = 1 THEN 1 END ) AS CONFIRM
					, COUNT(CASE WHEN STATUS_CONFIRM = 0 THEN 0 END ) AS NOT_CONFIRM
					
				FROM LIST_AREA A 
				INNER JOIN ITEM_ASSESSMENT_DUPLIKAT A1 ON A.LIST_AREA_ID = A1.LIST_AREA_ID
				INNER JOIN AREA_UNIT_DETIL B ON B.ITEM_ASSESSMENT_DUPLIKAT_ID = A1.ITEM_ASSESSMENT_DUPLIKAT_ID AND B.LIST_AREA_ID = A1.LIST_AREA_ID
				INNER JOIN AREA_UNIT C ON C.AREA_UNIT_ID = B.AREA_UNIT_ID
				INNER JOIN OUTLINING_ASSESSMENT_DETIL D ON  D.AREA_UNIT_DETIL_ID = B.AREA_UNIT_DETIL_ID AND D.STATUS_AKTIF IS NULL
				INNER JOIN OUTLINING_ASSESSMENT_AREA_DETIL E ON  E.OUTLINING_ASSESSMENT_DETIL_ID = D.OUTLINING_ASSESSMENT_DETIL_ID AND A1.ITEM_ASSESSMENT_DUPLIKAT_ID = E.ITEM_ASSESSMENT_DUPLIKAT_ID
				INNER JOIN OUTLINING_ASSESSMENT F ON  F.OUTLINING_ASSESSMENT_ID = D.OUTLINING_ASSESSMENT_ID 
				INNER JOIN ITEM_ASSESSMENT_FORMULIR B1 ON B1.ITEM_ASSESSMENT_FORMULIR_ID = E.ITEM_ASSESSMENT_FORMULIR_ID AND B1.STATUS_KONFIRMASI = 1
				INNER JOIN ITEM_ASSESSMENT B2 ON B2.ITEM_ASSESSMENT_ID = B1.ITEM_ASSESSMENT_ID
				INNER JOIN KATEGORI_ITEM_ASSESSMENT B3 ON B3.KATEGORI_ITEM_ASSESSMENT_ID = B1.KATEGORI_ITEM_ASSESSMENT_ID AND B3.BOBOT IS NOT NULL
				INNER JOIN PROGRAM_ITEM_ASSESSMENT B4 ON B4.PROGRAM_ITEM_ASSESSMENT_ID = B1.PROGRAM_ITEM_ASSESSMENT_ID ".$statementnew."
				WHERE 1=1 
				--AND F.OUTLINING_ASSESSMENT_ID =1

				GROUP BY A.KODE || GENERATEZERO(A1.KODE,2),A.NAMA
		) A

		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY KODE_INFO,A.NAMA,A.JUMLAH_KLAUSUL,A.CONFIRM,A.NOT_CONFIRM  ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
	}

	function selectByParamsRating($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.KODE_INFO,A.NAMA", $statementnew='')
	{
		$str = "
		SELECT 			
					 sum(b3.bobot) TOTAL_BOBOT
					
				FROM LIST_AREA A 
				INNER JOIN ITEM_ASSESSMENT_DUPLIKAT A1 ON A.LIST_AREA_ID = A1.LIST_AREA_ID
				INNER JOIN AREA_UNIT_DETIL B ON B.ITEM_ASSESSMENT_DUPLIKAT_ID = A1.ITEM_ASSESSMENT_DUPLIKAT_ID AND B.LIST_AREA_ID = A1.LIST_AREA_ID
				INNER JOIN AREA_UNIT C ON C.AREA_UNIT_ID = B.AREA_UNIT_ID
				INNER JOIN OUTLINING_ASSESSMENT_DETIL D ON  D.AREA_UNIT_DETIL_ID = B.AREA_UNIT_DETIL_ID AND D.STATUS_AKTIF IS NULL
				INNER JOIN OUTLINING_ASSESSMENT_AREA_DETIL E ON  E.OUTLINING_ASSESSMENT_DETIL_ID = D.OUTLINING_ASSESSMENT_DETIL_ID AND A1.ITEM_ASSESSMENT_DUPLIKAT_ID = E.ITEM_ASSESSMENT_DUPLIKAT_ID
				INNER JOIN OUTLINING_ASSESSMENT F ON  F.OUTLINING_ASSESSMENT_ID = D.OUTLINING_ASSESSMENT_ID 
				INNER JOIN ITEM_ASSESSMENT_FORMULIR B1 ON B1.ITEM_ASSESSMENT_FORMULIR_ID = E.ITEM_ASSESSMENT_FORMULIR_ID AND B1.STATUS_KONFIRMASI IS NOT NULL
				INNER JOIN ITEM_ASSESSMENT B2 ON B2.ITEM_ASSESSMENT_ID = B1.ITEM_ASSESSMENT_ID
				INNER JOIN KATEGORI_ITEM_ASSESSMENT B3 ON B3.KATEGORI_ITEM_ASSESSMENT_ID = B1.KATEGORI_ITEM_ASSESSMENT_ID AND B3.BOBOT IS NOT NULL
				INNER JOIN PROGRAM_ITEM_ASSESSMENT B4 ON B4.PROGRAM_ITEM_ASSESSMENT_ID = B1.PROGRAM_ITEM_ASSESSMENT_ID  ".$statementnew."
				WHERE 1=1 
				--AND F.OUTLINING_ASSESSMENT_ID =1

				
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.KODE || GENERATEZERO(A1.KODE,2),A.NAMA,B.NAMA, F.DISTRIK_ID, D.BLOK_UNIT_ID, A.LIST_AREA_ID,A1.ITEM_ASSESSMENT_DUPLIKAT_ID ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
	}

	function selectByParamsItemFormulir($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY ITEM_ASSESSMENT_FORMULIR_ID ASC")
	{
		$str = "
			SELECT  DISTINCT
				A.*,C.BOBOT KATEGORI_BOBOT,C.NAMA KATEGORI_INFO,D.NAMA PROGRAM_INFO
				, CASE WHEN A.STATUS_KONFIRMASI =1 THEN 'Ya'
				else 'tidak'
				end STATUS_KONFIMASI_INFO,
				a.KATEGORI_ITEM_ASSESSMENT_ID
			FROM ITEM_ASSESSMENT_FORMULIR A 
			INNER JOIN ITEM_ASSESSMENT B ON B.ITEM_ASSESSMENT_ID = A.ITEM_ASSESSMENT_ID
			INNER JOIN KATEGORI_ITEM_ASSESSMENT C ON C.KATEGORI_ITEM_ASSESSMENT_ID = A.KATEGORI_ITEM_ASSESSMENT_ID
			INNER JOIN PROGRAM_ITEM_ASSESSMENT D ON D.PROGRAM_ITEM_ASSESSMENT_ID = A.PROGRAM_ITEM_ASSESSMENT_ID ".$statementnew."
			INNER JOIN OUTLINING_ASSESSMENT_AREA_DETIL E ON  E.ITEM_ASSESSMENT_FORMULIR_ID = A.ITEM_ASSESSMENT_FORMULIR_ID 
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