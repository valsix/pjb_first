<?
/* *******************************************************************************************************
MODUL NAME 			: 
FILE NAME 			: string.func.php
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: Functions to handle string operation
***************************************************************************************************** */



/* fungsi untuk mengatur tampilan mata uang
 * $value = string
 * $digit = pengelompokan setiap berapa digit, default : 3
 * $symbol = menampilkan simbol mata uang (Rupiah), default : false
 * $minusToBracket = beri tanda kurung pada nilai negatif, default : true
 */

function makedirs($dirpath, $mode=0777)
{
    return is_dir($dirpath) || mkdir($dirpath, $mode, true);
}

 
function setInfoChecked($val1, $val2, $val="checked")
{
	if($val1 == $val2)
		return $val;
	else
		return "";
}


function in_array_column($text, $column, $array)
{
    if (!empty($array) && is_array($array))
    {
        for ($i=0; $i < count($array); $i++)
        {
            if ($array[$i][$column]==$text || strcmp($array[$i][$column],$text)==0) 
				$arr[] = $i;
        }
		return $arr;
    }
    return "";
}


function currencyToPage($value, $symbol=true, $minusToBracket=true, $minusLess=false, $digit=3)
{

    if($value == "")
		$value = 0;
	$rupiah = number_format($value,0, ",",".");
    $rupiah = $rupiah . ",-";
    return $rupiah;
}

function nomorDigit($value, $symbol=true, $minusToBracket=true, $minusLess=false, $digit=3)
{
	$arrValue = explode(".", $value);
	$value = $arrValue[0];
	if(count($arrValue) == 1)
		$belakang_koma = "";
	else
		$belakang_koma = $arrValue[1];
	if($value < 0)
	{
		$neg = "-";
		$value = str_replace("-", "", $value);
	}
	else
		$neg = false;
		
	$cntValue = strlen($value);
	//$cntValue = strlen($value);
	
	if($cntValue <= $digit)
		$resValue =  $value;
	
	$loopValue = floor($cntValue / $digit);
	
	for($i=1; $i<=$loopValue; $i++)
	{
		$sub = 0 - $i; //ubah jadi negatif
		$tempValue = $endValue;
		$endValue = substr($value, $sub*$digit, $digit);
		$endValue = $endValue;
		
		if($i !== 1)
			$endValue .= ".";
		
		$endValue .= $tempValue;
	}
	
	$beginValue = substr($value, 0, $cntValue - ($loopValue * $digit));
	
	if($cntValue % $digit == 0)
		$resValue = $beginValue.$endValue;
	else if($cntValue > $digit)
		$resValue = $beginValue.".".$endValue;
	
	//additional
	if($belakang_koma == "")
		$resValue = $symbol." ".$resValue;
	else
		$resValue = $symbol." ".$resValue.",".$belakang_koma;
	
	
	if($minusToBracket && $neg)
	{
		$resValue = "(".$resValue.")";
		$neg = "";
	}
	
	if($minusLess == true)
	{
		$neg = "";
	}
	
	$resValue = $neg.$resValue;
	
	//$resValue = "<span style='white-space:nowrap'>".$resValue."</span>";

	return $resValue;
}


function numberToIna($value, $symbol=true, $minusToBracket=true, $minusLess=false, $digit=3)
{
	$arr_value = explode(".", $value);
	
	if(count($arr_value) > 1)
		$value = $arr_value[0];
	
	if($value < 0)
	{
		$neg = "-";
		$value = str_replace("-", "", $value);
	}
	else
		$neg = false;
		
	$cntValue = strlen($value);
	//$cntValue = strlen($value);
	
	if($cntValue <= $digit)
		$resValue =  $value;
	
	$loopValue = floor($cntValue / $digit);
	
	for($i=1; $i<=$loopValue; $i++)
	{
		$sub = 0 - $i; //ubah jadi negatif
		$tempValue = $endValue;
		$endValue = substr($value, $sub*$digit, $digit);
		$endValue = $endValue;
		
		if($i !== 1)
			$endValue .= ".";
		
		$endValue .= $tempValue;
	}
	
	$beginValue = substr($value, 0, $cntValue - ($loopValue * $digit));
	
	if($cntValue % $digit == 0)
		$resValue = $beginValue.$endValue;
	else if($cntValue > $digit)
		$resValue = $beginValue.".".$endValue;
	
	//additional
	if($symbol == true && $resValue !== "")
	{
		$resValue = $resValue;
	}
	
	if($minusToBracket && $neg)
	{
		$resValue = "(".$resValue.")";
		$neg = "";
	}
	
	if($minusLess == true)
	{
		$neg = "";
	}

	if(count($arr_value) == 1)
		$resValue = $neg.$resValue;
	else
		$resValue = $neg.$resValue.",".$arr_value[1];
	
	if(substr($resValue, 0, 1) == ',')
		$resValue = '0'.$resValue;	//$resValue = "<span style='white-space:nowrap'>".$resValue."</span>";

	return $resValue;
}

function getNameValueYaTidak($number) {
	$number = (int)$number;
	$arrValue = array("0"=>"Tidak", "1"=>"Ya");
	return $arrValue[$number];
}

function getNameValueKategori($number) {
	$number = (int)$number;
	$arrValue = array("1"=>"Sangat Baik", "2"=>"Baik", "3"=>"Cukup", "4"=>"Kurang");
	return $arrValue[$number];
}	

function getNameValue($number) {
	$number = (int)$number;
	$arrValue = array("0"=>"Tidak", "1"=>"Ya");
	return $arrValue[$number];
}	

function getNameValueAktif($number) {
	$number = (int)$number;
	$arrValue = array("0"=>"Tidak Aktif", "1"=>"Aktif");
	return $arrValue[$number];
}

function getNameValidasi($number) {
	$number = (int)$number;
	$arrValue = array("0"=>"Menunggu Konfirmasi","1"=>"Disetujui", "2"=>"Ditolak");
	return $arrValue[$number];
}	

function getNameInputOutput($char) {
	$arrValue = array("I"=>"Datang", "O"=>"Pulang");
	return $arrValue[$char];
}		
	
function dotToComma($varId)
{
	$newId = str_replace(".", ",", $varId);	
	return $newId;
}

function CommaToQuery($varId)
{
	$newId = str_replace(",", "','", $varId);	
	return $newId;
}


function CommaToDot($varId)
{
	$newId = str_replace(",", ".", $varId);	
	return $newId;
}

function dotToNo($varId)
{
	$newId = str_replace(".", "", $varId);	
	$newId = str_replace(",", ".", $newId);	
	return $newId;
}
function CommaToNo($varId)
{
	$newId = str_replace(",", "", $varId);	
	return $newId;
}

function CrashToNo($varId)
{
	$newId = str_replace("#", "", $varId);	
	return $newId;
}

function StarToNo($varId)
{
	$newId = str_replace("* ", "", $varId);	
	return $newId;
}

function NullDotToNo($varId)
{
	$newId = str_replace(".00", "", $varId);
	return $newId;
}

function ExcelToNo($varId)
{
	$newId = NullDotToNo($varId);
	$newId = StarToNo($newId);
	return $newId;
}

function ValToNo($varId)
{
	$newId = NullDotToNo($varId);
	$newId = CommaToNo($newId);
	$newId = StarToNo($newId);
	return $newId;
}

function ValToNull($varId)
{
	if($varId == '')
		return 0;
	else
		return $varId;
}

function ValToNullMenit($varId)
{
	if($varId == '')
		return 00;
	else
		return $varId;
}

function ValToNullDB($varId)
{
	if($varId == '')
		return 'NULL';
	elseif($varId == 'null')
		return 'NULL';
	else
		return "'".$varId."'";
}

function setQuote($var, $status='')
{	
	if($status == 1)
		$tmp= str_replace("\'", "''", $var);
	else
		$tmp= str_replace("'", "''", $var);
	return $tmp;
}

// fungsi untuk generate nol untuk melengkapi digit

function generateZero($varId, $digitGroup, $digitCompletor = "0")
{
	$newId = "";
	
	$lengthZero = $digitGroup - strlen($varId);
	
	for($i = 0; $i < $lengthZero; $i++)
	{
		$newId .= $digitCompletor;
	}
	
	$newId = $newId.$varId;
	
	return $newId;
}

// truncate text into desired word counts.
// to support dropDirtyHtml function, include default.func.php
function truncate($text, $limit, $dropDirtyHtml=true)
{
	$tmp_truncate = array();
	$text = str_replace("&nbsp;", " ", $text);
	$tmp = explode(" ", $text);
	
	for($i = 0; $i <= $limit; $i++)		//truncate how many words?
	{
		$tmp_truncate[$i] = $tmp[$i];
	}
	
	$truncated = implode(" ", $tmp_truncate);
	
	if ($dropDirtyHtml == true and function_exists('dropAllHtml'))
		return ($truncated);
	else
		return $truncated;
}

function arrayMultiCount($array, $field_name, $search)
{
	$summary = 0;
	for($i = 0; $i < count($array); $i++)
	{
		if($array[$i][$field_name] == $search)
			$summary += 1;
	}
	return $summary;
}

function getValueArray($var)
{
	//$tmp = "";
	for($i=0;$i<count($var);$i++)
	{			
		if($i == 0)
			$tmp .= $var[$i];
		else
			$tmp .= ",".$var[$i];
	}
	
	return $tmp;
}

function getValueArrayMonth($var)
{
	//$tmp = "";
	for($i=0;$i<count($var);$i++)
	{			
		if($i == 0)
			$tmp .= "'".$var[$i]."'";
		else
			$tmp .= ", '".$var[$i]."'";
	}
	
	return $tmp;
}

function getColoms($var)
{
	$tmp = "";
	if($var == 1)	$tmp = 'A';
	elseif($var == 2)	$tmp = 'B';
	elseif($var == 3)	$tmp = 'C';
	elseif($var == 4)	$tmp = 'D';
	elseif($var == 5)	$tmp = 'E';
	elseif($var == 6)	$tmp = 'F';
	elseif($var == 7)	$tmp = 'G';
	elseif($var == 8)	$tmp = 'H';
	elseif($var == 9)	$tmp = 'I';
	elseif($var == 10)	$tmp = 'J';
	elseif($var == 11)	$tmp = 'K';
	elseif($var == 12)	$tmp = 'L';
	elseif($var == 13)	$tmp = 'M';
	elseif($var == 14)	$tmp = 'N';
	elseif($var == 15)	$tmp = 'O';
	elseif($var == 16)	$tmp = 'P';
	elseif($var == 17)	$tmp = 'Q';
	elseif($var == 18)	$tmp = 'R';
	elseif($var == 19)	$tmp = 'S';
	elseif($var == 20)	$tmp = 'T';
	elseif($var == 21)	$tmp = 'U';
	elseif($var == 22)	$tmp = 'V';
	elseif($var == 23)	$tmp = 'W';
	elseif($var == 24)	$tmp = 'X';
	elseif($var == 25)	$tmp = 'Y';
	elseif($var == 26)	$tmp = 'Z';
	elseif($var == 27)	$tmp = 'AA';
	elseif($var == 28)	$tmp = 'AB';
	elseif($var == 29)	$tmp = 'AC';
	elseif($var == 30)	$tmp = 'AD';
	elseif($var == 31)	$tmp = 'AE';
	elseif($var == 32)	$tmp = 'AF';
	elseif($var == 33)	$tmp = 'AG';
	elseif($var == 34)	$tmp = 'AH';
	elseif($var == 35)	$tmp = 'AI';
	elseif($var == 36)	$tmp = 'AJ';
	elseif($var == 37)	$tmp = 'AK';
	elseif($var == 38)	$tmp = 'AL';
	elseif($var == 39)	$tmp = 'AM';
	elseif($var == 40)	$tmp = 'AN';
	elseif($var == 41)	$tmp = 'AO';
	elseif($var == 42)	$tmp = 'AP';
	elseif($var == 43)	$tmp = 'AQ';
	elseif($var == 44)	$tmp = 'AR';
	elseif($var == 45)	$tmp = 'AS';
	elseif($var == 46)	$tmp = 'AT';
	elseif($var == 47)	$tmp = 'AU';
	elseif($var == 48)	$tmp = 'AV';
	elseif($var == 49)	$tmp = 'AW';
	elseif($var == 50)	$tmp = 'AX';
	elseif($var == 51)	$tmp = 'AY';
	
	return $tmp;
}

function setNULL($var)
{	
	if($var == '')
		$tmp = 'NULL';
	else
		$tmp = $var;
	
	return $tmp;
}

function setNULLModif($var)
{	
	if($var == '')
		$tmp = 'NULL';
	else
		$tmp = "'".$var."'";
	
	return $tmp;
}

function setVal_0($var)
{	
	if($var == '')
		$tmp = '0';
	else
		$tmp = $var;
	
	return $tmp;
}

function get_null_10($varId)
{
	if($varId == '') return '';
	if($varId < 10)	$temp= '0'.$varId;
	else			$temp= $varId;
			
	return $temp;
}

function _ip( )
{
    return ( preg_match( "/^([d]{1,3}).([d]{1,3}).([d]{1,3}).([d]{1,3})$/", $_SERVER['HTTP_X_FORWARDED_FOR'] ) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'] );
}

function getFotoProfile($id)
{
	$filename = "uploads/foto/profile-".$id.".jpg";
	if (file_exists($filename)) {
	} else {
		$filename = "images/foto-profile.png";
	}	
	return $filename;
}

/*function getFotoProfile($id)
{
	$filename = "uploads/foto/profile-".$id.".jpg";
	if (file_exists($filename)) {
	} else {
		$filename = "images/foto-profile.jpg";
	}	
	return $filename;
}*/
function toNumber($varId)
{	
	return (float)$varId;
}

function searchWordDelimeter($varSource, $varSearch, $varDelimeter=",")
{

	$arrSource = explode($varDelimeter, $varSource);
	
	for($i=0; $i<count($arrSource);$i++)
	{
		if(trim($arrSource[$i]) == $varSearch)
			return true;
	}
	
	return false;
}

function getZodiac($day,$month){
	if(($month==1 && $day>20)||($month==2 && $day<20)){
	$mysign = "Aquarius";
	}
	if(($month==2 && $day>18 )||($month==3 && $day<21)){
	$mysign = "Pisces";
	}
	if(($month==3 && $day>20)||($month==4 && $day<21)){
	$mysign = "Aries";
	}
	if(($month==4 && $day>20)||($month==5 && $day<22)){
	$mysign = "Taurus";
	}
	if(($month==5 && $day>21)||($month==6 && $day<22)){
	$mysign = "Gemini";
	}
	if(($month==6 && $day>21)||($month==7 && $day<24)){
	$mysign = "Cancer";
	}
	if(($month==7 && $day>23)||($month==8 && $day<24)){
	$mysign = "Leo";
	}
	if(($month==8 && $day>23)||($month==9 && $day<24)){
	$mysign = "Virgo";
	}
	if(($month==9 && $day>23)||($month==10 && $day<24)){
	$mysign = "Libra";
	}
	if(($month==10 && $day>23)||($month==11 && $day<23)){
	$mysign = "Scorpio";
	}
	if(($month==11 && $day>22)||($month==12 && $day<23)){
	$mysign = "Sagitarius";
	}
	if(($month==12 && $day>22)||($month==1 && $day<21)){
	$mysign = "Capricorn";
	}
	return $mysign;
}

function getValueANDOperator($var)
{
	$tmp = ' AND ';
	
	return $tmp;
}

function getValueKoma($var)
{
	if($var == '')
		$tmp = '';
	else
		$tmp = ',';	
	
	return $tmp;
}

function import_format($val)
{
	if($val == ":02")
	{
		$temp= str_replace(":02","24:00",$val);
	}
	else
	{	
		$temp="";
		if($val == "[hh]:mm" || $val == "[h]:mm"){}
		else
			$temp= $val;
	}
	return $temp;
	//return $val;
}

function kekata($x) 
{
	$x = abs($x);
	$angka = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	$temp = "";
	if ($x <12) 
	{
		$temp = " ". $angka[$x];
	} 
	else if ($x <20) 
	{
		$temp = kekata($x - 10). " belas";
	} 
	else if ($x <100) 
	{
		$temp = kekata($x/10)." puluh". kekata($x % 10);
	} 
	else if ($x <200) 
	{
		$temp = " seratus" . kekata($x - 100);
	} 
	else if ($x <1000) 
	{
		$temp = kekata($x/100) . " ratus" . kekata($x % 100);
	} 
	else if ($x <2000) 
	{
		$temp = " seribu" . kekata($x - 1000);
	} 
	else if ($x <1000000) 
	{
		$temp = kekata($x/1000) . " ribu" . kekata($x % 1000);
	} 
	else if ($x <1000000000) 
	{
		$temp = kekata($x/1000000) . " juta" . kekata($x % 1000000);
	} 
	else if ($x <1000000000000) 
	{
		$temp = kekata($x/1000000000) . " milyar" . kekata(fmod($x,1000000000));
	} 
	else if ($x <1000000000000000) 
	{
		$temp = kekata($x/1000000000000) . " trilyun" . kekata(fmod($x,1000000000000));
	}      
	
	return $temp;
}

function terbilang($x, $style=4) 
{
	if($x < 0) 
	{
		$hasil = "minus ". trim(kekata($x));
	} 
	else 
	{
		$hasil = trim(kekata($x));
	}

	echo $hasil;exit;

	switch ($style) 
	{
		case 1:
			$hasil = strtoupper($hasil);
			break;
		case 2:
			$hasil = strtolower($hasil);
			break;
		case 3:
			$hasil = ucwords($hasil);
			break;
		default:
			$hasil = ucfirst($hasil);
			break;
	}      
	return $hasil;
}

function churuf($x, $style=3) 
{
	$hasil = $x;

	switch ($style) 
	{
		case 1:
			$hasil = strtoupper($hasil);
			break;
		case 2:
			$hasil = strtolower($hasil);
			break;
		case 3:
			$hasil = ucwords($hasil);
			break;
		default:
			$hasil = ucfirst($hasil);
			break;
	}      
	return $hasil;
}

function romanic_number($integer, $upcase = true)
{
    $table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1);
    $return = '';
    while($integer > 0)
    {
        foreach($table as $rom=>$arb)
        {
            if($integer >= $arb)
            {
                $integer -= $arb;
                $return .= $rom;
                break;
            }
        }
    }

    return $return;
}

function getExe($tipe)
{
	switch ($tipe) {
	  case "application/pdf": $ctype="pdf"; break;
	  case "application/octet-stream": $ctype="exe"; break;
	  case "application/zip": $ctype="zip"; break;
	  case "application/msword": $ctype="doc"; break;
	  case "application/vnd.ms-excel": $ctype="xls"; break;
	  case "application/vnd.ms-powerpoint": $ctype="ppt"; break;
	  case "image/gif": $ctype="gif"; break;
	  case "image/png": $ctype="png"; break;
	  case "image/jpeg": $ctype="jpeg"; break;
	  case "image/jpg": $ctype="jpg"; break;
	  case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet": $ctype="xlsx"; break;
	  case "application/vnd.openxmlformats-officedocument.wordprocessingml.document": $ctype="docx"; break;
	  default: $ctype="application/force-download";
	} 
	
	return $ctype;
} 

function getExtension($varSource)
{
	$temp = explode(".", $varSource);
	return end($temp);
}


function coalesce($varSource, $varReplace)
{
	if($varSource == "")
		return $varReplace;
		
	return $varSource;
}

function unserialized($serialized)
{
	$arrSerialized = str_replace('@', '"', $serialized);			
	return unserialize($arrSerialized);
}



function translate($id, $en)
{
	if($_SESSION["lang"] == "en")
		return $en;	
	else
		return $id;
}

function getBahasa()
{
	if($_SESSION["lang"] == "en")
		return "en";	
	else
		return "";
}

function getTerbilang($x)
{
  $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
  if ($x < 12)
    return " " . $abil[$x];
  elseif ($x < 20)
    return getTerbilang($x - 10) . " belas";
  elseif ($x < 100)
    return getTerbilang($x / 10) . " puluh" . getTerbilang($x % 10);
  elseif ($x < 200)
    return " seratus" . getTerbilang($x - 100);
  elseif ($x < 1000)
    return getTerbilang($x / 100) . " ratus" . getTerbilang($x % 100);
  elseif ($x < 2000)
    return " seribu" . getTerbilang($x - 1000);
  elseif ($x < 1000000)
    return getTerbilang($x / 1000) . " ribu" . getTerbilang($x % 1000);
  elseif ($x < 1000000000)
    return getTerbilang($x / 1000000) . " juta" . getTerbilang($x % 1000000);
}

function isStrContain($string, $keyword)
{
	if (empty($string) || empty($keyword)) return false;
	$keyword_first_char = $keyword[0];
	$keyword_length = strlen($keyword);
	$string_length = strlen($string);
	
	// case 1
	if ($string_length < $keyword_length) return false;
	
	// case 2
	if ($string_length == $keyword_length) {
	  if ($string == $keyword) return true;
	  else return false;
	}
	
	// case 3
	if ($keyword_length == 1) {
	  for ($i = 0; $i < $string_length; $i++) {
	
		// Check if keyword's first char == string's first char
		if ($keyword_first_char == $string[$i]) {
		  return true;
		}
	  }
	}
	
	// case 4
	if ($keyword_length > 1) {
	  for ($i = 0; $i < $string_length; $i++) {
		/*
		the remaining part of the string is equal or greater than the keyword
		*/
		if (($string_length + 1 - $i) >= $keyword_length) {
	
		  // Check if keyword's first char == string's first char
		  if ($keyword_first_char == $string[$i]) {
			$match = 1;
			for ($j = 1; $j < $keyword_length; $j++) {
			  if (($i + $j < $string_length) && $keyword[$j] == $string[$i + $j]) {
				$match++;
			  }
			  else {
				return false;
			  }
			}
	
			if ($match == $keyword_length) {
			  return true;
			}
	
			// end if first match found
		  }
	
		  // end if remaining part
		}
		else {
		  return false;
		}
	
		// end for loop
	  }
	
	  // end case4
	}
	
	return false;
}

function renameFile($varSource)
{
	$varSource = str_replace(" ", "_",$varSource);
	$varSource = str_replace("'", "", $varSource);
	return $varSource;
}

function getColumnExcel($var)
{
	$var = strtoupper($var);
	if($var == "")
		return 0;
		
	if($var == "A")	$tmp = 1;
	elseif($var == "B")	$tmp = 2;
	elseif($var == "C")	$tmp = 3;
	elseif($var == "D")	$tmp = 4;
	elseif($var == "E")	$tmp = 5;
	elseif($var == "F")	$tmp = 6;
	elseif($var == "G")	$tmp = 7;
	elseif($var == "H")	$tmp = 8;
	elseif($var == "I")	$tmp = 9;
	elseif($var == "J")	$tmp = 10;
	elseif($var == "K")	$tmp = 11;
	elseif($var == "L")	$tmp = 12;
	elseif($var == "M")	$tmp = 13;
	elseif($var == "N")	$tmp = 14;
	elseif($var == "0")	$tmp = 15;
	elseif($var == "P")	$tmp = 16;
	elseif($var == "Q")	$tmp = 17;
	elseif($var == "R")	$tmp = 18;
	elseif($var == "S")	$tmp = 19;
	elseif($var == "T")	$tmp = 20;
	
	return $tmp;
}

function terbilang_en($number) {
    
    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );
    
    if (!is_numeric($number)) {
        return false;
    }
    
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'terbilang_en only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . terbilang_en(abs($number));
    }
    
    $string = $fraction = null;
    
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }
    
    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . terbilang_en($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = terbilang_en($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= terbilang_en($remainder);
            }
            break;
    }
    
    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
    
    return $string;
}

function decimalNumber($num2)
{
	if(strpos($num2, '.'))
		return number_format($num2, 2, '.', '');	
	
	return $num2;
}

function harcodemenu()
{
	$arrdata= array(
	  array("MENU_ID"=>"01", "MENU_PARENT_ID"=>"0", "NAMA"=> "Pengaturan", "LINK_FILE"=>"", "AKSES"=>"", "JUMLAH_CHILD"=>1)
	  , array("MENU_ID"=>"0101", "MENU_PARENT_ID"=>"01", "NAMA"=> "Master Pelaksanaan", "LINK_FILE"=>"", "AKSES"=>"", "JUMLAH_CHILD"=>1)
	  , array("MENU_ID"=>"010101", "MENU_PARENT_ID"=>"0101", "NAMA"=> "Setting Pelaksanaan", "LINK_FILE"=>"pengaturan_formula", "AKSES"=>"", "JUMLAH_CHILD"=>0)
	  , array("MENU_ID"=>"010101", "MENU_PARENT_ID"=>"0101", "NAMA"=> "Jadwal", "LINK_FILE"=>"pengaturan_jadwal", "AKSES"=>"", "JUMLAH_CHILD"=>0)
	  // , array("MENU_ID"=>"0101", "MENU_PARENT_ID"=>"01", "NAMA"=> "SK CPNS", "LINK_FILE"=>"pegawai_sk_cpns", "AKSES"=>"", "JUMLAH_CHILD"=>0)
	  // , array("MENU_ID"=>"0101", "MENU_PARENT_ID"=>"01", "NAMA"=> "SK PNS", "LINK_FILE"=>"pegawai_sk_pns", "AKSES"=>"", "JUMLAH_CHILD"=>0)

	  // , array("MENU_ID"=>"02", "MENU_PARENT_ID"=>"0", "NAMA"=> "Data Riwayat", "LINK_FILE"=>"", "AKSES"=>"", "JUMLAH_CHILD"=>1)
	  // , array("MENU_ID"=>"0201", "MENU_PARENT_ID"=>"02", "NAMA"=> "Riwayat Pangkat/Golongan", "LINK_FILE"=>"pegawai_pangkat", "AKSES"=>"", "JUMLAH_CHILD"=>0)
	  // , array("MENU_ID"=>"0201", "MENU_PARENT_ID"=>"02", "NAMA"=> "Riwayat Jabatan", "LINK_FILE"=>"pegawai_jabatan", "AKSES"=>"", "JUMLAH_CHILD"=>0)
	  // , array("MENU_ID"=>"0201", "MENU_PARENT_ID"=>"02", "NAMA"=> "Riwayat Gaji", "LINK_FILE"=>"pegawai_gaji", "AKSES"=>"", "JUMLAH_CHILD"=>0)
	  // , array("MENU_ID"=>"0201", "MENU_PARENT_ID"=>"02", "NAMA"=> "Pendidikan Umum", "LINK_FILE"=>"pendidikan_umum", "AKSES"=>"", "JUMLAH_CHILD"=>0)
	  // // , array("MENU_ID"=>"0201", "MENU_PARENT_ID"=>"02", "NAMA"=> "Riwayat Angka Kredit", "LINK_FILE"=>"riwayat_kredit", "AKSES"=>"", "JUMLAH_CHILD"=>0)
	  // // , array("MENU_ID"=>"0201", "MENU_PARENT_ID"=>"02", "NAMA"=> "Diklat Struktural", "LINK_FILE"=>"diklat_struktural", "AKSES"=>"", "JUMLAH_CHILD"=>0)
	  // // , array("MENU_ID"=>"0201", "MENU_PARENT_ID"=>"02", "NAMA"=> "Diklat Fungsional", "LINK_FILE"=>"diklat_fungsional", "AKSES"=>"", "JUMLAH_CHILD"=>0)
	  // // , array("MENU_ID"=>"0201", "MENU_PARENT_ID"=>"02", "NAMA"=> "Diklat Teknis", "LINK_FILE"=>"diklat_teknis", "AKSES"=>"", "JUMLAH_CHILD"=>0)
	  // , array("MENU_ID"=>"0201", "MENU_PARENT_ID"=>"02", "NAMA"=> "Diklat", "LINK_FILE"=>"pegawai_diklat", "AKSES"=>"", "JUMLAH_CHILD"=>0)
	  // , array("MENU_ID"=>"0201", "MENU_PARENT_ID"=>"02", "NAMA"=> "Kursus", "LINK_FILE"=>"pegawai_kursus", "AKSES"=>"", "JUMLAH_CHILD"=>0)
	  // // , array("MENU_ID"=>"0201", "MENU_PARENT_ID"=>"02", "NAMA"=> "Seminar/Lokakarya/Bimtek", "LINK_FILE"=>"pegawai_seminar", "AKSES"=>"", "JUMLAH_CHILD"=>0)
	  // , array("MENU_ID"=>"0201", "MENU_PARENT_ID"=>"02", "NAMA"=> "Tambahkan Masa Kerja", "LINK_FILE"=>"tambahan_masa_kerja", "AKSES"=>"", "JUMLAH_CHILD"=>0)

	  // , array("MENU_ID"=>"03", "MENU_PARENT_ID"=>"0", "NAMA"=> "Data Keluarga", "LINK_FILE"=>"", "AKSES"=>"", "JUMLAH_CHILD"=>1)
	  // , array("MENU_ID"=>"0301", "MENU_PARENT_ID"=>"03", "NAMA"=> "Orang Tua", "LINK_FILE"=>"pegawai_orang_tua", "AKSES"=>"", "JUMLAH_CHILD"=>0)
	  // , array("MENU_ID"=>"0301", "MENU_PARENT_ID"=>"03", "NAMA"=> "Suami/Istri", "LINK_FILE"=>"pegawai_suami_istri", "AKSES"=>"", "JUMLAH_CHILD"=>0)
	  // , array("MENU_ID"=>"0301", "MENU_PARENT_ID"=>"03", "NAMA"=> "Anak", "LINK_FILE"=>"pegawai_anak", "AKSES"=>"", "JUMLAH_CHILD"=>0)

	  // , array("MENU_ID"=>"04", "MENU_PARENT_ID"=>"0", "NAMA"=> "Lain Lain", "LINK_FILE"=>"", "AKSES"=>"", "JUMLAH_CHILD"=>1)
	  // , array("MENU_ID"=>"0401", "MENU_PARENT_ID"=>"04", "NAMA"=> "Organisasi", "LINK_FILE"=>"pegawai_organisasi", "AKSES"=>"", "JUMLAH_CHILD"=>0)
	  // , array("MENU_ID"=>"0401", "MENU_PARENT_ID"=>"04", "NAMA"=> "Penghargaan", "LINK_FILE"=>"pegawai_penghargaan", "AKSES"=>"", "JUMLAH_CHILD"=>0)
	  // , array("MENU_ID"=>"0401", "MENU_PARENT_ID"=>"04", "NAMA"=> "Penilaian Potensi Diri", "LINK_FILE"=>"pegawai_penilaian_potensi", "AKSES"=>"", "JUMLAH_CHILD"=>0)
	  // , array("MENU_ID"=>"0401", "MENU_PARENT_ID"=>"04", "NAMA"=> "Penilaian Prestasi Kerja (SKP)", "LINK_FILE"=>"pegawai_penilaian_prestasi", "AKSES"=>"", "JUMLAH_CHILD"=>0)
	  // , array("MENU_ID"=>"0401", "MENU_PARENT_ID"=>"04", "NAMA"=> "Hukuman", "LINK_FILE"=>"pegawai_hukuman", "AKSES"=>"", "JUMLAH_CHILD"=>0)
	  // , array("MENU_ID"=>"0401", "MENU_PARENT_ID"=>"04", "NAMA"=> "Cuti", "LINK_FILE"=>"pegawai_cuti", "AKSES"=>"", "JUMLAH_CHILD"=>0)
	  // , array("MENU_ID"=>"0401", "MENU_PARENT_ID"=>"04", "NAMA"=> "Penguasaan Bahasa", "LINK_FILE"=>"pegawai_bahasa", "AKSES"=>"", "JUMLAH_CHILD"=>0)

	);
	return $arrdata;
}

function json_response($code = 200, $message = null)
{
    // clear the old headers
    header_remove();
    // set the actual code
    http_response_code($code);
    // set the header to make sure cache is forced
    header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
    // treat this as json
    header('Content-Type: application/json');
    $status = array(
        200 => '200 OK',
        400 => '400 Bad Request',
        422 => 'Unprocessable Entity',
        500 => '500 Internal Server Error'
        );
    // ok, validation error, or failure
    header('Status: '.$status[$code]);
    // return the encoded json
    return json_encode(array(
        'status' => $code < 300, // success or not?
        'message' => $message
        ));
}

function romanicNumber($integer, $upcase = true)
{
    $table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1);
    $return = '';
    while($integer > 0)
    {
        foreach($table as $rom=>$arb)
        {
            if($integer >= $arb)
            {
                $integer -= $arb;
                $return .= $rom;
                break;
            }
        }
    }

    return $return;
}

function radioPenilaian($tempNilai, $val="checked")
{
	  if($tempNilai == 1)
	  {
		  $arrChecked[0]=$val;
		  $arrChecked[1]="";
		  $arrChecked[2]="";
		  $arrChecked[3]="";
		  $arrChecked[4]="";
		  $arrChecked[5]="";
	  }
	  elseif($tempNilai == 2)
	  {
		  $arrChecked[0]="";
		  $arrChecked[1]=$val;
		  $arrChecked[2]="";
		  $arrChecked[3]="";
		  $arrChecked[4]="";
		  $arrChecked[5]="";
	  }
	  elseif($tempNilai == 3)
	  {
		  $arrChecked[0]="";
		  $arrChecked[1]="";
		  $arrChecked[2]=$val;
		  $arrChecked[3]="";
		  $arrChecked[4]="";
		  $arrChecked[5]="";
	  }
	  elseif($tempNilai == 4)
	  {
		  $arrChecked[0]="";
		  $arrChecked[1]="";
		  $arrChecked[2]="";
		  $arrChecked[3]=$val;
		  $arrChecked[4]="";
		  $arrChecked[5]="";
	  }
	  elseif($tempNilai == 5)
	  {
		  $arrChecked[0]="";
		  $arrChecked[1]="";
		  $arrChecked[2]="";
		  $arrChecked[3]="";
		  $arrChecked[4]=$val;
		  $arrChecked[5]="";
	  }
	  elseif($tempNilai == 6)
	  {
		  $arrChecked[0]="";
		  $arrChecked[1]="";
		  $arrChecked[2]="";
		  $arrChecked[3]="";
		  $arrChecked[4]="";
		  $arrChecked[5]=$val;
	  }
	  else
	  {
		  $arrChecked[0]="";
		  $arrChecked[1]="";
		  $arrChecked[2]=$val;
		  $arrChecked[3]="";
		  $arrChecked[4]="";
		  $arrChecked[5]="";
	  }
	  
	  return $arrChecked;
}

function NolToNone($varId)
{
	if($varId == '0')
		return "";
	else
		return $varId;
}

function valuechecked($n, $info= "√")
{
	$return= "";
	if($n == ""){}
	else
		$return= $info;

	return $return;
}

function infobelbin()
{
	$arrdata= array(
		array(
			"id"=>"1", "text"=>"Implementor"
			, "karakter"=>"Implementer mempunyai pemikiran yang praktis dan juga kontrol diri serta disiplin. Mereka memilih untuk bekerja keras dan menyelesaikan masalah dengan cara sistematis. Secara lebih luas IMP biasanya adalah orang yang memiliki minat dan kesetiaan terhadap perusahaan dan mereka kurang tertarik untuk mengejar tujuan pribadi. Walau demikian, IMP mungkin kurang memiliki spontanitas dan menunjukkan tanda-tanda kekakuan. Mereka biasanya konservatif, disiplin, bekerja secara sistematis, efisien, dan terorganisir dengan baik."
			, "fungsi"=>"IMP berguna bagi organisasi karena mereka efisien dan karena mereka dapat mengetahui apa yang relevan dan bisa dilakukan. Banyak yang mengatakan bahwa ekseutif hanya mengerjakan tugas yang mereka inginkan dan menghindari tugas yang tidak mereka inginkan. Berbeda dengan IMP, mereka akan melakukan apa yang perlu dilakukan."
			, 
			"data"=> array(
				array("soal"=>"1", "jawaban"=>"3")
				, array("soal"=>"2", "jawaban"=>"1")
				, array("soal"=>"3", "jawaban"=>"9")
				, array("soal"=>"4", "jawaban"=>"4")
				, array("soal"=>"5", "jawaban"=>"5")
				, array("soal"=>"6", "jawaban"=>"2")
				, array("soal"=>"7", "jawaban"=>"8")
			)
		)
		, array(
			"id"=>"2", "text"=>"Coordinator"
			, "karakter"=>"Aspek yang paling menonjol dari Coordinator adalah kemampuan mereka untuk menyebabkan orang lain untuk bekerja mencapai tujuan bersama. Dewasa, mempercayai dan percaya diri, mereka dapat mendelegasikan dengan segera. Dalam hubungan interpersonal, mereka dengan cepat dapat mengamati bakat individual dan menggunakannya untuk mencapai tujuan kelompok. Walau CO mungkin bukan orang yang paling cerdas dalam kelompok, namun mereka memiliki pandangan yang luas dan umumnya dihormati oleh orang-orang. Namun, kedekatan mereka dengan bawahannya menimbulkan kesan kurang tegas"
			, "fungsi"=>"Fungsi CO paling tepat bila ditugaskan mengurus sekelompok orang dengan keterampilan dan karakteristik pribadi yang berbeda-beda. Mereka akan lebih baik berhubungan dengan rekan yang kedudukannya setara daripada mengatur bawahannya. Pada beberapa kasus, CO cenderung untuk bertentangan dengan shapers karena  gaya manajemennya berlawanan"
			, 
			"data"=> array(
				array("soal"=>"1", "jawaban"=>"5")
				, array("soal"=>"2", "jawaban"=>"7")
				, array("soal"=>"3", "jawaban"=>"3")
				, array("soal"=>"4", "jawaban"=>"2")
				, array("soal"=>"5", "jawaban"=>"8")
				, array("soal"=>"6", "jawaban"=>"5")
				, array("soal"=>"7", "jawaban"=>"4")
			)
		)
		, array(
			"id"=>"3", "text"=>"Shaper"
			, "karakter"=>"Shapers adalah orang yang memiliki motivasi tinggi dengan energi yang besar dan kebutuhan mencapai prestasi yang tinggi. Biasanya mereka adalah orang ekstrovert yang agresifa dan memiliki semangat kuat. SH senang menantang pihak lain dan keinginan mereka adlaah untuk menang. Mereka sering memimpin dan mendorong orang untuk bertindask. Jika ada halangan mereka berusaha untuk melintasinya. Keras kepala dan assertive, mereka cenderung untuk menunjukkan respon emosional berargumentasi dan mungkin kurang memiliki pemahaman interpersonal. Mereka memiliki peranan paling kompetitif dalam tim."
			, "fungsi"=>"SH umumnya menjadi manajer yang baik karena dapat menggerakkan dan bertahan menghadapi tekanan. Mereka paling mampu membangkitkan suatu tim dan paling berguna untuk satu grup pada saat komplikasi politis cenderung memperlambat kerja. Sha cenderung untuk mengatasi masalah semacam ini dan terus bergerak maju."
			, 
			"data"=> array(
				array("soal"=>"1", "jawaban"=>"9")
				, array("soal"=>"2", "jawaban"=>"6")
				, array("soal"=>"3", "jawaban"=>"8")
				, array("soal"=>"4", "jawaban"=>"3")
				, array("soal"=>"5", "jawaban"=>"9")
				, array("soal"=>"6", "jawaban"=>"7")
				, array("soal"=>"7", "jawaban"=>"1")
			)
		)
		, array(
			"id"=>"4", "text"=>"Plant"
			, "karakter"=>"Plant adalah mereka yang menjadi inovator dan penemu serta memiliki kreativitas tinggi. Mereka menghasilkan ide-ide sebagai perkembangan utama. Biasanya mereka menyukai untuk bekerja sendiri, terpisah dari anggota kelompok yang lain, menggunakan imajinasi mereka dan sering bekerja dengan cara yang tidak ortodoks. Mereka cenderung untuk bersifat introvert dan bereaksi dengan kuat terhadap ujian dan kritik. Ide-ide mereka mungkin menjadi radikal dan kurang terkontrol. Mereka adalah oranga yang indenpenden, cerdas dan memiliki gagasan baru, namun sulit mengkomunikasikannya."
			, "fungsi"=>"Fungsi utama dari PL adalah untuk membangkitkan saran-saran baru dan memecahkan permasalahan yang komplek. Para PL sering diperlukan pada saat permulaan bekerja atau sebagai pencipta produk baru. Oleh karena itu pada PL biasanya dikenang sebagai para pendiri perusahaan atau sebagai pencipta produk baru."
			, 
			"data"=> array(
				array("soal"=>"1", "jawaban"=>"8")
				, array("soal"=>"2", "jawaban"=>"4")
				, array("soal"=>"3", "jawaban"=>"1")
				, array("soal"=>"4", "jawaban"=>"5")
				, array("soal"=>"5", "jawaban"=>"3")
				, array("soal"=>"6", "jawaban"=>"6")
				, array("soal"=>"7", "jawaban"=>"9")
			)
		)
		, array(
			"id"=>"5", "text"=>"Resource Investigator"
			, "karakter"=>"Resources Investigator adalah mereka yang memiliki antusiasme dan cepat tanggap. Mampu berkomunikasi dengan sekitarnya, baik bila ia berada dialer dan diluar lingkungan perusahaan. Mereka memiliki kemampuan untuk melakukan negoisiasi dan menyelidiki kesempatan-kesempatan yang bersifat baru serta membina hubungan. Walaupun bukan sebagai sumber ide-ide baru yang utama, RI efektif dalam menangkap ide-ide orang lain serta mengembangkannya. Seperti yang disebutkan dalam namanya, mereka terampil dalam menemukan apa yang tersedia dan apa yang dapat dilakukan"
			, "fungsi"=>"Mereka biasanya diterima dengan hangat oleh orang lain karena sikapnya. RI memiliki kepribadian yang tenang dengan naluri ingin tahu yang kuat serta kesiapan untuk melihat kemungkinan pada hal-hal baru. Namun demikian, tanpa adanya dorongan dari orang lain maka antusiasme mereka akan cepat hilang."
			, 
			"data"=> array(
				array("soal"=>"1", "jawaban"=>"1")
				, array("soal"=>"2", "jawaban"=>"9")
				, array("soal"=>"3", "jawaban"=>"4")
				, array("soal"=>"4", "jawaban"=>"6")
				, array("soal"=>"5", "jawaban"=>"7")
				, array("soal"=>"6", "jawaban"=>"3")
				, array("soal"=>"7", "jawaban"=>"5")
			)
		)
		, array(
			"id"=>"6", "text"=>"Monitor Evaluator"
			, "karakter"=>"Monitor Evaluator adalah tipe inidividu yang serius, bijaksana dan tidak mudah bersikap over antusiastik. Mereka lambat dalam mengambil keputusan karena berusaha untuk mempertimbangkannya berulang kali. Biasanya mereka memiliki kemampuan berfikir kritis yang tinggi. Mereka memiliki kapasitas untuk berfikir bijak dengan memperhitungkan segala faktor. ME yang baik jarang membuat kesalahan. Mereka biasanya mempunyai kemampuan berpikir kritis yang tinggi, mereka memiliki kapasitas untuk membuat penilaian yang cerdas dengan memperhitungkan semua faktor yang berpengaruh."
			, "fungsi"=>"ME paling cocok dalam menganalisa masalah, mengevaluasi ide-ide dan saran. Mereka paling baik dalam mempertimbangkan hal yang baik dan buruk dari suatu pilihan. Untuk orang lain, ME mungkin dipandang sebagai orang yang membosankan, tidak ramah atau bahkan terlalu kritis."
			, 
			"data"=> array(
				array("soal"=>"1", "jawaban"=>"7")
				, array("soal"=>"2", "jawaban"=>"2")
				, array("soal"=>"3", "jawaban"=>"6")
				, array("soal"=>"4", "jawaban"=>"8")
				, array("soal"=>"5", "jawaban"=>"1")
				, array("soal"=>"6", "jawaban"=>"4")
				, array("soal"=>"7", "jawaban"=>"7")
			)
		)
		, array(
			"id"=>"7", "text"=>"Team Worker"
			, "karakter"=>"Team workers adalah anggota kelompok yang paling mendukung. Mereka bersifat tenang, senang bergaul dan perduli dengan orang lain. Mereka memiliki kapasitas terbesar untuk flesibilitas dan beradaptasi dengan orang dan situasi yang berbeda. TW bersifat diplomatis dan perseptif. TW adalah pendengar yang baik dan biasanya menjadi anggota kelompok yang populer. Mereka memiliki sensivitas dalam bekerja, tapi mereka tidak dapat memutuskan kesimpulan pada situasi mendesak.  Potensi kelemahan mereka adalah dalam situasi kritis mereka tidak dapat membuat keputusan yang tegas."
			, "fungsi"=>"Peran TW adalah mencegah munculnya masalah interpersonal dalam kelompok sehingga membuat semua anggota kelompok dapat memberikan sumbangannya dengan efektif. Karena tidak menyukai perselisihan, mereka berusaha sekeras mungkin untuk menghindarinya."
			, 
			"data"=> array(
				array("soal"=>"1", "jawaban"=>"2")
				, array("soal"=>"2", "jawaban"=>"3")
				, array("soal"=>"3", "jawaban"=>"7")
				, array("soal"=>"4", "jawaban"=>"1")
				, array("soal"=>"5", "jawaban"=>"6")
				, array("soal"=>"6", "jawaban"=>"9")
				, array("soal"=>"7", "jawaban"=>"2")
			)
		)
		, array(
			"id"=>"8", "text"=>"Complete Finisher"
			, "karakter"=>"Completer Finsiher memiliki kapasitas yang baik untuk menyelesaikan tugas dan memperhatikan detail. Mereka tidak akan memulai seseuatu yang tidak dapat mereka selesaikan. Mereka termotivasi oleh kecemasan, namun di luarnya mereka mungkin tampak tenang. Biasanya, mereka bersifat introvert dan sedikit membutuhkan stimulus atau insentif eksternal. CF mungkin tidak toleran dengan pihak yang memiliki kepribadian santai. Mereka tidak terlalu bersemangat untuk mendelegasikan sesuatu, lebih menyukai untuk mengerjakan semua tugas sendirian."
			, "fungsi"=>"CF sangat berguna di saat suatu tugas memerlukan konsentrasi dan tingkat keakuratan yang tinggi. Mereka mendorong munculnya suatu kesan mendesak di dalam suatu kelompok dan mereka dapat memenuhi jadwal dengan baik. Dalam manejemen, mereka tampil menonjol karena standar tinggi yang mereka terapkan, dan karena sifat perfeksionis mereka hingga ke detail."
			, 
			"data"=> array(
				array("soal"=>"1", "jawaban"=>"4")
				, array("soal"=>"2", "jawaban"=>"5")
				, array("soal"=>"3", "jawaban"=>"2")
				, array("soal"=>"4", "jawaban"=>"7")
				, array("soal"=>"5", "jawaban"=>"4")
				, array("soal"=>"6", "jawaban"=>"8")
				, array("soal"=>"7", "jawaban"=>"6")
			)
		)
		, array(
			"id"=>"9", "text"=>"Specialist"
			, "karakter"=>"Specialist sebagai individu yang berdedikasi dan membanggakan dirinya karena memiliki keterampilan teknis dan pengetahuan spesialis. Pusat perhatian mereka adalah untuk mempertahankan standar profesional dan untuk meningkatkan dan mempertahankan lapangan ilmu mereka. Walaupun mereka sangat bangga dengan subyeknya, biasanya mereka kurang tetarik dengan pihak lain. SP menjadi seorang ahli karena komitmen mutlak mereka pada bidang terbatas. Hanya sedikit orang yang memiliki bakat atau kecenderungan untuk SP terbaik."
			, "fungsi"=>"SP memiliki peran yang tidak bisa dilepaskan dalam sejumlah tim, karena mereka memiliki keterampilan yang diperlukan untuk pelayanan atau produk perusahaan. Sebagai manajer, mereka dapat memperoleh dukungan karena mereka lebih mengetahui subyeknya dibandingkan orang lain dan mereka diandalkan untuk membuat keputusan berdasarkan pengalamannya."
			, 
			"data"=> array(
				array("soal"=>"1", "jawaban"=>"6")
				, array("soal"=>"2", "jawaban"=>"8")
				, array("soal"=>"3", "jawaban"=>"5")
				, array("soal"=>"4", "jawaban"=>"9")
				, array("soal"=>"5", "jawaban"=>"2")
				, array("soal"=>"6", "jawaban"=>"1")
				, array("soal"=>"7", "jawaban"=>"3")
			)
		)
	);

	return $arrdata;
}

function infobelbinget($infoid, $text="data")
{
	$arrdata= infobelbin();
	$arraykey= in_array_column($infoid, "id", $arrdata);
	// print_r($arraykey);exit;
	$indexdata= $arraykey[0];
	return $arrdata[$indexdata][$text];
}

function checkketeranganvalid($str)
{
	// if($str == "										            												            	")
	// 	$str= "";

	// elseif($str == "										            												            												            												            		")
	// 	$str= str_replace("										            												            												            												            		", "", $str);
	return trim($str);
}

function infoasesorlaporan($rolemode="pusat")
{
	if($rolemode == "pusat")
	{
		$arrdata= array(
			array(
				"jenis"=>"kesimpulan_umum", "text"=>"EXECUTIVE SUMMARY"
				, 
				"data"=> array("EXECUTIVE SUMMARY", "KESIMPULAN UMUM")
			)
			, array(
				"jenis"=>"deskripsi_kompetensi", "text"=>"DESKRIPSI KOMPETENSI"
			)
			, array(
				"jenis"=>"deskripsi_potensi", "text"=>"DESKRIPSI POTENSI"
			)
			, array(
				"jenis"=>"saran_pengembangan", "text"=>"SARAN PENGEMBANGAN KOMPETENSI"
			)
			, array(
				"jenis"=>"saran_pengembangan_potensi", "text"=>"SARAN PENGEMBANGAN POTENSI"
			)
		);
	}
	else if($rolemode == "pds")
	{
		$arrdata= array(
			array(
				"jenis"=>"area_kekuatan", "text"=>"AREA KEKUATAN"
				, 
				"data"=> array("EXECUTIVE SUMMARY", "KESIMPULAN UMUM")
			)
			, array(
				"jenis"=>"area_pengembangan", "text"=>"AREA PENGEMBANGAN"
			)
			, array(
				"jenis"=>"saran_pengembangan_mandiri", "text"=>"PENGEMBANGAN MANDIRI"
			)
			, array(
				"jenis"=>"saran_penugasan_khusus", "text"=>"PENUGASAN KHUSUS"
			)
		);
	}

	return $arrdata;
}

function infoasesorlaporanget($infoid, $text="text", $rolemode="pusat")
{
	$arrdata= infoasesorlaporan($rolemode);
	$arraykey= in_array_column($infoid, "jenis", $arrdata);
	// print_r($arraykey);exit;
	$indexdata= $arraykey[0];
	return $arrdata[$indexdata][$text];
}

function infoasesorpsikologilaporan()
{
	$arrdata= array(
		array(
			"jenis"=>"hasil_pemeriksaan", "text"=>"HASIL PEMERIKSAAN PSIKOLOGIS", "penggalianid"=>1
		)
		, array(
			"jenis"=>"kesimpulan", "text"=>"KESIMPULAN"
			,  "data"=> array(
				array("jenis"=>"kesimpulan_mendukung", "text"=>"Hal yang mendukung kinerja", "penggalianid"=>2)
				, array("jenis"=>"kesimpulan_menghambat", "text"=>"Hal yang menghambat kinerja", "penggalianid"=>3)
			)
		)
		, array(
			"jenis"=>"saran_pengembangan", "text"=>"SARAN PENGEMBANGAN", "penggalianid"=>4
		)
	);

	return $arrdata;
}

function infoasesorpsikologilaporanget($infoid, $text="text")
{
	$arrdata= infoasesorpsikologilaporan();
	$arraykey= in_array_column($infoid, "jenis", $arrdata);
	// print_r($arraykey);exit;
	$indexdata= $arraykey[0];
	return $arrdata[$indexdata][$text];
}

function kesimpulanasesor($infokode)
{
	$return= "Tidak disarankan";
	if($infokode == "P")
		$return= "Dipertimbangkan";
	elseif($infokode == "S")
		$return= "Disarankan";
	elseif($infokode == "-")
		$return= $infokode;

	return $return;
}

function num2alpha($n) {
    $r = '';
    for ($i = 1; $n >= 0 && $i < 10; $i++) {
    $r = chr(0x41 + ($n % pow(26, $i) / pow(26, $i - 1))) . $r;
    $n -= pow(26, $i);
    }
    return $r;
}

function alpha2num($a) {
    $r = 0;
    $l = strlen($a);
    for ($i = 0; $i < $l; $i++) {
    $r += pow(26, $i) * (ord($a[$l - $i - 1]) - 0x40);
    }
    return $r - 1;
}

function toAlpha($data){
    $alphabet =   array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
    $alpha_flip = array_flip($alphabet);
        if($data <= 25){
          return $alphabet[$data];
        }
        elseif($data > 25){
          $dividend = ($data + 1);
          $alpha = '';
          $modulo;
          while ($dividend > 0){
            $modulo = ($dividend - 1) % 26;
            $alpha = $alphabet[$modulo] . $alpha;
            $dividend = floor((($dividend - $modulo) / 26));
          } 
          return $alpha;
        }

}
function getmultiseparator($vreturn)
{
	$vreturn= str_replace("'", "", $vreturn);
	$vreturn= explode(",", $vreturn);
	return $vreturn;
}


function checkFile($tipe,$jenis)
{
	$acceptable = array();

	if($jenis==1)
	{
		$acceptable = array(
			'image/jpeg'
			,'image/png'
		);
	}
	else
	{
		$acceptable = array(
			'application/pdf'
		);
	}
	
	if((in_array($tipe, $acceptable))) {
		return true;
	}
	else
	{
		return false;
	}
}

function findNextPrev($current_value,$array,$jenisarray,$kolom,$cari)
{
	$index="";
	$sebelum="";
	$lanjut="";	
	if($jenisarray==1)
	{
		//multi dimensional array
		$index = array_search($current_value, array_column($array, $kolom));
		if($index !== false && $index > 0 ) $prev = $array[$index-1];
		if($index !== false && $index < count($array)-1) $next = $array[$index+1];
		$sebelum = $prev[$kolom];
		$lanjut = $next[$kolom];
	}
	else if($jenisarray==2)
	{
		// single array
		$index = array_search($current_value, $array);
		if($index !== false && $index > 0 ) $prev = $array[$index-1];
		if($index !== false && $index < count($array)-1) $next = $array[$index+1];
		$sebelum = $prev;
		$lanjut = $next;
	}

	if($cari==1)
	{
		return $sebelum; 	
	}
	else if($cari==2)
	{
		return $lanjut;
	}
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>