<?php
require_once("dbcontroller.php");
$db_handle = new DBController();

$master = $_POST["master"];
$editObj = $_POST["editObj"];
$editVal = $_POST["editVal"];
$sk_sr = $_POST["sk_sr"];
$date = date('d.m.Y', strtotime($_POST["date"]));
$day = $_POST["day"];
$satsang_no = "";

$row_count = $db_handle->numRows("SELECT * FROM `".$master."` WHERE `sk_sr`='".$sk_sr."'");

if ($row_count == 0) {
	if (strcmp($editObj, "centre_name") == 0 && $editVal != '') {
		$result = $db_handle->executeUpdate("INSERT INTO `".$master."` (`id`, `row`, `col`, `centre_name`, `date`, `day`, `sk_sr`, `pathi`, `ground`) VALUES ('', '', '', '".$editVal."', '".$date."', '".$day."', '".$sk_sr."', '', '')");
	}
}
else if (strcmp($editObj, "pathi") == 0) {

	if ($editVal != '') {
		if (strpos($editVal, ")") != false) {
			$satsang_no = "(".explodeCheck($editVal, '(');
		}

		if ($satsang_no != '') {
			$result = $db_handle->executeUpdate("UPDATE `".$master."` set satsang_no = '".$satsang_no."' WHERE `sk_sr`='".$sk_sr."'");
		}
	}
}

function explodeCheck($str, $del)
{	
	if (strpos($str, $del) != false) {
		return TRIM(explode($del, $str)[1]);
	} else {
		return "";
	}
}
?>