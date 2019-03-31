<?

class CWorkIblock {
	private $arrFilter = array('ACTIVE'=>'Y');
	private $arrSort = array('SORT'=>'ASC');
	private $arrSelect = array('ID','NAME');
	private $pageData = array('nPageSize'=>100);
	private $timecach = 36000;
	
	function SetSelect ($arr) {
		$this->arrSelect = $arr;
	}
	function SetSort ($arr) {
		$this->arrSort = $arr;
	}
	function SetPageParametr ($arr) {
		$this->pageData = $arr;
	}
	function SetFilter ($arr) {
		$this->arrFilter = $arr;
	}
	function SetTimeCach ($time) {
		$this->timecach = intval($time);
	}
	function GetList () {
		$cache_id = md5(serialize(array_merge($this->arrSelect,$this->arrSort,$this->arrFilter,($this->pageData?$this->pageData:array()))));
		$cache_dir = "/tagged_getlist";
		$obCache = new CPHPCache;
		if($obCache->InitCache($this->timecach, $cache_id, $cache_dir)) {
			$arElements = $obCache->GetVars();
		} elseif(CModule::IncludeModule("iblock") && $obCache->StartDataCache()) {
			$arElements = array();
			$rsElements = CIBlockElement::GetList($this->arrSort, $this->arrFilter, false, $this->pageData, $this->arrSelect);
			global $CACHE_MANAGER;
			$CACHE_MANAGER->StartTagCache($cache_dir);
			while($arElement = $rsElements->Fetch()) {
				$CACHE_MANAGER->RegisterTag("iblock_id_".$arElement["IBLOCK_ID"]);
				$arElements[] = $arElement;
			}
			$CACHE_MANAGER->RegisterTag("iblock_id_new");
			$CACHE_MANAGER->EndTagCache();
			$obCache->EndDataCache($arElements);
		} else {
			$arElements = array();
		}
		return $arElements;
	}
}


?>