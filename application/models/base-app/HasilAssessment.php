<? 
include_once(APPPATH.'/models/Entity.php');

class HasilAssessment extends Entity { 

	var $query;

    function HasilAssessment()
	{
      	$this->Entity(); 
    }



	function selectByParamsRekomendasi($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY  A.KATEGORI_REKOMENDASI_ID ASC")
	{
		$str = "
			SELECT A.KATEGORI_REKOMENDASI_ID,A.NAMA KATEGORI_INFO,COUNT(B.KATEGORI_REKOMENDASI_ID) JUMLAH_REKOMENDASI
			FROM KATEGORI_REKOMENDASI A
			LEFT JOIN  OUTLINING_ASSESSMENT_REKOMENDASI B ON B.KATEGORI_REKOMENDASI_ID = A.KATEGORI_REKOMENDASI_ID
			LEFT JOIN 
			(
				SELECT A.OUTLINING_ASSESSMENT_ID, A.DISTRIK_ID,A.BLOK_UNIT_ID,A.TAHUN,A.V_STATUS,E.OUTLINING_ASSESSMENT_AREA_DETIL_ID,E.LIST_AREA_ID,A.BULAN
				FROM OUTLINING_ASSESSMENT A
				LEFT JOIN DISTRIK B ON B.DISTRIK_ID = A.DISTRIK_ID
				LEFT JOIN BLOK_UNIT C ON C.BLOK_UNIT_ID = A.BLOK_UNIT_ID
				INNER JOIN OUTLINING_ASSESSMENT_DETIL D ON D.OUTLINING_ASSESSMENT_ID = A.OUTLINING_ASSESSMENT_ID
				INNER JOIN OUTLINING_ASSESSMENT_AREA_DETIL E ON E.OUTLINING_ASSESSMENT_DETIL_ID = D.OUTLINING_ASSESSMENT_DETIL_ID
				
			) C ON C.OUTLINING_ASSESSMENT_AREA_DETIL_ID = B.OUTLINING_ASSESSMENT_AREA_DETIL_ID
			  
			WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY  A.KATEGORI_REKOMENDASI_ID,A.NAMA ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
	}

	function selectByParamsJenisRekomendasi($paramsArray=array(),$limit=-1,$from=-1, $statement='',$statementstatus='', $sOrder="ORDER BY  A.JENIS_REKOMENDASI_ID ASC")
	{

		$str = "
			SELECT A.JENIS_REKOMENDASI_ID,A.NAMA JENIS_INFO,COUNT(B.JENIS_REKOMENDASI_ID) JUMLAH_JENIS
			FROM JENIS_REKOMENDASI A
			LEFT JOIN  OUTLINING_ASSESSMENT_REKOMENDASI B ON B.JENIS_REKOMENDASI_ID = A.JENIS_REKOMENDASI_ID
			LEFT JOIN 
			(
				SELECT A.OUTLINING_ASSESSMENT_ID, A.DISTRIK_ID,A.BLOK_UNIT_ID,A.TAHUN,A.V_STATUS,E.OUTLINING_ASSESSMENT_AREA_DETIL_ID,E.LIST_AREA_ID,A.BULAN
				FROM OUTLINING_ASSESSMENT A
				LEFT JOIN DISTRIK B ON B.DISTRIK_ID = A.DISTRIK_ID
				LEFT JOIN BLOK_UNIT C ON C.BLOK_UNIT_ID = A.BLOK_UNIT_ID
				INNER JOIN OUTLINING_ASSESSMENT_DETIL D ON D.OUTLINING_ASSESSMENT_ID = A.OUTLINING_ASSESSMENT_ID
				INNER JOIN OUTLINING_ASSESSMENT_AREA_DETIL E ON E.OUTLINING_ASSESSMENT_DETIL_ID = D.OUTLINING_ASSESSMENT_DETIL_ID
				WHERE 1=1
				".$statementstatus."
				
			) C ON C.OUTLINING_ASSESSMENT_AREA_DETIL_ID = B.OUTLINING_ASSESSMENT_AREA_DETIL_ID
			WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY  A.JENIS_REKOMENDASI_ID,A.NAMA ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
	}

	function selectByParamsPrioritasRekomendasi($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder=" ORDER BY A.PRIORITAS_REKOMENDASI_ID ASC")
	{
		$str = "
			SELECT A.PRIORITAS_REKOMENDASI_ID,A.NAMA PRIORITAS_INFO,COUNT(B.PRIORITAS_REKOMENDASI_ID) PRIORITAS_REKOMENDASI
			FROM PRIORITAS_REKOMENDASI A
			LEFT JOIN  OUTLINING_ASSESSMENT_REKOMENDASI B ON B.PRIORITAS_REKOMENDASI_ID = A.PRIORITAS_REKOMENDASI_ID
			LEFT JOIN 
			(
				SELECT A.OUTLINING_ASSESSMENT_ID, A.DISTRIK_ID,A.BLOK_UNIT_ID,A.TAHUN,A.V_STATUS,E.OUTLINING_ASSESSMENT_AREA_DETIL_ID,E.LIST_AREA_ID,A.BULAN
				FROM OUTLINING_ASSESSMENT A
				LEFT JOIN DISTRIK B ON B.DISTRIK_ID = A.DISTRIK_ID
				LEFT JOIN BLOK_UNIT C ON C.BLOK_UNIT_ID = A.BLOK_UNIT_ID
				INNER JOIN OUTLINING_ASSESSMENT_DETIL D ON D.OUTLINING_ASSESSMENT_ID = A.OUTLINING_ASSESSMENT_ID
				INNER JOIN OUTLINING_ASSESSMENT_AREA_DETIL E ON E.OUTLINING_ASSESSMENT_DETIL_ID = D.OUTLINING_ASSESSMENT_DETIL_ID
				
			) C ON C.OUTLINING_ASSESSMENT_AREA_DETIL_ID = B.OUTLINING_ASSESSMENT_AREA_DETIL_ID
			WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY  A.PRIORITAS_REKOMENDASI_ID,A.NAMA ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
	}


	function selectByParamsRekomendasiKategori($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY  A.KATEGORI_REKOMENDASI_ID ASC")
	{
		$str = "
			SELECT A.KATEGORI_REKOMENDASI_ID,A.NAMA KATEGORI_INFO
			FROM KATEGORI_REKOMENDASI A
			INNER JOIN  OUTLINING_ASSESSMENT_REKOMENDASI B ON B.KATEGORI_REKOMENDASI_ID = A.KATEGORI_REKOMENDASI_ID
			LEFT JOIN 
			(
				SELECT A.OUTLINING_ASSESSMENT_ID, A.DISTRIK_ID,A.BLOK_UNIT_ID,A.TAHUN,A.V_STATUS,E.OUTLINING_ASSESSMENT_AREA_DETIL_ID,E.LIST_AREA_ID,A.BULAN
				FROM OUTLINING_ASSESSMENT A
				LEFT JOIN DISTRIK B ON B.DISTRIK_ID = A.DISTRIK_ID
				LEFT JOIN BLOK_UNIT C ON C.BLOK_UNIT_ID = A.BLOK_UNIT_ID
				INNER JOIN OUTLINING_ASSESSMENT_DETIL D ON D.OUTLINING_ASSESSMENT_ID = A.OUTLINING_ASSESSMENT_ID
				INNER JOIN OUTLINING_ASSESSMENT_AREA_DETIL E ON E.OUTLINING_ASSESSMENT_DETIL_ID = D.OUTLINING_ASSESSMENT_DETIL_ID
				
			) C ON C.OUTLINING_ASSESSMENT_AREA_DETIL_ID = B.OUTLINING_ASSESSMENT_AREA_DETIL_ID
			WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY  A.KATEGORI_REKOMENDASI_ID,A.NAMA ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
	}

	function selectByParamsRekomendasiProyeksi($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY  A.KATEGORI_REKOMENDASI_ID ASC")
	{
		$str = "
			SELECT A.KATEGORI_REKOMENDASI_ID,A.NAMA KATEGORI_INFO,TIMELINE_REKOMENDASI_ID,COUNT(TIMELINE_REKOMENDASI_ID) JUMLAH_SEM
			, SPLIT_PART(TIMELINE_REKOMENDASI_ID, '_', 1)  TAHUN
			FROM KATEGORI_REKOMENDASI A
			INNER JOIN  OUTLINING_ASSESSMENT_REKOMENDASI B ON B.KATEGORI_REKOMENDASI_ID = A.KATEGORI_REKOMENDASI_ID
			LEFT JOIN 
			(
				SELECT A.OUTLINING_ASSESSMENT_ID, A.DISTRIK_ID,A.BLOK_UNIT_ID,A.TAHUN,A.V_STATUS,E.OUTLINING_ASSESSMENT_AREA_DETIL_ID,E.LIST_AREA_ID,A.BULAN
				FROM OUTLINING_ASSESSMENT A
				LEFT JOIN DISTRIK B ON B.DISTRIK_ID = A.DISTRIK_ID
				LEFT JOIN BLOK_UNIT C ON C.BLOK_UNIT_ID = A.BLOK_UNIT_ID
				INNER JOIN OUTLINING_ASSESSMENT_DETIL D ON D.OUTLINING_ASSESSMENT_ID = A.OUTLINING_ASSESSMENT_ID
				INNER JOIN OUTLINING_ASSESSMENT_AREA_DETIL E ON E.OUTLINING_ASSESSMENT_DETIL_ID = D.OUTLINING_ASSESSMENT_DETIL_ID
				
			) C ON C.OUTLINING_ASSESSMENT_AREA_DETIL_ID = B.OUTLINING_ASSESSMENT_AREA_DETIL_ID
			WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY  A.KATEGORI_REKOMENDASI_ID,A.NAMA,TIMELINE_REKOMENDASI_ID ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
	}
	function selectByParamsRekomendasiProyeksiTotal($paramsArray=array(),$limit=-1,$from=-1, $statement='',$statementdetil='', $sOrder=" ORDER BY TIMELINE_REKOMENDASI_ID")
	{
		$str = "
		SELECT
		*, SUM(JUMLAH_SEM) TOTAL_SEM
		FROM
		(
					SELECT TIMELINE_REKOMENDASI_ID,COUNT(TIMELINE_REKOMENDASI_ID) JUMLAH_SEM
					FROM KATEGORI_REKOMENDASI A
					INNER JOIN  OUTLINING_ASSESSMENT_REKOMENDASI B ON B.KATEGORI_REKOMENDASI_ID = A.KATEGORI_REKOMENDASI_ID
					LEFT JOIN 
					(
						SELECT A.OUTLINING_ASSESSMENT_ID, A.DISTRIK_ID,A.BLOK_UNIT_ID,A.TAHUN,A.V_STATUS,E.OUTLINING_ASSESSMENT_AREA_DETIL_ID,E.LIST_AREA_ID,A.BULAN
						FROM OUTLINING_ASSESSMENT A
						LEFT JOIN DISTRIK B ON B.DISTRIK_ID = A.DISTRIK_ID
						LEFT JOIN BLOK_UNIT C ON C.BLOK_UNIT_ID = A.BLOK_UNIT_ID
						INNER JOIN OUTLINING_ASSESSMENT_DETIL D ON D.OUTLINING_ASSESSMENT_ID = A.OUTLINING_ASSESSMENT_ID
						INNER JOIN OUTLINING_ASSESSMENT_AREA_DETIL E ON E.OUTLINING_ASSESSMENT_DETIL_ID = D.OUTLINING_ASSESSMENT_DETIL_ID
					
					) C ON C.OUTLINING_ASSESSMENT_AREA_DETIL_ID = B.OUTLINING_ASSESSMENT_AREA_DETIL_ID
					WHERE 1=1
					".$statementdetil."
					GROUP BY TIMELINE_REKOMENDASI_ID
		) A
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY  TIMELINE_REKOMENDASI_ID,JUMLAH_SEM".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
	}

	function selectByParamsRekomendasiProyeksiPersentase($paramsArray=array(),$limit=-1,$from=-1, $statement='',$statementdetil='', $sOrder="")
	{
		$str = "
		SELECT *
		,round((sum(CONFIRM)/sum(JUMLAH_KLAUSUL) * 100),1) PERSEN_CONFIRM
		,round((sum(NOT_CONFIRM)/sum(JUMLAH_KLAUSUL) * 100),1) PERSEN_NOT_CONFIRM
		, CASE WHEN CONFIRM > 0  AND NOT_CONFIRM = 0 THEN 'COMPLY' ELSE  'NOT COMPLY' END STATUS_COMPLY
		
		FROM
		(
				SELECT 			
				A.KODE || GENERATEZERO(A1.KODE,2) KODE_INFO
				, A.NAMA
				, B.NAMA AREA_UNIT
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
				INNER JOIN PROGRAM_ITEM_ASSESSMENT B4 ON B4.PROGRAM_ITEM_ASSESSMENT_ID = B1.PROGRAM_ITEM_ASSESSMENT_ID
				WHERE 1=1 
					".$statementdetil."
					GROUP BY A.KODE || GENERATEZERO(A1.KODE,2),A.NAMA,B.NAMA,  A.LIST_AREA_ID,A1.ITEM_ASSESSMENT_DUPLIKAT_ID
		) A
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY KODE_INFO,A.NAMA,A.AREA_UNIT,A.JUMLAH_KLAUSUL,A.CONFIRM,A.NOT_CONFIRM".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
	}

	// function selectByParamsRekomendasiProyeksiTahun($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder=" ORDER BY  Split_part(TIMELINE_REKOMENDASI_ID, '_', 1)  ASC")
	// {
	// 	$str = "
	// 		SELECT 
	// 		 SPLIT_PART(TIMELINE_REKOMENDASI_ID, '_', 1)  TAHUN
	// 		FROM KATEGORI_REKOMENDASI A
	// 		INNER JOIN  OUTLINING_ASSESSMENT_REKOMENDASI B ON B.KATEGORI_REKOMENDASI_ID = A.KATEGORI_REKOMENDASI_ID
	// 		WHERE 1=1
	// 	"; 
		
	// 	while(list($key,$val) = each($paramsArray))
	// 	{
	// 		$str .= " AND $key = '$val' ";
	// 	}
		
	// 	$str .= $statement." GROUP BY  split_part(TIMELINE_REKOMENDASI_ID, '_', 1) ".$sOrder;
	// 	$this->query = $str;
				
	// 	return $this->selectLimit($str,$limit,$from); 
	// }

	// function selectByParamsRekomendasiGroupTahunProyeksi($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY  B.TIMELINE_REKOMENDASI_ID ASC")
	// {
	// 	$str = "
	// 		SELECT TIMELINE_REKOMENDASI_ID, SPLIT_PART(TIMELINE_REKOMENDASI_ID, '_', 1)  TAHUN
	// 		FROM KATEGORI_REKOMENDASI A
	// 		INNER JOIN  OUTLINING_ASSESSMENT_REKOMENDASI B ON B.KATEGORI_REKOMENDASI_ID = A.KATEGORI_REKOMENDASI_ID
	// 		WHERE 1=1
	// 	"; 
		
	// 	while(list($key,$val) = each($paramsArray))
	// 	{
	// 		$str .= " AND $key = '$val' ";
	// 	}
		
	// 	$str .= $statement." GROUP BY  TIMELINE_REKOMENDASI_ID ".$sOrder;
	// 	$this->query = $str;
				
	// 	return $this->selectLimit($str,$limit,$from); 
	// }


	// function selectByParamsRekomendasiSemester($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY  B.TIMELINE_REKOMENDASI_ID ASC")
	// {
	// 	$str = "
	// 		SELECT  REPLACE(TIMELINE_REKOMENDASI_ID::text, '_', ' Semester ') as SEMESTER
	// 		FROM KATEGORI_REKOMENDASI A
	// 		INNER JOIN  OUTLINING_ASSESSMENT_REKOMENDASI B ON B.KATEGORI_REKOMENDASI_ID = A.KATEGORI_REKOMENDASI_ID
	// 		WHERE 1=1
	// 	"; 
		
	// 	while(list($key,$val) = each($paramsArray))
	// 	{
	// 		$str .= " AND $key = '$val' ";
	// 	}
		
	// 	$str .= $statement." GROUP BY  REPLACE(TIMELINE_REKOMENDASI_ID::text, '_', ' Semester '),B.TIMELINE_REKOMENDASI_ID ".$sOrder;
	// 	$this->query = $str;
				
	// 	return $this->selectLimit($str,$limit,$from); 
	// }

	

} 
?>