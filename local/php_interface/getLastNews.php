<?define('DR',str_replace('/local/php_interface','',__DIR__));
$_SERVER["DOCUMENT_ROOT"] = DR;
require_once(DR.'/bitrix/modules/main/include/prolog_before.php');
$xml_string = file_get_contents('https://habr.com/ru/rss/best/daily/');
$xml = new CDataXML();
$xml->LoadString($xml_string);
$arData = $xml->GetArray();
$channel = $arData['rss']['#']['channel'];
$channel = array_shift($channel);
$items = $channel['#']['item'];
for($i=0;$i<5;$i++) {
	$item = $items[$i]['#'];
	$title = array_shift($item['title'])['#'];
	$guid = array_shift($item['guid'])['#'];
	$anons = array_shift($item['description'])['#'];
	
	print_r ("\n");
	print_r ("Название: ".$title."\n");
	print_r ("Ссылка: ".$guid."\n");
	print_r ("Анонс: ".strip_tags($anons)."\n");
	print_r ("===================================================================\n");
	
}

?>