<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once("functions/string.func.php");

class Globalfunc
{
	function getkelompokequipmenttree($arrparam)
	{
		$CI = &get_instance();
		$CI->load->model("base-app/KelompokEquipment");

		$statement="";
		$set= new KelompokEquipment();
		$arrsimpegjabatan= [];
		$set->selectByParams(array(), -1,-1,$statement);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= [];
			$arrdata["id"]= $set->getField("KELOMPOK_EQUIPMENT_ID");
			$arrdata["vid"]= $set->getField("ID");
			$arrdata["parentid"]= $set->getField("PARENT_ID");
			$arrdata["text"]= $set->getField("NAMA");
			array_push($arrsimpegjabatan, $arrdata);
		}
		unset($set);
		// print_r($arrsimpegjabatan);exit;

		$arrdatajabatan= [];
		$infocarikey= "0";
		// echo $infocarikey;exit;
		$arrcheck= in_array_column($infocarikey, "parentid", $arrsimpegjabatan);
		// print_r($arrcheck);exit;
		foreach ($arrcheck as $vindex)
		{
			$vid= $arrsimpegjabatan[$vindex]["id"];
			$vtext= $arrsimpegjabatan[$vindex]["text"];

			$arrdata= [];
			$arrdata["id"]= $vid;
			$arrdata["text"]= $vtext;

			$vid= $arrsimpegjabatan[$vindex]["vid"];
			$infocarichildkey= $vid;
			$arrchildcheck= in_array_column($infocarichildkey, "parentid", $arrsimpegjabatan);
			if(!empty($arrchildcheck))
			{
				$arrdata["inc"]= $this->getchild($vid, $arrsimpegjabatan);
			}
			array_push($arrdatajabatan, $arrdata);
		}
		return $arrdatajabatan;
	}

	function getchild($vid, $arrsimpegjabatan)
	{
		$arrdatachildjabatan= [];
		$infocarikey= $vid;
		$arrcheck= in_array_column($infocarikey, "parentid", $arrsimpegjabatan);
		// print_r($arrcheck);exit;
		foreach ($arrcheck as $vindex)
		{
			$vid= $arrsimpegjabatan[$vindex]["id"];
			$vtext= $arrsimpegjabatan[$vindex]["text"];

			$arrdata= [];
			$arrdata["id"]= $vid;
			$arrdata["text"]= $vtext;

			$vid= $arrsimpegjabatan[$vindex]["vid"];
			$infocarichildkey= $vid;
			$arrchildcheck= in_array_column($infocarichildkey, "parentid", $arrsimpegjabatan);
			if(!empty($arrchildcheck))
			{
				$arrdata["inc"]= $this->getchild($vid, $arrsimpegjabatan);
			}
			array_push($arrdatachildjabatan, $arrdata);
		}
		return $arrdatachildjabatan;
	}

}