<?php
require_once("dbcontroller.php");
$db_handle = new DBController();

$master = $_POST["master"];
$editObj = $_POST["editObj"];
$editVal = $_POST["editVal"];
$sk_sr = $_POST["sk_sr"];
$date = date('d.m.Y', strtotime($_POST["date"]));
$day = $_POST["day"];

$row_count = $db_handle->numRows("SELECT * FROM `".$master."` WHERE `sk_sr`='".$sk_sr."' AND date='".$date."'");

if ($row_count == 0) {
	if (strcmp($editObj, "centre_name") == 0 && $editVal != '') {

		$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
		fwrite($myfile, "INSERT INTO `".$master."` (`id`, `row`, `col`, `centre_name`, `date`, `day`, `sk_sr`, `pathi`, `ground`) VALUES ('', '', '', '".$editVal."', '".$date."', '', '".$sk_sr."', '', '')");
		fclose($myfile);

		$result = $db_handle->executeUpdate("INSERT INTO `".$master."` (`id`, `row`, `col`, `centre_name`, `date`, `day`, `sk_sr`, `pathi`, `ground`) VALUES ('', '', '', '".$editVal."', '".$date."', '".$day."', '".$sk_sr."', '', '')");
	}
}
else {

	$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
	fwrite($myfile, "UPDATE `".$master."` set ".$editObj." = '".$editVal."' WHERE `sk_sr`='".$sk_sr."' AND date='".$date."'");
	fclose($myfile);

	$result = $db_handle->executeUpdate("UPDATE `".$master."` set ".$editObj." = '".$editVal."' WHERE `sk_sr`='".$sk_sr."' AND date='".$date."'");;
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