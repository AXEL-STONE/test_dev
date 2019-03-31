<?


function x ($obj) {
		echo "<xmp>-=";
		print_r($obj);
		echo "=-</xmp>";
}
function xe ($obj) {
		x($obj);
		die();
}

include(__DIR__.'/include/class.work_iblock.php');


?>