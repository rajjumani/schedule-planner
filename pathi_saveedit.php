<?php
require_once("dbcontroller.php");
$db_handle = new DBController();

$master = $_POST["master"];
$editObj = $_POST["editObj"];
$editVal = $_POST["editVal"];
$pathi = $_POST["pathi_name"];
$date = date('d.m.Y', strtotime($_POST["date"]));
$day = $_POST["day"];
$col = 701;

if (strcmp($editObj, "centre_name") == 0) {

	if ($editVal != '') {
		
		$row_count = $db_handle->numRows("SELECT * FROM `".$master."` WHERE (`pathi`='PA: ".$pathi."' OR `ground`='SS: ".$pathi."') AND date='".$date."'");
		if ($row_count == 0) {
			$result = $db_handle->executeUpdate("INSERT INTO `".$master."` (`id`, `row`, `col`, `centre_name`, `date`, `day`, `sk_sr`, `pathi`, `ground`) VALUES ('', '', '".$col."', '".$editVal."', '".$date."', '".$day."', '', 'PA: ".$pathi."', '')");
		}
		else {
			$result = $db_handle->executeUpdate("UPDATE `".$master."` set centre_name = '".$centre_name."' WHERE (`pathi`='PA: ".$pathi."' OR `ground`='SS: ".$pathi."') AND date='".$date."'");
		}
	}
	else {
		$result = $db_handle->executeUpdate("UPDATE `".$master."` set centre_name = '".$centre_name."' WHERE (`pathi`='PA: ".$pathi."' OR `ground`='SS: ".$pathi."') AND date='".$date."'");
	}
}

else if (strcmp($editObj, "sk_sr") == 0) {
			
	$result = $db_handle->executeUpdate("UPDATE `".$master."` set sk_sr = '".$editVal."' WHERE (`pathi`='PA: ".$pathi."' OR `ground`='SS: ".$pathi."') AND date='".$date."'");
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