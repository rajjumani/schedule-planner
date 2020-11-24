<?php
require_once("dbcontroller.php");
$db_handle = new DBController();

$row = '40'.$_POST["row"];
$col = '40'.$_POST["col"];
	
	$row_cnt = $db_handle->numRows("SELECT * FROM `".$_POST["master"]."` WHERE `row`=".$row." AND `col`=".$col);

	/*$sewa = array();
	$sewa = explodeCheck($_POST["editval"], '@');
	
	$a = array();
	$a = explode('@', $_POST["editval"]);
	
	$sk_sr_split = array();
	$sk_sr_split = explode(')', $a[0]);
	$sk_sr = "SK: ".TRIM($sk_sr_split[1]);
	
	$centre_date = array();
	$centre_date = explode('ON', $a[1]);
	
	$centre_name = TRIM($centre_date[0]);
	
	$date_split = array();
	$date_split = explode('TH', $centre_date[1]);

	$master_split = array();
	$master_split = explode('-', $_POST["master"]);

	$monthObj   = DateTime::createFromFormat('!M', $master_split[1]);
	$month_long = $monthObj->format('m');

	$date_short = $date_split[0];
	$dateObj   = DateTime::createFromFormat('!j', TRIM($date_short));
	$date_long = $dateObj->format('d');

	$yearObj   = DateTime::createFromFormat('!y', TRIM($master_split[2]));
	$year_long = $yearObj->format('Y');
	$date_full = $date_long.".".$month_long.".".$year_long;

	$sk_query = $db_handle->runQuery("SELECT `sk_sr` FROM `".$_POST["master"]."` WHERE centre_name='".$centre_name."' AND date='".$date_full."'");

	$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
	fwrite($myfile, "INSERT INTO `".$_POST["master"]."` (`id`, `row`, `col`, `centre_name`, `date`, `day`, `sk_sr`, `pathi`, `ground`) VALUES ('', '".$_POST["row"]."', '".$_POST["col"]."', '".$centre_name."', '".$date_full."', '', '".$sk_sr."', '', '".$_POST["editval"]."')");
	fclose($myfile);*/
	
	if ($row_cnt == 0) {
		$result = $db_handle->executeUpdate("INSERT INTO `".$_POST["master"]."` (`id`, `row`, `col`, `centre_name`, `date`, `day`, `sk_sr`, `pathi`, `ground`) VALUES ('', '".$row."', '".$col."', '', '', '', '', '', '".$_POST["editval"]."')");
	}
	else {
		$result = $db_handle->executeUpdate("UPDATE `".$_POST["master"]."` set ground = '".$_POST["editval"]."', centre_name = '".$centre_name."', date = '".$date_full."', sk_sr = '".$sk_sr."' WHERE row=".$row." AND col=".$col);;
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